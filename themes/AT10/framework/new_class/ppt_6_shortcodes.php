<?php
/*

LIST OF SHORTCODES
1. TITLE
2. EXCERPT
3. CONTENT
4. TAGS
5. IMAGE (SINGLE)
6. IMAGES 
7. VIDEO (SINGLE)
8. 
9. CATEGORY
10. CATEGORYICON
11. CUSTOM FIELD

*/
function _ppt_shortcodelist(){

return array(

"TITLE" => array(

	"name" 		=> "Post Title",
	"desc" 		=> "Will display the listing/post title.",
	"example"	=> "[TITLE]",
),

"EXCERPT" => array(

	"name" 		=> "Post Excerpt",
	"desc" 		=> "Will display the post except and fallback to the post content.",
	"example"	=> "[EXCERPT show=100]",
),


"CONTENT" => array(

	"name" 		=> "Post Content",
	"desc" 		=> "Will display the post content.",
	"example"	=> "[CONTENT]",
),

"IMAGE" => array(

	"name" 		=> "Post Image",
	"desc" 		=> "Will display the post image.",
	"example"	=> "[IMAGE pathonly=0]",
),

"VIDEO" => array(

	"name" 		=> "Post Video",
	"desc" 		=> "Will display the post video.",
	"example"	=> "[VIDEO]",
),

"VIDEO-YOUTUBE" => array(

	"name" 		=> "Post YouTube Video",
	"desc" 		=> "Will display the YouTube video.",
	"example"	=> "[VIDEO-YOUTUBE]",
),


"TAGS" => array(

	"name" 		=> "Post Tags",
	"desc" 		=> "Will display the post tags.",
	"example"	=> "[TAGS]",
),


"AUTHOR" => array(

	"name" 		=> "Author Name",
	"desc" 		=> "Will display the post tags.",
	"example"	=> "[AUTHOR link=1]",
),


"AUTHORIMAGE" => array(

	"name" 		=> "Author Image",
	"desc" 		=> "Will display the author image",
	"example"	=> "[AUTHORIMAGE circle=1 size=16]",
),

"FAVS" => array(

	"name" 		=> "Favorites Buttton",
	"desc" 		=> "Will display the icon to allow users to add listing to favorites",
	"example"	=> "[FAV icon=1 icon_only=0]",
),

"SUBSCRIBE" => array(

	"name" 		=> "Subscribe Button",
	"desc" 		=> "Will display the icon to allow users to add subscribers",
	"example"	=> "[SUBSCRIBE icon=1 icon_only=0]",
),


"TAX" => array(

	"name" 		=> "Taxonomy Display",
	"desc" 		=> "Will display the listing value for the taxonomy",
	"example"	=> "[TAX name='listing' pid='']",
),

"SOCIALSHARE" => array(
	"name" 		=> "Social Share Icons",
	"desc" 		=> "Will display social share icons on your listing page",
	"example"	=> "[SOCIALSHARE small=0]",
),



);



}


class premiumpress_elementor_shortcode {

    private static $_instance = null;

    private static $elementor_frontend;

    public static function instance() {

        if (is_null(self::$_instance)) {
            self::$_instance = new self(); // 135 number line
        }
        return self::$_instance;

    }

    public function __construct() {

        if (defined('ELEMENTOR_VERSION')) {
            if (class_exists('\Elementor\Frontend')) {
                self::$elementor_frontend = new \Elementor\Frontend(); // 143 number line

                add_shortcode('premiumpress_elementor_template', array($this, 'elemenntor_add_template'));
            } else {
                error_log('Elementor Frontend class does not exist.');
            }
        } else {
            error_log('Elementor is not activated.');
        }
    }

    public function elemenntor_add_template($atts) {
        $atts = shortcode_atts(array(
            'id' => '',
        ), $atts, 'elementor_add_template');

        if ($atts['id'] !== '' && self::$elementor_frontend) {
            return self::$elementor_frontend->get_builder_content_for_display($atts['id']);
        } else {
            error_log('Elementor Frontend instance is not available or ID is empty.');
            return '';
        }
    }
}

premiumpress_elementor_shortcode::instance(); // 158 number line

