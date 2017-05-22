<?php 
/**
 * Slush Pro.
 *
 * This defines the helper functions for use in the Slush Pro Theme.
 *
 * @package Slush_Pro
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/slush/
 */

/**
 * Gallery Function.
 *
 * Function to display a slider using Bootstrap Carousel.
 *
 * @param integer $postid - Post ID.
 * @param string $imagesize - Image size name.
 * @param string $metabox_id - Metabox option ID.
 * @param boolean $lightbox - Boolean: true/false. If true, slide items will have link.
 * @return a markup for the gallery slider.
 */
function zp_gallery( $postid, $imagesize, $metabox_id, $lightbox = false ) {

	global $post;
	$output = '';
	// Gets all of the attachments for the post.
	$post_gallery_images = get_post_meta( $postid, $metabox_id, true );
	
	// Gets all image ID.
	$post_gallery_ids = explode(",", $post_gallery_images );
	
	$output = '';
	if ( count( $post_gallery_ids ) > 0 ) {
		$output .='<div class="carousel slide" id="' . $postid . '">';
		$output .= '<ol class="carousel-indicators">';
				
		$output .= '</ol>';
		$output .= '<div class="carousel-inner">';
		
		// Checker variable.
		$flag = 0;

		$counter = 0;
		$i = 0;
		while ( $i < count( $post_gallery_ids ) ) {
			if ( $post_gallery_ids[$i] ) {
				
				$image_url = wp_get_attachment_image_src( $post_gallery_ids[$i], $imagesize );
				$full_size  = wp_get_attachment_image_src( $post_gallery_ids[$i], 'full' );
				
				if ( $image_url[0] ) {
					$flag++;
					if ( $flag == 1 ) {
						$active = 'active';
					} else {
						$active = '';
					}

					$output .= '<div class="item ' . $active . ' gallery-image">';
					
					if ( $lightbox ) {
						$output .= '<a href="' . $full_size[0] . '"><img class="img-responsive" alt="' . get_the_title() . '" src="' . $image_url[0] . '" /></a>';
					} else {
						$output .= '<img class="img-responsive" alt="' . get_the_title() . '" src="' . $image_url[0] . '" />';
					}
					$output .= '</div>';
				}
			}
			$i++;
		}
			
		$output .= '</div>';
		$output .= '<a data-slide="prev" data-target="#' . $postid . '" class="carousel-control left"><i class="fa fa-angle-left"></i></a>';
		$output .= '<a data-slide="next" data-target="#' . $postid . '" class="carousel-control right"><i class="fa fa-angle-right"></i></a>';
		$output .= '</div>';

		return $output;
	}

}

/**
 * Blog Video Function.
 *
 * @param integer $postid - Post ID.
 * @param string $imagesize - Image size name.
 * @return a markup for the video.
 */
 function zp_video( $postid, $image_size ) {

	$height = get_post_meta( $postid, 'zp_video_prieview_image_height', true );
	$m4v = get_post_meta( $postid, 'zp_video_m4v_url', true );
	$ogv = get_post_meta( $postid, 'zp_video_ogv_url', true );
	$poster = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), $image_size );
	$output = '';

	// Sets width and height.
	$style = '';
	$width = $poster[1];
	$height = $poster[2];

	if ( ! empty( $poster[0] ) ) {
		$poster_size = 'size: { width: "' . $width . 'px", height: "' . $height . 'px" },';
	} else {
		$poster_size = 'size: { width: "100%", height: "33px" },';
	}

	$output .= '<script type="text/javascript">
		jQuery(document).ready(function($){
			if( $().jPlayer ) {
				$("#jquery-jplayer-video-' . $postid . '").jPlayer({
					ready: function () {
						$(this).jPlayer("setMedia", {
							m4v: "' . $m4v . '",
							ogv: "' . $ogv . '",
							poster: "' . $poster[0] . '"
						});
					},
					size: {
						cssClass: "jp-video-normal",
						width: "100%",
						height: "' . $height . 'px"
					},
					swfPath: "' . get_stylesheet_directory_uri() . '/js",
					solution: "flash, html",
					wmode: "window",
					cssSelectorAncestor: "#jp-video-container-' . $postid . '",
					supplied: "m4v, ogv"
				});

				$("#jquery-jplayer-video-' . $postid . '").bind($.jPlayer.event.playing, function(event) {
					$(this).add("#jp-video-interface-' . $postid . '").hover( function() {
						$("#jp-video-interface-' . $postid . '").stop().animate({ opacity: 1 }, 400);
					}, function() {
						$("#jp-video-interface-' . $postid . '").stop().animate({ opacity: 0 }, 400);
					});
				});
				
				$("#jquery-jplayer-video-' . $postid . '").bind($.jPlayer.event.pause, function(event) {
					$("#jquery-jplayer-video-' . $postid . '").add("#jp-video-interface-' . $postid . '").unbind("hover");
					$("#jp-video-interface-' . $postid . '").stop().animate({ opacity: 1 }, 400);
				});
			}

		});
	</script>';

	$output .= '<div id="jp-video-container-' . $postid . '" class="jp-video jp-video-normal" >';
		$output .= '<div class="jp-type-single">';
			$output .= '<div id="jquery-jplayer-video-' . $postid . '" class="jp-jplayer" data-orig-width="' . $width . '" data-orig-height="' . $height . '"></div>';
			$output .= '<div class="jp-gui">';
			$output .= '<div id="jp-video-interface-' . $postid . '" class="jp-interface">';
				$output .= '<ul class="jp-controls">';
					$output .= '<li><a href="#" class="jp-play" tabindex="1">play</a></li>';
					$output .= '<li><a href="#" class="jp-pause" tabindex="1">pause</a></li>';
					$output .= '<li><a href="#" class="jp-mute" tabindex="1">mute</a></li>';
					$output .= '<li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>';
			   $output .= ' </ul>';
				$output .= '<div class="jp-progress">';
					$output .= '<div class="jp-seek-bar">';
						$output .= '<div class="jp-play-bar"></div>';
				   $output .= '</div>';
				$output .= '</div>';
				$output .= '<div class="jp-volume-bar">';
					$output .= '<div class="jp-volume-bar-value"></div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';

	return $output;

}

