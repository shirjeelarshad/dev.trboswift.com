<?php
   /*
   Template Name: [PAGE - MY ACCOUNT]
   */
   
   global $userdata, $new_settings, $settings, $CORE; $CORE->Authorize();
   
   $GLOBALS['flag-account'] = 1;   
   
	// UPDATE ONLINE STATUS
	$CORE->USER("set_online",$userdata->ID);	 
    
   	// GET HEADER
   	get_header();  
	
	$showDashboard = true; 
	
$user_roles = wp_get_current_user()->roles;	
$roles = wp_get_current_user()->roles;
$ev = _ppt(array("emails","user_verify")); 

// CHECK FOR FOCE EMAIL VERIFICATION
if( isset($ev['enable']) && $ev['enable'] == 1 &&  _ppt(array('register','forcemailverify'))  == '1' && $CORE->USER("get_verified", $userdata->ID)  == "0"  ){

	$showDashboard = false;
	
	?>

<div class="col-12  py-5  bg-light">
	<div class="col-lg-6 mx-auto">
		<div class="card card-body text-center text-black p-5" style="    border-radius: 1.25rem;"> <i
				class="fal fa-envelope fa-8x mb-4 text-primary"></i>
			<div class="col-lg-10 mx-auto p-0 m-0">
				<h4><?php echo __("Please verify your email address.","premiumpress"); ?></h4>
				<p class="lead mb-0">
					<?php echo __("We have sent a verification link to the email below;","premiumpress"); ?> </p>
			</div>

			<div class="bg-success my-4 col-lg-10 border p-3 mx-auto">
				<?php echo $CORE->USER("get_email", $userdata->ID ); ?> </div>
			<div class="col-lg-10 mx-auto p-0 m-0"> <a href="javascript:void(0);" onclick="resendVemail();"
					class="btn btn-primary btn-block mt-1"><?php echo __("resend email","premiumpress"); ?></a> </div>
		</div>
	</div>
</div>
<script>
function resendVemail() {

	jQuery.ajax({
		type: "POST",
		dataType: 'json',
		url: '<?php echo home_url(); ?>/',
		data: {
			action: "resendvemail",
			uid: <?php echo $userdata->ID; ?>,
		},
		success: function(response) {


			if (response.status == "sent") {

				alert("<?php echo __("Email Sent!","premiumpress"); ?>");
			}


		},
		error: function(e) {
			alert("error " + e)
		}
	});
}

jQuery(document).ready(function() {

	jQuery("#account_sidebar .btn-dark.viewp").hide();
	jQuery("#jumplinks li").hide();

	jQuery(".dashboard-usertop .dropdown-menu").hide();
	jQuery(".dashboard-usertop .caret").hide();

});
</script>
<?php
}


// CHECK FOR INVALID OR EXPIRED MEMBERSHIP
if( _ppt(array('mem','register'))  == '1'){

	$mem = $CORE->USER("get_user_membership", $userdata->ID);  
	
	if(is_array($mem)){
		$da = $CORE->date_timediff($mem['date_expires'],'');
		if($da['expired'] == 1){
		
		$showDashboard = false;
		$showUpgrades = true;
		 
		}
	}else{
		$showDashboard = false;
		$showUpgrades = true;
	}
	
	
	if($showUpgrades){
	?>
<div class="col-lg-10 col-xl-6 mx-auto my-5">
	<?php _ppt_template( 'page-login-memberships' ); ?>
</div>
<script>
jQuery(document).ready(function() {

	jQuery("#jumplinks li").hide();

	jQuery(".dashboard-usertop .dropdown-menu").hide();
	jQuery(".dashboard-usertop .caret").hide();

});
</script>
<?php  
	} 

}

