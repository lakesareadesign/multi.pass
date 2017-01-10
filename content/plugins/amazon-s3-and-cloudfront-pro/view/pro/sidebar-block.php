<?php
$tab              = ( isset( $tab ) ) ? $tab : '';
$show_button      = ( isset( $show_button ) ) ? $show_button : true;
$description      = ( isset( $description ) ) ? $description : false;
$progress_percent = ( isset( $progress_percent ) ) ? $progress_percent : false;
?>
<div id="<?php echo $id; ?>" class="block <?php echo $tab; ?>" data-tab="<?php echo $tab; ?>">
	<div class="block-title-wrap <?php echo ( false !== $description ) ? 'with-description' : ''; ?>">

		<?php if ( false !== $progress_percent ): ?>
			<div class="pie-chart" data-percentage="<?php echo $progress_percent; ?>">
				<svg viewBox="-100 -100 200 200">
					<path d="" />
				</svg>
			</div>
		<?php endif; ?>

		<h4><?php echo $title; ?></h4>

		<?php if ( false !== $description ) : ?>
			<a href="#" class="general-helper"></a>
			<div class="helper-message">
				<?php echo $description; ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( $show_button ) : ?>
		<a href="#" class="as3cf-pro-tool button"><?php echo $button_title; ?></a>
	<?php endif; ?>
</div>
