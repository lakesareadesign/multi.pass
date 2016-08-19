(function($) {
    WPHB_Admin.gzip = {
        module: "gzip",
        selectedServer: "",
        $serverSelector: null,
        $serverInstructions: [],
        init: function() {
            var self = this;
            if (wphbGZipStrings) self.strings = wphbGZipStrings;
            this.$serverSelector = $("#wphb-server-type");
            this.selectedServer = this.$serverSelector.val();
            var instructionsList = $(".wphb-server-instructions");
            instructionsList.each(function(i, element) {
                self.$serverInstructions[$(this).data("server")] = $(this);
            });
            this.showServerInstructions(this.selectedServer);
            this.$serverSelector.change(function() {
                var value = $(this).val();
                self.hideCurrentInstructions();
                self.showServerInstructions(value);
                self.setServer(value);
                self.selectedServer = value;
            });
            $("#toggle-apache-instructions").click(function(e) {
                e.preventDefault();
                $(".apache-instructions").toggle();
            });
            $("#toggle-litespeed-instructions").click(function(e) {
                e.preventDefault();
                $(".litespeed-instructions").toggle();
            });
            return this;
        },
        hideCurrentInstructions: function() {
            var selected = this.selectedServer;
            if (this.$serverInstructions[selected]) {
                this.$serverInstructions[selected].hide();
            }
        },
        showServerInstructions: function(server) {
            if (typeof this.$serverInstructions[server] != "undefined") {
                this.$serverInstructions[server].show();
            }
            if ("apache" == server || 'LiteSpeed' == server) {
                $("#enable-cache-wrap").show();
            } else {
                $("#enable-cache-wrap").hide();
            }
        },
        setServer: function(value) {
            var self = this;
            $.ajax({
                url: ajaxurl,
                method: "POST",
                data: {
                    action: "wphb_ajax",
                    wphb_nonce: self.strings.setServerNonce,
                    nonce_name: "wphb-set-server",
                    module: self.module,
                    module_action: "set_server_type",
                    data: {
                        type: value
                    }
                }
            });
        },
    };
})(jQuery);