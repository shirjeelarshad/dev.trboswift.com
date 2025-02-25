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

global $CORE, $userdata, $settings; 
?>
<!-- MAIN BODY WRAP -->

<div id="accountpage-body" style="display:nonexx;" class="bg-white">
<div class="wrapper d-flex align-items-stretch">
<nav id="account_sidebar">
  <div class="custom-menu">
    <button type="button" class="btn menu-toggle-account"> <i class="fa fa-bars text-white"></i> <span class="sr-only">Toggle Menu</span> </button>
  </div>
  <div class="bg-primary" style="height:100px;"> </div>
  <div class="col-md-7 mx-auto mt-n5 pl-0 sidebar-userphoto clearfix text-center"> <a onclick="showdetails('photo');" href="javascript:void(0);" class="position-relative"> <span class="ml-2"> <img class="rounded-circle img-fluid" src="<?php echo $CORE->USER("get_avatar", $userdata->ID ); ?>" alt="user "> </span>
    <?php if(_ppt(array('user','level')) == "0"){ }else{  ?>
    <div class="levelicon active withtext position-absolute" style="bottom:20px; right:0px;"> <span><?php echo  $CORE->USER("get_level",$userdata->ID); ?></span> <small><?php echo __("level","premiumpress"); ?></small> </div>
    <?php } ?>
    </a> </div>
  <div class="clearfix"></div>
  
  <div class="text-center w-100 mt-3">
  
  <h5>
  
        <?php if(get_user_meta($userdata->ID,'old_username',true) != ""){ ?>
      <?php echo $CORE->USER("get_username", $userdata->ID );  ?>
      
      <?php }else{ ?>
      <a href="javascript:void(0);" class="text-white" style="text-decoration:none;" onclick="showdetails('details'); showdetails('username');"><?php echo $CORE->USER("get_username", $userdata->ID );  ?> <i class="fal fa-pencil"></i></a>
      
      <?php } ?>
  
</h5>
  
    <?php /* if(get_user_meta($userdata->ID,'ppt_verified',true) == 1){ ?>
    <div class="btn btn-system"><i class="fa fa-award text-success"></i> <?php echo __("Verified","premiumpress") ?></div>
    <?php }else{ ?>
    <div class="btn btn-system"><i class="fa fa-award text-danger"></i> <?php echo __("Not Verified","premiumpress") ?></div>
    <?php } */ ?>
    
    
    
  </div>
  <div class="text-center w-100 mt-3">
    <?php if( $CORE->LAYOUT("captions","memberships") && _ppt(array('mem','enable')) != 0 ){ 
			
			$mymem = $CORE->USER("get_user_membership", $userdata->ID);
			
			 ?>
    <a href="javascript:void(0)" class="small text-underline text-light" onclick="SwitchPage('membership');">
    <?php if($mymem == 0){ echo __("No Membership","premiumpress"); }else{ echo $mymem['name']; } ?>
    </a>
    <?php } ?>
  </div>
  <ul class="list-unstyled components mb-5 nav flex-column nav-pills mt-5" id="jumplinks">
    <?php   foreach($CORE->USER("get_account_links", array()) as $k => $i){ 	 
            if(isset($i['hidebox'])){ continue; }	
			
			//if(in_array($k, array('details','photo'))){ continue; }
							 
            ?>
    <li><a  <?php if($k == "details"){ ?>onclick="showdetails('details');" href="javascript:void(0);"<?php }elseif($i['link'] != ""){ ?>href="<?php echo $i['link']; ?>"<?php }else{ ?>onclick="SwitchPage('<?php echo $k; ?>');" href="javascript:void(0);"<?php } ?> class="nav-item nav-link tab-<?php echo $k; ?> <?php if($k == "dashboard"){ ?>selected<?php } ?>"> <span><?php echo $i['name'] ?></span> <i class="fal <?php echo $i['icon'] ?>"></i> </a>
      <?php  } ?>
    </li>
  </ul>
  <div class=" px-4">
    <?php if(_ppt(array('user','allow_profile')) == 1){ 
	
	$ulink = $CORE->USER("get_user_profile_link", $userdata->ID);
	?>
    <a href="<?php echo $ulink; ?>" <?php if($ulink == "0"){ ?>style="display:none;"<?php } ?> class="btn btn-dark btn-block btn-sm py-2 viewp"><?php echo __("View My Profile","premiumpress"); ?></a>
    <?php } ?>
    <div class="mt-3"> <a href="<?php echo wp_logout_url(); ?>" class="btn btn-dark btn-sm py-2 small text-uppercase btn-block"><i class="fa fa-sign-out"></i> <?php echo __("Logout","premiumpress"); ?></a> </div>
  </div>
</nav>
<div id="account_content">

<div class="main h-100">
