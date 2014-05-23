Installation
============

Binaries:
---------
The PDFTK PHP Library requires a valid installation of the PDFTK Binary, which can be found:

	http://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/


Composer:
---------
The library is PSR-0 compliant and the simplest way to install it is via composer, at the moment it isn't part of the
main composer package library so it can be included by putting:

    {
        "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/bensquire/php-pdftk-toolkit"
            }
        ],
        "require": {
            "bensquire/php-pdftk-toolkit": "development"
        }
    }

into your composer.json, then run 'composer install' or 'composer update' as required.