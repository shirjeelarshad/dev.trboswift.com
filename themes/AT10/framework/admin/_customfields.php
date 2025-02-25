<?php
/* =============================================================================
   USER ACTIONS
   ========================================================================== */
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

// SETUP GLOBALS
global $wpdb, $CORE, $CORE_ADMIN;

 

_ppt_template('framework/admin/header' ); 

_ppt_template('framework/admin/_form-top' ); ?>

 
<div class="tab-content">
        
        
        <div class="tab-pane active " 
        data-title="Custom Fields" 
        data-icon="fa-cube" 
        id="customfields" 
        role="tabpanel" aria-labelledby="overview-tab">
        
        
         <?php  _ppt_template('framework/admin/parts/listings-fields' ); ?> 
    
         </div>        
        
 

</div>

<?php _ppt_template('framework/admin/_form-bottom' ); ?>
<?php  _ppt_template('framework/admin/footer' );  ?>
 


