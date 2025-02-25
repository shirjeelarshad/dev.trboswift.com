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


?>
 

<div class="alert alert-danger" id="notice-overduepayment" style="display:none;"> <b><span class="label label-danger"><?php echo __("Overdue Invoices","premiumpress"); ?></span></b>
  <button class="btn btn-danger float-right mt-2" onclick="SwitchPage('orders');"><?php echo __("Pay Now","premiumpress"); ?></button>
  <br />
  <small><?php echo __("You have overdue invoices that require your attention.","premiumpress"); ?></small>
  <div class="clearfix"></div>
</div>



<div id="notice-accountdefault">
<?php
$usernotice = stripslashes(get_user_meta($userdata->ID ,'ppt_customtext',true));

$userCredit = get_user_meta($userdata->ID, 'ppt_usercredit', true);

//$userVerified = get_user_meta($userdata->ID, 'ppt_verified', true);

if( $userCredit < 0  ){

$userCredit = str_replace("-","",$userCredit);

?>



<div class="alert alert-danger"> <b><span class="label label-danger"><?php echo __("Negative Amount Balance","premiumpress"); ?></span></b>
  <button class="btn btn-danger float-right mt-2" onclick="ajax_load_payment();"><?php echo __("Pay Now","premiumpress"); ?></button>
  <br />
  <small> <?php printf( __( 'Amount due %s. Please make payment as soon as possible.', 'premiumpress' ), '<span>' . hook_price($userCredit) . '</span>' );  ?> </small>
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
   			jQuery('#ajax_account').html(response);
   			
           },
           error: function(e) {
               console.log(e)
           }
       });
   
   }
</script>
<input type="hidden" id="ppt_orderdata" value="<?php 

	$payment_due = round($userCredit,2);

   $couponcode = "";
   if(isset($_POST['couponcode'])){
   $couponcode = esc_attr($_POST['couponcode']);
   }
   
   echo $CORE->order_encode(array(
   
   	"uid" => $userdata->ID, 
   	"amount" => $payment_due, 
   	
   	"local_currency_amount" => $CORE->price_format_display( $payment_due ),
   	"local_currency_code" => $CORE->_currency_get_code(),
   	
   	"order_id" => "CREDIT-".$post->ID."-".rand(),
   	 
   	"description" => "Account Overdue Payment",
   	
   	"recurring" => 0,
   	
   	"couponcode" => 0,
   
   								
   ) ); 
    		
   ?>" />
<?php }elseif(strlen($usernotice) > 1){ ?>
<div style="background:#fbfbfb; border: 1px solid #ddd; " class="p-4 mt-n2 text-center"> <?php echo $usernotice; ?> </div>
<?php }else{ ?>
<div style="background:#fbfbfb; border: 1px dashed #ddd; " class="p-4 mt-n2">
  <div class="text-muted text-center opacity-5"><i class="fal fa-smile mr-2"></i> <?php echo __("No New Alerts","premiumpress"); ?></div>
</div>
<?php } ?>
</div>
