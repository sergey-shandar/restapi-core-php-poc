<?php
namespace RestApiCore;


class Client
{
    /**
     * @param TypeInfo $result
     * @param string $path
     * @param string $method
     * @param array $pathParameters
     * @param array $queryParameters
     * @param array $headerParameters
     * @param $body
     *
     * @return object
     */
    function request(
        TypeInfo $result,
        $path,
        $method,
        array $pathParameters,
        array $queryParameters,
        array $headerParameters, $body)
    {
        return null;
    }
}