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
   
   global $wpdb, $CORE, $settings;
   
   
   // GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
   $packagefields = get_option("packagefields");
   if(!is_array($packagefields)){ $packagefields = array(); }
   
    
   // GET LIST OF CATEGORIES FOR SELECTION
   $categorylist = $CORE->CategoryList(array(0,false,0,THEME_TAXONOMY,0,0,true));
   $categorylistarray = get_terms(THEME_TAXONOMY,"orderby=count&order=desc&get=all");
   $new_categorylistarray = array();
   foreach($categorylistarray as $cad){
   $new_categorylistarray[$cad->term_id] = $cad;
   }
   
   // PACKAGE FEATURES
   $pakfeatures = $CORE->PACKAGE("get_package_all_features", array());

	// GET LANGUAGES
	$langs = _ppt('languages');

 ?>
 
 
 
  <?php 
  $settings = array(
  
  "title" => __("Global Settings","premiumpress"), 
  
  "desc" => str_replace("%s", strtolower($CORE->LAYOUT("captions","1")), __("Global %s settings.","premiumpress") ) ,
  
  //"video" => "https://www.youtube.com/watch?v=RDx63RYwS38",
  
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>


<div class="card card-admin">
  <div class="card-body">
  
  
  
     <div class="row border-bottom pb-3 mb-3">
      <div class="col-md-8 ">
        <label class="font-weight-bold mb-2"><?php echo str_replace("%s", $CORE->LAYOUT("captions","2"), __("Enable %s","premiumpress") ); ?></label>
        <p class="text-muted"><?php echo str_replace("%s", strtolower($CORE->LAYOUT("captions","2")), __("Allow %s to be added to my website.","premiumpress") ); ?></p>
      </div>
      <div class="col-md-2 mt-3 formrow">
        <div class="">
          <label class="radio off">
          <input type="radio" name="toggle" 
                     value="off" onchange="document.getElementById('websitepackages').value='0'">
          </label>
          <label class="radio on">
          <input type="radio" name="toggle"
                     value="on" onchange="document.getElementById('websitepackages').value='1'">
          </label>
          <div class="toggle <?php if( _ppt(array('lst','websitepackages')) == '1'){  ?>on<?php } ?>">
            <div class="yes">ON</div>
            <div class="switch"></div>
            <div class="no">OFF</div>
          </div>
        </div>
        <input type="hidden" id="websitepackages" name="admin_values[lst][websitepackages]" value="<?php echo _ppt(array('lst','websitepackages')); ?>">
      </div>
    </div>
        
  
  
  
  		
       <div class="container px-0 border-bottom mb-3"> 
      <div class="row " <?php if( _ppt(array('lst','adminonly')) == '1'){  ?>style="border: 5px solid #dc3545!important;    padding: 10px;"<?php } ?>>
      <div class="col-md-8 ">
        <label class="font-weight-bold mb-2"><?php echo __("Admin Only Mode","premiumpress"); ?></label>
        <p class="text-muted"><?php 
		
		echo str_replace("%s", strtolower($CORE->LAYOUT("captions","2")), __("This will stop users from adding new %s.","premiumpress") );
		
		
		?></p>
        <?php if( _ppt(array('lst','adminonly')) == '1'){  ?>
        <p class="font-wight-bold text-danger"><i class="fa fa-check mr-2"></i> <?php echo __("Users listing have been disabled.","premiumpress"); ?></p>
        <?php } ?>
      </div>
      <div class="col-md-2 mt-3 formrow">
        <div class="">
          <label class="radio off">
          <input type="radio" name="toggle" 
                     value="off" onchange="document.getElementById('adminonly').value='0'">
          </label>
          <label class="radio on">
          <input type="radio" name="toggle"
                     value="on" onchange="document.getElementById('adminonly').value='1'">
          </label>
          <div class="toggle <?php if( _ppt(array('lst','adminonly')) == '1'){  ?>on<?php } ?>">
            <div class="yes">ON</div>
            <div class="switch"></div>
            <div class="no">OFF</div>
          </div>
        </div>
        <input type="hidden" id="adminonly" name="admin_values[lst][adminonly]" value="<?php echo _ppt(array('lst','adminonly')); ?>">
      </div>
    </div>
    
    </div>
    
        
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo __("How Many?","premiumpress"); ?></label>
          <p class="text-muted"><?php  echo str_replace("%s", strtolower($CORE->LAYOUT("captions","2")), __("How many %s can each member create?","premiumpress") );  ?></p>
          <?php /*if( $CORE->LAYOUT("captions","memberships") ){ ?>
          <p class="text-muted small"><span class="badge badge-info"><i class="fa fa-info"></i></span> <?php echo __("This can be combined with membership packages.","premiumpress"); ?></p>
          <?php } */ ?>
        </div>
        <div class="col-md-5">
          <?php
			   $g = _ppt(array('lst', 'onelistingonly'));
			   ?>
          <select name="admin_values[lst][onelistingonly]" class="mt-2 form-control" style="width:100%">
            <option value="0" <?php if( $g  == "0"){ echo "selected=selected"; } ?>><?php echo __("Unlimited","premiumpress"); ?></option>
            <option value="1" <?php if( $g  == "1"){ echo "selected=selected"; } ?>><?php echo __("Only One","premiumpress"); ?></option>
          </select>
        </div>
      </div>
    </div>
    <!-- ------------------------- -->
    <div class="container px-0 ">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo __("Admin Approval?","premiumpress"); ?></label>
          <p class="text-muted"><?php echo str_replace("%s", strtolower($CORE->LAYOUT("captions","1")), __("Does the admin need to manually approve a new %s before it goes live?","premiumpress") );  ?></p>
        </div>
        <div class="col-md-5">
          <?php
			   $g = _ppt(array('lst', 'default_listing_status'));
			   ?>
          <select name="admin_values[lst][default_listing_status]" class="mt-2 form-control" style="width:100%">
            <option value="publish" <?php if( $g == "publish"){ echo "selected=selected"; } ?>><?php echo __("No","premiumpress"); ?></option>
            <option value="pending" <?php if( $g == "pending"){ echo "selected=selected"; } ?>><?php echo __("Yes","premiumpress"); ?></option>
          </select>
        </div>
      </div>
    </div>
    <input type="hidden" id="requiremembership" name="admin_values[lst][requiremembership]" value="0">
  
  
    <?php if(THEME_KEY == "so" ){ ?>
    <div class="container px-0 border-top mb-3">
      <div class="row py-2">
        <div class="col-md-8 pr-lg-5">
          <label><?php echo __("Login To Download","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Force users to login before they can download products.","premiumpress"); ?></p>
        </div>
        <div class="col-md-2">
          <div class="mt-4 formrow">
            <label class="radio off">
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('requirelogin_downloads').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('requirelogin_downloads').value='1'">
            </label>
            <div class="toggle <?php if(_ppt(array('lst', 'requirelogin_downloads' )) == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="requirelogin_downloads" name="admin_values[lst][requirelogin_downloads]" value="<?php echo _ppt(array('lst', 'requirelogin_downloads' )); ?>">
        </div>
      </div>
    </div>
    
    
    
    
    
    <?php } ?>
  
  
      <?php if(THEME_KEY == "cp" ){ ?>
    <div class="container px-0 border-bottom border-top pt-3 mb-3">
      <div class="row py-2">
        <div class="col-md-6 pr-lg-5">
          <label><?php echo __("Search Card Terms Area","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Choose which content to show in the terms dropdown.","premiumpress"); ?></p>
        </div>
        <div class="col-md-6">
          <?php
			   $g = _ppt(array('lst', 'cpterms'));
			   ?>
          <select name="admin_values[lst][cpterms]" class="mt-2 form-control" style="width:100%">
            <option value="0" <?php if( $g  == "0"){ echo "selected=selected"; } ?>><?php echo __("Hide Section","premiumpress"); ?></option>
            <option value="1" <?php if( $g  == "1"){ echo "selected=selected"; } ?>>post excerpt</option>
            <option value="2" <?php if( $g  == "2"){ echo "selected=selected"; } ?>>post content</option>
          </select>
        </div>
      </div>
    </div>
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-8 pr-lg-5">
          <label><?php echo __("Cashback","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off the cachback system.","premiumpress"); ?></p>
        </div>
        <div class="col-md-2">
          <div class="mt-4 formrow">
            <label class="radio off">
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('cpcashback').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('cpcashback').value='1'">
            </label>
            <div class="toggle <?php if(_ppt(array('lst', 'cpcashback' )) == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="cpcashback" name="admin_values[lst][cpcashback]" value="<?php if(_ppt(array('lst', 'cpcashback' )) == ""){ echo 1; }else{ echo _ppt(array('lst', 'cpcashback' )); } ?>">
        </div>
      </div>
    </div>
  
     <?php if(_ppt(array('lst', 'cpcashback' )) == '1' && _ppt(array('user', 'cashout' )) != '1'){  ?>
    
    <div class="col-12 px-0">
    <div class="alert alert-warning">
   
    <p><?php echo __("To enable users to withdraw their cashback funds, please turn on the cashout system.","premiumpress"); ?></p>
     <a href="admin.php?page=settings&lefttab=user" class="btn btn-sm btn-warning"><?php echo __("Do it now","premiumpress"); ?></a>
    </div>
    </div>
    
    <?php } ?>
    
    <?php } ?>
    
    
    
    <?php if(in_array(THEME_KEY, array("mj")) ){ ?>
    <div class="container px-0 border-top mb-3 pt-3">
      <div class="row py-2">
        <div class="col-md-8 pr-lg-5">
          <label><?php echo __("Sellers Only","premiumpress"); ?></label>
          <p class="text-muted"><?php echo str_replace("%s", strtolower($CORE->LAYOUT("captions","2")), __("Turn ON to stop non-seller accounts adding %s.","premiumpress")); ?></p>
        </div>
        <div class="col-md-2">
          <div class="mt-4 formrow">
            <label class="radio off">
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('selleronly').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('selleronly').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('lst', 'selleronly')), array("1"))){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="selleronly" name="admin_values[lst][selleronly]" value="<?php  if(in_array(_ppt(array('lst', 'selleronly')), array("1"))){ echo 1; }else{ echo 0; } ?>">
        </div>
      </div>
    </div>
    <?php } ?>
    
    
    <?php if(THEME_KEY == "vt" ){ ?>
    <div class="container px-0 border-top mb-3 pt-3">
      <div class="row py-2">
        <div class="col-md-8 pr-lg-5">
          <label><?php echo __("Show Levels","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off the display of video levels on your website.","premiumpress"); ?></p>
        </div>
        <div class="col-md-2">
          <div class="mt-4 formrow">
            <label class="radio off">
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('vt_levels').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('vt_levels').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('lst', 'vt_levels')), array("","1"))){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="vt_levels" name="admin_values[lst][vt_levels]" value="<?php  if(in_array(_ppt(array('lst', 'vt_levels')), array("","1"))){ echo 1; }else{ echo 0; } ?>">
        </div>
      </div>
    </div>
    <?php } ?>
  
  
  </div>
