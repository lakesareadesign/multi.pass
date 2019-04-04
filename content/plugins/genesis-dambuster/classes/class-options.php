<?php
class Genesis_Dambuster_Options {

	protected $option_name;
	protected $options = array();
	protected $defaults = array();
	protected $encoded = false;

	function __construct($option_name, $defaults = array(), $encoded = false) {
		$this->option_name = $option_name;
		$this->defaults = $defaults;
		$this->encoded = $encoded;
	}

	function add_defaults($more = array()) {
	    if ($more) {
			$this->defaults = array_merge($this->defaults, (array)$more);
			$this->options = array(); //clear cache
		}
	}	

	function get_defaults() {
		return $this->defaults;
	}

	function get_default($option_name) {
    	if ($option_name && array_key_exists($option_name, $this->defaults))
        	return  $this->defaults[$option_name];
    	else
        	return false;
	}	

	function get_option_name() {
		return $this->option_name;
	}

	function get_options($cache = true) {
		if ($cache && (count($this->options) > 0)) return $this->options;
		$the_options = get_option($this->get_option_name());
		if (! empty($the_options) && ! is_array($the_options) && $this->encoded) 
			$the_options = unserialize(strrev(base64_decode($the_options)));
		$this->options = empty($the_options) ? $this->get_defaults() : shortcode_atts( $this->get_defaults(), $the_options);
		return $this->options;
	}
	
	function get_option($option_name, $cache = true) {
    	$options = $this->get_options($cache);
    	if ($option_name && $options && array_key_exists($option_name,$options))
         if (($defaults = $this->get_default($option_name)) && is_array($defaults) && is_array($options[$option_name])) 
            return $this->validate_options($defaults, $options[$option_name]);
         else
            return $options[$option_name];
    	else
        	return $this->get_default($option_name);     		
    }

	function save_options($new_options) {
		$options = $this->get_options(false);
		$new_options = shortcode_atts( $this->get_defaults(), array_merge($options, $new_options));
		if ($this->encoded) $new_options = base64_encode(strrev(serialize($new_options)));
		$updated = update_option($this->get_option_name(),$new_options);
		if ($updated) $this->get_options(false);
		return $updated;
	}	
		
	function validate_options($defaults, $options ) {
		if (is_array($defaults) )
    		if (is_array($options)) 
    		      return shortcode_atts($defaults, $options);		
            else
                return $defaults;
		else
    		return false;		
    }

	function upgrade_options($upgrade_options= array()) {
		/* Merge in old options and upgrade options */ 
		$new_options = $this->get_defaults();
		$old_options = get_option($this->get_option_name());

		foreach ($new_options as $key => $subdefaults) {
			if (is_array($old_options) && array_key_exists($key, $old_options)) 
				$new_options[$key] = $this->validate_options($subdefaults, $old_options[$key]);
			if (is_array($upgrade_options) && array_key_exists($key, $upgrade_options)) 
				$new_options[$key] = $this->validate_options($new_options[$key], $upgrade_options[$key]);
		}
		$this->save_options($new_options);
	}
}
