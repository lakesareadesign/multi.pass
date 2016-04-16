jQuery(function($) {
    "use strict";

    $('input[name="photocrati-nextgen_pro_mosaic[lazy_load_enable]"]')
        .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_mosaic_lazy_load_initial'))
        .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_mosaic_lazy_load_batch'));
});