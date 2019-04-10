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
	
TODO: add support for sending via the mail queue

**Log**

Run the `test:log` console command to write a series of logs covering all severities to the default log file.

The `--channel` option can be used to specify any other configured logging channel.

	:::bash
	artisan test:log --channel=syslog
	
**Filesystem**

Run the `test:file` console command to list all files available on the default disk.

The `--disk` option can be used to specify any other configured disk (eg `local` or `public`).

	:::bash
	artisan test:file --disk=public
	
Note that no files are written to the disk.

**Cache**

Run the `test:cache` console command to write test writing to and retrieving from the default cache store.

The `--store` option can be used to specify any other configured cache store.

	:::bash
	artisan test:cache --store=array
	
The test will generate a random key, write it to the cache (provided the key doesn't already exist), increment the 
value, then retrieve and delete the key - checking that the returned value is as expected.

**Schedule**

Rune the `test:schedule` console command to output details of scheduled commands to the console.

**Notifications**

TODO: implement notifications testing!
