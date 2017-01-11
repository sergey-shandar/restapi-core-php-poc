<?php

use PHPUnit\Framework\TestCase;
use RestApiCore\Client;

class ClientTest extends TestCase
{
    public function testClient()
    {
        $client = new Client(new MockHttpClient(), 'http://petstore.swagger.io/v2');
        $client->request(
            MainSampleClass::createClassInfo(), 'path/', 'get', ['a' => 13, 'b' => [2, '17']], [], 'body');
    }

    public function testQuery()
    {
        $mock = new MockHttpClient();
        $client = new Client($mock, 'http://petstore.swagger.io/v2');

        $client->request(
            MainSampleClass::createClassInfo(), 'path/', 'get', ['a' => 'myworld'], [], 'body');
        $this->assertSame($mock->lastRequest->getUri()->getQuery(), 'a=myworld');

        $client->request(
            MainSampleClass::createClassInfo(), 'path/', 'get', ['a' => ['myworld']], [], 'body');
        $this->assertSame($mock->lastRequest->getUri()->getQuery(), 'a=myworld');

        $client->request(
            MainSampleClass::createClassInfo(), 'path/', 'get', ['a' => ['myworld', 'herworld']], [], 'body');
        $this->assertSame($mock->lastRequest->getUri()->getQuery(), 'a=myworld&a=herworld');

        $client->request(
            MainSampleClass::createClassInfo(), 'path/', 'get', ['a' => []], [], 'body');
        $this->assertSame($mock->lastRequest->getUri()->getQuery(), '');
    }
}
