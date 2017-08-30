<?php

// Adds the Post Options Meta box to the post editor
add_action('add_meta_boxes', 'add_post_header_meta_box');
function add_post_header_meta_box() {
    add_meta_box('bbs-post-header-meta-box', 'Post Header', 'post_header_meta_box_callback', 'post', 'normal', 'high', null);
}

function post_header_meta_box_callback($object) {

    wp_nonce_field(basename(__FILE__), 'meta-box-nonce');

    ?>
        <div>
          <table class="form-table">
	           <tbody>
                  <tr valign="top">
			                <th scope="row"><label for="bbs-hide-post-header"><strong>Post Header</strong></label></th>
			                <td>
				                 <p>
                            <label class="selectit">
                              <?php
                                $checkbox_value = bbs_cf( 'bbs-hide-post-header' );

                                if($checkbox_value == '') {
                                  echo '<input name="bbs-hide-post-header" type="checkbox" value="true">';
                                }
                                else if($checkbox_value == 'true') {
                                  echo '<input name="bbs-hide-post-header" type="checkbox" value="true" checked="checked">';
                                }
                              ?>
                              Hide Post Header
                            </label>
                          </p>
                          <p><strong>Note:</strong> You must add a featured image in order for this option to matter.</p>
			                  </td>
		                </tr>
                </tbody>
            </table>
        </div>
    <?php

}

function save_custom_meta_box($post_id, $post, $update) {
    if ( !isset( $_POST['meta-box-nonce'] ) || !wp_verify_nonce( $_POST['meta-box-nonce'], basename(__FILE__) ) )
        return $post_id;

    if ( !current_user_can( 'edit_post', $post_id ) )
        return $post_id;

    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

    $slug = 'post';
    if ( $slug != $post->post_type )
        return $post_id;

    $bbs_hide_post_header_value = '';

    if ( isset( $_POST['bbs-hide-post-header'] ) ) {
        $bbs_hide_post_header_value = $_POST['bbs-hide-post-header'];
    }
    update_post_meta( $post_id, 'bbs-hide-post-header', $bbs_hide_post_header_value );
}

add_action('save_post', 'save_custom_meta_box', 10, 3);
