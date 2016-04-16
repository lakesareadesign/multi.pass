<div class="digital_downloads_list">
    <?php esc_html_e($msg)?>
</div>
<script type="text/javascript">
    jQuery(function($){
        function refresh_digital_downloads()
        {
            setTimeout(function(){
                $.get(window.location, function(response){
                    var html = $(response);
                    $('.digital_downloads_list').html(html.find('.digital_downloads_list'));
                    if ($('.digital_downloads_list').find('table').length == 0) refresh_digital_downloads();
                });
            }, 1000);
        }

        refresh_digital_downloads();
    });
</script>