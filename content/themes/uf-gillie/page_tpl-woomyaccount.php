<?php
/**
 * Template Name: Woomyaccount Page template
 *
 * @package WordPress
 * @subpackage woomyaccount
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-woomyaccount'));

get_header();
echo $layout->apply_layout();
get_footer();