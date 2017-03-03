<?php
namespace JsonRpc;

use PHPUnit\Framework\TestCase;
use RestApiCore\JsonRpc\Error;

class ErrorTest extends TestCase
{
    public function testConstructor()
    {
        try {
            throw new Error("Unknown method", Error::METHOD_NOT_FOUND);
        } catch (Error $exception) {
            $this->assertInstanceOf(Error::class, $exception);
            $this->assertSame(-32601, $exception->getCode());
            $this->assertSame("Unknown method", $exception->getMessage());
        }
    }

    public function testMethodNotFound()
    {
        try {
            throw Error::methodNotFound("method");
        } catch (Error $exception) {
            $this->assertInstanceOf(Error::class, $exception);
            $this->assertSame(-32601, $exception->getCode());
        }
    }
}