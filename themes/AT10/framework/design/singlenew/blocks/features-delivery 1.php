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

global $CORE, $post, $userdata; 

   // GET SHIPPING OST
   $price_shipping = get_post_meta($post->ID,'price_shipping',true);
   if($price_shipping == "" || !is_numeric($price_shipping)){$price_shipping = 0; }
   


 
         // PICKUP ONLY
         if(get_post_meta($post->ID,'delivery', true) == 1){ ?>
      <div class=" card bg-secondary mt-5 mb-4 rounded-0 border-0" style=" position:relative; overflow:hidden"> <i class="fab fa-dropbox" aria-hidden="true" style="    font-size: 50px;    position: absolute;   bottom:0px; right: 0px;    opacity: 0.1;"></i>
        <h5 class="font-itc"><?php echo __("Pick up available only  at AutoCoin Ho Chi Minh City Location","premiumpress"); ?></h5>
        <p class="font-itc mt-2"><?php echo __("The seller requests you pick-up this item in person.","premiumpress"); ?></p>
        <p class="small text">
          <?php if(strlen(do_shortcode('[CITY]')) > 2){ echo str_replace("%s", do_shortcode('[CITY]') , str_replace("%d", do_shortcode('[COUNTRY]'), __("The item is located in %s, %d.","premiumpress"))); } ?>
          <?php echo __("Full address and pickup details are provided after purchase.","premiumpress"); ?> </p>
      </div>
      <?php }else{ ?>
      <div class=" card bg-secondary mt-5 mb-4 rounded-0 border-0 " style="position:relative; overflow:hidden"> <i class="fa fa-map-marker" aria-hidden="true" style="    font-size: 50px;    position: absolute;  bottom:0px;  right: 0px;    opacity: 0.1;"></i>
        <h5 class="font-itc" ><?php echo __("This item can be shipped to you!","premiumpress"); ?></h5>
        
        <?php if($price_shipping > 0){ ?>
         <h6 class="text-success"><?php echo str_replace("%s",hook_price($price_shipping),__("Shipping cost is %s","premiumpress")); ?></h6>
       <?php } ?>
        
        <p class="mt-2 font-itc"><?php echo __("The seller will ship this item to you once payment has been recieved.","premiumpress"); ?></p>
        <p class="small font-itc">
          <?php  
		 
		  if(strlen(do_shortcode('[CITY]')) > 2){
		 echo str_replace("%s", do_shortcode('[CITY]') , str_replace("%d", do_shortcode('[COUNTRY]'), __("The item will be shipped from %s, %d, shipping charges are dicussed between you and the seller.","premiumpress"))); 
         }else{
         echo __("Full details are provided after purchase.","premiumpress");
         }
         ?>
        </p>
      </div><?php } ?>