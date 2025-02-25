<div class="container px-0">
    <div class="row">
    
    
        <div class="col-md-4 pr-lg-4">                
        <h3 class="mt-4"><?php echo __("Confirmation Email","premiumpress"); ?></h3>        
        <p class="text-muted lead mb-4">
        
        <?php echo __("This email is sent to a user when they join your newsletter.","premiumpress"); ?>
        
        
        </p>
        
         <a href="https://www.youtube.com/watch?v=A23nzR48OkU" class="btn btn-danger text-light mt-4 shadow-sm btn-sm px-3 popup-yt"><i class="fa fa-video mr-1"></i> <?php echo __("watch video","premiumpress"); ?></a>
   
        
        
        </div>
        <div class="col-md-8">            
        
        
        
        <div class="card card-admin"><div class="card-body">   
        
        
        
        
         <div class="row border-bottom pb-3 mb-3">
            <div class="col-md-8 ">
              <label class="font-weight-bold mb-2"><?php echo __("Newsletter System","premiumpress"); ?></label>
              <p class="text-muted"><?php echo __("Turn on/off to enable the built-in newsletter system.","premiumpress"); ?></p>
            </div>
            <div class="col-md-2 mt-3 formrow">
              <div class="">
                <label class="radio off">
                <input type="radio" name="toggle" 
                     value="off" onchange="document.getElementById('enablenewsl').value='0'">
                </label>
                <label class="radio on">
                <input type="radio" name="toggle"
                     value="on" onchange="document.getElementById('enablenewsl').value='1'">
                </label>
                <div class="toggle <?php if( _ppt(array('newsletter','enable')) == '1'){  ?>on<?php } ?>">
                  <div class="yes">ON</div>
                  <div class="switch"></div>
                  <div class="no">OFF</div>
                </div>
              </div>
              <input type="hidden" id="enablenewsl" name="admin_values[newsletter][enable]" value="<?php echo _ppt(array('newsletter','enable')); ?>">
            </div>
          </div>
        
        
       
       
       
         <div class="row border-bottom pb-3 mb-3">
            <div class="col-md-8 ">
              <label class="font-weight-bold mb-2"><?php echo __("Use Built-in Newsletter System","premiumpress"); ?></label>
              <p class="text-muted"><?php echo __("Turn on/off the built-in newsletter system.","premiumpress"); ?></p>
            </div>
            <div class="col-md-2 mt-3 formrow">
              <div class="">
                <label class="radio off">
                <input type="radio" name="toggle" 
                     value="off" onchange="document.getElementById('newsdefault').value='0'">
                </label>
                <label class="radio on">
                <input type="radio" name="toggle"
                     value="on" onchange="document.getElementById('newsdefault').value='1'">
                </label>
                <div class="toggle <?php if( _ppt(array('newsletter','newsdefault')) == '1'){  ?>on<?php } ?>">
                  <div class="yes">ON</div>
                  <div class="switch"></div>
                  <div class="no">OFF</div>
                </div>
              </div>
              <input type="hidden" id="newsdefault" name="admin_values[newsletter][newsdefault]" value="<?php if(_ppt(array('newsletter','newsdefault')) == ""){ echo 1; }else{ echo _ppt(array('newsletter','newsdefault')); } ?>">
            </div>
          </div> 
       
       
       
       
       
       
       
       
       
       
<div <?php if( _ppt(array('newsletter','newsdefault')) == 1 ){  ?>style="display:none;"<?php } ?>>   
 
 <label class="font-weight-bold mb-2"><?php echo __("Custom Form Shortcode.","premiumpress"); ?></label>
 
 <p class="text-muted"><?php echo __("Here you can enter your own newsletter signup form shortcodes which will replace the default theme display.","premiumpress"); ?></p>
    
 <textarea class="form-control" style="height:300px !important;" name="admin_values[newsletter][customcode]"><?php echo _ppt(array('newsletter','customcode')); ?></textarea>

</div>
       
       

<div <?php if( _ppt(array('newsletter','newsdefault')) == 0 ){  ?>style="display:none;"<?php } ?>>   
 
        
          
            
            <label class="txt500"><?php echo __("Email Subject","premiumpress"); ?></label>
             
            
             <input type="text" class="form-control"  name="admin_values[newsletter][confirmation_title]" value="<?php 
			 
			 if(stripslashes(_ppt(array('newsletter','confirmation_title'))) == ""){
			 
			 echo __("Please confirm your email!","premiumpress");
			 
			 }else{
			 
			 echo stripslashes(_ppt(array('newsletter','confirmation_title'))); 
			 
			 }
			 
			 ?>">  
             
             <div class="mt-3 mb-3">
             <style>
				.wp-switch-editor, .tmce-active .switch-tmce, .html-active .switch-html { height:27px !important; }
				</style>
             <?php 
			 
			 
			 if(_ppt(array('newsletter','confirmation_message')) == ""){
			 
			 $mdata = __("Thank you for joining our mailing list.

Please click the link below to confirm your email address is valid:

(link)

Kind Regards

Management","premiumpress");

			 }else{
			 $mdata = _ppt(array('newsletter','confirmation_message'));
			 }
			 
			 
			 echo wp_editor( $mdata , 'ppt_email', array( 'textarea_name' => 'admin_values[newsletter][confirmation_message]', 'editor_height' => '200px') );  ?>
 			
            </div>
            
            
 
            
            <p class="alert alert-info"><i class="fa fa-info-circle mr-1"></i> <b><?php echo __("Remember","premiumpress"); ?></b> <?php echo __("Use the short code <code>(link)</code> within your email above where you want the confirmation link to display.","premiumpress"); ?></p>
            
         
        
        
       
        
            <label class="txt500"><?php echo __("Thank You Page","premiumpress"); ?></label>
             
             <input type="text"  class="form-control" name="admin_values[newsletter][thankyoupage]" placeholder="http://" value="<?php echo _ppt(array('newsletter','thankyoupage')); ?>">
             
             
               <p class="alert alert-info mt-3"><i class="fa fa-info-circle mr-1"></i> <b><?php echo __("Example","premiumpress"); ?></b> http://mywebiste.com/thankyou/</p>
            
            
             
             
             <p class="py-2 text-muted"><?php echo __("This is the page users are sent to after they click the confirmation link within the email.","premiumpress"); ?></p>
           
            <label class="txt500"><?php echo __("Unsubscribe Page","premiumpress"); ?></label>
              <input type="text"  class="form-control" name="admin_values[newsletter][unsubscribepage]" placeholder="http://" value="<?php echo _ppt(array('newsletter','unsubscribepage'));?>">
              
              
               <p class="alert alert-info mt-3"><i class="fa fa-info-circle mr-1"></i> <b><?php echo __("Example","premiumpress"); ?></b> http://mywebiste.com/unsubscribe/</p>
            
              
              <p class="py-2 text-muted"><?php echo __("This is the page users are sent to after they click the unsubscribe link within an email.","premiumpress"); ?></p>
              
           
        
           
            
            
            
            
            
            
            
            
            
     <hr />
     
     
     
     
     
     
</div> 
     
     
        
        
              
   
         <div class="p-4 bg-light text-center mt-4">
         <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    	</div>
        
        
        </div><!-- end col 8 -->
      

    </div></div>  <!-- end admin card -->
        
        

</div></div>  <!-- end row -->
        
              
             