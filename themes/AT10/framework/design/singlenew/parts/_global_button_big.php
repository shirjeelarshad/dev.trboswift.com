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

switch(THEME_KEY){

case "sp": {
?>

 
     <a href="javascript:void(0)" onclick="processCart();"  class="btn btn-primary shadow-sm btn-xl btn-icon icon-before mt-2 mb-3 prev btn-block ">
     <i class="fal fa-shopping-basket mr-2"></i> <?php echo __("Add To Cart","premiumpress") ?>
     </a>
     
   
     
<script>   
   function processCart(){	 jQuery(".extra-modal-wrap").fadeIn(400);} 
</script>
      <!--msg model -->
      <div class="extra-modal-wrap shadow hidepage" style="display:none;">
        <div class="extra-modal-wrap-overlay"></div>
        <div class="extra-modal-item">
          <div class="extra-modal-container">
            <div class="card-body">
             
             <?php
			 
			    $GLOBALS['inlineBtn'] = 1;
   _ppt_template( 'framework/design/singlenew/blocks/sidebar-sp-buttons' );  
			 
			 ?>
             
            </div>
            <div class="card-footer text-center">
              <button type="button" onclick="jQuery('.extra-modal-wrap').fadeOut(400);" class="btn btn-system shadow-sm btn-xl"><?php echo __("Close Window","premiumpress"); ?></button>
            </div>
          </div>
        </div>
      </div>
     
<?php } break;

 

case "mj": { ?>


      <a href="javascript:void(0)"  <?php if(!$userdata->ID){ ?>onclick="processLogin(1,0);"<?php } ?>
          
		  <?php if($userdata->ID == $post->post_author){ ?>onclick="alert('<?php echo __("You cannot buy on your own items.","premiumpress"); ?>');"<?php }else{ ?>onclick="processMakeOffer1()"<?php } ?>  class="btn btn-primary shadow-sm btn-xl btn-icon icon-before mt-2 mb-3 prev btn-block ">
          
            <i class="fal fa-shopping-basket mr-2"></i> <?php echo __("Buy Now","premiumpress"); ?>
          
          
          </a>
    
     
      <?php if(in_array(_ppt(array('user','favs')), array("","1")) ){ ?>
      <div class="link-dark">
      <?php if(!$userdata->ID){ ?>
      <a href="javascript:void(0);" onclick="processLogin();" class="small mt-2"> <i class="fal fa-heart text-dark"></i>  <?php echo __("Add to favorites","premiumpress") ?></a>
      <?php }else{ ?>
      <?php echo do_shortcode('[FAVS class="small mt-2" icon_name="class="fal fa-heart text-dark" text=1 icon=1]'); ?>
      <?php } ?>
       </div>
      <?php } ?>
      
      
            
      <script>
	  
	 
   
   function processMakeOffer1(){	 jQuery(".extra-modal-wrap1").fadeIn(400);}   
   
   </script>
      <!--msg model -->
      <div class="extra-modal-wrap1 shadow hidepage text-left" style="display:none;">
        <div class="extra-modal-wrap1-overlay"></div>
        <div class="extra-modal-item">
          <div class="extra-modal-container">
            <div class="card-body">
              <?php _ppt_template( 'framework/design/singlenew/blocks/sidebar-mj' );  ?>
            </div>
            <div class="card-footer text-center">
              <button type="button" onclick="jQuery('.extra-modal-wrap1').fadeOut(400);" class="btn btn-system shadow-sm btn-xl"><?php echo __("Close Window","premiumpress"); ?></button>
            </div>
          </div>
        </div>
      </div>
      

<?php } break;

case "es":
case "da": {

?>

 
      <a <?php echo $CORE->USER("get_message_link", $post->post_author); ?> class="btn btn-primary shadow-sm btn-xl btn-icon icon-before mt-2 mb-3 prev btn-block "><i class="fal fa-comments-alt mr-2"></i> <?php echo __("Message Me","premiumpress") ?></a>
    
     
      <?php if(in_array(_ppt(array('user','favs')), array("","1")) ){ ?>
      <div class="link-dark">
      <?php if(!$userdata->ID){ ?>
      <a href="javascript:void(0);" onclick="processLogin();" class="small mt-2"> <i class="fal fa-heart text-dark"></i>  <?php echo __("Add to favorites","premiumpress") ?></a>
      <?php }else{ ?>
      <?php echo do_shortcode('[FAVS class="small mt-2" icon_name="class="fal fa-heart text-dark" text=1 icon=1]'); ?>
      <?php } ?>
       </div>
      <?php } ?>

<?php 


} break;

case "jb":
case "rt":
case "ct":
case "dl": {
?>

 

      <?php if(in_array(_ppt(array('design','display_offers')), array("","1")) && get_post_meta($post->ID, "status", true )  !=1 ){ ?>
      
      <?php if(get_post_meta($post->ID,"offertype", true) == 1){ ?>
      
      <a href="javascript:void(0);" <?php if($userdata->ID){ ?>onclick="BuyNowOffer();"<?php }else{ ?>onclick="processLogin();"<?php } ?>  class="btn btn-block btn-primary shadow-sm btn-xl btn-icon icon-before mt-2 mb-3 prev btn-block ">
      <i class="fal fa-box-usd "></i> <?php echo __("Buy Now","premiumpress"); ?> </a>
      
      <?php }else{ ?>
      
      <a href="javascript:void(0);" onclick="processMakeOffer();" class="btn btn-block btn-primary shadow-sm btn-xl btn-icon icon-before mt-2 mb-3">
      
      <?php if(THEME_KEY == "jb"){ ?>
      <i class="fal fa-briefcase "></i>
      <?php }else{ ?>
      <i class="fal fa-comments-alt-dollar"></i> 
	  
	  <?php } ?>
	  
	  <?php echo $CORE->LAYOUT("captions","offerbtn"); ?>
      
      
      </a>
      
      <?php } ?>
      
           <?php if(in_array(_ppt(array('user','favs')), array("","1")) ){ ?>
      <div class="link-dark">
      <?php if(!$userdata->ID){ ?>
      <a href="javascript:void(0);" onclick="processLogin();" class="small mt-2"> <i class="fal fa-heart text-dark"></i>  <?php echo __("Add to favorites","premiumpress") ?></a>
      <?php }else{ ?>
      <?php echo do_shortcode('[FAVS class="small mt-2" icon_name="class="fal fa-heart text-dark" text=1 icon=1]'); ?>
      <?php } ?>
       </div>
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
      <div class="extra-modal-wrap shadow hidepage text-left" style="display:none;">
        <div class="extra-modal-wrap-overlay"></div>
        <div class="extra-modal-item">
          <div class="extra-modal-container">
            <div class="card-body">
              <?php 
			  
			  
			  if(THEME_KEY == "jb"){
			  
			  _ppt_template( 'framework/design/singlenew/blocks/sidebar-jb-offer' );
			  
			  }elseif(THEME_KEY == "rt"){
			  
			  _ppt_template( 'framework/design/singlenew/blocks/sidebar-rt-offer' );
			  
			  }else{
			  _ppt_template( 'framework/design/singlenew/blocks/sidebar-ct-offer' );
			  }
			  
			  
			    ?>
            </div>
            <div class="card-footer text-center">
              <button type="button" onclick="jQuery('.extra-modal-wrap').fadeOut(400);" class="btn btn-system shadow-sm btn-xl"><?php echo __("Close Window","premiumpress"); ?></button>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>

 
     
 

<?php

} break;


case "at": {
?>

 
     <a href="javascript:void(0)" onclick="processCart();"  class="btn btn-primary shadow-sm btn-xl btn-icon icon-before mt-2 mb-3 prev btn-block ">
     <i class="fal fa-gavel mr-n2"></i> <?php echo __("Bid Now","premiumpress") ?>
     </a>
     
     
      <?php if(in_array(_ppt(array('user','favs')), array("","1")) ){ ?>
      <div class="link-dark">
      <?php if(!$userdata->ID){ ?>
      <a href="javascript:void(0);" onclick="processLogin();" class="small mt-2"> <i class="fal fa-heart text-dark"></i>  <?php echo __("Add to favorites","premiumpress") ?></a>
      <?php }else{ ?>
      
      <?php echo do_shortcode('[FAVS class="btn btn-dark  ml-2 mt-2 mb-3 btn-xl" icon_name="class="fal fa-heart text-dark"  icon=1]'); ?>
      <?php } ?>
       </div>
      <?php } ?>
     
     
<script>   
   function processCart(){	 jQuery(".extra-modal-wrap").fadeIn(400);} 
</script>
      <!--msg model -->
      <div class="extra-modal-wrap shadow hidepage text-left" style="display:none;">
        <div class="extra-modal-wrap-overlay"></div>
        <div class="extra-modal-item">
          <div class="extra-modal-container">
            <div class="card-body">
             
<?php
$userAgent = $_SERVER['HTTP_USER_AGENT'];

if (strpos($userAgent, 'Mobile') !== false || strpos($userAgent, 'Tablet') !== false || strpos($userAgent, 'Android') !== false) {
    // Show X content for smaller displays
    echo "X content";
} else {
      $GLOBALS['inlineBtn'] = 1;
  _ppt_template( 'framework/design/singlenew/parts/_auction_buy' ); 
}
?>
             
            </div>
            <div class="card-footer text-center">
              <button type="button" onclick="jQuery('.extra-modal-wrap').fadeOut(400);" class="btn btn-system shadow-sm btn-xl"><?php echo __("Close Window","premiumpress"); ?></button>
            </div>
          </div>
        </div>
      </div>
     
<?php } break;


case "vt":
case "dt": { ?>


 <?php if(in_array(_ppt(array('design','display_comments')), array("","1")) ){ ?>
<a  href="javascript:void(0)"  <?php if(!$userdata->ID){ ?> onclick="processLogin();" <?php }else{ ?>onclick="jQuery('#faq-tab').trigger('click');processCommentPop();"<?php } ?>  class="btn btn-primary shadow-sm btn-xl btn-icon icon-before mt-2 mb-3 prev btn-block ">
     <i class="fal fa-comments"></i> <?php echo __("Write Review","premiumpress") ?>
     </a>
     <?php }else{ ?>
     
        <a <?php echo $CORE->USER("get_message_link", $post->post_author); ?> class="btn btn-primary shadow-sm btn-xl btn-icon icon-before mt-2 mb-3"><i class="fal fa-paper-plane mr-2"></i> <?php echo __("Send Message","premiumpress") ?></a>
    
     <?php } ?>
     
      <?php if(in_array(_ppt(array('user','favs')), array("","1")) ){ ?>
      <div class="link-dark">
      <?php if(!$userdata->ID){ ?>
      <a href="javascript:void(0);" onclick="processLogin();" class="small mt-2"> <i class="fal fa-heart text-dark"></i>  <?php echo __("Add to favorites","premiumpress") ?></a>
      <?php }else{ ?>
      <?php echo do_shortcode('[FAVS class="small mt-2" icon_name="class="fal fa-heart text-dark" text=1 icon=1]'); ?>
      <?php } ?>
       </div>
      <?php } ?>

<?php } break;


case "cm": { ?>


<?php } break; ?>

<?php } // end switch ?>
   
 