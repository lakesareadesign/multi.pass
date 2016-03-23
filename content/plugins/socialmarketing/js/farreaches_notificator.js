/**
 * This component manages WordPress-style notifications. It uses EventBus to fetch [dismiss] notifications from the server side.
 * PHP Class FarReaches_Notifications_Manager is this component's server-side counterpart.
 *
 * An example of the generated markup structure:
 *
 * <div id="wp_notificator">
 *     <div class="updated wp_notificator_style wp_notificator_permanent"
 *          style="display:block"
 *          content="plugin_retrying_connection"
 *          data-permanent="true">
 *         <p>SocialMarketing is now reconnecting with the server at FarReach.es.</p>
 *             <a href="javascript:void(0);" class="wp_notificator_dismiss">Dismiss</a>
 *     </div>
 * </div>
 */

window.FARREACHES = (function(FARREACHES) {

    FARREACHES.NotificationManager = (function() {

        var scope = {};

        scope.initialize = function() {
            var div = '<div id="wp_notificator"></div>';
            jQuery('#wpbody-content .wrap:first').prepend(div);                
            jQuery('#wp_notificator').on('click', '.wp_notificator_dismiss', function() {
                var div = jQuery(this).parents('div.wp_notification');
                FARREACHES.EventBus.publish('farreaches://notification/dismiss', [div.data('key')], null, function() {
                    scope.restore_notification(div);
                });                    
            });

            FARREACHES.EventBus.subscribe('farreaches://notification/show', function(notification_data) {
                scope.show_notification(notification_data);
            });

            FARREACHES.EventBus.subscribe('farreaches://notification/dismiss', function(event) {
                // 0 - notification key
                // 1 - user id
                scope.dismiss_notification(event[0]);
            });
        };

        scope.restore_notification = function($element) {
            $element.slideDown('slow').fadeIn('slow').dequeue();
        };

        scope.show_notification = function(notification_data) {
            if (typeof notification_data['progress'] == 'undefined') {
                notification_data['progress'] = false;
            }
            if (notification_data['transient'] === true) {
                scope.show_notification_transient(notification_data['key'], notification_data['text'], notification_data['progress']);
            } else {
                scope.show_notification_permanent(notification_data['key'], notification_data['text'], notification_data['progress']);
            }
        };

        scope.dismiss_notification = function(key) {
            _hide_notification_element(jQuery("div[data-key='" + key + "']"));
        };

        /**
         * Prints a permanent message on the notifications manager.
         *
         * @param message plaintext or html to print in the message
         * @returns string id of the element created
         */
        scope.show_notification_permanent = function(key, message, progress, writable) {
            return _show_notification({key:key, text:message, permanent:true, is_progress:progress, is_writeable: writable});
        };

        /**
         * Prints a non permanent message on the notifications manager.
         *
         * @param message plaintext or html to print in the message
         * @returns string id of the element created
         */
        scope.show_notification_transient = function(key, message, progress) {
            return _show_notification({key:key, text:message, permanent:false, is_progress:progress});
        };
        
        function _hide_notification_element($element) {
            $element.fadeOut('slow', function(){
                $element.remove();
            }).dequeue();
        }

        function _show_notification(options) {
            var notificator = jQuery('#wp_notificator');
            if (!notificator.is(":visible")) {
                jQuery('#wpbody-content .wrap:first').prepend(notificator);
                notificator.show();
            }
            if (jQuery('div[data-key=' + options.key + ']:visible').size() > 0) {
                console.warn('Duplicate notification with key "' + options.key + '"');
                return undefined;
            }

            if (typeof _show_notification.messageID == 'undefined') {
                _show_notification.messageID = 0;
            }

            var opt = {};
            var default_values = { permanent:false, is_writeable:true, id:_show_notification.messageID++, old:false, is_progress:false };
            jQuery.extend(opt, default_values, options);

            var div = jQuery('<div><p>' + opt.text + '</p></div>')
                .hide()
                .attr('id', 'notification_' + opt.id)
                .attr('data-key', opt.key)
                .attr('data-permanent', opt.permanent)
                .addClass('wp_notification')
                .addClass(opt.permanent ? 'wp_notificator_permanent' : 'wp_notificator_transient');

            if (opt.is_writeable) {
                var a = jQuery('<a> × </a>&nbsp;').attr('href', 'javascript:void(0);').addClass('wp_notificator_dismiss');
                a.prependTo(div.find('p'));
            }
            if (opt.is_progress){
                div.addClass('farreaches-loading');
            }

            div.appendTo('#wp_notificator');
            div.slideDown('fast').fadeIn('slow');
            if (!opt.permanent) {
            	setTimeout(function() {
            		div.fadeOut('slow').dequeue();
            	}, 5000);
            }
            div.dequeue();
            return opt.id;
        }

        return scope;

    }());

    return FARREACHES;

}(window.FARREACHES || {}));


