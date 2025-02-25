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
        
        
        <h5 class="card-title"><?php echo __("Username Search","premiumpress"); ?></h5>
        
        <div class="position-relative mt-4">
<input type="text" class="form-control customfilter" name="username" data-type="text" data-key="username"  placeholder="<?php echo __("Username..","premiumpress"); ?>" value="<?php if(isset($_GET['username'])){ echo esc_attr($_GET['username']); } ?>">

 <button class="btn position-absolute text-muted" style="top:0px; right:0px;" type="button" onclick="_filter_update()" ><i class="fa fa-search"></i></button>

</div> 
        
        
        </div> 
        
         <?php if( $CORE->LAYOUT("captions","memberships") && _ppt(array('mem','enable')) == 1 ){ ?>
        <div class="col-md-6 border-right">  
        
        <label><?php echo __("Memberships","premiumpress"); ?></label> 
<hr />
        
        
              <?php 	 
	
	 
	
	// GET MEMBERSHIPS
	$all_memberships = $CORE->USER("get_memberships", array());
	 
 foreach($all_memberships  as $key => $m){ 
	 ?>
        
        
        <label class="custom-control custom-checkbox">
<input type="checkbox" class="custom-control-input customfilter" data-type="checkbox" data-key="membership" data-value="<?php echo $m['key']; ?>" onclick="_filter_update()">
    <span class="custom-control-label"></span>
     <span class="custom-control-label"></span>  <?php echo $m['name']; ?>
  
</label> 

<?php } ?>
        
        
        
        </div> 
        
        <?php } ?>
        
        <div class="col-md-3 border-right">  
        
<label><?php echo __("Show Only","premiumpress"); ?></label> 
<hr />

<label class="custom-control custom-checkbox">
<input type="checkbox" class="custom-control-input customfilter" data-type="checkbox" data-key="online" data-value="1" onclick="_filter_update()">
    <span class="custom-control-label"></span>
     <span class="custom-control-label"></span>  <?php echo __("Online Now","premiumpress") ?> 
  
</label> 


<label class="custom-control custom-checkbox">
<input type="checkbox" class="custom-control-input customfilter" data-type="checkbox" data-key="verify" data-value="0" onclick="_filter_update()">
    <span class="custom-control-label"></span>
     <span class="custom-control-label"></span>  <?php echo __("Not-Verified","premiumpress") ?> 
  
</label> 
    
<label class="custom-control custom-checkbox">
<input type="checkbox" class="custom-control-input customfilter" data-type="checkbox" data-key="verify" data-value="1" onclick="_filter_update()">
    <span class="custom-control-label"></span>
     <span class="custom-control-label"></span>  <?php echo __("Verified","premiumpress") ?> 
  
</label>     

        
        </div>
        
 
    
    </div>    
    </div>   

</div> 