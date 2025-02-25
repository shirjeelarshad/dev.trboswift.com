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

global $CORE;

$cats = get_terms( 'listing', array( 'hide_empty' => 0 )); 


// GET CATEGORY LIST FROM TERMS OBJEC
$selected_categories = array();
if(isset($_GET['eid'])){ 
	$foundcats 	= wp_get_object_terms( $_GET['eid'], 'listing' );	
	if(is_array($foundcats) && !empty($foundcats)){
		foreach($foundcats as $cat){
			$selected_categories[] = $cat->term_id;
		}
	}	
}

$selected_categories = array_reverse($selected_categories);	

$count = 1;
$cats = get_terms( 'listing', array( 'hide_empty' => 0, 'parent' => 0  ));
 
$catscount = count($cats);


// MULTIPLE CATEGORIES
$multiCat = false;
if(isset($_GET['eid'])){ 
   $MyPackageId = 1; // default
   if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ $MyPackageId = get_post_meta($_GET['eid'],'packageID',true); }
   if(!is_numeric($MyPackageId)){ $MyPackageId = 1; } 
	if(_ppt('pak'.$MyPackageId.'_category')){
		$multiCat = true;
	}
}


if(is_admin()){
	$multiCat = true;
}

// GET FIELDS
$cfields = array();
if(THEME_KEY != "sp"){
$cfields = get_option("cfields"); 
}

if(isset($cfields['taxonomy']) && in_array("listing", $cfields['taxonomy']) ){
	
	// SKIP AS ALREADY ADDED
	
}else{

?>

<div id="catwrapper" class="form-group">
<label class="w-100">

<?php if(is_admin()){ ?>
<a href="<?php echo home_url(); ?>/wp-admin/edit-tags.php?taxonomy=listing&post_type=listing_type" target="_blank" class="small float-right"><?php echo __("manage","premiumpress") ?></a>
<?php }?>
<span class="custom-icon icon-category mr-2"></span> <?php echo __("Category","premiumpress") ?>

</label> 

<select id="parent_category_list" name="form[category]<?php if($multiCat){ ?>[]<?php }else{ ?>[0]<?php } ?>" class="form-control <?php if($catscount > 10 || $multiCat){ ?>selectpicker border<?php } ?>" 
onchange="UpdateCategoryList()" <?php if($multiCat){ ?> data-size="10" multiple <?php } ?> <?php if($catscount > 10){ ?> data-live-search="true"<?php } ?>>


<?php
$count = 1;
$cats = get_terms( 'listing', array( 'hide_empty' => 0, 'parent' => 0  ));
if(!empty($cats)){

	foreach($cats as $cat){ 
	if($cat->parent != 0){ continue; } 

?>
<option value="<?php echo $cat->term_id; ?>" <?php if(in_array($cat->term_id, $selected_categories) ){ echo "selected=selected";  }  ?>>
	<?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?>
</option>

<?php $count++; } } ?>


</select>

<div id="subcategory_list" class=" mb-4" <?php if(isset($_GET['eid']) && isset($selected_categories[1]) ){ ?> <?php }else{ ?>style="display:none;"<?php } ?>>
<label class="mt-3"><?php echo __("Sub Category","premiumpress"); ?></label>
<select name="form[category]<?php if(is_admin()){ ?>[]<?php }else{ ?>[1]<?php } ?>"class="form-control <?php if(is_admin()){ ?>selectpicker<?php } ?>"  id="category_subs" >
<option value=""><?php echo __("Any","premiumpress"); ?></option>
</select>
</div>

</div>

<?php } // end skip ?>

<?php

$allcatids = "";
if(is_array($selected_categories) && !empty($selected_categories) ){
	foreach($selected_categories as $g){
		$allcatids .= $g.",";
	}
}

?>
<input type="hidden" id="callcatidsbox" value="<?php echo substr($allcatids,0,-1); ?>" id="" />
 
<script>

jQuery(document).ready(function(){ 
	UpdateCategoryList();
});



 
function UpdateCategoryList() { 
 
	jQuery('#category_subs').html("");
	
	var catids = "";
	
	jQuery("#parent_category_list > option:selected").each(function() {
		catids = catids + this.value+',';
	});
	
	showsubcategories(catids);
	  
}

function showsubcategories(catids){

	// SHOW CUSTOM FIELDS
	showcustomfields();
 	
	// NOW TRY SHOW SUB CATEGORIES
	if(catids == ""){
	return;
	}
	
	jQuery.ajax({
		type: "POST",
		url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
				action: "load_taxonomy_list",
				taxonomy1: "listing",
				parent:catids,
				child: jQuery("#callcatidsbox").val(),
		},
		success: function(response) {
		 
 			if(response.total > 0){				
				
				jQuery('#subcategory_list').show();			
				jQuery('#category_subs').html(response.output);
				
			} else{ 
				
				jQuery('#subcategory_list').hide();			
				jQuery('#category_subs').val("0");				
				
			}
			
			 <?php if(is_admin()){ ?>jQuery('#category_subs').selectpicker('refresh');<?php } ?>
			 
			  // SHOW CUSTOM FIELDS
			 showcustomfields();
			 	
				
		},
		error: function(e) {
			console.log(e)
		}
	});

}


function showcustomfields(){	
	
	jQuery('.customfield').hide();
	var sList = "";
	
	jQuery("#parent_category_list > option:selected").each(function(i, obj) {
		 
		catid = jQuery(obj).val();	 	 
		jQuery('.customid-' + catid).show();       	   
	});	
	
	if(jQuery("#category_subs").length > 0){
		jQuery("#category_subs > option:selected").each(function(i, obj) {
			 
			catid = jQuery(obj).val();	 	 
			jQuery('.customid-' + catid).show();       	   
		});	
	}	
	
	// SHOW ALL ALLOWED
	jQuery('.customid-0').show(); 
}




jQuery('#category_subs').on('change', function (e) {
    
  	showcustomfields();

});
 
</script>
          