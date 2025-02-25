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

if(isset($_GET['eid']) && is_numeric($_GET['eid'])){

$postf = get_post($_GET['eid']);
$postid = get_post_meta($_GET['eid'], "log_postid", true);

$log_email = get_post_meta($_GET['eid'], "log_email", true);

}


?>
<?php
  
  $settings = array("title" => "Log Details", "desc" => "Here you can add/edit a new log entery.");
   _ppt_template('framework/admin/_form-wrap-top' ); ?>

<div class="card card-admin">
  <div class="card-body">
    <?php if(isset($_GET['eid']) && is_numeric($_GET['eid'])){ ?>
    <div class="float-right small"><i class="fal fa-clock"></i> <?php echo $postf->post_date; ?></div>
    <?php } ?>
    <div class="card-title"><?php echo __("Log Details","premiumpress"); ?></div>
    <form method="post" action="" enctype="multipart/form-data">
      <input type="hidden" name="newlog" value="<?php if(isset($_GET['eid'])){ echo esc_attr($_GET['eid']); }else{ echo 1; }  ?>" />
      <div class="row">
        <div class="form-group col-12 mt-4">
          <label><?php echo __("Type","premiumpress"); ?></label>
          <div class="input-group">
            <select class="form-control" name="log[log_type]">
              <?php foreach(  $CORE->FUNC("get_logtype", array() ) as $k => $n){
			  
			  if($n['name'] == "%f"){ continue; }
			    ?>
              <option value="<?php echo $k; ?>" <?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'], "log_type", true) == $k){ echo "selected=selected"; }?>><?php echo $n['name']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <!-- end row -->
      <div class="form-group">
        <label><?php echo __("Details","premiumpress"); ?></label>
        <textarea style="height:250px !important;" name="details" class="form-control"><?php if(isset($_GET['eid'])){ echo $postf->post_content; }?>
</textarea>
      </div>
      <div class="row mt-4">
        <div class="form-group col-6">
          <label><?php echo __("To User","premiumpress"); ?></label>
          <div class="input-group">
            <div class="input-group-prepend"> <span class="input-group-text"> <i class="fal fa-user"></i> </span> </div>
            <input name="log[log_to]" class="form-control"  type="text" value="<?php if(isset($_GET['eid'])){ echo get_post_meta($_GET['eid'], "log_to", true); }?>">
          </div>
        
        
        <?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'], "log_from", true) != ""){  ?>
        
          <label class="mt-4"><?php echo __("From User","premiumpress"); ?></label>
          <div class="input-group">
            <div class="input-group-prepend"> <span class="input-group-text"> <i class="fal fa-user"></i> </span> </div>
            <input name="log[log_from]" class="form-control"  type="text" value="<?php if(isset($_GET['eid'])){ echo get_post_meta($_GET['eid'], "log_from", true); }?>">
          </div>
          
          <?php } ?>
          
          
           <?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'], "log_emailid", true) != ""){  ?>
        
          <label class="mt-4"><?php echo __("Email ID","premiumpress"); ?></label>
          <div class="input-group">
            <div class="input-group-prepend"> <span class="input-group-text"> <i class="fal fa-envelope"></i> </span> </div>
            <input name="log[log_emailid]" class="form-control"  type="text" value="<?php if(isset($_GET['eid'])){ echo get_post_meta($_GET['eid'], "log_emailid", true); }?>">
          </div>
          
          <?php } ?>
          
          
        </div>
        <div class="form-group col-6">
         
          <div <?php if(isset($_GET['eid']) && $postid == ""){  ?>style="display:none;"<?php } ?>>
            <label><?php echo __("Post","premiumpress"); ?></label>
            <div class="input-group">
              <div class="input-group-prepend"> <span class="input-group-text"> # </span> </div>
              <input name="log[log_postid]" class="form-control"  type="text" value="<?php if(isset($_GET['eid'])){ echo $postid;  }?>">
            </div>
          </div>
          
          
          
          <div <?php if(isset($_GET['eid']) && $log_email == ""){  ?>style="display:none;"<?php } ?>>
            <label><?php echo __("Email Address","premiumpress"); ?></label>
            <div class="input-group">
              <div class="input-group-prepend"> <span class="input-group-text"> @ </span> </div>
              <input name="log[log_email]" class="form-control"  type="text" value="<?php if(isset($_GET['eid'])){ echo $log_email;  }?>">
            </div>
          </div>
        </div>
      </div>
      <!-- end row -->
      <div class="p-4 bg-light text-center mt-4">
        <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
      </div>
    </form>
  </div>
</div>
</div>
</div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
