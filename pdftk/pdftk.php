<?php

/**
 * @author Ben Squire <ben@hoasty.com>
 * @license Apache 2.0
 *
 * @package PDFTK-PHP-Library
 * @version 0.1.1
 *
 * @abstract This class allows you to integrate with pdftk command line from within
 * your PHP application (An application for PDF: merging, encrypting, rotating, watermarking,
 * metadata viewer/editor, compressing etc etc). This library is currently limited
 * to the concatenation functionality of the binary; additional functionality to
 * come over time.
 *
 * This library is in no way connected with the author of PDFTK.
 *
 * To be able to use this library a working version of the binary must be installed
 * and its path configured below.
 *
 * @uses http://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/
 *
 * @see install.md
 *
 * @example examples/example1.php
 * @example examples/example2.php
 * @example examples/example3.php
 * @example examples/example4.php
 */
class pdftk {

	//StartConfiguration
	protected $sBin = '/usr/local/bin/pdftk';
	//End Configuration


	protected $aInputFiles = null;
	protected $sOutputFilename = null;
	protected $bVerbose = false;
	protected $bAskmode = false;
	protected $bCompress = true;
	protected $sOwnerPassword = null;
	protected $sUserPassword = null;
	protected $iEncryption = 128;
	protected $aAccess = array(
		'Printing' => false,
		'DegradedPrinting' => false,
		'ModifyContents' => false,
		'Assembly' => false,
		'CopyContents' => false,
		'ScreenReaders' => false,
		'ModifyAnnotations' => false,
		'FillIn' => false,
		'AllFeatures' => false
	);
	protected $sInputData = null; //We'll use this to store the key for the input file.

	function __construct($aParams = array()) {
		if (isset($aParams['owner_password'])) {
			$this->setOwnerPassword($aParams['owner_password']);
		}

		if (isset($aParams['user_password'])) {
			$this->setUserPassword($aParams['user_password']);
		}

		if (isset($aParams['encryption_level'])) {
			$this->setEncryptionLevel($aParams['encryption_level']);
		}

		if (isset($aParams['verbose_mode'])) {
			$this->setVerboseMode($aParams['verbose_mode']);
		}

		if (isset($aParams['ask_mode'])) {
			$this->setAskMode($aParams['ask_mode']);
		}

		if (isset($aParams['compress'])) {
			$this->setCompress($aParams['compress']);
		}
	}

	/**
	 * Sets the level of encrpytion to be used (if owner/user password is specified).
	 * e.g. $foo->setEncrpytionLevel(128);
	 *
	 * @param int $iEncryptionLevel
	 * @return __pdftk
	 */
	public function setEncryptionLevel($iEncryptionLevel = 128) {
		if ((int) $iEncryptionLevel != 40 && (int) $iEncryptionLevel != 128) {
			throw new Exception('Encryption should either be 40 or 128 (bit)');
        }
		
        $this->iEncryption = (int) $iEncryptionLevel;
		return $this;
	}

	/**
	 * Returns the level of encrpytion set.
	 * e.g. $level = $foo->getEncryptionLevel();
	 *
	 * @return int
	 */
	public function getEncryptionLevel() {
		return $this->iEncryption;
	}

	/**
	 * Sets the users password for the ouput file
	 * $foo->setUserPassword("bar");
	 * @return __pdftk
	 */
	public function setUserPassword($sPassword = null) {
		$this->sUserPassword = $sPassword;
		return $this;
	}

	/**
	 * Retreives the user-password for the output file
	 * e.g: $foo->getUserPassword();
	 *
	 * @return string
	 */
	public function getUserPassword() {
		return $this->sUserPassword;
	}

	/**
	 * Sets the owners password for the ouput file
	 * $foo->setOwnerPassword("bar");
	 *
	 * @param string $sPassword
	 * @return __pdftk
	 */
	public function setOwnerPassword($sPassword = null) {
		$this->sOwnerPassword = $sPassword;
		return $this;
	}

	/**
	 * Retreives the owner-password for the output file
	 * e.g: $foo->getOwnerPassword();
	 *
	 * @return string
	 */
	public function getOwnerPassword() {
		return $this->sOwnerPassword;
	}

	/**
	 * Sets whether the cli will output verbose information
	 * e.g:	$foo->setVerboseMode(false);
	 *
	 * @param bool $bVerbose
	 * @return __pdftk
	 */
	public function setVerboseMode($bVerbose = false) {
		if (!is_bool($bVerbose)) {
			throw new Exception('Verbose mode should be either true or false');
        }
		
        $this->bVerbose = (bool) $bVerbose;
		return $this;
	}

