<?php

include('../pdftk/pdftk.php');
$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'pdfs' . DIRECTORY_SEPARATOR;

$pdftk = new pdftk();
$pdftk->setInputFile(array("filename" => $path . 'example.pdf', 'start_page' => 2))
		->setInputFile(array("filename" => $path . 'example2.pdf', 'rotation' => 90))
		->setInputFile(array("filename" => $path . 'example2.pdf', 'password' => 'password', 'alternate' => 'odd'));

header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="temp.pdf"');
echo $pdftk->_renderPdf();