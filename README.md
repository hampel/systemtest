System Test for Laravel
=======================

This package provides a number of console commands to test various subsystems (email, logging, notifications, etc) of a 
Laravel system in production.

By [Simon Hampel](mailto:simon@hampelgroup.com).

Installation
------------

The recommended way of installing the Alerts package is through [Composer](http://getcomposer.org):

	:::bash
	composer require hampel/systemtest:~1.1

Alternatively, specify the package name manually in your `composer.json`

    :::json
    {
        "require": {
            "hampel/systemtest": "~1.1"
        }
    }

Run Composer to update the new requirement.

    :::bash
    $ composer update

The package is built to work with the Laravel Framework v5.5 and above.

Usage
-----

Once installed, new artisan console commands will become available:

**Mail**

Ensure that mail has been configured and then run the `test:mail` console command with a destination email address as 
the parameter.

	:::bash
	artisan test:mail foo@example.com

