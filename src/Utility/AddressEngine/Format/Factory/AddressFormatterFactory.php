<?php
declare(strict_types=1);

namespace App\Utility\AddressEngine\Format\Factory;

use App\Utility\AddressEngine\Format\Contract\AddressFormatterInterface;
use InvalidArgumentException;
use ReflectionClass;
use RuntimeException;

final class AddressFormatterFactory
{
    /** @var array */
    private array $map = [];

    /**
     * @param iterable<AddressFormatterInterface> $strategies
     * @throws \ReflectionException
     */
    public function __construct(iterable $strategies)
    {
        foreach ($strategies as $strategy) {
            $short = (new ReflectionClass($strategy))->getShortName();
            $this->map[$short] = $strategy;
        }
    }

    public function forCountry(string $countryCode): AddressFormatterInterface
    {
        return match (strtoupper($countryCode)) {
            'UA' => $this->map['UaFormatter'] ?? throw new RuntimeException('UA formatter not registered'),
            'CA' => $this->map['CaFormatter'] ?? throw new RuntimeException('CA formatter not registered'),
            'AU' => $this->map['AuFormatter'] ?? throw new RuntimeException('AU formatter not registered'),
            default => $this->map['CaFormatter']
                ?? throw new InvalidArgumentException('No formatter for ' . $countryCode),
        };
    }
}
