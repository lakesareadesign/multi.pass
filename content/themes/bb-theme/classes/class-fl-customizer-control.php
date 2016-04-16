<?php

/**
 * Custom Customizer controls for the Beaver Builder theme.
 *
 * @since 1.2.0
 */
final class FLCustomizerControl extends WP_Customize_Control {

	/**
	 * Used to connect controls to each other.
	 *
	 * @since 1.2.0
	 * @var bool $connect
	 */
	public $connect = false;

	/**
	 * Used to set the mode for code controls.
	 *
	 * @since 1.3.3
	 * @var bool $mode
	 */
	public $mode = 'html';

	/**
	 * If true, the preview button for a control will be rendered.
	 *
	 * @since 1.3.3
	 * @var bool $preview_button
	 */
	public $preview_button = false;

	/**
	 * Renders the content for a control based on the type
	 * of control specified when this class is initialized.
	 *
	 * @since 1.2.0
	 * @access protected
	 * @return void
	 */
	protected function render_content()
	{
		switch($this->type) {

			case 'font':
			$this->render_font();
			break;

			case 'font-weight':
			$this->render_font_weight();
			break;

			case 'code':
			$this->render_code();
			break;

			case 'line':
			$this->render_line();
			break;

			case 'export-import':
			$this->render_export_import();
			break;

			case 'slider':
			$this->render_slider();
			break;
		}
	}

	/**
	 * Renders the title and description for a control.
	 *
	 * @since 1.2.0
	 * @access protected
	 * @return void
	 */
	protected function render_content_title()
	{
		if(!empty($this->label)) {
			echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
		}
		if(!empty($this->description)) {
			echo '<span class="description customize-control-description">' . $this->description . '</span>';
		}
	}

	/**
	 * Renders the connect attribute for a connected control.
	 *
	 * @since 1.2.0
	 * @access protected
	 * @return void
	 */
	protected function render_connect_attribute()
	{
		if ( $this->connect ) {
			echo ' data-connected-control="'. $this->connect .'"';
		}
	}

	/**
	 * Renders a font control.
	 *
	 * @since 1.2.0
	 * @access protected
	 * @return void
	 */
	protected function render_font()
	{
		echo '<label>';
		$this->render_content_title();
		echo '<select ';
		$this->link();
		$this->render_connect_attribute();
		echo '>';
		echo '<optgroup label="System">';

		foreach(FLFontFamilies::$system as $name => $variants) {
			echo '<option value="'. $name .'" '. selected($name, $this->value(), false) .'>'. $name .'</option>';
		}

		echo '<optgroup label="Google">';

		foreach(FLFontFamilies::$google as $name => $variants) {
			echo '<option value="'. $name .'" '. selected($name, $this->value(), false) .'>'. $name .'</option>';
		}

		echo '</select>';
		echo '</label>';
	}

	/**
	 * Renders a font weight control.
	 *
	 * @since 1.2.0
	 * @access protected
	 * @return void
	 */
	protected function render_font_weight()
	{
		echo '<label>';
		$this->render_content_title();
		echo '<select ';
		$this->link();
		$this->render_connect_attribute();
		echo '>';		
		echo '<option value="'. $this->value() .'" selected="selected">'. $this->value() .'</option>';
		echo '</select>';
		echo '</label>';
	}

	/**
	 * Renders a code control.
	 *
	 * @since 1.2.0
	 * @access protected
	 * @return void
	 */
	protected function render_code()
	{
		$this->render_content_title();
		
		if ( $this->preview_button ) {
			echo '<input type="button" name="fl-preview-button" class="button fl-preview-button" value="Preview" />';
		}
		
		echo '<label>';
		echo '<textarea rows="15" style="width:100%" ';
		$this->link();
		echo '>' . $this->value() . '</textarea>';
		echo '<div class="fl-code-editor" data-mode="' . $this->mode . '"></div>';
		echo '</label>';
	}

	/**
	 * Renders a line break control.
	 *
	 * @since 1.2.0
	 * @access protected
	 * @return void
	 */
	protected function render_line()
	{
		echo '<hr />';
	}

	/**
	 * Renders the export/import control.
	 *
	 * @since 1.2.0
	 * @access protected
	 * @return void
	 */
	protected function render_export_import()
	{
		$plugin = 'customizer-export-import';
		$nonce  = wp_create_nonce( 'install-plugin_' . $plugin );
		$url    = admin_url( 'update.php?action=install-plugin&plugin=' . $plugin . '&_wpnonce=' . $nonce );

		echo '<p>' . __( 'Please install and activate the "Customizer Export/Import" plugin to proceed.', 'fl-automator' ) . '</p>';
		echo '<a class="install-now button" href="' . $url . '">' . _x( 'Install &amp; Activate', '...a plugin.', 'fl-automator' ) . '</a>';
	}

	/**
	 * Renders the slider control.
	 *
	 * @since 1.5.0
	 * @access protected
	 * @return void
	 */
	protected function render_slider()
	{	
		$this->choices['min']   = ( isset( $this->choices['min'] ) )   ? $this->choices['min']   : '0';
		$this->choices['max']   = ( isset( $this->choices['max'] ) )   ? $this->choices['max']   : '100';
		$this->choices['step']  = ( isset( $this->choices['step'] ) )  ? $this->choices['step']  : '1';

		echo '<label>';
		$this->render_content_title();
		echo '<div class="wrapper">';
		echo '<input type="range" min="' . $this->choices['min'] . '" max="' . $this->choices['max'] . '" step="' . $this->choices['step'] . '" value="' . $this->value() . '"';
		$this->link();
		echo 'data-reset_value="' . $this->settings['default']->default . '">';
		echo '<div class="fl-range-value">';
		echo '<input type="text" id="fl-range-value-input" value="' . $this->value() . '">';
		echo '</div>';
		echo '<div class="fl-slider-reset">';
		echo '<span class="dashicons dashicons-image-rotate"></span>';
		echo '</div>';
		echo '</div>';
		echo '</label>';
	}
}