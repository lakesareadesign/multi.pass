jQuery(function($) {
    var showActivation = function() {
        $('#confirmation').hide();
        FARREACHES.NotificationManager.show_notification_permanent('farreaches_activation_js_progress', 'Please wait. We are registering your account.', true, false);  
    };
    
    var marketingAndTechnicalContactSame = function() {
    	if ( $("#marketingAndTechnicalContactSame").is(":checked") ) {
    		$("#technicalContact").hide();
    	} else {
    		$("#technicalContact").show();   		
    	}
    };
    $("#marketingAndTechnicalContactSame").click(marketingAndTechnicalContactSame);
    marketingAndTechnicalContactSame();
    
    FARREACHES.EventBus.subscribe('farreaches://plugin_state/synced', function() {
    	// HACK : should have a generic retry
        window.location.href = FARREACHES.config['activation_landing_url'];
    });

    FARREACHES.EventBus.subscribe('farreaches://plugin_state/confirmed', function() {
        showActivation();
    });

    if (FARREACHES.config['plugin_state'] == 'plugin_state/confirmed') {
        showActivation();
    }
    if (FARREACHES.config['plugin_state'] == 'plugin_state/synced') {
    	window.location.href = FARREACHES.config['activation_landing_url'];
    }
});