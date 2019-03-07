<?php
class Genesis_Dambuster_Plugin {

 	private $help = GENESIS_DAMBUSTER_HELP;
  	private $home = GENESIS_DAMBUSTER_HOME;
  	private $icon = GENESIS_DAMBUSTER_ICON;
 	private $name = GENESIS_DAMBUSTER_NAME;
	private $newsfeeds = array(GENESIS_DAMBUSTER_NEWS);
 	private $path = GENESIS_DAMBUSTER_PATH;
 	private $slug = GENESIS_DAMBUSTER_SLUG;
 	private $version = GENESIS_DAMBUSTER_VERSION;


	private $modules = array(
//		'template' => array('class'=> 'Genesis_Dambuster_Template',  'theme' => 'Genesis'),
		'agency' => array('class'=> 'Genesis_Dambuster_Agency',   'theme' => 'Agency Pro'),
		'altitude' => array('class'=> 'Genesis_Dambuster_Altitude', 'theme' => 'Altitude Pro' ),
		'ambiance' => array('class'=> 'Genesis_Dambuster_Ambiance',  'theme' => 'Ambiance Pro'),
		'aspire' => array('class'=> 'Genesis_Dambuster_Aspire',  'theme' => 'Aspire Pro'),
		'author' => array('class'=> 'Genesis_Dambuster_Author',  'theme' => 'Author Pro'),
		'beautiful' => array('class'=> 'Genesis_Dambuster_Beautiful',  'theme' => 'Beautiful Pro'),
		'cafe' => array('class'=> 'Genesis_Dambuster_Cafe',  'theme' => 'Cafe Pro'),
		'centric' => array('class'=> 'Genesis_Dambuster_Centric',  'theme' => 'Centric'),
		'community' => array('class'=> 'Genesis_Dambuster_Community', 'theme' => 'Community Pro'),
		'daily-dish' => array('class'=> 'Genesis_Dambuster_DailyDish', 'theme' => 'Daily Dish Pro'),
		'decor' => array('class'=> 'Genesis_Dambuster_Decor', 'theme' => 'Decor'),
		'digital' => array('class'=> 'Genesis_Dambuster_Digital', 'theme' => 'Digital Pro'),
		'divine' => array('class'=> 'Genesis_Dambuster_Divine', 'theme' => 'Divine'),
		'dynamik' => array('class'=> 'Genesis_Dambuster_Dynamik', 'theme' => 'Dynamik-Gen'),
		'eleven40' => array('class'=> 'Genesis_Dambuster_Eleven40',  'theme' => 'eleven40 Pro'),
		'enterprise' => array('class'=> 'Genesis_Dambuster_Enterprise',  'theme' => 'Enterprise Pro'),
		'epik' => array('class'=> 'Genesis_Dambuster_Epik',  'theme' => 'Epik'),
		'essence' => array('class'=> 'Genesis_Dambuster_Essence',  'theme' => 'Essence Pro'),
		'executive' => array('class'=> 'Genesis_Dambuster_Executive',  'theme' => 'Executive Pro'),
		'expose' => array('class'=> 'Genesis_Dambuster_Expose',  'theme' => 'Expose Pro'),
		'infinity' => array('class'=> 'Genesis_Dambuster_Infinity',  'theme' => 'Infinity Pro'),
		'interior' => array('class'=> 'Genesis_Dambuster_Interior',  'theme' => 'Interior Pro'),
		'metro' => array('class'=> 'Genesis_Dambuster_Metro', 'theme' => 'Metro Pro'),
		'mindstream' => array('class'=> 'Genesis_Dambuster_Mindstream', 'theme' => 'Mindstream'),
		'minimum' => array('class'=> 'Genesis_Dambuster_Minimum', 'theme' => 'Minimum Pro'),
		'mocha' => array('class'=> 'Genesis_Dambuster_Mocha', 'theme' => 'Mocha'),
		'modern-studio' => array('class'=> 'Genesis_Dambuster_ModernStudio', 'theme' => 'Modern Studio Pro'),
		'monochrome' => array('class'=> 'Genesis_Dambuster_Monochrome', 'theme' => 'Monochrome Pro'),
		'news-pro' => array('class'=> 'Genesis_Dambuster_News_Pro', 'theme' => 'News Pro'),
		'nosidebar' => array('class'=> 'Genesis_Dambuster_NoSidebar', 'theme' => 'No Sidebar Pro'),
		'outreach' => array('class'=> 'Genesis_Dambuster_Outreach', 'theme' => 'Outreach Pro'),
		'pretty-chic' => array('class'=> 'Genesis_Dambuster_Pretty_Chic', 'theme' => 'Pretty Chic'),
		'prose' => array('class'=> 'Genesis_Dambuster_Prose', 'theme' => 'Prose'),
		'showcase' => array('class'=> 'Genesis_Dambuster_Showcase', 'theme' => 'Showcase Pro'),
		'sixteen-nine' => array('class'=> 'Genesis_Dambuster_SixteenNine', 'theme' => 'Sixteen Nine Pro'),
		'streamline' => array('class'=> 'Genesis_Dambuster_Streamline', 'theme' => 'Streamline Pro'),
		'swank' => array('class'=> 'Genesis_Dambuster_Swank', 'theme' => 'Swank'),
		'the-411' => array('class'=> 'Genesis_Dambuster_The411', 'theme' => 'The 411 Pro'),		
		'wintersong' => array('class'=> 'Genesis_Dambuster_Wintersong', 'theme' => 'Wintersong Pro'),	
		'workstation' => array('class'=> 'Genesis_Dambuster_Workstation', 'theme' => 'Workstation Pro'),	
	);
	
