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
     * @param TypeInfo $resultTypeInfo
     * @param string $path
     * @param string $method
     * @param array $queryParameters
     * @param array $headerParameters
     * @param mixed $body
     *
     * @return mixed
     */
    public function request(
        TypeInfo $resultTypeInfo,
        $path,
        $method,
        array $queryParameters,
        array $headerParameters,
        $body)
    {
        $uri = $this->baseUrl . $path . self::query($queryParameters);

        $request = new Request(
            $method,
            $uri,
            [
                'Content-Type' => self::APPLICATION_JSON,
                'Accept' => self::APPLICATION_JSON,
            ],
            json_encode(TypeInfo::serialize($body)));

        $response = $this->httpClient->send($request);

        $responseBody = $response->getBody();
        $contents = $responseBody->getContents();
        $rawResult = json_decode($contents);

        return $resultTypeInfo->deserialize($rawResult);
    }

    /**
     * @param array $queryParameters
     * @return string
     */
    private static function query(array $queryParameters)
    {
        $query = http_build_query($queryParameters);
        return  $query === '' ? '' : '?' . $query;
    }
}