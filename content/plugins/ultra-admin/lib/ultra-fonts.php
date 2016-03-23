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

function ultra_css_fonts() {

    global $ultraadmin;

    $bodyfont = "'Open Sans', Arial, Helvetica, sans-serif";
    $menufont = "Oswald, Arial, Helvetica, sans-serif ";
    $buttonfont = "Oswald, Arial, Helvetica, sans-serif ";
    $headingfont = "Oswald,  Arial, Helvetica, sans-serif";

    $body_letter_spacing = $body_word_spacing = "";
    $heading_letter_spacing = $heading_word_spacing = "";
    $menu_letter_spacing = $menu_word_spacing = "";
    $button_letter_spacing = $button_word_spacing = "";

    $body_font_weight = "font-weight:400; ";
    $menu_font_weight = "font-weight:300; ";
    $button_font_weight = "font-weight:300; ";
    $heading_font_weight = "font-weight:300; ";

    $body_font_style = "font-style:normal; ";
    $menu_font_style = "font-style:normal; ";
    $button_font_style = "font-style:normal; ";
    $heading_font_style = "font-style:normal; ";


    $body_font_size = "font-size:15px; ";
    $body_line_height = "line-height:23px; ";

    $menu_font_size = "font-size:15px; ";
    $menu_line_height = "line-height:46px; ";

    $button_font_size = "font-size:15px; ";
    $button_line_height = "line-height:23px; ";


    if (isset($ultraadmin['google_body']) && sizeof($ultraadmin['google_body']) && trim($ultraadmin['google_body']['font-family']) != "") {
        $bodyfont = "'".$ultraadmin['google_body']['font-family']."'";

        if (isset($ultraadmin['google_body']['font-backup'])) {
            $bodyfont .= ", " . $ultraadmin['google_body']['font-backup'];
        } else {
            $bodyfont .= ", sans-serif";
        }
        if (isset($ultraadmin['google_body']['letter-spacing']) && trim(($ultraadmin['google_body']['letter-spacing']) != "")) {
            $body_letter_spacing = "letter-spacing:" . $ultraadmin['google_body']['letter-spacing'] . "; ";
        }
        if (isset($ultraadmin['google_body']['word-spacing']) && trim(($ultraadmin['google_body']['word-spacing']) != "")) {
            $body_word_spacing = "word-spacing:" . $ultraadmin['google_body']['word-spacing'] . "; ";
        }
        if (isset($ultraadmin['google_body']['font-weight']) && trim(($ultraadmin['google_body']['font-weight']) != "")) {
            $body_font_weight = "font-weight:" . $ultraadmin['google_body']['font-weight'] . "; ";
        }
        if (isset($ultraadmin['google_body']['font-style']) && trim(($ultraadmin['google_body']['font-style']) != "")) {
            $body_font_style = "font-style:" . $ultraadmin['google_body']['font-style'] . "; ";
        }
        if (isset($ultraadmin['google_body']['font-size']) && trim(($ultraadmin['google_body']['font-size']) != "")) {
            $body_font_size = "font-size:" . $ultraadmin['google_body']['font-size'] . "; ";
        }
        if (isset($ultraadmin['google_body']['line-height']) && trim(($ultraadmin['google_body']['line-height']) != "")) {
            $body_line_height = "line-height:" . $ultraadmin['google_body']['line-height'] . "; ";
        }
    }




    if (isset($ultraadmin['google_nav']) && sizeof($ultraadmin['google_nav']) && trim($ultraadmin['google_nav']['font-family']) != "") {
        $menufont = "'".$ultraadmin['google_nav']['font-family']."'";

        if (isset($ultraadmin['google_nav']['font-backup'])) {
            $menufont .= ", " . $ultraadmin['google_nav']['font-backup'];
        } else {
            $menufont .= ", sans-serif";
        }
        if (isset($ultraadmin['google_nav']['letter-spacing']) && trim(($ultraadmin['google_nav']['letter-spacing']) != "")) {
            $menu_letter_spacing = "letter-spacing:" . $ultraadmin['google_nav']['letter-spacing'] . "; ";
        }
        if (isset($ultraadmin['google_nav']['word-spacing']) && trim(($ultraadmin['google_nav']['word-spacing']) != "")) {
            $menu_word_spacing = "word-spacing:" . $ultraadmin['google_nav']['word-spacing'] . "; ";
        }
        if (isset($ultraadmin['google_nav']['font-weight']) && trim(($ultraadmin['google_nav']['font-weight']) != "")) {
            $menu_font_weight = "font-weight:" . $ultraadmin['google_nav']['font-weight'] . "; ";
        }
        if (isset($ultraadmin['google_nav']['font-style']) && trim(($ultraadmin['google_nav']['font-style']) != "")) {
            $menu_font_style = "font-style:" . $ultraadmin['google_nav']['font-style'] . "; ";
        }
        if (isset($ultraadmin['google_nav']['font-size']) && trim(($ultraadmin['google_nav']['font-size']) != "")) {
            $menu_font_size = "font-size:" . $ultraadmin['google_nav']['font-size'] . "; ";
        }
        if (isset($ultraadmin['google_nav']['line-height']) && trim(($ultraadmin['google_nav']['line-height']) != "")) {
            $menu_line_height = "line-height:" . $ultraadmin['google_nav']['line-height'] . "; ";
        }
    }




    if (isset($ultraadmin['google_button']) && sizeof($ultraadmin['google_button']) && trim($ultraadmin['google_button']['font-family']) != "") {
        $buttonfont = "'".$ultraadmin['google_button']['font-family']."'";

        if (isset($ultraadmin['google_button']['font-backup'])) {
            $buttonfont .= ", " . $ultraadmin['google_button']['font-backup'];
        } else {
            $buttonfont .= ", sans-serif";
        }
        if (isset($ultraadmin['google_button']['letter-spacing']) && trim(($ultraadmin['google_button']['letter-spacing']) != "")) {
            $button_letter_spacing = "letter-spacing:" . $ultraadmin['google_button']['letter-spacing'] . "; ";
        }
        if (isset($ultraadmin['google_button']['word-spacing']) && trim(($ultraadmin['google_button']['word-spacing']) != "")) {
            $button_word_spacing = "word-spacing:" . $ultraadmin['google_button']['word-spacing'] . "; ";
        }
        if (isset($ultraadmin['google_button']['font-weight']) && trim(($ultraadmin['google_button']['font-weight']) != "")) {
            $button_font_weight = "font-weight:" . $ultraadmin['google_button']['font-weight'] . "; ";
        }
        if (isset($ultraadmin['google_button']['font-style']) && trim(($ultraadmin['google_button']['font-style']) != "")) {
            $button_font_style = "font-style:" . $ultraadmin['google_button']['font-style'] . "; ";
        }
        if (isset($ultraadmin['google_button']['font-size']) && trim(($ultraadmin['google_button']['font-size']) != "")) {
            $button_font_size = "font-size:" . $ultraadmin['google_button']['font-size'] . "; ";
        }
        if (isset($ultraadmin['google_button']['line-height']) && trim(($ultraadmin['google_button']['line-height']) != "")) {
            $button_line_height = "line-height:" . $ultraadmin['google_button']['line-height'] . "; ";
        }
    }




    if (isset($ultraadmin['google_headings']) && sizeof($ultraadmin['google_headings']) && trim($ultraadmin['google_headings']['font-family']) != "") {
        $headingfont = "'".$ultraadmin['google_headings']['font-family']."'";

        if (isset($ultraadmin['google_headings']['font-backup'])) {
            $headingfont .= ", " . $ultraadmin['google_headings']['font-backup'];
        } else {
            $headingfont .= ", sans-serif";
        }
        if (isset($ultraadmin['google_headings']['letter-spacing']) && trim(($ultraadmin['google_headings']['letter-spacing']) != "")) {
            $heading_letter_spacing = "letter-spacing:" . $ultraadmin['google_headings']['letter-spacing'] . "; ";
        }
        if (isset($ultraadmin['google_headings']['word-spacing']) && trim(($ultraadmin['google_headings']['word-spacing']) != "")) {
            $heading_word_spacing = "word-spacing:" . $ultraadmin['google_headings']['word-spacing'] . "; ";
        }
        if (isset($ultraadmin['google_headings']['font-weight']) && trim(($ultraadmin['google_headings']['font-weight']) != "")) {
            $heading_font_weight = "font-weight:" . $ultraadmin['google_headings']['font-weight'] . "; ";
        }
        if (isset($ultraadmin['google_headings']['font-style']) && trim(($ultraadmin['google_headings']['font-style']) != "")) {
            $headings_font_style = "font-style:" . $ultraadmin['google_headings']['font-style'] . "; ";
        }
    }


//    else if(isset($ultraadmin['standard_body']) && trim($ultraadmin['standard_body']) != ""){ $bodyfont = "".$ultraadmin['standard_body']."";}
//    if(isset($ultraadmin['google_nav']) && trim($ultraadmin['google_nav']) != ""){ $menufont = "'".$ultraadmin['google_nav']."', sans-serif"; }
//    else if(isset($ultraadmin['standard_nav']) && trim($ultraadmin['standard_nav']) != ""){ $menufont = "".$ultraadmin['standard_nav']."";}
//    if(isset($ultraadmin['google_headings']) && trim($ultraadmin['google_headings']) != ""){ $headingfont = "'".$ultraadmin['google_headings']."', sans-serif"; }
//    else if(isset($ultraadmin['standard_headings']) && trim($ultraadmin['standard_headings']) != ""){ $headingfont = "".$ultraadmin['standard_headings']."";}


$ret = array();
$ret['body_font_css'] = "font-family: " . $bodyfont . ";" . $body_letter_spacing . " " . $body_word_spacing . " " . $body_font_weight . " " . $body_font_size . " " . $body_line_height . " ".$body_font_style;
$ret['head_font_css'] = "font-family: " . $headingfont . ";" . $heading_letter_spacing . " " . $heading_word_spacing . " " . $heading_font_weight . " ".$heading_font_style;
$ret['menu_font_css'] = " font-family: " . $menufont . ";" . $menu_letter_spacing . " " . $menu_word_spacing . " " . $menu_font_weight . " " . $menu_font_size . " " . $menu_line_height . " ".$menu_font_style;
$ret['button_font_css'] = " font-family: " . $buttonfont . ";" . $button_letter_spacing . " " . $button_word_spacing . " " . $button_font_weight . " " . $button_font_size . " " . $button_line_height . " ".$button_font_style;



return $ret;
}


