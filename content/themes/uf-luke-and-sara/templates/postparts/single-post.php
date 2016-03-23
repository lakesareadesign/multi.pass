<?php $templates = array(); ob_start();

//***** comments_count
?><div class="post_comments"><?php _e('Comments', 'lukeandsara'); ?> (%comments_count%)</div><?php
$templates["comments_count"] = ob_get_contents();
ob_clean();

//***** categories
?><div class="post_categories">
<h3 class="post_categories_title"><?php _e('Category', 'lukeandsara'); ?></h3>
%categories%
</div><?php
$templates["categories"] = ob_get_contents();
ob_clean();

//***** author
?><a class="post_author" href="%author_url%"><?php _e('By', 'lukeandsara'); ?> %author%</a><?php
$templates["author"] = ob_get_contents();
ob_clean();

//***** title
?><h1 class="post_title">%title%</h1><?php
$templates["title"] = ob_get_contents();
ob_clean();

ob_end_clean();
return $templates;