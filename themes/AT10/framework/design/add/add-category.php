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
		 		
 

$cats = get_terms( 'listing', array( 'hide_empty' => 0 ));
 
if(!empty($cats)){

?>



<?php if(is_admin() ){ ?>
 
<a href="admin.php?page=settings&lefttab=taxonomies" target="_blank" class="btn btn-system btn-sm mb-3 float-right"><i class="fal fa-plus"></i> <?php echo __("taxonomies","premiumpress"); ?></a>
 
<?php } ?>
<h6><?php echo __("Organize","premiumpress"); ?></h6>
<?php
  
//_ppt_template('framework/design/add/add-category-single' ); 

_ppt_template('framework/design/add/add-category-multiple' ); 


?>


<?php } ?>
<?php


// GET FIELDS
$cfields = array();

if(THEME_KEY != "sp"){
$cfields = get_option("cfields"); 
}

$taxonomies = get_taxonomies();

 
foreach ( $taxonomies as $taxonomy ) {
 
	// SKIP BAD TAX
	if(in_array($taxonomy, array('nav_menu','category','post_tag','post_format','link_category','listing','elementor_library_type','elementor_library_category', 'elementor_font_type', 

'topic-tag', 'product_type', 'product_visibility', 'product_cat', 'product_tag', 'product_shipping_class', 'pa_color', 'pa_size', 'advanced_ads_groups','events_categories','events_tags', 'wpbdp_category')) || 
	strpos($taxonomy,"plugin") !== false || 
	strpos($taxonomy,"yst") !== false || 
	strpos($taxonomy,"forms") !== false ||
	strpos($taxonomy,"-tags") !== false ||
	strpos($taxonomy,"-categories") !== false ||
	strpos($taxonomy,"-category") !== false ||
	strpos($taxonomy,"elementor") !== false ){ continue; }  
	
	
	// NEW
	if($taxonomy == "features"){ 	
	continue;	
	}
	
	// SKIP HIDE TAXONOMIES
	if(is_array(_ppt('hidetax')) && in_array($taxonomy, _ppt('hidetax')) ){
	continue;
	}
	
	// SKIP ALREADY ADDED TAXONOMIES
	if(isset($cfields['taxonomy']) && in_array($taxonomy, $cfields['taxonomy']) ){
	continue;
	} 
	

	// GET DATA
	if(in_array($taxonomy, array("listing"))){	
		$cats = get_terms( array( 'taxonomy' => $taxonomy, 'parent' => 0, 'hide_empty' => 0 )  );	
	}else{	
		$cats = get_terms( array( 'taxonomy' => $taxonomy,  'hide_empty' => 0  )  );	
	}	 

	// IF NOT ADMIN AND IS EMPTY, HIDE
	if(empty($cats) ){ //!is_admin() && 
	continue;
	} 
 

// GET CATEGORY LIST FROM TERMS OBJEC
$selected_categories = array();
if(isset($_GET['eid'])){ 
	$foundcats 	= wp_get_object_terms( $_GET['eid'], $taxonomy );
	if(is_array($foundcats) && !empty($foundcats)){
		foreach($foundcats as $cat){
			$selected_categories[$cat->term_id] = $cat->term_id;
		}
	}	
}


 


$display_caption = $CORE->GEO("translation_tax_key", $taxonomy);
 
if($taxonomy == "color"){
	$txicon = "fa fa-fill-drip";
}elseif($taxonomy == "size"){
	$txicon = "fa fa-swatchbook";
}elseif(_ppt(array('taxicon', $taxonomy)) != ""){ 
	$txicon = str_replace("fa fa ","fa ", _ppt(array('taxicon', $taxonomy))); 
}else{ 
	$txicon = "fa fa-cog";	
} 

?>
<div class="form-group">
  <label class="w-100 mb-2" style="z-index:100;">
  <?php if(is_admin()){ ?>
  
  
  
  <a href="<?php echo home_url(); ?>/wp-admin/edit-tags.php?taxonomy=<?php echo $taxonomy ?>&post_type=listing_type" target="_blank" class="small float-right text-uppercase"><?php echo __("manage","premiumpress"); ?></a>
 
 
  <?php if(THEME_KEY == "sp" && in_array($taxonomy, array("color","size")) ){ ?>
  
  
  <a class="small float-right mr-4 text-uppercase" href="javascript:void(0);" onClick="StartCopyNew<?php echo $taxonomy ?>(0,0);"><?php echo __("Add Price Change","premiumpress"); ?></a>
  <script>
  
	  function StartCopyNew<?php echo $taxonomy ?>(k, v){
	  
		var newfield = jQuery('#copynew-<?php echo $taxonomy ?>').clone(true).prependTo('#copynew-<?php echo $taxonomy ?>-list').show();
	 
		//addClass('testing123');
		 
		// NOW SET VALUES
		if(k != 0){
				newfield.find('select').attr('name','custom[price_addone_<?php echo $taxonomy; ?>][]').val(k);
				newfield.find('input').attr('name','custom[price_addone_'+k+'_value]').attr('disabled', false).val(v);
		}	
		
		i=1;
		 
	  }
  
    jQuery(document).ready(function(){
		jQuery('.copynewselect').on('change', function() {
			 
			val = jQuery(this).val();
			
			jQuery(this).attr('name','custom[price_addone_'+ jQuery(this).attr("data-tax") +'][]');
			
			jQuery(this).parent().parent().addClass('testing666').find('input').attr('name','custom[price_addone_'+ val +'_value]').attr('disabled', false);
			
		});
	});
  
  </script>
   
  <?php
  
  if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){
	  $v = get_post_meta($_GET['eid'], 'price_addone_'.$taxonomy, true );
	  if(is_array($v)){
		foreach($v as $po){
			
			$pv = get_post_meta($_GET['eid'],'price_addone_'.$po.'_value', true);
			 
			if($pv != ""){
			?>        
			<script>                
             jQuery(document).ready(function(){  StartCopyNew<?php echo $taxonomy ?>('<?php echo $po; ?>','<?php echo $pv; ?>');  });               
            </script>
            <?php
			}
		
		}
	  }  
  }
  
  ?>
  
  
  <?php } ?>
 
  <?php }?>
  
  <span class="<?php echo $txicon; ?> mr-2"></span> <?php echo $display_caption; ?></label>
  
  
