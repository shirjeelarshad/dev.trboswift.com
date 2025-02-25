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

global $CORE, $post, $userdata; 

$selected_array =  wp_get_post_terms($post->ID, "features", true);	?>
   <div class="row flex-warp justify-content-center align-items-center" style="margin:-10px;">
      <?php 
	  
	  if(is_array($selected_array) && !empty($selected_array) ){ 
	  
	  $i=1; foreach($selected_array as $val){
	  
	  $icon = "fa-check";
	  if(isset($val->term_id) && isset($GLOBALS['CORE_THEME']['category_icon_small_'.$val->term_id]) && $GLOBALS['CORE_THEME']['category_icon_small_'.$val->term_id] != ""){
		
			$icon =  _ppt('category_icon_small_'.$val->term_id);
			 
		
		}
		if(defined('WLT_DEMOMODE') && $i > 6){ continue;}
	  
	  	?>
      
      <span  class="btn-rounded bg-light float-left p-2 px-3 rounded small m-2">
      <span class="text-secondary mr-2"><i class="fa <?php echo $icon; ?>"></i> </span>
      <span class="text-secondary opacity-4 "><?php echo $CORE->GEO("translation_tax", array($val->term_id,  $val->name));  ?></span> 
      
      </span>
      
       
      <?php	$i++; } }else{	?>
      
       <span  class="btn-rounded font-itc bg-black float-left p-2 px-3 rounded small m-2">
      <i class="fal fa-lightbulb mr-2"></i> <?php echo __("Nothing Noteworthy","premiumpress"); ?>
      </span>
      
      <?php } ?>
      </div>
   <div class="clearfix "></div>