<?php
/**
 * Slush Pro.
 *
 * This file adds the customizer additions to the Slush Pro Theme.
 *
 * @package Slush_Pro
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/slush/
 */

add_action( 'customize_register', 'zp_add_customizer_controls' );
/**
 * Theme Customizer Additional Controls.
 *
 * This is where you add extra customizer controller by extending the WP_Customize_Control Class.
 */
function zp_add_customizer_controls() {
	// Textarea Control.
	class ZP_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';     
	
		public function render_content() { ?>

			<label><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span></label>
			<textarea rows="10" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		<?php
		}
	}

}

/**
 * Customizer theme option.
 */
class ZP_Customizer extends Genesis_Customizer_Base {

	public function __construct() {

		if ( method_exists( $this, 'theme_body_font_register' ) ) {
			add_action( 'customize_register', array( $this, 'theme_body_font_register' ), 30 );
		}

		if ( method_exists( $this, 'theme_heading_font_register' ) ) {
			add_action( 'customize_register', array( $this, 'theme_heading_font_register' ), 30 );
		}

		if ( method_exists( $this, 'site_header_register' ) ) {
			add_action( 'customize_register', array( $this, 'site_header_register' ), 31 );
		}

		if ( method_exists( $this, 'accent_color_register' ) ) {
			add_action( 'customize_register', array( $this, 'accent_color_register' ), 31 );
		}

		if ( method_exists( $this, 'footer_settings_register' ) ) {
			add_action( 'customize_register', array( $this, 'footer_settings_register' ), 31 );
		}

		if ( method_exists( $this, 'blog_settings_register' ) ) {
			add_action( 'customize_register', array( $this, 'blog_settings_register' ), 31 );
		}

	}

	public function theme_heading_font_register( $wp_customize ) {

		$this->theme_heading_font( $wp_customize );

	}

	public function theme_body_font_register( $wp_customize ) {

		$this->theme_body_font( $wp_customize );

	}

	public function site_header_register( $wp_customize ) {

		$this->header_layout( $wp_customize );

	}

	public function accent_color_register( $wp_customize ) {

		$this->accent_color( $wp_customize );

	}

	public function footer_settings_register( $wp_customize ) {

		$this->footer_settings( $wp_customize );

	}

	public function blog_settings_register( $wp_customize ) {

		$this->blog_settings( $wp_customize );
	
	}

	// Blog Settings.
	private function blog_settings( $wp_customize ) {

		$wp_customize->add_section( 'zp_blog_settings', array(
			'title' => __( 'Blog Settings', 'slush-pro' ),
		) );

		// Read More Label.
		$wp_customize->add_setting( 'read_more', array(
			'default' => 'Read More →',
		) );

		$wp_customize->add_control( 'read_more', array(
			'label'    => __( 'Read More Label', 'slush-pro' ),
			'section'  => 'zp_blog_settings',
			'settings' => 'read_more',
			'type'     => 'text',
		) );

		// Display Blog Author.
		$wp_customize->add_setting( 'blog_author', array(
			'default' => '1',
		) );

		$wp_customize->add_control( 'blog_author', array(
			'label'    => __( 'Display Blog Author?', 'slush-pro' ),
			'section'  => 'zp_blog_settings',
			'settings' => 'blog_author',
			'type'     => 'checkbox',
		) );

		// Blog Author Label.
		$wp_customize->add_setting( 'blog_author_label', array(
			'default' => '',
		) );

		$wp_customize->add_control( 'blog_author_label', array(
			'label'    => __( 'Blog Author Label', 'slush-pro' ),
			'section'  => 'zp_blog_settings',
			'settings' => 'blog_author_label',
			'type'     => 'text',
		) );

		// Display Blog Comment.
		$wp_customize->add_setting( 'blog_comment', array(
			'default' => '1',
		) );

		$wp_customize->add_control( 'blog_comment', array(
			'label'    => __( 'Display Blog Comment?', 'slush-pro' ),
			'section'  => 'zp_blog_settings',
			'settings' => 'blog_comment',
			'type'     => 'checkbox',
		) );

		// Blog Comment Label.
		$wp_customize->add_setting( 'blog_comment_label', array(
			'default' => '',
		) );

		$wp_customize->add_control( 'blog_comment_label', array(
			'label'    => __( 'Blog Comment Label', 'slush-pro' ),
			'section'  => 'zp_blog_settings',
			'settings' => 'blog_comment_label',
			'type'     => 'text',
		) );

		// Display Blog Like.
		$wp_customize->add_setting( 'blog_like', array(
			'default' => '1',
		) );

		$wp_customize->add_control( 'blog_like', array(
			'label'    => __( 'Display Blog Like?', 'slush-pro' ),
			'section'  => 'zp_blog_settings',
			'settings' => 'blog_like',
			'type'     => 'checkbox',
		) );

		// Display Blog Read.
		$wp_customize->add_setting( 'blog_read', array(
			'default' => '1',
		) );

		$wp_customize->add_control( 'blog_read', array(
			'label'    => __( 'Display Blog Read?', 'slush-pro' ),
			'section'  => 'zp_blog_settings',
			'settings' => 'blog_read',
			'type'     => 'checkbox',
		) );

		// Minute(s) Read Label.
		$wp_customize->add_setting( 'blog_read_label', array(
			'default' => '',
		) );

		$wp_customize->add_control( 'blog_read_label', array(
			'label'    => __( 'Blog Read Label', 'slush-pro' ),
			'section'  => 'zp_blog_settings',
			'settings' => 'blog_read_label',
			'type'     => 'text',
		) );

		// Display Blog Date.
		$wp_customize->add_setting( 'blog_date', array(
			'default' => '1',
		) );

		$wp_customize->add_control( 'blog_date', array(
			'label'    => __( 'Display Blog Date?', 'slush-pro' ),
			'section'  => 'zp_blog_settings',
			'settings' => 'blog_date',
			'type'     => 'checkbox',
		) );

		// Blog Date Label.
		$wp_customize->add_setting( 'blog_date_label', array(
			'default' => '',	
		) );

		$wp_customize->add_control( 'blog_date_label', array(
			'label'    => __( 'Blog Date Label', 'slush-pro' ),
			'section'  => 'zp_blog_settings',
			'settings' => 'blog_date_label',
			'type'     => 'text',
		) );

		// Display Blog Tags.
		$wp_customize->add_setting( 'blog_tags', array(
			'default' => '1',
		) );

		$wp_customize->add_control( 'blog_tags', array(
			'label'    => __( 'Display Blog Tags?', 'slush-pro' ),
			'section'  => 'zp_blog_settings',
			'settings' => 'blog_tags',
			'type'     => 'checkbox',
		) );

		// Display Blog Categories.
		$wp_customize->add_setting( 'blog_categories', array(
			'default' => '1',
		) );

		$wp_customize->add_control( 'blog_categories', array(
			'label'    => __( 'Display Blog Categories?', 'slush-pro' ),
			'section'  => 'zp_blog_settings',
			'settings' => 'blog_categories',
			'type'     => 'checkbox',
		) );

	}
	
