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
   if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
   
global $wpdb, $CORE, $userdata, $STRING;

$user_id = get_current_user_id(); // Get the current user ID
$user_email = $userdata->user_email; // Get the current user email

// Specify the Forminator form ID and the meta key
$form_id = 318301; // Replace with your specific Forminator form ID
$meta_key = 'hidden-3'; // Replace with your specific meta key
$seller_email_meta = 'email-1'; // Replace with your specific seller email meta key
$buyer_email_meta = 'email-2'; // Replace with your specific buyer email meta key

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

$filtered_entries = [];

if (current_user_can('administrator')) {
    // Admin: Show all entries
    $filtered_entries = $entries;
} else {
    // Non-admin: Filter entries by meta value
    foreach ($entries as $entry) {
        $entry_id = $entry->entry_id;

        // Fetch metadata for the entry with the specified meta key and user ID
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

        // Check if the meta value matches the user ID or email
        if (
            (!empty($meta_data[$meta_key]) && $meta_data[$meta_key] == $user_id) ||
            (!empty($meta_data[$seller_email_meta]) && $meta_data[$seller_email_meta] == $user_email) ||
            (!empty($meta_data[$buyer_email_meta]) && $meta_data[$buyer_email_meta] == $user_email)
        ) {
            $filtered_entries[] = $entry;
        }
    }
}
?>




<div class="admin-escrow-order-data">


    <div class="card-body p-0">
        <?php if (!empty($filtered_entries)) { ?>
        <div class="overflow-auto">
            <div class="table small table-orders">
                <div class="overflow-scroll">
                    <div class="d-flex"
                        style=" margin-bottom:5px; color: #909090; font-family: Inter; font-style: normal; font-weight: 400;">
                        <div class="col"><?php echo __("ID", "premiumpress"); ?></div>
                        <div class="col"><?php echo __("Transaction Title", "premiumpress"); ?></div>
                        <div class="col"><?php echo __("Created", "premiumpress"); ?></div>
                        <div class="col"><?php echo __("Amount", "premiumpress"); ?></div>
                        <div class="col"><?php echo __("Role", "premiumpress"); ?></div>
                        <div class="col" style="border-radius:0 10px 0 0;"><?php echo __("Status", "premiumpress"); ?>
                        </div>
                        <div class="col" style="border-radius:0 10px 0 0;"><?php echo __("Actions", "premiumpress"); ?>
                        </div>


                    </div>
                </div>
                <div>
                    <?php
                        foreach ($filtered_entries as $entry) {
                            $entry_id = $entry->entry_id;

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
                        ?>
                    <div class="d-flex row-<?php echo $entry_id; ?>"
                        style="font-size:12px; padding:10px 5px; margin-bottom:5px; border-radius:6px; background:#f5f7fa">
                        <div class="col">
                            <a class="text-dark entry-link" href="javascript:void(0)"
                                data-entry-id="<?php echo $entry->entry_id; ?>">
                                #<?php echo $entry->entry_id; ?>
                            </a>
                        </div>
                        <div class="col">
                            <?php echo isset($meta_data['name-1']) ? esc_html($meta_data['name-1']) : ''; ?><br>
                            <span
                                class="small opacity-5"><?php echo isset($meta_data['text-12']) ? esc_html($meta_data['text-12']) : ''; ?></span>
                        </div>
                        <div class="col">
                            <?php echo esc_html(hook_date($entry->date_created)); ?>
                        </div>
                        <div class="col">
                            <?php echo isset($meta_data['currency-1']) ? esc_html(hook_price($meta_data['currency-1'])) : ''; ?>
                        </div>
                        <div class="col">
                            <?php echo isset($meta_data['select-10']) ? esc_html($meta_data['select-10']) : ''; ?>
                        </div>
                        <div class="col">
                            <div style="background:#ECFDF3; color:#027A48; padding:5px 10px; border-radius:50px">
                                Awaiting</div>
                        </div>

                        <div class="col">
                            <a class="text-dark entry-link" href="javascript:void(0)"
                                data-entry-id="<?php echo $entry->entry_id; ?>">
                                <i class="fal fa-pen"></i>
                            </a>
                        </div>

                    </div>
                    <?php
                        }
                        ?>
                </div>
            </div>
        </div>
        <?php } else { ?>
        <div class="not-fount-entries py-5 text-center">
            <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/Group222.png" />
            <h6><i class="fal fa-frown mr-2"></i>
                <?php echo __("There’s nothing here yet. Click below to start a new transaction.", "premiumpress"); ?>
            </h6>

        </div>
        <?php } ?>
    </div>
</div>





