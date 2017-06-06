<ul class="wphb-tabs hide-on-mobile">
	<?php foreach ( $this->get_tabs() as $tab => $name ): ?>
		<li class="wphb-tab <?php echo ( $tab === $this->get_current_tab() ) ? 'current' : null ?>">
			<a href="<?php echo esc_url( $this->get_tab_url( $tab ) ) ?>">
				<?php echo $name; ?>
			</a>
			<?php do_action( 'wphb_admin_after_tab_' . $this->get_slug(), $tab ); ?>
		</li>
	<?php endforeach; ?>
</ul>

<div class="mline hide-on-large">
	<div class="select-container mobile-nav">
		<span class="dropdown-handle"><i class="wdv-icon wdv-icon-reorder"></i></span>
		<select class="mobile-nav wdev-styled" style="display: none;">
			<?php foreach ( $this->get_tabs() as $tab => $name ): ?>
				<option value="#<?php echo $tab; ?>" <?php selected( $this->get_current_tab(), $tab ); ?>><?php echo $name; ?></option>
			<?php endforeach; ?>
		</select>
		<div class="select-list-container">
			<div class="list-value">
				<?php echo $this->get_tab_name( $this->get_current_tab() ); ?>
			</div>
			<ul class="list-results wphb-tabs">
				<?php foreach ( $this->get_tabs() as $tab => $name ): ?>
					<li class="wphb-tab <?php echo ( $tab === $this->get_current_tab() ) ? 'current' : null ?>">
						<a href="<?php echo esc_url( $this->get_tab_url( $tab ) ) ?>" data-tab="#<?php echo $tab; ?>"><?php echo $name; ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div><!-- end mline -->