<?php
namespace RestApiCore\Request;

use RestApiCore\Type\Type;

final class JsonRequest extends Request
{
    /**
     * @var mixed
     */
    private $body = '';

    public function __construct(Type $type, $object)
    {
        $this->body = $type->serialize($object);
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return ['json' => $this->body];
    }
}