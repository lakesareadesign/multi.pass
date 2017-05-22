/**
 * This script adds the post like jquery to the Slush Pro Theme.
 *
 * @package Slush_Pro\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

function createCookie(name, value, days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		var expires = "; expires=" + date.toGMTString();
	} else var expires = "";
	document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
}

function readCookie(name) {
	var nameEQ = escape(name) + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) == 0) return unescape(c.substring(nameEQ.length, c.length));
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name, "", -1);
}

function zp_set_liked(){
	jQuery('.zp_like_holder i').each(function(){
		var classname = jQuery(this).attr('class');
		var id=classname.split(" ");
		var ID = id[2];

		if(readCookie('Liked' + ID) == ID){
			jQuery('.zp_like_holder.'+ID).find('.fa-heart').addClass('liked');
		}
	});
}

function zp_insert_like(ID){
		if(readCookie('Liked' + ID) != ID){
			var data = {
				"action" : "zp_insert_likes",
				"post_id" : ID
			};
			
			jQuery.post(zp_post_like.ajax_url,data,function(data){
				jQuery('.zp_like_holder.'+ID).children('.like_counter').text('('+data+')');
				jQuery('.zp_like_holder.'+ID).animate({'opacity': 0}, 1000, function () {
					jQuery(this).children('.fa-heart').addClass('liked');
				}).animate({'opacity': 1}, 1000);
			});
		   createCookie('Liked' + ID,ID,365);
		}
	}
jQuery(window).load(function(){	
	
	zp_set_liked();	
	
	jQuery('#zp_masonry_container, article.post, .single_portfolio_container').on( 'click', '.zp_like_holder i', function(){
		var classname = jQuery(this).attr('class');
		var id=classname.split(" ");
		zp_insert_like(id[2]);
	});
});
