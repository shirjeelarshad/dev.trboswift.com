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
$form_id = 324878; // Replace with your specific Forminator form ID
$meta_key = 'hidden-3'; // user meta specific meta key
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
}
?>




<div class="admin-finance-order-data">


    <div class="card-body p-0">
        <?php if (!empty($filtered_entries)) { ?>
        <div class="overflow-auto">
            <div class="table small table-orders">
                <div class="overflow-scroll">
                    <div class="d-flex"
                        style=" margin-bottom:5px; color: #909090; font-family: Inter; font-style: normal; font-weight: 400;">
                        <div class="col"><?php echo __("ID", "premiumpress"); ?></div>
                        <div class="col-3"><?php echo __("Title", "premiumpress"); ?></div>
                        <div class="col"><?php echo __("Created", "premiumpress"); ?></div>
                        <div class="col"><?php echo __("VIN", "premiumpress"); ?></div>
                        <div class="col"><?php echo __("SIN", "premiumpress"); ?></div>
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
                            <a class="text-dark finance-entry-link" href="javascript:void(0)"
                                data-entry-id="<?php echo $entry->entry_id; ?>">
                                #<?php echo $entry->entry_id; ?>
                            </a>
                        </div>
                        <div class="col-3">
                            <?php echo isset($meta_data['select-1']) ? esc_html($meta_data['select-1'] . ' ' . $meta_data['text-14'] . ' ' . $meta_data['select-2'] ) : ''; ?>

                        </div>
                        <div class="col">
                            <?php echo esc_html(hook_date($entry->date_created)); ?>
                        </div>
                        <div class="col">
                            <?php echo isset($meta_data['text-13']) ? esc_html($meta_data['text-13']) : ''; ?>
                        </div>
                        <div class="col">
                            <?php echo isset($meta_data['text-4']) ? esc_html($meta_data['text-4']) : ''; ?>
                        </div>
                        <div class="col">
                            <div style="background:#ECFDF3; color:#027A48; padding:5px 10px; border-radius:50px">
                                Awaiting</div>
                        </div>

                        <div class="col">
                            <a class="text-dark finance-entry-link" href="javascript:void(0)"
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





<div class="finance-entry-details mt-3 d-none">



    <div class="turbobidfinance finance-bg-green mb-2 position-relative">
        <img class="turbobidfinance-child" loading="lazy" alt="turbobid finance icon"
            src="<?php echo home_url(); ?>/wp-content/uploads/2024/07/Vector-2.svg" />
        <button type="button" class="finance-back-main btn btn-light d-none rounded-pill"
            style="position: absolute; right: 30px; top: 15px;"><i class="fal fa-times"></i></button>

        <section class="turbobidfinance-inner col-6">
            <div class="frame-parent">
                <div class="turbobid-finance-services-wrapper">
                    <h3 class="turbobid-finance-services">Financing</h3>
                </div>
                <div class="lien-service">
                    <div class="the-lien-payoff">
                        Any Vehicle, Any Marketplace

                    </div>
                </div>
            </div>
        </section>
        <div class="col d-flex justify-content-end align-items-end ">
            <img loading="lazy" alt="turbobid financing icon" style="width:150px; object-fit:contain"
                src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/cardblue.svg" />
        </div>
    </div>



    <div class="bg-white p-3 mb-2" style="border-radius:22px;">
        <div class="mb-3">
            <div class="d-flex flex-column flex-md-row justify-content-between mb-1">
                <div class="finance-entry-title h6">Tesla Model 3</div>
                <div class="text-md-right">Transaction #<span class="finance-entry-id">9865445678556</span><i
                        class="fal fa-copy ml-1"></i></div>
            </div>
            <span class="text-primary small">TurboBid offers secure finance services, ensuring payment protection,
                instant lien checks, and fraud prevention for vehicle transactions.</span>
        </div>



        <div class="financing-process mb-3">

            <div class="container mb-4">
                <div class="progress-container">
                    <div class="progress" id="financing-progress-bar"></div>

                    <div class="finance-step-wrap step-wrap active" data-step="1">
                        <div class="circle"><span class="step-title">1</span></div>
                        <p class="text">Application</p>
                    </div>
                    <div class="finance-step-wrap step-wrap" data-step="2">
                        <div class="circle"><span class="step-title">2</span></div>
                        <p class="text">Decision</p>
                    </div>
                    <div class="finance-step-wrap step-wrap" data-step="3">
                        <div class="circle"><span class="step-title">3</span></div>
                        <p class="text">Identity Verification</p>
                    </div>
                    <div class="finance-step-wrap step-wrap" data-step="4">
                        <div class="circle"><span class="step-title">4</span></div>
                        <p class="text">Paperwork</p>
                    </div>
                    <div class="finance-step-wrap step-wrap" data-step="5">
                        <div class="circle"><span class="step-title">5</span></div>
                        <p class="text">Prepare for delivery</p>
                    </div>
                    <div class="finance-step-wrap step-wrap" data-step="6">
                        <div class="circle"><span class="step-title">6</span></div>
                        <p class="text">Vehicle delivery & Payment</p>
                    </div>
                </div>
                <div>



                    <?php if (current_user_can('administrator')) { ?>
                    <button onclick="decreaseFinanceStep()" class="btn btn-primary rounded-pill px-3"
                        id="finance-step-back" disabled>&larr;
                        Back</button>
                    <button onclick="financeMakeNextStep()" class="btn btn-secondary rounded-pill px-3"
                        id="finance-step-next">Next</button>
                    <?php } ?>
                </div>

            </div>



            <div>
                <input type="hidden" id="finance_entry_id" value="123">
                <input type="hidden" id="finance_entry_vehicle_vin" value="VIN11">
                <input type="hidden" id="finance_entry_vehicle_name" value="LAND ROVER">
                
                <input type="hidden" id="finance_pickup_id" value="123">

            </div>



            <div id="all-finance-details" class="mb-3">



                <div class="financing-process-step-details" data-step="1">
                    <div class="container row m-0 p-2" style="border-radius:22px; border:1px solid #3B634C;">

                        <div class="col-12">

                            <div class="row mx-0 gap-2 my-2 align-items-center">
                                <h5 class="col-md-9">Thank you for applying with TurboBid, We're currently reviewing
                                    your
                                    application</h5>
                                <div class="col-3  d-none d-md-block">
                                    <?php echo $CORE->LAYOUT("get_logo", "light"); ?></div>
                            </div>

                            <div><button onclick="financeProgressVerification('1', 'Application', 'Unapproved')"
                                    id="finance-1-unverified"
                                    class="btn finance-warning rounded-pill px-4">Cancel</button>
                                <button onclick="financeProgressVerification('1', 'Application', 'Approved')"
                                    id="finance-1-verified" class="btn finance-accepted rounded-pill px-4">Make
                                    Approved</button>
                            </div>

                        </div>
                    </div>


                    <div class="financing-item-details bg-light p-3 mt-2" style="border-radius:22px;"></div>



                </div>
                <div class="financing-process-step-details" data-step="2" style="display: none;">

                    <div class="container row m-0 p-2" style="border-radius:22px; border:1px solid #3B634C;">

                        <div class="row mx-0 my-2 align-items-center">
                            <h5 class="applicationDecision">Decision:Approved</h5>
                            <div class="col-3 d-none d-md-block"><?php echo $CORE->LAYOUT("get_logo", "light"); ?>
                            </div>
                        </div>


                        <p>Congratulations on receiving your financing approval! Please take a moment to review the
                            terms, interest rate, and all details before proceeding.</p>

                        <div><button onclick="financeProgressVerification('2', 'Application', 'Unapproved')"
                                id="finance-2-unverified" class="btn finance-warning rounded-pill px-4">Cancel</button>
                            <button onclick="financeProgressVerification('2', 'Application', 'Approved')"
                                id="finance-2-verified" class="btn finance-accepted rounded-pill px-4">Make
                                Approved</button>
                        </div>



                    </div>

                    <div class="financing-item-details bg-light p-3 mt-2" style="border-radius:22px;"></div>

                </div>
                <div class="financing-process-step-details" data-step="3" style="display: none;">
                    <div class="container row m-0 p-2" style="border-radius:22px; border:1px solid #3B634C;">

                        <div class="col-12">

                            <div class="row mx-0 gap-2 my-2 align-items-center">
                                <h5>Please complete the TurboBid KYC identity verification process.</h5>
                                <div class="col-3 d-none d-md-block">
                                    <?php echo $CORE->LAYOUT("get_logo", "light"); ?></div>
                            </div>
                            <p>Capture a photo of your drivers license along with a simple selfie. You can do this
                                using either a smartphone or a web browser.We’ll need to use to register the
                                vehicle.</p>


                            <button id="finance-3-verified" class="btn finance-warning rounded-pill px-4">Un
                                Verified</button>

                        </div>
                    </div>

                    <div class="financing-item-details bg-light p-3 mt-2" style="border-radius:22px;"></div>

                </div>
                <div class="financing-process-step-details" data-step="4" style="display: none;">
                    <div class="container row m-0 p-2" style="border-radius:22px; border:1px solid #3B634C;">

                        <div class="col-12">

                            <div class="row mx-0 gap-2 my-2 align-items-center">
                                <h5>Please review and complete the paperwork</h5>
                                <div class="col-3 d-none d-md-block">
                                    <?php echo $CORE->LAYOUT("get_logo", "light"); ?></div>
                            </div>


                            <p>Congratulations on receiving your financing approval! Please take a moment to review
                                the terms, interest rate, and all details before signing.</p>

                            <div><button onclick="financeProgressVerification('4', 'Application', 'Unapproved')"
                                    id="finance-4-unverified"
                                    class="btn finance-warning rounded-pill px-4">Cancel</button>
                                <button onclick="financeProgressVerification('4', 'Application', 'Approved')"
                                    id="finance-4-verified" class="btn finance-accepted rounded-pill px-4">Make
                                    Approved</button>
                            </div>

                        </div>
                    </div>

                    <div class="financing-item-details bg-light p-3 mt-2" style="border-radius:22px;"></div>

                </div>
                <div class="financing-process-step-details" data-step="5" style="display: none;">
                    <div class="container m-0 p-2" style="border-radius:22px; border:1px solid #3B634C;">

                        <div class="row mx-0 gap-2 my-2 align-items-center">
                            <h5 class="mb-2">Payment will be issued to seller at vehicle drop off location</h5>
                            <div class="col-3 d-none d-md-block"><?php echo $CORE->LAYOUT("get_logo", "light"); ?>
                            </div>
                        </div>
                        <div>
                            <p>The seller will receive payment upon delivery of the vehicle. Please book a time to
                                pick up the vehicle
                            </p>
                            
                         
           <div class="row mb-2">
            <div class="col-3">Location:</div>
            <div class="col">
                <span id="finance-location-text" class="editable-field"></span>
                <input type="text" id="finance-location-input" class="form-control rounded-pill d-none" value="0987654edfvbn">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-3">Date time:</div>
            <div class="col">
                <span id="finance-pickup-date-text" class="editable-field"></span>
                <?php
                $twenty_years_later = date('Y-m-d H:i:s', strtotime('+20 years', strtotime(current_time('mysql'))));
                ?>
                <input type="datetime-local" id="finance-pickup-date-input" class="form-control rounded.pill d-none" value="<?php echo current_time('mysql') ?>" min="<?php echo current_time('mysql') ?>"
  max="<?php echo $twenty_years_later; ?>">
            </div>
        </div>
                            
                        </div>
                        
                        <br>
                        
                        <div><button onclick="financeProgressVerification('5', 'Application', 'Unapproved')"
                                id="finance-5-unverified" class="btn finance-warning rounded-pill px-4">Cancel</button>
                            <button onclick="financeProgressVerification('5', 'Application', 'Approved')"
                                id="finance-5-verified" class="btn finance-accepted rounded-pill px-4">Make
                                Approved</button>
                        </div>

                    </div>

                    <!-- Second block -->
                    <div class="financing-item-details bg-light p-3 mt-2" style="border-radius:22px;"></div>


                </div>
                <div class="financing-process-step-details" data-step="6" style="display: none;">
                    <div class="container row m-0 p-2" style="border-radius:22px; border:1px solid #3B634C;">

                        <div class="col-12">
                            <div class="row mx-0 gap-2 my-2 align-items-center">
                                <h5>Vehicle Delivery & Payment </h5>
                                <div class="col-3 d-none d-md-block">
                                    <?php echo $CORE->LAYOUT("get_logo", "light"); ?></div>
                            </div>
                            <p>Payment will be issued upon vehicle drop off <br>
                            </p>
                            
                             <div class="row"> 
                               <div class="col-3"><strong>Location:</strong></div>
            					<div class="col">
                <span class="finance-location-text editable-field"></span> 									</div> </div>
                				<div class="row"> 
                               <div class="col-3"><strong>Time:</strong></div>
            					<div class="col">
                <span class="finance-timeslot-text editable-field"></span> 									</div> </div>

                            <div class="pt-5"><button onclick="financeProgressVerification('6', 'Application', 'Unapproved')"
                                    id="finance-6-unverified"
                                    class="btn finance-warning rounded-pill px-4">Cancel</button>
                                <button onclick="financeProgressVerification('6', 'Application', 'Approved')"
                                    id="finance-6-verified" class="btn finance-accepted rounded-pill px-4">Make
                                    Approved</button>
                            </div>

                        </div>
                    </div>

                    <div class="financing-item-details bg-light p-3 mt-2" style="border-radius:22px;"></div>

                </div>




            </div>


        </div>
    </div>
</div>




<script>
// Retrieve values from sessionStorage
var getFinanceEmail = sessionStorage.getItem('@finance-user-email');
var getFinanceId = sessionStorage.getItem('@finance-entry-id');


// Function to get the current step for a given type
function getFinanceCurrentStep() {

    return parseInt(sessionStorage.getItem('finance-' + getFinanceId + '-step-' + getFinanceEmail), 10);

}

// Function to set the current step for a given type
function setFinanceCurrentStep(step) {

    sessionStorage.setItem('finance-' + getFinanceId + '-step-' + getFinanceEmail, step);

}

// Function to update the steps and display
function updateFinanceStep(step) {
    let totalFinanceSteps = 6;
    let currentFinanceStep = step;

    //console.log('step: ', currentFinanceStep);

    var $steps = jQuery('.finance-step-wrap');
    var $stepDetails = jQuery('#all-finance-details .financing-process-step-details');
    var $progressBar = jQuery('#financing-progress-bar');

    $steps.removeClass('active').each(function(index) {
        if (index + 1 <= currentFinanceStep) {
            jQuery(this).addClass('active');
        }
    });

    $stepDetails.hide().filter('[data-step="' + currentFinanceStep + '"]').show();

    var progressWidth = (currentFinanceStep - 1) / (totalFinanceSteps - 1) * 100;
    $progressBar.css('width', progressWidth + '%');

    jQuery('#finance-step-back').prop('disabled', currentFinanceStep === 1);
    jQuery('#finance-step-next').text(currentFinanceStep === totalFinanceSteps ? 'All Complete' : 'Next');

}

// Function to move to the next step
function financeMakeNextStep() {
    let currentFinanceStep = getFinanceCurrentStep();
    // console.log('currentFinanceStep:', currentFinanceStep);
    let totalFinanceSteps = 6;

    if (currentFinanceStep < totalFinanceSteps) {
        setFinanceCurrentStep(currentFinanceStep + 1);
        updateFinanceStep(currentFinanceStep + 1);
    }
}

// Function to move to the previous step
function decreaseFinanceStep() {
    let currentFinanceStep = getFinanceCurrentStep();
    let totalFinanceSteps = 6;

    if (currentFinanceStep > 1) {
        setFinanceCurrentStep(currentFinanceStep - 1);
        updateFinanceStep(currentFinanceStep - 1);
    }
}






jQuery('.finance-back-main').click(function() {
    jQuery('.finance-entry-details').addClass('d-none');
    jQuery('.finance-back-main').addClass('d-none');
    jQuery('.admin-finance-order-data').removeClass('d-none');
});


function updateUserFinanceEntryCurrentStep() {

    let currentFinanceStep = currentFinanceStep();


    var stepMeta = 'finance_entry_current_step';


    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'POST',
        data: {
            action: 'update_entry_step',
            current_step: currentFinanceStep,
            form_id: 318301,
            entry_id: getFinanceId,
            step_meta: stepMeta
        },
        success: function(response) {
            // console.log(response);
            if (response.success) {


                updateFinanceStep(currentFinanceStep);


            } else {
                alert('Failed to update step.');
            }
        },
        error: function() {
            alert('An error occurred.');
        }
    });
}






