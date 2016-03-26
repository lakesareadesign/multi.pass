<?php $templates = array(); ob_start();

//***** title
?><h1 class="post_title">%title%</h1><?php
$templates["title"] = ob_get_contents();
ob_clean();

//***** excerpt
?><div class="post_excerpt">%excerpt%</div><?php
$templates["excerpt"] = ob_get_contents();
ob_clean();

//***** contents
?><div class="post_content">%contents%</div><?php
$templates["contents"] = ob_get_contents();
ob_clean();

ob_end_clean();
return $templates;