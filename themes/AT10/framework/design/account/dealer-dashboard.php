<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN, $CORE_AUCTION;



$user_roles = wp_get_current_user()->roles;

$user_id = get_current_user_id(); // Get the current user ID
$user_email = $userdata->user_email;
$escrow_form_id = 330325;
$credit_form_id = 337873;


$document_card = get_user_meta($user_id, 'document_proof_file', true);






function check__dealer_deals($form_id)
{
	global $wpdb;

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


	// Return filtered entries or false if no entries found
	return !empty($entries) ? $entries : false;
}






$f = array(
	1 => array(

		"name" => __("User Research", "premiumpress"),
		"icon" => "fas fa-search",
		"color" => "#FFBB38",
		"link" => "<?php echo home_url(); ?>/wp-admin/admin.php?page=membership",
	),

	2 => array(

		"name" => __("New Escrow Transaction", "premiumpress"),
		"icon" => "fas fa-car-side",
		"color" => "#FFBB38",
		"link" => "<?php echo home_url(); ?>/escrow-back-end/",
	),

	3 => array(

		"name" => __("New Transport Trasaction", "premiumpress"),
		"icon" => "fas fa-car",
		"color" => "#FFBB38",
		"link" => "<?php echo home_url(); ?>/credit-application/",
	),



	4 => array(

		"name" => __("New Finance App", "premiumpress"),
		"icon" => "fas fa-car-crash",
		"color" => "#FFBB38",
		"link" => "<?php echo home_url(); ?>/credit-application/",
	),

	5 => array(
		"name" => __("Overdue invoices", "premiumpress"),
		"icon" => "fas fa-clipboard-list",
		"color" => "#FFBB38",
		"link" => "<?php echo home_url(); ?>/wp-admin/admin.php?page=listings",
	),

	6 => array(
		"name" => __("Escalate Issue", "premiumpress"),
		"icon" => "fal fa-tv-retro",
		"color" => "#FFBB38",
		"link" => "<?php echo home_url(); ?>/wp-admin/admin.php?page=listings",
	)



);


function display_deal_leads($form_id)
{
	global $wpdb;

	// Total Submissions
	$total_submissions = $wpdb->get_var(
		$wpdb->prepare(
			"SELECT COUNT(*) FROM wp_frmt_form_entry WHERE form_id = %d",
			$form_id
		)
	);

	// Last Submission Date
	$last_submission = $wpdb->get_var(
		$wpdb->prepare(
			"SELECT MAX(date_created) FROM wp_frmt_form_entry WHERE form_id = %d",
			$form_id
		)
	);

	// Format the last submission date
	$formatted_last_submission = $last_submission ? date('M d, Y @ g:i A', strtotime($last_submission)) : 'N/A';

	// Total Views
	$form_view = Forminator_Form_Views_Model::get_instance();
	$total_views = $form_view->count_views($form_id);

	// Conversion Rate
	$conversion_rate = $total_views > 0 ? round(($total_submissions / $total_views) * 100, 2) : 0;

	// Return as an array
	return [
		"total_views" => $total_views,
		"total_submissions" => $total_submissions,
		"last_submission" => $formatted_last_submission,
		"conversion_rate" => $conversion_rate
	];
}

$finance_deal = display_deal_leads(337873);

$pending_deal_tabs = array(
	1 => array(
		"name" => __("Conversion %", "premiumpress"),
		"value" => $finance_deal["conversion_rate"] . " %",
		"views" => $finance_deal["total_views"],
		"view_label" => __("Views on application"),
		"submit_count" => $finance_deal["total_submissions"],
		"submit_label" => __("Submitted Application"),
		"icon" => home_url() . "/wp-content/uploads/2024/09/note-2.svg",
		"color" => "#FFBB38",
		"link" => "",
	),

	2 => array(

		"name" => __("Awaiting Decision", "premiumpress"),
		"value" => "3",
		"decision" => 3,
		"decision_label" => __("Applicant Decision pending"),
		"icon" => home_url() . "/wp-content/uploads/2024/09/send-2.svg",
		"color" => "#FFBB38",
		"link" => "",
	),

	3 => array(

		"name" => __("KYC Verification", "premiumpress"),
		"value" => 48,
		"pending_kyc" => 3,
		"pending_kyc_label" => __("Pending KYC"),
		"completed_kyc" => 32,
		"completed_kyc_label" => __("Completed KYC"),
		"icon" => home_url() . "/wp-content/uploads/2024/09/graph.svg",
		"color" => "#FFBB38",
		"link" => "",
	),



	4 => array(

		"name" => __("Paperwork", "premiumpress"),
		"value" => 66,
		"pending_paperwork" => 33,
		"pending_paperwork_label" => __("Pending Paperwork"),
		"icon" => home_url() . "/wp-content/uploads/2024/09/chart-2.svg",
		"color" => "#FFBB38",
		"link" => "",
	),

	5 => array(
		"name" => __("Delivery", "premiumpress"),
		"value" => 6,
		"vehicle_pick" => 3,
		"vehicle_pick_label" => __("Vehicle Pick Up"),
		"vehicle_transport" => 2,
		"vehicle_transport_label" => __("Trbo Swift Transport"),
		"icon" => home_url() . "/wp-content/uploads/2024/09/danger.svg",
		"color" => "#FFBB38",
		"link" => "",
	),

	6 => array(
		"name" => __("Disbursal", "premiumpress"),
		"value" => 76,
		"disbursal_pick_label" => __("Deals Disbursed"),
		"icon" => home_url() . "/wp-content/uploads/2024/09/danger.svg",
		"color" => "#FFBB38",
		"link" => "",
	),
	7 => array(
		"name" => __("Declined Applications", "premiumpress"),
		"value" => 16,
		"bank_rejected" => 3,
		"bank_rejected_label" => __("Bank Rejected"),
		"customer_rejected" => 3,
		"customer_rejected_label" => __("Customer Rejected"),
		"icon" => home_url() . "/wp-content/uploads/2024/09/danger.svg",
		"color" => "#FFBB38",
		"link" => "",
	)
);




