#!/usr/bin/php
<?php

include ('theRuns.php');

if (php_sapi_name() != "cli") {
    exit ('CLI only.');
} elseif (empty($argv[1])) {
    exit ("Usage: php " . $argv[0] . " \033[4minput file\033[0m \n");
} elseif (!file_exists((string) $argv[1])) {
    exit("File not found: " . (string) $argv[1] . "\n");
}

/** @var int[] $input */
$input = include($argv[1]);
if (!is_array($input)) {
    exit("Input was not a valid array.\n");
}

echo 'Result: ' . json_encode(theRuns($input)) . "\n";