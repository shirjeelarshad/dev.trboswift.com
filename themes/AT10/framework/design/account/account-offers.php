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

global $CORE, $userdata, $post, $settings;



if (THEME_KEY == "at") {

	$txt1 = __("Won", "premiumpress");
	$txt2 = __("Pending", "premiumpress");
	$txt3 = __("Lost", "premiumpress");

} else {

	$txt1 = __("Accepted", "premiumpress");
	$txt2 = __("Pending", "premiumpress");
	$txt3 = __("Rejected", "premiumpress");

}

if (is_admin() && isset($_GET['eid']) && is_numeric($_GET['eid'])) {
	$thisuserID = $_GET['eid'];
} else {
	$thisuserID = $userdata->ID;
}


?>




<select class="form-control w-100 show-mobile hide-ipad hide-desktop mt-4" onchange="showoffers(this.value);">

    <option value="all"><?php echo __("All", "premiumpress") ?></option>

    <option value="3"><?php echo $txt1; ?></option>
    <option value="2"><?php echo $txt3; ?></option>
    <option value="1"><?php echo $txt2; ?></option>

</select>


<script>
function showoffers(type) {


    jQuery('.collapse').removeClass('show');

    jQuery('.card-job-1').hide();
    jQuery('.card-job-2').hide();
    jQuery('.card-job-3').hide();
    jQuery('.card-job-finished').hide();

    jQuery('.card-job-' + type).show();

    if (type == "all") {

        jQuery('.card-job-1').show();
        jQuery('.card-job-2').show();
        jQuery('.card-job-3').show();
        jQuery('.card-job-finished').show();
    }

}

jQuery(document).ready(function() {

    jQuery('#count-approved').html(jQuery('.job-approved').length);
    jQuery('#count-rejected').html(jQuery('.job-rejected').length);
    jQuery('#count-pending').html(jQuery('.job-pending').length);

    jQuery('.count-offers-pending').html(jQuery('.job-pending').length);
    jQuery('.count-offers-approved').html(jQuery('.job-approved').length);

    jQuery('#count-offer-finished').html(jQuery('.job-finished').length);



    var allofferscount = parseFloat(jQuery('.job-finished').length) + parseFloat(jQuery('.job-pending')
        .length) + parseFloat(jQuery('.job-approved').length) + parseFloat(jQuery('.job-rejected').length);

    jQuery('#count-all').html(allofferscount);



    var allofferscount = parseFloat(jQuery('.job-finished:not(.ownpost)').length) + parseFloat(jQuery(
            '.job-pending:not(.ownpost)').length) + parseFloat(jQuery('.job-approved:not(.ownpost)').length) +
        parseFloat(jQuery('.job-rejected:not(.ownpost)').length);

    jQuery('.count-all-offers').html(allofferscount);


    <?php if (in_array(THEME_KEY, array("mj", "at", "ct", "dl"))) { ?>

    var allmyofferscount = parseFloat(jQuery('.job-finished.ownpost').length) + parseFloat(jQuery(
        '.job-pending.ownpost').length) + parseFloat(jQuery('.job-approved.ownpost').length) + parseFloat(
        jQuery('.job-rejected.ownpost').length);

    <?php } else { ?>
    var allmyofferscount = parseFloat(jQuery('.job-finished').length) + parseFloat(jQuery('.job-pending')
        .length) + parseFloat(jQuery('.job-approved').length) + parseFloat(jQuery('.job-rejected').length);

    <?php } ?>


    if (allmyofferscount > 0) {

        jQuery(".menu-alert-offers").html(allmyofferscount).show();

        jQuery("#icons-count-all-my-offers").find('span').html(allmyofferscount);

    } else if (allofferscount > 0) {

        jQuery(".menu-alert-offers").html(allofferscount).show();

    }

});
</script>



