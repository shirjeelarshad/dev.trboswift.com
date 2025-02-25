<?php
global $settings;

 
if(isset($settings['hero_size']) && $settings['hero_size'] == "hero-full"){ 
 
 	 
?>
<script>

jQuery(document).ready(function(){ 

	console.log('loaded full page hero');

	jQuery('.elementor_header').addClass('fixed-top bg-transparent').removeClass('bg-dark').addClass('bg-white');
	
	<?php if($settings['hero_txtcolor'] == "light"){ ?>
	jQuery('.elementor_mainmenu').removeClass('navbar-light').addClass('navbar-dark');
	<?php }else{ ?>
	jQuery('.elementor_mainmenu').addClass('navbar-light').removeClass('navbar-dark');
	<?php } ?>
	
	jQuery('.elementor_topmenu').addClass('fade');
	
	
	jQuery('.header2 .elementor_submenu, .header12 .elementor_submenu').attr('style','display: none !important');
 

});
 

jQuery(window).on('load', function(){
 
	jQuery(window).on('scroll', function() {
		if(jQuery(this).scrollTop() > 150) {
		
			jQuery('.elementor_header').removeClass('bg-transparent');
			jQuery('.elementor_mainmenu').addClass('navbar-light').removeClass('navbar-dark');
			
		} else {
		
			jQuery('.elementor_header').addClass('bg-transparent');
			<?php if($settings['hero_txtcolor'] == "light"){ ?>
			jQuery('.elementor_mainmenu').removeClass('navbar-light').addClass('navbar-dark');
			<?php }else{ ?>
			jQuery('.elementor_mainmenu').addClass('navbar-light').removeClass('navbar-dark');
			<?php } ?>
			
		}
	}); 

});

</script>
<?php } ?>