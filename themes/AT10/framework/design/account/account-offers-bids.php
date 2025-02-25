<?php global $post, $CORE, $userdata, $CORE_AUCTION; 

$p = $post;
// GET BUYER ID
                     $job_buyer_id = get_post_meta($p->ID,'buyer_id',true);
                     
                     $job_seller_id = get_post_meta($p->ID,'seller_id',true);
                     
                     // GET POST ID FOR JOB
                     $offer_status = get_post_meta($p->ID,'offer_status',true);
					  
                     // GET POST ID FOR JOB
                     $job_post_id = get_post_meta($p->ID,'post_id',true);
                     
                     
					 /********************************************/
					
					 		 
					  // PRICE
                     $price = get_post_meta($p->ID, "price", true);  
					 
					  // EXPIRY DATE
   					  $expiry_date = get_post_meta($job_post_id,'listing_expiry_date',true);
					  $vv = $CORE->date_timediff($expiry_date);
					  if($vv['expired'] == 1){ $expiry_date = ""; }
					   
                      // CURRENT PRICE
					  $current_price = get_post_meta($job_post_id,'price_current',true);
					  if(!is_numeric($current_price)){ $current_price = 0; }
					   
					  // HIPPING OST
					  $price_shipping = get_post_meta($job_post_id,'price_shipping',true);
					  if($price_shipping == "" || !is_numeric($price_shipping)){$price_shipping = 0; }
					   
					  // HIGHEST BIDDER
					  $hbid =  $CORE_AUCTION->get_highest_bidder($job_post_id);
				
					  if($vv['expired'] == 1){
					  $hbid = $CORE_AUCTION->_get_winner($job_post_id);	
					   		 
					  }
					  
					   // BUYER DISPLAY
					  $BUYERSHOWFORM = 0;							  
					  if($expiry_date == "" && $job_buyer_id == $userdata->ID){    
					  
					  	if( $hbid['reserve_met'] == "no" ){
						
							$BUYERSHOWFORM = 4; // RESERVE NOT MET
							
						}elseif($hbid['userid'] == $userdata->ID){ 							  
							  $BUYERSHOWFORM = 1; // BUYER WON
						}else{ 							  
							  $BUYERSHOWFORM = 2; // BUYER LOST							  
						}                               
                      }elseif($expiry_date != "" && $job_buyer_id == $userdata->ID){ 					  	
							$BUYERSHOWFORM = 3; // BUYER PENDING
					  } 
					  
					  // SELLER DISPLAY
					  $SELLERSHOWFORM = 0;							  
					  if($expiry_date == "" && $job_seller_id == $userdata->ID){
					  
					  	if($hbid['user'] == "nobidders" ){ 
						
						$SELLERSHOWFORM = 2; // NO BIDDER
						
						}elseif($hbid['user'] == "nowinner" ){
						
						$SELLERSHOWFORM = 3; // NO WINNER
						
						}elseif( $hbid['reserve_met'] == "no" ){
						
						$SELLERSHOWFORM = 4; // RESERVER NOT ME
						
						}else{ //$hbid['reserve_met'] == "yes" 
						
						$SELLERSHOWFORM = 1; // ITEM SOLD
						
						}                               
                                                     
                      }elseif($expiry_date != "" && $job_seller_id == $userdata->ID){ 					  	
							$SELLERSHOWFORM = 3; // SELLER PENDING
					  } 
                     
					 
					 /*****************************************************/
					 
					 
					 
					  
					 
					 
					 
					 
                     
                     // CHECK IF FUNDS PAID
                     $job_donedate = get_post_meta($p->ID,'jobdone',true);
                     
                     
                     // OFFSER SET
                     $offerset = get_post_meta($p->ID, "offer_set", true); 
					 
					 
					 
                     // PAYMENT ID
                     if($offer_status == 3){ // OFFER ACCEPTED
					 
                     	$payment_id = get_post_meta($p->ID, "payment_id", true); 
					   
					   	$odata = $CORE->ORDER("get_order", $payment_id);
						
						$odata_status = $CORE->ORDER("get_status", $odata['order_status']);
					    $order_status =  $odata_status['name'];
					  
                     }
					 
					
                     
                     // PAYMENT COMPLETED
                     $payment_complete = get_post_meta($p->ID, "payment_complete", true); 
					 
					 // ORDER ID
					 $job_orderid = get_post_meta($p->ID,'invoice_id',true);
					 if($job_orderid == ""){
					  
					  $job_orderid = get_post_meta($p->ID,'order_id',true);
					  
					   $job_payment_status = get_post_meta($job_orderid,'order_status',true);
					
					   
					  
					 }
					   
					 
					 // FEEDBACK FORM EXTRAS
					 if($offer_status  == 2 || $offer_status  == 3){
						   $feedback_date = get_post_meta($p->ID,'feedback_date',true);		
						   if($feedback_date == ""){		   
							   $_GET['pid'] 	= $job_post_id;
							   $_GET['orderid'] = $job_orderid;
							   $_GET['extraid'] = $p->ID;		
							   if($job_buyer_id == $userdata->ID){
							   $_GET['uid'] = $job_seller_id;
							   }else{
							   $_GET['uid'] = $job_buyer_id;
							   }
						   }
						    
				}
				
				// CARD STATUS (1,2,3)
				$card_status = 1;
			 	if($job_buyer_id == $userdata->ID){ 
					if($BUYERSHOWFORM == 1){
						$card_status = 3;					
					}elseif($BUYERSHOWFORM == 2){
						$card_status = 2;
					}else{
						$card_status = 1;
					}
				}else{
					if($SELLERSHOWFORM == 1){
						$card_status = 3;					
					}elseif($SELLERSHOWFORM == 2 || $SELLERSHOWFORM == 3){
						$card_status = 2;
					}else{
						$card_status = 1;
					}
				
				}
					   
                     ?>

