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
   
   global $CORE, $userdata; $shown =1;
   
   // PACKAGE /MEMEBERSHIP DATA
   $csubscriptions = get_option("csubscriptions"); 
   
   
   // GET USERS EXISTING SUBSCRIPTION
   $f = get_user_meta($userdata->ID, 'ppt_subscription',true);
   if(!array($f) || (is_array($f) && empty($f) ) ){ $f = ""; }
    
   
   if(isset($f['date_expires'])){
   $da = $CORE->date_timediff($f['date_expires'],'');
   }
    
   
   ?>
<?php /*
   <div class="stepbox row mb-5">
   				<div class="col-4 stepbox-step active step1">
   					<div class="text-center stepbox-stepnum"><?php echo __("Select Package","premiumpress"); ?></div>
<div class="progress">
   <div class="progress-bar"></div>
</div>
<a href="javascript:void(0);" onclick="ChangeSteps(1);" class="stepbox-dot bg-dark"></a>
</div>
<div class="col-4 stepbox-step step2">
   <div class="text-center stepbox-stepnum"><?php echo __("Payment","premiumpress"); ?></div>
   <div class="progress">
      <div class="progress-bar"></div>
   </div>
   <a href="javascript:void(0);" class="stepbox-dot bg-dark"></a>
</div>
<div class="col-4 stepbox-step step3">
   <div class="text-center stepbox-stepnum">
      <?php if(is_array($f) && $da['expired'] == 0 ){ ?>
      <?php echo __("My Membership","premiumpress"); ?></a><?php }else{ ?>
      <?php echo __("Complete","premiumpress"); ?>
      <?php } ?>
   </div>
   <div class="progress">
      <div class="progress-bar"></div>
   </div>
   <a href="javascript:void(0);" <?php if(is_array($f) && $da['expired'] == 0 ){ ?> onclick="ChangeSteps(3);"<?php } ?> class="stepbox-dot bg-dark"></a>  
</div>
</div>
*/ ?>
<script>
   function ChangeSteps(step){
   
   	if(step == 1){
   	
   		jQuery('.step1').addClass('active'); 
   		jQuery('.step2').removeClass('active');
      		jQuery('.step3').removeClass('active');
      		  		 
      		 	
   		jQuery('#packagesbox').show();
   		jQuery('#confirmpage').hide();
   		jQuery('#existingpackagebox').hide();
   		
   		jQuery('.step3 .progress').removeClass('bg-success');			
   		jQuery('.step2 .progress').removeClass('bg-success');
   		
   	}else if(step == 2){
   		
   		jQuery('.step3').removeClass('active');
      		jQuery('.step2').addClass('active');   		
      		jQuery('#step-packages').hide();		
      		jQuery('#step-content').show();		
      		jQuery('#step-payment').hide();		
   		jQuery('.step2 .progress').addClass('bg-success');
   		jQuery('.step1 .progress').addClass('bg-success');
   	
   	}else if(step == 3){
   		
   		jQuery('.step1').addClass('active');
   		jQuery('.step2').addClass('active');
   		jQuery('.step3').addClass('active');
   		
   		<?php if(is_array($f) && $da['expired'] == 0 ){ ?>
   		jQuery('#packagesbox').hide();
   		jQuery('#confirmpage').hide();
   		jQuery('#existingpackagebox').show();
   		<?php } ?>
   		jQuery('.step1 .progress').addClass('bg-success');
   		jQuery('.step2 .progress').addClass('bg-success');
   		jQuery('.step3 .progress').addClass('bg-success');
   	} 
   }
   
