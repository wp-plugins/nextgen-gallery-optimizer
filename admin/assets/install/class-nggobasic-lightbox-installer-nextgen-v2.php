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
 * Avoid error if NextGEN Gallery isn't installed.
 */
if ( ! class_exists( 'C_Lightbox_Installer' ) ) {
	
	return;

}

/**
 * NGGOBASIC_Lightbox_Installer_NextGEN_V2
 *
 * Provides the functionality to install a lightbox in NextGEN Gallery.
 *
 * This is called conditionally as required (to improve performance) and
 * only loads in the WordPress admin.
 *
 * Developers can work with this instance by calling
 * NGGOBASIC_Lightbox_Installer_NextGEN_V2::get_instance().
 *
 * @package	NextGEN_Gallery_Optimizer_Basic
 * @author	Mark Jeldi | Helpful Media <http://www.nextgengalleryoptimizer.com/contact/>
 * @since 		2.0.0
 */
 class NGGOBASIC_Lightbox_Installer_NextGEN_V2 extends C_Lightbox_Installer {

 	/**
	 * The name of our lightbox.
	 *
	 * @since	2.0.0
	 * @var		string
	 */
	public $lightbox_name;

 	/**
	 * The display name of our lightbox.
	 *
	 * @since	2.0.0
	 * @var		string
	 */
	public $lightbox_display_name;
	
	/**
	 * Our lightbox class/rel code.
	 *
	 * @since	2.0.0
	 * @var		string
	 */
	public $lightbox_code;

	/**
	 * URL paths to our lightbox scripts.
	 *
	 * @since	2.0.0
	 * @var		string
	 */
	public $scripts;
	
	/**
	 * URL paths to our lightbox stylesheets.
	 *
	 * @since	2.0.0
	 * @var		string
	 */
	public $styles;
 
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
	 * @wp-hook	void
	 * @uses		void
	 * @since		2.0.0
	 * @return 	void
	 */
	public function __construct() {
	
		parent::__construct();
	
	}

	/**
	 * Install our menu option at Gallery --> Other Options --> Lightbox Effects
	 *
	 * Extends the "install()" method in NextGEN's C_Lightbox_Installer.
	 *
	 * @wp-hook	void
	 * @uses		void
	 * @since		2.0.0
	 * @return 	void
	 */
	function install() {

		$this->install_lightbox(
			
			$this->lightbox_name,
			$this->lightbox_display_name,
			$this->lightbox_code,
			array( $this->styles ),
			array( $this->scripts )
		
		);
	
	}

	/**
	 * Remove our menu option from Gallery --> Other Options --> Lightbox Effects,
	 * and the associated meta data in the wp_postmeta database table.
	 *
	 * Calls the "uninstall_lightbox()" method in NextGEN's C_Lightbox_Installer,
	 * with our lightbox name as a parameter.
	 *
	 * Note: Can't use "uninstall" method name here as it's used in NextGEN for
	 * a hard reset (uninstalls all lightboxes).
	 *
	 * @wp-hook	void
	 * @uses		void
	 * @since		2.0.0
	 * @param	string $lightbox_name
	 * @return 	void
	 */
	function do_uninstall( $lightbox_name ) {
		
		parent::uninstall_lightbox( $lightbox_name );
	
	}
	
}