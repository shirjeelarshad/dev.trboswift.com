<?php
 
add_filter( 'ppt_blocks_args',  array('block_hero_search3',  'data') );
add_action( 'hero_search3',  			array('block_hero_search3', 'output' ) );
add_action( 'hero_search3-css',  		array('block_hero_search3', 'css' ) );
add_action( 'hero_search3-js',  		array('block_hero_search3', 'js' ) );

class block_hero_search3 {

	function __construct(){}		

	public static function data($a){ 
	
		global $CORE;
  
		$a['hero_search3'] = array(
			"name" 	=> "Hero Search 3",
			"image"	=> "hero_search3.jpg",
			"cat"	=> "hero",
			"order" => 5,
			"desc" 	=> "", 
			"data" 	=> array( ),
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h1",
					
					"title" 			=> "Build Amazing Websites",					 
					"subtitle"			=> $CORE->LAYOUT("get_placeholder_text", array('desc', "hero") ),					
					"desc" 				=> "",
					 	
					"title_margin"		=> "",
					"subtitle_margin"	=> "mb-5",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "light",
					"subtitle_txtcolor" => "light",
					"desc_txtcolor" 	=> "opacity-5",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
					 
					"hero_size" 		=> "hero-large",
					"hero_image" 		=> DEMO_IMG_PATH."/blocks/hero/hero5_bg.jpg",
					"hero_overlay" 		=> "grey", 				
					 
			),
					
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $settings, $new_settings;
	
	
        $settings = array( ); 
		
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("hero_search3", "hero", $settings ) );
 
		 // UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		 if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		 } 
		 
		/* DEFAULTS */
		if($settings['hero_image'] == ""){
		
			$default_data = $CORE->LAYOUT("get_block_defaults", "hero_search3");		 	 
			$settings['hero_image'] = $default_data['hero_image'];
		 	
			if($settings['hero_txtcolor'] == "light"){
			$settings['hero_size'] .= " bg-dark";	
			}else{
			$settings['hero_size'] .= " bg-light";	
			}
			
		}
		
		
		
		$settings['title_pos'] = "center";
		
   $categories = wp_list_categories( 
   	array(
   	'taxonomy'  	=> 'listing',
   	'depth'         => 1,	
   	'hierarchical'  => 1,		
   	'hide_empty'    => 0,
   	'echo'			=> false,
   	'title_li' 		=> '',
   	'orderby' 		=> 'term_order',
   	'walker'		=> new walker_shortcode_dcats,
   	'limit' 		=> 16,
   	'show_count'	=> 0,
   	) 
   );
		
		
	 
 
		ob_start();
		
		
		?>
<section class="position-relative heros3 position-relative hero-default hero-search <?php echo $settings['hero_size']; ?> hero-default text-<?php echo $settings['hero_txtcolor']; ?>">
  <div class="bg-image" data-bg="<?php echo $settings['hero_image']; ?>"></div>
  <?php _ppt_template( 'framework/design/hero/parts/overlay' ); ?>
  <div class="hero_content bg-content clearfix" style="top:25%">
    <div class="col-lg-10  mx-auto text-center mt-lg-5">
      <?php _ppt_template( 'framework/design/parts/title' ); ?>
    </div>
    <div class="<?php if(in_array( _ppt(array('design','boxed_layout')), array("1","1a","1b") )){ ?>col-xl-10<?php }else{ ?>col-xl-8<?php } ?> mx-auto text-center">
      <?php _ppt_template( 'framework/design/parts/search-inline' ); ?>
    </div>
  </div>
  <div class="cats-inner hide-mobile ">
    <div class="container">
      <div class="row categories">
        <ul class="list-unstyled m-0 p-0">
          <?php echo str_replace("text-primary","",$categories); ?>
        </ul>
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


.heros3 .form-control { border:0px; border-radius:0px;; border-bottom:1px solid #fff; padding:0px; background: none;}
.heros3 input.form-control { color:#fff;  }	
.heros3 select { color:#fff; }	
.heros3 ::-webkit-input-placeholder { 
 color: #fff;
}
.heros3 ::-moz-placeholder {  
 color: #fff;
}
.heros3 :-ms-input-placeholder {
  color: #fff;
}
.heros3 :-moz-placeholder {  
 color: #fff;
}

 
.heros3 .cats-inner {    background: -moz-linear-gradient(top,rgba(0,0,0,.65) 0,rgba(0,0,0,.65) 100%);
   background: -webkit-gradient(linear,left top,left bottom,color-stop(0,rgba(0,0,0,.65)),color-stop(100%,rgba(0,0,0,.65)));
   background: -webkit-linear-gradient(top,rgba(0,0,0,.65) 0,rgba(0,0,0,.65) 100%);
   background: -o-linear-gradient(top,rgba(0,0,0,.65) 0,rgba(0,0,0,.65) 100%);
   background: -ms-linear-gradient(top,rgba(0,0,0,.65) 0,rgba(0,0,0,.65) 100%);
   background: linear-gradient(to bottom,rgba(0,0,0,.65) 0,rgba(0,0,0,.65) 100%);
   min-height: 180px;    padding: 30px 0 40px;
       position: absolute;
    width: 100%; 
	bottom: 0px; 
	z-index: 100;
   
   }
.heros3 .search-inner > div {  background: rgba(0, 0, 0, 0.2);}
.heros3 h1 { text-shadow: 1px 1px #333;}
.heros3 .categories li a, .heros3  .categories li .fa { color:#FFFFFF !important;  }
.heros3 .categories li .fa { margin-right:10px; } 
.heros3 .search-inner p { max-width:600px;margin:auto auto; }
.heros3 .categories li em { float:right; color:#CCCCCC; margin-right:20px; opacity: 0.5; }

.heros3 .homensearch select, .hero25 .homensearch input { border-radius:0px;  }
.heros3 .homensearch ::-webkit-input-placeholder  { color:#000; }

.heros3.bg-dark { color:#fff; }
.heros3.bg-light { color:#333; }
.heros3 .categories li {    float: left;    min-height: 40px; line-height:40px;    min-width: 25%;}

.heros3 .categories li a { display: block;
    max-width: 150px;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    float: left;}
	 

@media (min-width: 1200px) {

    .heros3 .container {  max-width:950px; margin:auto auto;  }
	 
	
	
	/* large */
   .heros3.hero-large .categories li  {  min-height: 60px; line-height:60px;   }
   .heros3.hero-large .categories li a, .heros3.hero-large  .categories li .fa { font-size:20px;     display: block;
    max-width: 200px;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    float: left;}
	 
}
@media (max-width: 575.98px) { 
	
	
   .heros3 .categories li {    float: left;       min-width: 50%; text-align:center; }
 
   
   .heros3 .form-control, .heros3 .btn, .heros3 .input-group-append, .input-group-prepend {display:block; margin-bottom:10px; width:100%; }
   .heros3 form { border:0px; padding:10px; }
   .heros3 .categories li a, .heros3  .categories li .fa { font-size:16px; }   
}
</style>
<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}		
	public static function js(){ global $CORE;
		ob_start();
	  _ppt_template( 'framework/design/hero/parts/js' );  
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}	
	
}

?>