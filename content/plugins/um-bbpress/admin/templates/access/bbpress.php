
<h4><?php _e('Which roles can create new topics in this forum','um-bbpress'); ?></h4>

<p class="description">

	<?php $value = get_post_meta($post->ID, '_um_bbpress_can_topic', true); ?>

	<?php foreach($ultimatemember->query->get_roles() as $role_id => $role) { ?>

		<label><input type="checkbox" name="_um_bbpress_can_topic[]" value="<?php echo $role_id; ?>" <?php if (  ( isset( $value ) && is_array( $value ) && in_array($role_id, $value ) ) || ( isset( $value ) && $role_id == $value ) ) echo 'checked="checked"'; ?> /> <?php echo $role; ?></label><br />

	<?php } ?>

</p>

<h4><?php _e('Which roles can create new replies in this forum','um-bbpress'); ?></h4>

<p class="description">

	<?php $value = get_post_meta($post->ID, '_um_bbpress_can_reply', true); ?>

	<?php foreach($ultimatemember->query->get_roles() as $role_id => $role) { ?>

		<label><input type="checkbox" name="_um_bbpress_can_reply[]" value="<?php echo $role_id; ?>" <?php if (  ( isset( $value ) && is_array( $value ) && in_array($role_id, $value ) ) || ( isset( $value ) && $role_id == $value ) ) echo 'checked="checked"'; ?> /> <?php echo $role; ?></label><br />

	<?php } ?>

</p>