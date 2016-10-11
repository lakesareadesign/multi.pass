<?php
/**
 * Template Name: Faq Page template
 *
 * @package WordPress
 * @subpackage faq
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-faq'));

get_header();
echo $layout->apply_layout();
get_footer();