function ultra_fonts() {
    global $ultraadmin;
    $gfont = array();

    if (isset($ultraadmin['google_body']) && sizeof($ultraadmin['google_body']) && trim($ultraadmin['google_body']['font-family']) != "") {
        $font = $ultraadmin['google_body']['font-family'];
        $font = str_replace(", " . $ultraadmin['google_body']['font-backup'], "", $font);
        $gfont[urlencode($font)] = '"' . urlencode($font) . ':400,300,300italic,400italic,600,600italic,700,700italic:latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese"';
    }

    if (isset($ultraadmin['google_nav']) && sizeof($ultraadmin['google_nav']) && trim($ultraadmin['google_nav']['font-family']) != "" 
        && $ultraadmin['google_nav']['font-family'] != $ultraadmin['google_body']['font-family']) {
        $font = $ultraadmin['google_nav']['font-family'];
        $font = str_replace(", " . $ultraadmin['google_nav']['font-backup'], "", $font);
        $gfont[urlencode($font)] = '"' . urlencode($font) . ':400,300,300italic,400italic,600,600italic,700,700italic:latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese"';
    }

    if (isset($ultraadmin['google_headings']) && sizeof($ultraadmin['google_headings']) && trim($ultraadmin['google_headings']['font-family']) != "" 
        && $ultraadmin['google_headings']['font-family'] != $ultraadmin['google_body']['font-family'] 
        && $ultraadmin['google_headings']['font-family'] != $ultraadmin['google_nav']['font-family']) {
        $font = $ultraadmin['google_headings']['font-family'];
        $font = str_replace(", " . $ultraadmin['google_headings']['font-backup'], "", $font);
        $gfont[urlencode($font)] = '"' . urlencode($font) . ':400,300,300italic,400italic,600,600italic,700,700italic:latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese"';
    }

    if (isset($ultraadmin['google_button']) && sizeof($ultraadmin['google_button']) && trim($ultraadmin['google_button']['font-family']) != "" 
        && $ultraadmin['google_button']['font-family'] != $ultraadmin['google_body']['font-family'] 
        && $ultraadmin['google_button']['font-family'] != $ultraadmin['google_headings']['font-family'] 
        && $ultraadmin['google_button']['font-family'] != $ultraadmin['google_nav']['font-family']) {
        $font = $ultraadmin['google_button']['font-family'];
        $font = str_replace(", " . $ultraadmin['google_button']['font-backup'], "", $font);
        $gfont[urlencode($font)] = '"' . urlencode($font) . ':400,300,300italic,400italic,600,600italic,700,700italic:latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese"';
    }

    $gfonts = "";
    if ($gfont) {
        if (is_array($gfont) && !empty($gfont)) {
            $gfonts = implode($gfont, ', ');
        }
    }
    ?>

    <!-- Fonts - Start -->        
    <script type="text/javascript">
        WebFontConfig = {
    <?php if (!empty($gfonts)): ?>google: {families: [<?php echo $gfonts; ?>]},<?php endif; ?>
            custom: {}
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                    '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>
    <!-- Fonts - End -->        

    <?php
}
?>