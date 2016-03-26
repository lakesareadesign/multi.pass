<?php
/**
 * Template Name: Download Page template
 *
 * @package WordPress
 * @subpackage download
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-download'));

get_header();
echo $layout->apply_layout();
get_footer();