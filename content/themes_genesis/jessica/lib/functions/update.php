<?php
/**
 * Provides a notification everytime the theme is updated
 *
 */

function update_notifier_menu() {

	$ignore = genesis_get_option( 'wsm_ignore_updates', 'jessica-settings' );
	if ( 1 == $ignore )
			return;
	$update_check_int = 24; // Time in hours to check file for new version
	$update_check_int_seconds = $update_check_int * 3600;
	$xml = get_latest_theme_version( $update_check_int_seconds );
	$theme_data = wp_get_theme();

	if( isset( $xml->latest ) && version_compare( $theme_data->get( 'Version' ), $xml->latest ) == -1 ) {
		add_dashboard_page( $theme_data->get( 'Name' ) . 'Theme Updates', $theme_data->get( 'Name' ) . ' <span class="update-plugins count-1"><span class="update-count">Update</span></span>', 'administrator', strtolower( trim( preg_replace( '/[^A-Za-z0-9-]+/', '-', $theme_data->get( 'Name' ) ) ) ) . '-updates', 'update_notifier' );
	}else if($xml->latest === -2){
		add_dashboard_page($theme_data['Name'] . 'Theme Error', 'Theme Error', 'read', strtolower( trim( preg_replace( '/[^A-Za-z0-9-]+/', '-', $theme_data['Name'] ) ) ) . '-error', 'error_xml_notfound');
	}
}

add_action('admin_menu', 'update_notifier_menu');

// show message when xml not found;
function error_xml_notfound(){
	$theme_data = wp_get_theme(); // Get theme data from style.css (current version is what we want) ?>

	<style>
		.update-nag {display: none;}
		#instructions {max-width: 800px;}
		h3.title {margin: 30px 0 0 0; padding: 30px 0 0 0; border-top: 1px solid #ddd;}
		ul {line-height:1;list-style: disc inside;}
		p span {font-weight:bold;padding-left:20px;}
	</style>

	<div class="wrap">

		<div id="icon-tools" class="icon32"></div>
		<h2><?php echo $theme_data['Name']; ?> Theme Error</h2>
	    <div id="message" class="error below-h2"><p><strong>Can't get update data from <?php echo $theme_data['Name']; ?>. </strong> You have version <?php echo $theme_data['Version']; ?> installed.</p></div>

        <img style="float: left; margin: 0 20px 20px 0; border: 1px solid #ddd; width:300px;" src="<?php echo get_bloginfo( 'stylesheet_directory' ) . '/screenshot.png'; ?>" />

        <div id="instructions" style="max-width: 800px;">
            <h3>Unable to get theme update data</h3>
            <b>Please note:</b> This is not a critical error, you can still use your theme as usual. Your site is just unable to connect to the update server for some unknown reason, most often because your server is unable to make outgoing connections or the update server itself is down.

			You can go to your My Account page on 9seeds.com <a href="https://9seeds.com/my-account/downloads/" alt="9seeds Theme Store My Account">here</a> to check for and manually update your theme if a newer version is available.
        </div>

            <div class="clear"></div>
	</div>
<?php
}

function update_notifier() {
	global $update_check_int, $update_check_int_seconds;
	$xml = get_latest_theme_version( $update_check_int_seconds ); // This tells the function to cache the remote call for 21600 seconds (6 hours)
	$theme_data = wp_get_theme(); ?>

	<style>
		.update-nag {display: none;}
		#instructions {max-width: 800px;}
		h3.title {margin: 30px 0 0 0; padding: 30px 0 0 0; border-top: 1px solid #ddd;}
		ul {line-height:1;list-style: disc inside;}
		p span {font-weight:bold;padding-left:20px;}
	</style>

	<div class="wrap">

		<div id="icon-tools" class="icon32"></div>
		<h2><?php echo $theme_data->get( 'Name' ); ?> Theme Updates</h2>
	    <div id="message" class="updated below-h2"><p><strong>There is a new version of the <?php echo $theme_data->get( 'Name' ); ?> theme available.</strong> You have version <?php echo $theme_data->get( 'Version' ); ?> installed. Update to version <?php echo $xml->latest; ?>.</p></div>

        <img style="float: left; margin: 0 20px 20px 0; border: 1px solid #ddd; width:300px;" src="<?php echo get_bloginfo( 'stylesheet_directory' ) . '/screenshot.png'; ?>" />

        <div id="instructions" style="max-width: 800px;">
            <h3>Update Download and Instructions</h3>
            <p><strong>Please note:</strong> make a <strong>backup</strong> of your <?php echo $theme_data->get( 'Name' ); ?> Theme prior to upgrading.</p>
            <p>To update the Theme, login to your <a href="https://9seeds.com/my-account/" target="_blank">My Account</a> page and re-download the theme like you did when you bought it.</p>
            <p>Extract the <strong><?php echo strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $theme_data->get( 'Name' )))); ?>-<?php echo $xml->latest; ?>.zip</strong> file's contents, look for the extracted theme folder, upload the folder's contents using FTP to the <strong>/wp-content/themes/<?php echo strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $theme_data->get( 'Name' )))); ?>/</strong> folder overwriting the old files (this is why it's important to backup any changes you've made to the theme files).</p>
            <p>If you didn't make any changes to the theme files, you are free to overwrite them with the new ones without the risk of losing theme settings, pages, posts, etc.</p>
            <p>If you have made any changes to the theme files <strong>updating will overwrite your customizations</strong>. In that case you may elect not to update your theme. You may go to the <a href="<?php echo site_url(); ?>/wp-admin/admin.php?page=jessica"><?php echo $theme_data->get( 'Name' ); ?> Settings</a> page to disable this update notification.</p>
        </div>

            <div class="clear"></div>

	    <h3 class="title">Changelog</h3>
	    <?php echo $xml->changelog; ?>

	</div>

