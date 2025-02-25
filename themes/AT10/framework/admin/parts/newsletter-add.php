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
?>


 
  <?php
  
  $settings = array("title" => __("Subscriber Details","premiumpress"), "desc" => __("Here you can manually add/edit a newsletter subscriber.","premiumpress") );
   _ppt_template('framework/admin/_form-wrap-top' ); ?> 
 
 
 

   <div class="card card-admin">
    
     <div class="card-body">
     
      <div class="card-title"><?php echo __("Subscriber Details","premiumpress"); ?></div>
    


 <form method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="newsub" value="<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ echo esc_attr($_GET['eid']); }else{ echo 1; }  ?>" />
  

<div class="form-group mt-4">

<label><?php echo __("Email","premiumpress"); ?></label>
             
  <input type="text" name="news_email" class="form-control" value="<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ echo get_post_meta($_GET['eid'], "news_email", true); }?>">

</div>

<div class="form-group">

<label><?php echo __("Verified","premiumpress"); ?></label>

                  
<select class="form-control" name="news_verified">

<option value="no"><?php echo __("No","premiumpress"); ?></option>

<option value="yes" <?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) && get_post_meta($_GET['eid'], "news_verified", true) == "yes"){ echo "selected=selected"; }?>><?php echo __("Yes","premiumpress"); ?></option>

</select>   
             
  
</div>

<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ ?>
<div class="">
<label><?php echo __("Email Hash","premiumpress"); ?></label>

 <input type="text" name="news_hash" class="form-control" value="<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ echo get_post_meta($_GET['eid'], "news_hash", true); }?>">

<p class="mt-3 text-muted">Test the newsletter confirmation email &amp; process for this user, <a class="link font-weight-bold text-underline" href="<?php echo home_url(); ?>/confirm/mailinglist/<?php if(isset($_GET['eid'])){ echo get_post_meta($_GET['eid'], "news_hash", true); }?>" target="_blank"><u>click here.</u></a></p>

</div>
<?php } ?>

 
 
<div class="p-4 bg-light text-center mt-4">
         <button type="submit" class="btn btn-admin"> <?php echo __("Save Settings","premiumpress"); ?> </button>
    	</div>

</form>

</div></div> 

 
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>


 