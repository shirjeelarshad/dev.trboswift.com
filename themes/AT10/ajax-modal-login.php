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

global $CORE;


if (!_ppt_checkfile("ajax-modal-login.php")) {
	?>


	<style>
		.login-modal-container {
			border-radius: 20px;

		}

		.header-top-btn {
			border-radius: 10px;

		}

		.header-topbtn-login-active {
			border-top-right-radius: 10px;
			border-bottom-right-radius: 10px;
			background: #efa404;
		}


		.login-modal-close {
			position: absolute;
			right: -30px;
			top: -30px;
			color: #fcfcfc;
		}




		.form-control {
			border-radius: 10px;
		}

		.submitbtn {
			border-radius: 50px;

		}

		label {

			font-size: 14px;
			color: #3F3F3F;
		}
	</style>



	<div class="bg-white mb-5" style="border-radius:20px;margin-top:50px;overflow: hidden;"
		class="<?php if (isset($GLOBALS['flag-login'])) { ?>card shadow-sm<?php } ?>">

		<div class="d-flex justify-content-center pt-3">
			<div style="max-width:120px; text-align:center;"><?php echo $CORE->LAYOUT("get_logo", "light"); ?></div>
		</div>


		<div class="card-body p-0 p-md-2">



			<div class="px-md-5">

				<div class="loginHeader text-center">
					<h2 class="text-secondary font-weight-bold p-2"><?php echo __("SIGN IN", "premiumpress") ?></h2>

					<span>Welcome! Please log in to view the status of your financing or escrow application and to begin a
						new transaction.</span>
				</div>


				<?php if (defined('WLT_DEMOMODE') && strpos($_SERVER['HTTP_HOST'], "premiummod.com") !== false && !isset($_GET['admindemo'])) { ?>
					<div class="alert alert-success"><i class="fa fa-user-circle mr-2"></i> <strong>Username: demo / Password :
							demo</strong></div>
				<?php } ?>
				<div id="login_form_message"></div>







				<?php if (defined('WLT_DEMOMODE') && isset($_GET['admindemo'])) { ?>
					<script>
						jQuery(document).ready(function () {
							jQuery("form#loginform").submit();
						});
					</script>
				<?php } ?>

			</div>



			<script>
				function login_process() {

					var user_login = document.getElementById("user_login");
					var user_pass = document.getElementById("user_pass");

					canContinue = true;

					if (user_login.value == '') {
						jQuery("#login_form_message").addClass('text-danger mb-4').html(
							"<?php echo __("Please complete all required fields.", "premiumpress") ?>");
						user_login.style.border = 'thin solid red';
						canContinue = false;
					}

					if (user_pass.value == '') {
						jQuery("#login_form_message").addClass('text-danger mb-4').html(
							"<?php echo __("Please complete all required fields.", "premiumpress") ?>");
						user_pass.focus();
						user_pass.style.border = 'thin solid red';
						canContinue = false;
					}

					if (canContinue) {

						var formd = jQuery("#form_user_login").serialize();

						jQuery('#login_form_message').html(
							'<div class="text-center text-primary"><i class="fa fa-spinner fa-3x fa-spin"></i></div>');
						jQuery('#form_user_login').hide();
						jQuery('.loginbottomextras').hide();

						jQuery.ajax({
							type: "POST",
							url: ajax_site_url,
							dataType: 'json',
							data: {
								action: "login_process",
								formdata: formd,
							},
							success: function (response) {

								if (response.status == "error") {

									jQuery("#login_form_message").addClass('text-danger mb-4').html(response.msg);

									jQuery('#form_user_login').show();
									jQuery('.loginbottomextras').show();

								} else if (response.status == "func_mem") {

									jQuery(".login-modal-wrap").fadeOut(400);
									processPayment(response.link, response.msg);

								} else if (response.status == "reload") {

									window.location.reload();

								} else if (response.status == "ok") {


									const urlLoginParams = new URLSearchParams(window.location.search);
									const page_type = urlLoginParams.get('page_type');

									function getPagePath() {
										// Get the full URL
										const url = window.location.href;

										// Create a URL object
										const urlObj = new URL(url);

										// Extract the pathname (e.g., "/escrow-back-end/")
										const pathname = urlObj.pathname;

										// Remove leading and trailing slashes and return the path
										return pathname.replace(/^\/|\/$/g, '');
									}

									// Get the current page path
									const pagePath = getPagePath();

									if (pagePath === 'escrow-back-end' || pagePath === 'credit-application') {
										window.location.reload();
									} else if (page_type === 'escrow') {

										window.location.href =
											'<?php echo home_url(); ?>/account/?showtab=escrow';
									} else if (page_type === 'finance') {

										window.location.href =
											'<?php echo home_url(); ?>/account/?showtab=financing';

									} else {
										window.location.href = '<?php echo home_url(); ?>/account';
									}


									// 			window.location.href= response.link;


								}

							},
							error: function (e) {
								console.log(e)
							}
						});

					}

				}
			</script>

			<script>
				function agreeDisclaimer() {
					// If the user clicks "Agree," load the page
					window.location.href = '<?php echo home_url(); ?>/account/';
				}

				function disagreeDisclaimer() {

					// If the user clicks "Disagree," redirect to example.com/home
					window.location.href =
						'<?php echo home_url(); ?>/wp-login.php?action=logout';
				}
			</script>



			<div class="loginWithPhoneForm mt-3">
				<div class="loginOtpSendCodeSection">
					<div class="col-12">
						<label>Country code</label>
						<div class="country ">
							<div id="country" class="select"><i class="flagstrap-icon flagstrap-ca"></i>Canada (+1)</div>
							<div id="country-drop" class="dropdown">
								<ul>
									<li data-code="AF" data-name="Afghanistan" data-cid="c32"><i
											class="flagstrap-icon"></i>Afghanistan (+93)</li>
									<li data-code="AL" data-name="Albania" data-cid="c33"><i
											class="flagstrap-icon"></i>Albania (+355)</li>
									<li data-code="DZ" data-name="Algeria" data-cid="c34"><i
											class="flagstrap-icon"></i>Algeria (+213)</li>
									<li data-code="AS" data-name="American Samoa" data-cid="c35"><i
											class="flagstrap-icon"></i>American Samoa (+1-684)</li>
									<li data-code="AD" data-name="Andorra" data-cid="c36"><i
											class="flagstrap-icon"></i>Andorra (+376)</li>
									<li data-code="AO" data-name="Angola" data-cid="c37"><i
											class="flagstrap-icon"></i>Angola (+244)</li>
									<li data-code="AI" data-name="Anguilla" data-cid="c38"><i
											class="flagstrap-icon"></i>Anguilla (+1-264)</li>
									<li data-code="AG" data-name="Antigua and Barbuda" data-cid="c39"><i
											class="flagstrap-icon"></i>Antigua and Barbuda (+1-268)</li>
									<li data-code="AR" data-name="Argentina" data-cid="c40"><i
											class="flagstrap-icon"></i>Argentina (+54)</li>
									<li data-code="AM" data-name="Armenia" data-cid="c41"><i
											class="flagstrap-icon"></i>Armenia (+374)</li>
									<li data-code="AW" data-name="Aruba" data-cid="c42"><i class="flagstrap-icon"></i>Aruba
										(+297)</li>
									<li data-code="AU" data-name="Australia" data-cid="c43"><i
											class="flagstrap-icon"></i>Australia (+61)</li>
									<li data-code="AT" data-name="Austria" data-cid="c44"><i
											class="flagstrap-icon"></i>Austria (+43)</li>
									<li data-code="AZ" data-name="Azerbaijan" data-cid="c45"><i
											class="flagstrap-icon"></i>Azerbaijan (+994)</li>
									<li data-code="BS" data-name="Bahamas" data-cid="c46"><i
											class="flagstrap-icon"></i>Bahamas (+1-242)</li>
									<li data-code="BH" data-name="Bahrain" data-cid="c47"><i
											class="flagstrap-icon"></i>Bahrain (+973)</li>
									<li data-code="BD" data-name="Bangladesh" data-cid="c48"><i
											class="flagstrap-icon"></i>Bangladesh (+880)</li>
									<li data-code="BB" data-name="Barbados" data-cid="c49"><i
											class="flagstrap-icon"></i>Barbados (+1-246)</li>
									<li data-code="BY" data-name="Belarus" data-cid="c50"><i
											class="flagstrap-icon"></i>Belarus (+375)</li>
									<li data-code="BE" data-name="Belgium" data-cid="c51"><i
											class="flagstrap-icon"></i>Belgium (+32)</li>
									<li data-code="BZ" data-name="Belize" data-cid="c52"><i
											class="flagstrap-icon"></i>Belize (+501)</li>
									<li data-code="BJ" data-name="Benin" data-cid="c53"><i class="flagstrap-icon"></i>Benin
										(+229)</li>
									<li data-code="BM" data-name="Bermuda" data-cid="c54"><i
											class="flagstrap-icon"></i>Bermuda (+1-441)</li>
									<li data-code="BT" data-name="Bhutan" data-cid="c55"><i
											class="flagstrap-icon"></i>Bhutan (+975)</li>
									<li data-code="BO" data-name="Bolivia" data-cid="c56"><i
											class="flagstrap-icon"></i>Bolivia (+591)</li>
									<li data-code="BA" data-name="Bosnia and Herzegovina" data-cid="c57"><i
											class="flagstrap-icon"></i>Bosnia and Herzegovina (+387)</li>
									<li data-code="BW" data-name="Botswana" data-cid="c58"><i
											class="flagstrap-icon"></i>Botswana (+267)</li>
									<li data-code="BR" data-name="Brazil" data-cid="c59"><i
											class="flagstrap-icon"></i>Brazil (+55)</li>
									<li data-code="IO" data-name="British Indian Ocean Territory" data-cid="c60"><i
											class="flagstrap-icon"></i>British Indian Ocean Territory (+246)</li>
									<li data-code="" data-name="British Virgin Islands" data-cid="c61"><i
											class="flagstrap-icon"></i>British Virgin Islands (+1-284)</li>
									<li data-code="BN" data-name="Brunei" data-cid="c62"><i
											class="flagstrap-icon"></i>Brunei (+673)</li>
									<li data-code="BG" data-name="Bulgaria" data-cid="c63"><i
											class="flagstrap-icon"></i>Bulgaria (+359)</li>
									<li data-code="BF" data-name="Burkina Faso" data-cid="c64"><i
											class="flagstrap-icon"></i>Burkina Faso (+226)</li>
									<li data-code="BI" data-name="Burundi" data-cid="c65"><i
											class="flagstrap-icon"></i>Burundi (+257)</li>
									<li data-code="KH" data-name="Cambodia" data-cid="c66"><i
											class="flagstrap-icon"></i>Cambodia (+855)</li>
									<li data-code="CM" data-name="Cameroon" data-cid="c67"><i
											class="flagstrap-icon"></i>Cameroon (+237)</li>
									<li data-code="CA" data-name="Canada" data-cid="c68"><i
											class="flagstrap-icon"></i>Canada (+1)</li>
									<li data-code="CV" data-name="Cape Verde" data-cid="c69"><i
											class="flagstrap-icon"></i>Cape Verde (+238)</li>
									<li data-code="KY" data-name="Cayman Islands" data-cid="c70"><i
											class="flagstrap-icon"></i>Cayman Islands (+1-345)</li>
									<li data-code="CF" data-name="Central African Republic" data-cid="c71"><i
											class="flagstrap-icon"></i>Central African Republic (+236)</li>
									<li data-code="TD" data-name="Chad" data-cid="c72"><i class="flagstrap-icon"></i>Chad
										(+235)</li>
									<li data-code="CL" data-name="Chile" data-cid="c73"><i class="flagstrap-icon"></i>Chile
										(+56)</li>
									<li data-code="CN" data-name="China" data-cid="c74"><i class="flagstrap-icon"></i>China
										(+86)</li>
									<li data-code="" data-name="Christmas Island" data-cid="c75"><i
											class="flagstrap-icon"></i>Christmas Island (+61)</li>
									<li data-code="" data-name="Cocos Islands" data-cid="c76"><i
											class="flagstrap-icon"></i>Cocos Islands (+61)</li>
									<li data-code="CO" data-name="Colombia" data-cid="c77"><i
											class="flagstrap-icon"></i>Colombia (+57)</li>
									<li data-code="KM" data-name="Comoros" data-cid="c78"><i
											class="flagstrap-icon"></i>Comoros (+269)</li>
									<li data-code="CK" data-name="Cook Islands" data-cid="c79"><i
											class="flagstrap-icon"></i>Cook Islands (+682)</li>
									<li data-code="CR" data-name="Costa Rica" data-cid="c80"><i
											class="flagstrap-icon"></i>Costa Rica (+506)</li>
									<li data-code="HR" data-name="Croatia" data-cid="c81"><i
											class="flagstrap-icon"></i>Croatia (+385)</li>
									<li data-code="CU" data-name="Cuba" data-cid="c82"><i class="flagstrap-icon"></i>Cuba
										(+53)</li>
									<li data-code="CY" data-name="Cyprus" data-cid="c83"><i
											class="flagstrap-icon"></i>Cyprus (+357)</li>
									<li data-code="CZ" data-name="Czech Republic" data-cid="c84"><i
											class="flagstrap-icon"></i>Czech Republic (+420)</li>
									<li data-code="CD" data-name="Democratic Republic of the Congo" data-cid="c85"><i
											class="flagstrap-icon"></i>Democratic Republic of the Congo (+243)</li>
									<li data-code="DK" data-name="Denmark" data-cid="c86"><i
											class="flagstrap-icon"></i>Denmark (+45)</li>
									<li data-code="DJ" data-name="Djibouti" data-cid="c87"><i
											class="flagstrap-icon"></i>Djibouti (+253)</li>
									<li data-code="DM" data-name="Dominica" data-cid="c88"><i
											class="flagstrap-icon"></i>Dominica (+1-767)</li>
									<li data-code="DO" data-name="Dominican Republic" data-cid="c89"><i
											class="flagstrap-icon"></i>Dominican Republic (+1-809)</li>
									<li data-code="DO" data-name="Dominican Republic" data-cid="c90"><i
											class="flagstrap-icon"></i>Dominican Republic (+1-829)</li>
									<li data-code="" data-name="East Timor" data-cid="c91"><i
											class="flagstrap-icon"></i>East Timor (+670)</li>
									<li data-code="EC" data-name="Ecuador" data-cid="c92"><i
											class="flagstrap-icon"></i>Ecuador (+593)</li>
									<li data-code="EG" data-name="Egypt" data-cid="c93"><i class="flagstrap-icon"></i>Egypt
										(+20)</li>
									<li data-code="SV" data-name="El Salvador" data-cid="c94"><i
											class="flagstrap-icon"></i>El Salvador (+503)</li>
									<li data-code="GQ" data-name="Equatorial Guinea" data-cid="c95"><i
											class="flagstrap-icon"></i>Equatorial Guinea (+240)</li>
									<li data-code="ER" data-name="Eritrea" data-cid="c96"><i
											class="flagstrap-icon"></i>Eritrea (+291)</li>
									<li data-code="EE" data-name="Estonia" data-cid="c97"><i
											class="flagstrap-icon"></i>Estonia (+372)</li>
									<li data-code="ET" data-name="Ethiopia" data-cid="c98"><i
											class="flagstrap-icon"></i>Ethiopia (+251)</li>
									<li data-code="FK" data-name="Falkland Islands" data-cid="c99"><i
											class="flagstrap-icon"></i>Falkland Islands (+500)</li>
									<li data-code="FO" data-name="Faroe Islands" data-cid="c100"><i
											class="flagstrap-icon"></i>Faroe Islands (+298)</li>
									<li data-code="FJ" data-name="Fiji" data-cid="c101"><i class="flagstrap-icon"></i>Fiji
										(+679)</li>
									<li data-code="FI" data-name="Finland" data-cid="c102"><i
											class="flagstrap-icon"></i>Finland (+358)</li>
									<li data-code="FR" data-name="France" data-cid="c103"><i
											class="flagstrap-icon"></i>France (+33)</li>
									<li data-code="PF" data-name="French Polynesia" data-cid="c104"><i
											class="flagstrap-icon"></i>French Polynesia (+689)</li>
									<li data-code="GA" data-name="Gabon" data-cid="c105"><i class="flagstrap-icon"></i>Gabon
										(+241)</li>
									<li data-code="GM" data-name="Gambia" data-cid="c106"><i
											class="flagstrap-icon"></i>Gambia (+220)</li>
									<li data-code="GE" data-name="Georgia" data-cid="c107"><i
											class="flagstrap-icon"></i>Georgia (+995)</li>
									<li data-code="DE" data-name="Germany" data-cid="c108"><i
											class="flagstrap-icon"></i>Germany (+49)</li>
									<li data-code="GH" data-name="Ghana" data-cid="c109"><i class="flagstrap-icon"></i>Ghana
										(+233)</li>
									<li data-code="GI" data-name="Gibraltar" data-cid="c110"><i
											class="flagstrap-icon"></i>Gibraltar (+350)</li>
									<li data-code="GR" data-name="Greece" data-cid="c111"><i
											class="flagstrap-icon"></i>Greece (+30)</li>
									<li data-code="GL" data-name="Greenland" data-cid="c112"><i
											class="flagstrap-icon"></i>Greenland (+299)</li>
									<li data-code="GD" data-name="Grenada" data-cid="c113"><i
											class="flagstrap-icon"></i>Grenada (+1-473)</li>
									<li data-code="GU" data-name="Guam" data-cid="c114"><i class="flagstrap-icon"></i>Guam
										(+1-671)</li>
									<li data-code="GT" data-name="Guatemala" data-cid="c115"><i
											class="flagstrap-icon"></i>Guatemala (+502)</li>
									<li data-code="GN" data-name="Guinea" data-cid="c116"><i
											class="flagstrap-icon"></i>Guinea (+224)</li>
									<li data-code="GN" data-name="Guinea" data-cid="c117"><i
											class="flagstrap-icon"></i>Guinea (+245)</li>
									<li data-code="GN" data-name="Guyana" data-cid="c118"><i
											class="flagstrap-icon"></i>Guyana (+592)</li>
									<li data-code="HT" data-name="Haiti" data-cid="c119"><i class="flagstrap-icon"></i>Haiti
										(+509)</li>
									<li data-code="HN" data-name="Honduras" data-cid="c120"><i
											class="flagstrap-icon"></i>Honduras (+504)</li>
									<li data-code="HK" data-name="Hong Kong" data-cid="c121"><i
											class="flagstrap-icon"></i>Hong Kong (+852)</li>
									<li data-code="HU" data-name="Hungary" data-cid="c122"><i
											class="flagstrap-icon"></i>Hungary (+36)</li>
									<li data-code="IS" data-name="Iceland" data-cid="c123"><i
											class="flagstrap-icon"></i>Iceland (+354)</li>
									<li data-code="IN" data-name="India" data-cid="c124"><i class="flagstrap-icon"></i>India
										(+91)</li>
									<li data-code="ID" data-name="Indonesia" data-cid="c125"><i
											class="flagstrap-icon"></i>Indonesia (+62)</li>
									<li data-code="IR" data-name="Iran" data-cid="c126"><i class="flagstrap-icon"></i>Iran
										(+98)</li>
									<li data-code="IQ" data-name="Iraq" data-cid="c127"><i class="flagstrap-icon"></i>Iraq
										(+964)</li>
									<li data-code="IE" data-name="Ireland" data-cid="c128"><i
											class="flagstrap-icon"></i>Ireland (+353)</li>
									<li data-code="IM" data-name="Isle of Man" data-cid="c129"><i
											class="flagstrap-icon"></i>Isle of Man (+44-1624)</li>
									<li data-code="IL" data-name="Israel" data-cid="c130"><i
											class="flagstrap-icon"></i>Israel (+972)</li>
									<li data-code="IT" data-name="Italy" data-cid="c131"><i class="flagstrap-icon"></i>Italy
										(+39)</li>
									<li data-code="" data-name="Ivory Coast" data-cid="c132"><i
											class="flagstrap-icon"></i>Ivory Coast (+225)</li>
									<li data-code="JM" data-name="Jamaica" data-cid="c133"><i
											class="flagstrap-icon"></i>Jamaica (+1-876)</li>
									<li data-code="JP" data-name="Japan" data-cid="c134"><i class="flagstrap-icon"></i>Japan
										(+81)</li>
									<li data-code="JE" data-name="Jersey" data-cid="c135"><i
											class="flagstrap-icon"></i>Jersey (+44-1534)</li>
									<li data-code="JO" data-name="Jordan" data-cid="c136"><i
											class="flagstrap-icon"></i>Jordan (+962)</li>
									<li data-code="KZ" data-name="Kazakhstan" data-cid="c137"><i
											class="flagstrap-icon"></i>Kazakhstan (+7)</li>
									<li data-code="KE" data-name="Kenya" data-cid="c138"><i class="flagstrap-icon"></i>Kenya
										(+254)</li>
									<li data-code="KI" data-name="Kiribati" data-cid="c139"><i
											class="flagstrap-icon"></i>Kiribati (+686)</li>
									<li data-code="KW" data-name="Kuwait" data-cid="c140"><i
											class="flagstrap-icon"></i>Kuwait (+965)</li>
									<li data-code="KG" data-name="Kyrgyzstan" data-cid="c141"><i
											class="flagstrap-icon"></i>Kyrgyzstan (+996)</li>
									<li data-code="LA" data-name="Laos" data-cid="c142"><i class="flagstrap-icon"></i>Laos
										(+856)</li>
									<li data-code="LV" data-name="Latvia" data-cid="c143"><i
											class="flagstrap-icon"></i>Latvia (+371)</li>
									<li data-code="LB" data-name="Lebanon" data-cid="c144"><i
											class="flagstrap-icon"></i>Lebanon (+961)</li>
									<li data-code="LS" data-name="Lesotho" data-cid="c145"><i
											class="flagstrap-icon"></i>Lesotho (+266)</li>
									<li data-code="LR" data-name="Liberia" data-cid="c146"><i
											class="flagstrap-icon"></i>Liberia (+231)</li>
									<li data-code="LY" data-name="Libya" data-cid="c147"><i class="flagstrap-icon"></i>Libya
										(+218)</li>
									<li data-code="LI" data-name="Liechtenstein" data-cid="c148"><i
											class="flagstrap-icon"></i>Liechtenstein (+423)</li>
									<li data-code="LT" data-name="Lithuania" data-cid="c149"><i
											class="flagstrap-icon"></i>Lithuania (+370)</li>
									<li data-code="LU" data-name="Luxembourg" data-cid="c150"><i
											class="flagstrap-icon"></i>Luxembourg (+352)</li>
									<li data-code="MO" data-name="Macao" data-cid="c151"><i class="flagstrap-icon"></i>Macao
										(+853)</li>
									<li data-code="MK" data-name="Macedonia" data-cid="c152"><i
											class="flagstrap-icon"></i>Macedonia (+389)</li>
									<li data-code="MG" data-name="Madagascar" data-cid="c153"><i
											class="flagstrap-icon"></i>Madagascar (+261)</li>
									<li data-code="MW" data-name="Malawi" data-cid="c154"><i
											class="flagstrap-icon"></i>Malawi (+265)</li>
									<li data-code="MY" data-name="Malaysia" data-cid="c155"><i
											class="flagstrap-icon"></i>Malaysia (+60)</li>
									<li data-code="MV" data-name="Maldives" data-cid="c156"><i
											class="flagstrap-icon"></i>Maldives (+960)</li>
									<li data-code="ML" data-name="Mali" data-cid="c157"><i class="flagstrap-icon"></i>Mali
										(+223)</li>
									<li data-code="MT" data-name="Malta" data-cid="c158"><i class="flagstrap-icon"></i>Malta
										(+356)</li>
									<li data-code="MH" data-name="Marshall Islands" data-cid="c159"><i
											class="flagstrap-icon"></i>Marshall Islands (+692)</li>
									<li data-code="MQ" data-name="Martinique" data-cid="c160"><i
											class="flagstrap-icon"></i>Martinique (+596)</li>
									<li data-code="MR" data-name="Mauritania" data-cid="c161"><i
											class="flagstrap-icon"></i>Mauritania (+222)</li>
									<li data-code="MU" data-name="Mauritius" data-cid="c162"><i
											class="flagstrap-icon"></i>Mauritius (+230)</li>
									<li data-code="YT" data-name="Mayotte" data-cid="c163"><i
											class="flagstrap-icon"></i>Mayotte (+262)</li>
									<li data-code="MX" data-name="Mexico" data-cid="c164"><i
											class="flagstrap-icon"></i>Mexico (+52)</li>
									<li data-code="FM" data-name="Micronesia" data-cid="c165"><i
											class="flagstrap-icon"></i>Micronesia (+691)</li>
									<li data-code="MD" data-name="Moldova" data-cid="c166"><i
											class="flagstrap-icon"></i>Moldova (+373)</li>
									<li data-code="MC" data-name="Monaco" data-cid="c167"><i
											class="flagstrap-icon"></i>Monaco (+377)</li>
									<li data-code="MN" data-name="Mongolia" data-cid="c168"><i
											class="flagstrap-icon"></i>Mongolia (+976)</li>
									<li data-code="ME" data-name="Montenegro" data-cid="c169"><i
											class="flagstrap-icon"></i>Montenegro (+382)</li>
									<li data-code="MS" data-name="Montserrat" data-cid="c170"><i
											class="flagstrap-icon"></i>Montserrat (+1-664)</li>
									<li data-code="MA" data-name="Morocco" data-cid="c171"><i
											class="flagstrap-icon"></i>Morocco (+212)</li>
									<li data-code="MZ" data-name="Mozambique" data-cid="c172"><i
											class="flagstrap-icon"></i>Mozambique (+258)</li>
									<li data-code="MM" data-name="Myanmar" data-cid="c173"><i
											class="flagstrap-icon"></i>Myanmar (+95)</li>
									<li data-code="NA" data-name="Namibia" data-cid="c174"><i
											class="flagstrap-icon"></i>Namibia (+264)</li>
									<li data-code="NR" data-name="Nauru" data-cid="c175"><i class="flagstrap-icon"></i>Nauru
										(+674)</li>
									<li data-code="NP" data-name="Nepal" data-cid="c176"><i class="flagstrap-icon"></i>Nepal
										(+977)</li>
									<li data-code="NL" data-name="Netherlands" data-cid="c177"><i
											class="flagstrap-icon"></i>Netherlands (+31)</li>
									<li data-code="" data-name="Netherlands Antilles" data-cid="c178"><i
											class="flagstrap-icon"></i>Netherlands Antilles (+599)</li>
									<li data-code="NC" data-name="New Caledonia" data-cid="c179"><i
											class="flagstrap-icon"></i>New Caledonia (+687)</li>
									<li data-code="NZ" data-name="New Zealand" data-cid="c180"><i
											class="flagstrap-icon"></i>New Zealand (+64)</li>
									<li data-code="NI" data-name="Nicaragua" data-cid="c181"><i
											class="flagstrap-icon"></i>Nicaragua (+505)</li>
									<li data-code="NE" data-name="Niger" data-cid="c182"><i class="flagstrap-icon"></i>Niger
										(+227)</li>
									<li data-code="NG" data-name="Nigeria" data-cid="c183"><i
											class="flagstrap-icon"></i>Nigeria (+234)</li>
									<li data-code="NU" data-name="Niue" data-cid="c184"><i class="flagstrap-icon"></i>Niue
										(+683)</li>
									<li data-code="" data-name="North Korea" data-cid="c185"><i
											class="flagstrap-icon"></i>North Korea (+850)</li>
									<li data-code="MP" data-name="Northern Mariana Islands" data-cid="c186"><i
											class="flagstrap-icon"></i>Northern Mariana Islands (+1-670)</li>
									<li data-code="NO" data-name="Norway" data-cid="c187"><i
											class="flagstrap-icon"></i>Norway (+47)</li>
									<li data-code="OM" data-name="Oman" data-cid="c188"><i class="flagstrap-icon"></i>Oman
										(+968)</li>
									<li data-code="PK" data-name="Pakistan" data-cid="c189"><i
											class="flagstrap-icon"></i>Pakistan (+92)</li>
									<li data-code="PW" data-name="Palau" data-cid="c190"><i class="flagstrap-icon"></i>Palau
										(+680)</li>
									<li data-code="PA" data-name="Panama" data-cid="c191"><i
											class="flagstrap-icon"></i>Panama (+507)</li>
									<li data-code="PG" data-name="Papua New Guinea" data-cid="c192"><i
											class="flagstrap-icon"></i>Papua New Guinea (+675)</li>
									<li data-code="PY" data-name="Paraguay" data-cid="c193"><i
											class="flagstrap-icon"></i>Paraguay (+595)</li>
									<li data-code="PE" data-name="Peru" data-cid="c194"><i class="flagstrap-icon"></i>Peru
										(+51)</li>
									<li data-code="PH" data-name="Philippines" data-cid="c195"><i
											class="flagstrap-icon"></i>Philippines (+63)</li>
									<li data-code="PN" data-name="Pitcairn" data-cid="c196"><i
											class="flagstrap-icon"></i>Pitcairn (+870)</li>
									<li data-code="PL" data-name="Poland" data-cid="c197"><i
											class="flagstrap-icon"></i>Poland (+48)</li>
									<li data-code="PT" data-name="Portugal" data-cid="c198"><i
											class="flagstrap-icon"></i>Portugal (+351)</li>
									<li data-code="PR" data-name="Puerto Rico (+1-787)" data-cid="c199"><i
											class="flagstrap-icon"></i>Puerto Rico (+1-787) (+1-787)</li>
									<li data-code="PR" data-name="Puerto Rico (+1-939)" data-cid="c200"><i
											class="flagstrap-icon"></i>Puerto Rico (+1-939) (+1-939)</li>
									<li data-code="QA" data-name="Qatar" data-cid="c201"><i class="flagstrap-icon"></i>Qatar
										(+974)</li>
									<li data-code="CG" data-name="Republic of the Congo" data-cid="c202"><i
											class="flagstrap-icon"></i>Republic of the Congo (+242)</li>
									<li data-code="RO" data-name="Romania" data-cid="c203"><i
											class="flagstrap-icon"></i>Romania (+40)</li>
									<li data-code="RU" data-name="Russia" data-cid="c204"><i
											class="flagstrap-icon"></i>Russia (+7)</li>
									<li data-code="RW" data-name="Rwanda" data-cid="c205"><i
											class="flagstrap-icon"></i>Rwanda (+250)</li>
									<li data-code="" data-name="Saint Barthelemy" data-cid="c206"><i
											class="flagstrap-icon"></i>Saint Barthelemy (+590)</li>
									<li data-code="SH" data-name="Saint Helena" data-cid="c207"><i
											class="flagstrap-icon"></i>Saint Helena (+290)</li>
									<li data-code="KN" data-name="Saint Kitts and Nevis" data-cid="c208"><i
											class="flagstrap-icon"></i>Saint Kitts and Nevis (+1-869)</li>
									<li data-code="LC" data-name="Saint Lucia" data-cid="c209"><i
											class="flagstrap-icon"></i>Saint Lucia (+1-758)</li>
									<li data-code="MF" data-name="Saint Martin" data-cid="c210"><i
											class="flagstrap-icon"></i>Saint Martin (+590)</li>
									<li data-code="PM" data-name="Saint Pierre and Miquelon" data-cid="c211"><i
											class="flagstrap-icon"></i>Saint Pierre and Miquelon (+508)</li>
									<li data-code="VC" data-name="Saint Vincent and the Grenadines" data-cid="c212"><i
											class="flagstrap-icon"></i>Saint Vincent and the Grenadines (+1-784)</li>
									<li data-code="WS" data-name="Samoa" data-cid="c213"><i class="flagstrap-icon"></i>Samoa
										(+685)</li>
									<li data-code="SM" data-name="San Marino" data-cid="c214"><i
											class="flagstrap-icon"></i>San Marino (+378)</li>
									<li data-code="ST" data-name="Sao Tome and Principe" data-cid="c215"><i
											class="flagstrap-icon"></i>Sao Tome and Principe (+239)</li>
									<li data-code="SA" data-name="Saudi Arabia" data-cid="c216"><i
											class="flagstrap-icon"></i>Saudi Arabia (+966)</li>
									<li data-code="SN" data-name="Senegal" data-cid="c217"><i
											class="flagstrap-icon"></i>Senegal (+221)</li>
									<li data-code="RS" data-name="Serbia" data-cid="c218"><i
											class="flagstrap-icon"></i>Serbia (+381)</li>
									<li data-code="SC" data-name="Seychelles" data-cid="c219"><i
											class="flagstrap-icon"></i>Seychelles (+248)</li>
									<li data-code="SL" data-name="Sierra Leone" data-cid="c220"><i
											class="flagstrap-icon"></i>Sierra Leone (+232)</li>
									<li data-code="SG" data-name="Singapore" data-cid="c221"><i
											class="flagstrap-icon"></i>Singapore (+65)</li>
									<li data-code="SK" data-name="Slovakia" data-cid="c222"><i
											class="flagstrap-icon"></i>Slovakia (+421)</li>
									<li data-code="SI" data-name="Slovenia" data-cid="c223"><i
											class="flagstrap-icon"></i>Slovenia (+386)</li>
									<li data-code="SB" data-name="Solomon Islands" data-cid="c224"><i
											class="flagstrap-icon"></i>Solomon Islands (+677)</li>
									<li data-code="SO" data-name="Somalia" data-cid="c225"><i
											class="flagstrap-icon"></i>Somalia (+252)</li>
									<li data-code="ZA" data-name="South Africa" data-cid="c226"><i
											class="flagstrap-icon"></i>South Africa (+27)</li>
									<li data-code="KR" data-name="South Korea" data-cid="c227"><i
											class="flagstrap-icon"></i>South Korea (+82)</li>
									<li data-code="ES" data-name="Spain" data-cid="c228"><i class="flagstrap-icon"></i>Spain
										(+34)</li>
									<li data-code="LK" data-name="Sri Lanka" data-cid="c229"><i
											class="flagstrap-icon"></i>Sri Lanka (+94)</li>
									<li data-code="SD" data-name="Sudan" data-cid="c230"><i class="flagstrap-icon"></i>Sudan
										(+249)</li>
									<li data-code="SR" data-name="Suriname" data-cid="c231"><i
											class="flagstrap-icon"></i>Suriname (+597)</li>
									<li data-code="" data-name="Svalbard and Jan Mayen" data-cid="c232"><i
											class="flagstrap-icon"></i>Svalbard and Jan Mayen (+47)</li>
									<li data-code="SZ" data-name="Swaziland" data-cid="c233"><i
											class="flagstrap-icon"></i>Swaziland (+268)</li>
									<li data-code="SE" data-name="Sweden" data-cid="c234"><i
											class="flagstrap-icon"></i>Sweden (+46)</li>
									<li data-code="CH" data-name="Switzerland" data-cid="c235"><i
											class="flagstrap-icon"></i>Switzerland (+41)</li>
									<li data-code="SY" data-name="Syria" data-cid="c236"><i class="flagstrap-icon"></i>Syria
										(+963)</li>
									<li data-code="TW" data-name="Taiwan" data-cid="c237"><i
											class="flagstrap-icon"></i>Taiwan (+886)</li>
									<li data-code="TJ" data-name="Tajikistan" data-cid="c238"><i
											class="flagstrap-icon"></i>Tajikistan (+992)</li>
									<li data-code="TZ" data-name="Tanzania" data-cid="c239"><i
											class="flagstrap-icon"></i>Tanzania (+255)</li>
									<li data-code="TH" data-name="Thailand" data-cid="c240"><i
											class="flagstrap-icon"></i>Thailand (+66)</li>
									<li data-code="TG" data-name="Togo" data-cid="c241"><i class="flagstrap-icon"></i>Togo
										(+228)</li>
									<li data-code="TK" data-name="Tokelau" data-cid="c242"><i
											class="flagstrap-icon"></i>Tokelau (+690)</li>
									<li data-code="TO" data-name="Tonga" data-cid="c243"><i class="flagstrap-icon"></i>Tonga
										(+676)</li>
									<li data-code="TT" data-name="Trinidad and Tobago" data-cid="c244"><i
											class="flagstrap-icon"></i>Trinidad and Tobago (+1-868)</li>
									<li data-code="TN" data-name="Tunisia" data-cid="c245"><i
											class="flagstrap-icon"></i>Tunisia (+216)</li>
									<li data-code="TR" data-name="Turkey" data-cid="c246"><i
											class="flagstrap-icon"></i>Turkey (+90)</li>
									<li data-code="TM" data-name="Turkmenistan" data-cid="c247"><i
											class="flagstrap-icon"></i>Turkmenistan (+993)</li>
									<li data-code="TC" data-name="Turks and Caicos Islands" data-cid="c248"><i
											class="flagstrap-icon"></i>Turks and Caicos Islands (+1-649)</li>
									<li data-code="TV" data-name="Tuvalu" data-cid="c249"><i
											class="flagstrap-icon"></i>Tuvalu (+688)</li>
									<li data-code="" data-name="US. Virgin Islands" data-cid="c250"><i
											class="flagstrap-icon"></i>US. Virgin Islands (+1-340)</li>
									<li data-code="UG" data-name="Uganda" data-cid="c251"><i
											class="flagstrap-icon"></i>Uganda (+256)</li>
									<li data-code="UK" data-name="Ukraine" data-cid="c252"><i
											class="flagstrap-icon"></i>Ukraine (+380)</li>
									<li data-code="AE" data-name="United Arab Emirates" data-cid="c253"><i
											class="flagstrap-icon"></i>United Arab Emirates (+971)</li>
									<li data-code="GB" data-name="United Kingdom" data-cid="c254"><i
											class="flagstrap-icon"></i>United Kingdom (+44)</li>
									<li data-code="US" data-name="United States" data-cid="c255"><i
											class="flagstrap-icon"></i>United States (+1)</li>
									<li data-code="UY" data-name="Uruguay" data-cid="c256"><i
											class="flagstrap-icon"></i>Uruguay (+598)</li>
									<li data-code="UZ" data-name="Uzbekistan" data-cid="c257"><i
											class="flagstrap-icon"></i>Uzbekistan (+998)</li>
									<li data-code="VU" data-name="Vanuatu" data-cid="c258"><i
											class="flagstrap-icon"></i>Vanuatu (+678)</li>
									<li data-code="" data-name="Vatican" data-cid="c259"><i
											class="flagstrap-icon"></i>Vatican (+379)</li>
									<li data-code="VE" data-name="Venezuela" data-cid="c260"><i
											class="flagstrap-icon"></i>Venezuela (+58)</li>
									<li data-code="VN" data-name="Vietnam" data-cid="c261"><i
											class="flagstrap-icon"></i>Vietnam (+84)</li>
									<li data-code="WF" data-name="Wallis and Futuna" data-cid="c262"><i
											class="flagstrap-icon"></i>Wallis and Futuna (+681)</li>
									<li data-code="EH" data-name="Western Sahara" data-cid="c263"><i
											class="flagstrap-icon"></i>Western Sahara (+212)</li>
									<li data-code="YE" data-name="Yemen" data-cid="c264"><i class="flagstrap-icon"></i>Yemen
										(+967)</li>
									<li data-code="ZM" data-name="Zambia" data-cid="c265"><i
											class="flagstrap-icon"></i>Zambia (+260)</li>
									<li data-code="ZW" data-name="Zimbabwe" data-cid="c266"><i
											class="flagstrap-icon"></i>Zimbabwe (+263)</li>
								</ul>
							</div>
						</div>
					</div>

					<div class="form-group  col-12 login-otp-phone-input">

						<label for="loginPhoneNumber">Phone number</label>
						<input id="loginPhoneNumber" type="tel" name="mobile" class="form-control rounded-pill" required
							placeholder="Enter phone number here" value="+1" />
					</div>
					<div class="text-center">

						<button id="loginOtpSendBtn">Continue</button>
					</div>
				</div>
				<div class="loginOtpSubmitOtpSection text-center" style="display: none">
					<p>
						Enter OTP CODE , We have sent you on your phone number
						<span id="loginOtpPhone"></span>
					</p>
					<div class="login-otp-input">
						<input type="number" min="0" max="9" required />
						<input type="number" min="0" max="9" required />
						<input type="number" min="0" max="9" required />
						<input type="number" min="0" max="9" required />
						<input type="number" min="0" max="9" required />
						<input type="number" min="0" max="9" required />
					</div>
					<button id="loginOtpVerifyBtn">Verify</button>
					<div class="resend-text">
						Didn't receive the code?
						<span class="resend-link" id="resendLoginOtp">Resend Code</span>
						<span id="timer"></span>
					</div>
				</div>

				<div class="termsServiceSection text-stary" style="display: none">
					<h2>Review terms of Service</h2>
					<p class="text-dark">Welcome to Trbo Swift — Canada’s first vehicle escrow and used car financing
						platform.
						We create a secure way to buy and sell vehicles, backed by evolving technology.Our services include
						escrow for any vehicle and marketplace, as well as tailored financing options. To join the Trbo
						Swift
						car community, please agree to our terms of service, privacy policy, and nondiscrimination policy.
					</p>

					<div class="mt-5 mb-2">
						<div><a class="text-primary" target="_blank"
								href="<?php echo _ppt(array('links', 'terms')); ?>">Terms of service</a></div>
						<div><a class="text-primary" target="_blank" href="<?php echo home_url(); ?>/privacy">Privacy
								policy</a></div>
						<div><a class="text-primary" target="_blank"
								href="<?php echo home_url(); ?>/privacy">Nondiscrimination policy</a></div>
					</div>

					<div> <button id="termsAgree" class="btn btn-secondary rounded-pill px-5 py-2 mr-2">Agree</button>
						<button id="termsCancel" class="btn btn-light rounded-pill px-5 py-2 mr-2">Decline</button>
					</div>
				</div>

			</div>

			<form id="form_user_login" name="form_login" class="loginform ajax_modal" action="#"
				onsubmit="login_process(); return false; " method="post">

				<div class="loginWithEmailForm" style="display:none;">


					<label>Email</label>
					<div class="form-group position-relative">
						<input type="text" class="form-control rounded-pill"
							placeholder="<?php echo __("Enter email here", "premiumpress"); ?>" name="log" id="user_login"
							value="" autocomplete="current-password">
						<i class="fal fa-envelope position-absolute" style="<?php if ($CORE->GEO("is_right_to_left", array())) {
							echo "left:20px;";
						} else {
							echo "right:20px;";
						} ?> top:12px;"></i>
					</div>

					<label>Password</label>
					<div class="form-group position-relative">

						<input type="password" placeholder="<?php echo __("Enter Password", "premiumpress"); ?>"
							class="form-control rounded-pill" name="pwd" id="user_pass" value=""
							autocomplete="current-password">
						<a href="<?php echo home_url(); ?>/wp-login.php?action=lostpassword" rel="nofollow"
							class="text-dark small position-absolute" style="<?php if ($CORE->GEO("is_right_to_left", array())) {
								echo "left:20px;";
							} else {
								echo "right:20px;";
							} ?> top:12px; ">Forget?</a>

						<i class="fa fa-eye position-absolute" style="<?php if ($CORE->GEO("is_right_to_left", array())) {
							echo "left:60px;";
						} else {
							echo "right:80px;";
						} ?> top:12px;cursor:pointer; padding-right:10px; border-right:1px solid #eee;"
							onclick="TogglePass('user_pass');"></i>

					</div>



					<div class="form-group">
						<label class="custom-control custom-checkbox">
							<input type="checkbox" name="remember" class="custom-control-input" checked="">
							<div class="custom-control-label"><?php echo __("Remember", "premiumpress"); ?></div>
						</label>
					</div>

					<div class="form-group text-center mt-4">
						<button type="submit" id="emailLoginBtn"
							class="btn btn-secondary px-5 py-2 submitbtn"><?php echo __("Sign In", "premiumpress"); ?></button>
					</div>

				</div>

				<?php do_action('login_form'); ?>

				<div class="divider-or text-center" style="color:#838383;">
					<span><?php echo __("Or continue with", "premiumpress"); ?></span>
				</div>

				<div class="loginbottomextras">


					<?php if (defined('WLT_DEMOMODE') || _ppt(array('register', 'sociallogin')) == 1) { ?>

						<div class="row no-gutters justify-content-center">
							<div class="px-4 py-2 mb-2">
								<a id="loginWithEmail" class="btn btn-light" href="javascript:void(0)"> <img
										src="<?php echo home_url(); ?>/wp-content/uploads/2024/10/Email.svg"
										style="width:30px; height:30px; object-fit:contain;"> Email </a>

								<a id="loginWithPhone" class="btn btn-light" href="javascript:void(0)" style="display:none;">
									<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/ph_phone-light.svg"
										style="width:30px; height:30px; object-fit:contain;"> Phone </a>
								<?php

								$providers = array(
									"Twitter" => array("icon" => "https://avatars.githubusercontent.com/u/50278?s=280&v=4"),
									"Facebook" => array("icon" => get_template_directory_uri() . "/framework/images/facebook.svg"),
									"Google" => array("icon" => get_template_directory_uri() . "/framework/images/google.svg"),
									"LinkedIn" => array("icon" => get_template_directory_uri() . "/framework/images/linkedin.webp"),
									"Apple" => array("icon" => get_template_directory_uri() . "/framework/images/apple.svg"),
								);

								foreach ($providers as $key => $hh) {
									if (defined('WLT_DEMOMODE') || _ppt('social_' . strtolower($key) . '') == '1') { ?>
										<a class="btn btn-light" <?php if (defined('WLT_DEMOMODE')) { ?> href="javascript:void(0)"
												onclick="alert('Disabled in demo mode.');" <?php } else { ?>
												href="<?php echo home_url(); ?>/wp-login.php?sociallogin=<?php echo $key; ?>" <?php } ?>
											rel="nofollow"> <img src="<?php echo $hh['icon']; ?>"
												style="width:30px; height:30px; object-fit:contain;"> <?php echo $key; ?> </a>
									<?php }
								} ?>
							</div>
						</div>
					<?php } ?>



					<input type="hidden" name="testcookie" value="1" />
					<input type="hidden" name="rememberme" id="rememberme" value="1" />
			</form>




			<?php if (isset($_GET['checkemail'])) { ?>

				<div class="alert alert-success"><i class="fa fa-envelope fa-3x mr-3 float-left"></i>
					<?php echo __("We have sent password recovery instructions to your email address.", "premiumpress") ?></div>

			<?php } ?>



			<div class="text-center">Not a member? <a <?php if (isset($GLOBALS['flag-login']) || _ppt(array('mem', 'register')) == 1) { ?>href="<?php echo wp_registration_url(); ?>&membership=-1" <?php } else { ?>href="javascript:void(0)" onclick="processRegister();" <?php } ?>><span
						class="text-dark"><?php echo __("Register", "premiumpress"); ?></span></a></div>
		</div>











		<!-- Add Firebase Config -->
		<script>
			jQuery(document).ready(function () {


				function getPagePath() {
					// Get the full URL
					const url = window.location.href;

					// Create a URL object
					const urlObj = new URL(url);

					// Extract the pathname (e.g., "/escrow-back-end/")
					const pathname = urlObj.pathname;

					// Remove leading and trailing slashes and return the path
					return pathname.replace(/^\/|\/$/g, '');
				}

				// Example usage
				const pagePath = getPagePath();
				console.log("pagePath", pagePath); // Output: "escrow-back-end"


				function getQueryParameter(name) {
					const urlParams = new URLSearchParams(window.location.search);
					return urlParams.get(name);
				}

				const urlQueryPhone = getQueryParameter('phone');
				const urlQueryEmail = getQueryParameter('email');
				const page_type = getQueryParameter('page_type');

				if (urlQueryPhone) {
					// Remove all whitespace from the phone number
					const cleanedPhone = urlQueryPhone.replace(/\s+/g, '');

					// Extract the country code (e.g., assuming it's the first 2-4 digits)
					const countryCodeMatch = cleanedPhone.match(
						/^(\+\d{1,3})/); // Adjust length as needed for your country codes
					const countryCode = countryCodeMatch ? countryCodeMatch[0] : '';
					const phoneNumber = cleanedPhone.replace(countryCode, '');

					console.log(countryCodeMatch);


					jQuery('#loginPhoneNumber').val(`+${cleanedPhone}`); // Set remaining phone number

					countryAutoSelect('#country', cleanedPhone);
					// countryAutoSelect('#country', '+880');
				}




				if (urlQueryEmail) {
					jQuery('#user_login').val(urlQueryEmail);
				}


				jQuery(document).on('click', '#loginOtpSendBtn', function () {
					sendLoginOTP();
				})
				jQuery(document).on('click', '#loginOtpVerifyBtn', function () {
					verifyPhoneOTP();
				})
				jQuery(document).on('click', '#resendLoginOtp', function () {
					resendPhoneOTP();
				})

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




				// Send OTP function
				function sendLoginOTP() {

					const phoneInputField = jQuery('#loginPhoneNumber').val();
					const phoneNumber = `${phoneInputField}`; // Concatenate with `+` and dial code

					// Get full phone number with dial code
					console.log("Full Phone Number:", phoneNumber);

					// Initialize Recaptcha verifier

					// Remove the old reCAPTCHA element if it exists
					const recaptchaContainer = document.getElementById("loginOtpSendBtn");
					if (recaptchaContainer) {
						recaptchaContainer.remove(); // Remove the existing element
					}

					// Create a new reCAPTCHA container dynamically
					const newRecaptchaContainer = document.createElement("div");
					newRecaptchaContainer.id = "loginOtpSendBtn";
					document.body.appendChild(newRecaptchaContainer); // Append it to the body or any desired location

					// Initialize a new RecaptchaVerifier instance with the new container
					const appVerifier = new firebase.auth.RecaptchaVerifier(newRecaptchaContainer, {
						size: "invisible", // Keeps reCAPTCHA out of view for a seamless user experience
						callback: function (response) {
							// reCAPTCHA solved successfully
						},
						'expired-callback': function () {
							alert('reCAPTCHA expired, please try again.');
						}
					});




					let otpVerify = false;
					let confirmationResult; // To store Firebase confirmation result
					// Send OTP with phone number
					auth.signInWithPhoneNumber(phoneNumber, appVerifier)
						.then((confirmationResult) => {
							// Successfully sent OTP, now handle the result
							window.confirmationResult = confirmationResult;
							// alert("OTP sent successfully! ");
							console.log("confirmationResult: ", confirmationResult);


							document.querySelector(".loginOtpSendCodeSection").style.display = "none";
							document.querySelector(".loginOtpSubmitOtpSection").style.display = "block";
							document.getElementById("loginOtpPhone").textContent = phoneNumber;
							startTimer(); // Start the timer for OTP expiry
						}).catch((error) => {
							// Handle error
							console.error("Error sending OTP: ", error);
							alert("Error sending OTP: " + error.message);
						});
				}





				const otpCodeInputs = document.querySelectorAll(".login-otp-input input");
				let verifiedPhone = null;



				function verifyPhoneOTP() {
					// Combine the OTP digits from input fields
					const otp = Array.from(otpCodeInputs)
						.map((input) => input.value.trim())
						.filter((value) => value !== "")
						.join("");

					console.log('OTP:', otp); // Debugging

					if (otp.length !== 6) {
						alert("Please enter a valid 6-digit OTP.");
						return;
					}

					// Ensure confirmationResult is valid
					if (!confirmationResult) {
						alert('Confirmation result not found. Please resend OTP.');
						return;
					}

					// Verify OTP
					confirmationResult
						.confirm(otp)
						.then((result) => {
							console.log('Verification Success:', result); // Debugging
							verifiedPhone = result.user.phoneNumber;

							// alert("OTP Verified Successfully!");
							// Trigger further action with verified phone number
							afterVerification(result.user.phoneNumber);
						})
						.catch((error) => {
							console.error('Verification Failed:', error); // Debugging
							alert("Invalid OTP. Please try again.");
						});
				}



				function afterVerification(phoneNumber) {

					// const requestData = {
					// 	action: "check_have_user_by_phone",
					// 	phone: phoneNumber,
					// 	nonce: my_ajax_obj.otp_nonce, // Nonce for security
					// };
					// console.log('User login res: ', phoneNumber);

					jQuery.ajax({
						type: "POST",
						url: ajax_site_url,
						dataType: 'json',
						data: {
							action: "login_otp_process",
							phone: phoneNumber,
						},
						success: function (response) {
							if (response.status == "ok") {
								// alert("Login successful!");
								console.log('User login res: ', phoneNumber);
								console.log('User login res: ', response);

								if (pagePath === 'escrow-back-end' || pagePath === 'credit-application') {
									window.location.reload();
								} else if (page_type === 'escrow') {

									window.location.href =
										'<?php echo home_url(); ?>/account/?showtab=escrow';
								} else if (page_type === 'finance') {

									window.location.href =
										'<?php echo home_url(); ?>/account/?showtab=financing';

								} else {
									window.location.href = '<?php echo home_url(); ?>/account';
								}

								//window.location.href = response.data.redirect_url; 
							} else {
								termsOfService();

							}
						},
						error: function (xhr) {
							console.log('User login res: ', xhr);
							alert("An error occurred. Please try again.");
						}
					});
				}


				function termsOfService() {
					jQuery('.loginHeader').hide();
					jQuery('.loginOtpSubmitOtpSection').hide();
					jQuery('.termsServiceSection').show();
				}



				jQuery(document).on('click', '#termsAgree', function () {
					const requestData = {
						action: "otp_register_login_user",
						phone: verifiedPhone,
						nonce: my_ajax_obj.otp_nonce, // Nonce for security
					};
					jQuery.ajax({
						type: "POST",
						url: my_ajax_obj.ajax_url,
						data: requestData,
						success: function (response) {
							if (response.success) {
								//alert("Registration successful!");
								if (page_type === 'escrow') {

									window.location.href =
										'<?php echo home_url(); ?>/account/?showtab=escrow';
								} else if (page_type === 'finance') {

									window.location.href =
										'<?php echo home_url(); ?>/account/?showtab=financing';

								} else {
									window.location.href = '<?php echo home_url(); ?>/account/';
								}

							} else {
								alert("Error: " + response.data.message);
							}
						},
						error: function (xhr) {
							alert("An error occurred. Please try again.");
						}
					});
				});


				jQuery(document).on('click', '#termsCancel', function () {
					alert("Your account creation cancel!");
					window.location.href = '<?php echo home_url(); ?>';
				});

				jQuery(document).on('click', '#loginWithEmail', function () {
					jQuery('.loginWithPhoneForm').hide();
					jQuery('#loginWithEmail').hide();
					jQuery('#loginWithPhone').show();
					jQuery('.loginWithEmailForm').show();
				});

				jQuery(document).on('click', '#loginWithPhone', function () {
					jQuery('.loginWithEmailForm').hide();
					jQuery('.loginWithPhoneForm').show();
					jQuery('#loginWithPhone').hide();
					jQuery('#loginWithEmail').show();
				});


				otpCodeInputs.forEach((input, index) => {
					input.addEventListener('input', (e) => {
						if (e.target.value.length > 1) {
							e.target.value = e.target.value.slice(0, 1);
						}
						if (e.target.value.length === 1) {
							if (index < otpCodeInputs.length - 1) {
								otpCodeInputs[index + 1].focus();
							}
						}
					});

					input.addEventListener('keydown', (e) => {
						if (e.key === 'Backspace' && !e.target.value) {
							if (index > 0) {
								otpCodeInputs[index - 1].focus();
							}
						}
						if (e.key === 'e') {
							e.preventDefault();
						}
					});
				});




				// Timer and resend OTP functionality
				let timeLeft = 120; // 2 minutes in seconds
				let timerId;

				function startTimer() {
					timerId = setInterval(() => {
						const timerDisplay = document.getElementById("timer");
						if (timeLeft <= 0) {
							clearInterval(timerId);
							timerDisplay.textContent = "Code expired";
							document
								.querySelectorAll(".login-otp-input input")
								.forEach((input) => (input.disabled = true));
						} else {
							const minutes = Math.floor(timeLeft / 60);
							const seconds = timeLeft % 60;
							document
								.querySelectorAll(".login-otp-input input")
								.forEach((input) => (input.disabled = false));
							timerDisplay.textContent = `(${minutes}:${seconds
							.toString()
							.padStart(2, "0")})`;
							timeLeft--;
						}
					}, 1000);
				}

				function resendPhoneOTP() {
					if (timeLeft <= 0) {
						alert("Resending OTP...");
						timeLeft = 120;
						startTimer();
						sendLoginOTP(); // Resend OTP
					} else {
						alert("You can only resend OTP after the current one expires.");
					}
				}



				function extractCountryCodeValue(value) {
					if (!value) return 0;

					// Use regex to find numbers (including decimals) and percentages in the text
					let numericValue = value.match(/[\d.,]+/);

					if (numericValue) {
						// Remove commas (if any) and parse the numeric string as a float
						return parseFloat(numericValue[0].replace(/,/g, ''));
					}

					return 0; // Return 0 if no valid numeric value is found
				}



				function countryDropdown(seletor) {
					var Selected = jQuery(seletor);
					var Drop = jQuery(seletor + '-drop');
					var DropItem = Drop.find('li');

					Selected.click(function () {
						Selected.toggleClass('open');
						Drop.toggle();
					});

					Drop.find('li').click(function () {
						Selected.removeClass('open');
						Drop.hide();

						var item = jQuery(this);
						var countryPhoneCode = extractCountryCodeValue(item.text());
						// console.log(countryPhoneCode);
						jQuery('#loginPhoneNumber').val(`+${countryPhoneCode}`);
						Selected.html(item.html());
					});

					DropItem.each(function () {
						var code = jQuery(this).attr('data-code');

						if (code != undefined) {
							var countryCode = code.toLowerCase();
							jQuery(this).find('i').addClass('flagstrap-' + countryCode);
						}
					});
				}

				countryDropdown('#country');


				function countryAutoSelect(selector, phoneNumber) {
					var Selected = jQuery(selector);
					var Drop = jQuery(selector + '-drop');
					var DropItem = Drop.find('li');

					console.log(phoneNumber);

					phoneNumber = `+${phoneNumber}`;

					DropItem.each(function () {
						var item = jQuery(this);

						// Extract the country code from the item's text
						var countryPhoneCode = extractCountryCodeValue(item.text());

						// Check if extracted country code matches the given countryCode
						if (phoneNumber.startsWith(`+${countryPhoneCode}`)) {
							// Set the selected item in the dropdown
							Selected.html(item.html());

							var code = item.attr('data-code');

							if (code != undefined) {
								var countryLetterCode = code.toLowerCase();
								Selected.find('i').addClass('flagstrap-' + countryLetterCode);
							}


							return false; // Stop loop once the match is found
						}


					});
				}


			});
		</script>



		<style>
			.display-flex.small label {
				font-size: 10px;
			}
		</style>

		<style>
			@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");

			.otpVerifyBody {
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
				position: absolute;
				left: 0;
				top: 0;
				right: 0;
				bottom: 0;
				z-index: 99999;
				position: fixed;
			}


			h1 {
				margin-bottom: 1.5rem;
				color: #000000;
				font-weight: 600;
				font-size: 2rem;
			}

			p {
				margin-bottom: 2rem;
				color: #b0b0b0;
				font-weight: 300;
			}

			.login-otp-input {
				display: flex;
				justify-content: center;
				margin-bottom: 2rem;
			}

			@media screen and (max-width: 576px) {
				.login-otp-input input {
					width: 35px !important;
					height: 35px !important;
					margin: 0 8px;
					text-align: center;
					font-size: 1rem;
					border: 2px solid rgba(245, 247, 250, 1);
					border-radius: 12px;
					background-color: rgba(245, 247, 250, 1);
					color: #313131;
					transition: all 0.3s ease;
				}

			}

			@media screen and (min-width: 576px) {
				.login-otp-input input {
					width: 50px;
					height: 50px;
					margin: 0 8px;
					text-align: center;
					font-size: 1.5rem;
					border: 2px solid rgba(245, 247, 250, 1);
					border-radius: 12px;
					background-color: rgba(245, 247, 250, 1);
					color: #313131;
					transition: all 0.3s ease;
				}

			}



			.login-otp-phone-input input {
				width: 100%;
				text-align: start;
				font-size: 1.5rem;
				color: #313131;
				transition: all 0.3s ease;
			}

			.login-otp-phone-input input:focus,
			.login-otp-input input:focus {
				border-color: rgba(191, 155, 62, 1);
				box-shadow: 0 0 0 2px rgba(175, 176, 169, 0.175);
				outline: none;
			}

			.login-otp-phone-input input::-webkit-outer-spin-button,
			.login-otp-phone-input input::-webkit-inner-spin-button,
			.login-otp-input input::-webkit-outer-spin-button,
			.login-otp-input input::-webkit-inner-spin-button {
				-webkit-appearance: none;
				margin: 0;
			}

			.login-otp-phone-input input[type="tel"],
			.login-otp-input input[type="number"] {
				-moz-appearance: textfield;
			}

			#loginOtpSendBtn,
			#loginOtpVerifyBtn {
				background: linear-gradient(135deg,
						rgba(59, 99, 76, 1),
						rgb(95, 139, 114));
				color: rgb(255, 255, 255);
				border: 2px solid rgba(59, 99, 76, 1);
				padding: 5px 24px;
				font-size: 1rem;
				border-radius: 50px;
				cursor: pointer;
				margin: 5px;
				transition: all 0.3s ease;
				font-weight: 500;
				letter-spacing: 0.5px;
				min-width: 180px;
			}

			#loginOtpSendBtn:hover,
			#loginOtpVerifyBtn:hover {
				background: linear-gradient(135deg, rgba(59, 99, 76, 1), #191919);
				transform: translateY(-2px);
				box-shadow: 0 4px 8px rgba(2, 2, 2, 0.131);
			}

			#loginOtpSendBtn:disabled,
			#loginOtpVerifyBtn:disabled {
				background: #cccccc;
				border-color: #999999;
				color: #666666;
				cursor: not-allowed;
				transform: none;
				box-shadow: none;
			}

			#timer {
				font-size: 1rem;
				color: #000000;
				font-weight: 500;
				margin-left: 10px;
			}

			@keyframes pulse {
				0% {
					opacity: 1;
				}

				50% {
					opacity: 0.5;
				}

				100% {
					opacity: 1;
				}
			}

			.expired {
				animation: pulse 2s infinite;
				color: #ff4444;
			}

			.resend-text {
				margin-top: 1rem;
				font-size: 0.9rem;
				color: #b0b0b0;
			}

			.resend-link {
				color: #f16c65;
				text-decoration: none;
				cursor: pointer;
				transition: color 0.3s ease;
			}

			.resend-link:hover {
				color: #ff0000;
				text-decoration: underline;
			}

			#loginOtpPhone {
				color: #000000;
				font-weight: 500;
			}


			ul {
				list-style-type: none;
				padding-inline-start: 10px;
			}



			/* country code selection */


			.country {
				position: relative;
				margin: 0 auto;
				width: 100%;
			}

			.country .select {
				position: relative;
				padding: 0 35px 0 20px;
				height: 40px;
				line-height: 40px;
				border: 1px solid #d2d8dd;
				;
				background: #fff;
				white-space: nowrap;
				text-overflow: ellipsis;
				overflow: hidden;
				cursor: pointer;
				border-radius: 50px;
			}

			.country .select .flagstrap-icon {
				box-sizing: border-box;
				display: inline-block;
				margin-right: 10px;
				width: 16px;
				height: 11px;
				background-image: url("https://raw.githubusercontent.com/blazeworx/flagstrap/master/dist/css/flags.png");
				background-repeat: no-repeat;
				background-color: #e3e5e7;
			}

			.country .select .flagstrap-icon.flagstrap-ad {
				background-position: -16px 0;
			}

			.country .select .flagstrap-icon.flagstrap-ae {
				background-position: -32px 0;
			}

			.country .select .flagstrap-icon.flagstrap-af {
				background-position: -48px 0;
			}

			.country .select .flagstrap-icon.flagstrap-ag {
				background-position: -64px 0;
			}

			.country .select .flagstrap-icon.flagstrap-ai {
				background-position: -80px 0;
			}

			.country .select .flagstrap-icon.flagstrap-al {
				background-position: -96px 0;
			}

			.country .select .flagstrap-icon.flagstrap-am {
				background-position: -112px 0;
			}

			.country .select .flagstrap-icon.flagstrap-an {
				background-position: -128px 0;
			}

			.country .select .flagstrap-icon.flagstrap-ao {
				background-position: -144px 0;
			}

			.country .select .flagstrap-icon.flagstrap-ar {
				background-position: -160px 0;
			}

			.country .select .flagstrap-icon.flagstrap-as {
				background-position: -176px 0;
			}

			.country .select .flagstrap-icon.flagstrap-at {
				background-position: -192px 0;
			}

			.country .select .flagstrap-icon.flagstrap-au {
				background-position: -208px 0;
			}

			.country .select .flagstrap-icon.flagstrap-aw {
				background-position: -224px 0;
			}

			.country .select .flagstrap-icon.flagstrap-az {
				background-position: -240px 0;
			}

			.country .select .flagstrap-icon.flagstrap-ba {
				background-position: 0 -11px;
			}

			.country .select .flagstrap-icon.flagstrap-bb {
				background-position: -16px -11px;
			}

			.country .select .flagstrap-icon.flagstrap-bd {
				background-position: -32px -11px;
			}

			.country .select .flagstrap-icon.flagstrap-be {
				background-position: -48px -11px;
			}

			.country .select .flagstrap-icon.flagstrap-bf {
				background-position: -64px -11px;
			}

			.country .select .flagstrap-icon.flagstrap-bg {
				background-position: -80px -11px;
			}

			.country .select .flagstrap-icon.flagstrap-bh {
				background-position: -96px -11px;
			}

			.country .select .flagstrap-icon.flagstrap-bi {
				background-position: -112px -11px;
			}

			.country .select .flagstrap-icon.flagstrap-bj {
				background-position: -128px -11px;
			}

			.country .select .flagstrap-icon.flagstrap-bm {
				background-position: -144px -11px;
			}

			.country .select .flagstrap-icon.flagstrap-bn {
				background-position: -160px -11px;
			}

			.country .select .flagstrap-icon.flagstrap-bo {
				background-position: -176px -11px;
			}

			.country .select .flagstrap-icon.flagstrap-br {
				background-position: -192px -11px;
			}

			.country .select .flagstrap-icon.flagstrap-bs {
				background-position: -208px -11px;
			}

			.country .select .flagstrap-icon.flagstrap-bt {
				background-position: -224px -11px;
			}

			.country .select .flagstrap-icon.flagstrap-bv {
				background-position: -240px -11px;
			}

			.country .select .flagstrap-icon.flagstrap-bw {
				background-position: 0 -22px;
			}

			.country .select .flagstrap-icon.flagstrap-by {
				background-position: -16px -22px;
			}

			.country .select .flagstrap-icon.flagstrap-bz {
				background-position: -32px -22px;
			}

			.country .select .flagstrap-icon.flagstrap-ca {
				background-position: -48px -22px;
			}

			.country .select .flagstrap-icon.flagstrap-catalonia {
				background-position: -64px -22px;
			}

			.country .select .flagstrap-icon.flagstrap-cd {
				background-position: -80px -22px;
			}

			.country .select .flagstrap-icon.flagstrap-cf {
				background-position: -96px -22px;
			}

			.country .select .flagstrap-icon.flagstrap-cg {
				background-position: -112px -22px;
			}

			.country .select .flagstrap-icon.flagstrap-ch {
				background-position: -128px -22px;
			}

			.country .select .flagstrap-icon.flagstrap-ci {
				background-position: -144px -22px;
			}

			.country .select .flagstrap-icon.flagstrap-ck {
				background-position: -160px -22px;
			}

			.country .select .flagstrap-icon.flagstrap-cl {
				background-position: -176px -22px;
			}

			.country .select .flagstrap-icon.flagstrap-cm {
				background-position: -192px -22px;
			}

			.country .select .flagstrap-icon.flagstrap-cn {
				background-position: -208px -22px;
			}

			.country .select .flagstrap-icon.flagstrap-co {
				background-position: -224px -22px;
			}

			.country .select .flagstrap-icon.flagstrap-cr {
				background-position: -240px -22px;
			}

			.country .select .flagstrap-icon.flagstrap-cu {
				background-position: 0 -33px;
			}

			.country .select .flagstrap-icon.flagstrap-cv {
				background-position: -16px -33px;
			}

			.country .select .flagstrap-icon.flagstrap-cw {
				background-position: -32px -33px;
			}

			.country .select .flagstrap-icon.flagstrap-cy {
				background-position: -48px -33px;
			}

			.country .select .flagstrap-icon.flagstrap-cz {
				background-position: -64px -33px;
			}

			.country .select .flagstrap-icon.flagstrap-de {
				background-position: -80px -33px;
			}

			.country .select .flagstrap-icon.flagstrap-dj {
				background-position: -96px -33px;
			}

			.country .select .flagstrap-icon.flagstrap-dk {
				background-position: -112px -33px;
			}

			.country .select .flagstrap-icon.flagstrap-dm {
				background-position: -128px -33px;
			}

			.country .select .flagstrap-icon.flagstrap-do {
				background-position: -144px -33px;
			}

			.country .select .flagstrap-icon.flagstrap-dz {
				background-position: -160px -33px;
			}

			.country .select .flagstrap-icon.flagstrap-ec {
				background-position: -176px -33px;
			}

			.country .select .flagstrap-icon.flagstrap-ee {
				background-position: -192px -33px;
			}

			.country .select .flagstrap-icon.flagstrap-eg {
				background-position: -208px -33px;
			}

			.country .select .flagstrap-icon.flagstrap-eh {
				background-position: -224px -33px;
			}

			.country .select .flagstrap-icon.flagstrap-england {
				background-position: -240px -33px;
			}

			.country .select .flagstrap-icon.flagstrap-er {
				background-position: 0 -44px;
			}

			.country .select .flagstrap-icon.flagstrap-es {
				background-position: -16px -44px;
			}

			.country .select .flagstrap-icon.flagstrap-et {
				background-position: -32px -44px;
			}

			.country .select .flagstrap-icon.flagstrap-eu {
				background-position: -48px -44px;
			}

			.country .select .flagstrap-icon.flagstrap-fi {
				background-position: -64px -44px;
			}

			.country .select .flagstrap-icon.flagstrap-fj {
				background-position: -80px -44px;
			}

			.country .select .flagstrap-icon.flagstrap-fk {
				background-position: -96px -44px;
			}

			.country .select .flagstrap-icon.flagstrap-fm {
				background-position: -112px -44px;
			}

			.country .select .flagstrap-icon.flagstrap-fo {
				background-position: -128px -44px;
			}

			.country .select .flagstrap-icon.flagstrap-fr {
				background-position: -144px -44px;
			}

			.country .select .flagstrap-icon.flagstrap-ga {
				background-position: -160px -44px;
			}

			.country .select .flagstrap-icon.flagstrap-gb {
				background-position: -176px -44px;
			}

			.country .select .flagstrap-icon.flagstrap-gd {
				background-position: -192px -44px;
			}

			.country .select .flagstrap-icon.flagstrap-ge {
				background-position: -208px -44px;
			}

			.country .select .flagstrap-icon.flagstrap-gf {
				background-position: -224px -44px;
			}

			.country .select .flagstrap-icon.flagstrap-gg {
				background-position: -240px -44px;
			}

			.country .select .flagstrap-icon.flagstrap-gh {
				background-position: 0 -55px;
			}

			.country .select .flagstrap-icon.flagstrap-gi {
				background-position: -16px -55px;
			}

			.country .select .flagstrap-icon.flagstrap-gl {
				background-position: -32px -55px;
			}

			.country .select .flagstrap-icon.flagstrap-gm {
				background-position: -48px -55px;
			}

			.country .select .flagstrap-icon.flagstrap-gn {
				background-position: -64px -55px;
			}

			.country .select .flagstrap-icon.flagstrap-gp {
				background-position: -80px -55px;
			}

			.country .select .flagstrap-icon.flagstrap-gq {
				background-position: -96px -55px;
			}

			.country .select .flagstrap-icon.flagstrap-gr {
				background-position: -112px -55px;
			}

			.country .select .flagstrap-icon.flagstrap-gs {
				background-position: -128px -55px;
			}

			.country .select .flagstrap-icon.flagstrap-gt {
				background-position: -144px -55px;
			}

			.country .select .flagstrap-icon.flagstrap-gu {
				background-position: -160px -55px;
			}

			.country .select .flagstrap-icon.flagstrap-gw {
				background-position: -176px -55px;
			}

			.country .select .flagstrap-icon.flagstrap-gy {
				background-position: -192px -55px;
			}

			.country .select .flagstrap-icon.flagstrap-hk {
				background-position: -208px -55px;
			}

			.country .select .flagstrap-icon.flagstrap-hm {
				background-position: -224px -55px;
			}

			.country .select .flagstrap-icon.flagstrap-hn {
				background-position: -240px -55px;
			}

			.country .select .flagstrap-icon.flagstrap-hr {
				background-position: 0 -66px;
			}

			.country .select .flagstrap-icon.flagstrap-ht {
				background-position: -16px -66px;
			}

			.country .select .flagstrap-icon.flagstrap-hu {
				background-position: -32px -66px;
			}

			.country .select .flagstrap-icon.flagstrap-ic {
				background-position: -48px -66px;
			}

			.country .select .flagstrap-icon.flagstrap-id {
				background-position: -64px -66px;
			}

			.country .select .flagstrap-icon.flagstrap-ie {
				background-position: -80px -66px;
			}

			.country .select .flagstrap-icon.flagstrap-il {
				background-position: -96px -66px;
			}

			.country .select .flagstrap-icon.flagstrap-im {
				background-position: -112px -66px;
			}

			.country .select .flagstrap-icon.flagstrap-in {
				background-position: -128px -66px;
			}

			.country .select .flagstrap-icon.flagstrap-io {
				background-position: -144px -66px;
			}

			.country .select .flagstrap-icon.flagstrap-iq {
				background-position: -160px -66px;
			}

			.country .select .flagstrap-icon.flagstrap-ir {
				background-position: -176px -66px;
			}

			.country .select .flagstrap-icon.flagstrap-is {
				background-position: -192px -66px;
			}

			.country .select .flagstrap-icon.flagstrap-it {
				background-position: -208px -66px;
			}

			.country .select .flagstrap-icon.flagstrap-je {
				background-position: -224px -66px;
			}

			.country .select .flagstrap-icon.flagstrap-jm {
				background-position: -240px -66px;
			}

			.country .select .flagstrap-icon.flagstrap-jo {
				background-position: 0 -77px;
			}

			.country .select .flagstrap-icon.flagstrap-jp {
				background-position: -16px -77px;
			}

			.country .select .flagstrap-icon.flagstrap-ke {
				background-position: -32px -77px;
			}

			.country .select .flagstrap-icon.flagstrap-kg {
				background-position: -48px -77px;
			}

			.country .select .flagstrap-icon.flagstrap-kh {
				background-position: -64px -77px;
			}

			.country .select .flagstrap-icon.flagstrap-ki {
				background-position: -80px -77px;
			}

			.country .select .flagstrap-icon.flagstrap-km {
				background-position: -96px -77px;
			}

			.country .select .flagstrap-icon.flagstrap-kn {
				background-position: -112px -77px;
			}

			.country .select .flagstrap-icon.flagstrap-kp {
				background-position: -128px -77px;
			}

			.country .select .flagstrap-icon.flagstrap-kr {
				background-position: -144px -77px;
			}

			.country .select .flagstrap-icon.flagstrap-kurdistan {
				background-position: -160px -77px;
			}

			.country .select .flagstrap-icon.flagstrap-kw {
				background-position: -176px -77px;
			}

			.country .select .flagstrap-icon.flagstrap-ky {
				background-position: -192px -77px;
			}

			.country .select .flagstrap-icon.flagstrap-kz {
				background-position: -208px -77px;
			}

			.country .select .flagstrap-icon.flagstrap-la {
				background-position: -224px -77px;
			}

			.country .select .flagstrap-icon.flagstrap-lb {
				background-position: -240px -77px;
			}

			.country .select .flagstrap-icon.flagstrap-lc {
				background-position: 0 -88px;
			}

			.country .select .flagstrap-icon.flagstrap-li {
				background-position: -16px -88px;
			}

			.country .select .flagstrap-icon.flagstrap-lk {
				background-position: -32px -88px;
			}

			.country .select .flagstrap-icon.flagstrap-lr {
				background-position: -48px -88px;
			}

			.country .select .flagstrap-icon.flagstrap-ls {
				background-position: -64px -88px;
			}

			.country .select .flagstrap-icon.flagstrap-lt {
				background-position: -80px -88px;
			}

			.country .select .flagstrap-icon.flagstrap-lu {
				background-position: -96px -88px;
			}

			.country .select .flagstrap-icon.flagstrap-lv {
				background-position: -112px -88px;
			}

			.country .select .flagstrap-icon.flagstrap-ly {
				background-position: -128px -88px;
			}

			.country .select .flagstrap-icon.flagstrap-ma {
				background-position: -144px -88px;
			}

			.country .select .flagstrap-icon.flagstrap-mc {
				background-position: -160px -88px;
			}

			.country .select .flagstrap-icon.flagstrap-md {
				background-position: -176px -88px;
			}

			.country .select .flagstrap-icon.flagstrap-me {
				background-position: -192px -88px;
			}

			.country .select .flagstrap-icon.flagstrap-mg {
				background-position: -208px -88px;
			}

			.country .select .flagstrap-icon.flagstrap-mh {
				background-position: -224px -88px;
			}

			.country .select .flagstrap-icon.flagstrap-mk {
				background-position: -240px -88px;
			}

			.country .select .flagstrap-icon.flagstrap-ml {
				background-position: 0 -99px;
			}

			.country .select .flagstrap-icon.flagstrap-mm {
				background-position: -16px -99px;
			}

			.country .select .flagstrap-icon.flagstrap-mn {
				background-position: -32px -99px;
			}

			.country .select .flagstrap-icon.flagstrap-mo {
				background-position: -48px -99px;
			}

			.country .select .flagstrap-icon.flagstrap-mp {
				background-position: -64px -99px;
			}

			.country .select .flagstrap-icon.flagstrap-mq {
				background-position: -80px -99px;
			}

			.country .select .flagstrap-icon.flagstrap-mr {
				background-position: -96px -99px;
			}

			.country .select .flagstrap-icon.flagstrap-ms {
				background-position: -112px -99px;
			}

			.country .select .flagstrap-icon.flagstrap-mt {
				background-position: -128px -99px;
			}

			.country .select .flagstrap-icon.flagstrap-mu {
				background-position: -144px -99px;
			}

			.country .select .flagstrap-icon.flagstrap-mv {
				background-position: -160px -99px;
			}

			.country .select .flagstrap-icon.flagstrap-mw {
				background-position: -176px -99px;
			}

			.country .select .flagstrap-icon.flagstrap-mx {
				background-position: -192px -99px;
			}

			.country .select .flagstrap-icon.flagstrap-my {
				background-position: -208px -99px;
			}

			.country .select .flagstrap-icon.flagstrap-mz {
				background-position: -224px -99px;
			}

			.country .select .flagstrap-icon.flagstrap-na {
				background-position: -240px -99px;
			}

			.country .select .flagstrap-icon.flagstrap-nc {
				background-position: 0 -110px;
			}

			.country .select .flagstrap-icon.flagstrap-ne {
				background-position: -16px -110px;
			}

			.country .select .flagstrap-icon.flagstrap-nf {
				background-position: -32px -110px;
			}

			.country .select .flagstrap-icon.flagstrap-ng {
				background-position: -48px -110px;
			}

			.country .select .flagstrap-icon.flagstrap-ni {
				background-position: -64px -110px;
			}

			.country .select .flagstrap-icon.flagstrap-nl {
				background-position: -80px -110px;
			}

			.country .select .flagstrap-icon.flagstrap-no {
				background-position: -96px -110px;
			}

			.country .select .flagstrap-icon.flagstrap-np {
				background-position: -112px -110px;
			}

			.country .select .flagstrap-icon.flagstrap-nr {
				background-position: -128px -110px;
			}

			.country .select .flagstrap-icon.flagstrap-nu {
				background-position: -144px -110px;
			}

			.country .select .flagstrap-icon.flagstrap-nz {
				background-position: -160px -110px;
			}

			.country .select .flagstrap-icon.flagstrap-om {
				background-position: -176px -110px;
			}

			.country .select .flagstrap-icon.flagstrap-pa {
				background-position: -192px -110px;
			}

			.country .select .flagstrap-icon.flagstrap-pe {
				background-position: -208px -110px;
			}

			.country .select .flagstrap-icon.flagstrap-pf {
				background-position: -224px -110px;
			}

			.country .select .flagstrap-icon.flagstrap-pg {
				background-position: -240px -110px;
			}

			.country .select .flagstrap-icon.flagstrap-ph {
				background-position: 0 -121px;
			}

			.country .select .flagstrap-icon.flagstrap-pk {
				background-position: -16px -121px;
			}

			.country .select .flagstrap-icon.flagstrap-pl {
				background-position: -32px -121px;
			}

			.country .select .flagstrap-icon.flagstrap-pm {
				background-position: -48px -121px;
			}

			.country .select .flagstrap-icon.flagstrap-pn {
				background-position: -64px -121px;
			}

			.country .select .flagstrap-icon.flagstrap-pr {
				background-position: -80px -121px;
			}

			.country .select .flagstrap-icon.flagstrap-ps {
				background-position: -96px -121px;
			}

			.country .select .flagstrap-icon.flagstrap-pt {
				background-position: -112px -121px;
			}

			.country .select .flagstrap-icon.flagstrap-pw {
				background-position: -128px -121px;
			}

			.country .select .flagstrap-icon.flagstrap-py {
				background-position: -144px -121px;
			}

			.country .select .flagstrap-icon.flagstrap-qa {
				background-position: -160px -121px;
			}

			.country .select .flagstrap-icon.flagstrap-re {
				background-position: -176px -121px;
			}

			.country .select .flagstrap-icon.flagstrap-ro {
				background-position: -192px -121px;
			}

			.country .select .flagstrap-icon.flagstrap-rs {
				background-position: -208px -121px;
			}

			.country .select .flagstrap-icon.flagstrap-ru {
				background-position: -224px -121px;
			}

			.country .select .flagstrap-icon.flagstrap-rw {
				background-position: -240px -121px;
			}

			.country .select .flagstrap-icon.flagstrap-sa {
				background-position: 0 -132px;
			}

			.country .select .flagstrap-icon.flagstrap-sb {
				background-position: -16px -132px;
			}

			.country .select .flagstrap-icon.flagstrap-sc {
				background-position: -32px -132px;
			}

			.country .select .flagstrap-icon.flagstrap-scotland {
				background-position: -48px -132px;
			}

			.country .select .flagstrap-icon.flagstrap-sd {
				background-position: -64px -132px;
			}

			.country .select .flagstrap-icon.flagstrap-se {
				background-position: -80px -132px;
			}

			.country .select .flagstrap-icon.flagstrap-sg {
				background-position: -96px -132px;
			}

			.country .select .flagstrap-icon.flagstrap-sh {
				background-position: -112px -132px;
			}

			.country .select .flagstrap-icon.flagstrap-si {
				background-position: -128px -132px;
			}

			.country .select .flagstrap-icon.flagstrap-sk {
				background-position: -144px -132px;
			}

			.country .select .flagstrap-icon.flagstrap-sl {
				background-position: -160px -132px;
			}

			.country .select .flagstrap-icon.flagstrap-sm {
				background-position: -176px -132px;
			}

			.country .select .flagstrap-icon.flagstrap-sn {
				background-position: -192px -132px;
			}

			.country .select .flagstrap-icon.flagstrap-so {
				background-position: -208px -132px;
			}

			.country .select .flagstrap-icon.flagstrap-somaliland {
				background-position: -224px -132px;
			}

			.country .select .flagstrap-icon.flagstrap-sr {
				background-position: -240px -132px;
			}

			.country .select .flagstrap-icon.flagstrap-ss {
				background-position: 0 -143px;
			}

			.country .select .flagstrap-icon.flagstrap-st {
				background-position: -16px -143px;
			}

			.country .select .flagstrap-icon.flagstrap-sv {
				background-position: -32px -143px;
			}

			.country .select .flagstrap-icon.flagstrap-sx {
				background-position: -48px -143px;
			}

			.country .select .flagstrap-icon.flagstrap-sy {
				background-position: -64px -143px;
			}

			.country .select .flagstrap-icon.flagstrap-sz {
				background-position: -80px -143px;
			}

			.country .select .flagstrap-icon.flagstrap-tc {
				background-position: -96px -143px;
			}

			.country .select .flagstrap-icon.flagstrap-td {
				background-position: -112px -143px;
			}

			.country .select .flagstrap-icon.flagstrap-tf {
				background-position: -128px -143px;
			}

			.country .select .flagstrap-icon.flagstrap-tg {
				background-position: -144px -143px;
			}

			.country .select .flagstrap-icon.flagstrap-th {
				background-position: -160px -143px;
			}

			.country .select .flagstrap-icon.flagstrap-tj {
				background-position: -176px -143px;
			}

			.country .select .flagstrap-icon.flagstrap-tk {
				background-position: -192px -143px;
			}

			.country .select .flagstrap-icon.flagstrap-tl {
				background-position: -208px -143px;
			}

			.country .select .flagstrap-icon.flagstrap-tm {
				background-position: -224px -143px;
			}

			.country .select .flagstrap-icon.flagstrap-tn {
				background-position: -240px -143px;
			}

			.country .select .flagstrap-icon.flagstrap-to {
				background-position: 0 -154px;
			}

			.country .select .flagstrap-icon.flagstrap-tr {
				background-position: -16px -154px;
			}

			.country .select .flagstrap-icon.flagstrap-tt {
				background-position: -32px -154px;
			}

			.country .select .flagstrap-icon.flagstrap-tv {
				background-position: -48px -154px;
			}

			.country .select .flagstrap-icon.flagstrap-tw {
				background-position: -64px -154px;
			}

			.country .select .flagstrap-icon.flagstrap-tz {
				background-position: -80px -154px;
			}

			.country .select .flagstrap-icon.flagstrap-ua {
				background-position: -96px -154px;
			}

			.country .select .flagstrap-icon.flagstrap-ug {
				background-position: -112px -154px;
			}

			.country .select .flagstrap-icon.flagstrap-um {
				background-position: -128px -154px;
			}

			.country .select .flagstrap-icon.flagstrap-us {
				background-position: -144px -154px;
			}

			.country .select .flagstrap-icon.flagstrap-uy {
				background-position: -160px -154px;
			}

			.country .select .flagstrap-icon.flagstrap-uz {
				background-position: -176px -154px;
			}

			.country .select .flagstrap-icon.flagstrap-va {
				background-position: -192px -154px;
			}

			.country .select .flagstrap-icon.flagstrap-vc {
				background-position: -208px -154px;
			}

			.country .select .flagstrap-icon.flagstrap-ve {
				background-position: -224px -154px;
			}

			.country .select .flagstrap-icon.flagstrap-vg {
				background-position: -240px -154px;
			}

			.country .select .flagstrap-icon.flagstrap-vi {
				background-position: 0 -165px;
			}

			.country .select .flagstrap-icon.flagstrap-vn {
				background-position: -16px -165px;
			}

			.country .select .flagstrap-icon.flagstrap-vu {
				background-position: -32px -165px;
			}

			.country .select .flagstrap-icon.flagstrap-wales {
				background-position: -48px -165px;
			}

			.country .select .flagstrap-icon.flagstrap-wf {
				background-position: -64px -165px;
			}

			.country .select .flagstrap-icon.flagstrap-ws {
				background-position: -80px -165px;
			}

			.country .select .flagstrap-icon.flagstrap-ye {
				background-position: -96px -165px;
			}

			.country .select .flagstrap-icon.flagstrap-yt {
				background-position: -112px -165px;
			}

			.country .select .flagstrap-icon.flagstrap-za {
				background-position: -128px -165px;
			}

			.country .select .flagstrap-icon.flagstrap-zanzibar {
				background-position: -144px -165px;
			}

			.country .select .flagstrap-icon.flagstrap-zm {
				background-position: -160px -165px;
			}

			.country .select .flagstrap-icon.flagstrap-zw {
				background-position: -176px -165px;
			}

			.country .select:after {
				content: "";
				display: block;
				position: absolute;
				top: 18px;
				right: 20px;
				width: 8px;
				height: 5px;
				background: url("https://zinee91.dothome.co.kr/codepen/ico_updown3.png") no-repeat;
			}

			.country .select.open:after {
				background-position: 0 -5px;
			}

			.country .dropdown {
				display: none;
				position: absolute;
				top: 39px;
				left: 0;
				width: 100%;
				height: 225px;
				border: 1px solid #cfcfcf;
				border-top: 1px solid #a6a6a6;
				background: #fff;
				box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
				overflow-y: scroll;
				z-index: 1;
			}

			.country .dropdown .flagstrap-icon {
				box-sizing: border-box;
				display: inline-block;
				margin-right: 10px;
				width: 16px;
				height: 11px;
				background-image: url("https://raw.githubusercontent.com/blazeworx/flagstrap/master/dist/css/flags.png");
				background-repeat: no-repeat;
				background-color: #e3e5e7;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ad {
				background-position: -16px 0;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ae {
				background-position: -32px 0;
			}

			.country .dropdown .flagstrap-icon.flagstrap-af {
				background-position: -48px 0;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ag {
				background-position: -64px 0;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ai {
				background-position: -80px 0;
			}

			.country .dropdown .flagstrap-icon.flagstrap-al {
				background-position: -96px 0;
			}

			.country .dropdown .flagstrap-icon.flagstrap-am {
				background-position: -112px 0;
			}

			.country .dropdown .flagstrap-icon.flagstrap-an {
				background-position: -128px 0;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ao {
				background-position: -144px 0;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ar {
				background-position: -160px 0;
			}

			.country .dropdown .flagstrap-icon.flagstrap-as {
				background-position: -176px 0;
			}

			.country .dropdown .flagstrap-icon.flagstrap-at {
				background-position: -192px 0;
			}

			.country .dropdown .flagstrap-icon.flagstrap-au {
				background-position: -208px 0;
			}

			.country .dropdown .flagstrap-icon.flagstrap-aw {
				background-position: -224px 0;
			}

			.country .dropdown .flagstrap-icon.flagstrap-az {
				background-position: -240px 0;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ba {
				background-position: 0 -11px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-bb {
				background-position: -16px -11px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-bd {
				background-position: -32px -11px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-be {
				background-position: -48px -11px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-bf {
				background-position: -64px -11px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-bg {
				background-position: -80px -11px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-bh {
				background-position: -96px -11px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-bi {
				background-position: -112px -11px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-bj {
				background-position: -128px -11px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-bm {
				background-position: -144px -11px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-bn {
				background-position: -160px -11px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-bo {
				background-position: -176px -11px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-br {
				background-position: -192px -11px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-bs {
				background-position: -208px -11px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-bt {
				background-position: -224px -11px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-bv {
				background-position: -240px -11px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-bw {
				background-position: 0 -22px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-by {
				background-position: -16px -22px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-bz {
				background-position: -32px -22px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ca {
				background-position: -48px -22px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-catalonia {
				background-position: -64px -22px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-cd {
				background-position: -80px -22px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-cf {
				background-position: -96px -22px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-cg {
				background-position: -112px -22px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ch {
				background-position: -128px -22px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ci {
				background-position: -144px -22px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ck {
				background-position: -160px -22px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-cl {
				background-position: -176px -22px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-cm {
				background-position: -192px -22px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-cn {
				background-position: -208px -22px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-co {
				background-position: -224px -22px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-cr {
				background-position: -240px -22px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-cu {
				background-position: 0 -33px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-cv {
				background-position: -16px -33px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-cw {
				background-position: -32px -33px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-cy {
				background-position: -48px -33px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-cz {
				background-position: -64px -33px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-de {
				background-position: -80px -33px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-dj {
				background-position: -96px -33px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-dk {
				background-position: -112px -33px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-dm {
				background-position: -128px -33px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-do {
				background-position: -144px -33px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-dz {
				background-position: -160px -33px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ec {
				background-position: -176px -33px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ee {
				background-position: -192px -33px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-eg {
				background-position: -208px -33px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-eh {
				background-position: -224px -33px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-england {
				background-position: -240px -33px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-er {
				background-position: 0 -44px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-es {
				background-position: -16px -44px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-et {
				background-position: -32px -44px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-eu {
				background-position: -48px -44px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-fi {
				background-position: -64px -44px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-fj {
				background-position: -80px -44px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-fk {
				background-position: -96px -44px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-fm {
				background-position: -112px -44px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-fo {
				background-position: -128px -44px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-fr {
				background-position: -144px -44px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ga {
				background-position: -160px -44px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-gb {
				background-position: -176px -44px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-gd {
				background-position: -192px -44px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ge {
				background-position: -208px -44px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-gf {
				background-position: -224px -44px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-gg {
				background-position: -240px -44px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-gh {
				background-position: 0 -55px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-gi {
				background-position: -16px -55px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-gl {
				background-position: -32px -55px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-gm {
				background-position: -48px -55px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-gn {
				background-position: -64px -55px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-gp {
				background-position: -80px -55px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-gq {
				background-position: -96px -55px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-gr {
				background-position: -112px -55px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-gs {
				background-position: -128px -55px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-gt {
				background-position: -144px -55px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-gu {
				background-position: -160px -55px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-gw {
				background-position: -176px -55px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-gy {
				background-position: -192px -55px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-hk {
				background-position: -208px -55px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-hm {
				background-position: -224px -55px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-hn {
				background-position: -240px -55px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-hr {
				background-position: 0 -66px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ht {
				background-position: -16px -66px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-hu {
				background-position: -32px -66px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ic {
				background-position: -48px -66px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-id {
				background-position: -64px -66px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ie {
				background-position: -80px -66px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-il {
				background-position: -96px -66px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-im {
				background-position: -112px -66px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-in {
				background-position: -128px -66px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-io {
				background-position: -144px -66px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-iq {
				background-position: -160px -66px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ir {
				background-position: -176px -66px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-is {
				background-position: -192px -66px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-it {
				background-position: -208px -66px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-je {
				background-position: -224px -66px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-jm {
				background-position: -240px -66px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-jo {
				background-position: 0 -77px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-jp {
				background-position: -16px -77px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ke {
				background-position: -32px -77px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-kg {
				background-position: -48px -77px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-kh {
				background-position: -64px -77px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ki {
				background-position: -80px -77px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-km {
				background-position: -96px -77px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-kn {
				background-position: -112px -77px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-kp {
				background-position: -128px -77px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-kr {
				background-position: -144px -77px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-kurdistan {
				background-position: -160px -77px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-kw {
				background-position: -176px -77px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ky {
				background-position: -192px -77px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-kz {
				background-position: -208px -77px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-la {
				background-position: -224px -77px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-lb {
				background-position: -240px -77px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-lc {
				background-position: 0 -88px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-li {
				background-position: -16px -88px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-lk {
				background-position: -32px -88px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-lr {
				background-position: -48px -88px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ls {
				background-position: -64px -88px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-lt {
				background-position: -80px -88px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-lu {
				background-position: -96px -88px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-lv {
				background-position: -112px -88px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ly {
				background-position: -128px -88px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ma {
				background-position: -144px -88px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-mc {
				background-position: -160px -88px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-md {
				background-position: -176px -88px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-me {
				background-position: -192px -88px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-mg {
				background-position: -208px -88px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-mh {
				background-position: -224px -88px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-mk {
				background-position: -240px -88px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ml {
				background-position: 0 -99px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-mm {
				background-position: -16px -99px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-mn {
				background-position: -32px -99px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-mo {
				background-position: -48px -99px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-mp {
				background-position: -64px -99px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-mq {
				background-position: -80px -99px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-mr {
				background-position: -96px -99px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ms {
				background-position: -112px -99px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-mt {
				background-position: -128px -99px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-mu {
				background-position: -144px -99px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-mv {
				background-position: -160px -99px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-mw {
				background-position: -176px -99px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-mx {
				background-position: -192px -99px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-my {
				background-position: -208px -99px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-mz {
				background-position: -224px -99px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-na {
				background-position: -240px -99px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-nc {
				background-position: 0 -110px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ne {
				background-position: -16px -110px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-nf {
				background-position: -32px -110px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ng {
				background-position: -48px -110px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ni {
				background-position: -64px -110px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-nl {
				background-position: -80px -110px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-no {
				background-position: -96px -110px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-np {
				background-position: -112px -110px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-nr {
				background-position: -128px -110px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-nu {
				background-position: -144px -110px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-nz {
				background-position: -160px -110px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-om {
				background-position: -176px -110px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-pa {
				background-position: -192px -110px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-pe {
				background-position: -208px -110px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-pf {
				background-position: -224px -110px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-pg {
				background-position: -240px -110px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ph {
				background-position: 0 -121px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-pk {
				background-position: -16px -121px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-pl {
				background-position: -32px -121px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-pm {
				background-position: -48px -121px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-pn {
				background-position: -64px -121px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-pr {
				background-position: -80px -121px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ps {
				background-position: -96px -121px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-pt {
				background-position: -112px -121px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-pw {
				background-position: -128px -121px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-py {
				background-position: -144px -121px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-qa {
				background-position: -160px -121px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-re {
				background-position: -176px -121px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ro {
				background-position: -192px -121px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-rs {
				background-position: -208px -121px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ru {
				background-position: -224px -121px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-rw {
				background-position: -240px -121px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-sa {
				background-position: 0 -132px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-sb {
				background-position: -16px -132px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-sc {
				background-position: -32px -132px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-scotland {
				background-position: -48px -132px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-sd {
				background-position: -64px -132px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-se {
				background-position: -80px -132px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-sg {
				background-position: -96px -132px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-sh {
				background-position: -112px -132px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-si {
				background-position: -128px -132px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-sk {
				background-position: -144px -132px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-sl {
				background-position: -160px -132px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-sm {
				background-position: -176px -132px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-sn {
				background-position: -192px -132px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-so {
				background-position: -208px -132px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-somaliland {
				background-position: -224px -132px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-sr {
				background-position: -240px -132px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ss {
				background-position: 0 -143px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-st {
				background-position: -16px -143px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-sv {
				background-position: -32px -143px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-sx {
				background-position: -48px -143px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-sy {
				background-position: -64px -143px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-sz {
				background-position: -80px -143px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-tc {
				background-position: -96px -143px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-td {
				background-position: -112px -143px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-tf {
				background-position: -128px -143px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-tg {
				background-position: -144px -143px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-th {
				background-position: -160px -143px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-tj {
				background-position: -176px -143px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-tk {
				background-position: -192px -143px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-tl {
				background-position: -208px -143px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-tm {
				background-position: -224px -143px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-tn {
				background-position: -240px -143px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-to {
				background-position: 0 -154px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-tr {
				background-position: -16px -154px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-tt {
				background-position: -32px -154px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-tv {
				background-position: -48px -154px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-tw {
				background-position: -64px -154px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-tz {
				background-position: -80px -154px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ua {
				background-position: -96px -154px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ug {
				background-position: -112px -154px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-um {
				background-position: -128px -154px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-us {
				background-position: -144px -154px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-uy {
				background-position: -160px -154px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-uz {
				background-position: -176px -154px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-va {
				background-position: -192px -154px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-vc {
				background-position: -208px -154px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ve {
				background-position: -224px -154px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-vg {
				background-position: -240px -154px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-vi {
				background-position: 0 -165px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-vn {
				background-position: -16px -165px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-vu {
				background-position: -32px -165px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-wales {
				background-position: -48px -165px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-wf {
				background-position: -64px -165px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ws {
				background-position: -80px -165px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-ye {
				background-position: -96px -165px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-yt {
				background-position: -112px -165px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-za {
				background-position: -128px -165px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-zanzibar {
				background-position: -144px -165px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-zm {
				background-position: -160px -165px;
			}

			.country .dropdown .flagstrap-icon.flagstrap-zw {
				background-position: -176px -165px;
			}

			.country .dropdown .flagstrap-icon {
				vertical-align: middle;
			}

			.country .dropdown li {
				padding: 0 20px;
				line-height: 34px;
				font-size: 13px;
				font-weight: 400;
				color: #828282;
				cursor: pointer;
			}

			.country .dropdown li:first-child {
				margin-top: 12px;
			}

			.country .dropdown li:last-child {
				margin-bottom: 12px;
			}

			.country .dropdown li:hover {
				background: #dedede;
				color: #454545;
			}

			.country .dropdown li.open {
				display: block;
			}

			#loginPhoneNumber {
				max-height: 40px;
			}
		</style>


	<?php } ?>