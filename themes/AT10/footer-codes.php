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
	footer('HTTP/1.0 403 Forbidden');
	exit;
}

global $CORE, $userdata, $CORE; ?>


<?php if (in_array(_ppt(array("comchat", "msg_enable")), array("1")) && !isset($GLOBALS['COMCHATSET'])) { ?>
	<script>
		var chat_appid = '<?php echo _ppt(array("comchat", "appid")); ?>';
		var chat_auth = '<?php echo _ppt(array("comchat", "authkey")); ?>';
		var chat_id = '<?php echo $userdata->ID; ?>';
		var chat_name = '<?php echo $CORE->USER("get_username", $userdata->ID); ?>';
		var chat_avatar = '<?php echo $CORE->USER("get_avatar", $userdata->ID); ?>';
		var chat_link = '<?php echo $CORE->USER("get_user_profile_link", $userdata->ID); ?>';
	</script>
	<script>
		(function () {
			var chat_css = document.createElement('link');
			chat_css.rel = 'stylesheet';
			chat_css.type = 'text/css';
			chat_css.href = 'https://fast.cometondemand.net/' + chat_appid + 'x_xchat.css';
			document.getElementsByTagName("head")[0].appendChild(chat_css);
			var chat_js = document.createElement('script');
			chat_js.type = 'text/javascript';
			chat_js.src = 'https://fast.cometondemand.net/' + chat_appid + 'x_xchat.js';
			var chat_script = document.getElementsByTagName('script')[0];
			chat_script.parentNode.insertBefore(chat_js, chat_script);
		})();
	</script>

<?php } ?>



<?php if (_ppt(array('design', 'loadinline')) == 0 && !is_admin() && (_ppt(array('gdpr', 'enable')) == 1)) { ?>

	<script>
		jQuery(document).ready(function () {


			jQuery(document).gdprCookieLaw({
				moreLinkHref: '<?php echo _ppt(array('links', 'privacy')); ?>',
				theme: 'theme-dark',
				desc: "<?php echo __("We use cookies to ensure that we give you the best experience on our website. By continuing to use our site, you accept our cookie policy.", "premiumpress"); ?>",
				moreLinkText: "<?php echo __("Privacy Policy", "premiumpress"); ?>",
				btnAcceptText: "<?php echo __("Accept", "premiumpress"); ?>",
				animationStatus: true,
				animationDuration: 500,
				animationName: 'fade-slide',
				cookName: 'cookielaw1',
				expire: 30,
			});

		});
	</script>

<?php } ?>

<?php if (_ppt(array('design', 'loadinline')) == 0 && !is_admin() && (_ppt(array('adultwarning', 'enable')) == 1)) { ?>
	<script>
		jQuery(document).ready(function () {
			jQuery(document).gdprCookieLaw({
				moreLinkHref: '<?php echo _ppt(array('links', 'terms')); ?>',
				theme: 'theme-1',
				desc: "<?php echo __("Adult content warning. By continuing to use our site, you accept you are over the age of 18", "premiumpress"); ?>",
				moreLinkText: "",
				btnAcceptText: "<?php echo __("Accept", "premiumpress"); ?>",
				animationStatus: true,
				animationDuration: 500,
				animationName: 'fade-slide',
				cookName: 'adultwarning1',
				expire: 30,
			});
		});
	</script>
<?php } ?>


<?php wp_footer(); ?>

<!-- Firebase SDK -->
<script src="https://www.gstatic.com/firebasejs/9.6.11/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.6.11/firebase-auth-compat.js"></script>


<!-- Add Firebase Config -->
<script>
	// Your web app's Firebase configuration
	const firebaseConfig = {
		apiKey: "AIzaSyBKCxgZmKJDjW7sChMLaTseyEAA5elEG-w",
		authDomain: "turbobid-5cbde.firebaseapp.com",
		projectId: "turbobid-5cbde",
		storageBucket: "turbobid-5cbde.appspot.com",
		messagingSenderId: "370175895214",
		appId: "1:370175895214:web:946ad189879698cf202f3f",
		measurementId: "G-2DMLQ2BTRK"
	};


	// Initialize Firebase App
	firebase.initializeApp(firebaseConfig);

	// Get Firebase Auth
	const auth = firebase.auth();

	firebase.auth().useDeviceLanguage(); // Optional, to use user's device language for OTP
	firebase.auth().setPersistence(firebase.auth.Auth.Persistence.SESSION); // Optional

	// Enable Firebase Auth debug logging
	firebase.auth().settings.logLevel = 'debug';
</script>


<?php echo $CORE->LAYOUT("load_js", array()); ?>
<?php

// CUSTOM JQUERY
if (strlen(get_option('custom_js')) > 10) {
	echo stripslashes(get_option('custom_js'));
}

// GOOGLE ANALYTICS
if (_ppt(array('analytics', 'enable')) == '1') {


	if (strlen(_ppt(array('analytics', 'uakeyv4'))) > 1) {

		ob_start();
		?>
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-KWQWRQLJCT"></script>
		<script>
			window.dataLayer = window.dataLayer || [];

			function gtag() {
				dataLayer.push(arguments);
			}
			gtag('js', new Date());
			gtag('config', '<?php echo stripslashes(_ppt(array('analytics', 'uakeyv4'))); ?>');
		</script>
		<?php
		echo ob_get_clean();
	} else {
		ob_start();
		?>
		<script>
			(function (i, s, o, g, r, a, m) {
				i['GoogleAnalyticsObject'] = r;
				i[r] = i[r] || function () {
					(i[r].q = i[r].q || []).push(arguments)
				}, i[r].l = 1 * new Date();
				a = s.createElement(o),
					m = s.getElementsByTagName(o)[0];
				a.async = 1;
				a.src = g;
				m.parentNode.insertBefore(a, m)
			})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
			ga('create', '<?php echo stripslashes(_ppt(array('analytics', 'uakey'))); ?>', 'auto');
			ga('send', 'pageview');
		</script>
		<?php
		echo ob_get_clean();
	}
}

?>
<?php if (_ppt(array('maps', 'enable')) == 1) { ?>
	<!--map-modal -->
	<div class="map-modal-wrap shadow hidepage" style="display:none;">
		<div class="map-modal-wrap-overlay"></div>
		<div class="map-modal-item">
			<div class="map-modal-container">
				<div class="map-modal">
					<div id="singleMap" data-latitude="54.2890174" data-longitude="-0.4024484"></div>
				</div>
				<div class="card-body">
					<h3><a href="#" class="text-dark">Title</a></h3>
					<div class="address text-muted small letter-spacing-1"></div>
					<div class="map-modal-close bg-primary text-center"><i class="fal fa-times">&nbsp;</i></div>
				</div>
			</div>
		</div>
	</div>


	<!--map-locationMap -->
	<div class="location-modal-wrap shadow hidepage" style="display:none;">
		<div class="location-modal-wrap-overlay"></div>
		<div class="location-modal-item">
			<div class="location-modal-container">
				<div class="location-modal">
					<div id="locationMap"></div>

					<?php /*
																																																																																	 <div class="position-absolute locationmapgeromapbox" style="top:10px; left:10px;" id="locationmapgeromapbox">
																																																																																	   <input type="text"   placeholder="<?php echo __("Enter country, city or zipcode.","premiumpress"); ?>"
																																																																																			   id="location-setaddress" class="form-control" style="margin-right:50px;">
																																																																																			   <span id="searchlocationbit" style="top: 10px; right: 10px; position: absolute;    z-index: 100;"> <i
																																																																																					   class="fa fa-search " style="cursor:pointer;"></i> </span>
																																																																																		   </div>

																																																																																		   <input type="hidden" id="location-mylog"
																																																																																			   value="<?php if(isset($_SESSION['mylocation'])){ echo $_SESSION['mylocation']['log']; }else{ echo "-60.1"; } ?>" />
																																																																																		   <input type="hidden" id="location-mylat"
																																																																																			   value="<?php if(isset($_SESSION['mylocation'])){ echo $_SESSION['mylocation']['lat']; }else{ echo "30.7"; }  ?>" />
																																																																																		   <input type="hidden" id="location-country"
																																																																																			   value="<?php if(isset($_SESSION['mylocation'])){ echo $_SESSION['mylocation']['country']; } ?>" />
																																																																																		   <input type="hidden" id="location-address"
																																																																																			   value="<?php if(isset($_SESSION['mylocation'])){ echo $_SESSION['mylocation']['address']; } ?>" />
																																																																																		   <input type="hidden" id="location-zip"
																																																																																			   value="<?php if(isset($_SESSION['mylocation'])){ echo $_SESSION['mylocation']['zip']; } ?>" />

																																																																																		   */ ?>

				</div>

				<div class="card-body">
					<h3><?php echo __("Where are you now?", "premiumpress"); ?></h3>
					<div class="address text-muted small letter-spacing-1" id="location-address-display">
						<?php if (isset($_SESSION['mylocation'])) {
							echo $_SESSION['mylocation']['address'];
						} ?>
					</div>
					<div class="location-modal-close bg-primary text-center"><i class="fal fa-times">&nbsp;</i></div>
				</div>

			</div>
		</div>
	</div>
	<!--map-modal end -->

<?php //_ppt_template( 'ajax-modal-location' );  
?>
<?php } ?>
<!--payment modal -->
<div class="payment-modal-wrap shadow hidepage" style="display:none;">
	<div class="payment-modal-wrap-overlay"></div>
	<div class="payment-modal-item">
		<div class="payment-modal-container">
			<div id="ajax-payment-form"></div>
			<div class="card-body">
				<h3 class="<?php echo $CORE->GEO("price_formatting", array()); ?>">0</h3>
				<div class="payment-modal-close bg-primary text-center"><i class="fal fa-times">&nbsp;</i></div>
			</div>
		</div>
	</div>
</div>
<!--login modal -->
<div class="login-modal-wrap shadow hidepage" style="display:none;">
	<div class="login-modal-wrap-overlay"></div>
	<div class="login-modal-item">
		<div class="login-modal-container">
			<div>
				<div id="ajax-login-form"></div>
				<div class="login-modal-close text-center"><i class="fal fa-times">&nbsp;</i></div>
			</div>
		</div>
	</div>
</div>
<!--msg model -->
<div class="msg-modal-wrap shadow hidepage" style="display:none;">
	<div class="msg-modal-wrap-overlay"></div>
	<div class="msg-modal-item">
		<div class="msg-modal-container">
			<div class="card-body p-0">
				<div id="ajax-msg-form"></div>
				<div class="msg-modal-close text-center"><i class="fa fa-times">&nbsp;</i></div>
			</div>
		</div>
	</div>
</div>

<!--msg model -->
<div class="upgrade-modal-wrap shadow hidepage" style="display:none;">
	<div class="upgrade-modal-wrap-overlay"></div>
	<div class="upgrade-modal-item">
		<div class="upgrade-modal-container">
			<div class="card-body p-0">
				<div id="ajax-upgrade-form"></div>
				<div class="upgrade-modal-close text-center"><i class="fa fa-times">&nbsp;</i></div>
			</div>
		</div>
	</div>
</div>





<?php if (!isset($GLOBALS['NOFOOTERSTYLES'])) { ?>
	<noscript id="deferred-styles">

		<?php if (isset($GLOBALS['footer-css']) && is_array($GLOBALS['footer-css'])) {
			foreach ($GLOBALS['footer-css'] as $k => $path) { ?>
				<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>?v=<?php echo THEME_VERSION; ?>" <?php if (in_array($k, array("bootstrap", "_fonts", "_fontawesome", "_responsive", "_plugins", "cart"))) { ?>rel="preload" <?php } ?> />
			<?php }
		} ?>

		<?php if (isset($GLOBALS['footer-css-extra']) && is_array($GLOBALS['footer-css-extra'])) {
			foreach ($GLOBALS['footer-css-extra'] as $k => $path) { ?>
				<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>?v=<?php echo THEME_VERSION; ?>" />
			<?php }
		} ?>


		<style>
			<?php echo $CORE->LAYOUT("load_css", array());
			?>
		</style>


	</noscript>
	<script>
		var loadDeferredStyles = function () {
			var addStylesNode = document.getElementById("deferred-styles");
			var replacement = document.createElement("div");
			replacement.innerHTML = addStylesNode.textContent;
			document.body.appendChild(replacement)
			addStylesNode.parentElement.removeChild(addStylesNode);
		};
		var raf = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
			window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
		if (raf) raf(function () {
			window.setTimeout(loadDeferredStyles, 0);
		});
		else window.addEventListener('load', loadDeferredStyles);
	</script>
<?php } ?>

