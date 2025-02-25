<?php

global $imagedata, $settings;
 
?>
<figure class="effect-<?php echo $imagedata['effect']; ?> textpos-<?php echo $imagedata['image_txtpos']; ?>">

<img data-src="<?php echo $imagedata['image']; ?>" alt="<?php echo strip_tags($imagedata['image_title']); ?>" class="lazy" />
<figcaption>
<div class="wrapper">
<div class="caption">

<div class="title <?php echo $imagedata['title_margin']; ?> font-<?php echo $imagedata['title_font'];  ?> text-<?php echo $imagedata['title_txtcolor']; ?> <?php echo $imagedata['title_txtw']; ?> textsize-<?php echo $imagedata['title_txtsize']; ?>"><?php echo str_replace("<small>","<small class='text-primary'>",$imagedata['image_title']); ?></div>

<?php if(strlen($imagedata['image_subtitle']) > 1){ ?>
<div class="subtitle text-<?php echo $imagedata['subtitle_txtcolor']; ?> font-<?php echo $imagedata['subtitle_font'];  ?> <?php echo $imagedata['subtitle_txtw']; ?> textsize-<?php echo $imagedata['subtitle_txtsize']; ?> <?php echo $imagedata['subtitle_margin']; ?> <?php echo $imagedata['subtitle_txtw']; ?>"><?php echo $imagedata['image_subtitle']; ?></div>
<?php } ?>


<?php if($imagedata['btn_show'] == "yes"){  


	 $settings["btn_show"]		= $imagedata['btn_show'];
	 $settings["btn_txt"]		= $imagedata['btn_txt'];	 
	 $settings["btn_bg"]		= $imagedata['btn_bg']; 
	 $settings["btn_bg_txt"]	= $imagedata['btn_bg_txt']; 
	 $settings["btn_icon"]		= $imagedata['btn_icon']; 
	 $settings["btn_icon_pos"]	= $imagedata['btn_icon_pos'];
	 $settings["btn_size"]		= $imagedata['btn_size']; 
	 $settings["btn_margin"]	= $imagedata['btn_margin']; 
	 $settings["btn_style"]		= $imagedata['btn_style']; 
	 $settings["btn_font"]		= $imagedata['btn_font']; 	
	 $settings["btn_link"]		= $imagedata['btn_link'];

	ob_start(); _ppt_template( 'framework/design/parts/btn' ); $d = ob_get_clean();
	echo str_replace("<a","<button", str_replace("</a>","</button>", str_replace("href=","data-link=", $d ) ));
 	

} ?>

</div>
<?php if($imagedata['btn_show'] != "yes"){ ?>
<a href="<?php if($imagedata['btn_link'] == ""){ echo home_url()."/?s=";  }else{ echo $imagedata['btn_link']; } ?>">&nbsp;</a>
<?php } ?>

</div>
</figcaption>
</figure>