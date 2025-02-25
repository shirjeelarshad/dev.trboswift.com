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

global $CORE, $userdata, $escrows, $finances;

$user_id = get_current_user_id(); // Get the current user ID
$user_phone = get_user_meta($userdata->ID, 'phone', true);
$user_email = $userdata->user_email;


// Example usage


?>



<div class="financing-entry-details row mt-3" data-id="">
	<div class="col-md-8">
		<div class="turbobidfinancing financing-bg-green mb-2">


			<section class="turbobidfinancing-inner col-md-6">
				<div class="frame-parent">
					<div>
						<h1>Welcome to Trbo Swift</h1><br>
						<span class="text-primary">Canada's First Secure Escrow & Private Vehicle Financing
							Platform</span><br>
						<small class="mr-2 text-white">Instant lien searches powered by</small><img loading="lazy"
							alt="icon" style="width:100px; object-fit:contain"
							src="<?php echo home_url(); ?>/wp-content/themes/AT10/framework/images/carfax.svg" />
					</div>

				</div>
			</section>
			<div class="col d-flex justify-content-end align-items-end ">
				<img loading="lazy" alt="Trbo Swift financing icon" style="width:150px; object-fit:contain"
					src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/cardblue.svg" />
			</div>
		</div>

		<!-- <div class="bg-white p-3 my-3" style="border-radius:22px;">
			<div class="mb-3">
				<div class="position-relative">
					
					<div class="d-none d-md-block position-absolute" style="width:66px; right:10px; top:10px;  object-fit:contain">
						<?php echo $CORE->LAYOUT("get_logo", "light"); ?>
					</div>

					<?php if ($escrows) { ?>

					<h6>Escrow Services</h6>


					<div class="mt-5 overflow-auto">
						<table class="table small table-orders font-12">
							<thead>
								<tr>
									<th class="text-center bg-primary text-white" style="border-radius:10px 0 0 0;">
										<?php echo __("ID", "premiumpress"); ?>
									</th>
									<th class="text-center bg-primary text-white">
										<?php echo __("Title", "premiumpress"); ?>
									</th>
									<th class="text-center bg-primary text-white">
										<?php echo __("Created", "premiumpress"); ?>
									</th>
									<th class="text-center bg-primary text-white dashhideme">
										<?php echo __("Amount", "premiumpress"); ?>
									</th>
									<th class="text-center bg-primary text-white dashhideme"
										style="border-radius:0 10px 0 0;">
										<?php echo __("Status", "premiumpress"); ?>
									</th>
								</tr>
							</thead>
							<tbody class="border">
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
								<tr class="finance-row-<?php echo $entry_id; ?>">
									<td>
										<a class="text-dark entry-link" href="javascript:void(0)"
											data-entry-id="<?php echo $entry->entry_id; ?>">
											#<?php echo $entry->entry_id; ?>
										</a>
									</td>
									<td class="text-center text-dark">
										<span class="small opacity-5 font-12">
											<?php
											echo (!empty($meta_data['select-2']) ? esc_html($meta_data['select-2']) . ' ' : '') .
												(!empty($meta_data['select-1']) ? esc_html($meta_data['select-1']) . ' ' : '') .
												(!empty($meta_data['text-3']) ? esc_html($meta_data['text-3']) : '');
											?>
										</span>

									</td>
									<td class="text-center text-muted text-dark">
										<?php echo esc_html(hook_date($entry->date_created)); ?>
									</td>
									<td class="text-center text-dark">
										<?php echo isset($meta_data['currency-1']) ? esc_html(hook_price($meta_data['currency-1'])) : ''; ?>
									</td>
									<td class="text-center font-10">
										<div class="overflow-auto">
											<?php if ($seller_escrow_status["step"] && ($seller_escrow_status["step"] == 5 || $buyer_escrow_status["step"] == 6)) { ?>
											<div
												class="text-light px-3 py-2 rounded-pill d-flex justify-content-center align-items-center bg-secondary">
												<i class="fas fa-circle small mr-2 d-none d-md-block"></i> Closed
											</div>
											div
											<?php } else if ($seller_escrow_status["step"] && ($seller_escrow_status["step"] < 5 && $seller_escrow_status["step"] > 1 || $buyer_escrow_status["step"] < 6 && $buyer_escrow_status["step"] > 1)) { ?>
											<div
												class="text-light px-3 py-2 rounded-pill d-flex justify-content-center align-items-center bg-secondary opacity-5">
												<i class="fas fa-circle small mr-2 d-none d-md-block"></i> Open
											</div>
											<?php } else { ?>
											<div
												class="text-light px-3 py-2 rounded-pill d-flex justify-content-center align-items-center bg-primary">
												<i class="fas fa-circle small mr-2 d-none d-md-block"></i> Pending
											</div>
											<?php } ?>
										</div>
									</td>
								</tr>
								<?php } // End of foreach loop ?>
							</tbody>
						</table>
					</div>
					<?php } else { ?>
					<div class="d-flex align-items-center" style="gap:10px;">
						<h6>Escrow Services</h6> <small class="text-primary small">Get started, our process takes less
							than 5 minutes </small>
					</div>
					<span>We utilize Trbo Swift AI-driven damage inspection for escrow, including inspections at vehicle
						pickup.</span>

					<div class="mt-5">
						<button class="btn btn-outline-secondary rounded-pill px-3" id="financing-step-back">
							Learn more</button>
						<a href="<?php echo home_url(); ?>/escrow-back-end/" class="btn btn-secondary rounded-pill px-3"
							id="financing-step-next">Start Escrow</a>

					</div>


					<?php } ?>

				</div>



			</div>

		</div>  -->

		<!-- white block close -->

		<div class="bg-white p-3 my-3" style="border-radius:22px;">
			<div class="mb-3">
				<div class="position-relative">
					<div class="d-none d-md-block position-absolute"
						style="width:66px; right:10px; top:10px;  object-fit:contain">
						<?php echo $CORE->LAYOUT("get_logo", "light"); ?>
					</div>


					<?php
					// Check if there are any entries
					if ($finances) {
						?>

						<h6 class="btn" onclick="SwitchPage('financing');">Financing</h6>

						<div class=" mt-5 overflow-auto">
							<table class="table small table-orders font-12">
								<thead>
									<tr>
										<th class="text-center bg-primary text-white" style="border-radius:10px 0 0 0;">
											<?php echo __("ID", "premiumpress"); ?>
										</th>
										<th class="text-center bg-primary text-white">
											<?php echo __("Transaction Title", "premiumpress"); ?>
										</th>
										<th class="text-center bg-primary text-white">
											<?php echo __("Created", "premiumpress"); ?>
										</th>
										<th class="text-center bg-primary text-white dashhideme">
											<?php echo __("VIN", "premiumpress"); ?>
										</th>
										<th class="text-center bg-primary text-white dashhideme"
											style="border-radius:0 10px 0 0;">
											<?php echo __("Status", "premiumpress"); ?>
										</th>
									</tr>
								</thead>
								<tbody class="border">
									<?php
									// Loop through each finance entry
									foreach ($finances as $entry) {
										$entry_id = $entry->entry_id;



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

										//  $buyer_entry_current_step = get_post_meta($entry->entry_id, "entry_current_step", true);
								
										$buyer_finance_step_status = get_post_meta($entry->entry_id, "finance_step_status", true);

										//   $seller_entry_current_step = get_post_meta($entry_id, 'seller_escrow_entry_current_step', true);
								

										?>
										<tr class="finance-row-<?php echo $entry_id; ?>">
											<td>
												<a class="text-dark" onclick="SwitchPage('financing');" href="
											javascript:void(0)" data-entry-id="<?php echo $entry->entry_id; ?>">
													#<?php echo $entry->entry_id; ?>
												</a>
											</td>
											<td class="text-center text-dark btn font-12" onclick="SwitchPage('financing');">
												<?php
												echo isset($meta_data['select-1'])
													? esc_html($meta_data['select-1'] . ' ' . $meta_data['text-14'] . ' ' . $meta_data['select-2'])
													: '';
												?>
											</td>
											<td class=" text-center text-muted text-dark">
												<?php echo esc_html(hook_date($entry->date_created)); ?>
											</td>
											<td class="text-center text-dark ">
												<?php echo isset($meta_data['text-13']) ? esc_html($meta_data['text-13']) : ''; ?>
											</td>
											<td class="text-center font-10">
												<?php if ($buyer_finance_step_status["step"] && $buyer_finance_step_status["step"] == 6) { ?>
													<div style="min-width: 100px;"
														class="text-light px-3 py-2 turbo-warning rounded-pill d-flex justify-content-center align-items-center bg-secondary">
														<i class="fas fa-circle small mr-2 d-none d-md-block"></i>
														<?php echo $buyer_finance_step_status["status"] ?>
													</div>
												<?php } else if ($buyer_finance_step_status["step"] && ($buyer_finance_step_status["step"] < 6 && $buyer_finance_step_status["step"] > 1)) { ?>
														<div style="min-width: 100px;"
															class="text-light px-3 py-2 turbo-success rounded-pill d-flex justify-content-center align-items-center bg-secondary">
															<i class="fas fa-circle small mr-2 d-none d-md-block"></i>
														<?php echo $buyer_finance_step_status["status"] ?>
														</div>
												<?php } else { ?>
														<div style="min-width: 100px;"
															class="text-light px-3 py-2 turbo-danger rounded-pill d-flex justify-content-center align-items-center bg-primary">
															<i class="fas fa-circle small mr-2 d-none d-md-block"></i> Pending
														</div>
												<?php } ?>
											</td>
										</tr>
									<?php } // End of foreach loop ?>
								</tbody>
							</table>
						</div>
						<?php
					} else { ?>

						<div class="d-flex align-items-center" style="gap:10px;">
							<h6>Apply for financing</h6>
						</div>
						<span>We have exclusive partnerships with some of Canada’s largest lenders to get your
							best-in-market rates.</span>

						<div class="mt-5">
							<button class="btn btn-outline-secondary rounded-pill px-3" id="financing-step-back">
								Learn more</button>
							<a href="<?php echo home_url(); ?>/credit-application/"
								class="btn btn-secondary rounded-pill px-3" id="financing-step-next">Apply for financing</a>

						</div>
					<?php } ?>
				</div>


			</div>

		</div> <!-- white block close -->



		<div class="px-3 py-5 my-3  text-white" style="background-image:url('<?php echo home_url(); ?>/wp-content/uploads/2024/09/dashboard.png'); border-radius:22px; background-position:center;background-repeat: no-repeat;
