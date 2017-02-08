<?php
///////////////////////////////SETTINGS\\\\\\\\\\\\\\\\\\\\\\\\\\\\
function postspages_init() {

	register_setting("posts_pages", "flatty_wordpress_posts_remove_format");
	register_setting("posts_pages", "flatty_wordpress_posts_remove_trackbacks");
	register_setting("posts_pages", "flatty_wordpress_posts_remove_commentsstatus");
	register_setting("posts_pages", "flatty_wordpress_posts_remove_commentslist");
	register_setting("posts_pages", "flatty_wordpress_posts_remove_customfields");
	register_setting("posts_pages", "flatty_wordpress_posts_remove_revisions");
	register_setting("posts_pages", "flatty_wordpress_posts_remove_author");
	register_setting("posts_pages", "flatty_wordpress_posts_remove_slug");

	register_setting("posts_pages", "flatty_wordpress_pages_remove_format");
	register_setting("posts_pages", "flatty_wordpress_pages_remove_trackbacks");
	register_setting("posts_pages", "flatty_wordpress_pages_remove_commentsstatus");
	register_setting("posts_pages", "flatty_wordpress_pages_remove_commentslist");
	register_setting("posts_pages", "flatty_wordpress_pages_remove_customfields");
	register_setting("posts_pages", "flatty_wordpress_pages_remove_revisions");
	register_setting("posts_pages", "flatty_wordpress_pages_remove_author");
	register_setting("posts_pages", "flatty_wordpress_pages_remove_slug");

}

add_action("admin_init","postspages_init");