class framework_shortcodes extends framework_search {








function pptv9_shortcode_listing_ratebox( $atts, $content = null  ){ global $CORE, $post;

	// GET THE ID OF THE STAR ITEM
		if(isset($id) && strlen($id) > 0){ $thisID = $id; }elseif(isset($GLOBALS['POSTID'])){ $thisID = $GLOBALS['POSTID']; }else{ $thisID = $post->ID; }
		 
		// SETUP UNIQUE ID
		$divID = str_replace("+","",round(microtime(true) * 440)).$post->ID;
		if(isset($GLOBALS[$divID])){ return; }
		$GLOBALS[$divID] = true;
		
		// ITEM SCOPE RATING
		$itemscope_ratingcount = 0;
		$itemscope_ratingvalue = 0;
		 
		$up 	= get_post_meta($thisID, 'ratingup', true);
		$down 	= get_post_meta($thisID, 'ratingdown', true);
				
		// CSS FOR NO VOTES
		if($up == 0 && $down == 0){ $ncc = "novotes";  }else{ $ncc = ""; }
				
				
				if($up == ""){ $up =0; }
				if($down == ""){ $down =0; }
				$total = $up+$down;				 
				
				// ITEM SCOPE
				$itemscope_ratingcount = $total;
				$itemscope_ratingvalue = 5;
				
				// WORK OUT GOOD PERCENTAGE
				if($total == 0 || $up == 0 ){
					$good_per = 0;					
				}else{
					$good_per = ($up*100)/$total;				
				}
				
				// STYLE RANGES
				if($good_per == 0 || $good_per > 0){
				$ratingstyle = "rt1";
				}
				if($good_per > 40){
				$ratingstyle = "rt2";
				}
				if($good_per > 70){
				$ratingstyle = "rt3";
				}
				if($good_per > 90){
				$ratingstyle = "rt4";
				}
		
		$randomID = rand(); 
		
		// CHECK IF WE HAVE ALREADY RATED
		$user_ip = $CORE->get_client_ip();
		$rated_user_ips = get_option('rated_user_ips');
		$ratedup = false;
		$rateddown = false;
		$ratingset = false;
		if(!is_array($rated_user_ips)){ $rated_user_ips = array(); }
	 	
			if(isset($rated_user_ips[$post->ID]) && is_array($rated_user_ips[$post->ID]['ip-'.$user_ip]) && in_array($user_ip, $rated_user_ips[$post->ID]['ip-'.$user_ip])  ){			
				
				$ratingset = true;
				if( $rated_user_ips[$post->ID]['ip-'.$user_ip]['rating'] == 1){
					$ratedup = true;
				}else{
					$rateddown = true;
				}			
			}
		
		?>
  
                
<div class="smilesratingbox">        
<div class="rounded-0"  id="<?php echo $divID; ?>">

  <label class="btn ratingup btn-sm btn-system rounded-0 mr-2">
      <a href="javascript:void(0);" <?php if(!$ratingset){ ?>onclick="doratebutton('<?php echo $divID; ?>', '<?php echo $post->ID; ?>', 'up');" <?php } ?> class="text-dark">
			   <span class="up" data-toggle="tooltip" data-placement="top" title="<?php echo __("It's Great!","premiumpress"); ?>">
               <i class="fa fa-thumbs-up "></i>
               </span> 
              <?php echo $up; ?>
	</a>
               
  </label>
  <label class="btn ratingdown btn-sm  rounded-0 btn-system ">
    <a href="javascript:void(0);" <?php if(!$ratingset){ ?>onclick="doratebutton('<?php echo $divID; ?>', '<?php echo $post->ID; ?>', 'down');"<?php } ?> class="text-dark">
               <span class="down" data-toggle="tooltip" data-placement="top" title="<?php echo __("It's Bad","premiumpress"); ?>">
               <i class="fa fa-thumbs-down"></i>
               </span>  
              <?php echo $down; ?>
			   </a>
  </label> 
 
</div>
</div>

<script>
jQuery(document).ready(function(){ 

 setTimeout(function(){  
	jQuery('[data-toggle="tooltip"]').tooltip();
	}, 3000);
});
</script>
 
<?php

}
	
	










 

function pptv9_shortcode_socialbtns($atts, $content = null){ global $wpdb, $post;
	
extract( shortcode_atts( array( 'small' => true ), $atts ) );	

if(is_single()){
	$link = get_permalink($post->ID);
	$title = $post->post_title;
}else{
	$link = home_url();
	$title = "";
}

$link  = str_replace("&","&amp;", $link );

if($small){
$size = 16;
}else{
$size = 32;
}

ob_start();
?>
 
<a href="https://www.facebook.com/sharer.php?u=<?php echo $link; ?>" target="_blank">
<img src="<?php echo get_template_directory_uri(); ?>/framework/images/social/facebook<?php echo $size; ?>.png" alt="Facebook"/></a>
<a href="https://twitter.com/share?url=<?php echo $link; ?>" target="_blank">
<img src="<?php echo get_template_directory_uri(); ?>/framework/images/social/twitter<?php echo $size; ?>.png" alt="Twitter"/></a>
<a href="https://api.addthis.com/oexchange/0.8/forward/linkedin/offer?url=<?php echo $link; ?>&amp;pubid=ra-53d6f43f4725e784&amp;ct=1&amp;title=<?php echo $title; ?>&amp;pco=tbxnj-1.0" target="_blank">
<img src="<?php echo get_template_directory_uri(); ?>/framework/images/social/linkedin<?php echo $size; ?>.png" alt="LinkedIn"/></a>

<?php 
return ob_get_clean(); 

}	




function pptv9_shortcode_storeimage( $atts, $content = null ) { global $post;

		extract( shortcode_atts( array(  'link' => 0, 'id' => '', 'checkimage' => 0  ), $atts ) );
		
 
	
			if(is_numeric($id)){
			
				$t = get_term_by('id', $id, 'store');
			    $storedata = array();
				$storedata[0] = $t;
			
			}else{
				$storedata 	= wp_get_object_terms( $post->ID, 'store' ); 
			}
			
			
			// CHECK FOR IMAGE
			if($checkimage == 1){
 			 $img = do_shortcode('[IMAGE pathonly=1 fallback=0 link=0]');
				if(strlen($img) > 5){
					return $img;
				}
			
			}
			
		 	
			//$storedata = get_term_by('id', $post->ID, 'store');
			$store_image = get_template_directory_uri()."/framework/images/nostore.jpg";
			 
			if(isset($storedata[0]->name)){
			
			 	if(defined('WLT_DEMOMODE') && isset($GLOBALS['CORE_THEME']['storedata']) && isset($storedata[0]->name) ){  
							
						$did = filter_var($storedata[0]->name, FILTER_SANITIZE_NUMBER_INT);							
							
						if(isset($GLOBALS['CORE_THEME']['storedata'][$did]['image'])){
							
							return $GLOBALS['CORE_THEME']['storedata'][$did]['image'];
								
						}
				}
						
				
				if(_ppt('storeimage_'.$storedata[0]->term_id) != ""){
					
					return _ppt('storeimage_'.$storedata[0]->term_id);
					
				}
				 
			
			}	
			
			return $store_image;
		
}

function pptv9_shortcode_storename( $atts, $content = null ) { global $post;

		extract( shortcode_atts( array(  'link' => true, 'linkonly' => false, 'id' => '', 'pid' => ''  ), $atts ) );
		 
		if(is_numeric($id)){			
				$t = get_term_by('id', $id, 'store');
			    $storedata = array();
				$storedata[0] = $t;
			
		}elseif(is_numeric($pid)){
			$storedata 	= wp_get_object_terms( $pid, 'store' );		
		}elseif(isset($post->ID)){
			$storedata 	= wp_get_object_terms( $post->ID, 'store' );		
		}else{		
			return "";
		}
		
		 
		if(is_array($storedata) && !empty($storedata)){
		
			$name = $storedata[0]->name;		
		
		 		if(defined('WLT_DEMOMODE') && isset($GLOBALS['CORE_THEME']['storedata']) && isset($name) ){  
							
						$did = filter_var($name, FILTER_SANITIZE_NUMBER_INT);	 
						 	
						if(isset($GLOBALS['CORE_THEME']['storedata'][$did]['title'])){
							
							$name =  $GLOBALS['CORE_THEME']['storedata'][$did]['title'];
								
						}
				}
			  
		
	 		if($linkonly){
			return get_term_link($storedata[0]->term_id, "store");
			}
			
			if($link){
			
			return "<a href='".get_term_link($storedata[0]->term_id, "store")."' class='' target='_blank'>".$name."</a>";
			
			 
			}else{
			
			return $name;
			
			}
		
		
		}
		
		return "";
		
}

function pptv9_shortcode_storelink( $atts, $content = null ) { global $post;

		extract( shortcode_atts( array(  'link' => 1 ), $atts ) );
		
		if(!isset($post->ID)){
		return ;
		}
		
		$found 	= wp_get_object_terms( $post->ID, 'store' );
		 
		if(is_array($found) && !empty($found)){
	 		
			return get_term_link($found[0]->term_id, "store");	
			
			//return home_url()."/".$found[0]->slug."/";
			
			//	
		
		}
		
		return "";
		
}


function pptv9_shortcode_features( $atts, $content = null ) { global $post, $CORE;

		extract( shortcode_atts( array(  'link' => 0  ), $atts ) );
		
		
		$e1 = _ppt(array('design', "element_features")); 
		
		if($e1 == "" || $e1 == 1){
		
				$cl = $CORE->_language_current();
								 
				if(_ppt(array('lang','switch')) == 1 && $cl != "en_US"){
				
					$cats = get_the_terms( $post->ID, 'features');
					
					if(!empty($cats)){
						$t = "";
						foreach($cats as $c){
							
							$t .= "<a href='". get_term_link($c)."'>".$CORE->GEO("translation_tax", array($c->term_id, $c->name))."</a>";	
						
						}
					
					}					 					
				
				}
				
				 
				if( !isset($t) ){
				$t = get_the_term_list( $post->ID, 'features', "", '', '' );
				}	 
				
				$css = "";
				$features_pos = _ppt(array('design','single_features_pos')); 
				if($features_pos == "bottom"){
				$css = "bottom";
				}
			  	
				if(strlen($t) < 50){
				return "<hr />";
				}
				return "<div class='features-list-small ".$css."'>".$t."</div>";			 
		
		}

		return "";
		
 		
}


function pptv9_shortcode_features_tax( $atts, $content = null ) { global $post, $CORE;

		extract( shortcode_atts( array(  'link' => 0  ), $atts ) );
	

		$data = array(
		
		
      		"pj" => array(
			
				1 => array( 
					
					"value" => $post->ID,
					"desc" => __("Project ID","premiumpress"),		
					"show" => 1,
					"icon" => "fal fa-hashtag",
					
				),
                
                2 => array( 
					
					"value" => $CORE->PACKAGE("get_timesince", $post->post_date),
					"desc" => __("Date Posted","premiumpress"),		
					"show" => 1,
					"icon" => "fal fa-calendar",
					 
				),
                
                 3 => array( 
					
					"value" => do_shortcode('[PROPOSALS]'),
					"desc" => __("Proposals","premiumpress"),		
					"show" => 1,
					"icon" => "fal fa-users",
					 
				),
                
                
				
            ),
		   
		 
      
      		"rt" => array(
			
				1 => array( 
					
					"value" => do_shortcode('[SIZE]'),
					"desc" => __("Size","premiumpress"),		
					"show" => _ppt(array('design', "element_size")),
					"icon" => "fal fa-sync",
					
				),
                
                2 => array( 
					
					"value" => do_shortcode('[BEDS]'),
					"desc" => __("Beds","premiumpress"),		
					"show" => _ppt(array('design', "element_beds")),
					"icon" => "fal fa-bed",
					"tax" => "beds",
				),
                
                 3 => array( 
					
					"value" => do_shortcode('[BATHS]'),
					"desc" => __("Baths","premiumpress"),		
					"show" => _ppt(array('design', "element_baths")),
					"icon" => "fal fa-bath",
					"tax" => "baths",
				),
                
                
				
            ),
		
			"jb" => array(
			
				1 => array( 
					
					"value" => $CORE->PACKAGE("get_timesince", $post->post_date),
					"desc" => __("Date Posted","premiumpress"),		
					"show" => _ppt(array('design', "element_date")),
					"icon" => "fal fa-calendar-check",
				),
				
                
                2 => array( 
					
					"value" => do_shortcode('[SALARY]'),
					"desc" => __("Salary","premiumpress"),		
					"show" => _ppt(array('design', "element_salary")),
					"icon" => "fal fa-funnel-dollar",
				),
                
                 3 => array( 
					
					"value" => do_shortcode('[HOURS]'),
					"desc" => __("Avg. Per Week","premiumpress"),		
					"show" => _ppt(array('design', "element_hours")),
					"icon" => "fal fa-clock",
				), 
                 
                4 => array( 
					
					"value" => do_shortcode('[OFFERS]'),
					"desc" => __("Applicants","premiumpress"),		
					"show" => _ppt(array('design', "element_offers")),
					"icon" => "fal fa-users",
				),
                
                5 => array( 
					
					"value" => do_shortcode('[EXPERIENCE]'),
					"desc" => __("Experience","premiumpress"),		
					"show" => _ppt(array('design', "element_experience")),
					"icon" => "fal fa-university",
				),
                
                6 => array( 
					
					"value" => do_shortcode('[CATEGORY]'),
					"desc" => __("Category","premiumpress"),		
					"show" => _ppt(array('design', "element_category")),
					"icon" => do_shortcode('[CATEGORYICON default="fal fa-home" codeonly="1"]'),
				),
				
			),
		
		
			"da" => array(
			
				1 => array( 
					
					"value" => do_shortcode('[GENDER]'),
					"desc" => __("Gender","premiumpress"),		
					"show" => _ppt(array('design', "element_gender")),
					"icon" => do_shortcode('[GENDERICON icononly=1]'),
					"tax" => "dagender",
				),
				
				
				2 => array( 
					
					"value" => do_shortcode('[SEXUALITY]'),
					"desc" => __("Sexuality","premiumpress"),		
					"show" => _ppt(array('design', "element_sexuality")),
					"icon" => _ppt(array('taxicon', "dasexuality")),  
					"tax" => "dasexuality",
				),
				
				
				3 => array( 
					
					"value" => do_shortcode('[AGE]'),
					"desc" => __("Age","premiumpress"),		
					"show" => _ppt(array('design', "element_age")),
					"icon" => "fal fa-abacus",
					
				),
				
				4 => array( 
					
					"value" => do_shortcode('[TAX name="dathnicity"]'),
					"desc" => __("Ethnicity","premiumpress"),		
					"show" => _ppt(array('design', "element_dathnicity")),
					"icon" => _ppt(array('taxicon', "dathnicity")), 
					"tax" => "dathnicity", 
				),
				
				5 => array( 
					
					"value" => do_shortcode('[TAX name="daeyes"]'),
					"desc" => __("Eye Color","premiumpress"),		
					"show" => _ppt(array('design', "element_eye")),					
					"icon" => _ppt(array('taxicon', "daeyes")),
					"tax" => "daeyes", 
				),
				
				6 => array( 
					
					"value" => do_shortcode('[TAX name="dahair"]'),
					"desc" => __("Hair Color","premiumpress"),		
					"show" => _ppt(array('design', "element_hair")),					 
					"icon" => _ppt(array('taxicon', "dahair")),
					"tax" => "dahair",
				),
				
				7 => array( 
					
					"value" => do_shortcode('[TAX name="dabody"]'),
					"desc" => __("Body Shape","premiumpress"),		
					"show" => _ppt(array('design', "element_body")),
					"icon" => _ppt(array('taxicon', "dabody")), 
					"tax" => "dabody",
				),
				
				8 => array( 
					
					"value" => do_shortcode('[TAX name="dasmoke"]'),
					"desc" => __("Smokes","premiumpress"),		
					"show" => _ppt(array('design', "element_smoke")),					
					"icon" => _ppt(array('taxicon', "dasmoke")), 
					"tax" => "dasmoke",
				),
				
				9 => array( 
					
					"value" => do_shortcode('[TAX name="dadrink"]'),
					"desc" => __("Drinks","premiumpress"),		
					"show" => _ppt(array('design', "element_drink")),
					"icon" => _ppt(array('taxicon', "dadrink")), 
					"tax" => "dadrink",
				),
				
				
				
				
				
			),
			
			"mj" => array(
				
				/*
				1 => array( 
					
					"value" => do_shortcode('[DAYS]')." ".__("days","premiumpress") ,
					"desc" => __("Completion Time","premiumpress"),		
					"show" => _ppt(array('design', "element_days")),
					"icon" => "fa fa-clock",
				),
				*/
				
				2 => array( 
					
					"value" => do_shortcode('[SALES]'),
					"desc" => __("Jobs Sold","premiumpress"),		
					"show" => _ppt(array('design', "element_sold")),
					"icon" => "fa fa-sync",
				),
			
				
				3 => array( 
					
					"value" => do_shortcode('[WAITING]'),
					"desc" => __("Orders in Queue","premiumpress"),		
					"show" => _ppt(array('design', "element_waiting")),
					"icon" => "fa fa-box",
				),
			
			/*
				4 => array( 
					
					"value" => "#".$post->ID,
					"desc" => __("Micro Job ID","premiumpress"),		
					"show" => _ppt(array('design', "element_id")),
					"icon" => "fa fa-hashtag",
				),			
			*/
			/*
				5 => array( 
					
					"value" => $CORE->USER("get_name",$post->post_author),
					"desc" => __("Seller","premiumpress"),		
					"show" => _ppt(array('design', "element_user")),
					"icon" => "fa fa-user",
				),
				
				6 => array( 
					
					"value" => $CORE->USER("get_lastlogin",$post->post_author),
					"desc" => __("Last Online","premiumpress"),		
					"show" => _ppt(array('design', "element_user")),
					"icon" => "fa fa-lightbulb-on",
				),		
				*/						
			
						
			),
		
			"dl" => array(
			
			
			
				1 => array( 
					
					"value" => do_shortcode('[MILES]'),
					"desc" => __("miles","premiumpress"),		
					"show" => _ppt(array('design', "element_miles")),
					"icon" => "fa fa-tachometer-alt-fast",
				),
			
				2 => array( 
					
					"value" => do_shortcode('[YEAR]'),
					"desc" => __("Year","premiumpress"),		
					"show" => _ppt(array('design', "element_year")),
					"icon" => "fal fa-calendar-check",
				),
				
				3 => array( 
					
					"value" => do_shortcode('[TAX name="make"]'),
					"desc" => __("Make","premiumpress"),		
					"show" => _ppt(array('design', "element_make")),
					 
					"icon" => _ppt(array('taxicon', "make")), 
					"tax" => "make",
				),				 
			
				4 => array( 
					
					"value" => do_shortcode('[TAX name="model"]'),
					"desc" => __("Model","premiumpress"),		
					"show" => _ppt(array('design', "element_model")),
					"icon" => _ppt(array('taxicon', "make")), 
					 
					"tax" => "model",
				),
				
				5 => array( 
					
					"value" => do_shortcode('[TAX name="fuel"]'),
					"desc" => __("Fuel","premiumpress"),		
					"show" => _ppt(array('design', "element_fuel")),
					"icon" => _ppt(array('taxicon', "fuel")), 
					"tax" => "fuel",
				),
				
				6 => array( 
					
					"value" => do_shortcode('[TAX name="condition"]'),
					"desc" => __("Condition","premiumpress"),		
					"show" => _ppt(array('design', "element_condition")),					 
					"icon" => _ppt(array('taxicon', "condition")), 
					"tax" => "condition",
				),
				
				7 => array( 
					
					"value" => do_shortcode('[TAX name="body"]'),
					"desc" => __("Body","premiumpress"),		
					"show" => _ppt(array('design', "element_body")),
					 
					"icon" => _ppt(array('taxicon', "body")), 
					"tax" => "body",
				),
				
				8 => array( 
					
					"value" => do_shortcode('[TAX name="transmission"]'),
					"desc" => __("Transmission","premiumpress"),		
					"show" => _ppt(array('design', "element_transmission")),					 
					"icon" => _ppt(array('taxicon', "transmission")), 
					"tax" => "transmission",
				),
				
				
				9 => array( 
					
					"value" => do_shortcode('[TAX name="exterior"]'),
					"desc" => __("Exterior","premiumpress"),		
					"show" => _ppt(array('design', "element_exterior")),
					"icon" => _ppt(array('taxicon', "exterior")), 					 
					"tax" => "exterior",
				),
				
				10 => array( 
					
					"value" => do_shortcode('[TAX name="interior"]'),
					"desc" => __("Interior","premiumpress"),		
					"show" => _ppt(array('design', "element_interior")),
					"icon" => _ppt(array('taxicon', "interior")),
					"tax" => "interior",
				),
				
				11 => array( 
					
					"value" => do_shortcode('[TAX name="doors"]'),
					"desc" => __("Doors","premiumpress"),		
					"show" => _ppt(array('design', "element_doors")),
					"icon" => _ppt(array('taxicon', "doors")),
					 
					"tax" => "doors",
				),
				
				12 => array( 
					
					"value" => do_shortcode('[TAX name="engine"]'),
					"desc" => __("Engine","premiumpress"),		
					"show" => _ppt(array('design', "element_engine")),					 
					"icon" => _ppt(array('taxicon', "engine")),					
					"tax" => "engine",
				),
				
				13 => array( 
					
					"value" => do_shortcode('[TAX name="drive"]'),
					"desc" => __("Drive","premiumpress"),		
					"show" => _ppt(array('design', "element_drive")),					 
					"icon" => _ppt(array('taxicon', "drive")),
					"tax" => "drive",
				),
				
				14 => array( 
					
					"value" => do_shortcode('[TAX name="seller"]'),
					"desc" => __("Seller","premiumpress"),		
					"show" => _ppt(array('design', "element_seller")),
					 
					"icon" => _ppt(array('taxicon', "seller")),
					"tax" => "seller",
				),
				
				15 => array( 
					
					"value" => do_shortcode('[TAX name="owners"]'),
					"desc" => __("Owners","premiumpress"),		
					"show" => _ppt(array('design', "element_owners")),
					 
					"icon" => _ppt(array('taxicon', "owners")),
					"tax" => "owners",
				),
				
				
				
			
			
			),
		
		
			"dt" => array(
			
				1 => array( 
					
					"value" => do_shortcode('[CATEGORY]'),
					"desc" => __("Category","premiumpress"),		
					"show" => _ppt(array('design', "element_category")),
					"icon" => do_shortcode('[CATEGORYICON default="fal fa-home" codeonly="1"]'),
				),
				
				2 => array( 
					
					"value" => do_shortcode('[COUNTRY]')." ".do_shortcode('[CITY]'),
					"desc" => __("Location","premiumpress"),		
					"show" => _ppt(array('design', "element_location")),
					"icon" => "fal fa-map-marker",
				),
				
				
				3 => array( 
					
					"value" => do_shortcode('[OPENUNTIL]'),
					"desc" => __("Opening Hours","premiumpress"),		
					"show" => _ppt(array('design', "element_open")),
					"icon" => "fal fa-clock",
				),
			
			),
			
			
			
	
		
			"at" => array(
			
				1 => array( 
					
					"value" => do_shortcode('[REFUNDS]'),
					"desc" => __("Refunds","premiumpress"),		
					"show" => _ppt(array('design', "element_refunds")),
					"icon" => "fal fa-sync",
				),
				
				2 => array( 
					
					"value" => do_shortcode('[BIDS]'),
					"desc" => __("Bids","premiumpress"),		
					"show" => _ppt(array('design', "element_bids")),
					"icon" => "fal fa-hand-paper",
				), 
				
				3 => array( 
					
					"value" => do_shortcode('[CONDITION]'),
					"desc" => __("Condition","premiumpress"),		
					"show" => _ppt(array('design', "element_condition")),
					"icon" => _ppt(array('taxicon', "condition")), 
					//"tax" => "condition",
				), 	
				
				4 => array( 
					
					"value" => do_shortcode('[SHIPPING]'),
					"desc" => __("Shipping","premiumpress"),		
					"show" => _ppt(array('design', "element_shipping")),
					"icon" => "fal fa-ship",
				), 	
				
				5 => array( 
					
					"value" => '<a href="'.get_author_posts_url( $post->post_author ).'">'.$CORE->USER("get_name",$post->post_author).'</a>',
					"desc" => __("Seller","premiumpress"),		
					"show" => _ppt(array('design', "element_user")),
					"icon" => "fal fa-user",
				), 	
				
				6 => array( 
					
					"value" => do_shortcode('[RESERVE]'),
					"desc" => __("Reserve Price","premiumpress"),		
					"show" => _ppt(array('design', "element_reserve")),
					"icon" => "fal fa-coin",
				),
				
			),
			
			
		);
        
        
	  	// TURN OFF LOCATION
       if(_ppt(array("maps","enable")) != 1){
	   	unset($data["dt"][2]);
	   }
        
		
		 if(is_array(_ppt('listingtax')) && !empty(_ppt('listingtax')) ){
		  
			 foreach(_ppt('listingtax') as $customtax){ 
	 
				 	if(strlen($customtax) < 2 || $customtax == "features"){ continue; } 
					
					// STOP DEFAULT FIELDS
					if( in_array($customtax, array("dagender","dasexuality","dathnicity","daeyes","dahair","dabody","dasmoke","dadrink","features","condition", "make", "model", "condition", "body", "fuel", "transmission", "exterior", "interior", "doors", "seller", "engine", "drive","owners", "beds","baths", 'experience', 'jobtype')) ){
						continue;						
					}
					
				 
					$data[THEME_KEY][] = array( 
							
							"value" => $CORE->GEO("translation_tax_data", array($customtax, $post->ID)),
							"tax" => $customtax,
							"desc" =>  $CORE->GEO("translation_tax_key", $customtax),		
							"show" => 1,
							"icon" => _ppt(array('taxicon', $customtax)),
					);
				}
				
		}
		  
		 	
		
		?>
        <div class="ppt_shortcode_fields style-1">
        <div class="row">
		<?php 
		
		// ORDER AND SET VALUES
		$listingtax = _ppt('listingtax'); 
		
		$o = 20;
		$displayv = $data[THEME_KEY];
		foreach( $displayv as $k => $g){
			
			if(!isset($k['order'])){
				
				if(is_array($listingtax) && !empty($listingtax) && isset($g['tax']) && in_array($g['tax'], $listingtax) ){
					
					$cap = _ppt(array('taxcaption', $g['tax']));
					if($cap != $g['tax']){
					$displayv[$k]['desc'] =  $CORE->GEO("translation_tax_key", $g['tax']); 
					}
					$displayv[$k]['order'] = _ppt(array('taxorder', $g['tax']));
				
				}else{
				
					$displayv[$k]['order'] =  $o;
					$o++;
				
				}
				
			}
		}
		
		
		$order = array_column($displayv, 'order'); 
   		array_multisort( $order, SORT_ASC, $displayv);
		 
		
		foreach($displayv as $h){ 
		
		
		// SKIP NON-DISPLAY
		if(is_array($listingtax) && !empty($listingtax) && isset($h['tax']) && !in_array($h['tax'], $listingtax) ){
			 
			continue;
		
		}
		
		
		if($h['show'] == "" || $h['show'] == 1){ }else{ continue; }
		
		?> 
        
        
         <div class="col-xl-6">
                            
                             
                            <div class=" mb-3 fieldrow small fieldtype-0">
                                                                              
                                            <div class="title btn-block mb-3">
											
                                            <?php echo $h['desc']; ?>
                                            
                                            </div>  
                                            
                                            <div class="text">
                                            
											       <i class="text-primary mr-2 <?php if(strpos($h['icon'],"fab") === false){ echo "fal "; }else{ echo " "; } echo $h['icon']; ?>"></i>
                                                   
                                            <?php if($h['value'] == ""){ ?>            
            <span class="title text-muted opacity-5"><?php echo __("N/A","premiumpress"); ?></span>
            <?php }else{ ?>            
            <span class="title"><?php echo $h['value']; ?></span>
            <?php } ?>
                                            
                                            
                                            </div>   
                                          
                                                                          
                                    </div>
                                    
                            
                             
                             </div>
        
      
        <?php } ?>
        </div>
        </div>
        <?php
 		
}

 


function pptv9_shortcode_price( $atts = "", $content = null ) { global $post;

 	extract( shortcode_atts( array(  'pid' => '' ), $atts ) );
	
	if(isset($pid) && is_numeric($pid)){
	$thisid = $pid;
	}else{
	$thisid = $post->ID;
	}
	
	// GET LIST
	$LIST = get_post_meta($thisid,"price", true);
	
	if($LIST == 0){
	
	return __("Free","premiumpress");
	
	}elseif(is_numeric($LIST)){
		$amount = hook_price($LIST);
	}else{
		$amount = hook_price(100000);
	}
	
	return $amount;
		 
}

function pptv9_shortcode_offers( $atts = "", $content = null ) { global $post, $wpdb;

 	
	$SQL = "SELECT count(*) AS total FROM ".$wpdb->prefix."posts 
	INNER JOIN ".$wpdb->prefix."postmeta AS mt1 ON (".$wpdb->prefix."posts.ID = mt1.post_id AND mt1.meta_key = 'post_id' AND mt1.meta_value= '".$post->ID."') 
	WHERE 1=1 AND ".$wpdb->prefix."posts.post_status = 'publish' AND ".$wpdb->prefix."posts.post_type = 'ppt_offer' GROUP BY ID	";
	$result = $wpdb->get_results($SQL);	
					
	if(empty($result)){
		return 0;
	}
 				  		
	return $result[0]->total;
		 
}

function pptv9_shortcode_rating_user( $atts = "", $content = null ) { global $wpdb, $post, $CORE;

	extract( shortcode_atts( array( 'uid' => '', 'reviews' => 1 ), $atts ) );
	 
	 // GET THE ID OF THE STAR ITEM
		if(isset($uid) && is_numeric($uid) ){ 
			$thisID = $uid;
		}elseif(isset($post->post_author)){
			$thisID = $post->post_author;
		}else{
			return;
		} 
		
	$data = $CORE->USER("feedback_score", $thisID); 
	
	 
	$totalscore 	= $data['score'];
	$totalreviews 	= $data['votes'];	 
	
	$txt = " <span class='rating-symbol-total rating-score-".$totalscore."'>".number_format($totalscore,1)."</span>";
	if($reviews){
	$txt .= "<span class='rating-symbol-reviews'>(".number_format($totalreviews).")</span>";
 	}
	return '<input type="hidden" class="rating"  data-filled="fa fa-star rating-rated" data-empty="fal fa-star" readonly value="'.$totalscore.'"/>'.$txt;	 
 
}
function pptv9_shortcode_score( $atts = "", $content = null ) { global $wpdb, $post, $userdata;

	extract( shortcode_atts( array( 'size' => 'small', 'pid' => '', 'user_rating' => 0, 'total_r' => 0, 'total_s' => 0, 'score_link' => 0), $atts ) );
	
	
	if($total_r == 0 && defined('WLT_DEMOMODE') && user_can($post->post_author, 'administrator') && $post->comment_count == 0 ){
	 
		$totalreviews = 3;
		$totalscore = rand(40,50) / 10;
	
	}elseif($user_rating){
	
		$totalreviews = $total_r;
		$totalscore = $total_s;		 
	
	}else{
	
		// DEFAULTS
		$totalscore = 0;
		$totalreviews = 0;	 
		
		$args = array(
			'post_id' => $post->ID,
		);
		
		$ratingtotal = 0;
		$ratingcount = 0;	  
		 
		
					$comments = get_comments( $args );		 
					foreach ( $comments as $comment ) {		
					
							// DONT ADD POST AUTHOR COMMENTS
							if(get_comment_meta( $comment->comment_ID, 'feedback_for', true ) ==  $post->post_author){
							continue;
							}			
						
						$jj = get_comment_meta($comment->comment_ID, "ratingtotal", true);
						 
						if(is_numeric($jj)){
							$ratingtotal += $jj;
						}				
							 
						$ratingcount ++;
						
					}
					
						
					$totalreviews 		=  $ratingcount;
					if($ratingcount > 0){
					$totalscore 		= round(($ratingtotal/$ratingcount),2); 
					}else{
					$totalscore = 0;
					}
					
					// UPDATE STAR RATING			
					if(_ppt(array('search','filters_rating')) == "1"){
							update_post_meta($post->ID,'starrating', $totalscore);
					}
		 
	
	}
	
	
	
	 
	 
	// FALLBACK
	if($totalscore > 5){ $totalscore = 5; }
	
	// LABEL
	$txt = __("No Rating","premiumpress");
	if($totalscore > 0){
		switch(number_format($totalscore,0)){
			case "1": {
			$txt = __("Bad","premiumpress");
			} break;
			case "2": {
			$txt = __("Not Good","premiumpress");
			} break;
			case "3": {
			$txt = __("Good","premiumpress");
			} break;
			case "4": {
			$txt = __("Very Good","premiumpress");;
			} break;
			case "5": {
			$txt = __("Awesome","premiumpress");
			} break;
			default: {
				$txt = __("No Rating","premiumpress");
			} break;
		}
	}
	
 	// SIZE
	
	if($size == "text"){ 
	
	?>
    <?php if($totalscore == 0){ echo "-"; }else{ echo number_format($totalscore,1); } ?>
    <?php
	
	}elseif($size == "small"){
	?>
	
	<div class="rating-score-small">
    
    <?php if($score_link == 1){ ?>
     <span><?php echo $txt; ?><em><a href="javascript:void(0)" <?php if($userdata->ID){ ?>onclick="processCommentAll();"<?php }else{ ?>onclick="processLogin();"<?php } ?>><?php echo $totalreviews; ?> <?php echo __("Reviews","premiumpress"); ?></a></em></span>
    <?php }else{ ?>
    
     <span><?php echo $txt; ?><em><?php echo $totalreviews; ?> <?php echo __("Reviews","premiumpress"); ?></em></span>
    <?php } ?>
    
   
    <strong class="<?php if($totalscore == 0){ ?>bg-primary<?php }else{ echo "rating-color-".number_format($totalscore,0); } ?>"><?php if($totalscore == 0){ echo "-"; }else{ echo number_format($totalscore,1); } ?></strong>
    </div>
    
    <?php }elseif($size == "xs"){ ?>
	
	<div class="rating-score-small extrasmall">
   
    <strong class="<?php if($totalscore == 0){ ?>bg-primary<?php }else{ echo "rating-color-".number_format($totalscore,0);} ?>"><?php if($totalscore == 0){ echo "-"; }else{ echo number_format($totalscore,1); } ?></strong>
    </div>
	<?php }else{ ?>
	 
	<div class="rating-score-big">
	<span><?php if($totalscore == 0){ echo "-"; }else{ echo number_format($totalscore,1); } ?></span>
	<strong><?php echo $txt; ?></strong></div>    
	 
	<?php
	}
	
	}



