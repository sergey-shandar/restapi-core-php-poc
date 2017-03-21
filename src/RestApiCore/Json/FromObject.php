<?php
namespace RestApiCore\Json;

use RestApiCore\Reflection\Types\Info;

/**
 * Build a JSON string from an object.
 */
final class FromObject
{
    /**
     * @var FromSeq
     */
    private $seq;

    public function __construct()
    {
        $this->seq = new FromSeq();
    }

    /**
     * @param string $name
     * @param string $jsonValue
     */
    public function appendJson($name, $jsonValue)
    {
        $this->seq->append(Common::encodeStr($name) . ':' . $jsonValue);
    }

    /**
     * @param Info $type
     * @param string $name
     * @param mixed|null $value
     */
    public function append(Info $type, $name, $value)
    {
        if ($value !== null) {
            $this->appendJson($name, $type->jsonSerializeNotNull($value));
        }
    }

    public function get()
    {
        return '{' . $this->seq->get() . '}';
    }
}