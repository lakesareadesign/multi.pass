<?php
/**
 * Template Name: Course1 Page template
 *
 * @package WordPress
 * @subpackage course1
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-course1'));

get_header();
echo $layout->apply_layout();
get_footer();