<?php
 
add_filter( 'ppt_blocks_args', 	array('block_contact1',  'data') );
add_action( 'contact1',  		array('block_contact1', 'output' ) );
add_action( 'contact1-css',  	array('block_contact1', 'css' ) );
add_action( 'contact1-js',  	array('block_contact1', 'js' ) );

class block_contact1 {

	function __construct(){ }
 
	public static function data($a){ 
 
		$a['contact1'] = array(
			"name" 	=> "Style 1",
			"image"	=> "contact1.jpg",
			"cat"	=> "contact",
			"desc" 	=> "", 
			"data" 	=> array( ),
			"order" => 1,	
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h3",
					"title_pos" 		=> "",
					
					"title" 			=> __("Get in touch","premiumpress"),					 
					"subtitle"			=> "",					
					"desc" 				=> __("Complete the form below and we'll get back to you within 48 hours.","premiumpress"),
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "",
					"desc_margin" 		=> "mb-5",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "dark",
					"subtitle_txtcolor" => "primary",
					"desc_txtcolor" 	=> "opacity-5",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
			 
					
					 
			),
			
					
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( );  
	  
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("contact1", "contact", $settings ) ); 

		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
		// RANDOM NUMBERS
		$email_nr1 = rand("0", "9"); $email_nr2 = rand("0", "9"); 

		
	 
	ob_start();
	?>
    
    
    <section class="<?php echo $settings['section_class']." bg-white ".$settings['section_padding']." ".$settings['section_divider']; ?>">
	<div class="container">
		<div class="row">
        
       
        
        
			<div class=" col-md-8 mx-auto pr-lg-5">
            
            
            

             
				
			<div id="ajax_contactform_output_ok" style="display:none;">
  <div class="alert alert-success text-center small"> <i class="fa fa-check"></i> <?php echo __("Message Sent Successfully.","premiumpress") ?> </div>
</div>
<div id="ajax_contactform_output_error" style="display:none;">
  <div class="alert alert-danger text-center small"> <i class="fa fa-times"></i> <?php echo __("Error Sending Message.","premiumpress") ?> </div>
</div>
				<form method="post" action="" id="contactusform" enctype="multipart/form-data">
				
                
                <div class="row m-0 justify-content-between py-2">
                <button type="button" id="private-seller" class="btn btn-secondary rounded-pill">Private Seller</button>
                <button type="button" id="dealer-seller" class="btn btn-secondary rounded-pill">Dealer</button></div>
                <div class="text-center py-2">Contact Info</div>
                
                <input type="hidden" name="report" id="reportpostid" value="<?php if(isset($_GET['reportid']) && is_numeric($_GET['reportid']) ){ echo esc_attr($_GET['reportid']); } ?>" />
                    
                    
					<div id="html_element"></div>
					<?php if(isset($_GET['report']) && is_numeric($_GET['report']) ){ ?><input type="hidden" name="report" value="<?php echo strip_tags($_GET['report']); ?>" /><?php } ?>
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="controls mb-3 position-relative"> 
								<input type="text" class="form-control rounded-pill" name="form[fname]" id="fname" placeholder="<?php echo __("First Name","premiumpress") ?>" onchange="jQuery('#showcodeb').show();">
                                <span class="input-group-addon inlineicon"> <span class="fal fa-user"></span> </span> 
							</div>
						</div>
                        
						<div class="col-12 col-md-6">
							<div class="controls mb-3 position-relative">
								<input type="text" class="form-control rounded-pill" id="phone" name="form[phone]" placeholder="<?php echo __("Phone","premiumpress") ?>">
                                 <span class="input-group-addon inlineicon"> <span class="fal fa-phone"></span> </span> 
							</div>
						</div>
                        <!-- Dealer start -->
                        <div class="row col-12 m-0 py-2 px-0">
						<div class="col-12 col-md-6">
                        Dealership Website
                        </div>
                        <div class="col-12 col-md-6">
                        <input type="text" class="form-control rounded-pill" id="dealership-website" name="form[website]" placeholder="<?php echo __("Dealership Website","premiumpress") ?>">
                        
