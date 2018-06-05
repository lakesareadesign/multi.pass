<?php
/**
 * CoursePress functions and definitions
 *
 * @package CoursePress
 */

/**
 * Custom template tags for this theme.
 */
require 'inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require 'inc/extras.php';

/**
 * Customizer additions.
 */
require 'inc/customizer.php';


add_action( 'after_setup_theme', 'coursepress_setup' );

if ( ! function_exists( 'coursepress_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function coursepress_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on CoursePress, use a find and replace
		 * to change 'coursepress' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'coursepress', get_template_directory() . '/languages' );

		// Let WP handl <title> tag.
		add_theme_support( 'title-tag' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'coursepress' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'coursepress' ),
				'secondary' => __( 'Footer Menu', 'coursepress' ),
			)
		);

		// Add custom logo support
		add_theme_support( 'custom-logo' );

		// Setup the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'coursepress_custom_background_args',
				array(
					'default-color' => 'f9f9f9',
					'default-image' => '',
				)
			)
		);

		add_theme_support( 'post-thumbnails' );
	}
endif;


if ( ! function_exists( 'author_description_excerpt' ) ) :

	function author_description_excerpt( $user_id = false, $length = 100 ) {
		$excerpt = get_the_author_meta( 'description', $user_id );
		$excerpt = strip_shortcodes( $excerpt );
		$excerpt = apply_filters( 'the_content', $excerpt );
		$excerpt = str_replace( ']]>', ']]&gt;', $excerpt );
		$excerpt = strip_tags( $excerpt );
		$excerpt_length = apply_filters( 'excerpt_length', $length );
		$excerpt_more = apply_filters( 'excerpt_more', ' ' . '[...]' );

		$words = preg_split(
			'/\s+/m',
			$excerpt,
			$excerpt_length + 1,
			PREG_SPLIT_NO_EMPTY
		);

		if ( count( $words ) > $excerpt_length ) {
			array_pop( $words );
			$excerpt = implode( ' ', $words );
			$excerpt = $excerpt . $excerpt_more;
		} else {
			$excerpt = implode( ' ', $words );
		}

		return $excerpt;
	}
endif;


/**
 * Colorize first word of the widget title.
 */
add_filter( 'widget_title', 'coursepress_colorize_title' );

if ( ! function_exists( 'coursepress_colorize_title' ) ) :

	function coursepress_colorize_title( $old_title ) {
		$parts = explode( ' ', $old_title, 2 );
		$first = '';
		$second = '';
		if ( isset( $parts[0] ) ) { $first = $parts[0]; }
		if ( isset( $parts[1] ) ) { $second = ' ' . $parts[1]; }

		$title_new = sprintf(
			'<span class="yellow">%s</span>%s',
			$first,
			$second
		);

		return $title_new;
	}
endif;

/**
 * Register widgetized area and update sidebar with default widgets.
 */
add_action( 'widgets_init', 'coursepress_widgets_init' );

if ( ! function_exists( 'coursepress_widgets_init' ) ) :

	function coursepress_widgets_init() {
		register_sidebar(
			array(
				'name' => __( 'Sidebar', 'coursepress' ),
				'id' => 'sidebar-1',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h1 class="widget-title">',
				'after_title' => '</h1>',
			)
		);

		register_sidebar(
			array(
				'name' => __( 'Footer', 'coursepress' ),
				'id' => 'sidebar-2',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h1 class="widget-title">',
				'after_title' => '</h1>',
			)
		);
	}
endif;


/**
 * Enqueue scripts and styles.
 */
add_action( 'wp_enqueue_scripts', 'coursepress_scripts' );

if ( ! function_exists( 'coursepress_scripts' ) ) :

	function coursepress_scripts() {
		/**
		 * setup version
		 */
		$version = '';
		if ( class_exists( 'CoursePress' ) ) {
			$version = CoursePress::$version;
		} else {
			$theme = wp_get_theme();
			$version = $theme->get( 'Version' );
		}

		wp_enqueue_style(
			'coursepress-style',
			get_stylesheet_uri(),
			array(),
			$version
		);

		wp_enqueue_style(
			'coursepress-responsive-navigation',
			get_template_directory_uri() . '/css/responsive-nav.css',
			array(),
			$version
		);

		wp_enqueue_script(
			'coursepress-navigation',
			get_template_directory_uri() . '/js/navigation.js',
			array(),
			$version,
			true
		);

		wp_enqueue_script(
			'coursepress-responsive-navigation',
			get_template_directory_uri() . '/js/responsive-nav.min.js',
			array(),
			$version,
			true
		);

		wp_enqueue_script(
			'coursepress-general',
			get_template_directory_uri() . '/js/script.js',
			array(),
			$version,
			true
		);

		wp_enqueue_script(
			'coursepress-skip-link-focus-fix',
			get_template_directory_uri() . '/js/skip-link-focus-fix.js',
			array(),
			$version,
			true
		);

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_register_style(
			'google_fonts_lato',
			'//fonts.googleapis.com/css?family=Lato:300,400'
		);
		wp_enqueue_style( 'google_fonts_lato' );

		wp_register_style(
			'google_fonts_dosis',
			'//fonts.googleapis.com/css?family=Dosis:300,400'
		);
		wp_enqueue_style( 'google_fonts_dosis' );
	}
