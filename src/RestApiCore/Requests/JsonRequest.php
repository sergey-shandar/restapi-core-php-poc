<?php
namespace RestApiCore\Requests;

use RestApiCore\Types\Type;

final class JsonRequest extends Request
{
    /**
     * @var Type|null
     */
    public $type = null;

    /**
     * @var mixed|null
     */
    public $body = null;

    /**
     * @return array
     */
    public function getOptions()
    {
        $raw = $this->type === null ? null : $this->type->serialize($this->body);
        return ['json' => $raw];
    }
}