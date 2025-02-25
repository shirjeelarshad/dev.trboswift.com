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

global $CORE, $userdata; $showDashboard = true;?>
<?php

 
//$gg = $CORE->USER("get_subscribers_followingme", $userdata->ID);
  


// COUNT ONLINE USERS
 $gg = $CORE->USER("get_subscribers_followers", $userdata->ID);
  
 if(count($gg) > 0){ ?>

<div class="row">
  <?php foreach($gg  as $g){ 
 
 $plink = $CORE->USER("get_user_profile_link", $g);
 ?>
  <div class="col-md-4">
    <div class="card friendcard">
      <div class="card-body text-center">
      
      <a href="javascript:void(0)" onclick="processMessage(<?php echo $g; ?>)"> 
	  <?php echo $CORE->USER("get_photo", $g); ?>
      </a>
        <h4 class="mt-2"> <a href="<?php echo $plink; ?>" class="text-dark" style="text-decoration:underline;"><?php echo $CORE->USER("get_username", $g); ?></a></h4>
        <div class="small">
          <div class="title"><?php echo __("Last Login","premiumpress"); ?></div>
          <div class="mt-2">
            <?php echo $CORE->USER("get_lastlogin", $g); ?>
          </div>
        </div>
        <hr />
        <?php echo do_shortcode('[SUBSCRIBE class="btn btn-system btn-md mt-2" count=0 text=1 uid="'.$g.'"]'); ?> </div>
    </div>
  </div>
  <?php } ?>
  


<div class="col-md-12">
  <hr />
  
  <div class="bg-light p-4 text-center" id="deleteallfriendsmsg" style="display:none;"> <i class="fal fa-frown"></i> <?php echo __("You have not added any friends yet.","premiumpress") ?> </div>
  
  <a href="javascript:void(0);" class="btn btn-system friendcard" onclick="ajax_delete_subscribers();"><?php echo __("Delete All Friends","premiumpress") ?> </a>
  
<script> 
jQuery(document).ready(function(){ 

	 jQuery(".menu-alert-friends").html("<?php echo count($gg); ?>").show();

});
	 
   
   function ajax_delete_subscribers(){
   
       jQuery.ajax({
           type: "POST",
           url: '<?php echo home_url(); ?>/',		
   		data: {
               action: "subscribe_deleteall",
			   uid: "<?php echo $userdata->ID; ?>",
   		 
           },
           success: function(response) {	
		 		jQuery('.friendcard').hide();
		 		jQuery("#deleteallfriendsmsg").show();
           },
           error: function(e) {
               console.log(e)
           }
       });
   
   }
</script>
  
</div>
</div>
<?php }else{ ?>
<div class="card">
  <div class="card-body">
    <div class="bg-light p-4 text-center"> <i class="fal fa-frown"></i> <?php echo __("You have not added any friends yet.","premiumpress") ?> </div>
  </div>
</div>
<?php } ?>
