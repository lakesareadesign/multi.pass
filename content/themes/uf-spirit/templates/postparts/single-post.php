<?php $templates = array(); ob_start();

//***** title
?><h1 class="post_title">%title%</h1><?php
$templates["title"] = ob_get_contents();
ob_clean();

//***** author
?><div class="post_author">WRITTEN BY <a href="%author_url%">%author%</a></div><?php
$templates["author"] = ob_get_contents();
ob_clean();

//***** comments_count
?><div class="comments_count">COMMENTS / <a href="%permalink%#comments">%comments_count%</a></div><?php
$templates["comments_count"] = ob_get_contents();	     	 		 		  		  	 
ob_clean();

//***** date
?><time class="post_date" datetime="%date_iso%">%date%</time><?php
$templates["date"] = ob_get_contents();
ob_clean();

//***** contents
?><div class="post_content">%contents%</div><?php
$templates["contents"] = ob_get_contents();
ob_clean();

ob_end_clean();
return $templates;