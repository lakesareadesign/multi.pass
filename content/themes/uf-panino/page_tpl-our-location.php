<?php
/**
 * Template Name: Our Location Page template
 *
 * @package WordPress
 * @subpackage our-location
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-our-location'));

get_header();
echo $layout->apply_layout();
get_footer();