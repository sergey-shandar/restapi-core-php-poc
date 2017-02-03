<?php
namespace RestApiCore\Type;

final class DateTimeType extends Type
{
    /**
     * @param string $data
     * @return \DateTime
     */
    public function deserialize($data)
    {
        return new \DateTime($data);
    }

    public static function create()
    {
        return new self();
    }
}