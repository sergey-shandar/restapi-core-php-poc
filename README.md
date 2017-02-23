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

# Supported Types

- `LongType` deserialized as a `string`.
- `DateIntervalType` deserialized as a `\DateInterval`.
- `DateTimeType` deserialized as a `\DateTime`.
- `PrimitiveType` deserialized as a `boolean`, `int`, `float`. 
- `ArrayType` deserialized as an `array`.
- `MapType` deserialized as a `stdClass`.
- `ClassType` deserialized as a user class.

# Conventions

Each user class should implement

1. A default constructor.
2. A `createClassInfo` static function which returns `ClassTypeInfo`.
 
For example

```php
<?php
use \RestApiCore\Type\ClassType;
use \RestApiCore\Type\PrimitiveType;
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
    public static function createClassInfo()
    {
        return new ClassType(
            self::class,
            [
                new PropertyInfo('a', 'a', PrimitiveType::create()),
                new PropertyInfo('b', 'b', PrimitiveType::create()->createArray()->createArray()->createArray()),
                new PropertyInfo('c', 'CCC', PrimitiveType::create()->createArray()),
                new PropertyInfo('d', 'd', PrimitiveType::create()),
                new PropertyInfo('sub', 'sub', SampleSubClass::createClassInfo()),
                new PropertyInfo('subArray', 'subArray', SampleSubClass::createClassInfo()->createArray()),
            ]);
    }
}
```
