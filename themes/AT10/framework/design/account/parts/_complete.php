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

global $settings, $userdata, $CORE;

$uid = uniqid();
 

// 2 IMPORTANT VALUES
// 1. offer_complete (3: done  / 2: paid / 1: waiting payment )
// 2. offer_status (1: Pending / 2: Reject Order / 3: Accepted )
 
$types = array(

	// Pending Approval + Waiting
	
	"1-0" => array( 
	
		"name_buyer" 	=> __("Waiting for %s","premiumpress"),
		"desc_buyer" 	=> __("Please wait for the %s to accept this  %c","premiumpress"),		
		"name_seller" 	=> __("Accept %c","premiumpress"),
		"desc_seller" 	=> __("Please accept or decline this %c.","premiumpress"),		
		
		"icon" 			=> "fa fa-hourglass-start",
		"text-color" 	=> "text-primary",
		"user" 			=> "buyer",

	
	),	
	
	//"1-1" => array( ),
	
	
	// Rejected
	"2-0" => array(  ),
	//"2-1" => array(  ),
 
	// Accepted + Pending Payment
	"3-1" => array( 
	
		"name_buyer" 	=> __("Make Payment","premiumpress"),
		"desc_buyer" 	=> __("Please make payment to the %s.","premiumpress"),		
		"name_seller" 	=> __("Pending Payment","premiumpress"),
		"desc_seller" 	=> str_replace("%s","%b",__("Please wait for %s to make payment.","premiumpress")),		
		
		"icon" 			=> "fa fa-comment-alt-dollar",
		"text-color" 	=> "text-primary",
		"user" 			=> "buyer",
	),
	
	// Accepted + Completed
	"3-2" => array( 
 	
		"name_buyer" 	=> __("Pending Delivery","premiumpress"),
		"desc_buyer" 	=> __("Please wait for the %s to deliver this %c.","premiumpress"),		
		"name_seller" 	=> __("Please make delivery","premiumpress"),
		"desc_seller" 	=> __("Please deliver this %c to the %b.","premiumpress"), 
 		
		"icon" 			=> "fa fa-gift-card",
		"text-color" 	=> "text-primary",
		"user" 			=> "seller",
	),
	
	// Accepted + Approval
	"3-3" => array( 
	
		"name_buyer" 	=> __("Please Approve","premiumpress"),
		"desc_buyer" 	=> __("Please approve or decline the %s's delivery.","premiumpress"),		
		"name_seller" 	=> __("Pending Approval","premiumpress"),
		"desc_seller" 	=> __("Please wait for the %b to approve the delivery.","premiumpress"), 	
		
		"icon" 			=> "fa fa-check",
		"text-color" 	=> "text-primary",
		"user" 			=> "buyer",
	),
	// Accepted + Finished
	"3-4" => array( 
	
		"name_buyer" 		=> __("Complete Order","premiumpress"),
		"desc_buyer" 		=> __("Click continue to complete order.","premiumpress"),		
		"name_seller" 		=> __("Pending Complete","premiumpress"),
		"desc_seller" 		=> __("Please wait for the %b to mark order as completed.","premiumpress"),
		
		"icon" 				=> "fa fa-check",
		"text-color" 		=> "text-primary",
		"user" 				=> "buyer",
	),	
	// Accepted + Feedback
	"3-5" => array( 	
	
		"name_buyer" 	=> __("Leave Feedback","premiumpress"),
		"desc_buyer" 	=> __("Please leave feedback for the %s.","premiumpress"),		
		"name_seller" 	=> __("Leave Feedback","premiumpress"),
		"desc_seller" 	=> __("Please leave feedback for the %b.","premiumpress"),	
		 
		"icon" 			=> "fa fa-star",
		"text-color" 	=> "text-primary",
		"user" 			=> "buyer",
	),	
	
	// Accepted + Feedback
	"3-6" => array( 
	
		"name" 			=> __("Complete","premiumpress"),
		"desc" 			=> __("Please confirm that you've sent payment.","premiumpress"),
		
		"icon" 			=> "fa fa-cog",
		"text-color" 	=> "text-primary",
	),	

);




