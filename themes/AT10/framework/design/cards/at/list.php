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

$user_roles = wp_get_current_user()->roles;
$customer_price = get_post_meta($post->ID, 'customer_price', true);

// GET CURRENT PRICE
$current_price = get_post_meta($post->ID, 'price_current', true);
if (!is_numeric($current_price)) {$current_price = 0;}

if($customer_price && !empty($customer_price) ){
                $auction_customer_price = $customer_price;
                
}else{
                $auction_customer_price = 0;
}

?>

 <div class="<?php echo $post->cardclass; ?> mb-4 p-3" style="border-radius:10px; background:#f5f5f5;" <?php echo $post->carddata; ?>>

<div class="row no-gutters">

    
<div class="col-md-8 col-xl-10 col-lg-9 text-center text-md-left">

	<?php echo $post->image_formatted; ?>   

    
    <h3><a href="<?php echo get_permalink($post->ID); ?>"><?php echo do_shortcode('[TITLE]'); ?></a></h3>
    
    <ul class="list-inline small opacity-5 hide-mobile">    	
        
        <li class="list-inline-item"><i class="fal fa-clock mr-2"></i> <?php echo do_shortcode('[TIMER]'); ?> </li> 
        
        <li class="list-inline-item hide-mobile"><span class="mr-2"><?php echo do_shortcode('[CATEGORYICON]'); ?></span> <?php echo do_shortcode('[CATEGORY limit=2]'); ?></li>
         
     <li class="list-inline-item"><i class="fal fa-users mr-2"></i> <?php echo do_shortcode('[HITS]'); ?> <?php echo __("Views","premiumpress"); ?> </li> 
       
    </ul>
    
    <div class="small opacity-5 hide-mobile hide-ipad"><?php echo do_shortcode('[EXCERPT limit=90]'); ?>...</div>
    
    
</div>
    
<div class="col-md-4 col-xl-2 col-lg-3 text-center text-lg-right ">
    
    <div class="<?php if(!is_user_logged_in()){echo 'd-none';} ?> tiny text-uppercase opacity-5 hide-mobile hide-ipad"><?php echo __("Current Price","premiumpress"); ?></div>
    
    <div class="<?php if(!is_user_logged_in()){echo 'd-none';} ?> pricetag-big <?php echo $CORE->GEO("price_formatting",array()); ?>"><?php 
    // echo $post->price;
    
    if( !is_user_logged_in() || in_array('subscriber', $user_roles) || in_array('administator', $user_roles)  ) { echo $current_price + $auction_customer_price; }else{  echo $current_price; }
    
    ?></div>
    
    <a href="<?php echo get_permalink($post->ID); ?>"class="btn btn-primary rounded btn-sm btn-block mt-1"><?php echo __("View","premiumpress"); ?></a>
    
    
</div> 
 
</div>

</div>