window.Wds = window.Wds || {};

/**
 * General scoped variable getter
 *
 * @param {String} scope Scope to check for variable
 * @param {String} string Particular varname
 *
 * @return {String} Found value or false
 */
window.Wds.get = window.Wds.get || function (scope, varname) {
	scope = scope || 'general';
	return (window['_wds_' + scope] || {})[varname] || false;
}

/**
 * Fetch localized string for a particular context
 *
 * @param {String} scope Scope to check for strings
 * @param {String} string Particular string to check for
 *
 * @return {String} Localized string
 */
window.Wds.l10n = window.Wds.l10n || function (scope, string) {
	return (Wds.get(scope, 'strings') || {})[string] || string;
}

/**
 * Fetch template for a particular context
 *
 * @param {String} scope Scope to check for templates
 * @param {String} string Particular template to check for
 *
 * @return {String} Template markup
 */
window.Wds.template = window.Wds.template || function (scope, template) {
	return (Wds.get(scope, 'templates') || {})[template] || '';
}

/**
 * Compiles the template using underscore templaing facilities
 *
 * This is a simple wrapper with templating settings override,
 * Used because of the PHP ASP tags issues with linters and
 * deprecated PHP setups.
 *
 * @param {String} tpl Template to expand
 * @param {Object{ obj Optional data object
 *
 * @return {String} Compiled template
 */
window.Wds.tpl_compile = function (tpl, obj) {
	var setup = _.templateSettings,
		value
	;
	_.templateSettings = {
		evaluate:    /\{\{(.+?)\}\}/g,
        interpolate: /\{\{=(.+?)\}\}/g,
        escape: /\{\{-(.+?)\}\}/g
	};
	value = _.template(tpl, obj);
	_.templateSettings = setup;
	return value;
}

window.Wds.qtips = function ($elements) {
	var $ = jQuery;
	$elements.each(function () {
		$element = $(this);
		$element.qtip(
			$.extend({
				style: {
					classes: 'wds-qtip qtip-rounded'
				},
				position: {
					my: 'bottom center',
					at: 'top center'
				}
			}, $element.data())
		);
	});
};

window.Wds.hook_toggleables = function () {
	var $ = jQuery,
		toggleable = '.wds-toggleable';
	$(".toggle-checkbox", $(toggleable)).not(".wds-toggleable-inside *").on("change", function (e) {
		var $checkbox = $(this),
			$toggleable = $checkbox.closest(toggleable),
			is_inverted = $toggleable.is('.inverted'), // An inverted toggleable is in active state when the controlling checkbox is unchecked
			is_active = $checkbox.is(":checked");

		is_active = is_inverted ? !is_active : is_active;

		if (is_active) {
			$toggleable.removeClass("inactive");
		}
		else {
			$toggleable.addClass("inactive");
		}

		window.Wds.readjust_vertical_tabs_height();

		return false;
	});
};

window.Wds.hook_conditionals = function () {
	var root_selector = '.wds-conditional',
		$ = jQuery;

	function show_conditional_elements($select) {
		var $root = $select.closest(root_selector);

		$.each($root.find('.wds-conditional-inside'), function (index, conditional_el) {
			var $conditional_el = $(conditional_el);

			if ($conditional_el.data('conditional-val') == $select.val()) {
				$conditional_el.show();
			}
			else {
				$conditional_el.hide();
			}

			window.Wds.readjust_vertical_tabs_height();
		});
	}

	var $selects = $("select", $(root_selector)).not(".wds-conditional-inside *");

	$.each($selects, function (index, select) {
		show_conditional_elements($(select));

		$(select).change(function () {
			show_conditional_elements($(this));
			return false;
		});
	});
};

window.Wds.readjust_vertical_tabs_height = function () {
	// Click the current tab for height recalculation
	if (jQuery(".vertical-tabs").length) {
		jQuery('[name="wds-admin-active-tab"]:checked').click();
	}
};

window.Wds.accordion = function(end_callback) {
	var $ = jQuery;

	$(document).on('click', '.wds-accordion-handle', function () {
		var $handle = $(this),
			$accordion = $handle.closest('.wds-accordion'),
			$section = $handle.closest('.wds-accordion-section');

		if ($section.is('.disabled')) {
			return;
		}

		if ($section.is('.open')) {
			$section.removeClass('open');
		} else {
			$accordion.find('.open').removeClass('open');
			$section.addClass('open');
		}

		window.Wds.readjust_vertical_tabs_height();

		if(end_callback){
			end_callback();
		}
	});
};

