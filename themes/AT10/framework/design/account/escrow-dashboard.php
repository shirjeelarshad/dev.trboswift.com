<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN, $CORE_AUCTION;





$user_id = get_current_user_id(); // Get the current user ID
	$user_email = $userdata->user_email; 
    $escrow_form_id = 330325;
    $credit_form_id = 330325;


$document_card = get_user_meta($user_id, 'document_proof_file', true);




//Escrow
$escrow1 = __("Paid", "premiumpress");
$escrow2 = __("Under Progress", "premiumpress");
$escrow3 = __("Inspection Report", "premiumpress");
$escrow4 = __("In Transit", "premiumpress");


?>

<style>
.control-label {
	font-size: 12px;
	color: #bc9f4c;
}
</style>


<script>
function showDealerPage(type) {
	const sections = {

		pendingDeals: {
			content: '#list-item-pending-deals',
			menuItem: '.list-item-pending-deals',
		},
		bookedDeals: {
			content: '#list-item-booked-deals',
			menuItem: '.list-item-booked-deals',
		},
		transport: {
			content: '#list-item-transport',
			menuItem: '.list-item-transport',
		},
		inspection: {
			content: '#list-item-inspection',
			menuItem: '.list-item-inspection',
		},
		help: {
			content: '#list-item-help',
			menuItem: '.list-item-help',
		},
		invoices: {
			content: '#list-item-invoices',
			menuItem: '.list-item-invoices',
		},
		documents: {
			content: '#list-item-documents',
			menuItem: '.list-item-documents',
		},
		dealOverviewPage: {
			content: '#deal-overview',
			menuItem: 'text-black',
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



<section class="col-12 d-md-flex m-0 py-3 px-2">
	<div class="col-md-2">
		<ul class="bg-white list-unstyled py-3 my-3 radiusx" id="account_jumplinks"
			style="height:100%; line-height:30px;">
			<li class="list-item-pending-deals account-details-tab-bg px-3 py-2 mb-3"> <a
					onclick="showDealerPage('pendingDeals');" href="javascript:void(0);"
					class="text-decoration-none text-white" data-toggle="tab" role="tab">
					<?php echo __("Escrow","premiumpress") ?> </a> </li>


			<li class="list-item-booked-deals px-3 py-2 mb-3"> <a onclick="showDealerPage('bookedDeals');"
					href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab" role="tab">
					<?php echo __("Completed Escrow","premiumpress") ?> </a> </li>


			<li class="list-item-transport px-3 py-2 mb-3"> <a onclick="showDealerPage('transport');"
					href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab" role="tab">
					<?php echo __("Transport","premiumpress") ?> </a> </li>

			<li class="list-item-inspection px-3 py-2 mb-3"> <a onclick="showDealerPage('inspection');"
					href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab" role="tab">
					<?php echo __("Inspection Reports","premiumpress") ?> </a> </li>

			<li class="list-item-invoices px-3 py-2 mb-3"> <a onclick="showDealerPage('invoices');"
					href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab"
					role="tab"><?php echo __("Invoices","premiumpress") ?> </a> </li>

			<li class="list-item-documents px-3 py-2 mb-3"> <a onclick="showDealerPage('documents');"
					href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab"
					role="tab"><?php echo __("Documents","premiumpress") ?> </a> </li>

			<li class="list-item-help px-3 py-2 mb-3"> <a onclick="showDealerPage('help');" href="javascript:void(0);"
					class="text-decoration-none text-dark" data-toggle="tab" role="tab"> <i
						class="fal fa-heart mr-2"></i> <?php echo __("Help","premiumpress") ?> </a> </li>



			<li class="list-item px-3 py-2"> <a href="<?php echo wp_logout_url(home_url()); ?>"
					class="text-decoration-none text-dark"> <i class="fal fa-sign-out-alt text-danger mr-2"></i>
					<?php echo __("Logout","premiumpress") ?> </a>
			</li>

		</ul>

	</div>


	<div class="col-md-10 p-0">


		<div id="list-item-pending-deals" class="col-12 p-0">

			<h5>Escrow Dashboard</h5>
			<div>
				<div id="showDealsQuickInfoInCards" class="d-flex flex-wrap">

				</div>
			</div>






			<div id="mainPendingDealsSection" class="bg-white position-relative radiusx p-2">


			

				<span>We have exclusive partnerships with some of Canada’s largest lenders to get your
					best-in-market rates.</span>

				<div class="mt-5">
					<a href="<?php echo home_url(); ?>/faq" class="btn btn-outline-secondary rounded-pill px-3" id="financing-step-back">
						Learn more</a>
					<a href="<?php echo home_url(); ?>/escrow" class="btn btn-secondary rounded-pill px-3" id="financing-step-next">New Escrow</a>

				</div>

			</div>

			<div id="mainPendingDealViewSection">

			</div>



		</div>

		<div id="list-item-booked-deals" style="display: none;" class="col-12">

			<h5>Booked Deals</h5>
			<div id="mainBookedDealsSection" class="bg-white position-relative radiusx p-2">

			</div>

		</div>
		<div id="list-item-transport" style="display: none;" class="col-12">

		</div>
		<div id="list-item-inspection" style="display: none;" class="col-12">

		</div>
		<div id="list-item-invoices" style="display: none;" class="col-12">

		</div>
		<div id="list-item-documents" style="display: none;" class="col-12">

		</div>
		<div id="list-item-help" style="display: none;" class="col-12">

		</div>

		<div id="deal-overview" style="display: none;" class="col-12 p-0">

			<ul id="deal-overview-tabs" class="nav justify-content-start nav-pills mb-3" role="tablist">

				<li class="nav-item" role="presentation">
					<a class="deal-tab active" id="pills-applicants-tab" data-toggle="pill"
						data-target="#pills-applicants" type="button" role="tab" aria-controls="pills-applicants"
						aria-selected="true">Applicants</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="deal-tab " id="pills-vehicle-details-tab" data-toggle="pill"
						data-target="#pills-vehicle-details" type="button" role="tab"
						aria-controls="pills-vehicle-details" aria-selected="false">Vehicle Details</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="deal-tab " id="pills-client-documents-tab" data-toggle="pill"
						data-target="#pills-client-documents" type="button" role="tab"
						aria-controls="pills-client-documents" aria-selected="false">Client Documents</a>
				</li>

				<!-- <li class="nav-item" role="presentation">
                    <a class="deal-tab " id="pills-dealer-chat-tab" data-toggle="pill" data-target="#pills-dealer-chat"
                        type="button" role="tab" aria-controls="pills-dealer-chat" aria-selected="false">Dealer Chat</a>
                </li> -->
				<!-- <li class="nav-item" role="presentation">
                    <a class="deal-tab " id="pills-client-chat-tab" data-toggle="pill" data-target="#pills-client-chat"
                        type="button" role="tab" aria-controls="pills-client-chat" aria-selected="false">Client Deal</a>
                </li> -->
				<li class="nav-item" role="presentation">
					<a class="deal-tab " id="pills-notes-tab" data-toggle="pill" data-target="#pills-notes"
						type="button" role="tab" aria-controls="pills-notes" aria-selected="false">Notes</a>
				</li>
				<!-- <li class="nav-item" role="presentation">
                    <a class="deal-tab " id="pills-deals-tab" data-toggle="pill" data-target="#pills-deals"
                        type="button" role="tab" aria-controls="pills-deals" aria-selected="false">Deals</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="deal-tab " id="pills-documents-tab" data-toggle="pill" data-target="#pills-documents"
                        type="button" role="tab" aria-controls="pills-documents" aria-selected="false">Documents</a>
                </li> -->
				<!-- <li class="nav-item" role="presentation">
                    <a class="deal-tab " id="pills-waiver-tab" data-toggle="pill" data-target="#pills-waiver"
                        type="button" role="tab" aria-controls="pills-waiver" aria-selected="false">Waiver</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="deal-tab " id="pills-wholesale-tab" data-toggle="pill" data-target="#pills-wholesale"
                        type="button" role="tab" aria-controls="pills-wholesale" aria-selected="false">Wholesale Bill of
                        Sale</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="deal-tab " id="pills-bill-sale-tab" data-toggle="pill" data-target="#pills-bill-sale"
                        type="button" role="tab" aria-controls="pills-bill-sale" aria-selected="false">Ai Vehicle Inspection</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="deal-tab " id="pills-proxy-tab" data-toggle="pill" data-target="#pills-proxy"
                        type="button" role="tab" aria-controls="pills-proxy" aria-selected="false">Proxy</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="deal-tab " id="pills-credit-report-tab" data-toggle="pill"
                        data-target="#pills-credit-report" type="button" role="tab" aria-controls="pills-credit-report"
                        aria-selected="false">Credit Report</a>
                </li> -->
				<li class="nav-item" role="presentation">
					<a class="deal-tab " id="pills-shipping-tab" data-toggle="pill" data-target="#pills-shipping"
						type="button" role="tab" aria-controls="pills-shipping" aria-selected="false">Shipping</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="deal-tab " id="pills-vendor-info-tab" data-toggle="pill" data-target="#pills-vendor-info"
						type="button" role="tab" aria-controls="pills-vendor-info" aria-selected="false">Vendor</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="deal-tab " id="pills-funding-doc-tab" data-toggle="pill" data-target="#pills-funding-doc"
						type="button" role="tab" aria-controls="pills-funding-doc" aria-selected="false">Funding Doc</a>
				</li>


			</ul>



			<div class="tab-content" id="pills-order-content">

				<div class="tab-pane fade active show" id="pills-applicants" role="tabpanel"
					aria-labelledby="pills-applicants-tab">

					<section class="applicant-card">
						<div class="applicant-header">
							<div class="applicant-info">
								<div class="text-light d-flex font-12"><span class="heading-deal-id mr-2">Deal
										#7542</span>
									<div><span>Role:</span> <strong class="applicantRole text-white">BUYER</strong>
									</div>
								</div>
								<h2 class="applicant-title">Seller Details</h2>
								<div class="applicant-actions align-items-center">
									<div class="font-12"><span style="color:#f1f1f173">KYC Status:</span> <span
											class="seller-kyc-status text-light">Unverified</span></div>
									<button class="seller-send-kyc-btn btn btn-primary  px-3 py-1 rounded-pill">Send KYC
										Request</button>
									<button onClick="updateDealInformation();"
										class="btn update-btn btn-light px-5 py-1 rounded-pill">Update</button>
									<div class="font-12"><span style="color:#fff; font-weight:700;">Vehicle</span> <span
											class="vehicle-name text-light">354534454</span></div>
									<div class="font-12"><span style="color:#fff; font-weight:700;">VIN</span> <span
											class="vehicle-vin text-light">354534454</span></div>
									<div class="font-12"><span style="color:#fff; font-weight:700;">Escrow
											Initiated</span> <span class="applicantRole text-light">354534454</span>
									</div>

								</div>
							</div>
						</div>
					</section>



					<section class="sellerDetails custom-card mb-2">
						<div class="form-row">
							<div class="form-group col-12 col-md-3">
								<label for="firstName" class="field-label">First Name</label>
								<input id="firstName" class="form-control" type="text" value="">
							</div>

							<div class="form-group col-12 col-md-3">
								<label for="lastName" class="field-label">Last Name</label>
								<input id="lastName" class="form-control" type="text" value="">
							</div>


							<div class="form-group col-12 col-md-3">
								<label for="lastName" class="field-label">Contact</label>
								<input id="lastName" class="form-control" type="text" value="">
							</div>


							<div class="form-group col-12 col-md-3">
								<label for="email" class="field-label">E-mail Address</label>
								<input id="email" class="form-control" type="email" value="">
							</div>

						</div>


					</section>



					<div class="applicant-card employment-info">
						<div class="applicant-header">
							<div class="applicant-info">
								<h2 class="applicant-title">Buyer Details </h2>

								<div class="applicant-actions align-items-center">
									<div class="font-12"><span style="color:#f1f1f173">KYC Status:</span> <span
											class="buyer-kyc-status text-light">Unverified</span></div>
									<button class="seller-send-kyc-btn btn btn-primary  px-3 py-1 rounded-pill">Send KYC
										Request</button>


								</div>

							</div>

						</div>

					</div>




					<section class="buyerDetails custom-card">


						<div class="form-row">
							<div class="form-group col-12 col-md-3">
								<label for="firstName" class="field-label">First Name</label>
								<input id="firstName" class="form-control" type="text" value="">
							</div>




							<div class="form-group col-12 col-md-3">
								<label for="lastName" class="field-label">Contact</label>
								<input id="lastName" class="form-control" type="text" value="">
							</div>
							<div class="form-group col-12 col-md-3">
								<label for="lastName" class="field-label">Last Name</label>
								<input id="lastName" class="form-control" type="text" value="">
							</div>


							<div class="form-group col-12 col-md-3">
								<label for="email" class="field-label">E-mail Address</label>
								<input id="email" class="form-control" type="email" value="">
							</div>

						</div>


					</section>




					<section class="applicant-card employment-info">
						<div class="applicant-header">
							<div class="applicant-info">
								<h2 class="applicant-title">Transaction Details</h2>

							</div>

						</div>

					</section>



					<section class="transactionDetails custom-card">

						<div class="form-row">
							<div class="form-group col-md-3">
								<label for="current-employer" class="info-label">Current Employer</label>
								<input type="text" id="current-employer" class="form-control current-employer-name"
									value="">
							</div>
							<div class="form-group col-md-3">
								<label for="position" class="info-label">Position</label>
								<input type="text" id="position" class="form-control current-employer" value="">
							</div>
							<div class="form-group col-md-3">
								<label for="phone-number" class="info-label">Phone number</label>
								<input type="tel" id="phone-number" class="form-control current-employer" value="">
							</div>
							<div class="form-group col-md-3">
								<label for="time-at-employer" class="info-label">Time at Employer</label>
								<input type="text" id="time-at-employer" class="form-control current-employer" value="">
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-3">
								<label for="street-address" class="info-label">Street Address</label>
								<input type="text" id="street-address" class="form-control current-employer">
							</div>
							<div class="form-group col-md-3">
								<label for="city" class="info-label">City</label>
								<input type="text" id="city" class="form-control current-employer" value="">
							</div>
							<div class="form-group col-md-3">
								<label for="city" class="info-label">City</label>
								<input type="text" id="city" class="form-control current-employer" value="">
							</div>
							<div class="form-group col-md-3">
								<label for="postal-code" class="info-label">Postal Code</label>
								<input type="text" id="postal-code" class="form-control current-employer">
							</div>
						</div>



					</section>





					<!-- Tab of content close -->

				</div>
				<div class="tab-pane fade" id="pills-vehicle-details" role="tabpanel"
					aria-labelledby="pills-vehicle-details-tab">


					<section class="applicant-card vehicle-details-header align-items-center">

						<div class="d-md-flex align-items-center" style="gap:10px">
							<h2 class="applicant-title">Vehicle Details</h2>

						</div>



						<!-- Another block  -->

						<div class="applicant-actions align-items-center">

							<div class="font-12"><span style="color:#fff; font-weight:700;">Vehicle</span>
								<span class="vehicle-name text-light">354534454</span>
							</div>
							<div class="font-12"><span style="color:#fff; font-weight:700;">VIN</span> <span
									class="vehicle-vin text-light">354534454</span></div>
							<div class="font-12"><span style="color:#fff; font-weight:700;">Escrow
									Initiated</span> <span class="applicantRole text-light">354534454</span>
							</div>

						</div>

					</section>

					<div class="custom-card vehicle-vin-section">

						<div class="form-row">

							<div class="form-group col-12 col-md-6">
								<label for="vin-input" class="vin-label">VIN</label>
								<input type="text" id="vin-input" class="form-control stock-input" />
							</div>

							<div class="form-group col-12 col-md-6">
								<label for="purchase-price" class="price-label">
									Price (CAD)</label>
								<div class="input-group ">
									<div class="input-group-prepend">
										<span class="input-group-text"
											style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
									</div>
									<input type="text" id="purchase-price" class="form-control" aria-label="Purchase
                                        Price">

								</div>
							</div>

							<div class="form-group col-12 col-md-6">
								<label for="make-input" class="stock-label">Make</label>
								<input type="text" id="make-input" class="form-control make-input" />
							</div>

							<div class="form-group col-12 col-md-6">
								<label for="model" class="info-label">Model
								</label>
								<input type="text" id="model-input" class="form-control model-input" />
							</div>

							<div class="form-group col-12 col-md-6">
								<label for="year" class="info-label">Year
								</label>
								<select type="text" id="year" class="form-control co-app">
									<option>2024 </option>
									<option>2023 </option>
									<option>2022 </option>
									<option>2021 </option>
									<option>2020 </option>
									<option>2019 </option>
									<option>2018 </option>
									<option>2017 </option>
									<option>2016 </option>
									<option>2014 </option>
									<option>2013 </option>
									<option>2012 </option>
									<option>2011 </option>
									<option>2010 </option>
									<option>2009 </option>
									<option>2008 </option>
									<option>2007 </option>
									<option>2006 </option>
									<option>2005 </option>
									<option>2004 </option>
									<option>2003 </option>
									<option>2002 </option>
									<option>2001 </option>
									<option>2000 </option>
									<option>1999 </option>
									<option>1998 </option>
									<option>1997 </option>
									<option>1996 </option>
									<option>1995 </option>
									<option>1994 </option>
									<option>1993 </option>
									<option>1992 </option>
									<option>1991 </option>
									<option>1990 </option>
									<option>1989 </option>
									<option>1988 </option>
									<option>1987 </option>
									<option>1986 </option>
									<option>1985 </option>
									<option>1984 </option>
									<option>1983 </option>
									<option>1982 </option>
									<option>1981 </option>
									<option>1980 </option>
									<option>1979 </option>
									<option>1978 </option>
									<option>1977 </option>
									<option>1976 </option>
									<option>1975 </option>
									<option>1974 </option>
									<option>1973 </option>
									<option>1972 </option>
									<option>1971 </option>
									<option>1970 </option>
									<option>1969 </option>
									<option>1968 </option>
									<option>1967 </option>
									<option>1966 </option>
									<option>1965 </option>
									<option>1964 </option>
									<option>1963 </option>
									<option>1962 </option>
									<option>1961 </option>
									<option>1960 </option>


								</select>
							</div>


							<div class="form-group col-12 col-md-6">
								<label for="mileage-input" class="mileage-label">Odometer
									(Km)</label>
								<input type="text" id="mileage-input" class="form-control stock-input" />
							</div>

							<div class="form-group col-12 col-md-6">
								<label for="model" class="info-label">Color
								</label>
								<input type="text" id="color-input" class="form-control color-input" />
							</div>

							<div class="form-group col-md-6">
								<label for="applicantProvince" class="info-label">Which province is the vehicle
									registered in </label>
								<select type="text" id="applicantProvince" class="form-control vendor-province">

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

							<div class="form-group col-md-12">
								<label for="vehicleDetailsSectionNote" class="info-label">Notes</label>
								<textarea class="form-control bg-light p-2" id="vehicleDetailsSectionNote"
									placeholder="Enter a note ( Max 500 chars )" rows="3"
									style="min-height: 70px; border-radius:10px;"></textarea>
							</div>

						</div>


						<div class="text-right">
							<button
								class="vehicle-info-update-btn btn update-btn btn-secondary px-5 py-1 rounded-pill">Save</button>
						</div>






					</div>


				</div>




				<div class="tab-pane fade" id="pills-client-documents" role="tabpanel"
					aria-labelledby="pills-client-documents-tab">




					<section class="documents">

						<div class="col-12 d-flex py-3 px-2 align-items-center">
							<div class="col-md-3">
								<h5 class="vehicle-title">Client Documents</h5>
							</div>
							<div class="col-12 col-md-4">
								<div class="client-doc-icons d-flex flex-wrap">

									<a href="javascript:void(0);" class="icon-wrapper"><i class="fas fa-check"></i></a>
									<a href="javascript:void(0);" class="icon-wrapper"><i
											class="fas fa-exclamation"></i></a>

									<a href="javascript:void(0);" class="icon-wrapper">
										<i class="fas fa-upload"></i>
									</a>
									<a href="javascript:void(0);" class="icon-wrapper">
										<i class="fas fa-trash-alt"></i>
									</a>
									<a href="javascript:void(0);" class="icon-wrapper">
										<i class="fas fa-file"></i>
									</a>
									<a href="javascript:void(0);" class="icon-wrapper">
										<i class="fas fa-envelope"></i>
									</a>


								</div>
								<style>
								.client-doc-icons .icon-wrapper {
									width: 35px;
									height: 35px;
									border-radius: 100px;
									background: #fff;
									color: #000;
									border: 1px solid #fff;
									margin: 5px;
									align-items: center;
									justify-content: center;
									display: flex;
								}

								.client-doc-icons .icon-wrapper:hover {
									background: #000;
									color: #fff;
								}
								</style>
							</div>
							<div class="col-md-5 text-right">
								<span class="heading-deal-id mr-2">Deal
									#7542</span>

								<div class="applicant-actions align-items-center justify-content-end">

									<div class="font-12"><span style="font-weight:700;">Vehicle</span>
										<span class="vehicle-name">354534454</span>
									</div>
									<div class="font-12"><span style="font-weight:700;">VIN</span> <span
											class="vehicle-vin">354534454</span></div>
									<div class="font-12"><span style="font-weight:700;">Escrow
											Initiated</span> <span class="applicantRole">354534454</span>
									</div>

								</div>
							</div>


						</div>




						<div class="p-2">
							<div class="col-12 d-flex">


								<div class="col-md-8 p-0">
									<ul id="deal-overview-tabs" class="nav justify-content-start nav-pills mb-3"
										role="tablist">

										<li class="nav-item" role="presentation">
											<a class="deal-tab active" id="pills-client-document-all-tab"
												data-toggle="pill" data-target="#client-document-all" type="button"
												role="tab" aria-controls="client-document-all"
												aria-selected="true">All</a>
										</li>
										<li class="nav-item" role="presentation">
											<a class="deal-tab " id="pills-client-document-active-tab"
												data-toggle="pill" data-target="#client-document-active" type="button"
												role="tab" aria-controls="client-document-active"
												aria-selected="true">Active</a>
										</li>
										<li class="nav-item" role="presentation">
											<a class="deal-tab " id="pills-client-document-completed-tab"
												data-toggle="pill" data-target="#client-document-completed"
												type="button" role="tab" aria-controls="client-document-completed"
												aria-selected="true">Completed</a>
										</li>
										<li class="nav-item" role="presentation">
											<a class="deal-tab " id="pills-client-document-apps-tab" data-toggle="pill"
												data-target="#client-document-apps" type="button" role="tab"
												aria-controls="client-document-apps" aria-selected="true">Apps</a>
										</li>

									</ul>

								</div>
								<div class="col-md-4 p-0 justify-content-end">

									<div class="input-group rounded-pill border ">

										<div class="input-group-prepend">
											<span class="input-group-text  border-0"
												style="border-radius: 50px 0 0 50px; background: #fff;"><i
													class="fal fa-search"></i></span>
										</div>
										<input type="text" id="search-box-client-doc" class="form-control border-0"
											placeholder="Search here" style="border-radius: 0 50px 50px 0;">

									</div>
								</div>
							</div>


							<div class="tab-content pt-3" id="pills-order-content">
								<div class="tab-pane fade active show" id="client-document-all" role="tabpanel"
									aria-labelledby="pills-client-document-all-tab">
									<!-- All -->


									<div class="card-body p-0" bis_skin_checked="1">
										<div class="overflow-auto" bis_skin_checked="1">
											<table class="table small table-orders">
												<thead>
													<tr>
														<th class="text-start bg-primary text-white "
															style="border-radius:10px 0 0 0;">Document name</th>
														<th class="text-start bg-primary text-white ">Type
														</th>
														<th class="text-start  bg-primary text-white">Client name</th>
														<th class="text-start bg-primary text-white dashhideme">Select
														</th>

														<th class="text-start text-white  bg-primary  dashhideme">
															Status</th>
														<th class="text-end text-white  bg-primary  dashhideme"
															style="border-radius:0 10px 0 0;"></th>
													</tr>
												</thead>
												<tbody class="bg-white" id="client-document">
													<tr class="row-1" data-upload-name="Buyer Payment Upload"
														data-document-id="1">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Buyer Payment Upload
																</span>
																<span class="small pt-1 doc-date" style="color:#909090">
																</span>
															</div>
														</td>
														<td class="text-start text-dark">
															Dealer</span>
														</td>
														<td class="text-center text-muted text-dark">
															<div
																class="applicantNameFromFinance d-flex align-items-center">
																<img class="img-fluid mr-2"
																	style="max-width:35px; max-height:35px; border-radius:100px;"
																	src="<?php if($CORE->USER('get_avatar', $userdata->ID)){echo $CORE->USER('get_avatar', $userdata->ID); }else{ echo home_url() . '/wp-content/uploads/2024/09/user-profile.png'; } ?>"
																	alt="User Profile Image" />
																<?php echo $userdata->first_name ?>
																<?php echo $userdata->last_name ?>
															</div>
														</td>
														<td class="text-start text-dark">
															<span>
																+ Generate New
															</span>
														</td>
														<td class="doc-row-status text-end">
															<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Uncompleted</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-2" data-upload-name="Ai Vehicle Inspection"
														data-document-id="2">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Ai Vehicle Inspection
																</span>
																<span class="small pt-1 doc-date" style="color:#909090">
																</span>
															</div>
														</td>
														<td class="text-start text-dark">
															Dealer</span>
														</td>
														<td class="text-center text-muted text-dark">
															<div
																class="applicantNameFromFinance d-flex align-items-center">
																<img class="img-fluid mr-2"
																	style="max-width:35px; max-height:35px; border-radius:100px;"
																	src="<?php if($CORE->USER('get_avatar', $userdata->ID)){echo $CORE->USER('get_avatar', $userdata->ID); }else{ echo home_url() . '/wp-content/uploads/2024/09/user-profile.png'; } ?>"
																	alt="User Profile Image" />
																<?php echo $userdata->first_name ?>
																<?php echo $userdata->last_name ?>
															</div>

														</td>
														<td class="text-start text-dark">
															<span>
																+ Generate New
															</span>
														</td>
														<td class="doc-row-status text-end">
															<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Uncompleted</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-3" data-upload-name="Escrow Transaction"
														data-document-id="3">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Escrow Transaction
																</span>
																<span class="small pt-1 doc-date" style="color:#909090">
																</span>
															</div>
														</td>
														<td class="text-start text-dark">
															Dealer</span>
														</td>
														<td class="text-center text-muted text-dark">
															<div
																class="applicantNameFromFinance d-flex align-items-center">
																<img class="img-fluid mr-2"
																	style="max-width:35px; max-height:35px; border-radius:100px;"
																	src="<?php if($CORE->USER('get_avatar', $userdata->ID)){echo $CORE->USER('get_avatar', $userdata->ID); }else{ echo home_url() . '/wp-content/uploads/2024/09/user-profile.png'; } ?>"
																	alt="User Profile Image" />
																<?php echo $userdata->first_name ?>
																<?php echo $userdata->last_name ?>
															</div>

														</td>
														<td class="text-start text-dark">
															<span>
																+ Generate New
															</span>
														</td>
														<td class="doc-row-status text-end">
															<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Uncompleted</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-4" data-upload-name="Carfax Check"
														data-document-id="4">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Carfax Check
																</span>
																<span class="small pt-1 doc-date" style="color:#909090">
																</span>
															</div>
														</td>
														<td class="text-start text-dark">
															Dealer</span>
														</td>
														<td class="text-center text-muted text-dark">
															<div
																class="applicantNameFromFinance d-flex align-items-center">
																<img class="img-fluid mr-2"
																	style="max-width:35px; max-height:35px; border-radius:100px;"
																	src="<?php if($CORE->USER('get_avatar', $userdata->ID)){echo $CORE->USER('get_avatar', $userdata->ID); }else{ echo home_url() . '/wp-content/uploads/2024/09/user-profile.png'; } ?>"
																	alt="User Profile Image" />
																<?php echo $userdata->first_name ?>
																<?php echo $userdata->last_name ?>
															</div>

														</td>
														<td class="text-start text-dark">
															<span>
																+ Generate New
															</span>
														</td>
														<td class="doc-row-status text-end">
															<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Uncompleted</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-5" data-upload-name="KYC Check-Seller"
														data-document-id="5">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">KYC Check-Seller
																</span>
																<span class="small pt-1 doc-date" style="color:#909090">
																</span>
															</div>
														</td>
														<td class="text-start text-dark">
															Dealer</span>
														</td>
														<td class="text-center text-muted text-dark">
															<div
																class="applicantNameFromFinance d-flex align-items-center">
																<img class="img-fluid mr-2"
																	style="max-width:35px; max-height:35px; border-radius:100px;"
																	src="<?php if($CORE->USER('get_avatar', $userdata->ID)){echo $CORE->USER('get_avatar', $userdata->ID); }else{ echo home_url() .'/wp-content/uploads/2024/09/user-profile.png'; } ?>"
																	alt="User Profile Image" />
																<?php echo $userdata->first_name ?>
																<?php echo $userdata->last_name ?>
															</div>

														</td>
														<td class="text-start text-dark">
															<span>
																+ Generate New
															</span>
														</td>
														<td class="doc-row-status text-end">
															<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Uncompleted</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-6" data-upload-name="KYC Check-Buyer"
														data-document-id="6">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">KYC Check-Buyer
																</span>
																<span class="small pt-1 doc-date" style="color:#909090">
																</span>
															</div>
														</td>
														<td class="text-start text-dark">
															Dealer</span>
														</td>
														<td class="text-center text-muted text-dark">
															<div
																class="applicantNameFromFinance d-flex align-items-center">
																<img class="img-fluid mr-2"
																	style="max-width:35px; max-height:35px; border-radius:100px;"
																	src="<?php if($CORE->USER('get_avatar', $userdata->ID)){echo $CORE->USER('get_avatar', $userdata->ID); }else{ echo home_url() . '/wp-content/uploads/2024/09/user-profile.png'; } ?>"
																	alt="User Profile Image" />
																<?php echo $userdata->first_name ?>
																<?php echo $userdata->last_name ?>
															</div>

														</td>
														<td class="text-start text-dark">
															<span>
																+ Generate New
															</span>
														</td>
														<td class="doc-row-status text-end">
															<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Uncompleted</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-7" data-upload-name="Mechanical Inspection "
														data-document-id="7">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Mechanical Inspection
																</span>
																<span class="small pt-1 doc-date" style="color:#909090">
																</span>
															</div>
														</td>
														<td class="text-start text-dark">
															Dealer</span>
														</td>
														<td class="text-center text-muted text-dark">
															<div
																class="applicantNameFromFinance d-flex align-items-center">
																<img class="img-fluid mr-2"
																	style="max-width:35px; max-height:35px; border-radius:100px;"
																	src="<?php if($CORE->USER('get_avatar', $userdata->ID)){echo $CORE->USER('get_avatar', $userdata->ID); }else{ echo home_url() . '/wp-content/uploads/2024/09/user-profile.png'; } ?>"
																	alt="User Profile Image" />
																<?php echo $userdata->first_name ?>
																<?php echo $userdata->last_name ?>
															</div>

														</td>
														<td class="text-start text-dark">
															<span>
																+ Generate New
															</span>
														</td>
														<td class="doc-row-status text-end">
															<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Uncompleted</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-8" data-upload-name="Drivers License "
														data-document-id="8">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Drivers License
																</span>
																<span class="small pt-1 doc-date" style="color:#909090">
																</span>
															</div>
														</td>
														<td class="text-start text-dark">
															Dealer</span>
														</td>
														<td class="text-center text-muted text-dark">
															<div
																class="applicantNameFromFinance d-flex align-items-center">
																<img class="img-fluid mr-2"
																	style="max-width:35px; max-height:35px; border-radius:100px;"
																	src="<?php if($CORE->USER('get_avatar', $userdata->ID)){echo $CORE->USER('get_avatar', $userdata->ID); }else{ echo home_url() . '/wp-content/uploads/2024/09/user-profile.png'; } ?>"
																	alt="User Profile Image" />
																<?php echo $userdata->first_name ?>
																<?php echo $userdata->last_name ?>
															</div>

														</td>
														<td class="text-start text-dark">
															<span>
																+ Generate New
															</span>
														</td>
														<td class="doc-row-status text-end">
															<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Uncompleted</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>

												</tbody>
											</table>
										</div>
									</div>



								</div>
								<div class="tab-pane fade " id="client-document-active" role="tabpanel"
									aria-labelledby="pills-client-document-active-tab">Active</div>
								<div class="tab-pane fade " id="client-document-completed" role="tabpanel"
									aria-labelledby="pills-client-document-completed-tab">Completed</div>
								<div class="tab-pane fade " id="client-document-apps" role="tabpanel"
									aria-labelledby="pills-client-document-apps-tab">Completed</div>
							</div>


						</div>


					</section>
				</div>

				<div class="tab-pane fade" id="pills-client-chat" role="tabpanel"
					aria-labelledby="pills-client-chat-tab">
					<!-- client-chat -->


					<section class="applicant-card ">
						<div class="applicant-header">
							<div class="applicant-info">
								<h2 class="applicant-title">Client Deal- Customer Selection</h2>

							</div>
						</div>



						<!-- Another block  -->

						<div class="d-flex text-white" style="gap:10px;">
							<div class="text-end">
								<p class="heading-vendor-name text-white">Vendor: <strong>Cruze Auto Sales
										INC</strong></p>
								<p class="trim-plan manager-info">Manager: <strong>Trbo Swift Financial</strong></p>
							</div>
							<p class="heading-deal-id">Deal #7542</p>
						</div>

					</section>


					<section class="custom-card">

						<div class="bg-white">
							<h6>Approval</h6>
							<div class="client-deal-approval-details">
								<div class="form-row">
									<div class="form-group col-md-3">
										<label for="approvedAmount" class="info-label">Approved Amount</label>
										<input type="text" id="approvedAmount" class="form-control approvedAmount-name"
											value="">
									</div>

									<div class="form-group col-md-3">
										<label for="lender" class="info-label">Lender</label>
										<input type="text" id="lender" class="form-control Lender-name" value="">
									</div>


									<div class="form-group col-md-3">
										<label for="lenderType" class="info-label">Lender Type</label>
										<input type="text" id="lenderType" class="form-control" value="">
									</div>






								</div>



								<h6 class="mt-3 mb-1">Terms</h6>

								<div class="form-row term-1">



									<div class="form-group col-md-3">
										<label for="paymentAmount" class="info-label">Monthly Payment</label>
										<input type="text" id="paymentAmount" class="form-control" value="">
									</div>

									<div class="form-group col-md-3">
										<label for="biWeeklyPayment" class="info-label">Bi Weekly Payment</label>
										<input type="text" id="biWeeklyPayment" class="form-control" value="">
									</div>


									<div class="form-group col-md-3">
										<label for="approvalTerm" class="info-label">Term</label>
										<input type="text" id="approvalTerm" class="form-control" value="">
									</div>
									<div class="form-group col-md-3">
										<label for="interestRate" class="info-label">Interest Rate</label>
										<input type="text" id="interestRate" class="form-control" value="">
									</div>


								</div>

								<h6 class="mt-3 mb-1 d-none">2nd Term</h6>
								<div class="form-row term-2 d-none">



									<div class="form-group col-md-3">
										<label for="paymentAmount" class="info-label">Monthly Payment</label>
										<input type="text" id="paymentAmount" class="form-control" value="">
									</div>

									<div class="form-group col-md-3">
										<label for="biWeeklyPayment" class="info-label">Bi Weekly Payment</label>
										<input type="text" id="biWeeklyPayment" class="form-control" value="">
									</div>


									<div class="form-group col-md-3">
										<label for="approvalTerm" class="info-label">Term</label>
										<input type="text" id="approvalTerm" class="form-control" value="">
									</div>
									<div class="form-group col-md-3">
										<label for="interestRate" class="info-label">Interest Rate</label>
										<input type="text" id="interestRate" class="form-control" value="">
									</div>


								</div>


								<h6 class="mt-3 mb-1">Products</h6>

								<div class="form-row buyerAcceptedProducts">
									<div class="form-group col-3 col-md-2">
										<label for="warrantyCost" class="info-label">Warranty Cost</label>
										<input type="text" id="warrantyCost" class="form-control warrantyCost" value="">
									</div>

									<div class="form-group col-3 col-md-2">
										<label for="gaapInsurance" class="info-label">GAAP Insurance</label>
										<input type="text" id="gaapInsurance" class="form-control" value="">
									</div>

									<div class="form-group col-3 col-md-2">
										<label for="lifeInsurance" class="info-label">Life Insurance</label>
										<input type="text" id="lifeInsurance" class="form-control" value="">
									</div>

									<div class="form-group col-3 col-md-2">
										<label for="turboBidTransport" class="info-label">Trbo Swift Transport</label>
										<input type="text" id="turboBidTransport" class="form-control" value="">
									</div>
								</div>
							</div>
						</div>

					</section>



					<div class="custom-card col-12 row">
						<div class="col-12 col-md-7">

							<div id="clientNoteSection">
								<div class="mb-3">

									<textarea class="form-control bg-light p-2" id="addClientNoteTextarea"
										placeholder="Enter a message ( Max 500 chars )" rows="3"
										style="min-height: 150px; border-radius:10px;"></textarea>
								</div>
								<div class="mt-3 d-flex">

									<button class="btn btn-primary rounded-pill  px-3" id="addClientNote">Add
										note</button>
								</div>


							</div>
						</div>
						<div class="col-12 col-md-5 approvalDetails row">
							<div class="col-6 ">
								<div id="dealOrder" class="bg-light radiusx p-2"></div>

							</div>
							<div class="col-6">
								<div id="dealDeclinedProducts" class="bg-light radiusx p-2"></div>
							</div>

						</div>
					</div>

					<section class="applicant-card addition-info-header">
						<div class="applicant-header">
							<div class="applicant-info">
								<h2 class="applicant-title">Seller Dashboard/Documents</h2>
								<div class="d-flex align-items-center" style="gap:10px">
								</div>
							</div>
						</div>
					</section>

					<div class="custom-card col-12">

						<div class="px-0 px-md-5 mx-0 mx-md-5">
							<div class="progress-container my-3">
								<div class="progress" id="progress"></div>
								<div class="step-wrap active" data-step="1">
									<div class="circle"><span class="step-title">1</span></div>
									<p class="text">Vehicle Inspection</p>
								</div>
								<div class="step-wrap active" data-step="2">
									<div class="circle"><span class="step-title">2</span></div>
									<p class="text">Application status</p>
								</div>

								<div class="step-wrap active" data-step="3">
									<div class="circle"><span class="step-title">3</span></div>
									<p class="text">Decision</p>
								</div>
								<div class="step-wrap active" data-step="4">
									<div class="circle"><span class="step-title">4</span></div>
									<p class="text">Verification</p>
								</div>
							</div>
						</div>


						<div class="card-body p-0" bis_skin_checked="1">
							<div class="overflow-auto" bis_skin_checked="1">
								<table class="table small table-orders">
									<thead>
										<tr>
											<th class="text-start bg-light text-dark "
												style="border-radius:10px 0 0 0;">Document name</th>
											<th class="text-start bg-light text-dark">Status</th>
											<th class="text-start bg-light text-dark"></th>
											<th class="text-end text-dark  bg-light  dashhideme"
												style="border-radius:0 10px 0 0;"></th>
										</tr>
									</thead>
									<tbody class="bg-white" id="client-document">
										<tr class="row-1" data-upload-name="Vehicle Ownership" data-document-id="1">
											<td class="d-flex" colspan="6">
												<img style="max-width:35px; max-height:35px;"
													src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
													alt="PDF FILE" />
												<div class="d-flex flex-column pl-2">
													<span class="doc-name text-dark">Vehicle Ownership
													</span>
													<span class="small pt-1 doc-date" style="color:#909090">Uploaded
														5th
														Feb,2024</span>
												</div>
											</td>


											<td class="doc-row-status text-end" colspan="1">
												<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
														class="fas fa-circle small mr-2"></i>Uncompleted</span>
											</td>
											<td class="text-start text-dark" colspan="1">
												<a class="dropdown-item view-file-doc d-flex align-items-center text-dark"
													href="javascript:void(0)">
													<i class="far fa-eye"></i> View
												</a>
											</td>
											<td class="text-center" colspan="1">

												<div class="dropdown">
													<button class="btn btn-light dropdown-toggle" type="button"
														data-toggle="dropdown" aria-expanded="false">
														<i class="fa-solid fa-ellipsis-vertical"></i>
													</button>


													<div class="dropdown-menu">
														<a class="dropdown-item file-upload"
															href="javascript:void(0)"><i class="fa-solid fa-upload"></i>
															Upload</a>

														<a class="dropdown-item file-delete"
															href="javascript:void(0)"><i
																class="fa-solid fa-trash-can"></i>
															Delete</a>
														<a class="dropdown-item view-file-doc"
															href="javascript:void(0)"><i class="fa-regular fa-eye"></i>
															View</a>
														<a class="dropdown-item total-file-doc"
															href="javascript:void(0)"><i
																class="fa-solid fa-clipboard-list"></i>
															Total Doc</a>
													</div>
												</div>

											</td>
										</tr>
										<tr class="row-2" data-upload-name="Ai Damage Inspection" data-document-id="2">
											<td class="d-flex" colspan="9">
												<img style="max-width:35px; max-height:35px;"
													src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
													alt="PDF FILE" />
												<div class="d-flex flex-column pl-2">
													<span class="doc-name text-dark">Ai Damage Inspection
													</span>
													<span class="small pt-1 doc-date" style="color:#909090">Uploaded
														5th
														Feb,2024</span>
												</div>
											</td>



											<td class="doc-row-status text-end" colspan="1">
												<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
														class="fas fa-circle small mr-2"></i>Uncompleted</span>
											</td>
											<td class="text-start text-dark" colspan="1">
												<a class="dropdown-item view-file-doc d-flex align-items-center text-dark"
													href="javascript:void(0)">
													<i class="far fa-eye"></i> View
												</a>
											</td>
											<td class="text-center" colspan="1">

												<div class="dropdown">
													<button class="btn btn-light dropdown-toggle" type="button"
														data-toggle="dropdown" aria-expanded="false">
														<i class="fa-solid fa-ellipsis-vertical"></i>
													</button>


													<div class="dropdown-menu">
														<a class="dropdown-item file-upload"
															href="javascript:void(0)"><i class="fa-solid fa-upload"></i>
															Upload</a>

														<a class="dropdown-item file-delete"
															href="javascript:void(0)"><i
																class="fa-solid fa-trash-can"></i>
															Delete</a>
														<a class="dropdown-item view-file-doc"
															href="javascript:void(0)"><i class="fa-regular fa-eye"></i>
															View</a>
														<a class="dropdown-item total-file-doc"
															href="javascript:void(0)"><i
																class="fa-solid fa-clipboard-list"></i>
															Total Doc</a>
													</div>
												</div>

											</td>
										</tr>
										<tr class="row-3" data-upload-name="Mechanic Inspection" data-document-id="3">
											<td class="d-flex" colspan="9">
												<img style="max-width:35px; max-height:35px;"
													src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
													alt="PDF FILE" />
												<div class="d-flex flex-column pl-2">
													<span class="doc-name text-dark">Mechanic Inspection
													</span>
													<span class="small pt-1 doc-date" style="color:#909090">Uploaded
														5th
														Feb,2024</span>
												</div>
											</td>



											<td class="doc-row-status text-end" colspan="1">
												<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
														class="fas fa-circle small mr-2"></i>Uncompleted</span>
											</td>
											<td class="text-start text-dark" colspan="1">
												<a class="dropdown-item view-file-doc d-flex align-items-center text-dark"
													href="javascript:void(0)">
													<i class="far fa-eye"></i> View
												</a>
											</td>
											<td class="text-center" colspan="1">

												<div class="dropdown">
													<button class="btn btn-light dropdown-toggle" type="button"
														data-toggle="dropdown" aria-expanded="false">
														<i class="fa-solid fa-ellipsis-vertical"></i>
													</button>


													<div class="dropdown-menu">
														<a class="dropdown-item file-upload"
															href="javascript:void(0)"><i class="fa-solid fa-upload"></i>
															Upload</a>

														<a class="dropdown-item file-delete"
															href="javascript:void(0)"><i
																class="fa-solid fa-trash-can"></i>
															Delete</a>
														<a class="dropdown-item view-file-doc"
															href="javascript:void(0)"><i class="fa-regular fa-eye"></i>
															View</a>
														<a class="dropdown-item total-file-doc"
															href="javascript:void(0)"><i
																class="fa-solid fa-clipboard-list"></i>
															Total Doc</a>
													</div>
												</div>

											</td>
										</tr>

										<tr class="row-4" data-upload-name="Seller KYC" data-document-id="4">
											<td class="d-flex" colspan="9">
												<img style="max-width:35px; max-height:35px;"
													src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
													alt="PDF FILE" />
												<div class="d-flex flex-column pl-2">
													<span class="doc-name text-dark">Seller KYC
													</span>
													<span class="small pt-1 doc-date" style="color:#909090">Uploaded
														5th
														Feb,2024</span>
												</div>
											</td>



											<td class="doc-row-status text-end" colspan="1">
												<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
														class="fas fa-circle small mr-2"></i>Uncompleted</span>
											</td>
											<td class="text-start text-dark" colspan="1">
												<a class="dropdown-item view-file-doc d-flex align-items-center text-dark"
													href="javascript:void(0)">
													<i class="far fa-eye"></i> View
												</a>
											</td>
											<td class="text-center" colspan="1">

												<div class="dropdown">
													<button class="btn btn-light dropdown-toggle" type="button"
														data-toggle="dropdown" aria-expanded="false">
														<i class="fa-solid fa-ellipsis-vertical"></i>
													</button>


													<div class="dropdown-menu">
														<a class="dropdown-item file-upload"
															href="javascript:void(0)"><i class="fa-solid fa-upload"></i>
															Upload</a>

														<a class="dropdown-item file-delete"
															href="javascript:void(0)"><i
																class="fa-solid fa-trash-can"></i>
															Delete</a>
														<a class="dropdown-item view-file-doc"
															href="javascript:void(0)"><i class="fa-regular fa-eye"></i>
															View</a>
														<a class="dropdown-item total-file-doc"
															href="javascript:void(0)"><i
																class="fa-solid fa-clipboard-list"></i>
															Total Doc</a>
													</div>
												</div>

											</td>
										</tr>

									</tbody>
								</table>
							</div>
						</div>

					</div>



				</div>
				<div class="tab-pane fade" id="pills-notes" role="tabpanel" aria-labelledby="pills-notes-tab">
					<!-- notes -->



					<div class="col-12 d-flex p-0">
						<div class="col-12 col-md-9 px-2 py-3">


							<div class="bg-secondary py-3 px-2 d-flex justify-content-between"
								style="border-radius: 20px 20px 0 0">

								<div id="dealer-note-switcher-container">
									<div id="deals-note-switcher"></div>
								</div>

								<style>
								#dealer-note-switcher-container .toggleContainer::before {
									border-radius: 50px !important;
								}

								#dealer-note-switcher-container .toggleContainer {
									border: 0px !important;
									border-radius: 50px !important;
								}
								</style>




								<img stylw="width:30px; height:30px"
									src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/arrow.svg" />


							</div>
							<div class="bg-white py-3 px-2">

								<div class="input-group rounded-pill border ">

									<div class="input-group-prepend">
										<span class="input-group-text  border-0"
											style="border-radius: 50px 0 0 50px; background: #fff;"><i
												class="fal fa-search"></i></span>
									</div>
									<input type="text" id="search-box-client-doc" class="form-control border-0"
										placeholder="Search activity, notes, email & more..."
										style="border-radius: 0 50px 50px 0;">
									<div class="input-group-append">
										<button class="btn btn-secondary rounded-pill px-3 px-md-5"
											id="deal-notes-search">Search</button>
									</div>


								</div>


								<div class="my-3">


									<ul id="deal-overview-tabs" class="nav justify-content-start nav-pills my-3"
										role="tablist">

										<li class="nav-item" role="presentation">
											<a class="deal-tab" id="pills-deals-notes-Activity-tab" data-toggle="pill"
												data-target="#deals-notes-Activity" type="button" role="tab"
												aria-controls="deals-notes-Activity" aria-selected="true">Activity</a>
										</li>
										<li class="nav-item" role="presentation">
											<a class="deal-tab active" id="pills-deals-notes-Notes-tab"
												data-toggle="pill" data-target="#deals-notes-Notes" type="button"
												role="tab" aria-controls="deals-notes-Notes"
												aria-selected="true">Notes</a>
										</li>
										<li class="nav-item" role="presentation">
											<a class="deal-tab " id="pills-deals-notes-Emails-tab" data-toggle="pill"
												data-target="#deals-notes-Emails" type="button" role="tab"
												aria-controls="deals-notes-Emails" aria-selected="true">Emails</a>
										</li>
										<li class="nav-item" role="presentation">
											<a class="deal-tab " id="pills-deals-notes-Calls-tab" data-toggle="pill"
												data-target="#deals-notes-Calls" type="button" role="tab"
												aria-controls="deals-notes-Calls" aria-selected="true">Calls</a>
										</li>
										<li class="nav-item" role="presentation">
											<div class="dropdown">
												<a class="deal-tab dropdown-toggle btn" style="font-size:12px;"
													type="button" data-toggle="dropdown" aria-expanded="false"
													role="tab">Task</a>


												<div class="dropdown-menu">
													<a class="dropdown-item note-low text-success"
														onclick="showNoteByTask('Low')" href="javascript:void(0)"><i
															class="fal fa-flag"></i> Low</a>
													<a class="dropdown-item note-medium text-warning"
														onclick="showNoteByTask('Medium')" href="javascript:void(0)"><i
															class="fal fa-flag"></i>
														Medium</a>
													<a class="dropdown-item note-high text-danger"
														onclick="showNoteByTask('High')" href="javascript:void(0)"><i
															class="fal fa-flag"></i>
														High</a>

												</div>
											</div>
										</li>
										<li class="nav-item" role="presentation">
											<a class="deal-tab " id="pills-deals-notes-Meetings-tab" data-toggle="pill"
												data-target="#deals-notes-Meetings" type="button" role="tab"
												aria-controls="deals-notes-Meetings" aria-selected="true">Meetings</a>
										</li>

									</ul>

									<div class="tab-content pt-3" id="pills-order-content">
										<div class="tab-pane fade" id="deals-notes-Activity" role="tabpanel"
											aria-labelledby="pills-deals-notes-Activity-tab">
											deals-notes-Activity

										</div>

										<div class="tab-pane fade active show" id="deals-notes-Notes" role="tabpanel"
											aria-labelledby="pills-deals-notes-Notes-tab">
											<!-- deals-notes-Notes -->

											<div class="addDealNoteSection ">

												<?php
                                                    $editID = 0;
                                                $note_content = "";
                                                

                                                $note_content = preg_replace('#<div id="ppt_keywords">(.*?)</div>#', ' ', stripslashes($note_content));

                                                ?>
												<div class="form-group p-2"
													style="background:#F5F7FA; border-radius:11px">
													<div id="textarea_counter" class="text-muted small float-right">

													</div>
													<input type="hidden" name="textarea_counter_hidden" value="<?php if (is_numeric(_ppt(array('lst', 'descmin')))) {
                                                        echo _ppt(array('lst', 'descmin'));
                                                    } else {
                                                        echo 100;
                                                    } ?>" id="textarea_counter_hidden">

													<?php  ?>



													<div class=" position-relative">

														<?php 

		                                                echo wp_editor($note_content, 'editor_post_content', array('textarea_name' => 'note_content', 'editor_height' => '250px'));

	                                                    ?>
														<div class="position-absolute" style=" left:0px; bottom:61px;">
															<div class="dropdown">
																<a class="deal-tab dropdown-toggle btn rounded bg-white rounded-pill px-3 py-1"
																	style="font-size:12px;" data-toggle="dropdown"
																	aria-expanded="false">Select Priority Level</a>


																<div class="dropdown-menu">
																	<fieldset>

																		<div class="note-task-check">
																			<div
																				class="form-check  d-flex align-items-center text-success">
																				<input type="radio" name="formTask"
																					value="Low"
																					class="form-check-input"><label>
																					Low</label>
																			</div>
																			<div
																				class="form-check d-flex align-items-center text-warning">
																				<input type="radio" name="formTask"
																					value="Medium"
																					class="form-check-input"><label>
																					Medium</label>
																			</div>
																			<div
																				class="form-check d-flex align-items-center text-danger">
																				<input type="radio" name="formTask"
																					value="High"
																					class="form-check-input"><label>High</label>
																			</div>
																		</div>

																	</fieldset>


																</div>
															</div>


														</div>
														<button id="addNewNoteForDeal"
															class="btn btn-primary rounded-pill px-3 position-absolute"
															style=" right:0px; bottom:10px;">Add
															note</button>
													</div>
												</div>



											</div>


											<div id="notesContainer" class="notes-container">
												<div class="p-2 accordion-item"
													style="background:#F5F7FA; border-radius:11px">
													<div class="col-md-6 d-flex align-items-center justify-content-end float-right"
														style="gap:10px">
														<i class="fal fa-calendar-alt"></i>
														<span>October 15, 2022</span>
														<button class="btn border-left">
															<i class="fal fa-ellipsis-h-alt"></i>
														</button>
													</div>

													<input class="accordion__note__hidden" type="checkbox"
														id="note-one-1" checked>
													<label class="col-md-6 accordion__note__user__name" for="note-one-1"
														style="cursor:pointer;margin-top: 8px;">
														Note by Alexander Dupit
													</label>

													<hr />

													<div class="accordion__note__details position-relative"
														id="collapseNote1">
														<strong>Summary Note - 12 Jul, 2024</strong>
														<p>Customer will send ownership, note to follow up for tomorrow
															evening by phone at 8pm, otherwise by email provided.</p>
													</div>
												</div>
											</div>




											<div>
												<style>
												.note-task-check {
													display: flex;
													min-width: 300px;
													align-items: center;
													flex-direction: row;
													gap: 10px;
													padding: 0px 20px;
												}

												.note-task-check input {
													margin-top: 0px !important;
												}

												.note-task-check label {
													display: inline-block;
													margin-bottom: 0rem !important;
												}

												.mce-top-part {
													position: absolute !important;
													bottom: 19px;
													left: 0;
													right: 0;
												}

												.quicktags-toolbar {
													padding: 3px;
													position: absolute !important;
													border-bottom: 1px solid #dcdcde;
													background: #f6f7f7 !important;
													bottom: 0px;
													left: 0px;
													right: 0px;
												}

												.wp-editor-container {

													border: 0px solid #ffffff !important;
												}

												.html-active .switch-html,
												.tmce-active .switch-tmce {
													background: #F5F7FA !important;
													color: #50575e;
													border-bottom-color: #000 !important;
													border-bottom: 1px solid #000 !important;
												}

												.wp-switch-editor {

													background: #F5F7FA !important;

													border: 0px solid #F5F7FA !important;
												}



												div.mce-toolbar-grp {
													border-top: 1px solid #dcdcde;
													background: #f6f7f700 !important;
													border-bottom: 0px !important;
												}

												div.mce-edit-area {
													background: #F5F7FA !important;
													border-radius: 10px !important;
												}

												.mce-panel.mce-menu {
													background: #ffffff;
												}

												div.mce-panel {
													border: 0;
													background: #fff0 !important;
												}

												.mce-statusbar>.mce-container-body .mce-path {
													display: none;
												}

												div.mce-statusbar {
													border-top: 0px solid #fff0 !important;
												}

												.wp-editor-container textarea.wp-editor-area {

													background: #F5F7FA !important;
													border-radius: 11px;
												}

												#editor_post_content_ifr #tinymce.mce-content-body {
													background: #F8F9FA !important;
													border-radius: 11px;
												}

												.quicktags-toolbar {

													border-bottom: 0px solid #fff0 !important;
													background: #f6f7f7 !important;
													min-height: 30px;
													border-top: 1px solid #EAEAEA !important;
													padding: 15px 10px !important;
												}

												.mce-top-part::before {
													display: none !important;
												}

												.quicktags-toolbar input {
													border: 0px !important;
													text-transform: uppercase;
													color: #000 !important;
												}

												.wp-editor-tools {
													position: absolute;
													z-index: 1;
													right: 0;
													top: -12px;
												}





												.accordion__single__question {
													width: 100%;
													border-bottom: 1px solid #EAEAEA;
												}


												.accordion__single__hidden {
													display: none;
												}

												.accordion__single__hidden:checked~.accordion__single__answer {
													max-height: 500px;
													opacity: 1;
													-webkit-transform: translate(0, 0);
													-ms-transform: translate(0, 0);
													transform: translate(0, 0);
													margin-top: 14px;
												}

												.accordion__single__hidden:checked~.accordion__single__question::before {
													content: '˄';

												}

												.accordion__single__answer {
													margin-top: 5px;
													margin-left: 10px;
													max-height: 0;
													opacity: 0;
													-webkit-transform: translate(0, 50%);
													-ms-transform: translate(0, 50%);
													transform: translate(0, 50%);
													-webkit-transition: all .4s ease;
													transition: all .4s ease;
													position: relative;
												}

												.accordion__single__question:before {
													display: inline-block;
													margin-right: 10px;
													color: #000;
													content: '˅';
													float: left;
													font-size: 30px;
													font-weight: normal;
													line-height: 33px;
													font-size: 30px;
												}






												.accordion__note__hidden {
													display: none;
												}

												.accordion__note__details {
													max-height: 0;
													opacity: 0;
													transform: translate(0, 50%);
													margin-top: 0;
													transition: all .4s ease;
												}

												.accordion__note__hidden:checked~.accordion__note__details {


													max-height: 2000px;
													opacity: 1;
													transform: translate(0, 0);
													margin-top: 14px;
													transition: all .4s ease;
												}

												.accordion__note__hidden:checked~.accordion__note__user__name::before {
													content: '˄';
												}

												.accordion__note__user__name {
													width: 100%;
												}



												.accordion__note__user__name::before {
													display: inline-block;
													margin-right: 10px;
													color: #000;
													content: '˅';
													float: left;
													font-size: 30px;
													line-height: 25px;
												}
												</style>


											</div>





										</div>
										<div class="tab-pane fade" id="deals-notes-Emails" role="tabpanel"
											aria-labelledby="pills-deals-notes-Emails-tab">
											deals-notes-Emails

										</div>
										<div class="tab-pane fade" id="deals-notes-Calls" role="tabpanel"
											aria-labelledby="pills-deals-notes-Calls-tab">
											deals-notes-Calls

										</div>
										<div class="tab-pane fade" id="deals-notes-Meetings" role="tabpanel"
											aria-labelledby="pills-deals-notes-Meetings-tab">
											deals-notes-Meetings

										</div>
									</div>

								</div>




							</div>


						</div>
						<div class="col-12 col-md-3 px-2 py-3">

							<div class="bg-white py-3 px-2" style="border-radius: 20px">



								<input class="accordion__note__hidden" type="checkbox" id="note-client-1" checked>
								<label class="float-right accordion__note__user__name col-3 p-0" for="note-client-1"
									style="cursor:pointer;right: 0px;top: 0px; width: 10px;">
								</label>
								<div class="float-left d-flex align-items-center col-9 p-0">

									<strong class="small">Clients</strong>

									<div class="bg-light small ml-2 badge">2</div>
								</div>




								<div class="accordion__note__details position-relative mt-5" id="collapseNote1">

									<div class="radiusx my-2 p-2 border">
										<div class="d-flex justify-content-between align-items-center my-2">
											<div class="col-8 p-0 d-flex justify-content-start align-items-center"
												style="gap:5px">
												<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/circle.svg"
													style="width:20px" />
												<span class="clientName">Client Name</span>
											</div>

											<span class="badge rounded-pill turbo-success"> <i
													class="fas fa-circle small mr-2"></i> Seller</span>

										</div>
										<div class="bg-light radiusx my-2 py-3 px-1"
											style="color:#4B4B4B; font-size:14px">
											<div class="d-flex align-items-center my-2 overflow-hidden">
												<i class="fal fa-globe"></i> <a
													class="sellerMarketLink pl-2 text-dark small overflow-hidden"
													href="jlrlakridge.com">jlrlakridge.com</a>
											</div>
											<div class="d-flex align-items-center my-2">
												<i class="far fa-envelope"></i> <a href="mailto:toronto.auto@gmail.com"
													class="clientEmail ml-2 text-dark small">toronto.auto@gmail.com</a>
											</div>
											<div class="d-flex align-items-centerv my-2">
												<i class="fal fa-phone-alt"></i> <a href="tel:(416) 555-4393"
													class="clientPhone ml-2 text-dark small">(416) 555-4393</a>
											</div>
										</div>



									</div>
									<div class="radiusx my-2 p-2 border">
										<div class="d-flex justify-content-between align-items-center my-2">
											<div class="col-8 p-0 d-flex justify-content-start align-items-center"
												style="gap:5px">
												<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/circle.svg"
													style="width:20px" />
												<span class="buyerName">Buyer Name</span>
											</div>

											<span class="badge rounded-pill turbo-success"> <i
													class="fas fa-circle small mr-2"></i> Buyer</span>

										</div>
										<div class="bg-light radiusx my-2 py-3 px-1"
											style="color:#4B4B4B; font-size:14px">
											<div class="d-flex align-items-center my-2 overflow-hidden">
												<i class="fal fa-globe"></i> <a
													class="buyerMarketLink pl-2 text-dark small overflow-hidden"
													href="jlrlakridge.com">jlrlakridge.com</a>
											</div>
											<div class="d-flex align-items-center my-2">
												<i class="far fa-envelope"></i> <a href="mailto:toronto.auto@gmail.com"
													class="buyerEmail ml-2 text-dark small">toronto.auto@gmail.com</a>
											</div>
											<div class="d-flex align-items-centerv my-2">
												<i class="fal fa-phone-alt"></i> <a href="tel:(416) 555-4393"
													class="buyerPhone ml-2 text-dark small">(416) 555-4393</a>
											</div>
										</div>



									</div>



								</div>



								<div class="deal-status-section mt-4">
									<input class="accordion__note__hidden" type="checkbox" id="deal-status-note"
										checked>
									<label class="float-right accordion__note__user__name col-3 p-0"
										for="deal-status-note" style="cursor:pointer;right: 0px;top: 0px; width: 10px;">
									</label>
									<div class=" d-flex align-items-center col-9 p-0">

										<strong class="small">Deals</strong>

										<div class="bg-light small ml-2 badge">1</div>
									</div>




									<div class="accordion__note__details position-relative mt-3" id="collapseNote1">

										<div class="radiusx my-2 p-2 border">
											<div class="d-flex justify-content-start align-items-center my-2">

												<span>Escrow Status</span>

											</div>
											<div class="radiusx my-2 py-3" style="color:#4B4B4B; font-size:14px">
												<div class="d-flex align-items-center my-2">
													<div class="col-6 pl-0">
														<i class="fal fa-badge-dollar"></i> Escrow Amount
													</div>
													<div class="col-1">:</div>
													<div class="col-5 text-end">
														<span class="loanAmount text-black">$25,000</span>
													</div>
												</div>
												<div class="d-flex align-items-center my-2">
													<div class="col-6 pl-0">
														<i class="fal fa-calendar-alt"></i> Escrow Start
													</div>
													<div class="col-1">:</div>
													<div class="col-5 text-end">
														<span class="applicationDate text-black">June 20,2024</span>
													</div>
												</div>
												<div class="d-flex align-items-center my-2">
													<div class="col-6 pl-0">
														<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/spinner.svg"
															style="width:14px;" /> Status
													</div>
													<div class="col-1">:</div>
													<div class="noteSectionDealStatus col-5 text-end">
														<span class="badge rounded-pill py-2 px-3"
															style="background:#6D6D6D"> <i
																class="fas fa-circle small mr-2 text-success"></i>
															<span class="text-white">Paperwork</span></span>

													</div>
												</div>

											</div>



										</div>




									</div>
								</div>

								<div class="deal-task-section mt-4 d-none">
									<input class="accordion__note__hidden" type="checkbox" id="deal-task-note" checked>
									<label class="float-right accordion__note__user__name col-3 p-0"
										for="deal-task-note" style="cursor:pointer;right: 0px;top: 0px; width: 10px;">
									</label>
									<div class=" d-flex align-items-center col-9 p-0">

										<strong class="small">Task by Priority</strong>

										<div id="notesCount" class="bg-light small ml-2 badge">3/5</div>
									</div>




									<div class="accordion__note__details position-relative mt-3" id="collapseNote1">

										<div id="statusPriorityBasedNotes">



											<div class="radiusx my-2 p-2 bg-light">
												<div class="d-flex justify-content-between align-items-center my-2">
													<div class="p-0 d-flex justify-content-start align-items-center text-danger"
														style="gap:5px">
														<i class="fal fa-flag-alt"></i>
														<span>High</span>
													</div>

													<button class="btn"> <i class="fal fa-ellipsis-h-alt"></i></button>

												</div>
												<div class="radiusx" style="color:#4B4B4B; font-size:14px">

													<p>Lender is requesting paystub to close deal </p>

													<div class="d-flex justify-content-between align-items-center mt-2">
														<div class="col-6 pl-0">
															<img src="<?php if($CORE->USER('get_avatar', $userdata->ID)){echo $CORE->USER('get_avatar', $userdata->ID); }else{ echo home_url() . '/wp-content/uploads/2024/09/user-profile.png'; } ?>"
																style="width:30px;" />
														</div>
														<div
															class="col-6 pr-0 text-right d-flex justify-content-end align-items-center">
															<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/sms.svg"
																style="width:30px;" />
															<span class="ml-2 h5">3</span>

														</div>
													</div>

												</div>



											</div>

										</div>


									</div>
								</div>




							</div>
							<!-- White block close  -->

						</div>

					</div>


				</div>
				<div class="tab-pane fade" id="pills-deals" role="tabpanel" aria-labelledby="pills-deals-tab">


					<section class="deals-container">

						<section class="applicant-card book-deal-header-info">
							<div class="applicant-header">
								<div class="applicant-info">
									<h2 class="applicant-title">Book Deal</h2>

								</div>
							</div>

							<div class="custom-control custom-switch">
								<input type="checkbox" class="custom-control-input" id="customSwitch1">
								<label class="custom-control-label" for="customSwitch1">Request Funding Docs</label>
							</div>

							<!-- Another block  -->

							<div class="d-flex text-white" style="gap:10px;">
								<div class="text-end">
									<p class="heading-vendor-name text-white">Vendor: <strong>Cruze Auto Sales
											INC</strong></p>
									<p class="trim-plan manager-info">Manager: <strong>Trbo Swift Financial</strong></p>
								</div>
								<p class="heading-deal-id">Deal #7542</p>
							</div>

						</section>

						<div class="custom-card book-deal-info">

							<div class="form-row">

								<div class="form-group col-md-3">
									<label for="stock-input" class="info-label">Stock #
									</label>
									<input type="text" id="stock-input" class="form-control book-deal" value="V007" />
								</div>
								<div class="form-group col-md-3">
									<label for="date-input" class="info-label">Date
									</label>
									<input type="date" id="date-input" class="form-control book-deal" value="" />
								</div>
								<div class="form-group col-md-3">
									<label for="vehicle-input" class="info-label">Vehicle
									</label>
									<input type="date" id="vehicle-input" class="form-control book-deal" value="2012"
										readonly />
								</div>

								<div class="form-group col-md-3">
									<label for="vin-input" class="info-label">VIN
									</label>
									<input type="date" id="vin-input" class="form-control book-deal" value="VFFJ567766"
										readonly />
								</div>



							</div>

							<div class="form-row">

								<div class=" col-md-6">


									<div class="form-group ">
										<label>Funding Sheet</label>
										<form method="post" enctype="multipart/form-data"
											class="form-input d-flex border rounded-pill">
											<div class="input-group-append">
												<span for="file"
													class="uploading-sheet-file border rounded-pill  d-flex align-items-center px-4"
													style=" width:130px">Choose
													file</span>
											</div>
											<input type="file" name="file" id="uploading-sheet-file"
												style="cursor:pointer" class="custom-file-input" />
											<div class="input-group-append">
												<button class="btn btn-secondary rounded-pill" type="button"
													id="upload-funding-sheet">Upload</button>
											</div>
										</form>
									</div>


									<div id="uploading-sheet-info">
										<p id="uploading-sheet-name">File Name: <span></span></p>
										<p id="uploading-sheet-size">File Size: <span></span></p>
										<p id="uploading-sheet-type">MIME Type: <span></span></p>
									</div>

									<script>
									jQuery(function($) {
										jQuery("#uploading-sheet-info").hide();
										$("#uploading-sheet-file").on("change", function() {
											var file = this.files[0];
											var formdata = new FormData();
											formdata.append("file", file);
											jQuery("#uploading-sheet-info").show();
											if (file.name.length >= 30) {
												$("#uploading-sheet-name span")
													.empty()
													.append(file.name.substr(0, 30) + "..");
											} else {
												$("#uploading-sheet-name span").empty().append(file
													.name);
											}
											if (file.size >= 1073741824) {
												$("#uploading-sheet-size span")
													.empty()
													.append(Math.round(file.size / 1073741824) +
														"GB");
											} else if (file.size >= 1048576) {
												$("#uploading-sheet-size span")
													.empty()
													.append(Math.round(file.size / 1048576) + "MB");
											} else if (file.size >= 1024) {
												$("#uploading-sheet-size span")
													.empty()
													.append(Math.round(file.size / 1024) + "KB");
											} else {
												$("#uploading-sheet-size span")
													.empty()
													.append(Math.round(file.size) + "B");
											}
											if (file.type != "") {
												$("#uploading-sheet-type span").empty().append(file
													.type);
											} else {
												$("#uploading-sheet-type span").empty().append(
													"Unknown");
											}
											if (file.name.length >= 30) {
												$(".uploading-sheet-file").css("width", "303px")
													.text(
														"Chosen : " + file.name
														.substr(0, 30) +
														"..");
											} else {
												$(".uploading-sheet-file").css("width", "303px")
													.text(
														"Chosen : " + file
														.name);
											}

											var ext = $("#uploading-sheet-file").val().split(".")
												.pop()
												.toLowerCase();
											if ($.inArray(ext, ["php", "html"]) !== -1) {
												$("#uploading-sheet-info").hide();
												$(".uploading-sheet-file").text("Choose File").css(`
                                                    width: 150px;
                                                    
                                                    `);
												$("#uploading-sheet-file").val("");
												// alert("This file extension is not allowed!");
												showGlobalAlert('error', `<h3>This file extension is not allowed!</h3>`);
											}
										});
									});
									</script>



								</div>



								<div class="col-md-6 d-flex justify-content-end align-items-center">
									<button class="btn btn-primary rounded-pill mr-2" id="open-bill-of-sales">Open
										Bill
										of
										Sales</button>
									<button class="btn btn-primary rounded-pill" id="bool-deal-sales">Open Bill of
										Sales</button>

								</div>
							</div>


						</div>




						<h2 class="products-title">Products</h2>


						<div class="custom-card">

							<div class="form-row justify-content-between bank resurv">

								<label class="info-label col-md-4">Bank Reserve
								</label>

								<div class="input-group col-md-3">

									<div class="input-group-prepend">
										<span class="input-group-text"
											style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
									</div>
									<input type="text" id="purchase-price" class="form-control" aria-label="Purchase
                                        Price">

								</div>
							</div>




							<div class="form-row justify-content-between warrenty">

								<span class="info-label col-md-4">Warranty
								</span>


								<div class="form-group col-md">
									<label class="info-label">Sales Price:
									</label>
									<div class="input-group">

										<div class="input-group-prepend">
											<span class="input-group-text"
												style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
										</div>
										<input type="text" id="sales-price" class="form-control">

									</div>
								</div>

								<div class="form-group col-md">
									<label class="info-label">Cost:
									</label>
									<div class="input-group">

										<div class="input-group-prepend">
											<span class="input-group-text"
												style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
										</div>
										<input type="text" id="cost-price" class="form-control">

									</div>
								</div>
								<div class="form-group col-md">
									<label class="info-label">Profit:
									</label>
									<div class="input-group">

										<div class="input-group-prepend">
											<span class="input-group-text"
												style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
										</div>
										<input type="text" id="profit-price" class="form-control">

									</div>
								</div>



							</div>
							<div class="form-row justify-content-between pro-peack">

								<span class="info-label col-md-4">Pro Pack/Gap
								</span>


								<div class="form-group col-md">
									<label class="info-label">Sales Price:
									</label>
									<div class="input-group">

										<div class="input-group-prepend">
											<span class="input-group-text"
												style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
										</div>
										<input type="text" id="sales-price" class="form-control">

									</div>
								</div>

								<div class="form-group col-md">
									<label class="info-label">Cost:
									</label>
									<div class="input-group">

										<div class="input-group-prepend">
											<span class="input-group-text"
												style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
										</div>
										<input type="text" id="cost-price" class="form-control">

									</div>
								</div>
								<div class="form-group col-md">
									<label class="info-label">Profit:
									</label>
									<div class="input-group">

										<div class="input-group-prepend">
											<span class="input-group-text"
												style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
										</div>
										<input type="text" id="profit-price" class="form-control">

									</div>
								</div>



							</div>
							<div class="form-row justify-content-between life-insurance">

								<span class="info-label col-md-4">Life Insurance
								</span>


								<div class="form-group col-md">
									<label class="info-label">Sales Price:
									</label>
									<div class="input-group">

										<div class="input-group-prepend">
											<span class="input-group-text"
												style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
										</div>
										<input type="text" id="sales-price" class="form-control">

									</div>
								</div>

								<div class="form-group col-md">
									<label class="info-label">Cost:
									</label>
									<div class="input-group">

										<div class="input-group-prepend">
											<span class="input-group-text"
												style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
										</div>
										<input type="text" id="cost-price" class="form-control">

									</div>
								</div>
								<div class="form-group col-md">
									<label class="info-label">Profit:
									</label>
									<div class="input-group">

										<div class="input-group-prepend">
											<span class="input-group-text"
												style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
										</div>
										<input type="text" id="profit-price" class="form-control">

									</div>
								</div>



							</div>






						</div>

					</section>
				</div>
				<div class="tab-pane fade" id="pills-documents" role="tabpanel" aria-labelledby="pills-documents-tab">




					<section class="documents">

						<div class="col-12 d-flex py-3 px-2">
							<div class="col-md-8">
								<h2 class="vehicle-title"> Documents</h2>




							</div>
							<div class="col-md-4">

								<div class="d-flex " style="gap:10px;">
									<div class="text-end">
										<p class="heading-vendor-name ">Vendor: <strong>Cruze Auto Sales
												INC</strong></p>
										<p class="trim-plan manager-info">Manager: <strong>Trbo Swift Financial</strong>
										</p>
									</div>
									<p class="heading-deal-id">Deal #7542</p>
								</div>
							</div>


						</div>




						<div class="p-2">
							<div class="col-12 d-flex">


								<div class="col-md-8 p-0">
									<ul id="deal-overview-tabs" class="nav justify-content-start nav-pills mb-3"
										role="tablist">

										<li class="nav-item" role="presentation">
											<a class="deal-tab active" id="pills-document-all-tab" data-toggle="pill"
												data-target="#document-all" type="button" role="tab"
												aria-controls="document-all" aria-selected="true">All</a>
										</li>
										<li class="nav-item" role="presentation">
											<a class="deal-tab " id="pills-document-active-tab" data-toggle="pill"
												data-target="#document-active" type="button" role="tab"
												aria-controls="document-active" aria-selected="true">Active</a>
										</li>
										<li class="nav-item" role="presentation">
											<a class="deal-tab " id="pills-document-completed-tab" data-toggle="pill"
												data-target="#document-completed" type="button" role="tab"
												aria-controls="document-completed" aria-selected="true">Completed</a>
										</li>
										<li class="nav-item" role="presentation">
											<a class="deal-tab " id="pills-document-apps-tab" data-toggle="pill"
												data-target="#document-apps" type="button" role="tab"
												aria-controls="document-apps" aria-selected="true">Apps</a>
										</li>

									</ul>

								</div>
								<div class="col-md-4 p-0 justify-content-end">

									<div class="input-group rounded-pill border ">

										<div class="input-group-prepend">
											<span class="input-group-text  border-0"
												style="border-radius: 50px 0 0 50px; background: #fff;"><i
													class="fal fa-search"></i></span>
										</div>
										<input type="text" id="search-box-client-doc" class="form-control border-0"
											placeholder="Search here" style="border-radius: 0 50px 50px 0;">

									</div>
								</div>
							</div>


							<div class="tab-content pt-3" id="pills-order-content">
								<div class="tab-pane fade active show" id="document-all" role="tabpanel"
									aria-labelledby="pills-document-all-tab">
									<!-- All -->


									<div class="card-body p-0" bis_skin_checked="1">
										<div class="overflow-auto" bis_skin_checked="1">
											<table class="table small table-orders">
												<thead>
													<tr>
														<th class="text-start bg-primary text-white "
															style="border-radius:10px 0 0 0;">Document name</th>
														<th class="text-start bg-primary text-white ">Type
														</th>
														<th class="text-start  bg-primary text-white">Client name
														</th>
														<th class="text-start bg-primary text-white dashhideme">
															Select
														</th>

														<th class="text-start text-white  bg-primary  dashhideme">
															Status</th>
														<th class="text-end text-white  bg-primary  dashhideme"
															style="border-radius:0 10px 0 0;"></th>
													</tr>
												</thead>
												<tbody class="bg-white" id="document">
													<tr class="row-1" data-upload-name="Wholesale Ai Vehicle Inspection"
														data-document-id="1">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Wholesale Ai Vehicle
																	Inspection
																</span>
																<span class="small pt-1 doc-date" style="color:#909090">
																</span>
															</div>
														</td>
														<td class="text-start text-dark">
															Dealer</span>
														</td>
														<td class="text-center text-muted text-dark">
															<div
																class="applicantNameFromFinance d-flex align-items-center">
																<img class="img-fluid mr-2"
																	style="max-width:35px; max-height:35px; border-radius:100px;"
																	src="<?php if($CORE->USER('get_avatar', $userdata->ID)){echo $CORE->USER('get_avatar', $userdata->ID); }else{ echo home_url() . '/wp-content/uploads/2024/09/user-profile.png'; } ?>"
																	alt="User Profile Image" />
																<?php echo $userdata->first_name ?>
																<?php echo $userdata->last_name ?>
															</div>

														</td>
														<td class="text-start text-dark">
															<span>
																+ Generate New
															</span>
														</td>
														<td class="doc-row-status text-end">
															<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Uncompleted</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-2" data-upload-name="VGA Document"
														data-document-id="2">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">VGA Document
																</span>
																<span class="small pt-1 doc-date" style="color:#909090">
																</span>
															</div>
														</td>
														<td class="text-start text-dark">
															Dealer</span>
														</td>
														<td class="text-center text-muted text-dark">
															<div
																class="applicantNameFromFinance d-flex align-items-center">
																<img class="img-fluid mr-2"
																	style="max-width:35px; max-height:35px; border-radius:100px;"
																	src="<?php if($CORE->USER('get_avatar', $userdata->ID)){echo $CORE->USER('get_avatar', $userdata->ID); }else{ echo home_url() . '/wp-content/uploads/2024/09/user-profile.png'; } ?>"
																	alt="User Profile Image" />
																<?php echo $userdata->first_name ?>
																<?php echo $userdata->last_name ?>
															</div>

														</td>
														<td class="text-start text-dark">
															<span>
																+ Generate New
															</span>
														</td>
														<td class="doc-row-status text-end">
															<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Uncompleted</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-3" data-upload-name="Ai Vehicle Inspection"
														data-document-id="3">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Ai Vehicle Inspection
																</span>
																<span class="small pt-1 doc-date" style="color:#909090">
																</span>
															</div>
														</td>
														<td class="text-start text-dark">
															Dealer</span>
														</td>
														<td class="text-center text-muted text-dark">
															<div
																class="applicantNameFromFinance d-flex align-items-center">
																<img class="img-fluid mr-2"
																	style="max-width:35px; max-height:35px; border-radius:100px;"
																	src="<?php if($CORE->USER('get_avatar', $userdata->ID)){echo $CORE->USER('get_avatar', $userdata->ID); }else{ echo home_url() . '/wp-content/uploads/2024/09/user-profile.png'; } ?>"
																	alt="User Profile Image" />
																<?php echo $userdata->first_name ?>
																<?php echo $userdata->last_name ?>
															</div>

														</td>
														<td class="text-start text-dark">
															<span>
																+ Generate New
															</span>
														</td>
														<td class="doc-row-status text-end">
															<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Uncompleted</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-4" data-upload-name="Proxy" data-document-id="4">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Proxy
																</span>
																<span class="small pt-1 doc-date" style="color:#909090">
																</span>
															</div>
														</td>
														<td class="text-start text-dark">
															Dealer</span>
														</td>
														<td class="text-center text-muted text-dark">
															<div
																class="applicantNameFromFinance d-flex align-items-center">
																<img class="img-fluid mr-2"
																	style="max-width:35px; max-height:35px; border-radius:100px;"
																	src="<?php if($CORE->USER('get_avatar', $userdata->ID)){echo $CORE->USER('get_avatar', $userdata->ID); }else{ echo home_url() . '/wp-content/uploads/2024/09/user-profile.png'; } ?>"
																	alt="User Profile Image" />
																<?php echo $userdata->first_name ?>
																<?php echo $userdata->last_name ?>
															</div>

														</td>
														<td class="text-start text-dark">
															<span>
																+ Generate New
															</span>
														</td>
														<td class="doc-row-status text-end">
															<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Uncompleted</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-5" data-upload-name="Trbo Swift Client"
														data-document-id="5">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Trbo Swift Client
																</span>
																<span class="small pt-1 doc-date" style="color:#909090">
																</span>
															</div>
														</td>
														<td class="text-start text-dark">
															Dealer</span>
														</td>
														<td class="text-center text-muted text-dark">
															<div
																class="applicantNameFromFinance d-flex align-items-center">
																<img class="img-fluid mr-2"
																	style="max-width:35px; max-height:35px; border-radius:100px;"
																	src="<?php if($CORE->USER('get_avatar', $userdata->ID)){echo $CORE->USER('get_avatar', $userdata->ID); }else{ echo home_url() . '/wp-content/uploads/2024/09/user-profile.png'; } ?>"
																	alt="User Profile Image" />
																<?php echo $userdata->first_name ?>
																<?php echo $userdata->last_name ?>
															</div>

														</td>
														<td class="text-start text-dark">
															<span>
																+ Generate New
															</span>
														</td>
														<td class="doc-row-status text-end">
															<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Uncompleted</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-6" data-upload-name="Waiver" data-document-id="6">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Waiver
																</span>
																<span class="small pt-1 doc-date" style="color:#909090">
																</span>
															</div>
														</td>
														<td class="text-start text-dark">
															Dealer</span>
														</td>
														<td class="text-center text-muted text-dark">
															<div
																class="applicantNameFromFinance d-flex align-items-center">
																<img class="img-fluid mr-2"
																	style="max-width:35px; max-height:35px; border-radius:100px;"
																	src="<?php if($CORE->USER('get_avatar', $userdata->ID)){echo $CORE->USER('get_avatar', $userdata->ID); }else{ echo home_url() .  '/wp-content/uploads/2024/09/user-profile.png'; } ?>"
																	alt="User Profile Image" />
																<?php echo $userdata->first_name ?>
																<?php echo $userdata->last_name ?>
															</div>

														</td>
														<td class="text-start text-dark">
															<span>
																+ Generate New
															</span>
														</td>
														<td class="doc-row-status text-end">
															<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Uncompleted</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-7" data-upload-name="Proxy" data-document-id="7">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Proxy
																</span>
																<span class="small pt-1 doc-date" style="color:#909090">
																</span>
															</div>
														</td>
														<td class="text-start text-dark">
															Dealer</span>
														</td>
														<td class="text-center text-muted text-dark">
															<div
																class="applicantNameFromFinance d-flex align-items-center">
																<img class="img-fluid mr-2"
																	style="max-width:35px; max-height:35px; border-radius:100px;"
																	src="<?php if($CORE->USER('get_avatar', $userdata->ID)){echo $CORE->USER('get_avatar', $userdata->ID); }else{ echo '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png'; } ?>"
																	alt="User Profile Image" />
																<?php echo $userdata->first_name ?>
																<?php echo $userdata->last_name ?>
															</div>

														</td>
														<td class="text-start text-dark">
															<span>
																+ Generate New
															</span>
														</td>
														<td class="doc-row-status text-end">
															<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Uncompleted</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="py-3 bg-white">
														<td colspan="6">
															<button class="btn" id="vehiclePurchasAgreementBtn">
																<h6 class="text-black">Vehicle Purchase Agreement</h6>
															</button>
														</td>



													</tr>
													<tr class="row-8 vehiclePurchasAgreement"
														data-upload-name="Ontario VGA" data-document-id="8">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex align-items-center pl-2">
																<span class="doc-name text-dark ">Ontario VGA
																</span>

															</div>
														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-center text-muted text-dark">


														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-end">
															<span class="turbo-success font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Generate
																New</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-9 vehiclePurchasAgreement"
														data-upload-name="Quebec VGA" data-document-id="9">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex align-items-center pl-2">
																<span class="doc-name text-dark ">Quebec VGA
																</span>

															</div>
														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-center text-muted text-dark">


														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-end">
															<span class="turbo-success font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Generate
																New</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-10 vehiclePurchasAgreement"
														data-upload-name="Nova Scotia VGA" data-document-id="10">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex align-items-center pl-2">
																<span class="doc-name text-dark ">Nova Scotia VGA
																</span>

															</div>
														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-center text-muted text-dark">


														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-end">
															<span class="turbo-success font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Generate
																New</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-11 vehiclePurchasAgreement"
														data-upload-name="New Brunswick VGA" data-document-id="11">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex align-items-center pl-2">
																<span class="doc-name text-dark ">New Brunswick VGA
																</span>

															</div>
														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-center text-muted text-dark">


														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-end">
															<span class="turbo-success font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Generate
																New</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-12 vehiclePurchasAgreement"
														data-upload-name="Newfoundland and Labrador VGA"
														data-document-id="12">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex align-items-center pl-2">
																<span class="doc-name text-dark ">Newfoundland and
																	Labrador VGA
																</span>

															</div>
														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-center text-muted text-dark">


														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-end">
															<span class="turbo-success font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Generate
																New</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-13 vehiclePurchasAgreement"
														data-upload-name="Prince Edward Island VGA"
														data-document-id="13">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex align-items-center pl-2">
																<span class="doc-name text-dark ">Prince Edward Island
																	VGA
																</span>

															</div>
														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-center text-muted text-dark">


														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-end">
															<span class="turbo-success font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Generate
																New</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-14 vehiclePurchasAgreement"
														data-upload-name="Prince Edward Island VGA"
														data-document-id="14">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex align-items-center pl-2">
																<span class="doc-name text-dark ">Prince Edward Island
																	VGA
																</span>

															</div>
														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-center text-muted text-dark">


														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-end">
															<span class="turbo-success font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Generate
																New</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-15 vehiclePurchasAgreement"
														data-upload-name="Manitoba VGA" data-document-id="15">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex align-items-center pl-2">
																<span class="doc-name text-dark ">Manitoba VGA
																</span>

															</div>
														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-center text-muted text-dark">


														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-end">
															<span class="turbo-success font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Generate
																New</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-16 vehiclePurchasAgreement"
														data-upload-name="Saskatchewan VGA" data-document-id="16">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex align-items-center pl-2">
																<span class="doc-name text-dark ">Saskatchewan VGA
																</span>

															</div>
														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-center text-muted text-dark">


														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-end">
															<span class="turbo-success font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Generate
																New</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-17 vehiclePurchasAgreement"
														data-upload-name="Alberta VGA" data-document-id="17">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex align-items-center pl-2">
																<span class="doc-name text-dark ">Alberta VGA
																</span>

															</div>
														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-center text-muted text-dark">


														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-end">
															<span class="turbo-success font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Generate
																New</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-18 vehiclePurchasAgreement"
														data-upload-name="British Columbia VGA" data-document-id="18">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex align-items-center pl-2">
																<span class="doc-name text-dark ">British Columbia VGA
																</span>

															</div>
														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-center text-muted text-dark">


														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-end">
															<span class="turbo-success font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Generate
																New</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-19 vehiclePurchasAgreement"
														data-upload-name="Nunavut VGA" data-document-id="19">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex align-items-center pl-2">
																<span class="doc-name text-dark ">Nunavut VGA
																</span>

															</div>
														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-center text-muted text-dark">


														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-end">
															<span class="turbo-success font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Generate
																New</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-20 vehiclePurchasAgreement"
														data-upload-name="Northwest Territories VGA"
														data-document-id="20">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex align-items-center pl-2">
																<span class="doc-name text-dark ">Northwest Territories
																	VGA
																</span>

															</div>
														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-center text-muted text-dark">


														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-end">
															<span class="turbo-success font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Generate
																New</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>
													<tr class="row-21 vehiclePurchasAgreement"
														data-upload-name="Yukon Territory VGA" data-document-id="21">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex align-items-center pl-2">
																<span class="doc-name text-dark ">Yukon Territory VGA
																	VGA
																</span>

															</div>
														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-center text-muted text-dark">


														</td>
														<td class="text-start text-dark">

														</td>
														<td class="text-end">
															<span class="turbo-success font-8 px-2 py-1 rounded-pill"><i
																	class="fas fa-circle small mr-2"></i>Generate
																New</span>
														</td>
														<td class="text-center">

															<div class="dropdown">
																<button class="btn btn-light dropdown-toggle"
																	type="button" data-toggle="dropdown"
																	aria-expanded="false">
																	<i class="fa-solid fa-ellipsis-vertical"></i>
																</button>


																<div class="dropdown-menu">
																	<a class="dropdown-item upload"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-upload"></i> Upload</a>
																	<a class="dropdown-item request"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-file-contract"></i>
																		Request Sign</a>
																	<a class="dropdown-item delete"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-trash-can"></i>
																		Delete</a>
																	<a class="dropdown-item view-doc"
																		href="javascript:void(0)"><i
																			class="fa-regular fa-eye"></i> View</a>
																	<a class="dropdown-item total-doc"
																		href="javascript:void(0)"><i
																			class="fa-solid fa-clipboard-list"></i>
																		Total Doc</a>
																</div>
															</div>

														</td>
													</tr>


												</tbody>
											</table>
										</div>
									</div>



								</div>
								<div class="tab-pane fade " id="document-active" role="tabpanel"
									aria-labelledby="pills-document-active-tab">Active</div>
								<div class="tab-pane fade " id="document-completed" role="tabpanel"
									aria-labelledby="pills-document-completed-tab">Completed</div>
								<div class="tab-pane fade " id="document-apps" role="tabpanel"
									aria-labelledby="pills-document-apps-tab">Completed</div>
							</div>


						</div>


					</section>
				</div>
				<div class="tab-pane fade" id="pills-shipping" role="tabpanel" aria-labelledby="pills-shipping-tab">
					<section
						class="bg-secondary py-3 px-2 d-flex flex-column flex-md-row justify-content-between align-items-center radiusx">
						<div class="d-flex align-items-center ">
							<div class="d-flex align-items-center justify-content-center bg-white radiusx mr-2 p-2">
								<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/10/finance.svg" alt="" />

							</div>

							<div>
								<h3 class="text-primary">TruboBid Transport</h3>
								<span class="font-12 text-light">Enter your pickup and dropup locations then book
									transport</span>

							</div>
						</div>

						<div class="tect-center d-none d-md-block">
							<img style="margin-bottom:-100px; z-index:10; position:relative"
								src="<?php echo home_url(); ?>/wp-content/uploads/2024/12/Group-1321316318.png" />
						</div>



						<!-- Another block  -->

						<div class="d-flex flex-column justify-content-between align-items-center text-white">
							<div class="d-flex flex-wrap text-center text-md-end">
								<p class="heading-vendor-name text-white font-12 mr-2">Vendor: <strong>Cruze Auto Sales
										INC</strong></p>
								<p class="manager-info align-self-inline text-white font-12 mr-2">Manager:
									<strong>Trbo Swift
										Financial</strong>
								</p>
								<p class="heading-deal-id font-12">Deal #7542</p>
							</div>

							<div class="d-flex justify-content-between align-items center mt-2 font-10">
								<div>
									<div class="d-flex align-items-center justify-content-center">
										<img width="25" height="25"
											src="<?php echo home_url(); ?>/wp-content/uploads/2024/10/sequre1.svg"
											alt="" />
									</div>
									<div class="d-flex align-items-center mt-2">
										<p class="text-white">Fully Insured Transport</p>
									</div>
								</div>
								<div>
									<div class="d-flex align-items-center justify-content-center">
										<img width="25" height="25"
											src="<?php echo home_url(); ?>/wp-content/uploads/2024/10/sequre1.svg"
											alt="" />
									</div>
									<div class="d-flex align-items-center mt-2">
										<p class="text-white">Fully Insured Transport</p>
									</div>
								</div>
								<div>
									<div class="d-flex align-items-center justify-content-center">
										<img width="25" height="25"
											src="<?php echo home_url(); ?>/wp-content/uploads/2024/10/sequre1.svg"
											alt="" />
									</div>
									<div class="d-flex align-items-center mt-2">
										<p class="text-white">Fully Insured Transport</p>
									</div>
								</div>

							</div>
						</div>
					</section>



					<div class="position-relative mt-3">

						<div class="transportBody">
							<div class="circlex circle1"></div>
							<div class="circlex circle2"></div>
						</div>

						<div class="col-md-12 row m-0 p-0">


							<div class="col-md-8 pr-0 d-flex justify-content-center align-items-start">

								<div class="custom-card col-12 mt-5" style="max-width:650px">
									<div class="get-qute-form text-dark font-12">

										<div class="transport-form-type row col-12">
											<div class="form-check  d-flex align-items-center mr-2 px-5 pt-2"
												style="border:1px solid #eee; border-radius:30px; ">
												<input type="radio" name="transport-form-type" value="Open"
													class="form-check-input"><label>
													Low</label>
											</div>
											<div class="form-check d-flex align-items-center px-5 pt-2"
												style="border:1px solid #eee; border-radius:30px; ">
												<input type="radio" name="transport-form-type" value="Enclosed"
													class="form-check-input"><label>
													Enclosed</label>
											</div>

										</div>

										<div class="row m-0 justify-content-start align-items-stretch my-3">
											<div class="col-12 col-md-3 mb-2 mb-md-0 pl-0">
												<div class="carTypeCard"
													style="height:100%; width:100%; background:#F8F9FA; text-align: center; border-radius:11px; display:flex; justify-content:center; flex-direction:column; align-items:center; padding:10px;">
													<div
														style="width:50px; height:50px; background:#E2FBD7; border-radius:100%; display:flex; justify-content:center; align-items:center;">
														<img
															src="<?php echo home_url() ?>/wp-content/uploads/2024/12/Vegfhjctor.svg" />
													</div>
													<div class="mt-2" style="font-size:12px; color:#5f5f5f"><span
															class="termType">Sedan</span> </div>

												</div>
											</div>
											<div class="col-12 col-md-3 mb-2 mb-md-0">
												<div class="carTypeCard"
													style="height:100%; width:100%; background:#F8F9FA; text-align: center; border-radius:11px; display:flex; justify-content:center; flex-direction:column; align-items:center; padding:10px;">
													<div
														style="width:50px; height:50px; background:#E2FBD7; border-radius:100%; display:flex; justify-content:center; align-items:center;">
														<img
															src="<?php echo home_url() ?>/wp-content/uploads/2024/12/gfhjk.svg" />
													</div>
													<div class="mt-2" style="font-size:12px; color:#5f5f5f"><span
															class="termType">SUV/Minivan/Pickup</span> </div>

												</div>
											</div>
											<div class="col-12 col-md-3 mb-2 mb-md-0 pr-0">
												<div class="carTypeCard"
													style="height:100%; width:100%; background:#F8F9FA; text-align: center; border-radius:11px; display:flex; justify-content:center; flex-direction:column; align-items:center; padding:10px;">
													<div
														style="width:50px; height:50px; background:#E2FBD7; border-radius:100%; display:flex; justify-content:center; align-items:center;">
														<img
															src="<?php echo home_url() ?>/wp-content/uploads/2024/12/kjghf.svg" />
													</div>
													<div class="mt-2" style="font-size:12px; color:#5f5f5f"><span
															class="termType">Motorcycle</span> </div>

												</div>
											</div>




										</div>

										<div class="form-group">
											<!-- <label for="pick-details">Pickup details</label> -->
											<div class="pick-location input-group rounded-pill border">


												<div class="input-group-prepend">
													<span class="input-group-text  border-0"
														style="border-radius: 50px 0 0 50px; background: #fff;"><i
															class="fal fa-map-marker-alt"></i></span>
												</div>
												<input type="text" id="transportPickupLocation"
													class="forminator-input form-control border-0"
													placeholder="Enter Pickup Address/Zip code">



											</div>
										</div>

										<div class="form-group">
											<!-- <label for="pick-details">Dropoff details</label> -->
											<div class="input-group destination-location rounded-pill border">

												<div class="input-group-prepend">
													<span class="input-group-text  border-0"
														style="border-radius: 50px 0 0 50px; background: #fff;"><i
															class="fal fa-map-marker-alt"></i></span>
												</div>

												<input type="text" id="transportDropLocation"
													class="form-control forminator-input border-0"
													placeholder="Enter Dropoff Address/Zip code">


											</div>
										</div>
										<div class="form-group">
											<!-- <label for="pick-details">Dropoff details</label> -->
											<div class="input-group transport-delivery-amount rounded-pill border">
												<input type="text" id="transportDeliveryFee"
													class="form-control border-0" placeholder="Transport fee" disabled>

												<div class="input-group-append">
													<button id="get-quote-in-finance" class="input-group-text  border-0"
														style="border-radius:0 50px 50px 0; background: #fff;"><i
															class="fal fa-calculator-alt"></i></button>
												</div>


											</div>
										</div>



										<div class="form-group">
											<!-- <label for="pickup-date-details">Requested Pickup Date</label> -->
											<div class="input-group rounded-pill border">

												<div class="input-group-prepend">
													<span class="input-group-text  border-0"
														style="border-radius: 50px 0 0 50px; background: #fff;"><i
															class="far fa-calendar-alt"></i></span>
												</div>

												<input type="date" id="transportDateCollect"
													class="form-control border-0" placeholder="Select data">


											</div>
										</div>
										<div class="row col-12  justify-content-between">
											<div class="form-group col-12 col-md-6 p-0 pr-md-2">
												<label for="isVehicleDrivable">Is the vehicle drivable?</label>
												<select type="text" id="isVehicleDrivable" class="form-control"
													value="">
													<option value="yes">Yes</option>
													<option value="no">No</option>
												</select>
											</div>
											<div class="form-group col-12 col-md-6 p-0">
												<label for="isValueIsOver">Vehicle value over 60,000$?</label>
												<select type="text" id="isValueIsOver" class="form-control" value="">
													<option value="yes">Yes</option>
													<option value="no">No</option>
												</select>
											</div>
										</div>

										<div class="row d-flex justify-content-center">
											<button id="bookTrasportBtn"
												class="btn btn-secondary px-3 py-1 rounded-pill">Book
												Now</button>
										</div>

									</div>



								</div>
							</div>

							<div class="col-md-4">

								<div class="bg-white p-3 mb-2 mr-2" style="border-radius:22px;">
									<h5><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/wpf_ask-question.svg"
											style="width:25px; margin-right:10px;" />Canada Wide Delivery</h5>

									<?php echo do_shortcode('[elementor-template id="325472"]'); ?>

								</div>

								<div class="bg-white p-3 mb-2 mr-2" style="border-radius:22px;">
									<h5><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/wpf_ask-question.svg"
											style="width:25px; margin-right:10px;" />International Delivery</h5>

									<?php echo do_shortcode('[elementor-template id="325466"]'); ?>

								</div>
							</div>

						</div>


					</div>






				</div>


				<div class="tab-pane fade" id="pills-vendor-info" role="tabpanel"
					aria-labelledby="pills-vendor-info-tab">
					<section class="applicant-card chat-header-vendor">
						<div class="applicant-header">
							<div class="applicant-info">
								<h2 class="applicant-title">Vendor</h2>

							</div>
						</div>



						<!-- Another block  -->

						<div class="d-flex text-white" style="gap:10px;">
							<div class="text-end">
								<p class="heading-vendor-name text-white">Vendor: <strong>Cruze Auto Sales
										INC</strong></p>
								<p class="trim-plan manager-info">Manager: <strong>Trbo Swift Financial</strong></p>
							</div>
							<p class="heading-deal-id">Deal #7542</p>
						</div>

					</section>



					<section class="custom-card vendor-details-section">
						<div class="bg-light p-3" style="border-radius:15px;">

							<div class="form-row">
								<div class="form-group col-md-3">
									<label for="vendor-id" class="info-label">Vendor ID</label>
									<input type="text" id="vendor-id" current-vendor-id" class="form-control vendor-id"
										value="" readonly>
								</div>
								<div class="form-group col-md-3">
									<label for="company" class="info-label">Company</label>
									<input type="text" id="company" class="form-control vendor-company-name" value=""
										readonly>
								</div>
								<div class="form-group col-md-3">
									<label for="hst-number" class="info-label">HST #</label>
									<input type="text" id="hst-number" class="form-control hst-number" value=""
										readonly>
								</div>
								<div class="form-group col-md-3">
									<label for="dealer-Reg" class="info-label">Dealer Reg. #</label>
									<input type="text" id="dealer-Reg" class="form-control dealer-Reg" value=""
										readonly>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-md-3">
									<label for="vendor-Name" class="info-label">Name</label>
									<input type="text" id="vendor-Name" current-vendor-id"
										class="form-control vendor-Name" value="" readonly>
								</div>
								<div class="form-group col-md-3">
									<label for="vendor-PhoneNumber" class="info-label">Phone Number</label>
									<input type="tel" id="vendor-PhoneNumber" class="form-control vendor-PhoneNumber"
										value="" readonly>
								</div>
								<div class="form-group col-md-3">
									<label for="vendor-CellPhoneNumber" class="info-label">Cell Phone Number</label>
									<input type="tel" id="vendor-CellPhoneNumber"
										class="form-control vendor-CellPhoneNumber" value="" readonly>
								</div>

								<div class="form-group col-md-3">
									<label for="vendor-E-MailAddress" class="info-label">E-Mail Address</label>
									<input type="text" id="vendor-MailAddress" class="form-control mailAddress" value=""
										readonly>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-md-3">
									<label for="street-address" class="info-label">Address</label>
									<input type="text" id="street-address" class="form-control vendor-address">
								</div>
								<div class="form-group col-md-3">
									<label for="vendor-city" class="info-label">City</label>
									<input type="text" id="vendor-city" class="form-control current-employer" value="">
								</div>
								<div class="form-group col-md-3">
									<label for="vendor-province" class="info-label">Province</label>
									<select type="text" id="vendor-province" class="form-control vendor-province">

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
									<label for="postal-code" class="info-label">Postal Code</label>
									<input type="text" id="postal-code" class="form-control vendor-postal">
								</div>
							</div>

							<div class="form-row">

								<div class="form-group col-md-3">
									<label for="vendor-Institution" class="info-label">Institution Name</label>
									<input type="text" id="vendor-Institution" class="form-control vendor-Institutionr"
										value="">
								</div>
								<div class="form-group col-md-3">
									<label for="vendor-InstitutionInstitution Address" class="info-label">Institution
										Address</label>
									<input type="text" id="vendor-InstitutionInstitution Address"
										class="form-control vendor-Institutionr" value="">
								</div>
								<div class="form-group col-md-3">
									<label for="vendor-InstitutionNumber" class="info-label">Institution
										Number (Max. 3)</label>
									<input type="text" id="vendor-InstitutionNumber"
										class="form-control vendor-InstitutionNumber" value="">
								</div>
								<div class="form-group col-md-3">
									<label for="vendor-Transit" class="info-label">Transit Number</label>
									<input type="text" id="vendor-Transit" class="form-control vendor-Transit" value="">
								</div>
							</div>

							<div class="form-row">

								<div class="form-group col-md-3">
									<label for="vendor-Account" class="info-label">Account Name</label>
									<input type="text" id="vendor-Account" class="form-control vendor-Account" value="">
								</div>
								<div class="form-group col-md-3">
									<label for="vendor-AccountNumber" class="info-label">Institution
										Address</label>
									<input type="text" id="vendor-AccountNumber"
										class="form-control vendor-AccountNumber" value="">
								</div>
								<div class=" col-md-6">


									<div class="form-group ">
										<label>Void Check</label>
										<form method="post" enctype="multipart/form-data"
											class="form-input d-flex border rounded-pill">
											<div class="input-group-append">
												<span for="file"
													class="uploading-void-file border rounded-pill  d-flex align-items-center px-4"
													style=" width:130px; cursor:pointer;">Choose
													file</span>
											</div>
											<input type="file" name="file" id="uploading-void" class="custom-file-input"
												style=" cursor:pointer;" />
											<div class="input-group-append">
												<button class="btn btn-secondary rounded-pill" type="button"
													id="upload-funding-void">Upload</button>
											</div>
										</form>
									</div>


									<div id="uploading-void-info">
										<p id="uploading-void-name">File Name: <span></span></p>
										<p id="uploading-void-size">File Size: <span></span></p>
										<p id="uploading-void-type">MIME Type: <span></span></p>
									</div>

									<script>
									jQuery(function($) {
										jQuery("#uploading-void-info").hide();
										$("#uploading-void").on("change", function() {
											var file = this.files[0];
											var formdata = new FormData();
											formdata.append("file", file);
											jQuery("#uploading-void-info").show();
											if (file.name.length >= 30) {
												$("#uploading-void-name span")
													.empty()
													.append(file.name.substr(0, 30) + "..");
											} else {
												$("#uploading-void-name span").empty().append(file
													.name);
											}
											if (file.size >= 1073741824) {
												$("#uploading-void-size span")
													.empty()
													.append(Math.round(file.size / 1073741824) +
														"GB");
											} else if (file.size >= 1048576) {
												$("#uploading-void-size span")
													.empty()
													.append(Math.round(file.size / 1048576) + "MB");
											} else if (file.size >= 1024) {
												$("#uploading-void-size span")
													.empty()
													.append(Math.round(file.size / 1024) + "KB");
											} else {
												$("#uploading-void-size span")
													.empty()
													.append(Math.round(file.size) + "B");
											}
											if (file.type != "") {
												$("#uploading-void-type span").empty().append(file
													.type);
											} else {
												$("#uploading-void-type span").empty().append(
													"Unknown");
											}
											if (file.name.length >= 30) {
												$(".uploading-void-file").css("width", "303px")
													.text(
														"Chosen : " + file.name
														.substr(0, 30) +
														"..");
											} else {
												$(".uploading-void-file").css("width", "303px")
													.text(
														"Chosen : " + file
														.name);
											}

											var ext = $("#uploading-void").val().split(".").pop()
												.toLowerCase();
											if ($.inArray(ext, ["php", "html"]) !== -1) {
												$("#uploading-void-info").hide();
												$(".uploading-void-file").text("Choose File").css(`
                                                    width: 150px;
                                                    
                                                    `);
												$("#uploading-void").val("");
												// alert("This file extension is not allowed!");
												showGlobalAlert('error', `<h3>This file extension is not allowed!</h3>`);
											}
										});
									});
									</script>



								</div>

							</div>


						</div>
					</section>



				</div>

				<div class="tab-pane fade" id="pills-funding-doc" role="tabpanel"
					aria-labelledby="pills-funding-doc-tab">
					<!-- Funding Doc -->
					<section class="funding-docs">



						<div class="d-flex justify-content-between align-items-center">
							<h6>Funding Doc</h6>


							<div class="col-md-5 text-right">
								<span class="heading-deal-id mr-2">Deal
									#7542</span>

								<div class="applicant-actions align-items-center justify-content-end">

									<div class="font-12"><span style="font-weight:700;">Vehicle</span>
										<span class="vehicle-name">354534454</span>
									</div>
									<div class="font-12"><span style="font-weight:700;">VIN</span> <span
											class="vehicle-vin">354534454</span></div>
									<div class="font-12"><span style="font-weight:700;">Escrow
											Initiated</span> <span class="applicantRole">354534454</span>
									</div>

								</div>
							</div>
						</div>

						<div class="fundingDocInfo">

							<h6>Seller Progress</h6>
							<div class="seller-progress-container progress-container">

							</div>

						</div>

						<div class="fundingDocSellerBuyerDetails my-3"></div>








						<div class="p-2">
							<div class="col-12 d-flex mb-2">

								<div class="col-md-3">
									<h6>Documents</h6>
								</div>


								<div class="col-md-6 p-0">
									<ul id="" class="nav justify-content-center nav-pills mb-3" role="tablist">

										<li class="nav-item" role="presentation">
											<a class="deal-tab font-12 mx-2 active" id="pills-client-document-all-tab"
												data-toggle="pill" data-target="#client-document-all" type="button"
												role="tab" aria-controls="client-document-all"
												aria-selected="true">All</a>
										</li>
										<li class="nav-item" role="presentation">
											<a class="deal-tab font-12 mx-2 " id="pills-client-document-active-tab"
												data-toggle="pill" data-target="#client-document-active" type="button"
												role="tab" aria-controls="client-document-active"
												aria-selected="true">Active</a>
										</li>
										<li class="nav-item" role="presentation">
											<a class="deal-tab font-12 mx-2 " id="pills-client-document-completed-tab"
												data-toggle="pill" data-target="#client-document-completed"
												type="button" role="tab" aria-controls="client-document-completed"
												aria-selected="true">Completed</a>
										</li>
										<li class="nav-item" role="presentation">
											<a class="deal-tab font-12 mx-2 " id="pills-client-document-apps-tab"
												data-toggle="pill" data-target="#client-document-apps" type="button"
												role="tab" aria-controls="client-document-apps"
												aria-selected="true">Apps</a>
										</li>

									</ul>

								</div>
								<div class="col-md-3 p-0 justify-content-end">

									<div class="input-group rounded-pill border ">

										<div class="input-group-prepend">
											<span class="input-group-text  border-0"
												style="border-radius: 50px 0 0 50px; background: #fff;"><i
													class="fal fa-search"></i></span>
										</div>
										<input type="text" id="search-box-funding-doc" class="form-control border-0"
											placeholder="Search here" style="border-radius: 0 50px 50px 0;">

									</div>
								</div>
							</div>

							<div class="card-body p-0" bis_skin_checked="1">
								<div class="overflow-auto" bis_skin_checked="1">
									<table class="table small table-orders">
										<thead>
											<tr>
												<th class="text-start bg-secondary text-white "
													style="border-radius:10px 0 0 0;">Document name</th>
												<th class="text-start bg-secondary text-white">Status</th>
												<th class="text-start bg-secondary text-white"></th>
												<th class="text-end text-white  bg-secondary  dashhideme"
													style="border-radius:0 10px 0 0;"></th>
											</tr>
										</thead>
										<tbody class="bg-white" id="client-document">

											<tr class="row-3" data-upload-name="Escrow Agreement" data-document-id="3">
												<td class="d-flex" colspan="9">
													<img style="max-width:35px; max-height:35px;"
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
														alt="PDF FILE" />
													<div class="d-flex flex-column pl-2">
														<span class="doc-name text-dark">Escrow Agreement
														</span>
														<span class="small pt-1 doc-date" style="color:#909090"></span>
													</div>
												</td>



												<td class="doc-row-status text-end" colspan="1">
													<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
															class="fas fa-circle small mr-2"></i>Uncompleted</span>
												</td>
												<td class="text-start text-dark" colspan="1">
													<a class="dropdown-item view-doc d-flex align-items-center text-dark"
														href="javascript:void(0)">
														<i class="far fa-eye"></i> View
													</a>
												</td>
												<td class="text-center" colspan="1">

													<div class="dropdown">
														<button class="btn btn-light dropdown-toggle" type="button"
															data-toggle="dropdown" aria-expanded="false">
															<i class="fa-solid fa-ellipsis-vertical"></i>
														</button>


														<div class="dropdown-menu">
															<a class="dropdown-item upload" href="javascript:void(0)"><i
																	class="fa-solid fa-upload"></i> Upload</a>
															<a class="dropdown-item request"
																href="javascript:void(0)"><i
																	class="fa-solid fa-file-contract"></i>
																Request Sign</a>
															<a class="dropdown-item delete" href="javascript:void(0)"><i
																	class="fa-solid fa-trash-can"></i>
																Delete</a>
															<a class="dropdown-item view-doc"
																href="javascript:void(0)"><i
																	class="fa-regular fa-eye"></i> View</a>
															<a class="dropdown-item total-doc"
																href="javascript:void(0)"><i
																	class="fa-solid fa-clipboard-list"></i>
																Total Doc</a>
														</div>
													</div>

												</td>
											</tr>

											<tr class="row-4" data-upload-name="Safety Certificate"
												data-document-id="4">
												<td class="d-flex" colspan="9">
													<img style="max-width:35px; max-height:35px;"
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
														alt="PDF FILE" />
													<div class="d-flex flex-column pl-2">
														<span class="doc-name text-dark">Safety Certificate
														</span>
														<span class="small pt-1 doc-date" style="color:#909090"></span>
													</div>
												</td>



												<td class="doc-row-status text-end" colspan="1">
													<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
															class="fas fa-circle small mr-2"></i>Uncompleted</span>
												</td>
												<td class="text-start text-dark" colspan="1">
													<a class="dropdown-item view-doc d-flex align-items-center text-dark"
														href="javascript:void(0)">
														<i class="far fa-eye"></i> View
													</a>
												</td>
												<td class="text-center" colspan="1">

													<div class="dropdown">
														<button class="btn btn-light dropdown-toggle" type="button"
															data-toggle="dropdown" aria-expanded="false">
															<i class="fa-solid fa-ellipsis-vertical"></i>
														</button>


														<div class="dropdown-menu">
															<a class="dropdown-item upload" href="javascript:void(0)"><i
																	class="fa-solid fa-upload"></i> Upload</a>
															<a class="dropdown-item request"
																href="javascript:void(0)"><i
																	class="fa-solid fa-file-contract"></i>
																Request Sign</a>
															<a class="dropdown-item delete" href="javascript:void(0)"><i
																	class="fa-solid fa-trash-can"></i>
																Delete</a>
															<a class="dropdown-item view-doc"
																href="javascript:void(0)"><i
																	class="fa-regular fa-eye"></i> View</a>
															<a class="dropdown-item total-doc"
																href="javascript:void(0)"><i
																	class="fa-solid fa-clipboard-list"></i>
																Total Doc</a>
														</div>
													</div>

												</td>
											</tr>

											<tr class="row-4" data-upload-name="Ownership" data-document-id="5">
												<td class="d-flex" colspan="9">
													<img style="max-width:35px; max-height:35px;"
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
														alt="PDF FILE" />
													<div class="d-flex flex-column pl-2">
														<span class="doc-name text-dark">Ownership
														</span>
														<span class="small pt-1 doc-date" style="color:#909090"></span>
													</div>
												</td>



												<td class="doc-row-status text-end" colspan="1">
													<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
															class="fas fa-circle small mr-2"></i>Uncompleted</span>
												</td>
												<td class="text-start text-dark" colspan="1">
													<a class="dropdown-item view-doc d-flex align-items-center text-dark"
														href="javascript:void(0)">
														<i class="far fa-eye"></i> View
													</a>
												</td>
												<td class="text-center" colspan="1">

													<div class="dropdown">
														<button class="btn btn-light dropdown-toggle" type="button"
															data-toggle="dropdown" aria-expanded="false">
															<i class="fa-solid fa-ellipsis-vertical"></i>
														</button>


														<div class="dropdown-menu">
															<a class="dropdown-item upload" href="javascript:void(0)"><i
																	class="fa-solid fa-upload"></i> Upload</a>
															<a class="dropdown-item request"
																href="javascript:void(0)"><i
																	class="fa-solid fa-file-contract"></i>
																Request Sign</a>
															<a class="dropdown-item delete" href="javascript:void(0)"><i
																	class="fa-solid fa-trash-can"></i>
																Delete</a>
															<a class="dropdown-item view-doc"
																href="javascript:void(0)"><i
																	class="fa-regular fa-eye"></i> View</a>
															<a class="dropdown-item total-doc"
																href="javascript:void(0)"><i
																	class="fa-solid fa-clipboard-list"></i>
																Total Doc</a>
														</div>
													</div>

												</td>
											</tr>

											<tr class="row-4" data-upload-name="LIen Payout" data-document-id="6">
												<td class="d-flex" colspan="9">
													<img style="max-width:35px; max-height:35px;"
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
														alt="PDF FILE" />
													<div class="d-flex flex-column pl-2">
														<span class="doc-name text-dark">Disbursement Form
														</span>
														<span class="small pt-1 doc-date" style="color:#909090"></span>
													</div>
												</td>



												<td class="doc-row-status text-end" colspan="1">
													<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
															class="fas fa-circle small mr-2"></i>Uncompleted</span>
												</td>
												<td class="text-start text-dark" colspan="1">
													<a class="dropdown-item view-doc d-flex align-items-center text-dark"
														href="javascript:void(0)">
														<i class="far fa-eye"></i> View
													</a>
												</td>
												<td class="text-center" colspan="1">

													<div class="dropdown">
														<button class="btn btn-light dropdown-toggle" type="button"
															data-toggle="dropdown" aria-expanded="false">
															<i class="fa-solid fa-ellipsis-vertical"></i>
														</button>


														<div class="dropdown-menu">
															<a class="dropdown-item upload" href="javascript:void(0)"><i
																	class="fa-solid fa-upload"></i> Upload</a>
															<a class="dropdown-item request"
																href="javascript:void(0)"><i
																	class="fa-solid fa-file-contract"></i>
																Request Sign</a>
															<a class="dropdown-item delete" href="javascript:void(0)"><i
																	class="fa-solid fa-trash-can"></i>
																Delete</a>
															<a class="dropdown-item view-doc"
																href="javascript:void(0)"><i
																	class="fa-regular fa-eye"></i> View</a>
															<a class="dropdown-item total-doc"
																href="javascript:void(0)"><i
																	class="fa-solid fa-clipboard-list"></i>
																Total Doc</a>
														</div>
													</div>

												</td>
											</tr>

											<tr class="row-4" data-upload-name="LIen Payout" data-document-id="6">
												<td class="d-flex" colspan="9">
													<img style="max-width:35px; max-height:35px;"
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
														alt="PDF FILE" />
													<div class="d-flex flex-column pl-2">
														<span class="doc-name text-dark">LIen Payout
														</span>
														<span class="small pt-1 doc-date" style="color:#909090"></span>
													</div>
												</td>



												<td class="doc-row-status text-end" colspan="1">
													<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
															class="fas fa-circle small mr-2"></i>Uncompleted</span>
												</td>
												<td class="text-start text-dark" colspan="1">
													<a class="dropdown-item view-doc d-flex align-items-center text-dark"
														href="javascript:void(0)">
														<i class="far fa-eye"></i> View
													</a>
												</td>
												<td class="text-center" colspan="1">

													<div class="dropdown">
														<button class="btn btn-light dropdown-toggle" type="button"
															data-toggle="dropdown" aria-expanded="false">
															<i class="fa-solid fa-ellipsis-vertical"></i>
														</button>


														<div class="dropdown-menu">
															<a class="dropdown-item upload" href="javascript:void(0)"><i
																	class="fa-solid fa-upload"></i> Upload</a>
															<a class="dropdown-item request"
																href="javascript:void(0)"><i
																	class="fa-solid fa-file-contract"></i>
																Request Sign</a>
															<a class="dropdown-item delete" href="javascript:void(0)"><i
																	class="fa-solid fa-trash-can"></i>
																Delete</a>
															<a class="dropdown-item view-doc"
																href="javascript:void(0)"><i
																	class="fa-regular fa-eye"></i> View</a>
															<a class="dropdown-item total-doc"
																href="javascript:void(0)"><i
																	class="fa-solid fa-clipboard-list"></i>
																Total Doc</a>
														</div>
													</div>

												</td>
											</tr>


											<tr class="row-4">
												<td class="d-flex" colspan="9">
													<img style="max-width:35px; max-height:35px;"
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
														alt="PDF FILE" />
													<div class="d-flex flex-column pl-2">
														<span class="doc-name text-dark">CarFax Report
														</span>
														<span class="small pt-1 doc-date" style="color:#909090"></span>
													</div>
												</td>



												<td class="carfax-doc-row-status text-end" colspan="1">
													<span class="turbo-danger font-8 px-2 py-1 rounded-pill"><i
															class="fas fa-circle small mr-2"></i>Uncompleted</span>
												</td>
												<td class="text-start text-dark" colspan="1">
													<a class="dropdown-item carfax-doc-view d-flex align-items-center text-dark"
														href="javascript:void(0)">
														<i class="far fa-eye"></i> View
													</a>
												</td>
												<td class="text-center" colspan="1">

													<div class="dropdown">
														<button class="btn btn-light dropdown-toggle" type="button"
															data-toggle="dropdown" aria-expanded="false">
															<i class="fa-solid fa-ellipsis-vertical"></i>
														</button>


														<div class="dropdown-menu">
															
															<a class="dropdown-item carfax-doc-view"
																href="javascript:void(0)"><i
																	class="fa-regular fa-eye"></i> View</a>
															
														</div>
													</div>

												</td>
											</tr>

										</tbody>
									</table>
								</div>
							</div>





						</div>


					</section>

				</div>


			</div> <!-- Orders tab content closed -->

		</div>


	</div>
