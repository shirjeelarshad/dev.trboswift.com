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



<div class="upcoming-auction-card row m-0" style="background:#fff; box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px; border: 0px;     border-radius: 10px;"> 
<div class="col-6 p-0">
    
<?php


$files = $CORE->MEDIA("get_all_images", $post->ID);

if (empty($files) || (count($files) == 1 && $files[0]['src'] == "")) {
    echo '<span>No Image</span>';
} elseif (count($files) > 0) {
    $f = $files[0]; // Get the first image
    ?>
    <a href="<?php echo get_permalink($post->ID); ?>" target="_blank"><img loading="lazy" style="width:100%;  border-top-left-radius: 10px; border-bottom-left-radius: 10px;  object-fit: cover; object-position: center center;" src="<?php echo $f['src']; ?>" data-src="<?php echo $f['src']; ?>" alt="image" class="upcoming-img-height img-fluid lazyload"></a>
<?php } ?>
    
    
</div>
<div class="col-6 upcoming-right-section pl-2 pt-2">
    
    <p itemprop="name" class="upcoming-font-size "><?php if (strlen($post->post_title) > 25){ echo substr($post->post_title, 0, 25 ) . '...'; }else{ echo $post->post_title; }?></p>
    <p class="upcoming-font-size"><?php echo __("Price :", "premiumpress"); ?><?php echo do_shortcode('[PRICE]'); ?> </p>
   
</div>

</div>




<style >
    
    /* Styles for mobile */
@media screen and (max-width: 992px) {
  .upcomingHeading{
        font-size: 12px;
    font-weight: 700;
    color: #7a7a7a;
font-family: ITC Avant Garde Gothic Std;    }
    
  .upcoming-font-size{
      font-size:10px;
      padding-bottom:2px;
      margin:0px;
font-family: ITC Avant Garde Gothic Std;  }  
  
  
  
  .upcoming-img-height{
      height: 70px;
      
      
  }
  
  .upcoming-right-section{
    padding-left: 10px;
    padding-top: 10px;
    overflow: hidden;
  }
  
  
}
    
    
    
 /* Styles Desk */
    @media screen and (min-width: 992px) {
        
    .upcomingHeading{
        font-size: 15px;
    font-weight: 700;
    color: #7a7a7a;
    font-family: "ITCAvantGardeStd", Sans-serif;
    }
      .upcoming-auction-card{
       width:100%;
       
        overflow: hidden;
   }
   
  .upcoming-font-size{
      font-size:12px;
      padding-bottom:2px;
      margin:0px;
      font-family: "ITCAvantGardeStd", Sans-serif;
  }      
  
  .upcoming-img-height{
      height: 80px;
  }
  
  .upcoming-right-section{
    padding-left: 10px;
    padding-top: 10px;
    overflow: hidden;
  }
  
  
}    
    
</style>