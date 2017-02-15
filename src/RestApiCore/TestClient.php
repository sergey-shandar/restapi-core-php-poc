<?php
namespace RestApiCore;


abstract class TestClient
{
    /**
     * @var ApiClient
     */
    public $apiClient;

    /**
     * @param $expected
     * @param $actual
     */
    public abstract function assertSame($expected, $actual);

    /**
     * @param \stdClass $parameters
     */
    public abstract function filter(\stdClass $parameters);
}