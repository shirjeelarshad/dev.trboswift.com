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

global $CORE;
 
 
?> 

<div class="py-4">

    <div class="col-12">
    <div class="row">
              
        <div class="col-md-3 border-right openfilters">  
 

<h6>Quick Search</h6>
<hr />
<input type="text" placeholder="User ID" onchange="_filter_update()" value="" class="form-control rounded-0 customfilter" data-key="order_userid"  data-type="text" id="order_userid">

 
<input type="text" placeholder="Order ID" onchange="_filter_update()" value="" class="form-control rounded-0 customfilter mt-2" data-key="orderid"  data-type="text" id="orderid">

<input type="text" placeholder="Invoice ID" onchange="_filter_update()" value="<?php if(isset($_GET['invoiceid'])){ echo esc_attr($_GET['invoiceid']); } ?>" class="form-control rounded-0 customfilter mt-2" data-key="invoiceid"  data-type="text" id="invoiceid">

        
<?php _ppt_template( 'framework/design/widgets/widget-filter', 'date' ); ?>


      
        </div>
        <div class="col-md-3 border-right openfilters">  


<h6>Order Status</h6>
<hr />
<?php
 
foreach(  $CORE->ORDER("get_status", array() ) as $k => $n){
?>
<label class="custom-control custom-checkbox">
<input type="checkbox"  value="<?php echo $k; ?>" class="custom-control-input customfilter getstatscheck" onclick="_filter_update()" id="order_status_<?php echo $k; ?>_check" data-key="orderstatus" data-value="<?php echo $k; ?>" data-old-value="" data-type="checkbox">

<div class="custom-control-label"><?php echo $n['name']; ?> </div>
</label>
 
<?php } ?>
 

          
        
        </div> 
        
        <div class="col-md-3 border-right openfilters">  

<h6>Order Type</h6>
<hr />
<?php
 
foreach(  $CORE->ORDER("get_type", array() ) as $k => $n){
?>


<label class="custom-control custom-checkbox " >
<input type="checkbox"  value="<?php echo $k; ?>" name="ordertypeid[]" class="custom-control-input customfilter" onclick="_filter_update()" data-divid="ordertype-<?php echo $k; ?>" data-key="ordertype" data-value="<?php echo $k; ?>" data-old-value="" data-type="checkbox" >
<div class="custom-control-label"> <?php echo $n['name']; ?></div>
</label>
 
 
<?php } ?>

        
        </div> 
        
        <div class="col-md-3 openfilters">  
        


 <h6>Order Process</h6>
<hr />

<?php

foreach(  $CORE->ORDER("get_process", array() ) as $k => $n){
?>

<label class="custom-control custom-checkbox " >
<input type="checkbox"  value="<?php echo $k; ?>" class="custom-control-input customfilter" onclick="_filter_update()" data-divid="orderprocess-<?php echo $k; ?>" data-key="orderprocess" data-value="<?php echo $k; ?>" data-old-value="" data-type="checkbox" >
<div class="custom-control-label"> <?php echo $n['name']; ?></div>
</label>
 
<?php } ?>

     
        
        </div> 
        
 
    
    </div>    
    </div>   

</div>