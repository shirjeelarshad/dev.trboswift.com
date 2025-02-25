<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN, $CORE_AUCTION;


$user_id = get_current_user_id(); // Get the current user ID
	$user_email = $userdata->user_email; 
	$user_fname = get_user_meta($user_id, 'first_name', true);
	$user_lname = get_user_meta($user_id, 'last_name', true);

    $escrow_form_id = 330325;
    $credit_form_id = 330325;



$document_card = get_user_meta($user_id, 'document_proof_file', true);




  



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

		Dashboard: {
			content: '#list-item-Dashboard',
			menuItem: '.list-item-Dashboard',
		},
		Orders: {
			content: '#list-item-Orders',
			menuItem: '.list-item-Orders',
		},
		PendingPickUp: {
			content: '#list-item-PendingPickUp',
			menuItem: '.list-item-PendingPickUp',
		},
		History: {
			content: '#list-item-History',
			menuItem: '.list-item-History',
		},
		help: {
			content: '#list-item-help',
			menuItem: '.list-item-help',
		},
		invoices: {
			content: '#list-item-invoices',
			menuItem: '.list-item-invoices',
		},
		Billing: {
			content: '#list-item-Billing',
			menuItem: '.list-item-Billing',
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



<section class="col-12 d-md-flex m-0 py-3 px-2 position-relative position-md-fixed"
	style="background-image:url('<?php echo home_url(); ?>/wp-content/uploads/2024/10/bg-map.png'); background-size:cover; height: calc(100vh - 60px);">
	<div class="px-0 mb-md-3">
		<ul class="bg-white list-unstyled py-3 my-3 radiusx overflow-auto" id="account_jumplinks"
			style="height:100%; line-height:30px;">
			<li class="list-item-Dashboard account-details-tab-bg px-3 py-2 mb-3"> <a
					onclick="showDealerPage('Dashboard');" href="javascript:void(0);"
					class="text-decoration-none text-white" data-toggle="tab" role="tab">
					<?php echo __("Dashboard","premiumpress") ?> </a> </li>


			<li class="list-item-Orders px-3 py-2 mb-3"> <a onclick="showDealerPage('Orders');"
					href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab" role="tab">
					<?php echo __("Orders","premiumpress") ?> </a> </li>


			<li class="list-item-PendingPickUp px-3 py-2 mb-3"> <a onclick="showDealerPage('PendingPickUp');"
					href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab" role="tab">
					<?php echo __("Pending Pick Up","premiumpress") ?> </a> </li>

			<li class="list-item-History px-3 py-2 mb-3"> <a onclick="showDealerPage('History');"
					href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab" role="tab">
					<?php echo __("History","premiumpress") ?> </a> </li>

			<li class="list-item-invoices px-3 py-2 mb-3"> <a onclick="showDealerPage('invoices');"
					href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab"
					role="tab"><?php echo __("Invoices","premiumpress") ?> </a> </li>

			<li class="list-item-Billing px-3 py-2 mb-3"> <a onclick="showDealerPage('Billing');"
					href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab"
					role="tab"><?php echo __("Billing","premiumpress") ?> </a> </li>

			<li class="list-item-help px-3 py-2 mb-3"> <a onclick="showDealerPage('help');" href="javascript:void(0);"
					class="text-decoration-none text-dark" data-toggle="tab" role="tab"> <i
						class="fal fa-heart mr-2"></i> <?php echo __("Help","premiumpress") ?> </a> </li>
						

			<li class="list-item px-3 py-2"> <a href="<?php echo wp_logout_url(home_url()); ?>"
					class="text-decoration-none text-dark"> <i
						class="fal fa-sign-out-alt text-danger mr-2"></i> <?php echo __("Logout","premiumpress") ?> </a>
			</li>

		</ul>

	</div>


	<div class="col-md px-0 px-md-2">


		<div id="list-item-Dashboard" class="col-12 p-0 main-page-overflow-auto">

			<div class="my-3 py-3 d-flex flex-column flex-md-row col-12 px-0 bg-white radiusx">
				<div id="recentOrderAnalytics" class="col-12 col-md-4 d-flex mb-2 mb-md-0">
					<div class="bg-light radiusx p-2" style="width:100%">
						<div class="col-12 d-flex align-items-center border-bottom pb-2 px-0">
							<div class="col-6 p-0">
								<strong>Recent Order</strong>
							</div>
							<div class="col-6 text-right d-flex justify-content-end p-0">
								<div class="input-group flex-nowrap radiusx font-12 align-items-center bg-white"
									style="height:40px; max-width:120px">
									<div class="input-group-prepend bg-white p-2">
										<i class="far fa-calendar-alt font-16"></i>
									</div>
									<select id="monthSelectorOrders"
										class="form-control form-control-sm radiusx previousMonthOrders"
										placeholder="Month">

									</select>
								</div>
							</div>
						</div>

						<div class="col-12 row mt-2">
							<div class="col-5 p-0" id="lastThreeMonthOrders">
								<div class="d-flex align-items-center">
									<div class="bg-secondary p-1 mr-1 mb-2 d-flex justify-content-center align-items-center"
										style="width:40px; height:40px; border-radius:9px;">
										<img width="20" height="20"
											src="<?php echo home_url() ?>/wp-content/uploads/2024/12/Vector.svg" />
									</div>
									<div>
										<div class="font-10">New Orders</div>
										<div class="numberOfOrders font-12">12</div>
									</div>
								</div>
								<div class="d-flex align-items-center">
									<div class="bg-secondary p-1 mr-1 mb-2 d-flex justify-content-center align-items-center"
										style="width:40px; height:40px; border-radius:9px;">
										<img width="20" height="20"
											src="<?php echo home_url() ?>/wp-content/uploads/2024/12/Vector.svg" />
									</div>
									<div>
										<div class="font-10">Month Name Orders</div>
										<div class="numberOfOrders font-12">12</div>
									</div>
								</div>
								<div class="d-flex align-items-center">
									<div class="bg-secondary p-1 mr-1 mb-2 d-flex justify-content-center align-items-center"
										style="width:40px; height:40px; border-radius:9px;">
										<img width="20" height="20"
											src="<?php echo home_url() ?>/wp-content/uploads/2024/12/Vector.svg" />
									</div>
									<div>
										<div class="font-10">New Orders</div>
										<div class="numberOfOrders font-12">12</div>
									</div>
								</div>
								<div>
									<div class="font-10">In comparison to Last month</div>
									<h3 class="text-success"><i class="fal fa-long-arrow-up"></i>41%</h3>
								</div>
							</div>
							<div class="col-7 p-0">
								<canvas id="smoothLineChart" width="100%" height="209"></canvas>

							</div>
						</div>
					</div>
				</div>

				<div id="recentOrderAnalytics" class="col-12 col-md-4 d-flex mb-2 mb-md-0">
					<div class="bg-light radiusx p-2" style="width:100%">
						<div class="col-12 d-flex align-items-center border-bottom pb-2 px-0">
							<div class="col-6 p-0">
								<strong>Compleated Order</strong>
							</div>
							<div class="col-6 text-right d-flex justify-content-end p-0">
								<div class="input-group flex-nowrap radiusx font-12 align-items-center bg-white"
									style="height:40px; max-width:120px">
									<div class="input-group-prepend bg-white p-2">
										<i class="far fa-calendar-alt font-16"></i>
									</div>
									<select id="monthSelectorCompleted"
										class="form-control form-control-sm radiusx previousMonthCompleateOrders"
										placeholder="Month">

									</select>
								</div>
							</div>
						</div>

						<div class="col-12 row mt-2">
							<div class="col-5 p-0 d-flex flex-column justify-content-between"
								id="completedOrdersResult">
								<div class="d-flex align-items-center">
									<div class="bg-secondary p-1 mr-1 mb-2 d-flex justify-content-center align-items-center"
										style="width:40px; height:40px; border-radius:9px;">
										<img width="20" height="20"
											src="<?php echo home_url() ?>/wp-content/uploads/2024/12/Vector.svg" />
									</div>
									<div>
										<div class="font-10">Total Orders</div>
										<div class="numberOfOrders font-12">12</div>
									</div>
								</div>




								<div>
									<div class="font-10">In comparison to Last month</div>
									<h3 class="text-success"><i class="fal fa-long-arrow-up"></i>41%</h3>
								</div>
							</div>
							<div class="col-7 p-0">
								<canvas id="smoothLineCompleateOrderChart" width="100%" height="209"></canvas>

							</div>
						</div>
					</div>
				</div>
				<div id="recentOrderAnalytics" class="col-12 col-md-4 d-flex">
					<div class="bg-light radiusx p-2" style="width:100%">
						<div class="col-12 d-flex align-items-center border-bottom pb-2 px-0">
							<div class="col-6 p-0">
								<strong>Heat Map</strong>
							</div>
							<div class="col-6 text-right d-flex justify-content-end p-0">
								<button class="btn text-primary p-0 font-14">View All</button>
							</div>
						</div>
						<div class="col-12 d-flex justify-content-between">
							<div class="col-7 d-flex align-items-center justify-content-center">
								<canvas id="doughnutOrdersInCities" width="209" height="209"></canvas>

							</div>
							<div class="col-5">

								<div id="cityOrderCountsTable" class="table-container">
									<!-- City order counts will be dynamically inserted here -->
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

			<div class="bg-white" style="border-radius:15px !important;">
				<div class="col-12 py-3 d-flex align-items-center overflow-auto bg-secondary font-12"
					style="border-radius:15px 15px 0 0">
					<div class="col-3 col-md-2 d-flex align-items-center text-center">
						<button type="button" class="btn p-0 focus-none font-14 text-white text-primary fetchTransports"
							data-name="New Transport Order">New Transport
							Order</button>
					</div>
					<div class="col d-flex align-items-center text-center">
						<button type="button" class="btn p-0 focus-none font-14 text-white fetchTransports"
							data-name="Unassigned">Unassigned</button>
					</div>
					<div class="col d-flex align-items-center text-center">
						<button type="button" class="btn p-0 focus-none font-14 text-white fetchTransports"
							data-name="Awaiting Pickup">Awaiting
							Pickup</button>
					</div>
					<div class="col d-flex align-items-center text-center">
						<button type="button" class="btn p-0 focus-none font-14 text-white fetchTransports"
							data-name="On Route">On
							Route</button>
					</div>
					<div class="col d-flex align-items-center text-center">
						<button type="button" class="btn p-0 focus-none font-14 text-white fetchTransports"
							data-name="Delivered">Delivered</button>
					</div>
					<div class="col d-flex align-items-center text-center">
						<button type="button" class="btn p-0 focus-none font-14 text-white fetchTransports"
							data-name="Cancelled">Cancelled</button>
					</div>
					<div class="col d-flex align-items-center text-center">
						<button type="button" class="btn p-0 focus-none font-14 text-white fetchTransports"
							data-name="Rescheduled">Rescheduled</button>
					</div>
					<div class="col d-flex align-items-center text-center">
						<button type="button" class="btn p-0 focus-none font-14 text-white fetchTransports"
							data-name="View All">View
							All</button>
					</div>

				</div>


				<div id="mainPendingDealsSection" class="p-2"></div>
			</div>



			<div id="filterBasedTransport" class="my-3 py-3 d-flex flex-column flex-md-row col-12 px-0">
				<div id="mainPendingTransportsSection" class="col-12 col-md-6 px-0  mb-2 mb-md-0 pr-md-2"></div>
				<div id="mainOnRouteTransportsSection" class="col-12 col-md-6 px-0"></div>
			</div>



		</div>

		<div id="list-item-Orders" style="display: none;" class="col-12">



		</div>
		<div id="list-item-PendingPickUp" style="display: none;" class="col-12">

		</div>
		<div id="list-item-History" style="display: none;" class="col-12">

		</div>
		<div id="list-item-invoices" style="display: none;" class="col-12">

		</div>
		<div id="list-item-Billing" style="display: none;" class="col-12">

		</div>
		<div id="list-item-help" style="display: none;" class="col-12">

		</div>

		<div id="deal-overview" style="display: none;" class="col-12 p-0">

			<div class="py-3 d-flex flex-column flex-md-row col-12 px-0 radiusx">
				<div class="col-12 col-md-4 px-2">
					<div class="bg-white radiusx p-2 overflow-md-auto" >
						<div class="col-12 d-flex align-items-center px-0">
							<div class="col-4 p-0">
								<strong>Vehicles</strong>
							</div>
							<div class="col-8 text-right d-flex justify-content-end p-0">
								<div class="input-group flex-nowrap radiusx font-12 align-items-center bg-light"
									style="height:40px;">
									<div class="input-group-prepend bg-light p-2">
										<i class="fas fa-search font-16"></i>
									</div>
									<input id="searchTransport"
										class="searchTransport form-control form-control-sm radiusx bg-light"
										placeholder="Search by Shipment ID, No." />
								</div>
							</div>
						</div>

						<div class="my-2">
							<div class="col-12 radiusx bg-light" id="transportDetails">


							</div>

						</div>

						<div id="myAwaitingTransports" class="col-12 p-0"></div>




					</div>
				</div>

				<div id="" class="col-12 col-md-4 px-2 mt-2 mt-md-0">
					<div class="bg-white radiusx">
						<div class="col-12 d-flex align-items-center border-bottom p-2">
							<div class="col-8 p-0">
								<div class="font-12 text-muted">Shipment Id</div>
								<strong class="shipmentId">#id567</strong>
							</div>
							<div class="col-4 text-right d-flex justify-content-end align-items-center p-0">

								<button class="btn btn-primary rounded-pill font-12">Inspection Report</button>

							</div>
						</div>

						<div class="position-relative">
							<div class="ppt_map_location" style="width: 100%; height: 80vh; position:fixed;"></div>

							<div class="transportDetailsInMap p-2 bg-white radiusx"
								style="position:absolute; left:10px; right:10px; bottom: -15px;"></div>
						</div>


					</div>
				</div>
				<div id="" class="col-12 col-md-4 px-2 mt-2 mt-md-0">
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


						<div class="deloveryStatusReport mb-3 wrapper"></div>
					</div>

						<div class="py-4 font-12">

							<div class="form-group">
								<label for="PickupDateTime" class="info-label">Pick up date and time
								</label>
								<input type="datetime-local" id="PickupDateTime"
									style="border:none !important; border-radius:8px; background:#F8F9FA"
									class="form-control" placeholder="Pick up date and time" />
							</div>
							<div class="form-group">
								<label for="DropoffDateTime" class="info-label">Drop off time
								</label>
								<input type="datetime-local" id="DropoffDateTime"
									style="border:none !important; border-radius:8px; background:#F8F9FA"
									class="form-control" placeholder="Drop off time" />
							</div>

							<div class="form-group">
								<label for="DriverContactNumber" class="info-label">Driver contact number
								</label>
								<input type="text" id="DriverContactNumber"
									style="border:none !important; border-radius:8px; background:#F8F9FA"
									class="form-control" placeholder="Driver contact number" />
							</div>

							<div class="form-group">
								<label for="towingPartners" class="info-label">Select Towing Partner
								</label>
								<select type="text" id="towingPartners"
									style="border:none !important; border-radius:8px; background:#F8F9FA"
									class="form-control" value="">
									<option value="Freight Towing">
										

										Freight Towing
									</option>
									<option value="Trbo Swift Transport">
										

										Trbo Swift Transport
									</option>
									<option value="Local Assigned Company">
										

										Local Assigned Company
									</option>
								</select>
							</div>

							<div class="form-group">
								<label for="transportTypes" class="info-label">Transport Types
								</label>
								<select type="text" id="transportTypes"
									style="border:none !important; border-radius:8px; background:#F8F9FA"
									class="form-control" value="">
									<option>Tow Truck</option>
									<option>Flat Bed</option>
									<option>Enclosed Trailer</option>
								</select>
							</div>

							<div class="form-group">
								<label for="Insurance" class="info-label">Insurance
								</label>
								<select type="text" id="Insurance"
									style="border:none !important; border-radius:8px; background:#F8F9FA"
									class="form-control" value="">
									<option>Insured</option>
									<option>Not Insured</option>
								</select>
							</div>

							<button type="button" class="btn btn-primary rounded-pill font-12 px-3 py-1"
								id="submitTransportDetails">Save</button>





						</div>


						<div id="clientNoteSection">
							<div class="my-2">
								<div class="font-12 d-flex justify-content-between align-items-center">

									<div class="d-flex align-items-center" style="gap:10px"><strong
											class="font-12">Choose Priority Level</strong>

									</div>


									<div class="dropdown">
										<button class="btn btn-white dropdown-toggle px-3" type="button"
											data-toggle="dropdown" aria-expanded="false">
											<i class="fa-solid fa-ellipsis-vertical"></i>
										</button>


										<div class="dropdown-menu z-index">
											<a class="dropdown-item notePriorityLevel" data-priority-level="High"
												href="javascript:void(0)">High</a>
											<a class="dropdown-item notePriorityLevel" data-priority-level="Low"
												href="javascript:void(0)">Low</a>
											<a class="dropdown-item notePriorityLevel" data-priority-level="Medium"
												href="javascript:void(0)">Medium</a>

										</div>
									</div>

								</div>
							</div>
							<div class="mb-3">

								<textarea style="border:none !important; border-radius:8px; background:#F8F9FA"
									class="form-control bg-light p-2" id="addClientNoteTextarea"
									placeholder="Enter a message ( Max 500 chars )" rows="3"
									style="min-height: 150px; border-radius:10px;"></textarea>
							</div>
							<div class="mt-3 d-flex">

								<button class="btn btn-white rounded-pill text-primary  font-12 px-3 py-1"
									id="addClientNote">Add
									note</button>
							</div>
						</div>


						<div class="mt-2 py-3 font-10 d-none">

							<div class=" d-flex justify-content-between">
								<div class="font-12"><strong>Add New Towing Partner</strong></div>
								<div class="text-right"><a href="javascript:void(0)"
										class="btn btn-primary rounded-pill font-12 px-3 py-1"
										style="max-height: 30px; min-width: 60px; align-items: center; justify-content: center; display: flex;">+
										Add</a>
								</div>
							</div>
							<div class="my-2">
								<div class="font-12 d-flex justify-content-between align-items-center">

									<div class="d-flex align-items-center" style="gap:5px"><small
											class="font-10">Assign Tow Company</small>
										<div class="dropdown">
											<button class="btn btn-white px-3 dropdown-toggle" type="button"
												data-toggle="dropdown" aria-expanded="false">
												<i class="fa-solid fa-ellipsis-vertical"></i>
											</button>


											<div class="dropdown-menu z-index">
												<a class="dropdown-item assign" href="javascript:void(0)"
													data-assign-name="Freight Towing">
													<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
														style="width:14px;" />

													Freight Towing</a>
												<a class="dropdown-item assign" href="javascript:void(0)"
													data-assign-name="Trbo Swift Transport">
													<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
														style="width:14px;" />

													Trbo Swift Transport</a>
												<a class="dropdown-item assign" href="javascript:void(0)"
													data-assign-name="Local Assigned Company">
													<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
														style="width:14px;" />

													Local Assigned Company</a>
												<a class="dropdown-item assign" href="javascript:void(0)"
													data-assign-name="Add new Company">
													<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/hand.svg"
														style="width:14px;" />

													Add new Company</a>

											</div>
										</div>
									</div>


									<div class="dropdown">
										<button class="btn btn-white dropdown-toggle px-3 d-flex align-items-center" type="button"
											data-toggle="dropdown" aria-expanded="false">
											<small class="font-10">Choose Truck Type</small> <i class="fa-solid fa-ellipsis-vertical ml-2"></i>
										</button>


										<div class="dropdown-menu z-index">
											<a class="dropdown-item assign" href="javascript:void(0)"
												data-assign-name="Flat Bet">
												<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
													style="width:14px;" />

												Flat Bet</a>
											<a class="dropdown-item assign" href="javascript:void(0)"
												data-assign-name="Regular Truck">
												<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
													style="width:14px;" />

												Regular Truck</a>
											<a class="dropdown-item assign" href="javascript:void(0)"
												data-assign-name="Trailer">
												<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
													style="width:14px;" />

												Trailer</a>
											<a class="dropdown-item assign" href="javascript:void(0)"
												data-assign-name="Enclosed">
												<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/hand.svg"
													style="width:14px;" />

												Enclosed</a>

										</div>
									</div>

								</div>
							</div>


							<div style="background:#F8F9FA; border-radius:10px; padding:10px;">
								<div class="row m-0">
									<div class="col-md-3 p-0 d-flex justify-content-center align-items-center">
										<div class="custom-file-drop  position-relative" id="companyLogoDropArea">
											<div id="companyLogoPreviewContainer" style="border-radius:100%;"
												class="d-flex justify-content-center align-items-center">
												<img width="100%" height="100%"
													src="<?php echo home_url(); ?>/wp-content/uploads/2024/12/image.svg"
													alt="">
											</div>

											<input type="file" name="" id="companyLogoFileInput" class="d-none">
											<button type="submit"
												class="upload-company-logo-btn btn btn-white rounded-pill p-0 position-absolute"
												style="top: 8px;left: 15px;">+</button>

										</div>

									</div>
									<div class="form-group col-md-9 p-0">
										<label for="company-name-input" class="info-label">Company name
										</label>
										<input type="text" id="company-name-input"
											style="border:none !important; border-radius:8px; background:#fff"
											class="form-control" placeholder="Enter company name" />
									</div>
								</div>


								<div class="form-group">
									<label for="turbobid-certified-input" class="info-label">Trbo Swift Certified
									</label>
									<select type="text" id="turbobid-certified-input"
										style="border:none !important; border-radius:8px; background:#fff"
										class="form-control" value="">
										<option value="yes">Yes</option>
										<option value="no">No</option>
									</select>
								</div>
								<div class="form-group">
									<label for="contact-phone-input" class="info-label">Contact number
									</label>
									<input type="text" id="contact-phone-input"
										style="border:none !important; border-radius:8px; background:#fff"
										class="form-control" placeholder="Enter Contact number" />
								</div>
								<div class="form-group">
									<label for="number-of-trucks-input" class="info-label">Number of Trucks
									</label>
									<input type="text" id="number-of-trucks-input"
										style="border:none !important; border-radius:8px; background:#fff"
										class="form-control" placeholder="Enter Number of Trucks" />
								</div>
								<div class="form-group">
									<label for="number-of-drivers-input" class="info-label">Number of Drivers
									</label>
									<input type="text" id="number-of-drivers-input"
										style="border:none !important; border-radius:8px; background:#fff"
										class="form-control" placeholder="Enter Number of Drivers" />
								</div>

								<button class="btn btn-primary rounded-pill font-12 px-3 py-1"
									id="submitTowPartnerDetails">Save</button>

							</div>



						</div>


					</div>
				</div>

			</div>





		</div>


	</div>
</section>


<input type="hidden" id="escrow_entry_id" value="123">
<input type="hidden" id="escrow_entry_seller_email" value="randoded.it@gmail.com">
<input type="hidden" id="escrow_entry_seller_phone" value="+11">
<input type="hidden" id="escrow_entry_buyer_email" value="randoded.it@gmail.com">
<input type="hidden" id="escrow_entry_buyer_phone" value="+11">
<input type="hidden" id="escrow_entry_driver_email" value="randoded.it@gmail.com">
<input type="hidden" id="escrow_entry_driver_phone" value="+11">
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



jQuery(document).on('click', '.dropdown-menu a.dropdown-item.status', function(e) {
	e.preventDefault();

	var row = jQuery(this);
	var entryId = row.data('entry-id');

	var statusName = row.data('status-name');
	// var sellerEmail = row.data('seller-email');
	// var buyerEmail = row.data('buyer-email');
	// var vehicleVin = row.data('vehicle-vin');
	// var vehicleName = row.data('vehicle-name');



	var status = {
		transportId: entryId,
		transportStatus: statusName,
		status_name: statusName,
		status_submitter: '<?php echo $user_fname . ' ' . $user_lname ; ?>',
		status_submitter_email: '<?php echo $user_email; ?>',
		// sellerEmail: sellerEmail,
		// buyerEmail: buyerEmail,
		// vehicleVin: vehicleVin,
		// vehicleName: vehicleName,
	}


	sessionStorage.setItem('@transport-accept-info', JSON.stringify(status));


	// Open the modal
	jQuery('.documentManagementBody').removeClass('d-none').addClass('d-flex');
	jQuery('.documentManagementBody #documentManageTitle').html('Upload Document');

	jQuery('.documentManagementBody .sendDocumentSection').removeClass('d-block').addClass('d-none');
	jQuery('.documentManagementBody .documentViewSection').removeClass('d-none').addClass('d-block');

	// jQuery('.documentManagementBody .documentViewSection').html(content);

	var content = `
    <div class="d-flex justify-content-center align-items-center flex-column"> <h4>Are you sure, Want to ${statusName}</h4>
<div>
                <button class="dealStatusChangeBtn btn btn-primary rounded-pill px-3 mr-2" id="financing-step-back">${statusName}</button>
                <button class="btn btn-secondary rounded-pill px-3" onclick="jQuery('.documentManagementBody').removeClass('d-flex').addClass('d-none')" >Cancel</button>
</div>

    </div>
    `;



	if (statusName == 'Awaiting Pickup') {
		jQuery('.documentManagementBody #documentManageTitle').hide();
		jQuery('.documentManagementBody .documentManagementContainer').removeClass('p-3 customModalWidthHalf')
			.addClass(
				'p-0 border-0 customModalWidthFull');

		dealPaperWorkDetails(entryId);
	} else {

		jQuery('.documentManagementBody .documentManagementContainer').removeClass('p-0 customModalWidthFull')
			.addClass(
				'p-3 border-0 customModalWidthHalf');
		jQuery('.documentManagementBody #documentManageTitle').show().html('Change Status');
		jQuery('.documentManagementBody .documentViewSection').html(content);
	}






});




jQuery(document).on('click', '.dealStatusChangeBtn', function() {

	var entry = JSON.parse(sessionStorage.getItem('@transport-accept-info'));

	// console.log(entry['entry_id']);

	if (entry.transportStatus === 'New Transport Order') {
		dealPaperWorkDetails(entry.transportId);
	} else {
		// function
		submitTransportStatus();
	}

});








async function dealPaperWorkDetails(dealId) {
	jQuery('#loadingSpinner').show();

	let meta = null;

	console.log("dealId: ", dealId);
	const apiUrl = `<?php echo home_url(); ?>/rancoded-json/api/v1/turbo-transport/${dealId}`;

	await jQuery.getJSON(apiUrl, function(res) {
		console.log("Transport data: ", res);
		if (res) {
			meta = res.meta;
		} else {
			console.log(res.error.post_not_found);
		}

	}).fail(function() {
		showDealerPage('Dashboard');
		alert('Error fetch transport data from the API. Please try again.');
	});
	// console.log(meta); 
	// console.log(meta['text-12']);

	var approvalFields = `
    <div class="bg-secondary px-1 px-md-4 py-4 text-center text-white"><h5>Transport Accepting</h5></div>

   <div class="transportAcceptForm px-1 px-md-3 py-3 bg-white">

    <div class="mb-3 px-5">
        <div class="col-12 bg-light px-5 radiusx">

            <h5 class="text-primary text-center">Fee : ${formatCalCadPrice(meta.transportFee || 0)}</h5>
            <h6 class="text-dark text-center">Transport Date : ${formatDateToISO(meta.transportDate)}</h6>

             <div class="row m-0 small">
                                            <div class="col-md-6">
                                                <div class="px-1 px-md-3" style="border-radius:22px;">

                                                    <div class="list-group list-group-flush">
                                                        <div>
                                                            <div class="row align-items-center justify-content-between">
                                                                <span style="font-weight:600;">Buyer Name</span>
                                                                <span class="lenderName">${meta.transportSender[0].name || ''}</span>
                                                            </div>
                                                            <div class="row align-items-center justify-content-between">
                                                                <span style="font-weight:600;">Phone</span>
                                                                <span class="interestRate">${meta.transportSender[0].phone || ''}</span>
                                                            </div>
                                                            <div class="row align-items-center justify-content-between">
                                                                <span style="font-weight:600;">Email</span>
                                                                <span class="paymentWithTerm">${meta.transportSender[0].email || ''}</span>
                                                            </div>
                                                            <div class="row align-items-center justify-content-between">
                                                                <span style="font-weight:600;">Pickup</span>
                                                                <span class="approvedFinanceAmount">${meta.transportPickup || ''}</span>
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
                                                                <span style="font-weight:600;">Buyer Name</span>
                                                                <span class="lenderName">${meta.transportReceiver[0].name || ''}</span>
                                                            </div>
                                                            <div class="row align-items-center justify-content-between">
                                                                <span style="font-weight:600;">Phone</span>
                                                                <span class="interestRate">${meta.transportReceiver[0].phone || ''}</span>
                                                            </div>
                                                            <div class="row align-items-center justify-content-between">
                                                                <span style="font-weight:600;">Email</span>
                                                                <span class="paymentWithTerm">${meta.transportReceiver[0].email || ''}</span>
                                                            </div>
                                                            <div class="row align-items-center justify-content-between">
                                                                <span style="font-weight:600;">Destination</span>
                                                                <span class="approvedFinanceAmount">${meta.transportDestination || ''}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


        </div>
</div>

<div class="form-row my-2 px-5">
<div class="form-group col-md-6">
                                <label for="pickupDate" class="info-label">Pickup Time</label>
                                <input type="datetime-local" id="transportPickupTime" class="form-control" value="">
</div>
<div class="form-group col-md-6">
                                <label for="deliveryDate" class="info-label">Delivery Time</label>
                                <input type="datetime-local" id="transportDeliveryTime" class="form-control" value="" >
</div>
</div>
<div class="form-row my-2 px-5">
<div class="form-group col-md-6">
                                <label for="driverName" class="info-label">Driver Name</label>
                                <input type="text" id="driverName" class="form-control" value="">
</div>
<div class="form-group col-md-6">
                                <label for="driverPhone" class="info-label">Driver Prone</label>
                                <input type="tel" id="driverPhone" class="form-control" value="" >
</div>

</div>

<div class="form-row my-2 px-5">
<div class="form-group col-md-6">
                                <label for="driverEmail" class="info-label">Driver email</label>
                                <input type="text" id="driverEmail" class="form-control" value="">
</div>
<div class="form-group col-md-6">
                                <label for="driverCompany" class="info-label">Driver company</label>
                                <input type="text" id="driverCompany" class="form-control" value="" >
</div>

</div>

<div class="form-row my-2 px-5">

<div class="form-group col-md-12">
                                <label for="driverCurrentAddress" class="info-label">Your Address</label>
                                <input type="text" id="driverCurrentAddress" class="form-control" value="" >
</div>

</div>


<div class="transport_accept_location" style="width: 100%; height: 150px;"></div>


                        <div class="form-group col-12 col-md-12 d-flex justify-content-center align-items-center mt-2">
                                <button  type="submit" class="submitApprovalTerms btn btn-secondary rounded-pill px-3">Accepted Now</button>
                        </div>
    </div>

    
    `;

	jQuery(".documentManagementBody .documentViewSection").html(approvalFields);

	// initializeLocationMap(meta.transportPickupLocation, meta.transportDestinationLocation, null, true, meta
	// 	.transportStatus)
	
	initializeCustomLocationMap({
				pickupLocation: meta.transportPickupLocation,
				destinationLocation: meta.transportDestinationLocation,
				currentGoogleLocation: null,
				currentAddressCanChange: true,
				transportStatus: meta.transportStatus,
				mapContainer: '.transport_accept_location'
	});

	jQuery('#loadingSpinner').hide();
}





jQuery(document).on('click', '.submitApprovalTerms', function() {
	jQuery('#loadingSpinner').show();


	var transport = JSON.parse(sessionStorage.getItem('@transport-accept-info'));

	console.log("TransportXXID:", transport.transportId);

	var approvalFields = jQuery(this).closest('.transportAcceptForm');

	var transportPickupTime = approvalFields.find('#transportPickupTime').val();
	var transportDeliveryTime = approvalFields.find('#transportDeliveryTime').val();
	var transportDriverName = approvalFields.find('#driverName').val();
	var transportDriverPhone = approvalFields.find('#driverPhone').val();
	var transportDriverEmail = approvalFields.find('#driverEmail').val();
	var transportDriverCompany = approvalFields.find('#driverCompany').val();
	var driverCurrentAddress = approvalFields.find('#driverCurrentAddress').val();

	if (!transportPickupTime || !transportDeliveryTime || !transportDriverName || !transportDriverPhone || !
		transportDriverEmail || !driverCurrentAddress) {
		alert("Please fill out the form properly");
		jQuery('#loadingSpinner').hide();
		return;
	}

	var formData = new FormData();
	formData.append('form_name', 'Approval Transport');
	formData.append('form_title', 'Approval Transport');

	transportPickupTime && formData.append('transportPickupTime', transportPickupTime);
	transportDeliveryTime && formData.append('transportDeliveryTime', transportDeliveryTime);
	transportDriverName && formData.append('name', transportDriverName);
	transportDriverPhone && formData.append('phone', transportDriverPhone);
	transportDriverEmail && formData.append('email', transportDriverEmail);
	transportDriverCompany && formData.append('company', transportDriverCompany);
	driverCurrentAddress && formData.append('currentAddress', driverCurrentAddress);
	formData.append('driverStatus', 'Accepted');


	for (var pair of formData.entries()) {
		console.log(pair[0] + ': ' + pair[1]);
	}

	const apiUrl = `<?php echo home_url(); ?>/rancoded-json/api/v1/turbo-transport-driver/${transport.transportId}`;

	// Send AJAX POST request
	jQuery.ajax({
		url: apiUrl,
		type: 'POST',
		data: formData,
		processData: false,
		contentType: false,
		success: function(res) {
			console.log(res);
			console.log('Transport status updated successfully!');

			submitTransportStatus();
		},
		error: function(err) {
			console.error('Error:', err);
			alert('Error connecting to the API. Please try again later.');
			jQuery('#loadingSpinner').hide(); // Hide spinner
		}
	});


});





function submitTransportStatus() {
	// Retrieve transport data from session storage
	const transport = JSON.parse(sessionStorage.getItem('@transport-accept-info'));

	// Ensure transport data is available
	if (!transport || !transport.transportId) {
		// alert('Transport information is missing. Please try again.');
		showGlobalAlert('error', `<h3>Transport information is missing. Please try again.</h3>`);
		return;
	}

	// Construct the API URL
	const apiUrl = `<?php echo home_url(); ?>/rancoded-json/api/v1/turbo-transport-status/${transport.transportId}`;

	// Prepare data payload
	const payload = {
		transportStatus: transport.transportStatus || '',
		status_submitter: transport.status_submitter || 'Anonymous',
	};

	// Show a loading spinner (optional)
	jQuery('#loadingSpinner').show();

	// Send AJAX POST request
	jQuery.ajax({
		url: apiUrl,
		type: 'POST',
		contentType: 'application/json', // Ensure JSON payload is sent
		data: JSON.stringify(payload),
		success: function(res) {
			console.log('Response:', res);
			showGlobalAlert('', `<h3>Your request has been successfully completed!</h3>`);
			getTransportData('transportStatus', 'New Transport Order');
			handleGetTransport(transport.transportId);
		},
		error: function(err) {
			console.error('Error:', err);
			alert('Error connecting to the API. Please try again later.');
		},
		complete: function() {
			jQuery('#loadingSpinner').hide(); // Hide spinner
		},
	});
}


function submitDriverCurrentLocation(address, location = null) {

	var transportId = sessionStorage.getItem('@transport-id');

	// Ensure transport data is available
	if (!address) {
		console.error('Driverr address is missing. Please try again.');
		return;
	}

	// Construct the API URL
	const apiUrl = `<?php echo home_url(); ?>/rancoded-json/api/v1/turbo-driver-current-address/${transportId}`;

	// Create a FormData object
	const formData = new FormData();
	formData.append('currentAddress', address); // Add a default empty string for undefined values
	formData.append('transportCurrentGooglelocation', location);
	// Show a loading spinner (optional, if applicable)
	jQuery('#loadingSpinner').show();

	// Send AJAX POST request
	jQuery.ajax({
		url: apiUrl,
		type: 'POST',
		data: formData,
		processData: false, // Prevent jQuery from processing FormData
		contentType: false, // Use the FormData default content type
		success: function(res) {
			console.log(res);
			alert('Transport accepted successfully!');
			jQuery('#loadingSpinner').hide(); // Hide spinner
		},
		error: function(err) {
			console.error('Error:', err);
			alert('Error connecting to the API. Please try again later.');
			jQuery('#loadingSpinner').hide(); // Hide spinner
		}
	});
}

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
				alert('Deal deleted successfully');
				mainDealsImportFromServer();
			} else {
				alert('Error wehile delete')
			}
		})
		.fail(function(error) {
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
		alert('Please enter a note');
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
				alert('Successfully added note');
				getDealBasedNotes(); // Refresh notes
			} else {
				alert('Error adding note');
				console.log(res);
			}
		})
		.fail(function(error) {
			jQuery('#loadingSpinner').hide();
			alert('Error adding note');
			console.error("Error:", error);
		});
});

