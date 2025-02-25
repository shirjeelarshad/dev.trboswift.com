<?php
 
add_filter( 'ppt_blocks_args',  	array('block_search2',  'data') );
add_action( 'search2',  	array('block_search2', 'output' ) );
add_action( 'search2-css',  array('block_search2', 'css' ) );
add_action( 'search2-js',  	array('block_search2', 'js' ) );

class block_search2 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['search2'] = array(
			"name" 	=> "Search Basic",
			"image"	=> "search2.jpg",
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
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("search2", "search", $settings ) );
 	  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }  
		
		 
		
		ob_start();
		
		?>
<section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
  <div class="container">
    <form action="<?php echo home_url(); ?>" class="search">
      <div class="input-group">
        <input type="text" class="form-control rounded-0 typeahead" name="s" placeholder="<?php  echo __("Start your search here...","premiumpress"); ?>" autocomplete="off">
        <div class="input-group-append">
          <button class="btn btn-primary  rounded-0 text-uppercase px-3 border-0" type="submit"> <?php echo __("Search","premiumpress"); ?> </button>
        </div>
      </div>
    </form>
  </div>
</section>
<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
	public static function js(){ global $CORE;
	return "";
		ob_start();
		?>
<script>
		
jQuery(document).ready(function(){ 
 
	 jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {  
	 jQuery('.hero-search2 a').removeClass('bg-secondary');  
	 jQuery(this).addClass('bg-secondary');
	  
	}); 
	
 
});
</script>
<?php
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
