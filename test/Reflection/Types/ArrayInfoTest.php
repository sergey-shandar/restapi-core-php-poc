<?php
namespace Reflection\Types;

use PHPUnit\Framework\TestCase;
use RestApiCore\Reflection\Types\StringInfo;

class ArrayInfoTest extends TestCase
{
    public function test()
    {
        $type = StringInfo::create()->createArray();

        $json = $type->jsonSerialize(['a', 'b', null]);
        $this->assertSame('["a","b",null]', $json);

        $object = $type->jsonDeserialize($json);
        $this->assertSame(['a', 'b', null], $object);
    }
}