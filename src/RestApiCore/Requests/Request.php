<?php
namespace RestApiCore\Requests;

use RestApiCore\Types\Type;

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
     * @var array
     */
    public $queryParameters = [];

    /**
     * @var array
     */
    public $headerParameters = [];

    public function getQuery()
    {
        /**
         * @var string[]
         */
        $parameters = [];
        foreach ($this->queryParameters as $key => $value) {
            if (gettype($value) === Type::ARRAY_TYPE) {
                foreach ($value as $item) {
                    $parameters[] = self::queryParam($key, $item);
                }
            } else {
                $parameters[] = self::queryParam($key, $value);
            }
        }

        return join('&', $parameters);
    }

    public function getUrl($baseUrl)
    {
        return $baseUrl . $this->path;
    }

    /**
     * @return array
     */
    public abstract function getOptions();

    private static function queryParam($key, $value) {
        return $key . '=' . urlencode($value);
    }
}