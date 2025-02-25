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
   
   
   $img = do_shortcode('[IMAGE pathonly=1]');
   
   $price = do_shortcode('[PRICE]');
   if( $price == ""){
   	 $price = hook_price(100);
   }
   
   $oldprice = get_post_meta($post->ID,'old_price', true);
   
	// CHECK CAN SHOW
	$canShow = 1;
	$outofstock = get_post_meta($post->ID, 'stock_remove', true);
	if($outofstock == 1){
		$qty = get_post_meta($post->ID, 'qty', true);
 		if($qty == 0){
			$canShow = 0;
		}	
	}
?>

<div data-pid="<?php echo $post->ID; ?>" class="card-search card-zoom card-top-image clearfix border-0 shadow-sm">
  <?php /************ MIAN IMAGE ***/ ?>
  <figure> 
  <?php if( $oldprice  > 0 ){ ?> 
   <span class="featuredribbion" style="z-index:100;"><?php echo __("on sale","premiumpress"); ?></span>
   <?php } ?>
  
  
  <a href="<?php echo get_permalink($post->ID); ?>"> 
  
  
 
  <img data-src="<?php echo $img; ?>" class="img-fluid lazy" alt="<?php echo $post->post_title; ?>">
    <div class="read_more"><span><?php echo __("view","premiumpress"); ?></span></div>
    </a>
    <div class="fbit top-right p-0 z-1"><?php echo do_shortcode('[FAVS icon_only=1]'); ?></div>
    
    <?php if($canShow){ ?> 
    <div class="add-cart-wrap"> <?php echo do_shortcode('[ADDCART class="bg-primary text-light"]'. __("Add to Cart","premiumpress").'[/ADDCART]'); ?> </div>
    <?php } ?>
  </figure>
  <?php /***************** */ ?>
  <div class="card-body  py-3 bg-white">
    <div class="card-top">
      <h3 class="mb-1 font-weight-normal"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo do_shortcode('[TITLE]'); ?></a></h3>
      <div class="small opacity-5 mb-2"><?php echo do_shortcode('[CATEGORY limit=1]'); ?></div>
    </div>
    <div class="card-bottom d-flex justify-content-between">
      <div class="pricetag <?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo $price; ?></div>
      <?php if($oldprice > 0){ ?>
      <div class="h3 pricetag font-weight-normal opacity-8 ml-3  <?php echo $CORE->GEO("price_formatting",array()); ?>" style="text-decoration:line-through;"><?php echo hook_price(array($oldprice,0)) ; ?></div>
      <?php } ?>
    </div>
  </div>
</div>
