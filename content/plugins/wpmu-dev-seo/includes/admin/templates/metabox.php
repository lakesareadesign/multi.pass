<?php

$date = '';
if ( $post->post_type == 'post' ) {
	if ( isset( $post->post_date ) ) {
		$date = date( 'M j, Y', strtotime( $post->post_date ) ); } else { 		$date = date( 'M j, Y' ); }
}

?>

<table class="widefat">

<?php

	$title = smartcrawl_get_value( 'title' );
if ( empty( $title ) ) {
	$title = $post->post_title; }
if ( empty( $title ) ) {
	$title = __( 'temp title', 'wds' ); }

	$desc = smartcrawl_get_value( 'metadesc' );
if ( empty( $desc ) ) {
	$desc = substr( strip_tags( $post->post_content ), 0, 130 ); }
if ( empty( $desc ) ) {
	$desc = __( 'temp description', 'wds' ); }

	$slug = $post->post_name;
if ( empty( $slug ) ) {
	$slug = sanitize_title( $title ); }

?>

<?php if ( apply_filters( 'wds-metabox-visible_parts-preview_area', true ) ) { ?>
	<tr>
		<th><label><?php esc_html_e( 'Preview:', 'wds' ); ?></label></th>
		<td>
		<?php
			$video = smartcrawl_get_value( 'video_meta',$post->ID );
		if ( $video && $video != 'none' ) {
		?>
		<div id="snippet" class="video">
			<h4 style="margin:0;font-weight:normal;"><a class="title" href="#"><?php echo esc_html( $title ); ?></a></h4>
			<div style="margin:5px 10px 10px 0;width:82px;height:62px;float:left;">
				<img style="border: 1px solid blue;padding: 1px;width:80px;height:60px;" src="<?php echo esc_url( $video['thumbnail_loc'] ); ?>"/>
				<div style="margin-top:-23px;margin-right:4px;text-align:right"><img src="http://www.google.com/images/icons/sectionized_ui/play_c.gif" alt="" border="0" height="20" style="-moz-opacity:.88;filter:alpha(opacity=88);opacity:.88" width="20"></div>
			</div>
			<div style="float:left;width:440px;">
				<p style="color:#767676;font-size:13px;line-height:15px;"><?php echo esc_html( number_format( $video['duration'] / 60 ) ); ?> <?php esc_html_e( 'mins', 'wds' ); ?> - <?php echo esc_html( $date ); ?></p>
				<p style="color:#000;font-size:13px;line-height:15px;" class="desc"><span><?php echo esc_html( $desc ); ?></span></p>
				<a href="#" class="url"><?php echo esc_html( str_replace( 'http://','',get_bloginfo( 'url' ) ) ); ?>/<?php echo esc_html( $slug ); ?>/</a> - <a href="#" class="util"><?php esc_html_e( 'More videos &raquo;', 'wds' ); ?></a>
			</div>
		</div>

		<?php
		} else {

			if ( ! empty( $date ) ) {
				$date .= ' ... ';
			}

			?>
			<div id="snippet">
				<p><a style="color:#2200C1;font-weight:medium;font-size:16px;text-decoration:underline;" href="#"><?php echo esc_html( $title ); ?></a></p>
				<p style="font-size: 12px; color: #000; line-height: 15px;"><?php echo esc_html( $date ); ?><span><?php echo esc_html( $desc ); ?></span></p>
				<p>
					<a href="#" style="font-size: 13px; color: #282; line-height: 15px;" class="url"><?php echo esc_html( str_replace( 'http://','',get_bloginfo( 'url' ) ) ); ?>/<?php echo esc_html( $slug ); ?>/</a> - <a href="#" class="util"><?php esc_html_e( 'Cached', 'wds' ); ?></a> - <a href="#" class="util"><?php esc_html_e( 'Similar', 'wds' ); ?></a>
					<?php if ( is_multisite() && (is_admin() || is_network_admin()) && class_exists( 'domain_map' ) ) { ?>
								<small style="opacity:.5"><i><?php esc_html_e( __( 'The URL preview may be thwarted by domain mapping', 'wds' ) ); ?></i></small>
							<?php } ?>
				</p>
			</div>
			<?php
		}
		?>

		</td>
	</tr>
<?php } ?>

<?php
	$title_placeholder = smartcrawl_get_seo_title();
if ( ! $title_placeholder ) { $title_placeholder = ''; }

	$desc_placeholder = smartcrawl_get_seo_desc();
if ( ! $desc_placeholder ) { $desc_placeholder = ''; }
?>

<?php if ( apply_filters( 'wds-metabox-visible_parts-focus_area', true ) ) { ?>
	<tr>
		<th valign='top'><label for='wds_focus'><?php esc_html_e( 'Focus keywords' , 'wds' ); ?></label></th>
		<td valign='top'>
			<input type='text' class='widefat' id='wds_focus' name='wds_focus' value='<?php echo esc_html( smartcrawl_get_value( 'focus-keywords' ) ); ?>' class='wds' /><br />
		</td>
	</tr>
<?php } ?>

