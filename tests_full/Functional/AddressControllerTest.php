<?php
namespace Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AddressControllerTest extends WebTestCase
{
    public function testCreateAddressEndpoint(): void
    {
        $client = AddressControllerTest::createClient();
        $client->request('POST', '/address', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'city' => 'Kyiv',
            'country' => 'UA',
            'street' => 'Khreshchatyk',
            'zipcode' => '01001'
        ]));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    public function testGetAddressEndpoint(): void
    {
        $client = AddressControllerTest::createClient();
        $client->request('GET', '/address/1');
        $this->assertResponseStatusCodeSame(200);
    }
}
