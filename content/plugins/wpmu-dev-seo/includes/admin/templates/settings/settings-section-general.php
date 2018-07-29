<?php
/**
 * Settings general section template
 *
 * @package wpmu-dev-seo
 */

$sitemap_option_name = empty( $sitemap_option_name ) ? '' : $sitemap_option_name;
$verification_pages = empty( $verification_pages ) ? array() : $verification_pages;
$smartcrawl_options = Smartcrawl_Settings::get_options();
$sitemap_options = Smartcrawl_Settings::get_component_options( Smartcrawl_Settings::COMP_SITEMAP );
$plugin_modules = empty( $plugin_modules ) ? array() : $plugin_modules;
?>

<?php
$this->_render( 'toggle-group', array(
	'label'       => __( 'Plugin Modules', 'wds' ),
	'description' => __( 'Choose which modules you would like to activate.', 'wds' ),
	'items'       => $plugin_modules,
) );
?>

<?php if ( is_multisite() && is_network_admin() ) : ?>
	<input type="hidden" name="<?php echo esc_attr( $_view['option_name'] ); ?>[save_blog_tabs]" value="1"/>
	<div class="wds-table-fields wds-separator-top">
		<div class="label">
			<label class="wds-label"><?php esc_html_e( 'Site Owner Permissions', 'wds' ); ?></label>
			<p class="wds-label-description">
				<?php esc_html_e( 'Use this section to choose what sections of this plugin will be accessible to Site Admins on your Network.', 'wds' ); ?>
			</p>
		</div>

		<div class="fields">
			<div class="wds-toggle-table">
				<span class="toggle wds-toggle">
					<input type="checkbox"
					       class="toggle-checkbox"
					       value="yes"
					       name="<?php echo esc_attr( $_view['option_name'] ); ?>[wds_sitewide_mode]"
					       id="wds_sitewide_mode"
						<?php echo isset( $wds_sitewide_mode ) ? checked( $wds_sitewide_mode, true, false ) : ''; ?>
					/>
					<label class="toggle-label" for="wds_sitewide_mode"></label>
				</span>

				<div class="wds-toggle-description">
					<label
						class="wds-label"
						for="wds_sitewide_mode"><?php esc_html_e( 'Sitewide mode (network level changes only)', 'wds' ); ?>
					</label>
				</div>
			</div>
			<?php
			foreach ( $slugs as $item => $label ) {
				$checked = ( ! empty( $blog_tabs[ $item ] ) ) ? 'checked' : '';
				$presence_slug = preg_replace( '/^wds_/', '', $item );
				?>
				<div class="wds-toggle-table">
				<span class="toggle wds-toggle">
					<input type="checkbox"
					       class="toggle-checkbox"
					       value="yes"
					       data-prereq="<?php echo esc_attr( $presence_slug ); ?>"
					       name="<?php echo esc_attr( $_view['option_name'] ); ?>[wds_blog_tabs][<?php echo esc_attr( $item ); ?>]"
					       id="wds_blog_tabs-<?php echo esc_attr( $item ); ?>"
						<?php echo esc_attr( $checked ); ?>
					/>
					<label class="toggle-label" for="wds_blog_tabs-<?php echo esc_attr( $item ); ?>"></label>
				</span>
					<div class="wds-toggle-description">
						<label class="wds-label"
						       for="wds_blog_tabs-<?php echo esc_attr( $item ); ?>"><?php echo esc_html( $label ); ?></label>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
<?php endif; ?>

<?php
$this->_render( 'toggle-group', array(
	'label'       => esc_html__( 'Builtin modules', 'wds' ),
	'description' => esc_html__( 'Choose which modules you would like to activate.', 'wds' ),
	'separator'   => true,
	'items'       => array(
		'analysis-seo'         => array(
			'label'       => esc_html__( 'Page Analysis', 'wds' ),
			'description' => esc_html__( 'Analyses your content against recommend SEO practice and gives recommendations for improvement to make sure content is as optimized as possible.', 'wds' ),
		),
		'analysis-readability' => array(
			'label'       => esc_html__( 'Readability analysis', 'wds' ),
			'description' => esc_html__( 'Benchmarks the readability of your content for the average visitor and gives recommendations for improvement.', 'wds' ),
		),
		'extras-admin_bar'     => array(
			'label'       => esc_html__( 'Admin Bar', 'wds' ),
			'description' => esc_html__( 'Adds a shortcut to SmartCrawl in the WP Admin bar at the top of your screen.', 'wds' ),
		),
	),
) );
?>

<?php
$this->_render( 'toggle-group', array(
	'label'       => __( 'Meta Tags', 'wds' ),
	'description' => __( 'Choose what SmartCrawl modules you want available to use.', 'wds' ),
	'separator'   => true,
	'items'       => array(
		'general-suppress-generator'           => array(
			'label'       => __( 'Hide generator meta tag', 'wds' ),
			'description' => __( 'It can be considered a security risk to have your WordPress version visible to the public, so we recommend you hide it.', 'wds' ),
		),
		'general-suppress-redundant_canonical' => array(
			'label'       => __( 'Hide redundant canonical link tags', 'wds' ),
			'description' => __( 'WordPress automatically generates a canonical tag for your website, but in many cases this isn’t needed so you can turn it off to avoid any potential SEO ‘duplicate content’ backlash from search engines.', 'wds' ),
		),
		'metabox-lax_enforcement'              => array(
			'label'       => __( 'Enforce meta tag character limits', 'wds' ),
			'description' => __( 'Each meta tag type has recommended maximum characters lengths to follow. Turning this off will remove the enforcement preventing you from adding too many characters.', 'wds' ),
		),
	),
) );
?>

<div class="wds-table-fields wds-separator-top">
	<div class="label">
		<label class="wds-label"><?php esc_html_e( 'Search engines', 'wds' ); ?></label>
		<p class="wds-label-description"><?php esc_html_e( 'This tool will add the meta tags required by search engines to verify your site with their SEO management tools to your websites <head> tag.', 'wds' ); ?></p>
	</div>
	<div class="fields">
		<?php
		$value = isset( $sitemap_options['verification-google-meta'] ) ? $sitemap_options['verification-google-meta'] : '';
		?>
		<label for="verification-google" class="wds-label"><?php esc_html_e( 'Google Verification', 'wds' ); ?></label>
		<div class="wds-label-description">
			<?php esc_html_e( 'Paste the full meta tag from Google. The value looks like this:', 'wds' ); ?>
			<pre
				class="wds-meta-tags-example"><?php echo esc_html( '<meta name="google-site-verification" content="+nxGUDJ4QpAZ5l9Bsjdi102tLVC21AIh5d1Nl23908vVuFHs34=" />' ); ?></pre>
		</div>
		<input
			id='verification-google'
			name='<?php echo esc_attr( $_view['option_name'] ); ?>[verification-google-meta]'
			type='text'
			class='wds-field'
			value='<?php echo esc_attr( $value ); ?>'>

		<?php
		$value = isset( $sitemap_options['verification-bing-meta'] ) ? $sitemap_options['verification-bing-meta'] : '';
		?>
		<label for="verification-bing" class="wds-label"><?php esc_html_e( 'Bing Verification', 'wds' ); ?></label>
		<div class="wds-label-description">
			<?php esc_html_e( 'Paste the full meta tag from Bing. The value looks like this:', 'wds' ); ?>
			<pre
				class="wds-meta-tags-example"><?php echo esc_html( '<meta name="msvalidate.01" content="J3P85HC9105H840J1U8117603269HA13" />' ); ?></pre>
		</div>
		<input
			id='verification-bing'
			name='<?php echo esc_attr( $_view['option_name'] ); ?>[verification-bing-meta]'
			type='text'
			class='wds-field'
			value='<?php echo esc_attr( $value ); ?>'>

		<label for="verification-pages"
		       class="wds-label"><?php esc_html_e( 'Add verification code to', 'wds' ); ?></label>
		<select id="verification-pages"
		        name="<?php echo esc_attr( $_view['option_name'] ); ?>[verification-pages]"
		        class="select-container"
		        style="width: 100%;">
			<?php foreach ( $verification_pages as $item => $label ) : ?>
				<?php
				$selected = isset( $sitemap_options['verification-pages'] ) && $sitemap_options['verification-pages'] === $item ? 'selected' : '';
				?>
				<option
					value="<?php echo esc_attr( $item ); ?>"
					<?php echo esc_attr( $selected ); ?>>
					<?php echo esc_html( $label ); ?>
				</option>
			<?php endforeach; ?>
		</select>

		<div class="wds-custom-meta-tags">
			<label for="verification-google" class="wds-label"><?php esc_html_e( 'Custom meta tags', 'wds' ); ?></label>
			<p class="wds-label-description"><?php esc_html_e( 'Have more meta tags you want to add? Add as many as you like.', 'wds' ); ?></p>

			<?php if ( ! empty( $sitemap_options['additional-metas'] ) && is_array( $sitemap_options['additional-metas'] ) ) : ?>
				<?php
				foreach ( $sitemap_options['additional-metas'] as $custom_value ) {
					$this->_render( 'settings/settings-custom-meta-tag', array(
						'value' => $custom_value,
					) );
				}
				?>
			<?php endif; ?>

			<?php $this->_render( 'settings/settings-custom-meta-tag' ); ?>

			<button type="button"
			        class="button button-dark button-dark-o"><?php esc_html_e( 'Add Another', 'wds' ); ?></button>
		</div>
	</div>
</div>