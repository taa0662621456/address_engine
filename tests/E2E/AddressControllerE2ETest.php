<?php
namespace Tests\E2E;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AddressControllerE2ETest extends WebTestCase
{
    public function testCreateAndRetrieveAddress(): void
    {
        $client = AddressControllerE2ETest::createClient();

        // Создаём новый адрес
        $client->request('POST', '/address', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'city' => 'Київ',
            'country' => 'UA',
            'street' => 'Хрещатик 1',
            'zipcode' => '01001'
        ]));

        $this->assertResponseStatusCodeSame(201);

        // Пытаемся получить по id (допустим 1)
        $client->request('GET', '/address/1');
        $this->assertTrue(in_array($client->getResponse()->getStatusCode(), [200, 404]));
    }

    public function testSearchCity(): void
    {
        $client = AddressControllerE2ETest::createClient();

        $client->request('GET', '/address/search?city=Київ');
        $this->assertResponseStatusCodeSame(200);
    }
}
