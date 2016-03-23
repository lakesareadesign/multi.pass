// This is a Javascript module pattern: http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
window.FARREACHES = (function(self) {

    self.redirect_on_success = function(result) {
        window.location = result[0];
    };
    
    self.notification_on_failure = function(result) {
        if (result.exception_message) {
            self.NotificationManager.show_notification_transient('server_error', result.exception_message);
        } else {
            self.NotificationManager.show_notification_transient('server_error', 'Server is not available at the moment. Please try again later.');
        }
    };
    
    self.register_child_window_close_handler = function(child_window, handler) {
        var timer = setInterval(check_child, 500);
        function check_child() {
            if (child_window.closed) {
                clearInterval(timer);
                handler();
            }
        }
    };
    
    self.reload_window_with_cache_invalidate = function(wdw) {
        wdw = wdw || window;
        var loc = wdw.location.toString();
        var invalidate_param = '&invalidate=true';
        if (loc.indexOf(invalidate_param) === -1){
            loc += invalidate_param;
        }
        wdw.location = loc;
    };

    return self;

}(window.FARREACHES || {}));

// -----------------------------------------------------------------------------------------
// TODO: Separate for clarity
// jsRender enhancements
//-----------------------------------------------------------------------------------------
jQuery(function($) {
    // Because jquery is not available until late in the loading process,
    // we cannot put $(..) code directly as script elements in the html that php generates.
    // We need to put all jquery code in a separate file ( this one ) which is also async loaded.
    // The workaround is to create configuration variables that this file can use to do the actual
    // jquery calls.
    
    var aCount = 0;

    var vm = {
        addCount:function() {
            aCount++;
            return null;
        },
        showCount:function() {
            var currentCount = aCount;
            aCount = 0;
            return currentCount;
        }
    };

    $.views.helpers({ addCount:vm.addCount, showCount:vm.showCount });

    $.views.converters({
        domId:function(value) {
            if (value) {
                value = value.replace(/[^a-zA-Z0-9]+/g, '_-_'); //we use - instead of just removing it to make sure 'a s' and  'as' aren't the same.
                //Bruno 29 aug - just to make sure i changed '-' to '_-_' to make absolutely sure that
                //                in 99.999% of cases you won't get this error!
                return value;
            } else {
                return null;
            }
        },
        cssName:function(value) {
            if (value) {
                return value.toLowerCase(value).replace(/\s+/g, '-');
            } else {
                return null;
            }
        }
    });
    
    $.views.helpers({
        incIndex: function(group, returnCurrent) {
            group = group || 'defaultgroup';            
            var idxs = arguments.callee._indexes = arguments.callee._indexes || {};
            var groupObj = idxs[group] = idxs[group] || {index: 0};
            var res = returnCurrent? groupObj.index - 1 : groupObj.index++ ; 
            
            return res;
        },
        /**
         * 24 may 2013 - PAT
         *  getFields() borrowed from jsrender examples - be on lookout for this method being put in jsrender
         *  
         *  converts a json object {"key1":"value1", "key2": "value2", ...} 
         *  to
         *  json array [{"key" : "key1", "value": "value1"}, {"key" : "key2", "value": "value2"}]
         *  
         *  this is useful because jsrender does not have keyed objects.
         *  
         *  use example: {{for ~getFields(details)}}
         *  
         */        
        getFields: function( object, keys ) {
            var key, value,
            fieldsArray = [];
            for ( key in object ) {
                if ( object.hasOwnProperty( key ) ) {
                    value = object[ key ];
                    // For each property/field add an object to the array, with key and value
                    fieldsArray.push({
                        key: key,
                        value: value
                    });
                }
            }
            // Return the array, to be rendered using {{for ~fields(object)}}
            return fieldsArray;
        }
    });
    /**
     * {{fields details}}
        <div>
            <b>{{>~key}}</b>: {{>#data}}
        </div>
       {{/fields}}
     */
    $.views.tags({
        fields: function( object ) {
                var key,
                        ret = "";
                for ( key in object ) {
                        if ( object.hasOwnProperty( key )) {
                                // For each property/field, render the content of the {{fields object}} tag, with "~key" as template parameter
                                ret += this.tagCtx.render( object[ key ], { key: key });
                        }
                }
                return ret;
        }
    });
    
    if (typeof(FARREACHES.config.templates) != "undefined") {
        $.templates(FARREACHES.config.templates);

        // automatically generate the templates instances supplied in the FARREACHES.config.templates_data
        // hard-coded use of $.link should never be needed.
        for (var index in FARREACHES.config['templates_data']) {
            var template_data = FARREACHES.config['templates_data'][index];
            var template_id = template_data['template_id'];
            if (typeof($.link[template_id]) == "undefined") {
                console.debug("undefined template " + template_id);
            }
            // If template data is not an object then jsrender doesn't render its content at all
            if (typeof template_data['data'] !== 'object' || 0 == template_data['data'].length) {
                template_data['data'] = {};
            }
            $.link[template_id](template_data['dom_selector'], template_data['data']);
        }
    }

    FARREACHES.ajax = {};
    for (var ajax_call in FARREACHES.config['ajax']) {
        FARREACHES.ajax[ajax_call] = function() {
            $.post(FARREACHES.config.ajax[ajax_call].url, { nonce:FARREACHES.config.ajax[ajax_call].nonce });
        };
    }

    // supplied by FarReaches_EventBus_Bridge_Javascript
    FARREACHES.EventBusBridge.start(FARREACHES.EventBus, FARREACHES.config['_wp_event_bus_sync_url'], FARREACHES.config['farreaches_event_bus_sync_interval'], window);

    // to initialize the notificator automatically
    FARREACHES.NotificationManager.initialize();

    if (typeof FARREACHES.config['event_bus_pending_events'] === 'object') {
        FARREACHES.EventBus._deliver(FARREACHES.config['event_bus_pending_events']);
    }

    $(document).on('change.farreaches', 'input[data-publish-topic]', function(){
        var input = $(this);
        input.prop('disabled', true);
        
        var topic = input.data('publish-topic');
        var value = input.val();
        var event = {};
        var id = input.attr('id');
        event[id] = value;
        var label = $("label[for='"+id+"']");
        label.removeClass('fr-label-success');
        label.removeClass('fr-label-failure');
        label.addClass('fr-label-progress');
        
        var success = function(result){
            label.removeClass('fr-label-progress');
            label.addClass('fr-label-success');
            input.prop('disabled', false);
        };
        var failure = function(result){
            label.removeClass('fr-label-progress');
            label.addClass('fr-label-failure');
            FARREACHES.NotificationManager.show_notification_transient('updated', 'Failed to update ' + label.html() + '.');
            input.prop('disabled', false);
        };
        FARREACHES.EventBus.publish(topic, event, success, failure);
    });
    
    $(document).on('click.farreaches', 'button[data-publish-topic], a[data-publish-topic]', function(clickEvent) {
        //Kostya: to prevent our buttons from submitting wordpress forms.
        //i.e. 'Publish now' button used to submit edit post form.
        clickEvent.preventDefault();
        
        var button = $(this);
        var topic = button.data('publish-topic');
        var event = button.data('publish-event');
        //TODO: document this usage.. see activate_confirm.tmpl
        if ('string' == typeof event && event.indexOf('!form') == 0) {
            //Gather form fields as event. 
            // Note: the '!form' is 5 characters long so the rest of the event string is a jquery selector
            var form = $(event.substring(5));
            event = form.serializeObject();
        }
        var label = button.data('publish-label');
        var label_success = button.data('publish-label-success');
        if (typeof label_success == 'undefined') {
            label_success = button.html();
        }
        var label_failure = button.data('publish-label-failure');
        if (typeof label_failure == 'undefined') {
            label_failure = button.html();
        }
        var disabled_after = button.data('publish-disabled-after');
        button.html(label);
        button.attr('disabled', 'disabled');
        var success = function(result) {
            var success_handler = FARREACHES[button.data('publish-success')];
            if ($.isFunction(success_handler)) {
                success_handler(result);
            }
            button.text(label_success);
            always();
        };
        var failure = function(result) {
            var failure_handler = FARREACHES[button.data('publish-failure')];
            if ($.isFunction(failure_handler)) {
                failure_handler(result);
            }
            button.html(label_failure);
            always();
        };
        var always = function() {
            if (!disabled_after) {
                button.removeAttr('disabled');
            }
        };
        FARREACHES.EventBus.publish(topic, event, success, failure);
        return false;
    });

    //If a button or a link submits a form, prevent that form default submit 
    //and make everything go through the buttons handler.
    $('button[data-publish-topic], a[data-publish-topic]').each(
        function(){
            var button = $(this);
            var event = button.data('publish-event');
            //TODO: document this usage.. see activate_confirm.tmpl
            if ('string' == typeof event && event.indexOf('!form') == 0) {
                //Gather form fields as event.
                // Note: the '!form' is 5 characters long so the rest of the event string is a jquery selector
                var form = $(event.substring(5));
                $(form).submit(function(event){
                    event.preventDefault();
                    button.click();
                });
            }
        }
    );

}); // END document.ready
