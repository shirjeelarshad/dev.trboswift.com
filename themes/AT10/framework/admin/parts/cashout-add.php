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

global $CORE, $settings;

$settings = array(

"title" => __("Cashout Details","premiumpress"), 

"desc" =>__("Here you can add/edit the cashout request.","premiumpress"),

);

// USER ID
if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ $cashout_userid =  get_post_meta($_GET['eid'], "cashout_userid", true); } 

 

_ppt_template('framework/admin/_form-wrap-top' ); ?>

<div class="card card-admin">
  <div class="card-body">
    <div class="card-title"><?php echo __("Cashout Details","premiumpress"); ?></div>
    <form method="post" action="" enctype="multipart/form-data">
      <input type="hidden" name="neworder" value="<?php if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ echo esc_attr($_GET['eid']); }else{ echo 1; }  ?>" />
      <p class="text-muted mt-4"><?php echo __("Who's the order for?","premiumpress"); ?></p>
      <div class="row">
        <div class="form-group col-6">
          <label><?php echo __("User ID","premiumpress"); ?></label>
          <div class="input-group">
            <div class="input-group-prepend"> <span class="input-group-text"> # </span> </div>
            <input name="order[cashout_userid]" class="form-control"  type="text" value="<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ echo $cashout_userid; } ?>">
          </div>
          <!-- input-group.// -->
        </div>
        <div class="form-group col-6">
          <label><?php echo __("Email","premiumpress"); ?></label>
          <div class="input-group">
            <div class="input-group-prepend"> <span class="input-group-text"> @ </span> </div>
            <input name="order[cashout_email]" class="form-control"  type="text" value="<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ echo get_post_meta($_GET['eid'], "cashout_email", true); }?>">
          </div>
          <!-- input-group.// -->
        </div>
      </div>
      
      <?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ ?>
      <hr />
      <p class="text-muted mt-4"><?php echo __("User entered cashout details;","premiumpress"); ?></p>
       
       <div class="border p-3 bg-light">
      <div class="row">
          <div class="col-md-5 text-center border-right">
           <?php  $g = get_user_meta($cashout_userid, 'payment_type', true); if($g == ""){ $g  = __("Not Set","premiumpress"); } echo $g; ?>
          </div>
          <div class="col-md-7 text-center">
          
          <?php
		  
		  switch($g){
		  	
			case "paypal": {
			
				echo get_user_meta($cashout_userid,'paypal',true);
			
			} break;
			
			case "bank": {
			
				echo wpautop(stripslashes(get_user_meta($cashout_userid,'bank',true)));
			
			} break;
			
			case "person": {
			
				echo stripslashes(get_user_meta($cashout_userid,'payaddresss',true));
			
			} break;
			
			default: { echo __("Not Set;","premiumpress"); }
		  
		  
		  }
		  
		  
		  ?>
          
          </div>
      </div>
      </div>
      
      
      <?php } ?>
      
      
      
       <hr />
      <p class="text-muted"><?php echo __("What's the status of the cashout request?","premiumpress"); ?></p>
      <div class="row">
        <div class="form-group col-6">
          <label><?php echo __("Request Status","premiumpress"); ?></label>
          <select name="order[cashout_status]" class="form-control">
            <?php
// ORDER STATUS
if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){
$orderstatus = get_post_meta($_GET['eid'], "cashout_status", true);
}
 
foreach( $CORE->ORDER("get_status", array()) as $k => $n){
?>
            <option value="<?php echo $k; ?>" <?php  if(isset($_GET['eid'])){  selected( $orderstatus, $k ); }  ?>><?php echo $n['name']; ?></option>
            <?php } ?>
          </select>
          <?php

// ORDER STATUS
if(isset($_GET['eid']) && is_numeric($_GET['eid']) && get_post_meta($_GET['eid'], "cashout_paid", true) != ""){ ?>
          <div class="small text-muted mt-3"> <i class="fa fa-check"></i> <?php echo  __("Paid","premiumpress")." ".get_post_meta($_GET['eid'], "cashout_paid", true); ?> </div>
          <?php

}
?>
        </div>
        <div class="form-group col-6">
          <label><?php echo __("Payment Status","premiumpress"); ?></label>
          <select name="order[cashout_process]" class="form-control">
            <?php
// ORDER STATUS
if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){
$orderstatus = get_post_meta($_GET['eid'], "cashout_process", true);
}
 
foreach( $CORE->ORDER("get_process", array()) as $k => $n){
?>
            <option value="<?php echo $k; ?>" <?php  if(isset($_GET['eid'])){  selected( $orderstatus, $k ); }  ?>><?php echo $n['name']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <!-- end row -->
      <hr />
      <div class="row">
        <div class="form-group col-6">
          <label><?php echo __("Total Requested","premiumpress"); ?></label>
          <div class="input-group">
            <div class="input-group-prepend"> <span class="input-group-text"> <?php echo _ppt(array('currency','symbol')); ?> </span> </div>
            <input name="order[cashout_total]" class="form-control numericonly"  type="text" value="<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ echo get_post_meta($_GET['eid'], "cashout_total", true); }else{ echo 0; } ?>">
          </div>
        </div>
        <div class="form-group col-6">
          <div class="form-group">
            <label><?php echo __("Transaction Ref","premiumpress"); ?></label>
            <input type="text" name="order[cashout_ref]" class="form-control" value="<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ echo get_post_meta($_GET['eid'], "cashout_ref", true); } ?>">
            <div class="small text-muted mt-2"><?php echo __("Enter when payment is sent.","premiumpress"); ?></div>
          </div>
        </div>
      </div>
      <!-- end row -->
      <div class="form-group">
        <label><?php echo __("Additional Notes","premiumpress"); ?></label>
        <div class="input-group">
          <textarea name="order[cashout_notes]" class="form-control" style="height:100px !important;"><?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ echo get_post_meta($_GET['eid'], "cashout_notes", true); }?>
</textarea>
        </div>
      </div>
      <div class="p-4 bg-light text-center mt-4">
        <button type="submit" class="btn btn-admin"> <?php echo __("Update Order","premiumpress"); ?></button>
      </div>
    </form>
  </div>
</div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
