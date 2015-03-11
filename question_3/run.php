#!/usr/bin/php
<?php

include ('vendor/autoload.php');

$lookup = new \p33rs\SFDBI(new GuzzleHttp\Client());
$result = 'lol';

echo 'Result: ' . json_encode($result, JSON_PRETTY_PRINT) . "\n";
