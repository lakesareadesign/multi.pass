<?php
/**
 * Template Name: Portfolio Extended Page template
 *
 * @package WordPress
 * @subpackage portfolio-extended
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-portfolio-extended'));

get_header();
echo $layout->apply_layout();
get_footer();