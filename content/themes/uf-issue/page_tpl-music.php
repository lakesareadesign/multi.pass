<?php
/**
 * Template Name: Music Page template
 *
 * @package WordPress
 * @subpackage music
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-music'));

get_header();
echo $layout->apply_layout();
get_footer();