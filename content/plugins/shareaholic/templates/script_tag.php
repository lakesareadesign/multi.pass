<!-- Powered by Shareaholic; Grow your audience faster! - https://www.shareaholic.com -->
<link rel='preload' href='<?php echo ShareaholicUtilities::asset_url('assets/pub/shareaholic.js') ?>' as='script' />
<script data-cfasync='false'>
  //<![CDATA[
    _SHR_SETTINGS = <?php echo json_encode($base_settings); ?>;
  //]]>
</script>
<script data-cfasync='false'
        src='<?php echo ShareaholicUtilities::asset_url('assets/pub/shareaholic.js') ?>'
        data-shr-siteid='<?php echo $api_key; ?>' async <?php echo $overrides ?>>
</script>
