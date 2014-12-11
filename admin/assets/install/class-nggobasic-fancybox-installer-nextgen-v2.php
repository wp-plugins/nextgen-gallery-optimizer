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
 * NGGOBASIC_Fancybox_Installer_NextGEN_V2
 *
 * Automatic Fancybox installation and integration with NextGEN Gallery v2.0.
 *
 * Creates a new menu option in the lightbox drop-down at
 * Gallery --> Other Options --> Lightbox Effects, and populates the
 * "Show Advanced Settings" fields with our scripts, stylesheets and
 * class/rel codes.
 *
 * This is called via our NGGOBASIC_Admin class, and only loads in the
 * WordPress admin.
 *
 * Developers can work with this instance by calling
 * NGGOBASIC_Fancybox_Installer_NextGEN_V2::get_instance().
 *
 * @package	NextGEN_Gallery_Optimizer_Basic
 * @author	Mark Jeldi | Helpful Media <http://www.nextgengalleryoptimizer.com/contact/>
 * @since 		2.0.0
 */
class NGGOBASIC_Fancybox_Installer_NextGEN_V2 {

	/**
	 * A single instance of the C_NextGen_Settings class.
	 *
	 * @since	2.0.0
	 * @var		object
	 * @see		_construct()
	 */
	protected $ngg_settings;

	/**
	 * The name of our lightbox.
	 *
	 * @since	2.0.0
	 * @var		string
	 */
	protected $lightbox_name = 'nextgen-gallery-optimizer-basic-enhanced-fancybox-lightbox';

	/**
	 * The display name of our lightbox.
	 *
	 * @since	2.0.0
	 * @var		string
	 */
	protected $lightbox_display_name = 'Enhanced Fancybox Lightbox [NextGEN Gallery Optimizer Basic]';

	/**
	 * Our lightbox class/rel code used in each image's anchor tag on the front
	 * end. The class name hooks Fancybox to the image, and the rel tag enables
	 * Fancybox to group images by gallery.
	 *
	 * @since	2.0.0
	 * @var		string
	 */
	protected $lightbox_code  = 'class="nggobasic-fancybox" rel="%GALLERY_NAME%"';

	/**
	 * URL paths to our lightbox scripts.
	 *
	 * @since	2.0.0
	 * @var		string
	 */
	protected $scripts;
	
	/**
	 * URL paths to our lightbox stylesheets.
	 *
	 * @since	2.0.0
	 * @var		string
	 */
	protected $styles;
	
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
	 * @uses		add_action(), register_deactivation_hook()
	 * @since		2.0.0
	 * @return 	void
	 */
	public function init() {

		// Retrieve required properties from our main plugin class.
		$this->plugin = NextGEN_Gallery_Optimizer_Basic::get_instance();
		$vars = $this->plugin->get_vars();
		$this->prefix = $vars['prefix'];
		$this->version = $vars['version'];
		$this->fancybox_version = $vars['fancybox_version'];
		$this->settings_slug = $vars['settings_slug'];
		$this->plugin_dir_url = $vars['plugin_dir_url'];
		$this->plugin_dir_path = $vars['plugin_dir_path'];
		
		// Retrieve required properties from our main admin class.
		$this->admin = NGGOBASIC_Admin::get_instance();
		$vars = $this->admin->get_vars();
		$this->plugin_dir_file = $vars['plugin_dir_file'];
		
		// Get our settings instance.
		$this->settings = NGGOBASIC_Settings::get_instance();
	
		// Access NextGEN's settings instance.
		$this->ngg_settings = C_NextGen_Settings::get_instance();
		
		// Define the path to Fancybox's CSS stylesheet.
		$this->styles = $this->plugin_dir_url . 'fancybox/' . $this->prefix . '.jquery.fancybox-' . $this->fancybox_version . '.css';

		// Define the path to Fancybox's script.
		$this->scripts  = $this->plugin_dir_url . 'fancybox/' . $this->prefix . '.jquery.fancybox-' . $this->fancybox_version . '.pack.js';

		// Reset our class/rel code and script and stylesheet URLs if accidentally changed.
		add_action( 'admin_init', array( $this, 'update_modified_fancybox_urls' ) );
		
		// Register and enqueue Optimizer's JavaScript file for NextGEN's lightbox settings.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_nextgen_options_page_js' ) );
		
		// Install our lightbox on activation, and reinstall on domain change.
		add_action( 'admin_footer', array( $this, 'install_controller' ) );
		
		// Uninstall our Fancybox menu item if Optimizer is deactivated.
		register_deactivation_hook( $this->plugin_dir_file, array( $this, 'uninstall_controller' ) );
		
	}
	
