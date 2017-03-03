<?php
namespace RestApiCore\Json\Rpc;

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