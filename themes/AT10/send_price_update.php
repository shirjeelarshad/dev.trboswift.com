<?php
// send_price_update.php

// Check if the WebSocket server URL and price are provided as command line arguments
if (isset($argv[1]) && isset($argv[2])) {
    $websocket_url = $argv[1];
    $price_live = $argv[2];

    // Create a WebSocket client using PHP cURL
    $ch = curl_init($websocket_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['price' => $price_live]));
    curl_exec($ch);
    curl_close($ch);
}
