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



global $userdata, $CORE_AUCTION, $wpdb, $CORE, $CORE_CART, $post;

$current_time = current_time('mysql');

$newauctions = array(
    'post_type'      => 'listing_type',
    'post_status'    => 'publish',
    'meta_query'     => array(
        array(
            'key'     => 'listing_expiry_date',
            'value'   => $current_time,
            'compare' => '>=',
            'type'    => 'DATETIME',
        ),
    ),
    'orderby'        => 'ID',  // Order by post ID
    'order'          => 'DESC', // Ascending order (latest first)
    'posts_per_page' => 5,
);

$new_auctions = new WP_Query($newauctions);

if ($new_auctions->have_posts()) {
    while ($new_auctions->have_posts()) {
        $new_auctions->the_post();
        echo '<div class="mb-2">';
        _ppt_template('framework/design/singlenew/blocks/ending_soon_auction');
        echo '</div>';
    }
    wp_reset_postdata(); // Reset post data
}



?>