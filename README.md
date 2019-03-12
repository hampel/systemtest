Mail Test for Laravel
=====================

This package provides a very simple mail test console command to verify if email delivery is operational.

By [Simon Hampel](mailto:simon@hampelgroup.com).

Installation
------------

The recommended way of installing the Alerts package is through [Composer](http://getcomposer.org):

	:::bash
	composer require hampel/mailtest:~1.0

Alternatively, specify the package name manually in your `composer.json`

    :::json
    {
        "require": {
            "hampel/mailtest": "~1.0"
        }
    }

Run Composer to update the new requirement.

    :::bash
    $ composer update

The package is built to work with the Laravel Framework v5.5 and above.

Usage
-----

Once installed, a new artisan console command will become available - `mail:test`:

	:::bash
	artisan mail:test foo@example.com

Ensure that mail has been configured and then run the above console command with an email address to send to as the 
parameter. Any exceptions raised will be output to the console.