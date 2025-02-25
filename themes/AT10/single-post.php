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
   
   $GLOBALS['flag-blog'] 		= true;
   $GLOBALS['flag-blog-single'] = true;
   
   if(!_ppt_checkfile("single-post.php")){
   
   if(!defined('SIDEBAR-LEFT') && !defined('SIDEBAR')){
   define('SIDEBAR', true);
   }
   
   function _hook_head(){
   ?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<?php }
   if(_ppt(array('captcha','enable')) == 1 && _ppt('captcha','sitekey') != ""){
   add_action('wp_head','_hook_head');
   }
   
   global $post, $CORE;
   
   // UPDATE HITS
   $hits = get_post_meta($post->ID,'hits',true);
   if(!is_numeric($hits)){ $hits = 0; }
   update_post_meta($post->ID, 'hits',  $hits + 1 );
   $hits++;
   
   
   
    $day 	= date("d", strtotime(get_the_date('Y-m-d',$post->ID)));
   $month 	= date("M", strtotime(get_the_date('Y-m-d',$post->ID)));
   
$socialshare = "";	

ob_start();
?>
 
    
<div id="socialbar" class="socialbar social-buttons">

<div class="sharertitle hide-mobile">
    <span class="total-count"><?php  echo $day; ?></span>

    <span class="total-text"><?php echo $month; ?></span>

</div>

<div class="sharerfacebook sharebutton">
<a href="https://www.facebook.com/sharer.php?u=<?php echo get_permalink($post->ID); ?>" class="facebook"  target="_blank" title="Share on Facebook">

 <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title></title><g><path d="M21,1H3A2,2,0,0,0,1,3V21a2,2,0,0,0,2,2h7.5a.5.5,0,0,0,.5-.5v-7a.5.5,0,0,0-.5-.5h-1a.5.5,0,0,1-.5-.5v-3a.5.5,0,0,1,.5-.5h1a.5.5,0,0,0,.5-.5v-1A4.5,4.5,0,0,1,15.5,5h3a.5.5,0,0,1,.5.5v3a.5.5,0,0,1-.5.5h-3a.5.5,0,0,0-.5.5v1a.5.5,0,0,0,.5.5h3a.5.5,0,0,1,.49.58l-.5,3A.5.5,0,0,1,18,15H15.5a.5.5,0,0,0-.5.5v7a.5.5,0,0,0,.5.5H21a2,2,0,0,0,2-2V3A2,2,0,0,0,21,1Z" style="fill:#fff"></path></g></svg>  

<span class="count">Share</span></a>
</div>


<div class="sharertwitter sharebutton">
<a href="https://twitter.com/share?url=<?php echo get_permalink($post->ID); ?>&amp;text=<?php echo $post->post_title; ?>" class="twitter" target="_blank" title="Share on Twitter">


 <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title></title><g><path d="M23.87,4.43a.5.5,0,0,0-.6-.1,4.76,4.76,0,0,1-.75.27A4.85,4.85,0,0,0,23.37,3a.5.5,0,0,0-.77-.53,10.59,10.59,0,0,1-2.53,1A5.05,5.05,0,0,0,16.5,2a5.71,5.71,0,0,0-3,.93C11.6,4,11.27,6.47,11.41,8a13,13,0,0,1-9-4.76A.53.53,0,0,0,2,3a.5.5,0,0,0-.4.25,5.35,5.35,0,0,0,.22,5.7c-.15-.1-.31-.22-.47-.35A.5.5,0,0,0,.5,9,5.73,5.73,0,0,0,3,13.64l-.39-.11A.5.5,0,0,0,2,14.2a6.48,6.48,0,0,0,4.19,3.62A9.22,9.22,0,0,1,.56,19a.5.5,0,0,0-.31.93A15.2,15.2,0,0,0,8,22H8a13.35,13.35,0,0,0,10-4.63,13.63,13.63,0,0,0,3.65-9.92A9.81,9.81,0,0,0,23.92,5,.5.5,0,0,0,23.87,4.43ZM8,21.5Z" style="fill:#fff"></path></g></svg> 

<span class="count">Tweet</span></a>
</div>


<div class="sharerlinkedin sharebutton">
<a href="https://www.linkedin.com/cws/share?url=<?php echo get_permalink($post->ID); ?>" class="linkedin" data-size="medium" rel="nofollow noopener noreferrer" target="_blank" title="Share on LinkedIn">

<svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="linkedin" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" ><path fill="currentColor" d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z" class=""></path></svg>

<span class="count">Share</span></a>
</div>

<div class="sharerpinterest sharebutton">
<a href="https://pinterest.com/pin/create/button/?url=<?php echo get_permalink($post->ID); ?>&amp;description=<?php echo $post->post_title; ?>" class="pinterest" rel="nofollow" target="_blank" title="Share on Pinterest">

<svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="pinterest-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-pinterest-square fa-w-14"><path fill="currentColor" d="M448 80v352c0 26.5-21.5 48-48 48H154.4c9.8-16.4 22.4-40 27.4-59.3 3-11.5 15.3-58.4 15.3-58.4 8 15.3 31.4 28.2 56.3 28.2 74.1 0 127.4-68.1 127.4-152.7 0-81.1-66.2-141.8-151.4-141.8-106 0-162.2 71.1-162.2 148.6 0 36 19.2 80.8 49.8 95.1 4.7 2.2 7.1 1.2 8.2-3.3.8-3.4 5-20.1 6.8-27.8.6-2.5.3-4.6-1.7-7-10.1-12.3-18.3-34.9-18.3-56 0-54.2 41-106.6 110.9-106.6 60.3 0 102.6 41.1 102.6 99.9 0 66.4-33.5 112.4-77.2 112.4-24.1 0-42.1-19.9-36.4-44.4 6.9-29.2 20.3-60.7 20.3-81.8 0-53-75.5-45.7-75.5 25 0 21.7 7.3 36.5 7.3 36.5-31.4 132.8-36.1 134.5-29.6 192.6l2.2.8H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48z" class=""></path></svg>

<span class="count">Pin</span></a>
</div>

<div class="small float-right hide-ipad hide-mobile sharebutton">

<div class="pt-2 opacity-5"><?php the_category(','); ?></div>
</div>

</div>
<?php 

$socialshare = ob_get_contents();
ob_end_clean();
   
   
   
   
   
   get_header(); _ppt_template( 'page', 'top' );
   
   
   ?>

<section class="section-60 bg-light">
  <div class="container">
    <div class="row">
      <?php
   
   if (have_posts()) : while (have_posts()) : the_post();  ?>
      <div class="col pr-md-5">
        <div class="card blog-single shadow-sm border-0">
          <div class="card-body"> <img src="<?php echo do_shortcode('[IMAGE pathonly=1]'); ?>" alt="<?php echo strip_tags(do_shortcode('[TITLE]')); ?>" class="card-img-top img-fluid">
            <h1 class="py-4 mt-4"><?php echo do_shortcode('[TITLE]'); ?></h1>
            
            <?php if(_ppt(array('blog','enablesocial')) == 1){ echo $socialshare; } ?>
            
             
            <hr />
            <div class="text-muted"> <?php echo do_shortcode('[CONTENT media=0]'); ?> </div>
            <?php if ( comments_open() ){ ?>
            <div class="mt-4">
            <?php 
			
			 
/*

	1. DISPLAY COMMENTS
	
*/


if($post->comment_count == 0 && $post->post_author == 1 && defined('WLT_DEMOMODE')){

	// GET FILE
	
	echo "<h3 class='mb-4'>3 Comments </h3>";
	
	_ppt_template('content-comment-example');	

}else{
	
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
	echo preg_replace("/<form.*?<\/form>/is","", $comment_form);


}

/*

	2. DISPLAY FORM BOX
	
*/
 

ob_start();

?>
    <textarea id="comment" name="comment" style="min-height:100px;" aria-required="true" class="form-control my-4"></textarea>
 
    <div class="btn-toolbar mt-4">
      <button class="btn btn-primary btn-sm btn-icon icon-before mr-3" type="submit"><i class="fa fa-comment"></i> <?php echo __("Post Comment","premiumpress"); ?></button>
     </div>
    <?php
$commentfield = ob_get_clean();
 
/*

	3. DISPLAY EVERYTHING
	
*/

if($userdata->ID){

$comments_args = array(
	'class_form' 			=> '',
	'id_form' 				=> 'newcomment',
	'label_submit'			=> '',
	'comment_notes_before' 	=> '',
	'title_reply'			=> '', 
	'title_reply_before' 	=> '',
	'comment_notes_after' 	=> '',
	//'submit_field' 			=> '',
	'comment_field' 		=> ''.$commentfield.'',
	'logged_in_as' 			=> '',
);

comment_form( $comments_args, $post->ID );
}else{
?>
    <div class="text-center text-muted p-2 py-4 bg-light"> <i class="fal fa-comments mr-2"></i> <?php echo __("Please login to post a comment.","premiumpress"); ?> </div>
<?php }  ?>
			
			</div>
		 
            <?php } ?>
          </div>
        </div>
      </div>
      <?php endwhile; endif; ?>
      <?php get_sidebar();  ?>
    </div>
  </div>
</section>
<style>
.wp-block-post-featured-image .wp-post-image {
width:100%;
}
</style>

<?php _ppt_template( 'page', 'bottom' ); ?>
<?php get_footer(); ?>
<?php } ?>