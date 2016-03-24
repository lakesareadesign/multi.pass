/**
 * @Package: WordPress Plugin
 * @Subpackage: Ultra WordPress Admin Theme
 * @Since: Ultra 1.0
 * @WordPress Version: 4.0 or above
 * This file is part of Ultra WordPress Admin Theme Plugin.
 */


/*----------------------------------
    Page loader
-----------------------------------*/

(function($) {
    Pace.on('start', function(){
	  //$(".pace-progress-inner").html("Loading...");
      //$(".pace").append('<div class="contain"><div class="item"></div><div class="item"></div><div class="item"></div><div class="item"></div><div class="item"></div><div class="item"></div><div class="item"></div><div class="item"></div><div class="item"></div><div class="item"></div><div class="item"></div><div class="item"></div><div class="item"></div><div class="item"></div><div class="item"></div><div class="item"></div></div>');
      //console.log("pace started");
    });
    Pace.on('hide', function(){
    	$("#wpwrap").addClass("loaded");
      //$("#wrapper").removeClass("loading");
      //console.log("pace ended");
    });
 })(jQuery);
 
