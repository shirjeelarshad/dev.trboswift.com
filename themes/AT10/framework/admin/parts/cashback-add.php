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




// WORK OUT THE COMMISSION
$commission = 0;
if(isset($_GET['eid']) && is_numeric($_GET['eid']) && is_numeric(get_post_meta($_GET['eid'], "cashback_pid", true)) && get_post_meta($_GET['eid'], "cashback_reftotal", true) > 0){

	$amount = get_post_meta($_GET['eid'], "cashback_reftotal", true);
	$pid = get_post_meta($_GET['eid'], "cashback_pid", true);
	
	$v		= get_post_meta($pid, 'cashback', true);	
	$p		= get_post_meta($pid, 'cashback_p', true);	
	
	if($p > 0){
	
	$commission_value = $amount/100 * $p;
	
	}else{
	
		$commission_value = $v;
	}

	$commission = hook_price($commission_value);


}






$settings = array(

"title" => __("Cashback Details","premiumpress"), 

"desc" =>__("Here you can add/edit a cashback request.","premiumpress"),

);

// USER ID
if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ $cashback_userid =  get_post_meta($_GET['eid'], "cashback_userid", true); } 

 

_ppt_template('framework/admin/_form-wrap-top' ); ?>

<div class="card card-admin">
  <div class="card-body">
    <div class="card-title"><?php echo __("Cashback Details","premiumpress"); ?></div>
    <form method="post" action="" enctype="multipart/form-data">
      <input type="hidden" name="neworder" value="<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ echo esc_attr($_GET['eid']); }else{ echo 1; }  ?>" />
      <p class="text-muted mt-4"><?php echo __("Who's the request from?","premiumpress"); ?></p>
      <div class="row">
        <div class="form-group col-md-6">
          <label><?php echo __("User ID","premiumpress"); ?></label>
          <div class="input-group">
            <div class="input-group-prepend"> <span class="input-group-text"> # </span> </div>
            <input name="order[cashback_userid]" class="form-control"  type="text" value="<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ echo $cashback_userid; } ?>">
          </div>
          
         <?php if(isset($_GET['eid'])){  ?>
      
          <a href="admin.php?page=members&eid=<?php echo $cashback_userid; ?>" class="btn btn-system shadow-sm btn-sm mt-4"><?php echo __("View Account","premiumpress"); ?></a>
           
        
        <?php } ?>
        </div>
      
      <div class="col">
      
          
          <label><?php echo __("Coupon Used","premiumpress"); ?></label>
       
          
          <div class="input-group">
           <div class="input-group-prepend"> <span class="input-group-text"> # </span> </div>
            <input name="order[cashback_pid]" class="form-control numericonly"  type="text" value="<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ echo get_post_meta($_GET['eid'], "cashback_pid", true); }else{ echo 0; } ?>">
          </div>
          
             
          <?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) && is_numeric(get_post_meta($_GET['eid'], "cashback_pid", true))){ ?>
          <div class="my-3">
          <a href="<?php echo get_permalink(get_post_meta($_GET['eid'], "cashback_pid", true)); ?>" target="_blank"><?php echo get_the_title(get_post_meta($_GET['eid'], "cashback_pid", true)); ?></a>
          </div>
          <?php } ?>
          
      
      </div>
       
      </div>
      
      
 
       
      
       <hr />
      <p class="text-muted"><?php echo __("What's the status of the cashback request?","premiumpress"); ?></p>
      <div class="row">
        <div class="form-group col-6">
          <label><?php echo __("Request Status","premiumpress"); ?></label>
          <select name="order[cashback_status]" class="form-control">
            <?php
// ORDER STATUS
if(isset($_GET['eid'])){
$orderstatus = get_post_meta($_GET['eid'], "cashback_status", true);
}
 
foreach( array(

0 => __("Pending","premiumpress"),
1 => __("Approved","premiumpress"),
2 => __("Rejected","premiumpress"),

) as $k => $n){
?>
            <option value="<?php echo $k; ?>" <?php  if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){  selected( $orderstatus, $k ); }  ?>><?php echo $n; ?></option>
            <?php } ?>
          </select>
          <?php

// ORDER STATUS
if(isset($_GET['eid']) && get_post_meta($_GET['eid'], "cashback_paid", true) != ""){ ?>
          <div class="small text-muted mt-3"> <i class="fa fa-check"></i> <?php echo  __("Paid","premiumpress")." ".get_post_meta($_GET['eid'], "cashback_paid", true); ?> </div>
          <?php

}
?>
        </div>
        <div class="form-group col-6">
        <?php if(isset($_GET['eid'])){ ?>
        <?php if($orderstatus  == 0){ ?>
        <div class="bg-light border p-4">
        
        
        <i class="fal fa-info-circle"></i> <?php echo str_replace("%s",$commission,__("If you set this to approved, a total of %s will be added to the users balance.","premiumpress")); ?>
        
        </div>
        
        <input type="hidden" name="commission" value="<?php echo $commission_value; ?>" />
      <?php }elseif($orderstatus  == 1){ ?>
      
       <div class="alert-success border p-4">
        
        
        <i class="fal fa-info-circle"></i> <?php echo str_replace("%s",$commission,__("A total of %s was be added to the users balance.","premiumpress")); ?>
        
        </div>
      <?php } ?>
      <?php } ?>
      
      
        </div>
      </div>
      <!-- end row -->
      <hr />
      <div class="row">
      
        <div class="form-group col-6">
    
    
              <label>Ref: <?php echo __("Order Total","premiumpress"); ?></label>
          <div class="input-group">
            <div class="input-group-prepend"> <span class="input-group-text"> <?php echo _ppt(array('currency','symbol')); ?> </span> </div>
            <input name="order[cashback_reftotal]" class="form-control numericonly"  type="text" value="<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ echo get_post_meta($_GET['eid'], "cashback_reftotal", true); }else{ echo 0; } ?>">
     </div>
      
      
            <label class="mt-4">Ref: <?php echo __("Order ID","premiumpress"); ?></label>
          <div class="input-group">
            <div class="input-group-prepend"> <span class="input-group-text"> # </span> </div>
            <input name="order[cashback_refid]" class="form-control"  type="text" value="<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ echo get_post_meta($_GET['eid'], "cashback_refid", true); }else{ echo 0; } ?>">
          </div>
          
        </div>
        
        
        
        <div class="form-group col-6">
         
  <div class="bg-light border p-4">
        
        
        <i class="fal fa-info-circle"></i> <?php echo __("These are the details provided by the user when making the cashback request.","premiumpress"); ?>
        
        </div>
          
        </div>
      </div>
      <!-- end row -->
      <div class="form-group mt-4">
        <label><?php echo __("Admin Notes","premiumpress"); ?></label>
        <div class="input-group">
          <textarea name="order[cashback_notes]" class="form-control" style="height:100px !important;"><?php if(isset($_GET['eid'])){ echo get_post_meta($_GET['eid'], "cashback_notes", true); }?>
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
