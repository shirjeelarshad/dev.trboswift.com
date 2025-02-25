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


global $CORE, $post, $userdata, $CORE_AUCTION;

$user_credit = get_user_meta($userdata->ID,'ppt_usercredit',true);
	$user_credit_bakup = $user_credit;
	if($user_credit == "" || !is_numeric($user_credit) ){ $user_credit = 0; }

//1. GET EXPIRY DATE
$expiry_date = get_post_meta($post->ID, 'listing_expiry_date', true);
$vv = $CORE->date_timediff($expiry_date);

// END THE AUCTION
if ($expiry_date != "" && $vv['expired'] == 1) {
    $CORE_AUCTION->_end_auction($post->ID);
}

// GET AUCTION DISPLAY TYPE
$display_type = get_post_meta($post->ID, 'auction_type', true);

// GET CURRENT PRICE
$current_price = get_post_meta($post->ID, 'price_current', true);
if (!is_numeric($current_price)) {
    $current_price = 0;
}

// GET RESERVE PRICE
$price_reserve = get_post_meta($post->ID, 'price_reserve', true);
if (!is_numeric($price_reserve)) {
    $price_reserve = 0;
}

// GET THE BIDING TYPE
$auction_type_credit = get_post_meta($post->ID, 'auction_type_credit', true);
if ($auction_type_credit == "") {
    $auction_type_credit = 0;
}

// GET BUY NOW PRICE
$bin_price = get_post_meta($post->ID, 'price_bin', true);

$user_roles = wp_get_current_user()->roles;


$bid_increments = wp_get_post_terms($post->ID, 'bid-increments');

if (!is_wp_error($bid_increments) && !empty($bid_increments)) {
    foreach ($bid_increments as $bid_increment) {
        $dynamicIncrement = $bid_increment->name;
    }
} else {
    $dynamicIncrement = 2000000;
}


$auction_lane_name = wp_get_post_terms($post->ID, 'auction-lane');
if (!is_wp_error($auction_lane_name) && !empty($auction_lane_name)) {
    foreach ($auction_lane_name as $auction_lane) {
        $auction_lane_term = $auction_lane->slug;
    }
}

// echo $auction_lane_term;

$customer_price = get_post_meta($post->ID, 'customer_price', true);

if ($customer_price && !empty($customer_price)) {
    $auction_customer_price = $customer_price;

} else {
    $auction_customer_price = 0;
}





// GET SHIPPING OST
$price_shipping = get_post_meta($post->ID, 'price_shipping', true);
if ($price_shipping == "" || !is_numeric($price_shipping)) {
    $price_shipping = 0;
}

if ($bin_price > 0 && $price_shipping > 0) {
    $bin_price = $bin_price + $price_shipping;
}

// CHECK FOR QTY
$qty = get_post_meta($post->ID, 'qty', true);
if ($qty == "") {
    $qty = 1;
}

// CHECK FOR USER BUY NOW PAYMENT WITH ITEMS
// WHICH HAVE MULTIPLE QTY VALUES

//1. GET EXPIRY DATE
$expiry_date = get_post_meta($post->ID, 'listing_expiry_date', true);

// type
$display_type = get_post_meta($post->ID, 'auction_type', true);

// elementor preview
if (isset($_REQUEST['action']) || isset($_REQUEST['preview_id'])) {
    $post->post_status = "publish";
    $expiry_date = date("d-m-Y");
}


?>

