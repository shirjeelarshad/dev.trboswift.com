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

   // GET PRICE
   $price = get_post_meta($post->ID, 'price', true);
   $price2 = get_post_meta($post->ID, 'price-1', true);
   
   // GET THE CURRENT SALES AMOUNT
   $sales_count = get_post_meta($post->ID, 'sales_count', true);
   $purchase_type = get_post_meta($post->ID, 'purchase_type', true);   
 
   // LISTING STATUS
   $status = get_post_meta($post->ID, 'status', true);
   
   
	// TURN OFF DAYS
	$showdays = true;
	$el = _ppt(array('design', "element_days"));
	if($el == 0){
	$showdays = false;
	}

?>

<div class="sidebar-fixed-content">
  <div class="card card-listing">
    <div id="ajax_payment_job_form"></div>
    <div class="tabs" id="widget-buybox">
      <div class="tab-button-outer">
        <?php if(get_post_meta($post->ID, 'price-1', true) > 0){ ?>
        <ul id="tab-button" class="bg-primary">
          <li data-id="price1" class="is-active"><a href="#tab01"><?php echo __("Standard","premiumpress"); ?></a></li>
          <li data-id="price2"><a href="#tab02"><?php echo __("Premium","premiumpress"); ?></a></li>
        </ul>
        <?php } ?>
      </div>
      <div id="tab01" class="tab-contents p-4">
        <div class="pt-2"> <i class="fal fa-shopping-basket float-right mt-1 fa-3x opacity-5"></i>
          <h6><?php echo __("Standard Plan","premiumpress") ?></h6>
          <div class="price_total h2 text-success <?php echo $CORE->GEO("price_formatting",array()); ?>"><i class="fal fa-spinner fa-spin"></i></div>
          <?php /*
          <div class="mb-3 text-primary mb-3 mt-1"><?php echo get_post_meta($post->ID,'gig',true); ?></div>
          
		  */ ?>
          <?php
		  // TURN OFF DAYS		 
		  if($showdays){
		  ?>
          <p><i class="fal fa-clock"></i> <?php echo get_post_meta($post->ID,'days',true); ?> <?php echo __("day delivery","premiumpress") ?></p>
          <?php } ?>
          <?php if(strlen(get_post_meta($post->ID,'desc',true)) > 1){ ?>
          <div class="small"> <?php echo get_post_meta($post->ID,'desc',true); ?> </div>
          <?php } ?>
        </div>
      </div>
      <?php if(get_post_meta($post->ID, 'price-1', true) > 0){ ?>
      <div id="tab02" class="tab-contents p-4">
        <div class="pt-2"> <i class="fal fa-star float-right mt-1 fa-3x opacity-5"></i>
          <h6><?php echo __("Premium Plan","premiumpress") ?></h6>
          <div class="price_total h2 text-success <?php echo $CORE->GEO("price_formatting",array()); ?>"><i class="fal fa-spinner fa-spin"></i></div>
          <?php /*
          <div class="mb-3 text-primary mb-3 mt-1"><?php echo get_post_meta($post->ID,'gig-1',true); ?></div>
          */ ?>
          <?php
		  // TURN OFF DAYS		 
		  if($showdays){
		  ?>
          <p><i class="fal fa-clock"></i> <?php echo get_post_meta($post->ID,'days-1',true); ?> <?php echo __("day delivery","premiumpress") ?></p>
          <?php } ?>
          <?php if(strlen(get_post_meta($post->ID,'desc-1',true)) > 1){ ?>
          <div class="small"> <?php echo get_post_meta($post->ID,'desc-1',true); ?> </div>
          <?php } ?>
        </div>
      </div>
      <?php } ?>
      <div class="card-body py-0">
        <?php if($status == 1){ ?>
        <button class="btn btn-light btn-lg btn-block mt-4 border"><?php echo __("Sold Out","premiumpress"); ?></button>
        <?php }else{ ?>
         
        
        <div class="row">
        <div class="col-12 <?php if(isset($GLOBALS['global_design2']) || isset($GLOBALS['global_design3'])){ ?>col-md-6<?php } ?>">
        
        <button type="button"  
		  <?php if(!$userdata->ID){ ?>href="javascript:void(0)" onclick="processLogin(1,0);"<?php } ?>
          
		  <?php if($userdata->ID == $post->post_author){ ?>onclick="alert('<?php echo __("You cannot buy on your own items.","premiumpress"); ?>');"<?php } ?> class="<?php if($userdata->ID && $userdata->ID != $post->post_author){ ?>btn-buynow<?php } ?> btn btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 mb-3">
        <i class="fal fa-shopping-basket mr-2 text-primary"></i> <?php echo __("Buy Now","premiumpress"); ?>
        </button>
        
        </div>
          <?php if(isset($GLOBALS['global_design2']) || isset($GLOBALS['global_design3'])){ ?>
      
        <div class="col-md-6">
        
        
        
        <a href="javascript:void(0);" <?php if(!$userdata->ID){ ?>onclick="processLogin();"<?php }else{ ?>onclick="processMakeOffer();"<?php } ?> class="btn btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 mb-3"> <i class="fal fa-comments-alt-dollar text-primary mr-2"></i> <span><?php echo __("Make Offer","premiumpress"); ?></span></a>
        
    
        
        </div>
         <?php } ?>
        </div>
        
        
        
        <?php $current_data = get_post_meta($post->ID,'customextras', true); 
            if(is_array($current_data) && !empty($current_data) && $current_data['name'][0] != "" ){ ?>
        <a href="javascript:void(0);" onclick="jQuery('#job_addons').toggle();jQuery('#bottomcard').toggle();" class="btn btn-system btn-block "><?php echo __("view add-ons","premiumpress") ?></a>
        <div id="job_addons" class="clearfix" style="display:none;">
          <input type="hidden" value="" id="backcustom">
          <ul id="customextraslist" class="list-group mt-4">
            <?php  $i=0; 
			
            	foreach($current_data['name'] as $key => $data){ 
            	
            		if($current_data['name'][$i] !="" && is_numeric($current_data['price'][$i]) ){
            	  
            			echo '<li class="list-group-item text-left rounded-0" onclick="setactiveaddon(this); AdjustPrice()" style="cursor:pointer;" data-id="'.$i.'" data-price="'.$current_data['price'][$i].'"> 
            		 
            			  
            			<strong>'.$current_data['name'][$i].'</strong>
            			 
						 <span class="badge badge-success badge-pill '.$CORE->GEO("price_formatting",array()).'">+ '.$current_data['price'][$i].'</span>
            			
						 
            			<div class="small mt-1">'.trim($current_data['value'][$i]).'</div>
            			   
            			</li>';
            	
            		} 
            
            	$i++; 
            	}
            
			?>
          </ul>
          <div onclick="clearaddon(); AdjustPrice()" style="cursor:pointer;" class="my-2 text-right small clearaddonbutton"> <i class="fa fa-close"></i> <?php echo __("Remove Extras","premiumpress"); ?></div>
        </div>
        <?php } ?>
        <?php } ?>
      </div>
    </div>
    <input id="totalpricedue" value="0" type="hidden" />
    <textarea id="hh" style="display:none;"><?php
   $cartdata = array(
   	"uid" => $userdata->ID, 
   	"amount" => $price, 
   	"order_id" => "MJ-".$post->ID."-".$userdata->ID."-1-0-".rand(1, 1000000),
   	"description" => __("Payment for Job ID","premiumpress")." #".$post->ID,	
   	"recurring" => 0,	
   	"credit" => 1,						
   );
    
   $jj = $CORE->order_encode($cartdata); echo $jj; ?>
