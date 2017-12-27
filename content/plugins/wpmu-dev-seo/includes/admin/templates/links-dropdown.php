<?php
	$label = empty($label) ? '' : $label;
	$links = empty($links) ? array() : $links;
?>

<div class="wds-links-dropdown">
	<a class="wds-links-dropdown-anchor" href="#">&hellip;</a>
	<ul>
		<?php if($label): ?>
			<li class="wds-links-dropdown-label"><?php echo $label; ?></li>
		<?php endif; ?>

		<?php foreach($links as $href => $text): ?>
			<li><a href="<?php echo esc_attr($href); ?>"><?php echo $text; ?></a></li>
		<?php endforeach; ?>
	</ul>
</div>