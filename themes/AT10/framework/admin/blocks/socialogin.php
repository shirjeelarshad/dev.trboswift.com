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

if(_ppt(array('register','sociallogin')) == 1){

// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  
 
 
$providers = array(

	"twitter" => array(
		"name" => "Twitter",
		"help" => "https://developer.twitter.com/en/apps/",
		"icon" => "fa-twitter",
	),

	"facebook" => array(
		"name" => "Facebook",
		"help" => "https://developers.facebook.com/apps/",
		"icon" => "fa-facebook-f",
	),
	
	"google" => array(
		"name" => "Google",
		"help" => "https://developers.google.com/identity/",
		"icon" => "fa-google",
	),
	 
	"linkedin" => array(
		"name" => "LinkedIn",
		"help" => "https://www.linkedin.com/developers",
		"icon" => "fa-linkedin",
	),
    
    "apple" => array(
		"name" => "Apple",
		"help" => "https://developer.apple.com",
		"icon" => "fa-apple",
	),
	 
);
 
?> 


 
 
 
<?php foreach($providers as $key => $pro){ ?>


<div class="container px-0 bg-light mb-4 p-4 mt-4">
<div class="row">

    <div class="col-5">
    
        <label class="txt500"><?php echo $pro['name']; ?></label>
        
        <p class="text-muted">API keys can be found <a href="<?php echo $pro['help']; ?>" target="_blank" class="font-weight-bold"><u>here</u></a></p>
        
         <div class="mt-2 formrow">                  
                                     
                                      <label class="radio off" >
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('social_<?php echo $key; ?>').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('social_<?php echo $key; ?>').value='1'">
                                      </label>
                                      <div class="toggle <?php if(_ppt('social_'.$key.'') == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                      
<input type="hidden" id="social_<?php echo $key; ?>" name="admin_values[social_<?php echo $key; ?>]" 
                                 value="<?php if(_ppt('social_'.$key.'') == ""){ echo 0; }else{ echo _ppt('social_'.$key.''); } ?>"> 
                                 </div>
                                 
                                 
                                 
               <?php if(_ppt('social_'.$key.'_key1') != "" && _ppt('social_'.$key.'_key2') != ""){ ?>
               
               
                  <a class="btn btn-success btn-sm mt-4" href="<?php echo home_url(); ?>/wp-login.php?sociallogin=<?php echo $pro['name']; ?>" rel="nofollow" target="_blank">
                  Test <?php echo $pro['name']; ?> Login
                  </a>
               
              
               <?php } ?>
                                 
        
    </div>
    
    <div class="col-7">
    

    <div class="row"> 
  
  
    <div class="col-md-12">
                   
      <div class="form-group">
    	<label class="txt500">App Key <span class="required">*</span></label><br />
        <input type="text" class="form-control" name="admin_values[social_<?php echo $key; ?>_key1]" value="<?php echo _ppt('social_'.$key.'_key1'); ?>" />
        	</div>
            
 	</div>
    
    
    <div class="col-md-12">
                   
         <div class="form-group">
    	<label class="txt500">Secret Key <span class="required">*</span></label><br />
        <input type="<?php if(defined('WLT_DEMOMODE')){ echo "password"; }else{  echo "text"; } ?>" class="form-control" name="admin_values[social_<?php echo $key; ?>_key2]" value="<?php echo _ppt('social_'.$key.'_key2'); ?>" />
        </div>
        
        <label class="txt500">Callback URL</label><br />
       <code class="small">
       <?php if($pro['name'] == "Twitter"){ ?>
		<?php echo home_url().'/wp-login.php'; ?>
 		<?php }else{ ?>
       <?php echo home_url().'/wp-login.php?sociallogin='.$pro['name']; ?>
        <?php } ?>
        
        </code>
        
 
    
    </div>
    
</div>                  
    
</div>
</div>
</div>


 
 

    
<?php }  ?>
<?php }  ?>