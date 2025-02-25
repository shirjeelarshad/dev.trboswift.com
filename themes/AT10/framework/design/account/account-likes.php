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

global $CORE, $userdata; $showDashboard = true; 

$listing_ids = $CORE->PACKAGE("get_user_listing_ids", $userdata->ID);
 
?>

<?php if(empty($listing_ids)){ ?>

<div class="card">
  <div class="card-body">
    <div class="bg-light p-4 text-center"> <i class="fal fa-frown"></i> <?php echo __("You do not have any profiles to like.","premiumpress") ?> </div>
  </div>
</div>

<?php }elseif($CORE->USER("membership_hasaccess", "liked") != 1){ ?>

    <div class="bg-white y-middle">
      <div class="p-4 text-center">
        <h4><i class="fal fa-lock mr-2"></i> <?php echo __("No Access","premiumpress"); ?></h4>
        <div class="mt-4 small"><?php echo __("Please upgrade your membership to access this feature.","premiumpress"); ?></div>
        <a href="javascript:void(0);" onclick="SwitchPage('membership');" class="btn btn-system btn-md mt-4"><?php echo __("View My Membership","premiumpress"); ?></a> </div>
    </div>

<?php }else{ ?>



   
   
   <?php foreach($listing_ids as $id){ 
   
   $hits = get_post_meta($id,'hits', true);
   if(!is_numeric($hits)){ $hits = 0; }
   
   ?>
   <div class="card mb-5">
  <div class="card-body">
   
   <a href="<?php echo get_permalink($id); ?>" class="btn btn-system btn-sm float-right" target="_blank"><?php echo __("View Profile","premiumpress") ?></a>
   
   <h4><?php echo get_the_title($id); ?></h4>
   
   <p><?php echo __("Total profile visitors:","premiumpress") ?> <?php echo number_format($hits); ?></p>
<hr />


  <?php 
  
	  $f = get_post_meta($id, 'likes_array', true);
	  if(is_array($f) && !empty($f) ){
	  ?>

          <?php
	  foreach( $f as $u){
	  if(!isset($u['userid'])){ continue; }
	  
	       $day 	= date("d", strtotime($u['date']));
		   $month 	= date("M", strtotime($u['date']));
		   $year 	= date("Y", strtotime($u['date']));
	  ?>
         
          <div class="border-bottom mb-2 pb-2">
            <div class="row">
              <div class="col-md-8"> 
              
              <a href="<?php echo $CORE->USER("get_user_profile_link", $u['userid']); ?>"> <img src="<?php echo $CORE->USER("get_avatar", $u['userid']); ?>" width="26" height="26" class="mr-2" alt="user" /> <small><?php echo $CORE->USER("get_username", $u['userid']); ?></small> </a> 
              
              
              </div>
              
              <div class="col-md-4 small">
                <time datetime="<?php echo $u['date']; ?>"><?php echo $month; ?> <?php echo $day ; ?></time>
              </div>
              
            </div>
          </div>
          
          
          
          <?php } }else{ ?>

<p class="opacity-5"> <i class="fal fa-frown"></i> <?php echo __("No likes recorded.","premiumpress") ?></p>
<?php } ?>
   
   
     </div>
</div>
   
   
   <?php } ?>
   
   





<?php } ?>
