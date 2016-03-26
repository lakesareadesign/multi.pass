<?php
/**
 * Template Name: About Page template
 *
 * @package WordPress
 * @subpackage about
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-about'));

get_header();
echo $layout->apply_layout();
get_footer();