<?php
$robots_noindex_value = empty( $robots_noindex_value ) ? false : $robots_noindex_value;
$robots_nofollow_value = empty( $robots_nofollow_value ) ? false : $robots_nofollow_value;
$robots_index_value = empty( $robots_index_value ) ? false : true;
$robots_follow_value = empty( $robots_follow_value ) ? false : true;
$advanced_value = empty( $advanced_value ) ? array() : $advanced_value;
$advanced_options = empty( $advanced_options ) ? array() : $advanced_options;
$sitemap_priority_options = empty( $sitemap_priority_options ) ? array() : $sitemap_priority_options;
$post_type_noindexed = empty( $post_type_noindexed ) ? false : true;
$post_type_nofollowed = empty( $post_type_nofollowed ) ? false : true;
$post = empty( $post ) ? null : $post;
if ( $post ) {
	$post_id = $post->ID;
} else {
	return;
}
?>

<div class="wds-metabox-section wds-advanced-metabox-section wds-form">
	<div class="wds-table-fields-group">
		<?php if ( apply_filters( 'wds-metabox-visible_parts-robots_area', true ) ) : ?>
			<div class="wds-table-fields">
				<div class="label">
					<label class="wds-label"><?php esc_html_e( 'Indexing', 'wds' ); ?></label>
					<p class="wds-label-description">
						<?php esc_html_e( 'Choose how search engines will index this particular page.', 'wds' ); ?>
					</p>
				</div>
				<div class="fields">
					<?php
					if ( $post_type_noindexed ) {
						$this->_render( 'toggle-item', array(
							'field_name'       => 'wds_meta-robots-index',
							'field_id'         => 'wds_meta-robots-index',
							'checked'          => $robots_index_value ? 'checked="checked"' : '',
							'item_label'       => esc_html__( 'Index - Override Post Type Setting', 'wds' ),
							'item_description' => esc_html__( 'Instruct search engines whether or not you want this post to appear in search results.', 'wds' ),
						) );
					} else {
						$this->_render( 'toggle-item', array(
							'inverted'         => true,
							'field_name'       => 'wds_meta-robots-noindex',
							'field_id'         => 'wds_meta-robots-noindex',
							'checked'          => $robots_noindex_value ? 'checked="checked"' : '',
							'item_label'       => esc_html__( 'Index', 'wds' ),
							'item_description' => esc_html__( 'Instruct search engines whether or not you want this post to appear in search results.', 'wds' ),
						) );
					}

					if ( $post_type_nofollowed ) {
						$this->_render( 'toggle-item', array(
							'field_name'       => 'wds_meta-robots-follow',
							'field_id'         => 'wds_meta-robots-follow',
							'checked'          => $robots_follow_value ? 'checked="checked"' : '',
							'item_label'       => esc_html__( 'Follow - Override Post Type Setting', 'wds' ),
							'item_description' => esc_html__( 'Tells search engines whether or not to follow the links on your page and crawl them too.', 'wds' ),
						) );
					} else {
						$this->_render( 'toggle-item', array(
							'inverted'         => true,
							'field_name'       => 'wds_meta-robots-nofollow',
							'field_id'         => 'wds_meta-robots-nofollow',
							'checked'          => $robots_nofollow_value ? 'checked="checked"' : '',
							'item_label'       => esc_html__( 'Follow', 'wds' ),
							'item_description' => esc_html__( 'Tells search engines whether or not to follow the links on your page and crawl them too.', 'wds' ),
						) );
					}

					$this->_render( 'toggle-item', array(
						'inverted'         => true,
						'item_value'       => 'noarchive',
						'field_name'       => 'wds_meta-robots-adv[noarchive]',
						'field_id'         => 'wds_meta-robots-noarchive',
						'checked'          => in_array( 'noarchive', $advanced_value, true ) ? 'checked="checked"' : '',
						'item_label'       => esc_html__( 'Archive', 'wds' ),
						'item_description' => esc_html__( 'Instructs search engines to store a cached version of this page.', 'wds' ),
					) );

					$this->_render( 'toggle-item', array(
						'inverted'         => true,
						'item_value'       => 'nosnippet',
						'field_name'       => 'wds_meta-robots-adv[nosnippet]',
						'field_id'         => 'wds_meta-robots-nosnippet',
						'checked'          => in_array( 'nosnippet', $advanced_value, true ) ? 'checked="checked"' : '',
						'item_label'       => esc_html__( 'Snippet', 'wds' ),
						'item_description' => esc_html__( 'Allows search engines to show a snippet of this page in the search results and prevents them from caching the page.', 'wds' ),
					) );
					?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( apply_filters( 'wds-metabox-visible_parts-canonical_area', true ) ) : ?>
			<div class="wds-table-fields wds-separator-top">
				<div class="label">
					<label for="wds_canonical" class="wds-label"><?php esc_html_e( 'Canonical', 'wds' ); ?></label>
					<p class="wds-label-description">
						<?php esc_html_e( 'If you have several similar versions of this page you can point search engines to the canonical or "genuine" version to avoid duplicate content issues.', 'wds' ); ?>
					</p>
				</div>
				<div class="fields">
					<input type='text' id='wds_canonical' name='wds_canonical'
					       value='<?php echo esc_attr( smartcrawl_get_value( 'canonical', $post_id ) ); ?>'
					       class='wds'/>
					<span
							class="wds-field-legend"><?php esc_html_e( 'Enter the full canonical URL including http:// or https://', 'wds' ); ?></span>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( apply_filters( 'wds-metabox-visible_parts-redirect_area', true ) && user_can_see_seo_metabox_301_redirect() ) : ?>
			<div class="wds-table-fields wds-separator-top">
				<div class="label">
					<label for="wds_redirect" class="wds-label"><?php esc_html_e( '301 Redirect', 'wds' ); ?></label>
					<p class="wds-label-description">
						<?php esc_html_e( 'Send visitors to this URL to another page.', 'wds' ); ?>
					</p>
				</div>
				<div class="fields">
					<input type='text' id='wds_redirect' name='wds_redirect'
					       value='<?php echo esc_attr( smartcrawl_get_value( 'redirect', $post_id ) ); ?>' class='wds'/>
					<span
							class="wds-field-legend"><?php esc_html_e( 'Enter the URL to send traffic to including http:// or https://', 'wds' ); ?></span>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( apply_filters( 'wds-metabox-visible_parts-sitemap_priority_area', true ) ) : ?>
			<div class="wds-table-fields wds-separator-top">
				<div class="label">
					<label for='wds_sitemap-priority'
					       class="wds-label"><?php esc_html_e( 'Sitemap Priority', 'wds' ); ?></label>
				</div>
				<div class="fields">
					<select name='wds_sitemap-priority'
					        id='wds_sitemap-priority'
					        class="select-container"
					        style="width: 100%">

						<?php $priority_value = smartcrawl_get_value( 'sitemap-priority', $post_id ); ?>

						<?php foreach ( $sitemap_priority_options as $key => $label ) : ?>
							<option value='<?php echo esc_attr( $key ); ?>' <?php selected( $key, $priority_value ); ?>>
								<?php echo esc_html( $label ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		<?php endif; ?>

		<div class="wds-table-fields wds-separator-top">
			<div class="label">
				<label class="wds-label" for="wds_autolinks-exclude">
					<?php esc_html_e( 'Automatic Linking', 'wds' ); ?>
				</label>
				<p class="wds-label-description">
					<?php esc_html_e( 'You can prevent this particular post from being auto-linked', 'wds' ); ?>
				</p>
			</div>
			<div class="fields">
				<?php
				$this->_render( 'toggle-item', array(
					'inverted'   => true,
					'field_name' => 'wds_autolinks-exclude',
					'checked'    => smartcrawl_get_value( 'autolinks-exclude', $post_id ) ? 'checked="checked"' : '',
					'item_label' => esc_html__( 'Enable automatic linking for this post', 'wds' ),
				) );
				?>
			</div>
		</div>
	</div>
</div>