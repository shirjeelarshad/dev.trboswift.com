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

global $CORE;
?>

<?php if(THEME_KEY != "vt"){ ?>
<div class="px-4 py-2 small text-muted border-top  d-flex justify-content-between align-items-center">
  <div><i class="fa fa-users mr-2"></i> <em><?php echo do_shortcode('[HITS]'); ?> <?php echo __("views today!","premiumpress"); ?></em> </div>
  <div class="text-muted text-uppercase"><?php echo do_shortcode('[OFFERS]'); ?> <?php echo $CORE->LAYOUT("captions","offers"); ?>.</div>
</div>
<?php } ?>

<div class="p-4  border-top">


<a href="<?php if(_ppt(array('user','allow_profile')) == 1){  echo get_author_posts_url( $post->post_author );  }else{ echo "#"; }?>" class="userphoto float-right mt-n2 position-relative" style="width:70px;height:50px;"> <?php echo str_replace("userphoto","rounded-circlex",get_avatar( $post->post_author, 80 )); ?>
<div class="levelicon active withtext position-absolute" style="bottom:-30px; right:-10px;"> <span><?php echo  $CORE->USER("get_level",$post->post_author); ?></span><small><?php echo __("level","premiumpress"); ?></small> </div>
</a>




<h5><?php echo  $CORE->USER("get_name",$post->post_author); ?></h5>

<?php if(THEME_KEY == "vt"){ ?>

<p class="small text-muted"> <?php echo __("has","premiumpress")." ".$CORE->USER("get_subscribers_count", $post->post_author)." ". __("subscribers","premiumpress"); ?>.</p>

<?php }else{ ?>
<p class="small text-muted"> <?php echo __("has","premiumpress"); ?> <?php echo $CORE->USER("count_listings", $post->post_author)." ". __("other ads","premiumpress"); ?>.</p>

<?php } ?>


<?php echo do_shortcode('[RATING_USER uid='.$post->post_author.']'); ?>

 
</div>