	/* =============================================================================
		[TAX] - SHORTCODE
		========================================================================== */
function pptv9_shortcode_taxonomy( $atts, $content = null ) { global  $CORE, $post; 

	extract( shortcode_atts( array( 'name' => 'listing', 'pid' => $post->ID, 'default' => ''), $atts ) );		
 	
	// GET LIST
	$LIST = get_the_term_list( $pid, $name, "", ', ', '' );
	
	if(!is_string($LIST)){
	return;
	}
	 
	if(strlen($LIST) > 1){	
	return $LIST; //strip_tags();
	}else{
	return $default;
	}

}
	/* =============================================================================
		[AUTHORIMAGE] - SHORTCODE
		========================================================================== */
	function ppt_shortcode_author_image($atts, $content = null){ global $wpdb,  $wp_query, $CORE, $post;  
	
		extract( shortcode_atts( array( 'size' => '32', 'circle' => false), $atts ) );
		
		 
		if($circle){
		$img =  str_replace("avatar ","avatar img-circle ",str_replace('photo"','photo img-circle"',get_avatar($post->post_author, array($size, $size) )));
		}else{
		$img = str_replace('photo"','photo img-circle"',get_avatar($post->post_author, array($size, $size) ));
		}
		
		return $img;
		 
		
	}	

	/* =============================================================================
		[AUTHOR] - SHORTCODE
		========================================================================== */
	function ppt_shortcode_author($atts, $content = null){ global $wpdb,  $wp_query, $CORE, $post;  
	
		extract( shortcode_atts( array( 'link' => 1), $atts ) );
		
		
		if($link == 1){
		 return '<a href="'.get_author_posts_url( $post->post_author ).'">'.$CORE->USER("get_name", $post->post_author).'</a>';
		}
		
		return $CORE->USER("get_name", $post->post_author);
	}

/* =============================================================================
	[URL] - SHORTCODE
	========================================================================== */
function pptv9_shortcode_url($atts, $content = null){ global $wpdb,  $wp_query, $CORE, $post;  
		
	return home_url()."/";		
}
/* =============================================================================
	[ID] - SHORTCODE
	========================================================================== */
function pptv9_shortcode_postid($atts, $content = null){ global $wpdb,  $wp_query, $CORE, $post;  
	 	
	return $post->ID;		
}
	/* =============================================================================
		[TITLE] - SHORTCODE
		========================================================================== */
function pptv9_shortcode_title( $atts = "", $content = null ) { global $userdata, $CORE, $post; 
 	
	   	extract( shortcode_atts( array(  "link" => false, "striptags" => false, 'size' => 1 ), $atts ) );
	 
	  
		if(defined('WLT_DEMOMODE') && isset($GLOBALS['CORE_THEME']['sampledata']) && isset($post->post_title) && isset($post->post_type) && $post->post_type == "listing_type"  ){  
			
			$did = filter_var($post->post_title, FILTER_SANITIZE_NUMBER_INT);
			
			if(isset($GLOBALS['CORE_THEME']['sampledata'][$did]['title'])){
			
			return $GLOBALS['CORE_THEME']['sampledata'][$did]['title'];
			
			}
		
		} 
 
		if($CORE->_language_current(1) != "en_us"){
			
			$title = get_post_meta($post->ID,'post_title_'.$CORE->_language_current(1), true);
		
			if($title != ""){ $rTitle =  $title; }		
			$rTitle = $post->post_title;		
		
		}else{
			if(isset($post->post_title)){
			$rTitle = $post->post_title;
			}else{
			$rTitle = "";
			}
		} 
		
		// CLEAN STRING
		$rTitle =  esc_html(strip_tags($rTitle));		
		
		// LIMIT
		$title_css = "";
		if($size == 1 && strlen($rTitle) > 60 && $striptags == false){
			  
			$rTitle = '<span class="title-long">'.$rTitle.'</span>';
		}
		
		// OUTPUT		
		if($link){
		return "<a href='".get_permalink($post->ID)."'>".$rTitle."</a>";
		}
		
		return $rTitle;
}
/* =============================================================================
	 
	========================================================================== */


function pptv9_shortcode_excerpt($atts, $content = null){ global $wpdb, $wp_query, $CORE, $post;  
	
		extract( shortcode_atts( array( 'limit' => 100 ), $atts ) );
		
		$rd = "";
				
		 	 
		// elementor preview
		if( 
		( isset($_REQUEST['action']) && !in_array($_REQUEST['action'], array("contactform", "sendgift", "invitechat")) )
		
		|| isset($_REQUEST['preview_id']) || isset($_REQUEST['elementor_library']) ){
		
		$content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
		
		}else{
	 
			// GET CONTENT		
			if(strlen($post->post_excerpt) < 5 && THEME_KEY !="da" ){ 
			
				$content = $post->post_content;  
			 	
			}else{			
				$content = $post->post_excerpt;
			}
		}
		   
		
		// CLEAN
		$content = esc_html(strip_tags($content)); 	
		
		// LIMIT LENGTH
		$content =  mb_substr ($content, 0, $limit);				
		
		// STERILIZE FOR AJAX OUTPUT
		if(isset($GLOBALS['ajax_search'])){		  
		
				if(get_option('WPLANG') == "ja"){
		 
	 			$content = iconv("windows-1250","UTF-8", $content);
				 
				}else{
				
				$content = esc_html(strip_tags($content)); 
				
				}
				
		}		
				
		
		// CLEAN
		$content = preg_replace( "/\r|\n/", "",strip_tags(preg_replace('/\[gallery[^>]+\]/i', "", $content)));
		
		if($content == ""){
			$content = preg_replace( "/\r|\n/", "",strip_tags(preg_replace('/\[gallery[^>]+\]/i', "", $post->post_content)));
			
			$content =  mb_substr ($content, 0, $limit);
			
		}
		
		 
		
		if(defined('WLT_DEMOMODE') && in_array(THEME_KEY, array("es"))){
		
		$content = "offering a special price today, only for some hot sexy fun :)";	
		
		}elseif(defined('WLT_DEMOMODE') && in_array(THEME_KEY, array("da")) && user_can( $post->post_author , 'administrator') ){
		  
			 
			$da = array(
					"I am well-balanced and stable, but willing to let you knock me off my feet.",
					"I am someone who will kiss you in the rain.",
					"What I am is good enough.",
					"I am old fashioned sometimes. I still believe in romance, in roses, in holding hands.",
					"I don't smoke, drink or party every weekend. I don't play around or start drama to get attention. Yes, we do still exist!",
					"Nice guys finish last? Let's prove that wrong.",
					"I'm going to make the rest of my life the best of my life. Care to share it with me?",
					"I am strong, kind, smart, hilarious, sweet, lovable, and amazing. Isn't that what you've been looking for?",
					"I'm neither especially clever nor especially gifted, except for when it comes to being your perfect other half.",
					"I won't run away in the storms.",
					"I want to inspire and be inspired.",
					"I am here to find love and give love in return.",
					"I can guarantee you won't find anybody else like me.",
					"WiFi, food, my bed, snuggles. Perfection.",
					"I am strong enough to protect you and soft enough to melt your heart.",
					"If I could rate my personality, I'd say good looking!",
					"I find that having a dirty mind makes ordinary conversations much more interesting.",
					"I live my life without stress and worries.",
					"I am good looking (In certain lighting).",
					"I am not the one your mother warned you about.",
					"As long as you think I'm awesome, we will get along just fine.",
					"I am too positive to be doubtful, too optimistic to be fearful, and too determined to be defeated.",
					"Forget what hurt you in the past. It wasn't me. I'm like the opposite of that person!",
					"I'm not beautiful like you, but I'm beautiful like me!",
					"I am just one small person in this big world trying to find real love.",
					"I'm responsible, hard-working, faithful and a really, really good kisser.",
					"Once I've found my special someone, my life will be complete.",
					"Being both strong and soft is a combination I have mastered.",
					"I'm not here to be an average partner, I'm here to be an awesome partner.",
					"Don't let idiots ruin your day, date me instead!",
					"I'm a tidy person, with a few messy habits.",
					"I've learned to stop rushing things that need time to grow.",
					"I'm trusting, and I'll never try to tell you what you can and can't do.",
					"I'm loving, and I'll always look forward to seeing you at the end of each day.",
					"I appreciate the little things.",
					"I'm willing to work hard to make you happy in life."
				);	
				
				$rand_keys = array_rand($da, 2);
				$content = $da[$rand_keys[0]];	
		}
		
			 
		// ADD ON DASHES 
		if(!isset($GLOBALS['flag-single']) && strlen($content) > $limit){	
					$rd = "...";					
		}else{			
					$rd = "";			
		}	
		 
		return "<span class='shortcode_excerpt'>".$content.$rd."</span>";			
		 
			
}
/* =============================================================================
	 
	========================================================================== */


function pptv9_shortcode_content($atts, $content = null){ global $wpdb, $wp_query, $CORE, $post; $STRING = "";  
	
		extract( shortcode_atts( array( 'size' => 0, "pid" => "" ), $atts ) );
		
		 
		// GET THE POST ID
		if($pid != "" && is_numeric($pid)  ){
			$post = get_post($pid);
		}
		
		// elementor preview
		if( 
		( isset($_REQUEST['action']) && !in_array($_REQUEST['action'], array("contactform", "sendgift", "invitechat")) )
		
		|| isset($_REQUEST['preview_id']) || isset($_REQUEST['elementor_library']) ){
		
		$content = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.�Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p><p>Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.� luctus nec ullamcorper mattis, pulvinar dapibus leo. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>';
		
		}else{

		if($CORE->_language_current(1) != "en_us"){		
		
			$content = get_post_meta($post->ID, 'post_content_'.$CORE->_language_current(1), true);
			if($content == ""){
				$content = apply_filters( 'the_content', $post->post_content );
				$content = str_replace( ']]>', ']]&gt;', $content );
			}			
			
		}else{			 
			$content = apply_filters( 'the_content', $post->post_content );
			$content = str_replace( ']]>', ']]&gt;', $content );			 
		}		
		 
		 
		
	  } // end elementor
	  
	  
	  
	  	 
		if($size > 0){ 
			ob_start();
			?> 
            <div class="post_content_box"><?php echo $content; ?></div>
			<script>
				jQuery(document).ready(function() {
				 
				  jQuery('.post_content_box').expander({
					slicePoint: '<?php echo $size; ?>',   
					expandSpeed: 0,
					userCollapseText: '<?php echo __('read more','premiumpress'); ?>',
					expandText: '<?php echo __('read less','premiumpress'); ?>',
				  }); 
				 
				}); 
				</script>
		<?php
		return ob_get_clean(); 
		
		}else{
		
		return  wpautop($content);
		
		} 
	
	
		   
}


/* =============================================================================
		[TAGS] - SHORTCODE
		========================================================================== */
	function pptv9_shortcode_tags( $atts, $content = null ) {
	
		global $userdata, $CORE, $post, $shortcode_tags; $STRING = "";
		
		extract( shortcode_atts( array('text' => '', 'class' => 'my-3 mt-5'  ), $atts ) );
	
		// elementor preview
		if( ( isset($_REQUEST['action']) && !in_array($_REQUEST['action'], array("contactform", "sendgift", "invitechat")) )
		
		|| isset($_REQUEST['preview_id']) || isset($_REQUEST['elementor_library']) ){
		$STRING .= "<div class='pptv9_tags btn-group  ".$class."'>";
		$STRING .= "<a href='#' rel='tag' class='btn btn-sm btn btn-outline-dark border-0'>Tag 1</a>&nbsp;";
		$STRING .= "<a href='#' rel='tag' class='btn btn-sm btn btn-outline-dark border-0'>Tag 2</a>&nbsp;";
		$STRING .= "<a href='#' rel='tag' class='btn btn-sm btn btn-outline-dark border-0'>Tag 3</a>&nbsp;";
		$STRING .= "<a href='#' rel='tag' class='btn btn-sm btn btn-outline-dark border-0'>Tag 4</a>&nbsp;";
		$STRING .= "</div>";
		}else{	
		
			
			$t = wp_get_post_tags($post->ID);
		
			if(is_array($t) && !empty($t) ){
				$STRING .= "<div class='pptv9_tags btn-group ".$class."'>";
				foreach($t as $tag){				  
					$STRING .= "<a href='".get_term_link($tag->term_id, $tag->taxonomy)."' rel='tag' class='btn btn-sm btn btn-outline-dark'>".esc_attr($text)."".$tag->name."</a>&nbsp;";
				}
				$STRING .= "</div>";
			}
		}
		
		// RETURN
		return $STRING;
	}



/* =============================================================================
		[IMAGE] - SHORTCODE
	========================================================================== */
		 
	function pptv9_shortcode_image( $atts, $content = null ) {
	  
		global $userdata, $CORE,   $post;  $image = ""; $img = ""; $sd = ""; $linkextra = ""; if(!isset($GLOBALS['imagecount'])){ $GLOBALS['imagecount'] = 1; }else{ $GLOBALS['imagecount']++; }
		
		extract( shortcode_atts( array(		
			'pid' => '', 
			"pathonly" => false,
			'aclass' => 'ppt_image_link',
			'link' => 1, 	 
			"class" => "ppt_image img-fluid", 
			'limit' => 100,
			'size' => 'thumbnail',
			'showdata' => false,
			'fallback' => 1,
			'type' => "get_all_images",
			
			'w' => 0,
			'h' => 0,
			
		), $atts ) );
		
		   
		// CHECK FOR ELEMENTOR PREVIEW
		if( ( isset($_REQUEST['action']) && in_array($_REQUEST['action'], array("elementor", "elementor_ajax")) ) || isset($_REQUEST['preview_id']) || isset($_REQUEST['elementor_library'])  ){
		
			$image = '<img alt="no image" src="'.get_template_directory_uri()."/framework/images/nophoto.jpg".'" class="'.$class.'">';
			
			if($pathonly){		
				preg_match( '@src="([^"]+)"@' , $image , $match );
				if(isset($match[1]) && !empty($match[1]) && substr($match[1],0 , 4) == "http"){
					return $match[1];
				}		 
			}
		
			return $image;		
		}		
		
		// GET THE POST ID
		if(isset($post->ID) && $pid == "" ){
			$pid = $post->ID;
		}
		 
		
		// LOAD IN DATA
		$data =  $CORE->MEDIA($type, $pid, array("w" => $w, "h" => $h));
		 
		   
		$name = "";
		if(isset($data[0]['name'])){
		$name = $data[0]['name'];
		} 
		
	 
		
		// FALLBACK
		if(isset($data[0]['thumbnail']) && $data[0]['thumbnail'] == ""){	 
				$data[0]['thumbnail'] = $data[0]['src'];	
		}
		
		
		// NO FALLBACK
		if($fallback == 0 && isset($data[0]['thumbnail']) && strpos($data[0]['thumbnail'], "framework/images") !== false){
		return "";
		}
		 
		
		if(( isset($data[0]) || isset($data[1]) ) && $size == "thumbnail"){ 
		
			// GET IMAGE DIMENTIONS
			if($showdata){
				
				if(isset($data[0]['width'])){
					$width = $data[0]['width'];
					$height = $data[0]['height'];
				}else{
					//list($width, $height, $type, $attr) = @getimagesize($data[0]['thumbnail']);
					$width =  420;
					$height = 200;					
				}
			 
				$sd = ' data-width="'.$width.'" data-height="'.$height.'"';
	 		}
			
			$keyh = 0;
			if(!isset($data[0]['thumbnail'])){
			$keyh = 1;
			}
			$image = '<img src="'.$data[$keyh]['thumbnail'].'" alt="'.$name.'" data-src="'.$data[$keyh]['thumbnail'].'" class="'.$class.'" '.$sd.'>';
		
		
		
			
		}elseif(isset($data[0])){
			
			// GET IMAGE DIMENTIONS
			if($showdata){
		
		
				if(isset($data[0]['width'])){
					$width = $data[0]['width'];
					$height = $data[0]['height'];
				}else{
					//list($width, $height, $type, $attr) = @getimagesize($data[0]['thumbnail']);
					$width =  800;
					$height = 600;					
				}
			 
				$sd = ' data-width="'.$width.'" data-height="'.$height.'"';
		
	 		}
			
			$image = '<img data-src="'.$data[0]['src'].'" alt="'.$name.'" data-src="'.$data[0]['thumbnail'].'" class="lazy '.$class.'" '.$sd.'>';
		
		}else{
				
			$data = $this->media_get($pid,"video");
			if(isset($data[0])){			
			
			$image = '<img data-src="'.$data[0]['thumbnail'].'" alt="'.$name.'" data-src="'.$data[0]['thumbnail'].'" class="lazy '.$class.'" '.$sd.'>';
			
			}elseif($fallback == 1){
			 
			$image = '<img alt="no image" data-src="'.$this->_FALLBACK($pid, get_the_title($pid)).'" class="lazy '.$class.'">';
			
			} 
			
		}
		
		
		if($link){
			$permalink = get_permalink($pid); 
			$image = '<a href="'.$permalink.'" class="'.$aclass.''.$linkextra.'">'.$image.'</a>';
		}
		
		
	
		
		if($pathonly){		
			preg_match( '@src="([^"]+)"@' , $image , $match );
			if(isset($match[1]) && !empty($match[1]) && substr($match[1],0 , 4) == "http"){
				return $match[1];
			}
			
			if($fallback == 1){
					return $this->_FALLBACK($pid, get_the_title($pid));
			}else{			
				return "";
			}
			 
			 
		 
		}
		
		return $image;
		
		
	}


/* =============================================================================
		[IMAGES] - SHORTCODE
	========================================================================== */

function pptv9_shortcode_images($atts, $content = null){  global $userdata, $CORE, $settings, $post;


	 // removed and set for single only
	 
	 // widget-single-images	
}
/* =============================================================================
		[GALLERY] - SHORTCODE
	========================================================================== */

function pptv9_shortcode_gallery($atts, $content = null){  global $userdata, $CORE, $settings, $post;

		// EXTRACT OPTIONS
		extract( shortcode_atts( array( 'postid' => '', 'limit' => 100, 'style' => 1), $atts ) );
 		
		// FIX FOR PRINT PAGE IMAGES
		if($postid != ""){ $pid = $postid; }else{ $pid = $post->ID; }
		
		// 1. GET MEDIA
		if( ( isset($_REQUEST['action']) && !in_array($_REQUEST['action'], array("contactform", "sendgift", "invitechat","load_user_video","load_video_form")) )
		
		|| isset($_REQUEST['preview_id']) || isset($_REQUEST['elementor_library']) ){
			$i = 1;
			while($i < 10){
			$files[$i] = array(
			"name" => "Example Image",
			"thumbnail" => FRAMREWORK_URI.'elementor/img/item-'.$i.'.png',
			"src" => FRAMREWORK_URI.'elementor/img/item-'.$i.'.png',
			"ID" => 1,
			);
			$i++; }
		
		}else{
		$files = $this->media_get($pid, "images"); 
	 	if(!is_array($files)){ $files = array(); }
		}
		
		// LOAD GALLERY
		$settings['images'] = $files;
		
		// GET FILE
		_ppt_template('framework/elementor/shortcodes/image-gallery');		
}


