<?php
   /*
   Template Name: [PAGE - Escrow page]
   */


           get_header();

        ?>


<div class="main-home-body" style="background:#F8F9FA;">


	<div class="hero-banner overflow-hidden">
		<div class="container radiusx" style="background:#F4F4F4">



			<div class="d-flex flex-column flex-md-row align-items-start py-3 py-md-5">
				<div class="col-md-5 p-0">

					<style>
					@media (min-width: 576px) {
						.headerMainTextStyle {
							margin-right: -250px;
						}
					}

					@media (max-width: 576px) {
						.headerMainTextStyle {
							margin-right: 0px;
						}
					}
					</style>

					<div class="pt-2 headerMainTextStyle">
						<span class="text-primary small">Best transaction platform</span>
						<h1 class="font-weight-bold">Secure Escrow </h1>
						<span class="small">To begin selling, list your vehicle on Trbo Swift. Need help locating your<br>
							VIN? Here are some handy places <a class="text-primary" href="#">to check.</a> </span>
					</div>

					<div class="bg-white radiusx my-3 py-4 px-3 z-index">

						<div id="vehicle-form">

							<div class="material-textfield">
								<select placeholder=" " type="text" id="sellerType">
									<option value="Buyer">I’m buying</option>
									<option value="Seller">I’m selling</option>
								</select>
								<label>Are you buying or selling? </label>
							</div>
							<div class="material-textfield">
								<input placeholder="Enter VIN" type="text" id="vehicle-identification-number">
								<label>Vehicle Identification number</label>
							</div>

							<div class="material-price-field">
								<input placeholder=" " type="text" id="vehiclePrice">
								<label>Enter price</label>
							</div>

							<div id="decoded-vin-result" class="py-2 my-2 text-dark small">
							</div>

							<div class="d-flex flex-row justify-content-start mt-1" style="gap:10px">
								<button type="button" class="btn btn-secondary rounded-pill px-4"
									id="get-escrow"><small>Add vehicle</small></button>

							</div>
						</div>

					</div>


				</div>

				<div class="col-md-7 p-0 text-right">
					<img style="max-width:100%; max-height:500px; object-fit:contain; z-index:1; position: relative;"
						src="<?php echo home_url(); ?>/wp-content/uploads/2024/12/Group-1321315446.png" />

				</div>
			</div>

		</div>

	</div> <!-- Home banner 12 block close -->



	<div class="bg-secondary  position-relative trboSwiftEscrowSection">

			<img class="position-absolute carRight" src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/Group-1321317195.png" />


			<div class="container py-5">
			<div class="col-7 p-0">
				<div>
					<span class="text-white bg-primary small px-3 py-1 d-flex"
						style="max-width:150px; border-radius:8px;"> <img
							src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/link.svg " width="15px"
							class="mr-2" />
						Powered by AI</span>
				</div>
				<h2 class="text-white my-2 md-h1 ">Introducing Trbo Swift Escrow</h2>

				<span class="text-primary">Enhance your security with Scam Protection including a Stolen Vehicle Check with Trbo Swift Escrow.</span><br>
				<span class="text-white">Turbo Swift Escrow guarantees secure and reliable vehicle transactions in Canada’s market. We utilize Veriff for identity verification, Carfax for lien checks, and multiple trusted data sources to validate vehicles and ensure the legitimacy of each deal. Payments are held securely and released only after thorough checks on seller details, identity, and lien status are completed. With Turbo Swift Escrow, you can confidently buy or sell, knowing every transaction is protected and verified.</span>

				<div class="d-block d-md-none mt-2">
					<a href="<?php echo home_url(); ?>/escrow-back-end/" type="button"
						class="btn btn-light rounded-pill px-4 small" id="get-finance"><small>Apply now</small></a>

				</div>
			</div>
			<div class="col-12 col-md-6 cardGridLayout my-4 px-0" style="gap:10px">
				
					<div
						class="smallOptionCard">
						<div
							style="width:50px; height:50px; background:#fff0; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
							<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/11/Vector.svg" width="23"
								height="26" viewBox="0 0 23 26" />
						</div>
						<span style="font-size:12px; color:#fff">Escrow</span>

					</div>
				
					<div
						class="smallOptionCard">
						<div
							style="width:50px; height:50px; background:#fff0; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
							<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/11/Vector.svg" width="23"
								height="26" viewBox="0 0 23 26" />
						</div>
						<span style="font-size:12px; color:#fff">
							KYC verification</span>

					</div>
				
					<div
						class="smallOptionCard">
						<div
							style="width:50px; height:50px; background:#fff0; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
							<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/11/Vector.svg" width="23"
								height="26" viewBox="0 0 23 26" />
						</div>
						<span style="font-size:12px; color:#fff">
							AI Vehicle Inspection</span>

					</div>
				
					<div
						class="smallOptionCard">
						<div
							style="width:50px; height:50px; background:#fff0; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
							<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/11/Vector.svg" width="23"
								height="26" viewBox="0 0 23 26" />
						</div>
						<span style="font-size:12px; color:#fff">
							Payment</span>
						</span>

					</div>
				
					<div
						class="smallOptionCard">
						<div
							style="width:50px; height:50px; background:#fff0; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
							<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/11/Vector.svg" width="23"
								height="26" viewBox="0 0 23 26" />
						</div>
						<span style="font-size:12px; color:#fff">
							Lien Check</span>
						</span>

					</div>
				
					<div
						class="smallOptionCard">
						<div
							style="width:50px; height:50px; background:#fff0; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
							<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/11/Vector.svg" width="23"
								height="26" viewBox="0 0 23 26" />
						</div>
						<span style="font-size:12px; color:#fff">
							Stolen Vehicle Check</span>
						</span>

					
				</div>

			</div>

			<div class="d-none d-md-block">
				<a href="<?php echo home_url(); ?>/escrow-back-end/" type="button"
					class="btn btn-light rounded-pill px-4 small" id="get-finance"><small>Explore more</small></a>

			</div>

			</div>




	</div>


	<div class="bg-white py-5">
		<div class="container">

			<div class="col-md-12 d-flex flex-column-reverse flex-md-row align-items-center  position-relative">


				<div class="col-md-6 px-0 text-start pr-md-4">
					<img class="spinningWheel" 
						src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/Group-1321317141.png" />

				</div>


				<div class="col-md-6 px-0 py-3">

					<small class="text-primary">Enhancing the verification of key data points<br>to enable secure online vehicle transactions.</small>

					<h2 class="text-dark">The Ideal Way to Handle Private Vehicle Sales</h2>



					<span class="small text-dark">Transparent, low fees</span>


					<div class="d-flex my-2 small"><strong class="mr-2">Buyers</strong> $349 Escrow fee</div>
					<div class="d-flex my-2 small align-items-center"> <strong class="mr-2">Sellers</strong> +$99 loan
						payoff fee <a href="<?php echo home_url() ?>/finance/"
							style="margin-left:5px;font-size:8px">More info on
							selling a
							financed car</a>
					</div>

					<small>
						Fees can be shared equally between the buyer and seller, or one party can choose to cover the entire cost. We only charge our fee once the transaction is successfully completed, and there are no cancellation fees.
					</small>




					<div class="col-12 col-md d-flex justify-content-start align-items-stretch my-4">
						<div style="max-width:150px">
							<div
								style="height:100%; width:100%; background:#fff0; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
								<div
									style="width:50px; height:50px; background:#BF9B3E; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
									<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/wscan.svg" width="23"
										height="26" viewBox="0 0 23 26" />
								</div>
								<span style="font-size:12px; color:#333">Pay online</span>

							</div>
						</div>
						<div style="max-width:150px">
							<div
								style="height:100%; width:100%; background:#fff0; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
								<div
									style="width:50px; height:50px; background:#BF9B3E; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
									<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/fa_id-card-o.svg" width="23"
										height="26" viewBox="0 0 23 26" />
								</div>
								<span style="font-size:12px; color:#333">
									Scam Protection </span>

							</div>
						</div>
						<div style="max-width:150px">
							<div
								style="height:100%; width:100%; background:#fff0; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
								<div
									style="width:50px; height:50px; background:#BF9B3E; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
									<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/wpaper.svg"
										width="23" height="26" viewBox="0 0 23 26" />
								</div>
								<span style="font-size:12px; color:#333">
									Help with Paper work</span>
								</span>

							</div>
						</div>
						<div style="max-width:150px">
							<div
								style="height:100%; width:100%; background:#fff0; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
								<div
									style="width:50px; height:50px; background:#BF9B3E; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
									<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/Vector.svg"
										width="23" height="26" viewBox="0 0 23 26" />
								</div>
								<span style="font-size:12px; color:#333">
									Loan Payoff Service</span>
								</span>

							</div>
						</div>

					</div>


					<div class="d-flex my-2">Funds are securely managed and held in our trust account at <img
							class="ml-2" style=" width:100px; object-fit:contain;"
							src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/td.svg" /></div>




				</div><!--  6 block close -->



			</div> <!--  12 block close -->



		</div>
	</div>



