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

global $CORE, $userdata, $post; 


/*
	FOOTER ADVERTISING
*/
 
if( $CORE->ADVERTISING("check_exists","footer") && !isset($GLOBALS['flag-account']) ){ ?>

<section id="advertising_footer" class="bg-light border-top mobile-mb-4 mobile-pb-4">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center py-4"> <?php echo $CORE->ADVERTISING("get_banner","footer"); ?> </div>
        </div>
    </div>
</section>
<?php } ?>
<?php

if(isset($GLOBALS['flag-blankpage'])){

}else{

	_ppt_template( 'footer', 'menu' ); 
}

?>
</main>
</div>

<?php if(in_array(_ppt(array('design','preloader')), array("","1"))){ ?>
<div id="page-loading" style="height:400px; text-align:center; padding-top:300px;"> <img
        src="<?php echo get_template_directory_uri(); ?>/framework/images/loading.svg" alt="loading page" /> </div>
<?php } ?>

<?php _ppt_template( 'footer', 'mobilemenu' );  ?>
<?php _ppt_template( 'footer', 'codes' );  ?>


<!-- Add stripe card modal start -->
<style>
.upgrade-modal-wrap-overlay {

    height: 100em;
}


.add-stripe-card-modal-wrap {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    z-index: 1000;
    display: none;
    overflow: auto;
    -webkit-transform: translate3d(0, 0, 0);
}

.stripe-modal-container {
    border-radius: 8px;
}

.close-stripe {
    position: absolute;
    right: 10px;
    top: 10px;
}

.stripe-modal-item {
    position: relative;
    margin: 0 auto;
    z-index: 2;
    display: flex;
    align-items: center;
    min-height: calc(100% - 1rem);
    justify-content: center;
}

.stripe-modal-item {
    min-height: calc(100% - 3.5rem);
}


@media (min-width: 1477px) {

    .stripe-modal-container {

        min-width: calc(30% - 3.5rem);
        width: calc(30% - 3.5rem);
    }
}

@media (min-width: 1077px) and (max-width:1476.99px) {

    .stripe-modal-container {

        min-width: calc(40% - 3.5rem);
        width: calc(40% - 3.5rem);
    }
}

@media (min-width: 876.99px) and (max-width:1076.99px) {

    .stripe-modal-container {

        min-width: calc(70% - 3.5rem);
    }

}

@media (min-width: 677px) and (max-width:876.99px) {
    .stripe-modal-container {
        min-width: calc(70% - 3.5rem);
    }
}

@media (min-width: 576px) and (max-width:676.99px) {
    .stripe-modal-container {
        min-width: calc(80% - 3.5rem);
    }
}

@media (max-width: 575.99px) {
    .stripe-modal-container {
        min-width: calc(100% - 3.5rem);
    }
}


#card-element {
    padding-top: 15px;
    padding-bottom: 15px;
    padding-left: 5px;
    padding-right: 5px;
    border-radius: 3px;
    border: 1px solid #d2d8dd !important;
}
</style>
<div class="add-stripe-card-modal-wrap shadow hidepage" style="display:none;">
    <div class="extra-modal-wrap-overlay"></div>
    <div class="stripe-modal-item">
        <div class="stripe-modal-container bg-white">
            <div class="position-relative">
                <!-- Modal header here  -->
                <a onclick="jQuery('.add-stripe-card-modal-wrap').fadeOut(400);" class="btn close-stripe ">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="card-body border-0">
                <div class="container">
                    <div id="stripe-card-before"></div>
                    <div id="stripe-card-content"></div>

                </div>
            </div>
            <!-- Modal footer here  -->
        </div>
    </div>
</div>
<!-- Add card close -->




<div id="popupDisclaimer">
    <div class="modal-dialog">
        <div class="modal-content bg-white position-relative" style="border-radius:20px;">
            <button onclick="jQuery('#popupDisclaimer').fadeOut(400);" type="button" class="btn btn-light rounded-pill"
                style="position: absolute; right: 30px; top: 15px; z-index:5;"><i class="fal fa-times"></i></button>
            <div class="modal-body">

                <h1>Modal content</h1>
            </div>

        </div>
    </div>
</div>