<div class=" rounded-0 card-job-<?php echo $card_status; ?> mb-3" id="card-jobid<?php echo $p->ID; ?>">
  <div class="card-header " id="heading<?php echo $p->ID; ?>" style="cursor:pointer;">
    <h5 class="mb-0">
      <div class=" btn btn-block pl-3 " data-toggle="collapse" data-target="#collapse<?php echo $p->ID; ?>" aria-controls="collapse<?php echo $p->ID; ?>"> <span class="float-left  font-weight-bold text-left">
        <?php if($job_buyer_id == $userdata->ID){ ?>
        <div class="small"><?php echo __("You bid on","premiumpress"); ?>;</div>
        <?php }else{ ?>
        <div class="small"><?php echo $CORE->USER("get_name",$job_buyer_id); ?> <?php echo __("Your item","premiumpress"); ?>;</div>
        <?php } ?>
        <?php echo get_the_title( $job_post_id ); ?> (#<?php echo $p->ID; ?>) </span>
        
        
        <?php if($job_buyer_id == $userdata->ID){ //BUYER ?>
         		<?php if($BUYERSHOWFORM == 1){ ?>
                              <span class="badge badge-success float-right job-approved"><?php echo __("Auction Won","premiumpress"); ?> </span>
                              <?php }elseif($BUYERSHOWFORM == 2){ ?>
                                   <span class="badge badge-danger float-right job-rejected"> <?php echo __("Auction Lost","premiumpress"); ?></span> 
                              <?php }elseif($BUYERSHOWFORM == 3){ ?>
                                     <span class="badge badge-info float-right job-pending"><?php echo __("Pending","premiumpress"); ?> </span>
                              <?php } ?>
        
        <?php }else{ ?>
        
        <?php if($SELLERSHOWFORM == 1){ ?>
                               <span class="badge badge-success float-right job-approved"><?php echo __("Auction Sold","premiumpress"); ?></span> 
                              <?php }elseif($SELLERSHOWFORM == 2 || $SELLERSHOWFORM == 3){ ?>
                                   <span class="badge badge-danger float-right job-rejected"> <?php echo __("Not Sold","premiumpress"); ?></span>
                              <?php }else{ ?>
             <span class="badge badge-info float-right job-pending"><?php echo __("Pending","premiumpress"); ?></span>
            <?php } ?>
        
        
        <?php } ?>
        
        
      
        
        
        </span>
       
      </div>
    </h5>
  </div>
  <div id="collapse<?php echo $p->ID; ?>" class="collapse rounded-0" aria-labelledby="heading<?php echo $p->ID; ?>" data-parent="#accordion">
    <div class="">
      <div class="container mb-4 px-0">
        <?php if($job_donedate != ""){ ?>
        <div class="alert alert-info"><?php echo __("This item was marked as complete on","premiumpress"); ?>: <?php echo hook_date($job_donedate); ?> </div>
        <?php } ?>
        <?php if($job_buyer_id == $userdata->ID){ //BUYER ?>
        <div class="stepbox row mb-5 mt-4 p-0 w-100">
          <div class="col-4 stepbox-step step1 active">
            <div class="text-center stepbox-stepnum"><?php echo __("Bid Made","premiumpress"); ?></div>
            <div class="progress bg-success">
              <div class="progress-bar"></div>
            </div>
            <a href="javascript:void(0);" onClick="ChangeSteps(1);" class="stepbox-dot bg-dark"></a> </div>
          <div class="col-4 stepbox-step step2 <?php if($offerset != ""){ ?>active<?php } ?>">
            <div class="text-center stepbox-stepnum"><?php echo __("Auction Ended","premiumpress"); ?></div>
            <div class="progress <?php if($offerset != ""){ ?>bg-success<?php } ?>">
              <div class="progress-bar"></div>
            </div>
            <a href="javascript:void(0);" class="stepbox-dot bg-dark"></a> </div>
           <div class="col-4 stepbox-step step3">
            <div class="text-center stepbox-stepnum">
            
             <?php if($BUYERSHOWFORM == 1){ ?>
                              <?php echo __("Auction Won","premiumpress"); ?> 
                              <?php }elseif($BUYERSHOWFORM == 2){ ?>
                                    <?php echo __("Auction Lost","premiumpress"); ?> 
                              <?php }elseif($BUYERSHOWFORM == 3){ ?>
                                     <?php echo __("Pending","premiumpress"); ?> 
                              <?php } ?>
            
            
            </div>
            <div class="progress <?php if($BUYERSHOWFORM == 2){ echo "bg-danger"; }elseif($BUYERSHOWFORM == 1){echo "bg-success"; } ?>">
              <div class="progress-bar"></div>
            </div>
            <a href="javascript:void(0);" class="stepbox-dot <?php if($BUYERSHOWFORM == 2){ echo "bg-danger"; }elseif($BUYERSHOWFORM == 1){echo "bg-success"; } ?>"></a> </div>
        </div>
        <?php }else{ // SELLER ?>
        <div class="stepbox row mb-5 mt-4">
          <div class="col-4 stepbox-step step1 active">
            <div class="text-center stepbox-stepnum"><?php echo __("Bid Received","premiumpress"); ?></div>
            <div class="progress bg-success">
              <div class="progress-bar"></div>
            </div>
            <a href="javascript:void(0);" class="stepbox-dot bg-dark"></a> </div>
          <div class="col-4 stepbox-step step2 active">
            <div class="text-center stepbox-stepnum"><?php echo __("Auction Ended","premiumpress"); ?></div>
            <div class="progress bg-success">
              <div class="progress-bar"></div>
            </div>
            <a href="javascript:void(0);" class="stepbox-dot bg-dark"></a> </div>
          <div class="col-4 stepbox-step step3">
            <div class="text-center stepbox-stepnum">
            
             <?php if($SELLERSHOWFORM == 1){ ?>
                              <?php echo __("Auction Sold","premiumpress"); ?> 
                              <?php }elseif($SELLERSHOWFORM == 2){ ?>
                                    <?php echo __("Not Sold","premiumpress"); ?> 
                              <?php }elseif($SELLERSHOWFORM == 3){ ?>
                                     <?php echo __("No Winner","premiumpress"); ?> 
                              <?php }else{ ?>
             <?php echo __("Pending","premiumpress"); ?> 
            <?php } ?>
            
            </div>
            <div class="progress <?php if($BUYERSHOWFORM == 2){ echo "bg-danger"; }elseif($BUYERSHOWFORM == 1){echo "bg-success"; } ?>">
              <div class="progress-bar"></div>
            </div>
            <a href="javascript:void(0);" class="stepbox-dot <?php if($BUYERSHOWFORM == 2){ echo "bg-danger"; }elseif($BUYERSHOWFORM == 1){echo "bg-success"; } ?>"></a> </div>
        </div>
        <?php } ?>
        
        
        
   
        <div class="row">
          <div class="col-md-6">
            <ul class="payment-right pl-0">
              <li>
                <div class="left">
                  <?php if($job_buyer_id == $userdata->ID){ ?>
                  <?php echo __("Seller","premiumpress"); ?>:
                  <?php }else{ ?>
                  <?php echo __("Buyer","premiumpress"); ?>:
                  <?php } ?>
                </div>
                <div class="right"><span>
                  <?php if($job_buyer_id == $userdata->ID){ ?>
                  <a href="<?php echo get_author_posts_url($job_seller_id); ?>"><?php echo $CORE->USER("get_name",$job_seller_id); ?></a>
                  <?php }else{ ?>
                  <span > AutoCoin</span>
                  
                                    <!-- <a href="<?php echo get_author_posts_url($job_buyer_id); ?>"><?php echo $CORE->USER("get_name",$job_buyer_id); ?></a> -->

                  <?php } ?>
                  
                  <div class="small mt-1">
                   <?php if($job_buyer_id == $userdata->ID){ ?>
                <a href="#" onclick="SwitchPage('messages');jQuery('#usernamefield').val('<?php echo $CORE->USER("get_username",$job_seller_id); ?>');" data-toggle="modal" data-target="#exampleModal"><?php echo __("send message","premiumpress"); ?></a>
                  
                  <?php }else{ ?>
                   <a href="#" onclick="SwitchPage('messages');jQuery('#usernamefield').val('<?php echo $CORE->USER("get_username",$job_buyer_id); ?>');" data-toggle="modal" data-target="#exampleModal"><?php echo __("send message","premiumpress"); ?></a>
                 
                   
                  <?php } ?>
                </div>
                  
                  </span> </div>
                <div class="clearfix"></div>
              </li>
              
              
              
              
              <li class="border-0">
                <div class="left"><?php echo __("Item","premiumpress"); ?>:</div>
                <div class="right"> <a href="<?php echo get_permalink( $job_post_id); ?>" target="_blank"><?php echo get_the_title($job_post_id);; ?></a> </div>
                <div class="clearfix"></div>
              </li>
              
         
                                       
                                        
                                 
             
              
            </ul>
          </div>
          <div class="col-md-6 pl-5">
        
        
        <ul class="payment-right pl-0">
        
             <li>
                                          <div class="left"><?php echo __("Current Price","premiumpress"); ?>:</div>
                                          <div class="right">
                                             <?php echo hook_price($current_price); ?>
                                          </div>
                                          <div class="clearfix"></div>
                                       </li>
              
                 <li>
                                          <div class="left"><?php echo __("My Offers","premiumpress"); ?>:</div>
                                          <div class="right">
                                             <?php echo $CORE_AUCTION->get_mybid($job_post_id, $userdata->ID); ?>
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
                                       
                                       <?php if(isset($hbid['userid'])){ ?>
                                       <li>
                                          <div class="left"><?php echo __("Highest Bidder","premiumpress"); ?>:</div>
                                          <div class="right">
                                           
                                             <span id="ppexpirydate"><?php echo $CORE->USER("get_name",$hbid['userid']); ?></span>
                                          </div>
                                          <div class="clearfix"></div>
                                       </li> 
                                       <?php } ?>
                                       
                                         <li>
                                          <div class="left"><?php echo __("End Date","premiumpress"); ?>:</div>
                                          <div class="right">
                                             <span id="ppexpirydate"><?php if($expiry_date == ""){ echo  __("Auction Ended","premiumpress"); }else{ echo $expiry_date; } ?></span>
                                          </div>
                                          <div class="clearfix"></div>
                                       </li> 
        </ul>
             
          </div>
          </div>
          
          
          
          
          
            <?php if(function_exists('current_user_can') && current_user_can('administrator')){ ?>
                                        
                                           <button class="btn btn-primary rounded-0" type="button" onClick="ajax_single_offer_delete_<?php echo $p->ID; ?>()"><?php echo __("Delete ","premiumpress"); ?></button>
                                          
               
               
			    <script>
									
	function ajax_single_offer_delete_<?php echo $p->ID; ?>(){ 
 
	jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            single_action: "offer_delete",
			
			job_id: <?php echo $p->ID; ?>,
			listing_id: <?php echo $job_post_id; ?>,
			
			seller_id:  <?php echo $job_seller_id; ?>,
			buyer_id: <?php echo $job_buyer_id; ?>, 
			  
        },
        success: function(response) {
 
			if(response.status == "ok"){
			 	 
				 jQuery('#card-jobid<?php echo $p->ID; ?>').hide();
  		 	
			}else{			
				console.log("Error trying to add.");			
			}			
        },
        error: function(e) {
            console.log(e)
        }
    });
	
}// end are you sure
									</script>
			   
			   
			   <?php } ?>
          
          
          
          
          
          
            
            
     
            

          </div>
        </div>
      </div>
    </div>