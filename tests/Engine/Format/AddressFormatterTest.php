<?php
namespace Tests\Engine\Format;

use PHPUnit\Framework\TestCase;
use App\Utility\AddressEngine\Format\AddressFormatter;

final class AddressFormatterTest extends TestCase
{
    public function testFormatUa(): void
    {
        $formatter = new AddressFormatter();
        $formatted = $formatter->format('UA', [
            'street' => 'Хрещатик 1',
            'city' => 'Київ',
            'zipcode' => '01001',
            'country' => 'UA'
        ]);
        $this->assertStringContainsString('Київ', $formatted);
        $this->assertStringContainsString('01001', $formatted);
    }

    public function testFormatCa(): void
    {
        $formatter = new AddressFormatter();
        $formatted = $formatter->format('CA', [
            'street' => '123 Queen St',
            'city' => 'Toronto',
            'zipcode' => 'M5H 2N2',
            'country' => 'CA'
        ]);
        $this->assertStringContainsString('Toronto', $formatted);
        $this->assertStringContainsString('M5H 2N2', $formatted);
    }
}
