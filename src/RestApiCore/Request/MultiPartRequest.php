<?php
namespace RestApiCore\Request;


final class MultiPartRequest extends Request
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