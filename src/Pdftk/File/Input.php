<?php
namespace Pdftk\File;

/**
 * Class Input
 * @package Pdftk\File
 */
class Input
{
    protected $aRotations = array(0 => 'north', 90 => 'east', 180 => 'south', 270 => 'west');
    protected $sInputFilename = null; //File to read in
    protected $streamData = null; //Direct Stream data
    protected $sPassword = null; //Allow us to decode
    protected $mStartPage = null; //numeric or end
    protected $mEndPage = null; //numeric or end
    protected $sAlternatePages = null; //odd or even
    protected $sRotation = null; //north, east, south or west
    protected $sOverride = null; //In-case the string is complex

    public function __construct($aParams = array())
    {
        if (isset($aParams['filename'])) {
            $this->setFilename($aParams['filename']);
        }

        if (isset($aParams['data'])) {
            $this->setStreamData($aParams['data']);
        }

        if (isset($aParams['password'])) {
            $this->setPassword($aParams['password']);
        }

        if (isset($aParams['start_page'])) {
            $this->setStartPage($aParams['start_page']);
        }

        if (isset($aParams['end_page'])) {
            $this->setEndPage($aParams['end_page']);
        }

        if (isset($aParams['alternate'])) {
            $this->setAlternate($aParams['alternate']);
        }

        if (isset($aParams['rotation'])) {
            $this->setRotation($aParams['rotation']);
        }
    }

    /**
     * Set the filename to be read from
     *
     * @param string $sFilename
     * @throws \Exception
     * @return $this
     */
    public function setFilename($sFilename)
    {
        if (!file_exists($sFilename)) {
            throw new \Exception('File Doesn\'t exist: ' . $sFilename);
        }

        $this->sInputFilename = $sFilename;
        return $this;
    }

    /**
     * Return the filename of the input file
     * @example    $foo->getFilename();
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->sInputFilename;
    }

    /**
     * Pass the input data in
     *
     * @param string $sData
     * @return $this
     */
    public function setStreamData($sData = null)
    {
        $this->streamData = $sData;
        return $this;
    }

    /**
     * Returns the 'string' version of the file.
     *
     * @return string
     */
    public function getStreamData()
    {
        return $this->streamData;
    }

    /**
     * Set the files read password
     *
     * @param null $sPassword
     * @return $this
     */
    public function setPassword($sPassword = null)
    {
        $this->sPassword = $sPassword;
        return $this;
    }

    /**
     * Returns the read password set for this input file
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->sPassword;
    }

    /**
     * Set the start page to read from
     * @example $foo->setStartPage('end');
     *
     * @param mixed $mStartPage
     * @return $this
     */
    public function setStartPage($mStartPage)
    {
        $this->mStartPage = $mStartPage;
        return $this;
    }

    /**
     * Set the end page to read up to
     *
     * @param $iEndPage
     * @return $this
     */
    public function setEndPage($iEndPage)
    {
        $this->mEndPage = $iEndPage;
        return $this;
    }

    /**
     * Allows the user to pass in a replacement command line string
     * @example $foo->setOverride('5-25oddW');
     *
     * @param string $sOverride
     * @return $this
     */
    public function setOverride($sOverride)
    {
        $this->sOverride = $sOverride;
        return $this;
    }

    /**
     * Sets the rotation of this document
     * @example $foo->setRotation(90);
     *
     * @param $iRotation
     * @return $this
     */
    public function setRotation($iRotation)
    {
        $this->sRotation = (int)$iRotation;
        return $this;
    }

    /**
     * Sets the rotation of the input file
     * @example $foo->setAlternate('even');
     *
     * @params string $sAlternate
     * return $this
     */
    public function setAlternate($sAlternate = null)
    {
        $this->sAlternatePages = $sAlternate;
        return $this;
    }

    /**
     * Returns command to be executed
     * @example $foo->_getCatCommand();
     *
     * @return string
     */
    public function _getCatCommand()
    {
        if ($this->sOverride != null) {
            return $this->sOverride;
        }

        $aCommand = array();

        //Page Numbers and Qualifiers
        if ($this->mStartPage !== null) {
            $aCommand[] = $this->mStartPage;
        }

        if ($this->mEndPage !== null) {
            $aCommand[] = '-' . $this->mEndPage;
        }

        if ($this->sAlternatePages !== null) {
            $aCommand[] = $this->sAlternatePages;
        }

        //File rotation
        if ($this->sRotation !== null) {
            $aCommand[] = $this->aRotations[$this->sRotation];
        }

        return implode('', $aCommand);
    }
}