window.Wds.link_dropdown = function(){
	var $ = jQuery;

	function close_all_dropdowns($except)
	{
		var $dropdowns = $('.wds-links-dropdown');
		if($except) {
			$dropdowns = $dropdowns.not($except);
		}
		$dropdowns.removeClass('open');
	}

	$('body').click(function (e) {
		var $this = $(e.target),
			$el = $this.closest('.wds-links-dropdown');

		if ($el.length == 0) {
			close_all_dropdowns();
		}
		else if ($this.is('a')) {
			e.preventDefault();
			close_all_dropdowns($el);

			$el.toggleClass('open');
		}
	});
};

window.Wds.media_url = function ($root) {
	var $ = jQuery,
		$button = $root.find('.wds-media-url-button'),
		$field = $root.find('.wds-media-url-field'),
		idx = $root.data('name');

	if (!(wp || {}).media) {
		return;
	}

	wp.media.frames.wds_media_url = wp.media.frames.wds_media_url || {};
	wp.media.frames.wds_media_url[idx] = wp.media.frames.wds_media_url[idx] || new wp.media({
			multiple: false,
			library: {type: 'image'}
		});

	$button.click(function (e) {
		if (e && e.preventDefault) e.preventDefault();
		wp.media.frames.wds_media_url[idx].open();

		return false;
	});

	wp.media.frames.wds_media_url[idx].on('select', function () {
		var selection = wp.media.frames.wds_media_url[idx].state().get('selection'),
			url = '';

		if (!selection) {
			return false;
		}

		selection.each(function (model) {
			url = model.get("url");
		});

		if (!url) {
			return false;
		}

		$field.val(url);
	});
};

window.Wds.styleable_file_input = function ($root) {
	var $ = jQuery,
		$file_input = $root.find('input[type="file"]'),
		$readonly_input = $root.find('input[readonly]');

	function get_file_name(path) {
		if (!path) {
			return '';
		}

		return path.split('\\').pop();
	}

	$readonly_input.val(
		get_file_name($file_input.val())
	);

	$file_input.on('change', function () {
		var file = get_file_name($(this).val());
		$readonly_input.val(file);
	});
};

window.Wds.styleable_checkbox = function ($element) {
	var $ = jQuery;
	$element.each(function () {
		var $checkbox = $(this);

		if ($checkbox.closest('.wds-checkbox-container').length) {
			return;
		}

		$checkbox.wrap('<div class="wds-checkbox-container">');
		$checkbox.wrap('<label>');
		$checkbox.after('<span></span>');
	});
};

window.Wds.optimum_length_indicator = function ($element, lower, upper) {
	var $ = jQuery,
		offset = 8 / 100 * upper,
		almost_lower = lower + offset,
		almost_upper = upper - offset,
		field_class = 'wds-optimum-length-indicator-field',
		field_selector = '.' + field_class,
		indicator_class = 'wds-optimum-length-indicator',
		indicator_selector = '.' + indicator_class;

	if ($element.is(field_selector) || !$element.is('input,textarea')) {
		return;
	}

	$element.addClass(field_class);
	$('<div></div>').addClass(indicator_class).insertAfter($element);

	function reset_classes() {
		$element.removeClass('over almost-over just-right almost-under under');
	}

	var update_indicator = function () {
		var $this = $(this),
			value = $this.val(),
			length = value.length,
			ideal_length = (upper + lower) / 2,
			percentage = length / ideal_length * 100;

		// When the length is equal to mean, the progress bar should be in the center instead of the end. Therefore:
		percentage = percentage / 2;
		percentage = percentage > 100 ? 100 : percentage;

		$element.next(indicator_selector).width(percentage + '%');

		reset_classes();

		if (length > upper) {
			$element.addClass('over');
		}
		else if (almost_upper < length && length <= upper) {
			$element.addClass('almost-over');
		}
		else if (almost_lower <= length && length <= almost_upper) {
			$element.addClass('just-right');
		}
		else if (lower <= length && length < almost_lower) {
			$element.addClass('almost-under');
		}
		else if (lower > length) {
			$element.addClass('under');
		}
	};

	update_indicator.apply($element);
	$element.on('input propertychange', update_indicator);
};

window.Wds.dismissible_message = function () {
	var $ = jQuery;

	function remove_message(event) {
		event.preventDefault();

		var $dismiss_link = $(this),
			$message_box = $dismiss_link.closest('.wds-mascot-message, .wds-notice'),
			message_key = $message_box.data('key');

		$message_box.remove();
		if (message_key) {
			$.post(
				ajaxurl,
				{
					action: 'wds_dismiss_message',
					message: message_key,
                	_wds_nonce: _wds_admin.nonce
				},
				'json'
			);
		}
	}

	$(document).on('click', '.wds-mascot-bubble-dismiss, .wds-notice-dismiss', remove_message);
};

