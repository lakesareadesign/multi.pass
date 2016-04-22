<?php
/**
 * Template Name: Features Page template
 *
 * @package WordPress
 * @subpackage features
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-features'));

get_header();
echo $layout->apply_layout();
get_footer();