	/**
	 * Controller method for Fancybox installation.
	 *
	 * Install our menu option at Gallery --> Other Options --> Lightbox Effects
	 * upon Optimizer's activation.
	 *
	 * Additionally, as NextGEN 2.0 persists full, hard-coded filepaths for
	 * lightbox scripts and styles to the database, we'll reinstall Fancybox if
	 * a user's domain ever changes (useful for devs moving a client's site
	 * from development to production).
	 *
	 * Also, as the "custom" lightbox effect is no longer an option in NextGEN
	 * 2.0, we'll make our Fancybox lightbox the current selection upon upgrade
	 * from NextGEN v1 if "custom" is selected.
	 *
	 * We're using the admin_footer hook here, so we can capture the current
	 * selection on the same page load as the lightbox form submission (for
	 * when a new selection is being made).
	 *
	 * @wp-hook	admin_footer
	 * @uses		void
	 * @since		2.0.0
	 * @return 	void
	 */	
	function install_controller() {
	
		$this->reset_installation();
	
		$this->capture_previous_lightbox_settings();
	
		// Run our initial installation upon activation or reactivation.
		if ( ! $this->settings->fancybox_installed ) {
			
			/**
			 * Install our lightbox after ensuring there are no duplicate db
			 * entries for users switching back and forth between NextGEN
			 * codebases.
			 */
			$this->uninstall(); 
			$this->install();

			// Set our install flag as true so we only run on activation.
			$this->settings->fancybox_installed = true;
			$this->settings->save();
		
		}
		
		// Reinstall if Fancybox is selected and the site has been moved to a new URL.
		if ( $this->settings->fancybox && $this->settings->lightbox_plugin_dir_url != $this->plugin_dir_url ) {
		
			$this->uninstall_controller();
			$this->install();

			// Reset our URL flag so we only run again on the next domain/directory change.
			$settings = NGGOBASIC_Settings::get_instance();
			$settings->lightbox_plugin_dir_url = $this->plugin_dir_url;
			$settings->save();
			
		}

		// 
		if ( 'custom' == $this->ngg_settings->thumbEffect ) {

			$this->save_fancybox_selection();

		}
		
		$this->set_fancybox_checkbox();

	}

	/**
	 * Reset our Fancybox installation flag if a user has upgraded to
	 * NextGEN 2.0 after using NextGEN Legacy.
	 *
	 * This is required as the two codebases require different methods of
	 * lightbox installation.
	 *
	 * @wp-hook	void
	 * @uses		void
	 * @since		2.0.0
	 * @return 	void
	 */ 
	function reset_installation() {
	
		if ( $this->settings->nextgen_legacy || null === $this->settings->nextgen_legacy ) {

			$this->settings->fancybox_installed = false;
			$this->settings->nextgen_legacy = false;
		
		}
	
	}	

