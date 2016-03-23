<?php
if ( ! isset( $errors ) || ! is_array( $errors ) ) {
	return;
}

$all_errors = array();

foreach ( $errors as $blog_id => $blog_errors ) {
	foreach ( $blog_errors as $attachment_id => $attachment_errors ) {
		if ( ! is_array( $attachment_errors ) ) {
			// Ensure any errors are treated as an array
			$attachment_errors = (array) $attachment_errors;
		}

		foreach ( $attachment_errors as $error ) {
			$all_errors[] = sprintf( '%s <a target="_blank" href="%s">%s</a>', $error, get_admin_url( $blog_id, 'post.php?post=' . $attachment_id . '&action=edit' ), $attachment_id );
		}
	}
}


?>

<ol class="as3cf-notice-toggle-list">
	<?php foreach ( $all_errors as $error ) : ?>
		<li><?php echo $error; ?> </li>
	<?php endforeach; ?>
</ol>