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

global $CORE, $post, $userdata;


switch(THEME_KEY){
 	 
	
	default: {	
		$title = __("User Reviews","premiumpress");
	} break;
}

 ?>

<div class="mb-4 pb-4" style="display:none">

<h5 class="card-title ml-lg-4"><?php echo $title; ?></h5>

<div id="commentlistwrap" >
<?php

if($post->comment_count == 0 && $post->post_author == 1 && defined('WLT_DEMOMODE')){

	// GET FILE
	_ppt_template('content-comment-example');

}else{

$args = array(
	 
	'number' => 10,
	
	'meta_query' => array(
			 
			array(
				'key'		=> 'postauthor',
				'value' 	=> $post->post_author,
				'compare' 		=> '=',
			),
			 
			 
		),
		
);

// GET USER FEEDBACK
$c = new WP_Comment_Query($args); 
$comments = $c->comments;
 

if(!empty($comments)){ 
?>
 
 

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
		_ppt_template('content-comment');	
   
   } ?>


<?php }else{ ?>
<div class="my-4 clearfix ml-lg-4">
<span class="btn-rounded bg-light  p-2 px-3 rounded small">
      <span class="mr-2"><i class="fal fa-comments"></i> </span>
      <span class="opacity-8"><?php echo __("No Reviews Found","premiumpress"); ?></span> 
      
      </span>
</div>
<?php } ?>
<?php } ?> 
</div>
<script>
function processCommentAll(){
 	
 
	jQuery("#comments-ajax-all").html('');
 	jQuery('#commentlistwrap .comment-single').each(function () {	
	 	  
		jQuery("#comments-ajax-all").html(jQuery("#comments-ajax-all").html() + '<div class="comment-single mb-4">'+jQuery(this).html()+'</div>' );	
	});
	jQuery("#commentsformbody").hide();
	jQuery(".comment-modal-wrap").fadeIn(400);
   
}
jQuery(document).ready(function(){ 


if(jQuery('#commentlistwrap .comment-single').length > 1){
	jQuery('#commentlistwrap .comment-single').hide();
	jQuery('#commentlistwrap .comment-single:nth(0)').fadeIn('slow');
	cc = -1;
	setInterval(function(){		
		
	    jQuery('#commentlistwrap .comment-single').hide();
		cc++;
		jQuery('#commentlistwrap .comment-single:nth('+cc+')').fadeIn('slow');		 
		if(cc == 2){ cc = 0; }
		
	}, 6000);
}	

});
</script> 
</div>  
<?php
/*

	4. DISPLAY EVERYTHING
	
*/

if($userdata->ID){
$comments_args = array(
	'class_form' 			=> '',
	'id_form' 				=> 'newcomment',
	'label_submit'			=> '',
	'comment_notes_before' 	=> '',
	'title_reply'			=> '', 
	'title_reply_before' 	=> '',
	'comment_notes_after' 	=> '',
	//'submit_field' 			=> '',
	'comment_field' 		=> '',
	'logged_in_as' 			=> '',
);
?>
<!--msg model -->
<div class="comment-modal-wrap shadow hidepage" style="display:none;">
  <div class="comment-modal-wrap-overlay"></div>
  <div class="comment-modal-item">
    <div class="comment-modal-container">
      <div class="card-body">
        <div id="comments-ajax-all" style="max-height: 500px;    overflow: hidden;    overflow-y: scroll;"></div>
        <div id="commentsformbody"> <?php echo comment_form( $comments_args, $post->ID ); ?> </div>
        <a href="javascript:void(0);" onclick="jQuery('.comment-modal-wrap').fadeOut(400);" class="small"><?php echo __("Close Window","premiumpress"); ?></a> </div>
    </div>
  </div>
</div>
<?php

}
?>
  
