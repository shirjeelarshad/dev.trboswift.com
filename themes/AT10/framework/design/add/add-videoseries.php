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
if(isset($_GET['eid']) && is_numeric($_GET['eid'])){
$editID = $_GET['eid'];
}  
 
?>
<div class="card shadow-sm <?php if(!isset($_POST['ajaxedit'])){ ?>mt-5<?php } ?>">
  <div class="card-body">

  <?php if(!isset($_POST['ajaxedit'])){ ?>
  <a href="javascript:void(0);" onclick="jQuery('#showvbox').slideToggle();" style="float:right; font-size:30px;"><i class="fa fa-chevron-down f-3x"></i></a>
  <?php } ?>
  
  
    <h4><?php echo __("Video Series","premiumpress"); ?></h4>
    <p class="text-muted"><?php echo __("Enter the video ID of other videos to setup a video series.","premiumpress"); ?></p>
    
<div class="row border-top pt-3" <?php if(!isset($_POST['ajaxedit'])){ ?>style="display:none;"<?php } ?> id="showvbox">


<?php $i =1; while($i < 10){ ?> 
<div class="col-md-4 mt-3">

<label><?php echo __("Video","premiumpress"); ?> ID <?php echo $i; ?></label>
<input type="text" name="custom[vt_video<?php echo $i; ?>]" class="form-control numericonly" value="<?php echo $CORE->get_edit_data('vt_video'.$i, $editID);  ?>"  />
</div>


<?php $i++; } ?>
    
</div></div></div>
 