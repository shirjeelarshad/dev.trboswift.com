<?php
global $settings;

 
if(isset($settings['hero_overlay']) && $settings['hero_overlay'] != "none"){ 
	
	switch($settings['hero_overlay']){	 
	
		case "gradient": {
		
		echo "<div class='bg-overlay-gradient'></div>";
		} break;
		
		case "black": {
		
		echo "<div class='bg-overlay-black'></div>";
		} break;
		
		case "grey": {
		
		echo "<div class='bg-overlay-grey'></div>";
		} break;
		
		case "white": {
		
		echo "<div class='bg-overlay-white'></div>";
		} break;

		case "green": {
		
		echo "<div class='bg-overlay-green'></div>";
		} break;
				
		case "primary": {
		
		echo "<div class='bg-overlay-primary bg-primary'></div>";
		} break;
		
		case "secondary": {
		
		echo "<div class='bg-overlay-secondary bg-secondary'></div>";
		} break;
		 
	
	}

} ?>