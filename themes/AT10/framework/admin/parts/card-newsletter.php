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
	$email = get_post_meta($post->ID,'news_email',true);
	 
 	$v = get_post_meta($post->ID, "news_verified", true);

?>
<tr id="postid-<?php echo $post->ID; ?>">
<td>
<input class="checkbox1" type="checkbox" name="check[]" value="<?php echo $post->ID; ?>">

</td>
<td>


<ul class="list-inline mb-0">
 

<li class="list-inline-item">
<div class="float-left pt-3 font-weight-bold">
<?php echo $email; ?>

</div>
</li>

</ul>
 
</td>
<td><?php echo hook_date($post->post_date); ?></td>  
                      
<td class="text-center">

<?php if($v == "yes"){ ?>
 <div class=" text-success"><i class="fa fa-award"></i></span>  <?php echo __("Verified","premiumpress") ?></div>
<?php }else{ ?>
<div class="text-danger"><i class="fa fa-award text-danger"></i></span>  <?php echo __("Not Verified","premiumpress") ?></div>
<?php } ?>
</td>
 
<td>
 

<a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=email&eid=<?php echo $post->ID; ?>" class="btn btn-system btn-md shadow-sm btn-block"><?php echo __("Edit","premiumpress"); ?> </a>

<a href="javascript:void(0);"  onclick="ajax_delete_subscriber('<?php echo $post->ID; ?>')"  class="btn btn-system btn-md shadow-sm btn-block"><?php echo __("Delete","premiumpress"); ?></a>

 




</td>
</tr>