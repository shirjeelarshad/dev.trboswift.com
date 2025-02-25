<?php
 
add_filter( 'ppt_blocks_args', 	array('block_stores2',  'data') );
add_action( 'stores2',  		array('block_stores2', 'output' ) );
add_action( 'stores2-css',  	array('block_stores2', 'css' ) );
add_action( 'stores2-js',  	array('block_stores2', 'js' ) );

if(!function_exists('n_round')){
function n_round($num, $tonearest) {  return floor($num/$tonearest)*$tonearest;}
}
if(!function_exists('stores2_pagenav')){
function stores2_pagenav($return="", $numposts = "", $max_page = "") { global $wpdb, $wp_query; $return=""; $pages = "";  $backBtn = ""; $forwardBtn = "";
 
		$posts_per_page = $max_page;
		 
		$paged = 1;
		if(isset($_GET['pv']) && is_numeric($_GET['pv'])){
		$paged = $_GET['pv'];
		}
		 
		$pagenavi_options['pages_text'] = __("Page %s of %d","premiumpress");
		$pagenavi_options['current_text'] = "%PAGE_NUMBER%";
		$pagenavi_options['page_text'] = "%PAGE_NUMBER%";		
		$pagenavi_options['first_text'] = __("<< First","premiumpress");
		$pagenavi_options['last_text'] = __("Last >>","premiumpress"); 
		$pagenavi_options['num_pages'] = "2";
		$backBtn = ""; $forwardBtn = "";		
		 
		if(empty($paged) || $paged == 0) {
			$paged = 1;
		}		
		 
		// HIDE IF
		//die($numposts." == ".$posts_per_page);
		//if($numposts  <= $posts_per_page){ return; }
		
		
		$pages_to_show = intval(5);
		$larger_page_to_show = intval(1);
		$larger_page_multiple = intval(1);
		$pages_to_show_minus_1 = $pages_to_show - 1;
		$half_page_start = floor($pages_to_show_minus_1/2);
		$half_page_end = ceil($pages_to_show_minus_1/2);
		$start_page = $paged - $half_page_start;
		
	 
		if($start_page <= 0) {
			$start_page = 0;
		}
		$end_page = $paged + $half_page_end;
		if(($end_page - $start_page) != $pages_to_show_minus_1) {
			$end_page = $start_page + $pages_to_show_minus_1;
		}
		if($end_page > $max_page) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page = $max_page;
		}
		if($start_page <= 0) {
			$start_page = 0;
		}
		$larger_per_page = $larger_page_to_show*$larger_page_multiple;
		$larger_start_page_start = (n_round($start_page, 10) + $larger_page_multiple) - $larger_per_page;
		$larger_start_page_end = n_round($start_page, 10) + $larger_page_multiple;
		$larger_end_page_start = n_round($end_page, 10) + $larger_page_multiple;
		$larger_end_page_end = n_round($end_page, 10) + ($larger_per_page);
		if($larger_start_page_end - $larger_page_multiple == $start_page) {
			$larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
			$larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
		}
		if($larger_start_page_start <= 0) {
			$larger_start_page_start = $larger_page_multiple;
		}
		if($larger_start_page_end > $max_page) {
			$larger_start_page_end = $max_page;
		}
		if($larger_end_page_end > $max_page) {
			$larger_end_page_end = $max_page;
		}
		if($max_page > 1 || intval(1) == 1) {
		
		
		if($max_page == 0 && $paged > 0){ $max_page=1; }
		
			$pages_text = str_replace("%s", number_format_i18n($paged), $pagenavi_options['pages_text']);
			$pages_text = str_replace("%d", number_format_i18n($max_page), $pages_text);	
  		
					// PAGES COUNT
					if(!empty($pages_text)) {
						$pages .= '<div class="pages"><span class="page-link">'.$pages_text.'</span></div>';
					}
					
					 
					 // PREVIOUS
					 
					if($paged > 1 ){							
							 			
										
					 	$link = _ppt(array('links','stores'))."/?pv=".($paged-1);	
						 
															
						$backBtn .= '<li class="page-item"><a href="'.$link.'" class="page-link last"><i class="fa fa-angle-left"></i> <span class="hide-mobile">'.__("Previous","premiumpress").'</span></a></li>';
													
					} 
					
					 
					
				  	//  NUMBERS
					for($i = $start_page; $i  <= $end_page; $i++) {	
					 
					
						$link = _ppt(array('links','stores'))."/?pv=".($i);
						
						$thispageid = $i;  
						$thispageid++; // not show 0
					 	
						if(isset($_GET['pv']) && is_numeric($_GET['pv']) && $_GET['pv'] > 0){
					    $activepage = $paged + 1;
						}else{
						$activepage = 1;
						}
						
						 
						/*** build string ***/
						if($thispageid == $activepage) {							
							$current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($thispageid), $pagenavi_options['current_text']);
							
							$return .= '<li class="page-item"><a href="'.$link.'" class="page-link num page-link bg-primary text-light" rel="nofollow">'.$current_page_text.'</a></li>';
						
						
						} else {
							$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($thispageid), $pagenavi_options['page_text']);
							
							$return .= '<li class="page-item"><a href="'.$link.'" class="page-link num" rel="nofollow">'.$page_text.'</a></li>';
						}
					}
					
					
					 
			 		// FIRST BUTTON
					if($paged > 0 && $paged < $max_page){	
						/*** get link for formatting ***/						
						 
						$link = _ppt(array('links','stores'))."/?pv=".($paged+1);						 
						 
						$forwardBtn = '<li class="page-item"><a href="'.$link.'" class="page-link next"><span class="hide-mobile">'.__("Next","premiumpress").' &nbsp;&nbsp;</span> <i class="fa fa-angle-right nomargin" aria-hidden="true"></i> </a></li>';	
										
					} 
		}
	 
	
	// ADD ON STYLE WRAPPER <div class="pager pull-right">'.$pages.'</div>
	$return = '
	<nav class="ppt-pnav clearfix my-4">
	<ul class="pagination justify-content-center">'.$backBtn.''.$return.''.$forwardBtn.'</ul>  </nav>';
	 
	// RETURN VALUE
	if($return){	return $return;	}else{	echo $return;	}
}
}