	// Footer Settings.
	private function footer_settings( $wp_customize ) {

		$wp_customize->add_section( 'zp_footer_settings', array(
			'title' => __( 'Footer Settings', 'slush-pro' ),
		) );

		// Footer Text.
		$wp_customize->add_setting( 'footer_text', array(
			'default' => '',
		) );

		$wp_customize->add_control( new ZP_Textarea_Control( $wp_customize, 'footer_text', array(
			'label'    => __( 'Footer Text', 'slush-pro' ),
			'section'  => 'zp_footer_settings',
			'settings' => 'footer_text',
		) ) );

		// Footer Logo.
		$wp_customize->add_setting( 'footer_logo', array(
			'default' => '',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_logo', array(
			'label'    => __( 'Footer Logo', 'slush-pro' ),
			'section'  => 'zp_footer_settings',
			'settings' => 'footer_logo',
		) ) );

	}

	// Accent Color.
	private function accent_color( $wp_customize ) {

		$wp_customize->add_section( 'zp_accent_color', array(
			'title' => __( 'Accent Colors', 'slush-pro' ),
		) );

		// Default Color.
		$wp_customize->add_setting( 'accent_default', array(
			'default' => '',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_default', array(
			'label'    => __( 'Accent Default', 'slush-pro' ),
			'section'  => 'zp_accent_color',
			'settings' => 'accent_default',
		) ) );

	}

	// Site Header.
	private function header_layout( $wp_customize ) {

		$wp_customize->add_section( 'zp_header_layout', array(
			'title' => __( 'Header Layout', 'slush-pro' ),
		) );

		$wp_customize->add_setting( 'zp_header_layout', array(
			'default' => '',
		) );

		$wp_customize->add_control( 'zp_header_layout', array(
				'choices'  => array(
					'header_one'   => 'Header 1',
					'header_two'   => 'Header 2',
					'header_three' => 'Header 3',
				), 
				'label'    => __( 'Select Header Layout', 'slush-pro' ),
				'section'  => 'genesis_layout',
				'settings' => 'zp_header_layout',
				'type'     => 'radio',
		) );

	}

	// Theme body font style.
	private function theme_body_font( $wp_customize ) {

		$wp_customize->add_section( 'body_style', array(
			'title' => __( 'Body Style', 'slush-pro' ),
		) );

		// Body Font Family.
		$wp_customize->add_setting( 'body_font', array(
			'default' => '',
		) );
	
		$wp_customize->add_control( 'body_font', array(
			'choices'  => $this->zp_googlefonts_array(),
			'label'    => __( 'Body Font Family', 'slush-pro' ),
			'section'  => 'body_style',
			'settings' => 'body_font',
			'type'     => 'select',
		) );

		// Body Font Weight.
		$wp_customize->add_setting( 'body_font_weight', array(
			'default' => '',
		) );
	
		$wp_customize->add_control( 'body_font_weight', array(
			'choices'  => $this->zp_font_weights(),
			'label'    => __( 'Body Font Weight', 'slush-pro' ),
			'section'  => 'body_style',
			'settings' => 'body_font_weight',
			'type'     => 'select',
		) );

		// Body Font Style.
		$wp_customize->add_setting( 'body_font_style', array(
			'default' => '',
		) );
	
		$wp_customize->add_control( 'body_font_style', array(
			'choices'  => $this->zp_font_styles(),
			'label'    => __( 'Body Font Style', 'slush-pro' ),
			'section'  => 'body_style',
			'settings' => 'body_font_style',
			'type'     => 'select',
		) );

		// Body Font size.
		$wp_customize->add_setting( 'body_font_size', array(
			'default' => '',
		) );
	
		$wp_customize->add_control( 'body_font_size', array(
			'label'    => __( 'Body Font Size', 'slush-pro' ),
			'section'  => 'body_style',
			'settings' => 'body_font_size',
			'type'     => 'text',
		) );

		// Body Color.
		$wp_customize->add_setting( 'body_color', array(
			'default' => '',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'body_color', array(
			'label'    => __( 'Body Color', 'slush-pro' ),
			'section'  => 'body_style',
			'settings' => 'body_color',
		) ) );

	}


	// Theme heading style.
	private function theme_heading_font( $wp_customize ) {

		$wp_customize->add_section( 'heading_style', array(
			'title' => __( 'Heading Style', 'slush-pro' ),
		) );

		// Headings Font Family.
		$wp_customize->add_setting( 'head_font', array(
			'default' => '',
		) );
	
		$wp_customize->add_control( 'head_font', array(
			'choices'  => $this->zp_googlefonts_array(),
			'label'    => __( 'Headings Font Family', 'slush-pro' ),
			'section'  => 'heading_style',
			'settings' => 'head_font',
			'type'     => 'select',
		) );

		// Head Font Weight.
		$wp_customize->add_setting( 'head_font_weight', array(
			'default' => '',
		) );
	
		$wp_customize->add_control( 'head_font_weight', array(
			'choices'  => $this->zp_font_weights(),
			'label'    => __( 'Headings Font Weight', 'slush-pro' ),
			'section'  => 'heading_style',
			'settings' => 'head_font_weight',
			'type'     => 'select',
		) );

		// Head Font Style.
		$wp_customize->add_setting( 'head_font_style', array(
			'default' => '',
		) );
	
		$wp_customize->add_control( 'head_font_style', array(
			'choices'  => $this->zp_font_styles(),
			'label'    => __( 'Headings Font Weight', 'slush-pro' ),
			'section'  => 'heading_style',
			'settings' => 'head_font_style',
			'type'     => 'select',
		) );

		// Head Color.
		$wp_customize->add_setting( 'head_color', array(
			'default' => '',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'head_color', array(
			'label'    => __( 'Headings Color', 'slush-pro' ),
			'section'  => 'heading_style',
			'settings' => 'head_color',
		) ) );

		// Head Font Size.
		$wp_customize->add_setting( 'head_font_size', array(
			'default' => '',
		) );
	
		$wp_customize->add_control( 'head_font_size', array(
			'label'    => __( 'H1 Font Size', 'slush-pro' ),
			'section'  => 'heading_style',
			'settings' => 'head_font_size',
			'type'     => 'text',
		) );

		// h2.
		$wp_customize->add_setting( 'head2_font_size', array(
			'default' => '',
		) );
	
		$wp_customize->add_control( 'head2_font_size', array(
			'label'    => __( 'H2 Font Size', 'slush-pro' ),
			'section'  => 'heading_style',
			'settings' => 'head2_font_size',
			'type'     => 'text',
		) );

		// h3.
		$wp_customize->add_setting( 'head3_font_size', array(
			'default' => '',
		) );
	
		$wp_customize->add_control( 'head3_font_size', array(
			'label'    => __( 'H3 Font Size', 'slush-pro' ),
			'section'  => 'heading_style',
			'settings' => 'head3_font_size',
			'type'     => 'text',
		) );

		// h4.
		$wp_customize->add_setting( 'head4_font_size', array(
			'default' => '',
		) );
	
		$wp_customize->add_control( 'head4_font_size', array(
			'label'    => __( 'H4 Font Size', 'slush-pro' ),
			'section'  => 'heading_style',
			'settings' => 'head4_font_size',
			'type'     => 'text',
		) );

		// h5.
		$wp_customize->add_setting( 'head5_font_size', array(
			'default' => '',
		) );
	
		$wp_customize->add_control( 'head5_font_size', array(
			'label'    => __( 'H5 Font Size', 'slush-pro' ),
			'section'  => 'heading_style',
			'settings' => 'head5_font_size',
			'type'     => 'text',
		) );

		// h6.
		$wp_customize->add_setting( 'head6_font_size', array(
			'default' => '',
		) );
	
		$wp_customize->add_control( 'head6_font_size', array(
			'label'    => __( 'H6 Font Size', 'slush-pro' ),
			'section'  => 'heading_style',
			'settings' => 'head6_font_size',
			'type'     => 'text',
		) );

	}

	// List of Google Fonts.
	function zp_googlefonts_array() {

		$zp_fonts = array(
			''                          => 'Default',
			'ABeeZee'                   => 'ABeeZee',
			'Abel'                      => 'Abel',
			'Abhaya+Libre'              => 'Abhaya Libre',
			'Abril+Fatface'             => 'Abril Fatface',
			'Aclonica'                  => 'Aclonica',
			'Acme'                      => 'Acme',
			'Actor'                     => 'Actor',
			'Adamina'                   => 'Adamina',
			'Advent+Pro'                => 'Advent Pro',
			'Aguafina+Script'           => 'Aguafina Script',
			'Akronim'                   => 'Akronim',
			'Aladin'                    => 'Aladin',
			'Aldrich'                   => 'Aldrich',
			'Alef'                      => 'Alef',
			'Alegreya'                  => 'Alegreya',
			'Alegreya+SC'               => 'Alegreya SC',
			'Alegreya+Sans'             => 'Alegreya Sans',
			'Alegreya+Sans+SC'          => 'Alegreya Sans SC',
			'Alex+Brush'                => 'Alex Brush',
			'Alfa+Slab+One'             => 'Alfa Slab One',
			'Alice'                     => 'Alice',
			'Alike'                     => 'Alike',
			'Alike+Angular'             => 'Alike Angular',
			'Allan'                     => 'Allan',
			'Allerta'                   => 'Allerta',
			'Allerta+Stencil'           => 'Allerta Stencil',
			'Allura'                    => 'Allura',
			'Almendra'                  => 'Almendra',
			'Almendra+Display'          => 'Almendra Display',
			'Almendra+SC'               => 'Almendra SC',
			'Amarante'                  => 'Amarante',
			'Amaranth'                  => 'Amaranth',
			'Amatic+SC'                 => 'Amatic SC',
			'Amatica+SC'                => 'Amatica SC',
			'Amethysta'                 => 'Amethysta',
			'Amiko'                     => 'Amiko',
			'Amiri'                     => 'Amiri',
			'Amita'                     => 'Amita',
			'Anaheim'                   => 'Anaheim',
			'Andada'                    => 'Andada',
			'Andika'                    => 'Andika',
			'Angkor'                    => 'Angkor',
			'Annie+Use+Your+Telescope'  => 'Annie Use Your Telescope',
			'Anonymous+Pro'             => 'Anonymous Pro',
			'Antic'                     => 'Antic',
			'Antic+Didone'              => 'Antic Didone',
			'Antic+Slab'                => 'Antic Slab',
			'Anton'                     => 'Anton',
			'Arapey'                    => 'Arapey',
			'Arbutus'                   => 'Arbutus',
			'Arbutus+Slab'              => 'Arbutus Slab',
			'Architects+Daughter'       => 'Architects Daughter',
			'Archivo+Black'             => 'Archivo Black',
			'Archivo+Narrow'            => 'Archivo Narrow',
			'Aref+Ruqaa'                => 'Aref Ruqaa',
			'Arima+Madurai'             => 'Arima Madurai',
			'Arimo'                     => 'Arimo',
			'Arizonia'                  => 'Arizonia',
			'Armata'                    => 'Armata',
			'Arsenal'                   => 'Arsenal',
			'Artifika'                  => 'Artifika',
			'Arvo'                      => 'Arvo',
			'Arya'                      => 'Arya',
			'Asap'                      => 'Asap',
			'Asar'                      => 'Asar',
			'Asset'                     => 'Asset',
			'Assistant'                 => 'Assistant',
			'Astloch'                   => 'Astloch',
			'Asul'                      => 'Asul',
			'Athiti'                    => 'Athiti',
			'Atma'                      => 'Atma',
			'Atomic+Age'                => 'Atomic Age',
			'Aubrey'                    => 'Aubrey',
			'Audiowide'                 => 'Audiowide',
			'Autour+One'                => 'Autour One',
			'Average'                   => 'Average',
			'Average+Sans'              => 'Average Sans',
			'Averia+Gruesa+Libre'       => 'Averia Gruesa Libre',
			'Averia+Libre'              => 'Averia Libre',
			'Averia+Sans+Libre'         => 'Averia Sans Libre',
			'Averia+Serif+Libre'        => 'Averia Serif Libre',
			'Bad+Script'                => 'Bad Script',
			'Baloo'                     => 'Baloo',
			'Baloo+Bhai'                => 'Baloo Bhai',
			'Baloo+Bhaina'              => 'Baloo Bhaina',
			'Baloo+Chettan'             => 'Baloo Chettan',
			'Baloo+Da'                  => 'Baloo Da',
			'Baloo+Paaji'               => 'Baloo Paaji',
			'Baloo+Tamma'               => 'Baloo Tamma',
			'Baloo+Thambi'              => 'Baloo Thambi',
			'Balthazar'                 => 'Balthazar',
			'Bangers'                   => 'Bangers',
			'Basic'                     => 'Basic',
			'Battambang'                => 'Battambang',
			'Baumans'                   => 'Baumans',
			'Bayon'                     => 'Bayon',
			'Belgrano'                  => 'Belgrano',
			'Belleza'                   => 'Belleza',
			'BenchNine'                 => 'BenchNine',
			'Bentham'                   => 'Bentham',
			'Berkshire+Swash'           => 'Berkshire Swash',
			'Bevan'                     => 'Bevan',
			'Bigelow+Rules'             => 'Bigelow Rules',
			'Bigshot+One'               => 'Bigshot One',
			'Bilbo'                     => 'Bilbo',
			'Bilbo+Swash+Caps'          => 'Bilbo Swash Caps',
			'BioRhyme'                  => 'BioRhyme',
			'BioRhyme+Expanded'         => 'BioRhyme Expanded',
			'Biryani'                   => 'Biryani',
			'Bitter'                    => 'Bitter',
			'Black+Ops+One'             => 'Black Ops One',
			'Bokor'                     => 'Bokor',
			'Bonbon'                    => 'Bonbon',
			'Boogaloo'                  => 'Boogaloo',
			'Bowlby+One'                => 'Bowlby One',
			'Bowlby+One+SC'             => 'Bowlby One SC',
			'Brawler'                   => 'Brawler',
			'Bree+Serif'                => 'Bree Serif',
			'Bubblegum+Sans'            => 'Bubblegum Sans',
			'Bubbler+One'               => 'Bubbler One',
			'Buda'                      => 'Buda',
			'Buenard'                   => 'Buenard',
			'Bungee'                    => 'Bungee',
			'Bungee+Hairline'           => 'Bungee Hairline',
			'Bungee+Inline'             => 'Bungee Inline',
			'Bungee+Outline'            => 'Bungee Outline',
			'Bungee+Shade'              => 'Bungee Shade',
			'Butcherman'                => 'Butcherman',
			'Butterfly+Kids'            => 'Butterfly Kids',
			'Cabin'                     => 'Cabin',
			'Cabin+Condensed'           => 'Cabin Condensed',
			'Cabin+Sketch'              => 'Cabin Sketch',
			'Caesar+Dressing'           => 'Caesar Dressing',
			'Cagliostro'                => 'Cagliostro',
			'Cairo'                     => 'Cairo',
			'Calligraffitti'            => 'Calligraffitti',
			'Cambay'                    => 'Cambay',
			'Cambo'                     => 'Cambo',
			'Candal'                    => 'Candal',
			'Cantarell'                 => 'Cantarell',
			'Cantata+One'               => 'Cantata One',
			'Cantora+One'               => 'Cantora One',
			'Capriola'                  => 'Capriola',
			'Cardo'                     => 'Cardo',
			'Carme'                     => 'Carme',
			'Carrois+Gothic'            => 'Carrois Gothic',
			'Carrois+Gothic+SC'         => 'Carrois Gothic SC',
			'Carter+One'                => 'Carter One',
			'Catamaran'                 => 'Catamaran',
			'Caudex'                    => 'Caudex',
			'Caveat'                    => 'Caveat',
			'Caveat+Brush'              => 'Caveat Brush',
			'Cedarville+Cursive'        => 'Cedarville Cursive',
			'Ceviche+One'               => 'Ceviche One',
			'Changa'                    => 'Changa',
			'Changa+One'                => 'Changa One',
			'Chango'                    => 'Chango',
			'Chathura'                  => 'Chathura',
			'Chau+Philomene+One'        => 'Chau Philomene One',
			'Chela+One'                 => 'Chela One',
			'Chelsea+Market'            => 'Chelsea Market',
			'Chenla'                    => 'Chenla',
			'Cherry+Cream+Soda'         => 'Cherry Cream Soda',
			'Cherry+Swash'              => 'Cherry Swash',
			'Chewy'                     => 'Chewy',
			'Chicle'                    => 'Chicle',
			'Chivo'                     => 'Chivo',
			'Chonburi'                  => 'Chonburi',
			'Cinzel'                    => 'Cinzel',
			'Cinzel+Decorative'         => 'Cinzel Decorative',
			'Clicker+Script'            => 'Clicker Script',
			'Coda'                      => 'Coda',
			'Coda+Caption'              => 'Coda Caption',
			'Codystar'                  => 'Codystar',
			'Coiny'                     => 'Coiny',
			'Combo'                     => 'Combo',
			'Comfortaa'                 => 'Comfortaa',
			'Coming+Soon'               => 'Coming Soon',
			'Concert+One'               => 'Concert One',
			'Condiment'                 => 'Condiment',
			'Content'                   => 'Content',
			'Contrail+One'              => 'Contrail One',
			'Convergence'               => 'Convergence',
			'Cookie'                    => 'Cookie',
			'Copse'                     => 'Copse',
			'Corben'                    => 'Corben',
			'Cormorant'                 => 'Cormorant',
			'Cormorant+Garamond'        => 'Cormorant Garamond',
			'Cormorant+Infant'          => 'Cormorant Infant',
			'Cormorant+SC'              => 'Cormorant SC',
			'Cormorant+Unicase'         => 'Cormorant Unicase',
			'Cormorant+Upright'         => 'Cormorant Upright',
			'Courgette'                 => 'Courgette',
			'Cousine'                   => 'Cousine',
			'Coustard'                  => 'Coustard',
			'Covered+By+Your+Grace'     => 'Covered By Your Grace',
			'Crafty+Girls'              => 'Crafty Girls',
			'Creepster'                 => 'Creepster',
			'Crete+Round'               => 'Crete Round',
			'Crimson+Text'              => 'Crimson Text',
			'Croissant+One'             => 'Croissant One',
			'Crushed'                   => 'Crushed',
			'Cuprum'                    => 'Cuprum',
			'Cutive'                    => 'Cutive',
			'Cutive+Mono'               => 'Cutive Mono',
			'Damion'                    => 'Damion',
			'Dancing+Script'            => 'Dancing Script',
			'Dangrek'                   => 'Dangrek',
			'David+Libre'               => 'David Libre',
			'Dawning+of+a+New+Day'      => 'Dawning of a New Day',
			'Days+One'                  => 'Days One',
			'Dekko'                     => 'Dekko',
			'Delius'                    => 'Delius',
			'Delius+Swash+Caps'         => 'Delius Swash Caps',
			'Delius+Unicase'            => 'Delius Unicase',
			'Della+Respira'             => 'Della Respira',
			'Denk+One'                  => 'Denk One',
			'Devonshire'                => 'Devonshire',
			'Dhurjati'                  => 'Dhurjati',
			'Didact+Gothic'             => 'Didact Gothic',
			'Diplomata'                 => 'Diplomata',
			'Diplomata+SC'              => 'Diplomata SC',
			'Domine'                    => 'Domine',
			'Donegal+One'               => 'Donegal One',
			'Doppio+One'                => 'Doppio One',
			'Dorsa'                     => 'Dorsa',
			'Dosis'                     => 'Dosis',
			'Dr+Sugiyama'               => 'Dr Sugiyama',
			'Droid+Sans'                => 'Droid Sans',
			'Droid+Sans+Mono'           => 'Droid Sans Mono',
			'Droid+Serif'               => 'Droid Serif',
			'Duru+Sans'                 => 'Duru Sans',
			'Dynalight'                 => 'Dynalight',
			'EB+Garamond'               => 'EB Garamond',
			'Eagle+Lake'                => 'Eagle Lake',
			'Eater'                     => 'Eater',
			'Economica'                 => 'Economica',
			'Eczar'                     => 'Eczar',
			'Ek+Mukta'                  => 'Ek Mukta',
			'El+Messiri'                => 'El Messiri',
			'Electrolize'               => 'Electrolize',
			'Elsie'                     => 'Elsie',
			'Elsie+Swash+Caps'          => 'Elsie Swash Caps',
			'Emblema+One'               => 'Emblema One',
			'Emilys+Candy'              => 'Emilys Candy',
			'Engagement'                => 'Engagement',
			'Englebert'                 => 'Englebert',
			'Enriqueta'                 => 'Enriqueta',
			'Erica+One'                 => 'Erica One',
			'Esteban'                   => 'Esteban',
			'Euphoria+Script'           => 'Euphoria Script',
			'Ewert'                     => 'Ewert',
			'Exo'                       => 'Exo',
			'Exo+2'                     => 'Exo 2',
			'Expletus+Sans'             => 'Expletus Sans',
			'Fanwood+Text'              => 'Fanwood Text',
			'Farsan'                    => 'Farsan',
			'Fascinate'                 => 'Fascinate',
			'Fascinate+Inline'          => 'Fascinate Inline',
			'Faster+One'                => 'Faster One',
			'Fasthand'                  => 'Fasthand',
			'Fauna+One'                 => 'Fauna One',
			'Federant'                  => 'Federant',
			'Federo'                    => 'Federo',
			'Felipa'                    => 'Felipa',
			'Fenix'                     => 'Fenix',
			'Finger+Paint'              => 'Finger Paint',
			'Fira+Mono'                 => 'Fira Mono',
			'Fira+Sans'                 => 'Fira Sans',
			'Fira+Sans+Condensed'       => 'Fira Sans Condensed',
			'Fira+Sans+Extra+Condensed' => 'Fira Sans Extra Condensed',
			'Fjalla+One'                => 'Fjalla One',
			'Fjord+One'                 => 'Fjord One',
			'Flamenco'                  => 'Flamenco',
			'Flavors'                   => 'Flavors',
			'Fondamento'                => 'Fondamento',
			'Fontdiner+Swanky'          => 'Fontdiner Swanky',
			'Forum'                     => 'Forum',
			'Francois+One'              => 'Francois One',
			'Frank+Ruhl+Libre'          => 'Frank Ruhl Libre',
			'Freckle+Face'              => 'Freckle Face',
			'Fredericka+the+Great'      => 'Fredericka the Great',
			'Fredoka+One'               => 'Fredoka One',
			'Freehand'                  => 'Freehand',
			'Fresca'                    => 'Fresca',
			'Frijole'                   => 'Frijole',
			'Fruktur'                   => 'Fruktur',
			'Fugaz+One'                 => 'Fugaz One',
			'GFS+Didot'                 => 'GFS Didot',
			'GFS+Neohellenic'           => 'GFS Neohellenic',
			'Gabriela'                  => 'Gabriela',
			'Gafata'                    => 'Gafata',
			'Galada'                    => 'Galada',
			'Galdeano'                  => 'Galdeano',
			'Galindo'                   => 'Galindo',
			'Gentium+Basic'             => 'Gentium Basic',
			'Gentium+Book+Basic'        => 'Gentium Book Basic',
			'Geo'                       => 'Geo',
			'Geostar'                   => 'Geostar',
			'Geostar+Fill'              => 'Geostar Fill',
			'Germania+One'              => 'Germania One',
			'Gidugu'                    => 'Gidugu',
			'Gilda+Display'             => 'Gilda Display',
			'Give+You+Glory'            => 'Give You Glory',
			'Glass+Antiqua'             => 'Glass Antiqua',
			'Glegoo'                    => 'Glegoo',
			'Gloria+Hallelujah'         => 'Gloria Hallelujah',
			'Goblin+One'                => 'Goblin One',
			'Gochi+Hand'                => 'Gochi Hand',
			'Gorditas'                  => 'Gorditas',
			'Goudy+Bookletter+1911'     => 'Goudy Bookletter 1911',
			'Graduate'                  => 'Graduate',
			'Grand+Hotel'               => 'Grand Hotel',
			'Gravitas+One'              => 'Gravitas One',
			'Great+Vibes'               => 'Great Vibes',
			'Griffy'                    => 'Griffy',
			'Gruppo'                    => 'Gruppo',
			'Gudea'                     => 'Gudea',
			'Gurajada'                  => 'Gurajada',
			'Habibi'                    => 'Habibi',
			'Halant'                    => 'Halant',
			'Hammersmith+One'           => 'Hammersmith One',
			'Hanalei'                   => 'Hanalei',
			'Hanalei+Fill'              => 'Hanalei Fill',
			'Handlee'                   => 'Handlee',
			'Hanuman'                   => 'Hanuman',
			'Happy+Monkey'              => 'Happy Monkey',
			'Harmattan'                 => 'Harmattan',
			'Headland+One'              => 'Headland One',
			'Heebo'                     => 'Heebo',
			'Henny+Penny'               => 'Henny Penny',
			'Herr+Von+Muellerhoff'      => 'Herr Von Muellerhoff',
			'Hind'                      => 'Hind',
			'Hind+Guntur'               => 'Hind Guntur',
			'Hind+Madurai'              => 'Hind Madurai',
			'Hind+Siliguri'             => 'Hind Siliguri',
			'Hind+Vadodara'             => 'Hind Vadodara',
			'Holtwood+One+SC'           => 'Holtwood One SC',
			'Homemade+Apple'            => 'Homemade Apple',
			'Homenaje'                  => 'Homenaje',
			'IM+Fell+DW+Pica'           => 'IM Fell DW Pica',
			'IM+Fell+DW+Pica+SC'        => 'IM Fell DW Pica SC',
			'IM+Fell+Double+Pica'       => 'IM Fell Double Pica',
			'IM+Fell+Double+Pica+SC'    => 'IM Fell Double Pica SC',
			'IM+Fell+English'           => 'IM Fell English',
			'IM+Fell+English+SC'        => 'IM Fell English SC',
			'IM+Fell+French+Canon'      => 'IM Fell French Canon',
			'IM+Fell+French+Canon+SC'   => 'IM Fell French Canon SC',
			'IM+Fell+Great+Primer'      => 'IM Fell Great Primer',
			'IM+Fell+Great+Primer+SC'   => 'IM Fell Great Primer SC',
			'Iceberg'                   => 'Iceberg',
			'Iceland'                   => 'Iceland',
			'Imprima'                   => 'Imprima',
			'Inconsolata'               => 'Inconsolata',
			'Inder'                     => 'Inder',
			'Indie+Flower'              => 'Indie Flower',
			'Inika'                     => 'Inika',
			'Inknut+Antiqua'            => 'Inknut Antiqua',
			'Irish+Grover'              => 'Irish Grover',
			'Istok+Web'                 => 'Istok Web',
			'Italiana'                  => 'Italiana',
			'Italianno'                 => 'Italianno',
			'Itim'                      => 'Itim',
			'Jacques+Francois'          => 'Jacques Francois',
			'Jacques+Francois+Shadow'   => 'Jacques Francois Shadow',
			'Jaldi'                     => 'Jaldi',
			'Jim+Nightshade'            => 'Jim Nightshade',
			'Jockey+One'                => 'Jockey One',
			'Jolly+Lodger'              => 'Jolly Lodger',
			'Jomhuria'                  => 'Jomhuria',
			'Josefin+Sans'              => 'Josefin Sans',
			'Josefin+Slab'              => 'Josefin Slab',
			'Joti+One'                  => 'Joti One',
			'Judson'                    => 'Judson',
			'Julee'                     => 'Julee',
			'Julius+Sans+One'           => 'Julius Sans One',
			'Junge'                     => 'Junge',
			'Jura'                      => 'Jura',
			'Just+Another+Hand'         => 'Just Another Hand',
			'Just+Me+Again+Down+Here'   => 'Just Me Again Down Here',
			'Kadwa'                     => 'Kadwa',
			'Kalam'                     => 'Kalam',
			'Kameron'                   => 'Kameron',
			'Kanit'                     => 'Kanit',
			'Kantumruy'                 => 'Kantumruy',
			'Karla'                     => 'Karla',
			'Karma'                     => 'Karma',
			'Katibeh'                   => 'Katibeh',
			'Kaushan+Script'            => 'Kaushan Script',
			'Kavivanar'                 => 'Kavivanar',
			'Kavoon'                    => 'Kavoon',
			'Kdam+Thmor'                => 'Kdam Thmor',
			'Keania+One'                => 'Keania One',
			'Kelly+Slab'                => 'Kelly Slab',
			'Kenia'                     => 'Kenia',
			'Khand'                     => 'Khand',
			'Khmer'                     => 'Khmer',
			'Khula'                     => 'Khula',
			'Kite+One'                  => 'Kite One',
			'Knewave'                   => 'Knewave',
			'Kotta+One'                 => 'Kotta One',
			'Koulen'                    => 'Koulen',
			'Kranky'                    => 'Kranky',
			'Kreon'                     => 'Kreon',
			'Kristi'                    => 'Kristi',
			'Krona+One'                 => 'Krona One',
			'Kumar+One'                 => 'Kumar One',
			'Kumar+One+Outline'         => 'Kumar One Outline',
			'Kurale'                    => 'Kurale',
			'La+Belle+Aurore'           => 'La Belle Aurore',
			'Laila'                     => 'Laila',
			'Lakki+Reddy'               => 'Lakki Reddy',
			'Lalezar'                   => 'Lalezar',
			'Lancelot'                  => 'Lancelot',
			'Lateef'                    => 'Lateef',
			'Lato'                      => 'Lato',
			'League+Script'             => 'League Script',
			'Leckerli+One'              => 'Leckerli One',
			'Ledger'                    => 'Ledger',
			'Lekton'                    => 'Lekton',
			'Lemon'                     => 'Lemon',
			'Lemonada'                  => 'Lemonada',
			'Libre+Baskerville'         => 'Libre Baskerville',
			'Libre+Franklin'            => 'Libre Franklin',
			'Life+Savers'               => 'Life Savers',
			'Lilita+One'                => 'Lilita One',
			'Lily+Script+One'           => 'Lily Script One',
			'Limelight'                 => 'Limelight',
			'Linden+Hill'               => 'Linden Hill',
			'Lobster'                   => 'Lobster',
			'Lobster+Two'               => 'Lobster Two',
			'Londrina+Outline'          => 'Londrina Outline',
			'Londrina+Shadow'           => 'Londrina Shadow',
			'Londrina+Sketch'           => 'Londrina Sketch',
			'Londrina+Solid'            => 'Londrina Solid',
			'Lora'                      => 'Lora',
			'Love+Ya+Like+A+Sister'     => 'Love Ya Like A Sister',
			'Loved+by+the+King'         => 'Loved by the King',
			'Lovers+Quarrel'            => 'Lovers Quarrel',
			'Luckiest+Guy'              => 'Luckiest Guy',
			'Lusitana'                  => 'Lusitana',
			'Lustria'                   => 'Lustria',
			'Macondo'                   => 'Macondo',
			'Macondo+Swash+Caps'        => 'Macondo Swash Caps',
			'Mada'                      => 'Mada',
			'Magra'                     => 'Magra',
			'Maiden+Orange'             => 'Maiden Orange',
			'Maitree'                   => 'Maitree',
			'Mako'                      => 'Mako',
			'Mallanna'                  => 'Mallanna',
			'Mandali'                   => 'Mandali',
			'Marcellus'                 => 'Marcellus',
			'Marcellus+SC'              => 'Marcellus SC',
			'Marck+Script'              => 'Marck Script',
			'Margarine'                 => 'Margarine',
			'Marko+One'                 => 'Marko One',
			'Marmelad'                  => 'Marmelad',
			'Martel'                    => 'Martel',
			'Martel+Sans'               => 'Martel Sans',
			'Marvel'                    => 'Marvel',
			'Mate'                      => 'Mate',
			'Mate+SC'                   => 'Mate SC',
			'Maven+Pro'                 => 'Maven Pro',
			'McLaren'                   => 'McLaren',
			'Meddon'                    => 'Meddon',
			'MedievalSharp'             => 'MedievalSharp',
			'Medula+One'                => 'Medula One',
			'Meera+Inimai'              => 'Meera Inimai',
			'Megrim'                    => 'Megrim',
			'Meie+Script'               => 'Meie Script',
			'Merienda'                  => 'Merienda',
			'Merienda+One'              => 'Merienda One',
			'Merriweather'              => 'Merriweather',
			'Merriweather+Sans'         => 'Merriweather Sans',
			'Metal'                     => 'Metal',
			'Metal+Mania'               => 'Metal Mania',
			'Metamorphous'              => 'Metamorphous',
			'Metrophobic'               => 'Metrophobic',
			'Michroma'                  => 'Michroma',
			'Milonga'                   => 'Milonga',
			'Miltonian'                 => 'Miltonian',
			'Miltonian+Tattoo'          => 'Miltonian Tattoo',
			'Miniver'                   => 'Miniver',
			'Miriam+Libre'              => 'Miriam Libre',
			'Mirza'                     => 'Mirza',
			'Miss+Fajardose'            => 'Miss Fajardose',
			'Mitr'                      => 'Mitr',
			'Modak'                     => 'Modak',
			'Modern+Antiqua'            => 'Modern Antiqua',
			'Mogra'                     => 'Mogra',
			'Molengo'                   => 'Molengo',
			'Molle'                     => 'Molle',
			'Monda'                     => 'Monda',
			'Monofett'                  => 'Monofett',
			'Monoton'                   => 'Monoton',
			'Monsieur+La+Doulaise'      => 'Monsieur La Doulaise',
			'Montaga'                   => 'Montaga',
			'Montez'                    => 'Montez',
			'Montserrat'                => 'Montserrat',
			'Montserrat+Alternates'     => 'Montserrat Alternates',
			'Montserrat+Subrayada'      => 'Montserrat Subrayada',
			'Moul'                      => 'Moul',
			'Moulpali'                  => 'Moulpali',
			'Mountains+of+Christmas'    => 'Mountains of Christmas',
			'Mouse+Memoirs'             => 'Mouse Memoirs',
			'Mr+Bedfort'                => 'Mr Bedfort',
			'Mr+Dafoe'                  => 'Mr Dafoe',
			'Mr+De+Haviland'            => 'Mr De Haviland',
			'Mrs+Saint+Delafield'       => 'Mrs Saint Delafield',
			'Mrs+Sheppards'             => 'Mrs Sheppards',
			'Mukta+Vaani'               => 'Mukta Vaani',
			'Muli'                      => 'Muli',
			'Mystery+Quest'             => 'Mystery Quest',
			'NTR'                       => 'NTR',
			'Neucha'                    => 'Neucha',
			'Neuton'                    => 'Neuton',
			'New+Rocker'                => 'New Rocker',
			'News+Cycle'                => 'News Cycle',
			'Niconne'                   => 'Niconne',
			'Nixie+One'                 => 'Nixie One',
			'Nobile'                    => 'Nobile',
			'Nokora'                    => 'Nokora',
			'Norican'                   => 'Norican',
			'Nosifer'                   => 'Nosifer',
			'Nothing+You+Could+Do'      => 'Nothing You Could Do',
			'Noticia+Text'              => 'Noticia Text',
			'Noto+Sans'                 => 'Noto Sans',
			'Noto+Serif'                => 'Noto Serif',
			'Nova+Cut'                  => 'Nova Cut',
			'Nova+Flat'                 => 'Nova Flat',
			'Nova+Mono'                 => 'Nova Mono',
			'Nova+Oval'                 => 'Nova Oval',
			'Nova+Round'                => 'Nova Round',
			'Nova+Script'               => 'Nova Script',
			'Nova+Slim'                 => 'Nova Slim',
			'Nova+Square'               => 'Nova Square',
			'Numans'                    => 'Numans',
			'Nunito'                    => 'Nunito',
			'Nunito+Sans'               => 'Nunito Sans',
			'Odor+Mean+Chey'            => 'Odor Mean Chey',
			'Offside'                   => 'Offside',
			'Old+Standard+TT'           => 'Old Standard TT',
			'Oldenburg'                 => 'Oldenburg',
			'Oleo+Script'               => 'Oleo Script',
			'Oleo+Script+Swash+Caps'    => 'Oleo Script Swash Caps',
			'Open+Sans'                 => 'Open Sans',
			'Open+Sans+Condensed'       => 'Open Sans Condensed',
			'Oranienbaum'               => 'Oranienbaum',
			'Orbitron'                  => 'Orbitron',
			'Oregano'                   => 'Oregano',
			'Orienta'                   => 'Orienta',
			'Original+Surfer'           => 'Original Surfer',
			'Oswald'                    => 'Oswald',
			'Over+the+Rainbow'          => 'Over the Rainbow',
			'Overlock'                  => 'Overlock',
			'Overlock+SC'               => 'Overlock SC',
			'Overpass'                  => 'Overpass',
			'Overpass+Mono'             => 'Overpass Mono',
			'Ovo'                       => 'Ovo',
			'Oxygen'                    => 'Oxygen',
			'Oxygen+Mono'               => 'Oxygen Mono',
			'PT+Mono'                   => 'PT Mono',
			'PT+Sans'                   => 'PT Sans',
			'PT+Sans+Caption'           => 'PT Sans Caption',
			'PT+Sans+Narrow'            => 'PT Sans Narrow',
			'PT+Serif'                  => 'PT Serif',
			'PT+Serif+Caption'          => 'PT Serif Caption',
			'Pacifico'                  => 'Pacifico',
			'Padauk'                    => 'Padauk',
			'Palanquin'                 => 'Palanquin',
			'Palanquin+Dark'            => 'Palanquin Dark',
			'Paprika'                   => 'Paprika',
			'Parisienne'                => 'Parisienne',
			'Passero+One'               => 'Passero One',
			'Passion+One'               => 'Passion One',
			'Pathway+Gothic+One'        => 'Pathway Gothic One',
			'Patrick+Hand'              => 'Patrick Hand',
			'Patrick+Hand+SC'           => 'Patrick Hand SC',
			'Pattaya'                   => 'Pattaya',
			'Patua+One'                 => 'Patua One',
			'Pavanam'                   => 'Pavanam',
			'Paytone+One'               => 'Paytone One',
			'Peddana'                   => 'Peddana',
			'Peralta'                   => 'Peralta',
			'Permanent+Marker'          => 'Permanent Marker',
			'Petit+Formal+Script'       => 'Petit Formal Script',
			'Petrona'                   => 'Petrona',
			'Philosopher'               => 'Philosopher',
			'Piedra'                    => 'Piedra',
			'Pinyon+Script'             => 'Pinyon Script',
			'Pirata+One'                => 'Pirata One',
			'Plaster'                   => 'Plaster',
			'Play'                      => 'Play',
			'Playball'                  => 'Playball',
			'Playfair+Display'          => 'Playfair Display',
			'Playfair+Display+SC'       => 'Playfair Display SC',
			'Podkova'                   => 'Podkova',
			'Poiret+One'                => 'Poiret One',
			'Poller+One'                => 'Poller One',
			'Poly'                      => 'Poly',
			'Pompiere'                  => 'Pompiere',
			'Pontano+Sans'              => 'Pontano Sans',
			'Poppins'                   => 'Poppins',
			'Port+Lligat+Sans'          => 'Port Lligat Sans',
			'Port+Lligat+Slab'          => 'Port Lligat Slab',
			'Pragati+Narrow'            => 'Pragati Narrow',
			'Prata'                     => 'Prata',
			'Preahvihear'               => 'Preahvihear',
			'Press+Start+2P'            => 'Press Start 2P',
			'Pridi'                     => 'Pridi',
			'Princess+Sofia'            => 'Princess Sofia',
			'Prociono'                  => 'Prociono',
			'Prompt'                    => 'Prompt',
			'Prosto+One'                => 'Prosto One',
			'Proza+Libre'               => 'Proza Libre',
			'Puritan'                   => 'Puritan',
			'Purple+Purse'              => 'Purple Purse',
			'Quando'                    => 'Quando',
			'Quantico'                  => 'Quantico',
			'Quattrocento'              => 'Quattrocento',
			'Quattrocento+Sans'         => 'Quattrocento Sans',
			'Questrial'                 => 'Questrial',
			'Quicksand'                 => 'Quicksand',
			'Quintessential'            => 'Quintessential',
			'Qwigley'                   => 'Qwigley',
			'Racing+Sans+One'           => 'Racing Sans One',
			'Radley'                    => 'Radley',
			'Rajdhani'                  => 'Rajdhani',
			'Rakkas'                    => 'Rakkas',
			'Raleway'                   => 'Raleway',
			'Raleway+Dots'              => 'Raleway Dots',
			'Ramabhadra'                => 'Ramabhadra',
			'Ramaraja'                  => 'Ramaraja',
			'Rambla'                    => 'Rambla',
			'Rammetto+One'              => 'Rammetto One',
			'Ranchers'                  => 'Ranchers',
			'Rancho'                    => 'Rancho',
			'Ranga'                     => 'Ranga',
			'Rasa'                      => 'Rasa',
			'Rationale'                 => 'Rationale',
			'Ravi+Prakash'              => 'Ravi Prakash',
			'Redressed'                 => 'Redressed',
			'Reem+Kufi'                 => 'Reem Kufi',
			'Reenie+Beanie'             => 'Reenie Beanie',
			'Revalia'                   => 'Revalia',
			'Rhodium+Libre'             => 'Rhodium Libre',
			'Ribeye'                    => 'Ribeye',
			'Ribeye+Marrow'             => 'Ribeye Marrow',
			'Righteous'                 => 'Righteous',
			'Risque'                    => 'Risque',
			'Roboto'                    => 'Roboto',
			'Roboto+Condensed'          => 'Roboto Condensed',
			'Roboto+Mono'               => 'Roboto Mono',
			'Roboto+Slab'               => 'Roboto Slab',
			'Rochester'                 => 'Rochester',
			'Rock+Salt'                 => 'Rock Salt',
			'Rokkitt'                   => 'Rokkitt',
			'Romanesco'                 => 'Romanesco',
			'Ropa+Sans'                 => 'Ropa Sans',
			'Rosario'                   => 'Rosario',
			'Rosarivo'                  => 'Rosarivo',
			'Rouge+Script'              => 'Rouge Script',
			'Rozha+One'                 => 'Rozha One',
			'Rubik'                     => 'Rubik',
			'Rubik+Mono+One'            => 'Rubik Mono One',
			'Rubik+One'                 => 'Rubik One',
			'Ruda'                      => 'Ruda',
			'Rufina'                    => 'Rufina',
			'Ruge+Boogie'               => 'Ruge Boogie',
			'Ruluko'                    => 'Ruluko',
			'Rum+Raisin'                => 'Rum Raisin',
			'Ruslan+Display'            => 'Ruslan Display',
			'Russo+One'                 => 'Russo One',
			'Ruthie'                    => 'Ruthie',
			'Rye'                       => 'Rye',
			'Sacramento'                => 'Sacramento',
			'Sahitya'                   => 'Sahitya',
			'Sail'                      => 'Sail',
			'Salsa'                     => 'Salsa',
			'Sanchez'                   => 'Sanchez',
			'Sancreek'                  => 'Sancreek',
			'Sansita+One'               => 'Sansita One',
			'Sarala'                    => 'Sarala',
			'Sarina'                    => 'Sarina',
			'Sarpanch'                  => 'Sarpanch',
			'Satisfy'                   => 'Satisfy',
			'Scada'                     => 'Scada',
			'Scheherazade'              => 'Scheherazade',
			'Schoolbell'                => 'Schoolbell',
			'Scope+One'                 => 'Scope One',
			'Seaweed+Script'            => 'Seaweed Script',
			'Secular+One'               => 'Secular One',
			'Sevillana'                 => 'Sevillana',
			'Seymour+One'               => 'Seymour One',
			'Shadows+Into+Light'        => 'Shadows Into Light',
			'Shadows+Into+Light+Two'    => 'Shadows Into Light Two',
			'Shanti'                    => 'Shanti',
			'Share'                     => 'Share',
			'Share+Tech'                => 'Share Tech',
			'Share+Tech+Mono'           => 'Share Tech Mono',
			'Shojumaru'                 => 'Shojumaru',
			'Short+Stack'               => 'Short Stack',
			'Shrikhand'                 => 'Shrikhand',
			'Siemreap'                  => 'Siemreap',
			'Sigmar+One'                => 'Sigmar One',
			'Signika'                   => 'Signika',
			'Signika+Negative'          => 'Signika Negative',
			'Simonetta'                 => 'Simonetta',
			'Sintony'                   => 'Sintony',
			'Sirin+Stencil'             => 'Sirin Stencil',
			'Six+Caps'                  => 'Six Caps',
			'Skranji'                   => 'Skranji',
			'Slabo+13px'                => 'Slabo 13px',
			'Slabo+27px'                => 'Slabo 27px',
			'Slackey'                   => 'Slackey',
			'Smokum'                    => 'Smokum',
			'Smythe'                    => 'Smythe',
			'Sniglet'                   => 'Sniglet',
			'Snippet'                   => 'Snippet',
			'Snowburst+One'             => 'Snowburst One',
			'Sofadi+One'                => 'Sofadi One',
			'Sofia'                     => 'Sofia',
			'Sonsie+One'                => 'Sonsie One',
			'Sorts+Mill+Goudy'          => 'Sorts Mill Goudy',
			'Source+Code+Pro'           => 'Source Code Pro',
			'Source+Sans+Pro'           => 'Source Sans Pro',
			'Source+Serif+Pro'          => 'Source Serif Pro',
			'Space+Mono'                => 'Space Mono',
			'Special+Elite'             => 'Special Elite',
			'Spicy+Rice'                => 'Spicy Rice',
			'Spinnaker'                 => 'Spinnaker',
			'Spirax'                    => 'Spirax',
			'Squada+One'                => 'Squada One',
			'Sree+Krushnadevaraya'      => 'Sree Krushnadevaraya',
			'Sriracha'                  => 'Sriracha',
			'Stalemate'                 => 'Stalemate',
			'Stalinist+One'             => 'Stalinist One',
			'Stardos+Stencil'           => 'Stardos Stencil',
			'Stint+Ultra+Condensed'     => 'Stint Ultra Condensed',
			'Stint+Ultra+Expanded'      => 'Stint Ultra Expanded',
			'Stoke'                     => 'Stoke',
			'Strait'                    => 'Strait',
			'Sue+Ellen+Francisco'       => 'Sue Ellen Francisco',
			'Suez+One'                  => 'Suez One',
			'Sumana'                    => 'Sumana',
			'Sunshiney'                 => 'Sunshiney',
			'Supermercado+One'          => 'Supermercado One',
			'Sura'                      => 'Sura',
			'Suranna'                   => 'Suranna',
			'Suravaram'                 => 'Suravaram',
			'Suwannaphum'               => 'Suwannaphum',
			'Swanky+and+Moo+Moo'        => 'Swanky and Moo Moo',
			'Syncopate'                 => 'Syncopate',
			'Tangerine'                 => 'Tangerine',
			'Taprom'                    => 'Taprom',
			'Tauri'                     => 'Tauri',
			'Taviraj'                   => 'Taviraj',
			'Teko'                      => 'Teko',
			'Telex'                     => 'Telex',
			'Tenali+Ramakrishna'        => 'Tenali Ramakrishna',
			'Tenor+Sans'                => 'Tenor Sans',
			'Text+Me+One'               => 'Text Me One',
			'The+Girl+Next+Door'        => 'The Girl Next Door',
			'Tienne'                    => 'Tienne',
			'Tillana'                   => 'Tillana',
			'Timmana'                   => 'Timmana',
			'Tinos'                     => 'Tinos',
			'Titan+One'                 => 'Titan One',
			'Titillium+Web'             => 'Titillium Web',
			'Trade+Winds'               => 'Trade Winds',
			'Trirong'                   => 'Trirong',
			'Trocchi'                   => 'Trocchi',
			'Trochut'                   => 'Trochut',
			'Trykker'                   => 'Trykker',
			'Tulpen+One'                => 'Tulpen One',
			'Ubuntu'                    => 'Ubuntu',
			'Ubuntu+Condensed'          => 'Ubuntu Condensed',
			'Ubuntu+Mono'               => 'Ubuntu Mono',
			'Ultra'                     => 'Ultra',
			'Uncial+Antiqua'            => 'Uncial Antiqua',
			'Underdog'                  => 'Underdog',
			'Unica+One'                 => 'Unica One',
			'UnifrakturCook'            => 'UnifrakturCook',
			'UnifrakturMaguntia'        => 'UnifrakturMaguntia',
			'Unkempt'                   => 'Unkempt',
			'Unlock'                    => 'Unlock',
			'Unna'                      => 'Unna',
			'VT323'                     => 'VT323',
			'Vampiro+One'               => 'Vampiro One',
			'Varela'                    => 'Varela',
			'Varela+Round'              => 'Varela Round',
			'Vast+Shadow'               => 'Vast Shadow',
			'Vesper+Libre'              => 'Vesper Libre',
			'Vibur'                     => 'Vibur',
			'Vidaloka'                  => 'Vidaloka',
			'Viga'                      => 'Viga',
			'Voces'                     => 'Voces',
			'Volkhov'                   => 'Volkhov',
			'Vollkorn'                  => 'Vollkorn',
			'Voltaire'                  => 'Voltaire',
			'Waiting+for+the+Sunrise'   => 'Waiting for the Sunrise',
			'Wallpoet'                  => 'Wallpoet',
			'Walter+Turncoat'           => 'Walter Turncoat',
			'Warnes'                    => 'Warnes',
			'Wellfleet'                 => 'Wellfleet',
			'Wendy+One'                 => 'Wendy One',
			'Wire+One'                  => 'Wire One',
			'Work+Sans'                 => 'Work Sans',
			'Yanone+Kaffeesatz'         => 'Yanone Kaffeesatz',
			'Yantramanav'               => 'Yantramanav',
			'Yatra+One'                 => 'Yatra One',
			'Yellowtail'                => 'Yellowtail',
			'Yeseva+One'                => 'Yeseva One',
			'Yesteryear'                => 'Yesteryear',
			'Yrsa'                      => 'Yrsa',
		);

		return $zp_fonts;

	}

	// Font Weights.
	function zp_font_weights() {

		$zp_font_weights = array(
			''          => 'Default',
			'100'       => '100',
			'100italic' => '100italic',
			'200'       => '200',
			'200italic' => '200italic',
			'300'       => '300',
			'300italic' => '300italic',
			'400'       => '400',
			'400italic' => '400italic',
			'500'       => '500',
			'500italic' => '500italic',
			'600'       => '600',
			'600italic' => '600italic',
			'700'       => '700',
			'700italic' => '700italic',
			'800'       => '800',
			'800italic' => '800italic',
			'900'       => '900',
			'900italic' => '900italic',
		);

		return $zp_font_weights;

	}

	// Font Style.
	function zp_font_styles() {

		$zp_font_styles = array(
			''          => 'Default',
			'100'       => '100',
			'100italic' => '100italic',
			'200'       => '200',
			'200italic' => '200italic',
			'300'       => '300',
			'300italic' => '300italic',
			'400'       => '400',
			'400italic' => '400italic',
			'500'       => '500',
			'500italic' => '500italic',
			'600'       => '600',
			'600italic' => '600italic',
			'700'       => '700',
			'700italic' => '700italic',
			'800'       => '800',
			'800italic' => '800italic',
			'900'       => '900',
			'900italic' => '900italic',
		);

		return $zp_font_styles;

	}

}

