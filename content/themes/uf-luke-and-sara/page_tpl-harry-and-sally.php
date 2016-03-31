<?php
/**
 * Template Name: Harry And Sally Page template
 *
 * @package WordPress
 * @subpackage harry-and-sally
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-harry-and-sally'));

get_header();
echo $layout->apply_layout();
get_footer();