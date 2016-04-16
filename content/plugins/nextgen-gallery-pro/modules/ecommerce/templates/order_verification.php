<div id="ngg_order_verification" data-order="<?php echo esc_attr($order_hash)?>">
    <p>
        <?php esc_html_e($i18n->verifying_order_msg)?><br/>
        <?php esc_html_e($i18n->please_wait_msg)?>
    </p>
    <p><?php esc_html_e($i18n->redirect_msg)?></p>
    <script type="text/javascript">
        jQuery(function($){
            function ngg_verify_order(order)
            {
                setTimeout(function(){
                    var request = {
                        action: 'is_order_verified',
                        order:  order
                    };
                    $.post(photocrati_ajax.url, request, function(response){
                        if (typeof(response) != 'object') response = JSON.parse(response);
                        if (response.verified) window.location = response.thank_you_page_url;
                        else ngg_verify_order(order);
                    });
                }, 1000);
            }

            ngg_verify_order($('#ngg_order_verification').attr('data-order'));
        });
    </script>
</div>