<hr>
<div class="widget mb-5" id="widget-buybox" data-title="<?php echo __("Bidding Options", "premiumpress") ?>">
    <div id="bidding-box-close<?php echo $post->ID; ?>" class="bidding-box-close" style="display:none"></div>




    <div class="clearfix"></div>
    <div class=" ">
        <div class="d-flex justify-content-center"> <span class=" text-center">
                <div id="buybox-price" class="pb-1"><span class="text-muted ">Current Bid</span>


                    <?php if (_ppt(array('currency', 'switch')) != 1) {
                        echo _ppt(array('currency', 'symbol'));
                    } ?>
                    <span
                        class="buybox-price-num<?php echo $post->ID; ?> h5 font-weight-bold <?php echo $CORE->GEO("price_formatting", array()); ?>">00</span>
                    <?php if (_ppt(array('currency', 'switch')) != 1) {
                        echo _ppt(array('currency', 'code'));
                    } else {
                        echo hook_currency_code('');
                    } ?>
                </div>
            </span> </div>
    </div>







    <!--<div class="progress-bar">-->
    <!--  <div class="progress" id="progress"></div>-->
    <!--</div>-->








    <style>
        /*.progress-bar {*/
        /*  width: 100%;*/
        /*  height: 10px;*/
        /*  background-color: green;*/
        /*  position: relative;*/
        /*  border-radius:10px;*/
        /*}*/

        /*.progress-bar .progress {*/
        /*  width: 0%;*/
        /*  height: 100%;*/
        /*  background-color: lightgray;*/
        /*  border-radius: 0px;*/
        /*  position: absolute;*/

        /*}*/
    </style>

    <script>





        // var progressInterval; // Global variable to hold the progress interval

        // Function to start the progress animation
        // function startProgress() {
        //   var progressElement = document.getElementById("progress");
        //   progressElement.style.width = "0%"; // Reset the progress to 0%

        //   var duration = 10000; // 10 seconds in milliseconds
        //   var interval = 50; // Update progress every 50 milliseconds
        //   var increment = (interval / duration) * 100;

        //   var progress = 0;
        //   var progressAnimation = function() {
        //     progress += increment;
        //     progressElement.style.width = progress + "%";

        //     if (progress >= 100) {
        //       progress = 0; // Reset progress to 0 when it reaches 100%
        //     }
        //   };

        //   progressInterval = setInterval(progressAnimation, interval);
        // }

        // Function to restart the progress animation
        // function restartProgress() {
        //   clearInterval(progressInterval);
        //   startProgress();
        // }

        // Attach a click event listener to the restart button
        //   document.addEventListener("DOMContentLoaded", function() {
        //     document.getElementById("restartButton").addEventListener("click", function() {
        //       restartProgress();
        //     });
        //   });

        // Start the progress animation initially
        // startProgress();


    </script>




    <div class="singlebidbox">
        <div class=" ">


            <div class="">

                <div class="input-group ">
                    <div class="input-group-prepend">
                        <button class="btn btn-dark  decrementBtn" type="button"
                            id="decrementBtn<?php echo $post->ID; ?>">-</button>

                        <span class="input-group-text bg-light">
                            <?php echo hook_currency_symbol(''); ?>
                        </span>
                    </div>
                    <input type="text" class="form-control text-center  nob bid_amount<?php echo $post->ID; ?>"
                        id="bid_amount<?php echo $post->ID; ?>" name="bidamount" value="<?php if (!is_user_logged_in() || in_array('subscriber', $user_roles) || in_array('customer', $user_roles)) {
                               echo $current_price + $auction_customer_price + $dynamicIncrement;
                           } else {
                               echo $current_price + $dynamicIncrement;
                           } ?>">
                    <div class="input-group-append">
                        <button class="btn btn-dark incrementBtn" type="button"
                            id="incrementBtn<?php echo $post->ID; ?>">+</button>

                    </div>
                </div>
            </div>


            <div class=" text-xs-right">
                <?php if (is_user_logged_in()) { ?>
                <?php if ($user_credit > 1200000 ){ ?>
                    <button id="bidPriceUpdate" class=" btn btn-block  shadow-sm mt-2  bg-primary" <?php if ($userdata->ID != $post->post_author) { ?>onclick="ajax_load_buybox_bid<?php echo $post->ID; ?>(); " <?php } else { ?>onclick="alert('<?php echo __("You cannot bid on your own items.", "premiumpress"); ?>');" <?php } ?>>
                        <?php echo __("Offer Now", "premiumpress"); ?>
                    </button>
                  <?php } else { ?> 
                  <button class=" btn btn-block  shadow-sm mt-2  bg-primary" onclick="alert('<?php echo __("Ban không thể đề xuất giá mong muốn, bạn cần có số dư tài khoản của bạn từ 12 triệu đồng để tham gia.", "premiumpress"); ?>');" >
                        <?php echo __("Offer Now", "premiumpress"); ?>
                    </button>
                  
                  
                <?php }
                } else { ?>
                    <a class="btn btn-block btn-system bg-primary shadow-sm mt-2 btn-md" href="javascript:void(0);"
                        onclick="ProcessLogin();">
                        <?php echo __("Login Now", "premiumpress"); ?>
                    </a>
                <?php } ?>
            </div>


        </div>

        <div id="bidding_message<?php echo $post->ID; ?>"></div>


    </div>






    <script>
        var getDynamicBidIncrement<?php echo $post->ID; ?> = <?php echo $dynamicIncrement; ?>;


        document.getElementById('incrementBtn<?php echo $post->ID; ?>').addEventListener('click', function () {
            var inputField = document.getElementById('bid_amount<?php echo $post->ID; ?>');
            var currentValue = parseInt(inputField.value);
            var incrementedValue = currentValue + getDynamicBidIncrement<?php echo $post->ID; ?>;
            inputField.value = incrementedValue;
        });

        document.getElementById('decrementBtn<?php echo $post->ID; ?>').addEventListener('click', function () {
            var inputField = document.getElementById('bid_amount<?php echo $post->ID; ?>');
            var currentValue = parseInt(inputField.value);
            var decrementedValue = currentValue - getDynamicBidIncrement<?php echo $post->ID; ?>;

            // Check if decremented value is less than or equal to the current price
            if (decrementedValue >= <?php echo $current_price; ?>) {
                inputField.value = decrementedValue;
            } else {
                inputField.value = <?php echo $current_price; ?>;
            }
        });
    </script>





