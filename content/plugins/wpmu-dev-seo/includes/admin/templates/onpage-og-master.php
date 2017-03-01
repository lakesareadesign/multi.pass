<fieldset class="toggleable inactive">
	<legend><?php esc_html_e('OpenGraph', 'wds'); ?></legend>
	<div class="inside">
		<?php
			$this->_render('onpage-og-title', array(
				'for_type' => $for_type,
			));
			$this->_render('onpage-og-images', array(
				'for_type' => $for_type,
			));
			$this->_render('onpage-og-description', array(
				'for_type' => $for_type,
			));
		?>
	</div>
</fieldset>