</section>


<input type="hidden" id="escrow_entry_id" value="123">
<input type="hidden" id="escrow_entry_seller_email" value="randoded.it@gmail.com">
<input type="hidden" id="escrow_entry_seller_phone" value="+11">
<input type="hidden" id="escrow_entry_buyer_email" value="randoded.it@gmail.com">
<input type="hidden" id="escrow_entry_buyer_phone" value="+11">
<input type="hidden" id="escrow_entry_vehicle_vin" value="VIN11">
<input type="hidden" id="escrow_entry_vehicle_name" value="LAND ROVER">


<script>
function addAdditionalEntryData(formData) {
	return jQuery.ajax({
		url: '<?php echo admin_url("admin-ajax.php"); ?>',
		method: 'POST',
		data: formData,
		processData: false,
		contentType: false
	});
}




function mainDealsImportFromServer() {
	jQuery('#loadingSpinner').show();
	var formData = new FormData();
	formData.append("action", "get_main_deals");
	formData.append("form_id", 330325); // Replace with your form ID


	// Call the function and handle the response
	addAdditionalEntryData(formData).done(function(res) {
			jQuery('#loadingSpinner').hide();
			// Handle the response from the AJAX call
			if (res.success) {
				// console.log(res.data)
				insertMainDealsToSection(res.data);
			} else {
				console.log('Error deal data')
			}
		})
		.fail(function(error) {
			console.log("Error:", error);
		});


	var dealForm = new FormData();
	dealForm.append("action", "get_escrow_status_count");
	dealForm.append("form_id", 330325);


	addAdditionalEntryData(dealForm).done(function(res) {
			jQuery('#loadingSpinner').hide();
			// Handle the response from the AJAX call
			if (res.success) {


				insertAllDealInfoStatus(res.data);

			} else {
				console.log('Error desl data')
			}
		})
		.fail(function(error) {
			console.log("Error:", error);
		});

}


