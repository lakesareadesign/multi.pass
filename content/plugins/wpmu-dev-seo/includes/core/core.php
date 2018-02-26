<?php
/**
 * Core helper functions
 *
 * Procedures smartcrawl_get_value(), smartcrawl_replace_vars(), smartcrawl_get_term_meta()
 * inspired by WordPress SEO by Joost de Valk (http://yoast.com/wordpress/seo/).
 *
 * @package wpmu-dev-seo
 */

/**
 * Gets post meta value
 *
 * @param string $val Key root to check.
 * @param int    $post_id Optional post ID.
 *
 * @return mixed
 */
function smartcrawl_get_value( $val, $post_id = false ) {
	if ( ! $post_id ) {
		global $post;
		$post_id = isset( $post ) ? $post->ID : false;
	}
	if ( ! $post_id ) { return false; }

	$custom = get_post_custom( $post_id );
	return ( ! empty( $custom[ '_wds_' . $val ][0] ) ) ?
		maybe_unserialize( $custom[ '_wds_' . $val ][0] )
		:
		false
	;
}

/**
 * Sets post meta value
 *
 * @param string $meta Key root to check.
 * @param mixed  $val Value to set.
 * @param int    $post_id Optional post ID.
 *
 * @return void
 */
function smartcrawl_set_value( $meta, $val, $post_id ) {
	update_post_meta( $post_id, "_wds_{$meta}", $val );
}

/**
 * Macro expansion helper
 *
 * @param string $string String to process.
 * @param array  $args Expansion vars.
 *
 * @return string
 */
function smartcrawl_replace_vars( $string, $args = array() ) {
	global $wp_query;

	$defaults = array(
		'ID' => '',
		'name' => '',
		'post_author' => '',
		'post_content' => '',
		'post_date' => '',
		'post_excerpt' => '',
		'post_modified' => '',
		'post_title' => '',
		'taxonomy' => '',
		'description' => '',
		'username' => '',
		'full_name' => '',
	);

	$pagenum = get_query_var( 'paged' );
	if ( 0 === $pagenum ) {
		$pagenum = ($wp_query->max_num_pages > 1) ? 1 : '';
	}

	$r = wp_parse_args( $args, $defaults );

	$smartcrawl_options = Smartcrawl_Settings::get_options();
	$preset_sep = ! empty( $smartcrawl_options['preset-separator'] ) ? $smartcrawl_options['preset-separator'] : 'pipe';
	$separator = ! empty( $smartcrawl_options['separator'] ) ? $smartcrawl_options['separator'] : smartcrawl_get_separators( $preset_sep );

	$replacements = array(
		'%%date%%' 					=> $r['post_date'],
		'%%title%%'					=> stripslashes( $r['post_title'] ),
		'%%sitename%%'				=> get_bloginfo( 'name' ),
		'%%sitedesc%%'				=> get_bloginfo( 'description' ),
		'%%excerpt%%'				=> smartcrawl_get_trimmed_excerpt( $r['post_excerpt'], $r['post_content'] ),
		'%%excerpt_only%%'			=> $r['post_excerpt'],
		'%%category%%'				=> (get_the_category_list( ', ','',$r['ID'] ) != '') ? strip_tags( get_the_category_list( ', ','',$r['ID'] ) ) : $r['name'],
		'%%category_description%%'	=> ! empty( $r['taxonomy'] ) ? trim( strip_tags( get_term_field( 'description', $r['term_id'], $r['taxonomy'] ) ) ) : '',
		'%%tag_description%%'		=> ! empty( $r['taxonomy'] ) ? trim( strip_tags( get_term_field( 'description', $r['term_id'], $r['taxonomy'] ) ) ) : '',
		'%%term_description%%'		=> ! empty( $r['taxonomy'] ) ? trim( strip_tags( get_term_field( 'description', $r['term_id'], $r['taxonomy'] ) ) ) : '',
		'%%term_title%%'			=> $r['name'],
		'%%tag%%'					=> $r['name'],
		'%%modified%%'				=> $r['post_modified'],
		'%%id%%'					=> $r['ID'],
		'%%name%%'					=> get_the_author_meta( 'display_name', ! empty( $r['post_author'] ) ? $r['post_author'] : get_query_var( 'author' ) ),
		'%%userid%%'				=> ! empty( $r['post_author'] ) ? $r['post_author'] : get_query_var( 'author' ),
		'%%searchphrase%%'			=> esc_html( get_query_var( 's' ) ),
		'%%currenttime%%'			=> date( 'H:i' ),
		'%%currentdate%%'			=> date( 'M jS Y' ),
		'%%currentmonth%%'			=> date( 'F' ),
		'%%currentyear%%'			=> date( 'Y' ),
		'%%page%%'		 			=> (get_query_var( 'paged' ) != 0) ? 'Page ' . get_query_var( 'paged' ) . ' of ' . $wp_query->max_num_pages : '',
		'%%spell_page%%'		 	=> (get_query_var( 'paged' ) != 0) ? 'Page ' . smartcrawl_spell_number( get_query_var( 'paged' ) ) . ' of ' . smartcrawl_spell_number( $wp_query->max_num_pages ) : '',
		'%%pagetotal%%'	 			=> ($wp_query->max_num_pages > 1) ? $wp_query->max_num_pages : '',
		'%%spell_pagetotal%%'	 	=> ($wp_query->max_num_pages > 1) ? smartcrawl_spell_number( $wp_query->max_num_pages ) : '',
		'%%pagenumber%%' 			=> $pagenum,
		'%%spell_pagenumber%%' 		=> smartcrawl_spell_number( $pagenum ),
		'%%caption%%'				=> $r['post_excerpt'],
		'%%bp_group_name%%'			=> $r['name'],
		'%%bp_group_description%%'	=> smartcrawl_get_trimmed_excerpt( '', $r['description'] ),
		'%%bp_user_username%%'	=> $r['username'],
		'%%bp_user_full_name%%'	=> $r['full_name'],
		'%%sep%%' 					=> $separator,
	);

	foreach ( $replacements as $var => $repl ) {
		$repl = apply_filters( 'wds-macro-variable_replacement', $repl, $var );
		$string = str_replace( $var, $repl, $string );
	}

	return $string;
}

