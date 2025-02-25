<?php

global $settings;
 
  $settings = array("title" => "Child Theme", "desc" => "Here you can compile your current childtheme and settings into a child theme.");
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
   

 <form method="post" action="" id="downloadchildtheme">
        <input type="hidden" name="dsample" value="123" />     
            
         
            </form>

<div class="card card-admin">
        <div class="card-body py-5">
        
       

<?php _ppt_template('framework/admin/_form-top' );  ?>



               
           <h5 class="mb-4"><?php echo __("Child Theme Name","premiumpress"); ?></h5> 
          
          <input type="text" name="admin_values[childtheme][name]" value="<?php  if(stripslashes(_ppt(array('childtheme', 'name'))) == ""){ echo "Child Theme"; }else{ echo stripslashes(_ppt(array('childtheme', 'name'))); }  ?>" class="form-control-lg w-100 rounded-0">
            
          
<div class="row mt-5">
<div class="col-md-6 text-center">

         
     <h5><?php echo __("Screenshot Image","premiumpress"); ?> </h5>
    <div class="text-muted mt-3 mb-4 small">Must be a .png file. (1200px x 900px)</div>
 
  <input type="hidden" 
               id="up_thumb_url_aid" 
               name="admin_values[childtheme][thumb_url_aid]" 
               value="<?php  echo stripslashes(_ppt(array('childtheme', 'thumb_url_aid')));  ?>"  />                
            <input 
               name="admin_values[childtheme][thumb_url]" 
               type="hidden" 
               id="up_thumb_url" 
               value="<?php echo stripslashes(_ppt(array('childtheme','thumb_url')));  ?>" />
               
               
            <?php if(substr(_ppt(array('childtheme','thumb_url')),0,4) == "http"){ ?>
            <div class="pptselectbox bg-light p-2 position-relative text-center   border">
            
                <img src="<?php echo _ppt(array('childtheme','thumb_url')); ?>" style="max-width:100%; max-height:300px;" id="thumb_url_preview" />   
            </div>
            <div class="pptselectbtns mb-4 text-center mt-4">
               <a href="<?php  echo _ppt(array('childtheme','thumb_url'));  ?>" target="_blank" class="btn btn-secondary  rounded-0" style="font-size: 10px;"><?php echo __("View","premiumpress") ?></a>
               <a href="javascript:void(0);"id="editImg_thumb_url" class="btn btn-secondary  rounded-0" style="font-size: 10px;"><?php echo __("Edit","premiumpress") ?></a>
               <a href="javascript:void(0);" id="upload_thumb_url" class="btn btn-secondary  rounded-0" style="font-size: 10px;"><?php echo __("Change","premiumpress") ?></a>
               <a href="javascript:void(0);" onclick="jQuery('#up_thumb_url').val('');document.admin_save_form.submit();" class="btn btn-secondary  rounded-0" style="font-size: 10px;"><?php echo __("Delete","premiumpress") ?></a>
            </div>
            <?php }else{ ?>
            <div class="pptselectbox bg-light text-dark p-5 text-center position-relative border">
             
               <a href="javascript:void(0);" id="upload_thumb_url">
                  <div class="text-dark font-weight-bold btn btn-system btn-md"><?php echo __("select image","premiumpress") ?></div>
                  <div class="text-muted small mt-4">.jpeg/ .png</div>
               </a>
            </div>
            <?php } ?>
            
            
            <script >
               jQuery(document).ready(function () {
               
               	jQuery('#editImg_thumb_url').click(function() {           
               			   	 
               		tb_show('', 'media.php?attachment_id=<?php echo _ppt(array('childtheme', 'thumb_url_aid' ) ); ?>&action=edit&amp;TB_iframe=true');
               					 
               		return false;
               	});
               	
               	jQuery('#upload_thumb_url').click(function() {           
               	
               		ChangeAIDBlock('up_thumb_url_aid');
               		ChangeImgBlock('up_thumb_url');		
               		ChangeImgPreviewBlock('thumb_url_preview');
					jQuery('#textlogobox').val('');
               		
               		formfield = jQuery('#up_thumb_url').attr('name');
               	 
               		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
               			return false;
               	});
               					
               });	
            </script>         
    
    
   