</div>
<!-- end admin card -->
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
  
  
  
  
  
  
 
 <?php 
  $settings = array(
  
  "title" => __("Add/Edit","premiumpress")." ".$CORE->LAYOUT("captions","1"), 
  
  "desc" => str_replace("%s", strtolower($CORE->LAYOUT("captions","2")), __("These settings are applied when a user creates or edits their %s.","premiumpress") ) ,
  
  "video" => "https://www.youtube.com/watch?v=JnQZK97qDqo",
   
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>





<div class="row mb-4">
    
        <div class="col-lg-6 mb-4">  
        
        <div class="card p-4 shadow" style="background: #e43546;">   
        
       
        <h3 class="text-white">  <i class="fal fa-table mr-2"></i>
         <?php echo __("Pricing Tables","premiumpress"); ?></h3>
        <p class="text-white" style="font-size:16px;"><?php echo str_replace("%s", strtolower($CORE->LAYOUT("captions","1")), __("Create %s packages.","premiumpress") ); ?></p>
        
        <a href="#homepage" id="homepage-box1" data-targetdiv="packages" onclick="jQuery('.lefttab').val('packages-tab');" class="btn btn-sm btn-admin color3 mt-3 customlist"> <?php echo __("View Options","premiumpress"); ?></a>
        
        </div> 
    </div>
    
     <div class="col-lg-6 mb-4">
     
     
             <div class="card p-4 shadow" style="background: #0866c6;">   
        
       
        <h3 class="text-white">  <i class="fal fa-desktop mr-2"></i>
         <?php echo __("Page Layout","premiumpress"); ?></h3>
        <p class="text-white" style="font-size:16px;"><?php echo str_replace("%s", strtolower($CORE->LAYOUT("captions","1")), __("Edit the %s page layout.","premiumpress") ); ?></p>
        
        <a href="admin.php?page=design&lefttab=single" class="btn btn-sm btn-admin color3 mt-3 customlist"> <?php echo __("View Options","premiumpress"); ?></a>
        
        </div>
        
      
    
    	</div> 
    
    </div>








<div class="card card-admin">
  <div class="card-body">
  
  
  <?php if(THEME_KEY == "dt" ){ ?>
      <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-8 pr-lg-5">
          <label><?php echo __("Services Section","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off the option for users to enter their own services.","premiumpress"); ?></p>
        </div>
        <div class="col-md-2">
          <div class="mt-4 formrow">
            <label class="radio off">
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('dt_services').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('dt_services').value='1'">
            </label>
            <div class="toggle <?php  if(in_array(_ppt(array('lst', 'dt_services')), array("","1"))){ ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="dt_services" name="admin_values[lst][dt_services]" value="<?php if(in_array(_ppt(array('lst', 'dt_services')), array("","1"))){  }else{ echo 0; } ?>">
        </div>
      </div>
    </div>
    
    <?php } ?>


    <?php if(THEME_KEY == "at" ){ ?>
    
    <div class="container px-0 mt-3 border-bottom mb-3">
      <div class="row py-2 ">
        <div class="col-md-8 pr-lg-5">
          <label><?php echo __("Bidding Increments","premiumpress"); ?> </label>
          <p class="text-muted"><?php echo __("Here you can set the default bid increment.","premiumpress"); ?></p>
        </div>
        <div class="col-md-3 formrow">
          <div class="input-group mb-3">
            <div class="input-group-prepend"> <span class="input-group-text"><?php echo hook_currency_symbol(''); ?></span> </div>
            <input type="text" name="admin_values[lst][at_bidinc]" class="form-control val-numeric" value="<?php if(_ppt(array('lst', 'at_bidinc' )) == ""){ echo 1; }else{ echo _ppt(array('lst', 'at_bidinc' )); } ?>">
          </div>
        </div>
      </div>
    </div>
    
    
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-8 pr-lg-5">
          <label><?php echo __("Disable Auction Length","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn ON to use the package length instead of allowing users to set their own auction lenght.","premiumpress"); ?></p>
        </div>
        <div class="col-md-2">
          <div class="mt-4 formrow">
            <label class="radio off">
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('auction_time').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('auction_time').value='1'">
            </label>
            <div class="toggle <?php if(_ppt(array('lst', 'auction_time' )) == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="auction_time" name="admin_values[lst][auction_time]" value="<?php echo _ppt(array('lst', 'auction_time' )); ?>">
        </div>
      </div>
    </div>
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3 ">
      <div class="row py-2">
        <div class="col-md-5">
          <label><?php echo __("Auction Lengths","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Select which ones are available.","premiumpress"); ?></p>
        </div>
        <div class="col-md-7">
          <div class="row px-0">
            <?php 


$videopak = array( 
		
		"0.2" => __("15 Seconds","premiumpress"),
		"0.5" => __("1 Minutes","premiumpress"),
		"0.1" => __("3 Minutes","premiumpress"),
		"1" => "1 ".__("Days","premiumpress"), 
		"3" => "3 ".__("Days","premiumpress"), 
		"5" => "5 ".__("Days","premiumpress"), 
		"7" => "7 ".__("Days","premiumpress"),  
		
		
		
);

foreach($videopak as $k => $f ){ ?>
            <div class="col-md-4">
              <label class="custom-control custom-checkbox">
              <input type="checkbox" 
        value="1" 
       
        class="custom-control-input" 
        id="auctiontime_<?php echo str_replace(".","",$k); ?>check" 
        onchange="ChekAtime('#auctiontime_<?php echo str_replace(".","",$k); ?>');"
         
		<?php if(_ppt("auctiontime_".str_replace(".","",$k)) == 1){ ?>checked=checked<?php } ?>>
              <input type="hidden" name="admin_values[auctiontime_<?php echo str_replace(".","",$k); ?>]" id="auctiontime_<?php echo str_replace(".","",$k); ?>add" value="<?php if(in_array(_ppt("auctiontime_".str_replace(".","",$k)) , array("","1")) ){ echo 1; }else{ echo 0; } ?>">
              <span class="custom-control-label"><?php echo $f; ?></span> </label>
            </div>
            <?php  } ?>
          </div>
        </div>
      </div>
    </div>
    <script>
		function ChekAtime(div){
		
			if (jQuery(div+'check').is(':checked')) {			
				jQuery(div+'add').val(1);			
			}else{			
				jQuery(div+'add').val(0);
			}
		
		}
		</script>
    <?php } ?>
    
     <?php if(in_array(THEME_KEY, array("at")) ){ ?>
     
     <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-8 pr-lg-5">
          <label><?php echo __("Buy Now Only","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off the option for users to list a buy now auction.","premiumpress"); ?></p>
        </div>
        <div class="col-md-4">
       
          <div class="mt-2 formrow">
            <label class="radio off">
           
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('at_buynow').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('at_buynow').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('lst', 'at_buynow' )), array("1",""))){ ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="at_buynow" name="admin_values[lst][at_buynow]" value="<?php if(in_array(_ppt(array('lst', 'at_buynow' )), array("1",""))){ echo 1; }else{ echo 0; } ?>">
      
      </div></div></div>
     
     
     <?php } ?>

    <?php if(in_array(THEME_KEY, array("ct","dl")) ){ ?>
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-8 pr-lg-5">
          <label><?php echo __("Listing Types","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("By default both buy now and offers are enabled.","premiumpress"); ?></p>
        </div>
        <div class="col-md-4">
         <label><?php echo __("Buy Now Only","premiumpress"); ?></label>
          <div class="mt-2 formrow">
            <label class="radio off">
           
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('ct_buynow').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('ct_buynow').value='1'">
            </label>
            <div class="toggle <?php if(_ppt(array('lst', 'ct_buynow' )) == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="ct_buynow" name="admin_values[lst][ct_buynow]" value="<?php if(in_array(_ppt(array('lst', 'ct_buynow' )), array("1",""))){ echo 1; }else{ echo 0; } ?>">
      
        
          <label class="mt-4"><?php echo __("Make Offer Only","premiumpress"); ?></label>
          <div class="mt-2 formrow">
            <label class="radio off">
           
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('ct_buynow_offer').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('ct_buynow_offer').value='1'">
            </label>
            <div class="toggle <?php if(_ppt(array('lst', 'ct_buynow_offer' )) == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="ct_buynow_offer" name="admin_values[lst][ct_buynow_offer]" value="<?php echo _ppt(array('lst', 'ct_buynow_offer' )); ?>">
         
          </div>
        
      </div>
    </div>
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-8 pr-lg-5">
          <label><?php echo __("Disable Delivery Option","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn OFF the delivery option when add/editing a listing.","premiumpress"); ?></p>
        </div>
        <div class="col-md-2">
          <div class="mt-4 formrow">
            <label class="radio off">
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('ct_delivery').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('ct_delivery').value='1'">
            </label>
            <div class="toggle <?php if(_ppt(array('lst', 'ct_delivery' )) == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="ct_delivery" name="admin_values[lst][ct_delivery]" value="<?php echo _ppt(array('lst', 'ct_delivery' )); ?>">
        </div>
      </div>
    </div>
    <?php } ?>


    
    
    
    
    <?php if( THEME_KEY == "vt"  ){ ?>
    <input type="hidden" name="admin_values[lst][default_listing_require_image]" value="0">
    <?php }else{ ?>
    
    <?php if($CORE->LAYOUT("captions","maps") && _ppt(array('maps','enable')) == 1){ ?>
          <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-8 pr-lg-5">
          <label><?php echo __("Location Box","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off to hide the display of the map location box.","premiumpress"); ?></p>
        </div>
        <div class="col-md-2">
          <div class="mt-4 formrow">
            <label class="radio off">
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('default_location').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('default_location').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('lst', 'default_location')), array("","1"))){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="default_location" name="admin_values[lst][default_location]" value="<?php if(in_array(_ppt(array('lst', 'default_location')), array("","1"))){ echo 1; }else{ echo 0; } ?>">
        </div>
      </div>
    </div>
    <?php } ?>
    
    
          <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-8 pr-lg-5">
          <label><?php echo __("Image Uploads","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn  on/off the option for users to upload images.","premiumpress"); ?></p>
        </div>
        <div class="col-md-2">
          <div class="mt-4 formrow">
            <label class="radio off">
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('default_imguploads').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('default_imguploads').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('lst', 'default_imguploads')), array("","1"))){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="default_imguploads" name="admin_values[lst][default_imguploads]" value="<?php if(in_array(_ppt(array('lst', 'default_imguploads')), array("","1"))){ echo 1; }else{ echo 0; } ?>">
        </div>
      </div>
    </div>
    
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3 ">
      <div class="row py-2">
        <div class="col-md-8">
          <label><?php echo __("Image Required","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on to force the user to upload an image.","premiumpress"); ?></p>
        </div>
        <div class="col-md-2">
          <div  class="mt-3 formrow">
            <label class="radio off">
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('default_listing_require_image').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('default_listing_require_image').value='1'">
            </label>
            <div class="toggle <?php if(_ppt(array('lst', 'default_listing_require_image' )) == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="default_listing_require_image" name="admin_values[lst][default_listing_require_image]" value="<?php if(_ppt(array('lst', 'default_listing_require_image')) == ""){ echo 0; }else{ echo _ppt(array('lst', 'default_listing_require_image')); } ?>">
        </div>
      </div>
    </div>
    
    <?php } ?>
    
    
    
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-8 pr-lg-5">
          <label><?php echo __("Max. Title Length","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("The maximum character length for the title.","premiumpress"); ?></p>
        </div>
        <div class="col-md-3">
          <div class="input-group mb-3">
            <div class="input-group-prepend"> <span class="input-group-text">#</span> </div>
            <input type="text" name="admin_values[lst][titlemax]" class="form-control" value="<?php if(_ppt(array('lst', 'titlemax' )) == ""){ echo 150; }else{ echo _ppt(array('lst', 'titlemax' )); } ?>">
          </div>
        </div>
      </div>
    </div>
        
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-8 pr-lg-5">
          <label><?php echo __("Min. Description Length","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("The minimum amount of characters for the description.","premiumpress"); ?></p>
        </div>
        <div class="col-md-3">
          <div class="input-group mb-3">
            <div class="input-group-prepend"> <span class="input-group-text">#</span> </div>
            <input type="text" name="admin_values[lst][descmin]" class="form-control" value="<?php if(_ppt(array('lst', 'descmin' )) == ""){ echo 100; }else{ echo _ppt(array('lst', 'descmin' )); } ?>">
          </div>
        </div>
      </div>
    </div>
    
    
    
    
    
 <?php  _ppt_template('framework/admin/parts/listings-fields' ); ?> 
    


    
    
    
    
    
    
    
    
    <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
  </div>
</div>
<!-- end admin card -->
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
<?php

  $settings = array(
  
  "title" => __("Media Setting","premiumpress"), 
  "desc" => __("Here are additional media settings.","premiumpress") ,
  
  
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
<div class="card card-admin">
  <div class="card-body">
  
    <?php if( THEME_KEY == "vt"  ){ ?>
    <input type="hidden" name="admin_values[lst][default_listing_require_image]" value="0">
    <?php }else{ ?>
 
 
 
 <?php
 
 
 
  if( THEME_KEY == "dt"  ){ ?>
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7 pr-lg-5">
          <label><?php echo __("Screenshot Images","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Display a screenshot of the website if no other exists.","premiumpress"); ?></p>
       
       
       
       
        </div>
        <div class="col-md-5">
          <div class="mt-1 formrow">
            <label class="radio off">
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('default_screenshot').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('default_screenshot').value='1'">
            </label>
            <div class="toggle <?php if(_ppt(array('lst', 'default_screenshot' )) == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="default_screenshot" name="admin_values[lst][default_screenshot]" value="<?php echo _ppt(array('lst', 'default_screenshot' )); ?>">
          
          
          
                
      
          <?php $cfields = get_option("cfields");   ?>
          <label class="mt-4"><?php echo __("Which field holds the website link?","premiumpress"); ?></label>
          <div>
          <select class="form-control" name="admin_values[lst][default_screenshot_key]" >
          <?php 
		  $i=0;
		  foreach($cfields as $k=>$f){  
		  
		  if(isset($cfields['dbkey'][$i]) && $cfields['dbkey'][$i] !="" && isset($cfields['name'][$i]) && $cfields['name'][$i] != "" ){ ?>
          <option value="<?php  echo $cfields['dbkey'][$i]; ?>" <?php if($cfields['dbkey'][$i] == _ppt(array('lst','default_screenshot_key'))){ echo "selected=selected"; } ?>><?php echo $cfields['name'][$i]; ?></option>
          <?php } $i++; } ?> 
          
          </select>
          </div>
      <?php
	  
	  $providers = array(
	  
	  "thum" => "thum.io",
	  //"url2png" => "url2png",
	  
	  "browshot" => "browshot",
	 //"google" => "Google",
	  
	  );
	    
	  ?>
      
      
        <label class="mt-4"><?php echo __("Which screenshot provider to use?","premiumpress"); ?></label>
          <div>
          <select class="form-control" id="screenshot-sel" name="admin_values[lst][default_screenshot_provider]" onchange="showssss(this.value);">
          
          <?php 
		  $i=0;
		  foreach($providers as $k=>$f){  ?>
          <option value="<?php  echo $k; ?>" <?php if($k == _ppt(array('lst','default_screenshot_provider'))){ echo "selected=selected"; } ?>><?php echo $f; ?></option>
          <?php } ?> 
          
          </select>
          </div>
          
          <script>
		   jQuery(document).ready(function(){		   
		  	 
			 showssss(jQuery("#screenshot-sel").val())
			 
		   });
		   
		   function showssss(id){
		     	
				 	
		   		jQuery(".screenshot-service").hide();
			
				jQuery("#screenshots-"+id).show();
		   
		   }
		  </script>
          
          
          <div class="screenshot-service" id="screenshots-thum" style="display:none;">
          
              <label class="mb-2 mt-3">thum.io Auth Key (xxx-website) </label>
              <input type="text" name="admin_values[screenshots][thum_api]" value="<?php echo _ppt(array('screenshots','thum_api')); ?>" class="form-control">
              
              <p class="small mt-2 opacity-5">Visit Thumb.io <a href="https://www.thum.io/" target="_blank">here</a></p>
          
          </div>
          <?php /*
             <div class="screenshot-service" id="screenshots-url2png" style="display:none;">
          
              <label class="mb-2 mt-3">Auth Key</label>
              <input type="text" name="admin_values[screenshots][url2png_api]" value="<?php echo _ppt(array('screenshots','url2png_api')); ?>" class="form-control">
              
              <label class="mb-2 mt-3">Secret Key </label>
              <input type="text" name="admin_values[screenshots][url2png_secret]" value="<?php echo _ppt(array('screenshots','url2png_secret')); ?>" class="form-control">
             
              
              <p class="small mt-2 opacity-5">Visit url2png.com <a href="https://www.url2png.com/" target="_blank">here</a></p>
          
          </div>*/ ?>
          
             <div class="screenshot-service" id="screenshots-browshot" style="display:none;">
          
              <label class="mb-2 mt-3">API Key </label>
              <input type="text" name="admin_values[screenshots][browshot_api]" value="<?php echo _ppt(array('screenshots','browshot_api')); ?>" class="form-control">
              
              <label class="mb-2 mt-3">Instance ID </label>
              <input type="text" name="admin_values[screenshots][browshot_in]" value="<?php echo _ppt(array('screenshots','browshot_in')); ?>" class="form-control">
             
              
              <p class="small mt-2 opacity-5">Visit browshot.com <a href="https://www.browshot.com/" target="_blank">here</a></p>
          
          </div>
      
      
      </div>
          
          
      </div>
      
      
     
      </div>
      
 
 <?php } ?>
 
 
 
 
 
 
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3" <?php if(_ppt('pak0_enable') == "1" || _ppt('pak1_enable') == "1"){ echo "style='display:none;'"; } ?> >
      <div class="row py-2">
        <div class="col-md-8 pr-lg-5">
          <label><?php echo __("Max File Uploads","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Set the max number of files a member can upload.","premiumpress"); ?></p>
        </div>
        <div class="col-md-3">
          <div class="input-group mb-3">
            <div class="input-group-prepend"> <span class="input-group-text">#</span> </div>
            <input type="text" name="admin_values[lst][default_images]" class="form-control" value="<?php if(_ppt(array('lst','default_images')) == ""){ echo 10; }else{ echo _ppt(array('lst','default_images')); } ?>">
          </div>
        </div>
      </div>
    </div>
    
    
    
    
    <div class="container px-0 border-bottom mb-3" <?php if(_ppt('pak0_enable') == "1" || _ppt('pak1_enable') == "1"){ echo "style='display:none;'"; } ?>>
      <div class="row py-2">
        <div class="col-md-8 pr-lg-5">
          <label><?php echo __("Multiple Categories","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn ON to allow users to select multiple categories.","premiumpress"); ?></p>
        </div>
        <div class="col-md-2">
          <div class="mt-4 formrow">
            <label class="radio off">
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('default_multiplecats').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('default_multiplecats').value='1'">
            </label>
            <div class="toggle <?php if(_ppt(array('lst', 'default_multiplecats' )) == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="default_multiplecats" name="admin_values[lst][default_multiplecats]" value="<?php echo _ppt(array('lst', 'default_multiplecats' )); ?>">
        </div>
      </div>
    </div>
  
  

    
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3 ">
      <div class="row py-2">
        <div class="col-md-8">
          <label><?php echo __("Crop Images","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off the built-in crop system.","premiumpress"); ?></p>
        </div>
        <div class="col-md-4">
          <div  class=" formrow">
            <label class="radio off">
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('default_crop').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('default_crop').value='1'">
            </label>
            <div class="toggle <?php if(_ppt(array('lst', 'default_crop' )) == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="default_crop" name="admin_values[lst][default_crop]" value="<?php if(in_array(_ppt(array('lst', 'default_crop')), array("1") ) ){ echo 1; }else{ echo 0; }?>">
          
          
              <?php
			   $g = _ppt(array('lst', 'default_crop_bg'));
			   ?>
          <select name="admin_values[lst][default_crop_bg]" class="mt-2 form-control" style="width:100%">
            <option value="0" <?php if( $g  == "0"){ echo "selected=selected"; } ?>><?php echo __("White Background","premiumpress"); ?></option>           
            
            <option value="1" <?php if( $g  == "1"){ echo "selected=selected"; } ?>><?php echo __("Black Background","premiumpress"); ?></option>   
         
          </select>
          
        </div>
      </div>
    </div>
    
    
    <?php } ?>
    
    
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-8 pr-lg-5">
          <label><?php echo __("Hide Featured Image","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn ON to hide the first image from the image gallery on the listing page.","premiumpress"); ?></p>
        </div>
        <div class="col-md-2">
          <div class="mt-4 formrow">
            <label class="radio off">
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('hide_featuredimage').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('hide_featuredimage').value='1'">
            </label>
            <div class="toggle <?php if(_ppt(array('lst', 'hide_featuredimage' )) == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="hide_featuredimage" name="admin_values[lst][hide_featuredimage]" value="<?php echo _ppt(array('lst', 'hide_featuredimage' )); ?>">
        </div>
      </div>
    </div>
    
     <?php if(!in_array(THEME_KEY, array("cp")) ){ ?>
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3 ">
      <div class="row py-2">
        <div class="col-md-5">
          <label><?php echo __("Video Uploads","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Select which services are available.","premiumpress"); ?></p>
        </div>
        <div class="col-md-7">
          <div class="row px-0">
            <?php 


$videopak = array(

	1 => array("key" => "basic", "name" => "User" ),
	2 => array("key" => "youtube", "name" => "YouTube" ),
	3 => array("key" => "vimeo", "name" => "Vimeo" ),
	
);

foreach($videopak as $k => $f ){ ?>
            <div class="col-md-4">
              <label class="custom-control custom-checkbox">
              <input type="checkbox" 
        value="1" 
       
        class="custom-control-input" 
        id="videoupload_<?php echo $f['key']; ?>check" 
        onchange="ChekVidPak('#videoupload_<?php echo $f['key']; ?>');"
         
		<?php if(_ppt("videoupload_".$f['key']) == 1){ ?>checked=checked<?php } ?>>
              <input type="hidden" name="admin_values[videoupload_<?php echo $f['key']; ?>]" id="videoupload_<?php echo $f['key']; ?>add" value="<?php if(_ppt("videoupload_".$f['key']) == "" || _ppt("videoupload_".$f['key']) == 1){ echo 1; }else{ echo 0; } ?>">
              <span class="custom-control-label"><?php echo $f['name']; ?></span> </label>
            </div>
            <?php  } ?>
          </div>
        </div>
      </div>
    </div>
    <script>
		function ChekVidPak(div){
		
			if (jQuery(div+'check').is(':checked')) {			
				jQuery(div+'add').val(1);			
			}else{			
				jQuery(div+'add').val(0);
			}
		
		}
		</script>
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3 ">
      <div class="row py-2">
        <div class="col-md-8">
          <label><?php echo __("Video Auto Play","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off the video auto play feature.","premiumpress"); ?></p>
        </div>
        <div class="col-md-2">
          <div  class="mt-3 formrow">
            <label class="radio off">
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('videoautoplay').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('videoautoplay').value='1'">
            </label>
            <div class="toggle <?php if(_ppt(array('lst', 'videoautoplay' )) == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="videoautoplay" name="admin_values[lst][videoautoplay]" value="<?php if(_ppt(array('lst', 'videoautoplay')) == ""){ echo 0; }else{ echo _ppt(array('lst', 'videoautoplay')); } ?>">
        </div>
      </div>
    </div>
    <?php } ?>
    
    <?php if(THEME_KEY == "vt" ){ ?>
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-8 pr-lg-5">
          <label><?php echo __("Login To Watch Videos","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Force users to login before they can watch all videos.","premiumpress"); ?></p>
        </div>
        <div class="col-md-2">
          <div class="mt-4 formrow">
            <label class="radio off">
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('requirelogin_videos').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('requirelogin_videos').value='1'">
            </label>
            <div class="toggle <?php if( _ppt(array('lst', 'requirelogin_videos' )) == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="requirelogin_videos" name="admin_values[lst][requirelogin_videos]" value="<?php echo _ppt(array('lst', 'requirelogin_videos' )); ?>">
        </div>
      </div>
    </div>
    <?php } ?>
    <?php /*

      <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-6 pr-lg-5">
          <label><?php echo __("Image Display Mode","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Choose how you want to display images on your website.","premiumpress"); ?></p>
        </div>
        <div class="col-md-6">
          
             <?php
			   $g = _ppt(array('lst', 'imagemode'));
			   ?>
          <select name="admin_values[lst][imagemode]" class="mt-2 form-control" style="width:100%">
            <option value="0" <?php if( $g  == "0"){ echo "selected=selected"; } ?>><?php echo __("Responsive (mixed heights)","premiumpress"); ?></option>           
            
            <option value="1" <?php if( $g  == "1"){ echo "selected=selected"; } ?>><?php echo __("Portrait (height 260px)","premiumpress"); ?></option>   
            <option value="2" <?php if( $g  == "2"){ echo "selected=selected"; } ?>><?php echo __("Portrait (height 300px)","premiumpress"); ?></option>          
           
            <option value="3" <?php if( $g  == "3"){ echo "selected=selected"; } ?>><?php echo __("Landscape (height 180px)","premiumpress"); ?></option>
         	<option value="4" <?php if( $g  == "4"){ echo "selected=selected"; } ?>><?php echo __("Landscape (height 220px)","premiumpress"); ?></option>
         
         
          </select>
          
         </div>    
      </div>
    </div>  
	*/ ?>
    <div class="row mt-4">
      <div class="col-lg-6 mb-4 mb-lg-0">
        <label><?php echo __("Fallback Image","premiumpress"); ?></label>
        <p class="text-muted"><?php echo __("This is the image that will be displayed when no other image is assigned to the listing.","premiumpress"); ?></p>
        <p class="text-muted"><?php echo __("Recommended size","premiumpress"); ?>: 1024x748px</p>
      </div>
      <div class="col-lg-6 mb-4 mb-lg-0">
        <input type="hidden" 
               id="up_fallback_image_aid" 
               name="admin_values[lst][fallback_image_aid]" 
               value="<?php echo _ppt(array('lst', "fallback_image_aid" )); ?>"  />
        <input 
               name="admin_values[lst][fallback_image]" 
               type="hidden" 
               id="up_fallback_image" 
               value="<?php if( _ppt(array('lst', 'fallback_image')) != ""){  echo _ppt(array('lst', 'fallback_image')); } ?>" />
        <?php if( substr(_ppt(array('lst', 'fallback_image')) ,0,4) == "http"){ ?>
        <div class="pptselectbox bg-light p-5 text-center  mb-2 border"> <img src="<?php echo _ppt(array('lst', 'fallback_image')); ?>" style="max-width:100%; max-height:300px;" id="fallback_image_preview" /> </div>
        <div class="pptselectbtns"> <a href="<?php echo _ppt(array('lst', 'fallback_image')); ?>" target="_blank" class="btn btn-secondary  rounded-0" style="font-size: 10px;">View </a> <a href="javascript:void(0);"id="editImg_fallback_image" class="btn btn-secondary  rounded-0" style="font-size: 10px;">Edit </a> <a href="javascript:void(0);" id="upload_fallback_image" class="btn btn-secondary  rounded-0" style="font-size: 10px;">Change </a> <a href="javascript:void(0);" onclick="jQuery('#up_fallback_image').val('');document.admin_save_form.submit();" class="btn btn-secondary  rounded-0" style="font-size: 10px;">Delete</a> </div>
        <?php }else{ ?>
        <div class="pptselectbox bg-dark p-5 text-center  mb-2"> <a href="javascript:void(0);" id="upload_fallback_image"  class="btn btn-system btn-sm">
          <div>select image</div>
          <div>.jpeg/ .png</div>
          </a> </div>
        <?php } ?>
      </div>
    </div>
    <script >
               jQuery(document).ready(function () {
               
               	jQuery('#editImg_fallback_image').click(function() {           
               			   	 
               		tb_show('', 'media.php?attachment_id=<?php echo _ppt(array('lst', "fallback_image_aid" )); ?>&action=edit&amp;TB_iframe=true');
               					 
               		return false;
               	});
               	
               	jQuery('#upload_fallback_image').click(function() {           
               	
               		ChangeAIDBlock('up_fallback_image_aid');
               		ChangeImgBlock('up_fallback_image');		
               		ChangeImgPreviewBlock('fallback_image_preview')
               		
               		formfield = jQuery('#up_fallback_image').attr('name');
               	 
               		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
					
					
               			return false;
               	});
               					
               });	
            </script>
    <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
  </div>
</div>
<!-- end admin card -->
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
 

 
<?php
 if( THEME_KEY == "vt"){
  $settings = array("title" => __("Video Preview","premiumpress"), "desc" => __("Here you can enable video previews.","premiumpress") );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
<div class="card card-admin">
  <div class="card-body">
    <div class="container px-0  border-bottom mb-3">
      <div class="row">
        <div class="col-8">
          <label>Video Preview</label>
          <p class="text-muted">Turn on/off video preview  options.</p>
        </div>
        <div class="col-3">
          <div class="mt-3">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('videopreview_enable').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('videopreview_enable').value='1'">
            </label>
            <div class="toggle <?php if(_ppt(array('lst', 'videopreview_enable')) == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="videopreview_enable" name="admin_values[lst][videopreview_enable]" value="<?php echo _ppt(array('lst', 'videopreview_enable')); ?>">
        </div>
      </div>
    </div>
    <div class="container px-0  border-bottom mb-3">
      <div class="row py-2">
        <div class="col-8">
          <label>Video Preview Length</label>
          <p class="text-muted">Enter a value in seconds. </p>
        </div>
        <div class="col-4">
          <div class="input-group"> <span class="input-group-prepend input-group-text">#</span>
            <input type="text" class="form-control btn-block"  name="admin_values[lst][videopreview_seconds]" value="<?php if(is_numeric(_ppt(array('lst', 'videopreview_seconds')))){ echo _ppt(array('lst', 'videopreview_seconds')); }else{ echo 20; } ?>" style="max-width:100px">
          </div>
        </div>
      </div>
    </div>
    <div class="container px-0  border-bottom mb-3">
      <div class="row py-2">
        <div class="col-12">
          <label>Message</label>
          <p class="text-muted">Displayed to the user when the time has run down. </p>
        </div>
        <div class="col-12">
          <textarea class="form-control"  style="height:200px !important;font-size:11px;" name="admin_values[lst][videopreview_message]"><?php echo stripslashes(_ppt(array('lst', 'videopreview_message'))); ?></textarea>
        </div>
      </div>
    </div>
    <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
  </div>
</div>
<!-- end admin card -->
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
<?php } ?>
<?php
 if(in_array(THEME_KEY, array("mj","at","ct")) ){
  $settings = array(
  
  "title" => __("House Commission","premiumpress"), 
  "video" => "https://www.youtube.com/watch?v=YEfXPOG0sqY",
  "desc" => str_replace("%s", strtolower($CORE->LAYOUT("captions","2")),__("Here you can charge users a percentage for %s sold.","premiumpress")) 
  
  );
  
  
  
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
<div class="card card-admin">
  <div class="card-body">
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo __("Commission","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Set a percentage or a fixed amount.","premiumpress"); ?></p>
        </div>
        <div class="col-md-5">
        
        
          <div class="input-group"> <span class="input-group-prepend input-group-text">%</span>
            <input type="text" class="form-control btn-block"  name="admin_values[lst][house_comission]" value="<?php if(is_numeric(_ppt(array('lst', 'house_comission')))){ echo _ppt(array('lst', 'house_comission')); }else{ echo 0; } ?>" style="max-width:100px">
          </div>
          
                    <div class="input-group mt-3"> <span class="input-group-prepend input-group-text"><?php echo hook_currency_symbol(''); ?></span>
            <input type="text" class="form-control btn-block"  name="admin_values[lst][house_comission_fixed]" value="<?php if(is_numeric(_ppt(array('lst', 'house_comission_fixed')))){ echo _ppt(array('lst', 'house_comission_fixed')); }else{ echo 0; } ?>" style="max-width:100px">
          </div>
          
          
        </div>
      </div>
    </div>
    <div class="container px-0  border-bottom mb-3">
      <div class="row">
        <div class="col-8">
          <label><?php echo __("Commission Invoice","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off the commission invoice.","premiumpress"); ?></p>
        </div>
        <div class="col-3">
          <div class="mt-3">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('house_comission_invoice').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('house_comission_invoice').value='1'">
            </label>
            <div class="toggle <?php if(_ppt(array('lst', 'house_comission_invoice')) == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="house_comission_invoice" name="admin_values[lst][house_comission_invoice]" value="<?php echo _ppt(array('lst', 'house_comission_invoice')); ?>">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <h6><?php echo __("Commission Invoice On","premiumpress"); ?></h6>
        <p><?php echo __("After a seller has successfully completed an order, a new invoice with the commission amount is added to the sellers account so they can pay separately.","premiumpress"); ?> </p>
        <ul class="mt-2 small">
          <li><i class="fa fa-check mr-2"></i> <?php echo __("More protection for website owner","premiumpress"); ?></li>
          <li><i class="fa fa-check mr-2"></i> <?php echo __("Easier for accountant","premiumpress"); ?></li>
          <li><i class="fa fa-times mr-2"></i> <?php echo __("One extra step for user","premiumpress"); ?></li>
        </ul>
      </div>
      <div class="col-md-6">
        <h6><?php echo __("Commission Invoice Off","premiumpress"); ?></h6>
        <p><?php echo __("After a seller has successfully completed an order, the sellers account is automatically deducted the house comission. No invoice is added.","premiumpress"); ?> </p>
        <ul class="mt-2 small">
          <li><i class="fa fa-check mr-2"></i> <?php echo __("Easier process","premiumpress"); ?></li>
          <li><i class="fa fa-times mr-2"></i> <?php echo __("Less protection for website owner","premiumpress"); ?></li>
        </ul>
      </div>
    </div>
    <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
  </div>
</div>
<!-- end admin card -->
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
<?php } ?>
<?php
 
  $settings = array("title" => __("Listing Expiry","premiumpress"), "desc" => str_replace("%s", strtolower($CORE->LAYOUT("captions","1")), __("Here you can set what happens when a %s expires.","premiumpress") ) );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
<div class="card card-admin">
  <div class="card-body">
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo __("Change Status?","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Should the theme update the post status?","premiumpress"); ?></p>
        </div>
        <div class="col-md-5">
          <?php
			   $g = _ppt(array('lst', 'expiryaction'));
			   ?>
          <select name="admin_values[lst][expiryaction]" class="mt-2 form-control" style="width:100%">
            <option value="0" <?php if( $g  == "0"){ echo "selected=selected"; } ?>><?php echo __("Do nothing","premiumpress"); ?></option>
            <option value="1" <?php if( $g  == "1"){ echo "selected=selected"; } ?>>
            <?php if(THEME_KEY == "cp"){ echo __("Set to expired","premiumpress"); }else{ echo __("Set to expired - user to repay","premiumpress"); } ?>
            </option>
            <option value="2" <?php if( $g  == "2"){ echo "selected=selected"; } ?>><?php echo __("Delete listing","premiumpress"); ?></option>
          </select>
        </div>
      </div>
    </div>
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo __("Change Listing Package?","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Should the theme change the listing package?","premiumpress"); ?></p>
        </div>
        <div class="col-md-5">
          <?php
			   $g = _ppt(array('lst', 'expirypackage'));
			   ?>
          <select name="admin_values[lst][expirypackage]" class="mt-2 form-control" style="width:100%">
            <option value="0" <?php if( $g  == "0"){ echo "selected=selected"; } ?>><?php echo __("Do nothing","premiumpress"); ?></option>
            <option value="pak0" <?php if( $g  == "pak0"){ echo "selected=selected"; } ?>><?php echo __("Set to","premiumpress")." "._ppt('pak0_name'); ?></option>
            <option value="pak1" <?php if( $g  == "pak1"){ echo "selected=selected"; } ?>><?php echo __("Set to","premiumpress")." "._ppt('pak1_name'); ?></option>
            <option value="pak2" <?php if( $g  == "pak2"){ echo "selected=selected"; } ?>><?php echo __("Set to","premiumpress")." "._ppt('pak2_name'); ?></option>
          </select>
        </div>
      </div>
    </div>
    <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
  </div>
</div>
<script>
		function ChekME(div){
		
			if (jQuery(div+'check').is(':checked')) {			
				jQuery(div+'add').val(1);			
			}else{			
				jQuery(div+'add').val(0);
			}
		
		}
		 
		function changeCheckB(div){
			
			if (jQuery('#'+div+'_check').hasClass('fa-check')) {			
				jQuery('#'+div).val(0);	
				jQuery('#'+div+'_check').removeClass('fa-check text-success').addClass('fa-times text-danger');		
			}else{			
				jQuery('#'+div).val(1);	
				jQuery('#'+div+'_check').removeClass('fa-times text-danger').addClass('fa-check text-success');	
			}
					
				
		}
</script>
<!-- end admin card -->
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
