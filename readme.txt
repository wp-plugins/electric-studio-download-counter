=== Plugin Name ===
Contributors: irvingswiftj, Matthew Burrows, Electric Studio
Tags: downloads, counter
Requires at least: 3.1
Tested up to: 3.3.1
Stable tag: 1.1

Get Statistics about your downloads.

== Description ==

View how many people have downloaded what files from your site.

Features include:
* Allows you to specify which file types to track.
* View top ten downloads.
* View this month's downloads.
* View this week's downloads.
* Use shortcode or a php function to display amount of times downloaded in the frontend of your site.

== Installation ==

Install from wordpress plugins directory.

Else, to install manually:

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. An example of the available download stats.
2. Specify which file types you want to track.

== Changelog ==

= 1.1 =
* Fixed notices that appeared in debugging mode
* Widget now included

= 1.0 =
* Code is now Object Orientated style to be consistant with our other plugins
* Nonces have been added for security on the AJAX functions
* Javascript now respects target="_blank" on tracked links - Thanks to Philouxera for bringing this to my attention
* Download Counter is now a menu page rather than an option page.
* Count Shortcode added [downloadcount link="filename.txt"]. Users that want to build this into their template can do with `echo $esdc->get_count("filename.txt");` - Thanks to 'Biyan' for suggesting this

= 0.7.4 =
* Fixed Jquery bug

= 0.7.3 =
* Wordpress 3.3.1 compatible

= 0.7.2 =
* Searching for downloads between different dates are no longer limited to 30 results.

= 0.7.1 =

* Fixed 'not counting bug'

= 0.7 =

* 2 Bug Fixes
* Search for Dates

= 0.5 =
* Beta version release.

== Upgrade Notice ==

= 1.1 =
* Minor Bug fixes

= 1.0 =
* Code is now Object Orientated style to be consistant with our other plugins
* Nonces have been added for security on the AJAX functions
* Javascript now respects target="_blank" on tracked links
* Download Counter is now a menu page rather than an option page.
* Shortcode added

= 0.7.4 =
Fixed jquery bug 

= 0.7.3 =
Wordpress 3.3.1 compatible

= 0.7.2 =
Download search improved

= 0.7.1 =
Fixes issues with not counting.

= 0.7 =
Bug fixes and new functionality

= 0.5 =
This is the beta version.


