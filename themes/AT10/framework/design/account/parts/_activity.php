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

$e1 = _ppt(array('user', "feed-activity")); if($e1 == "" || $e1 == 1){
?>

<div class="card shadow-sm border-0 hide-mobile">
  <div class="card-header bg-white">
    <h6><?php echo __("My Activity","premiumpress"); ?></h6>
    <p><?php echo __("Recent account changes.","premiumpress"); ?></p>
  </div>
  <div class="card-body">
    <div style="max-height:450px; overflow-y: scroll;"> <?php echo $CORE->USER("get_logs", $userdata->ID); ?> </div>
  </div>
</div>
<?php } ?>