<?php $groups_enabled = ! empty( $_view['options']['sitemap-buddypress-groups'] ); ?>
<div class="wds-sitemap-section wds-toggleable <?php echo $groups_enabled ? '' : 'inactive'; ?>">
	<?php
	$this->_render( 'sitemap/sitemap-part', array(
		'item'        => 'sitemap-buddypress-groups',
		'item_name'   => '',
		'item_label'  => __( 'BuddyPress Groups', 'wds' ),
		'option_name' => $_view['option_name'] . '[sitemap-buddypress-groups]',
	) );
	?>

	<div class="wds-sitemap-sub-section wds-toggleable-inside-box">
		<?php if ( ! empty( $exclude_groups ) ) : ?>
			<?php foreach ( $exclude_groups as $exclude_bp_role => $exclude_bp_role_label ) : ?>
				<?php
				$this->_render( 'sitemap/sitemap-part', array(
					'item'        => 'sitemap-buddypress-' . $exclude_bp_role,
					'item_name'   => '',
					'item_label'  => $exclude_bp_role_label,
					'option_name' => $_view['option_name'] . '[exclude_bp_groups][]',
				) );
				?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>

<?php $profiles_enabled = ! empty( $_view['options']['sitemap-buddypress-profiles'] ); ?>
<div class="wds-sitemap-section wds-toggleable <?php echo $profiles_enabled ? '' : 'inactive'; ?>">
	<?php
	$this->_render( 'sitemap/sitemap-part', array(
		'item'        => 'sitemap-buddypress-profiles',
		'item_name'   => '',
		'item_label'  => __( 'BuddyPress Profiles', 'wds' ),
		'option_name' => $_view['option_name'] . '[sitemap-buddypress-profiles]',
	) );
	?>

	<div class="wds-sitemap-sub-section wds-toggleable-inside-box">
		<?php if ( ! empty( $exclude_roles ) ) : ?>
			<?php foreach ( $exclude_roles as $exclude_bp_role => $exclude_bp_role_label ) : ?>
				<?php
				$this->_render( 'sitemap/sitemap-part', array(
					'item'        => 'sitemap-buddypress-roles-' . $exclude_bp_role,
					'item_name'   => '',
					'item_label'  => $exclude_bp_role_label,
					'option_name' => $_view['option_name'] . '[exclude_bp_roles][]',
				) );
				?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>