</script>
<?php 
   if(is_array($f) && $da['expired'] == 0 ){
   $h = $CORE->get_subscription_name($userdata->ID);
   
   ?>
<?php if(count($csubscriptions['name']) > 2){ ?>
<script>
   jQuery(document).ready(function(){
   //
   //jQuery('#packagesbox').hide();
   //jQuery('#confirmpage').hide();
   jQuery('#maintext').html('<?php echo __("Upgrade Membership","premiumpress"); ?>');
   jQuery('.pp-<?php echo $f['key']; ?>').hide();
   });
</script>
<?php } ?>
<div id="existingpackagebox" <?php if(count($csubscriptions['name']) > 2){ ?>style="display:none;"<?php } ?>>
   <div class="package-tab-content bg-white">
      <div class="py-5 px-5">
         <?php get_template_part( hook_theme_folder( array('account', 'mymembership', true) ) , 'mymembership' ); ?>
      </div>
   </div>
</div>
<!-- end existing subscription box -->
<?php } ?>
<section class="pricingblock">
   <!-- setup package array for jquery -->
   <script>var mem = [];</script>
   <?php
      // CHECK FOR HIDDEN PACKAGES
      $hideME = array();	
      $f = get_user_meta($userdata->ID, 'ppt_subscription',true);
      
      if(is_array($f)){
      
      	if(is_array($csubscriptions) && !empty($csubscriptions) ){ 
      	 
      		$i=0; 
      		foreach($csubscriptions['name'] as $xxx){ 
      			if(strlen($xxx) > 0){
      			 
      				if(( isset($csubscriptions['hide'][$i]) && is_array($csubscriptions['hide'][$i]) ) && $f['key'] == $csubscriptions['key'][$i] ){
      				
      					foreach($csubscriptions['hide'][$i] as $j  ){  
      						
      						$hideME[] = $j;
      					
      					}
      				
      				} // end if
      			
      			
      			}
      		$i++;
      		}
      		
      	} // end if
      
      }// end if
      
      
      // LOOP ID
      $i = 1; $shown = 0;
      
      // START LLOOP 
      if(is_array($csubscriptions) && !empty($csubscriptions) ){ $i=0; 
      
      foreach($csubscriptions['name'] as $data){ 
      
      if($csubscriptions['name'][$i] != "" ){
      
      if(in_array($csubscriptions['key'][$i], $hideME)){ $i++; continue; } 
      
      // HIDE ALSO IF EXISTING PACKAGE HAS THIS MEMBERSHIP
      //if(isset($GLOBALS['current_membership']) && is_numeric($GLOBALS['current_membership']) && $GLOBALS['current_membership'] == $field['ID']){ continue; }
       
      // WORK OUR PRICE
      $PRICE = hook_price($csubscriptions['price'][$i]);
      if($csubscriptions['price'][$i] == 0){       
      	$dprice = __("FREE","premiumpress");       
      	$isfree = true;
      }else{
      	$dprice = $PRICE;      	 
      	$isfree = false;
      }
      
      // WORK OUR DAYS 
      $DAYS    = $csubscriptions['days'][$i];         	
      switch($DAYS){				
      case "1": {
      $daytext = "24 ".__("Hours","premiumpress");
      } break;
      case "7": {
      $daytext = "1 ".__("Week","premiumpress");
      } break;
      case "30": {
      $daytext =  "1 ".__("Month","premiumpress");
      } break;
      case "365": {
      $daytext =  "1 ".__("Year","premiumpress");
      } break;
      default: { 
      $daytext = $DAYS." ".__("Days","premiumpress"); 
      }
      }
      
      // INCREASE 
      $shown++;
      
      
      ?>
   <div class="package-posts py-4 col-12 bg-white shadow-sm mb-4">
      <div class="row">
         <div class="col-md-3 box-price text-center">
            <div class="text-success text-center h1"><?php echo $dprice; ?></div>
            <div class="h6 text-center" id="pdaystext<?php echo $i; ?>"><?php echo $daytext; ?></div>
            <?php if($csubscriptions['recurring'][$i] ==1){ ?> 
            <div><?php echo __("Subscription","premiumpress"); ?></div>
            <?php } ?>
         </div>
         <div class="col-md-6 text-left box-desc">
            <h5 class="mb-3"><?php echo stripslashes($csubscriptions['name'][$i]); ?> </h5>
            <?php if(strlen($csubscriptions['desc'][$i]) > 1){ ?>
            <p class="mb-0 text-muted mt-4"><?php echo stripslashes($csubscriptions['desc'][$i]); ?></p>
            <?php } ?>
             
            
         </div>
         <div class="col-md-3 box-btn">
            <a class="btn btn-success text-uppercase btn-block font-weight-bold mt-2" id="btn-<?php echo $csubscriptions['key'][$i]; ?>"  <?php if($userdata->ID){ ?> href="javascript:void(0);" onclick="processSubscription('<?php echo $i; ?>','<?php 
               $couponcode = "";
               if(isset($_POST['couponcode'])){
               $couponcode = esc_attr($_POST['couponcode']);
               }
               
               echo  $CORE->order_encode(array(               
               "uid" => $userdata->ID,                
               "amount" => $csubscriptions['price'][$i],                
               "local_currency_amount" => $csubscriptions['price'][$i],
               "local_currency_code" => $CORE->_currency_get_code(), 
			               
               "order_id" => "SUBS-".str_replace("-s","",$csubscriptions['key'][$i])."-".$userdata->ID."-".rand(),                 
               "description" => stripslashes($csubscriptions['name'][$i]),
               "recurring" => $csubscriptions['recurring'][$i],    
               "recurring_days" => $DAYS,            
               "couponcode" => $couponcode,               
               ) 								
               ); 
               ?>');"<?php }else{ ?>href="<?php echo wp_login_url( get_permalink($post->ID) ); ?>"<?php } ?>><?php echo __("Select Package","premiumpress") ?></a>
         </div>
      </div>
   </div>
   <script>
      mem[<?php echo $i; ?>] = {
      	name:"<?php echo stripslashes($csubscriptions['name'][$i]); ?>", 
      	price:"<?php echo hook_price($csubscriptions['price'][$i]); ?>", 
      	time:"<?php echo $daytext; ?>", 
      	listings:"<?php  if(isset($csubscriptions['listings'][$i])){ echo $csubscriptions['listings'][$i]; }else{ echo 0; } ?>",
      expirydate:"<?php echo hook_date(date( 'd.m.Y H:i:s', strtotime("+ ".$DAYS." days"))); ?>",
      };
   </script> 
   <?php } $i++; $shown++; } } ?>
</section>
<script>
   function processSubscription(mid, sid){
   
   	jQuery('#ppname').html(mem[mid]['name']);
   	jQuery('#ppprice').html(mem[mid]['price']);
   	jQuery('#pplistings').html(mem[mid]['listings']);
   	jQuery('#ppflistings').html(mem[mid]['flistings']);
   	jQuery('#pptime').html(mem[mid]['time']);
   jQuery('#ppexpirydate').html(mem[mid]['expirydate']);
   
   
       jQuery.ajax({
           type: "POST",
           url: '<?php echo home_url(); ?>/',		
   		data: {
               action: "load_new_payment_form",
   			details: sid, 
           },
           success: function(response) { 
     	ChangeSteps(2);
   			jQuery('#confirmpage').show();
   			jQuery('.pricingblock').hide();
   			jQuery('#ajax_payment_form').html(response);			 
   			
           },
           error: function(e) {
               console.log(e)
           }
       });
   
   }
   
</script>
<?php if($userdata->ID){ ?><?php } ?>
<div class="clearfix"></div>
<div id="confirmpage" style="display:none;" class=" mt-5">
   <div class="col-md-12 px-0">
      <p class="pb-2"><?php echo __("All transactions are secure and encrypted. Credit card information is never stored.","premiumpress"); ?></p>
      <div class="row">
         <div class="col-md-8">
            <div id="ajax_payment_form"></div>
            <p class="small mt-3"><?php echo __("By clicking \"Pay Now\" you agree to our","premiumpress"); ?> <a href="<?php echo _ppt(array('links','terms')); ?>"><?php echo __("Terms &amp; conditions","premiumpress"); ?></a></p>
         </div>
         <div class="col-md-4">
            <ul class="payment-right p-0">
               <li>
                  <div id="package-type" class="left">
                     <?php echo __("Name","premiumpress"); ?>
                  </div>
                  <div class="right">
                     <span id="ppname">xxx</span>
                  </div>
                  <div class="clearfix"></div>
               </li>
               <li>
                  <div class="left"><?php echo __("Time Period","premiumpress"); ?>:</div>
                  <div class="right">
                     <span id="pptime">xxx</span>
                  </div>
                  <div class="clearfix"></div>
               </li>
               <li>
                  <div class="left"><?php echo __("Expiry Date","premiumpress"); ?>:</div>
                  <div class="right">
                     <span id="ppexpirydate">xxx</span>
                  </div>
                  <div class="clearfix"></div>
               </li>
               <?php if(THEME_KEY != "da"){ ?>
               <li>
                  <div class="left"><?php echo __("Listings Included","premiumpress"); ?>:</div>
                  <div class="right">
                     <span id="pplistings">xxx</span>
                  </div>
                  <div class="clearfix"></div>
               </li>
               <?php } ?>
               <li>
                  <div class="left"><strong><?php echo __("Total","premiumpress"); ?>:</strong></div>
                  <div class="right">	
                     <span id="ppprice">xxx</span>
                  </div>
                  <div class="clearfix"></div>
               </li>
            </ul>
         </div>
      </div>
   </div>
</div>
<!-- end confirm box -->
<?php
   // COUPON CODE
   if(isset($_POST['coupon_orderid']) && strlen($_POST['coupon_orderid']) > 5 ){
   $sm = explode("-", $_POST['coupon_orderid']);
   ?>
<script>
   jQuery(document).ready(function() {
   	setTimeout(function(){
   		jQuery('#btn-<?php echo $sm[1]; ?>').click();
   	}, 1000);
   });
</script>
<?php 
   }
   ?>