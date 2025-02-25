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



// COUPON CODE SETTINGS
if(isset($_POST['neworder']) && is_numeric($_POST['neworder'])){
 
		// ADD SYSTEM TRANSACTION				
		$my_post = array();				
		$my_post['post_title'] 		= "Cashout #".$_POST['neworder']; 
		$my_post['post_type'] 		= "ppt_cashout"; 
		$my_post['post_status'] 	= "publish";
		$my_post['post_content'] 	= ""; 
		
		// UPDATE
		if($_POST['neworder'] == 1){
		
			$payment_id = wp_insert_post( $my_post );
		
			// ADD LOG ENTRY
   			//$CORE->ADDLOG('(cron) Micro Job Finished.',  $job_seller_id, $p->ID,"",'listing', $p->ID);
		
		}else{
		
			$my_post['ID'] 	= $_POST['neworder'];
			$payment_id = $_POST['neworder'];
			wp_update_post( $my_post );
			
			
			// CHECK IF OLD TYPE WAS 
			// REMOVE AMOUNT FROM USER ACCOUNT
			$ct = get_post_meta($payment_id, "cashout_status", true);
			if($ct == 0 && $_POST['order']['cashout_status'] == 1){
			
				$c = get_user_meta($_POST['order']['cashout_userid'],'ppt_usercredit', true);
				$c1  = $c - $_POST['order']['cashout_total'];
				update_user_meta($_POST['order']['cashout_userid'],'ppt_usercredit', $c1);
			
			}
			 
		
		} 

		// CUSTOM FIELDS
		if(isset($_POST['order']) && is_array($_POST['order']) && !empty($_POST['order']) ){
			foreach($_POST['order'] as $kk => $vv){
				 update_post_meta($payment_id, $kk, $vv);
			}
		} 				


}

}
 

_ppt_template('framework/admin/header' ); 


?>
<div class="tab-content">
       
        <div class="tab-pane active addjumplink" 
        data-title="All Requests" 
        data-icon="fa-receipt" 
        id="orders" 
        role="tabpanel" aria-labelledby="orders-tab">
        
        
         <?php _ppt_template('framework/admin/parts/cashout-table' ); ?>
    
         </div>        
        
        
        <div class="tab-pane addjumplink" 
        data-title="Add New" 
        data-icon="fa-plus" 
        id="add" 
        role="tabpanel" aria-labelledby="add-tab">            

		<?php _ppt_template('framework/admin/parts/cashout-add' ); ?>
        
        
        </div>
        
         
     
        
     

</div>
 
   
<?php  _ppt_template('framework/admin/footer' );  ?>