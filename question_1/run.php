#!/usr/bin/php
<?php

if (php_sapi_name() != "cli") {
    exit ('CLI only.');
} elseif (empty($argv[1])) {
    exit ("Usage: php ". $argv[0] ." \033[4minput file\033[0m \n");
} elseif (!file_exists((string) $argv[1])) {
    exit("File not found: " . (string) $argv[1] . "\n");
}

require_once('autoload.php');
$input = explode("\n", file_get_contents($argv[1]));
echo json_encode(Zone::parseCodes($input), JSON_PRETTY_PRINT);