<div class=" bg-white">
	<div class="container text-center py-5 d-flex flex-column justify-content-center align-items-center">
		<small class="text-primary">Secure transactions nationwide</small>
		<h2 class="text-dark">Enable Escrow for any vehicle, Any marketplace</h2>
		<div class="col-md-6 align-self-center text-center">
			Trbo Swift safeguards against payment fraud and simplifies private car sales. Shop confidently on all marketplaces and with any private seller.
		</div>

		<!-- <div class="align-content-center">
			<div class="buyerSellerBtn bg-secondary">
				<span class="tabBtn">I'm a Buyer</span>
				<div class="tabBtn active">I'm a Seller</div>
			</div>
		</div> -->


	</div>
	<div class="container d-flex flex-column-reverse flex-md-row py-3">

		<div class="col-12 col-md-6 text-left">
			<img style="width:100%; object-fit:contain"
				src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/freepik_br_763e2511-77de-450d-bdf4-32f0bdf863d0-1-1.png" />


			<div class="mt-3 ml-md-4 col-md-8"><small >We utilize Trbo Swift AI-driven damage inspection for escrow, including inspections at vehicle pickup and drop-off.</small></div>	
		</div>

		<div class="col-12 col-md-6">



			<div class="wrapper">
				<ul class="StepProgress">
					<div class="StepProgress-item is-done"><span class="h6 mb-1">Start Escrow</span><br><small>We handle the escrow process, ensuring that funds are securely managed for both the buyer and seller, and issue payments accordingly.</small></div>

					<div class="StepProgress-item is-done"><span class="h6 mb-1">Complete Vehicle Verification</span><br><small>When you add your vehicle to Trbo Swift, our automated system will check for any liens nationwide and perform thorough seller and buyer verification to ensure a secure transaction.</small><br><img
							src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/Group-1321315455.png"
							style="width:100%;height:100%; max-height:150px; object-fit:contain; margin:20px 0" /></div>

					<div class="StepProgress-item current"><span class="h6 mb-1">Buyer Payment to Trbo Swift</span><br><small>Trbo Swift will confirm the buyer’s payment and inform the seller via email and text once the payment is verified. Funds will be securely held until the vehicle is delivered, protecting you from fake drafts and the inconvenience of handling cash.</small></div>
					<div class="StepProgress-item"><span class="h6 mb-1">Funds Deposited Securely into the Seller's Account</span><br><small>Payments are issued via direct wire transfer powered by PayPal or can be provided by cheque. If there is a loan on the vehicle, Trbo Swift will handle the payoff for you.</small></div>

				</ul>
			</div>
		</div>



	</div> 


	<div class="container py-3">	
		<div class="enSuringSecure d-flex align-items-center text-white">
		<div class="iconBlock">
			<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/db.svg"
                 />
		</div>
		<div class="textBlock ">
			<h2>Ensuring Secure and Reliable Fund Custody</h2>
			<span>Funds are held and managed through</span>
		</div>
		<div class="logoBlock">
			<img class="badgeImage" src="<?php echo home_url(); ?>/wp-content/uploads/2024/07/Group-1321315026.png"  />
			<img class="canadaTrust" src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/image-196.png"  />
        </div>
		
		</div>
	</div>
</div>



</div>






<div class="container py-5" >

	<div class="d-flex justify-content-center flex-column align-items-center pt-5 pb-3 mt-3">
		<span class="text-primary">How KYC Onboarding works?</span>
		<h3 class="text-center">Identity Verification for Buyers & Sellers</h3>

		<span class="col-md-6 text-center">Trbo Swift uses KYC verification to confirm that both buyers and sellers are legitimate parties in the transaction. The process is quick, can be completed on your smartphone, and takes just seconds.</span>

	</div>
	<div class="  col-md-12 p-md-0 d-flex flex-column-reverse flex-md-row my-5 py-5 align-items-center pb-3">
		<div class="supportedVehicleSection position-relative col-md-6 pl-md-2 pr-md-0 text-center">
			<img class="ai-id-card" src="<?php echo home_url(); ?>/wp-content/uploads/2024/07/Group-1321315155.png" />

		</div>
		<div class="powerfulDocumentsList ">
			<div
				class="bg-secondary text-white d-flex justify-content-start align-items-center align-items-md-center mb-2">
				<span class="icon-number">1</span>
				<div>
					<h6>Take a photo of your identity document</h6>
					<span class="small">Trbo Swift guides you through the entire process with real-time feedback and
						automatically identifies the document type. </span>
				</div>
			</div>

			<div
				class="bg-secondary text-white d-flex justify-content-start align-items-center align-items-md-center mb-2">
				<span class="icon-number">2</span>
				<div>
					<h6>Take S Selfie!</h6>
					<span class="small">Take a simple selfie with clear lighting.</span>
				</div>
			</div>

			<div
				class="bg-secondary text-white d-flex justify-content-start align-items-center align-items-md-center mb-2">
				<span class="icon-number">3</span>
				<div>
					<h6>Get a decision</h6>
					<span class="small">The data is securely analyzed and our AI-powered identity verification
						technology provides a decision in a matter of seconds.</span>
				</div>
			</div>

			<div
				class="bg-secondary text-white d-flex justify-content-start align-items-center align-items-md-center mb-2">
				<span class="icon-number">4</span>
				<div>
					<h6>Your identity verification is approved</h6>
					<span class="small">Trbo Swift KYC enhances security measures to prevent fraud and maintain a safe
						marketplace environment.</span>
				</div>
			</div>

			


		</div>



	</div>
</div> <!-- col-12 close -->

<div class="overflow-hidden">
	<div class="container col-md-12 d-flex flex-column flex-md-row align-items-center py-5">
		<div class="col-md-6 px-0 py-5">
			<h2>Seller Payment for Private Sale Vehicles with Trbo Swift Escrow</h2>
			<span>Once the vehicle financing is approved, sellers must complete a KYC verification, just like the buyer. After verification, the seller will be prompted to select their preferred payment method. Trbo Swift Escrow will then process the payment directly to the seller from our Trust Account.</span>


			<br> <a href='<?php echo home_url(); ?>/what-is-turbobid/' class="btn btn-secondary rounded-pill mt-3">Learn
				more</a>

		</div>

		<div class="col-md-6 px-0 py-5 py-md-0 text-right">
			<img style="object-fit:contain;object-fit: contain; min-height: 300px;"
				src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/freepik_br_63db8398-31e6-4978-a359-bf7e59198e5b-1.png" />

		</div>

	</div>
</div>




		<div style="background:#F4F4F4">
		<div class="container py-5">

			<div class="d-flex justify-content-center flex-column align-items-center ">
				<small class="text-primary">Our process for two different users</small>
				<h2 class="text-dark text-center">Buy a Vehicle Anywhere in Canada, No Matter the Distance</h2>


			</div>

			<div class="d-flex flex-column flex-md-row justify-content-start align-items-stretch py-4 px-0">
				<div class="col-12 col-md-6 pb-3  pb-md-0">
					<div
						style="height:300px; width:100%; background:#3B634C; text-align: start; border-radius:11px; display:flex; flex-direction:column; justify-content:space-around; align-items:flex-start; padding:30px;">
						<div class="text-white">
							<h5>When Selling</h5>
							<small>Maximize your sale by connecting with buyers across Canada using Trbo Swift Escrow. We
								ensure secure payments, verify buyer details, and perform checks through Carfax, so you
								can
								sell with confidence and get the best value for your vehicle.</small>

						</div>
						<a href="<?php echo home_url();?>/escrow?type=Seller" class="btn btn-white rounded-pill px-3" style="font-size:12px; background:#fff">I’m
							Selling</a>

					</div>
				</div>
				<div class="col-12 col-md-6 mb-3 mb-md-0">
					<div
						style="height:300px; width:100%; background:#BC9F4C; text-align: start; border-radius:11px; display:flex; flex-direction:column; justify-content:space-around; align-items:flex-start; padding:30px;">
						<div class="text-white">
							<h5>When Buying</h5>
							<small>Protect yourself in Canada’s vehicle market with Trbo Swift Escrow. We verify payments,
								seller details, and conduct identity and lien checks through Carfax, releasing payment
								only
								when all conditions are met. Buy or sell with confidence, knowing your transaction is
								safe
								and hassle-free.</small>

						</div>
						<a href="<?php echo home_url();?>/escrow?type=Buyer" class="btn btn-white rounded-pill px-3 mt-3" style="font-size:12px; background:#fff">I’m
							Buying</a>

					</div>
				</div>


			</div>

		</div>
	</div>












