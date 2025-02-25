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
   
   global $CORE, $userdata;
   $veriff_decision = get_user_meta($userdata->ID, 'veriff_decision', true);
   $userPhone = get_user_meta($userdata->ID, 'phone', true);
   
   ?>

<script>
function showEscrowPage(type) {
	const sections = {
		all: {
			content: '#escrow-all',
			menuItem: '.escrow-list-item-all',
		},
		actionRequired: {
			content: '#escrow-action-required',
			menuItem: '.escrow-list-item-action-required',
		},
		open: {
			content: '#escrow-open',
			menuItem: '.escrow-list-item-open',
		},
		closed: {
			content: '#escrow-closed',
			menuItem: '.escrow-list-item-closed',
		},
	};

	// Hide all sections
	Object.keys(sections).forEach((key) => {
		const {
			content,
			menuItem
		} = sections[key];
		jQuery(content).hide();
		jQuery(menuItem).removeClass('account-details-tab-bg');
		jQuery(`${menuItem} a`).removeClass('text-white').addClass('text-dark');
	});

	// Show the selected section
	const {
		content,
		menuItem
	} = sections[type];
	jQuery(content).show();
	jQuery(menuItem).addClass('account-details-tab-bg');
	jQuery(`${menuItem} a`).removeClass('text-dark').addClass('text-white');


}
</script>



<div class="escrow-table-data">
	<div class="d-flex flex-column flex-md-row m-0 pt-3">
		<div class="col-md-2">
			<ul class="bg-white list-unstyled py-3 my-3 radiusx" id="account_jumplinks" style="line-height:30px;">

				<li class="escrow-list-item-all px-3 py-2 mb-3 account-details-tab-bg"> <a
						onclick="showEscrowPage('all');" href="javascript:void(0);"
						class="text-decoration-none text-white" data-toggle="tab" role="tab"> <i
							class="far fa-window-restore mr-2"></i> <?php echo __("All","premiumpress") ?> </a> </li>


				<li class="escrow-list-item-action-required px-3 py-2 mb-3"> <a
						onclick="showEscrowPage('actionRequired');" href="javascript:void(0);"
						class="text-decoration-none text-dark" data-toggle="tab" role="tab"> <i
							class="far fa-window-restore mr-2"></i> <?php echo __("Action Required","premiumpress") ?>
					</a> </li>

				<li class="escrow-list-item-open px-3 py-2 mb-3"> <a onclick="showEscrowPage('open');"
						href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab" role="tab">
						<i class="far fa-window-restore mr-2"></i> <?php echo __("Open","premiumpress") ?> </a> </li>

				<li class="escrow-list-item-closed px-3 py-2 mb-3"> <a onclick="showEscrowPage('closed');"
						href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab" role="tab">
						<i class="far fa-window-restore mr-2"></i> <?php echo __("Closed","premiumpress") ?> </a> </li>

			</ul>
		</div>

		<div class="col-md-10">


			<div id="escrow-all" style="display:block;" class="bg-white radiusx col-12 my-3">
				<?php get_template_part( 'framework/design/account/account-escrow-data'); ?>
			</div>


		</div>

		<!-- col-12 block clole -->


	</div>
</div>

