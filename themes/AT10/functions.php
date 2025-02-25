<?php

/* =============================================================================
   DEBUG OPTIONS
   ========================================================================== */

//ini_set( 'display_errors', 1);
//error_reporting( E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_STRICT );	
//define('WLT_DEBUG_EMAIL', true);


/* =============================================================================
   LOAD IN FRAMEWORK
   ========================================================================== */

// LOAD IN CLASS FILES
if (!defined('THEME_VERSION')) {
    include("framework/_config.php");
}

/* =============================================================================
   ADD YOUR CUSTOM CODE BELOW THIS LINE
   ========================================================================== */








function allow_svg_upload($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');



function acf_repeater_shortcode($atts)
{
    ob_start();

    // Retrieve the ACF Repeater data
    $repeater_data = get_field('accidentdamage'); // Replace 'your_repeater_field_name' with the actual name of your repeater field

    if ($repeater_data) {
        echo '<table style="width:100%">';
        echo '<tr>';

        // Display table headers (subfield names)
        foreach ($repeater_data[0] as $subfield_name => $value) {
            echo '<th style="padding:10px; border: 1px solid #eee;"">' . $subfield_name . '</th>';
        }

        echo '</tr>';

        // Loop through the repeater rows
        foreach ($repeater_data as $row) {
            echo '<tr>';

            // Display the subfield values as table cells
            foreach ($row as $value) {
                echo '<td style="padding:10px; border: 1px solid #eee;">' . $value . '</td>';
            }

            echo '</tr>';
        }

        echo '</table>';
    }

    $output = ob_get_clean();
    return $output;
}
add_shortcode('acf_repeater', 'acf_repeater_shortcode');


function enqueue_pdfjs()
{
    wp_enqueue_script('pdfjs', 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js', array(), '2.11.338', true);
}
add_action('wp_enqueue_scripts', 'enqueue_pdfjs');


// AUTOFAX REPORT

function acf_vehicle_history_repeater_shortcode($atts)
{
    $output = '';

    // Retrieve the ACF PDF file URL
    $pdf_file = get_field('autofaxpdf'); // Replace 'your_file_field_name' with the actual name of your file field

    if ($pdf_file) {
        // Generate the HTML markup to display the PDF file
        $output .= '<div class="pdf-container">';
        $output .= '<embed class="pdf-embed" src="' . $pdf_file . '" type="application/pdf" />';
        $output .= '</div>';
    } else {
        // Custom message when no PDF file is uploaded
        $output .= 'No autofax report found.';
    }

    return $output;
}
add_shortcode('acf_vehicle_history_repeater', 'acf_vehicle_history_repeater_shortcode');








function acf_motorcycle_history_repeater_shortcode($atts)
{
    $output = '';

    // Retrieve the ACF PDF file URL
    $pdf_file = get_field('autofaxpdf'); // Replace 'your_file_field_name' with the actual name of your file field

    if ($pdf_file) {
        // Generate the HTML markup to display the PDF file
        $output .= '<div class="pdf-container">';
        $output .= '<embed class="pdf-embed" src="' . $pdf_file . '" type="application/pdf" />';
        $output .= '</div>';
    } else {
        // Custom message when no PDF file is uploaded
        $output .= 'No autofax report found.';
    }

    return $output;
}
add_shortcode('acf_motorcycle_history_repeater', 'acf_motorcycle_history_repeater_shortcode');


function custom_listing_table_shortcode()
{

    $args = array(
        'post_type' => 'listing_type',
        'post_status' => 'publish', // Filter by post status
        'posts_per_page' => 10,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $query = new WP_Query($args);

    $current_date = date('F j, Y');

    if ($query->have_posts()) {
        echo '<table style="background-color: #fff; border-collapse: collapse; border: 0.5px solid #eee; font-size: 14px; margin-bottom:50px;">';
        echo '<tr>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Post</th>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Expiry Date</th>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Price Starting</th>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Price Current</th>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Price Reserve</th>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Reserve Status</th>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Number of Bids</th>';
        echo '</tr>';

        while ($query->have_posts()) {
            $query->the_post();

            $post_id = get_the_ID();
            $expiry_date = get_post_meta($post_id, 'live_auction_start_date', true);
            $timestamp = strtotime($expiry_date);
            $formatted_date = date('F j, Y', $timestamp);

            if ($formatted_date >= $current_date) {
                // Get meta values
                $price_starting = get_post_meta($post_id, 'price_starting', true);
                $price_current = get_post_meta($post_id, 'price_current', true);
                $price_reserve = get_post_meta($post_id, 'price_reserve', true);

                // Check if price_reserve > 0
                $reserve_status = ($price_reserve > 0) ? 'SELLER RESERVE PRICE' : 'NO RESERVE';

                // Get the current bid data array number
                $current_bid_data = get_post_meta($post_id, 'current_bid_data', true);
                $number_of_bids = (is_array($current_bid_data)) ? count($current_bid_data) : 0;

                // Output the table row with inline styles
                echo '<tr>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;"><a href="' . get_permalink() . '">' . get_the_title() . '</a></td>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;">' . $formatted_date . '</td>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;">' . $price_starting . '</td>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;">' . $price_current . '</td>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;">' . $price_reserve . '</td>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;">' . $reserve_status . '</td>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;">' . $number_of_bids . '</td>';
                echo '</tr>';
            }
        }

        echo '</table>';

        wp_reset_postdata(); // Restore original post data
    } else {
        echo 'No posts found.';
    }





}
add_shortcode('custom_listing_table', 'custom_listing_table_shortcode');



function future_listing_table_shortcode()
{



    $args = array(
        'post_type' => 'listing_type',
        'posts_per_page' => 10,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $query = new WP_Query($args);

    $current_date = date('F j, Y');



    if ($query->have_posts()) {

        echo '<table style="background-color: #fff; border-collapse: collapse; border: 0.5px solid #eee; font-size: 14px;">';
        echo '<tr>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Post</th>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Expiry Date</th>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Price Starting</th>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Price Current</th>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Price Reserve</th>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Reserve Status</th>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Number of Bids</th>';
        echo '</tr>';

        while ($query->have_posts()) {
            $query->the_post();

            $post_id = get_the_ID();
            $expiry_date = get_post_meta($post_id, 'listing_expiry_date', true);
            $timestamp = strtotime($expiry_date);
            $formatted_date = date('F j, Y', $timestamp);

            if ($formatted_date > $current_date) {
                // Get meta values
                $price_starting = get_post_meta($post_id, 'price_starting', true);
                $price_current = get_post_meta($post_id, 'price_current', true);
                $price_reserve = get_post_meta($post_id, 'price_reserve', true);

                // Check if price_reserve > 0
                $reserve_status = ($price_reserve > 0) ? 'SELLER RESERVE PRICE' : 'NO RESERVE';

                // Get the current bid data array number
                $current_bid_data = get_post_meta($post_id, 'current_bid_data', true);
                $number_of_bids = (is_array($current_bid_data)) ? count($current_bid_data) : 0;

                // Output the table row with inline styles
                echo '<tr>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;"><a href="' . get_permalink() . '">' . get_the_title() . '</a></td>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;">' . $formatted_date . '</td>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;">' . $price_starting . '</td>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;">' . $price_current . '</td>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;">' . $price_reserve . '</td>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;">' . $reserve_status . '</td>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;">' . $number_of_bids . '</td>';
                echo '</tr>';
            }
        }

        echo '</table>';

        wp_reset_postdata(); // Restore original post data
    } else {
        echo 'No posts found.';
    }




}
add_shortcode('future_listing_table', 'future_listing_table_shortcode');




function past_auctn_table_shortcode()
{



    $args = array(
        'post_type' => 'listing_type',
        'posts_per_page' => 10,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $query = new WP_Query($args);

    $current_date = date('F j, Y');



    if ($query->have_posts()) {

        echo '<table style="background-color: #fff; border-collapse: collapse; border: 0.5px solid #eee; font-size: 14px;">';
        echo '<tr>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Post</th>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Expiry Date</th>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Price Starting</th>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Price Current</th>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Price Reserve</th>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Reserve Status</th>';
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">Number of Bids</th>';
        echo '</tr>';

        while ($query->have_posts()) {
            $query->the_post();

            $post_id = get_the_ID();
            $expiry_date = get_post_meta($post_id, 'live_auction_start_date', true);
            $timestamp = strtotime($expiry_date);
            $formatted_date = date('F j, Y', $timestamp);

            if ($formatted_date > $current_date) {
                // Get meta values
                $price_starting = get_post_meta($post_id, 'price_starting', true);
                $price_current = get_post_meta($post_id, 'price_current', true);
                $price_reserve = get_post_meta($post_id, 'price_reserve', true);

                // Check if price_reserve > 0
                $reserve_status = ($price_reserve > 0) ? 'SELLER RESERVE PRICE' : 'NO RESERVE';

                // Get the current bid data array number
                $current_bid_data = get_post_meta($post_id, 'current_bid_data', true);
                $number_of_bids = (is_array($current_bid_data)) ? count($current_bid_data) : 0;

                // Output the table row with inline styles
                echo '<tr>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;"><a href="' . get_permalink() . '">' . get_the_title() . '</a></td>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;">' . $formatted_date . '</td>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;">' . $price_starting . '</td>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;">' . $price_current . '</td>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;">' . $price_reserve . '</td>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;">' . $reserve_status . '</td>';
                echo '<td style="border: 0.5px solid #eee; padding: 10px;">' . $number_of_bids . '</td>';
                echo '</tr>';
            }
        }

        echo '</table>';

        wp_reset_postdata(); // Restore original post data
    } else {
        echo 'No posts found.';
    }




}
add_shortcode('past_auctn_table', 'past_auctn_table_shortcode');





function calender_shortcode()
{



    $args = array(
        'post_type' => 'listing_type',
        'posts_per_page' => -1, // Retrieve all posts
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $query = new WP_Query($args);

    // Get the unique auction times from the posts
    $auction_times = array();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $status = get_post_status();
            $expiry_date = get_post_meta(get_the_ID(), 'live_auction_start_date', true);
            $auction_time = date('h:i A', strtotime($expiry_date));
            $auction_times[] = $auction_time;
        }
    }

    // Remove duplicate auction times and sort the array
    $auction_times = array_unique($auction_times);
    sort($auction_times);

    // Get the next 7 days starting from the current date
    $dates = array();
    $current_date = strtotime(date('Y-m-d'));
    for ($i = 0; $i < 7; $i++) {
        $date = strtotime("+$i day", $current_date);
        $date_name = date('l', $date);
        $date_value = date('m/d/Y', $date);
        $dates[$date_value] = $date_name;
    }

    // Create an associative array to store the post data by date and time
    $post_data = array();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $status = get_post_status();
            $post_id = get_the_ID();
            $expiry_date = get_post_meta($post_id, 'live_auction_start_date', true);
            $auction_time = date('h:i A', strtotime($expiry_date));
            $auction_date = date('m/d/Y', strtotime($expiry_date));
            $tax_terms = get_the_terms($post_id, 'test-drive'); // Assuming 'city' is the taxonomy name
            $taxonomy_name = '';
            $taxonomy_link = '';

            if ($tax_terms && !is_wp_error($tax_terms)) {
                $taxonomy = reset($tax_terms);
                $taxonomy_name = $taxonomy->name;
                $taxonomy_link = get_term_link($taxonomy);
            }

            // Check if post is published, end date is greater than current time, and within the next 7 days
            if ($status === 'publish' && strtotime($expiry_date) >= time() && isset($dates[$auction_date])) {
                if (!isset($post_data[$auction_time])) {
                    $post_data[$auction_time] = array();
                }
                $post_data[$auction_time][$auction_date] = array(
                    'taxonomy_name' => $taxonomy_name,
                    'taxonomy_link' => $taxonomy_link,
                );
            }
        }
    }

    // Sort the array keys to maintain consistent order
    ksort($post_data);

    // Output the calendar table with inline styles
    echo '<table style="background-color: #fff; border-collapse: collapse; border: 0.5px solid #eee; font-size: 14px;">';
    echo '<tr>';
    echo '<th style="border: 0.5px solid #eee; padding: 10px;">Auction Time</th>';

    // Generate the column headers for each date
    foreach ($dates as $date_value => $date_name) {
        echo '<th style="border: 0.5px solid #eee; padding: 10px;">' . $date_name . '<br>' . $date_value . '</th>';
    }

    echo '</tr>';

    // Generate the rows for each auction time
    foreach ($auction_times as $auction_time) {
        echo '<tr>';
        echo '<td style="border: 0.5px solid #eee; padding: 10px;">' . $auction_time . '</td>';

        foreach ($dates as $date_value => $date_name) {
            echo '<td style="border: 0.5px solid #eee; padding: 10px;">';
            if (isset($post_data[$auction_time][$date_value])) {
                $taxonomy_name = $post_data[$auction_time][$date_value]['taxonomy_name'];
                $taxonomy_link = $post_data[$auction_time][$date_value]['taxonomy_link'];

                echo '<a href="' . $taxonomy_link . '">ðŸŸ¡' . $taxonomy_name . '</a>';
            }
            echo '</td>';
        }

        echo '</tr>';
    }

    echo '</table>';

    wp_reset_postdata(); // Restore original post data



}
add_shortcode('calender_table_auc', 'calender_shortcode');











// functions.php

// Include the AJAX handler file
// require_once get_template_directory() . '/ajax-live-auction-posts.php';





add_action('wp_ajax_update_post_status', 'update_post_status_callback');
add_action('wp_ajax_nopriv_update_post_status', 'update_post_status_callback');

function update_post_status_callback()
{
    if (isset($_POST['postId'])) {
        $post_id = intval($_POST['postId']);

        // Update the post status to 'expired'
        $my_post = array(
            'ID' => $post_id,
            'post_status' => 'expired'
        );
        wp_update_post($my_post);

        // Update the expiry date meta data
        update_post_meta($post_id, 'live_auction_start_date', '');
        update_post_meta($post_id, 'listing_expiry_date', '');
    }

    // Always die after handling an AJAX request
    wp_die();
}













function enqueue_socket_io_script()
{
    wp_enqueue_script('socket-io', 'https://cdn.socket.io/4.3.1/socket.io.js', array(), '4.3.1');
}
add_action('wp_enqueue_scripts', 'enqueue_socket_io_script');






// Function to handle AJAX request and fetch the live auction Lane A
function refresh_posts()
{
    ob_start();




    global $userdata, $CORE_AUCTION, $wpdb, $CORE, $CORE_CART, $post;




    $current_time = current_time('mysql');

    $expiry_date = get_post_meta($post->ID, 'live_auction_start_date', true);
    $new_expiry_date = date("Y-m-d H:i:s", strtotime($expiry_date . " +30 seconds"));

    $vv = $CORE->date_timediff($expiry_date);




    $current_args = array(
        'post_type' => 'listing_type',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'live_auction_start_date',
                'value' => $current_time,
                'compare' => '<=',
                'type' => 'DATETIME',
                'order' => 'ASC',
            ),
        ),
        'tax_query' => array(
            array(
                'taxonomy' => 'auction-lane',
                'field' => 'slug',
                'terms' => 'lane-a',
            ),
        ),
        'orderby' => 'ID', // Order by post ID
        'order' => 'ASC', // Ascending order (latest first)
        'posts_per_page' => 1,
    );



    $current_live_posts = new WP_Query($current_args);


    if ($current_live_posts->have_posts()) {



        ?>





<?php



                                                                                                            while ($current_live_posts->have_posts()) {
                                                                                                                $current_live_posts->the_post();



                                                                                                                _ppt_template('framework/design/singlenew/designs/global_design2');




                                                                                                                wp_reset_postdata();


                                                                                                            }
    }




    $upcommingargs = array(
        'post_type' => 'listing_type',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'live_auction_start_date',
                'value' => $current_time,
                'compare' => '<=',
                'type' => 'DATETIME',
                'order' => 'ASC',

            ),
        ),

        'tax_query' => array(
            array(
                'taxonomy' => 'auction-lane',
                'field' => 'slug',
                'terms' => 'lane-a',
            ),
        ),

        'orderby' => 'ID', // Order by post ID
        'order' => 'ASC', // Acending order (latest first)
        'posts_per_page' => -1,
    );

    $up_com_posts = new WP_Query($upcommingargs);


    if ($up_com_posts->have_posts()) {
        $post_countx = 0;


        ?>
<div id="upCommingSide" class="upCommingSide bg-white ">
	<div class="">
		<a href="javascript:void(0)" class="closebtn" onclick="closeUpCommingSide()">×</a>
		<span class="upcomingHeading pl-3 pb-4">REMAINING AUCTIONS</span>

		<?php
                                                                                                            $total_posts = $up_com_posts->found_posts;
                                                                                                            $remmening_posts = $total_posts - 1;

                                                                                                            while ($up_com_posts->have_posts()) {
                                                                                                                $up_com_posts->the_post();
                                                                                                                $post_countx++;

                                                                                                                if ($post_countx === 1) {

                                                                                                                } else {
                                                                                                                    // Remaining posts
                                                                                                                    echo '<div class=" d-flex p-2 mb-2">';

                                                                                                                    echo '<div class=" mr-2 "> <span class="p-1 bg-white text-dark rounded-circle" >' . $remmening_posts-- . '</span></div>';

                                                                                                                    _ppt_template('framework/design/singlenew/designs/upcomming_auction');
                                                                                                                    echo '</div>';


                                                                                                                }
                                                                                                            }
                                                                                                            echo '</div></div>';



                                                                                                            die();




    } else {
        echo '<div id="liveNotA" style="height: 700px;  display: flex;  justify-content: center; flex-direction: column; align-items: center; " class=" col-sm   p-6 bg-white  ">';
        
        echo '<h5 class="text-dark text-center">' . __("CURRENTLY NO LIVESTREAM SCHEDULE", "premiumpress") . '</h5> <br>';

        // Get the next auction time
        $args_next = array(
            'post_type' => 'listing_type',
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'live_auction_start_date',
                    'orderby' => 'meta_value',
                    'value' => $current_time,
                    'compare' => '>',
                    'type' => 'DATETIME',

                    'order' => 'ASC',
                ),
            ),
            'tax_query' => array(
                array(
                    'taxonomy' => 'auction-lane',
                    'field' => 'slug',
                    'terms' => 'lane-a',
                ),
            ),
            'orderby' => 'ID', // Order by post ID
            'order' => 'ASC', // Acending order (latest first)
            'posts_per_page' => 1,

        );

        $next_posts = new WP_Query($args_next);

        if ($next_posts->have_posts()) {
            $next_posts->the_post();


            $next_auction_start = get_post_meta(get_the_ID(), 'live_auction_start_date', true);

            // echo do_shortcode('[TITLE]');

            $next_auction_start_timestamp = strtotime($next_auction_start);


            $fiveMinutesAgoTimestamp = strtotime('-5 minutes', $next_auction_start_timestamp);
            // 5 minutes before the start

            $remening_countdown_time = date("Y-m-d H:i:s", $fiveMinutesAgoTimestamp);




            $timezone_name = wp_timezone_string();

            $current_timestamp = strtotime($current_time);

            $remaining_time = $next_auction_start_timestamp - $current_timestamp;



            $remening_count_start_min = date(" i", $remaining_time);
            $remening_count_start_sec = date(" s", $remaining_time);




            if ($remening_countdown_time <= $current_time) {
                // Display the countdown timer



                echo '<div class="text-dark h6 text-center" >' . __("Livestream trực tiếp sẽ bắt đầu sau ", "premiumpress") . ': <span id="nextauctiontimer"></span></div>';

                ?>


		<script type="text/javascript">
		// Get the remaining minutes from PHP


		var remainingMinutes = <?php echo $remening_count_start_min; ?>;
		var remainingSeconds = <?php echo $remening_count_start_sec; ?>;


		// Calculate the countdown start time
		var countdownStartTime = new Date();
		countdownStartTime.setMinutes(countdownStartTime.getMinutes() + remainingMinutes);
		countdownStartTime.setSeconds(countdownStartTime.getSeconds() + remainingSeconds);



		// Function to update the countdown timer
		function updateCountdown() {
			var now = new Date().getTime();
			var distance = countdownStartTime - now;

			// Calculate remaining minutes and seconds
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);

			// Display the countdown in the HTML element with id "nextauctiontimer"
			document.getElementById("nextauctiontimer").innerHTML = minutes + " phát " + seconds + " giây ";

			// Check if the countdown is finished
			if (distance < 1) {
				document.getElementById("nextauctiontimer").innerHTML = '0';

				// Stop the countdown interval
				clearInterval(countdownInterval);


				refreshPosts();
				// location.reload();









			}

		}

		// Update the countdown every second
		var countdownInterval = setInterval(updateCountdown, 1000);
		</script>


		<?php



            } else {
                // Display the date and time of the next auction
                echo '<h6 class="text-dark text-center">' . __("Lịch bán trực tiếp ", "premiumpress")  . date('g:i a \a\t F j, Y', strtotime($next_auction_start)) . ' [' . $timezone_name . ']' . '</h6><br>';

            }

            wp_reset_postdata();

        } else {
            // echo '<h6 class="text-dark ">' . __("No Upcoming Live Offers ", "premiumpress")  .' </h6><br>';

            ?> <script>
		// function hgkjhuvgjh(){

		// location.reload();


		// }
		setInterval(refreshPosts, 200000);
		</script>
		<?php

        }

        echo '</div>';


    }





    $output = ob_get_clean();
    echo $output;

    die();
}

add_action('wp_ajax_refresh_posts', 'refresh_posts');
add_action('wp_ajax_nopriv_refresh_posts', 'refresh_posts');



// Function to handle AJAX request and fetch the live auction Lane A
function getauction_lane_a()
{
    ob_start();




    global $userdata, $CORE_AUCTION, $wpdb, $CORE, $CORE_CART, $post;




    $current_time = current_time('mysql');

    $expiry_date = get_post_meta($post->ID, 'live_auction_start_date', true);
    $new_expiry_date = date("Y-m-d H:i:s", strtotime($expiry_date . " +30 seconds"));

    $vv = $CORE->date_timediff($expiry_date);




    $current_args = array(
        'post_type' => 'listing_type',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'live_auction_start_date',
                'value' => $current_time,
                'compare' => '<=',
                'type' => 'DATETIME',
                'order' => 'ASC',
            ),
        ),
        'tax_query' => array(
            array(
                'taxonomy' => 'auction-lane',
                'field' => 'slug',
                'terms' => 'lane-a',
            ),
        ),
        'orderby' => 'ID', // Order by post ID
        'order' => 'ASC', // Ascending order (latest first)
        'posts_per_page' => 1,
    );



    $current_live_posts = new WP_Query($current_args);


    if ($current_live_posts->have_posts()) {



        ?>





		<?php



                                                                                                            while ($current_live_posts->have_posts()) {
                                                                                                                $current_live_posts->the_post();



                                                                                                                _ppt_template('framework/design/singlenew/designs/global_design2');




                                                                                                                wp_reset_postdata();


                                                                                                            }
    }




    $upcommingargs = array(
        'post_type' => 'listing_type',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'live_auction_start_date',
                'value' => $current_time,
                'compare' => '<=',
                'type' => 'DATETIME',
                'order' => 'ASC',

            ),
        ),

        'tax_query' => array(
            array(
                'taxonomy' => 'auction-lane',
                'field' => 'slug',
                'terms' => 'lane-a',
            ),
        ),

        'orderby' => 'ID', // Order by post ID
        'order' => 'ASC', // Acending order (latest first)
        'posts_per_page' => -1,
    );

    $up_com_posts = new WP_Query($upcommingargs);


    if ($up_com_posts->have_posts()) {
        $post_countx = 0;


        ?>
		<div id="upCommingSide" class="upCommingSide bg-white ">
			<div class="">
				<a href="javascript:void(0)" class="closebtn" onclick="closeUpCommingSide()">×</a>
				<span class="upcomingHeading pl-3 pb-4"><?php echo __("REMAINING AUCTIONS", "premiumpress"); ?></span>

				<?php
                                                                                                            $total_posts = $up_com_posts->found_posts;
                                                                                                            $remmening_posts = $total_posts - 1;

                                                                                                            while ($up_com_posts->have_posts()) {
                                                                                                                $up_com_posts->the_post();
                                                                                                                $post_countx++;

                                                                                                                if ($post_countx === 1) {

                                                                                                                } else {
                                                                                                                    // Remaining posts
                                                                                                                    echo '<div class=" d-flex p-2 mb-2">';

                                                                                                                    echo '<div class=" mr-2 "> <span class="p-1 bg-white text-dark rounded-circle" >' . $remmening_posts-- . '</span></div>';

                                                                                                                    _ppt_template('framework/design/singlenew/designs/upcomming_auction');
                                                                                                                    echo '</div>';


                                                                                                                }
                                                                                                            }
                                                                                                            echo '</div></div>';



                                                                                                            die();




    } else {
        echo '<div id="liveNotA" style="height: 700px;  display: flex;  justify-content: center; flex-direction: column; align-items: center; " class="bg-white col-sm   p-6   ">';
        echo '<h5 class="text-dark text-center">' . __("CURRENTLY NO LIVESTREAM SCHEDULE", "premiumpress") . '</h5><br>';

        // Get the next auction time
        $args_next = array(
            'post_type' => 'listing_type',
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'live_auction_start_date',
                    'orderby' => 'meta_value',
                    'value' => $current_time,
                    'compare' => '>',
                    'type' => 'DATETIME',

                    'order' => 'ASC',
                ),
            ),
            'tax_query' => array(
                array(
                    'taxonomy' => 'auction-lane',
                    'field' => 'slug',
                    'terms' => 'lane-a',
                ),
            ),
            'orderby' => 'ID', // Order by post ID
            'order' => 'ASC', // Acending order (latest first)
            'posts_per_page' => 1,

        );

        $next_posts = new WP_Query($args_next);

        if ($next_posts->have_posts()) {
            $next_posts->the_post();


            $next_auction_start = get_post_meta(get_the_ID(), 'live_auction_start_date', true);

            // echo do_shortcode('[TITLE]');

            $next_auction_start_timestamp = strtotime($next_auction_start);


            $fiveMinutesAgoTimestamp = strtotime('-5 minutes', $next_auction_start_timestamp);
            // 5 minutes before the start

            $remening_countdown_time = date("Y-m-d H:i:s", $fiveMinutesAgoTimestamp);




            $timezone_name = wp_timezone_string();

            $current_timestamp = strtotime($current_time);

            $remaining_time = $next_auction_start_timestamp - $current_timestamp;



            $remening_count_start_min = date(" i", $remaining_time);
            $remening_count_start_sec = date(" s", $remaining_time);




            if ($remening_countdown_time <= $current_time) {
                // Display the countdown timer



                echo '<div class="text-dark h6 text-center" >' . __("The live stream will start later ", "premiumpress") . ': <span id="nextauctiontimer"></span></div>';

                ?>


				<script type="text/javascript">
				// Get the remaining minutes from PHP


				var remainingMinutes = <?php echo $remening_count_start_min; ?>;
				var remainingSeconds = <?php echo $remening_count_start_sec; ?>;


				// Calculate the countdown start time
				var countdownStartTime = new Date();
				countdownStartTime.setMinutes(countdownStartTime.getMinutes() + remainingMinutes);
				countdownStartTime.setSeconds(countdownStartTime.getSeconds() + remainingSeconds);



				// Function to update the countdown timer
				function updateCountdown() {
					var now = new Date().getTime();
					var distance = countdownStartTime - now;

					// Calculate remaining minutes and seconds
					var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
					var seconds = Math.floor((distance % (1000 * 60)) / 1000);

					// Display the countdown in the HTML element with id "nextauctiontimer"
					document.getElementById("nextauctiontimer").innerHTML = minutes + " M " + seconds + " S ";

					// Check if the countdown is finished
					if (distance < 1) {
						document.getElementById("nextauctiontimer").innerHTML = '0';

						// Stop the countdown interval
						clearInterval(countdownInterval);


						getAuctionLaneAPosts();
						// location.reload();









					}

				}

				// Update the countdown every second
				var countdownInterval = setInterval(updateCountdown, 1000);
				</script>


				<?php



            } else {
                // Display the date and time of the next auction
                echo '<h6 class="text-dark text-center">' . __("Next Live Offers & Time In Lane A  ", "premiumpress") . date('g:i a \a\t F j, Y', strtotime($next_auction_start)) . ' [' . $timezone_name . ']' . '</h6><br>';

            }

            wp_reset_postdata();

        } else {
            // echo '<h6 class="text-dark ">' . __("No Upcoming Live offers In Lane A ", "premiumpress") . ' </h6><br>';

            ?> <script>
				// function hgkjhuvgjh(){

				// location.reload();


				// }
				setInterval(getAuctionLaneAPosts, 200000);
				</script>
				<?php

        }

        echo '</div>';


    }





    $output = ob_get_clean();
    echo $output;

    die();
}

add_action('wp_ajax_getauction_lane_a', 'getauction_lane_a');
add_action('wp_ajax_nopriv_getauction_lane_a', 'getauction_lane_a');




