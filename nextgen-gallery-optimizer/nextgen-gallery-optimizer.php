<?php
/*
Plugin Name: NextGEN Gallery Optimizer
Description: Optimizes your site's page load speed by ensuring NextGEN Gallery's scripts and styles ONLY load on posts with the [nggallery id=x] shortcode. Also includes and integrates the fantastic Fancybox lightbox script, so now you can have gorgeous galleries AND a speedy site!
Author: Mark Jeldi
Author URI: http://www.markstechnologynews.com
Version: 1.0
License: GPL
*/

/**************************************************
* global variables
**************************************************/

$nextgen_optimizer_prefix = 'nextgen_optimizer_';
$nextgen_optimizer_plugin_name = 'NextGEN Gallery Optimizer';

// retrieve our plugin settings from the options table
$nextgen_optimizer_options = get_option('nextgen_optimizer_settings');

/**************************************************
* includes
**************************************************/

include('nextgen-optimizer-functions.php'); // plugin functionality
include('nextgen-optimizer-options.php'); // the plugin options page HTML, linked CSS and save functions

/**************************************************
* add options page
**************************************************/

// call our stylesheet
function nextgen_optimizer_load_styles() {
	wp_enqueue_style('nextgen_optimizer_styles', plugin_dir_url( __FILE__ ) . 'css/nextgen-optimizer-options.css');
}

// attach the above wp_enqueue_style so our stylesheet only loads on the options page we're building
function nextgen_optimizer_add_options_page() {
	$nextgen_optimizer_options_page = add_options_page('NextGEN Gallery Optimizer', 'NextGEN Optimizer', 'manage_options', 'nextgen_optimizer_options', 'nextgen_optimizer_options_page');
	add_action('admin_print_styles-' . $nextgen_optimizer_options_page, 'nextgen_optimizer_load_styles');
}

// create options page complete with attached css file and link in admin menu. 
add_action('admin_menu', 'nextgen_optimizer_add_options_page');

/**************************************************
* save settings
**************************************************/

// create our settings in the options table
function nextgen_optimizer_register_settings() {
	register_setting('nextgen_optimizer_settings_group', 'nextgen_optimizer_settings');
}
add_action('admin_init', 'nextgen_optimizer_register_settings');

/**************************************************
* add settings & donate links on plugins page
**************************************************/

function nextgen_optimizer_settings_link($links, $file) {
	if ($file == plugin_basename(__FILE__)) {
		$links[] = '<a href="'.admin_url('options-general.php?page=nextgen_optimizer_options').'">Settings</a>';
		$links[] = '<a href="http://wordpress.org/tags/nextgen-gallery-optimizer?forum_id=10">Support Forum</a>';
		$links[] = '<a href="http://wordpress.org/extend/plugins/nextgen-gallery-optimizer">Rate this plugin</a>';
		$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YGS3ANA29BJ2W">Donate</a>';
	}
	return $links;
}
add_filter('plugin_row_meta', 'nextgen_optimizer_settings_link', 10, 2);