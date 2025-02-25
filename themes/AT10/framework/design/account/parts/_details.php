<?php
 
global $userdata, $CORE, $settings;
 

?>

<div class="card-body  mb-4 <?php if(is_admin()){ ?>border-0<?php } ?>">

 <h6><?php echo __("Details","premiumpress"); ?></h6>
 
  <div class="row">
    <div class="col-12">
      <ul class="payment-right pl-0">
        <li>
          <div class="left">
            <?php if($settings['job_buyer_id'] == $userdata->ID){ ?>
            
            
            <?php if(in_array(THEME_KEY, array("jb","pj"))){ echo __("Employer","premiumpress"); }else{ echo __("Seller","premiumpress"); } ?>:
            
            
            <?php }else{ ?>
            
            
            <?php if(in_array(THEME_KEY, array("jb","pj"))){ echo __("Applicant","premiumpress"); }else{ echo __("Buyer","premiumpress"); } ?>:
            
            
            <?php } ?>
          </div>
          <div class="right"><span>
            <?php 
			if(in_array(THEME_KEY, array("da"))){ ?>
			<a href="<?php echo get_author_posts_url($settings['job_buyer_id']); ?>"><?php echo $CORE->USER("get_name",$settings['job_buyer_id']); ?></a>
			<?php }elseif($settings['job_buyer_id'] == $userdata->ID){ ?>
             TURBO<span class="text-primary">BID</span>
         <!--   <a href="<?php echo get_author_posts_url($settings['job_seller_id']); ?>"><?php echo $CORE->USER("get_name",$settings['job_seller_id']); ?></a> -->
            <?php }else{ ?>
            <a href="<?php echo get_author_posts_url($settings['job_buyer_id']); ?>"><?php echo $CORE->USER("get_name",$settings['job_buyer_id']); ?></a>
            <?php } ?>
            </span> </div>
          <div class="clearfix"></div>
        </li>
       
         <?php if(!in_array(THEME_KEY, array("da")) && _ppt(array('user','account_messages')) == 1  ){ ?>
        <li>
          <div class="left">
            <?php if($settings['job_buyer_id'] == $userdata->ID){ ?>
            <a href="<?php echo get_author_posts_url($settings['job_seller_id']); ?>" class="btn btn-system btn-sm"><?php echo __("Auctions","premiumpress"); ?></a>
            <?php }else{ ?>
            <a href="<?php echo get_author_posts_url($settings['job_buyer_id']); ?>" class="btn btn-system btn-sm"><i class="fa fa-user"></i> <?php echo __("Profile","premiumpress"); ?></a>
            <?php } ?>
          </div>
           <?php if(!is_admin()){ ?>
          <div class="right">
            <?php if($settings['job_buyer_id'] == $userdata->ID){ ?>
            <a <?php echo $CORE->USER("get_message_link", $settings['job_seller_id']); ?> class="btn btn-system btn-sm"><i class="fa fa-envelope"></i> <?php echo __("Message","premiumpress"); ?></a>
            <?php }else{ ?>
            <a <?php echo $CORE->USER("get_message_link", $settings['job_buyer_id']); ?> class="btn btn-system btn-sm" ><i class="fa fa-envelope"></i> <?php echo __("Message","premiumpress"); ?></a>
            <?php } ?>
          </div>
          <?php } ?>
          <div class="clearfix"></div>
        </li>
        <?php } ?>
        
        <?php if(!in_array(THEME_KEY, array("jb")) && is_numeric($settings['order_total']) && $settings['order_total'] > 0){ ?>
        <li>
          <div class="left"><?php echo __("Order Total","premiumpress"); ?>:</div>
          <div class="right"><span class="<?php echo $CORE->GEO("price_formatting",array()); ?>"> <?php echo hook_price($settings['order_total']); ?></span></div>
          <div class="clearfix"></div>
        </li>
        
         <li>
          <div class="left"><?php   echo __("Payment Status","premiumpress"); ?>:</div>
          <div class="right"> <?php echo $settings['payment_status']; ?></div>
          <div class="clearfix"></div>
        </li>
        
        
        <?php if($settings['job_buyer_id'] != $userdata->ID && is_numeric(_ppt(array('lst', 'house_comission'))) && ( _ppt(array('lst', 'house_comission')) > 0 || _ppt(array('lst', 'house_comission_fixed')) > 0 ) ){ ?>
        
          <li>
          <div class="left"><?php echo __("House Comission","premiumpress"); ?>:</div>
          <?php if( _ppt(array('lst', 'house_comission')) > 0){ ?>
          <div class="right"><?php echo _ppt(array('lst', 'house_comission')); ?>%</div>
          <?php }else{ ?>
            <div class="right"><?php echo hook_price(_ppt(array('lst', 'house_comission_fixed'))); ?></div>
          <?php } ?>
          <div class="clearfix"></div>
        </li>
        <?php } ?>
        
        
        <?php } ?>
        
        <?php if(strlen($settings['payment_id']) > 1){ ?>
        <li  class="border-0">
          <div class="left"><?php echo __("Invoice ID","premiumpress"); ?>:</div>
          <div class="right"> <span> <a href="<?php echo get_template_directory_uri(); ?>/_invoice.php?invoiceid=<?php echo $settings['payment_id']; ?>" target='_blank' style='text-decoration:underline;'> #<?php echo $CORE->order_get_orderid($settings['payment_id']); ?></a> </span> </div>
          <div class="clearfix"></div>
        </li>
        <?php } ?>
      </ul>
    </div>
    <div class="col-12">
      <ul class="payment-right pl-0">
        <li>
          <div class="left"><?php 
		  
		  if(in_array(THEME_KEY, array("da"))){
		  echo __("Profile","premiumpress"); 
		  }else{
		  echo __("Title","premiumpress"); 		  
		  }
		  
		  ?>:</div>
          <div class="right"> <a href="<?php echo get_permalink( $settings['job_post_id']); ?>" target="_blank"><?php echo get_the_title($settings['job_post_id']); ?></a> </div>
          <div class="clearfix"></div>
        </li>
        
        
        
