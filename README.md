# restapi-core-php-poc

REST API Core for PHP (Proof of concept)

[![Build Status](https://travis-ci.org/sergey-shandar/restapi-core-php-poc.svg?branch=master)](https://travis-ci.org/sergey-shandar/restapi-core-php-poc)

[![Latest Unstable Version](https://poser.pugx.org/sergey-shandar/restapi-core-php-poc/v/unstable)](https://packagist.org/packages/sergey-shandar/restapi-core-php-poc)

# Supported Run Times

- PHP 5.6
- PHP 7.0
- PHP 7.1
- HHVM 3.3

# Required Windows Extensions

- `php_mbstring.dll`
- `php_openssl.dll`

# Supported Request Types

|Class Name                 |Content-Type                       |
|---------------------------|-----------------------------------|
|`Requests\JsonRequest`     |`application/json`                 |
|`Requests\FormRequest`     |`application/x-www-form-urlencoded`|
|`Requests\MultiPartRequest`|`multipart/form-data`              |

# Serialization

## Supported Types

|Reflection Type         |PHP Type       |PHP JSON Type|Swagger Type|Swagger Format|
|------------------------|---------------|-------------|------------|--------------|
|`Types\StringType`      |`string`       |`string`     |`string`    |              |
|`Types\BooleanType`     |`boolean`      |`boolean`    |`boolean`   |              |
|`Types\NumberType`      |`int`          |`int`        |`integer`   |`int32`       |
|                        |`float`        |`float`      |`number`    |`float`       |
|                        |               |             |            |`double`      |
|`Types\LongType`        |`string`       |`string`     |`integer`   |`int64`       |
|`Types\DateTimeType`    |`\DateTime`    |`string`     |`string`    |`date-time`   |
|`Types\DateIntervalType`|`\DateInterval`|`string`     |`string`    |`duration`    |
|`Types\ArrayType`       |`T[]`          |`T[]`        |`array`     |              |
|`Types\MapType`         |`T[]`          |`\stdClass`  |`object`    |              |
|`Types\ClassType`       |`UserClass`    |`\stdClass`  |`object`    |              |

# JSON

- Serialization: PHP User's Object => string
- Deserialization: string => PHP Object => PHP User's Object

# Conventions

Each user class should implement

1. A default constructor.
2. A `createClassType` static function which returns `\RestApiCore\Types\ClassType`.
 
For example

```php
<?php
use \RestApiCore\Types\ClassType;
use \RestApiCore\Types\NumberType;
use \RestApiCore\Types\StringType;
use \RestApiCore\PropertyInfo;

class SampleClass
{
    /**
     * @var int $a
     */
    public $a;

    /**
     * @var string[][][] $b
     */
    public $b;

    /**
     * @var int[] $c
     */
    public $c;

    /**
     * An optional parameter.
     *
     * @var string|null $d
     */
    public $d;

    /**
     * @var SampleSubClass $sub
     */
    public $sub;

    /**
     * @var SampleSubClass[] $subArray
     */
    public $subArray;

    /**
     * SampleClass constructor.
     *
     * @param int|null $a
     * @param string[][][]|null $b
     * @param int[]|null $c
     * @param string|null $d
     * @param SampleSubClass|null $sub
     * @param SampleSubClass[]|null $subArray
     */
    public function __construct(
        $a = null, array $b = null, array $c = null, $d = null, $sub = null, array $subArray = null)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
        $this->d = $d;
        $this->sub = $sub;
        $this->subArray = $subArray;
    }

    /**
     * @return ClassType
     */
    public static function createClassType()
    {
        return new ClassType(
            self::class,
            [
                new PropertyInfo('a', 'a', NumberType::create()),
                new PropertyInfo('b', 'b', StringType::create()->createArray()->createArray()->createArray()),
                new PropertyInfo('c', 'CCC', NumberType::create()->createArray()),
                new PropertyInfo('d', 'd', StringType::create()),
                new PropertyInfo('sub', 'sub', SampleSubClass::createClassType()),
                new PropertyInfo('subArray', 'subArray', SampleSubClass::createClassType()->createArray()),
            ]);
    }
}
```
