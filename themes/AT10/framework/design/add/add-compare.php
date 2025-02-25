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

 
$data = array();
$content = "";
$for = "";
$against = "";
$rating = "5";
if(isset($_GET['eid'])){
	$data 		= get_post_meta($_GET['eid'],'comparedata',true);
	$content 	= get_post_meta($_GET['eid'],'cm_verdict',true);
	$for 		= get_post_meta($_GET['eid'],'cm_for',true);
	$against 	= get_post_meta($_GET['eid'],'cm_against',true);
	$rating 	= get_post_meta($_GET['eid'],'cm_rating',true);

}
 
?>
<div class="card shadow-sm <?php if(!isset($_POST['ajaxedit'])){ ?>mt-5<?php } ?>">
  <div class="card-body">
  <?php if(!isset($_POST['ajaxedit'])){ ?>
  <a href="javascript:void(0);" onclick="jQuery('#showvbox').slideToggle();" style="float:right; font-size:30px;"><i class="fa fa-chevron-down f-3x"></i></a>
  <?php } ?>
  
  
    <h4><?php echo __("Our Verdict","premiumpress"); ?></h4>
    <p class="text-muted"><?php echo __("Here you can add your own review for this product.","premiumpress"); ?></p>
    
<div class="row border-top pt-3" <?php if(!isset($_POST['ajaxedit'])){ ?>style="display:none;"<?php } ?> id="showvbox">

<div class="col-12">
 
<textarea class="form-control" style="height:250px !important;" name="custom[cm_verdict]"><?php echo $content; ?></textarea>
<div class="text-muted small mt-1"><?php echo __("leave blank to hide display.","premiumpress"); ?></div>
</div>

<div class="col-md-6 mt-4">
<h6><i class="fa fa-plus-circle"></i> <?php echo __("For","premiumpress"); ?></h6>
<textarea class="form-control" style="height:150px !important;" name="custom[cm_for]"><?php echo $for; ?></textarea>
<div class="text-muted small mt-1"><?php echo __("One item per line.","premiumpress"); ?></div>
</div>
<div class="col-md-6 mt-4">
<h6><i class="fa fa-minus-circle"></i>
<?php echo __("Against","premiumpress"); ?>
</h6>
<textarea class="form-control" style="height:150px !important;" name="custom[cm_against]"><?php echo $against; ?></textarea>
</div>
<div class="col-md-6 mt-3">

<label>Our Rating (1-5)</label>
<input type="text" name="custom[cm_rating]" class="form-control val-numeric" value="<?php echo $rating; ?>"  />
</div>
</div>


    
</div></div>
 