	/**
	 * Capture the previous lightbox selection in Optimizer's settings in order
	 * to restore NextGEN's settings on deactivation, or when our Fancybox
	 * checkbox is deselected on Optimizer's settings page.
	 * 
	 * We'll automatically restore users' previous settings if they only want
	 * to use the Optimization features of Optimizer.
	 *
	 * This also helps resolve a bug where NextGEN changes to "No lightbox"
	 * when Optimizer's Fancybox is uninstalled on plugin deactivation...even
	 * if a different lightbox was selected.
	 *
	 * @wp-hook	void
	 * @uses		void
	 * @since		2.0.0
	 * @return 	void
	 */
	function capture_previous_lightbox_settings() {

		// Run if our thumbEffect setting doesn't match the current selection in NextGEN's settings.
		if ( $this->settings->original_thumbEffect != $this->ngg_settings->thumbEffect ) {
		
			// Only run if the selected lightbox is not Optimizer's Fancybox.
			if ( $this->lightbox_name != $this->ngg_settings->thumbEffect ) {

				// Only run if the selected lightbox is not "custom" when updating from NextGEN v1 to v2.
				if ( 'custom' != $this->ngg_settings->thumbEffect ) {

					// Pass the previous lightbox settings to our NGGOBASIC_Settings instance for saving.
					$this->settings->original_thumbEffect = stripslashes( $this->ngg_settings->thumbEffect );
					$this->settings->original_thumbCode = stripslashes( $this->ngg_settings->thumbCode );
					$this->settings->save();

				}

			}

		}

	}	
	
	/**
	 * Install our menu option at Gallery --> Other Options --> Lightbox Effects,
	 * and programmatically save it as selected.
	 *
	 * Calls our NGGOBASIC_Lightbox_Installer_NextGEN_V2 class, which extends the
	 * "install()" method in NextGEN 2.0's C_Lightbox_Installer.
	 *
	 * @wp-hook	void
	 * @uses		void
	 * @see			NGGOBASIC_Lightbox_Installer_NextGEN_V2 class
	 * @since		2.0.0
	 * @return 	void
	 */
	function install() {

		require_once( $this->plugin_dir_path . 'admin/assets/install/class-' . $this->prefix . '-lightbox-installer-nextgen-v2.php' );
		
		$instance = NGGOBASIC_Lightbox_Installer_NextGEN_V2::get_instance();
		$instance->lightbox_name = $this->lightbox_name;
		$instance->lightbox_display_name = $this->lightbox_display_name;
		$instance->lightbox_code = $this->lightbox_code;
		$instance->scripts = $this->scripts;
		$instance->styles = $this->styles;
		$instance->install();

		if ( $this->settings->fancybox ) {
		
			$this->save_fancybox_selection();

		}
	
	}

	/**
	 * Programmatically save our Fancybox lightbox as the selected option at
	 * Gallery --> Other Options --> Lightbox Effects.
	 *
	 * @wp-hook	void
	 * @uses		void
	 * @since		2.0.0
	 * @return 	void
	 */
	function save_fancybox_selection() {
	
		// Save our lightbox as the current selection.
		$this->ngg_settings->thumbEffect = $this->lightbox_name;
		$this->ngg_settings->thumbCode = $this->lightbox_code;
		$this->ngg_settings->save();

	}

	/**
	 * Toggle the Fancybox checkbox on/off on our settings page depending on
	 * whether our lightbox is selected at Gallery --> Other Options --> Lightbox
	 * Effects.
	 *
	 * Only runs when NextGEN's "Other Options" page is saved.
	 *
	 * @wp-hook	void
	 * @uses		void
	 * @since		2.0.0
	 * @return 	void
	 */
	function set_fancybox_checkbox() {
		
		if ( isset ( $_GET['page'] ) && 'ngg_other_options' == $_GET['page'] ) {
		
			if ( isset( $_POST[ 'lightbox_library_id' ] ) ) {
		
				if ( $this->ngg_settings->thumbEffect == $this->lightbox_name ) {

					$this->settings->fancybox = true;
					$this->settings->save();
				
				} else {

					$this->settings->fancybox = false;
					$this->settings->save();
				
				}
				
			}
			
		}

	}