<div class="escrow-entry-details mt-3 d-none">

    <div>
        <div class="turbobidescrow escrow-bg-green mb-2 position-relative">
            <button type="button" class="escrow-back-main btn btn-light d-none rounded-pill"
                style="position: absolute; right: 30px; top: 15px;"><i class="fal fa-times"></i></button>
            <img class="turbobidescrow-child" loading="lazy" alt="turbobid escrow icon"
                src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/escrow.svg" />

            <section class="turbobidescrow-inner col-10">
                <div class="frame-parent">
                    <div class="turbobid-escrow-services-wrapper">
                        <h3 class="turbobid-escrow-services">TurboBId Escrow Services</h3>
                    </div>
                    <div class="lien-service">
                        <div class="the-lien-payoff">
                            The Lien Payoff service is applied for this transaction

                        </div>
                        <span class="small">TurboBId will assist in sending the payoff check to the lien
                            holder. Contact escrow@turbobid.ca for any concerns.</span>

                    </div>
                </div>
            </section>
        </div>

        <div class="bg-white p-3 mb-2" style="border-radius:22px;">
            <div class="mb-3">
                <div class="d-flex flex-column flex-md-row justify-content-between mb-1">
                    <div class="escrow-entry-title h6">Tesla Model 3</div>
                    <div class="text-md-right">Transaction #<span class="escrow-entry-id">9865445678556</span><i
                            class="fal fa-copy ml-1"></i></div>
                </div>
                <span class="text-primary small">TurboBid offers secure escrow services, ensuring payment protection,
                    instant lien checks, and fraud prevention for vehicle transactions.</span>
            </div>



            <div class="escrow-process py-5">

                <div>
                    <input type="hidden" id="escrow_entry_id" value="123">
                    <input type="hidden" id="escrow_entry_seller_email" value="randoded.it@gmail.com">
                    <input type="hidden" id="escrow_entry_seller_phone" value="+11">
                    <input type="hidden" id="escrow_entry_buyer_email" value="randoded.it@gmail.com">
                    <input type="hidden" id="escrow_entry_buyer_phone" value="+11">
                    <input type="hidden" id="escrow_entry_vehicle_vin" value="VIN11">
                    <input type="hidden" id="escrow_entry_vehicle_name" value="LAND ROVER">

                </div>



                <div id="step-details">

                    <div id="buyer-all-escrow-details" class="mt-5">

                        <h6 class="mb-2">Buyer Escrow Details:</h6>

                        <div id="buyer-progress-container" class="progress-container"></div>



                        <?php if (current_user_can('administrator')) { ?>
                        <div class="my-3">

                            <button onclick="decreaseEscrowStep('buyer')" class="btn escrow-warning rounded-pill px-3"
                                id="buyer-escrow-step-back" disabled>&larr;
                                Back</button>
                            <button onclick="escrowMakeNextStep('buyer')" id="buyer-escrow-step-next"
                                class="btn escrow-accepted rounded-pill px-3">Make
                                Complete</button>
                        </div>
                        <?php } ?>

                        <div class="escrow-process-step-details" data-step="1">
                            <div class="container d-flex flex-row flex-md-column m-0 p-2"
                                style="border-radius:22px; border:1px solid #3B634C;">

                                <div class="col-md-9">
                                    <h5>Agreement Created </h5>
                                    <p><span class="escrow-buyer-name text-primary">Buyer (Shirjeel Arshad)</span>is
                                        buying a motor vehicle from
                                        <span class="escrow-seller-name text-primary">Seller(Kenneth Pham)</span>. Buyer
                                        & Seller are both
                                        required to complete the TurboBid AI Damage inspection
                                    </p>

                                    <div class="d-flex align-items-center my-3" style="gap:10px;">
                                        <span class="escrow-warning px-3 py-1 rounded">Status</span>
                                        <button type="button" id="buyer1-verified" class="btn"
                                            onclick="escrowProgressVerification('buyer', '1', 'Agreement', 'Verified')">
                                            <i class="fal fa-check-circle fa-lg"></i>
                                        </button>
                                        <button type="button" id="buyer1-unverified" class="btn"
                                            onclick="escrowProgressVerification('buyer', '1', 'Agreement', 'Un Verified')">
                                            <i class="fal fa-times-circle fa-lg"></i>
                                        </button>
                                    </div>


                                </div>
                                <div class="d-none d-md-block col-md-3 align-self-center">
                                    <?php echo $CORE->LAYOUT("get_logo", "light"); ?>
                                </div>

                            </div>







                        </div>

                        <div class="escrow-process-step-details" data-step="2" style="display: none;">

                            <div class="container d-flex flex-column flex-md-row m-0 p-2"
                                style="border-radius:22px; border:1px solid #3B634C;">

                                <div class="col-md-6">
                                    <h5>Payment <span class="escrow-pay-status escrow-warning">Pending</span></h5>

                                    <p>Please verify uploaded proof of payment </p>




                                    <div class="d-flex flex-wrap" id="paymentProofPreviewContainer"></div>


                                </div>

                                <div class="col-md-6 d-md-flex flex-column justify-content-between pt-3 pt-md-0">
                                    <div class="d-none d-md-block col-md-5 align-self-end">
                                        <?php echo $CORE->LAYOUT("get_logo", "light"); ?>
                                    </div>
                                    <div class="d-flex align-items-center my-3" style="gap:10px;">
                                        <span class="escrow-warning px-3 py-1 rounded"> Status: </span>
                                        <button type="button" id="buyer2-verified" class="btn"
                                            onclick="escrowProgressVerification('buyer', '2', 'Payment', 'Approved')">
                                            <i class="fal fa-check-circle fa-lg"></i>
                                        </button>
                                        <button type="button" id="buyer2-unverified" class="btn"
                                            onclick="escrowProgressVerification('buyer', '2', 'Payment', 'Un Approved')">
                                            <i class="fal fa-times-circle fa-lg"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>



                        </div>




                        <div class="escrow-process-step-details" data-step="3" style="display: none;">
                            <div class="container position-relative m-0 p-5"
                                style="border-radius:22px; border:1px solid #3B634C;">
                                <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/carfax-canada.svg"
                                    style="position: absolute; right: 30px; top: 15px; width:55px; height:55px;" />

                                <div class="row col-12">
                                    <h5>Vehicle Verification</h5>
                                    <div class="col-5 col-md-2 align-self-center">
                                        <?php echo $CORE->LAYOUT("get_logo", "light"); ?>
                                    </div>
                                </div>



                                <div class="col-12 d-md-flex m-0 justify-content-md-end">

                                    <div class="d-flex align-items-center my-3" style="gap:10px;">
                                        <span class="escrow-warning px-3 py-1 rounded"> Status: </span>
                                        <button type="button" id="buyer3-verified" class="btn"
                                            onclick="escrowProgressVerification('buyer', '3', 'Vehicle Verification', 'Approved')">
                                            <i class="fal fa-check-circle fa-lg"></i>
                                        </button>
                                        <button type="button" id="buyer3-unverified" class="btn"
                                            onclick="escrowProgressVerification('buyer', '3', 'Vehicle Verification', 'Un Approved')">
                                            <i class="fal fa-times-circle fa-lg"></i>
                                        </button>
                                    </div>
                                </div>


                            </div>
                        </div>


                        <div class="escrow-process-step-details" data-step="4" style="display: none;">
                            <div class="container d-flex flex-column flex-md-row m-0 p-2"
                                style="border-radius:22px; border:1px solid #3B634C;">

                                <div class="col-10">
                                    <h5>Seller Inspection: <span
                                            class="escrow-inspection-status escrow-warning">Pending</span> </h5>
                                    <p>Please review seller inspection</p>

                                    <div class="d-flex align-items-center my-3" style="gap:10px;">
                                        <span class="escrow-warning px-3 py-1 rounded"> Status: </span>
                                        <button type="button" id="buyer4-verified" class="btn"
                                            onclick="escrowProgressVerification('buyer', '4', 'Seller Inspection', 'Approved')">
                                            <i class="fal fa-check-circle fa-lg"></i>
                                        </button>
                                        <button type="button" id="buyer4-unverified" class="btn"
                                            onclick="escrowProgressVerification('buyer', '4', 'Seller Inspection', 'Un Approved')">
                                            <i class="fal fa-times-circle fa-lg"></i>
                                        </button>
                                    </div>

                                </div>
                                <div class="d-none d-md-block col-md-2">
                                    <?php echo $CORE->LAYOUT("get_logo", "light"); ?>
                                </div>

                            </div>




                        </div>

                        <div class="escrow-process-step-details" data-step="5" style="display: none;">

                            <div class="container d-flex flex-column flex-md-row m-0 p-2"
                                style="border-radius:22px; border:1px solid #3B634C;">

                                <div class="col-md-5 p-0">
                                    <div class="d-flex">
                                        <h5>Delivery Details</h5>
                                        <div class="col-5 col-md-5 align-self-center">
                                            <?php echo $CORE->LAYOUT("get_logo", "light"); ?></div>
                                    </div>

                                    <p>Book Online with TurboBid</p>

                                    <div class="d-flex align-items-center my-3" style="gap:10px;">
                                        <span class="escrow-warning px-3 py-1 rounded"> Status: </span>
                                        <button type="button" id="buyer5-verified" class="btn"
                                            onclick="escrowProgressVerification('buyer', '5', 'Delivery', 'Approved')">
                                            <i class="fal fa-check-circle fa-lg"></i>
                                        </button>
                                        <button type="button" id="buyer5-unverified" class="btn"
                                            onclick="escrowProgressVerification('buyer', '5', 'Delivery', 'Un Approved')">
                                            <i class="fal fa-times-circle fa-lg"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="col-md-7">
                                    <div class="info-section">
                                        <div class="row m-0 align-items-center">
                                            <h5>Info</h5>

                                        </div>

                                        <div class="buyer-delivery-info col-12">
                                            <div class="row mb-2">
                                                <div class="col">Transport Company:</div>
                                                <div class="col">
                                                    <span class="transport-company-text editable-field">James
                                                        Coin</span>

                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">Tracking Number:</div>
                                                <div class="col">
                                                    <span
                                                        class="tracking-number-text editable-field">0987654edfvbn</span>
                                                    >
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">Phone Number:</div>
                                                <div class="col">
                                                    <span class="phone-number-text editable-field">416-265-1074</span>

                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">Pickup Date:</div>
                                                <div class="col">
                                                    <span class="pickup-date-text editable-field">12 July
                                                        2024</span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>

                            </div>

                            <!-- Second block -->



                        </div>

                        <div class="escrow-process-step-details" data-step="6" style="display: none;">
                            <div class="container d-flex flex-column flex-md-row m-0 p-2"
                                style="border-radius:22px; border:1px solid #3B634C;">

                                <div class="col-12">

                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex gap-10">
                                            <h5>Delivery <span
                                                    class="escrow-delivery-status escrow-warning">Pending</span></h5>
                                            <h5>Payment to seller: <span
                                                    class="escrow-payToSeller-status escrow-warning">Pending</span></h5>
                                        </div>
                                        <div class="col-5 col-md-2 align-self-center d-none d-md-block">
                                            <?php echo $CORE->LAYOUT("get_logo", "light"); ?></div>
                                    </div>
                                    <p>Thank you for using TurboBid! Please rate your experience here.</p>

                                    <div class="pt-5 pb-3">

                                        <span class="ammount-release-seller mb-2"></span><br>

                                        <strong>Review tracking details on the TurboBid Dashboard. Payment will be made
                                            to the seller upon delivery.</strong>

                                    </div>

                                </div>

                            </div>


                            <div class="col-12">
                                <div class="d-flex align-items-center my-3" style="gap:10px;">
                                    <span class="escrow-warning px-3 py-1 rounded"> Status: </span>
                                    <button type="button" id="buyer6-verified" class="btn"
                                        onclick="escrowProgressVerification('buyer', '6', 'All Transaction', 'Approved')">
                                        <i class="fal fa-check-circle fa-lg"></i>
                                    </button>
                                    <button type="button" id="buyer6-unverified" class="btn"
                                        onclick="escrowProgressVerification('buyer', '6', 'All Transaction', 'All Cancel')">
                                        <i class="fal fa-times-circle fa-lg"></i>
                                    </button>
                                </div>


                            </div>



                        </div>

                    </div><!-- Buyer all Escrow details close -->



                    <div id="seller-all-escrow-details" class="mt-5">


                        <h6 class="mb-2">Seller Escrow Details:</h6>

                        <div id="seller-progress-container" class="progress-container"></div>

                        <?php if (current_user_can('administrator')) { ?>
                        <div class="my-3">
                            <button onclick="decreaseEscrowStep('seller')" class="btn escrow-warning rounded-pill px-3"
                                id="seller-escrow-step-back" disabled>&larr;
                                Back</button>
                            <button onclick="escrowMakeNextStep('seller')" id="seller-escrow-step-next"
                                class="btn escrow-accepted rounded-pill px-3">Make
                                Complete</button>

                        </div>
                        <?php } ?>


                        <div class="escrow-process-step-details" data-step="1">
                            <div class="container d-flex flex-column flex-md-row m-0 p-2"
                                style="border-radius:22px; border:1px solid #3B634C;">

                                <div class="col-md-9">
                                    <h5>Agreement Created </h5>
                                    <p><span class="escrow-buyer-name text-primary">Buyer (Shirjeel Arshad)</span>is
                                        buying a motor vehicle from
                                        <span class="escrow-seller-name text-primary">Seller(Kenneth Pham)</span>. Buyer
                                        & Seller are both
                                        required to complete the TurboBid AI Damage inspection
                                    </p>

                                    <div class="d-flex align-items-center my-3" style="gap:10px;">
                                        <span class="escrow-warning px-3 py-1 rounded">Status:</span>
                                        <button type="button" id="seller1-verified" class="btn"
                                            onclick="escrowProgressVerification('seller', '1', 'Agreement', 'Verified')">
                                            <i class="fal fa-check-circle fa-lg"></i>
                                        </button>
                                        <button type="button" id="seller1-unverified" class="btn"
                                            onclick="escrowProgressVerification('seller', '1', 'Agreement', 'Un Verified')">
                                            <i class="fal fa-times-circle fa-lg"></i>
                                        </button>
                                    </div>

                                </div>
                                <div class="d-none d-md-block col-md-3 align-self-center">
                                    <?php echo $CORE->LAYOUT("get_logo", "light"); ?>
                                </div>

                            </div>





                        </div>
                        <div class="escrow-process-step-details" data-step="2" style="display: none;">

                            <div class="container d-flex flex-column flex-md-row m-0 p-2"
                                style="border-radius:22px; border:1px solid #3B634C;">

                                <div class="col-md-7">
                                    <h5>Buyer Payment Status: <span
                                            class="escrow-pay-status escrow-warning">Pending</span></h5>

                                    <p>We’ll update this as soon as the buyers payment has been recieved in escrow
                                        account</p>
                                    <br><br>

                                    <h5>Seller Payment Method</h5>

                                    <p>Please complete the disibmursement form & upload a copy of your direct deposit
                                        form to receive your vehicle payment </p>

                                </div>

                                <div class="col-md-5 d-flex flex-column justify-content-between pt-3 pt-md-0">
                                    <div class="d-none d-md-block col-md-6 align-self-end">
                                        <?php echo $CORE->LAYOUT("get_logo", "light"); ?>
                                    </div>
                                    <button type="button" class="btn btn-primary rounded-pill px-5 mr-3"
                                        data-bs-toggle="modal" onclick="jQuery('#popupDisclaimer').fadeIn(400);">Check
                                        out
                                        DP</button>

                                    <div class="d-flex align-items-center my-3" style="gap:10px;">
                                        <span class="escrow-warning px-3 py-1 rounded"> Status: </span>
                                        <button type="button" id="seller2-verified" class="btn"
                                            onclick="escrowProgressVerification('seller', '2', 'Buyer Payment', 'Approved')">
                                            <i class="fal fa-check-circle fa-lg"></i>
                                        </button>
                                        <button type="button" id="seller2-unverified" class="btn"
                                            onclick="escrowProgressVerification('seller', '2', 'Buyer Payment', 'Un Approved')">
                                            <i class="fal fa-times-circle fa-lg"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>






                            <!-- The Modal -->
                            <div class="modal fade" id="bankInfoModal" tabindex="-1"
                                aria-labelledby="bankInfoModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="bankInfoModalLabel">Beneficiary Bank Information
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <!-- Modal Body -->
                                        <div class="modal-body">
                                            <div id="sellerBankInfo">



                                            </div>
                                        </div>

                                        <!-- Modal Footer -->

                                    </div>
                                </div>
                            </div>


                        </div>





                        <div class="escrow-process-step-details" data-step="3" style="display: none;">
                            <div class="container d-flex flex-column flex-md-row m-0 p-2"
                                style="border-radius:22px; border:1px solid #3B634C;">

                                <div class="col-md-10">
                                    <h5>Seller Inspection: <span
                                            class="escrow-inspection-status escrow-warning">Pending</span></h5>
                                    <p>Please conduct the vehicle inspection before it is transported. The buyer will
                                        need to approve the inspection report.</p>

                                    <div class="d-flex align-items-center my-3" style="gap:10px;">
                                        <span class="escrow-warning px-3 py-1 rounded"> Status: </span>
                                        <button type="button" id="seller3-verified" class="btn"
                                            onclick="escrowProgressVerification('seller', '3', 'Seller Inspection', 'Approved')">
                                            <i class="fal fa-check-circle fa-lg"></i>
                                        </button>
                                        <button type="button" id="seller3-unverified" class="btn"
                                            onclick="escrowProgressVerification('seller', '3', 'Seller Inspection', 'Un Approved')">
                                            <i class="fal fa-times-circle fa-lg"></i>
                                        </button>
                                    </div>

                                    <div class="py-5">
                                        <div class="seller-inspection-result"></div>
                                    </div>

                                </div>
                                <div class="d-none d-md-block col-md-2">
                                    <?php echo $CORE->LAYOUT("get_logo", "light"); ?>
                                </div>

                            </div>



                        </div>

                        <div class="escrow-process-step-details" data-step="4" style="display: none;">

                            <div class="container d-flex flex-column flex-md-row m-0 p-2"
                                style="border-radius:22px; border:1px solid #3B634C;">

                                <div class="col-md-5 mb-2 mb-md-0">
                                    <div class="d-flex col-12 p-0">
                                        <h5>Delivery Details</h5>
                                        <div class="col-5 col-md-5 align-self-center">
                                            <?php echo $CORE->LAYOUT("get_logo", "light"); ?></div>
                                    </div>

                                    <p>Please review delivery details for vehicle pick up date.</p>

                                    <div class="d-flex align-items-center my-3" style="gap:10px;">
                                        <span class="escrow-warning px-3 py-1 rounded"> Status: </span>
                                        <button type="button" id="seller4-verified" class="btn"
                                            onclick="escrowProgressVerification('seller', '4', 'Delivery', 'Approved')">
                                            <i class="fal fa-check-circle fa-lg"></i>
                                        </button>
                                        <button type="button" id="seller4-unverified" class="btn"
                                            onclick="escrowProgressVerification('seller', '4', 'Delivery', 'Un Approved')">
                                            <i class="fal fa-times-circle fa-lg"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="col-md-7">
                                    <div class="info-section">
                                        <div class="row m-0 align-items-center">
                                            <h5>Info</h5>

                                        </div>

                                        <div class="buyer-delivery-info col-12">
                                            <div class="row mb-2">
                                                <div class="col">Transport Company:</div>
                                                <div class="col">
                                                    <span class="transport-company-text editable-field">James
                                                        Coin</span>

                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">Tracking Number:</div>
                                                <div class="col">
                                                    <span
                                                        class="tracking-number-text editable-field">0987654edfvbn</span>
                                                    >
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">Phone Number:</div>
                                                <div class="col">
                                                    <span class="phone-number-text editable-field">416-265-1074</span>

                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">Pickup Date:</div>
                                                <div class="col">
                                                    <span class="pickup-date-text editable-field">12 July
                                                        2024</span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>

                            </div>

                            <!-- Second block -->


                        </div>

                        <div class="escrow-process-step-details" data-step="5" style="display: none;">
                            <div class="container d-flex flex-column flex-md-row m-0 p-2"
                                style="border-radius:22px; border:1px solid #3B634C;">

                                <div class="col-12">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex gap-10">
                                            <h5>Delivery <span
                                                    class="escrow-delivery-status escrow-warning">Pending</span></h5>
                                            <h5>Payment <span
                                                    class="escrow-payToSeller-status escrow-warning">Pending</span>
                                            </h5>
                                        </div>
                                        <div class="col-5 col-md-2 p-0 ml-2 align-self-center d-none d-md-block">
                                            <?php echo $CORE->LAYOUT("get_logo", "light"); ?></div>
                                    </div>


                                    <div class="py-3">

                                        <div class="d-flex flex-column flex-md-row gap-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="sellerWireTransfer"
                                                    id="sellerWireTransfer" checked>
                                                <label class="form-check-label" for="sellerWireTransfer">
                                                    Wire Transfer
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="sellerHyperWalletPayment" id="sellerHyperWalletPayment">
                                                <label class="form-check-label" for="sellerHyperWalletPayment">
                                                    Hyperwallet Payment <sub>(falter)</sub> <img class="ml-2"
                                                        src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/image-151.svg" />
                                                </label>
                                            </div>

                                        </div>



                                        <div class="d-flex align-items-center my-3" style="gap:10px;">
                                            <span class="escrow-warning px-3 py-1 rounded"> Status: </span>
                                            <button type="button" id="seller5-verified" class="btn"
                                                onclick="escrowProgressVerification('seller', '5', 'Transaction', 'Approved')">
                                                <i class="fal fa-check-circle fa-lg"></i>
                                            </button>
                                            <button type="button" id="seller5-unverified" class="btn"
                                                onclick="escrowProgressVerification('seller', '5', 'Transaction', 'Cancel')">
                                                <i class="fal fa-times-circle fa-lg"></i>
                                            </button>
                                        </div>

                                    </div>

                                </div>

                            </div>




                        </div>
                    </div><!-- Seller all Escrow details close -->


                    <div class="escrow-entry-transaction-summary mt-3">Transaction Summary</div>

                </div>

                <div class="turbobidescrow-data"></div>

            </div>
        </div>
    </div>