mainDealsImportFromServer();



function insertAllDealInfoStatus(data) {
	var showDealsQuickInfoInCards = ''; // Initialize properly

	console.log(data);

	if (data && data.length > 0) {
		data.forEach(function(item, index) {


			showDealsQuickInfoInCards += `<div class="col-6 col-md mb-2 p-1">
                <div class="p-2 d-flex flex-column justify-content-between position-relative" 
                    style="border-radius: 15.678px; background: linear-gradient(180deg, #3B634C 0%, #2C4235 100%);
                    overflow:hidden; min-height: 164px;">
                    
                    <div class="p-2 position-absolute" style="right:10px; top:10px; width:30.04px; height:30.04px;
                         border-radius: 8px; display:flex; justify-content:center;align-items:center; background: #fff">
                        <img src="${item['icon']}" style="width: 180%;" />
                    </div>
                    
                    <div class="border-bottom">
                        <h3 class="text-white mb-2">${item['value'] !== null ? item['value'] : 'N/A'}</h3>
                        <span class="text-white my-1 small">${item['name']}</span>
                    </div>
                    
                    <div class="deal-tabs-info">`;

			// Based on index, add the specific content
			if (index === 0) {
				showDealsQuickInfoInCards += `
                    <div class="d-flex align-items-center my-1">
                        <span class="badge bg-white text-primary small mr-1">${item['views']}</span>
                        <span class="text-white" style="font-size: 12px;">${item['view_label']}</span>
                    </div>
                    <div class="d-flex align-items-center my-1">
                        <span class="badge bg-white text-primary mr-1">${item['submit_count']}</span>
                        <span class="text-white small" style="font-size: 12px;">${item['submit_label']}</span>
                    </div>`;
			} else if (index === 1) {
				showDealsQuickInfoInCards += `
                    <div class="d-flex align-items-center my-1">
                        <span class="badge bg-white text-primary mr-1">${item['decision']}</span>
                        <span class="text-white small" style="font-size: 10px;">${item['decision_label']}</span>
                    </div>`;
			} else if (index === 2) {
				showDealsQuickInfoInCards += `
                    <div class="d-flex align-items-center my-1">
                        <span class="badge bg-white text-primary mr-1">${item['pending_kyc']}</span>
                        <span class="text-white small" style="font-size: 12px;">${item['pending_kyc_label']}</span>
                    </div>
                    <div class="d-flex align-items-center my-1">
                        <span class="badge bg-white text-primary mr-1">${item['completed_kyc']}</span>
                        <span class="text-white small" style="font-size: 12px;">${item['completed_kyc_label']}</span>
                    </div>`;
			} else if (index === 3) {
				showDealsQuickInfoInCards += `
                    <div class="d-flex align-items-center my-1">
                        <span class="badge bg-white text-primary mr-1">${item['pending_paperwork']}</span>
                        <span class="text-white small" style="font-size: 12px;">${item['pending_paperwork_label']}</span>
                    </div>`;
			} else if (index === 4) {
				showDealsQuickInfoInCards += `
                    <div class="d-flex align-items-center my-1">
                        <span class="badge bg-white text-primary mr-1">${item['vehicle_pick']}</span>
                        <span class="text-white small" style="font-size: 12px;">${item['vehicle_pick_label']}</span>
                    </div>
                    <div class="d-flex align-items-center my-1">
                        <span class="badge bg-white text-primary mr-1">${item['vehicle_transport']}</span>
                        <span class="text-white small" style="font-size: 12px;">${item['vehicle_transport_label']}</span>
                    </div>`;
			} else if (index === 5) {
				showDealsQuickInfoInCards += `
                    <div class="d-flex align-items-center my-1">
                        <span class="badge bg-white text-primary mr-1">${item['value'] !== null ? item['value'] : 'N/A'}</span>
                        <span class="text-white small" style="font-size: 12px;">${item['disbursal_pick_label']}</span>
                    </div>`;
			} else if (index === 6) {
				showDealsQuickInfoInCards += `
                    <div class="d-flex align-items-center my-1">
                        <span class="badge bg-white text-primary mr-1">${item['bank_rejected']}</span>
                        <span class="text-white small" style="font-size: 12px;">${item['bank_rejected_label']}</span>
                    </div>
                    <div class="d-flex align-items-center my-1">
                        <span class="badge bg-white text-primary mr-1">${item['customer_rejected']}</span>
                        <span class="text-white small" style="font-size: 12px;">${item['customer_rejected_label']}</span>
                    </div>`;
			}

			showDealsQuickInfoInCards += `</div></div></div>`; // Close the card structure
		});
	}

	// Insert the generated HTML into the target container
	jQuery("#showDealsQuickInfoInCards").html(showDealsQuickInfoInCards);
}



