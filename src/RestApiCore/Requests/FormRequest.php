<?php
namespace RestApiCore\Requests;

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