<?php
// fetch_listing_expiry_date_ajax.php

// Load WordPress environment
require_once('../../../wp-load.php');

// Get the current post ID (pid)
$pid = get_the_ID();

// Get the $listing_expiry_date for the first post
$listing_expiry_date = get_post_meta($pid, 'listing_expiry_date', true);

// Prepare the response data
$response_data = array(
    'listing_expiry_date' => $listing_expiry_date,
);

// Send the $listing_expiry_date as a JSON response
wp_send_json_success($response_data);
