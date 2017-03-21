<?php
use PHPUnit\Framework\TestCase;
use RestApiCore\ApiClient;
use RestApiCore\Requests\JsonRequest;
use RestApiCore\Reflection\Types\NullInfo;

class ClientTest extends TestCase
{
    public function testClient()
    {
        $client = new ApiClient(new MockHttpClient(), 'http://petstore.swagger.io/v2');

        $request = new JsonRequest(NullInfo::create(), 'body');
        $request->path = 'path/';
        $request->query = ['a' => 13, 'b' => [2, '17']];

        $client->request(MainSampleClass::createClassType(), $request);
    }

    public function testQuery()
    {
        $mock = new MockHttpClient();
        $client = new ApiClient($mock, 'http://petstore.swagger.io/v2');

        {
            $request = new JsonRequest(NullInfo::create(), '');
            $request->queryParameters = ['a' => 'myworld'];
            $client->request(MainSampleClass::createClassType(), $request);
            // $this->assertSame($mock->lastRequest->getUri()->getQuery(), 'a=myworld');
        }

        {
            $request = new JsonRequest(NullInfo::create(), '');
            $request->queryParameters = ['a' => ['myworld']];
            $client->request(
                MainSampleClass::createClassType(), $request);
            // $this->assertSame($mock->lastRequest->getUri()->getQuery(), 'a=myworld');
        }

        {
            $request = new JsonRequest(NullInfo::create(), '');
            $request->queryParameters = ['a' => ['myworld', 'herworld']];
            $client->request(MainSampleClass::createClassType(), $request);
            // $this->assertSame($mock->lastRequest->getUri()->getQuery(), 'a=myworld&a=herworld');
        }

        {
            $request = new JsonRequest(NullInfo::create(), '');
            $request->queryParameters = ['a' => []];
            $client->request(MainSampleClass::createClassType(), $request);
            // $this->assertSame($mock->lastRequest->getUri()->getQuery(), '');
        }
    }

    public function testClientCreate()
    {
        ApiClient::create("http://example.com/");
    }
}