/**
 * Blog Audio Fucntion.
 *
 * @param integer $postid - Post ID.
 * @param string $image_size - Image size name.
 * @return a markup for audio post format.
 */
 function zp_audio( $postid, $image_size ) {

	$mp3 = get_post_meta( $postid, 'zp_audio_mp3_url', true );
	$ogg = get_post_meta( $postid, 'zp_audio_ogg_url', true );
	$poster = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), $image_size );
	$output = '';

	// Sets width and height.
	$style = '';
	$width = $poster[1];
	$height = $poster[2];

	if ( ! empty( $poster[0] ) ) {
		$poster_size = 'size: { width: "' . $width . 'px", height: "' . $height . 'px" },';
	} else {
		$poster_size = 'size: { width: "100%", height: "33px" },';
	}

	$output .= '<script type="text/javascript">
			jQuery(document).ready(function($){

				if( $().jPlayer ) {
					$("#jquery-jplayer-audio-' . $postid . '").jPlayer({
						ready: function () {
							$(this).jPlayer("setMedia", {
								poster: "' . $poster[0] . '",
								mp3: "' . $mp3 . '",
								oga: "' . $ogg . '",
								end: ""
							});
						},
						' . $poster_size . '
						swfPath: "' . get_stylesheet_directory_uri() . '/js",
						solution: "flash, html",
						wmode: "window",
						cssSelectorAncestor: "#jp-audio-interface-' . $postid . '",
						supplied: "mp3, oga"
					});

				}
			});
		</script>';

		$output .= '<div id="jp-container-' . $postid . '" class="jp-audio" >';
			$output .= '<div class="jp-type-single">';
				$output .= '<div id="jquery-jplayer-audio-' . $postid . '" class="jp-jplayer" data-orig-width="' . $width . '" data-orig-height="' . $height . '"></div>';
				$output .= '<div id="jp-audio-interface-' . $postid . '" class="jp-interface">';
					$output .= '<ul class="jp-controls">';
						$output .= '<li><a href="#" class="jp-play" tabindex="1" title="play">play</a></li>';
						$output .= '<li><a href="#" class="jp-pause" tabindex="1" title="pause">pause</a></li>';
						$output .= '<li><a href="#" class="jp-mute" tabindex="1" title="mute">mute</a></li>';
						$output .= '<li><a href="#" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>';
					$output .= '</ul>';
				   $output .= ' <div class="jp-progress">';
						$output .= '<div class="jp-seek-bar">';
							$output .= '<div class="jp-play-bar"></div>';
						$output .= '</div>';
				   $output .= ' </div>';
					$output .= '<div class="jp-volume-bar">';
						$output .= '<div class="jp-volume-bar-value"></div>';
				   $output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>'; 

	return $output;

}
	
/**
 * Blog Quote Function.
 *
 * @return a markup for quote post format.
 */
 function zp_quote() {

	$content = get_the_content();
	$title = get_the_title();
	$permalink = get_permalink();
	$output = '';
	$output .= '<div class="caption">';
	$output .= sprintf( '<div %s>', genesis_attr( 'entry-content' ) );
	$output .= '<h2>' . $content . '</h2>';
	$output .= '<span class="blog_meta"></span><p class="quote_author">' . $title . '<a href="' . $permalink . '" title="Permanent Link to ' . $title . '" ></a></p>';
	$output .= '</div>';
	$output .= '</div>';
	return $output;

}
 
/**
 * Blog Link Function.
 *
 * @return a markup for link post format.
 */
 function zp_link() {
	 
	 global $post;
	 $title = get_the_title();
	 $permalink = get_permalink();
	 $link = get_post_meta( $post->ID, 'zp_link_format', true );
	 $output = '';
	 $output .= sprintf( '<div %s>', genesis_attr( 'entry-content' ) );
	 $output .= '<div class="caption">';
	 $output .= '<h2><a href="' . $link . '" title="' . $title . '" target="_blank">' . $title . '</a></h2>';
	 $output .= '<span class="blog_meta"></span><p class="link_source">' . get_the_content() . '</p>';
	 $output .= '</div>';
	 $output .= '</div>';

	return $output;

}

/**
 * Matches the input video link inserted.
 *
 * @param string $link - Full video URL.
 * @return a video URL needed in video post format.
 */
 function zp_return_desired_link( $link ) {

	 $src = '';

	 if ( preg_match( '/youtube/', $link ) ) {
		 if ( preg_match_all('#(http://www.youtube.com)?/(v/([-|~_0-9A-Za-z]+)|watch\?v\=([-|~_0-9A-Za-z]+)&?.*?)#i', $link, $matches ) ) {
			 $src = '//www.youtube.com/embed/' . $matches[4][0] . '?autoplay=1';
		}
	} elseif ( preg_match( '/vimeo/', $link ) ) {
		if ( preg_match('/^(https|http):\/\/(www\.)?vimeo\.com\/(clip\:)?(\d+).*$/', $link, $matches ) ) {
			$src = '//player.vimeo.com/video/' . $matches[4] . '?autoplay=1'; }
	}
	return $src;

}

/**
 * Gets the terms where the portfolio items belong and use as a class.
 * Terms was used as a selector on the isotope filter.
 * 
 * @param integer $id - ID of the post.
 * @param string $sep - term separator.
 * @returns string - list of terms separated by space.
*/
function zp_portfolio_items_term( $id, $sep ) {

	$output = '';

	$terms = wp_get_post_terms( $id, 'portfolio_category' );
	$term_string = $term_link = '';
		foreach ( $terms as $term ) {
			if ( $sep == '' ) {
				$term_string .= ( $term->slug ) . ' ';
			} else {
				$term_link .= '<a href="' . get_term_link( $term->term_id, 'portfolio_category' ) . '">' . $term->name . '</a>' . $sep . ' ';   
			}
		}

	// Separates terms with space.
	if ( $sep == '' ) {
		$term_string = substr( $term_string, 0, strlen( $term_string ) - 1 );
		$string = str_replace( ",", " ", $term_string );
		$output = $string . " ";
	} else {
		$term_string = substr( $term_link, 0, strlen( $term_link ) - 2 );
		$output = $term_string;
	}
	return $output; 

}

