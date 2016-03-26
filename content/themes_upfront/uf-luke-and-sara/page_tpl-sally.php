<?php
/**
 * Template Name: Sally Page template
 *
 * @package WordPress
 * @subpackage sally
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-sally'));

get_header();
echo $layout->apply_layout();
get_footer();