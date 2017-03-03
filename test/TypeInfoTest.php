<?php

use RestApiCore\Types\BooleanType;
use RestApiCore\Types\DateIntervalType;
use RestApiCore\Types\DateTimeType;
use RestApiCore\Types\LongType;
use RestApiCore\Types\NullType;
use RestApiCore\Types\NumberType;
use RestApiCore\Types\PrimitiveType;
use PHPUnit\Framework\TestCase;
use RestApiCore\Types\StringType;

class TypeInfoTest extends TestCase
{
    public function testBool()
    {
        $v = BooleanType::create()->jsonSerialize(true);
        $this->assertSame($v, 'true');

        $x = BooleanType::create()->jsonDeserialize($v);
        $this->assertSame($x, true);
        $this->assertSame(gettype($x), 'boolean');
    }

    public function testInt()
    {
        $v = NumberType::create()->jsonSerialize(45);
        $this->assertSame($v, '45');

        $x = NumberType::create()->jsonDeserialize($v);
        $this->assertSame($x, 45);
        $this->assertSame(gettype($x), 'integer');
    }

    public function testFloat()
    {
        $v = NumberType::create()->jsonSerialize(45.7);
        $this->assertSame($v, '45.7');

        $x = NumberType::create()->jsonDeserialize($v);
        $this->assertSame($x, 45.7);
        $this->assertSame(gettype($x), 'double');
    }

    public function testString()
    {
        $v = StringType::create()->jsonSerialize('abc');
        $this->assertSame($v, '"abc"');

        $x = StringType::create()->jsonDeserialize($v);
        $this->assertSame($x, 'abc');
        $this->assertSame(gettype($x), 'string');
    }

    public function testIntArray()
    {
        $v = NumberType::create()->createArray()->jsonSerialize([1, 2]);
        $this->assertSame($v, '[1,2]');

        $x = NumberType::create()->createArray()->jsonDeserialize($v);
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
        $v = MainSampleClass::createClassType()->jsonSerialize($s);
        $this->assertSame('{"a":1,"b":[[["a"],null]],"CCC":[3],"sub":{"a":0},"subArray":[]}', $v);

        /**
         * @var MainSampleClass $x
         */
        $x = MainSampleClass::createClassType()->jsonDeserialize($v);
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
        $v = MainSampleClass::createClassType()->jsonSerialize($s);
        $this->assertSame($v, '{"a":0,"b":[],"CCC":[],"sub":{"a":0},"subArray":[]}');

        /**
         * @var MainSampleClass $x
         */
        $x = MainSampleClass::createClassType()->jsonDeserialize($v);
        $this->assertSame($x->a, 0);
        $this->assertSame($x->b, []);
        $this->assertSame($x->c, []);
        $this->assertSame($x->d, null);
        $this->assertSame($x->subArray, []);
    }

    public function testDateTime()
    {
        $s = new DateTime('2017-01-18T18:23:32.708000Z');

        $x = DateTimeType::create()->jsonSerialize($s);
        $this->assertSame('"2017-01-18T18:23:32.708000Z"', $x);

        $m = DateTimeType::create()->jsonDeserialize($x);
        $this->assertEquals($s, $m);
    }

    public function testDateInterval()
    {
        $s = new DateInterval('P1Y2M3DT4H5M6S');

        $x = DateIntervalType::create()->jsonSerialize($s);
        $this->assertSame('"P1Y2M3DT4H5M6S"', $x);

        $m = DateIntervalType::create()->jsonDeserialize($x);
        $this->assertEquals($s, $m);
    }

    public function testLongTypeInfo()
    {
        $s = '12';

        $x = LongType::create()->deserialize($s);
        $this->assertEquals($x, '12');

        $r = LongType::create()->jsonSerialize('345');
        $this->assertEquals($r, '345');

        $ra = LongType::create()->jsonSerialize(345);
        $this->assertEquals($ra, '345');
    }

    public function testArrayWithNulls()
    {
        $s = [ null, new MainSampleClass(null, [[[null, 'a']]], [3]) ];

        $v = MainSampleClass::createClassType()->createArray()->jsonSerialize($s);
        $this->assertSame('[null,{"a":0,"b":[[[null,"a"]]],"CCC":[3],"sub":{"a":0},"subArray":[]}]', $v);

        /**
         * @var MainSampleClass[] $y
         */
        $y = MainSampleClass::createClassType()->createArray()->jsonDeserialize($v);
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
        $o = NullType::create()->createArray()->jsonSerialize($x);
        $this->assertSame($o, '[]');
        $type = NullType::create()->createArray();
        $result = $type->jsonDeserialize($o);
        $this->assertSame($result, []);
    }

    public function testDictionary() {
        $x = ['api-version' => 3];
        /**
         * @var \stdClass $o
         */
        $o = NumberType::create()->createMap()->jsonSerialize($x);
        $this->assertSame($o, '{"api-version":3}');
        $type = StringType::create()->createMap();
        $result = $type->jsonDeserialize($o);
        $this->assertSame($result['api-version'], 3);
    }

    public function testEmptyDictionary() {
        $x = [];
        /**
         * @var \stdClass $o
         */
        $o = StringType::create()->createMap()->jsonSerialize($x);
        $this->assertSame($o, '{}');
        $type = StringType::create()->createMap();
        $result = $type->jsonDeserialize($o);
        $this->assertEquals($result, []);
    }

    public function testNullDictionary() {
        $type = StringType::create()->createMap();
        $result = $type->deserialize(null);
        $this->assertNull($result);
    }

    public function testDeserializeParam() {
        $params = new \stdClass();
        $params->a = 23;
        $value = StringType::create()->deserializeParam($params, 'a');
        $this->assertSame(23, $value);
    }
}
