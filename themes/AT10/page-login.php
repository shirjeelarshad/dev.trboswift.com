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
   
   global $CORE, $errortext, $userdata, $errorStyle; 
   
   $GLOBALS['flag-login'] = 1;
   
   // LOGOUT GO TO HOMEPAGE
   if(isset($_GET['loggedout'])){   
   	header("location:".home_url());
   }

	get_header();

	_ppt_template( 'page', 'top' );



 ?> 
 
<section class="bg-light section-120" id="loginform">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-8 mx-auto">
        <?php if( _ppt(array('mem','register'))  == '1'){  ?>
        <?php _ppt_template( 'page-login-memberships' ); ?>
        <?php }else{ ?>
        <?php _ppt_template( 'ajax', 'modal-login' ); ?>
        
        <?php } ?>
      </div>
    </div>
  </div>
</section>
<?php 

   _ppt_template( 'page', 'bottom' );
   
   get_footer(); 
?>