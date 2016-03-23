<?php
/**
 * @Package: WordPress Plugin
 * @Subpackage: Ultra WordPress Admin Theme
 * @Since: Ultra 1.0
 * @WordPress Version: 4.0 or above
 * This file is part of Ultra WordPress Admin Theme Plugin.
 */
?>
<?php

function ultra_logo($rettype = ""){
    global $ultraadmin;
       $ultraadmin = ultraadmin_network($ultraadmin);       

    $csstype = ultra_dynamic_css_type();


    $str = "";
    if(isset($ultraadmin['enable-logo']) && $ultraadmin['enable-logo'] != "1" && $ultraadmin['enable-logo'] == "0" && !$ultraadmin['enable-logo']){

        // hide logo
        if($rettype != "1"){$str .= "<style type='text/css' data-display='hide' id='ultra-admin-logo-hide'>";}
        $str .= "#adminmenuwrap .logo-overlay{display:none !important;} #adminmenuwrap:before, .folded #adminmenuwrap:before{display: none !important;} .auto-fold #adminmenuwrap:before{display: none !important;}  #adminmenu{margin-top:0px !important;}"; 
        if($rettype != "1"){$str .= "</style>";}

    } else {

        // show logo
        $logo = $logo_folded = "";

        //echo $csstype;
        if($csstype != "custom"){
                global $ultra_color;

                $logo = str_replace("PLUGINURL",plugins_url('/', __FILE__).'..',$ultra_color[$csstype]['logo']['url']);
                $logo_folded = str_replace("PLUGINURL",plugins_url('/', __FILE__).'..',$ultra_color[$csstype]['logo_folded']['url']);
        }

        if($logo == ""){if(isset($ultraadmin['logo']['url'])){ $logo = trim($ultraadmin['logo']['url']); }}
        if($logo_folded == ""){if(isset($ultraadmin['logo_folded']['url'])){ $logo_folded = trim($ultraadmin['logo_folded']['url']); }}
        
        if($rettype != "1"){$str .= "<style type='text/css' data-display='show' data-csstype='".$csstype."' id='ultra-admin-logo-show'>";}
        $str .= "#adminmenuwrap:before{background-image: url('".$logo."');} 
        .folded #adminmenuwrap:before{background-image: url('".$logo_folded."');} 
        .auto-fold #adminmenuwrap:before{background-image: url('".$logo_folded."');} 
        .menu-expanded #adminmenuwrap:before{background-image: url('".$logo."') !important;} 
        .menu-collapsed #adminmenuwrap:before{background-image: url('".$logo_folded."') !important;}";
        if($rettype != "1"){$str .= "</style>";}
    }

    if($rettype != "1"){ echo $str;} else { return $str; }
}


function ultra_favicon(){
?>

<?php global $ultraadmin; 

       $ultraadmin = ultraadmin_network($ultraadmin);       

?>

<?php if ($ultraadmin['favicon']['url']): ?>
    <link rel="shortcut icon" href="<?php echo $ultraadmin['favicon']['url']; ?>" type="image/x-icon" />
<?php endif; ?>

<?php if ($ultraadmin['iphone_icon']['url']): ?>
    <!-- For iPhone -->
    <link rel="apple-touch-icon-precomposed" href="<?php echo $ultraadmin['iphone_icon']['url']; ?>">
<?php endif; ?>

<?php if ($ultraadmin['iphone_icon_retina']['url']): ?>
    <!-- For iPhone 4 Retina display -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $ultraadmin['iphone_icon_retina']['url']; ?>">
<?php endif; ?>

<?php if ($ultraadmin['ipad_icon']['url']): ?>
    <!-- For iPad -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $ultraadmin['ipad_icon']['url']; ?>">
<?php endif; ?>

<?php if ($ultraadmin['ipad_icon_retina']['url']): ?>
    <!-- For iPad Retina display -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $ultraadmin['ipad_icon_retina']['url']; ?>">
<?php endif; ?>
<?php
}


function ultra_logo_url(){

    global $ultraadmin;
       $ultraadmin = ultraadmin_network($ultraadmin);       

    $logourl = "";
    if(isset($ultraadmin['logo-url']) && trim($ultraadmin['logo-url']) != ""){
        $logourl = $ultraadmin['logo-url'];
        echo "<style type='text/css' id='ultra-logo-url'> #adminmenuwrap .logo-overlay { cursor:hand;cursor:pointer; }</style>";
    }

    echo "<meta type='info' id='ultra-logourl' data-value='".$logourl."'>";
}
?>