// SWITCH TEXT CHANGES
switch(THEME_KEY){

	case "at": { 
	 
	
		// CUSTOM
		if(get_post_meta($settings['job_post_id'],'listing_expiry_date', true) != ""  ){  
				
			$types["1-0"] = array( 
				
					"name_buyer" 		=> __("Waiting for auction to end","premiumpress"),
					"desc_buyer" 		=> __("Please wait for the auction to finish.","premiumpress"),					
					"name_seller" 		=> __("Waiting for auction to end","premiumpress"),
					"desc_seller" 		=> __("Please wait for the auction to finish.","premiumpress"),					
					"icon" 				=> "fal fa-clock",
					"text-color" 		=> "text-primary",
					"user" 				=> "buyer",	
			
			);			
		}
		
		$buyer_text = __("buyer","premiumpress");
		$seller_text = __("seller","premiumpress");
			
	} break;
	
	case "pj":
	case "jb": {
	
		$buyer_text = __("applicant","premiumpress");
		$seller_text = __("employer","premiumpress");
		
	} break;
	
	case "rt": {
	
		$buyer_text = __("buyer","premiumpress");
		$seller_text = __("agent","premiumpress");
	
	} break;
	
	case "ll": {
	
		$buyer_text = __("student","premiumpress");
		$seller_text = __("teacher","premiumpress");
	
	} break;	 
	
	default: {
	
		$buyer_text = __("buyer","premiumpress");
		$seller_text = __("seller","premiumpress");
	}
}



	// Accepted + Finished
if(_ppt(array('cashout', 'enable_escrow')) == '1'){
	$types["3-4"] = array( 
	
		"name_buyer" 		=> __("Release Funds","premiumpress"),
		"desc_buyer" 		=> __("Please release funds to the %s.","premiumpress"),		
		"name_seller" 		=> __("Pending Funds","premiumpress"),
		"desc_seller" 		=> __("Please wait for the %b to release funds.","premiumpress"),
		
		"icon" 				=> "fa fa-wallet",
		"text-color" 		=> "text-primary",
		"user" 				=> "buyer",
	);	
}



$status_key = $settings['offer_status']."-".$settings['offer_complete'];

 
 
