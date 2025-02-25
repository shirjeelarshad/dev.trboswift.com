<?php
   /*
   Template Name: [PAGE - Private seller]
   */



      get_header();

        ?>


<div class="main-home-body" style="background:#F8F9FA;">


	<div class="hero-banner overflow-hidden">
		<div class="container radiusx d-flex flex-column-reverse flex-md-column justify-content-start" style="background:#F4F4F4; min-height:calc(80vh - 92px);">

			<img class="heroBannerCar" style="object-fit:contain; z-index:1; max-width: 639px;"
				src="<?php echo home_url(); ?>/wp-content/uploads/2024/12/Group-1321316947.png" />

			<div class="d-flex flex-column flex-md-row align-items-start py-3 py-md-5">
				<div class="col-md-7 p-0">
					<div class="pt-2 headerMainTextStyle col-12">
						<span class="text-primary small">Buy a Vehicle anywhere in Canada.</span>
						<h1 class="font-weight-bold">Transport & Logistics</h1>
						<span class="text-dark">Canada's First Secure Platform for Escrow and Private Vehicle<br>Financing – Ensuring Safe, Reliable Transactions for Buyers and Sellers.</span>
					</div>

					<!-- Image  -->



				</div>

				<div class="col-md-5">
					<div class="bg-white radiusx my-3 px-3 py-4 z-index" style="height: 41rem;">
						<h3>Get a quote</h3>
						<span class="">Get effortless, secure transaction with Trbo Swift’s automated process-Canada’s premier platform for seamless transactions.</span>


					 <div class="formContainer mt-3">
						
        <div class="input-group pick-location" >
			<div class="input-group-prepend bg-white border-0">

				
				<i class="fas fa-map-marker-alt"></i>
			</div>
            <input  type="text" id="transportPickupLocation" class="forminator-input form-control bg-white" placeholder="Ship from (city, country, or ZIP)">
        </div>
        <div class="input-group destination-location ">
			<div class="input-group-prepend bg-white border-0">

			
				<i class="fas fa-map-marker-alt"></i>
			</div>
            <input  type="text" id="transportDropLocation"class="forminator-input form-control bg-white" placeholder="Ship to (city, country, or ZIP)">
        </div>
        <div class="input-group">
			<div class="input-group-prepend bg-white border-0">

				
				<i class="fas fa-calendar-alt"></i>
			</div>
            <input id="shipDate" type="date" class="form-control bg-white" placeholder="Select ship date">
        </div>
        <div class="input-group">
			<div class="input-group-prepend bg-white border-0">

				<i class="fas fa-truck"></i>
			</div>
            <input id="SelectVehicletype" type="text" placeholder="Select Vehicle type" class="form-control bg-white" readonly>
			<i class="fas fa-sort-down"></i>
        </div>

        <div class="vehicle-selection" id="vehicleSelection">
            <h4>Vehicle Selection</h4>

			<span>Vehicle Size</span>
            <div class="vehicle-size">
                <div data-description="Small" class="active">
                    <span></span>
                    Small
                </div>
                <div data-description="Medium">
                    <span></span>
                    Medium
                </div>
                <div data-description="Large">
                    <span></span>
                    Large
                </div>
                <div data-description="Extra Large">
                    <span></span>
                    X-L
                </div>
                <div data-description="Other">
                    <span></span>
                    Other
                </div>
            </div>

			<div class="">
           <input class="vehicle-type-description form-control" placeholder="Sedans, Compact SUV, Coupes & Hatchbacks"></input>
        </div>
            
        </div>

		
    </div>

	<input type="text" id="transportDeliveryFee" class="form-control border-0 bg-white" placeholder="" disabled>

	<div class="d-flex flex-row justify-content-center mt-1" style="gap:10px">
								<button type="button" class="btn btn-secondary rounded-pill px-5 py-3"
									id="get-quote-in-finance"><small>Quote</small></button>

							</div>

							</div>

	


				</div>
			</div>

		</div>

	</div> <!-- Home banner 12 block close -->

	<div class="bg-white">
		<div class="container py-5">

			<div class="d-flex justify-content-center flex-column align-items-center ">
				<small class="text-primary">Flatbed & enclosed trailer services available nationwide in Canada </small>
				<h2 class="text-dark">Shop on any vehicle, any marketplace</h2>


			</div>

			<div
				class="includedTrboSwiftCards col-12 align-items-center my-4 px-0">
				
					<div
						class="infoCardDesign">
						<div class="cardIcon">
							<div
								class="inner">
								<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/07/Vector.svg" width="40"
									height="50" viewBox="0 0 30 50" />
							</div>
						</div>
						<div>
							<span style="color:#fff">Tracking & Supportr</span><br>
							<small style="font-size:12px; color:#f3f3f3">Track the status of your vehicle from the Trbo Swift
								dashboard to receive updates and manage information directly. You can also view the
								assigned towing company.</small>
						</div>


					</div>
			
					<div
						class="infoCardDesign">
						<div class="cardIcon">
							<div
								class="inner">
								<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/12/Group-1321316615.png"
									width="30" height="30" viewBox="0 0 30 50" />
							</div>
						</div>
						<div>
							<span style="color:#fff">Fully insured</span><br>
							<small style="font-size:12px; color:#f3f3f3">All vehicle deliveries include comprehensive
								coverage, with additional options available for high-value vehicles.</small>
						</div>


					</div>
				
					<div
						class="infoCardDesign">
						<div class="cardIcon">
							<div
								class="inner">
								<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/07/Group-1321315125.svg"
									width="30" height="50" viewBox="0 0 30 50" />
							</div>
						</div>
						<div>
							<span style="color:#fff">Nationwide delivery network</span><br>
							<small style="font-size:12px; color:#f3f3f3">Trbo Swift collaborates with select transport
								companies throughout Canada to guarantee that vehicle delivery & transport are managed
								with efficiency.</small>
						</div>


					</div>
			



			</div>




		</div>


		<div class="text-center mt-3">

			<h2>Nationwide Coverage</h2>

		</div>

		<div class="container d-flex flex-column-reverse flex-md-row py-5">

			<div class="col-12 col-md-6 ">
				<img style="width:100%; object-fit:contain"
					src="<?php echo home_url(); ?>/wp-content/uploads/2024/12/Group-1321316948.png" />

			</div>

			<div class="col-12 col-md-6 ">
				<img style="width:100%; object-fit:contain"
					src="<?php echo home_url(); ?>/wp-content/uploads/2024/12/Group-1321316335.png" />

			</div>



		</div> <!-- Home banner 12 block close -->

	</div>



	<div class="position-relative py-5 my-5">

		<div class="d-flex justify-content-center">
			<div class="col-md-6 d-flex justify-content-center flex-column align-items-center ">
				<small class="text-primary">Transport</small>
				<h2 class="text-dark text-center">Get a Quote & Book Online</h2>
			</div>



		</div>

		<div class="bookOnlineSection container col-md-12 d-flex flex-column flex-md-row align-items-center">
			<img class="transport-car  position-absolute"
				src="<?php echo get_template_directory_uri(); ?>/framework/images/cartruck.svg" />

			<div class="col-md-6" style="z-index:11">


				<p><strong>Dependable, Consistent, and Comprehensive:</strong> We manage every aspect of the process
					from start to finish, allowing you to concentrate on buying and selling more cars. Enjoy
					competitive and transparent pricing through our nationwide network of trusted carriers.
					Additionally, use Trbo Swift Transport at checkout to unlock exclusive benefits.</p>

				<div class="bg-white border d-flex align-items-center px-3 py-2"
					style="border-radius:10px 20px 20px 10px; border-left:4px solid #124326!important;">
					<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/11/Group-1321316662.svg" width="48px"
						class="mr-2 img-fluid" />

					<span><strong>Effortless,
							Speedy, and Affordable</strong><br>Ship any vehicle, no matter where you purchase
						it.</span>


				</div>
				<button onclick="window.location.href = '<?php echo home_url(); ?>/what-is-turbobid/' "
					class="btn btn-secondary rounded-pill my-3">Learn more</button>
			</div>



		</div>
	</div>



	<div
		class="supportedVehicleSection bg-secondary col-12 d-flex flex-column flex-md-row align-items-center pl-md-5 pr-0  position-relative ">
		<div class="col-12 col-md-7 d-flex flex-column justify-content-between pl-md-5 ml-md-5">
			<div class="col-6 py-4">
				<div>
					<span class="text-white bg-primary small px-3 py-1 d-flex justify-content-center align-items-center text-uppercase"
						style="max-width:150px; border-radius:8px; border:1px solid #3B634C">Vehicle type</span>
				</div>
				<h4 class="text-white my-2 md-h1 ">All Types of Vehicles</h4>

				<span class="text-light">We provide flatbed and enclosed transport options through our trusted and insured partners.</span>


			</div>
			<div class="col-12 col-md-6 cardGridLayout my-4 px-0" style="gap:10px">
				
					<div
						class="smallOptionCard">
						<div
							style="width:50px; height:50px; background:#fff0; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
							<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/TurboBid_DD-8.svg" width="40"
								height="40" viewBox="0 0 40 40" />
						</div>
						<span style="font-size:14px; color:#fff">Sedan</span>

					</div>
				
					<div
						class="smallOptionCard">
						<div
							style="width:50px; height:50px; background:#fff0; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
							<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/TurboBid_DD-8.svg" width="40"
								height="40" viewBox="0 0 40 40" />
						</div>
						<span style="font-size:14px; color:#fff">
							Antique car</span>

					</div>
				
					<div
						class="smallOptionCard">
						<div
							style="width:50px; height:50px; background:#fff0; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
							<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/TurboBid_DD-8.svg" width="40"
								height="40" viewBox="0 0 40 40" />
						</div>
						<span style="font-size:14px; color:#fff">
							Luxury</span>

					</div>
				
					<div
						class="smallOptionCard">
						<div
							style="width:50px; height:50px; background:#fff0; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
							<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/TurboBid_DD-8.svg" width="40"
								height="40" viewBox="0 0 40 40" />
						</div>
						<span style="font-size:14px; color:#fff">
							Suv/Pickup</span>
						</span>

					</div>
				
					<div
						class="smallOptionCard">
						<div
							style="width:50px; height:50px; background:#fff0; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
							<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/TurboBid_DD-8.svg" width="40"
								height="40" viewBox="0 0 40 40" />
						</div>
						<span style="font-size:14px; color:#fff">
							Motorcycle</span>
						</span>

					</div>
				
					<div
						class="smallOptionCard">
						<div
							style="width:50px; height:50px; background:#fff0; border-radius:100%; display:flex; justify-content:center; align-items:center; margin-bottom:8px">
							<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/TurboBid_DD-8.svg" width="40"
								height="40" viewBox="0 0 40 40" />
						</div>
						<span style="font-size:14px; color:#fff">
							Electric</span>
						</span>

					
				</div>

			</div>
		</div>
		<div class="col-12 col-md-5 d-flex flex-column justify-content-between py-5 mt-md-0">
			<h4 class="text-white mb-2">How does it work?</h4>
			<div style="margin-left:10px">
				<div class="wrapper text-white">
					<ul class="StepProgress">
						<div class="StepProgress-item is-done">
							<span class="h5 mb-1">Book Transport</span><br><small>Transport any vehicle, regardless of
								where
								you purchase it.
								You can include transport in your financing or escrow order.</small>
						</div>
						<div class="StepProgress-item current">
							<span class="h5 mb-1">Transport Assigned</span><br><small>Trbo Swift will assign your
								vehicle's
								delivery to our trusted partners to ensure a safe and efficient transport.</small>
						</div>
						<div class="StepProgress-item">
							<span class="h5 mb-1">Vehicle Delivery</span><br><small>Monitor your delivery status
								directly from the Trbo Swift dashboard. We perform a Trbo Swift AI damage inspection at
								pickup to ensure safe transport.</small>
						</div>


					</ul>
				</div>
			</div>

		</div>


	</div>

	<!--  Block close -->



	<div class="bg-white py-5">
		<div class="container col-md-12 d-flex flex-column flex-md-row align-items-center py-3">
			<div class="col-md-6 px-0">
				<h2>TurboBid AI Damage Inspection for all vehicle deliveries</h2>
				<span>Ensure complete transparency in your transaction by sending and reviewing the Trbo Swift AI Condition Report. This report evaluates 81 vehicle components and identifies 19 types of damage, offering a comprehensive view of the vehicle’s condition. The buyer reviews the detailed report to guarantee a smooth and transparent process.</span>


				<br> <a href='<?php echo home_url(); ?>/what-is-turbobid/'
					class="btn btn-secondary rounded-pill mt-3 px-5">Learn
					more</a>

			</div>

			<div class="col-md-6 px-0 py-5 py-md-0">
				<img style="object-fit:contain;object-fit: contain; height: 300px; width: 100%;"
					src="<?php echo home_url(); ?>/wp-content/uploads/2024/07/image-128.png" />

			</div>

		</div>
	</div>








	<div class="container">

		<div class="d-flex justify-content-center flex-column align-items-center mt-3">


			<div class="col-12 col-md-6 text-center">
				<small class="text-primary">Frequently Asked Questions </small>
				<h2 class="text-dark">More Questions?</h2>
				<small class="text-dark">We are happy to answer them Click the button below to send the team a message.</small>
			</div>


		</div>


		<div class="facContainer mb-5">
		<?php echo do_shortcode('[elementor-template id="325466"]'); ?>
	</div>


	</div>


	<div class="bottomSellWithUs p-2  text-center bg-primary">
		<span class="small text-white font-weight-bold text-mobile-9">Finance Any Used Car,Any Platform! Apply in
			just 5
			minutes. <a href="<?php echo home_url(); ?>/escrow/" class="text-white font-weight-bold">Get
				Started<a /></span>

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

    <script>
        jQuery(document).ready(function ($) {
            // Toggle dropdown on click
            $('#SelectVehicletype').on('click', function () {
                $('#vehicleSelection').toggle();
            });

            // Select vehicle size and update description
            $('.vehicle-size div').on('click', function () {
                $('.vehicle-size div').removeClass('active');
                $(this).addClass('active');
                const description = $(this).data('description');
                // $('.vehicle-type-description').val(description);
            });

            // Update the SelectVehicletype input when clicking anywhere
            $(document).on('click', function (e) {
                if (!$(e.target).closest('#vehicleSelection, #SelectVehicletype').length) {
                    const selectedSize = $('.vehicle-size div.active').text();
                    const description = $('.vehicle-type-description').val();
                    if (selectedSize && description) {
                        $('#SelectVehicletype').val(`${selectedSize} - ${description}`);
                    }
                    $('#vehicleSelection').hide();
                }
            });

            // Log form data if all inputs are filled
            $('form .submitGetQuote').on('click', function () {
                const shipFrom = $('#shipFrom').val();
                const shipTo = $('#shipTo').val();
                const shipDate = $('#shipDate').val();
                const vehicleType = $('#SelectVehicletype').val();

                if (shipFrom && shipTo && shipDate && vehicleType) {
                    console.log({
                        ShipFrom: shipFrom,
                        ShipTo: shipTo,
                        ShipDate: shipDate,
                        VehicleType: vehicleType
                    });
                }
            });
        });
    </script>
	  <style>
		#vehicleSelection{
			position: absolute;
    		width: 95%;
		}
		#vehicleSelection::before{
			content: '';
			position: absolute;
			background: #F8F9FA;
			width: 50px;
			height: 50px;
			right: 43px;
			top: -25px;
			transform: rotate(44deg);
		}
        .formContainer {
            
            background-color: #fff;
			z-index: 111;
			
        }
       .formContainer .input-group {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }
        .input-group i {
            margin-right: 10px;
            color: #888;
        }
       .formContainer .input-group input {
            border: none;
            outline: none;
    		height: 50px;
        }

		 .formContainer .input-group input:focus{
			border: none !important;
		 }


        .vehicle-selection {
            display: none;
            background-color: #F8F9FA;
            border-radius: 5px;
            padding: 10px;
    margin-top: -11px;
            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
			
        }
        .vehicle-size {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
        }
        .vehicle-size div {
            text-align: center;
            cursor: pointer;
        }
        .vehicle-size div span {
            display: block;
            width: 20px;
            height: 20px;
            background-color: #d4af37;
            border-radius: 50%;
            margin: 0 auto 5px;
        }
        .vehicle-size div.active span {
            background-color: #000;
        }
        .vehicle-description {
            text-align: center;
            color: #888;
        }
    </style>


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
		top: -80px;
		right: 0px;
		z-index: 10;
		max-height: 420px;
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
	/* Ensure the pseudo-elements are positioned relative to this element */
}

