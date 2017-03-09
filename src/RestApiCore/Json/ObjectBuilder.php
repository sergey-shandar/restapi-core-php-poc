<?php
namespace RestApiCore\Json;

use RestApiCore\Types\Type;

final class ObjectBuilder
{
    /**
     * @var SeqBuilder
     */
    private $seq;

    public function __construct()
    {
        $this->seq = new SeqBuilder();
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
     * @param Type $type
     * @param string $name
     * @param mixed|null $value
     */
    public function append(Type $type, $name, $value)
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