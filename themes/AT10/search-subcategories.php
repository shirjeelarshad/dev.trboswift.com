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

global $CORE, $wpdb, $term;
 
if(!_ppt_checkfile("search-subcategories.php")){

$term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
 
// GET SUB CATEGORIES
$subcats = wp_list_categories(array('taxonomy' => 'listing', 'child_of' => $term->term_id, 'title_li' => '', 'show_option_all' => false, "show_option_none" => " ", "echo" => false));
// GET PARENT WHEN VIEWING CHILD
if($term->parent != 0){
$term_parent = get_term_by('id', $term->parent, get_query_var( 'taxonomy' ) );
$subcats .= wp_list_categories(array('taxonomy' => 'listing', 'child_of' => $term->parent, 'title_li' => '', 'show_option_all' => false, "show_option_none" => " ", "echo" => false));
}

 
?><main id="main">
   <div class="container">
      <?php if(_ppt("category_hideresults_".$term->term_id) == 1){ ?>
      <div class="subcats-block">
         <div class="row">
            <?php
               $i = 1; $n = 1;
               $args = array(
               	  'taxonomy'     => THEME_TAXONOMY,
               	  'orderby'      => 'term_order',
               	  'order'		 => 'asc',
               	  'show_count'   => 1,
               	  'pad_counts'   => 1,
               	  'hierarchical' => 0,
               	  'title_li'     => '',
               	  'hide_empty'   => 0,
               	  'child_of' 		=> $term->term_id
               	 
               );
               $categories = get_categories($args);
               
               $cat=1;
               foreach ($categories as $category) { 
               
               
               // IMAGE
               if(isset($category->term_id) && isset($GLOBALS['CORE_THEME']['category_image_'.$category->term_id])   ){
               $image = str_replace("&", "&amp;",$GLOBALS['CORE_THEME']['category_image_'.$category->term_id]);
               }else{
               $image = "https://via.placeholder.com/220x190.png?text=".$category->name."";
               }
               
               
               // LINK 
               $link = get_term_link($category);
               
               
               // CHECK FOR CATEGORY TRANSLATIONS
               $catTrans = _ppt('category_translation');
               $lang = $CORE->_language_current();
               $cat_name = $category->name;
               if($catTrans != "" && $lang != "en_US"){ 
               	if(isset($catTrans[strtolower($lang)]) && isset($catTrans[strtolower($lang)][$category->term_id]) ){			
               		$cat_name = $catTrans[strtolower($lang)][$category->term_id];			
               	}		
               }
               
               ?>
            <div class="col-md-3 col-sm-4 col-xs-6">
               <div class="cat-wrap">
                  <div class="cat">
                     <div class="img" style="background-image:url('<?php echo $image; ?>');">
                        <a href="<?php echo $link; ?>">
                        </a>
                     </div>
                     <div class="desc">
                        <div class="name"><?php echo $cat_name; ?></div>
                     </div>
                  </div>
               </div>
               <!-- end cat wrap -->
            </div>
            <?php } ?>
         </div>
      </div>
      <?php } ?>
   </div>
   <!-- end container -->
</main>
<!-- end main --><?php } ?>