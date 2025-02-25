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
   
   if(!_ppt_checkfile("content-post.php")){
   
   global $CORE, $post;
   
   if(!isset($GLOBALS['blogcount'])){ $GLOBALS['blogcount'] = 1; }else{ $GLOBALS['blogcount']++; }
    
    
   $day 	= date("d", strtotime(get_the_date('Y-m-d',$post->ID)));
   $month 	= date("M", strtotime(get_the_date('Y-m-d',$post->ID)));
   $year 	= date("Y", strtotime(get_the_date('Y-m-d',$post->ID)));
   
   $g = wp_get_post_terms($post->ID,"category"); 
   
   if( defined('WLT_DEMOMODE') ){
   	 $img =  do_shortcode('[IMAGE pathonly=1]');
   }else{
	   $img = get_the_post_thumbnail_url($post->ID);
	   if(strlen($img) < 4){
	   $img = get_template_directory_uri()."/framework/images/nophoto.jpg";
	   }
   }
   
   
   ?>
   
<div class="card card-blog-post p-4 border-light rounded-0">
   <div class="row d-flex <?php if($GLOBALS['blogcount']%2){ ?>flex-row-reverse<?php } ?>">
      <div class="col">
            <a href="<?php echo get_permalink($post->ID); ?>">
            <img  data-src="<?php echo $img; ?>" alt="<?php echo strip_tags($post->post_title); ?>" class="img-fluid mb-4 mb-md-0 lazy">  
            </a>
      </div>
      <div class="col-md-6">
         <div class="d-flex justify-content-between">
            <span class="text-muted">
            <i class="fal fa-folder-open"></i> 
            <?php the_category(','); ?>
            </span>
            <span class="text-muted">
            <i class="fal fa-clock"></i> 
            <time datetime="<?php echo $post->post_date; ?>"><?php echo $month; ?> <?php echo $day ; ?></time>
            </span>
         </div>
         <h3 class="pt-2 pt-md-3 pb-2 h2 font-weight-normal line-height-40">
            <a href="<?php echo get_permalink($post->ID); ?>" class="text-decoration-none text-dark"><?php echo do_shortcode('[TITLE]'); ?></a>
         </h3>
         <p class="text-muted"><?php echo do_shortcode('[EXCERPT limit=100]'); ?>... <u><a class="text-primary" href="<?php echo get_permalink($post->ID); ?>"><?php echo __("read more","premiumpress"); ?></a></u></p>
         
      </div>
   </div>
</div>
<?php } ?>