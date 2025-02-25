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
   
 
   
   if(!_ppt_checkfile("widget-blog-categories.php")){
   ?>
   
   
<div class="card card-blog">
  <div class="card-body">
    <h5 class="card-title"><?php  echo __("Categories","premiumpress"); ?></h5>
    
 
<ul class="list-group list-group-flush">
  <?php
  
$terms = get_terms( 'category', array('hide_empty' => 1) );
if(!empty($terms)){
foreach($terms as $t){ $term_link = get_term_link( $t ); ?>
<li class="list-group-item d-flex justify-content-between align-items-center px-0">
<a href="<?php echo $term_link; ?>" class="text-muted"><?php echo $CORE->GEO("translation_tax", array($t->term_id, $t->name)); ?></a>
<span class="badge bg-primary text-white badge-pill"><?php echo $t->count; ?></span>

</li>
<?php } } ?>
</ul>

</div>
</div>
 
<?php } ?>