 /* =============================================================================
	 [VIDEO-VIMEO] - SHORTCODE
	========================================================================== */
	// YOUTUBE AND VIDEO DISPLAY
	function pptv9_shortcode_video_vimeo($atts, $content = null){ global $post;
	 
		// EXTRACT OPTIONS
		extract( shortcode_atts( array('height' => '640', 'width' => '1100', 'post_id' => $post->ID, 'image' => "", "autoplay" => "off"), $atts ) );
 		
		if( ( isset($_REQUEST['action']) && !in_array($_REQUEST['action'], array("contactform", "sendgift", "invitechat","load_user_video","load_video_form")) )
		
		|| isset($_REQUEST['preview_id']) || isset($_REQUEST['elementor_library']) ){
		
			$videlink = "https://www.youtube.com/watch?v=-az0qZtuL_A&origin=".home_url();
			$image = "https://www.premiumpress.com/wp-content/themes/PREMIUMPRESS3/template/web2019/img/image-youtube.png";
		
		}else{
		 
		 	 
			$videid = get_post_meta($post_id,'vimeo_id',true);
			if($videid != ""){			
				$videlink = "https://player.vimeo.com/video/".$videid;	
			}  
			
			// GIVE UP!
			if($videlink == ""){			
				return 0;
			}		
			
		 
		}
		 
		
  
	$CONTENT = "";
	if(strlen($videlink) > 1){
		// BUILD COMMENT BLOCK
		ob_start();
		
		try { ?><div id="videoplayer" style="max-height:470px; overflow:hidden;">
        <?php $e1 = _ppt(array('lst', 'videoautoplay')); if($e1 == "" || $e1 == 1){  ?>
        <?php echo do_shortcode('[video src="'.$videlink.'"  autoplay="on"  width="'.$width.'" height="'.$height.'" poster="'.$image.'"][/video]'); ?> 
        <?php }else{ ?>
        <?php echo do_shortcode('[video src="'.$videlink.'"   width="'.$width.'" height="'.$height.'" poster="'.$image.'"][/video]'); ?> 
        <?php } ?>
                    
		</div><?php
		
		}catch (Exception $e) {
			ob_end_clean();
			throw $e;
		}  
		$CONTENT  = ob_get_clean();	
	}
	return $CONTENT;
	}
	
	
/* =============================================================================
	 [VIDEO-YOUTUBE] - SHORTCODE
	========================================================================== */
	// YOUTUBE AND VIDEO DISPLAY
	function pptv9_shortcode_video_youtube($atts, $content = null){ global $post;
	 
		// EXTRACT OPTIONS
		extract( shortcode_atts( array('height' => '480', 'width' => '600', 'post_id' => $post->ID, 'image' => "", "autoplay" => "off"), $atts ) );
		
		$videlink  = "";	
		 
 		 
		if( ( isset($_REQUEST['action']) && !in_array($_REQUEST['action'], array("contactform", "sendgift", "invitechat","load_user_video","load_video_form")) )
		
		|| isset($_REQUEST['preview_id']) || isset($_REQUEST['elementor_library']) ){
		
			$videlink = "https://www.youtube.com/watch?v=-az0qZtuL_A";
			$image = "https://www.premiumpress.com/wp-content/themes/PREMIUMPRESS3/template/web2019/img/image-youtube.png";
		
		}else{
		 
		 	 
			$videid = get_post_meta($post_id,'youtube_id',true);
			if($videid != ""){			
				$videlink = "https://www.youtube.com/watch?v=".$videid;	
			} 
			
			 
			
			// TRY VIMEO ??
			if($videlink == ""){
			
				$videid = get_post_meta($post_id,'vimeo_id',true);
				if($videid != ""){			
					$videlink = $videlink = "https://player.vimeo.com/video/".$videid;
				} 
   
    		}
			 
			
			// GIVE UP!
			if($videlink == ""){			
				return "";
			}		
			
		 
		}
		 
  
	$CONTENT = "";
	if(strlen($videlink) > 1){
		// BUILD COMMENT BLOCK
		ob_start();
		
		try { ?><div id="videoplayer" class="youtubelpayer">
        
        <?php $e1 = _ppt(array('lst', 'videoautoplay')); if($e1 == "" || $e1 == 1){  ?>
        <?php  echo do_shortcode('[video src="'.$videlink.'"  autoplay="on"  width="'.$width.'" height="'.$height.'" poster="'.$image.'"][/video]'); ?>
        <?php }else{ ?>
        <?php  echo do_shortcode('[video src="'.$videlink.'"  width="'.$width.'" height="'.$height.'" poster="'.$image.'"][/video]'); ?>
        <?php } ?>
		    
		</div><?php
		
		}catch (Exception $e) {
			ob_end_clean();
			throw $e;
		}  
		$CONTENT  = ob_get_clean();	
	}
	return $CONTENT;
	}

/* =============================================================================
	 [VIDEO] - SHORTCODE
	========================================================================== */

	// YOUTUBE AND VIDEO DISPLAY
	function pptv9_shortcode_video($atts, $content = null){ global $post;
	 
		// EXTRACT OPTIONS
		extract( shortcode_atts( array('height' => '440', 'width' => '1100', 'post_id' => $post->ID, 'image' => "", "autoplay" => "off"), $atts ) );
 		
		if( ( isset($_REQUEST['action']) && !in_array($_REQUEST['action'], array("contactform", "sendgift", "invitechat","load_user_video")) )
		
		|| isset($_REQUEST['preview_id']) || isset($_REQUEST['elementor_library']) ){
		
			$videlink = "https://www.youtube.com/watch?v=-az0qZtuL_A";
			$image = get_template_directory_uri()."/framework/images/novideo.jpg";
		
		}else{
		
		
		 	$files = $this->MEDIA("get_all_videos", $post->ID);
							   	 
	 		if(!is_array($files)){
			
				return 0;
			
			}	
			
			// DEAULTS
			$videlink = "";
			 
			
			if(isset($files[0]['src']) && in_array($files[0]['type'], $this->allowed_video_types)  ){
				
				$videlink 	= wp_get_attachment_url( $files[0]['id'] );
				$image 		= $files[0]['thumbnail'];					 
			}	
		 
		}
		
		// AUTO PLAY		
		 
		
		// NO POSTER
		if(strpos($image, "novideo") !== false){
		$image = "";
		}
		 
	
	$CONTENT = "";
	if(strlen($videlink) > 1){
		// BUILD COMMENT BLOCK
		ob_start();
		try { 
		?><div id="videoplayer" class="standardvideos">
        <?php $e1 = _ppt(array('lst', 'videoautoplay')); if($e1 == "" || $e1 == 1){  ?>
        <?php  echo do_shortcode('[video src="'.$videlink.'"  autoplay="on"  width="'.$width.'" height="'.$height.'" poster="'.$image.'" ][/video]'); ?>   
       <?php }else{ ?>
		<?php  echo do_shortcode('[video src="'.$videlink.'" width="'.$width.'" height="'.$height.'" poster="'.$image.'" ][/video]'); ?>   
        <?php } ?>
         
		</div><?php
		
		}catch (Exception $e) {
			ob_end_clean();
			throw $e;
		}  
		$CONTENT  = ob_get_clean();	
	}
	return $CONTENT;
	}


/* =============================================================================
	 
	========================================================================== */


function pptv9_shortcode_cats( $atts, $content = null ){ global $post, $CORE;
	
	extract( shortcode_atts( array( 'limit' => 1, 'pid' => '', 'seperator' => ',', 'type' => THEME_TAXONOMY, 'link' => 1, 'class' => '' ), $atts ) );	
		
	$string = ""; $lc = 0;
	
	if($pid != "" && is_numeric($pid)){
		$POSTID = $pid;
	}else{
		if(isset($post->ID)){
		$POSTID = $post->ID;
		}else{
		$POSTID = 0;
	} 
	
	//$categories = get_the_terms( $POSTID, $type, array( 'order' => 'term_order') );
	
	$categories = wp_get_post_terms( $POSTID, "listing", array( 'orderby' => 'count', 'order' =>'desc' ) );
	 
	if(empty($categories)){
	return __("No Category","premiumpress");
	} 
	
	if(is_array($categories)){
	foreach($categories as $cat){
	
	if(!isset($cat->term_id)){ continue; }
	
		//if($limit == 1 && $cat->parent != 0){ continue; }
	 
		// CHECK FOR CATEGORY TRANSLATIONS
		$catTrans = _ppt('category_translation');		
		$lang = $CORE->_language_current(1);
		
		// DEFAULT 
		$cat_name = $cat->name;
		
		// CHECK FOR TRANSLATION
		if($catTrans != "" && $lang != "en_us"){ 
		 
			if(isset($catTrans[$lang]) && isset($catTrans[$lang][$cat->term_id]) ){			
				$cat_name = $catTrans[$lang][$cat->term_id];			
			}
				
		} 
		
		if($lc == $limit){ continue; }	
		$lc++;
		
		if($link == 1){
			$string .= "<a href='".get_term_link($cat->term_id)."' class='".$class."'>".$cat_name."</a>";
		}else{
			$string .= $cat_name;
		}
		
		if($limit > 1){
			$string .= $seperator." ";
		}
				
	}
	}
	
	}
	 
  
	if($limit > 1){
		return substr($string,0,-2);
	}else{
		return $string;
	}
	
		 
	}
	/* =============================================================================
		[CATEGORYICON] - SHORTCODE
		========================================================================== */

	function pptv9_shortcode_categoryicon($atts, $content = null){ global $post;
	
		extract( shortcode_atts( array('default' => "fa-tag", "class" => "",  "tooltip" => 1, "codeonly" => 0), $atts ) );
	
		$terms = wp_get_post_terms( $post->ID, "listing" );		 
		 
		if(isset($terms[0]->term_id) && isset($GLOBALS['CORE_THEME']['category_icon_small_'.$terms[0]->term_id]) && $GLOBALS['CORE_THEME']['category_icon_small_'.$terms[0]->term_id] != ""){
		
			$icon =  $GLOBALS['CORE_THEME']['category_icon_small_'.$terms[0]->term_id];
			
			if(strlen($icon) > 2){ 
			$default = $icon;
			}
		
		}
		
		if($codeonly){
		return $default;
		}		 
		
		return "<i class='fal ".$default." ".$class."'></i>";
	
	}
	/* =============================================================================
		[CATEGORYIMAGE] - SHORTCODE
		========================================================================== */

 function pptv9_shortcode_categoryimage( $atts = "", $content = null ) { global $userdata, $CORE, $wpdb, $post; $img = "";  
 	
	   	extract( shortcode_atts( array(  'term_id' => '', 'tax' => 'listing', 'pathonly' => 0, 'link' => 0), $atts ) );
		
		// TERMS
		$terms = get_term_by('term_id', $term_id, $tax);
		
		if(empty($terms)){
			$term_list = wp_get_post_terms( $post->ID, $tax, array( 'fields' => 'ids' ) );
			
			if(isset($term_list[0])){
			 
			$terms = get_term_by('term_id', $term_list[0], $tax);
			
			} 
		}

		
		 
			if(isset($terms)){			 
		 		
				// GET BIG IMAGE
		 		if( strlen(_ppt('storeimage_'.$terms->term_id)) > 1 ){
				
					$merchant_logo = _ppt('storeimage_'.$terms->term_id);
					
					$l = get_term_link($terms, 'store');
					
					$img = "<a href='".$l."'><img src='".str_replace("&","&amp;",$merchant_logo)."' alt='".$terms->slug."' class='img-fluid' /></a>";
		
				}elseif( strlen(_ppt('category_image_'.$terms->term_id)) > 1 ){
				
					$merchant_logo = _ppt('category_image_'.$terms->term_id);
					
					$l = get_term_link($terms, 'store');
					
					$img = "<a href='".$l."'><img src='".str_replace("&","&amp;",$merchant_logo)."' alt='".$terms->slug."' class='img-fluid' /></a>";
		
				}elseif(isset($terms->term_id) && _ppt('category_icon_'.$terms->term_id) != ""){
					
					$img = "<img src='"._ppt('category_icon_'.$terms->term_id)."' alt='".$terms->slug."' class='img-fluid' />";
				
				}
				  
			
				if(strlen($img) > 1){	
			 
					if($pathonly){		
						preg_match( '@src="([^"]+)"@' , $img , $match );					 
						if(isset($match[1]) && !empty($match[1]) && substr($match[1],0 , 4) == "http"){
							return $match[1];
						}					
						preg_match( "@src='([^']+)'@" , $img , $match );					 
						if(isset($match[1]) && !empty($match[1]) && substr($match[1],0 , 4) == "http"){
							return $match[1];
						}					
					}
								
					if($link == 1){
						return $img;
					}else{
						return  preg_replace('/<a.*?(<img.*?>)<\/a>/', '$1', $img);
					}					
				}
				 
			
			}
			
	
}

