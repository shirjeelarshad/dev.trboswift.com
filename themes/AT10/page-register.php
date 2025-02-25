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

global $CORE, $errortext, $errorStyle, $userdata; 

	$GLOBALS['flag-register'] = 1;
	
	
	// + ADD IN CAPECHA
	function _hook_head(){
	?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<?php }
	
	if(_ppt(array('captcha','enable')) == 1 && _ppt(array('captcha','sitekey')) != "" ){
	add_action('wp_head','_hook_head');
	} 
 
if(!_ppt_checkfile("page-register.php")){ ?>

<?php get_header(); ?>
<?php _ppt_template( 'page', 'top' ); ?>

<section class="section-120 bg-light">
  <div class="container">
    <div class="row">
    
    <?php if(THEME_KEY == "cp" && _ppt(array('lst', 'cpcashback' )) == '1' ){ $GLOBALS['blockform'] = 1; ?>
    <div class="col-12 mb-4">
    
    <div class="text-center py-3">
 
  <h1 class="h2"><?php echo __("Join Today &amp; Start Earning","premiumpress") ?></h1>
 
  <p class="text-muted my-3 col-md-10 mx-auto"><?php echo __("Already a member?","premiumpress"); ?> <a <?php if(isset($GLOBALS['flag-register'])){ ?>href="<?php echo wp_login_url(); ?>"<?php }else{ ?>href="javascript:void(0)" onclick="processLogin();"<?php } ?> class="text-primary modal-register-link"><u><?php echo __("login here","premiumpress"); ?></u></a> </p>
</div>
    
    
    </div>
 
     <div class="col-md-6">
     
        <?php if( _ppt(array('mem','register'))  == '1' && !isset($_GET['membership']) && strlen($errortext) < 1 ){  ?>
        <?php _ppt_template( 'page-login-memberships' ); ?>
        <?php }else{ ?>
         
            <div class="card shadow-sm">
<div class="card-body p-xl-5">

         <h4><?php echo __("Create your free account","premiumpress") ?></h4>
         
         <p class="opacity-5"><?php echo __("Complete the form below to get started.","premiumpress") ?></p>
         
         <hr />
        <?php _ppt_template( 'ajax', 'modal-register' ); ?>
        
        </div></div>
        
        <?php } ?>
        
    </div>
    <div class="col-md-6">
         
         
         <div class="card shadow-sm">
<div class="card-body p-xl-5">

         <h4><?php echo __("How does it work?","premiumpress") ?></h4>
         
         <p class="opacity-5"><?php echo __("Here are some common questions &amp; answers.","premiumpress") ?></p>
         
         <hr />
         
         <?php
		 
		 global $settings;
		 
		 $settings['faq1_title'] = __("How does it work?","premiumpress") ;
		 $settings['faq1_desc'] = __("Cashback is becoming a very popular method of shopping online. By using our affiliate links to buy products or services online, we can share with you some of the benefits the merchants provide us. It's a win win for everyone.","premiumpress") ;
		 
		 $settings['faq2_title'] = __("Are there any hidden costs?","premiumpress") ;
		 $settings['faq2_desc'] = __("No - it's completely free to join. There are no hidden costs.","premiumpress") ;


		 $settings['faq3_title'] = __("Can I browse offers before I sign up?","premiumpress") ;
		 $settings['faq3_desc'] = __("Yes - you can browse our webiste as normal and take a look at some of the great offers we have available.","premiumpress") ;		 

		 $settings['faq4_title'] = __("Is it safe and secure?","premiumpress") ;
		 $settings['faq4_desc'] = __("Yes - To ensure your personal information is secure, we use SSL encryption. We will never store your credit/debit card data on our website.","premiumpress") ;
		 
		 
		 $settings['faq5_title'] = __("How do I get paid my cashback?","premiumpress") ;
		 $settings['faq5_desc'] = __("For each successful cashback sale you make, your account will be credited with the amount due. You can then request a cashout and will send you payment using your prefered method (bank, cheque, PayPal etc).","premiumpress") ;
		 
		 
		
		
		 
		 ?>
         
         <div class="mt-4">
                    <?php  _ppt_template( 'framework/design/faq/parts/faq1' ); ?>
                    </div>
         
          
         
</div> </div>          
    
    </div>
    
    
    <?php }else{ ?>
    
    
    
      <div class="col-md-8 col-lg-10 col-xl-6 mx-auto">
        <?php if( _ppt(array('mem','register'))  == '1' && !isset($_GET['membership']) && strlen($errortext) < 1 ){  ?>
        <?php _ppt_template( 'page-login-memberships' ); ?>
        <?php }else{ ?>
        <?php _ppt_template( 'ajax', 'modal-register' ); ?>
        <?php } ?>
      </div>
      
     <?php } ?> 
      
    </div>
  </div>
</section>
<?php _ppt_template( 'page', 'bottom' ); ?>
<?php get_footer(); ?>
<?php } ?>