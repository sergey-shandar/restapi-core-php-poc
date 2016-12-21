<?php

use RestApiCore\Core;
use RestApiCore\TypeInfo;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public function testBool()
    {
        $v = Core::serialize(true);
        $this->assertEquals($v, true);
        $this->assertEquals(gettype($v), Core::BOOLEAN_TYPE);

        $x = Core::deserialize($v, new TypeInfo(gettype($v)));
        $this->assertEquals($x, true);
        $this->assertEquals(gettype($x), Core::BOOLEAN_TYPE);
    }

    public function testInt()
    {
        $v = Core::serialize(45);
        $this->assertEquals($v, 45);
        $this->assertEquals(gettype($v), Core::INTEGER_TYPE);

        $x = Core::deserialize($v, new TypeInfo(gettype($v)));
        $this->assertEquals($x, 45);
        $this->assertEquals(gettype($x), Core::INTEGER_TYPE);
    }

    public function testFloat()
    {
        $v = Core::serialize(45.7);
        $this->assertEquals($v, 45.7);
        $this->assertEquals(gettype($v), Core::DOUBLE_TYPE);

        $x = Core::deserialize($v, new TypeInfo(gettype($v)));
        $this->assertEquals($x, 45.7);
        $this->assertEquals(gettype($x), Core::DOUBLE_TYPE);
    }

    public function testString()
    {
        $v = Core::serialize('abc');
        $this->assertEquals($v, 'abc');
        $this->assertEquals(gettype($v), Core::STRING_TYPE);

        $x = Core::deserialize($v, new TypeInfo(gettype($v)));
        $this->assertEquals($x, 'abc');
        $this->assertEquals(gettype($x), Core::STRING_TYPE);
    }

    public function testIntArray()
    {
        $v = Core::serialize([1, 2]);
        $this->assertEquals($v, [1, 2]);
        $this->assertEquals(gettype($v), Core::ARRAY_TYPE);

        $x = Core::deserialize($v, new TypeInfo(Core::INTEGER_TYPE, 1));
        $this->assertEquals($x, [1, 2]);
        $this->assertEquals(gettype($x), Core::ARRAY_TYPE);
    }

    public function testSampleClass()
    {
        $s = new SampleClass();
        $s->a = 1;
        $s->b = [[['a']]];
        $s->c = [3];

        $v = Core::serialize($s);
        $this->assertEquals($v['a'], 1);
        $this->assertEquals($v['b'], [[['a']]]);
        $this->assertEquals($v['CCC'], [3]);

        /**
         * @var SampleClass $x
         */
        $x = SampleClass::deserialize($v);
        $this->assertEquals($x->a, 1);
        $this->assertEquals($x->b, [[['a']]]);
        $this->assertEquals($x->c, [3]);
    }

    public function testSampleClassWithNulls()
    {
        $s = new SampleClass();

        $v = Core::serialize($s);
        $this->assertArrayNotHasKey('a', $v);
        $this->assertArrayNotHasKey('b', $v);
        $this->assertArrayNotHasKey('CCC', $v);

        /**
         * @var SampleClass $x
         */
        $x = SampleClass::deserialize($v);
        $this->assertEquals($x->a, null);
        $this->assertEquals($x->b, null);
        $this->assertEquals($x->c, null);
    }

    public function testArrayWithNulls()
    {
        $s = [ null, new SampleClass(null, [[[null, 'a']]], [3]) ];

        $v = Core::serialize($s);
        $this->assertEquals(count($v), 2);
        $this->assertEquals($v[0], null);
        $v1 = $v[1];
        $this->assertArrayNotHasKey('a', $v1);
        $this->assertEquals($v1['b'], [[[null, 'a']]]);
        $this->assertEquals($v1['CCC'], [3]);

        /**
         * @var SampleClass[] $y
         */
        $y = Core::deserialize($v, new TypeInfo(SampleClass::class, 1));
        $this->assertEquals(count($y), 2);
        $this->assertEquals($y[0], null);
        $x = $y[1];
        $this->assertEquals($x->a, null);
        $this->assertEquals($x->b, [[[null, 'a']]]);
        $this->assertEquals($x->c, [3]);
    }
}
