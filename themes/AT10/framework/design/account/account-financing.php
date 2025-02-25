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

global $wpdb, $CORE, $userdata;

$roles = wp_get_current_user()->roles;


/**
 * Normalize a phone number and compare it to a standardized format.
 *
 * @param string $inputNumber The phone number in any format (e.g., "(416) 200-1883").
 * @param string $normalizedNumber The standardized phone number to match (e.g., "+14162001883").
 * @return bool True if the numbers match, false otherwise.
 */
function isMatchingPhoneNumber($inputNumber, $normalizedNumber)
{
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

if (in_array('subscriber', $roles) || in_array('customer', $roles) || current_user_can('administrator')) {

	$user_email = $userdata->user_email;
	$user_phone = get_user_meta($userdata->ID, 'phone', true);

	$finance_form_id = 337873;
	$seller_email_finance = 'email-2'; // Replace with your specific seller email meta key
	$buyer_email_finance = 'email-1';
	$user_finance_meta = 'hidden-3';

	$entries_table = $wpdb->prefix . 'frmt_form_entry';
	$meta_table = $wpdb->prefix . 'frmt_form_entry_meta';

	// Fetch form entries for the specified form ID
	$finance_entries = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT entry_id, date_created FROM $entries_table WHERE form_id = %d",
			$finance_form_id
		)
	);



	$isBuyerFinance = false;
	$isSellerFinance = false;

	foreach ($finance_entries as $entry) {
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

		// Define buyer/seller identification criteria based on metadata
		if (
			(!isset($meta_data['finance_deal_status']) ||
				($meta_data['finance_deal_status'] != 'closed' && $meta_data['finance_deal_status'] != 'Finished')
			) &&
			(
				(!empty($meta_data[$buyer_email_finance]) && $meta_data[$buyer_email_finance] == $user_email) ||
				(!empty($meta_data['phone-1']) && isMatchingPhoneNumber($meta_data['phone-1'], $user_phone))
			)
		) {
			$isBuyerFinance = true;
		} elseif (
			(!isset($meta_data['finance_deal_status']) ||
				($meta_data['finance_deal_status'] != 'closed' && $meta_data['finance_deal_status'] != 'Finished')
			) &&
			(
				(!empty($meta_data[$seller_email_finance]) && $meta_data[$seller_email_finance] == $user_email) ||
				(!empty($meta_data['phone-6']) && isMatchingPhoneNumber($meta_data['phone-6'], $user_phone))
			)
		) {
			$isSellerFinance = true;
		}

		// Exit loop if both roles are identified
		if ($isBuyerFinance && $isSellerFinance) {
			break;
		}
	}




	// if($isBuyerFinance){