                        </div>
                        </div>
                        
                        <div class="row col-12 m-0 py-2 px-0">
						<div class="col-12 col-md-6">
                        Dealership Name
                        </div>
                        <div class="col-12 col-md-6">
                        <input type="text" class="form-control rounded-pill" id="dealer-name" name="form[name]" placeholder="<?php echo __("Dealership Name","premiumpress") ?>">
                        </div>
                        </div>
                        
                        <div class="col-12">
                        
                     
    <!-- Your existing form elements -->
    <div class="custom-file">
        <input type="file" name="files[]" id="fileInput" class="custom-file-input" multiple >
        <label class="custom-file-label" for="image_upload_field">Select Photo</label>
    </div>
    <div class="d-flex flex-wrap " id="previewContainer"></div>


  
  <script>



document.getElementById('fileInput').addEventListener('change', function(event) {
    const files = event.target.files;

    for (const file of files) {
        const reader = new FileReader();

        reader.onload = function(e) {
            const previewElement = createPreviewElement(file, e.target.result);
            document.getElementById('previewContainer').appendChild(previewElement);
        };

        reader.readAsDataURL(file); // Read the file as a data URL
    }
});


// Function to create a preview element
function createPreviewElement(file, dataUrl) {
    const previewElement = document.createElement('div');
    previewElement.className = 'preview-item';
    previewElement.classList.add('card','d-flex','justify-content-center','p-2','m-1');

    const imageElement = document.createElement('img');
    imageElement.src = dataUrl;
    imageElement.alt = file.name;
    imageElement.style.maxWidth = '200px';

    const removeButton = document.createElement('button');
    removeButton.textContent = 'Remove';
    removeButton.className = 'remove-button';

    // Add event listener to remove button
    removeButton.addEventListener('click', function() {
        previewElement.remove(); // Remove the preview element from the DOM
    });

    previewElement.appendChild(imageElement);
    previewElement.appendChild(removeButton);

    return previewElement;
}

</script>

<style>
.preview-item {
    margin-bottom: 10px;
    border: 1px solid #ccc;
    padding: 5px;
}

.remove-button {
    margin-top: 5px;
    cursor: pointer;
    background-color: #e74c3c;
    color: #fff;
    border: none;
    padding: 5px 10px;
    border-radius: 3px;
}
</style>

                        </div>
                        <!-- Dealer End -->
                        
                        
                        <div class="col-12 mt-3">
							<div class="controls mb-3 position-relative"> 
								<input type="text" class="form-control" id="email1" name="form[email]" placeholder="<?php echo __("Email","premiumpress") ?>">
                                <span class="input-group-addon inlineicon"> <span class="fal fa-envelope"></span> </span>
							</div>
						</div>
                        
						<div class="col-12">
							<div class="controls mb-3 position-relative">
								<textarea name="form[message]" class="form-control" id="message" style="height:150px; width:100%;" placeholder="<?php echo __("Message","premiumpress") ?>"></textarea>
							</div>
						</div>
      
                        
<?php if(_ppt(array('captcha','enable')) == 1 && _ppt(array('captcha','sitekey')) != "" ){ ?>
      
      <div class="col-12 mb-3">
         <div class="g-recaptcha mt-2" data-sitekey="<?php echo stripslashes(_ppt(array('captcha','sitekey'))); ?>"></div>
      </div>
<script src='https://www.google.com/recaptcha/api.js'></script>
<?php }else{ ?>  
                        
                        
<div class="col-12" id="showcodeb" style="display:none;">
      <div class="controls mb-3 position-relative">
        <input type="text" name="contact_code" placeholder="<?php echo str_replace("%a",$email_nr1,str_replace("%b",$email_nr2,__("Security: %a + %b = ?","premiumpress"))); ?>" class="form-control"  tabindex="5"  id="code" />
         <span class="input-group-addon inlineicon"> <span class="fal fa-shield-check"></span> </span>
</div>  </div> 

<?php } ?>