</div>




<script>
// Retrieve values from sessionStorage
var getSellerEmail = sessionStorage.getItem('@escrow-seller-email');
var getBuyerEmail = sessionStorage.getItem('@escrow-buyer-email');

// Function to get the total number of steps for a given type
function getTotalSteps(type) {
    if (type === 'buyer') {
        return parseInt(sessionStorage.getItem('buyer-total-steps-' + getBuyerEmail), 10);
    } else if (type === 'seller') {
        return parseInt(sessionStorage.getItem('seller-total-steps-' + getSellerEmail), 10);
    }
    return 0;
}

// Function to get the current step for a given type
function getCurrentStep(type) {
    if (type === 'buyer') {
        return parseInt(sessionStorage.getItem('buyer-current-step-' + getBuyerEmail), 10);
    } else if (type === 'seller') {
        return parseInt(sessionStorage.getItem('seller-current-step-' + getSellerEmail), 10);
    }
    return 1; // Default step if none found
}

// Function to set the current step for a given type
function setCurrentStep(type, step) {
    if (type === 'buyer') {
        sessionStorage.setItem('buyer-current-step-' + getBuyerEmail, step);
    } else if (type === 'seller') {
        sessionStorage.setItem('seller-current-step-' + getSellerEmail, step);
    }
}

