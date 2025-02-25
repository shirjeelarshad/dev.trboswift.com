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
	$user_id = get_post_meta($post->ID,'userid',true);
 
	$expires = get_post_meta($post->ID,'expires',true);
	
	$impressions = get_post_meta($post->ID,'impressions',true);
	
	$location = get_post_meta($post->ID,'location',true);
	
	$bannerid = get_post_meta($post->ID,'bannerid',true);
	
	
	
	 
?>
<tr id="postid-<?php echo $post->ID; ?>">

<td>
<input class="checkbox1" type="checkbox" name="check[]" value="<?php echo $post->ID; ?>">
</td>


<td> 
<?php if(is_numeric($user_id)){ ?>
 <a href="admin.php?page=members&eid=<?php echo $user_id; ?>" class="text-dark" target="_blank" style="max-width:55px; max-height:45px; overflow:hidden; float:left; margin-bottom:20px; margin-right:10px;"> 

<?php  echo str_replace("avatar ","avatar img-fluid ",get_avatar( $user_id, 60 )); ?>

</a> 
<?php } ?>
 
<?php $loc = $CORE->ADVERTISING("get_spaces",  $location);   ?>

<?php if(isset($loc['n'])){ ?> 
<div class="font-weight-bold"><?php echo $loc['n']; ?></div>
<?php } ?>
 
<div class="small mt-2">

<?php $e =  $CORE->ADVERTISING("campaign_expires", $post->ID); 

if($e['expired']){ echo __("Finished","premiumpress"); }else{ ?>
 
<?php echo $e['days'];  ?> left

<?php } ?>

- 

<?php $bann = $CORE->ADVERTISING("banner_data", $bannerid); if(isset($bann['name'])){ echo $bann['name']; } ?>
 

</div>
 
</td>

 

<td class="text-center"><?php echo $CORE->ADVERTISING("campaign_impressions", $post->ID); ?></td>  

<td class="text-center"><?php echo $CORE->ADVERTISING("campaign_clicks", $post->ID); ?></td> 
                       
<td>

<?php $status = $CORE->ADVERTISING("campaign_status", $post->ID); ?>

<div style=" padding:8px; background:<?php echo $status['color']; ?>; color:#fff; margin-top:5px; text-align:center; font-size:11px; width:100%; text-transform:uppercase">
<?php echo $status['short']; ?></div>

</td>
 
<td>


 

<a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=advertising&eid=<?php echo $post->ID; ?>" class="btn btn-system btn-md shadow-sm btn-block"><?php echo __("Edit","premiumpress"); ?> </a>

<a href="javascript:void(0);"  onclick="ajax_delete_advertising('<?php echo $post->ID; ?>')"   class="btn btn-system btn-md shadow-sm btn-block"><?php echo __("Delete","premiumpress"); ?></a>



</td>
</tr>