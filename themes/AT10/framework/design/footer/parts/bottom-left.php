<?php global $settings; ?>

<div class="row px-0">
  <div class="col-md-12">
    <div class="copyright opacity-8">
      <?php if(isset($settings['footer_copyright']) && strlen($settings['footer_copyright']) > 2){ ?>
      <?php echo $settings['footer_copyright']; ?>
      <?php }else{ ?>
      &copy; <?php echo date("Y"); ?> <?php echo stripslashes(_ppt(array('company','name'))); ?>. <?php echo __("All rights reserved.","premiumpress"); ?>
      <?php } ?>
    </div>
  </div>
</div>
