<?php

use Pdftk\Pdftk;

class PdftkTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {

    }

    /**
     * @expectedException \Exception
     */
    public function testSetBinary()
    {
        $object = new Pdftk();
        $object->setBinary('foo');
    }
}