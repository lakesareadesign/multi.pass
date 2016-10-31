<?php
/**
 * Class: WD_DB_Prefix
 */

/**
 * @author: Hoang Ngo
 */
class WD_DB_Prefix extends WD_Hardener_Abstract {
	protected $db_prefix;
	protected $old_prefix;
	protected $renamed_table = array();

	public function on_creation() {
		$this->id         = 'db_prefix';
		$this->title      = esc_html__( 'Change default database prefix', wp_defender()->domain );
		$this->can_revert = true;

		$this->add_action( 'admin_footer', 'print_scripts' );
		$this->add_ajax_action( $this->generate_ajax_action( 'db_prefix_change' ), 'process' );
		if ( $this->check() && WD_Utils::get_setting( $this->get_setting_key( 'start' ) ) ) {
			WD_Utils::update_setting( $this->get_setting_key( 'start' ), 0 );
			//clear all cache
			wp_cache_flush(); //we gotta clear the whole object cache
			$this->after_processed();
		}
	}

	/**
	 * @return bool
	 */
	public function check( $against = 'wp_' ) {
		global $wpdb;

		if ( is_null( $this->db_prefix ) ) {
			$this->db_prefix = $wpdb->base_prefix;
		}

		if ( $this->db_prefix == $against ) {
			return false;
		}

		return true;
	}

	public function print_scripts() {
		?>
		<script type="text/javascript">
			jQuery(function ($) {
				$('#db_prefix_form').submit(function (e) {
					var that = $(this);
					var parent = $(this).closest('.wd-hardener-rule');
					$.ajax({
						type: 'POST',
						url: ajaxurl,
						data: that.serialize(),
						beforeSend: function () {
							that.find('button').attr('disabled', 'disabled');
							that.find('button').css({
								'cursor': 'progress'
							});
						},
						success: function (data) {
							that.find('button').removeAttr('disabled');
							that.find('button').css({
								'cursor': 'pointer'
							});

							if (data.status == 0) {
								$('#db_prefix .wd-error').html(data.error).removeClass('wd-hide');
							} else {
								$('#db_prefix .wd-error').html('').addClass('wd-hide');
								that.closest('div').html(data.message);
								//moving to the success queue
								parent.hide(500, function () {
									var div = parent.detach();
									div.prependTo($('.wd-hardener-success'));
									div.find('.rule-title').removeClass('issue').addClass('fixed').find('button').hide();
									div.find('i.dashicons-flag').replaceWith($('<i class="wdv-icon wdv-icon-fw wdv-icon-ok"/>'));
									div.find('.form-ignore').addClass('wd-hide');
									div.show(500, function () {
										/*	$('html, body').animate({
										 scrollTop: div.find('.rule-title').offset().top
										 }, 1000);*/
									});
								});
								$('body').trigger('after_an_issue_resolved', -1);
							}
						}
					})
					return false;
				})
			})
		</script>
		<?php
	}

	/**
	 * Return current database prefix
	 *
	 * @return string
	 * @access protected
	 * @since 1.0
	 */
	protected function get_current_prefix() {
		global $wpdb;

		return $wpdb->base_prefix;
	}

	/**
	 * Get a list of tables beginning with a prefix
	 *
	 * @param string $prefix Prefix to search for, defaults to base_prefix
	 *
	 * @return array
	 */
	private function get_tables( $prefix = false ) {
		global $wpdb;

		if ( ! $prefix ) {
			$prefix = $wpdb->base_prefix;
		}

		$results = $wpdb->get_col( $wpdb->prepare( "SHOW TABLES LIKE %s", $prefix . '%' ) );
		$results = array_unique( $results );

		return $results;
	}

	/**
	 * This will validate the env for doing this
	 * 1. we require function
	 * 2. wp-config.php writeable
	 * 3. user having the ability for alter
	 *
	 * @return bool
	 */
	private function validate_environment() {
		$wp_config_path = WD_Utils::retrieve_wp_config_path();
		if ( ! is_writable( $wp_config_path ) ) {
			$this->output_error( 0, esc_html__( "Your wp-config.php is not writable", wp_defender()->domain ) );
		}

		if ( ! function_exists( 'file' ) || ! function_exists( 'file_get_contents' ) || ! function_exists( 'file_put_contents' ) ) {
			$this->output_error( 1, sprintf( esc_html__( "This plugin will require these functions % enabled on your server", wp_defender()->domain ), 'file, file_get_contents, file_put_contents' ) );
		}

		return true;
	}

