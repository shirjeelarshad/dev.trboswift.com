<?php
 
add_filter( 'ppt_blocks_args', 	array('block_category5',  'data') );
add_action( 'category5',  		array('block_category5', 'output' ) );
add_action( 'category5-css',  	array('block_category5', 'css' ) );
add_action( 'category5-js',  	array('block_category5', 'js' ) );

class block_category5 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['category5'] = array(
			"name" 	=> "Style 5",
			"image"	=> "category5.jpg",
			"cat"	=> "category",
			"desc" 	=> "", 
			"data" 	=> array(  ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( );  
	  
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("category5", "category", $settings ) ); 

		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
	 
		
	ob_start();
	?><section  class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">

   <div class="container"><div class="row">

   <?php if($settings['title_show'] == "yes"){ ?>
      <div class="col-12 section-bottom-40">       
          <?php _ppt_template( 'framework/design/parts/title' ); ?>
      </div>
      <?php } ?>
    
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
?>
<div class="ccat2 col-12">
            <div class="row">
               <?php
                  $i = 1; $n = 1; $shown=1;
                  
                  $categories = get_categories($args);
                  
                  $cat=1;
                  foreach ($categories as $category) { 
                  
                  // HIDE PARENT
                  if($category->parent != 0){ continue; }
                  
		// SHOW AMOUNT
		if($shown > $show ){ $i++;continue; }
		 
		// CHECK FOR OFFSET
		if($i < $offset){ $i++; continue; }	 
		
		$shown++;
  
                  // LINK 
                  $link = get_term_link($category);
				
                  ?>
               <div class="col-xl-3 col-md-4 col-12">
                  <div class="cat bg-white">
                     <a href="<?php echo $link; ?>">
                        <div class="clearfix p-2">
                           <div class="text-dark pt-1 text-left"><span class="pl-2"><?php echo $category->name; ?></span> <span class="float-right countb bg-primary text-light px-2 mt-n1"><?php echo $category->count; ?></span> </div>
                        </div>
                     </a>
                  </div>
               </div>
               <?php $i++; } ?>
            </div>
</div>


   </div> </div>

</section><?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		ob_start();
		?>
<style>
.ccat2 .cat {  background: #F9F9F9;   line-height: 1.2;   width: 100%;   position: relative;   border: 1px solid #F1F1F1;   font-size: 13px;   font-weight: 400;   letter-spacing: 0.5px;   text-align: center;   margin-bottom:20px;   }
.ccat2 .cat .countb { float: right!important;  padding: 3px;    font-size: 13px;}
.ccat2 .cat-item1 {   background: #F9F9F9;   line-height: 1.2;   width: 100%;   position: relative;   border: 1px solid #F1F1F1;   font-size: 13px;   font-weight: 400;   letter-spacing: 0.5px;   text-align: center;   margin-bottom:20px;   }

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