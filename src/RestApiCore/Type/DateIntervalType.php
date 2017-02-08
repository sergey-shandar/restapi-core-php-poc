<?php
namespace RestApiCore\Type;

final class DateIntervalType extends Type
{
    /**
     * @param mixed $data
     * @return mixed
     */
    public function deserialize($data)
    {
        return new \DateInterval($data);
    }

    public static function create()
    {
        return new self();
    }
}