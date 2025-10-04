<?php
namespace Tests\Engine\Format\Factory;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use App\Utility\AddressEngine\Format\Factory\AddressFormatterFactory;
use App\Utility\AddressEngine\Format\Contract\AddressFormatterInterface;

final class AddressFormatterFactoryTest extends TestCase
{
    public function testCreateUaFormatter(): void
    {
        $factory = new AddressFormatterFactory();
        $formatter = $factory->create('UA');
        $this->assertInstanceOf(AddressFormatterInterface::class, $formatter);
    }

    public function testCreateCaFormatter(): void
    {
        $factory = new AddressFormatterFactory();
        $formatter = $factory->create('CA');
        $this->assertInstanceOf(AddressFormatterInterface::class, $formatter);
    }

    public function testCreateAuFormatter(): void
    {
        $factory = new AddressFormatterFactory();
        $formatter = $factory->create('AU');
        $this->assertInstanceOf(AddressFormatterInterface::class, $formatter);
    }

    public function testUnknownCountryThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $factory = new AddressFormatterFactory();
        $factory->create('XX');
    }
}