/**
 * Gets the category of the posts.
 * Category was used as a selector on the isotope fitler.
 * 
 * @param integer $id - ID of the post.
 * @param string $sep - term separator.
 * @returns string - list of terms separated by space.
*/
function zp_post_items_term( $id, $sep ) {

	$output = '';
	
	$terms = wp_get_post_terms( $id, 'category' );
	$term_string = '';
		foreach ( $terms as $term ) {
			$term_string .= ( $term->slug ) . $sep . ' ';
		}
	// Separates terms with space.
	if ( $sep == '' ) {
		$term_string = substr( $term_string, 0, strlen( $term_string ) - 1 );
		$string = str_replace( ",", " ", $term_string );
		$output = $string . " ";
	} else {
		$term_string = substr( $term_string, 0, strlen( $term_string ) - 2 );
		$output = $term_string;
	}
	return $output;
}

/**
 * Returns number of columns for Portfolio and Masonry Blog.
 *
 * @param integer $columns - Number of defined columns.
 * @return a string to define columns.
 */
function zp_columns( $columns ) {
	 
	if ( $columns == 2 ) {
		 $col = 'col2';
	} elseif ( $columns == 3 ) {
		$col = 'col3';
	} elseif ( $columns == 4 ) {
		$col = 'col4';
	} else {
		$col = 'col3';
	}
	return $col;

}

/**
 * Filters function for Portfolio and Masonry blog.
 *
 * @param string $filter - True/False.
 * @param string $category - Pre selected category.
 * @param string $taxonomy - Taxonomy.
 * @returns HTML markup for the taxonomy filter.
 */
function zp_filter_function( $filter, $category, $taxonomy ) {

	$output = '';

	// If $filter.
	if ( $filter == 'true' ) {
		$filter = 'style="display: block;"';
	} else {
		$filter = 'style="display: none;"';
	}

	// Checks if it has categoryed category.
	if ( $category != '' ) {
		$all = '';
		$selected = 'active';
	} else {
		$all = 'active';
		$selected = '';
	}

	$output .= '<div class="zp_masonry_filter" ' . $filter . '>';
	$output .= '<ul data-option-key="filter" class="option-set" > <li><a class="' . $all . '" href="#" data-option-value="*" >' . __( 'All', 'slush-pro' ) . '</a></li>';

	// Gets all portfolio catgories.
	$categories = get_categories( array( 'taxonomy' => $taxonomy ) );
	foreach ( $categories as $category ):
		if (  $category == $category->slug ) {
			$output .= '<li ><a class="' . $selected . '" href="#" data-option-value=".' . $category->slug . '" >' . $category->name . '</a></li>';
		} else {
			$output .= '<li ><a class="" href="#"  data-option-value=".' . $category->slug . '" >' . $category->name . '</a></li>';
		}
	endforeach;

	$output .= '</ul></div>';

	return $output;

}

/**
 * Portfolio Layout.
 *
 * @param integer $items - Number of items to display.
 * @param integer $columns  - Number of columns to display.
 * @param boolean $filter - check filter if included or not.
 * @param string $category - Portfolio category.
 * @param boolean $load_more - Set to true to enable loadmore feature.
 * @return an HTML layout of portfolio.
 */
function zp_portfolio_output( $items, $columns, $filter, $category = '', $load_more = true ) {

	global $post;
	
	// Enqueue Scripts.
	if ( $load_more ) {
		$category = ( $category != ''  )? $category : '';
		wp_enqueue_script( 'zp_imageloaded' );
		wp_enqueue_script( 'zp_post_load_more' );
		wp_localize_script( 'zp_post_load_more', 'zp_load_more', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'columns' => $columns, 'post_type' => 'portfolio', 'category' => $category, 'posts_per_page' => $items, 'button_label' => __( 'Load More Posts', 'slush-pro' ), 'loading_label' => __( 'Loading...', 'slush-pro' ), 'end_post' => __( 'End of Posts', 'slush-pro' ) ) );
	}
	
	wp_enqueue_script('zp_post_like' );
	wp_localize_script( 'zp_post_like', 'zp_post_like', 
		array(
			'ajax_url' => admin_url('admin-ajax.php')
		)
	);
	
	// Initializes $output variable.
	$output = '';
	
	// Checks if $items and set default 6 when empty.
	$items = ( '' == $items )? 6 : $items;
	
	// Checks if $column and set default 3 when empty.
	$columns = ( '' == $columns )? 3 : $columns;
	
	// Sets columns.
	$portfolio_col = zp_columns( $columns );
	
	// Filters functions.
	$output .= zp_filter_function( $filter, $category, 'portfolio_category' );

	$output .= '<div id="zp_masonry_container">';

	// Portfolio query arguments.
	if ( $category != '' ) {
		$args = array( 
			'portfolio_category' => $category,
			'post_type'          => 'portfolio',
			'posts_per_page'     => $items,
		);
	} else {
		$args = array(
			'post_type'      => 'portfolio',
			'posts_per_page' => $items,
		);
	}
	
	$portfolio = new WP_Query( $args );
	
	// Renders portfolio loop.
	$output .= zp_portfolio_loop( $portfolio, $portfolio_col );
	
	// Loads More Button.
	if ( $load_more ) {
		$output .= '<div class="zp_loader_container"><a class="load_more" data-nonce="' . wp_create_nonce( 'zp_load_posts' ) . '" href="javascript:;">' . __( 'Load More Posts', 'slush-pro' ) . '</a></div>';
	}
	
	return $output;

}

/**
 * Displays Related Portfolio.
 * 
 * @param integer $items - Number of items to display.
 * @param integer $columns  - Number of columns to display.
 * @return an HTML layout of portfolio.
 */
 function zp_related_portfolio( $items, $columns ) {

	global $post, $wp_query;

	// Enqueues Scripts.
	wp_enqueue_script('zp_post_like' );
	wp_localize_script( 'zp_post_like', 'zp_post_like', 
		array(
			'ajax_url' => admin_url('admin-ajax.php')
		)
	);

	// Initializes $ouput variable.
	$output = $term_ids = '';

	// Checks if $items and set default 6 when empty.
	$items = ( '' == $items )? 6 : $items;

	// Checks if $column and set default 3 when empty.
	$columns  = ( '' == $columns )? 3 : $columns;

	// Sets columns.
	$portfolio_col = zp_columns( $columns );

	$output .= '<div id="zp_masonry_container">';

	// Portfolio query arguments.
	$terms = get_the_terms( $post->ID, 'portfolio_category' );
	if ( $terms ) {
		$term_ids = array_values( wp_list_pluck( $terms,'term_id' ) );
	}
	$args = array(
		'post_type'      => 'portfolio',
		'tax_query'      => array(
			'taxonomy' => 'portfolio_category',
			'field'    => 'id',
			'terms'    => $term_ids,
			'operator' => 'IN',
		),
		'orderby'        => 'rand',
		'post__not_in'   => array( $post->ID ),
		'posts_per_page' => $items,
	);

	$portfolio = new WP_Query( $args );

	// Renders portfolio loop.
	$output .= zp_portfolio_loop( $portfolio, $portfolio_col, true );

	return $output;

}

