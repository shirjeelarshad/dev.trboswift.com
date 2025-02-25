<?php

global $userdata, $CORE;

// ORDERS
$args = array(
      	'post_type' 		=> 'listing_type',
      	'posts_per_page' 	=> 100,
        'paged' 			=> 1,
		'author'		=> $userdata->ID	 ,
		
		'post_status' 			=> array('publish','pending','pending_approval','payment','expired'), //,'trash'
 );
 
 
$wp_query1 = new WP_Query($args); 
$lists = $wpdb->get_results($wp_query1->request, OBJECT);
 
 
?>




<select class="form-control w-100 show-mobile hide-ipad hide-desktop mt-4 mb-4" onchange="showlistings(this.value);">

<option value="all"><?php echo __("All","premiumpress") ?></option>
<option value="publish"><?php echo __("Live","premiumpress"); ?>  </option>
<option value="pending"><?php echo  __("Pending","premiumpress"); ?>   </option>
<option value="expired"><?php echo __("Expired","premiumpress"); ?>   </option>

</select>

<div id="load_payment_relist_form"></div>
<div class="tabbable-panel mb-5 hide-mobile">


<!--<a href="<?php echo _ppt(array('links','add')); ?>" class="float-right btn btn-primary hide-mobile"><?php echo __("Add New","premiumpress") ?> </a>-->

  <div class="tabbable-line ">
    <ul class="nav nav-tabs clearfix">
    
     <li class="nav-item"> <a href="javascript:void(0);" onclick="showlistings('all');" class="nav-link py-3 text-black active" data-toggle="tab"  role="tab">
     <span class="px-lg-2 "><?php echo __("All","premiumpress") ?> </span> <span class="badge badge-pill" id="count-status-all">0</span> </a> 
     </li>
      
      <li class="nav-item"> <a href="javascript:void(0);" onclick="showlistings('publish');" class="nav-link py-3 text-black" data-toggle="tab"  role="tab">
      <span class="px-lg-2 "><?php echo __("Live","premiumpress") ?> </span> <span class="badge badge-pill" id="count-status-publish">0</span> </a>
      </li>
      
      
      <li class="nav-item"> <a href="javascript:void(0);" onclick="showlistings('pending');" class="nav-link py-3 text-black " data-toggle="tab"  role="tab"> <span class="px-lg-2 "> <?php echo __("Pending","premiumpress") ?></span> <span class="badge   badge-pill" id="count-status-pending">0</span> </a> </li>
      <li class="nav-item"> <a href="javascript:void(0);" onclick="showlistings('expired');" class="nav-link py-3 text-black " data-toggle="tab"  role="tab"> <span class="px-lg-2 "> <?php echo __("Expired","premiumpress") ?></span> <span class="badge badge-pill" id="count-status-expired">0</span> </a> </li>
      

      
    </ul>
  </div>
</div>
<script>
function showlistings(type){
								
					jQuery('.status-publish').hide();
					jQuery('.status-pending').hide();
					jQuery('.status-expired').hide();
					 
					jQuery('.status-' +type).show();
					
					if(type == "all"){
					
					jQuery('.status-publish').show();
					jQuery('.status-pending').show();
					jQuery('.status-expired').show();
					}
				
				}
