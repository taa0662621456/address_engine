<?php
namespace App\RepositoryInterface\Address;

use App\Entity\Address\Address;

interface AddressRepositoryInterface
{
    public function findById(int $id): ?Address;
    public function findAll(): array;
    public function save(Address $address): void;
    public function remove(Address $address): void;
    public function existsDuplicate(Address $address): bool;
    public function isInUse(Address $address): bool;

    public function searchByCity(string $city): array;
    public function searchByCountry(string $country): array;
    public function searchByZipcode(string $zipcode): array;
    public function search(string $query, array $filters = []): array;
    public function paginate(int $page, int $limit): array;
    public function searchAdvanced(array $criteria, int $page = 1, int $limit = 20): array;
}
