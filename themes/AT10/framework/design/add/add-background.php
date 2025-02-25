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


$editID=0;
$currentimg = "";
if(isset($_GET['eid']) && is_numeric($_GET['eid'])){
$editID = $_GET['eid'];
$currentimg = get_post_meta($editID, "backgroundimg", true);
} 

 
 
?>

<div class="card shadow-sm mt-4">
  <div class="card-body">
    <div class="row">
      <div class="col-12">
        <h4><?php echo __("Background Image","premiumpress"); ?></h4>
        <hr />
      </div>
      <?php

$lst_backgrounds = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14);


foreach($lst_backgrounds as $k ){

$defaultimg = DEMO_IMG_PATH."backgroundimages/".$k.".jpg";
 



?>
      <div class="col-md-6 text-center p-2">
        <figure> <img src="<?php if(_ppt(array('bgimg', $k)) == ""){ echo $defaultimg; }else{ echo _ppt(array('bgimg', $k )); } ?>" alt="img" class="img-fluid"> </figure>
        <input type="radio" class="form-control"  value="<?php echo $k; ?>" name="custom[backgroundimg]" <?php if( $currentimg == $k){ echo "checked=checked"; } ?> >
      </div>
      <?php } ?>
      
      
      
    </div>
  </div>
</div>
