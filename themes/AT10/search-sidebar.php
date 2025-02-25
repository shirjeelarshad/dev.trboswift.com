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


if(isset($GLOBALS['flag-taxonomy']) && $GLOBALS['flag-taxonomy-type'] == "store"){ 

$GLOBALS['storesidebarset'] = 1;
 
?>
<?php _ppt_template( 'search', 'taxonomy-store' ); ?>
<?php } ?>
<?php if($CORE->ADVERTISING("check_exists", "search_sidebar_top") ){ ?>

<div class="mb-4 d-none d-md-block"> <?php echo $CORE->ADVERTISING("get_banner", "search_sidebar_top" );  ?> </div>
<?php } ?>
<?php if(!isset($GLOBALS['storesidebarset'])){ ?>
<div class="filters_col filters_sidebar">
  <div class="filter-top"><?php echo __("Filters ","premiumpress"); ?> <i class="fa fa-sliders-h <?php if(_ppt(array('lang','rtl')) == 1){ ?>float-left<?php }else{ ?>float-right<?php } ?>"></i> </div>
  <?php

$filters = $CORE->LAYOUT("captions","filters");
if(is_array($filters)){

	foreach($filters as $filter){	 
	
		if(_ppt(array("search","filters_".$filter)) != 0){
		_ppt_template( 'framework/design/widgets/widget-filter', $filter );
		}
	}

} 
	
?>
<div id="savedsearcheshere"></div>
<script> 
jQuery(document).ready(function(){ 
savesearch_get();
});
</script>
 


<?php if($CORE->isMobileDevice()){ ?>
  <button class="btn btn-primary btn-block mt-3" type="button" onClick="ProcessMobileFilters();"><?php echo __("Search","premiumpress"); ?></button>
  <script>
function ProcessMobileFilters(){

	_filter_update();
	
	jQuery('#filerbuttonclick').trigger('click');

}
</script>
 
  <?php } ?>
</div>
<?php } ?>

<?php if($CORE->ADVERTISING("check_exists", "search_sidebar_bottom") ){ ?>
<div class="mt-4 d-none d-md-block"> <?php echo $CORE->ADVERTISING("get_banner", "search_sidebar_bottom" );  ?> </div>
<?php } ?>



<div class="hide-mobile">
<?php  

	 

		// SET DEFAULTS
		ob_start();
		 dynamic_sidebar("search_sidebar"); 
		$sidebar_content = ob_get_clean();
		
		if(defined('THEME_KEY') && THEME_KEY == "cp" && $sidebar_content == ""){
		
		global $settings;
		
		$settings['num'] = 3;
		
		_ppt_template( 'framework/design/widgets/widget', 'coupon-pop' );
		
		_ppt_template( 'framework/design/widgets/widget', 'blog-recent' );	 
		
		}
		
		echo $sidebar_content; 
		
		
?>
</div>