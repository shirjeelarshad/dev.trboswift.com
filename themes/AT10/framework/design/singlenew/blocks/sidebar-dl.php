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

global $CORE, $userdata, $post;

   // GET SHIPPING OST
   $price_shipping = get_post_meta($post->ID,'price_shipping',true);
   if($price_shipping == "" || !is_numeric($price_shipping)){$price_shipping = 0; } 

?>

<div class="sidebar-fixed-content">
  <div class="card card-listing">
    <div class="card-body">
      <div class="text-center py-4 mt-2 bg-light mb-4">
        <div class="h1 text-700 text-shadow-white price-value <?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo do_shortcode('[PRICE]'); ?></div>
        <div class="text-muted small mb-n2 text-center opacity-5"><?php echo __("asking price","premiumpress"); ?></div>
      </div>
      <?php if(get_post_meta($post->ID, "status", true ) == 1){ ?>
      <a href="javascript:void(0);" class="btn btn-block btn-dark py-4  text-uppercase font-weight-bold"><?php echo __("item sold","premiumpress"); ?></a>
      <?php }else{ ?>
      <?php /*** SHIPPING */ ?>
      <?php if($price_shipping > 0){ ?>
      <div class="small mb-4 mt-n1"> <i class="fal fa-box mr-2"></i> <?php echo __("Shipping cost","premiumpress"); ?>: <span class="<?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo hook_price(array($price_shipping,0)) ; ?></span> </div>
      <?php } ?>
      <?php if(_ppt(array('user','account_messages')) == 1){ ?>
      <?php if(_ppt(array('lst','adminonly')) != 1){ ?>
      <a <?php echo $CORE->USER("get_message_link", $post->post_author); ?> class="btn btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 mb-3"><i class="fal fa-paper-plane mr-2 text-primary"></i> <?php echo __("Message","premiumpress") ?></a>
      <?php }else{ ?>
      <?php _ppt_template( 'framework/design/singlenew/parts/_contactform' );  ?>
      <?php } ?>
      <?php } ?>
    
    
      <?php if(in_array(_ppt(array('design','display_offers')), array("","1")) ){ ?>
      <?php if(get_post_meta($post->ID,"offertype", true) == 1){ ?>
      <a href="javascript:void(0);" <?php if($userdata->ID){ ?>onclick="BuyNowOffer();"<?php }else{ ?>onclick="processLogin();"<?php } ?>  class="btn btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 mb-3"><i class="fal fa-box-usd  text-primary"></i> <?php echo __("Buy Now","premiumpress"); ?> </a>
      <?php }else{ ?>
      <a href="javascript:void(0);" onclick="processMakeOffer();" class="btn btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 mb-3"> <i class="fal fa-comments-alt-dollar text-primary"></i> <span><?php echo $CORE->LAYOUT("captions","offerbtn"); ?></span></a>
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
              <button type="button" onclick="jQuery('.extra-modal-wrap').fadeOut(400);" class="btn btn-system shadow-sm btn-xl"><?php echo __("Close Window","premiumpress"); ?></button>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <?php } ?>
      <?php   $data = $CORE->USER("feedback_score", $post->post_author);  ?>
      
      <?php if(in_array(_ppt(array('user','favs')), array("","1")) ){ ?>
      <div class="divider-or"><span class="mt-n1"><?php echo __("Or","premiumpress") ?></span></div>     
      <?php if(!$userdata->ID){ ?>
      <a href="javascript:void(0);" onclick="processLogin();" class="btn btn-block btn-light mt-2"> <?php echo __("Add to favorites","premiumpress") ?></a>
      <?php }else{ ?>
      <?php echo do_shortcode('[FAVS class="btn btn-light  btn-block mt-3" text=1 icon=0]'); ?>
      <?php } ?>
      <?php } ?>
      
      
      
    </div>
  </div>
</div>
<script>

 
jQuery(document).ready(function(){ 
   
  
		jQuery(".sidebar-fixed-content").scrollToFixed({
			minWidth: 1064,
			zIndex: 12,
			marginTop: 100,
			removeOffsets: true,
			limit: function () {
				var a = jQuery(".limit-box").offset().top - jQuery(".sidebar-fixed-content").outerHeight(true) - 48;
				return a;
			}
		});  
   
});


</script>
