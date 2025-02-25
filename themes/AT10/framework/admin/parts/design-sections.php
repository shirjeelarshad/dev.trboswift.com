<?php

global $settings;

  $settings = array(
  "title" => __("Announcements","premiumpress"), 
  "desc" => __("This will display a bar at the top of your website.","premiumpress"),
  "video" => "https://www.youtube.com/watch?v=y8wH_LyLbeM",
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?> 
        
        
		<div class="card card-admin"><div class="card-body">



<div class="container my-4 ">
<div class="row">


   
         <div class="col-3">                  
                                     
                                      <label class="radio off" >
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('div_notify').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('div_notify').value='1'">
                                      </label>
                                      <div class="toggle <?php if(_ppt(array('design','notify')) == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                      
<input type="hidden" id="div_notify" name="admin_values[design][notify]"  value="<?php if(in_array(_ppt(array('design','notify')), array("",0)) ){ echo 0; }else{ echo 1; } ?>"> 
                                 </div>
                               
    <div class="col-9">
    
        <label><?php echo __("Enable","premiumpress"); ?></label>
        
        <p class="text-muted"><?php echo __("Turn on/off this option.","premiumpress"); ?></p>
   </div>  
   
   
<div class="col-12">

<label><?php echo __("Text","premiumpress"); ?></label>

<input class="form-control" name="admin_values[design][notify_text]"  type="text" value="<?php if(_ppt(array('design','notify_text')) == ""){ echo "Summer Sale 50% off everything! "; }else{  echo _ppt(array('design','notify_text')); } ?>" />


</div>  

<div class="col-12 mt-4">

<label><?php echo __("Link","premiumpress"); ?></label>

<input class="form-control" name="admin_values[design][notify_link]"  type="text" value="<?php if(_ppt(array('design','notify_link')) == ""){ echo home_url()."/?s="; }else{  echo _ppt(array('design','notify_link')); } ?>" />


</div>          

</div></div>
   
      
 

<div class="p-4 bg-light text-center mt-4">
         <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    	</div>


      
        </div></div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>