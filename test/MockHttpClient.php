<?php

use RestApiCore\HttpClient;

class MockHttpClient implements HttpClient
{

    /**
     * @return mixed
     */
    function request()
    {
        return null;
    }
}