<?php
namespace RestApiCore\Request;

use RestApiCore\ApiClient;
use RestApiCore\Type\Type;

final class JsonRequest extends Request
{
    /**
     * @var string
     */
    public $contentType = ApiClient::APPLICATION_JSON;

    /**
     * @var mixed
     */
    public $body = '';

    /**
     * @return string
     */
    public function getBodyString() {
        return null;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        $raw = Type::serialize($this->body);
        return ['json' => $raw];
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return [ 'Content-Type' => $this->contentType ];
    }
}