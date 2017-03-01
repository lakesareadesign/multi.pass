
<tr class="form-field">
	<th scope="row" valign="top"><label for="<?php echo $id; ?>"><?php echo $label; ?>:</label></th>
	<td>
	<?php

	if ( $type === 'text' ) {

	?>
		<input name="<?php echo $id; ?>" id="<?php echo $id; ?>" type="text" value="<?php if (isset($val)) echo $val; ?>" size="40"/>
		<p class="description"><?php echo $desc; ?></p>
	<?php

	} elseif ( $type === 'checkbox' ) {

	?>
		<input name="<?php echo $id; ?>" id="<?php echo $id; ?>" type="checkbox" <?php checked($val); ?> style="width:5%;" />
	<?php

	}

	?>
	</td>
</tr>