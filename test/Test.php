<?php

use RestApiCore\PrimitiveTypeInfo;
use PHPUnit\Framework\TestCase;
use RestApiCore\TypeInfo;

class Test extends TestCase
{
    public function testBool()
    {
        $v = TypeInfo::serialize(true);
        $this->assertSame($v, true);
        $this->assertSame(gettype($v), 'boolean');

        $x = PrimitiveTypeInfo::create()->deserialize($v);
        $this->assertSame($x, true);
        $this->assertSame(gettype($x), 'boolean');
    }

    public function testInt()
    {
        $v = TypeInfo::serialize(45);
        $this->assertSame($v, 45);
        $this->assertSame(gettype($v), 'integer');

        $x = PrimitiveTypeInfo::create()->deserialize($v);
        $this->assertSame($x, 45);
        $this->assertSame(gettype($x), 'integer');
    }

    public function testFloat()
    {
        $v = TypeInfo::serialize(45.7);
        $this->assertSame($v, 45.7);
        $this->assertSame(gettype($v), 'double');

        $x = PrimitiveTypeInfo::create()->deserialize($v);
        $this->assertSame($x, 45.7);
        $this->assertSame(gettype($x), 'double');
    }

    public function testString()
    {
        $v = TypeInfo::serialize('abc');
        $this->assertSame($v, 'abc');
        $this->assertSame(gettype($v), 'string');

        $x = PrimitiveTypeInfo::create()->deserialize($v);
        $this->assertSame($x, 'abc');
        $this->assertSame(gettype($x), 'string');
    }

    public function testIntArray()
    {
        $v = TypeInfo::serialize([1, 2]);
        $this->assertSame($v, [1, 2]);
        $this->assertSame(gettype($v), 'array');

        $x = PrimitiveTypeInfo::create()->createArray()->deserialize($v);
        $this->assertSame($x, [1, 2]);
        $this->assertSame(gettype($x), 'array');
    }

    public function testSampleClass()
    {
        $s = new SampleClass();
        $s->a = 1;
        $s->b = [[['a'], null]];
        $s->c = [3];

        $v = TypeInfo::serialize($s);
        $this->assertSame($v['a'], 1);
        $this->assertSame($v['b'], [[['a'], null]]);
        $this->assertSame($v['CCC'], [3]);

        /**
         * @var SampleClass $x
         */
        $x = SampleClass::createClassInfo()->deserialize($v);
        $this->assertSame($x->a, 1);
        $this->assertSame($x->b, [[['a'], null]]);
        $this->assertSame($x->c, [3]);
        $this->assertSame($x->subArray, []);
    }

    public function testSampleClassWithNulls()
    {
        $s = new SampleClass();

        $v = TypeInfo::serialize($s);
        $this->assertSame(count($v), 5);
        $this->assertSame($v['a'], 0);
        $this->assertSame($v['b'], []);
        $this->assertSame($v['CCC'], []);
        $this->assertSame($v['sub'], ['a' => 0]);
        $this->assertArrayNotHasKey('d', $v);
        $this->assertSame($v['subArray'], []);

        /**
         * @var SampleClass $x
         */
        $x = SampleClass::createClassInfo()->deserialize($v);
        $this->assertSame($x->a, 0);
        $this->assertSame($x->b, []);
        $this->assertSame($x->c, []);
        $this->assertSame($x->d, null);
        $this->assertSame($x->subArray, []);
    }

    public function testArrayWithNulls()
    {
        $s = [ null, new SampleClass(null, [[[null, 'a']]], [3]) ];

        $v = TypeInfo::serialize($s);
        $this->assertSame(count($v), 2);
        $this->assertSame($v[0], null);
        $v1 = $v[1];
        $this->assertSame(count($v1), 5);
        $this->assertSame($v1['a'], 0);
        $this->assertSame($v1['b'], [[[null, 'a']]]);
        $this->assertSame($v1['CCC'], [3]);
        $this->assertSame($v1['sub'], ['a' => 0]);
        $this->assertArrayNotHasKey('d', $v);
        $this->assertSame($v1['subArray'], []);

        /**
         * @var SampleClass[] $y
         */
        $y = SampleClass::createClassInfo()->createArray()->deserialize($v);
        $this->assertSame(count($y), 2);
        $this->assertSame($y[0], null);
        $x = $y[1];
        $this->assertSame($x->a, 0);
        $this->assertSame($x->b, [[[null, 'a']]]);
        $this->assertSame($x->c, [3]);
        $this->assertSame($x->subArray, []);
    }
}