// Function to handle AJAX request and fetch the get auction_lane_b
function getauction_lane_b()
{
    ob_start();




    global $userdata, $CORE_AUCTION, $wpdb, $CORE, $CORE_CART, $post;




    $current_time = current_time('mysql');

    $expiry_date = get_post_meta($post->ID, 'live_auction_start_date', true);
    $new_expiry_date = date("Y-m-d H:i:s", strtotime($expiry_date . " +30 seconds"));

    $vv = $CORE->date_timediff($expiry_date);




    $current_args = array(
        'post_type' => 'listing_type',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'live_auction_start_date',
                'value' => $current_time,
                'compare' => '<=',
                'type' => 'DATETIME',
                'order' => 'ASC',
            ),
        ),
        'tax_query' => array(
            array(
                'taxonomy' => 'auction-lane',
                'field' => 'slug',
                'terms' => 'lane-b',
            ),
        ),
        'orderby' => 'ID', // Order by post ID
        'order' => 'ASC', // Ascending order (latest first)
        'posts_per_page' => 1,
    );



    $current_live_posts = new WP_Query($current_args);


    if ($current_live_posts->have_posts()) {



        ?>





				<?php



                                                                                                            while ($current_live_posts->have_posts()) {
                                                                                                                $current_live_posts->the_post();



                                                                                                                _ppt_template('framework/design/singlenew/designs/global_design2');




                                                                                                                wp_reset_postdata();


                                                                                                            }
    }




    $upcommingargs = array(
        'post_type' => 'listing_type',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'live_auction_start_date',
                'value' => $current_time,
                'compare' => '<=',
                'type' => 'DATETIME',
                'order' => 'ASC',

            ),
        ),

        'tax_query' => array(
            array(
                'taxonomy' => 'auction-lane',
                'field' => 'slug',
                'terms' => 'lane-b',
            ),
        ),

        'orderby' => 'ID', // Order by post ID
        'order' => 'ASC', // Acending order (latest first)
        'posts_per_page' => -1,
    );

    $up_com_posts = new WP_Query($upcommingargs);


    if ($up_com_posts->have_posts()) {
        $post_countx = 0;


        ?>
				<div id="upCommingSide" class="upCommingSide bg-white ">
					<div class="">
						<a href="javascript:void(0)" class="closebtn" onclick="closeUpCommingSide()">×</a>
						<span
							class="upcomingHeading pl-3 pb-4"><?php echo __("REMAINING AUCTIONS", "premiumpress"); ?></span>

						<?php
                                                                                                            $total_posts = $up_com_posts->found_posts;
                                                                                                            $remmening_posts = $total_posts - 1;

                                                                                                            while ($up_com_posts->have_posts()) {
                                                                                                                $up_com_posts->the_post();
                                                                                                                $post_countx++;

                                                                                                                if ($post_countx === 1) {

                                                                                                                } else {
                                                                                                                    // Remaining posts
                                                                                                                    echo '<div class=" d-flex p-2 mb-2">';

                                                                                                                    echo '<div class=" mr-2 "> <span class="p-1 bg-white text-dark rounded-circle" >' . $remmening_posts-- . '</span></div>';

                                                                                                                    _ppt_template('framework/design/singlenew/designs/upcomming_auction');
                                                                                                                    echo '</div>';


                                                                                                                }
                                                                                                            }
                                                                                                            echo '</div></div>';



                                                                                                            die();




    } else {
        echo '<div id="liveNotB" style="height: 700px;  display: flex;  justify-content: center; flex-direction: column; align-items: center; " class="bg-white col-sm   p-6   ">';
        echo '<h5 class="text-dark text-center">' .  __("CURRENTLY NO LIVESTREAM SCHEDULED", "premiumpress") . '</h5><br>';

        // Get the next auction time
        $args_next = array(
            'post_type' => 'listing_type',
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'live_auction_start_date',
                    'orderby' => 'meta_value',
                    'value' => $current_time,
                    'compare' => '>',
                    'type' => 'DATETIME',

                    'order' => 'ASC',
                ),
            ),
            'tax_query' => array(
                array(
                    'taxonomy' => 'auction-lane',
                    'field' => 'slug',
                    'terms' => 'lane-b',
                ),
            ),
            'orderby' => 'ID', // Order by post ID
            'order' => 'ASC', // Acending order (latest first)
            'posts_per_page' => 1,

        );

        $next_posts = new WP_Query($args_next);

        if ($next_posts->have_posts()) {
            $next_posts->the_post();


            $next_auction_start = get_post_meta(get_the_ID(), 'live_auction_start_date', true);

            // echo do_shortcode('[TITLE]');

            $next_auction_start_timestamp = strtotime($next_auction_start);


            $fiveMinutesAgoTimestamp = strtotime('-5 minutes', $next_auction_start_timestamp);
            // 5 minutes before the start

            $remening_countdown_time = date("Y-m-d H:i:s", $fiveMinutesAgoTimestamp);




            $timezone_name = wp_timezone_string();

            $current_timestamp = strtotime($current_time);

            $remaining_time = $next_auction_start_timestamp - $current_timestamp;



            $remening_count_start_min = date(" i", $remaining_time);
            $remening_count_start_sec = date(" s", $remaining_time);




            if ($remening_countdown_time <= $current_time) {
                // Display the countdown timer



                echo '<div class="text-dark h6 text-center" >' .  __("The live stream will start later", "premiumpress") . ': <span id="nextauctiontimer"></span></div>';

                ?>


						<script type="text/javascript">
						// Get the remaining minutes from PHP


						var remainingMinutes = <?php echo $remening_count_start_min; ?>;
						var remainingSeconds = <?php echo $remening_count_start_sec; ?>;


						// Calculate the countdown start time
						var countdownStartTime = new Date();
						countdownStartTime.setMinutes(countdownStartTime.getMinutes() + remainingMinutes);
						countdownStartTime.setSeconds(countdownStartTime.getSeconds() + remainingSeconds);



						// Function to update the countdown timer
						function updateCountdown() {
							var now = new Date().getTime();
							var distance = countdownStartTime - now;

							// Calculate remaining minutes and seconds
							var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
							var seconds = Math.floor((distance % (1000 * 60)) / 1000);

							// Display the countdown in the HTML element with id "nextauctiontimer"
							document.getElementById("nextauctiontimer").innerHTML = minutes + " phát " + seconds +
								" giây ";

							// Check if the countdown is finished
							if (distance < 1) {
								document.getElementById("nextauctiontimer").innerHTML = '0';

								// Stop the countdown interval
								clearInterval(countdownInterval);


								getAuctionLaneBPosts();
								// location.reload();









							}

						}

						// Update the countdown every second
						var countdownInterval = setInterval(updateCountdown, 1000);
						</script>


						<?php



            } else {
                // Display the date and time of the next auction
                echo '<h6 class="text-dark text-center">' .  __("Next Live Offers & Time In Lane B", "premiumpress") . date('g:i a \a\t F j, Y', strtotime($next_auction_start)) . ' [' . $timezone_name . ']' . '</h6><br>';

            }

            wp_reset_postdata();

        } else {
            // echo '<h6 class="text-dark ">' .  __("No Upcoming Live Offers In Lane B", "premiumpress") . ' </h6><br>';

            ?> <script>
						// function hgkjhuvgjh(){

						// location.reload();


						// }
						setInterval(getAuctionLaneBPosts, 200000);
						</script>
						<?php

        }

        echo '</div>';


    }





    $output = ob_get_clean();
    echo $output;

    die();
}

add_action('wp_ajax_getauction_lane_b', 'getauction_lane_b');
add_action('wp_ajax_nopriv_getauction_lane_b', 'getauction_lane_b');



// Function to handle AJAX request and fetch the get auction_lane_b
function getauction_lane_c()
{
    ob_start();




    global $userdata, $CORE_AUCTION, $wpdb, $CORE, $CORE_CART, $post;




    $current_time = current_time('mysql');

    $expiry_date = get_post_meta($post->ID, 'live_auction_start_date', true);
    $new_expiry_date = date("Y-m-d H:i:s", strtotime($expiry_date . " +30 seconds"));

    $vv = $CORE->date_timediff($expiry_date);




    $current_args = array(
        'post_type' => 'listing_type',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'live_auction_start_date',
                'value' => $current_time,
                'compare' => '<=',
                'type' => 'DATETIME',
                'order' => 'ASC',
            ),
        ),
        'tax_query' => array(
            array(
                'taxonomy' => 'auction-lane',
                'field' => 'slug',
                'terms' => 'lane-c',
            ),
        ),
        'orderby' => 'ID', // Order by post ID
        'order' => 'ASC', // Ascending order (latest first)
        'posts_per_page' => 1,
    );



    $current_live_posts = new WP_Query($current_args);


    if ($current_live_posts->have_posts()) {



        ?>





						<?php



                                                                                                            while ($current_live_posts->have_posts()) {
                                                                                                                $current_live_posts->the_post();



                                                                                                                _ppt_template('framework/design/singlenew/designs/global_design2');




                                                                                                                wp_reset_postdata();


                                                                                                            }
    }




    $upcommingargs = array(
        'post_type' => 'listing_type',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'live_auction_start_date',
                'value' => $current_time,
                'compare' => '<=',
                'type' => 'DATETIME',
                'order' => 'ASC',

            ),
        ),

        'tax_query' => array(
            array(
                'taxonomy' => 'auction-lane',
                'field' => 'slug',
                'terms' => 'lane-c',
            ),
        ),

        'orderby' => 'ID', // Order by post ID
        'order' => 'ASC', // Acending order (latest first)
        'posts_per_page' => -1,
    );

    $up_com_posts = new WP_Query($upcommingargs);


    if ($up_com_posts->have_posts()) {
        $post_countx = 0;


        ?>
						<div id="upCommingSide" class="upCommingSide bg-white ">
							<div class="">
								<a href="javascript:void(0)" class="closebtn" onclick="closeUpCommingSide()">×</a>
								<span
									class="upcomingHeading pl-3 pb-4"><?php echo  __("REMAINING AUCTIONS", "premiumpress"); ?></span>

								<?php
                                                                                                            $total_posts = $up_com_posts->found_posts;
                                                                                                            $remmening_posts = $total_posts - 1;

                                                                                                            while ($up_com_posts->have_posts()) {
                                                                                                                $up_com_posts->the_post();
                                                                                                                $post_countx++;

                                                                                                                if ($post_countx === 1) {

                                                                                                                } else {
                                                                                                                    // Remaining posts
                                                                                                                    echo '<div class=" d-flex p-2 mb-2">';

                                                                                                                    echo '<div class=" mr-2 "> <span class="p-1 bg-white text-dark rounded-circle" >' . $remmening_posts-- . '</span></div>';

                                                                                                                    _ppt_template('framework/design/singlenew/designs/upcomming_auction');
                                                                                                                    echo '</div>';


                                                                                                                }
                                                                                                            }
                                                                                                            echo '</div></div>';



                                                                                                            die();




    } else {
        echo '<div id="liveNotC" style="height: 700px; display: flex;  justify-content: center; flex-direction: column; align-items: center; " class="bg-white col-sm   p-6   ">';
        echo '<h5 class="text-dark text-center">' .  __("CURRENTLY NO LIVESTREAM SCHEDULED", "premiumpress") . '</h5><br>';

        // Get the next auction time
        $args_next = array(
            'post_type' => 'listing_type',
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'live_auction_start_date',
                    'orderby' => 'meta_value',
                    'value' => $current_time,
                    'compare' => '>',
                    'type' => 'DATETIME',

                    'order' => 'ASC',
                ),
            ),
            'tax_query' => array(
                array(
                    'taxonomy' => 'auction-lane',
                    'field' => 'slug',
                    'terms' => 'lane-c',
                ),
            ),
            'orderby' => 'ID', // Order by post ID
            'order' => 'ASC', // Acending order (latest first)
            'posts_per_page' => 1,

        );

        $next_posts = new WP_Query($args_next);

        if ($next_posts->have_posts()) {
            $next_posts->the_post();


            $next_auction_start = get_post_meta(get_the_ID(), 'live_auction_start_date', true);

            // echo do_shortcode('[TITLE]');

            $next_auction_start_timestamp = strtotime($next_auction_start);


            $fiveMinutesAgoTimestamp = strtotime('-5 minutes', $next_auction_start_timestamp);
            // 5 minutes before the start

            $remening_countdown_time = date("Y-m-d H:i:s", $fiveMinutesAgoTimestamp);




            $timezone_name = wp_timezone_string();

            $current_timestamp = strtotime($current_time);

            $remaining_time = $next_auction_start_timestamp - $current_timestamp;



            $remening_count_start_min = date(" i", $remaining_time);
            $remening_count_start_sec = date(" s", $remaining_time);




            if ($remening_countdown_time <= $current_time) {
                // Display the countdown timer



                echo '<div class="text-dark h6 text-center" >' .  __("The live stream will start later ", "premiumpress") . ': <span id="nextauctiontimer"></span></div>';

                ?>


								<script type="text/javascript">
								// Get the remaining minutes from PHP


								var remainingMinutes = <?php echo $remening_count_start_min; ?>;
								var remainingSeconds = <?php echo $remening_count_start_sec; ?>;


								// Calculate the countdown start time
								var countdownStartTime = new Date();
								countdownStartTime.setMinutes(countdownStartTime.getMinutes() + remainingMinutes);
								countdownStartTime.setSeconds(countdownStartTime.getSeconds() + remainingSeconds);



								// Function to update the countdown timer
								function updateCountdown() {
									var now = new Date().getTime();
									var distance = countdownStartTime - now;

									// Calculate remaining minutes and seconds
									var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
									var seconds = Math.floor((distance % (1000 * 60)) / 1000);

									// Display the countdown in the HTML element with id "nextauctiontimer"
									document.getElementById("nextauctiontimer").innerHTML = minutes + " phát " +
										seconds + " giây ";

									// Check if the countdown is finished
									if (distance < 1) {
										document.getElementById("nextauctiontimer").innerHTML = '0';

										// Stop the countdown interval
										clearInterval(countdownInterval);


										getAuctionLaneCPosts();
										// location.reload();









									}

								}

								// Update the countdown every second
								var countdownInterval = setInterval(updateCountdown, 1000);
								</script>


								<?php



            } else {
                // Display the date and time of the next auction
                echo '<h6 class="text-dark text-center">' .  __("Next Live Offers & Time In Lane C", "premiumpress") . ' ' . date('g:i a \a\t F j, Y', strtotime($next_auction_start)) . ' [' . $timezone_name . ']' . '</h6><br>';

            }

            wp_reset_postdata();

        } else {
            // echo '<h6 class="text-dark ">' .  __("No Upcoming Live offers In Lane C", "premiumpress") . ' </h6><br>';

            ?> <script>
								// function hgkjhuvgjh(){

								// location.reload();


								// }
								setInterval(getAuctionLaneCPosts, 200000);
								</script>
								<?php

        }

        echo '</div>';


    }





    $output = ob_get_clean();
    echo $output;

    die();
}

add_action('wp_ajax_getauction_lane_c', 'getauction_lane_c');
add_action('wp_ajax_nopriv_getauction_lane_c', 'getauction_lane_c');






function get_live_stream_lane_a()
{
    ob_start();


    echo '<video id="videoElement" controls autoplay muted width="100%" height="auto" poster="https://img.freepik.com/premium-vector/live-stream-icon-video-broadcasting-online-broadcast-streaming_212474-689.jpg"></video>';

    echo "
<script>
  var flvPlayer = flvjs.createPlayer({
    type: 'flv',
    url: 'https://livestream.turbobid.ca/live/lane-a.flv', // Replace with the correct URL
  });

  flvPlayer.attachMediaElement(document.getElementById('videoElement'));
  flvPlayer.load();
  flvPlayer.play();
</script> ";


    $output = ob_get_clean();
    echo $output;
}

add_action('wp_ajax_get_live_stream_lane_a', 'get_live_stream_lane_a');
add_action('wp_ajax_nopriv_get_live_stream_lane_a', 'get_live_stream_lane_a');
function get_live_stream_lane_b()
{
    ob_start();


    echo '<video id="videoElement" controls autoplay muted width="100%" height="auto" poster="https://img.freepik.com/premium-vector/live-stream-icon-video-broadcasting-online-broadcast-streaming_212474-689.jpg"></video>';

    echo "
<script>
  var flvPlayer = flvjs.createPlayer({
    type: 'flv',
    url: 'https://livestream.turbobid.ca/live/lane-b.flv', // Replace with the correct URL
  });

  flvPlayer.attachMediaElement(document.getElementById('videoElement'));
  flvPlayer.load();
  flvPlayer.play();
</script> ";


    $output = ob_get_clean();
    echo $output;
}

add_action('wp_ajax_get_live_stream_lane_b', 'get_live_stream_lane_b');
add_action('wp_ajax_nopriv_get_live_stream_lane_b', 'get_live_stream_lane_b');
function get_live_stream_lane_c()
{
    ob_start();


    echo '<video id="videoElement" controls autoplay muted width="100%" height="auto" poster="https://img.freepik.com/premium-vector/live-stream-icon-video-broadcasting-online-broadcast-streaming_212474-689.jpg"></video>';

    echo "
<script>
  var flvPlayer = flvjs.createPlayer({
    type: 'flv',
    url: 'https://livestream.turbobid.ca/live/lane-c.flv', // Replace with the correct URL
  });

  flvPlayer.attachMediaElement(document.getElementById('videoElement'));
  flvPlayer.load();
  flvPlayer.play();
</script> ";


    $output = ob_get_clean();
    echo $output;
}

add_action('wp_ajax_get_live_stream_lane_c', 'get_live_stream_lane_c');
add_action('wp_ajax_nopriv_get_live_stream_lane_c', 'get_live_stream_lane_c');








function get_user_fav_auc()
{
     
   global $CORE, $LAYOUT, $wpdb, $wp_query, $userdata; 
    
   $GLOBALS['flag-search'] = 1;
        
   if(!_ppt_checkfile("search.php")){ 
   
   
   
   // CHECK FOR REDIRECT
   if(_ppt(array("search","mustlogin")) == 1 && !$userdata->ID){ 
   
   		$link = _ppt(array("search","mustlogin_link"));
		if($link == ""){
			$link = wp_login_url();
		}
		
		header("location: ".$link);
		exit();
			
   }
 
   // GET STYLE
	if( ( defined('WLT_DEMOMODE') &&  isset($_GET['style']) && is_numeric($_GET['style']) ) || ( isset($_GET['style']) && is_numeric($_GET['style']) && function_exists('current_user_can') && current_user_can('administrator') ) ){
		$thisdesign = $_GET['style'];
	}else{
		$thisdesign = _ppt(array('design','search_layout')); 
	}	
    if($thisdesign == ""){ $thisdesign = 5; }
	
	if(THEME_KEY == "ph"){ $thisdesign = 8; }
	
	$GLOBALS['flag-search-style'] = $thisdesign;
	
	
	
	
	 
    
   
   _ppt_template( 'page', 'top' ); 
   
   if(!in_array($thisdesign,array('5','6')) ){ 
   
	_ppt_template( 'search', 'bar-filters' ); 

	}  
	
	if(in_array($thisdesign,array('7')) ){ 
	
	 _ppt_template( 'search', 'mapside' ); 
   
   } 
   
   
   if(in_array($thisdesign,array('8')) ){ 
	
	 _ppt_template( 'search', 'top-filters' ); 
   
   }  
   
 
if($CORE->LAYOUT('captions','maps') && _ppt(array("maps","enable")) == 1 && !in_array($thisdesign,array('7')) ){ _ppt_template( 'search', 'map' ); } 


if(!in_array($thisdesign,array('7'))){
?>

								<section class="bg-light section-40">
									<div
										class="<?php if(in_array($thisdesign,array('1','2')) || THEME_KEY == "ph" ){ ?>container container-full-width px-lg-5 px-md-4 mx-lg-2<?php }else{ ?>container<?php } ?>">
										<div class="row">
											<?php if(in_array($thisdesign,array('5','6')) ){ ?>
											<div class="col-md-4 col-lg-3 pr-md-4 collapsed" id="filters-extra">
												<?php _ppt_template( 'search', 'sidebar' ); ?>
											</div>
											<?php } ?>
											<div class="col">
												<div <?php if(in_array($thisdesign,array('5','6')) || $CORE->ADVERTISING("check_exists", "search_side") ){ ?>class="row px-0"
													<?php } ?>>
													<?php if($CORE->ADVERTISING("check_exists", "search_side") ){  ?>
													<div class="col-12  col-xl-10">
														<?php _ppt_template( 'search', 'bar' ); ?>
													</div>
													<div class="d-none d-lg-block col-xl-2">
														<?php if($CORE->ADVERTISING("check_exists", "search_side") ){ ?>
														<?php echo $CORE->ADVERTISING("get_banner", "search_side" );  ?>
														<?php } ?>
													</div>
													<?php }else{ ?>
													<div class="col-12">
														<?php if(isset($GLOBALS['flag-taxonomy'])){ ?>
														<?php _ppt_template( 'search', 'taxonomy' ); ?>
														<?php } ?>

														<?php dynamic_sidebar("search_top");  ?>

														<?php _ppt_template( 'search', 'bar' ); ?>

														<?php dynamic_sidebar("search_bottom");  ?>


													</div>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</section>
								<?php } ?>





								<textarea style="width:100%; height:100px; display:none" id="_filter_data"></textarea>
								<input type="hidden" name="cardlayout" class="customfilter" id="filter-cardlayout"
									data-type="select" data-key="cardlayout"
									value="<?php echo $CORE->LAYOUT("default_search_type", $thisdesign); ?>" />
								<input type="hidden" name="perpage" class="customfilter" data-type="select"
									data-key="perpage"
									value="<?php if(THEME_KEY == "ph"){ echo 24; }else{ echo get_option('posts_per_page'); } ?>">

								<?php if(isset($_GET['uid']) && is_numeric($_GET['uid']) ){ ?>
								<input type="hidden" class="customfilter" name="userid" data-type="text"
									data-key="userid" value="<?php echo esc_attr($_GET['uid']); ?>">
								<?php } ?>

								<?php if(isset($_GET['favs']) ){ ?>
								<input type="hidden" class="customfilter" name="favorites" data-type="text"
									data-key="favorites" value="1">
								<?php } ?>

								<?php if(isset($GLOBALS['flag-taxonomy']) && isset($GLOBALS['flag-taxonomy-id']) ){ ?>
								<input type="hidden" name="taxonomy" class="customfilter" data-type="text"
									data-key="taxonomy"
									value="<?php echo $GLOBALS['flag-taxonomy-type']."-".$GLOBALS['flag-taxonomy-id']; ?>">
								<?php } ?>

								<?php if(is_tag()){ 
$tag_obj = $wp_query->get_queried_object();
?>
								<input type="hidden" name="taxonomy" class="customfilter" data-type="text"
									data-key="taxonomy" value="<?php echo $tag_obj->taxonomy."-".$tag_obj->term_id; ?>">
								<?php } ?>


								<script>
								jQuery(document).ready(function() {

									<?php if(!in_array($thisdesign,array('5','6','7','8')) ){  ?>
									jQuery('.btn_filt').show();

									<?php } ?>

									_filter_update();

									// SHOW FIRST 5 FILTERS
									var i = 0;
									jQuery('.filters_sidebar .filter-content').each(function() {
										if (i < 5) {
											jQuery(this).addClass('show');
											i++;
										}

									});
								});
								</script>
								<?php _ppt_template( 'page', 'bottom' ); ?>

								<?php }
}

add_action('wp_ajax_get_user_fav_auc', 'get_user_fav_auc');
add_action('wp_ajax_nopriv_get_user_fav_auc', 'get_user_fav_auc');







// function custom_rewrite_rule() {
//     add_rewrite_rule('^liveauctions/?$', 'index.php?custom_template=liveauctions-template', 'top');
// }
// add_action('init', 'custom_rewrite_rule');

// function add_query_vars($vars) {
//     $vars[] = 'custom_template';
//     return $vars;
// }
// add_filter('query_vars', 'add_query_vars');

// function custom_template_hierarchy($template) {
//     if (get_query_var('custom_template')) {
//         return locate_template('liveauctions-template.php');
//     }
//     return $template;
// }
// add_filter('template_include', 'custom_template_hierarchy');





function attach_payment_method() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'attach_payment_method_nonce')) {
        wp_send_json_error('Invalid nonce.');
    }

    // Get the payment method ID and customer ID from the AJAX request
    $payment_method_id = $_POST['payment_method_id'];
    $user_id = $_POST['user_id'];

    // Include the Stripe PHP library
    require_once WP_PLUGIN_DIR . '/v10_gateway_stripe_checkout/stripe-php-13.16.0/init.php';

    // Set the secret key
    \Stripe\Stripe::setApiKey(get_option('stripe_secret'));

    try {
    
    	$customer_id = get_user_meta($user_id, 'stripe_customer_id', true);
        $customer_live_id = get_user_meta($user_id, 'stripe_customer_live_id', true);
        
        $isLiveMode = strpos(get_option('stripe_secret'), 'live') !== false;
    
    	if($isLiveMode){
        // Attach the payment method to the customer Live
        $payment_method = \Stripe\PaymentMethod::retrieve($payment_method_id);
        $payment_method->attach(['customer' => $customer_live_id]);

        // Set the default payment method for the customer
        \Stripe\Customer::update($customer_live_id, [
            'invoice_settings' => [
                'default_payment_method' => $payment_method_id
            ]
        ]);
        } else {
        // Attach the payment method to the customer
        $payment_method = \Stripe\PaymentMethod::retrieve($payment_method_id);
        $payment_method->attach(['customer' => $customer_id]);

        // Set the default payment method for the customer
        \Stripe\Customer::update($customer_id, [
            'invoice_settings' => [
                'default_payment_method' => $payment_method_id
            ]
        ]);
        
		}
        // Return success response
        wp_send_json_success('Payment method attached successfully.');
    } catch (Exception $e) {
        // Return error response
        wp_send_json_error('Error attaching payment method: ' . $e->getMessage());
    }

    // Make sure to exit after sending the JSON response
    exit;
}
add_action('wp_ajax_attach_payment_method', 'attach_payment_method');
add_action('wp_ajax_nopriv_attach_payment_method', 'attach_payment_method');


function retrieve_all_payment_methods() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'retrieve_all_payment_methods_nonce')) {
        wp_send_json_error('Invalid nonce.');
    }
    
    global $CORE, $userdata;

    // Get the user ID from the AJAX request
    $user_id = $_POST['user_id'];

    // Include the Stripe PHP library
    require_once WP_PLUGIN_DIR . '/v10_gateway_stripe_checkout/stripe-php-13.16.0/init.php';

    // Set the secret key
    \Stripe\Stripe::setApiKey(get_option('stripe_secret'));

    try {
    	
        $customer_id = get_user_meta($user_id, 'stripe_customer_id', true);
        $customer_live_id = get_user_meta($user_id, 'stripe_customer_live_id', true);
        
        $isLiveMode = strpos(get_option('stripe_secret'), 'live') !== false;

		if($isLiveMode && empty($customer_live_id)) {
        $email = $CORE->USER("get_email", $user_id);
		$first_name = $userdata->first_name;
		$last_name = $userdata->last_name;
        // Create a new customer
        
        $customer = \Stripe\Customer::create([
            'name' => $first_name . ' ' . $last_name,
            'email' => $email,
            'metadata' => ['turbobid_uid' => $user_id]
        ]);
		
        // Save the customer ID in WordPress user meta for future reference
        update_user_meta($user_id, 'stripe_customer_live_id', $customer->id);
        
        $customer_live_id = $customer->id;
        
        }

		if($isLiveMode && !empty($customer_live_id)){
        // Retrieve live customer's default payment method ID
        $customer = \Stripe\Customer::retrieve($customer_live_id);
         // Retrieve all payment methods for the live customer
        $payment_methods = \Stripe\PaymentMethod::all(['customer' => $customer_live_id, 'type' => 'card']);
        $default_payment_method = $customer->invoice_settings->default_payment_method;
		}else{
        // Retrieve customer's default payment method ID
        $customer = \Stripe\Customer::retrieve($customer_id);
         // Retrieve all payment methods for the customer
        $payment_methods = \Stripe\PaymentMethod::all(['customer' => $customer_id, 'type' => 'card']);
        $default_payment_method = $customer->invoice_settings->default_payment_method;
        
        }
        
        // Prepare response data
        $response_data = array(
            'payment_methods' => $payment_methods->data,
            'default_payment_method' => $default_payment_method
        );

        // Return success response with payment methods data
        wp_send_json_success($response_data);
        
    } catch (Exception $e) {
        // Return error response
        wp_send_json_error('Error retrieving payment methods: ' . $e->getMessage());
    }

    // Make sure to exit after sending the JSON response
    exit;
}
add_action('wp_ajax_retrieve_all_payment_methods', 'retrieve_all_payment_methods');
add_action('wp_ajax_nopriv_retrieve_all_payment_methods', 'retrieve_all_payment_methods');




