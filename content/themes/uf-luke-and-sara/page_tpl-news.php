<?php
/**
 * Template Name: News Page template
 *
 * @package WordPress
 * @subpackage news
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-news'));	  	    	    		 				 

get_header();
echo $layout->apply_layout();
get_footer();