/**
 * Portfolio Loop.
 *
 * @param object $portfolio_object - Contains the portfolio item query.
 * @param string $portfolio_col - Portfolio column class.
 * @param boolean $related - Set true if it is related portfolio ( Related portfolio have different image size ).
 * @returns an HTML markup of portfolio items.
 */
function zp_portfolio_loop( $portfolio_object, $portfolio_col, $related = false ) {

	global $post;

	$output = '';

	if ( $portfolio_object->have_posts() ):
		while ( $portfolio_object->have_posts() ) : $portfolio_object->the_post();
		
			// Gets full image size ( for lightbox ).
			$image_url = wp_get_attachment_url(  get_post_thumbnail_id(  $post->ID ) );
			
			// Gets image display size.
			if ( $related ) {
				$image_size = 'related_' . $portfolio_col;
			} else {
				$image_size = $portfolio_col;
			}
			
			$image = get_the_post_thumbnail( $post->ID, $image_size, array( 'class' => 'img-responsive', 'alt' => get_the_title(), 'title' => get_the_title() ) );
					
			// Checks portfolio link option ( lightbox, external or single page ).
			$link_type = get_post_meta( $post->ID, 'portfolio_link', true );
			
			// Adds like span.
			$like_counter = ( get_post_meta( $post->ID, 'zp_like', true ) > 0 )? get_post_meta( $post->ID, 'zp_like', true ): 0;
			$like = '<span class="zp_like_holder ' . $post->ID . '"><i class="fa fa-heart ' . $post->ID . '"></i><em class="like_counter">(' . $like_counter . ')</em></span>';
			
			switch( $link_type ) {
				case 'lightbox':
					// Checks if portfolio items has a video link.
					$video_link = get_post_meta( $post->ID, 'video_link', true );
					$lightbox_images = get_post_meta( $post->ID, 'lightbox_images', true );
					if ( $video_link ) {
						// $hover_icon = '<span class="hover_icon gallery-video"><h4><a href="' . $video_link . '" data-rel="prettyPhoto" title="' . get_the_title() . '">' . get_the_title() . '</a></h4></span>';

						$hover_icon = '<span class="hover_icon gallery-video"><span class="portfolio_detail_cat">' . zp_portfolio_items_term( $post->ID, ',' ) . '</span><h4><a href="' . $video_link . '" data-rel="prettyPhoto" title="' . get_the_title() . '">' . get_the_title() . '</a></h4><span class="portfolio_item_link"><a href="' . $video_link . '" data-rel="prettyPhoto" title="' . get_the_title() . '"><i class="fa fa-youtube-play"></i></a></span></span>';

						$output .= '<div class="zp_masonry_item  portfolio-item  gallery-video ' . $portfolio_col . ' ' . zp_portfolio_items_term( $post->ID, '' ) . '">';
						$output .= '<span class="zp_masonry_media">' . $hover_icon . $image . '</span>';
						$output .= '</div>';
					} elseif ( $lightbox_images != '' ) {
						// Gallery on the lightbox.
						$lightbox_gallery = '';
						$lightbox_gallery_ids = array_filter( explode( ",", $lightbox_images ) ); 
						$i = 0;
						while ( $i < count( $lightbox_gallery_ids ) ) {
							if ( isset( $lightbox_gallery_ids[$i] ) ) {
								$image_full = wp_get_attachment_image_src( $lightbox_gallery_ids[$i], 'full' );
								$image_tag = wp_get_attachment_image( $lightbox_gallery_ids[$i], 'thumbnail' );
								$image_meta = zp_get_attachment_meta( $lightbox_gallery_ids[$i] );
								$lightbox_gallery .= '<a style="display: none; " href="' . $image_full[0] . '" title="' . $image_meta['title'] . '">' . $image_tag . '</a>';
							}
						$i++;
						}
						$script = '<script type="text/javascript">
							jQuery(document).ready(function() {
								jQuery(".gallery_' . $post->ID . '").magnificPopup({
									delegate: "a",
									type: "image",
									tLoading: "Loading image...",
									mainClass: "mfp-img-mobile",
									gallery: {
										enabled: true,
										navigateByImgClick: true,
										preload: [0,1]
									},
									callbacks: {
										buildControls: function() {
											this.contentContainer.append(this.arrowLeft.add(this.arrowRight));
									}
									
								  }
								});
							});
						</script>';

						//$hover_icon = '<div class="hover_icon gallery-lightbox gallery_' . $post->ID . '"><h4><a href="' . $image_url . '" data-rel="prettyPhoto" title="' . get_the_title() . '">' . get_the_title() . '</a></h4>' . $lightbox_gallery . '</div>';

						$hover_icon = '<div class="hover_icon"><span class="portfolio_detail_cat">' . zp_portfolio_items_term( $post->ID, ',' ) . '</span><h4>' . get_the_title() . '</h4><span class="portfolio_item_link gallery_' . $post->ID . '"><a href="' . $image_url . '"><i class="fa fa-search"></i>' . $lightbox_gallery . '</a></span></div>';
						$output .= '<div class="zp_masonry_item  portfolio-item  ' . $portfolio_col . ' ' . zp_portfolio_items_term( $post->ID, '' ) . '">';
						$output .= $script;
						$output .= '<span class="zp_masonry_media">' . $hover_icon . $image . '</span>';
						$output .= '</div>';
					} else {
					// If there's no video and no gallery images then use the image
						$hover_icon = '<span class="hover_icon"><span class="portfolio_detail_cat">' . zp_portfolio_items_term( $post->ID, ',' ) . '</span><h4><a href="' . $image_url . '" data-rel="prettyPhoto" title="' . get_the_title() . '">' . get_the_title() . '</a></h4><span class="portfolio_item_link"><a href="' . $image_url . '" data-rel="prettyPhoto" title="' . get_the_title() . '"><i class="fa fa-long-arrow-right"></i></a></span></span>';
						$output .= '<div class="zp_masonry_item  portfolio-item ' . $portfolio_col . ' ' . zp_portfolio_items_term( $post->ID, '' ) . '">';
						$output .= '<span class="zp_masonry_media gallery-popup">' . $hover_icon . $image . '</span>';
						$output .= '</div>';
					}
					break;
				case 'external_link':
					$external_link = get_post_meta( $post->ID, 'zp_external_link', true );
					$hover_icon = '<span class="hover_icon"><span class="portfolio_detail_cat">' . zp_portfolio_items_term( $post->ID, ',' ) . '</span><h4><a href="' . $external_link . '" target="_blank">' . get_the_title() . '</a></h4><span class="portfolio_item_link"><a href="' . $external_link . '" target="_blank"><i class="fa fa-external-link"></i></a></span></span>';

					$output .= '<div class="zp_masonry_item  portfolio-item  ' . $portfolio_col . ' ' . zp_portfolio_items_term( $post->ID, '' ) . '">';
					$output .= '<span class="zp_masonry_media">' . $hover_icon . $image . '</span>';
					$output .= '</div>';
					break;
				default:
					$hover_icon = '<span class="hover_icon"><span class="portfolio_detail_cat">' . zp_portfolio_items_term( $post->ID, ',' ) . '</span><h4><a href="' . get_permalink() . '" >' . get_the_title() . '</a></h4><span class="portfolio_item_link"><a href="' . get_permalink() . '"><i class="fa fa-long-arrow-right"></i></a></span></span>';
					$output .= '<div class="zp_masonry_item portfolio-item  ' . $portfolio_col . ' ' . zp_portfolio_items_term( $post->ID, '' ) . '">';
					$output .= '<span class="zp_masonry_media">' . $hover_icon . $image . '</span>';
					$output .= '</div>';
					break;
			}
		endwhile;
	endif;
	$output .= '</div>';
	wp_reset_postdata();

	return $output;

 }

