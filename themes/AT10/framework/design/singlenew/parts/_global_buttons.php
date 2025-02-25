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
        
<?php 
		  
if(defined('THEME_KEY') && in_array(THEME_KEY, array("sp"))){
   
   $GLOBALS['inlineBtn'] = 1;
   _ppt_template( 'framework/design/singlenew/blocks/sidebar-sp-buttons' );  
   

}elseif(defined('THEME_KEY') && in_array(THEME_KEY, array("at"))){
   
   $GLOBALS['inlineBtn'] = 1; ?>
   
   <div class="bg-light mt-4 p-3">
  <?php _ppt_template( 'framework/design/singlenew/parts/_auction_buy' ); ?>
  </div>
  <?php
  


}elseif(in_array(THEME_KEY, array("es"))){ 

?>

   <div class="border-top pt-4 mt-5">
  <div class="row">
  
  <div class="col-md-6 mb-4 mb-md-0">
     
     
       <?php if(in_array(_ppt(array('user','account_messages')), array("","1")) ){ ?>
      <a <?php echo $CORE->USER("get_message_link", $post->post_author); ?> class="btn prev btn-block btn-system shadow-sm btn-xl btn-icon icon-before"><i class="fal fa-comments-alt mr-2 text-primary"></i> <?php echo __("Message","premiumpress") ?></a>
      <?php } ?>
     
     
  </div>
  <div class="col-md-6 mb-4 mb-md-0">
  
  
   
     <button type="button" onclick="processRates()" class="btn prev btn-block btn-system shadow-sm btn-xl btn-icon icon-before mb-3">
        <i class="fal fa-clock mr-2 text-primary"></i> <?php echo __("My Rates","premiumpress"); ?>
        </button>
     
  </div>
  </div>
  
  
   
      
      <script>
	  
	 
   
   function processRates(){	 jQuery(".extra-modal-wrap1").fadeIn(400);}   
   
   </script>
      <!--msg model -->
      <div class="extra-modal-wrap1 shadow hidepage" style="display:none;">
        <div class="extra-modal-wrap1-overlay"></div>
        <div class="extra-modal-item">
          <div class="extra-modal-container">
            <div class="card-body">
              <?php _ppt_template( 'framework/design/singlenew/blocks/rates' );  ?>
            </div>
            <div class="card-footer text-center">
              <button type="button" onclick="jQuery('.extra-modal-wrap1').fadeOut(400);" class="btn prev btn-system shadow-sm btn-xl"><?php echo __("Close Window","premiumpress"); ?></button>
            </div>
          </div>
        </div>
      </div>


<?php 
  
}elseif(in_array(THEME_KEY, array("mj"))){ 


   // LISTING STATUS
   $status = get_post_meta($post->ID, 'status', true);
  

?>
  
  
  
   <div class="border-top pt-4 mt-5">
  <div class="row">
  
  <div class="col-md-6 mb-4 mb-md-0">
     
     
       <?php if(in_array(_ppt(array('user','account_messages')), array("","1")) ){ ?>
      <a <?php echo $CORE->USER("get_message_link", $post->post_author); ?> class="btn prev btn-block btn-system shadow-sm btn-xl btn-icon icon-before"><i class="fal fa-comments-alt mr-2 text-primary"></i> <?php echo __("Message","premiumpress") ?></a>
      <?php } ?>
     
     
  </div>
  <div class="col-md-6 mb-4 mb-md-0">
  
      <?php if($status == 1){ ?>
        <button class="btn prev btn-light btn-lg btn-block border"><?php echo __("Sold Out","premiumpress"); ?></button>
        <?php }else{ ?>
  
     <button type="button"  
		  <?php if(!$userdata->ID){ ?>href="javascript:void(0)" onclick="processLogin(1,0);"<?php } ?>
          
		  <?php if($userdata->ID == $post->post_author){ ?>onclick="alert('<?php echo __("You cannot buy on your own items.","premiumpress"); ?>');"<?php }else{ ?>onclick="processMakeOffer1()"<?php } ?> class="btn prev btn-block btn-system shadow-sm btn-xl btn-icon icon-before mb-3">
        <i class="fal fa-shopping-basket mr-2 text-primary"></i> <?php echo __("Buy Now","premiumpress"); ?>
        </button>
        
        <?php } ?>
        
  </div>
  </div>
  
  
   
      
      <script>
	  
	 
   
   function processMakeOffer1(){	 jQuery(".extra-modal-wrap1").fadeIn(400);}   
   
   </script>
      <!--msg model -->
      <div class="extra-modal-wrap1 shadow hidepage" style="display:none;">
        <div class="extra-modal-wrap1-overlay"></div>
        <div class="extra-modal-item">
          <div class="extra-modal-container">
            <div class="card-body">
              <?php _ppt_template( 'framework/design/singlenew/blocks/sidebar-mj' );  ?>
            </div>
            <div class="card-footer text-center">
              <button type="button" onclick="jQuery('.extra-modal-wrap1').fadeOut(400);" class="btn prev btn-system shadow-sm btn-xl"><?php echo __("Close Window","premiumpress"); ?></button>
            </div>
          </div>
        </div>
      </div>
      
      

<?php }elseif(in_array(THEME_KEY, array("da"))){ ?>

 <div class="border-top pt-4 mt-5">
  <div class="row">
  
  <div class="col-md-6 mb-4 mb-md-0">
     
     
       <?php if(in_array(_ppt(array('user','account_messages')), array("","1")) ){ ?>
      <a <?php echo $CORE->USER("get_message_link", $post->post_author); ?> class="btn prev btn-block btn-system shadow-sm btn-xl btn-icon icon-before"><i class="fal fa-comments-alt mr-2 text-primary"></i> <?php echo __("Message","premiumpress") ?></a>
      <?php } ?>
     
     
  </div>
  <div class="col-md-6 mb-4 mb-md-0">
  
  
          <?php if( in_array(_ppt(array('design', 'display_gifts')), array("", "1")) ){ ?>
        <a 
      <?php if(!$CORE->USER("membership_hasaccess", "gifts")){ ?>
       
       href="javascript:void(0);"  onclick="processUpgrade();"
       
       <?php }elseif(!$userdata->ID){ ?>
       
        href="javascript:void(0);" onclick="processLogin();" 
         
       <?php }elseif($userdata->ID && $CORE->USER("membership_hasaccess", "gifts")){ ?>
       
       href="javascript:void(0);"  onclick="giftshow();"
         
       <?php }else{ ?>
       
      href="javascript:void(0);"  onclick="ProcessUpgrade();"
      <?php } ?>
      
     class="btn prev btn-block btn-system shadow-sm btn-xl btn-icon icon-before"><i class="fal fa-heart mr-2 text-primary"></i> <?php echo __("Send Gift","premiumpress") ?></a>
        <?php } ?>
  
  </div>
  </div>
   </div>
   
   
<?php if($CORE->USER("membership_hasaccess", "gifts")){ ?>
<script>
function SendGiftItem(tid){


jQuery('#gifticons').html("<div class='col-12 text-center'><i class='fas fa-spinner fa-spin fa-3x'></i></div>");

jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            action: "add_gift",
			pid: <?php echo $post->ID; ?>,
			uid: <?php echo $userdata->ID; ?>,
			rid: <?php echo $post->post_author; ?>,
			gift: tid,			 			
        },
        success: function(response) {
 
			if(response.status == "ok"){ 
			
			
				jQuery.ajax({
						type: "POST",
						url: '<?php echo home_url(); ?>/',	
						dataType: 'json',	
						data: {
							action: "send_chat_msg",
							uid: <?php echo $userdata->ID; ?>,
							rid: <?php echo $post->post_author; ?>,
							gift: tid,
							msg: 'gift',			
						},
						success: function(response) {
				 
							if(response.status == "ok"){
							
									jQuery("#giftsent").show();
									jQuery("#giftselect").hide();
							
							}else{			
								
										
							}			
						},
						error: function(e) {
							console.log(e)
						}
				});
							
			
			}else if(response.status == "found"){ 	 		 
  		 	
			jQuery("#toomnaygifts").show();
			jQuery("#giftselect").hide();
			
			}else{			
				alert("asd");		
			}			
        },
        error: function(e) {
            console.log(e)
        }
});


}