<script>
	var ajax_site_url = "<?php echo $CORE->_ppt_home_url(); ?>/index.php";
	var ajax_framework_url = "<?php echo get_template_directory_uri(); ?>/";
	var ajax_googlemaps_key = "<?php echo trim(_ppt(array('maps', 'apikey'))); ?>";


	<?php if ($CORE->GEO("is_right_to_left", array())) { ?>
		jQuery(document).ready(function () {

			jQuery("html[lang=ar]").attr("dir", "rtl").find("body").addClass("rtl right-to-left");

		});
	<?php } ?>

	jQuery(window).on('load', function () {

		setTimeout(
			function () {

				jQuery("#wrapper").addClass('d-flex').removeClass('hidepage').addClass('preload-hide');

				jQuery("#sidebar-wrapper").css('display', '');

				jQuery('#page-loading').html('').hide();

				jQuery(".hidepage").each(function () {
					jQuery(this).removeAttr("style").removeClass('hidepage').addClass('preload-hide');
				});


				jQuery(".gdpr-cookie-law").css("display", "block");

				tinyScroll();

				// Trigger window resize event to fix resize size issues.
				// Don't use jquery trigger event since that only triggers
				// methods hooked to events, and not the events themselves.
				if (typeof (Event) === 'function') {
					window.dispatchEvent(new Event('resize'));
				} else {
					var event = window.document.createEvent('UIEvents');
					event.initUIEvent('resize', true, false, window, 0);
					window.dispatchEvent(event);
				}



				<?php if ((!$CORE->isMobileDevice() && defined('THEME_KEY') && !in_array(THEME_KEY, array("dt", "sp", "cm", "ct", "vt", "rt", "so", "jb", "cp", "ph", "es"))) && $userdata->ID && in_array(_ppt(array('user', 'friends')), array("", "1")) && _ppt(array("comchat", "msg_enable")) != 1 && $CORE->USER("get_subscribers_followers_count", $userdata->ID) > 0) {

					// COUNT ONLINE USERS
					$gg = $CORE->USER("get_subscribers_followers", $userdata->ID);


					?>


					jQuery("#ppt_livechat_window").pptChat({
						cookie: false,
						sound: false,
						changeBrowserTitle: false,

						accountLink: "<?php echo _ppt(array('links', 'myaccount')); ?>/?showtab=messages",
						accountText: "<?php echo __("My Message", "premiumpress"); ?>",

						button: {
							speechBubble: "<?php echo __("My Friends", "premiumpress"); ?>",
							src: '<i class="fal fa-comment"></i>',
							notificationNumber: '<?php echo count($gg); ?>',
						},
						popup: {

							outsideClickClosePopup: false,

							persons: [

								<?php if (count($gg) > 0) {
									foreach ($gg as $p) { ?> {
											avatar: {
												src: "<?php echo $CORE->USER("get_avatar", $p); ?>",
											},
											text: {
												title: "<?php echo $CORE->USER("get_username", $p); ?>",
												description: "",
												status: false,
												count: <?php if ($CORE->USER("get_online_status", $p)) {
													echo 1;
												} else {
													echo 0;
												} ?>,
											},

											link: {
												desktop: "<?php echo $p; ?>"
											},
											day: {
												sunday: '00:00-23:59',
												monday: '00:00-23:59',
												tuesday: '00:00-23:59',
												wednesday: '00:00-23:59',
												thursday: '00:00-23:59',
												friday: '00:00-23:59',
												saturday: '00:00-23:59'
											}
										},
									<?php }
								} ?>
							]
						},
					});

				<?php } ?>


			}, 1000);

	});










	jQuery(document).ready(function ($) {
		let autocompletePickup, autocompleteDestination;

		function initializeAutocomplete(inputElement, callback) {
			if (!inputElement) return;

			let options = {
				componentRestrictions: { country: "CA" },
				fields: ["address_components", "formatted_address"]
			};

			let autocomplete = new google.maps.places.Autocomplete(inputElement, options);
			google.maps.event.addListener(autocomplete, 'place_changed', function () {
				let place = autocomplete.getPlace();
				inputElement.value = place.formatted_address;
				if (callback) callback(place.formatted_address);
			});
		}

		function setupAutocompleteForSelectors(selectors) {
			selectors.forEach(selector => {
				$(selector).each(function () {
					initializeAutocomplete(this);
				}).on('click', function () {
					initializeAutocomplete(this);
				});
			});
		}

		function initialize() {
			setupAutocompleteForSelectors([
				'.googleAutoLocation',
				'.location-populate input',
				'.credit-google-address input[name="address-1-street_address"]',
				'.credit-google-address input[name="address-2-street_address"]'
			]);

			autocompletePickup = document.querySelector('#pickupAddress .location1') ||
				document.querySelector('.pick-location .forminator-input');
			autocompleteDestination = document.querySelector('#dropOffAddress .location2') ||
				document.querySelector('.destination-location .forminator-input');

			initializeAutocomplete(autocompletePickup);
			initializeAutocomplete(autocompleteDestination);
		}

		function updatePickupnMap() {

			let mapContainer = $('.financeMapContainer');
			mapContainer.html(`<div class="transportLocationStatus">
			<div class="position-relative">
			<div class="finance_map_container" style="width: 100%; min-height: 361px;"> </div>
			<div class="transportDetailsInMap"> </div>
			</div>
			<div id="transportDetails"> </div>
			</div>`);

			if (mapContainer.length > 0) {
				setTimeout(function () {
					let pickupLocation = $('.pick-location .forminator-input').val().trim();
					if (pickupLocation) {
						initializeCustomLocationMap({
							currentGoogleLocation: pickupLocation || null,
							currentAddressCanChange: false,
							mapContainer: '.finance_map_container',
						});
					}
				}, 1000);

			}
		}

		function updateDestinationMap() {


			let mapContainer = $('.financeMapContainer');
			mapContainer.html(`
		<div class="transportLocationStatus">
			<div class="position-relative">
				<div class="finance_map_container" style="width: 100%; min-height: 361px;"></div>
				<div class="transportDetailsInMap"></div>
			</div>
			<div id="transportDetails"></div>
		</div>
	`);

			if (mapContainer.length > 0) {
				setTimeout(function () {
					let pickupLocation = $('.pick-location .forminator-input').val().trim();
					let destinationLocation = $('.destination-location .forminator-input').val().trim();
					if (pickupLocation && destinationLocation) {
						initializeCustomLocationMap({
							pickupLocation,
							destinationLocation,
							currentGoogleLocation: null,
							currentAddressCanChange: false,
							mapContainer: '.financeMapContainer .finance_map_container',
						});

						let transportDetailsInMap = `
					<div class="d-flex align-items-center justify-content-between bg-white p-2 mb-2" style="border-radius: 0 0 15px 15px; box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
						<div class="d-flex align-items-center justify-content-between col-12" style="gap:15px;">
							<div class="col d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
								<div class="d-flex align-items-center mr-2">
									<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/dfghjkl.svg" style="width:30px" />
									<div class="ml-2">
										<div class="font-weight-bold font-12 text-dark opasity-">${pickupLocation}</div>
										<div class="font-10 text-muted">Pickup Location</div>
									</div>
								</div>
							</div>
							<div class="col d-flex align-items-center justify-content-end radiusx bg-white p-2 mb-2">
								<div class="d-flex align-items-center mr-2">
									<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/Group.svg" style="width:30px" />
									<div class="ml-2">
										<div class="font-weight-bold font-12 text-dark opasity-">${destinationLocation}</div>
										<div class="font-10 text-muted">Destination</div>
									</div>
								</div>
							</div>
						</div>
					</div>`;

						jQuery('.transportDetailsInMap').html(transportDetailsInMap);

						let data = `
					<div class="pb-2" style="border-bottom:1px dashed rgba(0, 0, 0, 0.88); margin-bottom:15px;">
						<div class="d-flex align-items-center justify-content-between">
							<div>
								<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/56789.svg" style="width:30px" /> ##
							</div>
							<div class="d-flex align-items-center dropdown" style="gap:10px">
							</div>
						</div>
						<span class="font-12 text-dark">${$('input[name="text-14"]').val()}</span><br>
						<span class="font-12 text-dark">VIN: ${$('input[name="text-13"]').val()}</span>
					</div>

					<div class="col-12 d-flex flex-column flex-md-row font-12 p-0 mb-3">
						<div class="row flex-column mx-0 mb-2 mr-md-3">
							<div class="text-muted">Sender</div>
							<div class="font-weight-bold text-dark">${$('input[name="name-4"]').val()} ${$('input[name="name-6"]').val()}</div>
						</div>
						<div class="row flex-column mx-0 mb-2 mr-md-3">
							<div class="text-muted">Receiver</div>
							<div class="font-weight-bold text-dark">${$('input[name="name-1"]').val()} ${$('input[name="name-2"]').val()}</div>
						</div>
						<div class="row flex-column mx-0 mb-2 mr-md-3">
							<div class="text-muted">Fee</div>
							<div class="font-weight-bold text-dark show-calculated-price"></div>
						</div>
						<div class="row flex-column mx-0 mb-2 mr-md-3">
							<div class="text-muted">Status</div>
							<div class="font-weight-bold text-dark">Quote</div>
						</div>
						<div class="row flex-column mx-0 mb-2 mr-md-3">
							<div class="text-muted">Referral</div>
							<div class="font-weight-bold text-dark">TrboSwift escrow</div>
						</div>
					</div>
				`;

						data += `
					<div class="d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
						<div class="d-flex align-items-center">
							<div>
								<div class="font-10 text-muted">Buyer</div>
								<div class="font-weight-bold font-12 ">${$('input[name="name-1"]').val()}</div>
								<div class="text-muted font-12 ">${$('input[name="name-2"]').val()}</div>
							</div>
						</div>
						<div class="d-flex" style="gap:10px;">
							<a type="button" class="btn" href="mailto:${$('input[name="email-1"]').val()}">
								<i class="fal fa-envelope"></i>
							</a>
							<a type="button" class="btn" href="tel:${$('input[name="phone-1"]').val()}">
								<i class="fal fa-phone-alt"></i>
							</a>
						</div>
					</div>

					<div class="d-flex align-items-center justify-content-between radiusx bg-white p-2 mb-2">
						<div class="d-flex align-items-center">
							<div>
								<div class="font-10 text-muted">Seller</div>
								<div class="font-weight-bold font-12 ">${$('input[name="name-4"]').val()}</div>
								<div class="text-muted font-12 ">${$('input[name="name-6"]').val()}</div>
							</div>
						</div>
						<div class="d-flex" style="gap:10px;">
							<a type="button" class="btn" href="mailto:${$('input[name="email-2"]').val()}">
								<i class="fal fa-envelope"></i>
							</a>
							<a type="button" class="btn" href="tel:${$('input[name="phone-7"]').val()}">
								<i class="fal fa-phone-alt"></i>
							</a>
						</div>
					</div>`;

						jQuery('.transportLocationStatus').addClass('d-flex flex-column flex-md-row');
						jQuery('#transportDetails').addClass('col-12 col-md-6').html(data);
						calculateDistance(pickupLocation, destinationLocation);
					}
				}, 1000);
			}
		}





		$('.pickup-location .forminator-input').on('change', updatePickupnMap);
		$('.destination-location .forminator-input').on('change', updateDestinationMap);

		$('.generate-ship-price, .getDealTransportCost, #get-quote-in-finance').click(function () {
			let pickupLocation = $('.pick-location .forminator-input').val();
			let destinationLocation = $('.destination-location .forminator-input').val();
			if (pickupLocation && destinationLocation) {
				calculateDistance(pickupLocation, destinationLocation);
			} else {
				alert('Please enter both pickup and destination locations.');
			}
		});

		window.addEventListener('load', initialize);


		$(".getting-ship-btns").addClass('d-flex align-items-end').html(
			'<div class="row m-0"><span class="generate-ship-price btn btn-primary rounded-pill mr-3 text-small" style="font-size: 12px;">Get Quote</span><span class="add-prices-to-shipping btn btn-primary rounded-pill" style="font-size: 12px;">Add to Escrow Order</span></div>'
		);

		$(".getting-quote-btns").addClass('d-flex align-items-end').html(
			'<div class="row m-0"><span id="get-quote-in-finance" class="forminator-button btn btn-secondary rounded-pill d-flex align-items-center px-5" style="font-size: 12px;">Get Quote</span></div>'
		);


		setTimeout(function () {
			let mapContainer = $('.financeMapContainer');
			if (mapContainer.length > 0) {

				mapContainer.html(`<div class="transportLocationStatus">
			<div class="position-relative">
			<div class="finance_map_container" style="width: 100%; min-height: 361px;"> </div>
			<div class="transportDetailsInMap"> </div>
			</div>
			<div id="transportDetails"> </div>
			</div>`);


				initializeCustomLocationMap({
					currentGoogleLocation: null,
					currentAddressCanChange: true,
					mapContainer: '.finance_map_container',
					inputField: '.pick-location .forminator-input'
				});
			}
		}, 2000);



		$('.generate-ship-price').click(function () {
			var pickupLocation = $('.pick-location .forminator-input').val();
			var destinationLocation = $('.destination-location .forminator-input').val();

			if (pickupLocation && destinationLocation) {
				calculateDistance(pickupLocation, destinationLocation);
			} else {
				alert('Please enter both pickup and destination locations.');
			}
		});

		$('.getDealTransportCost').click(function () {
			var pickupLocation = $('#pickupAddress.location1').val();
			var destinationLocation = $('#dropOffAddress.location2').val();

			if (pickupLocation && destinationLocation) {
				calculateDistance(pickupLocation, destinationLocation);
			} else {
				alert('Please enter both pickup and destination locations.');
			}
		});



		$('#get-quote-in-finance').click(function () {
			var pickupLocation = $('.pick-location .forminator-input').val();
			var destinationLocation = $('.destination-location .forminator-input').val();

			if (pickupLocation && destinationLocation) {
				calculateDistance(pickupLocation, destinationLocation);
			} else {
				alert('Please enter both pickup and destination locations.');
			}
		});






		function calculateDistance(pickup, destination) {

			var service = new google.maps.DistanceMatrixService();
			if (pickup && destination && service) {
				service.getDistanceMatrix({
					origins: [pickup],
					destinations: [destination],
					travelMode: 'DRIVING',
					unitSystem: google.maps.UnitSystem.METRIC,
				}, function (response, status) {
					if (status !== 'OK') {
						alert('Error was: ' + status);
					} else {
						var distance = response.rows[0].elements[0].distance
							.value; // distance in meters
						calculatedPrice = (distance / 1000) * 4; // distance in km * 4

						if ($('.transport-delivery-amount input').length > 0) {
							// Display calculated price
							$('.transport-delivery-amount input').val(formatCalCadPrice(
								calculatedPrice));
						}

						if ($('#transportDistance').length > 0) {
							// Display calculated price
							$('#transportDistance').val(distance);
						}




						// Only proceed if the price is calculated properly
						if (calculatedPrice) {
							calculateDistancePrice(); // Call only after calculatedPrice is set
						} else {
							alert('Error calculating price. Please try again.');
						}

					}
				});
			}
		}

		// Calculate the price and update the shipping cost field
		function calculateDistancePrice() {
			if (calculatedPrice) {
				if ($('.total-shipping-cost input').length > 0) {
					$('.total-shipping-cost input').val(calculatedPrice);
				}

				if ($('.show-calculated-price').length > 0) {
					$('.show-calculated-price').html('<strong>CA' + formatCalCadPrice(calculatedPrice) +
						'</strong>');
				}

				if ($('.trans-shipping-methods select').length > 0) {
					const shippingMethodsSelect = $('.trans-shipping-methods select');
					shippingMethodsSelect.find('option').each(function () {
						if ($(this).val() === 'Trbo Swift Transport') {
							shippingMethodsSelect.val($(this).val()).trigger('change');
							return false; // Exit the loop once matched
						}
					});
				}



				if ($('.buyer-seller-fee-covering-1 select').length > 0) {

					handleFeeChange(); // Make sure this doesn't reset the value unexpectedly
				}
			} else {
				alert('Please calculate the price first by clicking "See Prices".');
			}
		}

		// Ensure this button action happens after price calculation
		$('.add-prices-to-shipping').click(function () {
			if (calculatedPrice) {
				calculateDistancePrice();
			} else {
				alert('Please calculate the price first by clicking "See Prices".');
			}
		});



		const customSelectList = jQuery('[custom-select]');

		const vehicleDetailsQuoteInput = customSelectList.find('#qute-vehicle-details');

		$('input[type="radio"][name="vehicle-small"], input[type="radio"][name="vehicle-shape"]').on(
			'change',
			function () {
				// Get the selected vehicle type from the radio button
				var vehicleType = $(this).val();

				// Update the vehicleDetailsQuoteInput with the selected vehicle type
				vehicleDetailsQuoteInput.val(vehicleType);
				console.log(vehicleType);

				if (vehicleType === 'Small') {
					var vehicleCount = $('.get-qute-form').find('#small-vehicle-value').val();

					if (vehicleCount > 0) {
						var rate = parseFloat(vehicleCount * 9);
					} else {
						var rate = parseFloat(1 * 9);
					}

				} else {
					var vehicleCount = $('.get-qute-form').find('#medium-vehicle-value').val();
					if (vehicleCount > 0) {
						var rate = parseFloat(vehicleCount * 10);
					} else {
						var rate = parseFloat(1 * 10);
					}

				}

				// Pickup and destination locations
				var pickupLocation = $('.pick-location .forminator-input').val();
				var destinationLocation = $('.destination-location .forminator-input').val();

				if (pickupLocation && destinationLocation) {
					calculateShippingDistance(rate, pickupLocation, destinationLocation);
				} else {
					alert('Please enter both pickup and destination locations.');
				}
			});



		function calculateShippingDistance(rate, pickup, destination) {
			const perKilometer = rate || 4;
			var service = new google.maps.DistanceMatrixService();
			service.getDistanceMatrix({
				origins: [pickup],
				destinations: [destination],
				travelMode: 'DRIVING',
				unitSystem: google.maps.UnitSystem.METRIC,
			}, function (response, status) {
				if (status !== 'OK') {
					alert('Error was: ' + status);
				} else {
					var distance = response.rows[0].elements[0].distance
						.value; // distance in meters

					if (distance) {
						calculatedPrice = (distance / 1000) *
							perKilometer; // distance in km * 4
						// console.log('Pickup and destination locations ship price:',  shipPrice);

						jQuery('.documentManagementBody #documentManageTitle').html(
							'Shipping Quote');
						jQuery('.documentManagementBody .sendDocumentSection').removeClass(
							'd-block')
							.addClass(
								'd-none');
						jQuery('.documentManagementBody .documentViewSection').removeClass(
							'd-none')
							.addClass(
								'd-block');


						jQuery('.documentManagementBody .documentViewSection').html(
							'<h5>Price: ' +
							formatCalCadPrice(calculatedPrice) + '</h5>');
						jQuery('.documentManagementBody').removeClass('d-none').addClass(
							'd-flex');
					} else {
						alert(
							'No distance found between the pickup and destination locations.');
					}

				}
			});
		}






		function handleFeeChange() {
			const buyer_fee = $('.buyer-seller-fee-covering-1 select').val();
			const seller_fee = $('.buyer-seller-fee-covering-2 select').val();
			console.log(buyer_fee + " " + seller_fee);
			if (buyer_fee === "Buyer 100%") {
				$('.buyer-shipping-fee input').val(calculatedPrice.toFixed(2) * 1);
				$('.seller-shipping-fee input').val(calculatedPrice.toFixed(2) * 0);
			} else if (seller_fee === "Seller 100%") {
				$('.buyer-shipping-fee input').val(calculatedPrice.toFixed(2) * 0);
				$('.seller-shipping-fee input').val(calculatedPrice.toFixed(2) * 1);
			} else {
				$('.buyer-shipping-fee input').val(calculatedPrice.toFixed(2) * 0.5);
				$('.seller-shipping-fee input').val(calculatedPrice.toFixed(2) * 0.5);
			}

			buyerSellerSummary();

		}


		function formatCalCadPrice(value) {
			let number = parseFloat(value);
			if (isNaN(number)) return value;
			return '$' + number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
		}





		function formatedOdometer(value) {
			let number = parseFloat(value);
			if (isNaN(number)) return value;

			// Convert the number to a string with comma as thousand separator
			let numberStr = number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');

			// Return the formatted number
			return numberStr;
		}

		$('.odometer-field .forminator-field .forminator-input').each(function () {
			let value = $(this).val();
			let formattedValue = formatedOdometer(value);
			$(this).val(formattedValue);
		});
		$('#escrowOdometer').each(function () {
			let value = $(this).val();
			let formattedValue = formatedOdometer(value);
			$(this).val(formattedValue);
		});

		// Apply formatting when value changes
		$('.odometer-field .forminator-field .forminator-input').on('change', function () {

			let value = $(this).val();
			let formattedValue = formatedOdometer(value);
			$(this).val(formattedValue);
		});

		// Apply formatting when value changes
		$('.selling-page-mileage .forminator-field .forminator-input').on('change', function () {

			let value = $(this).val();
			let formattedValue = formatedOdometer(value);
			$(this).val(formattedValue);
		});



	});


	// Function to get query parameters
	function getQueryParameter(name) {
		const urlParams = new URLSearchParams(window.location.search);
		return urlParams.get(name);
	}




	// Calculate buyer and seller summary
	function buyerSellerSummary() {
		var lienProtection = parseFloat(jQuery('.lien-protection input[type="checkbox"]:checked').data(
			'calculation')) || 0;
		var pricePurchase = parseFloat(jQuery('.transaction-price input').val()) || 0;
		var pricePurchaseEscrowFee = parseFloat(jQuery('.transaction-fee input').val()) || 0;
		var buyerEscrowFee = parseFloat(jQuery('.buyer-escrow-fee input').val()) || 0;
		var sellerEscrowFee = parseFloat(jQuery('.seller-escrow-fee input').val()) || 0;
		var buyerShippingFee = parseFloat(jQuery('.buyer-shipping-fee input').val()) || 0;
		var sellerShippingFee = parseFloat(jQuery('.seller-shipping-fee input').val()) || 0;

		// Calculate total buyer price and seller proceeds
		var buyerTotalPrice = pricePurchase + buyerEscrowFee + buyerShippingFee;
		var sellerProceeds = pricePurchase - (sellerEscrowFee + sellerShippingFee + lienProtection);

		// Update buyer and seller input fields
		jQuery('.buyer-total-price input').val(buyerTotalPrice);
		jQuery('.seller-proceeds-price input').val(sellerProceeds);


		var vinSelectYear = jQuery('.vin-select-year select').val();
		var vinSelectMake = jQuery('.vin-select-make select').val();
		var vinInputModel = jQuery('.vin-input-model input').val();

		const buyer_fee = jQuery('.buyer-seller-fee-covering-1 select').val();
		const seller_fee = jQuery('.buyer-seller-fee-covering-2 select').val();
		const shippingMethodsSelect = jQuery('.trans-shipping-methods select').val();





		var transactionSummary = `<div style="font-size:14px">
<div class="d-flex justify-content-between">${vinSelectYear} ${vinSelectMake} ${vinInputModel}</div>
<div class="d-flex justify-content-between">Price <span class="font-weight-bold">${formatCalCadPrice(pricePurchase)}</span></div>
<div class="d-flex justify-content-between">Escrow Fee <span class="font-weight-bold">${formatCalCadPrice(pricePurchaseEscrowFee)}</span></div>
<div class="d-flex justify-content-between">Trbo Swift Fee paid by <span class="font-weight-bold"> ${buyer_fee || ""} ${seller_fee || ""}</span></div>
<div class="d-flex justify-content-between"><span class="text">Shipping Option</span> <span class="font-weight-bold seller-fee">${shippingMethodsSelect}</span></div>
</div>`;

		// Display buyer and seller summary
		var buyerSummary = `
			<div style="font-size:14px">
				<div class="pb-3">
					<div class="d-flex justify-content-between">Buyer Price:<span class="cad-price-format">${formatCalCadPrice(pricePurchase)}</span></div>
					<div class="d-flex justify-content-between">Trbo Swift fee paid by: <div><span class="text-primary">Buyer</span> <span class="cad-price-format">${formatCalCadPrice(buyerEscrowFee)}</span></div></div>
					<div class="d-flex justify-content-between">Shipping fee paid by: <div class="buyer-escrow-fee"><span class="text-primary">Buyer</span> <span class="buyer-fee-cal">${formatCalCadPrice(buyerShippingFee)}</span></div></div>
					<div class="d-flex justify-content-between">Total to be paid by Buyer:<span class="cad-price-format">${formatCalCadPrice(buyerTotalPrice)}</span></div>
				</div>
			</div>`;

		var sellerSummary = `
			<div style="font-size:14px">
				<div class="pt-3">
					<div class="d-flex justify-content-between">Lien Holder Pay Off Fee<span class="cad-price-format">${formatCalCadPrice(lienProtection) || 0}</span></div>
					<div class="d-flex justify-content-between">Trbo Swift fee paid by: <div><span class="text-primary">Seller</span> <span class="cad-price-format">${formatCalCadPrice(sellerEscrowFee)}</span></div></div>
					<div class="d-flex justify-content-between">Shipping fee paid by: <div class="seller-escrow-fee"><span class="text-primary">Seller</span> <span class="seller-fee-cal">${formatCalCadPrice(sellerShippingFee)}</span></div></div>
					<div class="d-flex justify-content-between">Seller Proceeds:<span class="cad-price-format">${formatCalCadPrice(sellerProceeds)}</span></div>
				</div>
			</div>`;

		jQuery('.transaction-details-summary').html(transactionSummary);

		jQuery('.buyer-transaction-summary').html(buyerSummary);
		jQuery('.seller-transaction-summary').html(sellerSummary);
	}

	// Utility function to format price
	function formatCalCadPrice(value) {
		let number = parseFloat(value);
		if (isNaN(number)) return value;
		return '$' + number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
	}
