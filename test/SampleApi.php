<?php

use RestApiCore\ApiClient;
use RestApiCore\Requests\JsonRequest;

class SampleApi
{
    /**
     * @var ApiClient $_client
     */
    private $client;

    /**
     * SampleApi constructor.
     *
     * @param ApiClient $client
     */
    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param MainSampleClass $sampleClass
     *
     * @return MainSampleClass
     */
    public function test(MainSampleClass $sampleClass)
    {
        $request = new JsonRequest();
        $request->queryParameters = ['a' => 13];
        $request->body = $sampleClass;
        return $this->client->request(MainSampleClass::createClassType(), $request);
    }
}