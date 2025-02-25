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

global $CORE; ?>
<div class="collapse <?php if($GLOBALS['flag-search-style'] == 7){ ?>bg-light <?php }else{ ?>bg-white<?php } ?> border-top" id="filters-extra">
  <div class="container py-4">
    <div class="row">
      <?php

$filters = $CORE->LAYOUT("captions","filters");

if(is_array($filters)){

	foreach($filters as $filter){	 
	
		if(_ppt(array("search","filters_".$filter)) != 0){
		echo '<div class="col-md-3 border-right openfilters">';
		_ppt_template( 'framework/design/widgets/widget-filter', $filter );
		echo "</div>";
		}
	}

} 
	
?>
    </div>
    

    
<?php if($CORE->isMobileDevice()){ ?>
<div>
<button class="btn btn-primary btn-block" type="button" onClick="ProcessMobileFilters();"><?php echo __("Search","premiumpress"); ?></button>
<script>
function ProcessMobileFilters(){

	_filter_update();
	
	jQuery('#filerbuttonclick').trigger('click');

}
</script>

</div>
<?php } ?>
  </div>
</div>