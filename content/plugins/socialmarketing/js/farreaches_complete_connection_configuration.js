jQuery(function($) {
    
    var create_cookie = function (name, value, days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        } else expires = "";
        document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
    };
    
    FARREACHES.EventBus.subscribe('farreaches://external-service/redirect', function($event) {
        // If you uncomment this you will see that two redirect events come almost simultaneously. Redirect urls are equal.
        // Urls look like this: http://sandbox.farreach.es:8080/api/ConfigureExtServices?externalServiceDefinition=tumblr.com&fsRedirectUrl=http%3A%2F%2Fexample.com%3A8055%2Fwordpress2%2Fwp-admin%2Fadmin.php%3Fpage%3Dfarreaches-complete-connection-configuration&redirectProperties=%5B%27messageEndPoint%27%5D&apiKey=ampcb_caf8cda1fda671ed29d837c191fd7f0a3b1771db59473b1cf10fab40b1484fa8
        // Second one instantly overrides the 1st one.
        // TODO investigate the root cause for the doubling redirect event. This may cause problems in the future.
        //console.log('redirecting popup: '+$redirect);
        document.location = $event.redirectUrl;
    });
    
    $('body > :not(#complete-connection-configuration)').hide(); //hide all nodes directly under the body
    if (FARREACHES.config['redirectData']) {
        //We set the cookie because facebook erases all additional parameters from redirect url except the first one
        //(which is taken by 'page').
        create_cookie('externalServiceDefinition', FARREACHES.config['redirectData']['externalServiceDefinition'], 1);
        FARREACHES.EventBus.publish(
                'farreaches://external-service/connect', 
                FARREACHES.config['redirectData'], 
                null,
                function(result) {
                    opener.FARREACHES.external_connection_failed(result);
                }
        );
        // HACK TODO: Style with css, get message from message-bundle..
        $('<h2 class="fr-waiting">Please wait for external service communication...</h2>').appendTo('body');
    } else if ($("div.farreaches-endpoint").size() > 1) {
            $('#complete-connection-configuration').appendTo('body');
            $('body').removeClass();
            var complete_button = $('#farreaches-complete-button');
            $(document).on('click', 'div.farreaches-endpoint', function() {
                var end_point_div = $(this);
                end_point_div.toggleClass('farreaches-endpoint-selected');
                var selected_endpoints = complete_button.data('publish-event');
                if (selected_endpoints == null) {
                    selected_endpoints = [];
                }
                var end_point_lookup_key = end_point_div.data('endpoint');
                if (end_point_div.hasClass('farreaches-endpoint-selected')) {
                    selected_endpoints.push(end_point_lookup_key);
                } else {
                    selected_endpoints.splice(selected_endpoints.indexOf(end_point_lookup_key), 1);
                }
                complete_button.data('publish-event', selected_endpoints);
            });
    } else {
        var selected_endpoints = [$('div.farreaches-endpoint').data('endpoint')];
        var complete_button = $('#farreaches-complete-button');
        complete_button.data('publish-event', selected_endpoints);
        complete_button.click();
    }
});
