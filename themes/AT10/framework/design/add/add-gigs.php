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

global $CORE;

$editID=0;
if(isset($_GET['eid']) && is_numeric($_GET['eid'])){
$editID = $_GET['eid'];
} 

 
$data = array();
$content = "";
$for = "";
$against = "";
$rating = "";
if(isset($_GET['eid'])){



}
 
?>

<div class="card shadow-sm mt-5">
  <div class="card-body">
    <h4><?php echo __("Pricing","premiumpress"); ?></h4>
    <hr />
    <div class="row">
      <?php $a=1; while($a < 3){ 

$name = "gig";
$price = "price";
$days = "days";
$desc = "desc";
if($a ==2){
$name = "gig-1";
$price = "price-1";
$days = "days-1";
$desc = "desc-1";
}

 // TURN OFF DAYS
$showdays = true;
$el = _ppt(array('design', "element_days"));
if($el == 0){
$showdays = false;
}
	 

?>
      <div class="col-lg-6">
        <div class="p-3 border bg-light">
          <label class="text-uppercase font-weight-bold text-dark small btn-block">
          <?php if($a ==1){ echo __("Standard","premiumpress"); }else{ echo "<i class='fa fa-star text-warning mr-2'></i> ".__("Premium","premiumpress"); } ?>
          <?php echo __("Title","premiumpress"); ?> </label>
          <div class="input-group">
            <input type="text" class="form-control <?php if($a ==1){ ?>required-field<?php } ?>" name="custom[<?php echo $name; ?>]" value="<?php echo $CORE->get_edit_data($name, $editID); ?>"/>
          </div>
          <div class="row mt-4">
            <div class="col-md-6">
              <label class="text-uppercase font-weight-bold text-dark small btn-block"><?php echo __("Price","premiumpress"); ?></label>
              <div class="input-group"><span class="input-group-text bg-white rounded-0 border-right-0"><?php echo _ppt(array('currency','symbol')); ?></span>
                <input type="text" name="custom[<?php echo $price; ?>]" maxlength="10" class="form-control rounded-0 val-numeric required <?php if($a ==1){ ?>val-notzero<?php } ?>" value="<?php 
		
		if(!isset($_GET['eid'])){ echo 0; }else{ $g = $CORE->get_edit_data($price, $_GET['eid']); if($g == ""){ echo 0; }else{ echo $g; } } ?>" id="field-price" style="max-width:100px;">
              </div>
            </div>
            <div class="col-md-6" <?php if(!$showdays){ ?>style="display:none"<?php } ?>>
              <label class="text-uppercase font-weight-bold text-dark small btn-block"><?php echo __("Can complete in","premiumpress"); ?> </label>
              <div class="input-group">
                <select name="custom[<?php echo $days; ?>]" class="form-control rounded-0">
                  <option value="1" <?php selected( $CORE->get_edit_data($days, $editID), 1 ); ?>>1 <?php echo __("day","premiumpress"); ?></option>
                  <?php
        $i=2;
        while($i< 31){
        ?>
                  <option value="<?php echo $i; ?>" <?php selected( $CORE->get_edit_data($days, $editID), $i ); ?>><?php echo $i; ?> <?php echo __("days","premiumpress"); ?></option>
                  <?php $i++; } ?>
                </select>
              </div>
            </div>
          </div>
          <label class="text-uppercase font-weight-bold text-dark small btn-block  mt-4"> <?php echo __("Description","premiumpress"); ?> </label>
          <div class="input-group">
            <textarea name="custom[<?php echo $desc; ?>]" class="form-control" style="min-height:100px;"><?php echo $CORE->get_edit_data($desc, $editID); ?></textarea>
          </div>
        </div>
      </div>
      <?php $a++; } ?>
    </div>
    <hr />
    <div class="clearfix"> <a href="javascript:void(0);" onClick="gigAdd();" class="btn btn-system btn-md"><i class="fa fa-plus"></i> <?php echo __("Add Add-on","premiumpress") ?></a> </div>
    <div id="wlt_customextras_list" class="list-group">
      <?php 

$current_data = array();
if(isset($_GET['eid'])){
$current_data = get_post_meta($_GET['eid'],'customextras', true); 
}

