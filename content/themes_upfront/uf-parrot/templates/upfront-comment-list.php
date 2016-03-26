<?php
/**
 * Contains codes that run through wp_list_comment callback
 *
 * Note: no </li> closure needed
 */


switch ( $comment->comment_type ){
	case 'pingback':
	case 'trackback':
		break;

	default:
?>

<li <?php comment_class(); ?> id="<?php comment_ID(); ?>">
	<article id="comment-<?php comment_ID(); ?>" class="comment">
		<div class="comment-avatar vcard">
			<?php echo get_avatar($comment, 45); ?>
		</div>
		<div class="comment-content-wrapper">
			<cite class="fn"><?php comment_author_link(); ?></cite>
			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- end comment-content -->
			<?php edit_comment_link( __( 'Edit' ), '<p class="edit-link">', '</p>' ); ?>
			<?php if ( '0' == $comment->comment_approved ): ?>
				<p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></p>
			<?php endif ?>
			<footer class="comment-footer">
				<time class="comment-time" datetime="<?php comment_time('Y-m-d'); ?>"><?php printf('%1$s', get_comment_date()); ?></time>
				<div class="reply">- <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></div>
			</footer><!-- end comment-footer -->
		</div>
	</article>

<?php
		break;
}
?>