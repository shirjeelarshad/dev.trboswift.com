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

global $CORE, $post, $userdata;

$user_roles = wp_get_current_user()->roles;
 $customer_price = get_post_meta($post->ID, 'customer_price', true);

 $seller_type = get_post_meta($post->ID, 'sellertype', true);
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

<div style="background: transparent !important; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.05) 0px 4px 6px -2px;" class="<?php echo $post->cardclass; ?>" <?php echo $post->carddata; ?>> <?php echo $post->image_formatted; ?>
  <div class="card-body position-relative bg-white">
  <div style="top: -45px!important; left: 10px;" class="list-inline btn-list cardtop hide-mobile hide-ipad"> 
  <?php if($seller_type){ ?>
  <span  style="background:#eee; color:#000; font-size:12px; font-weight:bold; padding-left: 10px;
      padding-right:10px;
      padding-top: 5px;
      padding-bottom: 5px; border-radius:5px;">
 <?php echo $seller_type ?></span> <?php } ?>
 </div>
 
    <ul style="top: -50px!important; right: 10px;" class="list-inline btn-list cardtop hide-mobile hide-ipad" <?php if(_ppt(array('lst','adminonly')) != 1 && _ppt(array('user','allow_profile')) == "0"){ }else{ ?>style="right:10px;"<?php } ?>>
    <?php if(_ppt(array('user','account_messages')) == 0 && _ppt(array('lst','adminonly')) != 1 ){ ?>
    
     <li class="list-inline-item" data-toggle="tooltip" data-placement="top" title="<?php echo __("Send Message","premiumpress"); ?>">
        <div> <a <?php echo $CORE->USER("get_message_link", $post->post_author); ?>><i class="fal fa-envelope text-primary"></i></a> </div>
      </li>
      <?php } ?>
      <?php if(in_array(_ppt(array('user','favs')), array("","1"))){ ?>
      <li class="list-inline-item" data-toggle="tooltip" data-placement="top" title="<?php echo __("Add Favorites","premiumpress"); ?>">
        <div> <?php echo do_shortcode('[FAVS icon=1 class="text-primary"]'); ?> </div>
      </li>
      <?php } ?>
      <?php if(isset($post->maplat) &&  strlen($post->maplat) > 1 ){ ?>
      <li class="list-inline-item" data-toggle="tooltip" data-placement="top" title="<?php echo __("Load Map","premiumpress"); ?>">
        <div> <a href="javascript:void(0);" 
    class="single-map-item text-primary" 
    data-title="<?php echo strip_tags($post->title); ?>" 
    data-url="<?php echo $post->link; ?>" 
    data-newlatitude="<?php echo $post->maplat; ?>" 
    data-address="<?php echo $post->maplocation; ?>" 
    data-newlongitude="<?php echo $post->maplong; ?>"><i class="fal fa-map-marker-alt"></i></a> </div>
      </li>
      <?php } ?>
    </ul>
    <?php if(_ppt(array('lst','adminonly')) != 1 && _ppt(array('user','allow_profile')) == "1"){ ?>
    <div class="author-img" data-toggle="tooltip" data-placement="top" title="<?php echo str_replace("%s", $CORE->USER("get_username", $post->post_author) ,__("sold by %s","premiumpress")); ?>"> <a href="<?php echo $CORE->USER("get_user_profile_link", $post->post_author); ?>"><?php echo $CORE->USER("get_photo", $post->post_author); ?></a></div>
    <?php } ?>
    <span class="mt-2 text-left"><a class="text-black" style="font-size:12px" href="<?php echo get_permalink($post->ID); ?>"><?php if (strlen($post->post_title) > 25) {
        echo substr($post->post_title, 0, 25) . '...';
      } else {
        echo $post->post_title;
      } ?></a></span>
    
   

<div class="text-secondary font-weight-bold h6 cad-price-element"><?php 
    // echo $post->price;
    
    if( !is_user_logged_in() || in_array('subscriber', $user_roles) || in_array('administator', $user_roles) && $auction_customer_price > 0 ) { echo $current_price + $auction_customer_price; }else{  echo $current_price; }
    
    ?></div>
    
     

 <div class=" my-2"> <div class="text-secondary small "><i class="fal fa-map-marker-alt"></i> <?php 
 
$auction_location = wp_get_post_terms($post->ID, 'location');
 
if (!empty($auction_location ) && !is_wp_error($auction_location )) {

    $auction_location_link = get_term_link($auction_location[0]);
    
    if (!is_wp_error($auction_location_link )) {
        echo '<a class="text-secondary font-weight-bold" href="' . esc_url($auction_location_link ) . '">' . esc_html($auction_location[0]->name) . '</a>';
    } else {
        echo $auction_location[0]->name; 
        
    }
}
 
 ?></div>

    
 <ul class=" mt-2  list-inline seperator">
 <li class="list-inline-item  pr-2">

 <span class="text-secondary font-weight-bold" style="font-weight:300; font-size:12px">
  <?php
 
$auction_gear = wp_get_post_terms($post->ID, 'transmission');
 
if (!empty($auction_gear ) && !is_wp_error($auction_gear )) {

    $gear_link = get_term_link($auction_gear [0]);
    
    if (!is_wp_error($term_link)) {
        echo '<a class="text-black" href="' . esc_url($gear_link) . '">' . esc_html($auction_gear[0]->name) . '</a>';

    } else {
        echo $auction_gear[0]->name; 
        
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
 
 <div class="card-bottom">
 
 <a href="<?php echo get_permalink($post->ID); ?>" class="btn btn-secondary rounded-pill text-white btn-block">Bid Now</a>
 
</div>

 </div>
   <!--- 
    <div class="card-bottom d-md-flex justify-content-between mt-md-3 text-left text-md-left text-secondary">
   <a    href="<?php echo get_permalink($post->ID); ?>" ><span class="h5 text-primary font-weight-bold">Bid Now</span></a>
          <div class=" small  text-primary font-weight-bold"><i class="fal fa-clock"></i> <?php echo do_shortcode('[TIMER]'); ?> </div>
       
    </div> 
   ---> 
   
    
  </div>
</div>