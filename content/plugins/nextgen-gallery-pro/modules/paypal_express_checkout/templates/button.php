<a href="javascript:void(0)"
   id="paypal_express_checkout_button"
   data-processing-msg="<?php echo esc_attr($processing_msg)?>"
   data-submit-msg="<?php echo esc_attr($value)?>"
   class="ngg_pro_btn paypal"><?php esc_html_e($value); ?></a>
<script type="text/javascript">
	jQuery(function($){
		$('#paypal_express_checkout_button').click(function(e){
			e.preventDefault();

			// Disable the button from further clicks
			$(this).attr('disabled', 'disabled');

			// Change the text of the button to indicate that we're processing
			$(this).text($(this).attr('data-processing-msg'));

			// Start express checkout with PayPal
			var post_data = $('#ngg_pro_checkout').serialize();
			post_data += "&action=paypal_express_checkout";
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

				// Redirect to PayPal
				else {
					window.location = response.redirect;
				}
			});

		});
	});
</script>