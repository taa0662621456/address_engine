<?php
namespace App\DTO\Address;



use App\Application\Address\DTO\AddressDTO;
use App\Application\Address\DTO\AddressResponseDTO;
use App\Entity\Address\Address;

final class AddressMapper
{
    public static function toEntity(AddressDTO $dto): Address
    {
        return new Address(
            new City($dto->city),
            new Country($dto->country),
            new Street($dto->street),
            new Zipcode($dto->zipcode)
        );
    }

    public static function toDTO(Address $address): AddressDTO
    {
        return new AddressDTO(
            (string)$address->city(),
            (string)$address->country(),
            (string)$address->street(),
            (string)$address->zipcode()
        );
    }

    public static function toResponseDTO(Address $address): AddressResponseDTO
    {
        return new AddressResponseDTO(
            method_exists($address, 'getId') ? $address->getId() : 0,
            (string)$address->city(),
            (string)$address->country(),
            (string)$address->street(),
            (string)$address->zipcode(),
            method_exists($address, 'getCreatedAt') ? $address->getCreatedAt() : null,
            method_exists($address, 'getUpdatedAt') ? $address->getUpdatedAt() : null
        );
    }
}
