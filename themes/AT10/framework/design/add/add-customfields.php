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


	switch(THEME_KEY){
		
		case "da": {
		
			$title = __("About Me","premiumpress");
			 
		} break;
		
		default: {
		
			$title =  __("Details","premiumpress"); 
		 
		} break;
	
	}




$editID=0;

if(isset($_GET['eid']) && is_numeric($_GET['eid'])){
$editID = $_GET['eid'];
} 

$o=0; 
$field = array();
$canEdit = true;


	if(THEME_KEY ==  "at" && isset($_GET['eid']) && !is_admin() ){ 
		
			// CHECK FOR BIDDING SO WE CAN DISABLE FIELDS
			$current_bidding_data = get_post_meta($_GET['eid'],'current_bid_data',true); 
			if(is_array($current_bidding_data) && !empty($current_bidding_data) ){ $canEdit = false; }
			  
		}



?>

<div class="row">
  <div class="col-12">
    <?php if(is_admin() || ( function_exists('current_user_can') && current_user_can('administrator')) ){ ?>
    <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=listingsetup" target="_blank" class="float-right text-uppercase mt-2 btn btn-system btn-sm"><i class="fa fa-sync"></i> <?php echo __("manage fields","premiumpress"); ?></a>
    <?php } ?>
    <h4><?php echo $title; ?></h4>
    <hr />
  </div>
  <?php
  
  if($canEdit){
  
echo str_replace("col-md-6","col-md-6",$CORE->BUILD_FIELDS(hook_add_fieldlist($field),''));		
 if(THEME_KEY != "cp" ){ 		
echo str_replace("col-md-6","col-md-6",$CORE->SUBMISSION_FIELDS(false,true)); // CUSTOM FIELDS
}
}elseif(THEME_KEY == "at"){
?>
<div class="col-12">
<div class="p-3 text-center small">
<div class="alert alert-info">
<i class="fal fa-info-circle"></i> <?php echo __("Auction details cannot be modified once bids have been received.","premiumpress"); ?>
</div>
</div>
</div>
<?php } ?>
</div>
<?php if(isset($_POST['ajaxedit'])){



 ?>

<script>
 
jQuery(document).ready(function(){
jQuery('.customid-0').show(); 

<?php

// GET CATEGORY LIST FROM TERMS OBJEC
if(isset($_GET['eid'])){ 
	$foundcats 	= wp_get_object_terms( $_GET['eid'], 'listing' );
	if(is_array($foundcats) && !empty($foundcats)){
		foreach($foundcats as $cat){?>
		jQuery('.customid-<?php echo $cat->term_id; ?>').show(); 
		<?php
		}
	}	
}

?>

jQuery('.selectpicker').selectpicker('refresh');


});

</script>
<?php } ?>
