<?php
/**
 * Class: WD_Plugin_Theme_Version
 */

/**
 * @author: Hoang Ngo
 */
class WD_Plugin_Theme_Version extends WD_Hardener_Abstract {
	public function on_creation() {
		$this->id         = 'wp_plugin_theme_version';
		$this->title      = esc_html__( 'Update plugins & themes to latest versions', wp_defender()->domain );
		$this->can_revert = true;

		$this->add_action( 'admin_footer', 'print_scripts' );
		$this->add_ajax_action( 'wd_get_plugin_changelog', 'get_changelog' );
		$this->add_ajax_action( 'wd_listen_pt_version', 'listen_pt_version' );
		$this->add_ajax_action( 'wd_update_theme', 'update_theme' );
		$this->add_action( 'upgrader_process_complete', 'submit_to_api_when_things_updated', 10, 2 );
	}

	public function submit_to_api_when_things_updated() {
		WD_Utils::flag_for_submitting();
	}

	/**
	 * @return bool
	 */
	public function check() {
		if ( count( $this->get_plugins_outdate() ) || count( $this->get_themes_outdate() ) ) {
			$last_submission = get_site_option( $this->id . 'last_submission' );
			if ( $last_submission != false ) {
				delete_site_option( $this->id . 'last_submission' );
				WD_Utils::flag_for_submitting();
			}

			return false;
		}

		$last_submission = get_site_option( $this->id . 'last_submission' );
		if ( $last_submission == false ) {
			WD_Utils::flag_for_submitting();
			update_site_option( $this->id . 'last_submission', time() );
		}

		return true;
	}