jQuery('.finance-entry-link').on('click', function() {
    var entry_id = jQuery(this).data('entry-id');
    jQuery('#loadingSpinner').show();
    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'POST',
        data: {
            action: 'get_admin_finance_details',
            entry_id: entry_id
        },
        success: function(response) {
            jQuery('#loadingSpinner').hide();
            jQuery('.admin-finance-order-data').addClass('d-none');
            jQuery('.finance-entry-details').removeClass('d-none');
            jQuery('.finance-back-main').removeClass('d-none');

            if (response.success) {

                var entry = response.data;
                var meta = entry.meta;
                sessionStorage.setItem('@finance-entry-id', entry.entry_id);

                sessionStorage.setItem('@finance-user-email', meta['email-1']);


                jQuery('.finance-entry-title').text(meta['text-1']);
                jQuery('.finance-entry-id').text(entry.entry_id);

                jQuery('.finance-entry-vin').html('VIN: ' + meta['text-11']);

                jQuery("#finance_pickup_id").val('pickup-' + entry.entry_id);
                jQuery("#finance_entry_vehicle_name").val(`${meta['select-1']}  ${meta['text-14']} ${meta['select-2']}`);
                jQuery("#finance_entry_vehicle_vin").val(meta['text-13']);
                




financePickupSessionResponse(entry.finance_pickup_info);


                

                // Example usage
                const dateCreated = entry.date_created; // Make sure this is a valid date string
                jQuery('.finance-entry-submit-date').html(formatDate(dateCreated));



                if (meta['email-1']) {
                    var financeStep = entry.entry_current_step;


                    sessionStorage.setItem('finance-' + getFinanceId + '-step-' + meta['email-1'],
                        financeStep);

                    updateFinanceStep(financeStep);

                    financeItemDetails(meta);

                    if (financeStep === 3) {
                        fetchUserVeriffStatus(meta['email-1'], function(error, veriffDecision) {
                            if (error) {
                                console.log("Error fetching buyer veriff decision:", error);
                            } else {
                                userVeriffDecision(veriffDecision);
                            }
                        });

                    }

                    if (entry.finance_step_status.step !== '') {
                        financeStatusBasedUpdateInfo(entry.finance_step_status.step, entry
                            .finance_step_status
                            .status);
                    }

                }


            } else {
                jQuery('.finance-entry-details').html(
                    '<p>Error fetching entry details.</p>');
            }
        },
        error: function() {
            jQuery('.finance-entry-details').html(
                '<p>Error fetching entry details.</p>');
        }
    });
});


