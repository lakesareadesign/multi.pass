<?php
/**
 * Metabox preview template
 *
 * @package wpmu-dev-seo
 */

$post = empty( $post ) ? null : $post;

// Date.
$date = $post ? date( 'M j, Y', strtotime( $post->post_date ) ) : date( 'M j, Y' );
// Title.
$title = empty( $title ) ? smartcrawl_get_value( 'title' ) : $title;
if ( empty( $title ) && $post ) {
	$title = $post->post_title;
}
if ( empty( $title ) ) {
	$title = esc_html__( 'Dummy Title', 'wds' );
}
if ( is_object( $post ) ) {
	$title = smartcrawl_replace_vars( $title, (array) $post );
}

// Description.
$description = empty( $description ) ? smartcrawl_get_value( 'metadesc' ) : $description;
if ( empty( $description ) && $post ) {
	$description = $post->post_excerpt;
}
if ( empty( $description ) && $post ) {
	$description = substr( strip_tags( $post->post_content ), 0, 130 );
}
if ( empty( $description ) ) {
	$description = __( 'Dummy description', 'wds' );
}
if ( is_object( $post ) ) {
	$description = smartcrawl_replace_vars( $description, (array) $post );
}

// Slug.
$slug = ! empty( $post->post_name ) ? $post->post_name : sanitize_title( $title );
?>
<div class="wds-metabox-preview">
	<label class="wds-label"><?php esc_html_e( 'Google Preview' ); ?></label>

	<?php
	if ( apply_filters( 'wds-metabox-visible_parts-preview_area', true ) ) {
		$link = sprintf(
			'%s/%s/',
			str_replace( 'http://', '', get_bloginfo( 'url' ) ),
			$slug
		);
		if ( ! empty( $post ) && is_object( $post ) && ! empty( $post->ID ) ) {
			$link = get_permalink( $post->ID );
		}

		$this->_render( 'onpage/onpage-preview', array(
			'link'        => esc_url( $link ),
			'title'       => esc_html( $title ),
			'description' => esc_html( $description ),
		) );
	}
	?>
</div>