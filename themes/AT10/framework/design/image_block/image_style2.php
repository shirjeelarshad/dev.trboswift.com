<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_style2',  'data') );
add_action( 'image_style2',  		array('block_image_style2', 'output' ) );
add_action( 'image_style2-css',  	array('block_image_style2', 'css' ) );

class block_image_style2 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_style2'] = array(
			"name" 	=> "Style 2",
			"image"	=> "image_style2.jpg",
			"cat"	=> "image_block",
			"desc" 	=> "", 
			"data" 	=> array(),
			"order" => 21,
			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
 		 
		 // SETTINGS LOADED VIA MAIN LAYOUT
       	 $settings = array( );
		 
		 // ADD ON SYSTEM DEFAULTS
		 $settings = $CORE->LAYOUT("get_block_settings_defaults", array("image_style2", "image_block", $settings ) );
  		
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		  
		 // DEFAULTS
		 $sd = array( '', array(400,525), array(400,250), array(400,250), array(820,250)  );
		 $i=1; while($i < 5){ 		 	
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
            
                 <div class="col-lg-4">
                 
<?php _ppt_template( 'framework/design/image_block/parts/i1' );  ?>               
                    
                </div>
            
                <div class="col-lg-8">
                
                
                
                    
                    
                    
                    
                    <div class="row mb-4">
                        <div class="col-lg-6">
                           
                 
<?php _ppt_template( 'framework/design/image_block/parts/i2' );  ?> 

                        </div>
                        <div class="col-lg-6">
                          
<?php _ppt_template( 'framework/design/image_block/parts/i3' );  ?> 

                        </div>
                    </div>
                    
                    
                        <div class="row">
                        <div class="col ">
                           
                 
<?php _ppt_template( 'framework/design/image_block/parts/i4' );  ?>  
</div>                        
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
	
	public static function css(){ global $CORE;
	
		ob_start();
		?>
        
        <style>
		 
		</style>
        
 
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>