	public function process() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! $this->verify_nonce( 'remove_readme_file' ) ) {
			return;
		}

	}

	/**
	 * We will need to check which plugins outdate and return a list
	 * @return array
	 */
	public function get_plugins_outdate() {
		$plugins = get_site_transient( 'update_plugins' );

		$need_update = array();
		if ( is_object( $plugins ) ) {
			foreach ( (array) $plugins->response as $key => $plugin ) {
				$data = get_plugin_data( WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $key );
				if ( version_compare( $data['Version'], $plugin->new_version ) == - 1 ) {
					//this case, the version lower than newest
					//this is for wpmudev plugin
					$update_notices = property_exists( $plugin, 'upgrade_notice' ) === true ? $plugin->upgrade_notice : null;
					if ( ! is_array( $update_notices ) ) {
						$update_notices = preg_split( '/<br[^>]*>/i', $update_notices );
					}
					//we only need a strip version
					if ( is_array( $update_notices ) && count( $update_notices ) ) {
						$update_notices = array_shift( $update_notices );
						$update_notices = strip_tags( $update_notices );
						$update_notices = wp_trim_words( $update_notices, apply_filters( $this->id . '/truncate_length', 15 ) );
					}
					$need_update[] = array(
						'name'           => $data['Name'],
						'new_version'    => $plugin->new_version,
						'version'        => $data['Version'],
						'slug'           => $plugin->slug,
						'base'           => $key,
						'update_notices' => $update_notices
					);
				}
			}
		}

		return $need_update;
	}

	/**
	 * This will get the outdate theme
	 * //todo for now, it only can get from wp repo, need to extend it later
	 */
	public function get_themes_outdate() {
		$themes = get_site_transient( 'update_themes' );

		$need_update = array();
		if ( is_object( $themes ) ) {
			foreach ( (array) $themes->response as $key => $theme ) {
				$data = wp_get_theme( $key );
				if ( version_compare( $data->Version, $theme['new_version'] ) == - 1 ) {
					$need_update[] = array(
						'name'        => $data['Name'],
						'new_version' => $theme['new_version'],
						'version'     => $data['Version'],
						'base'        => $key,
						//'update_notices' => $update_notices
					);

				}
			}
		}

		return $need_update;
	}

	/**
	 * @param $slug
	 * @param $base
	 */
	protected function get_plugin_changelog( $slug, $base ) {
		$url = "http://api.wordpress.org/plugins/info/1.0/" . $slug;
		if ( $ssl = wp_http_supports( array( 'ssl' ) ) ) {
			$url = set_url_scheme( $url, 'https' );
		}
		$raw_response = wp_remote_get( $url );
		if ( is_wp_error( $raw_response ) || 200 != wp_remote_retrieve_response_code( $raw_response ) ) {
			return;
		}

		$response = maybe_unserialize( wp_remote_retrieve_body( $raw_response ) );
		//data found on repo
		if ( is_object( $response ) ) {
			$changelog = $response->sections['changelog'];
			/**
			 * the changelog struct will he someting like <h4>version</h4><ul><li></>
			 */
			$pattern = '~<ul>(.*?)</ul>~s';
			preg_match_all( $pattern, $changelog, $matches );
			$latest_changlog = '';
			if ( isset( $matches[1] ) && count( $matches[1] ) ) {
				$latest_changlog = array_shift( $matches[1] );
				//cleanup
				preg_match_all( '~<li>(.*?)</li>~s', $latest_changlog, $matches );
				if ( isset( $matches[1] ) && count( $matches[1] ) ) {
					//we only get first line
					$logs = $matches[1];

					return wp_trim_words( array_shift( $logs ), apply_filters( $this->id . '/truncate_length', 15 ) );
				}
			}
		}

		return esc_html__( "N/A", wp_defender()->domain );
	}

	public function get_theme_changelog( $slug, $base ) {
		$raw_response = wp_remote_post(
			'http://api.wordpress.org/themes/info/1.0/',
			array(
				'body' => array(
					'action'  => 'theme_information',
					'request' => serialize( (object) array(
						'slug'   => $slug,
						'fields' => array(
							'description' => true
						)
					) )
				)
			)
		);

		if ( is_wp_error( $raw_response ) || 200 != wp_remote_retrieve_response_code( $raw_response ) ) {
			return;
		}

		$response = maybe_unserialize( wp_remote_retrieve_body( $raw_response ) );
	}

	/**
	 * Ajax function, to getting plugin change logs
	 */
	public function get_changelog() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! $this->verify_nonce( 'wd_get_plugin_changelog' ) ) {
			return;
		}

		$data = isset( $_POST['data'] ) ? $_POST['data'] : array();
		if ( empty( $data ) ) {
			return;
		}

		$ret = array();

		foreach ( $data as $item ) {
			$slug = $item['slug'];
			$type = $item['type'];
			$base = $item['base'];

			if ( empty( $slug ) || empty( $type ) || empty( $base ) ) {
				continue;
			}

			if ( $type == 'plugin' ) {
				$info  = $this->get_plugin_changelog( $slug, $base );
				$ret[] = array(
					'base' => $base,
					'html' => $info
				);
			}
		}

		wp_send_json( array(
			'status' => 1,
			'data'   => $ret
		) );

	}

	public function print_scripts() {
		?>
		<script type="text/javascript">
			jQuery(function ($) {
				var data = [];
				$('.wd-plugin-changelog').each(function () {
					var that = $(this);
					data.push({
						slug: that.data('slug'),
						type: that.data('type'),
						base: that.data('base')
					});
				}).promise().done(function () {
					if (data.length > 0) {
						$.ajax({
							method: 'POST',
							url: ajaxurl,
							data: {
								action: 'wd_get_plugin_changelog',
								wp_plugin_theme_version_nonce: '<?php echo $this->generate_nonce( 'wd_get_plugin_changelog' ) ?>',
								data: data
							},
							async: true,
							success: function (data) {
								if (data.status == 1) {
									$.each(data.data, function (i, v) {
										$('[data-base="' + v.base + '"]').html(v.html);
									})
								}
							}
						})
					}
				});

				$('.wd-plugins-update').submit(function () {
					var that = $(this);
					var parent = that.closest('.wd-hardener-rule');
					$.ajax({
						type: 'POST',
						url: ajaxurl,
						data: that.serialize(),
						beforeSend: function () {
							that.find('button').attr('disabled', 'disabled').html(that.find('button').text() + ' <i class="wdv-icon wdv-icon-fw wdv-icon-refresh spin"></i>')
							parent.find('.wd-error').html('').addClass('wd-hide');
						},
						success: function (data) {
							if (data.success == true) {
								that.closest('.update-nag').fadeOut(500, function () {
									that.closest('.update-nag').remove();
									if (parent.find('.update-nag').size() == 0) {
										location.reload();
									}
								});
							} else {
								parent.find('.wd-error').html(data.data.error).removeClass('wd-hide');
								that.find('button').removeAttr('disabled').html(that.find('button').text().replace(' <i class="wdv-icon wdv-icon-fw wdv-icon-refresh spin"></i>'))
							}
						}
					})
					return false;
				})
			})
		</script>
		<?php
	}

	public function listen_pt_version() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		$slug = WD_Utils::http_post( 'slug' );
		$type = WD_Utils::http_post( 'type' );

		if ( $type == 'plugin' ) {
			$data = $this->get_plugins_outdate();
			foreach ( $data as $plugin ) {
				if ( $plugin['base'] == $slug ) {
					wp_send_json( array(
						'status' => 0
					) );
				}
			}
			//if goes here, mean plugin updated
			wp_send_json( array(
				'status' => 1
			) );
		}

	}

	/**
	 * Update theme
	 * @since 1.0.2
	 */
	public function update_theme() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}
		if ( ! $this->verify_nonce( 'wd_update_theme' ) ) {
			return;
		}

		$theme = WD_Utils::http_post( 'theme' );

		$ret = WD_Utils::update_theme( $theme );
		if ( is_wp_error( $ret ) ) {
			wp_send_json_error( array(
				'error' => $ret->get_error_message()
			) );
		}
		//re generate cache
		wp_send_json_success();
	}

	public function display() {
		?>
		<div class="wd-hardener-rule">
			<?php echo $this->get_rule_title(); ?>
			<div class="wd-clearfix"></div>

			<div id="<?php echo $this->id ?>" class="wd-rule-content">
				<h4 class="tl"><?php esc_html_e( "Overview", wp_defender()->domain ) ?></h4>

				<p><?php esc_html_e( "Updates to plugins and themes often include critical security updates, new features and a happier life for all, so we recommend you stick to the latest versions and update regularly.", wp_defender()->domain ) ?></p>

				<div class="wd-error wd-hide">

				</div>
				<?php if ( ! $this->check() ): ?>
					<?php foreach ( $this->get_plugins_outdate() as $item ): ?>
						<div class="update-nag">
							<div class="group">
								<div class="col span_8_of_12 wd-plugin-info">
									<?php echo $item['name'] ?>
									<div class="wd-plugins-detail">
										v <?php echo $item['new_version'] ?> -
										<?php if ( ! empty( $item['update_notices'] ) ): ?>
										<span data-type="plugin" data-base="<?php echo esc_attr( $item['base'] ) ?>"
										      data-slug="<?php echo esc_attr( $item['slug'] ) ?>">
											<?php echo $item['update_notices'] ?>
											<?php else: ?>
											<span data-type="plugin" data-base="<?php echo esc_attr( $item['base'] ) ?>"
											      data-slug="<?php echo esc_attr( $item['base'] ) ?>"
											      class="wd-plugin-changelog">
										<i class="wdv-icon wdv-icon-fw wdv-icon-refresh spin"></i>
												<?php endif; ?>
										</span>
									</div>
								</div>
								<div class="col span_4_of_12 tr">
									<form class="wd-plugins-update"
									      action="<?php echo network_admin_url( 'admin-ajax.php' ) ?>"
									      method="post">
										<?php //wp_nonce_field( 'upgrade-plugin_' . $item['base'], '_ajax_nonce' );
										wp_nonce_field( 'updates', '_ajax_nonce' )
										?>
										<input type="hidden" name="action" value="update-plugin">
										<input type="hidden" name="plugin" value="<?php echo $item['base'] ?>">
										<input type="hidden" name="slug" value="<?php echo $item['slug'] ?>">
										<button type="submit" class="button button-small button-secondary wd-button">
											<?php esc_html_e( "Update", wp_defender()->domain ) ?>
										</button>
									</form>
								</div>
								<div class="wd-clearfix"></div>
							</div>
						</div>
					<?php endforeach; ?>
					<?php foreach ( $this->get_themes_outdate() as $item ): ?>
						<div class="update-nag">
							<div class="group">
								<div class="col span_8_of_12 wd-theme-info">
									<?php echo $item['name'] ?>

									<div class="wd-plugins-detail">
										v <?php echo $item['new_version'] ?>
									</div>
								</div>
								<div class="col span_4_of_12 tr">
									<form class="wd-plugins-update"
									      action="<?php echo network_admin_url( 'admin-ajax.php' ) ?>"
									      method="post">
										<?php $this->generate_nonce_field( 'wd_update_theme' )
										?>
										<input type="hidden" name="action" value="wd_update_theme">
										<input type="hidden" name="theme" value="<?php echo $item['base'] ?>">
										<button type="submit" class="button button-small button-secondary wd-button">
											<?php esc_html_e( "Update", wp_defender()->domain ) ?>
										</button>
									</form>
								</div>
								<div class="wd-clearfix"></div>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>

				<div class="wd-clearfix"></div>
				<br/>

				<h4 class="tl"><?php esc_html_e( "How To Fix", wp_defender()->domain ) ?></h4>

				<div class="wd-well">
					<?php if ( $this->check() ): ?>
						<?php esc_html_e( "All of your plugins & themes are up to date.", wp_defender()->domain ) ?>
					<?php else: ?>
						<p><?php esc_html_e( "Update each version individually and be sure to check the changelog in case of major changes. It’s safe practice to update one at a time, and check your website front end for any breakages as you go.", wp_defender()->domain ) ?></p>
					<?php endif; ?>
				</div>
				<?php echo $this->ignore_button() ?>
			</div>
		</div>
		<?php
	}

	public function revert() {

	}
}