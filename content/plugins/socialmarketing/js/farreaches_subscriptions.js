jQuery(function($) {
    $('.farreaches-subscribe').click(function(){
        FARREACHES.NotificationManager.dismiss_notification('subscription-failed');
        FARREACHES.NotificationManager.dismiss_notification('try-again');
        
        var button = $(this);
        var plan = button.data('plan');
        var plan_id = button.data('plan-id');
        
        var token = function(res){
            FARREACHES.EventBus.publish('farreaches://subscribe/', {
                charge: { card:res.id },
                featureSetDefinition: plan_id
            });
            $('#farreaches-subscription-list').hide();
            FARREACHES.NotificationManager.show_notification_permanent(
                    key = 'subscruption-in-progress',
                    text = 'Sending your subscription request to Farreach.es...',
                    progress = true);
        };

        StripeCheckout.open({
          key:         FARREACHES.config['stripe_publishable_key'],
          address:     false,
          name:        'Farreach.es',
          description: plan,
          panelLabel:  'Checkout',
          token:       token
        });

        return false;
      });
    
    $('.farreaches-free').click(function(){
       window.location.href= FARREACHES.config['settings_page_url'];
    });
    
    FARREACHES.EventBus.subscribe('farreaches://subscribe/success', function() {
        window.location.reload();
    });


    FARREACHES.EventBus.subscribe('farreaches://subscribe/fail', function($event_data) {
        FARREACHES.NotificationManager.dismiss_notification('subscruption-in-progress');
        FARREACHES.NotificationManager.show_notification_permanent(
                key = 'subscription-failed',
                text = $event_data['error']);
        FARREACHES.NotificationManager.show_notification_transient(
                key = 'try-again',
                text = 'Try again or contact our support team.');
        $('#farreaches-subscription-list').show();
    });

});