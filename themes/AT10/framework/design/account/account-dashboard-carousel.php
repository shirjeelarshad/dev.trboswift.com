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

global $CORE, $userdata;
$user_roles = wp_get_current_user()->roles;	

?> 
<div class="hide-mobile" id="dash-carousel">

<div class="bg-white"> 

 

<div class="card-header">
    <h6 class=" mb-0">New Vehicles</h6>
  </div>

 
<div class="p-2">
<div class="owl-carousel owl-theme"> <?php echo str_replace("data-srcxx","srcxx", do_shortcode('[LISTINGS nav=0  carousel=5 custom="new"]'));

?> 

</div>
<script> 
jQuery(document).ready(function(){ 
		 
	var owl = jQuery("#dash-carousel .owl-carousel").owlCarousel({
        loop: false,
        margin: 20,
        nav: false,
		<?php if($CORE->GEO("is_right_to_left", array() )){ ?>rtl: true,<?php } ?>
        dots: false,		
        responsive: {
            0: {
                items: 1
            },
			 
            600: {
                items: 3
            }, 
            900: {
                items: 4
            }, 
            1200: {
                items: 5
            }, 
            1400: {
                items: 6
            },
			
        },        
    }); 
	
	owl.owlCarousel();
	
	// REFRESH	
	setTimeout(function(){	
   		owl.trigger('refresh.owl.carousel');
	}, 2000); 
 
  jQuery("#dash-carousel .next").click(function(){
    owl.trigger('next.owl.carousel');
	owl.trigger('refresh.owl.carousel');
  })
  jQuery("#dash-carousel .prev").click(function(){
    owl.trigger('prev.owl.carousel');
	owl.trigger('refresh.owl.carousel');
  })
	
	
});
	 
</script>
</div></div>  </div>