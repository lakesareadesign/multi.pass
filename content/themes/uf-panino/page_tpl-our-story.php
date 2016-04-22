<?php
/**
 * Template Name: Our Story Page template
 *
 * @package WordPress
 * @subpackage our-story
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-our-story'));	   	 	  	    			    

get_header();
echo $layout->apply_layout();
get_footer();