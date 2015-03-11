#!/usr/bin/php
<?php

/**
 * @param int[] $input
 * @return int[]|null
 * @throws Exception
 */
function theRuns(array $input)
{
    $result = [];
    $up = 0;
    $down = 0;
    foreach ($input as $key => $value) {
        if (!is_int($value)) {
            throw new \Exception('expected integer array');
        }
        if (!$key) {
            continue;
        }

        if ($value - 1 == $input[$key - 1]) {
            $up++;
            echo $key . ": increments to ".$up."\n";
        } elseif ($up) {
            $result[] = $key - $up - 1;
            echo $key . ": increment ends at ".$up."\n";
            $up = 0;
        }

        if ($value + 1 == $input[$key - 1]) {
            $down++;
            echo $key . ": decrements to ".$down."\n";
        } elseif ($down) {
            $result[] = $key - $down - 1;
            echo $key . ": decrement ends at ".$down."\n";
            $down = 0;
        }
    };
    return $result ?: null;
}

if (empty($argv[1])) {
    exit ("Usage: php run.php \033[4minput file\033[0m \n");
} elseif (!file_exists((string) $argv[1])) {
    exit("File not found: " . (string) $argv[1] . "\n");
}

/** @var int[] $input */
$input = include($argv[1]);
if (!is_array($input)) {
    exit("Input was not a valid array.\n");
}

echo 'Result: ' . json_encode(theRuns($input));