<?php if(in_array(THEME_KEY, array("at"))){  global $CORE_AUCTION;




 //1. GET EXPIRY DATE
   					  $expiry_date = get_post_meta($settings['job_post_id'],'listing_expiry_date',true);
					  $vv = $CORE->date_timediff($expiry_date);
					  if($vv['expired'] == 1){ $expiry_date = ""; }
					  
					   // PRICE
                      $price = get_post_meta($settings['pid'], "price", true);                    
					   
                      // GET CURRENT PRICE
					  $current_price = get_post_meta($settings['job_post_id'],'price_current',true);
					  if(!is_numeric($current_price)){ $current_price = 0; }
					   
					  // GET SHIPPING OST
					  $price_shipping = get_post_meta($settings['job_post_id'],'price_shipping',true);
					  if($price_shipping == "" || !is_numeric($price_shipping)){$price_shipping = 0; }
					   
					  // GET HIGHEST BIDDER
					  $hbid =  $CORE_AUCTION->get_highest_bidder($settings['job_post_id']);
					  //print_r($hbid);
					   
					  if($vv['expired'] == 1){
					  $hbid = $CORE_AUCTION->_get_winner($settings['job_post_id']);					 
					  }
					  
					 

?>

<?php if($vv['expired'] != 1 && $settings['job_seller_id'] != $userdata->ID && $hbid['userid'] != $userdata->ID ){ ?>
<script>
jQuery(document).ready(function(){ 
jQuery("#msgbox-<?php echo $settings['pid']; ?>").html("<span class='small span-yellow'>You've been outbid!</span>");
});
</script>
<?php } ?>
 
 
 <?php if($settings['job_seller_id'] != $userdata->ID){ ?>
       <li>
                                          <div class="left"><?php echo __("My Offers","premiumpress"); ?>:</div>
                                          <div class="right">
                                             <span class="<?php echo $CORE->GEO("price_formatting",array()); ?>"> <?php echo hook_price($price); ?></span>
                                          </div>
                                          <div class="clearfix"></div>
                                       </li>
<?php } ?>
                                       
                                        <li>
                                          <div class="left"><?php echo __("Current Price","premiumpress"); ?>:</div>
                                          <div class="right">
                                             <span class="<?php echo $CORE->GEO("price_formatting",array()); ?>"> <?php echo hook_price($current_price); ?></span>
                                          </div>
                                          <div class="clearfix"></div>
                                       </li>
                                       <?php if($price_shipping > 0){ ?>
                                        <li>
                                          <div class="left"><?php echo __("Shipping Price","premiumpress"); ?>:</div>
                                          <div class="right">
                                             <?php echo hook_price($price_shipping); ?>
                                          </div>
                                          <div class="clearfix"></div>
                                       </li>
                                       <?php } ?>
                                       <li>
                                          <div class="left"><?php echo __("Offer Date","premiumpress"); ?>:</div>
                                          <div class="right">
                                             <span id="ppexpirydate"><?php echo hook_date($post->post_date); ?></span>
                                          </div>
                                          <div class="clearfix"></div>
                                       </li> 
                                       
                                       <li>
                                          <div class="left"><?php echo __("Hightest Bidder","premiumpress"); ?>:</div>
                                          <div class="right">
                                            <?php echo $hbid['user']; ?>
                                          </div>
                                          <div class="clearfix"></div>
                                       </li>    
<?php if($vv['expired'] != 1 ){ ?>
    <li>
                                          <div class="left"><?php echo __("Auction Ends","premiumpress"); ?>:</div>
                                          <div class="right">
                                            <?php echo do_shortcode('[TIMER pid="'.$settings['job_post_id'].'" layout="auction_buying_timer" finished_class="badge float-right"]'); ?>
                                          </div>
                                          <div class="clearfix"></div>
                                       </li> 
<?php } ?>
 


<?php  } ?>      

