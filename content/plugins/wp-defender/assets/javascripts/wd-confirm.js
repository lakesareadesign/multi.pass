/*!
 * jquery.confirm
 *
 * @version 2.3.1
 *
 * @author My C-Labs
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 * @author Russel Vela
 * @author Marcus Schwarz <msspamfang@gmx.de>
 *
 * @license MIT
 * @url https://myclabs.github.io/jquery.confirm/
 */
(function ($) {

    /**
     * Confirm a link or a button
     * @param [options] {{title, text, confirm, cancel, confirmButton, cancelButton, post, confirmButtonClass}}
     */
    $.fn.wd_confirm = function (options) {
        if (typeof options === 'undefined') {
            options = {};
        }

        this.click(function (e) {
            e.preventDefault();

            var newOptions = $.extend({
                button: $(this)
            }, options);

            $.wd_confirm(newOptions, e);
        });

        return this;
    };

    /**
     * Show a confirmation dialog
     * @param [options] {{title, text, confirm, cancel, confirmButton, cancelButton, post, confirmButtonClass}}
     * @param [e] {Event}
     */
    $.wd_confirm = function (options, e) {
        // Do nothing when active confirm modal.
        if ($('.confirmation-modal').length > 0)
            return;

        // Parse options defined with "data-" attributes
        var dataOptions = {};
        if (options.button) {
            var dataOptionsMapping = {
                'title': 'title',
                'text': 'text',
                'confirm-button': 'confirmButton',
                'cancel-button': 'cancelButton',
                'confirm-button-class': 'confirmButtonClass',
                'cancel-button-class': 'cancelButtonClass',
                'dialog-class': 'dialogClass'
            };
            $.each(dataOptionsMapping, function (attributeName, optionName) {
                var value = options.button.data(attributeName);
                if (value) {
                    dataOptions[optionName] = value;
                }
            });
        }

        // Default options
        var settings = $.extend({}, $.wd_confirm.options, {
            confirm: function () {

            },
            button: null
        }, dataOptions, options);

        var modalHTML =
            '<div class="wd-confirm-dialog">' +
            '<div class="wd-confirm-dialog-inner">' +
            '<p>' + settings.text + '</p>' +
            '<div class="wd-confirm-buttons">' +
            '<a class="button wd-button block wd-confirm" href="#">' + settings.confirmButton + '</a>' +
            '<a class="button button-grey block wd-cancel" href="#">' + settings.cancelButton + '</a>' +
            '</div>' +
            '</div>' +
            '</div>';

        var modal = $(modalHTML);

        modal.find(".wd-confirm").click(function (e) {
            e.preventDefault();
            settings.confirm(modal, e);
        });
        modal.find(".wd-cancel").click(function () {
            modal.removeClass('is-visible');
        });

        // Show the modal
        var most = $('.wp-defender').first();
        most.find('.wd-confirm-dialog').remove();
        most.append(modal);
        modal.addClass('is-visible');
    };

    /**
     * Globally definable rules
     */
    $.wd_confirm.options = {
        text: "Are you sure?",
        title: "",
        confirmButton: "Yes",
        cancelButton: "Cancel",
        post: false,
        confirmButtonClass: "btn-primary",
        cancelButtonClass: "btn-default",
        dialogClass: "modal-dialog"
    }
}(jQuery));
