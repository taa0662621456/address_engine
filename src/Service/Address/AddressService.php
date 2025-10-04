<?php
namespace App\Service\Address;

use App\Application\Address\DTO\AddressDTO;
use App\Application\Address\DTO\AddressResponseDTO;
use App\Application\Address\DTO\PagedResponseDTO;
use App\DTO\Address\AddressMapper;
use App\Entity\Address\Address;
use App\RepositoryInterface\Address\AddressRepositoryInterface;
use InvalidArgumentException;

final class AddressService
{
    private const ISO_COUNTRIES = [ 'AF','AX','AL','DZ','AS','AD','AO','AI','AQ','AG','AR','AM','AW','AU','AT','AZ',
        'BS','BH','BD','BB','BY','BE','BZ','BJ','BM','BT','BO','BQ','BA','BW','BV','BR','IO',
        'BN','BG','BF','BI','CV','KH','CM','CA','KY','CF','TD','CL','CN','CX','CC','CO','KM',
        'CG','CD','CK','CR','CI','HR','CU','CW','CY','CZ','DK','DJ','DM','DO','EC','EG','SV',
        'GQ','ER','EE','SZ','ET','FK','FO','FJ','FI','FR','GF','PF','TF','GA','GM','GE','DE',
        'GH','GI','GR','GL','GD','GP','GU','GT','GG','GN','GW','GY','HT','HM','VA','HN','HK',
        'HU','IS','IN','ID','IR','IQ','IE','IM','IL','IT','JM','JP','JE','JO','KZ','KE','KI',
        'KP','KR','KW','KG','LA','LV','LB','LS','LR','LY','LI','LT','LU','MO','MG','MW','MY',
        'MV','ML','MT','MH','MQ','MR','MU','YT','MX','FM','MD','MC','MN','ME','MS','MA','MZ',
        'MM','NA','NR','NP','NL','NC','NZ','NI','NE','NG','NU','NF','MK','MP','NO','OM','PK',
        'PW','PS','PA','PG','PY','PE','PH','PN','PL','PT','PR','QA','RE','RO','RU','RW','BL',
        'SH','KN','LC','MF','PM','VC','WS','SM','ST','SA','SN','RS','SC','SL','SG','SX','SK',
        'SI','SB','SO','ZA','GS','SS','ES','LK','SD','SR','SJ','SE','CH','SY','TW','TJ','TZ',
        'TH','TL','TG','TK','TO','TT','TN','TR','TM','TC','TV','UG','UA','AE','GB','US','UM',
        'UY','UZ','VU','VE','VN','VG','VI','WF','EH','YE','ZM','ZW'
    ];

    public function __construct(private readonly AddressRepositoryInterface $repository)
    {
    }

    // Работа через DTO
    public function createFromDTO(AddressDTO $dto): void
    {
        $entity = AddressMapper::toEntity($dto);
        $this->create($entity);
    }

    public function updateFromDTO(AddressDTO $dto): void
    {
        $entity = AddressMapper::toEntity($dto);
        $this->update($entity);
    }

    public function getDTO(int $id): ?AddressDTO
    {
        $entity = $this->get($id);
        return $entity ? AddressMapper::toDTO($entity) : null;
    }

    public function listAllDTO(): array
    {
        return array_map([AddressMapper::class, 'toDTO'], $this->listAll());
    }

    // Работа через ResponseDTO (для API)
    public function getResponseDTO(int $id): ?AddressResponseDTO
    {
        $entity = $this->get($id);
        return $entity ? AddressMapper::toResponseDTO($entity) : null;
    }

    public function listAllResponseDTO(): array
    {
        return array_map([AddressMapper::class, 'toResponseDTO'], $this->listAll());
    }

    public function paginateResponse(int $page, int $limit): PagedResponseDTO
    {
        $result = $this->repository->paginate($page, $limit);
        $items = array_map([AddressMapper::class, 'toResponseDTO'], $result['items'] ?? []);
        $total = $result['total'] ?? count($items);
        return new PagedResponseDTO($items, $total, $page, $limit);
    }

    public function searchAdvanced(array $criteria, int $page = 1, int $limit = 20): PagedResponseDTO
    {
        $result = $this->repository->searchAdvanced($criteria, $page, $limit);
        $items = array_map([AddressMapper::class, 'toResponseDTO'], $result['items'] ?? []);
        $total = $result['total'] ?? count($items);
        return new PagedResponseDTO($items, $total, $page, $limit);
    }

    // Оригинальные методы (работа напрямую с Entity)
    public function create(Address $address): void
    {
        $this->validate($address);
        if ($this->repository->existsDuplicate($address)) {
            throw new InvalidArgumentException('Duplicate address already exists');
        }
        $this->repository->save($address);
    }

    public function update(Address $address): void
    {
        $this->validate($address);
        if ($this->repository->existsDuplicate($address)) {
            throw new InvalidArgumentException('Duplicate address already exists');
        }
        $this->repository->save($address);
    }

    public function delete(Address $address): void
    {
        if ($this->repository->isInUse($address)) {
            throw new InvalidArgumentException('Cannot delete address: it is already in use');
        }
        $this->repository->remove($address);
    }

    public function get(int $id): ?Address
    {
        return $this->repository->findById($id);
    }

    public function listAll(): array
    {
        return $this->repository->findAll();
    }

    public function searchByCity(string $city): array
    {
        return $this->repository->searchByCity($city);
    }

    public function searchByCountry(string $country): array
    {
        return $this->repository->searchByCountry($country);
    }

    public function searchByZipcode(string $zipcode): array
    {
        return $this->repository->searchByZipcode($zipcode);
    }

    public function search(string $query, array $filters = []): array
    {
        return $this->repository->search($query, $filters);
    }

    public function paginate(int $page, int $limit): array
    {
        return $this->repository->paginate($page, $limit);
    }

    private function validate(Address $address): void
    {
        // validate zipcode
        if (method_exists($address, 'zipcode')) {
            $zip = $address->zipcode();
            if (method_exists($zip, '__toString')) {
                $zipStr = (string) $zip;
                if ($zipStr === '' || strlen($zipStr) < 3) {
                    throw new InvalidArgumentException('Zipcode is invalid or too short');
                }
            }
        }

        // validate city
        if (method_exists($address, 'city')) {
            $city = $address->city();
            if (method_exists($city, '__toString')) {
                $cityStr = trim((string) $city);
                if ($cityStr === '') {
                    throw new InvalidArgumentException('City cannot be empty');
                }
            }
        }

        // validate country (ISO code)
        if (method_exists($address, 'country')) {
            $country = $address->country();
            if (method_exists($country, '__toString')) {
                $countryStr = strtoupper(trim((string) $country));
                if ($countryStr === '') {
                    throw new InvalidArgumentException('Country cannot be empty');
                }
                if (!in_array($countryStr, self::ISO_COUNTRIES, true)) {
                    throw new InvalidArgumentException('Country must be valid ISO code, got: ' . $countryStr);
                }
            }
        }

        // validate street
        if (method_exists($address, 'street')) {
            $street = $address->street();
            if (method_exists($street, '__toString')) {
                $streetStr = trim((string) $street);
                if ($streetStr === '' || strlen($streetStr) < 2) {
                    throw new InvalidArgumentException('Street cannot be empty or too short');
                }
            }
        }
    }
}
