<?php

// V10.4

	// REGISTER PAGE
	function hook_register_top(){  do_action('hook_register_top');  }  

///////////////////////////////////////


	// EXPIRY FUNCTIONS
	function hook_expire_listing_action($c){ return  apply_filters('hook_expire_listing_action', $c);  } // $postid
	
	
	// RELIST FUNCTIONS
	function hook_relist_listing_action($c){ return  apply_filters('hook_relist_listing_action', $c);  } // $postid
	
	// AUTHOR TOOLBOX
	function hook_can_delete_listing($c){ return  apply_filters('hook_can_delete_listing', $c);  } // $postid (return "stop")
	
	// AUTHOR TOOLBOX
	function hook_orderid($c){ return  apply_filters('hook_orderid', $c);  } // $postid (return "stop")
 
	
	// CURRENY CODES
	function hook_currency_code($c){ return  apply_filters('hook_currency_code', $c);  }  // takes no input
	function hook_currency_symbol($c){ return  apply_filters('hook_currency_symbol', $c);  } // takes no input
	
	// CHANGING THEME FOLDERS
	function hook_theme_folder($c){ return  apply_filters('hook_theme_folder', $c);  } // takes no input
	
	// HOOK LINKS
	function hook_affiliate_link($c){ return  apply_filters('hook_affiliate_link', $c);  } // takes no input
	
	// HOOK LINKS
	function hook_comments_before(){ return  do_action('hook_comments_before');  } // takes no input
	
	// HOOK NO RESULTS
	function hook_noresults(){ return  do_action(' hook_noresults');  } // takes no input
	
	// HOOK FOR NEW SEARCH ARGS
	function hook_search_args($c){ return  apply_filters('hook_search_args', $c);  } // takes no input
	function hook_search_addons($c){ return  apply_filters('hook_search_addons', $c);  } // takes no input
 	
 
	// ACCOUNT PAGE
	function hook_account_userfields_after(){ return  do_action('hook_account_userfields_after');  } // takes no input

	// BLOCKS FILTERS
	//function ppt_block_args($c){ return  apply_filters('ppt_block_args', $c); }

	// SEARCH FILTERS
	//function ppt_query_args($c){ return  apply_filters('ppt_query_args', $c); }

 
	// ORDERS HOOKS FOR CHILD THEMES
	function hook_v9_order_process($c){ return  apply_filters('hook_v9_order_process', $c); }
 	
	// PRIMARY AND SECONDARY COLORS
	function hook_color_primary_css($c){ return  apply_filters('hook_color_primary_css', $c);  }
	function hook_color_secondary_css($c){ return  apply_filters('hook_color_secondary_css', $c);  }
	function hook_color_bglight_css($c){ return  apply_filters('hook_color_bglight_css', $c);  }
	function hook_color_bgdark_css($c){ return  apply_filters('hook_color_bgdark_css', $c);  }
	
	
	// ADD LISTING
	function hook_add_fieldlist($c){ return apply_filters('hook_add_fieldlist', $c );   }
 	function hook_add_build_field($string){ return apply_filters('hook_add_build_field', $string );   }
	function hook_custom_fields_filter($c){ return apply_filters('hook_custom_fields_filter', $c );   }
	function hook_add_post_title_text($c){ return apply_filters('hook_add_post_title_text', $c );   }

	// IMAGE EDITING HOOKS
	function hook_upload_delete($post_id,$imagename,$user_id){return apply_filters('hook_upload_delete',array($post_id, $imagename,$user_id));}
	function hook_upload_edit($post_id){   return  apply_filters('hook_upload_edit', $post_id);   }
	function hook_upload($postID, $file, $featured = false){  return  apply_filters('hook_upload',array($postID, $file, $featured) );   } 	
	function hook_upload_return($file){   return  apply_filters('hook_upload_return', $file);   }	
	function hook_image_display($c){   return  apply_filters('hook_image_display', $c);   }	 	
	function hook_fallback_image_display($c){   return  apply_filters('hook_fallback_image_display', $c);   }
	
	// SQL
	function hook_custom_queries($c){ return  apply_filters('hook_custom_queries', $c);  }

	// ACCOUNT PAGE
	function hook_v9_account_options($c){ return  apply_filters('hook_v9_account_options', $c); } // use din my account
	function hook_v9_admin_options($c){ return  apply_filters('hook_v9_admin_options', $c); } // used in 2 overview

	// MISC
	function hook_price($c){ return  apply_filters('hook_price', $c);  }
	function hook_price_save($c){ return  apply_filters('hook_price_save', $c);  }
	function hook_price_filter($c){ return  apply_filters('hook_price_filter', $c);  }
	function hook_price_currencycode($c){ return  apply_filters('hook_price_currencycode', $c);  }
	
	// DATE AND TIME
	function hook_date($c){ return  apply_filters('hook_date', $c);  }
	function hook_date_only($c){ return  apply_filters('hook_date_only', $c);  }
  
	// CART
	function hook_cart_data($c){   return  apply_filters('hook_cart_data', $c);   }
	function hook_addcart_small($c){   return  apply_filters('hook_addcart_small', $c);   }
	function hook_addcart_big($c){   return  apply_filters('hook_addcart_big', $c);   }
	
	function hook_checkout_paymentoptions($c){   return  apply_filters('hook_checkout_paymentoptions', $c);   }
	function hook_checkout_before_paymentoptions(){ do_action('hook_checkout_before_paymentoptions'); }
	function hook_checkout_after_paymentoptions(){ do_action('hook_checkout_after_paymentoptions'); }
	
	// CALLBACK PAGE
	function hook_payments_gateways($gateways){ return  apply_filters('hook_payments_gateways', $gateways);  }		 
	function hook_callback($c){ return  apply_filters('hook_callback',$c);  }	 
	function hook_callback_success(){  do_action('hook_callback_success');  }  
	function hook_callback_error(){  do_action('hook_callback_error');  }  
	function hook_callback_process_orderid($c){ return  apply_filters('hook_callback_process_orderid', $c); }
	function hook_callback_process_orderid_after($c){ return  apply_filters('hook_callback_process_orderid_after', $c); }
	
	
	// ADMIN AREA
	function hook_v9_adminoptions_1($c){ return  apply_filters('hook_v9_adminoptions_1', $c); }
	function hook_v9_admincode_1(){ return  do_action('hook_v9_admincode_1'); }
	function hook_admin_2_homeedit($c){   return  apply_filters('hook_admin_2_homeedit', $c);   }
	function hook_admin_1_tab1_subtab2_pagelist($c){  return  apply_filters('hook_admin_1_tab1_subtab2_pagelist', $c);  }
	
	// ELEMENTOR
	function hook_v9_admin_elementor_templates($c){ return  apply_filters('hook_v9_admin_elementor_templates', $c); } // used in 3 overview
 

/*
NEW ADMIN AREA HOOKS FOR VERSION 8.4+
*/
function hook_admin_1_pagesetup(){  do_action('hook_admin_1_pagesetup');  }

?>