// Function to update the steps and display
function updateEscrowStep(type, step) {
    let totalEscrowSteps = getTotalSteps(type);
    let currentEscrowStep = step;

    console.log('step: ', currentEscrowStep);

    var $steps = jQuery('.' + type + '-step-wrap');
    var $stepDetails = jQuery('#' + type + '-all-escrow-details .escrow-process-step-details');
    var $progressBar = jQuery('#' + type + '-progress');

    $steps.removeClass('active').each(function(index) {
        if (index + 1 <= currentEscrowStep) {
            jQuery(this).addClass('active');
        }
    });

    $stepDetails.hide().filter('[data-step="' + currentEscrowStep + '"]').show();

    var progressWidth = (currentEscrowStep - 1) / (totalEscrowSteps - 1) * 100;
    $progressBar.css('width', progressWidth + '%');

    jQuery('#' + type + '-escrow-step-back').prop('disabled', currentEscrowStep === 1);
    jQuery('#' + type + '-escrow-step-next').text(currentEscrowStep === totalEscrowSteps ? 'All Complete' : 'Next');

}

// Function to move to the next step
function escrowMakeNextStep(type) {
    let currentEscrowStep = getCurrentStep(type);
    let totalEscrowSteps = getTotalSteps(type);
    console.log('user: ', type);

    if (currentEscrowStep < totalEscrowSteps) {
        setCurrentStep(type, currentEscrowStep + 1);
        updateEscrowStep(type, currentEscrowStep + 1);
    }
}

