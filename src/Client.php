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
        $uri = $this->baseUrl . $path;
        if (count($queryParameters) > 0)
        {
            $items = [];
            foreach ($queryParameters as $key => $value)
            {
                if (gettype($value) === TypeInfo::ARRAY_TYPE)
                {
                    foreach ($value as $v)
                    {
                        $items[] = $key . '=' . $v;
                    }
                }
                else
                {
                    $items[] = $key . '=' . $value;
                }
            }
            $uri .= "?" . join('&', $items);
        }

        $request = new Request(
            $method,
            $uri,
            ['Content-Type' => 'application/json'],
            json_encode(TypeInfo::serialize($body)));
        $response = $this->httpClient->send($request);
        return $resultTypeInfo->deserialize($response->getBody());
    }
}