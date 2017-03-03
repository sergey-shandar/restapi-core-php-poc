<?php

/**
 */
class Category
{
    /**
     * @var int|null
     */
    public $id;

    /**
     * @var string|null
     */
    public $name;

    /**
     * @param int|null $id
     * @return self
     */
    public function id($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string|null $name
     * @return self
     */
    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param int|null $id
     * @param string|null $name
     */
    public function __construct($id = null, $name = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     */
    public static function createClassInfo()
    {
        return new \RestApiCore\Types\ClassType(self::class, [new \RestApiCore\PropertyInfo('id', 'id', \RestApiCore\Types\StringType::create()), new RestApiCore\PropertyInfo('name', 'name', \RestApiCore\Types\StringType::create())]);
    }

    /**
     * @param int|null $id
     * @param string|null $name
     * @return self
     */
    public static function create($id = null, $name = null)
    {
        return new self($id, $name);
    }
}
