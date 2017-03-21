<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use RestApiCore\ApiClient;
use RestApiCore\Requests\JsonRequest;
use RestApiCore\Requests\MultiPartRequest;
use RestApiCore\Reflection\Types\NullInfo;

class MultiPartTest extends TestCase
{
    public function testGuzzle()
    {
        $request = new Request(
            'POST',
            'http://petstore.swagger.io/v2/pet/425/uploadImage',
            [
                'Accept' => JsonRequest::CONTENT_TYPE,
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
        $client->request(NullInfo::create(), $apiRequest);
    }

    public function testJsonApi()
    {
        $apiRequest = new JsonRequest();
        $apiRequest->method = 'POST';
        $apiRequest->path = 'v2/pet';
        $apiRequest->type = Pet::createClassInfo();
        $apiRequest->body = Pet::create()->id(525);
        $client = new ApiClient(new Client(), 'http://petstore.swagger.io/');
        $client->request(NullInfo::create(), $apiRequest);
    }

    public function testFormApi()
    {
        $client = new ApiClient(new Client(), 'http://petstore.swagger.io/v2', 'TOKEN');

        {
            $apiRequest = new JsonRequest();
            $apiRequest->method = 'POST';
            $apiRequest->path = '/pet';
            $apiRequest->type = Pet::createClassInfo();
            $apiRequest->body = Pet::create()->id(525)->status('available');
            $client->request(NullInfo::create(), $apiRequest);
        }

        {
            $apiRequest = new \RestApiCore\Requests\FormRequest();
            $apiRequest->path = '/pet/525';
            $apiRequest->method = 'Post';
            $apiRequest->queryParameters = [];
            $apiRequest->parameters = [ 'status' => 'sold' ];
            $client->request(\RestApiCore\Reflection\Types\NullInfo::create(), $apiRequest);
        }

        {
            $apiRequest = new \RestApiCore\Requests\JsonRequest(NullInfo::create(), null);
            $apiRequest->path = '/pet/525';
            $apiRequest->method = 'Get';
            $apiRequest->queryParameters = [];
            $response = $client->request(Pet::createClassInfo(), $apiRequest);
        }
    }
}
