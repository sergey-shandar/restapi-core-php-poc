<?php

use PHPUnit\Framework\TestCase;
use RestApiCore\Client;

class ClientTest extends TestCase
{
    public function testClient()
    {
        $client = new Client(new MockHttpClient());
        $client->request(SampleClass::createClassInfo(), "path/", "query", [], [], [], "body");
    }
}
