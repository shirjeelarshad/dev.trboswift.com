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
<form method="get" action="<?php echo home_url(); ?>" class="searchform text-left">
  <input type="hidden" name="s" value="" />
  <input type="hidden" name="type" value="1" />
  
  
  <?php if(_ppt(array('design', 'searchbox_enable')) == "1"){ ?>
  
  <?php $ld = _ppt('customsearchbox');  ?>
  
   <div class="row">
  	
	<?php if(is_array($ld) && !empty($ld)){ foreach($ld as $type => $vals){
	
		if($vals != "1"){  continue; }
	 
  
  		switch($type){
		
			case "keyword": {
?>
    <div class="col-12 mb-2">
      <div class="form-input position-relative">
        <label><?php echo __("Keyword","premiumpress"); ?></label>
        <input name="s" class="form-control" />
        <span  style="top: 40px; right: 10px; position: absolute;    z-index: 100;"><span class="fal fa-search"></span></span> 
      </div>
    </div>
<?php
			} break;	
					
			case "location": {
?>
    <div class="col-12 mb-2">
    <?php  if(_ppt(array("maps","provider")) == "basic"){  ?>
    <div class="form-input mb-2">
        <label><?php echo __("Location","premiumpress"); ?></label>
        <?php echo _get_country_search_box(); ?>
        </div>
        <?php }else{ ?>
    
      <div class="form-input mb-2">
        <label><?php echo __("Location","premiumpress"); ?></label>
<div class="form-input position-relative">
      <input name="zipcode" class="form-control" id="homesearchzip"  placeholder="<?php echo __("Any Location","premiumpress"); ?>" />
      <span  style="top: 11px; right: 10px; position: absolute;    z-index: 100;color:#000; cursor:pointer;" <?php if(_ppt(array('maps','enable'))){ ?>onclick="getCurrentLocation();"<?php } ?>><span class="fal fa-map-marker"></span></span> </div>
      </div>
      <?php } ?>
    </div>
<?php
			} break;
			
			case "price": {
?>
<div class="col-12 mb-2">
 <label><?php echo __("Max Price","premiumpress"); ?></label>
    
   <div class="input-group">   
	<input class="form-control numericonly" name="price2" value="" placeholder="<?php echo __("Any","premiumpress"); ?>"/>     
    <div class="position-absolute text-muted" style="bottom: 8px;    right: 10px;"><?php echo hook_currency_symbol(''); ?></div>
    </div>
</div>
<?php
			
			} break;
			
			default: { // TAXONOMIE
			
			if(substr($type, 0, 3) == "tax"){
			
				$taxonomy = str_replace("tax_","",$type);
			
				$cats = get_terms( $taxonomy, array( 'hide_empty' => 0, 'parent' => $parent  ));
				if(!empty($cats)){
				
				?>
				<div class="col-12 mb-2">
						<label><?php if($taxonomy == "listing"){ echo __("Category","premiumpress"); }else{ echo $CORE->GEO("translation_tax_key", $taxonomy); } ?></label>
						<select name="tax-<?php echo $taxonomy; ?>" class="form-control rounded-0">
						  <option value=""><?php echo __("Any","premiumpress"); ?></option>
						  <?php
								  $count = 1;
								  $cats = get_terms( $taxonomy, array( 'hide_empty' => 1, 'parent' => 0  ));
								  if(!empty($cats)){
								  foreach($cats as $cat){ 
								  if($cat->parent != 0){ continue; } 
								   
								  ?>
						  <option value="<?php echo $cat->term_id; ?>" <?php if(isset($_GET['tax-listing']) && $_GET['tax-listing'] == $cat->term_id){ echo "selected=selected"; } ?>>
						  <?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?>
                          </option>
						  <?php $count++; } } ?>
						</select>
				</div>
				<?php
				
				}
			
			}
			
			
			} break;
		
		} 
		}
  
   } ?>
   
   
      <div class="col-12">
      <button class="btn-block btn btn-primary py-3 mt-3" type="submit"> <?php echo __("Search","premiumpress"); ?></button>
    </div>
   
  
  <?php }else{ ?>
  
  
  
  
  
  
  <?php switch(THEME_KEY){
  
  case "es":
  case "da": {    ?>
    
  <div class="row">
    <div class="col-12">
      <div class="form-input mb-2">
        <label><?php echo __("Im looking for","premiumpress"); ?></label>
        
        
  <?php if(THEME_KEY == "es"){ ?>
  
    <select name="tax-dathnicity" class="form-control mb-4 mb-md-0 rounded-0"  data-live-search="true">
      <option value=""><?php echo __("Any Ethnicity","premiumpress"); ?></option>
      <?php
$count = 1;
$cats = get_terms( 'dathnicity', array( 'hide_empty' => 0, 'parent' => 0  ));
if(!empty($cats)){
foreach($cats as $cat){ 
if($cat->parent != 0){ continue; } 
 
?>
      <option value="<?php echo $cat->term_id; ?>"> <?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
      <?php $count++; } } ?>
    </select>
  
  
  <?php }else{ ?>
        
    <select name="tax-dagender" class="form-control mb-4 mb-md-0 rounded-0"  data-live-search="true">
      <option value=""><?php echo __("Any Gender","premiumpress"); ?></option>
      <?php
$count = 1;
$cats = get_terms( 'dagender', array( 'hide_empty' => 0, 'parent' => 0  ));
if(!empty($cats)){
foreach($cats as $cat){ 
if($cat->parent != 0){ continue; } 
 
?>
      <option value="<?php echo $cat->term_id; ?>"> <?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
      <?php $count++; } } ?>
    </select>
    
    <?php } ?>
    
      </div>
    </div>
    <div class="col-12">
      <div class="form-input mb-2">
        <label><?php echo __("Aged","premiumpress"); ?></label>
   <select name="age1" class="form-control mb-4 mb-md-0 rounded-0"  data-live-search="true">
      <option value=""><?php echo __("Any Age","premiumpress"); ?></option>
      <option value="20">20+</option>
      <option value="30">30+</option>
      <option value="40">40+</option>
      <option value="50">50+</option>
    </select>
      </div>
    </div>
    <?php if(_ppt(array('maps','enable')) == 1){ ?>
    <div class="col-12">
    
    
    <?php  if(_ppt(array("maps","provider")) == "basic"){  ?>
    <div class="form-input mb-2">
        <label><?php echo __("Location","premiumpress"); ?></label>
        <?php echo _get_country_search_box(); ?>
        </div>
        <?php }else{ ?>
    
      <div class="form-input mb-2">
        <label><?php echo __("Location","premiumpress"); ?></label>
<div class="form-input position-relative">
      <input name="zipcode" class="form-control" id="homesearchzip"  placeholder="<?php echo __("Any Location","premiumpress"); ?>" />
      <span  style="top: 11px; right: 10px; position: absolute;    z-index: 100;color:#000; cursor:pointer;" <?php if(_ppt(array('maps','enable'))){ ?>onclick="getCurrentLocation();"<?php } ?>><span class="fal fa-map-marker"></span></span> </div>
      </div>
      <?php } ?>
      
    </div>
    <?php } ?>
    <div class="col-12">
      <button class="btn-block btn btn-primary py-3 mt-3" type="submit"> <?php echo __("Search","premiumpress"); ?></button>
    </div>
  </div>   
<?php } break; case "dl": {    ?>
  <div class="row">
    <div class="col-12">
      <div class="form-input mb-2">
        <label><?php echo __("Manufacturer","premiumpress"); ?></label>
        <select name="tax-make" class="form-control" id="reg_field_tax_make" onchange="ChangeSearchValues('',this.value,'model__make','tx_model[]','-1','0', 'reg_field_tax_model')">
          <option value=""><?php echo __("Any","premiumpress"); ?></option>
          <?php
                  $count = 1;
                  $cats = get_terms( 'make', array( 'hide_empty' => 1, 'parent' => 0  ));
                  if(!empty($cats)){
                  foreach($cats as $cat){ 
                  if($cat->parent != 0){ continue; } 
                   
                  ?>
          <option value="<?php echo $cat->term_id; ?>" <?php if(isset($_GET['tax-make']) && $_GET['tax-make'] == $cat->term_id){ echo "selected=selected"; } ?>> <?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
          <?php $count++; } } ?>
        </select>
        
<script>
function ChangeSearchValues(e, t, a, o, n, r, i) {	
	
	  jQuery.ajax({
        type: "GET",  
		url: ajax_site_url,	
        data: {
			core_aj: 1,
            action: "ChangeSearchValues",
			val: t,
            key: a,
			cl: o,
			pr: n,
			add: r,
        },
        success: function(r) { 
		
		jQuery('#'+i).html(r);
		jQuery('#'+i).prop('disabled', false);
		
        },
        error: function(e) {
             
        }
    });	
 
} 
</script>
      </div>
    </div>
    <div class="col-12">
      <div class="form-input mb-2">
        <label><?php echo __("Model","premiumpress"); ?></label>
        <select name="tax-model" class="form-control"  id="reg_field_tax_model">
          <option value=""><?php echo __("Any","premiumpress"); ?></option>
        </select>
      </div>
    </div>
    <div class="col-12">
      <div class="form-input mb-2">
        <label><?php echo __("Max Price","premiumpress"); ?></label>
       
        
   <div class="input-group">   
	<input class="form-control numericonly" name="price2" value="" placeholder="<?php echo __("Any","premiumpress"); ?>"/>     
    <div class="position-absolute text-muted" style="bottom: 8px;    right: 10px;"><?php echo hook_currency_symbol(''); ?></div>
    </div>
        
        
      </div>
    </div>
    <div class="col-12">
      <button class="btn-block btn btn-primary py-3 mt-3" type="submit"> <?php echo __("Search","premiumpress"); ?></button>
    </div>
  </div>
  <?php } break; default: {
?>
  
  <div class="row">
    <div class="col-12">
      <div class="form-input mb-2 position-relative">
        <label><?php echo __("Keyword","premiumpress"); ?></label>
        <input name="s" class="form-control" />
        <span  style="top: 40px; right: 10px; position: absolute;    z-index: 100;"><span class="fal fa-search"></span></span> 
      </div>
    </div>
    <div class="col-12">
      <div class="form-input mb-2">
      
      
      
              <?php if(THEME_KEY == "cp"){ ?>
       <label><?php echo __("Store","premiumpress"); ?></label>
        <select name="tax-store" class="form-control rounded-0">
          <option value=""><?php echo __("Any Store","premiumpress"); ?></option>
          <?php
                  $count = 1;
                  $cats = get_terms( 'store', array( 'hide_empty' => 1, 'parent' => 0  ));
                  if(!empty($cats)){
                  foreach($cats as $cat){ 
                  if($cat->parent != 0){ continue; } 
                   
                  ?>
          <option value="<?php echo $cat->term_id; ?>" <?php if(isset($_GET['tax-listing']) && $_GET['tax-listing'] == $cat->term_id){ echo "selected=selected"; } ?>> <?php 
		  
		  
		  
		  
		  
		  if( defined('WLT_DEMOMODE') ){
		 
				$did = filter_var($cat->name, FILTER_SANITIZE_NUMBER_INT);	
			 				
				if(is_numeric($did) && isset($GLOBALS['CORE_THEME']['storedata'][$did]['title'])){
							
					echo $GLOBALS['CORE_THEME']['storedata'][$did]['title'];
								
				}else{
				
					echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); 
				}
		
	 
		}else{
		
				echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); 
		
		}
		  
		  
		  
		  
		  
		   ?></option>
          <?php $count++; } } ?>
        </select>
        
        <?php }else{ ?>
        
        <label><?php echo __("Category","premiumpress"); ?></label>
        <select name="tax-listing" class="form-control rounded-0">
          <option value=""><?php echo __("Any","premiumpress"); ?></option>
          <?php
                  $count = 1;
                  $cats = get_terms( 'listing', array( 'hide_empty' => 1, 'parent' => 0  ));
                  if(!empty($cats)){
                  foreach($cats as $cat){ 
                  if($cat->parent != 0){ continue; } 
                   
                  ?>
          <option value="<?php echo $cat->term_id; ?>" <?php if(isset($_GET['tax-listing']) && $_GET['tax-listing'] == $cat->term_id){ echo "selected=selected"; } ?>> <?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
          <?php $count++; } } ?>
        </select>
        
        <?php } ?>
        
      </div>
    </div>
    <div class="col-12">
      <div class="form-input mb-2">
        <?php if(THEME_KEY == "jb"){ ?>
        <label><?php echo __("Job Type","premiumpress"); ?></label>
        <?php 
		$foundcats 	= get_terms( "jobtype", array( 'hide_empty' => 0  ));
	
			 ?>
        <select class="form-control form-control-custom" name="jobtype">
          <option value=""><?php echo __("All Types","premiumpress"); ?></option>
          <?php if(is_array($foundcats) && !empty($foundcats)){
		foreach($foundcats as $cat){ ?>
          <option value="<?php echo $cat->term_id; ?>"><?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
          <?php
			 
		}
	}	?>
        </select>
        <?php }elseif(in_array(THEME_KEY, array("vt","ll"))){ ?>
        <label><?php echo __("Level","premiumpress"); ?></label>
        <?php 
		$foundcats 	= get_terms( "level", array( 'hide_empty' => 0  ));
	
			 ?>
        <select class="form-control form-control-custom" name="tax-level">
          <option value=""><?php echo __("All Types","premiumpress"); ?></option>
          <?php if(is_array($foundcats) && !empty($foundcats)){
		foreach($foundcats as $cat){ ?>
          <option value="<?php echo $cat->term_id; ?>"><?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
          <?php
			 
		}
	}	?>
        </select>
        
        
        <?php }elseif(THEME_KEY == "cp"){ ?>
        
        <?php 
		$foundcats 	= get_terms( "listing", array( 'hide_empty' => 0  ));
	
			 ?>
             <label><?php echo __("Category","premiumpress"); ?></label>
        <select class="form-control form-control-custom" name="tax-listing">
          <option value=""><?php echo __("Any Category","premiumpress"); ?></option>
          <?php if(is_array($foundcats) && !empty($foundcats)){
		foreach($foundcats as $cat){ ?>
          <option value="<?php echo $cat->term_id; ?>"><?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
          <?php
			 
		}
	}	?>
        </select>
        
              <?php }elseif(THEME_KEY == "ph"){ ?>
        
        <label><?php echo __("Orientation","premiumpress"); ?></label>
        
                <?php  $foundcats 	= get_terms( "orientation", array( 'hide_empty' => 0  )); ?>
        <select class="form-control form-control-custom" name="tax-orientation">
          <option value=""><?php echo __("Any","premiumpress"); ?></option>
          <?php if(is_array($foundcats) && !empty($foundcats)){
		foreach($foundcats as $cat){ ?>
          <option value="<?php echo $cat->term_id; ?>"><?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
          <?php
			 
		}
	}	?>
        </select>
       
        
        <?php }elseif(THEME_KEY == "dt"){ ?>
        <label><?php echo __("Location","premiumpress"); ?></label>
        
        <?php  if(_ppt(array("maps","provider")) == "basic"){  ?>
        <?php echo _get_country_search_box(); ?>
        <?php }else{ ?>
        
        <div class="position-relative">
          <input type="text" class="form-control w-100 customfilter" name="zipcode" value="<?php if(isset($_GET['zipcode'])) { echo esc_attr($_GET['zipcode']); } ?>" placeholder="<?php echo __("City or Zipcode","premiumpress"); ?>" />
          <span  style="top: 10px; right: 10px; position: absolute;    z-index: 100;"><span class="fal fa-map-marker"></span></span>
        </div>
        <input type="hidden" id="radiusf" class="hidden customfilter" name="radius" data-type="text" data-key="radius" value="0">
        
        <?php } ?>
        
        
        <?php }else{ ?>
        <label><?php echo __("Max Price","premiumpress"); ?></label>
           <div class="input-group">   
	<input class="form-control numericonly" name="price2" value="" placeholder="<?php echo __("Any","premiumpress"); ?>"/>
    
     
    <div class="position-absolute text-muted" style="bottom: 8px;    right: 10px;"><?php echo hook_currency_symbol(''); ?></div>

    </div>
        
        
        
        <?php } ?>
        
        
        
      </div>
    </div>
    <div class="col-12">
      <button class="btn-block btn btn-primary py-3 mt-3" type="submit"> <?php echo __("Search","premiumpress"); ?></button>
    </div>
  </div> 
  <?php } break;  }  ?>
  
  <?php } ?>
  
</form>