function giftshow(){

	jQuery(".extra-modal-wrap").fadeIn(400);	

}
</script>
<!--gift modal -->
<div class="extra-modal-wrap shadow hidepage" style="display:none;">
  <div class="extra-modal-wrap-overlay"></div>
  <div class="extra-modal-item">
    <div class="extra-modal-container">
      <?php if(!$CORE->USER("membership_hasaccess", "gifts")){ ?>
      <div class="alert p-3 my-4 alert-warning m-4" id="giftsent"> <i class="float-left pb-2 fa-3x fa fa-lock mr-3"></i>
        <div class="lead font-weight-bold"><?php echo __("No Access","premiumpress"); ?></div>
        <p class="mb-0 pb-0"><?php echo __("Please upgrade your membership to access this feature.","premiumpress"); ?></p>
      </div>
      <div class="extra-modal-close bg-dark text-center" onclick="jQuery('.extra-modal-wrap').fadeOut(400)" style="top: 30px;"><i class="fal fa-times">&nbsp;</i></div>
      <?php }else{ ?>
      <div class="alert p-3 my-4 alert-success m-4" id="giftsent" style="display:none;"> <i class="float-left pb-2 fa-3x fa fa-check mr-3"></i>
        <div class="lead font-weight-bold"><?php echo __("Gift Sent!","premiumpress"); ?></div>
        <p class="mb-0 pb-0"><?php echo __("Your gift is on it's way, the user will be notified shortly.","premiumpress"); ?></p>
        <div class="extra-modal-close bg-dark text-center" onclick="jQuery('.extra-modal-wrap').fadeOut(400)" style="top: 30px;"><i class="fal fa-times">&nbsp;</i></div>
      </div>
      <div class="alert p-3 my-4 alert-danger m-4" id="toomnaygifts" style="display:none;"> <i class="float-left pb-2 fa-3x fa fa-heart-broken mr-3"></i>
        <div class="lead font-weight-bold"><?php echo __("Too Many Gifts","premiumpress"); ?></div>
        <p class="mb-0 pb-0"><?php echo __("It looks like you've already sent this user a gift.","premiumpress"); ?></p>
        <div class="extra-modal-close bg-dark text-center" onclick="jQuery('.extra-modal-wrap').fadeOut(400)" style="top: 30px;"><i class="fal fa-times">&nbsp;</i></div>
      </div>
      <div class="card-body" id="giftselect">
        <h3><?php echo __("Click any gift icon below to send to","premiumpress") ?> <?php echo $CORE->USER("get_username",$post->post_author); ?></h3>
        <div class="container p-5">
          <div class="row" id="gifticons">
            <?php $i=1; while($i < 9){ 
			
			
			$defaultimg = get_template_directory_uri()."/_dating/icons/".$i.".png";
			if( _ppt(array('bgimg', "gift".$i)) == ""){			
			}else{				
				$defaultimg = _ppt(array('bgimg', "gift".$i));				
			}
			
			?>
            <div class="col-md-3 gifti<?php echo $i; ?>"> <a href="javascript:void(0);" <?php if($userdata->ID == $post->post_author){ ?>onclick="alert('<?php echo __("You cannot send yourself a gift.","premiumpress") ?>');"<?php }else{ ?>onclick="SendGiftItem('<?php echo $i; ?>');"<?php } ?>> <img src="<?php echo $defaultimg; ?>" alt="gif" class="img-fluid" /></a> </div>
            <?php $i++; } ?>
          </div>
        </div>
        <div class="extra-modal-close bg-primary text-center" onclick="jQuery('.extra-modal-wrap').fadeOut(400)"><i class="fal fa-times">&nbsp;</i></div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
<!--gift end -->
<?php } ?> 


