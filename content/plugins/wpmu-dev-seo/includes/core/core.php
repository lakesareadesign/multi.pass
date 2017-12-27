<?php
/**
 * wds_get_value(), wds_replace_vars(), wds_get_term_meta()
 * inspired by WordPress SEO by Joost de Valk (http://yoast.com/wordpress/seo/).
 */
function wds_get_value ($val, $post_id=false) {
	if (!$post_id) {
		global $post;
		$post_id = isset($post) ? $post->ID : false;
	}
	if (!$post_id) return false;

	$custom = get_post_custom($post_id);
	return ( !empty($custom['_wds_'.$val][0]) ) ?
		maybe_unserialize($custom['_wds_'.$val][0])
		:
		false
	;
}

function wds_set_value ($meta, $val, $post_id) {
	update_post_meta($post_id, "_wds_{$meta}", $val);
}



function wds_replace_vars ($string, $args=array()) {
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

	$pagenum = get_query_var('paged');
	if ($pagenum === 0) {
		$pagenum = ($wp_query->max_num_pages > 1) ? 1 : '';
	}

	$r = wp_parse_args($args, $defaults);

	$wds_options = WDS_Settings::get_options();
	$preset_sep = !empty($wds_options['preset-separator']) ? $wds_options['preset-separator'] : 'pipe';
	$separator = !empty($wds_options['separator']) ? $wds_options['separator'] : wds_get_separators($preset_sep);

	$replacements = array(
		'%%date%%' 					=> $r['post_date'],
		'%%title%%'					=> stripslashes($r['post_title']),
		'%%sitename%%'				=> get_bloginfo('name'),
		'%%sitedesc%%'				=> get_bloginfo('description'),
		'%%excerpt%%'				=> wds_get_trimmed_excerpt($r['post_excerpt'], $r['post_content']),
		'%%excerpt_only%%'			=> $r['post_excerpt'],
		'%%category%%'				=> (get_the_category_list(', ','',$r['ID']) != '') ? strip_tags(get_the_category_list(', ','',$r['ID'])) : $r['name'],
		'%%category_description%%'	=> !empty($r['taxonomy']) ? trim(strip_tags(get_term_field( 'description', $r['term_id'], $r['taxonomy'] ))) : '',
		'%%tag_description%%'		=> !empty($r['taxonomy']) ? trim(strip_tags(get_term_field( 'description', $r['term_id'], $r['taxonomy'] ))) : '',
		'%%term_description%%'		=> !empty($r['taxonomy']) ? trim(strip_tags(get_term_field( 'description', $r['term_id'], $r['taxonomy'] ))) : '',
		'%%term_title%%'			=> $r['name'],
		'%%tag%%'					=> $r['name'],
		'%%modified%%'				=> $r['post_modified'],
		'%%id%%'					=> $r['ID'],
		'%%name%%'					=> get_the_author_meta('display_name', !empty($r['post_author']) ? $r['post_author'] : get_query_var('author')),
		'%%userid%%'				=> !empty($r['post_author']) ? $r['post_author'] : get_query_var('author'),
		'%%searchphrase%%'			=> esc_html(get_query_var('s')),
		'%%currenttime%%'			=> date('H:i'),
		'%%currentdate%%'			=> date('M jS Y'),
		'%%currentmonth%%'			=> date('F'),
		'%%currentyear%%'			=> date('Y'),
		'%%page%%'		 			=> (get_query_var('paged') != 0) ? 'Page ' . get_query_var('paged') . ' of ' . $wp_query->max_num_pages : '',
		'%%spell_page%%'		 	=> (get_query_var('paged') != 0) ? 'Page '. wds_spell_number(get_query_var('paged')) . ' of ' . wds_spell_number($wp_query->max_num_pages) : '',
		'%%pagetotal%%'	 			=> ($wp_query->max_num_pages > 1) ? $wp_query->max_num_pages : '',
		'%%spell_pagetotal%%'	 	=> ($wp_query->max_num_pages > 1) ? wds_spell_number($wp_query->max_num_pages) : '',
		'%%pagenumber%%' 			=> $pagenum,
		'%%spell_pagenumber%%' 		=> wds_spell_number($pagenum),
		'%%caption%%'				=> $r['post_excerpt'],
		'%%bp_group_name%%'			=> $r['name'],
		'%%bp_group_description%%'	=> wds_get_trimmed_excerpt('', $r['description']),
		'%%bp_user_username%%'	=> $r['username'],
		'%%bp_user_full_name%%'	=> $r['full_name'],
		'%%sep%%' 					=> $separator,
	);

	foreach ($replacements as $var => $repl) {
		$repl = apply_filters('wds-macro-variable_replacement', $repl, $var);
		$string = str_replace($var, $repl, $string);
	}

	return $string;
}

