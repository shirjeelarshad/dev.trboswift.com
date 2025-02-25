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
$paknames = array('Free','Featured','Sponsored' );

$g = $CORE->PACKAGE("get_packages", array());

// CREATE A BASE PACKAGE IF THIS ONE IS EMPTY
$noPaks = false;
if(empty($g)){ 

 $g = array( 1 => array(
            "key" => 1,
            "name" => "",
            "desc" => "",
            "price" => 0,
            "price_text" => "",
            "duration" => 10,
            "recurring" => 0,
			),
  );
  
  $noPaks = true;

}
 
 
foreach(  $g as $k => $n){  
?>

<script>
 
package["<?php echo $n['key']; ?>"] = {
		 
         	name:"<?php if($noPaks){ echo ""; }elseif(_ppt('pak'.$n['key'].'_name') != ""){ echo _ppt('pak'.$n['key'].'_name'); }else{ echo $paknames[$n['key']]; } ?>",
         	
			price:"<?php if($noPaks){ echo 0; }elseif(_ppt('pak'.$n['key'].'_price') == ""){ echo 0; }else{ echo _ppt('pak'.$n['key'].'_price'); } ?>",
			 
			subscription:"<?php if($noPaks){ echo 0; }elseif(_ppt('pak'.$n['key'].'_r') != 1){ echo 0; }else{ echo 1; } ?>",
								
			duration:"<?php if($noPaks){ echo 0; }elseif(_ppt('pak'.$n['key'].'_duration') == ""){ echo 10; }else{ echo _ppt('pak'.$n['key'].'_duration'); } ?>",
			
			duration_date:"<?php if($noPaks){ echo 0; }elseif(_ppt('pak'.$n['key'].'_duration') == ""){ 
			
			date("Y-m-d H:i:s", strtotime( date("Y-m-d H:i:s") . " +10 days"));
			
			}elseif(_ppt('pak'.$n['key'].'_duration') == 0){			
			
			}else{  
			
			echo date("Y-m-d H:i:s", strtotime( date("Y-m-d H:i:s") . " +"._ppt('pak'.$n['key'].'_duration')." days"));
			
			 } ?>",
			
			videos: <?php if($noPaks){ echo 1; }elseif(_ppt(array('lst','websitepackages')) == 0){ echo 1; }elseif(_ppt('pak'.$n['key'].'_videos') == ""){ echo 5; }else{ echo _ppt('pak'.$n['key'].'_videos'); } ?>,
			images:"<?php if($noPaks){ if(!is_numeric( _ppt(array('lst','default_images')))){ echo 10; }else{ echo _ppt(array('lst','default_images')); } }elseif( _ppt(array('lst','websitepackages')) == 0){ echo _ppt('pak0_images'); }elseif(_ppt('pak'.$n['key'].'_images') == ""){ echo 0; }else{ echo _ppt('pak'.$n['key'].'_images'); } ?>",
			 
			homepage:"<?php if($noPaks){ echo 0; }elseif(_ppt('pak'.$n['key'].'_homepage') == ""){ echo 0; }else{ echo _ppt('pak'.$n['key'].'_homepage'); } ?>",
			featured:"<?php if($noPaks){ echo 0; }elseif(_ppt('pak'.$n['key'].'_featured') == ""){ echo 0; }else{ echo _ppt('pak'.$n['key'].'_featured'); } ?>",
			sponsored:"<?php if($noPaks){ echo 0; }elseif(_ppt('pak'.$n['key'].'_sponsored') == ""){ echo 0; }else{ echo _ppt('pak'.$n['key'].'_sponsored'); } ?>",
 			
			category:"<?php if($noPaks){ if(_ppt(array('lst', 'default_multiplecats' )) == 1){ echo 1; }else{ echo 0; } }elseif(_ppt('pak'.$n['key'].'_category') == ""){ echo 0; }else{ echo _ppt('pak'.$n['key'].'_category'); } ?>",
 			
			  				
};
 
</script> 
<?php  } ?>