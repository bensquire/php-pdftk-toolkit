<?php
include('../vendor/autoload.php');

use Pdftk\Pdftk;
$sPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'pdfs' . DIRECTORY_SEPARATOR;
$pages = 2;

for($x = 1; $x <= $pages; $x++)
{
    $oPDFTk = new Pdftk();
    $oPDFTk ->setInputFile(array("filename" => $sPath . 'example.pdf', 'start_page' => $x, "end_page" => $x))
            ->setUserPassword("userpassword")
            ->setOwnerPassword("ownerpassword")
            ->setOutputFile(sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'example2output-' . $x . '.pdf')
            ->_renderPdf();

    echo 'Saving PDF to: ' . sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'example2output-' . $x . '.pdf' . "\r\n";
}


