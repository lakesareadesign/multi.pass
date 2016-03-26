<?php
/**
 * Template Name: Portfolio Page template
 *
 * @package WordPress
 * @subpackage portfolio
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-portfolio'));

get_header();
echo $layout->apply_layout();
get_footer();