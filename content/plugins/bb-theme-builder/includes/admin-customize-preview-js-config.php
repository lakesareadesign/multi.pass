<?php

$has_header = 0 !== count( FLThemeBuilderLayoutData::get_current_page_header_ids() );
$has_footer = 0 !== count( FLThemeBuilderLayoutData::get_current_page_footer_ids() );

?>
<script>

FLThemeBuilderConfig = {
	hasHeader : <?php echo $has_header ? 'true' : 'false'; ?>,
	hasFooter : <?php echo $has_footer ? 'true' : 'false'; ?>
};
	
</script>
