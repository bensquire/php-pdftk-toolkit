php-pdftk-toolkit
=================
A PHP library to that creates an interface for the PDFTK (PDF-Toolkit) command line interface
(http://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/).

A simple PSR-0 compliant library, this project will build and run the typical command line  parameters used to merge
and modify PDFs.

Note: If your looking for the simpler non PSR-0 compliant module, then you can download the tagged 'v1' commit.


Example Code:
-------------
    //Initiate autoloader

    use Pdftk\Pdftk;

	$oPdftk = new Pdftk();
	$oPdftk	->setInputFile(array("filename" => $path . 'example.pdf', 'start_page' => 2))
			->setInputFile(array("filename" => $path . 'example2.pdf', 'rotation' => 90))
			->setInputFile(array("filename" => $path . 'example2.pdf', 'password' => 'password', 'alternate' => 'odd'))
			->setUserPassword("userpassword")
			->setOwnerPassword("ownerpassword")
			->setEncryptionLevel(40)
			->setOutputFile('/tmp/generated.pdf');

	$oPdftk->_renderPdf();


Implemented Functionality:
--------------------------
 - Page Rotation
 - Adjustable encryption level
 - Open Password Encrypted PDFs
 - Create Password Encrypted PDFs
 - Use implicit pages or a range
 - Use alternate pages (odd or even)
 - Rotate pages
 - Output the PDF to the browser or a file


Installation:
-------------
 - Download and install the PDFTK binary http://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/
 - Download this PHP library
 - Update the location of the PDFTK binary within this library
 - Try the examples!
 - Provide Feedback :)


Requirements:
-------------
This library requires no additional software beyond  a functional version of PHP
5.3 (or greater) and version 1.45 of the pdftk binary (remember to update the binary
location if its not in /usr/local/bin).