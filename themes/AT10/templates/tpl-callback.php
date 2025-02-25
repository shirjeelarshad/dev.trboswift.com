<?php
/*
Template Name: [PAGE - PAYMENT CALLBACK]
*/


// DISABLE SIDEBAR
$GLOBALS['flag-nosidebar'] = 1;

get_header(); _ppt_template( 'page', 'top' ); ?>

<?php 
	
	switch($payment_status){ 
	
		case "success": { 
		
			_ppt_template( 'payment', 'thankyou' );
		
		} break;
		
		default: {
		
		 _ppt_template( 'payment', 'error' );
		 
		} 
	
	}
?>    
		
<?php _ppt_template( 'page', 'bottom' ); get_footer(); ?>