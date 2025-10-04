<?php
namespace App\Application\Address\DTO;

use DateTimeImmutable;

final class AddressResponseDTO
{
    public function __construct(
        public int                $id,
        public string             $city,
        public string             $country,
        public string             $street,
        public string             $zipcode,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null
    ) {}
}