function set_default_payment_method() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'set_default_payment_method_nonce')) {
        wp_send_json_error('Invalid nonce.');
    }

    $payment_method_id = $_POST['payment_method_id'];
    $user_id = $_POST['user_id'];

    // Include the Stripe PHP library
    require_once WP_PLUGIN_DIR . '/v10_gateway_stripe_checkout/stripe-php-13.16.0/init.php';

    // Set the secret key
    \Stripe\Stripe::setApiKey(get_option('stripe_secret'));

    try {
    
    	$customer_id = get_user_meta($user_id, 'stripe_customer_id', true);
        $customer_live_id = get_user_meta($user_id, 'stripe_customer_live_id', true);
        
        $isLiveMode = strpos(get_option('stripe_secret'), 'live') !== false;
        
        if($isLiveMode){
         // Set the default payment method for the live customer
        $customer = \Stripe\Customer::update(
            $customer_live_id,
            ['invoice_settings' => ['default_payment_method' => $payment_method_id]]
        );
        }else{
        // Set the default payment method for the customer
        $customer = \Stripe\Customer::update(
            $customer_id,
            ['invoice_settings' => ['default_payment_method' => $payment_method_id]]
        );
        }

        // Return success response
        wp_send_json_success('Default Payment Method set successfully.');
    } catch (Exception $e) {
        // Return error response
        wp_send_json_error('Error setting default payment method: ' . $e->getMessage());
    }

    // Make sure to exit after sending the JSON response
    exit;
}
add_action('wp_ajax_set_default_payment_method', 'set_default_payment_method');
add_action('wp_ajax_nopriv_set_default_payment_method', 'set_default_payment_method');




function remove_payment_method() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'remove_payment_method_nonce')) {
        wp_send_json_error('Invalid nonce.');
    }

    // Get the payment method ID from the AJAX request
    $payment_method_id = $_POST['payment_method_id'];

    // Include the Stripe PHP library
    require_once WP_PLUGIN_DIR . '/v10_gateway_stripe_checkout/stripe-php-13.16.0/init.php';

    // Set the secret key
    \Stripe\Stripe::setApiKey(get_option('stripe_secret'));

    try {
        // Retrieve the payment method
        $payment_method = \Stripe\PaymentMethod::retrieve($payment_method_id);

        // Detach the payment method
        $payment_method->detach();

        // Return success response
        wp_send_json_success('Payment Method detached successfully.');
    } catch (Exception $e) {
        // Return error response
        wp_send_json_error('Error detaching payment method: ' . $e->getMessage());
    }

    // Make sure to exit after sending the JSON response
    exit;
}
add_action('wp_ajax_remove_payment_method', 'remove_payment_method');
add_action('wp_ajax_nopriv_remove_payment_method', 'remove_payment_method');



function set_card_save_container() {

  ob_start();
  
   // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'add_stripe_payment_methods_nonce')) {
        wp_send_json_error('Invalid nonce.');
    }
  
  	global $wpdb, $CORE, $userdata;

  
    
    // Include the Stripe PHP library
    require_once WP_PLUGIN_DIR . '/v10_gateway_stripe_checkout/stripe-php-13.16.0/init.php';

    // Set the secret key
    \Stripe\Stripe::setApiKey(get_option('stripe_secret'));

    try {
    
        $user_id = $userdata->ID;
		$email = $CORE->USER("get_email", $user_id);
		$first_name = $userdata->first_name;
		$last_name = $userdata->last_name;
        
        $customer_id = get_user_meta($user_id, 'stripe_customer_id', true);
        $customer_live_id = get_user_meta($user_id, 'stripe_customer_live_id', true);
        
        $isLiveMode = strpos(get_option('stripe_secret'), 'live') !== false;
    	
         
       if (empty($customer_id) && !$isLiveMode ) {
        // Create a new customer
        
        $customer = \Stripe\Customer::create([
            'name' => $first_name . ' ' . $last_name,
            'email' => $email,
            'metadata' => ['turbobid_uid' => $user_id]
        ]);
		
        // Save the customer ID in WordPress user meta for future reference
        update_user_meta($user_id, 'stripe_customer_id', $customer->id);
        
        $customer_id = $customer->id;
        
        } else if(empty($customer_live_id) && $isLiveMode ) {
        
        // Create a new customer
        
        $customer = \Stripe\Customer::create([
            'name' => $first_name . ' ' . $last_name,
            'email' => $email,
            'metadata' => ['turbobid_uid' => $user_id]
        ]);
		
        // Save the customer ID in WordPress user meta for future reference
        update_user_meta($user_id, 'stripe_customer_live_id', $customer->id);
        
        $customer_live_id = $customer->id;
        
        }
        
        
        
    if((!empty($customer_id) && !$isLiveMode) || (!empty($customer_live_id) && $isLiveMode)) {
        
                
 ?>


								<form id="payment-form">
									<span>Credit Card information</span>
									<div class="mt-2">
										<label for="card-element">
											Name on card
										</label>
										<input type="text" id="card-holder-name" class="form-control"
											placeholder="Name on card" required>
									</div>

									<div class="my-3">
										<label for="card-element">
											Credit card
										</label>
										<div id="card-element">
											<!-- A Stripe Element will be inserted here. -->
										</div>

									</div>

									<div class="mb-2">
										<label for="card-element">
											Phone Number
										</label>
										<input type="text" id="card-holder-phone" class="form-control"
											placeholder="Phone Number" required>
									</div>

									<!-- Used to display form errors. -->
									<div id="card-errors" role="alert"></div>

									<button id="submit-button" class="btn btn-secondary btn-md mt-2" type="submit">Add
										Card</button>
								</form>


								<script>
								var clientSecret = '<?php echo  get_option('stripe_secret'); ?>';
								var stripe_pub_key = '<?php echo  get_option('stripe_production'); ?>';
								var stripe = Stripe(stripe_pub_key);
								// Create an instance of Elements
								var elements = stripe.elements();

								// Create an instance of the card Element
								var card = elements.create('card');

								// Add an instance of the card Element into the `card-element` div
								card.mount('#card-element');

								// Handle real-time validation errors on the card Element
								card.addEventListener('change', function(event) {
									var displayError = document.getElementById('card-errors');
									if (event.error) {
										displayError.textContent = event.error.message;
									} else {
										displayError.textContent = '';
									}
								});

								// Handle form submission
								var form = document.getElementById('payment-form');
								form.addEventListener('submit', function(event) {
									event.preventDefault();

									// Disable the submit button to prevent multiple submissions
									document.getElementById('submit-button').disabled = true;

									// Get the card holder name
									var cardHolderName = document.getElementById('card-holder-name').value;

									var cardHolderPhone = document.getElementById('card-holder-phone').value;

									// Create a payment method using the card Element
									stripe.createPaymentMethod({
										type: 'card',
										card: card,
										billing_details: {
											name: cardHolderName,
											phone: cardHolderPhone
										}
									}).then(function(result) {
										if (result.error) {
											// Inform the user if there was an error
											var errorElement = document.getElementById('card-errors');
											errorElement.textContent = result.error.message;

											// Re-enable the submit button
											document.getElementById('submit-button').disabled = false;
										} else {

											var paymentMethodId = result.paymentMethod.id;
											attachPaymentMethod(paymentMethodId);

										}
									});
								});


								function attachPaymentMethod(paymentMethodId) {
									// Send AJAX request to attach payment method
									jQuery.ajax({
										url: '<?php echo admin_url('admin-ajax.php'); ?>',
										type: 'POST',
										data: {
											action: 'attach_payment_method',
											payment_method_id: paymentMethodId,
											user_id: '<?php echo $user_id; ?>',
											nonce: '<?php echo wp_create_nonce('attach_payment_method_nonce'); ?>'
										},
										success: function(response) {
											if (response.success) {
												if (jQuery('.add-stripe-card-modal-wrap').length) {
													// Fade out the element with class '.add-stripe-card-modal-wrap'
													jQuery('.add-stripe-card-modal-wrap').fadeOut(400);
												}

												// Check if 'retrieveAllPaymentMethods' function is defined and callable
												if (typeof retrieveAllPaymentMethods === 'function') {
													// Call the 'retrieveAllPaymentMethods' function
													retrieveAllPaymentMethods();
												}

												if (typeof payNowCheckout === 'function') {

													payNowCheckout();
												}

												// Check if 'ajax_load_buybox_bid' function is defined and callable
												if (typeof ajax_load_buybox_bid === 'function') {
													// Call the 'ajax_load_buybox_bid' function
													ajax_load_buybox_bid();
												}

											} else {
												// Re-enable the submit button
												document.getElementById('submit-button').disabled = false;
												var errorElement = document.getElementById('card-errors');
												errorElement.textContent = response.data;
												if (jQuery('.add-stripe-card-modal-wrap').length) {
													setTimeout(function() {
														jQuery('.add-stripe-card-modal-wrap')
															.fadeOut(400);
													}, 5000);

												}

											}

										},
										error: function(xhr, status, error) {
											console.error('AJAX Error:', error);
											// Handle error response
										}
									});
								}
								</script>




								<?php
        
        }
       
    } catch (Exception $e) {
        // Return error response
        wp_send_json_error('Error setting error: ' . $e->getMessage());
    }

   exit;
}
add_action('wp_ajax_set_card_save_container', 'set_card_save_container');
add_action('wp_ajax_nopriv_set_card_save_container', 'set_card_save_container');


function show_modal_yes_no() {
    // Retrieve message, card name, and yes button call from the AJAX request
    $message = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : '';
    $card_name = isset($_POST['card_name']) ? sanitize_text_field($_POST['card_name']) : '';
    $yes_btn_call = isset($_POST['yes_btn_call']) ? wp_unslash($_POST['yes_btn_call']) : '';

    ob_start();

    // Output modal content
    echo '<p>' . esc_html($message) . ' ' . esc_html($card_name) . '?</p>';
    echo '<div class="modal-footer">';
    echo '<button class="btn btn-secondary" onclick="jQuery(\'.add-stripe-card-modal-wrap\').fadeOut(400);" id="cancel-modal">' . esc_html__("Cancel", "premiumpress") . '</button>';
    echo '<button class="btn btn-primary" id="confirm-modal" onclick="'. esc_js($yes_btn_call) .'">' . esc_html__("Yes", "premiumpress") . '</button>';
    echo '</div>';

    // Capture output and return as response
    exit;
}
add_action('wp_ajax_show_modal_yes_no', 'show_modal_yes_no');
add_action('wp_ajax_nopriv_show_modal_yes_no', 'show_modal_yes_no');



function delete_payment_user_card() {
    // Retrieve message, card name, and yes button call from the AJAX request
    $message = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : '';
    $card_name = isset($_POST['card_name']) ? sanitize_text_field($_POST['card_name']) : '';
    $yes_btn_call = isset($_POST['yes_btn_call']) ? wp_unslash($_POST['yes_btn_call']) : '';
    
    $no_btn_call = isset($_POST['no_btn_call']) ? wp_unslash($_POST['no_btn_call']) : '';

    ob_start();

    // Output modal content
    echo '<p>' . esc_html($message) . ' ' . esc_html($card_name) . '?</p>';
    echo '<div class="modal-footer">';
    echo '<button class="btn btn-secondary" onclick="'. esc_js($no_btn_call) .'" id="cancel-modal">' . esc_html__("Cancel", "premiumpress") . '</button>';
    echo '<button class="btn btn-primary" id="confirm-modal" onclick="'. esc_js($yes_btn_call) .'">' . esc_html__("Yes", "premiumpress") . '</button>';
    echo '</div>';

    // Capture output and return as response
    exit;
}
add_action('wp_ajax_delete_payment_user_card', 'delete_payment_user_card');
add_action('wp_ajax_nopriv_delete_payment_user_card', 'delete_payment_user_card');


// Hook the AJAX handler for initiating the Stripe payment
add_action('wp_ajax_initiate_stripe_payment', 'initiate_stripe_payment');
add_action('wp_ajax_nopriv_initiate_stripe_payment', 'initiate_stripe_payment');

function initiate_stripe_payment() {
    // Verify nonce (if applicable)
    wp_verify_nonce($_POST['nonce'], 'stripe_payment_nonce');

    $amount = $_POST['amount'];
    $order_id = $_POST['order_id'];
    $description = $_POST['description'];

    global $CORE, $userdata;
    
    // Include the Stripe PHP library
    require_once WP_PLUGIN_DIR . '/v10_gateway_stripe_checkout/stripe-php-13.16.0/init.php';

    // Set the secret key
    \Stripe\Stripe::setApiKey(get_option('stripe_secret'));

    try {
        // Retrieve or create the Stripe customer
        $user_id = $userdata->ID;
        $customer_id = get_user_meta($user_id, 'stripe_customer_id', true);
        $customer_live_id = get_user_meta($user_id, 'stripe_customer_live_id', true);
        
        $isLiveMode = strpos(get_option('stripe_secret'), 'live') !== false;
        if($isLiveMode){
         
        if(empty($customer_live_id)) {
            // Create a new customer
            $customer = \Stripe\Customer::create([
                'name' => $userdata->first_name . ' ' . $userdata->last_name,
                'email' => $CORE->USER("get_email", $user_id),
                'metadata' => ['turbobid_uid' => $user_id]
            ]);

            // Save the customer ID in WordPress user meta for future reference
            update_user_meta($user_id, 'stripe_customer_live_id', $customer->id);
            $customer_live_id = $customer->id;
        }
        
       
        
        // Retrieve the customer's default payment method
        $customer = \Stripe\Customer::retrieve($customer_live_id);
       
        $default_payment_method = $customer->invoice_settings->default_payment_method;
        
        // Prepare payment intent data with the default payment method
         $intent = \Stripe\PaymentIntent::create([
            'amount' => $amount,
            'currency' => get_option('stripe_currency'),
            'customer' => $customer_live_id,
            'payment_method' => $default_payment_method,
            'off_session' => true,
            'confirm' => true, // Confirm the payment immediately
            
        ]);

        // Payment intent creation successful, proceed with further actions
        
        }else{ 
        if(empty($customer_id)) {
            // Create a new customer
            $customer = \Stripe\Customer::create([
                'name' => $userdata->first_name . ' ' . $userdata->last_name,
                'email' => $CORE->USER("get_email", $user_id),
                'metadata' => ['turbobid_uid' => $user_id]
            ]);

            // Save the customer ID in WordPress user meta for future reference
            update_user_meta($user_id, 'stripe_customer_id', $customer->id);
            $customer_id = $customer->id;
        }
        
        // Retrieve the customer's default payment method
        $customer = \Stripe\Customer::retrieve($customer_id);
       
        $default_payment_method = $customer->invoice_settings->default_payment_method;
        
        // Prepare payment intent data with the default payment method
         $intent = \Stripe\PaymentIntent::create([
            'amount' => $amount,
            'currency' => get_option('stripe_currency'),
            'customer' => $customer_id,
            'payment_method' => $default_payment_method,
            'off_session' => true,
            'confirm' => true, // Confirm the payment immediately
            
        ]);

        // Payment intent creation successful, proceed with further actions
       }

        // PASS IN DATA
        $data = core_generic_gateway_callback(
            $order_id,
            array(
                'description' => $description,
                'email' => $CORE->USER("get_email", $user_id),
                'shipping' => 0,
                'shipping_label' => '',
                'tax' => 0,
                'payment_data' => '',
                'gateway_name' => 'stripe',
                'amount' => $amount / 100, // Convert amount back to currency unit
            )
        );


		// Trigger the hook_callback action with the data
        do_action('hook_callback', $data);
        
        
        
        wp_send_json_success($data);

    } catch (Exception $e) {
        // Return error response
        wp_send_json_error(['message' => 'Error initiating payment: ' . $e->getMessage()]);
    }

    // Make sure to exit after sending the JSON response
    exit;
}





add_action('wp_ajax_update_billing_address', 'update_billing_address');
add_action('wp_ajax_nopriv_update_billing_address', 'update_billing_address');

function update_billing_address() {
    try {
    
    	global $CORE, $userdata;
        
        // Get the updated billing address data from the AJAX request
        $billing_address = sanitize_text_field($_POST['billing_address']);
        $billing_country = sanitize_text_field($_POST['billing_country']);
        $billing_city = sanitize_text_field($_POST['billing_city']);
        $billing_state = sanitize_text_field($_POST['billing_state']);
        $billing_area = sanitize_text_field($_POST['billing_area']);
        $billing_route = sanitize_text_field($_POST['billing_route']);
        $billing_neighborhood = sanitize_text_field($_POST['billing_neighborhood']);
        $map_log = sanitize_text_field($_POST['map_log']);
        $map_lat = sanitize_text_field($_POST['map_lat']);

        // Update the user's billing address fields
        update_user_meta($userdata->ID, 'address1', $billing_address);
        update_user_meta($userdata->ID, 'address2', $billing_route);
        update_user_meta($userdata->ID, 'country', $billing_country);
        update_user_meta($userdata->ID, 'city', $billing_city);
        update_user_meta($userdata->ID, 'town', $billing_state);
        update_user_meta($userdata->ID, 'area', $billing_area);
        update_user_meta($userdata->ID, 'route', $billing_route);
        update_user_meta($userdata->ID, 'neighborhood', $billing_neighborhood);
        update_user_meta($userdata->ID, 'map_log', $map_log);
        update_user_meta($userdata->ID, 'map_lat', $map_lat);

        // Additional data to include in the success response
        $additional_data = array(
            'billing_address' => $billing_address,
            'billing_country' => $billing_country,
            'billing_city' => $billing_city,
            'billing_state' => $billing_state,
            'billing_area' => $billing_area,
            'billing_route' => $billing_route,
            'billing_neighborhood' => $billing_neighborhood,
            'map_log' => $map_log,
            'map_lat' => $map_lat,
            // Add more fields as needed
        );

        // Send a response back to the client with success message and additional data
        wp_send_json_success(array('message' => 'Billing address updated successfully!', 'data' => $additional_data));
    } catch (Exception $e) {
        // Return error response
        wp_send_json_error('Error updating address: ' . $e->getMessage());
    }

    // Make sure to exit after sending the JSON response
    wp_die();
}


add_action('wp_ajax_get_user_tax_price', 'get_user_tax_price');
add_action('wp_ajax_nopriv_get_user_tax_price', 'get_user_tax_price');

function get_user_tax_price() {
    try {
    
    	global $CORE, $userdata;
        
       
       $delivery_country 	= get_user_meta($userdata->ID, 'country', true);
		$delivery_state 	= get_user_meta($userdata->ID, 'city', true);
        $taxSet = 0;
		 
		
		 
			$regions = _ppt('regions');	
			if(is_array($regions)){ 
				$i=0; 
				while($i < count($regions['name']) ){
					if($regions['name'][$i] !=""){	
					
						
						if( (!empty($regions['country'][$i]) && in_array($delivery_country, $regions['country'][$i]) ) 
						|| (!empty($regions['state'][$i]) && in_array($delivery_state, $regions['state'][$i]) ) ) { // COUNTRY OR STATE CHECKOUT	
						
					 
							// FLAT RATE 
							if( is_numeric( _ppt(array('tax_country','price_'.$regions['key'][$i])) ) && !$taxSet ){ 
							 $user_shipping_tax = _ppt(array('tax_country','price_'.$regions['key'][$i])); 
								
							}
									
							// FLAT PERCENTAGE
							if( is_numeric( _ppt(array('tax_country','percentage_'.$regions['key'][$i])) ) && !$taxSet  ){ 		 
								  $user_shipping_tax = _ppt(array('tax_country','percentage_'.$regions['key'][$i])) /100;
								
							}					
						
						}
												
					}
				$i++;
				} 
			}
            
          $user_shipping_tax = hook_price($user_shipping_tax);
          $user_city = $CORE->USER("get_address_part", array("city", $userdata->ID));
          $user_town = $CORE->USER("get_address_part", array("town", $userdata->ID));

        // Additional data to include in the success response
        $additional_data = array(
            'tax' => $user_shipping_tax,
            'user_city' => $user_city,
            'user_town' => $user_town,
        );
        
        wp_send_json_success($additional_data);
    } catch (Exception $e) {
        // Return error response
        wp_send_json_error('Error get data: ' . $e->getMessage());
    }

    // Make sure to exit after sending the JSON response
    wp_die();
}



add_action('wp_ajax_post_comment', 'post_comment');
add_action('wp_ajax_nopriv_post_comment', 'post_comment');

function post_comment() {
    $comment_content = $_POST['comment'];
    $post_id = $_POST['post_id'];

    // Create the comment data array
    $comment_data = array(
        'comment_post_ID' => $post_id,
        'comment_content' => $comment_content,
        'user_id' => get_current_user_id(),
    );

    // Insert the comment into the database
    $comment_id = wp_insert_comment($comment_data);

    // Get the updated comments section HTML
    wp_send_json_success($comment_id);

    // Make sure to exit after sending the response
    wp_die();
}




add_action('wp_ajax_post_reply', 'post_reply');
add_action('wp_ajax_nopriv_post_reply', 'post_reply');

function post_reply() {
    $comment_content = $_POST['comment'];
    $post_id = $_POST['post_id'];
    $comment_parent = $_POST['comment_parent'];

    // Create the comment data array
    $comment_data = array(
        'comment_post_ID' => $post_id,
        'comment_content' => $comment_content,
        'user_id' => get_current_user_id(),
        'comment_parent' => $comment_parent
    );

    // Insert the comment into the database
    $comment_id = wp_insert_comment($comment_data);

    wp_send_json_success($comment_id);

    // Make sure to exit after sending the response
    wp_die();
}



function ending_soon_listings_shortcode() {
    ob_start();
    ?>
								<div class="col-12">
									<div class="clearfix"></div>
									<div class="ending-soon-listings owl-carousel owl-theme">
										<?php
            $data = str_replace(".00", "", do_shortcode('[LISTINGS dataonly=1 nav=0 small=1 carousel=1 custom=endsoon]'));

            if (strlen($data) < 10) {
                $data = str_replace(".00", "", do_shortcode('[LISTINGS dataonly=1 nav=0 small=1 carousel=1 custom=endsoon]'));
            }

            echo $data;

            if (_ppt(array('lst', 'hide_featuredimage')) == "1") {
                $GLOBALS['flag-singlepage'] = 1;
            }
            ?>
									</div>
								</div>

								<script>
								jQuery(document).ready(function() {
									var owl = jQuery(".ending-soon-listings").owlCarousel({
										loop: false,
										margin: 20,
										nav: true,
										dots: false,
										lazyLoad: true,
										responsive: {
											0: {
												items: 1
											},
											600: {
												items: 2
											},
											1000: {
												items: 4
											},
											1200: {
												items: 5
											}
										},
										onInitialized: setStagePosition,
										onTranslated: setStagePosition
									});

									function setStagePosition(event) {
										var itemIndex = event.item.index;
										var itemCount = event.item.count;
										var itemsPerPage = event.page.size;

										var stage = jQuery('.ending-soon-listings .owl-stage-outer .owl-stage');

										if (itemIndex === 0) {
											stage.css('left', '80px');
										} else {
											stage.css('left', '0');
										}

										if (itemIndex >= itemCount - itemsPerPage) {
											stage.css('right', '80px');
										} else {
											stage.css('right', '0');
										}
									}
								});
								</script>
								<style>
								.ending-soon-listings .owl-nav .owl-next {
									position: absolute;
									left: 10px;
									top: 160px;
									z-index: 0;
									transform: rotate(180deg);
									background: white !important;
									width: 40px;
									height: 40px;
									display: flex !important;
									justify-content: center;
									align-items: center;
									border-radius: 50px !important;
									padding: 0px !important;
									margin: 0px !important;


								}

								.ending-soon-listings .owl-nav .owl-prev {
									position: absolute;
									right: 10px;
									top: 160px;
									z-index: 0;
									transform: rotate(180deg);
									background: white !important;
									width: 40px;
									height: 40px;
									display: flex !important;
									justify-content: center;
									align-items: center;
									border-radius: 50px !important;
									padding: 0px !important;
									margin: 0px !important;

								}

								.ending-soon-listings .owl-nav .owl-prev:focus,
								.ending-soon-listings .owl-nav .owl-next:focus {
									background-color: yellow;
									border: 0px solid #fff;
								}

								.ending-soon-listings .owl-nav .owl-prev span,
								.ending-soon-listings .owl-nav .owl-next span {
									font-size: 20px !important;
									color: black;

								}

								.ending-soon-listings .owl-nav .owl-prev span:hover,
								.ending-soon-listings .owl-nav .owl-next span:hover color:black;

								}

								.ending-soon-listings .owl-stage-outer .owl-stage {
									z-index: 11;
								}


								.new-search {
									border-radius: 10px !important;
									border: 0px solid #fff;
								}



								.new-search:not(.img-user):not(.no-resize) figure a img {
									border-top-left-radius: 10px;
									border-top-right-radius: 10px;
								}

								.new-search .card-body {
									border-bottom-left-radius: 10px;
									border-bottom-right-radius: 10px;
								}
								</style>
								<?php
    return ob_get_clean();
}

add_shortcode('ending_soon_listings', 'ending_soon_listings_shortcode');



// AJAX handler for filtering images
function filter_images_ajax_handler() {
    // Check nonce for security
    check_ajax_referer('filter_images_nonce', 'nonce');

    // Get the parameters
    $post_id = intval($_POST['post_id']);
    $category = sanitize_text_field($_POST['category']);

    // Get files
    global $CORE;
    $files = $CORE->MEDIA("get_all_images", $post_id);

    // Function to filter images by category
    // Function to filter images by category
function get_filtered_images($files, $category) {
    if ($category === 'all') {
        return $files;
    }

    $filtered_images = array_filter($files, function ($file) use ($category) {
        // Split category into words and filter non-alphanumeric characters
        $category_words = preg_split('/[^a-zA-Z0-9]+/', $category);
        $category_words = array_filter($category_words);

        // Split file name into words and filter non-alphanumeric characters
        $file_name_words = preg_split('/[^a-zA-Z0-9]+/', $file['name']);
        $file_name_words = array_filter($file_name_words);

        // Check if any category word is found in file name words
        foreach ($category_words as $category_word) {
            foreach ($file_name_words as $file_name_word) {
                // Case insensitive comparison
                if (stripos($file_name_word, $category_word) !== false) {
                    return true;
                }
            }
        }
        return false;
    });

    return count($filtered_images) > 0 ? $filtered_images : $files;
}


    // Filter images based on category
    $filtered_images = get_filtered_images($files, $category);

    // Function to generate slick slider
    function generate_slick_slider($slider_id, $images) {
        ob_start();
        if (empty($images)) {
            echo do_shortcode('[IMAGE link=0]');
            return;
        }
        ?>
								<div class="main">
									<?php if (count($images) > 1): ?>
									<div class="slider slider-for-<?php echo $slider_id; ?>">
										<?php foreach ($images as $f): ?>
										<a href="<?php echo $f['src']; ?>" data-toggle="lightbox" data-type="image">
											<img src="<?php echo $f['src']; ?>" class="img-fluid"
												alt="<?php echo $f['name']; ?>" style="width:100%; border-radius:15px">
										</a>
										<?php endforeach; ?>
									</div>
									<div class="slider slider-nav-<?php echo $slider_id; ?>">
										<?php foreach ($images as $f): ?>
										<div>
											<img src="<?php echo $f['src']; ?>" alt="<?php echo $f['name']; ?>">
										</div>
										<?php endforeach; ?>
									</div>
									<?php else: ?>
									<div class="single-image">
										<a href="<?php echo $images[0]['src']; ?>" data-toggle="lightbox"
											data-type="image">
											<img src="<?php echo $images[0]['src']; ?>" class="img-fluid"
												alt="<?php echo $images[0]['name']; ?>"
												style="width:100%; border-radius:15px">
										</a>
									</div>
									<?php endif; ?>
								</div>

								<?php if (count($images) > 1): ?>
								<script>
								jQuery(document).ready(function($) {
									// Initialize slick sliders
									$('.slider-for-<?php echo $slider_id; ?>').slick({
										slidesToShow: 1,
										slidesToScroll: 1,
										arrows: false,
										fade: true,
										asNavFor: '.slider-nav-<?php echo $slider_id; ?>'
									});

									$('.slider-nav-<?php echo $slider_id; ?>').slick({
										slidesToShow: 3,
										slidesToScroll: 1,
										asNavFor: '.slider-for-<?php echo $slider_id; ?>',
										dots: false,
										focusOnSelect: true,
										centerMode: true,
										variableWidth: true,
										prevArrow: '<span class="slick-prev"><i class="fa-solid fa-chevron-left"></i></span>',
										nextArrow: '<span class="slick-next"><i class="fa-solid fa-chevron-right"></i></span>'
									});
								});
								</script>

								<style>
								.slider-nav-<?php echo $slider_id;

								?> {
									padding-left: 50px;
									padding-right: 50px;
								}

								.slider-nav-<?php echo $slider_id;

								?>.slick-prev {
									left: 0;
									position: absolute;
									cursor: pointer;
								}

								.slider-nav-<?php echo $slider_id;

								?>.slick-next {
									right: 0;
									position: absolute;
									cursor: pointer;
								}

								.slider-for-<?php echo $slider_id;

								?>img {
									border-radius: 15px;
								}

								.slider-nav-<?php echo $slider_id;

								?>img {

									cursor: pointer;
								}

								@media (max-width:500px) {
									.slider-for-<?php echo $slider_id;

									?>img {
										height: 280px !important;
										margin-bottom: 20px;
									}

									.slider-nav-<?php echo $slider_id;

									?>img {
										width: 60px;
										height: 60px;

										margin-right: 5px;
										border-radius: 8px;
									}

									.slider-nav-<?php echo $slider_id;

									?>.slick-prev {

										top: 20px;
									}

									.slider-nav-<?php echo $slider_id;

									?>.slick-next {

										top: 20px;
									}
								}

								@media screen and (max-width: 900px) and (min-width: 501px) {
									.slider-for-<?php echo $slider_id;

									?>img {
										height: 400px !important;
										margin-bottom: 20px;
									}

									.slider-nav-<?php echo $slider_id;

									?>img {
										width: 70px;
										height: 70px;

										margin-right: 6px;
										border-radius: 6px;
									}

									.slider-nav-<?php echo $slider_id;

									?>.slick-prev {

										top: 25px;
									}

									.slider-nav-<?php echo $slider_id;

									?>.slick-next {

										top: 25px;
									}

								}

								@media screen and (max-width: 1200px) and (min-width: 901px) {
									.slider-for-<?php echo $slider_id;

									?>img {
										height: 351px !important;
										margin-bottom: 20px;
									}

									.slider-nav-<?php echo $slider_id;

									?>img {
										width: 80px;
										height: 80px;

										margin-right: 8px;
										border-radius: 8px;
									}

									.slider-nav-<?php echo $slider_id;

									?>.slick-prev {

										top: 30px;
									}

									.slider-nav-<?php echo $slider_id;

									?>.slick-next {

										top: 30px;
									}
								}

								@media (min-width:1201px) {
									.slider-for-<?php echo $slider_id;

									?>img {
										height: 464px !important;
										margin-bottom: 20px;
									}

									.slider-nav-<?php echo $slider_id;

									?>img {
										width: 100px;
										height: 100px;
										margin-right: 10px;
										border-radius: 10px;

									}

									.slider-nav-<?php echo $slider_id;

									?>.slick-prev {

										top: 40px;
									}

									.slider-nav-<?php echo $slider_id;

									?>.slick-next {

										top: 40px;
									}
								}
								</style>
								<?php endif;
        return ob_get_clean();
    }

    // Generate slider content
    $slider_content = generate_slick_slider($category, $filtered_images);

    // Send response
    echo json_encode(['content' => $slider_content]);
    wp_die(); // This is required to terminate immediately and return a proper response
}

