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
 
 
global $settings, $CORE, $CORE_ADMIN;

 // GET SAVED DAT
 $tax = get_option('custom_taxonomy');  
              
// GET LANGUAGES
$langs = _ppt('languages');

$taxonomies = get_taxonomies(); 
 

  $settings = array(
  
  "title" => __("Customize","premiumpress"), 
  "desc" => __("Here you can change the display options for your taxonomies.","premiumpress"),
  "video" => "https://www.youtube.com/watch?v=qqEYntVIJiA",
  
  );?>
  
<div id="taxmanage">
  <?php    _ppt_template('framework/admin/_form-wrap-top' ); ?>
  
   
<div class="card card-admin">
  <div class="card-body">
<input type="hidden" value="0" name="admin_values[hidetax][0]"  /> 
<input type="hidden" value="0" name="admin_values[taxmulti][0]"  />
<input type="hidden" value="0" name="admin_values[listingtax][0]"   />
<input type="hidden" value="0" name="admin_values[searchtax][0]"   />
<div class="clearfix btn-block my-4">
  <div class="row mb-2">
    <div class="col-5 small text-muted"> <?php echo __("Display Caption","premiumpress"); ?> </div>
   
    <div class="col-2 small text-muted px-0"><?php echo __("Search Page","premiumpress"); ?> </div>
    
    <?php if(THEME_KEY == "sp"){ ?>
  <div class="col-2 small text-muted text-center"> <?php echo __("Listing Page","premiumpress"); ?> </div>
    <?php } ?>
    
    
    
    <div class="col-2 small text-muted text-center"> <?php echo __("Multi Select","premiumpress"); ?> </div>
    
    
     <?php if(THEME_KEY != "sp"){ ?>
  <div class="col-2 small text-muted text-center"> <?php echo __("Hide","premiumpress"); ?> </div>
    <?php } ?>
    
    
    <div class="col-1 px-0 small text-muted text-center"> <?php echo __("Order","premiumpress"); ?> </div>
    
  </div>
  <hr />
  <?php


$orderscat = array();