if($showDashboard){
   
    ?>
<div class="bg-light m-md-0 p-md-0">


	<div class="mobile-mb-6">
		<div class="row mx-0">
			<?php if( isset($GLOBALS['error_message']) ){ ?>
			<div class="col-12 mb-2">
				<div class="alert alert-success alert-dismissible fade show"> <?php echo $GLOBALS['error_message']; ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span
							aria-hidden="true">&times;</span> </button>
				</div>
			</div>
			<?php } ?>
			<?php 

/* EMAIL VERIFICATION ********************************************************/ 


if(isset($ev['enable']) && $ev['enable'] == 1 &&  _ppt(array('register','forcemailverify'))  == '1' && $CORE->USER("get_verified", $userdata->ID)  == "0" ){  ?>
			<div class="col-12 mb-2">
				<div class="alert alert-danger"> <a href="javascript:void(0);" onclick="resendVemail();"
						class="btn btn-danger float-right mt-1"><?php echo __("resend email","premiumpress"); ?></a>
					<div class="font-weight-bold mb-2">
						<?php echo __("Please verify your email address.","premiumpress"); ?> </div>
					<p class="mb-0 small">
						<?php echo __("If you have not received the email, please check your account email settings and use the resend button to try again.","premiumpress"); ?>
					</p>
				</div>
			</div>
			<script>
			function resendVemail() {

				jQuery.ajax({
					type: "POST",
					dataType: 'json',
					url: '<?php echo home_url(); ?>/',
					data: {
						action: "resendvemail",
						uid: <?php echo $userdata->ID; ?>,
					},
					success: function(response) {


						if (response.status == "sent") {

							alert("<?php echo __("Email Sent!","premiumpress"); ?>");
						}


					},
					error: function(e) {
						alert("error " + e)
					}
				});
			}
			</script>
			<?php } 

/* *********************************************************/ 

?>


			<div class="col-12 position- top-0 start-0" style="z-index:999; right-0">
				<div class="bg-white py-2 border-0 row">
					<div class="col text-left d-flex align-items-center">

						<a style="display: flex; width:150px; padding:10px; margin-left:20px; border-radius:10px; "
							href="<?php echo home_url(); ?>"> <?php echo $CORE->LAYOUT("get_logo","light");  ?> </a>


					</div>
					<div class="col text-right d-flex justify-content-end align-items-center">

						<button class="navbar-toggler menu-toggle tm border-0 d-inline-block d-md-none"><span
								class="fal fa-bars">&nbsp;</span></button>

								<?php if(in_array('Finance', $roles)){ ?>
								<a href="<?php echo home_url(); ?>/credit-application/?type=Seller" class="border-0 d-md-inline-block d-none btn btn-secondary rounded-pill px-4 mr-3">Finance</a>
								<?php } ?>
						

						<div class="top-user-profile-block hide-mobile">
							<a href="javascript:void(0);" onclick="showdetails('photo');" class=""> <img
									class="rounded-circle img-fluid bg-secondary"
									src="<?php echo $CORE->USER("get_avatar", $userdata->ID ); ?>" alt="user"
									style="max-width:40px; max-height:40px; height:40px; width:40px;"> </a>

							<div style="display: inline;margin-left: 5px;font-size: 10px;"> <span><?php if ($userdata->last_name) {
          echo $userdata->first_name . ' ' . $userdata->last_name;
        } else {
          echo $CORE->USER("get_username", $userdata->ID);
        } ?></span> </div>

						</div>
					</div>

				</div>


			</div>



			<div class="col-12 p-0 row mx-0 overflow-y" style="min-height: 100vh;">
				<?php 
    
    			if(in_array('subscriber', $roles) || in_array('customer', $roles) || in_array('administrator', $roles)) { ?>

				<div class="col-md-1 pr-0 bg-white  d-flex justify-content-center hide-mobile sidebar-menu"
					id="accountmenubar">
					<?php _ppt_template( 'framework/design/account/account-menu' ); ?></div>
				<div class="col-md-11 p-0">
					<div class="px-2 bg-light">
						<?php  $i=1; foreach($CORE->USER("get_account_links", array()) as $k => $i){   ?>
						<div id="<?php echo $k; ?>" class="account_page_wrapper" style="display:none;">

							<?php  if(isset($i['path'])){ get_template_part( 'framework/design/account/account-'. $i['path'] ); } ?>
						</div>
						<?php } ?>

					</div>
				</div>

				<script>
				function moveSideMenuLinks() {
					const sideMenuLinks = document.querySelector('.side-menu-links');
					const mainMenu = document.querySelector('#menu-main.navbar-nav');

					// Check if device width is <= 678px
					if (window.innerWidth <= 678) {
						mainMenu.innerHTML = ''; // Clear main-menu content

						// Move and reformat links from side-menu-links to main-menu
						sideMenuLinks.querySelectorAll('a').forEach(link => {
							const linkHTML = `
                    <div class="d-flex align-items-center" style="gap:8px">
                        <a class="${link.className}" onclick="${link.getAttribute('onclick')}" href="${link.getAttribute('href')}" id="${link.id}" title="${link.title}">
                            <span class="text-uppercase">${link.title}</span>
                        </a>
                    </div>
                `;
							mainMenu.innerHTML += linkHTML;
						});

						// Hide the side-menu-links
						sideMenuLinks.style.display = 'none';
					} else {
						// Reset behavior for larger screens
						mainMenu.innerHTML = '';
						sideMenuLinks.style.display = 'block';
					}
				}

				// Call the function on window resize
				window.addEventListener('resize', moveSideMenuLinks);

				// Call the function initially
				moveSideMenuLinks();
				</script>

				<?php }else if(in_array('dealer', $roles) || in_array('Finance', $roles)){ ?>

				<?php _ppt_template('framework/design/account/dealer-dashboard'); ?>

				<script>
				function moveSideMenuLinks() {
					const sideMenuLinks = document.querySelector('#account_jumplinks');
					const mainMenu = document.querySelector('#menu-main.navbar-nav');

					// Check if device width is <= 678px
					if (window.innerWidth <= 678) {
						mainMenu.innerHTML = ''; // Clear main-menu content

						// Move and reformat links from side-menu-links to main-menu
						sideMenuLinks.querySelectorAll('li').forEach(link => {
							const linkHTML = `
                    <li class="${link.className}" id="${link.id}">
                        ${link.innerHTML}
                    </li>
                `;
							mainMenu.innerHTML += linkHTML;
						});

						// Hide the side-menu-links
						sideMenuLinks.style.display = 'none';
					} else {
						// Reset behavior for larger screens
						mainMenu.innerHTML = '';
						sideMenuLinks.style.display = 'block';
					}
				}

				// Call the function on window resize
				window.addEventListener('resize', moveSideMenuLinks);

				// Call the function initially
				moveSideMenuLinks();
				</script>

				<?php }else if(in_array('escrow', $roles)){ ?>

				<?php _ppt_template('framework/design/account/escrow-dashboard'); ?>

				<script>
				function moveSideMenuLinks() {
					const sideMenuLinks = document.querySelector('#account_jumplinks');
					const mainMenu = document.querySelector('#menu-main.navbar-nav');

					// Check if device width is <= 678px
					if (window.innerWidth <= 678) {
						mainMenu.innerHTML = ''; // Clear main-menu content

						// Move and reformat links from side-menu-links to main-menu
						sideMenuLinks.querySelectorAll('li').forEach(link => {
							const linkHTML = `
                    <li class="${link.className}" id="${link.id}">
                        ${link.innerHTML}
                    </li>
                `;
							mainMenu.innerHTML += linkHTML;
						});

						// Hide the side-menu-links
						sideMenuLinks.style.display = 'none';
					} else {
						// Reset behavior for larger screens
						mainMenu.innerHTML = '';
						sideMenuLinks.style.display = 'block';
					}
				}

				// Call the function on window resize
				window.addEventListener('resize', moveSideMenuLinks);

				// Call the function initially
				moveSideMenuLinks();
				</script>

				<?php }else if(in_array('transport', $roles)){ ?>

				<?php _ppt_template('framework/design/account/transport-dashboard'); ?>

				<script>
				function moveSideMenuLinks() {
					const sideMenuLinks = document.querySelector('#account_jumplinks');
					const mainMenu = document.querySelector('#menu-main.navbar-nav');

					// Check if device width is <= 678px
					if (window.innerWidth <= 678) {
						mainMenu.innerHTML = ''; // Clear main-menu content

						// Move and reformat links from side-menu-links to main-menu
						sideMenuLinks.querySelectorAll('li').forEach(link => {
							const linkHTML = `
                    <li class="${link.className}" id="${link.id}">
                        ${link.innerHTML}
                    </li>
                `;
							mainMenu.innerHTML += linkHTML;
						});

						// Hide the side-menu-links
						sideMenuLinks.style.display = 'none';
					} else {
						// Reset behavior for larger screens
						mainMenu.innerHTML = '';
						sideMenuLinks.style.display = 'block';
					}
				}

				// Call the function on window resize
				window.addEventListener('resize', moveSideMenuLinks);

				// Call the function initially
				moveSideMenuLinks();
				</script>

				<?php } ?>



			</div>
			<!--- close row  -->
		</div>
	</div>
</div>
<?php } ?>
<?php 
if(in_array(_ppt(array('user','rec')), array("","1",))){ ?>
<section class="   hide-mobile">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<style>
				.theme-da .owl-item .card-body {
					display: none;
				}
				</style>

			</div>
		</div>
	</div>
</section>
<?php } ?>
<script>
<?php if( isset($_GET['showtab']) ){ ?>
jQuery(document).ready(function() {
	SwitchPage('<?php echo esc_attr($_GET['showtab']); ?>');
});
<?php }elseif( isset($_POST['showtab']) ){ ?>

jQuery(document).ready(function() {
	SwitchPage('<?php echo esc_attr($_POST['showtab']); ?>')
});

<?php } ?>
</script>



