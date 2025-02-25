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
if (!defined('THEME_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

global $CORE, $post, $userdata, $CORE_AUCTION;



$user_id = $userdata->ID;

// Stripe customer Id
$customer_id = get_user_meta($user_id, 'stripe_customer_id', true);
$customer_live_id = get_user_meta($user_id, 'stripe_customer_live_id', true);


$user_credit = get_user_meta($userdata->ID, 'ppt_usercredit', true);
$user_credit_bakup = $user_credit;
if ($user_credit == "" || !is_numeric($user_credit)) {
    $user_credit = 0;
}

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




$customer_price = get_post_meta($post->ID, 'customer_price', true);

if ($customer_price && !empty($customer_price)) {
    $auction_customer_price = $customer_price;
} else {
    $auction_customer_price = 0;
}


$bid_increments = wp_get_post_terms($post->ID, 'bid-increments');

if (!is_wp_error($bid_increments) && !empty($bid_increments)) {
    foreach ($bid_increments as $bid_increment) {
        $dynamicIncrement = $bid_increment->name;
    }
} else {
    $dynamicIncrement = 2000000;
}




// ONLY SHOW IF IS LIVE
if (in_array($post->post_status, array("publish", "expired"))) {


    if ($expiry_date == "" || $vv['expired'] == 1) { ?>

        <?php _ppt_template('framework/design/singlenew/parts/_auction_end'); ?>
    <?php } else { ?>

        <div class="widget " id="widget-buybox" data-title="<?php echo __("Bidding Options", "premiumpress") ?>">


            <div id="bidding_highest_bidder" class="small"></div>


            <div>
                <div class="mt-2">


                    <style>
                        @media (min-width:1000px) {

                            .input-group-prepend .btn,
                            .input-group-append .btn {
                                width: 50px;
                                font-weight: bold;
                            }

                        }


                        .input-group-prepend .btn {
                            border: 0px solid #fff !important;
                            border-top-left-radius: 50px !important;
                            border-bottom-left-radius: 50px !important;
                            background: #BC9F4C !important;

                        }

                        .input-group-append .btn {
                            border: 0px solid #fff !important;
                            border-top-right-radius: 50px !important;
                            border-bottom-right-radius: 50px !important;
                            background: #BC9F4C !important;
                        }
                    </style>



                    <div class="mb-2">
                        <?php /*** BID BOX ***/ if ($display_type != 2) { ?>
                            <span class="small mb-3 f_size12 opacity-5">Enter amount in <?php echo hook_currency_symbol(''); ?>
                            </span>

                            <div class="d-flex bidding-block">


                                <div class="col-8 col-md-6 input-group m-0 p-0">
                                    <div class="input-group-prepend ">
                                        <button class="btn btn-primary decrementBtn" type="button" id="decrementBtn">-</button>
                                    </div>
                                    <input type="text" class="form-control text-center font-weight-bold nob bid_amount border-0 p-2 m-0" id="bid_amount" name="bidamount" value="<?php if (!is_user_logged_in() || in_array('subscriber', $user_roles) || in_array('customer', $user_roles)) {
                                                                                                                                                                                        echo number_format($current_price + $auction_customer_price + $dynamicIncrement);
                                                                                                                                                                                    } else {
                                                                                                                                                                                        echo number_format($current_price + $dynamicIncrement);
                                                                                                                                                                                    } ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary incrementBtn" type="button" id="incrementBtn">+</button>
                                    </div>
                                </div> <!-- Input Group close -->


                                <?php if ($userdata->ID) { ?>

                                    <button class="ml-2 col-4 col-md-6 btn btn-secondary rounded-pill" <?php if ($userdata->ID != $post->post_author) { ?>onclick="processNoCreditPop();" <?php } else { ?>onclick="alert('<?php echo __("You cannot bid on your own items.", "premiumpress"); ?>');" <?php } ?>>
                                        <span class="d-none d-md-block"><?php echo __("Place a bid", "premiumpress"); ?></span><span class="d-block d-md-none"><?php echo __("Bid", "premiumpress"); ?></span></button>

                                <?php } else { ?>
                                    <a class="ml-2 col-4 col-md-6 btn btn-secondary rounded-pill" href="javascript:void(0);" onclick="processRegister();"><?php echo __("Place a bid", "premiumpress"); ?></a>
                                <?php } ?>

                            </div>
                        <?php }
                        /*** END BID BOX NOW ***/ ?>

                        <?php /*** BUY NOW ***/

                        if (is_numeric($bin_price) && $bin_price > 0.00 && (($bin_price >= $current_price && $bin_price >= $price_reserve) || ($display_type == 3))) {
                        ?>

                            <?php if ($userdata->ID) { ?>


                                <button type="button" <?php if ($userdata->ID != $post->post_author) { ?> onclick="processbuynow();" <?php } else { ?> onclick="alert('<?php echo __("You cannot bid on your own items.", "premiumpress"); ?>');" <?php } ?> class="mt-3 btn btn-secondary col-md-6 rounded-pill d-flex align-items-center justify-content-center ">
                                    <?php echo __("Buy Now", "premiumpress"); ?>
                                </button>
                                <form method="post" action="" name="buynowform" id="buynowform">
                                    <input type="hidden" name="auction_action" value="buynow" />
                                </form>


                            <?php } else { ?>


                                <a href="javascript:void(0);" onclick="processLogin(1,'');" class="mt-3 btn btn-secondary col-md-6 rounded-pill d-flex justify-content-center align-items-center">
                                    <?php echo __("Buy Now", "premiumpress"); ?></a>

                            <?php } ?>




                            <script>
                                function processBidPop() {

                                    jQuery(".extra-modal-wrap").fadeIn(400);

                                }
                            </script>




                        <?php }
                        /** END BIDDING OPTIONS */ ?>

                    </div>



                </div>


                <script>
                    function processbuynow() {

                        if (confirm(
                                "<?php echo __("You want to buy this car now for sure " . hook_currency_symbol(''), "premiumpress"); ?>             <?php echo $bin_price; ?>"
                            )) {
                            jQuery("#buynowform").submit();

                        }

                    }
                </script>

                <!--<div class="mt-4 bidmanlink" style="display:none;"> <a href="<?php echo _ppt(array('links', 'myaccount')); ?>?showtab=offers"><u><?php echo __("View bid management page.", "premiumpress"); ?></u></a> </div>-->
            </div>
            <?php if ($expiry_date == "") { ?>
                <script>
                    jQuery(document).ready(function() {

                        ajax_load_bidding_history();

                    });
                </script>
            <?php } elseif ($expiry_date != "") { ?>
                <script>
                    // CLEAR MESSAGES
                    jQuery(".bid_amount").click(function() {

                        jQuery('#bidding_message').html('');
                        jQuery('.highbidder').removeClass('newhighbidder-red');

                    });

                    jQuery(document).ready(function() {

                        <?php if (isset($_REQUEST['action']) || isset($_REQUEST['preview_id'])) {
                        } else { ?>

                            ajax_load_bidding_history();
                        <?php } ?>

                        ajax_load_buybox();

                        refreshBiding();
                        //refreshBidingPage();



                        jQuery("#user_maxbid").change(function() {
                            jQuery("#user_maxbid").val(jQuery("#user_maxbid").val().replace(',', ''));
                        });

                    });


                    function refreshBiding() {
                        setTimeout(function() {

                            ajax_load_bidding_history();
                            ajax_load_buybox();

                            refreshBiding();

                        }, 100000);
                    }

                    function refreshBidingPage() { // every 5 minutes
                        setTimeout(function() {

                            window.open('<?php echo get_permalink($post->ID); ?>', "_self");

                        }, 1500000);
                    }


                    function ajax_set_maxbid() {


                        var bidprice = jQuery('#user_maxbid').val();
                        var ecp = jQuery('.buybox-price-num').html().replace(/[^0-9.,]/g, '');
                        var ecp = Math.round(parseFloat(ecp) * 100) / 100;
                        var bidprice = Math.round(parseFloat(bidprice) * 100) / 100;

                        var bidinc = <?php if (_ppt(array('lst', 'at_bidinc')) == "") {
                                            echo 1;
                                        } else {
                                            echo _ppt(array('lst', 'at_bidinc'));
                                        } ?>;


                        var minbidamount = parseFloat(ecp) + parseFloat(bidinc);

                        if (bidprice > ecp) {


                            if (bidprice < minbidamount) {

                                alert("<?php echo __("Please enter a value greater than: " . hook_currency_symbol(''), "premiumpress"); ?>" +
                                    minbidamount);
                                return false;

                            }



                        } else {
                            alert("<?php echo __("Please enter a value greater than the current auction price.", "premiumpress"); ?>");
                            return false;
                        }



                        jQuery.ajax({
                            type: "POST",
                            url: '<?php echo get_home_url(); ?>/',
                            data: {
                                auction_action: "set_maxbid",
                                pid: <?php echo $post->ID; ?>,
                                uid: <?php if ($userdata->ID) {
                                            echo $userdata->ID;
                                        } else {
                                            echo 0;
                                        } ?>,
                                amount: jQuery('#user_maxbid').val(),
                            },
                            success: function(e) {

                                //jQuery('.singlebidbox').hide();

                                jQuery('.maxbid-price-num').html(jQuery('#user_maxbid').val());

                                // CLEAR VALUE
                                //jQuery('#user_maxbid').val('');

                            },
                            error: function(e) {
                                //alert(e)
                            }
                        })
                    }




                    function ajax_expire() {
                        jQuery.ajax({
                            type: "POST",
                            url: '<?php echo get_home_url(); ?>/',
                            data: {
                                action: "expire_check_listing",
                                pid: <?php echo $post->ID; ?>
                            },
                            success: function(e) {

                                //console.log(e+'<-- ajax_expire');

                                // alert(e);
                                // RELOAD PAGE
                                //window.open('<?php echo get_permalink($post->ID); ?>', "_self");
                            },
                            error: function(e) {
                                //alert("error" + e)
                            }
                        })
                    }


                    function ajax_load_buybox() {
                        jQuery.ajax({
                            type: "POST",
                            url: '<?php echo home_url(); ?>/',
                            data: {
                                auction_action: "buybox_load",
                                pid: <?php echo $post->ID; ?>,
                                uid: <?php if ($userdata->ID) {
                                            echo $userdata->ID;
                                        } else {
                                            echo 0;
                                        } ?>,
                            },
                            dataType: 'json',
                            success: function(response) {

                                //console.log(response);

                                if (response.status == "sold") {

                                    // RELOAD WINDOW
                                    //window.open('<?php echo get_permalink($post->ID); ?>', "_self");		

                                } else {

                                    // BLINK AFFECT
                                    jQuery('#buybox-price').fadeTo('slow', 0.5).fadeTo('slow', 1.0);

                                    if (response.price != "") {


                                        var currentSedPrice = response.price;

                                        <?php if (!is_user_logged_in() || in_array('subscriber', $user_roles) || in_array('customer', $user_roles)) { ?>


                                            var customerIncreamentedPrice = <?php echo $auction_customer_price ?>;

                                            var newUpdatedPrice = parseInt(currentSedPrice) + parseInt(
                                                customerIncreamentedPrice);


                                            jQuery('.buybox-price-num').html(newUpdatedPrice);

                                            jQuery('.increamented-bid-value').html(parseInt(currentSedPrice) + parseInt(
                                                customerIncreamentedPrice) + parseInt(getDynamicBidIncrement));

                                        <?php } else { ?>


                                            var incrementedPriceValue = parseInt(currentSedPrice);
                                            jQuery('.buybox-price-num').html(incrementedPriceValue);

                                            jQuery('.increamented-bid-value').html(parseInt(currentSedPrice) + parseInt(
                                                getDynamicBidIncrement));


                                        <?php } ?>


                                        // 	jQuery('.buybox-price-num').html(response.price);

                                        // REMOVE .00
                                        var fdate = jQuery('.buybox-price-num').html().toString().replace(/\.00$/, '');
                                        jQuery('.buybox-price-num').html(fdate);

                                    }

                                    var dateStr = response.date;
                                    var a = dateStr.split(' ');
                                    var d = a[0].split('-');
                                    var t = a[1].split(':');
                                    var finalDate1 = new Date(d[0], (d[1] - 1), d[2], t[0], t[1], t[2], t[2]);

                                    //console.log(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);		

                                    //console.log('single: expiry date: '+response.date + ' --  timer date: (' +finalDate1+') timezone: <?php echo get_option('gmt_offset'); ?> ');

                                    jQuery('#buybox-timer').countdown('destroy');

                                    jQuery('#buybox-timer').countdown({
                                        until: finalDate1,
                                        layout: jQuery('#auction_timer_layout_single_side').html(),
                                        //format: $this.data( "format" ),
                                        //labels: labels, 
                                        timezone: <?php echo get_option('gmt_offset'); ?>,
                                        //compact: true,
                                        //serverSync: ajax_serverSync(),
                                        onExpiry: function() {

                                            jQuery('#buybox-buybox').html(
                                                '<button class="btn btn-block mt-2 rounded-0 "><?php echo __("Auction Finished", "premiumpress"); ?></button>'
                                            );

                                            // CORE AJAX EXPIRE
                                            ajax_expire();

                                            <?php if ($vv['expired'] != 1) { ?>
                                                // RELOAD PAGE
                                                setTimeout(function() {
                                                    location.reload();
                                                }, 2000);
                                            <?php } ?>


                                        },
                                        alwaysExpire: true,
                                    });

                                    // USER CREDIT CHANGE
                                    jQuery('#buybox-user-credit').html(response.credit);

                                }

                                // UPDATE BIDDING HISTORY
                                ajax_load_bidding_history();

                                UpdatePrices();



                            },
                            error: function(e) {
                                //console.log(e)
                            }
                        })
                    }

                    function ajax_serverSync() {

                        ajax_load_serverTime('.ggtd');
                        dateStr = jQuery('.ggtd').val();

                        if (typeof dateStr !== "undefined" && dateStr != "" && dateStr != null) {
                            //console.log(dateStr + "<-- gg");
                            return dateStr;

                        }
                    }

                    function ajax_load_buybox_bid() {

                        <?php if ($display_type != 3) { ?>


                            var bidprice = unformatNumber(jQuery('.bid_amount').val());
                            var ecp = jQuery('.buybox-price-num').html().replace(/[^0-9.,]/g, '');
                            var ecp = Math.round(parseFloat(ecp) * 100) / 100;
                            var bidprice = Math.round(parseFloat(bidprice) * 100) / 100;

                            var bidinc = <?php if (_ppt(array('lst', 'at_bidinc')) == "") {
                                                echo 1;
                                            } else {
                                                echo _ppt(array('lst', 'at_bidinc'));
                                            } ?>;

                            var minbidamount = parseFloat(ecp) + parseFloat(bidinc);
                            <?php
                            $history = get_post_meta($post->ID, 'current_bid_data', true);
                            if ($history == "" || (is_array($history) && empty($history))) {
                            } else { ?>

                            <?php } ?>




                        <?php } ?>








                        jQuery.ajax({
                            type: "POST",
                            url: '<?php echo home_url(); ?>/',
                            data: {
                                auction_action: "buybox_bid",
                                pid: <?php echo $post->ID; ?>,

                                <?php if ($display_type == 3) { ?>
                                    amount: unformatNumber(jQuery('.bid_amount').val()), // set penny amount
                                    type: "penny",
                                <?php } else { ?>
                                    amount: unformatNumber(jQuery('.bid_amount').val()),
                                    type: "auction",
                                <?php } ?>

                                <?php if ($auction_type_credit == 1) {
                                    $ctype = "credit";
                                } elseif ($auction_type_credit == 2) {
                                    $ctype = "tokens";
                                } else {
                                    $ctype = "none";
                                } ?>
                                credit_type: "<?php echo $ctype; ?>",

                                uid: <?php if ($userdata->ID) {
                                            echo $userdata->ID;
                                        } else {
                                            echo 0;
                                        } ?>,

                            },
                            dataType: 'json',
                            success: function(response) {

                                //console.log(response);

                                if (response.status == "nocredit") {

                                    jQuery('.btn-mainbid').html(
                                        "<button class='sold btn btn-block btn-danger shadow-sm mt-2 btn-md'><?php echo __("Insufficient balance to bid", "premiumpress"); ?></button>"
                                    );

                                    jQuery('.maxbid').html('');

                                } else if (response.status == "error_not_greater") {

                                    jQuery('#bidding_message').html(
                                        "<div class='alert alert-danger'><?php echo __("Invalid Amount.", "premiumpress"); ?></div>"
                                    );

                                } else {

                                    // CLEAN UP
                                    jQuery('#bidding_message').html('');

                                }

                                // RELOAD DATA
                                ajax_load_buybox();

                                // CHECK FOR BID RESULT
                                if (response.outbid == "outbid") {

                                    jQuery('#bidding_message').html(
                                        "<div class='alert alert-danger mt-2 rounded-0'><?php echo __("You've been outbid.", "premiumpress"); ?></div>"
                                    );

                                } else {

                                    jQuery('#bidding_message').html(
                                        "<div class='alert bg-secondary text-white font-weight-bold radiusx mt-2 '><i class='fa fa-check float-right mt-1'></i><?php echo __("Bid Submitted  ", "premiumpress"); ?></div>"
                                    ).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000);
                                    postCommentBid();
                                }

                                setTimeout(function() {
                                    jQuery('#bidding_message').html("");
                                }, 6000);

                            },
                            error: function(e) {
                                //console.log(e)
                            }
                        });


                    }


                    function postCommentBid() {
                        var price = parseFloat(unformatNumber(jQuery('.bid_amount').val())).toLocaleString('en-CA', {
                            style: 'currency',
                            currency: 'CAD',
                            maximumFractionDigits: 0
                        });
                        var bidValue = '<span class="bid-cmnt"><span class="bided">Bid</span> ' + price + '</span>';
                        var postId = <?php echo get_the_ID(); ?>; // Get the current post ID

                        // Make AJAX request to post the comment
                        jQuery.ajax({
                            type: 'POST',
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            data: {
                                action: 'post_comment',
                                comment: bidValue,
                                post_id: postId
                            },
                            success: function(response) {
                                jQuery('#comment').val('');
                                // Update the comments section with the new comment
                                jQuery('#auction-comments').load(location.href + ' #auction-comments');
                                jQuery('#comment-block').load(location.href + ' #comment-block');
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    }
                </script>
            <?php } // if not expired 
            ?>

        </div>



        <input type="hidden" class="ggtd" />
        <script>
            var hbidder_id = 0;

            function ajax_load_bidding_history() {

                jQuery.ajax({
                    type: "POST",
                    url: '<?php echo get_home_url(); ?>/',
                    data: {
                        auction_action: "bidhistory",
                        pid: <?php echo $post->ID; ?>
                    },
                    dataType: 'json',
                    success: function(response) {

                        // UPDATE COUNT
                        jQuery('#bidding_history_count').html(response.total);
                        jQuery('#bidding_history_data').html(response.data);

                        if (response.bidder_high_name != "nobidders" && response.bidder_high_name != "") {

                            jQuery('.highbidder').show();
                            jQuery('.bidmanlink').show();
                            jQuery('#bidding_highest_bidder').html(
                                "<div class='my-2'><i class='fal fa-user mr-2'></i> <?php echo __("Highest: ", "premiumpress"); ?>" +
                                response.bidder_high_name + "</div>"
                            ); // '<a href="' + response.bidder_high_link + '">'+response.bidder_high_photo + '</a> ' + 

                            <?php if ($userdata->ID) { ?>
                                // FLASH FOR NEW BID
                                //console.log(hbidder_id + ' old VS new ' + response.bidder_high_id);				
                                if (hbidder_id != response.bidder_high_id && response.bidder_high_id !=
                                    <?php echo $userdata->ID; ?>) {

                                    jQuery('.highbidder').addClass('newhighbidder-red').stop().fadeTo('slow', 0.1).fadeTo(
                                        'slow', 1.0);
                                    jQuery('.highbidder').removeClass('newhighbidder-red');

                                    // SET VAR FOR NEW BID
                                    hbidder_id = response.bidder_high_id;

                                }
                            <?php } ?>

                        }


                        // RELOAD PAGE
                        //window.open('<?php echo get_permalink($post->ID); ?>', "_self");
                    },
                    error: function(e) {
                        // alert("error" + e)
                    }
                })
            }
        </script>



    <?php } // end auction expired 
    ?>
<?php } ?>



<style>
    .nocredit-modal-wrap {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        z-index: 1000;
        display: none;
        overflow: auto;
        -webkit-transform: translate3d(0, 0, 0);
    }

    .card-header h5 {
        margin-bottom: 24px;
        font-weight: 700;
        font-size: 22px;
        line-height: 22px;
    }
</style>
<!--msg model -->
<div class="nocredit-modal-wrap shadow hidepage" style="display:none;">
    <div class="extra-modal-wrap-overlay"></div>
    <div class="stripe-modal-item">
        <div class="stripe-modal-container bg-white">
            <div class="position-relative">
                <!-- Modal header here  -->
                <a onclick="jQuery('.nocredit-modal-wrap').fadeOut(400);" class="btn close-stripe ">
                    <i class="fas fa-times"></i>
                </a>
            </div>

            <div class="card-body border-0">
                <div class="card-header bg-white">
                    <h5 class="text-center"> <?php echo do_shortcode('[TITLE]'); ?></h5>
                    <div class="row justify-content-center font-weight-bold"> <?php echo do_shortcode('[TIMELEFT]'); ?>
                        <span class="ml-3 font-weight-bold">Current Bid

                            <span class="buybox-price-num  text-black <?php echo $CORE->GEO("price_formatting", array()); ?>" style="font-size:16px;">00</span><span>
                    </div>
                </div>

                <div style="font-size:12px">

                    <div>Bidding will instantly reach <span class="popup-bid-button  text-black <?php echo $CORE->GEO("price_formatting", array()); ?>">00</span>.
                        TurboBid winners pay a 2.75% fee into of the winning amount. The minimum buyers fee is $275 up
                        to a maximum of $2,500.</div>


                    <div class="my-2">Bids are binding and cannot be retracted. You are responsible for completing all
                        due diligence prior to bidding. By placing this bid, you agree to the Turbobid Terms of Use.
                    </div>


                </div>


                <div class="my-2 d-flex justify-content-center flex-column">

                    <button onClick="checkCustomerPaymentmethods();" class="popup-bid-button btn btn-secondary font-weight-bold">Submit Bid</button>

                    <a onclick="jQuery('.nocredit-modal-wrap').fadeOut(400);" class="text-secondary mt-2 btn">
                        Cancel
                    </a>
                </div>

            </div>


            <!-- Modal footer here  -->
        </div>
    </div>
</div>


<script>
    function processNoCreditPop() {
        // Get the value of the bid amount input using jQuery
        var myTypedBid = unformatNumber(jQuery('.bid_amount').val());

        // Show the modal popup by fading it in
        jQuery(".nocredit-modal-wrap").fadeIn(400);

        // Check if the .popup-bid-button element exists
        var bidButton = jQuery('.popup-bid-button');
        if (bidButton.length) {
            // Define the price formatting class (assuming $CORE->GEO("price_formatting", array()) returns a valid CSS class string)
            var priceFormatting = '<?php echo $CORE->GEO("price_formatting", array()); ?>';

            // Format the bid amount using JavaScript (for example, add currency symbols, decimal points, and thousands separators)
            var formattedBid = formatBidAmount(myTypedBid);

            // Construct the HTML content with the formatted bid amount
            var buttonContent = 'Bid <span class="pricetag ' + priceFormatting + '">' + formattedBid + '</span>';

            // Update the HTML content of .popup-bid-button
            bidButton.html(buttonContent);
        }
    }

    // Example function to format the bid amount (customize as needed)
    function formatBidAmount(bidAmount) {
        // Assuming bidAmount is a numeric value representing the bid amount (e.g., 1234.56)

        // Format the bid amount with currency symbol, decimal point, and thousands separator
        var formattedAmount = 'C$' + parseFloat(bidAmount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

        return formattedAmount;
    }
</script>

<script>
    function checkCustomerPaymentmethods() {

        var ceck_customer_id = '<?php if ($customer_live_id) {
                                    echo $customer_live_id;
                                } else {
                                    echo $customer_id;
                                } ?>';

        if (ceck_customer_id) {

            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'retrieve_all_payment_methods',
                    user_id: '<?php echo $user_id; ?>',
                    nonce: '<?php echo wp_create_nonce('retrieve_all_payment_methods_nonce'); ?>'
                },
                success: function(response) {
                    if (response.success && response.data.payment_methods.length > 0) {
                        // Payment methods exist, hide modal and continue
                        jQuery(".nocredit-modal-wrap").fadeOut(400);
                        ajax_load_buybox_bid(); // Example: Call function to load content
                    } else {
                        // No payment methods, show modal to add new card
                        jQuery(".nocredit-modal-wrap").fadeOut(400);
                        addStripePaymentCard(); // Example: Call function to add new payment method
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    // Handle error scenario
                }
            });

        } else {
            jQuery(".nocredit-modal-wrap").fadeOut(400);
            addStripePaymentCard();
        }

    }



    function retrieveAllPaymentMethods() {
        // Send AJAX request to retrieve all payment methods for the customer
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'retrieve_all_payment_methods',
                user_id: '<?php echo $user_id; ?>',
                nonce: '<?php echo wp_create_nonce('retrieve_all_payment_methods_nonce'); ?>'
            },
            success: function(response) {

                // Display all payment methods in the .all-payment-methods div
                if (response.success) {
                    var paymentMethods = response.data.payment_methods;
                    var paymentMethodsHTML = '';

                    paymentMethods.forEach(function(method) {
                        paymentMethodsHTML += '<div class="credit-card ' + method.card.brand +
                            ' selectable" data-payment-method-id="' + method.id +
                            '" data-payment-method-brand="' + method.card.brand + '">';

                        paymentMethodsHTML += '<div class="d-flex align-items-center">';
                        paymentMethodsHTML += '<div class="pr-2 text-capitalize brandName">' + method
                            .card.brand + '</div>';
                        paymentMethodsHTML += '<div class="pr-2 credit-card-last4">' + method.card
                            .last4 + '</div>';

                        if (method.id === response.data.default_payment_method) {
                            paymentMethodsHTML += '<span class="badge bg-info ">Default</span>';
                        }

                        paymentMethodsHTML += '</div>';

                        paymentMethodsHTML += '<div class="pt-3 credit-card-expiry">' + method.card
                            .exp_month + ' / ' + method.card.exp_year + '</div>';
                        paymentMethodsHTML +=
                            '<a class="text-white pr-2 pt-2 set-default-btn" title="Set as default"><i class="fas fa-ellipsis-h"></i></a>';
                        paymentMethodsHTML +=
                            '<a class="pr-2 remove-method-btn"><i class="fas fa-ban"></i> Remove</a>';
                        paymentMethodsHTML += '</div>';
                    });

                    document.querySelector('.all-payment-methods').innerHTML = paymentMethodsHTML;

                    // Add event listener to set default button
                    document.querySelectorAll('.set-default-btn').forEach(function(button) {
                        button.addEventListener('click', function() {
                            var paymentMethodId = this.closest('.credit-card').getAttribute(
                                'data-payment-method-id');
                            setDefaultPaymentMethod(paymentMethodId);
                        });
                    });

                    // Add event listener to remove button
                    document.querySelectorAll('.remove-method-btn').forEach(function(button) {
                        button.addEventListener('click', function() {
                            var paymentMethodId = this.closest('.credit-card').getAttribute(
                                'data-payment-method-id');
                            var paymentMethodBrand = this.closest('.credit-card').getAttribute(
                                'data-payment-method-brand');
                            removeCardYesNoBtn(paymentMethodBrand, paymentMethodId);
                        });
                    });

                } else {
                    console.error('Error retrieving payment methods:', response.data);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                // Handle error response
            }
        });
    }



    function setDefaultPaymentMethod(paymentMethodId) {
        // Send AJAX request to set default payment method
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'set_default_payment_method',
                user_id: '<?php echo $user_id; ?>',
                payment_method_id: paymentMethodId,
                nonce: '<?php echo wp_create_nonce('set_default_payment_method_nonce'); ?>'
            },
            success: function(response) {

                // Refresh payment methods list after setting default
                retrieveAllPaymentMethods();
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                // Handle error response
            }
        });
    }


    function removeCardYesNoBtn(paymentMethodBrand, paymentMethodId) {
        jQuery('#stripe-card-content').empty();

        // Construct the function call as a string
        var detachFunctionCall = 'detachPaymentMethod("' + paymentMethodId + '");';

        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'show_modal_yes_no',
                message: 'Are you sure you want to remove this',
                card_name: paymentMethodBrand,
                yes_btn_call: detachFunctionCall, // Pass the function call string
            },
            success: function(response) {
                console.log('AJAX Success:', response);
                jQuery('.add-stripe-card-modal-wrap').fadeIn(400);
                jQuery('#stripe-card-content').html(response);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                // Handle error here (e.g., display error message)
            }
        });
    }






    function detachPaymentMethod(paymentMethodId) {
        jQuery('.add-stripe-card-modal-wrap').fadeOut(400);
        // Send AJAX request to detach payment method
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'remove_payment_method',
                user_id: '<?php echo $user_id; ?>',
                payment_method_id: paymentMethodId,
                nonce: '<?php echo wp_create_nonce('remove_payment_method_nonce'); ?>'
            },
            success: function(response) {

                // Refresh payment methods list after detaching payment method
                retrieveAllPaymentMethods();
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                // Handle error response
            }
        });
    }





    // Function to add Stripe Payment Card the posts

    function addStripePaymentCard() {
        jQuery('#stripe-card-content').empty();

        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'set_card_save_container',
                user_id: '<?php echo $user_id; ?>',
                nonce: '<?php echo wp_create_nonce('add_stripe_payment_methods_nonce'); ?>'
            },
            success: function(response) {
                jQuery('.add-stripe-card-modal-wrap').fadeIn(400);


                var addStripeBeforeText =
                    '<div class="mb-3"><h5 class="text-center mt-2">Register to Bid</h5><span style="font-size:13px;"><?php echo __("We require a valid credit card on your account before you can start bidding. TurboBid winners pay a 2.75% fee on the winning amount. The minimum buyer\'s fee is $275, up to a maximum of $2,500. All bids are binding.", "premiumpress"); ?></span></div>';

                jQuery('#stripe-card-before').html(addStripeBeforeText);

                jQuery('#stripe-card-content').html(response);

                jQuery('#submit-button').html('Register to bid');

            }
        });
    }
</script>