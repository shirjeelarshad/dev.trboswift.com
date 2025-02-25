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

global $CORE, $errortext;
 
?>
<?php get_header(); ?>

<main id="main">
  <div class="container ">
    <section>
      <?php if(strlen($errortext) > 1){ ?>
      <div class="alert <?php echo $errorStyle; ?> text-center"><?php echo $errortext; ?></div>
      <?php } ?>
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form name="resetpassform" id="resetpassform" action="<?php echo esc_url( site_url( 'wp-login.php?action=resetpass&key=' . urlencode( $_GET['key'] ) . '&login=' . urlencode( $_GET['login'] ), 'login_post' ) ); ?>" method="post" autocomplete="off">
            <input type="hidden" id="user_login" value="<?php echo esc_attr( $_GET['login'] ); ?>" autocomplete="off" />
            <input type="hidden" name="key" value="<?php echo strip_tags($_GET['key']); ?>" />
            <input type="hidden" name="login" id="user_login" value="<?php echo strip_tags($_GET['login']); ?>" />
            <input type="hidden" name="action" value="resetpass" />
            <div class="form-group">
              <label for="pass1"><?php echo __("New Password","premiumpress") ?><br>
              <input type="password" name="pass1" class="input" size="20" >
              </label>
            </div>
            <div class="form-group">
              <label for="pass2"><?php echo __("Confirm new password","premiumpress") ?><br>
              <input type="password" name="pass2"  class="input" size="20" >
              </label>
            </div>
            <?php do_action( 'resetpassword_form' ); ?>
            <div class="text-center margin-top2 margin-bottom3">
              <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary" value="<?php echo __("Reset Password","premiumpress") ?>">
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
</main>
<?php get_footer(); ?>