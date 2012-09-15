<?php
	include('../pdftk/pdftk.php');
	$path = dirname(__FILE__) . DIRECTORY_SEPARATOR. 'pdfs' . DIRECTORY_SEPARATOR;
	
	$pdftk = new pdftk();
	$pdftk	->setInputFile(array("filename"=>$path . 'example.pdf', 'start_page'=>1, "end_page"=>2))
			->setInputFile(array("filename"=>$path . 'example.pdf', 'rotation'=>90))
			->setUserPassword("userpassword")
			->setOwnerPassword("ownerpassword")
			->setEncryptionLevel(40)					//Weak Encryption, 128 is default
			->setOutputFile('/tmp/generated.pdf');				
	
	$pdftk->_renderPdf();
?>