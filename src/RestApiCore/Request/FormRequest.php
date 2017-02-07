<?php
namespace RestApiCore\Request;

final class FormRequest extends FormDataRequest
{
    /**
     * @return array
     */
    public function getOptions()
    {
        return [ 'form_params' => $this->parameters ];
    }
}