/**
 * Gets separator, or separators list
 *
 * @param string $key Optional separator key.
 *
 * @return string|array
 */
function smartcrawl_get_separators( $key = null ) {
	$separators = array(
		'dot'           => '·',
		'dot-l'         => '•',
		'dash'          => '-',
		'dash-l'        => '—',
		'pipe'          => '|',
		'forward-slash' => '/',
		'back-slash'    => '\\',
		'tilde'         => '~',
		'greater-than'  => '>',
		'less-than'     => '<',
		'caret-right'   => '›',
		'caret-left'    => '‹',
		'arrow-right'   => '→',
		'arrow-left'    => '←',
	);

	if ( null === $key || empty( $separators[ $key ] ) ) {
		return $separators;
	} else {
		return $separators[ $key ];
	}
}

/**
 * Returns the post title meta using options set by user on smartcrawl_onpage
 *
 * @param WP_Post $post Optional post.
 *
 * @return string|false
 */
function smartcrawl_get_seo_title( $post = false ) {
	$smartcrawl_options = Smartcrawl_Settings::get_options();

	if ( ! $post ) {
		global $post;
	}
	if ( ! $post ) { return false; }

	if ( ! empty( $post->post_type ) && isset( $smartcrawl_options[ 'title-' . $post->post_type ] ) && ! empty( $smartcrawl_options[ 'title-' . $post->post_type ] ) ) {
		return smartcrawl_replace_vars( $smartcrawl_options[ 'title-' . $post->post_type ], (array) $post );
	}

	return 'false';
}

/**
 * Returns the post desc meta using options set by user on smartcrawl_onpage
 *
 * @param WP_Post $post Optional post.
 *
 * @return string|false
 */
function smartcrawl_get_seo_desc( $post = false ) {
	$smartcrawl_options = Smartcrawl_Settings::get_options();

	if ( ! $post ) {
		global $post;
	}
	if ( ! $post ) { return false; }

	if ( ! empty( $post->post_type ) && isset( $smartcrawl_options[ 'metadesc-' . $post->post_type ] ) && ! empty( $smartcrawl_options[ 'metadesc-' . $post->post_type ] ) ) {
		return smartcrawl_replace_vars( $smartcrawl_options[ 'metadesc-' . $post->post_type ], (array) $post );
	}

	return false;
}


/**
 * Returns the number as an anglicized string
 *
 * Adapted from original code by Hugh Bothwell (hugh_bothwell@hotmail.com)
 *
 * @param int $num Number to convert.
 *
 * @return string
 */
