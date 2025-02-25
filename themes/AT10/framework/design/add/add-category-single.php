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
			$selected_categories[$cat->term_id] = $cat->term_id;
		}
	}	
}


// GET FIELDS
$cfields = array();

if(THEME_KEY != "sp"){
$cfields = get_option("cfields"); 
}
 
if(isset($cfields['taxonomy']) && in_array("listing", $cfields['taxonomy']) ){

}else{

?>
<div id="catwrapper">

<label class="w-100">

<?php if(is_admin()){ ?>
<a href="<?php echo home_url(); ?>/wp-admin/edit-tags.php?taxonomy=listing&post_type=listing_type" target="_blank" class="small float-right"><?php echo __("manage","premiumpress") ?></a>
<?php }?>


<span class="custom-icon icon-category mr-2"></span> <?php echo __("Category","premiumpress") ?></label>



<select id="add-category" 

<?php if(is_admin()){ ?> 

class="form-control border mb-4 selectpicker" 
name="form[category][]" 
multiple 


<?php }else{ ?>
class="form-control border mb-4"
name="form[category][]" 
onChange="showcustomfields();"
<?php } ?>
>
<option value="0"><?php echo __("Select Category","premiumpress") ?></option>
<?php 
foreach($cats as $cat){  ?>
<option <?php if(in_array($cat->term_id, $selected_categories) ){ echo "selected=selected";  }  ?> value="<?php echo $cat->term_id; ?>">
<?php if($cat->parent != 0){ ?>
--
<?php } ?>
<?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
<?php } ?>
</select>


</div>

<?php } ?>

<?php if(is_admin()){ ?> 
<script>

jQuery(function() {

	jQuery('#add-category').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
	showcustomfields();
	}); 
});
</script>

<?php } ?>