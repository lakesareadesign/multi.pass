<div class="fl-social-icons">
<?php

foreach($icons as $icon) {

	$link_target = ' target="_blank"';

	if(!empty($settings['fl-social-' . $icon])) {

		if($icon == 'email') {
			$settings['fl-social-' . $icon] = 'mailto:' . $settings['fl-social-' . $icon];
			$link_target = '';
		}

		$class = 'fl-icon fl-icon-color-'. $settings['fl-social-icons-color'] .' fl-icon-'. $icon .' fl-icon-'. $icon;
		$class .= $circle ? '-circle' : '-regular';
		echo '<a href="'. $settings['fl-social-' . $icon] . '"' . $link_target . ' class="'. $class .'"></a>';
	}
}

?>
</div>