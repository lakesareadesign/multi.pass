<tr id='tr_<?php print esc_attr("{$id}_{$padding_name}"); ?>'>
    <td>
        <label for="<?php print esc_attr("{$id}_{$padding_name}"); ?>"
               <?php if (!empty($padding_text)) { ?>title='<?php print esc_attr($padding_text); ?>'<?php } ?>
               <?php if (!empty($padding_text)) { ?>class='tooltip'<?php } ?>>
            <?php print $padding_label; ?>
        </label>
    </td>
    <td>
        <input type='number'
               step='any'
               id='<?php print esc_attr("{$id}_{$padding_name}"); ?>'
               name='<?php print esc_attr("{$id}[{$padding_name}]"); ?>'
               class='<?php print esc_attr("{$id}[{$padding_name}]"); ?>'
               min='0'
               value='<?php print esc_attr($padding_value); ?>'/>
        <select id="<?php print esc_attr($id . '_' . $padding_unit_name); ?>"
                name="<?php print esc_attr($id. '[' . $padding_unit_name . ']'); ?>"
                class="<?php print esc_attr($id . '[' . $padding_unit_name . ']'); ?>">
            <?php foreach ($padding_unit_options as $key => $val) { ?>
                <option value='<?php print esc_attr($key); ?>' <?php selected($key, $padding_unit_value); ?>><?php print esc_html__($val); ?></option>
            <?php } ?>
        </select>
    </td>
</tr>