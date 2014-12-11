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
 * Dynamic Fancybox Settings Interface Demo HTML Template
 *
 * Represents the view for our dynamic Fancybox settings page, including the
 * HTML markup and options form that makes up the core of the user interface.
 *
 * @package		NextGEN_Gallery_Optimizer_Basic
 * @author		Mark Jeldi | Helpful Media <http://www.nextgengalleryoptimizer.com/contact/>
 * @link				http://www.nextgengalleryoptimizer.com
 * @copyright	2012 - 2014 Mark Jeldi | Helpful Media
 */
?>

<!-- Interface wrapper -->
<div id="nggobasic-dfsi-wrap">

	<!-- Interface post-footer padding -->
	<div id="nggobasic-dfsi-wrap-inner">

		<!-- Content container -->
		<div id="nggobasic-dfsi-box">

			<!-- Darken content background opacity -->
			<div id="nggobasic-dfsi-box-inner">

				<div id="nggobasic-dfsi-logo">
					<a id="nggobasic-dfsi-logo-inner" href="http://www.nextgengalleryoptimizer.com" target="_blank"><img src="<?php echo $this->plugin_dir_url; ?>admin/assets/images/nextgen-gallery-optimizer.png" title="NextGEN Gallery Optimizer" alt="NextGEN Gallery Optimizer" /></a>
				</div>				
				
				<div id="nggobasic-dfsi-title">
					Dynamic Fancybox Settings Interface
				</div>

				<div id="nggobasic-dfsi-upgrade-text">
					This is a preview of the NEW Dynamic Fancybox Settings Interface in Optimizer Pro. To activate these settings on your site, please upgrade to...<br />
					<a href="http://www.nextgengalleryoptimizer.com/" target="_blank">NextGEN Gallery Optimizer Pro</a>.
				</div>

				<div id="nggobasic-dfsi-download-box">
					<div id="nggobasic-dfsi-download-inner">
						<a id="nggobasic-dfsi-download-button" href="http://www.nextgengalleryoptimizer.com/purchase/" target="_blank">Get Optimizer Pro</a>
					</div>
				</div>

				<!-- Fancybox settings form -->
				<form method="post" action="options.php" id="nggobasic-dfsi-form">
					
					<?php settings_fields( $this->db_name . '_group' ); ?>
			
					<div id="nggobasic-dfsi-responsive-grid">

						<div class="nggobasic-dfsi-option-box">

							<div class="nggobasic-dfsi-option-title">
								Title position
							</div>

							<div class="nggobasic-dfsi-option-bg">							
								<div id="nggobasic-dfsi-help-title-position" class="nggobasic-dfsi-help-link">?</div>
								<span class="nggobasic-dfsi-option-vertical-align"></span>
									<?php $titles = array( 'None', 'Float', 'Over', 'Inside', 'Outside' ); ?>
									<select class="nggobasic-dfsi-input" name="<?php echo $this->db_name ?>[fancybox_title_position]" id="<?php echo $this->db_name ?>[fancybox_title_position]">
										<?php foreach($titles as $title) { ?>
											<?php if( 'Float' == $title ) { $selected = ' selected="selected"'; } else { $selected = ''; } ?>
											<option value="<?php echo $title; ?>"<?php echo $selected; ?>><?php echo $title; ?></option>
										<?php } ?>
									</select>
								<span class="nggobasic-dfsi-option-vertical-align"></span>
							</div>

						</div>
						
						<div class="nggobasic-dfsi-option-box nggobasic-dfsi-option-middle">

							<div class="nggobasic-dfsi-option-title">
								Overlay color
							</div>

							<div class="nggobasic-dfsi-option-bg">
								<div id="nggobasic-dfsi-help-overlay-color" class="nggobasic-dfsi-help-link">?</div>
								<span class="nggobasic-dfsi-option-vertical-align"></span>
								<span class="nggobasic-dfsi-input" id="nggobasic-dfsi-overlay-color">
									<input class="nggobasic-dfsi-input" type="text" name="<?php echo $this->db_name ?>[fancybox_overlay_color]" id="<?php echo $this->db_name ?>[fancybox_overlay_color]" value="#666" />
									<span class="nggobasic-dfsi-input" id="nggobasic-dfsi-color-picker-link">Pick</span>
									<span class="clear"></span>
								</span>
								<span class="nggobasic-dfsi-option-vertical-align"></span>
							</div>

						</div>

						<div class="nggobasic-dfsi-option-box">

							<div class="nggobasic-dfsi-option-title">
								Overlay opacity
							</div>

							<div class="nggobasic-dfsi-option-bg">
								<div id="nggobasic-dfsi-help-overlay-opacity" class="nggobasic-dfsi-help-link">?</div>
								<span class="nggobasic-dfsi-option-vertical-align"></span>
									<?php $stops = array( '0', '0.1', '0.2', '0.3', '0.4', '0.5', '0.6', '0.7', '0.8', '0.9', '1' ); ?>
									<select class="nggobasic-dfsi-input" name="<?php echo $this->db_name ?>[fancybox_overlay_opacity]" id="<?php echo $this->db_name ?>[fancybox_overlay_opacity]">
										<?php foreach($stops as $stop) { ?>
											<?php if ( '0.3' == $stop ) { $selected = ' selected="selected"'; } else { $selected = ''; } ?>
											<option value="<?php echo $stop; ?>"<?php echo $selected; ?>><?php echo $stop; ?></option>
										<?php } ?>
									</select>
								<span class="nggobasic-dfsi-option-vertical-align"></span>
							</div>

						</div>
						
						<div class="nggobasic-dfsi-option-box">

							<div class="nggobasic-dfsi-option-title">
								Responsive resize
							</div>
							
							<div class="nggobasic-dfsi-option-bg">
								<div id="nggobasic-dfsi-help-responsive-resize" class="nggobasic-dfsi-help-link">?</div>
								<span class="nggobasic-dfsi-option-vertical-align"></span>
								<input id="<?php echo $this->db_name ?>[fancybox_responsive_resize]" name="<?php echo $this->db_name ?>[fancybox_responsive_resize]" type="checkbox" value="1" />
								<span class="nggobasic-dfsi-option-vertical-align"></span>
							</div>

						</div>
						
						<div class="nggobasic-dfsi-option-box nggobasic-dfsi-option-middle">

							<div class="nggobasic-dfsi-option-title">
								Image counter
							</div>
							
							<div class="nggobasic-dfsi-option-bg">
								<div id="nggobasic-dfsi-help-image-counter" class="nggobasic-dfsi-help-link">?</div>
								<span class="nggobasic-dfsi-option-vertical-align"></span>
								<input id="<?php echo $this->db_name ?>[fancybox_image_counter]" name="<?php echo $this->db_name ?>[fancybox_image_counter]" type="checkbox" value="1" />
								<span class="nggobasic-dfsi-option-vertical-align"></span>
							</div>

						</div>

						<div class="nggobasic-dfsi-option-box">

							<div class="nggobasic-dfsi-option-title">
								Title from Alt
							</div>

							<div class="nggobasic-dfsi-option-bg">
								<div id="nggobasic-dfsi-help-title-from-alt" class="nggobasic-dfsi-help-link">?</div>
								<span class="nggobasic-dfsi-option-vertical-align"></span>
								<input id="<?php echo $this->db_name ?>[fancybox_title_from_alt]" name="<?php echo $this->db_name ?>[fancybox_title_from_alt]" type="checkbox" value="1" />
								<span class="nggobasic-dfsi-option-vertical-align"></span>
							</div>

						</div>
						
						<div class="clear"></div>
					
					</div><!-- End #nggobasic-dfsi-responsive-grid-->

					<div id="nggobasic-dfsi-footer-buttons">
						<input type="submit" disabled class="button-primary nggobasic-dfsi-input" id="nggobasic-dfsi-save-button" value="<?php _e( 'Save', 'nggobasic_domain' ); ?>" title="Save is disabled for this demo." />
						<input type="button" class="button-primary nggobasic-dfsi-input" id="nggobasic-dfsi-reset-button" value="<?php _e( 'Reset', 'nggobasic_domain' ); ?>" />
					</div>

				</form>
			
			</div><!-- Close #nggobasic-dfsi-box-inner -->

		</div><!-- Close #nggobasic-dfsi-box -->
		
		<div id="nggobasic-dfsi-mobile-spacer">&nbsp;</div>

	</div><!-- Close #nggobasic-dfsi-wrap-inner -->

</div><!-- Close #nggobasic-dfsi-wrap -->

<!-- Append our background image. -->
<img id="nggobasic-dfsi-bg" alt="" src="<?php echo $this->plugin_dir_url; ?>admin/assets/images/brooklyn-bridge.jpg" />

<!-- Append our color picker overlay. -->
<div id="nggobasic-dfsi-mini-modal-overlay"></div>

<!-- Append our mini modal for our color picker and help screens -->
<div id="nggobasic-dfsi-mini-modal-box">
	<div id="nggobasic-dfsi-mini-modal-inner">
		<div id="nggobasic-dfsi-mini-modal-wrap">
			<a id="nggobasic-dfsi-mini-modal-close"></a>
			<div id="nggobasic-dfsi-color-picker"></div>
			<div id="nggobasic-dfsi-help"><div id="nggobasic-dfsi-help-text"></div></div>
		</div>
	</div>
</div>