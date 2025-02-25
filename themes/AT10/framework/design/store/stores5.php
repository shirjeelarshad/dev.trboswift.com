<?php
 
add_filter( 'ppt_blocks_args', 	array('block_stores5',  'data') );
add_action( 'stores5',  		array('block_stores5', 'output' ) );
add_action( 'stores5-css',  	array('block_stores5', 'css' ) );
add_action( 'stores5-js',  	array('block_stores5', 'js' ) );

class block_stores5 {

	function __construct(){}		

	public static function data($a){   global $CORE;
  
		$a['stores5'] = array(
			"name" 		=> "Style 5",
			"image"		=> "stores5.jpg",
			"cat"		=> "store",
			"desc" 		=> "", 
			"order" 	=> 5, 
			
			"data" 	=> array( ),
			
			
			"defaults" => array(
					
					"section_padding" => "section-80",
					"section_bg"	=>	"bg-light",	
					
					// TEXT						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					"title_pos" 		=> "left",
					
					
					"title" 			=> "Featured Stores",					 
					"subtitle"			=>  "",					
					"desc" 				=> "Over 1,000 stores and coupons online right now - find the best deals and offers today!",
					 	
					"title_margin"		=> "mb-4",
					"subtitle_margin"	=> "",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "light",
					"subtitle_txtcolor" => "opacity-5",
					"desc_txtcolor" 	=> "opacity-5",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
					 
					
					// BUTTON					
					"btn_show" 			=> "yes",						
					"btn_style" 		=> "4",				
					"btn_size" 			=> "btn-md",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "",
					"btn_font" 			=> "",
					"btn_txt" 			=> __("All Stores","premiumpress"),
					"btn_link" 			=> _ppt(array('links','stores')),
					"btn_bg" 			=> "light",
					"btn_bg_txt" 		=> "text-light",					
					"btn_margin" 		=> "mt-2",
				 
					
					 
			), 
						
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("stores5", "store", $settings ) );
	 
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
	
	?>
<section id="stores5-carousel-<?php echo $randomID; ?>" class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
  <div class="container">
    <div class="white-block featured-stores text-light bg-primary border">
      <div class="row">
        <div class="col-sm-4">
          <div class="featured-stores-title">
             <?php  _ppt_template( 'framework/design/parts/title' ); ?>
        <?php  _ppt_template( 'framework/design/parts/btn' ); ?>
            
            </div>
        </div>
        <div class="col-sm-8 bg-white pr-0">
        <ul class="list-unstyled list-inline">
          <?php
		
		$termdata = get_terms('store', 'orderby=term_order&hide_empty=0');
		$start		= 1;
		$per_page 	= 10;
		$total_merchants = count($termdata);		  
         
		$i=1; $sf = 0;
        foreach ($termdata as $term) { 
		
		if($i > 10){ continue;}
	 
		 // LINK 
         $link = get_term_link($term);		 
		 
		 // IMAGE
		 $img = do_shortcode('[STOREIMAGE id="'.$term->term_id.'"]');
		
		?>
          <li>
            <div class="store-logo y-middle"> <a href="<?php echo $link; ?>"> <img src="<?php echo $img; ?>" class="img-fluid" alt="<?php echo $term->name; ?>"> </a> </div>
          </li>
          <?php $i++; } ?>
          
        </ul>
      </div>
    </div>
  </div>
  </div>
</section>
<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		ob_start();
		?>
<style>
 .featured-stores-title {
    padding: 65px 40px 64px;
    margin-right: -15px;
    
}
.featured-stores ul {
    margin: 2px -13px;
}
.featured-stores ul li {
	width: 33%;
    margin: -3px;
	    border-bottom: 1px solid #ddd;
    border-right: 1px solid #ddd;
    display: inline-block;

    text-align: center;
}
.featured-stores ul li img { 
padding:10px;
 max-height: 142px;
}
.featured-stores ul li .store-logo {
    position: relative;
   
	min-height:130px;
}

</style>
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
