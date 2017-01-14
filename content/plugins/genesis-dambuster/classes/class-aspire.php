<?php
class Genesis_Dambuster_Aspire extends Genesis_Dambuster_Template {

    function remove_post_image() {
         remove_action( 'genesis_entry_header', 'aspire_featured_photo', 5 );		
         parent::remove_post_image();
    }

}
