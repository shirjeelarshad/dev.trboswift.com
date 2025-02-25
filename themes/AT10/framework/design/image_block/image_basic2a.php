<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_basic2a',  'data') );
add_action( 'image_basic2a',  		array('block_image_basic2a', 'output' ) );
add_action( 'image_basic2a-css',  	array('block_image_basic2a', 'css' ) );

class block_image_basic2a {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_basic2a'] = array(
			"name" 	=> "Basic 2 (a)",
			"image"	=> "image_basic2.jpg",
			"cat"	=> "image_block",
			"desc" 	=> "", 
			"order" => 3,
			"data" 	=> array( ),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		 // SETTINGS LOADED VIA MAIN LAYOUT
       	 $settings = array( );
		 
		 // ADD ON SYSTEM DEFAULTS
		 $settings = $CORE->LAYOUT("get_block_settings_defaults", array("image_basic2a", "image_block", $settings ) );
 		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 // DEFAULTS
		 $i=1; while($i < 4){ 		 	
			if($settings['image_block'.$i] == ""){
				$settings['image_block'.$i] = $CORE->LAYOUT("get_placeholder",array(1000,500));
			}
			$i++;
		 }	  
 
		ob_start();
		?>
        
<section class="image_block grid <?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
 

<div class="<?php echo $settings['section_w']; ?> <?php if($settings['section_w'] == "container-fluid"){ ?>px-0<?php } ?>">

<?php if($settings['title_show'] == "yes"){ ?>
<div class="row ">
<div class="col-md-12">
<?php  _ppt_template( 'framework/design/parts/title' ); ?>
<?php  _ppt_template( 'framework/design/parts/btn' ); ?>
</div>
</div>
<?php } ?>
<div class="row no-gutters">
 
                 
<?php $i=1; while($i < 3){ ?>
<div class="col-6">

<?php 
global $imagedata;
 
?>  
<?php _ppt_template( 'framework/design/image_block/parts/i'.$i );  ?>
</div>   
<?php $i++; } ?>
  

</div></div>
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
		
@media only screen and (max-width: 991px) {
    .image_block .box-wrap.long-height, .image_block .box-wrap.mid-height{
    	height: 300px;
    }
}
 


</style>
        
 
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>