$i=1;
foreach ( $taxonomies as $taxonomy ) {
if(in_array($taxonomy, array('category','post_tag','nav_menu','link_category','post_format','listing','elementor_library_type','elementor_library_category', 'elementor_font_type', 

'topic-tag', 'product_type', 'product_visibility', 'product_cat', 'product_tag', 'product_shipping_class', 'pa_color', 'pa_size', 'advanced_ads_groups', 'wpbdp_category'


 
))){ continue; } 



$defaulticon = "fa fa-check";

/*
if(THEME_KEY == "da" && in_array($taxonomy, array('dagender','features','sexuality','dathnicity','daeyes','dahair','dabody','dasmoke','dadrink','dasexuality'


 
))){ continue; } 
*/
 

// CHECK FOR THINGS TURNED OFF
if($taxonomy == "dagender"){
	 
	$defaulticon = "fal fa-user";
} 
// CHECK FOR THINGS TURNED OFF
if($taxonomy == "dasexuality"){
	 
	$defaulticon = "fal fa-smile-wink";
}
// CHECK FOR THINGS TURNED OFF
if($taxonomy == "dathnicity"){
	 
	$defaulticon = "fal fa-globe-americas";
}

// CHECK FOR THINGS TURNED OFF
if($taxonomy == "daeyes"){
	 
	$defaulticon = "fal fa-eye";
}
// CHECK FOR THINGS TURNED OFF
if($taxonomy == "dahair"){
 
	$defaulticon = "fal fa-palette";
}

// CHECK FOR THINGS TURNED OFF
if($taxonomy == "dabody"){
	 
	$defaulticon = "fal fa-dewpoint";
}


// CHECK FOR THINGS TURNED OFF
if($taxonomy == "dasmoke"){
	 
	$defaulticon = "fal fa-smoking";
}

// CHECK FOR THINGS TURNED OFF
if($taxonomy == "dadrink"){
	 
	$defaulticon = "fal fa-beer";
}


if($taxonomy == "condition"){

	$defaulticon = "fal fa-box";
}
if($taxonomy == "delivery"){

	$defaulticon = "fal fa-ship";
}

if(THEME_KEY == "dl"){
	switch($taxonomy){
	
		case "make": { $defaulticon = "fal fa-car"; } break;
		case "model": { $defaulticon = "fal fa-car-side"; } break;
		case "fuel": { $defaulticon = "fal fa-gas-pump"; } break;
		case "condition": { $defaulticon = "fal fa-car-garage"; } break;
		case "body": { $defaulticon = "fal fa-cars"; } break;
		case "transmission": { $defaulticon = "fal fa-battery-bolt"; } break;
		case "exterior": { $defaulticon = "fal fa-brush"; } break;
		case "interior": { $defaulticon = "fal fa-fill"; } break;
		case "doors": { $defaulticon = "fal fa-door-open"; } break;
		case "engine": { $defaulticon = "fal fa-car-battery"; } break;
		case "drive": { $defaulticon = "fal fa-steering-wheel"; } break;
		case "seller": { $defaulticon = "fal fa-user"; } break;
		case "owners": { $defaulticon = "fal fa-users"; } break;
	
	}
}


if(THEME_KEY == "rt"){
	switch($taxonomy){
	
		case "beds": { $defaulticon = "fal fa-bed"; } break;
		case "baths": { $defaulticon = "fal fa-bath"; } break;
		 
	}
}
 


if(!taxonomy_exists($taxonomy)){
continue;
}

$defaultlistingtax = 0;

if( in_array($taxonomy, array("dagender","dasexuality","dathnicity","daeyes","dahair","dabody","dasmoke","dadrink","features","condition", "make", "model", "condition", "body", "fuel", "transmission", "exterior", "interior", "doors", "seller", "engine", "drive","owners", "beds","baths", 'experience', 'jobtype','color','size')) ){
$defaultlistingtax = 1;

}
 



?>
  <div class="row mt-2 taxrowtop">
  
  
     <div class="col-1">
     
      <input type="hidden" name="admin_values[taxicon][<?php echo $taxonomy; ?>]" id="tax_icon_<?php echo $taxonomy; ?>"  value="<?php if(_ppt(array('taxicon', $taxonomy)) != "" && _ppt(array('taxicon', $taxonomy)) != "fa fa-cog"){ echo str_replace("fa fa ","fa ", _ppt(array('taxicon', $taxonomy))); }else{ echo $defaulticon; }  ?>" />
     
      <i class="<?php if(_ppt(array('taxicon', $taxonomy)) != "" && _ppt(array('taxicon', $taxonomy)) != "fa fa-cog"){ echo str_replace("fa fa ","fa ",_ppt(array('taxicon', $taxonomy))); }else{ echo $defaulticon;; }  ?> float-left mr-2 fa-1x border p-2" style="cursor:pointer;" id="tax_icon_<?php echo $taxonomy; ?>_icon" onclick="loadiconbox('tax_icon_<?php echo $taxonomy; ?>','<?php if(_ppt(array('taxicon', $taxonomy)) != ""){ echo _ppt(array('taxicon', $taxonomy)); }else{ echo $defaulticon; }  ?>');"></i>
      
      
     </div>
      
         
  
    <div class="col-4">
    
    
     

     
     
    
      <input class="form-control small" name="admin_values[taxcaption][<?php echo $taxonomy; ?>]"  value="<?php if(_ppt(array('taxcaption', $taxonomy)) != ""){ echo _ppt(array('taxcaption', $taxonomy)); }else{ echo $taxonomy; }  ?>" />
      <div> <a href="edit-tags.php?taxonomy=<?php echo $taxonomy; ?>&post_type=listing_type" class="tiny" target="_blank"><?php echo __("manage values","premiumpress"); ?></a>
        <?php if(is_array($langs) && !empty($langs) && count($langs) > 1   ){  ?>
        <a href="javascript:void(0);" onclick="jQuery('.showtaxtranslations<?php echo str_replace(" ","-",$taxonomy); ?>').toggle();" class="tiny ml-3"><?php echo __("Show translations","premiumpress"); ?></a>
        <?php } ?>
      </div>
      <?php if(is_array($langs) && !empty($langs) && count($langs) > 1 ){ ?>
      <div id="" class="p-3 py-2 bg-light mt-3 showtaxtranslations<?php echo str_replace(" ","-",$taxonomy); ?>" style="display:none;">
        <?php foreach(_ppt('languages') as $lang){
			
					$icon = explode("_",$lang); 
			
					if(_ppt(array('lang','default')) == "en_US" && isset($icon[1]) && strtolower($icon[1]) == "us"){ continue; } 
				
				?>
        <div class="mt-3">
          <div class="mb-2 small">
            <div class="flag flag-<?php if(isset($icon[1])){ echo strtolower($icon[1]); }else{ echo $icon[0]; } ?> mr-2">&nbsp;</div>
            <?php echo $CORE->GEO("get_lang_name", strtolower($lang)); ?> </div>
          <input class="form-control small" name="admin_values[taxcaption_<?php echo strtolower($lang); ?>][<?php echo $taxonomy; ?>]" 
                    value="<?php if(_ppt(array('taxcaption_'.strtolower($lang), $taxonomy)) != ""){ echo _ppt(array('taxcaption_'.strtolower($lang), $taxonomy)); }else{ echo $taxonomy; }  ?>" />
        </div>
        <?php } ?>
      </div>
      <?php } ?>
    </div>
    
 
      
      
    <div class="col-2">
      <label class="custom-control custom-checkbox mt-2 ml-2">
      <input type="checkbox" class="custom-control-input customfilter" 
value="<?php echo $taxonomy; ?>" name="admin_values[searchtax][]" <?php if(is_array(_ppt('searchtax')) && in_array($taxonomy, _ppt('searchtax'))){ echo "checked=checked"; } ?> />
      <div class="custom-control-label"> &nbsp; </div>
      </label>
    </div>
    
    <?php if(THEME_KEY == "sp"){ ?>
    <div class="col-2 border-right">
      <label class="custom-control custom-checkbox mt-2 ml-3">
      <input type="checkbox" class="custom-control-input customfilter" 
value="<?php echo $taxonomy; ?>" name="admin_values[listingtax][]" <?php if( ( $defaultlistingtax == 1 && !is_array(_ppt('listingtax')) ) || is_array(_ppt('listingtax')) && in_array($taxonomy, _ppt('listingtax'))){ echo "checked=checked"; } ?> />
      <div class="custom-control-label"> &nbsp; </div>
      </label>
    </div>
	<?php } ?>
    
    
      <div class="col-2 pr-0 text-center">
      <label class="custom-control custom-checkbox mt-2 ml-4">
      <input type="checkbox" class="custom-control-input customfilter"  
value="<?php echo $taxonomy; ?>" name="admin_values[taxmulti][]" <?php if(is_array(_ppt('taxmulti')) && in_array($taxonomy, _ppt('taxmulti'))){ echo "checked=checked"; } ?> />
      <div class="custom-control-label"> &nbsp; </div>
    </div>
    
       <?php if(THEME_KEY != "sp"){ ?>
 
 
 <div class="col-2 pr-0 text-center">
      <label class="custom-control custom-checkbox mt-2 ml-4">
      <input type="checkbox" class="custom-control-input customfilter"  
value="<?php echo $taxonomy; ?>" name="admin_values[hidetax][]" <?php if(is_array(_ppt('hidetax')) && in_array($taxonomy, _ppt('hidetax'))){ echo "checked=checked"; } ?> <?php if(in_array($taxonomy, array("features"))){ echo "disabled"; } ?> />
      <div class="custom-control-label"> &nbsp; </div>
    </div>
 
 
    <?php } ?>
    
    
    
    <div class="col-1 px-0">
      <input class="form-control numericonly" name="admin_values[taxorder][<?php echo $taxonomy; ?>]"  value="<?php if(_ppt(array('taxorder', $taxonomy)) != ""){ echo _ppt(array('taxorder', $taxonomy)); }else{ echo $i; }  ?>"
      
      
      <?php if(in_array(_ppt(array('taxorder', $taxonomy)), $orderscat)){ echo 'style="border:2px solid red !important;"'; }else{ $orderscat[_ppt(array('taxorder', $taxonomy))] = _ppt(array('taxorder', $taxonomy)); } ?>
       />
    </div>
    
    
  
  </div>
  <?php $i++; } ?>
 