//////////////////////////////////////////////////////////////////////////////////////////////////PAGE
function options_sub_postspages() {
	?>

	<form method='post' action='options.php'>

		<div class="wrap flatty-form">

			<div class="page-title">
	            <img src="<?php echo plugins_url(FLATTY_PLUGIN_URL . 'assets/flatty-logo.png') ?>" class="flatty-logo"/>
	            <div class="header"><?php _e('Posts & Pages', 'flatty-flat-admin-theme' ); ?></div>
	        </div>

	        <div id="posts-box" class="postbox flatty">
				<div class="title">
	                <i class="dashicons dashicons-wordpress" style="background-color: #404386;"></i>
	                <span><?php _e('Meta Boxes', 'flatty-flat-admin-theme' ); ?></span>
	            </div>

				<div class="option">
					<label for="flatty_wordpress_posts_remove_format"><?php _e('Remove "Format" box', 'flatty-flat-admin-theme' ); ?></label>
					<div style="margin-left:auto;">
						<input
							type="checkbox"
							name="flatty_wordpress_posts_remove_format"
							id="flatty_wordpress_posts_remove_format"
							value='1'
							<?php checked(1, get_option('flatty_wordpress_posts_remove_format')); ?>
						/>
						<span>Post</span>
					</div>
					<div style="margin-left:10px;">
						<input
							type="checkbox"
							name="flatty_wordpress_pages_remove_format"
							id="flatty_wordpress_pages_remove_format"
							value='1'
							<?php checked(1, get_option('flatty_wordpress_pages_remove_format')); ?>
						/>
						<span>Page</span>
					</div>
					<div class="flatty-description"><?php _e('Allows the user to select a post format', 'flatty-flat-admin-theme' ); ?></div>
				</div>

				<div class="option">
					<label for="flatty_wordpress_posts_remove_trackbacks"><?php _e('Remove "Trackbacks" box', 'flatty-flat-admin-theme' ); ?></label>

					<div style="margin-left:auto;">
						<input
							type="checkbox"
							name="flatty_wordpress_posts_remove_trackbacks"
							id="flatty_wordpress_posts_remove_trackbacks"
							value='1'
							<?php checked(1, get_option('flatty_wordpress_posts_remove_trackbacks')); ?>
						/>
						<span>Post</span>
					</div>
					<div style="margin-left:10px;">
						<input
							type="checkbox"
							name="flatty_wordpress_pages_remove_trackbacks"
							id="flatty_wordpress_pages_remove_trackbacks"
							value='1'
							<?php checked(1, get_option('flatty_wordpress_pages_remove_trackbacks')); ?>
						/>
						<span>Page</span>
					</div>

					<div class="flatty-description"><?php _e('Displays an input box for sending trackbacks.', 'flatty-flat-admin-theme' ); ?></div>
				</div>

				<div class="option">
					<label for="flatty_wordpress_pages_remove_commentsstatus"><?php _e('Remove "Comments status" box', 'flatty-flat-admin-theme' ); ?></label>

					<div style="margin-left:auto;">
						<input
							type="checkbox"
							name="flatty_wordpress_posts_remove_commentsstatus"
							id="flatty_wordpress_posts_remove_commentsstatus"
							value='1'
							<?php checked(1, get_option('flatty_wordpress_posts_remove_commentsstatus')); ?>
						/>
						<span>Post</span>
					</div>
					<div style="margin-left:10px;">
						<input
							type="checkbox"
							name="flatty_wordpress_pages_remove_commentsstatus"
							id="flatty_wordpress_pages_remove_commentsstatus"
							value='1'
							<?php checked(1, get_option('flatty_wordpress_pages_remove_commentsstatus')); ?>
						/>
						<span>Page</span>
					</div>

					<div class="flatty-description"><?php _e('Allows you to enable/disable comments and pings for the post', 'flatty-flat-admin-theme' ); ?></div>
				</div>

				<div class="option">
					<label for="flatty_wordpress_remove_commentslist"><?php _e('Remove "Comments list" box', 'flatty-flat-admin-theme' ); ?></label>

					<div style="margin-left:auto;">
						<input
							type="checkbox"
							name="flatty_wordpress_posts_remove_commentslist"
							id="flatty_wordpress_posts_remove_commentslist"
							value='1'
							<?php checked(1, get_option('flatty_wordpress_posts_remove_commentslist')); ?>
						/>
						<span>Post</span>
					</div>
					<div style="margin-left:10px;">
						<input
							type="checkbox"
							name="flatty_wordpress_pages_remove_commentslist"
							id="flatty_wordpress_pages_remove_commentslist"
							value='1'
							<?php checked(1, get_option('flatty_wordpress_pages_remove_commentslist')); ?>
						/>
						<span>Page</span>
					</div>

					<div class="flatty-description"><?php _e('Displays comments made on the post', 'flatty-flat-admin-theme' ); ?></div>
				</div>

				<div class="option">
					<label for="flatty_wordpress_posts_remove_customfields"><?php _e('Remove "Custom Fields" box', 'flatty-flat-admin-theme' ); ?></label>

					<div style="margin-left:auto;">
						<input
							type="checkbox"
							name="flatty_wordpress_posts_remove_customfields"
							id="flatty_wordpress_posts_remove_customfields"
							value='1'
							<?php checked(1, get_option('flatty_wordpress_posts_remove_customfields')); ?>
						/>
						<span>Post</span>
					</div>
					<div style="margin-left:10px;">
						<input
							type="checkbox"
							name="flatty_wordpress_pages_remove_customfields"
							id="flatty_wordpress_pages_remove_customfields"
							value='1'
							<?php checked(1, get_option('flatty_wordpress_pages_remove_customfields')); ?>
						/>
						<span>Page</span>
					</div>

				</div>

				<div class="option">
					<label for="flatty_wordpress_posts_remove_revisions"><?php _e('Remove "Revisions" box', 'flatty-flat-admin-theme' ); ?></label>

					<div style="margin-left:auto;">
						<input
							type="checkbox"
							name="flatty_wordpress_posts_remove_revisions"
							id="flatty_wordpress_posts_remove_revisions"
							value='1'
							<?php checked(1, get_option('flatty_wordpress_posts_remove_revisions')); ?>
						/>
						<span>Post</span>
					</div>
					<div style="margin-left:10px;">
						<input
							type="checkbox"
							name="flatty_wordpress_pages_remove_revisions"
							id="flatty_wordpress_pages_remove_revisions"
							value='1'
							<?php checked(1, get_option('flatty_wordpress_pages_remove_revisions')); ?>
						/>
						<span>Page</span>
					</div>

					<div class="flatty-description"><?php _e('Displays post revision links', 'flatty-flat-admin-theme' ); ?></div>
				</div>

				<div class="option">
					<label for="flatty_wordpress_posts_remove_author"><?php _e('Remove "Author" box', 'flatty-flat-admin-theme' ); ?></label>
					
					<div style="margin-left:auto;">
						<input
							type="checkbox"
							name="flatty_wordpress_posts_remove_author"
							id="flatty_wordpress_posts_remove_author"
							value='1'
							<?php checked(1, get_option('flatty_wordpress_posts_remove_author')); ?>
						/>
						<span>Post</span>
					</div>
					<div style="margin-left:10px;">
						<input
							type="checkbox"
							name="flatty_wordpress_pages_remove_author"
							id="flatty_wordpress_pages_remove_author"
							value='1'
							<?php checked(1, get_option('flatty_wordpress_pages_remove_author')); ?>
						/>
						<span>Page</span>
					</div>

					<div class="flatty-description"><?php _e('Displays a select box to choose a post author', 'flatty-flat-admin-theme' ); ?></div>
				</div>

				<div class="option">
					<label for="flatty_wordpress_posts_remove_slug"><?php _e('Remove "Slug" box', 'flatty-flat-admin-theme' ); ?></label>
					
					<div style="margin-left:auto;">
						<input
							type="checkbox"
							name="flatty_wordpress_posts_remove_slug"
							id="flatty_wordpress_posts_remove_slug"
							value='1'
							<?php checked(1, get_option('flatty_wordpress_posts_remove_slug')); ?>
						/>
						<span>Post</span>
					</div>
					<div style="margin-left:10px;">
						<input
							type="checkbox"
							name="flatty_wordpress_pages_remove_slug"
							id="flatty_wordpress_pages_remove_slug"
							value='1'
							<?php checked(1, get_option('flatty_wordpress_pages_remove_slug')); ?>
						/>
						<span>Page</span>
					</div>

					<div class="flatty-description"><?php _e('Displays an additional post slug box', 'flatty-flat-admin-theme' ); ?></div>
				</div>

	        </div>


		</div>

		<div class="buttons-container">
			<?php
				settings_fields('posts_pages');
				submit_button('', 'primary large flatty-button-update');
			?>
			<div class="flatty-single"><?php _e('*Don\'t forget to save changes', 'flatty-flat-admin-theme' ); ?></div>
		</div>

	</form>

	<?php
}

?>