function smartcrawl_spell_number( $num ) {
	$num = (int) $num;    // make sure it's an integer.

	if ( $num < 0 ) { return 'negative' . _wds_hb_convert_tri( -$num, 0 ); }
	if ( 0 == $num ) { return 'zero'; }

	return _wds_hb_convert_tri( $num, 0 );
}

/**
 * Recursive fn, converts three digits per pass
 *
 * Adapted from original code by Hugh Bothwell (hugh_bothwell@hotmail.com)
 *
 * @param int $num Number to convert.
 * @param int $tri Triplet to check.
 *
 * @return string
 */
function _wds_hb_convert_tri( $num, $tri ) {
	$ones = array(
		'',
		' one',
		' two',
		' three',
		' four',
		' five',
		' six',
		' seven',
		' eight',
		' nine',
		' ten',
		' eleven',
		' twelve',
		' thirteen',
		' fourteen',
		' fifteen',
		' sixteen',
		' seventeen',
		' eighteen',
		' nineteen',
	);

	$tens = array(
		'',
		'',
		' twenty',
		' thirty',
		' forty',
		' fifty',
		' sixty',
		' seventy',
		' eighty',
		' ninety',
	);

	$triplets = array(
		'',
		' thousand',
		' million',
		' billion',
		' trillion',
		' quadrillion',
		' quintillion',
		' sextillion',
		' septillion',
		' octillion',
		' nonillion',
	);

	// chunk the number, ...rxyy.
	$r = (int) ($num / 1000);
	$x = ($num / 100) % 10;
	$y = $num % 100;

	// init the output string.
	$str = '';

	// do hundreds.
	if ( $x > 0 ) { $str = $ones[ $x ] . ' hundred'; }

	// do ones and tens.
	if ( $y < 20 ) { $str .= $ones[ $y ]; } else { $str .= $tens[ (int) ($y / 10) ] . $ones[ $y % 10 ]; }

	// add triplet modifier only if there is some output to be modified...
	if ( '' != $str ) { $str .= $triplets[ $tri ]; }

	// continue recursing?
	if ( $r > 0 ) { return _wds_hb_convert_tri( $r, $tri + 1 ) . $str; } else { return $str; }
}

/**
 * Gets excerpt trimmed to length
 *
 * @param string $excerpt Optional excerpt.
 * @param string $contents Contents.
 *
 * @return string
 */
function smartcrawl_get_trimmed_excerpt( $excerpt, $contents ) {
	$string = $excerpt ? $excerpt : $contents;
	$string = trim( preg_replace( '/\r|\n/', ' ', strip_shortcodes( htmlspecialchars( wp_strip_all_tags( strip_shortcodes( $string ) ), ENT_QUOTES ) ) ) );
	return (preg_match( '/.{156,}/um', $string ))
		? preg_replace( '/(.{0,152}).*/um', '$1', $string ) . '...'
		: $string
	;
}

/**
 * Gets taxonomy term meta value
 *
 * @param object $term Term object.
 * @param string $taxonomy Taxonomy the term belongs to.
 * @param string $meta Meta key to check.
 *
 * @return mixed
 */
function smartcrawl_get_term_meta( $term, $taxonomy, $meta ) {
	$term = (is_object( $term )) ? $term->term_id : get_term_by( 'slug', $term, $taxonomy );
	$tax_meta = get_option( 'wds_taxonomy_meta' );

	return (isset( $tax_meta[ $taxonomy ][ $term ][ $meta ] )) ? $tax_meta[ $taxonomy ][ $term ][ $meta ] : false;
}

/**
 * Blog template settings handler
 *
 * @param string $and Query gathered this far.
 *
 * @return string
 */
function smartcrawl_blog_template_settings( $and ) {
	// $and .= " AND `option_name` != 'wds_sitemaps_options'"; // Removed plural
	$and .= " AND `option_name` != 'wds_sitemap_options'"; // Added singular
	return $and;
}
add_filter( 'blog_template_exclude_settings', 'wds_blog_template_settings' );


/**
 * Checks user persmission level against minumum requirement
 * for displaying SEO metabox.
 *
 * @return bool
 */
