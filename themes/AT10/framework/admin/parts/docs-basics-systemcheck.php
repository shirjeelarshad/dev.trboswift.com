<?php

global $settings;
 
  $settings = array("title" => "System Check", "desc" => "Here you can see any hosting issues with your current installation.");
   _ppt_template('framework/admin/_form-wrap-top' ); ?>

<div class="card card-admin">
  <div class="card-body text-center">
    <?php ppt_system_check(true); ?>
  </div>
</div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
