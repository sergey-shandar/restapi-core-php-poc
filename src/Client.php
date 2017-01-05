<?php
namespace RestApiCore;


class Client
{
    /**
     * @param string $path
     * @param string $method
     * @param array $pathParameters
     * @param array $queryParameters
     * @param array $headerParameters
     * @param $body
     *
     * @return null
     */
    function request($path, $method, array $pathParameters, array $queryParameters, array $headerParameters, $body)
    {
        return null;
    }
}