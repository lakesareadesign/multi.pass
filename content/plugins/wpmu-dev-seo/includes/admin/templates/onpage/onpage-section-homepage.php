<?php
	$homepage_title = empty( $homepage_title ) ? '' : $homepage_title;
	$homepage_description = empty( $homepage_description ) ? '' : $homepage_description;
	$show_homepage_options = empty( $show_homepage_options ) ? '' : $show_homepage_options;
	$meta_robots_main_blog_archive = empty( $meta_robots_main_blog_archive ) ? '' : $meta_robots_main_blog_archive;
	$option_name = empty( $_view['option_name'] ) ? '' : '';
?>

<?php
	$this->_render(
		'onpage/onpage-preview',
		array(
			'link'        => home_url(),
			'title'       => smartcrawl_replace_vars( $homepage_title, array() ),
			'description' => smartcrawl_replace_vars( $homepage_description, array() ),
		)
	);
?>

<?php if ( $show_homepage_options ) :  ?>

	<div class="wds-table-fields-group">
		<div class="wds-table-fields">
			<div class="label">
				<label for="title-homepage" class="wds-label"><?php esc_html_e( 'Page Title' , 'wds' ); ?></label>
			</div>
			<div class="fields wds-allow-macros">
				<input id='title-homepage' name='<?php echo esc_attr( $_view['option_name'] ); ?>[title-home]' type='text' class='wds-field' value='<?php echo esc_attr( $_view['options']['title-home'] ); ?>'>
			</div>
		</div>
	</div>

	<div class="wds-table-fields-group">
		<div class="wds-table-fields">
			<div class="label">
				<label for="metadesc-homepage" class="wds-label"><?php esc_html_e( 'Page Description' , 'wds' ); ?></label>
			</div>
			<div class="fields wds-allow-macros">
				<textarea id='metadesc-homepage' name='<?php echo esc_attr( $_view['option_name'] ); ?>[metadesc-home]' type='text' class='wds-field'><?php echo esc_textarea( $_view['options']['metadesc-home'] ); ?></textarea>
			</div>
		</div>
	</div>

	<div class="wds-table-fields-group">
		<div class="wds-table-fields">
			<div class="label">
				<label for="metakeywords-homepage" class="wds-label"><?php esc_html_e( 'Page Keywords' , 'wds' ); ?></label>
			</div>
			<div class="fields fields-with-legend">
				<input id='metakeywords-homepage' name='<?php echo esc_attr( $_view['option_name'] ); ?>[keywords-home]' type='text' class='wds-field' value='<?php echo esc_attr( $_view['options']['keywords-home'] ); ?>'>
				<span class="wds-field-legend"><?php echo sprintf( '%s <pre class="wds-pre wds-pre-inline">%s</pre>' , __( 'Comma-separated keywords, e.g.', 'wds' ), __( 'word1, word2', 'wds' ) ); ?></span>
			</div>
		</div>
	</div>

	<?php
		$this->_render('onpage/onpage-og-master', array(
			'for_type' => 'home',
		));
	?>

	<?php
		$this->_render('onpage/onpage-meta-robots', array(
			'items'    => $meta_robots_main_blog_archive,
		));
	?>

<?php else : ?>

	<?php
		$front_page = (int) get_option( 'page_on_front' );
		$edit_link = sprintf(
			'<a href="' . get_edit_post_link( $front_page ) . '">%s</a>',
			__( 'here', 'wds' )
		);
	?>
	<div class="wds-notice wds-notice-info">
		<p>
			<?php
			if ( $front_page ) {
				printf(
					__( 'Your homepage is set to a static page. Configure your homepage SEO via the page itself %s.', 'wds' ),
					$edit_link
				);
			} else {
				esc_html_e( 'Your homepage is set to a static page. Configure your homepage SEO via the page itself.', 'wds' );
			}
			?>
		</p>
	</div>
<?php endif; ?>