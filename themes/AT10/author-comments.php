<?php
/* 
* Theme: TURBOBID CORE FRAMEWORK FILE
* Url: www.turbobid.ca
* Author: Md Nuralam
*
* THIS FILE WILL BE UPDATED WITH EVERY UPDATE
* IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
*
* http://codex.wordpress.org/Child_Themes
*/
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

global $CORE, $userdata, $authorID;
$args = array(
	 
	'number' => 10,
	'post_author__in' => array($authorID),
	'meta_query' => array(			 
		array(
			'key'		=> 'feedback',	
			'compare'	=>'NOT EXISTS'	
			 
		),			 
	),
		
);
// GET USER FEEDBACK
$c = new WP_Comment_Query($args); 
$comments = $c->comments;
 

if(!empty($comments)){ 
?>
 
 
<div class="ppt-comments">
   <?php foreach($comments as $comment){ 
   
   
		global $settings;
		
		$settings = array(
		
			"ID" => $comment->comment_ID,
			"desc" => strip_tags($comment->comment_content), 
			"date" => $comment->comment_date, 			
			"author" => $comment->user_id, 
			"author_name" => $CORE->USER("get_name",$comment->user_id), 			
			"pid" => $comment->comment_post_ID,			
			
		);		 
		
		// DISPLAY FEEDBACK 
 		_ppt_template( 'content', 'feedback' );
   
   } ?>
</div>
<?php }else{ ?>
<div class="bg-light p-4 text-muted font-weight-bold text-center">
            <div><?php echo __("No comments left.","premiumpress") ?></div>
            </div>
<?php } ?>
 
 