function user_can_see_seo_metabox() {
	$smartcrawl_options = Smartcrawl_Settings::get_options();
	$capability = (defined( 'SMARTCRAWL_SEO_METABOX_ROLE' ) && SMARTCRAWL_SEO_METABOX_ROLE)
		? SMARTCRAWL_SEO_METABOX_ROLE
		: ( ! empty( $smartcrawl_options['seo_metabox_permission_level'] ) ? $smartcrawl_options['seo_metabox_permission_level'] : false)
	;
	$capability = apply_filters( 'wds-capabilities-seo_metabox', $capability );
	$able = false;

	if ( is_array( $capability ) ) {
		foreach ( $capability as $cap ) {
			$able = current_user_can( $cap );
			if ( $able ) { break; }
		}
	} else {
		$able = current_user_can( $capability );
	}
	return $able;
}

/**
 * Checks user persmission level against minumum requirement
 * for displaying Moz urlmetrics metabox.
 *
 * @return bool
 */
function user_can_see_urlmetrics_metabox() {
	$smartcrawl_options = Smartcrawl_Settings::get_options();
	$capability = (defined( 'SMARTCRAWL_URLMETRICS_METABOX_ROLE' ) && SMARTCRAWL_URLMETRICS_METABOX_ROLE)
		? SMARTCRAWL_URLMETRICS_METABOX_ROLE
		: ( ! empty( $smartcrawl_options['urlmetrics_metabox_permission_level'] ) ? $smartcrawl_options['urlmetrics_metabox_permission_level'] : false)
	;
	$capability = apply_filters( 'wds-capabilities-urlmetrics_metabox', $capability );
	$able = false;

	if ( is_array( $capability ) ) {
		foreach ( $capability as $cap ) {
			$able = current_user_can( $cap );
			if ( $able ) { break; }
		}
	} else {
		$able = current_user_can( $capability );
	}
	return $able;
}

/**
 * Checks user persmission level against minumum requirement
 * for displaying the 301 redirection field within SEO metabox.
 *
 * @return bool
 */
function user_can_see_seo_metabox_301_redirect() {
	$smartcrawl_options = Smartcrawl_Settings::get_options();
	$capability = (defined( 'SMARTCRAWL_SEO_METABOX_301_ROLE' ) && SMARTCRAWL_SEO_METABOX_301_ROLE)
		? SMARTCRAWL_SEO_METABOX_301_ROLE
		: ( ! empty( $smartcrawl_options['seo_metabox_301_permission_level'] ) ? $smartcrawl_options['seo_metabox_301_permission_level'] : false)
	;
	$capability = apply_filters( 'wds-capabilities-seo_metabox_301_redirect', $capability );
	$able = false;

	if ( is_array( $capability ) ) {
		foreach ( $capability as $cap ) {
			$able = current_user_can( $cap );
			if ( $able ) { break; }
		}
	} else {
		$able = current_user_can( $capability );
	}
	return $able;
}

/**
 * Attempt to hide metaboxes by default by adding them to "hidden" array.
 *
 * Metaboxes are still added to "Screen Options".
 * If user chooses to show/hide them, respect her decision.
 *
 * @deprecated as of version 1.0.9
 *
 * @param array $arg Whatever's been already hidden.
 *
 * @return array
 */
function smartcrawl_process_default_hidden_meta_boxes( $arg ) {
	$smartcrawl_options = Smartcrawl_Settings::get_options();
	$arg[] = 'wds-wds-meta-box';
	$arg[] = 'wds_seomoz_urlmetrics';
	return $arg;
}

/**
 * Hide ALL wds metaboxes.
 *
 * Respect wishes for other metaboxes.
 * Still accessble from "Screen Options".
 *
 * @param array $arg Whatever's been already hidden.
 *
 * @return array
 */
function smartcrawl_hide_metaboxes( $arg ) {
	// Hide WP defaults, if nothing else.
	if ( empty( $arg ) ) { $arg = array( 'slugdiv', 'trackbacksdiv', 'postcustom', 'postexcerpt', 'commentstatusdiv', 'commentsdiv', 'authordiv', 'revisionsdiv' ); }
	$arg[] = 'wds-wds-meta-box';
	$arg[] = 'wds_seomoz_urlmetrics';
	return $arg;
}

/**
 * Register metabox hiding for other boxes.
 *
 * @deprecated
 */
function smartcrawl_register_metabox_hiding() {
	$post_types = get_post_types();
	foreach ( $post_types as $type ) { add_filter( 'get_user_option_metaboxhidden_' . $type, 'wds_hide_metaboxes' ); }

}

/**
 * Forces metaboxes to start collapsed.
 *
 * It properly merges the WDS boxes with the rest of the users collapsed boxes.
 * For info on registering, see `register_metabox_collapsed_state`.
 *
 * @param array $closed Whatever's been closed this far.
 *
 * @return array
 */
