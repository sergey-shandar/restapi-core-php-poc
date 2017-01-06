<?php

use RestApiCore\Client;

class SampleApi
{
    /**
     * @var Client $_client
     */
    private $client;

    /**
     * SampleApi constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param SampleClass $sampleClass
     *
     * @return SampleClass
     */
    public function test(SampleClass $sampleClass)
    {
        return $this->client->request(SampleClass::createClassInfo(), '', '', [], [], [], $sampleClass);
    }
}