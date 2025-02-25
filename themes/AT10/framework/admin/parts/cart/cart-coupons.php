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

 
?>
<?php 

global $settings;

$settings = array(

	"title" => __("Coupon Codes","premiumpress"), 	
	
	"desc" => __("Here you can setup discount codes for your website.","premiumpress"),

 	"video" => "https://www.youtube.com/watch?v=atAAYYUuo4o",

);

_ppt_template('framework/admin/_form-wrap-top' ); ?>

<div class="card card-admin">
  <div class="card-body">
    <div class="row border-bottom pb-3 mb-3">
      <div class="col-md-8 ">
        <label class="font-weight-bold mb-2"><?php echo __("Enable Coupons","premiumpress"); ?></label>
        <p class="text-muted"><?php echo __("Turn on/off the coupon system.","premiumpress"); ?></p>
      </div>
      <div class="col-md-2 mt-3 formrow">
        <div class="">
          <label class="radio off" style="display: none;">
          <input type="radio" name="toggle" value="off" onchange="document.getElementById('enablecoupons').value='0'">
          </label>
          <label class="radio on" style="display: none;">
          <input type="radio" name="toggle" value="on" onchange="document.getElementById('enablecoupons').value='1'">
          </label>
          <div class="toggle <?php if(_ppt(array('coupons','enable'))  == '1'){  ?>on<?php } ?>">
            <div class="yes">ON</div>
            <div class="switch"></div>
            <div class="no">OFF</div>
          </div>
        </div>
        <input type="hidden" id="enablecoupons" name="admin_values[coupons][enable]" value="<?php echo _ppt(array('coupons','enable')); ?>">
      </div>
    </div>
    <a data-toggle="modal" href="#CouponModal" class="btn btn-system btn-md float-right mb-3 shadow-sm"><i class="fa fa-plus"></i> <?php echo __("Add Coupon","premiumpress"); ?></a>
    <?php 
		
		$ppt_coupons = get_option("ppt_coupons");
		 
		 // update_option("ppt_emails","");
		if(is_array($ppt_coupons) && count($ppt_coupons) > 0 ){  ?>
    <table id="datatable_example" class="responsive table table-striped table-bordered mt-3">
      <thead>
        <tr>
          <th class="no_sort"><?php echo __("Code","premiumpress"); ?></th>
          <th class="no_sort"><?php echo __("Discount","premiumpress"); ?></th>
          <th class="no_sort"><?php echo __("Uses","premiumpress"); ?></th>
          <th class="no_sort" style="width:140px;text-align:center;"><?php echo __("Actions","premiumpress"); ?></th>
      </thead>
      <tbody>
        <?php
 	  
		foreach($ppt_coupons as $key=>$field){ ?>
        <tr>
          <td><?php echo stripslashes($field['code']); ?></td>
          <td style="width:50px; text-align:center"><?php 
		$discount = $field['discount_percentage'];
		if($discount != ""){
		
			echo $discount."%"; 
		
		}else{
			echo hook_price($field['discount_fixed']); 
		}
		
		 ?></td>
          <td style="width:50px; text-align:center"><?php
		$ff = 0;
		if(isset($field['used'])){		$ff = $field['used']; }
		
		 
		echo $ff;
		 ?></td>
          <td class="ms"><div class="btn-group1"> <a class="btn btn-sm btn-primary" rel="tooltip" 
                  href="admin.php?page=cart&lefttab=coupons&edit_coupon=<?php echo $key; ?>"
                  data-placement="left" data-original-title=" edit "><i class="fa fa-pencil ml-0"></i></a> <a class="btn btn-danger btn-sm confirm" rel="tooltip" data-placement="bottom" 
                  data-original-title="Remove"
                  href="admin.php?page=cart&lefttab=coupons&delete_coupon=<?php echo $key; ?>"
                  ><i class="fa fa-trash ml-0"></i></a> </div></td>
        </tr>
        <?php  }   ?>
      </tbody>
    </table>
    <?php } ?>
    <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
  </div>
</div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
