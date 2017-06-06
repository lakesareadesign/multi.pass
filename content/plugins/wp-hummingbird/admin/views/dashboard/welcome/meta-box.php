<div class="wphb-block-entry">

	<div class="wphb-block-entry-image wphb-block-entry-image-bottom">
        <img class="wphb-image"
             src="<?php echo wphb_plugin_url() . 'admin/assets/image/hb-graphic-dash-top.png'; ?>"
             srcset="<?php echo wphb_plugin_url() . 'admin/assets/image/hb-graphic-dash-top@2x.png'; ?> 2x"
             alt="<?php _e('Hummingbird', 'wphb'); ?>">
	</div>

	<div class="wphb-block-entry-third">
        <span class="not-present">
            <?php
            if ( $last_report && ! is_wp_error( $last_report ) ) {
	            $error_class = ( 'aplus' === $last_report->data->score_class || 'a' === $last_report->data->score_class || 'b' === $last_report->data->score_class ) ? 'tick' : 'warning';
                echo $last_report->data->score . "<i class='hb-wpmudev-icon-{$error_class}'></i><span class='score-span'>/100</span>";
            } elseif ( wphb_performance_is_doing_report() ) {
                _e( 'Analyzing...', 'wphb' );
            } else {
                echo '-';
            } ?>
        </span>
		<p class="current-performance-score"><?php _e( 'Current performance score', 'wphb' ); ?></p>
		<span>
            <?php
            if ( $last_report && ! is_wp_error( $last_report ) ) {
                $data_time = strtotime( get_date_from_gmt( date( 'Y-m-d H:i:s', $last_report->data->time ) ) );
                echo date_i18n( get_option( 'date_format' ), $data_time ); ?> <span class="list-detail-stats-heading-extra-info"><?php printf( _x( 'at %s', 'Time of the last performance report', 'wphb' ), date_i18n( get_option( 'time_format' ), $data_time ) );
            } elseif ( wphb_performance_is_doing_report() ) {
                    _e( 'Running scan...', 'wphb' );
            } else {
                _e( 'Never', 'wphb' );
            } ?>
        </span>
		<p><?php _e( 'Last test date', 'wphb' ); ?></p>
	</div>

	<div class="wphb-block-entry-third">
		<ul class="dev-list">
			<li>
				<span class="list-label"><?php _e( 'Browser Caching', 'wphb' ); ?></span>
				<span class="list-detail">
                    <?php if ( $cf_active ) : ?>
                        <?php if ( $cf_current === 691200 ) : ?>
                            <span class="status-ok">&nbsp;</span>
                        <?php else : ?>
                            <div class="wphb-pills">!</div>
                        <?php endif; ?>
                    <?php else : ?>
                        <?php if ( $caching_issues ) : ?>
                            <div class="wphb-pills"><?php echo intval( $caching_issues ); ?></div>
                        <?php else : ?>
                            <span class="status-ok">&nbsp;</span>
                        <?php endif; ?>
                    <?php endif; ?>
				</span>
			</li>
			<li>
				<span class="list-label"><?php _e( 'GZIP Compression', 'wphb' ); ?></span>
				<span class="list-detail">
					<?php if ( $gzip_issues ) : ?>
						<div class="wphb-pills"><?php echo intval( $gzip_issues ); ?></div>
					<?php else : ?>
						<span class="status-ok">&nbsp;</span>
					<?php endif; ?>
				</span>
			</li>
			<li>
				<span class="list-label"><?php _e( 'Last Down', 'wphb' ); ?></span>
				<span class="list-detail">
					<?php if ( ! wphb_is_member() ) : ?>
						<a class="button button-content-cta button-ghost" href="#wphb-upgrade-membership-modal" id="dash-uptime-update-membership" rel="dialog"><?php _e( 'Pro Feature', 'wphb' ); ?></a>
					<?php elseif ( is_wp_error( $uptime_report ) || ( ! $uptime_active ) ) : ?>
						<a target="_blank" class="button button-disabled" id="dash-uptime-inactive"><?php _e( 'Uptime Inactive', 'wphb' ); ?></a>
                    <?php else:
                        echo $site_date;
					endif; ?>
				</span>
			</li>
		</ul>
	</div>

</div><!-- end wphb-block-entry -->