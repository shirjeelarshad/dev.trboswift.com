jQuery(document).ready(function(){ 
							
	//jQuery("a[href='admin.php?page=go_elementor_pro']").attr('href', 'https://www.premiumpress.com/elementorpro/');
	
	//jQuery('.go_pro').find('a').attr('href', 'https://www.premiumpress.com/elementorpro/');
	
	//jQuery('.elementor-button-go-pro').attr('href', 'https://www.premiumpress.com/elementorpro/');
	
	//jQuery("a[href='https://go.elementor.com/renew/']").attr('href', 'https://www.premiumpress.com/elementorpro/');
	
	
	jQuery(".wp-admin.post-type-listing_type #side-sortables").prepend("<a href='admin.php?page=listings&eid="+jQuery('#post_ID').val()+"' class='button button-primary button-large' style='width:100%; margin-bottom:20px; font-size:16px; text-align:center; font-weight:bold;'>Edit with AutoCoin</a>")
	
});