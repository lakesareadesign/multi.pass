<?php $templates = array(); ob_start();

//***** author
?><a class="post_author" href="%author_url%">%author%</a><?php
$templates["author"] = ob_get_contents();
ob_clean();

//***** author_gravatar
?><span class="author_gravatar">%avatar_{size}%</span><?php
$templates["author_gravatar"] = ob_get_contents();
ob_clean();

//***** categories
?><div class="post_categories"><span class="post_categories_label">Categories</span>%categories%</div><?php
$templates["categories"] = ob_get_contents();
ob_clean();

//***** comments_count
?><div class="post_comments">%comments_count%</div><?php
$templates["comments_count"] = ob_get_contents();
ob_clean();

//***** contents
?><div class="post_content">%contents%</div><?php
$templates["contents"] = ob_get_contents();
ob_clean();

//***** date
?><time class="post_date" datetime="%date_iso%">%date%</time><?php
$templates["date"] = ob_get_contents();
ob_clean();

//***** update
?><time class="post_update" datetime="%date_iso%">%update%</time><?php
$templates["update"] = ob_get_contents();
ob_clean();

//***** excerpt
?><div class="post_excerpt">%excerpt%</div><?php
$templates["excerpt"] = ob_get_contents();
ob_clean();

//***** featured_image
?><div class="post_thumbnail">%image%</div><?php
$templates["featured_image"] = ob_get_contents();
ob_clean();

//***** tags
?><div class="post_tags">%tags%</div><?php
$templates["tags"] = ob_get_contents();
ob_clean();

//***** title
?><h1 class="post_title">%title%</h1><?php
$templates["title"] = ob_get_contents();
ob_clean();

ob_end_clean();
return $templates;