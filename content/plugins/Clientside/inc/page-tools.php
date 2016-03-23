<div class="wrap">

	<h2><?php echo $page_info['title']; ?></h2>

	<?php Clientside_Pages::show_page_tabs( $page_info['slug'] ); ?>

	<div class="clientside-page-sidebar">
		<div class="clientside-widget clientside-widget-bordered">
			<div class="inside">
				<?php if ( is_multisite() ) { ?>

					<?php if ( Clientside_Options::get_saved_network_option( 'network-admins-only' ) ) { ?>
						<p><?php _e( 'Note that only Network Administrators have access to these Admin Tools.', 'clientside' ); ?></p>
					<?php } else { ?>
						<p><?php _e( 'Note that both Network Administrators and Site Administrators have access to these Admin Tools.', 'clientside' ); ?></p>
					<?php } ?>

					<?php if ( is_super_admin() ) { ?>
						<p><?php _e( 'Visit the Network Options to change this behavior.', 'clientside' ); ?></p>
						<a class="clientside-button-lined clientside-button-large clientside-button-w100p" href="<?php echo Clientside_Pages::get_page_url( 'clientside-options-network' ); ?>"><?php _e( 'Network Options', 'clientside' ); ?></a>
					<?php } ?>

				<?php } else { ?>
					<?php _e( 'Note that only Administrators have access to these Admin Tools.', 'clientside' ); ?>
				<?php } ?>

			</div>
		</div>
	</div>

	<ul class="clientside-page-content">

		<?php $page = Clientside_Pages::get_pages( 'clientside-admin-menu-editor' ); ?>
		<li class="postbox clientside-widget-bordered clientside-tool-item">

			<div class="clientside-tools-huge-icon">
				<a href="<?php echo Clientside_Pages::get_page_url( $page['slug'] ); ?>"><span class="dashicons dashicons-menu"></span></a>
			</div>

			<div class="clientside-tools-icon-sibling">
				<h3 class="hndle">
					<a href="<?php echo Clientside_Pages::get_page_url( $page['slug'] ); ?>"><?php echo $page['title']; ?></a>
				</h3>
				<div class="inside">
					<p>
						The menu editor allows you to reorder menu items, rename them and conditionally hide them for specific user roles. This avoids confusion and distraction for the affected user group.
					</p>
					<a href="<?php echo Clientside_Pages::get_page_url( $page['slug'] ); ?>" class="button-primary"><?php _e( 'Admin Menu Editor', 'clientside' ); ?></a>
				</div>
			</div>

		</li>

		<?php $page = Clientside_Pages::get_pages( 'clientside-admin-widget-manager' ); ?>
		<li class="postbox clientside-widget-bordered clientside-tool-item">

			<div class="clientside-tools-huge-icon">
				<a href="<?php echo Clientside_Pages::get_page_url( $page['slug'] ); ?>"><span class="dashicons dashicons-screenoptions"></span></a>
			</div>

			<div class="clientside-tools-icon-sibling">
				<h3 class="hndle">
					<a href="<?php echo Clientside_Pages::get_page_url( $page['slug'] ); ?>"><?php echo $page['title']; ?></a>
				</h3>
				<div class="inside">
					<p>
						The widget manager allows you to choose which admin widgets are visible to which user group. The widget manager lists widgets belonging to the Dashboard page and the Post Edit screen (all post types). Hiding a widget also makes it disappear from the page’s Screen Options.
					</p>
					<a href="<?php echo Clientside_Pages::get_page_url( $page['slug'] ); ?>" class="button-primary"><?php _e( 'Admin Widget Manager', 'clientside' ); ?></a>
				</div>
			</div>

		</li>

		<?php $page = Clientside_Pages::get_pages( 'clientside-admin-column-manager' ); ?>
		<li class="postbox clientside-widget-bordered clientside-tool-item">

			<div class="clientside-tools-huge-icon">
				<a href="<?php echo Clientside_Pages::get_page_url( $page['slug'] ); ?>"><span class="dashicons dashicons-editor-justify"></span></a>
			</div>

			<div class="clientside-tools-icon-sibling">
				<h3 class="hndle">
					<a href="<?php echo Clientside_Pages::get_page_url( $page['slug'] ); ?>"><?php echo $page['title']; ?></a>
				</h3>
				<div class="inside">
					<p>
						The column manager allows you to choose which listing columns are visible to which user group. Hiding a column also makes it disappear from the page’s Screen Options.
					</p>
					<a href="<?php echo Clientside_Pages::get_page_url( $page['slug'] ); ?>" class="button-primary"><?php _e( 'Admin Column Manager', 'clientside' ); ?></a>
				</div>
			</div>

		</li>

	</ul>

	</div>

</div>

