!function(e){var t=Upfront.Settings&&Upfront.Settings.l10n?Upfront.Settings.l10n.global.views:Upfront.mainData.l10n.global.views;define(["text!upfront/templates/popup.html","scripts/upfront/upfront-views-editor/theme-colors","scripts/upfront/upfront-views-editor/fonts"],function(s,o,r){return Backbone.View.extend({className:"upfront-ui",id:"upfront-general-csseditor",tpl:_.template(e(s).find("#csseditor-tpl").html()),prepareAce:!1,ace:!1,events:{"click .upfront-css-save-ok":"fire_save","click .upfront-css-close":"close","click .upfront-css-font":"startInsertFontWidget","click .upfront-css-image":"openImagePicker","click .upfront-css-selector":"addSelector"},initialize:function(t){var s,o,r=this,i=e.Deferred();this.options=t||{},this.model=t.model,this.sidebar=t.sidebar!==!1,this.global=t.global===!0,this.toolbar=t.toolbar!==!1,this.prepareAce=i.promise(),require([Upfront.Settings.ace_url],function(){i.resolve()}),this.resizeHandler=this.resizeHandler||function(){r.$el.width(e(window).width()-e("#sidebar-ui").width()-1)},e(window).on("resize",this.resizeHandler),s=this.model.get("id")+"-breakpoint-style",o=e("#"+s),0===o.length?(this.$style=e('<style id="'+s+'"></style>'),e("body").append(this.$style)):this.$style=o,t.cssSelectors&&(this.selectors=t.cssSelectors),"function"==typeof t.change&&this.listenTo(this,"change",t.change),"function"==typeof t.onClose&&this.listenTo(this,"close",t.onClose),this.render(),this.startResizable()},close:function(t){t&&t.preventDefault(),e(window).off("resize",this.resizeHandler),this.editor&&this.editor.destroy(),e("#page").css("padding-bottom",0),this.remove()},render:function(){var t=this;e("#page").append(this.$el),this.sidebar?this.$el.removeClass("upfront-css-no-sidebar"):this.$el.addClass("upfront-css-no-sidebar"),this.$el.html(this.tpl({selectors:this.selectors,elementType:!1,show_style_name:!1,showToolbar:this.toolbar})),this.resizeHandler(".");var s=this.$el.height()-this.$(".upfront-css-top").outerHeight();this.$(".upfront-css-body").height(s),this.prepareAce.done(function(){t.startAce()}),this.prepareSpectrum(),this.$el.show()},startAce:function(){var t=this,s=ace.edit(this.$(".upfront-css-ace")[0]),o=s.getSession();o.setUseWorker(!1),s.setShowPrintMargin(!1),o.setMode("ace/mode/css"),s.setTheme("ace/theme/monokai"),s.on("change",function(o){var r,i=s.getValue().split("}"),n="\n\n."+t.options.page_class+" ";i=_.map(i,function(t){return e.trim(t)}),i.pop(),r=i.length?n+i.join("\n}"+n)+"\n}":"",t.$style.html(r),t.trigger("change",r)});var r=new RegExp("."+this.options.page_class+"s*","g"),i=this.model.get("styles")?this.model.get("styles").replace(r,""):"";i="GalleryLightbox"===this.options.type?this.model.get("properties").get("styles").get("value").replace(r,""):this.model.get("styles")?this.model.get("styles").replace(r,""):"",s.setValue(e.trim(i),-1),s.renderer.scrollBar.width=5,s.renderer.scroller.style.right="5px",s.focus(),this.editor=s},prepareSpectrum:function(){var s=this;s.$(".upfront-css-color").spectrum({showAlpha:!0,showPalette:!0,palette:o.colors.pluck("color").length?o.colors.pluck("color"):["fff","000","0f0"],maxSelectionSize:9,localStorageKey:"spectrum.recent_bgs",preferredFormat:"hex",chooseText:t.ok,showInput:!0,allowEmpty:!0,show:function(){spectrum=e(".sp-container:visible")},change:function(e){var t=e.alpha<1?e.toRgbString():e.toHexString();s.editor.insert(t),s.editor.focus()},move:function(e){var t=e.toRgbString();spectrum.find(".sp-dragger").css("border-top-color",t),spectrum.parent().find(".sp-dragger").css("border-right-color",t)}})},startResizable:function(){var t=this,s=t.$(".upfront-css-body"),o=t.$(".upfront-css-top").outerHeight(),r=t.$(".upfront-css-selectors"),i=t.$(".upfront-css-save-form"),n=function(n,l){var c=l?l.size.height:t.$(".upfront-css-resizable").height(),a=c-o;s.height(a),t.editor&&t.editor.resize(),r.height(a-i.outerHeight()),e("#page").css("padding-bottom",c)};n(),this.$(".upfront-css-resizable").resizable({handles:{n:".upfront-css-top"},resize:n,minHeight:200,delay:100})},remove:function(){this.trigger("close"),Backbone.View.prototype.remove.call(this),e(window).off("resize",this.resizeHandler)},openImagePicker:function(){var e=this;Upfront.Media.Manager.open({}).done(function(t,s){if(Upfront.Events.trigger("upfront:element:edit:stop"),s){var o=s.models[0].get("image").src;e.editor.insert('url("'+o+'")'),e.editor.focus()}})},startInsertFontWidget:function(){var t=new r.Insert_Font_Widget({collection:r.theme_fonts_collection});e("#insert-font-widget").html(t.render().el)},addSelector:function(t){var s=e(t.target).data("selector");this.editor.insert(s),this.editor.focus()}})})}(jQuery);