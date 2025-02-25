<?php
/* 
 * Theme: rancoded CORE FRAMEWORK FILE
 * Url: www.rancoded.com
 * Author: Nuralam
 *
 * THIS FILE WILL BE UPDATED WITH EVERY UPDATE
 * IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
 *
 * http://codex.wordpress.org/Child_Themes
 */



if (!defined('THEME_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

global $CORE, $CORE_CART, $post, $userdata;

$customer_price = get_post_meta($post->ID, 'customer_price', true);
$auction_location = wp_get_post_terms($post->ID, 'location', true);
$sellername = get_post_meta($post->ID, 'sellername', true);

$auction_interior = wp_get_post_terms($post->ID, 'interior', true);
$auction_exterior = wp_get_post_terms($post->ID, 'color', true);

// GET CURRENT PRICE
$current_price = get_post_meta($post->ID, 'price_current', true);
if (!is_numeric($current_price)) {$current_price = 0;}

if($customer_price && !empty($customer_price) ){
                $auction_customer_price = $customer_price;
                
}else{
                $auction_customer_price = 0;
}
 
 
 $key1kilometers  = get_post_meta($post->ID, 'key1', true);



if($key1kilometers && !empty($key1kilometers) ){
                $kilometers = $key1kilometers;
                
}else{
                $kilometers = 'unknown';
}
 

?>



<div class="live-auction-card">


    <?php


    $files = $CORE->MEDIA("get_all_images", $post->ID);

    if (empty($files) || (count($files) == 1 && $files[0]['src'] == "")) {
        echo '<span>No Image</span>';
    } elseif (count($files) > 0) {
        $f = $files[0]; // Get the first image
        ?>
        <a href="<?php echo get_permalink($post->ID); ?>" target="_blank"><img loading="lazy" style="width:100%;border-radius: 10px; object-fit: cover; object-position: center;"
                src="<?php echo $f['src']; ?>" data-src="<?php echo $f['src']; ?>" alt="image"
                class="img-fluid lazyload"></a>
    <?php } ?>



    <div class="live-bottom-section my-3">

        <span class="live-font-size h5">
            <?php if (strlen($post->post_title) > 25) {
                echo substr($post->post_title, 0, 25) . '...';
            } else {
                echo $post->post_title;
            } ?>
        </span>
        
        <div class="small">
         <?php _ppt_template('framework/design/singlenew/parts/_global_content'); ?>
        </div>
        
        <div class="auction-info mt-3">
                    <div class="info">
                      <div class="auction-timer">
                        <div class="timer"></div>
                        <div class="time-left">
                          <div class="time">
                            <h2 class="auction-ending-in">Auction Ending in</h2>
                            <b class="h-43m"><?php echo do_shortcode('[TIMER]'); ?></b>
                          </div>
                        </div>
                      </div>
                      <div class="bid-info">
                        <div class="bids">
                          <div class="current-bid3">
                            <span class="icon" loading="lazy"><span>
                          </div>
                          <div class="bid-amount1">
                            <h2 class="current-bids">Current Bids</h2>
                            <b class="empty1"><?php echo do_shortcode('[PRICE]'); ?></b>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  
          <div class="mt-3"><a href="<?php echo get_permalink($post->ID); ?>" class="btn btn-secondary btn-block rounded-pill">Bid Now</a></div>
                  
                  
                  <div class="my-3">

            <h5 class="text-secondary mb-2 font-weight-bold "><?php echo __("Vehcile Info", "premiumpress"); ?>
            </h5>


            <div class="col-12 p-0 d-flex align-items-center my-3">
              <?php if($sellername){ ?>
               <div
                class="col-6 p-0 ">
                <span class="small" style="color:#444444;"><?php echo __("Seller: ", "premiumpress"); ?></span>
                <span class="text-primary font-weight-bold"><?php echo $sellername; ?></span>

              </div>
              <?php } ?>
              <?php if($auction_location[0]->name){ ?>
              <div
                class="col-6 p-0">
                <span class="small" style="color:#444444;"><?php echo __("Location: ", "premiumpress"); ?></span>
               <span class="font-weight-bold"> <?php echo $auction_location[0]->name; ?></span>

              </div>
				<?php } ?>
            </div>
            
            <div class="col-12 p-0 d-flex align-items-center my-3">
             <?php if($auction_interior[0]->name){ ?>
              <div
                class="col-6 p-0 ">
                <span class="small" style="color:#444444;"><?php echo __("Interior: ", "premiumpress"); ?></span>
               <span class="font-weight-bold"> <?php echo $auction_interior[0]->name; ?></span>

              </div>
              <?php } ?>
			<?php if($auction_exterior[0]->name){ ?>
              <div
                class="col-6 p-0">
                <span class="small" style="color:#444444;"><?php echo __("Exterior Color: ", "premiumpress"); ?></span>
               <span class=" font-weight-bold"> <?php echo $auction_exterior[0]->name; ?></span>

              </div>
               <?php } ?>


            </div>



          </div>
        
        
 </div>


</div>