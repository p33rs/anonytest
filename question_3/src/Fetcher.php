<?php
namespace p33rs;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class Fetcher
{

    /** @var CookieJar */
    private $jar;

    /** @var Client */
    private $guzzle;

    public function __construct (Client $guzzle, CookieJar $jar)
    {
        $this->jar = $jar;
        $this->guzzle = $guzzle;
    }



}