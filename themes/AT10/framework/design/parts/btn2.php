<?php
global $settings;

if(isset($settings['btn2_show']) && $settings['btn2_show'] == "yes"){ 


// CHECK FOR DISABLED BUTTONS
	if(_ppt(array('lst','websitepackages')) == 0 && $settings['btn2_link'] == _ppt(array('links','add'))){ 	
	return "";
	}

	if($settings['btn2_txt'] == ""){ $settings['btn2_txt'] = "Search"; }
	if($settings['btn2_bg'] == ""){ $settings['btn2_bg'] = "primary"; }
	if($settings['btn2_bg_txt'] == ""){ $settings['btn2_bg_txt'] = ""; }
	
	
	if($settings['btn2_size'] == ""){ $settings['btn2_size'] = "btn-md"; }
	if($settings['btn2_icon'] == ""){ $settings['btn2_icon'] = ""; }
	$settings['btn2_icon'] = str_replace("far", "fa", $settings['btn2_icon']);
	
	
	if($settings['btn2_icon_pos'] == ""){ $settings['btn2_icon_pos'] = "before"; }
	

	// TRANSLATIONS 
	$settings['btn2_txt'] 		= __($settings['btn2_txt'],"premiumpress");
  
	switch($settings['btn2_style']){
	
	
		case "2": { // outlined
		
		?>
	<a href="<?php echo $settings['btn2_link']; ?>" class="btn btn2 btn-border-2 font-<?php echo $settings['btn2_font'];  ?> <?php echo $settings['btn2_size']; ?> btn-outline-<?php echo $settings['btn2_bg']; ?> <?php echo $settings['btn2_bg_txt']; ?> <?php echo $settings['btn2_margin']; ?> <?php if(strlen($settings['btn2_icon']) > 1){ ?>btn-icon icon-<?php echo $settings['btn2_icon_pos']; ?><?php } ?>">
	
    <?php if($settings['btn2_icon'] != "" && $settings['btn2_icon_pos'] == "before"){ ?><i class="mr-1 <?php echo $settings['btn2_icon']; ?>"></i> <?php } ?>
    
	<span data-elementor-setting-key="btn2_txt" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing"><?php echo $settings['btn2_txt']; ?></span>
   
    <?php if($settings['btn2_icon'] != "" && $settings['btn2_icon_pos'] == "after"){ ?><i class="<?php echo $settings['btn2_icon']; ?>"></i> <?php } ?>
    
    </a>
    <?php } break;	
	
	case "3": { // normal rounded
?>
	<a href="<?php echo $settings['btn2_link']; ?>" class="btn btn2 btn-rounded-25 font-<?php echo $settings['btn2_font'];  ?> <?php echo $settings['btn2_size']; ?> btn-<?php echo $settings['btn2_bg']; ?> <?php echo $settings['btn2_bg_txt']; ?> <?php echo $settings['btn2_margin']; ?> <?php if(strlen($settings['btn2_icon']) > 1){ ?>btn-icon icon-<?php echo $settings['btn2_icon_pos']; ?><?php } ?>">

    <?php if($settings['btn2_icon'] != "" && $settings['btn2_icon_pos'] == "before"){ ?><i class="<?php echo $settings['btn2_icon']; ?>"></i> <?php } ?>
    
	<span data-elementor-setting-key="btn2_txt" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing"><?php echo $settings['btn2_txt']; ?></span>
   
    <?php if($settings['btn2_icon'] != "" && $settings['btn2_icon_pos'] == "after"){ ?><i class="<?php echo $settings['btn2_icon']; ?>"></i> <?php } ?>

    </a>
<?php	
	} break;
	
	case "4": { // outlined rounded
	?>
	<a href="<?php echo $settings['btn2_link']; ?>" class="btn btn2 btn-border-2 font-<?php echo $settings['btn2_font'];  ?> btn-rounded-25 <?php echo $settings['btn2_size']; ?> btn-outline-<?php echo $settings['btn2_bg']; ?> <?php echo $settings['btn2_bg_txt']; ?> <?php echo $settings['btn2_margin']; ?> <?php if(strlen($settings['btn2_icon']) > 1){ ?>btn-icon icon-<?php echo $settings['btn2_icon_pos']; ?><?php } ?>">
	
    <?php if($settings['btn2_icon'] != "" && $settings['btn2_icon_pos'] == "before"){ ?><i class="mr-1 <?php echo $settings['btn2_icon']; ?>"></i> <?php } ?>
    
	<span data-elementor-setting-key="btn2_txt" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing"><?php echo $settings['btn2_txt']; ?></span>
   
    <?php if($settings['btn2_icon'] != "" && $settings['btn2_icon_pos'] == "after"){ ?><i class="<?php echo $settings['btn2_icon']; ?>"></i> <?php } ?>
    
    </a>
	<?php
	} break;	
	
	
	
	case "5": { // Square Edges
	?>
	<a href="<?php echo $settings['btn2_link']; ?>" class="btn btn2 rounded-0 font-<?php echo $settings['btn2_font'];  ?> <?php echo $settings['btn2_size']; ?> btn-<?php echo $settings['btn2_bg']; ?> <?php echo $settings['btn2_bg_txt']; ?> <?php echo $settings['btn2_margin']; ?> <?php if(isset($settings['btn2_video'])){ ?>popup-yt<?php } ?> <?php if(strlen($settings['btn2_icon']) > 1){ ?>btn-icon icon-<?php echo $settings['btn2_icon_pos']; ?><?php } ?>">
	
    <?php if($settings['btn2_icon'] != "" && $settings['btn2_icon_pos'] == "before"){ ?><i class="mr-1 <?php echo $settings['btn2_icon']; ?>"></i> <?php } ?>
    
	<span data-elementor-setting-key="btn2_txt" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing"><?php echo $settings['btn2_txt']; ?></span>
   
    <?php if($settings['btn2_icon'] != "" && $settings['btn2_icon_pos'] == "after"){ ?><i class="<?php echo $settings['btn2_icon']; ?>"></i> <?php } ?>
    
    </a>
	<?php
	} break;		
		
		default: { // normal
		
		?>
	<a href="<?php echo $settings['btn2_link']; ?>" class="btn btn2 btn-ppt font-<?php echo $settings['btn2_font'];  ?> <?php echo $settings['btn2_size']; ?> btn-<?php echo $settings['btn2_bg']; ?> <?php echo $settings['btn2_bg_txt']; ?> <?php echo $settings['btn2_margin']; ?> <?php if(strlen($settings['btn2_icon']) > 1){ ?>btn-icon icon-<?php echo $settings['btn2_icon_pos']; ?><?php } ?>">

    <?php if($settings['btn2_icon'] != "" && $settings['btn2_icon_pos'] == "before"){ ?><i class="<?php echo $settings['btn2_icon']; ?>"></i> <?php } ?>
    
	<span data-elementor-setting-key="btn2_txt" 
            data-elementor-inline-editing-toolbar="none" 
            class="elementor-inline-editing"><?php echo $settings['btn2_txt']; ?></span>
   
    <?php if($settings['btn2_icon'] != "" && $settings['btn2_icon_pos'] == "after"){ ?><i class="<?php echo $settings['btn2_icon']; ?>"></i> <?php } ?>

    </a>
    <?php } break;
	
	}
	
	

 } ?>