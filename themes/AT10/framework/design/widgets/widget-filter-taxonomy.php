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

global $CORE, $userdata, $post, $wpdb, $settings; 

 // BUILD NEW ORDER
if(is_array(_ppt('searchtax'))){

$taxonomies = get_taxonomies(); 
$displaytax = array();
  
foreach ( $taxonomies as $taxonomy ) {

	if(in_array($taxonomy, _ppt('searchtax'))){  
	 	
		$to = _ppt(array('taxorder',$taxonomy));
		if($to == ""){ $to = 0; }
		
		$displaytax[$to] =  $taxonomy;
		
	}

}

 
 

// REORDER
ksort($displaytax);
 
foreach ( $displaytax as $taxonomy ) {


if(THEME_KEY == "vt" && $taxonomy == "level" && !in_array(_ppt(array('lst', 'vt_levels')), array("","1"))){
continue;
}


// AJAX REQUESTS FOR SINGLE CATS ON SEARC PAGE
if(isset($_POST['showtax']) && $_POST['showtax'] != "" && $taxonomy != $_POST['showtax']){ continue; }




$showhide = _ppt(array('search','showhide'));
if(!is_numeric($showhide)){
$showhide = 5;
}

if(in_array($taxonomy, _ppt('searchtax'))){ 

$parent = 0;
$count = 1;
$cats = get_terms( $taxonomy, array( 'hide_empty' => 0, 'parent' => $parent  ));
if(!empty($cats)){
 
 
 // Initialize arrays for numeric and text values
    $numeric_cats = array();
    $text_cats = array();

    // Separate numeric and text values
    foreach ($cats as $cat) {
        if (is_numeric($cat->name)) {
            $numeric_cats[] = $cat;
        } else {
            $text_cats[] = $cat;
        }
    }

    // Sort numeric values in descending order
    usort($numeric_cats, function ($a, $b) {
        return intval($b->name) - intval($a->name);
    });

    // Sort text values alphabetically
    usort($text_cats, function ($a, $b) {
        return strcasecmp($a->name, $b->name);
    });

    // Merge sorted arrays
    $cats = array_merge($numeric_cats, $text_cats);
    

?>

<div class="card card-filter">
  <div class="card-body"> <a href="#" data-toggle="collapse" data-target="#collapse_tax-<?php echo strip_tags(str_replace("-","",$taxonomy)); ?>" aria-expanded="true" class="">
    <h5 class="card-title"><?php echo $CORE->GEO("translation_tax_key", $taxonomy); ?></h5>
    </a>
    <div class="filter-content collapse" id="collapse_tax-<?php echo strip_tags(str_replace("-","",$taxonomy)); ?>">
      <div class="filter_maxheight max_height_<?php echo strip_tags(str_replace("-","",$taxonomy)); ?>" <?php if(count($cats) > $showhide ){ ?>style="max-height:<?php echo $showhide*32; ?>px; overflow:hidden;"<?php } ?>>
        <?php if(THEME_KEY == "dl" && $taxonomy == "make"){ ?>
        <select name="tax-make" class="form-control customfilter" id="reg_field_tax_make" name="sort" data-type="select" data-key="taxonomy" onchange="ChangeSearchValues('',this.value,'model__make','tx_model[]','-1','0', 'reg_field_tax_model_side');  ">
        <option value=""><?php echo __("Any Make","premiumpress"); ?></option>
        <?php
$count = 1;
$cats = get_terms( 'make', array( 'hide_empty' => 0, 'parent' => 0  ));
if(!empty($cats)){


foreach($cats as $cat){ 
if($cat->parent != 0){ continue; } 

 
?>
        <option value="make-<?php echo $cat->term_id; ?>" <?php if(isset($_GET['tax-make']) && $_GET['tax-make'] == $cat->term_id){ echo "selected=selected"; } ?>> <?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?>
        <?php if($cat->count > 0){ ?>
        (<?php echo $cat->count; ?>)
        <?php } ?>
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
		
		_filter_update();
		
        },
        error: function(e) {
             
        }
    });	
 
} 
<?php if(isset($_GET['tax-make']) && is_numeric($_GET['tax-make']) ){ ?>
 jQuery(document).ready(function(){ 
   	
   	ChangeSearchValues('','make-<?php echo esc_attr($_GET['tax-make']); ?>','model__make','tx_model[]','<?php if(isset($_GET['tax-model']) && is_numeric($_GET['tax-model']) ){ echo esc_attr($_GET['tax-model']); }else{ echo "-1"; } ?>','0', 'reg_field_tax_model_side');
   
   });  
<?php } ?>
</script>
        <?php   $count=0;  }elseif(THEME_KEY == "dl" && $taxonomy == "model"){ $count=0; ?>
        <select name="tax-model" class="form-control customfilter" data-live-search="true" id="reg_field_tax_model_side"  data-type="select" data-key="taxonomy" onchange="_filter_update();" >
          <option value=""><?php echo __("Any Model","premiumpress"); ?></option>
        </select>
        <?php }else{ ?>
        <?php $count = 1; foreach($cats as $cat){  
		
			if($count > 150){ continue; }
			
			// DEFAULT GENDER FOR DATING THEME
			if( in_array(THEME_KEY, array("da")) && $taxonomy == "dagender" && !isset($_GET['tax-dagender']) ){ 
			
				 $_GET['tax-'.$taxonomy] = get_user_meta($userdata->ID,'da-seek2',true);
				 
			}
		 ?>
        <label class="custom-control custom-checkbox f-<?php echo $taxonomy."-".$cat->term_id; ?>">
        <input type="checkbox" <?php if(isset($GLOBALS['flag-taxonomy-id']) && $GLOBALS['flag-taxonomy-id'] == $cat->term_id ){  ?>disabled<?php } ?> 

<?php if(isset($_GET['tax-'.$taxonomy]) && $_GET['tax-'.$taxonomy] == $cat->term_id){ echo "checked=checked"; } ?>

value="<?php echo $cat->term_id; ?>" name="catid[]" class="custom-control-input customfilter" data-type="checkbox" onclick="_filter_update()" data-key="taxonomy" data-value="<?php echo $taxonomy; ?>-<?php echo $cat->term_id; ?>">
        <div class="custom-control-label <?php if(_ppt(array('search','count')) != 1){ ?>addcount<?php } ?>" data-countkey="<?php echo $taxonomy; ?>-<?php echo $cat->term_id; ?>">
          <?php if(THEME_KEY == "dt"){ ?>
          <a href="<?php echo get_term_link( $cat->term_id, $taxonomy); ?>" class="text-dark">
          <?php } ?>
          <?php 
		
		if( defined('WLT_DEMOMODE') && $taxonomy == "store" ){
		 
				$did = filter_var($cat->name, FILTER_SANITIZE_NUMBER_INT);	
			 				
				if(is_numeric($did) && isset($GLOBALS['CORE_THEME']['storedata'][$did]['title'])){
							
					echo $GLOBALS['CORE_THEME']['storedata'][$did]['title'];
								
				}else{
				
					echo $CORE->GEO("translation_tax_value", array($cat->term_id, $cat->name)); 
				}
		
	 
		}else{
		
				echo $CORE->GEO("translation_tax_value", array($cat->term_id, $cat->name)); 
		
		}
	 
		?>
          <?php if(THEME_KEY == "dt"){ ?>
          </a>
          <?php } ?>
        </div>
        </label>
        <?php $count++; } ?>
        <?php } ?>
      </div>
      <?php if($count > $showhide ){ ?>
      <div class="mt-3">
        <?php if($taxonomy == "store"){ ?>
        <a href="<?php echo _ppt(array('links','stores')); ?>" class="text-primary"><u><span class="small showmoreless"><?php echo __("show more","premiumpress") ?></span></u></a>
        <?php }elseif($taxonomy == "listing"){ ?>
        <a href="<?php echo _ppt(array('links','categories')); ?>" class="text-primary"><u><span class="small showmoreless"><?php echo __("show more","premiumpress") ?></span></u></a>
        <?php }else{ ?>
        <a href="javascript:void(0);" onclick="SetMaxHeight<?php echo strip_tags(str_replace("-","",$taxonomy));; ?>('.max_height_<?php echo strip_tags(str_replace("-","",$taxonomy));; ?>');" class="text-primary"><u><span class="small showmoreless"><?php echo __("show more","premiumpress") ?></span></u></a>
        <?php } ?>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
<?php if($count > $showhide ){ ?>
<script>

function SetMaxHeight<?php echo strip_tags(str_replace("-","",$taxonomy)); ?>(div){
	
	if(jQuery('.<?php echo strip_tags(str_replace("-","",$taxonomy)); ?>_hset').length > 0){
	
		jQuery('.max_height_<?php echo strip_tags(str_replace("-","",$taxonomy)); ?>').removeClass('<?php echo strip_tags(str_replace("-","",$taxonomy)); ?>_hset');
		
		 jQuery(div).css('max-height', '<?php echo $showhide*36; ?>px'); 
		 
		 jQuery('#collapse_tax-<?php echo strip_tags(str_replace("-","",$taxonomy)); ?> .showmoreless').html("<?php echo __("show more","premiumpress") ?>");
	
	}else{	
	
		jQuery('.max_height_<?php echo strip_tags(str_replace("-","",$taxonomy)); ?>').addClass('<?php echo strip_tags(str_replace("-","",$taxonomy)); ?>_hset');
		
		jQuery(div).css('max-height', '100%');  
		
		jQuery('#collapse_tax-<?php echo strip_tags(str_replace("-","",$taxonomy)); ?> .showmoreless').html("<?php echo __("show less","premiumpress"); ?>");
	}
 

}
</script>
<?php } ?>
<?php } ?>
<?php } ?>
<?php } } ?>