<?php
 
add_filter( 'ppt_blocks_args',  	array('block_listings10',  'data') );
add_action( 'listings10',  	array('block_listings10', 'output' ) );
add_action( 'listings10-css',  array('block_listings10', 'css' ) );
add_action( 'listings10-js',  	array('block_listings10', 'js' ) );

class block_listings10 {

	function __construct(){}		

	public static function data($a){ global $CORE;  
	
		global $CORE;
  
		$a['listings10'] = array(
			"name" 	=> "Style 10 - Search Results + Sidebar",
			"image"	=> "listings10.jpg",
			"cat"	=> "listings",
			"desc" 	=> "",
			"order" => 9, 
			"data" 	=> array( ),
			
			// HIDE VALUES
			"hide-title" 	=> true,
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
	
	
        $settings = array( );
		  
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("listings10", "listings", $settings ) );
 	  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }  
		 
		 if($settings['card'] == "list"){		 
		 	$thisdesign = 6; 
		  
		 }elseif($settings['card'] == "info"){
		  $thisdesign = 5; 		 
		 
		 }elseif($settings['card'] == "list-small"){
		  $thisdesign = 4;  
		  
		 }elseif($settings['card'] == "list-xsmall"){
		  $thisdesign = 4;  
		  
		  
		 }else{ 
		 	 $thisdesign = 5; 
		 }
		 
		 
 		
		ob_start();
		
		?>
<section class="section-0 <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_divider']; ?>">
  <div class="container py-4 <?php if(in_array(_ppt(array('design','boxed_layout')), array('1','1a','1b','1c')) ){ echo "px-0"; } ?>">
    <div class="row">
      <div class="col-md-4 col-lg-3 pr-md-4 collapsed" id="filters-extra">
        <?php _ppt_template( 'search', 'sidebar' ); ?>
      </div>
      <div class="col">
        <div class="row px-0">
          <?php if($CORE->ADVERTISING("check_exists", "search_side") ){  ?>
          <div class="col-12  col-xl-10">
            <?php _ppt_template( 'search', 'bar' ); ?>
          </div>
          <div class="d-none d-lg-block col-xl-2 bg-light">
            <?php if($CORE->ADVERTISING("check_exists", "search_side") ){ ?>
            <?php echo $CORE->ADVERTISING("get_banner", "search_side" );  ?>
            <?php } ?>
          </div>
          <?php }else{ ?>
          <div class="col-12">
            <?php _ppt_template( 'search', 'bar' ); ?>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>
<input type="hidden" name="cardlayout" class="customfilter" id="filter-cardlayout"  data-type="select" data-key="cardlayout" value="<?php echo $CORE->LAYOUT("default_search_type", $thisdesign); ?>" />
<input type="hidden" name="perpage"  class="customfilter" data-type="select" data-key="perpage" value="<?php if($settings['limit'] == ""){ echo get_option('posts_per_page'); }else{ echo $settings['limit']; } ?>" >
<textarea style="width:100%; height:100px; display:none" id="_filter_data"></textarea>
<?php $output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
	public static function js(){ global $CORE;
	
		ob_start();
		?>
<script>
 
var ajax_site_url = "<?php echo home_url(); ?>/"; 
var ajax_framework_url = "<?php echo get_template_directory_uri(); ?>/"; 
var ajax_googlemaps_key = "<?php echo trim( _ppt(array('maps','apikey')) ); ?>"; 

jQuery(document).ready(function(){ 
    
  _filter_update();
   
   // SHOW FIRST 5 FILTERS
   var i = 0;
   jQuery('.filters_sidebar .filter-content').each(function () {
		if(i < 5){
		jQuery(this).addClass('show');
		i ++;
		}
		
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
