<a href="javascript:void(0)"
   id="ngg_test_gateway_button"
   data-processing-msg="<?php echo esc_attr($i18n->processing_msg)?>"
   data-submit-msg="<?php echo esc_attr($i18n->button_text)?>"
   class="ngg_pro_btn"><?php esc_html_e($i18n->button_text); ?></a>
<script type="text/javascript">
    jQuery(function($) {
        $('#ngg_test_gateway_button').click(function(e){
            e.preventDefault();

	        // Disable the button from further clicks
	        $(this).attr('disabled', 'disabled');

	        // Change the text of the button to indicate that we're processing
	        $(this).text($(this).attr('data-processing-msg'));

            var post_data = $('#ngg_pro_checkout').serialize();
            post_data += "&action=test_gateway_checkout";
	        var $button = $(this);
            $.post(photocrati_ajax.url, post_data, function(response){
                if (typeof(response) != 'object') {
                    response = JSON.parse(response);
                }
                if (typeof(response.error) != 'undefined') {
                    $button.removeAttr('disabled');
	                $button.text($button.attr('data-submit-msg'));
                    alert(response.error);
                } else {
                    window.location = response.redirect;
                }
            });
        });
    });
</script>