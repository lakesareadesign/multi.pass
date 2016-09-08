<?php
/**
 * Template Name: Contact Page template
 *
 * @package WordPress
 * @subpackage contact
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-contact'));

get_header();
echo $layout->apply_layout();
get_footer();