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

global $CORE, $LAYOUT, $wpdb, $wp_query;
 
 
$term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );




// FIX FOR OLD SETUPS
$description = "";
if( strlen($term->description) > 0){
	$description  = $term->description;
}elseif( strlen(_ppt('category_description_'.$term->term_id)) >  5){  
	$description = _ppt('category_description_'.$term->term_id);
}


if(strlen($description) >  5 || defined('WLT_DEMOMODE') ){
?>



<div class="bg-white p-4  mb-4 border">
  <div class="row">
    <div class="col-12">
    
      <?php if($term->taxonomy == "store" && ( _ppt('storeimage_'.$term->term_id) != "" || _ppt('storelink_'.$term->term_id) != "" )  ){ ?>
      
      <div class="my- text-center py-4 border mb-4"> <img src="<?php echo do_shortcode('[STOREIMAGE id="'.$term->term_id.'"]'); ?>" class="img-fluid" /> </div>
      <?php } ?>
      
      <h2 class="h4 text-center">
        <?php 
		
		if( defined('WLT_DEMOMODE') && $taxonomy == "store" ){
		 
				$did = filter_var($term->name, FILTER_SANITIZE_NUMBER_INT);	
			 				
				if(is_numeric($did) && isset($GLOBALS['CORE_THEME']['storedata'][$did]['title'])){
							
					echo $GLOBALS['CORE_THEME']['storedata'][$did]['title'];
								
				}else{
				
					echo $CORE->GEO("translation_tax", array($term->term_id, $term->name)); 
				}
		
	 
		}else{		
				echo $CORE->GEO("translation_tax", array($term->term_id, $term->name)); 		
		}
		
		?>
      </h2>
       <?php if($term->taxonomy == "store" ){
	   
	   
	   $strorelink = _ppt('storelinkaff_'.$term->term_id);
	   if($strorelink == ""){
	   $strorelink = _ppt('storelink_'.$term->term_id);
	   }
	   if(strlen( $strorelink ) > 1){ 
	    ?>
      <hr />
      <a href="<?php echo home_url(); ?>/outtax/<?php echo $term->term_id; ?>/" rel="nofollow" target="_blank" class="btn btn-primary btn-block text-uppercase"><span><?php echo __("Visit Store","premiumpress"); ?></span></a>
     <hr />
      <?php } } ?>
      <p class="text-muted text-center small">
        <?php 
		
		if(defined('WLT_DEMOMODE')){
		
			echo "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue.";
		
		}elseif($description != ""){ 
		
			echo $description; 
		
		}else{ echo $term->description; } ?>
      </p>
     
    </div>
  </div>
</div>
<?php }  ?>
<input type="hidden" name="taxonomy"  class="customfilter" data-type="text" data-key="taxonomy" value="<?php echo $term->taxonomy."-".$term->term_id; ?>" >
<script>
jQuery(document).ready(function(){ 
jQuery('.f-<?php echo $term->taxonomy."-".$term->term_id; ?>').find('input').prop( "checked", true );
});
</script>