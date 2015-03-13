<?php
namespace p33rs;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Message\Request;

class Fetcher
{

    /** @var CookieJar */
    private $jar;

    /** @var Client */
    private $guzzle;

    public function __construct (Client $guzzle, CookieJar $jar)
    {
        $this->setJar($jar);
        $this->guzzle = $guzzle;
    }

    public function fetch ($url, $type = 'POST', array $data = [])
    {
        $options = [ 'body' => $data ];
        if ($this->jar) {
            $options += ['cookies' => $this->jar];
        }
        $request = $this->guzzle->createRequest($type, $url, $options);
        return (string) $this->guzzle->send($request)->getBody();
    }

    public function getJar() {
        return $this->jar;
    }

    public function setJar(CookieJar $jar = null) {
        $this->jar = $jar;
        return $this;
    }

}