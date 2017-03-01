<div id="container" class="wrap wrap-wds wds-page wds-page-autolinks">
	<section id="header">
		<?php $this->_render('settings-message-top'); ?>
		<div class="actions">
			<a href="#show-supported-macros-modal" rel="dialog" class="button button-small button-light actions-button"><?php esc_html_e('Browse Macros', 'wds'); ?></a>
		</div>
		<h1><?php esc_html_e( 'Title & Meta' , 'wds' ); ?></h1>
	</section><!-- end header -->

	<dialog class="wds-modal" id="show-supported-macros-modal" title="<?php esc_html_e( 'Supported Macros', 'wds' ); ?>">
		<div id="wds-show-supported-macros">
			<table class="wds-data-table wds-data-table-inverse-large">
				<thead>
					<tr>
						<th class="label"><?php esc_html_e( 'Title' , 'wds'); ?></th>
						<th class="result"><?php esc_html_e( 'Gets Replaced By' , 'wds'); ?></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th class="label"><?php esc_html_e( 'Title' , 'wds'); ?></th>
						<th class="result"><?php esc_html_e( 'Gets Replaced By' , 'wds'); ?></th>
					</tr>
				</tfoot>
				<tbody>

					<?php foreach( $macros as $macro => $label ) { ?>
						<tr>
							<td class="data data-small"><?php echo esc_html($macro); ?></td>
							<td class="data data-small"><?php echo esc_html($label); ?></td>
						</tr>
					<?php } ?>

				</tbody>
			</table>
		</div>
	</dialog><!-- end run-seo-analysis-modal -->

