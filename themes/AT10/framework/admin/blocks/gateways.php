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

global $CORE, $userdata;


if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; } $core_admin_values = get_option("core_admin_values");
 function MakeField($type, $name, $value, $list="", $default=""){
if($value ==""){ $value = $default; }
	switch($type){	
		case "checkbox": { return  "<input type='checkbox' class='checkbox' name='".$name."' value='".$value."'> "; } break;	
		case "text": { return  "<input type='text' name='adminArray[".$name."]' value='".$value."' class='form-control'>"; } break;
		case "textarea": { return "<textarea name='adminArray[".$name."]' type='text' class='form-control'>".stripslashes($value)."</textarea>"; } break;
		case "listbox": { 
			$r ="<select name='adminArray[".$name."]' class='form-control'>";
			foreach($list as $key => $val){
				if($value==$key){ $sel="selected"; }else{ $sel=""; }
				$r .="<option value='".$key."' ".$sel.">".$val."</option>";
			}
			$r .="</select>";
			return $r;
		} break;
	}
}


?>


<a href="https://www.premiumpress.com/plugins/?license=<?php echo get_option('ppt_license_key'); ?>" target="_blank" class="float-right btn-system btn-md shadow-sm">Find More Plugins <i class="fa fa-long-arrow-right mr-0 ml-2"></i> </a>
 
<h4><?php echo __("Installed Gateways","premiumpress"); ?></h4>  
<hr />
 
<div id="accordion" class="clearfix">                 
<?php 
 
$gatways = hook_payments_gateways($GLOBALS['core_gateways']);

$i=1;$p=1; if(is_array($gatways)){foreach($gatways as $Value){ ?>

   
    <div class="border shadow-sm" id="heading<?php echo $i; ?>" style="cursor:pointer;">
           <a class="p-3 py-4 btn-block"  data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="false" aria-controls="collapse<?php echo $i; ?>">
     
      
      <div class="float-right" style="margin-top:-10px;">
      
      <div class="border">
      
<?php if(strpos($Value['logo'], "http") === false){ ?>
<img src="https://www.premiumpress.com/_demoimages/gateways/<?php echo $Value['logo'] ?>"  style="max-width:100px; max-height:80px;">
<?php }else{ ?>
<img src="<?php echo $Value['logo'] ?>"  class="merchantlogo " style="max-width:100px; max-height:80px;">
<?php } ?>
    </div>
      
      </div>
      
 
           <h6 class="mb-0"><?php echo $Value['name'] ?> <?php if(get_option($Value['function']) == 'yes'){ ?><span class="badge badge-success txt300"><?php echo __("Enabled","premiumpress"); ?></span> <?php } ?></h6>  
      
      </a>
    </div>
    <div id="collapse<?php echo $i; ?>" class=" collapse border" aria-labelledby="heading<?php echo $i; ?>" data-parent="#accordion">
     

<div class="container">
   <div class="row border-bottom bg-dark text-white" style="border-top:0px;">
      <div class="col-8 pt-4">
         <label class="txt500 text-white"> <?php echo __("Enable Gateway","premiumpress"); ?> </label>
         <p class="py-2 text-white"><?php echo __("Turn on/off the display of this gateway.","premiumpress"); ?></p>
      </div>
      <div class="col-4 pt-4">
         <label class="radio off">
         <input type="radio" name="toggle" 
            value="no" onchange="document.getElementById('<?php echo $Value['function']; ?>_on').value='no'">
         </label>
         <label class="radio on">
         <input type="radio" name="toggle"
            value="yes" onchange="document.getElementById('<?php echo $Value['function']; ?>_on').value='yes'">
         </label>
         <div class="toggle <?php if(get_option($Value['function']) == 'yes'){  ?>on<?php } ?>">
            <div class="yes">ON</div>
            <div class="switch"></div>
            <div class="no">OFF</div>
         </div>
      </div>
      <input type="hidden" id="<?php echo $Value['function']; ?>_on" name="adminArray[<?php echo $Value['function']; ?>]" value="<?php echo get_option($Value['function']); ?>">
   </div>
</div>

<div class="p-4">

 
<div class="row mt-2">
   <?php foreach($Value['fields'] as $key => $field){ 
      if(!isset($field['list'])){ $field['list'] = ""; }
      if(!isset($field['default'])){ $field['default'] =""; }
      
      if($Value['function'] == $field['fieldname']){ continue; }
      
      ?>
   <div class="col-md-6 form-group py-2">
      <label class="txt500"><?php echo $field['name'] ?></label>   
      <?php echo MakeField($field['type'], $field['fieldname'],get_option($field['fieldname']),$field['list'], $field['default']) ?>
   </div>
   <?php } ?>
   <?php /*
   <hr />
   <div class="col-md-12">
      <div class="form-group">
         <label class="txt500">Display Text</label>
         <textarea name="adminArray[<?php echo $Value['function']; ?>_desc]" class="form-control" style="min-height:200px;"><?php  echo stripslashes(get_option($Value['function'].'_desc'));  ?></textarea>
      </div>
   </div>
 */ ?>
</div>
<?php if(isset($Value['notes']) && strlen($Value['notes']) > 1){ ?>

<div class="padding1 text-center mb-3">
   <?php echo $Value['notes']; ?>
</div>
<?php } ?> 
     
     
      </div>
 </div>    
 <?php $i++; } }  ?>  
 
