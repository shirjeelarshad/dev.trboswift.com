<?php
 
add_filter( 'ppt_blocks_args', 	array('block_category2',  'data') );
add_action( 'category2',  		array('block_category2', 'output' ) );
add_action( 'category2-css',  	array('block_category2', 'css' ) );
add_action( 'category2-js',  	array('block_category2', 'js' ) );

class block_category2 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['category2'] = array(
			"name" 	=> "Style 2",
			"image"	=> "category2.jpg",
			"cat"	=> "category",
			"desc" 	=> "", 
			"data" 	=> array(  ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( );  
	  
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("category2", "category", $settings ) ); 

		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
	 
		
	ob_start();
	?><section id="new-categories-7" class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">

   <div class="container"><div class="row">

   <?php if($settings['title_show'] == "yes"){ ?>
      <div class="col-12 section-bottom-40">       
          <?php _ppt_template( 'framework/design/parts/title' ); ?>
      </div>
      <?php } ?>
    
   
    
      <div class="col-12 pt-4">
      
      <div class="clearfix"></div>
      
      
 
<?php
 

$i = 1; $n = 1; $shown=1; $offset = 0;
	 
 
if(isset($settings['boxcss'])){ $boxcss = $settings['boxcss']; }else{  $boxcss = "col-xl-3 col-md-4 col-12 px-0 px-md-2"; }



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
<div class="row">
                <?php
                    
                     
                        
                         
                         
                $categories = get_categories($args);
                
                 $c = 0;
                foreach ($categories as $ccat) { 
                
                        // HIDE PARENT
                        if($ccat->parent != 0){ continue; }
                        
                        // SHOW AMOUNT
                        if($shown > $show ){ $i++;continue; }
                         
                        // CHECK FOR OFFSET
                        if($i < $offset){ $i++; continue; }	 
                        
                        $shown++;
                                         
                        if(isset($ccat->term_id) && isset($GLOBALS['CORE_THEME']['category_icon_small_'.$ccat->term_id]) && $GLOBALS['CORE_THEME']['category_icon_small_'.$ccat->term_id] != ""   ){
                        $caticon = "fa ".str_replace("&", "&amp;",$GLOBALS['CORE_THEME']['category_icon_small_'.$ccat->term_id]);
                        }else{
                       
					   		$cat_icons_small = array(
		
						'fa-car',
						'fa-archive',
						'fa-university',
						'fa-coffee',
						'fa-heart',
						'fa-desktop',
						'fa-film',
						'fa-futbol',
						'fa-bus',
						
						'fa-car',
						'fa-coffee',
						'fa-university',
						'fa-archive',
						'fa-laptop',
						'fa-desktop',
						'fa-film',
						'fa-futbol',
						'fa-bus',
						
						'fa-car',
						'fa-archive',
						'fa-university',
						'fa-coffee',
						'fa-heart',
						'fa-desktop',
						'fa-film',
						'fa-futbol',
						'fa-bus',
		
		);	
		
		if(isset($cat_icons_small[$c])){
		$caticon = "fal ".$cat_icons_small[$c];
		}else{
		$caticon = "fal fa-check";
		}
						$c++;
						
                        }
                        
                        // LINK 
                        $link = get_term_link($ccat);
                        
                ?>
<div class="col-lg-4 col-sm-6">


<div class="ccat">

<div class="ccat-icon bg-primary">
<i class="text-white fa-2x fa <?php echo str_replace("-o","",$caticon); ?>"></i>
</div>

<h4>
<a href="<?php echo get_term_link($ccat->term_id, 'listing'); ?>"><?php echo $ccat->name; ?></a>
</h4>

<?php
$childcats = get_terms( 'listing', array(        'hide_empty' => 0,        'parent' => $ccat->term_id   ));

$limit = 5;
$v = 0;
if(!empty($childcats)){
foreach($childcats as $childcat){  
if($v > $limit){ continue; }
?>
<p><a href="<?php echo get_term_link($childcat->term_id, 'listing'); ?>"><?php echo $childcat->name; ?></a></p>
<?php 


$v++; } } ?>                        
</div>
            
                    
                    							
            
                

</div>
<?php $i++; } ?>
</div>
            
         	 
            
      </div>     
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
 
#new-categories-7 .ccat{    border: 1px solid #e1e1e1;    text-align: center;    margin: 0 0 50px 0;    position: relative;}
#new-categories-7 .ccat .ccat-icon{    display: inline-block;    position: absolute;    top: -20px;    width: 48px;    height: 48px;    background: #3f3d59;    left: 0;    right: 0;    margin: 0 auto;}
#new-categories-7 .ccat .ccat-icon i{    padding: 10px 0 0 0;    color: #ffffff;}
#new-categories-7 .ccat h4{    margin: 48px 0 20px 0;    font-weight: 700;}
#new-categories-7 .ccat h4 a{    text-decoration: none;    color: #3f3d59;}
#new-categories-7 .ccat p:last-child{    margin: 0 0 20px 0; }
#new-categories-7 .ccat p a{    text-decoration: none;    color: #888888;}

#new-categories-7 .ccat:hover{    border: 1px solid #666; background:#fff; }
#new-categories-7 .ccat:hover .ccat-icon{    background: #a0ce4e;}
#new-categories-7 .ccat:hover h4 a{    color: #222;}
#new-categories-7 .ccat .ccat-icon img{    padding: 10px;    width: 100%;    height: auto; }
   
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