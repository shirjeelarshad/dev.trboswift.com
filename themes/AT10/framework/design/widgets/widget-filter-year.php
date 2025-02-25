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

global $CORE, $userdata, $post, $settings; 

 
if(isset($_GET['year1']) && is_numeric($_GET['year1'])){ $year1 = esc_attr($_GET['year1']); }else{ $year1 = 1950; }		
if(isset($_GET['year2']) && is_numeric($_GET['year2']) && $_GET['year2'] > 0){ $year2 = esc_attr($_GET['year2']); }else{ $year2 = date("Y")+1; }	 
 		
 
?>
 
<div class="card card-filter">
   <div class="card-body">
      <a href="#" data-toggle="collapse" data-target="#collapse_year" aria-expanded="true" class="">
         <h5 class="card-title"><?php echo __("Year","premiumpress"); ?></h5>
      </a>
      <div <?php if(!$CORE->isMobileDevice()){ ?> class="filter-content collapse" id="collapse_year"<?php }else{ ?> class="pt-2"<?php } ?>>
 
         <div class="form-row">
            <div class="form-group col-md-6">
               <label class="small text-muted"><?php echo __("Min","premiumpress"); ?></label>                
               <input type="text" name="year1" class="form-control customfilter" data-type="text" data-key="year1" <?php if(!$CORE->isMobileDevice()){ ?>onchange="_filter_update()" <?php } ?> id="filter_year_value_1" value="<?php echo $year1; ?>">                    
            </div>
            <div class="form-group text-right col-md-6">
               <label class="small text-muted"><?php echo __("Max","premiumpress"); ?></label>				  
               <input type="text" class="form-control customfilter" name="year2" data-type="text" data-key="year2"  <?php if(!$CORE->isMobileDevice()){ ?>onchange="_filter_update()" <?php } ?>id="filter_year_value_2" value="<?php echo $year2; ?>">    
            </div>
         </div>
      </div>
   </div>
</div> 