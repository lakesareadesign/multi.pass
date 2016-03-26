<?php
/**
 * Template Name: Our Gallery Page template
 *
 * @package WordPress
 * @subpackage our-gallery
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-our-gallery'));

get_header();
echo $layout->apply_layout();
get_footer();