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

$vehicle_brand = wp_get_post_terms($post->ID, brand);

$vehicle_year = wp_get_post_terms($post->ID, year);

$vehicle_model = get_post_meta($post->ID, 'modelnum', true);

$vehicle_location = wp_get_post_terms($post->ID, location);

$auction_end_time = get_post_meta($post->ID, 'listing_expiry_date', true);
?>



<div class="bg-white p-2" > 
<div class="col-12 p-0">
    
<?php


$files = $CORE->MEDIA("get_all_images", $post->ID);

if (empty($files) || (count($files) == 1 && $files[0]['src'] == "")) {
    echo '<span>No Image</span>';
} elseif (count($files) > 0) {
    $f = $files[0]; // Get the first image
    ?>
    <a href="<?php echo get_permalink($post->ID); ?>" target="_blank"><img loading="lazy" style="width:100%;  border-radius: 15px; object-fit: cover; object-position: center center;" src="<?php echo $f['src']; ?>" data-src="<?php echo $f['src']; ?>" alt="image" class="upcoming-img-height img-fluid lazyload"></a>
<?php } ?>
 
 <div class="vehicle-image-left-content">
 <span class="vehicle-year"> <?php echo $vehicle_year[0]->name; ?> </span><br>
  <span class="vehicle-brand"> <?php echo $vehicle_brand[0]->name; ?> </span><br>
  <span class="vehicle-model"> <?php if ($vehicle_model) {
    echo $vehicle_model;
  } else { ?>
      <?php if (strlen($post->post_title) > 25) {
        echo substr($post->post_title, 0, 25) . '...';
      } else {
        echo $post->post_title;
      } ?>
    <?php } ?> </span>
</div><!-- Image left content close -->

<div class="vehicle-image-right-section"> 
 <span class="vehicle-location"> <?php echo $vehicle_location[0]->name; ?> </span>

</div>
    
</div>



<div class="col-12 row justify-content-between m-0 upcoming-right-section">
    
    <div class="p-0 small d-flex flex-column align-items-start justify-content-center text-dark font-weight-bold ">
                <span class="small" style="color:#444444;"><?php echo __("Latest bid", "premiumpress"); ?></span>
                <?php echo do_shortcode('[PRICE]'); ?>
                
              </div>
              
   
    
    <div class="p-0 small d-flex flex-column align-items-start justify-content-center text-primary font-weight-bold ">
                <span class="small" style="color:#444444;"><i class="fa-regular fa-clock  text-primary"></i><?php echo __("Time Left:", "premiumpress"); ?></span>
                <?php echo do_shortcode("[TIMELEFT]"); ?>
                

				                
            <?php
// Get the auction start and end times
$auction_start_time = get_the_date('Y-m-d H:i:s', $post->ID);
$auction_end_time = get_post_meta($post->ID, 'listing_expiry_date', true);
$current_time = current_time('mysql');

// Convert times to timestamps
$current_timestamp = strtotime($current_time);
$auction_end_timestamp = strtotime($auction_end_time);
$auction_start_timestamp = strtotime($auction_start_time);

// Calculate the duration and elapsed time
$auction_duration = $auction_end_timestamp - $auction_start_timestamp; 
$time_elapsed = $current_timestamp - $auction_start_timestamp;

// Calculate the progress percentage
$progress_percentage = ($time_elapsed / $auction_duration) * 100;
?>

<div class="progress-bar<?php echo $post->ID; ?>">
  <div class="progress<?php echo $post->ID; ?>"></div>
</div>

<style>
.progress-bar<?php echo $post->ID; ?> {
  width: 100%;
  height: 5px;
  background-color: lightgray;
  position: relative;
  border-radius: 5px;
  overflow: hidden;
}

.progress<?php echo $post->ID; ?> {
  width: 0%;
  height: 100%;
  background-color: #BF9B3E;
  position: absolute;
  border-radius: 5px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  function progressBar<?php echo $post->ID; ?>() {
    var progressBar = document.querySelector('.progress<?php echo $post->ID; ?>');
    var auctionEndTime = <?php echo $auction_end_timestamp; ?> * 1000; // Convert to milliseconds
    var auctionStartTime = <?php echo $auction_start_timestamp; ?> * 1000; // Convert to milliseconds
    var currentTime = new Date().getTime();
    
    if (currentTime >= auctionEndTime) {
      progressBar.style.width = '100%';
    } else {
      var totalDuration = auctionEndTime - auctionStartTime;
      var timeElapsed = currentTime - auctionStartTime;
      var progressPercentage = (timeElapsed / totalDuration) * 100;
      progressBar.style.width = progressPercentage + '%';
    }
  }

  progressBar<?php echo $post->ID; ?>();
});
</script>
                
              </div>
   
</div>





</div>




<style >

 .vehicle-image-left-content {
    position: absolute;
    left: 0px;
    bottom: 0px;
    padding: 10px;
}
 
 .vehicle-year, .vehicle-model, .vehicle-location{
 color: #FFFFFFB2;
 font-size:12px;
 
text-shadow: 1px 3px 10px rgba(0, 0, 0, 1);


 }
 
 .vehicle-brand{
 color:#fff;
 font-size:14px;
 font-weight:bold;
 text-shadow: 1px 3px 8px rgba(0, 0, 0, 0.39);

 }
 
 .vehicle-image-right-section{
     position: absolute;
    right: 0px;
    bottom: 0px;
    padding: 10px;
    
 }
    
    /* Styles for mobile */
@media screen and (max-width: 992px) {
  .upcomingHeading{
        font-size: 12px;
    font-weight: 700;
    color: #7a7a7a;
    }
    
  .upcoming-font-size{
      font-size:10px;
      padding-bottom:2px;
      margin:0px;
      }  
  
  
  
  .upcoming-img-height{
      height: 350px;
      
      
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
    
    }
      .upcoming-auction-card{
       width:100%;
       
        overflow: hidden;
   }
   
  .upcoming-font-size{
      font-size:12px;
      padding-bottom:2px;
      margin:0px;
  }      
  
  .upcoming-img-height{
      height: 350px;
  }
  
  .upcoming-right-section{
    padding: 10px;
    overflow: hidden;
  }
  
  
}    
    
</style>