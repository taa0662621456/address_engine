<?php
namespace App\Utility\AddressEngine\Repository;

final class SubdivisionRepository
{
    private array $subdivisions;

    public function __construct(string $resourcePath = __DIR__ . '/resources/subdivisions.json')
    {
        $this->subdivisions = json_decode(file_get_contents($resourcePath), true) ?? [];
    }

    public function getAll(string $country): array
    {
        $country = strtoupper($country);
        return $this->subdivisions[$country] ?? [];
    }

    public function get(string $country, string $code): ?array
    {
        $country = strtoupper($country);
        return $this->subdivisions[$country][$code] ?? null;
    }

    public function exists(string $country, string $code): bool
    {
        $country = strtoupper($country);
        return isset($this->subdivisions[$country][$code]);
    }
}
