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

    /**
     * @param Client $guzzle
     * @param CookieJar $jar
     */
    public function __construct (Client $guzzle, CookieJar $jar)
    {
        $this->setJar($jar);
        $this->guzzle = $guzzle;
    }

    /**
     * @param string $url
     * @param string $type
     * @param array $data
     * @return string
     */
    public function fetch ($url, $type = 'POST', array $data = [])
    {
        $options = [ 'body' => $data ];
        if ($this->jar) {
            $options += ['cookies' => $this->jar];
        }
        $request = $this->guzzle->createRequest($type, $url, $options);
        return (string) $this->guzzle->send($request)->getBody();
    }

    /** @return CookieJar */
    public function getJar() {
        return $this->jar;
    }

    /**
     * @param CookieJar $jar
     * @return $this
     */
    public function setJar(CookieJar $jar = null) {
        $this->jar = $jar;
        return $this;
    }

}