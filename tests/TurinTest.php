<?php
class TurinTest extends PHPUnit_Framework_TestCase
{
    public function testSimple()
    {
    	$parser = new \Turin\Parser('examples/simple.turin');

    	$expected = file_get_contents('examples/simple.php');

		$this->assertEquals($parser->toPhp(), $expected);
    }

/*
    public function testLady()
    {
    	$parser = new \Turin\Parser('examples/lady.turin');

    	$expected = file_get_contents('examples/lady.php');

		$this->assertEquals($parser->toPhp(), $expected);
    }
    */
}
