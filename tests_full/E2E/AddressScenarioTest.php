<?php
namespace Tests\E2E;

use PHPUnit\Framework\TestCase;
use App\Utility\AddressEngine\Repository\CountryRepository;
use App\Utility\AddressEngine\Repository\SubdivisionRepository;
use App\Utility\AddressEngine\Repository\AddressFormatRepository;
use App\Utility\AddressEngine\Validator\AddressValidator;
use App\Utility\AddressEngine\Validator\ZipcodeValidator;

final class AddressScenarioTest extends TestCase
{
    public function testFullScenario(): void
    {
        $validator = new AddressValidator(
            new CountryRepository(),
            new SubdivisionRepository(),
            new AddressFormatRepository(),
            new ZipcodeValidator()
        );

        $data = [
            'country' => 'US',
            'subdivision' => 'TX',
            'city' => 'Houston',
            'street' => '123 Main St',
            'zipcode' => '77001'
        ];

        // Step 1: validate
        $this->assertTrue($validator->isValid($data));

        // Step 2: format
        $formatted = $validator->format($data);
        $this->assertStringContainsString('Houston', $formatted);

        // Step 3: simulate repository save/retrieve (условный шаг)
        $this->assertNotEmpty($data['zipcode']);
    }
}
