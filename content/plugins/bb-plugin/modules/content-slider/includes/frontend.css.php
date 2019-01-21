.fl-node-<?php echo $id; ?> .fl-content-slider,
.fl-node-<?php echo $id; ?> .fl-slide {
	min-height: <?php echo $settings->height; ?>px;
}
.fl-node-<?php echo $id; ?> .fl-slide-foreground {
	margin: 0 auto;
	max-width: <?php echo $settings->max_width; ?>px;
}
<?php
if ( $settings->arrows ) :
	if ( isset( $settings->arrows_bg_color ) && ! empty( $settings->arrows_bg_color ) ) :
?>
	.fl-node-<?php echo $id; ?> .fl-content-slider-svg-container {
		background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->arrows_bg_color ); ?>;
		width: 40px;
		height: 40px;

		<?php if ( isset( $settings->arrows_bg_style ) && 'circle' == $settings->arrows_bg_style ) : ?>
		-webkit-border-radius: 50%;
		-moz-border-radius: 50%;
		-ms-border-radius: 50%;
		-o-border-radius: 50%;
		border-radius: 50%;
		<?php endif; ?>
	}
	.fl-node-<?php echo $id; ?> .fl-content-slider-navigation svg {
		height: 100%;
		width: 100%;
		padding: 5px;
	}
	<?php
	endif;

	if ( isset( $settings->arrows_text_color ) && ! empty( $settings->arrows_text_color ) ) :
	?>
	.fl-node-<?php echo $id; ?> .fl-content-slider-navigation path {
		fill: <?php echo FLBuilderColor::hex_or_rgb( $settings->arrows_text_color ); ?>;
	}
	<?php
	endif;
endif;

for ( $i = 0; $i < count( $settings->slides ); $i++ ) {

	// Make sure we have a slide.
	if ( ! is_object( $settings->slides[ $i ] ) ) {
		continue;
	}

	// Slide Settings
	$slide = $settings->slides[ $i ];

	// Slide Background Color
	if ( 'color' == $slide->bg_layout && ! empty( $slide->bg_color ) ) {
		echo '.fl-node-' . $id . ' .fl-slide-' . $i;
		echo ' { background-color: ' . FLBuilderColor::hex_or_rgb( $slide->bg_color ) . '; }';
	}

	// Foreground Photo/Video
	if ( 'photo' == $slide->content_layout || 'video' == $slide->content_layout ) {

		$photo_width = 100 - $slide->text_width;

		// Foreground Photo/Video Width
		if ( 'center' != $slide->text_position ) {
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-photo-wrap ';
			echo '{ width: ' . $photo_width . '%; }';
		}

		// Foreground Photo/Video Margins
		if ( 'left' == $slide->text_position ) {
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-photo ';
			echo '{ margin-right: ' . $slide->text_margin_left . 'px; ';
			echo 'margin-top: ' . $slide->text_margin_top . 'px; ';
			echo 'margin-bottom: ' . $slide->text_margin_bottom . 'px; }';
		} elseif ( 'center' == $slide->text_position ) {
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-photo ';
			echo '{ margin-left: ' . $slide->text_margin_left . 'px; ';
			echo 'margin-right: ' . $slide->text_margin_right . 'px; ';
			echo 'margin-bottom: ' . $slide->text_margin_bottom . 'px; }';
		} elseif ( 'right' == $slide->text_position ) {
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-photo ';
			echo '{ margin-left: ' . $slide->text_margin_right . 'px; ';
			echo 'margin-top: ' . $slide->text_margin_top . 'px; ';
			echo 'margin-bottom: ' . $slide->text_margin_bottom . 'px; }';
		}
	}

	// Text Width and Margins
	if ( 'none' != $slide->content_layout ) {

		// Content wrap width
		echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-content-wrap ';
		echo '{ width: ' . $slide->text_width . '%; }';

		// Margins
		echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-content ';
		echo '{ margin-right: ' . $slide->text_margin_right . 'px; ';
		echo 'margin-left: ' . $slide->text_margin_left . 'px; ';

		// 100% height, don't use top/bottom margins
		if ( '100%' == $slide->text_bg_height && ! empty( $slide->text_bg_color ) ) {

			// Content height
			echo ' min-height: ' . $settings->height . 'px; }';

			// Content wrap height
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-content-wrap ';
			echo '{ min-height: ' . $settings->height . 'px; }';
		} else {
			echo 'margin-top: ' . $slide->text_margin_top . 'px; ';
			echo 'margin-bottom: ' . $slide->text_margin_bottom . 'px; }';
		}
	}

	// Text Styles
	if ( 'custom' == $slide->title_size ) {
		echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-title ';
		echo '{ font-size: ' . $slide->title_custom_size . 'px; }';
	}

	// Text Color
	if ( ! empty( $slide->text_color ) ) {
		echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-title, ';
		echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-text, ';
		echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-text * ';
		echo '{ color: ' . FLBuilderColor::hex_or_rgb( $slide->text_color ) . '; }';
		echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-text strong ';
		echo '{ color: inherit; }';
	}

	// Text BG Color
	if ( ! empty( $slide->text_bg_color ) ) {
		echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-content ';
		echo '{ background-color: ' . FLBuilderColor::hex_or_rgb( $slide->text_bg_color ) . ';';
		echo 'padding-top: ' . $slide->text_padding_top . 'px;';
		echo 'padding-right: ' . $slide->text_padding_right . 'px;';
		echo 'padding-bottom: ' . $slide->text_padding_bottom . 'px;';
		echo 'padding-left: ' . $slide->text_padding_left . 'px;}';
	}

	// Text Shadow
	if ( $slide->text_shadow ) {
		echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-title, ';
		echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-text ';
		echo '{ text-shadow: 0 0 5px rgba(0,0,0,0.3); }';
	}

	// Responsive Text Styles
	if ( $global_settings->responsive_enabled ) {
		echo '@media (max-width: ' . $global_settings->responsive_breakpoint . 'px) { ';

		// Responsive Text Color
		if ( ! empty( $slide->r_text_color ) ) {
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-title, ';
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-text, ';
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-text * ';
			echo '{ color: ' . FLBuilderColor::hex_or_rgb( $slide->r_text_color ) . '; }';
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-text strong ';
			echo '{ color: inherit; }';
		} else {
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-title, ';
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-text, ';
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-text * ';
			echo '{ color: inherit; }';
		}

		// Responsive Text BG Color
		if ( ! empty( $slide->r_text_bg_color ) ) {
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-content ';
			echo '{ background-color: ' . FLBuilderColor::hex_or_rgb( $slide->r_text_bg_color ) . '; }';
		} else {
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-content ';
			echo '{ background-color: transparent; }';
		}

		// Responsive Text Shadow
		echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-title, ';
		echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-text ';
		echo '{ text-shadow: none; }';

		echo ' }';
	}

	// Button Styles
	if ( 'button' == $slide->cta_type ) {
		FLBuilder::render_module_css( 'button', $id . ' .fl-slide-' . $i, $module->get_button_settings( $slide ) );
	}
}