	/**
	 * Returns whether the cli will output verbose information
	 * e.g:	$foo->getVerboseMode();
	 *
	 * @return boolean
	 */
	public function getVerboseMode() {
		return $this->bVerbose;
	}

	/**
	 * Sets whether the cli will ask questons when needed
	 * e.g:	$foo->setAskMode(false);
	 *
	 * @param bool $bAskMode
	 * @return __pdftk
	 */
	public function setAskMode($bAskMode = false) {
		if (!is_bool($bAskMode)) {
			throw new Exception('Ask Mode should be either true or false');
        }
		
        $this->bAskmode = (bool) $bAskMode;
		return $this;
	}

	/**
	 * Returns whether the cli will output questions (when needed)
	 * e.g:	$foo->getAskMode();
	 *
	 * @return boolean
	 */
	public function getAskMode() {
		return $this->bAskmode;
	}

	/**
	 * Setups the output file to be used
	 * e.g: $foo->setOutputFile("~/tmp/foo.pdf");
	 *
	 * @param string $sFilename
	 * @return __pdftk
	 */
	public function setOutputFile($sFilename) {
		$this->sOutputFilename = $sFilename;
		return $this;
	}

	/**
	 * Return the output pdfs file
	 * e.g: $foo->getOutputFile();
	 *
	 * @return string
	 */
	public function getOutputFile() {
		return $this->sOutputFilename;
	}

	/**
	 * Compressed by default which prevents editing in text editors, uncompressed allows editing, but increases filesize
	 * e.g: $foo->setCompression(true);
	 *
	 * @param bool $bCompression
	 * @return __pdftk
	 */
	public function setCompress($bCompression = true) {
		$this->bCompress = (bool) $bCompression;
		return $this;
	}

	/**
	 * Returns whether compressions is currently enabled or disabled
	 * e.g: $foo->getCompress();
	 *
	 * @return bool
	 */
	public function getCompress() {
		return $this->bCompress;
	}

	/**
	 * Setup an input file, as an object
	 * e.g. $foo->setInputFile(array("password"=>"foobar"));
	 *
	 * @param array $aParams
	 * @return __pdftk
	 */
	public function setInputFile($aParams = array()) {
		if ($aParams instanceof pdftk_inputfile) {
			$this->aInputFiles[] = $aParams;
		} else {
			$this->aInputFiles[] = new pdftk_inputfile($aParams);
		}
		return $this;
	}

	/**
	 * Returns part of or all of the $this->_input_file array (when possible)
	 * e.g. $temp = $foo->getInputFile();
	 *
	 * @param <type> $mInputFile
	 * @return mixed __pdftk_inputfile|bool|array
	 */
	public function getInputFile($mInputFile = null) {
		if (isset($mInputFile) && isset($this->aInputFiles[$mInputFile])) {
			return $this->aInputFiles[$mInputFile];
		} elseif (isset($mInputFile) && !isset($this->aInputFiles[$mInputFile])) {
			return false;
		}
        
        return $this->aInputFiles;
	}

