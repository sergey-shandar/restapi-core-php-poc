<?php
namespace RestApiCore\Requests;

abstract class FormDataRequest extends Request
{
    /**
     * @var array
     */
    public $parameters = [];

    /**
     * @return null
     */
    public function getBody()
    {
        return null;
    }

    /**
     * @return string[]
     */
    public function getHeaders()
    {
        return [];
    }
}