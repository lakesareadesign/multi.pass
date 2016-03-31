<?php
/**
 * Template Name: Testimonials Page template
 *
 * @package WordPress
 * @subpackage testimonials
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-testimonials'));

get_header();
echo $layout->apply_layout();
get_footer();