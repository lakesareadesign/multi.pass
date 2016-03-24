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


function ultra_css_element_color($type) {
    global $ultraadmin;
    return ".btn-" . $type . ", .btn-" . $type . ".inverted:hover { background-color: " . $ultraadmin[$type . "-color"] . "; border-color: transparent;}
.btn-" . $type . ":hover, .btn-" . $type . ":focus, .btn-" . $type . ".inverted { border-color: " . $ultraadmin[$type . "-color"] . "; background-color:transparent; color: " . $ultraadmin[$type . "-color"] . ";}
.btn-" . $type . ":hover .fa, .btn-" . $type . ":focus .fa, .btn-" . $type . ".inverted .fa { color: " . $ultraadmin[$type . "-color"] . ";}
.btn-" . $type . ".inverted:hover, .btn-" . $type . ".inverted:hover .fa {color: #ffffff;} 
.alert-" . $type . "{ background-color: " . $ultraadmin[$type . "-color"] . "; color: white;}
.alert-" . $type . " .close .fa{color:white;}
.progress-bar-" . $type . " { background-color: " . $ultraadmin[$type . "-color"] . ";}

";
}

function ultra_css_color($selector, $id, $opacity = "", $valuetype = "") {
    global $ultraadmin;
    if ($valuetype == "string") {
        $value = $id;
    } else {
        $value = $ultraadmin[$id];
        if (is_array($value) && sizeof($value) == 0) {
            return;
        } else if (is_array($value) && sizeof($value) > 0) {
            $value = $ultraadmin[$id]['regular'];
        }
        if ($value == "") {
            return;
        }
    }
    return " ".$selector . "{color:" . ultra_hextorgba($value, $opacity) . " /*".$value."*/;} ";
}

function ultra_css_shadow($selector, $id, $opacity = "", $side, $width, $string = "",$valuetype = "") {
    if ($width == "") {
        $width = "1px";
    }
    
    if ($side == "") {
        $side = "bottom";
    }

//    if ($side == "top") {
//        $side_css = "inset 0 " . $width . " " . $width . " -" . $width . "";
//    }
//    if ($side == "right") {
//        $side_css = "inset -" . $width . " 0 " . $width . " -" . $width . "";
//    }
//    if ($side == "bottom") {
//        $side_css = "inset 0 -" . $width . " " . $width . " -" . $width . "";
//    }
//    if ($side == "left") {
//        $side_css = "inset " . $width . " 0 " . $width . " -" . $width . " ";
//    }

if ($side == "top") {
//        $side_css = "inset 0 " . $width . " " . $width . " -" . $width . "";
        $side_css = "0px ".$width." 0px 0px color inset, 
	0px 0px 0px 0px color inset, 
	0px 0px 0px 0px color inset, 
	0px 0px 0px 0px color inset";
    }
    if ($side == "right") {
//        $side_css = "inset -" . $width . " 0 " . $width . " -" . $width . "";
        $side_css = "0px 0px 0px 0px color inset, 
	0px 0px 0px 0px color inset, 
	0px 0px 0px 0px color inset, 
	-".$width." 0px 0px 0px color inset";
    }
    if ($side == "bottom") {
//        $side_css = "inset 0 -" . $width . " " . $width . " -" . $width . "";
        $side_css = "0px 0px 0px 0px color inset, 
	0px -".$width." 0px 0px color inset, 
	0px 0px 0px 0px color inset, 
	0px 0px 0px 0px color inset";

    }
    if ($side == "left") {
//        $side_css = "inset " . $width . " 0 " . $width . " -" . $width . " ";
        $side_css = "0px 0px 0px 0px color inset, 
	0px 0px 0px 0px color inset, 
	".$width." 0px 0px 0px color inset, 
	0px 0px 0px 0px color inset";
    }
    
    if ($side == "left-right" || $side == "right-left") {
        $side_css = "0px 0px 0px 0px color inset, 
	0px 0px 0px 0px color inset, 
	".$width." 0px 0px 0px color inset, 
	-".$width." 0px 0px 0px color inset";
    }
    
    if ($side == "top-bottom" || $side == "bottom-top") {
        $side_css = "0px ".$width." 0px 0px color inset, 
	0px -".$width." 0px 0px color inset, 
	0px 0px 0px 0px color inset, 
	0px 0px 0px 0px color inset";
    }
    
    if ($side == "all" || $side == "top-right-bottom-left") {
        $side_css = "0px ".$width." 0px 0px color inset, 
	0px -".$width." 0px 0px color inset, 
	".$width." 0px 0px 0px color inset, 
	-".$width." 0px 0px 0px color inset";
    }
    
    
    if($side == "multiple"){
        $side_css = $string;
    }

    global $ultraadmin;
    
    if($string == "string"){
        $value = $id;
    } else if($valuetype == "string"){
        $value = $id;
    } else {
        $value = $ultraadmin[$id];
        if (is_array($value) && sizeof($value) == 0) {
            return;
        } else if (is_array($value) && sizeof($value) > 0) {
            $value = $ultraadmin[$id]['regular'];
        }
    }
    
    if ($value == "") {
        return;
    }
    
    
    /* Relative color code */ 
    /*    * * Darken Color - In box shadow the original color gets lighter ** */
    //    echo $value;
    $hex = $value;
    /*    
    //    echo "0. ".$hex . "[HEX]\n";
    $rgb = HTMLToRGB($hex);
    //    echo "1. ".$rgb . "[HEX to RGB]\n";
    $new_color = ChangeLuminosity($rgb, 63);
    //    echo "2. ".$new_color . "[Dark RGB (rgb-hsl-dark hsl-rgb)]\n";
    $new_hex = RGBToHTML($new_color);
    //    echo "3. ".$new_hex . "[HEX]\n";
    $value = $new_hex;
    //    echo "===========\n";
    */
    
    
//    if($side == "multiple"){
        if($hex != "transparent"){ $color = ultra_hextorgba($hex, $opacity);} else { $color = "transparent";} // same color as separator - no darker version
        $side_css = str_replace("color",$color,$side_css);
        return " ".$selector . "{box-shadow: " . $side_css . " ;\n"
            . "-webkit-box-shadow: " . $side_css . " ;\n"
            . "-o-box-shadow: " . $side_css . " ;\n"
            . "-moz-box-shadow: " . $side_css . " ;\n"
            . "-ms-box-shadow: " . $side_css . " /*".$hex."*/;} \n";
    //}
    //else { // darker version of color code used - NO USE RIGHT NOW
//    return $selector . "{box-shadow: " . $side_css . " " . ultra_hextorgba($value, $opacity) . ";\n"
//            . "-webkit-box-shadow: " . $side_css . " " . ultra_hextorgba($value, $opacity) . ";\n"
//            . "-o-box-shadow: " . $side_css . " " . ultra_hextorgba($value, $opacity) . ";\n"
//            . "-moz-box-shadow: " . $side_css . " " . ultra_hextorgba($value, $opacity) . ";\n"
//            . "-ms-box-shadow: " . $side_css . " " . ultra_hextorgba($value, $opacity) . ";}\n";
   // }    
}

function ultra_link_color($selector, $id, $opacity = "", $type = "", $valuetype = "") {
    global $ultraadmin;
    if($valuetype == "array"){
        $value = $id;
    } else {
        $value = $ultraadmin[$id];
    }

    if (sizeof($value) == 0) {
        return;
    }
    
    $selector_visited = $selector_hover = $selector_active = "";
    $exp = explode(",", $selector);
    foreach ($exp as $single) {
        $selector_visited .= trim($single) . ":visited, ";
        $selector_hover .= trim($single) . ":hover, ";
        $selector_active .= trim($single) . ":active, ";
    }

    $selector_visited = substr($selector_visited, 0, -2);
    $selector_hover = substr($selector_hover, 0, -2);
    $selector_active = substr($selector_active, 0, -2);

    $regular = (isset($value['regular']) && $value['regular'] != "") ? $value['regular'] : $ultraadmin['primary-color'];
    $hover = (isset($value['hover']) && $value['hover'] != "") ? $value['hover'] : $regular;
    $active = (isset($value['active']) && $value['active'] != "") ? $value['active'] : $hover;
    $visited = (isset($value['visited']) && $value['visited'] != "") ? $value['visited'] : $regular;

    if (isset($type) && $type == "hover") {
        return $selector . "{color:" . ultra_hextorgba($value['hover'], $opacity) . " /*".$value['hover']."*/;} ";
    } else {
        return $selector . "{color:" . ultra_hextorgba($regular, $opacity) ." /*".$regular."*/;} " .
//                $selector_visited . " {color:" . ultra_hextorgba($visited, $opacity) . ";} " .
                $selector_hover . " {color:" . ultra_hextorgba($hover, $opacity) ." /*".$hover."*/;} " .
                $selector_active . " {color:" . ultra_hextorgba($active, $opacity) ." /*".$active."*/;} \n";
    }
}

function ultra_css_bgcolor($selector, $id, $opacity = "", $valuetype = "") {
    global $ultraadmin;
    if ($valuetype == "string") {
        $value = $id;
    } else if($valuetype == "luminosity"){
        $value = $ultraadmin[$id];
        $hex = $value;  /*HEX*/
        $rgb = ultra_HTMLToRGB($hex); /*HEX to RGB*/
        $new_color = ultra_ChangeLuminosity($rgb, $opacity); /*rgb-hsl-new hsl-rgb*/
        $new_hex = ultra_RGBToHTML($new_color); /*HEX*/
        $value = $new_hex;
    }else {
        $value = $ultraadmin[$id];
        if (is_array($value) && sizeof($value) == 0) {
            return;
        } else if (is_array($value) && sizeof($value) > 0) {
            $value = $ultraadmin[$id]['regular'];
        }
        if ($value == "") {
            return;
        }
    }
    $color = "";
    if($value == "transparent"){ $color = "transparent"; } 
    else if(strpos($value,"rgba") !== false){ $color = $value;}
    else {$color = ultra_hextorgba($value, $opacity);}
    return " ".$selector . "{background-color:" . $color ." /*".$value."*/;} ";
}

function ultra_css_border_color($selector, $id, $opacity = "", $bordertype, $valuetype = "") {
    global $ultraadmin;
    
    if ($valuetype == "string") {
        $value = $id;
    } else {
        $value = $ultraadmin[$id];
        if (is_array($value) && sizeof($value) == 0) {
            return;
        } else if (is_array($value) && sizeof($value) > 0) {
            if (isset($ultraadmin[$id]['regular'])) {
                $value = $ultraadmin[$id]['regular'];
            }
        }
    }
    if ($value == "") {
        return;
    }
    
    
    if ($bordertype == "all") {
        $css_property = "border-color";
    } else if ($bordertype == "top") {
        $css_property = "border-top-color";
    } else if ($bordertype == "right") {
        $css_property = "border-right-color";
    } else if ($bordertype == "bottom") {
        $css_property = "border-bottom-color";
    } else if ($bordertype == "left") {
        $css_property = "border-left-color";
    }
    
    $color = "";
    if($value != "transparent"){ $color = ultra_hextorgba($value, $opacity);} else { $color = "transparent";}
    
    return " ".$selector . "{" . $css_property . ":" . $color ." /*".$value."*/;}\n ";
}

function ultra_css_background($selector, $id, $opacity = "",$type = "") {
    global $ultraadmin;
    if($type == "array"){
        $value = $id;
    } else {
        $value = $ultraadmin[$id];
    }

    if(!isset($value['background-image'])){$value['background-image'] = "";}
    if(!isset($value['background-repeat'])){$value['background-repeat'] = "";}
    if(!isset($value['background-color'])){$value['background-color'] = "";}
    if(!isset($value['background-size'])){$value['background-size'] = "";}
    if(!isset($value['background-attachment'])){$value['background-attachment'] = "";}
    if(!isset($value['background-position'])){$value['background-position'] = "";}


    $bg_image = "";
    $ultraadminID = $value['background-image'];
    if (isset($ultraadminID) && trim($ultraadminID) != "") {
        $bg_image = "background-image:url(" . $ultraadminID . "); ";
    }

    $bg_color = "";
    $ultraadminID = $value['background-color'];
    $colorcode = ultra_colorcode($ultraadminID,$opacity);
    $bg_color = "background-color: ".$colorcode.";";
    
    $bg_repeat = "";
    $ultraadminID = $value['background-repeat'];
    if (isset($ultraadminID) && trim($ultraadminID) != "") {
        $bg_repeat = "background-repeat:" . $ultraadminID . "; ";
    }

    $bg_size = "";
    $ultraadminID = $value['background-size'];
    if (isset($ultraadminID) && trim($ultraadminID) != "") {
        $bg_size = "-webkit-background-size:" . $ultraadminID . "; "
                . "-moz-background-size:" . $ultraadminID . "; "
                . "-o-background-size:" . $ultraadminID . "; "
                . "background-size:" . $ultraadminID . "; ";
    }

    $bg_attach = "";
    $ultraadminID = $value['background-attachment'];
    if (isset($ultraadminID) && trim($ultraadminID) != "") {
        $bg_attach = "background-attachment:" . $ultraadminID . "; ";
    }

    $bg_pos = "";
    $ultraadminID = $value['background-position'];
    if (isset($ultraadminID) && trim($ultraadminID) != "") {
        $bg_pos = "background-position:" . $ultraadminID . "; ";
    }


    return " ".$selector . "{" . $bg_color . $bg_image . $bg_pos . $bg_attach . $bg_size . $bg_repeat . "} ";
}

function ultra_hextorgba($value, $opacity) {
    if ($opacity == "" || !isset($opacity)) {
        $opacity = 1;
    }
    $rgb = ultra_hex2rgb($value);
    return "rgba(" . $rgb[0] . "," . $rgb[1] . "," . $rgb[2] . ",$opacity)";
}






function ultra_colorcode($color,$opacity = "",$addstr = ""){
        $ret = $color;
        $code = "";
        if($opacity == ""){$opacity = "1.0";}
        global $ultraadmin;
        //$ultraadmin = ultra_color();
        
        if (isset($color) &&  trim($color) != "" &&  trim($color) != "#") {
        if ($color == "transparent") {
            $ret = "transparent".$addstr;
        } else if ($color == "primary") {
            $ret = $ultraadmin['primary-color'].$addstr;
        } else if ($color == "primary2") {
            $ret = $ultraadmin['primary2-color'].$addstr;
        } else if ($color == "secondary") {
            $ret = $ultraadmin['secondary-color'].$addstr;
        } else if(strpos($color,"rgb") !== false){
            $ret = $color.$addstr;
        } else if(strpos($color,"/") !== false){
            $colorexp = explode("/",$color);
            if(trim($colorexp[0]) == "primary"){ $code = $ultraadmin['primary-color'];}
            else if(trim($colorexp[0]) == "primary2"){ $code = $ultraadmin['primary2-color'];}
            else if(trim($colorexp[0]) == "secondary"){ $code = $ultraadmin['secondary-color'];}
            else {$code = trim($colorexp[0]);}
            if(trim($colorexp[1]) != ""){$opacity = trim($colorexp[1]);}
            $ret = ultra_hextorgba($code, $opacity).$addstr ." /*".$code."*/; ";
        } else {
            $ret = ultra_hextorgba($color, $opacity).$addstr ." /*".$color."*/; ";
//            $ret = $color ." /*".$color."*/; ";
        }
    }
    
return $ret;
    
}


?>