<?php
namespace RestApiCore\Json\Rpc;

/**
 * A JSON RPC server interface.
 */
interface Server
{
    /**
     * @param string $method
     * @param \stdClass $params
     *
     * @return string
     */
    public function call($method, \stdClass $params);
}