<?php

global $settings;

  $settings = array(
  "title" => __("Colors","premiumpress"), 
  "desc" => __("Here you can setup custom colors for your website.","premiumpress"),
  "video" => "https://www.youtube.com/watch?v=y8wH_LyLbeM",
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>      
        
		<div class="card card-admin"><div class="card-body">






   
  
 <div class="row">
   <div class="col-md-6">
   
   
   <div style="border-radius:4px; background:<?php echo _ppt(array('design','color_bg')); ?>" class="shadow-sm m-3 py-4 border text-center">
  
   <div style="font-size:30px; font-weight:bold; color:<?php echo _ppt(array('design','color_text')); ?>" class="py-4"><?php echo __("Text Color","premiumpress"); ?></div>
 
   
   </div>
    
   </div>
   <div class="col-md-6">
   
   <div class="row px-3">
   <div class="col-12">
      <label class="txt500"><?php echo __("Website Background","premiumpress"); ?></label>
   
   <div class="input-group myColorPicker">
					  <span class="input-group-addon myColorPicker-preview px-3 border mr-2">&nbsp;</span>
					  <input type="text" class="form-control" id="w1" name="admin_values[design][color_bg]" value="<?php echo _ppt(array('design','color_bg'));  ?>" autocomplete="off">
					</div>
                    
      </div>
      
      
      <div class="col-12 mt-4">              
     
   <label class="txt500"><?php echo __("Body Text Color","premiumpress"); ?></label>
   
   <div class="input-group myColorPicker">
					  <span class="input-group-addon myColorPicker-preview px-3 border mr-2">&nbsp;</span>
					  <input type="text" class="form-control" id="w2" name="admin_values[design][color_text]" value="<?php echo _ppt(array('design','color_text')); ?>" autocomplete="off">
					</div>
                    
    </div></div>   
    
    
 

    
</div></div>

<hr />



 <div class="row">
   <div class="col-md-6">
   
   
   <div style="border-radius:4px; background:<?php echo _ppt(array('design','color_bgdark')); ?>" class="shadow-sm m-3 py-4 border text-center">
  
   <div class="text-primary" style="font-size:30px; font-weight:bold; <?php if(_ppt(array('design','color_primary')) != ""){ ?>color:<?php echo _ppt(array('design','color_primary')); } ?> !important"><?php echo __("Primary Text","premiumpress"); ?></div>
   
   <div class="text-secondary mt-3 pb-4 font-weight-bold" style="<?php if(_ppt(array('design','color_secondary')) != ""){ ?>color:<?php echo _ppt(array('design','color_secondary')); } ?> !important;"><?php echo __("Secondary color","premiumpress"); ?></div>
   
   
   </div>
    
   </div>
   <div class="col-md-6">
   
   <div class="row px-3">
   <div class="col-12">
    <label class="txt500"><?php echo __("Primary Color","premiumpress"); ?></label>
   
   <div class="input-group myColorPicker">
					  <span class="input-group-addon myColorPicker-preview px-3 border mr-2">&nbsp;</span>
					  <input type="text" class="form-control" id="pc1" name="admin_values[design][color_primary]" value="<?php echo _ppt(array('design','color_primary')); ?>" autocomplete="off">
					</div>
      </div>
      <div class="col-12 mt-4">              
                    <label class="txt500"><?php echo __("Secondary Color","premiumpress"); ?></label>
  
  
   <div class="input-group myColorPicker">
					  <span class="input-group-addon myColorPicker-preview px-3 border mr-2">&nbsp;</span>
					  <input type="text" class="form-control" id="pc3" name="admin_values[design][color_secondary]" value="<?php echo _ppt(array('design','color_secondary')); ?>" autocomplete="off">
					</div>


    </div></div>   

    
</div></div>

<hr />

 <div class="row">
   <div class="col-md-6 mt-4">
   
   
   <div class="row mx-4 text-center">
   <div class="col-6 bg-dark" style="height:130px; border-radius:4px; <?php if(_ppt(array('design','color_bgdark')) != ""){ ?>background:<?php echo _ppt(array('design','color_bgdark')); ?> !important; <?php } ?>" >
   
   
   <i class="fa fa-circle text-white" style="padding-top:30px; font-size:70px; font-weight:bold;"></i>
   
   </div>
   <div class="col-6 bg-light" 
   style="height:130px; border-radius:4px; <?php if(_ppt(array('design','color_bglight')) != ""){ ?> background:<?php echo _ppt(array('design','color_bglight')); ?> !important; <?php } ?>">
   
   <i class="fa fa-circle text-dark" style="padding-top:30px; font-size:70px; font-weight:bold;"></i>
   </div>
   </div>
   
   
   
   
    
   </div>
   <div class="col-md-6 mt-3">
      <div class="row px-3">
   <div class="col-12">
   
        <label class="txt500"><?php echo __("Dark Background","premiumpress"); ?></label>
   
   <div class="input-group myColorPicker">
					  <span class="input-group-addon myColorPicker-preview px-3 border mr-2">&nbsp;</span>
					  <input type="text" class="form-control" id="pc2" name="admin_values[design][color_bgdark]" value="<?php echo _ppt(array('design','color_bgdark'));  ?>" autocomplete="off">
					</div>

   </div><div class="col-12 mt-4">
   
   <label class="txt500"><?php echo __("Light Background","premiumpress"); ?></label>
  
  
   <div class="input-group myColorPicker">
					  <span class="input-group-addon myColorPicker-preview px-3 border mr-2">&nbsp;</span>
					  <input type="text" class="form-control" id="pc4" name="admin_values[design][color_bglight]" value="<?php echo _ppt(array('design','color_bglight'));  ?>" autocomplete="off">
					</div>  
</div></div> 
    
</div></div>

 

<?php /* if(THEME_KEY == "da"){ ?>  
<div class="row py-3 mt-4">
<div class="col-6">

   <label class="txt500">Male Profile Color</label>
   
   <div class="input-group myColorPicker">
					  <span class="input-group-addon myColorPicker-preview px-3 border mr-2">&nbsp;</span>
					  <input type="text" class="form-control" name="admin_values[design][color_male]" value="<?php echo _ppt('color_male'); ?>">
					</div>
   
   

</div>
<div class="col-6">

<label class="txt500">Female Profile Color</label>
  
  
   <div class="input-group myColorPicker">
					  <span class="input-group-addon myColorPicker-preview px-3 border mr-2">&nbsp;</span>
					  <input type="text" class="form-control" name="admin_values[design][color_female]" value="<?php echo _ppt('color_female'); ?>">
					</div>

</div>
</div> 
<?php } */ ?>  







<div class="p-4 bg-light text-center mt-4">
         <button type="submit" class="btn btn-admin"> <?php echo __("Save Settings","premiumpress"); ?></button>
    	</div>



 
 










      
     
        
        </div></div>
        
        
        
        
        
     
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?> 