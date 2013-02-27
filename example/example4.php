<?php
include('../pdftk/pdftk.php');
$sPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'pdfs' . DIRECTORY_SEPARATOR;

$oTmp = new pdftk_inputfile(array("filename" => $sPath . 'example.pdf', 'start_page' => 2));

$oPdftk = new pdftk();
$oPdftk ->setInputFile($oTmp)
        ->setInputFile(array("filename" => $sPath . 'example2.pdf', 'rotation' => 90))
        ->setInputFile(array("filename" => $sPath . 'example2.pdf', 'password' => 'password', 'alternate' => 'odd'))
        ->inlineOutput('example4output.pdf', FALSE);