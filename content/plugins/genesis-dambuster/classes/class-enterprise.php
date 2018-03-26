<?php
class Genesis_Dambuster_Enterprise extends Genesis_Dambuster_Template {

	function inline_specific_styles() { //override offsetting negative margins and paddings and hence fix scrollbar issue
       return '.gd-full-width .entry-header { margin:0; padding:0; border-bottom: none;}';
    }
       
}