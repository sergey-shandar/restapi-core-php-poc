<?php
namespace RestApiCore\Request;

final class MultiPartRequest extends FormDataRequest
{
    /**
     * @return array
     */
    public function getOptions()
    {
        $multipart = [];
        foreach ($this->parameters as $key => $value)
        {
            $multipart[] = [ 'name' => $key, 'contents' => $value];
        }
        return [
            'multipart' => $multipart,
        ];
    }
}