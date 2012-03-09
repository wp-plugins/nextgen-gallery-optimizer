<?php

/**********************************************************************
* remove nextgen gallery scripts [works on nextgen 1.6.2 and above]
**********************************************************************/

function remove_nextgen_js() {
	if (!is_admin()) {
			define('NGG_SKIP_LOAD_SCRIPTS', true);
	}
}
add_action('init', 'remove_nextgen_js');



/**********************************************************************
* remove nextgen gallery styles
**********************************************************************/

function remove_nextgen_css() {
	wp_deregister_style('NextGEN');
}
add_action('wp_print_styles', 'remove_nextgen_css', 100);



/**********************************************************************
* check if post contains [nggallery id=x] shortcode
**********************************************************************/

function nggo_check_nggallery_shortcode( $shortcode = nggallery ) {
global $nextgen_optimizer_options;
	
	if (!is_admin()) {
    $post = get_post( get_the_ID() );

		// check post content for [nggallery id=x] shortcode 
		if ( stripos( $post->post_content, '[' . $shortcode ) !== FALSE ) {
 
			if(isset($nextgen_optimizer_options['fancybox'])) {
				if($nextgen_optimizer_options['fancybox'] == true) {
					
					// see scripts-and-styles.php for functions
					add_action('wp_enqueue_scripts', 'nggo_fancybox_scripts', 999);
					add_action('wp_print_styles', 'nggo_fancybox_style', 999);
					add_action('wp_head','nggo_fancybox_inline_js', 999);
				}
			}

			if($nextgen_optimizer_options['css'] != "") {
				
				add_action('wp_print_styles', 'nggo_custom_style', 999); // see scripts-and-styles.php for function 
	
			} else {

				$nggo_theme = $nextgen_optimizer_options['theme'];

				if($nggo_theme == "") { }
				if($nggo_theme == "Black Minimalism Theme") { define( 'NGGO_NEXTGEN_CSS', 'Black_Minimalism.css' ); }
				if($nggo_theme == "Default Styles") { define( 'NGGO_NEXTGEN_CSS', 'nggallery.css' ); }
				if($nggo_theme == "Dkret3 Theme") { define( 'NGGO_NEXTGEN_CSS', 'ngg_dkret3.css' ); }
				if($nggo_theme == "Hovereffect Styles") { define( 'NGGO_NEXTGEN_CSS', 'hovereffect.css' ); }
				if($nggo_theme == "K2 Theme") { define( 'NGGO_NEXTGEN_CSS', 'ngg_k2.css' ); }
				if($nggo_theme == "Shadow Effect") { define( 'NGGO_NEXTGEN_CSS', 'ngg_shadow.css' ); }
				if($nggo_theme == "Shadow Effect with Description Text") { define( 'NGGO_NEXTGEN_CSS', 'ngg_shadow2.css' ); }

				if ($nggo_theme != "") {
					 
					add_action('wp_print_styles', 'nggo_nextgen_style', 999); // see scripts-and-styles.php for function
				
				}

			} // close if/else statement
		} // close regex
	} // close if not admin
} // close check_nextgen_shortcode function

add_action('get_header','nggo_check_nggallery_shortcode');