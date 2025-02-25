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

   $qty = get_post_meta($post->ID, "qty", true );
   if($qty == ""){ $qty = 10; }
   $qty_min = 1;
 
   // GET PRODUCT TYPE
   $product_type = get_post_meta($post->ID,'type',true);
   
   // GET PRICE
   $price = get_post_meta($post->ID,'price',true);
    
   // GET OLD PRICE
   $oldprice = get_post_meta($post->ID,'old_price',true); 

?>

<div class="sidebar-fixed-content">
  <div class="card card-listing">
    <div class="card-body">
      <div class="addeditmenu" data-key="shopfields"></div>
      <div id="ajax-buynow"></div>
      <div class="ajax-buynow-wrapper"  itemscope itemtype="https://schema.org/Product">
        <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
          <meta itemprop="priceCurrency" content="USD" />
          <meta itemprop="price" content="<?php echo $price; ?>" />
          <link itemprop="availability" href="http://schema.org/InStock" />
          <meta itemprop="priceValidUntil" content="<?php echo date('d-m-Y', strtotime("+1 month")); ?>" />
          <meta itemprop="url" content="<?php echo get_permalink($post->ID); ?>" />
        </div>
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="pricetag <?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo do_shortcode('[PRICE]'); ?></h4>
          <?php if(is_numeric($oldprice) && $oldprice > 0){ ?>
          <h4 class="pricetag  font-weight-normal opacity-8 ml-3  <?php echo $CORE->GEO("price_formatting",array()); ?>" style="text-decoration:line-through;"><?php echo hook_price(array($oldprice,0)) ; ?></h4>
          <?php } ?>
        </div>
        
  <?php _ppt_template( 'framework/design/singlenew/blocks/sidebar-sp-buttons' );  ?>
  
  
      <div class="divider-or"><span class="mt-n1"><?php echo __("Or","premiumpress") ?></span></div>
     
     <?php if(in_array(_ppt(array('user','account_messages')), array("","1")) ){ ?>
      <?php _ppt_template( 'framework/design/singlenew/parts/_contactform' );  ?>
    <?php } ?>
    
    <?php if(in_array(_ppt(array('user','favs')), array("","1")) ){ ?>
      <?php if(!$userdata->ID){ ?>
      <a href="javascript:void(0);" onclick="processLogin();" class="btn btn-block btn-light mt-2"> <?php echo __("Add to favorites","premiumpress") ?></a>
      <?php }else{ ?>
      <?php echo do_shortcode('[FAVS class="btn btn-light  btn-block mt-3" text=1 icon=0]'); ?>
      <?php } ?>
      <?php } ?>
      
      
      
    </div>
     </div>
    
    
  </div>
</div>
<script>

 
jQuery(document).ready(function(){ 
   
  
		jQuery(".sidebar-fixed-content").scrollToFixed({
			minWidth: 1064,
			zIndex: 12,
			marginTop: 100,
			removeOffsets: true,
			limit: function () {
				var a = jQuery(".limit-box").offset().top - jQuery(".sidebar-fixed-content").outerHeight(true) - 48;
				return a;
			}
		});  
   
});


</script>