<div class="tabbable-panel">
    <div class="tabbable-line">



        <ul class="nav nav-tabs clearfix hide-mobile">

            <li class="nav-item">

                <a href="javascript:void(0);" onclick="showoffers('all');" class="nav-link py-3 text-black active"
                    data-toggle="tab" role="tab">
                    <span class="px-lg-2 ">
                        <?php echo __("All", "premiumpress") ?>
                    </span>

                    <span class="badge badge-pill" id="count-all">0</span>
                </a>

            </li>



            <li class="nav-item"> <a href="javascript:void(0);" onclick="showoffers(3);"
                    class="nav-link py-3 text-black  showoffers-3-btn" data-toggle="tab" role="tab"> <span
                        <?php if (!is_admin()) { ?>class="px-lg-2" <?php } ?>><?php echo $txt1; ?></span> <span
                        class="badge   badge-pill" id="count-approved">0</span> </a> </li>




            <li class="nav-item"> <a href="javascript:void(0);" onclick="showoffers(1);"
                    class="nav-link py-3 text-black showoffers-1-btn" data-toggle="tab" role="tab"> <span
                        <?php if (!is_admin()) { ?>class="px-lg-2" <?php } ?>><?php echo $txt2; ?></span> <span
                        class="badge   badge-pill" id="count-pending">0</span> </a> </li>
            <li class="nav-item"> <a href="javascript:void(0);" onclick="showoffers(2);"
                    class="nav-link py-3 text-black showoffers-2-btn" data-toggle="tab" role="tab"> <span
                        <?php if (!is_admin()) { ?>class="px-lg-2" <?php } ?>> <?php echo $txt3; ?></span><span
                        class="badge badge-pill" id="count-rejected">0</span> </a> </li>



            <li class="nav-item"> <a href="javascript:void(0);" onclick="showoffers('finished');"
                    class="nav-link py-3 text-black " data-toggle="tab" role="tab"> <span
                        <?php if (!is_admin()) { ?>class="px-lg-2" <?php } ?>>
                        <?php echo __("Finished", "premiumpress") ?></span> <span class="badge badge-pill"
                        id="count-offer-finished">0</span> </a> </li>


        </ul>

    </div>
</div>

