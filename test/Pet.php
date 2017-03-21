<?php

class Pet
{
    /**
     * @var int|null
     */
    public $id;

    /**
     * @var Category|null
     */
    public $category;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string[]
     */
    public $photoUrls;

    /**
     * @var Tag[]|null
     */
    public $tags;

    /**
     * @var string|null
     */
    public $status;

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
     * @param Category|null $category
     * @return self
     */
    public function category(Category $category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @param string $name
     * @return self
     */
    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string[] $photoUrls
     * @return self
     */
    public function photoUrls(array $photoUrls)
    {
        $this->photoUrls = $photoUrls;
        return $this;
    }

    /**
     * @param Tag[]|null $tags
     * @return self
     */
    public function tags(array $tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @param string|null $status
     * @return self
     */
    public function status($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param int|null $id
     * @param Category|null $category
     * @param string|null $name
     * @param string[]|null $photoUrls
     * @param Tag[]|null $tags
     * @param string|null $status
     */
    public function __construct($id = null, Category $category = null, $name = null, array $photoUrls = null, array $tags = null, $status = null)
    {
        $this->id = $id;
        $this->category = $category;
        $this->name = $name;
        $this->photoUrls = $photoUrls;
        $this->tags = $tags;
        $this->status = $status;
    }

    /**
     */
    public static function createClassInfo()
    {
        return \RestApiCore\Reflection\Types\ClassInfo::create(self::class)
            ->withProperty('id', 'id', \RestApiCore\Reflection\Types\NumberInfo::create())
            ->withProperty('category', 'category', Category::createClassInfo())
            ->withProperty('name', 'name', \RestApiCore\Reflection\Types\StringInfo::create())
            ->withProperty('photoUrls', 'photoUrls', \RestApiCore\Reflection\Types\StringInfo::create()->createArray())
            ->withProperty('tags', 'tags', Tag::createClassInfo()->createArray())
            ->withProperty('status', 'status', \RestApiCore\Reflection\Types\StringInfo::create());
    }

    /**
     * @param int|null $id
     * @param Category|null $category
     * @param string|null $name
     * @param string[]|null $photoUrls
     * @param Tag[]|null $tags
     * @param string|null $status
     * @return self
     */
    public static function create($id = null, Category $category = null, $name = null, array $photoUrls = null, array $tags = null, $status = null)
    {
        return new self($id, $category, $name, $photoUrls, $tags, $status);
    }
}