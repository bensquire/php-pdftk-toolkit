<?php

use Pdftk\Pdftk;

class PdftkTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {

    }

    public function testConstructor()
    {
        $params = array(
            'owner_password' => 'foo',
            'user_password' => 'bar',
            'encryption_level' => 128,
            'verbose_mode' => true,
            'ask_mode' => false,
            'compress' => true,
        );

        $object = new Pdftk($params);
        $this->assertTrue($object->getCompress());
        $this->assertFalse($object->getAskMode());
        $this->assertEquals($object->getEncryptionLevel(), 128);
    }

    /**
     * @expectedException \Exception
     */
    public function testSetBinary()
    {
        $object = new Pdftk();
        $object->setBinary('foo');
    }

    /**
     * @expectedException \Exception
     */
    public function testSetEncryptionLevelError()
    {
        $object = new Pdftk();
        $object->setEncryptionLevel('foo');
    }

    public function testSetEncryptionLevel()
    {
        $object = new Pdftk();
        $this->assertEquals($object->setEncryptionLevel(128), $object);
        $this->assertEquals($object->getEncryptionLevel(), 128);
    }

    public function testSetUserPassword()
    {
        $object = new Pdftk();
        $this->assertEquals($object->setUserPassword('fooball'), $object);
        $this->assertEquals($object->getUserPassword(), 'fooball');
    }

    public function testSetOwnerPassword()
    {
        $object = new Pdftk();
        $this->assertEquals($object->setOwnerPassword('fooball'), $object);
        $this->assertEquals($object->getOwnerPassword(), 'fooball');
    }

    public function testSetVerboseMode()
    {
        $object = new Pdftk();
        $this->assertEquals($object->setVerboseMode(true), $object);
        $this->assertTrue($object->getVerboseMode());

        $this->assertEquals($object->setVerboseMode(false), $object);
        $this->assertFalse($object->getVerboseMode());
    }

    /**
     * @expectedException \Exception
     */
    public function testSetVerboseModeError()
    {
        $object = new Pdftk();
        $object->setVerboseMode('blah');
    }

    /**
     * @expectedException \Exception
     */
    public function testSetAskModeError()
    {
        $object = new Pdftk();
        $object->setAskMode('blah');
    }

    public function testSetAskMode()
    {
        $object = new Pdftk();
        $this->assertEquals($object->setAskMode(true), $object);
        $this->assertTrue($object->getAskMode());
    }

    //TODO: Improve function validation
    public function testSetOutputFile()
    {
        $object = new Pdftk();
        $this->assertEquals($object->setOutputFile('/this/needs/validateing'), $object);
        $this->assertEquals($object->getOutputFile(), '/this/needs/validateing');
    }

    //TODO: Add validation to function
    public function testSetCompress()
    {
        $object = new Pdftk();
        $this->assertEquals($object->setCompress(true), $object);
        $this->assertEquals($object->getCompress(), true);

        $this->assertEquals($object->setCompress(false), $object);
        $this->assertEquals($object->getCompress(), false);
    }

    //TODO: This function requires further validation
    public function testSetInputFile()
    {
        $params = array(
            'filename' => './tests/pdfs/example.pdf',
            'password' => 'madeup',
            'start_page' => 1,
            'end_page' => 1,
            'alternate' => 'even',
            'rotation' => 0
        );

        $inputFile = new \Pdftk\File\Input($params);

        $object = new Pdftk();
        $this->assertEquals($object->setInputFile($params), $object);
        $this->assertEquals($object->setInputFile($inputFile), $object);


        $this->assertEquals(count($object->getInputFile()), 2);
    }
}