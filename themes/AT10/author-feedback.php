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
	
	'meta_query' => array(
			 
			array(
				'key'		=> 'feedback_for',
				'value' 	=> $authorID,
				'compare' 		=> '=',
			),
			array(
				'key'		=> 'feedback',	
				'value' 	=> 1,
				'compare' 	=> '=',
			),	
			 
		),
		
);
// GET USER FEEDBACK
$c = new WP_Comment_Query($args); 
$feedback = $c->comments;

// GET MY FEEDBACK
$args = array(
 	
	'meta_query' => array(
			 
			array(
				'key'		=> 'feedback_from',
				'value' 	=> $authorID,
				'compare' 		=> '=',
			),
			array(
				'key'		=> 'feedback',	
				'value' 	=> 1,
				'compare' 	=> '=',
			),	
			 
		),
);
$c = new WP_Comment_Query($args); 
$feedback2 = $c->comments;
 
  
?>

<div class="tab-pane fade" id="t1" role="tabpanel">
  <?php if(empty($feedback)){ ?>
<div class="bg-light p-4 text-muted font-weight-bold text-center">
            <div><?php echo __("No feedback received.","premiumpress") ?></div>
            </div>
  
  <?php }elseif(!empty($feedback)){ ?>
  <div class=" clearfix pt-5">
    <?php foreach($feedback as $this_feedback){
		 
		global $settings;
		
		$settings = array(
		
			"ID" => $this_feedback->comment_ID,
			"desc" => strip_tags($this_feedback->comment_content), 
			"date" => $this_feedback->comment_date, 			
			"author" => $this_feedback->user_id, 
			"author_name" => $CORE->USER("get_name",$this_feedback->user_id), 			
			"pid" => $this_feedback->comment_post_ID,			
			
		);		 
		
		// DISPLAY FEEDBACK 
 		_ppt_template( 'content', 'feedback' );
		 
		
		
		}  // end foreach ?>
  </div>
  <!-- review wrapper -->
  <?php } // end if ?>
  <?php wp_reset_postdata();  ?>
</div>
<div class="tab-pane fade" id="t2" role="tabpanel">
  <?php if(empty($feedback2)){ ?>
<div class="bg-light p-4 text-muted font-weight-bold text-center">
            <div><?php echo __("No feedback left.","premiumpress") ?></div>
            </div>
  <?php }elseif(!empty($feedback2)){ ?>
  <div class=" clearfix pt-5">
    <?php foreach($feedback2 as $this_feedback){
		 
			global $settings;
			
			$settings = array(
			
				"ID" => $this_feedback->comment_ID,
				"desc" => strip_tags($this_feedback->comment_content), 
				"date" => $this_feedback->comment_date, 			
				"author" => $this_feedback->user_id, 
				"author_name" => $CORE->USER("get_name",$this_feedback->user_id), 			
				"pid" => $this_feedback->comment_post_ID,
				
			);		 
			
			// DISPLAY FEEDBACK 
			_ppt_template( 'content', 'feedback' );
	  
		 
		 }  // end foreach ?>
  </div>
  <!-- review wrapper -->
  <?php } // end if ?>
  <?php wp_reset_postdata();  ?>
</div>