</script>


<!-- For escrow page -->





<!-- End Escrow page function -->

<script>
	jQuery(document).ready(function ($) {
		// Insert the dropdown dynamically
		$('<div id="voi-product-dropdown" class="dropdown-content" style="display: none; position: absolute; background: #fff; border: 1px solid #ccc; z-index: 1000;"></div>')
			.insertAfter('.voi-search .forminator-field .forminator-input');

		// Function to fetch products based on the input
		function fetchProducts(query) {
			$.ajax({
				url: '<?php echo admin_url('admin-ajax.php'); ?>', // Replace with your actual PHP handler URL
				type: 'POST',
				data: {
					action: 'voi_search_live',
					search: query
				},
				success: function (data) {
					var products;
					try {
						products = JSON.parse(data).mylist;
					} catch (e) {
						products = [];
					}
					displayDropdown(products);
				}
			});
		}

		// Function to display the dropdown with product list
		function displayDropdown(products) {
			var dropdown = $('#voi-product-dropdown');
			dropdown.empty(); // Clear previous results

			if (products && products.length > 0) {
				products.forEach(function (product) {
					dropdown.append('<div class="dropdown-item" data-id="' + product.id + '">' + product
						.name + '</div>');
				});
				dropdown.show();
			} else {
				dropdown.hide();
			}
		}

		// Event listener for input focus and typing
		$('.voi-search .forminator-field .forminator-input').on('input focus', function () {
			var query = $(this).val();
			if (query.length > 2) { // Fetch products only if the input length is greater than 2
				fetchProducts(query);
			} else {
				$('#voi-product-dropdown').hide();
			}
		});

		// Event listener for selecting a product from the dropdown
		$(document).on('click', '.dropdown-item', function () {
			var productName = $(this).text();
			var productId = $(this).data('id');
			$('.voi-search .forminator-field .forminator-input').val(productName).data('product-id',
				productId);
			$('#voi-product-dropdown').hide();
		});

		// Hide dropdown if clicking outside
		$(document).on('click', function (event) {
			if (!$(event.target).closest(
				'.voi-search .forminator-field .forminator-input, #voi-product-dropdown').length) {
				$('#voi-product-dropdown').hide();
			}
		});



	});


	jQuery(document).ready(function () {
		setTimeout(function () {
			// Remove 'elementor-active' class from all tab titles and set aria attributes
			jQuery('.elementor-accordion .elementor-tab-title')
				.removeClass('elementor-active')
				.attr("aria-expanded", "false")
				.attr("aria-selected", "false");

			// Remove 'elementor-active' class and hide all tab content
			jQuery('.elementor-accordion .elementor-tab-content')
				.removeClass('elementor-active')
				.hide();
		});
	});






	document.addEventListener("DOMContentLoaded", () => {
		function countryCodeSelector(selector) {
			// Select all elements matching the provided selector
			const phoneInputFields = document.querySelectorAll(selector);

			if (phoneInputFields.length === 0) {
				console.warn(`No elements found for selector: ${selector}`);
				return;
			}

			// Initialize intlTelInput for each selected element
			phoneInputFields.forEach(phoneInputField => {
				intlTelInput(phoneInputField, {
					utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
					initialCountry: "ca",
					preferredCountries: ["ca", "us", "bd"],
				});
			});
		}

		// Call the function for different selectors
		// countryCodeSelector('input.forminator-field--phone');

	});







	function showGlobalAlert(status, responseData) {
		jQuery('.documentManagementBody').removeClass('d-none').addClass('d-flex');
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
<div class="p-5">

<image src="${status === 'error' ? '<?php echo home_url(); ?>/wp-content/uploads/2024/06/mingcute_alert-line.png' : '<?php echo home_url(); ?>/wp-content/uploads/2025/01/Group-1321315975.png'}" style="max-width:100px; max-height:100px;" />


<div class="mt-4">
${responseData ? responseData : 'Nothing happened'}
</div>
</div>
`;



		jQuery(".documentManagementBody .documentViewSection").html(displayData);
	}


</script>


<script>
	let googleMaps, pickupTransportMarker, destinationTransportMarker, currentUserLocationMarker, directionsMapService, directionsMapRenderer, mapGeocoder, inputFieldClass;
	// let googleMap, pickupTransportMarker, destinationTransportMarker, currentUserLocationMarker, directionsMapService, directionsMapRenderer, mapGeocoder;

	function initializeCustomLocationMap(options) {

		const {
			pickupLocation = null,
			destinationLocation = null,
			currentGoogleLocation = null,
			currentAddressCanChange = false,
			transportStatus = null,
			mapContainer = ".map_container",
			inputField = "#driverCurrentAddress"
		} = options;

		console.log('options: ', options);

		inputFieldClass = inputField;

		const mapStyle = [{
			"elementType": "geometry",
			"stylers": [{
				"color": "#f5f5f5"
			}]
		},
		{
			"elementType": "labels.text.fill",
			"stylers": [{
				"color": "#616161"
			}]
		},
		{
			"featureType": "road",
			"elementType": "geometry",
			"stylers": [{
				"color": "#000000"
			}]
		},
		{
			"featureType": "water",
			"elementType": "geometry.fill",
			"stylers": [{
				"color": "#c9e5f0"
			}]
		},
		];

		const mapOptions = {
			zoom: 16,
			center: { lat: 43.7, lng: -79.42 },
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			styles: mapStyle,
			mapTypeControl: false,
			streetViewControl: false,
			fullscreenControl: true,
			zoomControl: true,
			scaleControl: true,
		};

		// Initialize Google Maps
		googleMaps = currentAddressCanChange ? new google.maps.Map(document.querySelector(mapContainer),
			mapOptions) : new google.maps.Map(document.querySelector(mapContainer), mapOptions);
		directionsMapService = new google.maps.DirectionsService();
		directionsMapRenderer = new google.maps.DirectionsRenderer({
			map: googleMaps,
			suppressMarkers: true,
			polylineOptions: {
				strokeColor: "#fd5c63",
				strokeWeight: 5
			},
		});
		mapGeocoder = new google.maps.Geocoder();


		// 	// Highlight Canada
		// 		const canadaCoords = [
		//     { lat: 43.72011, lng: -79.4563 }, // Top-left
		//         { lat: 43.72011, lng: -79.3763 }, // Top-right
		//         { lat: 43.68011, lng: -79.3763 }, // Bottom-right
		//         { lat: 43.68011, lng: -79.4563 }  // Bottom-left
		//   // Add more points as needed
		// ];

		// 		const canadaPolygon = new google.maps.Polygon({
		// 			paths: canadaCoords,
		// 			strokeColor: "#FF0000",
		// 			strokeOpacity: 0.8,
		// 			strokeWeight: 2,
		// 			fillColor: "#FF0000",
		// 			fillOpacity: 0.3 // 50% red fill
		// 		});

		// 		canadaPolygon.setMap(googleMaps);

		// Process locations
		processLocations(pickupLocation, destinationLocation, currentGoogleLocation, currentAddressCanChange,
			transportStatus);
	}

	function processLocations(pickupLocation, destinationLocation, currentGoogleLocation, currentAddressCanChange,
		transportStatus) {


		resolveCoordinates(pickupLocation, (pickupLatLng) => {
			pickupTransportMarker = new google.maps.Marker({
				position: pickupLatLng,
				map: googleMaps,
				icon: {
					url: "https://cdn-icons-png.flaticon.com/512/684/684908.png",
					scaledSize: new google.maps.Size(30, 30),
				},
				title: "Pickup Location",
			});



			resolveCoordinates(destinationLocation, (destinationLatLng) => {
				destinationTransportMarker = new google.maps.Marker({
					position: destinationLatLng,
					map: googleMaps,
					icon: {
						url: "<?php echo home_url(); ?>/wp-content/uploads/2024/12/maps-and-flags.png",
						scaledSize: new google.maps.Size(30, 30),
					},
					title: "Destination Location",
				});

				calculateAndDisplayRoute(pickupLatLng, destinationLatLng);

				if (transportStatus === "Delivered" || transportStatus === "Awaiting pickup") {
					// Hide current location marker
					adjustMapBounds([pickupLatLng, destinationLatLng]);
					calculateTotalDistance(pickupLatLng, destinationLatLng);
				} else {
					// Handle current location
					if (!currentGoogleLocation) {
						getUserCurrentLocation((currentLatLng) => {
							addCurrentLocationMarker(currentLatLng, currentAddressCanChange);
							adjustMapBounds([pickupLatLng, destinationLatLng, currentLatLng]);
							// calculateRemainingDistance(currentLatLng, destinationLatLng);
							calculateTotalDistance(pickupLatLng, destinationLatLng);
						});
					} else {
						resolveCoordinates(currentGoogleLocation, (currentLatLng) => {
							addCurrentLocationMarker(currentLatLng, currentAddressCanChange);
							adjustMapBounds([pickupLatLng, destinationLatLng, currentLatLng]);
							calculateRemainingDistance(currentLatLng, destinationLatLng);
							calculateTotalDistance(pickupLatLng, destinationLatLng);
						});
					}
				}

			});
		});
	}

	function resolveCoordinates(location, callback) {
		if (location?.map_lat && location?.map_log) {
			const latLng = new google.maps.LatLng(location.map_lat, location.map_log);
			callback(latLng);
		} else if (location?.address) {
			mapGeocoder.geocode({
				address: location.address
			}, (results, status) => {
				if (status === google.maps.GeocoderStatus.OK) {
					callback(results[0].geometry.location);
				} else {
					console.error("Geocoding failed: " + status);
				}
			});
		} else {
			mapGeocoder.geocode({
				address: location
			}, (results, status) => {
				if (status === google.maps.GeocoderStatus.OK) {
					callback(results[0].geometry.location);
				} else {
					console.error("Geocoding failed: " + status);
				}
			});
		}
	}

	function getUserCurrentLocation(callback) {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(
				(position) => {
					const latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
					callback(latLng);
				},
				(error) => {
					console.error("Error getting user location: ", error);
				}
			);
		} else {
			console.error("Geolocation is not supported by this browser.");
		}
	}

	function addCurrentLocationMarker(currentLatLng, currentAddressCanChange) {
		currentUserLocationMarker = new google.maps.Marker({
			position: currentLatLng,
			map: googleMaps,
			icon: {
				url: currentAddressCanChange ? "https://cdn-icons-png.flaticon.com/512/684/684908.png" :
					"<?php echo home_url(); ?>/wp-content/uploads/2024/12/emojione-delivery-truck.svg",
				scaledSize: new google.maps.Size(40, 40),
			},
			title: "Current Location",
			draggable: currentAddressCanChange,
		});

		if (currentAddressCanChange) {
			google.maps.event.addListener(currentUserLocationMarker, "dragend", (event) => {
				const newPosition = event.latLng;
				mapGeocoder.geocode({
					location: newPosition
				}, (results, status) => {
					if (status === google.maps.GeocoderStatus.OK) {
						console.log("New Address: ", results[0].formatted_address);
						jQuery(inputFieldClass || '#driverCurrentAddress').val(results[0].formatted_address);
						// alert(New address selected: ${results[0].formatted_address});
					} else {
						console.error("Reverse geocoding failed: " + status);
					}
				});
			});
		}
	}

	function calculateTotalDistance(originLatLng, destinationLatLng) {
		const service = new google.maps.DistanceMatrixService();
		service.getDistanceMatrix({
			origins: [originLatLng],
			destinations: [destinationLatLng],
			travelMode: google.maps.TravelMode.DRIVING,
		},
			(response, status) => {
				if (status === google.maps.DistanceMatrixStatus.OK) {
					const distance = response.rows[0].elements[0].distance.text;
					console.log("Total Distance: " + distance);
					jQuery('.Total Distance').val(distance)
					// alert(Total Distance: ${distance});
				} else {
					console.error("Distance calculation failed: " + status);
				}
			}
		);
	}

	function calculateRemainingDistance(currentLatLng, destinationLatLng) {
		const service = new google.maps.DistanceMatrixService();
		service.getDistanceMatrix({
			origins: [currentLatLng],
			destinations: [destinationLatLng],
			travelMode: google.maps.TravelMode.DRIVING,
		},
			(response, status) => {
				if (status === google.maps.DistanceMatrixStatus.OK) {
					const distance = response.rows[0].elements[0].distance.text;
					console.log("Remaining Distance: " + distance);
					jQuery('.Total Distance').val(distance)
					// alert(Remaining Distance: ${distance});
				} else {
					console.error("Distance calculation failed: " + status);
				}
			}
		);
	}

	function adjustMapBounds(markers) {
		const bounds = new google.maps.LatLngBounds();
		markers.forEach((marker) => bounds.extend(marker));
		googleMaps.fitBounds(bounds);
	}


	function calculateAndDisplayRoute(originLatLng, destinationLatLng) {
		const request = {
			origin: originLatLng,
			destination: destinationLatLng,
			travelMode: google.maps.TravelMode.DRIVING,
		};

		directionsMapService.route(request, (result, status) => {
			if (status === google.maps.DirectionsStatus.OK) {
				directionsMapRenderer.setDirections(result);
			} else {
				console.error("Directions request failed: " + status);
			}
		});
	}







	function updateFinanceFormWidth(selector) {
		if (document.documentElement.clientWidth <= 768) {
			jQuery(selector || '.financeFormMainSection').css({ 'width': '100%' });
		} else {
			jQuery(selector || '.financeFormMainSection').css({ 'width': '70%' });
		}
	}




	function showFinanceGetApprovalModal() {

		jQuery(document).ready(function ($) {

			let trboFinanceAgreeData = `
<div class="p-md-3 ">

<div class="d-flex align-items-center">
<h3>Get Pre-Approved</h3>
								<div class="" style="max-width:110px; margin-top: -45px;  margin-bottom:45px;">
										<?php echo $CORE->LAYOUT("get_logo", "light"); ?>
								</div>
</div>
<p>Note: Name & Address must match your government issued ID to get an accurate result.</p>

								<div class="col-12 p-0 container m-0 position-relative"
									style="border-radius:22px;">

									<div class="col-12 col-md-8">
									</div>
									<div class="col-12 col-md-4 d-flex justify-content-center align-items-center">
									<img src="<?php echo home_url() ?>/wp-content/uploads/2025/01/Group-1321317067.png" style="width:100%; height:100%; object-fit: contain" />
									</div>

								</div>
	</div>
`;
			jQuery('.newUserAddModalContainer').addClass('bg-white customModalWidthHalf p-1 p-md-2').html(trboFinanceAgreeData);
			jQuery('.newUserAddModalBody').removeClass('d-none').addClass('d-flex p-2 p-md-3');

		});
	}



	function showFinanceFormApprovalModal() {

		jQuery(document).ready(function ($) {

			let trboFinanceAgreeData = `
<div class="p-md-3">
								<div class="container m-0 p-2 position-relative"
									style="border-radius:22px; border:1px solid #3B634C;">

									<div class="col-12 d-flex justify-content-between align-items-center py-2"> <span class="text-secondary font-weight-bold font-16" style="font-family:Plus Jakarta Sans;">DEAL AGREEMENT</span></div> 


									<div class="col-md-10">
										
									<div class="mb-2 font-10 text-left">
										<p><span class="text-primary">Buyer (${$('input[name="name-1"]').val()} ${$('input[name="name-2"]').val()})</span> is
											applying for <span class="text-secondary">$ ${parseFloat($('input[name="currency-2"]').val()).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')} to purchase ${$("#select-2 .select2-selection__rendered").val()} ${$("#select-1 .select2-selection__rendered").val()} ${$("input[name='text-14']").val()} with the VIN - <strong class="text-uppercase">${$("input[name='text-13']").val()}</strong></span> from 
											<span class="text-primary">Seller(${$("input[name='name-4']").val()} ${$("input[name='name-6']").val()})</span> Seller is required to complete the TrboSwfift AI Damage inspection.
										</p>
									</div>

									<div class="my-4 text-center">
									<button id="nextBtn" class="brn text-white rounded-pill py-1 px-3 font-10 mb-3 mr-0 mb-md-0 mr-md-3" style="background:#5F5F5F;">
									Accept agreement
									</button>
									<button  onclick="jQuery('.newUserAddModalBody').removeClass('d-flex').addClass('d-none');" class="brn btn-secondary rounded-pill py-1 px-3 font-10 mb-3 mr-0 mb-md-0 mr-md-3">
									Decline agreement
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
			jQuery('.newUserAddModalContainer').addClass('bg-white customModalWidthFull p-2 p-md-3').html(trboFinanceAgreeData);
			jQuery('.newUserAddModalBody').removeClass('d-none').addClass('d-flex p-2 p-md-3');

		});
	}


	var financeFormTransport = jQuery('.border-left-3');

	if (financeFormTransport.length) {
		financeFormTransport.html(`
<div class="row ml-4">
<div>
<p><small>Transportation,Anywhere Across Canada</small></p><br>
<div class="pl-3" style="border-left: 9px solid #BF9B3E">
<h3 class="text-primary"><strong>Vehicle Transportation</strong></h3><br>
<p><span class="text-dark">Select an option to get a TRBO Swift Transport quote and have your vehicle delivered anywhere in Canada.</span></p>
</div>
</div>
<div>
<p>Our Trusted Partner<br><img style="width: 100px;" src="https://trboswift.com/wp-content/uploads/2025/02/Link-→-abrams-logo.png.png" /></p>
</div>
</div>
	`);
	}




	jQuery(document).ready(function ($) {
		// Monitor button click to start observing response changes
		$(document).on('click', '.forminator-button-submit', function () {
			console.log("Submit button clicked. Starting observer...");
			observeResponseChange();
		});

		function observeResponseChange() {
			let checkInterval = setInterval(function () {
				let successNode = $('.forminator-response-message.forminator-success');
				let errorNode = $('.forminator-response-message.forminator-error');

				$('.forminator-response-message').addClass('d-none'); // Hide default messages

				if (successNode.length > 0 && successNode.text().trim() !== '') {
					console.log("Success message detected!");

					// Hide FAQ section and expand form width
					$('.financeFormFaqSection').hide();
					$('.financeFormMainSection').css({ 'width': '100%' });

					let message = `
					<div class="py-4 formResponseSuccess">
						<div class="col-12 position-relative py-4 newbgPrimary text-white align-content-center" 
							style="min-height:324px; border-radius:5px;">
							<img class="carImage" src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/image-162-1.svg"/>

							<div class="col-md-8 d-flex justify-content-center align-items-center flex-column">
								<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/teenyicons_tick-circle-solid.svg" style="width:80px;" />
								<h6 class="col-md-6 my-3 text-center">
									Your deal has been submitted! View the agreement by clicking 
									<a href="<?php echo home_url(); ?>/account/?showtab=financing" class="text-white" style="text-decoration: underline;">here</a>.
								</h6>
								<span>The seller has been invited to complete their part of the application.</span>
							</div>
						</div>

						<div class="col-12 row mx-0 py-5 row mx-0 align-items-md-center">
							<div class="col-3 col-md-2">
								<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/TurboBid_DD-13.svg" style="width:100%;" />
							</div>
							<div class="col-9 col-md-5">
								<small class="text-primary">Connected and Updated</small>
								<h6>Stay Informed About Your Application</h6>
								<p class="small">
									Once submitted, track your loan updates, sign paperwork, review terms, and access the vehicle inspection report easily. 
									Our intuitive dashboard simplifies the loan process for vehicles listed across Canada. 
									Log in with your application email, and receive all updates via email and text.
								</p>
							</div>
							<div class="col-md-5">
								<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/freepik_br_63db8398-31e6-4978-a359-bf7e59198e5b-1.png" style="width:100%;" />
							</div>
						</div>
					</div>
				`;

					$('.forminator-response-message').html(message).removeClass('d-none forminator-success');

					clearInterval(checkInterval); // Stop checking
				} else if (errorNode.length > 0 && errorNode.text().trim() !== '') {
					console.log("Error message detected:", errorNode.text().trim());
					clearInterval(checkInterval); // Stop checking
				} else {
					console.log("Waiting for response...");
				}
			}, 2000); // Check every 2 seconds
		}
	});



	function stringArrayToArray(data) {
		var sellerSuggestedTimesStr = data;
		// Remove backslashes (if they exist as literals)
		var cleanedString = sellerSuggestedTimesStr.replace(/\\/g, '');

		// Parse the cleaned string into a JSON array
		var sellerSuggestedTimes;
		try {
			return sellerSuggestedTimes = JSON.parse(cleanedString);
		} catch (error) {
			console.error("Failed to parse sellerSuggestedTimes:", error);
			return sellerSuggestedTimes = []; // Fallback to empty array
		}
	}





