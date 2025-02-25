<?php



   /*
    ALL HEADERS HAVE
	
	1. elementor_header
	2. elementor_topmenu
	3. elementor_mainmenu
	
   
   */
 
add_filter( 'ppt_blocks_args', 	array('block_header3',  'data') );
add_action( 'header3',  		array('block_header3', 'output' ) );
add_action( 'header3-css',  	array('block_header3', 'css' ) );

class block_header3 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['header3'] = array(
			"name" 	=> "Style 3",
			"image"	=> "header3.jpg",
			"cat"	=> "header",
			"desc" 	=> "", 
			"data" 	=> array( ),
			"order" 	=> 3,
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $userdata, $new_settings, $settings;
	
		
		// ADD ON SYSTEM DEFAULTS
		$settings = array();
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("header3", "header", $settings ) );
 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		    
 
		ob_start();
		
		?>

<style>
.elementor_mainmenu .nav-item a {
	color: #6D6D6D;
	text-transform: capitalize !important;
}

.elementor_header {
	z-index: 999;
	position: relative;
}

.navbar-brand .img-fluid{
	max-height: 50px;
    object-fit: contain;
}

@media (min-width: 1300px) {
    .container {
        max-width: 90vw !important;
    }

	.header-button{
		min-width:144px;
		min-height:40px;
		text-align-center;
		display:flex; justify-content:center;
		align-items:center;
	}
}

@media (min-width: 768px) and (max-width: 1300px) {
    .container, .container-md, .container-sm {
        max-width: 95vw!important;
    }
}


footer{
	overflow: hidden;
}

    footer .socials {
        display: flex;
    }
	footer a{
		color: #333;
	}

	/* .forminator-ui.forminator-custom-form[data-design=default] .forminator-has_error .forminator-error-message{
		display: none!important;
	} */

</style>

<header class="elementor_header ">


	<!-- has-sticky  not-->
	<nav class="elementor_mainmenu navbar navbar-light navbar-expand-lg  py-2">

		<div class="container bg-light p-2 rounded-pill d-flex justify-content-between align-items-center">

			<div class="col-3 d-md-none">

				<button class="navbar-toggler menu-toggle tm border-0"><span class="fal fa-bars">&nbsp;</span></button>
			</div>

			<div class="col-6 col-md-3">
				<a class="navbar-brand d-flex  flex-column align-items-center align-items-md-start"
					href="<?php echo home_url(); ?>">
					<?php echo $CORE->LAYOUT("get_logo","dark");  ?>
					<!-- <span style="font-size:8px; color:#6D6D6D;">Innovative Technology Solutions for Dealers</span> -->
				</a>
			</div>


			<div class="collapse navbar-collapse main-menu justify-content-center text-center">
				<?php echo do_shortcode('[MAINMENU class="navbar-nav" style=1]');  ?>
			</div>



			<div class="col-3  d-flex justify-content-end p-0">

				<?php if (!$userdata->ID) { ?>
				<div class="list-inline-item d-flex align-items-center  mr-0">
					<button 
						class="getPreApproval btn px-2 btn-outline-secondary rounded-pill px-2 mr-md-2 header-button" style="font-size:10px"
						>
						<?php echo __("Get Pre-Approved", "premiumpress"); ?></button>
					<a href="/login" class="btn px-3 btn-secondary rounded-pill px-2 d-none d-md-flex header-button"
						style="font-size:10px">
						<?php echo __("Login", "premiumpress"); ?></a>
				</div>

				<?php } else { ?>
				<div class="list-inline-item mr-0 d-flex align-items-center">
					<button  type="button"
						class="getPreApproval btn px-2 btn-outline-secondary rounded-pill px-2 mr-2 header-button" style="font-size:10px"
						>
						<?php echo __("Get Pre-Approved", "premiumpress"); ?></button>
					<a class="btn  rounded-pill btn-secondary text-white px-4 d-none d-md-flex header-button"
						href="<?php echo home_url(); ?>/account" style="font-size:10px">
						<?php echo __("Account", "premiumpress"); ?></a>
				</div>

				<?php } ?>


			</div>

		</div>
	</nav>


</header>
<style>
@media (min-width:720px) {
	.header-position-absolute {
		position: absolute;
		top: 10px;
		left: 0;
		right: 0;
		z-index: 999;
	}
}

@media (max-width:719.99px) {
	.header-position-absolute {
		position: absolute;
		top: 10px;
		left: 0;
		right: 0;
		z-index: 999;
	}

	.header-position-absolute .container.rounded-pill {
		margin: 0 10px;
	}

}

.navbar-brand .img-fluid {
	width: 180px !important;

}

.sticky {
	top: 10px;
	background-color: #ffffff00;
	border-bottom: 1px solid #fff0 !important;
}

.box-shadow {
	box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
}
</style>
<?php

		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
		}
	
		public static function css(){ 
		ob_start();?>

<?php
		
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
}

?>