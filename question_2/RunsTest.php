<?php
// bootstrap with theRuns.php
class RunsTest extends PHPUnit_Framework_TestCase {
    public function testUp()
    {
        $test = [999, 1, 2, 999];
        $this->assertEquals(
            [1],
            theRuns($test)
        );
    }
    public function testDown()
    {
        $test = [999, 2, 1, 999];
        $this->assertEquals(
            [1],
            theRuns($test)
        );
    }
    public function testStart()
    {
        $test = [0, 1, 2, 999, 999];
        $this->assertEquals(
            [0],
            theRuns($test)
        );
    }
    public function testEnd()
    {
        $test = [999, 999, 0, 1, 2];
        $this->assertEquals(
            [2],
            theRuns($test)
        );
    }
    public function testOverlaps()
    {
        $test = [0, 1, 2, 1, 0, 1, 2];
        $this->assertEquals(
            [0, 2, 4],
            theRuns($test)
        );
    }
    public function testBadInput()
    {
        $this->setExpectedException('InvalidArgumentException');
        $test = [0, 1, 2, 'some more time in a dream', 'the hope to run out of steam'];
        theRuns($test);
    }
}