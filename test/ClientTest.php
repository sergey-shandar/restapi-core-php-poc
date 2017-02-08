<?php

use PHPUnit\Framework\TestCase;
use RestApiCore\ApiClient;
use RestApiCore\Request\JsonRequest;

class ClientTest extends TestCase
{
    public function testClient()
    {
        $client = new ApiClient(new MockHttpClient(), 'http://petstore.swagger.io/v2');

        $request = new JsonRequest();
        $request->path = 'path/';
        $request->query = ['a' => 13, 'b' => [2, '17']];
        $request->body = 'body';

        $client->request(MainSampleClass::createClassInfo(), $request);
    }

    public function testQuery()
    {
        $mock = new MockHttpClient();
        $client = new ApiClient($mock, 'http://petstore.swagger.io/v2');

        {
            $request = new JsonRequest();
            $request->queryParameters = ['a' => 'myworld'];
            $client->request(MainSampleClass::createClassInfo(), $request);
            // $this->assertSame($mock->lastRequest->getUri()->getQuery(), 'a=myworld');
        }

        {
            $request = new JsonRequest();
            $request->queryParameters = ['a' => ['myworld']];
            $client->request(
                MainSampleClass::createClassInfo(), $request);
            // $this->assertSame($mock->lastRequest->getUri()->getQuery(), 'a=myworld');
        }

        {
            $request = new JsonRequest();
            $request->queryParameters = ['a' => ['myworld', 'herworld']];
            $client->request(MainSampleClass::createClassInfo(), $request);
            // $this->assertSame($mock->lastRequest->getUri()->getQuery(), 'a=myworld&a=herworld');
        }

        {
            $request = new JsonRequest();
            $request->queryParameters = ['a' => []];
            $client->request(MainSampleClass::createClassInfo(), $request);
            // $this->assertSame($mock->lastRequest->getUri()->getQuery(), '');
        }
    }

    public function testClientCreate()
    {
        ApiClient::create("http://example.com/");
    }
}
