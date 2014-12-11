<?php

/**
 * NextGEN Gallery Optimizer Basic
 *
 * Optimizer improves your site's page load speed by preventing NextGEN's
 * scripts and stylesheets from loading on pages without galleries.
 *
 * What's more, if you're using the original NextGEN Gallery (v1.x.xx) or the
 * NextCellent Gallery fork, Optimizer will intelligently fine-tune all your
 * *gallery* pages too... detecting every shortcode and setting to only load
 * what's necessary.
 *
 * For a full overview of the optimization process, please see...
 * http://www.nextgengalleryoptimizer.com/optimization-flowchart/
 *
 * Optimizer also includes an *enhanced* version of the fantastic Fancybox
 * lightbox script, and only loads it on gallery pages. The result? Gorgeous
 * galleries *and* a speedy site.
 *
 * Now supports NextGEN 2.0, NextGEN Legacy and the NextCellent Gallery fork.
 *
 * Upgrade to Optimizer Pro for the new "NextGEN Gallery Deactivator" feature.
 * A whole new level of speed optimization that only loads NextGEN’s *code* on
 * gallery pages.
 * http://www.nextgengalleryoptimizer.com/#nextgen-gallery-deactivator
 *
 * Upgrade to Optimizer Pro for the new "Dynamic Fancybox Settings Interface".
 * The fastest and easiest way to customize Fancybox. Set title styles,
 * background color and opacity, make Fancybox responsive and more.
 * http://www.nextgengalleryoptimizer.com/#dynamic-fancybox-settings-interface
 *
 * For more information, please see the following...
 * http://www.nextgengalleryoptimizer.com
 * http://www.nextgengalleryoptimizer.com/documentation/
 * http://www.nextgengalleryoptimizer.com/purchase/
 *
 * @package		NextGEN_Gallery_Optimizer_Basic
 * @author		Mark Jeldi | Helpful Media <http://www.nextgengalleryoptimizer.com/contact/>
 * @link				http://www.nextgengalleryoptimizer.com
 * @copyright	2012 - 2014 Mark Jeldi | Helpful Media
 *
 * @wordpress-plugin
 * Plugin Name:	NextGEN Gallery Optimizer
 * Plugin URI:	http://www.nextgengalleryoptimizer.com
 * Description:	<strong>The essential add-on for the NextGEN Gallery WordPress plugin.</strong> Improves your site's page load speed by preventing NextGEN's scripts & stylesheets from loading on pages without galleries. Optimizer also includes an <em>enhanced</em> version of the fantastic Fancybox lightbox script, and only loads it on gallery pages. The result? Gorgeous galleries <em>and</em> a speedy site! Now supports NextGEN 2.0, NextGEN Legacy and the NextCellent Gallery fork. <strong><a href="http://www.nextgengalleryoptimizer.com/purchase/">Upgrade to Optimizer Pro</a></strong> for the new <strong><a href="http://www.nextgengalleryoptimizer.com/#nextgen-gallery-deactivator/">NextGEN Gallery Deactivator</a></strong> feature. A whole new level of speed optimization that only loads NextGEN’s <em>code</em> on gallery pages. Also included in Pro is the new <strong><a href="http://www.nextgengalleryoptimizer.com/#dynamic-fancybox-settings-interface/">Dynamic Fancybox Settings Interface</a></strong>. The fastest and easiest way to customize Fancybox. Set title styles, background color and opacity, make Fancybox <strong><em>responsive</em></strong> and more. See it in action on Optimizer's settings page, or check out the website for a <strong><a href="http://www.nextgengalleryoptimizer.com/#dynamic-fancybox-settings-interface/">live demo</a></strong>.
 * Author:			Helpful Media
 * Version:		2.0
 *
 * Copyright (c) 2012-2014 by Mark Jeldi | Helpful Media | http://www.nextgengalleryoptimizer.com/contact/
 */
 
/**
 * Exit if this file is called directly.
 */
if ( ! defined( 'WPINC' ) ) {

	exit( 'Sorry. You are not allowed to call this page directly.' );

}

/**
 * Check for required PHP version.
 * 
 * As of Optimizer 2.0, we're dropping support for PHP 4.
 * 
 * This shouldn't be an issue as WordPress itself has required PHP 5.2.4 since v3.2 released in July 2011.
 * Read more: http://wordpress.org/news/2010/07/eol-for-php4-and-mysql4/.
 * Additionally, it appears no current WordPress installs (as of Oct 2013) are using anything less than PHP 5.2.
 * See: http://wordpress.org/about/stats/.
 */
