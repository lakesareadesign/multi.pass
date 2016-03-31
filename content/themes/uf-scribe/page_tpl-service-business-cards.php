<?php
/**
 * Template Name: Service Business Cards Page template
 *
 * @package WordPress
 * @subpackage service-business-cards
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-service-business-cards'));

get_header();
echo $layout->apply_layout();
get_footer();