</div>







<script>


    var countdownAudio<?php echo $post->ID; ?> = new Audio('<?php echo home_url(); ?>/wp-content/uploads/sounds/mixkit-female-microphone5-0-countdown-341.mp3');

    var countdownStartTimerAuc<?php echo $post->ID; ?> = new Audio('<?php echo home_url(); ?>/wp-content/uploads/sounds/mixkit-soft-bell-countdown-919.mp3');



    var bidSubmitAudioSound<?php echo $post->ID; ?> = new Audio('<?php echo home_url(); ?>/wp-content/uploads/sounds/mixkit-start-match-countdown-1954.mp3');





    var postId = <?php echo $post->ID; ?>;






    socket.emit('subscribe', { postId });




    var lastPrices = {};

    socket.on('priceUpdate', ({ auctionId, price }) => {

        // console.log(
        //     price !== undefined
        //         ? `Pricex: ${price}`
        //         : "Pricex is undefined",
        //     auctionId !== undefined
        //         ? `Auction ID: ${auctionId}`
        //         : "Auction ID is undefined"
        // );


        if (auctionId === <?php echo $post->ID; ?>) {
            updatePrice<?php echo $post->ID; ?>(price);

            if (lastPrices[auctionId] !== null && parseFloat(price) > parseFloat(lastPrices[auctionId])) {
                updateInputPrice<?php echo $post->ID; ?>(price);

                socket.emit('countdownRestart', { restartId: auctionId });

                jQuery('#bid-added-middle<?php echo $post->ID; ?>').html("<div class='bid-added-text'><?php echo __("BID ADDED", "premiumpress"); ?></div>");

                setTimeout(function () {
                    jQuery('.bid-added-text').html("");
                }, 1000);

                countdownStartTimerAuc<?php echo $post->ID; ?>.pause();
                countdownStartTimerAuc<?php echo $post->ID; ?>.currentTime = 0;

                bidSubmitAudioSound<?php echo $post->ID; ?>.play();

                if (!isMuted) {
                    speakPrice<?php echo $post->ID; ?>(price);
                }

                ajax_load_bidding_history<?php echo $post->ID; ?>();
            }

            lastPrices[auctionId] = price;
        }
    });








    // Start the countdown on the client side
    socket.on('countdown', ({ auctionId, countdownLeft }) => {
        if (auctionId === <?php echo $post->ID; ?>) {


            liveAuctionCountdown<?php echo $post->ID; ?>(countdownLeft);

        }
    });



    socket.on('nextLiveAuction', ({ auctionId, countdownLeft }) => {

        // console.log(

        //     auctionId !== undefined
        //         ? `Cownt End Id ID: ${auctionId}`
        //         : "Auction ID is undefined"
        // );

        if (auctionId === <?php echo $post->ID; ?>) {




            updateAuctionPost<?php echo $post->ID; ?>();




            setTimeout(function () {
                changeAuctionPosts();
            }, 5000);

        }
    });


    socket.on('reserveMeet', ({ auctionId }) => {

        // console.log(

        //     auctionId !== undefined
        //         ? `reserveMeet End Id ID: ${auctionId}`
        //         : "Auction ID is undefined"
        // );

        if (auctionId === <?php echo $post->ID; ?>) {
            jQuery('.auction-end-text').html("<?php echo __("LOT SOLD", "premiumpress"); ?>");

            setTimeout(function () { jQuery('.auction-end-text').html(""); }, 6000);

        }
    });

    socket.on('reserveNotMeet', ({ auctionId }) => {
        if (auctionId === <?php echo $post->ID; ?>) {
            jQuery('.auction-end-text').html("<?php echo __("RESERVE NOT MET", "premiumpress"); ?>");

            setTimeout(function () { jQuery('.auction-end-text').html(""); }, 6000);
        }

    });








    socket.on('disconnect', () => {
        console.log('Disconnected from WebSocket server');
    });



    var isMuted = true;



    var isAuctionRunning<?php echo $post->ID; ?> = false;
    var isAuctionPaused<?php echo $post->ID; ?> = false;


    var startStopButton<?php echo $post->ID; ?> = document.getElementById('startStopButton');
    var pauseResumeButton<?php echo $post->ID; ?> = document.getElementById('pauseResumeButton');

    function toggleStartStop<?php echo $post->ID; ?>() {
        if (isAuctionRunning<?php echo $post->ID; ?>) {
            socket.emit('countdownStop', { stopId: postId });
            isAuctionRunning<?php echo $post->ID; ?> = false;
            startStopButton<?php echo $post->ID; ?>.textContent = 'Restart Auction';
            pauseResumeButton<?php echo $post->ID; ?>.disabled = true;


        } else {
            socket.emit('countdownRestart', { restartId: postId });
            isAuctionRunning<?php echo $post->ID; ?> = true;
            startStopButton<?php echo $post->ID; ?>.textContent = 'Stop Auction';
            pauseResumeButton<?php echo $post->ID; ?>.disabled = false;

            countdownAudio<?php echo $post->ID; ?>.pause(); // Pause the audio
            countdownAudio<?php echo $post->ID; ?>.currentTime = 0;

            countdownStartTimerAuc<?php echo $post->ID; ?>.pause(); // Pause the audio
            countdownStartTimerAuc<?php echo $post->ID; ?>.currentTime = 0;
        }
    }


    function togglePauseResume<?php echo $post->ID; ?>() {
        if (isAuctionPaused<?php echo $post->ID; ?>) {
            socket.emit('countdownResume', { resumeId: postId });
            isAuctionPaused<?php echo $post->ID; ?> = false;
            pauseResumeButton<?php echo $post->ID; ?>.textContent = 'Pause Auction';
            startStopButton<?php echo $post->ID; ?>.disabled = false;

            countdownAudio<?php echo $post->ID; ?>.pause(); // Pause the audio
            countdownAudio<?php echo $post->ID; ?>.currentTime = 0;

            countdownStartTimerAuc<?php echo $post->ID; ?>.pause(); // Pause the audio
            countdownStartTimerAuc<?php echo $post->ID; ?>.currentTime = 0;

        } else {
            socket.emit('countdownPause', { pauseId: postId });
            isAuctionPaused<?php echo $post->ID; ?> = true;
            pauseResumeButton<?php echo $post->ID; ?>.textContent = 'Resume Auction';
            startStopButton<?php echo $post->ID; ?>.disabled = true;


        }
    }










    function updateInputPrice<?php echo $post->ID; ?>(price) {

        var liveUpdatedPrice = price;
        var getBidIncrement = <?php echo $dynamicIncrement; ?>;
        var customerIncreamentedPrice = <?php echo $auction_customer_price ?>;


        <?php if (!is_user_logged_in() || in_array('subscriber', $user_roles) || in_array('customer', $user_roles)) { ?>




            var newLiveUpdatedPrice = parseInt(liveUpdatedPrice) + parseInt(customerIncreamentedPrice) + parseInt(getBidIncrement);



            var incrementedValue = newLiveUpdatedPrice;
        <?php } else { ?>


            var incrementedValue = parseInt(liveUpdatedPrice) + parseInt(getBidIncrement);

        <?php } ?>


        //   inputField.value = incrementedValue;

        jQuery('#bid_amount<?php echo $post->ID; ?>').val(incrementedValue);

    }





    function updatePrice<?php echo $post->ID; ?>(price) {




        <?php if (!is_user_logged_in() || in_array('subscriber', $user_roles) || in_array('customer', $user_roles)) { ?>

            var customerIncreamentedPrice = <?php echo $auction_customer_price ?>;

            var liveUpdatedPrice = parseInt(price);

            var newLiveUpdatedPrice = liveUpdatedPrice + customerIncreamentedPrice;
            var formatted_price = formatPriceWithCommas<?php echo $post->ID; ?>(newLiveUpdatedPrice);

        <?php } else { ?>

            var formatted_price = formatPriceWithCommas<?php echo $post->ID; ?>(price);

        <?php } ?>
        var priceElement = document.querySelector('.buybox-price-num<?php echo $post->ID; ?>');

        if (priceElement) {
            priceElement.textContent = formatted_price;
        }

    }

    // Call the updatePrice function with the price value here



    function formatPriceWithCommas<?php echo $post->ID; ?>(price) {
        return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }





   // Store the current speech utterance
