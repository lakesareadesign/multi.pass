if (window.jQuery) {  
  jQuery(window).load(function() {

  jQuery('.color_field').wpColorPicker({
    width: 300,
    palettes:false,
    change: function(event, ui){
      var bkgColor = event.target.value;
      jQuery('#flatty-adminbar').css('background-color', bkgColor );
    }
  });

  ///////////////////////////////ACTIONS\\\\\\\\\\\\\\\\\\\\\\\\\\\\
  jQuery('#flatty-hide-menu').on('click', function(){
    if(jQuery('#adminmenumain').css('display') == 'none') {
      jQuery('#adminmenumain').removeClass('hidden');
      jQuery('#wpcontent').removeClass('fullwidth');
      jQuery('#wpfooter').removeClass('fullwidth');
      jQuery('#flatty-hide-menu').html('<i class="dashicons dashicons-menu"></i>');
    } else {
      jQuery('#adminmenumain').addClass('hidden');
      jQuery('#wpcontent').addClass('fullwidth');
      jQuery('#wpfooter').addClass('fullwidth');
      jQuery('.mce-toolbar-grp').addClass('fullwidth');
      jQuery('#flatty-hide-menu').html('<i class="dashicons dashicons-menu" style="opacity:.5"></i>');
    }
  });

  jQuery('#flatty_topbar_background_type').on('change', function(){
    //change background type dinamically
    var bkgType = "";
    bkgType = this.value;
    if (bkgType == "image") {
      jQuery('#flatty-adminbar').css('background-size', 'cover' );
      jQuery('#flatty-adminbar').css('background-repeat', 'norepeat' );
      jQuery('#flatty-adminbar').css('background-position', 'center' );
    } else {
      jQuery('#flatty-adminbar').css('background-size', 'contain' );
      jQuery('#flatty-adminbar').css('background-repeat', 'repeat' );
      jQuery('#flatty-adminbar').css('background-position', 'initial' );
    }  
  });

  jQuery('#flatty_topbar_background_blend').on('change', function(){
    //change background blend dinamically
    var bkgBlend = "";
    bkgBlend = this.value;
    jQuery('#flatty-adminbar').css('background-blend-mode', bkgBlend );
  });
  ////////////////////////////////////////CUSTOM BACKGROUND IMAGE\\\\\\\\\\\\\\\\\\\\\\\\\\\\
  jQuery('#button-upload_background_image').on('click', function(){
    uploadCustomBackgroundImage();
  });

  jQuery('#button-remove_background_image').on('click', function(){
    jQuery('#button-remove_background_image').hide(); //hide itself
    jQuery('#button-upload_background_image').show();
    jQuery('#flatty_topbar_background_image').val('');
    jQuery('#flatty_topbar_background_image').hide();
  });
  ///////////////////////////////CUSTOM BACKGROUND IMAGE FUNCTION\\\\\\\\\\\\\\\\\\\\\\\\\\\\
  function uploadCustomBackgroundImage() {
      var file_frame;
      var backimage;
      event.preventDefault();
      if ( file_frame ) {
        file_frame.open();
        return;
      }

      file_frame = wp.media.frames.file_frame = wp.media({
        title: 'Add custom background image',
        button: {
          text: 'Use this as background'
        },
        multiple: false
      });

      file_frame.on( 'select', function() {
        attachment = file_frame.state().get('selection').first().toJSON();
        backimage = attachment.url;
        jQuery('#flatty_topbar_background_image').val(attachment.url);
        
        //add dinamically
        jQuery('#flatty-adminbar').css('background-image', 'url("' + backimage + '")' );

        jQuery('#button-remove_background_image').show();
        jQuery('#button-upload_background_image').hide();
      });

      file_frame.open();
  }

  ////////////////////////////////////////////////////////////////////BUSINESS CARD PICTURE UPLOAD\\\\\\\\\\\\\\\\\\\\\\\\\\\\
  jQuery('#button_upload_business_card_picture').on('click', function(){
    uploadCustomerServiceLogo();
  });
  jQuery('#button_remove_business_card_picture').on('click', function(){
    jQuery('#button_remove_business_card_picture').hide(); //hide itself
    jQuery('#button_upload_business_card_picture').show(); //show upload button
    jQuery('#flatty_business_card_picture').val(''); //reset old url
  });
  ///////////////////////////////SUPPORT WIDGET LOGO FUNCTION\\\\\\\\\\\\\\\\\\\\\\\\\\\\
  function uploadCustomerServiceLogo() {
      var file_frame;
      event.preventDefault();
      if ( file_frame ) {
        file_frame.open();
        return;
      }

      file_frame = wp.media.frames.file_frame = wp.media({
        title: 'Add a picture to the support widget',
        button: {
          text: 'Use this picture'
        },
        multiple: false
      });

      file_frame.on( 'select', function() {
        attachment = file_frame.state().get('selection').first().toJSON();

        jQuery('#flatty_business_card_picture').val(attachment.url);

        jQuery('#button_remove_business_card_picture').show();
        jQuery('#button_upload_business_card_picture').hide();
      });

      file_frame.open();
  }
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
        title: 'Add Brand or Site Logo',
        button: {
          text: 'Use this logo'
        },
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
        title: 'Add Brand or Site FavIcon',
        button: {
          text: 'Use this favIcon'
        },
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

  ////////////////////////////////////////////////////////////////////LOGIN BACKGROUND UPLOAD\\\\\\\\\\\\\\\\\\\\\\\\\\\\
      jQuery('#button_flatty_login_background_upload').on('click', function(){
          uploadLoginCustomBackground();
      });

      jQuery('#button_flatty_login_background_remove').on('click', function(){
          jQuery('#button_flatty_login_background_remove').hide(); //hide itself
          jQuery('#flatty_login_custom_bkg_img').hide(); //hide logo picture

          jQuery('#button_flatty_login_background_upload').show();
          jQuery('#flatty_login_background_url').val('');
          jQuery('#flatty_login_background_url_img').hide();
      });

  ///////////////////////////////LOGIN BACKGROUND FUNCTION\\\\\\\\\\\\\\\\\\\\\\\\\\\\
  function uploadLoginCustomBackground() {
      var file_frame;
      event.preventDefault();
      if ( file_frame ) {
        file_frame.open();
        return;
      }

      file_frame = wp.media.frames.file_frame = wp.media({
        title: 'Add custom background to login page',
        button: {
          text: 'Use this background'
        },
        multiple: false
      });

      file_frame.on( 'select', function() {
        attachment = file_frame.state().get('selection').first().toJSON();

        jQuery('#flatty_login_background_url').val(attachment.url);

        jQuery('#flatty_login_background_url_img').show();
        jQuery('#flatty_login_background_url_img').attr('src', attachment.url);

        jQuery('#button_flatty_login_background_remove').show();
        jQuery('#button_flatty_login_background_upload').hide();
      });

      file_frame.open();
  }
  ////////////////////////////////////////////////////////////////////LOGO UPLOAD\\\\\\\\\\\\\\\\\\\\\\\\\\\\


  ///END WINDOW LOAD
  });
} else {
    // jQuery is not loaded
}