<?php
 
add_filter( 'ppt_blocks_args', 	array('block_category3',  'data') );
add_action( 'category3',  		array('block_category3', 'output' ) );
add_action( 'category3-css',  	array('block_category3', 'css' ) );
add_action( 'category3-js',  	array('block_category3', 'js' ) );

class block_category3 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['category3'] = array(
			"name" 	=> "Style 3",
			"image"	=> "category3.jpg",
			"cat"	=> "category",
			"desc" 	=> "", 
			"data" 	=> array(  ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( );  
	  
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("category3", "category", $settings ) ); 

		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
	 
		
	ob_start();
	?><section id="new-categories-5" class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">

   <div class="container"><div class="row">

   <?php if($settings['title_show'] == "yes"){ ?>
      <div class="col-12 section-bottom-40">       
          <?php _ppt_template( 'framework/design/parts/title' ); ?>
      </div>
      <?php } ?>
    
   
    
      <div class="col-12 pt-4">
      
      <div class="clearfix"></div>
      
<?php

global $settings; 

	// SETTINGS
	$GLOBALS['_list'] = 0;
	
	if(isset($settings['cat_offset']) && is_numeric($settings['cat_offset'])){ 			$offset = $settings['cat_offset']; }else{ $offset = 0; } 
	if(isset($settings['cat_show']) && is_numeric($settings['cat_show'])){  			$show = $settings['cat_show']; }else{ $show = 8; }
	if(isset($settings['cat_show_list']) && is_numeric($settings['cat_show_list'])){  	$show_list = $settings['cat_show_list']; }else{  $show_list = 5; }
	
	$orderby = "menu_order";
	$order = "asc";	
	
	
	$args = array(
	
		'taxonomy'  	=> 'listing',
		'depth'         => 10,	
		'hierarchical'  => true,		
		'hide_empty'    => 0,
		'echo'			=> false,
		'title_li' 		=> '',
		
		'walker'		=> new walker_shortcode_dcats,		
		
		'orderby'      => $orderby,
		'order'		 	=> $order,
 
		'limit' 		=> $show,
		'limit_list' 	=> $show_list,
		'offset'		=> $offset,
		
		
		'show_count'	=> 1,
	
	); 
	
	$categories = wp_list_categories($args); 
               
?>
 
<ul class="list-unstyled m-0 px-0">
<?php echo $categories; ?>
</ul> 
<div class="clearfix"></div>            
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
 
#new-categories-5 .list-unstyled { background:#ffffff; }
#new-categories-5 .list-unstyled > .cat-item {border:1px solid #ddd; margin:5px; margin-bottom:30px; background: #fff;  }
#new-categories-5 .list-unstyled > .cat-item em { display:none; }
#new-categories-5 .list-unstyled > .cat-item  .fa {  margin-right:10px; }
#new-categories-5 .list-unstyled > .cat-item  > a { display:block; background:#fff; border-bottom:1px solid #ddd; padding: 0px 20px; line-height:60px; height:60px; overflow:hidden; font-size:16px;   font-weight: bold; }
#new-categories-5 .list-unstyled > .cat-item > .children { list-style:none; padding:0px; }
#new-categories-5 .list-unstyled > .cat-item > .children > .cat-item { border-bottom:1px solid #ddd; margin:0px; line-height:50px; padding:0px 20px; max-height:50px; overflow:hidden; }
#new-categories-5 .list-unstyled > .cat-item > .children > .cat-item > em { display:block; float:right; margin-right: 10px;    font-size: 14px;    color: #999;}
#new-categories-5 .list-unstyled .catcount { font-size:11px; }
#new-categories-5 .list-unstyled .children li:last-child{ border-bottom:0px !important; }

@media (max-width: 575.98px) {  #new-categories-5 .list-unstyled > .cat-item { width:100%;   } #new-categories-5 .list-unstyled > .cat-item .fa { font-size: 26px !important;    margin-top: 15px; }  }
@media (min-width: 576px) and (max-width: 767.98px) { #new-categories-5 .list-unstyled > .cat-item { width: 48%; float: left;   } #new-categories-5 .list-unstyled > .cat-item .fa { font-size: 26px !important;    margin-top: 15px; }    }
@media (min-width: 768px) and (max-width: 991.98px) {  #new-categories-5 .list-unstyled > .cat-item { width: 47.8%; float: left;   }  } 
@media (min-width: 992px) and (max-width: 1199.98px) {  #new-categories-5 .list-unstyled > .cat-item { width: 31.8%; float: left;   }   } 
@media (min-width: 1200px) {#new-categories-5 .list-unstyled > .cat-item { width:23.9%; float:left; } }
   
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