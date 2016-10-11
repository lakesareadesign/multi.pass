<?php
/**
 * Template Name: Tech News Page template
 *
 * @package WordPress
 * @subpackage tech-news
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-tech-news'));

get_header();
echo $layout->apply_layout();
get_footer();