</div>

<hr />

<div class="row">

        <div class="col-md-4">
                    <label><?php echo __("Demo Test Mode","premiumpress"); ?></label>
                    <div class="formrow mt-2">
                      <label class="radio off">
                      <input type="radio" name="toggle" 
            value="off" onchange="document.getElementById('demopay').value='0'">
                      </label>
                      <label class="radio on">
                      <input type="radio" name="toggle"
            value="on" onchange="document.getElementById('demopay').value='1'">
                      </label>
                      <div class="toggle <?php if( in_array(_ppt('demopay'), array("","1") )){  ?>on<?php } ?>">
                        <div class="yes">ON</div>
                        <div class="switch"></div>
                        <div class="no">OFF</div>
                      </div>
                    </div>
                    <input type="hidden" id="demopay" name="admin_values[demopay]" value="<?php if( in_array(_ppt('demopay'), array("","1")) ){ echo 1; }else{ echo 0; } ?>">
                  </div>

<div class="col-md-8">

<p class="mt-3"><?php echo __("The demo test mode helps you test the payment sytem without having to use real money. It is only visible to the admin but if you want to hide it completely turn it off here.","premiumpress"); ?></p>

</div>

</div> 

<?php if(is_array($gatways)){ ?>
<div class="bg-light p-4 mt-3 mb-5">

<p><i class="fa fa-shopping-cart"></i> <strong>Payment Test</strong> </p>

<p>Make a test payment using your current settings.</p>
 
<button type="button" class="btn btn-sm btn-outline-dark" onclick="ajax_load_payment('<?php 
   
   
   echo $CORE->order_encode(array(
   
   	"uid" => $userdata->ID, 
	
   	"amount" => 1, 
	
   	"order_id" => "TEST-".rand(),
   	 
   	"description" => "Admin Payment Test",
   	
   	"recurring" => 0,
	
	"nocoupons" => 1,
    
   								
   ) ); 
    		
   ?>');">Pay $1 Now</button>
 
<button type="button" class="btn btn-sm btn-outline-dark" onclick="ajax_load_payment('<?php 
   
   
   echo $CORE->order_encode(array(
   
   	"uid" => $userdata->ID, 
	
   	"amount" => 5.99, 
	
   	"order_id" => "TEST-".rand(),
   	 
   	"description" => "Admin Payment Test",
   	
   	"recurring" => 0,
	
	"nocoupons" => 1,
    
   								
   ) ); 
    		
   ?>');">Pay $5.99 Now</button>
 
 
<button type="button" class="btn btn-sm btn-outline-dark" onclick="ajax_load_payment('<?php 
   
   
   echo $CORE->order_encode(array(
   
   	"uid" => $userdata->ID, 
	
   	"amount" => 10.99, 
	
   	"order_id" => "TEST-".rand(),
   	 
   	"description" => "Admin Payment Test",
   	
   	"recurring" => 0,
	
	"nocoupons" => 1,
    
   								
   ) ); 
    		
   ?>');">Pay $10.99 Now</button>



<button type="button" class="btn btn-sm btn-outline-dark" onclick="ajax_load_payment('<?php 
   
   
   echo $CORE->order_encode(array(
   
   	"uid" => $userdata->ID, 
	
   	"amount" => 101, 
	
   	"order_id" => "TEST-".rand(),
   	 
   	"description" => "Admin Payment Test",
   	
   	"recurring" => 0,
	
	"nocoupons" => 1,
    
   								
   ) ); 
    		
   ?>');">Pay $101 Now</button>
   
   
   
   
   
<button type="button" class="btn btn-sm btn-outline-dark mt-4" onclick="ajax_load_payment('<?php 
   
   
   echo $CORE->order_encode(array(
   
   	"uid" => $userdata->ID, 
	
   	"amount" => 10, 
	
   	"order_id" => "TEST-".rand(),
   	 
   	"description" => "Admin Payment Test",
   	
   	"recurring" => 1,
	"recurring_days" => 30,
	
	"nocoupons" => 1,
    
   								
   ) ); 
    		
   ?>');">Pay $10 - recurring</button>
 
 
   
   
   
 
</div>

 



<script> 
   
 function ajax_load_payment(orderdata){
   
       jQuery.ajax({
           type: "POST",
           url: '<?php echo home_url(); ?>/',		
   		data: {
               action: "load_new_payment_form",
   				details: orderdata,
           },
           success: function(response) {	
		   
		   //jQuery('#gateways').hide();		
   			jQuery('#accordion').html(response).addClass('p-5');
   			
           },
           error: function(e) {
               console.log(e)
           }
       });
   
   }
</script>

 

<?php } ?>




