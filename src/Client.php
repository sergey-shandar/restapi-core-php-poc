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
    const APPLICATION_X_WWW_FORM_URLENCODED = 'application/x-www-form-urlencoded';

    public function __construct(ClientInterface $httpClient, $baseUrl)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param TypeInfo $resultTypeInfo
     * @param string $contentType
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
        $contentType,
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
                'Content-Type' => $contentType,
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
        /**
         * @var string[] $parameters
         */
        $parameters = [];
        foreach ($queryParameters as $key => $value) {
            if (gettype($value) === TypeInfo::ARRAY_TYPE) {
                foreach ($value as $item) {
                    $parameters[] = self::queryParam($key, $item);
                }
            } else {
                $parameters[] = self::queryParam($key, $value);
            }
        }

        if (count($parameters) === 0) {
            return '';
        }

        return '?' . join('&', $parameters);
    }

    private static function queryParam($key, $value) {
        return $key . '=' . urlencode($value);
    }
}