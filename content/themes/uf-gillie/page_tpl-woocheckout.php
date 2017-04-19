<?php
/**
 * Template Name: Woocheckout Page template
 *
 * @package WordPress
 * @subpackage woocheckout
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-woocheckout'));

get_header();
echo $layout->apply_layout();
get_footer();