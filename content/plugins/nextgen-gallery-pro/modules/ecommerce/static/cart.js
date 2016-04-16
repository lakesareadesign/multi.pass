(function($){
    // Namespace and utility functions
    Ngg_Pro_Cart = {
        get_ajax_url: function(){
            return (typeof(photocrati_ajax) != 'undefined') ? photocrati_ajax.url :
                (typeof(parent.photocrati_ajax) != 'undefined' ? parent.photocrati_ajax.url : null);
        },

        Models: {},
        Views: {}
    };


    // Define image model
    Ngg_Pro_Cart.Models.Image						= Backbone.Model.extend({
        idAttribute: 'pid',

        subtotal: function(){
            var retval = 0.0;
            this.get('items').each(function(item){
                retval += item.subtotal();
            });
            return retval;
        }
    });

    // Define pricelist item model
    Ngg_Pro_Cart.Models.PricelistItem				= Backbone.Model.extend({
        idAttribute: 'ID',

        defaults: {
            quantity: 0
        },

        subtotal: function(){
            return parseFloat(this.get('price')) * parseInt(this.get('quantity'));
        }
    });

    // Define Image Collection
    Ngg_Pro_Cart.Models.ImageCollection				= Backbone.Collection.extend({
        model: Ngg_Pro_Cart.Models.Image,

        subtotal: function(){
            var retval = 0.0;
            this.each(function(image){
                retval += image.subtotal();
            });
            return retval;
        }
    });

    // Define Pricelist Item Collection
    Ngg_Pro_Cart.Models.PricelistItemCollection		= Backbone.Collection.extend({
        model: Ngg_Pro_Cart.Models.PricelistItem
    });


    // Define Cart Model
    Ngg_Pro_Cart.Models.Cart = Ngg_Pro_Cart.Models.ImageCollection.extend({
        shipping: 0.0,
        use_home_country: true,
        allow_international_shipping: false,

        empty_cart: function(){
            this.reset();
            this.save();
        },

        recalculate_shipping: function(){
            var _this = this;
            var request = {
                action: 'get_shipping_amount',
                cart: this.to_json(),
                use_home_country: this.use_home_country
            };

            $.post(Ngg_Pro_Cart.get_ajax_url(), request, function(response){
                if (typeof(response) != 'object') response = JSON.parse(response);
                _this.shipping = response.shipping;
                _this.trigger('change:shipping');
            });
        },

        initialize: function(){
            this.ready = false;
            this.storage = Ngg_Store;
            this.on('change:quantity', this.recalculate_shipping, this);

            // Internal representation of the cart stored in the browser
            // We store a simplified version of the cart to conserve memory
            // {
            //   image_ids: [1,2],
            //   images: {
            //        1: {
            //           item_ids: [3,4],
            //           items: {
            //                3: {quantity: 5}
            //                4: {quantity: 5}
            //           }
            //        }
            //   },
            // }
            var cart = this.storage.get('ngg_pro_cart');
            if (typeof(cart) != 'undefined' && cart != null) {
                if (typeof(cart) != 'object') cart = JSON.parse(cart);

                // Send the browser cart to the server to get a fully populated cart
                var _this = this;
                $.post(Ngg_Pro_Cart.get_ajax_url(), {action: 'get_cart_items', cart: cart}, function(response){
                    if (typeof(response) != 'object') response = JSON.parse(response);

                    // Set the total shipping cost
                    _this.shipping = response.shipping;
                    _this.allow_international_shipping = response.allow_international_shipping;

                    // Add the images to the cart
                    for (var image_index=0; image_index<response.image_ids.length; image_index++) {
                        var image_id         = parseInt(response.image_ids[image_index]);
                        var image_properties = response.images[image_id];
                        var items = new Ngg_Pro_Cart.Models.PricelistItemCollection();

                        for (var item_index=0; item_index<image_properties.item_ids.length; item_index++) {
                            var item_id 	 = parseInt(image_properties.item_ids[item_index]);
                            if (item_id > 0) {
                                var item_properties 	= image_properties.items[item_id];
                                item_properties.id 		= item_id;
                                item_properties.image_id= image_id;
                                items.add(item_properties);
                            }
                        }
                        image_properties.id = image_id;
                        image_properties.items = items;
                        delete image_properties.item_ids;
                        _this.add(image_properties);
                    }
                    _this.ready = true;
                    _this.trigger('ready');
                });
            }
            else {
                this.ready = true;
                this.trigger('ready');
            }
        },

        total: function(){
            return parseFloat(this.shipping) + parseFloat(this.subtotal());
        },

        /**
         * Saves the representation of the cart in the local browser storage
         */
        save: function(){
            this.storage.set('ngg_pro_cart', this.to_json());
        },

        /**
         * Returns the JSON representation of the cart
         * @returns {{image_ids: Array, images: {}}}
         */
        to_json: function(){
            var cart = {
                image_ids: [],
                images: {}
            };
            this.each(function(image_obj){
                cart.image_ids.push(image_obj.id);
                var stored_image = {
                    item_ids: [],
                    items: {}
                };
                image_obj.get('items').each(function(item){
                    stored_image.item_ids.push(item.id);
                    stored_image.items[item.id] = {quantity: item.get('quantity')};
                });

                cart.images[image_obj.id] = stored_image;
            });

            return cart;
        },

        update_quantity: function(image_id, item)
        {
            var remove_item = (parseInt(item.get('quantity')) > 0) ? false : true;
            var image = this.get(image_id);
            if (!image && !remove_item) {
                image = new Ngg_Pro_Cart.Models.Image({
                    pid:     image_id,
                    items:  new Ngg_Pro_Cart.Models.PricelistItemCollection()
                });
                this.add(image);
            }

            if (image) {
                var cart_items = image.get('items');
                var cart_item  = cart_items.get(item.id);
                if (cart_item) {
                    if (remove_item) cart_items.remove(cart_item);
                    else cart_item.set(item.attributes);
                }
                else if (!remove_item) cart_items.add(item.attributes);
                if (cart_items.length == 0) this.remove(image);
            }
            this.trigger('change:quantity');
            this.save();
        },

        item_count: function(){
            var retval = 0;
            this.each(function(image){
                retval += image.get('items').length
            });
            return retval;
        }
    });

    Ngg_Pro_Cart.get_instance = function(){
        if (typeof(Ngg_Pro_Cart['instance']) == 'undefined') {
            Ngg_Pro_Cart.instance = new Ngg_Pro_Cart.Models.Cart();
        }
        return Ngg_Pro_Cart.instance;
    };

    // Define a type of view that has template capabilities
    Ngg_Pro_Cart.Views.TemplateView					= Backbone.View.extend({
        render_template: function(params){
            var template = $('#'+this.template).html();
            for (var key in this.model.attributes) {
                if (typeof(key) == 'string') {
                    var value = this.model.get(key);
                    var placeholder = '{'+this.object_name+'.'+key+'}';
                    while (template.indexOf(placeholder) >= 0) {
                        template = template.replace(placeholder, value);
                    }
                }
            }
            if (typeof(params) != 'undefined') {
                for (var key in params) {
                    var placeholder = '{'+key+'}';
                    while (template.indexOf(placeholder) >= 0) {
                        template = template.replace(placeholder, params[key]);
                    }
                }
            }

            this.$el.html(template);
        }
    });

    // Define the Pricelist Item Row View
    Ngg_Pro_Cart.Views.Item_Row						= Ngg_Pro_Cart.Views.TemplateView.extend({
        tagName: 'tr',
        className: 'ngg_pro_cart_image_item',
        template: 'ngg_pro_cart_item_tmpl',
        object_name: 'item',

        initialize: function(params){
            this.image_id = params.image_id;
            this.model.on('change:quantity', this.update_subtotal, this);
        },

        quantity_changed: function(el){
            var quantity = $(el).val();
            if (quantity.length > 0) {
                quantity = parseInt(quantity);
                this.model.set('quantity', parseInt(quantity));
                Ngg_Pro_Cart.get_instance().update_quantity(this.image_id, this.model);
            }
        },

        update_subtotal: function(){
            this.$el.find('.subtotal_column span').html(sprintf(Ngg_Pro_Cart_Settings.currency_format, this.model.subtotal()));
        },

        render: function(){
            var _this = this;
            this.render_template({
                'image.filename': Ngg_Pro_Cart.get_instance().get(this.image_id).get('filename')
            });

            // Update price
            this.$el.find('.price_column').html(sprintf(Ngg_Pro_Cart_Settings.currency_format, this.model.get('price')));

            // Update subtotal
            this.update_subtotal();

            // Delete button events
            var delete_button = this.$el.find('.ngg_pro_delete_item');
            delete_button.on('click', function(e){
                e.preventDefault();
                _this.collection.remove(_this.model.id);
                _this.model.set('quantity', 0);
                Ngg_Pro_Cart.get_instance().update_quantity(_this.image_id, _this.model);
                _this.$el.fadeOut(400, function(){
                    $(this).remove();
                })
            });

            // Quantity field events
            var quantity_field = this.$el.find('.nggpl-quantity_field');
            quantity_field.on('keyup mouseup touchend change', function(){
                _this.quantity_changed(this);
            });

            return this.el;
        }
    });

    // Define the Image Row View
    Ngg_Pro_Cart.Views.Image_Row 					= Ngg_Pro_Cart.Views.TemplateView.extend({
        tagName: 'tr',
        className: 'ngg_pro_cart_image',
        template: 'ngg_pro_cart_image_tmpl',
        object_name: 'image',

        initialize: function(){
            this.model.get('items').on('remove', this.item_removed, this);
        },

        item_removed: function(e){
            if (this.model.get('items').length == 0) this.$el.fadeOut().remove();
        },

        render: function(){
            this.render_template();
            var items_table = this.$el.find('.ngg_pro_cart_items');
            var items		= this.model.get('items');
            items.each(function(item){
                var item_row = new Ngg_Pro_Cart.Views.Item_Row({model: item, collection: items, image_id: this.model.id});
                items_table.append(item_row.render());
            }, this);
            return this.el;
        }
    });

    // Define Cart View
    Ngg_Pro_Cart.Views.Cart							= Backbone.View.extend({
        el: '#ngg_pro_checkout',

        initialize: function(){
            this.model = Ngg_Pro_Cart.get_instance();
            this.model.on('ready', this.render, this);
            this.model.on('change:quantity change:shipping', this.update_totals, this);
            if (this.model.ready) this.render();
        },

        events: function() {
            // backbone.js doesn't handle touch events correctly, so we must determine if the user
            // has a touch device in advance and only bind to the correct events. Always binding 'click'
            // will cause iOS & Android to invoke redirect_to_checkout when touching anywhere in the
            // add-to-cart container.
            return ('ontouchstart' in document.documentElement) ? {
                'keypress .nggpl-quantity_field' : 'sanitize_quantity'
            } : {
                'keypress .nggpl-quantity_field' : 'sanitize_quantity'
            };
        },

        get_cart_images_el: function(){
            var $images_table = this.$el.find('.ngg_pro_cart_images');

            // Fix IE11 DOM representation
            if ($images_table.length == 0) {
                $images_table = $('.ngg_pro_cart_images').parent().detach();
                this.$el.append($images_table);
                $images_table = this.$el.find('.ngg_pro_cart_images');
            }

            return $images_table;
        },

        fix_ie_dom: function(){
           if (this.$el.find('#ngg_pro_links_wrapper').length == 0) {
               var $links = $('#ngg_pro_links_wrapper').detach();
               this.$el.prepend($links);
           }

           if (this.$el.find('#ngg_pro_checkout_buttons').length == 0) {
               var $buttons = $('#ngg_pro_checkout_buttons').detach();
               this.$el.append($buttons);
           }
        },

        sanitize_quantity: function(e){
            if (!(e.keyCode == 8 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 9 || e.keyCode == 46 || (e.charCode >= 48 && e.charCode <= 57))) {
                e.preventDefault();
                return false;
            }
            return true;
        },

        update_totals: function(urgent){
            if (typeof(urgent) == 'undefined') urgent = false;

            var $images_table = this.get_cart_images_el();

            // Hide/show no items message
            var $no_items = $('#ngg_pro_no_items');
            var $checkout_buttons = $('#ngg_pro_checkout_buttons');
            if (this.model.length > 0) {
                if (urgent) {
                    $images_table.show();
                    $no_items.hide();
                    $checkout_buttons.show();
                }
                else {
                    $images_table.fadeIn('fast');
                    $no_items.fadeOut('fast');
                    $checkout_buttons.fadeIn('fast');
                }

            }
            else {
                if (urgent) {
                    $images_table.hide();
                    $checkout_buttons.hide();
                    $no_items.show();
                }
                else {
                    $images_table.fadeOut('fast');
                    $checkout_buttons.fadeOut('fast');
                    $no_items.fadeIn('fast');
                }
            }

            // Update totals
            this.$el.find('#nggpl-subtotal_field').html(sprintf(Ngg_Pro_Cart_Settings.currency_format, this.model.subtotal()));
            this.$el.find('#nggpl-shipping_field').html(sprintf(Ngg_Pro_Cart_Settings.currency_format, parseFloat(this.model.shipping)));
            this.$el.find('#nggpl-total_field').html(sprintf(Ngg_Pro_Cart_Settings.currency_format, this.model.total()));
        },

        render: function(){
            var _this = this;

            // Re-calculate shipping when "Ship to" field changes
            if (this.model.allow_international_shipping) {
                $('#ship_to_row').show();
                $('#nggpl-ship_to_field select').change(function(){
                    $('#nggpl-shipping_field').text('Calculating...');
                    _this.model.use_home_country =  $(this).val();
                    _this.model.recalculate_shipping();
                });
            }
            else {
               $('#ship_to_row').hide();
            }

            // Display images
            this.model.each(function(image){
                var $images_table = _this.get_cart_images_el();
                var image_row = new Ngg_Pro_Cart.Views.Image_Row({model: image});
                $images_table.append(image_row.render());
            });

            // Update totals
            this.update_totals(true);

            // Fix IE10
            this.fix_ie_dom();

            // Show the cart
            this.$el.css('visibility', 'visible');
        }
    });


    Ngg_Pro_Cart.Views.Add_To_Cart = Backbone.View.extend({
        tagName: 'div',

        id: 'ngg_add_to_cart_container',

        className: 'scrollable',

        events: function() {
            // backbone.js doesn't handle touch events correctly, so we must determine if the user
            // has a touch device in advance and only bind to the correct events. Always binding 'click'
            // will cause iOS & Android to invoke redirect_to_checkout when touching anywhere in the
            // add-to-cart container.
            return ('ontouchstart' in document.documentElement) ? {
                'touchstart #ngg_checkout_btn' : 'redirect_to_checkout',
                'touchstart .nggpl-cart_count' : 'redirect_to_checkout',
                'keypress .nggpl-quantity_field' : 'sanitize_quantity',
                'blur .nggpl-quantity_field': 'quantity_lost_focus',
                'focusout .nggpl-quantity_field': 'quantity_lost_focus',
                'touchstart #ngg_update_cart_btn': 'update_cart'
            } : {
                'click #ngg_checkout_btn' : 'redirect_to_checkout',
                'click .nggpl-cart_count' : 'redirect_to_checkout',
                'keypress .nggpl-quantity_field' : 'sanitize_quantity',
                'click #ngg_update_cart_btn': 'update_cart'
            };
        },

        quantity_lost_focus: function(){
            // On iOS, after the soft keyboard closes, the resize event isn't triggered,
            // and therefore users can't scroll
            var $jq = parent.jQuery; // we have to use the parent's version of jQuery, which has the resize event handlers
            $jq(parent).trigger('resize');
            $('.galleria-sidebar-container').focus();
        },

        update_cart: function(e){
            var image_id = $('#nggpl-items_for_sale table:first').attr('data-image-id');
            $('#nggpl-items_for_sale td.nggpl-quantity_field input').each(function(){
                $(this).trigger('updated_quantity');
            });
            this.update_cart_summary(true);
        },

        sanitize_quantity: function(e){
            var $this = $(e.target);
            if (!(e.keyCode == 8 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 9 || e.keyCode == 46 || (e.charCode >= 48 && e.charCode <= 57))) {
                e.preventDefault();
                return false;
            }
            return true;
        },

        initialize: function(params){
            this.image_id = params.image_id;
            this.container = params.container;
//            Ngg_Pro_Cart.get_instance().on('change:quantity add remove reset', this.update_cart_summary, this);
            Ngg_Pro_Cart.get_instance().on('ready', this.emit_ready, this);
            if (Ngg_Pro_Cart.get_instance().ready) this.emit_ready();
        },

        emit_ready: function(){
            var _this = this;
            setTimeout(function(){
                _this.trigger('ready');
            }, 0);
        },

        redirect_to_checkout: function(){
            var referrer = encodeURIComponent(parent.location.toString());
            var url = Ngg_Pro_Cart_Settings.checkout_url;
            if (url.indexOf('?') > 0) url += "&referrer="+referrer;
            else url += "?referrer="+referrer;
            $.nplModal('close_modal');
            parent.location = url;
        },

        update_cart_summary: function(animate){
            var $summary = this.$el.find('.nggpl-cart_summary');
            $summary.find('.nggpl-cart_count').text(Ngg_Pro_Cart.get_instance().item_count() + ' items');
            $summary.find('.nggpl-cart_total').html(sprintf(Ngg_Pro_Cart_Settings.currency_format, Ngg_Pro_Cart.get_instance().subtotal()));
            if (animate) {
                var $notice = $('<div/>').text(ngg_cart_i18n.nggpl_cart_updated).css({
                    'text-align': 'center',
                    'font-size:': '13px',
                    'color': 'green',
                    'padding-top': '.5em'
                });
                $notice.hide();
                $summary.append($notice);
                $notice.fadeIn().delay(1000).fadeOut(500);
            }
        },

        update_accordion_icons: function(e, ui){
            if (e.type == 'accordioncreate') {
                var i=0;
                $(e.target).find('h3').each(function(){
                    var icon = $(this).find('.ui-accordion-header-icon');
                    icon.addClass('fa');
                    if (i == 0) icon.addClass('fa-minus-square');
                    else icon.addClass('fa-plus-square');
                    i++;
                });

                // When the show licensing terms link is clicked, ensure that
                // we are redirected
                $(e.target).find('.ui-accordion-header').click(function(e){
                    if (e.target.nodeName == 'A') {
                        e.preventDefault();
                        window.open(e.target.href, '_blank');
                    }
                });
            }
            else {
                if (ui.oldHeader) {
                    var icon = ui.oldHeader.find('.ui-accordion-header-icon');
                    icon.addClass('fa').removeClass('fa-minus-square').addClass('fa-plus-square');
                }
                if (ui.newHeader) {
                    var icon = ui.newHeader.find('.ui-accordion-header-icon');
                    icon.addClass('fa').removeClass('fa-plus-square').addClass('fa-minus-square');
                }
            }
        },

        render: function(){
            var existing = $(this.container).find('#'+this.id);
            if (existing.length == 0 || parseInt(existing.attr('data-image-id')) != this.image_id) {
                this.$el.empty();
                this.$el.attr('data-image-id', this.image_id);
                this.$el.append(ngg_add_to_cart_templates.add_to_cart);
                var _this = this;

                // Update cart total
                this.update_cart_summary(false);

                // Render the tables
                var tables = {};
                this.$el.find('.nggpl-pricelist_source_accordion').accordion({heightStyle: 'content', beforeActivate: this.update_accordion_icons, create: this.update_accordion_icons}).find('.nggpl-source_contents').each(function(){
                    var table = new Ngg_Pro_Cart.Views.Add_To_Cart.Items_Table({image_id: _this.image_id});
                    $(this).empty().append(table.render());
                    tables[$(this).attr('id')] = table;
                });

                // Fill the tables with items
                var data = {
                    image_id: this.image_id,
                    action: 'get_image_items',
                    cart:   Ngg_Pro_Cart.instance.to_json()
                };
                $.post(parent.photocrati_ajax.url, data, function(response){
                    if (typeof(response) != 'object') response = JSON.parse(response);

                    // Add items to each table
                    _.each(response, function(item){
                        tables[item.source].items.add(item);
                    }, _this);

                    // Iterate through each table and hide/show based on
                    // the number of items in the table
                    var i=0;
                    var callback = function(i){
                        _this.$el.find('.nggpl-pricelist_source_accordion h3:visible:first').click();
                    };
                    _.each(tables, function(table){
                        i++;
                        if (table.items.length > 0) {
                            if (i == _.size(tables))
                                table.$el.fadeIn(400, callback);
                            else
                                table.$el.fadeIn(400);
                        }

                        // Find the header as well
                        else {
                            var tab_id = table.$el.parent().attr('id');
                            if (i == _.size(tables))
                                $('h3[aria-controls="'+tab_id+'"]').hide(400, callback);
                            else
                                $('h3[aria-controls="'+tab_id+'"]').hide(400);
                        }
                    });

                    // Are there items?
                    if (response.length > 0) {
                        _this.$el.find('#nggpl-not_for_sale').hide();
                        _this.$el.find('#nggpl-items_for_sale').fadeIn().css('display', 'inline-block');
                    }
                    else {
                        _this.$el.find('#nggpl-items_for_sale').fadeOut('fast', function(){
                            _this.$el.find('#nggpl-not_for_sale').show();
                        });
                    }

                    if ($.nplModal('get_setting', 'sidebar_button_color')) {
                        _this.$el.find('#ngg_checkout_btn, #ngg_update_cart_btn').css({'color': $.nplModal('get_setting', 'sidebar_button_color')});
                    }
                    if ($.nplModal('get_setting', 'sidebar_button_background')) {
                        _this.$el.find('#ngg_checkout_btn, #ngg_update_cart_btn').css({'background-color': $.nplModal('get_setting', 'sidebar_button_background')});
                    }
                });

                this.trigger('rendered');
                $(this.container).append(this.el);
            }
        }
    });

    Ngg_Pro_Cart.Views.Add_To_Cart.Items_Table = Backbone.View.extend({
        tagName: 'table',

        class: 'items_table',

        initialize: function(params){
            this.image_id = params.image_id;
            this.items = new Ngg_Pro_Cart.Models.PricelistItemCollection();
            this.items.on('add', this.render_row, this);
        },

        render: function(){
            this.$el.hide();
            this.$el.html(ngg_add_to_cart_templates.add_to_cart_items);
            this.$el.attr('data-image-id', this.image_id);
            return this.el;
        },

        render_row: function(item){
            var row = new Ngg_Pro_Cart.Views.Add_To_Cart.Item_Row({model: item, image_id: this.image_id});
            this.$el.find('tbody').append(row.render());
        }
    });

    Ngg_Pro_Cart.Views.Add_To_Cart.Item_Row = Backbone.View.extend({
        tagName: 'tr',

        // TODO: Uncomment this if we want to auto-update cart again
        events: {
//            'change input':   'update_quantity',
//            'keyup input': 'update_quantity',
            'updated_quantity input': 'update_quantity'
        },

        initialize: function(params){
            this.image_id = params.image_id;
            this.model.on('change:quantity', this.update_subtotal, this);
        },

        render: function(){
            this.$el.html(ngg_add_to_cart_templates.add_to_cart_item);
            this.$el.attr('data-item-id', this.model.id);
            this.$el.find('.nggpl-quantity_field input').val(this.model.get('quantity'));
            this.$el.find('.nggpl-description_field').text(this.model.get('title'));
            this.$el.find('.nggpl-price_field').html(sprintf(Ngg_Pro_Cart_Settings.currency_format, this.model.get('price')));
            this.$el.find('.nggpl-total_field').html(sprintf(Ngg_Pro_Cart_Settings.currency_format, this.model.subtotal()));
            return this.el;
        },

        update_quantity: function(e){
            var quantity = $(e.target).val();
            if (isNaN(quantity)) quantity = 0;
            else quantity = parseInt(quantity);
            this.model.set('quantity', quantity);
            Ngg_Pro_Cart.get_instance().update_quantity(this.image_id, this.model);
        },

        update_subtotal: function(){
            this.$el.find('.nggpl-total_field').html(sprintf(Ngg_Pro_Cart_Settings.currency_format, this.model.subtotal()));
        }
    });

})(jQuery);
