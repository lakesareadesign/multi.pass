Hustle.define("Optin.Module", function() {
    "use strict";

    if( 'hustle_page_inc_optin_listing' === pagenow ){
        var Listing = Hustle.get("Optin.Listing");
        new Listing();
    }


});