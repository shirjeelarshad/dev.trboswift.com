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

global $CORE, $settings, $userdata;
 
if(!isset($settings['extra_show'])  ){
$settings['extra_show'] = "yes";
}

$phone = _ppt(array('company','phone'));
$email = _ppt(array('company','email'));

if(isset($_GET['ppt_live_preview']) && $phone == ""){
$phone = "123 456 789";
}

if(isset($_GET['ppt_live_preview']) && $email == ""){
$email = "admin@mywebsite.com";
}


?>
 

<ul class="topbar-info main-header ">
  <li class="hide-mobile hide-ipad">
      <?php  if ($userdata->ID) { ?>
    <form action="<?php echo home_url(); ?>" class="search">
      <div class="input-group">
        <input type="text" class="form-control rounded-0 typeahead" name="s" placeholder="<?php
		
		if(THEME_KEY == "cp"){
		
		echo __("Store name or keyword..","premiumpress");
		
		}else{
		
		  echo __("Search by Brand, Model, Year","premiumpress");
		  
		}  
		  
		   ?>" autocomplete="off">
        <div class="input-group-append">
          <button class="btn <?php echo $settings['btn-class']; ?>  rounded-0 text-uppercase px-3 border-0" type="submit"> <?php echo __("Search","premiumpress"); ?> </button>
        </div>
      </div>
    </form>
    
    <?php } ?>
  </li>
  <?php if($settings['extra_show'] == "yes"){ 
  
  if(!isset($settings['extra_type'])){ $settings['extra_type'] = ""; }
  
  if($settings['extra_type'] == ""){
  ?>
  <li class="hide-ipad hide-mobile phonesingle"> <span class="media"> <span class="media-left"> <span class="icon"> <i class="fal fa-phone-alt text-primary"></i> </span> </span> <span class="media-content"> <strong class="btn-block mt-n2" style="font-size:20px;"><?php echo $phone; ?></strong> <span class="opacity-5"><?php echo $email; ?></span> </span> </span> </li>
  <?php  if ($userdata->ID) {}else{ ?>
  
  <li class=" phonesingle"> <a href="<?php echo home_url(); ?>/wp-login.php?"> <span class="icon"> <i class="fas fa-user text-white"></i> </span>   </a>  </li>
  
  <?php 
  }
  }elseif($settings['extra_type'] == "button"){ ?>
   
  
             <li class="hide-mobile">
            
             <?php
			 
			 if(THEME_KEY == "sp"){
			 
			 _ppt_template( 'framework/design/parts/cart' ); 
			 
			 }else{		 
			 
			  _ppt_template( 'framework/design/parts/btn' ); 
			  
			 } 
			  
			  ?>
             
            </li> 
 

<?php  }elseif($settings['extra_type'] == "icons"){ ?>



  <?php if( ( defined('WLT_DEMOMODE') ||  get_option('users_can_register') == 1 )   ){ ?>
            <li class=" hide-mobile" style="border-right:none !important">
             
            
            <?php if(!$userdata->ID){ ?>
            <a href="javascript:void(0);" onclick="processLogin();" class="tm">
           <img class="rounded-circle img-fluid lazy" data-src="<?php echo get_template_directory_uri(); ?>/framework/images/avatar/none.png" alt="user" style="max-width:50px;"> 
            </a>
            <?php }else{ ?>
            <a href="<?php echo _ppt(array('links','myaccount')); ?>" class="tm">
            
            <img class="rounded-circle img-fluid lazy" data-src="<?php echo $CORE->USER("get_avatar", $userdata->ID ); ?>" alt="user" style="max-width:50px;"> 
           
           </a>
            <?php } ?>           
            
            
                       
            </li>
            <?php } ?>                 
        
			 
             <?php if(defined('WLT_CART')){ ?>
             <li class="list-inline-item hide-mobile">
             <a href="<?php echo _ppt(array('links','cart')); ?>" class="tm"><i class="fal fa-shopping-basket"></i></a>             
            </li>
            <?php } ?>
         
            
             
<?php
  
  
  } }?>
</ul>
<button class="navbar-toggler menu-toggle tm border-0"><i class="fas fa-bars fa-lg text-white"></i></button>