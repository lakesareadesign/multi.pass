<?php
// MEDIA UPLOADER
function enqueue_media_uploader() {
    wp_enqueue_media();
}

add_action("admin_enqueue_scripts", "enqueue_media_uploader");
?>
