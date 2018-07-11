<script id="wpmudev-mailchimp-group-args-tpl" type="text/template">
<div id="wph-mailchimp-group-args">
    <h3>
        <?php esc_attr_e("Interest group:", Opt_In::TEXT_DOMAIN); ?>
    </h3>
    <p>
        <?php
		printf(
			esc_attr__( '%1$sName:%2$s {{name}}', Opt_In::TEXT_DOMAIN ),
			'<strong>',
			'</strong>'
		);
		?>
    </p>
    <p>
        <?php
		printf(
			esc_attr__( '%1$sType:%2$s {{type}}', Opt_In::TEXT_DOMAIN ),
			'<strong>',
			'</strong>'
		);
		?>
    </p>
    <p>
        <?php
		printf(
			esc_attr__( '%1$sOptions:%2$s {{options}}', Opt_In::TEXT_DOMAIN ),
			'<strong>',
			'</strong>'
		);
		?>
    </p>
    <p>
        <?php
		printf(
			esc_attr__( '%1$sSelected:%2$s {{selected}}', Opt_In::TEXT_DOMAIN ),
			'<strong>',
			'</strong>'
		);
		?>
    </p>
</div>
</script>