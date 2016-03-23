<?php
/**
 * Template Name: Terms Page template
 *
 * @package WordPress
 * @subpackage terms
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-terms'));

get_header();
echo $layout->apply_layout();
get_footer();