<style>
/* Style for the popup */
#popupDisclaimer {
    display: none;
    position: fixed;
    top: 0px;
    right: 0;
    bottom: 0;
    left: 0;
    outline: 0;
    z-index: 1000;
    overflow-x: hidden;
    overflow-y: auto;
    /* padding-right: 17px; */
    /* opacity: 1; */
    transition: opacity .15s linear;
    background: #0000008a;
    width: 100%;
    align-items: center;
    justify-content: center;
}


#popupDisclaimer .modal-content {
    padding: 20px;
    border-radius: 20px;
}



@media (min-width: 576px) {
    #popupDisclaimer .modal-dialog {
        max-width: 70%;
        margin: 1.75rem auto;
    }

    .c29 {
        background-color: #ffffff;

        padding: 72pt 72pt 72pt 72pt
    }
}
</style>

<!-- Turbo Asistant code -->
<script>
jQuery(document).ready(function($) {
    // Define content for each button
    var contentMap = {
        'Auction Process': 'Answer  - Here\'s how it works: Simply add your credit card to place a bid on the vehicle you desire. The highest bid at the close of the auction wins the prize. With TurboBid, the closing process is efficiently managed for a smooth and hassle-free experience. Bid confidently and secure your next vehicle effortlessly with TurboBid!',
        'TurboBid Fees': 'Answer  - Buyers pay a 2.75% buyer’s fee to TurboBid, with a minimum of $275 and a maximum of $2,500, in addition to the final purchase price paid to the seller.',
        'Financing': 'Answer  - TurboBid offers seamless financing solutions through our trusted partners. Secure your financing by completing an application 48 hours before the auction closes. Our streamlined process ensures you have the necessary funds in place to bid confidently. Partner with TurboBid and our financing options to make your vehicle purchase experience as smooth as possible.',
        'Extended Warranty': 'Answer  - TurboBid is proud to partner with GuardTree to offer Canada\'s first used car warranty subscription. Starting from just $49.95, our partnership brings you instant protection without the hassle of inspections. Enjoy peace of mind knowing your vehicle is covered, and with the flexibility to cancel anytime, you\'re always in control. Trust TurboBid and GuardTree for reliable, affordable extended warranty solutions tailored to your needs. Get 25% off your first month when you use code “TURBOBID25” at checkout.',
        'What is a UVIP?': 'Answer  - UVIP provides important information about a used vehicle being sold privately or by a dealership. The UVIP includes details about the vehicle’s registration history, lien information, accident history, and any outstanding recalls. It is meant to provide transparency and protect buyers from purchasing a vehicle with undisclosed issues or liens. The UVIP is typically provided by the seller to the buyer before the sale is completed and is an important document to review before making a used car purchase in Ontario.',
        'Escrow Services': 'Answer  - At TurboBid, we\'re committed to enhancing your buying and selling journey with seamless transaction solutions. Introducing our Escrow services at just $149, designed to streamline your experience and provide security for all parties involved. With TurboBid managing the escrow process, your funds are securely held until both parties fulfill their obligations. Enjoy peace of mind and a transparent transaction experience with TurboBid Escrow services.',
        'Purchase Additional Car Key?': 'Answer  - Yes, TurboBid makes it easy to purchase additional car keys through our auctions. We partner with professional locksmiths who provide convenient at-your-door key cutting and programming services. The option to add additional keys is available once you’ve won the car, ensuring you receive your new keys quickly and securely, right at your location.'
    };

    var typing;

    // Handle click event for each button
    $('.ai-button').click(function() {
        var title = $(this).data('title');
        var content = contentMap[title];
        resetContent();
        $('#stripe-card-content').append(
            '<div class="d-flex"><h6 class="bg-light text-dark px-2 py-1 radiusx ">' + title +
            '</h6></div><div><span class="aiatant-help"></span><span class="typing-indicator ml-2" style="color:#938d8d; font-size: 10px;">Turbo writing...</span></div>'
            );
        showContent(content);
    });

    function resetContent() {
        $('#stripe-card-before').html('');
        $('#stripe-card-content').html('');

        clearInterval(typing); // Stop typing animation
    }

    // Function to type text with typing effect
    function showContent(content) {
        $('.add-stripe-card-modal-wrap').fadeIn(400);

        var i = 0;
        var targetElement = $('.aiatant-help');
        var speed = 50; // typing speed in milliseconds
        typing = setInterval(function() {
            if (i < content.length) {
                targetElement.append(content.charAt(i));
                i++;
            } else {
                clearInterval(typing);
                $('.typing-indicator').fadeOut('slow');
            }
        }, speed);
    }
});
</script>