endif;


add_action( 'wp_enqueue_scripts', 'load_all_jquery' );

if ( ! function_exists( 'load_all_jquery' ) ) :

	function load_all_jquery() {
		wp_enqueue_script( 'jquery' );
		$jquery_ui = array(
			'jquery-ui-core',
			'jquery-ui-widget',
			'jquery-ui-mouse',
			'jquery-ui-accordion',
			'jquery-ui-slider',
			'jquery-ui-tabs',
			'jquery-ui-sortable',
			'jquery-ui-draggable',
			'jquery-ui-droppable',
			'jquery-ui-selectable',
			'jquery-ui-position',
			'jquery-ui-datepicker',
			'jquery-ui-resizable',
			'jquery-ui-dialog',
			'jquery-ui-button',
		);
		foreach ( $jquery_ui as $script ) {
			wp_enqueue_script( $script );
		}
	}
endif;


add_filter( 'pre_get_posts', 'coursepress_filter_search' );

if ( ! function_exists( 'coursepress_filter_search' ) ) :

	function coursepress_filter_search( $query ) {
		if ( ! $query->is_search ) { return $query; }
		if ( is_admin() ) { return $query; }
		// Bail if it is a bbpress topic-reply query.
		if ( function_exists('bbp_get_topic_post_type') &&
			(in_array( bbp_get_topic_post_type(), (array)$query->get( 'post_type' ) )
			|| in_array( bbp_get_reply_post_type(), (array)$query->get( 'post_type' ) ) )
		) {
			return $query;
		}
		// On front-end we always search for post and course items!
		$current_types = $query->get('post_type');
		if ( !empty( $current_types ) ) {
			$current_types = (array) $current_types;
		}

		$added_types = array( 'post', 'course' );
		if ( empty( $current_types ) ) {
			$new_types = $added_types;
		} elseif ( in_array( 'post', $current_types ) ) {
			$new_types = array_unique( array_merge( $current_types, $added_types ) );
		}
		if ( isset( $new_types ) ) {
			$query->set( 'post_type', $new_types );
		}

		return $query;
	}
endif;


add_shortcode( 'contact_form', 'coursepress_contact_form' );

if ( ! function_exists( 'coursepress_contact_form' ) ) :

	function coursepress_contact_form() {
		ob_start();
		get_template_part( 'part-contact' );
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
	}
endif;


/**
 * Walker for mobile menu.
 * Used in header.php
 */
class Walker_Nav_Menu_Dropdown extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
	}

	public function end_lvl( &$output, $depth = 0, $args = array() ) {
	}

	public function start_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0 ) {
		// Here is where we create each option.
		$item_output = '';
		$item->title = str_repeat( '&#160;', $depth * 4 ) . $item->title;

		// Get the attributes.. Though we likely don't need them for this...
		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

		// Add the html
		$item_output .= '<li>';
		$item_output .= '<a href="' . $item->url . '">' . apply_filters( 'the_title_attribute', $item->title ) . '</a>';

		// Add this new item to the output string.
		$output .= $item_output;
	}

	public function end_el( &$output, $object, $depth = 0, $args = array() ) {
		// Close the item.
		$output .= '</li>';
	}
};


/**
 * Add thickbox to all images on Unit Elements.
 */
add_filter( 'element_content_filter', 'coursepress_filter_add_thickbox', 12, 1 );

if ( ! function_exists( 'coursepress_filter_add_thickbox' ) ) :

	function coursepress_filter_add_thickbox( $content ) {
		$rule = '#(<a\s[^>]*href)="([^"]+)".*<img#';
		$rule = str_replace( ' ', '', $rule );

		return preg_replace_callback(
			$rule,
			'coursepress_filter_add_thickbox_cb',
			$content
		);
	}
endif;

if ( ! function_exists( 'coursepress_filter_add_thickbox_cb' ) ) :

	function coursepress_filter_add_thickbox_cb( $match ) {
		$new_url = str_replace( '../wp-content', WP_CONTENT_URL, $match[0] );
		$rule = '#(//([^\s]*)\.(jpg|gif|png))#';
		$rule = str_replace( ' ', '', $rule );
		$output = preg_replace( $rule, '$1" class="thickbox', $new_url );
		return $output;
	}
endif;

/**
 * Add thickbox to all images on Unit Single pages.
 */
add_filter( 'the_content', 'coursepress_unit_content' );

if ( ! function_exists( 'coursepress_unit_content' ) ) :

	function coursepress_unit_content( $content ) {
		global $post;

		if ( is_object( $post ) && 'unit' == get_post_type( $post->ID ) ) {
			return coursepress_filter_add_thickbox( $content );
		} else {
			return $content;
		}
	}
