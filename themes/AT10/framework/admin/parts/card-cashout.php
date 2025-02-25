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
	$cashout_id = get_post_meta($post->ID,'cashout_id',true);
	 
	$cashout_status = get_post_meta($post->ID,'cashout_status',true);
	
	$cashout_process = get_post_meta($post->ID,'cashout_process',true);
	
	 
 	$cashout_total = get_post_meta($post->ID,'cashout_total',true);	
 	
	 
	$user_id = get_post_meta($post->ID,'cashout_userid',true);
 

?>

<tr id="postid-<?php echo $post->ID; ?>">
  <td><input class="checkbox1" type="checkbox" name="check[]" onclick="jQuery('#actionsbox').show();" value="<?php echo $post->ID; ?>">
  </td>
  <td><ul class="list-inline mb-0">
      <?php if(is_numeric($user_id)){ ?>
      <li class="list-inline-item"> <a href="<?php echo get_permalink($post->ID); ?>" class="text-dark" style="max-width:55px; max-height:45px; overflow:hidden;">
        <?php  echo str_replace("avatar ","avatar img-fluid ",get_avatar( $user_id, 50 )); ?>
        </a> </li>
      <?php } ?>
      <li class="list-inline-item mt-n2">
        <div class="pt-3 font-weight-bold"> <?php echo $CORE->USER("get_username", $user_id); ?></div>
        <div class="small mt-2"> <?php echo hook_date($post->post_date); ?></div>
      </li>
    </ul>
    </td>
 
  <td style="text-align:center;">
  
  
  <span class="<?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo hook_price($cashout_total); ?></span> 
  
  </td>
  <td><?php
 
// ORDER STATUS
 
$orderstatus = $CORE->ORDER("get_status", $cashout_status ); 
if(isset($orderstatus['name'])){
?>
    <div style=" padding:8px; background:<?php echo $orderstatus['color']; ?>; color:#fff; font-weight:bold; text-align:center; font-size:11px; width:100%; float:right; text-transform:uppercase"><?php echo $orderstatus['name']; ?></div>
    <?php } ?>
  </td>
  <td><?php
 
// ORDER STATUS
$orderprocess = $CORE->ORDER("get_process", $cashout_process ); 
if(isset($orderprocess['name'])){ 
?>
    <div style=" padding:8px; background:<?php echo $orderprocess['color']; ?>; color:#fff; font-weight:bold; text-align:center; font-size:11px; width:100%; float:right; text-transform:uppercase"><?php echo $orderprocess['name']; ?></div>
    <?php } ?>
  </td>
  <td><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=cashout&eid=<?php echo $post->ID; ?>" class="btn btn-system btn-md shadow-sm btn-block"><?php echo __("Edit","premiumpress"); ?> </a> <a href="javascript:void(0);" onclick="ajax_delete_cashout('<?php echo $post->ID; ?>')"  class="btn btn-system btn-md shadow-sm btn-block"><?php echo __("Delete","premiumpress"); ?></a> </td>
</tr>
