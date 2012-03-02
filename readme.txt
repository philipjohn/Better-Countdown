=== Better Countdown ===
Contributors: philipjohn 
Tags: countdown, jquery, widget, template tag, shortcode
Requires at least: 3.3.1
Tested up to: 3.3.1
Stable tag: trunk

Adds a widget, shortcode and template tag for adding a countdown anywhere in your site.

== Description ==

Implementing the [jQuery Countdown plugin](http://keith-wood.name/countdown.html) by [Keith Wood](http://keith-wood.name), this plugin provides three methods for adding a countdown to your WordPress site;

*   Sidebar Widget
*   Shortcode within posts and pages
*   Template tag for embedding in your theme

<div>
  Every instance of the countdown can have it's own options, or you can set options globally. This makes the plugin far easier to use than most of the other available countdown plugins.
</div>

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

== Frequently Asked Questions ==

**How do I add a countdown to my site?**

There are three ways;

*   Go to Appearance > Widgets and drag the "Countdown" widget to your sidebar then set your options
*   Add the [countdown] shortcode to a post or page, adding the date to countdown to like so; `[countdown to="5th March 2085 9:15am"]`
*   Use the template tag in your theme like so: `<?php echo pj_countdown('5th March 2085 9:15am'); ?>`

== Changelog ==

= Future features =

= 0.1 =
First stuff