<div class=" mt-5">
    <div class="tab-content pb-4 border-0 px-0 ">

        <div id="accordion" class="d-flex flex-wrap">
            <?php
			$paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;

			$args = array(
				'post_type' => 'ppt_offer',
				'posts_per_page' => 100,
				'paged' => $paged,
				'post_status' => 'publish',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'relation' => 'OR',
						'user1' => array(
							'key' => 'buyer_id',
							'compare' => '=',
							'value' => $thisuserID,
						),
						'user2' => array(
							'key' => 'seller_id',
							'compare' => '=',
							'value' => $thisuserID,
						),
					),
				),
			);
			$wp_query = new WP_Query($args);

			// COUNT EXISTING ADVERTISERS	 
			$tt = $wpdb->get_results($wp_query->request, OBJECT);

			$i = 1;
			$post_id_array = array();
			if (!empty($tt)) {

				foreach ($tt as $p) {





					$post = get_post($p->ID);

					$main_offer_post_id = $post->ID;

					// GET BUYER ID
					$job_buyer_id = get_post_meta($p->ID, 'buyer_id', true);
					if ($job_buyer_id == "") {
						$job_buyer_id = 0;
					}

					$job_seller_id = get_post_meta($p->ID, 'seller_id', true);
					if ($job_seller_id == "") {
						$job_seller_id = 0;
					}

					// GET POST ID FOR JOB
					$offer_status = get_post_meta($p->ID, 'offer_status', true);


					// GET POST ID FOR JOB
					$job_post_id = get_post_meta($p->ID, 'post_id', true);
					if (isset($post_id_array[$job_post_id]) && THEME_KEY == "at" && $offer_status == 1) {
						continue;
					}

					if ($job_seller_id == $thisuserID && THEME_KEY == "at" && $offer_status == 2) {
						continue;
					}
					$post_id_array[$job_post_id] = $job_post_id;


					// CHECK TITLE EXISTS
					$job_post_title = get_the_title($job_post_id);
					if ($job_post_title == "") {
						continue;
					}

					/*****************************************/


					// GET POST ID FOR JOB
					$order_total = 0;
					$order_id = "";
					if (get_post_meta($p->ID, 'order_id', true) != "") {
						$order_total = $CORE->ORDER("get_order_total", get_post_meta($p->ID, 'order_id', true));

						$payment_data = $CORE->ORDER("get_order", get_post_meta($p->ID, 'order_id', true));
						$payment_status = $CORE->ORDER("get_status", $payment_data['order_status']);

						$order_id = get_post_meta($p->ID, 'order_id', true);


					}

					if ($order_total == "0") { // THIS IS BECAUSE OF BUY NOW OPTION, NO PAYMENT ORDER IS MADE
			
						$order_total = get_post_meta($main_offer_post_id, 'price', true);
						$settings['payment_status'] = __("Pending", "premiumpress");

					}

					// CHECK FOR ESCROW SYSTEM
					if ($order_total == 0 && _ppt(array('cashout', 'enable_escrow')) == '1') {

						switch (THEME_KEY) {

							case "at": {

								$current_price = get_post_meta($job_post_id, 'price_current', true);
								if (!is_numeric($current_price)) {
									$current_price = 0;
								}

								$order_total = $current_price;
								$payment_status = array("name" => __("Pending", "premiumpress"));


							}
								break;

							case "dl":
							case "ct": {

								$order_total = get_post_meta($job_post_id, "price", true);
								$payment_status = array("name" => __("Pending", "premiumpress"));


							}
								break;

							default: {




							}
								break;
						}

					}



					// CHECK IF FUNDS PAID
					$job_donedate = get_post_meta($p->ID, 'jobdone', true);


					// PAYMENT ID
					$payment_id = "";
					$offer_complete = 0;
					$order_status = "";
					if ($offer_status == 3 && !in_array(THEME_KEY, array("da"))) { // OFFER ACCEPTED
			
						// ORDER ID
						$job_orderid = get_post_meta($p->ID, 'invoice_id', true);

						if ($job_orderid == "") {

							$job_orderid = get_post_meta($p->ID, 'order_id', true);


							$job_payment_status = get_post_meta($job_orderid, 'order_status', true);
							$offer_complete = get_post_meta($p->ID, "offer_complete", true);

							// SET JOB COMPLETE IF ESCROW PAYMENT WAS MADE
							if (($offer_complete == "" || $offer_complete == 1) && $job_payment_status == 1) {
								$offer_complete = 2;
							} elseif ($offer_complete == "") {
								$offer_complete = 1;
							}


						}

						$payment_id = get_post_meta($p->ID, "payment_id", true);
						if ($payment_id != "") {

							$odata = $CORE->ORDER("get_order", $payment_id);

							$odata_status = $CORE->ORDER("get_status", $odata['order_status']);
							if (isset($odata_status['name'])) {
								$order_status = $odata_status['name'];
							}
						}

						// PAYMENT COMPLETED
						$payment_complete = get_post_meta($p->ID, "payment_complete", true);


					}

					// FEEDBACK FORM EXTRAS
					$feedback_date = "";
					if ($offer_status == 3 && !in_array(THEME_KEY, array("da"))) {

						$feedback_date_buyer = get_post_meta($p->ID, 'feedback_date_buyer', true);
						$feedback_date_seller = get_post_meta($p->ID, 'feedback_date_seller', true);

						if ($job_buyer_id == $thisuserID) {

							$feedback_date = $feedback_date_buyer;
						} else {
							$feedback_date = $feedback_date_seller;
						}

						$_GET['pid'] = $job_post_id;
						$_GET['extraid'] = $p->ID;
						$_GET['buyerid'] = $job_buyer_id;
						$_GET['sellerid'] = $job_seller_id;

					}


					if ($offer_status == 3 && in_array(THEME_KEY, array("da"))) {

						$offer_complete = 3;

					}

					/*******************************************/

					if (THEME_KEY == "at") {
						global $CORE_AUCTION;

						// EXPIRY DATE
						$expiry_date = get_post_meta($job_post_id, 'listing_expiry_date', true);
						$vv = $CORE->date_timediff($expiry_date);
						if ($vv['expired'] == 1) {
							$expiry_date = "";
						}

						// HIGHEST BIDDER
						$hbid = $CORE_AUCTION->get_highest_bidder($job_post_id);

						if ($vv['expired'] == 1) {
							$hbid = $CORE_AUCTION->_get_winner($job_post_id);

							if ($hbid['reserve_met'] == "no") {

								continue;

							}
						}

					}
					/*******************************************/


					if (in_array(THEME_KEY, array("mj"))) {

						$txt1 = __("You paid for", "premiumpress");
						$txt2 = __("Item ordered", "premiumpress");

						$txt3 = __("New Order", "premiumpress");
						$txt4 = __("Wating Responce", "premiumpress");
						$txt5 = __("Mark Completed", "premiumpress");

						$txt6 = __("Order Received", "premiumpress");
						$txt7 = __("Accept/Decline", "premiumpress");
						$txt8 = __("Receive Payment", "premiumpress");

					} elseif (in_array(THEME_KEY, array("at"))) {

						$txt1 = __("You bid on", "premiumpress");
						$txt2 = __("Bidders for item", "premiumpress");

						$txt3 = __("New Bid", "premiumpress");
						$txt4 = __("Auction Ended", "premiumpress");
						$txt5 = __("Make Payment", "premiumpress");

						$txt6 = __("New Bid", "premiumpress");
						$txt7 = __("Auction Ended", "premiumpress");
						$txt8 = __("Receive Payment", "premiumpress");

					} elseif (in_array(THEME_KEY, array("jb"))) {

						$txt1 = __("Job title", "premiumpress");
						$txt2 = __("Job title", "premiumpress");

						$txt3 = __("Application Sent", "premiumpress");
						$txt4 = __("Wait for Responce", "premiumpress");
						$txt5 = __("Setup Interview", "premiumpress");

						$txt6 = __("Application Received", "premiumpress");
						$txt7 = __("Accept/Decline", "premiumpress");
						$txt8 = __("Setup Interview", "premiumpress");

					} elseif (in_array(THEME_KEY, array("rt"))) {

						$txt1 = __("Viewing request for", "premiumpress");
						$txt2 = __("Viewing request for", "premiumpress");

						$txt3 = __("Submit Request", "premiumpress");
						$txt4 = __("Wait for Responce", "premiumpress");
						$txt5 = __("Setup Viewing", "premiumpress");

						$txt6 = __("Viewing Request", "premiumpress");
						$txt7 = __("Accept/Decline", "premiumpress");
						$txt8 = __("Setup Viewing", "premiumpress");

					} elseif (in_array(THEME_KEY, array("da"))) {

						$txt1 = __("I requested access to", "premiumpress");
						$txt2 = __("Access request received for", "premiumpress");

						$txt3 = __("Request Sent", "premiumpress");
						$txt4 = __("Wating Responce", "premiumpress");
						$txt5 = __("Access Granted", "premiumpress");

						$txt6 = __("Requested Received", "premiumpress");
						$txt7 = __("Accept/Decline", "premiumpress");
						$txt8 = __("Access Granted", "premiumpress");


					} elseif (in_array(THEME_KEY, array("ll"))) {

						$txt1 = __("You applied for", "premiumpress");
						$txt2 = __("%user applied for", "premiumpress");

						$txt3 = __("New Applicaton", "premiumpress");
						$txt4 = __("Course Ended", "premiumpress");
						$txt5 = __("Make Payment", "premiumpress");

						$txt6 = __("New Application", "premiumpress");
						$txt7 = __("Course Ended", "premiumpress");
						$txt8 = __("Receive Payment", "premiumpress");


					} else {

						$txt1 = __("You bid on", "premiumpress");
						$txt2 = __("Your item", "premiumpress");

						$txt3 = __("Offer Sent", "premiumpress");
						$txt4 = __("Wating Responce", "premiumpress");
						$txt5 = __("Make Payment", "premiumpress");
						$txt6 = __("Offer Received", "premiumpress");
						$txt7 = __("Accept/Decline", "premiumpress");
						$txt8 = __("Receive Payment", "premiumpress");

					}

					// CHECK IF ITS MY OWN JOB
					$isownjob = "";
					if ($job_buyer_id == $thisuserID) {

					} else {
						$isownjob = "ownpost";
					}

					?>




            <div class="col-12 col-md-4 p-3 <?php if ($offer_status == 3 && $feedback_date != "") {
						echo "card-job-finished";
					} else { ?>card-job-<?php echo $offer_status; ?><?php } ?> card-postid-<?php echo $job_post_id; ?> "
                id="offer-card-<?php echo $main_offer_post_id; ?>">
                <div class="" id="heading<?php echo $post->ID; ?>">

                    <div class="listing-img-block">
                        <?php echo str_replace("data-", "", do_shortcode('[IMAGE pid="' . $job_post_id . '"]')); ?>
                    </div>


                    <div class="p-3 bg-light shadow-sm" style="border-radius:0 0 10px 10px;">
                        <div class="ellipsis">


                            <a href="<?php echo get_permalink($job_post_id); ?>" class="text-black font-weight-bold"
                                target="_blank">
                                <?php echo $job_post_title; ?></a>




                            <?php if ($job_buyer_id == $thisuserID) { ?>


                            <?php } else { ?>


                            <?php if (in_array(THEME_KEY, array("mj", "at", "ct", "dl"))) { ?>
                            <spa class="small badge badge-success"><?php echo __("selling", "premiumpress"); ?></span>

                                <?php } else { ?>

                                <div class="small  opacity-5">
                                    <?php echo str_replace("%user", $CORE->USER("get_username", $job_buyer_id), $txt2); ?>
                                </div>



                                <?php } ?>


                                <?php } ?>



                        </div>

                        <div class="bid-status-badge">


                            <?php if ($offer_status == 1 || $offer_status == "") { ?>

                            <?php if (THEME_KEY == "at") {

											// GET CURRENT PRICE
											$current_price = get_post_meta($job_post_id, 'price_current', true);
											if (!is_numeric($current_price)) {
												$current_price = 0;
											}

											?>

                            <div class="font-weight-bold job-pending <?php echo $isownjob; ?>">
                                <?php echo hook_price($current_price); ?>
                            </div>


                            <?php } else { ?>
                            <span
                                class="badge badge-info job-pending <?php echo $isownjob; ?>"><?php echo __("Pending", "premiumpress"); ?></span>
                            <?php } ?>

                            <?php } elseif ($offer_status == 2) { ?>

                            <span class="badge badge-danger job-rejected <?php echo $isownjob; ?>"><?php if (THEME_KEY == "at") {
											   echo __("Lost", "premiumpress");
										   } else {
											   echo __("Rejected", "premiumpress");
										   } ?>

                            </span>

                            <?php } elseif ($offer_status == 3 && $feedback_date != "") { ?>

                            <span class="badge badge-dark job-finished <?php echo $isownjob; ?>">
                                <i class="fa fa-heart" aria-hidden="true"></i>
                                <?php echo __("Complete", "premiumpress"); ?></span>
                            <?php } elseif ($offer_status == 3) { ?>

                            <span class="badge badge-success job-approved <?php echo $isownjob; ?>">

                                <?php if (THEME_KEY == "at") {

												if ($job_buyer_id == $thisuserID) {
													echo __("Won", "premiumpress");
												} else {

													echo __("Sold", "premiumpress");
												}

											} else {
												echo __("Accepted", "premiumpress");
											} ?> </span>

                            <?php } ?>

                        </div>

                        <div class="">





                            <?php

									switch (THEME_KEY) {

										case "at": {

											$current_price = get_post_meta($job_post_id, 'price_current', true);
											if (!is_numeric($current_price)) {
												$current_price = 0;
											}

											// GET SHIPPING OST
											$price_shipping = get_post_meta($job_post_id, 'price_shipping', true);
											if ($price_shipping == "" || !is_numeric($price_shipping)) {
												$price_shipping = 0;
											}

											if ($price_shipping > 0) {
												$current_price = $current_price + $price_shipping;
												$order_total = $current_price;
											}





										}
											break;

										default: {


											if (is_numeric($order_total) && $order_total > 0) {

												echo '<div class="' . $CORE->GEO("price_formatting", array()) . '">' . hook_price($order_total) . '</div>';
											}

										}
											break;
									}


									?>






                        </div>


                        <div class="text-secondary small my-3"><i class="fal fa-map-marker-alt"></i> <?php

								$auction_location = wp_get_post_terms($job_post_id, 'location');

								if (!empty($auction_location) && !is_wp_error($auction_location)) {

									$auction_location_link = get_term_link($auction_location[0]);

									if (!is_wp_error($auction_location_link)) {
										echo '<a class="text-secondary font-weight-bold" href="' . esc_url($auction_location_link) . '">' . esc_html($auction_location[0]->name) . '</a>';
									} else {
										echo $auction_location[0]->name;

									}
								}

								?></div>

                        <ul class=" mb-2  list-inline seperator">
                            <li class="list-inline-item  pr-2">

                                <span class="text-secondary font-weight-bold" style="font-weight:300; font-size:12px">
                                    <?php

											$auction_gear = wp_get_post_terms($job_post_id, 'transmission');

											if (!empty($auction_gear) && !is_wp_error($auction_gear)) {

												$gear_link = get_term_link($auction_gear[0]);

												if (!is_wp_error($term_link)) {
													echo '<a class="text-black" href="' . esc_url($gear_link) . '">' . esc_html($auction_gear[0]->name) . '</a>';

												} else {
													echo $auction_gear[0]->name;

												}
											}

											?>
                                </span>
                            </li>

                            <li class="list-inline-item pr-2">

                                <span class="text-black " style="font-weight:300; font-size:12px"><?php

										$auction_fuel = wp_get_post_terms($job_post_id, 'fuel');

										if (!empty($auction_fuel) && !is_wp_error($auction_fuel)) {

											$auction_fuel_link = get_term_link($auction_fuel[0]);

											if (!is_wp_error($auction_fuel_link)) {
												echo '<a class="text-secondary font-weight-bold" href="' . esc_url($auction_fuel_link) . '">' . esc_html($auction_fuel[0]->name) . '</a>';
											} else {
												echo $auction_fuel[0]->name;

											}
										}

										?> </span>
                            </li>
                            <li class="list-inline-item pr-2">
                                <span class="text-secondary font-weight-bold " style="font-weight:300; font-size:12px">
                                    <?php
											echo get_post_meta($job_post_id, 'key1', true);
											?> KM
                                </span>
                            </li>
                        </ul>

                        <div class="">

                            <a href="javascript:void(0);" onclick="ajax_chat_logs_<?php echo $post->ID; ?>_show();"
                                class="btn btn-secondary btn-block opacity-9 rounded-pill" data-toggle="modal"
                                data-target="#modal<?php echo $post->ID; ?>">
                                <?php echo __("View Details", "premiumpress"); ?>
                            </a>

                            <script>
                            function ajax_chat_logs_<?php echo $post->ID; ?>_show() {

                                if (jQuery('#ppt_chat_send_<?php echo $p->ID; ?>_chat_msg').length > 0) {
                                    ajax_chat_logs_<?php echo $post->ID; ?>();
                                }
                            }
                            </script>

                        </div>

                    </div>
                </div>
            </div>



            <div class="modal fade" id="modal<?php echo $post->ID; ?>" tabindex="-1" role="dialog"
                aria-labelledby="modalLabel<?php echo $post->ID; ?>" aria-hidden="true">
                <div class="modal-xl modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-white" id="modalLabel<?php echo $post->ID; ?>">
                                <?php echo __("Bid Details", "premiumpress"); ?>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid px-0">
                                <div class="row">
                                    <?php if (is_admin()) { ?>
                                    <div class="col-12 text-right">
                                        <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=orders&eid=<?php echo $order_id; ?>"
                                            class="btn btn-system bt-md mr-2 float-left" target="_blank">
                                            <i class="fa fa-file"></i> <?php echo __("Edit Order", "premiumpress"); ?>
                                        </a>
                                        <button type="button" class="btn btn-system bt-md mr-2"
                                            onclick="ajax_single_offer_close_<?php echo $post->ID; ?>()">
                                            <i class="fa fa-sync"></i> <?php echo __("Close", "premiumpress"); ?>
                                        </button>
                                        <?php if (THEME_KEY == "mj") { ?>
                                        <button type="button" class="btn btn-system bt-md mr-2"
                                            onclick="ajax_single_offer_refund_<?php echo $post->ID; ?>()">
                                            <i class="fa fa-sync"></i> <?php echo __("Refund", "premiumpress"); ?>
                                        </button>
                                        <?php } ?>
                                        <button type="button" class="btn btn-system bt-md"
                                            onclick="ajax_single_offer_delete_<?php echo $post->ID; ?>()">
                                            <i class="fa fa-trash"></i> <?php echo __("Delete", "premiumpress"); ?>
                                        </button>
                                        <hr />
                                    </div>
                                    <?php } ?>
                                    <div class="col-md-8">
                                        <?php
												global $settings;
												$settings['pid'] = $p->ID;
												$settings['offer_complete'] = $offer_complete;
												$settings['offer_status'] = $offer_status;
												$settings['job_post_id'] = $job_post_id;
												$settings['job_seller_id'] = $job_seller_id;
												$settings['job_buyer_id'] = $job_buyer_id;
												$settings['order_id'] = $order_id;
												$settings['order_total'] = $order_total;
												$settings['order_date'] = $post->post_date;
												$settings['payment_id'] = $payment_id;
												$settings['feedback_date'] = $feedback_date;
												$settings['offer_id'] = $main_offer_post_id;
												if (isset($payment_status['name'])) {
													$settings['payment_status'] = $payment_status['name'];
												}
												$status_key = $settings['offer_status'] . "-" . $settings['offer_complete'];
												if ($settings['offer_status'] == 3) {
													$settings['ajax'] = "offer_complete";
												} else {
													$settings['ajax'] = "offer_update";
												}
												_ppt_template('framework/design/account/parts/_complete');
												if ($status_key == "3-5") {
													_ppt_template('framework/design/account/parts/_feedback');
												} elseif ($settings['offer_status'] == 3) {
													_ppt_template('framework/design/account/parts/_chat');
												}
												?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
												global $settings;
												$settings['pid'] = $p->ID;
												$settings['offer_complete'] = $offer_complete;
												$settings['offer_status'] = $offer_status;
												$settings['job_post_id'] = $job_post_id;
												$settings['job_seller_id'] = $job_seller_id;
												$settings['job_buyer_id'] = $job_buyer_id;
												$settings['order_total'] = $order_total;
												$settings['order_date'] = $post->post_date;
												$settings['payment_id'] = $payment_id;
												if (isset($payment_status['name'])) {
													$settings['payment_status'] = $payment_status['name'];
												}
												_ppt_template('framework/design/account/parts/_details');
												?>
                                    </div>
                                </div>
                                <script>
                                function ajax_single_offer_close_<?php echo $post->ID; ?>() {
                                    jQuery.ajax({
                                        type: "POST",
                                        url: '<?php echo home_url(); ?>/',
                                        dataType: 'json',
                                        data: {
                                            single_action: "offer_close",
                                            job_id: <?php echo $p->ID; ?>,
                                            listing_id: <?php echo $job_post_id; ?>,
                                            seller_id: <?php echo $job_seller_id; ?>,
                                            buyer_id: <?php echo $job_buyer_id; ?>,
                                        },
                                        success: function(response) {
                                            if (response.status == "ok") {
                                                jQuery('#modal<?php echo $post->ID; ?>').modal('hide');
                                            } else {
                                                console.log("Error trying to add.");
                                            }
                                        },
                                        error: function(e) {
                                            console.log(e)
                                        }
                                    });
                                }

                                function ajax_single_offer_refund_<?php echo $post->ID; ?>() {
                                    jQuery.ajax({
                                        type: "POST",
                                        url: '<?php echo home_url(); ?>/',
                                        dataType: 'json',
                                        data: {
                                            single_action: "offer_refund",
                                            job_id: <?php echo $p->ID; ?>,
                                            listing_id: <?php echo $job_post_id; ?>,
                                            seller_id: <?php echo $job_seller_id; ?>,
                                            buyer_id: <?php echo $job_buyer_id; ?>,
                                        },
                                        success: function(response) {
                                            if (response.status == "ok") {
                                                jQuery('#modal<?php echo $post->ID; ?>').modal('hide');
                                            } else {
                                                console.log("Error trying to add.");
                                            }
                                        },
                                        error: function(e) {
                                            console.log(e)
                                        }
                                    });
                                }

                                function ajax_single_offer_delete_<?php echo $post->ID; ?>() {
                                    jQuery.ajax({
                                        type: "POST",
                                        url: '<?php echo home_url(); ?>/',
                                        dataType: 'json',
                                        data: {
                                            single_action: "offer_delete",
                                            job_id: <?php echo $p->ID; ?>,
                                            listing_id: <?php echo $job_post_id; ?>,
                                            seller_id: <?php echo $job_seller_id; ?>,
                                            buyer_id: <?php echo $job_buyer_id; ?>,
                                        },
                                        success: function(response) {
                                            if (response.status == "ok") {
                                                jQuery('#modal<?php echo $post->ID; ?>').modal('hide');
                                            } else {
                                                console.log("Error trying to add.");
                                            }
                                        },
                                        error: function(e) {
                                            console.log(e)
                                        }
                                    });
                                }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <?php } ?>



            <?php } else { ?>

            <div class="text-center mt-5"><i
                    class="<?php echo $CORE->LAYOUT("captions", "icon-offer"); ?> fa-4x text-primary"></i></div>

            <h4 class="text-center mt-4">
                <?php echo str_replace("%s", strtolower($CORE->LAYOUT("captions", "offers")), __("No %s found", "premiumpress")); ?>
            </h4>

            <p class="text-center text-black mt-3">
                <?php echo str_replace("%s", strtolower($CORE->LAYOUT("captions", "offer")), __("Submit a new %s to get started!", "premiumpress")); ?>
            </p>


            <?php } ?>

        </div>
        <style>
        .listing-img-block .ppt_image {
            border-radius: 10px 10px 0 0;
            height: 200px;
            width: 100%;
            object-fit: cover;
        }

        .bid-status-badge .badge {
            position: absolute;
            top: 30px;
            left: 30px;
        }

        .job-pending {
            position: absolute;
            top: 190px;
            background: white;
            padding: 0 10px;
            font-size: 12px;
            border-radius: 10px;
        }
        </style>
        <!-- end accordian -->

    </div>
</div>

<?php if (isset($_GET['showoid']) && is_numeric($_GET['showoid'])) { ?>
<script>
jQuery(document).ready(function() {

    jQuery('#collapse<?php echo esc_attr($_GET['showoid']); ?>').collapse('show');
    ajax_chat_logs_<?php echo esc_attr($_GET['showoid']); ?>_show();
});
</script>
<?php } ?>