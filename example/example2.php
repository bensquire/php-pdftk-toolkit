<?php
include('../pdftk/pdftk.php');
$sPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'pdfs' . DIRECTORY_SEPARATOR;

$oPdftk = new pdftk();
$oPdftk ->setInputFile(array("filename" => $sPath . 'example.pdf', 'start_page' => 1, "end_page" => 2))
        ->setInputFile(array("filename" => $sPath . 'example.pdf', 'rotation' => 90))
        ->setUserPassword("userpassword")
        ->setOwnerPassword("ownerpassword")
        ->setEncryptionLevel(40)     //Weak Encryption, 128 is default
        ->setOutputFile(sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'example2output.pdf')
        ->_renderPdf();