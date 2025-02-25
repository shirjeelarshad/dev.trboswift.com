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


if(THEME_KEY != "cp" && isset($_GET['eid']) && is_numeric($_GET['eid'])){
$img = do_shortcode('[IMAGE pathonly=1 pid='.$_GET['eid'].']'); 	 		
?>

<div style="overflow:hidden;" class="bg-white shadow-sm border mb-4 position-relative text-center"> <img src="<?php echo $img; ?>" class="img-fluid" />
  <div class="position-absolute w-100 text-center" style="bottom:20px;"> <a href="#add-media-section"><span class="badge badge-warning"><?php echo __("Featured Image","premiumpress"); ?></span></a> </div>
</div>
<?php } ?>