jQuery('#addNewNoteForDeal').on('click', function(e) {
	e.preventDefault();

	// Retrieve TinyMCE content for wp_editor
	var note = tinymce.get('editor_post_content').getContent();
	var taskStatus = jQuery('.note-task-check input[type="radio"]:checked').val();

	if (!note) {
		alert('Please enter a note');
		return;
	}

	if (!taskStatus) {
		alert('Please select a task status');
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
				alert('Successfully added notes');
				getDealBasedNotes(); // Refresh notes
			} else {
				alert('Error adding notes');
				console.log(res);
			}
		})
		.fail(function(error) {
			jQuery('#loadingSpinner').hide();
			alert('Error adding note');
			console.error("Error:", error);
		});
});




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
                        <img src="${note.note_submitter_photo || '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png'}" style="width:30px;" alt="Submitter Avatar" />
                    </div>
                    <div class="col-6 pr-0 text-right d-flex justify-content-end align-items-center">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/sms.svg" style="width:30px;" alt="SMS Icon" />
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

	console.log('deal-entry-link clicked');

	var dealId = jQuery(this).data('entry-id');


	jQuery('.finance-back-main').removeClass('d-none');
			showDealerPage('dealOverviewPage');

	handleGetTransport(dealId);



});

function getDealInfoAfterUpdateData() {
	var transportId = sessionStorage.getItem('@transport-id');
	handleGetTransport(transportId);
}

