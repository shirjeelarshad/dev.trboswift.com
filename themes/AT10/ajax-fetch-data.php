<?php
// Include WordPress core files
require_once( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/wp-load.php' );

// Fetch the bid count and current price
$num_bids = do_shortcode('[BIDS]');
$current_price = get_post_meta($_GET['post_id'], 'price_current', true);

// Prepare the response
$response = array(
    'num_bids' => $num_bids,
    'current_price' => $current_price
);

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
exit;
