<tr class="form-field">
	<th scope="row" valign="top">
		<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?>:</label>
	</th>
	<td>
		<?php

		if ( 'text' === $type ) {

			?>
			<input name="<?php echo esc_attr( $id ); ?>"
			       id="<?php echo esc_attr( $id ); ?>" type="text"
			       value="<?php echo isset( $val ) ? esc_attr( $val ) : ''; ?>"
			       size="40"/>
			<p class="description"><?php echo esc_html( $desc ); ?></p>
			<?php

		} elseif ( 'checkbox' === $type ) {

			?>
			<input name="<?php echo esc_attr( $id ); ?>"
			       id="<?php echo esc_attr( $id ); ?>"
			       type="checkbox" <?php checked( $val ); ?>
			       style="width:5%;"/>
			<?php
		}

		?>
	</td>
</tr>