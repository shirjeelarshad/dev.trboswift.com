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

global $settings, $userdata, $CORE;

 
if($settings['job_buyer_id'] == $userdata->ID){
	$feedback_date  = get_post_meta($settings['pid'],'feedback_date_buyer',true);
}else{
	$feedback_date  = get_post_meta($settings['pid'],'feedback_date_seller',true);
}


if($feedback_date == ""){
?>
<div class="card card-body mt-4">
<p><strong><?php echo __("Leave Feedback","premiumpress"); ?></strong></p>
<?php  get_template_part( 'author', 'feedback-form' ); ?>
</div>
           
<?php }elseif(isset($feedback_date) && strlen($feedback_date) > 1){ ?>

<div class="text-center mt-3"> <i class="fa fa-heart" aria-hidden="true"></i> <?php echo __("Feedback left on","premiumpress"); ?> <?php echo hook_date($feedback_date); ?></div>

<?php } 