function userVeriffDecision(veriffDecision) {
    if (veriffDecision.verification.status === "approved") {
        financeStatusBasedUpdateInfo(3, 'Approved');
    }
}

function financeItemDetails(meta) {
    var applicationDetails = `

                            <div class="h6"><i class="far fa-file"></i> Item details</div>
                            <h6 class="mb-2">${meta['select-1']} ${meta['text-14']} ${meta['select-2']}</h6>
                            <strong>VOI (Vehicle of interest)</strong>
                            <div class="d-flex justify-content-between text-dark"><span>
                                    ${meta['text-1']}</span> </div>
                           
                            <div class="d-flex justify-content-between text-dark"><span class="financing-entry-vin">Marketplace Link:
                                    ${meta['url-1']}</span></div>
                            <div class="d-flex justify-content-between text-dark"><span>VIN:
                                    ${meta['text-13']}</span></div>
                                    
                            <strong>Applicants Personal Information
</strong>
                            <div class="d-flex justify-content-between text-dark"><span>Name: ${meta['name-1']} ${meta['name-2']}</span></div>
                            
                            <div class="d-flex justify-content-between text-dark"><span>Email: ${meta['email-1']}</span></div>
                            
                            <div class="d-flex justify-content-between text-dark"><span>Phone: ${meta['phone-1']}</span> <span>Mobile: ${meta['phone-2']}</span> <span>Work: ${meta['phone-3']}</span></div>
                           
                            <div class="d-flex justify-content-between text-dark"><span>SIN: ${meta['text-4']}</span> </div>
                          

`;
    jQuery('.financing-item-details').html(applicationDetails);
}


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

