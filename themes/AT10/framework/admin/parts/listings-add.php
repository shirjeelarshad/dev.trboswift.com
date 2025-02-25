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

global $CORE;
?>
<script>
 

function ProcessAdminPackage(){
 
	 
	 if(jQuery('#packagessection input').length > 1){
	 
	 	jQuery('#packagessection').find('input').filter(':visible:first').trigger("click");
	 }

}
</script>

<input type="hidden" name="custom[adminareaedit]" class="form-control" value="1" />
<!-- dont rmeoved this // tells the form its an admin edit -->
<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ ?>
<div class="col-12 mx-auto">
  <div class="my-3"> 
  
  <a href="admin.php?page=listings&duplicate=<?php echo esc_attr($_GET['eid']); ?>" class="text-dark"><i class="fa fa-copy"></i> <?php echo __("Duplicate Listing","premiumpress"); ?></a> <span class="text-muted px-3">|</span> 
  
  <a href="<?php echo get_permalink($_GET['eid']); ?>" target="_blank" class="text-dark"><i class="fa fa-eye"></i> <?php echo __("View Listing Page","premiumpress"); ?></a> <span class="text-muted px-3">|</span> 
  
  <a href="post.php?post=<?php echo esc_attr($_GET['eid']); ?>&action=edit" target="_blank" class="text-dark"><i class="fab fa-wordpress"></i> <?php echo __("WordPress Editor","premiumpress"); ?></a>
  
  </div>
</div>
<hr />
<?php }else{ ?>
<h4 class="mb-5"><?php echo __("Add","premiumpress"); ?> <?php echo $CORE->LAYOUT("captions","1"); ?></h4>
<?php } ?>
<?php _ppt_template('framework/design/add/add-mainform' ); ?>