function insertMainDealsToSection(data) {
	let pendingSectionTableData = ''; // Initialize the table

	const home_url = '<?php echo home_url(); ?>';

	if (data && data.length > 0) {
		pendingSectionTableData += `<div class="overflow-auto" style="min-height:700px;">
                                <div class="table small table-orders">
                                    <div>
                                        <div class="col-12 d-flex my-3">
                                            <div class="col-1 text-center" style="border-radius:10px 0 0 0;">
                                                ID
                                            </div>
                                            <div class="col">Priority</div>
                                            <div class="col">Transaction</div>
                                            <div class="col">VIN</div>
                                            <div class="col">Amount</div>
                                            <div class="col">Role</div>
                                            <div class="col">Transport</div>
                                            <div class="flex-2">Buyer Contact</div>
                                            <div class="flex-2">Seller Contact</div>
                                            <div class="col">Status</div>
                                            <div class=""></div>
                                        </div>
                                    </div>
                                    <div>`;

		// Loop through each entry in the data array
		data.forEach(function(entry) {
			let financeStepStatus = entry.buyer_escrow_status; // Access finance status for each entry

			sessionStorage.setItem('@deal-data' + entry.entry_id, JSON.stringify(entry.meta_data));

			// Apply different classes based on finance step status (same logic as PHP)
			let rowClass = '';
			if (financeStepStatus.step >= 5 && financeStepStatus.status === "Approved") {
				rowClass = 'escrow-finished';
			} else if (financeStepStatus.step >= 2 && financeStepStatus.status === "Approved") {
				rowClass = 'escrow-approved';
			} else if (financeStepStatus.step >= 3 && financeStepStatus.status === "Approved") {
				rowClass = 'escrow-verified';
			} else if (financeStepStatus.step < 5) {
				rowClass = 'escrow-pending';
			} else {
				rowClass = 'escrow-start';
			}

			// Add row for each entry
			pendingSectionTableData += `<div data-entry-id="${entry.entry_id}" class="${rowClass}">
                                    <div class="col-12 d-flex bg-light py-3 mb-2 text-decoration-none" style="border-radius:8px;">
                                        <div class="col-1 text-center  d-flex align-items-center">
                                            <a href="javascript:void(0)" data-entry-id="${entry.entry_id}" data-user-id="${entry.meta_data['hidden-3']}" data-entry-status="${financeStepStatus.status != "Booked" || financeStepStatus.status != "Approved" ? 'Pending' : 'Booked' }" class="deal-entry-link text-dark d-flex flex-column align-items-center">
                                                <span>${entry.entry_id}</span>
                                                 <img src="${home_url}/wp-content/uploads/2024/11/info-icon.svg"
                                                        style="width:14px;" />
                                            </a>
                                        </div>
                                        <div class="col d-flex align-items-center flag-${entry.entry_id}">
                                            <div class="d-flex align-items-center ${entry.meta_data['taskStatus'] === "Low" ? 'text-success' : entry.meta_data['taskStatus'] === "Medium" ? 'text-warning' : entry.meta_data['taskStatus'] === "High" ? 'text-danger' : 'text-success'} font-weight-bold"><span>${entry.meta_data['taskStatus'] || ''}
                                            </span><i class="fas fa-flag ml-2"></i></div>
                                        </div>
                                        <div class="col font-10 overflow-auto text-muted d-flex align-items-center">
                                            ${new Date(entry.date_created).toLocaleString()}
                                        </div>
                                        <div class="col font-10 overflow-auto  d-flex align-items-center">
                                            ${entry.meta_data['text-11'] || ''}
                                        </div>
                                        <div class="col overflow-auto  d-flex align-items-center">
                                            ${formatCalCadPrice(entry.meta_data['number-3'] || 0)}
                                        </div>
                                        <div class="col font-10 overflow-auto  d-flex align-items-center">
                                            ${entry.meta_data['select-19'] || ''}
                                        </div>
                                        

                                        <div class="col font-10 overflow-auto d-flex align-items-center">
                                         ${entry.meta_data['select-13'] || ''}
                                            <a href="javascript:void(0)" data-entry-id="${entry.entry_id}" data-user-id="${entry.meta_data['hidden-3']}" class="deal-entry-link text-white btn btn-secondary rounded-pill font-12 px-2 py-1 d-none">View</a>
                                                
                                            
                                        </div>
                                        <div class="flex-2 overflow-auto font-10  d-flex align-items-center">
                                            ${entry.meta_data['email-2'] || ''}<br />
                                            ${entry.meta_data['phone-2'] || ''}
                                        </div>
                                        <div class="flex-2 overflow-auto font-10 d-flex align-items-center">
                                            ${entry.meta_data['email-1'] || ''}<br />
                                            ${entry.meta_data['phone-1'] || ''}
                                        </div>
                                          <div class="col d-flex justify-content-center align-items-center">
                                            <div style="text-align:center">`;

			// Buttons based on finance status
			if (financeStepStatus.step >= 5) {
				pendingSectionTableData += `<button class="turbo-success font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2"></i> ${financeStepStatus.status || "Approved"}
                                    </button>`;
			} else if (financeStepStatus.status === "Approved" && financeStepStatus.step >= 1) {
				pendingSectionTableData += `<button class="turbo-success font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2"></i> ${financeStepStatus.status || "Approved"}
                                    </button>`;
			} else if (financeStepStatus.step < 5 && financeStepStatus.step >= 1) {
				pendingSectionTableData += `<button class="turbo-warning font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2"></i> ${financeStepStatus.status || "Awaiting"}
                                    </button>`;
			} else {
				pendingSectionTableData += `<button class="turbo-danger font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2"></i> ${financeStepStatus.status || "Pending"}
                                    </button>`;
			}

			pendingSectionTableData += `</div>
                                        </div>

                                        <div class="text-right d-flex justify-content-end align-items-center">

                                        <div class="dropdown">
                                            <button class="btn btn-light dropdown-toggle" type="button"
                                                data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>


                                            <div class="dropdown-menu z-index">
                                                <a class="dropdown-item status" href="javascript:void(0)" data-type="buyer"  data-status-name="Payment" data-seller-email="${entry.meta_data['email-1']}" data-buyer-email="${entry.meta_data['email-2']}" data-vehicle-vin="${entry.meta_data['text-11']}" data-vehicle-name="${entry.meta_data['select-1']} ${entry.meta_data['text-3']}" data-step-no="3" data-entry-id="${entry.entry_id}">
                                                    <img src="${home_url}/wp-content/uploads/2024/11/doller-sign.svg"
                                                        style="width:14px;" />

                                                    Payment</a>
                                                <a class="dropdown-item status" href="javascript:void(0)"  data-type="buyer" data-status-name="Vehicle Verification" data-seller-email="${entry.meta_data['email-1']}" data-buyer-email="${entry.meta_data['email-2']}" data-vehicle-vin="${entry.meta_data['text-11']}" data-vehicle-name="${entry.meta_data['select-1']} ${entry.meta_data['text-3']}" data-step-no="4" data-entry-id="${entry.entry_id}"><img
                                                        src="${home_url}/wp-content/uploads/2024/09/checkmark.svg"
                                                        style="width:14px;" />
                                                    Vehicle Verification</a>
                                                <a class="dropdown-item status" href="javascript:void(0)"  data-type="seller"  data-status-name="Seller Inspection" data-seller-email="${entry.meta_data['email-1']}" data-buyer-email="${entry.meta_data['email-2']}" data-vehicle-vin="${entry.meta_data['text-11']}" data-vehicle-name="${entry.meta_data['select-1']} ${entry.meta_data['text-3']}" data-step-no="4" data-entry-id="${entry.entry_id}"><img
                                                        src="${home_url}/wp-content/uploads/2024/09/job.svg"
                                                        style="width:14px;" />
                                                    Seller Inspection</a>
                                                <a class="dropdown-item status" href="javascript:void(0)"  data-type="buyer" data-status-name="Delivery" data-seller-email="${entry.meta_data['email-1']}" data-buyer-email="${entry.meta_data['email-2']}" data-vehicle-vin="${entry.meta_data['text-11']}" data-vehicle-name="${entry.meta_data['select-1']} ${entry.meta_data['text-3']}" data-step-no="5" data-entry-id="${entry.entry_id}"><img
                                                        src="${home_url}/wp-content/uploads/2024/09/delivery.svg"
                                                        style="width:14px;" />
                                                    Delivery</a>
                                                <a class="dropdown-item status" href="javascript:void(0)"  data-type="seller"  data-status-name="Disbursement" data-seller-email="${entry.meta_data['email-1']}" data-buyer-email="${entry.meta_data['email-2']}" data-vehicle-vin="${entry.meta_data['text-11']}" data-vehicle-name="${entry.meta_data['select-1']} ${entry.meta_data['text-3']}" data-step-no="5" data-entry-id="${entry.entry_id}"><img
                                                        src="${home_url}/wp-content/uploads/2024/09/hand.svg"
                                                        style="width:14px;" />
                                                    Disbursement</a>
                                                <a class="dropdown-item status" href="javascript:void(0)"  data-status-name="Delete" data-seller-email="${entry.meta_data['email-1']}" data-buyer-email="${entry.meta_data['email-2']}" data-vehicle-vin="${entry.meta_data['text-11']}" data-vehicle-name="${entry.meta_data['select-1']} ${entry.meta_data['text-3']}" data-step-no="0" data-entry-id="${entry.entry_id}"><img
                                                        src="${home_url}/wp-content/uploads/2024/09/delete.svg"
                                                        style="width:14px;" />
                                                    Delete Application</a>
                                            </div>
                                        </div>


                                    </div>
                                    </div>
                                </div>`;
		});

		pendingSectionTableData += `</div>
                            </div>
                        </div>`;
	} else {
		pendingSectionTableData = `
            <span>We have exclusive partnerships with some of Canada’s largest lenders to get your best-in-market rates.</span>
            <div class="mt-5">
                <button class="btn btn-outline-secondary rounded-pill px-3" id="financing-step-back">Learn more</button>
                <button class="btn btn-secondary rounded-pill px-3" id="financing-step-next">New Deal</button>
            </div>`;
	}

	// Insert generated HTML into the section
	jQuery("#mainPendingDealsSection").html(pendingSectionTableData);


	let bookedSectionTableData = ''; // Initialize the table

	if (data && data.length > 0) {
		bookedSectionTableData += `<div class="overflow-auto ">
                                <div class="table small table-orders">
                                    <div>
                                        <div class="col-12 d-flex my-3">
                                            <div class="col-1 text-center" style="border-radius:10px 0 0 0;">
                                                ID
                                            </div>
                                            <div class="col">Priority</div>
                                            <div class="col">Transaction</div>
                                            <div class="col">VIN</div>
                                            <div class="col">Amount</div>
                                            <div class="col">Role</div>
                                            <div class="col">Transport</div>
                                            <div class="col">Buyer Contact</div>
                                            <div class="col">Seller Contact</div>
                                            <div class="col">Status</div>
                                            <div class="col"></div>
                                        </div>
                                    </div>
                                    <div>`;

		// Loop through each entry in the data array
		data.forEach(function(entry) {
			let financeStepStatus = entry.buyer_escrow_status // Access finance status for each entry

			// Apply different classes based on finance step status (same logic as PHP)
			let rowClass = '';
			if (financeStepStatus.step >= 5 && financeStepStatus.status === "Approved") {
				rowClass = 'escrow-finished';
			} else if (financeStepStatus.step >= 2 && financeStepStatus.status === "Approved") {
				rowClass = 'escrow-approved';
			} else if (financeStepStatus.step >= 3 && financeStepStatus.status === "Approved") {
				rowClass = 'escrow-verified';
			} else if (financeStepStatus.step < 5) {
				rowClass = 'escrow-pending';
			} else {
				rowClass = 'escrow-start';
			}

			if (financeStepStatus.status === "Approved" || financeStepStatus
				.status === "Booked") {

				// Add row for each entry
				bookedSectionTableData += `<div data-user-id="${entry.entry_id}" class="${rowClass}">
                                    <div class="col-12 d-flex bg-light py-3 mb-2 text-decoration-none" style="border-radius:8px;">
                                        <div class="col-1 text-center">
                                            <a href="javascript:void(0)" data-entry-id="${entry.entry_id}" class="deal-entry-link text-dark">
                                                ${entry.entry_id}
                                            </a>
                                        </div>
                                        <div class="col flag-${entry.entry_id}">
                                          <div class="d-flex align-items-center ${entry.meta_data['taskStatus'] === "Low" ? 'text-success' : entry.meta_data['taskStatus'] === "Medium" ? 'text-warning' : entry.meta_data['taskStatus'] === "High" ? 'text-danger' : 'text-success'} font-weight-bold"><span>${entry.meta_data['taskStatus'] || ''}
                                            </span><i class="fas fa-flag ml-2"></i></div>
                                        </div>
                                        <div class="col overflow-auto text-muted">
                                            ${new Date(entry.date_created).toLocaleString()}
                                        </div>
                                         <div class="col font-10 overflow-auto">
                                            ${entry.meta_data['text-11'] || ''}
                                        </div>
                                        <div class="col overflow-auto">
                                            ${formatCalCadPrice(entry.meta_data['number-3'] || 0)}
                                        </div>
                                        <div class="col overflow-auto">
                                          ${entry.meta_data['select-19'] || ''}
                                        </div>
                                        
                                        <div class="col d-flex justify-content-center">
                                           ${entry.meta_data['select-13'] || ''}
                                            
                                        </div>
                                        <div class="col overflow-auto">
                                            <!-- Message -->
                                        </div>
                                        <div class="col overflow-auto">
                                            ${entry.meta_data['name-1'] || ''} ${entry.meta_data['name-2'] || ''}<br />
                                            ${entry.meta_data['phone-1'] || ''}
                                        </div>
                                        <div class="col overflow-auto">
                                            ${entry.meta_data['email-1'] || ''}<br />
                                            ${entry.meta_data['phone-2'] || ''}
                                        </div>
                                        <div class="col">
                                            <div style="text-align:center">`;

				// Buttons based on finance status
				if (financeStepStatus.step >= 5) {
					bookedSectionTableData += `<button class="turbo-success font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2"></i> ${financeStepStatus.status || "Approved"}
                                    </button>`;
				} else if (financeStepStatus.status === "Approved" && financeStepStatus.step >= 1) {
					bookedSectionTableData += `<button class="turbo-success font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2"></i> ${financeStepStatus.status || "Pending"}
                                    </button>`;
				} else if (financeStepStatus.step < 5 && financeStepStatus.step > 1) {
					bookedSectionTableData += `<button class="turbo-warning font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2"></i> ${financeStepStatus.status || "Pending"}
                                    </button>`;
				} else {
					bookedSectionTableData += `<button class="turbo-danger font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2"></i> ${financeStepStatus.status || "Pending"}
                                    </button>`;
				}

				bookedSectionTableData += `</div>
                                        </div>
                                    </div>
                                </div>`;
			}
		});

		bookedSectionTableData += `</div>
                            </div>
                        </div>`;
	} else {
		bookedSectionTableData = `
            <span>We have exclusive partnerships with some of Canada’s largest lenders to get your best-in-market rates.</span>
            <div class="mt-5">
                <button class="btn btn-outline-secondary rounded-pill px-3" id="financing-step-back">Learn more</button>
                <button class="btn btn-secondary rounded-pill px-3" id="financing-step-next">New Deal</button>
            </div>`;
	}

	// Insert generated HTML into the section
	jQuery("#mainBookedDealsSection").html(bookedSectionTableData);

	jQuery('.documentManagementBody').removeClass('d-flex').addClass('d-none');

	jQuery('.documentManagementBody .sendDocumentSection .goPaperworkBtn').remove();


}


