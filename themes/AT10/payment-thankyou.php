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

if(!_ppt_checkfile("payment-thankyou.php")){

global $CORE, $payment_data;

   
?>
<section class="section-60 bg-light">
      <div class="container">
      <div class="row">
         <div class="col-md-6 offset-md-3">
            <div class="card">
               <div class="card-header"><?php echo __("Order Complete","premiumpress"); ?></div>
               <div class="card-body">
                  <p><?php echo __("Thank you, you order has been received and is being processed.","premiumpress") ?></p>
                  <p class="margin-top3"><?php echo __("One of our team members will be in contact shortly.","premiumpress") ?></p>
                 
                  <?php if(!empty($payment_data)){ ?>           
                  <div class=" list-boxed">
                     <ul class="list-unstyled">
                     
                     <?php if(isset($payment_data) && isset($payment_data['IDFORMATTED'])){ ?>
                        <li class="header"><?php echo __("Order ID","premiumpress"); ?>: #<?php echo $payment_data['IDFORMATTED']; ?> &nbsp; </li>
                    <?php } ?>
                        
                        <?php if(isset($payment_data) && isset($payment_data['order_date'])){ ?>
                        <li><span><?php echo __("Order Date","premiumpress"); ?>:</span> 
						<?php echo hook_date($payment_data['order_date']." ".$payment_data['order_time']); ?> &nbsp; </li>
                        <?php } ?>
                        
                        <?php if(isset($payment_data) && isset($payment_data['order_total'])){ ?>
                        <li><span><?php echo __("Order Total","premiumpress"); ?>:</span> <em class="<?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo hook_price($payment_data['order_total']); ?></em> &nbsp; </li>
                        <?php } ?>
                        
                        <?php if(isset($payment_data['order_description']) && strlen($payment_data['order_description']) > 1){ ?>
                        <li><span><?php echo __("Order Info","premiumpress"); ?>:</span> <?php echo stripslashes($payment_data['order_description']); ?> &nbsp; </li>
                        <?php } ?>
                        <?php if(isset($payment_data['order_email']) && strlen($payment_data['order_email']) > 1){ ?>
                        <li><span><?php echo __("Order Email","premiumpress"); ?>:</span> <?php echo $payment_data['order_email']; ?> &nbsp; </li>
                        <?php } ?>
                        
                        <?php if(isset($payment_data) && isset($payment_data['order_gatewayname'])){ ?>
                        
                        <li><span><?php echo __("Payment Method","premiumpress"); ?>:</span> <?php echo $payment_data['order_gatewayname']; ?> &nbsp; </li>
                        
                        <?php } ?>
                        
                        <?php if(isset($payment_data) && isset($payment_data['user_id'])){ ?>
                        
                        <li><span><?php echo __("User Account","premiumpress"); ?>:</span> <?php echo $payment_data['user_login_name']; ?> (#<?php echo $payment_data['user_id']; ?>) &nbsp; </li>
                        <?php } ?>
                        
                     </ul>
               </div>
              </div>
               <div class="card-footer">
                  <div class="row">
                     <div class="col-md-6">
                        <!-- RETURN USER TO THE PURCHASED/PAID ITEM --->
                        <?php 
                           /*
                           1. CREDIT OR PAY
                           2. LST
                           3. USERPAYMENT
                           4. MEM
                           5. BAN
                           6. CART		
                           */
						   
						   if(isset($payment_data['order_id']) && substr($payment_data['order_id'],0,3) == "LST"){
						   $h = explode("-", $payment_data['order_id']);
						   $_POST['paid_item_id'] = $h[1];						   
						   }
                           
                           	?>
                        <?php if(isset($_POST['paid_item_id']) && is_numeric($_POST['paid_item_id']) ){ ?>
                        <a href="<?php echo get_permalink($_POST['paid_item_id']); ?>" class="btn btn-primary margin-top4"><?php echo __("Return to listing","premiumpress") ?></a>
                        <?php }else{ ?>
                        <a href="<?php echo _ppt(array('links','myaccount')); ?>" class="btn btn-primary margin-top4"><?php echo __("Return to my account","premiumpress") ?></a>
                        <?php } ?> 
                     </div>
                     <div class="col-md-6  text-lg-right">
                     <?php if(isset($payment_data['ID'])){ ?>
                        <a href="<?php echo THEME_URI; ?>/_invoice.php?invoiceid=<?php echo $payment_data['ID']; ?>" target="_blank" class="btn btn-secondary">
                        <i class="far fa-file-text" aria-hidden="true"></i> <?php echo __("View Invoice","premiumpress") ?>
                        </a>
                        <?php } ?>
                     </div>
                  </div>
               </div> 
          
           
      <?php } ?>
        
            
              
         </div>
      </div> </div></div>
      <?php hook_callback_success(); ?>

</section>
<?php } ?>