// Register the AJAX actions
add_action('wp_ajax_filter_images', 'filter_images_ajax_handler');
add_action('wp_ajax_nopriv_filter_images', 'filter_images_ajax_handler');


add_action('wp_ajax_load_video_content', 'load_video_content');
add_action('wp_ajax_nopriv_load_video_content', 'load_video_content');

function load_video_content() {
    global $CORE, $post, $userdata;
    
    $post_id = intval($_POST['post_id']);
    
    // Load the video template
    $files = $CORE->MEDIA("get_all_images", $post_id);
    $videos = $CORE->MEDIA("get_all_videos", $post_id);
    
    $youtubevid = 0;
    $videmovid = 0;

    if (!is_array($videos) || (is_array($videos) && empty($videos))) {
        $youtubeid = get_post_meta($post_id, 'youtube_id', true);
        
        if ($youtubeid != "") {
            $youtubevid = 1;
            $videos = array('');
        }
        
        $videid = get_post_meta($post_id, 'vimeo_id', true);
        if ($videid != "") {
            $videmovid = 1;
            $videos = array('');
        }
    }

    ob_start();

    ?>
								<div class="card p-lg-4 position-relative overflow-hidden">
									<i class="fal fa-smile fa-8x text-primary"
										style="position:absolute; bottom:-25px; right:-15px;"></i>
									<div class="bg-image"
										data-bg="<?php if(isset($files[2]['src'])){  echo $files[2]['src']; }elseif(isset($files[0]['src'])){ echo $files[0]['src']; } ?>">
									</div>
									<div class="overlay-inner opacity-8"></div>
									<div class="bg-content text-white p-4">
										<div class="addeditmenu" data-key="video"></div>
										<h5 class="card-title"><?php echo get_the_title($post_id); ?></h5>
										<div class="small mb-3"> <?php echo count($videos); ?> vids</div>
										<?php if(!$userdata->ID && in_array(_ppt(array('design', 'display_videologin')), array("","1")) ){ ?>
										<a onclick="processLogin();" href="javascript:void(0);" class="btn btn-system ">
											<i class="fal fa-video text-primary mr-2"></i>
											<?php echo __("Watch Videos","premiumpress"); ?>
										</a>
										<?php } elseif (!$CORE->USER("membership_hasaccess", "view_videos")) { ?>
										<a onclick="processUpgrade();" href="javascript:void(0);"
											class="btn btn-system ">
											<i class="fal fa-video text-primary mr-2"></i>
											<?php echo __("Watch Videos","premiumpress"); ?>
										</a>
										<?php } elseif (!is_array($videos) || (is_array($videos) && empty($videos) && ($youtubevid == 0 && $videmovid == 0))) { ?>
										<button class="btn btn-system " disabled>
											<i class="fal fa-video  mr-2"></i>
											<?php echo __("No Videos","premiumpress"); ?>
										</button>
										<?php } else { ?>
										<a href="javascript:void(0);" onclick="processVideoOpen();"
											class="btn btn-system ">
											<i class="fal fa-video text-primary mr-2"></i>
											<?php echo __("Watch Videos","premiumpress"); ?>
										</a>
										<script>
										function processVideoOpen() {
											jQuery.ajax({
												type: "POST",
												url: ajax_site_url,
												data: {
													action: "load_video_form",
													pid: <?php echo $post_id; ?>
												},
												success: function(response) {
													jQuery(".video-modal-wrap").fadeIn(400);
													jQuery('#videoplayerajaxwindow').html(response);
													jQuery('video').mediaelementplayer({
														videoWidth: '100%',
														videoHeight: '100%',
														enableAutosize: true,
													});
												},
												error: function(e) {
													console.log(e)
												}
											});
										}
										</script>
										<?php } ?>
									</div>
								</div>

								<div class="video-modal-wrap shadow hidepage" style="display:none;">
									<div class="video-modal-wrap-overlay"></div>
									<div class="video-modal-item">
										<div class="video-modal-container">
											<div class="card-body">
												<div id="videoplayerajaxwindow"></div>
											</div>
											<div class="card-footer text-center">
												<button type="button"
													onclick="jQuery('.video-modal-wrap').fadeOut(400);"
													class="btn btn-system shadow-sm btn-xl"><?php echo __("Close Window","premiumpress"); ?></button>
											</div>
										</div>
									</div>
								</div>
								<?php

    wp_die();
}




function loan_calculator_shortcode() {
    ob_start();
    _ppt_template('templates/car-loan-calculator');
    return ob_get_clean();
}

add_shortcode('loan_calculator', 'loan_calculator_shortcode');



function custom_user_dropdown_shortcode($atts) {
    global $post;

    

    $post_id = intval($_GET['eid']);
    $post = get_post($post_id);

    

    // Fetch users
    $result = count_users();
    if ($result['total_users'] > 500) {
        $wp_user_query = new WP_User_Query(array('number' => 200, 'orderby' => 'display_name', 'order' => 'desc', 'count_total' => true, 'role__not_in' => 'Subscriber'));
    } else {
        $wp_user_query = new WP_User_Query(array('number' => 500, 'orderby' => 'display_name', 'order' => 'desc', 'count_total' => true));
    }
    $users = $wp_user_query->get_results();

    // Create the dropdown HTML
    $output = "<select id=\"post_author_override\" name=\"post_author_override\" class=\"\">";
    if (is_array($users)) {
        foreach ($users as $user) {
            $sel = ($post->post_author == $user->ID) ? "selected='selected'" : '';
            $output .= '<option value="' . $user->ID . '" ' . $sel . '>' . $user->user_login . ' (' . count_user_posts($user->ID, 'listing_type') . ' listings)</option>';
        }
    }
    $output .= "</select>";

    return $output;
}
add_shortcode('custom_user_dropdown', 'custom_user_dropdown_shortcode');



add_action('wp_ajax_voi_search_live', 'handle_voi_search_live');
add_action('wp_ajax_nopriv_voi_search_live', 'handle_voi_search_live');

function handle_voi_search_live() {
  if (isset($_POST['search'])) {
        $ar = array('mylist' => array());

        if (is_numeric($_POST['search'])) {
            $args = array('post_type' => 'listing_type', 'paged' => 1, 'p' => $_POST['search']);
        } else {
            $args = array('posts_per_page' => 8, 'post_type' => 'listing_type', 'orderby' => 'name', 'order' => 'asc', 'paged' => 1, 's' => esc_html($_POST['search']));
        }

        // SOTRE SEARCH
        if (THEME_KEY == "cp") {
            $args = array(
                'taxonomy' => array('store'),
                'orderby' => 'id',
                'order' => 'ASC',
                'hide_empty' => true,
                'fields' => 'all',
                'name__like' => $_POST['search']
            );

            $terms = get_terms($args);
            $count = count($terms);
            if ($count > 0) {
                $stop = 0;
                foreach ($terms as $term) {
                    if ($stop > 8) {
                        continue;
                    }

                    $ar['mylist'][] = array(
                        'id' => $term->term_id,
                        'name' => $term->name,
                        'img' => do_shortcode('[STOREIMAGE id="' . $term->term_id . '"]'),
                        'link' => get_term_link($term),
                        'text' => "",
                    );

                    $stop++;
                }
            }
        }

        if (empty($ar['mylist'])) {
            $custom_query = new WP_Query($args);

            if ($custom_query->have_posts()) {
                while ($custom_query->have_posts()) {
                    $custom_query->the_post();

                    if (in_array($custom_query->post->post_type, array("post", "page"))) {
                        continue;
                    }

                    $name = get_the_title();
                    if (is_numeric($_POST['search'])) {
                        $name = get_the_title() . " (LOT " . $_POST['search'] . ")";
                    }

                    $ar['mylist'][] = array(
                        'id' => $custom_query->post->ID,
                        'name' => $name,
                        'img' => do_shortcode('[IMAGE post_id="' . $custom_query->post->ID . '" link=0 pathonly=1]'),
                        'link' => get_permalink($custom_query->post->ID),
                        'text' => "",
                    );
                }
            }
        }

        echo json_encode($ar);
        die();
    }
}





add_action('wp_ajax_get_escrow_entry_details', 'get_escrow_entry_details');
add_action('wp_ajax_nopriv_get_escrow_entry_details', 'get_escrow_entry_details');

function get_escrow_entry_details() 
{
    global $wpdb;

    // Get the current user object
    $current_user = wp_get_current_user();

    if (!$current_user || !$current_user->exists()) {
        wp_send_json_error('User not authenticated.');
        return;
    }

    // Get the user ID, email, and phone number
    $user_id = $current_user->ID;
    $user_email = $current_user->user_email;
    $user_phone = get_user_meta($user_id, 'phone', true);

    // Ensure `entry_id` and `form_id` are provided in the POST request
    if (!isset($_POST['entry_id']) || !isset($_POST['form_id'])) {
        wp_send_json_error('Entry ID or Form ID not provided.');
        return;
    }

    $entry_id = intval($_POST['entry_id']);
    $form_id = intval($_POST['form_id']);

    // Define table names
    $entries_table = $wpdb->prefix . 'frmt_form_entry';
    $meta_table = $wpdb->prefix . 'frmt_form_entry_meta';

    // Define meta keys for buyer and seller
    $buyer_email_meta_key = 'email-2';
    $buyer_phone_meta_key = 'phone-2';
    $seller_email_meta_key = 'email-1';
    $seller_phone_meta_key = 'phone-1';

    // Fetch form entry matching the provided criteria
    $entry = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT e.entry_id, e.date_created
             FROM $entries_table e
             JOIN $meta_table m ON e.entry_id = m.entry_id
             WHERE e.form_id = %d AND e.entry_id = %d
             AND (
                 (m.meta_key = 'escrow_deal_status' AND m.meta_value NOT IN ('closed', 'Finished')) 
                 OR m.meta_key != 'escrow_deal_status'
             )
             ORDER BY e.date_created ASC
             LIMIT 1",
            $form_id,
            $entry_id
        )
    );

    if (!$entry) {
        wp_send_json_error('Entry not found.');
        return;
    }

    // Fetch metadata for the entry
    $meta = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT meta_key, meta_value 
             FROM $meta_table 
             WHERE entry_id = %d",
            $entry->entry_id
        )
    );

    // Convert metadata results to an associative array for easy access
    $meta_data = [];
    foreach ($meta as $m) {
        $meta_data[$m->meta_key] = $m->meta_value;
    }

    // Fetch additional metadata using `get_post_meta`
    $entry_current_step = get_post_meta($entry_id, 'escrow_entry_current_step', true);
    $seller_entry_current_step = get_post_meta($entry_id, 'seller_escrow_entry_current_step', true);
    $escrow_delivery_info = get_post_meta($entry_id, 'delivery_escrow_info', true);
    $buyerPayment_info = get_post_meta($entry_id, 'buyerPayment_info', true);
    $lienHolder_info = get_post_meta($entry_id, 'lienHolder_info', true);
    $seller_payment_method = get_post_meta($entry_id, 'seller_payment_method', true);
    $buyer_payment_proof = get_post_meta($entry_id, 'payment_proof', true);
    $buyer_escrow_status = get_post_meta($entry_id, 'buyer_escrow_step_status', true);
    $seller_escrow_status = get_post_meta($entry_id, 'seller_escrow_step_status', true);
    $seller_escrow_bank_dp = get_post_meta($entry_id, 'seller_bank_dp_escrow_info', true);
    $escrow_carfax_lien_result = get_post_meta($entry_id, 'escrow_carfax_lien_result', true);

    // Fetch deal documents
    $documents_meta = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT meta_value 
             FROM $meta_table 
             WHERE entry_id = %d AND meta_key = %s",
            $entry->entry_id, 'deal_documents'
        )
    );
    $documents = maybe_unserialize($documents_meta);

    // Prepare response data
    $entry_details = [
        'entry_id' => $entry->entry_id,
        'date_created' => $entry->date_created,
        'meta' => $meta_data,
        'escrow_entry_current_step' => $entry_current_step,
        'seller_escrow_entry_current_step' => $seller_entry_current_step,
        'delivery_escrow_info' => $escrow_delivery_info,
        'buyerPayment_info' => $buyerPayment_info,
        'lienHolder_info' => $lienHolder_info,
        'seller_payment_method' => $seller_payment_method,
        'payment_proof' => $buyer_payment_proof,
        'buyer_escrow_status' => $buyer_escrow_status,
        'seller_escrow_status' => $seller_escrow_status,
        'seller_escrow_bank_dp' => $seller_escrow_bank_dp,
        'deal_document' => $documents,
        'escrow_carfax_lien_result' => $escrow_carfax_lien_result,
    ];

    wp_send_json_success($entry_details);
}






add_action('wp_ajax_get_admin_finance_details', 'get_admin_finance_details');
add_action('wp_ajax_nopriv_get_admin_finance_details', 'get_admin_finance_details');

function get_admin_finance_details() {
    global $wpdb;

    if (!isset($_POST['entry_id'])) {
        wp_send_json_error('Entry ID not provided.');
    }
    
    $entry_id = intval($_POST['entry_id']);
    $meta_key = 'hidden-3'; // Replace with your specific meta key

    // Define table names
    $entries_table = $wpdb->prefix . 'frmt_form_entry';
    $meta_table = $wpdb->prefix . 'frmt_form_entry_meta';

    // Fetch the entry
    $entry = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM $entries_table WHERE entry_id = %d",
            $entry_id
        )
    );

    if (!$entry) {
        wp_send_json_error('Entry not found.');
    }

    // Fetch metadata for the entry
    $meta = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT meta_key, meta_value FROM $meta_table WHERE entry_id = %d",
            $entry_id
        )
    );

    // Prepare metadata for easy access
    $meta_data = [];
    foreach ($meta as $m) {
        $meta_data[$m->meta_key] = $m->meta_value;
    }

    $documents_meta = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT meta_value FROM $meta_table WHERE entry_id = %d AND meta_key = %s",
            $entry_id, 'deal_documents'
        )
    );

    $documents = maybe_unserialize($documents_meta);

    
    
    
    $entry_current_step = get_post_meta($entry->entry_id, "entry_current_step", true);
    
     $finance_step_status = get_post_meta($entry->entry_id, "finance_step_status", true);
     
     $finance_pickup_info = get_post_meta($entry->entry_id, "finance_pickup_info", true);


     $entry_current_step = get_post_meta($entry_id, 'escrow_entry_current_step', true);
    $seller_entry_current_step = get_post_meta($entry_id, 'seller_escrow_entry_current_step', true);
    $escrow_delivery_info = get_post_meta($entry_id, 'delivery_escrow_info', true);
     $buyerPayment_info = get_post_meta($entry_id, 'buyerPayment_info', true);
    $lienHolder_info = get_post_meta($entry_id, 'lienHolder_info', true);
    $seller_payment_method = get_post_meta($entry_id, 'seller_payment_method', true);
    $buyer_payment_proof = get_post_meta($entry_id, 'payment_proof', true);
    $buyer_escrow_status = get_post_meta($entry_id, 'buyer_escrow_step_status', true);
    $seller_escrow_status = get_post_meta($entry_id, 'seller_escrow_step_status', true);
    $seller_escrow_bank_dp = get_post_meta($entry_id, 'seller_bank_dp_escrow_info', true);
    $escrow_carfax_lien_result = get_post_meta($entry_id, 'escrow_carfax_lien_result', true);

    $entry_details = [
        'entry_id' => $entry->entry_id,
        'date_created' => $entry->date_created,
        'meta' => $meta_data,
        'deal_document' => $documents,
        'entry_current_step' => $entry_current_step,
        'finance_step_status' => $finance_step_status,
        'finance_pickup_info' => $finance_pickup_info,
        'escrow_entry_current_step' => $entry_current_step,
        'seller_escrow_entry_current_step' => $seller_entry_current_step,
        'delivery_escrow_info' => $escrow_delivery_info,
        'buyerPayment_info' => $buyerPayment_info,
        'lienHolder_info' => $lienHolder_info,
        'seller_payment_method' => $seller_payment_method,
        'payment_proof' => $buyer_payment_proof,
        'buyer_escrow_status' => $buyer_escrow_status,
        'seller_escrow_status' => $seller_escrow_status,
        'seller_escrow_bank_dp' => $seller_escrow_bank_dp,
        'escrow_carfax_lien_result' => $escrow_carfax_lien_result,
    ];

    wp_send_json_success($entry_details);
}


add_action('wp_ajax_get_finance_entry', 'get_finance_entry');
add_action('wp_ajax_nopriv_get_finance_entry', 'get_finance_entry');

function get_finance_entry() {
    global $wpdb, $userdata, $finances;

    
$entry = $finances[0];

    $entry_id = $entry->entry_id;
                
               

                // Fetch metadata for the entry
                $meta = $wpdb->get_results(
                    $wpdb->prepare(
                        "SELECT meta_key, meta_value FROM {$wpdb->prefix}frmt_form_entry_meta WHERE entry_id = %d",
                        $entry_id
                    )
                );

                // Prepare metadata for easy access
                $meta_data = [];
                foreach ($meta as $m) {
                    $meta_data[$m->meta_key] = $m->meta_value;
                }


    // Fetch the entry_current_step directly
    $entry_current_step = get_post_meta($entry->entry_id, "entry_current_step", true);
    $seller_entry_current_step = get_post_meta($entry->entry_id, "seller_entry_current_step", true);
    
    $finance_step_status = get_post_meta($entry->entry_id, "finance_step_status", true);
    
    $finance_pickup_info = get_post_meta($entry->entry_id, "finance_pickup_info", true);

    // Prepare metadata for easy access
    

     $documents_meta = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT meta_value FROM $meta_table WHERE entry_id = %d AND meta_key = %s",
            $entry->entry_id, 'deal_documents'
        )
    );

    $documents = maybe_unserialize($documents_meta);

    $entry_details = [
        'entry_id' => $entry->entry_id,
        'date_created' => $entry->date_created,
        'meta' => $meta_data,
        'entry_current_step' => $entry_current_step,
        'seller_entry_current_step' => $seller_entry_current_step,
        'finance_step_status' => $finance_step_status,
        'finance_pickup_info' => $finance_pickup_info,
        'deal_document' => $documents,
    ];

    wp_send_json_success($entry_details);
}





add_action('wp_ajax_update_entry_step', 'update_entry_step');
add_action('wp_ajax_nopriv_update_entry_step', 'update_entry_step');

function update_entry_step() {
    global $wpdb;

    // Get the current user ID
    $user_id = get_current_user_id();

    // Check if the function is called from the admin area and if the 'eid' parameter is set
    if (is_admin() && isset($_GET['eid'])) {   
        $user_id = $_GET['eid'];
    }

    // Get POST parameters
    $form_id = intval($_POST['form_id']);
    $current_step = intval($_POST['current_step']);
    $entry_id = intval($_POST['entry_id']);
    $meta_key = sanitize_text_field($_POST['step_meta']);

    // Define table names
    $entries_table = $wpdb->prefix . 'frmt_form_entry';
    $meta_table = $wpdb->prefix . 'frmt_form_entry_meta';

    // Check if the entry exists for the given form_id and entry_id
    $entry_exists = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT e.entry_id, e.date_created 
             FROM $entries_table e
             JOIN $meta_table m ON e.entry_id = m.entry_id
             WHERE e.form_id = %d AND e.entry_id = %d",
            $form_id, $entry_id
        )
    );

    if ($entry_exists) {
        // Update the meta value
        update_post_meta($entry_id, $meta_key, $current_step);
        wp_send_json_success([$meta_key => $current_step]);
    } else {
        wp_send_json_error('Entry not found.');
    }
}

add_action('wp_ajax_delete_turbo_entry_from_server', 'delete_turbo_entry_from_server');
add_action('wp_ajax_nopriv_delete_turbo_entry_from_server', 'delete_turbo_entry_from_server');
function delete_turbo_entry_from_server() {
    global $wpdb;

    // Get POST parameters
    $form_id = intval($_POST['form_id']);
    $entry_id = intval($_POST['entry_id']);

    // Define table names
    $entries_table = $wpdb->prefix . 'frmt_form_entry';
    $meta_table = $wpdb->prefix . 'frmt_form_entry_meta';

    // Check if the entry exists for the given form_id and entry_id
    $entry_exists = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT entry_id 
             FROM $entries_table 
             WHERE form_id = %d AND entry_id = %d",
            $form_id, $entry_id
        )
    );

    if ($entry_exists) {
        // Delete the entry from the form entry table
        $wpdb->delete(
            $entries_table,
            array('entry_id' => $entry_id),
            array('%d')
        );

        // Delete any associated metadata
        $wpdb->delete(
            $meta_table,
            array('entry_id' => $entry_id),
            array('%d')
        );

        wp_send_json_success("Entry and its metadata deleted successfully.");
    } else {
        wp_send_json_error('Entry not found.');
    }
}




add_action('wp_ajax_add_additional_escrow_info', 'add_additional_escrow_info');
add_action('wp_ajax_nopriv_add_additional_escrow_info', 'add_additional_escrow_info');

function add_additional_escrow_info() {
    global $wpdb, $userdata;

    // Get the current user ID
    $user_id = get_current_user_id();

    // Check if the function is called from the admin area and if the 'eid' parameter is set
    if (is_admin() && isset($_GET['eid'])) {   
        $user_id = $_GET['eid'];
    }

    // Get POST parameters
    $form_id = intval($_POST['form_id']);
    $entry_id = intval($_POST['entry_id']);
    $meta_key = sanitize_text_field($_POST['data_meta']);
    $additional_info = json_decode(stripslashes($_POST['additional_info']), true);
    $form_name = sanitize_text_field($_POST['form_name']);
    $form_title = sanitize_text_field($_POST['form_title']);

    // Define table names
    $entries_table = $wpdb->prefix . 'frmt_form_entry';
    $meta_table = $wpdb->prefix . 'frmt_form_entry_meta';

    // Check if the entry exists for the given form_id and entry_id
    $entry_exists = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT e.entry_id, e.date_created 
             FROM $entries_table e
             JOIN $meta_table m ON e.entry_id = m.entry_id
             WHERE e.form_id = %d AND e.entry_id = %d",
            $form_id, $entry_id
        )
    );

    if ($entry_exists) {
    $uploaded_image_urls = [];

        // Check if files are uploaded
        if (!empty($_FILES['images'])) {
            $uploaded_images = $_FILES['images'];

            // Get WordPress upload directory
            $upload_dir = wp_upload_dir();

            foreach ($uploaded_images['tmp_name'] as $key => $tmp_name) {
                $file_name = $uploaded_images['name'][$key];
                $file_error = $uploaded_images['error'][$key];

                // Check for upload errors
                if ($file_error == 0) {
                    $upload_path = $upload_dir['path'] . '/' . $file_name;

                    // Move the uploaded file to the WordPress uploads directory
                    if (move_uploaded_file($tmp_name, $upload_path)) {
                        // Store the image URL
                        $image_url = $upload_dir['url'] . '/' . $file_name;
                        $uploaded_image_urls[] = $image_url;
                    }
                }
            }
        }
        
        if (!empty($uploaded_image_urls)) {
            $additional_info['bank_dp_images'] = $uploaded_image_urls;
        }
    
    
        // Update the meta value
        update_post_meta($entry_id, $meta_key, $additional_info);
        
        // Format the $additional_info to a message format (HTML)
        $Message = '<h2>' . $form_title . '</h2>';
        
        $Message .= '<p><strong>Escrow ID:</strong> ' . $entry_id . '</p>';
        
        if($_POST['vehicle_name']){
        $Message .= '<p><strong>Title: </strong> ' . $_POST['vehicle_name'] . '</p>';
        }
        
        if($_POST['vehicle_vin']){
        $Message .= '<p><strong>VIN: #</strong> ' . $_POST['vehicle_vin'] . '</p>';
        }
        
        if ($userdata->ID) {
            $Message .= '<p><strong>Updated By: </strong> ';

            if (!is_admin()) {
                if ($userdata->first_name !== '') {
                    $Message .= $userdata->first_name . ' ' . $userdata->last_name;
                } else {
                    $Message .= $userdata->username;
                }
            } else {
                $Message .= 'Admin';
            }

            $Message .= '</p>';
        }
        
        if($_POST['escrow_buyer_email']){
        $Message .= '<p><strong>Buyer Email: </strong> ' . $_POST['escrow_buyer_email'] . '</p>';
        }
        if($_POST['escrow_seller_email']){
        $Message .= '<p><strong>Seller Email: </strong> ' . $_POST['escrow_seller_email'] . '</p>';
        }
        foreach ($additional_info as $key => $value) {
            if ($key == 'bank_dp_images') {
                $Message .= '<p><strong>' . ucfirst($key) . ':</strong></p>';
                foreach ($value as $image_url) {
                    $Message .= '<img src="' . $image_url . '" alt="Bank DP Image" style="max-width: 200px;"><br>';
                }
            } else {
                $Message .= '<p><strong>' . ucfirst($key) . ':</strong> ' . $value . '</p>';
            }
        }

        // Insert the post
        $my_post = array(
            'post_title'   => $meta_key,
            'post_content' => $Message,
            'post_excerpt' => "",
            'post_status'  => "publish",
            'post_type'    => "ppt_message",
            'post_author'  => $user_id,
        );
        $POSTID = wp_insert_post($my_post);

        add_post_meta($POSTID, "reciever_id", $user_id);
        add_post_meta($POSTID, "sender_id", $user_id);
        add_post_meta($POSTID, $meta_key, 1);
        add_post_meta($POSTID, "msg_stick", "[" . $user_id . "][" . $user_id . "]");
        add_post_meta($POSTID, "msg_status", "unread_" . $user_id);

        // Log the action
        // Assuming the CORE->FUNC is defined elsewhere
        global $CORE;
        $CORE->FUNC(
            "add_log",
            array(
                "type" => "listing_message",
                "postid" => $entry_id,
                "to" => $user_id,
                "from" => $user_id,
                "from_name" => $form_name,
                "alert_uid1" => $user_id,
                "data" => $Message,
                "email_data" => array(
                    "message" => $Message,
                ),
            )
        );

        // Send email to Admin
        $admin_email = get_option('admin_email');
        wp_mail($admin_email, $form_title . " - " . date("F j, Y"), $Message);

        // Send email to specific email
        wp_mail('rancoded.it@gmail.com', $form_title . " - " . date("F j, Y"), $Message);
        
        if($_POST['escrow_seller_email']){
        wp_mail($_POST['escrow_seller_email'], $form_title . " - " . date("F j, Y"), $Message);
        }
        
        if($_POST['escrow_buyer_email']){
        wp_mail($_POST['escrow_buyer_email'], $form_title . " - " . date("F j, Y"), $Message);
        }
        
        wp_send_json_success([$meta_key => $additional_info]);
    } else {
        wp_send_json_error('Entry not found.');
    }
}



add_action('wp_ajax_add_additional_deal_info', 'add_additional_deal_info');
add_action('wp_ajax_nopriv_add_additional_deal_info', 'add_additional_deal_info');

