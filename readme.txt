=== PWH Honey Pot ===
Contributors: infobahn.co.za
Tags: spam, honey pot, email harvester
Requires at least: 3.6
Tested up to: 4.0
Stable tag: 1.0.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin adds an email honey pot address to catch spammers and email harvesters.

== Description ==

This plugin uses an email address to catch spammers and mail harvesters. 
There are no settings for this plugin. It will attempt to connect to http://dnsbl.phpwebhost.co.za once a day to get a fresh honey pot email address.

You may also donate an mx record to dnsbl.phpwebhost.co.za, details can be found at http://dnsbl.phpwebhost.co.za/donate-an-mx.php

== Installation ==

1. Use Wordpress's  auto plugin installer. Search for PWH Honey Pot

== Changelog ==

= 1.0.5 =
* Adds a bit of error logging in the catch block (see 1.0.4 below). This allows a max file size of 5Mb before its deleted and starts fresh.
* If an error is triggered and the default email address is used it caches that as if it were a properly looked up address to prevent subsequent failures (which could significantly impact load times on every page load)

= 1.0.4 =
* Adds a try / catch block around the external checks to dnsbl.phpwebhost.co.za. If there is any failure in lookups it now defaults to an address rather than generating a fatal error

= 1.0.3 =
* Minor change to the way sites  connect to get random email addresses so that site owners can keep track of spam bots they've caught.

= 1.0.2 =
* Fixed a path error which caused the admin panel to throw an error and / or not display anything.

= 1.0.1 =
* Removed the need for any setup, random emails are completely auto generated from user donated MXs (http://dnsbl.phpwebhost.co.za/donate-an-mx.php)

= 1.0.0 =
* Initial version



