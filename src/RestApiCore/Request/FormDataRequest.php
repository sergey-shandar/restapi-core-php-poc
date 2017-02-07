<?php
namespace RestApiCore\Request;

abstract class FormDataRequest extends Request
{
    /**
     * @var array
     */
    public $parameters = [];
}