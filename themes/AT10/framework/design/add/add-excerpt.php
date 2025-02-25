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
 

$editID=0;

if(isset($_GET['eid']) && is_numeric($_GET['eid'])){
$editID = $_GET['eid'];
} 
 
?>
        <?php if(in_array(THEME_KEY , array("da","ex","es","ll"))){ ?>
      <div class="form-group">
        <input type="hidden" name="excerpt_counter_hidden" value="90" id="excerpt_counter_hidden">
        <div id="excerpt_counter" class="text-muted small float-right"><span></span></div>
        <label><?php 
		
		if(THEME_KEY == "es"){ 
		echo __("Special tag line.","premiumpress");
		
		
			
		}elseif(THEME_KEY == "ll"){ 
		echo __("A few words to explain the course content.","premiumpress");
		
		
		}else{
		echo __("How would you describe yourself in one sentence?","premiumpress");
		
		}
		
		
		 
		
		
		?> <span class="text-danger">*</span> </label>
        <input name="form[post_excerpt]" class="form-control rounded-0 required-field" tabindex="2" id="field-post_excerpt" placeholder="<?php echo __("I'm tall, dark and mysterious. Contact me now to learn more :-)","premiumpress"); ?>" value="<?php if(isset($_GET['eid'])){  echo preg_replace('#<div id="ppt_keywords">(.*?)</div>#', ' ', $CORE->get_edit_data('post_excerpt', $_GET['eid'])); }?>">
      </div>
      
      <?php } ?>