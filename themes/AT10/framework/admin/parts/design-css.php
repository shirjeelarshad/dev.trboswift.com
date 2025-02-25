<div class="container px-0">
    <div class="row">
        <div class="col-md-4 pr-lg-4">                
        <h3 class="mt-4"><?php echo __("Custom CSS","premiumpress"); ?></h3>        
        <p class="text-muted lead mb-4"><?php echo __("Here you can enter your own custom CSS/meta code.","premiumpress"); ?></p>
        </div>
        <div class="col-md-8">            
        
		<div class="card card-admin"><div class="card-body">


 
<textarea class="form-control" style="height:300px !important;font-size:11px;" name="adminArray[custom_head]"><?php echo stripslashes(get_option('custom_head')); ?></textarea>

<small><strong><?php echo __("Note","premiumpress"); ?>:</strong>  <?php echo __("Tags are already included so do not enter them above.","premiumpress"); ?></small> 
        
        
 
        
        
        
        
         <div class="p-4 bg-light text-center mt-4">
         <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    	</div>
        
        </div></div>
        </div>
        
        
</div></div>


  
<div class="container px-0">
    <div class="row">
        <div class="col-md-4 pr-lg-4">                
        <h3 class="mt-4"><?php echo __("Custom JS","premiumpress"); ?></h3>        
        <p class="text-muted lead mb-4"><?php echo __("Here you can enter your own javascript code.","premiumpress"); ?></p>
        </div>
        <div class="col-md-8">            
        
		<div class="card card-admin"><div class="card-body">
        
  <textarea class="form-control" style="height:300px !important;font-size:11px;" name="adminArray[custom_js]"><?php echo stripslashes(get_option('custom_js')); ?></textarea>
 
        
         <div class="p-4 bg-light text-center mt-4">
         <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    	</div>
        
        
        </div></div>
        </div>
        
        
</div></div>