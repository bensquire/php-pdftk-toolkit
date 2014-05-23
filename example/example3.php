<?php
include('../vendor/autoload.php');

use Pdftk\Pdftk;
use Pdftk\File\Input;

$sPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'pdfs' . DIRECTORY_SEPARATOR;


$oTmp = new Input(array("filename" => $sPath . 'example.pdf', 'start_page' => 2));

$oPDFTk = new Pdftk();
$oPDFTk ->setInputFile($oTmp)
        ->setInputFile(array("filename" => $sPath . 'example2.pdf', 'rotation' => 90))
        ->setInputFile(array("filename" => $sPath . 'example2.pdf', 'password' => 'password', 'alternate' => 'odd'))
        ->setOutputFile("example3output.pdf")
        ->downloadOutput();