.hero-banner::before {
	content: "";
	background-image: url(<?php echo home_url();
	?>/wp-content/uploads/2025/01/Vector-4.svg);
    position: absolute;
    top: 83px;
    right: -100px;
    width: 814px;
    height: 100%;
    object-fit: contain;
    background-repeat: no-repeat;
    z-index: 0;
    padding: 0px;
    transform: rotate(0deg);
}

.hero-banner::after {
	content: "";
	background-image: url('<?php echo home_url(); ?>/wp-content/uploads/2024/11/Vector2.png');
    position: absolute;
        bottom: -1193px;
    left: -79px;
    min-width: 2099px;
    height: 1469px;
    object-fit: contain;
    background-repeat: no-repeat;
    z-index: 0;
    padding: 0px;
    transform: rotate(354deg);
}

.supportedVehicleSection {
	overflow: hidden;
}

.supportedVehicleSection::before {
	content: '';
	    width: 67%;
    height: 197%;
    position: absolute;
    top: -373px;;
    left: -171px;
    background-color: #BF9B3E;
    transform: rotate(23deg);
}

.heroBannerCar {
	position: absolute;
	bottom: 0px;
	left: 0;
	    min-height: 550px;
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

	.supportedVehicleSection::before {

		width: 144%;
		height: 80%;
		position: absolute;
		top: -175px;
		left: -171px;
		background-color: #BF9B3E;
		transform: rotate(357deg);
	}

	.bookOnlineSection {
		padding-bottom: 208px;
	}

	.hero-banner::before {
		top: 412px;
        right: -85px;
        width: 455px;
        transform: rotate(-1deg);
	}

	.hero-banner::after {
		bottom: 63px;
		left: -272px;
		width: 422px;
		height: 461px;
	}


	.heroBannerCar {
		position: relative;
		margin-left: -50px;
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
		padding: 50px 10px;
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

	.carRight {
		position: absolute;
		right: -15px;
		top: 0px;
		max-width: 322px;
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
.StepProgress {
	position: relative;
	padding-left: 45px;
	list-style: none;
}

.StepProgress {
  position: relative;
  padding-left: 45px;
  list-style: none;
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
  width: 60%;
}
.StepProgress small{
	color:#222222;
}
/* SVG Icons for steps */
.StepProgress-item::before {
  content: '';
  position: absolute;
  top: 0;
  left: -50px;
    width: 35px;
    height: 35px; /* Set height for SVG */
  background-size: contain; /* Ensure SVG scales properly */
  background-repeat: no-repeat;
}

.StepProgress-item:first-child::before {
  background-image: url('<?php echo home_url(); ?>/wp-content/uploads/2025/01/Group-1321317073.svg');
}

.StepProgress-item:nth-child(2)::before {
  background-image: url('<?php echo home_url(); ?>/wp-content/uploads/2025/01/Group-1321317074.svg');
}

.StepProgress-item:nth-child(3)::before {
  background-image: url('<?php echo home_url(); ?>/wp-content/uploads/2025/01/Group-1321317075.svg');
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


.cardIcon .inner{
		width: 100%;
        height: 100%;
        background: #3B634C;
        border-radius: 100%;
        align-content: center;
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
	height:164.55px; width:184.68px; background:#487259; text-align: center; border-radius:5.25px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px;
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


.includedTrboSwiftCards {
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* 5 cards per row */
  grid-auto-rows: auto;
  gap: 1rem;
  position: relative;
  width: 100%;
}



.includedTrboSwiftCards::before {
 content: '';
 background: #3B634C; 
 width: 100%;
 height: 244px;
         position: absolute;
        top: 66px;
}



.infoCardDesign:nth-child(2)::before {
  background-image: url('<?php echo home_url(); ?>/wp-content/uploads/2025/01/Vector-2627-1.svg');
}
.infoCardDesign:nth-child(2)::before {
  content: '';
          position: absolute;
        left: -204px;
        bottom: 0;
        background-repeat: no-repeat;
        width: 100%;
        top: -11px;
        transform: rotate(4deg);
}

.infoCardDesign:nth-child(2)::after {
  background-image: url('<?php echo home_url(); ?>/wp-content/uploads/2025/01/Vector-2628.svg');
}
.infoCardDesign:nth-child(2)::after {
  content: '';
  position: absolute;
        left: 202px;
        bottom: 0;
        background-repeat: no-repeat;
        width: 100%;
        top: 46px;
        z-index: -1;
}


/* Card Design */
.infoCardDesign {
  /* background: #fff;
  box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px; */
  text-align: center;
  border-radius: 5px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 20px;
          height: 244px;
position: relative;
color:#fff;
        z-index: 0;
}

.infoCardDesign .cardIcon{
   	width: 85px;
    height: 85px;
    background: #ffffff;
    border-radius: 100%;
    margin-bottom: 8px;
    align-content: center;
    position: absolute;
    top: 50%;
    transform: translate(0%, -120%);
    border: 1px solid #3B634C;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 6px;
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

	.includedTrboSwiftCards::before {
 content: '';
 background: #3B634C; 
 width: 100%;
        height: 190px;
        position: absolute;
        top: 78px;
}

.infoCardDesign{
    text-align: center;
        border-radius: 5px;
        display: flex
;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px;
        height: 244px;
        position: relative;
        color: #fff;
        z-index: 0;

}

.infoCardDesign .cardIcon{
    width: 70px;
        height: 70px;
   background: #ffffff;
    border-radius: 100%;
    margin-bottom: 8px;
    align-content: center;
    position: absolute;
    top: 50%;
    transform: translate(0%, -120%);
    border: 1px solid #3B634C;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 6px;
}

.infoCardDesign div:nth-child(2){
	position: absolute;
    top: 50%;
    transform: translate(0%, -10%);
    width: 210px;
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
	    height: 240px; 
   /* width: 360px; */
    /* background: #fff; */
    text-align: center;
    border-radius: 1px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 10px 15px;
	color:#fff;
position: relative;

}

.infoCardDesign::before{
	content: '';
    background: #3B634C; 
    width: 100%;
            height: 176px;
        position: absolute;
        top: 81px;
}

.infoCardDesign .cardIcon{
    width: 60px;
        height: 60px;
 background: #ffffff;
    border-radius: 100%;
    margin-bottom: 8px;
    align-content: center;
    position: absolute;
    top: 50%;
    transform: translate(0%, -120%);
    border: 1px solid #3B634C;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 6px;
}

.infoCardDesign div:nth-child(2){
	position: absolute;
    top: 50%;
    transform: translate(0%, -10%);
    width: 210px;
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







</style>



<?php

        get_footer();


		?>