<?php

use RestApiCore\Core;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public function testBool()
    {
        $v = Core::serialize(true);
        $this->assertEquals($v, true);
        $this->assertEquals(gettype($v), Core::BOOLEAN_TYPE);

        $x = Core::deserialize($v, gettype($v), 0);
        $this->assertEquals($x, true);
        $this->assertEquals(gettype($x), Core::BOOLEAN_TYPE);
    }

    public function testInt()
    {
        $v = Core::serialize(45);
        $this->assertEquals($v, 45);
        $this->assertEquals(gettype($v), Core::INTEGER_TYPE);

        $x = Core::deserialize($v, gettype($v), 0);
        $this->assertEquals($x, 45);
        $this->assertEquals(gettype($x), Core::INTEGER_TYPE);
    }

    public function testFloat()
    {
        $v = Core::serialize(45.7);
        $this->assertEquals($v, 45.7);
        $this->assertEquals(gettype($v), Core::DOUBLE_TYPE);

        $x = Core::deserialize($v, gettype($v), 0);
        $this->assertEquals($x, 45.7);
        $this->assertEquals(gettype($x), Core::DOUBLE_TYPE);
    }

    public function testString()
    {
        $v = Core::serialize('abc');
        $this->assertEquals($v, 'abc');
        $this->assertEquals(gettype($v), Core::STRING_TYPE);

        $x = Core::deserialize($v, gettype($v), 0);
        $this->assertEquals($x, 'abc');
        $this->assertEquals(gettype($x), Core::STRING_TYPE);
    }

    public function testIntArray()
    {
        $v = Core::serialize([ 1, 2 ]);
        $this->assertEquals($v, [ 1, 2 ]);
        $this->assertEquals(gettype($v), Core::ARRAY_TYPE);

        $x = Core::deserialize($v, Core::INTEGER_TYPE, 1);
        $this->assertEquals($x, [ 1, 2 ]);
        $this->assertEquals(gettype($x), Core::ARRAY_TYPE);
    }
}
