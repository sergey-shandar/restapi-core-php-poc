<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use RestApiCore\ApiClient;
use RestApiCore\Request\JsonRequest;
use RestApiCore\Request\MultiPartRequest;
use RestApiCore\Type\PrimitiveType;

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
    }

    public function testMultiPartApi()
    {
        $apiRequest = new MultiPartRequest();
        $apiRequest->method = 'POST';
        $apiRequest->path = 'v2/pet/425/uploadImage';
        $apiRequest->parameters = [ 'file' => 'something' ];
        $client = new ApiClient(new Client(), 'http://petstore.swagger.io/');
        $client->request(PrimitiveType::create(), $apiRequest);
    }

    public function testJsonApi()
    {
        $apiRequest = new JsonRequest(Pet::createClassInfo(), Pet::create()->id(525));
        $apiRequest->method = 'POST';
        $apiRequest->path = 'v2/pet';
        $client = new ApiClient(new Client(), 'http://petstore.swagger.io/');
        $client->request(PrimitiveType::create(), $apiRequest);
    }

    public function testFormApi()
    {
        $client = new ApiClient(new Client(), 'http://petstore.swagger.io/v2', 'TOKEN');

        {
            $apiRequest = new JsonRequest(Pet::createClassInfo(), Pet::create()->id(525)->status('available'));
            $apiRequest->method = 'POST';
            $apiRequest->path = '/pet';
            $apiRequest->contentType = 'application/json';
            $client->request(PrimitiveType::create(), $apiRequest);
        }

        {
            $apiRequest = new \RestApiCore\Request\FormRequest();
            $apiRequest->path = '/pet/525';
            $apiRequest->method = 'Post';
            $apiRequest->queryParameters = [];
            $apiRequest->headerParameters = [];
            $apiRequest->parameters = [ 'status' => 'sold' ];
            $client->request(\RestApiCore\Type\PrimitiveType::create(), $apiRequest);
        }

        {
            $apiRequest = new \RestApiCore\Request\JsonRequest(PrimitiveType::create(), null);
            $apiRequest->path = '/pet/525';
            $apiRequest->method = 'Get';
            $apiRequest->queryParameters = [];
            $apiRequest->headerParameters = [];
            $response = $client->request(Pet::createClassInfo(), $apiRequest);
        }
    }
}