<style>
.aiatant-help {
    animation: typing 3s steps(30) forwards;
}

@keyframes typing {
    0% {
        width: 0;
    }

    100% {
        width: 100%;
    }
}



.ai-button {
    cursor: pointer;
}
</style>

<!-- Turbo Asistant code close -->


<!-- Vin Decode start -->
<script>
// Function to get query parameters
function getQueryParameter(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

/* jQuery(document).ready(function($) {
     // Retrieve parameters from the URL
     const vinParam = getQueryParameter('vin');
     const makeParam = getQueryParameter('make');
     const modelParam = getQueryParameter('model');
     const myearParam = getQueryParameter('year');

     // Use the parameters if present
     if (vinParam) {
         $('#forminator-field-text-11_667a727d1ae76').val(vinParam);
     }
     if (makeParam) {
         $('#forminator-form-279561__field--select-1_667a727d1ae76').val(makeParam);
     }
     if (modelParam) {
         $('#forminator-field-text-3_667a727d1ae76').val(modelParam);
     }
     if (myearParam) {
         $('#forminator-form-279561__field--select-2_667a727d1ae76').val(myearParam);
     }

 });
 
 */


jQuery(document).ready(function($) {
    // Select the VIN input field
    const vinInputField = $('.vin-input-field input');

    // Ensure the VIN input field exists
    if (vinInputField.length) {
        // Attach the change event listener to the VIN input field
        vinInputField.on('change', function() {
            const vin = $(this).val();
            // console.log('VIN entered:', vin);

            if (vin) {
                const apiUrl = `https://vpic.nhtsa.dot.gov/api/vehicles/decodevin/${vin}?format=json`;
                // console.log('Fetching data from API:', apiUrl);  

                // Fetch data from the API
                $.getJSON(apiUrl, function(data) {
                    if (data && data.Results) {
                        // console.log('API response:', data);  // Debugging log
                        let make = '',
                            model = '',
                            myear = '';

                        // Extract Make, Model, and Model Year from the API response
                        data.Results.forEach(item => {
                            if (item.Variable === 'Make') {
                                make = item.Value;
                            } else if (item.Variable === 'Model') {
                                model = item.Value;
                            } else if (item.Variable === 'Model Year') {
                                myear = item.Value;
                            }
                        });

                        // console.log('Decoded values:', { make, model, myear }); 

                        // Update the corresponding fields with the decoded values
                        if (make) {

                            const makeSelect = $('.vin-select-make select');
                            const lowercaseMake = make
                        .toLowerCase(); // Convert option values to lowercase

                            // Find the option with matching lowercase value
                            makeSelect.find('option').each(function() {
                                if ($(this).val().toLowerCase() === lowercaseMake) {
                                    makeSelect.val($(this).val()).trigger('change');
                                    return false; // Exit the loop once matched
                                }
                            });

                        }
                        if (model) {
                            $('.vin-input-model input').val(model);
                        }
                        if (myear) {

                            const yearSelect = $('.vin-select-year select');
                            yearSelect.val(myear).trigger('change');
                            yearSelect.find(`option[value="${myear}"]`).attr('selected',
                                'selected');
                        }
                    } else {
                        console.error('No data received from API'); // Error handling
                    }
                }).fail(function() {
                    console.error('Error fetching data from API'); // Error handling
                });
            } else {
                console.warn('VIN is empty'); // Warning for empty VIN
            }
        });
    } else {
        // console.error('VIN input field not found');
    }
});
</script>

<!-- Vin decode close -->


<script>
jQuery(document).ready(function($) {
    function replaceCheckbox(oldSelector, newId, label1, label2) {
        // Select the old checkbox label
        var oldCheckboxLabel = $(oldSelector);

        // Ensure the old checkbox exists
        if (oldCheckboxLabel.length) {
            // Get the attributes and state of the old checkbox
            var oldCheckbox = oldCheckboxLabel.find('input[type="checkbox"]');
            var isChecked = oldCheckbox.is(':checked');
            var checkboxName = oldCheckbox.attr('name');
            var checkboxValue = oldCheckbox.attr('value');
            var checkboxId = oldCheckbox.attr('id') || newId;

            // Define the new checkbox structure
            var newCheckboxHtml = `
                <div>
                    <input type="checkbox" id="${checkboxId}" class="toggleCheckbox" ${isChecked ? 'checked' : ''} name="${checkboxName}" value="${checkboxValue}" />
                    <label for="${checkboxId}" class="toggleContainer">
                        <div>${label1}</div>
                        <div>${label2}</div>
                    </label>
                </div>
            `;

            // Replace the old checkbox with the new one
            oldCheckboxLabel.replaceWith(newCheckboxHtml);

            // Attach any necessary event listeners to the new checkbox
            $('#' + checkboxId).on('change', function() {
                var isChecked = $(this).is(':checked');
                let group1 = $('.forminator-row .group-1'); // Fixed syntax
                let group14 = $('.group-14').closest('.forminator-row');
                let group15 = $('.group-15').closest('.forminator-row');

                let nearestRow = group1.closest('.forminator-row'); // Use `closest` instead of `nearest`

                if (isChecked) {
                    nearestRow.before(group14);
                    nearestRow.after(group15);
                } else {
                    nearestRow.before(group15);
                    nearestRow.after(group14);
                }
                // console.log(`New checkbox (${checkboxId}) is ${isChecked ? 'checked' : 'unchecked'}`);
            });
        } else {
            // console.error(`Checkbox label with selector "${oldSelector}" not found`);  // Error handling
        }
    }

    // Replace checkboxes
    // replaceCheckbox('.dealer-checkbox .forminator-checkbox', 'dealerPrivateSeller', 'Dealer', 'Private Party');

    // Example for another checkbox
    // replaceCheckbox('.car-modified .forminator-checkbox', 'carModified', 'Completely stock', 'Modified');

    // replaceCheckbox('.car-damadge .forminator-checkbox', 'carDamadge', 'No', 'Yes');

    // replaceCheckbox('.car-sale-elsewhere .forminator-checkbox', 'carSaleElsewhere', 'No', 'Yes');

    // replaceCheckbox('.car-vehicle-titled .forminator-checkbox', 'carVehicleTitled', 'No', 'Yes');

    // replaceCheckbox('.minimum-price .forminator-checkbox', 'minimumPrice', 'No', 'Yes');

    replaceCheckbox('.financeBuyerSeller .forminator-checkbox', 'financeBuyerSellerSwitcher', 'Buyer', 'Seller');

    replaceCheckbox('#deals-note-switcher', 'dealerNoteSwitcher', 'Overview', 'Activities');

});
</script>



<style>
.toggleContainer {
    position: relative;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    width: fit-content;
    border: 5px solid var(--color-whitesmoke-100);
    border-radius: 6px;
    background: var(--color-whitesmoke-100);
    font-size: var(--font-size-sm);
    color: var(--color-whitesmoke-100);
    cursor: pointer;
    line-height: 28px;
    font-family: var(--font-inter);

}

.toggleContainer::before {
    content: "";
    position: absolute;
    width: 50%;
    height: 100%;
    left: 0%;
    border-radius: 10px;
    /* background: var(--color-darkkhaki-200); */
    background: #004225;
    transition: all 0.3s;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
}

.toggleCheckbox:checked+.toggleContainer::before {
    left: 50%;
}

.toggleContainer div {
    padding: 6px;
    text-align: center;
    z-index: 1;
}

.toggleCheckbox {
    display: none;
}

.toggleCheckbox:checked+.toggleContainer div:first-child {
    color: rgb(52, 51, 51);
    transition: color 0.3s;
    padding: 6px 40px;
}

.toggleCheckbox:checked+.toggleContainer div:last-child {
    color: #ffffff;
    transition: color 0.3s;
    padding: 6px 40px;
}

.toggleCheckbox+.toggleContainer div:first-child {
    color: #ffffff;
    transition: color 0.3s;
    padding: 6px 40px;
}

.toggleCheckbox+.toggleContainer div:last-child {
    color: rgb(64, 63, 63);
    transition: color 0.3s;
    padding: 6px 40px;
}
</style>

</body>

</html>