<?php get_footer();  ?>


<style>
@media(max-width:576px) {
	.overflow-y {
		overflow-y: scroll;
	}
}

.table td {
	color: #fff;
}


.elementor_header,
.footer {
	display: none;
}

.top-user-profile-block {

	background-color: var(--color-whitesmoke-100);
	display: inline;
	padding: 20px;
	border-radius: 10px 0 0px 10px;
}


.top-page-banner {
	height: 116px;
	background-image: url('<?php echo home_url(); ?>/wp-content/uploads/2024/03/1bg.png');
	background-repeat: no-repeat, repeat;
	background-size: cover;
	background-position: center;
	border-radius: 20px;
	display: flex;
	flex-direction: column;
	justify-content: center;
	padding: 20px;
}

.side-menu-links {
	display: flex;
	flex-direction: column;
	gap: 20px;
}

.side-menu-links a {
	background: #F8F9FA;
	border-radius: 50px;
	height: 50px;
	width: 50px;
	display: flex;
	align-items: center;
	justify-content: center;

}

.side-menu-links a:hover {
	background: #3B634C;
	border-radius: 50px;
	height: 50px;
	width: 50px;
	display: flex;
	align-items: center;
	justify-content: center;

}

.side-menu-links a.active {
	background: #3B634C;
	border-radius: 50px;
	height: 50px;
	width: 50px;
	display: flex;
	align-items: center;
	justify-content: center;

}

