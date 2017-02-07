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
        $apiRequest->formDataParameters = [ 'file' => 'something' ];
        $client = new ApiClient(new Client(), 'http://petstore.swagger.io/');
        $client->request(PrimitiveType::create(), $apiRequest);
    }

    public function testJsonApi()
    {
        $apiRequest = new JsonRequest();
        $apiRequest->method = 'POST';
        $apiRequest->path = 'v2/pet';
        $apiRequest->contentType = 'application/json';
        $apiRequest->body = Pet::create()->id(525);
        $client = new ApiClient(new Client(), 'http://petstore.swagger.io/');
        $client->request(PrimitiveType::create(), $apiRequest);
    }

    public function testFormApi()
    {
        $client = new ApiClient(new Client(), 'http://petstore.swagger.io/v2');

        {
            $apiRequest = new JsonRequest();
            $apiRequest->method = 'POST';
            $apiRequest->path = '/pet';
            $apiRequest->contentType = 'application/json';
            $apiRequest->body = Pet::create()->id(525)->status('available');
            $client->request(PrimitiveType::create(), $apiRequest);
        }

        {
            /*
            $apiRequest = new \RestApiCore\Request\JsonRequest();
            $apiRequest->path = '/pet/525';
            $apiRequest->method = 'Post';
            $apiRequest->queryParameters = [];
            $apiRequest->headerParameters = [];
            $apiRequest->contentType = 'application/x-www-form-urlencoded';
            $apiRequest->body = null;
            $client->request(\RestApiCore\Type\PrimitiveType::create(), $apiRequest);
            */
            $apiRequest = new \RestApiCore\Request\FormRequest();
            $apiRequest->path = '/pet/525';
            $apiRequest->method = 'Post';
            $apiRequest->queryParameters = [];
            $apiRequest->headerParameters = [];
            $apiRequest->formParams = [ 'status' => 'sold' ];
            $client->request(\RestApiCore\Type\PrimitiveType::create(), $apiRequest);
        }

        {
            $apiRequest = new \RestApiCore\Request\JsonRequest();
            $apiRequest->path = '/pet/525';
            $apiRequest->method = 'Get';
            $apiRequest->queryParameters = [];
            $apiRequest->headerParameters = [];
            $apiRequest->contentType = 'application/json;';
            $apiRequest->body = null;
            $response = $client->request(Pet::createClassInfo(), $apiRequest);
            var_dump($response);
        }
    }
}

