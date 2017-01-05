<?php

use RestApiCore\Client;

class SampleApi
{
    /**
     * @var Client $_client
     */
    private $_client;

    /**
     * SampleApi constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->_client = $client;
    }

    /**
     * @param SampleClass $sampleClass
     * 
     * @return SampleClass
     */
    public function test(SampleClass $sampleClass)
    {
        return $this->_client->request('', '', [], [], [], $sampleClass);
    }
}