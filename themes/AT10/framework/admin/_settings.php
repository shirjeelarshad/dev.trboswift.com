<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN;
 
if( current_user_can('administrator') ){
  

	// SAVE REG FIELDS
	if(isset($_POST) && !empty($_POST) && isset($_POST['regfields']) ){
	
		update_option("regfields", $_POST['regfields']);	
	}
	 
	if(isset($_POST['cfield'])){
	
	
	  update_option("cfields", $_POST['cfield']);
	 
	}
	 

}
 

_ppt_template('framework/admin/header' ); 

_ppt_template('framework/admin/_form-top' ); ?>


 <?php _ppt_template('framework/admin/parts/settings-list' ); ?>  
 
<?php _ppt_template('framework/admin/_form-bottom' ); ?>
 


<!-- AFTER FORM DATA -->

<div style="display:none"><div id="regfield-list-new">

    <li class="cfielditem"> 
    
    <div class="heading">
    <div class="name"><?php echo __("New Field","premiumpress"); ?></div>
    </div>
    <div class="inside">    
       
        <label><?php echo __("Title","premiumpress"); ?></label>
        <input type="text" name="regfields[name][]" value="" id="nfaqt1" class="form-control" />  
        <input type="hidden" name="regfields[values][]" value="" />  
        <input type="hidden" name="regfields[required][]" value="" />  
        <input type="hidden" name="regfields[tax_name][]" value="" />  
        <input type="hidden" name="regfields[posttype_name][]" value="" />  
        <div class="row mt-3">
        
        	<div class="col-md-6">
            
            <label><?php echo __("Field Type","premiumpress"); ?></label>
            
              <select name="regfields[type][]" class="form-control">
                  
                    <option value="input"><?php echo __("Input Field","premiumpress"); ?></option>
                    <option value="textarea"><?php echo __("Text Area","premiumpress"); ?></option>
                    <option value="checkbox"><?php echo __("Checkbox","premiumpress"); ?></option>
                    <option value="radio"><?php echo __("Radio Button","premiumpress"); ?></option> 
                    <option value="select"><?php echo __("Selection Box","premiumpress"); ?></option>                                          
                    <option value="tax"><?php echo __("Taxonomy","premiumpress"); ?></option>  
              </select>
     
            
            </div>
        
        	<div class="col-md-6">
            
             <label><?php echo __("Unique Key","premiumpress"); ?></label>
             
              <input type="text" name="regfields[key][]" value="field<?php echo rand(0,1000); ?>" class="form-control"  />        
             
            </div>   
                 
        </div> 
 
    
    <hr />
    <button class="btn btn-primary" type="submit" onclick="checknotblank()"><?php echo __("Save","premiumpress"); ?></button>
    
    </div>
    
    </li>  
      
</div></div>


 

  

 


		<div id="UpdateModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document"><div class="modal-content">
					  <div class="modal-header">                
						<h6><?php echo __("Website Reset","premiumpress"); ?></h6>
					  </div>
					  <div class="modal-body">                      
					    
                        <p style="font-weight:bold;"><?php echo __("Would you like to reset your website to the default factory settings?","premiumpress"); ?></p>
                        
                        <p style="font-size:11px;"><?php echo __("Warning - resetting your website will delete all of your existing listing and admin changes.","premiumpress"); ?></p>
                         					             
					  </div>
                      <?php if(function_exists('current_user_can') && current_user_can('administrator')){ ?>
                      <form method="post" action="">
                      <input type="hidden" name="submitted" value="yes" />
                      <input type="hidden" name="core_system_reset" id="core_system_reset" value="new" />
					  <div class="modal-footer">
						<a class="btn" data-dismiss="modal" aria-hidden="true">No Thanks!</a>                       
						<button type="submit" class="btn btn-primary">Yes, Reset Now</button>
                       
					  </div>
                      </form>
                      <?php }else{ ?>
                      <div class="font-weight-bold p-3 bg-light">Disabled in demo mode</div>
                      <?php } ?>
</div></div></div>










<div id="ajax_payment_test"></div>
<?php
_ppt_template('framework/admin/footer' ); 
?>