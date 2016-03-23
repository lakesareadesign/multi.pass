<?php
/**
 * Template Name: Our Menu Page template
 *
 * @package WordPress
 * @subpackage our-menu
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-our-menu'));

get_header();
echo $layout->apply_layout();
get_footer();