<?php
namespace RestApiCore;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7;
use RestApiCore\Request\Request;
use RestApiCore\Type\Type;

final class ApiClient
{
    /**
     * @var ClientInterface $httpClient
     */
    private $httpClient;

    /**
     * @var string $baseUrl
     */
    private $baseUrl;

    const APPLICATION_JSON = 'application/json';

    public function __construct(ClientInterface $httpClient, $baseUrl)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param Type $resultTypeInfo
     * @param Request $apiRequest
     *
     * @return mixed
     */
    public function request(Type $resultTypeInfo, Request $apiRequest)
    {
        $headers = array_merge($apiRequest->getHeaders(), ['Accept' => self::APPLICATION_JSON]);

        $request = new Psr7\Request(
            $apiRequest->method,
            $apiRequest->getUrl($this->baseUrl),
            $headers,
            null
        );

        $query = ['query' => $apiRequest->getQuery()];
        $options = array_merge($query, $apiRequest->getOptions());
        $response = $this->httpClient->send($request, $options);

        $responseBody = $response->getBody();
        $contents = $responseBody->getContents();
        $rawResult = json_decode($contents, false, 512, JSON_BIGINT_AS_STRING);

        return $resultTypeInfo->deserialize($rawResult);
    }
}