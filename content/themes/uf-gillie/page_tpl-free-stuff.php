<?php
/**
 * Template Name: Free Stuff Page template
 *
 * @package WordPress
 * @subpackage free-stuff
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-free-stuff'));

get_header();
echo $layout->apply_layout();
get_footer();