// Function to move to the previous step
function decreaseEscrowStep(type) {
    let currentEscrowStep = getCurrentStep(type);
    let totalEscrowSteps = getTotalSteps(type);

    if (currentEscrowStep > 1) {
        setCurrentStep(type, currentEscrowStep - 1);
        updateEscrowStep(type, currentEscrowStep - 1);
    }
}






jQuery('.escrow-back-main').click(function() {
    jQuery('.escrow-entry-details').addClass('d-none');
    jQuery('.escrow-back-main').addClass('d-none');
    jQuery('.admin-escrow-order-data').removeClass('d-none');
});


function updateUserEscrowEntryCurrentStep(type) {
    var entryId = parseInt(jQuery('#escrow_entry_id').val());
    let currentEscrowStep = getCurrentStep(type);

    if (type === 'seller') {
        var stepMeta = 'seller_escrow_entry_current_step';
    }
    if (type === 'buyer') {
        var stepMeta = 'escrow_entry_current_step';
    }

    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'POST',
        data: {
            action: 'update_entry_step',
            current_step: currentEscrowStep,
            form_id: 318301,
            entry_id: entryId,
            step_meta: stepMeta
        },
        success: function(response) {
            console.log(response);
            if (response.success) {

                if (type === 'seller') {
                    updateEscrowStep(type, currentEscrowStep);
                }
                if (type === 'buyer') {
                    updateEscrowStep(type, currentEscrowStep);
                }

            } else {
                alert('Failed to update step.');
            }
        },
        error: function() {
            alert('An error occurred.');
        }
    });
}






jQuery('.entry-link').on('click', function() {
    var entry_id = jQuery(this).data('entry-id');
    jQuery('#loadingSpinner').show();
    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'POST',
        data: {
            action: 'get_escrow_entry_details',
            entry_id: entry_id
        },
        success: function(response) {
            jQuery('#loadingSpinner').hide();
            jQuery('.admin-escrow-order-data').addClass('d-none');
            jQuery('.escrow-entry-details').removeClass('d-none');
            jQuery('.escrow-back-main').removeClass('d-none');

            if (response.success) {

                var entry = response.data;
                var meta = entry.meta;

                // Extracting formatting results for each calculation
                var calculation1 = parseSerializedPHPData(meta["calculation-1"])[
                    "formatting_result"];
                var calculation4 = parseSerializedPHPData(meta["calculation-5"])[
                    "formatting_result"];
                var calculation5 = parseSerializedPHPData(meta["calculation-5"])[
                    "formatting_result"];
                var calculation2 = parseSerializedPHPData(meta["calculation-2"])[
                    "formatting_result"];
                var calculation3 = parseSerializedPHPData(meta["calculation-3"])[
                    "formatting_result"];

                jQuery('.escrow-entry-title').text(meta['name-1']);
                jQuery('.escrow-entry-id').text(entry.entry_id);
                jQuery('#escrow_entry_id').val(entry.entry_id);
                jQuery('.escrow-buyer-name').html('Buyer (' + meta['email-2'] + ')');
                jQuery('.escrow-seller-name').html('Seller (' + meta['email-1'] + ')');
                jQuery('.escrow-entry-vin').html('VIN: ' + meta['text-11']);
                jQuery('.ammount-release-seller').html('Total Amount Release to seller <strong>' +
                    calculation3 + '</strong>');

                jQuery('#escrow_entry_seller_email').val(meta['email-1']);
                sessionStorage.setItem('@escrow-seller-email', meta['email-1']);

                jQuery('#escrow_entry_seller_phone').val(meta['phone-1']);

                jQuery('#escrow_entry_buyer_email').val(meta['email-2']);
                sessionStorage.setItem('@escrow-buyer-email', meta['email-2']);

                jQuery('#escrow_entry_buyer_phone').val(meta['phone-2']);
                jQuery('#escrow_entry_vehicle_vin').val(meta['text-11']);
                jQuery('#escrow_entry_vehicle_name').val(meta['name-1']);

                jQuery('.escrow-entry-price').html(formatCalCadPrice(meta['currency-1']));
                jQuery('.escrow-entry-subtotal').html(formatCalCadPrice(meta['currency-1']));

                var currency4 = parseFloat(meta['currency-5']);
                var currency2 = parseFloat(meta['currency-2']);

                // Use a fallback of 0 if the result is NaN
                currency4 = isNaN(currency4) ? 0 : currency4;
                currency2 = isNaN(currency2) ? 0 : currency2;

                // Perform the addition
                var shippingSum = currency4 + currency2;

                // Update the HTML content with the sum
                jQuery('.escrow-entry-subtotal').html(formatCalCadPrice(shippingSum));

                jQuery('.escrow-entry-total-price').html(calculation2);

                function formatDate(dateString) {
                    const date = new Date(dateString);

                    const options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: 'numeric',
                        minute: 'numeric',
                        second: 'numeric',
                        timeZoneName: 'short'
                    };

                    return date.toLocaleDateString('en-US', options).replace(', ', ', ');
                }

                // Example usage
                const dateCreated = entry.date_created; // Make sure this is a valid date string
                jQuery('.escrow-entry-submit-date').html(formatDate(dateCreated));


                jQuery('#buyer-progress-container').html(escrowTransBuyerProgress);
                jQuery('#seller-progress-container').html(escrowTransSellerProgress);




                var uniqueId = '@escrowDelivery' + entry_id;

                sessionStorage.setItem(uniqueId, JSON.stringify(entry.delivery_escrow_info));

                deliverySessionResponse(uniqueId);

                if (meta['email-1']) {
                    let sellerTotalEscrowSteps = 5;
                    var sellerStep = entry.seller_escrow_entry_current_step;

                    updateEscrowStep('seller', sellerStep);

                    sessionStorage.setItem('seller-total-steps-' + meta['email-1'],
                        sellerTotalEscrowSteps);

                    sessionStorage.setItem('seller-current-step-' + meta['email-1'],
                        sellerStep);

                    bankDetailsPreview(entry);

                    if (entry.seller_payment_method['Gateway'] == 'Hyperwallet Payment (falter)') {
                        jQuery('#sellerHyperWalletPayment').prop("checked", true);
                        jQuery('#sellerWireTransfer').prop("checked", false);
                    } else if (entry.seller_payment_method['Gateway'] == 'Wire Transfer') {
                        jQuery('#sellerWireTransfer').prop("checked", true);
                        jQuery('#sellerHyperWalletPayment').prop("checked", false);
                    } else {
                        jQuery('#sellerWireTransfer').prop("checked", false);
                        jQuery('#sellerHyperWalletPayment').prop("checked", false);
                    }

                    escrowStatusBasedUpdateInfo(entry.seller_escrow_status.user, entry
                        .seller_escrow_status.step, entry.seller_escrow_status.status);
                }

                if (meta['email-2']) {
                    let buyerTotalEscrowSteps = 6;
                    var buyerStep = entry.escrow_entry_current_step;


                    // console.log('buyer_escrow_status: ', entry.buyer_escrow_status);

                    escrowStatusBasedUpdateInfo(entry.buyer_escrow_status.user, entry
                        .buyer_escrow_status.step, entry.buyer_escrow_status.status);


                    // Container to append the previews
                    var paymentProof = jQuery('#paymentProofPreviewContainer');

                    // Check if there are images and create preview elements
                    if (entry.payment_proof.length > 0) {
                        entry.payment_proof.forEach(function(imageUrl) {
                            var previewElement = createPreviewElement(imageUrl);
                            paymentProof.append(previewElement);
                        });
                    }

                    sessionStorage.setItem('buyer-total-steps-' + meta['email-2'],
                        buyerTotalEscrowSteps);
                    sessionStorage.setItem('buyer-current-step-' + meta['email-2'], buyerStep);

                    updateEscrowStep('buyer', buyerStep);

                }



                var transactionSummary = `
<div class="row justify-content-start align-items-center m-0"><h5 class="mr-2">Transaction Summary</h5> <span class="mr-2">${meta['name-1']}</span> <span>VIN: ${meta['text-11']}</span></div>
<div class="d-flex justify-content-between py-3">Subtotal <span class="cad-price-format">${formatCalCadPrice(meta["currency-1"])}</span></div>
<div class="row border-top m-0">
    <div class="col-12 col-md-6" style="border-right: 1px solid #dee2e6!important;">
        <span class="my-2">For Buyers</span>
        <div class="d-flex justify-content-between">Buyer Price:<span>${formatCalCadPrice(meta["currency-1"])}</span></div>
        <div class="d-flex justify-content-between">Escrow fee paid by:
            <div class="buyer-escrow-fee"><span class="text-primary">${meta["select-16"]}</span> <span class="buyer-fee-cal">${calculation4}</span></div>
        </div>
        <div class="d-flex justify-content-between">Shipping fee paid by:
            <div><span class="text-primary">Buyer</span> <span class="cad-price-format">${formatCalCadPrice(currency4)}</span></div>
        </div>
        <div class="d-flex justify-content-between">Total to be paid by Buyer:<span class="cad-price-format">${calculation2}</span></div>
    </div>
    <div class="col-12 col-md-6">
        <span class="my-2">For Sellers</span>
        <div class="d-flex justify-content-between">Lien Holder Pay Off Fee<span class="cad-price-format">${calculation1}</span></div>
        <div class="d-flex justify-content-between">Escrow fee paid by:
            <div class="seller-escrow-fee"><span class="text-primary">${meta["select-17"]}</span> <span class="seller-fee-cal">${calculation5}</span></div>
        </div>
        <div class="d-flex justify-content-between">Shipping fee paid by:
            <div><span class="text-primary">Seller</span> <span class="cad-price-format">${formatCalCadPrice(currency2)}</span></div>
        </div>
        <div class="d-flex justify-content-between">Seller Proceeds: <span class="cad-price-format">${calculation3}</span></div>
    </div>
</div>
`;
                jQuery('.escrow-entry-transaction-summary').html(transactionSummary);



            } else {
                jQuery('.escrow-entry-details .turbobidescrow-data').html(
                    '<p>Error fetching entry details.</p>');
            }
        },
        error: function() {
            jQuery('.escrow-entry-details .turbobidescrow-data').html(
                '<p>Error fetching entry details.</p>');
        }
    });
});