	/* =============================================================================
		[COMMENTS] - SHORTCODE
		========================================================================== */
	function pptv9_shortcode_comments($atts, $content = null){ global $userdata, $CORE, $post; $STRING = "";  $comment_string = ""; 
	
		// EXTRACT OPTIONS
		extract( shortcode_atts( array( 'pid' => '', 'style' => 1), $atts ) );
		
		if(is_numeric($pid)){
		$post = get_post($pid);
		}
		
		
		$GLOBALS['comment-style'] = $style;
		
		if( ( isset($_REQUEST['action']) && !in_array($_REQUEST['action'], array("contactform", "sendgift", "invitechat")) )
		
		|| isset($_REQUEST['preview_id']) || isset($_REQUEST['elementor_library']) ){
		
			
		
		}else{		
		
			// CHECK IF WE'VE ENABLED COMMENTS
			 
			
			//if($post->post_status == "pending"){ return; }
			
			//if($post->comment_status != "open"){ return; }
			   
			// BUILD COMMENT BLOCK
			ob_start();
				try {
				 
				comments_template();  // GET THE DEFAULT WORDPRESS TEMPLATE FOR COMMENTS
				
				}
				catch (Exception $e) {
					ob_end_clean();
					throw $e;
			}  
			$comment_form = ob_get_clean();
			$STRING = $comment_form;		 
			
			return $STRING;
		
		}
	}

 
/* =============================================================================
	 
	========================================================================== */





function pptv9_shortcode_amenities( $atts = "", $content = null ) { global $userdata, $CORE, $wpdb, $post;   
 	
	extract( shortcode_atts( array(  'xxxxxxxx' => ''), $atts ) );
	
	if( ( isset($_REQUEST['action']) && !in_array($_REQUEST['action'], array("contactform", "sendgift", "invitechat")) )
		
		|| isset($_REQUEST['preview_id']) || isset($_REQUEST['elementor_library']) ){
	
		?>    
		<div class="amenities"><ul class="list-unstyled row">
				 <?php             
				$dtamenitites = get_option("dtamenitites"); 
				if(is_array($dtamenitites)){ $i=0; $setKeys = array(); $selectedcatlist = array();
				foreach($dtamenitites['name'] as $data){ ?>
			  
		 
				<li class="col-md-6"><?php echo $dtamenitites['name'][$i]; ?></li>
				 
				 
				<?php $i++;  }} ?>
				</ul>    
		</div>
		<?php
	}else{
		
		if(_ppt('amenities') == 0){ return; }
	 
		$uam = get_post_meta($post->ID, 'amenities', true);
		 
		if(is_array($uam)){
		?>    
		<div class="amenities"><ul class="list-unstyled row">
				 <?php             
				$dtamenitites = get_option("dtamenitites"); 
				if(is_array($dtamenitites)){ $i=0; $setKeys = array(); $selectedcatlist = array();
				foreach($dtamenitites['name'] as $data){ if($dtamenitites['name'][$i] != "" ){  ?>
			  
				<?php if(is_array($uam) && in_array($dtamenitites['key'][$i], $uam)){ ?>
				<li class="col-md-6"><?php echo $dtamenitites['name'][$i]; ?></li>
				<?php } ?>
				 
				<?php $i++; } }} ?>
				</ul>    
		</div>
		<?php
		}
	}
}

/* =============================================================================
	 
	========================================================================== */















 
	/* =============================================================================
	[MEMBERSHIP] - SHORTCODE
	========================================================================== */
	function ppt_membership_filter($atts, $content = null){  global $userdata, $CORE, $post;
		
		extract( shortcode_atts( array('show' => '' ), $atts ) );	
	
	
		// MAKE SURE ITS ENABLED	  
		if(_ppt(array('mem','enable')) != 1 || is_admin() ){ return $content; }
		
		// DEFAULTS
		$allowed_ids 		= explode(",",$atts['show']);
		
		// IF EMPTY, RETURN CONTENT
		if(empty($allowed_ids)){
			return $content;
		}
		
		// GET USER MEMBERSHIP
		$user_membership_id = 0;
		$mymem = $CORE->USER("get_user_membership", $userdata->ID);
	 
		if( isset($mymem['expired']) && $mymem['expired'] == 1 ){								
				// EXPIRED									
		}else{
		
			$user_membership_id = $mymem['key'];
		}
	 
		
		// GET ALL MEMBERSHIPS
		$status = array(); $psks = "";
		$all_memberships = $CORE->USER("get_memberships", array());
		foreach($all_memberships  as $key => $m){							
			$status[$m['key']] = $m['name'];							
		}		
		foreach($status as $key => $club){
		
				if(in_array($key, array("","subs")) ){ continue; } 
				if(in_array($key, $allowed_ids) || in_array("mem".$key, $allowed_ids) ){ 
					$psks .= "<span class='badge badge-dark'>".$club."</span> "; 
				}
       	} 
		
		$canShow = false;
		// CAN SHOW?
		if(in_array($user_membership_id, $allowed_ids)  || in_array("mem".$user_membership_id, $allowed_ids) ){
			
			$canShow = true;
		
		}
				  
		
		if($canShow){
			
			$displaytext = $content;
		
		}else{
		
			$displaytext = _ppt(array('mem','listingaccessmsg'));	
			
			if($displaytext == ""){
			
			ob_start(); ?>
			<div class="card card-body card-upgrade-mem">
			   <div class="row">
               
                   <div class="col-md-6">
                   
                    <div class=""><?php echo str_replace("%s",$psks, __("%s members only.","premiumpress")); ?></div>
                   
                   </div>
                   <div class="col-md-6 text-md-right">
                   
                   <a href="javascript:void(0)"  <?php if(!$userdata->ID){ ?> onclick="processLogin();" <?php }else{ ?>onclick="processUpgrade();"<?php } ?>  class="btn btn-system"><?php echo __("Upgrade Now","premiumpress") ?></a>
                   
                   </div>
               
               </div>
               </div>
				<?php
				
				$displaytext = ob_get_clean();	 
			
				 
			}
			
			 
		}
		
	 
		if(isset($_GET['preview_id'])){
		echo $displaytext;	
		}else{
		return $displaytext;	
		} 
		
	}

 
function ppt_shortcode_hits( $atts = "", $content = null ) { global $userdata, $CORE, $wpdb, $post; $STRING = "";  
 	
	   	extract( shortcode_atts( array(  'pid' => ''), $atts ) );
		
		if($pid != "" && is_numeric($pid)){
		$POSTID = $pid;
		}else{
		$POSTID = $post->ID;
		}
		
		return $CORE->PACKAGE("get_hits", array($POSTID,"all") );
	
}


function ppt_shortcode_mainmenu( $atts = "", $content = null ) { global $userdata, $CORE, $wpdb, $post; $STRING = "";  
 	
	   	extract( shortcode_atts( array(  'hasadd' => 0, 'class' => 'nav sf-menu', 'cclass' => "", "topnav" => false, "footer" => false, "mobile" => false, "menu_name" => "" ), $atts ) );
	 	
		// REMOVES UNWANTED LINKS FOR DEMO PURPOSES
		$hasadd = 0;
		if(isset($atts['hasadd'])){
		$hasadd = $atts['hasadd'];	
		}
		
		
		// SIMPLE MENU FOR DEMO PREVIEWS
		$simplemenu = false;
		if(defined('WLT_DEMOMODE') && isset($_SESSION['design_preview']) ){
		
	 		$g = $CORE->LAYOUT("load_single_design", $_SESSION['design_preview']);			
			if(isset($g['menu-simple'])){
			
				$simplemenu = true;
			}		
		
		}
		
		if(defined('THEME_KEY') && THEME_KEY == "ph" ){
			$simplemenu = true;
		}
		
		// CURRENT LANG
		$cll = "en_US";
		if(_ppt(array('lang','switch')) == "1"){
		$cll = $CORE->_language_current(); 
		}
		 
	 	
		/// DIRECT MENU CALL
		if($menu_name != ""){
		
			if($menu_name == "none"){ return ""; }
		
			$menu_name_default =  $menu_name;
			$menu_name =  $menu_name;			
				 
	 		$nav_menu = wp_get_nav_menu_object($menu_name);		
			 
			$args = array( 
						
						'container' 		=> false,
						'container_class' 	=> false,
						'theme_location' 	=> $menu_name,
						'menu' 				=> $nav_menu->term_id,
						'menu_class' 		=> $class,
						'fallback_cb'    	=> '',
						'echo'           	=> false,
						'depth'           => 2,
						'walker' 			=> new WP_Bootstrap_Navwalker(),
						'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
						 						
			);					
		  
			$STRING = wp_nav_menu( $args );  // end menu
			
			return $STRING;
			 
		}elseif($footer){ // FOOTER NAV
		
			$menu_name_default =  'footermenu_en_US';
			$menu_name = 'footermenu_'.$cll;
		
		}elseif($topnav){	// TOP NAV
		
			$menu_name_default =  'topmenu_en_US';
			$menu_name = 'topmenu_'.$cll;
		
		}elseif($mobile){	// SIDEBAR MOBILE NAV
		
			$menu_name_default =  'mobile_en_US';
			$menu_name = 'mobilemenu_'.$cll;
		
		}else{	// MAIN NAV
		
			$menu_name_default =  'mainmenu_en_US';
			$menu_name =  'mainmenu_'.$cll;
		} 
		 
	   
		// GET MENUS
		$locations = get_nav_menu_locations();
		 
		 
		// FALLBACK TO DEFAULT IF NO MENU ADDED
		if ( ( $locations ) && isset( $locations[ $menu_name ] ) && $locations[ $menu_name ] != 0 ) {		
		}else{
		$menu_name = $menu_name_default;	 
		} 
		 
		// CHECK EXISTS AND THEN OUTPUT
        if ( ( $locations ) && isset( $locations[ $menu_name ] ) && $locations[ $menu_name ] != 0 ) {
		 
	 
	 		$nav_menu = wp_get_nav_menu_object($locations[$menu_name]);			
			 
			$args = array( 
						
						'container' 		=> false,
						'container_class' 	=> false,
						'theme_location' 	=> $menu_name,
						'menu' 				=> $nav_menu->term_id,
						'menu_class' 		=> $class,
						'fallback_cb'    	=> '',
						'echo'           	=> false,
						'depth'           => 2,
						'walker' 			=> new WP_Bootstrap_Navwalker(),
						'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
						 						
			);					
		  
			$STRING = wp_nav_menu( $args );  // end menu
		
		
		}elseif($footer){
		
		ob_start(); ?>
         
         <ul class="links-vertical list-unstyled" style="line-height:35px;">
                            
                                <li><a class="opacity-8" href="<?php echo _ppt(array('links','blog')); ?>"> <?php echo __("Blog","premiumpress"); ?></a></li>
                                <li><a class="opacity-8" href="<?php echo _ppt(array('links','aboutus')); ?>"><?php echo __("About Us","premiumpress"); ?></a></li>
                                <li><a class="opacity-8" href="<?php echo _ppt(array('links','how')); ?>"><?php echo __("How it works","premiumpress"); ?></a></li>
                                <li><a class="opacity-8" href="<?php echo _ppt(array('links','faq')); ?>"><?php echo __("FAQ","premiumpress"); ?></a></li>
                            </ul>
        <?php
		
        return ob_get_clean();	 

		}elseif($topnav){
		
		ob_start(); ?>
		
        <ul class="list-inline seperator mb-0">
        <li class="list-inline-item"><a href="<?php echo home_url(); ?>/?reset=1"><?php echo __("Home","premiumpress"); ?></a></li>        
          
        <li class="list-inline-item"><a href="<?php echo _ppt(array('links','how')); ?>"><?php echo __("How it works","premiumpress"); ?></a></li>  
              
        <li class="list-inline-item"><a href="<?php echo _ppt(array('links','aboutus')); ?>"><?php echo __("About Us","premiumpress"); ?></a></li>
        
        
        <?php if(defined('THEME_KEY') && THEME_KEY == "cp"){ ?>
        <li class="list-inline-item"><a href="<?php echo _ppt(array('links','stores')); ?>"><?php echo __("Stores","premiumpress"); ?></a></li>
         <?php } ?>
                                         
		</ul>         
         
		<?php
		return ob_get_clean();
		
		}else{
		ob_start(); ?>
		<ul class="<?php echo $class; ?>">
           <li class="nav-item">
              <a href="<?php echo home_url(); ?>/?reset=1" class="nav-link"><?php echo __("Home","premiumpress"); ?></a>
             
           </li>
           
           
        <?php if(!$simplemenu && defined('WLT_DEMOMODE') ){ ?>   
           <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        
        <span class="badge badge-danger" style="position: absolute;    top: -5px;    right: 0px;">5 <?php echo __("styles","premiumpress"); ?></span>
          <?php echo __("Search Page","premiumpress"); ?>
        </a>
        <div class="dropdown-menu" >
        
         
        <?php
		
		$snames = array(
		
		1 => "Style 1",
		2 => "Style 2",
		
		3 => "Style 3",
		4 => "Style 4",
		
		5 => "Style 5 <i class='fa mt-1 fa-star text-warning float-right'></i>",
		6 => "Style 6",	
	 	
		);
		
		
		 $i=1; while($i < 7){ ?>
         
         <a class="dropdown-item" href="<?php echo home_url(); ?>/?s=&amp;style=<?php echo $i; ?>"><?php echo $snames[$i]; ?></a>
         
         <?php $i++; } ?>
         
          
         
         <?php if( $CORE->LAYOUT('captions','maps') && _ppt(array('maps','enable')) == 1 ){ ?>
         
         <a class="dropdown-item" href="<?php echo home_url(); ?>/?s=&amp;style=7">Style 7 + Map</a>
         <?php } ?>
        
         
        </div>
      </li>
      <?php }else{ ?>
        <li class="nav-item">
              <a href="<?php echo home_url(); ?>/?s=" class="nav-link"><?php echo __("Search","premiumpress"); ?></a>
             
           </li>
      <?php } ?> 
      
      
      
      <?php if(!$simplemenu && defined('WLT_DEMOMODE') && defined('THEME_KEY') &&  in_array(THEME_KEY, array("cm","sp","at","dl","ct","dt","da","rt","mj","es","vt","jb")) ){
	  
	  
	  		$SQL = "SELECT ID FROM ".$wpdb->posts." WHERE post_type ='listing_type' and post_status = 'publish' ORDER BY rand() LIMIT 1 ";				 			 
			$result = $wpdb->get_results($SQL);
			$postID = $result[0]->ID;	 
	   ?> 
      
           <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        
        <span class="badge badge-danger" style="position: absolute;    top: -5px;    right: 0px;">3 <?php echo __("styles","premiumpress"); ?></span>
          <?php echo  str_replace("%s", $CORE->LAYOUT("captions","1"), __("%s Page","premiumpress")); ?>
        </a>
        <div class="dropdown-menu" >
        
         
        <?php
		
		$snames = array(
		
		1 => "Style 1",
		2 => "Style 2",
		3 => "Style 3", 
	 	
		);
		
		
		 $i=1; while($i < 4){ ?>
         
         <a class="dropdown-item" href="<?php echo get_permalink($postID); ?>/?style=<?php echo $i; ?>"><?php echo $snames[$i]; ?></a>
         
         <?php $i++; } ?>
          
        
         
        </div>
      </li>
      <?php }else{ ?>
      
       <li class="nav-item"><a href="<?php echo _ppt(array('links','contact')); ?>" class="nav-link"><?php echo __("Contact","premiumpress"); ?></a></li>
      <?php } ?>     
           
          
           
         <?php if(defined('THEME_KEY') &&  THEME_KEY == "cp"){ ?>
        <li class="nav-item"><a href="<?php echo _ppt(array('links','stores')); ?>" class="nav-link"><?php echo __("Stores","premiumpress"); ?></a></li>
         <?php } ?>
          
       <li class="nav-item"><a href="<?php echo _ppt(array('links','blog')); ?>" class="nav-link"><?php echo __("Blog","premiumpress"); ?></a></li>
        
        <?php if(!$simplemenu){ ?>   
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         
         <?php if(defined('WLT_DEMOMODE')){ ?>
         <span class="badge badge-danger" style="position: absolute;    top: -5px;    right: 0px;">10+ <?php echo __("pages","premiumpress"); ?></span>
         <?php } ?>
         
		 <?php echo __("Extra Pages","premiumpress"); ?>
        </a>
        
        
        <div class="dropdown-menu">
       
       
         <?php if(defined('THEME_KEY') &&  THEME_KEY == "da"){ ?>
       <a href="<?php echo _ppt(array('links','chatroom')); ?>" class="dropdown-item"><?php echo __("Chatroom","premiumpress"); ?></a>
         <?php } ?>
           
       
          <a href="<?php echo _ppt(array('links','myaccount')); ?>" class="dropdown-item"><i class="fal fa-users mr-2"></i> <?php echo __("My Account","premiumpress"); ?></a>
       
        <?php if(defined('THEME_KEY') && THEME_KEY == "sp"){ ?>
         <a href="<?php echo _ppt(array('links','cart')); ?>" class="dropdown-item"><i class="fal fa-shopping-basket mr-2"></i> <?php echo __("My Basket","premiumpress"); ?></a>  
        <?php } ?>
       
        <?php if(defined('THEME_KEY') && THEME_KEY != "sp"){ ?>
          <a href="<?php echo _ppt(array('links','add')); ?>" class="dropdown-item"><i class="fal <?php echo $CORE->LAYOUT("captions","icon"); ?> mr-2"></i> <?php echo str_replace("%s", $CORE->LAYOUT("captions","1"),__("Add %s","premiumpress")); ?></a>          
       	<?php } ?>
        
          <?php if( $CORE->LAYOUT("captions","memberships") ){?>
          <a href="<?php echo _ppt(array('links','memberships')); ?>" class="dropdown-item"><i class="fal fa-badge mr-2"></i> <?php echo __("Memberships","premiumpress"); ?></a>          
       	<?php } ?>
       
       
        <a href="<?php echo _ppt(array('links','contact')); ?>" class="dropdown-item"><i class="fal fa-envelope mr-2"></i> <?php echo __("Contact","premiumpress"); ?></a>
        
       
        <a href="<?php echo _ppt(array('links','sellspace')); ?>" class="dropdown-item"><i class="fal fa-bullhorn mr-2"></i><?php echo __("Advertising","premiumpress"); ?></a>
        
        <a href="<?php echo _ppt(array('links','testimonials')); ?>" class="dropdown-item"><i class="fal fa-comments-alt mr-2"></i><?php echo __("Testimonials","premiumpress"); ?></a>
        
        <a href="<?php echo _ppt(array('links','aboutus')); ?>" class="dropdown-item"><i class="fal fa-smile mr-2"></i> <?php echo __("About Us","premiumpress"); ?></a>
        
        <a href="<?php echo _ppt(array('links','how')); ?>"  class="dropdown-item"><i class="fal fa-cube mr-2"></i> <?php echo __("How it works","premiumpress"); ?></a>
        
        <a href="<?php echo _ppt(array('links','privacy')); ?>" class="dropdown-item"><i class="fal fa-quote-left mr-2"></i> <?php echo __("Privacy","premiumpress"); ?></a>
        
        <a href="<?php echo _ppt(array('links','terms')); ?>" class="dropdown-item"><i class="fal fa-heading mr-2"></i> <?php echo __("Terms","premiumpress"); ?></a>
        
        <a href="<?php echo _ppt(array('links','faq')); ?>" class="dropdown-item"><i class="fal fa-info mr-2"></i> <?php echo __("FAQ","premiumpress"); ?></a>
       
       
       
       </div>
       
      
      </li>
      <?php } ?>
      
      
      
           
       
           
           
        </ul>
		<?php
		return ob_get_clean();
		}
		 	
	return $STRING;

}



 
	/* =============================================================================
		[RATING] - SHORTCODE
		========================================================================== */
	function ppt_shortcode_rating( $atts = "", $content = null ) {
	
		global $wpdb, $userdata, $CORE, $post, $shortcode_tags; $STRING = "";  $default_options = 'all';
	 	
		
		
		extract( shortcode_atts( 
		array('size' => '24', 
		'id' => '', 
		'style' =>'', 
		'results' => false,   
		'readonly' => false, 
		'class' => '', 
		'submit' => false, 
		'score' => 0,		
		'only_score' => 0,
		'only_votes' => 0		
		), $atts ) );
		$size = esc_attr($size);
		$id = esc_attr($id);

		$style = esc_attr($style);
		$results = esc_attr($results);
 
 		$readonly = esc_attr($readonly); 
 
		// GET THE ID OF THE STAR ITEM
		if(isset($id) && is_numeric($id) ){ 
			$thisID = $id;
		}elseif(isset($post->ID)){
			$thisID = $post->ID;
		}else{
			return;
		} 
 		
			
		// GET THE RATING DATA
		$ratingT = get_post_meta($thisID, 'starrating_total', true);
		if($ratingT == ""){ $ratingT =0; }
		$ratingV = get_post_meta($thisID, 'starrating_votes', true);
		if($ratingV == ""){ $ratingV = 0; }			
		$rating = get_post_meta($thisID, 'starrating', true);		 
 
		if($rating == ""){ $rating = "0"; } 
		
		// RETURN VOTES
		if($only_votes ==1){
		return $ratingT;
		}
		
		// RETURN SCORE
		if($only_score == 1 || $score == 1){
		return round($rating,1);
		}
		
		$readonly = "data-readonly";
		if($submit){			
			$readonly = "";
			$rating = 5;
		}
		
		$txt= "";
		if($results == 1){
		$txt = " <span class='resultbit' data-toggle='tooltip' data-placement='top' title='".round($rating,1)." ".__( 'stars with', 'premiumpress' )." ".$ratingV." ".__( 'votes', 'premiumpress' )."'>
		
		<span class='badge badge-pill badge-secondary ml-2'>".round($rating,1)."</span></span>"; //".$ratingV."
		
		}
		
		
		$STRING .= '<input type="hidden" class="rating"  data-filled="fa fa-star rating-rated '.$class.'" data-empty="fa fa-star'.$class.'"  '.$readonly.' value="'.$rating.'"/>'.$txt;	 
			 
		return $STRING;
		
	}
	
	
	