						<div class="col-12">
							<button type="button" onclick="CheckFormData();" id="btncontactform" class="btn btn-primary btn-xl btn-block rounded-0 py-2 px-3" disabled><?php echo __("Submit","premiumpress") ?></button>	
						</div>
						<div class="col-12 my-3 "> 
							<input name="agreetc" type="checkbox" id="agreetc" onchange="UpdateTCA()" /> <?php echo __("Accept","premiumpress") ?> <a href="<?php echo _ppt(array('links','terms')); ?>"><?php echo __("Terms &amp; conditions","premiumpress") ?></a> 
						</div>
					</div>
				</form>
<script>

function UpdateTCA(){					 
	if(jQuery('#agreetc').is(':checked') ){                        	
		jQuery('#btncontactform').removeAttr("disabled");
	}else{
		jQuery('#btncontactform').attr("disabled", true);                       
	} 					 
}
					
function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}		
function CheckFormData() {
    var fname = $('#fname');
    var email1 = $('#email1');
    var phone = $('#phone');
    var code = $('#code');
    var message = $('#message');
    var reportpostid = $('#reportpostid');

    // Validate form fields
    if (fname.val() === '') {
        alert('Please complete all required fields.');
        fname.focus();
        fname.css('border', 'thin solid red');
        return false;
    }

    if (email1.val() === '') {
        alert('Please complete all required fields.');
        email1.focus();
        email1.css('border', 'thin solid red');
        return false;
    }

    if (!isEmail(email1.val())) {
        alert('Invalid email address.');
        email1.focus();
        email1.css('border', 'thin solid red');
        return false;
    }

    <?php if(_ppt(array('captcha','enable')) == 1 && _ppt(array('captcha','sitekey')) != "") { ?>
    var response = grecaptcha.getResponse();
    if (!response) {
        alert('Could not get reCAPTCHA response');
        return false;
    }
    <?php } else { ?>
    if (code.val() === '') {
        alert('Please complete all required fields.');
        code.focus();
        code.css('border', 'thin solid red');
        return false;
    }
    <?php } ?>

    if (message.val() === '') {
        alert('Please complete all required fields.');
        message.focus();
        message.css('border', 'thin solid red');
        return false;
    }

    // Create FormData object to handle file uploads
    var formData = new FormData();
    var fileInput = $('#fileInput')[0]; // Assuming 'fileInput' is your file input element

    // Append form data
    formData.append('action', 'single_contactform');
    formData.append('n', fname.val());
    formData.append('e', email1.val());
    formData.append('p', phone.val());
    formData.append('m', message.val());
    formData.append('pid', reportpostid.val());

    <?php if(_ppt(array('captcha','enable')) == 1 && _ppt(array('captcha','sitekey')) != "" ){ ?>
    formData.append('c', '1');
    formData.append('ca', '1');
    formData.append('captcha', grecaptcha.getResponse());
    <?php } else { ?>
    formData.append('ca', '<?php echo ($email_nr1 + $email_nr2); ?>');
    formData.append('c', code.val());
    <?php } ?>

    // Append files to FormData
    $.each(fileInput.files, function(index, file) {
        formData.append('images[]', file);
    });

    // Submit form data via AJAX
    $.ajax({
        type: 'POST',
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        data: formData,
        processData: false, // Prevent jQuery from automatically processing the data
        contentType: false, // Prevent jQuery from setting contentType
        dataType: 'json',
        success: function(response) {
            if (response.status === 'ok') {
                $('#ajax_contactform_output_ok').show();
                $('#contactusform').hide();
            } else {
                $('#ajax_contactform_output_error').show();
            }
        },
        error: function(e) {
            console.log(e);
            // Handle error
        }
    });

    return false; // Prevent default form submission
}
</script>
			</div>
            
            
            
		</div>
	</div>
</section>
 
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		return "";
		ob_start();
		?>
 
        <?php	
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
		public static function js(){
		return "";
		ob_start();
		?>
 
        <?php	
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
}

?>