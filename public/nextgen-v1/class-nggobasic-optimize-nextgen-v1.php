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
 */

/**
 * Exit if this file is called directly.
 */
if ( ! defined( 'WPINC' ) ) {

	exit( 'Sorry. You are not allowed to call this page directly.' );

}

/**
 * NGGOBASIC_Optimize_NextGEN_V1
 *
 * Our main public class for NextGEN Legacy (v1.6.2 to 1.9.13) to perform
 * front-facing optimization of NextGEN's scripts and styles.
 *
 * This class removes all scripts and styles inserted by NextGEN Legacy, and
 * includes our NGGOBASIC_Shortcode_Regex class to conditionally load only the
 * scripts and stylesheets required, speeding up page loads.
 *
 * This is called via our main NextGEN_Gallery_Optimizer_Basic class, and only
 * loads on front-end requests (when NextGEN Legacy is installed).
 *
 * Developers can work with this instance by calling
 * NGGOBASIC_Optimize_NextGEN_V1::get_instance().
 *
 * @package	NextGEN_Gallery_Optimizer_Basic
 * @author	Mark Jeldi | Helpful Media <http://www.nextgengalleryoptimizer.com/contact/>
 * @since 		2.0.0
 */
 class NGGOBASIC_Optimize_NextGEN_V1 {

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
	 * @wp-hook	void
	 * @uses		add_action()
	 * @since		2.0.0
	 * @return 	void
	 */
	public function init() {

		// Retrieve required properties from our main plugin class.
		$this->plugin = NextGEN_Gallery_Optimizer_Basic::get_instance();
		$vars = $this->plugin->get_vars();
		$this->db = $vars['db'];
		$this->prefix = $vars['prefix'];
		$this->plugin_dir_path = $vars['plugin_dir_path'];

		add_action( 'init', array( $this, 'remove_scripts_nextgen_v1' ) );
		add_action( 'wp_print_styles', array( $this, 'remove_styles_nextgen_v1' ), 1000 );		

		require_once( $this->plugin_dir_path . 'public/nextgen-v1/class-' . $this->prefix . '-register-scripts.php' );
		$this->register_scripts = NGGOBASIC_Register_Scripts::get_instance();
		$this->register_scripts->init();
		
		require_once( $this->plugin_dir_path . 'public/nextgen-v1/class-' . $this->prefix . '-shortcode-regex.php' );
		$this->shortcode_regex = NGGOBASIC_Shortcode_Regex::get_instance();
		$this->shortcode_regex->init();
		
		require_once( $this->plugin_dir_path . 'public/nextgen-v1/class-' . $this->prefix . '-nextgen-widgets.php' );
		$this->nextgen_widgets = NGGOBASIC_NextGEN_Widgets::get_instance();
		$this->nextgen_widgets->init();
		
	}
	
	/**
	 * Remove NextGEN Gallery's scripts [works on NextGEN v1.6.2 and above].
	 *
	 * @wp-hook	init
	 * @uses		void
	 * @since		2.0.0
	 * @return 	void
	 */
	function remove_scripts_nextgen_v1() {
			
		if ( ! defined( 'NGG_SKIP_LOAD_SCRIPTS' ) ) {
			
			define( 'NGG_SKIP_LOAD_SCRIPTS', true );
		
		}
	
	}

	/**
	 * Remove NextGEN Gallery's styles [works on NextGEN v1.6.2 and above].
	 *
	 * @wp-hook	wp_print_styles
	 * @uses		wp_deregister_style()
	 * @since		2.0.0
	 * @return 	void
	 */
	function remove_styles_nextgen_v1() {

		wp_deregister_style( 'NextGEN' );
		wp_deregister_style( 'shutter' );
		wp_deregister_style( 'thickbox' );
	
	}

}