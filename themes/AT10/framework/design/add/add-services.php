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

$current_data = array();
if(isset($_GET['eid'])){
$current_data = get_post_meta($_GET['eid'],'customextras', true); 
}

?>

<div class="card shadow-sm mt-5">
  <div class="card-body">
    <h4><?php echo __("Services","premiumpress"); ?></h4>
    <hr />
    
   
    <div class="clearfix"> <a href="javascript:void(0);" onClick="jQuery('#wlt_customextras_list_fields').clone().insertBefore('#wlt_customextras_list');jQuery('.ff999').show();" class="btn btn-system btn-md"><i class="fa fa-plus"></i> <?php echo __("Add Service","premiumpress") ?></a> </div>
    <div id="wlt_customextras_list" class="list-group">
      <?php 



if( !empty($current_data) ){ $i=0; foreach($current_data['name'] as $data){ if($current_data['name'][$i] !=""){ ?>
      <div   id="ff<?php echo $i; ?>">
        <div class="p-4 mb-4 bg-light border mt-4">
          <div class="row">
            <div class="col-md-8">
              <p class="text-uppercase font-weight-bold text-dark small"><?php echo __("Name","premiumpress") ?></p>
              <input type="text" name="customextras[name][]" id="ff<?php echo $i; ?>_title" value="<?php echo $current_data['name'][$i]; ?>" class="form-control rounded-0"  />
            </div>
            <div class="col-md-4">
              <p class="text-uppercase font-weight-bold text-dark small"><?php echo __("Price","premiumpress") ?></p>
              <div class="field_wrapper">
                <div class="input-group" style="max-width:200px;"><span class="input-group-text bg-white rounded-0 border-right-0"><?php echo hook_currency_symbol(''); ?></span>
                  <input type="text" name="customextras[price][]" maxlength="255" class="form-control rounded-0" value="<?php if(!isset($_GET['eid'])){ echo 0; }else{ echo $current_data['price'][$i]; } ?>" >
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
      
      <div class="ff999">
        <div class="p-4 mb-4 bg-light border mt-4">
          <div class="row">
            <div class="col-md-8">
              <p class="text-uppercase font-weight-bold text-dark small"><?php echo __("Name","premiumpress") ?></p>
              <input type="text" name="customextras[name][]" value="" class="form-control rounded-0"  />
            </div>
            <div class="col-md-4">
              <p class="text-uppercase font-weight-bold text-dark small"><?php echo __("Price","premiumpress") ?></p>
              <div class="field_wrapper">
                <div class="input-group" style="max-width:200px;"><span class="input-group-text bg-white rounded-0 border-right-0"><?php echo hook_currency_symbol(''); ?></span>
                  <input type="text" name="customextras[price][]" maxlength="255" class="form-control rounded-0" value="100" >
                </div>
              </div>
            </div>
            <div class="col-12 mt-4">
              <p class="text-uppercase font-weight-bold text-dark small"><?php echo __("Description","premiumpress") ?></p>
              <textarea name="customextras[value][]" class="form-control rounded-0" style="width:100%;height:100px;"></textarea>
            </div>
          </div>
          <div class="clearfix"></div>
          <a href="javascript:void(0);" onClick="jQuery('.ff999').hide();" class="btn btn-system btn-md mt-2"><i class="fa fa-trash"></i> <?php echo __("Delete","premiumpress") ?></a> </div>
      </div>
      
       </div>
      
      
        
        
        
   
    </div>
  </div>
</div>