// Function to create a row element for each bank detail
function createBankDetailRow(label, value) {
    const row = document.createElement('div');
    row.className = 'row my-2';

    const labelCol = document.createElement('div');
    labelCol.className = 'col-4 font-weight-bold';
    labelCol.textContent = label;

    const valueCol = document.createElement('div');
    valueCol.className = 'col-8';
    valueCol.textContent = value;

    row.appendChild(labelCol);
    row.appendChild(valueCol);

    return row;
}

function bankDetailsPreview(entry) {

    // Container to append the information
    var sellerBankDpInfo = jQuery('#popupDisclaimer .modal-body');

    // Append the other bank details row-wise
    var bankDetails = entry.seller_escrow_bank_dp;
    if (bankDetails !== '' || !bankDetails) {
        sellerBankDpInfo.html('<h6 class="mb-3">Disbursement Wire/Bank Transfer information</h6>');
        // Append the bank images at the top
        if (entry.seller_escrow_bank_dp.bank_dp_images.length > 0) {
            entry.seller_escrow_bank_dp.bank_dp_images.forEach(function(imageUrl) {
                var previewElement = createPreviewElement(imageUrl);
                sellerBankDpInfo.append(previewElement);
            });
        }

        sellerBankDpInfo.append(createBankDetailRow('Bank Name:', bankDetails.bank_name));
        sellerBankDpInfo.append(createBankDetailRow('Account Name:', bankDetails.account_name));
        sellerBankDpInfo.append(createBankDetailRow('Account Number:', bankDetails.account_number));
        sellerBankDpInfo.append(createBankDetailRow('Branch Number:', bankDetails.branch_number));
        sellerBankDpInfo.append(createBankDetailRow('FIN Number:', bankDetails.fin_number));
        sellerBankDpInfo.append(createBankDetailRow('SWIFT Code:', bankDetails.swift_code));
        sellerBankDpInfo.append(createBankDetailRow('Address:', bankDetails.address));
        sellerBankDpInfo.append(createBankDetailRow('Country:', bankDetails.country));
        sellerBankDpInfo.append(createBankDetailRow('Currency:', bankDetails.currency));
        sellerBankDpInfo.append(createBankDetailRow('Additional Info:', bankDetails.additional_info));
    } else {
        sellerBankDpInfo.html(
            '<h5 class="my-5"> Seller has not added Disbursement Wire/Bank Transfer information yet! </h5>');
    }
}


function formatCalCadPrice(value) {
    let number = parseFloat(value);
    if (isNaN(number)) return value;
    return 'CA$' + number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}


// Function to parse the serialized PHP data
function parseSerializedPHPData(serializedData) {
    // A simple parsing function (assumes the data is in a consistent format)
    var result = {};
    serializedData.replace(/s:17:"formatting_result";s:\d+:"([^"]+)";/g, function(_,
        formatting_result) {
        result["formatting_result"] = formatting_result;
    });
    return result;
}


