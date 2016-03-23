/**
 * Adds the category service icons to the right side of the categories.
 * Added this way because the ways to add it in php/wordpress are not clean with hooks/filters.
 */
jQuery(function($) {
	var prefixes = ["category-", "popular-category-"];
	$.each(FARREACHES.config.post_edit_categories_data.categories, function (idx, cat){		
		if (cat.icon_data){			
			for(var i = 0; i < prefixes.length; i++ ) {
				var span = $('<span class="farreaches-category-icons"></span>');
				$.each(cat.icon_data, function (idx, icon_data){
					var a = $('<a><img/></a>');
					a.attr('href', icon_data.public_uri);
					a.attr('target', '_blank');
					a.attr('title', icon_data.public_uri_anchor_text);
					a.find('img').attr('src', icon_data.service_icon_url);					
					a.appendTo(span);
				});
				var target = $('#'+ prefixes[i] + cat.id + '>label');
				span.insertAfter(target);
				var checkbox = $('#in-' + prefixes[i] + cat.id);
				checkbox.data('icon', cat.icon_data);
			}
		}
	});
	
	
	var refresh_selected_services = function() {
	    var selected_services = [];
	    var categories_checked = false;
	    $('#taxonomy-category .tabs-panel:visible input:checkbox').each(function(){
	        if($(this).is(':checked')){
	            categories_checked = true;
	            var icon_data = $(this).data('icon');
	            for (var i in icon_data) {
	                var icon = icon_data[i].service_icon_url;
	                if (selected_services.indexOf(icon) < 0) {
	                    selected_services.push(icon);
	                }
	            }
	        }
	    });
	    
	    if (!categories_checked) {
	        var default_category = FARREACHES.config.post_edit_categories_data.default_category;
	        if (default_category.icon_data) {
	            $.each(default_category.icon_data, function (idx, icon_data){
	                selected_services.push(icon_data.service_icon_url); 
	            });
	        }
	    }
	    
	    var destinations = $('.farreaches_destinations');
	    destinations.empty();
	    if (selected_services.length > 0) {
	        var html = 'Selected destinations: ';
	        for (var s in selected_services) {
	            html += '<img src="' + selected_services[s] + '"/> ';
	        }
	        destinations.html(html);
	    } else {
	        destinations.html('Choose connected categories to publish your post to social media.');
	    }
	};
	
	$('#taxonomy-category input:checkbox').on('change', function(){
	    refresh_selected_services();
	});
	refresh_selected_services();
});
