<?php
//require('../../../../wp-load.php');
//require('../../../../wp-blog-header.php');

$scriptPath = dirname(__FILE__);
$path = realpath($scriptPath . '/./');
$filepath = split("wp-content", $path);
// print_r($filepath);
define('WP_USE_THEMES', false);
require(''.$filepath[0].'/wp-load.php');


$plugin_version =get_option('mbYTPlayer_version');
$includes_url = includes_url();
$plugins_url = plugins_url();
$charset = get_option('blog_charset');
$donate = get_option('mbYTPlayer_donate');

if (!headers_sent()) {
    header('Content-Type: text/html; charset='.$charset);
}

if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
    ?>
    <!DOCTYPE HTML>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>" />
        <title><?php _e('mb.YTPlayer short code generator', 'wpmbytplayer'); ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo $plugins_url.'/wpmbytplayer/ytptinymce/bootstrap-1.4.0.min.css?v='.$plugin_version; ?>"/>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.js"></script>
        <script type="text/javascript" src="<?php echo $includes_url.'js/tinymce/tiny_mce_popup.js?v='.$plugin_version; ?>"></script>
        <style>

            fieldset {
                font-size: 16px;
                border: none;
                font-family: inherit;
                font-family: Helvetica Neue, Arial, Helvetica, sans-serif;
            }

            fieldset span.label{
                display: inline-block;
                width: 300px;
                font-size: 100%;
                font-weight: 400;
            }

            label {
                font-size: 16px;
            }

            fieldset label {
                margin: 0;
                padding: 9px!important;
                border-top: 1px solid #dcdcdc;
                display: block;
                font-size: 100%;
            }

            input, textarea, select {
                font-size: 100%;
            }

            .actions{
                text-align: right;
            }

            .help-inline {
                font-size: 16px;
                font-weight: 300;
                display: block;
                color: #999;
                padding-left: 0;
                margin: 5px 0;
            }

            .help-inline.inline {
                display: inline-block;
                font-weight: 400;
                padding-left: 10px;
            }



            #inlinePlayer, #controlBox{
                display: none;
                background: #fff;
                padding: 5px;
            }
        </style>

    </head>
    <body>

    <form class="form-stacked" action="#">
        <div class="actions">
            <input type="submit" value="Insert shortcode" class="btn primary"/>
            or
            <input class="btn" type="reset" value="Reset settings"/>
        </div>

        <fieldset>
            <!--legend><?php _e('mb.YTPlayer video parameters:', 'wpmbytplayer'); ?></legend-->
            <label>
                <span class="label"><?php _e('Video url', 'wpmbytplayer'); ?> <span style="color:red">*</span>: </span>
                <textarea type="text" name="url" class="span5"></textarea>
                <span class="help-inline"><?php _e('YouTube video URLs (comma separated)', 'wpmbytplayer'); ?></span>
            </label>

            <label>
                <span class="label"><?php _e('Opacity', 'wpmbytplayer'); ?>:</span>

                <input type="text" name="opacity" value="10">
<!--
                <select name="opacity">
                    <option value="1">1</option>
                    <option value=".8">0.8</option>
                    <option value=".5">0.5</option>
                    <option value=".3">0.3</option>
                </select>
