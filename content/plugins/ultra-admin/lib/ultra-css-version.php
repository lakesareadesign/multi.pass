<?php
/**
 * @Package: WordPress Plugin
 * @Subpackage: Ultra WordPress Admin Theme
 * @Since: Ultra 1.0
 * @WordPress Version: 4.0 or above
 * This file is part of Ultra WordPress Admin Theme Plugin.
 */
?>
<?php

function ultra_css_version(){
	global $wp_version;

	$version = $wp_version;
	if(strlen($version) == 3){$version = $version.".0";}

	if(version_compare($version, '4.0.0', '>=')){
    	return 'css40';
	} else {
    	return '';
    }
}

$GLOBALS['ultra_css_ver'] = ultra_css_version();

?>