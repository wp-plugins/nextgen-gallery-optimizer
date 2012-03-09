=== NextGEN Gallery Optimizer ===
Contributors: Mark Jeldi
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YGS3ANA29BJ2W
Author URI: http://www.markstechnologynews.com
Plugin URI: http://www.markstechnologynews.com/2012/02/nextgen-gallery-optimizer-wordpress-plugin-helps-boost-your-sites-page-load-speed.html
Tags: nextgen gallery, nextgen, nextgen gallery optimizer, nextgen gallery plugins, nextgen gallery lightbox, nextgen gallery addons, nextgen gallery fancybox, fancybox, fancybox plugin, fancybox lightbox, fancybox for wordpress, wordpress fancybox, wordpress optimization
Requires at least: 3.1.2
Tested up to: 3.3.1
Stable tag: 1.0.3

Improves your site's page load speed by preventing NextGEN's scripts & css from loading on posts without galleries.

== Description ==

NextGEN Gallery Optimizer improves your site's page load speed by ensuring NextGEN Gallery's scripts and styles ONLY load on posts with the [nggallery id=x] shortcode.

It also includes and integrates the fantastic Fancybox lightbox script, so now you can have gorgeous galleries AND a speedy site! *Requires NextGEN Gallery 1.6.2 and up.

= Key features: =
1. Improves your WordPress page load speed!
2. Prevents NextGEN's scripts and styles from loading on posts without galleries.
3. Lets you easily install the Fancybox lightbox to display your images in style.
 
 
 
= NEW in Version 1.0.3: =

Optimized code for improved compatibility
* Results in faster page load times by avoiding duplicate scripts. Also, less chance of conflicts with other plugins.

Improved settings page
* Makes setting up Fancybox even easier.
 
 
= NEW in Version 1.0.2: =

Support for WordPress Pages
* Display galleries on Posts <i>and Pages</i> in style, but only load code when they're present.

Fancybox overlap fix
* Fixes an issue where some page elements overlap Fancybox and prevent the close button from functioning (in particular the title text, header image and menu bar in Twenty Eleven).

Fix for Fancybox not working in IE6 & IE8
* Automatically updates the Fancybox stylesheet to use the correct file paths.

Latest JQuery
* Fancybox now running on JQuery version 1.7.1 resulting in faster page loads on pages with galleries.

== Installation ==
 
1. Upload `nextgen-gallery-optimizer` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Proceed to the plugin settings page to complete installation.


== Frequently Asked Questions ==

= Is this plugin compatible with minification/caching tools? =

Yes. However the small, already minified Fancybox script must be excluded from combining/minification or it won't function. This is true of any lightbox script.

For WP Minify, simply add /wp-content/plugins/nextgen-gallery-optimizer/fancybox/jquery.fancybox-1.3.4.pack.js in its js file exclusion options and clear the cache.

For W3 Total Cache, do nothing. It doesn't auto-discover, so as long as you don't manually add the script, it won't be included.

= What version of NextGEN Gallery is this plugin compatible with? =

Any version since 1.6.2


== Screenshots ==

1. NextGEN Gallery Optimizer settings page.


== Changelog ==

= V1.0.3 - 09/03/2012 =

* Replaced all hard-coded scripts and styles with WordPress's built-in wp_enqueue_scripts and wp_print_styles functions for better compatibility with other plugins.

* Added several instances of wp_deregister_script to pages we're serving jquery and jquery.fancybox.js on. This will prevent conflicts (and page load overhead) if any other installed plugins try to serve duplicate scripts.

* Added /wp-content/ url prefix to custom css input box on the settings page. Also made the Fancybox installation instructions clearer with larger text, a link to the NextGEN Effects page, and extra advice in the Tips section on plugin conflicts.

= V1.0.2 - 07/03/2012 =

* Added support for WordPress Pages

* Fixed an issue where some page elements overlap Fancybox and prevent the close button from functioning (in particular the title text, header image and menu bar in Twenty Eleven).

* Fixed a surprisingly common issue involving Fancybox not working in IE6 & IE8. My solution was to develop a regular expression that runs on the plugin options page ONLY to write the full urls Microsoft.AlphaImageLoader requires into the static Fancybox stylesheet. Much more efficient than some methods I've seen (such as dynamically rebuilding the stylesheet on every page view in php).

* Switched JQuery to the latest version 1.7.1 (Google hosted)

= V1.0.1 - 01/03/2012 =
* Resolved issue regarding upload to WordPress.org repository

= V1.0 - 28/02/2012 =
* Initial release on February 28th, 2012.


== Upgrade Notice ==
* Upgrade to V1.0.3 recommended for improved compatibility with other plugins.
* Upgrade to V1.0.2 recommended for cross-browser support.