function force_metabox_collapsed_state( $closed ) {
	$closed = is_array( $closed ) ? $closed : array();
	return array_merge($closed, array(
		'wds-wds-meta-box',
		'wds_seomoz_urlmetrics',
	));
}

/**
 * Registers WDS boxes state.
 * Collapsed state is tracked per post type.
 * This is why we have this separate hook to register state change processing.
 */
function register_metabox_collapsed_state() {
	global $post;
	if ( $post && $post->post_type ) {
		add_filter( 'get_user_option_closedpostboxes_' . $post->post_type, 'force_metabox_collapsed_state' );
	}
}
add_filter( 'post_edit_form_tag', 'register_metabox_collapsed_state' );

/**
 * Checks the page tab slug against permitted ones.
 *
 * This applies only for multisite, non-sitewide setups.
 *
 * @param string $slug Slug to check.
 *
 * @return bool
 */
function smartcrawl_is_allowed_tab( $slug ) {
	$blog_tabs = get_site_option( 'wds_blog_tabs' );
	$blog_tabs = is_array( $blog_tabs ) ? $blog_tabs : array();
	$allowed = true;
	if ( is_multisite() && ! SMARTCRAWL_SITEWIDE ) {
		$allowed = in_array( $slug, $blog_tabs ) ? true : false;
	}
	return $allowed;
}

/**
 * Checks if transient is stuck
 *
 * Stuck transient has no expiry time.
 * If so found, removes it.
 *
 * @param string $key Transient key.
 *
 * @return bool
 */
function smartcrawl_kill_stuck_transient( $key ) {
	global $_wp_using_ext_object_cache;
	if ( $_wp_using_ext_object_cache ) { return true; } // In object cache, nothing to do.

	$key = "_transient_{$key}";
	$alloptions = wp_load_alloptions();
	// If option is in alloptions, it is autoloaded and thus has no timeout - kill it.
	if ( isset( $alloptions[ $key ] ) ) { return delete_option( $key ); }

	return true;
}

/**
 * Check for boolean define switches and their values.
 *
 * @param string $switch Define name to check.
 *
 * @return bool
 */
function smartcrawl_is_switch_active( $switch ) {
	return defined( $switch ) ? constant( $switch ) : false;
}

/**
 * Check if we're on main BuddyPress site - BuddyPress root blog check.
 *
 * @return bool Are we on the main BuddyPress site.
 */
function smartcrawl_is_main_bp_site() {
	if ( is_multisite() && defined( 'BP_VERSION' ) && (defined( 'BP_ROOT_BLOG' ) && BP_ROOT_BLOG) ) {
		global $blog_id;
		return BP_ROOT_BLOG == $blog_id;
	}
	return is_main_site();
}

/**
 * Converts an argument map to HTML attributes string.
 *
 * @param array $args A hash of arguments.
 * @return string Constructed attributes string
 */
function smartcrawl_autolinks_construct_attributes( $args = array() ) {
	$ret = array();
	if ( empty( $args ) ) { return ''; }
	foreach ( $args as $key => $value ) {
		if ( empty( $key ) || empty( $value ) ) { continue; // Only accept properly formatted members.
		}		$ret[] = esc_html( $key ) . '="' . esc_attr( $value ) . '"';
	}
	return apply_filters( 'wds_autolinks_attributes', trim( join( ' ', $ret ) ) );
}

/**
 * MarketPress global term name finding helper
 *
 * @param string $mp_term MarketPress global term name.
 *
 * @return string
 */
function smartcrawl_get_mp_global_term_name( $mp_term ) {
	if ( empty( $mp_term ) ) { return ''; }

	$key = 'mp_term_name-' . preg_replace( '/[^-_a-z0-9]i/', '', $mp_term );
	$mp_term_name = wp_cache_get( $key, 'wds' );
	if ( empty( $mp_term_name ) ) {
		global $wpdb;
		$mp_term_name = $wpdb->get_var( $wpdb->prepare( "SELECT name FROM {$wpdb->base_prefix}mp_terms WHERE slug = %s", $mp_term ) ); // Yanked from MarketPress_MS, no accessor.
		wp_cache_set( $key, $mp_term_name, 'wds' );
	}

	return $mp_term_name;
}