<div class="escrow-entry-details position-relative d-none">
	<button class="escrow-back-main position-absolute btn btn-light rounded-circle p-2" ><i class="fas fa-times"></i></button>
	<div class="d-flex flex-column flex-md-row mx-0 mt-3">
		<div class="col-md-8 p-0 p-md-1">
			<div class="turbobidfinancing financing-bg-green mb-2 align-items-stretch">
				<img style="position: relative; padding: 20px; background: white; border-radius: 20px;" loading="lazy"
					alt="turbobid financing icon"
					src="<?php echo home_url(); ?>/wp-content/uploads/2024/07/Vector-2.svg" />

				<section class="turbobidfinancing-inner col-6 col-md-4">
					<div style="gap:8px">
						<div class="turbobid-financing-services-wrapper">
							<h3 class="turbobid-financing-services">Trbo Swift Escrow services</h3>
						</div>
						<div class="lien-service">
							<div class="font-12 text-white">
								Trbo Swift Escrow ensures your safest transaction when purchasing vehicles online. Any
								Vehicle, Any Marketplace
							</div>

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

			<div class="bg-white p-3 mb-2" style="border-radius:22px;">
				<div class="mb-3">
					<div class="d-flex flex-column flex-md-row justify-content-between mb-1">
						<div class="escrow-entry-title h6">Tesla Model 3</div>
						<div class="text-md-right">Transaction #<span class="escrow-entry-id">9865445678556</span><i
								class="far fa-copy ml-1"></i></div>
					</div>
					<span class="text-primary small">Trbo Swift offers secure escrow services, ensuring payment
						protection, instant lien checks, and fraud prevention for vehicle transactions.</span>
				</div>



				<div class="escrow-process mb-3">

					<div class="mb-4">
						<div class="progress-container">

						</div>
						<div>
							<input type="hidden" id="escrow_entry_id" value="123">
							<input type="hidden" id="escrow_entry_seller_email" value="randoded.it@gmail.com">
							<input type="hidden" id="escrow_entry_seller_phone" value="+11">
							<input type="hidden" id="escrow_entry_buyer_email" value="randoded.it@gmail.com">
							<input type="hidden" id="escrow_entry_buyer_phone" value="+11">
							<input type="hidden" id="escrow_entry_vehicle_vin" value="VIN11">
							<input type="hidden" id="escrow_entry_vehicle_name" value="LAND ROVER">
							<?php if (current_user_can('administrator')) { ?>
							<!-- <button class="btn btn-primary rounded-pill px-3" id="escrow-step-back" disabled>&larr;
								Back</button>
							<button onclick="escrowMakeNextStep()" class="btn btn-secondary rounded-pill px-3">Make
								Complete</button> -->
							<?php } ?>
						</div>

					</div>

					<div id="step-details" class="mb-3">

						<div id="buyer-all-escrow-details" class="d-none">

							<div class="escrow-process-step-details" data-step="1">
								<div class="container d-flex flex-row flex-md-column m-0 p-2"
									style="border-radius:22px; border:1px solid #3B634C;">

									<div class="col-md-12">
										<div class="d-flex">
											<h6>Agreement Created </h6>
											<div class="d-none d-md-block col-md-3 align-self-center"
												style="max-width:80px;">
												<?php echo $CORE->LAYOUT("get_logo", "light"); ?>
											</div>
										</div>

										<p><span class="escrow-buyer-name text-primary">Buyer (Shirjeel Arshad)</span>is
											buying a motor vehicle from
											<span class="escrow-seller-name text-primary">Seller(Kenneth Pham)</span>.
											Buyer & Seller are both
											required to complete the Trbo Swift AI Damage inspection
										</p>

										<div id="verification-next">
											<button
												class="buyer-custom-veriff-button btn btn-secondary rounded-pill px-4 mb-2 mb-md-0 font-12">Complete
												KYC Verification</button>


											<button onclick="escrowMakeNextStep()"
											 class="kycVerificationAfterNext btn btn-outline-secondary rounded-pill px-4 font-14">Accept
												agreement</button>

											<div id="buyer-veriff-root" class="mt-3" style="display: none;"></div>

										</div>

									</div>

								</div>



								<div class="escrow-entry-transaction-summary mt-3">Transaction Summary</div>


							</div>
							<div class="escrow-process-step-details" data-step="2" style="display: none;">

								<div class="container p-2" style="border-radius:22px; border:1px solid #3B634C;">

									<div class="col-md-12">
										<h5>Payment <span class="escrow-pay-status escrow-warning">Pending</span></h5>

										<p>Please upload proof of payment </p>


										<div class="d-none d-md-block position-absolute" style="max-width:80px;">
												<?php echo $CORE->LAYOUT("get_logo", "light"); ?>
											</div>




									</div>

									<div
										class="col-md-12 d-md-flex flex-column flex-md-row justify-content-between pt-3 pt-md-0 align-items-end">

										<div class="col-md-6">
											<div class="custom-file-drop " id="paymentProofDropArea">
												<p>Please update proof of payment</p>
												<img
													src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/Group-1321315199.svg" /><br>
												<span class="small">Upload documents or images to update seller about
													the
													payment proof.</span>
												<br>
												<span class="btn btn-outline-primary px-5 py-1">Browse</span>


												<input type="file" name="files[]" id="paymentProofFileInput" multiple>
											</div>
											<div class="d-flex flex-wrap" id="paymentProofPreviewContainer"></div>


										</div>

										<div
											class="col-md-6 d-flex flex-column flex-md-row justify-content-end align-items-end">
											<button
												class="btn btn-secondary rounded-pill px-4 mb-3 mb-md-0 mr-md-3 px-3 font-14">Wiring
												Instructions</button>

											<button onclick="escrowMakeNextStep()" id="paymentProofAgreeBtn"
												class="btn btn-outline-secondary rounded-pill px-4 font-14" disabled>I
												agree to
												continue</button>
										</div>
									</div>

								</div>

								<div class="escrow-entry-transaction-summary mt-3">Transaction Summary</div>

							</div>



							<div class="escrow-process-step-details" data-step="3" style="display: none;">
								<div class="container d-flex flex-column flex-md-row m-0 p-2"
									style="border-radius:22px; border:1px solid #3B634C;">

									<div class="col-10">
										<h5>Seller Inspection </h5>
										<p>Please review seller inspection before proceeding</p>

										<div>
											<button onclick="escrowMakeNextStep();"
												class="btn btn-outline-secondary rounded-pill px-4  mr-md-3 mb-3 mb-md-0">Agree
												& Continue</button>
											<button onclick="sellerVehicleInspectionReport()"
												class="btn btn-secondary rounded-pill px-4">View report</button>

											<div id="webappUrlBuyer"></div>

										</div>

									</div>
									<div class="d-none d-md-block col-md-2" style="max-width:80px;">
										<?php echo $CORE->LAYOUT("get_logo", "light"); ?>
									</div>

								</div>

								<div class="escrow-entry-transaction-summary mt-3">Transaction Summary</div>


							</div>




							<div class="escrow-process-step-details" data-step="4" style="display: none;">
								<div class="container position-relative  m-0 p-4"
									style="border-radius:22px; border:1px solid #3B634C;">
									<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/carfax-canada.svg"
										style="position: absolute; right: 30px; top: 15px; width:55px; height:55px;" />

									<div class="row col-12">
										<h5>Vehicle Verification</h5>
										<div class="col-4 col-md-2 align-self-center" style="max-width:80px;">
											<?php echo $CORE->LAYOUT("get_logo", "light"); ?>
										</div>
									</div>
									<p>Please hold on while Trbo Swift collects essential data to verify the vehicle's
										authenticity and check for any
										liens.</p>
									<div
										style="display: flex;flex-direction: row;flex-wrap: nowrap; align-items: flex-start;gap: 5px;">
										<input type="checkbox" id="vehicle-verification-check"
											name="vehicle-verification-check" value="0">
										<label for="vehicle-verification-check" style="font-size:10px">I
											Have Reviewed the Lien
											Information Provided by Trbo Swift, Which Is Current and Up-to-Date According
											to Our Third-Party Sources
											and Servers. I Understand That This Information May Change Over Time and
											Acknowledge That Trbo Swift Is
											Not Liable for Its Accuracy. I Confirm My Understanding and Am Ready to
											Proceed to the Next
											Step.</label>
									</div>

									<div class="col-12 d-md-flex m-0 justify-content-md-end">
										<img style="width:80px"
											src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/carfax.svg" />
										<div class="mt-3 ml-2 m-md-0">
											<button onclick="getCarFaxReport()"
												class="btn btn-outline-secondary rounded-pill px-4  mr-3">Verify</button>
											<button onclick="escrowMakeNextStep();" id="buyerVVToNext"
												class="btn btn-secondary rounded-pill px-4">Next</button>
										</div>
									</div>


								</div>



								<div class="col-md-12 row mx-0 mt-3 bg-secondary radiusx p-2" style="min-height:200px"
									bis_skin_checked="1">
									<div class="col-md-9 d-flex flex-column justify-content-between "
										bis_skin_checked="1">
										<div>
											<h4 class="text-white font-weight-bold">Canada <strong
													class="text-primary">Lien Search</strong></h4>
										</div>
										<div class="lienSearchResult">
											<h4 class="noLienHolderDetails text-white">Great news—no liens were found!
											</h4>
											<span class="text-white small">
												"Thank you for using Trbo Swift Lien Verification, powered by our
												partnership with Carfax."
											</span>
										</div>


										<div class="col-12 mt-2 col-md-12 d-none justify-content-start align-items-end">
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

										<div class="text-white small">Instant lien searches powered by <img
												src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/carfax.svg" />
										</div>

									</div>
									<div class="col-3 row d-flex align-items-center justify-content-end">
										<img decoding="async"
											style="width:190px; height:100%; object-fit:contain; text-align:center;"
											src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Group-1321315442.png">
									</div>
								</div>



							</div>




							<div class="escrow-process-step-details" data-step="5" style="display: none;">

								<div class="container d-flex flex-column flex-md-row m-0 p-2"
									style="border-radius:22px;">

									<div class="col-md-12 p-0">
										<div>
											<h5>Vehicle Pickup Details</h5>
											<small>Please provide the details of the transport company responsible for
												picking up the vehicle</small>
											<div class="d-none d-md-block position-absolute"
												style="max-width:80px; right:20px; top:20px;">
												<?php echo $CORE->LAYOUT("get_logo", "light"); ?>
											</div>
										</div>

										<div>
											<div class="info-section">
												<!-- <div class="row m-0 align-items-center">
                                                <h5>Info</h5>
                                                <button id="edit-buyer-escrow-delivery"
                                                    class="btn btn-outline-secondary rounded-pill px-4 py-1 ml-2"
                                                    style="font-size:10px">Edit</button>
                                                </div> -->

												<div class="buyer-delivery-info row mt-3">
													<div class="col-12 col-md-3">
														<div>Transport Company:</div>
														<div>
															<span id="transport-company-text"
																class="editable-field d-none">James
																Coin</span>
															<input type="text" id="transport-company-input"
																class="form-control rounded-pill" value="James Coin">
														</div>
													</div>
													<div class="col-12 col-md-3">
														<div>Phone Number:</div>
														<div>
															<span id="phone-number-text"
																class="editable-field d-none">416-265-1074</span>
															<input type="text" id="phone-number-input"
																class="form-control rounded-pill" value="416-265-1074">
														</div>
													</div>
													<div class="col-12 col-md-3">
														<div>Tracking Number:</div>
														<div>
															<span id="tracking-number-text"
																class="editable-field d-none">0987654edfvbn</span>
															<input type="text" id="tracking-number-input"
																class="form-control rounded-pill" value="0987654edfvbn">
														</div>
													</div>

													<div class="col-12 col-md-3">
														<div>Pickup Date:</div>
														<div>
															<span id="pickup-date-text" class="editable-field d-none">12
																July
																2024</span>
															<input type="date" id="pickup-date-input"
																class="form-control rounded-pill" value="2024-07-12">
														</div>
													</div>
												</div>
											</div>
											<small>Please select whether you will be picking up the vehicle in person or
												arranging local transportation</small>


											<div class="isPickingUp d-flex">
												Are you picking up the vehicle?
												<div class="form-check  d-flex ml-3">
													<input type="radio" name="formTask" value="Yes"
														class="form-check-input"><label>
														Yes</label>
												</div>
												<div class="form-check d-flex ml-2">
													<input type="radio" name="formTask" value="No"
														class="form-check-input"><label>
														No</label>
												</div>
											</div>



										</div>



										<div class="text-right">
											<!-- <button onclick="turboBidTransportPop()"
                                                class="btn btn-outline-secondary rounded-pill px-4 mr-md-3 mb-3 mb-md-0">Get
                                                Quote</button> -->
											<button class="btn btn-secondary rounded-pill px-4"
												onclick="addNewDeliveryInfo()">Next</button>

										</div>

									</div>



								</div>

								<!-- Second block -->

								<div class="col-md-12 row mx-0 mt-3 bg-secondary radiusx p-2" bis_skin_checked="1"
									style="min-height:200px">
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
												src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/carfax.svg" />
										</div>

									</div>
									<div class="col-3 row d-flex align-items-center justify-content-end">
										<img decoding="async"
											style="width:190px; height:100%; object-fit:contain; text-align:center;"
											src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Group-1321315442.png">
									</div>
								</div>

							</div>

							<div class="escrow-process-step-details" data-step="6" style="display: none;">
								<div class="container d-flex flex-column flex-md-row m-0 p-2"
									style="border-radius:22px; border:1px solid #3B634C;">

									<div class="col-12">

										<div class="d-flex justify-content-between">
											<div class="d-flex" style="gap:10px;">
												<h5>Delivery <span
														class="escrow-delivery-status escrow-warning">Pending</span>
												</h5>
												<h5>Payment to seller:<span
														class="escrow-payToSeller-status escrow-warning">Pending</span>
												</h5>
											</div>
											<div class="d-none d-md-block position-absolute" style="max-width:80px; right:20px; top: 10px;">
												<?php echo $CORE->LAYOUT("get_logo", "light"); ?></div>
										</div>
										<p>Thank you for using Trbo Swift! Please rate your experience here.</p>

										<div class="pt-5 pb-3">

											<span class="ammount-release-seller mb-2"></span><br>

											<strong>Review tracking details on the Trbo Swift Dashboard. Payment will
												be
												made to the seller upon delivery.</strong>

										</div>

									</div>

								</div>


								<div class="escrow-entry-transaction-summary mt-3">Transaction Summary</div>




							</div>

						</div><!-- Buyer all Escrow details close -->

						<div id="seller-all-escrow-details" class="d-none">
							<div class="escrow-process-step-details" data-step="1">
								<div class="container d-flex flex-column flex-md-row m-0 p-2"
									style="border-radius:22px; border:1px solid #3B634C;">

									<div class="col-md-12">
										<div class="d-flex">
											<h6>Agreement Created </h6>
											<div class="d-none d-md-block position-absolute"
												style="max-width:80px; right:20px; top:20px;">
												<?php echo $CORE->LAYOUT("get_logo", "light"); ?>
											</div>
										</div>
										<div class="mt-3 small mb-3"><span class="escrow-buyer-name text-primary">Buyer
											</span>is
											buying a motor vehicle from
											<span class="escrow-seller-name text-primary">Seller</span>.
											Buyer & Seller are both
											required to complete the Trbo Swift AI Damage inspection
										</div>

										<button onclick="escrowMakeNextStep()"
											class="btn btn-secondary rounded-pill px-4" style="min-width:150px">Accept
											agreement</button>

										<br><br>


										<small class="font-weight-bold">

											By entering into this agreement, the vehicle may not be driven more than 250
											km, or any other distance mutually agreed upon with the buyer prior to
											pickup.

										</small>

									</div>


								</div>



								<div class="escrow-entry-transaction-summary mt-3">Transaction Summary</div>


							</div>
							<div class="escrow-process-step-details" data-step="2" style="display: none;">

								<div class="container m-0 p-2" style="border-radius:22px; border:1px solid #3B634C;">

									<div class="d-none d-md-block  float-right" style="max-width:80px">
										<?php echo $CORE->LAYOUT("get_logo", "light"); ?>
									</div>

									<div class="">
										<h5>Buyer Finance Approval: <span
												class="escrow-pay-status escrow-warning">Pending</span></h5>

										<p>We’ll update this as soon as the buyers payment has been recieved in escrow
											account </p>

									</div>

									<div class="mt-3">
										<button type="button" class="btn btn-secondary rounded-pill px-4 mr-3"
											onclick="jQuery('#bankInfoModal').fadeIn(400);"
											style="min-width:150px;">Fill out
											form</button>

										<button onclick="escrowMakeNextStep()"
											class="btn btn-secondary rounded-pill px-4"
											style="min-width:150px">Next</button>
									</div>



								</div>

								<div class="escrow-entry-transaction-summary mt-3">Transaction Summary</div>



								<!-- The Modal -->
								<div class="modal" id="bankInfoModal" aria-labelledby="bankInfoModalLabel">
									<div class="modal-dialog modal-lg">
										<div class="modal-content bg-white position-relative"
											style="border-radius:20px;">
											<!-- Modal Header -->
											<div class="modal-header">
												<h5 class="modal-title" id="bankInfoModalLabel">Beneficiary Bank
													Information</h5>
												<button onclick="jQuery('#bankInfoModal').fadeOut(400);" type="button"
													class="btn btn-light rounded-pill"
													style="position: absolute; right: 30px; top: 15px; z-index:5;"><i
														class="fal fa-times"></i></button>
											</div>

											<!-- Modal Body -->
											<div class="modal-body">
												<form id="bankInfoForm" class="col-12 row">

													<div class="mb-3 col-md-12">
														<div class="custom-file-drop d-flex flex-column justify-content-center align-items-center"
															id="bankDPDropArea"
															style="width:200px; height:200px;border-radius: 100%;">
															<img
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/Group-1321315199.svg" />
															<strong>Upload Bank DP</strong>
															<span style="font-size:8px">Drop the bank dp image
																here.</span>
															<span style="font-size:10px">OR</span>
															<span class="btn btn-outline-primary px-5 py-1"
																style="font-size:10px">Browse</span>

															<input type="file" name="files[]" id="bankDPFileInput">
														</div>
														<div class="d-flex flex-wrap" id="bankDPDropPreviewContainer">
														</div>

													</div>

													<div class="mb-3 col-md-6 small">
														<label for="country" class="form-label">Country</label>
														<select class="form-select rounded-pill" id="country"
															name="country">
															<option selected>Canada</option>
															<option value="USA">USA</option>
															<option value="UK">UK</option>
														</select>
													</div>

													<div class="mb-3 col-md-6 small">
														<label for="currency" class="form-label">Currency</label>
														<select class="form-select rounded-pill" id="currency"
															name="currency">
															<option selected>CAD</option>
															<option value="USD">USD</option>
															<option value="GBP">GBP</option>
														</select>
													</div>

													<div class="mb-3 col-md-6 small">
														<label for="bankName" class="form-label">Bank Name</label>
														<input type="text" class="form-control rounded-pill"
															id="bankName" name="bank_name"
															placeholder="Enter bank name here">
													</div>

													<div class="mb-3 col-md-6 small">
														<label for="accountName" class="form-label">Beneficiary
															Account
															Name</label>
														<input type="text" class="form-control rounded-pill"
															id="accountName" name="account_name"
															placeholder="Enter account name">
													</div>

													<div class="mb-3 col-md-12 small">
														<label for="address" class="form-label">Add Address</label>
														<input type="text"
															class="form-control rounded-pill googleAutoLocation"
															id="address" name="address" placeholder="Enter address">
													</div>

													<div class="mb-3 col-md-6 small">
														<label for="swiftCode" class="form-label">Swift/BIC
															Code</label>
														<input type="text" class="form-control rounded-pill"
															id="swiftCode" name="swift_code"
															placeholder="Enter swift code here">
													</div>

													<div class="mb-3 col-md-6 small">
														<label for="accountNumber" class="form-label">Account
															Number</label>
														<input type="text" class="form-control rounded-pill"
															id="accountNumber" name="account_number"
															placeholder="Enter your account number">
													</div>

													<div class="mb-3 col-md-6 small">
														<label for="finNumber" class="form-label">Financial
															Institution
															Number</label>
														<input type="text" class="form-control rounded-pill"
															id="finNumber" name="fin_number" placeholder="Enter FIN">
													</div>

													<div class="mb-3 col-md-6 small">
														<label for="branchNumber" class="form-label">Branch/Transit
															Number</label>
														<input type="text" class="form-control rounded-pill"
															id="branchNumber" name="branch_number"
															placeholder="Enter branch number here">
													</div>

													<div class="mb-3 col-md-12 small">
														<label for="additionalInfo" class="form-label">Additional
															Information</label>
														<textarea class="form-control" id="additionalInfo"
															name="additional_info" rows="3"
															placeholder="Description"></textarea>
													</div>

													<p>CAD transfer to a bank account in Canada will incur a $10.00
														CAD
														fee.</p>
												</form>
											</div>

											<!-- Modal Footer -->
											<div class="modal-footer">
												<button onclick="jQuery('#bankInfoModal').fadeOut(400);" type="button"
													class="btn btn-secondary rounded-pill px-3">Close</button>
												<button onclick="saveBankInfoBtn()" type="button"
													class="btn btn-primary rounded-pill px-3" id="
                                                    saveBankInfoBtn">Save</button>
											</div>
										</div>
									</div>
								</div>


							</div>


							<div class="escrow-process-step-details" data-step="3" style="display: none;">
								<div class="container d-flex flex-column flex-md-row m-0 p-2 position-relative"
									style="border-radius:22px; border:1px solid #3B634C;">

									<div class="col-md-10">
										<h5>Seller Inspection: <span
												class="escrow-inspection-status escrow-warning">Pending</span></h5>
										<p>Please conduct the vehicle inspection before it is transported. The buyer
											will need to approve the inspection report.</p>

										<div class="d-flex flex-column flex-md-row gap-3">
											<button id="generateSellerUrl"
												class="btn btn-secondary rounded-pill px-4 mb-2 mb-md-0 mr-md-2">Complete
												Inspection</button>
											<button class="btn btn-outline-secondary rounded-pill px-4"
												onclick="sellerVehicleInspectionReport()">View
												report</button>

										</div>

										<div class="py-4">
											<div id="webappUrlSeller"></div>
											<div id="responseResultSeller"></div>
										</div>

									</div>
									<div class="d-none d-md-block position-absolute" style="max-width:80px; right:20px; top: 10px;">
										<?php echo $CORE->LAYOUT("get_logo", "light"); ?>
									</div>

								</div>

								<div class="inspection-section container my-3 p-2 bg-light" style="border-radius:22px;">

									<div class="form-group col-md-12 d-flex align-items-center px-0 mb-2">
										<span style="font-size:12px; color:#5f5f5f" for="escrowNameReqOwner"
											class="info-label mr-2">Name of Registered Owner</span>
										<input type="text" id="escrowNameReqOwner"
											class="col-6 form-control rounded-pill" value="">
									</div>
									<div class="col-md-12 row">



										<div id="isEscrowRegisteredOwner" class="col-md-6 row mt-2">
											<span class="mr-2" style="font-size:14px; color:#5f5f5f">Are you
												registered owner of the Vehicle?</span>

											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio"
													name="isEscrowRegisteredOwner" value="Yes">
												<label class="form-check-label" for="isEscrowRegisteredOwner">
													Yes
												</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio"
													name="isEscrowRegisteredOwner" value="No">
												<label class="form-check-label" for="isEscrowRegisteredOwner">
													No
												</label>
											</div>

										</div>

										<div id="isEscrowAnyLiensVehicle" class="col-md-6 row mt-2">
											<span class="mr-2" style="font-size:14px; color:#5f5f5f">Are there any
												liens on the vehicle?</span>

											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio"
													name="isEscrowAnyLiensVehicle" value="Yes">
												<label class="form-check-label" for="isEscrowAnyLiensVehicle">
													Yes
												</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio"
													name="isEscrowAnyLiensVehicle" value="No">
												<label class="form-check-label" for="isEscrowAnyLiensVehicle">
													No
												</label>
											</div>

										</div>

									</div>

									<div class="col-md-12 row mt-2">
										<div class="form-group col-md-6 pl-0">
											<label style="font-size:14px; color:#5f5f5f"
												for="isEscrowVehicleBeingPicked" class="info-label">Is the vehicle being
												picked up or
												delivered?</label>
											<select type="text" id="isEscrowVehicleBeingPicked"
												class="form-control rounded-pill">
												<option>Yes</option>
												<option>No</option>

											</select>
										</div>

										<div class="form-group col-md-6">
											<label style="font-size:14px; color:#5f5f5f" for=""
												class="info-label">Requested Pickup Date</label>
											<input type="date" id="requestedEscrowPickupDate"
												class="form-control rounded-pill" value="">
										</div>
									</div>


									<div id="confirmEscrowVehiclePurchase" class="row mx-0 align-items-center my-2"
										style="font-size:14px; color:#5f5f5f">
										<strong class="mr-2">Please confirm the vehicle purchase price:</strong>
										<span class="escrowVehicleVinNumber mr-2">VIN:SCBZR03B0KCX24723</span>
										<span class="escrowVehiclePurchasePrice mr-3">$55440</span>

										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio"
												name="confirmEscrowVehiclePurchase" value="Yes">
											<label class="form-check-label" for="confirmEscrowVehiclePurchase">
												Yes
											</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio"
												name="confirmEscrowVehiclePurchase" value="No">
											<label class="form-check-label" for="confirmEscrowVehiclePurchase">
												No
											</label>
										</div>

									</div>

									<div class="col-12 col-md-4 p-0 license-image-column">


										<div class="d-flex flex-wrap py-3" id="escrowSellerDocProofPrevContainer">
											<div class="col-12 px-0">

											</div>
										</div>

										<div class="custom-file-drop" id="escrowSellerDocProofDrop">
											<!-- <p>Upload document or image</p> -->
											<img
												src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/Group-1321315199.svg" /><br>
											<span class="small">Please update copy of Vehicle Ownership</span>
											<br>

											<div class="text-center my-2">
												<button class="escrowDocProofUpBtn btn btn-outline-primary px-2 py-1"
													style="width: 130px; font-size: 12px;">Browse</button><br>

											</div>


											<input type="file" name="file" id="escrowSellerDocProofFileInput"
												style="display: none;">
										</div>

									</div>

									<button type="button" id="escrowSellerDetailsSubmit"
										class="btn btn-secondary rounded-pill px-4 mt-3">Submit</button>

								</div>


							</div>




							<div class="escrow-process-step-details" data-step="4" style="display: none;">
								<div class="container row m-0 p-2 bg-white" style="border-radius:22px;">

									<div class="col-12">

										<div class="row mx-0 gap-2 my-2 align-items-center">
											<h5>Vehicle Pickup Details</h5>

										</div>
										<p class="small">Seller must be present with Photo ID when the vehicle is picked
											up by the seller or transport company </p>

										<div class="col-12 px-0 form-row my-3">
											<div class="form-group col-md-4">
												<label style="font-size:12px; color:#5f5f5f" for="escrowPickUpAddress"
													class="info-label">Address</label>
												<input type="text" id="escrowPickUpAddress"
													class="form-control rounded-pill googleAutoLocation"
													placeholder="Enter Pickup Address/Zip code" value="">
											</div>
											<div class="form-group col-md-4">
												<label style="font-size:12px; color:#5f5f5f"
													for="escrowVehiclePickupDate" class="info-label">Requested Pickup
													Date</label>
												<input type="date" id="escrowVehiclePickupDate"
													class="form-control rounded-pill" value="">
											</div>
											<div class="form-group col-md-4">
												<label style="font-size:12px; color:#5f5f5f" for="escrowDropoffDetails"
													class="info-label"> Dropoff Details</label>
												<input type="text" id="escrowDropoffDetails"
													class="form-control googleAutoLocation rounded-pill"
													placeholder="Enter Dropoff Address/Zip code" value="">
											</div>


											<div class="form-group col-md-4">
												<label style="font-size:12px; color:#5f5f5f" for="escrowOdometer"
													class="info-label">Odometer</label> <span
													class="badge badge-pill badge-success turbo-success">Verified</span>

												<input type="text" id="escrowOdometer" class="form-control rounded-pill"
													placeholder="Please enter the current KM on the vehicle" value="">
											</div>


											<div class="form-group col-md-4">
												<label style="font-size:12px; color:#5f5f5f" for="escrowWaiver"
													class="info-label">Escrow waiver Agreement / Contract</label>

												<select type="text" id="escrowWaiver" class="form-control rounded-pill">
													<option> I agree</option>
													<option>Not agree</option>
												</select>
											</div>

										</div>


										<div>

											<button type="submit"
												class="escrowPickupSellerNextBtn btn btn-secondary rounded-pill px-5 font-12"
												style="min-width:150px">Next</button>

										</div>


									</div>
								</div>



							</div>

							<div class="escrow-process-step-details" data-step="5" style="display: none;">
								<div class="container row m-0 p-2 bg-white" style="border-radius:22px;">

									<div class="col-12">


										<h5><span class="text-primary">Step 1:</span> KYC Verification</h5>
										<small>Please capture a photo of your driver's license along with a simple
											selfie.
											You can do this using either a smartphone or a web browser. We'll need this
											to verify the registered owner of the vehicle in order to issue
											payment.</small>

										<div>
											<span
												class="escrowSellerVeriffStatus btn btn-outline-secondary rounded-pill px-4 mr-2 font-12">Status
												Pending</span>
											<button
												class="seller-custom-veriff-button btn btn-secondary rounded-pill px-4 font-12">Get
												Verified</button>
											<div id="seller-veriff-root" class="mt-3" style="display: none;"></div>
										</div>



									</div>
								</div>


								<div class="container row mt-3 mx-0 p-2 bg-white" style="border-radius:22px;">

									<div class="col-12">


										<h5><span class="text-primary">Step 2:</span> Please Select Payout Method</h5>

										<div id="escrowSellerPayoutMethod" class="my-2">

											<button
												class="d-none d-md-block btn btn-secondary bg-secondary rounded-pill px-4 escrowSellerProcessComplete float-right"
												style="font-size:12px;">Finish</button>

											<div class="form-check form-check-inline  ml-3">
												<input class="form-check-input" type="radio" id="sellerWireTransfer"
													name="escrowSellerPayoutMethod" value="Wire Transfer"
													style="position: absolute; transform: translate(-19px, 5px);">
												<label class="form-check-label" for="escrowSellerPayoutMethod">
													Wire Transfer
												</label>
											</div>
											<div class="form-check form-check-inline ml-3">
												<input class="form-check-input" type="radio"
													name="escrowSellerPayoutMethod" value="Hyperwallet Payment (Faster)"
													id="sellerHyperWalletPayment"
													style="position: absolute; transform: translate(-19px, 5px);">
												<label class="form-check-label" for="escrowSellerPayoutMethod">
													Hyperwallet Payment (Faster)
												</label>
											</div>

										</div>

										<p>HyperWallet payments are sent directly to your email, enabling you to
											transfer funds anywhere faster than a wire transfer, often within hours.</p>

										<button
											class="btn btn-secondary bg-secondary rounded-pill px-4 escrowSellerProcessComplete mt-3 d-block d-md-none"
											style="font-size:12px;">Finish</button>



									</div>
								</div>


								<!-- <div class="d-flex" style="gap:10px;">
												<h5>Delivery <span
														class="escrow-delivery-status escrow-warning">Pending</span>
												</h5>
												<h5>Payment <span
														class="escrow-payToSeller-status escrow-warning">Pending</span>
												</h5>
											</div> -->


								<div class="escrow-entry-transaction-summary mt-3">Transaction Summary</div>


							</div>


						</div><!-- Seller all Escrow details close -->

					</div>

					<div class="escrow-item-details bg-light p-3 d-none" style="border-radius:22px;">
						<div class="h6"><i class="far fa-file"></i> Item details</div>
						<h6 class="escrow-entry-title">Tesla Model 3 2024</h6>
						<div class="d-flex justify-content-between text-dark"><span class="escrow-entry-title">
								Tesla
								Model 3 2024 </span> <span class="escrow-entry-price"> CA$35,000.00 </span></div>
						<div class="d-flex justify-content-between text-dark"><span class="escrow-entry-vin">VIN:
								OIUYTRE456YHBNMU</span></div>
						<div class="d-flex justify-content-between text-dark"><span>Subtotal</span> <span
								class="escrow-entry-subtotal"> CA$35,000.00 </span></div>
						<div class="d-flex justify-content-between text-dark"><span
								class="escrow-entry-shipping-fee">Shipping Fee </span> <span class="escrow-entry-price">
								CA$35,000.00 </span></div>
						<div class="d-flex justify-content-between text-dark font-weight-bold"><span>Total
								(CAD)</span>
							<span class="escrow-entry-total-price"> CA$35,000.00 </span>
						</div>
						<div>


						</div><!-- Process Close -->


					</div>




					<div class="turbobidescrow-data"></div>

				</div>
			</div>
		</div>
		<div class="col-md-4 p-0 p-md-1">
			<div class="bg-white p-3 mb-2 mr-2" style="border-radius:22px;">
				<h5>History</h5>
				<p class="escrow-entry-submit-date my-3">July 7, 2024, 6:12PM EDT</p><br>
				<span>Seller initiates the transaction</span>
			</div>

			<div class="bg-white p-3 mb-2 mr-2" style="border-radius:22px;">
				<h5><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/wpf_ask-question.svg"
						style="width:25px; margin-right:10px;" />Trbo Swift FAQ Questions</h5>

				<?php echo do_shortcode('[elementor-template id="325472"]'); ?>

			</div>

			<div class="bg-white p-3 mb-2 mr-2" style="border-radius:22px;">
				<h5><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/wpf_ask-question.svg"
						style="width:25px; margin-right:10px;" />Trbo Swift AI Inspection</h5>

				<?php echo do_shortcode('[elementor-template id="325466"]'); ?>

			</div>

		</div>

	</div>