function add_additional_deal_info() {
    global $wpdb, $userdata;

    // Get the current user ID
    $user_id = get_current_user_id();

    // Get POST parameters
    $form_id = intval($_POST['form_id']);
    $entry_id = intval($_POST['entry_id']);
    $meta_key = sanitize_text_field($_POST['data_meta']);
    $form_name = sanitize_text_field($_POST['form_name']);
    $form_title = sanitize_text_field($_POST['form_title']);

    // Define table names
    $entries_table = $wpdb->prefix . 'frmt_form_entry';
    $meta_table = $wpdb->prefix . 'frmt_form_entry_meta';

    // Check if the entry exists for the given form_id and entry_id
    $entry_exists = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT e.entry_id, e.date_created 
             FROM $entries_table e
             WHERE e.form_id = %d AND e.entry_id = %d",
            $form_id, $entry_id
        )
    );

    if ($entry_exists) {

        if($form_name == 'Approval Terms'){
            if($_POST['buyer_current_step']){
                 update_post_meta($entry_id, 'entry_current_step', $_POST['buyer_current_step']);
            }

            if($_POST['seller_current_step']){
                 update_post_meta($entry_id, 'seller_entry_current_step', $_POST['seller_current_step']);
            }
        }


        // Update the meta data in 'frmt_form_entry_meta'
        $meta_updates = [];

        $meta_fields = [
        'name-1', 'name-2','name-3', 'name-4', 'name-5', 'name-6','name-7', 'name-8', 'name-9', 'name-10','name-11', 'name-12', 'email-1','email-2', 'date-1', 'text-1', 'text-2', 'text-3', 'text-4', 'text-5','currency-1', 'currency-2', 'currency-3', 'currency-4', 'currency-5','currency-6','currency-7','currency-8','currency-9','currency-10','currency-11',
        'text-6', 'text-7', 'text-8', 'text-9', 'text-10', 'text-11', 'text-12', 'text-13', 'text-14', 'text-15', 'text-16', 'text-17', 'text-18', 'text-19', 'text-20', 'text-21', 'text-22', 'text-23', 'text-31', 'text-32','text-36','text-37','text-38', 'text-39','text-40','text-41','text-42','text-43','text-44','text-45','text-46',
        'text-55', 'text-52', 'text-57', 'text-53', 'text-56', 'text-57', 'text-58', 'text-59', 'text-60', 'text-61', 'text-62', 'text-63', 'text-64',  'text-67', 'text-65', 'text-66', 'text-68', 'text-69',  'phone-1', 'phone-2', 'phone-3', 'phone-4', 'phone-5','phone-6','phone-7',
        'select-1', 'select-2', 'select-3', 'select-4','select-7', 'select-8','select-9','select-10','select-11','select-12','select-13','select-14', 'radio-2', 'radio-3', 'radio-4', 'radio-5', 'radio-6','residenceTypeOption', 'employ-residence-type-option', 'previous-employer-position','KycRequest',
        'co-applicicant-first-name', 'co-applicicant-last-name', 'co-applicicant-dob', 'co-applicicant-street-address', 'gross-payment-frequency',
        'co-applicicant-city', 'co-applicicant-province', 'co-applicicant-postal-code', 'co-applicicant-residence-type',
        'co-applicicant-time-address', 'co-applicicant-monthly-payment', 'co-applicicant-mortgage-holder', 'co-applicicant-previous-address',
        'co-applicicant-previous-city', 'co-applicicant-previous-province', 'co-applicicant-previous-postal-code', 'co-applicicant-previous-email',
        'co-applicicant-previous-phone', 'co-applicicant-previous-secondary-phone', 'co-applicicant-previous-sin',
        'co-employment-employer', 'co-employment-employer-position', 'co-employment-employer-phone-number',
        'co-employment-employer-time-address', 'co-employment-employer-street-address', 'co-employment-employer-city',
        'co-employment-employer-province', 'co-employment-employer-postal-code', 'co-employment-employer-residence-type',
        'co-employment-employer-gross-monthly-income', 'co-employment-employer-previous-employer', 'co-employment-employer-previous-position',
        'co-employment-employer-previous-time', 'co-employment-employer-other-income',
        // Top section fields
        'topSectionVin', 'topSectionStocks', 'topSectionMileage', 'topSectionVehicleValue', 'topSectionPurchasePrice',
        'topSectionDownPayment', 'topSectionYear', 'topSectionMakeInput', 'topSectionModelInput', 'topSectionTrim',
        'topSectionColorInput', 'topSectionGasDieselHybrid',
        // Trade-in section fields
        'tradeInSectionVin', 'topTradeInSectionMileage', 'topTradeInSectionCurrentPrice', 'topTradeInSectionPurchasePrice',
        'topTradeInSectionYear', 'topTradeInSectionMakeInput', 'topTradeInSectionModelInput', 'topTradeInSectionTrim',
        'topTradeInSectionColorInput', 'topTradeInSectionGasDieselHybrid',
        // Warranty section fields
        'warrantySectionPrice1', 'warrantySectionPrice2', 'warrantySectionPrice3', 'warrantySectionPrice4','approvedAmount','lender','lenderType', 'approvalNoteTextarea','taskStatus', 
		'paymentAmountTerm','biWeeklyPaymentTerm','approvalTermTerm','interestRateTerm','paymentAmountTermTwo','biWeeklyPaymentTermTwo','approvalTermTermTwo','interestRateTermTwo','warrantyCost',
		'gaapInsurance', 'lifeInsurance','turboBidTransport','fundFirstName', 'fundLastName', 'fundMiddleName','fundingDate', 'paymentAmount', 'paymentMethod', 'transactionNumber', 'fundNotes',
		'nameOfRegisteredOwner','sellerRegisteredOwner', 'lienInformation', 'confirmedVehiclePriceVIN', 'institutionName',
        'institutionAddress', 'institutionNumber', 'transitNumber', 'accountName', 'accountNumber', 'selectedPayoutMethod', 'payoutAmount', 'transportCompany', 'phoneNumber','driver',
		'trackingNumber', 'isVehiclePicked', 'sellerPickupAddress', 'sellerPickupDate', 'sellerPickupTime', 'isRegisteredOwner', 'isAnyLiensVehicle', 'isVehicleBeingPicked', 'requestedPickupDate', 'locationOfVehicle',
		'confirmVehiclePurchase', 'dropoffDetails', 'sellerPayoutMethod', 'wireTransferAddress', 'wireTransferCity', 'wireTransferProvince', 'wireTransferCityPostalCode', 'hyperWalletPhoneNumber', 'hyperWalletEmail', 'middle-name',
        'buyerApprovedAmount', 'buyerApprovedLender', 'buyerApprovedLenderType', 'buyerApprovedPaymentFrequency', 'buyerApprovedWarrantyCost', 'buyerApprovedGAPInsurance', 'buyerApprovedLifeInsurance', 'buyerApprovedTurbobidTransport',
		'approvedMonthlyAmount', 'escrowOdometer', 'escrowWaiver', 'escrowNameReqOwner', 'isEscrowRegisteredOwner', 'isEscrowAnyLiensVehicle', 'isEscrowVehicleBeingPicked',
		'requestedEscrowPickupDate', 'confirmEscrowVehiclePurchase', 'buyer_veriff_status', 'seller_veriff_status', 'sellerSuggestedTimes', 'suggestedPrice'
        // Continue with other fields as needed
    ];


    // Loop through each field, check if it's set in $_POST, and sanitize it
    foreach ($meta_fields as $field) {
        if (isset($_POST[$field])) {
            $meta_updates[$field] = sanitize_text_field($_POST[$field]);
        }
    }



        foreach ($meta_updates as $meta_key => $meta_value) {
            // Check if the meta field exists for the given entry_id and meta_key
            $meta_exists = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT meta_id FROM $meta_table WHERE entry_id = %d AND meta_key = %s",
                    $entry_id, $meta_key
                )
            );

            if ($meta_exists) {
                // Update the existing meta value
                $wpdb->update(
                    $meta_table,
                    array('meta_value' => $meta_value), // New value
                    array('meta_id' => $meta_exists) // Where condition
                );
            } else {
                // Insert the new meta value if it doesn't exist
                $wpdb->insert(
                    $meta_table,
                    array(
                        'entry_id'   => $entry_id,
                        'meta_key'   => $meta_key,
                        'meta_value' => $meta_value
                    ),
                    array('%d', '%s', '%s')
                );
            }
        }

        // Handle file upload if available
        if (!empty($_FILES['documentProofFile'])) {
            $uploaded_file = $_FILES['documentProofFile'];

            // Get WordPress upload directory
            $upload_dir = wp_upload_dir();

            $file_name = $uploaded_file['name'];
            $file_tmp_name = $uploaded_file['tmp_name'];
            $file_error = $uploaded_file['error'];

            if ($file_error == 0) {
                $upload_path = $upload_dir['path'] . '/' . $file_name;
                $upload_url = $upload_dir['url'] . '/' . $file_name;

                // Move the file to the uploads directory
                if (move_uploaded_file($file_tmp_name, $upload_path)) {

                     $meta_exists = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT meta_id FROM $meta_table WHERE entry_id = %d AND meta_key = %s",
                    $entry_id, 'document_proof_file'
                )
            );

            if ($meta_exists) {
                // Update the existing meta value
                $wpdb->update(
                    $meta_table,
                    array('meta_value' => $upload_url), // New value
                    array('meta_id' => $meta_exists) // Where condition
                );
            } else {
                // Insert the new meta value if it doesn't exist
                $wpdb->insert(
                    $meta_table,
                    array(
                        'entry_id'   => $entry_id, 
                        'meta_key'   => 'document_proof_file',
                        'meta_value' => $upload_url
                    ),
                    array('%d', '%s', '%s')
                );
            }
                    // Store the uploaded file URL in user meta
                    // update_user_meta($user_id, 'document_proof_file', $upload_url);
                }
            }
        }

        // Prepare the success message
        $message = '<h2>' . esc_html($form_title) . '</h2>';
        $message .= '<p><strong>Deal ID:</strong> ' . esc_html($entry_id) . '</p>';
        if (!empty($_POST['name-1'])) {
            $message .= '<p><strong>First Name:</strong> ' . esc_html($_POST['name-1']) . '</p>';
        }
        if (!empty($upload_url)) {
            $message .= '<img src="' . esc_url($upload_url) . '" alt="Uploaded Image" style="max-width: 200px;"><br>';
        }

        // Send success response
        wp_send_json_success(array('message' => $message));

    } else {
        wp_send_json_error('Entry not found.');
    }
}



// Add AJAX action for logged-in users
add_action('wp_ajax_boldsign_request', 'handle_boldsign_request');

// Add AJAX action for non-logged-in users
add_action('wp_ajax_nopriv_boldsign_request', 'handle_boldsign_request');

function handle_boldsign_request() {
    // Check if the required POST data exists
    if (!isset($_POST['meta']) || !isset($_POST['uploadName'])) {
        wp_send_json_error(array('message' => 'Missing required data.'));
    }

    $meta = json_decode(stripslashes($_POST['meta']), true); // Decode JSON-encoded meta
    $uploadName = sanitize_text_field($_POST['uploadName']);

    // API Key and BoldSign URL
    $apiKey = 'X-API-KEY';
    $apiValue = 'NzZlZmE1NDctMmJiZS00OWEwLTg2YTEtYTJkZjA1ODM2NzFm';
    $apiUrl = 'https://api.boldsign.com/v1/document/createEmbeddedRequestUrl';

    // Prepare the data to send to BoldSign API
    $postData = array(
        'Title' => $uploadName,
        'ShowToolbar' => true,
        'ShowSaveButton' => true,
        'ShowSendButton' => true,
        'ShowPreviewButton' => true,
        'ShowNavigationButtons' => true,
        'SendViewOption' => 'FillingPage',
        'Locale' => 'EN',
        'ShowTooltip' => true,
        'Signers' => array(
            array(
                'Name' => sanitize_text_field(isset($meta['name-1']) ? $meta['name-1'] : $meta['email-1']) . ' ' . sanitize_text_field(isset($meta['name-2']) ? $meta['name-2'] : ""),
                'EmailAddress' => sanitize_email($meta['email-1']),
            ),
            array(
                'Name' => sanitize_text_field(isset($meta['name-3']) ? $meta['name-3'] : $meta['email-2']),
                'EmailAddress' => sanitize_email($meta['email-2']),
            )
        )
    );

    // Make the API request using wp_remote_post
    $response = wp_remote_post($apiUrl, array(
        'headers' => array(
            'X-API-KEY' => $apiValue,
            'Content-Type' => 'application/json'
        ),
        'body' => json_encode($postData),
        'method' => 'POST',
        'timeout' => 30,
    ));

    // Check for errors in the API request
    if (is_wp_error($response)) {
        wp_send_json_error(array('message' => 'Error connecting to BoldSign: ' . $response->get_error_message()));
    }

    // Parse and return the response
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    // Check if the API response contains the required data
    if (isset($data['documentId']) && isset($data['sendUrl'])) {
        wp_send_json_success($data); // Send back the document ID and send URL
    } else {
        wp_send_json_error(array('message' => 'Invalid response from BoldSign API.'));
    }

    // Always end AJAX handler with wp_die()
    wp_die();
}


// Add AJAX action for logged-in users
add_action('wp_ajax_boldsign_user_sign_link', 'handle_boldsign_user_sign_link');

// Add AJAX action for non-logged-in users
add_action('wp_ajax_nopriv_boldsign_user_sign_link', 'handle_boldsign_user_sign_link');

function handle_boldsign_user_sign_link() {
    // Check if the required POST data exists
    if (!isset($_POST['boldDocumentId']) || !isset($_POST['signerEmail'])) {
        wp_send_json_error(array('message' => 'Missing required data.'));
    }

   // Check if the required POST data exists
    if (!isset($_POST['boldDocumentId'])) {
        wp_send_json_error(array('message' => 'Missing required boldDocumentId parameter.'));
    }

    // Sanitize input
    $boldDocumentId = sanitize_text_field($_POST['boldDocumentId']);
    $signerEmail = sanitize_text_field($_POST['signerEmail']);

    // API Key and BoldSign URL
    $apiKey = 'X-API-KEY';
    $apiValue = 'NzZlZmE1NDctMmJiZS00OWEwLTg2YTEtYTJkZjA1ODM2NzFm';
    $apiUrl = 'https://api.boldsign.com/v1/document/getEmbeddedSignLink?documentId=' . rawurlencode($boldDocumentId) . '&signerEmail=' . rawurlencode($signerEmail);


    // Make the API request using wp_remote_get (since it's a GET request)
    $response = wp_remote_get($apiUrl, array(
        'headers' => array(
            'X-API-KEY' => $apiValue,
            'Content-Type' => 'application/json',
        ),
        'timeout' => 30,
    ));

    // Check for errors in the API request
    if (is_wp_error($response)) {
    wp_send_json_error(array('message' => 'Error connecting to BoldSign: ' . $response->get_error_message()));
} else {
    $body = wp_remote_retrieve_body($response);
    error_log('API Response Body: ' . $body);  // Log the response body
    $data = json_decode($body, true);

    if (isset($data['signLink'])) {
        wp_send_json_success($data);
    } else {
        wp_send_json_error(array('message' => 'Invalid response from BoldSign API.', 'response' => $data));
    }
    }

    // Always end AJAX handler with wp_die()
    wp_die();
}


// Add AJAX action for logged-in users
add_action('wp_ajax_boldsign_get_document_status', 'handle_boldsign_get_document_status');

// Add AJAX action for non-logged-in users
add_action('wp_ajax_nopriv_boldsign_get_document_status', 'handle_boldsign_get_document_status');



function handle_boldsign_get_document_status() {
    // Check if the required POST data exists
    if (!isset($_POST['boldDocumentId'])) {
        wp_send_json_error(array('message' => 'Missing required boldDocumentId parameter.'));
    }

    // Sanitize input
    $boldDocumentId = sanitize_text_field($_POST['boldDocumentId']);

    // API Key and BoldSign URL
    $apiKey = 'X-API-KEY';
    $apiValue = 'NzZlZmE1NDctMmJiZS00OWEwLTg2YTEtYTJkZjA1ODM2NzFm';
    $apiUrl = 'https://api.boldsign.com/v1/document/properties?documentId=' . $boldDocumentId;

    // Make the API request using wp_remote_get (since it's a GET request)
    $response = wp_remote_get($apiUrl, array(
        'headers' => array(
            'X-API-KEY' => $apiValue,
            'Content-Type' => 'application/json',
        ),
        'timeout' => 30,
    ));

    // Check for errors in the API request
    if (is_wp_error($response)) {
        wp_send_json_error(array('message' => 'Error connecting to BoldSign: ' . $response->get_error_message()));
    }

    // Parse and return the response
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    // Check if the API response contains the required data
    if (isset($data['status'])) {
        wp_send_json_success($data);
    } else {
        wp_send_json_error(array('message' => 'Invalid response from BoldSign API.'));
    }

    // Always end AJAX handler with wp_die()
    wp_die();
}



// Add AJAX action for logged-in users
add_action('wp_ajax_boldsign_get_document_download', 'handle_boldsign_get_document_download');

// Add AJAX action for non-logged-in users
add_action('wp_ajax_nopriv_boldsign_get_document_download', 'handle_boldsign_get_document_download');

function handle_boldsign_get_document_download() {
    if (!isset($_POST['boldDocumentId'])) {
        wp_send_json_error(array('message' => 'Missing required boldDocumentId parameter.'));
    }

    $boldDocumentId = sanitize_text_field($_POST['boldDocumentId']);
    $apiKey = 'X-API-KEY';
    $apiValue = 'NzZlZmE1NDctMmJiZS00OWEwLTg2YTEtYTJkZjA1ODM2NzFm';
    $apiUrl = 'https://api.boldsign.com/v1/document/download?documentId=' . $boldDocumentId;

    $response = wp_remote_get($apiUrl, array(
        'headers' => array(
            'X-API-KEY' => $apiValue,
            'Content-Type' => 'application/pdf',
        ),
        'timeout' => 30,
    ));

    if (is_wp_error($response)) {
        wp_send_json_error(array('message' => 'Error connecting to BoldSign: ' . $response->get_error_message()));
    }

    $pdf_content = wp_remote_retrieve_body($response);

    if (empty($pdf_content)) {
        wp_send_json_error(array('message' => 'Invalid response from BoldSign API.'));
    }

    // Encode PDF content in base64
    $base64_pdf = base64_encode($pdf_content);

    // Return the base64 PDF string
    wp_send_json_success(array('base64Pdf' => $base64_pdf));

    wp_die();
}







add_action('wp_ajax_submit_document_deal', 'submit_document_deal');
add_action('wp_ajax_nopriv_submit_document_deal', 'submit_document_deal');

function submit_document_deal() {
    global $wpdb, $userdata;

    // Get the current user ID
    $user_id = get_current_user_id();

    // Get POST parameters
    $form_id = intval($_POST['form_id']);
    $entry_id = intval($_POST['entry_id']);
    $meta_key = sanitize_text_field($_POST['data_meta']);
    $form_name = sanitize_text_field($_POST['form_name']);
    $form_title = sanitize_text_field($_POST['form_title']);

    // Define table names
    $entries_table = $wpdb->prefix . 'frmt_form_entry';
    $meta_table = $wpdb->prefix . 'frmt_form_entry_meta';

    // Check if the entry exists for the given form_id and entry_id
    $entry_exists = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT e.entry_id, e.date_created 
             FROM $entries_table e
             WHERE e.form_id = %d AND e.entry_id = %d",
            $form_id, $entry_id
        )
    );

    if ($entry_exists) {
        $uploaded_image_urls = [];

        // Check if files are uploaded
        if (!empty($_FILES['images'])) {
            $uploaded_images = $_FILES['images'];

            // Get WordPress upload directory
            $upload_dir = wp_upload_dir();

            foreach ($uploaded_images['tmp_name'] as $key => $tmp_name) {
                $file_name = $uploaded_images['name'][$key];
                $file_error = $uploaded_images['error'][$key];

                // Check for upload errors
                if ($file_error == 0) {
                    $upload_path = $upload_dir['path'] . '/' . $file_name;

                    // Move the uploaded file to the WordPress uploads directory
                    if (move_uploaded_file($tmp_name, $upload_path)) {
                        // Store the image URL
                        $image_url = $upload_dir['url'] . '/' . $file_name;
                        $uploaded_image_urls[] = $image_url;
                    }
                }
            }
        }

            // Retrieve any existing deal documents from meta
            $existing_documents = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT meta_value FROM $meta_table WHERE entry_id = %d AND meta_key = %s",
                    $entry_id, 'deal_documents'
                )
            );

            // Convert existing documents to array if found
            if ($existing_documents) {
                $existing_documents = maybe_unserialize($existing_documents);
            } else {
                $existing_documents = [];
            }

            // Create new document array
            $new_document = array(
                'doc_id' => sanitize_text_field($_POST['documentId']),
                'doc_name' => sanitize_text_field($_POST['documentName']),
                'doc_files' => $uploaded_image_urls,
                'document_is_complete' => 'completed',
                'templateId' => sanitize_text_field($_POST['templateId']),
                'templateUrl' => sanitize_text_field($_POST['templateUrl']),
                'createdAt' => current_time('mysql')
            );

            // Append new document to the existing array
            $existing_documents[] = $new_document;

            // Serialize the documents array for storage
            $documents_serialized = maybe_serialize($existing_documents);

            $meta_exists = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT meta_id FROM $meta_table WHERE entry_id = %d AND meta_key = %s",
                    $entry_id, 'deal_documents'
                )
            );

            if ($meta_exists) {
                // Update the existing meta value by appending the new documents
                $wpdb->update(
                    $meta_table,
                    array('meta_value' => $documents_serialized),
                    array('meta_id' => $meta_exists),
                    array('%s'), // Format of the updated data
                    array('%d')  // Format of the where condition
                );
            } else {
                // Insert new meta entry if it doesn't exist
                $wpdb->insert(
                    $meta_table,
                    array(
                        'entry_id'   => $entry_id,
                        'meta_key'   => 'deal_documents',
                        'meta_value' => $documents_serialized
                    ),
                    array('%d', '%s', '%s') // Format of the inserted data
                );
            }
        

        // Prepare the success message
        $message = 'Deal document submitted successfully';

        // Send success response
        wp_send_json_success(array('message' => $new_document));
    } else {
        wp_send_json_error('Entry not found.');
    }
}





add_action('wp_ajax_get_documents_from_server', 'get_documents_from_server');
add_action('wp_ajax_nopriv_get_documents_from_server', 'get_documents_from_server');
function get_documents_from_server() {
    global $wpdb;

    // Get POST parameters
    $form_id = intval($_POST['form_id']);
    $entry_id = intval($_POST['entry_id']);
    $doc_id = sanitize_text_field($_POST['documentId']);
    $doc_name = sanitize_text_field($_POST['documentName']);

    // Define table names
    $meta_table = $wpdb->prefix . 'frmt_form_entry_meta';

    // Query the database for the documents using form_id and entry_id
    $documents_meta = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT meta_value FROM $meta_table WHERE entry_id = %d AND meta_key = %s",
            $entry_id, 'deal_documents'
        )
    );

    if ($documents_meta) {
        // Unserialize the stored document data
        $documents = maybe_unserialize($documents_meta);

        // Filter the documents by doc_id and doc_name (if provided)
        $filtered_documents = array_filter($documents, function($doc) use ($doc_id, $doc_name) {
            return $doc['doc_id'] === $doc_id && $doc['doc_name'] === $doc_name;
        });

        // Check if any document matches the criteria
        if (!empty($filtered_documents)) {
            // Return the document details
            wp_send_json_success(array_values($filtered_documents)); // Return as JSON
        } else {
            wp_send_json_error('No document found with the given criteria.');
        }
    } else {
        wp_send_json_error('No documents found for the specified entry.');
    }
}



add_action('wp_ajax_delete_document_from_server', 'delete_document_from_server');
add_action('wp_ajax_nopriv_delete_document_from_server', 'delete_document_from_server');

function delete_document_from_server() {
    global $wpdb;

    $entry_id = intval($_POST['entry_id']);
    $doc_id = sanitize_text_field($_POST['doc_id']);
    $doc_name = sanitize_text_field($_POST['doc_name']);

    $meta_table = $wpdb->prefix . 'frmt_form_entry_meta';

    // Retrieve the existing meta value
    $documents_meta = $wpdb->get_var(
        $wpdb->prepare("SELECT meta_value FROM $meta_table WHERE entry_id = %d AND meta_key = %s", $entry_id, 'deal_documents')
    );

    if ($documents_meta) {
        $documents = maybe_unserialize($documents_meta);

        // Filter out the document to delete
        $documents = array_filter($documents, function($doc) use ($doc_id) {
            return $doc['doc_id'] !== $doc_id;
        });

        // Update the meta after removing the document
        $wpdb->update(
            $meta_table,
            array('meta_value' => maybe_serialize($documents)),
            array('entry_id' => $entry_id, 'meta_key' => 'deal_documents')
        );

        wp_send_json_success('Document deleted successfully.');
    } else {
        wp_send_json_error('Document not found.');
    }
}



add_action('wp_ajax_update_document_status', 'update_document_status');
add_action('wp_ajax_nopriv_update_document_status', 'update_document_status');
function update_document_status() {
    global $wpdb;

    $entry_id = intval($_POST['entry_id']);
    $doc_id = sanitize_text_field($_POST['doc_id']);
    $new_status = sanitize_text_field($_POST['document_is_complete']);

    $meta_table = $wpdb->prefix . 'frmt_form_entry_meta';

    // Retrieve the existing meta value
    $documents_meta = $wpdb->get_var(
        $wpdb->prepare("SELECT meta_value FROM $meta_table WHERE entry_id = %d AND meta_key = %s", $entry_id, 'deal_documents')
    );

    if ($documents_meta) {
        $documents = maybe_unserialize($documents_meta);

        // Update the document's status
        foreach ($documents as &$doc) {
            if ($doc['doc_id'] === $doc_id) {
                $doc['document_is_complete'] = $new_status;
                break;
            }
        }

        // Save the updated documents
        $wpdb->update(
            $meta_table,
            array('meta_value' => maybe_serialize($documents)),
            array('entry_id' => $entry_id, 'meta_key' => 'deal_documents')
        );

        wp_send_json_success('Document status updated successfully.');
    } else {
        wp_send_json_error('Document not found.');
    }
}




add_action('wp_ajax_upload_payment_proof', 'upload_payment_proof');
add_action('wp_ajax_nopriv_upload_payment_proof', 'upload_payment_proof');

function upload_payment_proof() {
    global $wpdb, $userdata;

    // Get the current user ID
    $user_id = get_current_user_id();

    // Check if the function is called from the admin area and if the 'eid' parameter is set
    if (is_admin() && isset($_GET['eid'])) {
        $user_id = $_GET['eid'];
    }

    // Get POST parameters
    $form_id = intval($_POST['form_id']);
    $entry_id = intval($_POST['entry_id']);
    $payment_meta_key = sanitize_text_field($_POST['payment_proof_meta']);
    $form_name = sanitize_text_field($_POST['form_name']);
    $form_title = sanitize_text_field($_POST['form_title']);
    $meta_key = sanitize_text_field($_POST['meta_key']);

    // Define table names
    $entries_table = $wpdb->prefix . 'frmt_form_entry';
    $meta_table = $wpdb->prefix . 'frmt_form_entry_meta';
    

    // Check if the entry exists for the given form_id and entry_id
    $entry_exists = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT e.entry_id, e.date_created 
             FROM $entries_table e
             JOIN $meta_table m ON e.entry_id = m.entry_id
             WHERE e.form_id = %d AND e.entry_id = %d",
            $form_id, $entry_id
        )
    );

    if ($entry_exists) {
        if (!empty($_FILES['images'])) {
            $uploaded_images = $_FILES['images'];
            $uploaded_image_urls = [];

            // Check if there are uploaded files
            if (!empty($uploaded_images['name'][0])) {
                $upload_dir = wp_upload_dir(); // Get WordPress upload directory

                foreach ($uploaded_images['tmp_name'] as $key => $tmp_name) {
                    $file_name = $uploaded_images['name'][$key];
                    $file_type = $uploaded_images['type'][$key];
                    $file_size = $uploaded_images['size'][$key];
                    $file_error = $uploaded_images['error'][$key];

                    // Check for upload errors
                    if ($file_error == 0) {
                        $upload_path = $upload_dir['path'] . '/' . $file_name;

                        // Move uploaded file to the WordPress uploads directory
                        if (move_uploaded_file($tmp_name, $upload_path)) {
                            // Store the image URL
                            $image_url = $upload_dir['url'] . '/' . $file_name;
                            $uploaded_image_urls[] = $image_url;
                        }
                    }
                }
            }

            if (!empty($uploaded_image_urls)) {
                update_post_meta($entry_id, $payment_meta_key, $uploaded_image_urls);
                
                // Format the $additional_info to a message format (HTML)
        $Message = '<h2>' . $form_title . '</h2>';
        
        $Message .= '<p><strong>Escrow ID:</strong> ' . $entry_id . '</p>';
        
        if($_POST['vehicle_name']){
        $Message .= '<p><strong>Title: </strong> ' . $_POST['vehicle_name'] . '</p>';
        }
        
        if($_POST['vehicle_vin']){
        $Message .= '<p><strong>VIN: #</strong> ' . $_POST['vehicle_vin'] . '</p>';
        }
        
        if ($userdata->ID) {
            $Message .= '<p><strong>Updated By: </strong> ';

            if (!is_admin()) {
                if ($userdata->first_name !== '') {
                    $Message .= $userdata->first_name . ' ' . $userdata->last_name;
                } else {
                    $Message .= $userdata->username;
                }
            } else {
                $Message .= 'Admin';
            }

            $Message .= '</p>';
        }
        
        
        if($_POST['escrow_buyer_email']){
        $Message .= '<p><strong>Buyer Email:</strong> ' . $_POST['escrow_buyer_email'] . '</p>';
        }
        if($_POST['escrow_seller_email']){
        $Message .= '<p><strong>Seller Email:</strong> ' . $_POST['escrow_seller_email'] . '</p>';
        }
        foreach ($uploaded_image_urls as $key => $image_url) {
        $Message .= '<img src="' . $image_url . '" alt="Payment proof image" style="max-width: 200px;"><br>';
    }

        // Insert the post
        $my_post = array(
            'post_title'   => $meta_key,
            'post_content' => $Message,
            'post_excerpt' => "",
            'post_status'  => "publish",
            'post_type'    => "ppt_message",
            'post_author'  => $user_id,
        );
        $POSTID = wp_insert_post($my_post);

        add_post_meta($POSTID, "reciever_id", $user_id);
        add_post_meta($POSTID, "sender_id", $user_id);
        add_post_meta($POSTID, $meta_key, 1);
        add_post_meta($POSTID, "msg_stick", "[" . $user_id . "][" . $user_id . "]");
        add_post_meta($POSTID, "msg_status", "unread_" . $user_id);

        // Log the action
        // Assuming the CORE->FUNC is defined elsewhere
        global $CORE;
        $CORE->FUNC(
            "add_log",
            array(
                "type" => "listing_message",
                "postid" => $entry_id,
                "to" => $user_id,
                "from" => $user_id,
                "from_name" => $form_name,
                "alert_uid1" => $user_id,
                "data" => $Message,
                "email_data" => array(
                    "message" => $Message,
                ),
            )
        );

        // Send email to Admin
        $admin_email = get_option('admin_email');
        wp_mail($admin_email, $form_title . " - " . date("F j, Y"), $Message);

        // Send email to specific email
        wp_mail('rancoded.it@gmail.com', $form_title . " - " . date("F j, Y"), $Message);
        
        if($_POST['escrow_seller_email']){
        wp_mail($_POST['escrow_seller_email'], $form_title . " - " . date("F j, Y"), $Message);
        }
        
        if($_POST['escrow_buyer_email']){
        wp_mail($_POST['escrow_buyer_email'], $form_title . " - " . date("F j, Y"), $Message);
        }
                
                wp_send_json_success([$payment_meta_key => $uploaded_image_urls]);
            } else {
                wp_send_json_error('No files were uploaded.');
            }
        } else {
            wp_send_json_error('No files were uploaded.');
        }
    } else {
        wp_send_json_error('Entry not found.');
    }
}









