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

global $CORE, $post;

?>
  
<?php 

//////////////////////////////////// COMPARE DATA


if(defined('THEME_KEY') && in_array(THEME_KEY, array("cm"))){ 


// DEFAULT SYSTEM COMPARE
$data = get_post_meta($post->ID,'comparedata',true);
if(is_array($data) && !empty($data) ){ $i = 0;

?>
<section class="mt-4">
<div class="container">
<div class="row">
        <?php
		
		if(!isset($data['store']) || isset($data['store']) && !is_array($data['store'])){ $data['store'] = array(); }
foreach($data['store'] as $d){ 

$storedata = get_term_by('id', $d, 'store');
if(isset($storedata->name)){
$store_name =  $storedata->name;

?>
<div class="col-md-6 col-xl-4">
        <div class="card card-body my-4">
          <div class="col-12 text-center text-md-left">
          
          
            <?php if(_ppt('storeimage_'.$storedata->term_id) != ""){ ?>
            <a href="<?php echo $data['link'][$i]; ?>" rel="nofollow" target="_blank"><img src="<?php echo _ppt('storeimage_'.$storedata->term_id); ?>" alt="<?php echo $store_name; ?>" class="img-fluid"></a>
            <?php } ?>
            
            <a href="<?php echo $data['link'][$i]; ?>" rel="nofollow" target="_blank" class="btn btn-primary mt-2 btn-sm float-right px-2 hide-mobile"><i class="fa fa-arrow-right"></i> </a>
            
             
            <div class="text-muted ml-2 mt-2">
            
            
            <a href="<?php echo get_term_link($storedata->term_id, "store"); ?>"><?php echo $store_name; ?></a> 
             
               
               <span class="priceval fotn-weight-bold float-md-right" data-val="<?php echo $data['price'][$i]; ?>"><em class="small opacity-5"><?php echo __("from","premiumpress"); ?></em> <?php echo hook_price($data['price'][$i]); ?></span>
               
               
            </div>
      
          </div> 
         </div>
       </div> 
       
        <?php  } $i++; } ?>
</div> </div></section> <?php } ?>



<?php

ob_start();
// ONLY LOAD THIS IN IF THE DATAFEEDR PLUGIN
// HAS BEEN FOUND AND WORKING
if(defined('DFRCS_VERSION')){

$price 	= get_post_meta($post->ID, 'price', true); 
	if($ean != ""){
		echo do_shortcode('[dfrcs ean="'.$ean.'"  filters="finalprice_min='.$price.'"]');
	}elseif($upc != ""){
		echo do_shortcode('[dfrcs upc="'.$upc.'" filters="finalprice_min='.$price.'"]');
	}elseif($isbn != ""){
		echo do_shortcode('[dfrcs isbn="'.$isbn.'" filters="finalprice_min='.$price.'"]');
	}else{
	 
		echo do_shortcode('[dfrcs name="'.$post->post_title.'" filters="finalprice_min='.$price.'"]');
	}
}

$content = ob_get_contents();
ob_end_clean();

$content = str_replace("View",__("View","premiumpress"), $content);

$content = str_replace("Sorry, no prices available at this time.",__("Sorry, no prices available at this time.","premiumpress"), $content);
 
echo $content; 

?> 


<?php } ?>
 
  
  
  
  
  
<?php 

//////////////////////////////////// BOTTOM SECTIONS


if(defined('THEME_KEY') && !in_array(THEME_KEY, array("sp","cp","vt","ll"))){ ?>
<section class="mt-4">
<div class="container">
<div class="row">
         
         <?php if(_ppt(array('design','single_bl')) != "hide"){ ?>
        <div class="<?php if(_ppt(array('design','single_br')) != "hide"){ ?>col-md-6<?php }else{ ?>col-12<?php } ?> mb-4">
          <?php _ppt_template( 'framework/design/singlenew/blocks/customfields' );  ?>
        </div>
        <?php } ?>
        
        <?php if(_ppt(array('design','single_br')) != "hide"){ ?>
        <div class="<?php if(_ppt(array('design','single_bl')) != "hide"){ ?>col-md-6<?php }else{ ?>col-12<?php } ?> mb-4">
        
         <?php if(in_array(THEME_KEY, array("dl"))){  ?>
         <div class="mb-4">
          <?php _ppt_template( 'framework/design/singlenew/blocks/map' );  ?>
          </div>
         <?php } ?>
        
          <?php _ppt_template( 'framework/design/singlenew/blocks/features' );  ?>
        </div>               
        <?php } ?>   
   
</div>
</div>
</section>
<?php } ?>  