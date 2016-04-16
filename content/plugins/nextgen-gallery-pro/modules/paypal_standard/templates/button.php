<a href="javascript:void(0)"
   id="ngg_paypal_standard_button"
   data-processing-msg="<?php echo esc_attr($processing_msg)?>"
   data-submit-msg="<?php echo esc_attr($value)?>"
   class="ngg_pro_btn paypal"><?php esc_html_e($value); ?></a>
<script type="text/javascript">
    jQuery(function($){
       function create_field(name, value){
           return $('<input/>').attr({
              name: name,
              value: value,
              type: 'hidden'
           });
       };


       $('#ngg_paypal_standard_button').click(function(e){
           e.preventDefault();

	       // Disable the button
	       $(this).attr('disabled', 'disabled');

	       // Change the text of the button to indicate that we're processing
	       $(this).text($(this).attr('data-processing-msg'));

           // Create temporary order
           var post_data = $('#ngg_pro_checkout').serialize();
           post_data += "&action=paypal_standard_order&use_home_country="+$('#ship_to_field select').val();
	       var $button = $(this);
           $.post(photocrati_ajax.url, post_data, function(response){
               if (typeof(response) != 'object') {
                   response = JSON.parse(response);
               }

               // If there's an error display it
               if (typeof(response.error) != 'undefined') {
                   $button.removeAttr('disabled');
	               $button.text($button.attr('data-submit-msg'));
                   alert(response.error);
               }

               // Send the order to PayPal
               else {
                   // Create paypal form
                   var $form = $('<form/>').attr({
                       action: '<?php echo esc_attr($paypal_url)?>',
                       method: 'POST'
                   });

                   // Modify return url
                   var return_url = '<?php echo esc_attr($return_url)?>';
                   if (return_url.indexOf('?') == -1)
                       return_url += '?order='+ response.order;
                   else
                       return_url += '&order='+ response.order;

                   // Modify the cancel url
                   var cancel_url = '<?php echo esc_attr($cancel_url)?>';
                   if (cancel_url.indexOf('?') == -1)
                       cancel_url += '?order='+ response.order;
                   else
                       cancel_url += '&order='+ response.order;

                   $form.append(create_field('cmd', '_cart'));
                   $form.append(create_field('upload', 1));
                   $form.append(create_field('invoice', response.order));
                   $form.append(create_field('custom', response.order));
                   $form.append(create_field('bn', 'NextGENGallery_BuyNow_WPS_US'));
                   $form.append(create_field('currency_code', '<?php echo esc_attr($currency) ?>'));
                   $form.append(create_field('business', '<?php echo esc_attr($email) ?>'));
                   $form.append(create_field('shopping_url', '<?php echo esc_attr($continue_shopping_url)?>'));
                   $form.append(create_field('return', return_url));
                   $form.append(create_field('cancel_return', cancel_url));
                   $form.append(create_field('notify_url', '<?php echo esc_attr($notify_url)?>'));

                   // Add items
                   var item_number = 1;
                   Ngg_Pro_Cart.get_instance().each(function(image){
                       image.get('items').each(function(item){
                           $form.append(create_field('amount_'+item_number, item.get('price')));
                           $form.append(create_field('quantity_'+item_number, item.get('quantity')));
                           $form.append(create_field('item_name_'+item_number, item.get('title')+ ' / ' + image.get('alttext')));
                           $form.append(create_field('item_number_'+item_number, image.get('filename')));
                           item_number++;
                       });
                   });

                   $form.append(create_field('handling_cart', Ngg_Pro_Cart.get_instance().shipping));

                   // Submit the form
                   $('body').append($form);
                   $form.submit();
               }
           });
       });
    });
</script>