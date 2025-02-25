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

global $CORE, $settings, $default_email_array, $userdata; 
 
$all_emails = _ppt('emails');
 
$settop = 0; 

$settings = array("title" => "User Emails", "desc" => "Here you can turn on/off email sent to users.", "video" => "");

   _ppt_template('framework/admin/_form-wrap-top' ); 
   
   ?>   
   <div class="card card-admin">
   <div class="card-body">
   <?php
$l = $CORE->FUNC("get_logtype", array()); 

foreach($l as $key => $val){

// SKIP
if(!isset($val['email']) ){ continue; }


$desc = $val['desc'];

$desc = str_replace("%u","User", $desc);
$desc = str_replace("%extra","Credit", $desc);

$subject 	= "";
$body 		=	"";
$sms 		= "";

if(isset($all_emails[$key]['subject'])){
$subject 	= $all_emails[$key]['subject'];
}

if($subject == "" && isset($val['email']['subject']) ){
$subject = $val['email']['subject'];
}

if(isset($all_emails[$key]['body'])){
$body 		= $all_emails[$key]['body'];
}

if($body == "" && isset($val['email']['body']) ){
$body = $val['email']['body'];
}

?>    

<div class="container px-0">
            <div class="row py-2">
              <div class="col-2">
                <div class="formrow">
                  <label class="radio off">
                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('<?php echo $key; ?>_enable').value='0'">
                  </label>
                  <label class="radio on">
                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('<?php echo $key; ?>_enable').value='1'">
                  </label>
                  <div class="toggle <?php if( isset($all_emails[$key]['enable']) && $all_emails[$key]['enable'] == '1'){  ?>on<?php } ?>">
                    <div class="yes">ON</div>
                    <div class="switch"></div>
                    <div class="no">OFF</div>
                  </div>
                </div>
                <input type="hidden" id="<?php echo $key; ?>_enable" name="admin_values[emails][<?php echo $key; ?>][enable]"
                             value="<?php if(isset($all_emails[$key]['enable'])){ echo $all_emails[$key]['enable']; }else{ echo 0; } ?>">
              </div>
              <div class="col-7">
                <h6>
                
                <?php $g = $CORE->EMAIL("count_email", $key); if($g > 0){  ?>
                 <a href="admin.php?page=reports&emailid=<?php echo $key; ?>" class="badge badge-success float-right text-white"><?php echo $g; ?> <?php echo __("sent","premiumpress"); ?></a>
                 <?php } ?>
                 
                <i class="<?php echo $val['icon'] ?> mr-2"></i> <?php echo $val['name'] ?>
                
                
                </h6>
                <p class="mb-0 text-muted">
                  <?php echo $desc; ?>  
                </p> 
                
              </div>
              <div class="col-md-3 pl-0">
                <div class=""> 
                
                <a href="javascript:void(0);" onclick="jQuery('#<?php echo $key; ?>_showemail').toggle();" class="btn btn-block btn-light shadow-sm btn-md rounded-0 px-4 mt-n2"><?php echo __("Edit Email","premiumpress"); ?></a>
                
                <a href="admin.php?page=email&testemail=<?php echo $key; ?>" class="btn btn-sm btn-light pr-1 btn-block mt-1"><?php echo __("Test","premiumpress"); ?><i class="fal ml-2 fa-envelope"></i> </a>
                
                
                 </div>
              </div>
            </div>
            <hr />
            <div class="row py-2" style="display:none;" id="<?php echo $key; ?>_showemail">
              <div class="col-12">
                <input type="text"  name="admin_values[emails][<?php echo $key; ?>][subject]" class="form-control mt-1 mb-2"  value="<?php echo stripslashes($subject); ?>" placeholder="Subject Here...">
                <?php echo wp_editor( stripslashes($body), 'email_id_'.$key, array( 'textarea_name' => 'admin_values[emails]['.$key.'][body]', 'editor_height' => '200px') );  ?>
              
               
                 
<?php $shortcodes = $CORE->email_message_filter('',array("user_id" => $userdata->ID), true, $key); ?>
<div class="bg-light my-4 p-3">
<div  class="small mb-2"><i class="fa fa-code mr-2"></i> <?php echo __("Email Shortcodes","premiumpress"); ?></div>
<select class="form-control" onchange="appendText(this.value,'email_id_<?php echo $key; ?>')">
 <option></option>
	<?php foreach($shortcodes as $key => $sc){ ?>
    <option value="<?php echo $key; ?>"><?php echo "(".$key.") = ".$sc; ?></option>
    <?php } ?>
</select>
</div>          
                
                
                
              </div>
            </div>
          </div>
<?php } ?>
           
           
          <div class="p-4 bg-light text-center mt-4">
            <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
          </div>
          
        </div>  </div>   
        
<script>

function appendText(text, editoid) {

	if(text == ""){ return; }
	 
	var content = '('+text+')';
	 
	if(jQuery('#wp-'+editoid+'-wrap').hasClass('html-active')){ // We are in text mode
	
		jQuery('#'+editoid).val(jQuery('#'+editoid).val()+' '+content); // Update the textarea's content	 
		
	} else { // We are in tinyMCE mode
		
		jQuery('#'+editoid+'_ifr').contents().find("body").html( jQuery('#'+editoid+'_ifr').contents().find("body").html() +' '+ content);
		
	}
 
}
</script>   
          