/**
 * Home Blog Layout.
 *
 * @param integer $items - Number of items to display.
 * @param integer $columns  - Number of columns to display.
 * @param boolean $filter - check filter if included or not.
 * @param string $category - Post Category.
 * @param boolean $load_more - Set to true to enable loadmore feature.
 * @return an HTML layout of masonry blog.
 */ 
 function zp_homeblog_output( $items, $columns, $filter, $category = '', $load_more = true ) {

	global $post;
	
	// Enqueues script.
	if ( $load_more ) {
		$category = ( $category != ''  )? $category : '';
		wp_enqueue_script('zp_imageloaded' );
		wp_enqueue_script( 'zp_post_load_more' );
		wp_localize_script( 'zp_post_load_more', 'zp_load_more', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'columns' => $columns, 'post_type' => 'post', 'category' => $category, 'posts_per_page' => $items, 'button_label'=> __( 'Load More Posts    ', 'slush-pro' ), 'loading_label' => __( 'Loading...', 'slush-pro' ), 'end_post' => __( 'End of Posts', 'slush-pro' ) ) );
	}
	
	wp_enqueue_script('zp_post_like' );
	wp_localize_script( 'zp_post_like', 'zp_post_like', 
		array(
			'ajax_url' => admin_url('admin-ajax.php')
		)
	);
	
	// Initializes $ouput variable.
	$output = '';
	
	// Checks if $items and set default 6 when empty.
	$items = ( '' == $items )? 6 : $items;
	
	// Checks if $column and set default 3 when empty.
	$columns  = ( '' == $columns )? 3 : $columns;

	// Sets columns.
	$blog_col = zp_columns( $columns );
		 
	// Filters functions.
	$filter = ( $filter == 'true' )? true : false;   
	echo zp_filter_function( $filter, $category, 'category' );
	
	$output .= '<div id="zp_masonry_container">';
	// Portfolio query arguments.
	if ( $category != '' ) {
		$args = array(
			'post_type'      => 'post',
			'posts_per_page' => $items,
			'category_name'  => $category,
		);
	} else {
		$args = array(
			'post_type'      => 'post',
			'posts_per_page' => $items,
		);
	}
	
	$zp_post_query = new WP_Query( $args );
	
	// Renders masonry blog loop.
	$output .= zp_masonry_blog_loop( $zp_post_query, $blog_col );

	// Loads More Button.
	if ( $load_more ) {
		$output .= '<div class="zp_loader_container"><a class="load_more" data-nonce="' . wp_create_nonce( 'zp_load_posts' ) . '" href="javascript:;">' . __( 'Load More Posts', 'slush-pro' ) . '</a></div>';
	}

	return $output;

}

/**
 * Masonry Blog loop.
 *
 * @param Object $zp_post_query - Contains the post query.
 * @param string $blog_col - Image size/Columns class.
 */
