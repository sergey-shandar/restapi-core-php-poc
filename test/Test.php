<?php

use RestApiCore\Core;
use RestApiCore\TypeInfo;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public function testBool()
    {
        $v = Core::serialize(true);
        $this->assertSame($v, true);
        $this->assertSame(gettype($v), Core::BOOLEAN_TYPE);

        $x = Core::deserialize($v, new TypeInfo(gettype($v)));
        $this->assertSame($x, true);
        $this->assertSame(gettype($x), Core::BOOLEAN_TYPE);
    }

    public function testInt()
    {
        $v = Core::serialize(45);
        $this->assertSame($v, 45);
        $this->assertSame(gettype($v), Core::INTEGER_TYPE);

        $x = Core::deserialize($v, new TypeInfo(gettype($v)));
        $this->assertSame($x, 45);
        $this->assertSame(gettype($x), Core::INTEGER_TYPE);
    }

    public function testFloat()
    {
        $v = Core::serialize(45.7);
        $this->assertSame($v, 45.7);
        $this->assertSame(gettype($v), Core::DOUBLE_TYPE);

        $x = Core::deserialize($v, new TypeInfo(gettype($v)));
        $this->assertSame($x, 45.7);
        $this->assertSame(gettype($x), Core::DOUBLE_TYPE);
    }

    public function testString()
    {
        $v = Core::serialize('abc');
        $this->assertSame($v, 'abc');
        $this->assertSame(gettype($v), Core::STRING_TYPE);

        $x = Core::deserialize($v, new TypeInfo(gettype($v)));
        $this->assertSame($x, 'abc');
        $this->assertSame(gettype($x), Core::STRING_TYPE);
    }

    public function testIntArray()
    {
        $v = Core::serialize([1, 2]);
        $this->assertSame($v, [1, 2]);
        $this->assertSame(gettype($v), Core::ARRAY_TYPE);

        $x = Core::deserialize($v, new TypeInfo(Core::INTEGER_TYPE, 1));
        $this->assertSame($x, [1, 2]);
        $this->assertSame(gettype($x), Core::ARRAY_TYPE);
    }

    public function testSampleClass()
    {
        $s = new SampleClass();
        $s->a = 1;
        $s->b = [[['a']]];
        $s->c = [3];

        $v = Core::serialize($s);
        $this->assertSame($v['a'], 1);
        $this->assertSame($v['b'], [[['a']]]);
        $this->assertSame($v['CCC'], [3]);

        /**
         * @var SampleClass $x
         */
        $x = SampleClass::deserialize($v);
        $this->assertSame($x->a, 1);
        $this->assertSame($x->b, [[['a']]]);
        $this->assertSame($x->c, [3]);
    }

    public function testSampleClassWithNulls()
    {
        $s = new SampleClass();

        $v = Core::serialize($s);
        $this->assertSame(count($v), 4);
        $this->assertSame($v['a'], 0);
        $this->assertSame($v['b'], []);
        $this->assertSame($v['CCC'], []);
        $this->assertSame($v['sub'], ['a' => 0]);
        $this->assertArrayNotHasKey('d', $v);

        /**
         * @var SampleClass $x
         */
        $x = SampleClass::deserialize($v);
        $this->assertSame($x->a, 0);
        $this->assertSame($x->b, []);
        $this->assertSame($x->c, []);
        $this->assertSame($x->d, null);
    }

    public function testArrayWithNulls()
    {
        $s = [ null, new SampleClass(null, [[[null, 'a']]], [3]) ];

        $v = Core::serialize($s);
        $this->assertSame(count($v), 2);
        $this->assertSame($v[0], null);
        $v1 = $v[1];
        $this->assertSame(count($v1), 4);
        $this->assertSame($v1['a'], 0);
        $this->assertSame($v1['b'], [[[null, 'a']]]);
        $this->assertSame($v1['CCC'], [3]);
        $this->assertSame($v1['sub'], ['a' => 0]);
        $this->assertArrayNotHasKey('d', $v);

        /**
         * @var SampleClass[] $y
         */
        $y = Core::deserialize($v, new TypeInfo(SampleClass::class, 1));
        $this->assertSame(count($y), 2);
        $this->assertSame($y[0], null);
        $x = $y[1];
        $this->assertSame($x->a, 0);
        $this->assertSame($x->b, [[[null, 'a']]]);
        $this->assertSame($x->c, [3]);
    }
}
