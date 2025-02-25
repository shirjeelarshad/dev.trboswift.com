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

global $CORE, $userdata; 

$value = array();
if(isset($_GET['eid'])){
$value = get_post_meta($_GET['eid'],'videoaccess',true);
}

 
 
	$status = array(
		"" 		=> __("Everyone"),
		"loggedin" 	=> __("Members Only"),		
		"subs" 	=> __("Members With Subscriptions"),
	);
	
	
	// GET ALL MEMBERSHIPS
	$all_memberships = $CORE->USER("get_memberships", array());
	foreach($all_memberships  as $key => $m){
				
			$status[$m['key']] = $m['name'];
				
	} 
	 
 
 
?>
<?php if(function_exists('current_user_can') && current_user_can('administrator') && _ppt(array('mem','enable')) == 1  ){ ?>

<hr style="margin: 0px -20px 15px -20px;" />
<h6><?php echo __("Membership Access","premiumpress"); ?></h6>
 
<?php 	$i=1; foreach($status as $key => $club){ ?>

<label class="custom-control custom-checkbox">
<input type="checkbox" class="form-control custom-control-input" name="custom[videoaccess][]" value="<?php echo $key; ?>" <?php 

if(empty($value) && $i == 1){  echo "checked"; }

elseif(is_array($value) && in_array($key, $value)){  echo "checked";  }

 ?>>
<div class="custom-control-label"><span><?php echo $club; ?></span></div>
</label>
 
<?php $i++; } ?>
<?php }else{ ?>
<input type="hidden" class="form-control" name="custom[videoaccess][]" value="0" />


<?php } ?>
 
