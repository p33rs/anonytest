<?php
/**
 * Treating this as if it's a static utility method in a Model class.
 * Wasn't 100% sure on how to interpret the given ranges,
 *   so made notes on what I'm attempting to match.
 * Regex is maybe overkill for the simple strings ("PARK"), but specifying
 *   a match type ("regex" or "equals") as well as additional options
 *   seems like unnecessary complexity
 */
class Zone {

    /** @var string */
    const NOT_FOUND = 'Not found';

    /** @var array[] */
    private static $codes = [
        // easy ones first
        [
            'name' => 'Battery Park City',
            'pattern' => '/^BPC$/',
        ],
        [
            'name' => 'New York City Parks',
            'pattern' => '/^PARK$/',
        ],
        [
            'name' => 'New York State Parks',
            'pattern' => '/^PARKNYS$/',
        ],
        [
            'name' => 'United States Parks',
            'pattern' => '/^PARKUS$/',
        ],
        [
            'name' => 'Zoning Not Applicable',
            'pattern' => '/^ZNA$/',
        ],
        [
            'name' => 'Special Zoning District',
            'pattern' => '/^ZR 11\-151$/',
        ],
        // the letter r followed by a number 1-10 and either
        //   - another number
        //   - a letter, A-H
        [
            'name' => 'General Residence Districts',
            'pattern' => '/^R([1-9]|10)(\-([1-9]|10)|[A-H])$/',
        ],
        // the letter c followed by either
        //   - a number 1-7, then a number 1-6
        //   - the number 8, then a number 1-4
        [
            'name' => 'Commercial Districts',
            'pattern' => '/^C([1-7]\-[1-6]|8\-[1-4])$/',
        ],
        // the letter M followed by a number 1-3 followed by a number 1-2
        [
            'name' => 'Manufacturing Districts',
            'pattern' => '/^M[1-3]\-(1|2)$/',
        ],
        // "M1-" followed by a number 1-6, then "/R", then a number 5-10
        [
            'name' => 'Mixed Manufacturing & Residential Districts',
            'pattern' => '/^M1\-[1-6]\/R([5-9]|10)$/',
        ],
    ];

    /**
     * @param string[] $codes
     * @return string
     */
    public static function parseCodes(array $codes = []) {
        $result = [];
        foreach ($codes as $code) {
            $result[] = [
                'code' => $code,
                'description' => self::check($code)
            ];
        }
        return [ 'codes' => $result ];
    }

    /**
     * @param $str
     * @return string
     */
    private static function check($str)
    {
        foreach (self::$codes as $code) {
            if (preg_match($code['pattern'], $str)) {
                return $code['name'];
            }
        }
        return self::NOT_FOUND;
    }

}