<?php _ppt_template('framework/admin/_form-wrap-bottom' );


 
 
$l = $CORE->EMAIL("get_admin_emails", array()); 


if(is_array($l) && !empty($l) ){

$settings = array("title" => "Admin Emails", "desc" => "Here you can turn on/off emails sent to the website admin." );

   _ppt_template('framework/admin/_form-wrap-top' ); 
   
   ?>
   
   <div class="card card-admin"><div class="card-body">
   <?php


foreach($l as $key => $val){


$desc = $val['desc'];

$desc = str_replace("%u","User", $desc);
$desc = str_replace("%extra","Credit", $desc);

$subject 	= "";
$body 		=	"";
$sms 		= "";

if(isset($all_emails[$key]['subject'])){
$subject 	= $all_emails[$key]['subject'];
}

if($subject == "" && isset($val['email']['subject']) ){
$subject = $val['email']['subject'];
}

if(isset($all_emails[$key]['body'])){
$body 		= $all_emails[$key]['body'];
}

if($body == "" && isset($val['email']['body']) ){
$body = $val['email']['body'];
}
 
?>    

<div class="container px-0">
            <div class="row py-2">
              <div class="col-2">
                <div class="formrow">
                  <label class="radio off">
                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('<?php echo $key; ?>_enable').value='0'">
                  </label>
                  <label class="radio on">
                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('<?php echo $key; ?>_enable').value='1'">
                  </label>
                  <div class="toggle <?php if( isset($all_emails[$key]['enable']) && $all_emails[$key]['enable'] == '1'){  ?>on<?php } ?>">
                    <div class="yes">ON</div>
                    <div class="switch"></div>
                    <div class="no">OFF</div>
                  </div>
                </div>
                <input type="hidden" id="<?php echo $key; ?>_enable" name="admin_values[emails][<?php echo $key; ?>][enable]"
                             value="<?php if(isset($all_emails[$key]['enable'])){ echo $all_emails[$key]['enable']; }else{ echo 0; } ?>">
              </div>
              <div class="col-7">
                <h6>
                <?php $g = $CORE->EMAIL("count_email", $key); if($g > 0){  ?>
                 <a href="admin.php?page=reports&emailid=<?php echo $key; ?>" class="badge badge-success float-right text-white"><?php echo $g; ?> <?php echo __("sent","premiumpress"); ?></a>
                 <?php } ?>
                 
                <i class="<?php if(isset($val['icon'])){ echo $val['icon']; }else{ echo "fa fa-envelope"; } ?> mr-2"></i> <?php echo $val['name'] ?></h6>
                <p class="mb-0 text-muted">
                  <?php echo $val['desc']; ?>  
                </p> 
                
              </div>
              <div class="col-md-3 pl-0">
                <div class=""> 
                
                <a href="javascript:void(0);" onclick="jQuery('#<?php echo $key; ?>_showemail').toggle();" class="btn btn-block btn-light shadow-sm btn-md rounded-0 px-4 mt-n2"><?php echo __("Edit Email","premiumpress"); ?></a>
                
                <a href="admin.php?page=email&testemail=<?php echo $key; ?>" class="btn btn-sm btn-light pr-1 btn-block mt-1"><?php echo __("Test","premiumpress"); ?><i class="fal ml-2 fa-envelope"></i> </a>
                
                
                 </div>
              </div>
            </div>
            <hr />
            <div class="row py-2" style="display:none;" id="<?php echo $key; ?>_showemail">
              <div class="col-12">
                <input type="text"  name="admin_values[emails][<?php echo $key; ?>][subject]" class="form-control mt-1 mb-2"  value="<?php echo stripslashes($subject); ?>" placeholder="Subject Here...">
                <?php echo wp_editor( stripslashes($body), 'email_id_'.$key, array( 'textarea_name' => 'admin_values[emails]['.$key.'][body]', 'editor_height' => '200px') );  ?>
              
               
              
<?php $shortcodes = $CORE->email_message_filter('',array("user_id" => $userdata->ID), true, $key); ?>
<div class="bg-light my-4 p-3">
<div  class="small mb-2"><i class="fa fa-code mr-2"></i> <?php echo __("Email Shortcodes","premiumpress"); ?></div>
<select class="form-control" onchange="appendText(this.value,'email_id_<?php echo $key; ?>')">
 <option></option>
	<?php foreach($shortcodes as $key => $sc){ ?>
    <option value="<?php echo $key; ?>"><?php echo "(".$key.") = ".$sc; ?></option>
    <?php } ?>
</select>
</div>      
                
                
                
                
              </div>
            </div>
          </div>
<?php } ?>
          
          
          
          
          
          
          <div class="p-4 bg-light text-center mt-4">
            <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
          </div>
          
        </div>  </div>    
          
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); 

} 

?>