endif;

/**
 * Numeric pagination.
 */
if ( ! function_exists( 'coursepress_numeric_posts_nav' ) ) {

	function coursepress_numeric_posts_nav( $navigation_id = '' ) {
		global $wp_query, $paged;

		if ( is_singular() ) {
			return;
		}

		// Stop execution if there's only 1 page.
		if ( $wp_query->max_num_pages <= 1 ) {
			return;
		}

		$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;

		$max = intval( $wp_query->max_num_pages );

		// Add current page to the array.
		if ( $paged >= 1 ) {
			$links[] = $paged;
		}

		// Add the pages around the current page to the array.
		if ( $paged >= 3 ) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}

		if ( ( $paged + 2 ) <= $max ) {
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}

		if ( $navigation_id ) {
			$id = 'id="' . $navigation_id . '"';
		} else {
			$id = '';
		}

		echo '<div class="navigation" ' . $id . '><ul>';

		// Previous Post Link.
		if ( get_previous_posts_link() ) {
			printf(
				'<li>%s</li>',
				get_previous_posts_link( '<span class="meta-nav">&larr;</span>' )
			);
		}

		// Link to first page, plus ellipses if necessary.
		if ( ! in_array( 1, $links ) ) {
			$class = '';
			if ( 1 == $paged ) {
				$class = ' class="active"';
			}

			printf(
				'<li%s><a href="%s">%s</a></li>',
				$class,
				esc_url( get_pagenum_link( 1 ) ),
				'1'
			);

			if ( ! in_array( 2, $links ) ) {
				echo '<li>&hellip;</li>';
			}
		}

		// Link to current page, plus 2 pages in either direction if necessary.
		sort( $links );
		foreach ( (array) $links as $link ) {
			$class = $paged == $link ? ' class="active"' : '';
			printf(
				'<li%s><a href="%s">%s</a></li>',
				$class,
				esc_url( get_pagenum_link( $link ) ),
				$link
			);
		}

		// Link to last page, plus ellipses if necessary.
		if ( ! in_array( $max, $links ) ) {
			if ( ! in_array( $max - 1, $links ) ) {
				echo '<li>&hellip;</li>';
			}

			$class = $paged == $max ? ' class="active"' : '';
			printf(
				'<li%s><a href="%s">%s</a></li>',
				$class,
				esc_url( get_pagenum_link( $max ) ),
				$max
			);
		}

		// Next Post Link.
		if ( get_next_posts_link() ) {
			printf(
				'<li>%s</li>',
				get_next_posts_link( '<span class="meta-nav">&rarr;</span>' )
			);
		}

		echo '</ul></div>';
	}
}

/**
 * Numeric pagination
 */
if ( ! function_exists( 'cp_numeric_posts_nav' ) ) {

	function cp_numeric_posts_nav( $navigation_id = '' ) {

		if ( is_singular() ) {
			return;
		}

		global $wp_query, $paged;
		/** Stop execution if there's only 1 page */
		if ( $wp_query->max_num_pages <= 1 ) {
			return;
		}

		$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;

		$max = intval( $wp_query->max_num_pages );

		/**    Add current page to the array */
		if ( $paged >= 1 ) {
			$links[] = $paged;
		}

		/**    Add the pages around the current page to the array */
		if ( $paged >= 3 ) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}

		if ( ( $paged + 2 ) <= $max ) {
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}

		if ( $navigation_id != '' ) {
			$id = 'id="' . $navigation_id . '"';
		} else {
			$id = '';
		}

		echo '<div class="navigation" ' . $id . '><ul>' . "\n";

		/**    Previous Post Link */
		if ( get_previous_posts_link() ) {
			printf( '<li>%s</li>' . "\n", get_previous_posts_link( '<span class="meta-nav">&larr;</span>' ) );
		}

		/**    Link to first page, plus ellipses if necessary */
		if ( ! in_array( 1, $links ) ) {
			$class = 1 == $paged ? ' class="active"' : '';

			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

			if ( ! in_array( 2, $links ) ) {
				echo '<li>…</li>';
			}
		}

		/**    Link to current page, plus 2 pages in either direction if necessary */
		sort( $links );
		foreach ( (array) $links as $link ) {
			$class = $paged == $link ? ' class="active"' : '';
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
		}

		/**    Link to last page, plus ellipses if necessary */
		if ( ! in_array( $max, $links ) ) {
			if ( ! in_array( $max - 1, $links ) ) {
				echo '<li>…</li>' . "\n";
			}

			$class = $paged == $max ? ' class="active"' : '';
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
		}

		/**    Next Post Link */
		if ( get_next_posts_link() ) {
			printf( '<li>%s</li>' . "\n", get_next_posts_link( '<span class="meta-nav">&rarr;</span>' ) );
		}

		echo '</ul></div>' . "\n";
	}
}