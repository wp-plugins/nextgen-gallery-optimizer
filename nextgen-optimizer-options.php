<?php

function nextgen_optimizer_options_page() {

global $nextgen_optimizer_options;
ob_start();

?>
	
<div class="wrap">
<h2>NextGEN Gallery Optimizer</h2>


	<div class="nggo_box">	
		<form method="post" action="options.php">
		<?php settings_fields('nextgen_optimizer_settings_group'); ?>
			
		<div class="nggo_inner">
		<h2><?php _e('Step 1:', 'nextgen_optimizer_domain'); ?></h2>
			
			<div class="nggo_select_style">
				<b>Select your NextGEN stylesheet:</b>
				<p>
					<?php $styles = array('','Black Minimalism Theme', 'Default Styles', 'Dkret3 Theme', 'Hovereffect Styles', 'K2 Theme', 'Shadow Effect', 'Shadow Effect with Description Text'); ?>
					<select name="nextgen_optimizer_settings[theme]" id="nextgen_optimizer_settings[theme]">
						<?php foreach($styles as $style) { ?>
							<?php if($nextgen_optimizer_options['theme'] == $style) { $selected = 'selected="selected"'; } else { $selected = ''; } ?>
							<option value="<?php echo $style; ?>" <?php echo $selected; ?>><?php echo $style; ?></option>
						<?php } ?>
					</select>
				</p>
			</div>
			
			<div class="nggo_custom_style">
				<b>Or enter the path to a custom file:</b>
				<p><?php echo content_url() ?>/ <input id="nextgen_optimizer_settings[css]" name="nextgen_optimizer_settings[css]" type="text" size="35" value="<?php echo $nextgen_optimizer_options['css']; ?>"/></p>
			</div>
			
		</div>
			
	<div class="clear"></div>
			
		<div class="nggo_inner">
			<h2><?php _e('Step 2:', 'nggo_domain'); ?></h2>
			<input id="nextgen_optimizer_settings[fancybox]" name="nextgen_optimizer_settings[fancybox]" type="checkbox" value="1" <?php checked(1, $nextgen_optimizer_options['fancybox']); ?> />
			&nbsp;&nbsp;<b>Use <a href="http://fancybox.net" target="_blank">Fancybox</a> lightbox effect?</b>
			<br>To complete the installation, go to <b><a href="<?php echo admin_url( 'admin.php?page=nggallery-options#effects' , __FILE__); ?>" target="_blank">Gallery --> Options --> Effects</a></b>, 
			select <b>Custom</b> and enter: <b>class="myfancybox" rel="%GALLERY_NAME%"</b>
		</div>
				

		<h2><?php _e('Step 3:', 'nextgen_optimizer_domain'); ?></h2>
		<input type="submit" class="button-primary" value="<?php _e('Save Options', 'nextgen_optimizer_domain'); ?>" />&nbsp;&nbsp;<b>Save your changes and enjoy!</b>&nbsp;
		Your gallery scripts and styles will now only load on posts with the [nggallery id=x] shortcode.

</div><!-- end .nggo_box -->		


	<div class="nggo_box">
		<h2><?php _e('Tips:', 'nggo_domain'); ?></h2>
		1. If Fancybox isn't working as it should, try deactivating other Fancybox/lightbox plugins which may be causing a conflict, 
		and try removing any duplicate Fancybox scripts hard-coded into your theme.<br /><br />
		
		2. Lightbox scripts such as Fancybox aren't generally compatible with minification/caching/combining plugins. 
		If you're using a plugin such as WP-Minify, be sure to list the already minified <b><?php echo plugins_url( 'fancybox/jquery.fancybox-'.NGGO_FANCYBOX_VERSION.'.pack.js' , __FILE__); ?></b>
		in its file exclusion options and clear the cache.
	</div>
		
</form>

		
	<div class="nggo_box">
		<div class="nggo_inner">
			<h2>Donate!</h2>
			If you would like to support further development of this plugin, or the creation of other optimization plugins...please consider a <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YGS3ANA29BJ2W">donation</a>!<br />
			It would be greatly appreciated...as would a <a href="http://wordpress.org/extend/plugins/nextgen-gallery-optimizer">good rating</a> on WordPress.org.
		</div>
		<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YGS3ANA29BJ2W">
		<?php echo '<img src="' . plugins_url( 'images/donate-button.gif' , __FILE__) . '" width="92" height="26"> '; ?></a>
	</div>


	<div class="nggo_box">
		<div class="nggo_inner">
			<h2>Hire me!</h2>
			Need to optimize your site further?<br />
			<a href="http://www.peopleperhour.com/freelancers/mark_j/wordpress_customisation_and_optimisation/143719">Hire me</a> and consider it done!
		</div>
		<a href="http://www.peopleperhour.com/freelancers/mark_j/wordpress_customisation_and_optimisation/143719">
		<?php echo '<img src="' . plugins_url( 'images/hire-button.gif' , __FILE__) . '" width="92" height="26"> '; ?></a>
	</div>


	<div class="nggo_box">
		<h2>Support:</h2>
		Any questions or suggestions?<br />
		Please leave a message at the <a href="http://wordpress.org/tags/nextgen-gallery-optimizer?forum_id=10">Support Forum</a>.
	</div>
		
</div><!-- end wrap -->



<?php
	echo ob_get_clean();
}