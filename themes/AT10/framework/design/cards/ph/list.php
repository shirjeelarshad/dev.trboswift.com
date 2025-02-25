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
 
 /*
ob_start();	
?>
<?php echo do_shortcode('[IMAGE link=0 showdata=1]'); ?>
<?php   
$image = ob_get_clean();
ob_get_flush();
preg_match_all('/(data-width|data-height)=("[^"]*")/i',$image, $result); 
$height = 1080;
$width = 1920;
if(isset($result[2]) && isset($result[2][1])){
$height = preg_replace("/[^0-9,.]/", "", $result[2][1] );
$width = preg_replace("/[^0-9,.]/", "", $result[2][0] );
}
*/
 
?>
<div data-pid="<?php echo $post->ID; ?>" class="card-search card-top-image stock-item">
  
  
<div class="listing-grid-item bg-dark">
      <div class="content">
         <a href="<?php echo the_permalink($post->ID); ?>">
            <div class="image">
            <?php echo do_shortcode('[IMAGE link=0 showdata=1]'); ?>
            </div>
           
            <div class="listing-grid-info">
               <div class="mb-1 clearfix">          
                
                  <div> <i class="fa fa-download"></i> <?php echo do_shortcode('[DOWNLOADS]'); ?>  <i class="fa fa-eye ml-3"></i> <?php echo do_shortcode('[HITS]'); ?> </div>
               </div>    
            </div>             
         </a>
      </div>
   </div>
  
</div>