function financeDetailsPreview(entry) {

    // Container to append the information
    var sellerBankDpInfo = jQuery('#popupDisclaimer .modal-body');

    // Append the other bank details row-wise
    var bankDetails = entry.seller_finance_bank_dp;
    if (bankDetails !== '' || !bankDetails) {
        sellerBankDpInfo.html('<h6 class="mb-3">Disbursement Wire/Bank Transfer information</h6>');
        // Append the bank images at the top
        if (entry.seller_finance_bank_dp.bank_dp_images.length > 0) {
            entry.seller_finance_bank_dp.bank_dp_images.forEach(function(imageUrl) {
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







function fetchUserVeriffStatus(userEmail, callback) {
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









function financeStatusBasedUpdateInfo(step, status) {
    if (status === 'Approved') {
        // Loop through the steps from 1 to the current step
        for (let i = 1; i <= step; i++) {
            jQuery('#finance-' + i + '-verified').removeClass('finance-warning').addClass('finance-accepted').text(
                'Approved').prop('disabled',
                true);
            jQuery('#finance-' + i + '-unverified').removeClass('finance-accepted').addClass('finance-warning').text(
                'Make Cancel').prop(
                'disabled', false);
            if (i >= 3) {
                jQuery('#finance-3-verified').removeClass('finance-warning').addClass('finance-accepted')
                    .text(
                        'Verified').prop('disabled',
                        false);
            } else {
                jQuery('#finance-3-verified').addClass('finance-warning').removeClass('finance-accepted').text(
                    'Un Verified').prop('disabled',
                    false);
            }

        }

        // Additional action when step 6 is approved
        if (step >= 1) {
            jQuery('.applicationDecision').text('Decision:Approved');
        }



    }

    if (status === "Unapproved") {
        for (let i = 1; i <= step; i++) {
            jQuery('#finance-' + i + '-unverified').removeClass('finance-warning').addClass('finance-accepted').text(
                'Canceled').prop(
                'disabled', true);
            jQuery('#finance-' + i + '-verified').removeClass('finance-accepted').addClass('finance-warning').text(
                'Make Approved').prop('disabled',
                false);
            if (i >= 3) {
                jQuery('#finance-3-verified').addClass('finance-warning').removeClass('finance-accepted').text(
                    'Un Verified').prop('disabled',
                    false);
            }
        }

        // Additional action when step 6 is approved

        if (step >= 1) {
            jQuery('.applicationDecision').text('Decision:Canceled');
        }

    }
}




function financeProgressVerification(step, stepName, status) {
    jQuery('#loadingSpinner').show();
    let storedData = {
        step: step,
        step_name: stepName,
        status: status
    };


    var vehicle_name = jQuery('#finance_entry_vehicle_name').val();
    var vehicle_vin = jQuery('#finance_entry_vehicle_vin').val();

    var formData = new FormData();
    formData.append("action", "add_additional_escrow_info");
    formData.append("form_id", 324878); // Replace with your form ID
    formData.append("entry_id", getFinanceId); // Replace with your entry ID
    formData.append("data_meta", "finance_step_status");
    formData.append('form_name', 'Finance Step Status');
    formData.append('form_title', 'Finance ' + stepName + ' Status ' + status + ' for ' + vehicle_name);

    formData.append('finance_buyer_email', getFinanceEmail);

    formData.append('vehicle_name', vehicle_name);
    formData.append('vehicle_vin', vehicle_vin);
    formData.append("additional_info", JSON.stringify(storedData));

    // Call the function and handle the response
    addAdditionalEntryData(formData)
        .done(function(res) {
            jQuery('#loadingSpinner').hide();
            // Handle the response from the AJAX call
            if (res.success) {
                //console.log(res.data);
                // Dynamically access the response data based on the type
                var statusKey = 'finance_step_status';
                if (res.data[statusKey] !== "") {
                    var statusValue = res.data[statusKey]['status'];
                    // Update the button color based on the status

                    financeStatusBasedUpdateInfo(step, statusValue);


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








    jQuery('#book-timeslot').on('click', function() {
    
        var isEditing = jQuery(this).text() === 'Update';
        var uniqueId = jQuery('#finance_pickup_id').val();

        if (isEditing) {
        jQuery('#book-timeslot').removeClass('btn-secondary').addClass('btn-outline-secondary');
        
        
            // Save data and change back to plain text
            var location = jQuery('#finance-location-input').val();
            var pickupDate = jQuery('#finance-pickup-date-input').val();
            
            var formattedDate = formatDate(pickupDate);

            jQuery('#finance-location-text').text(location).removeClass('d-none');
            jQuery('#finance-pickup-date-text').text(formattedDate).removeClass('d-none');

            jQuery('#finance-location-input').addClass('d-none');
            jQuery('#finance-pickup-date-input').addClass('d-none');

            // Store data in sessionStorage
            sessionStorage.setItem(uniqueId, JSON.stringify({
                location: location,
                pickupDate: formattedDate
            }));
            
            addNewPickUpInfo();

            // Change button text back to "Edit"
            jQuery(this).text('Book Timeslot');
        } else {
        jQuery('#edit-buyer-escrow-delivery').addClass('btn-outline-secondary');
        jQuery('#edit-buyer-escrow-delivery').removeClass('btn-secondary');
            // Change to input fields and allow editing
            jQuery('#finance-location-text').addClass('d-none');
            jQuery('#finance-pickup-date-text').addClass('d-none');

            jQuery('#finance-location-input').removeClass('d-none');
            jQuery('#finance-pickup-date-input').removeClass('d-none');

            // Change button text to "Update"
            jQuery(this).text('Update');
        }
    });



 function addNewPickUpInfo(){
    var uniqueId = jQuery("#finance_pickup_id").val();
    jQuery('#loadingSpinner').show();
  	if (uniqueId) {
	var storedData = JSON.parse(sessionStorage.getItem(uniqueId));
    
    var entryId = jQuery("#finance_entry_id").val();
    var seller_email = jQuery('#finance_entry_email').val();
    
    var vehicle_name = jQuery('#finance_entry_vehicle_name').val();
    var vehicle_vin = jQuery('#finance_entry_vehicle_vin').val();
    
    var formData = new FormData();
    formData.append("action", "add_additional_escrow_info");
    formData.append("form_id", 324878); // Replace with your form ID
    formData.append("entry_id", entryId); // Replace with your entry ID
    formData.append("data_meta", "finance_pickup_info");
    formData.append('form_name', 'Finance Booking Slot Info');
    formData.append('form_title', 'Finance Booking Slot Info Updated');
    formData.append('vehicle_name', vehicle_name);
    formData.append('vehicle_vin', vehicle_vin);

    formData.append("additional_info", JSON.stringify(storedData));

    // Call the function and handle the response
    addAdditionalEntryData(formData)
      .done(function (res) {
      jQuery('#loadingSpinner').hide();
        // Handle the response from the AJAX call
        if (res.success) {
          if (res.data !== "") {
          	deliverySessionResponse();
            jQuery("#timeslot-next").prop("disabled", false);
          } else {
            jQuery("#timeslot-next").prop("disabled", true);
          }
        } else {
          jQuery("#timeslot-next").prop("disabled", true);
          alert("Error updating info: " + res.data);
        }
      })
      .fail(function (error) {
        jQuery("#timeslot-next").prop("disabled", true);
        console.error("Error:", error);
        alert("Error updating info.");
      });
  } else {
    jQuery("#timeslot-next").prop("disabled", true);
  }
}


 function financePickupSessionResponse(storedData){
  

//console.log(storedData);

if(storedData){
jQuery("#timeslot-next").prop("disabled", false);
     jQuery('#finance-location-text').text(storedData.location);
     jQuery('.finance-location-text').text(storedData.location);
     jQuery('#finance-pickup-date-text').text(storedData.pickupDate);
     jQuery('.finance-timeslot-text').text(storedData.pickupDate);
     
     jQuery('#finance-location-input').val(storedData.location);
     jQuery('#finance-pickup-date-input').val(storedData.pickupDate);
}else{
jQuery('#finance-location-text').text('');
     jQuery('.finance-location-text').text('');
     jQuery('#finance-pickup-date-text').text('');
     jQuery('.finance-timeslot-text').text('');
     
     jQuery('#finance-location-input').val('');
     jQuery('#finance-pickup-date-input').val('');
jQuery("#timeslot-next").prop("disabled", true);
}

    }
    
   
 
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



</script>




<style>
.turbobidfinance-child {
    height: 139px;
    width: 116px;
    position: relative;
    padding: 20px;
    background: white;
    border-radius: 20px;
}

.turbobid-finance-services {
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

.turbobid-finance-services-wrapper {
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

.turbobidfinance,
.turbobidfinance-inner {
    max-width: 100%;
    display: flex;
    box-sizing: border-box;
}

.turbobidfinance-inner {
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-end;
    padding: 0 0 13px;
    text-align: left;
    font-size: 20px;
    font-family: "Plus Jakarta Sans";
}

.turbobidfinance {
    border-radius: 22px;
    flex-direction: row;
    align-items: flex-end;
    justify-content: flex-start;
    padding: 20px 16px;
    gap: 31px;
    line-height: normal;
    letter-spacing: normal;
}

.turbobidfinance.finance-bg-green {
    background: linear-gradient(180deg, #ecf7ed, #eef4e2);

}

@media screen and (max-width: 925px) {
    .turbobidfinance {
        flex-wrap: wrap;
    }
}

@media screen and (max-width: 700px) {
    .turbobidfinance {
        gap: var(--gap-mini);
    }
}

@media screen and (max-width: 450px) {
    .turbobid-finance-services {
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


.finance-pay-status,
.finance-delivery-status,
.finance-inspection-status {
    text-align: center;
    font-family: Inter;
    font-size: 12px;
    font-weight: 400;
    padding: 2px 5px;
    border-radius: 99px;
}

.finance-warning {
    color: #B99D4B;
    border: 1px solid #B99D4B;
    background: rgba(185, 157, 75, 0.20);
    color: #BF9B3E;
}

.finance-accepted {
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


.finance-payToSeller-status,
.finance-pay-status,
.finance-delivery-status,
.finance-inspection-status {
    text-align: center;
    font-family: Inter;
    font-size: 12px;
    font-weight: 400;
    padding: 2px 5px;
    border-radius: 99px;
}

.finance-warning {
    color: #B99D4B;
    border: 1px solid #B99D4B;
    background: rgba(185, 157, 75, 0.20);
    color: #BF9B3E;
}

.finance-accepted {
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