if(isset($types[$status_key])){

$status_types = $types[$status_key];


// CHECK TYPE
$mytype = "seller";
if($settings['job_buyer_id'] == $userdata->ID){
$mytype = "buyer";
}



 


if($status_key == "2-0"){ 

?>
<div class="p-3 bg-danger text-white mt-4"> <i class="fal fa-times ml-3 fa-3x float-left pb-4 mr-4"></i>
  <h6><?php echo __("Rejected","premiumpress"); ?></h6>
  <p class="small mb-0"><?php  echo str_replace("%s", strtolower($CORE->LAYOUT("captions","offer")), __("This %s was rejected.","premiumpress") ) ; ?></p>
</div>

<?php 

}else{
 
?>

<?php if(THEME_KEY == "ll" &&  $settings['job_seller_id'] != $userdata->ID && $status_key == "3-5"){ ?>

<?php $ddlink = get_post_meta($settings['job_post_id'], "download_path", true); ?>

<div class=" shadow-sm  p-3 mb-4" style=" backdrop-filter:blur(50px) brightness(100%);  border:0.5px solid #717171; border-radius:20px; color:white;">
    <div class="row y-middle">
        <div class="col-md-8">
            <i class="fa fa-download fa-3x text-success float-left mr-4 ml-2  mt-2"></i>        
            
            <h3><?php echo __("Download","premiumpress"); ?></h3> 
                  
            <p class="text-muted small"><?php echo __("Download all course materials.","premiumpress"); ?></p>  
            
        </div>
        <div class="col-md-4">
        
         
			 <?php if($ddlink == ""){ ?>
             <p class="text-muted small"><?php echo __("Download link not available - please contact the teacher.","premiumpress"); ?></p>  
             <?php }else{ ?> 
            <a href="<?php echo $ddlink; ?>" target="_blank" rel="nofollow" class="btn btn-success"><?php echo __("Download","premiumpress"); ?></a>
              <?php } ?>
        </div>
       
    </div>
</div>
<?php } ?>


 

<div class=" shadow-sm  p-3 mb-4" style=" backdrop-filter:blur(50px) brightness(100%);  border:0.5px solid #717171; border-radius:20px; color:white;" <?php if($settings['feedback_date'] != ""){ ?>style="display:none;"<?php } ?>>
    <div class="row y-middle">
        <div class="col-md-8">
            <i class="<?php echo $status_types['icon']; ?> fa-3x <?php echo $status_types['text-color']; ?> float-left mr-4 ml-2 pb-3 mt-2"></i>        
            
            <h5 class="text-white"><?php echo 
			str_replace("%b", $buyer_text, 
			str_replace("%s", $seller_text,  
			str_replace("%c", strtolower($CORE->LAYOUT("captions","offer")), $status_types['name_'.$mytype]))); ?></h5> 
                  
            <p class="text-muted small"><?php echo 
			str_replace("%b", $buyer_text, 
			str_replace("%s", $seller_text, 
			str_replace("%c", strtolower($CORE->LAYOUT("captions","offer")), $status_types['desc_'.$mytype]))); ?> </p>  
              
        </div>
        <div class="col-md-4">  
        
        <?php if($status_key == "3-5"){ // feedback ?>
        
        
        <?php }elseif($settings['job_'.$status_types['user'].'_id'] == $userdata->ID){ ?>
         
        
        
         <?php if($status_key == "1-0"){  ?>
         
         
         
			 <button class="btn btn-outline-dark btn-block" type="button"><i class="fa fa-spinner fa-spin text-muted mr-2"></i> 
                <?php  echo __("Waiting","premiumpress"); ?>
                </button> 
   
         
         
		 <?php }elseif($status_key == "1-1"){ ?>
          
   
          
          
         <?php }elseif($status_key == "3-1"){ ?>
         
        
              
            <?php if(_ppt(array('cashout', 'enable_escrow')) == '1' || user_can($settings['job_seller_id'], 'edit_posts'  )){  ?>
       
           <button class="btn btn-primary btn-block rounded-pill" onclick="ajax_escrow_payment('escrow_<?php echo $settings['pid']; ?>','<?php echo hook_price($settings['order_total']); ?>');">
		   <?php echo __("Pay Now","premiumpress"); ?>
           </button>
           
           <script>
		   
		   function ajax_escrow_payment(div,pp){
   			
           jQuery('#modal<?php echo $settings['pid']; ?>').modal('hide');
   
       jQuery.ajax({
           type: "POST",
           url: '<?php echo home_url(); ?>/',		
   		data: {
               action: "load_new_payment_form",
   				details:jQuery('#'+div).val(),
           },
           success: function(response) { 
		   
           
		   jQuery(".payment-modal-wrap").fadeIn(400); 
		 
		    jQuery(".payment-modal-container h3").text(pp).addClass("<?php echo _ppt(array('currency','symbol')); ?>"); 			 
			 
   			jQuery('#ajax-payment-form').html(response);	
			
			UpdatePrices();
            
   			
           },
           error: function(e) {
               console.log(e)
           }
       });
  
}
		   
		   </script>
           
            
            <input type="hidden" id="escrow_<?php echo $settings['pid']; ?>" value="<?php 
                      
                      
               if(!isset($data['order_description'])){ $data['order_description'] = ""; }
			   
			 
               
               echo $CORE->order_encode(array(   
                "uid" 			=> $userdata->ID, 
                "amount" 		=> $settings['order_total'],     	
                "order_id" 		=> "ESCROW-".$settings['payment_id']."-".$settings['pid']."-".$settings['job_post_id'],   	 
                "description" 	=> "ESCROW #".$settings['payment_id']."-".$settings['pid']."-".$settings['job_post_id'],   	
                "recurring" 	=> 0,   	
                "couponcode" 	=> 0,   
				"hidecouponbox" => 1, 								
               ) ); 
                        
               ?>" />
              
           
           
           <?php }else{ ?>
            
              
              <button class="btn btn-primary btn-block confirm" type="button" onclick="ajax_userpay<?php echo $uid; ?>();">
              <?php  echo __("Continue","premiumpress"); ?>
              </button>             
              
              
            <!--msg model -->
            <div class="extra-modal-wrap shadow hidepage"><div id="extra-modal-wrap-ajax"></div></div>
 
              
              
              
              <?php } ?>
              
         
         
         <?php }elseif($status_key == "3-2"){ ?>
            
            
            <button class="btn btn-primary btn-block confirm" type="button" onclick="ajax_offer<?php echo $uid; ?>(<?php echo ($settings['offer_complete'])+1; ?>); jQuery(this).prop('disabled', true);">
              <?php  echo __("Set Delivered","premiumpress"); ?>
              </button>
              
              <?php if(_ppt(array('cashout', 'enable_escrow')) != 1 && !user_can($settings['job_seller_id'], 'edit_posts')){  ?>
              
              
              
              <button class="btn btn-outline-dark btn-block confirm" type="button" onclick="ajax_offer<?php echo $uid; ?>(<?php echo ($settings['offer_complete'])-1; ?>); jQuery(this).prop('disabled', true);">
              <?php  echo __("Payment Not Received","premiumpress"); ?>
              </button> 
              <?php } ?>
         
			<?php }elseif($status_key == "3-3"){ ?>
            
            
            <button class="btn btn-primary btn-block confirm" type="button" onclick="ajax_offer<?php echo $uid; ?>(<?php echo ($settings['offer_complete'])+1; ?>); jQuery(this).prop('disabled', true);">
              <?php  echo __("Approve","premiumpress"); ?>
              </button>
              
              <button class="btn btn-outline-dark btn-block confirm" type="button" onclick="ajax_offer<?php echo $uid; ?>(<?php echo ($settings['offer_complete'])-1; ?>); jQuery(this).prop('disabled', true);">
              <?php  echo __("Decline","premiumpress"); ?>
              </button> 
            
            
            <?php }else{ ?>
        
            
              
              <button class="btn btn-primary btn-block confirm" type="button" onclick="ajax_offer<?php echo $uid; ?>(<?php echo ($settings['offer_complete'])+1; ?>); jQuery(this).prop('disabled', true); jQuery(this).prop('onclick', null).off('click');">
              <?php  echo __("Continue","premiumpress"); ?>
              </button>
               
              
              <?php } ?> 
          
          
        
		<?php }else{ ?>
        
        
        
        
        
        <?php if($status_key == "1-0" && $settings['job_seller_id'] == $userdata->ID && THEME_KEY != "at"){ ?>
         
          <select id="<?php echo $uid; ?>_b" class="form-control mb-2">
                      
            <option value="3" <?php echo selected(  $settings['offer_status'], 3); ?>><?php echo __("Accept","premiumpress"); ?></option>
            <option value="2" <?php echo selected(  $settings['offer_status'], 2); ?>><?php echo __("Reject","premiumpress"); ?></option>
            
          </select>
          
          <?php if(in_array(THEME_KEY, array("mj"))){  ?>
          <p class="small mt-3"><?php echo __("Reject order will issue buyer a refund.","premiumpress"); ?></p>
          <?php } ?>
          
            <button class="btn btn-dark btn-block offerbtnaccept" type="button" onclick="ajax_offer<?php echo $uid; ?>(jQuery('#<?php echo $uid; ?>_b').val()); jQuery(this).prop('disabled', true);"><?php echo __("Update","premiumpress"); ?></button>
         
         <?php }else{ ?>
         
          <button class="btn btn-outline-dark btn-block" type="button"><i class="fa fa-spinner fa-spin text-muted mr-2"></i> 
                <?php  echo __("Waiting","premiumpress"); ?>
                </button> 
                
                <?php } ?>
        
        
     
        
        <?php } ?>
           
        </div>
        
        <?php if($status_key == "1-0" && THEME_KEY == "mj" && $settings['job_buyer_id'] == $userdata->ID ){  ?>
        
        <div class="col-12">
        
        <hr />
        
        <div class="small">
        
        <?php
	 
		$vv = $CORE->date_timediff(date("Y-m-d H:i:s", strtotime( $settings['order_date'] . " + 5 days") ), date("Y-m-d H:i:s"));
		 
		 echo str_replace("%s",$vv['string'],__("The seller has 5 days to accept/decline this order otherwise the payment will be refunded to your account.  Time remaining: %s","premiumpress")); ?>
        
        </div>
        
        </div>
        
        <?php } ?>
        
        
        
    </div>
</div>
<?php  } } ?>
  
 
<script>

