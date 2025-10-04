<?php
namespace Tests\Engine;

use PHPUnit\Framework\TestCase;
use App\Utility\AddressEngine\Validator\ZipcodeValidator;

final class ZipcodeValidatorTest extends TestCase
{
    public function testUsZipcode(): void
    {
        $validator = new ZipcodeValidator();
        $this->assertTrue($validator->validate('US', '77001'));
        $this->assertFalse($validator->validate('US', '77A01'));
    }

    public function testGbPostcode(): void
    {
        $validator = new ZipcodeValidator();
        $this->assertTrue($validator->validate('GB', 'SW1A 1AA'));
    }
}
