<?php
namespace Tests\Engine;

use PHPUnit\Framework\TestCase;
use App\Utility\AddressEngine\Repository\CountryRepository;

final class CountryRepositoryTest extends TestCase
{
    public function testExists(): void
    {
        $repo = new CountryRepository();
        $this->assertTrue($repo->exists('US'));
        $this->assertFalse($repo->exists('XX'));
    }
}