	/**
	 * Sync Fancybox checkbox with Gallery --> Other Options --> Lightbox Effects.
	 * 
	 * Check if the user has just deactivated Fancybox via our main settings
	 * page checkbox, and if so, restore NextGEN's lightbox selection to its
	 * previous value and show an admin message to notify the user.
	 *
	 * Also, check if the user has just reactivated Fancybox via our main
	 * settings page checkbox, and if so, change NextGEN's lightbox selection
	 * to Optimizer's Fancybox.
	 *
	 * This method is called in our NGGOBASIC_Validation class.
	 *
	 * @wp-hook	void
	 * @uses		void
	 * @see			validate_optimizer_settings()
	 * @since		2.0.0
	 * @return 	void
	 */
	function sync_fancybox_checkbox( $input ) {
		
		$new_input = $input;
		
		// Check for "fancybox_title_position" so we don't run on Fancybox settings.
		if ( ! $new_input['fancybox'] && ! $new_input['fancybox_title_position'] ) {
			
			// Check if the current thumbEffect is set to Optimizer's Fancybox.
			if ( $this->ngg_settings->thumbEffect == $this->lightbox_name ) {
		
				// Restore lightbox to previous selection.
				$this->restore_previous_lightbox_settings();
				
				// Display a notification that the previous selection has been restored.
				$this->display_lightbox_restored_notice();
				
			}

		}

		// The following "fancybox_installed" check is required so as not to run on initial db setup.
		if ( $new_input['fancybox'] && ! $this->settings->fancybox && $this->settings->fancybox_installed ) {	

			// Reselect Optimizer's Fancybox at Gallery --> Other Options --> Lightbox Effects.
			$this->save_fancybox_selection();

		}
		
	}

	/**
	 * Update modified class/rel code and script and stylesheet URLs.
	 *
	 * As it's trivially easy for a user to accidentally edit Fancybox's
	 * inline code or filepaths at Gallery --> Other Options --> Lightbox Effects,
	 * and since there's no way for a user to to automatically restore defaults,
	 * we'll ensure the correct paths are submitted on save.
	 *
	 * @wp-hook	admin_init
	 * @uses		void
	 * @since		2.0.0
	 * @return 	void
	 */	
	function update_modified_fancybox_urls() {
	
		if ( $this->is_nextgen_other_options_page() ) {
		
			// Update Fancybox's inline class name and rel tag if accidentally changed.
			if ( isset( $_REQUEST[ $this->lightbox_name ]['code'] ) ) {
			
				$_REQUEST[ $this->lightbox_name ]['code'] = $this->lightbox_code;
			
			}

			// Update file paths to Fancybox's stylesheets if accidentally changed.
			if ( isset( $_REQUEST[ $this->lightbox_name ]['css_stylesheets'] ) ) {
				
				$_REQUEST[ $this->lightbox_name ]['css_stylesheets'] = $this->styles;
			
			}
			
			// Update file paths to Fancybox's scripts if accidentally changed.
			if ( isset( $_REQUEST[ $this->lightbox_name ]['scripts'] ) ) {
				
				$_REQUEST[ $this->lightbox_name ]['scripts'] = $this->scripts;
			
			}

		}
	
	}

	/**
	 * Restore our previously captured lightbox settings on plugin deactivation
	 * or Fancybox checkbox deselection.
	 *
	 * @wp-hook	void
	 * @uses		void
	 * @since		2.0.0
	 * @return 	void
	 */	
	function restore_previous_lightbox_settings() {

		$this->ngg_settings->thumbEffect = $this->settings->original_thumbEffect;
		$this->ngg_settings->thumbCode = $this->settings->original_thumbCode;
		$this->ngg_settings->save();

	}

	/**
	 * Remove our menu option from Gallery --> Other Options --> Lightbox Effects,
	 * and restore previous lightbox settings.
	 *
	 * @wp-hook	register_deactivation_hook
	 * @uses		update_option()
	 * @since		2.0.0
	 * @return 	void
	 */
	function uninstall_controller() {
		
		$this->uninstall();
		
		$this->restore_previous_lightbox_settings();
		
		// Update our Fancybox installation options so we can run again on reactivation.
		$this->settings->original_thumbEffect = 'none';
		$this->settings->original_thumbCode = '';
		$this->settings->fancybox_installed = false;
		$this->settings->save_settings();
	
	}

	/**
	 * Remove our menu option from Gallery --> Other Options --> Lightbox Effects,
	 * and the associated meta-data NextGEN inserts in the wp_postmeta table.
	 *
	 * @wp-hook	register_deactivation_hook
	 * @uses		update_option()
	 * @since		2.0.0
	 * @return 	void
	 */
	function uninstall() {
	
		require_once( $this->plugin_dir_path . 'admin/assets/install/class-' . $this->prefix . '-lightbox-installer-nextgen-v2.php' );
		$instance = NGGOBASIC_Lightbox_Installer_NextGEN_V2::get_instance();
		$instance->do_uninstall( $this->lightbox_name );
	
	}

