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

global $settings, $CORE;

$memnames = array( __("No Membership","premiumpress"), 'Bronze','Silver','Gold','','','','','','','' );

// GET LANGUAGES
$langs = _ppt('languages');

// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

// SAVE CUSTOM FIELD DATE
if(isset($_POST['csubscriptions']) && current_user_can('administrator') ){

update_option("csubscriptions", $_POST['csubscriptions']);
}
  
$csubscriptions = get_option("csubscriptions"); 
 
if(!is_array($csubscriptions)){ $csubscriptions = array(); }  
 
// SETUP ARRAY FOR EXISTING KEYS
// ENCASE THE USER HASNT REALISED THEY ARE THE SAME
$ekeys = array();
  
?>

<div class="">
  <div class="row">
    <div class="col-md-4 pr-lg-4">
      <h3 class="mt-4"><?php echo __("Memberships","premiumpress"); ?></h3>
      <p class="text-muted lead mb-4"><?php echo __("Turn on/off the entire membership system.","premiumpress"); ?>.</p>
      
     
       <a href="https://www.youtube.com/watch?v=bgwQMsW-OT8" class="btn btn-danger shadow-sm btn-sm px-3 popup-yt mb-4"><i class="fa fa-video mr-1"></i> <?php echo __("watch video","premiumpress"); ?></a>
      
      
    </div>
    <div class="col-md-8">
      <div class="card card-admin">
        <div class="card-body">
        
        
        
        
          <div class="row border-bottom pb-3 mb-3">
            <div class="col-md-8 ">
              <label class="font-weight-bold mb-2"><?php echo __("Enable Memberships","premiumpress"); ?></label>
              <p class="text-muted"><?php echo __("If disabled all listings will have free access.","premiumpress"); ?></p>
            </div>
            <div class="col-md-2 mt-3 formrow">
              <div class="">
                <label class="radio off">
        <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('enable_memberships').value='0'">
        </label>
        <label class="radio on">
        <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('enable_memberships').value='1'">
        </label>
        <div class="toggle <?php if(_ppt(array('mem','enable'))  == '1'){  ?>on<?php } ?>">
          <div class="yes">ON</div>
          <div class="switch"></div>
          <div class="no">OFF</div>
        </div>
      </div>
      <input type="hidden" id="enable_memberships" name="admin_values[mem][enable]" value="<?php if(_ppt(array('mem','enable')) == ""){ echo 0; }else{ echo _ppt(array('mem','enable')); } ?>">
            </div>
          </div> 
          
          
          <div class="row border-bottom pb-3 mb-3">
            <div class="col-md-8 ">
              <label class="font-weight-bold mb-2"><?php echo __("Force Membership","premiumpress"); ?></label>
              <p class="text-muted"><?php echo __("Stop users from joining the website and using website features until they have an active membership.","premiumpress"); ?></p>
            </div>
            <div class="col-md-2 mt-3 formrow">
              <div class="">
                <label class="radio off">
        <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('register_memberships').value='0'">
        </label>
        <label class="radio on">
        <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('register_memberships').value='1'">
        </label>
        <div class="toggle <?php if(_ppt(array('mem','register'))  == '1'){  ?>on<?php } ?>">
          <div class="yes">ON</div>
          <div class="switch"></div>
          <div class="no">OFF</div>
        </div>
      </div>
      <input type="hidden" id="register_memberships" name="admin_values[mem][register]" value="<?php if(_ppt(array('mem','register')) == ""){ echo 0; }else{ echo _ppt(array('mem','register')); } ?>">
            </div>
          </div> 
          
          
          
        
          <div class="row border-bottom pb-3 mb-3">
            <div class="col-md-8 ">
              <label class="font-weight-bold mb-2"><?php echo __("Enable Extra Time","premiumpress"); ?></label>
              <p class="text-muted"><?php echo __("Turn ON if you want a users remaining package length to be added to any new purchases.","premiumpress"); ?></p>
            </div>
            <div class="col-md-2 mt-3 formrow">
              <div class="">
                <label class="radio off">
        <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('mem_paktime').value='0'">
        </label>
        <label class="radio on">
        <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('mem_paktime').value='1'">
        </label>
        <div class="toggle <?php if(in_array(_ppt(array('mem','paktime')), array("","1"))){ ?>on<?php } ?>">
          <div class="yes">ON</div>
          <div class="switch"></div>
          <div class="no">OFF</div>
        </div>
      </div>
      <input type="hidden" id="mem_paktime" name="admin_values[mem][paktime]" value="<?php if(in_array(_ppt(array('mem','paktime')), array("","1"))){ echo 0; }else{ echo 0; } ?>">
            </div>
          </div> 
          
          
          
          <div class="container px-0 border-bottom mb-3" <?php if(_ppt(array('mem','register'))  == '1'){?>style="display:none;"<?php } ?>>
            <div class="row py-2">
              <div class="col-6">
                <label class="txt500"><?php echo __("Free Membership","premiumpress"); ?></label>
                <p class="text-muted"><?php echo __("Here you can set a default membership for all new user accounts when they join your website.","premiumpress"); ?></p>
              </div>
              <div class="col-6">
                <?php

	$status = array( "" => "None");
	// ADD ON MEMBERSHIPS
	$i=1; 
	while($i < 11){ 	
	
	
		if(_ppt('mem'.$i.'_name') == ""){ $n =  $memnames[$i]; }else{ $n =  _ppt('mem'.$i.'_name'); } 			
		if($n == ""){ $i++; continue; }
			
		$status['mem'.$i] = $n;
		$i++;
	}
 
	
	?>
                <select name="admin_values[mem][regmembership]"   class="form-control" style="widht:100%;">
                  <?php foreach($status as $key => $club){ ?>
                  <option value="<?php echo $key; ?>" <?php if(_ppt(array('mem','regmembership')) == $key){  echo "selected=selected"; } ?>><?php echo $club; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          
          
     
          
          
          
          
          
          
          
          
          
          <!-- ------------------------- -->
            <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
          
           </div>
          </div>
          
          

<?php _ppt_template('framework/admin/_form-wrap-bottom' );?>







<?php
 
 
 
  $settings = array(
  
  "title" => __("Membership Packages","premiumpress"), 
  "desc" => __("Here you can create your membership packages and set pricing options.","premiumpress") );
  
   _ppt_template('framework/admin/_form-wrap-top' ); 
   
   
   $memfeatures = $CORE->USER("membership_features", array());
   
   ?>  
          
            
        <div class="card card-admin">
        <div class="card-body">
       
        <a href="javascript:void(0);" onclick="jQuery('.hidemembership').toggle();" class="float-right btn btn-system btn-sm" style="margin-top:-10px;"><i class="fa fa-plus"></i> <?php echo __("Add Memberships","premiumpress"); ?></a>
          
          <div class="accordion border mt-4" id="accPackages">
          
          
            <?php  $i=0; while($i < 11){ ?>
            <div class="card-header p-0 mb-0 bg-white <?php if(_ppt('mem'.$i.'_name') == ""){?>hidemembership<?php } ?>" id="heading<?php echo $i; ?>" <?php if(_ppt('mem'.$i.'_name') == ""){?>style="display:none"<?php } ?>>
              <button class="btn btn-link btn-block btn-open-mem" type="button" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>">
             
              <?php if(_ppt('mem'.$i.'_enable') == 1 && $i != 0){ echo "<span class='badge badge-success float-right mr-3 mt-3 mr-5'>enabled</span>"; } ?>
              <?php if(_ppt('mem'.$i.'_enable') == 0 && $i != 0){ echo "<span class='badge badge-danger float-right mr-3 mt-3 mr-5'>disabled</span>"; } ?>
              
              <?php if(_ppt('mem'.$i.'_r') == 1 && $i != 0 ){ echo "<span class='badge badge-danger float-right mr-3 mt-3  mr-5'>recurring</span>"; } ?>
              <h5 class="mb-0">
                <div class="title" style="font-size:16px;">
                
                <?php if( _ppt('mem'.$i.'_icon') != "" && _ppt('mem'.$i.'_icon') != "fa fa-cog"){ ?><i class="fa <?php echo str_replace("fa fa ","fa ", _ppt('mem'.$i.'_icon') ); ?> mr-2"></i> <?php } ?>
                
                  <?php if(_ppt('mem'.$i.'_name') == ""){ echo "<span class='opacity-8'>".__("Membership","premiumpress")." ".$i.'</span>'; }else{ echo strip_tags(_ppt('mem'.$i.'_name')); } ?>
                  
                  <?php if( $i != 0 && _ppt('mem'.$i.'_price') != "" && _ppt('mem'.$i.'_enable')  == '1' ){ ?>(<span class="<?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo _ppt('mem'.$i.'_price'); ?></span>)<?php } ?>
                  </div>
              </h5>
              </button>
            </div>
             
            
            
            
            
            <div id="collapse<?php echo $i; ?>" class="collapse" aria-labelledby="heading<?php echo $i; ?>" data-parent="#accPackages">
              <div class="card-body bg-light border mb-4 pb-4">
              
              
                <div class="row border-bottom pb-3 mb-3" style="<?php if($i == 0){ echo "display:none;";} ?>">
                  <div class="col-md-2 formrow">
                    <div>
                      <label class="radio off">
                      <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('enablemem<?php echo $i; ?>').value='0'">
                      </label>
                      <label class="radio on">
                      <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('enablemem<?php echo $i; ?>').value='1'">
                      </label>
                      <div class="toggle <?php if(  _ppt('mem'.$i.'_enable') == '1'){  ?>on<?php } ?>">
                        <div class="yes">ON</div>
                        <div class="switch"></div>
                        <div class="no">OFF</div>
                      </div>
                    </div>
                    <input type="hidden" id="enablemem<?php echo $i; ?>" name="admin_values[mem<?php echo $i; ?>_enable]" 
                             value="<?php if($i ==0){ echo 1; }elseif(_ppt('mem'.$i.'_enable') != ""){ echo _ppt('mem'.$i.'_enable'); }elseif($i < 4){ echo 1; }else{ echo 0; }  ?>">
                  </div>
                  
                  <div class="col-md-6">
                    <label class="font-weight-bold mb-2"><?php echo __("Enable Package","premiumpress"); ?></label>
                  </div>
                </div>
                
                <div class="row py-2" style="<?php if($i == 0){ echo "display:none;";} ?>">
                 
                 
                  
                  <div class="col-2">
                  
                      
      <input type="hidden" name="admin_values[mem<?php echo $i; ?>_icon]"  id="mem<?php echo $i; ?>_icon"  value="<?php if(_ppt('mem'.$i.'_icon') == ""){ echo "fa fa-cog"; }else{ echo _ppt('mem'.$i.'_icon'); } ?>" />
     
      <i class="<?php if( _ppt('mem'.$i.'_icon')  != ""){ echo str_replace("fa fa ","fa ", _ppt('mem'.$i.'_icon') ); }else{ echo "fa fa-cog"; }  ?> fa-3x float-left mr-2 fa-1x border p-2" style="cursor:pointer;" id="mem<?php echo $i; ?>_icon_icon" onclick="loadiconbox('mem<?php echo $i; ?>_icon','<?php if( _ppt('mem'.$i.'_icon') != ""){ echo _ppt('mem'.$i.'_icon'); }else{ echo "fa fa-cog"; }  ?>');"></i>
      
       
                  
                  </div>
                 
                 
                  <div class="col-10">
                  
                  
                  <div class="row">
                  <div class="col-md-9">
                  
                  
                  
                  
                    <label class="txt500 mb-2 w-100"><?php echo __("Name","premiumpress"); ?> <span class="float-right small"><a href="javascript:void(0);" class="btn btn-sm btn-system" onclick="jQuery('#customdisplay<?php echo  $i; ?>').toggle();"><?php echo __("Custom Display Features","premiumpress"); ?></a></span></label>
                    <input type="text" name="admin_values[mem<?php echo $i; ?>_name]" value="<?php if(_ppt('mem'.$i.'_name') == ""){ echo $memnames[$i]; }else{ echo _ppt('mem'.$i.'_name'); } ?>" class="form-control">
                   
                    
                   
                   
                   
                                 
                     </div>
                     
                     <div class="col-md-3">
                     
                       
                    <label><?php echo __("Highlight","premiumpress"); ?> <i class="fal fa-info-circle" data-toggle="tooltip" data-title="<?php echo __("This will display a solid background within the pricing table display.","premiumpress"); ?>"></i> </label>
                    <div class="formrow mt-2">
                      <label class="radio off">
                      <input type="radio" name="toggle" 
            value="off" onchange="document.getElementById('mem<?php echo $i; ?>_highlight').value='0'">
                      </label>
                      <label class="radio on">
                      <input type="radio" name="toggle"
            value="on" onchange="document.getElementById('mem<?php echo $i; ?>_highlight').value='1'">
                      </label>
                      <div class="toggle <?php if( _ppt('mem'.$i.'_highlight') == '1'){  ?>on<?php } ?>">
                        <div class="yes">ON</div>
                        <div class="switch"></div>
                        <div class="no">OFF</div>
                      </div>
                    </div>
                    <input type="hidden" id="mem<?php echo $i; ?>_highlight" name="admin_values[mem<?php echo $i; ?>_highlight]" value="<?php if(_ppt('mem'.$i.'_highlight') == ""){ echo 0; }else{ echo _ppt('mem'.$i.'_highlight'); } ?>">
                  
                
                     
                     
                     </div>
                     </div>
                     
                     
                     
                     
                     
                     
                     
                     
                     
                      <div class="row mb-4 mt-4" id="customdisplay<?php echo  $i; ?>" style="display:none;">
                <?php $f =1; while($f < 9){ ?>
                <div class="col-md-6 mb-4 border-bottom pb-4">
                
                
                <div class="position-relative">
                <input type="text" name="admin_values[mem<?php echo $i; ?>_txt<?php echo $f; ?>]" value="<?php if(_ppt('mem'.$i.'_txt'.$f) == ""){ echo ""; }else{ echo _ppt('mem'.$i.'_txt'.$f); } ?>" class="form-control" style="padding-left:45px !important;">
                <input type="hidden" name="admin_values[mem<?php echo $i; ?>_txt<?php echo $f; ?>_val]" id="mem<?php echo $i; ?>_txt<?php echo $f; ?>_val" value="<?php if(_ppt('mem'.$i.'_txt'.$f.'_val') == ""){ echo "1"; }?>" />
                
                <i class="fa <?php if(_ppt('mem'.$i.'_txt'.$f.'_val') != "0"){ ?>fa-check text-success<?php }else{ ?>fa-times text-danger<?php } ?> position-absolute" onclick="changeCheckB('mem<?php echo $i; ?>_txt<?php echo $f; ?>_val')" id="mem<?php echo $i; ?>_txt<?php echo $f; ?>_val_check" style="top:15px; left:15px; cursor:pointer;"></i>
                
                </div>
                
                  
                 
				 <?php if(is_array($langs) && !empty($langs) && count($langs) > 1 ){ ?>
                
                <div id="" class="" >
                  <?php foreach(_ppt('languages') as $lang){
			
					$icon = explode("_",$lang); 
			
					if(_ppt(array('lang','default')) == "en_US" && isset($icon[1]) && strtolower($icon[1]) == "us"){ continue; } 
				
				?>
                  <div class="mt-3">
                    <div class="mb-2 small">
                      <div class="flag flag-<?php if(isset($icon[1])){ echo strtolower($icon[1]); }else{ echo $icon[0]; } ?> mr-2">&nbsp;</div>
                      <?php echo $CORE->GEO("get_lang_name", $lang); ?> </div>
                      
                      
                       <input type="text" name="admin_values[mem<?php echo $i; ?>_txt<?php echo $f; ?>_<?php echo strtolower($lang); ?>]" value="<?php if(_ppt('mem'.$i.'_txt'.$f.'_'.strtolower($lang)) == ""){ echo _ppt('mem'.$i.'_txt'.$f); }else{ echo _ppt('mem'.$i.'_txt'.$f.'_'.strtolower($lang)); } ?>" class="form-control">
                       
                    
                  </div>
                  
                  <?php } ?>
                  
                  
                </div>
                <?php } ?>
                
                  
                
                </div> 
                <?php  $f++; } ?>                
                </div> 
                
                     
                     
                     
               <?php /***********************************************************************/ ?>
                 
                 
				 <?php if(is_array($langs) && !empty($langs) && count($langs) > 1 ){ ?>
                
                <div id="" class="" >
                  <?php foreach(_ppt('languages') as $lang){
			
					$icon = explode("_",$lang); 
			
					if(_ppt(array('lang','default')) == "en_US" && isset($icon[1]) && strtolower($icon[1]) == "us"){ continue; } 
				
				?>
                  <div class="mt-3">
                    <div class="mb-2 small">
                      <div class="flag flag-<?php if(isset($icon[1])){ echo strtolower($icon[1]); }else{ echo $icon[0]; } ?> mr-2">&nbsp;</div>
                      <?php echo $CORE->GEO("get_lang_name", $lang); ?> </div>
                      
                      
                       <input type="text" name="admin_values[mem<?php echo $i; ?>_name_<?php echo strtolower($lang); ?>]" value="<?php if(_ppt('mem'.$i.'_name_'.strtolower($lang)) == ""){ if(isset($paknames[$i]) ){ echo $paknames[$i]; }else{ echo ""; }  }else{ echo _ppt('mem'.$i.'_name_'.strtolower($lang)); } ?>" class="form-control">       
                    
                  </div>
                  
                  <?php } ?>
                  
                  
                </div>
                <?php } ?>
                
                   <?php /***********************************************************************/ ?>
                     
                     
                
                 </div>
                 
           
           
            </div>  
                
                
                
                
                
                
                
                
                
                
                <!-- end row -->
                <div class="mt-3 mb-3" style="<?php if($i == 0){ echo "display:none;";} ?>">
                  <label class="txt500"><?php echo __("Description","premiumpress"); ?></label>
                  <textarea name="admin_values[mem<?php echo $i; ?>_desc]" class="form-control" style="height:100px !important;"><?php  if(_ppt('mem'.$i.'_desc') == ""){ }else{     echo stripslashes(_ppt('mem'.$i.'_desc')); } ?></textarea>
                
                
                
                
              <?php /***********************************************************************/ ?>
                 
                 
				 <?php if(is_array($langs) && !empty($langs) && count($langs) > 1 ){ ?>
                
                <div id="" class="" >
                  <?php foreach(_ppt('languages') as $lang){
			
					$icon = explode("_",$lang); 
			
					if(_ppt(array('lang','default')) == "en_US" && isset($icon[1]) && strtolower($icon[1]) == "us"){ continue; } 
				
				?>
                  <div class="mt-3">
                    <div class="mb-2 small">
                      <div class="flag flag-<?php if(isset($icon[1])){ echo strtolower($icon[1]); }else{ echo $icon[0]; } ?> mr-2">&nbsp;</div>
                      <?php echo $CORE->GEO("get_lang_name", $lang); ?> </div>
                      
                      <textarea name="admin_values[mem<?php echo $i; ?>_desc_<?php echo strtolower($lang); ?>]" class="form-control" style="height:100px !important;"><?php if(_ppt('mem'.$i.'_desc_'.strtolower($lang)) == ""){ }else{ echo _ppt('mem'.$i.'_desc_'.strtolower($lang)); } ?></textarea>   
                    
                  </div>
                  
                  <?php } ?>
                  
                  
                </div>
                <?php } ?>
                
                
                <?php /***********************************************************************/ ?>
                
                 
                
                </div>
                
                
                
               
               
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
               
               
               <div class="row mt-4" style="<?php if($i == 0){ echo "display:none;";} ?>">
                  <div class="col-md-4">
                 
                       <label class="txt500"><?php echo __("Price","premiumpress"); ?> <span class="required">*</span></label>
                    <div class="input-group"> <span class="input-group-prepend input-group-text"><?php echo hook_currency_symbol(''); ?></span>
                      <input type="text" name="admin_values[mem<?php echo $i; ?>_price]" value="<?php if(_ppt('mem'.$i.'_price') == ""){ echo $i*10; }else{ echo _ppt('mem'.$i.'_price'); } ?>" class="form-control val-numeric">
                    </div>
                    
                    </div>
                  <div class="col-md-4">
                  
                  
                     <label class="txt500 mb-2"><?php echo __("Duration","premiumpress"); ?> (<?php echo __("days","premiumpress"); ?>)</label>
                    <div class="input-group">
                      <?php if(in_array(_ppt('mem'.$i.'_duration'), array(1,2,7,30,60,90,120,150,180,365) )){ ?>
                      <select name="admin_values[mem<?php echo $i; ?>_duration]" class="form-control">
                        <option value="1" <?php if(_ppt('mem'.$i.'_duration') == "1"){ echo 'selected=selected'; } ?>>24 hours</option>
                        <option value="2" <?php if(_ppt('mem'.$i.'_duration') == "2"){ echo 'selected=selected'; } ?>>48 hours</option>
                        <option value="7" <?php if(_ppt('mem'.$i.'_duration') == "7"){ echo 'selected=selected'; } ?>>1 Week</option>
                        <option value="30" <?php if(_ppt('mem'.$i.'_duration') == "30"){ echo 'selected=selected'; } ?>>1 Month</option>
                        
                        <option value="60" <?php if(_ppt('mem'.$i.'_duration') == "60"){ echo 'selected=selected'; } ?>>2 Months</option>
                        <option value="90" <?php if(_ppt('mem'.$i.'_duration') == "90"){ echo 'selected=selected'; } ?>>3 Months</option>
                        <option value="120" <?php if(_ppt('mem'.$i.'_duration') == "120"){ echo 'selected=selected'; } ?>>4 Months</option>
                        <option value="150" <?php if(_ppt('mem'.$i.'_duration') == "150"){ echo 'selected=selected'; } ?>>5 Months</option>
                        <option value="180" <?php if(_ppt('mem'.$i.'_duration') == "180"){ echo 'selected=selected'; } ?>>6 Months</option>
                        
                        
                        <option value="365" <?php if(_ppt('mem'.$i.'_duration') == "365"){ echo 'selected=selected'; } ?>>1 Year</option>
                        <option value="99">Custom Duration</option>
                      </select>
                      <?php }else{ ?>
                      <input type="text" name="admin_values[mem<?php echo $i; ?>_duration]"   class="form-control" value="<?php if(_ppt('mem'.$i.'_duration') == ""){ echo "30"; }else{ echo _ppt('mem'.$i.'_duration'); } ?>">
                      <?php } ?>
                    </div>
                    <small>0 = <?php echo __("unlimited","premiumpress"); ?></small> 
                  
                   
                  </div>
                  <div class="col-md-4">
                    <label class="txt500"><?php echo __("Recurring Payment","premiumpress"); ?></label>
                    <div class="formrow mt-2">
                      <label class="radio off">
                      <input type="radio" name="toggle" 
            value="off" onchange="document.getElementById('mem<?php echo $i; ?>_r').value='0'">
                      </label>
                      <label class="radio on">
                      <input type="radio" name="toggle"
            value="on" onchange="document.getElementById('mem<?php echo $i; ?>_r').value='1'">
                      </label>
                      <div class="toggle <?php if( _ppt('mem'.$i.'_r') == '1'){  ?>on<?php } ?>">
                        <div class="yes">ON</div>
                        <div class="switch"></div>
                        <div class="no">OFF</div>
                      </div>
                    </div>
                    <input type="hidden" id="mem<?php echo $i; ?>_r" name="admin_values[mem<?php echo $i; ?>_r]" value="<?php echo _ppt('mem'.$i.'_r'); ?>">
                  </div> 
                  
                  
                  
                  
                </div>
                
                <hr style="<?php if($i == 0){ echo "display:none;";} ?>" />
                
                <div class="row" style="<?php if($i == 0){ echo "display:none;";} ?>">
             
                
                    <div class="col-md-3 mt-4">
                 <label class="txt500"><?php echo __("Admin Approval","premiumpress"); ?></label>
                
                    <div class="formrow mt-2">
                      <label class="radio off">
                      <input type="radio" name="toggle" 
            value="off" onchange="document.getElementById('mem<?php echo $i; ?>_approval').value='0'">
                      </label>
                      <label class="radio on">
                      <input type="radio" name="toggle"
            value="on" onchange="document.getElementById('mem<?php echo $i; ?>_approval').value='1'">
                      </label>
                      <div class="toggle <?php if( _ppt('mem'.$i.'_approval') == '1'){  ?>on<?php } ?>">
                        <div class="yes">ON</div>
                        <div class="switch"></div>
                        <div class="no">OFF</div>
                      </div>
                    </div>
                    <input type="hidden" id="mem<?php echo $i; ?>_approval" name="admin_values[mem<?php echo $i; ?>_approval]" value="<?php echo _ppt('mem'.$i.'_approval'); ?>">
                  </div> 
                  
                  
             <div class="col-md-8 mt-4">
                
                <div style="font-size:14px;">
                <?php echo __("If you want to manually approve user accounts after they purchase this membership enable this option. During the period of waiting for approval they will not be able to access any membership features.","premiumpress"); ?>
                 </div>  
                </div>
                  
               </div> 
               
               
                <hr style="<?php if($i == 0){ echo "display:none;";} ?>" />
                
                <div class="row" style="<?php if($i == 0){ echo "display:none;";} ?>">
             
                
                    <div class="col-md-3 mt-4">
                 <label class="txt500"><?php echo __("Show After Purchase","premiumpress"); ?></label>
                
                    <div class="formrow mt-2">
                      <label class="radio off">
                      <input type="radio" name="toggle" 
            value="off" onchange="document.getElementById('mem<?php echo $i; ?>_repurchase').value='0'">
                      </label>
                      <label class="radio on">
                      <input type="radio" name="toggle"
            value="on" onchange="document.getElementById('mem<?php echo $i; ?>_repurchase').value='1'">
                      </label>
                      <div class="toggle <?php if( in_array( _ppt('mem'.$i.'_repurchase'), array("","1")) ) {  ?>on<?php } ?>">
                        <div class="yes">ON</div>
                        <div class="switch"></div>
                        <div class="no">OFF</div>
                      </div>
                    </div>
                    <input type="hidden" id="mem<?php echo $i; ?>_repurchase" name="admin_values[mem<?php echo $i; ?>_repurchase]" value="<?php if(in_array(_ppt('mem'.$i.'_repurchase'), array("","1")) ){ echo 1; }else{ echo 0; } ?>">
                  </div> 
                  
                  
             <div class="col-md-8 mt-4">
                
                <div style="font-size:14px;">
                <?php echo __("Turn OFF to stop users who are currently subscribed to this plan from seeing this package when upgrading or buying a new membership.","premiumpress"); ?>
                 </div>  
                </div>
                  
               </div> 
                
              
                    
               
                    
                    
               <div class="col-md-12 px-0 mt-5">  
                     
                   <div class="border p-3 bg-white shadow-sm"> 
                   <i class="fal fa-lock float-left mr-4 fa-3x mt-2"></i>
                    <h6 class="mt-2"><?php echo __("Membership Access","premiumpress"); ?></h6>
                    <p><?php echo __("Choose which features users with this membership can access.","premiumpress"); ?></p>
                      
                    
        <div class="bg-white p-3 "> 
        
         
         
         <div class="row py-3 border-top"> 
             
            <div class="col-md-6">
            
            <label><?php echo __("Feature","premiumpress"); ?></label>
            
            </div>
            
            <div class="col-md-3 text-center">
            
            <label><?php echo __("Enable","premiumpress"); ?></label>
            
            </div>
            
            <div class="col-md-3 text-center">
            
            <label><?php echo __("Hide Display","premiumpress"); ?></label>
            
            </div>
        
        </div>
        
                   
     <?php  foreach($memfeatures as $f){  ?>
        
        <div class="row py-3 border-top position-relative" id="fearow<?php echo $i; ?>_<?php echo $f['key']; ?>"> 

        
        
        
        
        
        <div class="col-md-6 small">
		
		
		<label class="ppt-tooltip-show"><?php echo str_replace("%s", strtolower($CORE->LAYOUT("captions","1")), $f['name'] ); ?> 
        
        
        <?php if(isset($f['desc'])){ ?>
        <i class="fal fa-info-circle ml-2 ppt-tooltip-show" style="cursor:pointer"></i>
        
        <div class="ppt-tooltip bg-dark p-2 shadow" style="height: auto !important;
    text-align: left;
    font-size: 14px;
    max-width: 400px !important; "> <i class="fal fa-info-circle ml-2 fa-2x float-left pr-3" style="cursor:pointer"></i> <?php echo $f['desc']; ?></div> 
        
        <?php } ?>
        </label>
        
        
        </div>
        
        <div class="col-md-3 text-center">
        
        
   
        
         <label class="custom-control custom-checkbox"> 
            
            <input type="checkbox" 
            value="1" 
           
            class="custom-control-input" 
            id="mem<?php echo $i; ?>_<?php echo $f['key']; ?>check" 
            onchange="ChekME('#mem<?php echo $i; ?>_<?php echo $f['key']; ?>');"
             
            <?php if(_ppt('mem'.$i.'_'.$f['key']) == 1){ ?>checked=checked<?php } ?>> 
            
              <input type="hidden" name="admin_values[mem<?php echo $i; ?>_<?php echo $f['key']; ?>]" id="mem<?php echo $i; ?>_<?php echo $f['key']; ?>add" value="<?php 
			  
			  if( _ppt('mem'.$i.'_'.$f['key']) == "" ){ echo $f['default']; }else{ echo _ppt('mem'.$i.'_'.$f['key']); } ?>"> 
           
            <span class="custom-control-label">&nbsp;</span>
            </label>
         
        
        
        
        </div>
        
        <div class="col-md-3 text-center">
        
        
        
         <label class="custom-control custom-checkbox"> 
            
            <input type="checkbox" 
            value="1" 
           
            class="custom-control-input" 
            id="mem<?php echo $i; ?>_<?php echo $f['key'].'_hide'; ?>checkhide" 
            onchange="ChekMEHide('#mem<?php echo $i; ?>_<?php echo $f['key'].'_hide'; ?>');"
             
            <?php if(_ppt('mem'.$i.'_'.$f['key'].'_hide') == 1){ ?>checked=checked<?php } ?>> 
            
              <input type="hidden" name="admin_values[mem<?php echo $i; ?>_<?php echo $f['key'].'_hide'; ?>]" id="mem<?php echo $i; ?>_<?php echo $f['key'].'_hide'; ?>add" value="<?php 
			  
			  if( _ppt('mem'.$i.'_'.$f['key'].'_hide') == ""){ echo $f['hide_default']; }else{ echo _ppt('mem'.$i.'_'.$f['key'].'_hide'); } ?>"> 
           
            <span class="custom-control-label">&nbsp;</span>
            </label>
        
        
        </div>
       
       
       
       <?php if($f['key'] == "downloads"){ ?>
       <div class="col-md-12 mt-4">
       
       
       
                     <label class="txt500"><?php echo __("Downloads","premiumpress"); ?></label>
                    
                     
                     <div class="input-group"> <span class="input-group-prepend input-group-text">#</span>
                      <input type="text" name="admin_values[mem<?php echo $i; ?>_downloads_count]" value="<?php if(_ppt('mem'.$i.'_downloads_count') == ""){ echo 0; }else{ echo _ppt('mem'.$i.'_downloads_count'); } ?>" class="form-control val-numeric">
                    </div>
       
       </div>       
       <?php }elseif($f['key'] == "listings"){ ?>
       
       <div class="col-md-7 mt-4"></div>
       <div class="col-md-5 mt-4">
       
        
                     
                     <div class="input-group"> <span class="input-group-prepend input-group-text">#</span>
                      <input type="text" name="admin_values[mem<?php echo $i; ?>_listings_count]" value="<?php if(_ppt('mem'.$i.'_listings_count') == ""){ echo 0; }else{ echo _ppt('mem'.$i.'_listings_count'); } ?>" class="form-control val-numeric">
                    </div>
                     
       </div> 
       
           <?php }elseif($f['key'] == "listings_max"){ ?>
       
       <div class="col-md-7 mt-4"></div>
       <div class="col-md-5 mt-4">
       
        
                     
                     <div class="input-group"> <span class="input-group-prepend input-group-text">#</span>
                      <input type="text" name="admin_values[mem<?php echo $i; ?>_listings_max_count]" value="<?php if(_ppt('mem'.$i.'_listings_max_count') == ""){ echo 0; }else{ echo _ppt('mem'.$i.'_listings_max_count'); } ?>" class="form-control val-numeric">
                    </div>
                     
       </div>
       
           <?php }elseif($f['key'] == "max_msg"){ ?>
       
       <div class="col-md-7 mt-4"></div>
       <div class="col-md-5 mt-4">
       
        
                     
                     <div class="input-group"> <span class="input-group-prepend input-group-text">#</span>
                      <input type="text" name="admin_values[mem<?php echo $i; ?>_max_msg_count]" value="<?php if(_ppt('mem'.$i.'_max_msg_count') == ""){ echo 100; }else{ echo _ppt('mem'.$i.'_max_msg_count'); } ?>" class="form-control val-numeric">
                    </div>
                     
       </div>
       
             
       <?php } ?>
       
       
       
      	
        
        </div> 
        
        
        
        <?php } ?>
        </div> 
          
        </div>
        
        </div> 
                    
                 
                    
              <div class="py-4 small">
              
              <strong><?php echo __("Restricting Page Content","premiumpress"); ?> <span class="float-right badge badge-primary lead">This ID: <?php echo $i; ?></span></strong>
              
              <p class="mt-3"><?php echo __("Restrict content within your WordPress pages using the shortcode below.","premiumpress"); ?></p>
              
              <textarea class="form-control w-100" style="height:50px !important; padding-top:10px !important;">[MEMBERSHIP show="<?php echo $i; ?>"]my restricted content here[/MEMBERSHIP]</textarea>
              
              </div>
			 
                
                
              </div>
            </div>
            <?php $i++; } ?>
            
          </div>
          <div class="p-4 bg-light text-center mt-4">
            <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
          </div>
        </div>
        <!-- end col 8 -->
      </div>
    </div>
    <!-- end admin card -->
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
		
			function ChekMEHide(div){
		
			if (jQuery(div+'checkhide').is(':checked')) {			
				jQuery(div+'add').val(1);			
			}else{			
				jQuery(div+'add').val(0);
			}
		
		}
		</script> 




<?php if(THEME_KEY == "da"){
 
  $settings = array("title" => __("Default Membership (Gender)","premiumpress"), "desc" => __("Here you can set a default membership for new users who join your website.","premiumpress") );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
<div class="card card-admin">
  <div class="card-body">
  
  
                <?php
$count = 1;
$cats = get_terms( 'dagender', array( 'hide_empty' => 0, 'parent' => 0  ));
if(!empty($cats)){
foreach($cats as $cat){ 
if($cat->parent != 0){ continue; } 
 
?>
                    
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></label>
          <p class="text-muted"><?php echo __("Select membership for this gender type.","premiumpress"); ?></p>
        </div>
        <div class="col-md-5">
 
 <?php

	$status = array( "" => "None");
	// ADD ON MEMBERSHIPS
	$i=1; 
	while($i < 11){ 	
	
	
		if(_ppt('mem'.$i.'_name') == ""){ $n =  $memnames[$i]; }else{ $n =  _ppt('mem'.$i.'_name'); } 		
		if($n == ""){ $i++; continue; }
		$status['mem'.$i] = $n;
		$i++;
	}
 
	
	?>
                <select name="admin_values[mem][regmembership_<?php echo $cat->term_id; ?>]"   class="form-control" style="widht:100%;">
                  <?php foreach($status as $key => $club){ ?>
                  <option value="<?php echo $key; ?>" <?php if(_ppt(array('mem','regmembership_'.$cat->term_id)) == $key){  echo "selected=selected"; } ?>><?php echo $club; ?></option>
                  <?php } ?>
                </select>


        </div>
      </div>
    </div>
    
   <?php $count++; } } ?>
 
    
      <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
  </div>
</div>

  
<!-- end admin card -->
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>


<?php } ?>





<?php
 
  $settings = array(
  "title" => __("Restrict Page Content","premiumpress"), 
  "desc" => __("You can strict content within your WordPress pages using the [MEMBERSHIP] shortcode.","premiumpress")
  
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
<div class="card card-admin">
  <div class="card-body">
  
   <label><?php echo __("Restricted Content Message","premiumpress"); ?></label>
   
   <p><?php echo __("Enter the text to display to someone who does not have access to the content.","premiumpress"); ?></p>
   
   <textarea name="admin_values[mem][listingaccessmsg]" class="form-control" style="height:100px !important;"><?php echo _ppt(array('mem','listingaccessmsg')); ?></textarea>
  <div class="opacity-5 mt-3 small"><?php echo __("leave blank for default message.","premiumpress"); ?></div>
  
    
      <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
  </div>
</div>

  
<!-- end admin card -->
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
 