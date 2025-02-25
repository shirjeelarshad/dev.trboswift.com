<?php
 
add_filter( 'ppt_blocks_args',  	array('block_search1',  'data') );
add_action( 'search1',  	array('block_search1', 'output' ) );
add_action( 'search1-css',  array('block_search1', 'css' ) );
add_action( 'search1-js',  	array('block_search1', 'js' ) );

class block_search1 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['search1'] = array(
			"name" 	=> "Search Inline",
			"image"	=> "search1.jpg",
			"cat"	=> "search",
			"desc" 	=> "", 
			"data" 	=> array( ),
			
			// HIDE VALUES
			"hide-title" 	=> true,
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
	
	
        $settings = array( );
		  
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("search1", "search", $settings ) );
 	  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }		
		ob_start();
		
		?><section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
   <div class="container" style="padding:0 15px!important;">    
		<?php _ppt_template( 'framework/design/parts/search-inline' ); ?>
   </div>
</section><?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
	public static function js(){ global $CORE;
	 
		ob_start();
		?><script>
		
jQuery(document).ready(function(){ 
 
	 jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {  
	 jQuery('.hero-search1 a').removeClass('bg-secondary');  
	 jQuery(this).addClass('bg-secondary');
	  
	}); 
	
 
});
</script><?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		 
	
	}		
	public static function css(){ global $CORE;
		ob_start();
		?>
 
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>