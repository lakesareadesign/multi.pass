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

		<div class="flatty-header">
	        <div class="flatty-flex">
	            <img src="<?php echo plugins_url(FLATTY_PLUGIN_URL . 'assets/flatty-logo.png') ?>" class="flatty-logo"/>
	            <h1><?php _e('Post & Pages', 'flatty-flat-admin-theme' ); ?></h1>
	        </div>
	        <div class="flatty-row" style="align-items:flex-start; justify-content: flex-end;">
	            <div class="flatty-column">
	                <?php
	                    settings_fields('posts_pages');
	                    submit_button('', 'flatty-button update');
	                ?>
	                <p><?php _e('*Don\'t forget to save changes', 'flatty-flat-admin-theme' ); ?></p>
	            </div>
	        </div>
	    </div>

	    <div class="flatty-column">

	    	<div class="flatty-container" id="postandpages">
	            <div class="flatty-container-title" style="background: linear-gradient(135deg, #3F51B5 0%,#2196F3 100%);">
	                <i class="dashicons dashicons-wordpress" style="width:auto; height:auto; font-size:50px; margin-bottom:10px;"></i>
	                <span><?php _e('Meta Boxes', 'flatty-flat-admin-theme' ); ?></span>
	            </div>
	            <div class="flatty-container-content">
	                <!--HIDE FORMAT-->
	                <div class="flatty-option">
	                    <div class="flatty-column">
	                        <label for="flatty_wordpress_posts_remove_format"><?php _e('Remove "Format" box', 'flatty-flat-admin-theme' ); ?></label>
	                        <div class="flatty-description"><?php _e('Allows the user to select a post format', 'flatty-flat-admin-theme' ); ?></div>
	                    </div>
	                    <div class="flatty-row multi-column">
		                    <div class="flatty-column">
		                    	<span>Posts</span>
		                        <input
									type="checkbox"
									name="flatty_wordpress_posts_remove_format"
									id="flatty_wordpress_posts_remove_format"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_posts_remove_format')); ?>
								/>
							</div>
							<div class="flatty-column">
								<span>Pages</span>
								<input
									type="checkbox"
									name="flatty_wordpress_pages_remove_format"
									id="flatty_wordpress_pages_remove_format"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_pages_remove_format')); ?>
								/>
		                    </div>
		                </div>
	                </div>

	                <!--HIDE TRACKBACKS-->
	                <div class="flatty-option">
	                    <div class="flatty-column">
	                        <label for="flatty_wordpress_posts_remove_trackbacks"><?php _e('Remove "Trackbacks" box', 'flatty-flat-admin-theme' ); ?></label>
	                        <div class="flatty-description"><?php _e('Displays an input box for sending trackbacks.', 'flatty-flat-admin-theme' ); ?></div>
	                    </div>
	                    <div class="flatty-row multi-column">
		                    <div class="flatty-column">
		                    	<span>Posts</span>
		                        <input
									type="checkbox"
									name="flatty_wordpress_posts_remove_trackbacks"
									id="flatty_wordpress_posts_remove_trackbacks"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_posts_remove_trackbacks')); ?>
								/>
							</div>
							<div class="flatty-column">
								<span>Pages</span>
								<input
									type="checkbox"
									name="flatty_wordpress_pages_remove_trackbacks"
									id="flatty_wordpress_pages_remove_trackbacks"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_pages_remove_trackbacks')); ?>
								/>
		                    </div>
		                </div>
	                </div>

	                <!--HIDE TRACKBACKS-->
	                <div class="flatty-option">
	                    <div class="flatty-column">
	                        <label for="flatty_wordpress_posts_remove_trackbacks"><?php _e('Remove "Trackbacks" box', 'flatty-flat-admin-theme' ); ?></label>
	                        <div class="flatty-description"><?php _e('Displays an input box for sending trackbacks.', 'flatty-flat-admin-theme' ); ?></div>
	                    </div>
	                    <div class="flatty-row multi-column">
		                    <div class="flatty-column">
		                    	<span>Posts</span>
		                        <input
									type="checkbox"
									name="flatty_wordpress_posts_remove_trackbacks"
									id="flatty_wordpress_posts_remove_trackbacks"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_posts_remove_trackbacks')); ?>
								/>
							</div>
							<div class="flatty-column">
								<span>Pages</span>
								<input
									type="checkbox"
									name="flatty_wordpress_pages_remove_trackbacks"
									id="flatty_wordpress_pages_remove_trackbacks"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_pages_remove_trackbacks')); ?>
								/>
		                    </div>
		                </div>
	                </div>

	                <!--HIDE TRACKBACKS-->
	                <div class="flatty-option">
	                    <div class="flatty-column">
	                        <label for="flatty_wordpress_posts_remove_trackbacks"><?php _e('Remove "Trackbacks" box', 'flatty-flat-admin-theme' ); ?></label>
	                        <div class="flatty-description"><?php _e('Displays an input box for sending trackbacks.', 'flatty-flat-admin-theme' ); ?></div>
	                    </div>
	                    <div class="flatty-row multi-column">
		                    <div class="flatty-column">
		                    	<span>Posts</span>
		                        <input
									type="checkbox"
									name="flatty_wordpress_posts_remove_trackbacks"
									id="flatty_wordpress_posts_remove_trackbacks"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_posts_remove_trackbacks')); ?>
								/>
							</div>
							<div class="flatty-column">
								<span>Pages</span>
								<input
									type="checkbox"
									name="flatty_wordpress_pages_remove_trackbacks"
									id="flatty_wordpress_pages_remove_trackbacks"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_pages_remove_trackbacks')); ?>
								/>
		                    </div>
		                </div>
	                </div>

	                <!--HIDE COMMENTS STATUS-->
	                <div class="flatty-option">
	                    <div class="flatty-column">
	                        <label for="flatty_wordpress_pages_remove_commentsstatus"><?php _e('Remove "Comments status" box', 'flatty-flat-admin-theme' ); ?></label>
							<div class="flatty-description"><?php _e('Allows you to enable/disable comments and pings for the post', 'flatty-flat-admin-theme' ); ?></div>
	                    </div>
	                    <div class="flatty-row multi-column">
		                    <div class="flatty-column">
		                    	<span>Posts</span>
		                        <input
									type="checkbox"
									name="flatty_wordpress_posts_remove_commentsstatus"
									id="flatty_wordpress_posts_remove_commentsstatus"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_posts_remove_commentsstatus')); ?>
								/>
							</div>
							<div class="flatty-column">
								<span>Pages</span>
								<input
									type="checkbox"
									name="flatty_wordpress_pages_remove_commentsstatus"
									id="flatty_wordpress_pages_remove_commentsstatus"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_pages_remove_commentsstatus')); ?>
								/>
		                    </div>
		                </div>
	                </div>

	                <!--HIDE COMMENTS LIST-->
	                <div class="flatty-option">
	                    <div class="flatty-column">
	                        <label for="flatty_wordpress_remove_commentslist"><?php _e('Remove "Comments list" box', 'flatty-flat-admin-theme' ); ?></label>
							<div class="flatty-description"><?php _e('Displays comments made on the post', 'flatty-flat-admin-theme' ); ?></div>
	                    </div>
	                    <div class="flatty-row multi-column">
		                    <div class="flatty-column">
		                    	<span>Posts</span>
		                        <input
									type="checkbox"
									name="flatty_wordpress_posts_remove_commentslist"
									id="flatty_wordpress_posts_remove_commentslist"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_posts_remove_commentslist')); ?>
								/>
							</div>
							<div class="flatty-column">
								<span>Pages</span>
								<input
									type="checkbox"
									name="flatty_wordpress_pages_remove_commentslist"
									id="flatty_wordpress_pages_remove_commentslist"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_pages_remove_commentslist')); ?>
								/>
		                    </div>
		                </div>
	                </div>

	                <!--HIDE CUSTOM FIELDS-->
	                <div class="flatty-option">
	                    <div class="flatty-column">
	                        <label for="flatty_wordpress_posts_remove_customfields"><?php _e('Remove "Custom Fields" box', 'flatty-flat-admin-theme' ); ?></label>
							<div class="flatty-description"><?php _e('Remove custom fields box', 'flatty-flat-admin-theme' ); ?></div>
	                    </div>
	                    <div class="flatty-row multi-column">
		                    <div class="flatty-column">
		                    	<span>Posts</span>
		                        <input
									type="checkbox"
									name="flatty_wordpress_posts_remove_customfields"
									id="flatty_wordpress_posts_remove_customfields"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_posts_remove_customfields')); ?>
								/>
							</div>
							<div class="flatty-column">
								<span>Pages</span>
								<input
									type="checkbox"
									name="flatty_wordpress_pages_remove_customfields"
									id="flatty_wordpress_pages_remove_customfields"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_pages_remove_customfields')); ?>
								/>
		                    </div>
		                </div>
	                </div>

	                <!--HIDE REVISIONS-->
	                <div class="flatty-option">
	                    <div class="flatty-column">
	                        <label for="flatty_wordpress_posts_remove_revisions"><?php _e('Remove "Revisions" box', 'flatty-flat-admin-theme' ); ?></label>
							<div class="flatty-description"><?php _e('Displays post revision links', 'flatty-flat-admin-theme' ); ?></div>
	                    </div>
	                    <div class="flatty-row multi-column">
		                    <div class="flatty-column">
		                    	<span>Posts</span>
		                        <input
									type="checkbox"
									name="flatty_wordpress_posts_remove_revisions"
									id="flatty_wordpress_posts_remove_revisions"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_posts_remove_revisions')); ?>
								/>
							</div>
							<div class="flatty-column">
								<span>Pages</span>
								<input
									type="checkbox"
									name="flatty_wordpress_pages_remove_revisions"
									id="flatty_wordpress_pages_remove_revisions"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_pages_remove_revisions')); ?>
								/>
		                    </div>
		                </div>
	                </div>

	                <!--HIDE AUTHOR-->
	                <div class="flatty-option">
	                    <div class="flatty-column">
	                        <label for="flatty_wordpress_posts_remove_author"><?php _e('Remove "Author" box', 'flatty-flat-admin-theme' ); ?></label>
							<div class="flatty-description"><?php _e('Displays a select box to choose a post author', 'flatty-flat-admin-theme' ); ?></div>
	                    </div>
	                    <div class="flatty-row multi-column">
		                    <div class="flatty-column">
		                    	<span>Posts</span>
		                        <input
									type="checkbox"
									name="flatty_wordpress_posts_remove_author"
									id="flatty_wordpress_posts_remove_author"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_posts_remove_author')); ?>
								/>
							</div>
							<div class="flatty-column">
								<span>Pages</span>
								<input
									type="checkbox"
									name="flatty_wordpress_pages_remove_author"
									id="flatty_wordpress_pages_remove_author"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_pages_remove_author')); ?>
								/>
		                    </div>
		                </div>
	                </div>

	                <!--HIDE SLUG-->
	                <div class="flatty-option">
	                    <div class="flatty-column">
	                        <label for="flatty_wordpress_posts_remove_slug"><?php _e('Remove "Slug" box', 'flatty-flat-admin-theme' ); ?></label>
							<div class="flatty-description"><?php _e('Displays an additional post slug box', 'flatty-flat-admin-theme' ); ?></div>
	                    </div>
	                    <div class="flatty-row multi-column">
		                    <div class="flatty-column">
		                    	<span>Posts</span>
		                        <input
									type="checkbox"
									name="flatty_wordpress_posts_remove_slug"
									id="flatty_wordpress_posts_remove_slug"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_posts_remove_slug')); ?>
								/>
							</div>
							<div class="flatty-column">
								<span>Pages</span>
								<input
									type="checkbox"
									name="flatty_wordpress_pages_remove_slug"
									id="flatty_wordpress_pages_remove_slug"
									value='1'
									<?php checked(1, get_option('flatty_wordpress_pages_remove_slug')); ?>
								/>
		                    </div>
		                </div>
	                </div>

	            </div>
	        </div>

		</div>


	</form>

	<?php
}

?>
