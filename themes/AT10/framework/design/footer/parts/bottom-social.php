<?php global $settings; ?>

<div class="row px-0">
  <div class="col-md-6">
    <div class="copyright opacity-8">
      <?php if(isset($settings['footer_copyright']) && strlen($settings['footer_copyright']) > 2){ ?>
      <?php echo $settings['footer_copyright']; ?>
      <?php }else{ ?>
      &copy; <?php echo date("Y"); ?> <?php echo stripslashes(_ppt(array('company','name'))); ?>. <?php echo __("All rights reserved.","premiumpress"); ?>
      <?php } ?>
    </div>
  </div>
  <div class="col-md-6 text-right d-none d-md-block">
  
        <div class="socials small <?php if(in_array($settings['section_bg'], array('bg-light','','bg-white'))){ ?>dark<?php } ?>">
          <?php if(_ppt(array('company','twitter')) != ""){ ?>
          <a class="social" target="_blank" href="<?php
		  
		   $tw_link = _ppt(array('company','twitter'));
		  if(strpos($tw_link ,"twitter.com") === false){		  
		  	$tw_link  = "https://www.twitter.com/"._ppt(array('company','twitter'));		  
		  }	
		  
		  echo $tw_link;
		  
		  
		    ?>" title="Twitter"><i class="fab fa-twitter"></i></a>
          <?php } ?>
          <?php if(_ppt(array('company','facebook')) != ""){ ?>
          <a class="social" target="_blank" href="<?php 
		  
		  $fb_link = _ppt(array('company','facebook'));
		  if(strpos($fb_link,"facebook.com") === false){		  
		  	$fb_link = "https://www.facebook.com/"._ppt(array('company','facebook'));		  
		  }	
		  
		  echo $fb_link;
		  
		  
		   ?>" title="Facebook"><i class="fab fa-facebook"></i></a>
          <?php } ?>
          <?php if(_ppt(array('company','youtube')) != ""){ ?>
          <a class="social" target="_blank" href="<?php 
		  
		  $yt_link = _ppt(array('company','youtube'));
		  if(strpos($yt_link ,"youtube.com") === false){		  
		  	$yt_link  = "https://www.youtube.com/"._ppt(array('company','youtube'));		  
		  }	
		  
		  
		  echo $yt_link; ?>" title="YouTube"><i class="fab fa-youtube"></i></a>
          <?php } ?>
          <?php if(_ppt(array('company','instagram')) != ""){ ?>
          <a class="social" target="_blank" href="<?php 
		  
		  
		   $in_link = _ppt(array('company','instagram'));
		  if(strpos($yt_link ,"instagram.com") === false){		  
		  	$in_link  = "https://www.instagram.com/"._ppt(array('company','instagram'));		  
		  }	
		  
		  echo $in_link; ?>" title="Instagram"><i class="fab fa-instagram"></i></a>
          <?php } ?>
        </div>
  
  </div>
</div>