	/* =============================================================================
		[FIELDS] - SHORTCODE
		========================================================================== */	
	function ppt_shortcode_fields( $atts, $content = null ) {
	
		global $userdata, $CORE, $post; $STRING = ""; 
	
	   	extract( shortcode_atts( array( 'style' => '', 'postid' => '' ), $atts ) );
		
		
		  
		if(is_numeric($postid) && strlen($postid) > 0){ $THISPOSTID = $postid; }else{ $THISPOSTID = $post->ID; }
		
		// STYLE
		//$style = _ppt(array('lst','fieldslayout'));
		if(!is_numeric($style)){ $style = 0; }
		
	  	
			// GET CATEGORY FOR THIS LISTING
			$incats = wp_get_post_terms( $THISPOSTID, "listing" );
			$incatsarray = array();
			if(is_array($incats)){
				foreach($incats as $cad){
					$incatsarray[$cad->term_id] = $cad->term_id;
				}
			}
			 	
			// GET FIELDS
			$regfields = get_option("cfields"); 			
			 
			// START COUNTER
			$i=0;
			
			// CHECK HAS VALUES
			if(is_array($regfields) && isset($regfields['dbkey']) ){ 
			
			 
				// LOOP
				foreach($regfields['dbkey'] as $field){					 
				   
				
				if(isset($regfields['editonly'][$i]) && $regfields['editonly'][$i] == "yes"){  $i++; continue; }
						 
				// CHECK IF THIS IS A HIDDEN FIELD
				if(!isset($regfields['dbkey'][$i]) || (isset($regfields['dbkey'][$i]) && $regfields['dbkey'][$i] == "")  ){ $i++; continue; }					
				
				
				
				// CHECK THIS FIELD IS FOR THIS CATEGORY				 
				$canShow = false;				 
				if(isset($regfields['cat']) && isset($regfields['cat'][$i]) &&  is_array($regfields['cat'][$i]) && empty($regfields['cat'][$i])){
				
					$canShow = true;
					
				}elseif(isset($regfields['cat']) && isset($regfields['cat'][$i]) && is_array($regfields['cat'][$i]) && !empty($regfields['cat'][$i]) ){
				
					foreach($regfields['cat'][$i] as $fc){						
						if(in_array($fc, $incatsarray)){						
							$canShow = true;
						}
					}	
								
				}else{				 
				
					$canShow = true;
				}
				 	 
				// SHOW ALL CATS
				if(!isset($regfields['cat'][$i][0]) || isset($regfields['cat'][$i][0]) && ( $regfields['cat'][$i][0] == "" || $regfields['cat'][$i][0] == "0" )){
				$canShow = true;
				}
						 		
				if(!$canShow){ $i++; continue; }	
				
				 
				if(THEME_KEY == "dt" && !isset($GLOBALS['global_design3']) && in_array($regfields['dbkey'][$i], array("website","url","phone"))){
				//$i++; 
				//continue;
				}
				 	 
					 
				// CHECK IF IS HEADLINE
				if($regfields['fieldtype'][$i] == "title"){ 						
						
						
						$titlecss = "mt-4 mb-4";
						
						if(!isset($titlecount)){
							$titlecount = 1;
							$titlecss = "mb-4";						
						}
						
						if($style == 2){ 						
						
						$STRING .="<div class='col-12 ' style='border-top:25px solid #f8f9fa;  margin-left:-10px;padding-right:0px;     max-width: 120% !important;    margin-right: -10px;    flex: 0 0 120% !important;'></div><div class='col-12'><h6 class=' text-primary ".$titlecss."'>".$CORE->GEO("translate_field_name", array( stripslashes($regfields['name'][$i]), $i, $regfields))."</h6><hr></div>";
						
						}else{
						
						$STRING .="<div class='col-12'><h6 class='".$titlecss."'>".$CORE->GEO("translate_field_name", array( stripslashes($regfields['name'][$i]), $i, $regfields))."</h6></div>";
						
						}
						
						$i++; 
						continue;
				}
				
			
						  
					 		  
						// CHECK FOR YOUTUBE LINK
						if($regfields['fieldtype'][$i] == "taxonomy"){	
										
							$my_categories = get_the_terms( $THISPOSTID, $regfields['taxonomy'][$i] );
													  
							$value = "";
							if ( is_array( $my_categories ) ) {
								foreach ( $my_categories as $my_category ) {
									  
									$value .= $CORE->GEO("translation_tax", array($my_category->term_id, $my_category->name));
									
									if(count($my_categories) > 1){
									
									$value .= ", ";
									
									
									}
								}
							}
							
							
						}else{
						
							$v_check = get_post_meta($THISPOSTID, $regfields['dbkey'][$i], true);						 
							// CHECK IF ITS BLANK
							if($v_check == ""){ $i++; continue; }
								
							// CHECK FOR EMAIL							
							if(!is_array($v_check) && strpos($v_check,"@") !== false){								
								$v_check = "<a href='mailto:".$v_check."' rel='nofollow' style='text-decoration:underline;'>".$v_check."</a>";								
							
							// IF LINKS MAKE OUTBOUND
							}elseif(!is_array($v_check) && substr($v_check,0,4) == "http"){	
							
									if(get_option('permalink_structure') == ""){
									$link = $v_check;								
									}else{
									//$link = get_home_url()."/out/".$THISPOSTID."/".$regfields['dbkey'][$i]."/";
									$link = $v_check;
									}
									
									$icon = "<i class='fal fa-link mr-2 text-primary'></i>";
									$text = __("Visit Website","premiumpress");
									
									if(strpos($v_check, "facebook") !== false){
									$icon = "<i class='fab fa-facebook mr-2 text-primary'></i>";
									$text = __("Visit Facebook","premiumpress");									
									}
									
									if(strpos($v_check, "instagram") !== false){
									$icon = "<i class='fab fa-instagram mr-2 text-primary'></i>";
									$text = __("Visit Instagram","premiumpress");									
									}
									 
									if(strpos($v_check, "skype.com") !== false){
									$icon = "<i class='fab fa-skype mr-2 text-primary'></i>";
									$text = __("Skype Chat","premiumpress");									
									}
									
									if(strpos($v_check, "youtube") !== false){
									$icon = "<i class='fab fa-youtube mr-2 text-primary'></i>";
									$text = __("Visit YouTube","premiumpress");									
									}
									
									if(strpos($v_check, "twitter.com") !== false){
									$icon = "<i class='fab fa-twitter mr-2 text-primary'></i>";
									$text = __("Visit Twitter","premiumpress");									
									}
								 
									
									
									$v_check = "<a href='".$link."' class='btn btn-sm btn-system shadow-sm' rel='nofollow' target='_blank'>".$icon.$text."</a>";													
							
							
							
							// CHECK BOX DISPLAY						 						
							}elseif(is_array($v_check)){
								$nstring = "";						 					 				 									
								foreach($v_check as $vk=>$vd){
									if(!is_array($vd) && $vd != "" && $vd != "--" && $vd !="Array"){
									 
									$nstring .= "".$vd.", ";
									}
								}
								$nstring = substr($nstring,0,-2);
								$v_check = $nstring;						
							}
							if($regfields['dbkey'][$i] == "price"){						 
							$v_check = hook_price($v_check);						
							}
							
							//if($regfields['dbkey'][$i] == "phone" || $regfields['dbkey'][$i] == "phonenumber"){						 
							//$v_check = "<a href='tel:".$v_check."'>".$v_check."</a>";						
							//}
							
							if($regfields['fieldtype'][$i] == "textarea"){	
							$v_check = wpautop($v_check);
							}
							
							// INTEGRATION FOR COUPONS
							if( isset($GLOBALS['CORE_THEME']['coupon']['code_key']) && $GLOBALS['CORE_THEME']['coupon']['code_key'] == $regfields['dbkey'][$i]  ){
								$v_check = '[CBUTTON]';
							}
							if($regfields['dbkey'][$i] == "expires" || $regfields['dbkey'][$i] == "expiry_date"){						 
							$v_check = $this->date_timediff( $v_check );						
							}
							if($regfields['dbkey'][$i] == "start_date"){						 
							$v_check = $this->format_date( $v_check );						
							}
							
														
							$value = $v_check;
						}
						$values = "";
						
						 
						// DONT SHOW BLANK FIELDS
						if($value == ""){ $i++; continue; }
						
						if(is_array($value)){ 
						
							foreach($value as $val){			
								if(is_object($val)){
								$values .= " <a href='".get_term_link($val->slug, $regfields['taxonomy'][$i]). "'>".$val->name."</a>";
								}if(!is_array($val) && !is_object($val) && strlen($val) > 2){ $values .= " ".$val; 
								}elseif(is_array($val)){ 
									foreach($val as $val1){ 						 
										$values .= " ".$val1; 						 
									} // end foreach
								} // end if
							} // end foreach
						
						}else{ $values = $value; }	
							
							
							
							 
							if(!is_object($values)){ 
							
								// ADD ON DATE FORMAT
								if($regfields['fieldtype'][$i] == "date"){ $values = hook_date($values); }
								
								
									
				if($regfields['fieldtype'][$i] == "select"){ 
				
				
				 $values = trim(stripslashes(str_replace("_"," ",str_replace("::",",", str_replace(";;","'", $values)))));
				
				
				}
								
								 
								 ob_start();
							?>
                            <?php if($regfields['name'][$i] != "" && strlen($regfields['name'][$i]) > 1){ 
							
							
							 
							
							
							?>
                            <div class="col-6 col-md-3">
                            
                             
                            <div class="mb-3 d-flex d-md-block small fieldtype-<?php echo $regfields['fieldtype'][$i]; ?>">
                                                                              
                                            <div style="color:#444444;" class="mb-1 mr-2 m-md-0"><?php echo $CORE->GEO("translate_field_name", array( stripslashes($regfields['name'][$i]), $i, $regfields)); ?>:</div>  
                                            
                                            <div class="text-black font-weight-bold"><?php echo $values; ?></div>   
                                          
                                                                          
                                    </div>
                                    
                            
                             
                             </div>
                             <?php } ?> 
                           <?php
						   
						   		$STRING .= ob_get_clean(); 
						   
							}
							
							// NEXT FIELD
							$i++;
						} 
		} 
 		
		if($STRING  == ""){ return; } 
		
		
		$STRING  = "<div class='ppt_shortcode_fields row style-".$style."'>". $STRING. "</div>";
		
		// RETURN CODE
		return do_shortcode($STRING); 
	  
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function ppt_shortcode_location($atts, $content = null){  global $userdata, $CORE, $post; $STRING = ""; 
		
		extract( shortcode_atts( array(), $atts ) );
 
		if(get_post_meta($post->ID,'map-location',true) != ""){			  
			$STRING 	= get_post_meta($post->ID,'map-location',true);		 
		}	
		
		return $STRING;

	}
	
 
	
 	/* =============================================================================
	[CITY] - SHORTCODE
	========================================================================== */
	function ppt_shortcode_city($atts, $content = null){  global $userdata, $CORE, $post; $STRING = ""; 
		
		extract( shortcode_atts( array('link' => ''  ), $atts ) );
		
		if(_ppt(array('maps','enable')) == 0){ return ""; }
		 
		$city = get_post_meta($post->ID,'map-city',true);
		if($city == ""){			
			return "";
		}
		
		if($link == 1){
		
		return '<a href="'.home_url().'/?s=&city='.get_post_meta($post->ID,'map-city', true).'">'.$city.'</a>';
		
		}
		 
		return $city;
		
	}
	
 	/* =============================================================================
	[COUNTRY] - SHORTCODE
	========================================================================== */
	function ppt_shortcode_country($atts, $content = null){  global $userdata, $CORE, $post; $STRING = ""; 
		
		extract( shortcode_atts( array('link' => ''  ), $atts ) );
		
		if(_ppt(array('maps','enable')) == 0){ return ""; }
		 
		$country = get_post_meta($post->ID,'map-country',true);
		if($country == ""){		
			return "";
		}
		
		if(isset($GLOBALS['core_country_list'][$country])){
			$STRING = $GLOBALS['core_country_list'][$country];
		}else{
			$STRING = $country;
		}
		
		if($link == 1){
		
		$STRING = "<a href='".home_url()."/?s=&country=".$country."'>".$STRING."</a>";		
		
		}
		
		return $STRING;
		
	}
	
	/* =============================================================================
		[SUBSCRIBE] - SHORTCODE
		========================================================================== */
	function pptv9_shortcode_subscribe( $atts, $content = null){ global $userdata, $CORE, $post; $STRING = ""; 
	
		// EXTRACT OPTIONS
		extract( shortcode_atts(  array( 'text' => false, 'icon' => true, 'icon_name' => "fa-user-circle", 'class' => "", "uid" => "", "count" => false  ), $atts ) );
		
		
		if($uid == "" && is_object($post) && isset($post->post_author)){
		$uid = $post->post_author;
		}
		
		$text_add = __("Add Friends","premiumpress");
		$text_remove =  __("Remove Friends","premiumpress") ;
		
		$extn = "_list";
		$type = "subscribe";
		$userid =  $uid;
		 
		if($userdata->ID){
		
			if(defined('WP_ALLOW_MULTISITE')){
					$extn .= get_current_blog_id();
			}						 
			$my_list = get_user_meta($userdata->ID, $type.$extn, true);
			 
			if(is_array($my_list) && in_array($userid, $my_list)  ){
				
				$i = "fa fa-times";	
				$t = __("Unfriend","premiumpress");	
					
			}else{	 
					
					$i = "fal ".$icon_name;
					$t = __("Add Friends","premiumpress");
					
					if($count){
					$t .= " (".$CORE->USER("get_subscribers_count", $userid).")";
					}
			} 
			 
			
			ob_start();
			?>
			<button data-uid="<?php echo $uid; ?>" class="subscribe_add <?php echo $class; ?>" data-text="1" data-icon="<?php echo $icon; ?>" data-textremove="<?php echo $text_remove; ?>" data-textadd="<?php echo $text_add; ?>">
			<?php if($icon){ ?> <i class="<?php echo $i; ?>"></i>  <?php } ?>
			<?php if($text){  echo $t; } ?>
			</button>
			<?php
			$STRING = ob_get_clean(); 
			return $STRING;	
		
		}else{
		
			$i = "fa ".$icon_name;
			$t = __("Subscribe","premiumpress");		
			$ThisLink = site_url('wp-login.php?action=login&redirect_to='.get_permalink($post->ID), 'login_post');
			
			ob_start();
			?>
			<a href="<?php echo $ThisLink; ?>" class="subscribe_add <?php echo $class; ?>">
			<?php if($icon){ ?> <i class="<?php echo $i; ?>"></i>  <?php } ?>
			<?php if($text){  echo $t;  } ?>
			</a>
			<?php
			$STRING = ob_get_clean(); 
			return $STRING;	
		
		}					
				 
	}	
	
	/* =============================================================================
		[FAVS] - SHORTCODE
		========================================================================== */
	function pptv9_shortcode_favs( $atts, $content = null){ global $userdata, $CORE, $post; $STRING = ""; 
	
		// EXTRACT OPTIONS
		extract( shortcode_atts(  array( 'text' => false, 'icon' => true, 'icon_name' => "fa-heart", 'class' => "" ), $atts ) );
		 
		
		// SETUP
		$extn = "_list";
		$type = "favorite";
		$postid =  $post->ID;
		if($userdata->ID){
		
			if(defined('WP_ALLOW_MULTISITE')){
					$extn .= get_current_blog_id();
			}						 
			$my_list = get_user_meta($userdata->ID, $type.$extn, true);
			
			$text_add = __("Add Favorites","premiumpress");
			$text_remove =  __("Remove Favorites","premiumpress") ;
			
			 
			if(is_array($my_list) && in_array($postid, $my_list)  ){
				
				$i = "fa fa-times-square";	
				$t = $text_remove;	
					
			}else{						
				$i = "fa ".$icon_name;
				$t = $text_add;
			} 
			 
			
			ob_start();
			?>
			<button data-text="<?php echo $text; ?>" data-textremove="<?php echo $text_remove; ?>" data-icon="<?php echo $icon; ?>" data-textadd="<?php echo $text_add; ?>" data-pid="<?php echo $post->ID; ?>" class="favs_add <?php echo $class; ?>">
			<?php if($icon){ ?> <i class="<?php echo $i; ?>"></i>  <?php } ?>
			<?php if($text){  echo $t; } ?>
			</button>
			<?php
			$STRING = ob_get_clean(); 
			return $STRING;	
		
		}else{
		
			$i = "fa ".$icon_name;
			$t = __("Add Favorites","premiumpress");		
			 
			
			ob_start();
			?>
			<a href="javascript:void(0);" onclick="processLogin();" class="favs_add <?php echo $class; ?>">
			<?php if($icon){ ?> <i class="<?php echo $i; ?>"></i>  <?php } ?>
			<?php if($text){  echo $t;  } ?>
			</a>
			<?php
			$STRING = ob_get_clean(); 
			return $STRING;	
		
		}					
				 
	}	
 

	
	
	
	/* =============================================================================
		[GOOGLEMAP] - SHORTCODE
		========================================================================== */
	function ppt_google_maps_display($atts, $content = null){  global $wpdb, $post, $CORE; 
	
	extract( shortcode_atts( array('tab' => false, 'init' => true, 'text_before' => '', 'text_after' => '', 'color' => '', 'zoom' => '', 'streetview' => false), $atts ) ); 
	 
	 
		// GET MAP DATA
		$long 			= get_post_meta($post->ID,'map-log',true);	
		$lat 			= get_post_meta($post->ID,'map-lat',true);				
		$location 		= get_post_meta($post->ID,'map-location',true);				
		
		if($long == "" || $lat == ""){
		$lat = "-34.397";
		$long = "150.644";
		$location = "";
		}
	 
		ob_start();
		
	?> 
    <div id="map" style="height:100%"></div>
    <script>
      var map;
	  
	  
	  <?php if(_ppt(array("maps","provider")) == "mapbox"){ ?>

 
/* MOBILE MENU	*/
  
jQuery(document).ready(function(){ 

	mapboxgl.accessToken = '<?php echo _ppt(array('maps','apikey')); ?>';
	var map = new mapboxgl.Map({
	container: 'map',
	style: 'mapbox://styles/mapbox/streets-v11',
	center: [<?php echo $long; ?>, <?php echo $lat; ?>],
	zoom: 16
	});
	
	
	
	map.on('load', function () {
	
		map.loadImage(
			 '<?php echo  get_template_directory_uri(); ?>/framework/images/marker.png',
			function (error, image) {
			if (error) throw error;
			map.addImage('cat', image);
			map.addSource('point', {
			'type': 'geojson',
			'data': {
			'type': 'FeatureCollection',
				'features': [
					{
					'type': 'Feature',
					'geometry': {
					'type': 'Point',
					'coordinates': [<?php echo $long; ?>, <?php echo $lat; ?>]
					}
				}
			]
			}
		});
	
		map.addLayer({
			'id': 'points',
			'type': 'symbol',
			'source': 'point',
			'layout': {
			'icon-image': 'cat',
			'icon-size': 1
			}
		});
		
	jQuery(".card-header").click(function(e) {
      e.preventDefault();
      map.resize();
    });	
	
		
		
	
	}
	);
	});
	
	map.resize();

});


 
	  <?php }else{ 
	  
	  
$snip = str_replace('.', '', $location); // remove dots
$snip = str_replace(' ', '', $snip); // remove spaces
$snip = str_replace("\t", '', $snip); // remove tabs
$snip = str_replace("\n", '', $snip); // remove new lines
$snip = str_replace("\r", '', $snip); // remove carriage returns
$location =  $snip;
	  
	  ?> 
      function initMap() {
      
		var myLatLng = {lat: <?php echo $lat; ?>, lng: <?php echo $long; ?>};

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: myLatLng,
		  mapTypeControl: false,
		  streetViewControl: false
        });

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: "<?php echo trim(str_replace('"',"'",str_replace("\r", '',$location))); ?>"
        }); 
		
      }
	  
	  <?php } ?>
    </script>
    
    
