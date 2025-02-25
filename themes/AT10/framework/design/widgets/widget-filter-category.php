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

/*
if(isset($GLOBALS['flag-taxonomy']) && is_numeric($GLOBALS['flag-taxonomy-id']) && $GLOBALS['flag-taxonomy-id'] > 0){ 

	$cats = get_terms( 'listing', array( 'hide_empty' => 1, 'parent' => $GLOBALS['flag-taxonomy-id']  ));

	if(empty($cats)){
	//$cats = get_terms( 'listing', array( 'hide_empty' => 1, 'parent' => 0  ));
	
	$GLOBALS['flag-showresetbutton'] = 1;
	
	}else{
	
		$backcats = 1;
	}

}else{

$cats = get_terms( 'listing', array( 'hide_empty' => 1, 'parent' => 0  ));

}*/

$cats = get_terms( 'listing', array( 'hide_empty' => 1, 'parent' => 0  ));

$showhide = _ppt(array('search','showhide'));
if(!is_numeric($showhide)){
$showhide = 5;
}


if(isset($GLOBALS['flag-showresetbutton'])){

?>

<div class="border p-2 bg-light my-3 small">
<?php echo str_replace("%s", "<strong>".$CORE->GEO("translation_tax", array($GLOBALS['flag-taxonomy-id'], $GLOBALS['flag-taxonomy-name']))."</strong>",  __("Results for %s category only.","premiumpress") ); ?>
 <a href="<?php echo home_url(); ?>/?s="><?php echo __("Click here","premiumpress"); ?></a> <?php echo __("for full search.","premiumpress"); ?>
</div>

<?php

}
 
if(!empty($cats)){

?>

<div class="card card-filter">
  <div class="card-body">
   <a href="#" data-toggle="collapse" data-target="#collapse_categories" aria-expanded="true">
    <h5 class="small text-black"><?php echo __("Category","premiumpress"); ?></h5>
    </a>
    <div class="filter-content collapse" id="collapse_categories">
     
     <?php if(isset($backcats)){ ?>
     <div class="mb-4">
     <a href="<?php echo home_url(); ?>/?s=" class="text-dark small"><u> <i class="fa fa-arrow-left mr-2"></i> <?php echo __("Back to all categories","premiumpress"); ?></u></a>
     </div>
     <?php } ?>
     <div class="filter_maxheight max_height_listing" <?php if(count($cats) > $showhide ){ ?>style="max-height:<?php echo $showhide*32; ?>px; overflow:hidden;"<?php } ?>>

     
      <?php
$count = 1;

foreach($cats as $cat){ 

	$has_children = get_terms( 'listing', array( 'hide_empty' => 0, 'parent' => $cat->term_id   ));


 
 
?>
      <label class="custom-control custom-checkbox f-<?php echo "listing-".$cat->term_id; ?>" id="catid-<?php echo $cat->term_id; ?>">
      <input type="checkbox"  value="<?php echo $cat->term_id; ?>" name="catid[]" class="custom-control-input customfilter" onclick="_filter_update()"

  data-divid="catid-<?php echo $cat->term_id; ?>" <?php if(isset($_GET['tax-listing']) && $_GET['tax-listing'] == $cat->term_id){ echo "checked=checked"; } ?> data-key="catid" data-value="<?php echo $cat->term_id; ?>" data-old-value="" data-type="checkbox" <?php if(isset($GLOBALS['flag-taxonomy']) && is_numeric($GLOBALS['flag-taxonomy-id']) && $GLOBALS['flag-taxonomy-id'] > 0 ){  ?>disabled<?php } ?>>
  
  
  
      <div class="custom-control-label <?php if(_ppt(array('search','count')) != 1){ ?>addcount<?php } ?>" data-countkey="catid-<?php echo $cat->term_id; ?>"> 
	  
	  <a href="<?php echo get_term_link( $cat->term_id, "listing"); ?>" class="text-dark">
	  <?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?>
      
      <?php if(!empty($has_children)){ ?> <i class="fa fa-caret-down text-muted tiny ml-2"></i> <?php } ?>
       </a>
      <b class="badge badge-pill badge-secondary float-right defaultvalue"><?php if($cat->count > 50){ echo "50+"; }elseif($cat->count > 20){ echo "20+"; }else{ echo $cat->count; } ?></b>
      
     
      
      </div>
      
      </label>
      
      
      
      <?php if(isset($GLOBALS['flag-taxonomy']) && is_numeric($GLOBALS['flag-taxonomy-id']) && $GLOBALS['flag-taxonomy-id'] > 0 && $GLOBALS['flag-taxonomy-id'] == $cat->term_id ){
	  
	  $subcats = get_terms( 'listing', array( 'hide_empty' => 1, 'parent' => $GLOBALS['flag-taxonomy-id']  ));
	  
	   
		foreach($subcats as $cat){  
 
	?>
      <label class="custom-control custom-checkbox f-<?php echo "listing-".$cat->term_id; ?>" id="catid-<?php echo $cat->term_id; ?>">
      <input type="checkbox"  value="<?php echo $cat->term_id; ?>" name="subcatid[]" class="custom-control-input customfilter" onclick="_filter_update()"

  data-divid="catid-<?php echo $cat->term_id; ?>" <?php if(isset($_GET['tax-listing']) && $_GET['tax-listing'] == $cat->term_id){ echo "checked=checked"; } ?> data-key="subcatid" data-value="<?php echo $cat->term_id; ?>" data-old-value="" data-type="checkbox">
  
  
  
      <div class="custom-control-label <?php if(_ppt(array('search','count')) != 1){ ?>addcount<?php } ?>" data-countkey="catid-<?php echo $cat->term_id; ?>"> 
	  
	  <a href="javascript:void(0)" style="text-decoration:none; border-bottom:1px dashed #ddd;" class="text-dark">
	  <?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?>
       
       </a>
      <b class="badge badge-pill badge-secondary float-right defaultvalue"><?php if($cat->count > 50){ echo "50+"; }elseif($cat->count > 20){ echo "20+"; }else{ echo $cat->count; } ?></b>
      
     
      
      </div>
      
      </label>
      
     <?php } ?>
      
      
      <?php } ?>
      
      
      
     
     
      <?php $count++; }  ?>
    </div>
    
    
      <?php if(count($cats) > $showhide ){ ?>
      <div class="mt-3"> <a href="javascript:void(0);" onclick="SetMaxHeightlisting('.max_height_listing');" class="text-primary"><u><span class="small showmoreless"><?php echo __("show more","premiumpress") ?></span></u></a> </div>
      <?php } ?>
    
     </div>
  </div>
  
</div>

<?php if(count($cats) > $showhide ){ ?>
<script>

function SetMaxHeightlisting(div){
	
	if(jQuery('.listing_hset').length > 0){
	
		jQuery('.max_height_listing').removeClass('listing_hset');
		
		 jQuery(div).css('max-height', '<?php echo $showhide*36; ?>px'); 
		 
		 jQuery('#collapse_tax-listing .showmoreless').html("<?php echo __("show more","premiumpress") ?>");
	
	}else{	
	
		jQuery('.max_height_listing').addClass('listing_hset');
		jQuery(div).css('max-height', '100%');  
		
		jQuery('#collapse_tax-listing .showmoreless').html("<?php echo __("show less","premiumpress") ?>");
	}
 

}
</script>
<?php } ?>

<?php } // end no cats?>