# restapi-core-php-poc

REST API Core for PHP (Proof of concept)

[![Build Status](https://travis-ci.org/sergey-shandar/restapi-core-php-poc.svg?branch=master)](https://travis-ci.org/sergey-shandar/restapi-core-php-poc)

[![Latest Unstable Version](https://poser.pugx.org/sergey-shandar/restapi-core-php-poc/v/unstable)](https://packagist.org/packages/sergey-shandar/restapi-core-php-poc)

# Supported Run Times

- PHP 5.6
- PHP 7.0
- PHP 7.1
- HHVM 3.6

# Required Windows Extensions

- `php_mbstring.dll`
- `php_openssl.dll`

# Supported Request Types

|Class Name                 |Content-Type                       |
|---------------------------|-----------------------------------|
|`Requests\JsonRequest`     |`application/json`                 |
|`Requests\FormRequest`     |`application/x-www-form-urlencoded`|
|`Requests\MultiPartRequest`|`multipart/form-data`              |

# Reflection

## Supported Types

|Reflection Type Info |PHP Type       |PHP JSON Type|Swagger Type|Swagger Format|
|---------------------|---------------|-------------|------------|--------------|
|`StringInfo`         |`string`       |`string`     |`string`    |              |
|`BooleanInfo`        |`boolean`      |`boolean`    |`boolean`   |              |
|`NumberInfo`         |`int`          |`int`        |`integer`   |`int32`       |
|                     |`float`        |`float`      |`number`    |`float`       |
|                     |               |             |            |`double`      |
|`LongInfo`           |`string`       |`string`     |`integer`   |`int64`       |
|`DateTimeInfo`       |`\DateTime`    |`string`     |`string`    |`date-time`   |
|`DateIntervalInfo`   |`\DateInterval`|`string`     |`string`    |`duration`    |
|`ArrayInfo`          |`T[]`          |`T[]`        |`array`     |              |
|`MapInfo`            |`T[]`          |`\stdClass`  |`object`    |              |
|`ClassInfo`          |`UserClass`    |`\stdClass`  |`object`    |              |

# JSON

- Serialization: PHP Type => string
- Deserialization: string => PHP JSON Type => PHP Type

# Conventions

Each user class should implement

1. A default constructor.
2. A `createClassInfo` static function which returns `\RestApiCore\Reflection\Types\ClassInfo`.
 
For example

```php
<?php
use \RestApiCore\Reflection\Types\ClassInfo;
use \RestApiCore\Reflection\Types\NumberInfo;
use \RestApiCore\Reflection\Types\StringInfo;

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
     * @return ClassInfo
     */
    public static function createClassInfo()
    {
        return ClassInfo::create(self::class)
            ->withProperty('a', 'a', NumberInfo::create())
            ->withProperty('b', 'b', StringInfo::create()->createArray()->createArray()->createArray())            
            ->withProperty('c', 'CCC', NumberInfo::create()->createArray())
            ->withProperty('d', 'd', StringInfo::create())
            ->withProperty('sub', 'sub', SampleSubClass::createClassType())
            ->withProperty('subArray', 'subArray', SampleSubClass::createClassType()->createArray());
    }
}
```
