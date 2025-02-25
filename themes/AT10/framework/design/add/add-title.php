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
 
global $CORE, $userdata;

	switch(THEME_KEY){
		
		case "sp": {
		$title = "";
		} break;
		
		case "da": {
		
			 $title = __("Profile Name","premiumpress"); 
			 
		} break;
		 	
		
		default: {
		
			$title = __("Introduction","premiumpress"); 
		 
		} break;
	
	}


$editID=0;

if(isset($_GET['eid']) && is_numeric($_GET['eid'])){
$editID = $_GET['eid'];
} 
 
?>

<div class="form-group">
  <?php if(THEME_KEY == "ex"){ ?>
  <input type="hidden" name="form[post_title]" class="form-control" value="user profile <?php echo $CORE->USER("get_username", $userdata->ID); ?>" />
  <?php }else{ ?>
  <?php if(strlen($title) > 1){ ?>
  <h4><?php echo $title; ?></h4>
  <hr />
  <?php } ?>
  
   <label class=""><?php echo __("Title","premiumpress"); ?> <span class="text-danger">*</span> </label>
  <input type="input" name="form[post_title]" maxlength="<?php if(_ppt(array('lst', 'titlemax' )) == ""){ echo 150; }else{ echo _ppt(array('lst', 'titlemax' )); } ?>"
               
               placeholder="<?php echo $CORE->LAYOUT("captions", "add_title") ?>"
               
               
               class="form-control rounded-0 required-field" tabindex="1" value="<?php if(isset($_GET['eid'])){ echo $CORE->get_edit_data('post_title', $_GET['eid']); } ?>" style="height: 60px !important;    font-size: 20px !important; font-weight: bold;">
  <?php } ?>
</div>
