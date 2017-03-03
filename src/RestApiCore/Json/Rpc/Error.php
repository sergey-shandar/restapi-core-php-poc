<?php
namespace RestApiCore\Json\Rpc;

final class Error extends \Exception
{
    const PARSE_ERROR = -32700;
    const INVALID_REQUEST = -32600;
    const METHOD_NOT_FOUND = -32601;
    const INVALID_PARAMS = -32602;
    const INTERNAL_ERROR = -32603;

    const SERVER_ERROR_FIRST = -32000;

    /**
     * @var mixed
     */
    public $data;

    /**
     * JsonRpcError constructor.
     *
     * @param string $message
     * @param int $code
     * @param mixed|null $data
     */
    public function __construct($message, $code, $data = null)
    {
        parent::__construct($message, $code);
        $this->data = $data;
    }

    /**
     * @param string $method
     *
     * @return Error
     */
    public static function methodNotFound($method)
    {
        return new self('"'.$method.'" not found', self::METHOD_NOT_FOUND);
    }
}