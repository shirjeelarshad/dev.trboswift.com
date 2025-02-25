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

global $CORE, $userdata; ?>
<?php if(isset($_GET['checkemail'])){ ?>

<div class="alert alert-success"><i class="fa fa-envelope fa-3x mr-3 float-left"></i> <?php echo __("We have sent password recovery instructions to your email address.","premiumpress") ?></div>
<?php } ?>

<?php if($GLOBALS['flag-account']){ ?>


<?php }else{ ?>
<div class="text-center py-3">
  <h1 class="h2"> <?php echo __("Get Access Now!","premiumpress") ?></h1>
  <p class="text-muted my-3 col-md-10 mx-auto"><?php echo __("Signup for a membership today!","premiumpress"); ?></p>
</div>
<?php } ?>


<div class="card <?php if(!isset($GLOBALS['no-mem-header'])){  ?>shadow-sm<?php } ?>">


<?php 
if(isset($GLOBALS['no-mem-header'])){ 


}elseif(isset($GLOBALS['flag-account'])){ ?>
  <div class="card-header  bg-white">
  <a href="<?php echo wp_logout_url(home_url()); ?>" class="btn btn-system btn-sm float-right mt-2"><i class="fa fa-sign-out"></i> <?php echo __("logout","premiumpress"); ?></a> 
    <h4 class="mb-0 text-black"><i class="fal fa-star mr-2"></i> <?php echo __("Membership Required","premiumpress") ?></h4>
  </div>
 
<div class="text-muted text-center mt-4 pt-4"><?php echo __("Please confirm and pay for your membership below;","premiumpress"); ?></div>

<?php } ?>




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
 

  ?>
    <div class="card p-2 shadow-sm mb-4 p-3 bg-light text-center text-lg-left">
      <div class="row">
        <div class="col-lg-8">
          <h4><?php echo $n['name']; ?></h4>
          <p class="mb-0">
		  
		  <span class="text-uppercase small"><strong class="<?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo hook_price($n['price']); ?></strong> <?php echo __("for","premiumpress"); ?> <?php echo $n['duration_text']; ?> </span>
          
          
          
          </p>
          
         
         
          
        </div>
        <div class="col-lg-4">
          <?php if(!$userdata->ID){ ?>
          <a href="javascript:void(0)" <?php if(isset($_GET['action']) && $_GET['action'] == "register"){ ?>onclick="processRegister();"<?php }else{ ?>onclick="processLogin(1);"<?php } ?> class="btn btn-primary btn-sm py-2 mt-4 mt-lg-0 btn-block" ><?php echo __("Continue","premiumpress"); ?> </a>
          <?php }else{ ?>
          <a href="javascript:void(0);" class="btn btn-primary mt-4 mt-lg-0 btn-block btn-sm py-2 font-weight-bold" onclick="processPayment('<?php echo $btn; ?>','<?php echo $n['price']; ?>');"><?php if($GLOBALS['flag-account']){  echo __("Pay Now","premiumpress"); }else{  echo __("Continue","premiumpress"); }  ?> </a>
          <?php } ?> 
          
          
           <div>
           <a href="javascript:void(0);" class="btn btn-sm btn-system mt-2 btn-block" onclick="jQuery('#featuresfor<?php echo $n['key']; ?>').toggle();"> <?php echo __("view features","premiumpress"); ?></a>
          </div>
          
        </div>
      </div>
    </div>
    
    
    
     <div id="featuresfor<?php echo $n['key']; ?>" style="display:none;">
    <div class="card p-2 shadow-sm mb-4 p-3 bg-white text-center text-lg-left">

<h6><?php echo __("Featured Included","premiumpress"); ?></h6>
<ul class="list-unstyled col-lg-8 m-0 p-0">
    <?php foreach($CORE->USER("membership_features", array()) as $f){  
	
		if( _ppt($n['key']."_".$f['key']."_hide") == "1" || _ppt("mem".$n['key']."_".$f['key']."_hide") == "1"  ){ continue; }
	
	 ?>
            <li class="mb-2">
              <div class="float-left"><?php echo $f['name']; ?>: </div>
              <div class="float-right">
               
              
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
    
    <div class="text-muted my-3 text-center"><?php echo __("Already a member?","premiumpress"); ?> <a <?php if(isset($GLOBALS['flag-register'])){ ?>href="<?php echo wp_login_url(); ?>"<?php }else{ ?>href="javascript:void(0)" onclick="processLogin();"<?php } ?> class="text-primary modal-register-link"><u><?php echo __("login here","premiumpress"); ?></u></a> </div>
    
    
    <?php }else{ ?>
    
     
    
    <?php } ?>
    
  </div>
</div>
<script> 

function processPayment(sid,pp){
   	 
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
