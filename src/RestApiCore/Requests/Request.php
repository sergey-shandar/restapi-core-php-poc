<?php
namespace RestApiCore\Requests;

use RestApiCore\Reflection\Types\Info;

abstract class Request
{
    /**
     * @var string
     */
    public $path = '';

    /**
     * @var string
     */
    public $method = 'GET';

    /**
     * An associative array of parameters. Each parameter is a value which is convertible to a string or an array of
     * such values.
     *
     * @var array
     */
    public $queryParameters = [];

    /**
     * @return string
     */
    public function getQuery()
    {
        /**
         * @var string[]
         */
        $parameters = [];
        foreach ($this->queryParameters as $key => $value) {
            if (gettype($value) === Info::ARRAY_TYPE) {
                foreach ($value as $item) {
                    $parameters[] = self::queryParam($key, $item);
                }
            } else {
                $parameters[] = self::queryParam($key, $value);
            }
        }

        return join('&', $parameters);
    }

    /**
     * @param string $baseUrl
     *
     * @return string
     */
    public function getUrl($baseUrl)
    {
        return $baseUrl . $this->path;
    }

    /**
     * @return array
     */
    public abstract function getOptions();

    /**
     * @return string|null
     */
    public abstract function getBody();

    /**
     * @return string[]
     */
    public abstract function getHeaders();

    /**
     * @param string $key
     * @param string $value
     *
     * @return string
     */
    private static function queryParam($key, $value) {
        return $key . '=' . urlencode($value);
    }
}