</div>

 

      <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
    
  </div>
</div>

<script>
jQuery(document).ready(function() {

if(jQuery('.taxrowtop').length == 0){
jQuery("#taxmanage").hide();
}

});
</script>
<!-- end admin card -->
<?php _ppt_template('framework/admin/_form-wrap-bottom' );  ?>

</div>
<?php 

  $settings = array(
  
  "title" => __("Add Taxonomies","premiumpress"), 
  "desc" => __("Enter a key for your new taxonomy and it'll be created automatically for you. Do NOT use numbers or SPACES in your taxonomy names.","premiumpress"),
  
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
  
   
<div class="card card-admin">
  <div class="card-body">
  
  
  
 
  
  <div class="container  px-0">
    <div class="row">
      <div class="col-md-6 ">
        <label class="mt-4"><?php echo __("Taxonomy 1 Key","premiumpress"); ?></label>
        <input class="form-control" type="text" id="cxtax0" name="adminArray[custom_taxonomy][0]" value="<?php if(isset($tax[0]) && strlen($tax[0]) > 1){ echo strip_tags(str_replace(" ","-",strtolower($tax[0]))); } ?>" maxlength="15" />
        
      <?php if(isset($tax[0]) && strlen($tax[0]) > 1){ ?>
     <div class="position-absolute" style="bottom: 10px; font-size:12px; right:30px; cursor:pointer; color:red; z-index:100" onclick="jQuery('#cxtax0').val(' ');"><i class="fa fa-times"></i> </div>   
      <?php } ?>
        
        
      </div>
      <div class="col-md-6 ">
        <label class="mt-4"><?php echo __("Taxonomy 2 Key","premiumpress"); ?></label>
        <input class="form-control" type="text" id="cxtax1" name="adminArray[custom_taxonomy][1]" value="<?php if(isset($tax[1]) && strlen($tax[1]) > 1 ){ echo strip_tags(str_replace(" ","-",strtolower($tax[1])));   } ?>" maxlength="15" />
        
        <?php if(isset($tax[1]) && strlen($tax[1]) > 1){ ?>
     <div class="position-absolute" style="bottom: 10px; font-size:12px; right:30px; cursor:pointer; color:red; z-index:100" onclick="jQuery('#cxtax1').val(' ');"><i class="fa fa-times"></i> </div>   
      <?php } ?>
        
        
      </div>
    </div>
    
    <a href="javascript:void(0);" onclick="jQuery('#showmoretax').toggle();" class="btn btn-light rounded-0 btn-sm mt-3"><?php echo __("show more","premiumpress"); ?></a>
   
    <div id="showmoretax" style="display:none;">
      <div class="row">
        <?php $g=1; $i=2; while($i < 20){ ?>
        <!---- FIELD --->
        <div class="col-md-6 ">
          <label><?php echo __("Taxonomy","premiumpress"); ?> <?php echo ($i)+1; ?> Key</label>
          <input class="form-control" type="text" id="cxtax<?php echo $i; ?>"  name="adminArray[custom_taxonomy][<?php echo $i; ?>]" value="<?php if(isset($tax[$i]) && strlen($tax[$i]) > 1){ echo strip_tags(str_replace(" ","-",strtolower($tax[$i]))); }?>" maxlength="15" />
       
       
       <?php if(isset($tax[$i]) && strlen($tax[$i]) > 1){ ?>
     <div class="position-absolute" style="bottom: 10px; font-size:12px; right:30px; cursor:pointer; color:red; z-index:100" onclick="jQuery('#cxtax<?php echo $i; ?>').val(' ');"><i class="fa fa-times"></i> </div>   
      <?php } ?>
       
        </div>
        <!---- FIELD --->
        <?php if($g == 2){ $g = 0; echo "</div><div class='row mt-3'> "; } ?>
        <?php $i++; $g++; } ?>
      </div>
    </div>
 
</div>
   

      <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
    
  </div>
</div>
<!-- end admin card -->
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>

 