(function ($, doc){
    "use strict";
    if( pagenow !== 'hustle_page_inc_hustle_settings' ) return;

    var E_News = Hustle.get("Settings.E_News"),
        Modules_Activity = Hustle.get("Settings.Modules_Activity"),
        Services = Hustle.get("Settings.Services");

    new E_News;
    new Modules_Activity;
    new Services;
}(jQuery, document));