</script>

<?php /*
<script>
let googleMap, pickupTransportMarker, destinationTransportMarker, currentUserLocationMarker, directionsMapService, directionsMapRenderer, mapGeocoder;


function initializeCustomLocationMap(options) {
const {
pickupLocation = null,
destinationLocation = null,
currentGoogleLocation = null,
currentAddressCanChange = false,
transportStatus = null,
mapContainer = ".map_container"
} = options;

console.log('options: ', options);

// Define Map Styles
const mapStyle = [{
"elementType": "geometry",
"stylers": [{
"color": "#f5f5f5"
}]
},
{
"elementType": "labels.text.fill",
"stylers": [{
"color": "#616161"
}]
},
{
"featureType": "road",
"elementType": "geometry",
"stylers": [{
"color": "#000000"
}]
},
{
"featureType": "water",
"elementType": "geometry.fill",
"stylers": [{
"color": "#c9e5f0"
}]
},
];

let defaultLng = jQuery('#location-mylog').val() || "-75.6972";
let defaultLat = jQuery('#location-mylat').val() || "45.4215";

let myLatLng = { lat: parseFloat(defaultLat), lng: parseFloat(defaultLng) };

const mapOptions = {
zoom: 16,
center: myLatLng,
mapTypeId: google.maps.MapTypeId.ROADMAP,
styles: mapStyle,
mapTypeControl: false,
streetViewControl: false,
fullscreenControl: true,
zoomControl: true,
scaleControl: true,
};

// Initialize Google Maps
googleMap = new google.maps.Map(document.querySelector(mapContainer), mapOptions);
directionsMapService = new google.maps.DirectionsService();
directionsMapRenderer = new google.maps.DirectionsRenderer({
map: googleMap,
suppressMarkers: true,
polylineOptions: { strokeColor: "#fd5c63", strokeWeight: 5 },
});
mapGeocoder = new google.maps.Geocoder();

// Process locations
processLocations(pickupLocation, destinationLocation, currentGoogleLocation, currentAddressCanChange, transportStatus);
}


function processLocations(pickupLocation, destinationLocation, currentGoogleLocation, currentAddressCanChange, transportStatus) {
getUserCurrentLocation((currentLatLng) => {

console.log('Map pin:', currentLatLng);
addCurrentLocationMarker(currentLatLng, currentAddressCanChange);
googleMap.setCenter(currentLatLng);
});

resolveCoordinates(pickupLocation, (pickupLatLng) => {
pickupTransportMarker = createMarker(pickupLatLng, "Pickup Location", "https://cdn-icons-png.flaticon.com/512/684/684908.png");

resolveCoordinates(destinationLocation, (destinationLatLng) => {
destinationTransportMarker = createMarker(destinationLatLng, "Destination", "<?php echo home_url(); ?>/wp-content/uploads/2024/12/maps-and-flags.png");

calculateAndDisplayRoute(pickupLatLng, destinationLatLng);

if (transportStatus === "Delivered" || transportStatus === "Awaiting pickup") {
adjustMapBounds([pickupLatLng, destinationLatLng]);
calculateTotalDistance(pickupLatLng, destinationLatLng);
} else {
handleCurrentLocation(currentGoogleLocation, pickupLatLng, destinationLatLng, currentAddressCanChange);
}
});
});
}


function handleCurrentLocation(currentGoogleLocation, pickupLatLng, destinationLatLng, currentAddressCanChange) {
if (!currentGoogleLocation) {
getUserCurrentLocation((currentLatLng) => {
addCurrentLocationMarker(currentLatLng, currentAddressCanChange);
adjustMapBounds([pickupLatLng, destinationLatLng, currentLatLng]);
calculateTotalDistance(pickupLatLng, destinationLatLng);
});
} else {
resolveCoordinates(currentGoogleLocation, (currentLatLng) => {
addCurrentLocationMarker(currentLatLng, currentAddressCanChange);
adjustMapBounds([pickupLatLng, destinationLatLng, currentLatLng]);
calculateRemainingDistance(currentLatLng, destinationLatLng);
calculateTotalDistance(pickupLatLng, destinationLatLng);
});
}
}


function resolveCoordinates(location, callback) {
if (!location) return;

if (location.map_lat && location.map_log) {
callback(new google.maps.LatLng(location.map_lat, location.map_log));
} else if (location.address) {
mapGeocoder.geocode({ address: location.address }, (results, status) => {
if (status === google.maps.GeocoderStatus.OK) {
callback(results[0].geometry.location);
} else {
console.error("Geocoding failed: " + status);
}
});
}
}




function getUserCurrentLocation(callback) {
if (!navigator.geolocation) {
console.error("Geolocation is not supported by this browser.");
alert("Geolocation is not supported by this browser.");
return;
}

navigator.geolocation.getCurrentPosition(
(position) => {
console.log("Location retrieved:", position);
},
(error) => {
console.error("Error getting location:", error);
if (error.code === error.POSITION_UNAVAILABLE) {
setTimeout(() => getUserCurrentLocation(), 5000);
}
}
);

}





function createMarker(position, title, iconUrl) {
return new google.maps.Marker({
position,
googleMap,
icon: { url: iconUrl, scaledSize: new google.maps.Size(30, 30) },
title,
});
}


function addCurrentLocationMarker(currentLatLng, currentAddressCanChange) {
console.log('Your location: ', currentLatLng);

currentUserLocationMarker = createMarker(currentLatLng, "Current Location", "<?php echo home_url(); ?>/wp-content/uploads/2024/12/emojione-delivery-truck.svg");
if (currentAddressCanChange) {
currentUserLocationMarker.setDraggable(true);
google.maps.event.addListener(currentUserLocationMarker, "dragend", (event) => {
mapGeocoder.geocode({ location: event.latLng }, (results, status) => {
if (status === google.maps.GeocoderStatus.OK) {
console.log("New Address: ", results[0].formatted_address);
} else {
console.error("Reverse geocoding failed: " + status);
}
});
});
}
}


function calculateAndDisplayRoute(originLatLng, destinationLatLng) {
directionsMapService.route(
{ origin: originLatLng, destination: destinationLatLng, travelMode: google.maps.TravelMode.DRIVING },
(result, status) => {
if (status === google.maps.DirectionsStatus.OK) {
directionsMapRenderer.setDirections(result);
} else {
console.error("Directions request failed: " + status);
}
}
);
}


function calculateTotalDistance(originLatLng, destinationLatLng) {
const service = new google.maps.DistanceMatrixService();
service.getDistanceMatrix(
{ origins: [originLatLng], destinations: [destinationLatLng], travelMode: google.maps.TravelMode.DRIVING },
(response, status) => {
if (status === google.maps.DistanceMatrixStatus.OK) {
console.log("Total Distance: " + response.rows[0].elements[0].distance.text);
} else {
console.error("Distance calculation failed: " + status);
}
}
);
}


function calculateRemainingDistance(currentLatLng, destinationLatLng) {
calculateTotalDistance(currentLatLng, destinationLatLng);
}


function adjustMapBounds(markers) {
const bounds = new google.maps.LatLngBounds();
markers.forEach(marker => bounds.extend(marker));
googleMap.fitBounds(bounds);

// Set a maximum zoom level to prevent excessive zooming
google.maps.event.addListenerOnce(googleMap, 'bounds_changed', function() {
if (googleMap.getZoom() > 16) {
googleMap.setZoom(16); // Adjust to Uber-like zoom level
}
});
}
</script>
*/ ?>







