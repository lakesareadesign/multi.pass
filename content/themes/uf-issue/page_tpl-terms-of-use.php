<?php
/**
 * Template Name: Terms Of Use Page template
 *
 * @package WordPress
 * @subpackage terms-of-use
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-terms-of-use'));

get_header();
echo $layout->apply_layout();
get_footer();