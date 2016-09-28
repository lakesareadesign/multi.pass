///////////////////////////////SUPPORT BOX\\\\\\\\\\\\\\\\\\\\\\\\\\\\
jQuery(window).load(function() {
    showSupportBox();
    showLoginLinkTitle()

    function showSupportBox() {
        if(jQuery('#flatty_show_site_developer_info').prop( "checked")){
            jQuery("#developer_infos").css('opacity', 1);
        } else {
            jQuery("#developer_infos").css('opacity', 0);
        }
    }

    function showLoginLinkTitle() {
      if(jQuery('#login-link-url').lenght > 0) {
        if(jQuery('#login-link-url').val().lenght !== 0){
            jQuery("#login-link-title").css('display', 'flex');
        } else {
            jQuery("#login-link-title").css('display', 'none');
        }
      }
    }

///////////////////////////////BUTTONS\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    jQuery('#flatty_show_site_developer_info').on('click', function(){
        showSupportBox();
    });

    jQuery('#login-link-url').on('click', function(){
        showLoginLinkTitle();
    });


////////////////////////////////////////////////////////////////////LOGO UPLOAD\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    jQuery('#button-upload_logo').on('click', function(){
        uploadLogo();
    });

    jQuery('#button-remove_logo').on('click', function(){
        jQuery('#button-remove_logo').hide(); //hide itself
        jQuery('#flatty_custom_logo_img').hide(); //hide logo picture

        jQuery('#button-upload_logo').show();
        jQuery('#flatty_custom_logo').val('');
        jQuery('#flatty_custom_logo').hide();
    });

///////////////////////////////LOGO FUNCTION\\\\\\\\\\\\\\\\\\\\\\\\\\\\
function uploadLogo() {
    var file_frame;
    event.preventDefault();
    if ( file_frame ) {
      file_frame.open();
      return;
    }

    file_frame = wp.media.frames.file_frame = wp.media({
      title: jQuery(this).data( 'uploader_title' ),
      button: {text: jQuery(this).data( 'uploader_button_text' )},
      multiple: false
    });

    file_frame.on( 'select', function() {
      attachment = file_frame.state().get('selection').first().toJSON();

      jQuery('#flatty_custom_logo').val(attachment.url);

      jQuery('#flatty_custom_logo_img').show();
      jQuery('#flatty_custom_logo_img').attr('src', attachment.url);

      jQuery('#button-remove_logo').show();
      jQuery('#button-upload_logo').hide();
    });

    file_frame.open();
}

////////////////////////////////////////////////////////////////////FAVICON UPLOAD\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    jQuery('#button-upload_favicon').on('click', function(){
        uploadFavicon();
    });

    jQuery('#button-remove_favicon').on('click', function(){
        jQuery('#button-remove_favicon').hide(); //hide itself
        jQuery('#flatty_custom_favicon_img').hide(); //hide logo picture

        jQuery('#button-upload_favicon').show();
        jQuery('#flatty_custom_favicon').val('');
        jQuery('#flatty_custom_favicon').hide();
    });

///////////////////////////////FAVICON FUNCTION\\\\\\\\\\\\\\\\\\\\\\\\\\\\
function uploadFavicon() {
    var file_frame;
    event.preventDefault();
    if ( file_frame ) {
      file_frame.open();
      return;
    }

    file_frame = wp.media.frames.file_frame = wp.media({
      title: jQuery(this).data( 'uploader_title' ),
      button: {text: jQuery(this).data( 'uploader_button_text' )},
      multiple: false
    });

    file_frame.on( 'select', function() {
      attachment = file_frame.state().get('selection').first().toJSON();

      jQuery('#flatty_custom_favicon').val(attachment.url);

      jQuery('#flatty_custom_favicon_img').show();
      jQuery('#flatty_custom_favicon_img').attr('src', attachment.url);

      jQuery('#button-remove_favicon').show();
      jQuery('#button-upload_favicon').hide();
    });

    file_frame.open();
}


///END WINDOW LOAD
});