// Function to create a preview element
function createPreviewElement(imageUrl) {
    const previewElement = document.createElement('div');
    previewElement.className = 'preview-item card d-flex justify-content-center p-2 m-1 col-4';

    const hrefElement = document.createElement('a');
    hrefElement.href = imageUrl;
    hrefElement.setAttribute('data-toggle', 'lightbox');
    hrefElement.setAttribute('data-type', 'image');

    const imageElement = document.createElement('img');
    imageElement.src = imageUrl;
    imageElement.className = 'img-fluid';
    imageElement.alt = 'Payment Proof';

    hrefElement.appendChild(imageElement);
    previewElement.appendChild(hrefElement);

    return previewElement;
}

// Initialize the lightbox on click
jQuery(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    jQuery(this).ekkoLightbox();
});


var escrowTransBuyerProgress = `

  <div class="progress" id="buyer-progress"></div>
        <div class="buyer-step-wrap step-wrap active" data-step="1">
            <div class="circle"><span class="step-title">1</span></div>
            <p class="text">Agreement</p>
        </div>
        <div class="buyer-step-wrap step-wrap" data-step="2">
            <div class="circle"><span class="step-title">2</span></div>
            <p class="text">Payment</p>
        </div>
        
        <div class="buyer-step-wrap step-wrap" data-step="3">
            <div class="circle"><span class="step-title">3</span></div>
            <p class="text">Vehicle Verification </p>
        </div>
        <div class="buyer-step-wrap step-wrap" data-step="5">
            <div class="circle"><span class="step-title">5</span></div>
            <p class="text">Seller Inspection</p>
        </div>
        <div class="buyer-step-wrap step-wrap" data-step="5">
            <div class="circle"><span class="step-title">5</span></div>
            <p class="text">Delivery</p>
        </div>
       
        <div class="buyer-step-wrap step-wrap" data-step="6">
            <div class="circle"><span class="step-title">6</span></div>
            <p class="text">Seller Payment</p>
        </div>
`;


var escrowTransSellerProgress = `

  <div class="progress" id="seller-progress"></div>
        <div class="seller-step-wrap step-wrap active" data-step="1">
            <div class="circle"><span class="step-title">1</span></div>
            <p class="text">Agreement</p>
        </div>
        <div class="seller-step-wrap step-wrap" data-step="2">
            <div class="circle"><span class="step-title">2</span></div>
            <p class="text">Payment</p>
        </div>
        
        <div class="seller-step-wrap step-wrap" data-step="3">
            <div class="circle"><span class="step-title">3</span></div>
            <p class="text">Seller Inspection</p>
        </div>
        <div class="seller-step-wrap step-wrap" data-step="5">
            <div class="circle"><span class="step-title">5</span></div>
            <p class="text">Delivery</p>
        </div>
       
        <div class="seller-step-wrap step-wrap" data-step="5">
            <div class="circle"><span class="step-title">5</span></div>
            <p class="text">Seller Payment</p>
        </div>
`;




function fetchUserMeta(userEmail, callback) {
    jQuery.ajax({
        url: '<?php echo admin_url("admin-ajax.php"); ?>',
        method: 'POST',
        data: {
            action: 'get_user_meta_by_email',
            user_email: userEmail
        },
        success: function(response) {
            if (response.success) {
                callback(null, response.data.veriff_decision);
            } else {
                callback(response.data, null);
            }
        },
        error: function(error) {
            callback(error, null);
        }
    });
}

// Example usage:
fetchUserMeta(getSellerEmail, function(error, veriffDecision) {
    if (error) {
        console.error("Error fetching seller veriff decision:", error);
    } else {
        //console.log("Seller veriff decision:", veriffDecision);
        // You can now use the veriffDecision value as needed

        console.log("Veriff decision:", veriffDecision);

        if (veriffDecision && veriffDecision.verification.status === "approved") {
            jQuery('#seller1-verified').css({
                'color': '#124326',
                'font-size': '30px'
            });
            jQuery('#seller1-unverified').css({
                'color': '#BC9F4C',
                'font-size': '20px'
            });
        }

    }
});

fetchUserMeta(getBuyerEmail, function(error, veriffDecision) {
    if (error) {
        console.error("Error fetching buyer veriff decision:", error);
    } else {
        //console.log("Buyer veriff decision:", veriffDecision);
        // You can now use the veriffDecision value as needed

        if (veriffDecision && veriffDecision.verification.status === "approved") {
            jQuery('#buyer1-verified').css({
                'color': '#124326',
                'font-size': '30px'
            });
            jQuery('#buyer1-unverified').css({
                'color': '#BC9F4C',
                'font-size': '20px'
            });
        }
    }
});





function escrowStatusBasedUpdateInfo(type, step, status) {
    if (status === 'Approved') {
        // Loop through the steps from 1 to the current step
        for (let i = 1; i <= step; i++) {
            jQuery(`#${type}${i}-verified`).css({
                'color': '#124326',
                'font-size': '30px'
            });
            jQuery(`#${type}${i}-verified i`).removeClass('fal').addClass('fas');
            jQuery(`#${type}${i}-unverified`).css({
                'color': '#BC9F4C',
                'font-size': '20px'
            });
        }

        // Additional action when step 6 is approved
        if (type === 'buyer' && step >= 2) {
            jQuery('.escrow-pay-status').removeClass('escrow-warning').addClass('escrow-accepted')
                .text('Approved');

        }
        if (type === 'buyer' && step >= 5) {
            jQuery('.escrow-delivery-status').removeClass('escrow-warning').addClass(
                'escrow-accepted').text(
                'Approved');
        }
        if (type === 'seller' && step >= 3) {
            jQuery('.escrow-inspection-status').removeClass('escrow-warning').addClass(
                'escrow-accepted').text(
                'Approved');

        }
        if (type === 'seller' && step >= 5) {

            jQuery('.escrow-payToSeller-status').removeClass('escrow-warning').addClass(
                'escrow-accepted').text(
                'Approved');
        }
    }
}



function deliverySessionResponse(id) {

    if (id) {
        var storedData = JSON.parse(sessionStorage.getItem(id));

        jQuery("#step-details .transport-company-text").text(
            storedData.transportCompany
        );
        jQuery("#step-details .tracking-number-text").text(
            storedData.trackingNumber
        );
        jQuery("#step-details .phone-number-text").text(storedData.phoneNumber);
        jQuery("#step-details .pickup-date-text").text(storedData.pickupDate);


    }
}