<?php
	$wds_options = WDS_Settings::get_options();
	if ( ! wds_is_allowed_tab( $_view['slug'] ) ) {
		printf( __( "Your network admin prevented access to '%s', please move onto next step.", 'wds' ), __( 'Title & Meta' , 'wds' ) );
	} else if ( 'settings' === $_view['name'] || ( ! empty( $wds_options[ $_view['name'] ] ) ) ) {

?>
	<div class="row sub-header">
		<div class="wds-block-section">
		<p><?php esc_html_e('Here you can change the Title & Description meta tags for various areas of your website. Title & Description meta tags are generally held to be the most valuable and most likely to be indexed, so special attention to those. You may either use normal text or dynamic macros.', 'wds'); ?></p>
		</div>
	</div><!-- end sub-header -->

	<form action='<?php echo esc_attr($_view['action_url']); ?>' method='post' class="wds-form">
		<?php settings_fields( $_view['option_name'] ); ?>

		<input type="hidden" name='<?php echo esc_attr($_view['option_name']); ?>[<?php echo esc_attr($_view['slug']); ?>-setup]' value="1">

		<div class="vertical-tabs" id="page-title-meta-tabs">
			<section class="tab">
				<input type="radio" name="tab_onpage_group" id="tab_homepage" checked="checked">
				<label for="tab_homepage"><?php esc_html_e( 'Homepage', 'wds' ); ?></label>
				<div class="content wds-content-tabs">

					<h2 class="tab-title"><?php esc_html_e( 'Homepage', 'wds' ); ?></h2>

					<div class="wds-content-tabs-inner">

				<?php if ( WDS_SITEWIDE || 'posts' == get_option('show_on_front') ) { ?>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="title-homepage" class="wds-label"><?php esc_html_e( 'Page Title' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<input id='title-homepage' name='<?php echo esc_attr($_view['option_name']); ?>[title-home]' size='' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['title-home']); ?>'>
								</div>
							</div>
						</div>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="metadesc-homepage" class="wds-label"><?php esc_html_e( 'Page Description' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<textarea id='metadesc-homepage' name='<?php echo esc_attr($_view['option_name']); ?>[metadesc-home]' size='' type='text' class='wds-field'><?php echo esc_textarea($_view['options']['metadesc-home']); ?></textarea>
								</div>
							</div>
						</div>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="metakeywords-homepage" class="wds-label"><?php esc_html_e( 'Page Keywords' , 'wds' ); ?></label>
								</div>
								<div class="fields fields-with-legend">
									<input id='metakeywords-homepage' name='<?php echo esc_attr($_view['option_name']); ?>[keywords-home]' size='' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['keywords-home']); ?>'>
									<span class="wds-field-legend"><?php echo sprintf( '%s <pre class="wds-pre wds-pre-inline">%s</pre>' , __( 'Comma-separated keywords, e.g.', 'wds' ), __( 'word1, word2', 'wds' ) ); ?></span>
								</div>
							</div>
						</div>

						<?php
							$this->_render('onpage-og-master', array(
								'for_type' => 'home',
							));
						?>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label label-with-options">
									<label for="<?php echo esc_attr($_view['option_name']); ?>-main-blog-archive-meta-robots" class="wds-label"><?php _e( 'Main Blog Archive<br> Meta Robots' , 'wds' ); ?></label>
								</div>
								<div class="fields">
									<fieldset class="wds-fieldset" id="<?php echo esc_attr($_view['option_name']); ?>-main-blog-archive-meta-robots">
										<div class="wds-fieldset-fields-group">
										<?php
											foreach( $meta_robots_main_blog_archive as $item => $label ) {
												$checked = ( ! empty( $_view['options'][$item] ) ) ? "checked='checked' " : '';
												?>
													<p class="group">
														<input class="wds-checkbox wds-checkbox-with-label" value='<?php echo esc_attr($item); ?>' <?php echo $checked; ?> id='<?php echo esc_attr($_view['option_name']); ?>-<?php echo esc_attr($item); ?>' name='<?php echo esc_attr($_view['option_name']); ?>[<?php echo esc_attr($item); ?>]' type='checkbox'>
														<label for="<?php echo esc_attr($_view['option_name']); ?>-<?php echo esc_attr($item); ?>" class="wds-label wds-label-radio wds-label-inline wds-label-inline-right"><?php echo esc_html($label); ?></label>
													</p>
												<?php
											}
										?>
										</div><!-- end wds-fieldset-fields -->
									</fieldset><!-- end wds-fieldset -->
								</div>
								<div class="note"><p><i class="wdv-icon wdv-icon-fw wdv-icon-info-sign"></i> <?php esc_html_e( 'Please note, the Meta Robot settings are only relevant for Homepages that use Static Page.', 'wds' ); ?></p></div>
							</div>
						</div>

					<?php } else { ?>

						<p><?php esc_html_e( 'You seem to be using a static front page. You can tweak its SEO settings using the SmartCrawl metabox in your Page editor.' , 'wds' ); ?></p>

					<?php if ( (int) get_option( 'page_for_posts' ) ) { ?>
						<p><?php esc_html_e( 'You seem to be using a static front page. You can tweak its SEO settings using the SmartCrawl metabox in your Page editor.' , 'wds' ); ?></p>
					<?php } ?>

					<?php } ?>

					</div><!-- end wds-content-tabs-inner -->

				</div>
			</section>

		<?php foreach( get_post_types(array('public' => true)) as $posttype ) {

			if ( in_array( $posttype, array( 'revision', 'nav_menu_item' ) ) ) continue;
			if ( isset( $wds_options['redirectattachment'] ) && $wds_options['redirectattachment'] && $posttype == 'attachment' ) continue;

			$type_obj = get_post_type_object( $posttype );
			if ( ! is_object( $type_obj ) ) continue;

		?>

			<section class="tab">
				<input type="radio" name="tab_onpage_group" id="tab_<?php echo $posttype; ?>">
				<label for="tab_<?php echo $posttype; ?>"><?php echo esc_html($type_obj->labels->name); ?></label>
				<div class="content wds-content-tabs">

					<h2 class="tab-title"><?php echo esc_html($type_obj->labels->name); ?></h2>

					<div class="wds-content-tabs-inner">

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="title-<?php echo $posttype; ?>" class="wds-label"><?php printf( esc_html(__( '%s Title' , 'wds' )), esc_html($type_obj->labels->singular_name) ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<input id='title-<?php echo $posttype; ?>' name='<?php echo esc_attr($_view['option_name']); ?>[title-<?php echo $posttype; ?>]' size='' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['title-' . $posttype]); ?>'>
								</div>
							</div>
						</div>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="metadesc-<?php echo $posttype; ?>" class="wds-label"><?php printf( esc_html(__( '%s Meta Description' , 'wds' )), esc_html($type_obj->labels->singular_name) ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<textarea id='metadesc-<?php echo $posttype; ?>' name='<?php echo esc_attr($_view['option_name']); ?>[metadesc-<?php echo $posttype; ?>]' size='' type='text' class='wds-field'><?php echo esc_textarea($_view['options']['metadesc-' . $posttype]); ?></textarea>
								</div>
							</div>

							<?php
								$this->_render('onpage-og-master', array(
									'for_type' => $posttype,
								));
							?>

						</div>

					</div><!-- end wds-content-tabs-inner -->

				</div>
			</section>

		<?php } ?>

		<?php foreach( get_taxonomies( array( '_builtin' => false ), 'objects' ) as $taxonomy ) { ?>

			<section class="tab">
				<input type="radio" name="tab_onpage_group" id="tab_<?php echo strtolower($taxonomy->name); ?>">
				<label for="tab_<?php echo strtolower($taxonomy->name); ?>"><?php echo esc_html(ucfirst( $taxonomy->label )); ?></label>
				<div class="content wds-content-tabs">

					<h2 class="tab-title"><?php echo ucfirst( esc_html($taxonomy->label) ); ?></h2>

					<div class="wds-content-tabs-inner">

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="title-<?php echo $taxonomy->name; ?>" class="wds-label"><?php printf( esc_html(__( '%s Title' , 'wds')), esc_html(ucfirst( $taxonomy->label )) ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<input id='title-<?php echo $taxonomy->name; ?>' name='<?php echo esc_attr($_view['option_name']); ?>[title-<?php echo $taxonomy->name; ?>]' size='' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['title-' . $taxonomy->name]); ?>'>
								</div>
							</div>
						</div>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="metadesc-<?php echo $taxonomy->name; ?>" class="wds-label"><?php printf( esc_html(__( '%s Meta Description' , 'wds')), esc_html(ucfirst( $taxonomy->label )) ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<textarea id='metadesc-<?php echo $taxonomy->name; ?>' name='<?php echo esc_attr($_view['option_name']); ?>[metadesc-<?php echo $taxonomy->name; ?>]' size='' type='text' class='wds-field'><?php echo esc_textarea($_view['options']['metadesc-' . $taxonomy->name]); ?></textarea>
								</div>
							</div>
						</div>

						<?php
							$this->_render('onpage-og-master', array(
								'for_type' => $taxonomy->name,
							));
						?>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label label-with-options">
									<label for="<?php echo strtolower($taxonomy->label); ?>-meta-robots" class="wds-label"><?php printf( esc_html(__( '%s Meta Robots' , 'wds')), esc_html(ucfirst( $taxonomy->label )) ); ?></label>
								</div>
								<div class="fields">
									<fieldset class="wds-fieldset" id="<?php echo strtolower($taxonomy->label); ?>-meta-robots">
										<div class="wds-fieldset-fields-group">
										<?php
											$meta_robots_taxonomy_name = 'meta_robots_' . str_replace( '-', '_', $taxonomy->name );
											foreach( $$meta_robots_taxonomy_name as $item => $label ) {
												$checked = ( ! empty( $_view['options'][$item] ) ) ? "checked='checked' " : '';
												?>
													<p class="group">
														<input class="wds-checkbox wds-checkbox-with-label" value='<?php echo esc_attr($item); ?>' <?php echo $checked; ?> id='<?php echo esc_attr($_view['option_name']); ?>-<?php echo $taxonomy->name; ?>-<?php echo esc_attr($item); ?>' name='<?php echo esc_attr($_view['option_name']); ?>[<?php echo esc_attr($item); ?>]' type='checkbox'>
														<label for="<?php echo esc_attr($_view['option_name']); ?>-<?php echo $taxonomy->name; ?>-<?php echo esc_attr($item); ?>" class="wds-label wds-label-radio wds-label-inline wds-label-inline-right"><?php echo esc_html($label); ?></label>
													</p>
												<?php
											}
										?>
										</div><!-- end wds-fieldset-fields -->
									</fieldset><!-- end wds-fieldset -->
								</div>
							</div>
						</div>

					</div><!-- end wds-content-tabs-inner -->

				</div>
			</section>

		<?php } ?>

			<section class="tab">
				<input type="radio" name="tab_onpage_group" id="tab_post-categories">
				<label for="tab_post-categories"><?php esc_html_e( 'Post Categories', 'wds' ); ?></label>
				<div class="content wds-content-tabs">
					<h2 class="tab-title"><?php esc_html_e( 'Post Categories', 'wds' ); ?></h2>

					<div class="wds-content-tabs-inner">

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="title-category" class="wds-label"><?php esc_html_e( 'Category Title' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<input id='title-category' name='<?php echo esc_attr($_view['option_name']); ?>[title-category]' size='' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['title-category']); ?>'>
								</div>
							</div>
						</div>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="metadesc-category" class="wds-label"><?php esc_html_e( 'Category Meta Description' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<textarea id='metadesc-category' name='<?php echo esc_attr($_view['option_name']); ?>[metadesc-category]' size='' type='text' class='wds-field'><?php echo esc_textarea($_view['options']['metadesc-category']); ?></textarea>
								</div>
							</div>
						</div>

						<?php
							$this->_render('onpage-og-master', array(
								'for_type' => 'category',
							));
						?>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label label-with-options">
									<label for="<?php echo esc_attr($_view['option_name']); ?>-category-meta-robots" class="wds-label"><?php esc_html_e( 'Category Meta Robots' , 'wds' ); ?>	</label>
								</div>
								<div class="fields">
									<fieldset class="wds-fieldset" id="<?php echo esc_attr($_view['option_name']); ?>-category-meta-robots">
										<div class="wds-fieldset-fields-group">
										<?php
											foreach( $meta_robots_category as $item => $label ) {
												$checked = ( ! empty( $_view['options'][$item] ) ) ? "checked='checked' " : '';
												?>
													<p class="group">
														<input class="wds-checkbox wds-checkbox-with-label" value='<?php echo esc_attr($item); ?>' <?php echo $checked; ?> id='<?php echo esc_attr($_view['option_name']); ?>-<?php echo esc_attr($item); ?>' name='<?php echo esc_attr($_view['option_name']); ?>[<?php echo esc_attr($item); ?>]' type='checkbox'>
														<label for="<?php echo esc_attr($_view['option_name']); ?>-<?php echo esc_attr($item); ?>" class="wds-label wds-label-radio wds-label-inline wds-label-inline-right"><?php echo esc_html($label); ?></label>
													</p>
												<?php
											}
										?>
										</div><!-- end wds-fieldset-fields -->
									</fieldset><!-- end wds-fieldset -->
								</div>
							</div>
						</div>

					</div><!-- end wds-content-tabs-inner -->

				</div>
			</section>

			<section class="tab">
				<input type="radio" name="tab_onpage_group" id="tab_post-tags">
				<label for="tab_post-tags"><?php esc_html_e( 'Post Tags', 'wds' ); ?></label>
				<div class="content wds-content-tabs">
					<h2 class="tab-title"><?php esc_html_e( 'Post Tags', 'wds' ); ?></h2>

					<div class="wds-content-tabs-inner">

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="title-post_tag" class="wds-label"><?php esc_html_e( 'Tag Title' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<input id='title-post_tag' name='<?php echo esc_attr($_view['option_name']); ?>[title-post_tag]' size='' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['title-post_tag']); ?>'>
								</div>
							</div>
						</div>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="metadesc-post_tag" class="wds-label"><?php esc_html_e( 'Tag Meta Description' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<textarea id='metadesc-post_tag' name='<?php echo esc_attr($_view['option_name']); ?>[metadesc-post_tag]' size='' type='text' class='wds-field'><?php echo esc_textarea($_view['options']['metadesc-post_tag']); ?></textarea>
								</div>
							</div>
						</div>

						<?php
							$this->_render('onpage-og-master', array(
								'for_type' => 'post_tag',
							));
						?>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label label-with-options">
									<label for="<?php echo esc_attr($_view['option_name']); ?>-post_tag-meta-robots" class="wds-label"><?php esc_html_e( 'Tag Meta Robots' , 'wds' ); ?>	</label>
								</div>
								<div class="fields">
									<fieldset class="wds-fieldset" id="<?php echo esc_attr($_view['option_name']); ?>-post_tag-meta-robots">
										<div class="wds-fieldset-fields-group">
										<?php
											foreach( $meta_robots_post_tag as $item => $label ) {
												$checked = ( ! empty( $_view['options'][$item] ) ) ? "checked='checked' " : '';
												?>
													<p class="group">
														<input class="wds-checkbox wds-checkbox-with-label" value='<?php echo esc_attr($item); ?>' <?php echo $checked; ?> id='<?php echo esc_attr($_view['option_name']); ?>-<?php echo esc_attr($item); ?>' name='<?php echo esc_attr($_view['option_name']); ?>[<?php echo esc_attr($item); ?>]' type='checkbox'>
														<label for="<?php echo esc_attr($_view['option_name']); ?>-<?php echo esc_attr($item); ?>" class="wds-label wds-label-radio wds-label-inline wds-label-inline-right"><?php echo esc_html($label); ?></label>
													</p>
												<?php
											}
										?>
										</div><!-- end wds-fieldset-fields -->
									</fieldset><!-- end wds-fieldset -->
								</div>
							</div>
						</div>

					</div><!-- end wds-content-tabs-inner -->

				</div>
			</section>

			<section class="tab">
				<input type="radio" name="tab_onpage_group" id="tab_author-archive">
				<label for="tab_author-archive"><?php esc_html_e( 'Author Archive', 'wds' ); ?></label>
				<div class="content wds-content-tabs">
					<h2 class="tab-title"><?php esc_html_e( 'Author Archive', 'wds' ); ?></h2>

					<div class="wds-content-tabs-inner">

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="title-author" class="wds-label"><?php esc_html_e( 'Author Archive Title' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<input id='title-author' name='<?php echo esc_attr($_view['option_name']); ?>[title-author]' size='' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['title-author']); ?>'>
								</div>
							</div>
						</div>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="metadesc-author" class="wds-label"><?php _e( 'Author Archive <br> Meta Description' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<textarea id='metadesc-author' name='<?php echo esc_attr($_view['option_name']); ?>[metadesc-author]' size='' type='text' class='wds-field'><?php echo esc_textarea($_view['options']['metadesc-author']); ?></textarea>
								</div>
							</div>
						</div>

						<?php
							$this->_render('onpage-og-master', array(
								'for_type' => 'author',
							));
						?>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label label-with-options">
									<label for="<?php echo esc_attr($_view['option_name']); ?>-author-meta-robots" class="wds-label"><?php _e( 'Author Archive <br> Meta Robots' , 'wds' ); ?>	</label>
								</div>
								<div class="fields">
									<fieldset class="wds-fieldset" id="<?php echo esc_attr($_view['option_name']); ?>-author-meta-robots">
										<div class="wds-fieldset-fields-group">
										<?php
											foreach( $meta_robots_author as $item => $label ) {
												$checked = ( ! empty( $_view['options'][$item] ) ) ? "checked='checked' " : '';
												?>
													<p class="group">
														<input class="wds-checkbox wds-checkbox-with-label" value='<?php echo esc_attr($item); ?>' <?php echo $checked; ?> id='<?php echo esc_attr($_view['option_name']); ?>-meta_robots-author-<?php echo esc_attr($item); ?>' name='<?php echo esc_attr($_view['option_name']); ?>[<?php echo esc_attr($item); ?>]' type='checkbox'>
														<label for="<?php echo esc_attr($_view['option_name']); ?>-meta_robots-author-<?php echo esc_attr($item); ?>" class="wds-label wds-label-radio wds-label-inline wds-label-inline-right"><?php echo esc_html($label); ?></label>
													</p>
												<?php
											}
										?>
										</div><!-- end wds-fieldset-fields -->
									</fieldset><!-- end wds-fieldset -->
								</div>
							</div>
						</div>

					</div><!-- end wds-content-tabs-inner -->
				</div>
			</section>

			<section class="tab">
				<input type="radio" name="tab_onpage_group" id="tab_date-archive">
				<label for="tab_date-archive"><?php esc_html_e( 'Date Archives', 'wds' ); ?></label>
				<div class="content wds-content-tabs">
					<h2 class="tab-title"><?php esc_html_e( 'Date Archives', 'wds' ); ?></h2>

					<div class="wds-content-tabs-inner">

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="title-date" class="wds-label"><?php esc_html_e( 'Date Archives Title' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<input id='title-date' name='<?php echo esc_attr($_view['option_name']); ?>[title-date]' size='' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['title-date']); ?>'>
								</div>
							</div>
						</div>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="metadesc-date" class="wds-label"><?php _e( 'Date Archives <br> Meta Description' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<textarea id='metadesc-date' name='<?php echo esc_attr($_view['option_name']); ?>[metadesc-date]' size='' type='text' class='wds-field'><?php echo esc_textarea($_view['options']['metadesc-date']); ?></textarea>
								</div>
							</div>
						</div>

						<?php
							$this->_render('onpage-og-master', array(
								'for_type' => 'date',
							));
						?>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label label-with-options">
									<label for="<?php echo esc_attr($_view['option_name']); ?>-date-meta-robots" class="wds-label"><?php _e( 'Date Archives <br> Meta Robots' , 'wds' ); ?>	</label>
								</div>
								<div class="fields">
									<fieldset class="wds-fieldset" id="<?php echo esc_attr($_view['option_name']); ?>-date-meta-robots">
										<div class="wds-fieldset-fields-group">
										<?php
											foreach( $meta_robots_date as $item => $label ) {
												$checked = ( ! empty( $_view['options'][$item] ) ) ? "checked='checked' " : '';
												?>
													<p class="group">
														<input class="wds-checkbox wds-checkbox-with-label" value='<?php echo esc_attr($item); ?>' <?php echo $checked; ?> id='<?php echo esc_attr($_view['option_name']); ?>-meta_robots-date-<?php echo esc_attr($item); ?>' name='<?php echo esc_attr($_view['option_name']); ?>[<?php echo esc_attr($item); ?>]' type='checkbox'>
														<label for="<?php echo esc_attr($_view['option_name']); ?>-meta_robots-date-<?php echo esc_attr($item); ?>" class="wds-label wds-label-radio wds-label-inline wds-label-inline-right"><?php echo esc_html($label); ?></label>
													</p>
												<?php
											}
										?>
										</div><!-- end wds-fieldset-fields -->
									</fieldset><!-- end wds-fieldset -->
								</div>
							</div>
						</div>

					</div><!-- end wds-content-tabs-inner -->

				</div>
			</section>

			<section class="tab">
				<input type="radio" name="tab_onpage_group" id="tab_search-page">
				<label for="tab_search-page"><?php esc_html_e( 'Search Page', 'wds' ); ?></label>
				<div class="content wds-content-tabs">
					<h2 class="tab-title"><?php esc_html_e( 'Search Page', 'wds' ); ?></h2>

					<div class="wds-content-tabs-inner">

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="title-search" class="wds-label"><?php esc_html_e( 'Search Page Title' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<input id='title-search' name='<?php echo esc_attr($_view['option_name']); ?>[title-search]' size='' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['title-search']); ?>'>
								</div>
							</div>
						</div>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="metadesc-search" class="wds-label"><?php esc_html_e( 'Search Page Meta Description' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<textarea id='metadesc-search' name='<?php echo esc_attr($_view['option_name']); ?>[metadesc-search]' size='' type='text' class='wds-field'><?php echo esc_textarea($_view['options']['metadesc-search']); ?></textarea>
								</div>
							</div>
						</div>

						<?php
							$this->_render('onpage-og-master', array(
								'for_type' => 'search',
							));
						?>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label label-with-options">
									<label for="<?php echo esc_attr($_view['option_name']); ?>-search-meta-robots" class="wds-label"><?php _e( 'Search Page <br> Meta Robots' , 'wds' ); ?>	</label>
								</div>
								<div class="fields">
									<fieldset class="wds-fieldset" id="<?php echo esc_attr($_view['option_name']); ?>-search-meta-robots">
										<div class="wds-fieldset-fields-group">
										<?php
											foreach( $meta_robots_search as $item => $label ) {
												$checked = ( ! empty( $_view['options'][$item] ) ) ? "checked='checked' " : '';
												?>
													<p class="group">
														<input class="wds-checkbox wds-checkbox-with-label" value='<?php echo esc_attr($item); ?>' <?php echo $checked; ?> id='<?php echo esc_attr($_view['option_name']); ?>-meta_robots-search-<?php echo esc_attr($item); ?>' name='<?php echo esc_attr($_view['option_name']); ?>[<?php echo esc_attr($item); ?>]' type='checkbox'>
														<label for="<?php echo esc_attr($_view['option_name']); ?>-meta_robots-search-<?php echo esc_attr($item); ?>" class="wds-label wds-label-radio wds-label-inline wds-label-inline-right"><?php echo esc_html($label); ?></label>
													</p>
												<?php
											}
										?>
										</div><!-- end wds-fieldset-fields -->
									</fieldset><!-- end wds-fieldset -->
								</div>
							</div>
						</div>

					</div><!-- end wds-content-tabs-inner -->

				</div>
			</section>

			<section class="tab">
				<input type="radio" name="tab_onpage_group" id="tab_404-page">
				<label for="tab_404-page"><?php esc_html_e( '404 Page', 'wds' ); ?></label>
				<div class="content wds-content-tabs">
					<h2 class="tab-title"><?php esc_html_e( '404 Page', 'wds' ); ?></h2>

					<div class="wds-content-tabs-inner">

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="title-404" class="wds-label"><?php esc_html_e( '404 Page Title' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<input id='title-404' name='<?php echo esc_attr($_view['option_name']); ?>[title-404]' size='' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['title-404']); ?>'>
								</div>
							</div>
						</div>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="metadesc-404" class="wds-label"><?php esc_html_e( '404 Page Description' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<textarea id='metadesc-404' name='<?php echo esc_attr($_view['option_name']); ?>[metadesc-404]' size='' type='text' class='wds-field'><?php echo esc_textarea($_view['options']['metadesc-404']); ?></textarea>
								</div>
							</div>
						</div>

					</div><!-- end wds-content-tabs-inner -->

				</div>
			</section>

		<?php if( function_exists( 'groups_get_groups' ) && ( is_network_admin() || is_main_site() ) ) { ?>
			<section class="tab">
				<input type="radio" name="tab_onpage_group" id="tab_bp-groups">
				<label for="tab_bp-groups"><?php esc_html_e( 'BuddyPress Groups', 'wds' ); ?></label>
				<div class="content">
					<h2 class="tab-title"><?php esc_html_e( 'BuddyPress Groups', 'wds' ); ?></h2>

					<div class="wds-content-tabs-inner">

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="title-bp_groups" class="wds-label"><?php esc_html_e( 'BuddyPress Group Title' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<input id='title-bp_groups' name='<?php echo esc_attr($_view['option_name']); ?>[title-bp_groups]' size='' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['title-bp_groups']); ?>'>
								</div>
							</div>
						</div>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="metadesc-bp_groups" class="wds-label"><?php esc_html_e( 'BuddyPress Group<br> Meta Description' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<textarea id='metadesc-bp_groups' name='<?php echo esc_attr($_view['option_name']); ?>[metadesc-bp_groups]' size='' type='text' class='wds-field'><?php echo esc_textarea($_view['options']['metadesc-bp_groups']); ?></textarea>
								</div>
							</div>
						</div>

					</div><!-- end wds-content-tabs-inner -->

				</div>
			</section>
		<?php } ?>

		<?php if( defined( 'BP_VERSION' ) && ( is_network_admin() || is_main_site() ) ) { ?>
			<section class="tab">
				<input type="radio" name="tab_onpage_group" id="tab_bp-profile">
				<label for="tab_bp-profile"><?php esc_html_e( 'BuddyPress Profile', 'wds' ); ?></label>
				<div class="content wds-content-tabs">
					<h2 class="tab-title"><?php esc_html_e( 'BuddyPress Profile', 'wds' ); ?></h2>

					<div class="wds-content-tabs-inner">

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="title-bp_profile" class="wds-label"><?php esc_html_e( 'BuddyPress Profile Title' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<input id='title-bp_profile' name='<?php echo esc_attr($_view['option_name']); ?>[title-bp_profile]' size='' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['title-bp_profile']); ?>'>
								</div>
							</div>
						</div>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="metadesc-bp_profile" class="wds-label"><?php _e( 'BuddyPress Profile<br> Meta Description' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<textarea id='metadesc-bp_profile' name='<?php echo esc_attr($_view['option_name']); ?>[metadesc-bp_profile]' size='' type='text' class='wds-field'><?php echo esc_textarea($_view['options']['metadesc-bp_profile']); ?></textarea>
								</div>
							</div>
						</div>

					</div><!-- end wds-content-tabs-inner -->

				</div>
			</section>
		<?php } ?>

		<?php if( class_exists( 'MarketPress_MS' ) && ( is_network_admin() || is_main_site() ) ) { ?>
			<section class="tab">
				<input type="radio" name="tab_onpage_group" id="tab-marketpress">
				<label for="tab-marketpress"><?php esc_html_e( 'MarketPress', 'wds' ); ?></label>
				<div class="content wds-content-tabs">
					<h2 class="tab-title"><?php esc_html_e( 'MarketPress', 'wds' ); ?></h2>

					<div class="wds-content-tabs-inner">

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="title-mp_marketplace-base" class="wds-label"><?php esc_html_e( 'Marketplace Base Title' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<input id='title-mp_marketplace-base' name='<?php echo esc_attr($_view['option_name']); ?>[title-mp_marketplace-base]' size='' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['title-mp_marketplace-base']); ?>'>
								</div>
							</div>
						</div>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label label-long">
									<label for="metadesc-mp_marketplace-base" class="wds-label"><?php _e( 'Marketplace Base<br> Meta Description' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<textarea id='metadesc-mp_marketplace-base' name='<?php echo esc_attr($_view['option_name']); ?>[metadesc-mp_marketplace-base]' size='' type='text' class='wds-field'><?php echo esc_textarea($_view['options']['metadesc-mp_marketplace-base']); ?></textarea>
								</div>
							</div>
						</div>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label label-long">
									<label for="title-mp_marketplace-categories" class="wds-label"><?php _e( 'Marketplace Categories<br> Title' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<input id='title-mp_marketplace-categories' name='<?php echo esc_attr($_view['option_name']); ?>[title-mp_marketplace-categories]' size='' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['title-mp_marketplace-categories']); ?>'>
								</div>
							</div>
						</div>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="metadesc-mp_marketplace-categories" class="wds-label"><?php _e( 'Marketplace Categories<br> Meta Description' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<textarea id='metadesc-mp_marketplace-categories' name='<?php echo esc_attr($_view['option_name']); ?>[metadesc-mp_marketplace-categories]' size='' type='text' class='wds-field'><?php echo esc_textarea($_view['options']['metadesc-mp_marketplace-categories']); ?></textarea>
								</div>
							</div>
						</div>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label label-long">
									<label for="title-mp_marketplace-tags" class="wds-label"><?php _e( 'Marketplace Tags<br> Title' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<input id='title-mp_marketplace-tags' name='<?php echo esc_attr($_view['option_name']); ?>[title-mp_marketplace-tags]' size='' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['title-mp_marketplace-tags']); ?>'>
								</div>
							</div>
						</div>

						<div class="wds-table-fields-group">
							<div class="wds-table-fields">
								<div class="label">
									<label for="metadesc-mp_marketplace-tags" class="wds-label"><?php _e( 'Marketplace Tags<br> Meta Description' , 'wds' ); ?></label>
								</div>
								<div class="fields wds-allow-macros">
									<textarea id='metadesc-mp_marketplace-tags' name='<?php echo esc_attr($_view['option_name']); ?>[metadesc-mp_marketplace-tags]' size='' type='text' class='wds-field'><?php echo esc_textarea($_view['options']['metadesc-mp_marketplace-tags']); ?></textarea>
								</div>
							</div>
						</div>

					</div><!-- end wds-content-tabs-inner -->

				</div>
			</section>
		<?php } ?>

		</div><!-- end page-title-meta-tabs -->

		<div class="row">
			<div class="wds-block-section wds-block-section-space-vtabs wds-block-section-space-vtabs-left">
				<h2 class="wds-block-section-title"><?php esc_html_e('Title & Meta Example', 'wds'); ?></h2>
				<?php
					$this->_render('onpage-preview', array(
						'link' => home_url(),
						'title' => wds_replace_vars($wds_options['title-home'], array()),
						'description' => wds_replace_vars($wds_options['metadesc-home'], array()),
					));
				?>
			</div>
		</div>

		<div class="block-section-footer buttons">
			<input name='submit' type='submit' class='button button-cta-alt' value='<?php echo esc_attr( __( 'Save Settings' , 'wds') ); ?>'>
		</div>

	</form>

	<?php // echo $additional; ?>

<?php

	} else {
		printf( __( "You've chosen not to set up '%s', please move onto next step.", 'wds' ), __( 'Title & Meta' , 'wds' ) );
	}

?>

</div><!-- end wds-page-onpage -->