function handleGetTransport(entry_id) {

	jQuery('#loadingSpinner').show();

	console.log(entry_id);

	const apiUrl = `<?php echo home_url(); ?>/rancoded-json/api/v1/turbo-transport/${entry_id}`;

	return jQuery.getJSON(apiUrl, function(res) {
		console.log("Transport data: ", res);
		if (res) {
			
			showTransportDetails(res);
			jQuery('.shipmentId').text('#' + res.id);
			sessionStorage.setItem('@transport-id', res.id);
			// initializeLocationMap(res.meta.transportPickupLocation, res.meta.transportDestinationLocation, res
			// 	.meta.transportCurrentGooglelocation, false, res.meta.transportStatus)
			
			initializeCustomLocationMap({
				pickupLocation: res.meta.transportPickupLocation,
				destinationLocation: res.meta.transportDestinationLocation,
				currentGoogleLocation: null,
				transportStatus: res.meta.transportStatus,
				mapContainer: '.ppt_map_location'
			});



		} else {
			console.log(res.error.post_not_found);
			// alert(res.post_not_found);
		}

		jQuery('#loadingSpinner').hide();
	}).fail(function() {
		showDealerPage('Dashboard');
		alert('Error fetch transport data from the API. Please try again.');
	});
}


function showTransportDetails(res) {
	let data = '';

	data = `
    <div class="pb-2" style="border-bottom:1px dashed rgba(0, 0, 0, 0.88);  margin-bottom:15px;">
                                <div class="d-flex align-items-center justify-content-between">
                               
                                <div>
                                  <i class="fa-solid fa-truck-fast font-18" style="color:#68A281"></i> #${res.id}
                                  </div>
                                 <div class="d-flex align-items-center dropdown" style="gap:10px">`;



	// Buttons based on finance status
	if (res.meta?.transportStatus && res.meta.transportStatus === "Compleated" || res.meta.transportStatus === "Cancelled" ||
		res.meta.transportStatus === "Delivered" || res.meta.transportStatus ===
		"Awaiting pickup" || res.meta.transportStatus === "On Route") {
		data += ` <button class="turbo-success dropdown-toggle font-8 px-2 py-1 rounded-pill" type="button" data-toggle="dropdown" aria-expanded="false">
		 <i class="fas fa-circle small mr-2"></i> ${res.meta.transportStatus ||  "Pending"} </button>`;

	} else if (res.meta.transportStatus === "Rescheduled") {
		data += `<button class="turbo-warning dropdown-toggle font-8 px-2 py-1 rounded-pill" type="button" data-toggle="dropdown" aria-expanded="false">
                                      <i class="fas fa-circle small mr-2"></i>   ${res.meta.transportStatus ||  "Pending"}
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

                                <div class="col-12 font-12 p-0">

                                <div class="col-12 row mb-2">
                                <div class="col-4 text-muted">Sender</div>
                                <div class="col-6 font-weight-bold text-dark">${res.meta.transportSender[0].name}</div>
                                </div>
                                <div class="col-12 row mb-2">
                                <div class="col-4 text-muted">Receiver</div>
                                <div class="col-6 font-weight-bold text-dark">${res.meta.transportReceiver[0].name}</div>
                                </div>
                                <div class="col-12 row mb-2">
                                <div class="col-4 text-muted">Status</div>
                                <div class="col-6 font-weight-bold text-dark">${res.meta.transportStatus}</div>
                                </div>
                                <div class="col-12 row mb-2">
                                <div class="col-4 text-muted">Referral</div>
                                <div class="col-6 font-weight-bold text-dark">${res.meta.transportReferral}</div>
                                </div>

                                </div>
                                
                            </div>

                            <div class="d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
                                 <div class="d-flex align-items-center">
                                <div class="bg-secondary p-1 mr-1 mb-2 d-flex justify-content-center align-items-center" style="width:40px; height:40px; border-radius:100%;">
                                   <i class="fas fa-check text-white"></i>
                                </div>
                                 <div>
                                    <div class="font-10 text-muted">Driver contact</div>
                                    <div class="font-weight-bold font-12 ">${[...res.meta.transportDriver].reverse()[0]?.phone ? [...res.meta.transportDriver].reverse()[0]?.phone : ''}</div>
                                 </div>
                                 </div>

                                 <div class="d-flex" style="gap:10px;">
                                     <a type="button" class="btn" href="mailto:${res.meta.transportDriver.reverse()[0]?.phone ? res.meta.transportDriver.reverse()[0]?.email : ''}"><i class="fal fa-envelope"></i></i></a>
                                    <a type="button" class="btn" href="tel:${res.meta.transportDriver.reverse()[0]?.phone ? res.meta.transportDriver.reverse()[0]?.phone : '' }"><i class="fal fa-phone-alt"></i></a>
                                 </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
                                 <div class="d-flex align-items-center">
                                <div class="bg-secondary p-1 mr-1 mb-2 d-flex justify-content-center align-items-center" style="width:40px; height:40px; border-radius:100%;">
                                   <i class="fas fa-check text-white"></i>
                                </div>
                                 <div>
                                    <div class="font-10 text-muted">Sender</div>
                                    <div class="font-weight-bold font-12 ">${res.meta.transportSender.reverse()[0].name}</div>
                                    <div class="text-muted font-12 ">${res.meta.transportSender.reverse()[0].company}</div>
                                 </div>
                                 </div>

                                 <div class="d-flex" style="gap:10px;">
                                     <a type="button" class="btn" href="mailto:${res.meta.transportSender.reverse()[0].email}"><i class="fal fa-envelope"></i></i></a>
                                    <a type="button" class="btn" href="tel:${res.meta.transportSender.reverse()[0]?.phone}"><i class="fal fa-phone-alt"></i></a>
                                 </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
                                 <div class="d-flex align-items-center">
                                <div class="bg-secondary p-1 mr-1 mb-2 d-flex justify-content-center align-items-center" style="width:40px; height:40px; border-radius:100%;">
                                   <i class="fas fa-check text-white"></i>
                                </div>
                                 <div>
                                    <div class="font-10 text-muted">Receiver</div>
                                    <div class="font-weight-bold font-12 ">${res.meta.transportReceiver.reverse()[0].name}</div>
                                    <div class="text-muted font-12 ">${res.meta.transportReceiver.reverse()[0].company}</div>
                                 </div>

                                 </div>

                                 <div class="d-flex" style="gap:10px;">
                                     <a type="button" class="btn" href="mailto:${res.meta.transportReceiver.reverse()[0].email}"><i class="fal fa-envelope"></i></i></a>
                                    <a type="button" class="btn" href="tel:${res.meta.transportReceiver.reverse()[0].phone || ''}"><i class="fal fa-phone-alt"></i></a>
                                 </div>
                            </div>
                            
    `;


	jQuery('#transportDetails').html(data);


	let deliveryStatusReport = "";

	console.log("res.meta.transportDeliveryStatus: ", res.meta.transportDeliveryStatus)

	// Start the container for the status report
	deliveryStatusReport += `<div class="transportStepProgress">`;

	// Loop through each status in the transportDeliveryStatus array
	if (res.meta.transportDeliveryStatus != "[]" && res.meta.transportDeliveryStatus?.length > 0 || Array.isArray(res.meta.transportDeliveryStatus)) {
		res.meta.transportDeliveryStatus.forEach(function(item) {
			const statusName = item.status_name || "---"; // Default if status_name is missing
			const statusDate = item.status_submit_date ? formatDate(item.status_submit_date) : '---'; // Parse or fallback to `---`

			deliveryStatusReport += `
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
		deliveryStatusReport += `
        <div class="transportStepProgress-item number d-flex justify-content-center font-12">
            <span>No delivery statuses available</span>
        </div>
    `;
	}

	// Close the container
	deliveryStatusReport += `</div>`;

	// Update the HTML content of the target element
	jQuery(".deloveryStatusReport").html(deliveryStatusReport);


	console.log("Transport Delivery Status:", res.meta.transportDeliveryStatus);


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
	if (hasStatuses(["Driver added"])) {
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



	let transportDetailsInMap;

	transportDetailsInMap = `
                            <div class="d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
                                 <div class="d-flex flex-column align-items-center" style="gap:15px;">

                                        <div class="d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
                                        <div class="d-flex align-items-center mr-2">
                                        <i class="far fa-paper-plane h4"></i>
                                         <div class="ml-2">
                                        <div class="font-weight-bold font-12  text-dark opasity-">${res.meta.transportPickup || ''}</div>
                                        <div class="font-10 text-muted">Driver contact</div>
                                        </div>
                                        </div>
                                        </div>

                                         <div class="d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
                                        <div class="d-flex align-items-center mr-2">
                                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/Group.svg" style="width:30px" />
                                         <div class="ml-2">
                                        <div class="font-weight-bold font-12  text-dark opasity-">${res.meta.transportDestination || ''}</div>
                                        <div class="font-10 text-muted">Destination</div>
                                        </div>
                                        </div>
                                        </div>
                               
                                 </div>

                                 <div class="d-flex justify-content-center align-items-center">
                                     <div class="d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
                                        <div class="d-flex align-items-center mr-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 512 512"><path fill="currentColor" d="M92.6 21c-32 0-64.04 24-64.04 72L92.6 221l64-128c0-48-32-72-64-72m282.3 39c-6.9.29-13.6 1.6-19.2 2.8l3.8 17.6c5.6-1.25 11.4-2.04 16.3-2.4zM92.6 61c17.7 0 32 14.33 32 32c0 17.7-14.3 32-32 32c-17.67 0-32-14.3-32-32c0-17.67 14.33-32 32-32m302.2.2l-3 17.7c4.9 1.03 9.8 2.32 14.1 4.9l8.7-15.8c-6.1-3.25-12.9-6.17-19.8-6.8m-57.5 6.7c-6.1 2.38-12.2 4.51-17.4 6.6L327 91c5.5-2.34 11.3-4.38 16.2-6.1zM431 81.3L417.3 93c3.6 4.12 6.4 9.2 8.6 13.3l16.1-8.1c-3.4-6.55-6.4-11.51-11-16.9m-127.8.9c-6.1 3.11-11.1 5.88-16.5 8.6l8.8 15.8c5.2-3 10.9-5.9 15.5-8.2zm-32.3 17.9c-5.3 3.1-10.5 6.2-15.6 9.6l9.8 15c4.9-3.2 10-6.2 15-9.2zM448.2 118c-5.9 1-11.9 1.7-17.8 2.4c.4 5 .1 10.4-.9 14.6l17.5 4.1c1-7.2 1.9-14.6 1.2-21.1m-208.1 1.7c-5 3.4-9.9 6.9-14.9 10.3l10.4 14.7c4.8-3.5 9.7-6.8 14.6-10.2zm-29.6 21.1c-5 3.6-10.2 7.6-14.5 10.9l10.9 14.3c5.5-4 9.3-7 14.3-10.7zm213 8c-3 4.6-6.5 9.2-10 12.7l13.1 12.5c4.3-5.1 8.9-10.3 12.1-15.5zm-241.8 14.1c-4.9 3.8-9.8 7.7-14.1 11.3l11.4 13.9c4.7-3.9 9.5-7.9 13.9-11.1zM401.1 173c-4.6 3.7-9.4 7.3-13.8 10.3l10.3 14.8c5.3-3.6 10.5-7.5 15-11.1zm-247.4 12.9c-4.7 3.8-9.2 7.8-13.8 11.7l11.7 13.7c4.5-3.9 9-7.8 13.6-11.6zm218.9 7c-5.1 3-10.4 6.1-15.2 8.7l8.6 15.9c5.4-3.3 11.5-6.2 16-9.2zm-246.4 16.6c-4.5 4-8.9 8-13.4 12.1l12.1 13.4c4.4-4 8.9-8 13.3-12zm215.5.4c-5.3 2.6-10.6 5.3-15.9 7.9l7.7 16.2c6.2-3 10.8-5.5 16.4-8.1zm-32 15.4c-5.5 2.5-10.8 4.9-16.4 7.2l7.3 16.5c5.5-2.4 11-4.9 16.5-7.4zM99.6 234c-5.1 4.5-8.65 8-13.3 12.5l12.7 13c4.7-4.5 8.5-8.4 12.9-12.2zm177.3 5.8c-5.5 2.3-11 4.7-16.5 7l7 16.7c5.6-2.3 11.1-4.7 16.6-7.1zm-33.1 14c-5.5 2.4-11 4.8-16.6 7l7 16.7c5.5-2.3 11.1-4.7 16.6-7zm184.8 7.2c-32 0-64 24-64 72l64 128l64-128c0-48-32-72-64-72m-218 6.8c-5.7 2.6-11.7 5-16.6 7.1l7.1 16.6c5.9-2.5 11.5-4.9 16.5-7.1zM177.4 282c-5.4 2.5-11.7 5.3-16.5 7.5l7.4 16.4c5.9-2.6 11.1-5.2 16.3-7.4zm-33 15c-5.6 2.7-11.4 5.5-16.4 8l8.1 16.1c5.4-2.8 11-5.4 15.9-7.8zm284.2 4c17.7 0 32 14.3 32 32s-14.3 32-32 32s-32-14.3-32-32s14.3-32 32-32m-316.8 12.3c-5.3 2.9-10.6 5.9-16 9l9 15.6c5.1-3 10.3-5.8 15.5-8.6zM80.1 332c-5.61 3.2-11.03 7.5-15.7 10.6L75.3 357c4.97-3.6 10.32-7.3 14.6-9.9zm-29.9 22.6c-4.8 4.4-9.53 9.5-13.2 13.8l13.7 11.7c3.85-4.7 7.2-8.2 11.7-12.2zm217.8 1.3l1.6 17.9c5.2-.9 10.4-.3 15.6.5l3.1-17.7c-6.6-1-13.6-1.7-20.3-.7m-37.2 10l6.8 16.7c5.2-2.3 10.6-4.1 16.1-5.8c-1.9-5.7-3.3-11.5-4.8-17.3c-6.3 1.8-12.6 4.2-18.1 6.4m77.5-.9l-10.2 14.8c4.2 3.1 8.3 6.4 11.6 10.5l13.6-11.8c-5.1-5.2-9-10.1-15-13.5m-94.5 9c-5.5 2.8-10.8 6-16.1 9.1l9.1 15.5c5.2-2.8 10.3-6.1 15.4-8.8zM26.01 385c-3.02 6.5-5.47 13.5-6.61 19.7l17.7 3.1c1.08-5.7 2.63-9.8 4.9-14.7c-5.49-2.4-10.73-5.3-15.99-8.1m156.09 7.8c-5.1 3.3-10.1 6.6-15.1 10l10 15c5-3.3 9.9-6.7 14.9-10zm152.7 1.2l-15.1 9.8c3.2 4.8 6.3 9.8 9.2 14.9l15.6-9c-3.5-5.6-6-10.6-9.7-15.7m-182.7 19c-5 3.3-10 6.5-14.9 10l10 15c4.8-3.5 9.9-6.8 15-10.2zm-114.8 9.5c-5.79 1.2-11.63 2.2-17.45 3.3c1.05 7 3.86 13.8 6.4 19.2l16.25-7.8c-2.17-5-4.23-10.2-5.2-14.7m316.1 2.8l-15.6 9c3.1 5.4 6.7 11.2 9.6 15.8l15.1-9.7c-3.4-5.3-6.3-10.3-9.1-15.1m-231 7.5c-5 3.1-9.9 6.1-15.1 9l8.9 15.7c5.3-3.1 10.6-6.2 15.7-9.5zm-71.3 16.3l-12.3 13.2c5.56 5.3 12.42 8.8 19.9 10.4l4-17.5c-4.44-.9-8.59-3.1-11.6-6.1m41 .3c-5.01 2.3-10.21 4.1-15.6 5.2l4.1 17.6c6.42-1.3 12.46-3.7 18.5-6.2zm280.3 4.8l-13.9 11.3c4.3 5.3 9.6 10.4 14.2 14l11.1-14.2c-4.4-3.4-8.2-7.5-11.4-11.1m24.1 17.5l-4.5 17.5c7.9 1.6 13.8 2.1 21.2 1.3l-2.2-17.9c-4.9.8-9.7.3-14.5-.9"/></svg>
                                         <div class="ml-2">
                                        <div class="font-weight-bold font-12  text-dark transportDistance">${parseInt(res.meta.transportDistance || 0)}KM</div>
                                        <div class="font-10 text-muted">Distance</div>
                                        </div>
                                        </div>
                                        </div>
                                 </div>
                                

                                  <div class="d-flex flex-column align-items-center" style="gap:15px;">

                                        <div class="d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
                                        <div class="d-flex align-items-center mr-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><path d="M12 8v4l1.5 1.5m6.045 2.953C21.182 17.337 22 17.78 22 18.5s-.818 1.163-2.455 2.047l-1.114.601c-1.257.679-1.885 1.018-2.187.772c-.74-.605.413-2.164.696-2.716c.288-.56.282-.858 0-1.408c-.283-.552-1.436-2.111-.696-2.716c.302-.246.93.093 2.187.772z"/><path d="M13.026 21.948Q12.52 21.999 12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10q-.002 1.03-.2 2"/></g></svg>
                                        <div class="ml-2">
                                        <div class="font-weight-bold font-12  text-dark opasity-">${formatDate(res.meta.transportPickupTime)}</div>
                                        <div class="font-10 text-muted">Pickup Time</div>
                                        </div>
                                        </div>
                                        </div>

                                         <div class="d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
                                        <div class="d-flex align-items-center mr-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><path fill="currentColor" d="M16 9c-.91 0-1.77.18-2.57.5l-.7-3.05l3.89-3.89c.58-.56.58-1.53 0-2.12s-1.54-.586-2.12 0l-3.89 3.89l-9.2-2.12L0 3.62L7.43 7.5l-3.89 3.9l-2.48-.35L0 12.11l3.18 1.76l1.77 3.19L6 16l-.34-2.5l3.89-3.87l1.02 1.96A6.995 6.995 0 0 0 16 23c3.87 0 7-3.13 7-7s-3.13-7-7-7m0 12c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5m.5-4.75V12H15v5l3.61 2.16l.75-1.22z"/></svg>
                                         <div class="ml-2">
                                        <div class="font-weight-bold font-12  text-dark opasity-">${formatDate(res.meta.transportDeliveryTime)}</div>
                                        <div class="font-10 text-muted">Delivery Time</div>
                                        </div>
                                        </div>
                                        </div>
                               
                                 </div>
                            </div>



`;





	jQuery('.transportDetailsInMap').html(transportDetailsInMap);



}













function formatCalCadPrice(value) {
	let number = parseFloat(value);
	if (isNaN(number)) return value;
	return 'CA$' + number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}




// Initialize the lightbox on click
jQuery(document).on('click', '[data-toggle="lightbox"]', function(event) {
	event.preventDefault();
	jQuery(this).ekkoLightbox();
});





function formatDate(dateString) {
	const date = new Date(dateString);

	const options = {
		year: 'numeric',
		month: 'long',
		day: 'numeric',
		hour: 'numeric',
		minute: 'numeric',
	};

	if (!isNaN(date.getTime())) {

		return date.toLocaleDateString('en-US', options).replace(', ', ', ');
	} else {
		return dateString;
	}
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
				alert('Failed to retrieve vehicle information. Please check the VIN.');
				return;
			}
		}).fail(function() {
			alert('Error connecting to the API. Please try again later.');
		});
	}

});



function getTransportData(filterKey = '', filterValue = '') {
	jQuery('#loadingSpinner').show(); // Show the loading spinner

	const apiUrl = filterKey && filterValue ?
		`<?php echo home_url(); ?>/rancoded-json/api/v1/get-transports?key=${filterKey}&value=${filterValue}` :
		`<?php echo home_url(); ?>/rancoded-json/api/v1/get-transports`;

	return jQuery.getJSON(apiUrl, function(res) {
		if (res.status === 'success') {
			console.log(res.data);
			insertMainDealsToSection(res.data);


		} else if (res.status != 'success') {
			alert(res.message);
		}

		jQuery('#loadingSpinner').hide();
	}).fail(function() {
		alert('Error connecting to the API. Please try again later.');
	});
}

getTransportData('transportStatus', 'New Transport Order');

function getAwaitingTransportData(filterKey = '', filterValue = '') {
	jQuery('#loadingSpinner').show(); // Show the loading spinner

	const apiUrl = filterKey && filterValue ?
		`<?php echo home_url(); ?>/rancoded-json/api/v1/get-transports?key=${filterKey}&value=${filterValue}` :
		`<?php echo home_url(); ?>/rancoded-json/api/v1/get-transports?key=${"transportStatus"}&value=${"Awaiting pickup"}`;

	return jQuery.getJSON(apiUrl, function(res) {
		if (res.status === 'success') {
			insertPendingTransportToSection(res.data, "Awaiting pickup", filterKey ? 6 : 200);

		} else if (res.status != 'success') {
			alert(res.message);
		}

		jQuery('#loadingSpinner').hide();
	}).fail(function() {
		alert('Error connecting to the API. Please try again later.');
	});
}
getAwaitingTransportData('transportStatus', 'Awaiting pickup');

function getRouteTransportData(filterKey = '', filterValue = '') {
	jQuery('#loadingSpinner').show(); // Show the loading spinner

	const apiUrl = filterKey && filterValue ?
		`<?php echo home_url(); ?>/rancoded-json/api/v1/get-transports?key=${filterKey}&value=${filterValue}` :
		`<?php echo home_url(); ?>/rancoded-json/api/v1/get-transports?key=${"transportStatus"}&value=${"On Route"}`;

	return jQuery.getJSON(apiUrl, function(res) {
		if (res.status === 'success') {

			insertPendingTransportToSection(res.data, "On Route", filterKey ? 6 : 200);

		} else if (res.status != 'success') {
			alert(res.message);
		}

		jQuery('#loadingSpinner').hide();
	}).fail(function() {
		alert('Error connecting to the API. Please try again later.');
	});
}
getRouteTransportData('transportStatus', 'On Route');

function insertMainDealsToSection(data) {
	const homeUrl = '<?php echo home_url(); ?>';
	let pendingSectionTableData = ''; // Initialize the table

	if (data && data.length > 0) {
		pendingSectionTableData += `<div class="overflow-auto ">
                                <div class="table small table-orders">
                                    <div>
                                        <div class="col-12 d-flex my-3">
                                            <div class="col-1 text-center" style="border-radius:10px 0 0 0;">
                                                Order ID
                                            </div>
                                            <div class="col">Priority</div>
                                            <div class="col">Date</div>
                                            <div class="col">Pickup</div>
                                            <div class="col">Destination</div>
                                            <div class="col">VIN</div>
                                            <div class="col">Fee</div>
                                            <div class="col">Distance</div>
                                            <div class="col text-center">Status</div>
                                            <div class=""></div>
                                        </div>
                                    </div>
                                    <div>`;

		// Loop through each entry in the data array
		data.forEach(function(entry) {
			// Add row for each entry
			pendingSectionTableData += `<div data-entry-id="${entry.id}">
                                    <div class="col-12 d-flex align-items-center bg-light py-3 mb-2 text-decoration-none" style="border-radius:8px;">
                                        <div class="col-1 text-center">`;
			
				pendingSectionTableData += `<a href="javascript:void(0)" data-entry-id="${entry.id}"  data-entry-status="${entry.meta.transportStatus}" class="deal-entry-link text-dark d-flex flex-column align-items-center">
                                                <span>${entry.id}</span>
                                            </a>`
			

			pendingSectionTableData += `	
                                            
                                        </div>
                                        <div class="col flag-${entry.id}">
                                            <div class="d-flex align-items-center ${entry.meta.transportNotes?.priority === 'Low' || entry.meta.transportPriority === 'Low' ? 'text-success' : entry.meta.transportNotes?.priority === 'Medium' || entry.meta.transportPriority === "Medium" ? 'text-warning' : entry.meta.transportNotes?.priority === 'High' || entry.meta.transportPriority === "High" ? 'text-danger' : 'text-success' }">
                                            <span>${entry.meta.transportNotes?.priority || entry.meta.transportPriority || 'Low'}
                                            </span><i class="fas fa-flag ml-2"></i>
                                            </div>
                                        </div>
                                        <div class="col overflow-auto text-muted">
                                            ${new Date(entry.publish).toLocaleString()}
                                        </div>
                                        <div class="col font-10 overflow-auto">
                                            ${entry.meta.transportPickupLocation.address || ''}
                                        </div>
                                        <div class="col font-10 overflow-auto">
                                            ${entry.meta.transportDestinationLocation.address || ''}
                                        </div>
                                        <div class="col font-10 overflow-auto">
                                            <div class="text-dark d-flex flex-column align-items-center">
                                                <span>${entry.meta.vehicleName}</span>
                                                <span>${entry.meta.transportVIN}</span>
                                            </div>
                                        </div>
                                        <div class="col overflow-auto">
                                            ${formatCalCadPrice(entry.meta.transportFee || 0)}
                                        </div>
                                        <div class="col font-10 overflow-auto">
                                            ${entry.meta.transportDistance || ''}KM
                                        </div>
                                          <div class="col d-flex justify-content-center align-items-center dropdown">
                                            `;



			if (entry.meta.transportStatus === "Compleated" || entry.meta.transportStatus === "Cancelled" ||
				entry.meta.transportStatus === "Delivered" || entry.meta.transportStatus ===
				"Awaiting pickup" || entry.meta.transportStatus === "On Route") {
				pendingSectionTableData += ` <button class="turbo-success dropdown-toggle font-8 px-2 py-1 rounded-pill" type="button"
	data-toggle="dropdown"
	aria-expanded="false" >
		<i class="fas fa-circle small mr-2"></i> ${entry.meta.transportStatus ||  "Pending"} </button>`;

			} else if (entry.meta.transportStatus === "Rescheduled") {
				pendingSectionTableData += `<button type="button"
	data-toggle="dropdown"
	aria-expanded="false" class="turbo-warning dropdown-toggle font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2"></i> ${entry.meta.transportStatus ||  "Pending"}
                                    </button>`;
			} else {
				pendingSectionTableData += `<button type="button"
	data-toggle="dropdown"
	aria-expanded="false" class="turbo-danger dropdown-toggle font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2"></i> ${"Unassigned"}
                                    </button>`;
			}

			pendingSectionTableData += `

                                            <div class="dropdown-menu z-index">
                                                <a class="dropdown-item status" href="javascript:void(0)" data-type="driver"  data-status-name="Awaiting Pickup" data-entry-id="${entry.id}">
                                                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
                                                        style="width:14px;" />

                                                    Awaiting Pickup</a>
                                                <a class="dropdown-item status" href="javascript:void(0)"  data-type="driver" data-status-name="On Route" data-entry-id="${entry.id}"><img
                                                        src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
                                                        style="width:14px;" />
                                                    On Route</a>
                                                <a class="dropdown-item status" href="javascript:void(0)"  data-type="seller"  data-status-name="Delivered" data-entry-id="${entry.id}"><img
                                                        src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
                                                        style="width:14px;" />
                                                    Delivered</a>
                                                <a class="dropdown-item status" href="javascript:void(0)"  data-type="driver" data-status-name="Rescheduled" data-entry-id="${entry.id}"><img
                                                        src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
                                                        style="width:14px;" />
                                                    Rescheduled</a>
                                                <a class="dropdown-item status" href="javascript:void(0)"  data-type="driver"  data-status-name="Cancel" data-entry-id="${entry.id}">
                                                <img
                                                        src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
                                                        style="width:14px;" />
                                                    Cancel</a>
                                                <a class="dropdown-item status" href="javascript:void(0)"  data-status-name="Delete" data-entry-id="${entry.id}"><img
                                                        src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delete.svg"
                                                        style="width:14px;" />
                                                    Delete Application</a>
                                            </div>
            
                                        </div>

                                        <div class="text-right d-flex justify-content-end align-items-center">
                                        </div>
                                    </div>
                                </div>`;
		});

		pendingSectionTableData += `</div>
                            </div>
                        </div>`;
	} else {
		pendingSectionTableData = `
        <h1>Not Found Any Results</h1>
            <span>We have exclusive partnerships with some of Canada’s largest lenders to get your best-in-market rates.</span>
            <div class="mt-5">
                <a href="${homeUrl}/faq" class="btn btn-outline-secondary rounded-pill px-3" >Learn more</a>
            </div>`;
	}

	// Insert generated HTML into the section
	jQuery("#mainPendingDealsSection").html(pendingSectionTableData);



	jQuery('.documentManagementBody').removeClass('d-flex').addClass('d-none');

	jQuery('.documentManagementBody .sendDocumentSection .goPaperworkBtn').remove();


}





function insertPendingTransportToSection(data, sectionStatus, pagination = 6) {
	let pendingSectionTableData = ''; // Initialize the table
	let totalEntries = data.length;
	let totalPages = Math.ceil(totalEntries / pagination);
const homeUrl = '<?php echo home_url(); ?>';
	if (data && totalEntries > 0) {
		pendingSectionTableData += `<div class="overflow-auto ">
                                <div class="table small table-orders bordered bg-white radiusx p-2">
             
                                        <div class="col-12 d-flex my-3 mx-0">
                                            <div class="col-6 text-start" style="border-radius:10px 0 0 0;">
                                                <strong>${sectionStatus}</strong>
                                            </div>
                                            <div class="col-6 text-right"><button type="button" class="btn p-0 focus-none font-14 text-primary view-all"  onClick='${sectionStatus === "Awaiting pickup" ? "getAwaitingTransportData()" : "getRouteTransportData()"}'>View All</button></div>
                                        </div>
     
                                    <div>`;

		// Loop through paginated data
		data.slice(0, pagination).forEach(function(entry, index) {
			const formatAddress = (address) => {
				if (!address) return '';
				let parts = address.split(',');
				return `${parts[1]?.trim() || ''}, ${parts[2]?.split(' ')[0]?.trim() || ''}`;
			};

			pendingSectionTableData += `<div data-entry-id="${entry.id}">
                                    <div class="col-12 d-flex align-items-center bg-light py-3 mb-2 text-decoration-none" style="border-radius:8px;">
                                        <div class="col-2 text-center">
                                            <a href="javascript:void(0)" data-entry-id="${entry.id}"  data-entry-status="${entry.meta.transportDeliveryStatus}" class="deal-entry-link text-dark d-flex flex-column align-items-center">
                                                <span>SHIPID${entry.id}</span>
                                            </a>
                                        </div>
                                        
                                        <div class="col font-10 overflow-auto text-center">
                                            ${formatAddress(entry.meta.transportPickupLocation?.address)} 
                                            to 
                                            ${formatAddress(entry.meta.transportDestinationLocation?.address)}
                                        </div>
                                        
                                        <div class="col-2 d-flex justify-content-center align-items-center dropdown">
                                           `;

			// Buttons based on finance status
			if (entry.meta.transportStatus === "Awaiting pickup") {
				pendingSectionTableData += `<button type="button"
                                                data-toggle="dropdown" aria-expanded="false" class="turbo-success dropdown-toggle  font-8 px-2 py-1 rounded-pill" aria-expanded="false">
                                        <i class="fas fa-circle small mr-2 text-primary"></i> ${"AP"}
                                    </>`;
			} else if (entry.meta.transportStatus === "On Route") {
				pendingSectionTableData += `<button type="button" data-toggle="dropdown" aria-expanded="false" class="turbo-success dropdown-toggle  font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2 text-primary"></i> ${"On Route"}
                                    </button>`;
			} else if (["Compleated", "Cancelled", "Delivered", "Rescheduled"].includes(entry.meta
					.transportStatus)) {
				pendingSectionTableData += `<button type="button"
                                                data-toggle="dropdown" aria-expanded="false" class="turbo-success dropdown-toggle  font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2"></i> ${entry.meta.transportStatus || "Pending"}
                                    </button>`;
			} else {
				pendingSectionTableData += `<button type="button"
                                                data-toggle="dropdown" aria-expanded="false" class="turbo-success dropdown-toggle font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2 text-primary"></i> ${entry.meta.transportStatus || "Pending"}
                                    </button>`;
			}


			pendingSectionTableData += `

                                            <div class="dropdown-menu z-index">
                                                <a class="dropdown-item status" href="javascript:void(0)" data-type="driver" data-status-name="Awaiting Pickup" data-entry-id="${entry.id}">
                                                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg" style="width:14px;" />
                                                    Awaiting Pickup</a>
                                                <a class="dropdown-item status" href="javascript:void(0)" data-type="driver" data-status-name="On Route" data-entry-id="${entry.id}">
                                                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg" style="width:14px;" />
                                                    On Route</a>
                                                <a class="dropdown-item status" href="javascript:void(0)" data-type="seller" data-status-name="Delivered" data-entry-id="${entry.id}">
                                                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg" style="width:14px;" />
                                                    Delivered</a>
                                                <a class="dropdown-item status" href="javascript:void(0)" data-type="driver" data-status-name="Rescheduled" data-entry-id="${entry.id}">
                                                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg" style="width:14px;" />
                                                    Rescheduled</a>
                                                <a class="dropdown-item status" href="javascript:void(0)" data-type="driver" data-status-name="Cancel" data-entry-id="${entry.id}">
                                                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg" style="width:14px;" />
                                                    Cancel</a>
                                                <a class="dropdown-item status" href="javascript:void(0)" data-status-name="Delete" data-entry-id="${entry.id}">
                                                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delete.svg" style="width:14px;" />
                                                    Delete Application</a>
                                            </div>
                                        </div>

                                        <div class="col-3 overflow-auto text-muted text-right">
                                            ${entry.meta.transportPickupTime}
                                        </div>
                                    </div>
                                </div>`;
		});

		pendingSectionTableData += `</div>
                            </div>
                        </div>`;

	} else {
		pendingSectionTableData = `
        <h1>Not Found Any Results</h1>
            <span>We have exclusive partnerships with some of Canada’s largest lenders to get your best-in-market rates.</span>
            <div class="mt-5">
                <a href="${homeUrl}/faq" class="btn btn-outline-secondary rounded-pill px-3" >Learn more</a>
            </div>`;
	}

	let myAwaitingTransports = '';

	let width = screen.width

	if (data && totalEntries > 0) {
		myAwaitingTransports += `<div class="">
                                <div class="bordered bg-white radiusx">
                                <div>`;

		// Loop through paginated data
		data.slice(0, pagination).forEach(function(entry, index) {
			const formatAddress = (address) => {
				if (!address) return '';
				let parts = address.split(',');
				return `${parts[1]?.trim() || ''}, ${parts[2]?.split(' ')[0]?.trim() || ''}`;
			};

			myAwaitingTransports +=
				`<div data-entry-id="${entry.id}">
                                    <div class="col-12 d-flex flex-column align-items-center bg-light py-3 mb-2 text-decoration-none radiusx" style="${width <= '500' ? 'max-width: 360px' : null} border-radius:8px;">
										<div class="d-flex col-12 p-0">
                                        <div class="col-4 text-center pl-0  d-flex align-items-center">
                                        <i class="fa-solid fa-truck-fast" style="color:#68A281"></i>
                                         <a href="javascript:void(0)" data-entry-id="${entry.id}"  data-entry-status="${entry.meta.transportDeliveryStatus}" class="deal-entry-link text-dark font-12">
                                                <span class="ml-2">#${entry.id}</span>
                                            </a>
                                        </div>
                                        <div class="col-8 p-0 d-flex flex-wrap justify-content-end align-items-center">
                                        <div class="pl-0 mr-md-2 d-flex justify-content-center align-items-center dropdown">
                                            <a class="text-primary dropdown-toggle font-10 mb-2 mr-2" type="button"
                                                data-toggle="dropdown" aria-expanded="false" style="max-height: 30px; min-width: 60px; align-items: center; justify-content: center; display: flex;">`;

			// Buttons based on finance status
			if (entry.meta.transportStatus === "Awaiting pickup") {
				myAwaitingTransports += `<div class="turbo-success font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2 text-primary"></i> ${"AP"}
                                    </div>`;
			} else if (entry.meta.transportStatus === "On Route") {
				myAwaitingTransports += `<div class="turbo-success font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2 text-primary"></i> ${"On Route"}
                                    </div>`;
			} else if (["Compleated", "Cancelled", "Delivered", "Rescheduled"].includes(entry.meta
					.transportStatus)) {
				myAwaitingTransports += `<div class="turbo-warning font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2"></i> ${entry.meta.transportStatus || "Pending"}
                                    </div>`;
			} else {
				myAwaitingTransports += `<div class="turbo-danger font-8 px-2 py-1 rounded-pill">
                                        <i class="fas fa-circle small mr-2 text-primary"></i> ${"Pending"}
                                    </div>`;
			}

			myAwaitingTransports += `</a>

                                            <div class="dropdown-menu z-index">
                                                <a class="dropdown-item status" href="javascript:void(0)" data-type="driver" data-status-name="Awaiting Pickup" data-entry-id="${entry.id}">
                                                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg" style="width:14px;" />
                                                    Awaiting Pickup</a>
                                                <a class="dropdown-item status" href="javascript:void(0)" data-type="driver" data-status-name="On Route" data-entry-id="${entry.id}">
                                                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg" style="width:14px;" />
                                                    On Route</a>
                                                <a class="dropdown-item status" href="javascript:void(0)" data-type="seller" data-status-name="Delivered" data-entry-id="${entry.id}">
                                                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg" style="width:14px;" />
                                                    Delivered</a>
                                                <a class="dropdown-item status" href="javascript:void(0)" data-type="driver" data-status-name="Rescheduled" data-entry-id="${entry.id}">
                                                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg" style="width:14px;" />
                                                    Rescheduled</a>
                                                <a class="dropdown-item status" href="javascript:void(0)" data-type="driver" data-status-name="Cancel" data-entry-id="${entry.id}">
                                                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg" style="width:14px;" />
                                                    Cancel</a>
                                                <a class="dropdown-item status" href="javascript:void(0)" data-status-name="Delete" data-entry-id="${entry.id}">
                                                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delete.svg" style="width:14px;" />
                                                    Delete Application</a>
                                            </div>
                                        </div>

                                         <div class="px-0 d-flex align-items-center justify-content-end">
                                            <a href="javascript:void(0)" data-entry-id="${entry.id}"  data-entry-status="${entry.meta.transportDeliveryStatus}" class="deal-entry-link text-primary d-flex flex-flex justify-content-between mb-2 align-items-center font-10 px-2 py-1" style="width:80px; height:22px; border-radius:30px; border:1px solid #BF9B3E; max-height: 30px; min-width: 60px; align-items: center; justify-content: center; display: flex;">
                                                 <i class="fas fa-search small mr-1 text-primary font-14"></i>

                                                <span>Tracking</span>
                                            </a>
                                        </div>
                                        </div>
                                        </div>

                                        <div class="col-12 overflow-auto text-muted text-muted font-12 pl-0">
                                            ${entry.meta.vehicleName}
                                        </div>
                                       

                                        <div class="col-12 d-flex justify-content-between p-0">
                                           <div class="col-8  overflow-auto text-muted font-10 p-0">
                                            Pickup: ${formatDate(entry.meta.transportPickupTime)}
                                            </div>
                                            
                                            <div class="col-4 overflow-auto text-muted text-right p-0">
                                            
                                            <button class="btn text-primary font-8" type="button" data-toggle="collapse" data-target="#collapse${entry.id}" aria-expanded="false" aria-controls="collapse${entry.id}">
                                                    View more
                                                </button>
                                            </div>
                                        </div>

                                    
                                        <div class="collapse font-10 text-muted" id="collapse${entry.id}">
                                        ${formatAddress(entry.meta.transportPickupLocation?.address)} 
                                                                                    to 
                                                                                    ${formatAddress(entry.meta.transportDestinationLocation?.address)}
                                        </div>

                                        
                                     



                                    </div>
                                </div>`;
		});

		myAwaitingTransports += `</div>
                            </div>
                        </div>`;

	} else {
		myAwaitingTransports = `
        <h1>Not Found Any Results</h1>
            <span>We have exclusive partnerships with some of Canada’s largest lenders to get your best-in-market rates.</span>
            <div class="mt-5">
                <a href="${homeUrl}/faq" class="btn btn-outline-secondary rounded-pill px-3" >Learn more</a>
            </div>`;
	}

	if (sectionStatus === "Awaiting pickup") {
		// Insert generated HTML into the section
		jQuery("#mainPendingTransportsSection").html(pendingSectionTableData);
		jQuery("#myAwaitingTransports").html(myAwaitingTransports);
	} else if (sectionStatus === "On Route") {
		jQuery("#mainOnRouteTransportsSection").html(pendingSectionTableData);
	}
}




jQuery('.fetchTransports').on('click', function() {


	var callType = jQuery(this).data("name");
	jQuery('.fetchTransports').removeClass('text-primary');
	jQuery(this).addClass('text-primary');

	console.log(callType);

	if (callType === 'New Transport Order') {
		getTransportData('transportStatus', 'New Transport Order');
	} else if (callType === 'Unassigned') {
		getTransportData('transportStatus', 'Unassigned');
	} else if (callType === 'Awaiting Pickup') {
		getTransportData('transportStatus', 'Awaiting Pickup');
	} else if (callType === 'On Route') {
		getTransportData('transportStatus', 'On Route');
	} else if (callType === 'Delivered') {
		getTransportData('transportStatus', 'Delivered');
	} else if (callType === 'Cancelled') {
		getTransportData('transportStatus', 'Cancelled');
	} else if (callType === 'Rescheduled') {
		getTransportData('transportStatus', 'Rescheduled');
	} else {
		getTransportData();
	}

});



// Function to fetch transport data and process it
// Admin based 
function getTransportDataForAdminOrders(filterKey = '', filterValue = '') {
	jQuery('#loadingSpinner').show(); // Show loading spinner

	const apiUrl = filterKey && filterValue ?
		`<?php echo home_url(); ?>/rancoded-json/api/v1/get-transports?key=${filterKey}&value=${filterValue}` :
		`<?php echo home_url(); ?>/rancoded-json/api/v1/get-transports`;

	return jQuery.getJSON(apiUrl, function(res) {
		if (res.status === 'success') {
			const transports = res.data;

			let currentDriverOrderCompletedData = [];
			let currentDriverOrderData = [];

			// Filter orders by the current driver
			transports.forEach(function(transport) {
				const driverInfo = Array.isArray(transport.meta?.transportDriver) ?
					transport.meta.transportDriver : [];
				if (transport.meta.transportStatus === "Delivered") {
					currentDriverOrderCompletedData.push(transport);
				} else {
					currentDriverOrderData.push(transport);
				}
			});




			renderLastThreeMonthsOrders(currentDriverOrderData);
			renderDeliveredOrders(currentDriverOrderData, currentDriverOrderCompletedData)

			// Process chart data and render charts
			getOrdersInCities(currentDriverOrderData);
			initializeCharts(currentDriverOrderData, currentDriverOrderCompletedData);
			countOrdersByCity(currentDriverOrderCompletedData);
		} else {
			alert(res.message || 'No data found.');
		}

		jQuery('#loadingSpinner').hide();
	}).fail(function() {
		alert('Error connecting to the API. Please try again later.');
		jQuery('#loadingSpinner').hide();
	});
}

function renderLastThreeMonthsOrders(currentDriverOrderData) {
	// Get the last three months' data
	const ordersByMonth = {};
	const now = new Date();

	// Group orders by month
	currentDriverOrderData.forEach(order => {
		const orderDate = new Date(order.publish);
		const monthKey = `${orderDate.getFullYear()}-${orderDate.getMonth() + 1}`; // e.g., "2024-12"
		if (!ordersByMonth[monthKey]) {
			ordersByMonth[monthKey] = 0;
		}
		ordersByMonth[monthKey]++;
	});

	// Get last three months
	const lastThreeMonths = [];
	for (let i = 0; i < 3; i++) {
		const monthDate = new Date(now.getFullYear(), now.getMonth() - i, 1);
		const monthKey = `${monthDate.getFullYear()}-${monthDate.getMonth() + 1}`;
		const monthName = monthDate.toLocaleString('default', {
			month: 'long'
		});
		const orderCount = ordersByMonth[monthKey] || 0;
		lastThreeMonths.push({
			monthName,
			orderCount
		});
	}
	const homeUrl = window.location.origin;

	// Generate HTML
	let ordersHtml = '';
	lastThreeMonths.forEach((monthData, index) => {
		ordersHtml += `
            <div class="d-flex align-items-center">
                <div class="bg-secondary p-1 mr-1 mb-2 d-flex justify-content-center align-items-center"
                    style="width:40px; height:40px; border-radius:9px;">
                    <img width="20" height="20" src="${homeUrl}/wp-content/uploads/2024/12/Vector.svg" />
                </div>
                <div>
                    <div class="font-10">${index === 0 ? 'New Orders' : monthData.monthName + ' Orders'}</div>
                    <div class="numberOfOrders font-12">${monthData.orderCount}</div>
                </div>
            </div>
        `;
	});

	// Calculate comparison to last month
	const comparison = lastThreeMonths[0].orderCount - (lastThreeMonths[1]?.orderCount || 0);
	const comparisonPercentage = lastThreeMonths[1]?.orderCount ?
		Math.round((comparison / lastThreeMonths[1].orderCount) * 100) :
		0;

	// Append comparison
	ordersHtml += `
        <div>
            <div class="font-10">In comparison to Last month</div>
            <h3 class="${comparisonPercentage >= 0 ? 'text-success' : 'text-danger'}">
                <i class="fal fa-long-arrow-${comparisonPercentage >= 0 ? 'up' : 'down'}"></i>${Math.abs(comparisonPercentage)}%
            </h3>
        </div>
    `;

	// Inject the HTML into the container
	jQuery('#lastThreeMonthOrders').html(ordersHtml);
}





function renderDeliveredOrders(currentDriverOrderData, currentDriverOrderCompletedData) {
	// Filter and get the last 3 orders based on the publish date
	const recentMonthTransports = currentDriverOrderData
		.filter(transport => transport.publish)
		.slice(-3); // Get the last 3 orders

	const recentMonthTransportsCompleted = currentDriverOrderCompletedData
		.filter(transport => transport.meta.price);

	// Calculate total and comparison
	const totalOrders = recentMonthTransports.length;
	const totalCompletedOrders = recentMonthTransportsCompleted.length;

	const lastMonthOrders = currentDriverOrderData.slice(-6, -3).length; // Assuming last 6-3 are for last month
	const comparisonPercentage = lastMonthOrders ?
		Math.round(((totalOrders - lastMonthOrders) / lastMonthOrders) * 100) :
		0;

	const homeUrl = window.location.origin;



	// Completed Orders HTML
	const completedOrdersHtml = `
        
            <div class="d-flex align-items-center">
                <div class="bg-secondary p-1 mr-1 mb-2 d-flex justify-content-center align-items-center"
                    style="width:40px; height:40px; border-radius:9px;">
                    <img width="20" height="20" src="${homeUrl}/wp-content/uploads/2024/12/Vector.svg" />
                </div>
                <div>
                    <div class="font-10">Total Orders</div>
                    <div class="numberOfOrders font-12">${totalCompletedOrders}</div>
                </div>
            </div>
            <div>
                <div class="font-10">In comparison to Last month</div>
                <h3 class="${comparisonPercentage >= 0 ? 'text-success' : 'text-danger'}">
                    <i class="fal fa-long-arrow-${comparisonPercentage >= 0 ? 'up' : 'down'}"></i>${Math.abs(comparisonPercentage)}%
                </h3>
            </div>
        
    `;

	// Insert HTML into the respective containers
	jQuery('#completedOrdersResult').html(completedOrdersHtml);
}


// User Email based
function getTransportDataForUserOrders(filterKey = '', filterValue = '') {
	jQuery('#loadingSpinner').show(); // Show loading spinner

	const apiUrl = filterKey && filterValue ?
		`<?php echo home_url(); ?>/rancoded-json/api/v1/get-transports?key=${filterKey}&value=${filterValue}` :
		`<?php echo home_url(); ?>/rancoded-json/api/v1/get-transports`;

	return jQuery.getJSON(apiUrl, function(res) {
		if (res.status === 'success') {
			const transports = res.data;
			const userEmail = "<?php echo $userdata->user_email; ?>"; // Current driver's email

			let currentDriverOrderCompletedData = [];
			let currentDriverOrderData = [];

			// Filter orders by the current driver
			transports.forEach(function(transport) {
				const driverInfo = Array.isArray(transport.meta?.transportDriver) ?
					transport.meta.transportDriver : [];

				// Check if the current driver is in the transportDriver array
				const isCurrentDriver = driverInfo.some(driver =>
					driver?.email === userEmail && driver?.driverStatus === "Accepted"
				);

				if (isCurrentDriver) {
					if (transport.meta.transportStatus === "Delivered") {
						currentDriverOrderCompletedData.push(transport);
					} else {
						currentDriverOrderData.push(transport);
					}
				}
			});





			// Process chart data and render charts
			getOrdersInCities(currentDriverOrderData);
			initializeCharts(currentDriverOrderData, currentDriverOrderCompletedData);
			countOrdersByCity(currentDriverOrderCompletedData);
		} else {
			alert(res.message || 'No data found.');
		}

		jQuery('#loadingSpinner').hide();
	}).fail(function() {
		alert('Error connecting to the API. Please try again later.');
		jQuery('#loadingSpinner').hide();
	});
}


// Extract region or city from address
// function extractRegion(destinationAddress) {
// 	const match = destinationAddress.match(/,\s*([A-Za-z\s]+)\s*[A-Za-z0-9]*$/);
// 	return match ? match[1].trim() : "Unknown Region";
// }


// Variables for chart data
let ordersInCitiesDataLabels = [];
let ordersInCitiesDataData = [];

function extractRegion(address) {
	if (!address) return "All Region"; // Fallback for missing address
	const cityOrderCounts = [
		"Quebec",
		"Saskatchewan",
		"British Columbia",
		"Ontario",
		"Manitoba",
		"Alberta",
	];

	try {
		const geocoder = new google.maps.Geocoder();
		const response = geocoder.geocode({
			address
		});
		if (response.results && response.results.length > 0) {
			const result = response.results[0];
			for (const component of result.address_components) {
				if (component.types.includes("political")) {
					if (cityOrderCounts.includes(component.long_name)) {

						return component.long_name; // Extract the city name
					}
					// console.log(component.long_name);

				}
			}
		}
		return "All"; // Fallback for cases where city is not found
	} catch (error) {
		console.error("Error extracting city:", error);
		return "All";
	}
}

// Process orders and generate chart data
function getOrdersInCities(orderData) {
	const regionOrderCounts = {};

	// Loop through the orders and extract region names
	orderData.forEach(order => {
		const destination = order.meta?.transportPickup || "";
		const region = extractRegion(destination);
		regionOrderCounts[region] = (regionOrderCounts[region] || 0) + 1;
	});

	// Populate global chart data variables
	ordersInCitiesDataLabels = Object.keys(regionOrderCounts);
	ordersInCitiesDataData = Object.values(regionOrderCounts);

	console.log("regionOrderCounts: ", regionOrderCounts);
	console.log("ordersInCitiesDataLabels: ", ordersInCitiesDataLabels);
	console.log("ordersInCitiesDataData: ", ordersInCitiesDataData);

	// Render the chart only if data is ready
	renderOrdersInCitiesChart();
}

// Render the doughnut chart
function renderOrdersInCitiesChart() {
	const ctxOrdersInCities = document.getElementById("doughnutOrdersInCities").getContext("2d");

	if (!ctxOrdersInCities) {
		console.error("Canvas element not found");
		return;
	}

	if (!ordersInCitiesDataLabels.length || !ordersInCitiesDataData.length) {
		console.error("Labels or Data are empty. Chart cannot be rendered.");
		console.log("Labels: ", ordersInCitiesDataLabels);
		console.log("Data: ", ordersInCitiesDataData);
		return;
	}

	// Create the doughnut chart
	new Chart(ctxOrdersInCities, {
		type: "doughnut",
		data: {
			labels: ordersInCitiesDataLabels,
			datasets: [{
				label: 'Orders in Cities',
				data: ordersInCitiesDataData,
				backgroundColor: [
					"#3B634C", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF", "#FF9F40"
				],
				hoverBackgroundColor: [
					"#3B634C", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF", "#FF9F40"
				],
				borderWidth: 0,
				borderColor: "#fff",
				cutout: "80%", // Inner hole for the doughnut effect
			}],
		},
		options: {
			responsive: true,
			plugins: {
				legend: {
					display: false,
					position: "right",
				},
			},
		},
	});
}

// Initialize and process the data for charts
// getTransportDataForUserOrders();
getTransportDataForAdminOrders();



function countOrdersByCity(orderData) {
	const cityOrderCounts = {
		Quebec: 0,
		Saskatchewan: 0,
		"British Columbia": 0,
		Ontario: 0,
		Manitoba: 0,
		Alberta: 0,
	};

	// Loop through the orders
	orderData.forEach(order => {
		if (order.transportStatus === "Delivered") {
			const city = order.meta.transportDestination;

			// Increment count if the city is in our specified list
			if (cityOrderCounts.hasOwnProperty(city)) {
				cityOrderCounts[city]++;
			}
		}
	});

	displayCityOrderCounts(cityOrderCounts);
}


function displayCityOrderCounts(cityOrderCounts) {
	const leftBorderColor = [
		"#3B634C", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF", "#FF9F40"
	]; // Fixed syntax for defining the array

	const citiesContainer = document.getElementById("cityOrderCountsTable");

	citiesContainer.style.marginLeft = "-40px";
	citiesContainer.style.marginTop = "45px";
	citiesContainer.style.minWidth = "200px";

	if (!citiesContainer) {
		console.error("Element with ID 'cityOrderCountsTable' not found.");
		return;
	}

	// Clear any existing content
	citiesContainer.innerHTML = "";

	// Create the container for the cities
	const cityWrapper = document.createElement("div");
	cityWrapper.classList.add("col-12", "d-flex", "flex-wrap");

	// Counter to cycle through border colors
	let colorIndex = 0;

	// Add rows for each city and its order count
	for (const city in cityOrderCounts) {
		if (Object.hasOwnProperty.call(cityOrderCounts, city)) {
			const grid = document.createElement("div");
			grid.classList.add("col-6");
			grid.style.marginBottom = "4px";
			const block = document.createElement("div");
			block.classList.add("leftColor");

			// Cycle through border colors
			const borderColor = leftBorderColor[colorIndex % leftBorderColor.length];
			colorIndex++;

			// Apply styles
			block.style.borderLeft = `4px solid ${borderColor}`;
			block.style.height = "55px";
			block.style.padding = "10px";

			// Add content
			block.innerHTML = `
                <span class="font-10 text-dark d-block">${city}</span>
                <span class="font-14 text-black d-block">${cityOrderCounts[city]}</span>
            `;

			grid.appendChild(block);
			cityWrapper.appendChild(grid);
		}
	}

	// Append the wrapper to the container
	citiesContainer.appendChild(cityWrapper);
}






const parseDate = (dateStr, fallback) => {
	// Attempt to parse `dateStr` into a Date object
	const date = new Date(dateStr);
	if (!isNaN(date.getTime())) {
		return date;
	}
	// If `dateStr` is invalid, attempt to parse the fallback
	const fallbackDate = new Date(fallback);
	return !isNaN(fallbackDate.getTime()) ? fallbackDate :
		new Date(); // Default to current date if both fail
};


function prepareChartData(orderData, completedOrderData, selectedMonth) {
	const groupedOrdersByMonth = {};
	const groupedCompletedOrdersByMonth = {};
	const earningsByMonth = {};


	// Group orders by month
	orderData.forEach(order => {
		const pickupDate = parseDate(order.meta.transportPickupTime, order.publish);
		const month = pickupDate.toISOString().slice(0, 7); // Format: YYYY-MM
		groupedOrdersByMonth[month] = (groupedOrdersByMonth[month] || 0) + 1;
		earningsByMonth[month] = (earningsByMonth[month] || 0) + parseFloat(order.meta.transportFee ||
			0);
	});

	// Group completed orders by month
	completedOrderData.forEach(order => {
		const deliveryDate = parseDate(order.meta.transportDeliveryTime, order.publish);
		const month = deliveryDate.toISOString().slice(0, 7); // Format: YYYY-MM
		groupedCompletedOrdersByMonth[month] = (groupedCompletedOrdersByMonth[month] || 0) + 1;
	});

	// Only include data for the selected month
	const filteredOrders = groupedOrdersByMonth[selectedMonth] || 0;
	const filteredCompletedOrders = groupedCompletedOrdersByMonth[selectedMonth] || 0;

	const monthNames = [
		"Jan", "Feb", "Mar", "Apr", "May", "Jun",
		"Jul", "Aug", "Sept", "Oct", "Nov", "Dec"
	];
	// Create chart labels and data
	const labels = monthNames; // X-axis labels as full month names
	const newOrdersData = Array(12).fill(0); // Initialize array with 12 zeroes
	const completedOrdersData = Array(12).fill(0);

	// Populate data
	labels.forEach((label, index) => {
		const month = `${selectedMonth.split("-")[0]}-${String(index + 1).padStart(2, "0")}`;
		newOrdersData[index] = groupedOrdersByMonth[month] || 0;
		completedOrdersData[index] = groupedCompletedOrdersByMonth[month] || 0;
	});

	return {
		labels: labels,
		datasets: [{
				label: "New Orders",
				data: newOrdersData, // Y-axis: Count of new orders
				fill: true,
				backgroundColor: "rgba(191, 155, 62, 0.3)",
				borderColor: "#BF9B3E",
				borderWidth: 2,
				tension: 0.4,
				pointRadius: 0,
			},
			{
				label: "Completed Orders",
				data: completedOrdersData, // Y-axis: Count of completed orders
				fill: true,
				backgroundColor: "rgba(191, 155, 62, 0.3)",
				borderColor: "#BF9B3E",
				borderWidth: 2,
				tension: 0.4,
				pointRadius: 0,
			},
		],
	};
}





let ordersChart; // Global variable for the orders chart
let completedChart; // Global variable for the completed chart

function populateMonthSelectors() {
	const monthSelectorOrders = document.getElementById("monthSelectorOrders");
	const monthSelectorCompleted = document.getElementById("monthSelectorCompleted");

	if (!monthSelectorOrders || !monthSelectorCompleted) {
		console.error("Month selector elements not found.");
		return;
	}

	const currentMonth = new Date();
	const monthNames = [
		"January", "February", "March", "April", "May", "June",
		"July", "August", "September", "October", "November", "December"
	];

	// Clear existing options
	monthSelectorOrders.innerHTML = "";
	monthSelectorCompleted.innerHTML = "";

	// Populate the month selectors with previous 12 months
	for (let i = 0; i < 12; i++) {
		const monthDate = new Date(currentMonth.getFullYear(), currentMonth.getMonth() - i, 1);

		// Manually construct the correct month value in YYYY-MM format
		const year = monthDate.getFullYear();
		const month = String(monthDate.getMonth() + 1).padStart(2, "0"); // Ensure two-digit month
		const monthValue = `${year}-${month}`;

		// Create the readable label
		const monthLabel = `${monthNames[monthDate.getMonth()]} ${year}`;

		// Create an option element
		const option = new Option(monthLabel, monthValue);
		monthSelectorOrders.add(option.cloneNode(true)); // For orders
		monthSelectorCompleted.add(option.cloneNode(true)); // For completed orders
	}

	// Default to the current month
	const currentMonthValue = `${currentMonth.getFullYear()}-${String(currentMonth.getMonth() + 1).padStart(2, "0")}`;
	monthSelectorOrders.value = currentMonthValue;
	monthSelectorCompleted.value = currentMonthValue;

	console.log("Populated month selectors with currentMonth:", currentMonthValue);
}



function updateChart(chart, chartData) {
	if (chart) {
		chart.data = chartData;
		chart.update();
	}
}

function initializeCharts(orderData, completedOrderData) {
	populateMonthSelectors();

	const ctxOrders = document.getElementById("smoothLineChart").getContext("2d");
	const ctxCompleted = document.getElementById("smoothLineCompleateOrderChart").getContext("2d");

	const defaultMonth = new Date().toISOString().slice(0, 7);
	const chartDataOrders = prepareChartData(orderData, completedOrderData, defaultMonth);

	// Initialize Orders Chart
	ordersChart = new Chart(ctxOrders, {
		type: "line",
		data: chartDataOrders,
		options: {
			responsive: true,
			maintainAspectRatio: false,
			plugins: {
				legend: {
					display: false
				},
				tooltip: {
					enabled: true
				},
			},
			scales: {
				x: {
					grid: {
						color: "rgba(200, 200, 200, 0.2)"
					},
					ticks: {
						font: {
							size: 10
						}
					}
				},
				y: {
					grid: {
						color: "rgba(200, 200, 200, 0.2)"
					},
					ticks: {
						stepSize: 50,
						font: {
							size: 10
						}
					}
				},
			},
		},
	});

	// Initialize Completed Orders Chart
	completedChart = new Chart(ctxCompleted, {
		type: "line",
		data: chartDataOrders,
		options: {
			responsive: true,
			maintainAspectRatio: false,
			plugins: {
				legend: {
					display: false
				},
				tooltip: {
					enabled: true
				},
			},
			scales: {
				x: {
					grid: {
						color: "rgba(200, 200, 200, 0.2)"
					},
					ticks: {
						font: {
							size: 10
						}
					}
				},
				y: {
					grid: {
						color: "rgba(200, 200, 200, 0.2)"
					},
					ticks: {
						stepSize: 5,
						font: {
							size: 10
						}
					}
				},
			},
		},
	});

	document.getElementById("monthSelectorOrders").addEventListener("change", (e) => {
		const selectedMonth = e.target.value;
		const chartData = prepareChartData(orderData, completedOrderData, selectedMonth);
		updateChart(ordersChart, chartData);
	});

	document.getElementById("monthSelectorCompleted").addEventListener("change", (e) => {
		const selectedMonth = e.target.value;
		const chartData = prepareChartData(orderData, completedOrderData, selectedMonth);
		updateChart(completedChart, chartData);
	});
}
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>






<script>
// Example usage for different instances
initializeFileUploadHandler('#companyLogoDropArea', '#companyLogoFileInput', '#companyLogoPreviewContainer',
	'.upload-company-logo-btn');
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




const transportProgress = document.querySelector(".js-completed-bar");
if (transportProgress) {
	transportProgress.style.width = transportProgress.getAttribute("data-complete") + "%";
	transportProgress.style.opacity = 1;
}
</script>


<script>

jQuery(document).on('click', '#submitTransportDetails', function() {
    jQuery('#loadingSpinner').show();

    const transportId = sessionStorage.getItem('@transport-id');
    const transportPickupTime = jQuery('#PickupDateTime').val();
    const transportDeliveryTime = jQuery('#DropoffDateTime').val();
    const transportDriverPhone = jQuery('#DriverContactNumber').val();
    const towingPartners = jQuery('#towingPartners').val();
    const transportTypes = jQuery('#transportTypes').val();
    const insurance = jQuery('#Insurance').val();

    // Validate required fields
    if (!transportPickupTime || !transportDeliveryTime || !transportDriverPhone) {
        jQuery('#loadingSpinner').hide();
        showGlobalAlert('error', `<h3>Please fill out the form properly!</h3>`);
        return;
    }

    // Prepare JSON payload
    const payload = {
        transportPickupTime: transportPickupTime,
        transportDeliveryTime: transportDeliveryTime,
        phone: transportDriverPhone,
        towingPartners: towingPartners,
        transportTypes: transportTypes,
        insurance: insurance,
        driverStatus: 'Accepted'
    };

    console.log('Payload:', payload);

    const apiUrl = `<?php echo home_url(); ?>/rancoded-json/api/v1/turbo-transport-driver/${transportId}`;

    // Send AJAX POST request with JSON payload
    jQuery.ajax({
        url: apiUrl,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(payload),
        success: function(res) {
            console.log("Drivers: ", res);

            // Update status
            const status = {
                transportId: transportId,
                transportStatus: 'Driver added',
                status_name: 'Driver added',
                status_submitter: '<?php echo $user_lname; ?>'
            };

            sessionStorage.setItem('@transport-accept-info', JSON.stringify(status));
            submitTransportStatus();
        },
        error: function(err) {
            console.error('Error:', err);
            alert('Error connecting to the API. Please try again later.');
        },
        complete: function() {
            jQuery('#loadingSpinner').hide(); // Always hide spinner
        }
    });
});



</script>






<style>
.custom-tooltip {
	background-color: #fff;
	border: 1px solid #000;
	padding: 5px;
	font-size: 12px;
	color: #000;
	position: absolute;
	display: none;
	white-space: nowrap;
	z-index: 100;
	box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
	border-radius: 5px;
}


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
</style>
<style>
ul#all-bids {
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





@media screen and (max-width: 1100px) {
	.table.small.table-orders {
		overflow-x: scroll;
		width: 1200px;
	}
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

.form-check-input {
	margin-top: -10px !important;
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

.dropdown-toggle::after {
	display: none !important;
}


.custom-file-drop {
	border: 1px dashed #eee;
	border-radius: 100%;
	padding: 2px;
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


@media screen and (max-width: 350px) {
	.customModalWidthHalf {
		max-width: 90% !important;
		text-align: center !important;
	}

	.customModalWidthFull {
		max-width: 90% !important;
		text-align: start !important;
	}

}

@media screen and (max-width: 700px) {
	.customModalWidthHalf {
		max-width: 80% !important;
		text-align: center !important;
	}

	.customModalWidthFull {
		max-width: 80% !important;
		text-align: start !important;
	}

}

@media screen and (min-width: 701px) {
	.customModalWidthHalf {
		max-width: 40% !important;
		text-align: center !important;
	}

	.customModalWidthFull {
		max-width: 70% !important;
		text-align: start !important;
	}

	.position-md-fixed {
		position: fixed !important;
	}


	.overflow-md-auto{
		overflow-y:auto;
		height: calc(100vh - 140px);

	}
	.main-page-overflow-auto{
		overflow-y: scroll; height: calc(100vh - 90px);
	}

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




/* Transport Progress  */


.progress-decoration {
	position: relative;
	height: 16vh;
}

.progress-decoration svg {
	position: absolute;
	fill: rgba(237, 30, 40, 0.2);
}

.progress-decoration .icon-cloud {
	fill: rgba(145, 179, 250, 0.4);
}

.progress-decoration #cloud-one {
	right: 6vw;
	top: -12vh;
}

.progress-decoration #cloud-two {
	right: 32vw;
	top: -8vh;
}

.progress-decoration #cloud-three {
	right: 72vw;
	top: -12vh;
}

.progress-decoration #tree-one {
	bottom: 0;
	right: 80vw;
}

.progress-decoration #tree-two {
	bottom: 0;
	right: 20vw;
}

.progress-decoration #lamp-one {
	bottom: 0;
	right: 54vw;
}

.progress-decoration #lamp-two {
	bottom: 0;
	right: 0;
}

.transport-progress-container .progress-bar {
	background-color: #00000005;
	/* border: 3px #f4f4f4 solid; */
	border-radius: 5px;
	position: relative;
	margin: 4px 0 16px 0;
	height: 50px;
	width: 100%;
}

.transport-progress-container .progress-bar .completed-bar {
	background: linear-gradient(to left, #49EE8F, #3B634C);
	border-radius: 5px;
	color: #f4f4f4;
	display: flex;
	align-items: center;
	justify-content: center;
	height: 100%;
	width: 0;
	opacity: 0;
	transition: width 2s ease 0.4s;
	padding: 0 8px;
}

.transport-progress-container .progress-bar .completed-bar__dashed {
	width: 96%;
	border: 2px dashed #ffffff;
}

.transport-progress-container .progress-bar .completed-bar__truck {
	font-size: 1rem;
	margin-left: 4px;
}

.progress-information {
	display: none;
	justify-content: space-between;
	padding: 0 4px;
}

.icon-cloud {
	height: 50px;
	width: 50px;
}

.icon-lamp {
	height: 70px;
	width: 60px;
}

.icon-tree--one {
	height: 60px;
	width: 60px;
}

.icon-tree--two {
	height: 70px;
	width: 60px;
}

.progress-information p {
	font-family: "Poppins", "Helvetica", "sans-serif";
	letter-spacing: 1px;
	line-height: 1.5;
	display: block;
	margin-block-start: 1em;
	margin-block-end: 1em;
	margin-inline-start: 0px;
	margin-inline-end: 0px;
	margin-top: 0;
	margin-bottom: 1rem;
	font-weight: 300;
	font-size: 1rem;
	color: rgba(48, 48, 48, 0.6);
}

@media only screen and (max-width: 576px) {


	.progress-decoration {
		display: none;
	}

	.progress-information {
		display: flex;
	}

	.transport-progress-container .progress-bar {
		margin-bottom: 4px;
	}

	.transport-progress-container .progress-bar .completed-bar__dashed {
		width: 96%;
		border: 1px dashed #ffffff;
	}

	.transport-progress-container .progress-bar .completed-bar__truck {
		font-size: 1rem;
		margin-left: 0;
	}
}


.statusWrapper{
	border: 0.5px solid #ebecee;
    padding: 10px;
	margin-top:10px;
}


.deloveryStatusReport.wrapper {
	width: 100%;
	font-family: 'Helvetica';
	font-size: 14px;
}

.transportStepProgress {
    position: relative;
    margin-left: 45px;
    list-style: none;
    border: 0.5px solid #ebecee;
    border-radius: 10px;
    padding: 10px 0px;
}
.transportStepProgress small{
	color:#222222;
}

.transportStepProgress::before {
  display: inline-block;
  content: '';
  position: absolute;
  top: 5px;
  left: 9px;
  width: 10px;
  height: 50%;
  /* border-left: 1px solid #BF9B3E;  */
}

.transportStepProgress-item {
  position: relative;
  counter-increment: list;
  padding-bottom: 10px;
}

/* SVG Icons for steps */
.transportStepProgress-item::before {
  content: '';
  position: absolute;
  top: 0;
  left: -41px;
    width: 12px;
    height: 12px; /* Set height for SVG */
  background-size: contain; /* Ensure SVG scales properly */
  background-repeat: no-repeat;
    background-repeat: no-repeat;
    background-position: center;
}

.transportStepProgress-item.number:first-child::before, .transportStepProgress-item.number:last-child::before{
   	padding: 12px;
	border:0.5px solid #F8F9FA;
	border-radius: 50% !important;
	background: #fff;
    background-repeat: no-repeat;
    background-position: center;
	left: -48px;
}


.transportStepProgress-item.number:first-child::before {
  background-image: url('<?php echo home_url(); ?>/wp-content/uploads/2025/02/Vector.svg');
  
}
.transportStepProgress-item.number:last-child::before {
  background-image: url('<?php echo home_url(); ?>/wp-content/uploads/2025/02/Vector.svg');
}

.transportStepProgress-item.no-number::before {
  background-image: url('<?php echo home_url(); ?>/wp-content/uploads/2025/02/CodeSandboxOutlined.svg');
}

.transportStepProgress-item.number::before {
  background-image: url('<?php echo home_url(); ?>/wp-content/uploads/2025/02/CodeSandboxOutlined.svg');
    background-repeat: no-repeat;
    background-position: center;
}



/* Connecting lines */
/* .transportStepProgress-item:not(:last-child)::after {
  content: '';
  position: absolute;
  left: 7px;
  bottom: 0;
  width: 1px; 
  height: 100%;
  background: linear-gradient(to bottom, #000 50%, dashed 50%);
  background-size: 100% 200%; /* Adjust background for dashed */
  background-repeat: no-repeat;
} */



/* Current step styling */
.transportStepProgress-item.current::before {
  border-radius: 50%;

}



.transportStepProgress-item.is-done::after {
  content: '';
}

.transportStepProgress-item.current:not(:first-child)::after{
 content: '';
  position: absolute;
  top: -17px;
    left: -36px;
    width: 10px;
    height: 50%;
    border-left: 1px dashed #00000020;
}

.transportStepProgress strong {
	display: block;
}


/* Transport Progress  */
</style>
<?php get_template_part( 'framework/design/account/parts/document-management'); ?>

<script type="text/javascript">

</script>