window.Wds.hook_user_search = function () {
	var $ = jQuery;

	function add_new_user(e) {
		e.preventDefault();

		var $add_button = $(e.target),
			$container = $add_button.closest('.wds-user-search'),
			$select2 = $container.find('.wds-user-search-field select'),
			params = {
				option_name: $container.data('optionName'),
				users_key: $container.data('usersKey'),
				new_user_key: $container.data('newUserKey'),
				action: 'wds-user-search-add-user',
                _wds_nonce: _wds_admin.nonce
			},
			data = $container.find('input, select').serialize() + '&' + $.param(params);

		$add_button.prop("disabled", true);
		$select2.prop("disabled", true);

		$.post(ajaxurl, data, function (data) {
			data = (data || {});

			if (data.success) {
				var $new_user_search = $(data.user_search);
				$container.replaceWith($new_user_search);
				initialize_select2($new_user_search.find('select'));
				window.Wds.readjust_vertical_tabs_height();
			}
			else {
				$add_button.prop("disabled", false);
				$select2.prop("disabled", false);
			}
		}, 'json');
	}

	function initialize_select2($select) {
		$select.select2({
			ajax: {
				url: ajaxurl,
				dataType: 'json',
				delay: 500,
                type:'POST',
				data: function (params) {
					return {
						action: 'wds-user-search',
						query: params.term,
						page: params.page,
						_wds_nonce: _wds_admin.nonce
					};
				},
				processResults: function (data) {
					return {
						results: (data || {}).items
					};
				},
				cache: true
			},
			minimumInputLength: 2
		});
	}

	function remove_user(e) {
		if (e && e.preventDefault) e.preventDefault();
		$(this).closest('li').remove();
	}

	initialize_select2(
		$('.wds-user-search select')
	);

	$(document)
		.on('click', '.wds-user-search input[type="button"]', add_new_user)
		.on('click', '.wds-user-search a[href="#remove-user"]', remove_user);
};

window.Wds.update_progress_bar = function ($element, value) {
	if (!$element.is('.wds-progress')) {
		return;
	}

	$element.data('progress', value);
	$element.find('.wds-progress-bar-current-percent').html(value + '%');
	$element.find('.wds-progress-bar-inside').width(value + '%');
};

window.Wds.upsell = function () {
	var $ = jQuery;
	
	function do_upgrade_action() {
		var $button = $(this);

		window.open($button.data('target'), '_blank');
	}

	function open_upsell_modal(e) {
		e.preventDefault();
		
		WDP.showOverlay('#wds-upsell-modal');
		WDP.overlay.box_content.on('click', '.wds-navigate-to-pro', do_upgrade_action);
	}

	$(document).on('click', 'a[href=#upgrade-to-pro], .wds-upgrade-button', open_upsell_modal);
};

window.Wds.conditional_fields = function () {
	var $ = jQuery;

	function handle_conditional($child) {
		var parent = $child.data('parent'),
			$parent = $('#' + parent),
			parent_val = $child.data('parentVal'),
			values = [];

		if (parent_val.indexOf(',') != -1) {
			values = parent_val.split(',');
		}
		else {
			values.push(parent_val);
		}

		if (values.indexOf($parent.val()) == -1) {
			$child.hide();
		}
		else {
			$child.show();
		}
	}

	$('.wds-conditional-child').each(function () {
		handle_conditional(
			$(this)
		);
	});

	$('.wds-conditional-parent').on('change', function () {
		var $parent = $(this),
			parent_id = $parent.attr('id'),
			$children = $('[data-parent="' + parent_id + '"]');

		$children.each(function () {
			handle_conditional(
				$(this)
			);
		});
	});
};

window.Wds.floating_message = function () {
	setTimeout(function () {
		jQuery('.wds-notice-floating').hide();
	}, 5000);
};

/**
 * Gets cookie value.
 * Source: https://www.quirksmode.org/js/cookies.html
 *
 * @param {String} name Cookie key to get.
 *
 * @return {String}|{Null} Value.
 */
window.Wds.get_cookie = function (name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
};

/**
 * Sets cookie value.
 * Source: https://www.quirksmode.org/js/cookies.html
 *
 * @param {String} name Cookie key to set.
 * @param {String} value Value to set.
 * @param {Number} name Cookie expiration time.
 */
window.Wds.set_cookie = function (name, value, days) {
	var expires = "";
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days*24*60*60*1000));
		expires = "; expires=" + date.toUTCString();
	}
	document.cookie = name + "=" + (value || "")  + expires + "; path=/";
};

/**
 * Expires a cookie
 * Source: https://www.quirksmode.org/js/cookies.html
 *
 * @param {String} name Cookie key to expire.
 */
window.Wds.delete_cookie = function (name) {
	document.cookie = name+'=; Max-Age=-99999999;';
};

(function ($, undefined) {
	function init() {
		window.Wds.floating_message();
	}

	$(init);
})(jQuery);