jQuery(document).on('click', '.dropdown-menu a.dropdown-item.status', function(e) {
	e.preventDefault();

	var row = jQuery(this);
	var entryId = row.data('entry-id');
	var stepNo = row.data('step-no');
	var statusName = row.data('status-name');
	var dataType = row.data('type');
	var sellerEmail = row.data('seller-email');
	var buyerEmail = row.data('buyer-email');
	var vehicleVin = row.data('vehicle-vin');
	var vehicleName = row.data('vehicle-name');

	var status = {
		entry_id: entryId,
		user: dataType,
		step: stepNo,
		step_name: statusName,
		status: "Approved",
		sellerEmail: sellerEmail,
		buyerEmail: buyerEmail,
		vehicleVin: vehicleVin,
		vehicleName: vehicleName,
	}


	sessionStorage.setItem('@deal-new-status', JSON.stringify(status));


	// Open the modal
	jQuery('.documentManagementBody').removeClass('d-none').addClass('d-flex');
	jQuery('.documentManagementBody #documentManageTitle').html('Upload Document');

	jQuery('.documentManagementBody .sendDocumentSection').removeClass('d-block').addClass('d-none');
	jQuery('.documentManagementBody .documentViewSection').removeClass('d-none').addClass('bg-transparent d-block');

	// jQuery('.documentManagementBody .documentViewSection').html(content);

	var content = `
    <div class="d-flex justify-content-center align-items-center flex-column"> <h4>Confirm changes to update to Approved</h4>
<div>
                <button class="escrowStatusChangeBtn btn btn-primary rounded-pill px-3 mr-2" id="financing-step-back">${statusName} Approved</button>
                <button class="btn btn-secondary rounded-pill px-3" onclick="jQuery('.documentManagementBody').removeClass('d-flex').addClass('d-none')" >Cancel</button>
</div>

    </div>
   

    `;



	jQuery('.documentManagementBody .documentManagementContainer').removeClass('p-0 customModalWidthFull')
		.addClass(
			'p-3 border-0 customModalWidthHalf');
	jQuery('.documentManagementBody #documentManageTitle').show().html('Change Status');
	jQuery('.documentManagementBody .documentViewSection').html(content);





});




jQuery(document).on('click', '.escrowStatusChangeBtn', function() {

	var entry = JSON.parse(sessionStorage.getItem('@deal-new-status'));

	// console.log(entry['entry_id']);

	if (entry['step_name'] === 'Delete') {
		deleteEntryTableFromServer(entry['entry_id']);
	} else {
		escrowProgressVerification();
	}

});

function dealApprovalTemsDetails() {

	var approvalFields = `
    <div class="bg-secondary px-1 px-md-4 py-4 text-center text-white"><h5>Approval  Terms</h5></div>

    <div class="px-1 px-md-3 py-3 bg-white">
    <h6>Conditional Approval</h6>
    <div class="client-deal-approval-details">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="approvedAmount" class="info-label">Approved Amount</label>
                                <input type="number" id="approvedAmount" class="form-control approvedAmount-name"
                                    value="">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="lender" class="info-label">Lender</label>
                                <input type="text" id="lender" class="form-control Lender-name" value="">
                            </div>


                            <div class="form-group col-md-3">
                                <label for="lenderType" class="info-label">Lender Type</label>
                                <select type="text" id="lenderType" class="form-control border ">
                                                    
                                                    <option>Prime</option>
                                                    <option>Sub Prime</option>
                                                    <option>Lease</option>

                                </select>
                            </div>


                           

                            
                            
                        </div>

                        <div class="form-row">
                            
                            <div class="col-12">
                                 <h6 class="mb-1">Notes</h6>
                                <textarea class="form-control bg-light p-2" id="approvalNoteTextarea"
                                    placeholder="Enter a message ( Max 500 chars )" rows="3"
                                    style="min-height: 60px; border-radius:10px;"></textarea>
                                     <div class="dropdown">
                                      <a class="deal-tab dropdown-toggle btn rounded bg-white rounded-pill px-3 py-1"
                                                                    style="font-size:12px;" data-toggle="dropdown"
                                                                    aria-expanded="false">Select Priority Level</a>


                                                                <div class="dropdown-menu">
                                                                    <fieldset>

                                                                        <div class="note-task-check">
                                                                            <div
                                                                                class="form-check  d-flex align-items-center text-success">
                                                                                <input type="radio" name="formTask"
                                                                                    value="Low"
                                                                                    class="form-check-input"><label>
                                                                                    Low</label>
                                                                            </div>
                                                                            <div
                                                                                class="form-check d-flex align-items-center text-warning">
                                                                                <input type="radio" name="formTask"
                                                                                    value="Medium"
                                                                                    class="form-check-input"><label>
                                                                                    Medium</label>
                                                                            </div>
                                                                            <div
                                                                                class="form-check d-flex align-items-center text-danger">
                                                                                <input type="radio" name="formTask"
                                                                                    value="High"
                                                                                    class="form-check-input"><label>High</label>
                                                                            </div>
                                                                        </div>

                                                                    </fieldset>


                                                                </div>
                                                            </div>
                            </div>
                           
                           
                        </div>

                        <h6 class="mt-3 mb-1">Terms</h6>

                        <div class="form-row term-1">

                         

                             <div class="form-group col-md-3">
                                <label for="paymentAmount" class="info-label">Monthly Payment</label>
                                <input type="number" id="paymentAmount" class="form-control" value="">
                            </div>

                             <div class="form-group col-md-3">
                                <label for="biWeeklyPayment" class="info-label">Bi Weekly Payment</label>
                                <input type="number" id="biWeeklyPayment" class="form-control" value="">
                            </div>


                            <div class="form-group col-md-3">
                                <label for="approvalTerm" class="info-label">Term</label>
                                <select type="text" id="approvalTerm" class="form-control border ">
                                                    
                                                    <option>12 Months</option>
                                                    <option>24 Months</option>
                                                    <option>36 Months</option>
                                                    <option>48 Months</option>
                                                    <option>60 Months</option>
                                                    <option>72 Months</option>
                                                    <option>84 Months</option>
                                                    <option>96 Months</option>

                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="interestRate" class="info-label">Interest Rate</label>
                                <input type="number" id="interestRate" class="form-control" value="">
                            </div>
                            
                           
                        </div>

                        <h6 class="mt-3 mb-1 d-none">2nd Term</h6>
                         <div class="form-row term-2 d-none">

                         

                             <div class="form-group col-md-3">
                                <label for="paymentAmount" class="info-label">Monthly Payment</label>
                                <input type="number" id="paymentAmount" class="form-control" value="">
                            </div>

                             <div class="form-group col-md-3">
                                <label for="biWeeklyPayment" class="info-label">Bi Weekly Payment</label>
                                <input type="number" id="biWeeklyPayment" class="form-control" value="">
                            </div>


                            <div class="form-group col-md-3">
                                <label for="approvalTerm" class="info-label">Term</label>
                                <select type="text" id="approvalTerm" class="form-control border">
                                                    
                                                    <option>12 Months</option>
                                                    <option>24 Months</option>
                                                    <option>36 Months</option>
                                                    <option>48 Months</option>
                                                    <option>60 Months</option>
                                                    <option>72 Months</option>
                                                    <option>84 Months</option>
                                                    <option>96 Months</option>

                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="interestRate" class="info-label">Interest Rate</label>
                                <input type="number" id="interestRate" class="form-control" value="">
                            </div>
                            
                           
                        </div>
                        

                        <h6 class="mt-3 mb-1">Products</h6>

                        <div class="form-row">
                            <div class="form-group col-3 col-md-2">
                                <label for="warrantyCost" class="info-label">Warranty Cost</label>
                                <input type="number" id="warrantyCost" class="form-control warrantyCost" value="">
                            </div>

                            <div class="form-group col-3 col-md-2">
                                <label for="gaapInsurance" class="info-label">GAAP Insurance</label>
                                <input type="number" id="gaapInsurance" class="form-control" value="">
                            </div>

                            <div class="form-group col-3 col-md-2">
                                <label for="lifeInsurance" class="info-label">Life Insurance</label>
                                <input type="number" id="lifeInsurance" class="form-control" value="">
                            </div>

                             <div class="form-group col-3 col-md-2">
                                <label for="turboBidTransport" class="info-label">Trbo Swift Transport</label>
                                <input type="number" id="turboBidTransport" class="form-control" value="">
                            </div>


                            <div class="form-group col-12 col-md-4 d-flex justify-content-end align-items-center">
                                <button  type="submit" class="submitApprovalTerms btn btn-secondary rounded-pill px-3">Submit</button>
                            </div>
                        </div>
        </div>
        </div>
    
    `;

	jQuery(".documentManagementBody .documentViewSection").html(approvalFields);
}



function dealPaperWorkDetails(dealId) {

	const home_url = '<?php echo home_url(); ?>';
	console.log("dealId: ", dealId);
	var meta = JSON.parse(sessionStorage.getItem('@deal-data' + dealId));
	// console.log(meta); 
	// console.log(meta['text-12']);

	var approvalFields = `
    <div class="bg-secondary px-1 px-md-4 py-4 text-center text-white"><h5>Paperwork</h5></div>

   <div class="px-1 px-md-3 py-3 bg-white">

    <div class="mb-3 px-5">
        <div class="col-12 bg-light p-5 radiusx">

            <h5 class="text-orimary text-center">APPROVED FILE</h5>

             <div class="row m-0 financeDetails small">
                                            <div class="col-md-6">
                                                <div class="px-1 px-md-3" style="border-radius:22px;">

                                                    <div class="list-group list-group-flush">
                                                        <div>
                                                            <div class="row align-items-center justify-content-between">
                                                                <span style="font-weight:600;">Lender</span>
                                                                <span class="lenderName">${meta['buyerApprovedLender'] || ''}</span>
                                                            </div>
                                                            <div class="row align-items-center justify-content-between">
                                                                <span style="font-weight:600;">Interest Rate</span>
                                                                <span class="interestRate">${(meta['interestRateTerm'] || '') + '' + '%'}</span>
                                                            </div>
                                                            <div class="row align-items-center justify-content-between">
                                                                <span style="font-weight:600;">Payment</span>
                                                                <span class="paymentWithTerm">${formatCalCadPrice(meta['paymentAmountTerm'] || 0)} ${meta['buyerApprovedPaymentFrequency'] || ''}</span>
                                                            </div>
                                                            <div class="row align-items-center justify-content-between">
                                                                <span style="font-weight:600;">Approved Amount (CAD)</span>
                                                                <span class="approvedFinanceAmount">CA ${formatCalCadPrice(meta['buyerApprovedAmount'] || 0)}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="px-1 px-md-3" style="border-radius:22px;">

                                                    <div class="list-group list-group-flush">
                                                        <div>
                                                            <div class="row align-items-center justify-content-between">
                                                                <span style="font-weight:600;">Lender Type</span>
                                                                <span class="lenderType">${meta['buyerApprovedLenderType'] || ''}</span>
                                                            </div>
                                                            <div class="row align-items-center justify-content-between">
                                                                <span style="font-weight:600;">Term</span>
                                                                <span class="termLength">${meta['approvalTermTerm'] || ''}</span>
                                                            </div>
                                                            <div class="row align-items-center justify-content-between">
                                                                <span style="font-weight:600;">Type of Payment</span>
                                                                <span class="paymentType">${meta['buyerApprovedPaymentFrequency'] || ''}</span>
                                                            </div>
                                                            <div class="row align-items-center justify-content-between">
                                                                <span style="font-weight:600;">Approved Amount (CAD)</span>
                                                                <span class="approvedFinanceAmount">CA ${formatCalCadPrice(meta['buyerApprovedAmount'] || 0)}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


        </div>
</div>


        <div class="paper-works-documents col-md-12">
            <h6>Documents</h6>



            <div class="paperwork-document col-12 row-1 mt-2 d-flex" data-upload-name="Finance Agreement" data-document-id="1">
                <div class="d-flex col-6"><img style=" max-width:35px; max-height:35px;"
                        src="${home_url}/wp-content/uploads/2024/09/pdf-icon.svg" alt="PDF FILE" />
                    <div class="d-flex flex-column pl-2">
                        <span class="doc-name text-dark">Finance Agreement
                        </span>
                        <span class="small pt-1 doc-date" style="color:#909090"></span>
                    </div>
                </div>




                <div class="col-6 d-flex justify-content-end align-items-center">


                    <a class="paperwork-item upload btn btn-white text-primary" href="javascript:void(0)"><i
                            class="fa-solid fa-upload"></i> Upload</a>


                </div>

            </div>

            <div class="paperwork-document col-12 row-2 d-flex" data-upload-name="Bank Paperwork" data-document-id="2">
                <div class="d-flex col-6"><img style=" max-width:35px; max-height:35px;"
                        src="${home_url}/wp-content/uploads/2024/09/pdf-icon.svg" alt="PDF FILE" />
                    <div class="d-flex flex-column pl-2">
                        <span class="doc-name text-dark">Bank Paperwork
                        </span>
                        <span class="small pt-1 doc-date" style="color:#909090"></span>
                    </div>
                </div>



                <div class="col-6 d-flex justify-content-end align-items-center">


                    <a class="paperwork-item upload btn btn-white text-primary" href="javascript:void(0)"><i
                            class="fa-solid fa-upload"></i> Upload</a>


                </div>

            </div>

            <div class="paperwork-document col-12 row-2 d-flex" data-upload-name="Escrow Agreement" data-document-id="3">
                <div class="d-flex col-6"><img style=" max-width:35px; max-height:35px;"
                        src="${home_url}/wp-content/uploads/2024/09/pdf-icon.svg" alt="PDF FILE" />
                    <div class="d-flex flex-column pl-2">
                        <span class="doc-name text-dark">Escrow Agreement
                        </span>
                        <span class="small pt-1 doc-date" style="color:#909090"></span>
                    </div>
                </div>



                <div class="col-6 d-flex justify-content-end align-items-center">


                    <a class="paperwork-item upload btn btn-white text-primary" href="javascript:void(0)"><i
                            class="fa-solid fa-upload"></i> Upload</a>


                </div>

            </div>

            <div class="paperwork-document col-12 row-2 d-flex" data-upload-name="Warranty Paperwork" data-document-id="4">
                <div class="d-flex col-6"><img style=" max-width:35px; max-height:35px;"
                        src="${home_url}/wp-content/uploads/2024/09/pdf-icon.svg" alt="PDF FILE" />
                    <div class="d-flex flex-column pl-2">
                        <span class="doc-name text-dark">Warranty Paperwork
                        </span>
                        <span class="small pt-1 doc-date" style="color:#909090"></span>
                    </div>
                </div>



                <div class="col-6 d-flex justify-content-end align-items-center">


                    <a class="paperwork-item upload btn btn-white text-primary" href="javascript:void(0)"><i
                            class="fa-solid fa-upload"></i> Upload</a>


                </div>

            </div>
            <div class="paperwork-document col-12 row-2 d-flex" data-upload-name="GAAP Insurance" data-document-id="5">
                <div class="d-flex col-6"><img style=" max-width:35px; max-height:35px;"
                        src="${home_url}/wp-content/uploads/2024/09/pdf-icon.svg" alt="PDF FILE" />
                    <div class="d-flex flex-column pl-2">
                        <span class="doc-name text-dark">GAAP Insurance
                        </span>
                        <span class="small pt-1 doc-date" style="color:#909090"></span>
                    </div>
                </div>



                <div class="col-6 d-flex justify-content-end align-items-center">


                    <a class="paperwork-item upload btn btn-white text-primary" href="javascript:void(0)"><i
                            class="fa-solid fa-upload"></i> Upload</a>


                </div>

            </div>
            <div class="paperwork-document col-12 row-2 d-flex" data-upload-name="Life Insurance" data-document-id="6">
                <div class="d-flex col-6"><img style=" max-width:35px; max-height:35px;"
                        src="${home_url}/wp-content/uploads/2024/09/pdf-icon.svg" alt="PDF FILE" />
                    <div class="d-flex flex-column pl-2">
                        <span class="doc-name text-dark">Life Insurance
                        </span>
                        <span class="small pt-1 doc-date" style="color:#909090"></span>
                    </div>
                </div>



                <div class="col-6 d-flex justify-content-end align-items-center">


                    <a class="paperwork-item upload btn btn-white text-primary" href="javascript:void(0)"><i
                            class="fa-solid fa-upload"></i> Upload</a>


                </div>

            </div>





        </div>


                        <div class="form-group col-12 col-md-12 d-flex justify-content-center align-items-center">
                                <button  type="submit" class="escrowStatusChangeBtn btn btn-secondary rounded-pill px-3">Submit</button>
                            </div>
    </div>

    
    `;

	jQuery(".documentManagementBody .documentViewSection").html(approvalFields);
}





jQuery(document).on('click', '.submitApprovalTerms', function() {
	jQuery('#loadingSpinner').show();


	var entry = JSON.parse(sessionStorage.getItem('@deal-new-status'));



	var approvalFields = jQuery(this).closest('.client-deal-approval-details');

	var approvedAmount = approvalFields.find('#approvedAmount').val();
	var lender = approvalFields.find('#lender').val();
	var lenderType = approvalFields.find('#lenderType').val();
	var approvalNoteTextarea = approvalFields.find('#approvalNoteTextarea').val();
	var taskStatus = approvalFields.find('.note-task-check input[type="radio"]:checked').val();

	var paymentAmountTerm = approvalFields.find('.term-1 #paymentAmount').val();
	var biWeeklyPaymentTerm = approvalFields.find('.term-1 #biWeeklyPayment').val();
	var approvalTermTerm = approvalFields.find('.term-1 #approvalTerm').val();
	var interestRateTerm = approvalFields.find('.term-1 #interestRate').val();

	var paymentAmountTermTwo = approvalFields.find('.term-2 #paymentAmount').val();
	var biWeeklyPaymentTermTwo = approvalFields.find('.term-2 #biWeeklyPayment').val();
	var approvalTermTermTwo = approvalFields.find('.term-2 #approvalTerm').val();
	var interestRateTermTwo = approvalFields.find('.term-2 #interestRate').val();

	var warrantyCost = approvalFields.find('#warrantyCost').val();
	var gaapInsurance = approvalFields.find('#gaapInsurance').val();
	var lifeInsurance = approvalFields.find('#lifeInsurance').val();
	var turboBidTransport = approvalFields.find('#turboBidTransport').val();


	var formData = new FormData();
	formData.append('action', 'add_additional_deal_info');
	formData.append('form_id', <?php echo $credit_form_id; ?>); // Replace with your form ID
	formData.append('entry_id', entry['entry_id']); // Replace with your entry ID
	formData.append("data_meta", "applicant_information");
	formData.append('form_name', 'Approval Terms');
	formData.append('form_title', 'Approval Terms Updated');
	formData.append('userId', <?php echo $userdata->ID; ?>);
	formData.append('buyer_current_step', 2);
	formData.append('seller_current_step', 3);



	approvedAmount && formData.append('approvedAmount', approvedAmount);
	lender && formData.append('lender', lender);
	lenderType && formData.append('lenderType', lender);
	approvalNoteTextarea && formData.append('approvalNoteTextarea', approvalNoteTextarea);
	paymentAmountTerm && formData.append('paymentAmountTerm', paymentAmountTerm);
	biWeeklyPaymentTerm && formData.append('biWeeklyPaymentTerm', biWeeklyPaymentTerm);
	approvalTermTerm && formData.append('approvalTermTerm', approvalTermTerm);
	interestRateTerm && formData.append('interestRateTerm', interestRateTerm);

	paymentAmountTermTwo && formData.append('paymentAmountTermTwo', paymentAmountTermTwo);
	biWeeklyPaymentTermTwo && formData.append('biWeeklyPaymentTermTwo', biWeeklyPaymentTermTwo);
	approvalTermTermTwo && formData.append('approvalTermTermTwo', approvalTermTermTwo);
	interestRateTermTwo && formData.append('interestRateTermTwo', interestRateTermTwo);

	warrantyCost && formData.append('warrantyCost', warrantyCost);
	gaapInsurance && formData.append('gaapInsurance', gaapInsurance);
	lifeInsurance && formData.append('lifeInsurance', lifeInsurance);
	turboBidTransport && formData.append('turboBidTransport', turboBidTransport);
	taskStatus && formData.append('taskStatus', taskStatus);

	addAdditionalDealData(formData)
		.done(function(res) {
			jQuery('#loadingSpinner').hide();
			// Handle the response from the AJAX call
			if (res.success) {
				financeProgressVerification(entry['entry_id'], entry['step_no'], entry['status'],
					entry[
						'status']);
			} else {
				console.log(res.message);
			}
		})
		.fail(function(error) {
			console.error("Error:", error);
		});


});

function deleteEntryTableFromServer(entryId) {

	jQuery('#loadingSpinner').show();
	var formData = new FormData();
	formData.append('action', 'delete_turbo_entry_from_server');
	formData.append('form_id', <?php echo $credit_form_id; ?>);
	formData.append('entry_id', entryId);
	addAdditionalDealData(formData)
		.done(function(res) {
			jQuery('#loadingSpinner').hide();
			// Handle the response from the AJAX call
			if (res.success) {
				// alert('Deal deleted successfully');
				showGlobalAlert('success', `<h3>Escrow deleted successfully</h3>`);
				mainDealsImportFromServer();
			} else {
				// alert('Error wehile delete')
				showGlobalAlert('error', `<h3>Error wehile delete</h3>`);
			}
		})
		.fail(function(error) {
			console.error("Error:", error);
		});
}



jQuery('#vehiclePurchasAgreementBtn').on('click', function() {
	var rows = jQuery('.vehiclePurchasAgreement');
	if (rows.css('display') == 'none') {
		rows.show();
	} else {
		rows.hide();
	}
});


jQuery(document).on('click', '#fundDealBtn', function() {

	jQuery('.documentManagementBody #documentManageTitle').hide();
	jQuery('.documentManagementBody .documentManagementContainer').removeClass('p-3 customModalWidthHalf')
		.addClass(
			'p-0 border-0 customModalWidthFull');

	jQuery('.documentManagementBody .sendDocumentSection').removeClass('d-block').addClass('d-none');
	jQuery('.documentManagementBody .documentViewSection').removeClass('d-none').addClass('bg-transparent d-block');

	var approvalFields = `
    <div class="bg-secondary px-1 px-md-4 py-4 text-center text-white"><h5>Fund Deal</h5></div>

    <div class="px-1 px-md-3 py-3 bg-white">
    <div class="text-center px-5 mx-3 font-14">
    <p>Please enter details to fund this deal , Once you click<br>submit, this deal will be moved to the compleated deals section.</p>
    </div>
    <div class="fund-deal-form">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="firstName" class="info-label">First Name</label>
                                <input type="text" id="firstName" class="form-control firstName-name"
                                    value="">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="middleName" class="info-label">Middle Name</label>
                                <input type="text" id="middleName" class="form-control middleName-name" value="">
                            </div>


                            <div class="form-group col-md-3">
                                <label for="lastName" class="info-label">Last Name</label>
                                <input type="text" id="lastName" class="form-control" value="">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fundingDate" class="info-label">Funding Date</label>
                                <input type="date" id="fundingDate" class="form-control" value="">
                            </div>

                        </div>

                       

                        <div class="form-row">
                            <div class="form-group col-12 col-md-3  col-md-2">
                                <label for="Payment Amount" class="info-label">Payment Amount</label>
                                <input type="text" id="Payment Amount" class="form-control warrantyCost" value="">
                            </div>

                            <div class="form-group col-12 col-md-3  col-md-2">
                                <label for="Payment Method" class="info-label">Payment Method</label>
                                <input type="text" id="Payment Method" class="form-control" value="">
                            </div>

                            <div class="form-group col-12 col-md-3  col-md-2">
                                <label for="Transaction Number" class="info-label">Transaction Number</label>
                                <input type="text" id="Transaction Number" class="form-control" value="">
                            </div>

                             <div class="form-group col-12 col-md-3  col-md-2">
                                <label for="Notes" class="info-label">Notes</label>
                                <input type="text" id="Notes" class="form-control" value="">
                            </div>


                        </div>


                            <div class="form-group col-12 col-md-12 d-flex justify-content-center align-items-center">
                                <button  type="submit" id="submitFundDeal" class="submitFundDeal btn btn-secondary rounded-pill px-3">Submit</button>
                            </div>
        </div>
        </div>
    
    `;

	jQuery(".documentManagementBody .documentViewSection").html(approvalFields);
	jQuery('.documentManagementBody').removeClass('d-none').addClass('d-flex');
});


