<?php
namespace App\Utility\AddressEngine\Repository;

final class AddressFormatRepository
{
    private array $formats;

    public function __construct(string $resourcePath = __DIR__ . '/resources/address_formats.json')
    {
        $this->formats = json_decode(file_get_contents($resourcePath), true) ?? [];
    }

    public function get(string $country): ?string
    {
        $country = strtoupper($country);
        return $this->formats[$country] ?? null;
    }

    public function format(string $country, array $data): string
    {
        $pattern = $this->get($country) ?? "{street}, {city}, {zipcode}, {country}";
        foreach ($data as $key => $value) {
            $pattern = str_replace('{' . $key . '}', $value, $pattern);
        }
        return $pattern;
    }
}
