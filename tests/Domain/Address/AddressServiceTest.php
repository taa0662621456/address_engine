<?php
namespace Tests\Domain\Address;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use App\Application\Address\AddressService;
use App\Application\Address\DTO\AddressDTO;
use App\Application\Address\DTO\AddressMapper;

final class AddressServiceTest extends TestCase
{
    private AddressService $service;

    protected function setUp(): void
    {
        $this->service = new AddressService(new AddressRepositoryMock());
    }

    public function testCreateValidAddress(): void
    {
        $dto = new AddressDTO("Kyiv", "UA", "Main St", "01001");
        $this->service->createFromDTO($dto);
        $this->assertNotNull($this->service->getDTO(1));
    }

    public function testDuplicateThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $dto = new AddressDTO("Kyiv", "UA", "Main St", "01001");
        $this->service->createFromDTO($dto);
        $this->service->createFromDTO($dto);
    }
}
