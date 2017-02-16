<?php

use RestApiCore\Type\DateIntervalType;
use RestApiCore\Type\DateTimeType;
use RestApiCore\Type\LongType;
use RestApiCore\Type\PrimitiveType;
use RestApiCore\Type\Type;
use PHPUnit\Framework\TestCase;

class TypeInfoTest extends TestCase
{
    public function testBool()
    {
        $v = Type::serialize(true);
        $this->assertSame($v, true);
        $this->assertSame(gettype($v), 'boolean');

        $x = PrimitiveType::create()->deserialize($v);
        $this->assertSame($x, true);
        $this->assertSame(gettype($x), 'boolean');
    }

    public function testInt()
    {
        $v = Type::serialize(45);
        $this->assertSame($v, 45);
        $this->assertSame(gettype($v), 'integer');

        $x = PrimitiveType::create()->deserialize($v);
        $this->assertSame($x, 45);
        $this->assertSame(gettype($x), 'integer');
    }

    public function testFloat()
    {
        $v = Type::serialize(45.7);
        $this->assertSame($v, 45.7);
        $this->assertSame(gettype($v), 'double');

        $x = PrimitiveType::create()->deserialize($v);
        $this->assertSame($x, 45.7);
        $this->assertSame(gettype($x), 'double');
    }

    public function testString()
    {
        $v = Type::serialize('abc');
        $this->assertSame($v, 'abc');
        $this->assertSame(gettype($v), 'string');

        $x = PrimitiveType::create()->deserialize($v);
        $this->assertSame($x, 'abc');
        $this->assertSame(gettype($x), 'string');
    }

    public function testIntArray()
    {
        $v = Type::serialize([1, 2]);
        $this->assertSame($v, [1, 2]);
        $this->assertSame(gettype($v), 'array');

        $x = PrimitiveType::create()->createArray()->deserialize($v);
        $this->assertSame($x, [1, 2]);
        $this->assertSame(gettype($x), 'array');
    }

    public function testSampleClass()
    {
        $s = new MainSampleClass();
        $s->a = 1;
        $s->b = [[['a'], null]];
        $s->c = [3];

        /**
         * @var stdClass $v
         */
        $v = Type::serialize($s);
        $this->assertSame($v->a, 1);
        $this->assertSame($v->b, [[['a'], null]]);
        $this->assertSame($v->CCC, [3]);

        /**
         * @var MainSampleClass $x
         */
        $x = MainSampleClass::createClassInfo()->deserialize($v);
        $this->assertSame($x->a, 1);
        $this->assertSame($x->b, [[['a'], null]]);
        $this->assertSame($x->c, [3]);
        $this->assertSame($x->subArray, []);
    }

    public function testSampleClassWithNulls()
    {
        $s = new MainSampleClass();

        /**
         * @var stdClass $v
         */
        $v = Type::serialize($s);
        $p = get_object_vars($v);
        $this->assertSame(count($p), 5);
        $this->assertSame($v->a, 0);
        $this->assertSame($v->b, []);
        $this->assertSame($v->CCC, []);
        $this->assertSame($v->sub->a, 0);
        $this->assertFalse(property_exists($v, 'd'));
        $this->assertSame($v->subArray, []);

        /**
         * @var MainSampleClass $x
         */
        $x = MainSampleClass::createClassInfo()->deserialize($v);
        $this->assertSame($x->a, 0);
        $this->assertSame($x->b, []);
        $this->assertSame($x->c, []);
        $this->assertSame($x->d, null);
        $this->assertSame($x->subArray, []);
    }

    public function testDateTime()
    {
        $s = new DateTime('2017-01-18T18:23:32.708000Z');

        $x = Type::serialize($s);
        $this->assertSame('2017-01-18T18:23:32.708000Z', $x);

        $m = DateTimeType::create()->deserialize($x);
        $this->assertEquals($s, $m);
    }

    public function testDateInterval()
    {
        $s = new DateInterval('P1Y2M3DT4H5M6S');

        $x = Type::serialize($s);
        $this->assertSame('P1Y2M3DT4H5M6S', $x);

        $m = DateIntervalType::create()->deserialize($x);
        $this->assertEquals($s, $m);
    }

    public function testLongTypeInfo()
    {
        $s = 12;

        $x = LongType::create()->deserialize($s);
        $this->assertEquals($x, '12');
    }

    public function testArrayWithNulls()
    {
        $s = [ null, new MainSampleClass(null, [[[null, 'a']]], [3]) ];

        $v = Type::serialize($s);
        $this->assertSame(count($v), 2);
        $this->assertSame($v[0], null);
        /**
         * @var stdClass $v1
         */
        $v1 = $v[1];
        $this->assertSame(count(get_object_vars($v1)), 5);
        $this->assertSame($v1->a, 0);
        $this->assertSame($v1->b, [[[null, 'a']]]);
        $this->assertSame($v1->CCC, [3]);
        $this->assertSame($v1->sub->a, 0);
        $this->assertArrayNotHasKey('d', $v);
        $this->assertSame($v1->subArray, []);

        /**
         * @var MainSampleClass[] $y
         */
        $y = MainSampleClass::createClassInfo()->createArray()->deserialize($v);
        $this->assertSame(count($y), 2);
        $this->assertSame($y[0], null);
        $x = $y[1];
        $this->assertSame($x->a, 0);
        $this->assertSame($x->b, [[[null, 'a']]]);
        $this->assertSame($x->c, [3]);
        $this->assertSame($x->subArray, []);
    }

    public function testEmptyArray() {
        $x = [];
        /**
         * @var [] $o
         */
        $o = Type::serialize($x);
        $s = json_encode($o);
        $this->assertSame($s, '[]');
        $type = PrimitiveType::create()->createArray();
        $result = $type->deserialize($o);
        $this->assertSame($result, []);
    }

    public function testDictionary() {
        $x = new stdClass();
        $z = 'api-version';
        $x->$z = 3;
        /**
         * @var \stdClass $o
         */
        $o = Type::serialize($x);
        $s = json_encode($o);
        $this->assertSame($s, '{"api-version":3}');
        $type = PrimitiveType::create()->createStdClass();
        $result = $type->deserialize($o);
        $this->assertSame($result->$z, 3);
    }

    public function testEmptyDictionary() {
        $x = new stdClass();
        /**
         * @var \stdClass $o
         */
        $o = Type::serialize($x);
        $s = json_encode($o);
        $this->assertSame($s, '{}');
        $type = PrimitiveType::create()->createStdClass();
        $result = $type->deserialize($o);
        $this->assertEquals($result, new \stdClass());
    }

    public function testNullDictionary() {
        $type = PrimitiveType::create()->createStdClass();
        $result = $type->deserialize(null);
        $this->assertNull($result);
    }
}
