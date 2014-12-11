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
 * NGGOBASIC_Optimize_NextGEN_V2
 *
 * Optimizes the front-end of your site when running NextGEN Gallery 2.0+.
 *
 * Removes NextGEN's unnecessary sitewide scripts and styles from all
 * non-gallery pages.
 *
 * In addition, this also removes all unnecessary scripts and styles from
 * *gallery* pages, based on the selections made in the "Advanced options"
 * section on Optimizer's settings page.
 *
 * This is called via our main NextGEN_Gallery_Optimizer_Basic class, and only
 * loads on front-end requests (when NextGEN v2 is installed).
 *
 * Developers can work with this instance by calling
 * NGGOBASIC_Optimize_NextGEN_V2::get_instance().
 *
 * @package	NextGEN_Gallery_Optimizer_Basic
 * @author	Mark Jeldi | Helpful Media <http://www.nextgengalleryoptimizer.com/contact/>
 * @since 		2.0.0
 */
class NGGOBASIC_Optimize_NextGEN_V2 {

 	/**
	 * Do we have any shortcodes on the current page?
	 *
	 * @since	2.0.0
	 * @var		boolean
	 */
	protected $shortcodes;

 	/**
	 * Do we have any ATP attachments on the current page?
	 *
	 * @since	2.0.0
	 * @var		boolean
	 */
	protected $atp_attachments;

 	/**
	 * Do we have any widgets on the current page?
	 *
	 * @since	2.0.0
	 * @var		boolean
	 */
	protected $widgets;

 	/**
	 * Do we have related images on the current page?
	 *
	 * @since	2.0.0
	 * @var		boolean
	 */
	protected $related_images;

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
		$this->version = $vars['version'];
		$this->plugin_dir_url = $vars['plugin_dir_url'];
		$this->plugin_dir_path = $vars['plugin_dir_path'];
		$this->fancybox_handle = $vars['fancybox_handle'];
		$this->fancybox_version = $vars['fancybox_version'];

		// Run our shortcode regex.
		add_action( 'wp', array( $this, 'get_shortcode_regex' ) );

		// Priority 1 is important for all three of these calls, in order to be able to remove *all* unnecessary stylesheets in the head.
		add_action( 'wp_print_styles', array( $this, 'detect_widgets' ), 1 ); 
		add_action( 'wp_print_styles', array( $this, 'detect_related_images' ), 1 );
		add_action( 'wp_print_styles', array( $this, 'remove_scripts_and_styles' ), 1 );
		
		// Update our script dependencies set by NextGEN.
		add_action( 'wp_footer', array( $this, 'update_fancybox_script_dependencies' ) );
		
		// Ensure a fresh version of our Fancybox script is loaded by the browser (but only if it's been updated).
		add_filter( 'script_loader_src', array( $this, 'update_fancybox_script_versioning' ) );
		
