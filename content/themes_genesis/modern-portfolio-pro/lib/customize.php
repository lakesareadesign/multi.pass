<?php
/**
 * Modern Portfolio Pro.
 *
 * This file adds the Customizer additions to the Modern Portfolio Pro Theme.
 *
 * @package Modern Portfolio
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/modern-portfolio/
 */

/**
 * Registers settings and controls with the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
add_action( 'customize_register', 'modern_portfolio_customizer' );
function modern_portfolio_customizer( $wp_customize ) {

	class Child_MPP_Text_Control extends WP_Customize_Control {

		public $type = 'text'; 

		public function render_content() {
			$val = $this->value();
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<input class="allow-one-character" type="text" value="<?php echo esc_attr( $val[0] ); ?>" <?php $this->link(); ?> />
			</label>
			<script type="text/javascript">
				jQuery('body').on( 'change', '.allow-one-character', function(){
					var fullString = jQuery(this).val();
					
					jQuery(this).val(fullString.substring(0, 1).toUpperCase());
				});
			</script>
			<?php
		}

	}

	function modern_portfolio_sanitize_initial( $value ){

		if( $value ){
			$value = esc_attr( $value[0] );
		}

		return $value;

	}

	global $wp_customize;

	$wp_customize->add_section( 
		'modern-portfolio-icon', array(
			'title'       => __( 'Modern Portfolio Icon', 'modern-portfolio-pro' ),
			'description' => __( 'This will be displayed beside the site title and is limited to 1 character', 'modern-portfolio-pro' ),
			'priority'    => 35,
	) );

	$wp_customize->add_setting( 'modern_portfolio_custom_initial', array(
		'default'           => 'M',
		'sanitize_callback' => 'modern_portfolio_sanitize_initial',
		'type'              => 'option',
	) );

	$wp_customize->add_control(	new Child_MPP_Text_Control(	$wp_customize, 'icon_textbox', array(
		'label'    => __( 'Enter custom site initial:', 'modern-portfolio-pro' ),
		'section'  => 'modern-portfolio-icon',
		'settings' => 'modern_portfolio_custom_initial'        
	) ) );

}