jQuery(document).ready(function(){  

	jQuery('#count-status-publish, .count-status-publish').html( jQuery('.status-publish').length); 
	jQuery('#count-status-pending, .count-status-pending').html( jQuery('.status-pending').length); 
	jQuery('#count-status-expired, .count-status-expired').html( jQuery('.status-expired').length); 
	
	
	var allc = parseFloat(jQuery('.status-publish').length) + parseFloat(jQuery('.status-pending').length) + parseFloat(jQuery('.status-expired').length);	
	 
	jQuery('#count-status-all, .count-status-all').html( allc ); 

	<?php if(in_array(THEME_KEY, array("mj","at","ct","dl"))){ ?>
	
	 
	if(allc > 0){
	
	
	
		jQuery(".menu-alert-listings").html(allc).show();			
		jQuery("#icons-count-all-my-offers").show();		
		jQuery("#buyselliconbox h3").html("<?php echo __("Buy/Sell","premiumpress"); ?>");		
		jQuery("#icons-count-all-offers .tt").html("<?php echo __("buying","premiumpress"); ?>");
		jQuery("#icons-count-all-offers").addClass('badge-primary').removeClass('badge-light');
	
	}
 
	<?php } ?>
	
});
</script>
<?php if(is_array($lists) && !empty($lists)){ foreach($lists as $list){  


// GET DEFAULTS
$ss = get_post_status($list->ID);
if(THEME_KEY == "at"){
	if(get_post_meta($list->ID,'listing_expiry_date',true) == ""){
	$ss = "expired";
	}
}

// GET STATUS
$listingstatus = $CORE->PACKAGE("get_status",  $list->ID);

$payment_due = 0;
if($listingstatus['key'] == "payment"){
	$p = $CORE->PACKAGE("get_payment_due",  $list->ID);
	$payment_due += $p['total'];
}
 
?>
<div class="border-bottom  shadow-sm mb-4 status-<?php if(in_array($ss, array("pending","payment","pending_approval") )){ echo "pending"; }else{ echo $ss; } ?> p-3 listingid-<?php echo $list->ID; ?>">
  <div class="row y-middle">
    <div class="col-6 col-md-6 col-lg-5">
      <div class="float-left img-list mr-3"> <?php echo str_replace("data-","",do_shortcode('[IMAGE pid="'.$list->ID.'"]'));  ?> </div>
      <div class="ellipsis" style="max-width:200px;">
       
        <?php if($ss != "trash"){ ?>
        <a href="<?php echo get_permalink($list->ID); ?>" class="text-black font-weight-bold" target="_blank"> <?php echo get_the_title($list->ID); ?></a>
        <?php }else{ ?>
        <?php echo get_the_title($list->ID); ?>
        <?php } ?>
        
      </div>
      
      <div class="small opacity-5"><?php echo do_shortcode('[HITS pid="'.$list->ID.'"]'); ?> <?php echo __("user views","premiumpress") ?> </div>
      
      
      
    </div>
    <div class="col-2 col-lg-1 col-lg-3 hide-mobile text-center">
    
    
     <?php echo $CORE->PACKAGE("get_status_formatted",  $list->ID); ?> 
      
    
       
    </div>
    
    
    <div class="col-2 hide-ipad hide-mobile">
    
      
      
      
       
       <?php   if(THEME_KEY == "at"){ global $CORE_AUCTION; ?>
	 
	 	
        <div class="font-weight-bold">
        <?php echo $CORE_AUCTION->account_status_show($list->ID); ?>
	    </div>
      
      
     
	 
     
     <?php }?>
     
     
      
    
       
    </div>
    
     
    
    
    <div class="col-6 col-sm-3 col-lg-2">
    
    
<div class="dropdown">
  <button class="btn btn-outline-primary btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <?php echo __("Actions","premiumpress"); ?>
  </button>
  <div class="dropdown-menu btn-block" aria-labelledby="dropdownMenuButton">
   
     
     <?php if($payment_due > 0){ ?>      
    <a href="javascript:void(0);" onclick="SwitchPage('orders');" class="dropdown-item"> <i class="fal fa-wallet float-right" aria-hidden="true"></i> <?php echo __("Pay Now","premiumpress"); ?></a>
    
    <?php } ?>
     
     
    <?php if($ss != "trash"){ ?>
      <a href="<?php echo get_permalink($list->ID); ?>" target="_blank" class="dropdown-item"> <i class="fal fa-search float-right" aria-hidden="true"></i> <?php echo __("View","premiumpress"); ?></a>
    <?php } ?>
    

		<?php if($ss != "trash"){ ?>
        
        
		  <?php if(in_array($listingstatus['key'], array("expired")) && $payment_due == 0 ){ ?>
         
         <?php if( ( THEME_KEY == "at" && $CORE_AUCTION->account_can_repost($list->ID) == "1" ) || ( THEME_KEY != "at" ) ){ 
		 
		 ?>
         
         
          <!--<a  href="<?php echo _ppt(array('links','add')); ?>/?eid=<?php echo $list->ID; ?>&repost=1" class="dropdown-item"> <i class="fal fa-sync float-right" aria-hidden="true"></i>  <?php echo __("Repost","premiumpress"); ?> </a>-->
         
		 
		 <?php } ?>
         
          <?php }else{ 
		  
		  $ggl = _ppt(array('links','add'))."?eid=".$list->ID;
		  
		  if(_ppt(array('user','edit_listing_link')) == "2"){
			$ggl = get_permalink($list->ID);
			}
		  
		  ?>
          
          <!--<a href="<?php echo $ggl; ?>" target="_blank" class="dropdown-item"> <i class="fal fa-pencil float-right" aria-hidden="true"></i> <?php echo __("Edit","premiumpress"); ?> </a>-->
          
          
          
          <?php 	
		  
		  $canDelete = true;
		  if(THEME_KEY ==  "at" ){ 
		  
		  	// CHECK FOR BIDDING SO WE CAN DISABLE FIELDS
			$current_bidding_data = get_post_meta($list->ID,'current_bid_data',true); 
			if(is_array($current_bidding_data) && !empty($current_bidding_data) ){ $canDelete = false; }		  
		    
		  
		  } 
		  if($canDelete){
		  ?>
          
         
         <!--<a href="javascript:void(0);" onclick="ajax_delete_listing('<?php echo $list->ID; ?>');"  class="dropdown-item">-->
         <!--<i class="fal fa-trash float-right" aria-hidden="true"></i>-->
         <!--<?php echo __("Delete","premiumpress"); ?>-->
         <!--</a> -->
         
         <?php } ?>      
         
         
          
          <?php } ?>
          
          
      <?php } ?>
      
      

  </div>
</div>
    
    
    
    
    
    
    
    
    
    
      
    </div>
  </div>
</div>

<script>

   function ajax_delete_listing(id){
   
   if(confirm("<?php echo __("Are you sure?","premiumpress"); ?>")){
   
       jQuery.ajax({
           type: "POST",
           url: '<?php echo home_url(); ?>/',	
   		dataType: 'json',	
   		data: {
               action: "listing_delete",
   			pid: id,
           },
           success: function(response) {	
		   		
   			if(response.status == "ok"){	
   							
   				 	jQuery('.listingid-'+id).hide();	
     		 	
   			}
						
           },
           error: function(e) {
               console.log(e)
           }
       });
   }// end are you sure
   
   }
</script>
<?php } }else{ ?>
 
<div class="text-center mt-5"><i class="<?php echo $CORE->LAYOUT("captions","icon"); ?> fa-4x text-primary"></i></div>
<h4 class="text-center mt-4"><?php echo str_replace("%s", strtolower($CORE->LAYOUT("captions",2)), __("No %s found","premiumpress")); ?></h4>


<!--<p class="text-center text-muted mt-3"><?php echo str_replace("%s", strtolower($CORE->LAYOUT("captions",1)), __("Add a new %s to get started!","premiumpress")); ?></p>-->
<!--<div class="text-center">-->
<!--<a href="<?php echo _ppt(array('links','add')); ?>" class="btn btn-system btn-md"><?php echo __("Create New","premiumpress"); ?></a>-->
<!--</div>-->
 
<?php } ?>