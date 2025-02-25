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

global $CORE, $post;
 
 
?>

<div class="<?php echo $post->cardclass; ?>" <?php echo $post->carddata; ?>>
  <div class="row no-gutters">
    <div class="col-lg-4"> <?php echo $post->image_formatted; ?> </div>
    <div class="col-lg-8">
      <div class="new-search-body">
        <div class="card-category mb-2"><?php echo do_shortcode('[USERTYPE]'); ?></div>
        <h3><a href="<?php echo $post->link; ?>"><?php echo $CORE->USER("get_username", $post->post_author); ?></a></h3>
        <div class="card-bottom text-center d-md-flex justify-content-between">
        
        
  
           
        </div>
      </div>
    </div>
  </div>
</div>