<?php }

// This function retrieves a remote xml file on my server to see if there's a new update
// For performance reasons this function caches the xml content in the database for XX seconds ($interval variable)
function get_latest_theme_version( $interval ) {
	// remote xml file location
	$notifier_file_url = 'https://9seeds.com/files/theme-versions/jessica.xml';

	// Change the cache name to make updates from previous versions run smoother
	$db_cache_field = 'https-contempo-notifier-cache';
	$db_cache_field_last_updated = 'https-contempo-notifier-last-updated';
	
	$last = get_option( $db_cache_field_last_updated );
	$now = time();
	// check the cache
	if ( !$last || (( $now - $last ) > $interval ) ) {
		// cache doesn't exist, or is old, so refresh it
		if( function_exists( 'curl_init' ) ) { // if cURL is available, use it...
			$ch = curl_init( $notifier_file_url );
			// For servers which can't cURL from SSL sites
			curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );

			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_HEADER, 0 );
			curl_setopt( $ch, CURLOPT_TIMEOUT, 10 );
			$cache = curl_exec( $ch );
			curl_close( $ch );
		} else {
			$cache = file_get_contents( $notifier_file_url ); // ...if not, use the common file_get_contents()
		}

		if ($cache) {
			// we got good results
			update_option( $db_cache_field, $cache );
			update_option( $db_cache_field_last_updated, time() );
		}
		// read from the cache file
		$notifier_data = get_option( $db_cache_field );
	}
	else {
		// cache file is fresh enough, so read from it
		$notifier_data = get_option( $db_cache_field );
	}

	$use_errors = libxml_use_internal_errors(true);
	$xml = simplexml_load_string( $notifier_data );
	if (false === $xml) {
	  // throw new Exception("Cannot load xml source.\n");
	  $xml = new stdClass();
	  $xml->latest = -2;
	}
	libxml_clear_errors();
	libxml_use_internal_errors($use_errors);
	
	return $xml;
}