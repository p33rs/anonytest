<?php

/**
 * @param int[] $input
 * @return int[]|null
 * @throws Exception
 */
function theRuns(array $input)
{
    $result = [];
    // two separate queues, since if you have [1,2,1,2] you get overlap
    $up = 0;
    $down = 0;
    foreach ($input as $key => $value) {
        if (!is_int($value)) {
            throw new \InvalidArgumentException('expected integer array');
        }

        if (isset($input[$key + 1]) && $value == $input[$key + 1] - 1) {
            $up++;
        } elseif ($up) {
            $result[] = $key - $up;
            $up = 0;
        }

        if (isset($input[$key + 1]) && $value == $input[$key + 1] + 1) {
            $down++;
        } elseif ($down) {
            $result[] = $key - $down;
            $down = 0;
        }
    };
    return $result ?: null;
}