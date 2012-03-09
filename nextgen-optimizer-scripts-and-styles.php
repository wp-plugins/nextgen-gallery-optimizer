<?php

/**********************************************************************
* fancybox (modified) stylesheet
**********************************************************************/

function nggo_fancybox_style() {
	wp_register_style('nggo_fancybox.css', plugins_url('css/jquery.fancybox-'.NGGO_FANCYBOX_VERSION.'.css', __FILE__), false, NGGO_FANCYBOX_VERSION, 'screen');
	wp_enqueue_style('nggo_fancybox.css');
}



/**********************************************************************
* fancybox inline js
**********************************************************************/

function nggo_fancybox_inline_js() { ?>
<!-- [nextgen gallery optimizer] This post must contain an image gallery...else we wouldn't be serving its scripts and styles -->
<script type='text/javascript'>$(document).ready(function() { $('a.myfancybox').fancybox({ 'zoomSpeedIn': 500, 'zoomSpeedOut': 500, 'overlayShow':true,'overlayOpacity':0.3 }); });</script>
<?php
}



/**********************************************************************
* jquery & fancybox
* + deregister other versions when we serve them to avoid conflicts
**********************************************************************/

function nggo_fancybox_scripts() {
	wp_deregister_script('jquery');
	wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/'.NGGO_JQUERY_VERSION.'/jquery.min.js', false, NGGO_JQUERY_VERSION);
	wp_enqueue_script('jquery');
	wp_deregister_script('fancybox');
	wp_deregister_script('jquery.fancybox');
	wp_deregister_script('jquery-fancybox');
	wp_register_script('jquery.fancybox', plugins_url('fancybox/jquery.fancybox-'.NGGO_FANCYBOX_VERSION.'.pack.js', __FILE__), array('jquery'), NGGO_FANCYBOX_VERSION);
	wp_enqueue_script('jquery.fancybox');
}



/**********************************************************************
* custom style (as selected on settings page)
**********************************************************************/

function nggo_custom_style() {
	global $nextgen_optimizer_options;
	wp_register_style('custom.css', content_url($nextgen_optimizer_options['css'], dirname(__FILE__)), false, null, 'screen');
	wp_enqueue_style('custom.css');
}



/**********************************************************************
* nextgen gallery's styles (as selected on settings page)
**********************************************************************/

function nggo_nextgen_style() {
	global $nextgen_optimizer_options;
	global $nggo_css;
	wp_register_style('nextgen.css', plugins_url( 'nextgen-gallery/css/' .NGGO_NEXTGEN_CSS. '' , dirname(__FILE__)), false, null, 'screen');
	wp_enqueue_style('nextgen.css');
}