<?php if ( apply_filters( 'wds-metabox-visible_parts-title_area', true ) ) { ?>
	<tr>
		<th valign='top'><label for='wds_title'><?php esc_html_e( 'Title Tag' , 'wds' ); ?></label></th>
		<td valign='top'>
			<input type='text' class='widefat' id='wds_title' placeholder='<?php echo esc_html( $title_placeholder ); ?>' name='wds_title' value='<?php echo esc_html( smartcrawl_get_value( 'title' ) ); ?>' class='wds' />
			<p>
				<?php printf( esc_html( __( 'Up to %d characters recommended' , 'wds' ) ), SMARTCRAWL_TITLE_LENGTH_CHAR_COUNT_LIMIT ); ?>
			</p>
		</td>
	</tr>
<?php } ?>

<?php if ( apply_filters( 'wds-metabox-visible_parts-description_area', true ) ) { ?>
	<tr>
		<th valign='top'><label for='wds_metadesc'><?php esc_html_e( 'Meta Description' , 'wds' ); ?></label></th>
		<td valign='top'>
			<textarea rows='2' class='widefat' name='wds_metadesc' placeholder='<?php echo esc_html( $desc_placeholder ); ?>' id='wds_metadesc' class='wds'><?php echo esc_html( smartcrawl_get_value( 'metadesc' ) ); ?></textarea>
			<p>
				<?php printf( esc_html( __( '%d characters maximum' , 'wds' ) ), SMARTCRAWL_METADESC_LENGTH_CHAR_COUNT_LIMIT ); ?>
			</p>
		</td>
	</tr>
<?php } ?>

<?php if ( apply_filters( 'wds-metabox-visible_parts-keywords_area', true ) ) { ?>
	<tr>
		<th valign='top'><label for='wds_keywords'><?php esc_html_e( 'Meta keywords' , 'wds' ); ?></label></th>
		<td valign='top'>
			<input type='text' class='widefat' id='wds_keywords' name='wds_keywords' value='<?php echo esc_html( smartcrawl_get_value( 'keywords' ) ); ?>' class='wds' /><br />
			<label for="wds_tags_to_keywords"><?php esc_html_e( 'I want to use post tags in addition to my keywords', 'wds' ); ?></label>
			<input type='checkbox' name='wds_tags_to_keywords' id='wds_tags_to_keywords' value='1' <?php echo esc_attr( smartcrawl_get_value( 'tags_to_keywords' ) ) ? 'checked="checked"' : ''; ?> />
			<div>
				<b><?php esc_html_e( 'News Keywords', 'wds' ); ?></b> <a href="http://support.google.com/news/publisher/bin/answer.py?hl=en&answer=68297" target="_blank">(?)</a>
			</div>
			<input type='text' class='widefat' id='wds_news_keywords' name='wds_news_keywords' value='<?php echo esc_attr( smartcrawl_get_value( 'news_keywords' ) ); ?>' class='wds' />
			<p>
				<?php esc_html_e( 'Separate keywords with commas' , 'wds' ); ?><br />
				<?php esc_html_e( 'If you enable using tags, post tags will be merged in with any other keywords you enter in the text box.', 'wds' ); ?>
			</p>
		</td>
	</tr>
<?php } ?>

<?php if ( apply_filters( 'wds-metabox-visible_parts-robots_area', true ) ) { ?>
	<tr>
		<th valign='top'><label for='wds_robots_follow'><?php esc_html_e( 'Meta Robots' , 'wds' ); ?></label></th>
		<td>
			<table class='wds_subtable' broder='0'>
				<tr>
					<th valign='top'><label for='wds_robots_follow'><?php esc_html_e( 'Index' , 'wds' ); ?></label></th>
					<td valign='top'>
						<input type="radio" name="wds_meta-robots-noindex" id="wds_meta-robots-noindex-index" <?php echo ( ! $ri_value ? 'checked="checked"' : ''); ?> value="0" />
						<label for="wds_meta-robots-noindex-index"><?php esc_html_e( 'Index' , 'wds' ); ?></label><br />
						<input type="radio" name="wds_meta-robots-noindex" id="wds_meta-robots-noindex-noindex" <?php echo ($ri_value ? 'checked="checked"' : ''); ?> value="1" />
						<label for="wds_meta-robots-noindex-noindex"><?php esc_html_e( 'Noindex' , 'wds' ); ?></label>
					</td>
				</tr>
				<tr>
					<th valign='top'><label for='wds_robots_follow'><?php esc_html_e( 'Follow' , 'wds' ); ?></label></th>
					<td valign='top'>
						<input type="radio" name="wds_meta-robots-nofollow" id="wds_meta-robots-nofollow-follow" <?php echo ( ! $rf_value ? 'checked="checked"' : ''); ?> value="0" />
						<label for="wds_meta-robots-nofollow-follow"><?php esc_html_e( 'Follow' , 'wds' ); ?></label><br />
						<input type="radio" name="wds_meta-robots-nofollow" id="wds_meta-robots-nofollow-nofollow" <?php echo ($rf_value ? 'checked="checked"' : ''); ?> value="1" />
						<label for="wds_meta-robots-nofollow-nofollow"><?php esc_html_e( 'Nofollow' , 'wds' ); ?></label>
					</td>
				</tr>
				<tr>
					<th valign='top'><label for='wds_meta-robots-adv'><?php esc_html_e( 'Advanced' , 'wds' ); ?></label></th>
					<td valign='top'>
						<?php

						foreach ( $advanced as $rkey => $rlbl ) {
							$checked = in_array( $rkey, $adv_value ) ? 'checked="checked"' : '';
							?>
							<input type='hidden' name='wds_meta-robots-adv[<?php echo esc_attr( $rkey ); ?>]' value='' />
							<input type='checkbox' name='wds_meta-robots-adv[<?php echo esc_attr( $rkey ); ?>]' value='<?php echo esc_attr( $rkey ); ?>' id='wds_meta-robots-adv-<?php echo esc_attr( $rkey ); ?>' <?php echo $checked; ?> />&nbsp;
							<label for="wds_meta-robots-adv-<?php echo esc_attr( $rkey ); ?>"><?php echo esc_html( $rlbl ); ?></label><br />
							<?php
						}

						?>
					</td>
				</tr>
			</table>
			<p>
				<?php _e( '<code>meta</code> robots settings for this page.', 'wds' ); ?>
			</p>
		</td>
	</tr>
<?php } ?>

