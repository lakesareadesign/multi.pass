// This is a Javascript module pattern: http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
window.FARREACHES = (function(self) {
	var $ = jQuery;
	
	var connect_popup;
	var child_close_handler_enabled;
	
    self.show_connection_popup = function(result) {
    	connect_popup = window.open(FARREACHES.config['show_page_complete_connection_configuration_url'] + '&externalServiceDefinition=' + result, '_blank', 'width=600,height=500');
    	if(connect_popup == null || typeof(connect_popup) == "undefined") {
    		self.NotificationManager.show_notification_transient('popup_blocked', 'Please enable popups for this site and try again.');
    	} else {
    	    $.modal('<h1>Authorize us to act on your behalf.</h1><p>See the popup window.</p>');
    	}
    	FARREACHES.EventBus.subscribe('farreaches://external-service/redirect', function($event) {
    		// If you uncomment this you will see that two redirect events come almost simultaneously. Redirect urls are equal.
    		// Urls look like this: http://sandbox.farreach.es:8080/api/ConfigureExtServices?externalServiceDefinition=tumblr.com&fsRedirectUrl=http%3A%2F%2Fexample.com%3A8055%2Fwordpress2%2Fwp-admin%2Fadmin.php%3Fpage%3Dfarreaches-complete-connection-configuration&redirectProperties=%5B%27messageEndPoint%27%5D&apiKey=ampcb_caf8cda1fda671ed29d837c191fd7f0a3b1771db59473b1cf10fab40b1484fa8
    		// Second one instantly overrides the 1st one.
    		// TODO investigate the root cause for the doubling redirect event. This may cause problems in the future.
    		//console.log('redirecting popup: '+$redirect);
    		connect_popup.location.href = $event.redirectUrl;
        });
    	
    	child_close_handler_enabled = true;
    	FARREACHES.register_child_window_close_handler(connect_popup, function(){
    		if (child_close_handler_enabled){
    			FARREACHES.reload_window_with_cache_invalidate();	
    		}
    	});
    };
    
    self.close_connection_popup = function(result) {
    	if (window.opener){
    		// HACK: complete_connection_configuration.tmpl defines 'data-publish-success="close_connection_popup"', which currently is not aware about opener window.
    		// TODO refactor that place so no ambiguos method invocation present.
    		window.opener.FARREACHES.close_connection_popup(result);
    	}else{
        	child_close_handler_enabled = false;
        	connect_popup.close();
        	FARREACHES.reload_window_with_cache_invalidate();	
    	}
    };
    
    self.remove_endpoint = function(result) {
        $('.farreaches-endpoint-row[data-endpoint="' + result[0] + '"]').remove();
    };
    
    self.settings_save_on_success = function(result) {
    	$('#settings-form *').removeClass('farreaches-needs-save');
    	$('.farreaches-service').add('.farreaches-endpoint-row').each(function(){
    		var $el = $(this);
    		var parent = $el.find('.category-parent');
    	});
    };
    
    self.external_connection_failed = function(result) {
    	FARREACHES.notification_on_failure(result);
    	$.modal.close();
    	child_close_handler_enabled = false;
    	connect_popup.close();
    };
    
    // on document because template hasn't run
    $(document).on('click.farreaches', 'button.fr-connect-button', function(clickEvent){
    	clickEvent.preventDefault();
    	var $button = $(this);
    	var service_name = $button.data('service-name');
    	FARREACHES.show_connection_popup(service_name);
    });
    
    $(document).on('click.farreaches', '.farreaches-category-change', function(clickEvent) {
    	var change_button = $(this);
    	change_button.toggleClass('farreaches-assigned');
    	change_button.toggleClass('farreaches-needs-save');
    	var end_point = change_button.data('message-end-point');
    	$('#categories-' + end_point).val('');
    	var categories = '';
    	var assigned = 0;
    	var parentDiv = $('#'+end_point+'-cats');  
	    parentDiv.find('.farreaches-add[data-category="' + change_button.data('category') + '"]').toggleClass('farreaches-not-assigned');
    	$(this).parent().children('.farreaches-assigned').each(function() {
    	   var category = $(this).data('category');
    	   categories += category + ' ';
    	   assigned++;
    	});
    	var add_button = $('#' + end_point + '-add');
    	if (assigned == $(this).parent().children('.farreaches-category-change').length) {
    	    add_button.hide();
    	} else if (parentDiv.find('.farreaches-categories-add').length == 0){
    	    add_button.show();
    	}
    	if (assigned == 0) {
    	    $(this).siblings('.farreaches-instruction').show();
    	} else {
    	    $(this).siblings('.farreaches-instruction').hide();
    	}
    	$('#categories-' + end_point).val(categories);
    });
    
    $(document).on('click.farreaches', '.farreaches-category-add', function(clickEvent) {
        var add_button = $(this);
        var end_point = add_button.data('message-end-point');
        add_button.hide();
        var to_add = $('<div class="farreaches-categories-add">');
        $('#' + end_point + '-cats button.farreaches-category-change').each(function() {
            var button = $(this);
            var b = $('<button class="button farreaches-add" data-category="'+button.data('category') + '">' + button.text() + '</button>');
            b.data('message-end-point', button.data('message-end-point'));
            to_add.append(b);
            to_add.append(' ');
            if (!button.hasClass('farreaches-assigned')) {
                b.toggleClass('farreaches-not-assigned');
            }
        });
        if (to_add.children('.farreaches-not-assigned').length > 0) {
            to_add.prepend('<p>Click on categories to assign.</p>');    
        } else {
            to_add.prepend('<p>All categories assigned.</p>');
        }
        to_add.append('<span class="farreaches-icon-close"></span>');
        $('#'+end_point+'-cats').prepend(to_add);
        //insertAfter(add_button);
        $(to_add).on('click.farreaches', 'button.farreaches-add', function(clickEvent){
            clickEvent.preventDefault();
            var b = $(this);
            $('#'+b.data('message-end-point') + '-' + b.data('category')).click();
            var parent = b.parent();
            if (to_add.children('.farreaches-not-assigned').length == 0) {
                to_add.remove();
            }
        });
        $(to_add).on('click.farreaches', '.farreaches-icon-close', function(){
            to_add.remove();
            add_button.show();
        });
    });
    
    $(document).on('mouseover', '.farreaches-post', function() {
        post_id = $(this).data('post-id');
        $(this).addClass('farreaches-over');
        $(this).addClass('farreaches-post-highlight');
        $('.farreaches-post[data-post-id="'+ post_id +'"]').not('.farreaches-over').each(function() {
            var post = $(this);
            post.parents('.farreaches-accordion').accordion( "option", "active", 0 );
            post.addClass('farreaches-post-highlight');
            var parent_dom = post.parent().get()[0];
            var post_dom = post.get()[0];
            parent_dom.scrollTop = post_dom.offsetTop - parent_dom.offsetTop - 10;
        });
    });
    
    $(document).on('mouseout', '.farreaches-post', function() {
        post_id = $(this).data('post-id');
        $(this).removeClass('farreaches-over');
        $(this).removeClass('farreaches-post-highlight');
        $('.farreaches-post[data-post-id="'+ post_id +'"]').each(function() {
            $(this).removeClass('farreaches-post-highlight');
        });
    });
    
    $(document).ready(function(){
        //Hide assign category buttons if needed.
        $( ".farreaches-accordion" ).each(function() {
            var categoriesOpen = $(this).find('.farreaches-assigned').length == 0;
            $(this).accordion({
                active: categoriesOpen ? 1 : 0,
                heightStyle: "content"}); 
        });
        $('.farreaches-categories').each(function(){
           var total = $(this).children('.farreaches-category-change').length;
           var assigned = $(this).children('.farreaches-assigned').length;
           if (total == assigned) {
               var add_button = $('#' + $(this).data('message-end-point') + '-add');
               add_button.hide();
           }
           if (assigned != 0) {
               // for MEPs with no assigned categories: display the instructions to add categories
               $(this).find('.farreaches-instruction').hide();
           }
        });
        
        //Block ui if plugin failed to load settings.
        if (FARREACHES.config.settings_page_error_occurred){
            $.modal('<h1>Error loading settings</h1><p>Failed to load your social media settings, try again later.</p>');
        }
    });
    
    
    // look for buttons/inputs that have changes.
    $(window).on('beforeunload', function(){
    	unsaved_changes=$('.farreaches-needs-save');
    	if ( unsaved_changes.length !== 0 ) {
    		return "You have unsaved changes.";
    	}
    });
    return self;
}(window.FARREACHES || {}));
