<?php
namespace RestApiCore\Json\Rpc;

use RestApiCore\Json\Common;
use RestApiCore\Json\FromObject;

/**
 * Class StdIoServer
 *
 * See https://github.com/Microsoft/language-server-protocol/blob/master/protocol.md
 *
 * @package RestApiCore\Json\Rpc
 */
final class StdIoServer
{
    const CONTENT_LENGTH = 'Content-Length';

    const EOL = "\n";

    /**
     * @param string|resource $input
     *
     * @return mixed|null
     */
    public static function readMessage($input)
    {
        $line = fgets($input);
        $values = explode(':', $line);
        if (count($values) !== 2 || trim($values[0]) !== self::CONTENT_LENGTH) {
            return null;
        }
        $length = intval(trim($values[1]));

        // read one empty line.
        while (trim(fgets($input)) !== '') {}

        $json = fread($input, $length);
        return Common::decode($json);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public static function createMessage($value)
    {
        $newValue = $value . self::EOL;
        return
            self::CONTENT_LENGTH . ':' . strlen($newValue) . self::EOL
            . self::EOL
            . $newValue;
    }

    /**
     * @param Server $server
     * @param string|resource $input
     *
     * @return string|null
     */
    public static function call(Server $server, $input)
    {
        $message = self::readMessage($input);

        if ($message === null) {
            return null;
        }

        /**
         * @var string
         */
        $method = $message->method;
        /**
         * @var \stdClass
         */
        $params = $message->params;

        $result = $server->call($method, $params);

        $response = new FromObject();
        $response->appendJson('result', $result);

        return self::createMessage($response->get());
    }
}