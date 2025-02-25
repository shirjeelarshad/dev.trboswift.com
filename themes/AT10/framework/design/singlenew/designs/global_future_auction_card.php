<?php 
   /* 
   * Theme: TURBOBID CORE FRAMEWORK FILE
   * Url: www.turbobid.ca
   * Author: Nuralam
   *
   * THIS FILE WILL BE UPDATED WITH EVERY UPDATE
   * IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
   *
   * http://codex.wordpress.org/Child_Themes
   */
   
   
   
   if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

global $CORE, $CORE_CART, $post, $userdata;


?>


<div class="future-auction-card row m-2 pl-0 pr-0" style="background:#fff; box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px; border: 0px;     border-radius: 10px; ">
<div class="col-6 col-xs-4  pl-0 pr-0">
    
<?php


$files = $CORE->MEDIA("get_all_images", $post->ID);

if (empty($files) || (count($files) == 1 && $files[0]['src'] == "")) {
    echo '<span>No Image</span>';
} elseif (count($files) > 0) {
    $f = $files[0]; // Get the first image
    ?>
    <a href="<?php echo get_permalink($_GET['eid']); ?>" target="_blank" >
    <img loading="lazy" style="width:100%;  border-top-left-radius: 10px; border-bottom-left-radius: 10px; object-fit: cover; object-position: center center;" src="<?php echo $f['src']; ?>" data-src="<?php echo $f['src']; ?>" alt="image" class="img-fluid future-img-height lazyload"> </a>
<?php } ?>
    
    
</div>
<div class="col-6 col-xs-8 pl-0 pr-0">
<div class="padding-right-section "  >
    
    <span itemprop="name"  class="text-dark future-font-size font-weight-bold"><?php echo do_shortcode('[TITLE]'); ?></span>
    
    <?php  _ppt_template( 'framework/design/singlenew/blocks/future-vehicle-details-field' );   ?>
    
    <a class="btn btn-secondary future-font-size" style=" border: 0px; border-radius: 20px; text-decoration:none; " href="<?php echo get_permalink($_GET['eid']); ?>" target="_blank" class="text-dark"> <?php echo __("Bid Now","premiumpress"); ?></a>
   
</div>

</div>

</div>



<style >
    
    /* Styles for mobile */
@media screen and (max-width: 992px) {
   .future-auction-card{
       width:100%;
       height: 200px;
        
   } 
    
  .future-font-size{
      font-size:12px;
  }
  
  
  
  .future-img-height{
      height: 200px;
      
      
  }
  
  .padding-right-section{
          padding-left: 10px;
    padding-top: 10px;
    
  }
  
  
}
    
    
    
 /* Styles Desk */
    @media screen and (min-width: 992px) {
      .future-auction-card{
           width:100%;
       height: 300px;
       
   }
   
  .future-font-size{
      font-size:16px;
  }      
  
  .future-img-height{
      height: 300px;
  }
  
  .padding-right-section{
    padding-left: 15px;
    padding-top: 20px;
    
  }
  
  
}    
    
</style>