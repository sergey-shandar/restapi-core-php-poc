<?php
namespace RestApiCore;


interface HttpClient
{
    /**
     * @return mixed
     */
    function request();
}