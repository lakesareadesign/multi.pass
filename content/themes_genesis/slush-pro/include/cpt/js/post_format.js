/**
 * This script adds the post format jquery to the Slush Pro Theme.
 *
 * @package Slush_Pro\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

jQuery.noConflict();
jQuery(document).ready(function($){

	$('#audio-settings').hide();
	 $('#link-settings').hide();
	 $('#video-settings').hide();
	 $('#gallery-settings').hide();

	$('#post-formats-select  .post-format').each(function(i){

		if($(this).is(':checked')) {
			var val = $(this).val();

			$('#'+val+'-settings').show();
		}

	});	

	$('#post-formats-select  .post-format').click(function(){
			var val = $(this).val();
			$('#audio-settings').hide();
			$('#link-settings').hide();
			$('#video-settings').hide();
			$('#gallery-settings').hide();

			$('#'+val+'-settings').show();	
	});

	// Toogle Option.
	$('.page_slideshow-wrap').hide();
	$('.page_slideshow_effect-wrap').hide();
	$('.MP4_video-wrap').hide();
	$('.WEBM_video-wrap').hide();
	$('.OGV_video-wrap').hide();

	var value = $( '#scpt_meta_page_header_featured option:selected' ).val();

	if('slider' == value ){
		$('.page_slideshow-wrap').show();
		$('.page_slideshow_effect-wrap').show();
		$('.MP4_video-wrap').hide();
		$('.WEBM_video-wrap').hide();
		$('.OGV_video-wrap').hide();	
	}

	if( 'video' == value ){
		$('.page_slideshow-wrap').hide();
		$('.page_slideshow_effect-wrap').hide();
		$('.MP4_video-wrap').show();
		$('.WEBM_video-wrap').show();
		$('.OGV_video-wrap').show();
	}

	// Open option on change.
	$( '#scpt_meta_page_header_featured' ).change(function(){
		value = $(this).val();

		if ( 'slider' == value ) {
			$('.page_slideshow-wrap').show();
			$('.page_slideshow_effect-wrap').show();
			$('.MP4_video-wrap').hide();
			$('.WEBM_video-wrap').hide();
			$('.OGV_video-wrap').hide();	
		} else if ( 'video' == value ) {
			$('.page_slideshow-wrap').hide();
			$('.page_slideshow_effect-wrap').hide();
			$('.MP4_video-wrap').show();
			$('.WEBM_video-wrap').show();
			$('.OGV_video-wrap').show();
		} else {
			$('.page_slideshow-wrap').hide();
			$('.page_slideshow_effect-wrap').hide();
			$('.MP4_video-wrap').hide();
			$('.WEBM_video-wrap').hide();
			$('.OGV_video-wrap').hide();
		}
	});

	// Layout group option.
	var default_template = $( '#page_template' ).val();
	if ( default_template == 'layout_template.php' ) {
		$('#section_group').show();
	} else {
		$('#section_group').hide();
	}

	$('#page_template').change(function(){
		var page_template = $(this).val()

		if ( page_template == 'layout_template.php' ) {
			$('#section_group').show();
		} else {
			$('#section_group').hide();	
		}
	});
	// Portfolio Post Type Option.
	var default_val = $('#scpt_meta_portfolio_link').val();
	$('#portfolio_lightbox').hide();
	$('#portfolio_external_link').hide();
	$('#portfolio_single_page').hide();
	$('#portfolio_'+ default_val ).show();

	$('#scpt_meta_portfolio_link').change(function() {
		var portfolio_settings = $(this).val();

		$('#portfolio_lightbox').hide();
		$('#portfolio_external_link').hide();
		$('#portfolio_single_page').hide();				
		$('#portfolio_'+ portfolio_settings ).slideDown();

	});

	// Masonry Template.	
	 $('#masonry-template-settings').hide();

	if ( $( '#page_template' ).val() == 'masonry_template.php' ) {
		$('#masonry-template-settings').show();
	} else {
		$('#masonry-template-settings').hide();
	}

	$('#page_template').change(function(){
		var page_template = $(this).val()

		if ( page_template == 'masonry_template.php' ) {
			$('#masonry-template-settings').show();
		} else {
			$('#masonry-template-settings').hide();
		}
	});

});
