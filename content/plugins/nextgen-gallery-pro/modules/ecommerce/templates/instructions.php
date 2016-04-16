<h3 style="text-transform: uppercase"><?php echo ($i18n->ecomm_header); ?></h3>
<ol>
    <li><?php echo($i18n->ecomm_step_1)?></li>
    <li><?php echo($i18n->ecomm_step_2)?></li>
    <li><?php echo($i18n->ecomm_step_3)?></li>
    <li><?php echo($i18n->ecomm_step_4)?></li>
    <li><?php echo($i18n->ecomm_step_5)?></li>
</ol>
<h3 style="text-transform: uppercase"><?php echo ($i18n->proofing_header); ?></h3>
<ol>
    <li><?php echo ($i18n->proofing_step_1); ?></li>
    <li><?php echo ($i18n->proofing_step_2); ?></li>
    <li><?php echo ($i18n->proofing_step_3); ?></li>
</ol>
<h3 style="text-transform: uppercase"><?php echo ($i18n->additional_documentation)?></h3>
<ul>
    <?php foreach ($i18n->documentation_links as $link => $label): ?>
        <li><a target='_blank' href="<?php echo esc_attr($link)?>"><?php esc_html_e($label)?></a></li>
    <?php endforeach ?>
</ul>
<script type="text/javascript">
    jQuery(function($){
        $('.open_tab').click(function(e){
            e.preventDefault();
            $('#'+$(this).attr('rel')).click();
        });
    });
</script>