</textarea>
    <script>

   
jQuery(document).ready(function(){ 
   
   AdjustPrice();
   
   jQuery('#backcustom').val(jQuery("#widget-buybox .paymentcustomfield").val());
   
   
   if(jQuery('.clearaddonbutton').length == 0){
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
	} 
	
	jQuery('.price_total').html("<?php echo hook_price($price); ?>");
   
});




// MOBILE MENU	
jQuery(".btn-buynow").click(function(e) {

    e.preventDefault();
	
	// PROCESS AND GET ORDER ID
 	neworderid = AdjustPrice();
 
   	// RECALCULATE PRICE
   	jQuery.ajax({
            type: "POST",
            url: '<?php echo home_url(); ?>/',		
      		data: {
            action: "load_new_payment_form_recalculate",
   			details: jQuery('#hh').val(),
   			amount: jQuery('#totalpricedue').val(),
   			orderid: neworderid,
    },
     success: function(response) {
			   
      			jQuery('#hh').val(response);
			 	
				    // MAKE THE ORDER HAPPEN
				  jQuery.ajax({
						type: "POST",
						url: '<?php echo home_url(); ?>/',		
						data: {
							action: "load_new_payment_form",
							details: jQuery('#hh').val(),
							//smallform: 1,
						},
						success: function(response) {
						
							jQuery(".payment-modal-wrap").fadeIn(400);
							
							jQuery(".payment-modal-container h3").html(jQuery('.tab-contents .price_total').html());							
							
							jQuery('#ajax-payment-form').html(response);							
								 
						},
						error: function(e) {
							console.log(e)
						}
					 });
				
						
              },
              error: function(e) {
                  console.log(e)
              }
          });
   
	  
	  

});	




