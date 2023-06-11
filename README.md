System Test for Laravel
=======================

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hampel/systemtest.svg?style=flat-square)](https://packagist.org/packages/hampel/systemtest)
[![Total Downloads](https://img.shields.io/packagist/dt/hampel/systemtest.svg?style=flat-square)](https://packagist.org/packages/hampel/systemtest)
[![Open Issues](https://img.shields.io/github/issues-raw/hampel/systemtest.svg?style=flat-square)](https://github.com/hampel/systemtest/issues)
[![License](https://img.shields.io/packagist/l/hampel/systemtest.svg?style=flat-square)](https://packagist.org/packages/hampel/systemtest)

This package provides a number of console commands to test various subsystems (email, logging, notifications, etc) of a 
Laravel system in production. It is primarily intended for troubleshooting issues on a newly deployed application or
if you've moved to a new server - identifying permissions errors and such.

By [Simon Hampel](mailto:simon@hampelgroup.com)

Installation
------------

To install using composer, run the following command:

`composer require hampel/systemtest`

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

Run the `test:schedule` console command to output details of scheduled commands to the console.

**Upload**

Run the `test:upload <path>` console command to upload the file at `<path>` to your default filesystem disk and report 
back on the time taken.

The `--disk` option can be used to specify any configured disk (eg `local` or `s3`).

	:::bash
	artisan test:file /path/to/foo.jpg --disk=s3
	
Note that the file will be uploaded to the root of the disk and then deleted - so both write and delete permissions are 
required.

A large test file such as those used by the [Linode Speedtest](https://www.linode.com/speedtest) are good for testing 
upload speeds.

**Notifications**

Run the `test:notification <channel> <destination>` console command to send a notification to the selected channel.

Currently supported channels are `mail` and `slack`. The destination must also be specified, for mail that would be the
email address to send to and for Slack it would be the inbound webhook URL.

For example:

	:::bash
	artisan test:notification mail foo@example.com
	
	artisan test:notification slack https://hooks.slack.com/services/...
	
Be sure to check your inbox or Slack channel for a test notification message.
