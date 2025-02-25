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
 
global $CORE, $settings;


//print_r($settings);

$gg = array(
  		"",
	  __('Very Poor',"premiumpress"),
	  __('Below Average',"premiumpress"),
	  __('Average',"premiumpress"),
	  __('Above Average',"premiumpress"),
	  __('Perfect',"premiumpress"),
);
	  
$score = get_comment_meta($settings['ID'],'ratingtotal',true);
if( $score == ""){  $score = 5; }
	  
	  
// GET LISTING ID
$listingid = $settings['pid'];		 
$listing_link = ""; 
if(is_numeric($listingid)){		
	$listing_link = '<div class="mt-3 small"><a href="'.get_permalink($listingid).'">'.get_the_title($listingid).'</a></div>';
}
?>

<div class="comment-wrapper mb-4 border-bottom pb-4 card-feedback">
  <div class="row">
    <div class="col-md-1 pr-0">
      <div class="image"> <a href="<?php echo get_author_posts_url( $settings['author'] ); ?>"> <?php echo get_avatar( $settings['author'], 65, '[default gravatar URL]', 'Author�s gravatar' ); ?> </a> </div>
    </div>
    <div class="col-md-7 pl-lg-3">
      <div class="comment-author text-uppercase font-weight-bold float-left">
        <?php echo $settings['author_name']; ?>
      </div>
      <div class="comment-date text-muted float-right small mr-lg-4"><?php echo hook_date($settings['date']); ?></div>
      <div class="clearfix"></div>
      <div class="desc mt-4" style="border-left: 3px solid #e1e2e2; padding-left: 20px;"> <?php echo $settings['desc']; ?> </div>
      <?php echo $listing_link; ?> </div>
    <div class="col-md-4">
      <div class="rating-score-big text-center"> <span><?php echo number_format($score,1); ?></span> <strong><?php echo $gg[number_format($score,0)]; ?></strong></div>
    </div>
  </div>
</div>