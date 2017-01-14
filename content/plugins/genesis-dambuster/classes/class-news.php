<?php
class Genesis_Dambuster_News {
    const SCRIPT_VAR = 'genesis_dambuster_news';
    const HANDLE = 'genesis-dambuster-news';
    const RESULTS = 'genesis-dambuster-news-feed';

	function __construct() {
      add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
      add_action( 'wp_ajax_'.self::SCRIPT_VAR, array($this, 'get_feeds_ajax') );
	}

   function enqueue_scripts() {
    	wp_enqueue_script(self::HANDLE, plugins_url('scripts/jquery.news.js', dirname(__FILE__)), array('jquery'), GENESIS_DAMBUSTER_VERSION, true);         
        wp_localize_script( self::HANDLE, self::SCRIPT_VAR,
             array( 
                 'ajaxurl' => admin_url( 'admin-ajax.php' ),
                 'ajaxnonce'   => wp_create_nonce( self::SCRIPT_VAR.'_nonce' ),
                 'ajaxaction'   => self::SCRIPT_VAR,
                 'ajaxresults'  => '.'.self::RESULTS
              ) 
        );      
   }

   function get_feeds_ajax() {
      check_ajax_referer( self::SCRIPT_VAR.'_nonce', 'security' );
      $url = isset($_POST['url']) ? $_POST['url'] : '';
      if (empty($url)) wp_send_json_error( array( 'error' => __( 'Feed URL not supplied.' ) ) );

      $instance = array('url' => $url, 'show_summary' => false, 'show_featured' => true);
      $feed = $this->get_rss_feed_instance($instance);
      if( isset( $feed ) )
         wp_send_json_success( $feed );
      else
         wp_send_json_error( array( 'error' => __( 'Could not retrieve feed '.$url ) ) );
   }

	function get_rss_feed_instance( $instance ) {

		$url = ! empty( $instance['url'] ) ? $instance['url'] : '';

		while ( stristr($url, 'http') != $url )
			$url = substr($url, 1);

		if ( empty($url) )
			return;

		if ( in_array( untrailingslashit( $url ), array( site_url(), home_url() ) ) )
			return;

		$rss = fetch_feed($url);

		if ( is_wp_error($rss) ) {
			if ( is_admin() || current_user_can('manage_options') ) 
				echo '<div>' . sprintf( __('<strong>RSS Error</strong>: %s'), $rss->get_error_message() ) . '</div>';
			return;
		}

		$default_args = array( 'show_featured' => 0, 'show_summary' => 0, 'show_author' => 0, 'show_date' => 0,  'items' => 0 );

		if (($parsed_url = parse_url($url))
 		&& ($query = isset($parsed_url['query']) ? $parsed_url['query'] : '')) {
 			 $instance = wp_parse_args($query, $default_args);
		}

		$args = wp_parse_args( $instance, $default_args );

		$items = (int) $args['items'];
		if ( $items < 1 || 20 < $items ) $items = 10;

		$show_featured  = (int) $args['show_featured'];
		$show_summary  = (int) $args['show_summary'];
		$show_author   = (int) $args['show_author'];
		$show_date     = (int) $args['show_date'];
	
		if ( !$rss->get_item_quantity() ) {
			return '<div>' . __( 'An error has occurred, which probably means the feed is down. Try again later.' ) . '</div>';
		}
        $results = '';
   
		foreach ( $rss->get_items( 0, $items ) as $item ) {
			$link = $item->get_link();
			while ( stristr( $link, 'http' ) != $link ) {
				$link = substr( $link, 1 );
			}
			$link = esc_url( strip_tags( $link ) );
			$title = esc_html( trim( strip_tags( $item->get_title() ) ) );
			$link_title = '';		
			$desc = @html_entity_decode( $item->get_description(), ENT_QUOTES, get_option( 'blog_charset' ) );
	
			if (substr($desc,0,5) == '<img ') { //use image in place of title if supplied
				$end_image = strpos($desc,'>');
				$link_title = sprintf(' title="%1$s"', $title);
				$title = substr($desc,0, $end_image+1);
				$desc = substr($desc, $end_image+1);
			} else {
				if ($show_featured)
					continue; //skip items with missing featured images
			} 
	
			$desc = esc_attr( wp_trim_words( $desc, 55, ' [&hellip;]' ) );

			$summary = '';
			if ( $show_summary ) {
				$summary = $desc;

				// Change existing [...] to [&hellip;].
				if ( '[...]' == substr( $summary, -5 ) ) {
					$summary = substr( $summary, 0, -5 ) . '[&hellip;]';
				}

				$summary = '<div class="rssSummary">' . esc_html( $summary ) . '</div>';
			}

			$date = '';
			if ( $show_date ) {
				$date = $item->get_date( 'U' );

				if ( $date ) {
					$date = ' <span class="rss-date">' . date_i18n( get_option( 'date_format' ), $date ) . '</span>';
				}
			}

			$author = '';
			if ( $show_author ) {
				$author = $item->get_author();
				if ( is_object($author) ) {
					$author = $author->get_name();
					$author = ' <cite>' . esc_html( strip_tags( $author ) ) . '</cite>';
				}
			}

			if ($link) $title = sprintf('<a target="_blank" class="rsswidget" href="%1$s"%2$s>%3$s</a>', $link, $link_title, $title);
			$results .= sprintf('<div class="%5$s-item"><div>%1$s</div>%2$s%3$s%4$s</div>', $title, $date, $summary, $author, self::RESULTS );
		}

		if ( ! is_wp_error($rss) )
			$rss->__destruct();
		unset($rss);
		return $results;		
	}

	function display_feeds($feeds = false) {
		if (is_array($feeds) && (count($feeds) > 0)) {
         printf ('<div class="%1$s"></div>',self::RESULTS);
			for($index=0; $index < count($feeds); $index++ ) {			
            wp_localize_script( self::HANDLE, self::SCRIPT_VAR.$index, array( 'feedurl' => $feeds[$index]) );     
		   }                                                               
		}
	}
}