function ajax_userpay<?php echo $uid; ?>(){ 


       jQuery.ajax({
        type: "POST",
        url: ajax_site_url,		
   		data: {
               action: "load_payuser_form",  
			   	job_id: <?php echo $settings['pid']; ?>,
				listing_id: <?php echo $settings['job_post_id']; ?>,					
				seller_id:  <?php echo $settings['job_seller_id']; ?>,
				buyer_id: <?php echo $settings['job_buyer_id']; ?>,
				uid: "<?php echo $uid; ?>",  	
				offer_complete: "<?php echo $settings['offer_complete']; ?>",
				amount:	 "<?php echo $settings['order_total']; ?>", 
				 
           },
           success: function(response) { 
		    	
				jQuery(".extra-modal-wrap").fadeIn(400);
				jQuery(".extra-modal-wrap").addClass('pt-5');
				
   				jQuery('#extra-modal-wrap-ajax').html(response);			
				 
   			
           },
           error: function(e) {
               console.log(e)
           }
       });

	 


}


function ajax_offer<?php echo $uid; ?>(g){ 

 
		if(confirm("<?php echo __("Are you sure?","premiumpress"); ?>"))
		{
		   
		jQuery('.offerbtnaccept').attr('disabled', true);
		
			jQuery.ajax({
				type: "POST",
				url: '<?php echo home_url(); ?>/',	
				dataType: 'json',	
				data: {
					single_action: "<?php echo $settings['ajax']; ?>",
					
					job_id: <?php echo $settings['pid']; ?>,
					listing_id: <?php echo $settings['job_post_id']; ?>,
					
					seller_id:  <?php echo $settings['job_seller_id']; ?>,
					buyer_id: <?php echo $settings['job_buyer_id']; ?>, 
					
					offer_status: g, 
					  
				},
				success: function(response) {
		 
					if(response.status == "ok"){
						 
						 window.location.href = "<?php echo _ppt(array('links','account'))."?showtab=offers"; ?>";
					
					}else{			
						console.log("Error updating offer.");			
					}			
				},
				error: function(e) {
					console.log(e)
				}
			});
			
	
	}
		else
		{		 
			e.preventDefault();
		}
	 
	
}

 
</script>