<style>
	.forminator-edit-module {
		display: none;
	}

	.bg-transparent {
		background: transparent !important;
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

		.customModalWidthSmall {
			max-width: 60% !important;
			text-align: center !important;
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

		.customModalWidthSmall {
			max-width: 50% !important;
			text-align: center !important;
		}

	}

	.flex-2 {
		-ms-flex: 0 0 15.333333%;
		flex: 0 0 15.333333%;
		max-width: 15.333333%;
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

		.customModalWidthSmall {
			max-width: 50% !important;
			text-align: center !important;
		}



	}
</style>


<div id="ppt_livechat_window"></div>


<div class="newUserAddModalBody d-none">
	<button onclick="jQuery('.newUserAddModalBody').removeClass('d-flex').addClass('d-none');" type="button"
		class="btn btn-light rounded-pill" style="position: absolute; right: 30px; top: 15px; z-index:5;"><i
			class="fal fa-times"></i></button>
	<div class="newUserAddModalContainer position-relative" style="max-height:80vh; overflow-y:scroll;">

	</div>
</div>
<style>
	.newUserAddModalBody {
		display: flex;
		font-family: "Poppins", sans-serif;
		justify-content: center;
		align-items: center;
		height: 100vh;
		margin: 0;
		background-color: #565555b0;
		color: #000000;
		background-image: radial-gradient(circle at 25% 25%,
				rgba(255, 255, 255, 0.1) 2%,
				transparent 0%),
			radial-gradient(circle at 75% 75%,
				rgba(221, 221, 221, 0.1) 2%,
				transparent 0%);
		background-size: 60px 60px;
		z-index: 999;
		position: fixed;
		left: 0;
		top: 0;
		right: 0;
		bottom: 0;
	}

	.newUserAddModalContainer {
		background-color: rgba(255, 255, 255, 0.8);
		padding: 3rem;
		border-radius: 16px;
		box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
		text-align: center;
		backdrop-filter: blur(10px);
		border: 1px solid rgba(255, 255, 255, 0.1);
		width: 100%;
	}

	@media (min-width: 768px) {
		.newUserAddModalContainer {
			max-width: 700px;
			max-height: 80vh;
			overflow-y: scroll;
		}


		.formResponseSuccess .carImage {
			position: absolute !important;
			width: 635px;
			right: -26px;
			top: -26px;
		}

		.border-left-3 {
			line-height: 14px;
		}
	}

	@media (min-width: 450px) and (max-width: 768px) {
		.newUserAddModalContainer {
			max-width: 400px;
			max-height: 80vh;
			overflow-y: scroll;
		}

		.formResponseSuccess .carImage {
			position: unset;
			width: 100%;
		}
	}

	@media (min-width: 250px) and (max-width: 450px) {
		.newUserAddModalContainer {
			max-width: 100%;
			margin: auto 10px;
			max-height: 80vh;
			overflow-y: scroll;
		}

		.formResponseSuccess .carImage {
			position: unset;
			width: 100%;
		}

		.border-left-3 {
			line-height: 24px;
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


	.statusWrapper {
		border: 0.5px solid #ebecee;
		padding: 10px;
		margin-top: 10px;
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

	.transportStepProgress small {
		color: #222222;
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
		height: 12px;
		/* Set height for SVG */
		background-size: contain;
		/* Ensure SVG scales properly */
		background-repeat: no-repeat;
		background-repeat: no-repeat;
		background-position: center;
	}

	.transportStepProgress-item.number:first-child::before,
	.transportStepProgress-item.number:last-child::before {
		padding: 12px;
		border: 0.5px solid #F8F9FA;
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
  background-size: 100% 200%; 
} 
*/



	/* Current step styling */
	.transportStepProgress-item.current::before {
		border-radius: 50%;

	}



	.transportStepProgress-item.is-done::after {
		content: '';
	}

	.transportStepProgress-item.current:not(:first-child)::after {
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




	.newbgPrimary {
		background: #00371F;
	}

	.newColorPrimary {
		color: #004225;
	}



	.calendar-container,
	.calenderLeftInfo {
		background-color: #F8F9FA;
		border-radius: 6px;
		margin-top: 20px;
		padding: 15px;
	}


	.pignose-calendar-top-date {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		padding: 1.8em 0 !important;
		text-align: center;
		text-transform: uppercase;
		box-sizing: border-box;
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 10px;
	}

	.pignose-calendar {
		all: unset !important;
	}

	.pignose-calendar {
		background-color: #fff !important;
		border-radius: 6px !important;
	}

	.pignose-calendar .pignose-calendar-top .pignose-calendar-top-year {
		font-size: unset !important;
		color: #3F3F3F;
	}

	.pignose-calendar .pignose-calendar-top .pignose-calendar-top-month {
		margin-bottom: unset !important;
		font-size: unset !important;
		font-weight: 300 !important;
		color: #3F3F3F;
	}

	.pignose-calendar .pignose-calendar-top {
		padding: 1.6em 0;
		background-color: unset !important;
		border-bottom: unset !important;
		box-shadow: unset !important;
		position: relative;
		overflow: unset !important;
		width: unset !important;
		align-content: unset !important;
		align-self: unset !important;
		display: flex;
		justify-content: space-around;
	}

	.pignose-calendar .pignose-calendar-header .pignose-calendar-week.pignose-calendar-week-sat,
	.pignose-calendar .pignose-calendar-header .pignose-calendar-week.pignose-calendar-week-sun {
		color: #000000 !important;
	}

	.pignose-calendar .pignose-calendar-unit.pignose-calendar-unit-sat a,
	.pignose-calendar .pignose-calendar-unit.pignose-calendar-unit-sun a {
		color: #3F3F3F !important;
		font-weight: 300 !important;
	}

	.pignose-calendar .pignose-calendar-unit a {
		display: inline-block;
		width: 2.4em;
		height: 2.4em;
		border-radius: 50%;
		color: #3F3F3F;
		line-height: 2.4em;
		text-align: center;
		text-decoration: none;
		transition: background-color .3s ease, color .3s ease;
		font-weight: 300;
	}

	.pignose-calendar .pignose-calendar-unit.pignose-calendar-unit-active a {
		background-color: #BF9B3E;
		color: #fff;
		font-weight: 600;
		box-shadow: unset !important;
	}

	.timezone-container {
		margin-top: 20px;
	}

	select {
		width: 100%;
		padding: 8px;
		border: 1px solid #ccc;
		border-radius: 5px;
		font-size: 16px;
	}

	.selected-date {
		text-align: center;
		font-size: 18px;
		font-weight: bold;
		margin-top: 10px;
	}
</style>


<script>
	jQuery(document).ready(function ($) {


		$(document).on('click', '#dealStartForBuyer', function () {

			if (document.documentElement.clientWidth <= 768) {

				const aiDriverLicense = `
		<button id="snap" class="take-photo-btn">Take photo</button>
		<div id="camcam">
			<div class="camera-overlay">
				<div class="overlay-mask">
					<div class="mask-container">
						<div class="temporary-svg-overlay">
							<svg width="238" height="155" viewBox="0 0 238 155" fill="none" xmlns="http://www.w3.org/2000/svg" data-testid="document-front-helper-illustration"><g class="fyfaodn d2y8ndh"><rect x="1.5" y="1.5" width="234.385" height="151.3" rx="7.73077" stroke="#D4FAED" stroke-width="3"></rect><circle cx="65.28" cy="59.3459" r="22.2385" stroke="#D4FAED" stroke-width="3"></circle><path d="M94.9532 118.692C94.9532 102.304 81.6681 89.0186 65.28 89.0186C48.892 89.0186 35.6069 102.304 35.6069 118.692" stroke="#D4FAED" stroke-width="3"></path><path d="M130.562 47.4766H201.777M154.3 74.1824H201.777" stroke="#D4FAED" stroke-width="3"></path></g></svg>
						</div>
						<div class="scanning-overlay" style="display: none;">
							<div class="scanning-wrapper">
								<div class="scanner-bar"></div>
							</div>
						</div>
					</div>
					<div class="o1bk7qg8">
						<div class="text-content">
							<h4>Take a photo of your document’s photo page</h4>\
						</div>
						<div class="scanner-bottom">
						<div class="accepted-docs">
						<span>
								<div style="text-transform: uppercase; margin-bottom: 1rem;display: block;">ACCEPTED DOCUMENTS</div>
								<div style="text-transform: capitalize;">Driver’s license.</div>
								</span>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			<video id="video" autoplay playsinline></video>
			<div id="capture" class="son" style="display: none;">
					<canvas id="canvas"></canvas>
				</div>
			
		</div>`;

				jQuery('.newUserAddModalContainer')
					.removeClass('bg-white customModalWidthHalf px-2')
					.addClass('customModalWidthCamera')
					.html(aiDriverLicense);

				let video = document.getElementById('video');
				let canvas = document.getElementById('canvas');
				let context = canvas.getContext('2d');
				let streamRef = null;

				function openCam() {
					navigator.mediaDevices.getUserMedia({
						video: {
							facingMode: "environment",
							width: { ideal: 1920 },
							height: { ideal: 1080 }
						}
					}).then(stream => {
						video.srcObject = stream;
						streamRef = stream;

						// Show SVG overlay for 2 seconds
						setTimeout(() => {
							document.querySelector('.temporary-svg-overlay').style.display = 'none';
						}, 10000);

						video.onloadedmetadata = () => {
							canvas.width = video.videoWidth;
							canvas.height = video.videoHeight;
							// Adjust mask aspect ratio dynamically
							const mask = document.querySelector('.mask-container');
							mask.style.aspectRatio = video.videoWidth / video.videoHeight;
						};
					}).catch(console.error);
				}

				function closeCam() {
					if (streamRef) {
						streamRef.getTracks().forEach(track => track.stop());
					}
				}

				// Update capture handler
				$('#snap').click(function () {
					context.drawImage(video, 0, 0, canvas.width, canvas.height);

					// Show scanning overlay
					$('.temporary-svg-overlay').css({ display: 'block', opacity: 1 });
					$('.scanning-overlay').show();

					canvas.toBlob(blob => {
						const file = new File([blob], "id-card.jpg", {
							type: "image/jpeg",
							lastModified: Date.now()
						});


						imageScanner(file);

					}, 'image/jpeg', 1.0);

					$('#vid').hide();
					$('#capture').show();
				});

				// Update retake handler
				$('#retake').click(function () {
					$('#vid').show();
					$('#capture').hide();
					$('.scanning-overlay').hide();
					$('.temporary-svg-overlay').hide();
				});

				$('#close').click(() => {
					closeCam();
					jQuery('.newUserAddModalBody').addClass('d-none');
				});

				// Initialize camera
				openCam();

				// Handle orientation changes
				window.addEventListener('resize', () => {
					canvas.width = video.videoWidth;
					canvas.height = video.videoHeight;
				});


			} else {

				let aiDriverLicense = ` 
			
			<div class="d-flex flex-wrap py-3 position-relative" id="documentProofPreviewContainer" style="align-content: center;
	position: absolute;
	top: 49%;
	left: 50%;
	transform: translate(-50%, 0%);"></div>

								<div class="custom-file-drop" id="documentProofDropArea">
									<!-- <p>Upload document or image</p> -->
								
									<span class="small position-relative" style="z-index:1500">Upload driver license image.</span>
									<br>

									<div class="text-center my-2 position-relative" style="z-index:1500">
										<button class="upload-proof-btn btn btn-outline-primary px-2 py-1"
											style="width: 130px; font-size: 12px;">Browse</button>
									</div>

									<input type="file" name="file" id="documentProofFileInput" style="display: none;">
								</div>`;

				jQuery('.newUserAddModalContainer').addClass('bg-white customModalWidthHalf px-2').html(aiDriverLicense);



				initializeFileUploadHandler('#documentProofDropArea', '#documentProofFileInput', '#documentProofPreviewContainer',
					'.upload-proof-btn');

			}

		});



		$(document).on('change', '#documentProofFileInput', function (event) {
			$('#documentProofDropArea').hide();
			$('.newUserAddModalContainer').append(`<div id="loadingSpinner" class="spinner-overlay text-center" style="
		position: absolute;
		left: 50%;
		top: 50%;
		transform: rotateY(-50deg);
		z-index: 12;">
		<div class="spinner-grow text-light" role="status">
			<span class="sr-only">Scanning...</span>
		</div>
		<span class="text-white mt-2">Scanning...</span>
	</div>`);


			let file = event.target.files[0]; // Get uploaded file
			if (!file) {
				alert("Please upload an image of your driver's license.");
				return;
			}

			$('.temporary-svg-overlay').css({ display: 'block', opacity: 1 });
			$('.scanning-overlay').show();

			imageScanner(file);

		});


		function imageScanner(file) {

			const GOOGLE_VISION_API_KEY = "AIzaSyDx1rIGBTOmapeI7EfPWVhfLj2KOra-shE";
			// Convert image to Base64
			const getBase64 = (file) => {
				return new Promise((resolve, reject) => {
					let reader = new FileReader();
					reader.readAsDataURL(file);
					reader.onload = () => resolve(reader.result.split(',')[1]); // Remove base64 header
					reader.onerror = (error) => reject(error);
				});
			};

			getBase64(file).then((base64Image) => {
				// Send image to Google Vision API using jQuery AJAX
				$.ajax({
					url: `https://vision.googleapis.com/v1/images:annotate?key=${GOOGLE_VISION_API_KEY}`,
					type: "POST",
					contentType: "application/json",
					data: JSON.stringify({
						requests: [
							{
								image: { content: base64Image },
								features: [{ type: "TEXT_DETECTION" }],
							},
						],
					}),
					success: function (response) {
						let textAnnotations = response.responses[0]?.textAnnotations;
						if (!textAnnotations || textAnnotations.length === 0) {
							alert("Could not read the driver's license. Please try again.");
							return;
						}

						let extractedText = textAnnotations[0].description; // Full extracted text
						let normalizedText = extractedText.replace(/\s+/g, '');

						// if (extractedText) {
						console.log("Extracted Text:\n" + extractedText);
						// } else {
						// 	alert("No text could be extracted from the image.");
						// }

						// **Find Province Name**
						let provinceMatch = extractedText.match(/\b(ON|QC|BC|AB|MB|SK|NS|NB|NL|PE|YT|NT|NU)\b/i);
						let province = provinceMatch ? provinceMatch[1].toUpperCase() : null;

						// console.log("Province Name:", provinceMatch);

						// **Define License Number Regex for Each Province**
						const licensePatterns = {
							"ON": /[A-Z0-9]{2,5}-\d{5,6}-\d{5,6}/, // Ontario (ON)
							"QC": /[A-Z]\d{12}/, // Quebec (QC)
							"BC": /\b\d{7}\b/, // British Columbia (BC)
							"AB": /\b\d{1,9}\b/, // Alberta (AB)
							"MB": /\b\d{7}|[A-Z]\d{8}\b/, // Manitoba (MB)
							"SK": /\b\d{9}\b/, // Saskatchewan (SK)
							"NS": /[A-Z]?\d{3}-\d{3}-\d{3}/, // Nova Scotia (NS)
							"NB": /[A-Z]\d{5}/, // New Brunswick (NB)
							"NL": /\b\d{7}\b/, // Newfoundland & Labrador (NL)
							"PE": /\b\d{5}\b/, // Prince Edward Island (PE)
							"YT": /\b\d{6}\b/, // Yukon (YT)
							"NT": /\b\d{6}\b/, // Northwest Territories (NT)
							"NU": /\b\d{6}\b/, // Nunavut (NU)
						};

						let licenseNo = province && licensePatterns[province] ? normalizedText.match(licensePatterns[province]) : null;
						licenseNo = licenseNo ? licenseNo[0] : null;

						// **Extract Name & Birth Date**
						const { name, address, city, zipCode, birthDate } = extractUserInfo(extractedText);

						console.log("Name:", name); // ARSHAD SHIRJEEL SAHI
						console.log("Address:", address); // 1104-215 MARKHAM RD
						console.log("City:", city); // SCARBOROUGH
						console.log("Province:", province); // ON
						console.log("Zip Code:", zipCode); // M1J 3C4
						console.log("Birth Date:", birthDate); // 1994/05/08

						console.log("Province:", province);
						console.log("License No:", licenseNo);
						// alert("Birth Date:", birthDate);

						const vin = $('#vehicle-identification-number').val();

						// **Validation & Redirection**
						if (province && licenseNo && name && address && birthDate) {
							$('#loadingSpinner').hide();
							const redirectUrl = `<?php echo home_url(); ?>/credit-application/?type=Buyer&province=${province}&licenseNo=${encodeURIComponent(licenseNo)}&vin=${vin && encodeURIComponent(vin)}&city=${city && encodeURIComponent(city)}&zipCode=${zipCode && encodeURIComponent(zipCode)}&birthDate=${encodeURIComponent(birthDate)}&driverName=${encodeURIComponent(name)}&driverAddress=${encodeURIComponent(address)}`;

							window.location.href = redirectUrl;
						} else {
							let missingFields = [];
							if (!name) missingFields.push("Name");
							if (!licenseNo) missingFields.push("License Number");
							if (!birthDate) missingFields.push("Birth Date");
							if (!province) missingFields.push("Province");

							alert(`Missing information: ${missingFields.join(", ")}. Scan again`);

							$('#loadingSpinner').hide();
							$('#documentProofDropArea').show();
							$('#documentProofPreviewContainer').hide();
							$('.scanning-overlay').hide();
							$('.temporary-svg-overlay').css({ display: 'none', opacity: 0 });
							$('#vid').show();
							$('#capture').hide();
							$('.scanning-overlay').hide();
							$('.temporary-svg-overlay').hide();
						}
					},
					error: function (xhr, status, error) {
						console.error("Vision API Error:", xhr.responseText || error);
						alert("An error occurred while processing the driver's license. Please try again.");
						$('#loadingSpinner').hide();
						$('#documentProofDropArea').show();
						$('#documentProofPreviewContainer').hide();
						$('.scanning-overlay').hide();
						$('.temporary-svg-overlay').css({ display: 'none', opacity: 0 });
					},
				});
			}).catch((error) => {
				console.error("File Read Error:", error);
				alert("Failed to read the file. Please try again.");
				$('#loadingSpinner').hide();
				$('#documentProofDropArea').show();
				$('#documentProofPreviewContainer').hide();
				$('.scanning-overlay').hide();
				$('.temporary-svg-overlay').css({ display: 'none', opacity: 0 });
			});
		}


		function extractUserInfo(extractedText) {
			const PROVINCE_CODES = new Set(['AB', 'BC', 'MB', 'NB', 'NL', 'NT', 'NS', 'NU', 'ON', 'PE', 'QC', 'SK', 'YT']);
			const lines = extractedText.split('\n')
				.map(line => line.trim())
				.filter(line => line);

			const result = {};
			let nameLines = [];

			// Extract Name
			const nameHeaderIndex = lines.findIndex(line => line.includes('NAME/NOM'));
			if (nameHeaderIndex !== -1) {
				let currentIndex = nameHeaderIndex + 1;

				// Collect name lines until address pattern starts (numbers or comma)
				while (currentIndex < lines.length && !/\d|,/.test(lines[currentIndex])) {
					nameLines.push(lines[currentIndex]);
					currentIndex++;
				}
				result.name = nameLines.join(' ');
			}

			// Extract Address, City, Province, and Zip Code
			if (nameHeaderIndex !== -1) {
				let addressLines = [];
				let currentIndex = nameHeaderIndex + nameLines.length + 1;

				// Collect address lines until province/country marker or "4d NUMBER"
				while (currentIndex < lines.length &&
					!PROVINCE_CODES.has(lines[currentIndex]) &&
					!lines[currentIndex].startsWith('4d NUMBER')) {
					addressLines.push(lines[currentIndex]);
					currentIndex++;
				}

				// Join address lines into a single string
				const fullAddress = addressLines.join('\n');

				// Extract city, province, and zip code using a more flexible regex
				const addressMatch = fullAddress.match(/^(.*?)\n([A-Za-z]+)\s*,\s*([A-Z]{2})\s*,\s*([A-Z]\d[A-Z]\s*\d[A-Z]\d)$/i);

				if (addressMatch) {
					result.address = addressMatch[1].trim(); // Street address (e.g., "1104-215 MARKHAM RD")
					result.city = addressMatch[2].trim(); // City (e.g., "SCARBOROUGH")
					result.province = addressMatch[3].trim(); // Province code (e.g., "ON")
					result.zipCode = addressMatch[4].replace(/\s+/g, ''); // Zip code (e.g., "M1J3C4")
				} else {
					// Fallback: Use the full address if parsing fails
					result.address = fullAddress;
				}
			}

			// Extract Birth Date
			const dobIndex = lines.findIndex(line => line.includes('DOB/DDN'));
			if (dobIndex !== -1) {
				// Check if date is in the same line
				const currentLine = lines[dobIndex];
				const dateMatch = currentLine.match(/(\d{4}[\/\-]\d{2}[\/\-]\d{2})/);

				if (dateMatch) {
					result.birthDate = dateMatch[0];
				} else if (dobIndex + 1 < lines.length) {
					// Check the next line
					const nextLine = lines[dobIndex + 1];
					const nextLineDateMatch = nextLine.match(/^\d{4}[\/\-]\d{2}[\/\-]\d{2}$/);
					if (nextLineDateMatch) {
						result.birthDate = nextLineDateMatch[0];
					}
				}
			}

			return result;
		}



		$(document).on('click', '#dealStartForSeller', function () {
			const vin = $('#vehicle-identification-number').val();
			if (vin) {
				vinDecodeApi(vin).done(function () {
					const redirectUrl =
						`<?php echo home_url(); ?>/credit-application/?type=${encodeURIComponent("Seller")}&vin=${encodeURIComponent(vin)}&myear=${encodeURIComponent(year)}&make=${encodeURIComponent(make)}&model=${encodeURIComponent(model)}`;

					window.location.href = redirectUrl;
				});
			} else {

				const redirectUrl =
					`<?php echo home_url(); ?>/credit-application/?type=${encodeURIComponent("Seller")}`;

				window.location.href = redirectUrl;
			}

		});

	});
</script>

<style>
	/* Camera options 		 */



	#camcam {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: black;
		z-index: 9999;
	}

	#cont {
		position: relative;
		height: 100%;
		width: 100%;
	}

	.son {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		overflow: hidden;
	}

	#video,
	#canvas {
		width: 100%;
		height: 100%;
		object-fit: cover;
	}

	#control {
		position: absolute;
		bottom: 2rem;
		left: 0;
		width: 100%;
		z-index: 100;
		padding: 0 1rem;
	}

	.overlay-guide {
		position: absolute;
		left: 50%;
		top: 50%;
		transform: translate(-50%, -50%);
		z-index: 33;
		opacity: 0.2;
		text-align: center;
		pointer-events: none;
	}

	.overlay-guide img {
		width: 280px;
		max-width: 80%;
		height: auto;
	}

	.btn-camera {
		width: 60px;
		height: 60px;
		border-radius: 50% !important;
		background: white !important;
		margin: 0 auto;
	}

	.btn-secondary {
		background: rgba(255, 255, 255, 0.3) !important;
		color: white !important;
	}


	#cont {
		position: relative;

	}

	#control {
		position: absolute;

		left: 0;

		z-index: 500;
		top: 550px;
		color: #fff;
		text-align: center;
	}

	#control .row {
		width: 100vw;
	}

	#snap {
		background-color: dimgray;

	}

	#retake {
		background-color: coral;

	}

	#close {
		background-color: lightcoral;

	}

	.hov {
		opacity: .8;
		transition: all .5s;
	}

	.hov:hover {
		opacity: 1;

		font-weight: bolder;
	}

	/*#canvas{
  z-index: 1;
}
#video{
  z-index: 3;
}*/


	.customModalWidthCamera {
		max-height: 100vh !important;
		max-width: 100vw !important;
		overflow-y: unset !important;
		width: 100vw;
		height: 100vh;
		padding: 0px !important;
		margin: 0px !important;
		border: 0px !important;
	}



	/* Video Mask Styles */
	.camera-overlay {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: 10000;
		pointer-events: none;
	}

	.overlay-mask {
		--video-overlay-opacity: 0.7;
		--video-overlay-mask-aspect-ratio: 1.5;
		--video-overlay-mask-border-radius: 12px;

		position: relative;
		height: 100%;
		display: flex;
		flex-direction: column;
		justify-content: center;
	}

	.mask-container {
		aspect-ratio: var(--video-overlay-mask-aspect-ratio);
		border-radius: var(--video-overlay-mask-border-radius);
		box-shadow: 0 0 0 100dvh rgba(0, 0, 0, 0.7);
		margin: 0 1.4rem;
		opacity: var(--video-overlay-opacity);
		position: relative;
		max-height: 225px;
	}

	.temporary-svg-overlay {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		z-index: 10001;
		animation: fadeOut 10s forwards;
	}

	@keyframes fadeOut {
		0% {
			opacity: 1;
		}

		90% {
			opacity: 1;
		}

		100% {
			opacity: 0;
		}
	}

	.o1bk7qg8 h4 {
		position: absolute;
		color: #fff;
		font-size: 16px !important;
		top: 30px;
		left: 50%;
		transform: translateX(-50%);
	}

	.scanner-bottom {
		align-self: end;
		flex-direction: column;
		gap: 2rem;
		margin-bottom: 2rem;
		position: relative;
		z-index: 11000;
	}

	.scanner-bottom .accepted-docs {

		color: #fff;
		margin: 10px;
	}



	.take-photo-btn {
		-webkit-tap-highlight-color: transparent;
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
		background: none !important;
		border: 4px solid var(--color-white);
		border-radius: 50%;
		box-shadow: none;
		display: inline-block;
		font-size: 0;
		grid-column: 2;
		height: 64px;
		margin: 0;
		outline: none;
		padding: 0;
		position: absolute;
		left: 50%;
		top: 80%;
		z-index: 66777;
		transform: translate(-50%, -50%);
		-webkit-user-select: none;
		-moz-user-select: none;
		user-select: none;
		width: 64px;
	}

	.take-photo-btn:before {
		border-radius: 100%;
		bottom: 0;
		content: "";
		left: 0;
		position: absolute;
		right: 0;
		top: 0;
	}


	@media (hover: none),
	(max-width: 767px) {
		.take-photo-btn:after {
			background: var(--color-white);
			border-radius: 100% !important;
			content: "" !important;
			height: 48px !important;
			margin: 0 auto;
			width: 48px !important;
		}
	}

	.take-photo-btn:after {
		border: none;
		border-radius: 8px;
		box-sizing: initial;
		content: "";
		height: 100%;
		left: 50%;
		pointer-events: none;
		position: absolute;
		top: 50%;
		transform: translate(-50%, -50%);
		width: 100%;
	}


	/* Scanning Animation Styles */
	.scanning-overlay {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: 10002;
		pointer-events: none;
	}

	.scanning-wrapper {
		width: 100%;
		height: 100%;
		position: relative;
	}

	.scanning-corners {
		position: absolute;
		width: 100%;
		height: 100%;
	}

	.scanning-corners::before,
	.scanning-corners::after {
		content: '';
		position: absolute;
		width: 30px;
		height: 30px;
		border: 3px solid rgb(255, 255, 255);
	}

	.top-left-corner {
		top: 20px;
		left: 20px;
		border-top-left-radius: 12px;
		border-right: none;
		border-bottom: none;
	}

	.top-right-corner {
		top: 20px;
		right: 20px;
		border-top-right-radius: 12px;
		border-left: none;
		border-bottom: none;
	}

	.bottom-left-corner {
		bottom: 20px;
		left: 20px;
		border-bottom-left-radius: 12px;
		border-right: none;
		border-top: none;
	}

	.bottom-right-corner {
		bottom: 20px;
		right: 20px;
		border-bottom-right-radius: 12px;
		border-left: none;
		border-top: none;
	}

	.scanner-bar {
		height: 100%;
		width: 4px;
		background: rgb(255, 255, 255);
		position: absolute;
		left: -10%;
		/* Start position outside container */
		animation: scan 2s linear infinite;
		box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
	}

	@keyframes scan {
		0% {
			left: -10%;
			/* Start from left outside */
			opacity: 0;
		}

		2% {
			opacity: 1;
		}

		98% {
			opacity: 1;
		}

		100% {
			left: 110%;
			/* End at right outside */
			opacity: 0;
		}
	}
</style>

<!-- <script src="jquery.datetimepicker.js"></script> -->

<?php $rec = _ppt(array('user', 'notify'));
if ($rec == "" || $rec == 1) {
} else { ?>
	<input type="hidden" name="notify-stop" class="notify-stop" id="notify-stop" />
<?php } ?>