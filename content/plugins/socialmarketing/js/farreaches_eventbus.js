// All event bus functionality is implemented using javascript module-pattern and encapsulated inside FARREACHES scope.
window.FARREACHES = (function(FARREACHES) {

    /**
     * Factory method to create event bus.
     *
     * It is mostly needed in Jasmine test fixture to create a brand new event bus for each test.
     */
    FARREACHES.EventBusCreate = function() {
        return (function() {

            var self = {};

            /**
             * @private
             */
            var _handlers = [], _topic_handlers = {}, _topic_envelopes = {}, _loop_count = 0;

            /**
             * Publish event to the topic.
             *
             * @public
             * @param {String} topic
             * @param {*} event
             * @param {Function} success_handler executed upon succesfull delivery
             * @param {Function} failure_handler executed in case of exception thrown by a topic subscriber.
             */
            self.publish = function(topic, event, success_handler, failure_handler) {
                _loop_count++;
                try {
                    if (_loop_count > 10) {
                        console.error('Event loop detected, publishing interrupted.');
                        return;
                    }
                    self.enqueue(topic, event, success_handler, failure_handler);
                    _topic_envelopes['eventbus://publish'] = [ _to_envelope(topic) ];
                    self._deliver(_topic_envelopes);
                } finally {
                    _loop_count--;
                }
            };

            /**
             * Add an event to the delivery queue but don't immediately deliver.
             *
             * Each event listener is executed synchronously inside event bus delivery loop.
             * If some event handler publishes other event - it re-starts a delivery loop not finishing first one.
             * To avoid this endless delivery loop problem the enqueue() method should be used.
             *
             * @public
             * @todo create a unit test.
             * @todo TODO TO_KOSTYA find a way to avoid aforementioned problem. It should be possible to use single publish() method in all handlers without infinite loops
             * @param {String} topic
             * @param {*} event
             * @param {Function} success_handler executed upon succesfull delivery
             * @param {Function} failure_handler executed in case of exception thrown by a topic subscriber.
             */
            self.enqueue = function(topic, event, success_handler, failure_handler) {
                if (typeof _topic_envelopes[topic] == 'undefined') {
                    _topic_envelopes[topic] = [];
                }
                _topic_envelopes[topic].push(_to_envelope(event, success_handler, failure_handler));
            };

            /**
             * Subscribe to the topic.
             *
             * @public
             * @param {String} topic
             * @param {Function} handler executed when event is published to the topic.
             */
            self.subscribe = function(topic, handler) {
                if (typeof _topic_handlers[topic] == 'undefined') {
                    _topic_handlers[topic] = [ handler ];
                } else {
                    _topic_handlers[topic].push(handler);
                }
            };

            /**
             * @private
             * @return {Object} map 'topic' to [envelopes]
             */
            self._get_topic_envelopes = function() {
                return _topic_envelopes;
            };

            /**
             * Deliver topic envelopes to subscribers.
             *
             * @private
             * @param {Object} topic_envelopes
             */
            self._deliver = function(topic_envelopes) {
                jQuery.each(topic_envelopes, jQuery.proxy(function(topic, envelopes) {
                    _deliver_topic_envelopes(topic, envelopes);
                }, self));
            };

            /**
             * Clears topic envelopes.
             *
             * For example after delivery.
             *
             * @private
             * @return {Number} how many have been cleared
             */
            self._clear_topic_envelopes = function() {
                jQuery.each(_topic_envelopes, function(i, envelope) {
                    if (typeof envelope.success_handler_reg_id == 'number') {
                        _unregister_handler(envelope.success_handler_reg_id);
                    }
                    if (typeof envelope.failure_handler_reg_id == 'number') {
                        _unregister_handler(envelope.failure_handler_reg_id);
                    }
                });

                var envelopes_count = _topic_envelopes.length;
                _topic_envelopes = {};
                return envelopes_count;
            };

            /**
             * Execute event success handler (if defined).
             *
             * @private
             * @param {Object} envelope
             * @param {*} result returned by subscriber passed to a success handler.
             */
            self._handle_success = function(envelope, result) {
                if (typeof envelope.success_handler_reg_id == 'number') {
                    var success_handler = _handlers[envelope.success_handler_reg_id];
                    if (jQuery.isFunction(success_handler)) {
                        success_handler(result);
                    }
                }
            };

            /**
             * Execute event failure handler (if defined).
             *
             * @private
             * @param {Object} envelope
             * @param {*} cause exception thrown by subscriber passed to a failure handler.
             */
            self._handle_failure = function(envelope, cause) {
                if (typeof envelope.failure_handler_reg_id == 'number') {
                    var failure_handler = _handlers[envelope.failure_handler_reg_id];
                    if (jQuery.isFunction(failure_handler)) {
                        failure_handler(cause);
                    }
                }
            };

            /**
             * Deliver envelopes to the topic.
             *
             * @private
             * @param {String} topic
             * @param {Array} envelopes
             */
            function _deliver_topic_envelopes(topic, envelopes) {
                var undelivered = [];
                while (envelopes.length > 0) {
                    var envelope = envelopes.shift();
                    if (!_deliver_topic_envelope(topic, envelope)) {
                        undelivered.push(envelope);
                    }
                }
                if (_keep_undelivered(topic)) {
                    envelopes.length = 0;
                    for (var i = 0; i < undelivered.length; i++) {
                        envelopes.push(undelivered[i]);
                    }
                }
            }

            /**
             * Deliver envelope to the topic.
             *
             * @private
             * @param {String} topic
             * @param {Object} envelope
             */
            function _deliver_topic_envelope(topic, envelope) {
                var handlers = _topic_handlers[topic] || [], delivered = false;
                jQuery.each(handlers, function(i, handler) {
                    try {
                        var event_string = envelope.event;
                        if (event_string == null) {
                            event_string = 'empty event';
                        }
                        console.debug('FarReaches: Delivering '+ event_string + ' to topic "' + topic +'"...');
                        var result = handler(envelope.event);
                        console.debug('FarReaches: Done delivering '+ event_string+ ' to topic "'+ topic+ '"');
                        self._handle_success(envelope, result);
                    } catch (e) {
                        self._handle_failure(envelope, e);
                    } finally {
                    	if (!_keep_undelivered(topic)) {
                    		delivered = true;                    		
                    	}
                    }
                });
                if (delivered) {
                    if (typeof envelope.success_handler_reg_id == 'number') {
                        _unregister_handler(envelope.success_handler_reg_id);
                    }
                    if (typeof envelope.failure_handler_reg_id == 'number') {
                        _unregister_handler(envelope.failure_handler_reg_id);
                    }
                }
                return delivered;
            }

            /**
             * Register handler for a later invocation.
             *
             * In case of server-side subscriber and client-side publisher a callback handler function doesn't passed over the wire (HTTP).
             * Callback handler is registered and then its registration number transferred.
             * When server returns results this registration number is used to locate callback and run it.
             *
             * @private
             * @param {Function} handler
             * @return {Number} handler registration id
             */
            function _register_handler(handler) {
                _handlers.push(handler);
                return _handlers.length - 1;
            }

            /**
             * Unregister handler.
             *
             * @private
             * @param {Number} handler_id registration id
             * @return {Function} unregistered handler
             */
            function _unregister_handler(handler_id) {
                return _handlers.splice(handler_id, 1)[0];
            }

            /**
             * Each event published to a topic is wrapped up into the envelope.
             *
             * Envelope is a data structure containing event itself + meta info like success and failure handlers registration ids.
             *
             * @private
             * @param {*} event
             * @param {Function} success_handler executed upon successful delivery
             * @param {Function} failure_handler executed in case of exception thrown by a topic subscriber.
             * @return {Object} envelope
             */
            function _to_envelope(event, success_handler, failure_handler) {
                if (!event) {
                    event = null;
                }
                var result = {event:event};
                if (jQuery.isFunction(success_handler)) {
                    result.success_handler_reg_id = _register_handler(success_handler);
                }
                if (jQuery.isFunction(failure_handler)) {
                    result.failure_handler_reg_id = _register_handler(failure_handler);
                }
                return result;
            }

            /**
             * Some topics exists for the client-side purposes only. They should not be delivered to the server.
             *
             * @private
             * @param {String} topic
             * @return {Boolean} true if events published to the topic should not be delivered to the server.
             */
            function _keep_undelivered(topic) {
                return topic.indexOf('eventbus://') !== 0;
            }

            return self;

        }());
    };

    /**
     * Create Event Bus and make it public.
     */
    FARREACHES.EventBus = FARREACHES.EventBusCreate();

    /**
     * Event bus bridge is responsible for the Server <-> Client delivery of events.
     *
     * It issues AJAX request with some interval to post client's events and fetch server's events.
     */
    FARREACHES.EventBusBridgeCreate = function() {
        return (function() {

            /**
             * @private
             */
            var self = {},
                _local_topic_prefixes = ['eventbus://', 'local://'],
                _event_bus = undefined,
                _url = undefined,
                _interval = undefined,
                _timeout = undefined,
                _scheduler = undefined;

            /**
             * Start polling cycle to synchronize events.
             *
             * @public
             * @param {Object} event_bus to synchronize
             * @param {String} sync_url server URL to send AJAX requests
             * @param {Number} interval between synchronization requests (milliseconds).
             * @param {Object} scheduler contains setTimeout() and clearTimeout() methods (window)
             */
            self.start = function(event_bus, sync_url, interval, scheduler) {
                _event_bus = event_bus;
                _url = sync_url;
                _interval = interval;
                _scheduler = scheduler;

                event_bus.subscribe('eventbus://publish', jQuery.proxy(function(topic) {
                    if (!starts_with(topic, _local_topic_prefixes)) {
                        self.sync();
                    }
                }, self));

                self.sync();
            };

            /**
             * Stop polling cycle.
             *
             * @public
             */
            self.stop = function() {
                if (_timeout) {
                    _scheduler.clearTimeout(_timeout);
                }
                console.info('FARREACHES.EventBusBridge synchronization is switched off. To switch it on run FARREACHES.EventBusBridge.sync() manually.');
            };

            /**
             * Synchronize server and client events.
             *
             * @public
             *
             * Executed in different cases:
             * 1) When any event is published to any topic.
             * 2) When scheduled timeout happens.
             * 3) When invoked manually from Firebug console.
             */
            self.sync = function() {
                if (_timeout) {
                    _scheduler.clearTimeout(_timeout);
                }
                _event_bus.publish('eventbus://sync/before');
                jQuery.ajax({
                    type:'post',
                    url:_url,
                    context:self,
                    dataType:'json',
                    data:{
                        payload:JSON.stringify(_filter_local_topics(_event_bus._get_topic_envelopes()))
                    }
                }).done(
                    function(response) {
                        _event_bus.topic_envelopes = new Object;
                        var delivered = response['event_bus_delivered_events'] || [];
                        jQuery.each(delivered, function() {
                            $envelope = this;
                            jQuery.each(this.result, function() {
                                if (this.call_status == 'success') {
                                    _event_bus._handle_success($envelope, this);
                                } else {
                                    _event_bus._handle_failure($envelope, this);
                                }
                            });
                        });
                        _event_bus._deliver(response['event_bus_pending_events'] || []);
                        _event_bus.publish('eventbus://sync/done', response);
                    }
                ).fail(
                    function(xhr, status, error) {
                    	console.warn("FarReaches :" + error.stack + " response text:" + xhr.responseText);
                        jQuery.each(_event_bus._get_topic_envelopes(), function() {
                            _event_bus._handle_failure(this, error);
                        });
                        _event_bus.publish('eventbus://sync/fail', [xhr, status, error]);
                    }
                ).always(
                    function() {
                        var cleared = _event_bus._clear_topic_envelopes();
                        _event_bus.publish('eventbus://sync/after', cleared);
                        if (_interval < 1) {
                            console.warn('eventBusBridge sync interval is less than 1ms, synchronization is switched off');
                            return;
                        } else if (_interval < 2000) {
                            console.warn('eventBusBridge sync interval is less than 1 second, minumum value of 2 seconds will be used');
                            _interval = 2000;
                        }
                        _timeout = _scheduler.setTimeout(self.sync, _interval);
                    }
                );
            };

            function _filter_local_topics(topic_envelopes) {
                return _filter_topics(_local_topic_prefixes, topic_envelopes);
            }

            function _filter_topics(prefixes, topic_envelopes) {
                var filtered = {};
                jQuery.each(topic_envelopes, jQuery.proxy(function(topic, envelopes) {
                    if (!starts_with(topic, prefixes)) {
                        filtered[topic] = envelopes;
                    }
                }, self));
                return filtered;
            }

            function starts_with(subject, prefixes) {
                var positive = false;
                for (var i = 0; i < prefixes.length; i++) {
                    if (subject.indexOf('' + prefixes[i]) === 0) {
                        positive = true;
                        break;
                    }
                }
                return positive;
            }

            return self;

        }());

    };

    /**
     * Create Event Bus Bridge and make it public.
     */
    FARREACHES.EventBusBridge = FARREACHES.EventBusBridgeCreate();

    return FARREACHES;

}(window.FARREACHES || {}));
