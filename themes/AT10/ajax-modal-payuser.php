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

global $userdata, $CORE;
 
if(!isset($_POST['seller_id']) || isset($_POST['seller_id']) && !is_numeric($_POST['seller_id'])  ){ die(); }

$seller_id 	= $_POST['seller_id'];
$listing_id = $_POST['listing_id'];
$buyer_id 	= $_POST['buyer_id'];
$uid 		= $_POST['uid'];
$offer_complete = $_POST['offer_complete'];
$amount		 = $_POST['amount']; 

?>

<div class="extra-modal-wrap-overlay"></div>
<div class="extra-modal-item">
  <div class="extra-modal-container">
    <div class="card-body position-relative">
      <div class="extra-modal-close text-center btn-dark" onclick="jQuery('.extra-modal-wrap').fadeOut(400)" style="top:20px; right:20px;"><i class="fa fa-times"></i></div>
      <i class="fa fa-comment-alt-dollar text-primary fa-4x float-left mr-4"></i>
      <h4>
        <?php  echo __("Make Payment","premiumpress"); ?>
      </h4>
      <p>
        <?php  echo __("Please pay the seller directly.","premiumpress"); ?>
      </p>
      <hr />
      <div class="row">
        <div class="col-3">
          <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical"> 
            
          <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Details</a> 
          
          <?php if(in_array(_ppt("cashoutopt_paypal"), array("","1"))){ ?>
          
          <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="fab fa-paypal"></i> <?php echo __("PayPal","premiumpress"); ?></a>
          
          <?php } ?>
          
          
          <?php if(in_array(_ppt("cashoutopt_bank"), array("","1"))){ ?>
          
           <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false"><i class="fa fa-money-check-alt"></i>  <?php echo __("Ngân hàng","premiumpress"); ?></a>
          
          <?php } ?>
           
           
           <?php if(in_array(_ppt("cashoutopt_person"), array("","1"))){ ?>
          
            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="fal fa-handshake-alt"></i>  <?php echo __("In Person","premiumpress"); ?></a>
           
           <?php } ?> 
            
            
             </div>
        </div>
        <div class="col-9">
          <div class="tab-content bg-light p-4" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
              <h4 class="mb-3">
                <?php  echo __("Order Total","premiumpress"); ?>
                : <span class="<?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo hook_price($amount); ?></span></h4>
              <p>
                <?php  echo __("All payments are made between you and the seller. Please select a payment method opposite or contact the seller directly to make payment.","premiumpress"); ?>
              </p>
              <p>
                <?php  echo __("Once you have paid the seller, please click continue below and we'll let the seller know you've sent payment to them.","premiumpress"); ?>
              </p>
            </div>
            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
              <h6><?php echo __("PayPal","premiumpress"); ?></h6>
               <hr />
              <?php if(get_user_meta($seller_id,'payment_type',true) == "paypal"){ ?>
              <p>
                <?php  echo __("The seller has requested to be paid via PayPal. ","premiumpress"); ?>
              </p>
             
              <p><small><?php  echo __("Payment Email","premiumpress"); ?></small> <br /> <strong><?php echo get_user_meta($seller_id,'paypal',true);  ?></strong></p>
              
              
              
              <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
 
              <input type="hidden" name="business" value="<?php echo get_user_meta($seller_id,'paypal',true);  ?>">
            
              <input type="hidden" name="cmd" value="_xclick">
         
              <input type="hidden" name="item_name" value="<?php echo get_the_title($listing_id); ?>">
              <input type="hidden" name="amount" value="<?php echo $amount; ?>">
              <input type="hidden" name="currency_code" value="<?php echo _ppt(array('currency','code')); ?>">
             
              <input type="image" name="submit" border="0"
              src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
              alt="Buy Now">
              <img alt="" border="0" width="1" height="1"
              src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
            
            </form>
              
              <?php }else{ ?>
              <p class="opacity-5">
                <?php  echo __("The seller has not provided any details.","premiumpress"); ?>
              </p>
              <?php } ?>
            </div>
            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
              <h6><?php echo __("Bank","premiumpress"); ?></h6>
               <hr />
              <?php if(strlen(stripslashes(get_user_meta($userdata->ID,'Ngân hàng',true))) > 2 ){ ?>
              <?php echo wpautop(stripslashes(get_user_meta($userdata->ID,'Ngân hàng',true))); ?>
              <?php }else{ ?>
              <p class="opacity-5">
                <?php  echo __("The seller has not provided any details.","premiumpress"); ?>
              </p>
              <?php } ?>
            </div>
            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
              <h6><?php echo __("In Person/On Collection","premiumpress"); ?></h6>
              <hr />
              <?php if(strlen(stripslashes(get_user_meta($userdata->ID,'payaddresss',true))) > 2 ){ ?>
              <?php echo wpautop(stripslashes(get_user_meta($userdata->ID,'payaddresss',true))); ?>
              <?php }else{ ?>
              <p class="opacity-5">
                <?php  echo __("The seller has not provided any details.","premiumpress"); ?>
              </p>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <hr />
      <div class="row">
        <div class="col-md-6">
          <button class="btn btn-primary btn-block" type="button" onclick="MsgSellerBtn<?php echo $uid; ?>();">
          <?php  echo __("Message Seller","premiumpress"); ?>
          </button>
          <script>
							
							function MsgSellerBtn<?php echo $uid; ?>(){
							
								jQuery('.extra-modal-wrap').fadeOut(400);
							
								processMessage('<?php if($buyer_id == $userdata->ID){ echo $seller_id;  }else{ echo $buyer_id; } ?>');
						 	
							}
							
							</script>
        </div>
        <div class="col-md-6">
          <button class="btn btn-primary btn-block confirm" type="button" onclick="ajax_offer<?php echo $uid; ?>(<?php echo ($offer_complete)+1; ?>); jQuery(this).prop('disabled', true); jQuery(this).prop('onclick', null).off('click');">
          <?php  echo __("Continue","premiumpress"); ?>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>