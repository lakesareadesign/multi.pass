jQuery(document).ready ( function() {
  if(jQuery('.genesis-dambuster-metabox').length > 0) {
		jQuery('.genesis-dambuster-metabox li.tab a').each(function(i) {
			var thisMetabox =  jQuery(this).closest('.genesis-dambuster-metabox');
         	var tabs = thisMetabox.find('.metabox-tabs'); 	
         	var content = thisMetabox.find('.metabox-content'); 			
			var thisTab = jQuery(this).parent().attr('class').replace(/tab /, '');
			var selectedTab = thisMetabox.find('.tabselect');
			if ( thisTab == selectedTab.val() ) {
				jQuery(this).addClass('active');
            	content.children('div.'+thisTab).addClass('active');        	
			} else {
	       		content.children('div.' + thisTab).hide();
			}
         	jQuery(this).click(function(ev){
				ev.preventDefault();
         		content.children('div').hide();
				content.children('div.active').removeClass('active');
				tabs.find('li a.active').removeClass('active');
 	       		selectedTab.val(thisTab);
				tabs.find('li.'+thisTab+' a').addClass('active');
				content.children('div.'+thisTab).addClass('active').show();
				if (jQuery('#poststuff').length == 0) {
					boxes = jQuery('.postbox, .termbox');
					jQuery.post(ajaxurl, {
						action: 'genesis_dambuster_tab',
						box: tabs.closest(boxes).attr('id'),
						tabselect: thisTab,
						tabnonce: jQuery('#genesisdambustertabnonce').val()
					});
				}
				return false;
			});
	   		tabs.show();
		});
  }
});