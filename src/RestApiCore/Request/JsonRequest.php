<?php
namespace RestApiCore\Request;

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
}