//     echo 'Finance Buyer Section';
// }else if($isSellerFinance){
//     echo 'Finance Seller Section';
// } else{
//     echo 'No finance available' . 'user phone: ' . $user_phone;
// }





	?>



	<div class="financing-entry-details p-0 px-md-1 p-md-2 mt-5 mt-md-0" data-id=""
		style="background-image:url('<?php echo home_url(); ?>/wp-content/uploads/2024/10/bg-map.png')">
		<div class="row m-0 bg-white py-3" style="border-radius:22px;">
			<div class=" col-12 col-md-9 p-0 px-md-1">
				<!-- Finance Buyer Section  -->
				<?php if ($isBuyerFinance) { ?>
					<div id="financeBuyerSection">
						<div class="turbobidfinancing financing-bg-green mb-2 align-items-stretch">
							<img style="position: relative; padding: 20px; background: white; border-radius: 20px;"
								loading="lazy" alt="turbobid financing icon"
								src="<?php echo home_url(); ?>/wp-content/uploads/2024/07/Vector-2.svg" />

							<section class="turbobidfinancing-inner col-6 col-md-4">
								<div style="gap:8px">
									<div class="turbobid-financing-services-wrapper">
										<h3 class="turbobid-financing-services">Financing</h3>
									</div>
									<div class="lien-service">
										<div class="the-lien-payoff">
											Any Vehicle, Any Marketplace

										</div>
										<a href="<?php echo home_url() ?>/finance" class="btn btn-primary rounded-pill px-3"
											style="font-size:10px">Explore Finance</a>
									</div>

								</div>
							</section>
							<div class="col-12 col-md d-flex justify-content-between align-items-stretch p-0 px-md-1">
								<div class="col-4 p-0 px-md-1">
									<div
										style="height:100%; width:100%; background:#44795B; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
										<div
											style="width:50px; height:50px; background:#3B634C; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
											<svg xmlns="http://www.w3.org/2000/svg" width="23" height="26" viewBox="0 0 23 26"
												fill="none">
												<path d="M7.39062 11.3485L9.9779 13.9352L15.1518 8.76123" stroke="white"
													stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
												<path
													d="M11.2715 24.2837L12.4096 23.7919C14.7959 22.7679 16.8565 21.1105 18.3683 18.9992C19.8801 16.8878 20.7853 14.4031 20.986 11.8142L21.5424 4.67385C21.5514 4.37815 21.4587 4.08829 21.2797 3.85276C21.1007 3.61723 20.8462 3.45031 20.5589 3.3799L11.2715 1L1.98409 3.32837C1.69685 3.39875 1.44248 3.56559 1.26347 3.80099C1.08446 4.03639 0.991664 4.3261 1.00059 4.6217L1.55691 11.762C1.75752 14.3511 2.66274 16.8359 4.17451 18.9474C5.68628 21.0588 7.74698 22.7163 10.1334 23.7404L11.2715 24.2837Z"
													stroke="white" stroke-width="1.5" stroke-linecap="round"
													stroke-linejoin="round">
												</path>
											</svg>
										</div>
										<span style="font-size:12px; color:white">Secure &amp; Fast<br>Approvals </span>

									</div>
								</div>
								<div class="col-4 p-0 px-md-1 mx-1 m-md-0">
									<div
										style="height:100%; width:100%; background:#44795B; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
										<div
											style="width:50px; height:50px; background:#3B634C; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
												fill="none">
												<path
													d="M12.004 24C10.3453 24 8.78533 23.6853 7.324 23.056C5.86356 22.4258 4.59289 21.5707 3.512 20.4907C2.43111 19.4107 1.57556 18.1413 0.945333 16.6827C0.315111 15.224 0 13.6644 0 12.004C0 10.3436 0.315111 8.78356 0.945333 7.324C1.57556 5.86356 2.43067 4.59289 3.51067 3.512C4.59067 2.43111 5.86044 1.57556 7.32 0.945333C8.77956 0.315111 10.3396 0 12 0H12.6667V10.8533C12.896 10.9956 13.0644 11.1609 13.172 11.3493C13.2796 11.5378 13.3333 11.7556 13.3333 12.0027C13.3333 12.3582 13.2004 12.6689 12.9347 12.9347C12.6689 13.2004 12.3573 13.3333 12 13.3333C11.6427 13.3333 11.3311 13.2004 11.0653 12.9347C10.7996 12.6689 10.6667 12.3591 10.6667 12.0053C10.6667 11.76 10.7204 11.5409 10.828 11.348C10.9356 11.1551 11.104 10.9907 11.3333 10.8547V6.73067C10.0071 6.888 8.89778 7.46445 8.00533 8.46C7.11289 9.45556 6.66667 10.6356 6.66667 12C6.66667 13.4667 7.18889 14.7222 8.23333 15.7667C9.27778 16.8111 10.5333 17.3333 12 17.3333C13.4667 17.3333 14.7222 16.8111 15.7667 15.7667C16.8111 14.7222 17.3333 13.4667 17.3333 12C17.3333 11.2 17.172 10.4613 16.8493 9.784C16.5267 9.10667 16.088 8.512 15.5333 8L16.4853 7.04933C17.16 7.66267 17.692 8.39378 18.0813 9.24267C18.4707 10.0916 18.6658 11.0107 18.6667 12C18.6667 13.8516 18.0191 15.4258 16.724 16.7227C15.4289 18.0196 13.8564 18.6676 12.0067 18.6667C10.1569 18.6658 8.58133 18.0178 7.28 16.7227C5.98222 15.4258 5.33333 13.8516 5.33333 12C5.33333 10.2569 5.91111 8.75733 7.06667 7.50133C8.22222 6.24533 9.64444 5.53867 11.3333 5.38133V1.34933C8.53511 1.512 6.16889 2.61467 4.23467 4.65733C2.30044 6.7 1.33333 9.14756 1.33333 12C1.33333 14.9778 2.36667 17.5 4.43333 19.5667C6.5 21.6333 9.02222 22.6667 12 22.6667C14.9778 22.6667 17.5 21.6333 19.5667 19.5667C21.6333 17.5 22.6667 14.9778 22.6667 12C22.6667 10.4667 22.3667 9.03333 21.7667 7.7C21.1667 6.36667 20.3444 5.21111 19.3 4.23333L20.2507 3.28267C21.4151 4.38489 22.3311 5.68178 22.9987 7.17333C23.6662 8.66489 24 10.2711 24 11.992C24 13.6542 23.6853 15.2156 23.056 16.676C22.4258 18.1364 21.5707 19.4071 20.4907 20.488C19.4107 21.5689 18.1413 22.4244 16.6827 23.0547C15.224 23.6849 13.6644 24 12.004 24Z"
													fill="white"></path>
											</svg>
										</div>
										<span style="font-size:12px; color:white">
											Add Warranty,Insurance<br>&amp; Transport Options </span>

									</div>
								</div>
								<div class="col-4 p-0 px-md-1">
									<div
										style="height:100%; width:100%; background:#44795B; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
										<div
											style="width:50px; height:50px; background:#3B634C; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
											<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23"
												fill="none">
												<path
													d="M11.5 0C12.5557 0 13.5739 0.134766 14.5547 0.404297C15.5355 0.673828 16.4526 1.05941 17.3062 1.56104C18.1597 2.06266 18.9346 2.66162 19.6309 3.35791C20.3271 4.0542 20.9261 4.83285 21.4277 5.69385C21.9294 6.55485 22.3149 7.47201 22.5845 8.44531C22.854 9.41862 22.9925 10.4368 23 11.5C23 12.2412 22.9289 12.9712 22.7866 13.6899C22.6444 14.4087 22.4347 15.1162 22.1577 15.8125H18.6875V14.375H21.1357C21.4202 13.4316 21.5625 12.4733 21.5625 11.5C21.5625 10.5042 21.424 9.5459 21.147 8.625H17.0703C17.1302 9.10417 17.1751 9.57959 17.2051 10.0513C17.235 10.5229 17.25 11.0059 17.25 11.5H15.8125C15.8125 11.0133 15.7975 10.5342 15.7676 10.0625C15.7376 9.59082 15.689 9.11165 15.6216 8.625H7.37842C7.31852 9.10417 7.2736 9.57959 7.24365 10.0513C7.2137 10.5229 7.19499 11.0059 7.1875 11.5C7.1875 11.9867 7.20247 12.4658 7.23242 12.9375C7.26237 13.4092 7.31104 13.8883 7.37842 14.375H14.375V15.8125H7.62549C7.68538 16.1045 7.77148 16.4489 7.88379 16.8457C7.99609 17.2425 8.1346 17.6543 8.29932 18.0811C8.46403 18.5078 8.6512 18.9271 8.86084 19.3389C9.07048 19.7507 9.3138 20.125 9.59082 20.4619C9.86784 20.7988 10.1598 21.0646 10.4668 21.2593C10.7738 21.4539 11.1182 21.555 11.5 21.5625C11.7246 21.5625 11.938 21.5213 12.1401 21.439C12.3423 21.3566 12.5332 21.2443 12.7129 21.1021C12.8926 20.9598 13.0573 20.8063 13.207 20.6416C13.3568 20.4769 13.4953 20.3047 13.6226 20.125H14.375V22.6182C13.9033 22.7454 13.4279 22.839 12.9487 22.8989C12.4696 22.9588 11.9867 22.9925 11.5 23C10.4443 23 9.42611 22.8652 8.44531 22.5957C7.46452 22.3262 6.54736 21.9406 5.69385 21.439C4.84033 20.9373 4.06543 20.3384 3.36914 19.6421C2.67285 18.9458 2.07389 18.1672 1.57227 17.3062C1.07064 16.4452 0.685059 15.5317 0.415527 14.5659C0.145996 13.6001 0.00748698 12.5781 0 11.5C0 10.4443 0.134766 9.42611 0.404297 8.44531C0.673828 7.46452 1.05941 6.54736 1.56104 5.69385C2.06266 4.84033 2.66162 4.06543 3.35791 3.36914C4.0542 2.67285 4.83285 2.07389 5.69385 1.57227C6.55485 1.07064 7.46826 0.685059 8.43408 0.415527C9.3999 0.145996 10.4219 0.00748698 11.5 0ZM8.20947 1.98779C7.57308 2.20492 6.97038 2.48568 6.40137 2.83008C5.83236 3.17448 5.29704 3.56755 4.79541 4.00928C4.29378 4.45101 3.84831 4.93766 3.45898 5.46924C3.06966 6.00081 2.72152 6.57357 2.41455 7.1875H6.1543C6.23665 6.74577 6.33773 6.29655 6.45752 5.83984C6.57731 5.38314 6.72331 4.93018 6.89551 4.48096C7.06771 4.03174 7.26237 3.59749 7.47949 3.17822C7.69661 2.75895 7.93994 2.36214 8.20947 1.98779ZM8.20947 21.0122C7.93994 20.6453 7.69661 20.2523 7.47949 19.833C7.26237 19.4137 7.07145 18.9795 6.90674 18.5303C6.74202 18.0811 6.59603 17.6281 6.46875 17.1714C6.34147 16.7147 6.23665 16.2617 6.1543 15.8125H2.41455C2.70654 16.4189 3.05094 16.988 3.44775 17.5195C3.84456 18.0511 4.29378 18.5415 4.79541 18.9907C5.29704 19.4399 5.82861 19.833 6.39014 20.1699C6.95166 20.5068 7.55811 20.7876 8.20947 21.0122ZM5.92969 14.375C5.86979 13.8958 5.82487 13.4204 5.79492 12.9487C5.76497 12.4771 5.75 11.9941 5.75 11.5C5.75 11.0133 5.76497 10.5342 5.79492 10.0625C5.82487 9.59082 5.86979 9.11165 5.92969 8.625H1.85303C1.57601 9.5459 1.4375 10.5042 1.4375 11.5C1.4375 12.4958 1.57601 13.4541 1.85303 14.375H5.92969ZM15.3745 7.1875C15.3146 6.89551 15.2285 6.55111 15.1162 6.1543C15.0039 5.75749 14.8654 5.3457 14.7007 4.91895C14.536 4.49219 14.3488 4.07292 14.1392 3.66113C13.9295 3.24935 13.6862 2.875 13.4092 2.53809C13.1322 2.20117 12.8402 1.93538 12.5332 1.74072C12.2262 1.54606 11.8818 1.44499 11.5 1.4375C11.1331 1.4375 10.7925 1.53857 10.478 1.74072C10.1636 1.94287 9.86784 2.20866 9.59082 2.53809C9.3138 2.86751 9.07422 3.23812 8.87207 3.6499C8.66992 4.06169 8.479 4.4847 8.29932 4.91895C8.11963 5.35319 7.98112 5.76497 7.88379 6.1543C7.78646 6.54362 7.70036 6.88802 7.62549 7.1875H15.3745ZM20.5854 7.1875C20.2935 6.58105 19.9491 6.01204 19.5522 5.48047C19.1554 4.94889 18.7062 4.4585 18.2046 4.00928C17.703 3.56006 17.1714 3.16699 16.6099 2.83008C16.0483 2.49316 15.4419 2.2124 14.7905 1.98779C15.0601 2.35466 15.3034 2.74772 15.5205 3.16699C15.7376 3.58626 15.9285 4.02051 16.0933 4.46973C16.258 4.91895 16.404 5.37191 16.5312 5.82861C16.6585 6.28532 16.7633 6.73828 16.8457 7.1875H20.5854ZM17.25 17.25H21.5625V18.6875H17.25V23H15.8125V18.6875H11.5V17.25H15.8125V12.9375H17.25V17.25Z"
													fill="white"></path>
											</svg>
										</div>
										<span style="font-size:12px; color:white">
											Instant Payment to<br>Sellers with Trbo Swift </span>
										</span>

									</div>
								</div>



							</div>
						</div>

						<div class="bg-light p-3 mb-2" style="border-radius:22px;">
							<div class="mb-3">
								<div class="row mb-1">
									<div class="col financing-entry-title h5">No Pending Applications</div>
									<div class="col text-right">Application #<span
											class="financing-entry-id">9865445678556</span><i class="far fa-copy ml-1"></i>
									</div>
								</div>
								<span class="text-primary small">Trbo Swift partners with top lenders to get you the best rates
									and
									terms.
									Enjoy a seamless online financing process and add options for warranties, transportation,
									and
									escrow
									services.</span>
							</div>



							<div class="financing-process mb-3">

								<div class="container mb-4">
									<div class="progress-container">
										<div class="progress" id="financing-progress-bar"></div>

										<div class="step-wrap active" data-step="1">
											<div class="circle"><span class="step-title">1</span></div>
											<p class="text">Application Status</p>
										</div>
										<div class="step-wrap" data-step="2">
											<div class="circle"><span class="step-title">2</span></div>
											<p class="text">Decision</p>
										</div>
										<div class="step-wrap" data-step="3">
											<div class="circle"><span class="step-title">3</span></div>
											<p class="text">KYC verification</p>
										</div>
										<div class="step-wrap" data-step="4">
											<div class="circle"><span class="step-title">4</span></div>
											<p class="text">Paper Work</p>
										</div>
										<div class="step-wrap" data-step="5">
											<div class="circle"><span class="step-title">5</span></div>
											<p class="text">Vehicle Delivery</p>
										</div>
										<div class="step-wrap" data-step="6">
											<div class="circle"><span class="step-title">6</span></div>
											<p class="text">Seller Payment</p>
										</div>
									</div>
									<div>

										<input type="hidden" id="finance_entry_id" value="">
										<input type="hidden" id="finance_pickup_id" value="">
										<input type="hidden" id="finance_entry_vehicle_name" value="">
										<input type="hidden" id="finance_entry_vehicle_vin" value="">
										<input type="hidden" id="financeBuyerEmailAddress" value="">
										<input type="hidden" id="financeSellerEmailAddress" value="">

										<?php if (current_user_can('administrator')) { ?>
											<button class="btn btn-primary rounded-pill px-3" id="financing-step-back"
												disabled>&larr;
												Back</button>
											<button class="btn btn-secondary rounded-pill px-3 financing-step-next"> Next</button>
										<?php } ?>
									</div>

								</div>



								<div id="step-details" class="mb-3">

									<div class="financing-process-step-details" data-step="0">
										<div class="container row m-0 p-0 p-md-2 bg-white" style="border-radius:22px;">

											<div class="row mx-0 gap-2 my-2 align-items-center">
												<h5>Apply for financing</h5>
												<div class="col-3"><?php echo $CORE->LAYOUT("get_logo", "light"); ?></div>
											</div>
											<p class="text-primary">We have exclusive partnerships with some of Canada’s largest
												lenders
												to get your best-in-market rates.</p>


											<div class="row m-0 my-2">
												<button
													class="btn btn-outline-secondary rounded-pill px-4 mb-2 mb-md-0 mr-md-2">Learn
													more</button>
												<a href="<?php echo home_url(); ?>/credit-application"
													class="btn btn-secondary rounded-pill px-4" target="blank">Apply for
													financing</a>
											</div>


										</div>


										<div class="financing-item-details bg-light p-0 p-md-3 mt-2"
											style="border-radius:22px;">
											<div class="h6 pb-5 mb-5"><i class="far fa-file"></i> Item details</div>

										</div>


									</div>


									<div class="financing-process-step-details" data-step="1">
										<div class="container row m-0 p-2 bg-white mt-2" style="border-radius:22px;">

											<div class="col-12 p-0 p-md-2">

												<div class="row mx-0 gap-2 my-2 align-items-center">
													<h5 class="p-0 p-md-2 col-md-9">Thank you for applying with Trbo Swift,
														We're currently
														reviewing
														your
														application</h5>

												</div>

												<button
													class="financeApplicationDecision btn btn-outline-secondary rounded-pill px-4">Decision
													Pending</button>

											</div>
										</div>


										<div class="financing-item-details bg-light p-3 mt-2" style="border-radius:22px;"></div>



									</div>
									<div class="financing-process-step-details" data-step="2" style="display: none;">

										<div class="container p-2 bg-white" style="border-radius:22px;">

											<div class="col-12 my-2">
												<h5 class="financeApplicationDecision"><span
														class="text-primary">Decision:</span>
													<span class="text-secondary">Pending</span>
												</h5>

												<p>Congratulations on receiving your financing approval! Please take a moment to
													review
													the
													terms, interest rate, and all details before proceeding.</p>

											</div>

											<div class="col-12 col-md row m-0 justify-content-start align-items-stretch mb-3">
												<div class="col-12 col-md-3 mb-2 mb-md-0 pl-0">
													<div
														style="height:100%; width:100%; background:#F8F9FA; text-align: center; border-radius:11px; display:flex; justify-content:start; align-items:center; padding:10px;">
														<div
															style="width:50px; height:50px; background:#E2FBD7; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-right:8px">
															<img
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/10/money-recive.svg" />
														</div>
														<div style="font-size:12px; color:#5f5f5f"><span
																class="approvalAmountCard">$620
															</span> <span class="termType">/Month</span> </div>

													</div>
												</div>
												<div class="col-12 col-md-3 mb-2 mb-md-0 pl-0">
													<div
														style="height:100%; width:100%; background:#F8F9FA; text-align: center; border-radius:11px; display:flex;  justify-content:start; align-items:center; padding:10px;">
														<div
															style="width:50px; height:50px; background:#FFF2CE; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-right:8px">
															<i class="fal fa-tag " style="color:#BF9B3E"></i>
														</div>
														<div style="font-size:12px; color:#5f5f5f"><span
																class="approvalInterestCard">
																7.49%</span>interest</div>

													</div>
												</div>
												<div class="col-12 col-md-3 mb-2 mb-md-0 pl-0">
													<div
														style="height:100%; width:100%; background:#F8F9FA; text-align: center; border-radius:11px; display:flex;  justify-content:start; align-items:center; padding:10px;">
														<div
															style="width:50px; height:50px; background:#DAD7FE; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-right:8px">
															<img
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/10/Group-1321316259.svg" />
														</div>
														<div style="font-size:12px; color:#5f5f5f"><span
																class="approvalMonthTermCard">
																12 Month</span> Term</div>
														</span>

													</div>
												</div>



											</div>

											<div class="col-12 form-row mb-3">
												<div class="form-group col-md-3">
													<label style="font-size:12px; color:#5f5f5f" for="approvedAmounts"
														class="info-label">Approved Amount</label>
													<input type="text" id="approvedAmounts" class="form-control border radiusx"
														value="" readonly>
												</div>
												<div class="form-group col-md-3">
													<label style="font-size:12px; color:#5f5f5f" for="Lender"
														class="info-label">Lender</label>
													<input type="text" id="buyerLender" class="form-control border radiusx"
														value="" readonly>
												</div>
												<div class="form-group col-md-3">
													<label style="font-size:12px; color:#5f5f5f" for="Lender Type"
														class="info-label">Lender Type</label>
													<!-- <input type="text" id="buyerLenderType" class="form-control border radiusx" value=""> -->
													<select type="text" id="buyerLenderType" class="form-control border radiusx"
														readonly>

														<option value="Prime">Prime</option>
														<option value="Sub Prime">Sub Prime</option>
														<option value="Lease">Lease</option>

													</select>
												</div>
												<div class="form-group col-md-3">
													<label style="font-size:12px; color:#5f5f5f" for="paymentFrequency"
														class="info-label">Payment Frequency</label>
													<select type="text" id="buyerPaymentFrequency"
														class="form-control border radiusx">

														<option>Monthly</option>
														<option>Biweekly</option>

													</select>
												</div>

											</div>

										</div>


										<div class="container my-3 p-0">
											<h6 class="mb-2">Packages</h6>
											<div class="row">
												<!-- Aftermarket Warranty -->
												<div class="col-md-3 mb-3">
													<div class="card packages-card aftermarketWarranty">
														<div class="card-body d-flex flex-column justify-content-between small">
															<div>
																<h5 class="card-title">Aftermarket Warranty</h5>
																<p class="card-text"><strong>Extended Vehicle Coverage</strong>
																	- 2
																	Year, 100,00 KM</p>
																<p class="card-text"><strong>Power train</strong> - Covers
																	mechanical and suspension components of the vehicle.</p>
															</div>
															<div class="price">
																<span>$33 Monthly</span>
																<a href="#" class="view-details">View details</a>
															</div>
														</div>
													</div>
												</div>

												<!-- GAP Insurance -->
												<div class="col-md-3 mb-3">
													<div class="card packages-card gAPInsurance">
														<div class="card-body d-flex flex-column justify-content-between small">
															<div>
																<h5 class="card-title">GAP Insurance</h5>
																<p class="card-text"><strong>Loan Protection</strong> - Covers
																	the
																	difference between the insurance payout and your remaining
																	loan
																	balance if your vehicle is totaled or stolen.</p>
															</div>
															<div class="price">
																<span>$33 Monthly</span>
																<a href="#" class="view-details">View details</a>
															</div>
														</div>
													</div>
												</div>

												<!-- Life Insurance -->
												<div class="col-md-3 mb-3">
													<div class="card packages-card lifeInsurance">
														<div class="card-body d-flex flex-column justify-content-between small">
															<div>
																<h5 class="card-title">Life Insurance</h5>
																<p class="card-text"><strong>Protect Your Loved Ones</strong> -
																	With
																	Dependable Life Insurance. View coverage details.</p>
															</div>
															<div class="price">
																<span>$33 Monthly</span>
																<a href="#" class="view-details">View details</a>
															</div>
														</div>
													</div>
												</div>

												<!-- Turbobid Transport -->
												<div class="col-md-3 mb-3">
													<div class="card packages-card turbobidTransport">
														<div class="card-body d-flex flex-column justify-content-between small">
															<h5 class="card-title">Trbo Swift Transport</h5>
															<p class="card-text"><strong>Nationwide Delivery</strong> - Get your
																vehicle delivered anywhere in Canada through Trbo Swift
																Transport.
															</p>
															<div class="price">
																<span>$233 Total</span>
																<a href="#" class="view-details">View details</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>


										<div class="row m-0">
											<!-- <button class="btn btn-outline-secondary rounded-pill px-4 mb-3 mb-md-0 mr-md-3">View
									approval terms</button> -->
											<button id="submitApprovalInfo" class="btn btn-secondary rounded-pill px-4">Accept
												Terms & Continue</button>
										</div>



									</div>
									<div class="financing-process-step-details" data-step="3" style="display: none;">
										<div class="container row m-0 p-2 bg-white" style="border-radius:22px;">

											<div class="col-12">

												<h5 class="financeKYCDecision"><span class="text-primary">Decision:</span>
													<span class="text-secondary">Pending</span>
												</h5>

												<div class="row mx-0 gap-2 my-2 align-items-center">
													<h5>Please complete the Trbo Swift KYC identity verification process.</h5>

												</div>
												<p>Capture a photo of your drivers license along with a simple selfie. You can
													do
													this
													using either a smartphone or a web browser.We’ll need to use to register the
													vehicle.</p>

												<div class="row m-0">

													<div id="finance-verification-next">
														<div id="finance-veriff-root"></div>
													</div>

												</div>

											</div>
										</div>

										<div class="financing-item-details bg-light p-3 mt-2" style="border-radius:22px;"></div>

									</div>
									<div class="financing-process-step-details" data-step="4" style="display: none;">
										<div class="container row m-0 p-2">

											<div class="col-12 row align-items-center">

												<div class="col-md-9">
													<h5>Please review and complete the paperwork</h5>
													<p>Congratulations on receiving your financing approval! Please take a
														moment to
														review the terms, interest rate, and all details before signing.</p>

												</div>




												<div class="col-md-3 text-md-right">
													<button id="dealSignaturePaperWorkDetails"
														class="btn btn-secondary rounded-pill px-3"
														style="font-size:12px;">Review & Sign </button>
												</div>

											</div>
										</div>

										<div class="container p-0 p-md-1">
											<h5>Financing Details</h5>

											<div class="row col-12 align-items-center justify-content-between mb-3">
												<strong class="financing-entry-title">2024 Tesla Model 3</strong>
												<div class="financing-vin-color row align-items-center">
													<strong>VIN:</strong><span> OIUYTRE456YHBNMU/55000KM, Black</span>
												</div>

											</div>

											<div class="row m-0 gap-2 financeDetails">
												<div class="col-md-6 p-0 mb-2 mb-md-0 pr-md-2">
													<div class="card-body bg-white" style="border-radius:22px;">

														<ul class="list-group list-group-flush">
															<li class="list-group-item">
																<div class="row align-items-center justify-content-between">
																	<h6>Lender</h6>
																	<span class="lenderName">CIBC</span>
																</div>
																<div class="row align-items-center justify-content-between">
																	<h6>Interest Rate</h6>
																	<span class="interestRate">7.60%</span>
																</div>
																<div class="row align-items-center justify-content-between">
																	<h6>Payment</h6>
																	<span class="paymentWithTerm">$760.08 Monthly</span>
																</div>
																<div class="row align-items-center justify-content-between">
																	<h6>Approved Amount (CAD)</h6>
																	<span class="approvedFinanceAmount">CA $35,000.00</span>
																</div>
															</li>
														</ul>
													</div>
												</div>
												<div class="col-md-6 p-0 mb-2 mb-md-0 pr-md-0 ">
													<div class="card-body bg-white" style="border-radius:22px;">

														<ul class="list-group list-group-flush">
															<li class="list-group-item">
																<div class="row align-items-center justify-content-between">
																	<h6>Lender Type</h6>
																	<span class="lenderType">Prime</span>
																</div>
																<div class="row align-items-center justify-content-between">
																	<h6>Term</h6>
																	<span class="termLength">96 months</span>
																</div>
																<div class="row align-items-center justify-content-between">
																	<h6>Type of Payment</h6>
																	<span class="paymentType">Monthly</span>
																</div>
																<div class="row align-items-center justify-content-between">
																	<h6>Approved Amount (CAD)</h6>
																	<span class="approvedFinanceAmount">CA $35,000.00</span>
																</div>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div>


										<div class="col-12 mt-4" bis_skin_checked="1">
											<div class="overflow-auto" bis_skin_checked="1">
												<table class="table small table-borderless">

													<tbody id="client-document">
														<tr class="row-1" data-upload-name="Finance Agreement"
															data-document-id="1">
															<td class="d-flex d-flex  mb-2"
																style="border-radius:10px 0 0 10px;">
																<img style="max-width:35px; max-height:35px;"
																	src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																	alt="PDF FILE" />

																<div class="d-flex flex-column pl-2">
																	<span class="doc-name text-dark">Finance Agreement
																	</span>
																	<span class="small pt-1 doc-date" style="color:#909090">####
																	</span>
																</div>
															</td>


															<td class="text-right text-primary ">
																<a class="dropdown-item view-paperwork-doc text-dark disabled"
																	href="javascript:void(0)">
																	View Details
																</a>
															</td>
															<td class="doc-row-status text-right "
																style="border-radius:0px 10px 10px 0;">
																<span class="badge font-8 px-2 py-2 rounded-pill"
																	style="background:#F7D9D3; color:#F24822; width:120px;"><i
																		class="fas fa-circle small mr-2"></i>Pending
																	Signature</span>
															</td>

														</tr>
														<tr class="row-2" data-upload-name="Bank Paperwork"
															data-document-id="2">
															<td class="d-flex" colspan="9">
																<img style="max-width:35px; max-height:35px;"
																	src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																	alt="PDF FILE" />
																<div class="d-flex flex-column pl-2">
																	<span class="doc-name text-dark">Bank Paperwork
																	</span>
																	<span class="small pt-1 doc-date"
																		style="color:#909090">####</span>
																</div>
															</td>


															<td class="text-right text-primary" colspan="1">
																<a class="dropdown-item view-paperwork-doc text-dark disabled"
																	href="javascript:void(0)">
																	View Details
																</a>
															</td>
															<td class="doc-row-status text-right" colspan="1">
																<span class="badge font-8 px-2 py-2 rounded-pill"
																	style="background:#F7D9D3; color:#F24822; width:120px;"><i
																		class="fas fa-circle small mr-2"></i>Pending
																	Signature</span>
															</td>
														</tr>
														<tr class="row-3" data-upload-name="Escrow Agreement"
															data-document-id="3">
															<td class="d-flex" colspan="9">
																<img style="max-width:35px; max-height:35px;"
																	src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																	alt="PDF FILE" />
																<div class="d-flex flex-column pl-2">
																	<span class="doc-name text-dark">Escrow Agreement
																	</span>
																	<span class="small pt-1 doc-date"
																		style="color:#909090">####</span>
																</div>
															</td>



															<td class="text-right text-primary" colspan="1">
																<a class="dropdown-item view-paperwork-doc text-dark disabled"
																	href="javascript:void(0)">
																	View Details
																</a>
															</td>
															<td class="doc-row-status text-right" colspan="1">
																<span class="badge font-8 px-2 py-2 rounded-pill"
																	style="background:#F7D9D3; color:#F24822; width:120px;"><i
																		class="fas fa-circle small mr-2"></i>Pending
																	Signature</span>
															</td>
														</tr>
														<tr class="row-4" data-upload-name="Warranty Paperwork"
															data-document-id="4">
															<td class="d-flex" colspan="9">
																<img style="max-width:35px; max-height:35px;"
																	src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																	alt="PDF FILE" />
																<div class="d-flex flex-column pl-2">
																	<span class="doc-name text-dark">Warranty Paperwork
																	</span>
																	<span class="small pt-1 doc-date"
																		style="color:#909090">####</span>
																</div>
															</td>



															<td class="text-right text-primary" colspan="1">
																<a class="dropdown-item view-paperwork-doc text-dark disabled"
																	href="javascript:void(0)">
																	View Details
																</a>
															</td>
															<td class="doc-row-status text-right" colspan="1">
																<span class="badge font-8 px-2 py-2 rounded-pill"
																	style="background:#F7D9D3; color:#F24822; width:120px;"><i
																		class="fas fa-circle small mr-2"></i>Pending
																	Signature</span>
															</td>
														</tr>
														<tr class="row-5" data-upload-name="GAAP Insurance"
															data-document-id="5">
															<td class="d-flex" colspan="9">
																<img style="max-width:35px; max-height:35px;"
																	src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																	alt="PDF FILE" />
																<div class="d-flex flex-column pl-2">
																	<span class="doc-name text-dark">GAAP Insurance
																	</span>
																	<span class="small pt-1 doc-date"
																		style="color:#909090">####</span>
																</div>
															</td>



															<td class="text-right text-primary" colspan="1">
																<a class="dropdown-item view-paperwork-doc text-dark disabled"
																	href="javascript:void(0)">
																	View Details
																</a>
															</td>
															<td class="doc-row-status text-right" colspan="1">
																<span class="badge font-8 px-2 py-2 rounded-pill"
																	style="background:#F7D9D3; color:#F24822; width:120px;"><i
																		class="fas fa-circle small mr-2"></i>Pending
																	Signature</span>
															</td>
														</tr>

														<tr class="row-6" data-upload-name="Life Insurance"
															data-document-id="6">
															<td class="d-flex" colspan="9">
																<img style="max-width:35px; max-height:35px;"
																	src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																	alt="PDF FILE" />
																<div class="d-flex flex-column pl-2">
																	<span class="doc-name text-dark">Life Insurance
																	</span>
																	<span class="small pt-1 doc-date"
																		style="color:#909090">####</span>
																</div>
															</td>



															<td class="text-right text-primary" colspan="1">
																<a class="dropdown-item view-paperwork-doc text-dark disabled"
																	href="javascript:void(0)">
																	View Details
																</a>
															</td>
															<td class="doc-row-status text-right" colspan="1">
																<span class="badge font-8 px-2 py-2 rounded-pill"
																	style="background:#F7D9D3; color:#F24822; width:120px;"><i
																		class="fas fa-circle small mr-2"></i>Pending
																	Signature</span>
															</td>
														</tr>



													</tbody>
												</table>
											</div>
										</div>

									</div>
									<div class="financing-process-step-details" data-step="5" style="display: none;">
										<div class="container row m-0 p-2 bg-white mb-2" style="border-radius:22px;">
											<div class="col-12">
												<h5 class="mb-2">Pickup / Delivery</h5>

												<button
													onclick="jQuery('.newUserAddModalBody').removeClass('d-none').addClass('d-flex');"
													class="btn btn-secondary rounded-pill px-4 float-lg-right">View
													Calander</button>

												<span>Click ‘View Calendar’ to choose your vehicle pick date and time</span>
												<small>Once your pickup is confirmed, Turbo Swift will assign a delivery
													partner. Track updates below.</small>

												<div class="form-group col-md-4 p-0">
													<label style="font-size:12px; color:#5f5f5f"
														for="transportCompanyPickupDate" class="info-label">Earliest Pickup
														Date</label>
													<input type="date" id="transportCompanyPickupDate"
														class="form-control rounded-pill" value="">
												</div>


												<div class="col-12 form-row mb-3 p-0 d-none">
													<div class="form-group col-md-3">
														<label style="font-size:12px; color:#5f5f5f" for="sellerPickUpAddress"
															class="info-label">Seller Address</label>
														<input type="text" id="sellerPickUpAddress"
															class="form-control rounded-pill googleAutoLocation" value=""
															disabled>
													</div>
													<div class="form-group col-md-3">
														<label style="font-size:12px; color:#5f5f5f" for="Date"
															class="info-label">Date</label>
														<input type="date" id="vehiclePickupDate"
															class="form-control rounded-pill" value="" disabled>
													</div>
													<div class="form-group col-md-3">
														<label style="font-size:12px; color:#5f5f5f" for="preferredTimePickup"
															class="info-label">Preferred time for Pickup</label>
														<input type="time" id="preferredTimePickup"
															class="form-control rounded-pill" value="" disabled>
													</div>


												</div>

												<!-- <span>Add Details of Transport Company</span>
										<div class="col-12 form-row mb-3 p-0">
											<div class="form-group col-md-3">
												<label style="font-size:12px; color:#5f5f5f" for="transportCompanyName"
													class="info-label">Transport Company</label>
												<input type="text" id="transportCompanyName"
													class="form-control rounded-pill" value="">
											</div>
											<div class="form-group col-md-3">
												<label style="font-size:12px; color:#5f5f5f"
													for="transportCompanyPhoneNumber" class="info-label">Phone
													Number</label>
												<input type="tel" id="transportCompanyPhoneNumber"
													class="form-control rounded-pill" value="">
											</div>
											
											<div class="form-group col-md-3">
												<label style="font-size:12px; color:#5f5f5f"
													for="transportCompanyTrackingNumber" class="info-label">Tracking
													Number</label>
												<input type="text" id="transportCompanyTrackingNumber"
													class="form-control rounded-pill" value="">
											</div>


										</div>

										<div id="isVehicleBeingPicked" class="col-md-12 row mt-2">
											<span class="mr-2" style="font-size:14px; color:#5f5f5f">Is the vehicle
												being picked up?</span>

											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="isRegisteredOwner"
													value="Yes">
												<label class="form-check-label" for="isRegisteredOwner">
													Yes
												</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="isRegisteredOwner"
													value="No">
												<label class="form-check-label" for="isRegisteredOwner">
													No
												</label>
											</div>

										</div> -->

											</div>
										</div>


										<div class="container m-0 p-2" style="border-radius:10px;">

											<div class="transportLocationStatus">
												<div class="position-relative">
													<div class="finance_map_container" style="width: 100%; min-height: 361px;">
													</div>

													<div class="transportDetailsInMap"></div>
												</div>
												<div id="transportDetails"></div>
											</div>

										</div>

										<!-- <div class="mt-3">

									<button id="submitPickupDelivery"
										class="btn btn-secondary rounded-pill px-4">Submit</button>
								</div> -->


									</div>
									<div class="financing-process-step-details" data-step="6" style="display: none;">
										<div class="container row m-0 p-4 bg-white" style="border-radius:22px; ">

											<div class="mx-0 gap-2 my-2 align-items-center">
												<h5 class="mb-2">Delivery & Payment
												</h5>
												<p>The seller will receive payment upon delivery of the vehicle. Please book a
													time
													to
													pick up the vehicle
												</p>

											</div>

											<div>
												<button class="getFinanceInspectionUrl btn btn-secondary rounded-pill">Complete
													Inspection</button>
												<div class="mt-2">
													<strong>Note: </strong>Only complete the inspection when you are in
													possession
													of the vehicle
												</div>
											</div>

											<div class="py-4">
												<div class="financeIncSellerWebappUrl"></div>
												<div class="financeIncSellerResponseResult"></div>
											</div>



										</div>



										<!-- Second block -->
										<div class="financing-item-details bg-white p-4 mt-2" style="border-radius:22px;"></div>


									</div>





								</div>


							</div><!-- Process Close -->


						</div>
					</div>

				<?php } else if ($isSellerFinance) { ?>

						<!-- Finance Seller section  -->
						<div id="financeSellerSection">
							<div class="turbobidfinancing financing-bg-green mb-2 align-items-stretch">
								<img style="position: relative; padding: 20px; background: white; border-radius: 20px;"
									loading="lazy" alt="turbobid financing icon"
									src="<?php echo home_url(); ?>/wp-content/uploads/2024/07/Vector-2.svg" />

								<section class="turbobidfinancing-inner col-6 col-md-4">
									<div style="gap:8px">
										<div class="turbobid-financing-services-wrapper">
											<h3 class="turbobid-financing-services">Financing</h3>
										</div>
										<div class="lien-service">
											<div class="the-lien-payoff">
												Any Vehicle, Any Marketplace

											</div>
											<a href="<?php echo home_url() ?>/finance" class="btn btn-primary rounded-pill px-3"
												style="font-size:10px">Explore Finance</a>
										</div>

									</div>
								</section>
								<div class="col-12 col-md d-flex justify-content-between align-items-stretch p-0 px-md-1">
									<div class="col-4 p-0 px-md-1">
										<div
											style="height:100%; width:100%; background:#44795B; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
											<div
												style="width:50px; height:50px; background:#3B634C; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
												<svg xmlns="http://www.w3.org/2000/svg" width="23" height="26" viewBox="0 0 23 26"
													fill="none">
													<path d="M7.39062 11.3485L9.9779 13.9352L15.1518 8.76123" stroke="white"
														stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
													<path
														d="M11.2715 24.2837L12.4096 23.7919C14.7959 22.7679 16.8565 21.1105 18.3683 18.9992C19.8801 16.8878 20.7853 14.4031 20.986 11.8142L21.5424 4.67385C21.5514 4.37815 21.4587 4.08829 21.2797 3.85276C21.1007 3.61723 20.8462 3.45031 20.5589 3.3799L11.2715 1L1.98409 3.32837C1.69685 3.39875 1.44248 3.56559 1.26347 3.80099C1.08446 4.03639 0.991664 4.3261 1.00059 4.6217L1.55691 11.762C1.75752 14.3511 2.66274 16.8359 4.17451 18.9474C5.68628 21.0588 7.74698 22.7163 10.1334 23.7404L11.2715 24.2837Z"
														stroke="white" stroke-width="1.5" stroke-linecap="round"
														stroke-linejoin="round">
													</path>
												</svg>
											</div>
											<span style="font-size:12px; color:white">Secure &amp; Fast<br>Approvals </span>

										</div>
									</div>
									<div class="col-4 p-0 px-md-1 mx-1 m-md-0">
										<div
											style="height:100%; width:100%; background:#44795B; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
											<div
												style="width:50px; height:50px; background:#3B634C; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
													fill="none">
													<path
														d="M12.004 24C10.3453 24 8.78533 23.6853 7.324 23.056C5.86356 22.4258 4.59289 21.5707 3.512 20.4907C2.43111 19.4107 1.57556 18.1413 0.945333 16.6827C0.315111 15.224 0 13.6644 0 12.004C0 10.3436 0.315111 8.78356 0.945333 7.324C1.57556 5.86356 2.43067 4.59289 3.51067 3.512C4.59067 2.43111 5.86044 1.57556 7.32 0.945333C8.77956 0.315111 10.3396 0 12 0H12.6667V10.8533C12.896 10.9956 13.0644 11.1609 13.172 11.3493C13.2796 11.5378 13.3333 11.7556 13.3333 12.0027C13.3333 12.3582 13.2004 12.6689 12.9347 12.9347C12.6689 13.2004 12.3573 13.3333 12 13.3333C11.6427 13.3333 11.3311 13.2004 11.0653 12.9347C10.7996 12.6689 10.6667 12.3591 10.6667 12.0053C10.6667 11.76 10.7204 11.5409 10.828 11.348C10.9356 11.1551 11.104 10.9907 11.3333 10.8547V6.73067C10.0071 6.888 8.89778 7.46445 8.00533 8.46C7.11289 9.45556 6.66667 10.6356 6.66667 12C6.66667 13.4667 7.18889 14.7222 8.23333 15.7667C9.27778 16.8111 10.5333 17.3333 12 17.3333C13.4667 17.3333 14.7222 16.8111 15.7667 15.7667C16.8111 14.7222 17.3333 13.4667 17.3333 12C17.3333 11.2 17.172 10.4613 16.8493 9.784C16.5267 9.10667 16.088 8.512 15.5333 8L16.4853 7.04933C17.16 7.66267 17.692 8.39378 18.0813 9.24267C18.4707 10.0916 18.6658 11.0107 18.6667 12C18.6667 13.8516 18.0191 15.4258 16.724 16.7227C15.4289 18.0196 13.8564 18.6676 12.0067 18.6667C10.1569 18.6658 8.58133 18.0178 7.28 16.7227C5.98222 15.4258 5.33333 13.8516 5.33333 12C5.33333 10.2569 5.91111 8.75733 7.06667 7.50133C8.22222 6.24533 9.64444 5.53867 11.3333 5.38133V1.34933C8.53511 1.512 6.16889 2.61467 4.23467 4.65733C2.30044 6.7 1.33333 9.14756 1.33333 12C1.33333 14.9778 2.36667 17.5 4.43333 19.5667C6.5 21.6333 9.02222 22.6667 12 22.6667C14.9778 22.6667 17.5 21.6333 19.5667 19.5667C21.6333 17.5 22.6667 14.9778 22.6667 12C22.6667 10.4667 22.3667 9.03333 21.7667 7.7C21.1667 6.36667 20.3444 5.21111 19.3 4.23333L20.2507 3.28267C21.4151 4.38489 22.3311 5.68178 22.9987 7.17333C23.6662 8.66489 24 10.2711 24 11.992C24 13.6542 23.6853 15.2156 23.056 16.676C22.4258 18.1364 21.5707 19.4071 20.4907 20.488C19.4107 21.5689 18.1413 22.4244 16.6827 23.0547C15.224 23.6849 13.6644 24 12.004 24Z"
														fill="white"></path>
												</svg>
											</div>
											<span style="font-size:12px; color:white">
												Add Warranty,Insurance<br>&amp; Transport Options </span>

										</div>
									</div>
									<div class="col-4 p-0 px-md-1">
										<div
											style="height:100%; width:100%; background:#44795B; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
											<div
												style="width:50px; height:50px; background:#3B634C; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
												<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23"
													fill="none">
													<path
														d="M11.5 0C12.5557 0 13.5739 0.134766 14.5547 0.404297C15.5355 0.673828 16.4526 1.05941 17.3062 1.56104C18.1597 2.06266 18.9346 2.66162 19.6309 3.35791C20.3271 4.0542 20.9261 4.83285 21.4277 5.69385C21.9294 6.55485 22.3149 7.47201 22.5845 8.44531C22.854 9.41862 22.9925 10.4368 23 11.5C23 12.2412 22.9289 12.9712 22.7866 13.6899C22.6444 14.4087 22.4347 15.1162 22.1577 15.8125H18.6875V14.375H21.1357C21.4202 13.4316 21.5625 12.4733 21.5625 11.5C21.5625 10.5042 21.424 9.5459 21.147 8.625H17.0703C17.1302 9.10417 17.1751 9.57959 17.2051 10.0513C17.235 10.5229 17.25 11.0059 17.25 11.5H15.8125C15.8125 11.0133 15.7975 10.5342 15.7676 10.0625C15.7376 9.59082 15.689 9.11165 15.6216 8.625H7.37842C7.31852 9.10417 7.2736 9.57959 7.24365 10.0513C7.2137 10.5229 7.19499 11.0059 7.1875 11.5C7.1875 11.9867 7.20247 12.4658 7.23242 12.9375C7.26237 13.4092 7.31104 13.8883 7.37842 14.375H14.375V15.8125H7.62549C7.68538 16.1045 7.77148 16.4489 7.88379 16.8457C7.99609 17.2425 8.1346 17.6543 8.29932 18.0811C8.46403 18.5078 8.6512 18.9271 8.86084 19.3389C9.07048 19.7507 9.3138 20.125 9.59082 20.4619C9.86784 20.7988 10.1598 21.0646 10.4668 21.2593C10.7738 21.4539 11.1182 21.555 11.5 21.5625C11.7246 21.5625 11.938 21.5213 12.1401 21.439C12.3423 21.3566 12.5332 21.2443 12.7129 21.1021C12.8926 20.9598 13.0573 20.8063 13.207 20.6416C13.3568 20.4769 13.4953 20.3047 13.6226 20.125H14.375V22.6182C13.9033 22.7454 13.4279 22.839 12.9487 22.8989C12.4696 22.9588 11.9867 22.9925 11.5 23C10.4443 23 9.42611 22.8652 8.44531 22.5957C7.46452 22.3262 6.54736 21.9406 5.69385 21.439C4.84033 20.9373 4.06543 20.3384 3.36914 19.6421C2.67285 18.9458 2.07389 18.1672 1.57227 17.3062C1.07064 16.4452 0.685059 15.5317 0.415527 14.5659C0.145996 13.6001 0.00748698 12.5781 0 11.5C0 10.4443 0.134766 9.42611 0.404297 8.44531C0.673828 7.46452 1.05941 6.54736 1.56104 5.69385C2.06266 4.84033 2.66162 4.06543 3.35791 3.36914C4.0542 2.67285 4.83285 2.07389 5.69385 1.57227C6.55485 1.07064 7.46826 0.685059 8.43408 0.415527C9.3999 0.145996 10.4219 0.00748698 11.5 0ZM8.20947 1.98779C7.57308 2.20492 6.97038 2.48568 6.40137 2.83008C5.83236 3.17448 5.29704 3.56755 4.79541 4.00928C4.29378 4.45101 3.84831 4.93766 3.45898 5.46924C3.06966 6.00081 2.72152 6.57357 2.41455 7.1875H6.1543C6.23665 6.74577 6.33773 6.29655 6.45752 5.83984C6.57731 5.38314 6.72331 4.93018 6.89551 4.48096C7.06771 4.03174 7.26237 3.59749 7.47949 3.17822C7.69661 2.75895 7.93994 2.36214 8.20947 1.98779ZM8.20947 21.0122C7.93994 20.6453 7.69661 20.2523 7.47949 19.833C7.26237 19.4137 7.07145 18.9795 6.90674 18.5303C6.74202 18.0811 6.59603 17.6281 6.46875 17.1714C6.34147 16.7147 6.23665 16.2617 6.1543 15.8125H2.41455C2.70654 16.4189 3.05094 16.988 3.44775 17.5195C3.84456 18.0511 4.29378 18.5415 4.79541 18.9907C5.29704 19.4399 5.82861 19.833 6.39014 20.1699C6.95166 20.5068 7.55811 20.7876 8.20947 21.0122ZM5.92969 14.375C5.86979 13.8958 5.82487 13.4204 5.79492 12.9487C5.76497 12.4771 5.75 11.9941 5.75 11.5C5.75 11.0133 5.76497 10.5342 5.79492 10.0625C5.82487 9.59082 5.86979 9.11165 5.92969 8.625H1.85303C1.57601 9.5459 1.4375 10.5042 1.4375 11.5C1.4375 12.4958 1.57601 13.4541 1.85303 14.375H5.92969ZM15.3745 7.1875C15.3146 6.89551 15.2285 6.55111 15.1162 6.1543C15.0039 5.75749 14.8654 5.3457 14.7007 4.91895C14.536 4.49219 14.3488 4.07292 14.1392 3.66113C13.9295 3.24935 13.6862 2.875 13.4092 2.53809C13.1322 2.20117 12.8402 1.93538 12.5332 1.74072C12.2262 1.54606 11.8818 1.44499 11.5 1.4375C11.1331 1.4375 10.7925 1.53857 10.478 1.74072C10.1636 1.94287 9.86784 2.20866 9.59082 2.53809C9.3138 2.86751 9.07422 3.23812 8.87207 3.6499C8.66992 4.06169 8.479 4.4847 8.29932 4.91895C8.11963 5.35319 7.98112 5.76497 7.88379 6.1543C7.78646 6.54362 7.70036 6.88802 7.62549 7.1875H15.3745ZM20.5854 7.1875C20.2935 6.58105 19.9491 6.01204 19.5522 5.48047C19.1554 4.94889 18.7062 4.4585 18.2046 4.00928C17.703 3.56006 17.1714 3.16699 16.6099 2.83008C16.0483 2.49316 15.4419 2.2124 14.7905 1.98779C15.0601 2.35466 15.3034 2.74772 15.5205 3.16699C15.7376 3.58626 15.9285 4.02051 16.0933 4.46973C16.258 4.91895 16.404 5.37191 16.5312 5.82861C16.6585 6.28532 16.7633 6.73828 16.8457 7.1875H20.5854ZM17.25 17.25H21.5625V18.6875H17.25V23H15.8125V18.6875H11.5V17.25H15.8125V12.9375H17.25V17.25Z"
														fill="white"></path>
												</svg>
											</div>
											<span style="font-size:12px; color:white">
												Instant Payment to<br>Sellers with Trbo Swift </span>
											</span>

										</div>
									</div>



								</div>
							</div>

							<div class="bg-light p-3 mb-2" style="border-radius:22px;">
								<div class="mb-3">
									<div class="row mb-1">
										<div class="col financing-entry-title h5">No Pending Applications</div>
										<div class="col text-right">Application #<span
												class="financing-entry-id">9865445678556</span><i class="far fa-copy ml-1"></i>
										</div>
									</div>
									<span class="text-primary small">Trbo Swift partners with top lenders to get you the best rates
										and
										terms.
										Enjoy a seamless online financing process and add options for warranties, transportation,
										and
										escrow
										services.</span>
								</div>



								<div class="financing-process mb-3">

									<div class="container mb-4">
										<div class="progress-container">
											<div class="progress" id="financing-progress-bar"></div>

											<div class="step-wrap active" data-step="1">
												<div class="circle"><span class="step-title">1</span></div>
												<p class="text">Seller Details</p>
											</div>
											<div class="step-wrap" data-step="2">
												<div class="circle"><span class="step-title">2</span></div>
												<p class="text">Application Status</p>
											</div>
											<div class="step-wrap" data-step="3">
												<div class="circle"><span class="step-title">3</span></div>
												<p class="text">Payment</p>
											</div>
											<div class="step-wrap" data-step="4">
												<div class="circle"><span class="step-title">4</span></div>
												<p class="text">Vehicle Delivery</p>
											</div>
											<div class="step-wrap" data-step="5">
												<div class="circle"><span class="step-title">5</span></div>
												<p class="text">Complete</p>
											</div>

										</div>
										<div>

											<input type="hidden" id="finance_entry_id" value="">
											<input type="hidden" id="finance_pickup_id" value="">
											<input type="hidden" id="finance_entry_vehicle_name" value="">
											<input type="hidden" id="finance_entry_vehicle_vin" value="">
											<input type="hidden" id="financeBuyerEmailAddress" value="">
											<input type="hidden" id="financeSellerrEmailAddress" value="">

										<?php if (current_user_can('administrator')) { ?>
												<button class="btn btn-primary rounded-pill px-3" id="financing-step-back"
													disabled>&larr;
													Back</button>
												<button class="btn btn-secondary rounded-pill px-3 financing-step-next">Make
													Next</button>
										<?php } ?>
										</div>

									</div>



									<div id="step-details" class="mb-3">

										<div class="financing-process-step-details" data-step="0">
											<div class="container row m-0 p-2 bg-white" style="border-radius:22px;">

												<div class="row mx-0 gap-2 my-2 align-items-center">
													<h5>Apply for financing</h5>
													<div class="col-3"><?php echo $CORE->LAYOUT("get_logo", "light"); ?></div>
												</div>
												<p class="text-primary">We have exclusive partnerships with some of Canada’s largest
													lenders
													to get your best-in-market rates.</p>


												<div class="row m-0 my-2">
													<button class="btn btn-outline-secondary rounded-pill px-4 mr-3">Learn
														more</button>
													<a href="<?php echo home_url(); ?>/credit-application"
														class="btn btn-secondary rounded-pill px-4" target="blank">Apply for
														financing</a>
												</div>


											</div>


											<div class="financing-item-details bg-light p-3 mt-2" style="border-radius:22px;">
												<div class="h6 pb-5 mb-5"><i class="far fa-file"></i> Item details</div>

											</div>


										</div>


										<div class="financing-process-step-details" data-step="1">
											<div class="container m-0 p-2 bg-light" style="border-radius:22px;">

												<div class="col-12">

													<div class="form-group col-md-12 d-flex align-items-center px-0 mb-2">
														<span style="font-size:12px; color:#5f5f5f" for="nameRegisteredOwner"
															class="info-label mr-2">Name of Registered Owner</span>
														<input type="text" id="nameRegisteredOwner"
															class="col-6 form-control rounded-pill border-0" value="">
														<div class="input-group-append">
															<button
																class="scanSellerInfoBtn btn btn-secondary rounded-pill ml-2"><svg
																	xmlns="http://www.w3.org/2000/svg" width="24" height="24"
																	viewBox="0 0 24 24">
																	<g fill="none" stroke="currentColor" stroke-linejoin="round"
																		stroke-width="1">
																		<path
																			d="M9 3H8c-.93 0-1.395 0-1.776.102a3 3 0 0 0-2.122 2.122C4 5.605 4 6.07 4 7m11-4h1c.93 0 1.395 0 1.776.102a3 3 0 0 1 2.122 2.122C20 5.605 20 6.07 20 7m0 8v1c0 1.87 0 2.804-.402 3.5a3 3 0 0 1-1.098 1.098C17.804 21 16.87 21 15 21M4 15v1c0 1.87 0 2.804.402 3.5A3 3 0 0 0 5.5 20.598C6.196 21 7.13 21 9 21" />
																		<path stroke-linecap="round"
																			d="M3 15h18M7 11v4h10v-4c0-.943 0-1.414-.293-1.707S15.943 9 15 9H9c-.943 0-1.414 0-1.707.293S7 10.057 7 11" />
																	</g>
																</svg> Scan</button>
														</div>
													</div>
													<div class="col-md-12 row">



														<div id="isRegisteredOwner" class="col-md-6 row mt-2">
															<span class="mr-2" style="font-size:14px; color:#5f5f5f">Are you
																registered owner of the Vehicle?</span>

															<div class="form-check form-check-inline">
																<input class="form-check-input" type="radio"
																	name="isRegisteredOwner" value="Yes">
																<label class="form-check-label" for="isRegisteredOwner">
																	Yes
																</label>
															</div>
															<div class="form-check form-check-inline">
																<input class="form-check-input" type="radio"
																	name="isRegisteredOwner" value="No">
																<label class="form-check-label" for="isRegisteredOwner">
																	No
																</label>
															</div>

														</div>

														<div id="isAnyLiensVehicle" class="col-md-6 row mt-2">
															<span class="mr-2" style="font-size:14px; color:#5f5f5f">Are there any
																liens on the vehicle?</span>

															<div class="form-check form-check-inline">
																<input class="form-check-input" type="radio"
																	name="isAnyLiensVehicle" value="Yes">
																<label class="form-check-label" for="isAnyLiensVehicle">
																	Yes
																</label>
															</div>
															<div class="form-check form-check-inline">
																<input class="form-check-input" type="radio"
																	name="isAnyLiensVehicle" value="No">
																<label class="form-check-label" for="isAnyLiensVehicle">
																	No
																</label>
															</div>

														</div>

													</div>

													<div class="col-md-12 row mt-2">
														<!-- <div class="form-group col-md-6 pl-0">
												<label style="font-size:14px; color:#5f5f5f" for="isVehicleBeingPicked"
													class="info-label">Is the vehicle being picked up or
													delivered?</label>
												<select type="text" id="isVehicleBeingPicked"
													class="form-control rounded-pill">
													<option>Yes</option>
													<option>No</option>

												</select>
											</div> -->

														<div class="form-group col-md-6">
															<label style="font-size:14px; color:#5f5f5f" for="locationOfVehicle"
																class="info-label">Location of Vehicle</label>
															<input type="text" id="locationOfVehicle"
																class="form-control rounded-pill googleAutoLocation" value=""
																placeholder="Please enter address ">
														</div>

														<div class="form-group col-md-6">
															<label style="font-size:14px; color:#5f5f5f" for=""
																class="info-label">Earliest date for vehicle pick up</label>
															<input type="date" id="requestedPickupDate"
																class="form-control rounded-pill" value="">
														</div>
													</div>


													<div id="confirmVehiclePurchase" class="row mx-0 align-items-center my-2"
														style="font-size:14px; color:#5f5f5f">
														<strong class="mr-2">Please confirm the vehicle purchase price:</strong>
														<span class="vehicleVinNumber mr-2">VIN:SCBZR03B0KCX24723</span>
														<span class="vehiclePurchasePrice mr-3">$55440</span>

														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio"
																name="confirmVehiclePurchase" value="Yes">
															<label class="form-check-label" for="confirmVehiclePurchase">
																Yes
															</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio"
																name="confirmVehiclePurchase" value="No">
															<label class="form-check-label" for="confirmVehiclePurchase">
																No
															</label>
														</div>

													</div>

													<div class="form-row">
														<div class="col-md-9 row m-0 align-items-center">
															<label class="form-label mr-2">
																Enter your amount here:
															</label>
															<div class="col-md-6 input-group mb-3 rounded-pill bg-white"
																style="border-radius: 50px !important; overflow: hidden;">
																<div class="input-group-prepend bg-white"
																	style="border-top-left-radius:50px; border-bottom-left-radius:50px;">
																	<span class="input-group-text bg-white px-4"
																		style="background-white!important; border-top-left-radius:50px; border-bottom-left-radius:50px;">$
																	</span>
																</div>
																<input type="text" class="suggestedPrice form-control"
																	style="border-top-right-radius:50px; border-bottom-right-radius:50px;">

															</div>

														</div>
													</div>

													<div class="col-12 col-md-4 p-0 license-image-column">

														<div class="d-flex flex-wrap py-3" id="sellerDocumentProofPreviewContainer">
															<div class="col-12 px-0">
																<img class="vehicleOwnershipImage d-none" src=""
																	style="width:100%; height:100%; border-radius:10px;" />
															</div>
														</div>

														<div class="custom-file-drop" id="sellerDocumentProofDropArea">
															<!-- <p>Upload document or image</p> -->
															<img
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/Group-1321315199.svg" /><br>
															<span class="small">Please update copy of Vehicle Ownership</span>
															<br>

															<div class="text-center my-2">
																<button class="docProofUpBtn btn btn-outline-primary px-2 py-1"
																	style="width: 130px; font-size: 12px;">Browse</button><br>

															</div>


															<input type="file" name="file" id="sellerDocumentProofFileInput"
																style="display: none;">
														</div>

													</div>

												</div>


												<div class="col-12">
													<div class="mt-4">
														<strong>Note: </strong>Only complete the inspection when you are in
														possession
														of the vehicle
													</div>

													<div class="mt-3">
														<button
															class="getFinanceInspectionUrl btn btn-outline-secondary rounded-pill px-4 mb-3 mb-md-0 mr-md-3">Complete
															Inspection</button>
														<button
															class="SellerDetailsToNext btn btn-secondary rounded-pill px-4">Next</button>
													</div>
													<div class="py-4">
														<div class="financeIncSellerWebappUrl"></div>
														<div class="financeIncSellerResponseResult"></div>
													</div>
												</div>



											</div>

										</div>
										<div class="financing-process-step-details" data-step="2" style="display: none;">

											<div class="container row m-0 p-2 bg-white" style="border-radius:22px;">

												<div class="col-12">

													<div class="py-3">
														<span class="small">Thank you for submitting the necessary details. The
															buyer's finance application is still under review. We will send you a
															text message once it’s time to move forward with the payment. The funds
															will be securely held in trust by Trbo Swift until the vehicle is
															delivered to the buyer. </span>

													</div>

													<div class="d-flex flex-column flex-md-row my-2">
														<span
															class="financeApplicationDecision btn btn-secondary rounded-pill px-4 mb-2 mb-md-0 mr-md-2">Decision:
															Pending</span>
														<button
															class="financeViewAggriment btn btn-secondary rounded-pill px-4 disabled">View
															Agreement</span>
													</div>

													<div><small>Kindly review the agreement once the buyer has been approved, so we
															can proceed to the next step.</small></div>
												</div>
											</div>


											<div class="financing-item-details bg-white p-3 mt-2" style="border-radius:22px;"></div>



										</div>
										<div class="financing-process-step-details" data-step="3" style="display: none;">
											<!-- <div class="container row m-0 p-2 bg-white" style="border-radius:22px;">

									<div class="col-12">

										<div class="row mx-0 gap-2 my-2 align-items-center">
											<h5>Vehicle Pickup Details</h5>

										</div>
										<p class="small">Seller must be present with Photo ID when the vehicle is picked
											up by the seller or transport company </p>

										<div class="col-12 px-0 form-row my-3">
											<div class="form-group col-md-4">
												<label style="font-size:12px; color:#5f5f5f" for="sellerPickUpAddress"
													class="info-label">Address</label>
												<input type="text" id="sellerPickUpAddress"
													class="form-control rounded-pill googleAutoLocation" value="">
											</div>
											<div class="form-group col-md-4">
												<label style="font-size:12px; color:#5f5f5f" for="vehiclePickupDate"
													class="info-label">Requested Pickup Date</label>
												<input type="date" id="vehiclePickupDate"
													class="form-control rounded-pill" value="">
											</div>
											<div class="form-group col-md-4">
												<label style="font-size:12px; color:#5f5f5f" for="Dropoff Details"
													class="info-label"> Dropoff Details</label>
												<input type="text" id="dropoffDetails" class="form-control rounded-pill"
													value="">
											</div>


										</div>

										<div>

											<button type="submit"
												class="SellerNextBtn btn btn-secondary rounded-pill px-4">Next</button>

										</div>


									</div>
								</div> -->

											<div class="container row m-0 p-2 bg-white" style="border-radius:22px;">

												<div class="col-12">


													<h5><span class="text-primary">Step 1:</span> KYC Verification</h5>
													<p>Please capture a photo of your driver's license along with a simple selfie.
														You can do this using either a smartphone or a web browser. We'll need this
														to verify the registered owner of the vehicle in order to issue payment.</p>

													<span
														class="sellerKycStatus btn btn-outline-secondary rounded-pill px-4 mb-2 mr-2"
														style="font-size:12px;">Status Pending</span>
													<div id="finance-veriff-root" class="col-md-4 px-0">

														<button class="btn btn-secondary rounded-pill px-4"
															style="font-size:12px;">Get Verified</button>
													</div>

												</div>
											</div>


											<div class="container row mt-3 mx-0 p-2 bg-white" style="border-radius:22px;">

												<div class="col-12">


													<h5><span class="text-primary">Step 2:</span> Please Select Payout Method</h5>

													<div id="selectPayoutMethod" class="my-2">

														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="isAnyLiensVehicle"
																value="Wire Transfer">
															<label class="form-check-label" for="isAnyLiensVehicle">
																Wire Transfer
															</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="isAnyLiensVehicle"
																value="Hyperwallet Payment (Faster)">
															<label class="form-check-label" for="isAnyLiensVehicle">
																Hyperwallet Payment (Faster)
															</label>
														</div>

													</div>

													<p>HyperWallet payments are sent directly to your email, enabling you to
														transfer funds anywhere faster than a wire transfer, often within hours.</p>

													<div class="mt-2">

														<button class="financing-step-next btn btn-secondary rounded-pill px-4"
															style="font-size:12px;">Finish</button>
													</div>

												</div>
											</div>

											<!-- <div class="col-md-12 row mx-0 mt-3 bg-secondary radiusx p-2 d-none" bis_skin_checked="1">
									<div class="col-md-9" bis_skin_checked="1">
										<div>
											<h4 class="text-white font-weight-bold">Trbo Swift <strong
													class="text-primary">Escrow Services</strong></h4>
										</div>
										<span class="small text-white">Trbo Swift Escrow ensures your safest transaction
											when purchasing vehicles online. Any Vehicle, Any Marketplace</span>

										<div class="col-12 mt-2 col-md-12 d-flex justify-content-start align-items-end">
											<div class="p-2">
												<div
													style="height:100%; width:100%; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
													<div
														style="width:50px; height:50px; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
														<svg xmlns="http://www.w3.org/2000/svg" width="37" height="65"
															viewBox="0 0 37 65" fill="none">
															<path
																d="M0 0V64.75H37V0H0ZM23.125 60.125H13.875V55.5H23.125V60.125ZM32.375 50.875H4.625V9.25H32.375V50.875Z"
																fill="white"></path>
															<path fill-rule="evenodd" clip-rule="evenodd"
																d="M9 32C9 27.286 9 24.929 10.464 23.464C11.93 22 14.286 22 19 22C23.714 22 26.071 22 27.535 23.464C29 24.93 29 27.286 29 32C29 36.714 29 39.071 27.535 40.535C26.072 42 23.714 42 19 42C14.286 42 11.929 42 10.464 40.535C9 39.072 9 36.714 9 32ZM17.004 25.752C17.1025 25.7515 17.1999 25.7316 17.2907 25.6934C17.3815 25.6552 17.4639 25.5995 17.5332 25.5295C17.6024 25.4595 17.6572 25.3765 17.6944 25.2853C17.7316 25.1941 17.7505 25.0965 17.75 24.998C17.7495 24.8995 17.7296 24.8021 17.6914 24.7113C17.6532 24.6205 17.5975 24.5381 17.5275 24.4688C17.4575 24.3996 17.3745 24.3448 17.2833 24.3076C17.1921 24.2704 17.0945 24.2515 16.996 24.252C15.914 24.257 15.016 24.282 14.283 24.41C13.531 24.542 12.888 24.792 12.361 25.294C11.906 25.727 11.601 26.166 11.436 26.797C11.286 27.368 11.259 28.072 11.252 28.994C11.2512 29.0925 11.2698 29.1902 11.3068 29.2815C11.3438 29.3728 11.3983 29.4559 11.4674 29.5261C11.5365 29.5963 11.6188 29.6522 11.7094 29.6906C11.8001 29.729 11.8975 29.7492 11.996 29.75C12.0945 29.7508 12.1922 29.7322 12.2835 29.6952C12.3748 29.6582 12.4579 29.6037 12.5281 29.5346C12.5983 29.4655 12.6542 29.3832 12.6926 29.2926C12.731 29.2019 12.7512 29.1045 12.752 29.006C12.76 28.057 12.792 27.54 12.887 27.178C12.967 26.875 13.093 26.668 13.396 26.38C13.638 26.15 13.968 25.988 14.541 25.888C15.133 25.784 15.911 25.758 17.004 25.752ZM21.004 24.252C20.8051 24.2509 20.6139 24.3289 20.4725 24.4688C20.3311 24.6087 20.2511 24.7991 20.25 24.998C20.2489 25.1969 20.3269 25.3881 20.4668 25.5295C20.6067 25.6709 20.7971 25.7509 20.996 25.752C22.089 25.758 22.867 25.784 23.459 25.888C24.032 25.988 24.362 26.15 24.604 26.38C24.907 26.668 25.034 26.875 25.113 27.178C25.208 27.54 25.241 28.057 25.248 29.006C25.2496 29.2049 25.3301 29.395 25.4719 29.5346C25.6137 29.6741 25.8051 29.7516 26.004 29.75C26.2029 29.7484 26.393 29.6679 26.5326 29.5261C26.6721 29.3843 26.7496 29.1929 26.748 28.994C26.741 28.072 26.714 27.368 26.564 26.797C26.398 26.167 26.094 25.727 25.639 25.294C25.112 24.792 24.469 24.542 23.717 24.41C22.984 24.282 22.086 24.257 21.004 24.252ZM12 31.25C11.8011 31.25 11.6103 31.329 11.4697 31.4697C11.329 31.6103 11.25 31.8011 11.25 32C11.25 32.1989 11.329 32.3897 11.4697 32.5303C11.6103 32.671 11.8011 32.75 12 32.75H26C26.1989 32.75 26.3897 32.671 26.5303 32.5303C26.671 32.3897 26.75 32.1989 26.75 32C26.75 31.8011 26.671 31.6103 26.5303 31.4697C26.3897 31.329 26.1989 31.25 26 31.25H12ZM12.752 34.994C12.7504 34.7951 12.6699 34.605 12.5281 34.4654C12.3863 34.3259 12.1949 34.2484 11.996 34.25C11.7971 34.2516 11.607 34.3321 11.4674 34.4739C11.3279 34.6157 11.2504 34.8071 11.252 35.006C11.259 35.929 11.286 36.632 11.436 37.203C11.602 37.833 11.906 38.273 12.361 38.706C12.888 39.208 13.531 39.458 14.283 39.59C15.016 39.718 15.914 39.743 16.996 39.748C17.0945 39.7485 17.1921 39.7296 17.2833 39.6924C17.3745 39.6552 17.4575 39.6004 17.5275 39.5312C17.5975 39.4619 17.6532 39.3795 17.6914 39.2887C17.7296 39.1979 17.7495 39.1005 17.75 39.002C17.7505 38.9035 17.7316 38.8059 17.6944 38.7147C17.6572 38.6235 17.6024 38.5405 17.5332 38.4705C17.4639 38.4005 17.3815 38.3448 17.2907 38.3066C17.1999 38.2684 17.1025 38.2485 17.004 38.248C15.911 38.243 15.133 38.216 14.541 38.112C13.968 38.012 13.638 37.851 13.396 37.62C13.093 37.332 12.966 37.125 12.887 36.822C12.792 36.461 12.76 35.943 12.752 34.994ZM26.748 35.006C26.7488 34.9075 26.7302 34.8098 26.6932 34.7185C26.6562 34.6272 26.6017 34.5441 26.5326 34.4739C26.393 34.3321 26.2029 34.2516 26.004 34.25C25.8051 34.2484 25.6137 34.3259 25.4719 34.4654C25.3301 34.605 25.2496 34.7951 25.248 34.994C25.24 35.944 25.208 36.461 25.113 36.822C25.033 37.125 24.907 37.332 24.604 37.62C24.362 37.85 24.032 38.012 23.459 38.112C22.867 38.216 22.089 38.242 20.996 38.248C20.8975 38.2485 20.8001 38.2684 20.7093 38.3066C20.6185 38.3448 20.5361 38.4005 20.4668 38.4705C20.3269 38.6119 20.2489 38.8031 20.25 39.002C20.2511 39.2009 20.3311 39.3913 20.4725 39.5312C20.6139 39.6711 20.8051 39.7491 21.004 39.748C22.086 39.743 22.984 39.718 23.717 39.59C24.469 39.458 25.112 39.208 25.639 38.706C26.094 38.273 26.399 37.834 26.564 37.203C26.714 36.632 26.741 35.929 26.748 35.006Z"
																fill="white"></path>
														</svg>
													</div>
													<span style="font-size:12px; color:white">Payment Protection</span>

												</div>
											</div>
											<div class="p-2">
												<div
													style="height:100%; width:100%; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
													<div
														style="width:50px; height:50px; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
														<svg xmlns="http://www.w3.org/2000/svg" width="66" height="64"
															viewBox="0 0 66 64" fill="none">
															<g clip-path="url(#clip0_2656_7075)">
																<path
																	d="M27.5625 50.1693C27.5625 51.2912 27.2395 52.2449 26.5935 53.0303C25.9475 53.8156 25.1733 54.2083 24.271 54.2083H11.1665C10.2642 54.2083 9.48999 53.8156 8.84399 53.0303C8.198 52.2449 7.875 51.2912 7.875 50.1693C7.875 49.0677 7.9519 48.0426 8.10571 47.0941C8.25952 46.1455 8.51074 45.2275 8.85938 44.3402C9.20801 43.4528 9.73096 42.7541 10.4282 42.2441C11.1255 41.7342 11.9561 41.4792 12.9199 41.4792C14.2324 42.7847 15.832 43.4375 17.7188 43.4375C19.6055 43.4375 21.2051 42.7847 22.5176 41.4792C23.4814 41.4792 24.312 41.7342 25.0093 42.2441C25.7065 42.7541 26.2295 43.4528 26.5781 44.3402C26.9268 45.2275 27.178 46.1455 27.3318 47.0941C27.4856 48.0426 27.5625 49.0677 27.5625 50.1693ZM23.625 36.5833C23.625 38.2153 23.0508 39.6024 21.9023 40.7448C20.7539 41.8872 19.3594 42.4583 17.7188 42.4583C16.0781 42.4583 14.6836 41.8872 13.5352 40.7448C12.3867 39.6024 11.8125 38.2153 11.8125 36.5833C11.8125 34.9514 12.3867 33.5642 13.5352 32.4219C14.6836 31.2795 16.0781 30.7083 17.7188 30.7083C19.3594 30.7083 20.7539 31.2795 21.9023 32.4219C23.0508 33.5642 23.625 34.9514 23.625 36.5833ZM55.125 49.3125V51.2708C55.125 51.5564 55.0327 51.791 54.8481 51.9746C54.6636 52.1582 54.4277 52.25 54.1406 52.25H32.4844C32.1973 52.25 31.9614 52.1582 31.7769 51.9746C31.5923 51.791 31.5 51.5564 31.5 51.2708V49.3125C31.5 49.0269 31.5923 48.7923 31.7769 48.6087C31.9614 48.4251 32.1973 48.3333 32.4844 48.3333H54.1406C54.4277 48.3333 54.6636 48.4251 54.8481 48.6087C55.0327 48.7923 55.125 49.0269 55.125 49.3125ZM43.3125 41.4792V43.4375C43.3125 43.7231 43.2202 43.9577 43.0356 44.1413C42.8511 44.3249 42.6152 44.4167 42.3281 44.4167H32.4844C32.1973 44.4167 31.9614 44.3249 31.7769 44.1413C31.5923 43.9577 31.5 43.7231 31.5 43.4375V41.4792C31.5 41.1936 31.5923 40.959 31.7769 40.7754C31.9614 40.5918 32.1973 40.5 32.4844 40.5H42.3281C42.6152 40.5 42.8511 40.5918 43.0356 40.7754C43.2202 40.959 43.3125 41.1936 43.3125 41.4792ZM55.125 41.4792V43.4375C55.125 43.7231 55.0327 43.9577 54.8481 44.1413C54.6636 44.3249 54.4277 44.4167 54.1406 44.4167H48.2344C47.9473 44.4167 47.7114 44.3249 47.5269 44.1413C47.3423 43.9577 47.25 43.7231 47.25 43.4375V41.4792C47.25 41.1936 47.3423 40.959 47.5269 40.7754C47.7114 40.5918 47.9473 40.5 48.2344 40.5H54.1406C54.4277 40.5 54.6636 40.5918 54.8481 40.7754C55.0327 40.959 55.125 41.1936 55.125 41.4792ZM55.125 33.6458V35.6042C55.125 35.8898 55.0327 36.1243 54.8481 36.3079C54.6636 36.4915 54.4277 36.5833 54.1406 36.5833H32.4844C32.1973 36.5833 31.9614 36.4915 31.7769 36.3079C31.5923 36.1243 31.5 35.8898 31.5 35.6042V33.6458C31.5 33.3602 31.5923 33.1257 31.7769 32.9421C31.9614 32.7585 32.1973 32.6667 32.4844 32.6667H54.1406C54.4277 32.6667 54.6636 32.7585 54.8481 32.9421C55.0327 33.1257 55.125 33.3602 55.125 33.6458ZM59.0625 59.1042V24.8333H3.9375V59.1042C3.9375 59.3694 4.03491 59.5989 4.22974 59.7926C4.42456 59.9864 4.65527 60.0833 4.92188 60.0833H58.0781C58.3447 60.0833 58.5754 59.9864 58.7703 59.7926C58.9651 59.5989 59.0625 59.3694 59.0625 59.1042ZM63 21.8958V59.1042C63 60.4505 62.5181 61.6031 61.5542 62.5619C60.5903 63.5206 59.4316 64 58.0781 64H4.92188C3.56836 64 2.40967 63.5206 1.4458 62.5619C0.481934 61.6031 0 60.4505 0 59.1042V21.8958C0 20.5495 0.481934 19.3969 1.4458 18.4382C2.40967 17.4794 3.56836 17 4.92188 17H58.0781C59.4316 17 60.5903 17.4794 61.5542 18.4382C62.5181 19.3969 63 20.5495 63 21.8958Z"
																	fill="white"></path>
															</g>
															<path
																d="M55.5625 9.86758L54.2164 8.52145L53.8628 8.16789L53.5093 8.52145L52.5839 9.44676L52.2304 9.80031L52.5839 10.1539L55.2089 12.7789L55.5625 13.1324L55.9161 12.7789L61.1661 7.52887L61.5196 7.17531L61.1661 6.82176L60.2407 5.89645L59.8872 5.54289L59.5336 5.89645L55.5625 9.86758Z"
																fill="white" stroke="#3B634C"></path>
															<path
																d="M56.875 19.9416L56.6398 19.8162L52.5872 17.6554C52.5871 17.6553 52.5869 17.6553 52.5868 17.6552C51.3512 16.9979 50.318 16.0166 49.598 14.8166C48.878 13.6165 48.4984 12.243 48.5 10.8435M56.875 19.9416L60.928 17.214C62.0835 16.5994 63.0499 15.6817 63.7232 14.5594C64.3966 13.4371 64.7515 12.1526 64.75 10.8438H65.25V10.8432V2.3125C65.25 1.8318 65.059 1.37078 64.7191 1.03087C64.3792 0.690959 63.9182 0.5 63.4375 0.5H50.3125C49.8318 0.5 49.3708 0.690959 49.0309 1.03087C48.691 1.37078 48.5 1.8318 48.5 2.3125V10.8435M56.875 19.9416L57.1103 19.8162L61.1628 17.6554C61.1629 17.6554 61.163 17.6553 61.163 17.6553L56.875 19.9416ZM48.5 10.8435C48.5 10.8434 48.5 10.8433 48.5 10.8432L49 10.8438M48.5 10.8435V10.8438H49M49 10.8438C48.9985 12.1526 49.3534 13.4371 50.0268 14.5594C50.7002 15.6817 51.6665 16.5994 52.822 17.214L49 10.8438ZM50.8125 2.8125H62.9375V10.8438V10.8441C62.9383 11.8243 62.6723 12.7862 62.168 13.6266C61.6637 14.4671 60.9401 15.1544 60.0749 15.615L60.0746 15.6151L56.875 17.3207L53.6755 15.6145L53.6751 15.6143C52.81 15.1538 52.0865 14.4666 51.5822 13.6262C51.0779 12.7859 50.8118 11.8241 50.8125 10.8441V10.8438V2.8125Z"
																fill="white" stroke="#3B634C"></path>
															<defs>
																<clipPath id="clip0_2656_7075">
																	<rect width="63" height="47" fill="white"
																		transform="translate(0 17)"></rect>
																</clipPath>
															</defs>
														</svg>
													</div>
													<span style="font-size:12px; color:white">
														Verification </span>

												</div>
											</div>
											<div class="p-2">
												<div
													style="height:100%; width:100%; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
													<div
														style="width:50px; height:50px; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
														<svg xmlns="http://www.w3.org/2000/svg" width="44" height="57"
															viewBox="0 0 44 57" fill="none">
															<path
																d="M24.5 2V19.6667H42M2 2V55H42V18.4048L41.295 18.0868C34.5081 15.0416 29.0814 9.56322 26.065 2.71171L25.75 2H2Z"
																stroke="white" stroke-width="3"></path>
															<path
																d="M22 26C16.5 26 12 30.5 12 36C12 41.5 16.5 46 22 46C27.5 46 32 41.5 32 36C32 30.5 27.5 26 22 26ZM22 44C17.59 44 14 40.41 14 36C14 31.59 17.59 28 22 28C26.41 28 30 31.59 30 36C30 40.41 26.41 44 22 44ZM26.59 31.58L20 38.17L17.41 35.59L16 37L20 41L28 33L26.59 31.58Z"
																fill="white"></path>
														</svg>
													</div>
													<span style="font-size:12px; color:white">
														Fraud Prevention</span>
													</span>

												</div>
											</div>



										</div>

										<div class="text-white">Instant lien searches powered by <img
												src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/carfax.svg" /></div>

									</div>
									<div class="col-3 row d-flex align-items-center justify-content-end">
										<img decoding="async"
											style="width:100%; height:100%; object-fit:contain; text-align:center;"
											src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Group-1321315442.png">
									</div>
								</div> -->

										</div>
										<div class="financing-process-step-details" data-step="4" style="display: none;">
											<div class="container row m-0 p-2 bg-white mb-2" style="border-radius:22px;">
												<div class="col-12">
													<h5 class="mb-2">Pickup / Delivery</h5>

													<button
														onclick="jQuery('.newUserAddModalBody').removeClass('d-none').addClass('d-flex');"
														class="btn btn-secondary rounded-pill px-4 float-lg-right">View
														Calander</button>


													<span>Click ‘View Calendar’ to choose your vehicle pick date and time</span>
													<small>Once your pickup is confirmed, Turbo Swift will assign a delivery
														partner. Track updates below.</small>

													<div class="form-group col-md-4 p-0">
														<label style="font-size:12px; color:#5f5f5f"
															for="transportCompanyPickupDate" class="info-label">Earliest Pickup
															Date</label>
														<input type="date" id="transportCompanyPickupDate"
															class="form-control rounded-pill" value="">
													</div>


													<div class="col-12 form-row mb-3 p-0 d-none">
														<div class="form-group col-md-3">
															<label style="font-size:12px; color:#5f5f5f" for="sellerPickUpAddress"
																class="info-label">Seller Address</label>
															<input type="text" id="sellerPickUpAddress"
																class="form-control rounded-pill googleAutoLocation" value=""
																disabled>
														</div>
														<div class="form-group col-md-3">
															<label style="font-size:12px; color:#5f5f5f" for="Date"
																class="info-label">Date</label>
															<input type="date" id="vehiclePickupDate"
																class="form-control rounded-pill" value="" disabled>
														</div>
														<div class="form-group col-md-3">
															<label style="font-size:12px; color:#5f5f5f" for="preferredTimePickup"
																class="info-label">Preferred time for Pickup</label>
															<input type="time" id="preferredTimePickup"
																class="form-control rounded-pill" value="" disabled>
														</div>


													</div>

													<!-- <span>Add Details of Transport Company</span>
										<div class="col-12 form-row mb-3 p-0">
											<div class="form-group col-md-3">
												<label style="font-size:12px; color:#5f5f5f" for="transportCompanyName"
													class="info-label">Transport Company</label>
												<input type="text" id="transportCompanyName"
													class="form-control rounded-pill" value="">
											</div>
											<div class="form-group col-md-3">
												<label style="font-size:12px; color:#5f5f5f"
													for="transportCompanyPhoneNumber" class="info-label">Phone
													Number</label>
												<input type="tel" id="transportCompanyPhoneNumber"
													class="form-control rounded-pill" value="">
											</div>
											
											<div class="form-group col-md-3">
												<label style="font-size:12px; color:#5f5f5f"
													for="transportCompanyTrackingNumber" class="info-label">Tracking
													Number</label>
												<input type="text" id="transportCompanyTrackingNumber"
													class="form-control rounded-pill" value="">
											</div>


										</div>

										<div id="isVehicleBeingPicked" class="col-md-12 row mt-2">
											<span class="mr-2" style="font-size:14px; color:#5f5f5f">Is the vehicle
												being picked up?</span>

											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="isRegisteredOwner"
													value="Yes">
												<label class="form-check-label" for="isRegisteredOwner">
													Yes
												</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="isRegisteredOwner"
													value="No">
												<label class="form-check-label" for="isRegisteredOwner">
													No
												</label>
											</div>

										</div> -->

												</div>
											</div>




											<div class="container m-0 p-2" style="border-radius:10px;">

												<div class="transportLocationStatus">
													<div class="position-relative">
														<div class="finance_map_container" style="width: 100%; min-height: 361px;">
														</div>

														<div class="transportDetailsInMap"></div>
													</div>
													<div id="transportDetails"></div>
												</div>

											</div>

										</div>
										<div class="financing-process-step-details" data-step="5" style="display: none;">
											<div class="container row m-0 p-4 bg-white" style="border-radius:22px; ">

												<div class="mx-0 gap-2 my-2 align-items-center">
													<h5 class="mb-2">Complete
													</h5>
													<p>Please confirm that the vehicle has been picked up by the buyer or transport
														company.Trbo Swift will verify the details of this transaction
													</p>

												</div>

												<div>
													<button id="confirmSellerFinanceComplete"
														class="btn btn-secondary rounded-pill">Confirm</button>

												</div>



											</div>

											<!-- Second block -->

											<div class="financingTransactionSummary bg-white p-4 mt-2" style="border-radius:22px;">
											</div>


										</div>


									</div>

									<button class="financing-step-next btn btn-primary rounded-pill px-5">Next</button>


								</div><!-- Process Close -->


							</div>
						</div>

				<?php } else { ?>


						<div id="financeBuyerSection">
							<div class="turbobidfinancing financing-bg-green mb-2 align-items-stretch">
								<img style="position: relative; padding: 20px; background: white; border-radius: 20px;"
									loading="lazy" alt="turbobid financing icon"
									src="<?php echo home_url(); ?>/wp-content/uploads/2024/07/Vector-2.svg" />

								<section class="turbobidfinancing-inner col-6 col-md-4">
									<div style="gap:8px">
										<div class="turbobid-financing-services-wrapper">
											<h3 class="turbobid-financing-services">Financing</h3>
										</div>
										<div class="lien-service">
											<div class="the-lien-payoff">
												Any Vehicle, Any Marketplace

											</div>
											<a href="<?php echo home_url() ?>/finance" class="btn btn-primary rounded-pill px-3"
												style="font-size:10px">Explore Finance</a>
										</div>

									</div>
								</section>
								<div class="col-12 col-md d-flex justify-content-between align-items-stretch">
									<div class="col-4">
										<div
											style="height:100%; width:100%; background:#44795B; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
											<div
												style="width:50px; height:50px; background:#3B634C; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
												<svg xmlns="http://www.w3.org/2000/svg" width="23" height="26" viewBox="0 0 23 26"
													fill="none">
													<path d="M7.39062 11.3485L9.9779 13.9352L15.1518 8.76123" stroke="white"
														stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
													<path
														d="M11.2715 24.2837L12.4096 23.7919C14.7959 22.7679 16.8565 21.1105 18.3683 18.9992C19.8801 16.8878 20.7853 14.4031 20.986 11.8142L21.5424 4.67385C21.5514 4.37815 21.4587 4.08829 21.2797 3.85276C21.1007 3.61723 20.8462 3.45031 20.5589 3.3799L11.2715 1L1.98409 3.32837C1.69685 3.39875 1.44248 3.56559 1.26347 3.80099C1.08446 4.03639 0.991664 4.3261 1.00059 4.6217L1.55691 11.762C1.75752 14.3511 2.66274 16.8359 4.17451 18.9474C5.68628 21.0588 7.74698 22.7163 10.1334 23.7404L11.2715 24.2837Z"
														stroke="white" stroke-width="1.5" stroke-linecap="round"
														stroke-linejoin="round">
													</path>
												</svg>
											</div>
											<span style="font-size:12px; color:white">Secure &amp; Fast<br>Approvals </span>

										</div>
									</div>
									<div class="col-4">
										<div
											style="height:100%; width:100%; background:#44795B; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
											<div
												style="width:50px; height:50px; background:#3B634C; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
													fill="none">
													<path
														d="M12.004 24C10.3453 24 8.78533 23.6853 7.324 23.056C5.86356 22.4258 4.59289 21.5707 3.512 20.4907C2.43111 19.4107 1.57556 18.1413 0.945333 16.6827C0.315111 15.224 0 13.6644 0 12.004C0 10.3436 0.315111 8.78356 0.945333 7.324C1.57556 5.86356 2.43067 4.59289 3.51067 3.512C4.59067 2.43111 5.86044 1.57556 7.32 0.945333C8.77956 0.315111 10.3396 0 12 0H12.6667V10.8533C12.896 10.9956 13.0644 11.1609 13.172 11.3493C13.2796 11.5378 13.3333 11.7556 13.3333 12.0027C13.3333 12.3582 13.2004 12.6689 12.9347 12.9347C12.6689 13.2004 12.3573 13.3333 12 13.3333C11.6427 13.3333 11.3311 13.2004 11.0653 12.9347C10.7996 12.6689 10.6667 12.3591 10.6667 12.0053C10.6667 11.76 10.7204 11.5409 10.828 11.348C10.9356 11.1551 11.104 10.9907 11.3333 10.8547V6.73067C10.0071 6.888 8.89778 7.46445 8.00533 8.46C7.11289 9.45556 6.66667 10.6356 6.66667 12C6.66667 13.4667 7.18889 14.7222 8.23333 15.7667C9.27778 16.8111 10.5333 17.3333 12 17.3333C13.4667 17.3333 14.7222 16.8111 15.7667 15.7667C16.8111 14.7222 17.3333 13.4667 17.3333 12C17.3333 11.2 17.172 10.4613 16.8493 9.784C16.5267 9.10667 16.088 8.512 15.5333 8L16.4853 7.04933C17.16 7.66267 17.692 8.39378 18.0813 9.24267C18.4707 10.0916 18.6658 11.0107 18.6667 12C18.6667 13.8516 18.0191 15.4258 16.724 16.7227C15.4289 18.0196 13.8564 18.6676 12.0067 18.6667C10.1569 18.6658 8.58133 18.0178 7.28 16.7227C5.98222 15.4258 5.33333 13.8516 5.33333 12C5.33333 10.2569 5.91111 8.75733 7.06667 7.50133C8.22222 6.24533 9.64444 5.53867 11.3333 5.38133V1.34933C8.53511 1.512 6.16889 2.61467 4.23467 4.65733C2.30044 6.7 1.33333 9.14756 1.33333 12C1.33333 14.9778 2.36667 17.5 4.43333 19.5667C6.5 21.6333 9.02222 22.6667 12 22.6667C14.9778 22.6667 17.5 21.6333 19.5667 19.5667C21.6333 17.5 22.6667 14.9778 22.6667 12C22.6667 10.4667 22.3667 9.03333 21.7667 7.7C21.1667 6.36667 20.3444 5.21111 19.3 4.23333L20.2507 3.28267C21.4151 4.38489 22.3311 5.68178 22.9987 7.17333C23.6662 8.66489 24 10.2711 24 11.992C24 13.6542 23.6853 15.2156 23.056 16.676C22.4258 18.1364 21.5707 19.4071 20.4907 20.488C19.4107 21.5689 18.1413 22.4244 16.6827 23.0547C15.224 23.6849 13.6644 24 12.004 24Z"
														fill="white"></path>
												</svg>
											</div>
											<span style="font-size:12px; color:white">
												Add Warranty,Insurance<br>&amp; Transport Options </span>

										</div>
									</div>
									<div class="col-4">
										<div
											style="height:100%; width:100%; background:#44795B; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
											<div
												style="width:50px; height:50px; background:#3B634C; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
												<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23"
													fill="none">
													<path
														d="M11.5 0C12.5557 0 13.5739 0.134766 14.5547 0.404297C15.5355 0.673828 16.4526 1.05941 17.3062 1.56104C18.1597 2.06266 18.9346 2.66162 19.6309 3.35791C20.3271 4.0542 20.9261 4.83285 21.4277 5.69385C21.9294 6.55485 22.3149 7.47201 22.5845 8.44531C22.854 9.41862 22.9925 10.4368 23 11.5C23 12.2412 22.9289 12.9712 22.7866 13.6899C22.6444 14.4087 22.4347 15.1162 22.1577 15.8125H18.6875V14.375H21.1357C21.4202 13.4316 21.5625 12.4733 21.5625 11.5C21.5625 10.5042 21.424 9.5459 21.147 8.625H17.0703C17.1302 9.10417 17.1751 9.57959 17.2051 10.0513C17.235 10.5229 17.25 11.0059 17.25 11.5H15.8125C15.8125 11.0133 15.7975 10.5342 15.7676 10.0625C15.7376 9.59082 15.689 9.11165 15.6216 8.625H7.37842C7.31852 9.10417 7.2736 9.57959 7.24365 10.0513C7.2137 10.5229 7.19499 11.0059 7.1875 11.5C7.1875 11.9867 7.20247 12.4658 7.23242 12.9375C7.26237 13.4092 7.31104 13.8883 7.37842 14.375H14.375V15.8125H7.62549C7.68538 16.1045 7.77148 16.4489 7.88379 16.8457C7.99609 17.2425 8.1346 17.6543 8.29932 18.0811C8.46403 18.5078 8.6512 18.9271 8.86084 19.3389C9.07048 19.7507 9.3138 20.125 9.59082 20.4619C9.86784 20.7988 10.1598 21.0646 10.4668 21.2593C10.7738 21.4539 11.1182 21.555 11.5 21.5625C11.7246 21.5625 11.938 21.5213 12.1401 21.439C12.3423 21.3566 12.5332 21.2443 12.7129 21.1021C12.8926 20.9598 13.0573 20.8063 13.207 20.6416C13.3568 20.4769 13.4953 20.3047 13.6226 20.125H14.375V22.6182C13.9033 22.7454 13.4279 22.839 12.9487 22.8989C12.4696 22.9588 11.9867 22.9925 11.5 23C10.4443 23 9.42611 22.8652 8.44531 22.5957C7.46452 22.3262 6.54736 21.9406 5.69385 21.439C4.84033 20.9373 4.06543 20.3384 3.36914 19.6421C2.67285 18.9458 2.07389 18.1672 1.57227 17.3062C1.07064 16.4452 0.685059 15.5317 0.415527 14.5659C0.145996 13.6001 0.00748698 12.5781 0 11.5C0 10.4443 0.134766 9.42611 0.404297 8.44531C0.673828 7.46452 1.05941 6.54736 1.56104 5.69385C2.06266 4.84033 2.66162 4.06543 3.35791 3.36914C4.0542 2.67285 4.83285 2.07389 5.69385 1.57227C6.55485 1.07064 7.46826 0.685059 8.43408 0.415527C9.3999 0.145996 10.4219 0.00748698 11.5 0ZM8.20947 1.98779C7.57308 2.20492 6.97038 2.48568 6.40137 2.83008C5.83236 3.17448 5.29704 3.56755 4.79541 4.00928C4.29378 4.45101 3.84831 4.93766 3.45898 5.46924C3.06966 6.00081 2.72152 6.57357 2.41455 7.1875H6.1543C6.23665 6.74577 6.33773 6.29655 6.45752 5.83984C6.57731 5.38314 6.72331 4.93018 6.89551 4.48096C7.06771 4.03174 7.26237 3.59749 7.47949 3.17822C7.69661 2.75895 7.93994 2.36214 8.20947 1.98779ZM8.20947 21.0122C7.93994 20.6453 7.69661 20.2523 7.47949 19.833C7.26237 19.4137 7.07145 18.9795 6.90674 18.5303C6.74202 18.0811 6.59603 17.6281 6.46875 17.1714C6.34147 16.7147 6.23665 16.2617 6.1543 15.8125H2.41455C2.70654 16.4189 3.05094 16.988 3.44775 17.5195C3.84456 18.0511 4.29378 18.5415 4.79541 18.9907C5.29704 19.4399 5.82861 19.833 6.39014 20.1699C6.95166 20.5068 7.55811 20.7876 8.20947 21.0122ZM5.92969 14.375C5.86979 13.8958 5.82487 13.4204 5.79492 12.9487C5.76497 12.4771 5.75 11.9941 5.75 11.5C5.75 11.0133 5.76497 10.5342 5.79492 10.0625C5.82487 9.59082 5.86979 9.11165 5.92969 8.625H1.85303C1.57601 9.5459 1.4375 10.5042 1.4375 11.5C1.4375 12.4958 1.57601 13.4541 1.85303 14.375H5.92969ZM15.3745 7.1875C15.3146 6.89551 15.2285 6.55111 15.1162 6.1543C15.0039 5.75749 14.8654 5.3457 14.7007 4.91895C14.536 4.49219 14.3488 4.07292 14.1392 3.66113C13.9295 3.24935 13.6862 2.875 13.4092 2.53809C13.1322 2.20117 12.8402 1.93538 12.5332 1.74072C12.2262 1.54606 11.8818 1.44499 11.5 1.4375C11.1331 1.4375 10.7925 1.53857 10.478 1.74072C10.1636 1.94287 9.86784 2.20866 9.59082 2.53809C9.3138 2.86751 9.07422 3.23812 8.87207 3.6499C8.66992 4.06169 8.479 4.4847 8.29932 4.91895C8.11963 5.35319 7.98112 5.76497 7.88379 6.1543C7.78646 6.54362 7.70036 6.88802 7.62549 7.1875H15.3745ZM20.5854 7.1875C20.2935 6.58105 19.9491 6.01204 19.5522 5.48047C19.1554 4.94889 18.7062 4.4585 18.2046 4.00928C17.703 3.56006 17.1714 3.16699 16.6099 2.83008C16.0483 2.49316 15.4419 2.2124 14.7905 1.98779C15.0601 2.35466 15.3034 2.74772 15.5205 3.16699C15.7376 3.58626 15.9285 4.02051 16.0933 4.46973C16.258 4.91895 16.404 5.37191 16.5312 5.82861C16.6585 6.28532 16.7633 6.73828 16.8457 7.1875H20.5854ZM17.25 17.25H21.5625V18.6875H17.25V23H15.8125V18.6875H11.5V17.25H15.8125V12.9375H17.25V17.25Z"
														fill="white"></path>
												</svg>
											</div>
											<span style="font-size:12px; color:white">
												Instant Payment to<br>Sellers with Trbo Swift </span>
											</span>

										</div>
									</div>



								</div>
							</div>

							<div class="bg-light p-3 mb-2" style="border-radius:22px;">
								<div class="mb-3">
									<div class="row mb-1">
										<div class="col financing-entry-title h5">No Pending Applications</div>
										<div class="col text-right">Application #<span class="financing-entry-id"></span><i
												class="far fa-copy ml-1"></i></div>
									</div>
									<span class="text-primary small">Trbo Swift partners with top lenders to get you the best rates
										and
										terms.
										Enjoy a seamless online financing process and add options for warranties, transportation,
										and
										escrow
										services.</span>
								</div>



								<div class="financing-process mb-3">

									<div class="container mb-4">
										<div class="progress-container">
											<div class="progress" id="financing-progress-bar"></div>

											<div class="step-wrap" data-step="1">
												<div class="circle"><span class="step-title">1</span></div>
												<p class="text">Application Status</p>
											</div>
											<div class="step-wrap" data-step="2">
												<div class="circle"><span class="step-title">2</span></div>
												<p class="text">Decision</p>
											</div>
											<div class="step-wrap" data-step="3">
												<div class="circle"><span class="step-title">3</span></div>
												<p class="text">KYC verification</p>
											</div>
											<div class="step-wrap" data-step="4">
												<div class="circle"><span class="step-title">4</span></div>
												<p class="text">Paper Work</p>
											</div>
											<div class="step-wrap" data-step="5">
												<div class="circle"><span class="step-title">5</span></div>
												<p class="text">Vehicle Delivery</p>
											</div>
											<div class="step-wrap" data-step="6">
												<div class="circle"><span class="step-title">6</span></div>
												<p class="text">Seller Payment</p>
											</div>
										</div>
										<div>

											<input type="hidden" id="finance_entry_id" value="">
											<input type="hidden" id="finance_pickup_id" value="">
											<input type="hidden" id="finance_entry_vehicle_name" value="">
											<input type="hidden" id="finance_entry_vehicle_vin" value="">
											<input type="hidden" id="financeBuyerEmailAddress" value="">
											<input type="hidden" id="financeSellerEmailAddress" value="">


										</div>

									</div>



									<div id="step-details" class="mb-3">

										<div class="financing-process-step-details" data-step="0">
											<div class="container m-0 p-2 bg-white" style="border-radius:22px;">

												<div class="row mx-0 gap-2 my-3 align-items-center">
													<h5>Apply for financing</h5>

												</div>
												<p class="text-primary">We have exclusive partnerships with some of Canada’s largest
													lenders
													to get your best-in-market rates.</p>


												<div class="row m-0 my-2">
													<button class="btn btn-outline-secondary rounded-pill px-4 mr-3">Learn
														more</button>
													<a href="<?php echo home_url(); ?>/credit-application"
														class="btn btn-secondary rounded-pill px-4" target="blank">Apply for
														financing</a>
												</div>


											</div>


											<div class="financing-item-details bg-light p-3 mt-2" style="border-radius:22px;">
												<div class="h6 pb-5 mb-5"><i class="far fa-file"></i> Item details</div>

												<div class="p-5 d-flex align-items-center justify-content-center">
													<span>No items are here !</span>


												</div>

											</div>


										</div>



									</div>


								</div><!-- Process Close -->


							</div>
						</div>

				<?php } ?>

			</div>

			<div class="financeRightSidePanelFaq d-block col-12 col-md-3 p-0 p-md-2">
				<div class="bg-white p-3 mb-2" style="border-radius:22px; border:0.5px solid #eee">
					<h5>History</h5>
					<p class="financing-entry-submit-date my-3">July 7, 2024, 6:12PM EDT</p><br>
					<span>Seller initiates the transaction</span>
				</div>

				<div class="bg-white p-2 mb-2" style="border-radius:22px; border:0.5px solid #eee">
					<h5><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/wpf_ask-question.svg"
							style="width:25px; margin-right:10px;" />Trbo Swift FAQ Questions</h5>

					<?php echo do_shortcode('[elementor-template id="325472"]'); ?>

				</div>

				<div class="bg-white p-2 mb-2" style="border-radius:22px; border:0.5px solid #eee">
					<h5><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/wpf_ask-question.svg"
							style="width:25px; margin-right:10px;" />Trbo Swift AI Inspection</h5>

					<?php echo do_shortcode('[elementor-template id="325466"]'); ?>



				</div>

			</div>
			<div class="financeRightSidePanelDeliveryStatus d-none col-12 col-md-3 p-0 p-md-2">
				<div class="bg-white radiusx">

					<div class="px-2 mt-2 mt-md-0">
						<div class="bg-white radiusx p-2 overflow-md-auto">
							<div class="col-12 d-flex align-items-center border-bottom pb-2 px-0">
								<div class="col-6 p-0">
									<strong>Status</strong>
								</div>
								<div class="col-6 text-right d-flex justify-content-end p-0">

								</div>
							</div>


							<div class="statusWrapper">
								<div class="d-flex justify-content-between text-dark font-12 py-3 ">
									<span>Accepted</span>
									<span>Pickup</span>
									<span>On Route</span>
									<span>Delivery</span>
								</div>

								<div class="transport-progress-container">
									<div class="progress-bar">
										<div class="js-completed-bar completed-bar" data-complete="0">
											<hr class="completed-bar__dashed">
											<i class="fas fa-truck-moving completed-bar__truck"></i>
										</div>
									</div>
									<div class="progress-information">
										<p class="text-colour--faded-60"></p>
										<p class="text-colour--primary-red--80"></p>
									</div>
								</div>


								<div class="deliveryStatusReport mb-3 wrapper"></div>

								<div class="mt-2">
									<h5>Insurance</h5>
									<strong class="font-italic">You can view and manage your vehicle insurance through
										Turbobid or our trusted partners, who are fully responsible for the coverage.
										Additional insurance options are available for different vehicle classes as
										required.</strong><br>
									<strong class="font-italic">Review your coverage now for peace of mind!</strong>
								</div>
							</div>
						</div>
					</div>

				</div>

				<?php if ($isBuyerFinance || $isSellerFinance) { ?>

					<script>
						jQuery("#selectPayoutMethod input").on('click', function () {
							var value = jQuery(this).val();


							if (value === "Wire Transfer") {
								wireTransfer();
							} else {
								hyperwalletPayment();
							}

						});


						function wireTransfer() {

							jQuery('.documentManagementBody #documentManageTitle').hide();
							jQuery('.documentManagementBody .documentManagementContainer').removeClass('p-3 customModalWidthHalf').addClass(
								'p-0 border-0 customModalWidthFull')

							jQuery('.documentManagementBody .sendDocumentSection').removeClass('d-block').addClass('d-none');
							jQuery('.documentManagementBody .documentViewSection').removeClass('d-none').addClass('d-block');

							var approvalFields = `
	<div class="bg-secondary px-1 px-md-4 py-4 text-center text-white"><h5>Disbursement By Wire/Bank Transfer</h5></div>

	<div class="px-1 px-md-3 py-3 bg-white">
	<div class="text-center px-5 mx-3 font-14">
	<p>Please enter your information below. Funds will be transferred instantly upon confirmation of vehicle pickup or delivery.</p>
	</div>
	<div class="wire-transfer-form">
						<div class="form-row">
							<div class="form-group col-md-3">
								<label for="wireTransferAddress" class="info-label">Address</label>
								<input type="text" id="wireTransferAddress" class="form-control rounded-pill googleAutoLocation"
									value="">
							</div>

							<div class="form-group col-md-3">
								<label for="wireTransferCity" class="info-label">City</label>
								<input type="text" id="wireTransferCity" class="form-control rounded-pill" value="">
							</div>

							<div class="form-group col-md-3">
											<label for="wireTransferProvince" class="field-label">Province</label>
											<select type="text" id="wireTransferProvince"
												class="form-control rounded-pill rounded-pill wireTransferProvince">

												<option>Alberta</option>
												<option>British Columbia</option>
												<option>Manitoba</option>
												<option>New Brunswick</option>
												<option>Newfoundland and Labrador</option>
												<option>Northwest Territories</option>
												<option>Nova Scotia</option>
												<option>Nunavut</option>
												<option>Ontario</option>
												<option>Prince Edward Island</option>
												<option>Quebec</option>
												<option>Saskatchewan</option>
												<option>Yukon</option>

											</select>
										</div>


							<div class="form-group col-md-3">
								<label for="wireTransferCityPostalCode" class="info-label">Postal Code</label>
								<input type="text" id="wireTransferCityPostalCode" class="form-control rounded-pill" value="">
							</div>

						   

						</div>

					   

						<div class="form-row">
							<div class="form-group col-12 col-md-3">
								<label for="institutionName" class="info-label">Institution Name</label>
								<input type="text" id="institutionName" class="form-control rounded-pill" value="">
							</div>
							<div class="form-group col-12 col-md-3">
								<label for="institutionAddress" class="info-label">Institution Address</label>
								<input type="text" id="institutionAddress" class="form-control rounded-pill" value="">
							</div>
							<div class="form-group col-12 col-md-3">
								<label for="institutionNumber" class="info-label">Institution Number (Max. 3)</label>
								<input type="text" id="institutionNumber" class="form-control rounded-pill" value="">
							</div>
							 <div class="form-group col-12 col-md-3">
								<label for="transitNumber" class="info-label">Transit number</label>
								<input type="text" id="transitNumber" class="form-control rounded-pill" value="">
							</div>

							
						</div>

						<div class="form-row">
						<div class="form-group col-12 col-md-3">
								<label for="accountName" class="info-label">Account Name</label>
								<input type="text" id="accountName" class="form-control rounded-pill" value="">
							</div>
						<div class="form-group col-12 col-md-3">
								<label for="accountNumber" class="info-label">Account Number</label>
								<input type="text" id="accountNumber" class="form-control rounded-pill" value="">
							</div>



							 <div class="form-group col-12 col-md-3 d-flex justify-content-start align-items-end">
								<button  type="submit" id="submitWireTransferDocument" class="submitPayoutMethodDocument btn btn-secondary rounded-pill px-5 py-2">Submit</button>
							</div>

						</div>

		</div>
		</div>
	
	`;

							jQuery(".documentManagementBody .documentViewSection").html(approvalFields);
							jQuery('.documentManagementBody').removeClass('d-none').addClass('d-flex');
						}

						function hyperwalletPayment() {

							jQuery('.documentManagementBody #documentManageTitle').hide();
							jQuery('.documentManagementBody .documentManagementContainer').removeClass('p-3 customModalWidthFull').addClass(
								'p-0 border-0 customModalWidthHalf');

							jQuery('.documentManagementBody .sendDocumentSection').removeClass('d-block').addClass('d-none');
							jQuery('.documentManagementBody .documentViewSection').removeClass('d-none').addClass('d-block');

							var approvalFields = `
	<div class="bg-secondary px-1 px-md-4 py-4 text-center text-white"><h5>Disbursement By HyperWallet</h5></div>

	<div class="px-1 px-md-3 py-3 bg-white">
	<div class="text-center px-5 mx-3 font-14">
	<p>Please enter your information below. Funds will be transferred instantly upon confirmation of vehicle pickup or delivery. Instructions and payment details will be sent to the following email.</p>
	</div>
	<div class="fund-deal-form">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="hyperWalletFirstName" class="info-label">First name</label>
								<input type="text" id="hyperWalletFirstName" class="form-control rounded-pill"
									value="">
							</div>

							 <div class="form-group col-md-6">
								<label for="hyperWalletLastName" class="info-label">Last name</label>
								<input type="text" id="hyperWalletLastName" class="form-control rounded-pill"
									value="">
							</div>

							<div class="form-group col-md-6">
								<label for="hyperWalletPhoneNumber" class="info-label">Phone number</label>
								<input type="tel" id="hyperWalletPhoneNumber" class="form-control rounded-pill"
									value="">
							</div>

							  <div class="form-group col-md-6">
								<label for="hyperWalletEmail" class="info-label">Email</label>
								<input type="tel" id="hyperWalletEmail" class="form-control rounded-pill"
									value="">
							</div>
						</div>


						<div class="form-row">
							 <div class="form-group col-12 col-md-12 d-flex justify-content-center align-items-center">
								<button  type="submit" id="submitHyperWalletDocument" class="submitPayoutMethodDocument btn btn-secondary rounded-pill px-3">Submit</button>
							</div>

						</div>


						   
		</div>
		</div>
	
	`;

							jQuery(".documentManagementBody .documentViewSection").html(approvalFields);
							jQuery('.documentManagementBody').removeClass('d-none').addClass('d-flex');
						}





						jQuery(document).ready(function ($) {
							$('.packages-card').click(function () {
								// Toggle 'selected' class for clicked card
								$(this).toggleClass('selected');

								// Get the card title and price
								let cardTitle = $(this).find('.card-title').text();
								let cardPrice = $(this).find('.price span').text();

								// Check if the card is selected
								if ($(this).hasClass('selected')) {
									var monthlyPay = jQuery('.approvalAmountCard').text();
									var monthlyPayTerm = jQuery('.approvalMonthTermCard').text();

									if (cardTitle === "Trbo Swift Transport") {
										var transPortCost = extractNumericValue(cardPrice) / extractNumericValue(
											monthlyPayTerm);
										var TotalMonthlyPay = extractNumericValue(monthlyPay) + transPortCost;
										jQuery('.approvalAmountCard').text(formatCalCadPrice(TotalMonthlyPay))
									} else {
										var TotalMonthlyPay = extractNumericValue(monthlyPay) + extractNumericValue(cardPrice);
										jQuery('.approvalAmountCard').text(formatCalCadPrice(TotalMonthlyPay))
									}

									// If selected, log the card details
									console.log(`Selected: ${cardTitle} - ${cardPrice}`);
								} else {
									var monthlyPay = jQuery('.approvalAmountCard').text();
									var monthlyPayTerm = jQuery('.approvalMonthTermCard').text();

									if (cardTitle === "Trbo Swift Transport") {
										var transPortCost = extractNumericValue(cardPrice) / extractNumericValue(
											monthlyPayTerm);
										var TotalMonthlyPay = extractNumericValue(monthlyPay) - transPortCost;
										jQuery('.approvalAmountCard').text(formatCalCadPrice(TotalMonthlyPay))
									} else {
										var TotalMonthlyPay = extractNumericValue(monthlyPay) - extractNumericValue(cardPrice);
										jQuery('.approvalAmountCard').text(formatCalCadPrice(TotalMonthlyPay))
									}
									// If deselected, log that it was deselected
									console.log(`Deselected: ${cardTitle}`);
								}
							});
						});

						function extractNumericValue(value) {
							if (!value) return 0;

							// Use regex to find numbers (including decimals) and percentages in the text
							let numericValue = value.match(/[\d.,]+/);

							if (numericValue) {
								// Remove commas (if any) and parse the numeric string as a float
								return parseFloat(numericValue[0].replace(/,/g, ''));
							}

							return 0; // Return 0 if no valid numeric value is found
						}


						jQuery(document).ready(function ($) {
							<?php if ($isBuyerFinance) { ?>
								var financingTotalSteps = 6;
							<?php } else if ($isSellerFinance) { ?>
									var financingTotalSteps = 5;
							<?php } else { ?>
									var financingTotalSteps = 0;
							<?php } ?>


							var financingCurrentStep;

							function updateFinancingSteps(step) {
								console.log('step: ', step);
								financingCurrentStep = step;
								var $financingSteps = $('.financing-process .step-wrap');
								var $financingStepDetails = $('.financing-process-step-details');
								var $progressFinancingBar = $('#financing-progress-bar');


								$financingSteps.removeClass('active').each(function (index) {
									if (index + 1 <= financingCurrentStep) {
										$(this).addClass('active');
									}
								});

								$financingStepDetails.hide().filter('[data-step="' + financingCurrentStep + '"]').show();

								var progressWidth = (financingCurrentStep - 1) / (financingTotalSteps - 1) * 96;
								$progressFinancingBar.css('width', progressWidth + '%');

								$('#financing-step-back').prop('disabled', financingCurrentStep === 1);
								$('#next').text(financingCurrentStep === financingTotalSteps ? 'Complete' : 'Next');

								/* if(financingCurrentStep === 5 || financingCurrentStep === 7){
								$('.financing-process-step-details').addClass('d-none');
								}else{
								$('.financing-process-step-details').removeClass('d-none');
								} */
							}


							jQuery(document).on('click', '.financing-step-next', function () {
								console.log('financing: ', financingCurrentStep);

								if (financingCurrentStep < financingTotalSteps) {
									financingCurrentStep++;
								} else {
									// Submit the form or perform final action here
								}
								updateUserFinanceEntryCurrentStep();
							});

							// Use event delegation
							jQuery(document).on('click', '.financing-buyer-next', function () {
								console.log('financing: ', financingCurrentStep);

								if (financingCurrentStep < financingTotalSteps) {
									financingCurrentStep++;
								}
								updateUserFinanceEntryCurrentStep();
							});

							jQuery('#financing-step-back').click(function () {
								if (financingCurrentStep > 1) {
									financingCurrentStep--;
								}
								updateUserFinanceEntryCurrentStep();
							});


							function handleGetTransport(case_id, callback) {
								const apiUrl = `<?php echo home_url(); ?>/rancoded-json/api/v1/caseid-transport?transport_case_id=118`;

								jQuery.getJSON(apiUrl)
									.done(function (res) {
										console.log(res);
										if (res && res.meta) {
											callback(res);
										} else {
											callback(null);
										}
									})
									.fail(function (jqXHR) {
										if (jqXHR.status === 404) {
											console.warn("🚨 Case not found (404). Loading default map...");
										} else {
											console.error("❌ API request failed:", jqXHR);
										}
										callback(null); // ❌ Return default if API call fails
									});
							}


							function dealerApprovalTermForClient(step, dealerStatus, meta) {
								// Ensure 'step' is treated as a number
								const numericStep = parseInt(step, 10);
								const escrowId = $('#finance_entry_id').val();

								console.log('dealer step:', numericStep);

								function getValue(value) {
									return (value && value !== "undefined" && value !== "undefined undefined") ? value : "";
								}

								<?php if ($isBuyerFinance) { ?>
									console.log('Buyer : ', dealerStatus);
									if (dealerStatus.step_name == "Delivery" || numericStep == 5 || dealerStatus.step == 5) {
										if (financingCurrentStep < financingTotalSteps) {
											financingCurrentStep = 5;
										}




										let trboSwiftTransportStart = '';


										trboSwiftTransportStart += `
			
			<div class="col-12 row mx-0 p-0 ">
			<div class="col-md-8 p-0">
			<div class="turbobidfinancing financing-bg-green mb-2 align-items-stretch">
					<img style="position: relative; padding: 20px; background: white; border-radius: 20px;"
						loading="lazy" alt="turbobid financing icon"
						src="<?php echo home_url(); ?>/wp-content/uploads/2024/07/Vector-2.svg" />

					<section class="turbobidfinancing-inner col-6 col-md-4">
						<div style="gap:8px">
							<div class="turbobid-financing-services-wrapper">
								<h3 class="turbobid-financing-services">Financing</h3>
							</div>
							<div class="lien-service">
								<div class="the-lien-payoff">
									Any Vehicle, Any Marketplace

								</div>
								<a href="<?php echo home_url() ?>/finance" class="btn btn-primary rounded-pill px-3" style="font-size:10px">Explore Finance</a>
							</div>

						</div>
					</section>
					<div class="col-12 col-md d-flex justify-content-between align-items-stretch">
						<div class="col-4">
							<div
								style="height:100%; width:100%; background:#44795B; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
								<div
									style="width:50px; height:50px; background:#3B634C; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
									<svg xmlns="http://www.w3.org/2000/svg" width="23" height="26" viewBox="0 0 23 26"
										fill="none">
										<path d="M7.39062 11.3485L9.9779 13.9352L15.1518 8.76123" stroke="white"
											stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
										<path
											d="M11.2715 24.2837L12.4096 23.7919C14.7959 22.7679 16.8565 21.1105 18.3683 18.9992C19.8801 16.8878 20.7853 14.4031 20.986 11.8142L21.5424 4.67385C21.5514 4.37815 21.4587 4.08829 21.2797 3.85276C21.1007 3.61723 20.8462 3.45031 20.5589 3.3799L11.2715 1L1.98409 3.32837C1.69685 3.39875 1.44248 3.56559 1.26347 3.80099C1.08446 4.03639 0.991664 4.3261 1.00059 4.6217L1.55691 11.762C1.75752 14.3511 2.66274 16.8359 4.17451 18.9474C5.68628 21.0588 7.74698 22.7163 10.1334 23.7404L11.2715 24.2837Z"
											stroke="white" stroke-width="1.5" stroke-linecap="round"
											stroke-linejoin="round">
										</path>
									</svg>
								</div>
								<span style="font-size:12px; color:white">Secure &amp; Fast<br>Approvals </span>

							</div>
						</div>
						<div class="col-4">
							<div
								style="height:100%; width:100%; background:#44795B; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
								<div
									style="width:50px; height:50px; background:#3B634C; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
										fill="none">
										<path
											d="M12.004 24C10.3453 24 8.78533 23.6853 7.324 23.056C5.86356 22.4258 4.59289 21.5707 3.512 20.4907C2.43111 19.4107 1.57556 18.1413 0.945333 16.6827C0.315111 15.224 0 13.6644 0 12.004C0 10.3436 0.315111 8.78356 0.945333 7.324C1.57556 5.86356 2.43067 4.59289 3.51067 3.512C4.59067 2.43111 5.86044 1.57556 7.32 0.945333C8.77956 0.315111 10.3396 0 12 0H12.6667V10.8533C12.896 10.9956 13.0644 11.1609 13.172 11.3493C13.2796 11.5378 13.3333 11.7556 13.3333 12.0027C13.3333 12.3582 13.2004 12.6689 12.9347 12.9347C12.6689 13.2004 12.3573 13.3333 12 13.3333C11.6427 13.3333 11.3311 13.2004 11.0653 12.9347C10.7996 12.6689 10.6667 12.3591 10.6667 12.0053C10.6667 11.76 10.7204 11.5409 10.828 11.348C10.9356 11.1551 11.104 10.9907 11.3333 10.8547V6.73067C10.0071 6.888 8.89778 7.46445 8.00533 8.46C7.11289 9.45556 6.66667 10.6356 6.66667 12C6.66667 13.4667 7.18889 14.7222 8.23333 15.7667C9.27778 16.8111 10.5333 17.3333 12 17.3333C13.4667 17.3333 14.7222 16.8111 15.7667 15.7667C16.8111 14.7222 17.3333 13.4667 17.3333 12C17.3333 11.2 17.172 10.4613 16.8493 9.784C16.5267 9.10667 16.088 8.512 15.5333 8L16.4853 7.04933C17.16 7.66267 17.692 8.39378 18.0813 9.24267C18.4707 10.0916 18.6658 11.0107 18.6667 12C18.6667 13.8516 18.0191 15.4258 16.724 16.7227C15.4289 18.0196 13.8564 18.6676 12.0067 18.6667C10.1569 18.6658 8.58133 18.0178 7.28 16.7227C5.98222 15.4258 5.33333 13.8516 5.33333 12C5.33333 10.2569 5.91111 8.75733 7.06667 7.50133C8.22222 6.24533 9.64444 5.53867 11.3333 5.38133V1.34933C8.53511 1.512 6.16889 2.61467 4.23467 4.65733C2.30044 6.7 1.33333 9.14756 1.33333 12C1.33333 14.9778 2.36667 17.5 4.43333 19.5667C6.5 21.6333 9.02222 22.6667 12 22.6667C14.9778 22.6667 17.5 21.6333 19.5667 19.5667C21.6333 17.5 22.6667 14.9778 22.6667 12C22.6667 10.4667 22.3667 9.03333 21.7667 7.7C21.1667 6.36667 20.3444 5.21111 19.3 4.23333L20.2507 3.28267C21.4151 4.38489 22.3311 5.68178 22.9987 7.17333C23.6662 8.66489 24 10.2711 24 11.992C24 13.6542 23.6853 15.2156 23.056 16.676C22.4258 18.1364 21.5707 19.4071 20.4907 20.488C19.4107 21.5689 18.1413 22.4244 16.6827 23.0547C15.224 23.6849 13.6644 24 12.004 24Z"
											fill="white"></path>
									</svg>
								</div>
								<span style="font-size:12px; color:white">
									Add Warranty,Insurance<br>&amp; Transport Options </span>

							</div>
						</div>
						<div class="col-4">
							<div
								style="height:100%; width:100%; background:#44795B; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
								<div
									style="width:50px; height:50px; background:#3B634C; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
									<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23"
										fill="none">
										<path
											d="M11.5 0C12.5557 0 13.5739 0.134766 14.5547 0.404297C15.5355 0.673828 16.4526 1.05941 17.3062 1.56104C18.1597 2.06266 18.9346 2.66162 19.6309 3.35791C20.3271 4.0542 20.9261 4.83285 21.4277 5.69385C21.9294 6.55485 22.3149 7.47201 22.5845 8.44531C22.854 9.41862 22.9925 10.4368 23 11.5C23 12.2412 22.9289 12.9712 22.7866 13.6899C22.6444 14.4087 22.4347 15.1162 22.1577 15.8125H18.6875V14.375H21.1357C21.4202 13.4316 21.5625 12.4733 21.5625 11.5C21.5625 10.5042 21.424 9.5459 21.147 8.625H17.0703C17.1302 9.10417 17.1751 9.57959 17.2051 10.0513C17.235 10.5229 17.25 11.0059 17.25 11.5H15.8125C15.8125 11.0133 15.7975 10.5342 15.7676 10.0625C15.7376 9.59082 15.689 9.11165 15.6216 8.625H7.37842C7.31852 9.10417 7.2736 9.57959 7.24365 10.0513C7.2137 10.5229 7.19499 11.0059 7.1875 11.5C7.1875 11.9867 7.20247 12.4658 7.23242 12.9375C7.26237 13.4092 7.31104 13.8883 7.37842 14.375H14.375V15.8125H7.62549C7.68538 16.1045 7.77148 16.4489 7.88379 16.8457C7.99609 17.2425 8.1346 17.6543 8.29932 18.0811C8.46403 18.5078 8.6512 18.9271 8.86084 19.3389C9.07048 19.7507 9.3138 20.125 9.59082 20.4619C9.86784 20.7988 10.1598 21.0646 10.4668 21.2593C10.7738 21.4539 11.1182 21.555 11.5 21.5625C11.7246 21.5625 11.938 21.5213 12.1401 21.439C12.3423 21.3566 12.5332 21.2443 12.7129 21.1021C12.8926 20.9598 13.0573 20.8063 13.207 20.6416C13.3568 20.4769 13.4953 20.3047 13.6226 20.125H14.375V22.6182C13.9033 22.7454 13.4279 22.839 12.9487 22.8989C12.4696 22.9588 11.9867 22.9925 11.5 23C10.4443 23 9.42611 22.8652 8.44531 22.5957C7.46452 22.3262 6.54736 21.9406 5.69385 21.439C4.84033 20.9373 4.06543 20.3384 3.36914 19.6421C2.67285 18.9458 2.07389 18.1672 1.57227 17.3062C1.07064 16.4452 0.685059 15.5317 0.415527 14.5659C0.145996 13.6001 0.00748698 12.5781 0 11.5C0 10.4443 0.134766 9.42611 0.404297 8.44531C0.673828 7.46452 1.05941 6.54736 1.56104 5.69385C2.06266 4.84033 2.66162 4.06543 3.35791 3.36914C4.0542 2.67285 4.83285 2.07389 5.69385 1.57227C6.55485 1.07064 7.46826 0.685059 8.43408 0.415527C9.3999 0.145996 10.4219 0.00748698 11.5 0ZM8.20947 1.98779C7.57308 2.20492 6.97038 2.48568 6.40137 2.83008C5.83236 3.17448 5.29704 3.56755 4.79541 4.00928C4.29378 4.45101 3.84831 4.93766 3.45898 5.46924C3.06966 6.00081 2.72152 6.57357 2.41455 7.1875H6.1543C6.23665 6.74577 6.33773 6.29655 6.45752 5.83984C6.57731 5.38314 6.72331 4.93018 6.89551 4.48096C7.06771 4.03174 7.26237 3.59749 7.47949 3.17822C7.69661 2.75895 7.93994 2.36214 8.20947 1.98779ZM8.20947 21.0122C7.93994 20.6453 7.69661 20.2523 7.47949 19.833C7.26237 19.4137 7.07145 18.9795 6.90674 18.5303C6.74202 18.0811 6.59603 17.6281 6.46875 17.1714C6.34147 16.7147 6.23665 16.2617 6.1543 15.8125H2.41455C2.70654 16.4189 3.05094 16.988 3.44775 17.5195C3.84456 18.0511 4.29378 18.5415 4.79541 18.9907C5.29704 19.4399 5.82861 19.833 6.39014 20.1699C6.95166 20.5068 7.55811 20.7876 8.20947 21.0122ZM5.92969 14.375C5.86979 13.8958 5.82487 13.4204 5.79492 12.9487C5.76497 12.4771 5.75 11.9941 5.75 11.5C5.75 11.0133 5.76497 10.5342 5.79492 10.0625C5.82487 9.59082 5.86979 9.11165 5.92969 8.625H1.85303C1.57601 9.5459 1.4375 10.5042 1.4375 11.5C1.4375 12.4958 1.57601 13.4541 1.85303 14.375H5.92969ZM15.3745 7.1875C15.3146 6.89551 15.2285 6.55111 15.1162 6.1543C15.0039 5.75749 14.8654 5.3457 14.7007 4.91895C14.536 4.49219 14.3488 4.07292 14.1392 3.66113C13.9295 3.24935 13.6862 2.875 13.4092 2.53809C13.1322 2.20117 12.8402 1.93538 12.5332 1.74072C12.2262 1.54606 11.8818 1.44499 11.5 1.4375C11.1331 1.4375 10.7925 1.53857 10.478 1.74072C10.1636 1.94287 9.86784 2.20866 9.59082 2.53809C9.3138 2.86751 9.07422 3.23812 8.87207 3.6499C8.66992 4.06169 8.479 4.4847 8.29932 4.91895C8.11963 5.35319 7.98112 5.76497 7.88379 6.1543C7.78646 6.54362 7.70036 6.88802 7.62549 7.1875H15.3745ZM20.5854 7.1875C20.2935 6.58105 19.9491 6.01204 19.5522 5.48047C19.1554 4.94889 18.7062 4.4585 18.2046 4.00928C17.703 3.56006 17.1714 3.16699 16.6099 2.83008C16.0483 2.49316 15.4419 2.2124 14.7905 1.98779C15.0601 2.35466 15.3034 2.74772 15.5205 3.16699C15.7376 3.58626 15.9285 4.02051 16.0933 4.46973C16.258 4.91895 16.404 5.37191 16.5312 5.82861C16.6585 6.28532 16.7633 6.73828 16.8457 7.1875H20.5854ZM17.25 17.25H21.5625V18.6875H17.25V23H15.8125V18.6875H11.5V17.25H15.8125V12.9375H17.25V17.25Z"
											fill="white"></path>
									</svg>
								</div>
								<span style="font-size:12px; color:white">
									Instant Payment to<br>Sellers with Trbo Swift </span>
								</span>

							</div>
						</div>

					</div>
				</div>
				
				
				<div class="modal-body text-left">
				
				
				<h5>Please make your Selection</h5>
				<span class="small">The seller has chosen a pickup time slot. Once you select yours, Trbo Swift will arrange the transportation.</span>
				
				<div class="col-12 row mx-0 px-0">
				<div class="col-md-5 pl-md-0">
				<div class="calenderLeftInfo">
								<div class="row mx-0 mb-2 mr-md-2">
								<div class="text-muted mr-3">Buyer</div>
								<div class="font-weight-bold text-dark">${getValue(meta['name-1'])} ${getValue(meta['name-2'])}</div>
								</div>
								<div class="row mx-0 mb-2 mr-md-2">
								<div class="text-muted mr-3">Seller</div>
								<div class="font-weight-bold text-dark">${getValue(meta['name-4'])}</div>
								</div>
								<div class="row mx-0 mb-2 mr-md-2">
								<div class="text-muted mr-3">VIN</div>
								<div class="font-weight-bold text-dark">${getValue(meta['text-13'])}</div>
								</div>
								
								<hr>
								<div class="mt-2">
								<h5>Vehicle Pickup</h5>
								<small class="text-primary">Powered by Trbo Swift</small>
								
								<div class="row mx-0 mb-2 mr-md-2">
								<div class="text-muted mr-3"><img src="<?php echo home_Url(); ?>/wp-content/uploads/2025/02/clock.svg" style="width:25px" /> </div>
								<div class="font-weight-bold text-secondary small">1 Hour Pickup window</div>
								</div>
								
								<div class="mt-3 strong">After confirming your preferred pickup dates and times, Trbo Swift will assign a delivery partner to manage your request. You can track the process in real time using the provided link, and the buyer will finalize their choice by selecting a time slot from the options you’ve offered.</div>
								
								</div>
								</div>
				</div>
				<div class="col-md-7">
				<div class="calendar-container">
					<h5>Select Date & Time</h5>
					 <div class="calendar"></div>

					<div class="timezone-container">
						<label for="timezone">Time Zone</label>
						<select id="timezone">
							<option value="America/Toronto" selected>Eastern Time - US & Canada</option>
							<option value="America/New_York">New York (EST)</option>
							<option value="America/Chicago">Chicago (CST)</option>
							<option value="America/Denver">Denver (MST)</option>
							<option value="America/Los_Angeles">Los Angeles (PST)</option>
							<option value="Europe/London">London (GMT)</option>
							<option value="Asia/Dubai">Dubai (GST)</option>
							<option value="Asia/Kolkata">India (IST)</option>
						</select>
					</div>

					<div class="selected-date"></div>
				</div>

				
				
				</div>
				
				</div>
				
				</div>
				
			
			</div>
			<div class="col-md-4 text-left">
			<h6>Seller Suggested</h6>
			
			<div class="container my-3 p-0">
			<div class="selectedDateForPickup"></div>
			<span class="time d-none"></span>

				<div class="timeSlotList"></div>
			</div>

			<input type="hidden" id="vehiclePickupDate" />


			<button  class="submitSellerSuggestedTime btn btn-secondary px-4 rounded-pill">Finish</button>


			</div>
			
			</div>
			
			`;

										jQuery(document).ready(function ($) {

											// Function to format date
											function formatDate(date) {
												let options = { weekday: 'long', month: 'long', day: 'numeric' };
												return date.toLocaleDateString('en-US', options);
											}

											// Function to get future dates
											function getFutureDates(startDate, numDays = 4) {
												let dates = [];
												for (let i = 0; i < numDays; i++) {
													let futureDate = new Date(startDate);
													futureDate.setDate(startDate.getDate() + i);
													dates.push(futureDate);
												}
												return dates;
											}

											// Function to update the UI
											function updateDateTimeUI(selectedDate) {
												let now = new Date();
												let currentTime = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });

												// $(".selectedDate").text(formatDate(selectedDate));
												$(".time").text(currentTime);

												let futureDates = getFutureDates(selectedDate);
												let timeSlots = ["7:00 - 10:00 AM", "10:30 AM - 1:30 PM", "2:00 - 5:00 PM", "6:00 - 9:00 PM"];

												let sellerSuggestedTimes = stringArrayToArray(meta["sellerSuggestedTimes"]); // Convert stored data

												if (!sellerSuggestedTimes.length) {
													$('.selectedDateForPickup').text('The seller has not yet selected a date and time for pickup.');
												}

												let timeSlotHtml = "";
												futureDates.forEach((date, index) => {
													let formattedDate = date.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });

													// Find if this date and time exist in sellerSuggestedTimes
													let isChecked = sellerSuggestedTimes.some(suggested =>
														suggested.date === formattedDate && suggested.time === timeSlots[index]
													);

													timeSlotHtml += `
					<div class="mb-3">
						<span style="color: #BF9B3E">${formatDate(date)}</span>
						<div class="timeSlot my-2 position-relative" 
							style="background:rgb(249, 243, 228); border: 0.5px dashed rgb(169, 162, 144); border-radius:6px; height:56px;">
							
							<span class="text-primary slotTime py-3" 
								style="position:absolute; right:50%; top:50%; transform: translate(50%,-50%);">
								${timeSlots[index]}
							</span>
						</div>
					</div>
				`;
												});

												$(".timeSlotList").html(timeSlotHtml);
											}


											// Initialize with today's date
											let today = new Date();
											updateDateTimeUI(today);

											// Initialize PIGNOSE Calendar
											$(".calendar").pignoseCalendar({
												lang: "en",
												theme: "light",
												format: "YYYY-MM-DD",
												initialize: true,
												multiple: false,
												select: function (date, obj) {
													if (date[0] !== null) {
														let selectedDate = new Date(date[0].format("YYYY-MM-DD"));
														$("#vehiclePickupDate").val(date[0].format("YYYY-MM-DD"));
														updateDateTimeUI(selectedDate);
													}
												}
											});

											// Ensure user selects up to 3 time slots
											$(document).on("change", ".timeSlotCheckbox", function () {
												if ($(".timeSlotCheckbox:checked").length > 3) {
													$(this).prop("checked", false);
													alert("You can select a maximum of 3 time slots.");
												}
											});
										});


										jQuery('.newUserAddModalContainer').addClass('bg-white').css({ "max-width": "95%", "max-height": "95vh" }).html(trboSwiftTransportStart);

										if ($("#financing").css("display") !== "none") {
											jQuery('.newUserAddModalBody').removeClass('d-none').addClass('d-flex');
										}



										handleGetTransport(escrowId, function (res) {
											if (res) {
												let transportDetailsInMap = `
							<div class="d-flex align-items-center justify-content-between bg-white p-2 mb-2" style="border-radius: 0 0 15px 15px; box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
								 <div class="d-flex align-items-center justify-content-between col-12" style="gap:15px;">

										<div class="col d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
										<div class="d-flex align-items-center mr-2">
										<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/dfghjkl.svg" style="width:30px" />
										 <div class="ml-2">
										<div class="font-weight-bold font-12  text-dark opasity-">${res.meta.transportPickup || ''}</div>
										<div class="font-10 text-muted">Driver contact</div>
										</div>
										</div>
										</div>

										 <div class="col d-flex align-items-center justify-content-end radiusx bg-white p-2 mb-2">
										<div class="d-flex align-items-center mr-2">
										<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/Group.svg" style="width:30px" />
										 <div class="ml-2">
										<div class="font-weight-bold font-12  text-dark opasity-">${res.meta.transportDestination || ''}</div>
										<div class="font-10 text-muted">Destination</div>
										</div>
										</div>
										</div>
							   
								 </div>
							</div>
							`;
												jQuery('.transportDetailsInMap').html(transportDetailsInMap);


												let data = '';

												data = `
	<div class="pb-2" style="border-bottom:1px dashed rgba(0, 0, 0, 0.88);  margin-bottom:15px;">
								<div class="d-flex align-items-center justify-content-between">
							   
								<div>
								  <img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/56789.svg" style="width:30px" /> #${res.id}
								  </div>
								 <div class="d-flex align-items-center dropdown" style="gap:10px">`;



												// Buttons based on finance status
												if (res.meta?.transportStatus && res.meta.transportStatus === "Compleated" || res.meta.transportStatus === "Cancelled" ||
													res.meta.transportStatus === "Delivered" || res.meta.transportStatus ===
													"Awaiting pickup" || res.meta.transportStatus === "On Route") {
													data += ` <button class="turbo-success dropdown-toggle font-8 px-2 py-1 rounded-pill" type="button" data-toggle="dropdown" aria-expanded="false">
		 <i class="fas fa-circle small mr-2"></i> ${res.meta.transportStatus || "Pending"} </button>`;

												} else if (res.meta.transportStatus === "Rescheduled") {
													data += `<button class="turbo-warning dropdown-toggle font-8 px-2 py-1 rounded-pill" type="button" data-toggle="dropdown" aria-expanded="false">
									  <i class="fas fa-circle small mr-2"></i>   ${res.meta.transportStatus || "Pending"}
									</button>`;
												} else {
													data += `<button  class="turbo-danger dropdown-toggle font-8 px-2 py-1 rounded-pill" type="button" data-toggle="dropdown" aria-expanded="false">
									  <i class="fas fa-circle small mr-2"></i>   ${res.meta.transportStatus || "Unassigned"}
									</button>`;
												}

												data += `
	<div class="dropdown-menu z-index">
												<a class="dropdown-item status" href="javascript:void(0)" data-type="driver"  data-status-name="Awaiting Pickup" data-entry-id="${res.id}">
													<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
														style="width:14px;" />

													Awaiting Pickup</a>
												<a class="dropdown-item status" href="javascript:void(0)"  data-type="driver" data-status-name="On Route" data-entry-id="${res.id}"><img
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
														style="width:14px;" />
													On Route</a>
												<a class="dropdown-item status" href="javascript:void(0)"  data-type="seller"  data-status-name="Delivered" data-entry-id="${res.id}"><img
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
														style="width:14px;" />
													Delivered</a>
												<a class="dropdown-item status" href="javascript:void(0)"  data-type="driver" data-status-name="Rescheduled" data-entry-id="${res.id}"><img
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
														style="width:14px;" />
													Rescheduled</a>
												<a class="dropdown-item status" href="javascript:void(0)"  data-type="driver"  data-status-name="Cancel" data-entry-id="${res.id}">
												<img
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
														style="width:14px;" />
													Cancel</a>
												<a class="dropdown-item status" href="javascript:void(0)"  data-status-name="Delete" data-entry-id="${res.id}"><img
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delete.svg"
														style="width:14px;" />
													Delete Application</a>
	</div>`;


												data += `

									<button class="btn btn-primary font-8 px-2 py-1 rounded-pill" data-tracking-id="${res.id}">Tracking</button>
								 </div>
								 </div>

								 <span class="font-12 text-dark">${res.meta.vehicleName}</span><br>
								 <span class="font-12 text-dark">Pickup: ${formatDate(res.meta.transportPickupTime)}</span>



								
								</div>

								<div class="col-12 d-flex flex-column flex-md-row font-12 p-0 mb-3">

								<div class="row flex-column mx-0 mb-2 mr-md-2">
								<div class="text-muted">Sender</div>
								<div class="font-weight-bold text-dark">${getValue(res.meta.transportSender[0].name)}</div>
								</div>
								<div class="row flex-column mx-0 mb-2 mr-md-2">
								<div class="text-muted">Receiver</div>
								<div class="font-weight-bold text-dark">${getValue(res.meta.transportReceiver[0].name)}</div>
								</div>
								<div class="row flex-column mx-0 mb-2 mr-md-2">
								<div class="text-muted">Fee</div>
								<div class="font-weight-bold text-dark">${getValue(res.meta.transportFee)}</div>
								</div>
								<div class="row flex-column mx-0 mb-2 mr-md-2">
								<div class="text-muted">Status</div>
								<div class="font-weight-bold text-dark">${getValue(res.meta.transportStatus)}</div>
								</div>
								<div class="row flex-column mx-0 mb-2 mr-md-2">
								<div class="text-muted">Referral</div>
								<div class="font-weight-bold text-dark">${getValue(res.meta.transportReferral)}</div>
								</div>

								</div>
								
							</div>`;




												const driver = [...res.meta.transportDriver].reverse()[0] || {};
												const sender = [...res.meta.transportSender].reverse()[0] || {};
												const receiver = [...res.meta.transportReceiver].reverse()[0] || {};

												data += `
					<div class="d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
						<div class="d-flex align-items-center">
							<div>
								<div class="font-10 text-muted">Driver contact</div>
								<div class="font-weight-bold font-12 ">${getValue(driver.phone)}</div>
							</div>
						</div>
						<div class="d-flex" style="gap:10px;">
							<a type="button" class="btn" href="mailto:${getValue(driver.email)}">
								<i class="fal fa-envelope"></i>
							</a>
							<a type="button" class="btn" href="tel:${getValue(driver.phone)}">
								<i class="fal fa-phone-alt"></i>
							</a>
						</div>
					</div>

					<div class="d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
						<div class="d-flex align-items-center">
							<div>
								<div class="font-10 text-muted">Sender</div>
								<div class="font-weight-bold font-12 ">${getValue(sender.name)}</div>
								<div class="text-muted font-12 ">${getValue(sender.company)}</div>
							</div>
						</div>
						<div class="d-flex" style="gap:10px;">
							<a type="button" class="btn" href="mailto:${getValue(sender.email)}">
								<i class="fal fa-envelope"></i>
							</a>
							<a type="button" class="btn" href="tel:${getValue(sender.phone)}">
								<i class="fal fa-phone-alt"></i>
							</a>
						</div>
					</div>

					<div class="d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
						<div class="d-flex align-items-center">
							<div>
								<div class="font-10 text-muted">Receiver</div>
								<div class="font-weight-bold font-12 ">${getValue(receiver.name)}</div>
								<div class="text-muted font-12 ">${getValue(receiver.company)}</div>
							</div>
						</div>
						<div class="d-flex" style="gap:10px;">
							<a type="button" class="btn" href="mailto:${getValue(receiver.email)}">
								<i class="fal fa-envelope"></i>
							</a>
							<a type="button" class="btn" href="tel:${getValue(receiver.phone)}">
								<i class="fal fa-phone-alt"></i>
							</a>
						</div>
					</div>`;


												jQuery('.transportLocationStatus').addClass('d-flex flex-column flex-md-row');
												jQuery('#transportDetails').addClass('col-12 col-md-6').html(data);


												initializeCustomLocationMap({
													pickupLocation: res.meta.transportPickupLocation || null,
													destinationLocation: res.meta.transportDestinationLocation || null,
													currentGoogleLocation: res.meta.currentAddress || null,
													transportStatus: res.meta.transportStatus || null,
													mapContainer: '.finance_map_container'
												});



												let transportDeliveryProgress = 0;

												// Ensure transportDeliveryStatus is an array
												const deliveryStatuses = Array.isArray(res.meta.transportDeliveryStatus) ? res.meta.transportDeliveryStatus : [];

												// Helper function to check if all required statuses exist
												const hasStatuses = (statuses) =>
													statuses.every((status) =>
														deliveryStatuses.some((item) => item?.status_name === status)
													);

												// Check delivery progress based on the required statuses
												if (hasStatuses(["Accepted"])) {
													transportDeliveryProgress = 25;
												}
												if (hasStatuses(["Accepted", "Pickup"])) {
													transportDeliveryProgress = 35;
												}
												if (hasStatuses(["Driver added", "Driver"])) {
													transportDeliveryProgress = 15;
												}
												if (hasStatuses(["On Route"])) {
													transportDeliveryProgress = 65;
												}
												if (hasStatuses(["Accepted", "Pickup"])) {
													transportDeliveryProgress = 35;
												}
												if (hasStatuses(["Accepted", "Pickup", "On Route"])) {
													transportDeliveryProgress = 65;
												}
												if (hasStatuses(["Accepted", "Pickup", "On Route", "Delivered"])) {
													transportDeliveryProgress = 100;
												}

												// Update progress bar or UI element
												const $progressBar = jQuery(".js-completed-bar");
												$progressBar.data("complete", transportDeliveryProgress); // Set data attribute
												$progressBar.css("width", `${transportDeliveryProgress}%`);


												let transportStatusReport = "";
												// Start the container for the status report
												transportStatusReport += `<div class="transportStepProgress">`;

												// Loop through each status in the transportDeliveryStatus array
												if (res.meta.transportDeliveryStatus != "[]" && res.meta.transportDeliveryStatus?.length > 0 || Array.isArray(res.meta.transportDeliveryStatus)) {
													res.meta.transportDeliveryStatus.forEach(function (item) {
														const statusName = item.status_name || "---"; // Default if status_name is missing
														const statusDate = item.status_submit_date ? formatDate(item.status_submit_date) : '---'; // Parse or fallback to `---`

														transportStatusReport += `
			<div class="transportStepProgress-item current number d-flex justify-content-between font-12 mb-2">
				<div class="col-4"><span>${statusName}</span></div>
			   <div class="col-8"><span>
					<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/Group-1321315839.svg" style="width:15px; object-fit:contain;" /> ${statusDate}
				</span>
				</div>
			</div>
		`;
													});
												} else {
													// If no statuses are available, show a placeholder message
													transportStatusReport += `
		<div class="transportStepProgress-item number d-flex justify-content-center font-12">
			<span>No delivery statuses available</span>
		</div>
	`;
												}

												// Close the container
												transportStatusReport += `</div>`;

												// Update the HTML content of the target element
												jQuery(".deliveryStatusReport").html(transportStatusReport);



											} else {

												let transportDetailsInMap = `
							<div class="d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
								 <div class="d-flex align-items-center justify-content-between col-12" style="gap:15px;">

										<div class="col d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
										<div class="d-flex align-items-center mr-2">
										<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/dfghjkl.svg" style="width:30px" />
										 <div class="ml-2">
										<div class="font-weight-bold font-12  text-dark opasity-">${meta['text-36'] || ''}</div>
										<div class="font-10 text-muted">Driver contact</div>
										</div>
										</div>
										</div>

										 <div class="col d-flex align-items-center justify-content-end radiusx bg-white p-2 mb-2">
										<div class="d-flex align-items-center mr-2">
										<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/Group.svg" style="width:30px" />
										 <div class="ml-2">
										<div class="font-weight-bold font-12  text-dark opasity-">${meta['text-37'] || ''}</div>
										<div class="font-10 text-muted">Destination</div>
										</div>
										</div>
										</div>
							   
								 </div>
							</div>

`;

												jQuery('.transportDetailsInMap').html(transportDetailsInMap);
												jQuery('.financeRightSidePanelDeliveryStatus').removeClass('d-none').addClass('d-block');
												jQuery('.financeRightSidePanelFaq').removeClass('d-block').addClass('d-none');
												// If response is invalid, use default values
												initializeCustomLocationMap({
													pickupLocation: { address: meta['text-36'] || '' },
													destinationLocation: { address: meta['text-37'] || '' },
													currentGoogleLocation: null,
													mapContainer: '.finance_map_container'
												});
											}
										});







										updateFinancingSteps(5);
									} else if (dealerStatus.step_name == "Disbursement") {

										if (financingCurrentStep < financingTotalSteps) {
											financingCurrentStep = 6;
										}
										updateFinancingSteps(6);
									} else if (dealerStatus.step_name == "Paperwork") {
										if (financingCurrentStep < financingTotalSteps) {
											financingCurrentStep = 4;
										}
										updateFinancingSteps(4);
									} else if (dealerStatus.step_name == "Approved") {
										if (financingCurrentStep < financingTotalSteps) {
											financingCurrentStep = 2;
										}
										updateFinancingSteps(2);
									} else {
										if (financingCurrentStep < financingTotalSteps) {
											financingCurrentStep = 1;
										}
										updateFinancingSteps(1);
									}
								<?php } else if ($isSellerFinance) { ?>
										console.log('Seller : ', dealerStatus);
										if (dealerStatus.step_name === "Delivery" || dealerStatus.step === 4 || numericStep === 4) {
											if (financingCurrentStep < financingTotalSteps) {
												financingCurrentStep = 4;
											}


											let trboSwiftTransportStart = '';


											trboSwiftTransportStart += `
			
			<div class="col-12 row mx-0 p-0 ">
			<div class="col-md-8 p-0">
			<div class="turbobidfinancing financing-bg-green mb-2 align-items-stretch">
					<img style="position: relative; padding: 20px; background: white; border-radius: 20px;"
						loading="lazy" alt="turbobid financing icon"
						src="<?php echo home_url(); ?>/wp-content/uploads/2024/07/Vector-2.svg" />

					<section class="turbobidfinancing-inner col-6 col-md-4">
						<div style="gap:8px">
							<div class="turbobid-financing-services-wrapper">
								<h3 class="turbobid-financing-services">Financing</h3>
							</div>
							<div class="lien-service">
								<div class="the-lien-payoff">
									Any Vehicle, Any Marketplace

								</div>
								<a href="<?php echo home_url() ?>/finance" class="btn btn-primary rounded-pill px-3" style="font-size:10px">Explore Finance</a>
							</div>

						</div>
					</section>
					<div class="col-12 col-md d-flex justify-content-between align-items-stretch">
						<div class="col-4">
							<div
								style="height:100%; width:100%; background:#44795B; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
								<div
									style="width:50px; height:50px; background:#3B634C; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
									<svg xmlns="http://www.w3.org/2000/svg" width="23" height="26" viewBox="0 0 23 26"
										fill="none">
										<path d="M7.39062 11.3485L9.9779 13.9352L15.1518 8.76123" stroke="white"
											stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
										<path
											d="M11.2715 24.2837L12.4096 23.7919C14.7959 22.7679 16.8565 21.1105 18.3683 18.9992C19.8801 16.8878 20.7853 14.4031 20.986 11.8142L21.5424 4.67385C21.5514 4.37815 21.4587 4.08829 21.2797 3.85276C21.1007 3.61723 20.8462 3.45031 20.5589 3.3799L11.2715 1L1.98409 3.32837C1.69685 3.39875 1.44248 3.56559 1.26347 3.80099C1.08446 4.03639 0.991664 4.3261 1.00059 4.6217L1.55691 11.762C1.75752 14.3511 2.66274 16.8359 4.17451 18.9474C5.68628 21.0588 7.74698 22.7163 10.1334 23.7404L11.2715 24.2837Z"
											stroke="white" stroke-width="1.5" stroke-linecap="round"
											stroke-linejoin="round">
										</path>
									</svg>
								</div>
								<span style="font-size:10px; color:white">Secure &amp; Fast<br>Approvals </span>

							</div>
						</div>
						<div class="col-4">
							<div
								style="height:100%; width:100%; background:#44795B; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
								<div
									style="width:50px; height:50px; background:#3B634C; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
										fill="none">
										<path
											d="M12.004 24C10.3453 24 8.78533 23.6853 7.324 23.056C5.86356 22.4258 4.59289 21.5707 3.512 20.4907C2.43111 19.4107 1.57556 18.1413 0.945333 16.6827C0.315111 15.224 0 13.6644 0 12.004C0 10.3436 0.315111 8.78356 0.945333 7.324C1.57556 5.86356 2.43067 4.59289 3.51067 3.512C4.59067 2.43111 5.86044 1.57556 7.32 0.945333C8.77956 0.315111 10.3396 0 12 0H12.6667V10.8533C12.896 10.9956 13.0644 11.1609 13.172 11.3493C13.2796 11.5378 13.3333 11.7556 13.3333 12.0027C13.3333 12.3582 13.2004 12.6689 12.9347 12.9347C12.6689 13.2004 12.3573 13.3333 12 13.3333C11.6427 13.3333 11.3311 13.2004 11.0653 12.9347C10.7996 12.6689 10.6667 12.3591 10.6667 12.0053C10.6667 11.76 10.7204 11.5409 10.828 11.348C10.9356 11.1551 11.104 10.9907 11.3333 10.8547V6.73067C10.0071 6.888 8.89778 7.46445 8.00533 8.46C7.11289 9.45556 6.66667 10.6356 6.66667 12C6.66667 13.4667 7.18889 14.7222 8.23333 15.7667C9.27778 16.8111 10.5333 17.3333 12 17.3333C13.4667 17.3333 14.7222 16.8111 15.7667 15.7667C16.8111 14.7222 17.3333 13.4667 17.3333 12C17.3333 11.2 17.172 10.4613 16.8493 9.784C16.5267 9.10667 16.088 8.512 15.5333 8L16.4853 7.04933C17.16 7.66267 17.692 8.39378 18.0813 9.24267C18.4707 10.0916 18.6658 11.0107 18.6667 12C18.6667 13.8516 18.0191 15.4258 16.724 16.7227C15.4289 18.0196 13.8564 18.6676 12.0067 18.6667C10.1569 18.6658 8.58133 18.0178 7.28 16.7227C5.98222 15.4258 5.33333 13.8516 5.33333 12C5.33333 10.2569 5.91111 8.75733 7.06667 7.50133C8.22222 6.24533 9.64444 5.53867 11.3333 5.38133V1.34933C8.53511 1.512 6.16889 2.61467 4.23467 4.65733C2.30044 6.7 1.33333 9.14756 1.33333 12C1.33333 14.9778 2.36667 17.5 4.43333 19.5667C6.5 21.6333 9.02222 22.6667 12 22.6667C14.9778 22.6667 17.5 21.6333 19.5667 19.5667C21.6333 17.5 22.6667 14.9778 22.6667 12C22.6667 10.4667 22.3667 9.03333 21.7667 7.7C21.1667 6.36667 20.3444 5.21111 19.3 4.23333L20.2507 3.28267C21.4151 4.38489 22.3311 5.68178 22.9987 7.17333C23.6662 8.66489 24 10.2711 24 11.992C24 13.6542 23.6853 15.2156 23.056 16.676C22.4258 18.1364 21.5707 19.4071 20.4907 20.488C19.4107 21.5689 18.1413 22.4244 16.6827 23.0547C15.224 23.6849 13.6644 24 12.004 24Z"
											fill="white"></path>
									</svg>
								</div>
								<span style="font-size:10px; color:white">
									Add Warranty,Insurance<br>&amp; Transport Options </span>

							</div>
						</div>
						<div class="col-4">
							<div
								style="height:100%; width:100%; background:#44795B; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
								<div
									style="width:50px; height:50px; background:#3B634C; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
									<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23"
										fill="none">
										<path
											d="M11.5 0C12.5557 0 13.5739 0.134766 14.5547 0.404297C15.5355 0.673828 16.4526 1.05941 17.3062 1.56104C18.1597 2.06266 18.9346 2.66162 19.6309 3.35791C20.3271 4.0542 20.9261 4.83285 21.4277 5.69385C21.9294 6.55485 22.3149 7.47201 22.5845 8.44531C22.854 9.41862 22.9925 10.4368 23 11.5C23 12.2412 22.9289 12.9712 22.7866 13.6899C22.6444 14.4087 22.4347 15.1162 22.1577 15.8125H18.6875V14.375H21.1357C21.4202 13.4316 21.5625 12.4733 21.5625 11.5C21.5625 10.5042 21.424 9.5459 21.147 8.625H17.0703C17.1302 9.10417 17.1751 9.57959 17.2051 10.0513C17.235 10.5229 17.25 11.0059 17.25 11.5H15.8125C15.8125 11.0133 15.7975 10.5342 15.7676 10.0625C15.7376 9.59082 15.689 9.11165 15.6216 8.625H7.37842C7.31852 9.10417 7.2736 9.57959 7.24365 10.0513C7.2137 10.5229 7.19499 11.0059 7.1875 11.5C7.1875 11.9867 7.20247 12.4658 7.23242 12.9375C7.26237 13.4092 7.31104 13.8883 7.37842 14.375H14.375V15.8125H7.62549C7.68538 16.1045 7.77148 16.4489 7.88379 16.8457C7.99609 17.2425 8.1346 17.6543 8.29932 18.0811C8.46403 18.5078 8.6512 18.9271 8.86084 19.3389C9.07048 19.7507 9.3138 20.125 9.59082 20.4619C9.86784 20.7988 10.1598 21.0646 10.4668 21.2593C10.7738 21.4539 11.1182 21.555 11.5 21.5625C11.7246 21.5625 11.938 21.5213 12.1401 21.439C12.3423 21.3566 12.5332 21.2443 12.7129 21.1021C12.8926 20.9598 13.0573 20.8063 13.207 20.6416C13.3568 20.4769 13.4953 20.3047 13.6226 20.125H14.375V22.6182C13.9033 22.7454 13.4279 22.839 12.9487 22.8989C12.4696 22.9588 11.9867 22.9925 11.5 23C10.4443 23 9.42611 22.8652 8.44531 22.5957C7.46452 22.3262 6.54736 21.9406 5.69385 21.439C4.84033 20.9373 4.06543 20.3384 3.36914 19.6421C2.67285 18.9458 2.07389 18.1672 1.57227 17.3062C1.07064 16.4452 0.685059 15.5317 0.415527 14.5659C0.145996 13.6001 0.00748698 12.5781 0 11.5C0 10.4443 0.134766 9.42611 0.404297 8.44531C0.673828 7.46452 1.05941 6.54736 1.56104 5.69385C2.06266 4.84033 2.66162 4.06543 3.35791 3.36914C4.0542 2.67285 4.83285 2.07389 5.69385 1.57227C6.55485 1.07064 7.46826 0.685059 8.43408 0.415527C9.3999 0.145996 10.4219 0.00748698 11.5 0ZM8.20947 1.98779C7.57308 2.20492 6.97038 2.48568 6.40137 2.83008C5.83236 3.17448 5.29704 3.56755 4.79541 4.00928C4.29378 4.45101 3.84831 4.93766 3.45898 5.46924C3.06966 6.00081 2.72152 6.57357 2.41455 7.1875H6.1543C6.23665 6.74577 6.33773 6.29655 6.45752 5.83984C6.57731 5.38314 6.72331 4.93018 6.89551 4.48096C7.06771 4.03174 7.26237 3.59749 7.47949 3.17822C7.69661 2.75895 7.93994 2.36214 8.20947 1.98779ZM8.20947 21.0122C7.93994 20.6453 7.69661 20.2523 7.47949 19.833C7.26237 19.4137 7.07145 18.9795 6.90674 18.5303C6.74202 18.0811 6.59603 17.6281 6.46875 17.1714C6.34147 16.7147 6.23665 16.2617 6.1543 15.8125H2.41455C2.70654 16.4189 3.05094 16.988 3.44775 17.5195C3.84456 18.0511 4.29378 18.5415 4.79541 18.9907C5.29704 19.4399 5.82861 19.833 6.39014 20.1699C6.95166 20.5068 7.55811 20.7876 8.20947 21.0122ZM5.92969 14.375C5.86979 13.8958 5.82487 13.4204 5.79492 12.9487C5.76497 12.4771 5.75 11.9941 5.75 11.5C5.75 11.0133 5.76497 10.5342 5.79492 10.0625C5.82487 9.59082 5.86979 9.11165 5.92969 8.625H1.85303C1.57601 9.5459 1.4375 10.5042 1.4375 11.5C1.4375 12.4958 1.57601 13.4541 1.85303 14.375H5.92969ZM15.3745 7.1875C15.3146 6.89551 15.2285 6.55111 15.1162 6.1543C15.0039 5.75749 14.8654 5.3457 14.7007 4.91895C14.536 4.49219 14.3488 4.07292 14.1392 3.66113C13.9295 3.24935 13.6862 2.875 13.4092 2.53809C13.1322 2.20117 12.8402 1.93538 12.5332 1.74072C12.2262 1.54606 11.8818 1.44499 11.5 1.4375C11.1331 1.4375 10.7925 1.53857 10.478 1.74072C10.1636 1.94287 9.86784 2.20866 9.59082 2.53809C9.3138 2.86751 9.07422 3.23812 8.87207 3.6499C8.66992 4.06169 8.479 4.4847 8.29932 4.91895C8.11963 5.35319 7.98112 5.76497 7.88379 6.1543C7.78646 6.54362 7.70036 6.88802 7.62549 7.1875H15.3745ZM20.5854 7.1875C20.2935 6.58105 19.9491 6.01204 19.5522 5.48047C19.1554 4.94889 18.7062 4.4585 18.2046 4.00928C17.703 3.56006 17.1714 3.16699 16.6099 2.83008C16.0483 2.49316 15.4419 2.2124 14.7905 1.98779C15.0601 2.35466 15.3034 2.74772 15.5205 3.16699C15.7376 3.58626 15.9285 4.02051 16.0933 4.46973C16.258 4.91895 16.404 5.37191 16.5312 5.82861C16.6585 6.28532 16.7633 6.73828 16.8457 7.1875H20.5854ZM17.25 17.25H21.5625V18.6875H17.25V23H15.8125V18.6875H11.5V17.25H15.8125V12.9375H17.25V17.25Z"
											fill="white"></path>
									</svg>
								</div>
								<span style="font-size:10px; color:white">
									Instant Payment to<br>Sellers with Trbo Swift </span>
								</span>

							</div>
						</div>

					</div>
				</div>
				
				
				<div class="modal-body text-left">
				
				
				<h5>Please make your Selection</h5>
				<span class="small">The seller has chosen a pickup time slot. Once you select yours, Trbo Swift will arrange the transportation.</span>
				
				<div class="col-12 row mx-0 px-0">
				<div class="col-md-5 pl-md-0">
				<div class="calenderLeftInfo">
								<div class="row mx-0 mb-2 mr-md-2">
								<div class="text-muted mr-3">Buyer</div>
								<div class="font-weight-bold text-dark">${getValue(meta['name-1'])} ${getValue(meta['name-2'])}</div>
								</div>
								<div class="row mx-0 mb-2 mr-md-2">
								<div class="text-muted mr-3">Seller</div>
								<div class="font-weight-bold text-dark">${getValue(meta['name-4'])}</div>
								</div>
								<div class="row mx-0 mb-2 mr-md-2">
								<div class="text-muted mr-3">VIN</div>
								<div class="font-weight-bold text-dark">${getValue(meta['text-13'])}</div>
								</div>
								
								<hr>
								<div class="mt-2">
								<h5>Vehicle Pickup</h5>
								<small class="text-primary">Powered by Trbo Swift</small>
								
								<div class="row mx-0 mb-2 mr-md-2">
								<div class="text-muted mr-3"><img src="<?php echo home_Url(); ?>/wp-content/uploads/2025/02/clock.svg" style="width:25px" /> </div>
								<div class="font-weight-bold text-secondary small">1 Hour Pickup window</div>
								</div>
								
								<div class="mt-3 strong">After confirming your preferred pickup dates and times, Trbo Swift will assign a delivery partner to manage your request. You can track the process in real time using the provided link, and the buyer will finalize their choice by selecting a time slot from the options you’ve offered.</div>
								
								</div>
								</div>
				</div>
				<div class="col-md-7">
				<div class="calendar-container">
					<h5>Select Date & Time</h5>
					 <div class="calendar"></div>

					<div class="timezone-container">
						<label for="timezone">Time Zone</label>
						<select id="timezone">
							<option value="America/Toronto" selected>Eastern Time - US & Canada</option>
							<option value="America/New_York">New York (EST)</option>
							<option value="America/Chicago">Chicago (CST)</option>
							<option value="America/Denver">Denver (MST)</option>
							<option value="America/Los_Angeles">Los Angeles (PST)</option>
							<option value="Europe/London">London (GMT)</option>
							<option value="Asia/Dubai">Dubai (GST)</option>
							<option value="Asia/Kolkata">India (IST)</option>
						</select>
					</div>

					<div class="selected-date"></div>
				</div>

				
				
				</div>
				
				</div>
				
				</div>
				
			
			</div>
			<div class="col-md-4 text-left">
			
			<h6>Seller Suggested</h6>
			
			<div>
			
			<div class="container my-3 p-0">
				<h6 class="mb-2">Please pick up to 3 dates</h6>

				<div class="selectedDateForPickup">
					<span class="text-primary selectedDate"></span>

					<div class="selectedTime py-4 d-flex justify-content-center align-items-center my-2" 
						style="background: #FFF3D2; border: 0.5px dashed #BF9B3E; border-radius:6px;">
						<span class="text-primary time"></span>
					</div>

					<span class="small">Thank you for your order! To schedule your delivery, please select a time slot from the options below:</span>
				</div>

				<div class="timeSlotList"></div>
			</div>

			<!-- Include PIGNOSE Calendar -->
			<input type="hidden" id="vehiclePickupDate" />


			<button  class="submitSellerSuggestedTime btn btn-secondary px-4 rounded-pill">Finish</button>
			
			</div>
			
			
			
			
			
			</div>
			
			`;

											jQuery(document).ready(function ($) {

												// Function to format date
												function formatDate(date) {
													let options = { weekday: 'long', month: 'long', day: 'numeric' };
													return date.toLocaleDateString('en-US', options);
												}

												// Function to get future dates
												function getFutureDates(startDate, numDays = 4) {
													let dates = [];
													for (let i = 0; i < numDays; i++) {
														let futureDate = new Date(startDate);
														futureDate.setDate(startDate.getDate() + i);
														dates.push(futureDate);
													}
													return dates;
												}

												// Function to update the UI
												function updateDateTimeUI(selectedDate) {
													let now = new Date();
													let currentTime = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });

													$(".selectedDate").text(formatDate(selectedDate));
													$(".time").text(currentTime);

													let futureDates = getFutureDates(selectedDate);
													let timeSlots = ["7:00 - 10:00 AM", "10:30 AM - 1:30 PM", "2:00 - 5:00 PM", "6:00 - 9:00 PM"];

													let sellerSuggestedTimes = stringArrayToArray(meta["sellerSuggestedTimes"]); // Convert stored data

													let timeSlotHtml = "";
													futureDates.forEach((date, index) => {
														let formattedDate = date.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });

														// Find if this date and time exist in sellerSuggestedTimes
														let isChecked = sellerSuggestedTimes.some(suggested =>
															suggested.date === formattedDate && suggested.time === timeSlots[index]
														);

														timeSlotHtml += `
					<div class="mb-3">
						<span style="font-weight:bold;">Slot ${index + 1}:</span>
						<div class="timeSlot my-2 position-relative" 
							style="background:rgb(249, 243, 228); border: 0.5px dashed rgb(194, 187, 167); border-radius:6px; height:56px;">
							<input type="checkbox" class="timeSlotCheckbox" 
								style="position:absolute; left:10px; top:50%; transform: translateY(-50%);" 
								${isChecked ? "checked" : ""} />
							<span class="text-primary slotDate py-3" 
								style="position:absolute; right:200px; top:50%; transform: translateY(-50%); border-right: 2px solid #E3E3E3; padding-right:20px">
								${formattedDate}
							</span>
							<span class="text-primary slotTime py-3" 
								style="position:absolute; right:53px; top:50%; transform: translateY(-50%);">
								${timeSlots[index]}
							</span>
						</div>
					</div>
				`;
													});

													$(".timeSlotList").html(timeSlotHtml);
												}


												// Initialize with today's date
												let today = new Date();
												updateDateTimeUI(today);

												// Initialize PIGNOSE Calendar
												$(".calendar").pignoseCalendar({
													lang: "en",
													theme: "light",
													format: "YYYY-MM-DD",
													initialize: true,
													multiple: false,
													select: function (date, obj) {
														if (date[0] !== null) {
															let selectedDate = new Date(date[0].format("YYYY-MM-DD"));
															$("#vehiclePickupDate").val(date[0].format("YYYY-MM-DD"));
															updateDateTimeUI(selectedDate);
														}
													}
												});

												// Ensure user selects up to 3 time slots
												$(document).on("change", ".timeSlotCheckbox", function () {
													if ($(".timeSlotCheckbox:checked").length > 3) {
														$(this).prop("checked", false);
														alert("You can select a maximum of 3 time slots.");
													}
												});
											});


											jQuery('.newUserAddModalContainer').addClass('bg-white').css({ "max-width": "95%", "max-height": "95vh" }).html(trboSwiftTransportStart);
											// jQuery('.newUserAddModalBody').removeClass('d-none').addClass('d-flex');
											if ($("#financing").css("display") !== "none") {
												jQuery('.newUserAddModalBody').removeClass('d-none').addClass('d-flex');
											}




											handleGetTransport(escrowId, function (res) {
												if (res) {
													let transportDetailsInMap = `
							<div class="d-flex align-items-center justify-content-between bg-white p-2 mb-2" style="border-radius: 0 0 15px 15px; box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
								 <div class="d-flex align-items-center justify-content-between col-12" style="gap:15px;">

										<div class="col d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
										<div class="d-flex align-items-center mr-2">
										<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/dfghjkl.svg" style="width:30px" />
										 <div class="ml-2">
										<div class="font-weight-bold font-12  text-dark opasity-">${res.meta.transportPickup || ''}</div>
										<div class="font-10 text-muted">Driver contact</div>
										</div>
										</div>
										</div>

										 <div class="col d-flex align-items-center justify-content-end radiusx bg-white p-2 mb-2">
										<div class="d-flex align-items-center mr-2">
										<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/Group.svg" style="width:30px" />
										 <div class="ml-2">
										<div class="font-weight-bold font-12  text-dark opasity-">${res.meta.transportDestination || ''}</div>
										<div class="font-10 text-muted">Destination</div>
										</div>
										</div>
										</div>
							   
								 </div>
							</div>
							`;
													jQuery('.transportDetailsInMap').html(transportDetailsInMap);


													let data = '';

													data = `
	<div class="pb-2" style="border-bottom:1px dashed rgba(0, 0, 0, 0.88);  margin-bottom:15px;">
								<div class="d-flex align-items-center justify-content-between">
							   
								<div>
								  <img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/56789.svg" style="width:30px" /> #${res.id}
								  </div>
								 <div class="d-flex align-items-center dropdown" style="gap:10px">`;



													// Buttons based on finance status
													if (res.meta?.transportStatus && res.meta.transportStatus === "Compleated" || res.meta.transportStatus === "Cancelled" ||
														res.meta.transportStatus === "Delivered" || res.meta.transportStatus ===
														"Awaiting pickup" || res.meta.transportStatus === "On Route") {
														data += ` <button class="turbo-success dropdown-toggle font-8 px-2 py-1 rounded-pill" type="button" data-toggle="dropdown" aria-expanded="false">
		 <i class="fas fa-circle small mr-2"></i> ${res.meta.transportStatus || "Pending"} </button>`;

													} else if (res.meta.transportStatus === "Rescheduled") {
														data += `<button class="turbo-warning dropdown-toggle font-8 px-2 py-1 rounded-pill" type="button" data-toggle="dropdown" aria-expanded="false">
									  <i class="fas fa-circle small mr-2"></i>   ${res.meta.transportStatus || "Pending"}
									</button>`;
													} else {
														data += `<button  class="turbo-danger dropdown-toggle font-8 px-2 py-1 rounded-pill" type="button" data-toggle="dropdown" aria-expanded="false">
									  <i class="fas fa-circle small mr-2"></i>   ${res.meta.transportStatus || "Unassigned"}
									</button>`;
													}

													data += `
	<div class="dropdown-menu z-index">
												<a class="dropdown-item status" href="javascript:void(0)" data-type="driver"  data-status-name="Awaiting Pickup" data-entry-id="${res.id}">
													<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
														style="width:14px;" />

													Awaiting Pickup</a>
												<a class="dropdown-item status" href="javascript:void(0)"  data-type="driver" data-status-name="On Route" data-entry-id="${res.id}"><img
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
														style="width:14px;" />
													On Route</a>
												<a class="dropdown-item status" href="javascript:void(0)"  data-type="seller"  data-status-name="Delivered" data-entry-id="${res.id}"><img
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
														style="width:14px;" />
													Delivered</a>
												<a class="dropdown-item status" href="javascript:void(0)"  data-type="driver" data-status-name="Rescheduled" data-entry-id="${res.id}"><img
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
														style="width:14px;" />
													Rescheduled</a>
												<a class="dropdown-item status" href="javascript:void(0)"  data-type="driver"  data-status-name="Cancel" data-entry-id="${res.id}">
												<img
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
														style="width:14px;" />
													Cancel</a>
												<a class="dropdown-item status" href="javascript:void(0)"  data-status-name="Delete" data-entry-id="${res.id}"><img
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delete.svg"
														style="width:14px;" />
													Delete Application</a>
	</div>`;


													data += `

									<button class="btn btn-primary font-8 px-2 py-1 rounded-pill" data-tracking-id="${res.id}">Tracking</button>
								 </div>
								 </div>

								 <span class="font-12 text-dark">${res.meta.vehicleName}</span><br>
								 <span class="font-12 text-dark">Pickup: ${formatDate(res.meta.transportPickupTime)}</span>



								
								</div>

								<div class="col-12 d-flex flex-column flex-md-row font-12 p-0 mb-3">

								<div class="row flex-column mx-0 mb-2 mr-md-2">
								<div class="text-muted">Sender</div>
								<div class="font-weight-bold text-dark">${getValue(res.meta.transportSender[0].name)}</div>
								</div>
								<div class="row flex-column mx-0 mb-2 mr-md-2">
								<div class="text-muted">Receiver</div>
								<div class="font-weight-bold text-dark">${getValue(res.meta.transportReceiver[0].name)}</div>
								</div>
								<div class="row flex-column mx-0 mb-2 mr-md-2">
								<div class="text-muted">Fee</div>
								<div class="font-weight-bold text-dark">${getValue(res.meta.transportFee)}</div>
								</div>
								<div class="row flex-column mx-0 mb-2 mr-md-2">
								<div class="text-muted">Status</div>
								<div class="font-weight-bold text-dark">${getValue(res.meta.transportStatus)}</div>
								</div>
								<div class="row flex-column mx-0 mb-2 mr-md-2">
								<div class="text-muted">Referral</div>
								<div class="font-weight-bold text-dark">${getValue(res.meta.transportReferral)}</div>
								</div>

								</div>
								
							</div>`;




													const driver = [...res.meta.transportDriver].reverse()[0] || {};
													const sender = [...res.meta.transportSender].reverse()[0] || {};
													const receiver = [...res.meta.transportReceiver].reverse()[0] || {};

													data += `
					<div class="d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
						<div class="d-flex align-items-center">
							<div>
								<div class="font-10 text-muted">Driver contact</div>
								<div class="font-weight-bold font-12 ">${getValue(driver.phone)}</div>
							</div>
						</div>
						<div class="d-flex" style="gap:10px;">
							<a type="button" class="btn" href="mailto:${getValue(driver.email)}">
								<i class="fal fa-envelope"></i>
							</a>
							<a type="button" class="btn" href="tel:${getValue(driver.phone)}">
								<i class="fal fa-phone-alt"></i>
							</a>
						</div>
					</div>

					<div class="d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
						<div class="d-flex align-items-center">
							<div>
								<div class="font-10 text-muted">Sender</div>
								<div class="font-weight-bold font-12 ">${getValue(sender.name)}</div>
								<div class="text-muted font-12 ">${getValue(sender.company)}</div>
							</div>
						</div>
						<div class="d-flex" style="gap:10px;">
							<a type="button" class="btn" href="mailto:${getValue(sender.email)}">
								<i class="fal fa-envelope"></i>
							</a>
							<a type="button" class="btn" href="tel:${getValue(sender.phone)}">
								<i class="fal fa-phone-alt"></i>
							</a>
						</div>
					</div>

					<div class="d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
						<div class="d-flex align-items-center">
							<div>
								<div class="font-10 text-muted">Receiver</div>
								<div class="font-weight-bold font-12 ">${getValue(receiver.name)}</div>
								<div class="text-muted font-12 ">${getValue(receiver.company)}</div>
							</div>
						</div>
						<div class="d-flex" style="gap:10px;">
							<a type="button" class="btn" href="mailto:${getValue(receiver.email)}">
								<i class="fal fa-envelope"></i>
							</a>
							<a type="button" class="btn" href="tel:${getValue(receiver.phone)}">
								<i class="fal fa-phone-alt"></i>
							</a>
						</div>
					</div>`;


													jQuery('.transportLocationStatus').addClass('d-flex flex-column flex-md-row');
													jQuery('#transportDetails').addClass('col-12 col-md-6').html(data);


													initializeCustomLocationMap({
														pickupLocation: res.meta.transportPickupLocation || null,
														destinationLocation: res.meta.transportDestinationLocation || null,
														currentGoogleLocation: res.meta.currentAddress || null,
														transportStatus: res.meta.transportStatus || null,
														mapContainer: '.finance_map_container'
													});



													let transportDeliveryProgress = 0;

													// Ensure transportDeliveryStatus is an array
													const deliveryStatuses = Array.isArray(res.meta.transportDeliveryStatus) ? res.meta.transportDeliveryStatus : [];

													// Helper function to check if all required statuses exist
													const hasStatuses = (statuses) =>
														statuses.every((status) =>
															deliveryStatuses.some((item) => item?.status_name === status)
														);

													// Check delivery progress based on the required statuses
													if (hasStatuses(["Accepted"])) {
														transportDeliveryProgress = 25;
													}
													if (hasStatuses(["Accepted", "Pickup"])) {
														transportDeliveryProgress = 35;
													}
													if (hasStatuses(["Driver added", "Driver"])) {
														transportDeliveryProgress = 15;
													}
													if (hasStatuses(["On Route"])) {
														transportDeliveryProgress = 65;
													}
													if (hasStatuses(["Accepted", "Pickup"])) {
														transportDeliveryProgress = 35;
													}
													if (hasStatuses(["Accepted", "Pickup", "On Route"])) {
														transportDeliveryProgress = 65;
													}
													if (hasStatuses(["Accepted", "Pickup", "On Route", "Delivered"])) {
														transportDeliveryProgress = 100;
													}

													// Update progress bar or UI element
													const $progressBar = jQuery(".js-completed-bar");
													$progressBar.data("complete", transportDeliveryProgress); // Set data attribute
													$progressBar.css("width", `${transportDeliveryProgress}%`);


													let transportStatusReport = "";
													// Start the container for the status report
													transportStatusReport += `<div class="transportStepProgress">`;

													// Loop through each status in the transportDeliveryStatus array
													if (res.meta.transportDeliveryStatus != "[]" && res.meta.transportDeliveryStatus?.length > 0 || Array.isArray(res.meta.transportDeliveryStatus)) {
														res.meta.transportDeliveryStatus.forEach(function (item) {
															const statusName = item.status_name || "---"; // Default if status_name is missing
															const statusDate = item.status_submit_date ? formatDate(item.status_submit_date) : '---'; // Parse or fallback to `---`

															transportStatusReport += `
			<div class="transportStepProgress-item current number d-flex justify-content-between font-12 mb-2">
				<div class="col-4"><span>${statusName}</span></div>
			   <div class="col-8"><span>
					<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/Group-1321315839.svg" style="width:15px; object-fit:contain;" /> ${statusDate}
				</span>
				</div>
			</div>
		`;
														});
													} else {
														// If no statuses are available, show a placeholder message
														transportStatusReport += `
		<div class="transportStepProgress-item number d-flex justify-content-center font-12">
			<span>No delivery statuses available</span>
		</div>
	`;
													}

													// Close the container
													transportStatusReport += `</div>`;

													// Update the HTML content of the target element
													jQuery(".deliveryStatusReport").html(transportStatusReport);



												} else {

													let transportDetailsInMap = `
							<div class="d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
								 <div class="d-flex align-items-center justify-content-between col-12" style="gap:15px;">

										<div class="col d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
										<div class="d-flex align-items-center mr-2">
										<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/dfghjkl.svg" style="width:30px" />
										 <div class="ml-2">
										<div class="font-weight-bold font-12  text-dark opasity-">${meta['text-36'] || ''}</div>
										<div class="font-10 text-muted">Driver contact</div>
										</div>
										</div>
										</div>

										 <div class="col d-flex align-items-center justify-content-end radiusx bg-white p-2 mb-2">
										<div class="d-flex align-items-center mr-2">
										<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/Group.svg" style="width:30px" />
										 <div class="ml-2">
										<div class="font-weight-bold font-12  text-dark opasity-">${meta['text-37'] || ''}</div>
										<div class="font-10 text-muted">Destination</div>
										</div>
										</div>
										</div>
							   
								 </div>
							</div>

`;

													jQuery('.transportDetailsInMap').html(transportDetailsInMap);
													jQuery('.financeRightSidePanelDeliveryStatus').removeClass('d-none').addClass('d-block');
													jQuery('.financeRightSidePanelFaq').removeClass('d-block').addClass('d-none');
													// If response is invalid, use default values
													initializeCustomLocationMap({
														pickupLocation: { address: meta['text-36'] || '' },
														destinationLocation: { address: meta['text-37'] || '' },
														currentGoogleLocation: null,
														mapContainer: '.finance_map_container'
													});
												}
											});








											updateFinancingSteps(4);
										} else if (dealerStatus.step_name == "Disbursement") {
											if (financingCurrentStep < financingTotalSteps) {
												financingCurrentStep = 3;
											}




											updateFinancingSteps(3);
										} else if (dealerStatus.step == 5 && dealerStatus.status == 'Completed') {
											jQuery('#confirmSellerFinanceComplete').text('Completed');

											updateFinancingSteps(5);

										} else if (dealerStatus.step_name === "Approved" && dealerStatus.status == 'Approved') {
											jQuery('.financeApplicationDecision').text('Decision: Approved');
											if (financingCurrentStep < financingTotalSteps) {
												financingCurrentStep = 2;
											}
											updateFinancingSteps(2);
											showApprovalModal(dealerStatus, meta);

										} else if (dealerStatus.step == 2 && dealerStatus.status == 'Accepted') {
											jQuery('.financeApplicationDecision').text('Decision: Approved');
											jQuery('.financeViewAggriment').removeClass('disabled');
											if (financingCurrentStep < financingTotalSteps) {
												financingCurrentStep = 2;
											}
											updateFinancingSteps(2);

										} else if (!numericStep && escrowId) {
											updateFinancingSteps(1);
										} else if (!numericStep && !escrowId) {
											updateFinancingSteps(0);
										} else {
											updateFinancingSteps(numericStep);
										}
								<?php } else { ?>
										console.log('Not Work PHP : ', dealerStatus);
								<?php } ?>


								// showApprovalModal(dealerStatus, meta);

								var approvalAmountTerm = `${formatCalCadPrice(meta['paymentAmountTerm'] || 0)}`;

								$('.approvalAmountCard').text(approvalAmountTerm);
								$('.termType').text(
									`/${meta['paymentAmountTerm'] ? 'Month' : meta['biWeeklyPaymentTerm'] ? 'Week' : 'Year'}`)


								$('.approvalInterestCard').text((meta['interestRateTerm'] || '') + '' + '% ');
								$('.approvalMonthTermCard').text(meta['approvalTermTerm'] || '');



								$('#approvedAmounts').val(formatCalCadPrice(meta['approvedAmount'] || 0));

								$('#buyerLender').val(meta['lender'] || '');

								$('#buyerLenderType').val(meta['lenderType'] || 'Prime');

								$('#buyerPaymentFrequency').val(meta['approvalTermTerm'] === 'Monthly' ? 'Monthly' : meta[
									'approvalTermTerm'] === 'Weekly' ? 'Biweekly' : 'Monthly');

								$('.aftermarketWarranty .price span').text(formatCalCadPrice(meta['warrantyCost']) + ' ' + 'Monthly');
								$('.gAPInsurance .price span').text(formatCalCadPrice(meta['gaapInsurance']) + ' ' + 'Monthly');
								$('.lifeInsurance .price span').text(formatCalCadPrice(meta['lifeInsurance']) + ' ' + 'Monthly');
								$('.turbobidTransport .price span').text(formatCalCadPrice(meta['turboBidTransport']) + ' ' + 'Total');


								// $('.term-1 #biWeeklyPayment').val(meta['biWeeklyPaymentTerm'] || '');
								// $('.term-1 #approvalTerm').val(meta['approvalTermTerm'] || '');
								// $('.term-1 #interestRate').val(meta['interestRateTerm'] || '');

								// $('.term-2 #paymentAmount').val(meta['paymentAmountTermTwo'] || '');
								// $('.term-2 #biWeeklyPayment').val(meta['biWeeklyPaymentTermTwo'] || '');
								// $('.term-2 #approvalTerm').val(meta['approvalTermTermTwo'] || '');
								// $('.term-2 #interestRate').val(meta['interestRateTermTwo'] || '');



								if (dealerStatus.step >= 1 && step >= 4) {

									$('.financeDetails').find('.lenderName').text(meta['buyerApprovedLender']);
									$('.financeDetails').find('.interestRate').text((meta['interestRateTerm'] || '') + '' + '%');

									$('.financeDetails').find('.paymentWithTerm').text(
										`${meta['approvedMonthlyAmount'] || 0} ${meta['buyerApprovedPaymentFrequency']}`);

									$('.financeDetails').find('.approvedFinanceAmount').text(
										`CA ${formatCalCadPrice(meta['buyerApprovedAmount'] || 0)}`);

									$('.financeDetails').find('.lenderType').text(meta['buyerApprovedLenderType'] || '');

									$('.financeDetails').find('.termLength').text(meta['approvalTermTerm'] || '');

									$('.financeDetails').find('.paymentType').text(meta['buyerApprovedPaymentFrequency'] || '');

								}




							}


							function showApprovalModal(dealerStatus, meta) {
								var entryId = parseInt($('#finance_entry_id').val());

								jQuery('.documentManagementBody #documentManageTitle').html('Upload Document');

								jQuery('.documentManagementBody .sendDocumentSection').removeClass('d-block').addClass(
									'd-none');
								jQuery('.documentManagementBody .documentViewSection').removeClass('d-none').addClass(
									'bg-white d-block');

								jQuery('.documentManagementBody #documentManageTitle').hide();
								jQuery('.documentManagementBody .documentManagementContainer').removeClass(
									'p-3 customModalWidthHalf')
									.addClass(
										'p-0 border-0 customModalWidthSmall');

								let displayData = `
<div class="p-3">
								<div class="container m-0 p-2 position-relative"
									style="border-radius:22px; border:1px solid #3B634C;">

									<div class="col-12 d-flex justify-content-between align-items-center py-2"> <span class="text-secondary font-weight-bold font-16" style="font-family:Plus Jakarta Sans;">DEAL AGREEMENT</span>  <button class="copyId btn font-12">Application: #${entryId} <i class="fal fa-copy ml-1"></i></button></div> 


									<div class="col-md-10">
										
									<div class="mb-2 font-10 text-left">
										<p><span class="text-primary">Buyer (${meta['name-1']} ${meta['name-2']})</span> is
											approved for <span class="text-secondary">${formatCalCadPrice(meta['approvedAmount'] || 0)} to ${meta['select-1']}  ${meta['text-14']} ${meta['select-2']} with the VIN - <strong class="text-uppercase">${meta['text-13']}</strong></span> from 
											<span class="text-primary">Seller(${meta['name-4']})</span> Seller is required to complete the TrboSwfift AI Damage inspection.
										</p>
									</div>

									<div class="mb-2">
									<button class="financeAcceptAggriment brn btn-secondary rounded-pill py-1 px-3 font-10 mr-2">
									Accept agreement
									</button>
									<button class="financeCancelAggriment brn btn-secondary rounded-pill py-1 px-3 font-10">
									Cancel agreement
									</button>
									</div>

									<div class="mb-2 text-left">
									<strong class="font-8 text-secondary">By entering into this agreement, the vehicle may not be driven more than 250 km, or any other distance mutually agreed upon with the buyer prior to transport. </strong>
									</div>

									</div>
									<div class="d-none d-md-block position-absolute" style="max-width:100px; right:20px; top: 50%; transition: transform translate(-50%, 0);">
										<?php echo $CORE->LAYOUT("get_logo", "light"); ?>
									</div>

								</div>
	</div>
`;



								jQuery(".documentManagementBody .documentViewSection").html(displayData);
								jQuery('.documentManagementBody').removeClass('d-none').addClass('d-flex');

							}



							$(document).on('click', '.financeAcceptAggriment', function () {

								jQuery('.documentManagementBody').removeClass('d-flex').addClass('d-none');
								jQuery('.financeViewAggriment').removeClass('disabled');
								financeProgressVerification(2, 'Application', 'Accepted');
							});
							$(document).on('click', '.financeCancelAggriment', function () {

								jQuery('.documentManagementBody').removeClass('d-flex').addClass('d-none');
								financeProgressVerification(1, 'Application', 'Cancel');
							});

							$(document).on('click', '#submitApprovalInfo', function () {
								var entryId = parseInt($('#finance_entry_id').val());

								var selectedPackages = [];

								$('.packages-card').each(function (index, item) {
									// Check if the current package has the 'selected' class
									if ($(item).hasClass('selected')) {
										var packageName = $(item).find('.card-title').text()
											.trim(); // Get the package name
										var packagePrice = $(item).find('.price span').text()
											.trim(); // Get the package price
										// Push the package info as an object into the array
										selectedPackages.push({
											id: index + 1,
											packageName: packageName,
											packagePrice: packagePrice
										});
									}
								});


								var approvalAmount = $('#approvedAmounts').val();
								var lender = $('#buyerLender').val();
								var lenderType = $('#buyerLenderType').val();
								var paymentFrequency = $('#buyerPaymentFrequency').val();


								var approvalInterest = $('.approvalInterestCard').text();
								var paymentTerm = $('.approvalMonthTermCard').text();

								var approvedMonthlyAmount = $('.approvalAmountCard').text();



								var formData = new FormData();
								formData.append('action', 'add_additional_deal_info');
								formData.append('form_id', '<?php echo $finance_form_id; ?>');
								formData.append('entry_id', entryId);
								formData.append("data_meta", "applicant_information");
								formData.append('form_name', 'Buyer Approval');
								formData.append('form_title', 'Buyer Approval');
								formData.append('userId', '<?php echo $userdata->ID; ?>');


								// Add the other form data to the form data
								formData.append('buyerApprovedAmount', approvalAmount);
								formData.append('approvedMonthlyAmount', approvedMonthlyAmount);

								formData.append('buyerApprovedLender', lender);
								formData.append('buyerApprovedLenderType', lenderType);
								formData.append('buyerApprovedPaymentFrequency', paymentFrequency);

								// Check and append selected packages' info to formData
								if ($('.packages-card.aftermarketWarranty').hasClass('selected')) {
									var warrantyTitle = $('.packages-card.aftermarketWarranty').find('.price span').text()
										.trim();
									formData.append('buyerApprovedWarrantyCost', warrantyTitle);
								} else {
									formData.append('buyerApprovedWarrantyCost', ''); // append empty value if not selected
								}

								if ($('.packages-card.gAPInsurance').hasClass('selected')) {
									var gapInsuranceTitle = $('.packages-card.gAPInsurance').find('.price span').text().trim();
									formData.append('buyerApprovedGAPInsurance', gapInsuranceTitle);
								} else {
									formData.append('buyerApprovedGAPInsurance', ''); // append empty value if not selected
								}

								if ($('.packages-card.lifeInsurance').hasClass('selected')) {
									var lifeInsuranceTitle = $('.packages-card.lifeInsurance').find('.price span').text()
										.trim();
									formData.append('buyerApprovedLifeInsurance', lifeInsuranceTitle);
								} else {
									formData.append('buyerApprovedLifeInsurance', ''); // append empty value if not selected
								}

								if ($('.packages-card.turbobidTransport').hasClass('selected')) {
									var turbobidTransportTitle = $('.packages-card.turbobidTransport').find('.price span')
										.text().trim();
									formData.append('buyerApprovedTurbobidTransport', turbobidTransportTitle);
								} else {
									formData.append('buyerApprovedTurbobidTransport', ''); // append empty value if not selected
								}

								// Send AJAX request to save the data
								addAdditionalDealData(formData)
									.done(function (res) {
										jQuery('#loadingSpinner').hide();

										// Handle the response from the AJAX call
										if (res.success) {
											// alert('Submited the fund deal.');
											if (financingCurrentStep < financingTotalSteps) {
												financingCurrentStep++;
											}
											updateUserFinanceEntryCurrentStep();

											$('.financeDetails').find('.paymentWithTerm').text(
												`${approvedMonthlyAmount || 0} ${paymentFrequency}`);

											$('.financeDetails').find('.lenderName').text(lender);
											$('.financeDetails').find('.interestRate').text(approvalInterest);

											$('.financeDetails').find('.paymentWithTerm').text(formatCalCadPrice(
												approvalAmount) + ' ' + paymentFrequency);

											$('.financeDetails').find('.approvedFinanceAmount').text(
												`CA ${formatCalCadPrice(approvalAmount)}`);

											$('.financeDetails').find('.lenderType').text(lenderType);

											$('.financeDetails').find('.termLength').text(paymentTerm);

											$('.financeDetails').find('.paymentType').text(paymentFrequency);


										} else {
											alert('Error: Could not submit the info.');
										}
									})
									.fail(function (error) {
										jQuery('#loadingSpinner').hide();
										console.error("Error:", error);
									});






								// Output the selected packages to the console
								console.log("Selected Packages:", selectedPackages);
							});


							$(document).on('click', '.submitSellerSuggestedTime', function () {
								var entryId = parseInt($('#finance_entry_id').val());

								// Collect all selected date-time slots
								var selectedTimes = [];
								if ($("#vehiclePickupDate").val()) {
									selectedTimes.push({ date: $("#vehiclePickupDate").val(), time: $(".time").text() });
								}

								$('.timeSlotCheckbox:checked').each(function () {
									var date = $(this).siblings('.slotDate').text().trim();
									var time = $(this).siblings('.slotTime').text().trim();
									selectedTimes.push({ date: date, time: time });
								});



								if (selectedTimes.length === 0) {
									alert("Please select at least one time slot.");
									return;
								}

								var formData = new FormData();
								formData.append('action', 'add_additional_deal_info');
								formData.append('form_id', '<?php echo $finance_form_id; ?>');
								formData.append('entry_id', entryId);
								formData.append("data_meta", "applicant_information");
								formData.append('form_name', 'Seller suggested Pick-up dates');
								formData.append('form_title', 'Seller suggested Pick-up dates');
								formData.append('userId', '<?php echo $userdata->ID; ?>');

								// Convert array to JSON and append to form data
								formData.append('sellerSuggestedTimes', JSON.stringify(selectedTimes));

								// Send AJAX request to save the data
								addAdditionalDealData(formData)
									.done(function (res) {
										$('#loadingSpinner').hide();
										$('.newUserAddModalBody').removeClass('d-flex').addClass('d-none');

										// Handle the response from the AJAX call
										if (res.success) {
											alert('Submitted time slots successfully');
										} else {
											alert('Error: Could not submit the time slots.');
										}
									})
									.fail(function (error) {
										$('#loadingSpinner').hide();
										console.error("Error:", error);
									});
							});







							jQuery(document).on('click', '#dealSignaturePaperWorkDetails', function () {
								var dealId = parseInt($('#finance_entry_id').val());
								var storedDocuments = JSON.parse(sessionStorage.getItem('@client-deal-documents' + dealId));

								console.log('storedDocuments', storedDocuments);

								// Predefined documents from your HTML
								var predefinedDocuments = [{
									id: 1,
									name: "Finance Agreement"
								},
								{
									id: 2,
									name: "Bank Paperwork"
								},
								{
									id: 3,
									name: "Escrow Agreement"
								},
								{
									id: 4,
									name: "Warranty Paperwork"
								},
								{
									id: 5,
									name: "GAAP Insurance"
								},
								{
									id: 6,
									name: "Life Insurance"
								}
								];

								jQuery('.documentManagementBody .sendDocumentSection').removeClass('d-block').addClass(
									'd-none');
								jQuery('.documentManagementBody .documentViewSection').removeClass('d-none').addClass(
									'd-block');
								jQuery('.documentManagementBody #documentManageTitle').hide();
								jQuery('.documentManagementBody .documentManagementContainer').removeClass(
									'p-3 customModalWidthHalf').addClass(
										'p-0 border-0 customModalWidthFull');

								// HTML template for the documents
								let clientDealDocumentFile = `
		<div class="bg-secondary px-1 px-md-4 py-4 text-center text-white"><h5>Paperwork</h5></div>
		<div class="px-1 px-md-3 py-3 bg-white">
			<div class="mb-3 px-5">
				<div class="paper-works-documents col-md-12" id="paperwork-documents-container">`;


								// Iterate over predefined documents and match with storedDocuments
								predefinedDocuments.forEach(function (predefinedDoc) {
									// Check if any document from the session matches the current predefined document
									var matchingDocument = storedDocuments.find(function (storedDoc) {
										// Check if storedDoc is an array and get the last element, else use storedDoc directly
										var document = Array.isArray(storedDoc) && storedDoc.length > 0 ?
											storedDoc[storedDoc.length - 1] : storedDoc;

										// Compare doc_id and doc_name between document and predefinedDoc
										return document.doc_id == predefinedDoc.id && document.doc_name ===
											predefinedDoc.name && document.templateId;

									});

									console.log('matchingDocument', matchingDocument);



									if (matchingDocument) {
										clientDealDocumentFile += `
				<div class="paperwork-document col-12 d-flex" data-upload-name="${predefinedDoc.name}" data-document-id="${predefinedDoc.id}">
					<div class="d-flex col-6">
						<img style="max-width:35px; max-height:35px;" src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg" alt="PDF FILE" />
						<div class="d-flex flex-column pl-2">
							<span class="doc-name text-dark">${predefinedDoc.name}</span>
							<span class="small pt-1 doc-date" style="color:#909090">${matchingDocument.createdAt || ''}</span>
						</div>
					</div>
					<div class="col-6 d-flex justify-content-end align-items-center">
						<a class="paperwork-item signature btn font-8 rounded-pill" style="background:#F7D9D3; color:#F24822; width:120px;" href="javascript:void(0)" >
							<i class="fal fa-file-signature"></i> Signature
						</a>
					</div>
				</div>
			`;
									} else {
										clientDealDocumentFile += `
				<div class="paperwork-document col-12 d-flex" data-upload-name="${predefinedDoc.name}" data-document-id="${predefinedDoc.id}">
					<div class="d-flex col-6">
						<img style="max-width:35px; max-height:35px;" src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg" alt="PDF FILE" />
						<div class="d-flex flex-column pl-2">
							<span class="doc-name text-dark">${predefinedDoc.name}</span>
							<span class="small pt-1 doc-date" style="color:#909090">No signature request found</span>
						</div>
					</div>
					<div class="col-6 d-flex justify-content-end align-items-center">
						 <a class="paperwork-item btn font-8 rounded-pill" style="background:#f7e9d9; color:#F24822; width:120px;" href="javascript:void(0)" >
							<i class="fal fa-file-signature"></i> Pending
						</a>
					</div>
				</div>
			`;
									}
								});

								clientDealDocumentFile += ` </div>
				<div class="form-group col-12 col-md-12 d-flex justify-content-center align-items-center">
				  
				</div>
			</div>
		</div>
	`;

								// Render the main container
								jQuery(".documentManagementBody .documentViewSection").html(clientDealDocumentFile);
								// Open the modal
								jQuery('.documentManagementBody').removeClass('d-none').addClass('d-flex');

								// Get the paperwork documents container


							});


							setInterval(() => {
								get_finance_entry();
							}, 180000); // 180,000 milliseconds = 3 minutes

							get_finance_entry();

							function get_finance_entry() {
								console.log("Getting");

								jQuery.ajax({
									url: '<?php echo admin_url('admin-ajax.php'); ?>',
									type: 'POST',
									data: {
										action: 'get_finance_entry',
									},
									success: function (response) {
										console.log("Finance", response);

										if (response.success) {
											var entry = response.data;
											var meta = entry.meta;

											$('.financing-entry-title').text(meta['select-1'] + " " + meta['text-14'] +
												" " + meta['select-2']);
											$('.financing-entry-id').text(entry.entry_id);
											$('#finance_entry_id').val(entry.entry_id);

											sessionStorage.setItem('@deal-entry-id', entry.entry_id);
											sessionStorage.setItem('@deal-data' + entry.entry_id, JSON.stringify(meta));
											sessionStorage.setItem('@client-deal-documents' + entry.entry_id, JSON
												.stringify(entry.deal_document));

											<?php if ($isBuyerFinance) { ?>
												console.log("Seller step: ", stepX);
												sessionStorage.setItem('@deal-client-email', meta['email-1']);
												var stepX = entry.entry_current_step;
												if (stepX != 0) {
													dealerApprovalTermForClient(stepX, entry.finance_step_status, meta)
												} else {
													dealerApprovalTermForClient(1, entry.finance_step_status, meta)
												}

												if (entry.finance_step_status) {

												}

												fetchUserVeriffStatus('<?php echo $user_email; ?>', function (error, veriffDecision) {


													userVeriffDecision(veriffDecision);


												});

											<?php } else if ($isSellerFinance) { ?>
													sessionStorage.setItem('@deal-client-email', meta['email-2']);

													var stepX = entry.seller_entry_current_step;
													console.log("Seller step: ", stepX);

													// if (entry.finance_step_status) {
													// 	dealerApprovalTermForClient(stepX, entry.finance_step_status, meta)
													// }
													if (stepX != 0) {
														dealerApprovalTermForClient(stepX, entry.finance_step_status, meta)
													} else {
														dealerApprovalTermForClient(1, entry.finance_step_status, meta)
													}

													fetchUserVeriffStatus('<?php echo $user_email; ?>', function (error, veriffDecision) {
														userVeriffDecision(veriffDecision);

													});

											<?php } ?>

											jQuery('.vehicleVinNumber').text(meta['text-13'] || '');
											jQuery('.vehiclePurchasePrice').text(formatCalCadPrice(meta['currency-2'] ||
												0));


											jQuery('#nameRegisteredOwner').val(meta['nameOfRegisteredOwner'] || '');
											jQuery('.suggestedPrice').val(meta['suggestedPrice'] || '');
											setRadioValue('#isRegisteredOwner', meta['isRegisteredOwner'] || '');
											setRadioValue('#isAnyLiensVehicle', meta['isAnyLiensVehicle'] || '');

											jQuery('#isVehicleBeingPicked').val(meta['isVehicleBeingPicked'] || '');
											jQuery('#requestedPickupDate').val(meta['sellerPickupDate'] || '');
											jQuery('#locationOfVehicle').val(meta['locationOfVehicle'] || '');
											setRadioValue('#confirmVehiclePurchase', meta['confirmVehiclePurchase'] || '');

											jQuery('#vehiclePickupDate').val(meta['sellerPickupDate'] || '');
											// jQuery('#sellerPickUpAddress').val(meta['sellerPickupAddress'] || '');
											// jQuery('#dropoffDetails').val(meta['dropoffDetails'] || '');



											updateRowStatus(entry.deal_document);

											var paymentMethod = meta['sellerPayoutMethod'] || '';

											console.log('Payment: ', paymentMethod);

											if (paymentMethod === 'Wire Transfer') {
												jQuery('#selectPayoutMethod input[type="radio"][value="Wire Transfer"]')
													.prop('checked', true);
											} else if (paymentMethod === 'Hyperwallet Payment (Faster)') {
												jQuery(
													'#selectPayoutMethod input[type="radio"][value="Hyperwallet Payment (Faster)"]'
												)
													.prop('checked', true);
											}



											// Example usage
											const dateCreated = entry
												.date_created; // Make sure this is a valid date string
											$('.financing-entry-submit-date').html(formatDate(dateCreated));



											var applicationDtails = `

							<h5>Item details</h5>
							<strong class="mb-2">${meta['select-1']} ${meta['text-14']} ${meta['select-2']}</strong>

							
							
							<div class="d-flex justify-content-between text-dark mb-2"><span>VIN:
									${meta['text-13']}</span></div>
									
							
							<div class="d-flex justify-content-between text-dark"><strong>Application Amount ( CAD )</strong> <strong>${formatCalCadPrice(meta['currency-2'])}</strong></div>
							`;
											$('.financing-item-details').html(applicationDtails);

											var transactionSummary = `

							<h5>Transaction Summary</h5>
							<strong class="mb-2">${meta['select-1']} ${meta['text-14']} ${meta['select-2']}</strong>
							<span class="my-2">${meta['select-1']} ${meta['text-14']} ${meta['select-2']} </span>

							
							
							<div class="d-flex justify-content-between text-dark mb-2"><span>VIN:
									${meta['text-13']}</span></div>
									
							
							<div class="d-flex justify-content-between text-dark"><strong>Application Amount ( CAD )</strong> <strong>${formatCalCadPrice(meta['currency-2'])}</strong></div>
							`;
											$('.financingTransactionSummary').html(transactionSummary);


											if (entry.finance_step_status) {
												// financeStatusBasedUpdateInfo(entry.finance_step_status.step, entry
												//     .finance_step_status
												//     .status);
											}



											jQuery("#finance_pickup_id").val('pickup-' + entry.entry_id);
											jQuery("#finance_entry_vehicle_name").val(
												`${meta['select-1']}  ${meta['text-14']} ${meta['select-2']}`);
											jQuery("#finance_entry_vehicle_vin").val(meta['text-13']);




											financePickupSessionResponse(entry.finance_pickup_info);

											fetchFinanceDocumentFiles('1', 'Vehicle Ownership');

											/*   
												 var html ='<ul>';
 
												 $.each(meta, function(key, value) {
													html += '<li><strong>' + key + ':</strong> ' + value + '</li>';
												  });
 
												  html += '</ul>'; 
 
												  $('.turbobidfinancing-data').html(html); */

										} else {
											updateFinancingSteps(0);
											// $('.turbobidfinancing-data').html('<p>Error fetching entry details.</p>');
										}
									},
									error: function () {
										updateFinancingSteps(0);
										// $('.turbobidfinancing-data').html('<p>Error fetching entry details.</p>');
									}
								});
							}







							function fetchFinanceDocumentFiles(documentId, documentName) {
								jQuery('#loadingSpinner').show();
								var entryId = parseInt(jQuery('#finance_entry_id').val());
								var formData = new FormData();
								formData.append("action", "get_documents_from_server");
								formData.append("form_id", 337873); // Replace with your form ID
								formData.append("entry_id", entryId);
								formData.append('documentId', documentId);
								formData.append('documentName', documentName);
								addAdditionalDealData(formData)
									.done(function (res) {
										jQuery('#loadingSpinner').hide();
										// Handle the response from the AJAX call
										if (res.success) {
											// alert('Successfully get Document');
											console.log('Document: ', res);
											let proofFiles;
											res.data.forEach(function (doc) {

												doc.doc_files.forEach(function (fileUrl) {

													if (fileUrl.endsWith('.pdf')) {
														proofFiles += '<a class="col-12 col-md-6" href="' +
															fileUrl +
															'" target="_blank">View PDF file</a><br>';
														proofFiles += '<pdf-viewer src="' + fileUrl +
															'"></pdf-viewer><br>';
													} else if (fileUrl.endsWith('.jpg') || fileUrl.endsWith(
														'.jpeg') || fileUrl.endsWith(
															'.png') || fileUrl.endsWith('.svg')) {
														proofFiles += '<a class="col-12 col-md-6" href="' +
															fileUrl +
															'" target="_blank"><img style="width:100%; height:100%; padding:10px; border-radius:10px;" src="' +
															fileUrl + '" /></a><br>';
													} else {
														proofFiles +=
															'<a class="btn btn-primary rounded-pill" href="' +
															fileUrl +
															'" target="_blank">View File</a><br>';
													}
												});

											});

											jQuery('#sellerDocumentProofPreviewContainer').html(proofFiles);

										}
									})
									.fail(function (error) {
										alert('Error finding deal documents', error)
										console.error("Error:", error);
									});
							}



							function updateRowStatus(documents) {


								// Check if it's a string that needs to be parsed into JSON
								if (typeof documents === 'string') {
									try {
										documents = JSON.parse(documents);
									} catch (e) {
										console.error('Failed to parse documents:', e);
										return; // Exit the function if JSON parsing fails
									}
								}

								// Check if 'documents' is an array
								if (Array.isArray(documents)) {
									documents.forEach(function (document) {
										// Iterate over each table row in the client document section
										jQuery('#client-document tr').each(function () {
											var row = jQuery(this);
											var documentId = row.data('document-id');
											var uploadName = row.data('upload-name');

											// Match document by ID and name
											if (document.doc_id == documentId && document.doc_name === uploadName &&
												document.templateId) {
												row.show();
												// If document is completed, update the status cell
												if (document.document_is_complete === 'completed') {
													row.find('.doc-row-status').html(
														`<span class="badge font-8 px-2 py-2 rounded-pill" style="background:#F7D9D3; color:#F24822; width:120px;"><i class="fas fa-circle small mr-2"></i>
															Signature Requested</span>`
													);
													row.find('.doc-date').html(
														`<span class="badge font-8">${formatDate(document.createdAt)}</span>`
													);
													row.find('.view-paperwork-doc').removeClass('disabled');
												} else {
													row.find('.doc-row-status').html(
														`<span class="badge font-8 px-2 py-2 rounded-pill" style="background:#F7D9D3; color:#F24822; width:120px;"><i class="fas fa-circle small mr-2"></i>Pending
															Signature</span>`
													);

													row.find('.doc-date').html(
														`<span class="badge font-8">###</span>`
													);

													row.find('.dropdown-item.view-paperwork-doc').addClass('disabled');
												}
											}
										});
									});
								} else {
									// console.log('Documents is not an array:', documents);
									jQuery('tr').each(function () {
										var row = jQuery(this);
										var documentId = row.data('document-id');
										var uploadName = row.data('upload-name');

										// Match document by ID and name
										if (documentId && uploadName) {
											row.find('.doc-row-status').html(
												'<span class="turbo-warning font-10 px-2 py-1 rounded-pill"><i class="fas fa-circle small mr-2"></i>Uncompleted</span>'
											);
										}
									});

								}
							}



							function formatCalCadPrice(value) {
								let number = parseFloat(value);
								if (isNaN(number)) return value;
								return '$' + number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
							}


							function setRadioValue(selector, value) {
								if (value === 'Yes') {
									jQuery(selector + ' input[type="radio"][value="Yes"]').prop('checked', true);
								} else if (value === 'No') {
									jQuery(selector + ' input[type="radio"][value="No"]').prop('checked', true);
								}
							}






							function updateUserFinanceEntryCurrentStep() {
								var currentStep = financingCurrentStep;
								var entryId = parseInt($('#finance_entry_id').val());
								console.log('Next Submitted', currentStep);

								$.ajax({
									url: '<?php echo admin_url('admin-ajax.php'); ?>',
									type: 'POST',
									data: {
										action: 'update_entry_step',
										current_step: financingCurrentStep,
										form_id: 337873,
										entry_id: entryId,
										step_meta: <?php if ($isBuyerFinance) { ?> 'entry_current_step'
																																																																						<?php } else if ($isSellerFinance) { ?> 'seller_entry_current_step'
																																																																						<?php } ?>
									},
									success: function (response) {
										// console.log(response);
										if (response.success) {
											updateFinancingSteps(currentStep);
										} else {
											alert('Failed to update step.');
										}
									},
									error: function () {
										alert('An error occurred.');
									}
								});
							}



							jQuery(document).on('click', '.SellerDetailsToNext', function () {
								jQuery('#loadingSpinner').show();

								// Get the entryId from session storage
								var entryId = parseInt(jQuery('#finance_entry_id').val());


								var ghjds = jQuery('#nameRegisteredOwner').val();


								var iuyfgyuid = jQuery('#isRegisteredOwner input[type="radio"]:checked').val();
								var dyudsksds = jQuery('#isAnyLiensVehicle input[type="radio"]:checked').val();

								var yujkjjhgdj = jQuery('#isVehicleBeingPicked').val();
								var suggestedPrice = jQuery('.suggestedPrice').val();

								var wfdjsh = jQuery('#requestedPickupDate').val();
								var locationOfVehicle = jQuery('#locationOfVehicle').val();
								var xweidwxx = jQuery('#confirmVehiclePurchase input[type="radio"]:checked').val();

								if (entryId && wfdjsh && ghjds && wfdjsh && xweidwxx && locationOfVehicle && iuyfgyuid) {

									// Prepare FormData object
									var formData = new FormData();
									formData.append('action', 'add_additional_deal_info');
									formData.append('form_id', <?php echo $finance_form_id; ?>);
									formData.append('entry_id', entryId);
									formData.append("data_meta", "applicant_information");
									formData.append('form_name', 'Seller Details');
									formData.append('form_title', 'Seller Details Updated');
									formData.append('userId', <?php echo $userdata->ID; ?>);



									// Collect values from the sellerInformationPayout section

									formData.append('nameOfRegisteredOwner', ghjds);
									formData.append('isRegisteredOwner', iuyfgyuid);
									formData.append('isAnyLiensVehicle', dyudsksds);
									formData.append('isVehicleBeingPicked', yujkjjhgdj);
									formData.append('sellerPickupDate', wfdjsh);
									formData.append('confirmVehiclePurchase', xweidwxx);
									formData.append('locationOfVehicle', locationOfVehicle);
									formData.append('suggestedPrice', suggestedPrice);



									// Send AJAX request to save the data
									addAdditionalDealData(formData)
										.done(function (res) {
											jQuery('#loadingSpinner').hide();

											// Handle the response from the AJAX call
											if (res.success) {

												// alert('Submited the fund deal.');
												if (financingCurrentStep < financingTotalSteps) {
													financingCurrentStep++;
												}
												updateUserFinanceEntryCurrentStep();


											} else {
												alert('Error: Could not submit the fund deal.');
											}
										})
										.fail(function (error) {
											jQuery('#loadingSpinner').hide();
											console.error("Error:", error);
										});

								} else {
									alert('All fields are required. Please fill the fields then click on next button');
								}
							});





							jQuery(document).on('change', '#sellerDocumentProofFileInput', function () {

								var entryId = parseInt(jQuery('#finance_entry_id').val());
								var sellerDocumentProofFileInput = jQuery('#sellerDocumentProofFileInput')[0];
								var documentProofFile = sellerDocumentProofFileInput.files[0];

								jQuery('#loadingSpinner').show();

								var documentId = '1';
								var documentName = 'Vehicle Ownership';

								if (documentProofFile) {
									var formData = new FormData();
									formData.append("action", "submit_document_deal");
									formData.append("form_id", 337873); // Replace with your form ID
									formData.append("entry_id", entryId); // Replace with your entry ID
									formData.append("data_meta", "deal_client_document");
									formData.append('form_name', 'Vehicle Ownership');
									formData.append('form_title', 'Vehicle Ownership Document');
									formData.append('documentId', documentId);
									formData.append('documentName', documentName);

									if (documentProofFile) {
										formData.append('images[]', documentProofFile, documentProofFile
											.name); // Append the file if it exists
									}

									addAdditionalDealData(formData)
										.done(function (res) {
											jQuery('#loadingSpinner').hide();
											// Handle the response from the AJAX call
											if (res.success) {
												console.log(res.message);
												alert('Successfully Uploaded Vehicle Ownership')
											} else {
												alert('Error for submitting the Vehicle Ownership')
											}
										})
										.fail(function (error) {
											alert('Error Vehicle Ownership', error)
											console.error("Error:", error);
										});

								} else {
									alert("Please select files to upload.");
								}
							});


							jQuery(document).on('click', '.SellerNextBtn', function () {
								jQuery('#loadingSpinner').show();

								// Get the entryId from session storage
								var entryId = parseInt(jQuery('#finance_entry_id').val());
								var sellerDocumentProofFileInput = jQuery('#sellerDocumentProofFileInput')[0];
								var file = sellerDocumentProofFileInput.files[0];

								// Prepare FormData object
								var formData = new FormData();
								formData.append('action', 'add_additional_deal_info');
								formData.append('form_id', <?php echo $finance_form_id; ?>);
								formData.append('entry_id', entryId);
								formData.append("data_meta", "applicant_information");
								formData.append('form_name', 'Vehicle Pickup Details');
								formData.append('form_title', 'Vehicle Pickup Details');
								formData.append('userId', <?php echo $userdata->ID; ?>);



								// Collect values from the sellerInformationPayout section

								formData.append('sellerPickupAddress', jQuery('#sellerPickUpAddress').val());
								formData.append('sellerPickupDate', jQuery('#vehiclePickupDate').val());
								formData.append('dropoffDetails', jQuery('#dropoffDetails').val());



								// Send AJAX request to save the data
								addAdditionalDealData(formData)
									.done(function (res) {
										jQuery('#loadingSpinner').hide();

										// Handle the response from the AJAX call
										if (res.success) {

											// alert('Submited the fund deal.');
											if (financingCurrentStep < financingTotalSteps) {
												financingCurrentStep++;
											}
											updateUserFinanceEntryCurrentStep();


										} else {
											alert('Error: Could not submit the fund deal.');
										}
									})
									.fail(function (error) {
										jQuery('#loadingSpinner').hide();
										console.error("Error:", error);
									});
							});





							jQuery(document).on('click', '.submitPayoutMethodDocument', function () {
								jQuery('#loadingSpinner').show();

								// Get the entryId from session storage
								var entryId = parseInt(jQuery('#finance_entry_id').val());

								// Prepare FormData object
								var formData = new FormData();
								formData.append('action', 'add_additional_deal_info');
								formData.append('form_id', <?php echo $finance_form_id; ?>);
								formData.append('entry_id', entryId);
								formData.append("data_meta", "applicant_information");
								formData.append('form_name', 'Disbursement By Wire/Bank Transfer');
								formData.append('form_title', 'Disbursement By Wire/Bank Transfer FormSubmitted  by seller');
								formData.append('userId', <?php echo $userdata->ID; ?>);

								formData.append('sellerPayoutMethod', jQuery('#selectPayoutMethod input[type="radio"]:checked')
									.val());

								// Collect input values
								var section = jQuery('.documentViewSection');
								formData.append('wireTransferAddress', section.find('#wireTransferAddress').val());
								formData.append('wireTransferCity', section.find('#wireTransferCity').val());
								formData.append('wireTransferProvince', section.find('#wireTransferProvince').val());
								formData.append('wireTransferCityPostalCode', section.find('#wireTransferCityPostalCode')
									.val());

								formData.append('fundFirstName', section.find('#hyperWalletFirstName').val());
								formData.append('fundLastName', section.find('#hyperWalletLastName').val());
								formData.append('hyperWalletPhoneNumber', section.find('#hyperWalletPhoneNumber').val());
								formData.append('hyperWalletEmail', section.find('#hyperWalletEmail').val());


								// Collect values from the sellerInformationPayout section
								var sellerSection = jQuery('.documentViewSection');


								formData.append('institutionName', sellerSection.find('#institutionName').val());
								formData.append('institutionAddress', sellerSection.find('#institutionAddress').val());
								formData.append('institutionNumber', sellerSection.find('#institutionNumber').val());
								formData.append('transitNumber', sellerSection.find('#transitNumber').val());
								formData.append('accountName', sellerSection.find('#accountName').val());
								formData.append('accountNumber', sellerSection.find('#accountNumber').val());



								// Send AJAX request to save the data
								addAdditionalDealData(formData)
									.done(function (res) {
										jQuery('#loadingSpinner').hide();

										// Handle the response from the AJAX call
										if (res.success) {

											alert('Submitted payout method info.');

											jQuery('.documentManagementBody').removeClass('d-flex').addClass('d-none');
											// var meta = res.data;

										} else {
											alert('Error: Could not submit payout method info.');
										}
									})
									.fail(function (error) {
										jQuery('#loadingSpinner').hide();
										console.error("Error:", error);
									});
							});






						});






						function financeStatusBasedUpdateInfo(step, status) {
							if (status === 'Approved') {
								// Loop through the steps from 1 to the current step
								for (let i = 1; i <= step; i++) {
									jQuery('#finance-' + i + '-verified').removeClass('finance-warning').addClass('finance-accepted').text(
										'Approved').prop('disabled',
											true);
									jQuery('#finance-' + i + '-unverified').removeClass('finance-accepted').addClass('finance-warning')
										.text(
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
									jQuery('.financeApplicationDecision').text('Decision: Approved');
								}



							}

							if (status === "Unapproved") {
								for (let i = 1; i <= step; i++) {
									jQuery('#finance-' + i + '-unverified').removeClass('finance-warning').addClass('finance-accepted')
										.text(
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
									jQuery('.financeApplicationDecision').text('Decision:Canceled');
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

							var entryId = parseInt(jQuery('#finance_entry_id').val());
							var vehicle_name = jQuery('#finance_entry_vehicle_name').val();
							var vehicle_vin = jQuery('#finance_entry_vehicle_vin').val();

							var formData = new FormData();
							formData.append("action", "add_additional_escrow_info");
							formData.append("form_id", 337873); // Replace with your form ID
							formData.append("entry_id", entryId); // Replace with your entry ID
							formData.append("data_meta", "finance_step_status");
							formData.append('form_name', 'Finance Step Status');
							formData.append('form_title', 'Finance ' + stepName + ' Status ' + status + ' for ' + vehicle_name);

							formData.append('finance_buyer_email', getFinanceEmail);

							formData.append('vehicle_name', vehicle_name);
							formData.append('vehicle_vin', vehicle_vin);
							formData.append("additional_info", JSON.stringify(storedData));

							// Call the function and handle the response
							addAdditionalEntryData(formData)
								.done(function (res) {
									jQuery('#loadingSpinner').hide();
									// Handle the response from the AJAX call
									if (res.success) {
										console.log('statusValue', res.data);
										// Dynamically access the response data based on the type
										var statusKey = 'finance_step_status';
										if (res.data[statusKey] !== "") {
											var statusValue = res.data[statusKey]['status'];
											// Update the button color based on the status
											if (statusValue === 'Completed') {
												jQuery('#confirmSellerFinanceComplete').text('Completed');
												financeStatusBasedUpdateInfo(step, statusValue);
											}


										}
									} else {
										alert("Error updating status: " + res.data);
									}
								})
								.fail(function (error) {
									console.error("Error:", error);
									alert("Error updating status.");
								});
						}
					</script>


					<script src="https://cdn.veriff.me/sdk/js/1.5/veriff.min.js"></script>
					<script src="https://cdn.veriff.me/incontext/js/v1/veriff.js"></script>

					<script>
						var userId = "<?php echo $userdata->ID; ?>";
						var userFirstName = "<?php echo $userdata->first_name; ?>";
						var userLastName = "<?php echo $userdata->last_name; ?>";
						var apiKey = '9d91ff0b-0d5e-4d33-ba79-831a0e76191e'; // Replace with your actual API key
						var sharedSecretKey = 'a6a04a00-6327-4e62-8574-e85578831ffd';

						const financeVeriff = Veriff({
							host: 'https://stationapi.veriff.com',
							apiKey: apiKey,
							parentId: 'finance-veriff-root',
							onSession: function (err, response) {
								if (err) {
									console.error('Error starting verification session:', err);
									return;
								}

								//console.log('Veriff session started:', response);

								// Store the session URL and ID
								sessionStorage.setItem('@veriff-session-url', response.verification.url);
								sessionStorage.setItem('@veriff-session-id', response.verification.id);

								window.veriffSDK.createVeriffFrame({
									url: response.verification.url,
									onReload: () => {
										window.location.reload();
									},
									onEvent: function (event) {
										// console.log('Veriff event:', event);
										if (event === 'FINISHED') {

											// When verification is finished, fetch the decision
											const sessionId = sessionStorage.getItem('@veriff-session-id');
											if (sessionId) {
												fetchFinanceVeriffDecision(sessionId);
											}
										}
									}
								});
							}
						});

						// Set parameters before mounting
						financeVeriff.setParams({
							person: {
								givenName: userFirstName,
								lastName: userLastName
							},
							vendorData: userId
						});

						// Trigger the verification process on button click




						function financeVeriffMountAdd() {
							financeVeriff.mount({
								submitBtnText: 'Get verified'
							});
						}




						function userVeriffDecision(veriffDecision) {
							console.log('Verification', veriffDecision);
							if (veriffDecision && veriffDecision?.status === "success") {
								jQuery('.financeKYCDecision').html(
									'<span class="text-primary">Decision:</span><span class="text-secondary">Approved</span>');

								jQuery('#finance-verification-next').html(
									'<button class="btn btn-secondary rounded-pill px-5 financing-buyer-next">Next</button>'
								);
							} else {
								financeVeriffMountAdd();
							}
						}



						function fetchUserVeriffStatus(userEmail, callback) {
							jQuery.ajax({
								url: '<?php echo admin_url("admin-ajax.php"); ?>',
								method: 'POST',
								data: {
									action: 'get_user_meta_by_email',
									user_email: userEmail
								},
								success: function (response) {
									if (response.success) {
										if (response.data.veriff_decision) {
											callback(null, response.data.veriff_decision);

										} else {
											callback(response.data, null);
										}
									} else {
										callback(response.data, null);
									}
								},
								error: function (error) {
									callback(error, null);
								}
							});
						}


						// Function to calculate HMAC signature
						async function financeCalculateHMACSignature(sessionId, sharedSecretKey) {
							const encoder = new TextEncoder();
							const key = await crypto.subtle.importKey(
								'raw',
								encoder.encode(sharedSecretKey), {
								name: 'HMAC',
								hash: 'SHA-256'
							},
								false,
								['sign']
							);

							const signature = await crypto.subtle.sign(
								'HMAC',
								key,
								encoder.encode(sessionId)
							);

							return Array.from(new Uint8Array(signature))
								.map(b => b.toString(16).padStart(2, '0'))
								.join('');
						}

						// Function to fetch the decision
						async function fetchFinanceVeriffDecision(sessionId) {
							const hmacSignature = await financeCalculateHMACSignature(sessionId, sharedSecretKey);

							fetch(`https://stationapi.veriff.com/v1/sessions/${sessionId}/decision`, {
								method: 'GET',
								headers: {
									'X-AUTH-CLIENT': apiKey,
									'X-HMAC-SIGNATURE': hmacSignature,
									'Content-Type': 'application/json'
								}
							})
								.then(response => response.json())
								.then(data => {
									// console.log('Verification decision:', data);
									if (data.status === 'success') {
										veriffFinanceStatusUpdate(data);
									}
								})
								.catch(error => {
									console.error('Error fetching decision:', error);
								});
						}


						const sessionIdf = sessionStorage.getItem('@veriff-session-id');
						if (sessionIdf) {
							fetchFinanceVeriffDecision(sessionIdn);
						}


						function veriffFinanceStatusUpdate(decision) {
							jQuery.ajax({
								url: '<?php echo admin_url('admin-ajax.php'); ?>',
								type: 'POST',
								dataType: 'json', // Assuming the response will be JSON
								data: {
									action: 'handle_verification',
									decision: decision,
									user_id: <?php echo get_current_user_id(); ?>
								},
								success: function (response) {
									// Check if response is valid and contains the necessary data
									console.log("veriff_decision.verification: ", response.data.veriff_decision.verification);
									if (response) {
										if (response.data.veriff_decision.verification?.status === 'approved') {
											// Update the HTML to show the next button only if the verification is approved

											showGlobalAlert('', `<span class="text-primary mr-1">KYC Verification</span> <span class="text-secondary">Success</span>`);

											jQuery('.financeKYCDecision').html(
												'<span class="text-primary">KYC Verification</span><span class="text-secondary">Approved</span>');

											jQuery('#finance-verification-next').html(
												'<button class="btn btn-outline-secondary rounded-pill" onclick="financeMakeNextStep()">Next</button>'
											);
										}
									} else {
										console.log('Invalid response or missing data:', response);
									}
								},
								error: function (xhr, status, error) {
									console.error('AJAX request failed:', status, error);
								}
							});
						}


						jQuery('#confirmSellerFinanceComplete').click(function () {

							var userFirstName = "<?php echo $userdata->first_name; ?>";
							var userLastName = "<?php echo $userdata->last_name; ?>";
							var vehicle_name = jQuery('#finance_entry_vehicle_name').val();
							var vehicle_vin = jQuery('#finance_entry_vehicle_vin').val();

							financeProgressVerification(5, 'Finance', 'Completed');

							showGlobalAlert('', `<span class="text-primary mr-1">Hi ${userFirstName || ''} ${userLastName || ''}, Your ${vehicle_name} VIN: ${vehicle_vin} Financing</span> <span class="text-secondary">Completed</span>`);
						});


						jQuery('#book-timeslot').on('click', function () {

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



						function addNewPickUpInfo() {
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
								formData.append("form_id", 337873); // Replace with your form ID
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


						function financePickupSessionResponse(storedData) {

							if (storedData) {
								jQuery("#timeslot-next").prop("disabled", false);
								jQuery('#finance-location-text').text(storedData.location);
								jQuery('.finance-location-text').text(storedData.location);
								jQuery('#finance-pickup-date-text').text(storedData.pickupDate);
								jQuery('.finance-timeslot-text').text(storedData.pickupDate);
								jQuery('#finance-location-input').val(storedData.location);
								jQuery('#finance-pickup-date-input').val(storedData.pickupDate);
							} else {
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


					<script>
						function addAdditionalDealData(formData) {
							return jQuery.ajax({
								url: '<?php echo admin_url("admin-ajax.php"); ?>',
								method: 'POST',
								data: formData,
								processData: false,
								contentType: false
							});
						}


						jQuery(document).ready(function ($) {


							jQuery(document).on('click', '#sellerDocumentProofDropArea .docProofUpBtn', function () {
								var block = jQuery('#sellerDocumentProofDropArea');
								console.log('clicked');
								block.find('#sellerDocumentProofFileInput').click();
							});
							// Click handler for the custom drop area


							// Drag and drop events
							$('#sellerDocumentProofDropArea').on('dragover', function (event) {
								event.preventDefault();
								event.stopPropagation();
								$(this).addClass('dragover');
							});

							$('#sellerDocumentProofDropArea').on('dragleave', function (event) {
								event.preventDefault();
								event.stopPropagation();
								$(this).removeClass('dragover');
							});

							$('#sellerDocumentProofDropArea').on('drop', function (event) {
								event.preventDefault();
								event.stopPropagation();
								$(this).removeClass('dragover');

								const files = event.originalEvent.dataTransfer.files;
								handleFiles(files[0]); // Handle the first file
							});

							// Handle file selection via input field
							$('#sellerDocumentProofFileInput').on('change', function (event) {
								const files = event.target.files;
								handleFiles(files[0]); // Handle the first file
							});

							// Function to handle file preview
							function handleFiles(file) {
								const reader = new FileReader();

								reader.onload = function (e) {
									clearPreviewContainer(); // Clear existing content before showing the new image
									const previewElement = createPreviewElement(file, e.target.result);
									$('#sellerDocumentProofPreviewContainer').append(previewElement);
								};

								reader.readAsDataURL(file); // Read the file as a data URL
							}

							// Clear all previous content from the preview container
							function clearPreviewContainer() {
								$('#sellerDocumentProofPreviewContainer').html(''); // This will remove all inner content
							}

							// Create an image preview element
							function createPreviewElement(file, dataUrl) {
								const previewElement = $('<div>', {
									class: 'col-12 px-0 rounded'
								});

								const imageElement = $('<img>', {
									src: dataUrl,
									alt: file.name,
									css: {
										width: '100%',
										height: '100%',
										borderRadius: '10px'
									}
								});

								previewElement.append(imageElement);

								return previewElement;
							}
						});







						// Get Inspection Url And Data
						var secretApiKey =
							"c39906b3db22a9ec2d7f611bbd7631ab8b8f36ffb2e5561cf9a664e3288ae95471f2f242a76b189143d17d2997133382623e851172bd22cf2e00417b3c338e4e";

						jQuery(document).ready(function ($) {


							jQuery(document).on("click", ".getFinanceInspectionUrl", async function () {
								var vehicle_vin = jQuery('#finance_entry_vehicle_vin').val();
								var seller_email = jQuery('#finance_entry_seller_email').val();
								var seller_phone = jQuery('#finance_entry_seller_phone').val();
								var dealId = sessionStorage.getItem('@deal-entry-id');
								var caseId = `${dealId}-${vehicle_vin}-${seller_email}`;

								console.log(dealId)

								// Define the payload
								const payload = {
									apiKey: secretApiKey,
									clientId: `${vehicle_vin}-${seller_email}`,
									caseId: caseId, // Replace with your unique case ID
									appType: "default", // Or "custom"
									appId: 2, // Replace with the desired appId
									userDetails: {
										phone: seller_phone,
										Email: seller_email
									},
									inputMetaData: {
										licensePlate: "",
										vin: vehicle_vin
									}
								};

								try {
									// Generate the web app URL
									const token = await generateToken(payload);
									const webappUrl = "https://superapp.inspektlabs.com/#" + token;

									const inspectionQr = `http://api.qrserver.com/v1/create-qr-code/?data=${webappUrl
								}!&size=${'100'}x${'100'}&bgcolor=${'#fff'}`
									// Display the generated URL
									$(".financeIncSellerWebappUrl").html(
										`<div class="text-center"> <img src="${inspectionQr}" class="p-3 m-2 rounded bg-light"/><br><br><span class='small mt-2'>Scan using your phone</span></div>`
									);

									// Wait for the JSON response from the web app
									// const jsonResponse = await getJsonResponse(webappUrl);

									// Display the JSON response
								} catch (error) {
									console.error("Error:", error);
									// alert("An error occurred: " + error.message);
								}
							});



							$("#generateSellerUrl").click(async function () {
								var vehicle_vin = jQuery('#escrow_entry_vehicle_vin').val();
								var seller_email = jQuery('#escrow_entry_seller_email').val();
								var seller_phone = jQuery('#escrow_entry_seller_phone').val();
								var dealId = sessionStorage.getItem('@deal-entry-id');
								var caseId = `${dealId}-${vehicle_vin}-${seller_email}`;

								// Define the payload
								const payload = {
									apiKey: secretApiKey,
									clientId: `${vehicle_vin}-${seller_email}`,
									caseId: caseId, // Replace with your unique case ID
									appType: "default", // Or "custom"
									appId: 2, // Replace with the desired appId
									userDetails: {
										phone: seller_phone,
										Email: seller_email
									},
									inputMetaData: {
										licensePlate: "",
										vin: vehicle_vin
									}
								};

								try {
									// Generate the web app URL
									const token = await generateToken(payload);
									const webAppUrl = `https://superapp.inspektlabs.com/#${token}`;

									// Generate the QR code
									fetch(`https://api.qrserver.com/v1/create-qr-code/?data=${encodeURIComponent(webAppUrl)}&size=100x100&bgcolor=%23fff`, {
										method: 'GET',
									})
										.then(response => {
											if (!response.ok) {
												throw new Error('Network response was not ok');
											}
											// The URL is a direct link to the QR code image
											return response.url;
										})
										.then(inspectionQrUrl => {
											// Inject the QR code image into the HTML
											$("#webappUrlSeller").html(`
			<div class="text-center">
				<img src="${inspectionQrUrl}" class="p-3 m-2 rounded bg-light" alt="QR Code"/><br><br>
				<span class="small mt-2">Scan using your phone or click <a href="${webAppUrl}" target="_blank">here</a></span>
			</div>
		`);
										})
										.catch(error => {
											console.log('Error fetching QR code:', error);
										});

									// Wait for the JSON response from the web app
									// const jsonResponse = await getJsonResponse(webappUrl);

									// Display the JSON response
								} catch (error) {
									console.error("Error:", error);
									// alert("An error occurred: " + error.message);
								}
							});



							const apiDomain = "<?php echo home_url(); ?>/rancoded-json";

							// Generate inspection URL and token
							$("#generateBuyerUrl").click(async function () {
								const vehicleVin = $("#escrow_entry_vehicle_vin").val();
								const buyerEmail = $("#escrow_entry_buyer_email").val();
								const buyerPhone = $("#escrow_entry_buyer_phone").val();
								const dealId = sessionStorage.getItem("@deal-entry-id");

								const caseId = `${dealId}-${vehicleVin}-${buyerEmail}`;

								const payload = {
									apiKey: secretApiKey, // Replace with your actual API key
									clientId: `${vehicleVin}-${buyerEmail}`,
									caseId: caseId, // Replace with unique case ID logic
									appType: "default",
									appId: 2,
									userDetails: {
										phone: buyerPhone,
										Email: buyerEmail,
									},
									inputMetaData: {
										vin: vehicleVin,
									},
								};

								try {
									// Generate the token
									const token = await generateToken(payload);
									const webAppUrl = `https://superapp.inspektlabs.com/#${token}`;

									// Generate the QR code
									fetch(`https://api.qrserver.com/v1/create-qr-code/?data=${encodeURIComponent(webAppUrl)}&size=100x100&bgcolor=%23fff`, {
										method: 'GET',
									})
										.then(response => {
											if (!response.ok) {
												throw new Error('Network response was not ok');
											}
											// The URL is a direct link to the QR code image
											return response.url;
										})
										.then(inspectionQrUrl => {
											// Inject the QR code image into the HTML
											$("#webappUrlBuyer").html(`
			<div class="text-center">
				<img src="${inspectionQrUrl}" class="p-3 m-2 rounded bg-light" alt="QR Code"/><br><br>
				<span class="small mt-2">Scan using your phone or click <a href="${webAppUrl}" target="_blank">here</a></span>
			</div>
		`);
										})
										.catch(error => {
											console.log('Error fetching QR code:', error);
										});


								} catch (error) {
									console.error("Error generating inspection URL:", error);
									alert("Failed to generate inspection URL.");
								}
							});

							// Generate token function
							async function generateToken(payload) {
								return new Promise((resolve, reject) => {
									$.ajax({
										url: "<?php echo admin_url('admin-ajax.php'); ?>?action=generate_superapp_token",
										type: "POST",
										contentType: "application/json",
										data: JSON.stringify(payload),
										success: function (response) {
											if (response.success) {
												resolve(JSON.parse(response.data).token);
											} else {
												reject(new Error("Failed to generate token: " +
													response
														.data
														.message));
											}
										},
										error: function (xhr, status, error) {
											reject(new Error("An error occurred: " + error));
										}
									});
								});
							}

							// Handle callback response from inspection
							async function handleGetInspectionResultCallback() {
								try {

									var vehicle_vin = jQuery('#escrow_entry_vehicle_vin').val();
									var seller_email = jQuery('#escrow_entry_seller_email').val();
									var seller_phone = jQuery('#escrow_entry_seller_phone').val();
									var dealId = sessionStorage.getItem('@deal-entry-id');
									var caseId = `${dealId}-${vehicle_vin}-${seller_email}`;
									const response = await fetch(
										`${apiDomain}/api/v1/caseid-inspection?case_id=${caseId}`);
									const result = await response.json();
									if (result.success) {
										console.log("Inspection callback response:", result);
									} else {
										console.error("Callback error:", result.message);
									}
								} catch (error) {
									console.error("Error handling callback:", error);
								}
							}




							// Submit inspection data to the server
							function submitInspectionDataToServer(storedData) {
								const entryId = jQuery("#escrow_entry_id").val();
								const seller_email = jQuery('#escrow_entry_seller_email').val();
								const buyer_email = jQuery('#escrow_entry_buyer_email').val();
								const vehicle_name = jQuery('#escrow_entry_vehicle_name').val();
								const vehicle_vin = jQuery('#escrow_entry_vehicle_vin').val();

								const formData = new FormData();
								formData.append("action", "add_additional_escrow_info");
								formData.append("form_id", 330325);
								formData.append("entry_id", entryId);
								formData.append("data_meta", "inspection_result");
								formData.append('form_name', 'Escrow car inspection result Info');
								formData.append('form_title', 'Escrow car inspection result Inf');
								formData.append('escrow_seller_email', seller_email);
								formData.append('escrow_buyer_email', buyer_email);
								formData.append('vehicle_name', vehicle_name);
								formData.append('vehicle_vin', vehicle_vin);
								formData.append("additional_info", JSON.stringify(storedData));

								addAdditionalEntryData(formData)
									.done(function (res) {
										jQuery('#loadingSpinner').hide();
										if (res.success) {
											console.log("Inspection result saved:", res.data);
										} else {
											alert("Error updating info: " + res.data);
										}
									})
									.fail(function (error) {
										console.error("Error:", error);
									});
							}




						});


					</script>


				<?php } ?>


				<style>
					.turbobidfinancing-child {
						position: relative;
						padding: 20px;
						background: white;
						border-radius: 20px;
					}

					.turbobid-financing-services {
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

					.turbobid-financing-services-wrapper {
						display: flex;
						flex-direction: row;
						align-items: flex-start;
						justify-content: flex-start;
						padding: 0 var(--padding-8xs);
						box-sizing: border-box;
						max-width: 100%;
					}

					.the-lien-payoff {
						position: relative;
						font-weight: 600;
						display: inline-block;
						max-width: 100%;
						color: white;
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

					.frame-parent h1 {
						color: #fff;
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
						gap: var(--gap-6xs);
						font-size: var(--font-size-lg);
						color: var(--color-black);
					}

					.frame-parent {
						gap: var(--gap-8xl);
					}

					.turbobidfinancing,
					.turbobidfinancing-inner {
						max-width: 100%;
						display: flex;
						box-sizing: border-box;
					}

					.turbobidfinancing-inner {
						flex-direction: column;
						align-items: flex-start;
						justify-content: flex-end;
						padding: 0 0 var(--padding-smi);
						text-align: left;
						font-size: var(--font-size-3xl);
						color: var(--color-darkgoldenrod-100);
						font-family: var(--font-plus-jakarta-sans);
					}

					.turbobidfinancing {
						border-radius: var(--br-3xl);
						flex-direction: row;
						align-items: flex-end;
						justify-content: flex-start;
						padding: var(--padding-xl) var(--padding-base);
						gap: var(--gap-12xl);
						line-height: normal;
						letter-spacing: normal;
					}

					.turbobidfinancing.financing-bg-green {
						background: #3B634C;

					}

					@media screen and (max-width: 925px) {
						.turbobidfinancing {
							flex-wrap: wrap;
						}
					}

					@media screen and (max-width: 700px) {
						.turbobidfinancing {
							gap: var(--gap-mini);
						}
					}

					@media screen and (max-width: 450px) {
						.turbobid-financing-services {
							font-size: var(--font-size-lg);
						}
					}


					/* Select Function in buyer panel  */

					.packages-card {
						border: 2px solid #fff;
						border-radius: 10px;
						transition: all 0.3s ease-in-out;
						height: 100%;
						cursor: pointer;
					}

					.packages-card:hover {
						transform: translateY(-5px);
						box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
					}

					.card-title {
						font-size: 16px;
						color: #3A564E;
						margin-bottom: 15px;
					}

					.card-text {
						font-size: 14px;
						color: #6c757d;
					}

					.price {
						display: flex;
						justify-content: space-between;
						align-items: center;
						margin-top: 10px;
					}

					.price span {
						color: #3A564E;
						font-weight: bold;
					}

					.view-details {
						color: #F79646;
						font-size: 14px;
						font-weight: 500;
					}

					.view-details:hover {
						text-decoration: underline;
					}

					.packages-card.selected {
						border: 2px solid #F79646;
					}


					#timezone {
						width: 100%;
						padding: 8px;
						border: 1px solid #dbdbdb00;
						border-radius: 5px;
						font-size: 16px;
						background: transparent;
					}

					.custom-file-drop {
						border: 1px dashed #eee;
						border-radius: 10px;
						padding: 10px;
						text-align: center;
						cursor: pointer;
						transition: border-color 0.3s;
						background: #fff;
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

					#selectPayoutMethod input {
						cursor: pointer;
					}

					@media screen and (max-width: 350px) {
						.customModalWidthHalf {
							max-width: 90% !important;
							text-align: start !important;
						}

						.customModalWidthFull {
							max-width: 90% !important;
							text-align: start !important;
						}

					}

					@media screen and (max-width: 700px) {
						.customModalWidthHalf {
							max-width: 80% !important;
							text-align: start !important;
						}

						.customModalWidthFull {
							max-width: 80% !important;
							text-align: start !important;
						}

					}

					@media screen and (min-width: 701px) {
						.customModalWidthHalf {
							max-width: 40% !important;
							text-align: start !important;
						}

						.customModalWidthFull {
							max-width: 70% !important;
							text-align: start !important;
						}

					}



					.turbo-warning {
						color: #B99D4B;
						border: 1px solid #B99D4B;
						background: rgba(185, 157, 75, 0.20);
						color: #BF9B3E;
					}

					.turbo-success {
						border: 1px solid #4bb96c;
						background: rgb(75 185 113 / 20%);
						color: #3ebf4b;
					}

					.turbo-danger {
						border: 1px solid #dc3545;
						background: rgb(185 75 75 / 20%);
						color: #dc3545;
					}

					.form-check-inline .form-check-input {
						margin-top: 0px !important;
					}
				</style>
				<?php get_template_part('framework/design/account/parts/document-management'); ?>

			<?php } ?>