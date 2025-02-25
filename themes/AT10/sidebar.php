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
 
if(!isset($GLOBALS['flag-nosidebar'])){  
if(!_ppt_checkfile("sidebar.php")){

global $CORE, $post, $settings;
 
if(isset($GLOBALS['flag-add'])){

	$sidebarID = "add";

}elseif(isset($GLOBALS['flag-taxonomy'])){

	$sidebarID = "taxonomy";

}elseif(isset($GLOBALS['flag-blog'])){

	$sidebarID = "blog";
		
}elseif(isset($GLOBALS['flag-single'])){

	$sidebarID = "listing";
	
}elseif(isset($GLOBALS['flag-search'])){

	$sidebarID = "search";

}else{

	$sidebarID = "page";

}

 
	// SET DEFAULTS
	ob_start();
	dynamic_sidebar($sidebarID); 
	$sidebar_content = ob_get_clean();
 
?>

 
<aside class="sidebar-<?php echo $sidebarID; ?> col-lg-3 hide-mobile">


<?php if($CORE->ADVERTISING("check_exists", "blog_top") ){ ?>
<div class="mb-3 mt-n4 text-center ">
<?php echo $CORE->ADVERTISING("get_banner", "blog_top" );  ?>
</div>
<?php } ?>
 
 
    <?php 
	
	// SET DEFAULTS
	ob_start();
	dynamic_sidebar($sidebarID); 
	$sidebar_content = ob_get_clean();
	
	if($sidebar_content == "" && $sidebarID == "blog"){
	 	 
		 
		_ppt_template( 'framework/design/widgets/widget', 'blog-search' );
		
		_ppt_template( 'framework/design/widgets/widget', 'blog-categories' );
		
		_ppt_template( 'framework/design/widgets/widget', 'blog-recent' );
		
		//_ppt_template( 'framework/design/widgets/widget', 'newsletter' ); 
		
		dynamic_sidebar('blog');
 
 	
	 	
	}elseif($sidebar_content == ""){ ?>
   
        
    <?php }else{ ?>

    <?php echo $sidebar_content; ?>
    
    <?php } ?>
    
  
<?php if($CORE->ADVERTISING("check_exists", "blog_bottom") ){ ?>
<div class="mb-3 mt-n4 text-center ">
<?php echo $CORE->ADVERTISING("get_banner", "blog_bottom" );  ?>
</div>
<?php } ?>



</aside>
 
<?php } ?><?php } ?>