<?php
/*
 * Template Name: Gravity Registration Forms
 * Description: A custom template for the Gravity Registration Forms.
 */
 
 
 
 get_header();

?>
<div class="bg-secondary" style="min-height:100vh">
<div class="container" >
<div class="text-center py-3" id="regtopmsg">
<h1 class="h3 text-white font-weight-bold"><?php echo __("CREATE ACCOUNT","premiumpress") ?></h3>

<p class="text-muted text-center "><?php echo __("If you already have an account","premiumpress"); ?> </p>
<a class="btn  btn-light" href="<?php echo wp_login_url(); ?>" ><?php echo __("ĐĂNG NHẬP","premiumpress") ?></a>
</div>



<!--Default User register Form replace with wordpress register form-->

<div class="register-button-block d-flex justify-content-center mt-3 mb-2" style="text-align: left;">
  <button id="buyerBtn" class="btn btn-primary" style="padding: 10px; margin: 5px;     box-shadow: 0 1px 3px #00000040;" type="button" data-toggle="collapse" data-target="#buyerRegistration" aria-expanded="false" aria-controls="buyerRegistration">
       <input id="buyerBtnRadio" style="display: flex;
    justify-content: flex-start;" type="radio"></input>
    <div class="register-icon"  style="    display: grid;
    justify-content: center;
    align-items: center; padding-left: 50px; padding-right: 50px;">
       
      <img src="<?php echo home_url(); ?>/wp-content/uploads/2023/06/buyer.png" style="width: 50px;" alt="buyer" >
      <span><?php echo __("Cá nhân","premiumpress") ?></span>
    </div>
  </button>
  <button id="dealerBtn" class="btn btn-primary" style="padding: 10px; margin: 5px;     box-shadow: 0 1px 3px #00000040;" type="button" data-toggle="collapse" data-target="#dealerRegistration" aria-expanded="false" aria-controls="dealerRegistration">
       <input id="dealerBtnRadio" style="display: flex;
    justify-content: flex-start;" type="radio"></input>
      <div class="register-icon" style="    display: grid;
    justify-content: center;
    align-items: center; padding-left: 50px; padding-right: 50px;">
           
          <img src="<?php echo home_url(); ?>/wp-content/uploads/2023/06/dealer-e1687250791875.png" style="width: 50px" alt="dealer" class="rounded-lg">
    <span><?php echo __("Đại lý","premiumpress") ?></span></div>
    
  </button>
</div>

<div class="collapse" id="buyerRegistration">
  <div class="card card-body bg-secondary">
       
    <?php echo do_shortcode('[gravityform id="6" title="true" ajax="true"]'); ?>
    
    
  
    




  </div>
</div>


<div class="collapse" id="dealerRegistration">
  <div class="card card-body bg-secondary">
    <?php echo do_shortcode('[gravityform id="5" title="true" ajax="true"]'); ?>
  </div>
</div>




</div>
</div>
<style>
    #wrapper {
    padding: 0 0px!important;
    width: 100% !important;
}


div.wpforms-container-full, div.wpforms-container-full *{
    width: 100% !important;
    padding: 5px!important;
    font-size:14px!important;
}


.firebaseui-container {
    
    
    max-width: 100%!important;
}
.mdl-shadow--2dp {
    box-shadow: none!important;
}



    @media (max-width: 575.98px){
        
        
.register-icon {
        padding-left: 25px!important;
    padding-right: 25px!important;
    
    j
}
        
        
        
    }
    
    .gform-theme--framework input[type]:where(:not(.gform-text-input-reset):not([type=hidden])):where(:not(.gform-theme__disable):not(.gform-theme__disable *):not(.gform-theme__disable-framework):not(.gform-theme__disable-framework *)){
        
        border-radius: 0px !important;
    /* background: #7c7b7857 !important; */
    border: 0.5px solid #eee !important;
    }
    
    
    #buyerRegistration input, #dealerRegistration input  {
    border-radius: 20px!important;
    border: 1px solid #212228 !important;
    background: #212228!important;
    color: #ffffff9e;
    }
    
    #buyerRegistration .gform_button, #dealerRegistration .gform_button {
    background: #efa404 !important;
    }
    
    
    .firebaseui-id-country-selector{
    border-top-left-radius: 20px!important;
    border-bottom-left-radius: 20px!important;
    border-top-right-radius: 0px !important;
    border-bottom-right-radius: 0px!important;
    border: 1px solid #212228 !important;
    background: #212228!important;
    color: #ffffff;
    }
    
    #buyerRegistration .firebaseui-id-phone-number{
    
    border-top-left-radius: 0px!important;
    border-bottom-left-radius: 0px !important;
    border: 1px solid #212228 !important;
    background: #212228!important;
    color: #ffffff;
    }
    
    .firebaseui-button{
    background: black!important;
    border: 0.5px solid #ffffff45!important;
    }
    
    
    .gfield_label.gform-field-label{
    color: #ffffff!important;
    }
    
  

</style>



<script>
  // Get references to the buttons
  const buyerBtn = document.getElementById('buyerBtn');
  const dealerBtn = document.getElementById('dealerBtn');

  const buyerRegistration = document.getElementById('buyerRegistration');
  const dealerRegistration = document.getElementById('dealerRegistration');

  const buyerRadio = document.getElementById('buyerBtnRadio');
  const dealerRadio = document.getElementById('dealerBtnRadio');

  // Add click event listeners to the buttons
  buyerBtn.addEventListener('click', function() {
    // Show the buyer registration content and hide the dealer registration content
    buyerRegistration.style.display = 'block';
    dealerRegistration.style.display = 'none';

    buyerRadio.checked = true;
    dealerRadio.checked = false;
  });

  dealerBtn.addEventListener('click', function() {
    // Show the dealer registration content and hide the buyer registration content
    dealerRegistration.style.display = 'block';
    buyerRegistration.style.display = 'none';

    buyerRadio.checked = false;
    dealerRadio.checked = true;
  });
</script>





<?php


get_footer();

?>