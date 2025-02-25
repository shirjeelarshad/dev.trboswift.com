<?php
 
 
add_filter( 'ppt_blocks_args', 	array('block_header18',  'data') );
add_action( 'header18',  		array('block_header18', 'output' ) );
add_action( 'header18-css',  	array('block_header18', 'css' ) );
add_action( 'header18-js',  	array('block_header18', 'js' ) );

class block_header18 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['header18'] = array(
			"name" 	=> "Style 18",
			"image"	=> "header18.jpg",
			"cat"	=> "header",
			"desc" 	=> "", 
			"data" 	=> array( ),
			"order" 	=> 17,
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $userdata, $new_settings, $settings;
	
		
		// ADD ON SYSTEM DEFAULTS
		$settings = array();
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("header18", "header", $settings ) );
 
		  
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 }
		 
		 //$settings['btn'] = "yes";
		 //$settings['btn_show'] = "no";
		 $settings['topmenu_bg'] = "bg-white text-dark border-bottom";
		    
 
		ob_start();
		
		?><header class="elementor_header header18 logo-lg bg-white border-top border-bottom">
   <?php _ppt_template( 'framework/design/header/parts/header-topmenu' ); ?>
  <nav class="elementor_mainmenu navbar navbar-light navbar-expand-lg">
    <div class="container px-0">
    
    <a class="navbar-brand" href="<?php echo home_url(); ?>">
	 <?php echo $CORE->LAYOUT("get_logo","light");  ?>
	 <?php echo $CORE->LAYOUT("get_logo","dark");  ?>
     </a>
     
      <div class="collapse navbar-collapse main-menu justify-content-end" id="header1_buttonmenubar">
	  <?php echo do_shortcode('[MAINMENU class="navbar-nav" style=1]');  ?>
      </div>
      
	  <?php if($settings['btn_show'] == "yes"){ ?>
      <div class="align-items-center">
        <?php _ppt_template( 'framework/design/header/parts/header-button' ); ?>
      </div>
      <?php }else{ ?>
      <button class="navbar-toggler menu-toggle tm border-0"><span class="fal fa-bars">&nbsp;</span></button>
      <?php } ?>
      
    </div>
  </nav>
  
<div class=" border-top hide-mobile">

<div class="container px-0">

<div id="main-category-wrap">
    <div id="navMenu">
      <div id="navMenu-wrapper">
        <ul id="cat-items">
          <div id="menuSelector"></div><?php
  		 
		echo wp_list_categories( array(
                                 								'taxonomy'  	=> 'listing',
                                 								'depth'         => 1,	
                                 								'hierarchical'  => 1,		
                                 								'hide_empty'    => 0,
                                 								'echo'			=> false,
                                 								'title_li' 		=> '',
                                 								'show_count' 	=> 0,
                                 								'orderby' 		=> 'term_order',
                                 							  
                                 								) );
  		?></ul>
        <div class="navMenu-paddles">
          <button class="navMenu-paddle-left i fa <?php if($CORE->GEO("is_right_to_left", array() )){ ?>fa-angle-right<?php }else{ ?>fa-angle-left<?php } ?>"> </button>
          <button class="navMenu-paddle-right fa <?php if($CORE->GEO("is_right_to_left", array() )){  ?>fa-angle-left<?php }else{ ?>fa-angle-right<?php } ?>"> </button>
        </div>
      </div>
    </div>
</div>

</div>

</div>
  
  
</header>

<script>
jQuery(function() {
  var items = jQuery('#cat-items').width(); 
  
  jQuery('#main-category-wrap').addClass('container py-0');
  
   if( jQuery("#cat-items li").length > 5){
   
   jQuery('#navMenu-wrapper').addClass('addon');
  
  }else{
  jQuery('.navMenu-paddles').hide();
  }
  
  var itemSelected = document.getElementsByClassName('cat-item');
  navPointerScroll(jQuery(itemSelected));
  
  jQuery("#cat-items").scrollLeft(200).delay(200).animate({
    scrollLeft: "-=200"
  }, 2000, "easeOutQuad");
 
	jQuery('.navMenu-paddle-right').click(function () {
		jQuery("#cat-items").animate({
			scrollLeft: '+='+items
		});
	});
	jQuery('.navMenu-paddle-left').click(function () {
		jQuery( "#cat-items" ).animate({
			scrollLeft: "-="+items
		});
	});

  if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
    var scrolling = false;

    jQuery(".navMenu-paddle-right").bind("mouseover", function(event) {
        scrolling = true;
        scrollContent("right");
    }).bind("mouseout", function(event) {
        scrolling = false;
    });

    jQuery(".navMenu-paddle-left").bind("mouseover", function(event) {
        scrolling = true;
        scrollContent("left");
    }).bind("mouseout", function(event) {
        scrolling = false;
    });

    function scrollContent(direction) {
        var amount = (direction === "left" ? "-=3px" : "+=3px");
        jQuery("#cat-items").animate({
            scrollLeft: amount
        }, 1, function() {
            if (scrolling) {
                scrollContent(direction);
            }
        });
    }
  }
  
  

});

function navPointerScroll(ele) {

	var parentScroll = jQuery("#cat-items").scrollLeft();
	var offset = (jQuery(ele).offset().left - jQuery('#cat-items').offset().left);
	var totalelement = offset + jQuery(ele).outerWidth()/2;

	var rt = ((jQuery(ele).offset().left) - (jQuery('#navMenu-wrapper').offset().left) + (jQuery(ele).outerWidth())/2);
	jQuery('#menuSelector').animate({
		left: totalelement + parentScroll
	})
}
</script>

<?php

		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
		}
		
		public static function js(){ 
		return "";
		}
		
		public static function css(){ 
		 
		ob_start(); ?>
<style>
.elementor_mainmenu .nav-item a {
    text-transform: unset !important;
    text-decoration: unset !important;
    font-size: unset !important;
}

#main-category-wrap #navMenu {  position: relative;}
#main-category-wrap #navMenu #navMenu-wrapper {  overflow: hidden;  height: 60px; }
#main-category-wrap #navMenu #navMenu-wrapper.addon {  padding: 0 30px;}
#main-category-wrap #cat-items {  margin:0px;  padding: 0;  list-style: none;  white-space: nowrap;  overflow-x: hidden;  -webkit-overflow-scrolling: touch;} 
#main-category-wrap #navMenu ul li {  display: inline-block;  margin: 20px 24px;}
#main-category-wrap #navMenu ul li a { color:#666; }
#main-category-wrap #navMenu ul li a:hover { color:#000; font-weight:600; }
#main-category-wrap .navMenu-paddle-left, #main-category-wrap .navMenu-paddle-right {  cursor: pointer;  border: none;  position: absolute;  top: 20px;  background-color: transparent;  width: 25px;  height: 25px;  margin-left: auto;  margin-right: auto;}
#main-category-wrap .slick-prev, .navMenu-paddle-left { left: 0; } 
#main-category-wrap .slick-next, .navMenu-paddle-right { right: 0; }

.bg-dark #main-category-wrap #navMenu ul li a, .bg-dark #main-category-wrap .navMenu-paddles button { color:#fff; }
.bg-light #main-category-wrap #navMenu ul li a, .bg-light #main-category-wrap .navMenu-paddles button { color:#333; }

</style>
<?php 
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
		
}

?>