// Handle AJAX request to update user metadata
add_action('wp_ajax_handle_verification', 'handle_verification');
add_action('wp_ajax_nopriv_handle_verification', 'handle_verification');
function handle_verification() {
    if (isset($_POST['decision']) && isset($_POST['user_id'])) {
        $decision = $_POST['decision'];
        $user_id = intval($_POST['user_id']);

        // Update user metadata with verification decision
        update_user_meta($user_id, 'veriff_decision', $decision);

        $veriff_decision = get_user_meta($user_id, 'veriff_decision', true);
		if($veriff_decision){
        
        wp_send_json_success(['veriff_decision' => $veriff_decision]);
        
        }else{
        wp_send_json_success(['veriff_decision' => 'You need to verify']);
        }
        
    } else {
        echo 'Error: Missing parameters.';
    }
    wp_die();
}





// Function to get user meta by email via AJAX
function get_user_meta_by_email() {
    if (isset($_POST['user_email'])) {
        $user_email = sanitize_email($_POST['user_email']);

        // Get user by email
        $user = get_user_by('email', $user_email);

        if ($user) {
            $user_id = $user->ID;
            // Get the user meta value
            $veriff_decision = get_user_meta($user_id, 'veriff_decision', true);

            wp_send_json_success(array('veriff_decision' => $veriff_decision));
        } else {
            wp_send_json_error('User not found');
        }
    } else {
        wp_send_json_error('No email provided');
    }
}
add_action('wp_ajax_get_user_meta_by_email', 'get_user_meta_by_email');
add_action('wp_ajax_nopriv_get_user_meta_by_email', 'get_user_meta_by_email');




add_action('wp_ajax_submit_notes_for_deal', 'submit_notes_for_deal');
add_action('wp_ajax_nopriv_submit_notes_for_deal', 'submit_notes_for_deal');

function submit_notes_for_deal() {
    global $wpdb, $userdata;

    // Get the current user ID
    $user_id = get_current_user_id();

    // Sanitize and retrieve POST data
    $form_id = intval($_POST['form_id']);
    $entry_id = intval($_POST['entry_id']);
    $meta_key = sanitize_text_field($_POST['data_meta']);
    $form_name = sanitize_text_field($_POST['form_name']);
    $form_title = sanitize_text_field($_POST['form_title']);
    $note_text = wp_kses_post($_POST['note']);  // Allow HTML content
    $note_sender = sanitize_text_field($_POST['senderName']);

    // Define table names
    $entries_table = $wpdb->prefix . 'frmt_form_entry';
    $meta_table = $wpdb->prefix . 'frmt_form_entry_meta';

    // Check if the entry exists for the given form_id and entry_id
    $entry_exists = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT e.entry_id, e.date_created 
             FROM $entries_table e
             WHERE e.form_id = %d AND e.entry_id = %d",
            $form_id, $entry_id
        )
    );

    if ($entry_exists) {

        // Retrieve any existing deal documents from meta
        $existing_documents = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT meta_value FROM $meta_table WHERE entry_id = %d AND meta_key = %s",
                $entry_id, $meta_key
            )
        );

        // Convert existing documents to array if found
        if ($existing_documents) {
            $existing_documents = maybe_unserialize($existing_documents);
        } else {
            $existing_documents = [];
        }

        // Create new document array
        $new_document = array(
            'user_id' => $user_id,
            'note_id' => $user_id + $entry_id,
            'note' => $note_text,
            'task_status' => sanitize_text_field($_POST['taskStatus']),
            'note_submitter' => get_the_author_meta('display_name', $userdata->ID),
            'note_submitter_photo' => sanitize_text_field($_POST['userPhoto']),
            'note_applicant_name' => $note_sender,
            'note_submit_date' => date('F j, Y'),  // Use timestamp for accuracy
        );

        // Append new document to the existing array
        $existing_documents[] = $new_document;

        // Serialize the documents array for storage
        $documents_serialized = maybe_serialize($existing_documents);

        $meta_exists = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT meta_id FROM $meta_table WHERE entry_id = %d AND meta_key = %s",
                $entry_id, $meta_key
            )
        );

        if ($meta_exists) {
            // Update the existing meta value
            $wpdb->update(
                $meta_table,
                array('meta_value' => $documents_serialized),
                array('meta_id' => $meta_exists),
                array('%s'), 
                array('%d')  
            );
        } else {
            // Insert new meta entry if it doesn't exist
            $wpdb->insert(
                $meta_table,
                array(
                    'entry_id'   => $entry_id,
                    'meta_key'   => $meta_key,
                    'meta_value' => $documents_serialized
                ),
                array('%d', '%s', '%s')
            );
        }

        // Prepare the message content
        $Message = '<h2>' . $form_title . '</h2>';
        $Message .= '<p><strong>Deal ID:</strong> ' . $entry_id . '</p>';
        $Message .= '<p><strong>Applicant:</strong> ' . $note_sender . '</p>';
        
        if (!empty($_POST['vehicle_name'])) {
            $Message .= '<p><strong>Title: </strong> ' . sanitize_text_field($_POST['vehicle_name']) . '</p>';
        }
        
        if (!empty($_POST['vehicle_vin'])) {
            $Message .= '<p><strong>VIN: #</strong> ' . sanitize_text_field($_POST['vehicle_vin']) . '</p>';
        }

        if ($userdata->ID) {
            $Message .= '<p><strong>Updated By: </strong> ' . get_the_author_meta('display_name', $userdata->ID) . '</p>';
        }

        if (!empty($_POST['email'])) {
            $Message .= '<p><strong>Email: </strong> ' . sanitize_email($_POST['email']) . '</p>';
        }

        if (!empty($_POST['finance_seller_email'])) {
            $Message .= '<p><strong>Seller Email: </strong> ' . sanitize_email($_POST['finance_seller_email']) . '</p>';
        }

        $Message .= '<p><strong>Note:</strong> ' . $note_text . '</p>';

        // Create a WordPress post (optional step)
        $my_post = array(
            'post_title'   => $meta_key,
            'post_content' => $Message,
            'post_excerpt' => '',
            'post_status'  => 'publish',
            'post_type'    => 'ppt_message',
            'post_author'  => $user_id,
        );
        $POSTID = wp_insert_post($my_post);

        // Add post meta
        add_post_meta($POSTID, 'reciever_id', $user_id);
        add_post_meta($POSTID, 'sender_id', $user_id);

        // Log the action
        global $CORE;
        $CORE->FUNC(
            'add_log',
            array(
                'type' => 'deal_notes',
                'postid' => $entry_id,
                'to' => $user_id,
                'from' => $user_id,
                'from_name' => $form_name,
                'alert_uid1' => $user_id,
                'data' => $Message,
                'email_data' => array(
                    'message' => $Message,
                ),
            )
        );

        // Email the admin and other recipients
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $admin_email = get_option('admin_email');
        wp_mail($admin_email, $form_title . ' - ' . date('F j, Y'), $Message, $headers);
        wp_mail('rancoded.it@gmail.com', $form_title . ' - ' . date('F j, Y'), $Message, $headers);

        if (!empty($_POST['escrow_seller_email'])) {
            wp_mail(sanitize_email($_POST['escrow_seller_email']), $form_title . ' - ' . date('F j, Y'), $Message, $headers);
        }

        if (!empty($_POST['escrow_buyer_email'])) {
            wp_mail(sanitize_email($_POST['escrow_buyer_email']), $form_title . ' - ' . date('F j, Y'), $Message, $headers);
        }

        // Send success response
        wp_send_json_success('Note submitted successfully');
    } else {
        wp_send_json_error('Note cannot be submitted.');
    }
}



add_action('wp_ajax_get_deal_notes', 'get_deal_notes');
add_action('wp_ajax_nopriv_get_deal_notes', 'get_deal_notes');
function get_deal_notes() {
    global $wpdb, $userdata;

    // Get the current user ID
    $user_id = get_current_user_id();

    // Get POST parameters
    $form_id = intval($_POST['form_id']);
    $entry_id = intval($_POST['entry_id']);


    // Define table names
    $meta_table = $wpdb->prefix . 'frmt_form_entry_meta';

    // Query the database for the documents using form_id and entry_id
    $documents_meta = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT meta_value FROM $meta_table WHERE entry_id = %d AND meta_key = %s",
            $entry_id, 'deal_note_documents'
        )
    );

    if ($documents_meta) {
        // Unserialize the stored document data
        $documents = maybe_unserialize($documents_meta);
        // Check if any document matches the criteria
        if (!empty($documents)) {
            // Return the document details
            wp_send_json_success(array_values($documents)); // Return as JSON
        } else {
            wp_send_json_error('No notes found with the this deal.');
        }
    } else {
        wp_send_json_error('No notes found with the this deal.');
    }
}



add_action('wp_ajax_get_main_deals', 'get_main_deals');
add_action('wp_ajax_nopriv_get_main_deals', 'get_main_deals');
function get_main_deals() {
    global $wpdb;

    $form_id = intval($_POST['form_id']);

    // Define table names
    $entries_table = $wpdb->prefix . 'frmt_form_entry';
    $meta_table = $wpdb->prefix . 'frmt_form_entry_meta';

    // Fetch form entries for the specified form ID
    $entries = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT entry_id, date_created FROM $entries_table WHERE form_id = %d",
            $form_id
        )
    );

    // Initialize an array to hold all gated entries
    $gated_entries = [];

    // Loop through each entry
    foreach ($entries as $entry) {
        $entry_id = $entry->entry_id;
        $date_created = $entry->date_created;
        
        // finance
        // Retrieve the finance step status for each entry (if stored in post_meta)
        $finance_step_status = get_post_meta($entry_id, "finance_step_status", true);



        // escrow 
        $entry_current_step = get_post_meta($entry_id, "escrow_entry_current_step", true);
        
        // Fetch the entry_current_step directly
        $seller_entry_current_step = get_post_meta($entry_id, "seller_escrow_entry_current_step", true);
        
        $escrow_delivery_info = get_post_meta($entry_id, "delivery_escrow_info", true);
        
        $seller_payment_method = get_post_meta($entry_id, "seller_payment_method", true);
        
        $buyer_payment_proof = get_post_meta($entry_id, "payment_proof", true);

        $buyer_escrow_status = get_post_meta($entry_id, "buyer_escrow_step_status", true);

        $seller_escrow_status = get_post_meta($entry_id, "seller_escrow_step_status", true);

        $seller_escrow_bank_dp = get_post_meta($entry_id, "seller_bank_dp_escrow_info", true);
        

        // Fetch metadata for the entry
        $meta = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT meta_key, meta_value FROM $meta_table WHERE entry_id = %d",
                $entry_id
            )
        );

        // Prepare metadata for easy access
        $meta_data = [];
        foreach ($meta as $m) {
            $meta_data[$m->meta_key] = $m->meta_value;
        }

        // Add entry details including metadata to the gated_entries array
        $gated_entries[] = [
            'entry_id' => $entry_id,
            'date_created' => $date_created,
            'finance_step_status' => $finance_step_status,
            'buyer_escrow_entry_current_step' => $entry_current_step,
            'seller_escrow_entry_current_step' => $seller_entry_current_step,
            'delivery_escrow_info' => $escrow_delivery_info,
            'seller_payment_method' => $seller_payment_method,
            'payment_proof' => $buyer_payment_proof,
            'buyer_escrow_status' => $buyer_escrow_status,
            'seller_escrow_status' => $seller_escrow_status,
            'seller_escrow_bank_dp' => $seller_escrow_bank_dp,
            'meta_data' => $meta_data,
        ];
    }

    // Check if there are any entries and return the data as a JSON response
    if (!empty($gated_entries)) {
        wp_send_json_success($gated_entries);
    } else {
        wp_send_json_error('No deals found.');
    }
}


add_action('wp_ajax_get_deals_status_count', 'get_deals_status_count');
add_action('wp_ajax_nopriv_get_deals_status_count', 'get_deals_status_count');
function get_deals_status_count() {
    global $wpdb;

    $form_id = intval($_POST['form_id']);

    // Define table names
    $entries_table = $wpdb->prefix . 'frmt_form_entry';
    $meta_table = $wpdb->prefix . 'frmt_form_entry_meta';

    // Fetch form entries for the specified form ID
    $entries = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT entry_id, date_created FROM $entries_table WHERE form_id = %d",
            $form_id
        )
    );

    // Initialize counters for statuses and metadata
    $status_count = [
        'Awaiting' => 0,
        'Approved' => 0,
        'Paperwork' => 0,
        'Delivery' => 0,
        'Disbursement' => 0,
        'Delete' => 0,
        'Pending' => 0,
        'Cancelled' => 0,
        'Draft' => 0,
        'Completed' => 0,
        'Payment' => 0,
    ];

    $pickup_count = 0;
    $transport_count = 0;
    $kyc_verified = 0;
    $kyc_unverified = 0;

    // Loop through each entry
    foreach ($entries as $entry) {
        $entry_id = $entry->entry_id;

        // Retrieve the finance step status for each entry (if stored in post_meta)
        $finance_step_status = get_post_meta($entry_id, "finance_step_status", true);

        if (isset($finance_step_status['status'])) {
            // Increment the counter for the current status
            if (isset($status_count[$finance_step_status['status']])) {
                $status_count[$finance_step_status['status']]++;
            }

            if ($finance_step_status['step'] >= 3 && $finance_step_status['status'] === "Approved") {
                $kyc_verified++;
            }else{
                $kyc_unverified++;
            }

        }

        // Fetch metadata for the entry
        $meta = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT meta_key, meta_value FROM $meta_table WHERE entry_id = %d",
                $entry_id
            )
        );

        // Prepare metadata for easy access
        $meta_data = [];
        foreach ($meta as $m) {
            $meta_data[$m->meta_key] = $m->meta_value;
        }

        // Check and count specific metadata values for delivery
        if (isset($meta_data['delivery_pickup']) && $meta_data['delivery_pickup'] === 'Yes') {
            $pickup_count++;
        }

        if (isset($meta_data['delivery_transport']) && $meta_data['delivery_transport'] === 'Yes') {
            $transport_count++;
        }
    }

    // Prepare the result to send as a response
    $entries_status_result = [
        'status_counts' => $status_count,
        'pickup_count' => $pickup_count,
        'transport_count' => $transport_count,
    ];


    // Total Submissions
    $total_submissions = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*) FROM wp_frmt_form_entry WHERE form_id = %d",
            $form_id
        )
    );

    // Total Views
    $form_view = Forminator_Form_Views_Model::get_instance();
    $total_views = $form_view->count_views($form_id);

    // Conversion Rate
    $conversion_rate = $total_views > 0 ? round(($total_submissions / $total_views) * 100, 2) : 0;


    $pending_deal_tabs = array(
	1 => array(
		"name" => __("Conversion %","premiumpress"),
        "value" => $conversion_rate . " %",
        "views" => $total_views,
        "view_label" => __("Views on application"),
        "submit_count" => $total_submissions,
        "submit_label" => __("Submitted Application"),
		"icon" => home_url() . "/wp-content/uploads/2024/09/note-2.svg",
		"color" => "#FFBB38",
		"link" => "",
	),
    
    2 => array(
	
		"name" => __("Awaiting Decision","premiumpress"),
        "value" => $status_count['Awaiting'],
        "decision" => $status_count['Awaiting'],
        "decision_label" => __("Applicant Decision pending"),
		"icon" => home_url() . "/wp-content/uploads/2024/09/send-2.svg",
		"color" => "#FFBB38",
		"link" => "",
	),
    
    3 => array(
	
		"name" => __("KYC Verification","premiumpress"),
        "value" => $kyc_verified,
        "pending_kyc" => $kyc_unverified,
        "pending_kyc_label" => __("Pending KYC"),
        "completed_kyc" => $kyc_unverified,
        "completed_kyc_label" => __("Completed KYC"),
		"icon" => home_url() . "/wp-content/uploads/2024/09/graph.svg",
		"color" => "#FFBB38",
		"link" => "",
	),
    
    
    
    4 => array(
	
		"name" => __("Paperwork","premiumpress"),
        "value" => $status_count['Paperwork'],
        "pending_paperwork" => $status_count['Paperwork'],
        "pending_paperwork_label" => __("Pending Paperwork"),
		"icon" => home_url() . "/wp-content/uploads/2024/09/chart-2.svg",
		"color" => "#FFBB38",
		"link" => "",
	),
    
     5 => array(
		"name" => __("Delivery","premiumpress"),
		 "value" =>  $status_count['Delivery'],
        "vehicle_pick" =>  $pickup_count,
        "vehicle_pick_label" => __("Vehicle Pick Up"),
        "vehicle_transport" => $transport_count,
        "vehicle_transport_label" => __("Trbo Swift Transport"),
		"icon" =>  home_url() ."/wp-content/uploads/2024/09/danger.svg",
		"color" => "#FFBB38",
		"link" => "",
	),
    
    6 => array(
		"name" => __("Disbursal","premiumpress"),
		 "value" => $status_count['Disbursal'],
        "disbursal_pick_label" => __("Deals Disbursed"),
		"icon" => home_url() . "/wp-content/uploads/2024/09/danger.svg",
		"color" => "#FFBB38",
		"link" => "",
	),
    7 => array(
        "name" => __("Declined Applications","premiumpress"),
		 "value" =>  $status_count['Delete'],
        "bank_rejected" => 0,
        "bank_rejected_label" => __("Bank Rejected"),
        "customer_rejected" => 0,
        "customer_rejected_label" => __("Customer Rejected"),
		"icon" => home_url() ."/wp-content/uploads/2024/09/danger.svg",
		"color" => "#FFBB38",
		"link" => "",
      )
);

    // Check if there are any entries and return the data as a JSON response
    if (!empty($entries)) {
        wp_send_json_success(array_values($pending_deal_tabs));
    } else {
        wp_send_json_error('No deals found.');
    }
}


add_action('wp_ajax_get_escrow_status_count', 'get_escrow_status_count');
add_action('wp_ajax_nopriv_get_escrow_status_count', 'get_escrow_status_count');
function get_escrow_status_count() {
    global $wpdb;

    $form_id = intval($_POST['form_id']);

    // Define table names
    $entries_table = $wpdb->prefix . 'frmt_form_entry';
    $meta_table = $wpdb->prefix . 'frmt_form_entry_meta';

    // Fetch form entries for the specified form ID
    $entries = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT entry_id, date_created FROM $entries_table WHERE form_id = %d",
            $form_id
        )
    );

    // Initialize counters for statuses and metadata
    $status_count = [
        'Awaiting' => 0,
        'Approved' => 0,
        'Paperwork' => 0,
        'Delivery' => 0,
        'Disbursement' => 0,
        'Delete' => 0,
        'Pending' => 0,
        'Cancelled' => 0,
        'Draft' => 0,
        'Completed' => 0,
        'Payment' => 0,
    ];

    $pickup_count = 0;
    $transport_count = 0;
    $kyc_verified = 0;
    $kyc_unverified = 0;

    // Loop through each entry
    foreach ($entries as $entry) {
        $entry_id = $entry->entry_id;

        // Retrieve the finance step status for each entry (if stored in post_meta)
        $finance_step_status = get_post_meta($entry_id, "finance_step_status", true);

        if (isset($finance_step_status['status'])) {
            // Increment the counter for the current status
            if (isset($status_count[$finance_step_status['status']])) {
                $status_count[$finance_step_status['status']]++;
            }

            if ($finance_step_status['step'] >= 3 && $finance_step_status['status'] === "Approved") {
                $kyc_verified++;
            }else{
                $kyc_unverified++;
            }

        }

        // Fetch metadata for the entry
        $meta = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT meta_key, meta_value FROM $meta_table WHERE entry_id = %d",
                $entry_id
            )
        );

        // Prepare metadata for easy access
        $meta_data = [];
        foreach ($meta as $m) {
            $meta_data[$m->meta_key] = $m->meta_value;
        }

        // Check and count specific metadata values for delivery
        if (isset($meta_data['delivery_pickup']) && $meta_data['delivery_pickup'] === 'Yes') {
            $pickup_count++;
        }

        if (isset($meta_data['delivery_transport']) && $meta_data['delivery_transport'] === 'Yes') {
            $transport_count++;
        }
    }

    // Prepare the result to send as a response
    $entries_status_result = [
        'status_counts' => $status_count,
        'pickup_count' => $pickup_count,
        'transport_count' => $transport_count,
    ];


    // Total Submissions
    $total_submissions = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*) FROM wp_frmt_form_entry WHERE form_id = %d",
            $form_id
        )
    );

    // Total Views
    $form_view = Forminator_Form_Views_Model::get_instance();
    $total_views = $form_view->count_views($form_id);

    // Conversion Rate
    $conversion_rate = $total_views > 0 ? round(($total_submissions / $total_views) * 100, 2) : 0;



    $pending_deal_tabs = array(
	1 => array(
		"name" => __("Conversion %","premiumpress"),
        "value" => $conversion_rate . " %",
        "views" => $total_views,
        "view_label" => __("Views on application"),
        "submit_count" => $total_submissions,
        "submit_label" => __("Submitted Application"),
		"icon" => home_url() . "/wp-content/uploads/2024/09/note-2.svg",
		"color" => "#FFBB38",
		"link" => "",
	),
    
    2 => array(
	
		"name" => __("Agreement","premiumpress"),
        "value" => $status_count['Awaiting'],
        "decision" => $status_count['Awaiting'],
        "decision_label" => __("Applicant Decision pending"),
		"icon" => home_url() . "/wp-content/uploads/2024/09/send-2.svg",
		"color" => "#FFBB38",
		"link" => "",
	),
    
    3 => array(
	
		"name" => __("Payment","premiumpress"),
        "value" => $kyc_verified,
        "pending_kyc" => $kyc_unverified,
        "pending_kyc_label" => __("Payment Verification"),
        "completed_kyc" => $kyc_unverified,
        "completed_kyc_label" => __("Payment Processed"),
		"icon" => home_url() . "/wp-content/uploads/2024/09/graph.svg",
		"color" => "#FFBB38",
		"link" => "",
	),
    
    
    
    4 => array(
	
		"name" => __("Vehicle Verification","premiumpress"),
        "value" => $status_count['Paperwork'],
        "pending_paperwork" => $status_count['Paperwork'],
        "pending_paperwork_label" => __("Number of Vehicle Verified"),
		"icon" => home_url() . "/wp-content/uploads/2024/09/chart-2.svg",
		"color" => "#FFBB38",
		"link" => "",
	),
    
     5 => array(
		"name" => __("Delivery","premiumpress"),
		 "value" =>  $status_count['Delivery'],
        "vehicle_pick" =>  $pickup_count,
        "vehicle_pick_label" => __("Vehicle Pick Up"),
        "vehicle_transport" => $transport_count,
        "vehicle_transport_label" => __("Trbo Swift Transport"),
		"icon" => home_url() . "/wp-content/uploads/2024/09/danger.svg",
		"color" => "#FFBB38",
		"link" => "",
	),
    
    6 => array(
		"name" => __("Seller Inspection","premiumpress"),
		 "value" => $status_count['Disbursal'],
        "disbursal_pick_label" => __("# of Inspections Completed"),
		"icon" => home_url() . "/wp-content/uploads/2024/09/danger.svg",
		"color" => "#FFBB38",
		"link" => "",
	),
    7 => array(
        "name" => __("Disbursement","premiumpress"),
		 "value" =>  $status_count['Delete'],
        "bank_rejected" => 0,
        "bank_rejected_label" => __("Bank Rejected"),
        "customer_rejected" => 0,
        "customer_rejected_label" => __("Deals Disbursed"),
		"icon" => home_url() . "/wp-content/uploads/2024/09/danger.svg",
		"color" => "#FFBB38",
		"link" => "",
      )
);

    // Check if there are any entries and return the data as a JSON response
    if (!empty($entries)) {
        wp_send_json_success(array_values($pending_deal_tabs));
    } else {
        wp_send_json_error('No deals found.');
    }
}




// Enqueue your custom script
wp_localize_script('my-custom-script', 'my_ajax_obj', array(
    'ajax_url' => admin_url('admin-ajax.php'),
    'otp_nonce' => wp_create_nonce('otp_user_nonce')
));



add_action('wp_ajax_nopriv_check_have_user_by_phone', 'check_have_user_by_phone');
add_action('wp_ajax_nopriv_check_have_user_by_phone', 'check_have_user_by_phone');
function check_have_user_by_phone() {
    // Verify nonce
    if (!check_ajax_referer('otp_user_nonce', 'nonce', false)) {
        wp_send_json_error(array('message' => 'Nonce verification failed.'));
        wp_die();
    }

    // Validate phone number
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    if (empty($phone)) {
        wp_send_json_error(array('message' => 'Phone number is missing.'));
        wp_die();
    }

    // Query user by phone meta
    $user_query = new WP_User_Query(array(
        'meta_key'   => 'phone',
        'meta_value' => $phone,
        'number'     => 1,
        'count_total' => false,
    ));
    $users = $user_query->get_results();
    $user = !empty($users) ? $users[0] : null;

    if ($user) {
        wp_set_auth_cookie($user->ID);
        wp_send_json_success(array('redirect_url' => home_url(), 'user_type' => 'old'));
    } else {
        wp_send_json_error(array('message' => 'No user found.'));
    }

    wp_die();
}




add_action('wp_ajax_nopriv_otp_register_login_user', 'otp_register_login_user');
function otp_register_login_user() {
    check_ajax_referer('otp_user_nonce', 'nonce');

    $phone = sanitize_text_field($_POST['phone']);

    // Find user by phone meta
    $user_query = new WP_User_Query(array(
        'meta_key'   => 'phone',
        'meta_value' => $phone,
        'number'     => 1,
        'count_total' => false,
    ));
    $users = $user_query->get_results();
    $user = !empty($users) ? $users[0] : null;

    if ($user) {
        // User exists, log them in
        wp_set_auth_cookie($user->ID);
        wp_send_json_success(array('redirect_url' => home_url()));
    } else {
        // Register the user and add phone as user meta
        $random_password = wp_generate_password(12, false);
        $user_id = wp_create_user($phone, $random_password, $phone . '@trboswift.com'); // Example email for unique email

        if (is_wp_error($user_id)) {
            wp_send_json_error(array('message' => 'Registration failed: ' . $user_id->get_error_message()));
        } else {
            // Add phone to user meta
            update_user_meta($user_id, 'phone', $phone);

            // Log in the new user
            wp_set_auth_cookie($user_id);
            wp_send_json_success(array('redirect_url' => home_url()));
        }
    }
    wp_die();
}





add_action('wp_ajax_application_otp__after_register_user', 'application_otp__after_register_user');
add_action('wp_ajax_nopriv_application_otp__after_register_user', 'application_otp__after_register_user');

