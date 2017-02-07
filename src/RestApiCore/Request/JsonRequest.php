<?php
namespace RestApiCore\Request;

use RestApiCore\ApiClient;
use RestApiCore\Type\Type;

final class JsonRequest extends Request
{
    /**
     * @var mixed
     */
    public $body = '';

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
        return [];
    }
}