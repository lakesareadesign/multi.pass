<?php
/**
 * Template Name: Wedding Dress Page template
 *
 * @package WordPress
 * @subpackage wedding-dress
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-wedding-dress'));

get_header();
echo $layout->apply_layout();
get_footer();