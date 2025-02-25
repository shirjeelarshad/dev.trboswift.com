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

global $wpdb, $CORE, $CORE_ADMIN;


// GET LANGUAGES
$langs = _ppt('languages');
 
?>
 
 
 
 <?php

// WARNING FOR NONE MENU 
$locations = get_nav_menu_locations();
$menu_name = "mainmenu_en_US";
if ( ( $locations ) && isset( $locations[ $menu_name ] ) && $locations[ $menu_name ] != 0 ) {		


}else{
 

 ?>
 
<div class="col-12">

<div class="alert alert-info">

<i class="fal fa-smile float-left mr-3 fa-3x mb-5"></i>

<h4>You are using the demo menu bar.</h4>

<p>You have not yet setup your own menu bar therefore the demo one is being displayed instead. We recommend you setup your own, video tutorial here; <br /> <a href="https://www.youtube.com/watch?v=djD9HWDikmg" class="mt-4 btn btn-info shadow-sm btn-sm px-3 popup-yt"><i class="fa fa-video mr-1"></i> watch video</a>
 </p>


 
</div>
 

</div>
<?php } ?>
 
 
 
 
 
 
 <div class="col-12 border-bottom py-3 px-0">
  <div class="row">
    <div class="col-md-8">
      <label><?php echo __("Header Menu","premiumpress"); ?></label>
      <p class="pb-0 btn-block text-muted mb-0 mt-2"><?php echo __("The header menu is edited within the WordPress menu area.","premiumpress"); ?></p>
    </div>
    <div class="col-md-4">
      <div class="input-group mb-2">
      
         <a href="nav-menus.php" class="btn btn-admin color2"><?php echo __("Edit Menu","premiumpress"); ?></a>
         
      </div>
    </div>
  </div>
</div>
 
 
 
 
 <div class="col-12 border-bottom py-3 px-0">
  <div class="row">
    <div class="col-md-8">
      <label><?php echo __("Footer Mobile Menu","premiumpress"); ?></label>
      <p class="pb-0 btn-block text-muted mb-0 mt-2"><?php echo __("Turn on/off the footer mobile menu.","premiumpress"); ?></p>
    </div>
    <div class="col-md-4">
      <div class="input-group mb-2">
        <div class="formrow">
          <div class="">
            <label class="radio off" style="display: none;">
            <input type="radio" name="toggle" value="off" onchange="document.getElementById('footer_mobile_menu').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle" value="on" onchange="document.getElementById('footer_mobile_menu').value='1'">
            </label>
            <div class="toggle <?php if( _ppt('footer_mobile_menu') == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
            <input type="hidden" id="footer_mobile_menu" name="admin_values[footer_mobile_menu]"  value="<?php if(_ppt('footer_mobile_menu') == ""){ echo 1; }else{ echo _ppt('footer_mobile_menu'); } ?>">
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>
 
 
 
 
 
 
 
 
 
 
<div class="clearfix btn-block my-4">

  <div class="row mb-2">
  
   <div class="col-1 pr-0 small text-muted">  <?php echo __("Icon","premiumpress"); ?>  </div>
  
  
    <div class="col-6 small text-muted"> <?php echo __("Display Caption","premiumpress"); ?> </div>
    
   
    <div class="col-5 small text-muted px-0"> <?php echo __("Website Link","premiumpress"); ?> </div>
      
    </div>
    
  </div>
  
  <hr />
  
<?php


$defaults = array(

	
	1 => array(
		"n" => __("Home","premiumpress"),
		"i" => "fal fa-home",
		"l" => home_url(),
	),
	2 => array(
		"n" => __("Search","premiumpress"),
		"i" => "fal fa-search",
		"l" => home_url()."/?s=",
	),	
	3 => array(
		"n" => "",
		"i" => "fal fa-bars",
		"l" => "[menu]",
	),
	4 => array(
		"n" => "",
		"i" => "fa1 fa-user",
		"l" => "[login]",
	),	
	5 => array(
		"n" => "Blog",
		"i" => "fal fa-newspaper",
		"l" => _ppt(array('links','blog')),
	),		
		
);

