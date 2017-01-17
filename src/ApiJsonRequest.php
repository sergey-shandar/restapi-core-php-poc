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
        $raw = TypeInfo::serialize($this->body);
        return json_encode($raw);
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
        return [ 'Content-Type' => $this->contentType ];
    }
}