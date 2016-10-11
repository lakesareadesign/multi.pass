<?php
/**
 * Template Name: Advertise Page template
 *
 * @package WordPress
 * @subpackage advertise
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-advertise'));

get_header();
echo $layout->apply_layout();
get_footer();