function application_otp__after_register_user() {
    global $wpdb;

    $phone = sanitize_text_field($_POST['phone']);
    $email = sanitize_email($_POST['email']);
    $f_name = sanitize_text_field($_POST['f_name']);
    $l_name = sanitize_text_field($_POST['l_name']);
    $isBuyer = filter_var($_POST['is_buyer'], FILTER_VALIDATE_BOOLEAN);

    // Get the currently logged-in user
    $current_user = wp_get_current_user();

    // Find user by phone or email
    $user_query = new WP_User_Query(array(
        'number' => 1,
        'count_total' => false,
        'meta_query' => array(
            'relation' => 'OR',
            array('key' => 'phone', 'value' => $phone, 'compare' => '='),
            array('key' => 'email', 'value' => $email, 'compare' => '=')
        )
    ));

    $users = $user_query->get_results();
    $user = !empty($users) ? $users[0] : null;

    // Check if the found user is the same as the logged-in user
    if ($current_user->ID && $current_user->ID !== $user->ID) {
            // Log out the current user if it's different from the matched user
            if ($isBuyer) {
                wp_send_json_success(array('applicant_type' => 'buyer', 'redirect_url' => home_url()));
                wp_logout();
            }
           
            exit();
    }

    if ($user) {
        

        // Log in the found user
        if ($isBuyer) {
            wp_set_auth_cookie($user->ID);
            update_user_meta($user->ID, 'applicant_type', 'buyer');
            wp_send_json_success(array('applicant_type' => 'buyer', 'redirect_url' => home_url()));
        } else {
            wp_send_json_success(array('applicant_type' => 'seller', 'redirect_url' => home_url()));
        }
    } else {
        // Register a new user if no match was found
        $username = ($f_name || $l_name) ? trim($f_name . ' ' . $l_name) : $phone;
        $random_password = wp_generate_password(12, false);
        $user_email = $email ? $email : $phone . '@example.com';
        $user_id = wp_create_user($username, $random_password, $user_email);

        if (is_wp_error($user_id)) {
            wp_send_json_error(array('message' => 'Registration failed: ' . $user_id->get_error_message()));
        } else {
            // Update user meta
            update_user_meta($user_id, 'phone', $phone);
            update_user_meta($user_id, 'otp_verified', 'true');
            if ($f_name) update_user_meta($user_id, 'first_name', $f_name);
            if ($l_name) update_user_meta($user_id, 'last_name', $l_name);

            // Set buyer or seller type
            if ($isBuyer) {
                wp_set_auth_cookie($user_id);
                update_user_meta($user_id, 'applicant_type', 'buyer');
                wp_send_json_success(array('applicant_type' => 'buyer', 'redirect_url' => home_url()));
            } else {
                wp_send_json_success(array('applicant_type' => 'seller', 'redirect_url' => home_url()));
            }
        }
    }

    wp_die();
}




function proxy_superapp_token_request() {
    $url = 'https://urlgen.inspektlabs.com/superappToken';
    $args = array(
        'method' => 'POST',
        'headers' => array(
            'Content-Type' => 'application/json',
        ),
        'body' => file_get_contents('php://input'), // Forward the incoming request body
    );

    $response = wp_remote_post($url, $args);

    if (is_wp_error($response)) {
        wp_send_json_error(array('message' => $response->get_error_message()));
    } else {
        wp_send_json_success(wp_remote_retrieve_body($response));
    }
}

add_action('wp_ajax_generate_superapp_token', 'proxy_superapp_token_request');
add_action('wp_ajax_nopriv_generate_superapp_token', 'proxy_superapp_token_request');




function register_turbo_inspection_cpt() {
    register_post_type('turbo-inspection', array(
        'labels' => array(
            'name' => 'Turbo Inspections',
            'singular_name' => 'Turbo Inspection',
        ),
        'public' => true,
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'custom-fields'),
    ));
}
add_action('init', 'register_turbo_inspection_cpt');


function register_turbo_inspection_meta() {
    register_meta('post', '_case_id', array(
        'type'         => 'string',
        'description'  => 'Case ID',
        'single'       => true,
        'show_in_rest' => true,
    ));
    register_meta('post', '_vendor', array(
        'type'         => 'string',
        'description'  => 'Vendor',
        'single'       => true,
        'show_in_rest' => true,
    ));
    register_meta('post', '_upload_status', array(
        'type'         => 'string',
        'description'  => 'Upload Status',
        'single'       => true,
        'show_in_rest' => true,
    ));
    register_meta('post', '_vehicle_type', array(
        'type'         => 'string',
        'description'  => 'Vehicle Type',
        'single'       => true,
        'show_in_rest' => true,
    ));
    register_meta('post', '_all_inspection_result', array(
        'type'         => 'array',
        'description'  => 'All inspection result',
        'single'       => true,
        'show_in_rest' => true,
    ));
    register_meta('post', '_pdf_inspection_result', array(
        'type'         => 'string',
        'description'  => 'PDF inspection result',
        'single'       => true,
        'show_in_rest' => true,
    ));
}
add_action('init', 'register_turbo_inspection_meta');



add_filter('rest_url_prefix', function () {
    return 'rancoded-json';
});


function turbo_inspection_register_rest_routes() {
    $namespace = 'api/v1';

    // inspection api routes 

    register_rest_route($namespace, '/submit-inspection-result', array(
        'methods' => 'POST',
        'callback' => 'custom_create_post',
        'permission_callback' => '__return_true', // Allows access without authentication
    ));

    register_rest_route($namespace, '/turbo-inspection/(?P<id>\d+)', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'turbo_inspection_get_post',
        'permission_callback' => '__return_true',
    ));

    register_rest_route($namespace, '/caseid-inspection', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'turbo_inspection_get_post_by_case_id',
        'args'     => array(
            'case_id' => array(
                'required' => true,
                'validate_callback' => function ($param, $request, $key) {
                    return is_string($param);
                },
            ),
        ),
        'permission_callback' => '__return_true',
    ));

    register_rest_route($namespace, '/turbo-inspection/(?P<id>\d+)', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'turbo_inspection_update_post',
        'permission_callback' => '__return_true',
    ));

    register_rest_route($namespace, '/turbo-inspection/(?P<id>\d+)', array(
        'methods' => WP_REST_Server::DELETABLE,
        'callback' => 'turbo_inspection_delete_post',
        'permission_callback' => '__return_true',
    ));


    // transport api routes


     register_rest_route($namespace, '/submit-transport-request', array(
        'methods' => 'POST',
        'callback' => 'create_transport_post',
        'permission_callback' => '__return_true', // Allows access without authentication
    ));

    register_rest_route($namespace, '/turbo-transport/(?P<id>\d+)', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'turbo_transport_get_post',
        'permission_callback' => '__return_true',
    ));

    register_rest_route($namespace, '/caseid-transport', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'turbo_transport_get_post_by_case_id',
        'args'     => array(
            'transport_case_id' => array(
                'required' => true,
                'validate_callback' => function ($param, $request, $key) {
                    return is_string($param);
                },
            ),
        ),
        'permission_callback' => '__return_true',
    ));

    register_rest_route($namespace, '/get-transports', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'turbo_transport_get_all_post',
        'permission_callback' => '__return_true',
    ));

    register_rest_route($namespace, '/turbo-transport/(?P<id>\d+)', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'turbo_transport_update_post',
        'permission_callback' => '__return_true',
    ));
    register_rest_route($namespace, '/turbo-transport-note/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'turbo_transport_note_post',
        'permission_callback' => '__return_true',
    ));
    register_rest_route($namespace, '/turbo-transport-note/(?P<id>\d+)', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'turbo_transport_note_get',
        'permission_callback' => '__return_true',
    ));
    register_rest_route($namespace, '/turbo-transport-status/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'turbo_transport_delivery_status_post',
        'permission_callback' => '__return_true',
    ));
    register_rest_route($namespace, '/turbo-transport-status/(?P<id>\d+)', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'turbo_transport_delivery_status_get',
        'permission_callback' => '__return_true',
    ));
    register_rest_route($namespace, '/turbo-driver-current-address/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'turbo_transport_transport_driver_current_location',
        'permission_callback' => '__return_true',
    ));
    register_rest_route($namespace, '/turbo-transport-driver/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'turbo_transport_transportDriver_post',
        'permission_callback' => '__return_true',
    ));
    register_rest_route($namespace, '/turbo-transport-driver/(?P<id>\d+)', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'turbo_transport_transportDriver_get',
        'permission_callback' => '__return_true',
    ));

    register_rest_route($namespace, '/turbo-transport/(?P<id>\d+)', array(
        'methods' => WP_REST_Server::DELETABLE,
        'callback' => 'turbo_transport_delete_post',
        'permission_callback' => '__return_true',
    ));


    //User Id Based post get data

    register_rest_route($namespace, '/turbo-transport-towing/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'turbo_transport_towing_partner_post',
        'permission_callback' => '__return_true',
    ));
    register_rest_route($namespace, '/turbo-transport-towing/(?P<id>\d+)', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'turbo_transport_towing_partner_get',
        'permission_callback' => '__return_true',
    ));
    register_rest_route($namespace, '/turbo-transport-tow-company/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'turbo_transport_tow_company_post',
        'permission_callback' => '__return_true',
    ));
    register_rest_route($namespace, '/turbo-transport-tow-company/(?P<id>\d+)', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'turbo_transport_tow_company_get',
        'permission_callback' => '__return_true',
    ));


    //car fax api routes
     register_rest_route($namespace, '/lien-report', array(
        'methods' => 'POST',
        'callback'            => 'fetch_carfax_lien_report',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'turbo_inspection_register_rest_routes');



function custom_create_post(WP_REST_Request $request) {
    // Extract and encode request parameters for post_content
    $post_content = json_encode($request->get_params(), JSON_PRETTY_PRINT);

    // Create the post
    $post_id = wp_insert_post([
        'post_title'   => $request['inspectionId'],
        'post_content' => $post_content, // Store the JSON string as post_content
        'post_status'  => 'publish',
        'post_type'    => 'turbo-inspection',
    ]);

    // Check if post creation was successful
    if (is_wp_error($post_id)) {
        return new WP_REST_Response([
            'error' => $post_id->get_error_message()
        ], 500);
    }

    // Decode the JSON string back into an associative array
    $post_content_array = json_decode($post_content, true);

        // Save additional meta fields
        update_post_meta($post_id, '_case_id', $post_content_array['caseId'] ?? '');
        update_post_meta($post_id, '_vendor', $post_content_array['vendor'] ?? '');
        update_post_meta($post_id, '_version', $post_content_array['version'] ?? '');
        update_post_meta($post_id, '_upload_status', $post_content_array['uploadStatus'] ?? '');
        update_post_meta($post_id, '_vehicle_type', $post_content_array['vehicleType'] ?? '');
        update_post_meta($post_id, '_pdf_inspection_result', $post_content_array['pdfInspectionResult'] ?? '');
        update_post_meta($post_id, '_all_inspection_result', $post_content_array); // Save the full array
    

        if (!update_post_meta($post_id, 'case_id', $post_content_array['caseId'] ?? '')) {
            error_log('Failed to save case_id for post ID: ' . $post_id);
        }


    // Return success response
    return new WP_REST_Response([
        'success' => true,
        'message' => 'Successfully submitted inspection result',
        'post_id' => $post_id,
        'result' => $post_content_array // Include the decoded array in the response
    ], 200);
}


function turbo_inspection_get_post_by_case_id($request) {
    $case_id = $request->get_param('case_id');

    if (!$case_id) {
        return new WP_Error('invalid_case_id', 'Case ID is required.', array('status' => 400));
    }

    // Query posts with the specified case_id
    $query = new WP_Query(array(
        'post_type'  => 'turbo-inspection',
        'meta_key'   => '_case_id',
        'meta_value' => $case_id,
    ));

    if (!$query->have_posts()) {
        return new WP_Error('post_not_found', 'No post found with this Case ID.', array('status' => 404));
    }

    // Format the response
    $posts = array();
    foreach ($query->posts as $post) {
        $posts[] = array(
            'id'                  => $post->ID,
            'title'               => $post->post_title,
            'case_id' => get_post_meta($post->ID, '_case_id', true),
            'pdf_inspection_result' => get_post_meta($post->ID, '_pdf_inspection_result', true),
            'all_inspection_result' => get_post_meta($post->ID, '_all_inspection_result', true),
        );
    }

    return rest_ensure_response($posts);
}

function turbo_inspection_get_post($request) {
    $id = $request->get_param('id');
    $post = get_post($id);

    if (!$post || $post->post_type !== 'turbo-inspection') {
        return new WP_Error('post_not_found', 'Post not found.', array('status' => 404));
    }

    return rest_ensure_response(array(
        'id' => $post->ID,
        'title' => $post->post_title,
        'content' => $post,
    ));
}

function turbo_inspection_update_post($request) {
    $id = $request->get_param('id');
    $data = $request->get_json_params();

    $post = get_post($id);

    if (!$post || $post->post_type !== 'turbo-inspection') {
        return new WP_Error('post_not_found', 'Post not found.', array('status' => 404));
    }

    $post_id = wp_update_post(array(
        'ID' => $id,
        'post_title' => sanitize_text_field($data['title'] ?? $post->post_title),
        'post_content' => sanitize_textarea_field($data['content'] ?? $post->post_content),
    ));

    if (is_wp_error($post_id)) {
        return new WP_Error('post_update_failed', 'Failed to update post.', array('status' => 500));
    }

    return rest_ensure_response(array(
        'id' => $id,
        'status' => 'success',
        'message' => 'Turbo Inspection updated successfully.',
    ));
}

function turbo_inspection_delete_post($request) {
    $id = $request->get_param('id');

    $post = get_post($id);

    if (!$post || $post->post_type !== 'turbo-inspection') {
        return new WP_Error('post_not_found', 'Post not found.', array('status' => 404));
    }

    $deleted = wp_delete_post($id);

    if (!$deleted) {
        return new WP_Error('post_delete_failed', 'Failed to delete post.', array('status' => 500));
    }

    return rest_ensure_response(array(
        'id' => $id,
        'status' => 'success',
        'message' => 'Turbo Inspection deleted successfully.',
    ));
}




// transport 

function register_turbo_transport_cpt() {
    register_post_type('turbo-transport', array(
        'labels' => array(
            'name'          => 'Turbo Transports',
            'singular_name' => 'Turbo Transport',
        ),
        'public'       => true,
        'show_in_rest' => true,
        'supports'     => array('title', 'editor', 'custom-fields'),
    ));
}
add_action('init', 'register_turbo_transport_cpt');



function register_turbo_transport_meta() {
    $meta_fields = array(
        'transport_case_id'              => 'string',
        'transportId'           => 'string',
        'transportPriority'              => 'string',
        'vehicleName'           => 'string',
        'transportDate'                  => 'string',
        'transportPickup'                => 'string',
        'transportDestination'           => 'array',
        'transportVIN'                   => 'string',
        'transportFee'                   => 'string',
        'transportStatus'                => 'string',
        'transportReferral'              => 'string',
        'transportSender'                => 'array',
        'transportReceiver'              => 'array',
        'transportDriver'                => 'array',
        'transportPickupLocation'       => 'array',
        'transportDestinationLocation'  => 'array',
        'transportCurrentGooglelocation' => 'array',
        'transportDistance'             => 'string',
        'transportAwaitingPickup'       => 'string',
        'transportOnRoute'              => 'string',
        'transportPickupTime'           => 'string',
        'transportDeliveryTime'         => 'string',
        'transportDeliveryStatus'       => 'array',
        'transportDeliveryCompleted'    => 'string',
        'transportNotes'                 => 'array',
        'towingPartner'                 => 'array',
    );

    foreach ($meta_fields as $meta_key => $type) {
        register_meta('post', $meta_key, array(
            'type'         => $type,
            'description'  => $meta_key,
            'single'       => true,
            'show_in_rest' => true,
        ));
    }
}
add_action('init', 'register_turbo_transport_meta');





function create_transport_post(WP_REST_Request $request) {
    $post_content = json_encode($request->get_params(), JSON_PRETTY_PRINT);

    $post_id = wp_insert_post(array(
        'post_title'   => $request['transportId'],
        'post_content' => $post_content,
        'post_status'  => 'publish',
        'post_type'    => 'turbo-transport',
    ));

    if (is_wp_error($post_id)) {
        return new WP_REST_Response(array('error' => $post_id->get_error_message()), 500);
    }

    $post_content_array = json_decode($post_content, true);

    foreach ($post_content_array as $key => $value) {
    // Check if the value is supposed to be an array
    if (in_array($key, array("transportSender","transportReceiver", "transportPickupLocation",
        "transportDestinationLocation", "transportCurrentGooglelocation", "transportDriver", "transportDeliveryStatus", "transportNotes")) && $value === "") {
        $value = []; // Convert empty string to an empty array
    }

    if (in_array($key, array(
        "transport_case_id",
        "transportId",
        "transportPriority",
        "vehicleName",
        "transportDate",
        "transportPickup",
        "transportDestination",
        "transportVIN",
        "transportFee",
        "transportStatus",
        "transportReferral",
        "transportSender",
        "transportReceiver",
        "transportDriver",
        "transportPickupLocation",
        "transportDestinationLocation",
        "currentAddress",
        "transportDistance",
        "transportCurrentGooglelocation",
        "transportAwaitingPickup",
        "transportOnRoute",
        "transportPickupTime",
        "transportDeliveryTime",
        "transportDeliveryStatus",
        "carTypeCard",
        "transportNotes"
    ))) {
        update_post_meta($post_id, $key, $value);
    }
}


    return new WP_REST_Response(array(
        'success' => true,
        'message' => 'Successfully submitted transport',
        'post_id' => $post_id,
        'result'  => $post_content_array,
    ), 200);
}


function turbo_transport_get_post_by_case_id($request) {
    $case_id = $request->get_param('transport_case_id');

    if (!$case_id) {
        return new WP_Error('invalid_case_id', 'Case ID is required.', array('status' => 400));
    }

    // Query posts with the specified case_id
    $query = new WP_Query(array(
        'post_type'  => 'turbo-transport',
        'meta_key'   => 'transport_case_id',
        'meta_value' => $case_id,
    ));

    if (!$query->have_posts()) {
        return rest_ensure_response(array(
        'post_not_found'    => 'No post found with this Case ID.',
        'status' => 404,
    ));
    }

    // Format the response
    $posts = array();
    foreach ($query->posts as $post) {
        // Get the meta keys
        $meta_keys = array(
        "transport_case_id",
        "transportId",
        "transportPriority",
        "vehicleName",
        "transportDate",
        "transportPickup",
        "transportDestination",
        "transportVIN",
        "transportFee",
        "transportStatus",
        "transportReferral",
        "transportSender",
        "transportReceiver",
        "transportDriver",
        "transportPickupLocation",
        "transportDestinationLocation",
        "transportDistance",
        "currentAddress",
        "transportCurrentGooglelocation",
        "transportAwaitingPickup",
        "transportOnRoute",
        "transportPickupTime",
        "transportDeliveryTime",
        "transportDeliveryStatus",
        "transportDeliveryCompleted",
        "transportNotes"
        );

        // Retrieve meta data for the keys
    $meta_data = array();
    foreach ($meta_keys as $key) {
        $meta_value = get_post_meta($post->ID, $key, true);

        // Check if the value is JSON and decode it
        if (is_string($meta_value) && is_array(json_decode($meta_value, true))) {
            $meta_value = json_decode($meta_value, true);
        }

        // Check if the value is serialized and unserialize it
        if (is_serialized($meta_value)) {
            $meta_value = unserialize($meta_value);
        }

        $meta_data[$key] = $meta_value;
    }

        $posts[] = array(
            'id'    => $post->ID,
            'title' => $post->post_title,
            'meta'  => $meta_data, // Include all meta keys and values
        );
    }

      return rest_ensure_response(array(
        'id'    => $post->ID,
        'title' => $post->post_title,
        'meta'  => $meta_data,
    ));
}


function turbo_transport_get_post($request) {
    $id = $request->get_param('id');
    $post = get_post($id);

    if (!$post || $post->post_type !== 'turbo-transport') {
        return new WP_Error('post_not_found', 'Post not found.', array('status' => 404));
    }

    $meta_keys = array(
        "transport_case_id",
        "transportId",
        "transportPriority",
        "vehicleName",
        "transportDate",
        "transportPickup",
        "transportDestination",
        "transportVIN",
        "transportFee",
        "transportStatus",
        "transportReferral",
        "transportSender",
        "transportReceiver",
        "transportDriver",
        "transportPickupLocation",
        "transportDestinationLocation",
        "transportDistance",
        "currentAddress",
        "transportCurrentGooglelocation",
        "transportAwaitingPickup",
        "transportOnRoute",
        "transportPickupTime",
        "transportDeliveryTime",
        "transportDeliveryStatus",
        "transportDeliveryCompleted",
        "transportNotes"
    );

    // Retrieve meta data for the keys
    $meta_data = array();
    foreach ($meta_keys as $key) {
        $meta_value = get_post_meta($post->ID, $key, true);

        // Check if the value is JSON and decode it
        if (is_string($meta_value) && is_array(json_decode($meta_value, true))) {
            $meta_value = json_decode($meta_value, true);
        }

        // Check if the value is serialized and unserialize it
        if (is_serialized($meta_value)) {
            $meta_value = unserialize($meta_value);
        }

        $meta_data[$key] = $meta_value;
    }

    return rest_ensure_response(array(
        'id'    => $post->ID,
        'title' => $post->post_title,
        'meta'  => $meta_data,
    ));
}


function turbo_transport_get_all_post($request) {
    // Extract query parameters from the request
    $query_params = $request->get_params();
    
    // Set up default arguments for the query
    $args = array(
        'post_type'      => 'turbo-transport',
        'posts_per_page' => -1, // Retrieve all posts by default
        'orderby'        => 'ID',
        'order'          => 'DESC',
    );

    // Add meta_query if specific key and value are provided
    if (!empty($query_params['key']) && !empty($query_params['value'])) {
        $args['meta_query'] = array(
            array(
                'key'   => sanitize_text_field($query_params['key']),
                'value' => sanitize_text_field($query_params['value']),
                'compare' => 'LIKE' // Adjust this based on your needs
            )
        );
    }

    // Perform the query
    $query = new WP_Query($args);
    $posts = $query->get_posts();

    if (empty($posts)) {
        return rest_ensure_response(array(
            'status'  => 'no_results',
            'message' => 'No transport records found.',
        ));
    }

    // Define the meta keys to retrieve
    $meta_keys = array(
        "transport_case_id",
        "transportId",
        "transportPriority",
        "vehicleName",
        "carTypeCard",
        "transportDate",
        "transportPickup",
        "transportDestination",
        "transportVIN",
        "transportFee",
        "transportStatus",
        "transportReferral",
        "transportSender",
        "transportReceiver",
        "transportDriver",
        "transportPickupLocation",
        "currentAddress",
        "transportDestinationLocation",
        "transportDistance",
        "transportCurrentGooglelocation",
        "transportAwaitingPickup",
        "transportOnRoute",
        "transportPickupTime",
        "transportDeliveryTime",
        "transportDeliveryStatus",
        "transportDeliveryCompleted",
        "transportNotes"
    );

    // Prepare response data
    $response = array();
    foreach ($posts as $post) {
        $meta_data = array();
        foreach ($meta_keys as $key) {
            $meta_value = get_post_meta($post->ID, $key, true);

            // Check if the value is JSON and decode it
            if (is_string($meta_value) && is_array(json_decode($meta_value, true))) {
                $meta_value = json_decode($meta_value, true);
            }

            // Include meta data in the response
            $meta_data[$key] = $meta_value;
        }

        $response[] = array(
            'id'      => $post->ID,
            'title'   => $post->post_title,
            'publish' => $post->post_date,
            'meta'    => $meta_data,
        );
    }

    return rest_ensure_response(array(
        'status' => 'success',
        'data'   => $response,
    ));
}




function turbo_transport_update_post($request) {
    $id = $request->get_param('id');
    $data = $request->get_json_params();

    // Validate and fetch the post
    $post = get_post($id);
    if (!$post || $post->post_type !== 'turbo-transport') {
        return new WP_Error('post_not_found', 'Post not found or invalid post type.', array('status' => 404));
    }

    $post_id = $post->ID;

    // Update the post content (if provided)
    if (!empty($data['post_content'])) {
        $updated_post_content = json_encode($data, JSON_PRETTY_PRINT);
        wp_update_post(array(
            'ID'           => $post_id,
            'post_content' => $updated_post_content,
        ));
    }

    // Update meta fields
    $allowed_meta_keys = array(
        "transport_case_id",
        "transportId",
        "transportPriority",
        "vehicleName",
        "transportDate",
        "transportPickup",
        "transportDestination",
        "transportVIN",
        "transportFee",
        "transportStatus",
        "transportReferral",
        "transportSender",
        "transportReceiver",
        "transportDriver",
        "transportPickupLocation",
        "transportDestinationLocation",
        "transportDistance",
        "currentAddress",
        "transportCurrentGooglelocation",
        "transportAwaitingPickup",
        "transportOnRoute",
        "transportPickupTime",
        "transportDeliveryTime",
        "transportDeliveryStatus",
        "transportDeliveryCompleted",
        "transportNotes"
    );

    foreach ($allowed_meta_keys as $key) {
        if (isset($data[$key])) {
            update_post_meta($post_id, $key, $data[$key]);
        }
    }

    // Confirm if post and meta fields were updated successfully
    if (is_wp_error($post_id)) {
        return new WP_Error('post_update_failed', 'Failed to update post or meta fields.', array('status' => 500));
    }

    return rest_ensure_response(array(
        'id'      => $post_id,
        'status'  => 'success',
        'message' => 'Turbo Transport updated successfully.',
        'updated_meta' => $data // Include the updated data in the response
    ));
}
function turbo_transport_note_post($request) {
    $id = $request->get_param('id');
    $data = $request->get_json_params();

    // Validate and fetch the post
    $post = get_post($id);
    if (!$post || $post->post_type !== 'turbo-transport') {
        return new WP_Error('post_not_found', 'Post not found or invalid post type.', array('status' => 404));
    }

    $post_id = $post->ID;

    // Fetch existing transport notes from meta
    $existing_notes = get_post_meta($post_id, 'transportNotes', true);
    if (!is_array($existing_notes)) {
        $existing_notes = maybe_unserialize($existing_notes); // Unserialize if needed
        if (!is_array($existing_notes)) {
            $existing_notes = []; // Initialize as an empty array
        }
    }

    // Validate input data for the new note
    if (empty($data['note_text'])) {
        return new WP_Error('invalid_note', 'Note text is required.', array('status' => 400));
    }

    // Create new note entry
    $new_note = array(
        'id'                    => uniqid('nt_', true),
        'note'            => sanitize_text_field($data['note_text']),
        'task_status'     => isset($data['task_status']) ? sanitize_text_field($data['task_status']) : 'Pending',
        'note_submitter'  => isset($data['note_submitter']) ? sanitize_text_field($data['note_submitter']) : 'Anonymous',
        'note_submit_date' => date('Y-m-d H:i:s'), // Use a standard date-time format
    );

    // Append new note to the existing notes
    $existing_notes[] = $new_note;

    // Serialize and save updated notes back to the meta field
    $notes_serialized = maybe_unserialize($existing_notes);
    update_post_meta($post_id, 'transportNotes', $notes_serialized);

    // Confirm successful update
    return rest_ensure_response(array(
        'id'           => $post_id,
        'status'       => 'success',
        'message'      => 'Turbo Transport note added successfully.',
        'transportNotes' => $existing_notes, // Return the updated notes array
    ));
}


function turbo_transport_note_get($request) {
    $id = $request->get_param('id');
    $data = $request->get_json_params();

    // Validate and fetch the post
    $post = get_post($id);
    if (!$post || $post->post_type !== 'turbo-transport') {
        return new WP_Error('post_not_found', 'Post not found or invalid post type.', array('status' => 404));
    }

    $post_id = $post->ID;

    // Fetch existing transport notes from meta
    $existing_notes = get_post_meta($post_id, 'transportNotes', true);
    if ($existing_notes) {
        $existing_notes = maybe_unserialize($existing_notes);
    } else if($existing_notes == '"[]"' || !$existing_notes){
        $existing_notes = []; // Initialize as an empty array if no notes exist
    }
    // Confirm successful update
    return rest_ensure_response($existing_notes);
}



function turbo_transport_delivery_status_post($request) {
    $id = $request->get_param('id');
    $data = $request->get_json_params();

    // Validate and fetch the post
    $post = get_post($id);
    if (!$post || $post->post_type !== 'turbo-transport') {
        return new WP_Error('post_not_found', 'Post not found or invalid post type.', ['status' => 404]);
    }

    $post_id = $post->ID;

    // Fetch existing transport statuses from meta
    $existing_statuses = get_post_meta($post_id, 'transportDeliveryStatus', true);

    // Check and normalize to an array
    if (!is_array($existing_statuses)) {
        // Attempt to unserialize the value
        $existing_statuses = maybe_unserialize($existing_statuses);
        
        // If still not an array, set it as an empty array
        if (!is_array($existing_statuses)) {
            $existing_statuses = [];
        }
    }

    // Normalize data further if needed (optional)
    $existing_statuses = array_filter($existing_statuses, function ($item) {
        // Ensure each item is a valid associative array
        return is_array($item) && isset($item['status_name']);
    });

    if (empty($existing_statuses)) {
        $existing_statuses = []; // Default to an empty array
    }


    // Validate input data
    if (empty($data['transportStatus'])) {
        return new WP_Error('invalid_status', 'Transport status is required.', ['status' => 400]);
    }

    // Create a new status entry
    $new_status = [
        'id'                => uniqid('st_', true),
        'status_name'       => sanitize_text_field($data['transportStatus']),
        'status_submitter'  => isset($data['status_submitter']) ? sanitize_text_field($data['status_submitter']) : 'Anonymous',
        'status_submit_date'=> date('Y-m-d H:i:s'), // Use a standard date-time format
    ];

    // Append the new status to the existing statuses
    $existing_statuses[] = $new_status;

    // Update the transport statuses meta field
    update_post_meta($post_id, 'transportDeliveryStatus', $existing_statuses);

    // Update the transport's main status if provided
    if (!empty($data['transportStatus'])) {
        update_post_meta($post_id, 'transportStatus', sanitize_text_field($data['transportStatus']));
    }

    // Confirm successful update
    return rest_ensure_response([
        'id'                    => $post_id,
        'status'                => 'success',
        'message'               => 'Turbo Transport Delivery Status added successfully.',
        'transportDeliveryStatus'=> $existing_statuses, // Return the updated statuses array
    ]);
}



function turbo_transport_delivery_status_get($request) {
    $id = $request->get_param('id');
    $data = $request->get_json_params();

    // Validate and fetch the post
    $post = get_post($id);
    if (!$post || $post->post_type !== 'turbo-transport') {
        return new WP_Error('post_not_found', 'Post not found or invalid post type.', array('status' => 404));
    }

    $post_id = $post->ID;

    // Fetch existing transport statuss from meta
    $existing_statuss = get_post_meta($post_id, 'transportDeliveryStatus', true);
    if ($existing_statuss) {
        $existing_statuss = maybe_unserialize($existing_statuss);
    } else {
        $existing_statuss = []; // Initialize as an empty array if no statuss exist
    }
    // Confirm successful update
    return rest_ensure_response($existing_statuss);
}


function turbo_transport_transport_driver_current_location($request) {
    $id = $request->get_param('id');
    $data = $request->get_json_params();

    // Validate and fetch the post
    $post = get_post($id);
    if (!$post || $post->post_type !== 'turbo-transport') {
        return new WP_Error('post_not_found', 'Post not found or invalid post type.', array('status' => 404));
    }

    $post_id = $post->ID;

     // Validate input data for the new status
    if (empty($data['currentAddress'])) {
        return new WP_Error('invalid_status', 'Current address is required.', array('status' => 400));
    }

    // Fetch existing transport statuss from meta
    $existing_address = get_post_meta($post_id, 'transportCurrentGooglelocation', true);
    if (!is_array($existing_address)) {
        $existing_address = maybe_unserialize($existing_address); // Unserialize if needed
        if (!is_array($existing_address)) {
            $existing_address = []; // Initialize as an empty array
        }
    }

    if($data['transportCurrentGooglelocation']){
        $existing_address[] = $data['transportCurrentGooglelocation'];
        update_post_meta($post_id, 'transportCurrentGooglelocation', $existing_address);
    }
    if($data['currentAddress']){
        update_post_meta($post_id, 'currentAddress', sanitize_text_field($data['currentAddress']));
    }

    // Confirm successful update
    return rest_ensure_response(array(
        'id'           => $post_id,
        'status'       => 'success',
        'message'      => 'Turbo Transport driver current address added successfully.',
    ));
}

function turbo_transport_transportDriver_post($request) {
    $id = $request->get_param('id');
    $data = $request->get_json_params();

    // Validate and fetch the post
    $post = get_post($id);
    if (!$post || $post->post_type !== 'turbo-transport') {
        return new WP_Error('post_not_found', 'Post not found or invalid post type.', array('status' => 404));
    }

    $post_id = $post->ID;

    $existing_statuss = [];
    

    $existing_statuses = get_post_meta($post_id, 'transportDriver', true);

    // Check and normalize to an array
    if (!is_array($existing_statuses)) {
        // Attempt to unserialize the value
        $existing_statuses = maybe_unserialize($existing_statuses);
        
        // If still not an array, set it as an empty array
        if (!is_array($existing_statuses)) {
            $existing_statuses = [];
        }
    }

    // Normalize data further if needed (optional)
    $existing_statuses = array_filter($existing_statuses, function ($item) {
        // Ensure each item is a valid associative array
        return is_array($item) && isset($item['phone']);
    });

    if (empty($existing_statuses)) {
        $existing_statuses = []; // Default to an empty array
    }


   
    // Validate input data for the new status
    if (empty($data['phone'])) {
        return new WP_Error('invalid_status', 'Phone is required.', array('status' => 400));
    } else {
        // Get user by phone number
        $users = get_users(array(
            'meta_key'   => 'phone', // Replace with the meta key used for phone numbers
            'meta_value' => sanitize_text_field($data['phone']),
            'number'     => 1, // Limit to one user
            'fields'     => array('ID', 'display_name', 'user_email'), // Fetch only relevant fields
        ));

        if (!empty($users)) {
            $user = $users[0]; // Get the first matched user
            $data['name'] = $user->display_name;
            $data['email'] = $user->user_email;
        }
    }

    // Create new status entry
    $new_status = array(
        'id'                => uniqid('st_', true),
        'name'              => sanitize_text_field($data['name']),
        'phone'             => isset($data['phone']) ? sanitize_text_field($data['phone']) : 'Anonymous',
        'company'           => isset($data['company']) ? sanitize_text_field($data['company']) : 'Anonymous',
        'email'             => isset($data['email']) ? sanitize_text_field($data['email']) : 'Anonymous',
        'currentAddress'    => isset($data['currentAddress']) ? sanitize_text_field($data['currentAddress']) : '',
        'driverStatus'      => isset($data['driverStatus']) ? sanitize_text_field($data['driverStatus']) : '',
        'status_submit_date' => date('Y-m-d H:i:s'), // Use a standard date-time format
    );


    // // Append new status to the existing statuss
    $existing_statuss[] = $new_status;

    // // Serialize and save updated statuss back to the meta field
    $statuss_serialized = maybe_unserialize($existing_statuss);
    update_post_meta($post_id, 'transportDriver', $statuss_serialized);
    if($data['transportPickupTime']){
        update_post_meta($post_id, 'transportPickupTime', sanitize_text_field($data['transportPickupTime']));
    }
    if($data['transportDeliveryTime']){
        update_post_meta($post_id, 'transportDeliveryTime', sanitize_text_field($data['transportDeliveryTime']));
    }

    if($data['currentAddress']){
        update_post_meta($post_id, 'currentAddress', sanitize_text_field($data['currentAddress']));
    }

    if($data['towingPartners']){
        update_post_meta($post_id, 'towingPartners', sanitize_text_field($data['towingPartners']));
    }
    if($data['transportTypes']){
        update_post_meta($post_id, 'transportTypes', sanitize_text_field($data['transportTypes']));
    }

    if($data['transportTypes']){
        update_post_meta($post_id, 'transportTypes', sanitize_text_field($data['transportTypes']));
    }

    if($data['insurance']){
        update_post_meta($post_id, 'insurance', sanitize_text_field($data['insurance']));
    }
    
    // update_post_meta($post_id, 'transportAwaitingPickup', sanitize_text_field('Yes'));
    // Confirm successful update
    return rest_ensure_response(array(
        'id'           => $post_id,
        'status'       => 'success',
        'message'      => 'Turbo Transport driver added successfully.',
        'transportDriver' => $existing_statuss, // Return the updated statuss array
    ));
}


function turbo_transport_transportDriver_get($request) {
    $id = $request->get_param('id');
    $data = $request->get_json_params();

    // Validate and fetch the post
    $post = get_post($id);
    if (!$post || $post->post_type !== 'turbo-transport') {
        return new WP_Error('post_not_found', 'Post not found or invalid post type.', array('status' => 404));
    }

    $post_id = $post->ID;

    // Fetch existing transport statuss from meta
    $existing_statuss = get_post_meta($post_id, 'transportDriver', true);
    if ($existing_statuss) {
        $existing_statuss = maybe_unserialize($existing_statuss);
    } else {
        $existing_statuss = []; // Initialize as an empty array if no statuss exist
    }
    // Confirm successful update
    return rest_ensure_response($existing_statuss);
}


function turbo_transport_towing_partner_post($request) {
    $data = $request->get_json_params();
    $user_id = $request->get_param('id');

    // Fallback to the current logged-in user if `id` is not provided
    if (!$user_id) {
        $user_id = get_current_user_id();
    }

    if (!$user_id) {
        return new WP_Error('user_not_found', 'User not found or not logged in.', array('status' => 404));
    }

    // Fetch existing towing partners from user meta
    $existing_towings = get_user_meta($user_id, 'towingPartner', true);
    if ($existing_towings) {
        $existing_towings = maybe_unserialize($existing_towings);
    } else {
        $existing_towings = []; // Initialize as an empty array if no statuss exist
    }

    // Validate input data for the new towing partner
    if (empty($data['partner_company'])) {
        return new WP_Error('invalid_towing', 'Partner company is required.', array('status' => 400));
    }

    // Create new towing partner entry
    $new_towing = array(
        'id'                 => uniqid('towing_', true), // Unique ID for the towing partner
        'partner_company'    => sanitize_text_field($data['partner_company']),
        'company_type'       => isset($data['company_type']) ? sanitize_text_field($data['company_type']) : '',
        'truck_type'         => isset($data['truck_type']) ? sanitize_text_field($data['truck_type']) : '',
        'partner_contract'   => isset($data['partner_contract']) ? sanitize_text_field($data['partner_contract']) : '',
        'trucks'             => isset($data['trucks']) ? sanitize_text_field($data['trucks']) : '',
        'drivers'            => isset($data['drivers']) ? sanitize_text_field($data['drivers']) : '',
        'company_logo'       => isset($data['company_logo']) ? sanitize_text_field($data['company_logo']) : '',
        'insurer'            => isset($data['insurer']) ? sanitize_text_field($data['insurer']) : '',
        'policy'             => isset($data['policy']) ? sanitize_text_field($data['policy']) : '',
        'insurance_cap'      => isset($data['insurance_cap']) ? sanitize_text_field($data['insurance_cap']) : '',
        'insurance_expiry'   => isset($data['insurance_expiry']) ? sanitize_text_field($data['insurance_expiry']) : '',
        'partner_submit_date' => date('Y-m-d H:i:s'), // Use a standard date-time format
    );

    // Append the new towing partner to the existing array
    $existing_towings[] = $new_towing;

    // Serialize and save updated towings back to the user meta field
    $towings_serialized = maybe_unserialize($existing_towings);
    update_user_meta($user_id, 'towingPartner', $towings_serialized);

    // Return a successful response
    return rest_ensure_response(array(
        'user_id'            => $user_id,
        'status'        => 'success',
        'message'       => 'Towing Partner added successfully.',
        'towingPartner' => $existing_towings, // Include the updated towings array in the response
    ));
}



function turbo_transport_towing_partner_get($request) {
    $user_id = $request->get_param('id');

    // Fallback to the current logged-in user if `id` is not provided
    if (!$user_id) {
        $user_id = get_current_user_id();
    }

    if (!$user_id) {
        return new WP_Error('user_not_found', 'User not found or not logged in.', array('status' => 404));
    }

    // Fetch existing towing partners from user meta
    $existing_towings = get_user_meta($user_id, 'towingPartner', true);
    if ($existing_towings) {
        $existing_towings = maybe_unserialize($existing_towings);
    } else {
        $existing_towings = []; // Initialize as an empty array if no towings exist
    }

    // Return the towing partner data
    return rest_ensure_response(array(
        'id'            => $user_id,
        'status'        => 'success',
        'towingPartner' => $existing_towings,
    ));
}



function turbo_transport_tow_company_post($request) {
    $data = $request->get_json_params();
    $user_id = $request->get_param('id');

    // Fallback to the current logged-in user if `id` is not provided
    if (!$user_id) {
        $user_id = get_current_user_id();
    }

    if (!$user_id) {
        return new WP_Error('user_not_found', 'Driver not found or not logged in.', array('status' => 404));
    }

    // Fetch existing towing partners from user meta
    $existing_towings = get_user_meta($user_id, 'towCompany', true);
    if ($existing_towings) {
        $existing_towings = maybe_unserialize($existing_towings);
    } else {
        $existing_towings = []; // Initialize as an empty array if no statuss exist
    }

    // Validate input data for the new towing partner
    if (empty($data['tow_company'])) {
        return new WP_Error('invalid_towing', 'Partner company is required.', array('status' => 400));
    }

    // Create new towing partner entry
    $new_towing = array(
        'id'                 => uniqid('tow_', true), // Unique ID for the towing partner
        'tow_company'    => sanitize_text_field($data['tow_company']),
        'tow_logo'    => sanitize_text_field($data['tow_logo']),
        'partner_submit_date' => date('Y-m-d H:i:s'), // Use a standard date-time format
    );

    // Append the new towing partner to the existing array
    $existing_towings[] = $new_towing;

    // Serialize and save updated towings back to the user meta field
    $towings_serialized = maybe_unserialize($existing_towings);
    update_user_meta($user_id, 'towCompany', $towings_serialized);

    // Return a successful response
    return rest_ensure_response(array(
        'user_id'            => $user_id,
        'status'        => 'success',
        'message'       => 'Tow company added successfully.',
        'towCompany' => $existing_towings, // Include the updated towings array in the response
    ));
}



function turbo_transport_tow_company_get($request) {
    $user_id = $request->get_param('id');

    // Fallback to the current logged-in user if `id` is not provided
    if (!$user_id) {
        $user_id = get_current_user_id();
    }

    if (!$user_id) {
        return new WP_Error('user_not_found', 'User not found or not logged in.', array('status' => 404));
    }

    // Fetch existing towing partners from user meta
    $existing_towings = get_user_meta($user_id, 'towCompany', true);
    if ($existing_towings) {
        $existing_towings = maybe_unserialize($existing_towings);
    } else {
        $existing_towings = []; // Initialize as an empty array if no statuss exist
    }

    // Return the towing partner data
    return rest_ensure_response(array(
        'id'            => $user_id,
        'status'        => 'success',
        'towCompany' => $existing_towings,
    ));
}



function turbo_transport_delete_post($request) {
    $id = $request->get_param('id');

    $post = get_post($id);

    if (!$post || $post->post_type !== 'turbo-transport') {
        return new WP_Error('post_not_found', 'Post not found.', array('status' => 404));
    }

    $deleted = wp_delete_post($id);

    if (!$deleted) {
        return new WP_Error('post_delete_failed', 'Failed to delete post.', array('status' => 500));
    }

    return rest_ensure_response(array(
        'id' => $id,
        'status' => 'success',
        'message' => 'Turbo Transport deleted successfully.',
    ));
}






function generate_carfax_auth_token() {
    $client_id = 'jHaxPMu3PbmYq6o9halDYCod0pLiuqzZ';
    $client_secret = 'qboUsBza-mlTz44nv6XLuYTQtlN7Hk2S_fq45w-guZLHBOp1N0YJ4rFJKccwAtno';

    $auth_url = 'https://authentication.carfax.ca/oauth/token';

    $payload = http_build_query([
        'audience' => 'https://api.carfax.ca',
        'grant_type' => 'client_credentials',
        'client_id' => $client_id,
        'client_secret' => $client_secret,
    ]);

    $headers = [
        'Content-Type: application/x-www-form-urlencoded',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
    ];

    $response = wp_remote_post($auth_url, [
        'headers' => $headers,
        'body' => $payload,
    ]);

    if (is_wp_error($response)) {
        return new WP_Error('auth_error', 'Failed to connect to the authentication server.', $response);
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['access_token'])) {
        return $data['access_token'];
    }

    return new WP_Error('auth_error', 'Failed to generate auth token.', [
        'response_body' => $body,
    ]);
}



