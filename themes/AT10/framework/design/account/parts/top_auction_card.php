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



<div class="new-auction-card p-2">


    <?php


    $files = $CORE->MEDIA("get_all_images", $post->ID);

    if (empty($files) || (count($files) == 1 && $files[0]['src'] == "")) {
        echo '<span>No Image</span>';
    } elseif (count($files) > 0) {
        $f = $files[0]; // Get the first image
        ?>
        <a href="<?php echo get_permalink($post->ID); ?>" target="_blank"><img loading="lazy"
                style="width:100%; height:171px;  border-radius: 10px 10px 0 0; object-fit: cover; object-position: center;"
                src="<?php echo $f['src']; ?>" data-src="<?php echo $f['src']; ?>" alt="image"
                class="new-img-height img-fluid lazyload"></a>
    <?php } ?>



    <div class="top-bottom-section p-2">

        <span class="new-font-size small">
            <?php if (strlen($post->post_title) > 25) {
                echo substr($post->post_title, 0, 25) . '...';
            } else {
                echo $post->post_title;
            } ?>
        </span>
        
         <ul class=" mt-2  list-inline seperator">
 <li class="list-inline-item  pr-2">

 <span class="text-secondary font-weight-bold" style="font-weight:300; font-size:12px">
  <?php
 
$auction_gear = wp_get_post_terms($post->ID, 'transmission', true);
 
if (!empty($auction_gear ) && !is_wp_error($auction_gear )) {

    $gear_link = get_term_link($auction_gear[0]);

if (!is_wp_error($gear_link) && !empty($gear_link)) {
    echo '<a class="text-black" href="' . esc_url($gear_link) . '">' . esc_html($auction_gear[0]->name) . '</a>';
} else {
    echo esc_html($auction_gear[0]->name);
}
}

?>
 </span>
 </li>

  <li class="list-inline-item pr-2">

 <span class="text-black " style="font-weight:300; font-size:12px"><?php 
 
$auction_fuel = wp_get_post_terms($post->ID, 'fuel');
 
if (!empty($auction_fuel ) && !is_wp_error($auction_fuel )) {

    $auction_fuel_link = get_term_link($auction_fuel[0]);
    
    if (!is_wp_error($auction_fuel_link )) {
        echo '<a class="text-secondary font-weight-bold" href="' . esc_url($auction_fuel_link ) . '">' . esc_html($auction_fuel[0]->name) . '</a>';
    } else {
        echo $auction_fuel[0]->name; 
        
    }
}
 
 ?> </span>
 </li>
 <li class="list-inline-item pr-2">
 <span class="text-secondary font-weight-bold " style="font-weight:300; font-size:12px">
 <?php 
 echo get_post_meta($post->ID, 'key1', true);
 ?> KM
 </span>
 </li>
 </ul>
 
 <div class="bid-details">
                              <div class="current-bid">Current Bid:</div>
                              <div class="bid-amount">
                                <div class="bid-value">
                                  <div class="cad <?php echo $CORE->GEO("price_formatting",array()); ?>"><?php 
    // echo $post->price;
    
    if( !is_user_logged_in() || in_array('subscriber', $user_roles) || in_array('administator', $user_roles)  ) { echo $current_price + $auction_customer_price; }else{  echo $current_price; }
    
    ?></div>
                                </div>
                                <a href="<?php echo get_permalink($post->ID); ?>" class="view-details-button">
                               
                                  <div class="view-details-">
                                    View Details -&gt;
                                  </div>
                                </a>
                              </div>
                            </div>


    </div>

</div>