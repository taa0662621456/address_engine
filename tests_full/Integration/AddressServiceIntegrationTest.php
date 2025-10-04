<?php
namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use App\Application\Address\AddressService;
use App\Application\Address\DTO\AddressDTO;
use App\Application\Address\DTO\AddressMapper;

final class AddressServiceIntegrationTest extends TestCase
{
    private AddressService $service;

    protected function setUp(): void
    {
        // Здесь можно инициализировать in-memory репозиторий или mock DB
        $this->service = new AddressService(new AddressRepositoryMock());
    }

    public function testCreateAndRetrieve(): void
    {
        $dto = new AddressDTO("Berlin", "DE", "Alexanderplatz", "10178");
        $this->service->createFromDTO($dto);
        $result = $this->service->getDTO(1);
        $this->assertEquals("Berlin", $result->city);
    }
}