<?php if(_ppt(array("maps","provider")) == "mapbox"){ ?>
 
  <script src="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js"></script>
<?php }else{ ?>
  <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo _ppt(array('maps','apikey')); ?>&callback=initMap" async defer></script>
<?php } ?>

	<?php
	
	$STRING = ob_get_clean(); 
	
	 
	return $STRING;
 
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	 
	function ppt_shortcode_dcats($atts, $content = null){ global $wpdb, $CORE; $STRING = "";  
	
		extract( shortcode_atts( array( 'show_count' => '', 'title' => '', 'limit' => 20, 'div' => '.ppt_shortcode_dcats', 'class' => 'default' ), $atts ) ); 
		 	 
 
		$categories = wp_list_categories( array(
        'taxonomy'  	=> 'listing',
		'depth'         => 5,	
		'hierarchical'  => true,		
		'hide_empty'    => 0,
		'echo'			=> false,
        'title_li' 		=> '',
		 'orderby' 		=> 'term_order',
		 'walker'		=> new walker_shortcode_dcats,
		'limit' 		=> 500,
    	) ); 
	
		?>
   		
        <button class="hidden-sm-up navbar-toggler" type="button" data-toggle="collapse" data-target="#ppt_shortcode_dcats" aria-controls="header_menu" aria-expanded="false" >
            &#9776; <?php echo __("Categories","premiumpress"); ?>
        </button>
        <div class="navbar-toggleable-xs clearfix" id="ppt_shortcode_dcats">
         	 
        
            <div class=" ppt_shortcode_dcats <?php echo $class; ?> clearfix">
            
                <ul class="m-b-0 sf-menu sf-vertical">
                <?php echo $categories; ?>
                </ul>
            
            </div>
        	
            <div class="clearfix"></div>
            
        </div>
        
 
     <script>jQuery(document).ready(function(){ 
		 
		$counter = 1;
		jQuery("<?php echo $div; ?> li.cat-parent").each(function(){
			if($counter > <?php echo $limit; ?>)
			{
				this.remove();
			}
			$counter++;
		});
		
		}); 
		
		</script> 
 

      <?php 
		
		// RETURN
		return $STRING;		 
	
	}
	
	
	


	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	 
 

	
	
	function ppt_shortcode_likes( $atts, $content = null ){ global $post;
	
		extract( shortcode_atts( array(  "today" => false, "postid" => "" ), $atts ) );	
		
		if($postid != "" && is_numeric($postid) ){ $PID = $postid; }else{ $PID = $post->ID; }
    
	
		$rating_up 	= get_post_meta($PID, 'ratingup', true);
		if(is_numeric($rating_up)){
		return $rating_up; 	
		}else{
		return 0;
		}
		
		
	}
	

	
	function ppt_shortcode_screenshot( $atts, $content = null ){ global $post;
	
		extract( shortcode_atts( array( 'url' => "https://premiumpress.com", "class" => "img-fluid border p-1", "alt" => "screenshot", "pathonly" => false ), $atts ) );	
	
	 
		return "";
	}
	
 
	function shortcodelist(){
	
	return hook_shortcodelist(array());
	
	}
 
	

	 
	/* =============================================================================
	[DISTANCE] - SHORTCODE
	========================================================================== */
	function ppt_distance($atts, $content = null){  global $userdata, $CORE, $post, $wp_query;	
	 
		extract( shortcode_atts( array('show' => false, 'postid' => '', 'icon' => '', 'text_before' => '', 'text_after' => ''.__("away","premiumpress").'', "type" => "text" ), $atts ) );
  	 
	 	// CHECKS
		if(!isset($GLOBALS['ajax_search'])){ return; }		
		if(_ppt(array('maps','enable')) != 1  ){ return; } // 
		if(_ppt(array('search','filters_distance')) == 0 ){ return; }	
		if(!is_numeric($GLOBALS['distance_value'])){ return; }
		  
	 	$miles =  floor($GLOBALS['distance_value']);
		 	
		 
		// QUICK DISPLAY
		if(!is_numeric($miles)){
		$miles = 100;
		} 
		
		// GET THE UNIT
		$unit = strtoupper(_ppt(array('search','mapmetric')));			
		if ($unit == "1") {			 
			
			$rt = number_format(($miles * 1.609344)) ." ".__("KM","premiumpress");	
			
			if($miles < 1){		
			$rt = __("Less than 1 KM","premiumpress");		
			}	
			
		} else {
		   $rt = number_format($miles) ." ".__("miles","premiumpress");
		   if($miles < 1){		
			$rt = __("Less than 1 mile.","premiumpress");		
			}    
		}
		
		
		if($miles > 1000 ){	
		//$rt = do_shortcode('[CITY]');
		//$text_after = "";
		}
		
		
		
		
		// DISPLAY ICON
		$II = "";
		 
		if($type == "bar"){
		
		return "<span class='ppt_shortcode_distance bar'>".$II." ".$text_before." ".$rt." ".$text_after."</span>";
		
		}else{ 
		
		return "<span class='ppt_shortcode_distance'>".$II." ".$text_before." ".$rt." ".$text_after."</span>";
	
		}
		
	}	
 

	 

	
	/* =============================================================================
			[USERS] - SHORTCODE
			========================================================================== */
	function ppt_page_users( $atts, $content = null ) {
		
		global $wpdb, $post, $userdata, $settings; $STRING = ""; $extra=""; $i=1; $stopcount = 4; $args = "";  	 
	
	extract( shortcode_atts( array( 
	
	'dataonly' => false, 
	'query' => '', 
	'show' => get_option('posts_per_page'), 
 
	'cat' => '', 
	'orderby' => 'ID', 
	'order' => 'desc', 
	'grid' => false, 
	'authorid' => 0,
	'custom' => "", 
	'customvalue' => "",
	'small' => false,
	'extrasmall' => false,
	'nav' => false,
	'debug' => false,
	'offset' => 0,
	'carousel' => 0,
	
	'limit' => 12,
 
	'search' => "", 
	'card' => '',
	'card_class' => '',
	
	
	 ), $atts ) );
	 
	  
		 
		$args = array('role'          => 'subscriber' );
		
		if($customvalue == "user_fr"){
		
			 
			$args = array_merge($args, 			
				array( 'meta_query' => array (
				
					'relation'    => 'AND',	
					
							array( 	 
							'user_type'    => array(
								'key' 			=> 'user_type',								 
								'value' 		=> 'user_fr',
								'compare' 		=> '=',								 			
							),			 
							 						
						),			
				), )  );
			
				
		}elseif($customvalue == "user_em"){
		
			$args = array_merge($args, 			
				array( 'meta_query' => array (
				
					'relation'    => 'AND',	
					
							array( 	 
							'user_type'    => array(
								'key' 			=> 'user_type',								 
								'value' 		=> 'user_em',
								'compare' 		=> '=',								 			
							),			 
							 						
						),			
				), )  );
				
		}else{
		
		
		}
		 	
		$query1 = new WP_User_Query($args);
		
		$editors = $query1->get_results();
		 
 
		if ( ! empty( $editors ) ) {
		
			 
			$o = 0; $MAINSTRINGSTRING = "";
			ob_start();
			
			if($carousel){	
			
			echo "";
		
			}else{
			
			echo "<div class='row'>";
			}
			
			global $udata;
			
			foreach ( $editors as $editor ) {
			
				$udata = $editor->data;
				
				if($o > $limit){ $o++; continue; }
			 
				
				if($card_class != ""){
				
				echo '<div class="">';
				
				}elseif($carousel){
				 
				}else{
				
				echo '<div class="col-6 col-md-4 col-lg-4 col-xl-3 mb-4">';
				
				}
				
				$settings['card'] = "user";
				_ppt_template( 'content-listing'); 
			 
				if(!$carousel){
				
				echo '</div>';
				}
				
				$o++;			
			}
			
			if($carousel){	
			
			echo "";
		
			}else{	
			
			echo "</div>"; 
			
			}
		
		$MAINSTRINGSTRING .= ob_get_contents();	
		ob_end_clean(); 
 	
		// REMOVE EQUAL HIGH FROM CAROUSELS
		if($carousel){
		
		$MAINSTRINGSTRING = str_replace("eqh ","", str_replace("w-lg-30","", str_replace("w-lg-20","", $MAINSTRINGSTRING)));
		 
		}
		
		$STRING .= $MAINSTRINGSTRING;
		 
	
	} 
	// END QUERY
	wp_reset_query();
	
	if($nav){
	 
		// GET IDS ONLY INSTEAD OF ALL DATA
		$args = array_merge($args,array( 'fields' => "ids", ) );
	 	
		 
		// PERFORM QUERY
		$the_query = new WP_Query( $args ); 
		 
		$big = 999999999; // need an unlikely integer
		
	 
		if(is_front_page() || isset($GLOBALS['flag-home'])){
			$base = home_url()."/page/%#%/?s=";		 
			$format = "?pd=%#%";
		}else{
			
		} 
		
		$base = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );
		$format = "?pa=%#%";
		
		$posts_per_page_g = $args['posts_per_page'];
		if(!is_numeric($posts_per_page_g)){
		$posts_per_page_g = get_option('posts_per_page');
		}
		
		 
		 
		$STRING .= '<div class="col-12">
		
		<ul class="pagination justify-content-center">'.str_replace("current","active",str_replace("page-numbers","btn btn-secondary num",str_replace("<span","<li class='page-item'><span",str_replace("span/>","span/></li>",str_replace("a/>","a/></li>",str_replace("<a","<li class='page-item'><a rel='nofollow'",paginate_links( array(
			'base' 		=> '%_%',
			'format' 	=> "?pa=%#%",
			'current' 	=> max( 1, $paged ),
			'total' 	=> ceil($the_query->found_posts/$posts_per_page_g),
		) ).'</ul></div>'))))));
	
	}
	
	return $STRING; 
	
	
	
	}
	
	/* =============================================================================
		[LISTINGS] - SHORTCODE
		========================================================================== */
