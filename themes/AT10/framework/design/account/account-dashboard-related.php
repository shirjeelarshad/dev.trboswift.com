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


 
?> 
<div class="hide-mobile" id="related-carousel">

 

 <div style="position: absolute;  <?php if($CORE->GEO("is_right_to_left", array() )){ echo "left:10px;"; }else{ echo "right:10px;";  } ?> top: -10px; cursor:pointer;">
 <a class="btn bg-white btn-sm text-muted prev px-2 mt-2 border"><i class="fa fa-angle-left px-1" aria-hidden="true"></i></a> 
 <a class="btn bg-white btn-sm text-muted next px-2 mt-2 border"><i class="fa fa-angle-right px-1" aria-hidden="true"></i></a>
 </div>

<div class=" d-sm-flex d-block  ">
    <h5 class=" text-black mb-0"><?php echo __("Newly Added","premiumpress"); ?> </h5>
  </div>

 
<div class="mt-4">
<div class="owl-carousel owl-theme"> <?php echo str_replace("data-srcxx","srcxx", do_shortcode('[LISTINGS dataonly=1 nav=0 small=1 carousel=1 custom="new"]'));  ?> </div>
<script> 
jQuery(document).ready(function(){ 
		 
	var owl = jQuery("#related-carousel .owl-carousel").owlCarousel({
      loop: false,
        margin: 20,
        nav: false,
		<?php if($CORE->GEO("is_right_to_left", array() )){ ?>rtl: true,<?php } ?>
        dots: false,
		 	
        responsive: {
            0: {
                items: 2
            },
			 
            600: {
                items: 2
            }, 
			
            1000: {
                items: <?php if(THEME_KEY == "da"){ echo 5; }else{ echo 4; } ?>
            }
        },        
    });  
	
	owl.owlCarousel();
	
	// REFRESH	
	setTimeout(function(){	
   		owl.trigger('refresh.owl.carousel');
	}, 2000); 
 
  jQuery("#related-carousel .next").click(function(){
    owl.trigger('next.owl.carousel');
	owl.trigger('refresh.owl.carousel');
  })
  jQuery("#related-carousel .prev").click(function(){
    owl.trigger('prev.owl.carousel');
	owl.trigger('refresh.owl.carousel');
  })
	
	
});
	 
</script>
</div></div>   