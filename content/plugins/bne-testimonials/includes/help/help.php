<?php
/*
 *	Help Admin Page
 *
 * 	@author		Kerry Kline
 * 	@copyright	Copyright (c) 2017, Kerry Kline
 * 	@link		http://www.bnecreative.com
 *	@package	BNE Testimonials
 *
*/

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



/*
 *	Register admin page and location
 *
 *	@since v1.0
 *
*/
function bne_testimonial_help_menu_link() {
    add_submenu_page(
    	'edit.php?post_type=bne_testimonials',				// Post Type
    	__( 'BNE Testimonials', 'bne-testimonials' ),		// Page Title
    	__( 'Help', 'bne-testimonials' ),					// Menu Title
    	'edit_posts',										// User Role
    	'bne-testimonial-help',								// Page slug
    	'bne_testimonial_admin_help_page'					// Function call
    );
}
add_action( 'admin_menu' , 'bne_testimonial_help_menu_link');



/*
 *	Output the Admin Page
 *
 *	@since 		v1.0
 *	@updated 	v2.0
 *
*/
function bne_testimonial_admin_help_page() {

	// Load BNE Admin CSS
	wp_enqueue_style( 'bne-admin-styles', BNE_TESTIMONIALS_URI . '/assets/css/bne-admin.css' );

	?>
	
	<div id="bne-admin-wrapper" class="wrap" >
		<div class="bne-inner">

			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$('a.scroll').on('click', function() {
						$('html, body').animate({
							scrollTop: $(this.hash).offset().top - 50
						}, 1000);
						return false;
					});

					// Tab Nav
					$('.nav-tab-wrapper a').click(function(event){
						event.preventDefault();
						
						// Limit effect to the container element.
						var context = $(this).closest('.nav-tab-wrapper').parent();
						$('a.nav-tab', context).removeClass('nav-tab-active');
						$(this).closest('a').addClass('nav-tab-active');
						$('.tab-content', context).hide();
						$( $(this).attr('href'), context ).show();
					});
				
					// Make setting wp-tab-active optional.
					$('.nav-tab-wrapper').each(function(){
						if ( $('.nav-tab-active', this).length )
							$('.nav-tab-active', this).click();
						else
							$('a', this).first().click();
					});


				});  //End
			</script>
			<style type="text/css">
				.label.new {
					background: #0099ff;
					color: white;
					font-weight: bold;
					padding: 4px 7px;
					line-height: 1;
					border-radius: 5px;
					font-size: 11px;
					margin-right: 5px;
				}
				.bne-upsell * {
					margin: 0;
					padding: 0;
					position: relative;
					display: block;
				}
				.bne-upsell {
					margin-bottom: 20px;
					padding: 4px;
					background: white;
					border: 1px solid #ddd;
					border-radius: 3px;
					box-shadow: 0px 0px 3px #ccc;
				}
				.bne-upsell .upsell-footer {
					background: #000;
					margin: 0;
					line-height: 1;
					position: relative;
					color: white;
					padding: 10px;
					text-align: center;
					transition: all .3s ease;			
				}
				
				.bne-upsell:hover .upsell-footer {
					background: #0099ff;
				}
				
				.bne-upsell .upsell-link {
					text-decoration: none;
					color: white;
				}
			</style>

			<h1><?php echo __('BNE Testimonials Documentation', 'bne-testimonials' ); ?></h1>
			<div class="clear"></div>

			<div class="canvas">
				<div class="row">
					<div class="span-two-thirds">
						<?php
							$tabs = apply_filters( 'bne_testimonials_help_addon', array(
								array(
									'title'		=>	'Display Shortcode',
									'content'	=>	'',
									'include'	=>	BNE_TESTIMONIALS_DIR . '/includes/help/help-2x.php'
								),
								array(
									'title'		=>	'<span class="new label">Pro Only</span>Submit Form',
									'content'	=>	'',
									'include'	=>	BNE_TESTIMONIALS_DIR . '/includes/help/help-form.php'
								),
								array(
									'title'		=>	'<span class="new label">Pro Only</span>Badges',
									'content'	=>	'',
									'include'	=>	BNE_TESTIMONIALS_DIR . '/includes/help/help-badges.php'
								),
								array(
									'title'		=>	'<span class="new label">Pro Only</span>API',
									'content'	=>	'',
									'include'	=>	BNE_TESTIMONIALS_DIR . '/includes/help/help-api.php'
								),
							) );
						?>

						<!-- Tab Navigation -->
						<h2 class="bne-admin-tabs nav-tab-wrapper" style="margin-top:0;">
							<?php foreach( $tabs as $tab ) {
								echo '<a class="nav-tab" href="#'.sanitize_title( $tab['title'] ).'">'.$tab['title'].'</a>';
							} ?>
						</h2>
						
						<!-- Tab content -->
						<?php foreach( $tabs as $tab ) {
							echo '<div class="tab-content" id="'.sanitize_title( $tab['title'] ).'">';
								if( file_exists( $tab['include'] ) ) {
									include( $tab['include'] );
								} else {
									echo '<div style="margin-top: 15px;">'.$tab['content'].'</div>';
								}
							echo '</div>';
						} ?>
					</div><!-- .span-two-third (end) -->

					<div class="span-one-third">
						<?php include( BNE_TESTIMONIALS_DIR . '/includes/help/help-sidebar.php' ); ?>
					</div><!-- .span-one-third (end) -->
				
				</div><!-- .row (end) -->

			</div><!-- .canvas (end) -->
		</div><!-- .bne-inner (end) -->
	</div><!-- .bne-admin-wrapper.wrap (end) -->

	<?php
} // END Admin Help Page