</div>
<div class="col-md-6 text-center">



 <h5><?php echo __("Homepage Preview","premiumpress"); ?> </h5>
           
 <div class="text-muted mt-3 mb-4 small"> Recommended (650px x 800px)  </div>
   
  <input type="hidden" 
               id="up_thumb1_url_aid" 
               name="admin_values[childtheme][thumb1_url_aid]" 
               value="<?php echo _ppt(array('childtheme','thumb1_url_aid')); ?>"  />                
            <input 
               name="admin_values[childtheme][thumb1_url]" 
               type="hidden" 
               id="up_thumb1_url" 
               value="<?php  echo stripslashes(_ppt(array('childtheme','thumb1_url'))); ?>" />
               
               
            <?php if(_ppt(array('childtheme','thumb1_url')) != "" && substr(_ppt(array('childtheme','thumb1_url')),0,4) == "http"){ ?>
            <div class="pptselectbox bg-light p-2 position-relative text-center  border">
          
            
               <img src="<?php echo _ppt(array('childtheme','thumb1_url')); ?>" style="max-width:100%; max-height:300px;" id="thumb1_url_preview" />   
            </div>
            <div class="pptselectbtns mb-4 text-center mt-4">
               <a href="<?php echo _ppt(array('childtheme','thumb1_url'));  ?>" target="_blank" class="btn btn-secondary  rounded-0" style="font-size: 10px;"><?php echo __("View","premiumpress") ?></a>
               <a href="javascript:void(0);"id="editImg_thumb1_url" class="btn btn-secondary  rounded-0" style="font-size: 10px;"><?php echo __("Edit","premiumpress") ?></a>
               <a href="javascript:void(0);" id="upload_thumb1_url" class="btn btn-secondary  rounded-0" style="font-size: 10px;"><?php echo __("Change","premiumpress") ?></a>
               <a href="javascript:void(0);" onclick="jQuery('#up_thumb1_url').val('');document.admin_save_form.submit();" class="btn btn-secondary  rounded-0" style="font-size: 10px;"><?php echo __("Delete","premiumpress") ?></a>
            </div>
            <?php }else{ ?>
            <div class="pptselectbox position-relative bg-light p-5 text-center text-dark  ">
            
               <a href="javascript:void(0);" id="upload_thumb1_url">
                  <div class="text-dark font-weight-bold  btn btn-system btn-md"><?php echo __("select Image","premiumpress") ?></div>
                  <div class="text-muted small mt-4">.jpeg/ .png</div>
               </a>
            </div>
            <?php } ?>
            <script >
               jQuery(document).ready(function () {
               
               	jQuery('#editImg_thumb1_url').click(function() {           
               			   	 
               		tb_show('', 'media.php?attachment_id=<?php echo _ppt(array('childtheme','thumb1_url_aid')); ?>&action=edit&amp;TB_iframe=true');
               					 
               		return false;
               	});
               	
               	jQuery('#upload_thumb1_url').click(function() {           
               	
               		ChangeAIDBlock('up_thumb1_url_aid');
               		ChangeImgBlock('up_thumb1_url');		
               		ChangeImgPreviewBlock('thumb1_url_preview');
					
					jQuery('#textlogobox').val('');
               		
               		formfield = jQuery('#up_thumb1_url').attr('name');
               	 
               		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
               			return false;
               	});
               					
               });	
            </script>   





</div>
</div>



 <div class="p-4 bg-light text-center mt-4">
         <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress") ?></button>
    	</div>
        
<?php _ppt_template('framework/admin/_form-bottom' );  ?>

          
            
               <hr />
             
            <!------------ FIELD --------------> 
            <div style="text-align:center;"><button type="button" onclick="jQuery('#downloadchildtheme').submit();" class="btn btn-admin color2 btn-lg"><?php echo __("Download Child Theme","premiumpress"); ?></button></div>
          
            


	</div>
</div>



<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