var currentUtterance = null;

function speakPrice<?php echo $post->ID; ?>(price) {
    if ('speechSynthesis' in window) {
        // Cancel the current speech if there is one
        if (currentUtterance !== null) {
            speechSynthesis.cancel();
        }

        <?php if (!is_user_logged_in() || in_array('subscriber', $user_roles) || in_array('customer', $user_roles)) { ?>

            var customerIncreamentedPrice = <?php echo $auction_customer_price ?>;

            var liveUpdatedPrice = parseInt(price);

            var newLiveUpdatedPrice = liveUpdatedPrice + customerIncreamentedPrice;
            var formattedPrice = formatPriceForSpeech<?php echo $post->ID; ?>(newLiveUpdatedPrice);

        <?php } else { ?>

            var formattedPrice = formatPriceForSpeech<?php echo $post->ID; ?>(price);

        <?php } ?>

        var utterance = new SpeechSynthesisUtterance(`Current bid: ${formattedPrice}`);
        speechSynthesis.speak(utterance);
        // Store the current utterance
        currentUtterance = utterance;
    } else {
        // console.log('Text-to-speech not supported in this browser.');
    }
}

// Function to format price in terms of billions, millions, thousands, and individual digits
function formatPriceForSpeech<?php echo $post->ID; ?>(price) {
    var billion = Math.floor(price / 1000000000);
    var million = Math.floor((price - billion * 1000000000) / 1000000);
    var thousand = Math.floor((price - billion * 1000000000 - million * 1000000) / 1000);
    var remainder = price - billion * 1000000000 - million * 1000000 - thousand * 1000;

    var formattedPrice = '';

    if (billion > 0) {
        formattedPrice += `${convertToWords(billion)} billion `;
    }

    if (million > 0) {
        formattedPrice += `${convertToWords(million)} million `;
    }

    if (thousand > 0) {
        formattedPrice += `${convertToWords(thousand)} thousand `;
    }

    if (remainder > 0) {
        formattedPrice += `${convertToWords(remainder)} `;
    }

    return formattedPrice.trim();
}

