<ul class="dev-list dev-list-stats">
    <div class="content">
        <p><?php _e( 'Compress, combine and position your assets to dramatically improve your page load speed.', 'wphb' ); ?></p>
    </div>


    <li class="dev-list-stats-item">
        <span class="list-label list-label-stats"><?php _e( 'Total Enqueued Files', 'wphb' ); ?></span>
        <span class="list-detail list-detail-stats list-detail-stats-heading"><?php echo $enqueued_files; ?></span>
    </li>

    <li class="dev-list-stats-item">
        <span class="list-label list-label-stats list-label-stats-pills"><?php _e( 'Total Size Reductions', 'wphb' ); ?></span>
        <span class="list-detail list-detail-stats">
            <div class="wphb-pills-group">
                <span class="wphb-pills with-arrow right grey"><?php echo $original_size; ?>KB</span>
                <span class="wphb-pills"><?php echo $compressed_size; ?>KB</span>
            </div>
        </span>
    </li><!-- end dev-list-stats-item -->

    <li class="dev-list-stats-item">
        <span class="list-label list-label-stats"><?php _e( 'Total % Reductions', 'wphb' ); ?></span>
        <span class="list-detail list-detail-stats list-detail-stats-heading"><?php echo $percentage; ?>%</span>
    </li><!-- end dev-list-stats-item -->

    <li class="dev-list-stats-item">
        <span class="list-label list-label-stats list-label-stats-filename">
            <span class="wphb-filename-extension wphb-filename-extension-js"><?php _e( 'JS', 'wphb' ); ?></span>
            <p><?php _e( 'Scripts', 'wphb' ); ?></p>
        </span>
        <span class="list-detail list-detail-stats list-detail-stats-heading"><?php echo $compressed_size_scripts; ?>KB</span>
    </li><!-- end dev-list-stats-item -->

    <li class="dev-list-stats-item">
        <span class="list-label list-label-stats list-label-stats-filename">
            <span class="wphb-filename-extension wphb-filename-extension-css"><?php _e( 'CSS', 'wphb' ); ?></span>
            <p><?php _e( 'Stylesheets', 'wphb' ); ?></p>
        </span>
        <span class="list-detail list-detail-stats list-detail-stats-heading"><?php echo $compressed_size_styles; ?>KB</span>
    </li><!-- end dev-list-stats-item -->
</ul>

<div class="buttons">
    <a href="<?php echo esc_url( $minification_url ); ?>" class="button button-ghost" name="submit"><?php esc_attr_e( 'Configure', 'wphb' ); ?></a>
</div>