=== NextGEN Gallery Optimizer ===
Contributors: Mark Jeldi
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YGS3ANA29BJ2W
Author URI: http://www.markstechnologynews.com
Plugin URI: http://www.markstechnologynews.com/2012/02/nextgen-gallery-optimizer-wordpress-plugin-helps-boost-your-sites-page-load-speed.html
Tags: nextgen gallery, nextgen, nextgen gallery optimizer, nextgen gallery plugins, nextgen gallery addons, nextgen gallery fancybox, fancybox, fancybox plugin, fancybox lightbox, fancybox for wordpress, wordpress fancybox, wordpress optimization
Requires at least: 3.1.2
Tested up to: 3.3.1
Stable tag: 1.0.6

Improves your site's page load speed by preventing NextGEN's scripts & css from loading on posts without galleries.

== Description ==

= NextGEN Gallery Optimizer =

Improves your site's page load speed by ensuring NextGEN Gallery's scripts and styles ONLY load on posts with the [nggallery id=x] shortcode.

It also includes and *automatically*-integrates the fantastic Fancybox lightbox script, so now you can have gorgeous galleries AND a speedy site! *Requires NextGEN Gallery 1.6.2 and up.

Please note: This basic version currently only supports the **[nggallery id=x]** shortcode.

= NextGEN Gallery Optimizer *Premium* =

Builds on the basic version and adds support for ALL TEN of NextGen's shortcodes including **[nggallery id=x]**, **[slideshow id=x]**, **[album id=x]**, **[thumb id=x]**, **[singlepic id=x]**, **[imagebrowser id=x]**, **[nggtags gallery|album=mytag]**, **[random max=x]**, **[recent max=x]** and **[tagcloud]**.

It also adds support for the **[Show as slideshow]** link (loading slideshow scripts only after a user clicks-through), precision targeting for **shortcode SUB-pages** (ensuring we only load the scripts we need on each view) and also **removes NextGEN's version number comment** (for less clutter behind every page).

