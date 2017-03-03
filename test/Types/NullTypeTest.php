<?php
namespace Types;

use PHPUnit\Framework\TestCase;
use RestApiCore\Types\NullType;

class NullTypeTest extends TestCase
{
    public function test()
    {
        $type = NullType::create();

        $json = $type->jsonSerialize(90);
        $this->assertSame('null', $json);

        $object = $type->jsonDeserialize($json);
        $this->assertNull($object);
    }
}