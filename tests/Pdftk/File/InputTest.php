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
    public function testSetFilenameError()
    {
        $object = new Input();
        $object->setFilename('./tests/pdfs/missing.pdf');
    }

    public function testSetFilename()
    {
        $object = new Input();
        $object->setFilename('./tests/pdfs/example.pdf');
        $this->assertEquals($object->getFilename(), './tests/pdfs/example.pdf');
    }

    public function testSetPassword()
    {
        $object = new Input();
        $this->assertEquals($object->setPassword('foobar'), $object);
        $this->assertEquals($object->getPassword(), 'foobar');
    }

    public function testSetStartPage()
    {
        $object = new Input();
        $this->assertEquals($object->setStartPage(2), $object);
    }
    
    public function testSetEndPage()
    {
        $object = new Input();
        $this->assertEquals($object->setEndPage(2), $object);
    }

    public function testSetOverride()
    {
        $object = new Input();
        $this->assertEquals($object->setOverride(true), $object);
        $this->assertEquals($object->setOverride(false), $object);
    }

    public function testSetRotation()
    {
        $object = new Input();
        $this->assertEquals($object->setRotation(90), $object);
        $this->assertEquals($object->setRotation(180), $object);
    }

    public function testSetAlternate()
    {
        $object = new Input();
        $this->assertEquals($object->setAlternate('even'), $object);
        $this->assertEquals($object->setAlternate('odd'), $object);
    }
}