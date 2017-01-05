<?php
namespace RestApiCore;


class Client
{
    /**
     * @var HttpClient $httpClient
     */
    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param TypeInfo $result
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
        TypeInfo $result,
        $path,
        $method,
        array $pathParameters,
        array $queryParameters,
        array $headerParameters,
        $body)
    {
        return $result->deserialize($this->httpClient->request());
    }
}