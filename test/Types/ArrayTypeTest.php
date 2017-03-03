<?php
namespace Types;

use PHPUnit\Framework\TestCase;
use RestApiCore\Types\StringType;

class ArrayTypeTest extends TestCase
{
    public function test()
    {
        $type = StringType::create()->createArray();

        $json = $type->jsonSerialize(['a', 'b', null]);
        $this->assertSame('["a","b",null]', $json);

        $object = $type->jsonDeserialize($json);
        $this->assertSame(['a', 'b', null], $object);
    }
}