php-pdftk-toolkit
=================
A PHP library to that creates an interface for the PDFTK (PDF-Toolkit) command line interface
(http://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/).

Using simple OO methods, this project will build and run the typical command line parameters
used to merge and modify PDFs.

Note: It took me 7 months to realise the repository name is spelt wrong (doh!)


Example Code:
-------------
	$oPdftk = new pdftk();
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
5.2 (or greater) and version 1.45 of the pdftk binary (remember to update the binary
location).