	private $news;
  	private $options;
	private $tooltips;
 	private $utils;
	private $template = false;
	private $template_admin = false;


	public function init() {
		$d = dirname(__FILE__) . '/';
		require_once ($d . 'class-options.php');
		require_once ($d . 'class-utils.php');
		require_once ($d . 'class-tooltip.php');
		$this->utils = new Genesis_Dambuster_Utils();
		$this->tooltips = new Genesis_Dambuster_Tooltip();
		$this->options = new Genesis_Dambuster_Options( 'genesis_dambuster_options');
		$this->newsfeeds = apply_filters('genesis_dambuster_news', $this->newsfeeds);

		if ($this->is_genesis_loaded()) { 
			require_once ($d . 'class-template.php');
			$current_theme = wp_get_theme();
			foreach ($this->modules as $module => $module_data) //load optional theme module if required
            	if (apply_filters('genesis_dambuster_init-'.$module,  $this->match_theme_name($current_theme->name, $module_data['theme'])))  { //load on a matching theme or if forced by a filter hook
					$file = $d . 'class-'.$module.'.php';
					$class = $module_data['class'];
					if (file_exists($file)) require_once($file);
					if (class_exists($class)) $this->template = new $class();
            	}
         	if (! $this->template) $this->template = new Genesis_Dambuster_Template();  //install the default module if no theme specific module
		}
	}

	public function admin_init() {
		if ($this->is_genesis_loaded()) {
			$d = dirname(__FILE__) . '/';
			require_once ($d . 'class-news.php');
			require_once ($d . 'class-admin.php');		
			require_once ($d . 'class-template-admin.php');
			$this->news = new Genesis_Dambuster_News($this->version);
			$this->template_admin = new Genesis_Dambuster_Template_Admin($this, 'template');
 			if ($this->get_activation_key()) add_action('admin_init', array($this, 'upgrade'));          
		}
	}

	static function get_instance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new self(); 
            register_activation_hook($instance->path, array($instance, 'activate'));            
            add_action('init', array($instance, 'init'),0);
            if (is_admin()) add_action('init', array($instance, 'admin_init'),0);
        }
        return $instance;
	}
   
  	protected function __construct() {}

  	private function __clone() {}

  	private function __wakeup() {}

	public function get_help(){
		return $this->help;
	}
	
	public function get_home(){
		return $this->home;
	}

	public function get_icon(){
		return $this->icon;
	}

	public function get_modules(){
		return $this->modules;
	}

	public function get_name(){
		return $this->name;
	}

	public function get_news(){
		return $this->news;
	}

	public function get_newsfeeds(){
		return $this->newsfeeds;
	}

	public function get_options(){
		return $this->options;
	}
	
    public function get_path(){
		return $this->path;
	}

    public function get_slug(){
		return $this->slug;
	}

	public function get_template() { 
		return $this->template;
	}

	public function get_tooltips(){
		return $this->tooltips;
	}

	public function get_utils(){
		return $this->utils;
	}

	public function get_version(){
		return $this->version;
	}

	public function activate() { //called on plugin activation
    	if ( $this->is_genesis_present() ) 
    	    $this->set_activation_key();
		else 
         $this->abort();
	}

	public function upgrade() { //apply any upgrades
		$this->options->upgrade_options();
		$this->template_admin->upgrade();
		$this->unset_activation_key();
	}


    public function match_theme_name($theme_name, $module_theme_names) {
        $theme_name = str_replace(array(' Child Theme', ' Theme'), '', $theme_name);
        $theme_names = (array) $module_theme_names;
        return in_array( $theme_name, $theme_names);
    }



	private function deactivate($path ='') {
		if (empty($path)) $path = $this->path;
		if (is_plugin_active($path)) deactivate_plugins( $path );
	}

   private function get_activation_key() { 
    	return get_option($this->activation_key_name()); 
   }

   private function set_activation_key() { 
    	return update_option($this->activation_key_name(), true); 
   }

   private function unset_activation_key() { 
    	return delete_option($this->activation_key_name(), true); 
   }

  	private function activation_key_name() { 
    	return strtolower(__CLASS__) . '_activation'; 
	}

	function is_post_type_enabled($post_type){
		return in_array($post_type, array('post', 'page')) || $this->is_custom_post_type_enabled($post_type);
	}

	function is_custom_post_type_enabled($post_type){
		return in_array($post_type, (array)$this->template->get_option('custom_post_types'));
	}

	function custom_post_types_exist() {
       $cpt = get_post_types(array('public' => true, '_builtin' => false));
       return is_array($cpt) && (count($cpt) > 0);
	}


	public function is_genesis_present() {
		return substr(basename( TEMPLATEPATH ), 0,7) == 'genesis' ; //is genesis the current parent theme
	}

	public function is_genesis_loaded() {
		return defined('GENESIS_SETTINGS_FIELD'); //is genesis actually loaded? (ie not been nobbled by another plugin) 
	}


	

	private function abort() {
		$this->deactivate(); //deactivate this plugin
		wp_die(  __( sprintf('Sorry, you cannot use %1$s unless you are using a child theme based on the StudioPress Genesis theme framework. The %1$s plugin has been deactivated. Go to the WordPress <a href="%2$s"><em>Plugins page</em></a>.',
			$this->name, get_admin_url(null, 'plugins.php')), GENESIS_DAMBUSTER_DOMAIN ));       
	}
}