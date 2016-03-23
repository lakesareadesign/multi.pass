<?php
/**
 * Kickstart Pro
 *
 * @author  Lean Themes
 * @license GPL-2.0+
 * @link    http://demo.leanthemes.co/kickstart/
 */

add_action( 'wp_head', 'kickstart_customizer_css');
/**
 * Writes the anchor color style out to the `head` element of the document
 * by reading the value from the theme mod value in the options table.
 *
 */
function kickstart_customizer_css() {
	if ( get_theme_mod( 'kickstart_primary_color' ) != '' ) { ?>
		 <style type="text/css">
			a.more-link,
			button,
			input[type="button"],
			input[type="reset"],
			input[type="submit"],
			.archive .archive-before-content,
			.before-footer,
			.blog-top,
			.button,
			.enews-widget input[type="submit"],
			.entry-content a.more-link,
			.entry-content .button,
			.featured-link,
			.home-top .widget .featured-link,
			.home-top-callout,
			.format-quote .entry-content,
			.genesis-nav-menu .menu-item,
			.genesis-nav-menu .sub-menu a:hover,
			.genesis-nav-menu .sub-menu .current-menu-item > a:hover,
			.home-row1,
			.home-row4,
			.home-row6,
			.page-contact .site-container,
			.pricing-column .button,
			.pricing-column.featured,
			.site-title,
			div.slide-excerpt-border .featured-link,
			.widget_tag_cloud a,
			.widget_wp_sidebarlogin .widget-wrap {
				background-color: <?php echo get_theme_mod( 'kickstart_primary_color' ); ?>;
			}

			tbody {
				border-bottom-color: <?php echo get_theme_mod( 'kickstart_primary_color' ); ?>;
			}

			body,
			tbody tr:first-of-type td,
			td {
				border-top-color: <?php echo get_theme_mod( 'kickstart_primary_color' ); ?>;
			}

			.archive-pagination a,
			.archive-title,
			.entry-content a,
			.entry-content .button:hover,
			.entry-pagination a,
			.entry-title,
			.entry-title a,
			.kickstart-contact-box .address:before,
			.kickstart-contact-box .email:before,
			.kickstart-contact-box .phone:before,
			.home-row3-left a,
			.home-row3-left .widget-title,
			.home-row4 .post .more-link,
			.home-row5 .widget-title,
			.home-top-news .entry-content a:after,
			.home-top-news .widget-title,
			.latest-tweets .tweet-details a span,
			.pricing-column h4,
			.pricing-column.featured .button,
			.pricing-column.featured:after,
			.sidebar .latest-tweets .tweet-text a:hover,
			.sidebar .widget_categories ul li:before,
			.sidebar .widget-title a,
			.widget-title {
				color: <?php echo get_theme_mod( 'kickstart_primary_color' ); ?>;
			}

			@media only screen and (max-width: 768px) {
				.site-header {
					background-color: <?php echo get_theme_mod( 'kickstart_primary_color' ); ?>;
				}
			}
		 </style>
	<?php }
}
