<?php

use Pdftk\File\Input;

class InputTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {

    }

    /**
     * @expectedException \Exception
     */
    public function testSetFilename()
    {
        $object = new Input();
        $object->setFilename('./tests/pdfs/missing.pdf');
    }
}