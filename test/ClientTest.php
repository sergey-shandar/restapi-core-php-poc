<?php

use PHPUnit\Framework\TestCase;
use RestApiCore\Client;

class ClientTest extends TestCase
{
    public function testClient()
    {
        $client = new Client(new MockHttpClient(), 'http://petstore.swagger.io/v2');
        $client->request(
            MainSampleClass::createClassInfo(), 'path/', 'query', ['a' => 13, 'b' => [2, '17']], [], 'body');
    }
}
