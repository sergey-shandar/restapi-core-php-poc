<?php
namespace RestApiCore\JsonRpc;

interface Server
{
    /**
     * @param string $operationId
     * @param \stdClass $params
     *
     * @return mixed
     */
    public function call($operationId, \stdClass $params);
}