jQuery(document).on('click', '#submitFundDeal', function() {
	jQuery('#loadingSpinner').show();

	// Get the entryId from session storage
	var entryId = sessionStorage.getItem('@deal-entry-id');

	// Prepare FormData object
	var formData = new FormData();
	formData.append('action', 'add_additional_deal_info');
	formData.append('form_id', <?php echo $credit_form_id; ?>);
	formData.append('entry_id', entryId);
	formData.append("data_meta", "applicant_information");
	formData.append('form_name', 'Fund Deal');
	formData.append('form_title', 'Fund Deal');
	formData.append('userId', <?php echo $userdata->ID; ?>);

	// Collect input values
	var section = jQuery('.fund-deal-form');
	formData.append('fundFirstName', section.find('#firstName').val());
	formData.append('fundMiddleName', section.find('#middleName').val());
	formData.append('fundLastName', section.find('#lastName').val());
	formData.append('fundingDate', section.find('#fundingDate').val());
	formData.append('paymentAmount', section.find('#Payment\\ Amount').val());
	formData.append('paymentMethod', section.find('#Payment\\ Method').val());
	formData.append('transactionNumber', section.find('#Transaction\\ Number').val());
	formData.append('fundNotes', section.find('#Notes').val());

	// Collect values from the sellerInformationPayout section
	var sellerSection = jQuery('.sellerInformationPayout');
	formData.append('nameOfRegisteredOwner', sellerSection.find('#nameOfRegisteredOwner').val());
	formData.append('sellerRegisteredOwner', sellerSection.find('#sellerRegisteredOwner').val());
	formData.append('lienInformation', sellerSection.find('#lienInformation').val());
	formData.append('confirmedVehiclePriceVIN', sellerSection.find('#confirmedVehiclePriceVIN').val());
	formData.append('institutionName', sellerSection.find('#institutionName').val());
	formData.append('institutionAddress', sellerSection.find('#institutionAddress').val());
	formData.append('institutionNumber', sellerSection.find('#institutionNumber').val());
	formData.append('transitNumber', sellerSection.find('#transitNumber').val());
	formData.append('accountName', sellerSection.find('#accountName').val());
	formData.append('accountNumber', sellerSection.find('#accountNumber').val());
	formData.append('selectedPayoutMethod', sellerSection.find('#selectedPayoutMethod').val());
	formData.append('payoutAmount', sellerSection.find('#payoutAmount').val());

	// Collect values from the DeliveryDetails section
	var deliverySection = jQuery('.DeliveryDetails');
	formData.append('transportCompany', deliverySection.find('#transportCompany').val());
	formData.append('phoneNumber', deliverySection.find('#phoneNumber').val());
	formData.append('driver', deliverySection.find('#driver').val());
	formData.append('trackingNumber', deliverySection.find('#trackingNumber').val());
	formData.append('isVehiclePicked', deliverySection.find('#isVehiclePicked').val());
	formData.append('sellerPickupAddress', deliverySection.find('#SellerPickupAddress').val());
	formData.append('sellerPickupDate', deliverySection.find('#sellerPickupDate').val());
	formData.append('sellerPickupTime', deliverySection.find('#sellerPickupTime').val());

	// Send AJAX request to save the data
	addAdditionalDealData(formData)
		.done(function(res) {
			jQuery('#loadingSpinner').hide();

			// Handle the response from the AJAX call
			if (res.success) {

				// alert('Submited the fund deal.');
				showGlobalAlert('', `<h3>Submited the fund deal.</h3>`);
				// var meta = res.data;

				financeProgressVerification(entryId, '', 'Booked', 'Booked');


			} else {
				showGlobalAlert('erreo','Error: Could not submit the fund deal.');

			}
		})
		.fail(function(error) {
			jQuery('#loadingSpinner').hide();
			console.error("Error:", error);
		});
});



jQuery(".vehicle-info-update-btn").on('click', function() {
	jQuery('#loadingSpinner').show();
	var entryId = sessionStorage.getItem('@deal-entry-id');

	const topSection = jQuery('.custom-card.vehicle-vin-section');

	var topSectionVin = topSection.find('#vin-input').val();
	var topSectionMileage = topSection.find('#mileage-input').val();
	var topSectionPurchasePrice = topSection.find('#purchase-price').val();
	var topSectionYear = topSection.find('#year').val();
	var topSectionMakeInput = topSection.find('#make-input').val();
	var topSectionModelInput = topSection.find('#model-input').val();
	var topSectionColorInput = topSection.find('#color-input').val();
	var applicantProvince = topSection.find('#applicantProvince').val();


	var formData = new FormData();
	formData.append('action', 'add_additional_deal_info');
	formData.append('form_id', <?php echo $credit_form_id; ?>); // Replace with your form ID
	formData.append('entry_id', entryId); // Replace with your entry ID
	formData.append("data_meta", "applicant_information");
	formData.append('form_name', 'Vehicle Information');
	formData.append('form_title', 'Vehicle Information Updated');
	formData.append('userId', <?php echo $userdata->ID; ?>);

	topSectionVin && formData.append('text-11', topSectionVin);
	topSectionMileage && formData.append('text-4', topSectionMileage);
	topSectionPurchasePrice && formData.append('currency-1', topSectionPurchasePrice);
	topSectionYear && formData.append('select-2', topSectionYear);
	topSectionMakeInput && formData.append('select-1', topSectionMakeInput);
	topSectionModelInput && formData.append('text-3', topSectionModelInput);

	topSectionColorInput && formData.append('text-16', topSectionColorInput);
	applicantProvince && formData.append('select-18',
		applicantProvince);






	addAdditionalDealData(formData)
		.done(function(res) {
			jQuery('#loadingSpinner').hide();
			// Handle the response from the AJAX call
			if (res.success) {
				showGlobalAlert('','Successfully Updated Information');
			} else {
				showGlobalAlert('error','Error wehile updated');
			}
		})
		.fail(function(error) {
			showGlobalAlert('error','Error updated information')
			console.error("Error:", error);
		});



});

// jQuery('.user-info-container').on('change', '.user-details-column #firstName', function() {
//     var firstName = jQuery(this).val();
//     console.log(firstName);
// });

// Use 'click' event instead of 'change'
// jQuery('.applicant-actions .update-btn').on('click', function() {
//     var firstName = jQuery('.user-details-column #firstName').val();
//     console.log(firstName);
// });






console.log(jQuery('#documentProofFileInput').length); // Should log a number > 0 if element exists


function updateDealInformation() {
	jQuery('#loadingSpinner').show();
	var entryId = sessionStorage.getItem('@deal-entry-id');
	var meta = JSON.parse(sessionStorage.getItem('@deal-data' + entryId));
	// var documentProofFileInput = jQuery('#documentProofFileInput')[0];
	// var documentProofFile = documentProofFileInput.files[0];

	var sellerFirstName = jQuery('.sellerDetails #firstName').val();
	var sellerLastName = jQuery('.sellerDetails #lastName').val();


	var buyerFirstName = jQuery('.buyerDetails #firstName').val();
	var buyerLastName = jQuery('.buyerDetails #lastName').val();










	var additionalpickupAddress = jQuery('.additional-seller-info #pickupAddress').val();
	var additionaldropOffAddress = jQuery('.additional-seller-info #dropOffAddress').val();




	console.log(meta['select-19']);


	var formData = new FormData();
	formData.append('action', 'add_additional_deal_info');
	formData.append('form_id', <?php echo $credit_form_id; ?>); // Replace with your form ID
	formData.append('entry_id', entryId); // Replace with your entry ID
	formData.append("data_meta", "applicant_information");
	formData.append('form_name', 'Deal Applicant Information');
	formData.append('form_title', 'Deal Applicant Information Updated');
	formData.append('userId', <?php echo $userdata->ID; ?>);

	if (meta['select-19'] === 'Buyer') {
		buyerFirstName && formData.append('name-6', buyerFirstName);
		buyerLastName && formData.append('name-7', buyerLastName);
	} else {
		sellerFirstName && formData.append('name-9', sellerFirstName);
		sellerLastName && formData.append('name-10', sellerLastName);
	}

	if (meta['select-19'] === 'Seller') {
		buyerFirstName && formData.append('name-6', buyerFirstName);
		buyerLastName && formData.append('name-7', buyerLastName);

	} else {
		sellerFirstName && formData.append('name-9', sellerFirstName);
		sellerLastName && formData.append('name-10', sellerLastName);

	}









	// additionalyear3 && formData.append('additionalyear3', additionalyear3);



	// additionalpickupAddress && formData.append('text-36', additionalpickupAddress);
	// additionaldropOffAddress && formData.append('text-37', additionaldropOffAddress);

	// additionalTransportDeliveryAmount && formData.append('text-38', additionalTransportDeliveryAmount);


	// financeAddOnGaapInc && formData.append('radio-2', financeAddOnGaapInc);
	// financeAddOnLifeInc && formData.append('radio-3', financeAddOnLifeInc);
	// financeAddOnVehicleWarranty && formData.append('radio-4', financeAddOnVehicleWarranty);
	// financeAddOnIncludeTurboBIdDelivery && formData.append('radio-5',
	//     financeAddOnIncludeTurboBIdDelivery);
	// financeAddOnInspectionRequested && formData.append('radio-6',
	//     financeAddOnInspectionRequested);






	// Get the first file (single file)
	// if (documentProofFile) {
	//     formData.append('documentProofFile', documentProofFile, documentProofFile.name); // Append the file if it exists
	// }


	// for (var pair of formData.entries()) {
	//     console.log(pair[0] + ': ' + pair[1]);
	// }

	addAdditionalDealData(formData)
		.done(function(res) {
			jQuery('#loadingSpinner').hide();
			// Handle the response from the AJAX call
			if (res.success) {
				showGlobalAlert('','Successfully Updated Deal Information')



			} else {
				showGlobalAlert('error','Error updated deal information')
			}
		})
		.fail(function(error) {
			showGlobalAlert('error','Error updated seal information')
			console.error("Error:", error);
		});

}




function addAdditionalDealData(formData) {
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
jQuery('#addClientNote').on('click', function(e) {
	e.preventDefault();

	// Retrieve TinyMCE content for wp_editor
	var note = jQuery('#addClientNoteTextarea').val();

	if (!note) {
		showGlobalAlert('error', 'Please enter a note');
		return;
	}


	jQuery('#loadingSpinner').show();

	// Simulate fetching additional data
	var entryId = sessionStorage.getItem('@deal-entry-id');
	var firstName = jQuery('.user-details-column #firstName').val();
	var lastName = jQuery('.user-details-column #lastName').val();

	// Prepare form data
	var formData = new FormData();
	formData.append("action", "submit_notes_for_deal");
	formData.append("form_id", 330325); // Replace with your form ID
	formData.append("entry_id", entryId);
	formData.append("data_meta", "deal_client_notes");
	formData.append('form_name', 'Deal Client Note Added');
	formData.append('form_title', 'Deal client note submitted');
	formData.append('note', note); // Add note content
	formData.append('senderName', firstName + ' ' + lastName);
	formData.append('userPhoto', '<?php echo $CORE->USER('get_avatar', $userdata->ID); ?>');

	addAdditionalDealData(formData)
		.done(function(res) {
			jQuery('#loadingSpinner').hide();
			if (res.success) {
				showGlobalAlert('','Successfully added note');
				getDealBasedNotes(); // Refresh notes
			} else {
				showGlobalAlert('error','Error adding note');
				console.log(res);
			}
		})
		.fail(function(error) {
			jQuery('#loadingSpinner').hide();
			showGlobalAlert('error','Error adding note');
			console.error("Error:", error);
		});
});

jQuery('#addNewNoteForDeal').on('click', function(e) {
	e.preventDefault();

	// Retrieve TinyMCE content for wp_editor
	var note = tinymce.get('editor_post_content').getContent();
	var taskStatus = jQuery('.note-task-check input[type="radio"]:checked').val();

	if (!note) {
		showGlobalAlert('error','Please enter a note');
		return;
	}

	if (!taskStatus) {
		showGlobalAlert('error','Please select a task status');
		return;
	}

	jQuery('#loadingSpinner').show();

	// Simulate fetching additional data
	var entryId = sessionStorage.getItem('@deal-entry-id');
	var firstName = jQuery('.user-details-column #firstName').val();
	var lastName = jQuery('.user-details-column #lastName').val();

	// Prepare form data
	var formData = new FormData();
	formData.append("action", "submit_notes_for_deal");
	formData.append("form_id", 330325); // Replace with your form ID
	formData.append("entry_id", entryId);
	formData.append("data_meta", "deal_note_documents");
	formData.append('form_name', 'Deal Note Added');
	formData.append('form_title', 'Deal note submitted');
	formData.append('note', note); // Add note content
	formData.append('taskStatus', taskStatus);
	formData.append('senderName', firstName + ' ' + lastName);
	formData.append('userPhoto', '<?php echo $CORE->USER('get_avatar', $userdata->ID); ?>');

	addAdditionalDealData(formData)
		.done(function(res) {
			jQuery('#loadingSpinner').hide();
			if (res.success) {
				showGlobalAlert('','Successfully added notes');
				getDealBasedNotes(); // Refresh notes
			} else {
				showGlobalAlert('error','Error adding notes');
				console.log(res);
			}
		})
		.fail(function(error) {
			jQuery('#loadingSpinner').hide();
			showGlobalAlert('error','Error adding note');
			console.error("Error:", error);
		});
});


function getDealBasedNotes() {

	jQuery('#loadingSpinner').show();
	var entryId = sessionStorage.getItem('@deal-entry-id');

	var formData = new FormData();
	formData.append("action", "get_deal_notes");
	formData.append("form_id",
		330325); // Replace with your form ID
	formData.append("entry_id", entryId);

	addAdditionalDealData(formData)
		.done(function(res) {
			jQuery('#loadingSpinner').hide();
			// Handle the response from the AJAX call
			if (res.success) {

				showNotesInContainer(res.data)
			} else {
				//alert('Error added notes')
				jQuery('#notesContainer').html("");
				console.log(res);
			}
		})
		.fail(function(error) {
			// alert('Error added note', error)
			jQuery('#notesContainer').html("");
			console.error("Error:", error);
		});
}


function showNoteByTask(type) {




	jQuery('#notesContainer .accordion-item').hide();
	jQuery('.note-task-High').hide();
	jQuery('.note-task-Medium').hide();
	jQuery('.note-task-Low').hide();

	jQuery('.note-task-' + type).show();

	if (type == "all") {

		jQuery('.note-task-High').show();
		jQuery('.note-task-Medium').show();
		jQuery('.note-task-Low').show();
	}

}


jQuery('.carfax-doc-view').on('click', function(){
	const data = sessionStorage.getItem('escrow_carfax_lien_result');
	let resultHtml = `
        <div class="col-12 row text-dark font-12">
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
        </div>`;
		if(data.VhrReportUrl){
			resultHtml += `
        <a href="${data.VhrReportUrl}" target="_blank" class="btn btn-primary px-4 rounded-pill mb-2">View Full Report</a>
    `;
		}



	showGlobalAlert('', resultHtml)
})

function showNotesInContainer(notes) {
	let noteContent = '';

	if (notes.length > 0) {

		notes.forEach(function(note) {
			noteContent +=
				'<div class="note-task-' + note.task_status + ' mb-4 p-2 accordion-item note-' +
				note.note_id +
				'" style="background:#F5F7FA; border-radius:11px">';

			// Header with date and options dropdown
			noteContent +=
				'<div class="col-md-6 d-flex align-items-center justify-content-end float-right" style="gap:10px">';
			noteContent +=
				'<i class="fal fa-calendar-alt"></i>';
			noteContent += '<span class="font-12">' + formatJustDate(note.note_submit_date) + '</span>';

			// Dropdown menu
			noteContent += '<div class="dropdown">';
			noteContent +=
				'<button class="dropdown-toggle btn border-left" data-toggle="dropdown" aria-expanded="false">';
			noteContent +=
				'<i class="fal fa-ellipsis-h-alt"></i></button>';

			noteContent +=
				'<div class="dropdown-menu" style="transform: translate3d(-137px, 30px, 0px);">';
			noteContent += '<a class="dropdown-item note-low-' +
				note.note_id +
				' text-success" href="javascript:void(0)"><i class="fal fa-flag"></i> Make Low</a>';
			noteContent +=
				'<a class="dropdown-item note-medium-' +
				note.note_id +
				' text-warning" href="javascript:void(0)"><i class="fal fa-flag"></i> Make Medium</a>';
			noteContent +=
				'<a class="dropdown-item note-high-' +
				note.note_id +
				' text-danger" href="javascript:void(0)"><i class="fal fa-flag"></i> Make High</a>';
			noteContent +=
				'<a class="dropdown-item note-delete-' +
				note.note_id +
				' text-danger" href="javascript:void(0)"><i class="fal fa-trash"></i> Delete Note</a>';
			noteContent += '</div>'; // End of dropdown-menu
			noteContent += '</div>'; // End of dropdown
			noteContent += '</div>'; // End of header

			// Note details and checkbox
			noteContent +=
				'<input class="accordion__note__hidden" type="checkbox" id="note-one-' +
				note.note_id + '" checked>';
			noteContent +=
				'<label class="col-md-6 accordion__note__user__name font-12" for="note-one-' +
				note.note_id +
				'" style="cursor:pointer;margin-top: 8px;">';
			noteContent += '' + note.task_status +
				': lender is requesting paystub to close deal</label>';
			noteContent += '<hr/>';

			// Summary and content of the note
			noteContent +=
				'<div class="accordion__note__details position-relative" id="collapseNote1">';
			noteContent += '<span class="text-dark font-weight-bold font-12">Summary Note - ' +
				formatJustDate(note.note_submit_date) +
				'</span>';
			noteContent += '<p class="mt-3">' + note.note + '</p>';
			noteContent += '</div>'; // End of note details
			noteContent += '</div>'; // End of accordion item
		});
	} else {
		noteContent +=
			'<div class="m-3 d-flex"><button id="addNewNoteForDeal" class="btn btn-primary rounded-pill px-3 position-absolute" style="right:0px; bottom:10px;"> Add new note < /button></div >';
	}

	jQuery('#notesContainer').html(noteContent);





	// Sort notes by task_status ("High", "Medium", others)
	notes.sort(function(a, b) {
		const priority = {
			"High": 1,
			"Medium": 2,
			"Low": 3
		}; // Define priority ranking
		return (priority[a.task_status] || 4) - (priority[b.task_status] || 4);
	});

	let statusPriorityBasedNotes = '';

	notes.forEach(function(note) {
		// Get the avatar URL for the note submitter
		const home_url = '<?php echo home_url(); ?>';
		statusPriorityBasedNotes += `
        <div class="radiusx my-2 p-2 bg-light">
            <div class="d-flex justify-content-between align-items-center my-2">
                <div class="p-0 d-flex justify-content-start align-items-center" style="gap:5px;">
    `;

		// Display task status with corresponding icon
		if (note.task_status === 'High') {
			statusPriorityBasedNotes += '<i class="fal fa-flag-alt text-danger"></i> <span>' + note
				.task_status + '</span>';
		} else if (note.task_status === 'Medium') {
			statusPriorityBasedNotes += '<i class="fal fa-flag-alt text-warning"></i> <span>' + note
				.task_status + '</span>';
		} else {
			statusPriorityBasedNotes += '<i class="fal fa-flag-alt text-success"></i> <span>' + note
				.task_status + '</span>';
		}

		statusPriorityBasedNotes += `
                </div>
                <button class="btn"> <i class="fal fa-ellipsis-h-alt"></i></button>
            </div>
            <div class="radiusx" style="color:#4B4B4B; font-size:14px">
                
                <p>${note.note || 'Lender is requesting paystub to close deal'}</p>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div class="col-6 pl-0">
                        <img src="${note.note_submitter_photo || '${home_url}/wp-content/uploads/2024/09/user-profile.png'}" style="width:30px;" alt="Submitter Avatar" />
                    </div>
                    <div class="col-6 pr-0 text-right d-flex justify-content-end align-items-center">
                        <img src="${home_url}/wp-content/uploads/2024/09/sms.svg" style="width:30px;" alt="SMS Icon" />
                        <span class="ml-2 h5">${note.sms_count || '3'}</span>
                    </div>
                </div>
            </div>
        </div>
    `;
	});

	// Append the HTML to the container
	jQuery('#statusPriorityBasedNotes').html(statusPriorityBasedNotes);



}

// if (sessionStorage.getItem('@deal-entry-id')) {
//     getDealBasedNotes();
// }
</script>

<script>
// Retrieve values from sessionStorage
var getFinanceEmail = sessionStorage.getItem('@finance-user-email');
var getFinanceId = sessionStorage.getItem('@finance-entry-id');







jQuery('.finance-back-main').click(function() {
	jQuery('.finance-entry-details').addClass('d-none');
	jQuery('.finance-back-main').addClass('d-none');
	jQuery('.admin-finance-order-data').removeClass('d-none');
});




// Usage example



function insertApplicantInfo(entry, meta) {

	var sellerInfo = `
    
                          
                                 <div class="form-row">
                                        <div class="form-group col-12 col-md-3">
                                            <label for="firstName" class="field-label">First Name</label>
                                            <input id="firstName" class="form-control" type="text" value="${meta['select-19'] === 'Seller' ?  (meta['name-6'] || '') : ( meta['name-9'] || '') }">
                                        </div>
                                       
                                        <div class="form-group col-12 col-md-3">
                                            <label for="lastName" class="field-label">Last Name</label>
                                            <input id="lastName" class="form-control" type="text" value="${meta['select-19'] === 'Seller' ?  (meta['name-7'] || '') : ( meta['name-10'] || '') }">
                                        </div>

                                        <div class="form-group col-12 col-md-3">
                                            <label for="phoneNumber" class="field-label">Contact Number</label>
                                            <input id="phoneNumber" class="form-control" type="text" value="${meta['phone-1'] || ''}">
                                        </div>

                                         <div class="form-group col-12 col-md-3">
                                            <label for="emailAddress" class="field-label">Email</label>
                                            <input id="emailAddress" class="form-control" type="text" value="${meta['email-1'] || ''}">
                                        </div>
                                        
                                
                                </div>
                                
                                              
    
    `;

	jQuery(".sellerDetails").html(sellerInfo);

	jQuery(".applicantRole").val(meta['select-19'] || '');
	var vehicle_title = `${meta['select-2'] || ''} ${meta['text-1'] || ''} ${meta['text-3'] || ''}`;
	jQuery(".vehicle-name").val(vehicle_title);
	jQuery(".vehicle-vin").val(meta['text-11'] || '');




	var buyerInfo = `
    
                          
                                 <div class="form-row">
                                        <div class="form-group col-12 col-md-3">
                                            <label for="firstName" class="field-label">First Name</label>
                                            <input id="firstName" class="form-control" type="text" value="${meta['select-19'] === 'Buyer' ?   (meta['name-6'] || '') : ( meta['name-9'] || '') }">
                                        </div>
                                       
                                        <div class="form-group col-12 col-md-3">
                                            <label for="lastName" class="field-label">Last Name</label>
                                            <input id="lastName" class="form-control" type="text" value="${meta['select-19'] === 'Buyer' ?  (meta['name-7'] || '') : ( meta['name-10'] || '') }">
                                        </div>

                                        <div class="form-group col-12 col-md-3">
                                            <label for="phoneNumber" class="field-label">Contact Number</label>
                                            <input id="phoneNumber" class="form-control" type="text" value="${meta['phone-2'] || ''}">
                                        </div>

                                         <div class="form-group col-12 col-md-3">
                                            <label for="emailAddress" class="field-label">Email</label>
                                            <input id="emailAddress" class="form-control" type="text" value="${meta['email-2'] || ''}">
                                        </div>
                                        
                                
                                </div>
                                
                                              
    
    `;

	jQuery(".buyerDetails").html(buyerInfo);




	var transactionDetails = `
    

        <div class="form-row">
             <div class="form-group col-12 col-md-3  ">
                                            <label for="escrowAmount" class="field-label font-weight-bold">Escrow Amount</label>
                                            <input id="escrowAmount" class="form-control" type="text" value="${formatCalCadPrice(meta['currency-1'] || 0) }">
               </div>

                 <div class="form-group col-12 col-md-3  ">
                                            <label for="turbobidTransit" class="field-label font-weight-bold">Trbo Swift Transit Requested</label>
                                            <input id="turbobidTransit" class="form-control" type="text" value="${formatDateToISO(meta['date-1'] || '' )}">
               </div>

               
                <div class="form-group col-12 col-md-3">
                                            <label for="disclosureOfSale" class="field-label">Disclosure of sale</label>
                                             <select type="text" id="disclosureOfSale" class="form-control rounded-pill">

                                         <option>Vehicle is being sold AS-IS.</option>
                                        <option>Vehicle is being sold with safety certificate.</option>

                                    </select>
                  </div>

                <div class="form-group col-12 col-md-3">
                                            <label for="mechanicalRequested" class="field-label">Mechanical Requested </label>
                                             <select type="text" id="mechanicalRequested" class="form-control rounded-pill">

                                         <option>Yes</option>
                                        <option>No</option>

                                    </select>
                  </div>


        </div>

           <div class="form-row">
              <div class="form-group col-12 col-md-3">
                                            <label for="pickUpAddress" class="field-label">Pick-Up</label>
                                            <input id="pickUpAddress" class="text-22 form-control googleAutoLocation" type="text" value="${meta['text-14'] || '' }">
                                        </div>

                  <div class="form-group col-12 col-md-3">
                                            <label for="dropOffAddress" class="field-label">Drop-Off</label>
                                            <input id="dropOffAddress" class="text-22 form-control googleAutoLocation" type="text" value="${meta['text-15'] || '' }">
                                        </div>
                
                    <div class="form-group col-12 col-md-3">
                                            <label for="turboFee" class="field-label">Fee</label>
                                            <input id="turboFee" class="text-22 form-control" type="text" value="${formatCalCadPrice(meta['number-8'] || 0 )}">
                                        </div>
                    <div class="form-group col-12 col-md-3">
                                            <label for="transactionStartedBy" class="field-label">Transaction Started By</label>
                                            <input id="transactionStartedBy" class="text-22 form-control" type="text" value="${meta['name-6'] || ''} ${meta['name-8'] || ''} ${meta['name-7'] || ''}">
                                        </div>



        </div>


      

<div class="row my-3 mx-0 text-dark">
    <div class="col-12 col-md-6">
    <div class="bg-light radiusx p-2">
        <span class="my-2 h4 font-weight-bold">For Buyers</span>
        <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Buyer Price:</span><span>${formatCalCadPrice(meta["currency-1"] || 0)}</span></div>
        <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Trbo Swift fee paid by:<span class="text-primary">${meta["select-16"] || ''}</span></span>
            <div class="buyer-escrow-fee"> <span class="buyer-fee-cal">${formatCalCadPrice(meta["number-7"] || 0)}</span></div>
        </div>
        <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Shipping fee paid by:<span class="text-primary">Buyer</span></span>
            <div <span class="cad-price-format">${formatCalCadPrice(meta["number-5"] || 0)}</span></div>
        </div>
        <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Total to be paid by Buyer:</span><span class="cad-price-format">${formatCalCadPrice(meta["number-3"] || 0)}</span></div>
    </div>
    </div>
    <div class="col-12 col-md-6">
    <div class="bg-light radiusx p-2">
        <span class="my-2 h4 font-weight-bold">For Sellers</span>
        <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Shipping fee paid by:<span class="text-primary">Seller</span></span> <span class="cad-price-format">${formatCalCadPrice(meta["number-4"] || 0)}</span>
        </div>
        <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Trbo Swift fee paid by:<span class="text-primary">${meta["select-17"] || ''}</span></span>
            <div class="seller-escrow-fee"> <span class="seller-fee-cal">${formatCalCadPrice(meta["number-6"] || 0)}</span></div>
        </div>
        <div class="d-flex justify-content-between font-14 my-1"><span  class="font-weight-bold">Lien Holder Pay Off Fee</span><span class="cad-price-format">${formatCalCadPrice(extractNumericValue(meta["checkbox-9"] || 0))}</span></div>
        
        
        <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Seller Proceeds:</span> <span class="cad-price-format">${formatCalCadPrice(meta["number-2"] || 0)}</span></div>
    </div>
    </div>
</div>




    
    `;



	jQuery(".transactionDetails").html(transactionDetails);

	jQuery(".transactionDetails #disclosureOfSale").val(meta['select-11'] || '');

	jQuery(".transactionDetails #mechanicalRequested").val(meta['radio-2'] || '');




	var bankDetails = entry.seller_escrow_bank_dp;

	// console.log(bankDetails);

	var sellerBuyerCalculations = `<div class="row my-3 mx-0 text-dark">
    <div class="col-12 col-md-3">
    <div class="radiusx p-2" style="height: 100%; background:#eee;">
        <span class="my-2 h6 font-weight-bold">For Buyers</span>
          <button data-edit-btn data-field-prefix="buyerPayment" id="edit-buyer-payment-method"
                                                    class="btn btn-outline-secondary rounded-pill px-4 py-1 ml-2 float-right"
                                                    style="font-size:10px;">Edit</button>
        <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Buyer Price</span><span>${formatCalCadPrice(meta["currency-1"] || 0)}</span></div>
        <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Trbo Swift fee paid by <span class="text-primary">${meta["select-16"] || ''}</span></span>
            <div class="buyer-escrow-fee"> <span class="buyer-fee-cal">${formatCalCadPrice(meta["number-7"] || 0)}</span></div>
        </div>
        <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Shipping fee paid by <span class="text-primary">Buyer</span></span>
            <div <span class="cad-price-format">${formatCalCadPrice(meta["number-5"] || 0)}</span></div>
        </div>
        <div class="row mb-2">
                                                    <div class="col font-14 font-weight-bold">Payment Method</div>
                                                    <div class="col font-14 text-right">
                                                        <span id="buyerPayment-payment-method-text" class="editable-field"></span>
                                                        <input data-field="buyerPayment" data-type="payment-method" type="text" id="buyer-payment-method-input"
                                                            class="form-control rounded-pill d-none" style="max-height: 25px;" value="Wire">
                                                    </div>
                                                </div>
        <div class="row mb-2">
                                                    <div class="col font-14 font-weight-bold">Payment Date</div>
                                                    <div class="col font-14 text-right">
                                                        <span  id="buyerPayment-pay-date-text" class="editable-field">12 July
                                                            2024</span>
                                                        <input data-field="buyerPayment" data-type="pay-date" type="date" id="buyer-pay-date-input"
                                                            class="form-control rounded-pill d-none" style="max-height: 25px;" value="2024-07-12">
                                                    </div>
                                                </div>
        <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Total to be paid by Buyer</span><span class="cad-price-format">${formatCalCadPrice(meta["number-3"] || 0)}</span></div>
    </div>
    </div>
    
    <div class="col-12 col-md-3">
    <div class="radiusx p-2" style="height: 100%; background:#eee;">
        <span class="my-2 h6 font-weight-bold">For Sellers</span>
        <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Shipping fee paid by <span class="text-primary">Seller</span></span> <span class="cad-price-format">${formatCalCadPrice(meta["number-4"] || 0)}</span>
        </div>
        <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Trbo Swift fee paid by <span class="text-primary">${meta["select-17"] || ''}</span></span>
            <div class="seller-escrow-fee"> <span class="seller-fee-cal">${formatCalCadPrice(meta["number-6"] || 0)}</span></div>
        </div>
        <div class="d-flex justify-content-between font-14 my-1"><span  class="font-weight-bold">Lien Holder Pay Off Fee</span><span class="cad-price-format">${formatCalCadPrice(extractNumericValue(meta["checkbox-9"] || 0))}</span></div>
        
        
        <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Seller Proceeds</span> <span class="cad-price-format">${formatCalCadPrice(meta["number-2"] || 0)}</span></div>
    </div>
    </div>

     <div class="col-12 col-md-3">
    <div class="radiusx p-2" style="height: 100%; background:#eee;">
        <div class="info-section">
                                            <div class="d-flex justify-content-between align-items-center">
                                               <span class="my-2 h6 font-weight-bold">Lien Holder </span>
                                                
                                                    <button data-edit-btn data-field-prefix="lienHolder" id="edit-buyer-payment-method"
                                                    class="btn btn-outline-secondary rounded-pill px-4 py-1 ml-2"
                                                    style="font-size:10px;">Edit</button>
                                            </div>

                                            <div class="seller-delivery-info font-14">
                                                <div class="row my-1">
                                                    <div class="col font-weight-bold">Name</div>
                                                    <div class="col">
                                                        <span id="lienHolder-transport-company-text" class="editable-field"></span>
                                                        <input data-field="lienHolder" data-type="transport-company" type="text" id="lien-transport-company-input"
                                                            class="form-control rounded-pill d-none" style="max-height: 25px;" value="">
                                                    </div>
                                                </div>
                                                <div class="row my-1">
                                                    <div class="col font-weight-bold">Address</div>
                                                    <div class="col">
                                                        <span id="lienHolder-address-text"
                                                            class="editable-field"></span>
                                                        <input  data-field="lienHolder" data-type="address" type="text" id="lien-address-input"
                                                            class="form-control rounded-pill d-none googleAutoLocation" style="max-height: 25px;" value="">
                                                    </div>
                                                </div>
                                                <div class="row my-1">
                                                    <div class="col  font-weight-bold">Phone Number:</div>
                                                    <div class="col">
                                                        <span id="lienHolder-phone-number-text"
                                                            class="editable-field"></span>
                                                        <input  data-field="lienHolder" data-type="phone-number" type="text" id="phone-number-input"
                                                            class="form-control rounded-pill d-none" style="max-height: 25px;" value="">
                                                    </div>
                                                </div>
                                                <div class="row my-1">
                                                    <div class="col font-weight-bold">Date</div>
                                                    <div class="col">
                                                        <span id="lienHolder-date-text" class="editable-field"></span>
                                                        <input  data-field="lienHolder" data-type="date" type="date" id="lien-date-input"
                                                            class="form-control rounded-pill d-none" style="max-height: 25px;" value="">
                                                    </div>
                                                </div>
                                                 <div class="row my-1">
                                                    <div class="col  font-weight-bold">Account Number:</div>
                                                    <div class="col">
                                                        <span id="lienHolder-account-number-text"
                                                            class="editable-field"></span>
                                                        <input  data-field="lienHolder" data-type="account-number" type="text" id="account-number-input"
                                                            class="form-control rounded-pill d-none" style="max-height: 25px;" value="">
                                                    </div>
                                                </div>
                                                <div class="row my-1">
                                                    <div class="col font-weight-bold">Payout Date</div>
                                                    <div class="col">
                                                        <span id="lienHolder-payout-date-text" class="editable-field"></span>
                                                        <input  data-field="lienHolder" data-type="payout-date" type="date" id="lien-payout-date-input"
                                                            class="form-control rounded-pill d-none" style="max-height: 25px;" value="">
                                                    </div>
                                                </div>
                                                <div class="row my-1">
                                                    <div class="col font-weight-bold">Amount Owing</div>
                                                    <div class="col">
                                                        <span id="lienHolder-amount-owing-text" class="editable-field"></span>
                                                        <input  data-field="lienHolder" data-type="amount-owing" type="text" id="lien-payout-date-input"
                                                            class="form-control rounded-pill d-none" style="max-height: 25px;" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    </div>
    </div>

     <div class="col-12 col-md-3">
    <div class="radiusx p-2" style="height: 100%; background:#eee;">
        <span class="my-2 h6 font-weight-bold">Seller Payout</span>
        <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Name</span> <span>${bankDetails?.account_name || ''}</span>
        </div>
        <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Address</span>
            <div class="seller-escrow-fee"> <span class="seller-fee-cal overflow-auto">${bankDetails.address || ''}</span></div>
        </div>

         <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Phone</span>
            <div class="seller-escrow-fee"> <span class="seller-fee-cal">${meta["phone-1"] || ''}</span></div>
        </div>

         <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Payment Method</span>
            <div class="seller-escrow-fee"> <span class="sellerPaymentMethod overflow-auto">${entry.seller_payment_method?.Gateway || ''}</span></div>
        </div>

         <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Email</span>
            <div class="seller-escrow-fee"> <span class="sellerPaymentMethod overflow-auto">${meta["email-1"] || ''}</span></div>
        </div>

         <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Seller Steps Complete:</span>
            <div class="seller-escrow-fee"> <span class="sellerProgressStepCompleate"></span></div>
        </div>

        
        
        <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Payable</span> <span class="cad-price-format">${formatCalCadPrice(meta["number-2"] || 0)}</span></div>
    </div>
    </div>
</div>

<div class="col-12 my-3 mx-0 text-dark radiusx p-2" style="height: 100%; background:#eee;">
 <span class="my-2 h6 font-weight-bold">Buyer Transportation</span>
   <div class="d-flex flex-column flex-md-row">
     <div class="col-12 col-md-3">
         <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Is the vehcile being picked up:</span>
            <div class="seller-escrow-fee"> <span id="delivery_escrow_-isVehiclePickUp-text">${meta["text-1"] || ''}</span></div>
        </div>
         <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Buyer request Trbo Swift Transport</span>
            <div class="seller-escrow-fee"> <span>${meta["radio-1"] || ''}</span></div>
        </div>

     </div>

      <div class="col-12 col-md-3">
         <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Company Name</span>
            <div class="seller-escrow-fee"> <span id="delivery_escrow_-transportCompany-text">${meta["text-1"] || ''}</span></div>
        </div>
         <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Tracking Number</span>
            <div class="seller-escrow-fee"> <span id="delivery_escrow_-trackingNumber-text">${meta["text-1"] || ''}</span></div>
        </div>

     </div>

      <div class="col-12 col-md-3">
         <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Pick-Up Date</span>
            <div class="seller-escrow-fee"> <span id="delivery_escrow_-pickupDate-text">${meta["date-1"] || ''}</span></div>
        </div>
         <div class="d-flex justify-content-between font-14 my-1"><span class="font-weight-bold">Phone Number</span>
            <div class="seller-escrow-fee"> <span id="delivery_escrow_-phoneNumber-text">${meta["text-1"] || ''}</span></div>
        </div>

     </div>


      <div class="col-12 col-md-3">
         <div class="d-flex flex-column justify-content-between align-items-end">

         <button class="btn btn-secondary rounded-pill font-12 mb-2" style="min-width:100px;">Track Vehicle</button>
         <button id="fundDealBtn" class="btn btn-secondary rounded-pill font-12" style="min-width:100px;">Fund Deal</button>
         


        </div>
     </div>


    </div>
</div>    

`;


	jQuery('.fundingDocSellerBuyerDetails').html(sellerBuyerCalculations);





	// selectMatchingRadioButtonInGroup(meta['select-10'], '.user-info-container .residence-type-option', 'residenceType');



	// console.log(formatDateToISO(meta['date-1']));   


	// if (meta['document_proof_file']) {
	//     jQuery("#documentProofPreviewContainer img").attr("src", meta['document_proof_file']);
	// } else {
	//     jQuery("#documentProofPreviewContainer img").attr("src",
	//         "<?php echo home_url(); ?>/wp-content/uploads/2024/09/image-144.png");
	// }




	// jQuery(".user-info-card #secondaryPhone").val(meta['phone-2'] || '');
	// jQuery(".user-info-card #sin").val(meta['text-2'] || '');



	if (meta['select-19'] === 'Buyer') {
		jQuery(".buyerName").text(`${meta['name-6'] || ''} ${meta['name-7'] || ''}`);
		jQuery(".buyerMarketLink").text(meta[
			'text-13']).attr('href', meta['text-13']).show();
	} else {
		jQuery(".buyerName").text(`${meta['name-9'] || ''} ${meta['name-10'] || ''}`);
		jQuery(".buyerMarketLink").text('').attr('href', '').hide();
	}

	if (meta['select-19'] === 'Seller') {
		jQuery(".clientName").text(`${meta['name-6'] || ''} ${meta['name-7'] || ''}`);
		jQuery(".sellerMarketLink").text(meta[
			'text-13']).attr('href', meta['text-13']).show();
	} else {
		jQuery(".clientName").text(`${meta['name-9'] || ''} ${meta['name-10'] || ''}`);
		jQuery(".sellerMarketLink").text('').attr('href', '').hide();
	}


	//Note section content

	jQuery(".clientEmail").attr('href',
		`mailto:${meta['email-1'] || ''}`).text(meta['email-1'] || '');
	jQuery(".clientPhone").attr('href',
		`tel:${meta['phone-1'] || ''}`).text(meta['phone-1'] || '');





	jQuery(".buyerEmail").attr('href',
		`mailto:${meta['email-2'] || ''}`).text(meta['email-2']);
	jQuery(".buyerPhone").attr('href',
		`tel:${meta['phone-2'] || ''}`).text(meta['phone-2']);


	jQuery(".loanAmount").text(formatCalCadPrice(meta['currency-1']));





	//Vehicle details section content
	const topSection = jQuery('.custom-card.vehicle-vin-section');

	topSection.find('#vin-input').val(meta['text-11'] || '');


	topSection.find('#mileage-input').val(meta['text-4'] || '');


	topSection.find('#purchase-price').val(meta[
		'currency-1'] || '');

	topSection
		.find(
			'#year').val(meta['select-2'] || '');
	topSection.find('#make-input').val(meta[
		'select-1'] || '');

	topSection.find('#model-input').val(meta['text-3'] ||
		'');

	topSection.find('#color-input').val(meta['text-16'] || '');
	topSection.find('#applicantProvince').val(meta['select-18'] || '');
	topSection.find('#vehicleDetailsSectionNote').val(meta['vehicleDetailsSectionNote'] || '');



	// additional

	jQuery('.additional-seller-info #vin').val(meta['text-11'] || '');
	jQuery(
			'.additional-seller-info #year')
		.val(meta['select-2'] || '');
	jQuery('.additional-seller-info #make').val(meta['select-1'] ||
		'');
	jQuery(
		'.additional-seller-info #model').val(meta['text-14'] || '');

	jQuery('.additional-seller-info #sellerEmail').val(meta['email-2'] || '');
	jQuery(
		'.additional-seller-info #sellerName').val(meta['name-4'] || '');
	jQuery(
		'.additional-seller-info #sellerPhone').val(meta['phone-6'] || '');
	jQuery(
		'.additional-seller-info #buyerEmail').val(meta['email-1'] || '');

	jQuery('.additional-seller-info #sellerType').val(meta['select-7'] || '');

	//jQuery('.additional-seller-info #vin2').val();
	// jQuery('.additional-seller-info #year2').val();
	// jQuery('.additional-seller-info #make2').val();
	// vjQuery('.additional-seller-info #model2').val();

	//jQuery('.additional-seller-info #vin3').val();
	// jQuery('.additional-seller-info #year3').val();


	
	jQuery('.additional-seller-info #pickupAddress').val(meta['text-36'] || '');
	jQuery(
		'.additional-seller-info #dropOffAddress').val(meta['text-37'] || '');
		jQuery(
			'.transport-delivery-amount input').val(meta['text-38'] || '');
			
			
	// For GAAP Insurance
	setRadioValue('.additional-seller-info .gaap-insurance', meta['radio-2'] || '');
	
	// For Life Insurance
	setRadioValue('.additional-seller-info .life-insurance', meta['radio-3'] || '');
	
	// For Vehicle Warranty
	setRadioValue('.additional-seller-info .vehicle-warranty', meta['radio-4'] || '');

	// For Trbo Swift Delivery
	setRadioValue('.additional-seller-info .includeTurboBidDelivery', meta['radio-5'] || '');
	
	// For Inspection Requested
	setRadioValue('.additional-seller-info .inspectionRequested', meta['radio-6'] || '');
	
	
	jQuery('.seller-kyc-status').val(meta['seller_veriff_status'] || 'Unverified');




	var approvalFields = jQuery('.client-deal-approval-details');

	approvalFields.find('#approvedAmount').val(formatCalCadPrice(meta['buyerApprovedAmount'] ||
		0));
	approvalFields.find('#lender').val(meta['buyerApprovedLender'] || '');
	approvalFields.find(
		'#lenderType').val(meta['buyerApprovedLenderType'] || '');
	approvalFields.find(
			'#approvalNoteTextarea')
		.val(meta['approvalNoteTextarea'] || '');

	approvalFields.find('.term-1 #paymentAmount').val(meta['approvedMonthlyAmount'] || '');
	var totalMonthlyPay = extractNumericValue(meta['approvedMonthlyAmount'] || 0);
	var biWeeklyPay = totalMonthlyPay / 2;

	approvalFields.find('.term-1 #biWeeklyPayment').val(formatCalCadPrice(biWeeklyPay));

	approvalFields.find('.term-1 #approvalTerm').val(meta['approvalTermTerm'] || '');
	approvalFields.find(
		'.term-1 #interestRate').val(`${meta['interestRateTerm'] || ''}%`);

	approvalFields.find('.term-2 #paymentAmount').val(meta['paymentAmountTermTwo'] || '');
	approvalFields
		.find(
			'.term-2 #biWeeklyPayment').val(meta['biWeeklyPaymentTermTwo'] || '');
	approvalFields.find(
		'.term-2 #approvalTerm').val(meta['approvalTermTermTwo'] || '');
	approvalFields.find(
		'.term-2 #interestRate').val(meta['interestRateTermTwo'] || '');

	approvalFields.find('#warrantyCost').val(meta['buyerApprovedWarrantyCost'] || '');
	approvalFields.find(
		'#gaapInsurance').val(meta['buyerApprovedGAPInsurance'] || '');
	approvalFields.find(
			'#lifeInsurance')
		.val(meta['buyerApprovedLifeInsurance'] || '');
	approvalFields.find('#turboBidTransport').val(meta[
		'buyerApprovedTurbobidTransport'] || '');


	var approvedTerm = extractNumericValue(meta['approvalTermTerm'] || 12);

	// Extract numeric values for each field
	var approvedAmount = extractNumericValue(meta['buyerApprovedAmount'] || 0);
	var warrantyCost = extractNumericValue(meta['buyerApprovedWarrantyCost'] || 0) * approvedTerm;
	var gaapInsurance = extractNumericValue(meta['buyerApprovedGAPInsurance'] || 0) * approvedTerm;
	var lifeInsurance = extractNumericValue(meta['buyerApprovedLifeInsurance'] || 0) * approvedTerm;
	var turbobidTransport = extractNumericValue(meta['buyerApprovedTurbobidTransport'] || 0);

	// Calculate the subtotal
	var subTotal = approvedAmount + warrantyCost + gaapInsurance + lifeInsurance + turbobidTransport;

	// Generate the dealOrder HTML string
	var dealOrder = '';

	dealOrder +=
		`<h6>Deal</h6>
    <div class="d-flex justify-content-between mb-2 small"><strong>Vehicle</strong> <span>${formatCalCadPrice(approvedAmount || 0)}</span></div>`;

	if (warrantyCost) {
		dealOrder +=
			`<div class="d-flex justify-content-between mb-2 small"><strong>Warranty</strong> <span>${formatCalCadPrice(warrantyCost)}</span></div>`;
	}
	if (gaapInsurance) {
		dealOrder +=
			`<div class="d-flex justify-content-between mb-2 small"><strong>GAAP</strong> <span>${formatCalCadPrice(gaapInsurance || 0 )}</span></div>`;
	}
	if (lifeInsurance) {
		dealOrder +=
			`<div class="d-flex justify-content-between mb-2 small"><strong>Life INS</strong> <span>${formatCalCadPrice(lifeInsurance || 0)}</span></div>`;
	}
	if (turbobidTransport) {
		dealOrder +=
			`<div class="d-flex justify-content-between mb-2 small"><strong>TB Transport</strong> <span>${formatCalCadPrice(turbobidTransport || 0)}</span></div>`;
	}

	dealOrder +=
		`<div class="d-flex justify-content-between mb-2 small"><strong>Subtotal</strong> <span>${formatCalCadPrice(subTotal || 0)}</span></div>`;



	var dealDeclinedProducts = '';

	dealDeclinedProducts += `<h6>Declined Products</h6>`;

	if (!warrantyCost) {
		dealDeclinedProducts +=
			`<div class="d-flex justify-content-between mb-2 small"><strong>Warranty</strong> <span>${formatCalCadPrice(meta['warrantyCost'] || 0)} Monthly</span></div>`;
	}
	if (!gaapInsurance) {
		dealDeclinedProducts +=
			`<div class="d-flex justify-content-between mb-2 small"><strong>GAAP</strong> <span>${formatCalCadPrice(meta['gaapInsurance'] || 0)} Monthly</span></div>`;
	}
	if (!lifeInsurance) {
		dealDeclinedProducts +=
			`<div class="d-flex justify-content-between mb-2 small"><strong>Life INS</strong> <span>${formatCalCadPrice(meta['lifeInsurance'] || 0)} Monthly</span></div>`;
	}
	if (!turbobidTransport) {
		dealDeclinedProducts +=
			`<div class="d-flex justify-content-between mb-2 small"><strong>TB Transport</strong> <span>${formatCalCadPrice(meta['turboBidTransport'] || 0)} Total</span></div>`;
	}


	jQuery('.approvalDetails #dealOrder').html(dealOrder);
	jQuery('.approvalDetails #dealDeclinedProducts')
		.html(dealDeclinedProducts);



	// Collect input values
	var fundDealFormSection = jQuery('.fund-deal-form');
	// Populate the input fields with the data from the response
	fundDealFormSection.find('#firstName').val(meta['fundFirstName'] || '');
	fundDealFormSection.find(
		'#middleName').val(meta['fundLastName'] || '');
	fundDealFormSection.find('#lastName').val(meta[
		'fundMiddleName'] || '');
	fundDealFormSection.find('#fundingDate').val(meta['fundingDate'] ||
		'');
	fundDealFormSection.find('#Payment\\ Amount').val(meta['paymentAmount'] ||
		'');
	fundDealFormSection
		.find('#Payment\\ Method').val(meta['paymentMethod'] || '');
	fundDealFormSection.find(
		'#Transaction\\ Number').val(meta['transactionNumber'] || '');
	fundDealFormSection.find('#Notes')
		.val(
			meta['fundNotes'] || '');

	// Collect values from the sellerInformationPayout section
	var sellerSection = jQuery('.sellerInformationPayout');

	// Seller Information Payout Section

	sellerSection.find('#nameOfRegisteredOwner').val(meta['nameOfRegisteredOwner'] || '');

	// sellerSection.find('#sellerRegisteredOwner').val(meta['sellerRegisteredOwner'] || '');
	sellerSection.find('#sellerRegisteredOwner').val(meta['isRegisteredOwner'] || '');

	// sellerSection.find('#lienInformation').val(meta['lienInformation'] || '');
	sellerSection.find('#lienInformation').val(meta['isAnyLiensVehicle'] || '');

	if (meta['confirmVehiclePurchase'] === "Yes") {
		sellerSection.find('#confirmedVehiclePriceVIN').val(formatCalCadPrice(meta['currency-2']) + '-' +
			meta[
				'text-13'] || '');
	}

	sellerSection.find('#institutionName').val(meta['institutionName'] || '');
	sellerSection.find(
		'#institutionAddress').val(meta['institutionAddress'] || '');
	sellerSection.find(
			'#institutionNumber')
		.val(meta['institutionNumber'] || '');
	sellerSection.find('#transitNumber').val(meta['transitNumber'] ||
		'');
	sellerSection.find('#accountName').val(meta['accountName'] || '');
	sellerSection.find(
			'#accountNumber')
		.val(meta['accountNumber'] || '');
	sellerSection.find('#selectedPayoutMethod').val(meta[
		'sellerPayoutMethod'] || '');
	sellerSection.find('#payoutAmount').val(meta['payoutAmount'] || '');

	// Collect values from the DeliveryDetails section
	var deliverySection = jQuery('.DeliveryDetails');

	// // Delivery Details Section
	deliverySection.find('#transportCompany').val(meta['transportCompany'] || '');
	deliverySection.find(
		'#phoneNumber').val(meta['phoneNumber'] || '');
	deliverySection.find('#driver').val(meta[
			'driver'] ||
		'');
	deliverySection.find('#trackingNumber').val(meta['trackingNumber'] || '');
	deliverySection
		.find(
			'#isVehiclePicked').val(meta['isVehiclePicked'] || '');
	deliverySection.find('#SellerPickupAddress')
		.val(meta['sellerPickupAddress'] || '');
	deliverySection.find('#sellerPickupDate').val(meta[
		'sellerPickupDate'] || '');
	deliverySection.find('#sellerPickupTime').val(meta[
			'sellerPickupTime'] ||
		'');



	// Other Income
	// Set returned values into the fields, or empty if not provided
	jQuery('#otherIncomeAmount').val(meta['currency-4'] || '');
	jQuery('#otherIncomeFrequency').val(meta[
		'select-13'] || '');
	jQuery('#otherIncomeType').val(meta['select-14'] || '');
	jQuery(
		'#otherIncomeDescription').val(meta['text-45'] || '');

	// Housing     
	jQuery('#homeStatus').val(meta['select-10'] || '');
	jQuery('#mortageHolder').val(meta['text-43'] ||
		'');
	jQuery('#monthlyHousingPayment').val(meta['currency-5'] || '');
	jQuery('#marketValue').val(
		meta[
			'currency-7'] || '');
	jQuery('#mortagePayment').val(meta['currency-6'] || '');
	jQuery(
			'#additionalInfo')
		.val(meta['text-39'] || '');



}


function parseSerializedPHPData(serializedData) {
	// A simple parsing function (assumes the data is in a consistent format)
	var result = {};
	serializedData.replace(/s:17:"formatting_result";s:\d+:"([^"]+)";/g, function(_,
		formatting_result) {
		result["formatting_result"] = formatting_result;
	});
	return result;
}


