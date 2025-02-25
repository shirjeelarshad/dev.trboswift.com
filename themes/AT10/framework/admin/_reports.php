<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN;
// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values"); 


// LOAD IN MAIN DEFAULTS
if(function_exists('current_user_can') && current_user_can('administrator')){



	// COUPON CODE SETTINGS
	if(isset($_POST['newlog']) && is_numeric($_POST['newlog'])){
	 
			// ADD SYSTEM TRANSACTION				
			$my_post = array();				
			$my_post['post_title'] 		= "log #"; 
			$my_post['post_type'] 		= "ppt_logs"; 
			$my_post['post_status'] 	= "publish";
			$my_post['post_content'] 	= $_POST['details']; 
			 
			// UPDATE
			if($_POST['newlog'] == 1){
			
				$payment_id = wp_insert_post( $my_post );
			 
			}else{
			
				$my_post['ID'] 	= $_POST['newlog'];
				$payment_id = $_POST['newlog'];
				wp_update_post( $my_post );
			 
			} 
	
			// CUSTOM FIELDS
			if(isset($_POST['log']) && is_array($_POST['log']) && !empty($_POST['log']) ){
				foreach($_POST['log'] as $kk => $vv){
					 update_post_meta($payment_id, $kk, $vv);
				}
			} 
			 
	
	}

} 
 
 
if(function_exists('current_user_can') && current_user_can('administrator')){
	// DELETE THE RECENT SEARCHES
	if(isset($_GET['delrs']) && isset($_GET['key']) ){
		$saved_searches_array = get_option('recent_searches');
		unset($saved_searches_array[str_replace(" ","_",$_GET['key'])]);
		update_option('recent_searches',$saved_searches_array);
	}elseif(isset($_GET['delrsall'])){
		update_option('recent_searches','');
	}
	
	if(isset($_GET['forcecron']) && $_GET['forcecron'] == 1){
	
	premiumpress_hourly_event_hook_do();
	
	}
}// end if
 
// LOAD IN HEADER

 
_ppt_template('framework/admin/header' ); 

?>
 

<div class="tab-content">


        <div class="tab-pane active addjumplink" 
        data-title="Acitivity Log" 
        data-icon="fa-signal-alt-3" 
        id="listings" 
        role="tabpanel" aria-labelledby="listings-tab">        
        
 	<?php _ppt_template('framework/admin/parts/reports-table' ); ?> 
    
    </div>
    
            
        <div class="tab-pane addjumplink" 
        data-title="Add Report" 
        data-icon="fa-plus" 
        id="add" 
        role="tabpanel" aria-labelledby="add-tab">            

		<?php _ppt_template('framework/admin/parts/report-add' ); ?>
        
        
        </div>
             
</div><!-- end tabs -->


<?php // LOAD IN FOOTER

_ppt_template('framework/admin/footer' ); 

 ?>