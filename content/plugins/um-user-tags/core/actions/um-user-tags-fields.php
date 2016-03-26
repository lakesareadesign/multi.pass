<?php	
	
	/***
	***	@member directory header
	***/
	add_action('um_members_directory_head', 'um_user_tags_show_filters', 100 );
	function um_user_tags_show_filters( $args ) {
		global $um_user_tags;
		
		if ( $um_user_tags->filters ) {
			echo '<div class="um-user-tags-md">';
			foreach( $um_user_tags->filters as $metakey => $slug ) {
				$term = get_term_by('slug', $slug, 'um_user_tag');
				$remove_filter = remove_query_arg( $metakey );
				echo '<span>' . $term->name . '<a href="'. $remove_filter .'"><i class="um-icon-close"></i></a></span>';
			}
			echo '</div>';
		}
	}
	
	/***
	***	@modal field settings
	***/
	add_action('um_admin_field_edit_hook_tag_source', 'um_admin_field_edit_hook_tag_source');
	function um_admin_field_edit_hook_tag_source( $val ) {
		
		$metabox = new UM_Admin_Metabox();
		
		$parent_tags = get_terms( 'um_user_tag', array(
			'hide_empty' => 0,
			'parent' => 0
		) );
		
		?>
		
			<p><label for="_tag_source"><?php _e('Select a user tags source','um-mailchimp'); ?> <?php $metabox->tooltip( __('Choose the user tags type that user can select from','um-user-tags') ); ?></label>
				<select name="_tag_source" id="_tag_source" class="umaf-selectjs" style="width: 100%">
					
					<?php foreach( $parent_tags as $tag ) { ?>
					<option value="<?php echo $tag->term_id; ?>" <?php selected( $tag->term_id, $val ); ?>><?php echo $tag->name; ?></option>
					<?php } ?>
					
				</select>
			</p>

		<?php
	}