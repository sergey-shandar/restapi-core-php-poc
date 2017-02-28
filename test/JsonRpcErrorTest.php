<?php

use PHPUnit\Framework\TestCase;
use RestApiCore\JsonRpcError;

class JsonRpcErrorTest extends TestCase
{
    public function testConstructor()
    {
        try {
            throw new JsonRpcError("Unknown method", JsonRpcError::METHOD_NOT_FOUND);
        } catch (JsonRpcError $exception) {
            $this->assertInstanceOf(JsonRpcError::class, $exception);
            $this->assertSame(-32601, $exception->getCode());
            $this->assertSame("Unknown method", $exception->getMessage());
        }
    }

    public function testMethodNotFound()
    {
        try {
            throw JsonRpcError::createMethodNotFound("method");
        } catch (JsonRpcError $exception) {
            $this->assertInstanceOf(JsonRpcError::class, $exception);
            $this->assertSame(-32601, $exception->getCode());
        }
    }
}