<?php
namespace Json\Rpc;

use PHPUnit\Framework\TestCase;
use RestApiCore\Json\Rpc\StdIoServer;

class StdIoServerTest extends TestCase
{
    public function testRead()
    {
        $input = fopen('php://memory', 'r+');
        fwrite($input, StdIoServer::createMessage('{"method":"my","params":{}}'));
        fseek($input, 0);

        $message = StdIoServer::readMessage($input);

        $this->assertSame('my', $message->method);
        $this->assertEquals(new \stdClass(), $message->params);
    }

    public function testReadEmpty()
    {
        $input = fopen('php://memory', 'r+');
        fwrite($input, 'saaslkjlkjasj lksdjfl;jsdf;lsajf;lsjdf' . StdIoServer::EOL);
        fwrite($input, StdIoServer::createMessage('{"method":"my","params":{}}'));
        fseek($input, 0);

        $message = StdIoServer::readMessage($input);

        $this->assertNull($message);
    }

    public function testCall()
    {
        $input = fopen('php://memory', 'r+');
        fwrite($input, StdIoServer::createMessage('{"method":"my","params":{}}'));
        fseek($input, 0);

        $server = new MockServer('my', new \stdClass, '45');

        $response = StdIoServer::call($server, $input);

        $expected =
            'Content-Length:14' . StdIoServer::EOL .
            StdIoServer::EOL .
            '{"result":45}' . StdIoServer::EOL;

        $this->assertSame($expected, $response);
    }

    public function testCallScan()
    {
        $input = fopen('php://memory', 'r+');
        fwrite($input, 'saaslkjlkjasj lksdjfl;jsdf;lsajf;lsjdf' . StdIoServer::EOL);
        fwrite($input, StdIoServer::createMessage('{"method":"my","params":{"a":"xxx"}}'));
        fseek($input, 0);

        $object = new \stdClass;
        $object->a = 'xxx';
        $server = new MockServer('my', $object, '[45]');

        $response = null;
        do {
            $response = StdIoServer::call($server, $input);
        } while ($response === null);

        $expected =
            'Content-Length:16' . StdIoServer::EOL .
            StdIoServer::EOL .
            '{"result":[45]}' . StdIoServer::EOL;

        $this->assertSame($expected, $response);
    }
}