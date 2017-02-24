<?php
namespace RestApiCore;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7;
use RestApiCore\Requests\Request;
use RestApiCore\Types\Type;

final class ApiClient
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $bearerToken;

    const APPLICATION_JSON = 'application/json';

    /**
     * ApiClient constructor.
     *
     * @param ClientInterface $httpClient
     * @param string $baseUrl
     * @param string $bearerToken
     */
    public function __construct(ClientInterface $httpClient, $baseUrl, $bearerToken = null)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = $baseUrl;
        $this->bearerToken = $bearerToken;
    }

    /**
     * @param Type $resultTypeInfo
     * @param Request $apiRequest
     *
     * @return mixed
     */
    public function request(Type $resultTypeInfo, Request $apiRequest)
    {
        $headers = [ 'Accept' => self::APPLICATION_JSON ];

        if ($this->bearerToken !== null) {
            $headers['Authorization'] = 'Bearer ' . $this->bearerToken;
        }

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
        $rawResult = Json::decode($contents);

        return $resultTypeInfo->deserialize($rawResult);
    }

    /**
     * @param string $baseUrl
     * @param ApiClient|null $apiClient
     *
     * @return ApiClient
     */
    public static function create($baseUrl, self $apiClient = null)
    {
        return $apiClient === null ? new self(new Client(), $baseUrl) : $apiClient;
    }
}
