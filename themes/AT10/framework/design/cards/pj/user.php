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

global $CORE, $udata;
  
?>

<div class="card-user shadow-sm border"> 

<div class="card-body text-center pb-2">

<div class="text-center">

<div class="position-relative" style="max-width:150px; margin:auto;">
<img class="rounded-circle" src="<?php echo $CORE->USER("get_avatar", $udata->ID); ?>" alt="user ">

<?php if(_ppt(array('user','level')) == "0"){ }else{  ?>
<div class="levelicon active withtext position-absolute" style="bottom:20px; right:0px;"> 
<span><?php echo $CORE->USER("get_level", $udata->ID ); ?></span>
<small><?php echo __("level","premiumpress"); ?></small>
</div>
<?php } ?>

</div>

</div>

<h5><?php echo $CORE->USER("get_username", $udata->ID); ?></h5>

<div class="mb-3"> <?php echo do_shortcode('[RATING_USER uid='.$udata->ID.' reviews=0]'); ?></div> 

<div class="mb-3">
<a href="<?php echo $CORE->USER("get_user_profile_link", $udata->ID); ?>" class="btn btn-primary btn-sm"><?php  echo __("view profile","premiumpress"); ?></a>
</div>

</div>


</div>