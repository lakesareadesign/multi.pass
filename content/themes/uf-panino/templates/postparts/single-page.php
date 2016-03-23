<?php $templates = array(); ob_start();

//***** comments_count
?><div class="post_comments">
    <span class="post_comments_total">%comments_count%</span> Comment(s)
</div><?php
$templates["comments_count"] = ob_get_contents();
ob_clean();

//***** title
?><h1 class="post_title">%title%</h1><?php
$templates["title"] = ob_get_contents();
ob_clean();

ob_end_clean();
return $templates;