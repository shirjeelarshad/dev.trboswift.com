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
   
   global $CORE, $post, $userdata, $CORE_AUCTION;
   
     
   //1. CURRENT PRICE
   $price_current = get_post_meta($post->ID,'price_current',true);
   if($price_current == "" || !is_numeric($price_current) ){ $price_current = 0; }
   
   //.2 GET SHIPPING PRICE
   $price_shipping = get_post_meta($post->ID,'price_shipping',true);
   if($price_shipping == "" || !is_numeric($price_shipping)){$price_shipping = 0; }
   
   // 3. GET RESERVE PRICE
   $reserve_price = get_post_meta($post->ID,'price_reserve',true);
   if($reserve_price == ""|| !is_numeric($reserve_price)){ $reserve_price = 0; }
   
   // AUCTION TYPE
   $auction_type = get_post_meta($post->ID,'auction_type',true);
    
    
   // 4. GET HIGHEST BIDDER (RETURNS "nowinner" if no winner)
   $hbid = $CORE_AUCTION->_get_winner($post->ID);
   
   
   
   // CHECK FOR USER BUY NOW PAYMENT WITH ITEMS
   // WHICH HAVE MULTIPLE QTY VALUES
   if($userdata->ID){
   	$buynowdata = get_post_meta($post->ID,'user_buynow_data',true);	 
   	$buynowForm = false;
   	if(is_array($buynowdata) && isset($buynowdata[$userdata->ID])){
   	$buynowForm = true;
   	}
   }
   
   // CREATE ORDER ID
   $orderID = "AUCTION-".$post->ID."-".$userdata->ID."-".date("Ymds");
   
   /////////////////////////////////
   // WORK OUT THE PRICES FIRST ////
   /////////////////////////////////
   
   if(!$buynowForm){
   $total_price = $price_current+$price_shipping;
   }else{
   $total_price = $buynowdata[$userdata->ID]['price'] * $buynowdata[$userdata->ID]['qty'];
   }
   
    
   ?>
<script>
   jQuery(document).ready(function(){ 
   jQuery('.ppt_shortcode_favs').hide();
   });
</script>


