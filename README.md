# restapi-core-php-poc

REST API Core for PHP (Proof of concept)

[![Build Status](https://travis-ci.org/sergey-shandar/restapi-core-php-poc.svg?branch=master)](https://travis-ci.org/sergey-shandar/restapi-core-php-poc)

[Composer Package](https://packagist.org/packages/sergey-shandar/restapi-core-php-poc).

# Required Windows Extensions

- `php_mbstring.dll`
- `php_openssl.dll`

# Conventions

Every data class should implement

1. A default constructor.
2. A `createClassInfo` static function which returns `ClassTypeInfo`.
 
For example

```php
<?php

use RestApiCore\ClassTypeInfo;
use RestApiCore\PrimitiveTypeInfo;
use RestApiCore\PropertyInfo;

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
        $this->a = $a !== null ? $a : 0;
        $this->b = $b !== null ? $b : [];
        $this->c = $c !== null ? $c : [];
        $this->d = $d;
        $this->sub = $sub !== null ? $sub : new SampleSubClass();
        $this->subArray = $subArray !== null ? $subArray : [];
    }

    /**
     * @return ClassTypeInfo
     */
    public static function createClassInfo()
    {
        return new ClassTypeInfo(
            self::class,
            [
                new PropertyInfo('a', 'a', PrimitiveTypeInfo::create()),
                new PropertyInfo('b', 'b', PrimitiveTypeInfo::create()->createArray()->createArray()->createArray()),
                new PropertyInfo('c', 'CCC', PrimitiveTypeInfo::create()->createArray()),
                new PropertyInfo('d', 'd', PrimitiveTypeInfo::create()),
                new PropertyInfo('sub', 'sub', SampleSubClass::createClassInfo()),
                new PropertyInfo('subArray', 'subArray', SampleSubClass::createClassInfo()->createArray()),
            ]);
    }
}
```