function selectMatchingRadioButtonInGroup(metaValue, parentClass, radioGroupName) {
	// Check if metaValue is defined and not empty
	if (metaValue !== undefined && metaValue.trim() !== '') {
		console.log('Meta value:', metaValue, 'Parent class:', parentClass, 'Radio group name:',
			radioGroupName);

		// Convert metaValue to lowercase and split it into individual words for case-insensitive matching
		const wordsToMatch = metaValue.toLowerCase().split(/\s+/);

		// Select all radio buttons within the specified parent container
		const radioButtons = document.querySelectorAll(`${parentClass} input[name="${radioGroupName}"]`);

		// Iterate over the radio buttons to find and check the matching one
		radioButtons.forEach(radio => {
			// Convert the radio button value to lowercase for comparison
			const radioValue = radio.value.toLowerCase();

			// Check if any word from wordsToMatch is included in the radio button value
			if (wordsToMatch.some(word => radioValue.includes(word))) {
				radio.checked = true;
				console.log(`Matched and checked radio: ${radio.value}`);
			}
		});
	} else {
		console.log('Meta value is undefined or empty');
	}
}

// Example usage
// selectMatchingRadioButtonInGroup('Own with Mortgage', '.radio-group-container', 'housingStatus');




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


// Example usage:
// console.log(formatDateToISO("201988-03-08"));  



function extractNumericValue(value) {
	if (!value) return 0;

	// Convert value to a string in case it's not already
	let valueStr = value.toString();

	// Use regex to find numbers (including decimals) in the text
	let numericValue = valueStr.match(/[\d.,]+/);

	if (numericValue) {
		// Remove commas (if any) and parse the numeric string as a float
		return parseFloat(numericValue[0].replace(/,/g, ''));
	}

	return 0; // Return 0 if no valid numeric value is found
}



function setRadioValue(selector, value) {
	if (value === 'Yes') {
		jQuery(selector + ' input[type="radio"][value="Yes"]').prop('checked', true);
	} else if (value === 'No') {
		jQuery(selector + ' input[type="radio"][value="No"]').prop('checked', true);
	}
}



// Function to load session data into the form fields
function loadSessionData(prefix) {
	// Get stored data with prefix from sessionStorage
	var storedData = JSON.parse(sessionStorage.getItem(prefix + 'SessionData') || '{}');

	Object.keys(storedData).forEach(function(key) {
		jQuery(`#${prefix}-${key}-text`).text(storedData[key]);
		jQuery(`[data-field="${prefix}"][data-type="${key}"]`).val(storedData[key]);
	});
}

// Event handler for edit button click
jQuery(document).on('click', '[data-edit-btn]', function() {
	var $btn = jQuery(this);
	var isEditing = $btn.text() === 'Update';
	var prefix = $btn.data('field-prefix');

	if (isEditing) {
		$btn.addClass('btn-secondary').removeClass('btn-outline-secondary');

		// Collect input data for the current prefix and save it to session storage
		var fieldData = {};
		jQuery(`[data-field="${prefix}"]`).each(function() {
			var field = jQuery(this);
			var fieldType = field.data('type');
			var fieldValue = field.val();
			fieldData[fieldType] = fieldValue;
			jQuery(`#${prefix}-${fieldType}-text`).text(fieldValue).removeClass('d-none');
			field.addClass('d-none');
		});

		sessionStorage.setItem(prefix + 'SessionData', JSON.stringify(fieldData));

		// Send the updated data via AJAX
		addNewPaymentInfo(prefix, fieldData);
		$btn.text('Edit');
	} else {
		$btn.addClass('btn-outline-secondary').removeClass('btn-secondary');

		// Toggle inputs for editing mode
		jQuery(`[data-field="${prefix}"]`).each(function() {
			var field = jQuery(this);
			var fieldType = field.data('type');
			jQuery(`#${prefix}-${fieldType}-text`).addClass('d-none');
			field.removeClass('d-none');
		});

		$btn.text('Update');
	}
});

// Reusable AJAX function to send data to the server
function addNewPaymentInfo(prefix, fieldData) {
	jQuery('#loadingSpinner').show();

	var formData = new FormData();
	formData.append("action", "add_additional_escrow_info");
	formData.append("form_id", 330325);
	formData.append("entry_id", jQuery("#escrow_entry_id").val());
	formData.append("data_meta", `${prefix}_info`);
	formData.append("form_name", `${prefix} Info`);
	formData.append("form_title", `${prefix} Info Updated`);
	formData.append("additional_info", JSON.stringify(fieldData));

	formData.append('escrow_seller_email', jQuery('#escrow_entry_seller_email').val());
	formData.append('escrow_buyer_email', jQuery('#escrow_entry_buyer_email').val());
	formData.append('vehicle_name', jQuery('#escrow_entry_vehicle_name').val());
	formData.append('vehicle_vin', jQuery('#escrow_entry_vehicle_vin').val());

	addAdditionalEntryData(formData)
		.done(function(res) {
			jQuery('#loadingSpinner').hide();
			if (res.success) {
				if (res.data && res.data[`${prefix}_info`]) {
					// Update session data based on the response
					sessionStorage.setItem(prefix + 'SessionData', JSON.stringify(res.data[`${prefix}_info`]));
					loadSessionData(prefix);
				} else {
					showGlobalAlert('error', `Error: Response data missing for ${prefix}`);
				}
			} else {
				// alert("Error updating info: " + res.data);
				showGlobalAlert('error', `Error: Error updating info ${res.data}`);
			}
		})
		.fail(function(error) {
			jQuery('#loadingSpinner').hide();
			// alert("Error updating info.");
			showGlobalAlert('error', `Error: Error updating info ${res.data}`);
			console.error("Error:", error);
		});
}

