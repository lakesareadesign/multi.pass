<table class="list-table wphb-table stack dashboard-performance-report-table">

    <div class="content">
        <p><?php _e( 'Here are your latest performance test results. A score above 85 is considered a good benchmark.', 'wphb' ); ?></p>
    </div>

    <thead>
        <tr class="wphb-performance-report-item-heading">
            <th class="wphb-performance-report-heading wphb-performance-report-heading-recommendation"><?php _e( 'Recommendation', 'wphb' ); ?></th>
            <th class="wphb-performance-report-heading wphb-performance-report-heading-score"><?php _e( 'Score /100', 'wphb' ); ?></th>
            <th class="wphb-performance-report-heading wphb-performance-report-heading-action">&nbsp;</th>
        </tr><!-- end wphb-performance-report-item-heading -->
    </thead>

    <tbody>
    <?php foreach ( $report->rule_result as $rule => $rule_result ): ?>
        <tr class="wphb-performance-report-item">
            <td class="wphb-performance-report-item-recommendation">
                <?php echo $rule_result->label; ?>
            </td><!-- end wphb-performance-report-item-recommendation -->
            <td class="wphb-performance-report-item-score">
                <div class="wphb-score wphb-score-have-label">
                    <div class="tooltip-box">
                        <div class="tooltip-s wphb-score-result wphb-score-result-grade-<?php echo $rule_result->impact_score_class; ?>" tooltip="<?php echo $rule_result->impact_score; ?>/100">
                            <div class="wphb-score-type wphb-score-type-circle">
                                <svg class="wphb-score-graph wphb-score-graph-svg" xmlns="http://www.w3.org/2000/svg" width="30" height="30">
                                    <circle class="wphb-score-graph-circle" r="12.5" cx="15" cy="15" fill="transparent" stroke-dasharray="0" stroke-dashoffset="0"></circle>
                                    <circle class="wphb-score-graph-circle wphb-score-graph-result" r="12.5" cx="15" cy="15" fill="transparent" stroke-dasharray="80" stroke-dashoffset="0"></circle>
                                </svg>
                            </div><!-- end wphb-score-type -->
                            <div class="wphb-score-result-label"><?php echo $rule_result->impact_score; ?></div>
                        </div><!-- end wphb-score-result -->
                    </div><!-- end tooltip-box -->
                </div><!-- end wphb-score -->
            </td><!-- end wphb-performance-report-item-score -->
            <td>
                <?php if ( $rule_result->impact_score < 100 ) : ?>
                    <a href="<?php echo esc_url( wphb_get_admin_menu_url( 'performance' ) ); ?>#rule-<?php echo $rule; ?>" class="button button-ghost" name="submit"><?php _e( 'Improve', 'wphb' ); ?></a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>


<div class="buttons">
    <a href="<?php echo esc_url( $viewreport_link ); ?>" class="button button-ghost alignleft"><?php _e( 'View Full Report', 'wphb' ); ?></a>
    <div class="alignright">
        <?php
        $text = __( 'Automated performance tests are disabled', 'wphb' );
        if ( $notifications ) {
	        $text = __( 'Automated performance tests are enabled', 'wphb' );
        }
        ?>
        <span><?php echo $text; ?></span>
    </div>
</div>
<div class="clear"></div>