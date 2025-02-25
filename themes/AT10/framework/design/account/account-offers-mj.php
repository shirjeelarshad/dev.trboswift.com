<?php global $post, $CORE, $userdata; 

$p = $post;
// GET BUYER ID
                     $job_buyer_id = get_post_meta($p->ID,'buyer_id',true);
					 if($job_buyer_id == ""){ $job_buyer_id =0;}
                     
                     $job_seller_id = get_post_meta($p->ID,'seller_id',true);
					 if($job_seller_id == ""){ $job_seller_id = 0; }
                     
                     // GET POST ID FOR JOB
                     $offer_status = get_post_meta($p->ID,'offer_status',true);
                     
                     // GET POST ID FOR JOB
                     $job_post_id = get_post_meta($p->ID,'post_id',true);
                     
                     // GET POST ID FOR JOB					 
                     $order_total = $CORE->ORDER("get_order_total", get_post_meta($p->ID,'order_id',true));
                     
                     // CHECK IF FUNDS PAID
                     $job_donedate = get_post_meta($p->ID,'jobdone',true);
                     
                     // PRICE
                     $price = get_post_meta($p->ID, "price", true); 
                     
                     // OFFSER SET
                     $offerset = get_post_meta($p->ID, "offer_set", true); 
                     
					 
					 
                     // PAYMENT ID
					 $offer_complete = "";
                     if($offer_status == 3){ // OFFER ACCEPTED
					 
                     	$payment_id = get_post_meta($p->ID, "payment_id", true); 
					   
					   	$odata = $CORE->ORDER("get_order", $payment_id);
						
						$odata_status = $CORE->ORDER("get_status", $odata['order_status']);
					    $order_status =  $odata_status['name'];
						
						
						$offer_complete = get_post_meta($p->ID, "offer_complete", true); 						 
						if($offer_complete == ""){ $offer_complete = 1; }
					  
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
			 	   
					   
                     ?>

<div class="card rounded-0 card-job-<?php echo $offer_status; ?> mb-3" id="card-jobid<?php echo $p->ID; ?>">
  <div class="card-header bg-white" id="heading<?php echo $p->ID; ?>" style="cursor:pointer;">
    <h5 class="mb-0">
      <div class=" btn btn-block pl-3 <?php if($i == 1){ ?>collapsed<?php } ?>" data-toggle="collapse" data-target="#collapse<?php echo $p->ID; ?>" aria-controls="collapse<?php echo $p->ID; ?>"> <span class="float-left text-dark font-weight-bold text-left">
        <?php if($job_buyer_id == $userdata->ID){ ?>
        <div class="small"><?php echo __("You bought","premiumpress"); ?>;</div>
        <?php }else{ ?>
        <div class="small"><?php echo $CORE->USER("get_name",$job_buyer_id); ?> <?php echo __("paid for","premiumpress"); ?>;</div>
        <?php } ?>
        <?php echo get_the_title( $job_post_id ); ?> (#<?php echo $p->ID; ?>) </span>
        <?php if($offer_status == 1 || $offer_status == ""){ ?>
        <span class="badge badge-info float-right job-pending"><?php echo __("Pending","premiumpress"); ?></span>
        <?php }elseif($offer_status == 2){ ?>
        <span class="badge badge-danger float-right job-rejected"><?php echo __("Rejected","premiumpress"); ?>
        <?php if($feedback_date != ""){?>
        <i class="fa fa-heart" aria-hidden="true"></i>
        <?php } ?>
        </span>
        <?php }elseif($offer_status == 3){ ?>
        <div class=" float-right"> <span class="badge badge-success job-approved"><?php echo __("Accepted","premiumpress"); ?>
          <?php if($feedback_date != ""){?>
          <i class="fa fa-heart" aria-hidden="true"></i>
          <?php } ?>
          </span>
          
          <br /><small class="text-muted"><?php echo $order_status; ?></small>
          
          </div>
        <?php } ?>
      </div>
    </h5>
  </div>
  <div id="collapse<?php echo $p->ID; ?>" class="collapse rounded-0" aria-labelledby="heading<?php echo $p->ID; ?>" data-parent="#accordion">
    <div class="card-body">
      <div class="container mb-4 px-0">
        <?php if($job_donedate != ""){ ?>
        <div class="alert alert-info"><?php echo __("This application was marked as complete on","premiumpress"); ?>: <?php echo hook_date($job_donedate); ?> </div>
        <?php } ?>
        <?php if($job_buyer_id == $userdata->ID){ ?>
        <div class="stepbox row mb-5 mt-4 p-0 w-100">
          <div class="col-4 stepbox-step step1 active">
            <div class="text-center stepbox-stepnum"><?php echo __("Payment","premiumpress"); ?></div>
            <div class="progress bg-success">
              <div class="progress-bar"></div>
            </div>
            <a href="javascript:void(0);" onClick="ChangeSteps(1);" class="stepbox-dot bg-dark"></a> </div>
          <div class="col-4 stepbox-step step2 <?php if($offerset != ""){ ?>active<?php } ?>">
            <div class="text-center stepbox-stepnum"><?php echo __("Work in progress","premiumpress"); ?></div>
            <div class="progress <?php if($offerset != ""){ ?>bg-success<?php } ?>">
              <div class="progress-bar"></div>
            </div>
            <a href="javascript:void(0);" class="stepbox-dot bg-dark"></a> </div>
          <div class="col-4 stepbox-step step3 <?php if($offer_complete == 3){ echo "active"; } ?>">
            <div class="text-center stepbox-stepnum"> <?php echo __("Job Complete","premiumpress"); ?> </div>
            <div class="progress <?php if($offer_complete == 3){ echo "bg-success"; }elseif($offer_status == 2){ echo "bg-danger"; } ?>">
              <div class="progress-bar"></div>
            </div>
            <a href="javascript:void(0);" class="stepbox-dot <?php if($offer_complete == 3){ echo "bg-success"; }elseif($offer_status == 2){ echo "bg-danger"; }else{ echo "bg-dark"; } ?>"></a> </div>
        </div>
        <?php }else{ ?>
        <div class="stepbox row mb-5 mt-4">
          <div class="col-4 stepbox-step step1 active">
            <div class="text-center stepbox-stepnum"><?php echo __("Application Received","premiumpress"); ?></div>
            <div class="progress bg-success">
              <div class="progress-bar"></div>
            </div>
            <a href="javascript:void(0);" class="stepbox-dot bg-dark"></a> </div>
          <div class="col-4 stepbox-step step2 active">
            <div class="text-center stepbox-stepnum"><?php echo __("Give Response","premiumpress"); ?></div>
            <div class="progress bg-success">
              <div class="progress-bar"></div>
            </div>
            <a href="javascript:void(0);" class="stepbox-dot bg-dark"></a> </div>
          <div class="col-4 stepbox-step step3 <?php if($offer_complete == 3){ echo "active"; } ?>">
            <div class="text-center stepbox-stepnum"> <?php echo __("Job Complete","premiumpress"); ?> </div>
            <div class="progress <?php if($offer_complete == 3){ echo "bg-success"; }elseif($offer_status == 2){ ?>bg-danger<?php } ?>">
              <div class="progress-bar"></div>
            </div>
            <a href="javascript:void(0);" class="stepbox-dot <?php if($offer_complete == 3){ echo "bg-success"; }elseif($offer_status == 2){ echo "bg-danger"; }else{ echo "bg-dark"; } ?>"></a> </div>
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
                  <a href="<?php echo get_author_posts_url($job_buyer_id); ?>"><?php echo $CORE->USER("get_name",$job_buyer_id); ?></a>
                  <?php } ?>
                  </span> </div>
                <div class="clearfix"></div>
              </li>
                 <li>
                <div class="left"><?php echo __("Send Message","premiumpress"); ?>:</div>
                <div class="right">
                
                <?php if($job_buyer_id == $userdata->ID){ ?>
                <a href="#" onclick="SwitchPage('messages');jQuery('#usernamefield').val('<?php echo $CORE->USER("get_username",$job_seller_id); ?>');" data-toggle="modal" data-target="#exampleModal"><?php echo __("click here","premiumpress"); ?></a>
                  
                  <?php }else{ ?>
                   <a href="#" onclick="SwitchPage('messages');jQuery('#usernamefield').val('<?php echo $CORE->USER("get_username",$job_buyer_id); ?>');" data-toggle="modal" data-target="#exampleModal"><?php echo __("click here","premiumpress"); ?></a>
                 
                   
                  <?php } ?>
                
                 
                </div>
                <div class="clearfix"></div>
              </li>
              
            
              
               <li>
                <div class="left"><?php echo __("Order Total","premiumpress"); ?>:</div>
                <div class="right"> <?php echo hook_price($order_total); ?></div>
                <div class="clearfix"></div>
              </li>
              
              
              <li>
                <div class="left"><?php echo __("Order Date","premiumpress"); ?>:</div>
                <div class="right"> <span><?php echo hook_date($post->post_date); ?></span> </div>
                <div class="clearfix"></div>
              </li>
              
                <li  class="border-0">
                                    <div class="left"><?php echo __("Invoice ID","premiumpress"); ?>:</div>
                                    <div class="right">
                                       <span>
                                       <a href="<?php echo get_template_directory_uri(); ?>/_invoice.php?invoiceid=<?php echo $payment_id; ?>" target='_blank' style='text-decoration:underline;'> 
                                       #<?php echo $CORE->order_get_orderid($payment_id); ?>
                                       </a>
                                       </span>
                                    </div>
                                    <div class="clearfix"></div>
                                 </li>
              
            </ul>
          </div>
          
          <div class="col-md-6">
          
          <ul class="payment-right pl-0">
          
        <li>
                <div class="left"><?php echo __("Job Title","premiumpress"); ?>:</div>
                <div class="right"> <a href="<?php echo get_permalink( $job_post_id); ?>" target="_blank"><?php echo get_the_title($job_post_id);; ?></a> </div>
                <div class="clearfix"></div>
              </li>
              
              <li>                            
      <div class="left"> 
			  <?php echo __("Type","premiumpress"); ?>: 
			 
              </div>
               <div class="right">
			   <?php if(get_post_meta($p->ID,'gig_type',true) != ""){ echo __("Premium","premiumpress");  }else{ echo __("Standard","premiumpress"); } ?>
               </div>
			
			  </li>
             
              
              
              <li> 
                 <div class="left"> 
			  <?php echo __("Addon","premiumpress"); ?>: 
			 
              </div>
               <div class="right">
			   <?php 
			   
			   if(get_post_meta($p->ID,'gig_addon',true) != "" && is_numeric(get_post_meta($p->ID,'gig_addon',true)) ){ 
			   
			   $addonid = get_post_meta($p->ID,'gig_addon',true);
			 
			    
			   	$current_data = get_post_meta($job_post_id, 'customextras', true); 
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
              
                <li  class="border-0">
                                    <div class="left"><?php echo __("Finish within","premiumpress"); ?>:</div>
                                    <div class="right">
                                       <span id="ppexpirydate"><?php echo get_post_meta($job_post_id,'days', true); ?> <?php echo __("days","premiumpress"); ?></span>
                                    </div>
                                    <div class="clearfix"></div>
                                 </li>
              
               </ul>
          
          </div>
          <div class="col-12">
            <?php if($job_seller_id == $userdata->ID && $job_donedate == ""){ ?>
            <?php if($offerset == ""){ ?>
            <script>
									
	function ajax_single_offer_update_<?php echo $p->ID; ?>(){ 
 
	jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            single_action: "offer_update",
			
			job_id: <?php echo $p->ID; ?>,
			listing_id: <?php echo $job_post_id; ?>,
			
			seller_id:  <?php echo $job_seller_id; ?>,
			buyer_id: <?php echo $job_buyer_id; ?>,
			
			amount: <?php echo $price; ?>,
			
			pid: <?php echo $post->ID; ?>,
			aid: <?php echo $post->post_author; ?>,
			
			offer_status: jQuery('#<?php echo $p->ID; ?>_status').val(),
			 
        },
        success: function(response) {
 
			if(response.status == "ok"){
			 	 
				 window.location.href = "<?php echo _ppt(array('links','account'))."?showtab=offers"; ?>";
  		 	
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
                                    
           <div class="mt-4 bg-warning p-4">
           
            <h4>This order is waiting to start!</h4>            
            <p>The buyer is waiting for you to confirm and start this order.</p>                                    
                                    
            <select name="offer_status" class="form-control" id="<?php echo $p->ID; ?>_status">
            <option value="3" <?php echo selected(  $offer_status, 3); ?>><?php echo __("Accept Order","premiumpress"); ?></option>
              <option value="2" <?php echo selected(  $offer_status, 2); ?>><?php echo __("Reject Order","premiumpress"); ?></option>
              
            </select>
            <p class="small mt-3"><?php echo __("Reject order will issue buyer a refund.","premiumpress"); ?> </p>
            <div class="text-right mt-4">
              <button class="btn btn-primary rounded-0" type="button" onClick="ajax_single_offer_update_<?php echo $p->ID; ?>()"><?php echo __("Update","premiumpress"); ?></button>
            </div>
            
            </div>
            
            <?php }elseif($offer_status == 1 || $offer_status == ""){ ?>
            
            <?php }elseif($offer_status == 2){ ?>
            <div class="p-3 bg-danger text-white">
              <h6><?php echo __("Rejected","premiumpress"); ?></h6>
              <p class="small"><?php echo __("You rejected this order.","premiumpress"); ?></p>
            </div>
            <?php }elseif($offer_status == 3){ ?>
            <div class="p-3 bg-success text-white">
              <h6><?php echo __("Accepted","premiumpress"); ?></h6>
              <p class="small"><?php echo __("Congratulations, you've accepted this order.","premiumpress"); ?></p>
            </div>
            <?php } ?>
            <?php 
						   
						   // BUY SIDE
						   }else{ ?>
            <?php  if($offer_status == 1 || $offer_status == ""){ ?>
            <div class="p-3 bg-info text-white">
              <h6><?php echo __("Pending","premiumpress"); ?></h6>
              <p class="small"><?php echo __("This order is waiting for the seller to accept.","premiumpress"); ?></p>
            </div>
            <?php }elseif($offer_status == 2){ ?>
            <div class="p-3 bg-danger text-white">
              <h6><?php echo __("Rejected","premiumpress"); ?></h6>
              <p class="small"><?php echo __("Unfortunately the order was rejected by the seller.","premiumpress"); ?></p>
            </div>
            <?php }elseif($offer_status == 3){ ?>
            <div class="p-3 bg-success text-white">
              <h6><?php echo __("Accepted","premiumpress"); ?></h6>
              <p class="small"><?php echo __("Congratulations, the seller has accepted your order and will begin work shortly.","premiumpress"); ?> <?php echo hook_price($price); ?>.</p>
            </div>
            <?php } ?>
            <?php } ?>
          </div>
          </div>
          <?php if($offer_status == 3){ ?>
          
        
            <hr />
            <div class="p-3 bg-light mt-3 small">
              <p><strong><?php echo __("Now what?","premiumpress"); ?></strong></p>
              <?php 
						 
						 // SELLER TEXT
				if($job_seller_id == $userdata->ID){  ?>
                
              <p>Complete the job as per the user requirments. Once completed update the status below. If the sellers agrees, the payment will be credited to your account.</p>
              
              
              <?php 
						 
						 // BUYER TEXT
			}else{ ?>
              <p>Please wait for the work to be completed by the seller. Use the message system to communitae with the seller if required.</p>
              
              <p>Once the job has been completed the seller will update their status below. Please accept the work to finish the order.</p>
              
              
              <?php } ?>
              
              
           <?php 
			  global $settings;
			  $settings['pid'] = $p->ID;
			  $settings['offer_complete'] 	= $offer_complete;
			  $settings['job_post_id'] 		= $job_post_id;
			  $settings['job_seller_id'] 	= $job_seller_id;
			  $settings['job_buyer_id'] 	= $job_buyer_id;
			   
		  	  _ppt_template( 'framework/design/account/parts/_complete' ); ?>
               
            </div>
            
            
            
            
            <?php if(isset($feedback_date) && $feedback_date == ""){ ?>
            <div class="p-3 bg-light mt-3 small">
              <p><strong><?php echo __("Leave Feedback","premiumpress"); ?></strong></p>
              <p><?php echo __("Once the transacton is completed. Please leave feedback for the Employer.","premiumpress"); ?></p>
              <?php 
			  
			  $_GET['sellerid'] = $job_seller_id;
			  get_template_part( 'author', 'feedback-form' ); ?>
            </div>
            <?php }elseif(isset($feedback_date)){ ?>
            <div class="text-center mt-3"> <i class="fa fa-heart" aria-hidden="true"></i> <?php echo __("Feedback left on","premiumpress"); ?> <?php echo hook_date($feedback_date); ?></div>
            <?php } ?>
            
            
            

 
            
            
            
            
            
           
           <?php } ?>
           
           <?php if(function_exists('current_user_can') && current_user_can('administrator')){ ?>
           <hr />                             
<button class="btn btn-system btn-md" type="button" onClick="ajax_single_offer_delete_<?php echo $p->ID; ?>()"><i class="fa fa-trash"></i> <?php echo __("Delete","premiumpress"); ?></button>
                                         
               
               
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
  