<?php 
/*
<div class="container col-md-12 d-flex flex-column flex-md-row align-items-center py-3">
		<div class="col-12 col-md-6 px-0">
			<small class="text-primary">Our advanced car damage inspection technology</small>
			<h2>Automate Inspections with AI</h2>
			<small>Eliminate the need for a physical inspection—get a detailed report and buy with confidence, anywhere
				in Canada, knowing your transaction is secure and hassle-free. Our advanced car damage inspection
				technology identifies 19 different types of damage across 81 key components, including metal, plastic,
				fiber, glass, and rubber. We also provide thorough assessments of the undercarriage, as well as internal
				and interior damage, ensuring a complete evaluation of your vehicle's condition.</small>


			<div><a href='<?php echo home_url(); ?>/what-is-turbobid/'
					class="d-none d-md-inline-block btn btn-secondary rounded-pill mt-3">Learn
					more</a>

			</div>

		</div>

		<div class="col-md-6 px-0 py-5 py-md-0">
			<video id="aiVideo " class="aiVideo" style="width:100%!important;" autoplay loop playsinline default muted
				preload="auto">
				<source src="<?php echo home_url(); ?>/wp-content/uploads/2024/06/WhatsApp-Video-2024-06-03-at-2.24.10-AM.mp4"
					type="video/mp4">
			</video>

			<script>
			jQuery('#aiVideo').trigger('play');
			</script>
			<a href='<?php echo home_url(); ?>/what-is-turbobid/'
				class="d-inline-block d-md-none btn btn-secondary rounded-pill mt-3">Learn
				more</a>
		</div>



	</div>

	*/
?>

	




	<div class="container py-5">

		<div class="d-flex justify-content-center flex-column align-items-center mt-3">


			<div class="col-12 col-md-6 text-center">
				<small class="text-primary">Frequently Asked Questions</small>
				<h2 class="text-dark">More Questions?</h2>
				<small class="text-dark">We are happy to answer them Click the button below to send the team a message.</small>

					<br><br>
				<a href="<?php echo home_url(); ?>/contact" class="btn btn-secondary rounded-pill px-4" >Contact with us</a>
			</div>


		</div>


		<div class="facContainer">
		<?php echo do_shortcode('[elementor-template id="325466"]'); ?>
		</div>


	</div>


</div>


<div class="mapContentContainer bg-secondary p-2">

		<div class="container position-relative">

			<div class="col-md-12 d-flex flex-column flex-md-row align-items-center">


				<div class="textContent col-md-6 text-white py-5 pr-md-5">

					<h2 class="text-white">Transport your vehicle anywhere in Canada</h2>

					<p class="text-white">Book Canada-wide transport options, including open and enclosed transport, directly through your TurboBid Dashboard.</p>


					<button onclick="window.location.href = '<?php echo home_url(); ?>/what-is-turbobid/' "
						class="btn btn-light rounded-pill my-5 px-5">More Info</button>

				</div>

				<div class="mapEscrowContainer position-relative col-md-6 ml-0 ml-md-4 text-right">

					<img style="width:100%; object-fit:contain"
						src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/Group-1321317116.png" />


				</div>

			</div>





		</div><!--  Block close -->

	</div>



