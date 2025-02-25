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
	$data = $CORE->FUNC("format_logtype", $post->ID );
	 
	$user_id = $data['userid'];
	
	$key = explode("(",$data['name']);
	
	
	 
?>

<tr id="postid-<?php echo $post->ID; ?>" class="logclass <?php echo str_replace(")","",$key[1]); ?>">
  <td><input class="checkbox1" type="checkbox" name="check[]" value="<?php echo $post->ID; ?>">
  </td>
  <?php if(is_numeric($user_id)){ ?>
  <td><ul class="list-inline mb-0 ">
      <li class="list-inline-item"> <a href="<?php echo get_author_posts_url($user_id); ?>" class="text-dark" target="_blank" style="max-width:55px; max-height:45px; overflow:hidden;">
        <?php  echo str_replace("avatar ","avatar img-fluid ",get_avatar( $user_id, 60 )); ?>
        </a> </li>
      <li class="list-inline-item">
        <div class="font-weight-bold mb-2"><?php echo $data['name']; ?></div>
        <div class="small btn-block"> <?php echo $data['desc']; ?> </div>
      </li>
    </ul>
    
    
    
    
    </td>
  <?php }else{ ?>
  <td><?php  echo $data['name']; ?>
  </td>
  <?php } ?>
  
  
  
  <td><?php  echo $data['time']; ?></td>
  <td><i class="<?php echo $data['icon']; ?> fa-2x float-left pr-3"></i></td>
  <td><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=reports&eid=<?php echo $post->ID; ?>" class="btn btn-system btn-md shadow-sm btn-block"><?php echo __("Edit","premiumpress"); ?> </a> <a href="javascript:void(0);"  onclick="ajax_delete_log('<?php echo $post->ID; ?>')"   class="btn btn-system btn-md  shadow-sm btn-block"><?php echo __("Delete","premiumpress"); ?></a> </td>
</tr>
