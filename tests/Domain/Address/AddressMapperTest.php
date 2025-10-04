<?php
namespace Tests\Domain\Address;

use PHPUnit\Framework\TestCase;
use App\Application\Address\DTO\AddressDTO;
use App\Application\Address\DTO\AddressMapper;

final class AddressMapperTest extends TestCase
{
    public function testDtoToEntityAndBack(): void
    {
        $dto = new AddressDTO("Kyiv", "UA", "Main St", "01001");
        $entity = AddressMapper::toEntity($dto);
        $dto2 = AddressMapper::toDTO($entity);

        $this->assertEquals($dto->city, $dto2->city);
        $this->assertEquals($dto->country, $dto2->country);
    }
}