function wds_get_separators($key = null)
{
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
		'arrow-left'    => '←'
	);

	if ($key === null || empty($separators[ $key ])) {
		return $separators;
	} else {
		return $separators[ $key ];
	}
}

/**
 * Returns the post title meta using options set by user on wds_onpage
 *
 * @return string/false
 */
function wds_get_seo_title ($post=false) {
	$wds_options = WDS_Settings::get_options();

	if (!$post) {
		global $post;
	}
	if (!$post) return false;

	if (!empty($post->post_type) && isset($wds_options['title-'.$post->post_type]) && !empty($wds_options['title-'.$post->post_type]) ) {
		return wds_replace_vars($wds_options['title-'.$post->post_type], (array) $post );
	}

	return 'false';
}

/**
 * Returns the post desc meta using options set by user on wds_onpage
 *
 * @return string/false
 */

function wds_get_seo_desc ($post=false) {
	$wds_options = WDS_Settings::get_options();

	if (!$post) {
		global $post;
	}
	if (!$post) return false;

	if (!empty($post->post_type) && isset($wds_options['metadesc-'.$post->post_type]) && !empty($wds_options['metadesc-'.$post->post_type]) ) {
		return wds_replace_vars($wds_options['metadesc-'.$post->post_type], (array) $post );
	}

	return false;
}


/**
 * Returns the number as an anglicized string
 * Adapted from original code by Hugh Bothwell (hugh_bothwell@hotmail.com)
 */
function wds_spell_number ($num) {
	$num = (int) $num;    // make sure it's an integer

	if ($num < 0) return "negative"._wds_hb_convert_tri(-$num, 0);
	if ($num == 0) return "zero";

	return _wds_hb_convert_tri($num, 0);
}
/**
 * Recursive fn, converts three digits per pass
 * Adapted from original code by Hugh Bothwell (hugh_bothwell@hotmail.com)
 */
function _wds_hb_convert_tri ($num, $tri) {
	$ones = array(
		"",
		" one",
		" two",
		" three",
		" four",
		" five",
		" six",
		" seven",
		" eight",
		" nine",
		" ten",
		" eleven",
		" twelve",
		" thirteen",
		" fourteen",
		" fifteen",
		" sixteen",
		" seventeen",
		" eighteen",
		" nineteen"
	);

	$tens = array(
		"",
		"",
		" twenty",
		" thirty",
		" forty",
		" fifty",
		" sixty",
		" seventy",
		" eighty",
		" ninety"
	);

	$triplets = array(
		"",
		" thousand",
		" million",
		" billion",
		" trillion",
		" quadrillion",
		" quintillion",
		" sextillion",
		" septillion",
		" octillion",
		" nonillion"
	);

	// chunk the number, ...rxyy
	$r = (int) ($num / 1000);
	$x = ($num / 100) % 10;
	$y = $num % 100;

	// init the output string
	$str = "";

	// do hundreds
	if ($x > 0) $str = $ones[$x] . " hundred";

	// do ones and tens
	if ($y < 20) $str .= $ones[$y];
	else $str .= $tens[(int) ($y / 10)] . $ones[$y % 10];

	// add triplet modifier only if there
	// is some output to be modified...
	if ($str != "") $str .= $triplets[$tri];

	// continue recursing?
	if ($r > 0) return _wds_hb_convert_tri($r, $tri+1).$str;
	else return $str;
}

function wds_get_trimmed_excerpt ($excerpt, $contents) {
	$string = $excerpt ? $excerpt : $contents;
	$string = trim(preg_replace('/\r|\n/', ' ', strip_shortcodes(htmlspecialchars(wp_strip_all_tags(strip_shortcodes($string)), ENT_QUOTES))));
	return (preg_match('/.{156,}/um', $string))
		? preg_replace('/(.{0,152}).*/um', '$1', $string) . '...'
		: $string
	;
}

function wds_get_term_meta ($term, $taxonomy, $meta) {
	$term = (is_object($term)) ? $term->term_id : get_term_by('slug', $term, $taxonomy);
	$tax_meta = get_option('wds_taxonomy_meta');

	return (isset($tax_meta[$taxonomy][$term][$meta])) ? $tax_meta[$taxonomy][$term][$meta] : false;
}


