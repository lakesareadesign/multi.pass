<?php
/**
 * Jessica Comment Form
 *
 * This file calls the defines the output for the HTML5 blog comment form.
 *
 * @category     Jessica
 * @package      Structure
 * @author       9seeds
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        2.6.1
 */

/** Edit comments form text **/

add_filter( 'comment_form_defaults', 'wsm_genesis_comment_form_args' );

function wsm_genesis_comment_form_args( $defaults ) {

	global $user_identity, $id;

	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? ' aria-required="true"' : '' );

	$author = '<p class="comment-form-author">' .
			'<label for="author">' . __( 'Name', 'jessica' ) .   ( $req ? '<span class="required">*</span>' : '' ) .'</label> ' .
			 '<input id="author" name="author" type="text"  value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1"' . $aria_req . ' />' .
			 '</p><!-- .form-section-author .form-section -->';

	$email = '<p class="comment-form-email">' .
			'<label for="email">' . __( 'Email', 'jessica' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .
			'<input id="email" name="email" type="text"  value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" tabindex="2"' . $aria_req . ' />' .
			'</p><!-- .form-section-email .form-section -->';

	$url = '<p class="comment-form-url">' .
		'<label for="url">' . __( 'Website', 'jessica' ) . '</label> ' .
		'<input id="url" name="url" type="text"  value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" tabindex="2" />' .
		'</p><!-- .form-section-url .form-section -->';

	$comment_field = '<p class="comment-form-comment">' .
					'<label for="comment">' . __( 'Comment', 'jessica' ) . '</label>' .
	                '<textarea id="comment" name="comment"  cols="45" rows="8" tabindex="4" aria-required="true"></textarea>' .
					'</p>';
					 
	$cookies = '<p class="comment-form-cookies-consent">'.
	'<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes">'.
	'<label for="wp-comment-cookies-consent">Save my name, email, and website in this browser for the next time I comment.</label>'.
	'</p>';

	$args = array(
		'fields'               => array(
			'author' => $author,
			'email'  => $email,
			'url'    => $url,
			'cookies' => $cookies,
		),
		'comment_field'        => $comment_field,
		'title_reply'          => __( 'Leave a Comment', 'jessica' ),
		'label_submit' => __( 'Post', 'jessica' ), //default='Post Comment'
		'title_reply_to' => __( 'Reply', 'jessica' ), //Default: __( 'Leave a Reply to %s' )
		'cancel_reply_link' => __( 'Cancel', 'jessica' ),//Default: __( 'Cancel reply' )
		'comment_notes_before' => '',
		'comment_notes_after'  => '',
	);

	/** Merge $args with $defaults */
	$args = wp_parse_args( $args, $defaults );

		/** Return filterable array of $args, along with other optional variables */
	return apply_filters( 'genesis_comment_form_args', $args, $user_identity, $id, $commenter, $req, $aria_req );

}

// Remove comments from Post types
add_action( 'init', 'wsm_remove_store_comments', 10 );
function wsm_remove_store_comments() {
    remove_post_type_support( 'store_page', 'comments' );
}