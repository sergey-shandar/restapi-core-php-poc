<?php
namespace RestApiCore\Type;

final class StdClassType extends Type
{
    /**
     * @var Type
     */
    public $propertyType;

    /**
     * StdClassType constructor.
     *
     * @param Type $propertyType
     */
    public function __construct(Type $propertyType)
    {
        $this->propertyType = $propertyType;
    }

    /**
     * @param \stdClass|null $data
     * @return \stdClass|null
     */
    public function deserialize($data)
    {
        if ($data === null)
        {
            return $data;
        }

        $result = new \stdClass();
        foreach (get_object_vars($data) as $key => $value) {
            $result->$key =  $this->propertyType->deserialize($value);
        }
        return $result;
    }
}