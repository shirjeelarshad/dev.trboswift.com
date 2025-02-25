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

$weight_class 	= "";
$weight_type 	= "";
$length_class	= "";
if( isset($_GET['eid']) ){
$weight_class = get_post_meta($_GET['eid'], "weight_class", true);
$weight_type = get_post_meta($_GET['eid'], "weight_type", true);
$length_class = get_post_meta($_GET['eid'], "length_class", true);
}
 
?>
<div class="card shadow-sm mt-5"> <div class="card-body"> 
 
<div class="container px-0">


<div class="row">
<div class="col-12 col-lg-6">

<div class="step"><h3 class="mb-4"><?php echo __("Product Weight","premiumpress"); ?> </h3></div>




<div class="form-group">
	<label><?php echo __("Weight","premiumpress"); ?></label>
    <div class="input-group"> 
	<input class="form-control" name="custom[weight]" value="<?php if( isset($_GET['eid']) ){  echo get_post_meta($_GET['eid'], "weight", true); } ?>" />
    </div>
</div>

<div class="form-group">
	<label><?php echo __("Weight Type","premiumpress"); ?></label>
    <div class="input-group">
	<select name="custom[weight_class]" id="field_price-on" class="form-control" style="width:100%;">
	<option value="0" <?php if($weight_class  == 0){ ?>selected="selected"<?php } ?>><?php echo __("Kilogram","premiumpress"); ?></option>
	<option value="1" <?php if($weight_class  == 1){ ?>selected="selected"<?php } ?>><?php echo __("Gram","premiumpress"); ?></option> 
    <option value="2" <?php if($weight_class  == 2){ ?>selected="selected"<?php } ?>><?php echo __("Pound","premiumpress"); ?></option>   
    <option value="3" <?php if($weight_class  == 2){ ?>selected="selected"<?php } ?>><?php echo __("Ounce","premiumpress"); ?></option>              
    </select>
    </div>
</div> 
<div class="form-group">
	<label><?php echo __("Weight Category","premiumpress"); ?></label>
    <div class="input-group">
	<select name="custom[weight_type]" id="field_price-on" class="form-control" style="width:100%;">
	<option value="0" <?php if($weight_type == 0){ ?>selected="selected"<?php } ?>><?php echo __("Light","premiumpress"); ?></option>
	<option value="1" <?php if($weight_type == 1){ ?>selected="selected"<?php } ?>><?php echo __("Medium","premiumpress"); ?></option> 
    <option value="2" <?php if($weight_type == 2){ ?>selected="selected"<?php } ?>><?php echo __("Heavy","premiumpress"); ?></option> 
    <option value="3" <?php if($weight_type == 3){ ?>selected="selected"<?php } ?>><?php echo __("Very Heavy","premiumpress"); ?></option>             
    </select>    
    </div>
</div>

 
</div>

<div class="col-12 col-lg-6">

<div class="step"><h3 class="mb-4"><?php echo __("Product Dimensions","premiumpress"); ?> </h3></div>


<div class="form-group">
	<label><?php echo __("Dimensions","premiumpress"); ?> (<?php echo __("Length","premiumpress"); ?>)</label>
    <div class="input-group">
	<input class="form-control" name="custom[size_l]" value="<?php if( isset($_GET['eid']) ){  echo get_post_meta($_GET['eid'], "size_l", true); } ?>" />
    </div>
</div>

<div class="form-group">
	<label><?php echo __("Dimensions","premiumpress"); ?> (<?php echo __("Width","premiumpress"); ?>)</label>
    <div class="input-group"> 
	<input class="form-control" name="custom[size_w]" value="<?php if( isset($_GET['eid']) ){  echo get_post_meta($_GET['eid'], "size_w", true); } ?>" />
    </div>
</div>

<div class="form-group">
	<label><?php echo __("Dimensions","premiumpress"); ?> (<?php echo __("Height","premiumpress"); ?>)</label>
    <div class="input-group">
	<input class="form-control" name="custom[size_h]" value="<?php if( isset($_GET['eid']) ){  echo get_post_meta($_GET['eid'], "size_h", true); } ?>" />
    </div>
</div> 

<div class="form-group">
	<label><?php echo __("Length Type","premiumpress"); ?></label>
    <div class="input-group">
	<select name="custom[length_class]" class="form-control" style="width:100%;">
	<option value="0" <?php if($length_class == 0){ ?>selected="selected"<?php } ?>><?php echo __("Centimeter","premiumpress"); ?></option>
	<option value="1" <?php if($length_class == 1){ ?>selected="selected"<?php } ?>><?php echo __("Millimeter","premiumpress"); ?></option> 
    <option value="2" <?php if($length_class == 2){ ?>selected="selected"<?php } ?>><?php echo __("Inch","premiumpress"); ?></option>           
    </select>
    </div>
</div> 



</div>

</div>

</div> </div> </div> 