		// Ensure a fresh version of our Fancybox stylesheet is loaded by the browser (but only after an Optimizer update).
		add_filter( 'style_loader_src', array( $this, 'update_fancybox_stylesheet_versioning' ) );

	}
	
	/**
	 * Main shortcode regex to check for all eleven NextGEN shortcodes,
	 * including [nggalbum id=x] introduced in NextGEN v.1.9.12.
	 *
	 * If any are found, $this->shortcodes is set to true.
	 *
	 * Also checks the post/page content for any Attach to Post attachments
	 * introduced in NextGEN 2.0.xx.
	 *
	 * If any are found, $this->atp_attachments is set to true.
	 *
	 * @wp-hook	wp
	 * @uses		get_shortcode_regex()
	 * @global		$wp_query	 
	 * @since		2.0.0
	 * @return		void
	 */
	function get_shortcode_regex() {

		global $wp_query;
		
		$posts = $wp_query->posts;
		$pattern = get_shortcode_regex();

		foreach ( $posts as $post ) {
			
			/**
			 * Search for all NextGEN shortcodes in posts and pages using the
			 * built-in WordPress shortcode regex.
			 */
			preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches );

			if ( array_key_exists( 2, $matches ) ) {
				
				if ( in_array( 'nggallery', $matches[2] ) ||
				in_array( 'album', $matches[2] ) ||
				in_array( 'nggalbum', $matches[2] ) ||
				in_array( 'slideshow', $matches[2] ) ||
				in_array( 'imagebrowser', $matches[2] ) ||
				in_array( 'singlepic', $matches[2] ) ||
				in_array( 'thumb', $matches[2] ) ||
				in_array( 'random', $matches[2] ) ||
				in_array( 'recent', $matches[2] ) ||
				in_array( 'tagcloud', $matches[2] ) ||
				in_array( 'nggtags', $matches[2] ) ||
				
				// New in NextGEN 2.0.
				in_array( 'ngg_images', $matches[2] ) ) {
					
					$this->shortcodes = true;

				}
				
			}
			
			/**
			 * Search for all NextGEN Attach-to-Post Interface placeholders
			 * in posts and pages.
			 */		
			if ( strpos( $post->post_content, 'nextgen-attach_to_post/preview' ) ) {
				
				$this->atp_attachments = true;
			
			}
			
		}
		
	}

	/**
	 * Detect if a NextGEN gallery widget or slideshow widget is both active,
	 * and actually present on the current page.
	 *
	 * @wp-hook	wp_print_styles()
	 * @uses		is_active_widget()
	 * @uses		wp_style_is() 
	 * @since		2.0.0
	 * @return		void
	 */
	function detect_widgets() {
	
		if ( is_active_widget( '', '', 'ngg-images' ) ||  is_active_widget( '', '', 'slideshow' ) ) {
	
			// Detect if a NextGEN widget is actually present on the page.
			if ( wp_style_is( 'nextgen_widgets_style' ) ) {

				$this->widgets = true;
			
			}

		}	
			
	}

	/**
	 * Detect if NextGEN's "Related Images" are being displayed.
	 *
	 * @wp-hook	wp_print_styles()
	 * @uses		is_single()
	 * @global		$ngg
	 * @since		2.0.0
	 * @return		void
	 */
	function detect_related_images() {
	
		global $ngg;
	
		if ( is_single() ) {
		
			if ( isset( $ngg->options['activateTags'] ) && true == $ngg->options['activateTags'] ) {
		
				$this->related_images = true;
				
			}
			
		}
		
	}

	/**
	 * Controller to remove NextGEN's scripts and stylesheets.
	 *
	 * Determines if we're on a gallery page, or a non-gallery page, in order
	 * to remove the appropriate scripts and styles.
	 *
	 * @wp-hook	wp_print_styles()
	 * @since		2.0.0
	 * @return		void
	 */
	function remove_scripts_and_styles() {
	
		// Remove unnecessary scripts and styles from *non-gallery* pages.
		if ( ! $this->shortcodes && ! $this->atp_attachments && ! $this->widgets && ! $this->related_images && $this->db['optimize_front_end'] ) {
		
			$this->remove_non_gallery_page_scripts_and_styles();
			
		}

		// Remove unnecessary scripts and styles from *gallery* pages.
		if ( $this->shortcodes || $this->atp_attachments || $this->widgets || $this->related_images ) {
		
			$this->remove_gallery_page_scripts_and_styles();
			
		}
		
	}

	/**
	 * Conditionally remove NextGEN 2.0's unused scripts and styles from
	 * non-gallery pages.
	 *
	 * Only runs if our get_shortcode_regex() method finds no shortcodes or
	 * Attach-to-Post placeholders on the current page.
	 *
	 * @wp-hook	void
	 * @uses		add_action() 
	 * @since		2.0.0
	 * @return		void
	 */
	function remove_non_gallery_page_scripts_and_styles() {

		// JS.
		add_action( 'wp_print_scripts', array( $this, 'remove_photocrati_ajax_js_and_cdata' ) );
		add_action( 'wp_print_scripts', array( $this, 'remove_lazy_resources_js' ) );
		add_action( 'wp_print_scripts', array( $this, 'remove_frame_event_publisher_js' ) );
		add_action( 'wp_print_scripts', array( $this, 'remove_ngg_store_js' ) );
		add_action( 'wp_print_scripts', array( $this, 'remove_non_gallery_page_lightbox_context_script' ) );

		// CSS.
		add_action( 'wp_print_styles', array( $this, 'remove_font_awesome_css' ) );
		add_action( 'wp_print_styles', array( $this, 'remove_related_images_css' ) );
		
	}

	/**
	 * Conditionally remove NextGEN 2.0's unused scripts and styles from
	 * *gallery* pages.
	 *
	 * Only runs if our get_shortcode_regex() method finds shortcodes or
	 * Attach-to-Post placeholders on the current page.
	 *
	 * @wp-hook	void
	 * @uses		add_action() 
	 * @since		2.0.0
	 * @return		void
	 */
	function remove_gallery_page_scripts_and_styles() {

		// JS.
		if ( $this->db['remove_photocrati_ajax_js_and_cdata'] ) { add_action( 'wp_print_scripts', array( $this, 'remove_photocrati_ajax_js_and_cdata' ) ); }
		if ( $this->db['remove_lazy_resources_js'] ) { add_action( 'wp_print_scripts', array( $this, 'remove_lazy_resources_js' ) );}		
		if ( $this->db['remove_frame_event_publisher_js'] ) { add_action( 'wp_print_scripts', array( $this, 'remove_frame_event_publisher_js' ) ); }	
		if ( $this->db['remove_ngg_store_js'] ) { add_action( 'wp_print_scripts', array( $this, 'remove_ngg_store_js' ) ); }
		if ( $this->db['remove_lightbox_context_js'] ) { add_action( 'wp_print_scripts', array( $this, 'remove_gallery_page_lightbox_context_script' ) ); }		
		if ( $this->db['remove_common_js_and_cdata'] ) { add_action( 'wp_print_scripts', array( $this, 'remove_common_js_and_cdata' ) ); }
		if ( $this->db['remove_nextgen_basic_thumbnails_js'] ) { add_action( 'wp_print_scripts', array( $this, 'remove_nextgen_basic_thumbnails_js' ) ); }
		
		// CSS.
		if ( $this->db['remove_font_awesome_css'] ) { add_action( 'wp_print_styles', array( $this, 'remove_font_awesome_css' ) ); }
		if ( $this->db['remove_ngg_trigger_buttons_css'] ) { add_action( 'wp_print_styles', array( $this, 'remove_ngg_trigger_buttons_css' ) ); }
		if ( $this->db['remove_related_images_css'] ) { add_action( 'wp_print_styles', array( $this, 'remove_related_images_css' ) ); }
		if ( $this->db['remove_nextgen_pagination_css'] ) { add_action( 'wp_print_styles', array( $this, 'remove_nextgen_pagination_css' ) ); }

	}
	
	/**
	 * Remove inline "photocrati_ajax" CDATA and "ajax.js" script.
	 *
	 * See: "nextgen-gallery/products/photocrati_nextgen/modules/ajax/static/
	 * ajax.js".
	 *
	 * @wp-hook	wp_print_scripts()
	 * @uses		wp_dequeue_script() 
	 * @since		2.0.0
	 * @return		void
	 */
	function remove_photocrati_ajax_js_and_cdata() {
		
		wp_dequeue_script( 'photocrati_ajax' );
	
	}

	/**
	 * Remove "lazy_resources.js" and "sidjs-0.1.js" from early versions of
	 * NextGEN 2.0.
	 *
	 * See: "nextgen-gallery/products/photocrati_nextgen/modules/
	 * resource_minifier/static/sidjs-0.1.js".
	 *
	 * See: "nextgen-gallery/products/photocrati_nextgen/modules/
	 * resource_minifier/static/lazy_resources.js".
	 *
	 * @wp-hook	wp_print_scripts()
	 * @uses		wp_dequeue_script() 
	 * @since		2.0.0
	 * @return		void
	 */
	function remove_lazy_resources_js() {

		wp_dequeue_script( 'lazy_resources' );		
	
	}

	/**
	 * Remove "frame_event_publisher.js" from early versions of NextGEN 2.0.
	 *
	 * See: "nextgen-gallery/products/photocrati_nextgen/modules/
	 * frame_communication/static/frame_event_publisher.js".
	 *
	 * @wp-hook	wp_print_scripts()
	 * @uses		wp_dequeue_script() 
	 * @since		2.0.0
	 * @return		void
	 */
	function remove_frame_event_publisher_js() {

		wp_dequeue_script( 'frame_event_publisher' );

	}

	/**
	 * Remove persistent storage scripts "persist.js", "store.js" and
	 * "ngg_store.js".
	 *
	 * See: "nextgen-gallery/products/photocrati_nextgen/modules/ajax/static/
	 * persist.js".
	 *
	 * See: "nextgen-gallery/products/photocrati_nextgen/modules/ajax/static/
	 * store.js".
	 *
	 * See "nextgen-gallery/products/photocrati_nextgen/modules/ajax/static/
	 * ngg_store.js".
	 *
	 * @wp-hook	wp_print_scripts()
	 * @uses		wp_dequeue_script() 
	 * @since		2.0.0
	 * @return		void
	 */
	function remove_ngg_store_js() {

		wp_dequeue_script( 'ngg-store-js' );
	
	}

	/**
	 * Remove "lightbox_context.js" on *non-gallery* pages.
	 *
	 * This is only called when the “What must the lightbox be applied to?” option
	 * at Gallery --> Other Options --> Lightbox Effects is set to the default
	 * of ”Only apply to NextGEN images”.
	 *
	 * It also only fires if the “Show Related Images on Posts?” option at
	 * Gallery --> Other Options --> Image Options is deactivated, as they
	 * count as NextGEN images.
	 *
	 * Additionally, if the “Show Related Images on Posts?” option is
	 * activated, and either "Enhanced Fancybox Lightbox" or "No Lightbox" is
	 * selected, we'll remove the script also, as it's not being used.
	 *
	 * See: "nextgen-gallery/products/photocrati_nextgen/modules/lightbox/
	 * static/lightbox_context.js".
	 *
	 * @wp-hook	wp_print_scripts
	 * @uses		wp_dequeue_script
	 * @global		$ngg
	 * @since		2.0.0
	 * @return 	void
	 */
	function remove_non_gallery_page_lightbox_context_script() {

		global $ngg;
		
		if ( isset( $ngg->options['thumbEffectContext'] ) && 'nextgen_images' == $ngg->options['thumbEffectContext'] ) {
		
			if ( isset( $ngg->options['activateTags'] ) && false == $ngg->options['activateTags'] ) {

				wp_dequeue_script( 'nextgen_lightbox_context' );
				
			} else {
			
				// If Show Related Images is *true*, and our "Enhanced Fancybox Lightbox" or "No Lightbox" is set, we can remove the script also.
				if ( $this->db['fancybox'] || isset( $ngg->options['thumbEffect'] ) && 'none' == $ngg->options['thumbEffect'] ) {
				
					wp_dequeue_script( 'nextgen_lightbox_context' );
					
				}
				
			}
			
		}

	}

	/**
	 * Remove "lightbox_context.js" on *gallery* pages.
	 *
	 * We'll only fire this when Optimizer's "Enhanced Fancybox Lightbox" or
	 * "No Lightbox" is selected at Gallery -> Other Options -> Lightbox
	 * Effects.
	 *
	 * This is due to NextGEN depending on a method called
	 * "nextgen_lightbox_filter_selector()" in that JS file for every one of
	 * its lightboxes.
	 *
	 * If it's not loaded, all of its lightboxes break, returning an "Uncaught
	 * ReferenceError: nextgen_lightbox_filter_selector is not defined" in the
	 * console.
	 *
	 * See: "nextgen-gallery/products/photocrati_nextgen/modules/lightbox/
	 * static/lightbox_context.js".
	 *
	 * @wp-hook	wp_print_scripts
	 * @uses		wp_dequeue_script
	 * @global		$ngg
	 * @since		2.0.0
	 * @return 	void
	 */
	function remove_gallery_page_lightbox_context_script() {

		global $ngg;
		
		if ( $this->db['fancybox'] || isset( $ngg->options['thumbEffect'] ) && 'none' == $ngg->options['thumbEffect'] ) {

			wp_dequeue_script( 'nextgen_lightbox_context' );
			
		}

	}

	/**
	 * Remove NextGEN 2.0's "common.js" and its 1.5KB inline CDATA block.
	 *
	 * This is only performed when Optimizer's "Enhanced Fancybox Lightbox" or
	 * "No Lightbox" is selected at Gallery --> Other Options --> Lightbox
	 * Effects, as all the built-in lightboxes require these as a dependency.
	 *
	 * Note: We're only able to dequeue this for Fancybox, as we're first
	 * deleting the imposed dependency.
	 *
	 * We do this in "update_fancybox_script_dependencies()" (which updates
	 * $wp_scripts).
	 *
	 * See: "nextgen-gallery/products/photocrati_nextgen/modules/
	 * nextgen_gallery_display/static/common.js".
	 *
	 * @wp-hook	wp_print_scripts
	 * @uses		wp_dequeue_script
	 * @global		$ngg
	 * @since		2.0.0
	 * @return 	void
	 */
	function remove_common_js_and_cdata() {
	
		global $ngg;
		
		if ( $this->db['fancybox'] || isset( $ngg->options['thumbEffect'] ) && 'none' == $ngg->options['thumbEffect'] ) {
		
			wp_dequeue_script( 'ngg_common' );
		
		}
	
	}

	/**
	 * Remove "nextgen_basic_thumbnails.js".
	 *
	 * Appears to be an empty file.
	 *
	 * See: "nextgen-gallery/products/photocrati_nextgen/modules/
	 * nextgen_basic_gallery/static/thumbnails/nextgen_basic_thumbnails.js".
	 *
	 * @wp-hook	wp_print_scripts
	 * @uses		wp_dequeue_script
	 * @since		2.0.0
	 * @return 	void
	 */
	function remove_nextgen_basic_thumbnails_js() {
	
		wp_dequeue_script( 'photocrati-nextgen_basic_thumbnails' );
	
	}

	/**
	 * Remove "font-awesome.css"
	 *
	 * See: "nextgen-gallery/products/photocrati_nextgen/modules/
	 * nextgen_gallery_display/static/fontawesome/font-awesome.css".
	 *
	 * @wp-hook	wp_print_styles()
	 * @uses		wp_dequeue_style() 
	 * @since		2.0.0
	 * @return		void
	 */
	function remove_font_awesome_css() {

		wp_dequeue_style( 'fontawesome' );
		
	}

	/**
	 * Remove NextGEN's "ngg_trigger_buttons.css".
	 * 
	 * See: "nextgen-gallery/products/photocrati_nextgen/modules/
	 * nextgen_gallery_display/static/trigger_buttons.css"
	 *
	 * @wp-hook	wp_print_styles()
	 * @uses		wp_dequeue_style()
	 * @since		2.0.0
	 * @return 	void
	 */
	function remove_ngg_trigger_buttons_css() {
	
		wp_dequeue_style( 'ngg_trigger_buttons' );
	
	}

	/**
	 * Remove "nextgen_gallery_related_images.css", but only when the “Show
	 * Related Images on Posts?” option at Gallery -> Other Options -> Image
	 * Options is deactivated.
	 *
	 * Additionally, if “Show Related Images on Posts?” is set, only remove it
	 * if we're not on a post page.
	 *
	 * See: "nextgen-gallery/products/photocrati_nextgen/modules/
	 * nextgen_gallery_display/static/nextgen_gallery_related_images.css".
	 *
	 * @wp-hook	wp_print_styles
	 * @uses		wp_dequeue_style
	 * @global		$ngg
	 * @since		2.0.0
	 * @return 	void
	 */
	function remove_related_images_css() {

		global $ngg;
		
		if ( isset( $ngg->options['activateTags'] ) ) {
		
			if ( false == $ngg->options['activateTags'] ) {

				wp_dequeue_style( 'nextgen_gallery_related_images' );

			} else {
			
				if ( ! is_single() ) {	
					
					wp_dequeue_style( 'nextgen_gallery_related_images' );
					
				}
			
			}
			
		}

	}

	/**
	 * Remove NextGEN's pagination stylesheet.
	 *
	 * Ideally, this would only be performed when the "Images per page" option
	 * equals "0" at Gallery --> Gallery Settings --> NextGEN Basic Thumbnails.
	 *
	 * A "0" setting disables pagination, so we wouldn't want its stylesheet
	 * loading under this condition.
	 *
	 * Unfortunately, NextGEN doesn't seem to *ever* update its settings array
	 * for this value. Both "maxImages" and "galImages" (which we use in
	 * Legacy) permanently equal their defaults of "7" and "20" respectively.
	 *
	 * See: "nextgen-gallery/products/photocrati_nextgen/modules/
	 * nextgen_pagination/static/style.css"
	 *
	 * @wp-hook	wp_print_styles()
	 * @uses		wp_dequeue_style()
	 * @since		2.0.0
	 * @return 	void
	 */
	function remove_nextgen_pagination_css() {

		wp_dequeue_style( 'nextgen_pagination_style' );
		
	}

	/**
	 * Update our Enhanced Fancybox Lightbox's script dependencies.
	 *
	 * NextGEN 2.0 imposes a dependency of "common.js" (and its 15KB inline
	 * CDATA block) on our lightbox, even though we don't require it.
	 *
	 * In order to dequeue this, we must first remove the unnecessary
	 * dependency.
	 *
	 * We'll also take this opportunity to add jQuery as a dependency, as
	 * NextGEN 2.0.xx's "C_Lightbox_Installer" class lacks the ability to
	 * define dependencies (as well as version query args).
	 *
	 * @wp-hook	wp_footer
	 * @uses		wp_dequeue_script
	 * @since		2.0.0
	 * @return 	void
	 */
	function update_fancybox_script_dependencies() {

		global $wp_scripts;
		
		$i = 0;
		
		do {
			
			$script = $wp_scripts->query( $this->fancybox_handle . '-' . $i, 'registered' );
			
			if ( $script ) {

				if ( $this->db['fancybox'] ) {
				
					if ( $this->db['remove_common_js_and_cdata'] ) {

						unset ( $script->deps ); // Remove the "ngg_common" dependency so we can deregister it.
						
					}
					
					$script->deps[] = 'jquery'; // Insert our jQuery dependency to ensure it loads with the script.
				
				}

			}
			
			$i++;

		} while ( ! $script && $i < 100 );

	}

	/**
	 * Update Fancybox script versioning
	 * 
	 * Appends a last-modified timestamp to our call to our Enhanced Fancybox
	 * Lightbox script on the front-end.
	 *
	 * This ensures a fresh version of the script is loaded by the browser if
	 * it's been updated via our Dynamic Fancybox Settings Interface.
	 *
	 * The script remains cached in the browser until the timestamp no longer
	 * matches (which only occurs when the file is modified).
	 *
	 * We're intentionally omitting the "ver=" key, as it appears to work more
	 * consistently cross-browser.
	 *	 
	 * We're having to do this via the "script_loader_src" filter, as NextGEN
	 * 2.0.xx's "C_Lightbox_Installer" class lacks the ability to define a
	 * version.
	 *
	 * @wp-filter	script_loader_src
	 * @uses		remove_query_arg
	 * @param	string $src
	 * @since		2.0.0
	 * @return 	string $src
	 */
	function update_fancybox_script_versioning( $src ) {
	
		$file = 'fancybox/' . $this->prefix . '.jquery.fancybox-' . $this->fancybox_version . '.pack.js';

		if ( strpos( $src, $file ) ) {

			$src = remove_query_arg( 'ver', $src );
			$src = $src . '?' . filemtime( $this->plugin_dir_path . $file );
			
		}
		
		return $src;

	}

	/**
	 * Update Fancybox stylesheet versioning
	 *
	 * As NextGEN 2.0.xx's "C_Lightbox_Installer" class lacks the ability to
	 * define a version, we need to update the "ver" query-string parameter on
	 * Fancybox's stylesheet separately.
	 *
	 * We'll update it to reflect Optimizer's own version number (instead of
	 * the WordPress version as set by default).
	 *
	 * This is required for cache-busting the stylesheet after an Optimizer
	 * update.
	 *
	 * @wp-filter	style_loader_src
	 * @uses		add_query_arg
	 * @param	string $src
	 * @since		2.0.0
	 * @return 	string $src
	 */
	function update_fancybox_stylesheet_versioning( $src ) {

		if ( strpos( $src, $this->prefix . '.jquery.fancybox-' . $this->fancybox_version . '.css' ) ) {

			$src = add_query_arg( 'ver', $this->version, $src );

		}
		
		return $src;

	}

}