<?php
namespace Json\Rpc;

use PHPUnit\Framework\TestCase;
use RestApiCore\Json\Rpc\Server;

class MockServer implements Server
{
    /**
     * @var string
     */
    public $method;

    /**
     * @var \stdClass
     */
    public $params;

    /**
     * @var string
     */
    public $result;

    public function __construct($method, $params, $result)
    {
        $this->method = $method;
        $this->params = $params;
        $this->result = $result;
    }

    /**
     * @param string $method
     * @param \stdClass $params
     *
     * @return string
     */
    public function call($method, \stdClass $params)
    {
        TestCase::assertSame($this->method, $method);
        TestCase::assertEquals($this->params, $params);
        return $this->result;
    }
}
