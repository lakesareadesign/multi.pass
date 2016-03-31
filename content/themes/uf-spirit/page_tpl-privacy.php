<?php
/**
 * Template Name: Privacy Page template
 *
 * @package WordPress
 * @subpackage privacy
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-privacy'));

get_header();
echo $layout->apply_layout();
get_footer();