function escrowProgressVerification(type, step, stepName, status) {
    jQuery('#loadingSpinner').show();
    let storedData = {
        user: type,
        step: step,
        step_name: stepName,
        status: status
    };

    var entryId = jQuery("#escrow_entry_id").val();
    var vehicle_name = jQuery('#escrow_entry_vehicle_name').val();
    var vehicle_vin = jQuery('#escrow_entry_vehicle_vin').val();

    var formData = new FormData();
    formData.append("action", "add_additional_escrow_info");
    formData.append("form_id", 318301); // Replace with your form ID
    formData.append("entry_id", entryId); // Replace with your entry ID
    formData.append("data_meta", type + "_escrow_step_status");
    formData.append('form_name', 'Escrow Step Status');
    formData.append('form_title', 'Escrow ' + stepName + ' Status ' + status + ' for ' + vehicle_name);
    if (type === 'buyer') {
        formData.append('escrow_buyer_email', getBuyerEmail);
    } else {
        formData.append('escrow_seller_email', getSellerEmail);
    }
    formData.append('vehicle_name', vehicle_name);
    formData.append('vehicle_vin', vehicle_vin);
    formData.append("additional_info", JSON.stringify(storedData));

    // Call the function and handle the response
    addAdditionalEntryData(formData)
        .done(function(res) {
            jQuery('#loadingSpinner').hide();
            // Handle the response from the AJAX call
            if (res.success) {
                console.log(res.data);
                // Dynamically access the response data based on the type
                var statusKey = type + '_escrow_step_status';
                if (res.data[statusKey] !== "") {
                    var statusValue = res.data[statusKey]['status'];
                    // Update the button color based on the status
                    if (statusValue === 'Approved') {
                        jQuery('#' + type + step + '-verified').css({
                            'color': '#124326',
                            'font-size': '30px'
                        });
                        jQuery('#' + type + step + '-unverified').css({
                            'color': '#BC9F4C',
                            'font-size': '20px'
                        });

                        // Additional action when step 6 is approved
                        if (type === 'buyer' && step >= 2) {
                            jQuery('.escrow-pay-status').removeClass('escrow-warning').addClass('escrow-accepted')
                                .text('Approved');

                        }
                        if (type === 'buyer' && step >= 5) {
                            jQuery('.escrow-delivery-status').removeClass('escrow-warning').addClass(
                                'escrow-accepted').text(
                                'Approved');
                        }
                        if (type === 'seller' && step >= 3) {
                            jQuery('.escrow-inspection-status').removeClass('escrow-warning').addClass(
                                'escrow-accepted').text(
                                'Approved');

                        }
                        if (type === 'seller' && step >= 5) {

                            jQuery('.escrow-payToSeller-status').removeClass('escrow-warning').addClass(
                                'escrow-accepted').text(
                                'Approved');
                        }

                    } else if (statusValue === 'Un Approved') {
                        jQuery('#' + type + step + '-unverified').css({
                            'color': '#BC9F4C',
                            'font-size': '30px'
                        });
                        jQuery('#' + type + step + '-verified').css({
                            'color': '#124326',
                            'font-size': '20px'
                        });
                    }
                }
            } else {
                alert("Error updating status: " + res.data);
            }
        })
        .fail(function(error) {
            console.error("Error:", error);
            alert("Error updating status.");
        });
}

function addAdditionalEntryData(formData) {
    return jQuery.ajax({
        url: '<?php echo admin_url("admin-ajax.php"); ?>',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false
    });
}
</script>




<style>
.turbobidescrow-child {
    height: 139px;
    width: 116px;
    position: relative;
    padding: 20px;
    background: white;
    border-radius: 20px;
}

.turbobid-escrow-services {
    margin: 0;
    flex: 1;
    position: relative;
    font-size: inherit;
    font-weight: 600;
    font-family: inherit;
    display: inline-block;
    max-width: 100%;
    color: #BF9B3E;
}

.turbobid-escrow-services-wrapper {
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    justify-content: flex-start;
    padding: 0 5px;
    box-sizing: border-box;
    max-width: 100%;
}

.the-lien-payoff {
    position: relative;
    font-weight: 600;
    display: inline-block;
    max-width: 100%;
}

.turbobid-will-assist-container {
    flex: 1;
    position: relative;
    display: inline-block;
    max-width: 100%;
}

.frame-parent,
.lien-service {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    max-width: 100%;
}

.payoff-assistance {
    padding: 0 0 0 var(--padding-9xs);
    box-sizing: border-box;
    font-size: var(--font-size-sm);
    color: var(--color-darkslategray-300);
    font-family: var(--font-inter);
}

.frame-parent,
.lien-service {
    flex-direction: column;
}

.lien-service {
    gap: 7px;
    font-size: 18px;
    color: #000;
}

.frame-parent {
    gap: var(--gap-8xl);
}

.turbobidescrow,
.turbobidescrow-inner {
    max-width: 100%;
    display: flex;
    box-sizing: border-box;
}

.turbobidescrow-inner {
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-end;
    padding: 0 0 13px;
    text-align: left;
    font-size: 20px;
    font-family: "Plus Jakarta Sans";
}

.turbobidescrow {
    border-radius: 22px;
    flex-direction: row;
    align-items: flex-end;
    justify-content: flex-start;
    padding: 20px 16px;
    gap: 31px;
    line-height: normal;
    letter-spacing: normal;
}

.turbobidescrow.escrow-bg-green {
    background: linear-gradient(180deg, #ecf7ed, #eef4e2);

}

@media screen and (max-width: 925px) {
    .turbobidescrow {
        flex-wrap: wrap;
    }
}

@media screen and (max-width: 700px) {
    .turbobidescrow {
        gap: var(--gap-mini);
    }
}

@media screen and (max-width: 450px) {
    .turbobid-escrow-services {
        font-size: var(--font-size-lg);
    }
}
</style>

<style>
.custom-file-drop {
    border: 1px dashed #eee;
    border-radius: 10px;
    padding: 10px;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.3s;
    background: #f8f9fa;
}

.custom-file-drop.dragover {
    border-color: #0056b3;
}

.custom-file-drop input[type="file"] {
    display: none;
}

.preview-item img {
    max-width: 100%;
    height: auto;
}

.remove-button {
    margin-top: 10px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 3px;
    padding: 5px 10px;
    cursor: pointer;
}


.escrow-pay-status,
.escrow-delivery-status,
.escrow-inspection-status {
    text-align: center;
    font-family: Inter;
    font-size: 12px;
    font-weight: 400;
    padding: 2px 5px;
    border-radius: 99px;
}

.escrow-warning {
    color: #B99D4B;
    border: 1px solid #B99D4B;
    background: rgba(185, 157, 75, 0.20);
    color: #BF9B3E;
}

.escrow-accepted {
    border: 1px solid #4bb96c;
    background: rgb(75 185 113 / 20%);
    color: #3ebf4b;
}
</style>



<style>
.custom-file-drop {
    border: 1px dashed #eee;
    border-radius: 10px;
    padding: 10px;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.3s;
    background: #f8f9fa;
}

.custom-file-drop.dragover {
    border-color: #0056b3;
}

.custom-file-drop input[type="file"] {
    display: none;
}

.preview-item img {
    max-width: 100%;
    height: auto;
}

.remove-button {
    margin-top: 10px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 3px;
    padding: 5px 10px;
    cursor: pointer;
}


.escrow-payToSeller-status,
.escrow-pay-status,
.escrow-delivery-status,
.escrow-inspection-status {
    text-align: center;
    font-family: Inter;
    font-size: 12px;
    font-weight: 400;
    padding: 2px 5px;
    border-radius: 99px;
}

.escrow-warning {
    color: #B99D4B;
    border: 1px solid #B99D4B;
    background: rgba(185, 157, 75, 0.20);
    color: #BF9B3E;
}

.escrow-accepted {
    border: 1px solid #4bb96c;
    background: rgb(75 185 113 / 20%);
    color: #3ebf4b;
}

.gap-10 {
    gap: 10px;
}

.form-check {
    display: flex;
    align-items: center;
}

.form-check-label {
    padding-left: 30px;
}
</style>