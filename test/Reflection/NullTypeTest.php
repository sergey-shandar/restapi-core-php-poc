<?php
namespace Reflection;

use PHPUnit\Framework\TestCase;
use RestApiCore\Reflection\Types\NullInfo;

class NullTypeTest extends TestCase
{
    public function test()
    {
        $type = NullInfo::create();

        $json = $type->jsonSerialize(90);
        $this->assertSame('null', $json);

        $object = $type->jsonDeserialize($json);
        $this->assertNull($object);
    }
}