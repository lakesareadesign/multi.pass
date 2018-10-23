<div class="fl-rich-text">
	<?php

	global $wp_embed;

	echo wpautop( do_shortcode( $wp_embed->autoembed( $settings->text ) ) );

	?>
</div>
