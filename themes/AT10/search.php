<?php
   /* 
   * Theme: TURBOBID CORE FRAMEWORK FILE
   * Url: www.turbobid.ca
   * Author: Md Nuralam
   *
   * THIS FILE WILL BE UPDATED WITH EVERY UPDATE
   * IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
   *
   * http://codex.wordpress.org/Child_Themes
   */
   if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
   
   global $CORE, $LAYOUT, $wpdb, $wp_query, $userdata; 
    
   $GLOBALS['flag-search'] = 1;
        
   if(!_ppt_checkfile("search.php")){ 
   
   
   
   // CHECK FOR REDIRECT
   if(_ppt(array("search","mustlogin")) == 1 && !$userdata->ID){ 
   
   		$link = _ppt(array("search","mustlogin_link"));
		if($link == ""){
			$link = wp_login_url();
		}
		
		header("location: ".$link);
		exit();
			
   }
 
   // GET STYLE
	if( ( defined('WLT_DEMOMODE') &&  isset($_GET['style']) && is_numeric($_GET['style']) ) || ( isset($_GET['style']) && is_numeric($_GET['style']) && function_exists('current_user_can') && current_user_can('administrator') ) ){
		$thisdesign = $_GET['style'];
	}else{
		$thisdesign = _ppt(array('design','search_layout')); 
	}	
    if($thisdesign == ""){ $thisdesign = 5; }
	
	if(THEME_KEY == "ph"){ $thisdesign = 8; }
	
	$GLOBALS['flag-search-style'] = $thisdesign;
	
	
	
	
	 
    get_header();  
   
   _ppt_template( 'page', 'top' ); 
   
   if(!in_array($thisdesign,array('5','6')) ){ 
   
	_ppt_template( 'search', 'bar-filters' ); 

	}  
	
	if(in_array($thisdesign,array('7')) ){ 
	
	 _ppt_template( 'search', 'mapside' ); 
   
   } 
   
   
   if(in_array($thisdesign,array('8')) ){ 
	
	 _ppt_template( 'search', 'top-filters' ); 
   
   }  
   
 
if($CORE->LAYOUT('captions','maps') && _ppt(array("maps","enable")) == 1 && !in_array($thisdesign,array('7')) ){ _ppt_template( 'search', 'map' ); } 


if(!in_array($thisdesign,array('7'))){
?>
 <?php echo do_shortcode('[elementor-template id="275246"]'); ?>
<section class="section-40" style="
            background-image: url(&quot;<?php echo home_url(); ?>/wp-content/uploads/2024/06/Ellipse-186-2.png&quot;);
            background-repeat: no-repeat;
            background-size: contain;
            background-position-x: 0;
            background-position-y: 637px;
            ">
  <div class="<?php if(in_array($thisdesign,array('1','2')) || THEME_KEY == "ph" ){ ?>container container-full-width px-lg-5 px-md-4 mx-lg-2<?php }else{ ?>container<?php } ?>">
 

    <div class="row">
      <?php if(in_array($thisdesign,array('5','6')) ){ ?>
      <div class="col-md-4 col-lg-3 pr-md-4 collapsed" id="filters-extra">      
        <?php _ppt_template( 'search', 'sidebar' ); ?>
      </div>
      <?php } ?>
      <div class="col">
        <div <?php if(in_array($thisdesign,array('5','6')) || $CORE->ADVERTISING("check_exists", "search_side") ){ ?>class="row px-0"<?php } ?>>
          <?php if($CORE->ADVERTISING("check_exists", "search_side") ){  ?>
          <div class="col-12  col-xl-10">
            <?php _ppt_template( 'search', 'bar' ); ?>
          </div>
          <div class="d-none d-lg-block col-xl-2">
            <?php if($CORE->ADVERTISING("check_exists", "search_side") ){ ?>
            <?php echo $CORE->ADVERTISING("get_banner", "search_side" );  ?>
            <?php } ?>
          </div>
          <?php }else{ ?>
          <div class="col-12">
            <?php if(isset($GLOBALS['flag-taxonomy'])){ ?>
            <?php _ppt_template( 'search', 'taxonomy' ); ?>
            <?php } ?>
            
            <?php dynamic_sidebar("search_top");  ?>
            
            <?php _ppt_template( 'search', 'bar' ); ?>
            
            <?php dynamic_sidebar("search_bottom");  ?>

            
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>
 <div class="text-center py-4">
    <h2>Deals You might like</h2>
  </div>

  <?php

  echo do_shortcode("[ending_soon_listings]");
  echo do_shortcode('[elementor-template id="313983"]');

  ?>
<?php } ?>





<textarea style="width:100%; height:100px; display:none" id="_filter_data"></textarea>
<input type="hidden" name="cardlayout" class="customfilter" id="filter-cardlayout"  data-type="select" data-key="cardlayout" value="<?php echo $CORE->LAYOUT("default_search_type", $thisdesign); ?>" />
<input type="hidden" name="perpage"  class="customfilter" data-type="select" data-key="perpage" value="<?php if(THEME_KEY == "ph"){ echo 24; }else{ echo get_option('posts_per_page'); } ?>">

<?php if(isset($_GET['uid']) && is_numeric($_GET['uid']) ){ ?>
<input type="hidden" class="customfilter"  name="userid" data-type="text" data-key="userid" value="<?php echo esc_attr($_GET['uid']); ?>" >
<?php } ?>

<?php if(isset($_GET['favs']) ){ ?>
<input type="hidden" class="customfilter"  name="favorites" data-type="text" data-key="favorites" value="1" >
<?php } ?>

<?php if(isset($GLOBALS['flag-taxonomy']) && isset($GLOBALS['flag-taxonomy-id']) ){ ?>
<input type="hidden" name="taxonomy"  class="customfilter" data-type="text" data-key="taxonomy" value="<?php echo $GLOBALS['flag-taxonomy-type']."-".$GLOBALS['flag-taxonomy-id']; ?>" >
<?php } ?>

<?php if(is_tag()){ 
$tag_obj = $wp_query->get_queried_object();
?>
<input type="hidden" name="taxonomy"  class="customfilter" data-type="text" data-key="taxonomy" value="<?php echo $tag_obj->taxonomy."-".$tag_obj->term_id; ?>" >
<?php } ?>


<script>
jQuery(document).ready(function(){ 
     
   <?php if(!in_array($thisdesign,array('5','6','7','8')) ){  ?>
   jQuery('.btn_filt').show();
 
   <?php } ?>
  
  _filter_update();
   
   // SHOW FIRST 5 FILTERS
   var i = 0;
   jQuery('.filters_sidebar .filter-content').each(function () {
		if(i < 5){
		jQuery(this).addClass('show');
		i ++;
		}
		
	}); 
});
</script>
<?php _ppt_template( 'page', 'bottom' ); ?>
<?php get_footer(); ?>
<?php } ?>