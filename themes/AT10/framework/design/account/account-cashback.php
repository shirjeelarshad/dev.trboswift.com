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

	$f = get_user_meta($userdata->ID,'linktracking', true);
	if(!is_array($f)){
		$f = array();
	}
	 
	 
	
   // ORDERS
    $args = array(
      	'post_type' 		=> 'ppt_cashback',
      	'posts_per_page' 	=> 100,
        'paged' 			=> 1,
		
			'meta_query' => array( 
				'user_id'    => array(
					'key' 			=> 'cashback_userid',	
					'type' 			=> 'NUMERIC',
					'value' 		=> $userdata->ID,
					'compare' 		=> '=',								 					 			
				),					 	
      		), 
		 
			
      );
      $wp_query1 = new WP_Query($args); 
      $orders = $wpdb->get_results($wp_query1->request, OBJECT);
	
 
?>

<div class="row clearfix  mb-4 mt-4">
  <div class="col-md-8">
    <div class="card">
          <div class="card-body">
           
         
        <div class="card-header mt-n2 mb-4 ml-n2 mr-n2 bg-white">
              <h4 class="text-black mb-0 ml-n2"><?php echo __("Cashback Requests","premiumpress"); ?> </h4>
            </div> 
         
<?php
if(!empty($orders) ){
?>
<div class="overflow-auto"> 
          <table class="table small table-orders">
            <thead>
              <tr>
                <th><?php echo __("Request ID","premiumpress"); ?></th>
                
                <th class="text-center"><?php echo __("Date","premiumpress"); ?></th>
               
                <th class="text-center"><?php echo __("Status","premiumpress"); ?></th>
              
              </tr>
            </thead>
            <tbody>
              <?php
		 
		  
		 foreach($orders as $order){ 
		  
		 
		  // SELLER ID
          $status = get_post_meta($order->ID,'cashback_status',true);
		  $date = get_post_meta($order->ID,'cashback_date',true);
		 	    
         		       
           ?>
              <tr class="row-<?php echo $order->ID; ?>">
                <td><span class="font-weight-bold">
                
              #<?php echo $CORE->ORDER("format_id", $order->ID ); ?>
                
                
                </span> </td>
                <td class="text-center text-muted"><?php echo hook_date($date); ?></td>
              
                <td class="text-center dashhideme">
				
  <?php if($status == 0){ ?>
             
              <span class="inline-flex items-center font-weight-bold order-status-icon status-2"> <span class="dot mr-2"></span><span class="pr-2px leading-relaxed whitespace-no-wrap">
			  <?php echo __("Pending","premiumpress"); ?></span> </span>
              
              <?php }elseif($status == 1){ ?>
              <span class="inline-flex items-center font-weight-bold order-status-icon status-1"> <span class="dot mr-2"></span><span class="pr-2px leading-relaxed whitespace-no-wrap">
			  <?php echo __("Approved","premiumpress"); ?></span> </span>
             
              <?php }else{ ?>
              
              
              <span class="inline-flex items-center font-weight-bold order-status-icon status-5"> <span class="dot mr-2"></span><span class="pr-2px leading-relaxed whitespace-no-wrap">
			  <?php echo __("Rejected","premiumpress"); ?></span> </span>
              <?php } ?>
               
           
                  
                  </td>
                 
                  
               
              </tr>              
              <?php  }  ?>
            </tbody>
          </table>
          </div>
          <?php } ?>
          
          
          <?php if(empty($orders)){ ?>
          <div class="py-4 text-center">
            <h6><?php echo __("No Requests Found","premiumpress"); ?></h6>
          </div>
          <?php } ?>
         
         
           
        </div>
    </div>
 </div>   
 <div class="col-md-4">
 
 
 
 
    <div class="card ">
      <div class="card-header bg-white text-center font-weight-bold">
        
        <?php echo __("New Cashback Request","premiumpress"); ?>
        
        
        
      </div>
      
      <div class="card-body">
 
      <div class="alert alert-success font-weight-bold" id="cashbackformmsg" style="display:none;">
      <?php echo __("Your request has been received. Please allow 24/48 hours for us to validate your request.","premiumpress"); ?>
      </div>
      
       <?php if(empty($f)){ ?>
              
                <div class="py-4 text-center">
            <h6><?php echo __("No Coupons Used","premiumpress"); ?></h6>
            
            <p class="small opacity-5"><?php echo __("Please use a coupon or offer found on our website first.","premiumpress"); ?></p>
          </div>
              
              <?php }else{ ?>
      
        <form  role="form" method="post" action="" onsubmit="return CheckCashbackFormData();" id="cashbackform">
          <input type="hidden" name="action" value="cashbackform" />
          <div class="row">
            <div class="col-md-12">
             
             <label class="small font-weight-bold"><?php echo __("Which coupon did you use?","premiumpress"); ?></label>
              
             
              <select class="form-control" name="cashback-pid" id="cashback-pid" onchange="UpdateStoreName();">
              <option></option>
              <?php foreach($f as $k => $g){
			  
			   if(isset($k) && is_numeric($k)){			  
			  $tt = get_the_title($g['pid']);
			  if($tt == ""){ continue; }
			   ?>
              <option value="<?php echo $g['pid']; ?>" data-storename="<?php echo do_shortcode('[STORENAME link=0 pid='.$g['pid'].']'); ?>" data-date="<?php echo $g['date']; ?>"><?php echo $tt; ?></option>
              <?php } } ?>
              </select>
              <div id="showstorename"></div>
              
              <label class="mt-3 small font-weight-bold"><?php echo __("Order ID","premiumpress"); ?></label>
              <div class="input-group"> <span class="input-group-prepend input-group-text bg-white rounded-0">#</span>
                <input type="text" class="form-control rounded-0" name="cashback-amount" id="cashback-order" />
              </div>
              
              <label class="mt-3 small font-weight-bold"><?php echo __("Order Total","premiumpress"); ?></label>
              <div class="input-group"> <span class="input-group-prepend input-group-text bg-white rounded-0"><?php echo _ppt(array('currency','symbol')); ?></span>
                <input type="text" class="form-control rounded-0 numericonly" name="cashback-amount" id="cashback-amount"/>
              </div>
              
              
            </div>
            <div class="col-md-12">
              <button class="btn btn-primary my-4 btn-block border-radius-none font-weight-bold text-uppercase small" type="submit"><?php echo __("Submit Details","premiumpress"); ?></button>
            </div>
          </div>
        </form>
        <?php } ?>
        
        <script>
		
		function UpdateStoreName(){
		
		jQuery("#showstorename").html(jQuery('#cashback-pid').find(":selected").attr('data-storename')+' ('+jQuery('#cashback-pid').find(":selected").attr('data-date')+')').addClass('small font-weight-bold mt-2');
		
		
		} 
		
		
	function CheckCashbackFormData()
   { 
   	 
   	var a1 = document.getElementById("cashback-pid");
   	var a2 = document.getElementById("cashback-order");	
    var a3 = document.getElementById("cashback-amount");	
     
   	if(a1.value == '' || a2.value == '' || a3.value == '' )
   	{
   		alert("<?php echo __("Please fill in all of the details.","premiumpress") ?>");
   		a1.focus();
   		a1.style.border = 'thin solid red';
   		return false;
   	} 		
   	 
	
     jQuery.ajax({
           type: "POST",
           url: '<?php echo home_url(); ?>/',		
   		data: {
            action: "cashback_new",
			total: 	 a3.value,
			orderid: a2.value,
			pid: a1.value,			
			
           },
           success: function(response) {   			 
			
   			jQuery('#cashbackform').html('').hide();
   			jQuery('#cashbackformmsg').show();			
   			
           },
           error: function(e) {
               alert("error "+e)
           }
       });
   	
   	return false;
   }
   
   
</script>

     
      </div>      
    </div>
 
 
    
</div>
</div>