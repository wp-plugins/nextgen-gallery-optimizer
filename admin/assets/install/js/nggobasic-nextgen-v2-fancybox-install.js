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
 * Optimizer Basic's JavaScript for NextGEN's lightbox settings page.
 *
 * Requires jQuery v1.4.4+ as included in WordPress v3.1.
 *
 * Inserts a message at Gallery --> Other Options --> Lightbox Effects (when
 * Optimizer's Enhanced Fancybox Lightbox is selected), to help inform users
 * about the benefits of Optimizer's Enhanced Fancybox Lightbox, and introduce
 * them to the new Dynamic Fancybox Settings Interface available in Optimizer
 * Pro.
 *
 * This script loads on NextGEN's "Other Options" page only...
 * "http://www.yoursite.com/wp-admin/admin.php?page=ngg_other_options".
 *
 * @package		NextGEN_Gallery_Optimizer_Basic
 * @author		Mark Jeldi | Helpful Media <http://www.nextgengalleryoptimizer.com/contact/>
 * @link				http://www.nextgengalleryoptimizer.com
 * @copyright	2012 - 2014 Mark Jeldi | Helpful Media
 * @since 			2.0.0
 */
 
/**
 * Self-executing, namespaced closure pattern.
 *
 * Provides an easy way to extend our namespace, while keeping the content
 * protected from the global namespace.
 *
 * It also enables the use of public and private properties and methods,
 * protects the $ from conflicting with other JavaScript libraries, and protects
 * undefined from being redefined.
 *
 * We're prefixing a semi-colon here to ensure this script will continue to
 * function if concatenated with another file.
 */
;( function( nggobasicFancyboxInstall, $, undefined ) {

	var $thumbEffect, $boxText, enhancedFancyboxName, currentSelection,

		/**
		 * Init
		 *
		 * Cache our multi-use objects, and call all methods required to
		 * initialize our script.
		 *
		 * @param 	void
		 * @uses		_add_message_html()
		 * @uses		_animate_message()
		 * @since		2.0.0
		 * @return 	void
		 */
		_init = function() {
		
			$thumbEffect = $( '#lightbox_library' );
			enhancedFancyboxName = nggobasicNextGENOptionsPage.enhancedFancyboxName;

			_add_message_html();
			_animate_message();
			
		},

		/**
		 * Show message
		 *
		 * Inserts a message at Gallery --> Other Options --> Lightbox Effects
		 * when Optimizer's Enhanced Fancybox Lightbox is selected.
		 *
		 * This is intended to help inform users about the benefits of Optimizer's
		 * Enhanced Fancybox Lightbox, and introduce them to the new Dynamic
		 * Fancybox Settings Interface available in Optimizer Pro.
		 *
		 * @param 	void
		 * @since		2.0.0
		 * @return 	void
		 */
		_add_message_html = function() {

			var $lightboxEffectsContent = $( '#lightbox_effects_content' ),
			
			html = '' +
			
				'<tr>' +
				
				'<th></th>' +
				
				'<td style="padding-top: 0; padding-right: 0;">' +

					'<div id="nggobasic-message-box" style="color: #333;">' +

						'<div class="nggobasic-message-box-text" style="background-color: #ddd; padding: 15px;">' +
					
							"Why use Optimizer's <em>Enhanced</em> Fancybox Lightbox? " + '<a href="http://www.nextgengalleryoptimizer.com/#enhanced-fancybox-lightbox" target="_blank">Learn more...</a>' +

						'</div>' +

						'<div class="nggobasic-message-box-text" style="background-color: #222; color: #fff; margin: 10px 0 2px; padding: 15px;">' +
						
							"NEW! <em>Customize</em> Fancybox with Optimizer Pro's " + '<a style="color: #fff;" href="' + nggobasicNextGENOptionsPage.optimizerSettingsURL + '&autoload=true" target="_blank">' + "<b>Dynamic Fancybox Settings Interface</b></a>." +
									
						'</div>' +
						
					'</div>' +

				'</td>' +
				
			'</tr>';
			
			// Insert our table row.
			$thumbEffect.parent().parent().after( html );

			// Adjust the select menu's padding.
			$thumbEffect.parent().css({ 'padding-left': '0', 'padding-right': '0', 'padding-bottom': '7px' });
			
			// Remove 1px margin from select menu.
			$thumbEffect.css( 'margin-right', '0' );
			
			// Adjust the lightbox effects table to 100% width to avoid unnecessarily wrapping our text.
			$lightboxEffectsContent.find( 'table' ).css( 'width', '100%' );
			
			// Give the lightbox select menu's title td a minimum width to prevent the text running onto many lines (which causes a big gap below the select menu).
			$lightboxEffectsContent.find( '.column1' ).css( 'min-width', '120px' );
			
			// Reduce right padding for more uniform spacing.
			$lightboxEffectsContent.css( 'padding-right', '8px' );

			// Cache our message object ahead of further use.
			$boxText = $( '.nggobasic-message-box-text' );
			
			// Get our current lightbox selection.
			currentSelection = $thumbEffect.find( ':selected' ).attr( 'data-library-name' );

			// Hide our message on initial load if another lightbox is saved.
			if ( enhancedFancyboxName !== currentSelection ) { $boxText.css({ 'opacity': '0', 'display': 'none' }); }

		},

		/**
		 * Animate message
		 *
		 * Controls all animation of our message at Gallery --> Other Options
		 * --> Lightbox Effects.
		 *
		 * @param 	void
		 * @since		2.0.0
		 * @return 	void
		 */
		_animate_message = function() {
		
			// Avoid animation collisions.
			var animating = '';
			var animationQueue = '';

			$thumbEffect.change( function() {
				
				// Our queue is reset to true upon every change to the lightbox select menu.
				// This way, we know to run again once the current animation has completed.
				animationQueue = true;
				animate();
			
				/**
				 * Animate
				 *
				 * Animate the display of our learn more/DFSI message depending
				 * on whether Optimizer's Enhanced Fancybox Lightbox is
				 * selected.
				 *
				 * Scroll-down and fade-in if it is, fade-out and scroll-up if
				 * it's not.
				 *
				 * @param 	void
				 * @since		2.0.0
				 * @return 	null|void
				 */
				function animate() {
				
					currentSelection = $thumbEffect.find( ':selected' ).attr( 'data-library-name' );

					if ( ! animating ) { // Avoid collisions.
					
						// Return when animation isn't required to end our loop.
						if ( enhancedFancyboxName === currentSelection && $boxText.css( 'opacity' ) > 0 || enhancedFancyboxName !== currentSelection && $boxText.css( 'opacity' ) < 1 ) {

							return;
							
						}
					
						animating = true;
						animationQueue = false;
					
						if ( enhancedFancyboxName === currentSelection ) {
						
							$boxText.slideDown( 600, function() {

								$boxText.fadeTo( 600, 1, function() {
								
									animating = false;
									loop_animation();
								
								});

							});
					
						} else if ( $boxText.css( 'opacity' ) === '1' ) {

							$boxText.fadeTo( 600, 0.00, function() {

								$boxText.slideUp( 600, function() {
								
									animating = false;
									loop_animation();
								
								});
								
							});
						
						}
						
					}
					
				}
				
				/**
				 * Loop animation
				 *
				 * If another selection was made during our message animation,
				 * "animationQueue" will be true at this point.
				 *
				 * If so, we'll call our animation method again to
				 * appropriately show/hide Optimizer's message.
				 *
				 * @param 	void
				 * @since		2.0.0
				 * @return 	void
				 */
				function loop_animation() {
				
					if ( true === animationQueue ) {
				
						animate();
					
					}
				
				}
			
			});
			
		};

	$( document ).ready( function() {
	
		_init();

	});

}( window.nggobasicFancyboxInstall = window.nggobasicFancyboxInstall || {}, jQuery ) );

/**
 * jQuery noConflict
 *
 * Ensure we're running in noConflict mode for compatibility with other
 * JavaScript libraries.
 *
 * Required when using Google-hosted jQuery, which does not include this (the
 * version built-into WordPress calls it right at the end of the library).
 *
 * This will be unnecessary in most cases, as this script is called inside the
 * admin, but best to be safe.
 *
 * @since	2.0.0
 */
jQuery.noConflict();