function ppt_page_listings( $atts, $content = null ) {
	
	global $wpdb, $post, $userdata; $STRING = ""; $extra=""; $i=1; $stopcount = 4; $args = "";  
	
	extract( shortcode_atts( array( 
	
	'dataonly' => false, 
	'query' => '', 
	'show' => get_option('posts_per_page'), 
	'type' => THEME_TAXONOMY.'_type',  
	'cat' => '', 
	'orderby' => 'ID', 
	'order' => 'desc', 
	'grid' => false, 
	'authorid' => 0,
	'custom' => "", 
	'customvalue' => "",
	'small' => false,
	'extrasmall' => false,
	'nav' => false,
	'debug' => false,
	'offset' => 0,
	'carousel' => 0,
 	'perrow' => "",
	'search' => "", 
	'card' => '',
	'card_class' => '',
	
	
	 ), $atts ) );
	 
	 

 	
	// PER ROW SETUP
	if(isset($atts['dataonly']) != 1 && isset($atts['card']) && in_array( $atts['card'] , array('blank','info','small',  'list-small', 'list-xsmall','user'))){
	
		if($atts['perrow'] == "2"){
			$card_class = "col-6 col-md-6 perrow2";
		}elseif($atts['perrow'] == "3"){
			$card_class = "col-6 col-md-4 perrow3";
		}
 	
	}
  
	// GET CURRENT PAGED ITEM
	if( ( is_front_page() || isset($GLOBALS['flag-home']) ) && isset($_GET['pd']) && is_numeric($_GET['pd']) ){
	 $paged = $_GET['pd'];
	
	}elseif( isset($_GET['pa']) && is_numeric($_GET['pa']) ){
	 $paged = $_GET['pa'];
	
	
	}else{
	 $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
	}
  
  
   $query = str_replace("#038;","&",$query);
   
   
   
  	
   if(strlen($query) > 1 ){
		// ADD ON POST TYPE FOR THOSE WHO FORGET
		if(strpos($query,'post_type') == false && $type ==  THEME_TAXONOMY.'_type'  ){
		$args = $query ."&post_type=".THEME_TAXONOMY."_type&pa=".$paged;
		}else{
		$args = $query."&pa=".$paged;
		}
		$args = hook_custom_queries($args);
	}
    
    
    $extn = "_list";
    if (defined('WP_ALLOW_MULTISITE')) {
        $extn .= get_current_blog_id();
    }

    $my_list = get_user_meta($userdata->ID, 'favorite'.$extn, true);

    if (is_array($my_list) && !empty($my_list)) {
        $a['post_in'] = $my_list;
    } else {
        $a['post_in'] = array("99");
    }
 
  
	if($args == ""){
	// SWITCH QUERY TYPE
	switch($custom){
    
    case "userfavorite": {
        $args = array(
            'posts_per_page' => $show,
            'post_type' => $type,
            'orderby' => 'date', // You can customize this to any field you want to order by
            'order' => 'desc',   // Change order as needed
            'paged' => $paged,
            'offset' => $offset,
            'post__in' => $a['post_in'], // Use the user's favorite posts
        );
    } break;
	
	case "lastused": {

			$args = array('posts_per_page' => $show, 
			'post_type' => $type, 'orderby' => $orderby, 'order' => $order, 'paged'  => $paged, 'offset'  => $offset,
			'meta_query' => array (
					array (
					  'key' => "lastused",
						'compare' => 'LIKE',
						'value' => date('Y-m-d'),
						'type' => 'DATETIME'
					 
					)
				  ) 
			 );
		
		} break;
		
		case "women": {
		 	
			$terms = get_terms( array(
				'taxonomy' => 'dagender',
				'hide_empty' => true,
				'number' => 2,				 
				'search' => "female",				 
			));
			 
			
			$args = array('posts_per_page' => $show, 
			'post_type' => $type, 'orderby' => $orderby, 'order' => $order, 'paged'  => $paged, 'offset'  => $offset  );
			 
			 
			if( !is_wp_error( $terms ) && isset($terms[0]) && $terms[0]->slug != "male" ){
				$args['tax_query'] = array( array( 'taxonomy' => "dagender", 'field' => 'term_id', 'terms' =>  $terms[0]->term_id, 'operator'=> 'IN' )  );
			
			}elseif( !is_wp_error( $terms ) && isset($terms[1]) && $terms[1]->slug != "male"){
				$args['tax_query'] = array( array( 'taxonomy' => "dagender", 'field' => 'term_id', 'terms' =>  $terms[1]->term_id, 'operator'=> 'IN' )  );
			}		 
		
		} break;
	
		case "men": {


			$terms = get_terms( array(
				'taxonomy' => 'dagender',
				'hide_empty' => true,
				'number' => 2,				 
				'search' => "male",				 
			));
			   
			$args = array('posts_per_page' => $show, 
			'post_type' => $type, 'orderby' => $orderby, 'order' => $order, 'paged'  => $paged, 'offset'  => $offset  );
			 
			if( !is_wp_error( $terms ) && isset($terms[0]) && $terms[0]->slug != "female"){
				$args['tax_query'] = array( array( 'taxonomy' => "dagender", 'field' => 'term_id', 'terms' =>  $terms[0]->term_id, 'operator'=> 'IN' )  );
			}elseif( !is_wp_error( $terms ) && isset($terms[1]) && $terms[1]->slug != "female"){
				$args['tax_query'] = array( array( 'taxonomy' => "dagender", 'field' => 'term_id', 'terms' =>  $terms[1]->term_id, 'operator'=> 'IN' )  );
			}
		
		} break;
		
		case "termid": {

			$g = explode("-",$customvalue);
			 
			$args = array('posts_per_page' => $show, 
			'post_type' => $type, 'orderby' => $orderby, 'order' => $order, 'paged'  => $paged, 'offset'  => $offset  );
			 
			 
			$args['tax_query'] = array( array( 'taxonomy' => $g[0], 'field' => 'term_id', 'terms' => $g[1]  )  );
			
		
		} break;
		
		
	 
		case "sponsored": {
			$args = array('posts_per_page' => $show, 
			'post_type' => $type, 'orderby' => $orderby, 'order' => $order, 'paged'  => $paged, 'offset'  => $offset,
			'meta_query' => array (
			
				'relation'    => 'AND',						
							array(							
							'sponsored'    => array(
								'key' 			=> 'sponsored',
								'type' 			=> 'NUMERIC',
								'value' 		=> 1,
								'compare' 		=> '=',								 			
							),
							 					
						),	
				  ) 
			 );
			 
			  if(defined('WLT_DEMOMODE')){
			 
			 $args = array('posts_per_page' => $show,  'post_type' => $type,  'orderby' => 'rand', 'paged'  => $paged, 'offset'  => $offset  );
		
			 
			 }
			   
		} break;	
		case "homepage": {
			$args = array('posts_per_page' => $show, 
			'post_type' => $type, 'orderby' => $orderby, 'order' => $order, 'paged'  => $paged, 'offset'  => $offset,
			'meta_query' => array (
			
				'relation'    => 'AND',						
							array(							
							'homepage'    => array(
								'key' 			=> 'homepage',
								'type' 			=> 'NUMERIC',
								'value' 		=> 1,
								'compare' 		=> '=',								 			
							),
							 					
						),	
				  ) 
			 );
			 
			  if(defined('WLT_DEMOMODE')){
			 
			 $args = array('posts_per_page' => $show,  'post_type' => $type,  'orderby' => 'rand', 'paged'  => $paged, 'offset'  => $offset  );
		
			 
			 }
			   
		} break;
		case "featured": {
		
		
		
		
			$args = array('posts_per_page' => $show, 
			'post_type' => $type, 'orderby' => $orderby, 'order' => $order, 'paged'  => $paged, 'offset'  => $offset,
			'meta_query' => array (
			
				'relation'    => 'AND',						
							array(							
							'featured'    => array(
								'key' 			=> 'featured',
								'type' 			=> 'NUMERIC',
								'value' 		=> 1,
								'compare' 		=> '=',								 			
							),
							 					
						),	
				  ) 
			 ); 
			 
			 if(defined('WLT_DEMOMODE')){
			 
			 $args = array('posts_per_page' => $show,  'post_type' => $type,  'orderby' => 'rand', 'paged'  => $paged, 'offset'  => $offset  );
		
			 
			 }
			 
			 // ADD ON FOR ACCOUNT PAGE
			 if( THEME_KEY == "da" && isset($GLOBALS['flag-account']) && get_user_meta($userdata->ID,'da-seek2',true) != "" ){ 			 
				$seek2 = get_user_meta($userdata->ID,'da-seek2',true);				  
				$args['tax_query'] = array( array( 'taxonomy' => 'dagender', 'field' => 'term_id', 'terms' => $seek2  )  );			
			 }
		
			 
			   
		} break;
		
		case "popular": {
		
		
		
			if(defined('WLT_AUCTION')){
			
			$args = array('posts_per_page' => $show, 
			'post_type' => $type, 'orderby' => 'meta_value_num', 'order' => 'desc', 'paged'  => $paged, 'offset'  => $offset,
			'meta_query' => array (
					array (
					  'key' => 'hits',	
					  'orderby' => 'meta_value_num'				  
					),
					 array( 
						'key' => 'listing_expiry_date',																
						'orderby' => 'meta_value',						 
						'compare' => '>=',
						'value' => current_time( 'mysql' ),
						'type' => 'DATETIME'							 
					),
				  ) 
			 );
			  
			}else{
			
			$args = array('posts_per_page' => $show, 
			'post_type' => $type, 'orderby' => 'meta_value_num', 'order' => 'desc', 'paged'  => $paged, 'offset'  => $offset,
			'meta_query' => array (
					array (
					  'key' => 'hits',	
					  'orderby' => 'meta_value_num'				  
					)
				  ) 
			 );
			 
			 }
			 
			 
			  // ADD ON FOR ACCOUNT PAGE
			 if( THEME_KEY == "da" && isset($GLOBALS['flag-account']) && get_user_meta($userdata->ID,'da-seek2',true) != "" ){ 			 
				$seek2 = get_user_meta($userdata->ID,'da-seek2',true);				  
				$args['tax_query'] = array( array( 'taxonomy' => 'dagender', 'field' => 'term_id', 'terms' => $seek2  )  );			
			 }
			 
			
		
		} break;
		
		case "rating": {

			$args = array('posts_per_page' => $show, 
			'post_type' => $type, 'orderby' => 'meta_value_num', 'order' => 'desc', 'paged'  => $paged, 'offset'  => $offset,
			'meta_query' => array (
					array (
					'key' => 'starrating_total',																
					'orderby' => 'meta_value_num'				  
					)
				  ) 
			 );
		
		} break;
		
		case "author": {
		 
		$args = array('posts_per_page' => $show,  'post_type' => $type,  'orderby' => 'rand', 'offset'  => $offset, 'paged'  => $paged, 'author' => $authorid   );
		 
		
		} break;	
		
		
		
		case "endsooncoupon": {
		
			 $k = "expiry_date";

			$args = array('posts_per_page' => $show, 
			'post_type' => $type, 'orderby' => 'meta_value', 'order' => 'asc', 'paged'  => $paged, 'offset'  => $offset,
			'meta_query' => array (
				 				 
					array( 
						'key' => $k,																
						'orderby' => 'meta_value',						 
						'compare' => '>=',
						'value' => current_time( 'mysql' ),
						'type' => 'DATETIME'							 
					),	
				  ) 
			 );
		 
		
		} break;
		
		case "endingsoon": 
		case "endsoon": {
		
			 
			$args = array('posts_per_page' => $show, 
			'post_type' => $type, 'orderby' => 'meta_value', 'order' => 'asc', 'paged'  => $paged, 'offset'  => $offset,
			'meta_query' => array (
					array( 
						'key' => 'listing_expiry_date',																
						'orderby' => 'meta_value',						 
						'compare' => '>=',
						'value' => current_time( 'mysql' ),
						'type' => 'DATETIME'							 
					),
				  ) 
			 );
		
		} break;
		
		case "random": {

			$args = array('posts_per_page' => $show,  'post_type' => $type,  'orderby' => 'rand', 'paged'  => $paged, 'offset'  => $offset  );
		
		
		// ADD IN HITS
			if($orderby == "hits"){
			
				$args = array_merge($args, 			
				array( 'meta_query' => array (
				
					'relation'    => 'AND',	
					
							array(
							
							'relation'    => 'OR',	
										 
							'featured'    => array(
								'key' 			=> 'packageID',
								'type' 			=> 'NUMERIC',
								'value' 		=> 1,
								'compare' 		=> '=',								 			
							),			 
							'featured1'   => array(
								'key' 			=> 'packageID',								
								'value' 		=> "yes",
								'compare' 		=> '=',	
												
							),						
						),			
				), )  );
				
				}
				
				
				if(isset($_GET['country']) && strlen($_GET['country']) < 5){
				
				
				$args = array_merge($args, 			
				array( 'meta_query' => array (
				
					'relation'    => 'AND',	
					
							array(
							
							 			 
							'map-country'    => array(
								'key' 			=> 'map-country',								 
								'value' 		=> $_GET['country'],
								'compare' 		=> '=',								 			
							),			 
							 						
						),			
				), )  );
				
				}
				
		} break;
		
		case "nearby": {
		
			// GET CITY
			$city = get_post_meta($post->ID,'map-city',true);
			
			// GET CATEGORY
			$term_list = wp_get_post_terms($post->ID, 'listing', array("fields" => "all"));	
			
			$args = array('posts_per_page' => $show, 
			'post_type' => $type,   'order' => 'desc', 'paged'  => $paged, 'offset'  => $offset, 'post__not_in' => array($post->ID),
			'meta_query' => array (
					array (
					'key' => 'map-city',																
					'value' => $city				  
					)
				  ) 
			 );
			 if(isset($term_list[0])){	
			 			
				$args['tax_query'] = array( array( 'taxonomy' => "listing", 'field' => 'term_id', 'terms' =>  $term_list[0]->term_id, 'operator'=> 'IN' )  );
				 
			}
			 
			 
		} break;
 
		
		case "related": {
		
	 
			if(THEME_KEY == "cp"){				  
			$term_list = wp_get_post_terms($post->ID, 'store', array("fields" => "all"));	
			}elseif(THEME_KEY == "da"){				  
			$term_list = wp_get_post_terms($post->ID, 'dagender', array("fields" => "all"));		
			}else{			
			$term_list = wp_get_post_terms($post->ID, 'listing', array("fields" => "all"));		
			}
			 
 
 			if(THEME_KEY == "cp" && isset($term_list[0]) ){	
				$args = array('posts_per_page' => $show,  'orderby' => 'title', 'order' => 'des',  'post_type' => 'listing_type', 'post__not_in' => array($post->ID), 				
				'tax_query' => array( array('taxonomy' => "store", 'field' => 'term_id', 'terms' =>  $term_list[0]->term_id, 'operator'=> 'IN' ) ),				
				 );
				 
			}elseif(THEME_KEY == "da" && isset($term_list[0]) ){	
				$args = array('posts_per_page' => $show,  'orderby' => 'title', 'order' => 'des',  'post_type' => 'listing_type', 'post__not_in' => array($post->ID), 				
				'tax_query' => array( array('taxonomy' => "dagender", 'field' => 'term_id', 'terms' =>  $term_list[0]->term_id, 'operator'=> 'IN' ) ),				
				 );
				 
			}elseif(isset($term_list[0])){				
				$args = array('posts_per_page' => $show,  'orderby' => 'title', 'order' => 'des',  'post_type' => 'listing_type', 'post__not_in' => array($post->ID), 				
				'tax_query' => array( array('taxonomy' => "listing", 'field' => 'term_id', 'terms' =>  $term_list[0]->term_id, 'operator'=> 'IN' ) ),				
				 );
			}else{
				$args = array( 'post_type' => THEME_TAXONOMY.'_type', 'posts_per_page' => $show, 'orderby' => 'ID', 'order' => 'desc', 'paged'  => $paged, 'post__not_in' => array($post->ID)  );
			}
		
		} break;
		
		case "new": { 
		 
				
			$args = array('posts_per_page' => $show,  'post_type' => $type,  'orderby' => 'ID', 'order' => 'desc', 'paged'  => $paged, 'offset'  => $offset );
			
			 // ADD ON FOR ACCOUNT PAGE
			 if( THEME_KEY == "da" && isset($GLOBALS['flag-account']) && get_user_meta($userdata->ID,'da-seek2',true) != "" ){ 			 
				$seek2 = get_user_meta($userdata->ID,'da-seek2',true);				  
				$args['tax_query'] = array( array( 'taxonomy' => 'dagender', 'field' => 'term_id', 'terms' => $seek2  )  );			
			 }
			 
		
		} break;	
		
		case "stores": {
 
			$args = array('posts_per_page' => $show,  'post_type' => $type,  'taxonomy' => "store", 'orderby' => 'ID', 'order' => 'desc', 'paged'  => $paged, 'offset'  => $offset );
			 
		
		} break;
		
		default: {
		
		
			/*** default string ***/
			$args = array('posts_per_page' => $show, 'post_type' => $type, 'orderby' => $orderby, 'order' => $order, 'paged'  => $paged, 'offset'  => $offset );
	   	
			// ADD IN HITS
			if($orderby == "hits"){
			
				$args = array_merge($args, 			
				array( 'meta_query' => array (
				
					'relation'    => 'AND',	
					
							array(
							
							'relation'    => 'OR',	
										 
							'hits'    => array(
								'key' 			=> 'hits',
								'type' 			=> 'NUMERIC',								 								 			
							),					
						),				
				), )  );
				
				}
			
		}
	 
	} // end switch 
	
	
	// REMOVE IF 0
	if($offset == 0){
	unset($args['offset']);	
	}
	
	// CUSTOM CATEGORY
	$taxK = "listing";
	if(THEME_KEY == "da"){	
		$taxK = "dagender";
	}
	
	
 	if(is_array($cat)){
 		$args['tax_query'][] = array(
							'taxonomy' => $taxK,
							'field' => 'term_id',
							'terms' => $cat,
							'operator'=> 'IN'	,
							//'include_children' => true,						
		); 
	}elseif($cat != ""){
	 
 		$args['tax_query'][] = array(
							'taxonomy' => $taxK,
							'field' => 'term_id',
							'terms' => explode(",", $cat),
							'operator'=> 'IN'	,
							//'include_children' => true,						
		); 		
	}
	 
	
 
			 

	// COUPON HIDE EXPIRED
	 
	if(THEME_KEY == "cp" && $custom != "stores"){
	
	
	/* NEEDS REDOING 
		if(_ppt('coupon_showexpired') == '1'){}else{		
		
			// ADDON
			if(isset($args['meta_query'])){		
			
				$args['meta_query'] = array_merge($args['meta_query'],  
						array(  
							'expiry_date'   =>  
							array( 
								'key' 			=> 'expiry_date',																
								'orderby' 		=> 'expiry_date',						 
								'compare' 		=> '>=',
								'value' 		=> current_time( 'mysql' ),
								'type' 			=> 'DATETIME',
							),					  
						)
				);		
			
			}else{
			
				$args = array_merge($args, 			
					array( 'meta_query' => array (				
						'relation'    => 'AND',	
								'expiry_date'   =>  array( 
								'key' => 'expiry_date',																
								'orderby' => 'expiry_date',						 
								'compare' => '>=',
								'value' => current_time( 'mysql' ),
								'type' => 'DATETIME',
							), 
						), 
					)
				);
					
			}// end if 
			 
		}
		
		*/
		
	}
	
	
	if(THEME_KEY == "at"){
	
	
			// ADDON
			if(isset($args['meta_query'])){		
			
				$args['meta_query'] = array_merge($args['meta_query'],  
						array(  
							'expiry_date'   =>  
							array( 
								'key' => "listing_expiry_date",
								'compare' => '>=',
								'value' => current_time( 'mysql' ),
								'type' => 'DATETIME'	
							),					  
						)
				);		
			
			}else{
			 
				$args = array_merge($args, 			
					array( 'meta_query' => array (				
						'relation'    => 'AND',	
								'expiry_date'   =>  array( 
								'key' => "listing_expiry_date",
								'compare' => '>=',
								'value' => current_time( 'mysql' ),
								'type' => 'DATETIME'	
							), 
						), 
					)
				);
					
			}// end if 
		 	 
			 
		
	}
	
	if(THEME_KEY == "da" && isset($_GET['male'])){	
	
	
			// ADDON
			if(isset($args['meta_query'])){		
			
				$args['meta_query'] = array_merge($args['meta_query'],  
						array(  
							'dagender'   =>  
							array( 
								'key' => "dagender",
								'compare' => '=',
								'value' => "1",
							),					  
						)
				);		
			
			}else{
			 
				$args = array_merge($args, 			
					array( 'meta_query' => array (				
						'relation'    => 'AND',	
								'dagender'   =>  array( 
								'key' => "dagender",
								'compare' => '=',
								'value' => "1",
							), 
						), 
					)
				);
					
			}// end if 
		 	 
			 
		
	}elseif(THEME_KEY == "da" && isset($_GET['female'])){
	
			// ADDON
			if(isset($args['meta_query'])){		
			
				$args['meta_query'] = array_merge($args['meta_query'],  
						array(  
							'dagender'   =>  
							array( 
								'key' => "dagender",
								'compare' => '=',
								'value' => "2",
							),					  
						)
				);		
			
			}else{
			 
				$args = array_merge($args, 			
					array( 'meta_query' => array (				
						'relation'    => 'AND',	
								'dagender'   =>  array( 
								'key' => "dagender",
								'compare' => '=',
								'value' => "2",
							), 
						), 
					)
				);
					
			}// end if 
		
	}

	 
	if(isset($search) && strlen($search) > 1){
		 	 
		$args = array_merge($args, array( 's' => $search )  );
 		
	}
	
	// HOMEPAGE ADDON EXTRA FOR THIS
	/*
	if(isset($GLOBALS['flag-home'])){
	
		$args = array('posts_per_page' => $show, 
			'post_type' => $type, 'orderby' => $orderby, 'order' => $order, 'paged'  => $paged, 'offset'  => 0,
			'meta_query' => array ( 
			
			 			  			 
							'homepage'    => array(
								'key' 			=> 'homepage',								 
								'value' 		=> 1,
								'compare' 		=> '=',								 			
							),			 
					 
				  ) 
			 ); 
	
	}*/
	
 	
	// ONLY LIVE LISTINGS
	$args = array_merge($args, array( 'post_status' => array('publish') )  );
	 
  
	// HOOK QUERY
	$args = hook_custom_queries($args);
 
 	// debug
	//if($debug){
	//print_r($args);
	//}
	
	} // end if query is empty
	
	
	// SAVE QUERIES AND ADD-ON NO FOUND ROWS
	if(!$nav && is_array($args) ){	 
	 
		$args = array_merge($args, array('no_found_rows' => true ) );
	}  
	
	$GLOBALS['img_carousel'] = 1;
 
	  
	$query1 = new WP_Query( $args );
	
 
	if ( $query1->have_posts() ) {
 	
	 	 
		$o = 0; $MAINSTRINGSTRING = "";
		ob_start();
		
		if($carousel){	
		 
		
		echo "";
	
		}else{
		
		echo "<div class='row'>";
		}
 		
		while ( $query1->have_posts() ) { $query1->the_post();
		
		 	
			if( ( !isset($_POST['action']) && !isset($_GET['action'])  ) && get_post_meta($post->ID, "paymentdue", true) == "1"){
			continue;
			}
		    
			
			if($card_class != ""){
			
			echo '<div class="'.$card_class.'">';
			
			}elseif($carousel){
			
			
			}elseif($small){
			
			echo '<div class="col-6 col-md-4 col-lg-4 col-xl-3">';
			
			}else{
			
			echo '<div class="col-6">';
			}
			 
			_ppt_template( 'content-listing'); 
		 
			if(!$carousel){
			
			echo '</div>';
			}
			
			$o++;			
		}
		
		if($carousel){	
		
		echo "";
	
		}else{	
		
		echo "</div>"; 
		
		}
		
		$MAINSTRINGSTRING .= ob_get_contents();	
		ob_end_clean(); 
		
		
		// REMOVE EQUAL HIGH FROM CAROUSELS
		if($carousel){
		
		$MAINSTRINGSTRING = str_replace("eqh ","", str_replace("w-lg-30","", str_replace("w-lg-20","", $MAINSTRINGSTRING)));
		 
		}
		
		$STRING .= $MAINSTRINGSTRING;
		
		
		
		//$fg = hook_items_after_filter( array("string" => $STRING, "args" => $args, "show" => $show-$o ) );	 
		//$STRING .= $fg['string'];
	 
	
	} 
	// END QUERY
	wp_reset_query();
	
	if($nav){
	 
		// GET IDS ONLY INSTEAD OF ALL DATA
		$args = array_merge($args,array( 'fields' => "ids", ) );
	 	
		 
		// PERFORM QUERY
		$the_query = new WP_Query( $args ); 
		 
		$big = 999999999; // need an unlikely integer
		
	 
		if(is_front_page() || isset($GLOBALS['flag-home'])){
			$base = home_url()."/page/%#%/?s=";		 
			$format = "?pd=%#%";
		}else{
			
		} 
		
		$base = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );
		$format = "?pa=%#%";
		
		$posts_per_page_g = $args['posts_per_page'];
		if(!is_numeric($posts_per_page_g)){
		$posts_per_page_g = get_option('posts_per_page');
		}
		
		 
		 
		$STRING .= '<div class="col-12">
		
		<ul class="pagination justify-content-center">'.str_replace("current","active",str_replace("page-numbers","btn btn-secondary num",str_replace("<span","<li class='page-item'><span",str_replace("span/>","span/></li>",str_replace("a/>","a/></li>",str_replace("<a","<li class='page-item'><a rel='nofollow'",paginate_links( array(
			'base' 		=> '%_%',
			'format' 	=> "?pa=%#%",
			'current' 	=> max( 1, $paged ),
			'total' 	=> ceil($the_query->found_posts/$posts_per_page_g),
		) ).'</ul></div>'))))));
	
	}
	
	return $STRING; 	
	
}
 
 
 
 
	/* =============================================================================
		[TIMELEFT] - SHORTCODE
		========================================================================== */
	 	
		
	function ppt_shortcode_timeleft( $atts, $content = null ) {
	
 
		global $wpdb, $userdata, $CORE, $post, $shortcode_tags; $STRING = ""; 
		
		extract( shortcode_atts( array('postid' => "", "text_before" => "", "text_ended" => "", "key" => "listing_expiry_date" ), $atts ) );
		
		// SETUP ID FOR CUSTOM DISPLAY	
		$milliseconds = str_replace("+","",round(microtime(true) * 100));
		$milliseconds .= rand( 0, 10000 );
		 
		// CHECK FOR CUSTOM POST ID
		if($postid == ""){ $postid = $post->ID; }
		
		
		
		// GET VALUE FROM LISTING
		if($key == "membership"){
		$m = $CORE->USER("get_user_membership",$postid);
			if(isset($m['date_expires'])){
			$expiry_date = $m['date_expires'];
			}else{
			$expiry_date = "";
			} 
		
		}else{
		$expiry_date = get_post_meta($postid,$key,true);		 
		}
		
		if($expiry_date == "" || strlen($expiry_date) < 3){ 		 
			return "ended"; 
		}
		
	  
		if(strlen($expiry_date) == 10){ $expiry_date = $expiry_date." 00:00:00"; }
		
		// REFRESH PAGE EXTR
		$run_extra =  ""; $run_extrab  = "";
		
		$spanid = $postid."".$milliseconds;
	  
		ob_start();
		?>
		<div class="timeCountEndDate" style="display: grid; text-align: end;">
        
        
        <span class='timeleft_<?php echo $spanid; ?>'></span>
        </div>
		<script> 
			
			jQuery(document).ready(function() {		
			
				var dateStr = '<?php echo $expiry_date; ?>'
				var a=dateStr.split(' ');
				var d=a[0].split('-');
				var t=a[1].split(':');
				var date1 = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);	
						 
				jQuery('.timeleft_<?php echo $spanid; ?>').countdown({
				timezone: <?php echo get_option('gmt_offset'); ?>, 
				until: date1, 
				onExpiry: WLTvalidateexpiry<?php echo $postid; ?>,
				compact: true,
				alwaysExpire: true,				 
				});
				
			});
			
			function WLTvalidateexpiry<?php echo $postid; ?>(){		 
			 
			 	   jQuery.ajax({
					   type: "POST",
					   url: '<?php echo home_url(); ?>/',
					data: {
					action: "<?php if($key == "membership"){ echo "expire_check_membership"; }else{ echo "validateexpiry"; } ?>",						 	
					   pid: '<?php echo $postid; ?>',
					  },
					   success: function(response) {
					   
					   <?php if(is_admin() && !isset($_GET['eid']) ){ ?>
					   //location.reload();
					   <?php } ?>
					 
					   },
					   error: function(e) {
						   
					   }
				   });
						
			 };
			
		</script>
		<?php	 
			
			$STRING = ob_get_clean(); 
			
			return $STRING;
	}	

 
 
	/* =============================================================================
		[TIMESINCE] - SHORTCODE
		========================================================================== */
	function ppt_shortcode_timesince( $atts, $content = null ) { global $post, $CORE;
	
		global $wpdb, $userdata, $CORE, $post, $shortcode_tags;  
		
		extract( shortcode_atts( array('updated' => false ), $atts ) );		
		 
		if($updated == 1){
		$vv = $CORE->date_timediff($post->post_modified);	
		}else{		
		$vv = $CORE->date_timediff($post->post_date);	
		}			 
	
		return $vv['string-small'];
	
		 
	} 
  
	
	

}


?>