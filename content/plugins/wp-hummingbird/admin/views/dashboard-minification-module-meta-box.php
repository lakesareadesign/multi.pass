<ul class="dev-list dev-list-stats">

	<li class="dev-list-stats-item">
		<div>
			<span class="list-label list-label-stats"><?php _e( 'Total Enqueued Files', 'wphb' ); ?></span>
			<span class="list-detail list-detail-stats list-detail-stats-heading"><?php echo $enqueued_files; ?></span>
		</div>
	</li><!-- end dev-list-stats-item -->

	<li class="dev-list-stats-item">
		<div>
			<span class="list-label list-label-stats list-label-stats-pills"><?php _e( 'Total Size Reductions', 'wphb' ); ?></span>
			<span class="list-detail list-detail-stats">
				<div class="wphb-pills-group">
					<span class="wphb-pills with-arrow right grey"><?php echo $original_size; ?>KB</span>
					<span class="wphb-pills"><?php echo $compressed_size; ?>KB</span>
				</div>
			</span>
		</div>
	</li><!-- end dev-list-stats-item -->

	<li class="dev-list-stats-item">
		<div>
			<span class="list-label list-label-stats"><?php _e( 'Total % Reductions', 'wphb' ); ?></span>
			<span class="list-detail list-detail-stats list-detail-stats-heading"><?php echo $percentage; ?>%</span>
		</div>
	</li><!-- end dev-list-stats-item -->

	<li class="dev-list-stats-item">
		<div>
			<span class="list-label list-label-stats list-label-stats-filename">
				<span class="wphb-filename-extension wphb-filename-extension-js"><?php _e( 'JS', 'wphb' ); ?></span>
				<?php _e( 'Scripts', 'wphb' ); ?>
			</span>
			<span class="list-detail list-detail-stats list-detail-stats-heading"><?php echo $compressed_size_scripts; ?>KB</span>
		</div>
	</li><!-- end dev-list-stats-item -->

	<li class="dev-list-stats-item">
		<div>
			<span class="list-label list-label-stats list-label-stats-filename">
				<span class="wphb-filename-extension wphb-filename-extension-css"><?php _e( 'CSS', 'wphb' ); ?></span>
				<?php _e( 'Stylesheets', 'wphb' ); ?>
			</span>
			<span class="list-detail list-detail-stats list-detail-stats-heading"><?php echo $compressed_size_styles; ?>KB</span>
		</div>
	</li><!-- end dev-list-stats-item -->

</ul>