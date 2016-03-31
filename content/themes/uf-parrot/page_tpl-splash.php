<?php
/**
 * Template Name: Splash Page template
 *
 * @package WordPress
 * @subpackage splash
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-splash'));

get_header();
echo $layout->apply_layout();
get_footer();