<?php
namespace RestApiCore;

class ApiRequest
{
    /**
     * @var string
     */
    public $contentType = ApiClient::APPLICATION_JSON;

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

    /**
     * @var mixed
     */
    public $body = '';

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

    public function getBodyString() {
        return json_encode(TypeInfo::serialize($this->body));
    }

    private static function queryParam($key, $value) {
        return $key . '=' . urlencode($value);
    }
}