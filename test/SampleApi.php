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
     * @param MainSampleClass $sampleClass
     *
     * @return MainSampleClass
     */
    public function test(MainSampleClass $sampleClass)
    {
        return $this->client->request(MainSampleClass::createClassInfo(), '', '', ['a' => 13], [], $sampleClass);
    }
}