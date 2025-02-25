<?php global $comment, $settings, $args, $userdata, $post_authorID; 
   
   if(!is_array($args)){ $args = array(); }
   
   // CHECK FOR PHOTO
   $photo = get_comment_meta( $comment->comment_ID, 'photo', true );
   
   if($post_authorID = "" || !is_numeric($post_authorID) ){
   
   $post_authorID = $comment->user_id;
   }
    
   
   ?>
   
   <style>
   .child-comments li::marker{
   font-size: 0px;
   }
   
   .comment-single .comment-area, #comments-ajax-all .comment-single .comment-area {
    padding: 10px 15px;
    background: #f9f9f900 !important;
}

.comment-cont img{
width:50px;
height:50px;
border-radius: 50px;
}
   </style>
<div class="comment-single">
   <div class="row m-0">
      <div class="col-12">
         <div class="row m-0">
            <div class="col-0 d-none text-center">
              
               
               
                 <?php if(isset($comment->comment_ID)){ ?>
                  <?php if(get_comment_meta( $comment->comment_ID, 'rating1', true ) != ""){   ?> <?php } ?> 
               
            </div>
            <div id="comment-<?php echo $comment->comment_ID; ?>" class="comment-cont comment-area  col-12 d-flex">
            
            
                 <?php echo get_avatar( $comment, 50, '[default gravatar URL]', 'Author gravatar' ); ?>
             
               
               <div class="bg-white col-12 p-3" style="border-radius:15px;">
               <div>
               <div class="d-flex">
               
               
                  <?php if(!in_array(THEME_KEY, array("sp","cm")) ){ ?>
                  <h5 class="pb-0 d-flex align-items-center">
                     <?php comment_author(); ?>
                     <?php  
                $comment = get_comment(); 
                $comment_author_id = $comment->user_id;
                $post_author_id = get_post_field('post_author', get_the_ID());

                if ($comment_author_id == $post_author_id) { 
            ?>
                    <span class="ml-2 float-right" style="font-size: 12px;font-weight: 600;line-height: 11px;background: #7d4fff;padding: 2px 4px;border-radius: 4px;color: #fff;"><?php echo __("Seller", "premiumpress"); ?></span>					
            <?php 
                }   
            ?>
                  </h5>
                  <?php } ?>
                  </div>
                  <div class=" <?php if(!in_array(THEME_KEY, array("sp","cm","vt")) ){ ?>small<?php } ?>">
                  
                  
                  <?php
                  
                  if ($GLOBALS['comment_depth'] > 1){ 
            $reply_author = get_comment_author($comment->comment_parent);
            echo '<a href="#comment-' . $comment->comment_parent . '" class="font-weight-bold text-secondary" style="font-size:12px">' . __("RE:", "premiumpress") . ' ' . $reply_author . '</a>';
            
                }
                  
                  echo wpautop($comment->comment_content); ?></div>
                  <?php if(is_array($photo) && strlen($photo['src']) > 1){ ?>
                  <div class="attachment">
                     <a href="<?php echo $photo['src']; ?>" data-toggle="lightbox" data-type="image"><img src="<?php echo $photo['thumb']; ?>" alt="attachment" /></a>
                  </div>
                  <?php } ?>
                  <?php if ($comment->comment_approved == '0') : ?>
                  <p class="small">Your comment is awaiting moderation.</p>
                  <?php endif; ?>
                  <?php } ?>
               </div>
               <?php if(!in_array(THEME_KEY, array("mj","ct","sp","cm","vt")) ){ ?>
               <div class="bottom d-flex">
                  <?php // edit_comment_link(__("Edit","premiumpress"),'',''); ?>
                  <a href="javascript:void(0);" class="reply-link" onclick="showReplyForm(<?php comment_ID(); ?>, '<?php comment_author(); ?>')"><?php echo __("Reply", "premiumpress"); ?></a>
                  <div class="ml-2 small text-muted"><i class="fal fa-calendar mr-2"></i> <?php if(isset($comment->comment_ID)){ echo get_comment_date(); } ?></div>
               </div>
               <?php } ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>