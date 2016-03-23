<?php
/*
This file handles the admin area and functions.	You can use this file to make changes to the
dashboard. Updates to this page are coming soon. It's turned off by default, but you can call it
via the functions file.
*/

/************* DASHBOARD WIDGETS *****************/

// disable default dashboard widgets
function disable_default_dashboard_widgets() {
	// remove_meta_box('dashboard_right_now', 'dashboard', 'core');    // Right Now Widget
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  // Incoming Links Widget
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');         // Plugins Widget

	// remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  // Quick Press Widget
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');   // Recent Drafts Widget
	remove_meta_box('dashboard_primary', 'dashboard', 'core');         //
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');       //

	// removing plugin dashboard boxes
	//remove_meta_box('yoast_db_widget', 'dashboard', 'normal');         // Yoast's SEO Plugin Widget

}


/************* CUSTOM LOGIN PAGE *****************/

// calling your own login css so you can style it
function lad_login_css() { ?>
    <link rel="stylesheet" id="custom_wp_admin_css"  href="<?php echo get_stylesheet_directory_uri() . '/library/css/login.css'; ?>" type="text/css" media="all" />
<?php }

// changing the logo link from wordpress.org to your site
function lad_login_url() { return get_bloginfo('url'); }

// changing the alt text on the logo to show your site name
function lad_login_title() { return get_option('blogname'); }

// calling it only on the login page
add_action( 'login_enqueue_scripts', 'lad_login_css' );
add_filter('login_headerurl', 'lad_login_url');
add_filter('login_headertitle', 'lad_login_title');


/*
Now let's talk about adding your own custom Dashboard widget. Sometimes you want to show clients feeds relative to their site's content. For example, the NBA.com feed for a sports site. Here is an example Dashboard Widget that displays recent entries from an RSS Feed.

For more information on creating Dashboard Widgets, view:
http://digwp.com/2010/10/customize-wordpress-dashboard/
*/

// RSS Dashboard Widget
function lad_rss_dashboard_widget() {
	if(function_exists('fetch_feed')) {
		include_once(ABSPATH . WPINC . '/feed.php');               // include the required file
		$feed = fetch_feed('http://themble.com/feed/rss/');        // specify the source feed
		$limit = $feed->get_item_quantity(7);                      // specify number of items
		$items = $feed->get_items(0, $limit);                      // create an array of items
	}
	if ($limit == 0) echo '<div>The RSS Feed is either empty or unavailable.</div>';   // fallback message
	else foreach ($items as $item) : ?>

	<h4 style="margin-bottom: 0;">
		<a href="<?php echo $item->get_permalink(); ?>" title="<?php echo $item->get_date('j F Y @ g:i a'); ?>" target="_blank">
			<?php echo $item->get_title(); ?>
		</a>
	</h4>
	<p style="margin-top: 0.5em;">
		<?php echo substr($item->get_description(), 0, 200); ?>
	</p>
	<?php endforeach;
}

// calling all custom dashboard widgets
function lad_custom_dashboard_widgets() {
	wp_add_dashboard_widget('lad_rss_dashboard_widget', 'Recently on Themble (Customize on admin.php)', 'lad_rss_dashboard_widget');
	/*
	Be sure to drop any other created Dashboard Widgets
	in this function and they will all load.
	*/
}

// removing the dashboard widgets
add_action('admin_menu', 'disable_default_dashboard_widgets');
// adding any custom widgets
add_action('wp_dashboard_setup', 'lad_custom_dashboard_widgets');