$i=1;
while($i < 6){

$menu_id = $i;



?>
<div class="row mt-2">


  
     <div class="col-1">
            
     
      <input type="hidden" name="admin_values[mobilemenuicon][<?php echo $menu_id; ?>]" id="tax_icon_<?php echo $menu_id; ?>"  value="<?php if(_ppt(array('mobilemenuicon', $menu_id)) != ""){ echo _ppt(array('mobilemenuicon', $menu_id)); }else{ echo $defaults[$menu_id]["i"]; }  ?>" />
     
      <i class="<?php if(_ppt(array('mobilemenuicon', $menu_id)) != ""){ echo str_replace("fa fa ","fa ",_ppt(array('mobilemenuicon', $menu_id))); }else{ echo "fa fa-cog"; }  ?> float-left mr-2 fa-1x border p-2" style="cursor:pointer;" id="tax_icon_<?php echo $menu_id; ?>_icon" onclick="loadiconbox('tax_icon_<?php echo $menu_id; ?>','<?php if(_ppt(array('mobilemenuicon', $menu_id)) != ""){ echo _ppt(array('mobilemenuicon', $menu_id)); }else{ echo "fa fa-cog"; }  ?>');"></i>
      
      
     </div>
      
      
      
  
    <div class="col-6">
    
    
      <input class="form-control small" name="admin_values[mobilemenucaption][<?php echo $menu_id; ?>]"  value="<?php if(_ppt(array('mobilemenucaption', $menu_id)) != ""){ echo _ppt(array('mobilemenucaption', $menu_id)); }else{ echo $defaults[$menu_id]["n"]; }  ?>" />
     
      <div class="mt-1">
      
      
       <?php if(is_array($langs) && !empty($langs) && count($langs) > 1   ){  ?>
      <a href="javascript:void(0);" onclick="jQuery('.showtaxtranslations<?php echo str_replace(" ","-",$menu_id); ?>').toggle();" class="tiny"><?php echo __("Show translations","premiumpress"); ?></a> 
       
       <?php } ?>  
      
      </div>
       
          
      
 <?php if(is_array($langs) && !empty($langs) && count($langs) > 1 ){ ?>
                
                <div id="" class="p-3 py-2 bg-light mt-3 showtaxtranslations<?php echo str_replace(" ","-",$menu_id); ?>" style="display:none;">
                  <?php foreach(_ppt('languages') as $lang){
			
					$icon = explode("_",$lang); 
			
					if(isset($icon[1]) && strtolower($icon[1]) == "us"){ continue; } 
				
				?>
                  <div class="mt-3">
                    <div class="mb-2 small">
                      <div class="flag flag-<?php if(isset($icon[1])){ echo strtolower($icon[1]); }else{ echo $icon[0]; } ?> mr-2">&nbsp;</div>
                      <?php echo $CORE->GEO("get_lang_name", strtolower($lang)); ?>   </div>
                   
                   <input class="form-control small" name="admin_values[mobilemenucaption_<?php echo strtolower($lang); ?>][<?php echo $menu_id; ?>]" 
                    value="<?php if(_ppt(array('mobilemenucaption_'.strtolower($lang), $menu_id)) != ""){ echo _ppt(array('mobilemenucaption_'.strtolower($lang), $menu_id)); }else{ echo $defaults[$menu_id]["n"]; }  ?>" />
                   
                  </div>
                 
                  <?php } ?>
                </div>
<?php } ?>
      
      
      
      
      
    </div>
    
    
    
     
    
    
     <div class="col-5">
     
      <input class="form-control small" style="font-size:11px !important;" name="admin_values[mobilemenulink][<?php echo $menu_id; ?>]"  value="<?php if(_ppt(array('mobilemenulink', $menu_id)) != ""){ echo _ppt(array('mobilemenulink', $menu_id)); }else{ echo $defaults[$menu_id]["l"]; }  ?>" />
       
      </div>    
    
 
 </div> 
<?php $i++; } ?>
  
 