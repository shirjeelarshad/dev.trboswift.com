<?php
global $settings, $userdata; 

 if ($userdata->ID) {
     
     if(ISSET($settings['btn_show'] ) && $settings['btn_show'] == "yes"){ 

 
 
 	// CHECK FOR DISABLED BUTTONS
	if(_ppt(array('lst','websitepackages')) == 0 && $settings['btn_link'] == _ppt(array('links','add'))){ 	
	return "";
	}

	if($settings['btn_txt'] == ""){ $settings['btn_txt'] = ""; }
	if($settings['btn_bg'] == ""){ $settings['btn_bg'] = "primary"; }
	if($settings['btn_bg_txt'] == ""){ $settings['btn_bg_txt'] = ""; }	
	if($settings['btn_size'] == ""){ $settings['btn_size'] = "btn-md"; }
	if($settings['btn_icon'] == ""){ $settings['btn_icon'] = ""; }
	
	$settings['btn_icon'] = str_replace("far", "fa", $settings['btn_icon']);
	
	if($settings['btn_icon_pos'] == ""){ $settings['btn_icon_pos'] = "before"; }	
	if($settings['btn_style'] == ""){ $settings['btn_style'] = "2"; }
	
	
	// TRANSLATIONS 
	$settings['btn_txt'] 		= __($settings['btn_txt'],"premiumpress");
  
	 
	switch($settings['btn_style']){
	
	
		case "2": { // outlined
		
		?>
	<a href="<?php echo $settings['btn_link']; ?>" class="btn btn-border-2 font-<?php echo $settings['btn_font'];  ?> <?php echo $settings['btn_size']; ?> btn-outline-<?php echo $settings['btn_bg']; ?> <?php echo $settings['btn_bg_txt']; ?> <?php echo $settings['btn_margin']; ?> <?php if(isset($settings['btn_video'])){ ?>popup-yt<?php } ?> <?php if(strlen($settings['btn_icon']) > 1){ ?>btn-icon icon-<?php echo $settings['btn_icon_pos']; ?><?php } ?>">
	
    <?php if($settings['btn_icon'] != "" && $settings['btn_icon_pos'] == "before"){ ?><i class="mr-1 <?php echo $settings['btn_icon']; ?>"></i> <?php } ?>
    
	<span data-elementor-setting-key="btn_txt" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing"><?php echo $settings['btn_txt']; ?></span>
   
    <?php if($settings['btn_icon'] != "" && $settings['btn_icon_pos'] == "after"){ ?><i class="<?php echo $settings['btn_icon']; ?>"></i> <?php } ?>
    
    </a>
    <?php } break;	
	
	case "3": { // normal rounded
?>
	<a href="<?php echo $settings['btn_link']; ?>" class="btn btn-rounded-25 font-<?php echo $settings['btn_font'];  ?> <?php echo $settings['btn_size']; ?> btn-<?php echo $settings['btn_bg']; ?> <?php echo $settings['btn_bg_txt']; ?> <?php echo $settings['btn_margin']; ?> <?php if(isset($settings['btn_video'])){ ?>popup-yt<?php } ?> <?php if(strlen($settings['btn_icon']) > 1){ ?>btn-icon icon-<?php echo $settings['btn_icon_pos']; ?><?php } ?>">

    <?php if($settings['btn_icon'] != "" && $settings['btn_icon_pos'] == "before"){ ?><i class="<?php echo $settings['btn_icon']; ?>"></i> <?php } ?>
    
	<span data-elementor-setting-key="btn_txt" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing"><?php echo $settings['btn_txt']; ?></span>
   
    <?php if($settings['btn_icon'] != "" && $settings['btn_icon_pos'] == "after"){ ?><i class="<?php echo $settings['btn_icon']; ?>"></i> <?php } ?>

    </a>
<?php	
	} break;
	
	case "4": { // outlined rounded
	?>
	<a href="<?php echo $settings['btn_link']; ?>" class="btn btn-border-2 font-<?php echo $settings['btn_font'];  ?> btn-rounded-25 <?php echo $settings['btn_size']; ?> btn-outline-<?php echo $settings['btn_bg']; ?> <?php echo $settings['btn_bg_txt']; ?> <?php echo $settings['btn_margin']; ?> <?php if(isset($settings['btn_video'])){ ?>popup-yt<?php } ?> <?php if(strlen($settings['btn_icon']) > 1){ ?>btn-icon icon-<?php echo $settings['btn_icon_pos']; ?><?php } ?>">
	
    <?php if($settings['btn_icon'] != "" && $settings['btn_icon_pos'] == "before"){ ?><i class="mr-1 <?php echo $settings['btn_icon']; ?>"></i> <?php } ?>
    
	<span data-elementor-setting-key="btn_txt" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing"><?php echo $settings['btn_txt']; ?></span>
   
    <?php if($settings['btn_icon'] != "" && $settings['btn_icon_pos'] == "after"){ ?><i class="<?php echo $settings['btn_icon']; ?>"></i> <?php } ?>
    
    </a>
	<?php
	} break;
	
	
	case "5": { // Square Edges
	?>
	<a href="<?php echo $settings['btn_link']; ?>" class="btn rounded-0 font-<?php echo $settings['btn_font'];  ?> <?php echo $settings['btn_size']; ?> btn-<?php echo $settings['btn_bg']; ?> <?php echo $settings['btn_bg_txt']; ?> <?php echo $settings['btn_margin']; ?> <?php if(isset($settings['btn_video'])){ ?>popup-yt<?php } ?> <?php if(strlen($settings['btn_icon']) > 1){ ?>btn-icon icon-<?php echo $settings['btn_icon_pos']; ?><?php } ?>">
	
    <?php if($settings['btn_icon'] != "" && $settings['btn_icon_pos'] == "before"){ ?><i class="mr-1 <?php echo $settings['btn_icon']; ?>"></i> <?php } ?>
    
	<span data-elementor-setting-key="btn_txt" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing"><?php echo $settings['btn_txt']; ?></span>
   
    <?php if($settings['btn_icon'] != "" && $settings['btn_icon_pos'] == "after"){ ?><i class="<?php echo $settings['btn_icon']; ?>"></i> <?php } ?>
    
    </a>
	<?php
	} break;			
		
	default: { // normal
		
		?>
	<a href="<?php echo $settings['btn_link']; ?>" class="btn btn-ppt font-<?php echo $settings['btn_font'];  ?> <?php echo $settings['btn_size']; ?> btn-<?php echo $settings['btn_bg']; ?> <?php echo $settings['btn_bg_txt']; ?> <?php echo $settings['btn_margin']; ?> <?php if(isset($settings['btn_video'])){ ?>popup-yt<?php } ?> <?php if(strlen($settings['btn_icon']) > 1){ ?>btn-icon icon-<?php echo $settings['btn_icon_pos']; ?><?php } ?>">

    <?php if($settings['btn_icon'] != "" && $settings['btn_icon_pos'] == "before"){ ?><i class="<?php echo $settings['btn_icon']; ?>"></i> <?php } ?>
    
	<span data-elementor-setting-key="btn_txt" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing"><?php echo $settings['btn_txt']; ?></span>
   
    <?php if($settings['btn_icon'] != "" && $settings['btn_icon_pos'] == "after"){ ?><i class="<?php echo $settings['btn_icon']; ?>"></i> <?php } ?>

    </a>
    <?php } break;
	
	}
	
	

 } 
     
}
 
 
if(isset($settings['btn2_show']) && $settings['btn2_show'] == "yes"){ 

  _ppt_template( 'framework/design/parts/btn2' );
  
}