!function(e){upfrontrjs.define([],function(){var t=function(e){return e.breakpoint&&e.breakpoint.tablet&&(e.tablet=[],_.each(e.breakpoint.tablet,function(t,r){e.tablet[r]=t})),e.breakpoint&&e.breakpoint.mobile&&(e.mobile=[],_.each(e.breakpoint.mobile,function(t,r){e.mobile[r]=t})),e},r=function(e,r,n){var o=Upfront.Util.template(r);return"undefined"!=typeof e.preset_style&&(e.preset_style=e.preset_style.replace(/#page/g,"#page.upfront-layout-view .upfront-editable_entity.upfront-module"),"thispost"===n&&(e.preset_style=e.preset_style.replace(/.default/g,".default.upfront-this_post")),"ucomment"===n&&(e.preset_style=e.preset_style.replace(/.default/g,".default.upfront-comment")),e.preset_style=Upfront.Util.colors.convert_string_ufc_to_color(e.preset_style,!0)),o({properties:t(e)}).replace(/#page/g,"div#page.upfront-layout-view").replace(new RegExp(e.id+" .upfront-button","g"),e.id+".upfront-button").replace(/\\'/g,"'").replace(/\\'/g,"'").replace(/\\'/g,"'").replace(/\\"/g,'"').replace(/\\"/g,'"').replace(/\\"/g,'"')},n={generateCss:r,generatePresetsToPage:function(e,r){_.each(Upfront.mainData[e+"Presets"],function(o){n.updatePresetStyle(e,t(o),r)})},getPresetProperties:function(t,r){var n=Upfront.mainData[t+"Presets"]||[],o={};return e.each(n,function(e,t){return!t||!t.id||r!==t.id||void(o=_.extend({},t))}),o},updatePresetStyle:function(t,n,o){var p=t+"-preset-"+n.id,l=_.extend({},n);_.each(l,function(e,t){Upfront.Util.colors.is_theme_color(e)&&(l[t]=e)}),0===e("style#"+p).length&&e("body").append('<style class="preset-style" id="'+p+'"></style>'),e("style#"+p).text(Upfront.Util.colors.convert_string_ufc_to_color(r(l,o,t),!0))}};return n})}(jQuery);