<?php if ( apply_filters( 'wds-metabox-visible_parts-canonical_area', true ) ) { ?>
	<tr>
		<th valign='top'><label for='wds_canonical'><?php esc_html_e( 'Canonical URL' , 'wds' ); ?></label></th>
		<td valign='top'>
			<input type='text' id='wds_canonical' name='wds_canonical' value='<?php echo esc_attr( smartcrawl_get_value( 'canonical' ) ); ?>' class='wds' />
		</td>
	</tr>
<?php } ?>

<?php if ( apply_filters( 'wds-metabox-visible_parts-redirect_area', true ) ) { ?>
	<?php

	if ( user_can_see_seo_metabox_301_redirect() ) {
		?>

			<tr>
				<th valign='top'><label for='wds_redirect'><?php esc_html_e( '301 Redirect' , 'wds' ); ?></label></th>
				<td valign='top'>
					<input type='text' id='wds_redirect' name='wds_redirect' value='<?php echo esc_attr( smartcrawl_get_value( 'redirect' ) ); ?>' class='wds' />
				</td>
			</tr>

		<?php
	}

	?>
<?php } ?>

<?php if ( apply_filters( 'wds-metabox-visible_parts-sitemap_priority_area', true ) ) { ?>
	<tr>
		<th valign='top'><label for='wds_sitemap-priority'><?php esc_html_e( 'Sitemap Priority' , 'wds' ); ?></label></th>
		<td valign='top'>
			<select name='wds_sitemap-priority' id='wds_sitemap-priority'>

			<?php
				$value = smartcrawl_get_value( 'sitemap-priority' );

			foreach ( $options as $key => $label ) {
				?>

				<option value='<?php echo esc_attr( $key ); ?>' <?php echo (($key == $value) ? 'selected="selected"' : ''); ?>><?php echo esc_html( $label ); ?></option>

				<?php

			}
			?>

			</select>
			<p>
				<?php esc_html_e( 'The priority given to this page in the XML sitemap.', 'wds' ); ?>
			</p>
		</td>
	</tr>
<?php } ?>

<?php
	$og = smartcrawl_get_value( 'opengraph' );
if ( ! is_array( $og ) ) { $og = array(); }

	$og = wp_parse_args($og, array(
		'title' => false,
		'description' => false,
		'images' => false,
	));
?>
	<tr>
		<th>
			<label for="og-title"><?php esc_html_e( 'OpenGraph Title', 'wds' ); ?></label>
		</th>
		<td>
			<input type="text" class="widefat"
				id="og-title" name="wds-opengraph[title]"
				value="<?php echo esc_attr( $og['title'] ); ?>" />
		</td>
	</tr>
	<tr>
		<th>
			<label for="og-description"><?php esc_html_e( 'OpenGraph Description', 'wds' ); ?></label>
		</th>
		<td>
			<textarea class="widefat" name="wds-opengraph[description]"
				id="og-description"><?php echo esc_textarea( $og['description'] ); ?></textarea>
		</td>
	</tr>
	<tr>
		<th>
			<label for="og-images"><?php esc_html_e( 'OpenGraph Images', 'wds' ); ?></label>
		</th>
		<td
			class="fields og-images"
			data-name='wds-opengraph[og-images]'
		>
			<div class="add-action-wrapper item">
				<a href="#add" title="<?php esc_attr_e( 'Add image', 'wds' ); ?>">+</a>
			</div>
		<?php if ( ! empty( $og['images'] ) && is_array( $og['images'] ) ) { foreach ( $og['images'] as $img ) { ?>
			<input type="text" class="widefat"
				name="wds-opengraph[images][]"
				value="<?php echo esc_attr( $img ); ?>" />
		<?php }
} ?>
		</td>
	</tr>

</table>

<?php do_action( 'wds-editor-metabox-after', $post ); ?>