class block_stores2 {

 
	function __construct(){}		

	public static function data($a){ 
  
		$a['stores2'] = array(
			"name" 		=> "Style 2",
			"image"		=> "stores2.jpg",
			"cat"		=> "store",
			"desc" 		=> "", 
			"order" 	=> 2, 
			
			"data" 	=> array( ),
			
			"defaults" => array(
					
					"section_padding" => "section-80",
					"section_bg"	=>	"bg-light",	
					
					// TEXT						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					"title_pos" 		=> "left",
					
					
					"title" 			=> "Popular Stores",					 
					"subtitle"			=>  "",					
					"desc" 				=> "",
					 	
					"title_margin"		=> "mb-4",
					"subtitle_margin"	=> "",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "light",
					"subtitle_txtcolor" => "opacity-5",
					"desc_txtcolor" 	=> "opacity-5",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
					 
					
					// BUTTON					
					"btn_show" 			=> "yes",						
					"btn_style" 		=> "4",				
					"btn_size" 			=> "btn-md",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "",
					"btn_font" 			=> "",
					"btn_txt" 			=> __("All Stores","premiumpress"),
					"btn_link" 			=> _ppt(array('links','stores')),
					"btn_bg" 			=> "light",
					"btn_bg_txt" 		=> "text-light",					
					"btn_margin" 		=> "mt-2",
				 
					
					 
			), 			
		);		
		
		return $a;
	
	} 
 
function n_round($num, $tonearest) {  return floor($num/$tonearest)*$tonearest;}
 
	
	public static function output(){ global $CORE, $new_settings, $settings;
	 
	
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("stores2", "store", $settings ) );
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
	 
 
  
	 $settings['card'] 			= "store";
	 $settings['custom'] 		= "stores";
	 $settings['datastring'] 	= "";
	 $settings['perrow'] 		= "5"; 
	  
	 
	ob_start();
	
	?><section  class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
  <div class="container"><div class="row">
    
 
     
 
  
		<?php
		
		
		$categories = get_terms('store', 'orderby=term_order&hide_empty=0');
		$start		= 0;
		$per_page 	= 12;
		$total_stores = count($categories);
		
	 	
		if(isset($_GET['pv']) && is_numeric($_GET['pv'])){
		 $start = $per_page*$_GET['pv'];
		}   
         
		$i=1; $sf = 0;
        foreach ($categories as $term) { 
        
           // HIDE PARENT
           if($term->parent != 0){ continue; }
				
			if($i < $start){
				$i++;
				continue;
			}
				
			$sf ++;				
			if($sf > $per_page){
				continue;
			}               
                
          // LINK 
          $link = get_term_link($term);
				
		 // IMAGE
		 $img = do_shortcode('[STOREIMAGE id="'.$term->term_id.'"]');
                
        ?>
        
          
        <div class="col-12 col-md-4 col-lg-3">
        
       <div data-pid="<?php echo $term->term_id; ?>" class="card-search card-zoom card-top-image border-0 card-coupon text-center bg-white">
       
		  <?php /************ MIAN IMAGE ***/ ?>
          <figure class="<?php if(strpos($img, "linksy") !== false){ echo "py-5"; } ?>"> <a href="<?php echo $link; ?>">
          
          <img src="<?php echo $img; ?>" class="img-fluid" alt="<?php echo $term->name; ?>">
            <div class="read_more"><span><?php echo __("view","premiumpress"); ?></span></div>
            </a> </figure>
          <?php /***************** */ ?>
          <div class="card-body  p-0 py-3 text-center">
              <?php 
		   
		   
		   	if( defined('WLT_DEMOMODE') ){
		 
				$did = filter_var($term->name, FILTER_SANITIZE_NUMBER_INT);	
			 				
				if(is_numeric($did) && isset($GLOBALS['CORE_THEME']['storedata'][$did]['title'])){
							
					echo $GLOBALS['CORE_THEME']['storedata'][$did]['title'];
								
				}else{
				
					echo $CORE->GEO("translation_tax", array($term->term_id, $term->name)); 
				}
		
	 
		}else{
		
				echo $CORE->GEO("translation_tax", array($term->term_id, $term->name)); 
		
		}
		   
		 ?>
          </div>
        </div>
        
        </div>
        <?php $i++; } ?>  
 
 
 
 
 <?php if($total_stores > $per_page){ ?>
<div class="col-12 text-center">
 
<?php echo stores2_pagenav($return="", $per_page, round($total_stores/$per_page,0)); ?>
 

</div>
<?php } ?>
 
 
 
 
</div>
</div>
</section> 
 
<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		return "";
		ob_start();
		?>
 
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