// Function to convert number to words
function convertToWords(number) {
    var ones = ['', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
    var teens = ['eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
    var tens = ['', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
    var thousands = ['', 'thousand', 'million', 'billion'];

    if (number === 0) return 'zero';

    var chunkCount = 0;
    var words = '';

    while (number > 0) {
        var chunk = number % 1000;
        if (chunk !== 0) {
            var chunkWords = '';
            if (chunk >= 100) {
                chunkWords += ones[Math.floor(chunk / 100)] + ' hundred ';
                chunk %= 100;
            }
            if (chunk >= 11 && chunk <= 19) {
                chunkWords += teens[chunk - 11] + ' ';
                chunk = 0; // Skip handling the ones place if it's a teen number
            } else if (chunk >= 20 || chunk === 10) {
                chunkWords += tens[Math.floor(chunk / 10)] + ' ';
                chunk %= 10;
            }
            if (chunk > 0) {
                chunkWords += ones[chunk] + ' ';
            }
            chunkWords += thousands[chunkCount] + ' ';
            words = chunkWords + words;
        }
        chunkCount++;
        number = Math.floor(number / 1000);
    }
    return words.trim();
}





    var countdownCircleElement<?php echo $post->ID; ?> = document.getElementById('base-timer-label<?php echo $post->ID; ?>');
    var FULL_DASH_ARRAY = 283;
    var WARNING_THRESHOLD = 10;
    var ALERT_THRESHOLD = 5;


    var COLOR_CODES = {
        info: {
            color: "green"
        },
        warning: {
            color: "orange",
            threshold: WARNING_THRESHOLD
        },
        alert: {
            color: "red",
            threshold: ALERT_THRESHOLD
        }
    };



    var TIME_LIMIT = 60;
    var remainingPathColor = COLOR_CODES.info.color;








    function calculateCircleDasharray<?php echo $post->ID; ?>(countdown) {
        var rawTimeFraction = countdown / TIME_LIMIT;
        return `${(rawTimeFraction * FULL_DASH_ARRAY).toFixed(0)} 283`;

    }





    function liveAuctionCountdown<?php echo $post->ID; ?>(countdown) {

        var secondsRem = countdown;

        //   console.log(`secondsRem: ${secondsRem}`);

        countdownCircleElement<?php echo $post->ID; ?>.textContent = secondsRem;
        var circleDasharray = calculateCircleDasharray<?php echo $post->ID; ?>(secondsRem);
        jQuery('#base-timer-path-remaining<?php echo $post->ID; ?>').attr('stroke-dasharray', circleDasharray);

        var { alert, warning, info } = COLOR_CODES;
        var $remainingPath = jQuery('#base-timer-path-remaining<?php echo $post->ID; ?>');

        if (secondsRem <= alert.threshold) {
            $remainingPath.removeClass(warning.color).addClass(alert.color);
        } else if (secondsRem <= warning.threshold) {
            $remainingPath.removeClass(info.color).addClass(warning.color);
        } else {
            $remainingPath.addClass(info.color).removeClass(warning.color).removeClass(alert.color);
        }


        if (secondsRem > 0 && !isMuted) {
            countdownStartTimerAuc<?php echo $post->ID; ?>.play();
        }

        if (secondsRem <= 0) {

            countdownCircleElement<?php echo $post->ID; ?>.textContent = '0';


            countdownStartTimerAuc<?php echo $post->ID; ?>.pause();
            countdownStartTimerAuc<?php echo $post->ID; ?>.currentTime = 0;


            jQuery('#bidding-message-display<?php echo $post->ID; ?>').css('display', 'block');
            jQuery('#bidding-box-close<?php echo $post->ID; ?>').css('display', 'block');


            setTimeout(function () {
                jQuery('#bidding-message-display<?php echo $post->ID; ?>').css('display', 'none');
                jQuery('#bidding-box-close<?php echo $post->ID; ?>').css('display', 'none');
            }, 6000);

            jQuery('.auction-next-text').html(" <?php echo __("NEXT VEHICLE", "premiumpress"); ?>");

            setTimeout(function () { jQuery('.auction-next-text').html(""); }, 6000);




        }

        if (secondsRem <= 6 && !isMuted) {



        }






    }


    // Toggle sound on mute/unmute button click
    var toggleButton<?php echo $post->ID; ?> = document.getElementById('toggleSound<?php echo $post->ID; ?>');
    var volumeIcon<?php echo $post->ID; ?> = toggleButton<?php echo $post->ID; ?>.querySelector('i');

    function toggleSoundStartStop<?php echo $post->ID; ?>() {
        isMuted = !isMuted;
        // toggleButton.textContent = isMuted ? 'Unmute' : 'Mute';
        volumeIcon<?php echo $post->ID; ?>.classList.toggle('fa-volume-up', !isMuted);
        volumeIcon<?php echo $post->ID; ?>.classList.toggle('fa-volume-mute', isMuted);
    }








    function updateAuctionPost<?php echo $post->ID; ?>() {



        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'update_post_status',
                postId: <?php echo $post->ID; ?>,
            },
            success: function (response) {
                // Handle the response if needed

            },

        });

    }






    // CLEAR MESSAGES
    jQuery("#bid_amount<?php echo $post->ID; ?>").click(function () {

        jQuery('#bidding_message<?php echo $post->ID; ?>').html('');
        jQuery('#bidding_message_middle<?php echo $post->ID; ?>').html('');

        jQuery('.highbidder').removeClass('newhighbidder-red');

    });


    jQuery(document).ready(function () {

        <?php if (isset($_REQUEST['action']) || isset($_REQUEST['preview_id'])) {
        } else { ?>

            ajax_load_bidding_history<?php echo $post->ID; ?>();
        <?php } ?>



        jQuery(".bid_amount<?php echo $post->ID; ?>").change(function () {
            jQuery(".bid_amount<?php echo $post->ID; ?>").val(jQuery(".bid_amount<?php echo $post->ID; ?>").val().replace(',', ''));
        });

        jQuery("#user_maxbid").change(function () {
            jQuery("#user_maxbid").val(jQuery("#user_maxbid").val().replace(',', ''));
        });


    });













    function ajax_load_buybox_bid<?php echo $post->ID; ?>() {




        var bidprice = jQuery('#bid_amount<?php echo $post->ID; ?>').val();
        var ecp = jQuery('.buybox-price-num<?php echo $post->ID; ?>').html().replace(/[^0-9.,]/g, '');
        var ecp = Math.round(parseFloat(ecp) * 100) / 100;
        var bidprice = Math.round(parseFloat(bidprice) * 100) / 100;

        var bidinc = <?php if (_ppt(array('lst', 'at_bidinc')) == "") {
            echo 1;
        } else {
            echo _ppt(array('lst', 'at_bidinc'));
        } ?>;

        var minbidamount = parseFloat(ecp) + parseFloat(bidinc);






        jQuery.ajax({
            type: "POST",
            url: '<?php echo home_url(); ?>/',
            data: {
                auction_action: "buybox_bid",
                pid: <?php echo $post->ID; ?>,

				<?php if($display_type == 3){ ?> 			
   			amount: jQuery('#bid_amount<?php echo $post->ID; ?>').val(),
   			type: "penny",
   			<?php }else{ ?>
                amount: jQuery('#bid_amount<?php echo $post->ID; ?>').val(),
                type: "auction",
                <?php } ?>
                
                <?php if($auction_type_credit == 1){$ctype = "credit"; }elseif($auction_type_credit == 2){ $ctype = "tokens"; }else{  $ctype = "none"; } ?>
   			credit_type: "<?php echo $ctype; ?>",



                uid: <?php if ($userdata->ID) {
                    echo $userdata->ID;
                } else {
                    echo 0;
                } ?>,

            },
            dataType: 'json',
            success: function (response) {

                //console.log(response);


if(response.status == "nocredit"){
   			
   				jQuery('.btn-mainbid').html("<button class='btn sold'><?php echo __("NO CREDIT.","premiumpress"); ?></button>");
   				jQuery('.maxbid').html('');
   			
   			}else if(response.status  == "error_not_greater"){
   			
   				jQuery('#bidding_message').html("<div class='alert alert-danger'><?php echo __("Invalid Amount.","premiumpress"); ?></div>");
   			
   			}else{
   			
   				// CLEAN UP
   				jQuery('#bidding_message').html('');
   			
   			}



                // CHECK FOR BID RESULT
                if (response.outbid == "outbid") {

                    jQuery('#bidding_message<?php echo $post->ID; ?>').html("<div class='alert alert-danger mt-2 rounded-0'><?php echo __("You've been outbid.", "premiumpress"); ?></div>");

                } else if (response.outbid == "reserve_notmet") {

                    jQuery('#bidding_message<?php echo $post->ID; ?>').html("<div class='alert alert-warning mt-2 rounded-0'><?php echo __("This item has a reserve price. Your bid was accepted but it will not win the auction because it is less than the users reserve price.", "premiumpress"); ?></div>");

                }

            },
            error: function (e) {
                //console.log(e)
            }
        });


    }










    var hbidder_id<?php echo $post->ID; ?> = 0;




    function ajax_load_bidding_history<?php echo $post->ID; ?>() {

        jQuery.ajax({
            type: "POST",
            url: '<?php echo get_home_url(); ?>/',
            data: {
                auction_action: "bidhistory",
                pid: <?php echo $post->ID; ?>,
            },
            dataType: 'json',
            success: function (response) {

                // UPDATE COUNT
                jQuery('#bidding_history_count').html(response.total);
                jQuery('#bidding_history_data').html(response.data);

                if (response.bidder_high_name != "nobidders" || response.bidder_high_name != " ") {


                    // FLASH FOR NEW BID
                    // 			console.log(hbidder_id + ' old VS new ' + response.bidder_high_id);
                    if (response.bidder_high_id != <?php if ($userdata->ID) {
                        echo $userdata->ID;
                    } else {
                        echo 0;
                    } ?>) {
                        // SET VAR FOR NEW BID
                        // hbidder_id = response.bidder_high_id;

                    } else {
                        jQuery('#iam_highest_bidder_now<?php echo $post->ID; ?>').html("<div class='my-2 alert alert-success text-center'><?php echo __("You have the highest bid", "premiumpress"); ?></div>");
                        setTimeout(function () { jQuery('#iam_highest_bidder_now<?php echo $post->ID; ?>').html(""); }, 6000);
                    }


                    setTimeout(function () { jQuery('#bidding_message<?php echo $post->ID; ?>').html(""); }, 1000);


                }


                // RELOAD PAGE

            },
            error: function (e) {
                // alert("error" + e)
            }
        })
    }















    function changeAuctionPosts() {

        // socket.close();

        // Make sure to set the value of auction_lane_term before calling this function
        var auctionLaneTerm = '<?php echo $auction_lane_term; ?>';

        // Make an AJAX request to fetch the updated posts
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'GET',
            dataType: "html",
            data: {
                action: (function () {
                    if (auctionLaneTerm === 'lane-a') {
                        return 'getauction_lane_a';
                    } else if (auctionLaneTerm === 'lane-b') {
                        return 'getauction_lane_b';
                    } else if (auctionLaneTerm === 'lane-c') {
                        return 'getauction_lane_c';
                    }
                })()
            },
            success: function (response) {
                // Update the content of the post container with the new posts
                // jQuery('#live-auction-post-container').empty();
                jQuery('#live-auction-post-container').html(response);
            },
            error: function (e) {
                // console.log(e)
            }
        });
    }


    // console.log(`currentAuctionId: ${currentAuctionId}`);

    // console.log(`postId: ${postId}`);

    // Initial state


    // Function to toggle the state and call appropriate functions
    function toggleGetLive<?php echo $post->ID; ?>() {

        if (isMobileDevice()) {
            document.getElementById("mySidepanel").style.width = "80%";
        } else {
            document.getElementById("mySidepanel").style.width = "65%";
        }

        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'GET',
            data: {
                action: '<?php if ($auction_lane_term == 'lane-a') {
                    echo 'get_live_stream_lane_a';
                } elseif ($auction_lane_term == 'lane-b') {
                    echo 'get_live_stream_lane_b';
                } elseif ($auction_lane_term == 'lane-c') {
                    echo 'get_live_stream_lane_c';
                } ?>'
            },
            success: function (data) {
                jQuery('#showLiveCastContainer').empty();
                // Display the new post content
                jQuery('#showLiveCastContainer').html(data);



            },
        });


    }





    function removeAllBidingScript() {



        // var bidSection = document.getElementById("live-auction-slider-bid-section");

        // if (bidSection) {
        //   // Get all the script elements within the bidSection
        //   var scriptElements = bidSection.getElementsByTagName("script");

        //   // Iterate through the script elements and remove each one
        //   for (var i = scriptElements.length - 1; i >= 0; i--) {
        //     var script = scriptElements[i];
        //     script.parentNode.removeChild(script);
        //   }
        // }

        //   jQuery('#live-auction-slider-bid-section').html(""); 
        //   jQuery('#live-auction-slider-bid-section').empty();


        // const liveBiddingBox = jQuery('.main-live-bidding-row');

        // const loader = document.getElementById('loader');

        // Add the blur class to the live-bidding-box
        //   liveBiddingBox.addClass('blur-background');

        // Show the loader
        //   loader.style.display = 'block';



    }