	/**
	 * Check if we're on NextGEN's "Lightbox Effects" page.
	 *
	 * We're doing this the PHP way, as some of our hooks (inc. admin_head)
	 * fire too early to use get_current_screen();
	 *
	 * @wp-hook	void
	 * @uses		void
	 * @since		2.0.0
	 * @return 	void|true
	 */
	function is_nextgen_other_options_page() {
	
		if ( isset( $_GET['page'] ) && 'ngg_other_options' == $_GET['page'] ) {
		
			return true;
		
		}
	
	}

	/**
	 * Display a message on Optimizer's main settings page if Fancybox's
	 * checkbox is unchecked, notifying users that their previous lightbox
	 * selection has been restored.
	 *
	 * @wp-hook	void
	 * @uses		add_settings_error()
	 * @since		2.0.0
	 * @return 	void
	 */
	function display_lightbox_restored_notice() {

		$lightbox = $this->ngg_settings->thumbEffect;

		if ( $lightbox == 'none' ) { $lightbox = 'No lightbox'; }
		if ( $lightbox == 'fancybox' ) { $lightbox = 'Default Fancybox'; }
		if ( $lightbox == 'shutter2' ) { $lightbox = 'Shutter 2'; }

		$lightbox = ucfirst( $lightbox ); // Capitalize the first letter of other current thumbEffect settings for display purposes.

		$out  = '<font style="font-weight:bold !important;">Settings updated.</font><br />';
		$out .= '<font style="font-weight:normal !important;">';
		$out .= 'As Fancybox has been deselected, Optimizer has just restored your previous NextGEN lightbox selection of "<b><i>' . $lightbox . '</i></b>" at ';
		$out .= '<a href="' . admin_url( 'admin.php?page=ngg_other_options', __FILE__ ) . '">Gallery --> Other Options --> Lightbox Effects</a>.<br />';
		$out .= 'To resume using Optimizer\'s Enhanced Fancybox Lightbox, simply select it below, click Save Options, and NextGEN\'s Lightbox Effects will be automatically updated.';
		
		$out .= '</font>';
		
		add_settings_error( $this->settings_slug, 'previous-lightbox-selection-restored', $out, 'updated' );

	}

	/**
	 * Enqueue NextGEN options page JS.
	 *
	 * Register and enqueue Optimizer's JavaScript file for NextGEN's lightbox
	 * settings.
	 *
	 * This script loads on NextGEN v2's "Other Options" page only.
	 *
	 * Inserts a message at Gallery --> Other Options --> Lightbox Effects
	 * (when Optimizer's Enhanced Fancybox Lightbox is selected), to help
	 * inform users about the benefits of Optimizer's Enhanced Fancybox
	 * Lightbox, and introduce them to the new Dynamic Fancybox Settings
	 * Interface available in Optimizer Pro.
	 *
	 * @wp-hook	admin_enqueue_scripts
	 * @uses		wp_register_script(), wp_enqueue_script()
	 * @uses		wp_localize_script()
	 * @since		2.0.0
	 * @return 	void
	 */
	function enqueue_nextgen_options_page_js() {

		if ( $this->is_nextgen_other_options_page() ) {

			wp_register_script( $this->prefix . '-nextgen-options-page', $this->plugin_dir_url . 'admin/assets/install/js/' . $this->prefix . '-nextgen-v2-fancybox-install.min.js', array( 'jquery' ), $this->version );
			wp_enqueue_script( $this->prefix . '-nextgen-options-page' );

			// Include a small CDATA block to pass localized data to our script.
			wp_localize_script( $this->prefix . '-nextgen-options-page', $this->prefix . 'NextGENOptionsPage', array(
					'optimizerSettingsURL' => admin_url( 'options-general.php?page=' . $this->settings_slug ),
					'enhancedFancyboxName' => $this->lightbox_name
				)
			);

		}
	
	}

}