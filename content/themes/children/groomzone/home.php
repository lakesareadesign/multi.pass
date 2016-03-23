<?php


add_action( 'genesis_meta', 'lad_home_genesis_meta' );


//Add widget support for homepage. If no widgets active, display the default loop.
function lad_home_genesis_meta() {

	if ( is_active_sidebar( 'home-welcome' ) || is_active_sidebar( 'home-slider' ) || is_active_sidebar( 'home-1' ) || is_active_sidebar( 'home-2' ) || is_active_sidebar( 'home-left' ) || is_active_sidebar( 'home-middle' ) || is_active_sidebar( 'home-right' ) ) {

		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_after_header', 'lad_home_welcome_helper' );
		add_action( 'genesis_loop', 'lad_home_loop_helper' );
		//add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
		add_filter( 'body_class', 'add_body_class' );

		function add_body_class( $classes ) {
   			$classes[] = 'lad';
  			return $classes;
		}

	}
}

function lad_home_welcome_helper() {

	if ( is_active_sidebar( 'home-welcome' ) ) {
		echo '<div class="home-welcome">';
		dynamic_sidebar( 'home-welcome' );
		echo '</div><!-- end #home-welcome -->';
	}

	if ( is_active_sidebar( 'home-slider' ) ) {
		echo '<div class="home-slider">';
		dynamic_sidebar( 'home-slider' );
		echo '</div><!-- end #home-slider -->';
	}

}

function lad_home_loop_helper() {

	if ( is_active_sidebar( 'home-1' ) || is_active_sidebar( 'home-2' ) || is_active_sidebar( 'home-left' ) || is_active_sidebar( 'home-middle' ) || is_active_sidebar( 'home-right' ) ) {

		echo '<div class="home">';
			
			echo '<div class="">';
			dynamic_sidebar( 'home-1' );
			echo '</div><!-- end -->';

				echo '<div class="breakline"></div>';

			echo '<div class="">';
			dynamic_sidebar( 'home-2' );
			echo '</div><!-- end -->';
			
				echo '<div class="breakline"></div>';
			
			echo '<div class="one-third first">';
			dynamic_sidebar( 'home-left' );
			echo '</div><!-- end -->';

			echo '<div class="one-third">';
			dynamic_sidebar( 'home-middle' );
			echo '</div><!-- end -->';

			echo '<div class="one-third">';
			dynamic_sidebar( 'home-right' );
			echo '</div><!-- end -->';

		echo '</div><!-- end #home -->';

	}

}

genesis();