<script>
jQuery(document).ready(function($) {
	let make = '';
	let model = '';
	let year = '';


	$('#get-escrow').on('click', function() {
		let vehiclePrice = jQuery('#vehiclePrice').val();
		let sellerType = jQuery('#sellerType').val();

		const vin = $('#vehicle-identification-number').val();

		if (!vin) {
			alert('Please enter VIN number!');
			return;
		}
		if (!vehiclePrice) {
			alert('Please enter vehicle price!');
			return;
		}
		if (!sellerType) {
			alert('Please select seller type!');
			return;
		}

		vinDecodeApi(vin).done(function() {
			const redirectUrl =
				`<?php echo home_url(); ?>/escrow-back-end/?vin=${encodeURIComponent(vin)}&myear=${encodeURIComponent(year)}&make=${encodeURIComponent(make)}&model=${encodeURIComponent(model)}&ruletype=${sellerType}&price=${vehiclePrice}`;

			window.location.href = redirectUrl;
		});
	});

	$('#get-finance').on('click', function() {
		const vin = $('#vehicle-identification-number').val();

		if (!vin) {
			alert('Please enter VIN number.');
			return;
		}

		vinDecodeApi(vin).done(function() {
			const redirectUrl =
				`<?php echo home_url(); ?>/credit-application/?vin=${encodeURIComponent(vin)}&myear=${encodeURIComponent(year)}&make=${encodeURIComponent(make)}&model=${encodeURIComponent(model)}`;

			window.location.href = redirectUrl;
		});
	});

	$('#vehicle-identification-number').on('change', function() {
		const vin = $(this).val();

		vinDecodeApi(vin).done(function() {
			const vinResult = make + ' ' + model + ' ' + year;
			$('#decoded-vin-result').html(vinResult);

			// Adjust font size if the content is more than 33 characters
			if (vinResult.length > 33) {
				$('#decoded-vin-result').css('font-size', '12px');
			} else {
				$('#decoded-vin-result').css('font-size', ''); // Reset to default
			}

			// Clear the content after 3 seconds
			setTimeout(function() {
				$('#decoded-vin-result').html('');
			}, 60000);
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
</script>

<style>
.yellow-side-bg {
	position: absolute;
	left: -26px;
	top: -80px;
}

.ai-id-card {
	height: 761px;
	object-fit: contain;
	border-radius: 20px;
}

.step-wrap {
	display: grid;
	text-align: center;
	width: 50px;
	z-index: 1;
	justify-content: center;
	justify-items: center;
}

.step-wrap.active .circle {
	border-color: #BC9F4C;
}


.circle {
	border: 4px solid #f8f9fa;
	height: 35px;
	width: 35px;
}

.circle {
	background-color: #fff;
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	transition: 400ms ease;
}

.step-wrap.active .step-title {
	background-color: #124326;
	box-shadow: none;
	color: #fff;
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
	font-size: 18px;
}

.step-wrap span {
	color: #68696954;
	font-size: 12px;
}

.fa-check-circle {
	font-size: 30px;
	background: white;
	border-radius: 100%;
}

.message-pop {
	height: 150px;
	object-fit: contain;
	position: absolute;
	left: 85%;

}

.any-vehicle.escrow-process {
	background-position-y: -790px;
	background-position-x: -1720px;
	background-size: 5300px 2200px;

}

.inovation-bg {
	width: 100%;
	object-fit: cover;
	position: absolute;
	left: 0;
	right: 0;
	top: 0;
	z-index: 0;
	bottom: 0;
	height: 100%;
}

.transport-section {
	background-image: url('<?php echo get_template_directory_uri(); ?>/framework/images/banner-bg.svg');

}




@media screen and (min-width:768px) {

	.transport-section {
		background-repeat: no-repeat;
		background-size: 3500px 1248px;
		background-position-x: -1188px;
		background-position-y: -10px;

		padding: 50px 50px 560px 50px;
	}

	.transport-car {
		object-fit: cover;
		top: 230px;
		right: 0px;
		z-index: 10;
	}


	.escrow-writing-img {
		position: absolute;
		height: 260px;
		object-fit: contain;
		left: 260px;
		top: 100px;
		border-radius: 20px;
	}


	.dashboard-img {
		margin-left: 132px;
		margin-bottom: -170px;

	}

	

}

.transport-tab,
.innovation-tab {
	color: var(--color-gray-10, #FFF);
	text-align: center;
	font-family: Inter;
	font-size: 18px;
	font-style: normal;
	font-weight: 600;
	line-height: 20px;
	background: transparent;
	border: none;
	padding: 5px 10px;

}

.innovation-tab.active {
	color: #000;
	text-align: center;
	font-family: Inter;
	font-size: 18px;
	font-style: normal;
	font-weight: 600;
	line-height: 20px;

}

.transport-tab.active {
	color: #BC9F4C;
	text-align: center;
	font-family: Inter;
	font-size: 18px;
	font-style: normal;
	font-weight: 600;
	line-height: 20px;

}


.innovation-section .nav {
	border-top: 1px solid #fff;
	border-bottom: 1px solid #fff;
	padding: 10px 0;
	margin: 0 20vw;
	gap: 100px;
}

.transport-tabs .nav {
	border-top: 1px solid #fff;
	border-bottom: 1px solid #fff;
	padding: 10px 0;
	margin: 0 20vw;
	gap: 50px;
}


.main-home-body h1,
.main-home-body h2,
.main-home-body h3,
.main-home-body h4,
.main-home-body h5,
.main-home-body h6,
	{
	font-family: Plus Jakarta Sans;
}

.main-home-body p,
.main-home-body span {
	font-family: Inter;
}

.radiusx-20 {
	border-radius: 20px;
}

.hero-banner {
	position: relative;
	/* Ensure the pseudo-elements are positioned relative to this element */
}

.hero-banner::before {
	content: "";
	background-image: url(<?php echo home_url(); ?>/wp-content/uploads/2024/11/Vector.png);

}

.hero-banner::after {
	content: "";
	background-image: url('<?php echo home_url(); ?>/wp-content/uploads/2024/11/Vector2.png');
	
}


.any-vehicle {
	background-image: url('<?php echo get_template_directory_uri(); ?>/framework/images/any-vehicle.svg');
	background-repeat: no-repeat;
	background-position-y: -10px;
	background-size: 2435px 1200px;
	z-index: 1;
	padding: 100px 50px;
}

.innovation-section {
	padding: 100px 50px;
}



.transport-tabs .tab-content {
	padding: 200px 50px 0px 50px;
}

.transport-tabs .tab-content {
	padding: 200px 50px 0px 50px;
}


.supportedVehicleSection::before {
	content: '';
	width: 150%;
	height: 115%;
	position: absolute;
	top: -37px;
	left: -581px;
	background-color: #BF9B3E;

}

.supportedVehicleSection img {
	z-index: 2;
	position: relative;
}

@media screen and (max-width:767.99px) {

	.supportedVehicleSection {
		margin-top: 60px;
	}


	.ai-id-card {
		width: 100%;
		height: 500px;
		object-fit: cover;
		border-radius: 15px;
	}

	.yellow-side-bg {
		top: -260px;
		left: -140px;
	}



	.any-vehicle,
	.hero-banner {
		background-position-y: 5px;
	}

	.any-vehicle,
	.transport-tabs .tab-content,
	.innovation-section,
	.hero-banner {
		padding: 10px 10px;
		background-position-y: 50px;
	}

	.transport-section {
		padding: 100px 10px 400px 10px;
		background-position-y: 0px;
	}

	.transport-car {
		object-fit: contain;
		right: 0px;
		bottom: 0px;
		width: 120%;
	}

	.purchasing h6 {
		font-size: 12px !important;
	}

	.purchasing img {
		max-height: 40px !important;
	}

	.transport-tabs .nav,
	.innovation-section .nav {
		padding: 8px 0;
		margin: 0px 0px !important;
		font-size: 12px;
		gap: 30px;
	}

	.dashboard-img {
		margin-left: 50px;
		margin-bottom: -150px;

	}




	.any-vehicle.escrow-process {
		background-position-y: 151px !important;
		background-position-x: -30px !important;
		background-size: cover;

	}


	.message-pop {
		height: 110px;
		object-fit: contain;
		position: absolute;
		left: 68%;
		top: 20%;

	}

	.escrow-writing-img {
		position: absolute;
		height: 150px;
		object-fit: contain;
		right: 10px;
		top: 50px;
		border-radius: 10px;
	}

}

@media only screen and (min-width:768px) and (max-width:1000px) {

	.any-vehicle,
	.innovation-section,
	.hero-banner {
		padding: 10px 20px;
	}

	.purchasing h6 {
		font-size: 14px;
	}

	.innovation-section .nav {
		padding: 8px 0;
		margin: 0px 0px !important;
		font-size: 12px;
	}

}


.get-button {
	border-radius: 25px;
	margin-bottom: -50px;
	background: white;
	box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;

}

.get-button-block-bottom-border {
	border-bottom: 4px solid #bc9f4c;
}

.unfair-advantage {
	padding-top: 250px;
	margin-bottom: 150px;
	z-index: 0;
	position: relative;
}


.comparison-table {
	width: 100%;
	margin: 20px 0;
	border-collapse: collapse;
	z-index: 1;
}

.comparison-table th,
.comparison-table td {

	text-align: center;
	vertical-align: middle;
	z-index: 2;
}

.comparison-table th {
	padding-left: 10px;
	padding-right: 10px;
	padding-top: 0px;
	padding-bottom: 0px;
	max-width: 150px;
	;
	width: 18%;
}

.comparison-table th div {
	background-color: white;
	width: 100%;
	display: block;
	padding: 25px;
	height: 80px;
	border-top-left-radius: 15px;
	border-top-right-radius: 15px;
	z-index: 3;
}

.comparison-table .table-bottom td span {
	border-bottom-left-radius: 15px;
	border-bottom-right-radius: 15px;
	z-index: 4;
}

.comparison-table td {
	padding-left: 10px;
	padding-right: 10px;
	padding-top: 0px;
	padding-bottom: 0px;
	max-width: 18%;
	width: 18%;
}

.comparison-table td span {
	background-color: white;
	width: 100%;
	display: block;
	padding: 25px;
	height: 80px;
}

.canadas-first-consumer {
	font-size: 50px;
}

/* Mobile version */

@media (max-width:500px) {
	.escrowUseDashboardImage {
		width: 450px !important;
		height: 470px !important;
	}


	.canadas-first-consumer {
		font-size: 25px !important;
	}

	.comparison-table td span {
		background-color: white;
		width: 100%;
		display: block;
		padding: 5px;
		height: 50px;
		font-size: 10px;
	}

	.comparison-table td span i {
		font-size: 15px;
	}



	.get-button {
		margin-bottom: -200px;
		background: transparent;
		box-shadow: none;

	}

	.get-button .get-button-block-bottom-border {
		border-radius: 25px;
		background: white;
		padding: 50px 10px !important;
		box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
		margin-bottom: 20px;
	}

	.unfair-advantage {
		padding-top: 420px;
	}

	.unfair-advantage h1,
	.our-vehicles h1,
	.looking-sell h1,
	.home-bottom h1,
	.partners h1 {
		font-size: 18px !important;
		margin-bottom: 30px
	}


	.looking-sell img {

		margin-top: 50px !important;

	}

	.comparison-table th div {

		display: block;
		padding: 5px !important;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.comparison-table td span {
		background-color: white;
		width: 100%;
		display: block;
		padding: 5px;
		height: 60px;
	}

	.comparison-table .label-column {
		max-width: 30% !important;
		width: 30%;
	}


	.home-background-bottom {

		width: 100% !important;

	}

	.home-background-left {

		display: none;
	}

	.home-background-car1,
	.home-background-car2 {
		display: none;
	}

}

/* Mobile version close */

.comparison-table th img {
	max-height: 40px;
	max-width: 150px;
	width: 100%;
	object-fit: contain;
}

.comparison-table th .non-turbo {
	mix-blend-mode: luminosity;
}

.comparison-table td.checkmark {
	color: #3B634C;
}

.comparison-table td.crossmark {
	color: #B90101;
}

.comparison-table .label-column {
	max-width: 28% !important;
	width: 28%;
	text-align: left;
	font-weight: bold;
}

.comparison-table .header-column {}

.comparison-table .header-column img {
	display: block;
	margin: 0 auto;
}

.row-header {
	font-size: 14px;
}

.comparison-table td span i {
	font-size: 30px;
}

@media (max-width:450px) {

	.comparison-table {

		overflow-x: scroll;
	}



	.comparison-table .label-column {
		max-width: 120px !important;
		width: 120px !important;
	}

	.comparison-table th {
		padding-left: 5px;
		padding-right: 5px;
		padding-top: 0px;
		padding-bottom: 0px;
		max-width: 80px;
	}

	.comparison-table th div {
		background-color: white;
		width: 100%;
		display: block;
		padding: 5px;
		height: 30px;
		border-top-left-radius: 10px;
		border-top-right-radius: 10px;
	}

	.comparison-table th img {
		max-height: 30px;
		max-width: 50px;
		object-fit: contain;
	}


	.comparison-table td span {
		background-color: white;
		width: 100%;
		display: block;
		padding: 10px;
		height: 50px;
	}

	.comparison-table td {
		padding-left: 5px;
		padding-right: 5px;

		/* max-width: 10%; */
		width: 100px;
	}

	.comparison-table td span i {
		font-size: 15px;
	}

	.row-header {
		font-size: 12px;
	}


}


.owl-nav .owl-next {
	position: absolute;
	left: 10px;
	top: 160px;
	z-index: 0;
	transform: rotate(180deg);
	background: white !important;
	width: 40px;
	height: 40px;
	display: flex !important;
	justify-content: center;
	align-items: center;
	border-radius: 50px !important;
	padding: 0px !important;
	margin: 0px !important;


}

.owl-nav .owl-prev {
	position: absolute;
	right: 10px;
	top: 160px;
	z-index: 0;
	transform: rotate(180deg);
	background: white !important;
	width: 40px;
	height: 40px;
	display: flex !important;
	justify-content: center;
	align-items: center;
	border-radius: 50px !important;
	padding: 0px !important;
	margin: 0px !important;

}

.owl-nav .owl-prev:focus,
.owl-nav .owl-next:focus {
	background-color: yellow;
	border: 0px solid #fff;
}

.owl-nav .owl-prev span,
.owl-nav .owl-next span {
	font-size: 20px !important;
	color: black;

}

.owl-nav .owl-prev span:hover,
.owl-nav .owl-next span:hover color:black;

}

.owl-carousel .owl-stage-outer .owl-stage {
	z-index: 11;
}


.new-search {
	border-radius: 10px !important;
	border: 0px solid #fff;
	font-family: var(--e-global-typography-primary-font-family), Inter;
}



.new-search:not(.img-user):not(.no-resize) figure a img {
	border-top-left-radius: 10px;
	border-top-right-radius: 10px;
}

.new-search .card-body {
	border-bottom-left-radius: 10px;
	border-bottom-right-radius: 10px;
}



.partners-listings .owl-stage-outer .owl-stage .owl-item {
	text-align: center;
}



.aiVideo {
	border-radius: 25px;
	/* Inner border radius */
}

#aiVideoContainer {
	padding: 10px;
	border-radius: 25px;
	/* Outer border radius */
	border: 1px solid #fff;
}


.bottomSellWithUs {
	transition: all .3s ease-in-out;
	border-bottom: 1px solid #ededed;
	background-color: #fff;
	padding: 0;
	position: fixed;
	left: 0;
	bottom: 0;
	width: 100%;
	z-index: 500;

}

.home-background-left {
	position: absolute;
	top: 0px;
	right: -569px;
	width: 1554.3px;
	height: 2391.6px;
	object-fit: contain;
	z-index: 0;

}

.home-background-bottom {
	position: absolute;
	top: 526px;
	left: -250px;
	width: 2157px;
	z-index: 0;

}

.z-index {
	position: relative;
	z-index: 1;
}

.home-background-car1 {
	position: absolute;
	top: 900.9px;
	right: 114px;
	width: 51.7px;
	height: 60.4px;
	object-fit: contain;
	z-index: 2;
}

.home-background-car2 {
	position: absolute;
	top: 970.9px;
	right: 83px;
	width: 51.7px;
	height: 60.4px;
	object-fit: contain;
	z-index: 2;
}




.hero-buttons {
	align-self: stretch;
	justify-content: flex-start;
	padding: 0 0 0 8px;
	text-align: left;
	color: #272727;
}

.hero-browse,
.hero-buttons {
	flex-direction: row;
	box-sizing: border-box;
}

.hero-browse,
.hero-buttons,
.hero-slogan1 {
	display: flex;
	align-items: flex-start;
	max-width: 100%;
}

.hero-browse {
	flex: 1;
	box-shadow: 0 170px 48px transparent, 0 109px 43px rgba(138, 138, 138, 0.01), 0 61px 37px rgba(138, 138, 138, 0.05), 0 27px 27px rgba(138, 138, 138, 0.09), 0 7px 15px rgba(138, 138, 138, 0.1);
	border-radius: 32px;
	background-color: #fff;
	justify-content: space-between;
	padding: 34px 86px 0;
	gap: 100px;
	z-index: 4;
}

.hero-browse-child {
	height: 269px;
	width: 1531px;
	position: relative;
	box-shadow: 0 170px 48px transparent, 0 109px 43px rgba(138, 138, 138, 0.01), 0 61px 37px rgba(138, 138, 138, 0.05), 0 27px 27px rgba(138, 138, 138, 0.09), 0 7px 15px rgba(138, 138, 138, 0.1);
	border-radius: 32px;
	background-color: #fff;
	display: none;
	max-width: 100%;
}

.hero-slogan {
	width: 40%;
	flex-direction: column;
	align-items: flex-start;
	justify-content: flex-start;
	gap: 31px;
}

.heading-61,
.hero-slogan {
	display: flex;
	max-width: 100%;
}

.hero-headings {
	width: 523px;
	display: flex;
	flex-direction: column;
	align-items: flex-start;
	justify-content: flex-start;
	gap: 15px;
	max-width: 100%;
}

.heading-6 {
	margin: 0;
	width: 298px;
	position: relative;
	font-size: 30px;
	line-height: 30px;
	font-weight: 600;
	font-family: inherit;
	display: flex;
	align-items: center;
	z-index: 5;

}

.browse-the-largest {
	align-self: stretch;
	position: relative;
	font-size: var(--font-size-lg);
	line-height: 27px;
	font-family: var(--font-inter);
	color: var(--color-dimgray-100);
	z-index: 5;
}

.frame-child {
	height: 68px;
	width: 213px;
	position: relative;
	border-radius: var(--br-80xl);
	background-color: var(--color-darkslategray-100);
	display: none;
}

.frame-item {
	height: 68px;
	width: 213px;
	position: relative;
	border-radius: var(--br-80xl);
	background-color: var(--color-darkslategray-100);
	display: none;
}

.rectangle-parent {
	cursor: pointer;
	border: 0;
	padding: var(--padding-mini) var(--padding-3xs) var(--padding-base) var(--padding-12xl);
	background-color: var(--color-darkslategray-100);
	display: flex;
	flex-direction: row;
	align-items: flex-end;
	justify-content: flex-start;
	gap: var(--gap-11xl);
}

.get-started-wrapper {
	display: flex;
	flex-direction: column;
	align-items: flex-start;
	justify-content: flex-end;
	padding: 0 0 var(--padding-7xs);
}

.get-started {
	position: relative;
	font-size: var(--font-size-lg);
	line-height: 24px;
	font-family: var(--font-inter);
	color: var(--color-white);
	text-align: left;
	display: inline-block;
	min-width: 105px;
	white-space: nowrap;
	z-index: 1;
}

.button {
	height: 37px;
	width: 37px;
	position: relative;
	border-radius: var(--br-lg-5);
	background-color: var(--color-white);
	z-index: 1;
}

vector-icon {
	position: absolute;
	top: 11.5px;
	left: 11.5px;
	width: 14px;
	height: 14px;
	z-index: 2;
}

.hero-divider {
	align-self: stretch;
	height: 6px;
	position: relative;
	background-color: var(--color-darkkhaki-100);
}

.hero-divider,
.rectangle-parent {
	border-radius: var(--br-80xl);
	z-index: 5;
}


.vector-icon {
	position: absolute;
	top: 4px;
	left: 4px;
	width: 30px;
	height: 30px;
	z-index: 2;
}

.hero-slogan1 {
	width: 40%;
	flex-direction: column;
	justify-content: flex-start;
	gap: var(--gap-12xl);
}

.heading-6-sell-or-trade-your-parent {
	width: 523px;
	display: flex;
	flex-direction: column;
	align-items: flex-start;
	justify-content: flex-start;
	gap: var(--gap-mini);
	max-width: 100%;
}

.heading-61 {
	margin: 0;
	width: 500px;
	position: relative;
	font-size: 30px;
	line-height: 30px;
	font-weight: 600;
	font-family: inherit;
	align-items: center;
	z-index: 5;
}

.heading-61,
.hero-slogan {
	display: flex;
	max-width: 100%;
}

.skip-the-dealership {
	align-self: stretch;
	position: relative;
	font-size: var(--font-size-lg);
	line-height: 27px;
	font-family: var(--font-inter);
	color: var(--color-dimgray-100);
	z-index: 5;
}

.rectangle-group {
	cursor: pointer;
	border: 0;
	padding: var(--padding-mini) var(--padding-3xs) var(--padding-base) var(--padding-12xl);
	background-color: var(--color-darkslategray-100);
	display: flex;
	flex-direction: row;
	align-items: flex-end;
	justify-content: flex-start;
	gap: var(--gap-11xl);
}

.hero-slogan-child,
.rectangle-group {
	border-radius: var(--br-80xl);
	z-index: 5;
}

.get-started-container {
	display: flex;
	flex-direction: column;
	align-items: flex-start;
	justify-content: flex-end;
	padding: 0 0 var(--padding-7xs);
}

.rectangle-group {
	cursor: pointer;
	border: 0;
	padding: var(--padding-mini) var(--padding-3xs) var(--padding-base) var(--padding-12xl);
	background-color: var(--color-darkslategray-100);
	display: flex;
	flex-direction: row;
	align-items: flex-end;
	justify-content: flex-start;
	gap: var(--gap-11xl);
}

.get-started1 {
	position: relative;
	font-size: var(--font-size-lg);
	line-height: 24px;
	font-family: var(--font-inter);
	color: var(--color-white);
	text-align: left;
	display: inline-block;
	min-width: 105px;
	white-space: nowrap;
	z-index: 1;
	cursor: pointer;
}


.button1 {
	height: 37px;
	width: 37px;
	position: relative;
	border-radius: var(--br-lg-5);
	background-color: var(--color-white);
	z-index: 1;
}

.vector-icon1 {
	position: absolute;
	top: 4px;
	left: 4px;
	width: 30px;
	height: 30px;
	z-index: 2;
}


.hero-slogan-child {
	align-self: stretch;
	height: 6px;
	position: relative;
	background-color: var(--color-darkkhaki-100);
}

.hero-slogan-child,
.rectangle-group {
	border-radius: var(--br-80xl);
	z-index: 5;
}



/* Get button for mobile */


.rectangle-parent32 {
	box-shadow: 0 170px 48px transparent, 0 109px 43px rgba(138, 138, 138, 0.01), 0 61px 37px rgba(138, 138, 138, 0.05), 0 27px 27px rgba(138, 138, 138, 0.09), 0 7px 15px rgba(138, 138, 138, 0.1);
	border-radius: var(--br-base);
	background-color: var(--color-white);
	align-items: flex-start;
	padding: var(--padding-12xl) var(--padding-4xs) 0;
	gap: var(--gap-2xs-3);
	flex-shrink: 0;
	debug_commit: 448091;
	z-index: 2;
	margin-top: -53px;
	font-size: var(--font-size-3xl);
	color: var(--color-gray-300);
}

.frame-parent16,
.rectangle-parent32 {
	align-self: stretch;
	display: flex;
	flex-direction: column;
	justify-content: flex-start;
	box-sizing: border-box;
	max-width: 100%;
}

.frame-wrapper7 {
	align-self: stretch;
	flex-direction: row;
	padding: 0 var(--padding-3xs) 0 var(--padding-7xs);
}

.frame-wrapper7,
.heading-6-shop-cars-parent,
.shop-hundreds-of-vehicles-to-f-parent {
	display: flex;
	align-items: flex-start;
	justify-content: flex-start;
}


.heading-6-shop-cars-parent {
	flex: 1;
	flex-direction: column;
	gap: var(--gap-3xs);
}

.frame-wrapper7,
.heading-6-shop-cars-parent,
.shop-hundreds-of-vehicles-to-f-parent {
	display: flex;
	align-items: flex-start;
	justify-content: flex-start;
}

.heading-69 {
	margin: 0;
	width: 298px;
	position: relative;
	font-size: inherit;
	line-height: 30px;
	font-weight: 600;
	font-family: inherit;
	display: flex;
	align-items: center;
	z-index: 3;
}

.frame-wrapper7,
.heading-6-shop-cars-parent,
.shop-hundreds-of-vehicles-to-f-parent {
	display: flex;
	align-items: flex-start;
	justify-content: flex-start;
}

.shop-hundreds-of-vehicles-to-f-parent {
	align-self: stretch;
	flex-direction: column;
	gap: var(--gap-3xl);
	font-size: var(--font-size-xs);
	color: var(--color-dimgray-100);
	font-family: var(--font-inter);
}

.shop-hundreds-of {
	align-self: stretch;
	position: relative;
	line-height: 20px;
	z-index: 3;
}

.rectangle-parent33 {
	cursor: pointer;
	border: 0;
	padding: var(--padding-8xs) var(--padding-10xs) var(--padding-8xs) var(--padding-2xs);
	background-color: var(--color-darkslategray-100);
	border-radius: var(--br-80xl);
	display: flex;
	flex-direction: row;
	align-items: flex-end;
	justify-content: flex-start;
	z-index: 3;
}

.get-started-frame {
	display: flex;
	flex-direction: column;
	align-items: flex-start;
	justify-content: flex-end;
	padding: 0 0 var(--padding-5xs-9);
}


.frame-child49 {
	height: 30px;
	width: 30px;
	position: relative;
	z-index: 1;
}

.frame-child50 {
	align-self: stretch;
	height: 6px;
	position: relative;
	border-radius: var(--br-80xl);
	background-color: var(--color-darkkhaki-100);
	z-index: 3;
}



.frame-wrapper8 {
	flex-direction: row;
	box-sizing: border-box;
	font-size: var(--font-size-3xl);
	color: var(--color-gray-300);
}

.frame-parent15,
.frame-wrapper8 {
	align-self: stretch;
}

.frame-parent15,
.frame-wrapper8,
.rectangle-parent34 {
	display: flex;
	align-items: flex-start;
	justify-content: flex-start;
	max-width: 100%;
}

.rectangle-parent34 {
	flex: 1;
	box-shadow: 0 170px 48px transparent, 0 109px 43px rgba(138, 138, 138, 0.01), 0 61px 37px rgba(138, 138, 138, 0.05), 0 27px 27px rgba(138, 138, 138, 0.09), 0 7px 15px rgba(138, 138, 138, 0.1);
	border-radius: var(--br-base);
	background-color: var(--color-white);
	flex-direction: column;
	padding: var(--padding-12xl) var(--padding-4xs) 0;
	box-sizing: border-box;
	gap: var(--gap-2xs-3);
}

.frame-parent15,
.frame-wrapper8,
.rectangle-parent34 {
	display: flex;
	align-items: flex-start;
	justify-content: flex-start;
	max-width: 100%;
}


.frame-wrapper9 {
	align-self: stretch;
	flex-direction: row;
	padding: 0 var(--padding-3xs) 0 var(--padding-7xs);
}

.frame-wrapper9,
.heading-6-shop-cars-group,
.tell-us-about-your-ride-styl-parent {
	display: flex;
	align-items: flex-start;
	justify-content: flex-start;
}


.heading-6-shop-cars-group {
	flex: 1;
	flex-direction: column;
	gap: var(--gap-3xs);
}

.frame-wrapper9,
.heading-6-shop-cars-group,
.tell-us-about-your-ride-styl-parent {
	display: flex;
	align-items: flex-start;
	justify-content: flex-start;
}

.heading-610 {
	margin: 0;
	width: 298px;
	position: relative;
	font-size: inherit;
	line-height: 30px;
	font-weight: 600;
	font-family: inherit;
	display: flex;
	align-items: center;
	z-index: 1;
}

.frame-wrapper9,
.heading-6-shop-cars-group,
.tell-us-about-your-ride-styl-parent {
	display: flex;
	align-items: flex-start;
	justify-content: flex-start;
}

.tell-us-about-your-ride-styl-parent {
	align-self: stretch;
	flex-direction: column;
	gap: var(--gap-3xl);
	font-size: var(--font-size-xs);
	color: var(--color-dimgray-100);
	font-family: var(--font-inter);
}

.tell-us-about {
	align-self: stretch;
	position: relative;
	line-height: 20px;
	z-index: 1;
}

.rectangle-parent35 {
	cursor: pointer;
	border: 0;
	padding: var(--padding-8xs) var(--padding-10xs) var(--padding-8xs) var(--padding-2xs);
	background-color: var(--color-darkslategray-100);
	border-radius: var(--br-80xl);
	display: flex;
	flex-direction: row;
	align-items: flex-end;
	justify-content: flex-start;
	z-index: 1;
}

.frame-child52 {
	height: 40px;
	width: 126px;
	position: relative;
	border-radius: var(--br-80xl);
	background-color: var(--color-darkslategray-100);
	display: none;
}

.get-started-wrapper1 {
	display: flex;
	flex-direction: column;
	align-items: flex-start;
	justify-content: flex-end;
	padding: 0 0 var(--padding-5xs-9);
}

.get-started7 {
	width: 89.3px;
	height: 14.1px;
	position: relative;
	font-size: var(--font-size-xs);
	line-height: 24px;
	font-family: var(--font-inter);
	color: var(--color-white);
	text-align: left;
	display: flex;
	align-items: center;
	flex-shrink: 0;
	white-space: nowrap;
	z-index: 1;
}

.frame-child53 {
	height: 30px;
	width: 30px;
	position: relative;
	z-index: 1;
}


.frame-child54 {
	align-self: stretch;
	height: 6px;
	position: relative;
	border-radius: var(--br-80xl);
	background-color: var(--color-darkkhaki-100);
	z-index: 1;
}

.get-started6 {
	width: 89.3px;
	height: 14.1px;
	position: relative;
	font-size: var(--font-size-xs);
	line-height: 24px;
	font-family: var(--font-inter);
	color: var(--color-white);
	text-align: left;
	display: flex;
	align-items: center;
	flex-shrink: 0;
	white-space: nowrap;
	z-index: 1;
}


/* Main Header Text */



@media(max-width:1000px) {


	.an-all-in-one-auto1 {

		line-height: 20px;
		font-family: var(--font-inter);

		height: 40px;
		z-index: 2;
		height: 56px;
		z-index: 5;
		font-size: 12px;

	}


}



#wrapper {
	overflow: hidden;
}


.footer a {
	font-size: 12px;
	color: #6D6D6D;
	font-family: Inter;
}
</style>
<style>
.wrapper {
	width: 80%;
	font-family: 'Helvetica';
	font-size: 14px;
}

.StepProgress {
  position: relative;
  padding-left: 45px;
  list-style: none;
}

.StepProgress small{
	color:#222222;
}

.StepProgress::before {
  display: inline-block;
  content: '';
  position: absolute;
  top: 5px;
  left: 12px;
  width: 10px;
  height: 18%;
  border-left: 1px solid #BF9B3E; /* Default connecting line */
}

.StepProgress-item {
  position: relative;
  counter-increment: list;
  padding-bottom: 20px;
}

/* SVG Icons for steps */
.StepProgress-item::before {
  content: '';
  position: absolute;
  top: 0;
  left: -45px;
    width: 25px;
    height: 25px; /* Set height for SVG */
  background-size: contain; /* Ensure SVG scales properly */
  background-repeat: no-repeat;
}

.StepProgress-item.number:first-child::before {
  background-image: url('<?php echo home_url(); ?>/wp-content/uploads/2025/01/Group-1321317073.svg');
}

.StepProgress-item.number:nth-child(2)::before {
  background-image: url('<?php echo home_url(); ?>/wp-content/uploads/2025/01/Group-1321317074.svg');
}

.StepProgress-item.number:nth-child(3)::before {
  background-image: url('<?php echo home_url(); ?>/wp-content/uploads/2025/01/Group-1321317075.svg');
}

.StepProgress-item.no-number::before {
  background-image: url('<?php echo home_url(); ?>/wp-content/uploads/2025/01/Group-1321316254.svg');
}

.StepProgress-item::before {
  background-image: url('<?php echo home_url(); ?>/wp-content/uploads/2025/01/Group-1321316254.svg');
}

/* Connecting lines */
.StepProgress-item:not(:last-child)::after {
  content: '';
  position: absolute;
  left: 7px;
  bottom: 0;
  width: 1px; /* Border width */
  height: 100%;
  background: linear-gradient(to bottom, #000 50%, dashed 50%);
  background-size: 100% 200%; /* Adjust background for dashed */
  background-repeat: no-repeat;
}



/* Current step styling */
.StepProgress-item.current::before {
  border-radius: 50%;

}



.StepProgress-item.is-done::after {
  content: '';
}

.StepProgress-item.current::after{
 content: '';
  position: absolute;
  bottom: 0px;
    left: -33px;
    width: 10px;
    height: 257%;
    border-left: 1px dashed #BF9B3E;
}

.StepProgress strong {
	display: block;
}





.material-textfield,
.material-price-field {
	position: relative;
	margin-bottom: 20px;
}

.material-textfield label {
	position: absolute;
	font-size: 1rem;
	left: 0;
	top: 50%;
	transform: translateY(-50%);
	background-color: white;
	color: gray;
	padding: 0 0.3rem;
	margin: 0 0.5rem;
	transition: .1s ease-out;
	transform-origin: left top;
	pointer-events: none;
}

.material-price-field label {
	position: absolute;
	font-size: 1rem;
	left: 20px;
	top: 50%;
	transform: translateY(-50%);
	background-color: white;
	color: gray;
	padding: 0 0.3rem;
	margin: 0 0.5rem;
	transition: .1s ease-out;
	transform-origin: left top;
	pointer-events: none;
}

.material-price-field::after {
	content: '$';
	position: absolute;
	top: 50%;
	left: 10px;
	transform: translateY(-50%);
	font-size: 1.2rem;
	color: #CBCBCB;
	pointer-events: none;
	padding-right: 5px;
	border-right: 1px solid #CBCBCB;
}

.material-price-field input {
	font-size: 1rem;
	outline: none;
	border: 1px solid #CFCFCF;
	border-radius: 5px;
	padding: 1rem 1.8rem;
	color: gray;
	transition: 0.1s ease-out;
	width: 100%;
}

.material-textfield select,
.material-textfield input {
	font-size: 1rem;
	outline: none;
	border: 1px solid #CFCFCF;
	border-radius: 5px;
	padding: 1rem 0.7rem;
	color: gray;
	transition: 0.1s ease-out;
	width: 100%;
}

.material-textfield input:focus,
.material-textfield select:focus,
.material-price-field input:focus {
	border-color: #3B634C;
}

.material-textfield input:focus+label,
.material-textfield select:focus+label,
.material-price-field input:focus+label {
	background-color: #F6F6F6;
	color: #222222;
	top: 0;
	left: 0px;
	padding: 5px 20px;
	border-radius: 20px;
	transform: translateY(-50%) scale(.9);
}

.material-textfield input+label,
.material-textfield select+label,
.material-price-field input+label {
	background-color: #F6F6F6;
	color: #222222;
	top: 0;
	left: 0px;
	padding: 5px 20px;
	border-radius: 20px;
	transform: translateY(-50%) scale(.9);
}

.material-price-field input:not(:placeholder-shown)+label {
	top: 0;
	left: 0px;
	transform: translateY(-50%) scale(.9);
}

.material-textfield input:not(:placeholder-shown)+label,
.material-textfield select:not(:placeholder-shown)+label {
	top: 0;
	transform: translateY(-50%) scale(.9);
}






/* New designs */


/* desktop */
@media (min-width: 1000px) {


	.icon-number {
		        height: 70px;
        min-width: 70px;
        background: white;
        border: 2px solid #BF9B3E;
        border-radius: 100%;
        color: #3B634C;
        font-size: 35px;
        font-weight: 700;
        display: flex
;
        align-items: center;
        justify-content: center;
        margin-right: 25px;
        font-weight: 400;
	}

	.align-content-center{
		display: flex;
    justify-content: center;
    align-items: center;
	}

	.buyerSellerBtn{
		display: flex;
        justify-content: center;
        align-items: center;
        padding: 8px 8px;
        border-radius: 14px;
        margin-top: 30px;
        margin-bottom: 30px;
        background-color: #3B634C;
        color: white;
        font-size: 1.1rem;
        font-weight: 600;
        transition: background-color 0.2s ease-out;
        width: 400px;
        height: 70px;
		font-weight: 400;
	}

	.buyerSellerBtn .tabBtn {
        width: 50%;
        text-align: center;
    }

	.buyerSellerBtn .tabBtn.active {
        color: #ffffff;
        width: 50%;
        height: 100%;
        align-content: center;
        border-radius: 10px;
        background: #BC9F4C;
        border: 0.1px solid #eee;
    }




.powerfulDocumentsList{
	position: absolute;
	    top: 20%;
        transform: translate(19%, -10%);
        width: 81%;
	 
}

.powerfulDocumentsList div.bg-secondary{
           border-radius: 100px;
        padding: 0px 70px 0px 31rem;
        min-height: 110px;
}

 .hero-banner::before {

    position: absolute;
    top: -64px;
    right: -151px;
    width: 685px;
    height: 100%;
    object-fit: contain;
    background-repeat: no-repeat;
    z-index: 0;
    padding: 0px;
}

.hero-banner::after {
	
	position: absolute;
    bottom: -361px;
    left: -110px;
    width: 824px;
    height: 500px;
    object-fit: contain;
    background-repeat: no-repeat;
    z-index: 0;
    padding: 0px;
    transform: rotate(352deg);
}

						.headerMainTextStyle {
							margin-right: -520px;
						}
						h1{
	font-size: 76px !important;
    font-weight: 600 !important;
}




	.carRight{
		right: 0px;
        top: 50%;
        bottom: 0;
        transform: translate(-0%, -50%);
		max-height: 400px;
		object-fit: contain;
}

.trboSwiftEscrowSection{
	overflow: hidden;
}

.trboSwiftEscrowSection::before{
		content: "";
        position: absolute;
        top: -36px;
        right: 260px;
        width: 140px;
        height: 112%;
        background-color: #C5A142;
        z-index: 0;
        transform: translate(79%, 0%) rotate(10deg);
    }

.cardGridLayout{
	display: grid;
    grid-template-columns: repeat(3, 0fr);
    grid-auto-rows: auto;
    grid-gap: 1rem;
}

.smallOptionCard{
	height:130px; width:130px; background:#487259; text-align: center; border-radius:5.25px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;
}

	.headerMainTextStyle {
							margin-right: -520px;
	}
	h1{
	font-size: 76px !important;
    font-weight: 600 !important;
}

.escrowUseDashboardImage{
        width: 100%;
		max-height: 500px;
        object-fit: contain;
}


.infoCardDesign{
    background: #fff;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    text-align: center;
    border-radius: 1px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 30px 10px;

}



.includedTrboSwiftCards {
  display: grid;
  grid-template-columns: repeat(5, 1fr); /* 5 cards per row */
  grid-auto-rows: auto;
  gap: 1rem;
  position: relative;
  width: 100%;
}


.enSuringSecure{
	margin-top: 20px;
        min-height: 146px;
        background: #3B634C;
        border-radius: 10px;
        padding: 0px 22px;
		position: relative;
}

.enSuringSecure .iconBlock{
	max-width: 100px;
	margin-right: 30px;
}

.enSuringSecure .badgeImage{
	position: absolute;
    top: 0;
    right: 20px;
}

.enSuringSecure .canadaTrust{
	    position: absolute;
           top: 50%;
        right: 15%;
        transform: translate(10%, -50%);
        min-width: 170px;
}

.mapContentContainer .textContent{
  z-index: 1;
}

.mapEscrowContainer{
	    padding: 35px 0;
}
.mapEscrowContainer img{
	    width: 100%;
    object-fit: contain;
    z-index: 1;
    position: relative;
}

.mapEscrowContainer::before{
	            content: '';
        position: absolute;
        top: 0px;
        right: 260px;
        width: 521%;
        height: 112%;
        background-color: #3B6C50;
        z-index: 0;
        transform: translate(80%, 0%);
        border-radius: 100% 0 0 100%;
    
}

					}

					/* Tablet */

@media (min-width: 576px) and (max-width: 1000px) {

		.powerfulDocumentsList{
	transform: translate(-17%, 0%);
        width: 166%;
        margin-left: -30px;
	 
}

.mapContentContainer .textContent{
  z-index: 1;
}

.mapEscrowContainer{
	    padding: 35px 0;
}
.mapEscrowContainer img{
	    width: 100%;
    object-fit: contain;
    z-index: 1;
    position: relative;
}

.mapEscrowContainer::before{
	            content: '';
        position: absolute;
        top: 0px;
        right: 260px;
        width: 521%;
        height: 112%;
        background-color: #3B6C50;
        z-index: 0;
        transform: translate(80%, 0%);
        border-radius: 100% 0 0 100%;
    
}

	.buyerSellerBtn{
		display: flex;
        justify-content: center;
        align-items: center;
        padding: 8px 8px;
        border-radius: 14px;
        margin-top: 30px;
        margin-bottom: 30px;
        background-color: #3B634C;
        color: white;
        font-size: 1.1rem;
        font-weight: 600;
        transition: background-color 0.2s ease-out;
        width: 400px;
        height: 70px;
		font-weight: 400;
	}

	.buyerSellerBtn .tabBtn {
        width: 50%;
        text-align: center;
    }

	.buyerSellerBtn .tabBtn.active {
        color: #ffffff;
        width: 50%;
        height: 100%;
        align-content: center;
        border-radius: 10px;
        background: #BC9F4C;
        border: 0.1px solid #eee;
    }

.powerfulDocumentsList div.bg-secondary{
               border-radius: 100px;
        padding: 10px 10px 10px 16rem;
        min-height: 100px;
}


.list-group-item{
	display: flex
;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}



	.enSuringSecure{
	margin-top: 20px;
        min-height: 146px;
        background: #3B634C;
        border-radius: 10px;
        padding: 0px 22px;
		position: relative;
}

.enSuringSecure .iconBlock{
	max-width: 100px;
	margin-right: 30px;
}

.enSuringSecure .badgeImage{
	position: absolute;
    top: 0;
    right: 20px;
}

.enSuringSecure .canadaTrust{
	
    position: absolute;
        top: 73%;
        right: 40%;
        transform: translate(110%, -50%);
        min-width: 170px;
}


	.hero-banner::before {

    position: absolute;
    top: -64px;
    right: -151px;
    width: 685px;
    height: 100%;
    object-fit: contain;
    background-repeat: no-repeat;
    z-index: 0;
    padding: 0px;
}

.hero-banner::after {
	
	position: absolute;
    bottom: -361px;
    left: -110px;
    width: 824px;
    height: 500px;
    object-fit: contain;
    background-repeat: no-repeat;
    z-index: 0;
    padding: 0px;
    transform: rotate(352deg);
}

	.headerMainTextStyle {
							margin-right: -220px;
	}
	h1{
	font-size: 40px !important;
    font-weight: 600 !important;
}


.includedTrboSwiftCards{
		display: grid ;
		grid-template-columns: repeat(3, 1fr);
    grid-auto-rows: auto;
    grid-gap: 1rem;
	}

.infoCardDesign{
    background: #fff;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    text-align: center;
    border-radius: 1px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 10px 15px;

}

.infoCardDesign .cardIcon{
    width: 70px;
        height: 70px;
        background: #3B634C;
        border-radius: 100%;
        margin-bottom: 8px;
        align-content: center;
}



		.an-all-in-one-auto1 {

		line-height: 20px;
		font-family: var(--font-inter);

		height: 40px;
		z-index: 2;
		height: 56px;
		z-index: 5;
		font-size: 12px;

	}

	.carRight {
		position: absolute;
		right: -15px;
		top: 0px;
		max-width: 322px;
	}	
	
	.cardGridLayout{
	display: grid;
    grid-template-columns: repeat(3, 0fr);
    grid-auto-rows: auto;
    grid-gap: 1rem;
}

.smallOptionCard{
	height:164.55px; width:184.68px; background:#487259; text-align: center; border-radius:5.25px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;
}



.escrowUseDashboardImage{
        max-height: 300px;
        object-fit: contain;
}


	.icon-number {
		       height: 35px;
        min-width: 35px;
        background: white;
        border: 2px solid #BF9B3E;
		border-radius: 100%;
		color: #3B634C;
		font-size: 25px;
		font-weight: 700;
		display: flex;
		align-items: center;
		justify-content: center;
		margin-right: 10px;
		font-weight: 400;
	}

	

					}


					/* Mobile */
@media (max-width: 576px) {


		.powerfulDocumentsList{
	transform: translate(-17%, 0%);
        width: 166%;
        margin-left: -30px;
	 
}

.mapContentContainer .textContent{
  z-index: 1;
}

.mapEscrowContainer{
	    padding: 35px 0;
}
.mapEscrowContainer img{
	    width: 100%;
    object-fit: contain;
    z-index: 1;
    position: relative;
}

.mapEscrowContainer::before{
	            content: '';
        position: absolute;
        top: 0px;
        right: 260px;
        width: 521%;
        height: 112%;
        background-color: #3B6C50;
        z-index: 0;
        transform: translate(80%, 0%);
        border-radius: 100% 0 0 100%;
    
}



	.buyerSellerBtn{
		display: flex;
        justify-content: center;
        align-items: center;
        padding: 4px 4px;
        border-radius: 12px;
        margin-top: 30px;
        margin-bottom: 30px;
        background-color: #3B634C;
        color: white;
        font-size: 1.1rem;
        font-weight: 600;
        transition: background-color 0.2s ease-out;
        width: 100%;
        height: 50px;
        font-weight: 400;
		min-width: 270px;
	}

	.buyerSellerBtn .tabBtn {
        width: 50%;
        text-align: center;
    }

	.buyerSellerBtn .tabBtn.active {
        color: #ffffff;
        width: 50%;
        height: 100%;
        align-content: center;
        border-radius: 10px;
        background: #BC9F4C;
        border: 0.1px solid #eee;
    }

.powerfulDocumentsList div.bg-secondary{
               border-radius: 100px;
        padding: 10px 10px 10px 16rem;
        min-height: 100px;
}


.list-group-item{
	display: flex
;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}


	.enSuringSecure{
	margin-top: 20px;
        height: 261px;
        background: #3B634C;
        border-radius: 10px;
        padding: 0px 22px;
		position: relative;
		flex-direction: column;
}



.enSuringSecure .iconBlock{
	max-width: 100px;
	margin-right: 30px;
}
.enSuringSecure .iconBlock img{
	    position: absolute;
    top: 20px;
    left: 20px;
}
.enSuringSecure .textBlock{
	position: absolute;
    bottom: 46px;
}

.enSuringSecure .badgeImage{
	position: absolute;
    top: 0;
    right: 20px;
	width: 75px;
}

.enSuringSecure .canadaTrust{
	position: absolute;
            right: 10%;
        transform: translate(-50%, 0);
    max-width: 134px;
	width:131px;
}



	.headerMainTextStyle {
	margin-right: 0px;
	}


	.includedTrboSwiftCards{
		display: grid ;grid-template-columns: repeat(1, 1fr);
    grid-auto-rows: auto;
    grid-gap: 1rem;
	}


  /* .includedTrboSwiftCards > .scrollRight {
    animation: scrollDown 15s linear infinite;
  }


  .includedTrboSwiftCards > .scrollLeft {
    animation: scrollUp 15s linear infinite;
  } */

.infoCardDesign{
	    height: 240px; */
   /* width: 360px; */
    background: #fff;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    text-align: center;
    border-radius: 1px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 10px 15px;

}

.infoCardDesign .cardIcon{
    width: 60px;
        height: 60px;
        background: #3B634C;
        border-radius: 100%;
        margin-bottom: 8px;
        align-content: center;
}

.infoCardDesign .cardIcon img{
    width: 20px;
        height: 20px;
}

	.carRight {
		right: 0px;
        top: 16%;
        bottom: 0;
                transform: translate(0%, -50%);
        max-height: 162px;
        object-fit: contain;
	}	

.cardGridLayout{
	display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-auto-rows: auto;
    grid-gap: 1rem;
}

.smallOptionCard{
	height:150px; width:100%; background:#487259; text-align: center; border-radius:5.25px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;
}


.escrowUseDashboardImage{
                max-width: 400px;
        max-height: 300px;
        object-fit: contain;
}

.trboSwiftEscrowSection{
	overflow: hidden;
}

.trboSwiftEscrowSection::before{
		        content: "";
        position: absolute;
        top: -36px;
        right: 223px;
        width: 66px;
        height: 70%;
        background-color: #C5A142;
        z-index: 0;
        transform: translate(141%, 0%) rotate(10deg);
    
    }


.hero-banner::before {

    position: absolute;
    top: 306px;
    right: -628px;
    width: 866px;
    height: 100%;
    object-fit: contain;
    background-repeat: no-repeat;
    z-index: 0;
    padding: 0px;
    transform: rotate(-4deg);
}

.hero-banner::after {
    position: absolute;
    bottom: -9px;
    left: -378px;
    width: 824px;
    height: 500px;
    object-fit: contain;
    background-repeat: no-repeat;
    z-index: 0;
    padding: 0px;
    transform: rotate(352deg);
}


	.icon-number {
		       height: 35px;
        min-width: 35px;
        background: white;
        border: 2px solid #BF9B3E;
		border-radius: 100%;
		color: #3B634C;
		font-size: 25px;
		font-weight: 700;
		display: flex;
		align-items: center;
		justify-content: center;
		margin-right: 10px;
		font-weight: 400;
	}



					}

/* Mobile desin end*/

.facContainer {
	 display: flex;
    justify-content: center;
    align-items: center;

}
.facContainer div{
	 max-width: 605px;
    font-size: 14px;
    font-weight: bold;
}

.elementor-accordion-item{
border-bottom: 1px solid black !important;
}



.spinningWheel {
            width: 100%;
            height: 500px;
            object-fit: contain;
            /* background: url('wheel.png') no-repeat center center; */
            background-size: contain;
            animation: spin 10s linear infinite;
        }
.spinningWheel:hover {
  animation-play-state: paused; /* Pause animation on hover */
}

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }




</style>
<?php

        get_footer();


		?>