function zp_masonry_blog_loop( $zp_post_query, $blog_col ) {

	global $post;
	
	$output = ''; 
	 
	if ( $zp_post_query->have_posts() ):
		while ( $zp_post_query->have_posts() ) : $zp_post_query->the_post();

			// Gets full image size ( for lightbox ).
			$image_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

			// Gets image display size.
			$image = get_the_post_thumbnail( $post->ID, $blog_col, array('class' => 'img-responsive', 'alt' => "", 'title' => "" ) );

			// Checks portfolio link option ( lightbox, external or single page ).
			$format = get_post_format( $post->ID );
			
			// Gets limit content.
			if( has_excerpt( $post->ID ) ) { 
				$content = get_the_excerpt(); 
			} else { 
				//$content = strip_tags( strip_shortcodes( get_the_content() ), '<script>,<style>' ); 
				//$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) ); 
				//$content = genesis_truncate_phrase( $content, 150 ) . '...'; 
				$content =  get_the_excerpt();
			}
						 
			// Custom read more.
			//$read_more = '<a class="more-link" href="' . get_permalink() . '">' . __( 'Read More', 'slush-pro' ) . '&hellip;</a>';   
			
			// Gets post time.
			$masonry_date = get_the_date( 'F j, Y' );
			
			// Adds like span.
			$like_counter = ( get_post_meta( $post->ID, 'zp_like', true ) > 0 )? get_post_meta( $post->ID, 'zp_like', true ): 0;
			$like = '<span class="zp_like_holder ' . $post->ID . '"><i class="fa fa-heart ' . $post->ID . '"></i><em class="like_counter">(' . $like_counter . ')</em></span>';
			
			switch( $format ) {
				case 'audio':
					$audio_embed = get_post_meta( $post->ID, 'zp_embed_audio', true );
					if ( $audio_embed ) {
						$audio_post = stripslashes(htmlspecialchars_decode( $audio_embed ) );
					} else {
						$audio_post = zp_audio( $post->ID, $blog_col );
					}
					$output .= '<div class="zp_masonry_item blog-item ' . $blog_col . ' ' . zp_post_items_term( $post->ID, '' ) . '">';
					$output .= '<span class="zp_masonry_media zp_masonry_audio">' . $audio_post . '</span><span class="zp_masonry_detail"><span class="zp_masonry_title"><h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4></span><span class="zp_masonry_info">' . $masonry_date . $like . '</span><span class="zp_masonry_content">' . $content . '</span></span>';
					$output .= '</div>';
					break;
				case 'gallery':
					$output .= '<div class="zp_masonry_item blog-item  ' . $blog_col . ' ' . zp_post_items_term( $post->ID, '' ) . '">';
					$output .= '<span class="zp_masonry_media zp_masonry_gallery">' . zp_gallery( $post->ID, $blog_col, 'zp_post_gallery' ) . '</span><span class="zp_masonry_detail"><span class="zp_masonry_title"><h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4></span><span class="zp_masonry_info">' . $masonry_date . $like . '</span><span class="zp_masonry_content">' . $content . '</span></span>';
					$output .= '</div>';
					break;
				case 'image':
					$output .= '<div class="zp_masonry_item blog-item  ' . $blog_col . ' ' . zp_post_items_term( $post->ID, '' ) . '">';
					$output .= '<span class="zp_masonry_media zp_masonry_image">' . $image . '</span><span class="zp_masonry_detail"><span class="zp_masonry_title"><h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4></span><span class="zp_masonry_info">' . $masonry_date . $like . '</span><span class="zp_masonry_content">' . $content . '</span></span>';
					$output .= '</div>';
					break;
				case 'link':
					$link = get_post_meta( $post->ID, 'zp_link_format', true );
					$output .= '<div class="zp_masonry_item blog-item  ' . $blog_col . ' ' . zp_post_items_term( $post->ID, '' ) . '">';
					$output .= '<span class="zp_masonry_media zp_masonry_image"><a href="' . $link . '" target="_blank">' . $image . '</a></span><span class="zp_masonry_detail zp_masonry_link"><span class="zp_masonry_link_title"><h2><a href="' . $link . '" title="' . get_the_title() . '" target="_blank">' . get_the_title() . '</a></h2><span class="zp_masonry_info">' . $masonry_date . $like . '</span></span><span class="zp_masonry_link_desc">' . apply_filters( 'content', get_the_content() ) . '</span>';
					$output .= '</div>';
					break;
				case 'quote':
					$output .= '<div class="zp_masonry_item blog-item  ' . $blog_col . ' ' . zp_post_items_term( $post->ID, '' ) . '">';
					$output .= '<span class="zp_masonry_media zp_masonry_image">' . $image . '</span><span class="zp_masonry_detail zp_masonry_quote"><span class="zp_masonry_quote_title"><h2>' . get_the_content() . '</h2></span><span class="zp_masonry_quote_desc">' . get_the_title() . $like . '</span></span>';
					$output .= '</div>';
					break;
				case 'video':
					$embed = get_post_meta( $post->ID, 'zp_video_format_embed', true );
					if( ! empty( $embed ) ) {
						$video_post = '<script type="text/javascript">jQuery(document).ready(function(){ jQuery(".zp_masonry_video").fitVids(); }); </script>';
						$video_post .=  stripslashes( htmlspecialchars_decode( $embed ) );
					} else {
					   $video_post = zp_video( $post->ID, $blog_col );
					}
					$output .= '<div class="zp_masonry_item  blog-item  ' . $blog_col . ' ' . zp_post_items_term( $post->ID, '' ) . '">';
					$output .= '<span class="zp_masonry_media zp_masonry_video">' . $video_post . '</span><span class="zp_masonry_detail"><span class="zp_masonry_title"><h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4></span><span class="zp_masonry_info">' . $masonry_date . $like . '</span><span class="zp_masonry_content">' . $content . '</span></span>';
					$output .= '</div>';
					break;
				default:
					// Standard post format.
					$output .= '<div class="zp_masonry_item  blog-item  ' . $blog_col . ' ' . zp_post_items_term( $post->ID, '' ) . '">';
					$output .= '<span class="zp_masonry_media zp_masonry_standard">' . $image . '</span><span class="zp_masonry_detail"><span class="zp_masonry_title"><h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4></span><span class="zp_masonry_info">' . $masonry_date . $like . '</span><span class="zp_masonry_content">' . $content . '</span></span>';
					$output .= '</div>';
					break;
			}
		endwhile;
	endif;
	$output .= '</div>';
	wp_reset_postdata();

	return $output;

}

/**
 * Add Like functionality on blog items
 * using AJAX.
 */
 
add_action('wp_ajax_zp_insert_likes', 'zp_insert_likes');
add_action('wp_ajax_nopriv_zp_insert_likes', 'zp_insert_likes');

function zp_insert_likes() {

	$post_id = $_POST["post_id"];
	zp_add_like( $post_id );
	echo get_post_meta( $post_id, 'zp_like', true );
	die();

}

function zp_add_like( $post_id ) {

	$likes = get_post_meta( $post_id, 'zp_like', true );
	$likes = $likes + 1;
	update_post_meta( $post_id, 'zp_like', $likes );

}

add_action('publish_post', 'zp_add_custom_likes', 10, 2 );
function zp_add_custom_likes( $post_id, $post ) {
	//global $post;
	setup_postdata( $post );
	add_post_meta( $post_id, 'zp_like', 0, true );
	//return true;
}

/**
 * Adds Load More Post functionality in
 * portfolio and in masonry blog using AJAX.
 */
add_action( "wp_ajax_zp_load_posts", "zp_load_more_posts" );
add_action( "wp_ajax_nopriv_zp_load_posts", "zp_load_more_posts" );

