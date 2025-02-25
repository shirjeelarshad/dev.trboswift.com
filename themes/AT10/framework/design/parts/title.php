<?php
global $settings; 

if($settings['title_show'] == "yes"){

	if($settings['title_heading'] == ""){ $settings['title_heading'] = "h2"; }
	if($settings['title_style'] == ""){ $settings['title_style'] = "1"; }
	
	if(!isset($settings['desc'])){ $settings['desc'] = ""; } 
	
	$hclass = $settings['title_heading'];
	
	  
	if($settings['title_pos'] == ""){ $settings['title_pos'] = "left"; }
	switch($settings['title_pos']){
	
		case "left": {
		$txtdir = "text-center text-md-left";
		} break;
		case "right": {
		$txtdir = "text-center text-md-right";
		} break;
		case "center": {
		$txtdir = "text-center";
		} break;	
	}
	 
	
	
	// TRANSLATIONS 
	$settings['title'] 		= __($settings['title'],"premiumpress");
	$settings['subtitle'] 	= __($settings['subtitle'],"premiumpress"); 
	$settings['desc'] 		= __($settings['desc'],"premiumpress"); 
 
	switch($settings['title_style']){
	 	
			// H1 STYLES
			case "1":
			 { 
				
			?>
            
            <div class="<?php echo $txtdir; ?>">
			
			<<?php echo $hclass; ?> 
            data-elementor-setting-key="title" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing <?php echo $settings['title_margin']; ?> 
            font-<?php echo $settings['title_font'];  ?> 
            text-<?php echo $settings['title_txtcolor']; ?> <?php echo $settings['title_txtw']; ?>"><?php echo $settings['title'];  ?></<?php echo $hclass; ?>>
            
            <?php if(strlen($settings['subtitle']) > 1){ ?>
			<p data-elementor-setting-key="subtitle" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing lead text-<?php echo $settings['subtitle_txtcolor']; ?> font-<?php echo $settings['subtitle_font'];  ?> text-500 <?php echo $settings['subtitle_margin']; ?> <?php echo $settings['subtitle_txtw']; ?>"><?php echo $settings['subtitle']; ?></p> 
            <?php } ?>
            
            <?php if(strlen($settings['desc']) > 1){ ?>            
			<p data-elementor-setting-key="desc" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing line-height-30 <?php echo $settings['desc_margin']; ?> font-<?php echo $settings['desc_font'];  ?> text-<?php echo $settings['desc_txtcolor']; ?>"><?php echo do_shortcode($settings['desc']); ?></p> 
            <?php } ?> 
            
            </div>         
			
			<?php  
			
			} break;
			
			// STYLE 2
			case "2":
		  { 
				
			?> 
            
            <div class="<?php echo $txtdir; ?>">
            
			<div data-elementor-setting-key="title" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing text-<?php echo $settings['title_txtcolor']; ?> font-<?php echo $settings['title_font'];  ?> <?php echo $settings['title_margin']; ?> <?php echo $settings['title_txtw']; ?>"><?php echo $settings['title'];  ?></div> 
            
            <?php if(strlen($settings['subtitle']) > 1){ ?>
			<<?php echo $hclass; ?> data-elementor-setting-key="subtitle" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing <?php echo $settings['subtitle_margin']; ?> font-<?php echo $settings['subtitle_font'];  ?> text-<?php echo $settings['subtitle_txtcolor']; ?> <?php echo $settings['subtitle_txtw']; ?>"><?php echo $settings['subtitle']; ?></<?php echo $hclass; ?>> 
            <?php } ?>          
            
            <?php if(strlen($settings['desc']) > 1){ ?>            
			<p data-elementor-setting-key="desc" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing line-height-30 <?php echo $settings['desc_margin']; ?> font-<?php echo $settings['desc_font'];  ?> text-<?php echo $settings['desc_txtcolor']; ?>"><?php echo do_shortcode($settings['desc']); ?></p> 
            <?php } ?> 
            
            </div>          
			
			<?php  
			
			} break;				

			// H1 STYLE 3
			case "3":
		  	{ 
				
			?> 
            
            <div class="<?php echo $txtdir; ?>">
            
			<<?php echo $hclass; ?> data-elementor-setting-key="title" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing <?php echo $settings['title_margin']; ?> font-<?php echo $settings['title_font'];  ?> text-<?php echo $settings['title_txtcolor']; ?> <?php echo $settings['title_txtw']; ?>"><?php echo $settings['title'];  ?></<?php echo $hclass; ?>>
            
            <?php if(strlen($settings['subtitle']) > 1){ ?>
			<p data-elementor-setting-key="subtitle" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing lead text-<?php echo $settings['subtitle_txtcolor']; ?> font-<?php echo $settings['subtitle_font'];  ?> text-500 <?php echo $settings['subtitle_margin']; ?> <?php echo $settings['subtitle_txtw']; ?>"><?php echo $settings['subtitle']; ?></p> 
            <?php } ?>
            
             <hr style="width:50px; height:3px;" class="bg-primary my-4  <?php if($settings['title_pos'] == "center"){ ?>mx-auto<?php } ?>" />
            
            <?php if(strlen($settings['desc']) > 1){ ?>            
			<p data-elementor-setting-key="desc" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing line-height-30 <?php echo $settings['desc_margin']; ?> font-<?php echo $settings['desc_font'];  ?> text-<?php echo $settings['desc_txtcolor']; ?>"><?php echo do_shortcode($settings['desc']); ?></p> 
            <?php } ?>  
             
		    </div>      
			
			<?php  
			
			} break;	
			
			
			
			// H1 STYLE 4
			case "4":
		  	{ 
				
			?> 
            
            <div class="<?php echo $txtdir; ?>">
            
			<<?php echo $hclass; ?> data-elementor-setting-key="title" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing <?php echo $settings['title_margin']; ?> font-<?php echo $settings['title_font'];  ?> text-<?php echo $settings['title_txtcolor']; ?> <?php echo $settings['title_txtw']; ?>"><?php echo $settings['title'];  ?></<?php echo $hclass; ?>>
            
            <?php if(strlen($settings['subtitle']) > 1){ ?>
			<p data-elementor-setting-key="subtitle" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing lead text-<?php echo $settings['subtitle_txtcolor']; ?> font-<?php echo $settings['subtitle_font'];  ?> text-500 <?php echo $settings['subtitle_margin']; ?> <?php echo $settings['subtitle_txtw']; ?>"><?php echo $settings['subtitle']; ?></p> 
            <?php } ?>
            
            <?php if(strlen($settings['desc']) > 1){ ?>            
			<p data-elementor-setting-key="desc" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing line-height-30 <?php echo $settings['desc_margin']; ?> font-<?php echo $settings['desc_font'];  ?> text-<?php echo $settings['desc_txtcolor']; ?>"><?php echo do_shortcode($settings['desc']); ?></p> 
            <?php } ?>  
            
            
             <hr style="width:50px; height:3px;" class="bg-primary my-4  <?php if($settings['title_pos'] == "center"){ ?>mx-auto<?php } ?>" />
            
             
		    </div>      
			
			<?php  
			
			} break;	
			
			
			// H1 STYLE 4
			case "5":
		  	{ 
				
			?> 
            
            <div class="<?php echo $txtdir; ?>">
            
            
               <?php if(strlen($settings['subtitle']) > 1){ ?>
			<div class="badge <?php if(isset($settings['section_bg']) && $settings['section_bg'] == "bg-light"){?>bg-dark text-light<?php  }else{ ?>bg-white text-dark<?php } ?> mb-4 hide-mobile" style="font-size:14px; font-weight:600; padding: 5px 10px;" data-elementor-setting-key="subtitle" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing text-<?php echo $settings['subtitle_txtcolor']; ?> font-<?php echo $settings['subtitle_font'];  ?> text-500 <?php echo $settings['subtitle_margin']; ?> <?php echo $settings['subtitle_txtw']; ?>"><?php echo $settings['subtitle']; ?></div> 
            <?php } ?>
            
			<<?php echo $hclass; ?> data-elementor-setting-key="title" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing <?php echo $settings['title_margin']; ?> font-<?php echo $settings['title_font'];  ?> text-<?php echo $settings['title_txtcolor']; ?> <?php echo $settings['title_txtw']; ?>"><?php echo $settings['title'];  ?></<?php echo $hclass; ?>>
            
         
            
            <?php if(strlen($settings['desc']) > 1){ ?>            
			<p data-elementor-setting-key="desc" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing line-height-30 <?php echo $settings['desc_margin']; ?> font-<?php echo $settings['desc_font'];  ?> text-<?php echo $settings['desc_txtcolor']; ?>"><?php echo do_shortcode($settings['desc']); ?></p> 
            <?php } ?>  
            
            
             
		    </div>      
			
			<?php  
			
			} break;	
			
			
			
			// H1 STYLE 4
			case "6":
		  	{ 
				
			?> 
            
            <div class="<?php echo $txtdir; ?>">
            
            
               <?php if(strlen($settings['btn2_icon']) > 1){ ?>
			<i class="<?php echo $settings['btn2_icon']; ?> fa-3x mb-4"></i>
            <?php }else{ ?>
            <i class="fal fa-layer-group fa-3x mb-4"></i>
            <?php } ?>
            
			<<?php echo $hclass; ?> data-elementor-setting-key="title" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing <?php echo $settings['title_margin']; ?> font-<?php echo $settings['title_font'];  ?> text-<?php echo $settings['title_txtcolor']; ?> <?php echo $settings['title_txtw']; ?>"><?php echo $settings['title'];  ?></<?php echo $hclass; ?>>
            
         
            
            <?php if(strlen($settings['desc']) > 1){ ?>            
			<p data-elementor-setting-key="desc" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing line-height-30 <?php echo $settings['desc_margin']; ?> font-<?php echo $settings['desc_font'];  ?> text-<?php echo $settings['desc_txtcolor']; ?>"><?php echo do_shortcode($settings['desc']); ?></p> 
            <?php } ?>  
            
            
             
		    </div>      
			
			<?php  
			
			} break;
				
			  


 }

}
?>