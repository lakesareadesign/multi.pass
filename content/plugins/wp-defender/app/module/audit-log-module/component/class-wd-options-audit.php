<?php

/**
 * Author: Hoang Ngo
 */
class WD_Options_Audit extends WD_Event_Abstract {
	const CONTEXT_SETTINGS = 'ct_setting';

	public function get_hooks() {
		return array(
			'update_option'      => array(
				'args'        => array( 'option', 'old_value', 'value' ),
				'callback'    => array( 'WD_Options_Audit', 'process_options' ),
				'level'       => self::LOG_LEVEL_ERROR,
				'event_type'  => 'settings',
				'action_type' => WD_Audit_API::ACTION_UPDATED,
			),
			/*'update_site_option' => array(
				'args'        => array( 'option', 'old_value', 'value' ),
				'callback'    => array( 'WD_Options_Audit', 'process_network_options' ),
				'level'       => self::LOG_LEVEL_ERROR,
				'event_type'  => 'settings',
				'action_type' => WD_Audit_API::ACTION_UPDATED,
			)*/
		);
	}

	public static function process_network_options() {
		$args   = func_get_args();
		$option = $args[1]['option'];
		$old    = $args[1]['old_value'];
		$new    = $args[1]['value'];

		$option_human_read = self::key_to_human_name( $option );

		if ( $old == $new ) {
			return false;
		}

		if ( is_array( $old ) ) {
			$old = implode( ', ', $old );
		}

		if ( is_array( $new ) ) {
			$new = implode( ', ', $new );
		}

		$text = sprintf( __( "%s update network option %s from %s to %s", wp_defender()->domain ),
			WD_Utils::get_user_name( get_current_user_id() ), $option_human_read, $old, $new );

		return array( $text, self::CONTEXT_SETTINGS );
	}

	/**
	 * @return bool|string
	 */
	public static function process_options() {
		$args   = func_get_args();
		$option = $args[1]['option'];
		$old    = $args[1]['old_value'];
		$new    = $args[1]['value'];

		$option_human_read = self::key_to_human_name( $option );

		if ( $old == $new ) {
			return false;
		}
		if ( $option_human_read !== false ) {
			//we will need special case for reader
			switch ( $option ) {
				case 'users_can_register':
					if ( $new == 0 ) {
						$text = sprintf( __( "%s disabled site registration", wp_defender()->domain ), WD_Utils::get_user_name( get_current_user_id() ) );
					} else {
						$text = sprintf( __( "%s opened site registration", wp_defender()->domain ), WD_Utils::get_user_name( get_current_user_id() ) );
					}
					break;
				case 'start_of_week':
					global $wp_locale;
					$old_day = $wp_locale->get_weekday( $old );
					$new_day = $wp_locale->get_weekday( $new );
					$text    = sprintf( __( "%s update option %s from %s to %s", wp_defender()->domain ),
						WD_Utils::get_user_name( get_current_user_id() ), $option_human_read, $old_day, $new_day );
					break;
				case 'WPLANG':
					//no old value here
					$text = sprintf( __( "%s update option %s to %s", wp_defender()->domain ),
						WD_Utils::get_user_name( get_current_user_id() ), $option_human_read, $old, $new );
					break;
				default:
					$text = sprintf( __( "%s update option %s from %s to %s", wp_defender()->domain ),
						WD_Utils::get_user_name( get_current_user_id() ), $option_human_read, $old, $new );
					break;
			}

			return array( $text, self::CONTEXT_SETTINGS );
		} else {

		}

		return false;
	}

