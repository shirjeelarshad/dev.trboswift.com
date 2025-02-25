<?php
 
add_filter( 'ppt_blocks_args', 	array('block_text15',  'data') );
add_action( 'text15',  		array('block_text15', 'output' ) );
add_action( 'text15-css',  	array('block_text15', 'css' ) );
add_action( 'text15-js',  	array('block_text15', 'js' ) );

class block_text15 {

	function __construct(){}		

	public static function data($a){  global $CORE;
  
		$a['text15'] = array( 
			"name" 	=> "Style 15",
			"image"	=> "text15.jpg",
			"order" => 15,
			"cat"	=> "text",
			"desc" 	=> "", 
			"data" 	=> array( ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings; 
	
		$settings = array( );  
   
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("text15", "text", $settings ) );
 	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
		// TITLE STYLE
		if($settings["title_style"] == ""){
			$settings["title_style"] = "basic-color-h2";
		}
		
	  
	  
	ob_start();
	?><section id="text15" class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-xl-7 mb-4">
                    <div class="row no-gutters">
<?php $i=1; while($i < 7){  ?>
<div class="col-4 mb-3">
   <div class="text-center">
      <span>
      <a href="<?php if(isset($settings['text_image'.$i.'_link']) ){ echo $settings['text_image'.$i.'_link']; }else{ echo "#"; }  ?>">
      <img data-src="<?php if(strlen($settings['text_image'.$i]) > 10){ echo $settings['text_image'.$i]; }else{ echo $CORE->LAYOUT("get_placeholder",array(100,100)); } ?>" 
         class="img-fluid lazy" alt="img">
      </a>
      </span>
      <h6 class="mt-3"><?php if(!isset($settings['text_image'.$i.'_title']) ){ echo "Image 1"; }else{ echo $settings['text_image'.$i.'_title']; } ?></h6>
   </div>
</div>
<?php $i++; } ?>
                     
                    </div>
                </div>
                <div class="col-lg-6 col-xl-5">
                    
                       
                        <?php  _ppt_template( 'framework/design/parts/title' ); ?>
            
            <?php  _ppt_template( 'framework/design/parts/btn' ); ?>
                    
                    
                </div>

            </div>

 </div>
        </div>
    </section><?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		 
		ob_start();
		?>
<style>

#text15 span {
    display: inline-block;
    text-align: center;
    color: #000;
    font-size: 30px;
}

@media (max-width:991px) {
    #text15 br {
        display: none;
    }
    #text15 h2 {
        font-size: 30px;
    }
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