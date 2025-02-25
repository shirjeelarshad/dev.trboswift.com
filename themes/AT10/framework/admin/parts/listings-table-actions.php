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
 
 
?><div class="py-4">

   <div class="container">
      <div class="row">
         <div class="col-md-3 border-right">
            <label><?php echo __("Change Category","premiumpress"); ?></label> 
            <?php
               $count = 1;
               $cats = get_terms( 'listing', array( 'hide_empty' => 0, 'parent' => 0  ));
               if(!empty($cats)){
               ?>
            <select class="form-control" name="mass-cat" id="mass-cat">
            <option value="">----</option>
               <?php
                  foreach($cats as $cat){ 
                  
                   
                  ?>
               <option value="<?php echo $cat->term_id; ?>"><?php if($cat->parent != 0){ echo "-- "; } ?> <?php echo $cat->name; ?></option>
               <?php $count++; } ?>
            </select>
            <?php } ?>         
         </div>
         <div class="col-md-3 border-right"> 
         <?php if( $CORE->LAYOUT("captions","listings") ){ ?>
            <label><?php echo __("Change Package","premiumpress"); ?></label> 
             
            <select class="form-control" name="mass-pak" id="mass-pak">
               <option value="">----</option>
               <?php foreach(  $CORE->PACKAGE("get_packages", array() ) as $k => $n){  ?>
               <option value="<?php echo $k; ?>"><?php echo $n['name']; ?></option>
              <?php } ?>
                
            </select>
            <?php }else{ ?>
            <input type="hidden"name="mass-pak" id="mass-pak" value="0">
            <?php } ?>
            
            
            
            <?php
			$addons = $CORE->PACKAGE("get_packages_addons", array() );  ?>
            <?php if(!empty($addons)){ ?>
            <label class="mt-2"><?php echo __("Turn ON Add-ons","premiumpress"); ?></label> 
            <?php 
			 
			foreach($addons as $a){    ?>
     
        <label class="custom-control custom-checkbox">
        <input type="checkbox"  value="1" class="custom-control-input" id="mass_<?php echo $a['key']; ?>">
         
        
        <span class="custom-control-label  font-weight-normal"><?php echo $a['name']; ?></span> </label>
      
      <?php } ?>
      <?php } ?>
            
           
          
         </div>
         <div class="col-md-3 ">  
         
          <label><?php echo __("Change Status","premiumpress"); ?></label> 
          
 <select class="form-control" name="mass-status" id="mass-status">
               <option value="">----</option>
               <option value="publish"><?php echo __("Live","premiumpress"); ?></option>
               <option value="pending"><?php echo __("Pending","premiumpress"); ?></option>
               <option value="trash"><?php echo __("Delete","premiumpress"); ?></option>
                
            </select>
            
              <?php
			$addons = $CORE->PACKAGE("get_packages_addons", array() );  ?>
            <?php if(!empty($addons)){ ?>
            <label class="mt-2"><?php echo __("Turn OFF Add-ons","premiumpress"); ?></label> 
            <?php 
			 
			foreach($addons as $a){    ?>
     
        <label class="custom-control custom-checkbox">
        <input type="checkbox"  value="1" class="custom-control-input" id="mass_off_<?php echo $a['key']; ?>">
         
        
        <span class="custom-control-label font-weight-normal"><?php echo $a['name']; ?></span> </label>
      
      <?php } ?>
      <?php } ?>
  
         </div>
         <div class="col-lg-3">
          
        <button class="btn shadow-sm btn-block mt-4 font-weight-bold " type="button" onclick="ajax_massupdate_listings();"><?php echo __("Update","premiumpress"); ?> </button>
        
         </div>
        
      </div>
   </div>
   <a href="javascript:void(0);" onclick="jQuery('#actionsbox').hide();" class="float-right btn btn-warning  text-light rounded-0"><?php echo __("hide me","premiumpress"); ?></a>

</div>