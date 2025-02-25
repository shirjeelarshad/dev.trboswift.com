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


 
if(isset($settings['topmenu_show']) && $settings['topmenu_show'] == "yes"){ 

// LANGUAGES
$languages =  $CORE->GEO("get_languagelist",array()); 
 
// CURRENCY
$currency =  $CORE->GEO("get_currencylist",array()); 
if(!isset($settings['topmenu_bg'])){
	$settings['topmenu_bg'] = "bg-dark";
}
 
 
$phone = _ppt(array('company','phone'));
$email = _ppt(array('company','email'));

if(isset($_GET['ppt_live_preview']) && $phone == ""){
$phone = "123 456 789";
}

if(isset($_GET['ppt_live_preview']) && $email == ""){
$email = "admin@mywebsite.com";
} 
 
// if ($userdata->ID) {
?>

<nav class="bg-secondary elementor_topmenu d-none d-md-block <?php if(isset($settings['topmenu_bg'])){ echo $settings['topmenu_bg']; } ?> text-light">
  <div class="container">
    <div class="row">
      <div class="col-md-6 pr-0"> 
      <ul class="topbar-info main-header hide-ipad d-flex p-0">

                  <li class="d-none">
                   
                      <span class="media">
                        <span class="media-left">
                          <span class="icon">
                            <i class="fas fa-phone-alt fa-xs text-white" style="    font-size: 13px !important;"></i>
                          </span>
                        </span>
                        <span class="media-content"><a href="tel:<?php echo $phone; ?>">
                         <strong><?php echo $phone; ?></strong>
                     </a>
                      </span>
                  
                  </li>
                  <li class="d-none">
                   
                      <span class="media">
                        <span class="media-left">
                          <span class="icon">
                            <i class="fas fa-envelope fa-xs text-white" style="    font-size: 13px !important;" ></i>
                          </span>
                        </span>
                        <span class="media-content">
                        <a href="mailto:<?php echo $email; ?>">
                         <strong><?php echo $email; ?></strong>
                          </a>
                      </span>
                  
                  </li>
</ul> 
      </div>
      <div class="col d-none d-md-block">
        <ul class="list-inline p-0 mb-0 float-right seperator">
           <!--<li class=" header-lang hide-mobile">-->
             <?php 
            //  echo do_shortcode('[gtranslate]'); 
             ?>
            <!--</li>-->
        
          <?php if(is_array($currency) && !empty($currency) ){  $dfc = $CORE->GEO("get_currency_icon",array()); ?>
          
          <li class="list-inline-item dropdown w  hide-mobile"> <a href="#" class="dropdown-toggle noc" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          
           	 <?php if(strpos($dfc, "fa") !== false){ ?>
              <i class="<?php echo $dfc; ?>"></i>
              <?php }else{ ?>
              <span><?php echo $dfc; ?></span>
              <?php } ?>
          </a>
            
            
            <div class="dropdown-menu mt-n2">
              <?php  foreach($currency as $h){ ?>
              <a class="dropdown-item" href="<?php echo $h['link']; ?>"> 
              
               <?php if(strpos($h['icon'], "fa") !== false){ ?>
              <i class="<?php echo $h['icon']; ?> float-right mt-2"></i>
              <?php }else{ ?>
              <span class="float-right mt-1"><?php echo $h['icon']; ?></span>
              <?php } ?>
              <?php echo $h['name']; ?></a>
              <?php } ?>
            </div>
          </li>
          
          <?php } ?>
        
        <?php /* if(THEME_KEY == "dt" && _ppt(array('maps','enable')) == 1 ){ ?>
         
         <li class="list-inline-item"> 
          
          <?php if(isset($_SESSION['mylocation'])){ ?>
        <span> <a href="javascript:void(0);" class="single-location-window text-primary"> <span class="fa fa-map-marker ppt_locationflag"></span></a> </span>
        <?php }else{ ?>
        
        <span> <a href="javascript:void(0);" class="single-location-window text-primary"> <i class="fa fa-map-marker"></i> </a> </span>
        <?php } ?>
                 
           </li>
           <?php } */ ?>
        
           
         
          
          <?php if(is_array($languages) && !empty($languages)){ ?>
          <li class="list-inline-item w dropdown hide-mobile"> <a href="#" class="dropdown-toggle noc" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="flag flag-<?php echo $CORE->GEO("get_language_icon",array());  ?>">&nbsp;</span></a>
            <div class="dropdown-menu mt-n2">
              <?php foreach($languages as $h){ ?>
              <a class="dropdown-item" href="<?php echo $h['link']; ?>"><i class="<?php echo $h['icon']; ?> float-right mt-2"></i> <?php echo $h['name']; ?></a>
              <?php } ?>
            </div>
          </li>
          <?php } ?>
          <li class="list-inline-item pr-0 ">
            <div class="socials">
              <?php if(_ppt(array('company','twitter')) != ""){ ?>
              <a class="social" target="_blank" href="<?php 
			  
			   $tw_link = _ppt(array('company','twitter'));
		  if(strpos($tw_link ,"twitter.com") === false){		  
		  	$tw_link  = "https://www.twitter.com/"._ppt(array('company','twitter'));		  
		  }	
		  echo $tw_link;
			  
			  
			   ?>" title="Twitter"> <img data-src="<?php echo get_template_directory_uri(); ?>/framework/images/twitter_icon.svg" alt="twitter" class="img-fluid lazy rounded-0" height="16" width="16" /> </a>
              <?php } ?>
              <?php if(_ppt(array('company','facebook')) != ""){ ?>
              <a class="social" target="_blank" href="<?php 
			  
			   $fb_link = _ppt(array('company','facebook'));
		  if(strpos($fb_link,"facebook.com") === false){		  
		  	$fb_link = "https://www.facebook.com/"._ppt(array('company','facebook'));		  
		  }	
		  
		  echo $fb_link;
			  
			  
			   ?>" title="Facebook"> <img data-src="<?php echo get_template_directory_uri(); ?>/framework/images/facebook_icon.svg" alt="twitter" class="img-fluid lazy" height="16" width="16" /> </a>
              <?php } ?>
              <?php if(_ppt(array('company','youtube')) != ""){ ?>
              <a class="social" target="_blank" href="<?php 
			  
			  
			  $yt_link = _ppt(array('company','youtube'));
		  if(strpos($yt_link ,"youtube.com") === false){		  
		  	$yt_link  = "https://www.youtube.com/"._ppt(array('company','youtube'));		  
		  }	
		  
		  echo $yt_link;
			  
			   ?>" title="YouTube"> <img data-src="<?php echo get_template_directory_uri(); ?>/framework/images/youtube_icon.svg" alt="twitter" class="img-fluid lazy" height="16" width="16" /> </a>
              <?php } ?>
              <?php if(_ppt(array('company','instagram')) != ""){ ?>
              <a class="social" target="_blank" href="<?php
			  
			  $in_link = _ppt(array('company','instagram'));
			  
		  if(strpos($in_link,"instagram.com") === false){		  
		  	$in_link  = "https://www.instagram.com/"._ppt(array('company','instagram'));		  
		  }	
		  
		  echo $in_link;
			  
			  
			   ?>" title="Instagram"> <img data-src="<?php echo get_template_directory_uri(); ?>/framework/images/instagram_icon.svg" alt="twitter" class="img-fluid lazy" height="16" width="16" /> </a>
              <?php } ?>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
<?php }
//}
?>