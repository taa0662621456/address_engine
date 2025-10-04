<?php
namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use App\Utility\AddressEngine\Validator\AddressValidator;
use App\Utility\AddressEngine\Validator\ZipcodeValidator;
use App\Utility\AddressEngine\Repository\CountryRepository;
use App\Utility\AddressEngine\Repository\SubdivisionRepository;
use App\Utility\AddressEngine\Repository\AddressFormatRepository;
use App\Utility\AddressEngine\Format\AddressFormatter;

final class AddressValidatorFormatterIntegrationTest extends TestCase
{
    private AddressValidator $validator;
    private AddressFormatter $formatter;

    protected function setUp(): void
    {
        $this->validator = new AddressValidator(
            new CountryRepository(),
            new SubdivisionRepository(),
            new AddressFormatRepository(),
            new ZipcodeValidator()
        );
        $this->formatter = new AddressFormatter();
    }

    public function testValidAndFormatAddressUa(): void
    {
        $data = [
            'country' => 'UA',
            'subdivision' => '30',
            'city' => 'Київ',
            'street' => 'Хрещатик 1',
            'zipcode' => '01001'
        ];

        $this->assertTrue($this->validator->isValid($data), "Address should be valid");
        $formatted = $this->formatter->format('UA', $data);
        $this->assertStringContainsString('Київ', $formatted);
        $this->assertStringContainsString('01001', $formatted);
    }

    public function testInvalidZipcodeFails(): void
    {
        $data = [
            'country' => 'UA',
            'subdivision' => '30',
            'city' => 'Київ',
            'street' => 'Хрещатик 1',
            'zipcode' => '01A01'
        ];

        $this->assertFalse($this->validator->isValid($data), "Address should fail due to invalid zipcode");
    }
}
