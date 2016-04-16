<a href="javascript:void(0)"
   id="ngg_cheque_button"
   data-processing-msg="<?php esc_attr($i18n->processing_msg)?>"
   data-submit-msg="<?php esc_attr($i18n->button_text)?>"
   class="ngg_pro_btn"><?php esc_html_e($i18n->button_text); ?></a>

<div id="ngg_cheque_form_container" style="display: none;">
    <h3><?php echo $i18n->headline; ?></h3>

        <a href="javascript:void(0)"
           id="ngg_cheque_button_cancel"
           title="<?php esc_html_e($i18n->button_text_cancel); ?>"><span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-times fa-stack-1x"></i></span></a>

        <div id="nextgen_cheque_customer_name">
            <span><i class="fa fa-fw fa-user"></i></span>
            <input id="customer_name" required type="text" name="customer_name" placeholder='<?php echo $i18n->field_name; ?>'/>
        </div>

        <div id="nextgen_cheque_customer_email">
            <span><i class="fa fa-fw fa-envelope"></i></span>
            <input id="customer_email" required type="email" name="customer_email" placeholder="<?php echo $i18n->field_email; ?>"/>
        </div>

        <div id="nextgen_cheque_customer_address">
            <span><i class="fa fa-fw fa-map-marker"></i></span>
            <input id="customer_address" required type="text" name="customer_address" placeholder="<?php echo $i18n->field_address; ?>"/>
        </div>

        <div id="nextgen_cheque_customer_city">
            <input id="customer_city" required type="text" name="customer_city" placeholder="<?php echo $i18n->field_city; ?>"/>
        </div>

        <div id="nextgen_cheque_customer_state">
            <input id="customer_state" required type="text" name="customer_state" placeholder="<?php echo $i18n->field_state; ?>"/>
        </div>

        <div id="nextgen_cheque_customer_postal">
            <input id="customer_postal" required type="text" name="customer_postal" placeholder="<?php echo $i18n->field_postal; ?>"/>
        </div>

        <div id="nextgen_cheque_customer_country">
            <select id="customer_country" name="customer_country">
                <option value="" selected disabled><?php echo $i18n->field_country; ?></option>
                <?php foreach ($countries as $country) { ?>
                    <option value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div id="ngg_cheque_buttons">
            <a href="javascript:void(0)"
               id="ngg_cheque_button_submit"
               class="ngg_pro_btn"><?php esc_html_e($i18n->button_text_submit); ?>&nbsp;<i class="fa fa-arrow-circle-right"></i></a>
        </div>
</div>