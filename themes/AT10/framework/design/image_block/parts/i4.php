<?php 

global $imagedata, $settings;

if(isset( $settings['image_block4_effect'])){ 
 
$imagedata = array(	
	 "effect" 				=> $settings['image_block4_effect'],
	  
	 "image_txtpos" 		=> $settings['image_block4_txtpos'],
	 
	 "image" 				=> $settings['image_block4'],
	 
	 "image_title" 			=> $settings['image_block4_title'],
	 "image_subtitle" 		=> $settings['image_block4_subtitle'],

	 "title_txtcolor" 		=> $settings['image_block4_title_txtcolor'], 
	 "title_font" 			=> $settings['image_block4_title_font'], 
	 "title_margin" 		=> $settings['image_block4_title_margin'], 
	 "title_txtw" 			=> $settings['image_block4_title_txtw'], 
	 "title_txtsize" 		=> $settings['image_block4_title_txtsize'], 
  	 
	 "subtitle_txtcolor" 		=> $settings['image_block4_subtitle_txtcolor'], 
	 "subtitle_font" 			=> $settings['image_block4_subtitle_font'], 
	 "subtitle_margin" 			=> $settings['image_block4_subtitle_margin'], 
	 "subtitle_txtw" 			=> $settings['image_block4_subtitle_txtw'], 
	 "subtitle_txtsize" 		=> $settings['image_block4_subtitle_txtsize'], 

	 "btn_show" 		=> $settings['image_block4_btn_show'], 
	 "btn_txt" 			=> $settings['image_block4_btn_txt'], 	 
	 "btn_bg" 			=> $settings['image_block4_btn_bg'], 
	 "btn_bg_txt" 		=> $settings['image_block4_btn_bg_txt'], 
	 "btn_icon" 		=> $settings['image_block4_btn_icon'], 
	 "btn_icon_pos" 	=> $settings['image_block4_btn_icon_pos'], 
	 "btn_size" 		=> $settings['image_block4_btn_size'], 
	 "btn_margin" 		=> $settings['image_block4_btn_margin'], 
	 "btn_style" 		=> $settings['image_block4_btn_style'], 
	 "btn_font" 		=> $settings['image_block4_btn_font'], 	
	 "btn_link" 		=> $settings['image_block4_btn_link'], 	


);

_ppt_template( 'framework/design/image_block/parts/image' ); 

}
?>