</div>


<script>
let currentEscrowStep;
var userPhone = "<?php echo $userPhone; ?>";
// var userPhoneNumber = userPhone.startsWith("+") ? userPhone.substring(1) : userPhone;

function isMatchingCanadianNumber(inputNumber, normalizedNumber) {
	// Remove non-numeric characters from the input number
	const cleanedInputNumber = inputNumber.replace(/[^\d]/g, "");

	// Normalize the input number to include the +1 country code for Canada
	const formattedInputNumber = cleanedInputNumber.length === 10 ? `1${cleanedInputNumber}` : cleanedInputNumber;

	// Remove the + sign from the normalized number for comparison
	const cleanedNormalizedNumber = normalizedNumber.startsWith("+") ?
		normalizedNumber.substring(1) :
		normalizedNumber;

	// Compare the formatted numbers
	return formattedInputNumber === cleanedNormalizedNumber;
}


var sellerEscrowSessionEmail = sessionStorage.getItem('@escrow-seller-email');

function escrowMakeNextStep() {
	const totalEscrowSteps = sessionStorage.getItem('totalEscrowSteps');

	console.log('Current escrow step:', currentEscrowStep);

	if (currentEscrowStep < totalEscrowSteps) {
		currentEscrowStep++;
	} else {
		// Submit the form or perform final action here
	}
	updateUserEscrowEntryCurrentStep();
}



