<?php
namespace RestApiCore;


final class ApiJsonRequest extends ApiRequest
{
    /**
     * @var string
     */
    public $contentType = ApiClient::APPLICATION_JSON;

    /**
     * @var mixed
     */
    public $body = '';

    /**
     * @return string
     */
    public function getBodyString() {
        return json_encode(TypeInfo::serialize($this->body));
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return [ 'ContentType' => $this->contentType ];
    }
}