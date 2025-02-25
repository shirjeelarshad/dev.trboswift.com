<?php
 
add_filter( 'ppt_blocks_args',  	array('block_image_test',  'data') );
add_action( 'image_test',  		array('block_image_test', 'output' ) );
add_action( 'image_test-css',  	array('block_image_test', 'css' ) );

class block_image_test {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['image_test'] = array(
			"name" 	=> "Test Only",
			"image"	=> "image_text.jpg",
			"cat"	=> "image_block",
			"desc" 	=> "", 
			"order" => 99,
			"data" 	=> array(
			
			 
				  
			),
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings;
	
	
        global $imagedata;
 
		ob_start();
		?>
        
<div class="grid section-100">
<div class="container">
<div class="row ">

<div class="col-12 text-center">
<h4>Text Position</h4>
</div>
<?php 
 

$areas = array('tleft','tright','bleft','bright','center','tcenter','bcenter','ccenter');

$i =1; while($i < 10){ ?>
<div class="col-md-4 mb-4">
<?php

 

$imagedata = array(	
	 "effect" 				=> 1,
	  
	 "image_txtpos" 		=> $areas[$i],
	 
	 "image" 				=> $CORE->LAYOUT("get_placeholder", array(400,250) ),
	 
	 "image_title" 			=> 'My Title '.$areas[$i],
	 "image_subtitle" 		=> "subtitle here",

	 "title_txtcolor" 		=> "light", 
	 "title_font" 			=> "",
	 "title_margin" 		=> "", 
	 "title_txtw" 			=> "", 
	 "title_txtsize" 		=> "md", 
  	 
	 "subtitle_txtcolor" 		=> "",
	 "subtitle_font" 			=> "",
	 "subtitle_margin" 			=> "",
	 "subtitle_txtw" 			=> "",
	 "subtitle_txtsize" 		=> "",

	 "btn_show" 		=> "yes", 
	 "btn_txt" 			=> "Button", 	 
	 "btn_bg" 			=> "", 
	 "btn_bg_txt" 		=> "",
	 "btn_icon" 		=> "",
	 "btn_icon_pos" 	=> "", 
	 "btn_size" 		=> "",
	 "btn_margin" 		=> "", 
	 "btn_style" 		=> "",
	 "btn_font" 		=> "", 	
	 "btn_link" 		=> "",
);

_ppt_template( 'framework/design/image_block/parts/image' ); 
?>
</div>
<?php

$i++; } ?>
</div>
</div></div>
</section>

<hr />

<div class="grid section-100">
<div class="container">
<div class="row ">

<div class="col-12 text-center">
<h4>Text Effects</h4>
</div>

<?php 
 

$effects = array(1,2,3,4,5,6,7);

foreach($effects as $i){ ?>
<div class="col-md-4 mb-4">
<?php

$imagedata = array(	
	 "effect" 				=> $i,
	  
	 "image_txtpos" 		=> "bleft",
	 
	 "image" 				=> $CORE->LAYOUT("get_placeholder", array(400,250) ),
	 
	 "image_title" 			=> 'Effect '.$i,
	 "image_subtitle" 		=> "subtitle here",

	 "title_txtcolor" 		=> "", 
	 "title_font" 			=> "",
	 "title_margin" 		=> "", 
	 "title_txtw" 			=> "", 
	 "title_txtsize" 		=> "", 
  	 
	 "subtitle_txtcolor" 		=> "",
	 "subtitle_font" 			=> "",
	 "subtitle_margin" 			=> "",
	 "subtitle_txtw" 			=> "",
	 "subtitle_txtsize" 		=> "",

	 "btn_show" 		=> "yes", 
	 "btn_txt" 			=> "Button", 	 
	 "btn_bg" 			=> "", 
	 "btn_bg_txt" 		=> "",
	 "btn_icon" 		=> "",
	 "btn_icon_pos" 	=> "", 
	 "btn_size" 		=> "",
	 "btn_margin" 		=> "", 
	 "btn_style" 		=> "",
	 "btn_font" 		=> "", 	
	 "btn_link" 		=> "",
);

 

_ppt_template( 'framework/design/image_block/parts/image' ); 
?>
</div>
<?php } ?>
</div>
</div></div>
</section>

   

		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
	
	public static function css(){ global $CORE;
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