/**
 * Get a value from an array. If nothing is found for the provided keys, returns null.
 *
 * @param array        $array The array to search (haystack).
 * @param array|string $key The key to use for the search.
 *
 * @return null|mixed The array value found or null if nothing found.
 */
function smartcrawl_get_array_value( $array, $key ) {
	if ( ! is_array( $key ) ) {
		$key = array( $key );
	}

	if ( ! is_array( $array ) ) {
		return null;
	}

	$value = $array;
	foreach ( $key as $key_part ) {
		$value = isset( $value[ $key_part ] ) ? $value[ $key_part ] : null;
	}

	return $value;
}

/**
 * Inserts a value in the given array.
 *
 * @param mixed        $value The value to insert.
 * @param array        $array The array in which the value is to be inserted. Passed by reference.
 * @param array|string $keys Key specifying the place where the new value is to be inserted.
 *
 * @return void
 */
function smartcrawl_put_array_value( $value, &$array, $keys ) {
	if ( ! is_array( $keys ) ) {
		$keys = array( $keys );
	}

	$pointer = &$array;
	foreach ( $keys as $key ) {
		if ( ! isset( $pointer[ $key ] ) ) {
			$pointer[ $key ] = array(); }
		$pointer = &$pointer[ $key ];
	}
	$pointer = $value;
}

/**
 * Gets whatever's latest of a post
 *
 * @param int $post_id Post ID.
 *
 * @return WP_Post
 */
function smartcrawl_get_post_or_latest_revision( $post_id ) {
	$data = stripslashes_deep( $_POST );
	$is_auto_save = (bool) smartcrawl_get_array_value( $data, 'autosave_update' );
	if ( $is_auto_save ) {
		$post_revisions = wp_get_post_revisions( $post_id );
		if ( count( $post_revisions ) ) {
			return array_shift( $post_revisions );
		}
	}

	return get_post( $post_id );
}

/**
 * Checks if a dashboard widget mode is renderable
 *
 * Used on dashboard root page, for scenarios when we're
 * outside the network-wide mode and not all tabs are active
 * for site admins, in order to prevent showing broken "configure" links
 * and such. Re: https://app.asana.com/0/46496453944769/509480319187557/f
 *
 * @param string $tab Tab to check.
 *
 * @return bool
 */
function smartcrawl_can_show_dash_widget_for( $tab ) {
	if ( ! ! smartcrawl_is_switch_active( 'SMARTCRAWL_SITEWIDE' ) ) { return true; }

	if ( ! is_network_admin() ) { return true; } // Whatever, let site admin deal with it.

	// Not in sitewide mode, let's check if site admins can access it.
	$allowed_blog_tabs = Smartcrawl_Settings_Settings::get_blog_tabs();
	$allowed = in_array( $tab, array_keys( $allowed_blog_tabs ) ) && ! empty( $allowed_blog_tabs[ $tab ] );
	return $allowed;
}

/**
 * Sanitizes a string into relative URL
 *
 * @param string $raw Raw string to process.
 *
 * @return string Root-relative string
 */
function smartcrawl_sanitize_relative_url( $raw ) {
	$raw = preg_match( '/^https?:\/\//', $raw ) || preg_match( '/^\//', $raw )
		? esc_url( $raw )
		: esc_url( "/{$raw}" );

	$parsed = parse_url( $raw );
	$result = '';

	if ( empty( $parsed ) ) {
		$domain = preg_replace( '/^https?:\/\//', '', home_url() );
		$raw = preg_replace( '/^https?:\/\//', '', $raw );
		$result = preg_replace( '/^' . preg_quote( $domain, '/' ) . '/', '', $raw );
	} else {
		$result = ! empty( $parsed['path'] ) ? $parsed['path'] : '/';
		if ( ! empty( $parsed['query'] ) ) {
			$result .= '?' . $parsed['query'];
		}
	}

	return '/' . ltrim( $result, '/' );
}

/**
 * Gets regex for matching against a list of relative URLs
 *
 * @param string $urls A list of relative URLs.
 *
 * @return string
 */
function smartcrawl_get_relative_urls_regex( $urls ) {
	$regex = '';
	if ( ! is_array( $urls ) ) { return $regex; }

	$processed = array();
	foreach ( $urls as $url ) {
		if ( empty( $url ) ) { continue; }
		$processed[] = preg_quote( $url, '/' );
	}
	$regex = '/https?:\/\/.*?(' . join( '|', $processed ) . ')\/?$/';

	return $regex;
}