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
        <div class="comment-wrapper">
            <header class="comment-avatar">
                <?php echo get_avatar($comment, 75); ?>
            </header>
            <div class="comment-content-wrapper">
                <div class="comment-meta">
                    <div class="comment-author">
                        <cite class="fn"><?php comment_author_link(); ?></cite>
                    </div>
                    <div class="comment-time">
                        <a href="<?php comment_link(); ?>">
                            <time datetime="<?php comment_time('c'); ?>"><?php printf('%1$s', get_comment_date()) ?></time>
                        </a>
                    </div>
                </div>
                <div class="comment-content">
                    <?php comment_text(); ?>
                </div>
                <?php edit_comment_link( __( 'Edit' ), '<p class="edit-link">', '</p>' ); ?>
            </div>
        </div>
        <div class="comment-meta-actions">
            <?php if ( '0' == $comment->comment_approved ): ?>
                <p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></p>
            <?php endif ?>
            <div class="comment-reply">
                <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div>
        </div>
	</article>

<?php
		break;
}
?>