function zp_load_more_posts() {
	// Verifying nonce here.
	if ( ! wp_verify_nonce( $_REQUEST['nonce'], "zp_load_posts" ) ) {
		exit ( "You should not be here." );
	}

	$offset = isset( $_REQUEST['offset'] ) ? intval( $_REQUEST['offset'] ) : 0;
	$posts_per_page = isset( $_REQUEST['posts_per_page'] ) ? intval( $_REQUEST['posts_per_page'] ) : 10;
	
	// Optional, if post type is not defined use regular post type.
	$post_type = isset( $_REQUEST['post_type'] ) ? $_REQUEST['post_type'] : 'portfolio';
	
	// Numbers of columns.
	$columns = isset( $_REQUEST['columns'] ) ? $_REQUEST['columns'] : '3';
	
	// Gets Pre defined category.
	$category = isset( $_REQUEST['category'] ) ? $_REQUEST['category'] : '';
	
	// Sets columns.
	$masonry_col = zp_columns( $columns );
	
	ob_start();

	// Portfolio Query.
	if ( $post_type == 'portfolio' ) {
		if ( $category == '' ) {
			$args = array(
				'post_type'      => $post_type,
				'offset'         => $offset,
				'posts_per_page' => $posts_per_page,
			);  
		} else {
			$args = array(
				'posts_per_page'     => $posts_per_page,
				'post_type'          => $post_type,
				'offset'             => $offset,
				'portfolio_category' => $category,
			);
		}
	}
	
	// Posts Query.
	if ( $post_type == 'post' ) {
		if ( $category == '' ) {
			$args = array(
				'post_type'      => $post_type,
				'offset'         => $offset,
				'posts_per_page' => $posts_per_page,
				'post_status'    => 'publish',
			);  
		} else {
			$args = array(
				'post_type'      => $post_type,
				'posts_per_page' => $posts_per_page,
				'offset'         => $offset,
				'category_name'  => $category,
				'post_status'    => 'publish',
			);
		}
	}
	
	$posts_query = new WP_Query( $args );
	
	// Gets the total number of Posts.
	$count_posts = wp_count_posts( $post_type )->publish;
		
	if ( $posts_query->have_posts() && ( ( $count_posts < $posts_per_page ) || ( $posts_per_page != -1 ) ) ) {
		$result['have_posts'] = true;
			if ( $post_type == 'portfolio' )
				echo zp_portfolio_loop( $posts_query, $masonry_col );
			else
				echo zp_masonry_blog_loop( $posts_query, $masonry_col );
		$result['html'] = ob_get_clean();
	} else {
		// no posts found.
		$result['have_posts'] = false;
	}
	
	if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
		$result = json_encode( $result );
		echo $result;
	} else {
		header( "Location: " . $_SERVER["HTTP_REFERER"] );
	}
	die();
}

/**
 * Get Image Attachment Metadata ( caption, title ..).
 *
 * @param integer $attachment_id.
 * @return an array of values.
 */
 function zp_get_attachment_meta( $attachment_id ) {

	 $attachment = get_post( $attachment_id );

	 if ( $attachment ) {
		 return array(
			'alt'         => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
			'caption'     => $attachment->post_excerpt,
			'description' => $attachment->post_content,
			'href'        => get_permalink( $attachment->ID ),
			'src'         => $attachment->guid,
			'title'       => $attachment->post_title,
		);
	}

}

/**
 * Related Posts.
 *
 * @link Code inherited from (http://designsbynickthegeek.com/tutorials/related-posts-genesis, link).
 */
