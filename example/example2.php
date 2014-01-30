<?php
include('../vendor/autoload.php');

use Pdftk\Pdftk;

$sPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'pdfs' . DIRECTORY_SEPARATOR;
$sOutputFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'example2output.pdf';

$oPDFTk = new Pdftk();
$oPDFTk ->setInputFile(array("filename" => $sPath . 'example.pdf', 'start_page' => 1, "end_page" => 2))
        ->setInputFile(array("filename" => $sPath . 'example.pdf', 'rotation' => 90))
        ->setUserPassword("userpassword")
        ->setOwnerPassword("ownerpassword")
        ->setEncryptionLevel(40)     //Weak Encryption, 128 is default
        ->setOutputFile($sOutputFile)
        ->_renderPdf();

echo 'Rendered to: ' . $sOutputFile . "\r\n";
