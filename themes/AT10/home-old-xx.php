<?php
   /*
   Template Name: [PAGE - OLD HOME]
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
		<div class="pt-5 mt-5">
			<span class="text-primary">Canada's First Secure Escrow & Private Vehicle Financing Platform</span>
			<h1>Your Car Deal, Simplified.</h1>
			<span class="small">Our escrow, financing, and warranty keep you safe. Canada's first secured all-in-one
				platform for car buyers and sellers.</span>
		</div>
		<div class="d-flex flex-column flex-md-row align-items-start">
			<div class="col-md-4 p-0">
				<div class="bg-white radiusx-20 mt-3 p-3 m-0">
					<h5>Get Started Below!</h5>
					<span class="small">Experience effortless, secure transactions with TurboBid’s automated
						process—Canada’s premier platform for seamless transactions.</span>

					<div id="vehicle-form">

						<div id="decoded-vin-result"
							class="d-flex justify-content-center py-2 text-primary radiusx my-3"
							style="border:1px solid #BF9B3E">VIN</div>

						<div class="form-group position-relative">
							<label class="small">VIN</label>
							<input type="text" class="form-control radiusx border" placeholder="Enter vin number"
								name="vehicle-identification-number" id="vehicle-identification-number" value=""
								autocomplete="vehicle-identification-number">
						</div>

						<!-- <div class="form-group position-relative">
            <label>Model Year</label>
            <input type="text" class="form-control rounded-pill" placeholder="Enter car model year" name="modelyear" id="modelyear" value="" autocomplete="modelyear">
        </div> -->

						<div class="d-flex flex-column flex-md-row justify-content-center mt-1" style="gap:10px">
							<button type="button" class="btn btn-secondary rounded-pill px-4"
								id="get-escrow"><small>Start Escrow</small></button>

							<button type="button" class="btn btn-secondary rounded-pill px-4"
								id="get-finance"><small>Finance Vehicle</small></button>

						</div>
					</div>
					<div class="d-flex justify-content-center align-items-center small my-2"><span>Instant lien searches
							powered by</span> <img
							src="<?php echo get_template_directory_uri(); ?>/framework/images/carfax.svg"
							style="object-fit:contain; margin-left:5px;" /></div>
				</div>


			</div>

			<div class="col-md-8">
				<img style="width:100%; object-fit:contain"
					src="<?php echo get_template_directory_uri(); ?>/framework/images/herocar.svg" />

			</div>
		</div>

	</div> <!-- Home banner 12 block close -->


	<div
		class="any-vehicle escrow-process  col-md-12 d-flex flex-column flex-md-row align-items-start position-relative">
		<div style="background:#F8F9FA; position: absolute;top: 0;left: 0;right: 0;height:450px;"></div>
		<div class="col-md-7">

			<span class="text-dark font-weight-bold small rounded-pill px-3 py-2"
				style="background: rgba(191, 155, 62, 0.20); border: 1px solid #F5B100;">Process Escrow Transactions in
				less
				than 2 minutes</span>
			<h1>Any vehicle, any marketplace</h1>
			<span class="text-primary">Canada’s First Escrow and Private Vehicle Financing Platform </span><br>

			<img src="<?php echo get_template_directory_uri(); ?>/framework/images/brands.svg"
				style="width:100%;height:100%;object-fit:contain; margin:20px 0" />

			<div class="purchasing d-flex flex-wrap">


				<div class="col-6 col-md-4 py-1  px-1 pl-md-0">
					<div class="bg-white border d-flex justify-content-start align-items-center radiusx-20 p-3">
						<img src="<?php echo get_template_directory_uri(); ?>/framework/images/ai-inspection.svg"
							style="max-height:60px; object-fit:contain; margin-right:5px;" />
						<h6>TurboBid AI Inspection</h6>
					</div>
				</div>


				<div class="col-6 col-md-4 py-1 px-1">
					<div class="bg-white border d-flex justify-content-start align-items-center radiusx-20 p-3">
						<img src="<?php echo get_template_directory_uri(); ?>/framework/images/contracting.svg"
							style="max-height:60px; object-fit:contain; margin-right:5px;" />
						<h6>Digital Contracting </h6>
					</div>
				</div>

				<div class="col-6 col-md-4 py-1  px-1 pr-md-0">
					<div class="bg-white border d-flex justify-content-start align-items-center radiusx-20 p-3">
						<img src="<?php echo get_template_directory_uri(); ?>/framework/images/protection.svg"
							style="max-height:60px; object-fit:contain; margin-right:5px;" />
						<h6>Payment Protection</h6>
					</div>
				</div>






				<div class="col-6 col-md-4 py-1 px-1 pl-md-0">
					<div class="bg-white border d-flex justify-content-start align-items-center radiusx-20 p-3">
						<img src="<?php echo get_template_directory_uri(); ?>/framework/images/kyc.svg"
							style="max-height:60px; object-fit:contain; margin-right:5px;" />
						<h6>Seller KYC Verification</h6>
					</div>
				</div>


				<div class="col-6 col-md-4 py-1 px-1">
					<div class="bg-white border d-flex justify-content-start align-items-center radiusx-20 p-3">
						<img src="<?php echo get_template_directory_uri(); ?>/framework/images/transport.svg"
							style="max-height:60px; object-fit:contain; margin-right:5px;" />
						<h6>TurboBid Transport</h6>
					</div>
				</div>

				<div class="col-6 col-md-4 py-1 px-1  pr-md-0">
					<div class="bg-white border d-flex justify-content-start align-items-center radiusx-20 p-3">
						<img src="<?php echo get_template_directory_uri(); ?>/framework/images/instant-pay.svg"
							style="max-height:60px; object-fit:contain; margin-right:5px;" />
						<h6>Instant Payment</h6>
					</div>
				</div>

			</div>


		</div>

		<div class="col-md-5 py-3 ">
			<img style="width:100%; object-fit:contain"
				src="<?php echo get_template_directory_uri(); ?>/framework/images/turbo-map.svg" />

		</div>

	</div> <!-- Home banner 12 block close -->



	<div class="home-middle-block">

		<div class="bg-primary innovation-section text-white position-relative">

			<img class="inovation-bg" style="width:100vw; object-fit:cover"
				src="<?php echo get_template_directory_uri(); ?>/framework/images/inovation-bg.svg" />

			<div class="text-center">
				<h2 class="text-center bold ">Our escrow, financing, and warranty keep you safe. </h2>

			</div>

			<div class="pt-3" style=" position: relative;z-index:2">

				<ul class="nav justify-content-center nav-pills mb-3" id="pills-tab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="innovation-tab active" id="pills-home-tab" data-toggle="pill"
							data-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
							aria-selected="true">Escrow</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="innovation-tab" id="pills-profile-tab" data-toggle="pill"
							data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
							aria-selected="false">Financing</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="innovation-tab" id="pills-contact-tab" data-toggle="pill"
							data-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
							aria-selected="false">Warranty</button>
					</li>
				</ul>


				<div class="tab-content" id="pills-tabContent">
					<div class="tab-pane fade show active" id="pills-home" role="tabpanel"
						aria-labelledby="pills-home-tab">

						<div class="col-md-12 d-flex flex-column flex-md-row align-items-start px-0">
							<div class="col-md-6 py-3 position-relative">
								<img class="message-pop"
									src="<?php echo get_template_directory_uri(); ?>/framework/images/pop-message.svg" />

								<h3 class="text-black">Add Escrow To Your Transaction</h3>
								<h6 class="text-secondary mb-4">Get Payment Protection with TurboBid</h6>
								<div class="col-12 px-0">
									<div class="small col-7 col-md-10 px-0">Our escrow service ensures a smooth vehicle
										transaction across Canada by verifying buyer and seller info, outlining clear
										terms, and conducting a TurboBid AI inspection. We handle identity verification,
										nationwide lien checks through Carfax, and a detailed damage inspection. Payment
										is released once all conditions are met, ensuring a reliable, hassle-free
										experience.</div>
									<div class="col-md-8 p-0 mt-3">
										<h3>Transparent, low fees</h3>
										<div class="d-flex justify-content-between py-3 border-bottom">
											<span>Buyers</span><span>$249 Escrow fee</span>
										</div>

										<div class="d-flex justify-content-between py-3 border-bottom">
											<span>Sellers</span><span class="text-right">+$99 loan payoff
												fee<br><small><a href="#" style="color:#1A2B63">More info on selling a
														financed car</a></small></span>
										</div>

									</div>

									<small>Fees can be shared equally between buyers and sellers, or one party can
										choose to cover them entirely. We only collect our fee once the transaction is
										successfully completed and do not impose any cancellation charges.</small>
								</div>


								<button onclick="window.location.href = '<?php echo home_url(); ?>/escrow/' "
									class="btn btn-secondary rounded-pill mt-3">Learn more</button>

							</div>

							<div class="col-md-6 py-3 px-0">
								<img class="dashboard-img" style="object-fit:contain"
									src="<?php echo get_template_directory_uri(); ?>/framework/images/escrow-dashboard.svg" />

							</div>

						</div>


					</div><!-- Tab content block close -->

					<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

						<div class="col-md-12 py-3 d-flex flex-column flex-md-row align-items-center">
							<div class="col-md-6 px-0">
								<h3 class="text-black">Financing: Any Vehicle, Any Marketplace</h3>
								<img style="width:35vh;height:60px; margin: 20px 0px; object-fit:contain"
									src="<?php echo home_url(); ?>/wp-content/uploads/2024/07/Group-1321315018.png" />

								<div class="py-3">

									<span class="font-weight-bold">Borrow up to the full purchase price</span><br>
									<span class="opacity-5">Fill out our online form to get pre-qualified in
										minutes––with no fees, and no impact to your credit score.</span>

								</div>

								<div class="py-3">

									<span class="font-weight-bold">Competitive interest rates</span><br>
									<span class="opacity-5">Discover the perfect vehicle with payments you are
										pre-qualified for.</span>

								</div>

								<div class="py-3">

									<span class="font-weight-bold">Interest rate options</span><br>
									<span class="opacity-5">We partner with some of Canada's largest financial
										institutions to help get you a great rate.</span>

								</div>

								<div class="py-3">

									<span class="font-weight-bold">Flexible repayment schedule</span><br>
									<span class="opacity-5">Select from flexible repayment options that allow you to pay
										off your loan early or make additional payments.</span>

								</div>

								<button onclick="window.location.href = '<?php echo home_url(); ?>/finance/' "
									class="btn btn-secondary rounded-pill mt-3">Learn more</button>

							</div>

							<div class="col-md-6 px-0 py-3 py-md-0">
								<img class="dashboard-img" style="object-fit:contain"
									src="<?php echo get_template_directory_uri(); ?>/framework/images/finance-db.svg" />

							</div>

						</div>

					</div><!-- Tab content block close -->


					<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">

						<div class="col-md-12 py-3 px-0 d-flex flex-column flex-md-row align-items-start">
							<div class="col-md-6 p-0 px-md-3">


								<h3 class="text-black">Canada’s First Subscription Warranty</h3>

								<span class="small">TurboBid Protection Plans are designed to offer Canadians
									affordable, high-quality extended car warranties. In just a few clicks, you can
									cover your vehicle against breakdowns, including repair and replacement costs. Our
									plans also include roadside assistance, car rental, and trip interruption benefits
									while your car is in the repair shop.
									Warranty plans are available during your automated checkout process at no cost for
									the first month. After that, coverage continues monthly through one of TurboBid's
									warranty partner providers, ensuring seamless protection for your vehicle.</span>

								<div class="d-flex flex-wrap flex-md-row my-3" style="gap:30px;">
									<div class="d-flex align-items-center"><i class="fas fa-check-circle mr-2"
											style="color: #60BE02;"></i> No Inspection Required </div>
									<div class="d-flex align-items-center"><i class="fas fa-check-circle mr-2"
											style="color: #60BE02;"></i> No Inspection Required </div>
									<div class="d-flex align-items-center"><i class="fas fa-check-circle mr-2"
											style="color: #60BE02;"></i> No Inspection Required </div>
								</div>

								<div class="d-flex flex-wrap flex-md-row">
									<div class="col-md-4 p-2">
										<div
											class=" bg-white text-black d-flex flex-column justify-content-center align-items-center radiusx-20 p-3 mb-2">
											<h6>C$49.95 /mo</h6>
											<small style="color:eee; font-size:10px">Most Popular</small>
											<span>Deductible $500</span>
											<span>Limit per Repair $2500</span>
										</div>
									</div>
									<div class="col-md-4 p-2">
										<div
											class="bg-white text-black d-flex flex-column justify-content-center align-items-center radiusx-20 p-3 mb-2">
											<h6>C$69.95 /mo</h6>
											<small style="color:eee; font-size:10px">Popular</small>
											<span>Deductible $250</span>
											<span>Limit per Repair $5000</span>
										</div>
									</div>
									<div class="col-md-4 p-2">
										<div
											class=" bg-white text-black d-flex flex-column justify-content-center align-items-center radiusx-20 p-3 mb-2">
											<h6>C$79.95 /mo</h6>
											<small style="color:eee; font-size:10px">Popular</small>
											<span>Deductible $1000</span>
											<span>Limit per Repair $2500</span>
										</div>
									</div>
								</div>
								<button onclick="window.location.href = '<?php echo home_url(); ?>/protection-plans/' "
									class="btn btn-secondary rounded-pill mt-3">Learn more</button>



							</div>

							<div class="col-md-6 p-0 p-md-2">
								<img style="width:100%; object-fit:contain"
									src="<?php echo get_template_directory_uri(); ?>/framework/images/car-point.svg" />

							</div>

						</div>

					</div><!-- Tab content block close -->
				</div><!-- section content block close -->

			</div>

		</div><!--  Block close -->


		<div class="innovation-section">
			<div class="text-center py-5">
				<h2>TurboBid Escrow</h2>
				<span class="small">Secure and Reliable Vehicle Transaction Services</span>
			</div>

			<div class="col-md-12 d-flex flex-column flex-md-row align-items-center px-0">
				<div class="col-md-6 px-0 position-relative">
					<img class="escrow-writing-img"
						src="<?php echo get_template_directory_uri(); ?>/framework/images/writing.jpeg" />
					<img class="z-index" style="width:100%; object-fit:contain"
						src="<?php echo get_template_directory_uri(); ?>/framework/images/turbo-escrow.svg" />

				</div>
				<div class="col"></div>

				<div class="col-md-4 px-0 py-3">

					<h1>Our simple process.</h1>
					<span>Our automated Escrow Process simplifies the process for dealerships to compete and acquire
						inventory, allowing you to expand your search beyond traditional dealer auctions to all
						marketplaces in Canada</span>

					<div class="mt-4 text-dark d-flex justify-content-start align-items-start align-items-md-start radiusx-20 p-3 mb-2"
						style="gap:10px">

						<div class="step-wrap active">
							<div class="circle"><span class="step-title">1</span></div>
							<span class="text">Step</span>
						</div>

						<div>

							<span class="">Buyer and seller agree on terms and complete identity verification.</span>
						</div>
					</div> <!-- Row close -->

					<div class="text-dark d-flex justify-content-start align-items-start align-items-md-start radiusx-20 p-3 mb-2"
						style="gap:10px">

						<div class="step-wrap active">
							<div class="circle"><span class="step-title">2</span></div>
							<span class="text">Step</span>
						</div>

						<div>

							<span class="">Buyer can instantly check liens through Carfax Canada instantly through our
								automated process. </span>
						</div>
					</div> <!-- Row close -->

					<div class="text-dark d-flex justify-content-start align-items-start align-items-md-start radiusx-20 p-3 mb-2"
						style="gap:10px">

						<div class="step-wrap active">
							<div class="circle"><span class="step-title">3</span></div>
							<span class="text">Step</span>
						</div>

						<div>

							<span class="">The seller completes the TurboBid AI inspection, and the buyer approves it
								after review. Payment to the seller is made upon vehicle pickup or delivery, based on
								the terms outlined in the agreement.</span>
						</div>
					</div> <!-- Row close -->

					<div class="text-right mt-2"><img style="height:50px; object-fit:contain "
							src="<?php echo get_template_directory_uri(); ?>/framework/images/brands2.svg" /></div>

				</div><!--  6 block close -->

			</div> <!--  12 block close -->
		</div> <!--  section block close -->


		<div class="innovation-section py-5">
			<h1 class="text-center">Start Escrow Now</h1>

			<?php echo do_shortcode('[elementor-template id="325677"]'); ?>


		</div>

		<div class="innovation-section bg-white py-5">

			<?php echo do_shortcode('[elementor-template id="325686"]'); ?>


		</div>



		<div class="position-relative">

			<div class="transport-section col-md-12 d-flex flex-column flex-md-row align-items-center">
				<img class="transport-car  position-absolute"
					src="<?php echo get_template_directory_uri(); ?>/framework/images/cartruck.svg" />

				<div class="col-md-6" style="z-index:11">
					<h1>Transport</h1>
					<h3>Book online & get delivery anywhere in canada</h3>

					<p><strong>Dependable, Consistent, and Comprehensive:</strong> We manage every aspect of the process
						from start to finish, allowing you to concentrate on buying and selling more cars. Enjoy
						competitive and transparent pricing through our nationwide network of trusted carriers.
						Additionally, use TurboBid Transport at checkout to unlock exclusive benefits.</p>

					<div class="bg-white border d-flex align-items-center px-3 py-2"
						style="border-radius:10px 20px 20px 10px; border-left:4px solid #124326!important;"><i
							class="far fa-check-circle mr-2" style="color: #124326;"></i> <span><strong>Effortless,
								Speedy, and Affordable</strong><br>Ship any vehicle, no matter where you purchase
							it.</span> </div>

					<button onclick="window.location.href = '<?php echo home_url(); ?>/what-is-turbobid/' "
						class="btn btn-secondary rounded-pill my-3">Learn more</button>

				</div>

				<div class="col-md-6">

				</div>

			</div>



			<div class="transport-tabs bg-secondary pt-0" style=" position: relative;z-index:0">
				<img class="yellow-side-bg"
					src="<?php echo get_template_directory_uri(); ?>/framework/images/yellow-left-bg.svg" />

				<div style="padding-top:283px">
					<div class="z-index text-center">
						<h1 class="text-center bold text-white">TurboBid Transparency</h1>

					</div>
					<ul class="nav justify-content-center nav-pills mb-3 z-index" id="pills-tab" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="transport-tab active" id="pills-Carfax-Lien-tab" data-toggle="pill"
								data-target="#pills-Carfax-Lien" type="button" role="tab"
								aria-controls="pills-Carfax-Lien" aria-selected="true">Carfax Lien</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="transport-tab" id="pills-TurboBidAiInspection-tab" data-toggle="pill"
								data-target="#pills-TurboBidAiInspection" type="button" role="tab"
								aria-controls="pills-TurboBidAiInspection" aria-selected="false">TurboBid Ai
								Inspection</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="transport-tab" id="pills-EscrowPayments-tab" data-toggle="pill"
								data-target="#pills-EscrowPayments" type="button" role="tab"
								aria-controls="pills-EscrowPayments" aria-selected="false">Escrow Payments</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="transport-tab" id="pills-KYCVerification-tab" data-toggle="pill"
								data-target="#pills-KYCVerification" type="button" role="tab"
								aria-controls="pills-KYCVerification" aria-selected="false">KYC Verification</button>
						</li>
					</ul>


					<div class="tab-content z-index" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-Carfax-Lien" role="tabpanel"
							aria-labelledby="pills-Carfax-Lien-tab">

							<div class="col-md-12 d-flex flex-column flex-md-row align-items-start px-0">
								<div class="col-md-6 py-3 text-white px-0">

									<span class="text-primary">Steer clear of others' debt—ensure a lien-free vehicle in
										every transaction.</span>
									<h3>Carfax instant lien check</h3>
									<small>TurboBid Escrow is the first of its kind in Canada, offering an innovative
										and secure solution for vehicle transactions. Our automated process ensures
										instant lien checks across the country, backed by Carfax's lien guarantee, for a
										smooth and transparent experience.</small>

									<div class="mt-4 text-dark d-flex justify-content-start align-items-center p-3 mb-2"
										style="gap:10px">

										<span class="icon-number bg-primary text-white">1</span>

										<div>

											<span class="text-white">Use our automated process to check vehicle liens
												all across canada</span>
										</div>
									</div> <!-- Row close -->


									<div class="mt-4 text-dark d-flex justify-content-start align-items-center p-3 mb-2"
										style="gap:10px">

										<span class="icon-number bg-primary text-white">2</span>

										<div>

											<span class="text-white">We’ll settle any outstanding liens on the vehicle
												to ensure a smooth
												and issue-free transfer.</span>
										</div>
									</div> <!-- Row close -->



								</div>

								<div class="col-md-6 py-3 px-0">
									<img style="object-fit:contain"
										src="<?php echo get_template_directory_uri(); ?>/framework/images/lien-protection.svg" />

								</div>

							</div>


						</div><!-- Tab content block close -->

						<div class="tab-pane fade" id="pills-TurboBidAiInspection" role="tabpanel"
							aria-labelledby="pills-TurboBidAiInspection-tab">

							<div
								class="col-md-12 d-flex flex-column flex-md-row align-items-center text-white px-0 py-3">
								<div class="col-md-6 px-0">
									<span class="text-primary">Revolutionizing vehicle transactions</span>
									<h3>TurboBid AI Damage Inspection for All Escrow Transactions</h3>
									<small>Ensure complete transparency in your transaction by sending and reviewing the
										TurboBid AI Condition Report. This report evaluates 81 vehicle components and
										identifies 19 types of damage, offering a comprehensive view of the vehicle’s
										condition. The buyer reviews the detailed report to guarantee a smooth and
										transparent process.</small>

									<img style="object-fit:contain;object-fit: contain; height: 300px; width: 100%;"
										src="<?php echo home_url(); ?>/wp-content/uploads/2024/07/image-128.png" />
									<br> <button
										onclick="window.location.href = '<?php echo home_url(); ?>/what-is-turbobid/' "
										class="btn btn-primary rounded-pill mt-3">Learn more</button>

								</div>

								<div class="col-md-6 px-0 py-5 py-md-0">
									<video id="aiVideo " class="aiVideo" style="width:100%!important;" autoplay loop
										playsinline defaultmuted preload="auto">
										<source
											src="<?php echo home_url(); ?>/wp-content/uploads/2024/06/WhatsApp-Video-2024-06-03-at-2.24.10-AM.mp4"
											type="video/mp4">
									</video>

									<script>
									jQuery('#aiVideo').trigger('play');
									</script>

								</div>

							</div>

						</div><!-- Tab content block close -->


						<div class="tab-pane fade" id="pills-EscrowPayments" role="tabpanel"
							aria-labelledby="pills-EscrowPayments-tab">

							<div class="col-md-12 p-0 d-flex flex-column flex-md-row align-items-start text-white pb-5">
								<div class="col-md-6 p-0 px-md-3">


									<span class="text-primary">Ensuring Reliable Fund Custody</span>
									<h3>Secure Payments with TurboBid</h3>
									<small>Buyers transfer funds to the TurboBid Trust Account as part of the escrow
										process. TurboBid verifies the payment and notifies the seller once it is
										confirmed. The seller receives payment instantly when the vehicle is picked up
										or delivered, as outlined in the agreement. Payments are processed through
										Hyperwallet, powered by PayPal, for fast and secure direct wire
										transfers.</small>

									<br>

									<img style="object-fit:contain;object-fit: contain; height:50px; margin-top:100px"
										src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/image-151.svg" />

									<br>

									<button onclick="window.location.href = '<?php echo home_url(); ?>/what-is-turbobid/' "
										class="btn btn-primary rounded-pill mt-3">Learn more</button>

								</div>

								<div class="col-md-6 p-0 p-md-2">
									<img style="width:100%; object-fit:contain"
										src="<?php echo home_url(); ?>/wp-content/uploads/2024/07/image-84-e1720214398702.png" />

								</div>

							</div>

						</div><!-- Tab content block close -->


						<div class="tab-pane fade" id="pills-KYCVerification" role="tabpanel"
							aria-labelledby="pills-KYCVerification-tab">

							<div
								class="col-md-12 p-0 d-flex flex-column flex-md-row align-items-center text-white pb-3">
								<div class="col-md-6 p-0 p-md-2">

									<span class="text-primary">How KYC Onboarding works</span>
									<h3>Powerful Document & Identity Verification for Streamlined Onboarding</h3>

									<span class="small">Private vehicle sellers will have to capture a photo of their
										government-issued
										identity document along with a simple selfie.They can do this using either a
										smartphone or a web
										browser.</span>


									<div
										class="bg-secondary text-white d-flex justify-content-start align-items-start align-items-md-center radiusx-20 p-3 mb-2">
										<span class="icon-number">1</span>
										<div>
											<h6>Take a photo of your identity document</h6>
											<span class="small">TurboBid guides you through the entire process with
												real-time feedback and
												automatically identifies the document type.This makes the process
												quicker and minimizes
												typing errors.</span>
										</div>
									</div>

									<div
										class="bg-secondary text-white d-flex justify-content-start align-items-start align-items-md-center radiusx-20 p-3 mb-2">
										<span class="icon-number">2</span>
										<div>
											<h6>Take a selfie!</h6>
											<span class="small">Take a simple selfie with clear lighting.</span>
										</div>
									</div>

									<div
										class="bg-secondary text-white d-flex justify-content-start align-items-start align-items-md-center radiusx-20 p-3 mb-2">
										<span class="icon-number">3</span>
										<div>
											<h6>Get a decision</h6>
											<span class="small">TurboBid guides you through the entire process with
												real-time feedback and
												automatically identifies the document type.This makes the process
												quicker and minimizes
												typing errors.</span>
										</div>
									</div>


								</div>

								<div class="col-md-6 p-0 p-md-2 text-center">
									<img class="ai-id-card"
										src="<?php echo home_url(); ?>/wp-content/uploads/2024/07/Group-1321315155.png" />

								</div>

							</div> <!-- col-12 close -->


						</div><!-- Tab content block close -->


					</div>

				</div>

			</div><!-- section content block close -->

		</div><!--  Block close -->




	</div><!-- Home Middle Block close -->


	<div class="innovation-section py-5">


		<?php echo do_shortcode('[elementor-template id="325708"]'); ?>


	</div>





	<div class="bottomSellWithUs p-2  text-center bg-primary">
		<span class="small text-white font-weight-bold text-mobile-9">Finance Any Used Car,Any Platform! Apply in just 5
			minutes. <a href="<?php echo home_url(); ?>/escrow/" class="text-white font-weight-bold">Get Started<a /></span>

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
				$('#decoded-vin-result').html('VIN');
			}, 10000);
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
	background-image: url('<?php echo get_template_directory_uri(); ?>/framework/images/banner-bg.svg');
	background-repeat: no-repeat;
	background-position-y: -10px;
	background-size: 2435px 1200px;
	z-index: 1;
	padding: 100px 50px;
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
		padding: 100px 10px;
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
		padding: 100px 20px;
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
</style>

<?php

        get_footer();

    }

}

?>