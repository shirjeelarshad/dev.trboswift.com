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

//die(print_r(_ppt_elementor_defaultvalue('title_show')));


global $CORE;

$GLOBALS['flag-home'] = 1;

$pageLinkingID = _ppt_pagelinking("homepage");

if (substr($pageLinkingID, 0, 9) == "elementor" && !isset($_GET['design'])) {


    // CHECK ELMENTOR CANVUS		
    if (get_post_meta(substr($pageLinkingID, 10, 100), "_wp_page_template", true) != "elementor_header_footer") {
        define('NOHEADERFOOTER', 1);
    }

    get_header();

    echo do_shortcode("[premiumpress_elementor_template id='" . substr($pageLinkingID, 10, 100) . "']");

    get_footer();

} else {


    if (_ppt(array('design', 'slot1_style')) == "elementor" && defined('ELEMENTOR_VERSION') && isset($_SESSION['design_preview']) && strlen($_SESSION['design_preview']) > 1) { // CHILD THEME PREVIEWS

        _ppt_template('home', 'elementor');

    } elseif (!_ppt_checkfile("home.php")) {


        get_header();

        ?>


<div class="main-home-body" style="background:#F8F9FA;">


	<div class="hero-banner">
		<div class="container radiusx p-2 p-md-5" style="background:#F4F4F4">



			<div class="d-flex flex-column flex-md-row align-items-start py-3 py-md-5">
				<div class="col-md-4 p-0">

				

					<div class="pt-2 headerMainTextStyle">
						<span class="text-primary small">Shop Canada Wide- Any Vehicle, Any Marketplace</span>
						<h1 class="font-weight-bold">Your Car Deal, Simplified</h1>
						<span>Canada's First Secure Platform for Escrow and Private Vehicle<br>Financing – Ensuring Safe, Reliable Transactions for Buyers and Sellers.</span>
					</div>

					<div class="bg-white radiusx my-3 mt-md-5 p-2 m-0 z-index">

						<h5>Get Started Below!</h5>
						<span class="small">Experience seamless, secure transactions with Trbo Swift's automated process - the leading platform for effortless vehicle deals.</span>

						<div id="vehicle-form" class="mt-md-3">

							<div class="input-group mb-3">

								<div class="d-flex justify-content-center align-items-center  text-white px-5 input-group-prepend"
									style="background: #BF9B3E">VIN</div>
								<input type="text" class="form-control border" placeholder="VIN number here"
									name="vehicle-identification-number" id="vehicle-identification-number" value=""
									autocomplete="vehicle-identification-number">
							</div>

							<div id="decoded-vin-result" class="py-2 my-2 text-dark small">
							</div>



							<!-- <div class="form-group position-relative">
            <label>Model Year</label>
            <input type="text" class="form-control rounded-pill" placeholder="Enter car model year" name="modelyear" id="modelyear" value="" autocomplete="modelyear">
        </div> -->

							<div class="d-flex flex-row justify-content-start mt-1" style="gap:10px">
								<!-- <button type="button" class="btn btn-secondary rounded-pill px-4"
									id="get-escrow"><small>Start Escrow</small></button> -->

								<button type="button" class="btn btn-secondary rounded-pill px-4"
									id="get-finance"><small>Start Deal</small></button>

							</div>
						</div>
						<div class="d-flex justify-content-start align-items-start small my-3"><span>Instant lien
								searches
								powered by</span> <img
								src="<?php echo get_template_directory_uri(); ?>/framework/images/carfax.svg"
								style="object-fit:contain; margin-left:5px;" /></div>
					</div>


				</div>

				<div class="col-md-8 p-0 text-center text-md-right">
					<img style="max-height:590px; object-fit:contain; z-index:1; position: relative;"
						src="<?php echo home_url(); ?>/wp-content/uploads/2024/11/Group-1321316660.png" />

				</div>
			</div>

		</div>

	</div> <!-- Home banner 12 block close -->


	<div class="container d-flex flex-column-reverse flex-md-row py-5">

		<div class="col-12 col-md-6 ">
			<img style="width:100%; object-fit:contain"
				src="<?php echo home_url(); ?>/wp-content/uploads/2024/11/Group-1321316345.png" />

		</div>

		<div class="col-12 col-md-6 align-content-center">

			<span class="small" style="color: #F5B100;">Flexible Dream car drive</span>
			<h2>Trbo Swift Financing</h2>
			<small class="text-dark">Stay secure with trusted escrow, flexible financing, and reliable warranties. Add
				options like GAP insurance, vehicle warranties, Trbo Swift transport, and more. Transparency is key to
				ensuring you never overpay. </small><br>

			<ul class="list-group border-0 bg-light">
				<li class="list-group-item border-0 small bg-light px-0"><i style="font-size:14px; margin-right:10px;"
						class="fas fa-check-circle text-primary"></i> Financing
				</li>
				<li class="list-group-item border-0 small bg-light px-0"><i style="font-size:14px; margin-right:10px;"
						class="fas fa-check-circle text-primary"></i> Warranty</li>
			
				<li class="list-group-item border-0 small bg-light px-0"><i style="font-size:14px; margin-right:10px;"
						class="fas fa-check-circle text-primary"></i> Gap insurance</li>

			</ul>

			<a href="<?php echo home_url(); ?>/finance/" type="button" class="btn btn-secondary rounded-pill px-4 small"
				id="get-finance"><small>Explore more</small></a>







		</div>



	</div> <!-- Home banner 12 block close -->



	<div class="container d-flex flex-column flex-md-row py-5">

		<div class="col-12 col-md-6  align-content-center">


			<h2>Shop Any Vehicle,Any Marketplacee</h2>
			<span class="text-dark">Trbo Swift is Canada's first private vehicle financing platform, offering financing
				for any vehicle from any marketplace. </span><br>

			<ul class="list-group border-0 bg-light">
				<li class="list-group-item border-0 small bg-light px-0"><i style="font-size:14px; margin-right:10px;"
						class="fas fa-check-circle text-primary"></i> Borrow up to the full purchase price
				</li>
				<li class="list-group-item border-0 small bg-light px-0"><i style="font-size:14px; margin-right:10px;"
						class="fas fa-check-circle text-primary"></i> Finance Add Ons</li>
				<li class="list-group-item border-0 small bg-light px-0"><i style="font-size:14px; margin-right:10px;"
						class="fas fa-check-circle text-primary"></i> Flexible repayment schedule
				</li>
				<li class="list-group-item border-0 small bg-light px-0"><i style="font-size:14px; margin-right:10px;"
						class="fas fa-check-circle text-primary"></i> Interest rate options</li>
				<li class="list-group-item border-0 small bg-light px-0"><i style="font-size:14px; margin-right:10px;"
						class="fas fa-check-circle text-primary"></i> Competitive interest rates
				</li>
			</ul>

			<a href="<?php echo home_url(); ?>/escrow-back-end/" type="button"
				class="btn btn-secondary rounded-pill px-4 small" id="get-finance"><small>Apply Now</small></a>



			<img src="<?php echo get_template_directory_uri(); ?>/framework/images/brands.svg"
				style="width:100%;height:100%; height:150px; object-fit:contain; margin:20px 0" />



		</div>

		<div class="col-12 col-md-6 ">
			<img style="width:100%; object-fit:contain"
				src="<?php echo home_url(); ?>/wp-content/uploads/2024/11/Frame-1321315321.png" />

		</div>

	</div> <!-- Home banner 12 block close -->



	<div class="pl-1 pl-md-5">


		<div class="text-center py-5">
			<small class="text-primary">"Drive your financing forward – complete the entire application online, from start to finish."</small>
			<h2 class="text-dark">How to Apply for Vehicle Financing</h2>
		</div>

		<div class="col-md-12 d-flex flex-column flex-md-row align-items-center pl-md-5 ml-md-5 mb-5  position-relative">



			<div class="col-md-6 px-0 py-3">





				<div style="margin-left:10px">
					<div class="wrapper">
						<ul class="StepProgress">
							<div class="StepProgress-item no-number is-Done">Browse any used vehicle from your favorite marketplace in Canada and complete our quick online application.</div>
							<div class="StepProgress-item no-number current">Access your loan agreement and interest rate through our secure online portal, where you can also track your progress and add options for vehicle warranties, transport, and GAP Insurance. Complete and sign the deal online to get funded.
							</div>
							<div class="StepProgress-item no-number">Book your vehicle for transport anywhere in Canada through our partners. Sellers receive instant payment upon sale through Trbo Swift Escrow. You can also track the delivery of your vehicle from the user dashboard.
							</div>


						</ul>
					</div>
				</div>


				<div class="col-12 col-md d-flex justify-content-start align-items-stretch my-4">
					<div style="max-width:150px">
						<div
							style="height:100%; width:100%; background:#fff0; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
							<div
								style="width:50px; height:50px; background:#BF9B3E; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
								<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/wscan.svg" width="23"
									height="26" viewBox="0 0 23 26" />
							</div>
							<span style="font-size:12px; color:#333">Online Application</span>

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
								Approval </span>

						</div>
					</div>
					<div style="max-width:150px">
						<div
							style="height:100%; width:100%; background:#fff0; text-align: center; border-radius:11px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;">
							<div
								style="width:50px; height:50px; background:#BF9B3E; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
								<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/wpaper.svg" width="23"
									height="26" viewBox="0 0 23 26" />
							</div>
							<span style="font-size:12px; color:#333">
								Instant Seller payment</span>
							</span>

						</div>
					</div>

				</div>


				<a href="<?php echo home_url(); ?>/login" type="button"
					class="btn btn-secondary rounded-pill px-5 small" id="get-finance"><small>Sign up</small></a>

			</div><!--  6 block close -->

			<div class="col-md-6 px-0 text-right">
				<img class="financeUseDashboardImage" style=" right:0; top:0; width:750px; height:580px;"
					src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/Step-1-Agreement.png" />

			</div>

		</div> <!--  12 block close -->



	</div>


	<div class="bg-secondary  position-relative trboSwiftEscrowSection">

			<img class="position-absolute carRight" src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/Group-1321316653.png" />


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

				<small class="text-primary">Enhance your security with Scam Protection including a Stolen Vehicle Check with Trbo Swift Escrow.</small><br>
				<small class="text-white">Turbo Swift Escrow guarantees secure and reliable vehicle transactions in Canada’s market. We utilize Veriff for identity verification, Carfax for lien checks, and multiple trusted data sources to validate vehicles and ensure the legitimacy of each deal. Payments are held securely and released only after thorough checks on seller details, identity, and lien status are completed. With Turbo Swift Escrow, you can confidently buy or sell, knowing every transaction is protected and verified.</small>

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


	<div class="container py-5">


		<div class="d-flex justify-content-center flex-column align-items-center">
			<small class="text-primary">Your Guide to Secure Transactions</small>
			<h2 class="text-dark">Heres How to Get Started</h2>
			<div class="col-12 col-md-6 text-center">
				<span style="font-size:10px">Buy or sell with confidence, knowing your transaction is safe and hassle-free.</span>
			</div>

		</div>

		<div
			class="col-md-12 d-flex flex-column-reverse flex-md-row align-items-center pl-0 pr-md-5 mr-md-5  position-relative">


			<div class="col-md-6 px-0 text-center text-md-left position-relative">
				<img class="escrowUseDashboardImage" 
					src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/freepik_br_763e2511-77de-450d-bdf4-32f0bdf863d0-1-1.png" />

			</div>


			<div class="col-md-6 py-3">
				<div style="margin-left:10px">
					<div class="wrapper">
						<ul class="StepProgress">
							<div class="StepProgress-item number is-done">The buyer and seller finalize the terms and complete identity verification. The buyer then transfers funds to our Trbo Swift Trust Account at TD Bank.</div>
							<div class="StepProgress-item number current">The seller uploads ownership documents, provides key information, and completes the AI-powered damage inspection. Additionally, we conduct a nationwide lien check across Canada and a stolen vehicle check to ensure your purchase is secure and legitimate.
							</div>
							<div class="StepProgress-item number">We ensure the buyer receives the vehicle and the seller is paid, without any hassle, by securely managing the transaction and adhering to the terms outlined in the agreement.
							</div>


						</ul>
					</div>
				</div>



				<div class="mt-3">
					<a href="<?php echo home_url(); ?>/escrow-back-end/" type="button"
						class="btn btn-outline-secondary rounded-pill px-4 small d-flex align-items-center "
						style="max-width: 130px; font-size:10px"> <img style=" width:20px; object-fit:contain; margin-right:10px"
							src="<?php echo home_url(); ?>/wp-content/uploads/2024/06/Learn-More-icon.svg" /> See
						FAQs</a>
				</div>


			</div><!--  6 block close -->



		</div> <!--  12 block close -->



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
						<a class="btn btn-white rounded-pill px-3" style="font-size:12px; background:#fff">I’m
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
						<a class="btn btn-white rounded-pill px-3 mt-3" style="font-size:12px; background:#fff">I’m
							Buying</a>

					</div>
				</div>


			</div>

		</div>
	</div>


	<div class="bg-white">
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

	<div class="container p-5 col-12 row m-0">

		<div class="d-flex flex-column justify-content-center align-items-center align-items-md-start col-12 col-md-4">
			<small class="text-primary">Check our valued partners here</small>
			<h2 class="text-dark">Our Trusted Partners</h2>

		</div>

		<div class="col-12 col-md-8 my-2" style="display: grid
;
    grid-template-columns: repeat(3, 1fr);
    grid-auto-rows: auto;
    align-items: center; grid-gap: 3rem;">
			<div>
				<div
					style="text-align: start; border-radius:11px; display:flex; flex-direction:column; justify-content:space-around; align-items:flex-start;">
					<img style="height:100%; width:100%; object-fit:contain;"
						src="<?php echo home_url(); ?>/wp-content/uploads/2024/06/guardtree79.svg" />

				</div>
			</div>
			<div>
				<div
					style="text-align: start; border-radius:11px; display:flex; flex-direction:column; justify-content:space-around; align-items:flex-start;">
					<img style="height:100%; width:100%; object-fit:contain;"
						src="<?php echo get_template_directory_uri(); ?>/framework/images/carfax.svg" />

				</div>
			</div>

			<div>
				<div
					style="text-align: start; border-radius:11px; display:flex; flex-direction:column; justify-content:space-around; align-items:flex-start;">
					<img style="height:100%; width:100%; object-fit:contain;"
						src="<?php echo home_url(); ?>/wp-content/uploads/2024/11/Container.svg" />

				</div>
			</div>

		</div>

	</div>


	<div class="py-5">

		<div class="d-flex justify-content-center flex-column align-items-center ">
			<small class="text-primary">Other Benefits with Escrow </small>
			<h2 class="text-dark">Included with Trbo Swift Escrow</h2>


		</div>

		<div class="col-12 p-0 d-flex flex-md-column" style="gap:1rem">
		<div class="includedTrboSwiftCards right px-0 col-6 col-md-12">
			
			<div class="scrollRight">
				<div
					class="infoCardDesign">
					<div
						class="cardIcon">
						<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/Vector-1.svg" width="23"
							height="50" viewBox="0 0 30 50" />
					</div>
					<div>
						<span style="font-size:14px; color:#000">Trbo Inspection</span><br>
						<small style="font-size:12px; color:#333"> Our advanced car damage inspection technology identifies 19 different types of damage across 81 key components</small>
					</div>


				</div>
			</div>
			<div class="scrollRight">
				<div
					class="infoCardDesign">
					<div
						class="cardIcon">
						<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/11/Group-1321315025.svg" width="30"
							height="50" viewBox="0 0 30 50" />
					</div>
					<div>
						<span style="font-size:14px; color:#000">KYC Verification</span><br>
						<small style="font-size:12px; color:#333">Secure identity checks for all parties involved.</small>
					</div>


				</div>
			</div>
			<div class="scrollRight">
				<div
					class="infoCardDesign">
					<div
						class="cardIcon">
						<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/Vector-2.svg" width="30"
							height="50" viewBox="0 0 30 50" />
					</div>
					<div>
						<span style="font-size:14px; color:#000">Transport</span><br>
						<small style="font-size:12px; color:#333">Seamless vehicle transport across Canada. Quote and book online with our insured partners.</small>
					</div>


				</div>
			</div>
			<div class="scrollRight">
				<div
					class="infoCardDesign">
					<div
						class="cardIcon">
						<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/Group.svg" width="30"
							height="50" viewBox="0 0 30 50" />
					</div>
					<div>
						<span style="font-size:14px; color:#000">Stolen Vehicle Check</span><br>
						<small style="font-size:12px; color:#333">Our system scans multiple databases to identify any red flags, ensuring the vehicle has not been reported as stolen.</small>
					</div>


				</div>
			</div>

			<div class="scrollRight">
				<div
					class="infoCardDesign">
					<div
						class="cardIcon">
						<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/Vector.svg" width="30"
							height="50" viewBox="0 0 30 50" />
					</div>
					<div>
						<span style="font-size:14px; color:#000">Loan Pay Off</span><br>
						<small style="font-size:12px; color:#333">Hassle-free lien clearance for sellers with our Lien Payoff service—just $99.</small>
					</div>


				</div>
			</div>


		


		</div>
	
	<div class="includedTrboSwiftCards left p-0 col-6 col-md-12">
			<!-- New cards  -->

			<div class="scrollLeft">
				<div
					class="infoCardDesign">
					<div
						class="cardIcon">
						<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/Vector-3.svg" width="23"
							height="50" viewBox="0 0 30 50" />
					</div>
					<div>
						<span style="font-size:14px; color:#000">Nationwide Lien Check</span><br>
						<small style="font-size:12px; color:#333"> Powered by Carfax, we provide live lien searches with detailed lien holder info and payout amounts.</small>
					</div>


				</div>
			</div>
			<div class="scrollLeft">
				<div
					class="infoCardDesign">
					<div
						class="cardIcon">
						<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/11/Group-1321315025.svg" width="30"
							height="50" viewBox="0 0 30 50" />
					</div>
					<div>
						<span style="font-size:14px; color:#000">Payment Protection</span><br>
						<small style="font-size:12px; color:#333">Your funds are securely held and only released once all transaction conditions are verified, ensuring a safe and worry-free process.</small>
					</div>


				</div>
			</div>
			<div class="scrollLeft">
				<div
					class="infoCardDesign">
					<div
						class="cardIcon">
						<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/Group-1.svg" width="30"
							height="50" viewBox="0 0 30 50" />
					</div>
					<div>
						<span style="font-size:14px; color:#000">Financing</span><br>
						<small style="font-size:12px; color:#333">Process financing for any private sale vehicle in Canada.</small>
					</div>


				</div>
			</div>
			<div class="scrollLeft">
				<div
					class="infoCardDesign">
					<div
						class="cardIcon">
						<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/Group-2.svg" width="30"
							height="50" viewBox="0 0 30 50" />
					</div>
					<div>
						<span style="font-size:14px; color:#000">No Cancellation Fees!</span><br>
						<small style="font-size:12px; color:#333"> We only charge our fee once the transaction is successfully completed, and there are no cancellation fees.</small>
					</div>


				</div>
			</div>

			<div class="scrollLeft">
				<div
					class="infoCardDesign">
					<div
						class="cardIcon">
						<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/Group-1321317100.svg" width="30"
							height="50" viewBox="0 0 30 50" />
					</div>
					<div>
						<span style="font-size:14px; color:#000">Escrow Payment</span><br>
						<small style="font-size:12px; color:#333">  Secure instant wire transfers for private vehicle sales with Turbo Swift Escrow.</small>
					</div>


				</div>
			</div>
			
	</div>
	</div>


		<div class="text-center">

			<a href="<?php echo home_url(); ?>/escrow/" class="btn btn-secondary rounded-pill px-5 mt-3"
				style="font-size:12px;">Start Escrow
			</a>

		</div>

	</div>





	<div class="bg-secondary ">

		<div class="container position-relative">

			<div class="d-flex justify-content-center flex-column align-items-center pt-3">


				<div class="col-12 col-md-6 text-center text-capitalize">
					<h2 class="text-white">Book online & get delivery<br>anywhere in canada</h2>
				</div>


			</div>

			<div class="col-md-12 d-flex flex-column flex-md-row align-items-center py-3">


				<div class="col-md-6 text-white pr-md-5">

					<span class="text-primary">Choose from flatbed towing to enclosed trailer to your
						destination.</span>

					<p class="text-white small"><strong>Dependable, Consistent, and Comprehensive:</strong> Easily
						schedule your vehicle
						transport directly through Trbo Swift. With our seamless platform, you can track your vehicle in
						real time while we manage every step of the buying and selling process—from financing to escrow.
						Enjoy competitive, transparent pricing through our trusted nationwide carriers, and unlock
						exclusive benefits by using Trbo Swift Transport at checkout!</p>


					<div class="bg-white border d-flex align-items-center px-3 py-1 position-relative"
						style="border-radius:10px 12px 12px 10px;">
						<div style="width:1px; position:absolute; height:100%; left:-20px; top:0px; border-radius: 30px 0px 0px 30px;
    border-left: 7px solid #BF9B3E !important;">
						</div>
						<img style="width:40px;"
							src="<?php echo home_url(); ?>/wp-content/uploads/2024/11/Group-1321316662.svg" />
						<div class="ml-2 small">
							<span style="color:#53565A"><strong>Effortless,
									Speedy, and Affordable</strong><br>Ship any vehicle, no matter where you purchase
								it.</span>
						</div>
					</div>

					<button onclick="window.location.href = '<?php echo home_url(); ?>/what-is-turbobid/' "
						class="btn btn-primary rounded-pill my-3">Learn more</button>

				</div>

				<div class="col-md-6 ml-0 ml-md-4 text-right">

					<img style="width:100%; object-fit:contain"
						src="<?php echo home_url(); ?>/wp-content/uploads/2024/11/Group-1321315342.svg" />


				</div>

			</div>





		</div><!--  Block close -->




	</div>



	<div class="py-3 bg-white">
	<div class="container pb-3 bg-white">



		<div class="d-flex  flex-column flex-md-row justify-content-center align-items-center my-2 ">

			
				<div
					style="text-align: start; border-radius:11px; display:flex; flex-direction:column; justify-content:space-around; align-items:flex-start; padding:30px;">
					<img class="box-shadow" style="height:300px; width:100%; object-fit:cover; border-radius:15px; "
						src="<?php echo home_url(); ?>/wp-content/uploads/2024/11/Background.png" />

				</div>
			

			
				<div
					style="text-align: start; border-radius:11px; display:flex; flex-direction:column; justify-content:space-around; align-items:flex-start; padding:30px;">
					<img class="box-shadow" style="height:300px; width:100%; object-fit:cover; border-radius:15px; "
						src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/CUSTOMER-PANEL-updated-1-1.png" />

				</div>
			

			
				<div
					style="text-align: start; border-radius:11px; display:flex; flex-direction:column; justify-content:space-around; align-items:flex-start; padding:30px;">
					<img class="box-shadow" style="height:300px; width:100%; object-fit:cover; border-radius:15px; "
						src="<?php echo home_url(); ?>/wp-content/uploads/2024/11/Backgrounde.png" />

				</div>
			


		</div>

	</div>





	<div class="container bg-white">

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


	<div class="bottomSellWithUs p-2  text-center bg-primary">
		<span class="small text-white font-weight-bold text-mobile-9">Shop Canada Wide, Any Vehicle, Any Marketplace <a href="<?php echo home_url(); ?>/escrow/" class="text-white font-weight-bold">Apply Now</a></span>

		<a onclick="jQuery('.bottomSellWithUs').fadeOut(400);" class="btn close-stripe d-block">
			<i class="fas fa-times"></i>
		</a>
	</div>


</div>





<script>
jQuery(document).ready(function($) {
	let make = '';
	let model = '';
	let year = '';

	$('#get-escrow').on('click', function() {
		const vin = $('#vehicle-identification-number').val();

		if (!vin) {
			alert('Please enter VIN number.');
			return;
		}

		vinDecodeApi(vin).done(function() {
			const redirectUrl =
				`<?php echo home_url(); ?>/escrow-back-end/?vin=${encodeURIComponent(vin)}&myear=${encodeURIComponent(year)}&make=${encodeURIComponent(make)}&model=${encodeURIComponent(model)}`;

			window.location.href = redirectUrl;
		});
	});

	$('#get-finance').on('click', function() {
		const vin = $('#vehicle-identification-number').val();

		// if (!vin) {
		// 	alert('Please enter VIN number.');
		// 	return;
		// }

		showFinanceStartModal();

	
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
				showFinanceStartModal();
			}, 2000);
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





	   const right = document.querySelector(".includedTrboSwiftCards.right");
  const cardsRight = Array.from(right.children);

   cardsRight.forEach((card) => {
    const clone = card.cloneNode(true);
    right.appendChild(clone);
  });

  
  const container = document.querySelector(".includedTrboSwiftCards.left");
  const cardsLeft = Array.from(container.children);

  // Clone and append all cards to create a loop
  cardsLeft.forEach((card) => {
    const clone = card.cloneNode(true);
    container.appendChild(clone);
  });





function showFinanceStartModal(){
	


	let displayData = `
	<div class="p-md-3 ">

								<div class="" style="max-width:110px; margin-top: -45px;  margin-bottom:45px;">
										<?php echo $CORE->LAYOUT("get_logo", "light"); ?>
								</div>


								<div class="container m-0 position-relative"
									style="border-radius:22px;">

									<div class="d-flex mb-2"> <span class="text-black font-weight-bold font-16 text-start" style="font-family:Plus Jakarta Sans;">Start a deal as a...</span> </div> 


									<div class="col-md-12 p-0 d-flex justify-content-center align-items-center" style="gap:10px">
										
									<button id="dealStartForBuyer" class="brn py-1 px-3 font-10 packages-card bg-white" style="width:200px; ${document.documentElement.clientWidth <= 768 ? 'height:150px;' : 'height:200px;' } border-radius:10px; border:1px solid #eeeeee;">
									<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/Group.png" style="width:100%; height:100%; object-fit: contain;" />
									<div class="text-center mt-2"> <span class="font-weight-bold text-dark">Buyer</span> </div>
									</button>

									<button  id="dealStartForSeller" class="brn py-1 px-3 font-10 packages-card bg-white" style="width:200px; ${document.documentElement.clientWidth <= 768 ? 'height:150px;' : 'height:200px;' } border-radius:10px; border:1px solid #eeeeee;">
									<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/Group-1321317466.png" style="width:100%; height:100%; object-fit: contain;" />
									<div class="text-center mt-2"> <span class="font-weight-bold text-dark">Seller</span> </div>
									</button>

									</div>
									

								</div>
		</div>
	`;



	jQuery('.newUserAddModalContainer').addClass('bg-white customModalWidthHalf px-2 position-relative').css({"max-height": "60vh"}).html(displayData);
	jQuery('.newUserAddModalBody').removeClass('d-none').addClass('d-flex');

}



});

</script>

<style>

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

.yellow-side-bg {
	position: absolute;
	left: -26px;
	top: -80px;
}

.ai-id-card {
	height: 500px;
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

	.icon-number {
		height: 70px;
		min-width: 70px;
		background: white;
		border-radius: 100%;
		color: #3B634C;
		font-size: 35px;
		font-weight: 700;
		display: flex;
		align-items: center;
		justify-content: center;
		margin-right: 10px;
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
	overflow: hidden;
	/* Ensure the pseudo-elements are positioned relative to this element */
}

.hero-banner::before {
	content: "";
	background-image: url(<?php echo home_url(); ?>/wp-content/uploads/2024/11/Vector.png);
    position: absolute;
    top: -58px;
    right: -80px;
    width: 800px;
    height: 100%;
    /* transform: rotate(5deg); */
    object-fit: contain;
    background-repeat: no-repeat;
    z-index: 0;
    padding: 0px;
}

.hero-banner::after {
	content: "";
	background-image: url('<?php echo home_url(); ?>/wp-content/uploads/2024/11/Vector2.png');
	position: absolute;
       bottom: -279px;
    left: -8px;
    width: 518px;
    height: 500px;
    object-fit: contain;
    background-repeat: no-repeat;
    z-index: 0;
    padding: 0px;
    transform: rotate(350deg);
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

@media screen and (max-width:767.99px) {

.hero-banner::before {
	content: "";
	background-image: url(<?php echo home_url(); ?>/wp-content/uploads/2024/11/Vector.png);
    position: absolute;
    top: 355px;
    right: -250px;
    width: 660px;
    height: 100%;
    transform: rotate(-11deg);
    object-fit: contain;
    background-repeat: no-repeat;
    z-index: 0;
    padding: 0px;
}

.hero-banner::after {
	content: "";
	background-image: url('<?php echo home_url(); ?>/wp-content/uploads/2024/11/Vector2.png');
	position: absolute;
    bottom: 322px;
    left: -200px;
    width: 440px;
    height: 500px;
    object-fit: contain;
    background-repeat: no-repeat;
    z-index: 0;
    padding: 0px;
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

	.icon-number {
		height: 40px;
		min-width: 40px;
		background: white;
		border-radius: 100%;
		color: #3B634C;
		font-size: 25px;
		font-weight: 700;
		display: flex;
		align-items: center;
		justify-content: center;
		margin-right: 10px;
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
		max-width:400px;
		max-height:300px;
		object-fit:contain;
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
  height: 50%;
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
    height: 50%;
    border-left: 1px dashed #BF9B3E;
}

.StepProgress strong {
	display: block;
}


/* New designs */



/* General Styles for Desktop and Mobile */


/* Animations */
/* Scroll right */
@keyframes scrollRight {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(100%);
  }
}

/* Scroll left */
@keyframes scrollLeft {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-100%);
  }
}

/* Scroll down */
@keyframes scrollDown {
  0% {
    transform: translateY(0);
  }
  100% {
    transform: translateY(100%);
  }
}

/* Scroll up */
@keyframes scrollUp {
  0% {
    transform: translateY(0);
  }
  100% {
    transform: translateY(-100%);
  }
}





/* desktop */
@media (min-width: 1000px) {

	.carRight{
		right: 0px;
        top: 50%;
        bottom: 0;
        transform: translate(-10%, -50%);
		max-height: 500px;
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
  display: flex;
  grid-template-columns: repeat(5, 1fr); /* 5 cards per row */
  grid-auto-rows: auto;
  gap: 1rem;
  position: relative;
  width: 100%;
}

 /* Top row: Scroll to the right */
  .includedTrboSwiftCards > .scrollRight {
    animation: scrollRight 15s linear infinite;
  }

  /* Bottom row: Scroll to the left */
  .includedTrboSwiftCards > .scrollLeft {
    animation: scrollLeft 15s linear infinite;
  }

/* Card Design */
.infoCardDesign {
  background: #fff;
  box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
  text-align: center;
  border-radius: 5px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 20px;
          height: 244px;
        width: 244px;
position: relative;
}

.infoCardDesign .cardIcon{
    width: 80px;
        height: 80px;
        background: #3B634C;
        border-radius: 100%;
        margin-bottom: 8px;
        align-content: center;
		        position: absolute;
        top: 50%;
        transform: translate(0%, -120%);
}

.infoCardDesign div:nth-child(2){
	position: absolute;
    top: 50%;
    transform: translate(0%, -10%);
    width: 210px;
}
	

					}

	/* Tablet */

	@media (min-width: 576px) and (max-width: 1000px) {

	.headerMainTextStyle {
							margin-right: -220px;
						}
	h1{
	font-size: 40px !important;
    font-weight: 600 !important;
}

.includedTrboSwiftCards{
		display: grid ;grid-template-columns: repeat(3, 1fr);
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
	height:130px; width:130px; background:#487259; text-align: center; border-radius:5.25px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;
}



.escrowUseDashboardImage{
        max-height: 300px;
        object-fit: contain;
}


}


	/* Mobile */

	@media (max-width: 576px) {

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
        transform: translate(-10%, -50%);
        max-height: 219px;
        object-fit: contain;
	}	

.cardGridLayout{
	display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-auto-rows: auto;
    grid-gap: 1rem;
}

.smallOptionCard{
	height:130px; width:130px; background:#487259; text-align: center; border-radius:5.25px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;
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
        height: 79%;
        background-color: #C5A142;
        z-index: 0;
        transform: translate(141%, 0%) rotate(10deg);
    
    }



					}

/* Mobile closed  */

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

    }

}

?>