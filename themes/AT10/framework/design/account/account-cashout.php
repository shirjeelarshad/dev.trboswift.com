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

global $CORE, $userdata; 

	// 1. GET THE USERS CREDIT
	$user_credit = get_user_meta($userdata->ID,'ppt_usercredit',true);
	$user_credit_bakup = $user_credit;
	if($user_credit == "" || !is_numeric($user_credit) ){ $user_credit = 0; }
	
	// MIN CASHOUT
	$mincashout = _ppt(array('cashout', 'min_amount'));
	if(!is_numeric($mincashout)){
	$mincashout = 0;
	}
	
	// 
	$showcashout = true;
	if( !$CORE->LAYOUT("captions","cashout") ){
	$showcashout = false;
	}
	
 
?>

<div class="row clearfix  mb-4">
  <div class="col-md-8">
    <div class="">
      <div class="card-body">
        <?php 
	
	if(_ppt(array("user","cashout_hideform")) == 1){
	
	
	
	}elseif($user_credit == 0){ 
	
	?>
        <div class="pt-5 text-center"><i class="fal fa-smile fa-7x opacity-5"></i> </div>
        <div class="text-center opacity-5 my-4 pb-5"><?php echo __("Your account is upto date.","premiumpress"); ?></div>
        <?php
	
	}elseif($user_credit < 0){ 
	
	
	$user_credit = str_replace("-","",$user_credit);
$payment_due = round($user_credit,2);
	
	?>
        <h5><?php echo __("Payment Due","premiumpress"); ?></h5>
        <p><?php echo __("Please make payment as soon as possible.","premiumpress"); ?></p>
        <hr />
        <div id="ajax_overdue_payment"></div>
        <div class="alert alert-danger" id="paymentnotice1x"> <b><span class="label label-danger"><?php echo __("Negative Amount Balance","premiumpress"); ?></span></b>
          <button class="btn btn-danger float-right mt-2" onclick="ajax_load_payment();"><?php echo __("Pay Now","premiumpress"); ?></button>
          <br />
          <small> <?php printf( __( 'Amount due %s. Please make payment as soon as possible.', 'premiumpress' ), '<span>' . hook_price($user_credit) . '</span>' );  ?> </small>
          <div class="clearfix"></div>
        </div>
        <script> 
   
   function ajax_load_payment(){
   
       jQuery.ajax({
           type: "POST",
           url: '<?php echo home_url(); ?>/',		
   		data: {
               action: "load_new_payment_form",
   			details:jQuery('#ppt_orderdata').val(),
           },
           success: function(response) {	
		   jQuery('#paymentnotice1').hide();		
   			jQuery('#ajax_overdue_payment').html(response);
   			
           },
           error: function(e) {
               console.log(e)
           }
       });
   
   }
</script>
        <input type="hidden" id="ppt_orderdata" value="<?php 

	 
   $couponcode = "";
   if(isset($_POST['couponcode'])){
   $couponcode = esc_attr($_POST['couponcode']);
   }
   
   echo $CORE->order_encode(array(
   
   	"uid" => $userdata->ID, 
   	"amount" => $payment_due, 
 
   	"order_id" => "CREDIT-".$userdata->ID."-".rand(),
   	 
   	"description" => __("Account Overdue Payment","premiumpress"),
   	
   	"recurring" => 0,
   	
   	"couponcode" => 0,
   
   								
   ) ); 
    		
   ?>" />
        <?php }elseif($user_credit > 0){
	
	
	// GET CASHOUT COUNT
	$cashouts = $CORE->USER("get_cashout_pending", $userdata->ID); 
	 
	 ?>
        <h5><?php echo __("Cashout Funds","premiumpress"); ?></h5>
        <?php if($user_credit > $mincashout){ ?>
        <p><?php echo __("Please complete the form below and one of our team will contact you back ASAP to arrange payment.","premiumpress"); ?></p>
        <?php }else{ ?>
        <p><?php echo __("You do not have enough funds to cashout just yet.","premiumpress"); ?></p>
        <?php } ?>
        <hr />
        <div class="alert alert-success" id="cashoutnew" style="display:none">
          <div class="font-weight-bold"><?php echo __("Request Sent","premiumpress"); ?></div>
          <div><?php echo __("Your cashout request has been sent. Please allow 24/48 hours for a responce.","premiumpress"); ?></div>
        </div>
        <div class="alert alert-warning" id="cashoutwaiting" <?php if($cashouts ==0){ ?>style="display:none"<?php } ?>>
          <div class="font-weight-bold"><?php echo __("You have a pending request","premiumpress"); ?></div>
          <div><?php echo __("Please wait for the current request to be completed before submitting a new request.","premiumpress"); ?></div>
        </div>
        <?php if($cashouts == 0 && $user_credit > $mincashout){ ?>
        <form  role="form" method="post" action="" onsubmit="return CheckFormData();" class="mb-4 mt-3" id="cashoutform">
          <input type="hidden" name="action" value="cashoutform" />
          <div class="row">
            <div class="col-md-12">
              <label><?php echo __("Message","premiumpress"); ?></label>
              <textarea class="form-control rounded-0" style="height:200px;" name="cashout-message" id="cashout-message"></textarea>
              <label class="mt-3"><?php echo __("Amount","premiumpress"); ?></label>
              <div class="input-group" style="width:200px;"> <span class="input-group-prepend input-group-text bg-dark text-white border-0 rounded-0"><?php echo _ppt(array('currency','symbol')); ?></span>
                <input type="text" class="form-control rounded-0 numericonly" name="cashout-amount" id="cashout-amount"/>
              </div>
            </div>
            <div class="col-md-12">
              <button class="btn btn-primary my-4" type="submit"><?php echo __("Request Cashout","premiumpress"); ?></button>
            </div>
          </div>
        </form>
        <?php } ?>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="col-md-4 pl-lg-5">
  
  
   
  <?php if(_ppt(array('user','credit')) == "1"){ ?>
    
  <a href="javascript:void(0);" class="btn btn-primary btn-block mb-4 btn-xl" onclick="processCredit();"><i class="fal fa-plus"></i> <?php echo __("Buy Credit","premiumpress"); ?></a>
  
  <?php } ?>
  
    <div class=" text-center">
      <div class=" bg-dark">
        <?php if($user_credit_bakup > -1){  ?>
        <?php echo __("Current Balance","premiumpress"); ?>
        <?php }else{ ?>
        <?php echo __("Negative Balance","premiumpress"); ?>
        <?php } ?>
      </div>
      <div class="card-body  <?php if($user_credit_bakup < 0){ echo "text-danger"; } ?>">
        <h4 class="<?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo hook_price($user_credit); ?></h4>
        <?php if(_ppt(array("user","cashout_hideform")) == 1 && $user_credit_bakup > 0){  ?>
        <div class="mt-3 small text-muted"><?php echo __("Min Cashout Amount","premiumpress"); ?> <span class="<?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo hook_price($mincashout); ?></span></div>
        <?php } ?>
      </div>
    </div>
    
    <?php if( _ppt(array('user','cashout')) == "1" ){  if(_ppt(array("user","cashout_hideform")) == 1){}else{ ?>
    <div class=" text-center mt-5">
      <div class="card-header "><?php echo __("Payment Method","premiumpress"); ?></div>
      <div class="card-body">
        <?php  $g = get_user_meta($userdata->ID, 'payment_type', true); if($g == ""){ $g  = __("Not Set","premiumpress"); } ?>
        <h4><?php if($g == "bank"){ echo "Bank"; } ?></h4>
        <div class="mt-3 text-muted small"><a onclick="showdetails('details');showdetails('payment');" href="javascript:void(0);"><?php echo __("change payment method","premiumpress"); ?></a></div>
      </div>
    </div>
    <?php } } ?>
  </div>
</div>
<script>

<?php if($user_credit != 0){ ?>
jQuery(document).ready(function(){ 

	 jQuery(".menu-alert-cashout").html("<?php echo hook_price($user_credit); ?>").show();

});
<?php } ?>



   function CheckFormData()
   { 
   	 
   	var amount = document.getElementById("cashout-amount");
   	var message = document.getElementById("cashout-message");	
    
   
   	if(message.value == '')
   	{
   		alert("<?php echo __("Please add some details about why you are cashing out.","premiumpress") ?>");
   		message.focus();
   		message.style.border = 'thin solid red';
   		return false;
   	} 		
   	
   
   	if(amount.value == '')
   	{
   		alert("<?php echo __("Please enter a valid amount.","premiumpress") ?>");
   		amount.focus();
   		amount.style.border = 'thin solid red';
   		return false;
   	} 
	
	  if(amount.value > <?php echo $user_credit; ?>)
   	{
   		alert("<?php echo __("Please enter a valid amount.","premiumpress") ?>");
   		amount.focus();
   		amount.style.border = 'thin solid red';
   		return false;
   	} 
	
	
	
     jQuery.ajax({
           type: "POST",
           url: '<?php echo home_url(); ?>/',		
   		data: {
            action: "cashout_new",
			total: 	amount.value,
			msg: 	message.value,
           },
           success: function(response) {   			 
			
   			jQuery('#cashoutform').html('').hide();
   			jQuery('#cashoutnew').show();			
   			
           },
           error: function(e) {
               alert("error "+e)
           }
       });
   	
   	return false;
   }
   
   
</script>