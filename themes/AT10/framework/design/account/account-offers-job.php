<?php global $post, $CORE, $userdata; 

$p = $post;
// GET BUYER ID
                     $job_buyer_id = get_post_meta($p->ID,'buyer_id',true);
                     
                     $job_seller_id = get_post_meta($p->ID,'seller_id',true);
                     
                     // GET POST ID FOR JOB
                     $offer_status = get_post_meta($p->ID,'offer_status',true);
                     
                     // GET POST ID FOR JOB
                     $job_post_id = get_post_meta($p->ID,'post_id',true);
                     
                     // GET POST ID FOR JOB
                     $order_total = 100; //$CORE->order_total(get_post_meta($p->ID,'order_id',true));
                     
                     // CHECK IF FUNDS PAID
                     $job_donedate = get_post_meta($p->ID,'jobdone',true);
                     
                     // PRICE
                     $price = get_post_meta($p->ID, "price", true); 
                     
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
			 	   
					   
                     ?>

<div class="card rounded-0 card-job-<?php echo $offer_status; ?> mb-3" id="card-jobid<?php echo $p->ID; ?>">
  <div class="card-header bg-white" id="heading<?php echo $p->ID; ?>" style="cursor:pointer;">
    <h5 class="mb-0">
      <div class=" btn btn-block pl-3 <?php if($i == 1){ ?>collapsed<?php } ?>" data-toggle="collapse" data-target="#collapse<?php echo $p->ID; ?>" aria-controls="collapse<?php echo $p->ID; ?>"> <span class="float-left text-dark font-weight-bold text-left">
        <?php if($job_buyer_id == $userdata->ID){ ?>
        <div class="small"><?php echo __("You applied for","premiumpress"); ?>;</div>
        <?php }else{ ?>
        <div class="small"><?php echo $CORE->USER("get_name",$job_buyer_id); ?> <?php echo __("applied for","premiumpress"); ?>;</div>
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
        <div class=" float-right"> <span class="badge badge-success job-approved"><?php echo __("Approved","premiumpress"); ?>
          <?php if($feedback_date != ""){?>
          <i class="fa fa-heart" aria-hidden="true"></i>
          <?php } ?>
          </span> <small class="text-muted"><br />
          <?php echo $order_status; ?></small> </div>
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
            <div class="text-center stepbox-stepnum"><?php echo __("Application Sent","premiumpress"); ?></div>
            <div class="progress bg-success">
              <div class="progress-bar"></div>
            </div>
            <a href="javascript:void(0);" onClick="ChangeSteps(1);" class="stepbox-dot bg-dark"></a> </div>
          <div class="col-4 stepbox-step step2 <?php if($offerset != ""){ ?>active<?php } ?>">
            <div class="text-center stepbox-stepnum"><?php echo __("Waiting Response","premiumpress"); ?></div>
            <div class="progress <?php if($offerset != ""){ ?>bg-success<?php } ?>">
              <div class="progress-bar"></div>
            </div>
            <a href="javascript:void(0);" class="stepbox-dot bg-dark"></a> </div>
          <div class="col-4 stepbox-step step3">
            <div class="text-center stepbox-stepnum"> <?php echo __("Approved","premiumpress"); ?> </div>
            <div class="progress">
              <div class="progress-bar"></div>
            </div>
            <a href="javascript:void(0);" class="stepbox-dot <?php if($offer_status == 2){ ?>bg-danger<?php }else{ ?>bg-dark<?php } ?>"></a> </div>
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
          <div class="col-4 stepbox-step step3">
            <div class="text-center stepbox-stepnum"> <?php echo __("Approved","premiumpress"); ?> </div>
            <div class="progress <?php if($offer_status == 2){ ?>bg-danger<?php } ?>">
              <div class="progress-bar"></div>
            </div>
            <a href="javascript:void(0);" class="stepbox-dot <?php if($offer_status == 2){ ?>bg-danger<?php }else{ ?>bg-dark<?php } ?>"></a> </div>
        </div>
        <?php } ?>
        <div class="row">
          <div class="col-md-6">
            <ul class="payment-right pl-0">
              <li>
                <div class="left">
                  <?php if($job_buyer_id == $userdata->ID){ ?>
                  <?php echo __("Employer","premiumpress"); ?>:
                  <?php }else{ ?>
                  <?php echo __("Applicant","premiumpress"); ?>:
                  <?php } ?>
                </div>
                <div class="right"><span>
                  <?php if($job_buyer_id == $userdata->ID){ ?>
                  <a href="<?php echo get_author_posts_url($job_seller_id); ?>"><?php echo $CORE->USER("get_name",$job_seller_id); ?></a>
                  <?php }else{ ?>
                  <span > AutoCoin</span>
                  <a href="<?php echo get_author_posts_url($job_buyer_id); ?>"><?php echo $CORE->USER("get_name",$job_buyer_id); ?></a>
                  <?php } ?>
                  </span> </div>
                <div class="clearfix"></div>
              </li>
              <li>
                <div class="left"><?php echo __("Job Title","premiumpress"); ?>:</div>
                <div class="right"> <a href="<?php echo get_permalink( $job_post_id); ?>" target="_blank"><?php echo get_the_title($job_post_id);; ?></a> </div>
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
                <div class="left"><?php echo __("Date","premiumpress"); ?>:</div>
                <div class="right"> <span id="ppexpirydate"><?php echo hook_date($post->post_date); ?></span> </div>
                <div class="clearfix"></div>
              </li>
              
               <?php if(function_exists('current_user_can') && current_user_can('administrator')){ ?>
                                          <li>
                                           <button class="btn btn-primary rounded-0" type="button" onClick="ajax_single_offer_delete_<?php echo $p->ID; ?>()"><?php echo __("Delete","premiumpress"); ?></button>
                                          </li>
               
               
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
              
            </ul>
          </div>
          <div class="col-md-6 pl-5">
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
            <select name="offer_status" class="form-control" id="<?php echo $p->ID; ?>_status">
              <option value="2" <?php echo selected(  $offer_status, 2); ?>><?php echo __("Reject","premiumpress"); ?></option>
              <option value="3" <?php echo selected(  $offer_status, 3); ?>><?php echo __("Accept","premiumpress"); ?></option>
            </select>
            <p class="small mt-3"><?php echo __("Once you make a selection, this cannot be changed.","premiumpress"); ?> </p>
            <div class="text-right mt-4">
              <button class="btn btn-primary rounded-0" type="button" onClick="ajax_single_offer_update_<?php echo $p->ID; ?>()"><?php echo __("Update","premiumpress"); ?></button>
            </div>
            <?php }elseif($offer_status == 1 || $offer_status == ""){ ?>
            <?php }elseif($offer_status == 2){ ?>
            <div class="p-3 bg-danger text-white">
              <h6><?php echo __("Rejected","premiumpress"); ?></h6>
              <p class="small"><?php echo __("Unfortunately you were unsuccessful this time.","premiumpress"); ?></p>
            </div>
            <?php }elseif($offer_status == 3){ ?>
            <div class="p-3 bg-success text-white">
              <h6><?php echo __("Accepted","premiumpress"); ?></h6>
              <p class="small"><?php echo __("Congratulations, you've been accepted.","premiumpress"); ?></p>
            </div>
            <?php } ?>
            <?php 
						   
						   // BUY SIDE
						   }else{ ?>
            <?php  if($offer_status == 1 || $offer_status == ""){ ?>
            <div class="p-3 bg-info text-white">
              <h6><?php echo __("Pending","premiumpress"); ?></h6>
              <p class="small"><?php echo __("The employer has been notified and your application.","premiumpress"); ?></p>
            </div>
            <?php }elseif($offer_status == 2){ ?>
            <div class="p-3 bg-danger text-white">
              <h6><?php echo __("Rejected","premiumpress"); ?></h6>
              <p class="small"><?php echo __("The employer has rejected your application.","premiumpress"); ?></p>
            </div>
            <?php }elseif($offer_status == 3){ ?>
            <div class="p-3 bg-success text-white">
              <h6><?php echo __("Accepted","premiumpress"); ?></h6>
              <p class="small"><?php echo __("Congratulations, the employer has accepted your application.","premiumpress"); ?> <?php echo hook_price($price); ?>.</p>
            </div>
            <?php } ?>
            <?php } ?>
          </div>
          </div>
          <?php if($offer_status == 3){ ?>
          <div class="col-12">
            <hr />
            <div class="p-3 bg-light mt-3 small">
              <p><strong><?php echo __("Now what?","premiumpress"); ?></strong></p>
              <?php 
						 
						 // SELLER TEXT
						 if($job_seller_id == $userdata->ID){  ?>
              <p><?php echo str_replace("%", '<a href="'._ppt(array('links','myaccount')).'?tab=orders&paymentid='.$payment_id.'" style="text-decoration:underline;">#'.$CORE->order_get_orderid($payment_id).'</a>', __("A payment invoice (%) has ben added to your account. Please update the invoice status as soon as the buyer makes payment to prevent negative feedback.","premiumpress")); ?></p>
              <?php 
						 
						 // BUYER TEXT
						 }else{ ?>
              <p><?php echo str_replace("%", '<a href="'._ppt(array('links','myaccount')).'?tab=orders&paymentid='.$payment_id.'" style="text-decoration:underline;">#'.$CORE->order_get_orderid($payment_id).'</a>', __("A payment invoice (%) has ben added to your account. Please pay the Employer for this item as soon as possible to prevent negative feedback and delays.","premiumpress")); ?></p>
              <?php } ?>
            </div>
            
            <?php if(isset($feedback_date) && $feedback_date == ""){ ?>
            <div class="p-3 bg-light mt-3 small">
              <p><strong><?php echo __("Leave Feedback","premiumpress"); ?></strong></p>
              <p><?php echo __("Once the transacton is completed. Please leave feedback for the Employer.","premiumpress"); ?></p>
              <?php get_template_part( 'author', 'feedback-form' ); ?>
            </div>
            <?php }elseif(isset($feedback_date)){ ?>
            <div class="text-center mt-3"> <i class="fa fa-heart" aria-hidden="true"></i> <?php echo __("Feedback left on","premiumpress"); ?> <?php echo hook_date($feedback_date); ?></div>
            <?php } ?>
           
           <?php } ?>

          </div>
        </div>
      </div>
    </div>