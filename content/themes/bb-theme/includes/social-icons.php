<div class="fl-social-icons">
<?php

foreach ( $icons as $icon ) {

	$link_target = ' target="_blank"';


	if ( ! empty( $settings[ 'fl-social-' . $icon ] ) ) {

		$setting = $settings[ 'fl-social-' . $icon ];
		$icon_sreen_reader = '<span class="sr-only">' . ucfirst( $icon ) . '</span>';
		if ( 'email' == $icon ) {
			$setting = 'mailto:' . $setting;
			$link_target = '';
			$icon = 'envelope';
		}

		$pre = ( 'envelope' == $icon || 'rss' == $icon ) ? 'fas' : 'fab';

		$icon = ( 'facebook' == $icon ) ? 'facebook-f' : $icon;

		if ( ! $circle ) {
				printf( '<a href="%s"%s>%s<i class="%s fa-%s %s"></i></a>', $setting, $link_target, $icon_sreen_reader, $pre, $icon, $settings['fl-social-icons-color'] );
		} else {
				printf( '<a href="%s" class="fa-stack icon-%s"%s>%s
				<i class="fas fa-circle fa-stack-2x %s"></i>
				<i class="%s fa-%s %s fa-stack-1x fa-inverse"></i>
				</a>',
					$setting,
					$icon,
					$link_target,
					$icon_sreen_reader,
					$settings['fl-social-icons-color'],
					$pre,
					$icon,
					$settings['fl-social-icons-color']
				);
		}
	}
}

?>
</div>
