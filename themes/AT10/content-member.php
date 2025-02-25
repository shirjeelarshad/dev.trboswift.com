<?php

if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
global $author, $CORE;

$user = get_userdata($author->ID); 

 
?>
<div class="member box-grey box-shadow bg-light pb-4 mb-4">
   <div class="box-grey-wrap">
      <div class="img-box">
         <a href="<?php echo get_author_posts_url( $user->ID ); ?>">
         <?php echo str_replace("avatar ","avatar img-fluid ",get_avatar( $user->ID, 250 )); ?>
         </a>
         <?php  
            $listings = $CORE->count_user_posts_by_type( $user->ID, THEME_TAXONOMY."_type" );
			if($listings > 99){ $listings = "99+"; }
            ?>
            <a class="postcount" href="<?php echo get_home_url()."/?s=&amp;uid=".$user->ID; ?>">
         <span class="num"><?php echo $listings; ?></span>
         <span class="text"><?php echo __("items","premiumpress"); ?></span>
         </a>
         
      </div>
      <h4 class="text-center"> <a href="<?php echo get_author_posts_url( $user->ID ); ?>" class="text-dark" style="text-decoration:underline;"><?php  echo $CORE->USER("get_username",$user->ID); ?></a></h4>
      <div class="text-center">
         <div class="font-size14 grey"><?php echo __("Member since","premiumpress"); ?></div>
         <div class="font-size12 grey margin-top1"><?php $gg = hook_date( $CORE->USER("get_joined",$user->ID)); $f = explode(":", $gg); echo substr($f[0], 0, -2);  ?></div>
      </div>
   </div>
</div>