	/**
	 * Returns command to be executed
	 *
	 * @return string
	 */
	public function _getCommand() {
		$aCommand = array();
		$aCommand[] = $this->sBin;

		$total_inputs = count($this->aInputFiles);

		//Assign each PDF a multi-char handle (pdftk-1.45)
		foreach ($this->aInputFiles AS $iKey => $oFile) {
			if ($oFile->getData() != null) {
				$aCommand[] = "-";
				$this->sInputData = $iKey;
			} else {
				$handle = chr(65 + floor($iKey/26)%26).chr(65 + $iKey%26);
				$aCommand[] = $handle . "='" . $oFile->getFilename()."'";
			}
		}

		//Put read password in place for each file
		//input_pw A=foopass
		$aPasswords = array();
		foreach ($this->aInputFiles AS $iKey => $oFile) {
			//$letter = chr(65 + $iKey);
            $letter = chr(65 + floor($iKey/26)%26).chr(65 + $iKey%26);
			if ($oFile->getPassword() !== null) {
				$aPasswords[] = $letter . '=' . $oFile->getPassword();
			}
		}

		if (count($aPasswords) > 0) {
			$aCommand[] = 'input_pw ' . implode(' ', $aPasswords);
		}

		// TODO: PDFTK Capable of much more functionality, extend here.
		$aCommand[] = 'cat';

		//Fetch command for each input file
		if ($total_inputs > 1) {
			foreach ($this->aInputFiles AS $iKey => $oFile) {
				$handle = chr(65 + floor($iKey/26)%26).chr(65 + $iKey%26);
				$aCommand[] = $handle . $oFile->_getCatCommand();
			}
		}

		//Output file paramters
		$aCommand[] = 'output';
		if (!empty($this->sOutputFilename)) {
			$aCommand[] = $this->sOutputFilename;
		} else {
			$aCommand[] = '-';
		}

		//Check for PDF password...
		if ($this->sOwnerPassword != null || $this->sUserPassword != null) {

			//Set Encryption Level
			$aCommand[] = 'encrypt_' . $this->iEncryption . 'bit';

			//TODO: Sets permissions
			//pdftk mydoc.pdf output mydoc.128.pdf owner_pw foo user_pw baz allow printing
			//Printing, DegradedPrinting, ModifyContents, Assembly, CopyContents,
			//ScreenReaders, ModifyAnnotations, FillIn, AllFeatures
			//Setup owner password
			if ($this->sOwnerPassword != null) {
				$aCommand[] = 'owner_pw ' . $this->sOwnerPassword;
			}

			//Setup owner password
			if ($this->sUserPassword != null) {
				$aCommand[] = 'user_pw ' . $this->sUserPassword;
			}
		}

		//Compress
		$aCommand[] = (($this->bCompress == true) ? 'compress' : 'uncompress' );

		//Verbose Mode
		$aCommand[] = (($this->bVerbose) ? 'verbose' : '');

		//Ask Mode
		$aCommand[] = (($this->bAskmode) ? 'do_ask' : 'dont_ask');

		return implode(' ', $aCommand);
	}

	/**
	 * Render document as downloadable resource,
	 * e.g: $foo->downloadOutput();
	 *
	 * @param $bReturn Should data be returned as well 'echoed'
	 * @return mixed void|string
	 */
	public function downloadOutput($bReturn = false) {
		$filename = $this->sOutputFilename;
		$this->sOutputFilename = null;

		$pdfData = $this->_renderPdf();
		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		echo $pdfData;

		if ($bReturn) {
			return $pdfData;
		}
	}

	/**
     * Render document as inline resource
	 * e.g: $foo->inlineOutput(); 
     * 
     * @param string $sFilename The filename if your were to save the pdf
     * @param boolean $bReturn  Whether we should return the pdf in string format as well
     * @return type
     */
	public function inlineOutput($sFilename = 'output.pdf', $bReturn = false) {
        
        if (strlen($sFilename) === 0 || !is_string($sFilename)) {
            throw new Exception('Invalid output filename');
        }
        
		$this->sOutputFilename = null;
        $sFilename = preg_replace('/[^a-z0-9_\-.]+/i', '_', str_replace('.pdf', '', strtolower($sFilename))) . '.pdf';

		$pdfData = $this->_renderPdf();

        header('Content-type: application/pdf');
        header('Cache-Control: public, must-revalidate, max-age=0');
        header('Content-Disposition: inline; filename="' . $sFilename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($pdfData));
        header('Accept-Ranges: bytes');
		echo $pdfData;

		if ($bReturn) {
			return $pdfData;
		}
	}

	/**
	 * Builds the final PDF
	 * e.g:	$foo->_renderPdf();
	 *
	 * @return string
	 */
	public function _renderPdf() {
		$sData = ((!is_null($this->sInputData) ? $this->aInputFiles[$this->sInputData]->getData() : null));
		$sContent = $this->_exec($this->_getCommand(), $sData);
		if (strlen($sContent['stderr']) > 0) {
			throw new Exception('System error: ' . $sContent['stderr']);
		}

		//Error only if we expecting something from stdout and nothing was returned
		if (is_null($this->sOutputFilename) && mb_strlen($sContent['stdout'], 'utf-8') === 0) {
			throw new Exception('PDF-TK didnt return any data: ' . $this->_getCommand() . ' ' . $this->aInputFiles[$this->sInputData]->getData());
		}

		if ((int) $sContent['return'] > 1) {
			throw new Exception('Shell error, return code: ' . (int) $sContent['return']);
		}

		return $sContent['stdout'];
	}

