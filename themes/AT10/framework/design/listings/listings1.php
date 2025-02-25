<?php
 
add_filter( 'ppt_blocks_args', 	array('block_listings1',  'data') );
add_action( 'listings1',  		array('block_listings1', 'output' ) );
//add_action( 'listings1-css',  		array('block_listings1', 'css' ) );
//add_action( 'listings1-js',  		array('block_listings1', 'js' ) );

class block_listings1 {

	function __construct(){}		

	public static function data($a){ global $CORE; 
  
		$a['listings1'] = array(
			"name" 	=> "Style 1 - Carousel",
			"image"	=> "listings1.jpg",
			"cat"	=> "listings",
			"order" => 1,
			"desc" 	=> "", 
			"data" 	=> array( ),	
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					"title_pos" 		=> "center",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "listings") ),					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('subtitle', "listings") ),					
					"desc" 				=> "",
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "mb-4",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "dark",
					"subtitle_txtcolor" => "primary",
					"desc_txtcolor" 	=> "opacity-5",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
					 
					
					// BUTTON					
					"btn_show" 			=> "no",						
					"btn_style" 		=> "1",				
					"btn_size" 			=> "",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "",
					"btn_font" 			=> "",
					"btn_txt" 			=> "",
					"btn_link" 			=> "",
					"btn_bg" 			=> "",
					"btn_bg_txt" 		=> "",					
					"btn_margin" 		=> "mt-4",
					 			
					
					// BUTTON				
					"btn2_show" 		=> "no",						
					"btn2_style" 		=> "2",				
					"btn2_size" 		=> "",
					"btn2_icon" 		=> "",				
					"btn2_icon_pos" 	=> "",
					"btn2_font" 		=> "",
					"btn2_txt" 			=> "",
					"btn2_link" 		=> "",
					"btn2_bg" 			=> "",
					"btn2_bg_txt" 		=> "",					
					"btn2_margin" 		=> "mt-4",
					 
			),
			
					
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array(
				  
				"datastring" => "custom=new num=12",
				 
		 );  
	 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("listings1", "listings", $settings ) ); 

		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
 
	ob_start();
	 
	?>
<section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
  <div class="container">
    <div class="row m-0">
      <?php if($settings['title_show'] == "yes"){ ?>
      <div class="col-12 ">
        <?php _ppt_template( 'framework/design/parts/title' ); ?>
      </div>
      <?php } ?>
      <div class="col-12 px-sm-2 p-md-0">
        <div class="clearfix"></div>
        <div class="listing1-carousel-1 owl-carousel owl-theme home-big-banner"> <?php
		
		
		if(isset($_GET['ppt_live_preview'])){
		echo str_replace("data-src","src",do_shortcode('[LISTINGS card="" dataonly=1 nav=0 small=1 carousel=1 '.$settings['datastring'].' ]')); 
		}else{
		echo do_shortcode('[LISTINGS card="" dataonly=1 nav=0 small=1 carousel=1 '.$settings['datastring'].' ]'); 		
		}
		
		  ?> </div>
      </div>
    </div>
  </div>
</section>
<script> 
jQuery(document).ready(function(){ 

	var owl = jQuery(".listing1-carousel-1").owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        autoplay:false,
        dots: false,
		 <?php if($CORE->GEO("is_right_to_left", array() )){ ?>rtl: true,<?php } ?>
		lazyLoad:true,
        responsive: {
            0: {
                items: 1
            },			 
            600: {
                items: 1
            },
			800: {
                items: 1
            },	
            1000: {
                items: 1
            }
        },        
    }); 
	
	owl.owlCarousel();
	 
	
	// REFRESH	
	setTimeout(function(){	
   		owl.trigger('refresh.owl.carousel');		 
	}, 2000); 
 
	
	});		 
</script>

<style>

.new-search{
    border: 0px solid #fff !important;
    //box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
}

 @media (min-width: 1200px){
.home-big-banner .new-search.small:not(.no-resize) figure {
    height: auto !important;
}



.home-big-banner .new-search {
    border-radius: 15px;
    background: #fff !important;
}


.home-gallery-img{
width:100%;
height:700px !important;
object-fit:cover;
object-position:center;
}

.home-gallery-img1{
width:100%;
height:700px !important;
object-fit:cover;
object-position:center;
}

.home-gallery-img2{
width:100%;
height:100% !important;
object-fit:cover;
object-position:center;
}

.home-gallery-img3{
width:100%;
height:350px !important;
object-fit:cover;
}

}

@media (min-width: 576px) and (max-width: 1199.99px){
.home-big-banner .new-search.small:not(.no-resize) figure {
    height: auto !important;
    max-height: fit-content !important;
}



.home-big-banner .new-search {
    border-radius: 10px;
    background: #fff !important;
}

/*
.home-gallery{
width:100%;
height:500px;

}
*/

.home-gallery-img{
width:100%;
height:500px !important;
object-fit:cover;
object-position:center;
}

.home-gallery-img1{
width:100%;
height:500px !important;
object-fit:cover;
object-position:center;
}

.home-gallery-img2{
width:100%;
height:100% !important;
object-fit:cover;
}

.home-gallery-img3{
width:100%;
height:250px !important;
object-fit:cover;
}


.home-gallery-mobile-bottom{
display: flex;
flex-direction: column;
}

}



@media (max-width: 575.99px){

/* Mobile Phone */

figure.home-gallery-card {
    height: 100% !important;
    max-height: fit-content !important;
   
}

.home-gallery-mobile-bottom{
display: flex;
flex-direction: row;
}

.home-gallery-card{
border-radius:15px !important;
}

.home-gallery-img{
width:100%;
height:280px !important;
object-fit:cover;
object-position:center;
}

.home-gallery-img1{
width:100%;
height:180px !important;
object-fit:cover;
object-position:center;
}

.home-gallery-img2{
width:100%;
height:100px !important;
object-fit:cover;
}

.home-gallery-img3{
width:50%;
height:100px !important;
object-fit:cover;
}

}



.home-banner-ending-bid{

 position: absolute;
    bottom: 0;
    right: 50px;
    background: #333;
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    -ms-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);

    margin-bottom: 10px;
    margin-right: -40px;
    letter-spacing: 0.5px;
    border-radius: 5px;
}

.home-banner-title {

position: absolute;
    top: 0;
    left: 20px;
    color: #FFF;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    margin-top: 20px;
    letter-spacing: 0.5px;
    

}

</style>

<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
	
		public static function js(){
		
		ob_start();
		?>
<?php	
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		 }	
}

?>