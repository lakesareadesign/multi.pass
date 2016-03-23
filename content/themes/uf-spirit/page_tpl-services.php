<?php
/**
 * Template Name: Services Page template
 *
 * @package WordPress
 * @subpackage services
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-services'));

get_header();
echo $layout->apply_layout();
get_footer();