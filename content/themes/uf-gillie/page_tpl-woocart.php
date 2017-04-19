<?php
/**
 * Template Name: Woocart Page template
 *
 * @package WordPress
 * @subpackage woocart
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-woocart'));

get_header();
echo $layout->apply_layout();
get_footer();