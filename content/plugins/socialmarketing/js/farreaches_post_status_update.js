// This file contains functionality that updates posts statuses on each event bus sync
// Used on the post edit page.
window.FARREACHES = (function(self) {

    function getLocation(href) {
        var a = document.createElement("a");
        a.href = href;
        return a;
    }
    
    function extractText(text){
        var dummyNode = document.createElement('div'), resultText = '';
        dummyNode.innerHTML = text;
        resultText = dummyNode.innerText || dummyNode.textContent;
        return resultText;
    };

    self.process_preview_data_twitter = function(data) {
        data.post_text = extractText(data.post_text).substring(0, 118);
        data.post_url = data.post_url.substring(0, 33).replace(/.*?:\/\//g, '') + '...';
    };

    self.process_preview_data_facebook = function(data) {
        data.post_text = extractText(data.post_text).substring(0, 400);
        data.post_url_title = getLocation(data.post_url).hostname;
    };
    return self;

}(window.FARREACHES || {}));



jQuery(function($) {
    // Subscribe to the special internal event emitted by event bus bridge before each sync.
    FARREACHES.EventBus.subscribe('eventbus://sync/before', function() {
    	var selector = 'div[data-post-id]';
        // Collect all post ids available on the page.
        var post_ids = $(selector).map(function() {
            return $(this).data('post-id');
        }).get();
        
        var is_post_list_page = $('table.posts').length == 0? false: true;
        var topic = is_post_list_page? 'farreaches://post-list/status': 'farreaches://post/status';

        // eventBus.enqueue() used instead of publish() to avoid infinite recursion as we are already in the delivery loop
        FARREACHES.EventBus.enqueue(topic, post_ids, function(posts_statuses) {
            // HACK - needed because posts_statuses is : { call_status: "success", 168: <post 168's status> }
            // we need to separate returned data from call_status
            delete posts_statuses['call_status'];
            for (var post_id in posts_statuses) {
            	var post_data = posts_statuses[post_id];
            	if (is_post_list_page) {
            	    post_data['enable_abort'] = false;
            	    post_data['enable_publish_now'] = false;
            	}
            	var post_status_area = $('div[data-post-id=' + post_id + ']');
            	// Render updated post status by re-using 'post_status' jsrender template
                $.link['post_status'](post_status_area, post_data);
            }
        });
    });

    
    if($('#post_automatic_publishing').is(':checked')){
        $('.farreaches_destinations').show();
    } else {
        $('.farreaches_destinations').hide();
    }
    
    $('#post_automatic_publishing').live('change', function(){
        if($(this).is(':checked')){
            $('.farreaches_destinations').show();
        } else {
            $('.farreaches_destinations').hide();
        }
    });
    
    $('#fr-preview-header').click(function(){
        var preview_dialog = $('#fr-preview-dialog');
        preview_dialog.modal({
            overlayClose:true,
            closeHTML:'x',
            minWidth:'458px',
            maxWidth:'458px',
            minHeight:'280px',
            maxHeight:'280px'
        });
    });
    
    $('img.preview-icon').click(function() {
        var service_alias = $(this).data('service-alias');
        var preview_data = {
            post_title:$('#title').val(),
            post_url:$('#sample-permalink').text(),
            post_text:get_post_content()
        };

        preview_data = $.extend(preview_data, FARREACHES.config[service_alias] || {});

        var function_name = 'process_preview_data_' + service_alias;
        if (typeof FARREACHES[function_name] == 'function') {
            FARREACHES[function_name](preview_data);
        }

        var preview_content = $('#fr-preview-content');
        preview_content.html($('#farreaches-tmpl-post_preview_' + service_alias).render(preview_data));
    });

    function get_post_content() {
        if (jQuery("#wp-content-wrap").hasClass("tmce-active")) {
            return switchEditors._wp_Nop(tinyMCE.activeEditor.getContent());
        } else {
            return jQuery('textarea#content').val();
        }
    }
    
    $('.farreaches-meta-box-section').mouseenter(function(){
        $('.farreaches-meta-box-section').toggleClass('fr-highlight');
        $('#farreaches_publishing .inside').toggleClass('fr-highlight');
    }).mouseleave(function(){
        $('.farreaches-meta-box-section').toggleClass('fr-highlight');
        $('#farreaches_publishing .inside').toggleClass('fr-highlight');
    });
    
});