if ( version_compare( PHP_VERSION, '5.0', '<' ) ) {
    
	exit( sprintf( 'Sorry. NextGEN Gallery Optimizer requires PHP 5 or greater, <a href="http://wordpress.org/about/requirements">just like WordPress itself since v3.2</a>. You’re still on ' . PHP_VERSION . '. Please contact your host to arrange an upgrade.' ) );

}

/**
 * Check if WordPress version is at least v3.1 before we proceed with installation.
 * 
 * Required for use of the show_admin_bar(), wp_dequeue_script() and
 * get_current_screen() functions introduced in WordPress v3.1.
 */
global $wp_version;

if ( $wp_version < 3.8 ) {
	
	wp_die( __( 'Sorry. NextGEN Gallery Optimizer requires WordPress v3.8 or greater.<br />To proceed, please first <a href="http://codex.wordpress.org/Updating_WordPress" target="_blank">update your installation</a>.' ) );

}

/**
 * NextGEN_Gallery_Optimizer_Basic
 *
 * Our main class to initialize the plugin.
 *
 * We'll route all requests to the appropriate includes depending on whether
 * we're in the admin, or on a public, front-facing screen. This optimizes
 * performance by not loading unnecessary code into memory.
 *
 * Developers can work with this main plugin instance by calling
 * NextGEN_Gallery_Optimizer_Basic::get_instance().
 *
 * @package	NextGEN_Gallery_Optimizer_Basic
 * @author	Mark Jeldi | Helpful Media <http://www.nextgengalleryoptimizer.com/contact/>
 * @since 		2.0.0
 */
 class NextGEN_Gallery_Optimizer_Basic {

 	/**
	 * Optimizer's prefix used as an identifier in plugin file names.
	 * We're defining it here for greater consistency between Basic
	 * and Pro versions.
	 *
	 * @since	2.0.0
	 * @var		string
	 */
	protected $prefix = 'nggobasic';
	 
	/**
	 * Optimizer's version number, used for cache-busting scripts and styles on
	 * plugin updates.
	 *
	 * @since	2.0.0
	 * @var		string
	 */
	protected $version = '2.0.0';

	/**
	 * Fancybox's version number, used for cache-busting scripts and styles on
	 * plugin updates.
	 *
	 * @since	2.0.0
	 * @var		string
	 */	
	protected $fancybox_version = '1.3.4';

	/**
	 * Our Fancybox handle required for registering scripts and styles.
	 *
	 * @since	2.0.0
	 * @var		string
	 */
	protected $fancybox_handle = 'nextgen-gallery-optimizer-basic-enhanced-fancybox-lightbox';

	/**
	 * Optimizer's main settings page slug.
	 *
	 * @since	2.0.0
	 * @var		string
	 */	
	protected $settings_slug = 'nextgen-gallery-optimizer-basic-settings';

	/**
	 * Our options name in the WordPress wp_options database table.
	 *
	 * @since	2.0.0
	 * @var		string
	 */
	protected $db_name = 'nextgen_gallery_optimizer_basic_settings';

	/**
	 * Get Optimizer's settings from the WordPress wp_options database table.
	 *
	 * @since	2.0.0
	 * @var		array
	 * @see		__construct()
	 */
	protected $db;

	/**
	 * Full URL path to our plugin folder.
	 *
	 * @since	2.0.0
	 * @var		string
	 */
	protected $plugin_dir_url;

	/**
	 * Full system file path to our plugin folder.
	 *
	 * @since	2.0.0
	 * @var		string
	 */
	protected $plugin_dir_path;

	/**
	 * Are we using NextGEN Legacy?
	 *
	 * @since	2.0.0
	 * @var		boolean
	 */
	protected $nextgen_v1;
	
	/**
	 * Are we using NextGEN 2.0?
	 *
	 * @since	2.0.0
	 * @var		boolean
	 */
	protected $nextgen_v2;

 	/**
	 * A single instance of this class.
	 *
	 * @since	2.0.0
	 * @var		object
	 * @see		get_instance()
	 */
	protected static $instance = null;

	/**
	 * Access this class's working instance.
	 * If the instance hasn't been set, set it now.
	 *
	 * @wp-hook	void
	 * @uses		void
	 * @since		2.0.0
	 * @return		object of this class
	 */
	public static function get_instance() {

		if ( null == self::$instance ) { self::$instance = new self; }

		return self::$instance;
	
	}
	
	/**
	 * Class constructor.
	 * 
	 * Intentionally left empty and public for unit testing.
	 *
	 * @wp-hook	void
	 * @uses		void
	 * @see			init()
	 * @since		2.0.0
	 * @return 	void
	 */
	public function __construct() {}
	
	/**
	 * Class initialization.
	 *
	 * Get and set required properties, and add our action hooks, function
	 * calls and file includes to initialize this class.
	 *
	 * @wp-hook	plugins_loaded
	 * @uses		get_option()
	 * @since		2.0.0
	 * @return 	void
	 */
	public function init() {

		// Get our main database options.
		$this->db = get_option( $this->db_name );
		
		// Define extra plugin paths.
		$this->plugin_dir_url = plugin_dir_url( __FILE__ );
		$this->plugin_dir_path = plugin_dir_path( __FILE__ );
		
		// Detect which NextGEN codebase we're using.
		$this->get_nextgen_version();

		// Route to either admin classes or front-end classes.
		$this->route_request();
	
	}

	/**
	 * Our class router.
	 * 
	 * Only loads the code required for a given page view.
	 *
	 * Fully separates admin requests from the front-end, and also NextGEN
	 * Legacy code from NextGEN v2.0.
	 *
	 * @wp-hook	void
	 * @uses		is_admin()
	 * @since		2.0.0
	 * @return 	null|void
	 */
	function route_request() {

		if ( is_admin() ) {

			if ( ( basename( $_SERVER['PHP_SELF'] ) == 'plugins.php' ) && ( ! is_array( $this->db ) ) ) {
				
				// Redirect to settings page on first activation.
				add_action( 'init', array( $this, 'redirect_to_settings_page' ) );
			
			}
			
			// Include and instantiate our main admin class.
			require_once( $this->plugin_dir_path . 'admin/class-' . $this->prefix . '-admin.php' );
			$instance = NGGOBASIC_Admin::get_instance();
			$instance->init();

		}
		
		if ( ! is_admin() ) {		

			if ( $this->nextgen_v1 ) {

				require_once( $this->plugin_dir_path . 'public/nextgen-v1/class-' . $this->prefix . '-optimize-nextgen-v1.php' );
				$instance = NGGOBASIC_Optimize_NextGEN_V1::get_instance();
				$instance->init();
				
				add_action( 'init', array( $this, 'remove_nextgen_v1_version' ) );
				add_action( 'wp_head', array( $this, 'add_nextgen_v1_version' ) );

			}

			if ( $this->nextgen_v2 ) {
			
				if ( $this->db['optimize_front_end'] || $this->db['optimize_gallery_pages'] ) { // Optional settings for NextGEN 2.0.

					require_once( $this->plugin_dir_path . 'public/nextgen-v2/class-' . $this->prefix . '-optimize-nextgen-v2.php' );
					$instance = NGGOBASIC_Optimize_NextGEN_V2::get_instance();
					$instance->init();
				
				}

				// Add our version to NextGEN's inline version comment, for easier debugging for both developers.
				add_filter( 'show_nextgen_version', array( $this, 'filter_nextgen_v2_version' ) );

			}

		}

	}

	/**
	 * Allow public access to our main class properties.
	 *
	 * These are required both on the front-end and in the admin.
	 *
	 * To access from another plugin, or in your theme's functions.php file,
	 *	you could either extend this class, or do something like the following...
	 *
	 *	function get_optimizer_dir_url() {
	 *		$plugin = NextGEN_Gallery_Optimizer_Basic::get_instance();
	 *		$vars = $plugin->get_vars();
	 *		$optimizer_dir_url = $vars['plugin_dir_url'];
	 *		echo $optimizer_dir_url;
	 *	}
	 *	add_action( 'init', 'get_optimizer_dir_url' );
	 *
	 *	Note: If calling this class instance from within a plugin, depending on
	 * execution order, you may need to use the plugins_loaded hook or later
	 * to ensure this plugin's files have been included. NextGEN for example,
	 * forces itself to load last after all other plugins, so interaction with the
	 * gallery must come after all plugins have loaded.
	 *
	 * @wp-hook	void
	 * @uses		void
	 * @since		2.0.0
	 * @return 	array $vars
	 */
	public function get_vars() {

		$vars = array(

			"db" => $this->db,
			"db_name" => $this->db_name,
			"prefix" => $this->prefix,
			"version" => $this->version,
			"fancybox_version" => $this->fancybox_version,
			"fancybox_handle" => $this->fancybox_handle,
			"settings_slug" => $this->settings_slug,
			"plugin_dir_path" => $this->plugin_dir_path,
			"plugin_dir_url" => $this->plugin_dir_url,
			"nextgen_v1" => $this->nextgen_v1,
			"nextgen_v2" => $this->nextgen_v2

		);
	
		return $vars;
		
	}

	/**
	 * Check which NextGEN codebase we're using.
	 * 
	 * Options include NextGEN Legacy (up to and including v1.9.13), version
	 * 2.0 or the NextGEN Legacy fork "NextCellent Gallery".
	 *
	 * @wp-hook	void
	 * @uses		get_plugins(), is_plugin_active()
	 * @since		2.0.0
	 * @return		void
	 */
	function get_nextgen_version() {
		
		if ( ! function_exists( 'get_plugins' ) ) {
			
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		
		}

		if ( get_plugins( '/nextgen-gallery' ) && ( is_plugin_active( 'nextgen-gallery/nggallery.php' ) ) ) {
			
			$plugin_folder = get_plugins( '/nextgen-gallery' );
			$plugin_file = 'nggallery.php';
		
			if ( $plugin_folder[$plugin_file]['Version'] < '2.0.0' ) {
				
				$this->nextgen_v1 = true; // Cache the result for use throughout the plugin.
			
			} else {

				$this->nextgen_v2 = true; // Cache the result for use throughout the plugin.
			
			}
		
		}

		if ( get_plugins( '/nextcellent-gallery-nextgen-legacy' ) && ( is_plugin_active( 'nextcellent-gallery-nextgen-legacy/nggallery.php' ) ) ) {

			$this->nextgen_v1 = true;
		
		}

	}

	/**
	 * Remove NextGEN Gallery's version number comment from source code.
	 *
	 * @wp-hook	init
	 * @uses		remove_action()
	 * @since		2.0.0
	 * @return 	void
	 */
	function remove_nextgen_v1_version() {
		
		remove_action( 'wp_head', array( 'nggGallery', 'nextgen_version' ) );

	}

	/**
	 * Add our combined version tags for NextGEN Legacy.
	 *
	 * We're returning this in meta tag format instead of HTML comments, for
	 * greater consistency with the way WordPress adds its own tag.
	 *
	 * @wp-hook	wp_head()
	 * @uses		void
	 * @since		2.0.0
	 * @return 	void
	 */
	function add_nextgen_v1_version() {
	
		global $ngg;
	
		if ( get_plugins( '/nextgen-gallery' ) && ( is_plugin_active( 'nextgen-gallery/nggallery.php' ) ) ) { $gallery = 'NextGEN Gallery'; }
		if ( get_plugins( '/nextcellent-gallery-nextgen-legacy' ) && ( is_plugin_active( 'nextcellent-gallery-nextgen-legacy/nggallery.php' ) ) ) { $gallery = 'NextCellent Gallery'; }
	
		echo '<meta name="generator" content="' . $gallery . ' v' . $ngg->version . '" />' . "\n";
		echo '<meta name="generator" content="NextGEN Gallery Optimizer Basic v' . $this->version . '" />' . "\n";	

	}

	/**
	 * Add our version to NextGEN's inline version tag, for easier debugging
	 * for both developers.
	 *
	 * We're returning this in meta tag format instead of HTML comments, for
	 * greater consistency with the way WordPress adds its own tag.
	 *
	 * @filter		show_nextgen_version
	 * @since		2.0.0
	 * @return 	string $out
	 */	
	function filter_nextgen_v2_version() {
	
		$out  = '<meta name="generator" content="NextGEN Gallery v' . NGG_PLUGIN_VERSION . '" />' . "\n";
		$out .= '<meta name="generator" content="NextGEN Gallery Optimizer Basic v' . $this->version . '" />' . "\n";
		
		return $out;

	}

	/**
	 * Redirect users to settings page on first activation.
	 *
	 * @wp-hook	init
	 * @uses		wp_redirect()
	 * @since		2.0.0
	 * @return		void
	 */
	function redirect_to_settings_page() {
			
		if ( ! is_array( $this->db ) ) {
							
			wp_redirect( admin_url( 'options-general.php?page=' . $this->settings_slug . '', __FILE__ ) );	
			
		}
		
	}

}

/**
 * Instantiate our class.
 */
add_action( 'plugins_loaded', array( NextGEN_Gallery_Optimizer_Basic::get_instance(), 'init' ) );