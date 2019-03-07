<?php if ($api_key) { ?>
  
  <?php ShareaholicAdmin::show_header(); ?>
  
  <div class='wrap'>
    <script>
    window.ShareaholicConfig = {
      apiKey: "<?php echo $api_key ?>",
      verificationKey: "<?php echo $jwt ?>",
      apiHost: "<?php echo Shareaholic::API_URL ?>",
      serviceHost: "<?php echo Shareaholic::URL ?>",
      assetHost: "<?php echo ShareaholicUtilities::asset_url_admin() ?>",
      assetFolders: true,
      origin: "wp_plugin"
    };
    </script>

    <div id="root" class="shr-site-settings"></div>

    <script src="<?php echo ShareaholicUtilities::asset_url_admin('ui-site-settings/loader.js') ?>"></script>
  </div>

<?php } ?>

<?php ShareaholicAdmin::include_chat(); ?>