$deals = check__dealer_deals($credit_form_id);





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

			escrow: {
				content: '#list-item-escrow',
				menuItem: '.list-item-escrow',
			},
			finance: {
				content: '#list-item-finance',
				menuItem: '.list-item-finance',
			},
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
			users: {
				content: '#list-item-users',
				menuItem: '.list-item-users',
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



<section class="col-12 d-md-flex m-0 py-3">
	<div class="col-md-2">
		<ul class="bg-white list-unstyled py-3 my-3 radiusx" id="account_jumplinks"
			style="height:100%; line-height:30px;">

			<li class="list-item-pending-deals px-3 py-2 mb-3"> <a onclick="showDealerPage('pendingDeals');"
					href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab" role="tab">
					<?php echo __("Dealership", "premiumpress") ?> </a> </li>


			<li class="d-none list-item-finance px-3 py-2 mb-3"> <a onclick="showDealerPage('finance');"
					href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab" role="tab">
					<?php echo __("Finance Applications", "premiumpress") ?> </a> </li>




			<li class="list-item-booked-deals px-3 py-2 mb-3"> <a onclick="showDealerPage('bookedDeals');"
					href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab" role="tab">
					<?php echo __("Booked Deals", "premiumpress") ?> </a> </li>


			<li class="list-item-transport px-3 py-2 mb-3"> <a onclick="showDealerPage('transport');"
					href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab" role="tab">
					<?php echo __("Transport", "premiumpress") ?> </a> </li>

			<li class="list-item-escrow  px-3 py-2 mb-3"> <a onclick="showDealerPage('escrow');"
					href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab" role="tab">
					<?php echo __("Escrow Transaction", "premiumpress") ?> </a> </li>

			<li class="list-item-inspection px-3 py-2 mb-3"> <a onclick="showDealerPage('inspection');"
					href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab" role="tab">
					<?php echo __("Inspection Reports", "premiumpress") ?> </a> </li>

			<li class="list-item-invoices px-3 py-2 mb-3"> <a onclick="showDealerPage('invoices');"
					href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab"
					role="tab"><?php echo __("Invoices", "premiumpress") ?> </a> </li>

			<li class="list-item-users px-3 py-2 mb-3"> <a onclick="showDealerPage('users');" href="javascript:void(0);"
					class="text-decoration-none text-dark" data-toggle="tab"
					role="tab"><?php echo __("Users", "premiumpress") ?> </a> </li>

			<li class="list-item-documents px-3 py-2 mb-3"> <a onclick="showDlerPage('documents');"
					href="javascript:void(0);" class="text-decoration-none text-dark" data-toggle="tab"
					role="tab"><?php echo __("Documents", "premiumpress") ?> </a> </li>

			<li class="list-item-help px-3 py-2 mb-3"> <a onclick="showDealerPage('help');" href="javascript:void(0);"
					class="text-decoration-none text-dark" data-toggle="tab" role="tab"> <i
						class="fal fa-heart mr-2"></i> <?php echo __("Help", "premiumpress") ?> </a> </li>



			<li class="list-item px-3 py-2"> <a href="<?php echo wp_logout_url(); ?>"
					class="text-decoration-none text-dark"> <i class="fal fa-sign-out-alt text-danger mr-2"></i>
					<?php echo __("Logout", "premiumpress") ?> </a>
			</li>

		</ul>

	</div>


	<div class="col-12 col-md-10 p-0">
		<?php /*
		  <div id="list-item-dealership"  style="display: none;" class="col-12 px-md-1">
			  <div class="col-12 mb-4 p-0 px-md-1">
				  <div class="float-right position-absolute" style="right:20px; top:-20px;">
					  <small>Search Marketplace</small><br><br>
					  <img class="d-none d-md-block"
						  src="<?php echo home_url(); ?>/wp-content/uploads/2024/07/Group-1321315018.png"
						  style="width:400px;" />
				  </div>

				  <h4>Trbo Swift Dealer Services</h4>
				  <span>


					  <?php  $Hour = date('G', strtotime( date('Y-m-d H:i:s', strtotime(current_time( 'mysql' ) . "+1 minute")) ));

								  if ( $Hour >= 5 && $Hour <= 11 ) {
									  echo __("Good Morning","premiumpress");
								  } else if ( $Hour >= 12 && $Hour <= 18 ) {
									  echo __("Good Afternoon","premiumpress");
								  } else if ( $Hour >= 19 || $Hour <= 4 ) {
									  echo __("Good Evening","premiumpress");
								  }
								  
								  ?>,


					  <strong> <?php echo $CORE->USER("get_name",$userdata->ID); ?></strong> </span>
				  <span class="lead"><?php echo __("What would you like to do today?","premiumpress"); ?></span>
			  </div>


			  <div class="col-12 p-0 px-md-1">
				  <h6>Explore</h6>
				  <div class="row flex-md-wrap">
					  <?php $i=1; while($i <= 5){ ?>
					  <a class="col-12 col-md mb-2 p-0 px-md-1" href="<?php echo $f[$i]['link']; ?>" target="blank">
						  <div class="d-flex align-items-center justify-content-between"
							  style="background:#fff; border-radius: 20px; overflow:hidden; min-height: 109px;">
							  <div class="card-body position-relative pl-lg-4 row">

								  <div class="col-3 p-0">
									  <div
										  style="width:50.04px; height:50.04px; border-radius: 100%; display:flex; justify-content:center;align-items:center; background: #014127">
										  <i class="<?php echo $f[$i]['icon']; ?>"
											  style="font-size:20px; color: white;"></i>
									  </div>
								  </div>
								  <div class="col-7">
									  <span style="color:#014127; font-size:12px;"><?php echo $f[$i]['name']; ?></span>
								  </div>

								  <span class="col-2 p-0"><i class="fas fa-external-link-alt"
										  style="color:#014127"></i></span>

							  </div>
						  </div>
					  </a>
					  <?php $i++; } ?>
				  </div>
			  </div>


			  <div class="col-12 mt-3 p-0 px-md-1">
				  <div class="row">
					  <div class="col-12 px-0">
						  <style>
						  .notice-warning {
							  margin-bottom: 40px;
						  }
						  </style>

					  </div>
					  <div class="col-md-12 p-0 px-md-1">


						  <h6 class="my-2">New Leads</h6>

						  <div class="bg-white shadow-sm mt-3 position-relative overflow-auto"
							  style="border-radius: 10px;">
							  <div class="card-body table small table-orders">



								  <?php

								  echo '<div>';
								  echo '<div class="row mx-0" style="margin-bottom:5px; color: #909090; font-family: Inter; font-style: normal; font-weight: 400;">';
								  echo '<div class="col">Form Name</div>';
								  echo '<div class="col">Last Submission</div>';
								  echo '<div class="col">Views</div>';
								  echo '<div class="col">Submissions</div>';
								  echo '<div class="col">Conversion Rate</div>';
								  echo '</div>';

								  echo display_all_leads('Escrow Orders', 318301);
								  echo display_all_leads('Finance Applications', 337873);

								  echo '</div>';

								  function display_all_leads($formName, $form_id) {
									  global $wpdb;

									  // Total Submissions
									  $total_submissions = $wpdb->get_var(
										  $wpdb->prepare(
											  "SELECT COUNT(*) FROM wp_frmt_form_entry WHERE form_id = %d",
											  $form_id
										  )
									  );

									  // Last Submission Date
									  $last_submission = $wpdb->get_var(
										  $wpdb->prepare(
											  "SELECT MAX(date_created) FROM wp_frmt_form_entry WHERE form_id = %d",
											  $form_id
										  )
									  );

									  // Format the last submission date
									  $formatted_last_submission = $last_submission ? date('M d, Y @ g:i A', strtotime($last_submission)) : 'N/A';

									  // Total Views
									  $form_view = Forminator_Form_Views_Model::get_instance();
									  $total_views = $form_view->count_views($form_id);

									  // Conversion Rate
									  $conversion_rate = $total_views > 0 ? round(($total_submissions / $total_views) * 100, 2) : 0;

									  // Build the HTML output
									  $output = '<div class="row mx-0" style="font-size:12px; padding:10px 5px; margin-bottom:5px; border-radius: 6px;background: #F5F7FA;">';
									  $output .= '<div class="col">' . $formName . '</div>';
									  $output .= '<div class="col">' . $formatted_last_submission . '</div>';
									  $output .= '<div class="col">' . $total_views . '</div>';
									  $output .= '<div class="col">' . $total_submissions . '</div>';
									  $output .= '<div class="col">' . $conversion_rate . '%</div>';
									  $output .= '</div>';

									  return $output;
								  }

									  


								  ?>



							  </div><!-- Close Body -->

						  </div> <!-- New Leads block closed -->


					  </div><!-- col-12 closed -->


					  <div class="col-12 my-3 px-0 px-md-1">
						  <h6>Escrow Applications </h6>
						  <div class="bg-white shadow-sm p-3 mt-2" style="border-radius: 10px;">

							  <select class="form-control w-100 show-mobile hide-ipad hide-desktop mt-4"
								  onchange="showoffers(this.value);">

								  <option value="all"><?php echo __("All Vehicles", "premiumpress") ?></option>

								  <option value="4"><?php echo $escrow1; ?></option>
								  <option value="3"><?php echo $escrow2; ?></option>
								  <option value="2"><?php echo $escrow3; ?></option>
								  <option value="1"><?php echo $escrow4; ?></option>

							  </select>


							  <script>
							  function showoffers(type) {


								  jQuery('.collapse').removeClass('show');

								  jQuery('.card-job-1').hide();
								  jQuery('.card-job-2').hide();
								  jQuery('.card-job-3').hide();
								  jQuery('.card-job-4').hide();
								  jQuery('.card-job-finished').hide();

								  jQuery('.card-job-' + type).show();

								  if (type == "all") {

									  jQuery('.card-job-1').show();
									  jQuery('.card-job-2').show();
									  jQuery('.card-job-3').show();
									  jQuery('.card-job-4').show();
									  jQuery('.card-job-finished').show();
								  }

							  }

							  jQuery(document).ready(function() {




								  var allofferscount = parseFloat(jQuery('.job-finished').length) + parseFloat(
									  jQuery('.job-pending')
									  .length) + parseFloat(jQuery('.job-approved').length) + parseFloat(
									  jQuery('.job-rejected').length);

								  jQuery('#count-all').html(allofferscount);



								  var allofferscount = parseFloat(jQuery('.job-finished:not(.ownpost)').length) +
									  parseFloat(jQuery(
										  '.job-pending:not(.ownpost)').length) + parseFloat(jQuery(
										  '.job-approved:not(.ownpost)').length) +
									  parseFloat(jQuery('.job-rejected:not(.ownpost)').length);

								  jQuery('.count-all-offers').html(allofferscount);



								  var allmyofferscount = parseFloat(jQuery('.job-finished.ownpost').length) +
									  parseFloat(jQuery(
										  '.job-pending.ownpost').length) + parseFloat(jQuery(
										  '.job-approved.ownpost').length) + parseFloat(
										  jQuery('.job-rejected.ownpost').length);




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

											  <a href="javascript:void(0);" onclick="showoffers('all');"
												  class="nav-link py-3 text-black active" data-toggle="tab" role="tab">
												  <span>
													  <?php echo __("All Vehicles", "premiumpress") ?>
												  </span>


											  </a>

										  </li>


										  <li class="nav-item"> <a href="javascript:void(0);" onclick="showoffers(4);"
												  class="nav-link py-3 text-black  showoffers-4-btn" data-toggle="tab"
												  role="tab"> <span><?php echo $escrow1; ?></span> </a> </li>


										  <li class="nav-item"> <a href="javascript:void(0);" onclick="showoffers(3);"
												  class="nav-link py-3 text-black  showoffers-3-btn" data-toggle="tab"
												  role="tab"> <span><?php echo $escrow2; ?></span> </a> </li>




										  <li class="nav-item"> <a href="javascript:void(0);" onclick="showoffers(2);"
												  class="nav-link py-3 text-black showoffers-2-btn" data-toggle="tab"
												  role="tab"> <span><?php echo $escrow3; ?></span> </a> </li>



										  <li class="nav-item"> <a href="javascript:void(0);"
												  onclick="showoffers('finished');" class="nav-link py-3 text-black "
												  data-toggle="tab" role="tab"> <span>
													  <?php echo __("In Transit", "premiumpress") ?></span> </a> </li>


									  </ul>

								  </div>
							  </div> <!-- tab-panel close -->


							  <div class="tab-content pb-4 border-0 px-0">
								  <div id="accordion">



									  <div class="position-relative">


										  <?php if($escrows){ ?>
										  <div class="overflow-auto ">
											  <div class="table small table-orders">
												  <div>
													  <div class="col-12 row my-3">
														  <div class="col pl-2" style="border-radius:10px 0 0 0;">
															  <?php echo __("Seller", "premiumpress"); ?>
														  </div>
														  <div class="col text-left">
															  <?php echo __("Vehicle", "premiumpress"); ?>
														  </div>
														  <div class="col text-left">
															  <?php echo __("Created", "premiumpress"); ?>
														  </div>
														  <div class="col text-left dashhideme">
															  <?php echo __("Amount", "premiumpress"); ?>
														  </div>
														  <div class="col text-left dashhideme">
															  <?php echo __("Address", "premiumpress"); ?>
														  </div>
														  <div class="col text-center dashhideme"
															  style="border-radius:0 10px 0 0;">
															  <?php echo __("Status", "premiumpress"); ?>
														  </div>
													  </div>
												  </div>
												  <div>
													  <?php
													  // Loop through each finance entry
													  foreach ($escrows as $entry) {
														  $entry_id = $entry->entry_id;
														  
														  $seller_escrow_status = get_post_meta($entry_id, "seller_escrow_status", true);
														  
													  
														  
														  $buyer_escrow_status = get_post_meta($entry_id, "buyer_escrow_step_status", true);
														  
													  

														  // Fetch metadata for the entry
														  $meta = $wpdb->get_results(
															  $wpdb->prepare(
																  "SELECT meta_key, meta_value FROM {$wpdb->prefix}frmt_form_entry_meta WHERE entry_id = %d",
																  $entry_id
															  )
														  );

														  // Prepare metadata for easy access
														  $meta_data = [];
														  foreach ($meta as $m) {
															  $meta_data[$m->meta_key] = $m->meta_value;
														  }
													  ?>
													  <div
														  class='<?php if($seller_escrow_status["step"] >= 5 && $seller_escrow_status["status"] == "Approved" || $buyer_escrow_status["step"] >= 6 && $buyer_escrow_status["status"] == "Approved"){ ?> card-job-finished <?php }else if($buyer_escrow_status["step"] >= 2 && $buyer_escrow_status["status"] == "Approved"){ ?> card-job-4 <?php }else if($seller_escrow_status["step"] >= 3 && $seller_escrow_status["status"] == "Approved"){ ?> card-job-2 <?php }else if($seller_escrow_status["step"] < 5 || $buyer_escrow_status["step"] < 6){ ?> card-job-3 <?php }else{ ?>card-job-1 <?php } ?>'>

														  <a href="javascript:void(0)"
															  data-entry-id="<?php echo $entry->entry_id; ?>"
															  class="entry-link d-flex bg-light py-3 mb-2 escrow-row-<?php echo $entry_id; ?> text-decoration-none"
															  style="border-radius:8px;">
															  <div class="col font-10 text-dark pl-2">

																  <?php echo isset($meta_data['name-6']) ? esc_html($meta_data['name-6'] . ' ' . $meta_data['name-7']) : $meta_data['name-7']; ?>

															  </div>
															  <div class="col font-10 text-left text-dark">
																  <?php echo isset($meta_data['name-1']) ? esc_html($meta_data['name-1']) : ''; ?><br>
																  <?php echo isset($meta_data['text-11']) ? esc_html($meta_data['text-11']) : ''; ?>
															  </div>
															  <div class="col font-10 text-left text-dark">
																  <?php echo esc_html(hook_date($entry->date_created)); ?>
															  </div>
															  <div class="col font-10 text-left text-dark">
																  <?php echo isset($meta_data['currency-1']) ? esc_html(hook_price($meta_data['currency-1'])) : ''; ?>
															  </div>

															  <div class="col font-10 text-left text-dark small">
																  P:
																  <?php echo isset($meta_data['text-14']) ? esc_html($meta_data['text-14']) : ''; ?><br>
																  D:
																  <?php echo isset($meta_data['text-15']) ? esc_html($meta_data['text-15']) : ''; ?>
															  </div>

															  <div
																  class="col font-10 d-flex align-items-center justify-content-center">

																  <?php if($seller_escrow_status["step"] == 5 || $buyer_escrow_status["step"] == 6){ ?>
																  <span
																	  class="turbo-danger rounded-pill">
																	  <i class="fas fa-circle small"></i> Closed
																  </span>
																  <?php }else if($seller_escrow_status["step"] < 5 && $seller_escrow_status["step"] > 1 || $buyer_escrow_status["step"] < 6 && $buyer_escrow_status["step"] > 1 ){   ?>
																  <span
																	  class="turbo-success rounded-pill">
																	  <i class="fas fa-circle small"></i> Open
																  </span>
																  <?php }else{ ?>
																  <span
																	  class="turbo-warning rounded-pill">
																	  <i class="fas fa-circle small"></i> Pending
																  </span>
																  <?php } ?>
															  </div>
														  </a>
													  </div>
													  <?php } // End of foreach loop ?>
												  </div>
											  </div>
										  </div>
										  <?php } else { ?>
										  <div class="d-flex align-items-center mt-3"> <small
												  class="text-primary small">Get started, our process takes less than 5
												  minutes </small></div>
										  <span>We utilize Trbo Swift’s AI-driven damage inspection for escrow, including
											  inspections at vehicle pickup.</span>

										  <div class="mt-5">
											  <button class="btn btn-outline-secondary rounded-pill px-3"
												  id="financing-step-back">
												  Learn more</button>
											  <button class="btn btn-secondary rounded-pill px-3"
												  id="financing-step-next">Start Escrow</button>

										  </div>


										  <?php } ?>

									  </div>


									  <!--  block close -->




								  </div>
							  </div><!-- tab-content close -->


						  </div>
					  </div>
					  <!-- Escrow block close -->




					  <div class="col-12 my-3 p-0">
						  <h6>Finance Applications</h6>
						  <div class="bg-white shadow-sm p-3 mt-2" style="border-radius: 10px;">





							  <div class="position-relative">


								  <?php if($finances){ ?>
								  <div class="overflow-auto ">
									  <div class="table small table-orders">
										  <div>
											  <div class="col-12 row my-3">
												  <div class="col pl-2" style="border-radius:10px 0 0 0;">
													  <?php echo __("Applicants", "premiumpress"); ?>
												  </div>
												  <div class="col text-left">
													  <?php echo __("Vehicle", "premiumpress"); ?>
												  </div>
												  <div class="col text-left">
													  <?php echo __("Created", "premiumpress"); ?>
												  </div>
												  <div class="col text-left dashhideme">
													  <?php echo __("Purchase Amount", "premiumpress"); ?>
												  </div>
												  <div class="col text-left dashhideme">
													  <?php echo __("Address", "premiumpress"); ?>
												  </div>
												  <div class="col text-center dashhideme" style="border-radius:0 0 0 0;">
													  <?php echo __("Status", "premiumpress"); ?>
												  </div>
												  <div class="col text-left dashhideme"
													  style="border-radius:0 10px 0 0;">

												  </div>
												  
											  </div>
										  </div>
										  <div>
											  <?php
											  // Loop through each finance entry
											  foreach ($finances as $entry) {
												  $entry_id = $entry->entry_id;
												  
												  $finance_step_status = get_post_meta($entry_id, "finance_step_status", true);
												  
											  

												  // Fetch metadata for the entry
												  $meta = $wpdb->get_results(
													  $wpdb->prepare(
														  "SELECT meta_key, meta_value FROM {$wpdb->prefix}frmt_form_entry_meta WHERE entry_id = %d",
														  $entry_id
													  )
												  );

												  // Prepare metadata for easy access
												  $meta_data = [];
												  foreach ($meta as $m) {
													  $meta_data[$m->meta_key] = $m->meta_value;
												  }
											  ?>
											  <div
												  class='<?php if($finance_step_status["step"] >= 5 && $finance_step_status["status"] == "Approved"){ ?> finance-finished <?php }else if($finance_step_status["step"] >= 2 && $finance_step_status["status"] == "Approved"){ ?> finance-approved <?php }else if($finance_step_status["step"] >= 3 && $finance_step_status["status"] == "Approved"){ ?> finance-verified <?php }else if($finance_step_status["step"] < 5){ ?> finance-pending <?php }else{ ?> finance-start <?php } ?>'>

												  <div class="finance-link d-flex bg-light py-3 mb-2 finance-row-<?php echo $entry_id; ?> text-decoration-none"
													  style="border-radius:8px;">
													  <div class="col font-10 text-dark pl-2">

														  <?php echo isset($meta_data['name-1']) ? esc_html($meta_data['name-1'] . ' ' . $meta_data['name-2']) : $meta_data['name-2']; ?>

													  </div>
													  <div class="col font-10 text-left text-dark">
														  <?php 
														  echo isset($meta_data['select-1']) 
															  ? esc_html($meta_data['select-1'] . ' ' . $meta_data['text-14'] . ' ' . $meta_data['select-2']) 
															  : ''; 
														  ?>
													  </div>

													  <div class="col font-10 text-left text-muted text-dark">
														  <?php echo esc_html(hook_date($entry->date_created)); ?>
													  </div>


													  <div class="col font-10 text-left text-dark">
														  <?php echo isset($meta_data['currency-2']) ? esc_html(hook_price($meta_data['currency-2'])) : '';?>

													  </div>

													  <div class="col font-10 text-left text-dark small">
														  <?php echo isset($meta_data['text-15']) ? esc_html($meta_data['text-15']) : ''; ?>

													  </div>

													  <div class="col font-10 d-flex align-items-center justify-content-center">

														  <?php if($finance_step_status["step"] == 6){ ?>
														  <span class="turbo-danger rounded-pill">
															  <i class="fas fa-circle small"></i> Closed
														  </span>
														  <?php }else if( $finance_step_status["step"] < 6 && $finance_step_status["step"] > 1 ){   ?>
														  <span
															  class="turbo-success rounded-pill">
															  <i class="fas fa-circle small"></i> Open
														  </span>
														  <?php }else{ ?>
														  <span class="turbo-warning rounded-pill">
															  <i class="fas fa-circle small"></i> Pending
														  </span>
														  <?php } ?>
													  </div>

													  <div class="col font-10 d-flex align-items-center justify-content-center">
														  
														  <div class="dropdown-menu z-index show p-0 border-0 d-flex bg-light" style="margin-top: -36px; z-index: 1;">
														  <a class="dropdown-item status" href="javascript:void(0)" data-status-name="Delete" data-step-no="6" data-entry-id="<?php echo $entry_id; ?>"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delete.svg" style="width:14px;">
														  </a>
														  <a data-entry-id="<?php echo $entry_id; ?>" data-user-id="<?php echo $user_id; ?>" class="deal-entry-link dropdown-item" href="javascript:void(0)">
															  <i
																  class="fas fa-edit"></i>
														  </a>
														  </div>
														  

														  
													  </div>

												  </div><!-- row closed -->
											  </div>
											  <?php } // End of foreach loop ?>
										  </div>
									  </div>
								  </div>
								  <?php } else { ?>

								  <span>We have exclusive partnerships with some of Canada’s largest lenders to get your
									  best-in-market rates.</span>

								  <div class="mt-5">
									  <button class="btn btn-outline-secondary rounded-pill px-3"
										  id="financing-step-back">
										  Learn more</button>
									  <button class="btn btn-secondary rounded-pill px-3" id="financing-step-next">Apply
										  for financing</button>

								  </div>


								  <?php } ?>

							  </div>


							  <!--  block close -->





						  </div>
					  </div>
					  <!-- Finance block close -->





				  </div>

			  </div>

		  </div>

	  */ ?>
		<!-- Content close -->



		<div id="list-item-escrow" style="display: none;" class="col-12">
			<?php _ppt_template('framework/design/account/account-escrow'); ?>
		</div>

		<div id="list-item-users" style="display: none;" class="col-12">
			<?php _ppt_template('framework/design/account/dealer-users'); ?>
		</div>

		<div id="list-item-finance" style="display: none;" class="col-12">
			<?php _ppt_template('framework/design/account/account-financing'); ?>
		</div>

		<div id="list-item-pending-deals" class="col-12 p-0">

			<h5>Finance Dashboard</h5>



			<div>
				<div id="showDealsQuickInfoInCards" class="d-flex flex-wrap">
					<?php $i = 1;
					while ($i <= 7) { ?>
						<div class="col-6 col-md mb-2 p-1">
							<div class="p-2 d-flex flex-column justify-content-between position-relative" style="border-radius: 15.678px;
background: linear-gradient(180deg, #3B634C 0%, #2C4235 100%); overflow:hidden; min-height: 164px;">


								<div class="p-2 position-absolute"
									style="right:10px; top:10px;  width:30.04px; height:30.04px; border-radius: 8px; display:flex; justify-content:center;align-items:center; background: #fff">
									<img src="<?php echo $pending_deal_tabs[$i]['icon'] ?>" style=" width: 180%;" />
								</div>
								<div class="border-bottom">
									<h3 class="text-white mb-2"><?php echo $pending_deal_tabs[$i]['value']; ?></h3>

									<span class="text-white my-1 small"><?php echo $pending_deal_tabs[$i]['name']; ?></span>
								</div>

								<div class="deal-tabs-info">


									<?php if ($i == 1) { ?>
										<div class="d-flex align-items-center my-1">
											<span
												class="badge bg-white text-primary small mr-1"><?php echo $pending_deal_tabs[$i]['views'] ?></span>
											<span class="text-white" style="font-size: 12px;">
												<?php echo $pending_deal_tabs[$i]['view_label'] ?>
											</span>
										</div>
										<div class="d-flex align-items-center my-1">
											<span
												class="badge bg-white text-primary mr-1"><?php echo $pending_deal_tabs[$i]['submit_count'] ?></span>
											<span class="text-white small" style="font-size: 12px;">
												<?php echo $pending_deal_tabs[$i]['submit_label'] ?>
											</span>
										</div>

									<?php } elseif ($i == 2) { ?>

										<div class="d-flex align-items-center my-1">
											<span
												class="badge bg-white text-primary mr-1"><?php echo $pending_deal_tabs[$i]['decision'] ?></span>
											<span class="text-white small" style="font-size: 10px;">
												<?php echo $pending_deal_tabs[$i]['decision_label'] ?>
											</span>
										</div>


									<?php } elseif ($i == 3) { ?>

										<div class="d-flex align-items-center my-1">
											<span
												class="badge bg-white text-primary mr-1"><?php echo $pending_deal_tabs[$i]['pending_kyc'] ?></span>
											<span class="text-white small" style="font-size: 12px;">
												<?php echo $pending_deal_tabs[$i]['pending_kyc_label'] ?>
											</span>
										</div>
										<div class="d-flex align-items-center my-1">
											<span
												class="badge bg-white text-primary mr-1"><?php echo $pending_deal_tabs[$i]['completed_kyc'] ?></span>
											<span class="text-white small" style="font-size: 12px;">
												<?php echo $pending_deal_tabs[$i]['completed_kyc_label'] ?>
											</span>
										</div>


									<?php } elseif ($i == 4) { ?>

										<div class="d-flex align-items-center my-1">
											<span
												class="badge bg-white text-primary mr-1"><?php echo $pending_deal_tabs[$i]['pending_paperwork'] ?></span>
											<span class="text-white small" style="font-size: 12px;">
												<?php echo $pending_deal_tabs[$i]['pending_paperwork_label'] ?>
											</span>
										</div>


									<?php } elseif ($i == 5) { ?>

										<div class="d-flex align-items-center my-1">
											<span
												class="badge bg-white text-primary mr-1"><?php echo $pending_deal_tabs[$i]['vehicle_pick'] ?></span>
											<span class="text-white small" style="font-size: 12px;">
												<?php echo $pending_deal_tabs[$i]['vehicle_pick_label'] ?>
											</span>
										</div>

										<div class="d-flex align-items-center my-1">
											<span
												class="badge bg-white text-primary mr-1"><?php echo $pending_deal_tabs[$i]['vehicle_transport'] ?></span>
											<span class="text-white small" style="font-size: 12px;">
												<?php echo $pending_deal_tabs[$i]['vehicle_transport_label'] ?>
											</span>
										</div>


									<?php } elseif ($i == 6) { ?>

										<div class="d-flex align-items-center my-1">
											<span
												class="badge bg-white text-primary mr-1"><?php echo $pending_deal_tabs[$i]['value'] ?></span>
											<span class="text-white small" style="font-size: 12px;">
												<?php echo $pending_deal_tabs[$i]['disbursal_pick_label'] ?>
											</span>
										</div>

									<?php } elseif ($i == 7) { ?>
										<div class="d-flex align-items-center my-1">
											<span
												class="badge bg-white text-primary mr-1"><?php echo $pending_deal_tabs[$i]['bank_rejected'] ?></span>
											<span class="text-white small" style="font-size: 12px;">
												<?php echo $pending_deal_tabs[$i]['bank_rejected_label'] ?>
											</span>
										</div>

										<div class="d-flex align-items-center my-1">
											<span
												class="badge bg-white text-primary mr-1"><?php echo $pending_deal_tabs[$i]['customer_rejected'] ?></span>
											<span class="text-white small" style="font-size: 12px;">
												<?php echo $pending_deal_tabs[$i]['customer_rejected_label'] ?>
											</span>
										</div>

									<?php } ?>
								</div>

							</div>
						</div>
						<?php $i++;
					} ?>
				</div>
			</div>






			<div id="mainPendingDealsSection" class="bg-white position-relative radiusx p-2">


				<?php if ($deals) { ?>
					<div class="overflow-auto " style="min-height:700px">
						<div class="table small table-orders">
							<div>
								<div class="col-12 d-flex my-3">
									<div class="col-1 text-center " style="border-radius:10px 0 0 0;">
										<?php echo __("ID", "premiumpress"); ?>
									</div>
									<div class="col ">
										<?php echo __("Flag", "premiumpress"); ?>
									</div>
									<div class="col ">
										<?php echo __("Date", "premiumpress"); ?>
									</div>
									<div class="col ">
										<?php echo __("Dealer", "premiumpress"); ?>
									</div>
									<div class="col ">
										<?php echo __("Applicant", "premiumpress"); ?>
									</div>
									<div class="col ">
										<?php echo __("Vehicle VIN", "premiumpress"); ?>
									</div>
									<div class="col">
										<?php echo __("Action", "premiumpress"); ?>
									</div>

									<div class="col">
										<?php echo __("Dealer. Name", "premiumpress"); ?>
									</div>
									<div class="col">
										<?php echo __("Contact", "premiumpress"); ?>
									</div>
									<div class="col">
										<?php echo __("Status", "premiumpress"); ?>
									</div>
									<div class="col">

									</div>
								</div>
							</div>
							<div>
								<?php
								// Loop through each finance entry
								foreach ($deals as $entry) {
									$entry_id = $entry->entry_id;

									$finance_step_status = get_post_meta($entry_id, "finance_step_status", true);



									// Fetch metadata for the entry
									$meta = $wpdb->get_results(
										$wpdb->prepare(
											"SELECT meta_key, meta_value FROM {$wpdb->prefix}frmt_form_entry_meta WHERE entry_id = %d",
											$entry_id
										)
									);

									// Prepare metadata for easy access
									$meta_data = [];
									foreach ($meta as $m) {
										$meta_data[$m->meta_key] = $m->meta_value;
									}

									if ($finance_step_status["status"] != "Approved") {

										$user_email = isset($meta_data['email-1']) ? $meta_data['email-1'] : $meta_data['hidden-2'];

										$user = get_user_by('email', $user_email);

										if ($user) {
											$user_id = $user->ID;
										} else {
											$user_id = $$meta_data['hidden-3'];
										}



										?>
										<div
											class='<?php if ($finance_step_status["step"] >= 5 && $finance_step_status["status"] == "Approved") { ?> finance-finished <?php } else if ($finance_step_status["step"] >= 2 && $finance_step_status["status"] == "Approved") { ?> finance-approved <?php } else if ($finance_step_status["step"] >= 3 && $finance_step_status["status"] == "Approved") { ?> finance-verified <?php } else if ($finance_step_status["step"] < 5) { ?> finance-pending <?php } else { ?> finance-start <?php } ?>'>

											<div class="col-12 d-flex bg-light py-3 mb-2 deal-row-<?php echo $entry_id; ?> text-decoration-none"
												style="border-radius:8px;">
												<div class="col-1 text-center">
													<a href="javascript:void(0)" data-entry-id="<?php echo $entry->entry_id; ?>"
														data-user-id="<?php echo $user_id; ?>" class="deal-entry-link text-dark">

														<?php echo $entry_id; ?><br> <i
															class="fas fa-exclamation-triangle text-primary opacity-5"></i>

													</a>
												</div>


												<div class="col flag-<?php echo $entry_id; ?>">
													<!-- Flag details -->
													<div class="d-flex align-items-center text-danger font-weight-bold"><span>HIGH
														</span><i class="fas fa-flag ml-2"></i></div>



												</div>

												<div class="col overflow-auto text-muted ">
													<?php echo esc_html(hook_date($entry->date_created)); ?>
												</div>

												<div class="col overflow-auto">
													<?php echo isset($meta_data['name-1']) ? esc_html($meta_data['name-1'] . ' ' . $meta_data['name-2']) : $meta_data['name-2']; ?>
												</div>

												<div class="col overflow-auto">
													<?php echo isset($meta_data['name-1']) ? esc_html($meta_data['name-1'] . ' ' . $meta_data['name-2']) : $meta_data['name-2']; ?>
												</div>

												<div class="col font-10 overflow-auto">
													<?php echo esc_html($meta_data['text-13']); ?>
												</div>




												<div class="col overflow-auto">
													<!-- action -->
													<button data-entry-id="<?php echo $entry->entry_id; ?>"
														data-user-id="<?php echo $user_id; ?>"
														class="deal-entry-link btn btn-secondary rounded-pill px-3 py-1"
														style="font-size:12px">View</button>
												</div>

												<div class="col overflow-auto">
													<?php echo isset($meta_data['name-1']) ? esc_html($meta_data['name-1'] . ' ' . $meta_data['name-2']) : $meta_data['name-2']; ?><br />
													<?php echo isset($meta_data['phone-1']) ? esc_html($meta_data['phone-1']) : ''; ?>
												</div>

												<div class="col  overflow-auto">
													<?php echo isset($meta_data['email-1']) ? esc_html($meta_data['email-1']) : ' '; ?><br />
													<?php echo isset($meta_data['phone-2']) ? esc_html($meta_data['phone-2']) : ''; ?>
												</div>

												<div class="col d-flex justify-content-center">
													<div style="text-align:center">
														<?php if ($finance_step_status["step"] >= 5) { ?>
															<button class="turbo-success font-8 rounded-pill">
																<i class="fas fa-circle small"></i> Closed
															</button>
														<?php } else if ($finance_step_status["step"] < 5 && $finance_step_status["step"] > 1) { ?>
																<button class="turbo-warning font-8 rounded-pill">
																	<i class="fas fa-circle small"></i> Awaiting
																</button>
														<?php } else { ?>
																<button class="turbo-danger font-8 rounded-pill">
																	<i class="fas fa-circle small"></i> Pending
																</button>
														<?php } ?>
													</div>

												</div>

												<div class="col text-right">

													<div class="dropdown">
														<button class="btn btn-light dropdown-toggle" type="button"
															data-toggle="dropdown" aria-expanded="false">
															<i class="fa-solid fa-ellipsis-vertical"></i>
														</button>


														<div class="dropdown-menu z-index">
															<a class="dropdown-item " href="#">
																<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/dollerbadge.svg"
																	style="width:14px;" />

																Awaiting</a>
															<a class="dropdown-item" href="#"><img
																	src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/checkmark.svg"
																	style="width:14px;" />
																Approved</a>
															<a class="dropdown-item" href="#"><img
																	src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/job.svg"
																	style="width:14px;" />
																Paperwork</a>
															<a class="dropdown-item" href="#"><img
																	src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
																	style="width:14px;" />
																Delivery</a>
															<a class="dropdown-item" href="#"><img
																	src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/hand.svg"
																	style="width:14px;" />
																Disbursement</a>
															<a class="dropdown-item" href="#"><img
																	src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delete.svg"
																	style="width:14px;" />
																Delete Application</a>
														</div>
													</div>


												</div>

											</div><!-- row closed -->
										</div>
									<?php }
								} // End of foreach loop ?>
							</div>
						</div>
					</div>
				<?php } else { ?>

					<span>We have exclusive partnerships with some of Canada’s largest lenders to get your
						best-in-market rates.</span>

					<div class="mt-5">
						<button class="btn btn-outline-secondary rounded-pill px-3" id="financing-step-back">
							Learn more</button>
						<button class="btn btn-secondary rounded-pill px-3" id="financing-step-next">New Deal</button>

					</div>


				<?php } ?>

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

			<div class="col-md-12 pl-0">
				<div class="custom-card">
					<div class="shipping-content">
						<h5>
							Trbo Swift Transportation
						</h5>
						<span class="text-primary">Canada-wide delivery with Trbo Swift
							Auctions</span><br>
						<span>Trbo Swift Transport provides top-tier automotive transportation
							services
							nationwide. Receive a quote from our insured partners for all your
							vehicle
							transport needs.</span>
						<div>
							<div class="d-flex my-2">
								<i class="fas fa-check-circle text-success h3"></i><span class="ml-2">Book
									and Pay
									online</span>
							</div>
							<div class="d-flex my-2">
								<i class="fas fa-check-circle text-success h3"></i><span class="ml-2">Fully
									Insured
									fleet of
									transport drivers</span>
							</div>
							<div class="d-flex my-2">
								<i class="fas fa-check-circle text-success h3"></i><span class="ml-2">Trbo Swift
									Transport
									Tracking & Assistance</span>
							</div>
						</div>

						<div class="d-flex my-3">
							<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/noto_airplane.svg"
								style="width:60px; height:60px;" alt="" class="mr-2">
							<span class="text-dark">Need to ship internationally? Trbo Swift offers
								both
								air
								freight services and shipping container options. For more
								information,
								please email us at <a href="mailto:transport@trboswift.ca"
									class="text-black">transport@trboswift.ca</a> .</span>
						</div>
					</div>

					<div class="card-body p-0 shipping-transaction-" bis_skin_checked="1">
						<h5>Transaction</h5>
						<div class="overflow-auto" bis_skin_checked="1">
							<table class="table small table-orders">
								<thead>
									<tr>
										<th class="text-start bg-primary text-white " style="border-radius:20px 0 0 0;">
											Invoice</th>
										<th class="text-start bg-primary text-white ">Vehicle
										</th>
										<th class="text-start  bg-primary text-white">Pick up</th>
										<th class="text-start bg-primary text-white dashhideme">
											Destination
										</th>
										<th class="text-end text-white  bg-primary  dashhideme"
											style="border-radius:0 20px 0 0;">Amount</th>
									</tr>
								</thead>
								<tbody class="bg-white text-dark">
									<tr class="row-59 d-none">
										<td class="d-flex">
											<span class="doc-id text-dark">#2456178</span>
										</td>
										<td class="text-start text-dark">
											<div class="d-flex flex-column">
												<span class="doc-name text-dark">Tesla Model 3
												</span>
												<span class="small pt-1" style="color:#909090">SAJBP2FV1JCY66780</span>
											</div>
										</td>
										<td class="text-center text-muted text-dark">
											<span>Jul 07,2024</span>

										</td>
										<td class="text-start text-dark">
											<span>
												Montrear
											</span>
										</td>
										<td class="text-start">
											<div class="d-flex flex-column">
												<span class="doc-name text-dark">$600
												</span>
												<span class="small pt-1" style="color:#909090">CAD</span>
											</div>
										</td>

									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

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
				<li class="nav-item" role="presentation">
					<a class="deal-tab " id="pills-client-chat-tab" data-toggle="pill" data-target="#pills-client-chat"
						type="button" role="tab" aria-controls="pills-client-chat" aria-selected="false">Client Deal</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="deal-tab " id="pills-notes-tab" data-toggle="pill" data-target="#pills-notes"
						type="button" role="tab" aria-controls="pills-notes" aria-selected="false">Notes</a>
				</li>
				<!-- <li class="nav-item" role="presentation">
					<a class="deal-tab " id="pills-deals-tab" data-toggle="pill" data-target="#pills-deals"
						type="button" role="tab" aria-controls="pills-deals" aria-selected="false">Deals</a>
				</li> -->

				<li class="nav-item" role="presentation">
					<a class="deal-tab " id="pills-documents-tab" data-toggle="pill" data-target="#pills-documents"
						type="button" role="tab" aria-controls="pills-documents" aria-selected="false">Documents</a>
				</li>
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
						type="button" role="tab" aria-controls="pills-bill-sale" aria-selected="false">Bill of Sale</a>
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
				<!-- <li class="nav-item" role="presentation">
					<a class="deal-tab " id="pills-vendor-info-tab" data-toggle="pill" data-target="#pills-vendor-info"
						type="button" role="tab" aria-controls="pills-vendor-info" aria-selected="false">Vendor</a>
				</li> -->
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
								<h2 class="applicant-title">Client Deal- Approval Details</h2>
								<div class="applicant-actions"><button onClick="updateDealInformation();"
										class="btn update-btn px-5 py-2">Update</button> <button
										class="send-kyc-btn btn btn-primary px-3 py-2 rounded-pill">Send KYC
										Request</button></div>
							</div>
						</div>
						<div class="d-flex text-white" style="gap:10px;">
							<div class="text-end">
								<p class="heading-vendor-name text-white">Vendor: <strong>Cruze Auto Sales INC</strong>
								</p>
								<p class="trim-plan manager-info">Manager: <strong>Trbo Swift Financial</strong></p>
							</div>
							<p class="heading-deal-id">Deal #7542</p>
						</div>
					</section>



					<section class="user-info-card mb-2">
						<div class="d-flex flex-column flex-md-row user-info-container">
							<div class="col-12 col-md-8 user-details-column">
								<div class="info-group">
									<div class="form-row">
										<div class="form-group col-12 col-md-4">
											<label for="firstName" class="field-label">First Name</label>
											<input id="firstName" class="form-control" type="text" value="">
										</div>

										<div class="form-group col-12 col-md-4">
											<label for="middleName" class="field-label">Middle Name</label>
											<input id="middleName" class="form-control" type="text" value="">
										</div>

										<div class="form-group col-12 col-md-4">
											<label for="lastName" class="field-label">Last Name</label>
											<input id="lastName" class="form-control" type="text" value="">
										</div>

									</div>
								</div>
								<div class="info-group">
									<div class="form-row">
										<div class="form-group col-12 col-md-4">
											<label for="dob" class="field-label">Date of Birth (MM/DD/YY)</label>
											<input id="dob" class="form-control" type="date" value="">
										</div>


										<div class="form-group col-12 col-md-4  ">
											<label for="streetAddress" class="field-label">Street Address</label>
											<input id="streetAddress" class="form-control" type="text" value="">
										</div>
										<div class="form-group col-12 col-md-4">
											<label for="city" class="field-label">City</label>
											<input id="city" class="form-control" type="text" value="">
										</div>
									</div>
								</div>
								<div class="info-group">
									<div class="form-row">
										<div class="form-group col-12 col-md-4">
											<label for="province" class="field-label">Province</label>
											<select type="text" id="vendor-province"
												class="form-control rounded-pill vendor-province">

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
										<div class="form-group col-12 col-md-4">
											<label for="postalCode" class="field-label">Postal Code</label>
											<input id="postalCode" class="form-control" type="text" value="">
										</div>

										<div class="residence-type-group">
											<fieldset>
												<span>Residence Type</span>
												<div class="residence-type-option">
													<div class="form-check  d-flex align-items-center">
														<input type="radio" name="residenceType"
															class="form-check-input residence-type-rent"><label>
															Rent</label>
													</div>
													<div class="form-check d-flex align-items-center">
														<input type="radio" name="residenceType" value="own"
															class="form-check-input residence-type-own"><label>
															Own</label>
													</div>
													<div class="form-check d-flex align-items-center">
														<input type="radio" name="residenceType"
															value="Live with Parents"
															class="form-check-input residence-type-live-parents"><label>Live
															with Parents</label>
													</div>
												</div>

											</fieldset>
										</div>

									</div>
								</div>

								<div class="info-group">
									<div class="form-row">
										<div class="form-group col-12 col-md-4">
											<label for="timeAtAddress" class="field-label">Time at Address</label>
											<input id="timeAtAddress" class="form-control" type="text" value="">
										</div>
										<div class="form-group col-12 col-md-4">
											<label for="monthlyPayment" class="field-label">Monthly Payment</label>
											<input id="monthlyPayment" class="form-control" type="text" value="">
										</div>
										<div class="form-group col-12 col-md-4">
											<label for="mortgageHolder" class="field-label">Mortgage Holder</label>
											<input id="mortgageHolder" class="form-control" type="text" value="">
										</div>
									</div>
								</div>
								<div class="info-group">
									<div class="form-row">
										<div class="form-group col-12 col-md-4">
											<label for="previousAddress" class="field-label">Previous Street Address (if
												less than 2 years)</label>
											<input id="previousAddress" class="form-control" type="text" value="">
										</div>
										<div class="form-group col-12 col-md-4">
											<label for="previousCity" class="field-label">City</label>
											<input id="previousCity" class="form-control" type="text" value="">
										</div>
										<div class="form-group col-12 col-md-4">
											<label for="previousProvince" class="field-label">Province</label>
											<select type="text" id="previousProvince"
												class="form-control rounded-pill vendor-province">

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
									</div>
								</div>
								<div class="info-group">
									<div class="form-row">
										<div class="form-group col-12 col-md-4">
											<label for="previousPostalCode" class="field-label">Postal Code</label>
											<input id="previousPostalCode" class="form-control" type="text" value="">
										</div>
										<div class="form-group col-12 col-md-4">
											<label for="email" class="field-label">E-mail Address</label>
											<input id="email" class="form-control" type="email" value="">
										</div>
										<div class="form-group col-12 col-md-4">
											<label for="primaryPhone" class="field-label">Primary Phone Number</label>
											<input id="primaryPhone" class="form-control" type="tel" value="">
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-4 license-image-column">

								<div class="d-flex flex-wrap py-3" id="documentProofPreviewContainer">
									<div class="col-12 px-0">
										<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/image-144.png"
											style="width:100%; height:100%;" />
									</div>
								</div>

								<div class="custom-file-drop" id="documentProofDropArea">
									<!-- <p>Upload document or image</p> -->
									<img
										src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/Group-1321315199.svg" /><br>
									<span class="small">Upload documents or images.</span>
									<br>

									<div class="text-center my-2">
										<button class="upload-proof-btn btn btn-outline-primary px-2 py-1"
											style="width: 130px; font-size: 12px;">Browse</button><br>
										<button onClick="checkOnClick();" class="btn btn-outline-primary px-2 py-1 mt-2"
											style="width: 130px; font-size: 12px; z-index:11">Request
											DL</button>
									</div>

									<input type="file" name="file" id="documentProofFileInput" style="display: none;">
								</div>

							</div>
						</div>


					</section>



					<div class="applicant-card employment-info">
						<div class="applicant-header">
							<div class="applicant-info">
								<h2 class="applicant-title">Previous Address </h2>

							</div>

						</div>

					</div>




					<section class="previousAddressSection custom-card">



						<div class="form-row">
							<div class="form-group col-12 col-md-4  ">
								<label for="previousAddress" class="field-label">Address</label>
								<input id="previousAddress" class="form-control  googleAutoLocation" type="text"
									value="${meta['text-21'] || '' }">
							</div>

							<div class="form-group col-12 col-md-4  ">
								<label for="previousAddress2" class="field-label">Address 2</label>
								<input id="previousAddress2" class="form-control  googleAutoLocation" type="text"
									value="${meta['a-p-address'] || '' }">
							</div>

							<div class="form-group col-12 col-md-4">
								<label for="previousPostalCode" class="field-label">Postal Code</label>
								<input id="previousPostalCode" class="form-control" type="text"
									value="${meta['text-23'] || '' }">
							</div>


						</div>

						<div class="form-row">
							<div class="form-group col-12 col-md-4">
								<label for="previousCity" class="field-label">City</label>
								<input id="previousCity" class="text-22 form-control" type="text"
									value="${meta['text-22'] || '' }">
							</div>

							<div class="form-group col-12 col-md-4">
								<label for="previousProvince" class="field-label">Province</label>
								<select type="text" id="previousProvince"
									class="form-control rounded-pill vendor-province">

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



							<div class="form-group col-12 col-md-2">
								<label for="yearAtATime" class="field-label">Years</label>
								<input id="yearAtATime" class="form-control" type="text"
									value="${meta['text-6'] || '' }">
							</div>

							<div class="form-group col-12 col-md-2">
								<label for="timeAtAddress" class="field-label">Months</label>
								<input id="timeAtAddress" class="form-control" type="text"
									value="${meta['text-7'] || '' }">
							</div>


						</div>


					</section>




					<section class="applicant-card employment-info">
						<div class="applicant-header">
							<div class="applicant-info">
								<h2 class="applicant-title">Employment Information</h2>
								<div class="d-flex align-items-center" style="gap:10px">
									<button onClick="updateDealInformation();"
										class="btn update-button employment-info-update-btn">Update</button>
									<div class="status-container">
										<span class="status-label">Status: </span>
										<span class="status-value text-white">Verified <i
												class="fas fa-check-circle"></i></span>
									</div>
								</div>
							</div>

						</div>

					</section>



					<section id="employmentInformation" class="custom-card">

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
								<label for="province" class="info-label">Province</label>
								<select type="text" id="province" class="form-control current-employer">

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
								<input type="text" id="postal-code" class="form-control current-employer">
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-9">
								<span>Employment Type</span>
								<div class="residence-type-option">
									<div class="form-check  d-flex align-items-center">
										<input class="form-check-input" type="radio" id="full-time" value="Full time"
											name="employment-type" checked>
										<label for="full-time">Full time</label>
									</div>
									<div class="form-check  d-flex align-items-center">
										<input class="form-check-input" type="radio" id="part-time" value="Part time"
											name="employment-type">
										<label for="part-time">Part time</label>
									</div>
									<div class="form-check  d-flex align-items-center">
										<input class="form-check-input" type="radio" id="contract" value="Contract"
											name="employment-type">
										<label for="contract">Contract</label>
									</div>
									<div class="form-check  d-flex align-items-center">
										<input class="form-check-input" type="radio" id="seasonal" value="Seasonal"
											name="employment-type">
										<label for="seasonal">Seasonal</label>
									</div>
									<div class="form-check  d-flex align-items-center">
										<input class="form-check-input" type="radio" id="retired" value="Retired"
											name="employment-type">
										<label for="retired">Retired</label>
									</div>

								</div>
							</div>
							<div class="form-group col-md-3">
								<label for="gross-monthly-income" class="info-label">Gross Monthly Income</label>
								<input type="text" id="gross-monthly-income" class="form-control current-employer"
									value="">
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-3">
								<label for="previous-employer" class="info-label">Previous Employer</label>
								<input type="text" id="previous-employer" class="form-control previous-employer-name">
							</div>
							<div class="form-group col-md-3">
								<label for="previous-position" class="info-label">Previous Position</label>
								<input id="previous-position" class="form-control previous-employer" type="text">
							</div>
							<div class="form-group col-md-3">
								<label for="previous-time" class="info-label">Time at Employer</label>
								<input id="previous-time" class="form-control previous-employer" type="text">
							</div>
							<div class="form-group col-md-3">
								<label for="other-income" class="info-label">Other Monthly Income</label>
								<input id="other-income" class="form-control previous-employer" type="text">
							</div>

						</div>

					</section>




					<!-- Housing -->

					<section class="applicant-card co-employment-info">
						<div class="applicant-header">
							<div class="applicant-info">
								<h2 class="applicant-title">Housing</h2>

							</div>
						</div>
					</section>


					<section class="custom-card applicant-housing">

						<div class="form-row">
							<div class="form-group col-md-4">
								<label for="homeStatus" class="info-label">Home Status</label>
								<select type="text" id="homeStatus" class="form-control current-employer">

									<option>Own with Mortgage</option>
									<option>Own Free & Clear
									</option>
									<option>Own Mobile Home
									</option>
									<option>Rent
									</option>
									<option>With Parents
									</option>
									<option>Reserve Housing
									</option>
									<option>Other
									</option>

								</select>
							</div>

							<div class="form-group col-md-4">
								<label for="mortageHolder" class="info-label">Mortage Holder</label>
								<input type="text" id="mortageHolder" class="form-control current-employer" value="">
							</div>
							<div class="form-group col-md-4">
								<label for="monthlyHousingPayment" class="info-label">Monthly Housing Payment</label>
								<input type="text" id="monthlyHousingPayment" class="form-control current-employer"
									value="">
							</div>
							<div class="form-group col-md-4">
								<label for="marketValue" class="info-label">Market Value</label>
								<input type="text" id="marketValue" class="form-control current-employer" value="">
							</div>
							<div class="form-group col-md-4">
								<label for="mortagePayment" class="info-label">Mortage Payment</label>
								<input type="text" id="mortagePayment" class="form-control current-employer" value="">
							</div>
							<div class="form-group col-md-4">
								<label for="additionalInfo" class="info-label">Additional Info</label>
								<input type="text" id="additionalInfo" class="form-control current-employer" value="">
							</div>

						</div>

					</section>




					<!-- Other Income  -->

					<section class="applicant-card co-employment-info">
						<div class="applicant-header">
							<div class="applicant-info">
								<h2 class="applicant-title">Other Income</h2>

							</div>
						</div>
					</section>


					<section class="custom-card applicant-other-income">

						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="otherIncomeAmount" class="price-label">Other Income Amount</label>
								<div class="input-group ">
									<div class="input-group-prepend">
										<span class="input-group-text"
											style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
									</div>
									<input type="text" id="otherIncomeAmount" class="form-control">

								</div>
							</div>
							<div class="form-group col-md-6">
								<label for="otherIncomeFrequency" class="info-label">Other Income Frequency</label>
								<select type="text" id="otherIncomeFrequency" class="form-control current-employer">

									<option>Year</option>
									<option>Month</option>
									<option>Week</option>

								</select>
							</div>

							<div class="form-group col-md-6">
								<label for="otherIncomeType" class="info-label">Other Income Type</label>
								<select type="text" id="otherIncomeType" class="form-control current-employer">

									<option>Lump-sum payments</option>
									<option>Retiring allowance</option>
									<option>Death benefits (other than CPP or QPP death benefits)</option>

								</select>
							</div>

							<div class="form-group col-md-6">
								<label for="otherIncomeDescription" class="info-label"> Other Income Description</label>
								<input type="text" id="otherIncomeDescription" class="form-control current-employer"
									value="">
							</div>
						</div>

					</section>



					<!-- Other Income  -->

					<section class="applicant-card co-employment-info">
						<div class="applicant-header">
							<div class="applicant-info">
								<h2 class="applicant-title">Seller Information</h2>

							</div>
						</div>
					</section>


					<section class="dealSellerInformation custom-card">

						<div class="form-row">
							<div class="form-group col-md-4">
								<label for="otherIncomeAmount" class="price-label">Other Income Amount</label>
								<div class="input-group ">
									<div class="input-group-prepend">
										<span class="input-group-text"
											style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
									</div>
									<input type="text" id="otherIncomeAmount" class="form-control">

								</div>
							</div>
							<div class="form-group col-md-4">
								<label for="otherIncomeFrequency" class="info-label">Other Income Frequency</label>
								<select type="text" id="otherIncomeFrequency" class="form-control current-employer">

									<option>Year</option>
									<option>Month</option>
									<option>Week</option>

								</select>
							</div>

							<div class="form-group col-md-4">
								<label for="otherIncomeType" class="info-label">Other Income Type</label>
								<select type="text" id="otherIncomeType" class="form-control current-employer">

									<option>Lump-sum payments</option>
									<option>Retiring allowance</option>
									<option>Death benefits (other than CPP or QPP death benefits)</option>

								</select>
							</div>


						</div>

					</section>




					<section class="applicant-card addition-info-header">
						<div class="applicant-header">
							<div class="applicant-info">
								<h2 class="applicant-title">Finance Add Ons</h2>

							</div>
						</div>
					</section>




					<section class="custom-card additional-seller-info">




						<div class="col-12">



							<div class="form-row align-items-center">
								<span>GAAP Insurance</span>
								<div class="ml-2 gaap-insurance">
									<fieldset>
										<div class="form-check  d-flex align-items-center">
											<input class="form-check-input" type="radio" id="full-time" value="Yes"
												name="gaap-insurance">
											<label for="full-time">Yes</label>
										</div>
										<div class="form-check  d-flex align-items-center">
											<input class="form-check-input" type="radio" id="full-time" value="No"
												name="gaap-insurance">
											<label for="full-time">No</label>
										</div>
									</fieldset>
								</div>
							</div>

							<div class="form-row align-items-center">
								<span>Life Insurance</span>
								<div class="ml-2 life-insurance">
									<fieldset>
										<div class="form-check  d-flex align-items-center">
											<input class="form-check-input" type="radio" id="full-time" value="Yes"
												name="life-insurance">
											<label for="full-time">Yes</label>
										</div>
										<div class="form-check  d-flex align-items-center">
											<input class="form-check-input" type="radio" id="full-time" value="No"
												name="life-insurance">
											<label for="full-time">No</label>
										</div>
									</fieldset>
								</div>
							</div>

							<div class="form-row align-items-center">
								<span>Vehicle Warranty</span>
								<div class="ml-1 vehicle-warranty">
									<fieldset>
										<div class="form-check  d-flex align-items-center">
											<input class="form-check-input" type="radio" id="full-time" value="Yes"
												name="vehicle-warranty">
											<label for="full-time">Yes</label>
										</div>
										<div class="form-check  d-flex align-items-center">
											<input class="form-check-input" type="radio" id="full-time" value="No"
												name="vehicle-warranty">
											<label for="full-time">No</label>
										</div>
									</fieldset>
								</div>
							</div>

							<div class="form-row align-items-center">
								<span>Include Trbo Swift Delivery</span>
								<div class="ml-1 includeTurboBIdDelivery">
									<fieldset>
										<div class="form-check  d-flex align-items-center">
											<input class="form-check-input" type="radio" id="full-time" value="Yes"
												name="includeTurboBIdDelivery">
											<label for="full-time">Yes</label>
										</div>
										<div class="form-check  d-flex align-items-center">
											<input class="form-check-input" type="radio" id="full-time" value="No"
												name="includeTurboBIdDelivery">
											<label for="full-time">No</label>
										</div>
									</fieldset>
								</div>
							</div>

							<div class="form-row align-items-center">
								<span>Inspection requested</span>
								<div class="ml-1 inspectionRequested">
									<fieldset>
										<div class="form-check  d-flex align-items-center">
											<input class="form-check-input" type="radio" id="full-time" value="Yes"
												name="inspectionRequested">
											<label for="full-time">Yes</label>
										</div>
										<div class="form-check  d-flex align-items-center">
											<input class="form-check-input" type="radio" id="full-time" value="No"
												name="inspectionRequested">
											<label for="full-time">No</label>
										</div>
									</fieldset>
								</div>
							</div>
						</div>

						<div class="mt-3">
							<h6>Trbo Swift Transport</h6>
						</div>

						<div class="mt-3 form-row align-items-center">




							<div class="form-group col-12 col-md-4  ">
								<label for="pickupAddress" class="field-label">Enter Pickup Address/Zip code</label>
								<input id="pickupAddress" class="form-control  location1" type="text"
									value="${meta['text-15']}">
							</div>
							<div class="form-group col-12 col-md-4  ">
								<label for="dropOffAddress" class="field-label">Enter Dropoff Address/Zip code</label>
								<input id="dropOffAddress" class="form-control  location2" type="text"
									value="${meta['text-15']}">
							</div>




							<div class="col-3 col-md-2 input-group transport-delivery-amount">
								<div class="input-group-prepend">
									<span class="input-group-text"
										style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
								</div>
								<input type="text" id="purchase-price" class="form-control" aria-label="Purchase
										Price">

							</div>
							<!-- <div class="col-9 col-md-10">
								<button class="getDealTransportCost btn btn-secondary rounded-pill px-4">Done</button>
							</div> -->


						</div>



					</section>





					<section class="applicant-card co-app-info">
						<div class="applicant-header">
							<div class="applicant-info">
								<h2 class="applicant-title">Co-Applicant Information</h2>
								<div class="d-flex align-items-center" style="gap:10px">
									<button onClick="updateDealInformation();"
										class="btn update-button co-app-info-update-btn">Update</button>
									<div class="status-container">
										<span class="status-label">Status: </span>
										<span class="status-value">Unverified</span>
									</div>
								</div>
							</div>
						</div>
					</section>





					<section class="custom-card coEmploymentInformation">
					</section>





					<section class="applicant-card co-employment-info">
						<div class="applicant-header">
							<div class="applicant-info">
								<h2 class="applicant-title">Co-Employment Information</h2>
								<div class="d-flex align-items-center" style="gap:10px">
									<button onClick="updateDealInformation();"
										class="btn update-button co-app-info-update-btn">Update</button>
									<div class="status-container">
										<span class="status-label">Status: </span>
										<span class="status-value">Unverified</span>
									</div>
								</div>
							</div>
						</div>
					</section>




					<section class="custom-card co-employment">

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
								<label for="province" class="info-label">Province</label>
								<select type="text" id="province" class="form-control current-employer">

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
								<input type="text" id="postal-code" class="form-control current-employer">
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-9">
								<span>Employment Type</span>
								<div class="residence-type-option">
									<div class="form-check  d-flex align-items-center">
										<input class="form-check-input" type="radio" id="full-time" value="Full time"
											name="employment-type" checked>
										<label for="full-time">Full time</label>
									</div>
									<div class="form-check  d-flex align-items-center">
										<input class="form-check-input" type="radio" id="part-time"
											name="employment-type">
										<label for="part-time">Part time</label>
									</div>
									<div class="form-check  d-flex align-items-center">
										<input class="form-check-input" type="radio" id="contract" value="Contract"
											name="employment-type">
										<label for="contract">Contract</label>
									</div>
									<div class="form-check  d-flex align-items-center">
										<input class="form-check-input" type="radio" id="seasonal" value="Seasonal"
											name="employment-type">
										<label for="seasonal">Seasonal</label>
									</div>
									<div class="form-check  d-flex align-items-center">
										<input class="form-check-input" type="radio" id="retired" value="Retired"
											name="employment-type">
										<label for="retired">Retired</label>
									</div>

								</div>
							</div>
							<div class="form-group col-md-3">
								<label for="gross-monthly-income" class="info-label">Gross Monthly Income</label>
								<input type="text" id="gross-monthly-income" class="form-control current-employer"
									value="">
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-3">
								<label for="previous-employer" class="info-label">Previous Employer</label>
								<input type="text" id="previous-employer" class="form-control previous-employer-name">
							</div>
							<div class="form-group col-md-3">
								<label for="previous-position" class="info-label">Previous Position</label>
								<input id="previous-position" class="form-control previous-employer" type="text">
							</div>
							<div class="form-group col-md-3">
								<label for="previous-time" class="info-label">Time at Employer</label>
								<input id="previous-time" class="form-control previous-employer" type="text">
							</div>
							<div class="form-group col-md-3">
								<label for="other-income" class="info-label">Other Monthly Income</label>
								<input id="other-income" class="form-control previous-employer" type="text">
							</div>

						</div>

					</section>














					<!-- Tab of content close -->

				</div>
				<div class="tab-pane fade" id="pills-vehicle-details" role="tabpanel"
					aria-labelledby="pills-vehicle-details-tab">
					<style>
						.trade-in-card {
							border-radius: 10px;
							background-color: #3B634C;
							box-shadow: 4px 4px 39px rgba(0, 0, 0, 0.05);
							margin-top: 24px;
							color: #F8F9FA;
							padding: 50px 26px;
							font: 600 25px/3 Plus Jakarta Sans, -apple-system, Roboto, Helvetica, sans-serif;
						}



						.warranty-card {
							border-radius: 10px;
							background-color: #3B634C;
							box-shadow: 4px 4px 39px rgba(0, 0, 0, 0.05);
							margin-top: 17px;
							color: #F8F9FA;
							padding: 47px 26px;
							font: 600 25px/3 Plus Jakarta Sans, -apple-system, Roboto, Helvetica, sans-serif;
						}

						@media (max-width: 991px) {

							.warranty-card {
								max-width: 100%;
								padding: 0 20px;
							}

							.trade-in-card {
								max-width: 100%;
								padding: 0 20px;
							}


						}
					</style>

					<section class="">
						<section class="applicant-card vehicle-details-header">
							<div class="applicant-header">
								<div class="applicant-info">
									<div class="d-md-flex align-items-center" style="gap:10px">
										<h2 class="applicant-title">Vehicle Information</h2>

										<button class="btn btn-primary rounded-pill vehicle-send-inspection-btn">Send
											Inspection</button>
										<button class="btn btn-light rounded-pill vehicle-view-inspection-btn">Send
											Inspection</button>

									</div>
									<div class="d-flex align-items-center" style="gap:10px">
										<button
											class="btn btn-light rounded-pill vehicle-info-update-btn px-5 py-2">Update</button>
										<div class="status-container">
											<span class="status-label">Status: </span>
											<span class="status-value text-white">Verified <i
													class="fas fa-check-circle"></i></span>
										</div>
									</div>
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

						<div class="custom-card vehicle-vin-section">

							<div class="form-row">

								<div class="form-group col-md-3">
									<label for="vin-input" class="vin-label">VIN Number</label>
									<div class="input-group border rounded-pill vin-input">
										<input type="text" id="vin-input" class="form-control border-0 vin-input"
											value="">
										<button style=" font-size: 12px;" class="input-group-append search-vin-btn align-items-center rounded-pill
											btn btn-secondary ml-1">Search
											By VIN</button>
									</div>
								</div>

								<div class="form-group col-md-3">
									<label for="marketplaceLink" class="stock-label">Marketplace link</label>
									<input type="text" id="marketplaceLink" class="form-control stock-input" />
								</div>
								<div class="form-group col-md-3">
									<label for="mileage-input" class="mileage-label">Vehicle Mileage
										(Km)</label>
									<input type="text" id="mileage-input" class="form-control stock-input" />
								</div>

								<div class="form-group col-md-3">
									<label for="vehicle-value" class="vehicle-value-label">Vehicle Value</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"
												style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
										</div>
										<input type="text" id="vehicle-valu" class="form-control"
											aria-label="Vehicle Value">

									</div>
								</div>

							</div>


							<div class="form-row">

								<div class="form-group col-md-3">
									<label for="purchase-price" class="price-label">Purchase
										Price</label>
									<div class="input-group ">
										<div class="input-group-prepend">
											<span class="input-group-text"
												style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
										</div>
										<input type="text" id="purchase-price" class="form-control" aria-label="Purchase
										Price">

									</div>
								</div>

								<div class="form-group col-md-3">
									<label for="down-payment" class="price-label">Down Payment</label>
									<div class="input-group ">
										<div class="input-group-prepend">
											<span class="input-group-text"
												style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
										</div>
										<input type="text" id="down-payment" class="form-control">

									</div>
								</div>

								<div class="form-group col-md-3">
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

								<div class="form-group col-md-3">
									<label for="make-input" class="stock-label">Make</label>
									<input type="text" id="make-input" class="form-control make-input" />
								</div>





							</div>

							<div class="form-row">

								<div class="form-group col-md-3">
									<label for="model" class="info-label">Model
									</label>
									<input type="text" id="model-input" class="form-control model-input" />
								</div>

								<div class="form-group col-md-3">
									<label for="trim" class="info-label">Trim
									</label>
									<input type="text" id="trim" class="form-control" />
									<!-- <select class="form-control" id="trim">
										<option>Choose</option>
										<option>S or L</option>
										<option>EX or SXT</option>
										<option>SE</option>
										<option>SX</option>
										<option>SRT</option>
										<option>GT</option>
										<option>EX-L</option>
										<option>LX</option>
										<option>LE</option>
										<option>SEL</option>
									</select> -->
								</div>

								<div class="form-group col-md-3">
									<label for="model" class="info-label">Color
									</label>
									<input type="text" id="color-input" class="form-control color-input" />
								</div>

								<div class="form-group col-md-3">
									<label for="gas-diesel-hybrid" class="info-label">Gas / Diesel / Hybrid
									</label>
									<select class="form-control" id="gas-diesel-hybrid">
										<option value="">Choose</option>
										<option value="Gas">Gas</option>
										<option value="Diesel">Diesel</option>
										<option value="Hybrid">Hybrid</option>

									</select>
								</div>

							</div>




						</div>

						<div class="trade-in-card">Trade in</div>

						<div class="custom-card trade-in-section vehicle-vin-section">

							<div class="form-row">

								<div class="form-group col-md-3">
									<label for="vin-input" class="vin-label">VIN Number</label>
									<div class="input-group border rounded-pill vin-input">
										<input type="text" id="vin-input" class="form-control border-0 vin-input"
											value="">
										<button style=" font-size: 12px;" class=" input-group-append search-vin-btn align-items-center rounded-pill
											btn btn-secondary ml-1">Search
											By VIN</button>
									</div>
								</div>

								<div class="form-group col-md-3">
									<label for="mileage-input" class="mileage-label">Vehicle Mileage
										(Km)</label>
									<input type="text" id="mileage-input" class="form-control stock-input" />
								</div>

								<div class="form-group  col-md-3">
									<label for="purchase-price" class="price-label">Purchase
										Price</label>

									<div class="input-group">

										<div class="input-group-prepend">
											<span class="input-group-text"
												style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
										</div>
										<input type="text" id="purchase-price" class="form-control" aria-label="Purchase
										Price">

									</div>

								</div>



								<div class="form-group col-md-3">
									<label for="current-price" class="price-label">Current Payout</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"
												style="border-radius: 50px 0 0 50px; background: #fff;"> $</span>
										</div>
										<input type="text" id="current-price" class="form-control" aria-label="Purchase
										Price">
									</div>

								</div>




							</div>


							<div class="form-row">

								<div class="form-group col-md-3">
									<label for="year" class="info-label">Year
									</label>
									<select type="text" id="year" class="form-control current-em-app">
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

								<div class="form-group col-md-3">
									<label for="make-input" class="stock-label">Make</label>
									<input type="text" id="make-input" class="form-control make-input" />
								</div>


								<div class="form-group col-md-3">
									<label for="model" class="info-label">Model
									</label>
									<input type="text" id="model-input" class="form-control model-input" />
								</div>

								<div class="form-group col-md-3">
									<label for="trim" class="info-label">Trim
									</label>
									<input type="text" id="trim" class="form-control" />
									<!-- <select class="form-control" id="trim">
										<option>Choose</option>
										<option>S or L</option>
										<option>EX or SXT</option>
										<option>SE</option>
										<option>SX</option>
										<option>SRT</option>
										<option>GT</option>
										<option>EX-L</option>
										<option>LX</option>
										<option>LE</option>
										<option>SEL</option>
									</select> -->
								</div>




							</div>

							<div class="form-row">





								<div class="form-group col-md-6">
									<label for="model" class="info-label">Color
									</label>
									<input type="text" id="color-input" class="form-control color-input" />
								</div>

								<div class="form-group col-md-6">
									<label for="gas-diesel-hybrid" class="info-label">Gas / Diesel / Hybrid
									</label>
									<select class="form-control" id="gas-diesel-hybrid">
										<option value="">Choose</option>
										<option value="Gas">Gas</option>
										<option value="Diesel">Diesel</option>
										<option value="Hybrid">Hybrid</option>

									</select>
								</div>

							</div>
						</div>


						<div class="warranty-card">Warranty & Accessories</div>

						<div class="custom-card warranty-accessories-prices">


							<div class="form-row ">




								<div class="form-group col-md-3">
									<label for="blank-price1" class="price-label">------</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"
												style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
										</div>
										<input type="text" id="blank-price1" class="form-control" aria-label="Purchase
										Price" value="0">

									</div>
								</div>
								<div class="form-group col-md-3">
									<label for="blank-price2" class="price-label">------</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"
												style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
										</div>
										<input type="text" id="blank-price2" class="form-control" aria-label="Purchase
										Price" value="0">

									</div>
								</div>
								<div class="form-group col-md-3">
									<label for="blank-price3" class="price-label">------</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"
												style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
										</div>
										<input type="text" id="blank-price3" class="form-control" aria-label="Purchase
										Price" value="0">

									</div>
								</div>
								<div class="form-group col-md-3">
									<label for="blank-price4" class="price-label">------</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"
												style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
										</div>
										<input type="text" id="blank-price4" class="form-control" aria-label="Purchase
										Price" value="0">

									</div>
								</div>
							</div>

						</div>
					</section>
				</div>




				<div class="tab-pane fade" id="pills-client-documents" role="tabpanel"
					aria-labelledby="pills-client-documents-tab">




					<section class="documents">

						<div class="col-12 d-flex py-3 px-2">
							<div class="col-md-8">
								<h2 class="vehicle-title">Client Documents</h2>
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
													<tr class="row-1" data-upload-name="Bank Statement"
														data-document-id="1">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Bank Statement
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
																	src="<?php if ($CORE->USER('get_avatar', $userdata->ID)) {
																		echo $CORE->USER('get_avatar', $userdata->ID);
																	} else {
																		echo '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png';
																	} ?>" alt="User Profile Image" />
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
															<span class="turbo-danger font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Uncompleted</span>
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
													<tr class="row-2" data-upload-name="Bill of Sale"
														data-document-id="2">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Bill of Sale
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
																	src="<?php if ($CORE->USER('get_avatar', $userdata->ID)) {
																		echo $CORE->USER('get_avatar', $userdata->ID);
																	} else {
																		echo '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png';
																	} ?>" alt="User Profile Image" />
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
															<span class="turbo-danger font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Uncompleted</span>
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
													<tr class="row-3" data-upload-name="Car Ownerhship"
														data-document-id="3">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Car Ownerhship
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
																	src="<?php if ($CORE->USER('get_avatar', $userdata->ID)) {
																		echo $CORE->USER('get_avatar', $userdata->ID);
																	} else {
																		echo '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png';
																	} ?>" alt="User Profile Image" />
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
															<span class="turbo-danger font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Uncompleted</span>
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
													<tr class="row-4" data-upload-name="Carfax" data-document-id="4">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Carfax
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
																	src="<?php if ($CORE->USER('get_avatar', $userdata->ID)) {
																		echo $CORE->USER('get_avatar', $userdata->ID);
																	} else {
																		echo '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png';
																	} ?>" alt="User Profile Image" />
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
															<span class="turbo-danger font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Uncompleted</span>
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
													<tr class="row-5" data-upload-name="Drivers License"
														data-document-id="5">
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
																	src="<?php if ($CORE->USER('get_avatar', $userdata->ID)) {
																		echo $CORE->USER('get_avatar', $userdata->ID);
																	} else {
																		echo '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png';
																	} ?>" alt="User Profile Image" />
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
															<span class="turbo-danger font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Uncompleted</span>
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
													<tr class="row-6" data-upload-name="Employment Letter"
														data-document-id="6">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Employment Letter
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
																	src="<?php if ($CORE->USER('get_avatar', $userdata->ID)) {
																		echo $CORE->USER('get_avatar', $userdata->ID);
																	} else {
																		echo '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png';
																	} ?>" alt="User Profile Image" />
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
															<span class="turbo-danger font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Uncompleted</span>
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
													<tr class="row-7" data-upload-name="Loan Agreement"
														data-document-id="7">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Loan Agreement
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
																	src="<?php if ($CORE->USER('get_avatar', $userdata->ID)) {
																		echo $CORE->USER('get_avatar', $userdata->ID);
																	} else {
																		echo '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png';
																	} ?>" alt="User Profile Image" />
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
															<span class="turbo-danger font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Uncompleted</span>
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
													<tr class="row-8" data-upload-name="Pay Stub" data-document-id="8">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Pay Stub
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
																	src="<?php if ($CORE->USER('get_avatar', $userdata->ID)) {
																		echo $CORE->USER('get_avatar', $userdata->ID);
																	} else {
																		echo '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png';
																	} ?>" alt="User Profile Image" />
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
															<span class="turbo-danger font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Uncompleted</span>
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
													<tr class="row-9" data-upload-name="Proof of Insurance"
														data-document-id="9">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Proof of Insurance
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
																	src="<?php if ($CORE->USER('get_avatar', $userdata->ID)) {
																		echo $CORE->USER('get_avatar', $userdata->ID);
																	} else {
																		echo '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png';
																	} ?>" alt="User Profile Image" />
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
															<span class="turbo-danger font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Uncompleted</span>
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
													<tr class="row-10" data-upload-name="Void Cheque"
														data-document-id="10">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Void Cheque
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
																	src="<?php if ($CORE->USER('get_avatar', $userdata->ID)) {
																		echo $CORE->USER('get_avatar', $userdata->ID);
																	} else {
																		echo '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png';
																	} ?>" alt="User Profile Image" />
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
															<span class="turbo-danger font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Uncompleted</span>
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
				<div class="tab-pane fade" id="pills-dealer-chat" role="tabpanel"
					aria-labelledby="pills-dealer-chat-tab">
					<!-- dealer-chat -->


					<section class="applicant-card chat-header-vendor">
						<div class="applicant-header">
							<div class="applicant-info">
								<h2 class="applicant-title">Chat with Vendor</h2>

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



					<?php //  _ppt_template('framework/design/account/parts/_chat'); ?>



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
												<span class="turbo-danger font-8 rounded-pill"><i
														class="fas fa-circle small"></i>Uncompleted</span>
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
												<span class="turbo-danger font-8 rounded-pill"><i
														class="fas fa-circle small"></i>Uncompleted</span>
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
												<span class="turbo-danger font-8 rounded-pill"><i
														class="fas fa-circle small"></i>Uncompleted</span>
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
												<span class="turbo-danger font-8 rounded-pill"><i
														class="fas fa-circle small"></i>Uncompleted</span>
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

													<?php ?>



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
													class="fas fa-circle small"></i> Seller</span>

										</div>
										<div class="bg-light radiusx my-2 py-3 px-1"
											style="color:#4B4B4B; font-size:14px">
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
													class="fas fa-circle small"></i> Buyer</span>

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

												<span>Loan Status</span>

											</div>
											<div class="radiusx my-2 py-3" style="color:#4B4B4B; font-size:14px">
												<div class="d-flex align-items-center my-2">
													<div class="col-6 pl-0">
														<i class="fal fa-badge-dollar"></i> Loan Amount
													</div>
													<div class="col-1">:</div>
													<div class="col-5 text-end">
														<span class="loanAmount text-black">$25,000</span>
													</div>
												</div>
												<div class="d-flex align-items-center my-2">
													<div class="col-6 pl-0">
														<i class="fal fa-calendar-alt"></i> Application Date
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
																class="fas fa-circle small text-success"></i>
															<span class="text-white">Paperwork</span></span>

													</div>
												</div>

											</div>



										</div>




									</div>
								</div>

								<!-- <div class="deal-task-section mt-4">
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
															<img src="<?php if ($CORE->USER('get_avatar', $userdata->ID)) {
																echo $CORE->USER('get_avatar', $userdata->ID);
															} else {
																echo '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png';
															} ?>"
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
								</div> -->




							</div>
							<!-- White block close  -->

						</div>

					</div>


				</div>

				<?php

				/*
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
																			alert("This file extension is not allowed!");
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
							*/

				?>

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
													<tr class="row-1" data-upload-name="Wholesale Bill of Sale"
														data-document-id="1">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Wholesale Bill of Sale
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
																	src="<?php if ($CORE->USER('get_avatar', $userdata->ID)) {
																		echo $CORE->USER('get_avatar', $userdata->ID);
																	} else {
																		echo '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png';
																	} ?>" alt="User Profile Image" />
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
															<span class="turbo-danger font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Uncompleted</span>
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
																	src="<?php if ($CORE->USER('get_avatar', $userdata->ID)) {
																		echo $CORE->USER('get_avatar', $userdata->ID);
																	} else {
																		echo '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png';
																	} ?>" alt="User Profile Image" />
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
															<span class="turbo-danger font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Uncompleted</span>
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
													<tr class="row-3" data-upload-name="Bill of Sale"
														data-document-id="3">
														<td class="d-flex">
															<img style="max-width:35px; max-height:35px;"
																src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
																alt="PDF FILE" />
															<div class="d-flex flex-column pl-2">
																<span class="doc-name text-dark">Bill of Sale
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
																	src="<?php if ($CORE->USER('get_avatar', $userdata->ID)) {
																		echo $CORE->USER('get_avatar', $userdata->ID);
																	} else {
																		echo '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png';
																	} ?>" alt="User Profile Image" />
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
															<span class="turbo-danger font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Uncompleted</span>
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
																	src="<?php if ($CORE->USER('get_avatar', $userdata->ID)) {
																		echo $CORE->USER('get_avatar', $userdata->ID);
																	} else {
																		echo '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png';
																	} ?>" alt="User Profile Image" />
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
															<span class="turbo-danger font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Uncompleted</span>
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
																	src="<?php if ($CORE->USER('get_avatar', $userdata->ID)) {
																		echo $CORE->USER('get_avatar', $userdata->ID);
																	} else {
																		echo '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png';
																	} ?>" alt="User Profile Image" />
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
															<span class="turbo-danger font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Uncompleted</span>
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
																	src="<?php if ($CORE->USER('get_avatar', $userdata->ID)) {
																		echo $CORE->USER('get_avatar', $userdata->ID);
																	} else {
																		echo '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png';
																	} ?>" alt="User Profile Image" />
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
															<span class="turbo-danger font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Uncompleted</span>
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
																	src="<?php if ($CORE->USER('get_avatar', $userdata->ID)) {
																		echo $CORE->USER('get_avatar', $userdata->ID);
																	} else {
																		echo '<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-profile.png';
																	} ?>" alt="User Profile Image" />
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
															<span class="turbo-danger font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Uncompleted</span>
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
															<span class="turbo-success font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Generate
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
															<span class="turbo-success font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Generate
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
															<span class="turbo-success font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Generate
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
															<span class="turbo-success font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Generate
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
															<span class="turbo-success font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Generate
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
															<span class="turbo-success font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Generate
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
															<span class="turbo-success font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Generate
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
															<span class="turbo-success font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Generate
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
															<span class="turbo-success font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Generate
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
															<span class="turbo-success font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Generate
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
															<span class="turbo-success font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Generate
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
															<span class="turbo-success font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Generate
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
															<span class="turbo-success font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Generate
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
															<span class="turbo-success font-8 rounded-pill"><i
																	class="fas fa-circle small"></i>Generate
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

				<?php
				/*
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
																<input type="text" id="vendor-id" class="form-control vendor-id"
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
																<input type="text" id="vendor-Name"
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
																			alert("This file extension is not allowed!");
																		}
																	});
																});
																</script>



															</div>

														</div>


													</div>
												</section>



											</div>
							*/
				?>


				<div class="tab-pane fade" id="pills-funding-doc" role="tabpanel"
					aria-labelledby="pills-funding-doc-tab">
					<!-- Funding Doc -->
					<section class="funding-docs">



						<div class="custom-card sellerInformationPayout">
							<h6>Seller Infomration & Payout</h6>

							<div class="form-row mt-2">


								<div class="form-group col-md-3">
									<label for="nameOfRegisteredOwner" class="stock-label">Name of registered
										owner</label>
									<input type="text" id="nameOfRegisteredOwner" class="form-control funding-input"
										value="" />
								</div>

								<div class="form-group col-md-3">
									<label for="sellerRegisteredOwner" class="stock-label">Is the registered owner the
										seller ?</label>
									<select id="sellerRegisteredOwner" class="form-control funding-input"
										name="sellerRegisteredOwner">
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
									</select>
									<!-- <input type="text" id="sellerRegisteredOwner" class="form-control funding-input" /> -->
								</div>
								<div class="form-group col-md-3">
									<label for="lienInformation" class="mileage-label">Lien Information
									</label>
									<input type="text" id="lienInformation" class="form-control funding-input" />
								</div>
								<div class="form-group col-md-3">
									<label for="confirmedVehiclePriceVIN" class="mileage-label">Confirmed Vehicle Price
										& VIN
									</label>
									<input type="text" id="confirmedVehiclePriceVIN"
										class="form-control funding-input" />
								</div>



							</div>

							<div class="form-row">


								<div class="form-group col-md-3">
									<label for="institutionName" class="stock-label">Institution name</label>
									<input type="text" id="institutionName" class="form-control funding-input"
										value="" />
								</div>


								<div class="form-group col-md-3">
									<label for="institutionAddress" class="mileage-label">Institution Address
									</label>
									<input type="text" id="institutionAddress"
										class="form-control funding-input googleAutoLocation" />
								</div>
								<div class="form-group col-md-3">
									<label for="institutionNumber" class="mileage-label">Institution Number (Max. 3)
									</label>
									<input type="text" id="institutionNumber" class="form-control funding-input" />
								</div>
								<div class="form-group col-md-3">
									<label for="transitNumber" class="stock-label">Transit Number</label>
									<input type="text" id="transitNumber" class="form-control funding-input" />
								</div>

							</div>

							<div class="form-row">


								<div class="form-group col-md-3">
									<label for="accountName" class="stock-label">Account name</label>
									<input type="text" id="accountName" class="form-control funding-input" value="" />
								</div>


								<div class="form-group col-md-3">
									<label for="accountNumber" class="mileage-label">Account Number
									</label>
									<input type="text" id="accountNumber" class="form-control funding-input" />
								</div>

								<div class="form-group col-md-3">
									<label for="selectedPayoutMethod" class="info-label">Selected payout method
									</label>
									<select type="text" id="selectedPayoutMethod" class="form-control co-app">
										<option>Wire Transfer</option>
										<option>Hyperwallet Payment (Faster)</option>
									</select>
								</div>

								<div class="form-group col-md-3">
									<label for="payoutAmount" class="">Payout Amount</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"
												style="border-radius: 50px 0 0 50px; background: #fff;">$</span>
										</div>
										<input type="text" id="payoutAmount" class="form-control"
											aria-label="Vehicle Value">

									</div>
								</div>

							</div>



						</div>

						<div class="custom-card DeliveryDetails">
							<h6>Delivery Details</h6>

							<div class="form-row my-2">


								<div class="form-group col-md-3">
									<label for="transportCompany" class="stock-label">Transport company</label>
									<input type="text" id="transportCompany" class="form-control funding-input"
										value="" />
								</div>

								<div class="form-group col-md-3">
									<label for="phoneNumber" class="stock-label">Phone number</label>
									<input type="tel" id="phoneNumber" class="form-control funding-input" />
								</div>
								<div class="form-group col-md-3">
									<label for="driver" class="mileage-label">Driver
									</label>
									<input type="text" id="driver" class="form-control funding-input" />
								</div>
								<div class="form-group col-md-3">
									<label for="trackingNumber" class="mileage-label">Tracking number
									</label>
									<input type="text" id="trackingNumber" class="form-control funding-input" />
								</div>



							</div>

							<h6>Delivery Status</h6>

							<div class="form-row mt-2">

								<div class="form-group col-md-3">
									<label for="isVehiclePicked" class="info-label">Has the vehicle been picked up?
									</label>
									<select type="text" id="isVehiclePicked" class="form-control co-app">
										<option>Yes</option>
										<option>No</option>
									</select>
								</div>


								<div class="form-group col-md-3">
									<label for="SellerPickupAddress" class="stock-label">Seller Pickup Address</label>
									<input type="text" id="SellerPickupAddress"
										class="form-control funding-input googleAutoLocation" value="" />
								</div>


								<div class="form-group col-md-3">
									<label for="sellerPickupDate" class="mileage-label">Seller Pickup Date
									</label>
									<input type="date" id="sellerPickupDate" class="form-control funding-input" />
								</div>
								<div class="form-group col-md-3">
									<label for="sellerPickupTime" class="stock-label">Seller Pickup time</label>
									<input type="time" id="sellerPickupTime" class="form-control funding-input" />
								</div>

							</div>


							<button type="button" id="fundDealBtn"
								class="btn btn-secondary rounded-pill px-3 font-12 my-3">Fund
								deal</button>


						</div>






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
													style="border-radius:10px 0 0 0;">
													Document name</th>
												<th class="text-start bg-secondary text-white">Status</th>
												<th class="text-start bg-secondary text-white"></th>
												<th class="text-end text-white  bg-secondary  dashhideme"
													style="border-radius:0 10px 0 0;"></th>
											</tr>
										</thead>
										<tbody class="bg-white" id="client-document">
											<tr class="row-1" data-upload-name="Finance Agreement" data-document-id="1">
												<td class="d-flex" colspan="6">
													<img style="max-width:35px; max-height:35px;"
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
														alt="PDF FILE" />
													<div class="d-flex flex-column pl-2">
														<span class="doc-name text-dark">Finance Agreement
														</span>
														<span class="small pt-1 doc-date" style="color:#909090">
														</span>
													</div>
												</td>


												<td class="doc-row-status text-end" colspan="1">
													<span class="turbo-danger font-8 rounded-pill"><i
															class="fas fa-circle small"></i>Uncompleted</span>
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
											<tr class="row-2" data-upload-name="Bank Paperwork" data-document-id="2">
												<td class="d-flex" colspan="9">
													<img style="max-width:35px; max-height:35px;"
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
														alt="PDF FILE" />
													<div class="d-flex flex-column pl-2">
														<span class="doc-name text-dark">Bank Paperwork
														</span>
														<span class="small pt-1 doc-date" style="color:#909090"></span>
													</div>
												</td>



												<td class="doc-row-status text-end" colspan="1">
													<span class="turbo-danger font-8 rounded-pill"><i
															class="fas fa-circle small"></i>Uncompleted</span>
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
													<span class="turbo-danger font-8 rounded-pill"><i
															class="fas fa-circle small"></i>Uncompleted</span>
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
													<span class="turbo-danger font-8 rounded-pill"><i
															class="fas fa-circle small"></i>Uncompleted</span>
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

											<tr class="row-4" data-upload-name="Vehicle Ownership Buyer"
												data-document-id="5">
												<td class="d-flex" colspan="9">
													<img style="max-width:35px; max-height:35px;"
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
														alt="PDF FILE" />
													<div class="d-flex flex-column pl-2">
														<span class="doc-name text-dark">Vehicle Ownership Buyer
														</span>
														<span class="small pt-1 doc-date" style="color:#909090"></span>
													</div>
												</td>



												<td class="doc-row-status text-end" colspan="1">
													<span class="turbo-danger font-8 rounded-pill"><i
															class="fas fa-circle small"></i>Uncompleted</span>
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

											<tr class="row-4" data-upload-name="Vehicle Ownership Seller"
												data-document-id="6">
												<td class="d-flex" colspan="9">
													<img style="max-width:35px; max-height:35px;"
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg"
														alt="PDF FILE" />
													<div class="d-flex flex-column pl-2">
														<span class="doc-name text-dark">Vehicle Ownership Seller
														</span>
														<span class="small pt-1 doc-date" style="color:#909090"></span>
													</div>
												</td>



												<td class="doc-row-status text-end" colspan="1">
													<span class="turbo-danger font-8 rounded-pill"><i
															class="fas fa-circle small"></i>Uncompleted</span>
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


