<?php

/* remove nextgen gallery scripts [works on nextgen 1.6.2 and above] */
function remove_nextgen_js() { if ( !is_admin() ) { define('NGG_SKIP_LOAD_SCRIPTS', true); } }
add_action('init', 'remove_nextgen_js');

/* remove nextgen gallery styles */
function remove_nextgen_css() { wp_deregister_style('NextGEN'); }
add_action('wp_print_styles', 'remove_nextgen_css', 100);

/* remove nextgen version comment from header [works on nextgen 1.9.0 and above] */
remove_action('wp_head', array('nggGallery', 'nextgen_version') );


/* check if post contains shortcode for nextgen gallery */
function check_nextgen_shortcode( $shortcode = nggallery ) {

global $nextgen_optimizer_options;

if ( is_single() ) {
    	
$post = get_post( get_the_ID() );

// check post content for [nggallery id=x] shortcode 
if ( stripos( $post->post_content, '[' . $shortcode ) !== FALSE ) {
 


if(isset($nextgen_optimizer_options['fancybox'])) {
	if($nextgen_optimizer_options['fancybox'] == true) {

echo '
<!-- [start nextgen gallery optimizer] This post must contain an image gallery...else we wouldn\'t be serving its scripts and styles! -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="' . plugins_url( 'fancybox/jquery.fancybox-1.3.4.pack.js' , __FILE__) . '"></script>
<link rel="stylesheet" href="' . plugins_url( 'fancybox/jquery.fancybox-1.3.4.css' , __FILE__) . '" type="text/css" media="screen" />';
echo "\n"; ?>
<script type='text/javascript'>$(document).ready(function() { $("a.myfancybox").fancybox({ 'zoomSpeedIn': 500, 'zoomSpeedOut': 500, 'overlayShow':true,'overlayOpacity':0.3 }); });</script>
<?php
		}
	}


$nggo_comment = "\n";
$nggo_comment .= '<!-- [start nextgen gallery optimizer] This post must contain an image gallery...else we wouldn\'t be serving its stylesheet! -->';
$nggo_comment .= "\n";



if($nextgen_optimizer_options['css'] != "") {
	
	if(!isset($nextgen_optimizer_options['fancybox'])) {
	echo $nggo_comment;
	}
	
echo '<link rel="stylesheet" href="' . $nextgen_optimizer_options['css'] . '" type="text/css" media="screen" />';
echo "\n\n";

} else {

		$nggo_theme = $nextgen_optimizer_options['theme'];

		if($nggo_theme == "") { }
		if($nggo_theme == "Black Minimalism Theme") { $nggo_css = "Black_Minimalism.css"; }
		if($nggo_theme == "Default Styles") { $nggo_css = "nggallery.css"; }
		if($nggo_theme == "Dkret3 Theme") { $nggo_css = "ngg_dkret3.css"; }
		if($nggo_theme == "Hovereffect Styles") { $nggo_css = "hovereffect.css"; }
		if($nggo_theme == "K2 Theme") { $nggo_css = "ngg_k2.css"; }
		if($nggo_theme == "Shadow Effect") { $nggo_css = "ngg_shadow.css"; }
		if($nggo_theme == "Shadow Effect with Description Text") { $nggo_css = "ngg_shadow2.css"; }

		if ($nggo_theme != "") {

			if(!isset($nextgen_optimizer_options['fancybox'])) {
			echo $nggo_comment;
			}



		echo '<link rel="stylesheet" href="' .plugins_url( 'nextgen-gallery/css/' . $nggo_css . '' , dirname(__FILE__) ). '" type="text/css" media="screen" /> ';
		echo "\n\n";
		} else {
		echo "\n";
		}

} // close if/else statement
} // close regex
} // close if is_single
} // close check_nextgen_shortcode function

add_action('wp_head','check_nextgen_shortcode');