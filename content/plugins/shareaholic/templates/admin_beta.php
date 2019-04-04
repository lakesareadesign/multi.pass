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
      origin: "wp_plugin",
      language: "<?php echo strtolower(get_bloginfo('language')) ?>"
    };
    </script>

    <div id="root" class="shr-site-settings"></div>

    <script class="shr-app-loader__site-settings" src="<?php echo ShareaholicUtilities::asset_url_admin('ui-site-settings/loader.js') ?>"></script>
  </div>

<?php } ?>

<?php ShareaholicAdmin::include_chat(); ?>

<script src="https://dsms0mj1bbhn4.cloudfront.net/assets/pub/loader-reachable.js" async></script>
