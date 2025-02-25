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

<a href="javascript:void(0);" onclick="jQuery('#actionsbox').hide();" class="float-right text-muted position-absolute text-uppercase small" style="    top: 10px;    right: 10px;"><?php echo __("hide me","premiumpress"); ?></a>

    <div class="col-12">
    <div class="row">
              
        <div class="col-md-3 border-right">  
        
<label><?php echo __("Change Status","premiumpress"); ?></label> 
<?php
$count = 1;
 
?>
<select name="mass_os" id="mass_os" class="form-control">
 <option value="">----</option>
<?php
// ORDER STATUS
if(isset($_GET['eid']) && is_numeric($_GET['eid'])  ){
$orderstatus = get_post_meta($_GET['eid'], "order_status", true);
}
 
foreach( $CORE->ORDER("get_status", array()) as $k => $n){
?>
<option value="<?php echo $k; ?>"><?php echo $n['name']; ?></option>
<?php } ?>
</select>
        
          
        </div>
        <div class="col-md-3 border-right">  
        
        
 <label class="custom-control custom-checkbox mt-3">
<input type="checkbox" name="delete" id="delete-seleced" value="1" class="custom-control-input" >
<div class="custom-control-label"> Delete Selected</div>

        
        
        </div> 
        
        
        
        <div class="col-md-3 ">  
        
 

        
        
        </div> 
        
         <div class="col-lg-3">
          
        <button class="btn btn-primary rounded-pill shadow-sm btn-block mt-4 font-weight-bold" type="button" onclick="ajax_massupdate_listings();"><?php echo __("Update","premiumpress"); ?> </button>
        
         </div>
        
 
    
    </div>    
    </div>   

</div>