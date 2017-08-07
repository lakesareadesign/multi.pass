<div class="wphb-notice wphb-notice-<?php echo $class; ?> can-close">
	<div class="close"></div>
	<p><?php echo $message; ?></p>
</div>

<?php if ( $dismissable ): ?>
	<script type="text/javascript">
        jQuery('.wphb-notice:not(.notice)').delay(3000).slideUp('slow');
	</script>
<?php endif; ?>