function genesis_dambuster_news_ajax(url) {
	var data = { action: genesis_dambuster_news.ajaxaction, security: genesis_dambuster_news.ajaxnonce, url: url };     
	jQuery.post( genesis_dambuster_news.ajaxurl, data, function( response ) {
   	var ele = jQuery(genesis_dambuster_news.ajaxresults);
	if( response.success ) 
      	ele.append( response.data );
/*      else if ( response.data.error )
      	ele.append( response.data.error );
*/
   });
}    

jQuery(document).ready(function($) {
	if (typeof genesis_dambuster_news0 != 'undefined') genesis_dambuster_news_ajax(genesis_dambuster_news0.feedurl );
	if (typeof genesis_dambuster_news1 != 'undefined') genesis_dambuster_news_ajax(genesis_dambuster_news1.feedurl );   
	if (typeof genesis_dambuster_news2 != 'undefined') genesis_dambuster_news_ajax(genesis_dambuster_news2.feedurl );
});