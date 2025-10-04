<?php
namespace App\Api\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Api\Model\DomainCheckResult;
use App\Service\Domain\DomainAvailabilityService;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\RateLimiter\RateLimiterFactory;

final class DomainCheckProvider implements ProviderInterface
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly DomainAvailabilityService $domains,
        private readonly RateLimiterFactory $domainCheckLimiter,
        private readonly RateLimiterFactory $domainCheckGlobal,
        private readonly string $baseZone = 'smartresponsor.com',
        private readonly string $strategy = 'hybrid',
        private readonly int $suggestLimit = 5,
        private readonly int $suggestMaxChecks = 40,
        private readonly bool $enabled = true,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): DomainCheckResult
    {
        if (!$this->enabled) {
            throw new ServiceUnavailableHttpException(null, 'domain_check_disabled');
        }

        $req = $this->requestStack->getCurrentRequest();

        $ipGuard = $this->domainCheckLimiter->create($req?->getClientIp() ?? 'anon');
        if (!$ipGuard->consume(1)->isAccepted()) {
            throw new TooManyRequestsHttpException(message: 'too_many_requests');
        }
        $globalGuard = $this->domainCheckGlobal->create('global');
        if (!$globalGuard->consume(1)->isAccepted()) {
            throw new TooManyRequestsHttpException(message: 'too_many_requests');
        }

        $input = trim((string)($req?->query->get('slug') ?? ''));
        if ($input === '') {
            throw new BadRequestHttpException('slug_required');
        }

        $slug = preg_replace('/[^a-z0-9-]+/i', '-', strtolower($input)) ?? '';
        $slug = trim($slug, '-');
        if ($slug === '') {
            throw new BadRequestHttpException('slug_invalid');
        }

        $domain    = $this->baseZone ? sprintf('%s.%s', $slug, $this->baseZone) : $slug;
        $available = $this->domains->isAvailable($domain);

        $dto = new DomainCheckResult();
        $dto->input       = $input;
        $dto->slug        = $slug;
        $dto->domain      = $domain;
        $dto->available   = $available;
        $dto->strategy    = $this->strategy;
        $dto->definitive  = $this->isDefinitive();
        $dto->suggestions = $available ? [] : $this->suggest($slug, $this->suggestLimit, $this->suggestMaxChecks);

        return $dto;
    }

    private function isDefinitive(): bool
    {
        // Простая эвристика: API/WHOIS считаем более определёнными, DNS — эвристика.
        return in_array(strtolower($this->strategy), ['api', 'whois'], true);
    }

    /** @return list<string> */
    private function suggest(string $base, int $limit, int $maxChecks): array
    {
        $out = [];
        for ($i = 1, $checks = 0; $i < 100 && \count($out) < $limit && $checks < $maxChecks; $i++, $checks++) {
            $cand = $base.'-'.$i;
            $dom  = $this->baseZone ? ($cand.'.'.$this->baseZone) : $cand;
            if ($this->domains->isAvailable($dom)) {
                $out[] = $cand;
            }
        }
        return $out;
    }
}
