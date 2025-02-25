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

 		
 
?>

<div class="card card-filter hide-mobile">
  <div class="card-body"> <a href="#" data-toggle="collapse" data-target="#collapse_showonly" aria-expanded="true">
    <h5 class="card-title"><?php echo __("Show Only","premiumpress"); ?></h5>
    </a>
    <div class="filter-content collapse" id="collapse_showonly">
    
    

    
      <?php if(!is_admin() && THEME_KEY != "cp" && $userdata->ID && _ppt(array('user','favs')) == 1 ){ ?>
      <label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter" data-type="checkbox" data-key="favorites" data-value="1" onclick="_filter_update()">
      <span class="custom-control-label"></span> <span class="custom-control-label"></span> <?php echo __("My Favorites","premiumpress") ?> <b class="badge badge-pill badge-light float-right novalue"><?php echo $CORE->USER("favs_count",$userdata->ID); ?></b> </label>
      <?php } ?>
      
      
      <?php if(_ppt(array('lst','addon_featured_enable')) == 1){ ?>
      
      <label class="custom-control custom-checkbox">
      <input type="checkbox"  class="custom-control-input customfilter"  data-type="checkbox" data-key="featured" data-value="1" onclick="_filter_update()">
      <span class="custom-control-label"></span> 
	  
	  
	  <?php if(THEME_KEY == "cp"){ ?>   
      <?php echo __("Staff Picks","premiumpress") ?>
      <?php }else{ ?>
	  <?php echo __("Featured","premiumpress") ?>
     <?php } ?>
     
      </label>
      
      <?php } ?>
      
      
      <?php if(_ppt(array('lst','addon_sponsored_enable')) == 1){ ?>
     <label class="custom-control custom-checkbox">
      <input type="checkbox"  class="custom-control-input customfilter"  data-type="checkbox" data-key="sponsored" data-value="1" onclick="_filter_update()">
      <span class="custom-control-label"></span> 
	  
	  <?php echo __("Sponsored","premiumpress") ?>
     
      </label>
      <?php } ?>
      
       
      
<?php if(THEME_KEY == "at"){ ?>    
 
 
<label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter" data-type="checkbox"   data-key="expiry" data-value="1" onclick="_filter_update()" onChange="addnewfilter('1','expiry');" <?php if(!isset($_GET['status']) && !isset($_GET['favs']) ){ ?>checked=checked<?php } ?>>
      <span class="custom-control-label"></span> <?php echo __("Live Auctions","premiumpress") ?> </label>

<?php } ?>



<?php if(THEME_KEY == "cp"){ ?>

<label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter" data-type="checkbox"   data-key="verified" data-value="1" onclick="_filter_update()" onChange="addnewfilter('1','verified');">
      <span class="custom-control-label"></span> <?php echo __("Verified","premiumpress") ?> </label>

<?php } ?>


<?php if(THEME_KEY == "es"){ ?>

<label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter" data-type="checkbox"   data-key="hasvideo" data-value="1" onclick="_filter_update()" onChange="addnewfilter('1','hasvideo');">
      <span class="custom-control-label"></span> <?php echo __("Has Video","premiumpress") ?> </label>



<label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter" data-type="checkbox"   data-key="photosverified" data-value="1" onclick="_filter_update()" onChange="addnewfilter('1','photosverified');">
      <span class="custom-control-label"></span> <?php echo __("Photos Verified","premiumpress") ?> </label>



<label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter" data-type="checkbox"   data-key="verified" data-value="1" onclick="_filter_update()" onChange="addnewfilter('1','verified');">
      <span class="custom-control-label"></span> <?php echo __("Email Verified","premiumpress") ?> </label>

<?php } ?>
      
      
<?php if(in_array(THEME_KEY, array("ct") ) ){ ?>    
 
 
<label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter" data-type="checkbox"   data-key="status" data-value="1" onclick="_filter_update()" onChange="addnewfilter('1','status');" <?php if(!isset($_GET['status'])){ ?>checked=checked<?php } ?>>
      <span class="custom-control-label"></span> <?php echo __("Hide Sold Items","premiumpress") ?> </label>

<?php } ?>  


  <?php if(THEME_KEY == "mj"){ ?>
    
    
     <label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter" data-type="checkbox"   data-key="online" data-value="1" onclick="_filter_update()"  <?php if(isset($_GET['online'])){ ?>checked=checked<?php } ?>>
      <span class="custom-control-label"></span> <?php echo __("Online Sellers","premiumpress") ?> </label>

	<?php /*    
      <label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter" data-type="checkbox"   data-key="mjsold" data-value="1" onclick="_filter_update()" <?php if(isset($_GET['sold'])){ ?>checked=checked<?php } ?>>
      <span class="custom-control-label"></span> <?php echo __("Sold Jobs","premiumpress") ?> </label>
*/ ?>

<?php } ?>    
      
      
      
