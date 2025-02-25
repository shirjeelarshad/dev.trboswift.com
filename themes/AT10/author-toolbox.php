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
 
// ONLY AUTHOR OF LISTING CAN SEE THIS
if($post->post_author != $userdata->ID){ return; }

$status = $CORE->PACKAGE("get_status",  $post->ID );
 
$payment_due =  0;

if($status['key'] == "payment"){

	$p = $CORE->PACKAGE("get_payment_due",  $post->ID );
 	 	
 	$payment_due += $p['total'];
	
	if(isset($p['lastorder']) && is_array($p['lastorder']) ){
		
		$lastorder = $p['lastorder'];
	}
	 
  
	
if($payment_due > 0 && $post->post_status != "pending_approval"){

$my_post = array();
$my_post['ID'] 			= $post->ID;
$my_post['post_status'] = "payment"; // USER EDIT
wp_update_post( $my_post ); 
$post->post_status = "payment";

if($p['total_orders'] > 1){

$orderID = "UPGRADE-".$post->ID."-combined";

}else{

$orderID =  get_post_meta($lastorder['id'], 'order_id', true );

}

  
?> 


<div class="container mt-5">
<div class="alert alert-danger rounded-0"> 


<i class="fal fa-frown fa-3x float-left mr-4"></i>
<b><span class="label label-danger"><?php echo __("This ad is not live.","premiumpress"); ?></span></b>

 <?php if(isset($lastorder) && is_array($lastorder) ){ ?>
  <a href="javascript:void(0);" onclick="ajax_load_order_payment('orderdatafor<?php echo $post->ID; ?>','<?php echo $payment_due; ?>');" class="btn btn-danger float-right mt-2"><?php echo __("Pay Now","premiumpress"); ?></a>  
  <br />
  <small> <?php printf( __( 'Amount due %s. Please pay now to go live.', 'premiumpress' ), '<span>' . hook_price($payment_due) . '</span>' );  ?> </small>
  
  <?php }else{ ?>
  
  <a href="<?php echo _ppt(array('links','myaccount')); ?>?showtab=orders" class="btn btn-danger float-right mt-2"><?php echo __("View Invoices","premiumpress"); ?></a>
  <br />
  <small> <?php printf( __( 'Amount due %s. Please make payment as soon as possible.', 'premiumpress' ), '<span>' . hook_price($payment_due) . '</span>' );  ?> </small> 
  <?php } ?>
  
  
  <div class="clearfix"></div>
</div>
</div>

<?php if(isset($lastorder) && is_array($lastorder) ){ ?>
<script>
   
   function ajax_load_order_payment(div,pp){
   
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
<input type="hidden" id="orderdatafor<?php echo $post->ID; ?>" value="<?php if(!isset($data['order_description'])){ $data['order_description'] = ""; }
   
   echo $CORE->order_encode(array(   
   	"uid" 			=> $userdata->ID, 
   	"amount" 		=> $payment_due, //$lastorder['total'],     	
   	"order_id" 		=> $orderID,   	 
   	"description" 	=> $data['order_description'],   	
   	"recurring" 	=> $p['recurring'],  
	"recurring_days" =>  $p['recurring_days'],  	
   	"couponcode" 	=> 0,
	//"hidecouponbox" => 1,   								
   ) ); 
    		
   ?>" />
<?php } ?>

<?php } 


}
?>

<div id="option_btn">
   <div class="heading"><a href="<?php echo _ppt(array('links','add')); ?>?eid=<?php echo $post->ID; ?>" class="border-0 p-0 m-0 text-white" style="display: inline-block;"><i class="fa fa-cog" aria-hidden="true"></i></a></div>
   <div id="ajax_response_msg"></div>
   <div class="">
   <?php if($post->post_status == "payment"){ ?>
   <div class="info blue"><?php echo __("Waiting Payment","premiumpress"); ?></div>


   <?php }elseif($post->post_status == "pending_approval"){ ?>
   <div class="info red"><?php echo __("Pending Approval","premiumpress"); ?></div>
  
   <?php }elseif($post->post_status == "draft"){ ?>
   <div class="info red"><?php echo __("Draft","premiumpress"); ?></div>

   <?php }elseif($post->post_status == "expired"){ ?>
   <div class="info red"><?php echo __("Expired","premiumpress"); ?></div>

   
   <?php }elseif($post->post_status == "pending"){ ?>
   <div class="info blue"><?php echo __("Pending","premiumpress"); ?></div>
   
   <?php }else{ ?>
   <div class="info green"><?php echo __("Live","premiumpress"); ?></div>
   <?php }  ?>
   
   <div class="box-alert bell box-shadow">
      <div class="box-alert-wrap">
 
 
         <?php if($payment_due > 0){ ?>
         <?php /*
            <a href="#myPaymentOptions" role="button" data-toggle="modal" onclick="ajax_load_payment()" ><i class="fa fa-credit-card" aria-hidden="true"></i> 
               
               <?php echo __("Pay Now","premiumpress"); ?>
         </a>*/ ?>
         
         <a href="<?php echo _ppt(array('links','add')); ?>?eid=<?php echo $post->ID; ?>"  rel="tooltip" data-original-title="<?php echo __("Edit","premiumpress"); ?>" data-placement="left" >
         <i class="fa fa-pencil"></i> 
         <?php echo __("Edit","premiumpress"); ?>
         </a>
         
         <?php if(!in_array(THEME_KEY, array("da") ) ){ ?>
         
         <a href="javascript:void(0);" onclick="ajax_delete_listing();"  rel="tooltip" data-original-title="<?php echo __("Delete","premiumpress"); ?>" data-placement="left">
         <i class="fa fa-trash" aria-hidden="true"></i>
         <?php echo __("Delete","premiumpress"); ?>
         </a> 
         <?php } ?>
         
         <?php }elseif($post->post_status == "pending") { ?>
         
         
         <?php }else{ ?>
         
         
         <?php /*
            <a href="#myPaymentOptions" role="button" data-toggle="modal" onclick="ajax_show_enhancements();">
            <i class="fal fa-award" aria-hidden="true"></i> 
            <?php echo __("Upgrade","premiumpress"); ?>
         </a>  
         */ ?>
         <?php if(_ppt(array('links','add')) != ""){ ?>
         <a href="<?php echo _ppt(array('links','add')); ?>?eid=<?php echo $post->ID; ?>" >
         <i class="fa fa-pencil"></i> 
         <?php echo __("Edit","premiumpress"); ?>
         </a>
         <?php } ?>
         
         <?php /*if(_ppt('renewlisting') == 1 && $payment_due < 1 && $packageID != "" ){ ?>
         <i class="fa fa-refresh" aria-hidden="true"></i>        
         <?php if($relist['price'] == 0){ ?>
         <a href="javascript:void(0);" onclick="ajax_relist_listing();"><?php echo __("Relist Now","premiumpress"); ?></a> 
         <?php }else{ ?>
         <a href="#myPaymentOptions" role="button" data-toggle="modal" onclick="ajax_relist_payment();" ><?php echo __("Relist for","premiumpress"); ?> <?php echo hook_price($relist['price']); ?></a> 
         <?php } ?>               
         <?php }*/ ?>
         
        <?php 
		
		
		  $canDelete = true;
		  if(THEME_KEY ==  "at" ){ 
		  
		  	// CHECK FOR BIDDING SO WE CAN DISABLE FIELDS
			$current_bidding_data = get_post_meta($post->ID,'current_bid_data',true); 
			if(is_array($current_bidding_data) && !empty($current_bidding_data) ){ $canDelete = false; }		  
		    
		  
		  } 
		  
		  if(in_array(THEME_KEY, array("da") ) ){ 
		  $canDelete = false; 
		  }
		  
		  if($canDelete){ 
		
		?>
         <a href="javascript:void(0);" onclick="ajax_delete_listing();" ><i class="fa fa-trash" aria-hidden="true"></i> <?php echo __("Delete","premiumpress"); ?></a> 
         <?php } ?>
         
         <?php } // end if published ?>
         
      </div>
   </div>
   </div>
</div>
<!-- show payment form -->
<div id="myPaymentOptions" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 class="modal-title" id="modal-title"> <?php echo __("Choose payment method","premiumpress"); ?></h4>
         </div>
         <div class="modal-body">
            <?php if(is_numeric($payment_due) && $payment_due > 0){ ?>
            <div><?php echo __("Total due:","premiumpress"); ?><?php echo hook_price($payment_due); ?></div>
            <?php } ?>
            <div id="author-toolbox-payment-options"></div>
         </div>
      </div>
   </div>
</div>
<!-- end payment form -->
<script>
   function ajax_show_enhancements(){
   
       jQuery.ajax({
           type: "POST",
           url: '<?php echo home_url(); ?>/',		
   		data: {
               action: "listing_enhancements",			 
   			pid: <?php echo $post->ID; ?>,			 
           },
           success: function(response) {
   		
   			jQuery('#modal-title').html("Choose an upgrade option");
   			
   			if(response == ""){
   			jQuery('#author-toolbox-payment-options').html('<?php echo __("No upgrades available.","premiumpress"); ?>');
   			}else{
   			jQuery('#author-toolbox-payment-options').html(response);
   			}
   						
   			
   			
           },
           error: function(e) {
               //console.log(e)
           }
       });
   
   }
  
    
      
   function ajax_delete_listing(){
   
   if(confirm("<?php echo __("Are you sure?","premiumpress"); ?>")){
   
       jQuery.ajax({
           type: "POST",
           url: '<?php echo home_url(); ?>/',	
   		dataType: 'json',	
   		data: {
               action: "listing_delete",
   			pid: <?php echo $post->ID; ?>,
           },
           success: function(response) {			
   			if(response.status == "ok"){	
   							
   				window.open('<?php echo _ppt(array('links','myaccount')); ?>', "_self");			 
     		 	
   			}else{			
   				jQuery('#ajax_response_msg').html("error trying to delete");			
   			}			
           },
           error: function(e) {
               console.log(e)
           }
       });
   }// end are you sure
   
   }
</script>
