<?php
/**
 * Template Name: Tuition Page template
 *
 * @package WordPress
 * @subpackage tuition
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-tuition'));

get_header();
echo $layout->apply_layout();
get_footer();