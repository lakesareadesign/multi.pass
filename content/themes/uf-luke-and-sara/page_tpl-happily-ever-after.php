<?php
/**
 * Template Name: Happily Ever After Page template
 *
 * @package WordPress
 * @subpackage happily-ever-after
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-happily-ever-after'));

get_header();
echo $layout->apply_layout();
get_footer();