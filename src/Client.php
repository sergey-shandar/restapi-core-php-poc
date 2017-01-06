<?php
namespace RestApiCore;


use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;

class Client
{
    /**
     * @var ClientInterface $httpClient
     */
    private $httpClient;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param TypeInfo $resultTypeInfo
     * @param string $path
     * @param string $method
     * @param array $pathParameters
     * @param array $queryParameters
     * @param array $headerParameters
     * @param $body
     *
     * @return mixed
     */
    public function request(
        TypeInfo $resultTypeInfo,
        $path,
        $method,
        array $pathParameters,
        array $queryParameters,
        array $headerParameters,
        $body)
    {
        $uri = $path;
        $response = $this->httpClient->send(new Request($method, $uri));
        return $resultTypeInfo->deserialize($response->getBody());
    }
}