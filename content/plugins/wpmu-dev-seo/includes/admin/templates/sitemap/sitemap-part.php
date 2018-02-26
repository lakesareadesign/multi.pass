<?php
	$part_excluded = ! empty( $_view['options'][ $item ] );
	$part_checked = $part_excluded ? 'checked="checked"' : '';
	$inverted = empty( $inverted ) ? false : $inverted;
?>
<div class="wds-sitemap-part">
	<span class="wds-sitemap-part-label">
		<label
			class="wds-label wds-label-inline"
			for="<?php echo esc_attr( $item ); ?>">
			<?php echo $item_label; ?>
		</label>
	</span>
	<?php if ( ! empty( $item_name ) ) :  ?>
		<span class="wds-sitemap-part-name">
			<?php echo $item_name; ?>
		</span>
	<?php endif; ?>
	<span class="wds-sitemap-part-toggle">
		<span class="toggle wds-toggle <?php echo $inverted ? 'wds-inverted-toggle' : ''; ?>">
			<input
				class="toggle-checkbox"
				value='<?php echo esc_attr( $item ); ?>'
				<?php echo $part_checked; ?>
				id='<?php echo esc_attr( $item ); ?>'
				name="<?php echo esc_attr( $option_name ); ?>"
				type='checkbox'/>

			<label class="toggle-label" for="<?php echo $item; ?>"></label>
		</span>
	</span>
</div>