function AdjustPrice(){ 
	
	var price = 0, price1 = "<?php echo $price; ?>", price2 = "<?php echo $price2; ?>";
	 
  	// GET FIXED BASE PRICE
	var t1 = jQuery('#tab-button').find('.is-active').data('id');
	if(t1 == "price2"){		
		price += parseFloat(price2); baseid = 2;	
	}else{	
		price += parseFloat(price1); baseid = 1;
	}
	 
	// GET ACTOVE ADDON PRICE
	var addonprice = jQuery('#customextraslist').find('.active').data('price');
	if(!isNaN(addonprice)) {
		price = parseFloat(price) +  parseFloat(addonprice);
			// MAKE ADD-ON ID
			var addonid = jQuery('#customextraslist').find('.active').data('id');
		//console.log("addon price: "+addonprice);
	}else{
	addonprice = 0;
	addonid = "na";
	}
	
	// UPDATE PAYMENT DATA
   	jQuery('#paypalAmount').val(price);
   	jQuery('#credit_total').val(price);
   	jQuery('#admin_test_total').val(price);

	// MAKE DISPLAY	 
	jQuery('.price_total').html(price);
	
	// UPDATE PRICE DISPLAY
	UpdatePrices(); 
   
	// SAVE NEW PRICE
  	jQuery('#totalpricedue').val(price);
 
	
	// BUILD THE ORDER ID
	return "MJ-<?php echo $post->ID; ?>-<?php echo $userdata->ID; ?>-" + baseid + "-"+ addonid+'-'+Math.floor((Math.random() * 10000) + 1);
	
}


 

