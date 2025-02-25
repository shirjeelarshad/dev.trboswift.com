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

global $CORE, $post;

$userv = get_user_meta($post->ID,'ppt_verified',true);

$showmeme = 0;
if( $CORE->LAYOUT("captions","memberships")  ){
$showmeme = 1;
$mem = $CORE->USER("get_user_membership", $post->ID);
}



?>

<tr id="postid-<?php echo $post->ID; ?>" class="font-12 text-dark">
 
  
  <td>
      <a href="javascript:void(0)" id="viewUserProfile" data-user-id="<?php echo $post->ID; ?>" class="text-dark" style="max-width:55px; max-height:45px; overflow:hidden;">
       		<span class="ellipsis" style="max-width:150px;display: inline-block;"><?php echo $CORE->USER("get_name",$post->ID); ?></span>
      </a>
        
    <?php 
	  
  if($showmeme && isset($mem['user_approved']) && $mem['user_approved'] == "0"){
  
 ?>
 <span class="inline-flex items-center font-weight-bold order-status-icon status-4"> <span class="dot mr-2"></span> <span class="pr-2px leading-relaxed whitespace-no-wrap"><?php echo __("Pending Approval","premiumpress"); ?> </span> </span>
 
 
 <?php } ?>
    
    </td>

  
 <td class="text-black text-capitalize">
 <?php echo $CORE->USER("get_role", $post->ID ); ?>

  </td>

 <td class="text-black"><?php echo $CORE->USER("get_address_part", array("phone", $post->ID) ); ?></td>
 
 <td class="text-black">
  
  <?php echo $CORE->USER("get_email",$post->ID); ?>
  
  </td>


  
</tr>
