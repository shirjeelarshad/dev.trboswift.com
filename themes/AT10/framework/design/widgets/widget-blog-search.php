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
   
   global $CORE, $userdata, $settings, $post; 
   
 
   
   if(!_ppt_checkfile("widget-blog-search.php")){
   ?>

<div class="card card-blog">
  <div class="card-body">
    <h5 class="card-title">
      <?php  echo __("Search","premiumpress"); ?>
    </h5>
    <form action="<?php echo _ppt(array('links','blog')); ?>/" method="get">
      <div class="position-relative">
        <input type="text" class="form-control" name="keyword" placeholder="<?php  echo __("Keyword..","premiumpress"); ?>">
        <button type="submit" class="position-absolute btn btn-sm" style="top:5px; right:10px;"><i class="fa fa-search"></i></button>
      </div>
    </form>
  </div>
</div>
<?php } ?>
