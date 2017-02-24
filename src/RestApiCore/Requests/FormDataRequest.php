<?php
namespace RestApiCore\Requests;

abstract class FormDataRequest extends Request
{
    /**
     * @var array
     */
    public $parameters = [];
}