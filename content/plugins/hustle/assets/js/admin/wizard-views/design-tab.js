
Hustle.define("Optin.Design_Tab", function( $ ) {
    "use strict";
    return Hustle.View.extend( _.extend({}, Hustle.get("Mixins.Model_Updater"), {
        template: Hustle.template("wpoi-wizard-design_template"),
		message_editor: false,
		success_editor: false,
        structure_tpl: Hustle.template("wpoi-wizard-design_structure_template"),
        shapes_tpl: Hustle.template("wpoi-wizard-design_shapes_template"),
        after_submit_tpl: Hustle.template("wpoi-wizard-design_after_submit_template"),
        color_pickers_tpl: Hustle.template("optin-color-pickers"),
        el: "#wpoi-wizard-design",
        preview: false,
        preview_model: false,
        defaults: {
            optin_input_icons: ""
        },
        stylable_elements:{
            main_background: '.wpoi-hustle .wpoi-optin',
            title_color: '.wpoi-hustle h2.wpoi-title',
            link_color: '.wpoi-hustle .wpoi-message p a',
            content_color: '.wpoi-hustle .wpoi-message, .wpoi-hustle .wpoi-message p',
            link_hover_color: '.wpoi-hustle .wpoi-message p a:hover',
            link_active_color: '.wpoi-hustle .wpoi-message p a:active, .wpoi-hustle .wpoi-message p a:focus',
            form_background: '.wpoi-hustle .wpoi-form',
            fields_background: '.wpoi-hustle form .wpoi-element',
            fields_hover_background: '.wpoi-hustle form .wpoi-element:hover',
            fields_active_background: '.wpoi-hustle form .wpoi-element:active, .wpoi-hustle form .wpoi-element:focus',
            label_color: '.wpoi-hustle form .wpoi-element label, .wpoi-hustle form .wpoi-element label span, .wpoi-hustle form .wpoi-element .wphi-font',
            button_background: '.wpoi-hustle form button',
            button_label: '.wpoi-hustle form button',
            fields_color: '.wpoi-hustle form > .wpoi-element input',
            fields_hover_color: '.wpoi-hustle form > .wpoi-element input:hover',
            fields_active_color: '.wpoi-hustle form > .wpoi-element input:active, .wpoi-hustle form > .wpoi-element input:focus',
            error_color: '.wpoi-hustle form .i-error, .wpoi-hustle form .i-error + span',
            button_hover_background: '.wpoi-hustle form button:hover',
            button_active_background: '.wpoi-hustle form button:active, .wpoi-hustle form button:focus',
            button_hover_label: '.wpoi-hustle form button:hover',
            button_active_label: '.wpoi-hustle form button:active, .wpoi-hustle form button:focus',
            checkmark_color: '.wpoi-hustle .wpoi-success-message .wphi-font',
            success_color: '.wpoi-hustle .wpoi-success-message .wpoi-content, .wpoi-hustle .wpoi-success-message .wpoi-content p',
            close_color: 'a.inc-opt-close-btn, a.inc-opt-close-btn:visited',
            nsa_color: '.wpoi-nsa > a, .wpoi-nsa > a.inc_opt_never_see_again',
            overlay_background: '.wpoi-popup-overlay',
            close_hover_color: 'a.inc-opt-close-btn:hover',
            nsa_hover_color: '.wpoi-nsa > a:hover, .wpoi-nsa > a.inc_opt_never_see_again:hover',
            nsa_active_color: '.wpoi-nsa > a:active, .wpoi-nsa > a.inc_opt_never_see_again:active, .wpoi-nsa > a:focus, .wpoi-nsa > a.inc_opt_never_see_again:focus',
            radio_background: '.wpoi-hustle form .wpoi-mcg-option input[type="radio"] + label:before',
            radio_checked_background: '.wpoi-hustle form .wpoi-mcg-option input[type="radio"]:checked + label:after',
            checkbox_background: '.wpoi-hustle form .wpoi-mcg-option input[type="checkbox"] + label:before',
            checkbox_checked_color: '.wpoi-hustle form .wpoi-mcg-option input[type="checkbox"]:checked + label:before',
            mcg_title_color: '.wpoi-hustle form .wpoi-mcg-list-name, .wpoi-hustle .wpoi-submit-failure',
            mcg_label_color: '.wpoi-hustle form .wpoi-mcg-option input[type="checkbox"] + label, .wpoi-hustle form .wpoi-mcg-option input[type="radio"] + label',
            close_active_color: 'a.inc-opt-close-btn:active, a.inc-opt-close-btn:focus',
        },
        events: {
            'click .wph-preview--eye': "open_preview",
            "change #optin_color_palettes": "update_color_palette",
            "submit form.wpoi-form-wrap": "cancel_dummy_optin_submit",
			"change #optin-active-css": "toggleCustomCSS",
            "click #optin_apply_custom_css": 'apply_custom_css',
            "click .wph-triggers--options label": 'handle_triggers',
            "mouseenter .wpoi-stylable-element": "highlight_stylable_element",
            "mouseleave .wpoi-stylable-element": "highlight_stylable_element",
            "click .wpoi-stylable-element": "insert_stylable_element",
            "change #optin_fname": "update_optional_elements",
            "change #optin_lname": "update_optional_elements",
			'change #optin_customize_color_palette': '_toggleColorScheme',
			'change [name="on_success"]': 'updateMeta',
			'change [name="on_success_time"]': 'updateMeta',
			'change [name="on_success_unit"]': 'updateMeta',
			'change .wysiwyg-tab': 'toggleSuccessMessageFields'
        },
        stylables: {
            ".wpoi-hustle .wpoi-optin ": "Opt-in Container",
            ".wpoi-title ": "Title",
            ".wpoi-message, .wpoi-message p ": "Content",
            ".wpoi-form ": "Form Container",
            ".wpoi-form .wpoi-subscribe-fname ": "First Name",
            ".wpoi-form .wpoi-subscribe-lname ": "Last Name",
            ".wpoi-form .wpoi-subscribe-email ": "Email",
            ".wpoi-form .wpoi-subscribe-send ": "Form Button"
        },
        init: function( options ){
            this.optin = options.optin;

            this.listenTo(this.model, "change", this.render_structure);
            this.listenTo(this.model, "change:colors.customize",  this.render_color_pickers);
            this.listenTo(this.model, "change:borders.fields_style", this.render_shapes );
            this.listenTo( this.model, "change:on_submit", this.render_on_submit );

            this.listenTo( this.model, "change:form_location", this.set_proper_image_location );
			this.listenTo( Hustle.Events, "Optin.save", this.sync_model_data );

            return this.render();
        },
        render: function(){
            this.$el.html( this.template(  _.extend({}, { palettes: Palettes.toJSON() }, { stylables: this.stylables }, this.optin.toJSON(), this.model.toJSON()  ) ) );

            this.render_structure();
            this.render_shapes();
            this.render_on_submit();

            this.create_editors();
            this.update_styles();
            this.update_borders_style();
            this.render_color_pickers();
            this.render_image_holder();
            this.apply_custom_css();

        },
        render_structure: function(){
            this.$("#wph-optin--structure").html( this.structure_tpl( this.model.toJSON() ) );
        },
		handle_triggers: function(e){
			var $this = $(e.target),
				$selected_li = $this.closest('li'),
				$siblings = $selected_li.siblings()
			;
			$siblings.removeClass('current');
			$selected_li.addClass('current');
		},
        render_shapes: function(){
			var json_data = this.model.toJSON();
			json_data.wph_disabled = '';
			if ( this.model.get('borders.fields_style') === 'joined' ) {
				json_data.wph_disabled = 'disabled';
			}
            this.$("#wph-optin--shapes").html( this.shapes_tpl( json_data  ) );
			Hustle.Events.trigger("view.rendered", this.$("#wph-optin--shapes"));
            this.create_color_pickers();
        },
        render_on_submit: function(){
          // this.$("#wph-optin--after_submitting").html( this.after_submit_tpl( this.model.toJSON()  ) );
          if( "success_message" == this.model.get("on_submit") ){
              this.$("label[for='wpoi-sm']").show();
          }else{
              this.$("label[for='wpoi-sm']").hide();
              this.$("label[for='wpoi-om']").click();
          }
        },
        create_color_pickers: function(){
            this.$(".optin_color_picker").not(".wp-color-picker").wpColorPicker({
                change: function(event, ui){
                    var $this = $(this);
                    $this.val( ui.color.toCSS()).trigger("change");
                }
            });
        },
        render_image_holder: function(){
            var Media_Holder = Hustle.get("Media_Holder");
            this.media_holder = new Media_Holder({
                model: this.model,
                attribute: "image_src"
            });

            this.$(".wph-media--holder").html( this.media_holder.$el );
        },
        cancel_dummy_optin_submit: function(e){
            e.preventDefault();
        },
        update_color_palette: function(e){
            var palette = Palettes.findWhere({ "_id": e.target.value }),
                prev_val = this.model.get("colors").toJSON(),
                Model = Hustle.get("Models.M");
            this.model.set("colors", new Model( _.extend({}, palette.toJSON(), {palette: e.target.value } ) ) );
            this.$("#optin_customize_color_palette").prop("checked", false);
            this.render_color_pickers();
        },
        //reset_color_pickers: function(){
        //    var self = this;
        //    this.$('#optwiz-custom_color .optin_color_picker').each(function(){
        //        var $this = $(this),
        //            id = this.id,
        //            field_name = id.replace("optin_", ""),
        //            colors = self.model.get("colors");
        //
        //        if($this.data("wpColorPicker") || $this.data("wpWpColorPicker") )
        //            $this.wpColorPicker("color", colors.get(field_name));
        //
        //    });
        //},
        render_color_pickers: function(){
            var $el =  this.$('#optwiz-custom_color');
            if( _.isTrue( this.model.get("colors.customize") ) ){
                $el.html( this.color_pickers_tpl( this.model.toJSON() ) )
                    .removeClass("hidden");
            }else{
                $el.addClass("hidden");
            }

            this.create_color_pickers();
        },
        // Layout #3
        // Set height of image container same to parent div
        // This to avoid Safari conflicts with [ height: 100% ]
        _fix_layout_3_sizes: function(){
            $(".wpoi-layout-three .wpoi-optin:not(.wpoi-small) .nocontent:not(.noimage)").each(function(){
                var $this = $(this),
                    $parent = $this.find(".wpoi-aside-x").prev(".wpoi-element"),
                    $child = $this.find(".wpoi-aside-x").prev(".wpoi-element").find(".wpoi-container.wpoi-col");
                $child.css("height", $parent.height());
            });

            // Vertical align content
            $(".wpoi-layout-three .wpoi-optin:not(.wpoi-small) > .wpoi-container.noimage:not(.nocontent)").each(function(){
                var $this = $(this),
                    $aside = $this.find(".wpoi-aside-x"),
                    $div = $this.find(".wpoi-image").next(".wpoi-element"),
                    $element = $aside.prev(".wpoi-element"),
                    $content = $this.find(".wpoi-content"),
                    $col = $element.find(".wpoi-col"),
                    $form = $this.find("form");

                if ( $form.height() > $content.height() ){
                    $col.css("height", $aside.height() + 'px' );
                    $div.addClass("wpoi-align");
                    $content.addClass("wpoi-align-element");
                }
                if ( $form.height() < $content.height() ){
                    $aside.css("height", $element.height() + 'px');
                    $aside.addClass("wpoi-align");
                    $form.addClass("wpoi-align-element");
                }
            });
            $(".wpoi-layout-three .wpoi-optin:not(.wpoi-small) > .wpoi-container:not(.noimage):not(.nocontent)").each(function(){
                var $this = $(this),
                    $sidebar = $this.find(".wpoi-aside-x"),
                    $element = $sidebar.prev(".wpoi-element"),
                    $form = $this.find("form");

                if ( $form.height() < $element.height() ){
                    $sidebar.css("height", $element.height());
                    $sidebar.addClass("wpoi-align");
                    $form.addClass("wpoi-align-element");
                }
            });
        },
        create_editors: function(){
            this._bind_to_message_editor();
            this._create_css_editor();
        },
        highlight_stylable_element: function(e){
            var $el = $(e.target),
                $stylable = $( $el.data("stylable") );

            $stylable.toggleClass("optin_hovered_stylable_element");
        },
        insert_stylable_element: function(e){
            e.preventDefault();
            var $el = $(e.target),
                stylable = $el.data("stylable") + "{}";

            this.css_editor.navigateFileEnd();
            this.css_editor.insert(stylable);
            this.css_editor.navigateLeft(1);
            this.css_editor.focus();

        },
        apply_proper_preview_classes: function(){			
            $(".wpoi-hustle").each(function(){
                if ($(this).width() <= 405){
                    $(this).find(".wpoi-optin").addClass("wpoi-small");
                } else {
                    $(this).find(".wpoi-optin").removeClass("wpoi-small");
                }

                if ( ($(this).width() <= 585) && ($(this).width() > 405) ){
                    $(this).find(".wpoi-optin").addClass("wpoi-medium");
                } else {
                    $(this).find(".wpoi-optin").removeClass("wpoi-medium");
                }
            });

            $(".wpoi-layout-three .wpoi-optin:not(.wpoi-small) .wpoi-form").each(function(){
                if ($(this).height() > 168){
                    $(this).addClass("wpoi-align");
                    $(this).next("form").addClass("wpoi-align-element");
                } else {
                    $(this).removeClass("wpoi-align");
                    $(this).next("form").removeClass("wpoi-align-element");
                }
            });

            $(".wpoi-mcg-select").each(function(){
                $(this).parent(".wpoi-provider-args > .wpoi-container > .wpoi-element:nth-child(2) > .wpoi-container > .wpoi-element").css({"padding":"0","background":"transparent"});
            });

            // Layout #3
            // Set height of image container same to parent div
            // This to avoid Safari conflicts with [ height: 100% ]
            $(".wpoi-layout-three .wpoi-optin:not(.wpoi-small) .nocontent:not(.noimage)").each(function(){
                var $this = $(this),
                    $parent = $this.find(".wpoi-aside-x").prev(".wpoi-element"),
                    $child = $this.find(".wpoi-aside-x").prev(".wpoi-element").find(".wpoi-container.wpoi-col");
                $child.css("height", $parent.height());
            });

            // Layout #3
            // Vertical align content
            $(".wpoi-layout-three .wpoi-optin:not(.wpoi-small) > .wpoi-container.noimage:not(.nocontent)").each(function(){
                var $this = $(this),
                    $aside = $this.find(".wpoi-aside-x"),
                    $div = $this.find(".wpoi-image").next(".wpoi-element"),
                    $element = $aside.prev(".wpoi-element"),
                    $content = $this.find(".wpoi-content"),
                    $col = $element.find(".wpoi-col"),
                    $form = $this.find("form");

                if ( $form.height() > $content.height() ){
                    $col.css("height", $aside.height() + 'px' );
                    $div.addClass("wpoi-align");
                    $content.addClass("wpoi-align-element");
                }
                if ( $form.height() < $content.height() ){
                    $aside.css("height", $element.height() + 'px');
                    $aside.addClass("wpoi-align");
                    $form.addClass("wpoi-align-element");
                }
            });
            $(".wpoi-layout-three .wpoi-optin:not(.wpoi-small) > .wpoi-container:not(.noimage):not(.nocontent)").each(function(){
                var $this = $(this),
                    $sidebar = $this.find(".wpoi-aside-x"),
                    $element = $sidebar.prev(".wpoi-element"),
                    $form = $this.find("form");

                if ( $form.height() < $element.height() ){
                    $sidebar.css("height", $element.height());
                    $sidebar.addClass("wpoi-align");
                    $form.addClass("wpoi-align-element");
                }
            });
            // Layout #4
            // Vertical align content
            $(".wpoi-layout-four .wpoi-optin:not(.wpoi-small) > .wpoi-container.noimage:not(.nocontent)").each(function(){
                var $this = $(this),
                    $aside = $this.find(".wpoi-aside-xl"),
                    $col = $this.find(".wpoi-aside-xl > .wpoi-container"),
                    $parent = $aside.find(".wpoi-form"),
                    $form = $aside.find("form"),
                    $element = $aside.next(".wpoi-element"),
                    $content = $element.find(".wpoi-content");
				
                if ( $content.height() > $form.height() ){
                    $col.css("height", $aside.height() + 'px');
                    $parent.addClass("wpoi-align");
                    $form.addClass("wpoi-align-element");
                }
                if ( $content.height() < $form.height() ) {
                    $element.css("height", $col.height() + 'px');
                    $element.addClass("wpoi-align");
                    $content.addClass("wpoi-align-element");
                }
            });
            $(".wpoi-layout-four .wpoi-optin:not(.wpoi-small) > .wpoi-container:not(.noimage):not(.nocontent)").each(function(){
                var $this = $(this),
                    $aside = $this.find(".wpoi-aside-xl"),
                    $col = $this.find(".wpoi-aside-xl > .wpoi-container"),
                    $image = $this.find(".wpoi-image"),
                    $parent = $aside.find(".wpoi-form"),
                    $form = $aside.find("form"),
                    $element = $aside.next(".wpoi-element"),
                    $content = $this.find(".wpoi-content");

                if ( $content.height() > $col.height() ){
                    $col.css("height", $aside.height() + 'px');
                    $parent.css("height", $col.height() - $image.height() );
                    $parent.addClass("wpoi-align");
                    $form.addClass("wpoi-align-element");
                }
                if ( $content.height() < $col.height() ) {
                    $element.css("height", $aside.height() + 'px');
                    $element.addClass("wpoi-align");
                    $content.addClass("wpoi-align-element");
                }
            });
        },
        _bind_to_message_editor: function(){
            var self = this;
            var waitForTinyMCE = setInterval(function() {
				if (typeof tinymce !== "object") return;
				
				clearInterval(waitForTinyMCE);
				
				tinymce.on("AddEditor", function(args){
					var on_content_change = function() {
						if( args && 'optin_message' === args.editor.getParam("id") )
							self.optin.set("optin_message", this.getContent() );

						if( args && 'success_message' === args.editor.getParam("id") )
							self.model.set("success_message", this.getContent() );

						self.apply_proper_preview_classes();

					};
					if( args && 'optin_message' === args.editor.getParam("id") )
						self.message_editor = args.editor;

					if( args && 'success_message' === args.editor.getParam("id") )
						self.success_editor = args.editor;

						args.editor.on("loadContent", function(e){ // set max width of body element inside iframe to 100%
						this.dom.setStyle("tinymce", "maxWidth", "100%");
					});
					Optin.Events.off("navigate", self.refresh_editor, self );
					Optin.Events.on("navigate", self.refresh_editor, self );
					self.on("rendered", self.refresh_editor, self);
					args.editor.on('change', on_content_change);
					args.editor.on('AddUndo', on_content_change);
					args.editor.on('keyup', on_content_change);
					self.apply_proper_preview_classes();
					
				});
				
            }, 50);

        },
        refresh_editor: function(args, name){
            if( 'design' !== name || !_.isObject( this.message_editor )  ) return;
            this.message_editor.remove();
            tinymce.init(this.message_editor.settings);
            $(this.message_editor.settings.selector + "_ifr").height(240);

            this.success_editor.remove();
            tinymce.init(this.success_editor.settings);
            $(this.success_editor.settings.selector + "_ifr").height(240);

        },
        _create_css_editor: function(){
            this.css_editor = ace.edit("optin_custom_css");

            this.css_editor.getSession().setMode("ace/mode/css");
            this.css_editor.setTheme("ace/theme/solarized_light");
            this.css_editor.getSession().setUseWrapMode(true);
            this.css_editor.getSession().setUseWorker(false);
            this.css_editor.setShowPrintMargin(false);
            this.css_editor.renderer.setShowGutter(true);
            this.css_editor.setHighlightActiveLine(true);
            this.css_editor.on("blur", $.proxy(this.update_custom_css, this));

        },
        _create_color_pickers: function(){
            var self = this;
            this.$(".optin_color_picker").wpColorPicker({
                change: function(event, ui){
                    var method_name = "update_" + this.id.replace("optin_", "");
                    if( typeof self[method_name] === "function"){
                        self[method_name](event, ui);
                    }else{
                        console.warn("Method ", method_name, " not found");
                    }
                }
            });

            this.$(".ui-draggable-handle").click(function(e){e.preventDefault();});
        },
        update_custom_css: function(){
            this.model.set("css", this.css_editor.getValue() );
        },
		_toggleColorScheme: function() {
			var colorSelector = $('#optin_color_palettes' ),
				customColor = $('#optin_customize_color_palette');
			colorSelector.prop('disabled', customColor.is( ':checked' ) );
		},
		toggleCustomCSS: function(e) {
			var input = $(e.currentTarget),
				isOn = input.is(':checked'),
				holder =this.$('#wph-css-holder');
			holder[ isOn ? 'removeClass' : 'addClass']('hidden');
			input.closest('label.wph-label--border').toggleClass('toggle-off');
		},
        apply_custom_css: function(e){
            if( e ) {
                e.preventDefault();
				$(e.target).prop("disabled", true);
            }
			this._toggleColorScheme();

            this.update_custom_css();
            var $styles_el = $("#optin-custom-styles").length ? $("#optin-custom-styles") : $('<style id="optin-custom-styles">').appendTo("body"),
                css_string = this.css_editor.getValue();

            $.ajax({
                type: "POST",
                url: ajaxurl,
                dataType: "json",
                data: {
                    action: 'inc_opt_prepare_custom_css',
                    css: css_string,
                    _ajax_nonce: $("#optin_custom_css").data("nonce"),
                    optin_id: optin_vars.current.data.optin_id
                },
                success: function(res){
                    if( res && res.success ){
                        $styles_el.html( res.data  );
                    }

                    if( e ) $(e.target).prop("disabled", false);
                },
                error: function() {
                    if( e ) $(e.target).prop("disabled", false);
                }
            });
        },
        get_layout_colors: function(){
            if( !_.isTrue( this.model.get("colors.customize") ) )
                return Palettes.findWhere({_id: this.model.get("colors.palette")}).toJSON();
            else
                return this.model.toJSON().colors;
        },
        update_styles: function(){
            var colors = this.get_layout_colors(),
                styles = "",
                $styles_el = $("#optin-preview-styles").length ? $("#optin-preview-styles") : $('<style id="optin-preview-styles">').appendTo("body");

            _.each(this.stylable_elements, function(el, index){
                var color_type = index.indexOf("background") !== -1 ? 'background' : 'color',
                    color = colors[index];
                styles += ( el + "{ " + color_type + ": " + color +";} " );
            });

            $styles_el.html( styles );
        },
        update_borders_style: function(){
            var borders = this.model.toJSON().borders,
                elements = this.stylable_elements,
                styles = "",
                $styles_el = $("#optin-preview-styles-borders").length ? $("#optin-preview-styles-borders") : $('<style id="optin-preview-styles-borders">').appendTo("body");

            //main container border
            styles += ( elements.main_background + "{border-radius:" + borders.corners_radius + "px;}"  );

            if( 'joined' ===  this.model.get("borders").get('fields_style') ){ // set border to 0 if input and button are joined
                styles += ( elements.fields_background + "{border-radius: 0px;}"  );
                styles += ( elements.button_background + "{border-radius: 0px;}"  );
            }else{
                styles += ( elements.fields_background + "{border-radius:" + borders.fields_corners_radius + "px;}"  );
                styles += ( elements.button_background + "{border-radius:" + borders.button_corners_radius + "px;}"  );
            }

            // main container dropshadow
			// check not needed for optin
            // if(_.isTrue( borders.drop_shadow ) )
                styles += ( elements.main_background + "{box-shadow: 0 0 " + borders.dropshadow_value +"px " + borders.shadow_color + "}"  );


            $styles_el.html( styles );
        },
        update_optional_elements: function(e){
            var vals = this.model.get("elements");
            if( e.target.checked ){
                vals.push( e.target.value );
                this.model.set("elements", vals, {silent: true} ) ;
            }else{
                this.model.set("elements", _.without( vals, e.target.name ), {silent: true} );
            }
        },
        _show_args: function(){
            if( "mailchimp" === Optin.step.services.model.get("optin_provider")
                && !Optin.step.services.provider_args.isEmpty()
                && "hidden" !== Optin.step.services.provider_args.get("group").form_field
            )
            return true;

            return false;
        },
        /**
         * Set proper image location based on selected form_location
         *
         * If form location is not 0, set image locatio to left
         *
         * @param model
         */
        set_proper_image_location: function(model){
            if( model.get("form_location") != 0 ){
                model.set("image_location", "left");
            }
        },
        _set_preview_model: function(){
            var data = this.optin.toJSON(),
                _show_args = function(){
					if( "mailchimp" === data.optin_provider
						&& Optin.step.services.provider_args
						&& Optin.step.services.provider_args.get("group")
						&& "hidden" !== Optin.step.services.provider_args.get("group").form_field
					)
						return true;

					return false;
				},
                display = Optin.step.display.model.toJSON();
				
            if( this.preview_model ){
                this.preview_model.set( _.extend(
                    {
                        image_style: "",
                        type: "popup"
                    },
                    this.model.toJSON(),
                    this.model.get("borders").toJSON(),
                    this.optin.toJSON(),
                    {
                        types:{
                            after_content: display.after_content,
                            popup: display.popup,
                            slide_in: display.slide_in
                        }
                    },
                    {
                        has_args: _show_args()
                    }
                )  );
                return;
            }

            this.preview_model = new Backbone.Model( _.extend(
                {
                    image_style: "",
                    type: "popup"
                },
                this.model.toJSON(),
                this.model.get("borders").toJSON(),
                this.optin.toJSON(),
                {
                    types:{
                        after_content: display.after_content,
                        popup: display.popup,
                        slide_in: display.slide_in
                    }
                },
                {
                    has_args: _show_args()
                }
            )  );
        },
        open_preview: function(e) {
            Optin.Events.trigger("design:preview:render:start");
			this.sync_model_data();
            this._set_preview_model();
			
            if( this.preview ) {
                this.preview.render();
                this.preview.show();
            } else {
				var Preview = Hustle.get("Optin.Preview");
				this.preview = new Preview({model: this.preview_model });
				this.preview.show();
			}

			this._fix_layout_3_sizes();
            this.update_styles();
            this.update_borders_style();
            this.apply_proper_preview_classes();
            this.apply_custom_css();
        },
		sync_model_data: function() {
			var optin_title = this.model.get( 'optin_title' );
			if ( ! optin_title ) {
				// Try the title field
				optin_title = $( '#optin_title' ).val();
			}
			this.optin.set("optin_title", optin_title );
			
			if ( typeof tinymce !== "object" ) return;
			if ( !this.message_editor ) this.message_editor = tinymce.get("optin_message"); 
			this.optin.set("optin_message", this.message_editor.getContent());
			
			if ( !this.success_editor ) this.success_editor = tinymce.get("success_message");
			this.model.set("success_message", this.success_editor.getContent());
		},
		updateMeta: function( e ) {
			var input = $( e.currentTarget ),
				input_name = input.attr( 'name' );
			this.model.set( input_name, input.val() );
		},
		toggleSuccessMessageFields: function( e ) {
			var tab = $( e.currentTarget ),
				is_visible = 'success_message' === tab.val(),
				container = $( '#wpoi-success-message-fields');

			container[ is_visible ? 'removeClass' : 'addClass']('hidden');
		}
    }));

});
