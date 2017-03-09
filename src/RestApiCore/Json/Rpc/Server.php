<?php
namespace RestApiCore\Json\Rpc;

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