function zp_related_posts() {

	global $post; 
	$count = 0;
	$postIDs = array( $post->ID );
	$related = '';
	$tags = wp_get_post_tags( $post->ID );
	$cats = wp_get_post_categories( $post->ID );
	 
	if ( $tags ) {
		foreach ( $tags as $tag ) {
			$tagID[] = $tag->term_id;
		}

		$args = array(
			'tag__in'               => $tagID,
			'post__not_in'          => $postIDs,
			'showposts'             => 3,
			'ignore_sticky_posts'   => 1,
			'tax_query'             => array(
				array(
					'taxonomy'  => 'post_format',
					'field'     => 'slug',
					'terms'     => array( 
						'post-format-link', 
						'post-format-status', 
						'post-format-aside', 
						'post-format-quote'
						),
					'operator'  => 'NOT IN'
				)
			)
		);

		$tag_query = new WP_Query( $args );
		if ( $tag_query->have_posts() ) {
			while ( $tag_query->have_posts() ) {
				$tag_query->the_post(); 

				$related .= '<article class="' . join( ' ', get_body_class( array( 'three_columns', 'post_grid' ) ) ) . '"  itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost" >';
				
				$image = genesis_get_image( array( 'format' => 'url', 'size' => 'full' ) ); 
				$related .= '<div class="media_container">';
					$related .= '<div class="post_image_overlay"></div>';
					if ( $image ) {
					   $related .= '<div class="post_image_cover" style="background-image: url( ' . $image . ' );"></div>';
					} else {
						$image_default = genesis_get_option( 'zp_default_post_feature', ZP_SETTINGS_FIELD );
						 $related .= '<div class="post_image_cover" style="background-image: url( ' . $image_default . ' );"></div>';
					}
				$related .= '</div>';
				
				$related .= '<div class="entry-content-title"><div class="entry-content-header">';
				$related .= '<h2 class="entry-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
				if ( get_post_meta( $post->ID, 'post_desc', true ) != '' ) {
					$related .= '<h4 class="entry-title-desc">' . get_post_meta( $post->ID, 'post_desc', true ) . '</h4>';
				}
				$related .= '</div></div>';
				$related .= '<div class="entry-content-author">';
				$author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );
				$author_avatar = get_avatar( $post->post_author, 46 );
				$related .= '<a href="' . $author_link . '">' . $author_avatar . '</a>';
				$related .= '<span>' . __( 'Published ', 'slush-pro' ) . ' ' . get_the_date( 'F d, Y', $post->ID ) . ' ' . __( 'by ', 'slush-pro' ) . '<a href="' . $author_link . '">' . get_the_author() . '</a>' . __( ' in ', 'slush-pro' ) . ' ' . get_the_category_list( ',' ) . '<br /><a href="' . get_comments_link( $post->ID ) . '">' . zp_return_comment_number() . '</a></span>';
				$related .= '</div>';
						
				$related .= '</article>';


				$postIDs[] = $post->ID;
				$count++;
			}
		}
	}

	if ( $count <= 2 ) {
		$catIDs = array(); 
		foreach ( $cats as $cat ) {
			if ( 2 == $cat )
				continue;
			$catIDs[] = $cat;
		}
		 
		$showposts = 2 - $count; 
		$args = array(
			'category__in'        => $catIDs,
			'post__not_in'        => $postIDs,
			'showposts'           => $showposts,
			'ignore_sticky_posts' => 1,
			'orderby'             => 'rand',
			'tax_query'           => array(
				'taxonomy' => 'post_format',
				'field'    => 'slug',
				'terms'    => array( 
					'post-format-link', 
					'post-format-status', 
					'post-format-aside', 
					'post-format-quote',
				),
				'operator' => 'NOT IN',
			)
		); 
		$cat_query = new WP_Query( $args );
		 
		if ( $cat_query->have_posts() ) {
			 
			while ( $cat_query->have_posts() ) {
				 
				$cat_query->the_post();

				$related .= '<article class="' . join( ' ', get_body_class( array( 'three_columns', 'post_grid' ) ) ) . '"  itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost" >';
				
				$image = genesis_get_image( array( 'format' => 'url', 'size' => 'full' ) ); 
				$related .= '<div class="media_container">';
					$related .= '<div class="post_image_overlay"></div>';
					if ( $image ) {
					   $related .= '<div class="post_image_cover" style="background-image: url( ' . $image . ' );"></div>';
					} else {
						$image_default = genesis_get_option( 'zp_default_post_feature', ZP_SETTINGS_FIELD );
						 $related .= '<div class="post_image_cover" style="background-image: url( ' . $image_default . ' );"></div>';
					}
				$related .= '</div>';
				
				$related .= '<div class="entry-content-title"><div class="entry-content-header">';
				$related .= '<h2 class="entry-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
				if ( get_post_meta( $post->ID, 'post_desc', true ) != '' ) {
					$related .= '<h4 class="entry-title-desc">' . get_post_meta( $post->ID, 'post_desc', true ) . '</h4>';
				}
				$related .= '</div></div>';
				$related .= '<div class="entry-content-author">';
				$author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );
				$author_avatar = get_avatar( $post->post_author, 46 );
				$related .= '<a href="' . $author_link . '">' . $author_avatar . '</a>';
				$related .= '<span>' . __( 'Published ', 'slush-pro' ) . ' ' . get_the_date( 'F d, Y', $post->ID ) . ' ' . __( 'by ', 'slush-pro' ) . '<a href="' . $author_link . '">' . get_the_author() . '</a>' . __( ' in ', 'slush-pro' ) . ' ' . get_the_category_list(',') . '<br /><a href="' . get_comments_link( $post->ID ) . '">' . zp_return_comment_number() . '</a></span>';
				$related .= '</div>';
						
				$related .= '</article>';
			}
		}
	} 
	if ( $related ) {
		printf( '<div class="related-posts"><div class="container-fluid"><div class="related-list">%s</div></div></div>', $related );
	}

	wp_reset_query();

}

/**
 * Blog Minute Read.
 */
 if ( ! function_exists( 'zp_blog_read' ) ) {
	function zp_blog_read( $atts, $content = "" ) {

		extract( shortcode_atts( array(
			'label' => '',
		), $atts, 'zp_post_read' ) );
		
		global $post;
		
		$output = '';
		$reading_time = 0;
		$content  = $post->post_content;
		$words = str_word_count( strip_tags( $content ) );
		
		// Sets reading time 100wpm.
		$reading_time = floor($words / 100 );
		
		// Default Label.
		$default_label = ( $reading_time > 1 ) ? __( ' Minutes Read', 'slush-pro' ) : __( ' Minute Read', 'slush-pro' );
		$label = ( ! empty( $label ) ) ? $label : $default_label;
					 
		// If less than a minute, return 1.
		if ( $reading_time == 0 )  { $reading_time = '1'; } 
		
		$output =  '<span class="zp_post_read"><span class="zp_minute">' . $reading_time . "</span> <strong>" . $label . '</strong></span>';
		
		return $output;

	}

	add_shortcode( 'zp_post_read', 'zp_blog_read' );

 }

/**
 * Blog Views.
 */
function zp_get_post_views( $postID ) {

	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true );

	if ( $count == '' ) {
		delete_post_meta( $postID, $count_key );
		add_post_meta( $postID, $count_key, '0' );
	return '0';
	}

	return $count;

}

function zp_set_post_views( $postID ) {

	$count_key = 'post_views_count';
	$count = get_post_meta( $postID, $count_key, true );
	
	if ( $count == '' ) {
		$count = 0;
		delete_post_meta( $postID, $count_key );
		add_post_meta( $postID, $count_key, '0' );
	} else {
		$count++;
		update_post_meta( $postID, $count_key, $count );
	}

}

add_shortcode( 'zp_post_view', 'zp_blog_post_view' );
function zp_blog_post_view( $atts, $content = "" ) {

	extract( shortcode_atts( array(
		'label' => '',
	), $atts, 'zp_post_view'  ) );

	global $post;

	$output = '';

	$views = zp_get_post_views( $post->ID );

	// Default Label.
	$default_label = ( $views > 1 ) ? __( ' Views', 'slush-pro' ) : __( ' View', 'slush-pro' ); 
	$label = ( $label != '' ) ? $label : $default_label;
	
	$output = '<span class="zp_post_view"><span class="zp_views">' . $views . "</span> <strong>" . $label . '</strong></span>';
	return $output;

}

/**
 * Post Like.
 */
if ( ! function_exists( 'zp_post_like' ) ) {

	function zp_post_like() {

		global $post;

		// Enqueues script.
		wp_enqueue_script('zp_post_like' );
		wp_localize_script( 'zp_post_like', 'zp_post_like', 
			array(
				'ajax_url' => admin_url('admin-ajax.php')
			)
		);
		
		$like_counter = ( get_post_meta( $post->ID, 'zp_like', true ) > 0 )? get_post_meta( $post->ID, 'zp_like', true ): 0;
		$like = '<span class="zp_like_holder ' . $post->ID . '"><i class="fa fa-heart ' . $post->ID . '"></i><em class="like_counter">(' . $like_counter . ')</em></span>';
		
		return $like;

	}

	add_shortcode( 'zp_post_like', 'zp_post_like' );

}
