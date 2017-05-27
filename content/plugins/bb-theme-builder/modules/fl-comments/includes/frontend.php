<?php

ob_start();
comments_template();
$comments = ob_get_clean();

if ( empty( $comments ) ) {
	echo '<div class="fl-builder-module-placeholder-message">';
	_e( 'Comments', 'fl-theme-builder' );
	echo '</div>';
} else {
	echo $comments;
}