	/**
	 * @param $prefix
	 *
	 * @return bool|WP_Error
	 */
	public function validate( $prefix ) {
		if ( empty( $prefix ) ) {
			return new WP_Error( esc_html__( "Your prefix can't be empty!", wp_defender()->domain ) );
		}

		if ( preg_match( '|[^a-z0-9_]|i', $prefix ) ) {
			return new WP_Error( esc_html__( "Table prefix can only contain numbers, letters, and underscores.", wp_defender()->domain ) );
		}

		$tables = $this->get_tables( $prefix );
		if ( $tables ) {
			return new WP_Error( esc_html__( "This prefix is already in use. Please choose a different prefix.", wp_defender()->domain ) );
		}

		return true;
	}

	public function process() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! wp_verify_nonce( WD_Utils::http_post( '_wdnonce' ), 'change_db_prefix' ) ) {
			return;
		}
		//validate environment
		$this->validate_environment();

		//check if user provide a valid prefix
		$prefix = WD_Utils::http_post( 'new_db_prefix' );
		if ( empty( $prefix ) ) {
			wp_send_json( array(
				'status' => 0,
				'error'  => esc_html__( "Your prefix can't be empty!", wp_defender()->domain )
			) );
		}

		set_time_limit( - 1 );

		//add trailing underscore if not present
		if ( substr( $prefix, - 1 ) != '_' ) {
			$prefix .= '_';
		}

		if ( preg_match( '|[^a-z0-9_]|i', $prefix ) ) {
			wp_send_json( array(
				'status' => 0,
				'error'  => esc_html__( "Table prefix can only contain numbers, letters, and underscores.", wp_defender()->domain )
			) );
		}

		$tables = $this->get_tables( $prefix );
		if ( $tables ) { //a table already using this
			$this->output_error( 'conflict', esc_html__( "This prefix is already in use. Please choose a different prefix.", wp_defender()->domain ) );
		}

		WD_Utils::update_setting( $this->get_setting_key( 'start' ), 1 );
		$this->update_table_prefix( $prefix );
		$this->update_table_data( $prefix );
		$this->update_wpconfig( $prefix );

		//done
		if ( $this->is_ajax() ) {
			wp_send_json( array(
				'status'  => 1,
				'message' => sprintf( __( "Your prefix has successfully been changed to <strong>%s</strong>. If you notice any issues with user permissions you may need to flush your object cache." ), $prefix )
			) );
		}

		return true;
	}

	/**
	 * This will run a script to update all current table name to new prefix
	 *
	 * @param $prefix
	 *
	 * @return string
	 */
	public function update_table_prefix( $prefix, $old_prefix = null ) {
		global $wpdb;
		if ( is_null( $old_prefix ) ) {
			$old_prefix = $wpdb->prefix;
		}
		//prefix not empty
		$tables = $this->get_tables();

		foreach ( $tables as $table ) {
			$new_table_name = str_replace( $old_prefix, $prefix, $table );
			$sql = "RENAME TABLE `{$table}` TO `{$new_table_name}`";
			if ( $wpdb->query( $sql ) === false ) {
				if ( $this->is_ajax() ) {
					$this->output_error( 'alter_error', $wpdb->last_error );
				} else {
					return false;
				}
			}
			$this->renamed_table[] = $table;
		}

		return true;
	}

	/**
	 * @param $prefix
	 * @param null $path
	 *
	 * @return bool
	 */
	public function update_wpconfig( $prefix, $path = null ) {
		//update wp-config.php
		if ( $path == null || ! file_exists( $path ) ) {
			$path = WD_Utils::retrieve_wp_config_path();
		}
		$config_content = file_get_contents( $path );
		$config_content = preg_replace( '/(\$table_prefix\s*=\s*)([\'"]).+?\\2(\s*;)/', "\${1}'$prefix'\${3}", $config_content );
		//write back
		if ( ! file_put_contents( $path, $config_content, LOCK_EX ) ) {
			if ( $this->is_ajax() ) {
				$this->output_error( 'cant_write', esc_html__( "It seems the wp-config.php file is currently using by another process or isn't writeable.", wp_defender()->domain ) );
			} else {
				return false;
			}
		}

		return true;
	}

	/**
	 * This will fix the leftover data
	 *
	 * @param $prefix
	 *
	 * @return string
	 */
	public function update_table_data( $prefix, $old_prefix = null ) {
		global $wpdb;
		if ( is_null( $old_prefix ) ) {
			$old_prefix = $wpdb->prefix;
		}
		if ( is_multisite() ) {
			/**
			 * case multiste
			 * in multisite, blog options will have a option name $prefix_id_user_roles, we have to update this or
			 * we will have issue with roles
			 */
			$sql   = "SELECT blog_id FROM `{$prefix}blogs`";
			$blogs = $wpdb->get_col( $sql );
			if ( is_array( $blogs ) && count( $blogs ) ) {
				foreach ( $blogs as $blog_id ) {
					if ( $blog_id == 1 ) {
						continue;
					}
					$sql = "UPDATE `{$prefix}{$blog_id}_options` SET option_name=%s WHERE option_name=%s";
					$sql = $wpdb->prepare( $sql, $prefix . $blog_id . '_user_roles', $old_prefix . $blog_id . '_user_roles' );
					if ( $wpdb->query( $sql ) == false ) {
						return $this->output_error( 'sql_error', $wpdb->last_error );
					}
				}
			}
		}
		//now update the main blog
		$sql = "UPDATE `{$prefix}options` SET option_name=%s WHERE option_name=%s";
		$sql = $wpdb->prepare( $sql, $prefix . 'user_roles', $old_prefix . 'user_roles' );
		$wpdb->query( $sql );
		//we will need to update the prefix inside user meta, or we will get issue with permission
		$sql  = "SELECT * FROM {$prefix}usermeta";
		$rows = $wpdb->get_results( $sql, ARRAY_A );
		foreach ( $rows as $row ) {
			if ( strpos( $row['meta_key'], $old_prefix ) === 0 ) {
				$clean_name = substr( $row['meta_key'], strlen( $old_prefix ), strlen( $row['meta_key'] ) );
				$new_name   = $prefix . $clean_name;
				$sql        = $wpdb->prepare( "UPDATE `{$prefix}usermeta` SET meta_key=%s WHERE meta_key=%s", $new_name, $row['meta_key'] );
				//run the updater
				if ( $wpdb->query( $sql ) === false ) {
					return $this->output_error( 'sql_error', $wpdb->last_error );
				}
			}
		}

		return true;
	}

	public function display() {
		?>
		<div class="wd-hardener-rule">
			<?php echo $this->get_rule_title(); ?>
			<div class="wd-clearfix"></div>

			<div id="<?php echo $this->id ?>" class="wd-rule-content">
				<h4 class="tl"><?php esc_html_e( "Overview", wp_defender()->domain ) ?></h4>

				<p><?php esc_html_e( "When you first install WordPress on a new database, the default settings start with wp_ as the prefix to anything that gets stored in the tables. This makes it easier for hackers to perform SQL injection attacks if they find a code vulnerability. It’s good practice to come up with a unique prefix to protect yourself from this. Please backup your database before changing the prefix.", wp_defender()->domain ) ?></p>

				<h4 class="tl"><?php esc_html_e( "How To Fix", wp_defender()->domain ) ?></h4>

				<div class="wd-error wd-hide">

				</div>

				<div class="wd-well">
					<?php if ( is_multisite() && get_blog_count() >= 100 ):
						?>
						<?php esc_html_e( "Unfortunately it's not safe to do this via a plugin for larger WordPress Multisite installs. You can ignore this step, or follow a tutorial online on how to use a scalable tool like WP-CLI.", wp_defender()->domain ) ?>
					<?php else: ?>

						<?php if ( $this->check() ): ?>
							<?php
							global $wpdb;
							printf( __( "Your prefix is <strong>%s</strong> and is unique." ), $wpdb->base_prefix ) ?>
						<?php else: ?>
							<p>
								<?php esc_html_e( "We recommend using a different prefix to protect your database. Ensure you backup your database before changing the prefix.", wp_defender()->domain ) ?>
							</p>

							<form method="post" class="form-button-inline" id="db_prefix_form">
								<?php echo wp_nonce_field( 'change_db_prefix', '_wdnonce' ) ?>
								<input type="hidden" name="action"
								       value="<?php echo $this->generate_ajax_action( 'db_prefix_change' ) ?>">

								<div class="group">
									<div class="col span_10_of_12">
										<input name="new_db_prefix" type="text"
										       placeholder="<?php esc_attr_e( "New prefix", wp_defender()->domain ) ?>">
									</div>
									<div class="col span_2_of_12">
										<button type="submit" class="button wd-button">
											<?php esc_html_e( "Update", wp_defender()->domain ) ?>
										</button>
									</div>
								</div>
								<div class="wd-clearfix"></div>
							</form>
						<?php endif; ?>
					<?php endif; ?>
				</div>
				<?php echo $this->ignore_button() ?>
			</div>
		</div>
		<?php
	}

	public function revert( $prefix = 'wp_', $path = null ) {
		$this->update_table_prefix( $prefix );
		$this->update_table_data( $prefix );
		$this->update_wpconfig( $prefix, $path );
	}
}