#!/usr/bin/php
<?php

if (php_sapi_name() != "cli") {
    exit ('CLI only.');
}

include ('vendor/autoload.php');
$client = new GuzzleHttp\Client();
$jar = new GuzzleHttp\Cookie\CookieJar();
$fetcher = new p33rs\Fetcher($client, $jar);
$scraper = new p33rs\ElectricPermitScraper($fetcher);

$options = getopt('', ['block:', 'lot:']);
if (empty($options['block']) || empty($options['lot'])) {
    exit ("Usage: php " . $argv[0] . " --block \033[4mblock number\033[0m --lot \033[4mlot number\033[0m \n");
}

$result = $scraper->fetch($options);

echo 'Result: ' . json_encode($result, JSON_PRETTY_PRINT) . "\n";