function fetch_carfax_lien_report(WP_REST_Request $request) {
    $vin = sanitize_text_field($request->get_param('vin'));
    if (empty($vin) || strlen($vin) !== 17) {
        return wp_send_json_error(['message' => 'Invalid VIN provided.'], 400);
    }

    $token = generate_carfax_auth_token();
    if (is_wp_error($token)) {
        return wp_send_json_error([
            'message' => $token->get_error_message(),
            'details' => $token->get_error_data(),
        ], 500);
    }

    $api_url = 'https://vhrorderapi.carfax.ca/Api/V2/Order/VhrForProxy';

    $payload = [
        'AccountToken' => 'QAzHEQYi16SiG1QdDwOTcNyco1/oDzPydKnB80jdQ/JDy77nPebRTDzisgS7OLe3CJ9M21y3CzU1cKxKZUszfg==',
        'LienExpressProvince' => 'ON',
        'RefNum' => 'TrboSwiftLienCheck',
        'ReportType' => 5,
        'Vin' => $vin,
    ];

    $response = wp_remote_post($api_url, [
        'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ],
        'body' => wp_json_encode($payload),
    ]);

    if (is_wp_error($response)) {
        return wp_send_json_error([
            'message' => 'Failed to connect to Carfax API.',
            'details' => $response->get_error_message(),
        ], 500);
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['ResultCode']) && $data['ResultCode'] === 1) {
        return wp_send_json_success($data['ResponseData']);
    }

    return wp_send_json_error([
        'message' => $data['ResultMessage'] ?? 'Unknown error.',
        'response' => $data,
    ], 404);
}



function userDataByPhone($inputNumber, $normalizedNumber) {
    // Remove non-numeric characters from the input number
    $cleanedInputNumber = preg_replace('/\D/', '', $inputNumber);

    // Remove "+" from the normalized number and clean it
    $cleanedNormalizedNumber = ltrim($normalizedNumber, '+');

    // If the input number is 10 digits, prepend the country code "1" for Canada
    if (strlen($cleanedInputNumber) === 10) {
        $cleanedInputNumber = '1' . $cleanedInputNumber;
    }

    // Compare the cleaned numbers
    return $cleanedInputNumber === $cleanedNormalizedNumber;
}


function should_include_entry($form_type, $meta_data) {
    global $userdata;
    if (!isset($userdata) || !$userdata) {
        $userdata = wp_get_current_user();
    }

    $user_id = get_current_user_id();
    $user_phone = $user_id ? get_user_meta($user_id, 'phone', true) : '';
    $user_email = $userdata->user_email ?? '';

    $buyer_email_finance = 'email-1';
    $seller_email_finance = 'email-2';

    if ($form_type === 'finance') {
        $finance_status = $meta_data['finance_deal_status'] ?? '';
        $is_closed = $finance_status === 'closed' || $finance_status === 'Finished';

        $is_buyer = !empty($meta_data[$buyer_email_finance]) && $meta_data[$buyer_email_finance] === $user_email;
        $is_seller = !empty($meta_data[$seller_email_finance]) && $meta_data[$seller_email_finance] === $user_email;

        $phone_match_buyer = !empty($meta_data['phone-1']) && userDataByPhone($meta_data['phone-1'], $user_phone);
        $phone_match_seller = !empty($meta_data['phone-6']) && userDataByPhone($meta_data['phone-6'], $user_phone);

        return !$is_closed && ($is_buyer || $phone_match_buyer || $is_seller || $phone_match_seller);
    } elseif ($form_type === 'escrow') {
        $email_match = (!empty($meta_data['email-1']) && $meta_data['email-1'] === $user_email) ||
                       (!empty($meta_data['email-2']) && $meta_data['email-2'] === $user_email);

        $phone_match = userDataByPhone($meta_data['phone-1'], $user_phone) || 
                       userDataByPhone($meta_data['phone-2'], $user_phone);

        // $user_match = $meta_data['hidden-3'] == $user_id;

        return $email_match || $phone_match;
    }

    return false;
}

function check_forminator_entries($form_type, $form_id) {
    global $wpdb;

    $entries_table = $wpdb->prefix . 'frmt_form_entry';
    $meta_table = $wpdb->prefix . 'frmt_form_entry_meta';

    $entries = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT entry_id, date_created FROM $entries_table WHERE form_id = %d",
            $form_id
        )
    );

    if (empty($entries)) {
        error_log('No entries found for form ID: ' . $form_id);
        return false;
    }

    $filtered_entries = [];

    foreach ($entries as $entry) {
        $entry_id = $entry->entry_id;

        $meta = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT meta_key, meta_value FROM $meta_table WHERE entry_id = %d",
                $entry_id
            )
        );

        $meta_data = [];
        foreach ($meta as $m) {
            $meta_data[$m->meta_key] = $m->meta_value;
        }

        if (!empty($meta_data) && should_include_entry($form_type, $meta_data)) {
            $filtered_entries[] = $entry;
        }
    }

    return !empty($filtered_entries) ? $filtered_entries : false;
}

function define_global_variables() {
    global $escrows, $finances;

	$escrow_form_id = 330325;
    $credit_form_id = 337873;

    $escrows = check_forminator_entries('escrow', $escrow_form_id);
    $finances = check_forminator_entries('finance', $credit_form_id);
}
add_action('init', 'define_global_variables');




function add_dealer_user_capabilities() {
    $role = get_role('dealer'); // Replace 'dealer' with the actual role slug

    if ($role) {
        $role->add_cap('list_users');
        $role->add_cap('edit_users');
        $role->add_cap('delete_users');
        $role->add_cap('create_users');
        $role->add_cap('promote_users');
    }
}
add_action('init', 'add_dealer_user_capabilities');


// function add_advanced_custom_user_role() {
//     add_role(
//         'Finance', 
//         __('Finance', 'textdomain'),
//         array(
//             'read'              => true,
//             'edit_posts'        => true,
//             'delete_posts'      => true,
//             'publish_posts'     => true,
//             'upload_files'      => true, // Allow media uploads
//             'edit_pages'        => false,
//             'delete_pages'      => false,
//             'edit_others_posts' => false,
//         )
//     );
// }
// add_action('init', 'add_advanced_custom_user_role');


// function remove_multiple_user_roles() {
//     // List of roles to remove
//     $roles_to_remove = array('booknetic_staff', 'booknetic_customer', 'team_member', 'payer', 'contributor');

//     // Loop through each role and remove it
//     foreach ($roles_to_remove as $role) {
//         if (get_role($role)) { // Check if the role exists
//             remove_role($role);
//         }
//     }
// }
// add_action('init', 'remove_multiple_user_roles');




function login_page_srt($atts)
{
    ob_start();
    _ppt_template('ajax-modal-login'); 
     return ob_get_clean();
}
add_shortcode('login__srt', 'login_page_srt');



add_action('wp_ajax_create_new_user_ajax', 'handle_create_new_user');
add_action('wp_ajax_nopriv_create_new_user_ajax', 'handle_create_new_user');

function handle_create_new_user() {
    if (!isset($_POST['user_login'], $_POST['email'], $_POST['password'], $_POST['phone'], $_POST['address1'])) {
        wp_send_json_error("Missing required fields.");
    }

    $username = sanitize_user($_POST['user_login']);
    $email = sanitize_email($_POST['email']);
    $password = sanitize_text_field($_POST['password']);
    $phone = sanitize_text_field($_POST['phone']);
    $address = sanitize_text_field($_POST['address1']);
    $role = isset($_POST['role']) ? sanitize_text_field($_POST['role']) : 'Finance';

    if (username_exists($username)) {
        wp_send_json_error("Username already exists.");
    }

    if (email_exists($email)) {
        wp_send_json_error("Email already exists.");
    }

    $user_id = wp_create_user($username, $password, $email);
    if (is_wp_error($user_id)) {
        wp_send_json_error("Error creating user: " . $user_id->get_error_message());
    }

    $user = new WP_User($user_id);
    $user->set_role($role);

    update_user_meta($user_id, 'phone', $phone);
    update_user_meta($user_id, 'address1', $address);

    wp_send_json_success(array('message' => 'User created successfully', 'user_id' => $user_id));
}


add_action('wp_ajax_get_user_details', 'handle_get_user_details');
add_action('wp_ajax_nopriv_get_user_details', 'handle_get_user_details');

function handle_get_user_details() {
    global $CORE, $wpdb;

    if (!isset($_POST['eid'], $_POST['form_type'], $_POST['form_id'])) {
        wp_send_json_error("Missing required fields.");
    }

    $user_id = intval($_POST['eid']);
    $form_type = sanitize_text_field($_POST['form_type']);
    $form_id = intval($_POST['form_id']);

    $user_info = get_userdata($user_id);

    if (!$user_info) {
        wp_send_json_error("User not found.");
    }

    // User basic details
    $user_data = [
        'user_id' => $user_id,
        'display_name' => $user_info->display_name,
        'first_name' => $user_info->first_name,
        'last_name' => $user_info->last_name,
        'username' => $user_info->user_login,
        'email' => $user_info->user_email,
        'role' => $CORE->USER("get_role", $user_id),
        'photo' => $CORE->USER("get_photo", $user_id),
        'country' => $CORE->USER("get_address_part", ["country", $user_id]),
        'city' => $CORE->USER("get_address_part", ["city", $user_id]),
        'address' => $CORE->USER("get_address_part", ["address1", $user_id]),
        'phone' => $CORE->USER("get_address_part", ["phone", $user_id]),
        'login_info' => [
            'count' => get_user_meta($user_id, 'login_count', true),
            'last_date' => get_user_meta($user_id, 'login_lastdate', true),
            'ip' => get_user_meta($user_id, 'login_ip', true),
        ],
        'join_date' => $user_info->user_registered,
    ];

    // Fetch user entries (Finance or Escrow)
    $user_entries = get_user_based_forminator_entries($form_type, $form_id, $user_id);

    // Response
    wp_send_json_success([
        'success' => true,
        'user' => $user_data,
        'entries' => $user_entries ?: [],
    ]);
}

/**
 * Retrieve user-specific entries for Escrow or Finance.
 */
function get_user_based_forminator_entries($form_type, $form_id, $user_id) {
    global $wpdb;

    $entries_table = $wpdb->prefix . 'frmt_form_entry';
    $meta_table = $wpdb->prefix . 'frmt_form_entry_meta';

    // Get entries for the form
    $entries = $wpdb->get_results($wpdb->prepare(
        "SELECT entry_id, date_created FROM $entries_table WHERE form_id = %d",
        $form_id
    ));

    if (empty($entries)) {
        return [];
    }

    $filtered_entries = [];

    foreach ($entries as $entry) {
        $entry_id = $entry->entry_id;
        $entry_data = [
            'entry_id' => $entry_id,
            'date_created' => $entry->date_created,
        ];

        if ($form_type === 'finance') {
            $entry_data += [
                'buyer_current_step' => get_post_meta($entry_id, "entry_current_step", true),
                'seller_current_step' => get_post_meta($entry_id, "seller_entry_current_step", true),
                'finance_step_status' => get_post_meta($entry_id, "finance_step_status", true),
            ];
        } else { // Escrow case
            $entry_data += [
                'buyer_current_step' => get_post_meta($entry_id, "escrow_entry_current_step", true),
                'seller_current_step' => get_post_meta($entry_id, "seller_escrow_entry_current_step", true),
                'escrow_delivery_info' => get_post_meta($entry_id, "delivery_escrow_info", true),
                'seller_payment_method' => get_post_meta($entry_id, "seller_payment_method", true),
                'buyer_payment_proof' => get_post_meta($entry_id, "payment_proof", true),
                'buyer_escrow_status' => get_post_meta($entry_id, "buyer_escrow_step_status", true),
                'seller_escrow_status' => get_post_meta($entry_id, "seller_escrow_step_status", true),
            ];
        }

        // Fetch metadata for each entry
        $meta = $wpdb->get_results($wpdb->prepare(
            "SELECT meta_key, meta_value FROM $meta_table WHERE entry_id = %d",
            $entry_id
        ));

        foreach ($meta as $m) {
            $entry_data['meta'][$m->meta_key] = $m->meta_value;
        }

        // Only include if user-specific data is found
        if (should_user_based_include_entries($form_type, $user_id, $entry_data['meta'])) {
            $filtered_entries[] = $entry_data;
        }
    }

    return $filtered_entries;
}



function should_user_based_include_entries($form_type, $user_id, $meta_data) {
    global $userdata;
    if (!isset($userdata) || !$userdata) {
        $userdata = wp_get_current_user();
    }

    $user_phone = $user_id ? get_user_meta($user_id, 'phone', true) : '';
    $user_email = $userdata->user_email ?? '';

    $buyer_email_finance = 'email-1';
    $seller_email_finance = 'email-2';

    if ($form_type === 'finance') {
        $finance_status = $meta_data['finance_deal_status'] ?? '';
        $is_closed = $finance_status === 'closed' || $finance_status === 'Finished';

        $is_buyer = !empty($meta_data[$buyer_email_finance]) && $meta_data[$buyer_email_finance] === $user_email;
        $is_seller = !empty($meta_data[$seller_email_finance]) && $meta_data[$seller_email_finance] === $user_email;

        $phone_match_buyer = !empty($meta_data['phone-1']) && userDataByPhone($meta_data['phone-1'], $user_phone);
        $phone_match_seller = !empty($meta_data['phone-6']) && userDataByPhone($meta_data['phone-6'], $user_phone);

        return !$is_closed && ($is_buyer || $phone_match_buyer || $is_seller || $phone_match_seller);
    } elseif ($form_type === 'escrow') {
        $email_match = (!empty($meta_data['email-1']) && $meta_data['email-1'] === $user_email) ||
                       (!empty($meta_data['email-2']) && $meta_data['email-2'] === $user_email);

        $phone_match = userDataByPhone($meta_data['phone-1'], $user_phone) || 
                       userDataByPhone($meta_data['phone-2'], $user_phone);

        // $user_match = $meta_data['hidden-3'] == $user_id;

        return $email_match || $phone_match;
    }

    return false;
}


?>