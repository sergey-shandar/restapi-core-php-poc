<?php
namespace RestApiCore\Request;

use RestApiCore\Type\Type;

final class JsonRequest extends Request
{
    /**
     * @var Type|null
     */
    public $type = null;

    /**
     * @var mixed
     */
    public $body = '';

    /**
     * @return array
     */
    public function getOptions()
    {
        $raw = $this->type === null ? '' : $this->type->serialize($this->body);
        return ['json' => $raw];
    }
}