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

	// GET POST META
	$order_id = get_post_meta($post->ID,'order_id',true);
	 
	$order_status = get_post_meta($post->ID,'order_status',true);
	
	$order_process = get_post_meta($post->ID,'order_process',true);
	
	 
 	$order_total = get_post_meta($post->ID,'order_total',true);	
 	
	$order_type = get_post_meta($post->ID,'order_type',true);	
	
	$user_id = get_post_meta($post->ID,'order_userid',true);
 


   $day 	= date("d", strtotime($post->post_date));
   $month 	= date("M", strtotime($post->post_date));
   $year 	= date("Y", strtotime($post->post_date));
   
?>

<tr id="postid-<?php echo $post->ID; ?>">
  <td><input class="checkbox1" type="checkbox" name="check[]" onclick="jQuery('#actionsbox').show();" value="<?php echo $post->ID; ?>">
  </td>
  <td><ul class="list-inline mb-0">
      <?php if(is_numeric($user_id)){ ?>
      <li class="list-inline-item"> <a href="admin.php?page=members&eid=<?php echo $user_id; ?>" target="_blank" class="text-dark" style="max-width:55px; max-height:45px; overflow:hidden;">
        <?php  echo str_replace("avatar ","avatar img-fluid ",get_avatar( $user_id, 50 )); ?>
        </a> </li>
      <?php } ?>
      <li class="list-inline-item">
        <div class="float-left pt-3 font-weight-bold"> <span class="<?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo hook_price($order_total); ?></span> </div>
        <div class="small ml-n2"> <a href="<?php echo THEME_URI; ?>/_invoice.php?invoiceid=<?php echo $post->ID; ?>" class="" target="_blank"><i class="fa fa-file"></i> <?php echo $CORE->ORDER("format_id", $post->ID); ?></a> </div>
      </li>
    </ul></td>
    
  <td>
  <div class="font-weight-bold"><?php echo  $day." ".$month; ?></div>
  
  <div class="small"><?php echo $year; ?></div>
  </td>
  <td><?php

 
// ORDER TYPE  
$ordertype = $CORE->ORDER("get_type", $order_id) ;
if(isset($ordertype['name'])){
?>
    <div style="padding:8px; background:<?php echo $ordertype['color']; ?>; color:#fff; font-weight:bold; text-align:center; font-size:11px; text-transform:uppercase; width:100%;"><?php echo $ordertype['name']; ?></div>
    <?php } ?>
  </td>
  <td class="text-center">
  
  <?php echo $CORE->ORDER("get_status_formatted",  $order_status ); ?> 
  <div class="mt-2">
  <?php
 
// ORDER STATUS
$orderprocess = $CORE->ORDER("get_process", $order_process ); 
if(isset($orderprocess['name'])){ 
?>
    <div class="small"><?php echo $orderprocess['name']; ?></div>
    <?php } ?>
    
    </div>
  
 
  </td>
 
  <td><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=orders&eid=<?php echo $post->ID; ?>" class="btn btn-system btn-md shadow-sm btn-block"><?php echo __("Edit","premiumpress"); ?> </a> <a href="javascript:void(0);" onclick="ajax_delete_order('<?php echo $post->ID; ?>')"  class="btn btn-system btn-md shadow-sm btn-block"><?php echo __("Delete","premiumpress"); ?></a> </td>
</tr>