	/**
	 * Executes pdftk command
	 *
	 * @param string $sCommand Command to execute
	 * @param string $sInput Other input (not arguments)??
	 * @return array
	 */
	protected function _exec($sCommand, $sInput = null) {
		//TODO: Better handling of error codes
		//http://stackoverflow.com/questions/334879/how-do-i-get-the-application-exit-code-from-a-windows-command-line

		$aResult = array('stdout' => '', 'stderr' => '', 'return' => '');

		$aDescriptorSpec = array(
			0 => array('pipe', 'r'),
			1 => array('pipe', 'w'),
			2 => array('pipe', 'w')
		);

		$proc = proc_open($sCommand, $aDescriptorSpec, $aPipes);

		if (!is_resource($proc)) {
			throw new Exception('Unable to open command line resource');
        }
        
        fwrite($aPipes[0], $sInput);
        fclose($aPipes[0]);

        $aResult['stdout'] = stream_get_contents($aPipes[1]);
        fclose($aPipes[1]);

        $aResult['stderr'] = stream_get_contents($aPipes[2]);
        fclose($aPipes[2]);

        $aResult['return'] = proc_close($proc);

		return $aResult;
	}

	/**
	 * Returns the command to be executed
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->_getCommand();
	}

}

class pdftk_inputfile {

	protected $aRotations = array(0 => 'north', 90 => 'east', 180 => 'south', 270 => 'west');
	protected $sInputFilename = null;  //File to readin
	protected $_data = null;   //Direct Stream data
	protected $sPassword = null;  //Allow us to decode
	protected $mStartPage = null;  //numeric or end
	protected $mEndPage = null;  //numeric or end
	protected $sAlternatePages = null;  //odd or even
	protected $sRotation = null;  //north, east, south or west
	protected $sOverride = null;  //Incase the string is paticully complex

	function __construct($aParams = array()) {
		if (isset($aParams['filename'])) {
			$this->setFilename($aParams['filename']);
		}

		if (isset($aParams['data'])) {
			$this->setData($aParams['data']);
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
	 * @return bool
	 */
	public function setFilename($sFilename) {
		if (!file_exists($sFilename)) {
			throw new Exception('File Doesn\'t exist: ' . $sFilename);
        }
        
        $this->sInputFilename = $sFilename;
        return true;
	}

	/**
	 * Return the filename of the input file
	 * e.g:	$foo->getFilename();
	 *
	 * @return string
	 */
	public function getFilename() {
		return $this->sInputFilename;
	}

	/**
	 * Pass the input data in
	 *
	 * @param string $sData
	 */
	public function setData($sData = null) {
		$this->_data = $sData;
	}

	/**
	 * Returns the 'string' version of the file.
	 *
	 * @return <type>
	 */
	public function getData() {
		return $this->_data;
	}

	/**
	 * Set the files read password
	 *
	 * @param string $sPassword
	 */
	public function setPassword($sPassword = null) {
		$this->sPassword = $sPassword;
	}

	/**
	 * Returns the read password set for this input file
	 *
	 * @return string
	 */
	public function getPassword() {
		return $this->sPassword;
	}

	/**
	 * Set the start page to read from
	 * e.g: $foo->setStartPage('end');
	 *
	 * @param mixed $mStartPage
	 */
	public function setStartPage($mStartPage) {
		$this->mStartPage = $mStartPage;
	}

	/**
	 * Set the end page to read upto
	 * e.g: $foo->setEndPage(9);
	 *
	 * @param int $iEndPage
	 */
	public function setEndPage($iEndPage) {
		$this->mEndPage = $iEndPage;
	}

	/**
	 * Allows the user to pass in a replacement command line string
	 * e.g: $foo->setOverride('5-25oddW');
	 *
	 * @param string $sOverride
	 */
	public function setOverride($sOverride) {
		$this->sOverride = $sOverride;
	}

	/**
	 * Sets the rotation of this document
	 * e.g: $foo->setRotation(90);
	 *
	 * @param int $iRotation
	 */
	public function setRotation($iRotation) {
		$this->sRotation = (int) $iRotation;
	}

	/**
	 * Sets the rotation of the input file
	 * e.g: $foo->setAlternate('even');
	 *
	 * @params string $sAlternate
	 * @return void
	 */
	public function setAlternate($sAlternate = null) {
		$this->sAlternatePages = $sAlternate;
	}

	/**
	 * Returns command to be executed
	 * e.g:	$foo->_getCatCommand();
	 *
	 * @return string
	 */
	public function _getCatCommand() {

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