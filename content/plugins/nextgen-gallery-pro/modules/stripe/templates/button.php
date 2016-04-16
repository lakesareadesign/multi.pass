<span id="stripe-checkout-button">
	<button class="stripe-button-el" type="submit" name="ngg_pro_checkout" value="stripe_checkout">
		<span style="display: block; min-height: 30px;"><?php  echo esc_html($i18n->pay_with_card)?></span>
	</button>
</span>
<script type="text/javascript">
    jQuery('.stripe-button-el').attr('style', 'visibility: inherit !important');

	jQuery(function($){

        $('.stripe-button-el').hover(
            function(){
                $(this).find('span').css('background', 'inherit');
            },
            function(){
                $(this).find('span').css('background', 'linear-gradient(#7DC5EE, #008CDD 85%, #30A2E4) repeat scroll 0 0 #1275FF');
            }
        );

		$('#stripe-checkout-button button').click(function(e){
			e.preventDefault();

            var stripe_vars = <?php echo $stripe_vars ?>;
            stripe_vars.token = function(token, args){
                var $form = $('#ngg_pro_checkout');

                // Add token to the form
                var $input = $('<input/>').attr({
                    type: 	'hidden',
                    name: 	'stripe[token]',
                    value:	token.id
                });
                $form.append($input);

                // Add last four digits of the card
                $input = $('<input/>').attr({
                    type:	'hidden',
                    name: 	'stripe[last_four]',
                    value:  token.last4
                });
                $form.append($input);

                // Add the user's e-mail address
                $input = $('<input/>').attr({
                    type: 	'hidden',
                    name:	'stripe[email]',
                    value:  token.email
                });
                $form.append($input);

                // Add the customer name
                $input = $('<input/>').attr({
                    type: 	'hidden',
                    name:	'stripe[customer_name]',
                    value:  args.shipping_name
                });
                $form.append($input);

                // Add the shipping address
                $input = $('<input/>').attr({
                    type: 	'hidden',
                    name:	'stripe[shipping_street_address]',
                    value:  args.shipping_address_line1
                });
                $form.append($input);

                // Add the shipping city
                $input = $('<input/>').attr({
                    type: 	'hidden',
                    name:	'stripe[shipping_city]',
                    value:  args.shipping_address_city
                });
                $form.append($input);

                // Add the shipping state
                $input = $('<input/>').attr({
                    type: 	'hidden',
                    name:	'stripe[shipping_state]',
                    value:  args.shipping_address_state
                });
                $form.append($input);

                // Add the shipping zip
                $input = $('<input/>').attr({
                    type: 	'hidden',
                    name:	'stripe[shipping_zip]',
                    value:  args.shipping_address_zip
                });
                $form.append($input);

                // Add the shipping country
                $input = $('<input/>').attr({
                    type: 	'hidden',
                    name:	'stripe[shipping_country]',
                    value:  args.shipping_address_country
                });
                $form.append($input);

                // Notify that the user that this is a NGG Pro checkout request
                $input = $('<input/>').attr({
                    type: 'hidden',
                    name: 'ngg_pro_checkout',
                    value: 'stripe_checkout'
                });
                $form.append($input);

                // Create checkout request
                var post_data = $('#ngg_pro_checkout').serialize();
                post_data += "&action=stripe_checkout";
                $.post(photocrati_ajax.url, post_data, function(response){
                    if (typeof(response) != 'object') {
                        response = JSON.parse(response);
                    }

                    // If there's an error display it
                    if (typeof(response.error) != 'undefined') {
                        $(this).removeAttr('disabled');
                        alert(response.error);
                    }

                    // Redirect to thank you page
                    else {
                        window.location = response.redirect;
                    }
                });
            }

            var handler = StripeCheckout.configure(stripe_vars);

			handler.open({
				name: stripe_vars.site_name,
				description: Ngg_Pro_Cart.get_instance().length+' images'
			});
		});
	});
</script>