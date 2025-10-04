<?php
namespace App\Application\Address\DTO;

final class AddressDTO
{
    public function __construct(
        public string $city,
        public string $country,
        public string $street,
        public string $zipcode
    ) {}
}
