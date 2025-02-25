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
	$cashout_id = get_post_meta($post->ID,'cashback_id',true);
	 
	$status = get_post_meta($post->ID,'cashback_status',true);
	  
 	$cashout_paid = get_post_meta($post->ID,'cashback_total',true);	
 	
	 
	$user_id = get_post_meta($post->ID,'cashback_userid',true);
 

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
  
  <?php if($cashout_paid > 0){ ?>
  <span class="<?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo hook_price($cashout_paid); ?></span> 
  <?php }else{ ?>
  -
  <?php } ?>
  </td>
  <td style="text-align:center;">
  
  
  <?php if($status == 0){ ?>
             
              <span class="inline-flex items-center font-weight-bold order-status-icon status-2"> <span class="dot mr-2"></span><span class="pr-2px leading-relaxed whitespace-no-wrap">
			  <?php echo __("Pending","premiumpress"); ?></span> </span>
              
              <?php }elseif($status == 1){ ?>
              <span class="inline-flex items-center font-weight-bold order-status-icon status-1"> <span class="dot mr-2"></span><span class="pr-2px leading-relaxed whitespace-no-wrap">
			  <?php echo __("Approved","premiumpress"); ?></span> </span>
             
              <?php }else{ ?>
              
              
              <span class="inline-flex items-center font-weight-bold order-status-icon status-5"> <span class="dot mr-2"></span><span class="pr-2px leading-relaxed whitespace-no-wrap">
			  <?php echo __("Rejected","premiumpress"); ?></span> </span>
              <?php } ?>
  </td>
 
  <td><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=cashback&eid=<?php echo $post->ID; ?>" class="btn btn-system btn-md shadow-sm btn-block"><?php echo __("Edit","premiumpress"); ?> </a> <a href="javascript:void(0);" onclick="ajax_delete_cashout('<?php echo $post->ID; ?>')"  class="btn btn-system btn-md shadow-sm btn-block"><?php echo __("Delete","premiumpress"); ?></a> </td>
</tr>
