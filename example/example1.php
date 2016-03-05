<?php
include('../vendor/autoload.php');

use Pdftk\Pdftk;

$sPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'pdfs' . DIRECTORY_SEPARATOR;

$oPDFTk = new Pdftk();
$oPDFTk ->setInputFile(array("filename" => $sPath . 'example.pdf', 'start_page' => 2))
        ->setInputFile(array("filename" => $sPath . 'example2.pdf', 'rotation' => 90))
        ->setInputFile(array("filename" => $sPath . 'example2.pdf', 'password' => 'password', 'alternate' => 'odd'));

header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="example1.pdf"');
echo $oPDFTk->_renderPdf();
