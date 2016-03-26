<?php $templates = array(); ob_start();

//***** author
?><a class="post_author" href="%author_url%"><?php _e('Posted by', 'parrot'); ?> %author% -&nbsp;</a><?php
$templates["author"] = ob_get_contents();
ob_clean();

ob_end_clean();
return $templates;