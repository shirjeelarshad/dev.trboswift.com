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

global $CORE, $userdata, $post;

// DEFAULT SYSTEM COMPARE
$data = get_post_meta($post->ID,'comparedata',true);

$afflink = get_post_meta($post->ID, 'buy_link', true);

?>

<div class="sidebar-fixed-content">
  <div class="card card-listing">
    <div class="card-body">
      <div class="addeditmenu" data-key="stores"></div>
      
      
      
          <div class="text-center py-4 mt-2 bg-light mb-3">
        <div class="h1 text-700 text-shadow-white price-value <?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo do_shortcode('[PRICE]'); ?></div>
        <div class="text-muted small mb-n2 text-center opacity-5"><?php echo __("price from","premiumpress"); ?></div>
      </div>
      <?php

if(is_array($data) && !empty($data) ){ $i = 0;

?>
      <div class="container px-0">
        <?php
		
		if(!isset($data['store']) || isset($data['store']) && !is_array($data['store'])){ $data['store'] = array(); }
foreach($data['store'] as $d){ 

$storedata = get_term_by('id', $d, 'store');
if(isset($storedata->name)){
$store_name =  $storedata->name;

?>
        <div class="row no-gutters">
          <div class="col-md-12">
          
          
            <?php if(_ppt('storeimage_'.$storedata->term_id) != ""){ ?>
            <a href="<?php echo $data['link'][$i]; ?>" rel="nofollow" target="_blank"><img src="<?php echo _ppt('storeimage_'.$storedata->term_id); ?>" alt="<?php echo $store_name; ?>" class="img-fluid"></a>
            <?php } ?>
            
            <a href="<?php echo $data['link'][$i]; ?>" rel="nofollow" target="_blank" class="btn btn-primary mt-2 btn-sm float-right px-2"><i class="fa fa-arrow-right"></i> </a>
            
             
            <div class="small text-muted ml-2 mt-2">
            
            
            <a href="<?php echo get_term_link($storedata->term_id, "store"); ?>"><?php echo $store_name; ?></a> 
            
            
               <span class="text-muted">-</span> <span class="priceval" data-val="<?php echo $data['price'][$i]; ?>"><?php echo hook_price($data['price'][$i]); ?></span>
           
            
            
            </div>
      
          </div>
          
          
          <div class="col-md-12">
            <hr />
          </div>
        </div>
        <?php  } $i++; } ?>
      </div>
      <?php
}
?>
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
      <?php if(strlen($afflink) > 1){ ?>
      <a href="<?php echo $afflink; ?>" class="btn btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2"><i class="fal fa-shopping-cart mr-2 text-primary"></i> <?php echo __("Visit Store","premiumpress") ?></a>
      <?php } ?>
      
      <?php if(in_array(_ppt(array('design', 'display_comments')), array("","1"))){ ?>
      
      <div class="divider-or"><span class="mt-n1"><?php echo __("Or","premiumpress") ?></span></div>
      
      <a href="javascript:void(0);" <?php if(!$userdata->ID){ ?> onclick="processLogin();" <?php }else{ ?> onclick="processCommentPop();" <?php } ?>  class="btn btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2"><i class="fal fa-comments mr-2 text-primary"></i><?php echo __("Write Review","premiumpress") ?></a>
      
      <?php } ?>
      
      
      </div>
  </div>
</div>
