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

?>

<div class="" id="makeoffer">
  <div class="stepbox row mb-4">
    <div class="col-4 stepbox-step step1 active">
      <div class="text-center stepbox-stepnum"><?php echo __("Make Offer","premiumpress"); ?></div>
      <div class="progress bg-success">
        <div class="progress-bar"></div>
      </div>
      <a href="javascript:void(0);" onclick="ChangeSteps(1);" class="stepbox-dot bg-dark"></a> </div>
    <div class="col-4 stepbox-step step2">
      <div class="text-center stepbox-stepnum"><?php echo __("Wait for Responce","premiumpress"); ?></div>
      <div class="progress">
        <div class="progress-bar"></div>
      </div>
      <a href="javascript:void(0);" class="stepbox-dot bg-dark"></a> </div>
    <div class="col-4 stepbox-step step3">
      <div class="text-center stepbox-stepnum"> <?php echo __("Make Payment","premiumpress"); ?> </div>
      <div class="progress">
        <div class="progress-bar"></div>
      </div>
      <a href="javascript:void(0);" class="stepbox-dot bg-dark"></a> </div>
  </div>
  <div id="waitresponcebox" style="display:none;">
    <h2 class="mb-3 text-center"><?php echo __("Wait for a response","premiumpress"); ?></h2>
    <p class="mb-4 text-center"><?php echo __("Your offer has been submitted and a notification sent to the seller.","premiumpress"); ?></p>
    <div class="p-4 bg-light border">
      <h6 class="mb-2"><?php echo __("What happens next?","premiumpress"); ?></h6>
      <hr />
      <p><?php echo __("An email has been sent to the seller to notify them of your new offer.","premiumpress"); ?></p>
      <p><?php echo __("The seller has up to 30 days (usually allot quicker!) to respond and either accept or decline your offer. Once a response is received you will be emailed and you can view all responses via your members area.","premiumpress"); ?></p>
    </div>
    <div class="text-center my-4"><a href="<?php echo _ppt(array('links','myaccount')); ?>?showtab=offers" class="btn btn-primary rounded-0"><?php echo __("View my offers","premiumpress"); ?></a> </div>
  </div>
  <div id="makeofferbox" >
    <div class="col-md-12 m-auto">
      <div class="row">
        <div class="col-md-12">
          <div class="p-4 bg-light border col-12">
            <h5 class="mb-2"><?php echo __("How does it work?","premiumpress"); ?></h5>
            <hr />
            <p style="line-height:30px;" class="text-muted small"><?php echo __("Make an offer for this item by entering an amount below. Your offer will be sent to the seller for approval but remember, <strong>you can only make an offer on this item once</strong> and your offer is final - it cannot be changed. Good luck!","premiumpress"); ?> </p>
            <script>
                              function ValidateThis(){
                              
                              	var bidprice = jQuery('#offer_price_amount').val();
                              	
								
								if(<?php echo $userdata->ID; ?> == <?php echo $post->post_author; ?>){
									alert("<?php echo __("You cannot bid on your own items.","premiumpress"); ?>");
                              		return false;
								}
								
								if(!jQuery.isNumeric(bidprice)){
									alert("<?php echo __("Please enter a value offer amount.","premiumpress"); ?>");
                              		return false;
								}
								
                              	if(bidprice < 1){
                              		alert("<?php echo __("Please enter a value greater than 0.","premiumpress"); ?>");
                              		return false;
                              	}
								
								ajax_single_offer_make();
								return false;
                              	 
                              }
							  
							  
							  
function ajax_single_offer_make(){ 
 
	jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            single_action: "single_offer_make",
			pid: <?php echo $post->ID; ?>,
			aid: <?php echo $post->post_author; ?>,
			price: jQuery('#offer_price_amount').val(),
			 
        },
        success: function(response) {
 
			if(response.status == "ok"){
			 	 
				// UPDATED DISPLAY			
				jQuery('#makeofferbox').hide();	
				jQuery('#waitresponcebox').show();	
				
				//jQuery('.step1').removeClass('active');
				//jQuery('.step1 .process').removeClass('bg-success');
				
				jQuery('.step2').addClass('active');
				jQuery('.step2 .progress').addClass('bg-success');
				 
				 
  		 	
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
            <form method="post" action="<?php echo _ppt(array('links','offerpage')); ?>" onsubmit="return ValidateThis();">
              <input type="hidden" name="ct_action" value="newoffer">
              <input type="hidden" name="ct_pid" value="<?php echo $post->ID; ?>">
              <input type="hidden" name="ct_aid" value="">
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group"   style="max-width:200px;"> <span class="input-group-prepend"><span class="input-group-text bg-white"><?php echo hook_currency_symbol(''); ?></span></span>
                    <input type="text" name="offer_price_amount" id="offer_price_amount" maxlength="255" class="form-control rounded-0 val-numeric"  value="0" >
                  </div>
                </div>
                <div class="col-md-6 text-right">
                  <?php if(!$userdata->ID){ ?>
                  <a href="javascript:void(0);" onclick="processLogin(1);" class="btn btn-primary font-weight-bold text-uppercase rounded-0"> <?php echo __("Continue","premiumpress") ?></a>
                  <?php }else{ ?>
                  <button class="btn btn-primary font-weight-bold text-uppercase rounded-0" style="cursor:pointer"><?php echo __("Continue","premiumpress"); ?> <i class="fa fa-chevron-right ml-2"></i> </button>
                  <?php } ?>
                </div>
              </div>
              <div class="clearfix">
                <p class="mt-4 ml-2 small"><?php echo __("By clicking continue you agree to our website","premiumpress"); ?> <a href="<?php echo _ppt(array('links','terms')); ?>" style="text-decoration:underline;"><?php echo __("terms and conditions","premiumpress"); ?>.</a></p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
