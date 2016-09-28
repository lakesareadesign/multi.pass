///////////////////////////////SHOW-HIDE\\\\\\\\\\\\\\\\\\\\\\\\\\\\
if (window.jQuery) {  
    jQuery(window).load(function() {

      showTopBarProfile();
      showSiteName();
      showCustomerServiceBox();
      showCustomerServiceBoxWidget();
      showLoginLinkTitle();
      showRecaptchaConfig();
      showCustomFooterConfig();

      function showTopBarProfile() {
          if(jQuery('#flatty_use_flatty_topbar').prop( "checked")){
              jQuery("#flatty_topbar_addons").removeClass("flatty-disabled");
          } else {
              jQuery("#flatty_topbar_addons").addClass("flatty-disabled");
          }
      }

      function showSiteName() {
          if(jQuery('#flatty_show_sitename').prop( "checked")){
              jQuery("#option_flatty_show_sitename").removeClass("flatty-disabled");
          } else {
              jQuery("#option_flatty_show_sitename").addClass("flatty-disabled");
          }
      }

      function showCustomerServiceBox() {
          if(jQuery('#flatty_show_customer_service_box').prop( "checked")){
              jQuery("#info_customer_service_box").removeClass("flatty-disabled");
          } else {
              jQuery("#info_customer_service_box").addClass("flatty-disabled");
          }
      }

      function showCustomerServiceBoxWidget() {
        if(jQuery('#flatty_where_customer_service_box').val() === 'widget') {
          jQuery("#info_customer_service_box_widget").removeClass("flatty-disabled");
        } else {
          jQuery("#info_customer_service_box_widget").addClass("flatty-disabled");
        }
      }

      function showLoginLinkTitle() {
        if(jQuery('#flatty_login_custom-link').length > 0) {
          if(jQuery('#flatty_login_custom-link').val().length !== 0){
              jQuery("#login-link-title").removeClass("flatty-disabled");
          } else {
              jQuery("#login-link-title").addClass("flatty-disabled");
          }
        }
      }

      function showRecaptchaConfig() {
        if(jQuery('#flatty_login_recaptcha-use').prop( "checked")){
            jQuery("#google-recaptcha-config").removeClass("flatty-disabled");
        } else {
            jQuery("#google-recaptcha-config").addClass("flatty-disabled");
        }
      }

      function showCustomFooterConfig() {
        if(jQuery('#flatty_wp_flatty_footer_show').prop( "checked")){
            jQuery("#flatty_custom_footer").removeClass("flatty-disabled");
        } else {
            jQuery("#flatty_custom_footer").addClass("flatty-disabled");
        }
      }


  ///////////////////////////////CHECKS\\\\\\\\\\\\\\\\\\\\\\\\\\\\
      jQuery('#flatty_use_flatty_topbar').on('click', function(){
        showTopBarProfile();
      });

      jQuery('#flatty_show_sitename').on('click', function(){
        showSiteName();
      });

      jQuery('#flatty_show_customer_service_box').on('click', function(){
        showCustomerServiceBox();
      });

      jQuery('#flatty_where_customer_service_box').on('change', function(){
        if(jQuery('#flatty_where_customer_service_box').val() === 'widget') {
          jQuery("#info_customer_service_box_widget").removeClass("flatty-disabled");
        } else {
          jQuery("#info_customer_service_box_widget").addClass("flatty-disabled");
        }
      });

      jQuery('#flatty_login_custom-link').on('change', function(){
        showLoginLinkTitle();
      });

      jQuery('#flatty_login_recaptcha-use').on('click', function(){
        showRecaptchaConfig();
      });

      jQuery('#flatty_wp_flatty_footer_show').on('click', function(){
        showCustomFooterConfig();
      });

  ///////////////////////////////ACTIONS\\\\\\\\\\\\\\\\\\\\\\\\\\\\
      jQuery('#flatty-hide-menu').on('click', function(){
        if(jQuery('#adminmenumain').css('display') == 'none') {
          jQuery('#adminmenumain').removeClass('hidden');
          jQuery('#wpcontent').removeClass('fullwidth');
          jQuery('#flatty-hide-menu').html('<i class="dashicons dashicons-editor-expand"></i>Hide Sidebar');
        } else {
          jQuery('#adminmenumain').addClass('hidden');
          jQuery('#wpcontent').addClass('fullwidth');
          jQuery('.mce-toolbar-grp').addClass('fullwidth');
          jQuery('#flatty-hide-menu').html('<i class="dashicons dashicons-editor-expand"></i>Show Sidebar');
        }
      });

  ////////////////////////////////////////////////////////////////////CUSTOMER SERVICE LOGO UPLOAD\\\\\\\\\\\\\\\\\\\\\\\\\\\\
      jQuery('#button-upload_customer_logo').on('click', function(){
          uploadCustomerServiceLogo();
      });

      jQuery('#button-remove_customer_logo').on('click', function(){
          jQuery('#button-remove_customer_logo').hide(); //hide itself
          jQuery('#flatty_customer_service_logo_img').hide(); //hide logo picture

          jQuery('#button-upload_customer_logo').show();
          jQuery('#flatty_show_customer_service_logo').val('');
          jQuery('#flatty_show_customer_service_logo').hide();
      });

  ///////////////////////////////CUSTOMER SERVICE LOGO FUNCTION\\\\\\\\\\\\\\\\\\\\\\\\\\\\
  function uploadCustomerServiceLogo() {
      var file_frame;
      event.preventDefault();
      if ( file_frame ) {
        file_frame.open();
        return;
      }

      file_frame = wp.media.frames.file_frame = wp.media({
        title: 'Add customer service logo',
        button: {
          text: 'Use this logo'
        },
        multiple: false
      });

      file_frame.on( 'select', function() {
        attachment = file_frame.state().get('selection').first().toJSON();

        jQuery('#flatty_show_customer_service_logo').val(attachment.url);

        jQuery('#flatty_customer_service_logo_img').show();
        jQuery('#flatty_customer_service_logo_img').attr('src', attachment.url);

        jQuery('#button-remove_customer_logo').show();
        jQuery('#button-upload_customer_logo').hide();
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
      jQuery('#button-upload_login_background').on('click', function(){
          uploadLoginCustomBackground();
      });

      jQuery('#button-remove_login_background').on('click', function(){
          jQuery('#button-remove_login_background').hide(); //hide itself
          jQuery('#flatty_login_custom_bkg_img').hide(); //hide logo picture

          jQuery('#button-upload_login_background').show();
          jQuery('#flatty_login_custom_bkg').val('');
          jQuery('#flatty_login_custom_bkg').hide();
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

        jQuery('#flatty_login_custom_bkg').val(attachment.url);

        jQuery('#flatty_login_custom_bkg_img').show();
        jQuery('#flatty_login_custom_bkg_img').attr('src', attachment.url);

        jQuery('#button-remove_login_background').show();
        jQuery('#button-upload_login_background').hide();
      });

      file_frame.open();
  }


  ///END WINDOW LOAD
  });
} else {
    // jQuery is not loaded
}
