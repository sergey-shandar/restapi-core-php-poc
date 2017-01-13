<?php
namespace RestApiCore;


final class ApiMultiPartRequest extends ApiRequest
{
    /**
     * @var array
     */
    public $formDataParameters = [];

    /**
     * @return null
     */
    public function getBodyString()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return ApiClient::MULTIPART_FORM_DATA;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        $multipart = [];
        foreach ($this->formDataParameters as $key => $value)
        {
            $multipart[] = [ 'name' => $key, 'contents' => $value];
        }
        return [
            'multipart' => $multipart,
        ];
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return [];
    }
}