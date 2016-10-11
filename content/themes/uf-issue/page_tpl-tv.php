<?php
/**
 * Template Name: Tv Page template
 *
 * @package WordPress
 * @subpackage tv
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-tv'));

get_header();
echo $layout->apply_layout();
get_footer();