<?php
namespace RestApiCore;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7;
use RestApiCore\Json\Common;
use RestApiCore\Reflection\Types\TypeInfo;
use RestApiCore\Requests\JsonRequest;
use RestApiCore\Requests\Request;

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
     * @param TypeInfo $resultTypeInfo
     * @param Request $apiRequest
     *
     * @return mixed
     */
    public function request(TypeInfo $resultTypeInfo, Request $apiRequest)
    {
        $headers = $apiRequest->getHeaders();

        $headers['Accept'] = JsonRequest::CONTENT_TYPE;

        if ($this->bearerToken !== null) {
            $headers['Authorization'] = 'Bearer ' . $this->bearerToken;
        }

        $request = new Psr7\Request(
            $apiRequest->method,
            $apiRequest->getUrl($this->baseUrl),
            $headers,
            $apiRequest->getBody()
        );

        $options = $apiRequest->getOptions();
        $options['query'] = $apiRequest->getQuery();

        $response = $this->httpClient->send($request, $options);

        $responseBody = $response->getBody();
        $contents = $responseBody->getContents();
        $rawResult = Common::decode($contents);

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
