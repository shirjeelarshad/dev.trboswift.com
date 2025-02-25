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

$rates = array(
1 => __("1 Hour","premiumpress"),
2=> __("2 Hours","premiumpress"),
3 => __("3 Hours","premiumpress"),
4 =>__("6 Hours","premiumpress"),
5 => __("12 Hours","premiumpress"),
);
	

 
 
 
?>

<div class="card shadow-sm  <?php if(!isset($_POST['ajaxedit'])){ ?>mt-5<?php } ?>">
  <div class="card-body">
    <h4><?php echo __("My Rates","premiumpress"); ?></h4>
    <hr />
    <div class="row">
      <?php  foreach($rates as $k => $r){ ?>
      
      <div class="col-lg-12 border-bottom mb-3 pb-3">
      
          <div class="row">
            
            <div class="col-md-4 y-middle">
              <div class="h6"><?php echo $r; ?></div>
            </div>
            
            <div class="col-md-4">
              <label class="small"><?php echo __("Incall","premiumpress"); ?></label>
              <div class="input-group"><span class="input-group-text bg-white rounded-0 border-right-0"><?php echo hook_currency_symbol(''); ?></span>
                <input type="text" name="custom[rate_incall<?php echo $k; ?>]" maxlength="10" class="form-control rounded-0 val-numeric required" value="<?php 		if(!isset($_GET['eid'])){ echo 0; }else{ $g = $CORE->get_edit_data('rate_incall'.$k, $_GET['eid']); if(!is_numeric($g)){ echo 0; }else{ echo $g; } } ?>">
              </div>              
            </div>
            
            
            <div class="col-md-4">
              <label class="small"><?php echo __("Outcall","premiumpress"); ?></label>
              <div class="input-group"><span class="input-group-text bg-white rounded-0 border-right-0"><?php echo hook_currency_symbol(''); ?></span>
                <input type="text" name="custom[rate_outcall<?php echo $k; ?>]" maxlength="10" class="form-control rounded-0 val-numeric required" value="<?php 		if(!isset($_GET['eid'])){ echo 0; }else{ $g = $CORE->get_edit_data('rate_outcall'.$k, $_GET['eid']); if(!is_numeric($g)){ echo 0; }else{ echo $g; } } ?>">
              </div>              
            </div>
            
            
          </div>
        
         </div> 
        
        <?php  } ?>
      </div>
    </div>
  </div>
