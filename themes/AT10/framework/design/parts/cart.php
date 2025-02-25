<?php
global $settings;

if($settings['btn_show'] == "yes"){ 

$settings['btn_search'] = "yes";
$settings['btn_currency']  = "yes";
$settings['btn_language'] = "yes";
$settings['btn_myaccount'] = "yes";
?>

 
<ul class="list-inline small-list mb-0">
            
            
            <?php if(   $settings['btn_myaccount'] == "yes" ){ ?>
            <li class="list-inline-item w usericon hide-mobile">
             
           
            <a href="<?php echo _ppt(array('links','myaccount')); ?>" class="tm"><i class="fal fa-user-circle"></i></a>
                       
            </li>
            <?php } ?>
            
            <?php if($settings['btn_search'] == "yes"){  ?>
            <li class="list-inline-item w hide-mobile">
            <a href="<?php echo home_url(); ?>/?s=" class="tm"><i class="fal fa-search"></i></a>
            </li> 
            <?php } ?>
            
                 
            <?php /* if(is_array($currency) && !empty($currency) && $settings['btn_currency'] == "yes" ){ ?> 
            <li class="list-inline-item dropdown w  hide-mobile"> 
             
              <a href="#" class="dropdown-toggle noc" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fal fa-dollar-sign"></i></a>
             
              <div class="dropdown-menu">
              <?php  foreach($currency as $h){ ?>
              
               <a class="dropdown-item" href="<?php echo $h['link']; ?>"> <span class="text-muted float-right"><?php echo $h['icon']; ?></span> <?php echo $h['name']; ?></a> 
                  
              <?php } ?>       
              </div> 
             
            </li> 
            <?php } */ ?>  
              
            <?php /*if(is_array($languages) && !empty($languages) && $settings['btn_language'] == "yes"  ){ ?>
             <li class="list-inline-item w dropdown hide-mobile">
               
              <a href="#" class="dropdown-toggle noc" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-globe"></i></a>
             
              <div class="dropdown-menu">
              <?php foreach($languages as $h){ ?>
              
               <a class="dropdown-item" href="<?php echo $h['link']; ?>"><i class="<?php echo $h['icon']; ?> float-right mt-2"></i>  <?php echo $h['name']; ?></a> 
                  
              <?php } ?>       
              </div>  
             
            </li>
            <?php } */ ?>
			 
           
             <li class="list-inline-item hide-mobile">
             <a href="<?php echo _ppt(array('links','cart')); ?>" class="tm"> <span class="cart-basket-count-wrapper"><span class="cart-basket-count bg-primary text-white">0</span></span> <i class="fal fa-shopping-basket"></i></a>
             
            </li>
              
             <?php /*
            <li class="list-inline-item ">
            
             <button class="navbar-toggler menu-toggle tm">
               <div class="fal fa-bars"></div>
               </span>
            </button> 
            </li>
			*/ ?>
                   
</ul>
<?php

}
?>

