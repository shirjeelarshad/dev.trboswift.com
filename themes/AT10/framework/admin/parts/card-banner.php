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
 
 
	
	
	 
?>
<tr id="postid-<?php echo $post->ID; ?>">

 
                   
<td>


 <?php $img = $CORE->ADVERTISING("banner_image", $post->ID); ?>
 
 

<a href="<?php echo $img; ?>" target="_blank"> 
<img src="<?php echo $img; ?>" class="img-fluid" style="max-height:100px;" />
</a>


<div class="small mt-2"><?php echo $CORE->ADVERTISING("banner_name", $post->ID); ?></div>


</td>

                   
<td class="text-center">

<?php $data = $CORE->ADVERTISING("banner_data", $post->ID); echo $data['w']." x ".$data['h'].""; ?>
 

</td>
 
<td>

<a href="javascript:void(0);"  onclick="ajax_banner_delete('<?php echo $post->ID; ?>')" class="btn btn-system btn-md shadow-sm btn-block"><?php echo __("Delete","premiumpress"); ?></a>
 

</td>
</tr>