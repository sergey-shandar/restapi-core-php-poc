<?php
namespace RestApiCore;

abstract class ApiRequest
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
            if (gettype($value) === TypeInfo::ARRAY_TYPE) {
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
        $query = $this->getQuery();

        if (!empty($query)) {
            $query = '?' . $query;
        }

        return $baseUrl . $this->path . $query;
    }

    /**
     * @return string
     */
    public abstract function getBodyString();

    /**
     * @return array
     */
    public abstract function getOptions();

    /**
     * @return array
     */
    public abstract function getHeaders();

    private static function queryParam($key, $value) {
        return $key . '=' . urlencode($value);
    }
}