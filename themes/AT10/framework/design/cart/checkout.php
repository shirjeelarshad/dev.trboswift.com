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
   
   global $table_data, $CORE, $CORE_CART, $userdata, $wpdb;  
     
   ?>
   
   
   <!-- SAVING CHANGES TEXT --->
   <div id="core_saving_wrapper"  style="display:none;">
      <div class="alert alert-info mb-4">
         <h4 class="font-size18 bold"><?php echo __("Saving Changes","premiumpress"); ?></h4>
         <div><?php echo __("This may take a few minutes so please wait...","premiumpress"); ?></div>
         <div class="clearfix"></div>
      </div>
   </div>
      
<div class="card checkout shadow-soft">
<div class="card-block">

   <!-- END SAVING CHANGES --->
   <div id="ppt_checkoutsteps" role="tablist" aria-multiselectable="true">
      <a data-toggle="collapse" data-parent="#ppt_checkoutsteps" href="#step1">
         <div class="card-title">
            <span class="step bg txt">1</span> <?php echo __("User Login","premiumpress"); ?>
         </div>
      </a>
      <div id="step1" class="collapse in" role="tabpanel">
         <div class="step-block">
            <?php if($userdata->ID){ // USER IS LOGGED IN ?>
            <h4 style="text-align:center;"><?php echo __("Welcome back","premiumpress"); ?> <?php echo $userdata->display_name; ?></h4>
            <?php }else{ ?>
            <div class="row">
               <div class="col-md-12">
                  <div class="p-3">
                      
                        <div class="row">
                           <div class="col-md-8">
                              <h4 class="mb-1"><?php echo __("New Customer","premiumpress"); ?></h4>
                              <p><?php echo __("A free account will be created for you during checkout so you can login anytime and manage your order.","premiumpress"); ?></p>
                           </div>
                           <div class="col-md-3 col-offset-1">
                              <a class="btn btn-primary btn-block" href="#" onclick="step2();GuestCheckout();"><i class="fa fa-user-circle" aria-hidden="true"></i> <?php echo __("Continue","premiumpress"); ?></a>
                           </div>
                        </div>                     
                  </div>
                  <hr class="mt-0" />
                  <div class="p-3">
                    
                        <div class="row">
                           <div class="col-md-8">
                              <h4 class="mb-1"><?php echo __("Existing Customer","premiumpress"); ?></h4>
                              <p><?php echo __("If you have an account with us, please log in.","premiumpress"); ?></p>
                           </div>
                           <div class="col-md-3 col-offset-1">
                              <a class="btn btn-primary btn-block" href="javascript:void(0);" onclick="processLogin(1,'')"> <i class="fa fa-lock" aria-hidden="true"></i> <?php echo __("Login","premiumpress"); ?> </a>
                           </div>
                        </div>
                
                  </div>
               </div>
            </div>
            <!-- end box -->
            <?php } ?>	
            <div class="clearfix"></div>
         </div>
      </div>
      <!-- end step 1 -->
      <div class="accordion-group">
         <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#ppt_checkoutsteps" href="#step2" onclick="step2();">
               <div class="card-title">
                  <span class="step bg txt">2</span> <?php echo __("Delivery Details","premiumpress"); ?> 
               </div>
            </a>
         </div>
         <div id="step2" class="accordion-body collapse">
            <div class="step-block">
               <form method="post" action="" onsubmit="return validate_checkout();" id="main-userfields">
                  <input type="hidden" name="cart-checkout-complete" value="1" />
                  <?php _ppt_template('framework/design/cart/checkout-userfields' ); ?>
                  <div class="clearfix"></div>
                  <div class="text-center py-4">
                     <button class="btn btn-primary px-5 text-uppercase font-weight-bold" type="submit"><?php echo __("Continue","premiumpress"); ?></button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <div class="accordion-group">
         <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#ppt_checkoutsteps" href="#step3">
               <div class="card-title m-b-0 p-b-0" style="border-bottom:0px;">
                  <span class="step bg txt">3</span> <?php echo __("Payment","premiumpress"); ?> 
               </div>
            </a>
         </div>
         <?php if(isset($_POST['cart-checkout-complete'])){ ?>
         <div id="step3" class="accordion-body collapse">
            <div class="step-block py-5">
               <div id="ajax_payment_form"></div>
            </div>
            <?php } ?> 
            <div class="clearfix"></div>
         </div>
      </div>
   </div>
