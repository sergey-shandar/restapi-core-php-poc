<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use RestApiCore\ApiClient;
use RestApiCore\ApiJsonRequest;
use RestApiCore\ApiMultiPartRequest;
use RestApiCore\PrimitiveTypeInfo;

class MultiPartTest extends TestCase
{
    public function testGuzzle()
    {
        $request = new Request(
            'POST',
            'http://petstore.swagger.io/v2/pet/425/uploadImage',
            [
                'Accept' => ApiClient::APPLICATION_JSON,
            ],
            null);
        $client = new Client();
        $options = [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => 'something', // fopen('th.jpg', 'r'),
                ],
            ],
        ];
        $response = $client->send($request, $options);
        var_dump($response->getBody()->getContents());
    }

    public function testApi()
    {
        $apiRequest = new ApiMultiPartRequest();
        $apiRequest->method = 'POST';
        $apiRequest->path = 'v2/pet/425/uploadImage';
        $apiRequest->formDataParameters = [ 'file' => 'something' ];
        $client = new ApiClient(new Client(), 'http://petstore.swagger.io/');
        $client->request(PrimitiveTypeInfo::create(), $apiRequest);
    }

    public function testJsojApi()
    {
        $apiRequest = new ApiJsonRequest();
        $apiRequest->method = 'POST';
        $apiRequest->path = 'v2/pet';
        $apiRequest->contentType = 'application/json';
        $apiRequest->body = new Pet();
        $client = new ApiClient(new Client(), 'http://petstore.swagger.io/');
        $client->request(PrimitiveTypeInfo::create(), $apiRequest);
    }
}

