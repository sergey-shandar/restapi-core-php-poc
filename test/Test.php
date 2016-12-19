<?php

use RestApiCore\Core;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public function testInt()
    {
        Core::serialize(5);
    }
}
