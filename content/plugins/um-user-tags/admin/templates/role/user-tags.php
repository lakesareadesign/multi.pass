<?php global $um_user_tags;

	$terms = get_terms( 'um_user_tag', array(
			'hide_empty' => 0,
			'parent' => 0
	) );
		
	if ( !$terms )
		return '';
	
	$tags_set = get_option('um_user_tags_filters');

?>

<div class="um-admin-metabox">

	<div class="">

		<p>
			<label class="um-admin-half"><?php _e('Show user tags in profile head?','um-user-tags'); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_show_user_tags', 0 ); ?></span>
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label class="um-admin-half"><?php _e('Choose the user tags source to show in profile header','um-user-tags'); ?></label>
			<span class="um-admin-half">

				<?php if ( !$tags_set ) { ?>
				
				<?php _e('You did not create any user tags fields yet.','um-user-tags'); ?>
				
				<?php } else { ?>
				
				<select name="_um_user_tags_metakey" id="_um_user_tags_metakey" class="umaf-selectjs" style="width: 300px">
					
					<?php foreach( $tags_set as $i => $metakey ) { 
					
					$term = get_term_by('id', $i, 'um_user_tag');
					
					?>
					<option value="<?php echo $metakey; ?>" <?php selected($metakey, $ultimatemember->query->get_meta_value('_um_user_tags_metakey', $metakey) ); ?>><?php echo $term->name; ?></option>
					<?php } ?>
					
				</select>
				
				<?php } ?>

			</span>
			
		</p><div class="um-admin-clear"></div>

	</div>
	
	<div class="um-admin-clear"></div>
	
</div>