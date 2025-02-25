<?php global $settings; ?>

<div class="row px-0">
  <div class="col-md-6">
   
  
 
  
    <div class="copyright opacity-8 d-flex flex-column align-items-start d-md-block">
      <img width="150px" class="mb-2 m-md-0" src="<?php echo home_url(); ?>/wp-content/uploads/2024/02/logo-4__dragged_-removebg-preview-1.png" />
      <?php if(isset($settings['footer_copyright']) && strlen($settings['footer_copyright']) > 2){ ?>
      <?php echo $settings['footer_copyright']; ?>
      <?php }else{ ?>
      &copy; <?php echo date("Y"); ?> <?php echo stripslashes(_ppt(array('company','name'))); ?>. <?php echo __("All rights reserved.","premiumpress"); ?>
      <?php } ?>
    </div>
  </div>
  <div class="col-md-6 d-flex d-md-block justify-content-between text-md-right ">
  
  
    <?php if(isset($settings['footer_menu1']) && strlen($settings['footer_menu1']) > 2){ ?>
    
    <?php echo str_replace("menu-item","list-inline-item", str_replace("nav-link","opacity-8",do_shortcode('[MAINMENU menu_name="'.$settings['footer_menu1'].'" class="list-inline"][/MAINMENU]'))); ?>
    <?php }else{ ?>
    
    <?php  echo str_replace("menu-item","list-inline-item", str_replace("<li>","<li class='list-inline-item'>", str_replace("list-unstyled","list-inline", str_replace("nav-link","opacity-8",do_shortcode('[MAINMENU footer=1 class="list-inline"][/MAINMENU]')))));  ?>
    
    <?php } ?>
  </div>
</div>