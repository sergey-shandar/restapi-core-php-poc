<?php
namespace RestApiCore;


use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;

class ApiClient
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
    const APPLICATION_X_WWW_FORM_URLENCODED = 'application/x-www-form-urlencoded';
    const MULTIPART_FORM_DATA = 'multipart/form-data';

    public function __construct(ClientInterface $httpClient, $baseUrl)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = $baseUrl;
    }



    /**
     * @param TypeInfo $resultTypeInfo
     * @param ApiRequest $apiRequest
     *
     * @return mixed
     */
    public function request(TypeInfo $resultTypeInfo, ApiRequest $apiRequest)
    {
        $headers = array_merge($apiRequest->getHeaders(), ['Accept' => self::APPLICATION_JSON]);

        $request = new Request(
            $apiRequest->method,
            $apiRequest->getUrl($this->baseUrl),
            $headers,
            $apiRequest->getBodyString()
        );

        $response = $this->httpClient->send($request, $apiRequest->getOptions());

        $responseBody = $response->getBody();
        $contents = $responseBody->getContents();
        $rawResult = json_decode($contents);

        return $resultTypeInfo->deserialize($rawResult);
    }
}