<?php if(THEME_KEY == "dl" && $taxonomy == "make"){ ?>

  
   <select name="tax[make]" class="form-control" onchange="ChangeSearchValues('',this.value,'model__make','tx_model[]','-1','0', 'reg_field_tax_model');">
      <option value=""><?php echo __("Any Make","premiumpress"); ?></option>
      <?php
$count = 1;
$cats = get_terms( 'make', array( 'hide_empty' => 0, 'parent' => 0  ));
if(!empty($cats)){
foreach($cats as $cat){ 
if($cat->parent != 0){ continue; } 
 
?>
      <option value="<?php echo $cat->term_id; ?>" <?php if(isset($_GET['eid']) && in_array($cat->term_id, $selected_categories) ){ echo "selected=selected"; $makeID = $cat->term_id;  }?>>
      
      <?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?> <?php if($cat->count > 0){ ?>(<?php echo $cat->count; ?>)<?php } ?>
      
      </option>
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




 <?php   $count=0;  }elseif(THEME_KEY == "dl" && $taxonomy == "model"){ $count=0; ?>
  

  <select name="tax[model]" class="form-control" id="reg_field_tax_model">
      <option value=""><?php echo __("Any Model","premiumpress"); ?></option>
    </select>
    
<script>
	<?php if(isset($_GET['eid'])   ){ ?>
 jQuery(document).ready(function(){ 
   	
   	ChangeSearchValues('','<?php echo $makeID; ?>','model__make','tx_model[]','<?php if(is_array($selected_categories) && !empty($selected_categories)  ){  foreach($selected_categories as $gg){ echo $gg; } }else{ echo "-1"; } ?>','0', 'reg_field_tax_model');
   
   });  
<?php } ?>
</script>

<?php }else{ 


?>
   
  
  <select 
<?php  if( in_array($taxonomy, array("color","size")) || is_array(_ppt('taxmulti')) && in_array($taxonomy, _ppt('taxmulti'))  ){ ?> 

class="form-control border selectpicker" 
name="tax[<?php echo $taxonomy ?>][]"  
multiple  data-size="10" 

data-show-subtext="true" data-live-search="true"  

title=" " 

<?php }elseif($taxonomy == "features"){ ?>
class="form-control border selectpicker" 
multiple data-size="10" 

data-show-subtext="true" data-live-search="true"  
name="tax[<?php echo $taxonomy ?>][]"
title=" "
<?php }else{ ?>

class="form-control border "  
name="tax[<?php echo $taxonomy ?>]" <?php } ?>>

<?php

if(!empty($cats)){
foreach($cats as $cat){  
 
?>
  <option <?php if(in_array($cat->term_id, $selected_categories) ){ echo "selected=selected";  }  ?> value="<?php echo $cat->term_id; ?>">
  <?php if($cat->parent != 0){ ?>
  --
  <?php } ?>
 <?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
  <?php  } } ?>
  
</select> 





<?php if(THEME_KEY == "sp" && in_array($taxonomy, array("color","size")) ){ ?>



<div id="copynew-<?php echo $taxonomy; ?>-list"></div>

<div class="container px-0 mt-2" id="copynew-<?php echo $taxonomy; ?>" style="display:none;">
<div class="row">
    
    <div class="col-md-6"> 
   
  <select class="form-control border copynewselect" data-tax="<?php echo $taxonomy; ?>" name="" style="font-size:11px !important; height:25px !important;">
  <option value=""></option>
  <?php if(!empty($cats)){ foreach($cats as $cat){  
 
?>
  <option  value="<?php echo $cat->term_id; ?>">
  <?php if($cat->parent != 0){ ?>
  --
  <?php } ?>
 <?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
  <?php  } } ?>
   </select> 

   
    </div>
    <div class="col-md-6">
    
    <div class="position-relative"> 
    <input type="text" name="" disabled class="form-control numericonly" style="font-size:14px !important; height:25px !important; padding-left:20px !important;"   />
    
    
  
     <div class="position-absolute" style="bottom: 5px; font-size:12px; right: 10px; cursor:pointer; color:red; z-index:100" onclick="jQuery(this).prev('input').val('').parent().parent().parent().parent().hide();"><i class="fa fa-times"></i> </div>
     <div class="position-absolute" style="bottom: 4px; font-size:14px; left: 10px; color:#666"><?php echo hook_currency_symbol(''); ?></div>
    
    
    </div>
    
    </div>
</div>
</div>
 

<?php } ?>









<?php } ?>

</div>
<?php } ?>


 
<?php if(defined('WLT_CART') && is_admin() && !in_array(THEME_KEY, array("ph")) ){ ?>
<hr style="margin: 0px -20px 15px -20px;" />
<div class="row mb-4">
  <div class="col-6">
    <label><?php echo __("Enable Tax","premiumpress"); ?></label>
    <div class="formrow">
      <label class="radio off">
      <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('enable_tax').value='0'">
      </label>
      <label class="radio on">
      <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('enable_tax').value='1'">
      </label>
      <div class="toggle <?php if(isset($_GET['eid']) && $CORE->get_edit_data('tax_required', $_GET['eid']) == '1'){  ?>on<?php } ?>">
        <div class="yes">ON</div>
        <div class="switch"></div>
        <div class="no">OFF</div>
      </div>
    </div>
    <input type="hidden" id="enable_tax" class="form-control" name="custom[tax_required]" value="<?php if(isset($_GET['eid'])){  echo $CORE->get_edit_data('tax_required', $_GET['eid']); } ?>">
  </div>
  <div class="col-6">
    <label><?php echo __("Enable Shipping","premiumpress"); ?></label>
    <div class="formrow">
      <label class="radio off">
      <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('enable_shipping').value='0'">
      </label>
      <label class="radio on">
      <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('enable_shipping').value='1'">
      </label>
      <div class="toggle <?php if(isset($_GET['eid']) &&  $CORE->get_edit_data('ship_required', $_GET['eid']) == '1'){  ?>on<?php } ?>">
        <div class="yes">ON</div>
        <div class="switch"></div>
        <div class="no">OFF</div>
      </div>
    </div>
    <input type="hidden" id="enable_shipping" class="form-control" name="custom[ship_required]" value="<?php if(isset($_GET['eid'])){ echo $CORE->get_edit_data('ship_required', $_GET['eid']); } ?>">
  </div>
</div>
<?php } ?>

