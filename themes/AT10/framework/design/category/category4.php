<?php
 
add_filter( 'ppt_blocks_args', 	array('block_category4',  'data') );
add_action( 'category4',  		array('block_category4', 'output' ) );
add_action( 'category4-css',  	array('block_category4', 'css' ) );
add_action( 'category4-js',  	array('block_category4', 'js' ) );

class block_category4 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['category4'] = array(
			"name" 	=> "Style 4",
			"image"	=> "category4.jpg",
			"cat"	=> "category",
			"desc" 	=> "", 
			"data" 	=> array(  ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( );  
	  
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("category4", "category", $settings ) ); 

		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
	 
		
	ob_start();
	?><section class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">

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
 
.block-category4 .list-unstyled { background:#ffffff; }
.block-category4 .list-unstyled > .cat-item {  margin:5px; margin-bottom:30px; background: #fff;  }
.block-category4 .list-unstyled > .cat-item em { display:none; }
.block-category4 .list-unstyled > .cat-item  .fa {  margin-right:10px; }
.block-category4 .list-unstyled > .cat-item  > a { display:block; background:#fff; padding: 0px 20px; line-height:50px; height:50px; overflow:hidden; font-size:16px;   font-weight: bold; }
.block-category4 .list-unstyled > .cat-item > .children { list-style:none; padding:0px; padding:10px 0px; }
.block-category4 .list-unstyled > .cat-item > .children > .cat-item { border-bottom:1px solid #fff; margin:0px; line-height:30px; padding:0px 20px; max-height:50px; overflow:hidden; }
.block-category4 .list-unstyled > .cat-item > .children > .cat-item > em { display:block; float:right; margin-right: 10px;    font-size: 14px;    color: #999;}
.block-category4 .list-unstyled .catcount { font-size:11px; }
.block-category4 .list-unstyled .children li:last-child{ border-bottom:0px !important; }

@media (max-width: 575.98px) {  .block-category4 .list-unstyled > .cat-item { width:100%;   } .block-category4 .list-unstyled > .cat-item .fa { font-size: 26px !important;    margin-top: 15px; }  }
@media (min-width: 576px) and (max-width: 767.98px) { .block-category4 .list-unstyled > .cat-item { width: 48%; float: left;   } .block-category4 .list-unstyled > .cat-item .fa { font-size: 26px !important;    margin-top: 15px; }    }
@media (min-width: 768px) and (max-width: 991.98px) {  .block-category4 .list-unstyled > .cat-item { width: 31.8%; float: left;   }  } 
@media (min-width: 992px) and (max-width: 1199.98px) {  .block-category4 .list-unstyled > .cat-item { width: 31.8%; float: left;   }   } 
@media (min-width: 1200px) {.block-category4 .list-unstyled > .cat-item { width:23.9%; float:left; } }
   
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