<?php

global $settings;
 
  $settings = array("title" => "Shortcodes", "desc" => "Here is a list of all the shortcodes used within this framework.");
   _ppt_template('framework/admin/_form-wrap-top' ); ?>  
    
    
    <div class="card card-admin"><div class="card-body">
    
 
<?php
global $shortcode_tags;

foreach(_ppt_shortcodelist() as $c){

 
?>
<div class="bg-white p-3 border-bottom mb-4">
<div class="row">
<div class="col-6">
<h6 class="mb-2"><?php echo $c['name']; ?></h6>

<p class="pb-0 mb-0"><?php echo $c['desc']; ?></p>

</div>
<div class="col-6">
<textarea class="form-control w-100" style="padding-top:10px !important;">
<?php echo $c['example']; ?>
</textarea>
</div>
</div>
</div>
<?php }  ?>
   


</div> </div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>  