// Initialize fields for each section on page load
jQuery(document).ready(function() {
	loadSessionData('buyerPayment');
	loadSessionData('lienHolder');
});




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
		documents.forEach(function(document) {
			// Iterate over each table row in the client document section
			jQuery('tr').each(function() {
				var row = jQuery(this);
				var documentId = row.data('document-id');
				var uploadName = row.data('upload-name');

				// Match document by ID and name
				if (document.doc_id == documentId && document.doc_name === uploadName) {
					// If document is completed, update the status cell
					if (document.document_is_complete === 'completed') {
						row.find('.doc-row-status').html(
							'<span class="turbo-success font-10 px-2 py-1 rounded-pill"><i class="fas fa-circle small mr-2"></i>Completed</span>'
						);
					} else {
						row.find('.doc-row-status').html(
							'<span class="turbo-warning font-10 px-2 py-1 rounded-pill"><i class="fas fa-circle small mr-2"></i>Uncompleted</span>'
						);
					}
				}
			});
		});
	} else {
		// console.log('Documents is not an array:', documents);
		jQuery('tr').each(function() {
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

jQuery(document).on('click', '.deal-entry-link', function() {

	// console.log('deal-entry-link clicked');

	var dealId = jQuery(this).data('entry-id');

	getDealInfoAfterClickDealLink(dealId);

});

function getDealInfoAfterUpdateData() {
	var dealId = sessionStorage.getItem('@deal-entry-id');
	getDealInfoAfterClickDealLink(dealId);
}

function getDealInfoAfterClickDealLink(entry_id) {



	jQuery('#loadingSpinner').show();
	jQuery.ajax({
		url: '<?php echo admin_url('admin-ajax.php'); ?>',
		type: 'POST',
		data: {
			action: 'get_admin_finance_details',
			entry_id: entry_id
		},
		success: function(response) {

			jQuery('.finance-back-main').removeClass('d-none');

			if (response.success) {

				showDealerPage('dealOverviewPage');

				var entry = response.data;
				var meta = entry.meta;

				insertApplicantInfo(entry, meta);
				noteSectionDealStatus(entry);

				if(entry.escrow_carfax_lien_result){
					sessionStorage.setItem('escrow_carfax_lien_result', entry.escrow_carfax_lien_result);
					jQuery('.carfax-doc-row-status').html(`<span class="turbo-success font-10 px-2 py-1 rounded-pill"><i class="fas fa-circle small mr-2"></i>Completed</span>`);
				}else{
					jQuery('.carfax-doc-row-status').html(`<span class="turbo-danger font-10 px-2 py-1 rounded-pill"><i class="fas fa-circle small mr-2"></i>Uncompleted</span>`);
				}

				sessionStorage.setItem('@deal-entry-id', entry.entry_id);
				jQuery("#escrow_entry_id").val(entry.entry_id);
				sessionStorage.setItem('@deal-form-id', <?php echo $credit_form_id; ?>);

				jQuery('#dealChatId').val(entry.entry_id);
				sessionStorage.setItem('@deal-user-email', meta['email-1']);
				sessionStorage.setItem('@deal-data' + entry.entry_id, JSON.stringify(meta));

				jQuery('#escrow_entry_seller_email').val(meta['email-1']);
				sessionStorage.setItem('@escrow-seller-email', meta['email-1']);



				sessionStorage.setItem('buyerPayment' + 'SessionData', JSON.stringify(entry[
					`buyerPayment_info`] || ''));

				loadSessionData('buyerPayment');

				sessionStorage.setItem('lienHolder' + 'SessionData', JSON.stringify(entry[
					`lienHolder_info`] || ''));

				loadSessionData('lienHolder');

				sessionStorage.setItem('delivery_escrow_' + 'SessionData', JSON.stringify(entry[
					`delivery_escrow_info`] || ''));



				loadSessionData('delivery_escrow_');


				jQuery('#sellerPaymentMethod').val(entry['seller_payment_method']);


				jQuery('#escrow_entry_seller_phone').val(meta['phone-1']);


				jQuery('#escrow_entry_buyer_email').val(meta['email-2']);
				sessionStorage.setItem('@escrow-buyer-email', meta['email-2']);

				jQuery('#escrow_entry_buyer_phone').val(meta['phone-2']);
				jQuery('#escrow_entry_vehicle_vin').val(meta['text-11']);
				var vehicle_title =
					`${meta['select-2'] || ''} ${meta['text-1'] || ''} ${meta['text-3'] || ''}`;
				jQuery('#escrow_entry_vehicle_name').val(vehicle_title);
				jQuery('.vehicle-name').val(vehicle_title);
				jQuery('.vehicle-vin').val(meta['text-11']);
				jQuery(".applicantRole").val(meta['select-19'] || '');

				console.log('Deal data: ', sessionStorage.getItem('@deal-data' + entry
					.entry_id));

				jQuery(".heading-deal-id").text('Deal #' + entry.entry_id);

				jQuery('.finance-entry-vin').html('VIN: ' + meta['text-11']);

				jQuery("#finance_pickup_id").val('pickup-' + entry.entry_id);




				financePickupSessionResponse(entry.finance_pickup_info);

				console.log('deal-document', entry.deal_document);
				updateRowStatus(entry.deal_document);

				getDealBasedNotes();





				// Example usage
				const dateCreated = entry
					.date_created; // Make sure this is a valid date string
				jQuery('.finance-entry-submit-date').html(formatDate(dateCreated));


				jQuery(".applicationDate").text(formatJustDate(dateCreated));


				jQuery('.seller-progress-container').html(escrowTransSellerProcess);
				var sellerStepX = entry.seller_escrow_entry_current_step;
				if (sellerStepX) {
					updateEscrowStep('seller', sellerStepX);
				}

				if (sellerStepX >= 5) {
					jQuery('.sellerProgressStepCompleate').text('Compleate');
				} else {
					jQuery('.sellerProgressStepCompleate').text('Pending');

				}

				console.log('delivery_escrow_info', sellerStepX);

				var financeStep = entry.entry_current_step;


				sessionStorage.setItem('finance-' + getFinanceId + '-step-' + meta[
						'email-1'],
					financeStep);

				financeItemDetails(meta);




				jQuery('#loadingSpinner').hide();


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
}




function updateEscrowStep(stepFor, step) {
	if (stepFor === 'seller') {
		var totalEscrowSteps = 5;
	} else if (stepFor === 'buyer') {
		var totalEscrowSteps = 6;
	} else {
		console.log('Invalid stepFor type');
		return;
	}

	var currentEscrowStep = step;

	console.log('step: ', currentEscrowStep);

	var $steps = jQuery('.seller-progress-container .step-wrap');

	var $progressBar = jQuery('.seller-progress-container #progress');

	$steps.removeClass('active').each(function(index) {
		if (index + 1 <= currentEscrowStep) {
			jQuery(this).addClass('active');
		}
	});



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




function noteSectionDealStatus(entry) {
	let financeStepStatus = entry.finance_step_status;
	let bookedStatus = '';

	console.log(financeStepStatus);

	bookedStatus += `<div style="text-align:center">`;

	// Buttons based on finance status
	if (financeStepStatus.step >= 5) {
		bookedStatus += `<button class="turbo-success font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2"></i> ${financeStepStatus.status || "Approved"}
                                    </button>`;
	} else if (financeStepStatus.status === "Approved" && financeStepStatus.step >= 1) {
		bookedStatus += `<button class="turbo-success font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2"></i> ${financeStepStatus.status || "Pending"}
                                    </button>`;
	} else if (financeStepStatus.step < 5 && financeStepStatus.step >= 1) {
		bookedStatus += `<button class="turbo-warning font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2"></i> ${financeStepStatus.status || "Pending"}
                                    </button>`;
	} else {
		bookedStatus += `<button class="turbo-danger font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2"></i> ${financeStepStatus.status || "Pending"}
                                    </button>`;
	}


	jQuery('.noteSectionDealStatus').html(bookedStatus);

}


function userVeriffDecision(veriffDecision) {
	if (veriffDecision.verification.status === "approved") {
		financeStatusBasedUpdateInfo(3, 'Approved');
	}
}

function financeItemDetails(meta) {
	var applicationDetails = `

        <
        div class = "h6" > < i class = "far fa-file" > < /i> Item details</div >
        <
        h6 class = "mb-2" > $ {
            meta['select-1']
        }
    $ {
        meta['text-14']
    }
    $ {
        meta['select-2']
    } < /h6> <
    strong > VOI(Vehicle of interest) < /strong> <
        div class = "d-flex justify-content-between text-dark" > < span >
        $ {
            meta['text-1']
        } < /span> </div >

        <
        div class = "d-flex justify-content-between text-dark" > < span class = "financing-entry-vin" >
        Marketplace Link:
        $ {
            meta['url-1']
        } < /span></div >
        <
        div class = "d-flex justify-content-between text-dark" > < span > VIN:
        $ {
            meta['text-13']
        } < /span></div >

        <
        strong > Applicants Personal Information <
        /strong> <
        div class = "d-flex justify-content-between text-dark" > < span > Name: $ {
            meta['name-1']
        }
    $ {
        meta['name-2']
    } < /span></div >

    <
    div class = "d-flex justify-content-between text-dark" > < span > Email: $ {
            meta['email-1']
        } < /span></div >

        <
        div class = "d-flex justify-content-between text-dark" > < span > Phone: $ {
            meta['phone-1']
        } < /span> <span>Mobile: ${meta['phone-2']}</span > < span > Work: $ {
            meta['phone-3']
        } < /span></div >

        <
        div class = "d-flex justify-content-between text-dark" > < span > SIN: $ {
            meta['text-4']
        } < /span> </div >


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
			'<h5 class="my-5"> Seller has not added Disbursement Wire/Bank Transfer information yet! </h5>'
		);
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
			jQuery('#finance-' + i + '-verified').removeClass('finance-warning').addClass(
					'finance-accepted')
				.text(
					'Approved').prop('disabled',
					true);
			jQuery('#finance-' + i + '-unverified').removeClass('finance-accepted').addClass(
					'finance-warning')
				.text(
					'Make Cancel').prop(
					'disabled', false);
			if (i >= 3) {
				jQuery('#finance-3-verified').removeClass('finance-warning').addClass('finance-accepted')
					.text(
						'Verified').prop('disabled',
						false);
			} else {
				jQuery('#finance-3-verified').addClass('finance-warning').removeClass('finance-accepted')
					.text(
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
			jQuery('#finance-' + i + '-unverified').removeClass('finance-warning').addClass(
					'finance-accepted')
				.text(
					'Canceled').prop(
					'disabled', true);
			jQuery('#finance-' + i + '-verified').removeClass('finance-accepted').addClass(
					'finance-warning')
				.text(
					'Make Approved').prop('disabled',
					false);
			if (i >= 3) {
				jQuery('#finance-3-verified').addClass('finance-warning').removeClass('finance-accepted')
					.text(
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



function escrowProgressVerification() {
	const entry = JSON.parse(sessionStorage.getItem('@deal-new-status'));
	const stepMeta = entry.user === 'seller' ? 'seller_escrow_entry_current_step' : 'escrow_entry_current_step';

	// console.log('entry status:', entry)

	const formData = new FormData();
	formData.append("action", "add_additional_escrow_info");
	formData.append("form_id", 330325);
	formData.append("entry_id", entry.entry_id);
	formData.append("data_meta", `${entry.user}_escrow_step_status`);
	formData.append("form_name", "Escrow Step Status");
	formData.append("form_title", `Escrow ${entry.step_name} Status ${entry.status} for #${entry.entry_id}`);
	formData.append(entry.user === 'buyer' ? 'escrow_buyer_email' : 'escrow_seller_email', entry[`${entry.user}Email`]);
	formData.append("vehicle_name", entry.vehicleName);
	formData.append("vehicle_vin", entry.vehicleVin);
	formData.append("additional_info", JSON.stringify(entry));

	jQuery('#loadingSpinner').show();

	// Update entry step

	changeEscrowProgressStep();

	addAdditionalEntryData(formData)
		.done(function(res) {
			jQuery('#loadingSpinner').hide();
			if (res.success) {
				const statusKey = `${entry.user}_escrow_step_status`;
				if (res.data[statusKey]?.status) {
					mainDealsImportFromServer();
					// alert("Escrow status updated successfully");
					showGlobalAlert('success', `<h3>Escrow status updated successfully</h3>`)
				}
			} else {
				// alert("Error updating status: " + res.data);
				showGlobalAlert('error', `<h3>Error updating status: ${res.data}</h3>`)
			}
		})
		.fail(function(error) {
			console.error("Error:", error);
			// alert("Error updating status.");
			showGlobalAlert('error', `<h3>Error updating status: ${error}</h3>`)
		});


	jQuery('#loadingSpinner').hide();

}

function changeEscrowProgressStep(){
	const entry = JSON.parse(sessionStorage.getItem('@deal-new-status'));
	const stepMeta = entry.user === 'seller' ? 'seller_escrow_entry_current_step' : 'escrow_entry_current_step';
		jQuery.ajax({
		url: '<?php echo admin_url("admin-ajax.php"); ?>',
		type: 'POST',
		data: {
			action: 'update_entry_step',
			form_id: 330325,
			entry_id: entry.entry_id,
			step_meta: stepMeta,
			current_step: entry.step,
		},
		success: function(response) {

			console.log('Updated Step: ', response.data)

			// Add additional entry data

			// showGlobalAlert('success', `<h3>Escrow status updated successfully</h3>`)
			

		},
		error: function() {
			// alert('An error occurred.');
			showGlobalAlert('error', `<h3>An error occurred.</h3>`);
		}
	});
}



function financeProgressVerification(dealId, step, stepName, status) {
	jQuery('#loadingSpinner').show();


	let storedData = {
		step: step,
		step_name: stepName,
		status: status
	};

	if (!dealId) {
		// alert("Deal Id Not Defined");
		showGlobalAlert('error', `<h3>Deal Id Not Defined</h3>`);
		return
	}


	var vehicle_name = jQuery('#escrow_entry_vehicle_name').val();
	var vehicle_vin = jQuery('#escrow_entry_vehicle_vin').val();

	var formData = new FormData();
	formData.append("action", "add_additional_escrow_info");
	formData.append("form_id", 330325); // Replace with your form ID
	formData.append("entry_id", dealId);
	formData.append("data_meta", "finance_step_status");
	formData.append('form_name', 'Finance Step Status');
	formData.append('form_title', 'Deal status ' + status + ' for #' + dealId);

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

					mainDealsImportFromServer();

					// alert("Deal status updated successfully");
					showGlobalAlert('success', `<h3>Escrow status updated successfully</h3>`);

					var statusValue = res.data[statusKey]['status'];
					// Update the button color based on the status

					financeStatusBasedUpdateInfo(step, statusValue);


				}
			} else {
				// alert("Error updating status: " + res.data);
				showGlobalAlert('error', `<h3>Error updating status</h3>`);
			}
		})
		.fail(function(error) {
			console.error("Error:", error);
			// alert("Error updating status.");
			showGlobalAlert('error', `<h3>Error updating status</h3>`);
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



function addNewPickUpInfo() {
	var uniqueId = jQuery("#finance_pickup_id").val();
	jQuery('#loadingSpinner').show();
	if (uniqueId) {
		var storedData = JSON.parse(sessionStorage.getItem(uniqueId));

		var entryId = jQuery("#finance_entry_id").val();
		var seller_email = jQuery('#finance_entry_email').val();

		var vehicle_name = jQuery('#escrow_entry_vehicle_name').val();
		var vehicle_vin = jQuery('#escrow_entry_vehicle_vin').val();

		var formData = new FormData();
		formData.append("action", "add_additional_escrow_info");
		formData.append("form_id", 330325); // Replace with your form ID
		formData.append("entry_id", entryId); // Replace with your entry ID
		formData.append("data_meta", "finance_pickup_info");
		formData.append('form_name', 'Finance Booking Slot Info');
		formData.append('form_title', 'Finance Booking Slot Info Updated');
		formData.append('vehicle_name', vehicle_name);
		formData.append('vehicle_vin', vehicle_vin);

		formData.append("additional_info", JSON.stringify(storedData));

		// Call the function and handle the response
		addAdditionalEntryData(formData)
			.done(function(res) {
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
					// alert("Error updating info: " + res.data);
					showGlobalAlert('error', `<h3>Error updating info</h3>`);
				}
			})
			.fail(function(error) {
				jQuery("#timeslot-next").prop("disabled", true);
				console.error("Error:", error);
				// alert("Error updating info.");
				showGlobalAlert('error', `<h3>Error updating info</h3>`);
			});
	} else {
		jQuery("#timeslot-next").prop("disabled", true);
	}
}


function financePickupSessionResponse(storedData) {


	//console.log(storedData);

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

function formatJustDate(dateString) {
	const date = new Date(dateString);

	const options = {
		year: 'numeric',
		month: 'long',
		day: 'numeric',

	};

	return date.toLocaleDateString('en-US', options).replace(', ', ', ');
}


jQuery(document).ready(function($) {
	let make = '';
	let model = '';
	let year = '';

	// Click event for the search VIN button
	jQuery('.vehicle-vin-section #vin-input').on('change', function() {
		// Find the VIN input field in the same section and get its value
		const vin = jQuery(this).closest('.vehicle-vin-section').find('#vin-input').val();

		// Store reference to the closest section
		const section = $(this).closest('.vehicle-vin-section');

		console.log("VIN entered: ", vin);

		if (!vin) {
			console.error("VIN input is empty");
			return;
		}

		// Call the VIN decoding API
		vinDecodeApi(vin).done(function() {
			// Assuming the API returns 'model', 'year', and 'make' in the response


			// Update the input fields with the decoded values
			section.find("#model-input").val(model); // Update model field
			section.find("#year").val(year); // Update year field
			section.find("#make-input").val(make); // Update make field
		}).fail(function(error) {
			console.error("Error decoding VIN:", error);
		});
	});


	function vinDecodeApi(vin) {
		const apiUrl = `https://vpic.nhtsa.dot.gov/api/vehicles/decodevin/${vin}?format=json`;

		return $.getJSON(apiUrl, function(data) {
			make = '';
			model = '';
			year = '';

			data.Results.forEach(result => {
				if (result.Variable === 'Make') {
					make = result.Value;
				} else if (result.Variable === 'Model') {
					model = result.Value;
				} else if (result.Variable === 'Model Year') {
					year = result.Value;
				}
			});

			if (!make || !model || !year) {
				// alert('Failed to retrieve vehicle information. Please check the VIN.');
				showGlobalAlert('error', `<h3>Failed to retrieve vehicle information. Please check the VIN.</h3>`);
				return;
			}
		}).fail(function() {
			// alert('Error connecting to the API. Please try again later.');
			showGlobalAlert('error', `<h3>Error connecting to the API. Please try again later.</h3>`);
		});
	}

});
</script>
<input type="hidden" id="transportDistance" />
<script>
jQuery(document).ready(function($) {
	$('.carTypeCard').click(function() {
		// Toggle 'selected' class for clicked card
		$('.carTypeCard').removeClass('selected');
		$(this).addClass('selected');

		// Get the card title and price
		let cardTitle = $(this).find('.termType').text();

		// Check if the card is selected
		if ($(this).hasClass('selected')) {
			// If selected, log the card details
			console.log(`Selected: ${cardTitle}`);
		} else {

			// If deselected, log that it was deselected
			console.log(`Deselected: ${cardTitle}`);
		}
	});
});

jQuery('#bookTrasportBtn').on('click', function() {
	jQuery('#loadingSpinner').show(); // Show the loading spinner

	var dealId = sessionStorage.getItem('@deal-entry-id');
	const meta = JSON.parse(sessionStorage.getItem('@deal-data' + dealId) || "{}");

	// Check required values
	const requiredFields = {
		vehicleName: jQuery('#escrow_entry_vehicle_name').val(),
		transportDate: jQuery('#transportDateCollect').val(),
		transportPickup: jQuery('#transportPickupLocation').val(),
		transportDestination: jQuery('#transportDropLocation').val(),
		transportVIN: jQuery('#escrow_entry_vehicle_vin').val(),
		transportFee: jQuery('#transportDeliveryFee').val()
	};

	for (const [field, value] of Object.entries(requiredFields)) {
		if (!value) {
			// alert(`Please fill out the ${field} field.`);
			showGlobalAlert('error', `<h5>Please fill out the ${field} field.</h5>`);
			jQuery('#loadingSpinner').hide(); // Hide the spinner
			return; // Stop further execution
		}
	}


	const formData = new FormData();

	formData.append('transport_case_id', dealId);
	formData.append('transportId', dealId);
	formData.append('transportPriority', jQuery('.transport-form-type input[type="radio"]:checked').val());
	formData.append('vehicleName', requiredFields.vehicleName);
	formData.append('transportDate', requiredFields.transportDate);
	formData.append('transportPickup', requiredFields.transportPickup);
	formData.append('transportDestination', requiredFields.transportDestination);
	formData.append('carTypeCard', jQuery('.carTypeCard selected').find('.termType').text() || "");
	formData.append('transportVIN', requiredFields.transportVIN);
	formData.append('transportFee', requiredFields.transportFee);
	formData.append('transportStatus', "New Transport Order");
	formData.append('transportReferral', "Trbo Swift Escrow");
	// Append arrays and objects in proper JSON format
	formData.append('transportSender', JSON.stringify([{
		"name": `${meta['select-19'] === 'Seller' ?  meta['name-6'] + ' ' + meta['name-7'] : meta['name-9'] + ' ' + meta['name-10'] }`,
		"phone": meta['phone-1'] || '',
		"email": sessionStorage.getItem('@escrow-seller-email') || ''
	}]));
	formData.append('transportReceiver', JSON.stringify([{
		"name": `${meta['select-19'] === 'Buyer' ?  meta['name-6'] + ' ' + meta['name-7'] : meta['name-9'] + ' ' + meta['name-10'] }`,
		"phone": meta['phone-2'] || '',
		"email": sessionStorage.getItem('@escrow-buyer-email') || ''
	}]));
	formData.append('transportDriver', JSON.stringify([])); // Empty array for transportDriver
	formData.append('transportPickupLocation', JSON.stringify({
		"address": requiredFields.transportPickup,
		"map-log": "",
		"map-lat": ""
	}));
	formData.append('transportDestinationLocation', JSON.stringify({
		"address": requiredFields.transportDestination,
		"map-log": "",
		"map-lat": ""
	}));

	formData.append('transportDistance', jQuery('#transportDistance').val() || "");
	formData.append('transportCurrentGooglelocation', JSON.stringify([]));
	formData.append('transportAwaitingPickup', "");
	formData.append('transportOnRoute', "");
	formData.append('transportPickupTime', "");
	formData.append('transportDeliveryTime', "");
	formData.append('transportDeliveryStatus', JSON.stringify([]));
	formData.append('transportDeliveryCompleted', "");
	formData.append('transportNotes', JSON.stringify([]));

	const apiUrl = '<?php echo home_url(); ?>/rancoded-json/api/v1/submit-transport-request';

	// Send AJAX POST request
	jQuery.ajax({
		url: apiUrl,
		type: 'POST',
		data: formData,
		processData: false,
		contentType: false,
		success: function(res) {
			console.log(res);
			// alert('Transport request submitted successfully!');
			showGlobalAlert('', `<h3>Thank you for booking with Trbo Swift Transport.</h3> <br><br><span>Details of your transaction can be found transport account.</span>`);
			jQuery('#loadingSpinner').hide(); // Hide spinner
		},
		error: function() {
			// alert('Error connecting to the API. Please try again later.');
			showGlobalAlert('error', `<h3>Error connecting to the API. Please try again later.</h3>`);

			jQuery('#loadingSpinner').hide(); // Hide spinner
		}
	});
});


jQuery('.seller-send-kyc-btn').on('click', function(){
addMetaValue('KycRequest', 'Yes')
});


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
					showGlobalAlert('success', `Submitted ${metaName} successfully`);
			} 
		})
		.fail(function(error) {
			console.error("Error:", error);
		});

}

</script>

<script>
// Example usage for different instances
// initializeFileUploadHandler('#documentProofDropArea', '#documentProofFileInput', '#documentProofPreviewContainer',
// 	'.upload-proof-btn');
</script>



<div id="popupDisclaimer">
	<div class="modal-dialog">
		<div class="modal-content bg-white position-relative" style="border-radius:20px;">
			<button onclick="jQuery('#popupDisclaimer').fadeOut(400);" type="button" class="btn btn-light rounded-pill"
				style="position: absolute; right: 30px; top: 15px; z-index:5;"><i class="fal fa-times"></i></button>
			<div class="modal-body">

			</div>

		</div>
	</div>
</div>


<div id="loadingSpinner" class="spinner-overlay" style="display:none;">
	<div class="spinner-grow text-light" role="status">
		<span class="sr-only">Loading...</span>
	</div>
</div>


<script>
jQuery(document).ready(function() {
	const customSelectLists = jQuery('[custom-select]');

	customSelectLists.each(function() {
		const customSelect = jQuery(this);
		const inputField = customSelect.find(
			'#qute-vehicle-details');
		const dropdownEl = customSelect.find('.dropdown');
		const clearSelectionButton = customSelect.find(
			'.btn-clear-selection');
		const radioButtons = dropdownEl.find(
			'input[type="radio"]');

		// Reveal dropdown on input focus
		inputField.on("focus", function() {
			dropdownEl.addClass("show");
		});

		// Close dropdown if clicked outside
		jQuery(document).on("click", function(event) {
			if (!customSelect.is(event.target) &&
				customSelect.has(event.target)
				.length === 0) {
				dropdownEl.removeClass("show");
			}
		});

		// Handle radio button selection
		radioButtons.on('change', function() {
			const label = customSelect.find(
				`label[for="${jQuery(this).attr('id')}"]`
			);
			inputField.val(label.text().trim());
			clearSelectionButton.show();
			dropdownEl.removeClass("show");
		});

		// Clear selection button
		clearSelectionButton.on('click', function() {
			inputField.val("");
			clearSelectionButton.hide();
			radioButtons.prop('checked', false);
		});

		// Increment and decrement functionality for vehicle values
		function handleIncrementDecrement(incrementButtonId,
			decrementButtonId, inputId) {
			const incrementButton = jQuery(
				`#${incrementButtonId}`);
			const decrementButton = jQuery(
				`#${decrementButtonId}`);
			const inputField = jQuery(`#${inputId}`);

			incrementButton.on('click', function() {
				let currentValue = parseInt(
					inputField
					.val(), 10);
				if (isNaN(currentValue))
					currentValue =
					0; // Ensure it's a valid number
				inputField.val(currentValue + 1);
			});

			decrementButton.on('click', function() {
				let currentValue = parseInt(
					inputField
					.val(), 10);
				if (isNaN(currentValue))
					currentValue =
					0; // Ensure it's a valid number
				if (currentValue > 0) {
					inputField.val(currentValue -
						1);
				}
			});
		}

		// Apply increment/decrement handlers for each vehicle category
		handleIncrementDecrement('small-increment',
			'small-decrement', 'small-vehicle-value');
		handleIncrementDecrement('medium-increment',
			'medium-decrement', 'medium-vehicle-value');
	});
});
</script>


<style>



.inc-dec-btn {
	border-radius: 100px !important;
	width: 30px;
	height: 30px;
	display: flex;
	justify-content: center;
	align-items: center;
}



[custom-select] {
	position: relative;
	width: 100%;
	isolation: isolate;
	z-index: 0;
}

[custom-select] .input-container {
	position: relative;
}

[custom-select] label {
	display: block;
	font-size: 0.8rem;
	margin-bottom: 0.25rem;
}

[custom-select] input[type="text"] {
	width: 100%;
	padding: 0.75rem;
	padding-right: 2rem;
	/* Space for the delete button */
	box-sizing: border-box;
	text-transform: capitalize;
	outline: none;
	border: 1px solid rgba(from var(--clr-primary) r g b / .25);
	cursor: pointer;
	z-index: 1;
}

[custom-select] input[type="text"]:focus-visible {
	border-color: var(--clr-secondary);
}

[custom-select] .btn-clear-selection {
	position: absolute;
	top: 50%;
	right: 10px;
	transform: translate(0, -50%);
	background: transparent;
	border: none;
	outline: none;
	cursor: pointer;
	font-size: 18px;
	color: var(--clr-primary);
	display: none;
	/* Initially hidden */
	z-index: 2;
	transition: color 300ms ease-in-out;
}

[custom-select] .btn-clear-selection:focus-visible,
[custom-select] .btn-clear-selection:hover {
	color: var(--clr-secondary);
}

[custom-select] .dropdown {
	position: absolute;
	top: 100%;
	left: 0;
	width: 100%;
	border: 1px solid var(--clr-secondary);
	background-color: #fff;
	border-top: none;
	opacity: 0;
	transform: scaleY(0);
	transform-origin: top;
	z-index: 1000;
}

[custom-select] .dropdown input[type=radio] {
	position: absolute;
	width: 1px;
	height: 1px;
	padding: 0;
	margin: -1px;
	overflow: hidden;
	clip: rect(0, 0, 0, 0);
	white-space: nowrap;
	border-width: 0;
}

[custom-select]:has(.dropdown.show) {
	z-index: 10;
}

.dropdown.show {
	transition: opacity 0.3s ease, transform 0.3s ease;
	opacity: 1;
	transform: scaleY(1);
}

/* Radio buttons styling within the dropdown */
[custom-select] .dropdown label {
	display: flex;
	align-items: center;
	width: 100%;
	font-size: 16px !important;
	cursor: pointer;
	transition: background-color 300ms ease-in-out;
}

[custom-select] .dropdown label:hover {
	background-color: rgba(from var(--clr-secondary) r g b / .25);
}

[custom-select] .dropdown label input[type="radio"] {
	margin-right: 10px;
}

[custom-select] .dropdown label:focus-within {
	background-color: var(--clr-secondary);
	color: #FFF;
}

[custom-select] .dropdown label+label {
	border-top: 1px dotted var(--clr-primary);
}
</style>


<style>
/* Style for the popup */
#popupDisclaimer {
	display: none;
	position: fixed;
	top: 0px;
	right: 0;
	bottom: 0;
	left: 0;
	outline: 0;
	z-index: 9999;
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


#popupDisclaimer .modal-content {
	padding: 20px;
	border-radius: 20px;
}



@media (min-width: 576px) {
	#popupDisclaimer .modal-dialog {
		max-width: 70%;
		margin: 1.75rem auto;
	}

	.c29 {
		background-color: #ffffff;

		padding: 72pt 72pt 72pt 72pt
	}
}

</><style>ul#all-bids {
	border-bottom: 1px solid #ddd;
}

ul#all-bids.nav li {
	padding: 0px;
	margin-bottom: 0px;
}



ul#all-bids.nav li a {
	padding: 5px 20px 5px 20px;
	background: white;
	color: #909090;
	border: 1px solid #fff0;

}

ul#all-bids.nav li a.active {
	font-weight: bold;
	color: #202224;
	border-bottom: 1px solid #000;
}

ul#new-leads {
	border-bottom: 1px solid #ddd;
}

ul#new-leads.nav li {
	padding: 5px;
	margin-bottom: 0px;
}



ul#new-leads.nav li a {
	padding: 5px 20px 5px 20px;
	background: white;
	color: #909090;
	border: 1px solid #fff0;

}

ul#new-leads.nav li a.active {
	font-weight: bold;
	color: #202224;
	border-bottom: 1px solid #000;
}

.avatar.img-fluid {
	border-radius: 100%;
	width: 20px;
	height: 20px;
}



/* Step Process Start */


.progress-container {
	display: flex;
	justify-content: space-between;
	position: relative;
	margin-bottom: 30px;
	width: 100%;
}

.progress-container::before {
	content: '';
	background-color: #ddd;
	position: absolute;
	left: 20px;
	transform: translateY(-50%);
	height: 1px;
	width: calc(100% - 30px);
	z-index: 0;
}

.progress {
	background-color: #3B634C;
	position: absolute;
	left: 20px;
	transform: translateY(-50%);
	height: 1px;
	width: 0%;
	z-index: 0;
	transition: 400ms ease;
}

.step-wrap {
	display: grid;
	text-align: center;
	width: 50px;
	z-index: 1;
	justify-content: center;
	justify-items: center;
}

.step-wrap p {

	color: #aaa;
}

.step-wrap.active p {
	font-weight: 500;
	color: #000;
	transition: 400ms ease;
}

.circle {
	background-color: #fff;
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	transition: 400ms ease;
}


.circle .step-title {
	border-radius: 50%;
	box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
	width: 100%;
	height: 100%;
	display: flex;
	align-items: center;
	justify-content: center;
	color: #BC9F4C;
	font-weight: 400;
	font-size: 10px;
}

.step-wrap.active .circle {
	border-color: #BC9F4C;
}

.step-wrap.active .step-title {
	background-color: #124326;
	box-shadow: none;
	color: #fff;
}


.btn:disabled {
	background-color: #ccc;
	cursor: not-allowed;
}


@media screen and (min-width: 500px) {
	.circle {

		border: 4px solid #f8f9fa;

		height: 35px;
		width: 35px;
	}

	.progress-container::before {

		top: 18px;
	}

	.progress {
		top: 18px;
	}

	.step-wrap p {
		font-weight: 400;
		font-size: 10px;
	}

}

@media screen and (max-width: 500px) {
	.circle {
		border: 2px solid #f8f9fa;
		height: 25px;
		width: 25px;
	}

	.progress-container::before {
		top: 13px;
	}

	.progress {
		top: 13px;
	}

	.step-wrap p {
		font-weight: 400;
		font-size: 7px;
	}

}

/* Step Process Stop */


@media screen and (max-width: 1100px) {
	.table.small.table-orders {
		overflow-x: scroll;
		width: 1200px;
	}
}

.deal-entry-link.btn-secondary{
	    font-size: 10px !important;
    min-width: 70px;
    align-content: center;
}

.col.overflow-auto{
	align-content: center;
}

.col{
	padding:0px;
	align-content: center;
}

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

.carTypeCard {
	border: 2px solid #fff;
	border-radius: 10px;
	transition: all 0.3s ease-in-out;
	height: 100%;
	cursor: pointer;
}

.carTypeCard:hover {
	transform: translateY(-5px);
	box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}


.carTypeCard.selected {
	border: 2px solid #F79646;
}


.turbo-warning {
	color: #B99D4B;
	border: 1px solid #B99D4B;
	background: rgba(185, 157, 75, 0.20);
	color: #BF9B3E;
	min-width: 73px;
	    display: flex
;
    justify-content: center;
    align-items: center;
    gap: 3px;
}

.turbo-success {
	border: 1px solid #4bb96c;
	background: rgb(75 185 113 / 20%);
	color: #3ebf4b;
	min-width: 73px;
	    display: flex
;
    justify-content: center;
    align-items: center;
    gap: 3px;
}

.turbo-danger {
	border: 1px solid #dc3545;
	background: rgb(185 75 75 / 20%);
	color: #dc3545;
	min-width: 73px;
	    display: flex
;
    justify-content: center;
    align-items: center;
    gap: 3px;
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


#deal-overview-tabs {
	font-size: 12px;
	gap: 15px;
	border-bottom: 1px solid #DDDDDD;
}

#deal-overview-tabs .deal-tab {
	padding: 2px 0px !important;
	color: #979797;
}

#deal-overview-tabs .deal-tab.active {
	color: #202224;
	border-bottom: 1px solid #202224;

}



.custom-card {
	border-radius: 10px;
	background-color: #fff;
	box-shadow: 4px 4px 39px rgba(0, 0, 0, 0.05);
	padding: 14px 16px 33px;
	margin: 15px 0;
}

.custom-card .form-control,
.form-group .form-control {
	border-radius: 92px;
	font-weight: 700;
	padding: 0px 19px;
	border: 1px solid #bbbbbb;
	max-height: 38px;
}

.form-row {
	font-size: 12px;
}



.co-app-info-update-btn,
.employment-info-update-btn {
	border-radius: 61px;
	background-color: #fff;
	font-size: 12px;
	color: #3b634c;
	text-align: center;
	line-height: 1;
	padding: 13px 42px;
}

tbody td {
	vertical-align: middle !important;
}

.deal-tabs-info .badge {
	min-width: 22px;
}

.dropdown.show {
	z-index: 1;
}

.vehiclePurchasAgreement {
	display: none;
}

.dropdown-toggle::after {
	display: none !important;
}


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


.transportBody {
	background-color: #f8fdf4;
	height: 100%;
	margin: 0;
	display: flex;
	justify-content: center;
	align-items: center;
	position: absolute;
	left: 0;
	right: 0;
	z-index: 0;
	border-radius: 20px;
	min-height: 66vh;

}

.circlex {
	position: absolute;
	border-radius: 50%;
	filter: blur(100px);
}

.circle1 {
	width: 300px;
	height: 300px;
	background-color: #0e43cb85;
	bottom: 20%;
	left: 20%;
}

.circle2 {
	width: 500px;
	height: 500px;
	background-color: rgba(173, 216, 230, 0.5);
	bottom: 10%;
	right: 10%;
}
</style>

<style>
.user-info-card {
	border-radius: 10px;
	background-color: #fff;
	box-shadow: 4px 4px 39px rgba(0, 0, 0, 0.05);
	display: flex;
	margin-top: 11px;
	width: 100%;
	flex-direction: column;
	padding: 19px 0 34px 12px;
}



.user-details-column {
	display: flex;
	flex-direction: column;
	width: 70%;
}

.info-group {
	display: flex;
	margin-top: 16px;
	width: 100%;
	flex-direction: column;
}

.info-row {
	display: flex;
	align-items: center;
	gap: 17px;
	color: #3f3f3f;
	justify-content: start;
	flex-wrap: wrap;
	font: 12px/36px Inter, sans-serif;
}

.info-field {
	border-radius: 92px;
	align-self: stretch;
	display: flex;
	min-width: 240px;
	flex-direction: column;
	margin: auto 0;
}

.field-label {
	font-weight: 400;
	align-self: start;
	z-index: 10;
}

.field-value {
	border-radius: 92px;
	font-weight: 700;
	padding: 0px 19px;
	border: 1px solid #bbbbbb;
}

.residence-type-group {
	align-self: start;
	display: flex;
	align-items: flex-start;
}

.residence-type-option {
	display: flex;
	margin-top: 8px;
	gap: 20px;
	justify-content: space-between;
}

.radio-button {
	background-color: #fff;
	border-radius: 50%;
	display: flex;
	width: 18px;
	height: 18px;
	padding: 0 4px;
}

.radio-button-inner {
	background-color: #004225;
	border-radius: 50%;
	width: 10px;
	height: 10px;
}

.license-image-column {
	display: flex;
	flex-direction: column;
	width: 30%;
}

.license-image-container {
	display: flex;
	flex-grow: 1;
	flex-direction: column;
	color: #202224;
	font: 400 20px/1 Inter, sans-serif;
}

.license-image {
	aspect-ratio: 1.03;
	object-fit: contain;
	width: 100%;
	border-radius: 22px;
}

.license-label {
	align-self: start;
	margin-top: 13px;
}

.login-info-group {
	position: relative;
	display: flex;
	align-items: flex-start;
	gap: 17px;
	white-space: nowrap;
	justify-content: start;
	flex-grow: 1;
	flex-basis: auto;
}

.login-field {
	border-radius: 92px;
	z-index: 0;
	display: flex;
	min-width: 240px;
	flex-direction: column;
	width: 401px;
	margin: auto 0;
}

.login-input {
	border-radius: 92px;
	background-color: rgba(239, 239, 239, 0.82);
	height: 47px;
	border: 1px solid #bbbbbb;
}

.visually-hidden {
	position: absolute;
	width: 1px;
	height: 1px;
	padding: 0;
	margin: -1px;
	overflow: hidden;
	clip: rect(0, 0, 0, 0);
	white-space: nowrap;
	border: 0;
}

@media (max-width: 991px) {
	.user-info-card {
		max-width: 100%;
	}


	.user-details-column,
	.license-image-column {
		width: 100%;
	}

	.info-group,
	.info-row,
	.login-info-group {
		max-width: 100%;
	}

	.field-value,
	.license-image {
		max-width: 100%;
	}

	.login-field {
		white-space: initial;
	}
}

@media (max-width: 575.98px) {
	.mobile-mb-6 {
		margin-bottom: 0px !important;
	}
}

fieldset {
	display: flex;
	gap: 10px;
}

fieldset input.form-check-input {
	margin-top: 0px !important;
}

fieldset label {
	margin-bottom: 0px !important;
}

</style>
<style>
.applicant-card {
	border-radius: 10px;
	background-color: #3b634c;
	box-shadow: 4px 4px 39px rgba(0, 0, 0, 0.05);
	display: flex;
	width: 100%;
	align-items: flex-start;
	gap: 20px;
	flex-wrap: wrap;
	justify-content: space-between;
	padding: 10px 31px;
}

.applicant-header {
	display: flex;
	margin-top: 5px;
	gap: 32px;
	flex-wrap: wrap;
}

.applicant-info {
	display: flex;
	flex-direction: column;
	flex-grow: 1;
	flex-basis: 0;
	width: fit-content;
}

.applicant-title {
	color: #f8f9fa;
	align-self: flex-start;
	font: 600 25px/3 'Plus Jakarta Sans', -apple-system, Roboto, Helvetica, sans-serif;
}

.applicant-actions {
	display: flex;

	gap: 8px;
	font: 400 12px/1 Inter, sans-serif;
}

.funding-docs-btn {
	border-radius: 61px;
	background-color: #bf9b3e;
	color: #fff;
	text-align: center;
}

.status-label {
	color: rgba(255, 255, 255, 0.40);
	font-family: Inter;
	font-size: 12px;
	font-style: normal;
	font-weight: 400;
	/* 111.993% */
}

.kyc-status-label {
	color: rgba(255, 255, 255, 0.4);
	font-size: 14px;
	line-height: 1;
	margin: auto 0;
}

.kyc-status-value {
	color: #f8f9fa;
	font-size: 14px;
	line-height: 1;
	margin: auto 0;
}

.send-kyc-request-btn {
	border-radius: 61px;
	background-color: #bf9b3e;
	align-self: flex-end;
	margin-top: 40px;
	color: #fff;
	text-align: center;
	font: 400 12px/1 Inter, sans-serif;
}

.applicant-details {
	display: flex;
	flex-direction: column;
	color: #fff;
	font: 400 14px/1 Inter, sans-serif;
}

.vendor-deal-info {
	display: flex;
	gap: 37px;
}

.vendor-info {
	text-align: right;
	flex-grow: 1;
	width: 184px;
}

.manager-info {
	text-align: right;
	align-self: center;
	margin-top: 9px;
}

@media (max-width: 991px) {
	.applicant-card {
		max-width: 100%;
		padding: 0 20px;
	}



	.update-btn {
		white-space: initial;
	}
}
</style>
<?php get_template_part( 'framework/design/account/parts/document-management'); ?>

<script type="text/javascript">

</script>