function updateUserEscrowEntryCurrentStep() {
	var entryId = parseInt(jQuery('#escrow_entry_id').val());



	if ('<?php echo $userdata->user_email; ?>' === sellerEscrowSessionEmail || isMatchingCanadianNumber(jQuery(
			'#escrow_entry_seller_phone').val(), userPhone)) {
		var stepMeta = 'seller_escrow_entry_current_step';
	} else {
		var stepMeta = 'escrow_entry_current_step';
	}
	jQuery('#loadingSpinner').show();

	jQuery.ajax({
		url: '<?php echo admin_url('admin-ajax.php'); ?>',
		type: 'POST',
		data: {
			action: 'update_entry_step',
			current_step: currentEscrowStep,
			form_id: 330325,
			entry_id: entryId,
			step_meta: stepMeta
		},
		success: function(response) {
			jQuery('#loadingSpinner').hide();
			//console.log(response);
			if (response.success) {

				if ('<?php echo $userdata->user_email; ?>' === sellerEscrowSessionEmail ||
					isMatchingCanadianNumber(jQuery('#escrow_entry_seller_phone').val(), userPhone)) {
					updateEscrowStep(response.data.seller_escrow_entry_current_step);
				} else {
					updateEscrowStep(response.data.escrow_entry_current_step);
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






function updateEscrowStep(step) {
	const totalEscrowSteps = sessionStorage.getItem('totalEscrowSteps');
	currentEscrowStep = step;

	const currentUser = sessionStorage.getItem('@currentEscrowUserType');
	console.log('step: ', currentEscrowStep);
	console.log('Current user: ', currentUser);



	var $steps = jQuery('.step-wrap');
	var $stepDetails = jQuery(`#${currentUser}-all-escrow-details .escrow-process-step-details`);
	var $progressBar = jQuery('#progress');

	$steps.removeClass('active').each(function(index) {
		if (index + 1 <= currentEscrowStep) {
			jQuery(this).addClass('active');
		}
	});

	$stepDetails.hide().filter('[data-step="' + currentEscrowStep + '"]').show();

	var progressWidth = (currentEscrowStep - 1) / (totalEscrowSteps - 1) * 96;
	$progressBar.css('width', progressWidth + '%');

	jQuery('#escrow-step-back').prop('disabled', currentEscrowStep === 1);
	jQuery('#escrow-step-next').text(currentEscrowStep === totalEscrowSteps ? 'All Compleate' : 'Next');



	/* if(currentEscrowStep === 5 || currentEscrowStep === 7){
	 $('.escrow-item-details').addClass('d-none');
	 }else{
	 $('.escrow-item-details').removeClass('d-none');
	 }
	 */
}



jQuery('#escrow-step-back').click(function() {
	if (currentEscrowStep > 1) {
		currentEscrowStep--;
	}
	updateUserEscrowEntryCurrentStep();
});


jQuery('.escrow-back-main').click(function() {
	jQuery('.escrow-entry-details').addClass('d-none');
	jQuery('.escrow-back-main').addClass('d-none');
	jQuery('.escrow-table-data').removeClass('d-none');
});


jQuery(document).on('click', '.entry-link', function() {

	// console.log('deal-entry-link clicked');

	var dealId = parseInt(jQuery(this).data('entry-id'));

	getDealInfoAfterClickDealLink(dealId);

});

function getDealInfoAfterUpdateData() {
	var dealId = sessionStorage.getItem('@deal-entry-id');
	getDealInfoAfterClickDealLink(dealId);
}

function getDealInfoAfterClickDealLink(entry_id) {

	console.log(entry_id);

	jQuery('#dashboard').hide();
	jQuery('#escrow').show();
	jQuery('#loadingSpinner').show();
	jQuery.ajax({
		url: '<?php echo admin_url('admin-ajax.php'); ?>',
		type: 'POST',
		data: {
			action: 'get_escrow_entry_details',
			form_id: 330325,
			entry_id: entry_id
		},
		success: function(response) {
			jQuery('#loadingSpinner').hide();
			jQuery('.escrow-table-data').addClass('d-none');
			jQuery('.escrow-entry-details').removeClass('d-none');
			jQuery('.escrow-back-main').removeClass('d-none');

			console.log('escrow response:', response);

			if (response.success) {
				var entry = response.data;
				var meta = entry.meta;

				sessionStorage.setItem('@current-deal-meta-data', JSON.stringify(meta));


				if(entry.escrow_carfax_lien_result?.LienExpressProvince){
					jQuery('#buyerVVToNext').prop("disabled", false);
                    sessionStorage.setItem('escrow_carfax_lien_result', entry.escrow_carfax_lien_result);
				}
				if(entry.escrow_carfax_lien_result){
					jQuery('#buyerVVToNext').prop("disabled", false);
					sessionStorage.setItem('escrow_carfax_lien_result', entry.escrow_carfax_lien_result);
				}else{
					jQuery('#buyerVVToNext').prop("disabled", true);
				}
				
				// Function to parse the serialized PHP data



				jQuery('.escrow-entry-title').text(meta['name-1']);
				jQuery('.escrow-entry-id').text(entry.entry_id);
				jQuery('#escrow_entry_id').val(entry.entry_id);
				sessionStorage.setItem('@deal-entry-id', entry.entry_id);
				jQuery('.escrow-buyer-name').html('Buyer (' + meta['email-2'] + ')');
				jQuery('.escrow-seller-name').html('Seller (' + meta['email-1'] + ')');
				jQuery('.escrow-entry-vin').html('VIN: ' + meta['text-11']);
				jQuery('.ammount-release-seller').html('Total Amount Release to seller <strong>' +
					meta['number-2'] + '</strong>');

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


				jQuery('#escrowPickUpAddress').val(meta['text-14'] || '');
				jQuery('#escrowDropoffDetails').val(meta['text-15'] || '');
				jQuery('#escrowVehiclePickupDate').val(formatDateToISO(meta['date-1'] || '' ));
				jQuery('#escrowOdometer').val(meta['escrowOdometer'] || '' );
				jQuery('#escrowWaiver').val(meta['escrowWaiver'] || '' );

				var currency4 = parseFloat(meta['currency-4']);
				var currency2 = parseFloat(meta['currency-2']);

				// Use a fallback of 0 if the result is NaN
				currency4 = isNaN(currency4) ? 0 : currency4;
				currency2 = isNaN(currency2) ? 0 : currency2;

				// Perform the addition
				var shippingSum = currency4 + currency2;

				// Update the HTML content with the sum
				// jQuery('.escrow-entry-subtotal').html(formatCalCadPrice(shippingSum));

				// jQuery('.escrow-entry-total-price').html(calculation2);

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

				var sellerEscrowSession = sessionStorage.getItem('@escrow-seller-email');
				var buyerEscrowSession = sessionStorage.getItem('@escrow-buyer-email');


				const statusSession = {
					buyer: entry.buyer_escrow_status?.user,
					seller: entry.seller_escrow_status?.user,
					buyerStep: entry.buyer_escrow_status?.step || 0,
					sellerStep: entry.seller_escrow_status?.step || 0,
					buyerStatus: entry.buyer_escrow_status?.status || '',
					sellerStatus: entry.seller_escrow_status?.status || ''
				};
				sessionStorage.setItem('statusSession', JSON.stringify(statusSession));

				escrowStatusBasedUpdateInfo();

				

				if ('<?php echo $userdata->user_email; ?>' === meta['email-1'] ||
					isMatchingCanadianNumber(meta['phone-1'], userPhone))  {

					sessionStorage.setItem('@currentEscrowUserType', 'seller');
					sessionStorage.setItem('totalEscrowSteps', 5);

					jQuery('.escrow-process .progress-container').html(escrowTransSellerProcess);

					var stepX = entry.seller_escrow_entry_current_step;
					if(!stepX){
					updateEscrowStep(1);
					}else{
						updateEscrowStep(stepX);
					}
					

					jQuery('.escrow-process').removeClass('d-none');
					jQuery('.escrow-process #buyer-all-escrow-details').removeClass('d-block')
						.addClass('d-none');
					jQuery('.escrow-process #seller-all-escrow-details').removeClass('d-none')
						.addClass('d-block');

					var uniqueId = '@sellerEscrowDelivery' + entry_id;
					jQuery('#buyerDeliveryInfo').val(uniqueId);
					sessionStorage.setItem(uniqueId, JSON.stringify(entry.delivery_escrow_info));

					fetchUserMeta('<?php echo $userdata->user_email; ?>', function(error, veriffDecision) {
						if (error) {
							console.log("Error fetching buyer veriff decision:", error);
						} else {
							userEscrowVeriffDecision(veriffDecision);
						}
					});

					if (stepX == 4) {
						deliverySessionResponse();
					}

					
					if(meta['KycRequest'] === 'Yes'){
						setTimeout(function(){
							showGlobalAlert('error', 'Please verify your KYC');

						}, 5000);
					}


					if (entry.seller_payment_method['Gateway'] == 'Hyperwallet Payment (Faster)') {
						jQuery('#sellerHyperWalletPayment').prop("checked", true);
						jQuery('#sellerWireTransfer').prop("checked", false);
					} else if (entry.seller_payment_method['Gateway'] == 'Wire Transfer') {
						jQuery('#sellerWireTransfer').prop("checked", true);
						jQuery('#sellerHyperWalletPayment').prop("checked", false);
					} else {
						jQuery('#sellerWireTransfer').prop("checked", false);
						jQuery('#sellerHyperWalletPayment').prop("checked", false);
					}

					if (!entry.seller_escrow_bank_dp || entry.seller_escrow_bank_dp === "undefined") {
						jQuery('#sellerPaymentNext').prop("disabled", true);
					} else {
						jQuery('#sellerPaymentNext').prop("disabled", false);
					}

					fetchEscrowDocumentFiles('1', 'Escrow Vehicle Ownership');
					jQuery('#escrowNameReqOwner').val(meta['escrowNameReqOwner'] || '');
					setEscrowRadioValue('#isEscrowRegisteredOwner', meta['isEscrowRegisteredOwner']);
					setEscrowRadioValue('#isEscrowAnyLiensVehicle', meta['isEscrowAnyLiensVehicle']);
			
					jQuery('#isEscrowVehicleBeingPicked').val(meta['isEscrowVehicleBeingPicked'] || '');

					jQuery('#requestedEscrowPickupDate').val(formatDateToISO(meta['requestedEscrowPickupDate'] || ''));
					setEscrowRadioValue('#confirmEscrowVehiclePurchase', meta['confirmEscrowVehiclePurchase']);




				} else if ('<?php echo $userdata->user_email; ?>' === meta['email-2'] ||
					isMatchingCanadianNumber(meta['phone-2'], userPhone)) {

					sessionStorage.setItem('@currentEscrowUserType', 'buyer');
					sessionStorage.setItem('totalEscrowSteps', 6);

					jQuery('.escrow-process .progress-container').html(escrowTrasBuyerProcess);
					var stepX = entry.escrow_entry_current_step;
					if(!stepX){
					updateEscrowStep(1);
					}else{
						updateEscrowStep(stepX);
					}
					jQuery('.escrow-process').removeClass('d-none');
					jQuery('.escrow-process #buyer-all-escrow-details').removeClass('d-none')
						.addClass('d-block');
					jQuery('.escrow-process #seller-all-escrow-details').removeClass('d-block')
						.addClass('d-none');

					var uniqueId = '@buyerEscrowDelivery' + entry_id;
					jQuery('#buyerDeliveryInfo').val(uniqueId);
					sessionStorage.setItem(uniqueId, JSON.stringify(entry.delivery_escrow_info));
					if (stepX == 5) {
						deliverySessionResponse();
					}

					

						fetchUserMeta('<?php echo $userdata->user_email; ?>', function(error,
							veriffDecision) {
							if (error) {
								console.log("Error fetching buyer veriff decision:", error);
							} else {
								userEscrowVeriffDecision(veriffDecision);
							}
						});

					
				} else {

					jQuery('.escrow-process .progress-container').html('');
					sessionStorage.setItem('totalEscrowSteps', 0);
					updateEscrowStep(0);
					jQuery('.escrow-process').addClass('d-none');
					var uniqueId = '';
					jQuery('#buyerDeliveryInfo').val(uniqueId);

				}





				var transactionSummary = `
<div class="bg-light radiusx">
 <div class="row m-0 my-3 col-12">
 <span class="h5 mr-3">Transaction Summary</span>  <span class="text-dark">${meta['select-2'] || ''} ${meta['select-1'] || ''} ${meta['text-3'] || ''} VIN: ${meta['select-11'] || ''}</span>
 </div>      
  <div class="col-12 d-flex font-14 my-1"><span class="mr-5">Subtotal</span>
            <span class="cad-price-format">CA${formatCalCadPrice(meta["number-3"] || 0)}</span>
</div>         
<div class="row my-3 mx-0 text-dark border-top border-bottom small">
    <div class="col-12 col-md-6 border-right">
    <div class="p-2">
        <span class="my-2 text-primary">For Buyers</span>
        <div class="d-flex justify-content-between font-14 my-1"><span class="">Buyer Price:</span><span>${formatCalCadPrice(meta["currency-1"] || 0)}</span></div>
        <div class="d-flex justify-content-between font-14 my-1"><span class="">Trbo Swift fee paid by:<span class="text-primary">${meta["select-16"] || ''}</span></span>
            <div class="buyer-escrow-fee"> <span class="buyer-fee-cal">${formatCalCadPrice(meta["number-7"] || 0)}</span></div>
        </div>
        <div class="d-flex justify-content-between font-14 my-1"><span class="">Shipping fee paid by:<span class="text-primary">Buyer</span></span>
            <div <span class="cad-price-format">${formatCalCadPrice(meta["number-5"] || 0)}</span></div>
        </div>
        
    </div>
    </div>
    <div class="col-12 col-md-6">
    <div class="p-2">
        <span class="my-2 text-primary">For Sellers</span>
        <div class="d-flex justify-content-between font-14 my-1"><span class="">Shipping fee paid by:<span class="text-primary">Seller</span></span> <span class="cad-price-format">${formatCalCadPrice(meta["number-4"] || 0)}</span>
        </div>
        <div class="d-flex justify-content-between font-14 my-1"><span class="">Trbo Swift fee paid by:<span class="text-primary">${meta["select-17"] || ''}</span></span>
            <div class="seller-escrow-fee"> <span class="seller-fee-cal">${formatCalCadPrice(meta["number-6"] || 0)}</span></div>
        </div>
        <div class="d-flex justify-content-between font-14 my-1"><span  class="">Lien Holder Pay Off Fee</span><span class="cad-price-format">${formatCalCadPrice(extractNumericValue(meta["checkbox-9"] || 0))}</span></div>
        
        
        
    </div>
    </div>
</div>
<div class="row my-3 mx-0 text-dark small ">
    <div class="col-12 col-md-6"><div class="d-flex justify-content-between font-14 my-1"><span class="">Total to be paid by Buyer:</span><span class="cad-price-format">${formatCalCadPrice(meta["number-3"] || 0)}</span></div></div>
    <div class="col-12 col-md-6"><div class="d-flex justify-content-between font-14 my-1"><span class="">Seller Proceeds:</span> <span class="cad-price-format">${formatCalCadPrice(meta["number-2"] || 0)}</span></div></div>
</div>
</div>
`;
				jQuery('.escrow-entry-transaction-summary').html(transactionSummary);



				/*   var html ='<ul>';
				   
				  $.each(meta, function(key, value) {
				     html += '<li><strong>' + key + ':</strong> ' + value + '</li>';
				   });
				   
				   html += '</ul>';
				   
				   jQuery('.escrow-entry-details .turbobidescrow-data').html(html);
				   
				   */


			} else {
				jQuery('.escrow-entry-details .turbobidescrow-data').html(
					'<p>Error fetching escrow details.</p>');
			}
		},
		error: function(error) {
			jQuery('.escrow-entry-details .turbobidescrow-data').html(
				'<p>Error fetching entry details.</p>');
			console.log(error);
		}
	});
}



function setEscrowRadioValue(selector, value) {
	if (value === 'Yes') {
		jQuery(selector + ' input[type="radio"][value="Yes"]').prop('checked', true);
	} else if (value === 'No') {
		jQuery(selector + ' input[type="radio"][value="No"]').prop('checked', true);
	}
}

var escrowTrasBuyerProcess = `

  <div class="progress" id="progress"></div>
        <div class="step-wrap active" data-step="1">
            <div class="circle"><span class="step-title">1</span></div>
            <p class="text">Agreement</p>
        </div>
        <div class="step-wrap" data-step="2">
            <div class="circle"><span class="step-title">2</span></div>
            <p class="text">Payment</p>
        </div>

        <div class="step-wrap" data-step="3">
            <div class="circle"><span class="step-title">3</span></div>
            <p class="text">Seller Inspection</p>
        </div>
        
        <div class="step-wrap" data-step="4">
            <div class="circle"><span class="step-title">4</span></div>
            <p class="text">Vehicle Verification </p>
        </div>
        
        <div class="step-wrap" data-step="5">
            <div class="circle"><span class="step-title">5</span></div>
            <p class="text">Delivery</p>
        </div>
       
        <div class="step-wrap" data-step="6">
            <div class="circle"><span class="step-title">6</span></div>
            <p class="text">Complete</p>
        </div>
`;


var escrowTransSellerProcess = `

  <div class="progress" id="progress"></div>
        <div class="step-wrap active" data-step="1">
            <div class="circle"><span class="step-title">1</span></div>
            <p class="text">Agreement</p>
        </div>
        <div class="step-wrap" data-step="2">
            <div class="circle"><span class="step-title">2</span></div>
            <p class="text">Payment</p>
        </div>
        
        <div class="step-wrap" data-step="3">
            <div class="circle"><span class="step-title">3</span></div>
            <p class="text">Seller Inspection</p>
        </div>
        <div class="step-wrap" data-step="4">
            <div class="circle"><span class="step-title">4</span></div>
            <p class="text">Delivery</p>
        </div>
       
        <div class="step-wrap" data-step="5">
            <div class="circle"><span class="step-title">5</span></div>
            <p class="text">Seller Payment</p>
        </div>
`;



function fetchEscrowDocumentFiles(documentId, documentName) {
	jQuery('#loadingSpinner').show();
	var entryId = parseInt(jQuery('#escrow_entry_id').val());
	var formData = new FormData();
	formData.append("action", "get_documents_from_server");
	formData.append("form_id", 330325); // Replace with your form ID
	formData.append("entry_id", entryId);
	formData.append('documentId', documentId);
	formData.append('documentName', documentName);

	addAdditionalEntryData(formData)
		.done(function(res) {
			jQuery('#loadingSpinner').hide();
			console.log('Vehicle ownership:', res);

			if (res.success) {
				let proofFiles = ""; // Initialize the variable properly

				// Only process the last document in the response
				if (res.data.length > 0) {
					const lastDocument = res.data[res.data.length - 1];
					lastDocument.doc_files.forEach(function(fileUrl) {
						if (fileUrl.endsWith('.pdf')) {
							proofFiles = `
								<a class="col-12" href="${fileUrl}" target="_blank">
									View PDF file
								</a><br>
								<pdf-viewer src="${fileUrl}"></pdf-viewer><br>
							`;
						} else if (
							fileUrl.endsWith('.jpg') || 
							fileUrl.endsWith('.jpeg') || 
							fileUrl.endsWith('.png') || 
							fileUrl.endsWith('.svg')
						) {
							proofFiles = `
								<a class="col-12" href="${fileUrl}" target="_blank">
									<img style="width:100%; height:100%; padding:10px; border-radius:10px;" src="${fileUrl}" />
								</a><br><br>
							`;
						} else {
							proofFiles = `
								<a class="btn btn-primary rounded-pill" href="${fileUrl}" target="_blank">
									View File
								</a><br>
							`;
						}
					});
				}

				// Update the container with the last document's proof files
				jQuery('#escrowSellerDocProofPrevContainer').html(proofFiles);
			}
		})
		.fail(function(error) {
			alert('Error finding deal documents', error);
			console.error("Error:", error);
		});
}





jQuery('.escrowSellerProcessComplete').on('click', function(){
	const meta = JSON.parse(sessionStorage.getItem('@current-deal-meta-data'));
	showGlobalAlert('success', `<h3>Thank you for providing your payment information for the 2023 Tesla Model. Your payment for ${formatCalCadPrice(meta["number-2"] || 0)}  is currently being processed.</h3>`)

})


function formatCalCadPrice(value) {
	let number = parseFloat(value);
	if (isNaN(number)) return value;
	return 'CA$' + number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}


function userEscrowVeriffDecision(veriffDecision) {
	console.log("veriffDecision vv:", veriffDecision?.verification?.status);
	if (veriffDecision && veriffDecision.verification && veriffDecision.verification.status === "approved") {
		var currentUser = sessionStorage.getItem('@currentEscrowUserType');
					if(currentUser === 'seller'){
					jQuery('.escrowSellerVeriffStatus').text('Verified');
					jQuery('.seller-custom-veriff-button').hide();
					jQuery('.escrowSellerProcessComplete').prop('disabled', false);
					jQuery('.kycVerificationAfterNext').prop('disabled', false);

					}else{
					jQuery('.escrowBuyerVeriffStatus').text('Verified');
					jQuery('.buyer-custom-veriff-button').hide();
					jQuery('.escrowSellerProcessComplete').prop('disabled', false);
					jQuery('.kycVerificationAfterNext').prop('disabled', false);
					
					}
	} else {
		veriffMountAdd();
		jQuery('.kycVerificationAfterNext').prop('disabled', true);
		jQuery('.escrowSellerProcessComplete').prop('disabled', true);
	}
}




function getCarFaxReport() {
	const vehicleVin = jQuery('#escrow_entry_vehicle_vin').val();

	const faxData = sessionStorage.getItem('escrow_carfax_lien_result');

	//  if (faxData) {
	// 	showGlobalAlert('success', 'You have already searched for Lien. You can get only once the lien information!');
	// 	return;
	// }

	// API URL
	const apiUrl = `${window.location.origin}/rancoded-json/api/v1/lien-report`;

	// Show loading spinner
	jQuery('#loadingSpinner').show();

	// Send AJAX POST request
	jQuery.ajax({
		url: apiUrl,
		type: 'POST',
		data: JSON.stringify({
			vin: '3VWE57BU9KM063613'
		}),
		contentType: 'application/json',
		success: function(res) {
			// alert('Fetching the Carfax report successfully.', res);
			console.log('Fetching the Carfax report successfully.', res);
			escrowCarFaxData(res.data);
			if (res.success && res.data.LienExpressProvince || res.data.VhrReportHideLiensUrl != 'No report available') {
				displayLienReport(res.data);
				showGlobalAlert('error', `<h3>Vehicle does have a lien  on it!</h3>`);
			} else {
				displayNoLienFound();
				showGlobalAlert('success', `<h3>Congratulations, No Lien found!</h3>`);
			}
		},
		error: function(err) {
			console.error('Error:', err);
			alert('An error occurred while fetching the Carfax report. Please try again later.', err
				.responseText);
		},
		complete: function() {
			jQuery('#loadingSpinner').hide(); // Hide spinner
		},
	});
}


function escrowCarFaxData(faxInfo) {
	var entryId = parseInt(jQuery('#escrow_entry_id').val());


		const seller_email = jQuery('#escrow_entry_seller_email').val();
		const buyer_email = jQuery('#escrow_entry_buyer_email').val();
		const vehicle_name = jQuery('#escrow_entry_vehicle_name').val();
		const vehicle_vin = jQuery('#escrow_entry_vehicle_vin').val();
	// console.log('entry status:', entry)

	const formData = new FormData();
	formData.append("action", "add_additional_escrow_info");
	formData.append("form_id", 330325);
	formData.append("entry_id", entryId);
	formData.append("data_meta", 'escrow_carfax_lien_result');
	formData.append("form_name", "Carfax lien result");
	formData.append("form_title", `Carfax lien result`);
	formData.append('escrow_buyer_email', buyer_email);
	formData.append('escrow_seller_email', seller_email);
	formData.append("vehicle_name", vehicle_name);
	formData.append("vehicle_vin", vehicle_vin);
	formData.append("additional_info", JSON.stringify(faxInfo));

	addAdditionalEntryData(formData)
		.done(function(res) {
			if (res.success) {
				const statusKey = 'escrow_carfax_lien_result';
				if (res.data[statusKey]) {
					const data = res.data[statusKey]
					console.log('Lien data:', data);
					jQuery('#buyerVVToNext').prop("disabled", false);
				}
			} 
		})
		.fail(function(error) {
			console.error("Error:", error);
			// alert("Error updating status.");
			showGlobalAlert('error', `<h3>Error updating status: ${error}</h3>`)
		});

}


jQuery('.escrowPickupSellerNextBtn').on('click', function() {
	var entryId = parseInt(jQuery('#escrow_entry_id').val());
		const seller_email = jQuery('#escrow_entry_seller_email').val();
		const buyer_email = jQuery('#escrow_entry_buyer_email').val();
		const vehicle_name = jQuery('#escrow_entry_vehicle_name').val();
		const vehicle_vin = jQuery('#escrow_entry_vehicle_vin').val();

			
	// console.log('entry status:', entry)

	const formData = new FormData();
	formData.append("action", "add_additional_deal_info");
	formData.append("form_id", 330325);
	formData.append("entry_id", entryId);
	formData.append("data_meta", 'vehicle_pickup_details');
	formData.append("form_name", "Vehicle Pickup Details");
	formData.append("form_title", `Vehicle Pickup Details`);
	formData.append('escrow_buyer_email', buyer_email);
	formData.append('escrow_seller_email', seller_email);
	formData.append("vehicle_name", vehicle_name);
	formData.append("vehicle_vin", vehicle_vin);
	formData.append('text-14', jQuery('#escrowPickUpAddress').val());
	formData.append('text-15', jQuery('#escrowDropoffDetails').val());
	formData.append('date-1', jQuery('#escrowVehiclePickupDate').val());
	formData.append('escrowOdometer', jQuery('#escrowOdometer').val());
	formData.append('escrowWaiver', jQuery('#escrowWaiver').val());

	addAdditionalEntryData(formData)
		.done(function(res) {
			if (res.success) {
				
					console.log('Vehicle Pickup Details:', res);

					
					escrowMakeNextStep();
					showGlobalAlert('', `<h3>Vehicle Pickup Details Updated</h3>`)
			} 
		})
		.fail(function(error) {
			console.error("Error:", error);
			// alert("Error updating status.");
			showGlobalAlert('error', `<h3>Error updating info: ${error}</h3>`)
		});

});




function displayLienReport(data) {
	const resultHtml = `
        <div class="col-12 row text-white font-12">
            <div class="col-12 col-md-6">
                <p><strong>Vehicle:</strong> ${data.VehicleYear} ${data.VehicleMake} ${data.VehicleModel}</p>
                <p><strong>Lienholder:</strong> ${data.LienExpressProvince || 'Not available'}</p>
                <p><strong>Date of Search:</strong> ${new Date().toLocaleDateString()}</p>
            </div>
            <div class="col-12 col-md-6">
                <p><strong>VIN:</strong> ${data.Vin}</p>
                <p><strong>Province:</strong> ${data.LienExpressProvince || 'Not available'}</p>
                <p><strong>Amount Owing:</strong> ${data.AmountOwing || 'Not specified'}</p>
            </div>
        </div>
        <a href="${data.VhrReportUrl}" target="_blank" class="btn btn-primary px-4 rounded-pill mb-2">View Full Report</a>
    `;

	jQuery('.lienSearchResult').html(resultHtml);
}

function displayNoLienFound() {
	const noLienHtml = `
        <h4 class="noLienHolderDetails text-white">Great news—no liens were found!</h4>
        <span class="text-white small">
            "Thank you for using Trbo Swift Lien Verification, powered by our
            partnership with Carfax."
        </span>
    `;

	jQuery('.lienSearchResult').html(noLienHtml);
}



async function sellerVehicleInspectionReport() {
	var vehicle_vin = jQuery('#escrow_entry_vehicle_vin').val();
	var seller_email = jQuery('#escrow_entry_seller_email').val();
	var seller_phone = jQuery('#escrow_entry_seller_phone').val();
	var dealId = sessionStorage.getItem('@deal-entry-id');
	var caseId = `${dealId}-${vehicle_vin}-${seller_email}`;
	// const response = await fetch(`${apiDomain}/api/v1/caseid-inspection?case_id=${caseId}`);
	// const result = await response.json();

	jQuery('#loadingSpinner').show();
	// Open the modal
	jQuery('.documentManagementBody').removeClass('d-none').addClass('d-flex');
	jQuery('.documentManagementBody #documentManageTitle').html('Upload Document');

	jQuery('.documentManagementBody .sendDocumentSection').removeClass('d-block').addClass(
		'd-none');
	jQuery('.documentManagementBody .documentViewSection').removeClass('d-none').addClass(
		'd-block');

	jQuery('.documentManagementBody #documentManageTitle').hide();
	jQuery('.documentManagementBody .documentManagementContainer').removeClass(
			'p-3 customModalWidthHalf')
		.addClass(
			'p-0 border-0 customModalWidthFull');

	jQuery(".documentManagementBody .documentViewSection").html(`<div class="bg-secondary px-1 px-md-4 py-4 text-center text-white"><h5>Seller Inspection Report</h5></div>

    <div class="col-12 px-1 px-md-3 py-3 bg-white">
            <div id="result-info" class="col-12"></div>
            <div class="image-slider col-12"></div>
        </div>`);

	try {
		const apiUrl =
			`<?php echo home_url(); ?>/rancoded-json/api/v1/caseid-inspection?case_id=${caseId}`;
		await jQuery.getJSON(apiUrl, function(res) {

			if (res && res.length > 0) {
				const result = res.sort((a, b) => b - a)[0];
				displayInspectionInfo(result);
				displayImageSlider(result.all_inspection_result.relevantImages);
				console.log("SellerVehicleInspectionReport data: ", res[0]);
			} else {
				console.log(res.error.post_not_found);
				return jQuery(".documentManagementBody .documentViewSection").html(result
					.message);
			}

		}).fail(function() {
			// alert('Error fetch transport data from the API. Please try again.');
			jQuery(".documentManagementBody .documentViewSection").html(`<div class="alert alert-warning py-4  my-4 m-5" role="alert">
 No inspection results have been received yet.
</div>`);
		});
	} catch (error) {

		jQuery(".documentManagementBody .documentViewSection").html(`<div class="alert alert-warning my-4 m-2" role="alert">
 No inspection results have been received yet.
</div>`);

	}

	// console.log(result); 
	// console.log(result['text-12']);



	jQuery('.documentManagementBody').removeClass('d-none').addClass('d-flex');
	jQuery('#loadingSpinner')
		.hide();
}



function displayInspectionInfo(result) {
	let resultInfo = `
            <h5 class="text-primary text-center font-14">Result Status: ${result.all_inspection_result.uploadStatus || ''}</h5>
            <h6 class="text-dark text-center">Case Id: ${result.case_id || '111'}</h6>
            <div class="list-group list-group-flush font-14">
                <div class="row align-items-center justify-content-between">
                    <span style="font-weight:600;">Date</span>
                    <span>${result.all_inspection_result.inspectionId || '14 November 2024, 03:21 PM'}</span>
                </div>
                <div class="row align-items-center justify-content-between">
                    <span style="font-weight:600;">License Plate</span>
                    <span>${result.all_inspection_result.vehicleReadings.licensePlateReading || ''}</span>
                </div>
                <div class="row align-items-center justify-content-between">
                    <span style="font-weight:600;">Result Status</span>
                    <span>${result.all_inspection_result.uploadStatus || ''}</span>
                </div>
                <div class="row align-items-center justify-content-between">
                    <span style="font-weight:600;">Damage Severity Score</span>
                    <span>${result.all_inspection_result.totalLoss.totalLossScore || ''}</span>
                </div>
                <div class="row align-items-center justify-content-between">
                    <span style="font-weight:600;">Repair Workflow</span>
                    <span>${result.all_inspection_result.totalLoss.repairDecision || ''}</span>
                </div>
                <div class="row align-items-center justify-content-between">
                    <span style="font-weight:600;">Message</span>
                    <span>${result.all_inspection_result.preInspection.message || ''}</span>
                </div>
            </div>
        `;

	resultInfo += `<h6 class="text-center mt-3">Damage Report</h6>
        <table id="damage-report-table" class="table table-striped overflow-auto">
            <thead>
                <tr class="font-12 text-dark">
                    <th scope="col">Part</th>
                    <th scope="col">Damage Type</th>
                    <th scope="col">Confidence Score</th>
                    <th scope="col">Severity</th>
                    <th scope="col">Operation</th>
                    <th scope="col">Labour Hrs.</th>
                </tr>
            </thead>
            <tbody>`;

	result.all_inspection_result.preInspection.damagedParts.forEach(part => {
		resultInfo += `
                <tr class="font-12">
                    <td style="color:#333!important">${part.partName || '---'}</td>
                    <td style="color:#333!important">${part.listOfDamages || '---'}</td>
                    <td style="color:#333!important">${(part.confidenceScore * 100).toFixed(0) || '---'}%</td>
                    <td style="color:#333!important">${(part.damageSeverityScore  * 100).toFixed(0) || '---'}%</td>
                    <td style="color:#333!important">${part.laborOperation || '---'}</td>
                    <td style="color:#333!important">${part.laborRepairUnits || '---'}</td>
                </tr>`;
	});


	resultInfo += `</tbody>
        </table>`;
	jQuery('#result-info').html(resultInfo);
}



function displayImageSlider(images) {
	console.log("slick images: ", images);

	// Map image URLs for the main slider
	const imageElements = images.map(image =>
		`<div style="background-color: #000; height: 250px; display: flex; align-items: center; justify-content: center;">
            <img src="${image.originalImageURL}" alt="${image.imageTag}" 
                style="max-width: 100%; max-height: 250px; object-fit: contain;" 
                onerror="this.onerror=null; this.style.display='none'; this.parentElement.style.backgroundColor='#000'; this.parentElement.style.height='250px';">
         </div>`
	);

	// Map image URLs for the navigation slider


	// Add HTML to slider containers
	jQuery('.image-slider').html(imageElements.join('')); // Main slider

	// Initialize main Slick slider
	jQuery('.image-slider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: false,
		infinite: true,
		speed: 300,
		arrows: true,
		autoplay: false,
		fade: true,
		prevArrow: '<span class="slick-prev"><i class="fa-solid fa-chevron-left"></i></span>',
		nextArrow: '<span class="slick-next"><i class="fa-solid fa-chevron-right"></i></span>'
	});


}




// Get Inspection Url And Data
var secretApiKey =
	"c39906b3db22a9ec2d7f611bbd7631ab8b8f36ffb2e5561cf9a664e3288ae95471f2f242a76b189143d17d2997133382623e851172bd22cf2e00417b3c338e4e";

jQuery(document).ready(function($) {


	jQuery(document).on("click", ".getFinanceInspectionUrl", async function() {
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

			const inspectionQr = `http://api.qrserver.com/v1/create-qr-code/?data=${
       webappUrl
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



	$("#generateSellerUrl").click(async function() {
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
	$("#generateBuyerUrl").click(async function() {
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
				success: function(response) {
					if (response.success) {
						resolve(JSON.parse(response.data).token);
					} else {
						reject(new Error("Failed to generate token: " +
							response
							.data
							.message));
					}
				},
				error: function(xhr, status, error) {
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
			.done(function(res) {
				jQuery('#loadingSpinner').hide();
				if (res.success) {
					console.log("Inspection result saved:", res.data);
				} else {
					alert("Error updating info: " + res.data);
				}
			})
			.fail(function(error) {
				console.error("Error:", error);
			});
	}




});
</script>

<script src="<?php echo FRAMREWORK_URI . 'js/js.plugins-slickslider.js'; ?>"></script>


<script src="https://cdn.veriff.me/sdk/js/1.5/veriff.min.js"></script>
<script src="https://cdn.veriff.me/incontext/js/v1/veriff.js"></script>



<script>
var userId = "<?php echo $userdata->ID; ?>";
var userFirstName = "<?php echo $userdata->first_name; ?>";
var userLastName = "<?php echo $userdata->last_name; ?>";
var apiKey = '9d91ff0b-0d5e-4d33-ba79-831a0e76191e'; // Replace with your actual API key
var sharedSecretKey = 'a6a04a00-6327-4e62-8574-e85578831ffd';





// Trigger the verification process on button click

function veriffMountAdd() {
	var currentUser = sessionStorage.getItem('@currentEscrowUserType');
	console.log("Current user: " + currentUser);

	const veriff = Veriff({
		host: 'https://stationapi.veriff.com',
		apiKey: apiKey,
		parentId: currentUser === 'buyer' ? 'buyer-veriff-root' : currentUser === 'seller' ?
			'seller-veriff-root' : '',
		onSession: function(err, response) {
			if (err) {
				console.log('Error starting verification session:', err);
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
				onEvent: function(event) {
					console.log('Veriff event:', event);
					if (event === 'FINISHED') {

						// When verification is finished, fetch the decision
						const sessionId = sessionStorage.getItem('@veriff-session-id');
						if (sessionId) {
							fetchDecision(sessionId);
						}
					}
				}
			});
		}
	});

	// Set parameters before mounting
	veriff.setParams({
		person: {
			givenName: userFirstName,
			lastName: userLastName,
		},
		vendorData: userId
	});

	veriff.mount({
		submitBtnText: 'Get verified'
	});

	let open = false;


	if (currentUser === 'buyer') {

		jQuery('.buyer-custom-veriff-button').on('click', function() {
			if (!open) {
				open = true;
				jQuery('#buyer-veriff-root').show();
			} else {
				open = false;
				jQuery('#buyer-veriff-root').hide();
			}
		});
	} else {
		jQuery('.seller-custom-veriff-button').on('click', function() {
			if (!open) {
				open = true;
				jQuery('#seller-veriff-root').show();
			} else {
				open = false;
				jQuery('#seller-veriff-root').hide();
			}
		});
	}





}

function fetchUserMeta(userEmail, callback) {
	jQuery.ajax({
		url: '<?php echo admin_url("admin-ajax.php"); ?>',
		method: 'POST',
		data: {
			action: 'get_user_meta_by_email',
			user_email: userEmail
		},
		success: function(response) {
			// console.log("fetchUserMeta", response);
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



// Function to calculate HMAC signature
async function calculateHMACSignature(sessionId, sharedSecretKey) {
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
async function fetchDecision(sessionId) {
	const hmacSignature = await calculateHMACSignature(sessionId, sharedSecretKey);

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
				veriffStatusUpdate(data);
			}
		})
		.catch(error => {
			console.log('Error fetching decision:', error);
		});
}


const sessionIdn = sessionStorage.getItem('@veriff-session-id');
if (sessionIdn) {
	fetchDecision(sessionIdn);
}


function veriffStatusUpdate(decision) {
	jQuery.ajax({
		url: '<?php echo admin_url('admin-ajax.php'); ?>',
		type: 'POST',
		dataType: 'json', // Assuming the response will be JSON
		data: {
			action: 'handle_verification',
			decision: decision,
			user_id: <?php echo get_current_user_id(); ?>
		},
		success: function(response) {
			// Check if response is valid and contains the necessary data
			if (response) {
				if (response.data.veriff_decision.verification.status === 'approved') {
					var currentUser = sessionStorage.getItem('@currentEscrowUserType');
					if(currentUser === 'seller'){
					addMetaValue('seller_veriff_status', response.data.veriff_decision.verification.status);
					addMetaValue('KycRequest', 'No')
					jQuery('.escrowSellerVeriffStatus').text('Verified');
					jQuery('.seller-custom-veriff-button').prop('disabled', false);
					jQuery('.escrowSellerProcessComplete').prop('disabled', false);

					}else{
					addMetaValue('buyer_veriff_status', response.data.veriff_decision.verification.status);
					jQuery('.escrowBuyerVeriffStatus').text('Verified');
					jQuery('.buyer-custom-veriff-button').prop('disabled', false);
					}
					
				}
			} else {
				console.log('Invalid response or missing data:', response);
			}
		},
		error: function(xhr, status, error) {
			console.log('AJAX request failed:', status, error);
		}
	});
}


 function addMetaValue(metaName, metaValue) {
		var entryId = parseInt(jQuery('#escrow_entry_id').val());
		const seller_email = jQuery('#escrow_entry_seller_email').val();
		const buyer_email = jQuery('#escrow_entry_buyer_email').val();
		const vehicle_name = jQuery('#escrow_entry_vehicle_name').val();
		const vehicle_vin = jQuery('#escrow_entry_vehicle_vin').val();
	// console.log('entry status:', entry)
	const formData = new FormData();
	formData.append("action", "add_additional_deal_info");
	formData.append("form_id", 330325);
	formData.append("entry_id", entryId);
	formData.append("data_meta", 'car_kyc_status');
	formData.append("form_name", "Meta data");
	formData.append("form_title", `Meta data`);
	formData.append('escrow_buyer_email', buyer_email);
	formData.append('escrow_seller_email', seller_email);
	formData.append("vehicle_name", vehicle_name);
	formData.append("vehicle_vin", vehicle_vin);
	formData.append(metaName, metaValue);

	addAdditionalEntryData(formData)
		.done(function(res) {
			if (res.success) {
					console.log(metaName + ': ', res);
			} 
		})
		.fail(function(error) {
			console.error("Error:", error);
		});

}

</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
	document.getElementById('paymentProofDropArea').addEventListener('click', function() {
		document.getElementById('paymentProofFileInput').click();
	});

	document.getElementById('paymentProofDropArea').addEventListener('dragover', function(event) {
		event.preventDefault();
		event.stopPropagation();
		this.classList.add('dragover');
	});

	document.getElementById('paymentProofDropArea').addEventListener('dragleave', function(event) {
		event.preventDefault();
		event.stopPropagation();
		this.classList.remove('dragover');
	});

	document.getElementById('paymentProofDropArea').addEventListener('drop', function(event) {
		event.preventDefault();
		event.stopPropagation();
		this.classList.remove('dragover');

		const files = event.dataTransfer.files;
		handleFiles(files);
	});

	document.getElementById('paymentProofFileInput').addEventListener('change', function(event) {
		const files = event.target.files;
		handleFiles(files);
	});

	function handleFiles(files) {
		for (const file of files) {
			const reader = new FileReader();

			reader.onload = function(e) {
				const previewElement = createPreviewElement(file, e.target.result);
				document.getElementById('paymentProofPreviewContainer').appendChild(previewElement);
			};

			reader.readAsDataURL(file); // Read the file as a data URL
		}
	}

	// Payment proof close


	document
		.getElementById("bankDPDropArea")
		.addEventListener("click", function() {
			document.getElementById("bankDPFileInput").click();
		});

	document
		.getElementById("bankDPDropArea")
		.addEventListener("dragover", function(event) {
			event.preventDefault();
			event.stopPropagation();
			this.classList.add("dragover");
		});

	document
		.getElementById("bankDPDropArea")
		.addEventListener("dragleave", function(event) {
			event.preventDefault();
			event.stopPropagation();
			this.classList.remove("dragover");
		});

	document
		.getElementById("bankDPDropArea")
		.addEventListener("drop", function(event) {
			event.preventDefault();
			event.stopPropagation();
			this.classList.remove("dragover");

			const files = event.dataTransfer.files;
			handleBankDPFiles(files);
		});

	document
		.getElementById("bankDPFileInput")
		.addEventListener("change", function(event) {
			const files = event.target.files;
			handleBankDPFiles(files);
		});

	function handleBankDPFiles(files) {
		for (const file of files) {
			const reader = new FileReader();

			reader.onload = function(e) {
				const previewElement = createPreviewElement(file, e.target.result);
				document
					.getElementById("bankDPDropPreviewContainer")
					.appendChild(previewElement);
			};

			reader.readAsDataURL(file); // Read the file as a data URL

			jQuery('#bankDPDropArea').removeClass('d-flex').addClass('d-none');
		}
	}



	// Function to create a preview element
	function createPreviewElement(file, dataUrl) {
		const previewElement = document.createElement('div');
		previewElement.className = 'preview-item card d-flex justify-content-center p-2 m-1 col-4';

		const imageElement = document.createElement('img');
		imageElement.src = dataUrl;
		imageElement.alt = file.name;

		const removeButton = document.createElement('button');
		removeButton.textContent = 'X';
		removeButton.className = 'remove-button font-14';

		// Add event listener to remove button
		removeButton.addEventListener('click', function() {
			previewElement.remove(); // Remove the preview element from the DOM
			jQuery('#bankDPDropArea').removeClass('d-none').addClass('d-flex');
		});

		previewElement.appendChild(imageElement);
		previewElement.appendChild(removeButton);

		return previewElement;
	}


	var $paymentProofFileInput = jQuery('#paymentProofFileInput');
	$paymentProofFileInput.on('change', function() {
		jQuery('#loadingSpinner').show();
		var files = $paymentProofFileInput[0].files;
		var entryId = jQuery('#escrow_entry_id').val();
		var seller_email = jQuery('#escrow_entry_seller_email').val();
		var buyer_email = jQuery('#escrow_entry_buyer_email').val();
		var vehicle_name = jQuery('#escrow_entry_vehicle_name').val();
		var vehicle_vin = jQuery('#escrow_entry_vehicle_vin').val();

		if (files.length > 0) {
			var formData = new FormData();
			formData.append('action', 'upload_payment_proof');
			formData.append('form_id', 330325); // Replace with your form ID
			formData.append('entry_id', entryId); // Replace with your entry ID
			formData.append('payment_proof_meta', 'payment_proof');
			formData.append('escrow_seller_email', seller_email);
			formData.append('escrow_buyer_email', buyer_email);
			formData.append('form_name', 'Escrow Payment Proof Form');
			formData.append('form_title', 'Escrow Payment Proof New Data Added');
			formData.append('vehicle_name', vehicle_name);
			formData.append('vehicle_vin', vehicle_vin);

			jQuery.each(files, function(index, file) {
				formData.append('images[]', file, file.name);
			});

			jQuery.ajax({
				url: '<?php echo admin_url("admin-ajax.php"); ?>',
				method: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				success: function(data) {
					jQuery('#loadingSpinner').hide();
					if (data.success) {
						alert('Payment proof uploaded successfully!');
						console.log(data);
					} else {
						alert('Error uploading payment proof: ' + data.data);
					}
				},
				error: function(error) {
					console.error('Error:', error);
					alert('Error uploading payment proof.');
				}
			});
		} else {
			alert('Please select files to upload.');
		}
	});

});


jQuery(document).on('click', '#escrowSellerDetailsSubmit', function() {
	jQuery('#loadingSpinner').show();

	// Get the entryId from session storage
	var entryId = parseInt(jQuery('#escrow_entry_id').val());


	var ghjds = jQuery('#escrowNameReqOwner').val();


	var iuyfgyuid = jQuery('#isEscrowRegisteredOwner input[type="radio"]:checked').val();
	var dyudsksds = jQuery('#isEscrowAnyLiensVehicle input[type="radio"]:checked').val();

	var yujkjjhgdj = jQuery('#isEscrowVehicleBeingPicked').val();

	var wfdjsh = jQuery('#requestedEscrowPickupDate').val();
	var xweidwxx = jQuery('#confirmEscrowVehiclePurchase input[type="radio"]:checked').val();

	if (entryId && wfdjsh && ghjds && wfdjsh && xweidwxx && yujkjjhgdj && iuyfgyuid) {

		// Prepare FormData object
		var formData = new FormData();
		formData.append('action', 'add_additional_deal_info');
		formData.append('form_id', 330325);
		formData.append('entry_id', entryId);
		formData.append("data_meta", "applicant_information");
		formData.append('form_name', 'Seller Details');
		formData.append('form_title', 'Seller Details Updated');
		formData.append('userId', <?php echo $userdata->ID; ?>);



		// Collect values from the sellerInformationPayout section

		formData.append('escrowNameReqOwner', ghjds);
		formData.append('isEscrowRegisteredOwner', iuyfgyuid);
		formData.append('isEscrowAnyLiensVehicle', dyudsksds);
		formData.append('isEscrowVehicleBeingPicked', yujkjjhgdj);
		formData.append('requestedEscrowPickupDate', wfdjsh);
		formData.append('confirmEscrowVehiclePurchase', xweidwxx);



		// Send AJAX request to save the data
		addAdditionalEntryData(formData)
			.done(function(res) {
				jQuery('#loadingSpinner').hide();

				// Handle the response from the AJAX call
				if (res.success) {

					alert('Your information submited successfully.');
				} else {
					alert('Error: Could not submit the funddeal.');
				}
			}).fail(function(error) {
				jQuery('#loadingSpinner').hide();
				console.error("Error:", error);
			});
	} else {
		jQuery('#loadingSpinner').hide();
		alert('All fields are required. Please fill the fields then click on next button ');
	}
});


document.addEventListener('DOMContentLoaded', function() {
jQuery('#escrowSellerDocProofFileInput').on('change', function() {

	var entryId = parseInt(jQuery('#escrow_entry_id').val());
	var sellerDocumentProofFileInput = jQuery('#escrowSellerDocProofFileInput')[0];
	var documentProofFile = sellerDocumentProofFileInput.files[0];

	jQuery('#loadingSpinner').show();

	var documentId = '1';
	var documentName = 'Escrow Vehicle Ownership';

	if (documentProofFile) {
		var formData = new FormData();
		formData.append("action", "submit_document_deal");
		formData.append("form_id", 330325); // Replace with your form ID
		formData.append("entry_id", entryId); // Replace with your entry ID
		formData.append("data_meta", "escrow_seller_document");
		formData.append('form_name', 'Escrow Vehicle Ownership');
		formData.append('form_title', 'Escrow Vehicle Ownership');
		formData.append('documentId', documentId);
		formData.append('documentName', documentName);

		if (documentProofFile) {
			formData.append('images[]', documentProofFile, documentProofFile
				.name); // Append the file if it exists
		}

		addAdditionalEntryData(formData)
			.done(function(res) {
				jQuery('#loadingSpinner').hide();
				// Handle the response from the AJAX call
				console.log('Uploaded Vehicle Ownership', res);
				if (res.success) {
					// alert('Successfully Uploaded Vehicle Ownership')
				} else {
					// alert('Error for submitting the Vehicle Ownership')
				}
			})
			.fail(function(error) {
				alert('Error Vehicle Ownership', error)
				console.error("Error:", error);
			});

	} else {
		alert("Please select files to upload.");
	}
});
});





function saveBankInfoBtn() {
	jQuery('#loadingSpinner').show();
	var entryId = jQuery('#escrow_entry_id').val();
	var seller_email = jQuery('#escrow_entry_seller_email').val();
	var buyer_email = jQuery('#escrow_entry_buyer_email').val();
	var vehicle_name = jQuery('#escrow_entry_vehicle_name').val();
	var vehicle_vin = jQuery('#escrow_entry_vehicle_vin').val();

	var formData = new FormData();
	formData.append('action', 'add_additional_escrow_info');
	formData.append('form_id', 330325); // Replace with your form ID
	formData.append('entry_id', entryId); // Replace with your entry ID
	formData.append('data_meta', 'seller_bank_dp_escrow_info');
	formData.append('form_name', 'Escrow Disbursement Form');
	formData.append('form_title', 'Escrow Seller Disbursement New Data Added');
	formData.append('escrow_seller_email', seller_email);
	formData.append('escrow_buyer_email', buyer_email);
	formData.append('vehicle_name', vehicle_name);
	formData.append('vehicle_vin', vehicle_vin);

	// Get the form data as an object
	var formObject = jQuery('#bankInfoForm').serializeArray();
	var formObjectData = {};

	// Convert the form data into key-value pairs
	jQuery.each(formObject, function(i, field) {
		formObjectData[field.name] = field.value;
	});

	// Store the form data in session storage
	// sessionStorage.setItem('bankInfoForm', JSON.stringify(formObjectData));

	// Get files and add them to FormData
	var files = jQuery('#bankDPFileInput')[0].files;
	if (files.length > 0) {
		jQuery.each(files, function(index, file) {
			formData.append('images[]', file, file.name);
		});
	}

	// Add the serialized form data to additional_info
	formData.append('additional_info', JSON.stringify(formObjectData));

	// Log each formData entry
	// formData.forEach((value, key) => {
	//      console.log(key + ': ' + value);
	// });


	console.log("Clicked for add dp");

	for (var pair of formData.entries()) {
		console.log(pair[0] + ': ' + pair[1]);
	}

	// Call the function and handle the response
	addAdditionalEntryData(formData).done(function(res) {
		// Handle the response from the AJAX call
		jQuery('#loadingSpinner').hide();
		if (res.success) {
			console.log(res);
			if (res.data.seller_bank_dp_escrow_info !== '') {
				alert(
					'Thank you for completing the disbursement form for vehicle payment, please wait while we verify the buyer’s payment! Or now you can go to next step.'
				);
				jQuery('#bankInfoModal').modal('hide');
			}
		} else {
			jQuery('#buyerDeliveryToNext').prop("disabled", true);
			alert('Error updating info: ' + res.data);
		}
	}).fail(function(error) {
		jQuery('#buyerDeliveryToNext').prop("disabled", true);
		console.error('Error:', error);
		alert('Error updating info.');
	});
}
</script>

<input type="hidden" id="buyerDeliveryInfo" value="" />

<script>
jQuery(document).ready(function($) {

	jQuery('#edit-buyer-escrow-delivery').on('click', function() {

		var isEditing = $(this).text() === 'Update';
		var uniqueId = jQuery('#buyerDeliveryInfo').val();

		if (isEditing) {
			jQuery('#edit-buyer-escrow-delivery').addClass('btn-secondary');
			jQuery('#edit-buyer-escrow-delivery').removeClass('btn-outline-secondary');

			// Save data and change back to plain text
			var transportCompany = jQuery('#transport-company-input').val();
			var trackingNumber = jQuery('#tracking-number-input').val();
			var phoneNumber = jQuery('#phone-number-input').val();
			var pickupDate = jQuery('#pickup-date-input').val();

			jQuery('#transport-company-text').text(transportCompany).removeClass('d-none');
			jQuery('#tracking-number-text').text(trackingNumber).removeClass('d-none');
			jQuery('#phone-number-text').text(phoneNumber).removeClass('d-none');
			jQuery('#pickup-date-text').text(pickupDate).removeClass('d-none');

			jQuery('#transport-company-input').addClass('d-none');
			jQuery('#tracking-number-input').addClass('d-none');
			jQuery('#phone-number-input').addClass('d-none');
			jQuery('#pickup-date-input').addClass('d-none');

			// Store data in sessionStorage
			sessionStorage.setItem(uniqueId, JSON.stringify({
				transportCompany: transportCompany,
				trackingNumber: trackingNumber,
				phoneNumber: phoneNumber,
				pickupDate: pickupDate
			}));

			addNewDeliveryInfo();

			// Change button text back to "Edit"
			jQuery(this).text('Edit');
		} else {
			jQuery('#edit-buyer-escrow-delivery').addClass('btn-outline-secondary');
			jQuery('#edit-buyer-escrow-delivery').removeClass('btn-secondary');
			// Change to input fields and allow editing
			jQuery('#transport-company-text').addClass('d-none');
			jQuery('#tracking-number-text').addClass('d-none');
			jQuery('#phone-number-text').addClass('d-none');
			jQuery('#pickup-date-text').addClass('d-none');

			jQuery('#transport-company-input').removeClass('d-none');
			jQuery('#tracking-number-input').removeClass('d-none');
			jQuery('#phone-number-input').removeClass('d-none');
			jQuery('#pickup-date-input').removeClass('d-none');

			// Change button text to "Update"
			jQuery(this).text('Update');
		}
	});


	jQuery('#edit-seller-escrow-delivery').on('click', function() {
		var isEditing = $(this).text() === 'Update';
		var uniqueId = jQuery('#buyerDeliveryInfo').val();

		if (isEditing) {
			jQuery('#edit-seller-escrow-delivery').addClass('btn-secondary');
			jQuery('#edit-seller-escrow-delivery').removeClass('btn-outline-secondary');

			// Save data and change back to plain text
			var transportCompany = jQuery('#transport-company-input').val();
			var trackingNumber = jQuery('#tracking-number-input').val();
			var phoneNumber = jQuery('#phone-number-input').val();
			var pickupDate = jQuery('#pickup-date-input').val();

			jQuery('#transport-company-text').text(transportCompany).removeClass('d-none');
			jQuery('#tracking-number-text').text(trackingNumber).removeClass('d-none');
			jQuery('#phone-number-text').text(phoneNumber).removeClass('d-none');
			jQuery('#pickup-date-text').text(pickupDate).removeClass('d-none');

			jQuery('#transport-company-input').addClass('d-none');
			jQuery('#tracking-number-input').addClass('d-none');
			jQuery('#phone-number-input').addClass('d-none');
			jQuery('#pickup-date-input').addClass('d-none');

			// Store data in sessionStorage
			sessionStorage.setItem(uniqueId, JSON.stringify({
				transportCompany: transportCompany,
				trackingNumber: trackingNumber,
				phoneNumber: phoneNumber,
				pickupDate: pickupDate
			}));

			addNewDeliveryInfo();

			// Change button text back to "Edit"
			jQuery(this).text('Edit');
		} else {
			jQuery('#edit-seller-escrow-delivery').addClass('btn-outline-secondary');
			jQuery('#edit-seller-escrow-delivery').removeClass('btn-secondary');
			// Change to input fields and allow editing
			jQuery('#transport-company-text').addClass('d-none');
			jQuery('#tracking-number-text').addClass('d-none');
			jQuery('#phone-number-text').addClass('d-none');
			jQuery('#pickup-date-text').addClass('d-none');

			jQuery('#transport-company-input').removeClass('d-none');
			jQuery('#tracking-number-input').removeClass('d-none');
			jQuery('#phone-number-input').removeClass('d-none');
			jQuery('#pickup-date-input').removeClass('d-none');

			// Change button text to "Update"
			jQuery(this).text('Update');
		}
	});



});



function deliverySessionResponse() {
	var uniqueId = jQuery("#buyerDeliveryInfo").val();
	if (uniqueId) {
		var storedData = JSON.parse(sessionStorage.getItem(uniqueId));
		jQuery("#buyerDeliveryToNext").prop("disabled", true);

		jQuery("#step-details #transport-company-text").text(
			storedData.transportCompany
		);
		jQuery("#step-details #tracking-number-text").text(
			storedData.trackingNumber
		);
		jQuery("#step-details #phone-number-text").text(storedData.phoneNumber);
		jQuery("#step-details #pickup-date-text").text(storedData.pickupDate);

		jQuery("#step-details #transport-company-input").val(
			storedData.transportCompany
		);
		jQuery("#step-details #tracking-number-input").val(
			storedData.trackingNumber
		);
		jQuery("#step-details #phone-number-input").val(storedData.phoneNumber);
		jQuery("#step-details #pickup-date-input").val(storedData.pickupDate);

		console.log("uniqueId", uniqueId);
		console.log("storedData", storedData);
	}
}

function addNewDeliveryInfo() {
	jQuery('#loadingSpinner').show();
	var uniqueId = jQuery('#buyerDeliveryInfo').val();
	// Save data and change back to plain text
	var transportCompany = jQuery('#transport-company-input').val();
	var trackingNumber = jQuery('#tracking-number-input').val();
	var phoneNumber = jQuery('#phone-number-input').val();
	var pickupDate = jQuery('#pickup-date-input').val();
	var isVehiclePickUp = jQuery(
		'.isPickingUp input[type="radio"]:checked').val();

	jQuery('.isPickingUp').text(transportCompany).removeClass('d-none');

	sessionStorage.setItem(uniqueId, JSON.stringify({
		transportCompany: transportCompany,
		trackingNumber: trackingNumber,
		phoneNumber: phoneNumber,
		pickupDate: pickupDate,
		isVehiclePickUp: isVehiclePickUp
	}));



	if (uniqueId) {
		var storedData = JSON.parse(sessionStorage.getItem(uniqueId));

		var entryId = jQuery("#escrow_entry_id").val();
		var seller_email = jQuery('#escrow_entry_seller_email').val();
		var buyer_email = jQuery('#escrow_entry_buyer_email').val();
		var vehicle_name = jQuery('#escrow_entry_vehicle_name').val();
		var vehicle_vin = jQuery('#escrow_entry_vehicle_vin').val();

		var formData = new FormData();
		formData.append("action", "add_additional_escrow_info");
		formData.append("form_id", 330325); // Replace with your form ID
		formData.append("entry_id", entryId); // Replace with your entry ID
		formData.append("data_meta", "delivery_escrow_info");
		formData.append('form_name', 'Escrow Delivery Info');
		formData.append('form_title', 'Escrow Delivery Info Updated');
		formData.append('escrow_seller_email', seller_email);
		formData.append('escrow_buyer_email', buyer_email);
		formData.append('vehicle_name', vehicle_name);
		formData.append('vehicle_vin', vehicle_vin);

		formData.append("additional_info", JSON.stringify(storedData));

		// Call the function and handle the response
		addAdditionalEntryData(formData)
			.done(function(res) {
				jQuery('#loadingSpinner').hide();
				// Handle the response from the AJAX call
				if (res.success) {
					if (res.data.additional_info !== "") {
						deliverySessionResponse();
						// jQuery("#buyerDeliveryToNext").prop("disabled", false);
						escrowMakeNextStep();
					} else {
						// jQuery("#buyerDeliveryToNext").prop("disabled", true);
						alert("Error updating info: " + res.data);
					}
				} else {
					jQuery("#buyerDeliveryToNext").prop("disabled", true);
					alert("Error updating info: " + res.data);
				}
			})
			.fail(function(error) {
				jQuery("#buyerDeliveryToNext").prop("disabled", true);
				console.error("Error:", error);
				alert("Error updating info.");
			});
	} else {
		jQuery("#buyerDeliveryToNext").prop("disabled", true);
	}
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


<script>
jQuery('#sellerWireTransfer').on('click', function() {
	jQuery('#sellerHyperWalletPayment').prop("checked", false);
	jQuery('#sellerWireTransfer').prop("checked", true);

	var gateway = {
		"Gateway": "Wire Transfer"
	};
	addSellerPaymentGateway(gateway);
});

jQuery('#sellerHyperWalletPayment').on('click', function() {
	jQuery('#sellerHyperWalletPayment').prop("checked", true);
	jQuery('#sellerWireTransfer').prop("checked", false);

	var gateway = {
		"Gateway": "Hyperwallet Payment (Faster)"
	};
	addSellerPaymentGateway(gateway);

});






function addSellerPaymentGateway(gateway) {
	jQuery('#loadingSpinner').show();
	var entryId = jQuery("#escrow_entry_id").val();
	var seller_email = jQuery('#escrow_entry_seller_email').val();
	var vehicle_name = jQuery('#escrow_entry_vehicle_name').val();
	var vehicle_vin = jQuery('#escrow_entry_vehicle_vin').val();

	var formData = new FormData();
	formData.append("action", "add_additional_escrow_info");
	formData.append("form_id", 330325); // Replace with your form ID
	formData.append("entry_id", entryId); // Replace with your entry ID
	formData.append("data_meta", "seller_payment_method");
	formData.append('form_name', 'Escrow Payment Gateway');
	formData.append('form_title', 'Escrow Payment Gateway Updated');
	formData.append('escrow_seller_email', seller_email);
	formData.append('vehicle_name', vehicle_name);
	formData.append('vehicle_vin', vehicle_vin);

	formData.append("additional_info", JSON.stringify(gateway));

	// Call the function and handle the response
	addAdditionalEntryData(formData)
		.done(function(res) {
			jQuery('#loadingSpinner').hide();
			// Handle the response from the AJAX call
			if (res.success) {

			} else {
				console.log("Error updating info: " + res.data);
			}
		})
		.fail(function(error) {
			console.error("Error:", error);
		});

}




const currentUser = sessionStorage.getItem('@currentEscrowUserType');

function escrowStatusBasedUpdateInfo() {
	const statusSession = JSON.parse(sessionStorage.getItem('statusSession') || '{}');

	// If the buyer or seller is approved, update UI based on their steps
	if (statusSession.buyerStatus === 'Approved' || statusSession.sellerStatus === 'Approved') {
		// Buyer actions
		if (statusSession.buyerStep >= 2) {
			jQuery('.escrow-pay-status')
				.removeClass('escrow-warning')
				.addClass('escrow-accepted')
				.text('Approved');
			jQuery('#paymentProofUpload, #paymentProofAgreeBtn, #escrowMakeNextBtn').prop("disabled", false);
		}

		if (currentUser === 'buyer' && statusSession.buyerStep < 2) {
			jQuery('#paymentProofAgreeBtn, #sellerPaymentNext, #escrowMakeNextBtn').prop("disabled", true);
		}

		if (statusSession.buyerStep >= 5 && statusSession.buyerStatus === 'Approved') {
			jQuery('.escrow-delivery-status')
				.removeClass('escrow-warning')
				.addClass('escrow-accepted')
				.text('Approved');
			jQuery('.escrowSellerProcessComplete').prop("disabled", false);
		} else if (currentUser === 'buyer' && statusSession.buyerStep < 5) {
			jQuery('.escrowSellerProcessComplete').prop("disabled", true);
		}

		if (statusSession.sellerStep >= 5 && statusSession.buyerStatus === 'Approved') {
			jQuery('.escrow-payToSeller-status')
				.removeClass('escrow-warning')
				.addClass('escrow-accepted')
				.text('Approved');
			jQuery('.escrowSellerProcessComplete').prop("disabled", false);
		} else if (currentUser === 'buyer' && statusSession.buyerStep < 5) {
			jQuery('.escrowSellerProcessComplete').prop("disabled", true);
		}

		// Seller actions
		if (statusSession.sellerStep >= 3) {
			jQuery('.escrow-inspection-status')
				.removeClass('escrow-warning')
				.addClass('escrow-accepted')
				.text('Approved');
			jQuery('.escrow-pay-status')
				.removeClass('escrow-warning')
				.addClass('escrow-accepted')
				.text('Approved');
		}
	}
}



function turboBidTransportPop() {
	elementorProFrontend.modules.popup.showPopup({
		id: 321412
	});
}

function formatDateToISO(dateStr) {
	let parts;

	// Check if the input is in the format 'MM/DD/YYYY'
	if (dateStr.includes('/')) {
		parts = dateStr.split('/');
		const [mm, dd, yyyy] = parts;

		// Handle year with more than 4 digits
		let correctedYear = yyyy.length > 4 ? yyyy.slice(-4) : yyyy;

		return `${correctedYear}-${mm.padStart(2, '0')}-${dd.padStart(2, '0')}`; // Return in YYYY-MM-DD format
	}

	// Check if the input is in the format 'YYYY-MM-DD'
	if (dateStr.includes('-')) {
		parts = dateStr.split('-');
		const [yyyy, mm, dd] = parts;

		// Handle year with more than 4 digits
		let correctedYear = yyyy.length > 4 ? yyyy.slice(-4) : yyyy;

		return `${correctedYear}-${mm.padStart(2, '0')}-${dd.padStart(2, '0')}`; // Return in YYYY-MM-DD format
	}

	console.log('Invalid date format:', dateStr);
	return '';
}

initializeFileUploadHandler('#escrowSellerDocProofDrop', '#escrowSellerDocProofFileInput',
	'#escrowSellerDocProofPrevContainer',
	'.escrowDocProofUpBtn');
</script>


<div id="loadingSpinner" class="spinner-overlay" style="display:none;">
	<div class="spinner-grow text-light" role="status">
		<span class="sr-only">Loading...</span>
	</div>
</div>


<style>
.spinner-overlay {
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(0, 0, 0, 0.5);
	display: flex;
	justify-content: center;
	align-items: center;
	z-index: 9999;
}

.form-check input{
	margin-top: 0.1rem!important;
    margin-left: -1.25rem!important;
}

.form-check-inline {
   
    padding-left: 15px !important;

}

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
	padding: 0 var(--padding-8xs);
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
	gap: var(--gap-6xs);
	font-size: var(--font-size-lg);
	color: var(--color-black);
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
	padding: 0 0 var(--padding-smi);
	text-align: left;
	font-size: var(--font-size-3xl);
	color: var(--color-darkgoldenrod-100);
	font-family: var(--font-plus-jakarta-sans);
}

.turbobidescrow {
	border-radius: var(--br-3xl);
	flex-direction: row;
	align-items: flex-end;
	justify-content: flex-start;
	padding: var(--padding-xl) var(--padding-base);
	gap: var(--gap-12xl);
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

	.btn.btn-secondary, .btn.btn-outline-secondary{
		width: 100%;
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
	background: #eee;
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


.inspection-section input, .inspection-section select{
	border:none !important;
}
.inspection-section input:focus, .inspection-section input:active, .inspection-section select:focus{
	color:rgba(188, 159, 76, 1);
	border:none !important
}

#bankInfoModal {
	display: none;
	position: fixed;
	top: 0px;
	right: 0;
	bottom: 0;
	left: 0;
	outline: 0;
	z-index: 1000;
	overflow-x: hidden;
	overflow-y: auto;
	/* padding-right: 17px; */
	/* opacity: 1; */
	transition: opacity .15s linear;
	background: #0000008a;
	width: 100%;
	align-items: center;
	justify-content: center;
}

.slick-prev,
.slick-next {
	font-size: 18px;
	color: #333;
	cursor: pointer;
	z-index: 100;
}

.slick-prev:hover,
.slick-next:hover {
	color: #eee;
	background: #fff0;
}

.slick-prev {
	left: 0;
	position: absolute;
	top: 50%;
	cursor: pointer;
	transform: translate(0%, 0%);
	background: #ffffff;
	border-radius: 50px;
	border: 1px solid #eee;
	width: 30px;
	height: 30px;
	display: flex;
	flex-direction: row;
	justify-content: center;
	align-items: center;
}

.slick-next {
	right: 0;
	position: absolute;
	top: 50%;
	cursor: pointer;
	transform: translate(0%, 0%);
	background: #ffffff;
	border-radius: 50px;
	border: 1px solid #eee;
	width: 30px;
	height: 30px;
	display: flex;
	flex-direction: row;
	justify-content: center;
	align-items: center;
}

@media (min-width: 576px) {
	#bankInfoModal .modal-dialog {
		max-width: 70%;
		margin: 1.75rem auto;
	}
}


.font-8 {
	font-size: 8px;
}

.font-10 {
	font-size: 10px;
}

.font-12 {
	font-size: 12px;
}

.font-14 {
	font-size: 14px;
}

.font-16 {
	font-size: 16px;
}

.font-18 {
	font-size: 18px;
}

.font-20 {
	font-size: 20px;
}

.escrow-back-main{
	left: -8px;
    top: -15px;
    z-index: 7;
    width: 35px;
    height: 35px;
    font-size: 8px;
    align-content: center;
	transition-duration: 1s;
}
.escrow-back-main:hover{
	    font-size: 15px;
}
</style>
<?php get_template_part( 'framework/design/account/parts/document-management'); ?>