if( !empty($current_data) ){ $i=0; foreach($current_data['name'] as $data){ if($current_data['name'][$i] !=""){ ?>
      <div   id="ff<?php echo $i; ?>">
        <div class="p-4 mb-4 bg-light border mt-4">
          <div class="row">
            <div class="col-md-8">
              <p class="text-uppercase font-weight-bold text-dark small"><?php echo __("Add-on","premiumpress") ?> <?php echo __("Title","premiumpress") ?></p>
              <input type="text" name="customextras[name][]" id="ff<?php echo $i; ?>_title" value="<?php echo $current_data['name'][$i]; ?>" class="form-control rounded-0"  />
            </div>
            <div class="col-md-4">
              <p class="text-uppercase font-weight-bold text-dark small"><?php echo __("Price","premiumpress") ?></p>
              <div class="field_wrapper">
                <div class="input-group" style="max-width:200px;"><span class="input-group-text bg-white rounded-0 border-right-0"><?php echo _ppt(array('currency','symbol')); ?></span>
                  <input type="text" name="customextras[price][]" maxlength="255" class="form-control rounded-0 val-numeric" value="<?php if(!isset($_GET['eid'])){ echo 0; }else{ echo $current_data['price'][$i]; } ?>" >
                </div>
              </div>
            </div>
            <div class="col-12 mt-4">
              <p class="text-uppercase font-weight-bold text-dark small"><?php echo __("Description","premiumpress") ?></p>
              <textarea name="customextras[value][]" class="form-control rounded-0" style="width:100%;height:100px;"><?php echo trim($current_data['value'][$i]); ?></textarea>
            </div>
          </div>
          <div class="clearfix"></div>
          <a href="javascript:void(0);" onClick="jQuery('#ff<?php echo $i; ?>_title').val('');jQuery('#ff<?php echo $i; ?>').hide();" class="btn btn-system btn-md mt-2"><i class="fa fa-trash"></i> <?php echo __("Delete","premiumpress") ?></a> </div>
      </div>
      <?php } $i++; } } ?>
    </div>
    <div style="display:none">
      <div id="wlt_customextras_list_fields">
      
      <div id="randomnumme">
        <div class="p-4 mb-4 bg-light border mt-4">
          <div class="row">
            <div class="col-md-8">
              <p class="text-uppercase font-weight-bold text-dark small"><?php echo __("Add-on","premiumpress") ?> <?php echo __("Title","premiumpress") ?></p>
              <input type="text" name="customextras[name][]" value="" class="form-control rounded-0"  />
            </div>
            <div class="col-md-4">
              <p class="text-uppercase font-weight-bold text-dark small"><?php echo __("Price","premiumpress") ?></p>
              <div class="field_wrapper">
                <div class="input-group" style="max-width:200px;"><span class="input-group-text bg-white rounded-0 border-right-0"><?php echo _ppt(array('currency','symbol')); ?></span>
                  <input type="text" name="customextras[price][]" maxlength="255" class="form-control rounded-0 val-numeric" value="100" >
                </div>
              </div>
            </div>
            <div class="col-12 mt-4">
              <p class="text-uppercase font-weight-bold text-dark small"><?php echo __("Description","premiumpress") ?></p>
              <textarea name="customextras[value][]" class="form-control rounded-0" style="width:100%;height:100px;"></textarea>
            </div>
          </div>
          <div class="clearfix"></div>
          <a href="javascript:void(0);" class="btn btn-system btn-md mt-2"><i class="fa fa-trash"></i> <?php echo __("Delete","premiumpress") ?></a> </div>
      </div>
      
       </div>
      
      
        
        
        
   
    </div>
  </div>
</div>
 
<script>



function gigAdd(){

	var num = Math.floor((Math.random() * 100) + 1);	
	 
	jQuery("#randomnumme").addClass('gig-'+num);
	
	jQuery('#wlt_customextras_list_fields').clone().insertBefore('#wlt_customextras_list').removeAttr('id');	
	
	jQuery("#wlt_customextras_list_fields #randomnumme").removeClass('gig-'+num);	
	
	jQuery('.gig-' + num).find(".btn-system").attr('onClick', 'randomnumme_delete('+num+');');
	
	jQuery('.gig-' + num).removeAttr('id');
	
}


function randomnumme_delete(id){
 
	jQuery(".gig-"+id).html('');

}

</script>