.side-menu-links a:hover i {
	color: white !important;
}

.side-menu-links a.active i {
	color: white !important;
}

.side-bar-bottom {
	bottom: 129px;
	position: absolute;
}

.account-main-block {
	width: calc(100vw - 66px);
	height: 100vh;
}

.top-banner {
	height: 220px;

	background: black;

	border-radius: 10px;

}

.top-banner .banner-bg {
	background-image: url("<?php echo home_url(); ?>/wp-content/uploads/2024/07/Rectangle-34624338.png");
	background-size: cover;
	background-position: left;
	height: 100%;

	padding: 20px;
	border-radius: 10px;
	background-repeat: no-repeat;
}




/* Card css */

.bid-details {
	display: flex;
	align-items: flex-start;
	justify-content: flex-start;
}

.bid-details {
	font-size: var(--font-size-5xs);
}

.bid-details {
	align-self: stretch;
	flex-direction: column;
	font-size: var(--font-size-5xs);
}

.current-bid {
	width: 62px;
	position: relative;
	line-height: 25px;
	display: flex;
	align-items: center;
	z-index: 3;
}

.bid-amount {
	align-self: stretch;
	gap: 6px;
	margin-top: -5px;
	text-align: center;
	font-size: 10px;
	color: #333;
	display: flex;
	flex-direction: row;
	align-items: flex-start;
	justify-content: flex-start;
}

.bid-value {
	width: 107px;
	border-radius: 99px;
	background-color: #be9b525e;
	border: 0.3px solid var(--color-darkkhaki-100);
	box-sizing: border-box;
	display: flex;
	flex-direction: row;
	align-items: flex-start;
	justify-content: flex-start;
	padding: var(--padding-10xs) var(--padding-mini) var(--padding-11xs);
	white-space: nowrap;
	z-index: 1;
}

.bid-value:hover {
	background-color: var(--color-darkkhaki-200);
}

.cad {
	flex: 1;
	position: relative;
	line-height: 25px;
	font-weight: 600;
	display: inline-block;
	min-width: 77px;
	z-index: 2;
}

.view-details-button {
	flex: 1;
	border-radius: var(--br-80xl);
	background-color: var(--color-darkslategray-100);
	padding: 3px 10px;
	white-space: nowrap;
	z-index: 1;
	color: var(--color-whitesmoke-100);
}

.view-details- {
	flex: 1;
	position: relative;
	line-height: 25px;
	font-weight: 600;
	display: inline-block;
	min-width: 77px;
	z-index: 2;
}

