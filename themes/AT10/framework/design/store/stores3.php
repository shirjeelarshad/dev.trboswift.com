<?php
 
add_filter( 'ppt_blocks_args', 	array('block_stores3',  'data') );
add_action( 'stores3',  		array('block_stores3', 'output' ) );
add_action( 'stores3-css',  	array('block_stores3', 'css' ) );
add_action( 'stores3-js',  	array('block_stores3', 'js' ) );

class block_stores3 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['stores3'] = array(
			"name" 		=> "Style 3 - Top 10 Stores",
			"image"		=> "stores3.jpg",
			"cat"		=> "store",
			"desc" 		=> "", 
			"order" 	=> 3, 
			
			"data" 	=> array( ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("stores3", "store", $settings ) );
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
	 
 $settings['card'] 			= "store";
 $settings['custom'] 		= "stores";
 $settings['datastring'] 	= "";
$settings['perrow'] 	= "5"; 
$randomID = rand();



	ob_start();
	
	?><section id="stores3-carousel-<?php echo $randomID; ?>" class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
  <div class="container">
    <div class="row">
       
        <?php
		
		$termdata = get_terms('store', 'orderby=term_order&hide_empty=0');
		$start		= 1;
		$total_merchants = count($termdata);		  
         
		$i=1; $sf = 0;
        foreach ($termdata as $term) { 
	 
		 // LINK 
         $link = get_term_link($term);		 
		 
		 // IMAGE
		 $img = do_shortcode('[STOREIMAGE id="'.$term->term_id.'"]');
		 
		 if($i > 10){ continue; }
		
		?>
        <div class="col-6">
        <div class="card-search card-zoom card-top-image border-0 card-coupon">
		  <?php /************ MIAN IMAGE ***/ ?>
          <figure> <a href="<?php echo $link; ?>">
          
          <img src="<?php echo $img; ?>" class="img-fluid" alt="<?php echo $term->name; ?>">
            <div class="read_more"><span><?php echo __("view","premiumpress"); ?></span></div>
            </a> </figure>
          <?php /***************** */ ?>
          <div class="card-body  p-0 py-3 text-center">
           <?php 
		   
		   
		   	if( defined('WLT_DEMOMODE') ){
		 
				$did = filter_var($term->name, FILTER_SANITIZE_NUMBER_INT);	
			 				
				if(is_numeric($did) && isset($GLOBALS['CORE_THEME']['storedata'][$did]['title'])){
							
					echo $GLOBALS['CORE_THEME']['storedata'][$did]['title'];
								
				}else{
				
					echo $CORE->GEO("translation_tax", array($term->term_id, $term->name)); 
				}
		
	 
		}else{
		
				echo $CORE->GEO("translation_tax", array($term->term_id, $term->name)); 
		
		}
		   
		 ?>
         </div>
          </div>
        </div>
        <?php $i++; } ?> 
                
     
    </div>
  </div>
</section><?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		return "";
		ob_start();
		?>
 
        <?php	
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
		public static function js(){
		return "";
		ob_start();
		?>
 
        <?php	
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
}

?>