<input type="hidden" id="finance_entry_vehicle_name" />
<input type="hidden" id="finance_entry_vehicle_vin" />
<input type="hidden" id="transportDistance" />

<script>
	function checkOnClick() {
		alert('Check On click');
	}




	function mainDealsImportFromServer() {
		jQuery('#loadingSpinner').show();
		var formData = new FormData();
		formData.append("action", "get_main_deals");
		formData.append("form_id", 337873); // Replace with your form ID


		// Call the function and handle the response
		addAdditionalEntryData(formData).done(function (res) {
			jQuery('#loadingSpinner').hide();
			// Handle the response from the AJAX call
			if (res.success) {
				// console.log(res.data)
				insertMainDealsToSection(res.data);
			} else {
				console.log('Error deal data')
			}
		})
			.fail(function (error) {
				console.log("Error:", error);
			});


		var dealForm = new FormData();
		dealForm.append("action", "get_deals_status_count");
		dealForm.append("form_id", 337873);


		addAdditionalEntryData(dealForm).done(function (res) {
			jQuery('#loadingSpinner').hide();
			// Handle the response from the AJAX call
			if (res.success) {


				insertAllDealInfoStatus(res.data);

			} else {
				console.log('Error desl data')
			}
		})
			.fail(function (error) {
				console.log("Error:", error);
			});

	}


	mainDealsImportFromServer();



	function insertAllDealInfoStatus(data) {
		var showDealsQuickInfoInCards = ''; // Initialize properly

		console.log(data);

		if (data && data.length > 0) {
			data.forEach(function (item, index) {


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


	var adminRole = "<?php echo in_array('Finance', $user_roles) ? true : false; ?>";

	console.log("adminRole: ", adminRole);

	function insertMainDealsToSection(data) {
		let pendingSectionTableData = ''; // Initialize the table

		if (data && data.length > 0) {
			pendingSectionTableData += `<div class="overflow-auto" style="min-height:700px;">
								<div class="table small table-orders">
									<div>
										<div class="col-12 d-flex my-3">
											<div class="col-1 text-center" style="border-radius:10px 0 0 0;">
												ID
											</div>
											<div class="col">Flag</div>
											<div class="col">Date</div>
											<div class="col">Dealer</div>
											<div class="col">Applicant</div>
											<div class="col">Vehicle VIN</div>
											<div class="col">Action</div>
											<div class="col">Phone Number</div>
											<div class="col">Contact</div>
											<div class="col">Status</div>
											<div class=""></div>
										</div>
									</div>
									<div>`;

			// Loop through each entry in the data array
			data.forEach(function (entry) {
				let financeStepStatus = entry.finance_step_status; // Access finance status for each entry

				sessionStorage.setItem('@deal-data' + entry.entry_id, JSON.stringify(entry.meta_data));

				// Apply different classes based on finance step status (same logic as PHP)
				let rowClass = '';
				if (financeStepStatus.step >= 5 && financeStepStatus.status === "Approved") {
					rowClass = 'finance-finished';
				} else if (financeStepStatus.step >= 2 && financeStepStatus.status === "Approved") {
					rowClass = 'finance-approved';
				} else if (financeStepStatus.step >= 3 && financeStepStatus.status === "Approved") {
					rowClass = 'finance-verified';
				} else if (financeStepStatus.step < 5) {
					rowClass = 'finance-pending';
				} else {
					rowClass = 'finance-start';
				}

				// Add row for each entry
				pendingSectionTableData += `<div data-entry-id="${entry.entry_id}" class="${rowClass}">
									<div class="col-12 d-flex bg-light py-3 mb-2 text-decoration-none" style="border-radius:8px;">
										<div class="col-1 font-10 text-center">
											<a href="javascript:void(0)" data-entry-id="${entry.entry_id}" data-user-id="${entry.meta_data['hidden-3']}" data-entry-status="${financeStepStatus.status != "Booked" || financeStepStatus.status != "Approved" ? 'Pending' : 'Booked'}" class="deal-entry-link text-dark">
												${entry.entry_id}
												<br> <i
												class="fas fa-exclamation-triangle text-primary opacity-5"></i>
											</a>
										</div>
										<div class="col font-10 flag-${entry.entry_id}">
											<div class="d-flex align-items-center ${entry.meta_data['taskStatus'] === "Low" ? 'text-success' : entry.meta_data['taskStatus'] === "Medium" ? 'text-warning' : entry.meta_data['taskStatus'] === "High" ? 'text-danger' : 'text-success'} font-weight-bold"><span>${entry.meta_data['taskStatus'] || ''}
											</span><i class="fas fa-flag ml-2"></i></div>
										</div>
										<div class="col font-10 overflow-auto text-muted">
											${formatJustDate(entry.date_created)}
										</div>
										<div class="col font-10 overflow-auto">
											${entry.meta_data['select-7'] === "Dealer" ? entry.meta_data['name-4'] : ''}
										</div>
										<div class="col font-10 overflow-auto">
											${entry.meta_data['name-1'] + ' ' + entry.meta_data['name-2']}
										</div>
										<div class="col font-10 overflow-hidden">
											${entry.meta_data['text-13'] || ''}
										</div>

										<div class="col font-10 overflow-auto d-flex align-items-center">
											<a href="javascript:void(0)" data-entry-id="${entry.entry_id}" data-user-id="${entry.meta_data['hidden-3']}" class="deal-entry-link text-white btn btn-secondary rounded-pill font-12 px-2 py-1">
												View
											</a>
										</div>
										<div class="col font-10 overflow-auto font-10">
											${entry.meta_data['name-1'] || ''} ${entry.meta_data['name-2'] || ''}<br />
											${entry.meta_data['phone-1'] || ''}
										</div>
										<div class="col overflow-hidden font-10">
											<div>${entry.meta_data['email-1'] || ''}</div>
											<div>${entry.meta_data['phone-2'] || ''}</div>
										</div>
										  <div class="col d-flex justify-content-center align-items-center">
											<div style="text-align:center">`;

				// Buttons based on finance status
				if (financeStepStatus.step >= 5) {
					pendingSectionTableData += `<button class="turbo-success font-10 rounded-pill">
										<i class="fas fa-circle small"></i> ${financeStepStatus.status || "Approved"}
									</button>`;
				} else if (financeStepStatus.status === "Approved" && financeStepStatus.step >= 1) {
					pendingSectionTableData += `<button class="turbo-success font-10 rounded-pill">
										<i class="fas fa-circle small"></i> ${financeStepStatus.status || "Approved"}
									</button>`;
				} else if (financeStepStatus.step < 5 && financeStepStatus.step >= 1) {
					pendingSectionTableData += `<button class="turbo-warning font-10 rounded-pill">
										<i class="fas fa-circle small"></i> ${financeStepStatus.status || "Awaiting"}
									</button>`;
				} else {
					pendingSectionTableData += `<button class="turbo-danger font-10 rounded-pill">
										<i class="fas fa-circle small"></i> ${financeStepStatus.status || "Pending"}
									</button>`;
				}

				pendingSectionTableData += `</div>
										</div>

										<div class="text-right d-flex font-10 justify-content-end align-items-center">

										<div class="dropdown font-10">`;

				if (!adminRole) {
					pendingSectionTableData += ` <button class="btn btn-light dropdown-toggle" type="button"
												data-toggle="dropdown" aria-expanded="false">
												<i class="fa-solid fa-ellipsis-vertical"></i>
											</button>
										

											<div class="dropdown-menu z-index">
												<a class="dropdown-item status" href="javascript:void(0)"  data-status-name="Awaiting" data-step-no="1" data-entry-id="${entry.entry_id}">
													<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/dollerbadge.svg"
														style="width:14px;" />

													Awaiting</a>
												<a class="dropdown-item status" href="javascript:void(0)"  data-status-name="Approved" data-step-no="2" data-entry-id="${entry.entry_id}"><img
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/checkmark.svg"
														style="width:14px;" />
													Approved</a>
												<a class="dropdown-item status" href="javascript:void(0)"  data-status-name="Paperwork" data-step-no="4" data-entry-id="${entry.entry_id}"><img
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/job.svg"
														style="width:14px;" />
													Paperwork</a>
												<a class="dropdown-item status" href="javascript:void(0)" data-status-name="Delivery" data-step-no="5" data-entry-id="${entry.entry_id}"><img
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delivery.svg"
														style="width:14px;" />
													Delivery</a>
												<a class="dropdown-item status" href="javascript:void(0)"  data-status-name="Disbursement" data-step-no="6" data-entry-id="${entry.entry_id}"><img
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/hand.svg"
														style="width:14px;" />
													Disbursement</a>
												<a class="dropdown-item status" href="javascript:void(0)"  data-status-name="Delete" data-step-no="6" data-entry-id="${entry.entry_id}"><img
														src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/delete.svg"
														style="width:14px;" />
													Delete Application</a>
											</div>`;
				}
				pendingSectionTableData += `
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
											<div class="col">Flag</div>
											<div class="col">Date</div>
											<div class="col">Dealer</div>
											<div class="col">Applicant</div>
											<div class="col">Vehicle VIN</div>
											<div class="col">Status</div>
											<div class="col">Messages</div>
											<div class="col">Phone Number</div>
											<div class="col">Contact</div>
											<div class="col">Archive</div>
										</div>
									</div>
									<div>`;

			// Loop through each entry in the data array
			data.forEach(function (entry) {
				let financeStepStatus = entry.finance_step_status; // Access finance status for each entry

				// Apply different classes based on finance step status (same logic as PHP)
				let rowClass = '';
				if (financeStepStatus.step >= 5 && financeStepStatus.status === "Approved") {
					rowClass = 'finance-finished';
				} else if (financeStepStatus.step >= 2 && financeStepStatus.status === "Approved") {
					rowClass = 'finance-approved';
				} else if (financeStepStatus.step >= 3 && financeStepStatus.status === "Approved") {
					rowClass = 'finance-verified';
				} else if (financeStepStatus.step < 5) {
					rowClass = 'finance-pending';
				} else {
					rowClass = 'finance-start';
				}

				if (financeStepStatus.status === "Approved" || financeStepStatus
					.status === "Booked") {

					// Add row for each entry
					bookedSectionTableData += `<div data-user-id="${entry.entry_id}" class="${rowClass}">
									<div class="col-12 d-flex bg-light py-3 mb-2 text-decoration-none" style="border-radius:8px;">
										<div class="col-1 font-10 text-center">
											<a href="javascript:void(0)" data-entry-id="${entry.entry_id}" class="deal-entry-link text-dark">
												${entry.entry_id}
											</a>
										</div>
										<div class="col font-10 flag-${entry.entry_id}">
										  <div class="d-flex align-items-center ${entry.meta_data['taskStatus'] === "Low" ? 'text-success' : entry.meta_data['taskStatus'] === "Medium" ? 'text-warning' : entry.meta_data['taskStatus'] === "High" ? 'text-danger' : 'text-success'} font-weight-bold"><span>${entry.meta_data['taskStatus'] || ''}
											</span><i class="fas fa-flag ml-2"></i></div>
										</div>
										<div class="col font-10 overflow-auto text-muted">
											${new Date(entry.date_created).toLocaleString()}
										</div>
										<div class="col font-10 overflow-auto">
											${entry.meta_data['select-7'] === "Dealer" ? entry.meta_data['name-4'] : ''}
										</div>
										<div class="col font-10 overflow-auto">
											${entry.meta_data['name-1'] || ''} ${entry.meta_data['name-2'] || ''}
										</div>
										<div class="col font-10 overflow-auto">
											${entry.meta_data['text-13'] || ''}
										</div>
										<div class="col d-flex justify-content-center">
											<div style="text-align:center">`;

					// Buttons based on finance status
					if (financeStepStatus.step >= 5) {
						bookedSectionTableData += `<button class="turbo-success font-10 rounded-pill">
										<i class="fas fa-circle small"></i> ${financeStepStatus.status || "Approved"}
									</button>`;
					} else if (financeStepStatus.status === "Approved" && financeStepStatus.step >= 1) {
						bookedSectionTableData += `<button class="turbo-success font-10 rounded-pill">
										<i class="fas fa-circle small"></i> ${financeStepStatus.status || "Pending"}
									</button>`;
					} else if (financeStepStatus.step < 5 && financeStepStatus.step > 1) {
						bookedSectionTableData += `<button class="turbo-warning font-10 rounded-pill">
										<i class="fas fa-circle small"></i> ${financeStepStatus.status || "Pending"}
									</button>`;
					} else {
						bookedSectionTableData += `<button class="turbo-danger font-10 rounded-pill">
										<i class="fas fa-circle small"></i> ${financeStepStatus.status || "Pending"}
									</button>`;
					}

					bookedSectionTableData += `</div>
										</div>
										<div class="col font-10 overflow-auto">
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
										<div class="col font-10">
											<button class="deal-entry-link btn btn-light rounded-pill" data-entry-id="${entry.entry_id}"><i class="fas fa-archive"></i></button>
											<button class="deal-entry-link btn btn-light rounded-pill" data-entry-id="${entry.entry_id} "><i class="fas fa-edit"></i></button>
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


	jQuery(document).on('click', '.dropdown-menu a.dropdown-item.status', function (e) {
		e.preventDefault();

		var row = jQuery(this);
		var entrytId = row.data('entry-id');
		var stepNo = row.data('step-no');
		var statusName = row.data('status-name');

		var satatus = {
			entry_id: entrytId,
			step_no: stepNo,
			status: statusName
		}



		sessionStorage.setItem('@deal-new-status', JSON.stringify(satatus));


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

		if (statusName === "Approved") {

			jQuery('.documentManagementBody #documentManageTitle').hide();
			jQuery('.documentManagementBody .documentManagementContainer').removeClass('p-3 customModalWidthHalf')
				.addClass(
					'p-0 border-0 customModalWidthFull');

			dealApprovalTemsDetails();

		} else if (statusName === "Paperwork") {

			jQuery('.documentManagementBody #documentManageTitle').hide();
			jQuery('.documentManagementBody .documentManagementContainer').removeClass('p-3 customModalWidthHalf')
				.addClass(
					'p-0 border-0 customModalWidthFull');

			dealPaperWorkDetails(entrytId);

		} else {

			jQuery('.documentManagementBody .documentManagementContainer').removeClass('p-0 customModalWidthFull')
				.addClass(
					'p-3 border-0 customModalWidthHalf');
			jQuery('.documentManagementBody #documentManageTitle').show().html('Change Status');
			jQuery('.documentManagementBody .documentViewSection').removeClass('bg-white').html(content);
		}




	});




	jQuery(document).on('click', '.dealStatusChangeBtn', function () {

		var entry = JSON.parse(sessionStorage.getItem('@deal-new-status'));

		// console.log(entry['entry_id']);

		if (entry['status'] === 'Delete') {
			deleteEntryTableFromServer(entry['entry_id']);
		} else {

			financeProgressVerification(entry['entry_id'], entry['step_no'], entry['status'], entry[
				'status']);
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
						src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg" alt="PDF FILE" />
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
						src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg" alt="PDF FILE" />
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
						src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg" alt="PDF FILE" />
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
						src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg" alt="PDF FILE" />
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
						src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg" alt="PDF FILE" />
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
						src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/pdf-icon.svg" alt="PDF FILE" />
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
								<button  type="submit" class="dealStatusChangeBtn btn btn-secondary rounded-pill px-3">Submit</button>
							</div>
	</div>

	
	`;

		jQuery(".documentManagementBody .documentViewSection").html(approvalFields);
	}





	jQuery(document).on('click', '.submitApprovalTerms', function () {
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
			.done(function (res) {
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
			.fail(function (error) {
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
			.done(function (res) {
				jQuery('#loadingSpinner').hide();
				// Handle the response from the AJAX call
				if (res.success) {
					alert('Deal deleted successfully');
					mainDealsImportFromServer();
				} else {
					alert('Error wehile delete')
				}
			})
			.fail(function (error) {
				console.error("Error:", error);
			});
	}



	jQuery('#vehiclePurchasAgreementBtn').on('click', function () {
		var rows = jQuery('.vehiclePurchasAgreement');
		if (rows.css('display') == 'none') {
			rows.show();
		} else {
			rows.hide();
		}
	});


	jQuery(document).on('click', '#fundDealBtn', function () {

		jQuery('.documentManagementBody #documentManageTitle').hide();
		jQuery('.documentManagementBody .documentManagementContainer').removeClass('p-3 customModalWidthHalf')
			.addClass(
				'p-0 border-0 customModalWidthFull');

		jQuery('.documentManagementBody .sendDocumentSection').removeClass('d-block').addClass('d-none');
		jQuery('.documentManagementBody .documentViewSection').removeClass('d-none').addClass('d-block');

		var approvalFields = `
	<div class="bg-secondary px-1 px-md-4 py-4 text-center text-white"><h5>Fund Deal</h5></div>

	<div class="px-1 px-md-3 py-3 bg-white">
	<div class="text-center px-5 mx-3 font-14">
	<p>Please enter details to fund this deal , Once you click<br>submit, this deal will be moved to the booked deals section.</p>
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


	jQuery(document).on('click', '#submitFundDeal', function () {
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
			.done(function (res) {
				jQuery('#loadingSpinner').hide();

				// Handle the response from the AJAX call
				if (res.success) {

					// alert('Submited the fund deal.');
					showGlobalAlert('success', `<h3>Submited the fund deal.</h3>`);
					// var meta = res.data;

					financeProgressVerification(entryId, '', 'Booked', 'Booked');


				} else {
					// alert('Error: Could not submit the fund deal.');
					showGlobalAlert('error', `<h3>Error: Could not submit the fund deal.</h3>`);
				}
			})
			.fail(function (error) {
				jQuery('#loadingSpinner').hide();
				console.error("Error:", error);
			});
	});



	jQuery(".vehicle-info-update-btn").on('click', function () {
		jQuery('#loadingSpinner').show();
		var entryId = sessionStorage.getItem('@deal-entry-id');

		const topSection = jQuery('.custom-card.vehicle-vin-section');

		var topSectionVin = topSection.find('#vin-input').val();
		var topSectionStocks = topSection.find('#marketplaceLink').val();
		var topSectionMileage = topSection.find('#mileage-input').val();
		var topSectionVehicleValue = topSection.find('#vehicle-valu').val();
		var topSectionPurchasePrice = topSection.find('#purchase-price').val();
		var topSectionDownPayment = topSection.find('#down-payment').val();
		var topSectionYear = topSection.find('#year').val();
		var topSectionMakeInput = topSection.find('#make-input').val();
		var topSectionModelInput = topSection.find('#model-input').val();
		var topSectionTrim = topSection.find('#trim').val();
		var topSectionColorInput = topSection.find('#color-input').val();
		var topSectionGasDieselHybrid = topSection.find('#gas-diesel-hybrid').val();


		const tradeInSection = jQuery('.trade-in-section.vehicle-vin-section');

		var tradeInSectionVin = tradeInSection.find('#vin-input').val();
		var topTradeInSectionMileage = tradeInSection.find('#mileage-input').val();
		var topTradeInSectionCurrentPrice = tradeInSection.find('#current-price').val();
		var topTradeInSectionPurchasePrice = tradeInSection.find('#purchase-price').val();
		var topTradeInSectionYear = tradeInSection.find('#year').val();
		var topTradeInSectionMakeInput = tradeInSection.find('#make-input').val();
		var topTradeInSectionModelInput = tradeInSection.find('#model-input').val();
		var topTradeInSectionTrim = tradeInSection.find('#trim').val();
		var topTradeInSectionColorInput = tradeInSection.find('#color-input').val();
		var topTradeInSectionGasDieselHybrid = tradeInSection.find('#gas-diesel-hybrid').val();

		var warrantySection = jQuery('.warranty-accessories-prices');
		var warrantySectionPrice1 = warrantySection.find('#blank-price1').val();
		var warrantySectionPrice2 = warrantySection.find('#blank-price2').val();
		var warrantySectionPrice3 = warrantySection.find('#blank-price3').val();
		var warrantySectionPrice4 = warrantySection.find('#blank-price4').val();


		var formData = new FormData();
		formData.append('action', 'add_additional_deal_info');
		formData.append('form_id', <?php echo $credit_form_id; ?>); // Replace with your form ID
		formData.append('entry_id', entryId); // Replace with your entry ID
		formData.append("data_meta", "applicant_information");
		formData.append('form_name', 'Vehicle Information');
		formData.append('form_title', 'Vehicle Information Updated');
		formData.append('userId', <?php echo $userdata->ID; ?>);

		topSectionVin && formData.append('text-13', topSectionVin);
		topSectionStocks && formData.append('url-1', topSectionStocks);
		topSectionMileage && formData.append('topSectionMileage', topSectionMileage);
		topSectionVehicleValue && formData.append('currency-7', topSectionVehicleValue);
		topSectionPurchasePrice && formData.append('currency-2', topSectionPurchasePrice);
		topSectionDownPayment && formData.append('currency-3', topSectionDownPayment);
		topSectionYear && formData.append('topSectionYear', topSectionYear);
		topSectionMakeInput && formData.append('topSectionMakeInput', topSectionMakeInput);
		topSectionModelInput && formData.append('topSectionModelInput', topSectionModelInput);
		topSectionTrim && formData.append('topSectionTrim', topSectionTrim);
		topSectionColorInput && formData.append('topSectionColorInput', topSectionColorInput);
		topSectionGasDieselHybrid && formData.append('topSectionGasDieselHybrid',
			topSectionGasDieselHybrid);



		tradeInSectionVin && formData.append('tradeInSectionVin', tradeInSectionVin);
		topTradeInSectionMileage && formData.append('topTradeInSectionMileage', topTradeInSectionMileage);
		topTradeInSectionCurrentPrice && formData.append('topTradeInSectionCurrentPrice',
			topTradeInSectionCurrentPrice);
		topTradeInSectionPurchasePrice && formData.append('topTradeInSectionPurchasePrice',
			topTradeInSectionPurchasePrice);
		topTradeInSectionYear && formData.append('topTradeInSectionYear', topTradeInSectionYear);
		topTradeInSectionMakeInput && formData.append('topTradeInSectionMakeInput',
			topTradeInSectionMakeInput);
		topTradeInSectionModelInput && formData.append('topTradeInSectionModelInput',
			topTradeInSectionModelInput);
		topTradeInSectionTrim && formData.append('topTradeInSectionTrim', topTradeInSectionTrim);
		topTradeInSectionColorInput && formData.append('topTradeInSectionColorInput',
			topTradeInSectionColorInput);
		topTradeInSectionGasDieselHybrid && formData.append('topTradeInSectionGasDieselHybrid',
			topTradeInSectionGasDieselHybrid);



		warrantySectionPrice1 && formData.append('warrantySectionPrice1', warrantySectionPrice1);
		warrantySectionPrice2 && formData.append('warrantySectionPrice2', warrantySectionPrice2);
		warrantySectionPrice3 && formData.append('warrantySectionPrice3', warrantySectionPrice3);
		warrantySectionPrice4 && formData.append('warrantySectionPrice4', warrantySectionPrice4);


		addAdditionalDealData(formData)
			.done(function (res) {
				jQuery('#loadingSpinner').hide();
				// Handle the response from the AJAX call
				if (res.success) {
					showGlobalAlert('success', `<h3>Successfully Updated Information</h3>`);
				} else {
					// alert('Error wehile updated')
					showGlobalAlert('error', `<h3>Error wehile updated</h3>`);

				}
			})
			.fail(function (error) {
				// alert('Error updated information', error)
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
		var documentProofFileInput = jQuery('#documentProofFileInput')[0];
		var documentProofFile = documentProofFileInput.files[0];
		var firstName = jQuery('.user-details-column #firstName').val();
		var lastName = jQuery('.user-details-column #lastName').val();
		var middleName = jQuery('.user-details-column #middleName').val();
		var emailAddress = jQuery('.user-details-column #emailAddress').val();
		var martialStatus = jQuery('.user-details-column #MartialStatus').val();
		var dob = jQuery('.user-details-column #dob').val();
		var licenseNo = jQuery('.user-details-column #licenseNo').val();
		var streetAddress = jQuery('.user-details-column #streetAddress').val();
		var city = jQuery('.user-details-column #city').val();
		var vendorProvince = jQuery('.user-details-column #vendor-province').val();
		var postalCode = jQuery('.user-details-column #postalCode').val();
		var residenceTypeOption = jQuery('.user-details-column .residence-type-option input[type="radio"]:checked')
			.val();
		console.log("currentEmployerPhoneNumber", residenceTypeOption);
		var timeAtAddress = jQuery('.user-details-column #timeAtAddress').val();
		var monthlyPayment = jQuery('.user-details-column #monthlyPayment').val();
		var mortgageHolder = jQuery('.user-details-column #mortgageHolder').val();
		var previousAddress = jQuery('.user-details-column #previousAddress').val();
		var previousCity = jQuery('#previousCity.text-22').val();
		var previousProvince = jQuery('.user-info-container #previousProvince').val();
		var previousPostalCode = jQuery('.user-details-column #previousPostalCode').val();
		var primaryPhone = jQuery('.user-details-column #primaryPhone').val();
		var secondaryPhone = jQuery('.user-info-card #secondaryPhone').val();
		var sin = jQuery('.user-info-card #sin').val();

		//Current Employer
		var currentEmployer = jQuery('#employmentInformation #current-employer').val();
		var currentEmployerPosition = jQuery('#employmentInformation #position').val();
		var currentEmployerPhoneNumber = jQuery('#employmentInformation #phone-number').val();

		var currentEmployerTimeEmployer = jQuery('#employmentInformation #time-at-employer').val();
		var currentEmployerStreetAddress = jQuery('#employmentInformation #street-address').val();
		var currentEmployerCity = jQuery('#employmentInformation #city').val();
		var currentEmployerProvince = jQuery('#employmentInformation #province').val();
		var currentEmployerPostalCode = jQuery('#employmentInformation #postal-code').val();
		var currentEmployerRasidanceType = jQuery('#employmentInformation').find(
			'.employmentTypeOption input[type="radio"]:checked').val();
		var currentEmployerGrossMonthlyIncome = jQuery('#employmentInformation #gross-monthly-income').val();
		var currentEmployerPreviousEmployer = jQuery('#employmentInformation #previous-employer').val();
		var currentEmployerPreviousPosition = jQuery('#employmentInformation #previous-position').val();
		var currentEmployerPreviousTime = jQuery('#employmentInformation #previous-time').val();
		var currentEmployerOtherIncome = jQuery('#employmentInformation #other-income').val();
		var currentEmployerPaymentFrequency = jQuery('#gross-payment-frequency').val();


		// Co-Applicant  Information

		var coApplicantFirstName = jQuery('.coEmploymentInformation #firstName').val();
		var coApplicantLastName = jQuery('.coEmploymentInformation #lastName').val();
		var coApplicantDob = jQuery('.coEmploymentInformation #dob').val();
		var coApplicantStreetAddress = jQuery('.coEmploymentInformation #street-address').val();
		var coApplicantCity = jQuery('.coEmploymentInformation #city').val();
		var coApplicantProvince = jQuery('.coEmploymentInformation #province').val();
		var coApplicantPostalCode = jQuery('.coEmploymentInformation #postal-code').val();
		var coApplicantResidenceTypeOption = jQuery(
			'.coEmploymentInformation .residence-type-option input[type="radio"]:checked')
			.val();
		var coApplicantTimeAtAddress = jQuery('.coEmploymentInformation #timeAtAddress').val();
		var coApplicantMonthlyPayment = jQuery('.coEmploymentInformation #monthlyPayment').val();
		var coApplicantMortgageHolder = jQuery('.coEmploymentInformation #mortgageHolder').val();
		var coApplicantPreviousAddress = jQuery('.coEmploymentInformation #previousAddress').val();
		var coApplicantPreviousCity = jQuery('.coEmploymentInformation #coApplicantPreviousCity').val();
		var coApplicantPreviousProvince = jQuery('.coEmploymentInformation #province.co-app-previous').val();
		var coApplicantPreviousPostalCode = jQuery('.coEmploymentInformation #previousPostalCode').val();
		var coApplicantEmail = jQuery('.coEmploymentInformation #email').val();
		var coApplicantPrimaryPhone = jQuery('.coEmploymentInformation #primaryPhone').val();
		var coApplicantSecondaryPhone = jQuery('.coEmploymentInformation #secondaryPhone').val();
		var coApplicantSin = jQuery('.coEmploymentInformation #sin').val();

		// Co-Employment Information

		var coEmploymentInfoCurrentEmployer = jQuery('.co-employment #current-employer').val();
		var coEmploymentInfoPosition = jQuery('.co-employment #position').val();
		var coEmploymentInfoPhoneNumber = jQuery('.co-employment #phone-number').val();
		var coEmploymentInfoTimeEmployer = jQuery('.co-employment #time-at-employer').val();
		var coEmploymentInfoStreetAddress = jQuery('.co-employment #street-address').val();
		var coEmploymentInfoCity = jQuery('.co-employment #city').val();
		var coEmploymentInfoProvince = jQuery('.co-employment #province').val();
		var coEmploymentInfoPostalCode = jQuery('.co-employment #postal-code').val();
		var coEmploymentInfoResidenceTypeOption = jQuery(
			'.co-employment .residence-type-option input[type="radio"]:checked')
			.val();

		var coEmploymentInfoGrossMonthlyIncome = jQuery('.co-employment #gross-monthly-income').val();
		var coEmploymentInfoPreviousEmployer = jQuery('.co-employment #previous-employer').val();
		var coEmploymentInfoPreviousPosition = jQuery('.co-employment #previous-position').val();
		var coEmploymentInfoPreviousTime = jQuery('.co-employment #previous-time').val();
		var coEmploymentInfoOtherIncome = jQuery('.co-employment #other-income').val();



		var additionalvin = jQuery('.additional-seller-info #vin').val();
		var additionalyear = jQuery('.additional-seller-info #year').val();
		var additionalmake = jQuery('.additional-seller-info #make').val();
		var additionalmodel = jQuery('.additional-seller-info #model').val();

		var sellerEmail = jQuery('.dealSellerInformation #dealerEmailAddress').val();
		var sellerName = jQuery('.dealSellerInformation #sellerName').val();
		var sellerPhone = jQuery('.dealSellerInformation #dealSellerPhone').val();

		var sellerType = jQuery('.dealSellerInformation #sellerType').val();
		// var additionalyear3 = jQuery('.additional-seller-info #year3').val();



		var additionalpickupAddress = jQuery('.additional-seller-info #pickupAddress').val();
		var additionaldropOffAddress = jQuery('.additional-seller-info #dropOffAddress').val();

		var additionalTransportDeliveryAmount = jQuery('.transport-delivery-amount input').val();


		var financeAddOnGaapInc = jQuery(
			'.additional-seller-info .gaap-insurance input[type="radio"]:checked').val();
		var financeAddOnLifeInc = jQuery(
			'.additional-seller-info .life-insurance input[type="radio"]:checked').val();
		var financeAddOnVehicleWarranty = jQuery(
			'.additional-seller-info .vehicle-warranty input[type="radio"]:checked').val();
		var financeAddOnIncludeTurboBIdDelivery = jQuery(
			'.additional-seller-info .includeTurboBIdDelivery input[type="radio"]:checked').val();
		var financeAddOnInspectionRequested = jQuery(
			'.additional-seller-info .inspectionRequested input[type="radio"]:checked').val();


		// Collect values from the other income section
		var otherIncomeAmount = jQuery('#otherIncomeAmount').val() || '';
		var otherIncomeFrequency = jQuery('#otherIncomeFrequency').val() || '';
		var otherIncomeType = jQuery('#otherIncomeType').val() || '';
		var otherIncomeDescription = jQuery('#otherIncomeDescription').val() || '';

		// Collect values from the housing section
		var homeStatus = jQuery('#homeStatus').val() || '';
		var mortageHolder = jQuery('#mortageHolder').val() || '';
		var monthlyHousingPayment = jQuery('#monthlyHousingPayment').val() || '';
		var marketValue = jQuery('#marketValue').val() || '';
		var mortagePayment = jQuery('#mortagePayment').val() || '';
		var additionalInfo = jQuery('#additionalInfo').val() || '';



		var formData = new FormData();
		formData.append('action', 'add_additional_deal_info');
		formData.append('form_id', <?php echo $credit_form_id; ?>); // Replace with your form ID
		formData.append('entry_id', entryId); // Replace with your entry ID
		formData.append("data_meta", "applicant_information");
		formData.append('form_name', 'Deal Applicant Information');
		formData.append('form_title', 'Deal Applicant Information Updated');
		formData.append('userId', <?php echo $userdata->ID; ?>);
		firstName && formData.append('name-1', firstName);
		lastName && formData.append('name-2', lastName);
		middleName && formData.append('middle-name', middleName);
		dob && formData.append('date-1', dob);
		licenseNo && formData.append('text-4', licenseNo);
		streetAddress && formData.append('text-15', streetAddress);
		city && formData.append('text-16', city);
		vendorProvince && formData.append('select-3', vendorProvince);
		postalCode && formData.append('text-17', postalCode);
		residenceTypeOption && formData.append('residenceTypeOption', residenceTypeOption);
		timeAtAddress && formData.append('text-18', timeAtAddress);
		monthlyPayment && formData.append('text-19', monthlyPayment);
		mortgageHolder && formData.append('text-20', mortgageHolder);
		previousAddress && formData.append('text-21', previousAddress);
		previousCity && formData.append('text-22', previousCity);
		previousProvince && formData.append('select-4', previousProvince);
		previousPostalCode && formData.append('text-23', previousPostalCode);
		primaryPhone && formData.append('phone-1', primaryPhone);
		secondaryPhone && formData.append('phone-2', secondaryPhone);
		sin && formData.append('text-2', sin);
		martialStatus && formData.append('select-9', martialStatus);
		// emailAddress && formData.append('email-1', emailAddress);

		//Current Employer
		currentEmployer && formData.append('name-3', currentEmployer);
		currentEmployerPosition && formData.append('text-8', currentEmployerPosition);
		currentEmployerPhoneNumber && formData.append('phone-4', currentEmployerPhoneNumber);
		currentEmployerTimeEmployer && formData.append('text-10', currentEmployerTimeEmployer);
		currentEmployerStreetAddress && formData.append('text-29', currentEmployerStreetAddress);
		currentEmployerCity && formData.append('text-27', currentEmployerCity);
		currentEmployerProvince && formData.append('select-6', currentEmployerProvince);
		currentEmployerPostalCode && formData.append('text-28', currentEmployerPostalCode);
		currentEmployerRasidanceType && formData.append('employ-residence-type-option',
			currentEmployerRasidanceType);
		currentEmployerGrossMonthlyIncome && formData.append('currency-1', currentEmployerGrossMonthlyIncome);
		currentEmployerPreviousEmployer && formData.append('text-5', currentEmployerPreviousEmployer);
		currentEmployerPreviousPosition && formData.append('previous-employer-position',
			currentEmployerPreviousPosition);
		currentEmployerPreviousTime && formData.append('text-31', currentEmployerPreviousTime);
		currentEmployerOtherIncome && formData.append('text-32', currentEmployerOtherIncome);
		currentEmployerPaymentFrequency && formData.append('select-11', currentEmployerPaymentFrequency);


		// Co-Applicant  Information

		coApplicantFirstName && formData.append('co-applicicant-first-name', coApplicantFirstName);
		coApplicantLastName && formData.append('co-applicicant-last-name', coApplicantLastName);
		coApplicantDob && formData.append('co-applicicant-dob', coApplicantDob);
		coApplicantStreetAddress && formData.append('text-55', coApplicantStreetAddress);
		coApplicantCity && formData.append('text-52', coApplicantCity);
		coApplicantProvince && formData.append('select-16', coApplicantProvince);
		coApplicantPostalCode && formData.append('text-57', coApplicantPostalCode);
		coApplicantResidenceTypeOption && formData.append('co-applicicant-residence-type',
			coApplicantResidenceTypeOption);
		// coApplicantTimeAtAddress && formData.append('text-53', coApplicantTimeAtAddress);
		coApplicantMonthlyPayment && formData.append('co-applicicant-monthly-payment', coApplicantMonthlyPayment);
		coApplicantMortgageHolder && formData.append('co-applicicant-mortgage-holder', coApplicantMortgageHolder);
		coApplicantPreviousAddress && formData.append('co-applicicant-previous-address',
			coApplicantPreviousAddress);
		coApplicantPreviousCity && formData.append('co-applicicant-previous-city', coApplicantPreviousCity);
		coApplicantPreviousProvince && formData.append('select-16',
			coApplicantPreviousProvince);
		coApplicantPreviousPostalCode && formData.append('co-applicicant-previous-postal-code',
			coApplicantPreviousPostalCode);
		coApplicantEmail && formData.append('co-applicicant-previous-email', coApplicantEmail);
		coApplicantPrimaryPhone && formData.append('co-applicicant-previous-phone', coApplicantPrimaryPhone);
		coApplicantSecondaryPhone && formData.append('co-applicicant-previous-secondary-phone',
			coApplicantSecondaryPhone);
		coApplicantSin && formData.append('co-applicicant-previous-sin', coApplicantSin);

		// Co-Employment Information

		coEmploymentInfoCurrentEmployer && formData.append('name-5',
			coEmploymentInfoCurrentEmployer);
		coEmploymentInfoPosition && formData.append('text-63', coEmploymentInfoPosition);
		coEmploymentInfoPhoneNumber && formData.append('phone-7',
			coEmploymentInfoPhoneNumber);
		// coEmploymentInfoTimeEmployer && formData.append('co-employment-employer-time-address',
		// 	coEmploymentInfoTimeEmployer);
		coEmploymentInfoStreetAddress && formData.append('text-60',
			coEmploymentInfoStreetAddress);
		coEmploymentInfoCity && formData.append('text-62',
			coEmploymentInfoCity);
		coEmploymentInfoProvince && formData.append('select-17',
			coEmploymentInfoProvince);
		coEmploymentInfoPostalCode && formData.append('text-61',
			coEmploymentInfoPostalCode);
		coEmploymentInfoResidenceTypeOption && formData.append('co-employment-employer-residence-type',
			coEmploymentInfoResidenceTypeOption);
		coEmploymentInfoGrossMonthlyIncome && formData.append('currency-8',
			coEmploymentInfoGrossMonthlyIncome);
		coEmploymentInfoPreviousEmployer && formData.append('co-employment-employer-previous-employer',
			coEmploymentInfoPreviousEmployer);
		coEmploymentInfoPreviousPosition && formData.append('co-employment-employer-previous-position',
			coEmploymentInfoPreviousPosition);
		coEmploymentInfoPreviousTime && formData.append('co-employment-employer-previous-time',
			coEmploymentInfoPreviousTime);
		coEmploymentInfoOtherIncome && formData.append('co-employment-employer-other-income',
			coEmploymentInfoOtherIncome);

		// Additional-Seller Info/Add Ons

		additionalvin && formData.append('text-13', additionalvin);
		additionalyear && formData.append('select-2', additionalyear);
		additionalmake && formData.append('select-1', additionalmake);
		additionalmodel && formData.append('text-14', additionalmodel);

		sellerEmail && formData.append('email-2', sellerEmail);
		sellerName && formData.append('name-4', sellerName);
		sellerPhone && formData.append('phone-6', sellerPhone);

		sellerType && formData.append('select-7', sellerType);
		// additionalyear3 && formData.append('additionalyear3', additionalyear3);



		additionalpickupAddress && formData.append('text-36', additionalpickupAddress);
		additionaldropOffAddress && formData.append('text-37', additionaldropOffAddress);

		additionalTransportDeliveryAmount && formData.append('text-38', additionalTransportDeliveryAmount);


		financeAddOnGaapInc && formData.append('radio-2', financeAddOnGaapInc);
		financeAddOnLifeInc && formData.append('radio-3', financeAddOnLifeInc);
		financeAddOnVehicleWarranty && formData.append('radio-4', financeAddOnVehicleWarranty);
		financeAddOnIncludeTurboBIdDelivery && formData.append('radio-5',
			financeAddOnIncludeTurboBIdDelivery);
		financeAddOnInspectionRequested && formData.append('radio-6',
			financeAddOnInspectionRequested);


		// Append applicant-other-income values
		formData.append('currency-4', otherIncomeAmount);
		formData.append('select-13', otherIncomeFrequency);
		formData.append('select-14', otherIncomeType);
		formData.append('text-45', otherIncomeDescription);

		// Append applicant-housing values
		formData.append('select-10', homeStatus);
		formData.append('text-43', mortageHolder);
		formData.append('currency-5', monthlyHousingPayment);
		formData.append('currency-7', marketValue);
		formData.append('currency-6', mortagePayment);
		formData.append('text-39', additionalInfo);


		// console.log("documentProofFileInput: ", documentProofFileInput)
		// console.log("documentProofFile: ", documentProofFile)


		// Get the first file (single file)
		if (documentProofFile) {
			formData.append('documentProofFile', documentProofFile, documentProofFile.name); // Append the file if it exists
		}


		for (var pair of formData.entries()) {
			console.log(pair[0] + ': ' + pair[1]);
		}

		addAdditionalDealData(formData)
			.done(function (res) {
				jQuery('#loadingSpinner').hide();
				// Handle the response from the AJAX call
				if (res.success) {

					jQuery('.documentManagementBody').removeClass('d-flex d-block').addClass('d-none');

					jQuery('.documentManagementBody .sendDocumentSection .goPaperworkBtn').remove();


					showGlobalAlert('success', `<h3>Successfully Updated Deal Information</h3>`);
					// alert('Successfully Updated Deal Information')

					jQuery(".buyerName").text(firstName + ' ' + lastName);
					jQuery(".buyerPhone").attr('href', `tel:${primaryPhone}`);


				} else {
					// alert('Error updated deal information')
					showGlobalAlert('error', `<h3>Error updated deal information</h3>`);
				}
			})
			.fail(function (error) {
				// alert('Error updated seal information', error)
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
	jQuery('#addClientNote').on('click', function (e) {
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
		formData.append("form_id", 337873); // Replace with your form ID
		formData.append("entry_id", entryId);
		formData.append("data_meta", "deal_client_notes");
		formData.append('form_name', 'Deal Client Note Added');
		formData.append('form_title', 'Deal client note submitted');
		formData.append('note', note); // Add note content
		formData.append('senderName', firstName + ' ' + lastName);
		formData.append('userPhoto', '<?php echo $CORE->USER('get_avatar', $userdata->ID); ?>');

		addAdditionalDealData(formData)
			.done(function (res) {
				jQuery('#loadingSpinner').hide();
				if (res.success) {
					alert('Successfully added note');
					getDealBasedNotes(); // Refresh notes
				} else {
					alert('Error adding note');
					console.log(res);
				}
			})
			.fail(function (error) {
				jQuery('#loadingSpinner').hide();
				alert('Error adding note');
				console.error("Error:", error);
			});
	});

	jQuery('#addNewNoteForDeal').on('click', function (e) {
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
		formData.append("form_id", 337873); // Replace with your form ID
		formData.append("entry_id", entryId);
		formData.append("data_meta", "deal_note_documents");
		formData.append('form_name', 'Deal Note Added');
		formData.append('form_title', 'Deal note submitted');
		formData.append('note', note); // Add note content
		formData.append('taskStatus', taskStatus);
		formData.append('senderName', firstName + ' ' + lastName);
		formData.append('userPhoto', '<?php echo $CORE->USER('get_avatar', $userdata->ID); ?>');

		addAdditionalDealData(formData)
			.done(function (res) {
				jQuery('#loadingSpinner').hide();
				if (res.success) {
					// alert('Successfully added notes');
					showGlobalAlert('success', `<h3>Successfully added notes</h3>`);
					getDealBasedNotes(); // Refresh notes
				} else {
					// alert('Error adding notes');
					showGlobalAlert('error', `<h3>Error adding note</h3>`);
					console.log(res);
				}
			})
			.fail(function (error) {
				jQuery('#loadingSpinner').hide();
				// alert('Error adding note');
				showGlobalAlert('error', `<h3>Error adding note</h3>`);
				console.error("Error:", error);
			});
	});


	function getDealBasedNotes() {

		jQuery('#loadingSpinner').show();
		var entryId = sessionStorage.getItem('@deal-entry-id');

		var formData = new FormData();
		formData.append("action", "get_deal_notes");
		formData.append("form_id",
			337873); // Replace with your form ID
		formData.append("entry_id", entryId);

		addAdditionalDealData(formData)
			.done(function (res) {
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
			.fail(function (error) {
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


	function showNotesInContainer(notes) {
		let noteContent = '';

		if (notes.length > 0) {

			notes.forEach(function (note) {
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
		notes.sort(function (a, b) {
			const priority = {
				"High": 1,
				"Medium": 2,
				"Low": 3
			}; // Define priority ranking
			return (priority[a.task_status] || 4) - (priority[b.task_status] || 4);
		});

		let statusPriorityBasedNotes = '';

		notes.forEach(function (note) {
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







	jQuery('.finance-back-main').click(function () {
		jQuery('.finance-entry-details').addClass('d-none');
		jQuery('.finance-back-main').addClass('d-none');
		jQuery('.admin-finance-order-data').removeClass('d-none');
	});




	// Usage example



	function insertApplicantInfo(meta) {

		var info = `
	
	<div class="info-group">
									<div class="form-row">
										<div class="form-group col-12 col-md-4">
											<label for="firstName" class="field-label">First Name</label>
											<input id="firstName" class="form-control" type="text" value="${meta['name-1'] || ''}">
										</div>
										 <div class="form-group col-12 col-md-4">
											<label for="middleName" class="field-label">Middle Name</label>
											<input id="middleName" class="form-control" type="text" value="${meta['middle-name'] || ''}">
										</div>
										<div class="form-group col-12 col-md-4">
											<label for="lastName" class="field-label">Last Name</label>
											<input id="lastName" class="form-control" type="text" value="${meta['name-2'] || ''}">
										</div>
										
									</div>
								</div>
								<div class="info-group">
									<div class="form-row">

									<div class="form-group col-12 col-md-4">
											<label for="dob" class="field-label">Date of Birth (DD/MM/YY)</label>
											<input id="dob" class="form-control" type="date" value="${meta['date-1'] ? formatDateToISO(meta['date-1']) : ''}">
										</div>

										 <div class="form-group col-12 col-md-4">
											<label for="salutations" class="field-label">Salutations</label>
											<input id="salutations" class="form-control disabled" type="text"
												value="${meta['select-8'] || ''}" >
										</div>


										 <div class="form-group col-12 col-md-4">
											<label for="MartialStatus" class="field-label">Martial Status</label>
											<input id="MartialStatus" class="form-control" type="text"
												value="${meta['select-9'] || ''}" >
										</div>

									   
									</div>
								</div>


								<div class="info-group font-14">
								 <span>Residence Type</span>
								 <div class="residence-type-option d-flex align-items-center justify-content-start ">
													<div class="form-check  d-flex align-items-center">
														<input type="radio" name="residenceType" value="rent" ${meta['residenceTypeOption'] == 'rent' ? 'checked' : ''}
															class="form-check-input residence-type-rent"><label>
															Rent</label>
													</div>
													<div class="form-check d-flex align-items-center">
														<input type="radio" name="residenceType" value="own"  ${meta['residenceTypeOption'] == 'own' ? 'checked' : ''}
															class="form-check-input residence-type-own"><label>
															Own</label>
													</div>
													<div class="form-check d-flex align-items-center">
														<input type="radio" name="residenceType" ${meta['residenceTypeOption'] == 'live-parents' ? 'checked' : ''}
															value="Live with Parents" 
															class="form-check-input residence-type-live-parents"><label>Live
															with Parents</label>
													</div>
												</div>
								</div>


								<div class="info-group">

									<div class="form-row">

									 <div class="form-group col-12 col-md-4  ">
											<label for="streetAddress" class="field-label">Address</label>
											<input id="streetAddress" class="form-control  googleAutoLocation" type="text"
												value="${meta['text-15'] || ''}">
										</div>
										 <div class="form-group col-12 col-md-4  ">
											<label for="streetAddress2" class="field-label">Address 2</label>
											<input id="streetAddress2" class="form-control  googleAutoLocation" type="text"
												value="${meta['text-47'] || ''}">
										</div>

										 <div class="form-group col-12 col-md-4">
											<label for="postalCode" class="field-label">Postal Code</label>
											<input id="postalCode" class="form-control" type="text" value="${meta['text-17'] || ''}">
										</div>

									</div>
								</div>

								<div class="info-group">
									<div class="form-row">

									<div class="form-group col-12 col-md-4">
											<label for="city" class="field-label">City</label>
											<input id="city" class="form-control" type="text" value="${meta['text-16'] || ''}">
										</div>

										<div class="form-group col-12 col-md-4">
											<label for="province" class="field-label">Province</label>
										<select type="text" id="vendor-province" class="form-control rounded-pill vendor-province">

										<option>Alberta</option>
										<option>British Columbia</option>
										<option>Manitoba</option>
										<option>New Brunswick</option>
										<option>Newfoundland and Labrador</option>
										<option >Northwest Territories</option>
										<option >Nova Scotia</option>
										<option >Nunavut</option>
										<option >Ontario</option>
										<option >Prince Edward Island</option>
										<option >Quebec</option>
										<option >Saskatchewan</option>
										<option >Yukon</option>

									</select>
										</div>

										
										 <div class="form-group col-12 col-md-2">
											<label for="timeAtAddress" class="field-label">Years</label>
											<input id="timeAtAddress" class="form-control" type="text" value="${meta['text-6'] || ''}">
										</div>

										   <div class="form-group col-12 col-md-2">
											<label for="timeAtAddress" class="field-label">Months</label>
											<input id="timeAtAddress" class="form-control" type="text" value="${meta['text-7'] || ''}">
										</div>

									

									</div>
								</div>


								<div class="info-group">
									<div class="form-row">

									<div class="form-group col-12 col-md-4">
											<label for="primaryPhone" class="field-label">Primary Phone Number</label>
											<input id="primaryPhone" class="form-control disabled" type="tel"
												value="${meta['phone-1'] || ''}">
									</div>

									 <div class="form-group col-12 col-md-4">
											<label for="secondaryPhone" class="field-label">Second Phone Number</label>
											<input id="secondaryPhone" class="form-control" type="tel"
												value="${meta['phone-2'] || ''}" >
									</div>

									 <div class="form-group col-12 col-md-4">
											<label for="emailAddress" class="field-label">E-Mail Address</label>
											<input id="emailAddress" class="form-control disabled" type="email"
												value="${meta['email-1'] || ''}">
									</div>

									</div>
								</div>

								 <div class="info-group">
									<div class="form-row">

									<div class="form-group col-12 col-md-4">
									<label for="licenseNo" class="field-label">Driver License No.</label>
									<input id="licenseNo" class="form-control" type="text" value="${meta['text-4'] || ''}">
									</div>

									<div class="form-group col-12 col-md-4">
											<label for="sin" class="field-label">Social Insurance Number</label>
											<input id="sin" class="form-control" type="tel"
												value="${meta['text-2'] || ''}">
									</div>

			  
									</div>
								</div>                 
	
	`;




		var previousAddressSection = `
	

		<div class="form-row">
			 <div class="form-group col-12 col-md-4  ">
											<label for="previousAddress" class="field-label">Address</label>
											<input id="previousAddress" class="form-control  googleAutoLocation" type="text" value="${meta['text-15'] || ''}">
			   </div>

				<div class="form-group col-12 col-md-4  ">
											<label for="previousAddress2" class="field-label">Address 2</label>
											<input id="previousAddress2" class="form-control  googleAutoLocation" type="text" value="${meta['text-47'] || ''}">
			   </div>

				<div class="form-group col-12 col-md-4">
											<label for="previousPostalCode" class="field-label">Postal Code</label>
											<input id="previousPostalCode" class="form-control" type="text" value="${meta['text-17'] || ''}">
				</div>


		</div>

		   <div class="form-row">
			  <div class="form-group col-12 col-md-4">
											<label for="previousCity" class="field-label">City</label>
											<input id="previousCity" class="text-22 form-control" type="text" value="${meta['text-16'] || ''}">
										</div>

				  <div class="form-group col-12 col-md-4">
											<label for="previousProvince" class="field-label">Province</label>
											 <select type="text" id="previousProvince" class="form-control rounded-pill vendor-province">

										<option>Alberta</option>
										<option>British Columbia</option>
										<option>Manitoba</option>
										<option>New Brunswick</option>
										<option>Newfoundland and Labrador</option>
										<option >Northwest Territories</option>
										<option >Nova Scotia</option>
										<option >Nunavut</option>
										<option >Ontario</option>
										<option >Prince Edward Island</option>
										<option >Quebec</option>
										<option >Saskatchewan</option>
										<option >Yukon</option>

									</select>
				  </div>

				

				 <div class="form-group col-12 col-md-2">
											<label for="yearAtATime" class="field-label">Years</label>
											<input id="yearAtATime" class="form-control" type="text" value="${meta['text-6'] || ''}">
										</div>

										   <div class="form-group col-12 col-md-2">
											<label for="timeAtAddress" class="field-label">Months</label>
											<input id="timeAtAddress" class="form-control" type="text" value="${meta['text-7'] || ''}">
										</div>


		</div>
	
	`;


		jQuery('.previousAddressSection').html(previousAddressSection);

		var dealSellerInformation = `
	

		<div class="form-row">
			 <div class="form-group col-12 col-md-3  ">
											<label for="dealSellerName" class="field-label">Seller Name</label>
											<input id="dealSellerName" class="form-control" type="text" value="${meta['name-4'] || ''}">
			   </div>

				<div class="form-group col-12 col-md-3  ">
											<label for="Seller Email" class="field-label">Email Address</label>
											<input id="dealerEmailAddress" id="Seller Email" class="form-control" type="text" value="${meta['email-2'] || ''}">
			   </div>

				<div class="form-group col-12 col-md-3">
											<label for="dealSellerPhone" class="field-label">Phone</label>
											<input id="dealSellerPhone" class="form-control" type="text" value="${meta['phone-6'] || ''}">
				</div>

				 <div class="form-group col-12 col-md-3">
											<label for="dealSellerType" class="field-label">Seller Type</label>
											<input id="dealSellerType" class="form-control" type="text" value="${meta['select-7'] || ''}">
				</div>


		</div>

		</div>
	
	`;


		jQuery('.dealSellerInformation').html(dealSellerInformation);





		var employmentInfo = `


	
	
	 <div class="form-row">
							<div class="form-group col-md-3">
								<label for="current-employer" class="info-label">Current Employer</label>
								<input type="text" id="current-employer" class="form-control current-employer-name"
									value="${meta['name-3'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="position" class="info-label">Position</label>
								<input type="text" id="position" class="form-control current-employer"
									value="${meta['text-8'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="phone-number" class="info-label">Phone number</label>
								<input type="tel" id="phone-number" class="form-control current-employer"
									value="${meta['phone-4'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="time-at-employer" class="info-label">Time at Employer</label>
								<input type="text" id="time-at-employer" class="form-control current-employer font-weight-bold"
									value="${meta['text-10'] || ''} Year(s), ${meta['text-11'] || ''} Month(s)" readonly>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-3  ">
								<label for="street-address" class="info-label">Street Address</label>
								<input type="text" id="street-address" class="form-control current-employer  googleAutoLocation"  value="${meta['text-49'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="city" class="info-label">City</label>
								<input type="text" id="city" class="form-control current-employer" value="${meta['text-50'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="province" class="info-label">Province</label>
								<select type="text" id="province" class="form-control current-employer">
										<option>Alberta</option>
										<option>British Columbia</option>
										<option>Manitoba</option>
										<option>New Brunswick</option>
										<option>Newfoundland and Labrador</option>
										<option >Northwest Territories</option>
										<option >Nova Scotia</option>
										<option >Nunavut</option>
										<option >Ontario</option>
										<option >Prince Edward Island</option>
										<option >Quebec</option>
										<option >Saskatchewan</option>
										<option >Yukon</option>
								
								</select>
							</div>
							<div class="form-group col-md-3">
								<label for="postal-code" class="info-label">Postal Code</label>
								<input type="text" id="postal-code" class="form-control current-employer" value="${meta['text-65'] || ''}">
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-6">
								<span>Employment Type</span>
								<div class="employmentTypeOption d-flex align-items-center justify-content-start mt-2">
									<div class="form-check d-flex align-items-center">
										<input class="form-check-input" type="radio" id="full-time"  value="Full time" ${meta['employ-residence-type-option'] == 'Full time' ? 'checked' : ''}
											name="employment-type">
										<label for="full-time">Full time</label>
									</div>
									<div class="form-check d-flex align-items-center ml-2">
										<input class="form-check-input" type="radio" id="part-time" value="Part time" ${meta['employ-residence-type-option'] == 'Part time' ? 'checked' : ''}
											name="employment-type">
										<label for="part-time">Part time</label>
									</div>
									<div class="form-check d-flex align-items-center ml-2">
										<input class="form-check-input" type="radio" id="contract" value="Contract" ${meta['employ-residence-type-option'] == 'Contract' ? 'checked' : ''}
											name="employment-type"  >
										<label for="contract">Contract</label>
									</div>
									<div class="form-check d-flex align-items-center ml-2">
										<input class="form-check-input" type="radio" id="seasonal" value="Seasonal" ${meta['employ-residence-type-option'] == 'Seasonal' ? 'checked' : ''}
											name="employment-type"  >
										<label for="seasonal">Seasonal</label>
									</div>
									<div class="form-check d-flex align-items-center ml-2">
										<input class="form-check-input" type="radio" id="retired" value="Retired" ${meta['employ-residence-type-option'] == 'Retired' ? 'checked' : ''}
											name="employment-type"  >
										<label for="retired">Retired</label>
									</div>
								</div>
							</div>           
							<div class="form-group col-md-3">
								<label for="gross-monthly-income" class="info-label">Income</label>
								<input type="text" id="gross-monthly-income" class="form-control current-employer"
									value="${meta['currency-1'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="gross-payment-frequency" class="info-label">Payment Frequency </label>
								<input type="text" id="gross-payment-frequency" class="form-control current-employer"
									value="${meta['select-11'] || ''}">
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-3">
								<label for="previous-employer" class="info-label">Previous Employer</label>
								<input type="text" id="previous-employer" class="form-control previous-employer-name" value="${meta['text-5'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="previous-position" class="info-label">Previous Position</label>
								<input id="previous-position" class="form-control previous-employer" type="text" value="${meta['previous-employer-position'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="previous-time" class="info-label">Time at Employer</label>
								<input id="previous-time" class="form-control previous-employer" type="text" value="${meta['text-31'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="other-income" class="info-label">Other Monthly Income</label>
								<input id="other-income" class="form-control previous-employer" type="text" value="${meta['text-32'] || ''}">
							</div>

						</div>
	
	`;



		var coAApplicantInfo = `
   
						<div class="form-row">
							<div class="form-group col-md-4">
								<label for="firstName">First Name</label>
								<input value="${meta['co-applicicant-first-name'] || ''}" type="text" id="firstName"  class="form-control co-app">
							</div>
							<div class="form-group col-md-4">
								<label for="lastName">Last Name</label>
								<input  type="text" id="lastName" value="${meta['co-applicicant-last-name'] || ''}" class="form-control co-app">
							</div>
							
							<div class="form-group col-12 col-md-4">
											<label for="dob" class="field-label">Date of Birth (DD/MM/YY)</label>
											<input id="dob" class="form-control" type="date" value="${meta['co-applicicant-dob'] ? formatDateToISO(meta['co-applicicant-dob']) : ''}">
										</div>

						</div>

						<div class="form-row">
							<div class="form-group col-md-3  ">
								<label for="street-address" class="info-label">Street Address</label>
								<input type="text" id="street-address" class="form-control co-app  googleAutoLocation" value="${meta['text-55'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="city" class="info-label">City</label>
								<input type="text" id="city" class="form-control co-app" value="${meta['text-52'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="province" class="info-label">Province</label>
								<select type="text" id="province" class="form-control co-app">

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
								<input type="text" id="postal-code" class="form-control co-app" value="${meta['text-57'] || ''}">
							</div>
						</div>

						<div class="form-row">


							<div class="form-group col-md-3 co-app">
								<span>Residence Type</span>
								<div class="residence-type-option d-flex align-items-center justify-content-start mt-2">
									<div class="form-check  d-flex align-items-center">
										<input type="radio" name="residenceType" value="rent"
											class="form-check-input residence-type-rent"  ><label>
											Rent</label>
									</div>
									<div class="form-check d-flex align-items-center">
										<input type="radio" name="residenceType" value="own" 
											class="form-check-input residence-type-own"><label>
											Own</label>
									</div>
									<div class="form-check d-flex align-items-center">
										<input type="radio" name="residenceType" value="Live with Parents"
											class="form-check-input residence-type-live-parents"><label>Live
											with Parents</label>
									</div>
								</div>
							</div>

							<div class="form-group col-md-3">
								<label for="timeAtAddress" class="address-label">Time at Address</label>
								<input type="text" id="timeAtAddress" class="form-control co-app" value="${meta['text-53'] || '0'} Year(s), ${meta['text-54'] || '0'} Months(s)">
							</div>
							<div class="form-group col-md-3">
								<label for="monthlyPayment" class="address-label">Monthly Payment</label>
								<input type="text" id="monthlyPayment" class="form-control co-app" value="${meta['co-applicicant-monthly-payment'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="mortgageHolder" class="address-label">Mortgage Holder</label>
								<input type="text" id="mortgageHolder" class="form-control co-app" value="${meta['co-applicicant-mortgage-holder'] || ''}">
							</div>




						</div>


						<div class="form-row">




							<div class="form-group col-md-3  ">
								<label for="previousAddress" class="address-label">Previous Street Address (if less than
									2 years)</label>
								<input type="text" id="previousAddress" class="form-control co-app-previous  googleAutoLocation" value="${meta['co-applicicant-previous-address'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="coApplicantPreviousCity" class="address-label">City</label>
								<input type="text" id="coApplicantPreviousCity" class="form-control co-app-previous"  value="${meta['co-applicicant-previous-city'] || ''}">
							</div>

							<div class="form-group col-md-3">
								<label for="province" class="info-label">Province</label>
								<select type="text" id="province" class="form-control co-app-previous">

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
								<label for="previousPostalCode" class="address-label">Postal Code</label>
								<input type="text" id="previousPostalCode" class="form-control co-app-previous" value="${meta['co-applicicant-previous-postal-code'] || ''}">
							</div>






						</div>



						<div class="form-row ">




							<div class="form-group col-md-3">
								<label for="email" class="contact-label">Email Address</label>
								<input type="email" id="email" class="form-control co-app" value="${meta['co-applicicant-previous-email'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="primaryPhone" class="contact-label">Primary Phone Number</label>
								<input type="tel" id="primaryPhone" class="form-control co-app" value="${meta['co-applicicant-previous-phone'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="secondaryPhone" class="contact-label">Second Phone Number</label>
								<input type="tel" id="secondaryPhone" class="form-control co-app"  value="${meta['co-applicicant-previous-secondary-phone'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="sin" class="contact-label">Social Insurance Number</label>
								<input type="text" id="sin" class="form-control co-app" value="${meta['co-applicicant-previous-sin'] || ''}">
							</div>




						</div>


			   
	
	`;


		// Co-Employment Information

		var coEmploymentInformation = `
	

						<div class="form-row">
							<div class="form-group col-md-3">
								<label for="current-employer" class="info-label">Current Employer</label>
								<input type="text" id="current-employer" class="form-control current-employer-name"
									value="${meta['name-5'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="position" class="info-label">Position</label>
								<input type="text" id="position" class="form-control current-employer"  value="${meta['text-63'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="phone-number" class="info-label">Phone number</label>
								<input type="tel" id="phone-number" class="form-control current-employer" value="${meta['phone-7'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="time-at-employer" class="info-label">Time at Employer</label>
								<input type="text" id="time-at-employer" class="form-control current-employer" value="${meta['text-53'] || ''} Year(s), ${meta['text-54'] || ''} Months(s)">
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-3  ">
								<label for="street-address" class="info-label">Street Address</label>
								<input type="text" id="street-address" class="form-control current-employer  googleAutoLocation" value="${meta['text-60'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="city" class="info-label">City</label>
								<input type="text" id="city" class="form-control current-employer" value="${meta['text-62'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="province" class="info-label">Province</label>
								<select type="text" id="province" class="form-control current-employer">

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
								<input type="text" id="postal-code" class="form-control current-employer" value="${meta['text-61'] || ''}">
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-9">
								<span>Employment Type</span>
								<div class="residence-type-option d-flex align-items-center justify-content-start mt-2">
									<div class="form-check  d-flex align-items-center">
										<input class="form-check-input" type="radio" id="full-time" value="Full time"
											name="employment-type"  ${meta['co-employment-employer-residence-type'] === 'Full time' ? 'checked' : ''}>
										<label for="full-time">Full time</label>
									</div>
									<div class="form-check  d-flex align-items-center">
										<input class="form-check-input" type="radio" id="part-time"  value="Part time"
											name="employment-type" ${meta['co-employment-employer-residence-type'] === 'Part time' ? 'checked' : ''}>
										<label for="part-time">Part time</label>
									</div>
									<div class="form-check  d-flex align-items-center">
										<input class="form-check-input" type="radio" id="contract" value="Contract"
											name="employment-type" ${meta['co-employment-employer-residence-type'] === 'Contract' ? 'checked' : ''}>
										<label for="contract">Contract</label>
									</div>
									<div class="form-check  d-flex align-items-center">
										<input class="form-check-input" type="radio" id="seasonal" value="Seasonal"
											name="employment-type" ${meta['co-employment-employer-residence-type'] === 'Seasonal' ? 'checked' : ''}>
										<label for="seasonal">Seasonal</label>
									</div>
									<div class="form-check  d-flex align-items-center">
										<input class="form-check-input" type="radio" id="retired" value="Retired"
											name="employment-type" ${meta['co-employment-employer-residence-type'] === 'Retired' ? 'checked' : ''}>
										<label for="retired">Retired</label>
									</div>

								</div>
							</div>
							<div class="form-group col-md-3">
								<label for="gross-monthly-income" class="info-label">Gross Monthly Income</label>
								<input type="text" id="gross-monthly-income" class="form-control current-employer"
									 value="${meta['currency-8'] || ''}">
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-3">
								<label for="previous-employer" class="info-label">Previous Employer</label>
								<input type="text" id="previous-employer" class="form-control previous-employer-name" value="${meta['co-employment-employer-previous-employer'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="previous-position" class="info-label">Previous Position</label>
								<input id="previous-position" class="form-control previous-employer" type="text" value="${meta['co-employment-employer-previous-position'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="previous-time" class="info-label">Time at Employer</label>
								<input id="previous-time" class="form-control previous-employer" type="text" value="${meta['co-employment-employer-previous-time'] || ''}">
							</div>
							<div class="form-group col-md-3">
								<label for="other-income" class="info-label">Other Monthly Income</label>
								<input id="other-income" class="form-control previous-employer" type="text"  value="${meta['co-employment-employer-other-income'] || ''}">
							</div>

						</div>

				   
	`;



		var financeApplicantName = meta['name-1'] + ' ' + meta['name-2'];

		jQuery(".heading-vendor-name strong").text(financeApplicantName || '');


		// appliciant 
		jQuery(".user-info-container .user-details-column").html(info);

		jQuery('.applicantNameFromFinance').text(financeApplicantName || '');


		jQuery(".user-info-container #vendor-province").val(meta['select-12'] || 'Alberta');
		jQuery(".user-info-container #previousProvince").val(meta['select-4'] || 'Alberta');


		selectMatchingRadioButtonInGroup(meta['residenceTypeOption'], '.user-details-column .residence-type-option', 'residenceType');



		// console.log(formatDateToISO(meta['date-1']));   


		if (meta['document_proof_file']) {
			jQuery("#documentProofPreviewContainer img").attr("src", meta['document_proof_file']);
		} else {
			jQuery("#documentProofPreviewContainer img").attr("src",
				"<?php echo home_url(); ?>/wp-content/uploads/2024/09/image-144.png");
		}




		// jQuery(".user-info-card #secondaryPhone").val(meta['phone-2'] || '');
		// jQuery(".user-info-card #sin").val(meta['text-2'] || '');


		// Employer
		console.log('Emply: ', meta['employ-residence-type-option']);
		jQuery("#employmentInformation").html(employmentInfo);
		selectMatchingRadioButtonInGroup(meta['employ-residence-type-option'], '.employmentTypeOption',
			'employment-type');

		jQuery(".coEmploymentInformation #lastName").val(meta['text-12'] || '');
		jQuery(".coEmploymentInformation #street-address").val(meta['text-30'] || '');
		jQuery('#employmentInformation #province').val(meta['select-6'] || 'Alberta');


		// Co-Applicant  Information

		jQuery(".coEmploymentInformation").html(coAApplicantInfo);

		selectMatchingRadioButtonInGroup(meta['co-applicicant-residence-type'],
			'.coEmploymentInformation .residence-type-option',
			'residenceType');



		jQuery(".coEmploymentInformation #province").val(meta['co-applicicant-province'] || 'Alberta');

		jQuery(".coEmploymentInformation #province.co-app-previous").val(meta['co-applicicant-previous-province'] ||
			'Alberta');

		// Co-Employment Information

		selectMatchingRadioButtonInGroup(meta['co-employment-employer-residence-type'],
			'.co-employment .residence-type-option',
			'employment-type');

		jQuery(".co-employment").html(coEmploymentInformation);
		jQuery(".co-employment #province").val(meta['co-employment-employer-province'] || "Alberta");


		//Note section content
		jQuery(".clientName").text(meta['name-4']);
		jQuery(".clientEmail").attr('href', `mailto:${meta['email-2'] || ''}`).text(meta['email-2'] || '');
		jQuery(".clientPhone").attr('href', `tel:${meta['phone-6'] || ''}`).text(meta['phone-6'] || '');


		jQuery(".buyerName").text(meta['name-1'] + ' ' + meta['name-2']);
		jQuery(".buyerMarketLink").text(meta['url-1']).attr('href', meta['url-1']);
		jQuery(".buyerEmail").attr('href', `mailto:${meta['email-1'] || ''}`).text(meta['email-1']);
		jQuery(".buyerPhone").attr('href', `tel:${meta['phone-1'] || ''}`).text(meta['phone-1']);


		jQuery(".loanAmount").text(formatCalCadPrice(meta['currency-2']));





		//Vehicle details section content
		const topSection = jQuery('.custom-card.vehicle-vin-section');

		topSection.find('#vin-input').val(meta['text-13'] || '');
		topSection.find('#marketplaceLink').val(meta['url-1'] || '');
		topSection.find('#mileage-input').val(meta['topSectionMileage'] || '');
		topSection.find('#vehicle-valu').val(meta['currency-7'] || '');
		topSection.find('#purchase-price').val(meta['currency-2'] || '');
		topSection.find('#down-payment').val(meta['currency-3'] || '');
		topSection.find('#year').val(meta['topSectionYear'] || '');
		topSection.find('#make-input').val(meta['topSectionMakeInput'] || '');
		topSection.find('#model-input').val(meta['topSectionModelInput'] || '');
		topSection.find('#trim').val(meta['topSectionTrim'] || '');
		topSection.find('#color-input').val(meta['topSectionColorInput'] || '');
		topSection.find('#gas-diesel-hybrid').val(meta['topSectionGasDieselHybrid'] || '');


		const tradeInSection = jQuery('.trade-in-section.vehicle-vin-section');
		tradeInSection.find('#vin-input').val(meta['tradeInSectionVin'] || '');
		tradeInSection.find('#mileage-input').val(meta['topTradeInSectionMileage'] || '');
		tradeInSection.find('#current-price').val(meta['topTradeInSectionCurrentPrice'] || '');
		tradeInSection.find('#purchase-price').val(meta['topTradeInSectionPurchasePrice'] || '');
		tradeInSection.find('#year').val(meta['topTradeInSectionYear'] || '');
		tradeInSection.find('#make-input').val(meta['topTradeInSectionMakeInput'] || '');
		tradeInSection.find('#model-input').val(meta['topTradeInSectionModelInput'] || '');
		tradeInSection.find('#trim').val(meta['topTradeInSectionTrim'] || '');
		tradeInSection.find('#color-input').val(meta['topTradeInSectionColorInput'] || '');
		tradeInSection.find('#gas-diesel-hybrid').val(meta['topTradeInSectionGasDieselHybrid'] || '');



		var warrantySection = jQuery('.warranty-accessories-prices');
		warrantySection.find('#blank-price1').val(meta['warrantySectionPrice1'] || '');
		warrantySection.find('#blank-price2').val(meta['warrantySectionPrice2'] || '');
		warrantySection.find('#blank-price3').val(meta['warrantySectionPrice3'] || '');
		warrantySection.find('#blank-price4').val(meta['warrantySectionPrice4'] || '');



		// additional

		jQuery('.additional-seller-info #vin').val(meta['text-13'] || '');
		jQuery('.additional-seller-info #year').val(meta['select-2'] || '');
		jQuery('.additional-seller-info #make').val(meta['select-1'] || '');
		jQuery('.additional-seller-info #model').val(meta['text-14'] || '');

		jQuery('.additional-seller-info #sellerEmail').val(meta['email-2'] || '');
		jQuery('.additional-seller-info #sellerName').val(meta['name-4'] || '');
		jQuery('.additional-seller-info #sellerPhone').val(meta['phone-6'] || '');
		jQuery('.additional-seller-info #buyerEmail').val(meta['email-1'] || '');

		jQuery('.additional-seller-info #sellerType').val(meta['select-7'] || '');

		//jQuery('.additional-seller-info #vin2').val();
		// jQuery('.additional-seller-info #year2').val();
		// jQuery('.additional-seller-info #make2').val();
		// vjQuery('.additional-seller-info #model2').val();

		//jQuery('.additional-seller-info #vin3').val();
		// jQuery('.additional-seller-info #year3').val();


		jQuery('.additional-seller-info #pickupAddress').val(meta['text-36'] || '');
		jQuery('.additional-seller-info #dropOffAddress').val(meta['text-37'] || '');
		jQuery('.transport-delivery-amount input').val(meta['text-38'] || '');


		// For GAAP Insurance
		setRadioValue('.additional-seller-info .gaap-insurance', meta['radio-2'] || '');

		// For Life Insurance
		setRadioValue('.additional-seller-info .life-insurance', meta['radio-3'] || '');

		// For Vehicle Warranty
		setRadioValue('.additional-seller-info .vehicle-warranty', meta['radio-4'] || '');

		// For TurboBid Delivery
		setRadioValue('.additional-seller-info .includeTurboBidDelivery', meta['radio-5'] || '');

		// For Inspection Requested
		setRadioValue('.additional-seller-info .inspectionRequested', meta['radio-6'] || '');






		var approvalFields = jQuery('.client-deal-approval-details');

		approvalFields.find('#approvedAmount').val(formatCalCadPrice(meta['buyerApprovedAmount'] || 0));
		approvalFields.find('#lender').val(meta['buyerApprovedLender'] || '');
		approvalFields.find('#lenderType').val(meta['buyerApprovedLenderType'] || '');
		approvalFields.find('#approvalNoteTextarea').val(meta['approvalNoteTextarea'] || '');

		approvalFields.find('.term-1 #paymentAmount').val(meta['approvedMonthlyAmount'] || '');
		var totalMonthlyPay = extractNumericValue(meta['approvedMonthlyAmount'] || 0);
		var biWeeklyPay = totalMonthlyPay / 2;

		approvalFields.find('.term-1 #biWeeklyPayment').val(formatCalCadPrice(biWeeklyPay));

		approvalFields.find('.term-1 #approvalTerm').val(meta['approvalTermTerm'] || '');
		approvalFields.find('.term-1 #interestRate').val(`${meta['interestRateTerm'] || ''}%`);

		approvalFields.find('.term-2 #paymentAmount').val(meta['paymentAmountTermTwo'] || '');
		approvalFields.find('.term-2 #biWeeklyPayment').val(meta['biWeeklyPaymentTermTwo'] || '');
		approvalFields.find('.term-2 #approvalTerm').val(meta['approvalTermTermTwo'] || '');
		approvalFields.find('.term-2 #interestRate').val(meta['interestRateTermTwo'] || '');

		approvalFields.find('#warrantyCost').val(meta['buyerApprovedWarrantyCost'] || '');
		approvalFields.find('#gaapInsurance').val(meta['buyerApprovedGAPInsurance'] || '');
		approvalFields.find('#lifeInsurance').val(meta['buyerApprovedLifeInsurance'] || '');
		approvalFields.find('#turboBidTransport').val(meta['buyerApprovedTurbobidTransport'] || '');


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
				`<div class="d-flex justify-content-between mb-2 small"><strong>GAAP</strong> <span>${formatCalCadPrice(gaapInsurance || 0)}</span></div>`;
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
		jQuery('.approvalDetails #dealDeclinedProducts').html(dealDeclinedProducts);



		// Collect input values
		var fundDealFormSection = jQuery('.fund-deal-form');
		// Populate the input fields with the data from the response
		fundDealFormSection.find('#firstName').val(meta['fundFirstName'] || '');
		fundDealFormSection.find('#middleName').val(meta['fundLastName'] || '');
		fundDealFormSection.find('#lastName').val(meta['fundMiddleName'] || '');
		fundDealFormSection.find('#fundingDate').val(meta['fundingDate'] || '');
		fundDealFormSection.find('#Payment\\ Amount').val(meta['paymentAmount'] || '');
		fundDealFormSection.find('#Payment\\ Method').val(meta['paymentMethod'] || '');
		fundDealFormSection.find('#Transaction\\ Number').val(meta['transactionNumber'] || '');
		fundDealFormSection.find('#Notes').val(meta['fundNotes'] || '');

		// Collect values from the sellerInformationPayout section
		var sellerSection = jQuery('.sellerInformationPayout');

		// Seller Information Payout Section

		sellerSection.find('#nameOfRegisteredOwner').val(meta['nameOfRegisteredOwner'] || '');

		// sellerSection.find('#sellerRegisteredOwner').val(meta['sellerRegisteredOwner'] || '');
		sellerSection.find('#sellerRegisteredOwner').val(meta['isRegisteredOwner'] || '');

		// sellerSection.find('#lienInformation').val(meta['lienInformation'] || '');
		sellerSection.find('#lienInformation').val(meta['isAnyLiensVehicle'] || '');

		if (meta['confirmVehiclePurchase'] === "Yes") {
			sellerSection.find('#confirmedVehiclePriceVIN').val(formatCalCadPrice(meta['currency-2']) + '-' + meta[
				'text-13'] || '');
		}

		sellerSection.find('#institutionName').val(meta['institutionName'] || '');
		sellerSection.find('#institutionAddress').val(meta['institutionAddress'] || '');
		sellerSection.find('#institutionNumber').val(meta['institutionNumber'] || '');
		sellerSection.find('#transitNumber').val(meta['transitNumber'] || '');
		sellerSection.find('#accountName').val(meta['accountName'] || '');
		sellerSection.find('#accountNumber').val(meta['accountNumber'] || '');
		sellerSection.find('#selectedPayoutMethod').val(meta['sellerPayoutMethod'] || '');
		sellerSection.find('#payoutAmount').val(meta['payoutAmount'] || '');

		// Collect values from the DeliveryDetails section
		var deliverySection = jQuery('.DeliveryDetails');

		// // Delivery Details Section
		deliverySection.find('#transportCompany').val(meta['transportCompany'] || '');
		deliverySection.find('#phoneNumber').val(meta['phoneNumber'] || '');
		deliverySection.find('#driver').val(meta['driver'] || '');
		deliverySection.find('#trackingNumber').val(meta['trackingNumber'] || '');
		deliverySection.find('#isVehiclePicked').val(meta['isVehiclePicked'] || '');
		deliverySection.find('#SellerPickupAddress').val(meta['sellerPickupAddress'] || '');
		deliverySection.find('#sellerPickupDate').val(meta['sellerPickupDate'] || '');
		deliverySection.find('#sellerPickupTime').val(meta['sellerPickupTime'] || '');



		// Other Income
		// Set returned values into the fields, or empty if not provided
		jQuery('#otherIncomeAmount').val(meta['currency-4'] || '');
		jQuery('#otherIncomeFrequency').val(meta['select-13'] || '');
		jQuery('#otherIncomeType').val(meta['select-14'] || '');
		jQuery('#otherIncomeDescription').val(meta['text-45'] || '');

		// Housing     
		jQuery('#homeStatus').val(meta['select-10'] || '');
		jQuery('#mortageHolder').val(meta['text-43'] || '');
		jQuery('#monthlyHousingPayment').val(meta['currency-5'] || '');
		jQuery('#marketValue').val(meta['currency-7'] || '');
		jQuery('#mortagePayment').val(meta['currency-6'] || '');
		jQuery('#additionalInfo').val(meta['text-39'] || '');



	}


	function selectMatchingRadioButtonInGroup(metaValue, parentClass, radioGroupName) {
		// Check if metaValue is defined and not empty
		if (metaValue !== undefined && metaValue.trim() !== '') {
			console.log('Meta value:', metaValue, 'Parent class:', parentClass, 'Radio group name:', radioGroupName);

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
			documents.forEach(function (document) {
				// Iterate over each table row in the client document section
				jQuery('tr').each(function () {
					var row = jQuery(this);
					var documentId = row.data('document-id');
					var uploadName = row.data('upload-name');

					// Match document by ID and name
					if (document.doc_id == documentId && document.doc_name === uploadName) {
						// If document is completed, update the status cell
						if (document.document_is_complete === 'completed') {
							row.find('.doc-row-status').html(
								'<span class="turbo-success font-10 px-2 py-1 rounded-pill"><i class="fas fa-circle small"></i>Completed</span>'
							);
						} else {
							row.find('.doc-row-status').html(
								'<span class="turbo-warning font-10 px-2 py-1 rounded-pill"><i class="fas fa-circle small"></i>Uncompleted</span>'
							);
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
						'<span class="turbo-warning font-10 px-2 py-1 rounded-pill"><i class="fas fa-circle small"></i>Uncompleted</span>'
					);
				}
			});

		}
	}





	jQuery(document).on('click', '.deal-entry-link', function () {

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
			success: function (response) {

				jQuery('.finance-back-main').removeClass('d-none');

				if (response.success) {

					showDealerPage('dealOverviewPage');

					var entry = response.data;
					var meta = entry.meta;

					insertApplicantInfo(meta);
					noteSectionDealStatus(entry);

					sessionStorage.setItem('@deal-entry-id', entry.entry_id);
					sessionStorage.setItem('@deal-form-id', <?php echo $credit_form_id; ?>);
					jQuery('#dealChatId').val(entry.entry_id);
					sessionStorage.setItem('@deal-user-email', meta['email-1']);
					sessionStorage.setItem('@deal-data' + entry.entry_id, JSON.stringify(meta));

					console.log('Deal data: ', sessionStorage.getItem('@deal-data' + entry
						.entry_id));

					jQuery(".heading-deal-id").text('Deal #' + entry.entry_id);

					jQuery("#finance_pickup_id").val('pickup-' + entry.entry_id);
					jQuery("#finance_entry_vehicle_vin").val(meta['text-13']);
					jQuery("#finance_entry_vehicle_name").val(
						`${meta['select-1']}  ${meta['text-14']} ${meta['select-2']}`);



					financePickupSessionResponse(entry.finance_pickup_info);

					console.log('deal-document', entry.deal_document);
					updateRowStatus(entry.deal_document);

					getDealBasedNotes();





					// Example usage
					const dateCreated = entry
						.date_created; // Make sure this is a valid date string
					jQuery('.finance-entry-submit-date').html(formatDate(dateCreated));


					jQuery(".applicationDate").text(formatJustDate(dateCreated));



					if (meta['email-1']) {
						var financeStep = entry.entry_current_step;


						sessionStorage.setItem('finance-' + getFinanceId + '-step-' + meta[
							'email-1'],
							financeStep);


						if (financeStep === 3) {
							fetchUserVeriffStatus(meta['email-1'], function (error,
								veriffDecision) {
								if (error) {
									console.log("Error fetching buyer veriff decision:",
										error);
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


					jQuery('#loadingSpinner').hide();


				} else {
					jQuery('.finance-entry-details').html(
						'<p>Error fetching entry details.</p>');
				}
			},
			error: function () {
				jQuery('.finance-entry-details').html(
					'<p>Error fetching entry details.</p>');
			}
		});
	}



	function noteSectionDealStatus(entry) {
		let financeStepStatus = entry.finance_step_status;
		let bookedStatus = '';

		console.log(financeStepStatus);

		bookedStatus += `<div style="text-align:center">`;

		// Buttons based on finance status
		if (financeStepStatus.step >= 5) {
			bookedStatus += `<button class="turbo-success font-8 rounded-pill">
										<i class="fas fa-circle small"></i> ${financeStepStatus.status || "Approved"}
									</button>`;
		} else if (financeStepStatus.status === "Approved" && financeStepStatus.step >= 1) {
			bookedStatus += `<button class="turbo-success font-8 rounded-pill">
										<i class="fas fa-circle small"></i> ${financeStepStatus.status || "Pending"}
									</button>`;
		} else if (financeStepStatus.step < 5 && financeStepStatus.step >= 1) {
			bookedStatus += `<button class="turbo-warning font-8 rounded-pill">
										<i class="fas fa-circle small"></i> ${financeStepStatus.status || "Pending"}
									</button>`;
		} else {
			bookedStatus += `<button class="turbo-danger font-8 rounded-pill">
										<i class="fas fa-circle small"></i> ${financeStepStatus.status || "Pending"}
									</button>`;
		}


		jQuery('.noteSectionDealStatus').html(bookedStatus);

	}


	function userVeriffDecision(veriffDecision) {
		if (veriffDecision.verification.status === "approved") {
			financeStatusBasedUpdateInfo(3, 'Approved');
		}
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
				entry.seller_finance_bank_dp.bank_dp_images.forEach(function (imageUrl) {
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
		serializedData.replace(/s:17:"formatting_result";s:\d+:"([^"]+)";/g, function (_,
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
	jQuery(document).on('click', '[data-toggle="lightbox"]', function (event) {
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
			success: function (response) {
				if (response.success) {
					callback(null, response.data.veriff_decision);
				} else {
					callback(response.data, null);
				}
			},
			error: function (error) {
				callback(error, null);
			}
		});
	}









	function financeStatusBasedUpdateInfo(step, status) {
		if (status === 'Approved') {
			// Loop through the steps from 1 to the current step
			for (let i = 1; i <= step; i++) {
				jQuery('#finance-' + i + '-verified').removeClass('finance-warning').addClass('finance-accepted')
					.text(
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
				jQuery('.applicationDecision').text('Decision:Approved');
			}



		}

		if (status === "Unapproved") {
			for (let i = 1; i <= step; i++) {
				jQuery('#finance-' + i + '-unverified').removeClass('finance-warning').addClass('finance-accepted')
					.text(
						'Canceled').prop(
							'disabled', true);
				jQuery('#finance-' + i + '-verified').removeClass('finance-accepted').addClass('finance-warning')
					.text(
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




	function financeProgressVerification(dealId, step, stepName, status) {
		jQuery('#loadingSpinner').show();


		let storedData = {
			step: step,
			step_name: stepName,
			status: status
		};

		if (!dealId) {
			alert("Deal Id Not Defined");
			return
		}


		var vehicle_name = jQuery('#finance_entry_vehicle_name').val();
		var vehicle_vin = jQuery('#finance_entry_vehicle_vin').val();

		var formData = new FormData();
		formData.append("action", "add_additional_escrow_info");
		formData.append("form_id", 337873); // Replace with your form ID
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
			.done(function (res) {
				jQuery('#loadingSpinner').hide();
				// Handle the response from the AJAX call
				if (res.success) {
					//console.log(res.data);
					// Dynamically access the response data based on the type
					var statusKey = 'finance_step_status';
					if (res.data[statusKey] !== "") {

						mainDealsImportFromServer();

						jQuery('.documentManagementBody').removeClass('d-flex d-block').addClass('d-none');

						jQuery('.documentManagementBody .sendDocumentSection .goPaperworkBtn').remove();

						// alert("Deal status updated successfully");
						showGlobalAlert('success', `<h3>Deal status updated successfully</h3>`);

						var statusValue = res.data[statusKey]['status'];
						// Update the button color based on the status

						financeStatusBasedUpdateInfo(step, statusValue);


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


	jQuery(document).ready(function ($) {
		let make = '';
		let model = '';
		let year = '';

		// Click event for the search VIN button
		jQuery('.search-vin-btn').on('click', function () {
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
			vinDecodeApi(vin).done(function () {
				// Assuming the API returns 'model', 'year', and 'make' in the response


				// Update the input fields with the decoded values
				section.find("#model-input").val(model); // Update model field
				section.find("#year").val(year); // Update year field
				section.find("#make-input").val(make); // Update make field
			}).fail(function (error) {
				console.error("Error decoding VIN:", error);
			});
		});


		function vinDecodeApi(vin) {
			const apiUrl = `https://vpic.nhtsa.dot.gov/api/vehicles/decodevin/${vin}?format=json`;

			return $.getJSON(apiUrl, function (data) {
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
			}).fail(function () {
				alert('Error connecting to the API. Please try again later.');
			});
		}

	});
</script>

<script>
	// Example usage for different instances
	initializeFileUploadHandler('#documentProofDropArea', '#documentProofFileInput', '#documentProofPreviewContainer',
		'.upload-proof-btn');
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
	jQuery(document).ready(function ($) {
		$('.carTypeCard').click(function () {
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

	jQuery('#bookTrasportBtn').on('click', function () {
		jQuery('#loadingSpinner').show(); // Show the loading spinner

		var dealId = sessionStorage.getItem('@deal-entry-id');
		const meta = JSON.parse(sessionStorage.getItem('@deal-data' + dealId) || "{}");

		// Check required values
		const requiredFields = {
			vehicleName: jQuery('#finance_entry_vehicle_name').val(),
			transportDate: jQuery('#transportDateCollect').val(),
			transportPickup: jQuery('#transportPickupLocation').val(),
			transportDestination: jQuery('#transportDropLocation').val(),
			transportVIN: jQuery('#finance_entry_vehicle_vin').val(),
			transportFee: jQuery('#transportDeliveryFee').val()
		};

		for (const [field, value] of Object.entries(requiredFields)) {
			if (!value) {
				alert(`Please fill out the ${field} field.`);
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
			"name": `${meta['name-1'] || ''} ${meta['name-2'] || ''}`,
			"phone": meta['phone-1'] || '',
			"company": `${meta['name-1'] || ''} ${meta['name-2'] || ''}`,
			"email": meta['email-1'] || ''
		}]));
		formData.append('transportReceiver', JSON.stringify([{
			"name": meta['name-4'] || '',
			"phone": meta['phone-6'] || '',
			"company": meta['name-4'] || '',
			"email": meta['email-2'] || ''
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
			success: function (res) {
				console.log(res);
				// alert('Transport request submitted successfully!');
				jQuery('#loadingSpinner').hide(); // Hide spinner
				showGlobalAlert('success', `<h3>Transport request submitted successfully</h3>`);
			},
			error: function () {
				jQuery('#loadingSpinner').hide(); // Hide spinner
				// alert('Error connecting to the API. Please try again later.');
				showGlobalAlert('error', `<h3>Error connecting to the API. Please try again later.</h3>`);
			}
		});
	});
</script>


<style>
	.form-check input {
		margin-left: -1.25rem !important;
		margin-top: -5px !important;
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

	.deal-entry-link.btn-secondary {
		font-size: 10px !important;
		min-width: 70px;
		align-content: center;
	}

	.col.overflow-auto {
		align-content: center;
	}

	.col {
		padding: 0px;
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



	.turbo-warning {
		color: #B99D4B;
		border: 1px solid #B99D4B;
		background: rgba(185, 157, 75, 0.20);
		color: #BF9B3E;
		min-width: 73px;
		display: flex;
		justify-content: center;
		align-items: center;
		gap: 3px;
		max-width: 80px;
		padding: 5px 0;
	}

	.turbo-success {
		border: 1px solid #4bb96c;
		background: rgb(75 185 113 / 20%);
		color: #3ebf4b;
		min-width: 73px;
		display: flex;
		justify-content: center;
		align-items: center;
		gap: 3px;
		max-width: 80px;
		padding: 5px 0;
	}

	.turbo-danger {
		border: 1px solid #dc3545;
		background: rgb(185 75 75 / 20%);
		color: #dc3545;
		min-width: 73px;
		display: flex;
		justify-content: center;
		align-items: center;
		gap: 3px;
		max-width: 80px;
		padding: 5px 0;
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

	button.update-btn {
		border-radius: 61px;
		background-color: #fff;
		font-size: 12px;
		color: #3b634c;
		text-align: center;
		line-height: 1;
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

	.form-control {
		font-size: 12px;
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

	.manager-info {}

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
<?php get_template_part('framework/design/account/parts/document-management'); ?>