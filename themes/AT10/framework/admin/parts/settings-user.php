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
 
 
global $settings, $CORE_ADMIN, $CORE;


  $settings = array(
  
  "title" => __("User Account Page","premiumpress"), 
  "desc" => __("Here you can change the display options in the user accout page.","premiumpress"),
  
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
  
   
<div class="card card-admin">
  <div class="card-body">


<?php

$g = array(

	 
	 
		 "account_messages" => array(
		 
			 "name" => __("Message System","premiumpress"), 
			 "desc" => __("Here you can turn on/off the private message system within user account.","premiumpress"), 
			 "type" => "yesno", 
			 "d" => "1" ,
			  "col8" => true 
		 ),	
		 
		  "messages_limit" => array(
		 
			 "name" => __("Message Display Limit","premiumpress"), 
			 "desc" => __("Set how many messages to display within the chat history window.","premiumpress"), 
			 "type" => "input", 
			 "d" => "10" ,
			  "col8" => true 
		 ),	
		 
		 
		   "edit_listing_link" => array(
		 
			 "name" => __("Edit Button Redirect","premiumpress"), 
			 "desc" => __("Select the default redirect page for editing a listing.","premiumpress"), 
			 "type" => "select",
			 "values" => array(
			 	1 => array("id" => "1", "name" => "Full Edit Page"), 
				2 => array("id" => "2", "name" => "Live Edit Page"), 			 
			 ), 
			 "d" => "10" ,
			  "col8" => true 
		 ),	
		 
		 
		 
		  "friends" => array(
		 
			 "name" => __("Friends System","premiumpress"), 
			 "desc" => __("Here you can turn on/off the built-in friends system and messenger.","premiumpress"), 
			 "type" => "yesno", 
			 "d" => "1",
			  "col8" => true 
		 ),	
		 
		 "ratings" => array(
		 
			 "name" => __("Rating System","premiumpress"), 
			 "desc" => __("Here you can turn on/off the entire user rating system.","premiumpress"), 
			 "type" => "yesno", 
			 "d" => 1,
			  "col8" => true 
		 ),	
		 
		 "level" => array(
		 
			 "name" => __("User Level System","premiumpress"), 
			 "desc" => __("Here you can turn on/off the entire user level system.","premiumpress"), 
			 "type" => "yesno", 
			 "d" => 1,
			  "col8" => true 
		 ),	


		 "favs" => array(
		 
			 "name" => __("Favorites System","premiumpress"), 
			 "desc" => __("Here you can turn on/off the entire user favorites system.","premiumpress"), 
			 "type" => "yesno", 
			 "d" => 1 ,
			  "col8" => true 
		 ),	
		 
		 
		 "likes" => array(
		 
			 "name" => __("Likes System","premiumpress"), 
			 "desc" => __("Here you can turn on/off the entire user likes system.","premiumpress"), 
			 "type" => "yesno", 
			 "d" => 1 ,
			  "col8" => true 
		 ),	
		 
		  "orders" => array(
		 
			 "name" => __("Invoice System","premiumpress"), 
			 "desc" => __("Here you can turn on/off the entire user invoice system.","premiumpress"), 
			 "type" => "yesno", 
			 "d" 	=> 1 ,
			 "col8" => true 
		 ),	

		 
		 
		 
		 "social" => array(
		 
			 "name" => __("Social Media Input","premiumpress"), 
			 "desc" => __("Here you can turn on/off the social media input boxes within the user details section.","premiumpress"), 
			 "type" => "yesno", 
			 "d" 	=> 1,
			 "col8" => true 
		 ),
		 
		 "mobile" => array(
		 
			 "name" => __("Mobile Phone Input","premiumpress"), 
			 "desc" => __("Here you can turn on/off the mobile phone input boxe within the user details section.","premiumpress"), 
			 "type" => "yesno", 
			 "d" 	=> 1,
			 "col8" => true 
		 ),
		 
		
		
		  "rec" => array(
		 
			 "name" => str_replace("%s", $CORE->LAYOUT("captions","2"),__("Recommended %s","premiumpress")), 
			 "desc" => str_replace("%s", strtolower($CORE->LAYOUT("captions","2")),__("Here you can turn on/off the recommended %s on the user dashboard.","premiumpress")), 
			 "type" => "yesno", 
			 "d" 	=> 1,
			 "col8" => true 
		 ),	
		
		 
		  "notify" => array(
		 
			 "name" => __("User Notification Bubble","premiumpress"), 
			 "desc" => __("Here you can turn on/off the user notification buttle that pops up at the bottom right of a users screen.","premiumpress"), 
			 "type" => "yesno", 
			 "d" 	=> 1,
			 "col8" => true 
		 ),		
		 
		   "email_notify" => array(
		 
			 "name" => __("Email Notifications","premiumpress"), 
			 "desc" => __("Here you can turn on/off the email notifications under the user settings tab.","premiumpress"), 
			 "type" => "yesno", 
			 "d" 	=> 1,
			 "col8" => true 
		 ),
		 	 
		 		 
		 /*
		  "stats" => array(
		 
			 "name" => __("Statistics Chart","premiumpress"), 
			 "desc" => __("Here you can turn on/off the user statistics display.","premiumpress"), 
			 "type" => "yesno", 
			 "d" 	=> 1 ,
			 "col8" => true 
		 ),	
		 */
		 
		 /*
		 "feed" => array(
		 
			 "name" => __("Community Feed","premiumpress"), 
			 "desc" => __("Here you can turn on/off the members area activity feed.","premiumpress"), 
			 "type" => "yesno", 
			 "d" => 1 ,
			  "col8" => true 
		 ),	
		 
		 "feed-activity" => array(
		 
			 "name" => __("Activity Feed","premiumpress"), 
			 "desc" => __("Here you can turn on/off the system activity feed.","premiumpress"), 
			 "type" => "yesno", 
			 "d" => 1,
			  "col8" => true  
		 ),	
		 
			 
		 "add" => array(		 
			 "name" => __("Create New","premiumpress"), 
			 "desc" => __("Here you can turn on/off the create new buttons within the members account page.","premiumpress"), 
			 "type" => "yesno", 
			 "d" => 1 ,
			  "col8" => true 
		 ),*/	 

);


if(in_array(THEME_KEY, array("dt","sp","cm","cp","vt","rt","so","jb", "cp","ph","es" )) ){

unset($g['friends']);

}

if(!in_array(THEME_KEY, array("da" )) ){

unset($g['likes']);

}

foreach ($g as $fieldkey => $fielddata){ echo $CORE_ADMIN->LoadCongifField($fielddata, $fieldkey, "user"); }
?>


      <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
    
  </div>
</div>
<!-- end admin card -->
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>






<?php if( in_array(THEME_KEY, array("es","jb","mj","ll","da"))){ 
	
						if(THEME_KEY == "mj"){
						global $CORE_MICROJOBS;	
						$accountTypes = $CORE_MICROJOBS->_user_types();
						}elseif(THEME_KEY == "es"){
						global $CORE_ESCORTTHEME;	
						$accountTypes = $CORE_ESCORTTHEME->_escort_types();
						}elseif(THEME_KEY == "jb"){
						global $CORE_JOBS;	
						$accountTypes = $CORE_JOBS->_user_types();	
						
						}elseif(THEME_KEY == "ll"){
						global $CORE_LEARNING;	
						$accountTypes = $CORE_LEARNING->_user_types();							
						
						}elseif(THEME_KEY == "da"){
						global $CORE_DATING;	
						$accountTypes = $CORE_DATING->_user_types();	
						 
						$gender_types = get_terms( 'dagender', array( 'hide_empty' => 0, 'parent' => 0  ));

						
						}
						
						 
  
 

  $settings = array(
  
  "title" => __("User Account Types","premiumpress"), 
  "desc" => __("Here you can turn on/off user account types.","premiumpress"),
 // "video" => "https://www.youtube.com/watch?v=A00J696bkc0",
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
  
   
<div class="card card-admin">
  <div class="card-body">

<?php  

 
foreach($accountTypes as $k => $f ){ ?>
<div class="col-12">
<div class="row">
<div class="col-4">
<div class="mb-4">
              <label class="custom-control custom-checkbox">
              <input type="checkbox" 
        value="1" 
       
        class="custom-control-input" 
        id="usertype_<?php echo $k; ?>check" 
        onchange="CheckUserype('#usertype_<?php echo $k; ?>');"
         
		<?php if( in_array(_ppt(array("usertype",$k)), array("","1")) ){ ?>checked=checked<?php } ?>>
              <input type="hidden" name="admin_values[usertype][<?php echo $k; ?>]" id="usertype_<?php echo $k; ?>add" value="<?php if(in_array(_ppt(array("usertype",$k)), array("","1"))){ echo 1; }else{ echo 0; } ?>">
              <span class="custom-control-label"><?php echo $f['name']; ?></span> </label>

</div></div>
<div class="col-8">


<label><?php echo __("Register Page Image","premiumpress"); ?></label>

<input class="form-control" placeholder="Custom Image Path (135px130px)" name="admin_values[usertype][<?php echo $k; ?>_image]" value="<?php echo _ppt(array('usertype', $k.'_image')); ?>" />



<?php if(THEME_KEY == "da" && !empty($gender_types) ){  

 
 ?>

<div class="row mt-4">
<div class="col-md-6">

      <select name="admin_values[usertype][<?php echo $k; ?>_a]" class="form-control" >
              <option value=""></option>
              <?php

$val = _ppt(array('usertype', $k.'_a'));
foreach($gender_types as $cat){ 
if($cat->parent != 0){ continue; } 
 
?>

<option value="<?php echo $cat->term_id; ?>" <?php if($val == $cat->term_id){ echo 'selected=selected'; } ?>><?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>

<?php }  ?>

</select>

</div>

<div class="col-md-6">

      <select name="admin_values[usertype][<?php echo $k; ?>_b]" class="form-control" >
              <option value=""></option>
              <?php

$val = _ppt(array('usertype', $k.'_b'));
foreach($gender_types as $cat){ 
if($cat->parent != 0){ continue; } 
 
?>

<option value="<?php echo $cat->term_id; ?>" <?php if($val == $cat->term_id){ echo 'selected=selected'; } ?>><?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>

<?php  }  ?>

</select>

</div>

</div>

<?php } ?>

<?php if(THEME_KEY != "da"){ ?>
<div <?php if(_ppt(array('mem','enable'))  != '1'){  ?>syle="display:none"<?php } ?>> 
<label class="mt-3"><?php echo __("Default Membership","premiumpress"); ?></label>

<?php

	$status = array( "" => "None");
	// ADD ON MEMBERSHIPS
	$i=1; 
	while($i < 11){ 	
	
	
		if(_ppt('mem'.$i.'_name') == ""){ $n =  ""; }else{ $n =  _ppt('mem'.$i.'_name'); } 			
		if($n == ""){ $i++; continue; }
			
		$status['mem'.$i] = $n;
		$i++;
	}
 
	
	?>
                <select name="admin_values[usertype][<?php echo $k; ?>_mem]"   class="form-control" style="widht:100%;">
                  <?php foreach($status as $key => $club){ ?>
                  <option value="<?php echo $key; ?>" <?php if(_ppt(array('usertype', $k.'_mem')) == $key){  echo "selected=selected"; } ?>><?php echo $club; ?></option>
                  <?php } ?>
                </select>
</div>
<?php } ?>

</div>


</div>
</div>      
      
	<hr>  
 <?php  } ?>
       
       
     
      
 
    <script>
		function CheckUserype(div){
		
			if (jQuery(div+'check').is(':checked')) {			
				jQuery(div+'add').val(1);			
			}else{			
				jQuery(div+'add').val(0);
			}
		
		}
		</script>

 

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
  
  "title" => __("Cashout System","premiumpress"), 
  "desc" => __("Here you can turn on/off user cashout options.","premiumpress"),
  "video" => "https://www.youtube.com/watch?v=A00J696bkc0",
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
  
   
<div class="card card-admin">
  <div class="card-body">
  


<?php

$g = array(
		 
		  "cashout" => array(
		 
			 "name" => __("Cashout System","premiumpress"), 
			 "desc" => __("Here you can turn on/off the entire cashout system.","premiumpress"), 
			 "type" => "yesno", 
			 "d" 	=> 0,
			 "col8" => true 
		 ),	
		 
		  "credit" => array(
		 
			 "name" => __("Credit System (requires cashout enabled)","premiumpress"), 
			 "desc" => __("Enable users to buy credit for use on your website.","premiumpress"), 
			 "type" => "yesno", 
			 "d" 	=> 0,
			 "col8" => true 
		 ),	
		 
		 "cashout_hideform" => array(
		 
			 "name" => __("Cashout System - Hide Form","premiumpress"), 
			 "desc" => __("Turn on to hide the cashout form.","premiumpress"), 
			 "type" => "yesno", 
			 "d" 	=> 0,
			 "col8" => true 
		 ),
);
		 
foreach ($g as $fieldkey => $fielddata){ echo $CORE_ADMIN->LoadCongifField($fielddata, $fieldkey, "user"); }

?>
  
  
  
  
  
  
  
  
  
  
    <!-- ------------------------- -->
    <div class="container mt-4 border-bottom mb-3 ">
      <div class="row py-2">
        <div class="col-md-5">
          <label><?php echo __("User Options","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Select which services are available.","premiumpress"); ?></p>
        </div>
        <div class="col-md-7">
          <div class="row px-0">
            <?php 


$videopak = array(

	1 => array("key" => "paypal", "name" => __("PayPal","premiumpress")  ),
	2 => array("key" => "bank", "name" => __("Bank","premiumpress")),
	3 => array("key" => "person", "name" => __("In Person/On Collection","premiumpress")  ),
	
);

foreach($videopak as $k => $f ){ ?>
            <div class="col-md-12 mb-4">
              <label class="custom-control custom-checkbox">
              <input type="checkbox" 
        value="1" 
       
        class="custom-control-input" 
        id="cashoutopt_<?php echo $f['key']; ?>check" 
        onchange="CheckCashOpt('#cashoutopt_<?php echo $f['key']; ?>');"
         
		<?php if(_ppt("cashoutopt_".$f['key']) == 1){ ?>checked=checked<?php } ?>>
              <input type="hidden" name="admin_values[cashoutopt_<?php echo $f['key']; ?>]" id="cashoutopt_<?php echo $f['key']; ?>add" value="<?php if(in_array(_ppt("cashoutopt_".$f['key']), array("","1"))){ echo 1; }else{ echo 0; } ?>">
              <span class="custom-control-label"><?php echo $f['name']; ?></span> </label>
            </div>
            <?php  } ?>
          </div>
        </div>
      </div>
    </div>
    <script>
		function CheckCashOpt(div){
		
			if (jQuery(div+'check').is(':checked')) {			
				jQuery(div+'add').val(1);			
			}else{			
				jQuery(div+'add').val(0);
			}
		
		}
		</script>
    <!-- ------------------------- -->
  
 

      <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
    
  </div>
</div>
<!-- end admin card -->
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
 



<?php

if(_ppt(array('user','credit')) == "1"){ 

  $settings = array(
  
  "title" => __("Credit System","premiumpress"), 
  "desc" => __("Here you can set an amount of money for users to buy for credit.","premiumpress"),
  "video" => "https://www.youtube.com/watch?v=-LC9u3KiIxc",
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
  
   
<div class="card card-admin">
  <div class="card-body">
  
  
  <?php $i=1; while($i < 8){ ?>
  <div class="row">
  
   <div class="col-md-4">
   
   </div>
  
  <div class="col-md-4">
  <label><?php echo __("User Pays","premiumpress"); ?></label>
  
    <div class="input-group">   
	<input class="form-control numericonly" placeholder="0" name="admin_values[credit][<?php echo $i; ?>a]" value="<?php echo _ppt(array('credit', $i .'a')); ?>" style="padding-left:30px !important;"/>
    
    <div class="position-absolute" style="bottom: 8px;    left: 10px;"><?php echo hook_currency_symbol(''); ?></div>
    
    <div class="position-absolute text-muted" style="bottom: 8px;    right: 10px;"><?php echo hook_currency_code(''); ?></div>

    </div>
  
  
  
  </div>
  <div class="col-md-4">
  <label><?php echo __("Credit Received","premiumpress"); ?></label>

    <div class="input-group">   
	<input class="form-control numericonly" placeholder="0" name="admin_values[credit][<?php echo $i; ?>b]" value="<?php echo _ppt(array('credit', $i .'b')); ?>" style="padding-left:30px !important;"/>
    
    <div class="position-absolute" style="bottom: 8px;    left: 10px;"><?php echo hook_currency_symbol(''); ?></div>
    
    <div class="position-absolute text-muted" style="bottom: 8px;    right: 10px;"><?php echo hook_currency_code(''); ?></div>

    </div>

  </div>
  
  <div class="col-12">
  <hr />
  </div>
  
  </div>
  
  <?php $i++; } ?>
  
   
 

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
  
  "title" => __("Account Fields","premiumpress"), 
  "desc" => __("Here you can setup custom fields for users to edit when updating their accont details.","premiumpress"),
  
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
  
   
<div class="card card-admin">
  <div class="card-body">
  
  
  
  

  
  
  
  <?php _ppt_template('framework/admin/blocks/userfields' ); ?>
  
  
<?php

// COUNTRY LIST
$countrylist = array();
foreach ($GLOBALS['core_country_list'] as $key=>$option) {
$countrylist[$key] = array("id" => $key , "name" => $option);
} 

$g = array(

 "account_usercountry" => array(
		 
			 "name" => __("Default Country","premiumpress"),  
			 "desc" => __("Select a default display country for users.","premiumpress"), 
			 "type" => "select", 
			 "values" => $countrylist, 
		 ),


);
foreach ($g as $fieldkey => $fielddata){ echo $CORE_ADMIN->LoadCongifField($fielddata, $fieldkey, "user"); }
?>

      <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
    
  </div>
</div>
<!-- end admin card -->
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>




<?php 

if(!in_array(THEME_KEY, array("es")) ){

  $settings = array(
  
  "title" => __("WordPress Author Pages","premiumpress"), 
  "desc" => __("Here you can turn on/off display options on the default WordPress author pages.","premiumpress"),
  
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
  
   
<div class="card card-admin">
  <div class="card-body">
<?php
  
$g = array(

"allow_profile" => array(
		 
			 "name" => __("Author Pages","premiumpress"), 
			 "desc" => __("Turn OFF to prevent users from accessing the WordPress author page","premiumpress"), 
			 "type" => "yesno", 
			 "d" => "1",
			  "col8" => true 
		 ),	
		 
		 "author_feedback" => array(
		 
			 "name" => __("Author Feedback","premiumpress"), 
			 "desc" => __("Turn OFF to hide feedback display on the author profile page.","premiumpress"), 
			 "type" => "yesno", 
			 "d" => "1",
			  "col8" => true 
		 ),	
		 
		 "author_comments" => array(
		 
			 "name" => __("Author Comments","premiumpress"), 
			 "desc" => __("Turn OFF to hide comment display on the author profile page.","premiumpress"), 
			 "type" => "yesno", 
			 "d" => "1",
			  "col8" => true 
		 ),
		 
		 "author_ads" => array(
		 
			 "name" => __("Author Ads","premiumpress"), 
			 "desc" => __("Turn OFF to hide ads display on the author profile page.","premiumpress"), 
			 "type" => "yesno", 
			 "d" => "1",
			  "col8" => true 
		 ),	 
		 
		 "author_reputation" => array(
		 
			 "name" => __("Author Reputation","premiumpress"), 
			 "desc" => __("Turn OFF to hide the reputation display on the author profile page.","premiumpress"), 
			 "type" => "yesno", 
			 "d" => "1",
			 "col8" => true 
		 ),

);
foreach ($g as $fieldkey => $fielddata){ echo $CORE_ADMIN->LoadCongifField($fielddata, $fieldkey, "user"); }
?>

 


      <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
    
  </div>
</div>
<!-- end admin card -->
<?php _ppt_template('framework/admin/_form-wrap-bottom' );


} ?>