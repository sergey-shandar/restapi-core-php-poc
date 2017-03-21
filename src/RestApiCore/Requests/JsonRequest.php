<?php
namespace RestApiCore\Requests;

use RestApiCore\Reflection\Types\TypeInfo;

final class JsonRequest extends Request
{
    const CONTENT_TYPE = 'application/json';

    /**
     * @var TypeInfo|null
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
        return [];
    }

    /**
     * @return string|null
     */
    public function getBody()
    {
        $type = $this->type;
        $body = $this->body;
        return $type === null || $body === null ? null : $type->jsonSerializeNotNull($body);
    }

    /**
     * @return string[]
     */
    public function getHeaders()
    {
        return [ 'Content-Type' => self::CONTENT_TYPE ];
    }
}