<?php if($CORE->LAYOUT("captions","offers") != ""){ ?>
<div class="p-3 border bg-light">
      <div class="container px-0 mb-3">
        <div class="row">
          <div class="col-8">
            <label class="txt500">Escrow System</label>
            <p class="text-muted">By default buyer to seller payments are handled by users themselves. </p>
            
            <p class="text-muted">If you would like to act as the middle man and accept payments on behalf of the seller you can do here.</p>
            
            <p class="text-muted">Once the seller marks the order as completed, the sellers account will be credited with the order amount and can request you pay them directly as anytime.  </p>
          </div>
          <div class="col-3">
            <div class="mt-3">
              <label class="radio off">
              <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('enable_escrow').value='0'">
              </label>
              <label class="radio on">
              <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('enable_escrow').value='1'">
              </label>
              <div class="toggle <?php if(_ppt(array('cashout', 'enable_escrow')) == '1'){  ?>on<?php } ?>">
                <div class="yes">ON</div>
                <div class="switch"></div>
                <div class="no">OFF</div>
              </div>
            </div>
            <input type="hidden" id="enable_escrow" name="admin_values[cashout][enable_escrow]" value="<?php if(_ppt(array('cashout', 'enable_escrow')) == ""){ echo 1; }else{ echo _ppt(array('cashout', 'enable_escrow')); } ?>">
          </div>
        </div>
      </div>
      
      
    <div class="container px-0 ">
      <div class="row py-2">
        <div class="col-md-8">
          <label class="txt500"><?php echo __("Min Cashout Amount","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Here you can set the minimum amount users must have in credit before they can request a cashout.","premiumpress"); ?></p>
        </div>
        <div class="col-md-4">
           <div class="input-group"> <span class="input-group-prepend input-group-text"><?php echo hook_currency_symbol(''); ?></span>
              <input type="text" class="form-control btn-block"  name="admin_values[cashout][min_amount]" value="<?php if(is_numeric(_ppt(array('cashout', 'min_amount')))){ echo _ppt(array('cashout', 'min_amount')); }else{ echo 0; } ?>" style="max-width:100px">
            </div>
        </div>
      </div>
    </div>

</div>
<?php } ?>
 