background-size: cover;overflow: hidden; ">
			<div class="mb-3">
				<div class="position-relative">
					<img class="position-absolute" loading="lazy" alt="trboswift financing icon"
						style="right:-50px; top:0px; bottom:0px; width:325px; object-fit:contain"
						src="<?php echo home_url(); ?>/wp-content/uploads/2024/07/image-84-e1720214398702.png" />

					<div class="position-relative" style="z-index:1">
						<h2>Transport your vehicle anywhere in Canada</h6>

							<span>Book Canada-wide transport options, including open and<br>enclosed transport, directly
								through the escrow process.</span>
					</div>
					<div class="mt-5 ">


					</div>

				</div>

			</div>

		</div> <!-- white block close -->


	</div> <!-- col-md-8 close -->

	<div class="col-md-4">
		<div class="bg-white p-3 mb-2 mr-2"
			style="border-radius:22px;box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
			<h6>Got any questions? Feel free to contact a Trbo Swift team member for assistance.</h6>

			<div class="col-12 row" style="border-top:1px solid #EFF0F1;">
				<a class="col text-center py-2 text-primary" href="<?php echo home_url(); ?>/help/"
					style="border-right:1px solid #EFF0F1;"><i class="far fa-question-circle"></i> Need more help?</a>

				<a class="col text-center py-2 text-primary" href="<?php echo home_url(); ?>/contact"><i
						class="fas fa-phone-square-alt"></i> Contact Us</a>
			</div>
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


<style>
	.turbobidfinancing-child {
		height: 139px;
		width: 116px;
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
		background: linear-gradient(180deg, #ecf7ed, #eef4e2);

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
</style>