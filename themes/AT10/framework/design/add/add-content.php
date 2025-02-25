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
		
		case "da": {
		
			 $title = __("Here's My Story","premiumpress"); 
			 
		} break;
		
		case "mj": {
		
			 $title = __("About This Gig","premiumpress"); 
			 
		} break;		
		
		
		
		default: {
		
			$title = __("Description","premiumpress");
		 
		} break;
	
	}
	 


$editID=0;
$content = "";
if(isset($_GET['eid']) && is_numeric($_GET['eid'])){
$editID = $_GET['eid'];
$content = $CORE->get_edit_data('post_content', $editID);
} 

$content = preg_replace('#<div id="ppt_keywords">(.*?)</div>#', ' ', stripslashes($content));
 
?>
     <div class="form-group">
        <div id="textarea_counter" class="text-muted small float-right"><span></span></div>
        <input type="hidden" name="textarea_counter_hidden" value="<?php if(is_numeric(_ppt(array('lst', 'descmin' ))) ){ echo _ppt(array('lst', 'descmin' )); }else{ echo 100; } ?>" id="textarea_counter_hidden">
       
       <?php if(isset($_POST['ajaxedit'])){ ?>
    <h4><?php echo $title; ?></h4><hr />
     <?php }else{ ?>
      <label class=""><?php echo $title; ?> <span class="text-danger">*</span> </label>
     
     <?php }
	 
	 
		if(is_admin()){
			
		echo wp_editor( $content, 'editor_post_content', array( 'textarea_name' => 'form[post_content]', 'editor_height' => '250px') ); 
				  
		 }else{
		 
		 $content = str_replace("<p>","", $content);
		 $content = str_replace("</p>", PHP_EOL .PHP_EOL, $content);
		 
		?>
        <textarea name="form[post_content]" class="form-control rounded-0 required-field" tabindex="2" id="field-post_content" style="min-height:250px;"><?php echo $content; ?></textarea>
        <?php } ?>
      </div>