<?php /*      
      <?php if(THEME_KEY == "cp"){ ?>
      <label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter"  data-type="checkbox"   data-key="catid" data-value="1" onclick="_filter_update()">
      <span class="custom-control-label"></span> <?php echo __("Coupons","premiumpress") ?> </label>
      <label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter" data-type="checkbox"   data-key="catid" data-value="1" onclick="_filter_update()">
      <span class="custom-control-label"></span> <?php echo __("Offers","premiumpress") ?> </label>
      <label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter" data-type="checkbox"   data-key="catid" data-value="1" onclick="_filter_update()">
      <span class="custom-control-label"></span> <?php echo __("Prints","premiumpress") ?> </label>
      <label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter" data-type="checkbox"   data-key="catid" data-value="1" onclick="_filter_update()">
      <span class="custom-control-label"></span> <?php echo __("Used Today","premiumpress") ?> </label>
      <?php } ?>
      <?php if(in_array(THEME_KEY, array('at','ct','mj','dt','rt','da','so')) ){ ?>
      <label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter" data-type="checkbox"   data-key="catid" data-value="1" onclick="_filter_update()">
      <span class="custom-control-label"></span> <?php echo __("Verified Users","premiumpress"); ?> </label>
      <?php } ?>
      <?php if(_ppt('powerseller_price') > 0){ ?>
      <label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter" data-type="checkbox"   data-key="catid" data-value="1" onclick="_filter_update()">
      <span class="custom-control-label"></span> <?php echo __("Power Sellers","premiumpress") ?> </label>
      <?php } ?>
      
      <?php  if(in_array(THEME_KEY, array('ct','at'))){ ?>
      
      <label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter" data-type="checkbox"   data-key="catid" data-value="1" onclick="_filter_update()">
      <span class="custom-control-label"></span> <?php echo __("Refunds Accepted","premiumpress") ?> </label>
      <label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter" data-type="checkbox"   data-key="catid" data-value="1" onclick="_filter_update()">
      <span class="custom-control-label"></span> <?php echo __("Sold Items","premiumpress") ?> </label>
      <label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter" data-type="checkbox"   data-key="catid" data-value="1" onclick="_filter_update()">
      <span class="custom-control-label"></span> <?php echo __("Pickup Only","premiumpress") ?> </label>
 
      <?php } ?>




    
	  
      <?php if(THEME_KEY == "dt"){ ?>
      <label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter" data-type="checkbox"   data-key="catid" data-value="1" onclick="_filter_update()" onChange="addnewfilter('1','phone');" <?php if(isset($_GET['phone'])){ ?>checked=checked<?php } ?>>
      <span class="custom-control-label"></span> <?php echo __("With Phone Number","premiumpress") ?> </label>
      <?php } ?>
      
      
      <?php if(THEME_KEY == "at"){ ?>
      <label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input customfilter" data-type="checkbox"   data-key="status" data-value="1" onclick="_filter_update()" onChange="addnewfilter('1','status');" <?php if(!isset($_GET['status'])){ ?>checked=checked<?php } ?>>
      <span class="custom-control-label"></span> <?php echo __("Live Auctions","premiumpress") ?> </label>
      <?php } ?>
       
*/ ?>
	   
    </div>
  </div>
</div>
