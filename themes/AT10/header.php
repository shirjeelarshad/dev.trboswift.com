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
 
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
 
 
if (!headers_sent()){ header('X-UA-Compatible: IE=edge'); }


global $CORE, $post, $userdata; 


ob_start();
language_attributes();
$ll = ob_get_contents();
ob_end_clean(); 
if(!$CORE->GEO("is_right_to_left", array() ) ){
$ll = str_replace('dir="rtl"','',$ll);
$ll = str_replace('lang="ar"','',$ll);
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo $ll;  ?>>
<!--[if lte IE 8 ]>
<html lang="en" class="ie ie8">
   <![endif]-->
<!--[if IE 9 ]>
   <html lang="en" class="ie">
      <![endif]-->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="google-site-verification" content="4sq2U1g6nbvdYnYJxu8lGix2POr8uwPO71lu6QYH8RQ" />
	<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->
	<title><?php echo _ppt_meta_title(); ?></title>

	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/framework/css/global.css">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
		rel="stylesheet">


	<?php 
		// META DESCRIPTION
		echo _ppt_meta_description();
		
		// META KEYWORDS
		echo _ppt_meta_keywords();

?>
	<?php wp_head();  ?>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
		integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />


	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBCaFPlyPl_vdl9vSDx7iZHMG3BFc_tw0&libraries=places">
	</script>


	<!-- <script 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBCaFPlyPl_vdl9vSDx7iZHMG3BFc_tw0&libraries=places"
    async defer>
	</script> -->


	<script src="https://js.stripe.com/v3/"></script>


	<!-- IntlTelInput CSS and JS -->
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

	<!-- Include PIGNOSE Calendar Stylesheet -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pg-calendar@1.4.27/dist/css/pignose.calendar.min.css">
    
    <!-- Include jQuery and Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

    <!-- Include PIGNOSE Calendar Script -->
    <script src="https://cdn.jsdelivr.net/npm/pg-calendar@1.4.27/dist/js/pignose.calendar.min.js"></script>

    
    



	<script>
	jQuery(document).ready(function($) {
		function formatPriceToCAD(price) {
			return price.toLocaleString('en-CA', {
				style: 'currency',
				currency: 'CAD'
			});
		}

		$('.cad-price-element').each(function() {
			var cadPriceElement = $(this);
			var cadPriceFloat = parseFloat(cadPriceElement.text());

			if (!isNaN(cadPriceFloat)) {
				var formattedCadPrice = formatPriceToCAD(cadPriceFloat);
				cadPriceElement.text(formattedCadPrice);
			}
		});
	});
	</script>


	<script src="https://cdn.jsdelivr.net/npm/heic2any/dist/heic2any.min.js"></script>

	<script>
	function initializeFileUploadHandler(dropAreaSelector, inputFileSelector, previewContainerSelector,
		buttonSelector) {

		console.log('Uploading clicked');
		const dropArea = document.querySelector(dropAreaSelector);
		const inputFile = document.querySelector(inputFileSelector);
		const previewContainer = document.querySelector(previewContainerSelector);
		const uploadButton = document.querySelector(buttonSelector);

		if (!dropArea || !inputFile || !previewContainer || !uploadButton) {
			console.log('Invalid dropArea selectors. Please check your selectors.');
			return;
		}



		// Click handler for the custom upload button
		uploadButton.addEventListener('click', function() {
			console.log('Upload button clicked');
			inputFile.click();
		});

		// Drag and drop events
		dropArea.addEventListener('dragover', function(event) {
			event.preventDefault();
			event.stopPropagation();
			this.classList.add('dragover');
		});

		dropArea.addEventListener('dragleave', function(event) {
			event.preventDefault();
			event.stopPropagation();
			this.classList.remove('dragover');
		});

		dropArea.addEventListener('drop', function(event) {
			event.preventDefault();
			event.stopPropagation();
			this.classList.remove('dragover');

			const files = event.dataTransfer.files;
			handleFiles(files, inputFile, previewContainer);
		});

		// Handle file selection via input field
		inputFile.addEventListener('change', function(event) {
			const files = event.target.files;
			handleFiles(files, inputFile, previewContainer);
		});

		function handleFiles(files, input, previewContainer) {
			if (files.length > 0) {
				const file = files[0];
				if (isHEIC(file)) {
					convertHEICToJPG(file).then(convertedFile => {
						attachFileToInput(convertedFile, input);
						displayPreview(convertedFile, previewContainer);
					}).catch(error => {
						console.error('Error converting HEIC file:', error);
					});
				} else {
					attachFileToInput(file, input);
					displayPreview(file, previewContainer);
				}
			}
		}

		function isHEIC(file) {
			return file.type === 'image/heic' || file.name.endsWith('.heic');
		}

		function convertHEICToJPG(heicFile) {
			return new Promise((resolve, reject) => {
				heic2any({
					blob: heicFile,
					toType: "image/jpeg"
				}).then(convertedBlob => {
					const convertedFile = new File([convertedBlob], heicFile.name.replace(
						/\.heic$/, '.jpg'), {
						type: "image/jpeg"
					});
					resolve(convertedFile);
				}).catch(reject);
			});
		}

		function attachFileToInput(file, input) {
			const dataTransfer = new DataTransfer();

			for (const existingFile of input.files) {
				dataTransfer.items.add(existingFile);
			}

			dataTransfer.items.add(file);
			input.files = dataTransfer.files;
		}

		function displayPreview(file, previewContainer) {
			const reader = new FileReader();
			reader.onload = function(e) {
				clearPreviewContainer(previewContainer);
				const previewElement = createPreviewElement(file, e.target.result);
				previewContainer.appendChild(previewElement);
			};
			reader.readAsDataURL(file);
		}

		function clearPreviewContainer(previewContainer) {
			previewContainer.innerHTML = '';
		}

		function createPreviewElement(file, dataUrl) {
			const previewElement = document.createElement('div');
			previewElement.className = 'col-12 px-0 rounded';

			const imageElement = document.createElement('img');
			imageElement.src = dataUrl;
			imageElement.alt = file.name;
			imageElement.style.width = '100%';
			imageElement.style.height = '100%';
			imageElement.style.borderRadius = '10px';

			previewElement.appendChild(imageElement);
			return previewElement;
		}

	}
	</script>

	<!-- <script
    id="__ada"
    data-handle="TrboSwiftAi"
    src="https://static.ada.support/embed2.js">
	</script> -->





</head>

<?php

ob_start();
body_class();
$bc = ob_get_contents();
ob_end_clean(); 
if(!$CORE->GEO("is_right_to_left", array() ) ){
$bc = str_replace("rtl ","",$bc);
}

?>

<body <?php echo $bc; ?>>

	<?php if(_ppt_livepreview()){ ?>
	<?php _ppt_template( '_preview' );  ?>
	<?php }else{  ?>
	<div id="wrapper" <?php if(in_array(_ppt(array('design','preloader')), array("","1"))){ ?>style="display:none;"
		<?php } ?>>

		<div id="sidebar-wrapper" style="display:none; background: #e4f6e28f;">
			<?php _ppt_template( 'header', 'sidebar' );  ?>
		</div>

		<main id="page-content-wrapper" <?php if(_ppt('footer_mobile_menu') == "1"){ ?>class="with-mobilemenu"
			<?php } ?>>
			<?php
 

if(isset($GLOBALS['flag-blankpage'])){
 
	_ppt_template( 'header', 'menu' ); 
				
}else{

	_ppt_template( 'header', 'menu' ); 

if($CORE->ADVERTISING("check_exists", "header") ){ ?>
			<div class="py-4 text-center border-top border-bottom">
				<?php echo $CORE->ADVERTISING("get_banner", "header" );  ?> </div>
			<?php } ?>
			<?php } ?>
			<?php } ?>