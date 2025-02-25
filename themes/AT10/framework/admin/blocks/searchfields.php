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

global $wpdb, $CORE, $CORE_ADMIN;


?>


<div class="container px-0 border-bottom mb-3">
            <div class="row py-2">
              <div class="col-md-8 pr-lg-5">
                <label><?php echo __("Search Results","premiumpress"); ?></label>
                <p class="text-muted"><?php echo __("Here you can set the number of search results per page.","premiumpress"); ?></p>
              </div>
              <div class="col-md-3">
                <div class="input-group mb-3">
                  <div class="input-group-prepend"> <span class="input-group-text">#</span> </div>
                  <input type="text" name="adminArray[posts_per_page]" class="form-control" value="<?php echo get_option('posts_per_page'); ?>">
                </div>
              </div>
            </div>
          </div>
          
          
<?php if( _ppt(array('maps','enable')) == "1"){ ?>
<div class="container px-0 border-bottom mb-3">
            <div class="row py-2">
              <div class="col-md-8 pr-lg-5">
                <label><?php echo __("Search Distance Metric","premiumpress"); ?></label>
                <p class="text-muted"><?php echo __("Here you can set which metric system to use for search calculations.","premiumpress"); ?></p>
              </div>
              <div class="col-md-3">
                <div class="input-group mb-3">
                   
     <select name="admin_values[search][mapmetric]" class="form-control mb-4">
     
      <option value="0"><?php echo __("miles","premiumpress"); ?></option>
      
      <option value="1" <?php  if( _ppt(array('search','mapmetric')) == "1"){ echo "selected=selected"; } ?>><?php echo __("kilometers","premiumpress"); ?></option>
      
     
      </select>
                
                
                
                </div>
              </div>
            </div>
          </div>
<?php } ?>

<div class="container px-0 border-bottom mb-3 ">
  <div class="row py-2">
    <div class="col-md-9">
      <label class="txt500"><?php echo __("Require Login","premiumpress"); ?></label>
      <p class="text-muted"><?php echo __("Stops non-members from using the search page.","premiumpress"); ?></p>
      
      <div <?php if(_ppt(array("search","mustlogin")) != 1){  ?>style="display:none"<?php } ?>>
      <div class="small mb-2 text-danger"><i class="fa fa-link"></i> <?php echo __("Redirect user to this link","premiumpress"); ?>;</div>
      
      <input type="text" value="<?php if(_ppt(array("search","mustlogin_link")) == ""){ echo wp_login_url(); }else{ echo _ppt(array("search","mustlogin_link")); } ?>" class="form-control" name="admin_values[search][mustlogin_link]" />
      
      </div>
      
      
    </div>
    <div class="col-md-3">
      <div  class="mt-3 formrow">
        <label class="radio off">
        <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('mustlogin').value='0'">
        </label>
        <label class="radio on">
        <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('mustlogin').value='1'">
        </label>
        <div class="toggle <?php if(_ppt(array("search","mustlogin")) == 1){  ?>on<?php } ?>">
          <div class="yes">ON</div>
          <div class="switch"></div>
          <div class="no">OFF</div>
        </div>
      </div>
      <input type="hidden" id="mustlogin" name="admin_values[search][mustlogin]" value="<?php if(_ppt(array("search","mustlogin")) == ""){ echo 0; }else{ echo _ppt(array("search","mustlogin")); } ?>">
    </div>
  </div>
</div>



<div class="container px-0 border-bottom mb-3 ">
  <div class="row py-2">
    <div class="col-md-9">
      <label class="txt500"><?php echo __("Show Expired","premiumpress"); ?></label>
      <p class="text-muted"><?php echo __("This will included expired items in your search results.","premiumpress"); ?></p>
      
      
      
    </div>
    <div class="col-md-3">
      <div  class="mt-3 formrow">
        <label class="radio off">
        <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('showexpired').value='0'">
        </label>
        <label class="radio on">
        <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('showexpired').value='1'">
        </label>
        <div class="toggle <?php if(_ppt(array("search","showexpired")) == 1){  ?>on<?php } ?>">
          <div class="yes">ON</div>
          <div class="switch"></div>
          <div class="no">OFF</div>
        </div>
      </div>
      <input type="hidden" id="showexpired" name="admin_values[search][showexpired]" value="<?php if(_ppt(array("search","showexpired")) == ""){ echo 0; }else{ echo _ppt(array("search","showexpired")); } ?>">
    </div>
  </div>
</div>


<div class="container px-0 border-bottom mb-3">
            <div class="row py-2">
              <div class="col-md-8 pr-lg-5">
                <label><?php echo __("Show/Hide Amount","premiumpress"); ?></label>
                <p class="text-muted"><?php echo __("Here you can set the number of items to display before the show/hide is shown.","premiumpress"); ?></p>
              </div>
              <div class="col-md-3">
                <div class="input-group mb-3">
                  <div class="input-group-prepend"> <span class="input-group-text">#</span> </div>
                  <input type="text" name="admin_values[search][showhide]" class="form-control" value="<?php if(_ppt(array('search','showhide')) == ""){ echo 5; }else{ echo _ppt(array('search','showhide')); } ?>">
                </div>
              </div>
            </div>
          </div>

<?php
$filters = $CORE->LAYOUT("captions","filters");
if(is_array($filters)){

	foreach($filters as $filter){
	
	$show = true;
	 
 
 
 ?>
<!-- ------------------------- -->

<div class="container px-0 border-bottom mb-3 " <?php if(!$show){ ?>style="display:none;"<?php } ?>>
  <div class="row py-2">
    <div class="col-md-9">
      <label class="txt500"><?php if($filter == "countrylist"){ echo __("Country Filter (list style)","premiumpress"); }else{ echo ucfirst($filter)." ".__("Filter","premiumpress"); } ?></label>
      <p class="text-muted"><?php echo __("Turn on/off this filter on the search page.","premiumpress"); ?></p>
    </div>
    <div class="col-md-3">
      <div  class="mt-3 formrow">
        <label class="radio off">
        <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('filter_<?php echo $filter; ?>').value='0'">
        </label>
        <label class="radio on">
        <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('filter_<?php echo $filter; ?>').value='1'">
        </label>
        <div class="toggle <?php if(_ppt(array("search","filters_".$filter)) == 1){  ?>on<?php } ?>">
          <div class="yes">ON</div>
          <div class="switch"></div>
          <div class="no">OFF</div>
        </div>
      </div>
      <input type="hidden" id="filter_<?php echo $filter; ?>" name="admin_values[search][filters_<?php echo $filter; ?>]" value="<?php if(!$show){ echo 0; }elseif(_ppt(array("search","filters_".$filter)) == ""){ echo 1; }else{ echo _ppt(array("search","filters_".$filter)); } ?>">
    </div>
  </div>
</div>
<!-- ------------------------- -->
<?php
	 
	} 
} 
?>

 