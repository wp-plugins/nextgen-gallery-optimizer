=== Plugin Name ===
Contributors: Mark Jeldi
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YGS3ANA29BJ2W
Author URI: http://www.markstechnologynews.com
Plugin URI: http://www.markstechnologynews.com/2012/02/nextgen-gallery-optimizer-wordpress-plugin-helps-boost-your-sites-page-load-speed.html
Tags: nextgen gallery, nextgen, nextgen gallery optimizer, nextgen gallery plugins, nextgen gallery lightbox, nextgen gallery addons, nextgen gallery fancybox, fancybox, fancybox plugin, fancybox lightbox, wordpress optimization
Requires at least: 3.1.2
Tested up to: 3.3.1
Stable tag: 1.0.1

Improves your site's page load speed by preventing NextGEN's scripts & css from loading on posts without galleries.

== Description ==

NextGEN Gallery Optimizer improves your site's page load speed by ensuring NextGEN Gallery's scripts and styles ONLY load on posts with the [nggallery id=x] shortcode.

It also includes and integrates the fantastic Fancybox lightbox script, so now you can have gorgeous galleries AND a speedy site! *Requires NextGEN Gallery 1.6.2 and up.

= Key features: =
1. Improves your WordPress page load speed!
2. Prevents NextGEN's scripts and styles from loading on posts without galleries.
3. Lets you easily install the Fancybox lightbox to display your images in style.


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

= V1.0.1 - 01/03/2012 =
* Resolved issue regarding upload to WordPress.org repository

= V1.0 - 28/02/2012 =
* Initial release on February 28th, 2012.


== Upgrade Notice ==