</div>
<script>
   jQuery(document).ready(function(){ 
   
   		
   <?php if(isset($_POST['cart-checkout-complete'])){ ?>
   	jQuery('#step1').collapse('hide');
   	jQuery('#step2').collapse('hide');
   	jQuery('#step3').collapse('show');
   	ajax_checkout_payment();
   <?php }elseif($userdata->ID > 0){ ?>
   step2();
   <?php }else{ ?>
   jQuery('#step1').collapse('show');
   <?php } ?>
   
   });
    
   function GuestCheckout(){
   
   /*
   NOTHING NEEDED YET
   */
   
   }
   
   
   function step2(){
   	jQuery('#step1').collapse('hide');
   	jQuery('#step2').collapse('show');
   	jQuery('#step3').collapse('hide');
   	
   	jQuery('#step3').html('');
   }
   
   function validate_checkout(){
   
   	result =  js_validate_fields('<?php echo __("Please complete all required fields.","premiumpress") ?>');
   	
   	if(result){
   	
   		// SHOW WAITING...
   		jQuery('#core_saving_wrapper').show();
   		jQuery('#ppt_checkoutsteps').hide();
   	
   	} else {
   	return false;
   	}
   }
   
   function ajax_checkout_savesession(){
   
       jQuery.ajax({
           type: "POST",
           url: '<?php echo home_url(); ?>/',		
   		data: {
               action: "SaveSession"
    
           },
           success: function(response) {
   			
           },
           error: function(e) {
               alert("error saving session: "+e)
           }
       });
   
   }
   
   function  WLTUpdateUserField(ukey, uval){
   
   		jQuery.ajax({
   			type: "POST",
   			url: '<?php echo home_url(); ?>/',		
   			data: {
   				action: "update_userfield",
   				value: uval,
   				key: ukey,
   				id: <?php echo $userdata->ID; ?>,
   			},
   			success: function(response) {
   			 
   			  console.log(response);
   				 
   			},
   			error: function(e) {
   				alert("save error: "+e)
   			}
   		}); // save ajax
   		
   }
    
   function ajax_checkout_comments(){
   	
   	// SHOW WAITING...
   	jQuery('#core_saving_wrapper').show();
   	jQuery('#ppt_checkoutsteps').hide();
   	
   	// GET DATA	
   	var comments = jQuery("#checkoutcomments").val();
   	if(comments.length > 2){
    
   		jQuery.ajax({
   			type: "POST",
   			url: '<?php echo home_url(); ?>/',		
   			data: {
   				action: "update_userfield",
   				id: "cartcomment",
   				value: comments,
   				key: "<?php echo session_id(); ?>",
   			},
   			success: function(response) {
   			 
   			 
   				// HIDE WAITING...
   				jQuery('#core_saving_wrapper').hide();
   				jQuery('#ppt_checkoutsteps').show();
   				
   				// HIDE SAVE BUTTON
               	jQuery("#savecommentsbutton").hide();
   				 
   			},
   			error: function(e) {
   				alert("save error: "+e)
   			}
   		}); // save ajax
   	
   	}
   }
   
   function ajax_checkout_payment(){
	   
	   // BUILD ITEM NAME FROM JQUERY
	   itemName = "";
	   jQuery('.item-name').each(function(i, obj) {
		if(itemName != ""){
		itemName = itemName + ", ";
		}
		itemName = itemName + jQuery(obj).html();
	   });   

    	//JQUERY
       jQuery.ajax({
           type: "POST",
           url: '<?php echo home_url(); ?>/',		
   		data: {
               	action: "load_new_payment_form",
   				details: jQuery('#ppt_orderdata').val(), 
           },
           success: function(response) {
   			
   			jQuery('#ajax_payment_form').html(response); 
   			
           },
           error: function(e) {
               console.log(e)
           }
       });
   
    
   
   }
</script>