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
    /** @var int $tally */
    $tally = 0;
    foreach ($input as $key => $value) {
        if (!is_int($value)) {
            throw new \Exception('expected integer array');
        }
        if (!$key) {
            continue;
        }

        // This is nice but doesn't account for overlap.
        /*

 0    1
 1    1
 2    3         v
 3    5         v
 4    6  add 3  v  ^
 5    8            ^
 6    10           ^
 7    11 add 6  v  ^
 8    10        v
 9    9         v
10    8  add 7  v  ^
11    9            ^
12    10           ^
13    11 add 10    ^
14    7

         */
        if ($tally <= 0 && $value - 1 == $input[$key - 1]) {
            echo '$key = ' . $key . ', decr' . "\n";
            $tally--;
        } elseif ($tally >= 0 && $value + 1 == $input[$key - 1]) {
            echo '$key = ' . $key . ', incr' . "\n";
            $tally++;
        } else {
            echo '$key = ' . $key . ', reset';
            $abs = abs($tally);
            if ($abs) {
                $result[] = $key - $abs;
                echo ' and add ' . ($key - $abs) . ' to results';
            }
            echo "\n";
            $tally = 0;
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