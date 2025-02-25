<?php global $settings;  ?>

 
<div class="">
<div class="row">
<div class="col-md-4 pr-lg-4">
  <h3 class="mt-4"><?php echo $settings['title']; ?></h3>
  <p class="text-muted lead"><?php echo $settings['desc']; ?></p>
 
 
 
  <?php if(isset($settings['plugin']) && is_array($settings['plugin'])){ ?>
 
 <a href="<?php echo $settings['plugin']['link']; ?>" class="btn btn-danger shadow-sm btn-sm px-3 popup-yt mb-4"><i class="fa fa-download mr-1"></i> <?php echo $settings['plugin']['name']; ?></a>
 
  <?php } ?>
 
  <?php if(isset($settings['video']) && !is_array($settings['video']) && strlen($settings['video']) > 2){ ?>
  <a href="<?php echo $settings['video']; ?>" class="btn btn-danger shadow-sm btn-sm px-3 popup-yt mb-4"><i class="fa fa-video mr-1"></i> <?php echo __("watch video","premiumpress"); ?></a>
  
  <?php }elseif(isset($settings['video']) && is_array($settings['video'])){ ?>
  
  <h3 class="mt-4"><i class="fa fa-video mr-1"></i> <?php echo __("Video Tutorials","premiumpress"); ?></h3>
  
  <div class="pr-lg-3">
  <?php $i=1; foreach($settings['video'] as $vid){ ?>
  
  <div class="mt-4"><a href="<?php echo $vid['link']; ?>" class=" popup-yt mb-4 text-dark opacity-5"> <?php echo $i; ?>. <?php echo $vid['title']; ?></a></div>
  
  <?php $i++; } ?>
  </div>
  <?php } ?>
  
  
  
  <?php if(isset($settings['link']) && strlen($settings['link']) > 2){ ?>
  <div> <a href="<?php echo $settings['link']; ?>" class="btn btn-dark shadow-sm btn-sm" target="_blank"><i class="fa fa-link mr-1"></i> <?php echo __("visit website","premiumpress"); ?></a> </div>
  <?php } ?>
</div>
<div class="col-md-8">
