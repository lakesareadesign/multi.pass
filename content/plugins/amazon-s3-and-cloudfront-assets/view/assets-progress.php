<?php
$tab              = isset( $tab ) ? $tab : '';
$title            = isset( $title ) ? $title : __( 'Assets Status', 'as3cf-assets' );
$description      = isset( $description ) ? $description : false;
$progress_percent = isset( $progress_percent ) ? $progress_percent : 0;
$next_scan        = empty( $next_scan ) ? '' : $next_scan;
$scan_allowed     = empty( $scan_allowed ) ? false : $scan_allowed;
$purge_allowed    = empty( $purge_allowed ) ? false : $purge_allowed;
?>

<div id="<?php echo esc_attr( $id ); ?>" class="block <?php echo esc_attr( $tab ); ?>" data-tab="<?php echo esc_attr( $tab ); ?>">
	<div class="block-title-wrap <?php echo ( false !== $description ) ? 'with-description' : ''; ?>">
		<h4><?php echo esc_html( $title ); ?></h4>

		<p class="block-description">
			<?php if ( false !== $description ) : ?>
				<?php echo wp_kses_post( $description ); ?>
			<?php endif; ?>
		</p>

		<?php if ( false !== $progress_percent ) : ?>
			<div class="progress-bar-wrapper <?php echo ( 100 === ( int ) $progress_percent ) ? 'complete' : ''; ?>" data-percentage="<?php echo esc_attr( $progress_percent ); ?>" data-scanning="<?php echo esc_attr( $this->is_scanning() ); ?>" data-purging="<?php echo esc_attr( $this->is_purging() ); ?>" data-processing="<?php echo esc_attr( $this->is_processing() ); ?>" style="display: none;">
				<div class="progress-bar"></div>
			</div>
		<?php endif; ?>

		<p class="next-scan">
			<?php echo $next_scan; ?>
		</p>

		<a href="#" id="as3cf-assets-manual-scan" class="as3cf-manual-button button <?php echo ( $this->is_scanning() || $this->is_purging() || ! $scan_allowed ) ? 'disabled' : ''; ?>">
			<?php echo esc_html_x( 'Scan Now', 'Scan the filesystem for files to upload to S3', 'as3cf-assets' ); ?>
		</a>

		<a href="#" id="as3cf-assets-manual-purge" class="as3cf-manual-button button <?php echo ( $this->is_scanning() || $this->is_purging() || ! $purge_allowed ) ? 'disabled' : ''; ?>">
			<?php echo esc_html_x( 'Purge', 'Remove all files from S3', 'as3cf-assets' ); ?>
		</a>
	</div>
</div>
