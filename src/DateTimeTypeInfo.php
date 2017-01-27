<?php
namespace RestApiCore;

final class DateTimeTypeInfo extends TypeInfo
{
    /**
     * @param string $data
     * @return \DateTime
     */
    public function deserialize($data)
    {
        return new \DateTime($data);
    }
}