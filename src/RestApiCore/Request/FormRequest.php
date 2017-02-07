<?php
namespace RestApiCore\Request;

final class FormRequest extends Request
{
    /**
     * @var array $formParams
     */
    public $formParams = [];

    /**
     * @return array
     */
    public function getOptions()
    {
        return [ 'form_params' => $this->formParams ];
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return [];
    }
}