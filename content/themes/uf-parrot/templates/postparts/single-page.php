<?php $templates = array(); ob_start();

//***** date
?><time class="post_date" datetime="%date_iso%">%date%</time><?php
$templates["date"] = ob_get_contents();
ob_clean();

//***** author
?><a class="post_author" href="%author_url%"><?php _e('Posted by', 'parrot'); ?> %author%</a><?php
$templates["author"] = ob_get_contents();
ob_clean();

//***** title
?><h1 class="post_title">%title%</h1><?php
$templates["title"] = ob_get_contents();
ob_clean();

ob_end_clean();
return $templates;