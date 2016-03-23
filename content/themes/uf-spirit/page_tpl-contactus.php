<?php
/**
 * Template Name: Contactus Page template
 *
 * @package WordPress
 * @subpackage contactus
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-contactus'));

get_header();
echo $layout->apply_layout();
get_footer();