	private static function key_to_human_name( $key ) {
		$human_read = apply_filters( 'wd_audit_settings_keys', array(
			'blogname'                      => __( "Site Title", wp_defender()->domain ),
			'blogdescription'               => __( "Tagline", wp_defender()->domain ),
			'gmt_offset'                    => __( "Timezone", wp_defender()->domain ),
			'date_format'                   => __( "Date Format", wp_defender()->domain ),
			'time_format'                   => __( "Time Format", wp_defender()->domain ),
			'start_of_week'                 => __( "Week Starts On", wp_defender()->domain ),
			'timezone_string'               => __( "Timezone", wp_defender()->domain ),
			'WPLANG'                        => __( "Site Language", wp_defender()->domain ),
			'siteurl'                       => __( "WordPress Address (URL)", wp_defender()->domain ),
			'home'                          => __( "Site Address (URL)", wp_defender()->domain ),
			'admin_email'                   => __( "Email Address", wp_defender()->domain ),
			'users_can_register'            => __( "Membership", wp_defender()->domain ),
			'default_role'                  => __( "New User Default Role", wp_defender()->domain ),
			'default_pingback_flag'         => __( "Default article settings", wp_defender()->domain ),
			'default_ping_status'           => __( "Default article settings", wp_defender()->domain ),
			'default_comment_status'        => __( "Default article settings", wp_defender()->domain ),
			'comments_notify'               => __( "Email me whenever", wp_defender()->domain ),
			'moderation_notify'             => __( "Email me whenever", wp_defender()->domain ),
			'comment_moderation'            => __( "Before a comment appears", wp_defender()->domain ),
			'require_name_email'            => __( "Other comment settings", wp_defender()->domain ),
			'comment_whitelist'             => __( "Before a comment appears", wp_defender()->domain ),
			'comment_max_links'             => __( "Comment Moderation", wp_defender()->domain ),
			'moderation_keys'               => __( "Comment Moderation", wp_defender()->domain ),
			'blacklist_keys'                => __( "Comment Blacklist", wp_defender()->domain ),
			'show_avatars'                  => __( "Avatar Display", wp_defender()->domain ),
			'avatar_rating'                 => __( "Maximum Rating", wp_defender()->domain ),
			'avatar_default'                => __( "Default Avatar", wp_defender()->domain ),
			'close_comments_for_old_posts'  => __( "Other comment settings", wp_defender()->domain ),
			'close_comments_days_old'       => __( "Other comment settings", wp_defender()->domain ),
			'thread_comments'               => __( "Other comment settings", wp_defender()->domain ),
			'thread_comments_depth'         => __( "Other comment settings", wp_defender()->domain ),
			'page_comments'                 => __( "Other comment settings", wp_defender()->domain ),
			'comments_per_page'             => __( "Other comment settings", wp_defender()->domain ),
			'default_comments_page'         => __( "Other comment settings", wp_defender()->domain ),
			'comment_order'                 => __( "Other comment settings", wp_defender()->domain ),
			'comment_registration'          => __( "Other comment settings", wp_defender()->domain ),
			'thumbnail_size_w'              => __( "Thumbnail size", wp_defender()->domain ),
			'thumbnail_size_h'              => __( "Thumbnail size", wp_defender()->domain ),
			'thumbnail_crop'                => __( "Thumbnail size", wp_defender()->domain ),
			'medium_size_w'                 => __( "Medium size", wp_defender()->domain ),
			'medium_size_h'                 => __( "Medium size", wp_defender()->domain ),
			'medium_large_size_w'           => __( "Medium size", wp_defender()->domain ),
			'medium_large_size_h'           => __( "Medium size", wp_defender()->domain ),
			'large_size_w'                  => __( "Large size", wp_defender()->domain ),
			'large_size_h'                  => __( "Large size", wp_defender()->domain ),
			'image_default_size'            => __( "", wp_defender()->domain ),
			'image_default_align'           => __( "", wp_defender()->domain ),
			'image_default_link_type'       => __( "", wp_defender()->domain ),
			'uploads_use_yearmonth_folders' => __( "Uploading Files", wp_defender()->domain ),
			'posts_per_page'                => __( "Blog pages show at most", wp_defender()->domain ),
			'posts_per_rss'                 => __( "Syndication feeds show the most recent", wp_defender()->domain ),
			'rss_use_excerpt'               => __( "For each article in a feed, show", wp_defender()->domain ),
			'show_on_front'                 => __( "Front page displays", wp_defender()->domain ),
			'page_on_front'                 => __( "Front page", wp_defender()->domain ),
			'page_for_posts'                => __( "Posts page", wp_defender()->domain ),
			'blog_public'                   => __( "Search Engine Visibility", wp_defender()->domain ),
			'default_category'              => __( "Default Post Category", wp_defender()->domain ),
			'default_email_category'        => __( "Default Mail Category", wp_defender()->domain ),
			'default_link_category'         => __( "", wp_defender()->domain ),
			'default_post_format'           => __( "Default Post Format", wp_defender()->domain ),
			'mailserver_url'                => __( "Mail Server", wp_defender()->domain ),
			'mailserver_port'               => __( "Port", wp_defender()->domain ),
			'mailserver_login'              => __( "Login Name", wp_defender()->domain ),
			'mailserver_pass'               => __( "Password", wp_defender()->domain ),
			'ping_sites'                    => __( "", wp_defender()->domain ),
			'permalink_structure'           => __( "Permalink Setting", wp_defender()->domain ),
			'category_base'                 => __( "Category base", wp_defender()->domain ),
			'tag_base'                      => __( "Tag base", wp_defender()->domain ),
			'registrationnotification'      => __( "Registration notification", wp_defender()->domain ),
			'registration'                  => __( "Allow new registrations", wp_defender()->domain ),
			'add_new_users'                 => __( "Add New Users", wp_defender()->domain ),
			'menu_items'                    => __( "Enable administration menus", wp_defender()->domain ),
			'upload_space_check_disabled'   => __( "Site upload space", wp_defender()->domain ),
			'blog_upload_space'             => __( "Site upload space", wp_defender()->domain ),
			'upload_filetypes'              => __( "Upload file types", wp_defender()->domain ),
			'site_name'                     => __( "Network Title", wp_defender()->domain ),
			'first_post'                    => __( "First Post", wp_defender()->domain ),
			'first_page'                    => __( "First Page", wp_defender()->domain ),
			'first_comment'                 => __( "First Comment", wp_defender()->domain ),
			'first_comment_url'             => __( "First Comment URL", wp_defender()->domain ),
			'first_comment_author'          => __( "First Comment Author", wp_defender()->domain ),
			'welcome_email'                 => __( "Welcome Email", wp_defender()->domain ),
			'welcome_user_email'            => __( "Welcome User Email", wp_defender()->domain ),
			'fileupload_maxk'               => __( "Max upload file size", wp_defender()->domain ),
			//'global_terms_enabled'          => __( "", wp_defender()->domain ),
			'illegal_names'                 => __( "Banned Names", wp_defender()->domain ),
			'limited_email_domains'         => __( "Limited Email Registrations", wp_defender()->domain ),
			'banned_email_domains'          => __( "Banned Email Domains", wp_defender()->domain ),
		) );

		if ( isset( $human_read[ $key ] ) ) {
			if ( empty( $human_read[ $key ] ) ) {
				return $key;
			}

			return $human_read[ $key ];
		}

		return false;
	}

	public function dictionary() {
		return array(
			self::CONTEXT_SETTINGS => __( "Settings", wp_defender()->domain )
		);
	}
}