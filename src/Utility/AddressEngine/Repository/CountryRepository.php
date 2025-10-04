<?php
namespace App\Utility\AddressEngine\Repository;

final class CountryRepository
{
    private array $countries;

    public function __construct(string $resourcePath = __DIR__ . '/resources/countries.json')
    {
        $this->countries = json_decode(file_get_contents($resourcePath), true) ?? [];
    }

    public function getAll(): array
    {
        return $this->countries;
    }

    public function get(string $alpha2): ?array
    {
        $alpha2 = strtoupper($alpha2);
        return $this->countries[$alpha2] ?? null;
    }

    public function exists(string $alpha2): bool
    {
        return isset($this->countries[strtoupper($alpha2)]);
    }

    public function getName(string $alpha2): ?string
    {
        $country = $this->get($alpha2);
        return $country['name'] ?? null;
    }
}
