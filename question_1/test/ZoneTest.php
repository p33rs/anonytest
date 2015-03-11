<?php
/**
 * Admittedly, I am not great at writing tests, but I'd like to be.
 * Bootstrap with autoload.php.
 */
class ZoneTest extends PHPUnit_Framework_TestCase {
    public function testExample()
    {
        $test = ['M3', 'R3-2', 'PARKNYS', 'M1-3/R9'];
        $this->assertEquals(
            [ 'codes' => [
                [ 'code' => 'M3', 'description' => 'Not found' ],
                [ 'code' => 'R3-2', 'description' => 'General Residence Districts' ],
                [ 'code' => 'PARKNYS', 'description' => 'New York State Parks' ],
                [ 'code' => 'M1-3/R9', 'description' => 'Mixed Manufacturing & Residential Districts' ],
            ]],
            Zone::parseCodes($test)
        );
    }
}