jQuery(function() {

        var $tabButtonItem = jQuery('#tab-button li'), $tabSelect = jQuery('#tab-select'), $tabContents = jQuery('.tab-contents'), activeClass = 'is-active';
      
        $tabButtonItem.first().addClass(activeClass);
        $tabContents.not(':first').hide();
      
        $tabButtonItem.find('a').on('click', function(e) {
		
          var target = jQuery(this).attr('href');
      		
		  // REMOVE EXISTING CLASS
          $tabButtonItem.removeClass(activeClass);
		  
		  // SET ACITVE CLASS
          jQuery(this).parent().addClass(activeClass);
		  
          $tabSelect.val(target);
		  
		  // REMOVE ADDONS
		  jQuery('#customextraslist li').removeClass('active');	
		  
		  // READJUST PRICES
		  AdjustPrice();
		  
          $tabContents.hide();
          jQuery(target).show();
          e.preventDefault(); 
 
      });
});

 
function setactiveaddon(a){

	// SET ACTIVE ADD-ON DISPLAY 
	jQuery('#customextraslist li').removeClass('active');
   	jQuery(a).addClass('active');
}
function clearaddon(a){

	// CLEAR ACTIVE ADDONS
	jQuery('#customextraslist li').removeClass('active');
 	
	// NOW SET BASE
	AdjustPrice();
}



     
function ShowMakeOffer(on){

	jQuery('#listing-page-spinner').html('<div class="text-center mt-5 pt-5"><i class="fa fa-spinner fa-4x text-primary fa-spin"></i></div>');
	
	jQuery('#listing-page-wrapper').hide();
	jQuery('.hero-single').hide();
	if(on == 0){
	jQuery('#makeoffer').hide();
	}

	setTimeout(function(){ 
		
		if(on == 1){		  		
		jQuery('#makeoffer').show();
		}else{		
		jQuery('#listing-page-wrapper').show();
		jQuery('.hero-single').show();
		jQuery(window).trigger('resize'); 
		}
		
		jQuery('#listing-page-spinner').html('');
				
	},1500);

}
 
</script>



    <div class="card-body pt-0" id="bottomcard">
     
    <?php if(!isset($GLOBALS['global_design2']) && !isset($GLOBALS['global_design3'])){ ?>

      <div class="divider-or"><span class="mt-n1"><?php echo __("Or","premiumpress") ?></span></div>
      
      
       <?php } ?>    
       
       
       
       
        <?php if(in_array(_ppt(array('design','display_offerbtn')), array("","1")) ){ ?>
        
        
          <?php if(!isset($GLOBALS['global_design2']) && !isset($GLOBALS['global_design3'])){ ?>
        
        <a href="javascript:void(0);" <?php if(!$userdata->ID){ ?>onclick="processLogin();"<?php }else{ ?>onclick="processMakeOffer();"<?php } ?> class="btn btn-block btn-light mt-2"> <i class="fal fa-comments-alt-dollar text-primary mr-2"></i> <span><?php echo __("Make Offer","premiumpress"); ?></span></a>
        
        <?php } ?>
        
        
          <script>
   
function processMakeOffer(){	 jQuery(".extra-modal-wrap").fadeIn(400);}  
   
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
      
      
  
      
      
      
      
      
<?php if(!isset($GLOBALS['global_design2']) && !isset($GLOBALS['global_design3'])){ ?>
      
      
      
      
      <?php if(in_array(_ppt(array('user','account_messages')), array("","1")) ){ ?>
      <?php if(_ppt(array('lst','adminonly')) != 1){ ?>
      <a <?php echo $CORE->USER("get_message_link", $post->post_author); ?> class="btn btn-block btn-light mt-2"><i class="fal fa-paper-plane mr-2 text-primary"></i> <?php echo __("Message","premiumpress") ?></a>
      <?php }else{ ?>
      <?php _ppt_template( 'framework/design/singlenew/parts/_contactform' );  ?>
      <?php } ?>
      <?php } ?>
      
      <?php if(in_array(_ppt(array('user','favs')), array("","1")) ){ ?>
      <?php if(!$userdata->ID){ ?>
      <a href="javascript:void(0);" onclick="processLogin();" class="btn btn-block btn-light mt-2"> <?php echo __("Add Favorites","premiumpress") ?></a>
      <?php }else{ ?>
      <?php echo do_shortcode('[FAVS class="btn btn-block btn-light mt-2" text=1 icon=1 icon_name="fal fa-heart"]'); ?>
      <?php } ?>
      <?php } ?>
      
      
      
      <?php if(_ppt(array('user','friends')) == 1){ ?> 
    <?php echo do_shortcode('[SUBSCRIBE class="btn btn-block btn-light mt-2" count=0 text=1 uid="'.$post->post_author.'"]'); ?>
    <?php } ?>


<?php } ?>
    
      
    </div>
  </div>
</div>
<?php if(!isset($GLOBALS['global_design2']) && !isset($GLOBALS['global_design3'])){ ?>
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
<?php } ?>
