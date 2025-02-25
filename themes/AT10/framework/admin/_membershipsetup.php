<?php
/* =============================================================================
   USER ACTIONS
   ========================================================================== */
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

// SETUP GLOBALS
global $wpdb, $CORE, $CORE_ADMIN;
 
// LOAD IN MAIN DEFAULTS
if(function_exists('current_user_can') && current_user_can('administrator')){
   
 


}  
 

_ppt_template('framework/admin/header' ); 

_ppt_template('framework/admin/_form-top' ); ?>

 
<div class="tab-content">
        
        
  <div class="tab-pane  active" 
        data-title="<?php echo __("Memberships","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can configure membership options.","premiumpress"); ?>"
        data-icon="fa-users-class" 
        id="mem-settings" 
        role="tabpanel" aria-labelledby="mem-settings-tab">
		 <?php _ppt_template('framework/admin/parts/membership-settings' ); ?>
        </div>     
        
        <?php /*
        
          <div class="tab-pane addjumplink" 
        data-title="<?php echo __("Packages","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can manage your packages","premiumpress"); ?>"
        data-icon="fa-users-class" 
        id="mem-packages" 
        role="tabpanel" aria-labelledby="mem-packages-tab">
		 <?php _ppt_template('framework/admin/parts/membership-packages' ); ?>
        </div>     
        
		*/ ?>
 

</div>

<?php _ppt_template('framework/admin/_form-bottom' ); ?>
<?php  _ppt_template('framework/admin/footer' );  ?>
 
  