This donation-based version is available from the plugin settings page, [or can be downloaded here](http://www.markstechnologynews.com/nextgen-gallery-optimizer-premium).

If you have any questions, suggestions, ideas or feedback, please email me at mark@markstechnologynews.com

= Key features: =
1. Improves your WordPress page load speed!
2. Prevents NextGEN's scripts and styles from loading on posts without galleries.
3. Lets you easily install the Fancybox lightbox to display your images in style.

= NEW in Version 1.0.6: =

1. Fully-automated Fancybox installation! (Basic and Premium)


This version features completely automated Fancybox integration with NextGEN Gallery, so now you can be up and running even faster.


= NEW in Version 1.0.5: =

1. Precision matching with WordPress's built-in shortcode finder.
2. NextGEN Gallery Optimizer *Premium* (an optional upgrade for a small donation).


This version uses WordPress's native get_shortcode_regex() function for EXACT shortcode matching, ensuring scripts and styles don't load unexpectedly unless the FULL shortcode is present. If WordPress doesn't detect a shortcode, neither do we!

Also, this update introduces the new NextGEN Gallery Optimizer *Premium* version, which adds support for ALL TEN of NextGen's shortcodes, support for the [show as slideshow] link, the removal of NextGEN's version number comment and more.


= NEW in Version 1.0.4: =

1. Easier set up

This version automatically redirects first time users to the options page on activation and sets a default stylesheet for easier set up.


= NEW in Version 1.0.3: =

1. Optimized code for better compatibility and page load speed 
2. Improved settings page

This update results in faster page loads on gallery pages by avoiding duplicate scripts. It reduces the chance of conflicts with other plugins and makes setting up Fancybox even easier.


= NEW in Version 1.0.2: =

1. Support for WordPress Pages
2. Fancybox overlap fix
3. Fix for Fancybox not working in IE6 & IE8
4. Latest JQuery

This update lets you display galleries on both Posts AND Pages in style, but only load code when they're present.

It also fixes an issue where some page elements overlap Fancybox and prevent the close button from functioning (in particular the title text, header image and menu bar in Twenty Eleven).

It fixes the "Fancybox not working in IE6 & IE8" issue by automatically updating the Fancybox stylesheet to use the correct file paths, and we're now running Fancybox on  JQuery version 1.7.1, resulting in faster page loads where galleries are present.

== Installation ==

1. Upload `nextgen-gallery-optimizer` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Proceed to the plugin settings page to complete installation.


== Frequently Asked Questions ==

= Basic Version =
 
= Wait...my galleries are displaying in a vertical line! =

Please make sure you've selected a stylesheet on the (NextGEN Optimizer) settings page, and that you're using the [nggallery id=x] shortcode in your posts. This is the only supported shortcode in the basic version presently.


= My image thumbnails are clicking-through to an image URL! Where did the lightbox go? =

By design, the plugin strips NextGEN's sitewide scripts and styles (including those for lightboxes) and lets you insert your own...only where they're needed. 

Currently, NextGEN Optimizer lets you add the free and fabulous Fancybox lightbox to your gallery thumbs. Other effects are on the way...

To set up Fancybox, please check it's checkbox on the (NextGEN Optimizer) settings page. After you save, just go to Gallery --> Options --> Effects, select Custom and enter: **class="myfancybox" rel="%GALLERY_NAME%"** to complete the installation.

This will integrate the Fancybox lightbox with NextGEN Gallery on your [nggallery id=x] shortcodes instead of directing you to the image URL.


= Premium Version =
 
= Why won't my images click-through to a gallery on my [album id=x] shortcodes? =

It looks as though there may be a bug with one of NextGEN's settings. Go to Gallery --> Options --> Gallery Settings and make sure the first option "Deactivate gallery page link" is checked (as it is by default).

= I've just added a gallery to an album in NextGEN and I get a "Notice: Undefined property: stdClass::$gallery_ids" error message on my page. =

The drag-and-drop "Manage Albums" page in NextGEN does not auto-save like the WordPress widgets page. Click the "Update" button and your albums will display as they should.

= Help! My slideshows aren't working...they just show a rotating loading circle. =

Please go to GALLERY -> MANAGE GALLERY and select the gallery that's causing you trouble. Inside this gallery, ensure ALL image thumbnails are displaying and re-upload them if necessary. If they're missing, the "Path" field may have been changed, which will cause the slideshow to break.

= Why doesn't Optimizer support NextGEN widgets? =

After spending weeks working on integrating this, I've discovered it's not presently possible in WordPress to:

1. Conditionally load the required scripts in the header AND

2. ONLY load them if the widget is actually present on the page.

Since both the Fancybox and the NextGEN slideshow scripts must be loaded in the head section of the page so they don't break, and since the whole point of this plugin is to NOT load scripts on every page, I've had to abandon this idea for the time being. If you know of a solution, do let me know and I'll add it in the next version!


= General =
 
= Is this plugin compatible with minification/caching tools? =

Yes. However the small, already minified Fancybox script must be excluded from combining/minification or it won't function. This is true of any lightbox script.

For WP Minify, simply add /wp-content/plugins/nextgen-gallery-optimizer/fancybox/jquery.fancybox-1.3.4.pack.js in its js file exclusion options and clear the cache.

For W3 Total Cache, do nothing. It doesn't auto-discover, so as long as you don't manually add the script, it won't be included.


= What version of NextGEN Gallery is this plugin compatible with? =

Any version since 1.6.2


== Screenshots ==

1. NextGEN Gallery Optimizer settings page.


== Changelog ==

= V1.0.6 - 04/04/2012 =

* Installation of Fancybox is now fully automated and set by default.
The plugin saves a copy of existing settings on the Gallery --> Options --> Effects page, then updates them with the Fancybox code so we don't have to enter it manually.
Any changes to this code are then overridden as long as the Fancybox option on the settings page is checked. This helps prevent accidental changes that would break integration. A safety switch, if you will.
There's also an admin message that prompts users to uncheck the Fancybox setting on the options page if they want to use another custom lightbox/effect.
On deactivation, Optimizer will attempt to restore the former values...but only if Fancybox is selected (don't want to write over newer custom values!)

* Removed installation instructions from the options pages as, well, we don't need them anymore.

* After discovering WordPress's auto-update downloads the full version of the plugin (not just the files that have changed), and with no way to redirect back to the plugin settings page from the upgrade page, I've set the Fancybox stylesheet regex to run on admin_init instead. Since we only want it to run once (on first activation and after auto-update), I've defined a version number in the code and added a "version" option to the settings array to check against.

* Added (if !defined()) to skip_load_scripts to avoid possible error messages when both basic and premium versions of the plugin are installed.

* Added extra fields to the options page for persistent plugin settings.



= V1.0.5 - 20/03/2012 =

* Replaced my shortcode regex with WordPress's native get_shortcode_regex() function for more precise matching.

* Added a pre-emptive fix to solve a common problem where jQuery dependent scripts (such as Fancybox and NextGEN's slideshow) break if jQuery doesn't load first. Added array('jquery') dependencies to wp_register_script calls (which forces jQuery to not only load when these scripts are called, but load first), as well as add_action priority values to influence their order.

* Launched my new NextGEN Gallery Optimizer *Premium* version which supports ALL TEN of NextGen's shortcodes, supports the [show as slideshow] link, adds targeting for shortcode sub-pages (eg. stylesheet only on album page / both styles and scripts (if selected) on album GALLERY pages) and adds the removal of NextGEN's version number comment.

* Added promotional box to the basic version's settings page.



= V1.0.4 - 18/03/2012 =

* Added an automatic redirect that sends first time users to the plugin options page on first activation.

* Added a one time welcome message on the redirect.

* Added a default setting for the stylesheet in case anyone forgets to set it.

* Added email contact to the settings page and main page at the plugin repository.

* Changed all instances of $nextgen_gallery_optimizer to a global $nggo_options variable for less cumbersome handling of 
database options.

* Moved the stylesheet dropdown if statements to scripts-and-styles.php to keep them together with their register and enqueue calls.



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
= Upgrade to V1.0.6 is recommended for a number of coding improvements. =
= Upgrade to V1.0.5 is recommended for more accurate shortcode detection. =
= Upgrade to V1.0.4 is non-essential. Adds features to assist new users in getting set up. =
= Upgrade to V1.0.3 recommended for improved compatibility with other plugins. =
= Upgrade to V1.0.2 recommended for cross-browser support. =
 