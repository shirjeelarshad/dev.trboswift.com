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
    'order'          => 'ASC', // Ascending order (latest first)
    'posts_per_page' => 50,
);

$new_auctions = new WP_Query($newauctions);

?>
<div class="bg-white p-2 radiusx">
<div class="d-flex justify-content-between mb-2">
    <h6 class="p-2">Top Auctions</h6><a href="<?php echo home_url(); ?>/?s=" class="p-2 small opacity-5 text-dark">View All</a>
</div>
<div class="top-vehicles-items owl-carousel">
<?php
if ($new_auctions->have_posts()) {
    while ($new_auctions->have_posts()) {
        $new_auctions->the_post();
        echo '<div class="mb-2">';
        _ppt_template('framework/design/account/parts/top_auction_card');
        echo '</div>';
    }
    wp_reset_postdata(); // Reset post data
}

?>
</div>
</div>
<script>
        jQuery(document).ready(function () {

          var topVehiclesItems = jQuery(".top-vehicles-items").owlCarousel({
            loop: false,
            margin: 20,
            nav: false,
            <?php if ($CORE->GEO("is_right_to_left", array())) { ?>rtl: true, <?php } ?>
        dots: false,
            responsive: {
              0: {
                items: 1
              },

              600: {
                items: 3
              },
              1000: {
                items: 4
              },

            },
          });

           topVehiclesItems.owlCarousel();

          // REFRESH	
          setTimeout(function () {
            topVehiclesItems.trigger('refresh.topVehiclesItems.carousel');
          }, 2000);


        });

      </script>