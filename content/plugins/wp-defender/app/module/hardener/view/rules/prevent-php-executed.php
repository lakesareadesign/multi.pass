<div class="rule closed" id="disable-file-editor">
    <div class="rule-title">
		<?php if ( $controller->check() == false ): ?>
            <i class="def-icon icon-warning"></i>
		<?php else: ?>
            <i class="def-icon icon-tick"></i>
		<?php endif; ?>
		<?php _e( "Prevent PHP execution", wp_defender()->domain ) ?>
    </div>
    <div class="rule-content">
        <h3><?php _e( "Overview", wp_defender()->domain ) ?></h3>
        <div class="line end">
			<?php _e( "By default, a plugin/theme vulnerability could allow a PHP file to get uploaded into your site's directories and in turn execute harmful scripts that can wreak havoc on your website. Prevent this altogether by disabling direct PHP execution in directories that don't require it.", wp_defender()->domain ) ?>
        </div>
        <h3>
			<?php _e( "How to fix", wp_defender()->domain ) ?>
        </h3>
        <div class="well">
			<?php if ( $controller->check() ): ?>
                <p class="line"><?php _e( "PHP execution is locked down.", wp_defender()->domain ) ?></p>
                <form method="post" class="hardener-frm rule-process">
					<?php $controller->createNonceField(); ?>
                    <input type="hidden" name="action" value="processRevert"/>
                    <input type="hidden" name="slug" value="<?php echo $controller::$slug ?>"/>
                    <button class="button button-small button-grey"
                            type="submit"><?php _e( "Revert", wp_defender()->domain ) ?></button>
                </form>
			<?php else: ?>
				<?php
				switch ( \WP_Defender\Behavior\Utils::instance()->determineServer() ):
					case 'nginx':
						$wp_includes = str_replace( $_SERVER['DOCUMENT_ROOT'], '', ABSPATH . WPINC );
						$wp_content  = str_replace( $_SERVER['DOCUMENT_ROOT'], '', WP_CONTENT_DIR );

						$rules = "# Stop php access except to needed files in wp-includes
location ~* ^$wp_includes/.*(?<!(js/tinymce/wp-tinymce))\.php$ {
  internal; #internal allows ms-files.php rewrite in multisite to work
}

# Specifically locks down upload directories in case full wp-content rule below is skipped
location ~* /(?:uploads|files)/.*\.php$ {
  deny all;
}

# Deny direct access to .php files in the /wp-content/ directory (including sub-folders).
#  Note this can break some poorly coded plugins/themes, replace the plugin or remove this block if it causes trouble
location ~* ^$wp_content/.*\.php$ {
  deny all;
}
";
						?>
                        <div class="">
                            <p><?php esc_html_e( "For NGINX servers:", wp_defender()->domain ) ?></p>
                            <ol>
                                <li>
                                    <p><?php _e( "Input the file paths to ignore in the /wp-content directory (each in a new line). The file index.php is not allowed", wp_defender()->domain ) ?></p>
                                    <textarea class="hardener-php-excuted-ignore"></textarea>
                                </li>
                                <li>
									<?php esc_html_e( "Copy the generated code into your site specific .conf file usually located in a subdirectory under /etc/nginx/... or /usr/local/nginx/conf/...", wp_defender()->domain ) ?>
                                </li>
                                <li>
									<?php _e( "Add the code above inside the <strong>server</strong> section in the file, right before the php location block. Looks something like:", wp_defender()->domain ) ?>
                                    <pre>location ~ \.php$ {</pre>
                                </li>
                                <li>
									<?php esc_html_e( "Reload NGINX.", wp_defender()->domain ) ?>
                                </li>
                            </ol>
                            <p><?php sprintf( __( "Still having trouble? <a target='_blank' href=\"%s\">Open a support ticket</a>.", wp_defender()->domain ), 'https://premium.wpmudev.org/forums/forum/support#question' ) ?></p>

                            <pre>
## WP Defender - Prevent PHP Execution ##
								<?php echo esc_html( $rules ); ?>
                                <span class="hardener-nginx-extra-instructions"></span>
                                ## WP Defender - End ##
			                </pre>

                        </div>
                        <?php
						break;
					case 'apache':
						?>
                        <div class="line">
                            <p><?php _e( "We will place <strong>.htaccess</strong> file into the root folder to lock down the files and folders inside.", wp_defender()->domain ) ?></p>
                        </div>
                        <div class="line">
                            <p><?php _e( "File paths to ignore in the /wp-content directory (each in a new line). The file index.php is not allowed", wp_defender()->domain ) ?></p>
                            <textarea class="hardener-php-excuted-ignore"></textarea>
                        </div>
                        <form method="post" class="hardener-frm rule-process">
							<?php $controller->createNonceField(); ?>
                            <input type="hidden" name="action" value="processHardener"/>
                            <input type="hidden" name="file_paths" value=""/>
                            <input type="hidden" name="slug" value="<?php echo $controller::$slug ?>"/>
                            <button class="button float-r"
                                    type="submit"><?php _e( "Add .htaccess file", wp_defender()->domain ) ?></button>
                        </form>
						<?php $controller->showIgnoreForm() ?>
						<?php break; ?>
						<?php
					default:
						?>

						<?php break; ?>
					<?php endswitch;; ?>
			<?php endif; ?>
        </div>
        <div class="clear"></div>
	    <?php if ( \WP_Defender\Behavior\Utils::instance()->determineServer() != 'apache' ): ?>
            <div class="clear mline"></div>
		    <?php $controller->showIgnoreForm() ?>
	    <?php endif; ?>
    </div>
</div>