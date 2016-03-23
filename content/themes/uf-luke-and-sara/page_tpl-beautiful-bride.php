<?php
/**
 * Template Name: Beautiful Bride Page template
 *
 * @package WordPress
 * @subpackage beautiful-bride
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-beautiful-bride'));

get_header();
echo $layout->apply_layout();
get_footer();