<div class="widget" id="widget-auctionfinished" data-title="<?php echo __("Live Offers Finished","premiumpress") ?>">
  
   <div class="widget-title">
      <i class="fa fa-hammer float-right mt-1"></i>
      <h6><?php echo __("Live Offers Finished","premiumpress") ?></h6>
   </div>
 

 
         <ul class="payment-right pl-0">
         <?php if($auction_type != 2){ ?>
            <li style="border-top:0px;">
               <div class="left"><?php echo __("Live Offers Started","premiumpress"); ?>:</div><br />
               <div class="rightxx">
                  <span id="ppexpirydate"><?php echo hook_date($post->post_date); ?></span>
               </div>
               <div class="clearfix"></div>
            </li>
            <li>
               <div class="left"><?php echo __("Live Offers Ended","premiumpress"); ?>:</div><br />
               <div class="rightxx">
                  <span id="ppexpirydate"><?php echo hook_date(get_post_meta($post->ID,'auction_ended', true)); ?></span>
               </div>
               <div class="clearfix"></div>
            </li>
            
            <li>
               <div class="left"><?php echo __("Total Bidders","premiumpress"); ?>:</div>
               <div class="right">
                  <span id="pptime"><?php echo do_shortcode('[BIDS]'); ?></span>
               </div>
               <div class="clearfix"></div>
            </li>
            <li>
               <div class="left"><?php echo __("Initiation Price","premiumpress"); ?>:</div>
               <div class="right">
                  <span id="pplistings"><span class="<?php echo $CORE->GEO("price_formatting",array()); ?>"> <?php echo hook_price(get_post_meta($post->ID,'price_starting', true)); ?></span></span>
               </div>
               <div class="clearfix"></div>
            </li>
            <?php } ?>
            
            <?php if($auction_type != 2 &&  get_post_meta($post->ID,'price_reserve', true) > 0){ ?>
            <li>
               <div class="left"><?php echo __("Reserve Price","premiumpress"); ?>:</div>
               <div class="right">
                  <span id="pplistings"><?php echo hook_price(get_post_meta($post->ID,'price_reserve', true)); ?></span>
               </div>
               <div class="clearfix"></div>
            </li>
            <?php } ?>
            <?php if($auction_type != 2 && isset($hbid['amount']) && $hbid['amount'] > 0){ ?>
            <li>
               <div class="left"><?php echo __("Highest Offer","premiumpress"); ?>:</div>
               <div class="right">
                  <span id="pptime"><span class="<?php echo $CORE->GEO("price_formatting",array()); ?>"> <?php echo hook_price($hbid['amount']); ?></span></span>
               </div>
               <div class="clearfix"></div>
            </li>
            <?php } ?>
            <?php if(get_post_meta( $post->ID,'price_current', true) > 0){ ?>
            <li>
               <div class="left"><strong><?php echo __("End Price","premiumpress"); ?>:</strong></div>
               <div class="right">	
                  <span id="ppprice"><span class="<?php echo $CORE->GEO("price_formatting",array()); ?>"> <?php echo hook_price(get_post_meta($post->ID,'price_current', true)); ?></span></span>
               </div>
               <div class="clearfix"></div>
            </li>
            <?php } ?>
            
            <?php if($price_shipping > 0){ ?>
            
              <li>
               <div class="left"><strong><?php echo __("Shipping","premiumpress"); ?>:</strong></div>
               <div class="right">	
                  <span id="ppprice"><span class="<?php echo $CORE->GEO("price_formatting",array()); ?>"> <?php echo hook_price($price_shipping); ?></span></span>
               </div>
               <div class="clearfix"></div>
            </li>
            <?php } ?>
            
         </ul>


         <div id="auction-payment-form">
            <?php if($hbid['user'] == "nobidders" ){ ?>
            <div class="alert alert-info rounded-0" role="alert">
               <h6 class="alert-heading mt-2"><?php echo __("No Bidders","premiumpress"); ?></h6>
               <p class="small mb-0"><?php echo __("Aww, this item didn't receive any bidders. Unfortunately the auction has now ended and you've missed your chance.","premiumpress"); ?></p>
               
            </div>
            <?php }elseif($hbid['user'] == "nowinner" && !$buynowForm ){ ?>
            <div class="alert alert-warning rounded-0" role="alert">
               <h6 class="alert-heading mt-2"><?php echo __("Auction Ended","premiumpress"); ?></h6>
               <p class="small mb-0"><?php echo __("Aww, this auction has ended but unfortunately there was no winner.","premiumpress"); ?></p>
               
            </div>
            <?php }elseif( $hbid['reserve_met'] == "no" ){ ?>
            <div class="alert alert-warning rounded-0" role="alert">
               <h6 class="alert-heading mt-2"><?php echo __("Auction Ended - Reserve Not Met","premiumpress"); ?></h6>
               <p class="small mb-0"><?php echo __("Aww boo!, This auction has ended however the reserve price was not met therefore there was no winner.","premiumpress"); ?></p>
              
            </div>
            <?php }elseif( $hbid['reserve_met'] == "yes" ){ ?>
            <div class="alert alert-success rounded-0" role="alert">
            
               <h6 class="alert-heading mt-2"><?php echo __("Item Sold","premiumpress"); ?></h6>
               
               <p class="small mb-0"><?php echo __("This item was successfully sold and the lucky winner was","premiumpress"); ?> <?php echo $hbid['user']; ?>.</p>
              
            </div>
                  
                  
                     <?php if($userdata->ID == $hbid['userid']){ ?>
               <a href="<?php echo _ppt(array('links','myaccount')); ?>?showtab=offers" class="btn btn-success font-weight-bold text-uppercase rounded-0 btn-block tiny"><?php echo __("Manage Auctions","premiumpress"); ?></a>
               <?php } ?>
           
            <?php } ?>
     
   </div>
</div>
<div class="clearfix"></div>