function wds_blog_template_settings ($and) {
	//$and .= " AND `option_name` != 'wds_sitemaps_options'"; // Removed plural
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
function user_can_see_seo_metabox () {
	$wds_options = WDS_Settings::get_options();
	$capability = (defined('WDS_SEO_METABOX_ROLE') && WDS_SEO_METABOX_ROLE)
		? WDS_SEO_METABOX_ROLE
		: (!empty($wds_options['seo_metabox_permission_level']) ? $wds_options['seo_metabox_permission_level'] : false)
	;
	$capability = apply_filters('wds-capabilities-seo_metabox', $capability);
	$able = false;

	if (is_array($capability)) {
		foreach ($capability as $cap) {
			$able = current_user_can($cap);
			if ($able) break;
		}
	} else {
		$able = current_user_can($capability);
	}
	return $able;
}

/**
 * Checks user persmission level against minumum requirement
 * for displaying Moz urlmetrics metabox.
 *
 * @return bool
 */
function user_can_see_urlmetrics_metabox () {
	$wds_options = WDS_Settings::get_options();
	$capability = (defined('WDS_URLMETRICS_METABOX_ROLE') && WDS_URLMETRICS_METABOX_ROLE)
		? WDS_URLMETRICS_METABOX_ROLE
		: (!empty($wds_options['urlmetrics_metabox_permission_level']) ? $wds_options['urlmetrics_metabox_permission_level'] : false)
	;
	$capability = apply_filters('wds-capabilities-urlmetrics_metabox', $capability);
	$able = false;

	if (is_array($capability)) {
		foreach ($capability as $cap) {
			$able = current_user_can($cap);
			if ($able) break;
		}
	} else {
		$able = current_user_can($capability);
	}
	return $able;
}

/**
 * Checks user persmission level against minumum requirement
 * for displaying the 301 redirection field within SEO metabox.
 *
 * @return bool
 */
function user_can_see_seo_metabox_301_redirect () {
	$wds_options = WDS_Settings::get_options();
	$capability = (defined('WDS_SEO_METABOX_301_ROLE') && WDS_SEO_METABOX_301_ROLE)
		? WDS_SEO_METABOX_301_ROLE
		: (!empty($wds_options['seo_metabox_301_permission_level']) ? $wds_options['seo_metabox_301_permission_level'] : false)
	;
	$capability = apply_filters('wds-capabilities-seo_metabox_301_redirect', $capability);
	$able = false;

	if (is_array($capability)) {
		foreach ($capability as $cap) {
			$able = current_user_can($cap);
			if ($able) break;
		}
	} else {
		$able = current_user_can($capability);
	}
	return $able;
}

/**
 * Attempt to hide metaboxes by default by adding them to "hidden" array.
 * Metaboxes are still added to "Screen Options".
 * If user chooses to show/hide them, respect her decision.
 *
 * DEPRECATED as of version 1.0.9
 */
function wds_process_default_hidden_meta_boxes ($arg) {
	$wds_options = WDS_Settings::get_options();
	$arg[] = 'wds-wds-meta-box';
	$arg[] = 'wds_seomoz_urlmetrics';
	return $arg;
}
//add_filter('default_hidden_meta_boxes', 'wds_process_default_hidden_meta_boxes');


/**
 * Hide ALL wds metaboxes.
 * Respect wishes for other metaboxes.
 * Still accessble from "Screen Options".
 */
function wds_hide_metaboxes ($arg) {
	// Hide WP defaults, if nothing else:
	if (empty($arg)) $arg = array('slugdiv', 'trackbacksdiv', 'postcustom', 'postexcerpt', 'commentstatusdiv', 'commentsdiv', 'authordiv', 'revisionsdiv');
	$arg[] = 'wds-wds-meta-box';
	$arg[] = 'wds_seomoz_urlmetrics';
	return $arg;
}
/**
 * Register metabox hiding for other boxes.
 */
function wds_register_metabox_hiding () {
	$post_types = get_post_types();
	foreach ($post_types as $type) add_filter('get_user_option_metaboxhidden_' . $type, 'wds_hide_metaboxes');

}
//add_action('admin_init', 'wds_register_metabox_hiding');

/**
 * Forces metaboxes to start collapsed.
 * It properly merges the WDS boxes with the rest of the users collapsed boxes.
 * For info on registering, see `register_metabox_collapsed_state`.
 */
function force_metabox_collapsed_state ($closed) {
	$closed = is_array($closed) ? $closed : array();
	return array_merge($closed, array(
		'wds-wds-meta-box', 'wds_seomoz_urlmetrics'
	));
}

/**
 * Registers WDS boxes state.
 * Collapsed state is tracked per post type.
 * This is why we have this separate hook to register state change processing.
 */
function register_metabox_collapsed_state () {
	global $post;
	if ($post && $post->post_type) {
		add_filter('get_user_option_closedpostboxes_' . $post->post_type, 'force_metabox_collapsed_state');
	}
}
add_filter('post_edit_form_tag', 'register_metabox_collapsed_state');


/**
 * Checks the page tab slug against permitted ones.
 * This applies only for multisite, non-sitewide setups.
 */
function wds_is_allowed_tab ($slug) {
	$blog_tabs = get_site_option('wds_blog_tabs');
	$blog_tabs = is_array($blog_tabs) ? $blog_tabs : array();
	$allowed = true;
	if (is_multisite() && !WDS_SITEWIDE) {
		$allowed = in_array($slug, $blog_tabs) ? true : false;
	}
	return $allowed;
}

/**
 * Checks if transient is stuck (has no expiry time) and
 * if so, removes it.
 */
function wds_kill_stuck_transient ($key) {
	global $_wp_using_ext_object_cache;
	if ($_wp_using_ext_object_cache) return true; // In object cache, nothing to do

	$key = "_transient_{$key}";
	$alloptions = wp_load_alloptions();
	// If option is in alloptions, it is autoloaded and thus has no timeout - kill it
	if (isset($alloptions[$key])) return delete_option($key);

	return true;
}

/**
 * Check for boolean define switches and their values.
 */
function wds_is_switch_active ($switch) {
	return defined($switch) ? constant($switch) : false;
}

/**
 * Check if we're on main BuddyPress site - BuddyPress root blog check.
 * @return bool Are we on the main BuddyPress site.
 */
function wds_is_main_bp_site () {
	if (is_multisite() && defined('BP_VERSION') && (defined('BP_ROOT_BLOG') && BP_ROOT_BLOG)) {
		global $blog_id;
		return BP_ROOT_BLOG == $blog_id;
	}
	return is_main_site();
}

/**
 * Converts an argument map to HTML attributes string.
 * @param array $args A hash of arguments
 * @return string Constructed attributes string
 */
function wds_autolinks_construct_attributes ($args=array()) {
	$ret = array();
	if (empty($args)) return '';
	foreach ($args as $key => $value) {
		if (empty($key) || empty($value)) continue; // Only accept properly formatted members.
		$ret[] = esc_html($key) . '="' . esc_attr($value) . '"';
	}
	return apply_filters('wds_autolinks_attributes', trim(join(' ', $ret)));
}

function wds_get_mp_global_term_name ($mp_term) {
	if (empty($mp_term)) return '';

	$key = 'mp_term_name-' . preg_replace('/[^-_a-z0-9]i/', '', $mp_term);
	$mp_term_name = wp_cache_get($key, 'wds');
	if (empty($mp_term_name)) {
		global $wpdb;
		$mp_term_name = $wpdb->get_var( $wpdb->prepare("SELECT name FROM {$wpdb->base_prefix}mp_terms WHERE slug = %s", $mp_term) ); // Yanked from MarketPress_MS, no accessor
		wp_cache_set($key, $mp_term_name, 'wds');
	}

	return $mp_term_name;
}

/**
 * Get a value from an array. If nothing is found for the provided keys, returns null.
 *
 * @param $array array The array to search (haystack).
 * @param $key array|string The key to use for the search.
 *
 * @return null|mixed The array value found or null if nothing found.
 */
function wds_get_array_value($array, $key)
{
	if (!is_array($key)) {
		$key = array($key);
	}

	if (!is_array($array)) {
		return NULL;
	}

	$value = $array;
	foreach ($key as $key_part) {
		$value = isset($value[ $key_part ]) ? $value[ $key_part ] : NULL;
	}

	return $value;
}

/**
 * Inserts a value in the given array.
 *
 * @param $value mixed The value to insert.
 * @param $array array The array in which the value is to be inserted. Passed by reference.
 * @param $keys array|string Key specifying the place where the new value is to be inserted.
 */
function wds_put_array_value($value, &$array, $keys)
{
	if (!is_array($keys)) {
		$keys = array($keys);
	}

	$pointer = &$array;
	foreach ($keys as $key) {
		if (!isset($pointer[ $key ]))
			$pointer[ $key ] = array();
		$pointer = &$pointer[ $key ];
	}
	$pointer = $value;
}

function wds_get_post_or_latest_revision($post_id)
{
	$data = stripslashes_deep($_POST);
	$is_auto_save = (bool)wds_get_array_value($data, 'autosave_update');
	if ($is_auto_save) {
		$post_revisions = wp_get_post_revisions($post_id);
		if (count($post_revisions)) {
			return array_shift($post_revisions);
		}
	}

	return get_post($post_id);
}