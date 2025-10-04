<?php
namespace App\Api\Model;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'DomainCheck',
    operations: [
        new Get(
            uriTemplate: '/domain/check',
            provider: \App\Api\Provider\DomainCheckProvider::class,
            paginationEnabled: false,
            normalizationContext: ['groups' => ['domain:read']],
            outputFormats: ['json' => ['application/json']],
            openapiContext: [
                'summary' => 'Проверка доступности домена',
                'parameters' => [[
                    'name' => 'slug',
                    'in' => 'query',
                    'required' => true,
                    'schema' => ['type' => 'string'],
                    'description' => 'Базовый slug (без зоны), напр. "acme"',
                ]],
            ],
        ),
    ]
)]
final class DomainCheckResult
{
    #[Groups('domain:read')] public string $input;
    #[Groups('domain:read')] public string $slug;
    #[Groups('domain:read')] public string $domain;
    #[Groups('domain:read')] public bool   $available;
    #[Groups('domain:read')] public string $strategy;
    #[Groups('domain:read')] public bool   $definitive = false;
    /** @var list<string> */
    #[Groups('domain:read')] public array  $suggestions = [];
}
