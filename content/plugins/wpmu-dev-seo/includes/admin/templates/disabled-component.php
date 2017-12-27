<?php
	$content = empty($content) ? '' : $content;
	$image = empty($image) ? '' : $image;
	$component = empty($component) ? '' : $component;
	$button_text = empty($button_text) ? '' : $button_text;
?>
<form method='post'>
	<section class="dev-box">
		<div class="box-title">
			<h3><?php _e('Get Started', 'wds'); ?></h3>
		</div>
		<div class="box-content">
			<?php
				$this->_render('disabled-component-inner', array(
					'content'     => $content,
					'image'       => $image,
					'component'   => $component,
					'button_text' => $button_text
				));
			?>
		</div>
	</section>
</form>