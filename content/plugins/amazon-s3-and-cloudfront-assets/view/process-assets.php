<?php
$title              = isset( $title ) ? $title : '';
$more_info          = isset( $more_info ) ? $more_info : '';
$progress_percent   = isset( $progress_percent ) ? (int) $progress_percent : 0;
$is_queued          = isset( $is_queued ) ? $is_queued : false;
$status_description = isset( $status_description ) ? $status_description : '';
$button             = isset( $button ) ? $button : '';
$next_scan          = isset( $next_scan ) ? $next_scan: '';
$scan_allowed       = isset( $scan_allowed ) ? $scan_allowed : false;
$purge_allowed      = isset( $purge_allowed ) ? $purge_allowed : false;
?>

<div class="block-title-wrap <?php echo ! empty( $more_info ) ? 'with-description' : ''; ?>">
	<h4 class="block-title"><?php echo $title; ?></h4>

	<?php if ( ! empty ( $more_info ) ) : ?>
		<a href="#" class="general-helper"></a>
		<div class="helper-message">
			<?php echo $more_info; ?>
		</div>
	<?php endif; ?>
</div>

<?php if ( ! empty( $status_description ) ) : ?>
	<p class="block-description">
		<?php echo $status_description; ?>
	</p>
<?php endif; ?>

<div class="progress-bar-wrapper" style="display: <?php echo $is_queued ? 'block' : 'none'; ?>;">
	<div class="progress-bar" style="width: <?php echo esc_attr( $progress_percent ); ?>%;"></div>
</div>

<p class="next-scan">
	<?php echo $next_scan; ?>
</p>

<?php if ( ! empty( $button ) ) : ?>
	<div class="button-wrapper">
		<a href="#" id="as3cf-assets-manual-scan" class="scan button <?php echo ( $is_queued || ! $scan_allowed ) ? 'disabled' : ''; ?>" data-busy-description="<?php _e( 'Scanning and uploading files to S3.', 'as3cf-assets' ); ?>">
			<?php echo $button; ?>
		</a>

		<a href="#" id="as3cf-assets-manual-purge" class="purge button <?php echo ( $is_queued || ! $purge_allowed ) ? 'disabled' : ''; ?>" data-busy-description="<?php _e( 'Purging files from S3.', 'as3cf-assets' ); ?>">
			<?php echo esc_html_x( 'Purge', 'Remove all files from S3', 'as3cf-assets' ); ?>
		</a>
	</div>
<?php endif; ?>