add_action( 'init', 'zp_customizer_init' );
function zp_customizer_init() {

	new ZP_Customizer;

}

add_action( 'wp_enqueue_scripts', 'zp_customizer_style', 100 );
/**
* Enqueue customizer style.
*/
function zp_customizer_style() {
	// Enqueues Accent Color.
	if ( get_theme_mod( 'accent_default' ) || get_theme_mod( 'accent_hover' ) ) {

		$accent_default = get_theme_mod( 'accent_default' );
		$accent_hover = get_theme_mod( 'accent_hover' );

		$accent_css = '';

		if ( $accent_default ) {
			$accent_css .= "
				a:active,
				a:focus,
				a:hover,
				button:hover,
				input[type='button']:hover,
				input[type='reset']:hover,
				input[type='submit']:hover,
				li.current-menu-item.current_page_item a,
				.btn-default.active,
				.btn-default:active,
				.btn-default:focus,
				.btn-default:hover,
				.navbar .nav > li > a:focus,
				.navbar .nav > li > a:hover, 
				.open > .dropdown-toggle.btn-default, 
				.option-set a,
				.zp-post-carousel .swiper-pagination-bullet.swiper-pagination-bullet-active,
				.zp_like_holder .liked,
				.zp_like_holder:hover,
				.zpps-post-slider .swiper-button-next:hover,
				.zpps-post-slider .swiper-button-prev:hover {
					color: {$accent_default};
				}

				.woocommerce a.button:hover, 
				.woocommerce button.button:hover, 
				.woocommerce input.button:hover,
				.woocommerce #respond input#submit:hover {
					color: {$accent_default} !important; 
				}

				.caption_wrap .slide_button:focus,
				.caption_wrap .slide_button:hover {
					background-color: {$accent_default};
				}


				.single_portfolio_gallery .portfolio_icon_class i,
				.single_portfolio_image .portfolio_icon_class i {
					background-color: {$accent_hover};
				}

				.zp-post-carousel .swiper-button-next:focus,
				.zp-post-carousel .swiper-button-next:hover,
				.zp-post-carousel .swiper-button-prev:focus,
				.zp-post-carousel .swiper-button-prev:hover {
					background-color: {$accent_default};
				}

				.jp-play-bar,
				.jp-volume-bar-value {
					background: {$accent_default};
				}

				.zp-post-carousel .swiper-pagination-bullet.swiper-pagination-bullet-active {
					background-color: {$accent_default};
				}

				span.portfolio_item_link {
					background-color: {$accent_default};
				}
			";
		}

		wp_add_inline_style( 'mobile', $accent_css );

	}


	// Enqueue custom font style.
	// if ( get_theme_mod( 'body_font' ) || get_theme_mod( 'head_font' ) ) {

		// if ( get_theme_mod( 'body_font' ) ) {
			$font_fam = str_replace( "+", " ", get_theme_mod( 'body_font' ) );
			$font_weight = get_theme_mod( 'body_font_weight' );
			$font_style = get_theme_mod( 'body_font_style' );
			$font_size = get_theme_mod( 'body_font_size' );
			$font_color = get_theme_mod( 'body_color' );

			$body_css = '';

			if ( get_theme_mod( 'body_font' ) ) {
				$body_css .= "
					body {
						font-family: {$font_fam};
					}
				";
			}

			if ( $font_weight ) {
				$body_css .= "
					body {
						font-weight: {$font_weight};
					}
				";
			}

			if ( $font_style ) {
				$body_css .= "
					body {
						font-style: {$font_style};
					}
				";
			}

			if ( $font_color ) {
				$body_css .= "
					body,
					.lead,
					.zp_like_holder {
						color: {$font_color};
					}
				";
			}

			if ( $font_size ) {
				$body_css .= "
					body,
					span.zp_masonry_content,
					span.zp_masonry_link_desc,
					.content p,
					.entry-content ol,
					.entry-content p,
					.entry-content ul,
					.taxonomy-description > p,
					.textwidget p,
					.zp_masonry_content {
						font-size: {$font_size}px;
					}
				";
			}

			wp_add_inline_style( 'mobile', $body_css );
		//}
		// if ( get_theme_mod( 'head_font' ) ) {
			$head_font_style = str_replace( "+", " ", get_theme_mod( 'head_font' ) );
			$head_font_weight = get_theme_mod( 'head_font_weight' );
			$head_style = get_theme_mod( 'head_font_style' );
			$head_size = get_theme_mod( 'head_font_size' );
			$head2_size = get_theme_mod( 'head2_font_size' );
			$head3_size = get_theme_mod( 'head3_font_size' );
			$head4_size = get_theme_mod( 'head4_font_size' );
			$head5_size = get_theme_mod( 'head5_font_size' );
			$head6_size = get_theme_mod( 'head6_font_size' );
			$head_color = get_theme_mod( 'head_color' );

			$head_css = '';

			if ( get_theme_mod( 'head_font' ) ) {
				$head_css .= "
					h1,
					h2,
					h3,
					h4,
					h5,
					h6 {
						font-family: {$head_font_style};
					}
				";
			}
			
			if ( $head_font_weight ) {
				$head_css .= "
					h1,
					h2,
					h3,
					h4,
					h5,
					h6 {
						font-weight: {$head_font_weight};
					}
				";
			}

			if ( $head_style ) {
				$head_css .= "
					h1,
					h2,
					h3,
					h4,
					h5,
					h6 {
						font-style: {$head_style};
					}
				";
			}

			if ( $head_color ) {
				$head_css .= "
					h1,
					h2,
					h3,
					h4,
					h5,
					h6,
					.entry-content .caption h2 a,
					.entry-content h2 a,
					.entry-title > a,
					.site-title > a {
						color: {$head_color};
					}
				";
			}

			if ( $head_size ) {
				$head_css .= "
					h1,
					h1.entry-title,
					.format-link h2,
					.format-quote .entry-content > h2,
					.h1 {
						font-size: {$head_size}px;
					}
				";
			}

			if ( $head2_size ) {
				$head_css .= "
					h2,
					.h2 {
						font-size: {$head2_size}px;
					}
				";
			}

			if ( $head3_size ) {
				$head_css .= "
					h3,
					.h3 {
						font-size: {$head3_size}px;
					}
				";
			}

			if ( $head4_size ) {
				$head_css .= "
					h4,
					.h4 {
						font-size: {$head4_size}px;
					}
				";
			}

			if ( $head5_size ) {
				$head_css .= "
					h5,
					.h5 {
						font-size: {$head5_size}px;
					}
				";
			}

			if ( $head6_size ) {
				$head_css .= "
					h6,
					.h6 {
						font-size: {$head6_size}px;
					}
				";
			}

			wp_add_inline_style( 'mobile', $head_css );
	
}
