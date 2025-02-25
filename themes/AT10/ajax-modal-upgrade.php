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
<div class="text-center py-3">
  <h1 class="h2"> <?php echo __("Get Access Now!","premiumpress") ?></h1>
  <p class="text-muted my-3 col-md-10 mx-auto"><?php echo __("Signup for a membership today!","premiumpress"); ?></p>
</div>
<div class="card shadow-sm" style="max-height:600px; overflow:hidden; overflow-y:scroll">
  <div class="card-body p-lg-5">
    <?php foreach(  $CORE->USER("get_memberships", array() ) as $k => $n){ 

 
		$btn =  $CORE->order_encode(array(  
					               
						   "uid" 					=> $userdata->ID,                
						   "amount" 				=> $n['price'], 
						   "order_id" 				=> "SUBS-mem".$n['key']."-".$userdata->ID."-".rand(),                 
						   "description" 			=> $n['name'],
						   "recurring" 				=> $n['recurring'],    
						   "recurring_days" 		=> $n['duration'],            
						   "couponcode" 			=> "", 					                 
	));
	
	// TEXT CHANGES
	$btnColor = "btn-primary";
	$bgColor = "bg-light";
	$linkColor = "";
	if(_ppt('mem'.$n['key'].'_highlight') == 1){
	$btnColor = "btn-light";
	$bgColor = "bg-primary text-white";
	$linkColor = "text-light";
	}
	
	// DONT SHOW SUBSCRIBED PACKAGES
	$dontshowkey = "";
	if($userdata->ID ){		
				 
		$cm			= get_user_meta($userdata->ID,'ppt_subscription'); 		 
		if(is_array($cm) && isset($cm[0]) && _ppt($cm[0]['key'].'_repurchase') == "0" && !is_admin() ){					 
			$dontshowkey = $cm[0]['key'];			 
					 
		}					
				
	}
	
 

  ?>
    <div class="card p-2 shadow-sm mb-4 p-3 <?php echo $bgColor; ?> text-center text-lg-left <?php if($dontshowkey == $n['key'] || $dontshowkey == "mem".$n['key']){ ?> opacity-5<?php } ?>">
      <div class="row">
        <div class="col-lg-8">
          <h4><?php echo $n['name']; ?></h4>
          <p class="mb-0"><span class="<?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo hook_price($n['price']); ?></span> <?php echo __("for","premiumpress"); ?> <?php echo $n['duration_text']; ?></p>
        </div>
        <div class="col-lg-4 text-center">
         
         
         
          
          <?php if(!$userdata->ID){ ?>
          <a href="javascript:void(0)" <?php if(isset($_GET['action']) && $_GET['action'] == "register"){ ?>onclick="processRegister(); jQuery('.upgrade-modal-wrap').fadeOut(400);"<?php }else{ ?>onclick="processLogin(1);jQuery('.upgrade-modal-wrap').fadeOut(400);"<?php } ?> class="upgradebtn btn <?php echo $btnColor; ?>mt-4 mt-lg-0" ><?php echo __("Select Package","premiumpress"); ?> </a>
         
         <?php }elseif($dontshowkey == $n['key'] || $dontshowkey == "mem".$n['key']){ ?>
         
         
          <a href="javascript:void(0);" class="btn bg-system btn-sm mt-4 mt-lg-0"><?php echo __("Current Plan","premiumpress"); ?> </a>
         
          <?php }else{ ?>
          <a href="javascript:void(0);" class="btn <?php echo $btnColor; ?> mt-4 mt-lg-0" onclick="processPayment('<?php echo $btn; ?>','<?php echo $n['price']; ?>');"><?php echo __("Select Package","premiumpress"); ?> </a>
          <?php } ?>
          
          <div class="mt-2"><a href="javascript:void(0);" class="small <?php echo $linkColor; ?>" onclick="jQuery('#featuresfor<?php echo $n['key']; ?>').toggle();"><?php echo __("view features","premiumpress"); ?></a></div>
          
        </div>
      </div>
    </div>
    
    <div id="featuresfor<?php echo $n['key']; ?>" style="display:none;">
    <div class="card p-2 shadow-sm mb-4 p-3 bg-white text-center text-lg-left">

<h6><?php echo __("Featured Included","premiumpress"); ?></h6>
<ul class="list-unstyled col-lg-8 m-0 p-0">
    <?php foreach($CORE->USER("membership_features", array()) as $f){  
	
	if( _ppt($n['key']."_".$f['key']."_hide") == "1" || _ppt("mem".$n['key']."_".$f['key']."_hide") == "1" ){ continue; }
	
	 ?>
            <li class="mb-2">
              <div class="float-left"><?php echo $f['name']; ?>: </div>
              <div class="right">
               
              
                <?php if( _ppt($n['key']."_".$f['key']) == "1" || _ppt("mem".$n['key']."_".$f['key']) == "1" ){  ?>
                <span class="inline-flex items-center font-weight-bold order-status-icon status-1"> <span class="dot mr-2"></span><span class="pr-2px leading-relaxed whitespace-no-wrap"><?php echo __("Active","premiumpress"); ?></span> </span>
                <?php }else{ ?>
                <span class="inline-flex items-center font-weight-bold order-status-icon status-2"> <span class="dot mr-2"></span><span class="pr-2px leading-relaxed whitespace-no-wrap"><?php echo __("Inactive","premiumpress"); ?></span> </span>
                <?php } ?>
                
              </div>
              <div class="clearfix"></div>
            </li>
            <?php } ?>
    </ul>
    </div>
    
    </div>
    
    <?php } ?>
    
    <?php if(!$userdata->ID){ ?>
    
    <div class="text-muted my-3 text-center"><?php echo __("Already a member?","premiumpress"); ?> <a <?php if(isset($GLOBALS['flag-register'])){ ?>href="<?php echo wp_login_url(); ?>"<?php }else{ ?>href="javascript:void(0)" onclick="processLogin();jQuery('.upgrade-modal-wrap').fadeOut(400);"<?php } ?> class="upgradebtn text-primary modal-register-link"><u><?php echo __("login here","premiumpress"); ?></u></a> </div>
    
    <?php }elseif($userdata->ID){ $mem = $CORE->USER("get_user_membership", $userdata->ID); $da = $CORE->date_timediff($mem['date_expires'],'');  if($da['days-left'] > 0){  ?>
 
      <?php if(in_array(_ppt(array('mem','paktime')), array("","1"))){ ?>
      <div class="alert alert-success text-center">
      <?php echo str_replace("%s", "<u class='font-weight-bold'>".$da['days-left']."</u>", __("Buy a new membership today and get the %s days left on your old membership added completely free!","premiumpress")); ?>
      </div>
      <?php } ?>
     
      
      <?php } } ?>
    
  </div>
</div>
<script> 

function processPayment(sid,pp){
   	
		jQuery(".upgrade-modal-wrap").fadeOut(400);	
   	 
       jQuery.ajax({
           type: "POST",
           url: '<?php echo home_url(); ?>/',		
   		data: {
               action: "load_new_payment_form",
   				details: sid, 
           },
           success: function(response) { 
		   
		   jQuery(".payment-modal-wrap").fadeIn(400); 
		 
		    jQuery(".payment-modal-container h3").text(pp); 			 
			 
   			jQuery('#ajax-payment-form').html(response);	
			
			UpdatePrices();		 
   			
           },
           error: function(e) {
               console.log(e)
           }
       });
   
   }
   
</script>