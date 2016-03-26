<?php
/**
 * Template Name: Jacket Page template
 *
 * @package WordPress
 * @subpackage jacket
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-jacket'));

get_header();
echo $layout->apply_layout();
get_footer();