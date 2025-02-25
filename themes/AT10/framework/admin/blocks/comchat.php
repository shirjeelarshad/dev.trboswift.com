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


?>

<div class="col-12 border-bottom py-3 px-0">
  <div class="row">
    <div class="col-md-4">
      <label><?php echo __("Enable Comchat","premiumpress"); ?></label>
    </div>
    <div class="col-md-8">
      <div class="input-group mb-2">
        <div class="formrow">
          <div class="">
            <label class="radio off" style="display: none;">
            <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('enable').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('enable').value='1'">
            </label>
            <div class="toggle <?php if( in_array(_ppt(array("comchat","enable")), array("","1")) ){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
            <input type="hidden" id="enable" name="admin_values[comchat][enable]"  value="<?php if( in_array(_ppt(array("comchat","enable")), array("1")) ){ echo 1; }else{ echo 0; } ?>">
          </div>
          <p class="pb-0 btn-block text-muted mb-0 mt-3"><?php echo __("Turn on/off the comchat integration","premiumpress"); ?></p>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="col-12 border-bottom py-3 px-0">
  <div class="row">
    <div class="col-md-4">
      <label><?php echo __("Enable Messenger","premiumpress"); ?></label>
    </div>
    <div class="col-md-8">
      <div class="input-group mb-2">
        <div class="formrow">
          <div class="">
            <label class="radio off" style="display: none;">
            <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('msg_enable').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('msg_enable').value='1'">
            </label>
            <div class="toggle <?php if( in_array(_ppt(array("comchat","msg_enable")), array("","1")) ){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
            <input type="hidden" id="msg_enable" name="admin_values[comchat][msg_enable]"  value="<?php if( in_array(_ppt(array("comchat","msg_enable")), array("1")) ){ echo 1; }else{ echo 0; } ?>">
          </div>
          <p class="pb-0 btn-block text-muted mb-0 mt-3"><?php echo __("Turn on/off the comchat messenger integration","premiumpress"); ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container px-0 border-bottom mb-3 py-3 ">
      <div class="row py-2">
        <div class="col-md-6">
          <label>ComChat APP ID</label>
          <p class="text-muted">This can be found in your account <a href="">here</a>.</p>
        </div>
        <div class="col-md-6">
          <div class="input-group mb-3">
            <div class="input-group-prepend"> <span class="input-group-text">#</span> </div>
            <input type="text" name="admin_values[comchat][appid]" class="form-control" value="<?php if(_ppt(array("comchat","appid")) != ""){ echo _ppt(array("comchat","appid"));}else{  echo get_option('cc_clientid'); } ?>">
          </div>
        </div>
      </div>
    </div>
    
    
<div class="container px-0 border-bottom mb-3 py-3 ">
      <div class="row py-2">
        <div class="col-md-6">
          <label>ComChat API Key</label>
          <p class="text-muted">This can be found in your account <a href="">here</a>.</p>
        </div>
        <div class="col-md-6">
          <div class="input-group mb-3">
            <div class="input-group-prepend"> <span class="input-group-text">#</span> </div>
            <input type="text" name="admin_values[comchat][apikey]" class="form-control" value="<?php if(_ppt(array("comchat","apikey")) != ""){ echo _ppt(array("comchat","apikey")); }else{  echo get_option('cc_api_key'); } ?>">
          </div>
        </div>
      </div>
    </div>
    
    

<div class="container px-0 border-bottom mb-3 py-3 ">
      <div class="row py-2">
        <div class="col-md-6">
          <label>ComChat Auth Key</label>
          <p class="text-muted">This can be found in your account <a href="">here</a>.</p>
        </div>
        <div class="col-md-6">
          <div class="input-group mb-3">
            <div class="input-group-prepend"> <span class="input-group-text">#</span> </div>
            <input type="text" name="admin_values[comchat][authkey]" class="form-control" value="<?php if(_ppt(array("comchat","authkey")) != ""){ echo _ppt(array("comchat","authkey")); }else{ echo get_option('cc_auth_key'); } ?>">
          </div>
        </div>
      </div>
    </div>