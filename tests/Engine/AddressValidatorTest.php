<?php
namespace Tests\Engine;

use PHPUnit\Framework\TestCase;
use App\Utility\AddressEngine\Repository\CountryRepository;
use App\Utility\AddressEngine\Repository\SubdivisionRepository;
use App\Utility\AddressEngine\Repository\AddressFormatRepository;
use App\Utility\AddressEngine\Validator\AddressValidator;
use App\Utility\AddressEngine\Validator\ZipcodeValidator;

final class AddressValidatorTest extends TestCase
{
    private AddressValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new AddressValidator(
            new CountryRepository(),
            new SubdivisionRepository(),
            new AddressFormatRepository(),
            new ZipcodeValidator()
        );
    }

    public function testValidAddress(): void
    {
        $data = [
            'country' => 'US',
            'subdivision' => 'TX',
            'city' => 'Houston',
            'street' => '123 Main St',
            'zipcode' => '77001'
        ];

        $this->assertTrue($this->validator->isValid($data));
    }

    public function testInvalidZipcode(): void
    {
        $data = [
            'country' => 'US',
            'subdivision' => 'TX',
            'city' => 'Houston',
            'street' => '123 Main St',
            'zipcode' => '77A01'
        ];

        $this->assertFalse($this->validator->isValid($data));
    }
}
