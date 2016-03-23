<?php
/**
 * Template Name: Gallery Page template
 *
 * @package WordPress
 * @subpackage gallery
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-gallery'));

get_header();
echo $layout->apply_layout();
get_footer();