</script>




<style>
    .blur-background {
        filter: blur(5px) brightness(70%);
    }


    /* Loading icon */
    .loader {
        display: none;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -25px;
        margin-left: -25px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }


    .iam_highest_bidder_now {
        position: absolute;
        left: 0px;
        bottom: 0px;
        padding: 20px;
    }


    /*Circle Cowntdown*/


    .auction-circle-countdown {
        position: absolute;
        right: 0px;
        bottom: 0px;
        padding: 10px;
    }


    .base-timer {
        position: relative;
        width: 100px;
        height: 100px;
    }

    .base-timer__svg {
        transform: scaleX(-1);
    }

    .base-timer__circle {
        fill: none;
        stroke: none;
    }

    .base-timer__path-elapsed {
        stroke-width: 7px;
        stroke: grey;
    }

    .base-timer__path-remaining {
        stroke-width: 7px;
        stroke-linecap: round;
        transform: rotate(90deg);
        transform-origin: center;
        transition: 1s linear all;
        fill-rule: nonzero;
        stroke: currentColor;
    }

    .base-timer__path-remaining.green {
        color: rgb(65, 184, 131);
    }

    .base-timer__path-remaining.orange {
        color: orange;
    }

    .base-timer__path-remaining.red {
        color: red;
    }

    .base-timer__label {
        position: absolute;
        width: 100px;
        height: 100px;
        top: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: bold;
        font-family: ITC Avant Garde Gothic Std;
		font-style: normal;
		font-weight: 600;
		line-height: 24px;
        color: white;
   		 text-shadow: 0px 0px 7px rgb(0 0 0);
    }
</style>