<?php }elseif(in_array(THEME_KEY, array("cm"))){
   
   
   $afflink = get_post_meta($post->ID, 'buy_link', true);
   
   ?>
  
  
  <?php if(strlen($afflink) > 1){ ?>
  
  <div class="row">
  <div class="col-md-6 mb-4 mb-md-0">
      <a href="<?php echo $afflink; ?>" class="btn prev btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 mb-4"><i class="fal fa-shopping-cart mr-2 text-primary"></i> <?php echo __("Visit Store","premiumpress") ?></a>
  </div>
  <div class="col-md-6 mb-4 mb-md-0">
  
  
     <?php if(in_array(_ppt(array('user','favs')), array("","1")) ){ ?>
  
		  <?php if(!$userdata->ID){ ?>
          <a href="javascript:void(0);" onclick="processLogin();" class="btn prev btn-block btn-light btn-md px-3 mt-2"> <?php echo __("Add to favorites","premiumpress") ?></a>
          <?php }else{ ?>
          <?php echo do_shortcode('[FAVS class="btn prev btn-light btn-md btn-block mt-2 px-3" text=1 icon=0]'); ?>
          <?php } ?>
      
      <?php } ?>
  

  </div>
  </div> 
  <?php } ?>
 

 <?php }elseif(in_array(THEME_KEY, array("dt"))){ 
 
 	$websitelink = get_post_meta($post->ID, "website", true);
 ?>
 
  <div class="row">
  <div class="col-md-6 mb-4 mb-md-0">
  	
    
    
    <?php if( $websitelink != "" && strlen($websitelink) > 3){
	
	
	if(substr($websitelink,0,4) != "http" ){
		
		$websitelink = "https://".$websitelink;
		
		}
	?>
    
	
	   <a href="<?php echo $websitelink; ?>" target="_blank" rel="nofollow" class="btn prev btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 "><i class="fal fa-link mr-2 text-primary"></i> <?php echo __("Visit Website","premiumpress") ?></a>
    
    
    <?php }elseif(_ppt(array("maps","provider")) != "basic"){
		
		
	if(_ppt(array("maps","provider")) != "basic"){
	
		$long 		= get_post_meta($post->ID,'map-log',true); 
		$lat 		= get_post_meta($post->ID,'map-lat',true);	
		$address	= get_post_meta($post->ID,'map-location',true);			
				
		$post->carddata = 'data-pid="'.$post->ID.'" data-lat="'. $lat.'" data-long="'.$long.'" data-address="'.$address .'" ';
		$post->maplat = $lat;
		$post->maplong = $long;
	}
	$address 	= get_post_meta($post->ID,'map-location',true);
	$post->maplocation = do_shortcode('[LOCATION]');
	$post->city = do_shortcode('[CITY]');
		
		?>
        
        
         <a href="javascript:void(0);" class="btn prev btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 <?php if($address == ""){ echo "opacity-8"; }else{ echo "single-map-item"; } ?>"
    
    data-title="<?php echo strip_tags($post->title); ?>" 
    data-url="<?php echo $post->link; ?>" 
    data-newlatitude="<?php echo $post->maplat; ?>" 
    data-address="<?php echo $post->maplocation; ?>" 
    data-newlongitude="<?php echo $post->maplong; ?>"><i class="fal fa-map-marker mr-2 text-primary shadow-sm"></i> <?php echo __("View Map","premiumpress"); ?></a>
  
      <?php }elseif(in_array(_ppt(array('design','display_comments')), array("","1")) ){ ?>
    
     <a href="javascript:void(0)"  <?php if(!$userdata->ID){ ?> onclick="processLogin();" <?php }else{ ?>onclick="processCommentPop();"<?php } ?>  class="btn prev btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 mb-3"><i class="fal fa-comments mr-2 text-primary"></i> <?php echo __("Write Review","premiumpress") ?></a>
     
     
     <?php } ?>
  
  </div>
  <div class="col-md-6 mb-4 mb-md-0">
  
     
     <?php if(in_array(_ppt(array('user','account_messages')), array("","1")) ){ ?>
      
	  
	  <?php if(_ppt(array('lst','adminonly')) == 1 || !$userdata->ID){ ?>
      
      
      
      <?php _ppt_template( 'framework/design/singlenew/parts/_contactform' );  ?>
       
     
      <?php }else{ ?>
      
      <a <?php echo $CORE->USER("get_message_link", $post->post_author); ?> class="btn prev btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 "><i class="fal fa-paper-plane mr-2 text-primary"></i> <?php echo __("Message","premiumpress") ?></a>
    
      
	  <?php } ?>
      
      
      
      <?php } ?>

  </div>
  </div> 


<?php }elseif(in_array(THEME_KEY, array("dl","ct"))){ ?>


  <div class="row">
  <div class="col-md-6 mb-4 mb-md-0">


      <?php if(in_array(_ppt(array('design','display_offers')), array("","1")) && get_post_meta($post->ID, "status", true ) != 1 ){ ?>
      
      <?php if(get_post_meta($post->ID,"offertype", true) == 1){ ?>
      <a href="javascript:void(0);" <?php if($userdata->ID){ ?>onclick="BuyNowOffer();"<?php }else{ ?>onclick="processLogin();"<?php } ?>  class="btn prev btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 mb-3"><i class="fal fa-box-usd  text-primary"></i> <?php echo __("Buy Now","premiumpress"); ?> </a>
      <?php }else{ ?>
      <a href="javascript:void(0);" onclick="processMakeOffer();" class="btn prev btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 mb-3"> <i class="fal fa-comments-alt-dollar text-primary"></i> <span><?php echo $CORE->LAYOUT("captions","offerbtn"); ?></span></a>
      <?php } ?>
      
      <script>
   
   function processMakeOffer(){	 jQuery(".extra-modal-wrap").fadeIn(400);} 
   
   
   
function BuyNowOffer(){

if(confirm("<?php echo __("Are you sure?","premiumpress"); ?>"))
		{
		
	jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            single_action: "single_offer_make",
			pid: <?php echo $post->ID; ?>,
			aid: <?php echo $post->post_author; ?>,
			skip_to_buy: 1,
			 
        },
        success: function(response) {
 
			if(response.status == "ok"){
			 	 
				window.location.href='<?php echo _ppt(array('links','myaccount')); ?>?showtab=offers&showoid='+response.oid;	
				  
  		 	
			}else{			
				console.log("Error trying to add.");			
			}			
        },
        error: function(e) {
            console.log(e)
        }
    });
		
		}
		else
		{
		 
			e.preventDefault();
		}
}

   
   
   </script>
      <!--msg model -->
      <div class="extra-modal-wrap shadow hidepage" style="display:none;">
        <div class="extra-modal-wrap-overlay"></div>
        <div class="extra-modal-item">
          <div class="extra-modal-container">
            <div class="card-body">
              <?php _ppt_template( 'framework/design/singlenew/blocks/sidebar-ct-offer' );  ?>
            </div>
            <div class="card-footer text-center">
              <button type="button" onclick="jQuery('.extra-modal-wrap').fadeOut(400);" class="btn prev btn-system shadow-sm btn-xl"><?php echo __("Close Window","premiumpress"); ?></button>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
    
 
 
  </div>
  <div class="col-md-6 mb-4 mb-md-0">
  
  
   <?php if(_ppt(array('user','account_messages')) == 1 && get_post_meta($post->ID, "status", true ) != 1 ){ ?>
      
      <a <?php echo $CORE->USER("get_message_link", $post->post_author); ?> class="btn prev btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 mb-3"><i class="fal fa-paper-plane mr-2 text-primary"></i> <?php echo __("Message","premiumpress") ?></a>
    <?php } ?>

  </div>
  </div> 

<?php  } ?>
   
     
   
      </div>

 
 </div>
    
