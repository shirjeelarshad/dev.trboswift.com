<?php
/* 
* Theme: TURBOBID CORE FRAMEWORK FILE
* Url: www.turbobid.ca
* Author: Md Nuralam
*
* THIS FILE WILL BE UPDATED WITH EVERY UPDATE
* IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
*
* http://codex.wordpress.org/Child_Themes
*/
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

global $CORE, $post, $userdata;

 

?>
 
          <div class="stepbox row">
            <div class="col-4 stepbox-step step1 active">
              <div class="text-center stepbox-stepnum"><?php echo __("Submit Request","premiumpress"); ?></div>
              <div class="progress bg-success">
                <div class="progress-bar"></div>
              </div>
              <a href="javascript:void(0);" onclick="ChangeSteps(1);" class="stepbox-dot bg-dark"></a> </div>
            <div class="col-4 stepbox-step step2">
              <div class="text-center stepbox-stepnum"><?php echo __("Wait for Approval","premiumpress"); ?></div>
              <div class="progress">
                <div class="progress-bar"></div>
              </div>
              <a href="javascript:void(0);" class="stepbox-dot bg-dark"></a> </div>
            <div class="col-4 stepbox-step step3">
              <div class="text-center stepbox-stepnum"> <?php echo __("Join Course","premiumpress"); ?> </div>
              <div class="progress">
                <div class="progress-bar"></div>
              </div>
              <a href="javascript:void(0);" class="stepbox-dot bg-dark"></a> </div>
          </div>
          <div id="waitresponcebox" style="display:none;">
            <h2 class="mb-3 mt-4 text-center"><?php echo __("Wait for a response","premiumpress"); ?></h2>
            <p class="mb-4 text-center"><?php echo __("Your application has been submitted.","premiumpress"); ?></p>
            <div class="p-4 bg-light border col-12 m-auto">
              <h6 class="mb-2"><?php echo __("What happens next?","premiumpress"); ?></h6>
              <hr />
              <p><?php echo __("An email has been sent to the teacher to notify them of your new request. Once your application has been reviewed you'll get a notification in your members area.","premiumpress"); ?></p>
               
            </div>
            <div class="text-center my-4"> <a href="<?php echo get_permalink($post->ID); ?>" class="btn btn-primary rounded-0 mr-3"><?php echo __("Back to course page","premiumpress"); ?></a> <a href="<?php echo _ppt(array('links','myaccount')); ?>?showtab=offers" class="btn btn-primary rounded-0"><?php echo __("View my applications","premiumpress"); ?></a> </div>
          </div>
          <div id="makeofferbox" >
            <div class="col-md-12 m-auto ">
              <div class="row">
                <div class="col-md-12">
                  <div class="p-4 bg-light border col-12">
                    <h5 class="mb-2"><?php echo __("How does it work?","premiumpress"); ?></h5>
                    <hr />
                    <p style="line-height:30px;"> 
					
					<?php echo __("Congratulations on taking the next step to learning a new skill.","premiumpress"); ?>
                    
                    </p>
                    
                    <p>
                    
                   <?php echo __("Please click continue below to confirm you wish to enroll on this course. Your application will be sent to the instructor for approval. Once approved you will be provided with the course material.","premiumpress"); ?>
                     
                     </p>
					
					
					 
 
<script>
                              function ValidateThis(){
							  
							  
							  <?php if($post->post_author == $userdata->ID){ ?>
							   
									alert("<?php echo __("You cannot signup for your own courses.","premiumpress"); ?>");
                              		return false;
							 
							  <?php } ?>
                              
								ajax_single_offer_make();
								return false;
                              	 
                              }
							  
							  
							  
function ajax_single_offer_make(){ 
 
	jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            single_action: "single_offer_make",
			pid: <?php echo $post->ID; ?>,
			aid: <?php echo $post->post_author; ?>,
			price: jQuery('#offer_price_amount').val(),
			 
        },
        success: function(response) {
 
			if(response.status == "ok"){
			 	 
				// UPDATED DISPLAY			
				jQuery('#makeofferbox').hide();	
				jQuery('#waitresponcebox').show();	
				
			 
				jQuery('.step2').addClass('active');
				jQuery('.step2 .progress').addClass('bg-success');
				 
				 
  		 	
			}else{			
				console.log("Error trying to add.");			
			}			
        },
        error: function(e) {
            alert("error "+e)
        }
    });
	
}// end are you sure
							  
							  
</script>
                    <form method="post" action="<?php echo _ppt(array('links','offerpage')); ?>" onsubmit="return ValidateThis();">
                      <div class="bg-white p-3 py-4 text-center">
                        <input type="hidden" name="ct_action" value="newoffer">
                        <input type="hidden" name="ct_pid" value="<?php echo $post->ID; ?>">
                        <input type="hidden" name="ct_aid" value="">
                      
                       
      <?php if(!$userdata->ID){ ?>
      <a href="javascript:void(0);" onclick="processLogin(1);" class="btn btn-primary font-weight-bold text-uppercase rounded-0 btn-lg">  <?php echo __("Continue","premiumpress") ?></a> 
      <?php }else{ ?>
     <button class="btn btn-primary font-weight-bold text-uppercase rounded-0 btn-lg" style="cursor:pointer"><?php echo __("Continue","premiumpress"); ?> </button>
      <?php } ?>
                        
                      
                      
                      
                      </div>
                      <div class="clearfix">
                        <p class="mt-4 ml-2 small float-left"><?php echo __("By clicking continue you agree to our website","premiumpress"); ?> <a href="<?php echo _ppt(array('links','terms')); ?>" style="text-decoration:underline;"><?php echo __("terms and conditions","premiumpress"); ?>.</a></p>
                        
                        </div>
                    </form>
                  </div>
                </div>
      
              </div>
            </div>
            <!-- end make offer box -->
          </div>
        
 