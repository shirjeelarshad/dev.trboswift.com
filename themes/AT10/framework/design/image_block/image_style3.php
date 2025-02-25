<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_style3',  'data') );
add_action( 'image_style3',  		array('block_image_style3', 'output' ) );
add_action( 'image_style3-css',  	array('block_image_style3', 'css' ) );

class block_image_style3 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_style3'] = array(
			"name" 	=> "Style 3",
			"image"	=> "image_style3.jpg",
			"cat"	=> "image_block",
			"desc" 	=> "", 
			"data" 	=> array( ),
			"order" => 23,
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
	
	  
		 // SETTINGS LOADED VIA MAIN LAYOUT
       	 $settings = array( );
		 
		 // ADD ON SYSTEM DEFAULTS
		 $settings = $CORE->LAYOUT("get_block_settings_defaults", array("image_style3", "image_block", $settings ) );
  		
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		  
		 // DEFAULTS
		 $sd = array( '', array(500,625), array(710,300), array(710,300) );
		 $i=1; while($i < 4){ 		 	
			if($settings['image_block'.$i] == ""){
				$settings['image_block'.$i] = $CORE->LAYOUT("get_placeholder", $sd[$i] );
			}
			$i++;
		 }		  
	 
		 global $imagedata;		  
	 
 
		ob_start();
		?> 
<section class="grid <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">

 
        <div class="container">
        
        
<?php if($settings['title_show'] == "yes"){ ?>
<div class="row">
<div class="col-md-12">
<?php  _ppt_template( 'framework/design/parts/title' ); ?>
<?php  _ppt_template( 'framework/design/parts/btn' ); ?>
</div>
</div>
<?php } ?>
        
        
        
        
        
            <div class="row">
            
                 <div class="col-lg-5">
                 
<?php _ppt_template( 'framework/design/image_block/parts/i1' );  ?>  

                    
                    
                </div>
            
                <div class="col-lg-7">
                
                 
                    <div class="row">
                    
                        <div class="col-lg-12  mb-4">
                           
<?php _ppt_template( 'framework/design/image_block/parts/i2' );  ?>  

                        </div>
                        
                        <div class="col-lg-12">
<?php _ppt_template( 'framework/design/image_block/parts/i3' );  ?>  

                        </div>
                    </div>
                    
                    
                        
                    
                    
                </div>
                
           
                
            </div>
   
   </div>

</section><?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
	
	public static function css(){ global $CORE;
	return "";
		ob_start();
		?><?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>