.view-details-:hover {
	color: white;
}

.view-details-button {
	white-space: nowrap;
	color: var(--color-whitesmoke-100);
}

.top-bottom-section {
	background-color: var(--color-whitesmoke-100);
	border-radius: 0 0 10px 10px;
}

.auction-info,
.details,
.place-your-bids {
	display: flex;
	max-width: 100%;
}

.auction-info {
	align-self: stretch;
	padding: 0 0 0 var(--padding-12xs);
	box-sizing: border-box;
	font-size: var(--font-size-xs);
}

.auction-info,
.info {
	flex-direction: row;
}

.auction-info,
.bid-info,
.info {
	align-items: flex-start;
	justify-content: flex-start;
}

.info {
	flex: 1;
	border-radius: var(--br-xs);
	background-color: var(--color-whitesmoke-100);
	display: flex;
	gap: 39px;
	max-width: 100%;
	z-index: 1;
}

.auction-timer {
	height: 107px;
	flex-direction: row;
	gap: var(--gap-mini);
}

.auction-timer,
.time,
.time-left {
	display: flex;
	align-items: flex-start;
	justify-content: flex-start;
}

.timer {
	align-self: stretch;
	width: 5px;
	border-radius: var(--br-xs) 0 0 var(--br-xs);
	background-color: var(--color-darkkhaki-100);
}

.time-left {
	flex: 1;
	flex-direction: column;
	padding: var(--padding-sm) 0 0;
}

.time {
	flex-direction: column;
}

.h-43m,
.time {
	align-self: stretch;
}

.auction-ending-in {
	margin: 0;
	font-size: inherit;
	line-height: 39px;
	font-weight: 400;
	font-family: inherit;
}

.auction-ending-in,
.timer {
	position: relative;
	z-index: 2;
}

.h-43m {
	position: relative;
	font-size: var(--font-size-xs);
	line-height: 39px;
	color: var(--color-darkslategray-200);
	z-index: 3;
}

.bid-info {
	display: flex;
	flex-direction: column;
	padding: var(--padding-sm) 0 0;
	box-sizing: border-box;
}

.auction-info,
.bid-info,
.info {
	align-items: flex-start;
	justify-content: flex-start;
}

.bids {
	align-self: stretch;
	flex-direction: row;
	align-items: flex-end;
	gap: 25px;
}

.bid-amount1,
.bids {
	display: flex;
	justify-content: flex-start;
}

.current-bid3 {
	height: 73px;
	display: flex;
	flex-direction: column;
	align-items: flex-start;
	justify-content: flex-end;
	padding: 0 0 4.9px;
	box-sizing: border-box;
}

.current-bid3 .icon {
	width: 3px;
	flex: 1;
	position: relative;
	max-height: 100%;
	z-index: 2;
	background: white;
}

.bid-amount1 {
	flex: 1;
	flex-direction: column;
	align-items: flex-start;
}

.bid-amount1,
.bids {
	display: flex;
	justify-content: flex-start;
}

.current-bids {
	margin: 0;
	font-size: inherit;
	font-weight: 400;
	font-family: inherit;
	z-index: 2;
}

.current-bids,
.empty1 {
	align-self: stretch;
	position: relative;
	line-height: 39px;
}

.empty1 {
	font-size: var(--font-size-xs);
	color: var(--color-darkslategray-200);
	white-space: nowrap;
	z-index: 3;
}


.account-details-tab-bg {
	background: #BC9F4C;
	border-left: 2px solid #194128;
}


.account-toggle-buttons {
	position: relative;
	display: grid;
	grid-template-columns: repeat(2, 1fr);
	width: fit-content;
	border: 5px solid var(--color-whitesmoke-100);
	border-radius: 10px;
	background: var(--color-whitesmoke-100);
	font-size: var(--font-size-sm);
	cursor: pointer;
	line-height: 28px;
	font-family: var(--font-inter);
}

#archive-bids row,
#my-bidding row {
	margin: 0px !important;
}

.new-search.info {
	flex-direction: column;
	gap: 0px !important;
}

.new-search.info div {
	width: 100%;
}

.new-search.info .search-card-img img {
	border-radius: 15px 15px 0 0;
}

.new-search.info .card-body {
	border-radius: 0 0 15px 15px;
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


.elementor-tab-title {
	font-size: 12px;
	line-height: 1.5 !important;
}

.elementor-tab-content {
	font-size: 12px;
}
</style>