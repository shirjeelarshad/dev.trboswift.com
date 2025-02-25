<?php
/*
 * Template Name: Future Vehicles
 */





get_header();



global $userdata, $CORE_AUCTION, $wpdb, $CORE, $post;




$current_time = current_time('mysql');

$expiry_date = get_post_meta($post->ID, 'live_auction_start_date', true);
$new_expiry_date = date("Y-m-d H:i:s", strtotime($expiry_date . " +30 seconds"));

$vv = $CORE->date_timediff($expiry_date);




$args = array(
    'post_type' => 'listing_type',
    'post_status' => 'publish',
    'meta_query' => array(
        array(
            'key' => 'live_auction_start_date',
            'value' => $current_time,
            'compare' => '>=',
            'type' => 'DATETIME',
            'order' => 'ASC',

        ),
    ),

    'orderby' => 'ID', // Order by post ID
    'order' => 'ASC', // Descending order (latest first)

);

$posts = new WP_Query($args);

if ($posts->have_posts()) {
    $post_count = 0;

    echo '<div class="bg-secondary  pl-xs-1 pr-xs-1 pl-md-3 pr-md-3 pt-5 pb-5" style="min-height:100vh"> <span class=" font-itc pl-5 pr-3 pt-4  font-weight-bold h5">Xe sắp bán trực tiếp</span><br>';
    echo '<div class=" col-12 col-md-12 row pt-4  m-0 ">';

    while ($posts->have_posts()) {
        $posts->the_post();
        $post_count++;


        if ($post_count > 0) {


            echo '<div class="col-md-6 ">';
            _ppt_template('framework/design/singlenew/designs/global_future_auction_card');

            echo '</div>';





        }


    }
    echo '</div> </div>';
} else {
    echo '<div style="height: 700px;  display: flex;  justify-content: center; flex-direction: column; align-items: center; " class=" col-12 bg-secondary   p-6 mt-5 mb-5 ">';
    echo '<h5 class="font-itc">No future vehicles available</h5><br></div>';

}



get_footer();

?>