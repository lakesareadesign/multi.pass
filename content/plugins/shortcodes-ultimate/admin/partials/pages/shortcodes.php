<?php defined( 'ABSPATH' ) or exit; ?>

<div id="su_admin_shortcodes" class="wrap su-admin-shortcodes">

		<?php if ( ! $this->is_single_shortcode_page() ) : ?>
			<?php $this->the_template( 'pages/shortcodes-list' ); ?>
		<?php else : ?>
			<?php $this->the_template( 'pages/shortcodes-single' ); ?>
		<?php endif; ?>

</div>
