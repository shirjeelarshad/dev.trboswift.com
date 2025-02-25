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


<!--msg model -->
<div class="filter-modal-wrap shadow hidepage" style="display:none;">
  <div class="filter-modal-wrap-overlay"></div>
  <div class="filter-modal-item">
    <div class="filter-modal-container"> 
      <div class="card-body">
         <div id="ajax-filter-form"></div>
        <div class="filter-modal-close text-center"><i class="fa fa-times">&nbsp;</i></div>
        
        <hr />
        
        
        <button class="btn btn-primary" onclick="_filter_update();  jQuery('.filter-modal-wrap').fadeOut(400);"><?php echo __("Update Results","premiumpress"); ?></button>
      </div>
      
    </div>
  </div>
</div>

<div class="filter-bar hide-mobile">



<?php

function SearchFilterCaptions($filter){

	switch($filter){
	
		case "category": {
		
			if(THEME_KEY == "ex"){
		
			return __("Language","premiumpress");			 
			
			}else{
			
			return __("Category","premiumpress");
			  
			}			
			
		} break;
	
	}

	return $filter;
}

$filters = $CORE->LAYOUT("captions","filters");
if(is_array($filters)){

	foreach($filters as $filter){
	
		if(in_array($filter, array("taxonomy", "keyword","distance","showonly") ) ){  continue; }	 
	
		if(_ppt(array("search","filters_".$filter)) != 0){
		 
		//_ppt_template( 'framework/design/widgets/widget-filter', $filter );
		
		?>
        
         <div class="filter-section" onclick="processFilterbox('<?php echo $filter; ?>','');">
    <div class="tag-filter small font-weight-bold text-lowercase" id="<?php echo $filter; ?>"><span><?php echo SearchFilterCaptions($filter); ?></span></div>
  </div>
        <?php
		 
		}
	}
	
	$tax = get_taxonomies(); 
	
	foreach($tax as $t){
	
	if(in_array($t, _ppt('searchtax'))){ 
	
	?>
        
         <div class="filter-section" onclick="processFilterbox('taxonomy','<?php echo $t; ?>');">
    <div class="tag-filter small font-weight-bold text-lowercase" id="<?php echo $t; ?>"><span><?php echo $CORE->GEO("translation_tax_key", $t); ?></span></div>
  </div>
        <?php
		
		}
	
	
	}

} 
	
?>


 
  <div class="search-top-filters-input">
    <div  class="search-top-filterss-input-icon"> <i class="fal fa-search" onclick="jQuery('.search-form-hide').toggle();"></i> </div>
    <form action="<?php echo home_url(); ?>" class="search-form-hide">
      <input placeholder="<?php
		
		if(THEME_KEY == "cp"){
		
		echo __("Store name or keyword..","premiumpress");
		
		}else{
		
		  echo __("Keyword..","premiumpress");
		  
		}  
		  
		   ?>"  name="s" value="">
    </form>
  </div> 
</div>
