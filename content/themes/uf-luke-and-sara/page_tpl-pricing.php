<?php
/**
 * Template Name: Pricing Page template
 *
 * @package WordPress
 * @subpackage pricing
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-pricing'));

get_header();
echo $layout->apply_layout();
get_footer();