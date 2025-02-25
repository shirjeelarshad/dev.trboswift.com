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

    <div class="container">
    <div class="row">
              
        <div class="col-md-3 border-right">  
        
<label><?php echo __("Status","premiumpress"); ?></label> 
<?php
$count = 1;
 
?>
<select name="mass_os" id="mass_os" class="form-control">
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
        
        
        </div> 
        
        <div class="col-md-3 border-right">  
        
        
        </div> 
        
        <div class="col-md-3 ">  
        
 

 <label class="custom-control custom-checkbox ">
<input type="checkbox" name="delete" id="delete-seleced" value="1" class="custom-control-input" >
<div class="custom-control-label"> Delete Selected</div>

        
        
        </div> 
        
   <div class="col-12">
   
   <hr />
   
   <button class="btn btn-sm btn-admin color2" type="button" onclick="ajax_massupdate_listings();">Update Selected</button>




   
   </div>
    
    </div>    
    </div>   

</div> 