<?php if(in_array(THEME_KEY, array("rt"))){ 
 
 // PRICE
$viewdate = get_post_meta($settings['offer_id'], "price", true); 
 
 ?>
        <li>
          <div class="left"> <?php echo __("Viewing Date","premiumpress"); ?>: </div>
          <div class="right"> <?php echo $viewdate;  ?></div>
        </li>
       
        <?php } ?>    
        
          <?php if(in_array(THEME_KEY, array("jb"))){ 
 
 // PRICE
$price = get_post_meta($settings['pid'], "price", true); 
if(is_numeric($price)){
$reumseid = get_post($price);
if(isset($reumseid->post_content)){ 
 ?>
        <li>
          <div class="left"> <?php echo __("Attached Resume","premiumpress"); ?>: </div>
          <div class="right"> <a href="<?php echo $reumseid->post_content;  ?>" target="_blank" class="btn btn-system btn-sm"><i class="fa fa-download"></i> <?php echo __("Download","premiumpress"); ?></a> </div>
        </li>
       
        <?php } } } ?>   
       
        <?php if(in_array(THEME_KEY, array("dl","ct","pj"))){ 
 
 // PRICE
$price = get_post_meta($settings['pid'], "price", true); 

// CHECK FOR CUSTOM PRICE
$custom_price = get_post_meta($settings['offer_id'], "price", true); 
if(is_numeric($custom_price) && $custom_price > 0){
$price = $custom_price;
}



 ?>
        <li>
          <div class="left"> <?php echo __("Offer Amount","premiumpress"); ?>: </div>
          <div class="right"> <?php echo hook_price($price);  ?> </div>
        </li>
        <li>
          <div class="left"><?php echo __("Offer Date","premiumpress"); ?>:</div>
          <div class="right"> <span><?php echo hook_date($settings['order_date']); ?></span> </div>
          <div class="clearfix"></div>
        </li>
        <?php } ?>
        <?php if(THEME_KEY == "mj"){
		
		$orderID = get_post_meta($settings['order_id'], "order_id",true);
		$of = explode("-", $orderID);
		 
		 ?>
        <li>
          <div class="left"> <?php echo __("Type","premiumpress"); ?>: </div>
          <div class="right">
            <?php if(isset($of[3]) && $of[3] == "2"){ echo __("Premium","premiumpress");  }else{ echo __("Standard","premiumpress"); } ?>
          </div>
        </li>
        <li>
          <div class="left"> <?php echo __("Addon","premiumpress"); ?>: </div>
          <div class="right">
            <?php 
			   
			   if(get_post_meta($settings['pid'],'gig_addon',true) != "" && is_numeric(get_post_meta($settings['pid'],'gig_addon',true)) ){ 
			   
			   $addonid = get_post_meta($settings['pid'],'gig_addon',true);
			 
			    
			   	$current_data = get_post_meta($settings['job_post_id'], 'customextras', true); 
				if(is_array($current_data) && !empty($current_data) && $current_data['name'][0] != "" ){ 
					$i=0; 				 
					foreach($current_data['name'] as $key => $data){ 
					if($current_data['name'][$i] !="" && is_numeric($current_data['price'][$i]) ){						
							
							if($i == $addonid){							
							echo $current_data['name'][$i] ." - ".hook_price($current_data['price'][$i]); 
													
							} 
							
							 
						}						
						$i++; 
						}
					}
			   
			   
			   }else{ echo __("None","premiumpress"); } ?>
          </div>
        </li>
        <?php /*
        <li  class="border-0">
          <div class="left"><?php echo __("Finish within","premiumpress"); ?>:</div>
          <div class="right"> <span id="ppexpirydate"><?php echo get_post_meta($settings['job_post_id'],'days', true); ?> <?php echo __("days","premiumpress"); ?></span> </div>
          <div class="clearfix"></div>
        </li>*/
		?>
         <li>
          <div class="left"><?php echo __("Order Date","premiumpress"); ?>:</div>
          <div class="right"> <span><?php echo hook_date($settings['order_date']); ?></span> </div>
          <div class="clearfix"></div>
        </li>
        
        <?php } ?>
      </ul>
    </div>
  </div>
</div>