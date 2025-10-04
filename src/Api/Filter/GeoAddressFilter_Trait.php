<?php
declare(strict_types=1);

namespace App\Api\Filter;

use App\Factory\AddressFactory;
use App\Entity\Address\Address;

/**
 * Drop-in замена/расширение.
 * Вызов: $address = $this->applyGeoFilter($payload['address'] ?? []);
 */
trait GeoAddressFilterTrait
{
    private AddressFactory $addressFactory;

    public function setAddressFactory(AddressFactory $factory): void
    {
        $this->addressFactory = $factory;
    }

    /** @param array<string,mixed> $input */
    public function applyGeoFilter(array $input): Address
    {
        return $this->addressFactory->fromArray($input);
    }
}
