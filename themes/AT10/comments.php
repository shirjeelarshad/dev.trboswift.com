<?php
   if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
   
   global $CORE, $post, $userdata;
    
   
if(!_ppt_checkfile("comments.php")){

    
   if ( post_password_required() ) {
   	return;
   }
 

if ( have_comments() && isset($GLOBALS['flag-blog']) ) { ?>

<div class="ppt-comments">
  <h3 class="mb-4"><?php echo get_comments_number(); ?> <?php echo __("Comments","premiumpress"); ?> </h3>
  <ol>
    <?php
      wp_list_comments( array(
          //'per_page'   => 2,
          'max_depth'  => 3,	 
          'avatar_size'=> 34,
          'format'     => 'html5',
          //'callback' => 'html5_comment'
          'walker' => new  ppt_comment_walker,
      ) );
       	
      ?>
  </ol>
</div>
<?php
ob_start();
?>
<textarea id="comment" name="comment" style="min-height:100px;" aria-required="true" class="form-control my-4"></textarea>
<button class="btn btn-primary btn-lg mt-4" type="submit"><?php echo __("Save Comment","premiumpress"); ?></button>
<?php 

$commentfield = ob_get_clean();
$comments_args = array(
	'class_form' 			=> 'container',
	'id_form' 				=> 'blogcomment',
	'label_submit'			=> '',
	'comment_notes_before' 	=> '',
	'title_reply'			=> '', 
	'title_reply_before' 	=> '',
	'comment_notes_after' 	=> '',
	//'submit_field' 			=> '',
	'comment_field' 		=> $commentfield,
	'logged_in_as' 			=> '',
);
comment_form( $comments_args, $post->ID );
?>
<?php }elseif( have_comments() && isset($GLOBALS['flag-single']) ){ ?>

<ol class="list-unstyled pb-0 mb-0">
  <?php
      wp_list_comments( array(
          //'per_page'   => 2,
          'max_depth'  => 3,	 
          'avatar_size'=> 34,
          'format'     => 'html5',
          //'callback' => 'html5_comment'
          'walker' => new  ppt_comment_walker,
      ) );
 
      ?>
</ol>
<?php } ?>
<?php } ?>