-->
                <span class="help-inline"><?php _e('YouTube video opacity', 'wpmbytplayer'); ?></span>
            </label>

            <label>
                <span class="label"><?php _e('Quality', 'wpmbytplayer'); ?>:</span>
                <select name="quality">
                    <option value="default"><?php _e('auto detect', 'wpmbytplayer'); ?></option>
                    <option value="small"><?php _e('small', 'wpmbytplayer'); ?></option>
                    <option value="medium" selected="selected"><?php _e('medium', 'wpmbytplayer'); ?></option>
                    <option value="large"><?php _e('large', 'wpmbytplayer'); ?></option>
                    <option value="hd720"><?php _e('hd720', 'wpmbytplayer'); ?></option>
                    <option value="hd1080"><?php _e('hd1080', 'wpmbytplayer'); ?></option>
                    <option value="highres"><?php _e('highres', 'wpmbytplayer'); ?></option>
                </select>
                <span class="help-inline"><?php _e('YouTube video quality', 'wpmbytplayer'); ?></span>
            </label>

            <label>
                <span class="label"><?php _e('Aspect ratio', 'wpmbytplayer'); ?>:</span>
                <select name="ratio">
                    <option value="auto" selected="selected"><?php _e('auto detect', 'wpmbytplayer'); ?></option>
                    <option value="4/3"><?php _e('4/3', 'wpmbytplayer'); ?></option>
                    <option value="16/9"><?php _e('16/9', 'wpmbytplayer'); ?></option>
                </select>
                <span class="help-inline"><?php _e('YouTube video aspect ratio'); ?>.</span>
                <span class="help-inline"> <?php _e('If "auto" the plug in will try to get it from Youtube', 'wpmbytplayer'); ?>.</span>
            </label>

            <label>
                <span class="label"><?php _e('Is inline', 'wpmbytplayer'); ?>: </span>
                <input type="checkbox" name="isinline" value="true" onchange="isInline()" />
                <span class="help-inline"><?php _e('Show the player inline', 'wpmbytplayer'); ?></span>
            </label>

            <div id="inlinePlayer" style="">
                <span class="label"><?php _e('Player width', 'wpmbytplayer'); ?> *: </span>
                <input type="text" name="playerwidth" class="span5" style="width: 60px" onblur="suggestedHeight()"/> px
                <span class="help-inline"><?php _e('Set the width of the inline player', 'wpmbytplayer'); ?></span>
                <span class="label"><?php _e('Aspect ratio', 'wpmbytplayer'); ?>:</span>
                <select name="inLine_ratio" style="width: 60px" onchange="suggestedHeight()">
                    <option value="4/3"><?php _e('4/3', 'wpmbytplayer'); ?></option>
                    <option value="16/9"><?php _e('16/9', 'wpmbytplayer'); ?></option>
                </select>
                <span class="help-inline"><?php _e('To get the suggested height for the player', 'wpmbytplayer'); ?></span>

                <span class="label"><?php _e('Player height', 'wpmbytplayer'); ?> *: </span>
                <input type="text" name="playerheight" class="span5" style="width: 60px" /> px
                <span class="help-inline"><?php _e('Set the height of the inline player', 'wpmbytplayer'); ?></span>
                <span class="help-inline">* Add % to the unit if the width is set as percentage.</span>
            </div>

            <label>
                <span class="label"><?php _e('Element selector', 'wpmbytplayer'); ?>:</span>
                <input type="text" name="elementselector" value=""/>
                <span class="help-inline"><?php _e('Set the ID or the css class of the element where you want the player', 'wpmbytplayer'); ?></span>
            </label>

            <label>
                <span class="label"><?php _e('Show controls', 'wpmbytplayer'); ?>:</span>
                <input type="checkbox" name="showcontrols" value="true" onchange="showControlBox()"/>
                <span class="help-inline"><?php _e('show controls for this player', 'wpmbytplayer'); ?></span>
            </label>
            <div id="controlBox">
                <span class="label"><?php _e('Full screen', 'wpmbytplayer'); ?>:</span>
                <input type="radio" name="realfullscreen" value="true" checked/>
                <span class="help-inline inline"><?php _e('Full screen containment is the screen', 'wpmbytplayer'); ?></span>

                <span class="label"></span>
                <input type="radio" name="realfullscreen" value="false"/>
                <span class="help-inline inline" ><?php _e('Full screen containment is the browser window', 'wpmbytplayer'); ?></span>
                <br>
                <br>
                <span class="label"><?php _e('Show YouTube® link', 'wpmbytplayer'); ?></span>
                <input type="checkbox" name="printurl" value="true" checked/>
                <span class="help-inline"><?php _e('Show the link to the original YouTube® video', 'wpmbytplayer'); ?>.</span>
            </div>

            <label>
                <span class="label"><?php _e('Autoplay', 'wpmbytplayer'); ?>: </span>
                <input type="checkbox" name="autoplay" value="true" checked/>
                <span class="help-inline"><?php _e('The player starts on page load', 'wpmbytplayer'); ?></span>
            </label>

            <label>
                <span class="label"><?php _e('Start at', 'wpmbytplayer'); ?>: </span>
                <input type="text" name="startat" class="span5" style="width: 60px" /> sec.
                <span class="help-inline"><?php _e('Set the seconds you want the player starts at', 'wpmbytplayer'); ?></span>
            </label>

            <label>
                <span class="label"><?php _e('Stop at', 'wpmbytplayer'); ?>: </span>
                <input type="text" name="stopat" class="span5" style="width: 60px" /> sec.
                <span class="help-inline"><?php _e('Set the seconds you want the player stops at', 'wpmbytplayer'); ?></span>
            </label>

            <label>
                <span class="label"><?php _e('Audio volume', 'wpmbytplayer'); ?>:</span>
                <input type="text" name="volume" value="50" style="width: 60px"/>
                <span class="help-inline"><?php _e('Set the audio volume (from 0 to 100)', 'wpmbytplayer'); ?></span>
            </label>

            <label>
                <span class="label"><?php _e('Mute video', 'wpmbytplayer'); ?>:</span>
                <input type="checkbox" name="mute" value="true"/>
                <span class="help-inline"><?php _e('Mute the audio of the video', 'wpmbytplayer'); ?></span>
            </label>

            <label>
                <span class="label"><?php _e('Loop video', 'wpmbytplayer'); ?>:</span>
                <input type="checkbox" name="loop" value="true"/>
                <span class="help-inline"><?php _e('Loop the video once ended', 'wpmbytplayer'); ?></span>
            </label>

            <label>
                <span class="label"><?php _e('Add raster', 'wpmbytplayer'); ?>:</span>
                <input type="checkbox" name="addraster" value="true"/>
                <span class="help-inline"><?php _e('Add a raster effect', 'wpmbytplayer'); ?></span>
            </label>

            <label>
                <span class="label"><?php _e('Pause on window blur', 'wpmbytplayer'); ?>:</span>
                <input type="checkbox" name="stopmovieonblur" value="true"/>
                <span class="help-inline"><?php _e('Pause the player on window blur', 'wpmbytplayer'); ?></span>
            </label>

            <label>
                <span class="label"><?php _e('Add Google Analytics', 'wpmbytplayer'); ?>:</span>
                <input type="checkbox" name="gaTrack" value="true"/>
                <span class="help-inline"><?php _e('Add the event "play" on Google Analytics track', 'wpmbytplayer'); ?></span>
            </label>

        </fieldset>

        <div class="actions">
            <input type="submit" value="Insert shortcode" class="btn primary"/>
            or
            <input class="btn" type="reset" value="Reset settings"/>
        </div>
        <br>
        <br>
        <br>
    </form>

    <script type="text/javascript">

        function isInline(){
            var inlineBox = jQuery('#inlinePlayer');
            if(!$("[name=isinline]").is(":checked")){
                inlineBox.slideUp();
                $("[name=showcontrols]").removeAttr("checked");
                $("[name=autoplay]").attr("checked", "checked");
            }else{
                inlineBox.slideDown();
                $("[name=showcontrols]").attr("checked","checked");
                $("[name=autoplay]").removeAttr("checked");
            }
            showControlBox();
        }

        function showControlBox(){
            var controlBox = jQuery('#controlBox');
            if(!$("[name=showcontrols]").is(":checked")){
                controlBox.slideUp();
            }else{
                controlBox.slideDown();
            }
        }

        function suggestedHeight(){
            var width = parseFloat(jQuery("[name=playerwidth]").val());
            var margin = (width*10)/100;
            width = width + margin;
            var ratio = jQuery("[name=inLine_ratio]").val();
            var suggestedHeight = "";
            if(width)
                if(ratio == "16/9"){
                    suggestedHeight = (width*9)/16;
                }else{
                    suggestedHeight = (width*3)/4;
                }
            jQuery("[name=playerheight]").val(Math.floor(suggestedHeight));
        }

        // tinyMCEPopup.onInit.add(function(ed) {

        var ed = top.tinymce.activeEditor;

        var form = document.forms[0],

            isEmpty = function(value) {
                return (/^\s*$/.test(value));
            },

            encodeStr = function(value) {
                return value.replace(/\s/g, "%20")
                    .replace(/"/g, "%22")
                    .replace(/'/g, "%27")
                    .replace(/=/g, "%3D")
                    .replace(/\[/g, "%5B")
                    .replace(/\]/g, "%5D")
                    .replace(/\//g, "%2F");
            },

            insertShortcode = function(e){
                var sc = "[mbYTPlayer ",
                    inputs = form.elements, input, inputName, inputValue,
                    l = inputs.length, i = 0;

                for ( ; i < l; i++) {
                    input = inputs[i];
                    inputName = input.name;
                    inputValue = input.value;
                    // Video URL validation
                    if (inputName == "url" && (isEmpty(inputValue) || (inputValue.toLowerCase().indexOf("youtube")==-1) && inputValue.toLowerCase().indexOf("youtu.be")==-1)){
                        alert("a valid Youtube video URL is required");
                        return false;
                    }
                    // inputs of type "checkbox", "radio" and "text"
                    if (
                        ((input.type == "text" || input.type == "textarea") && !isEmpty(inputValue) && inputValue != input.defaultValue)
                        || input.type == "select-one"
                        || input.type =="checkbox"
                        || input.type =="radio"
                        ) {

                        if (input.type =="checkbox") {
                            if(!input.checked)
                                inputValue = false;
                        }

                        if (inputName =="realfullscreen" && !input.checked)
                            continue;

                        if (inputName =="inLine_ratio")
                            continue;

                        sc += ' ' + inputName + '="' + inputValue + '"';
                    }
                }
                sc += "]";

                ed.execCommand('mceInsertContent', 0, sc);
                tinyMCEPopup.close();

                return false;
            };

        form.onsubmit = insertShortcode;

        // });
    </script>
    </body>
    </html>
<?php }
