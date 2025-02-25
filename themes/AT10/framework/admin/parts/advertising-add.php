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

$allbanners = $CORE->ADVERTISING("get_all_banners", array());


  $settings = array(
  "title" => __("Advertising Details","premiumpress"), 
  "desc" => __("Here you can design your page content by selecting blocks for each space.","premiumpress"),
  
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>

<div class="card card-admin">
  <div class="card-body">
    <div class="card-title"><?php echo __("Campaign Details","premiumpress"); ?></div>
    <form method="post" action="" enctype="multipart/form-data">
      <input type="hidden" name="newcampaign" value="<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ echo esc_attr($_GET['eid']); }else{ echo 1; }  ?>" />
      <div class="row mt-4">
        <div class="form-group col-6">
          <label><?php echo __("Campaign Location","premiumpress"); ?></label>
          <div class="input-group mt-2">
            <select name="campaign[location]" class="form-control" >
              <?php foreach($CORE->ADVERTISING("get_spaces", array() ) as $key => $ban){ ?>
              <option value="<?php echo $key; ?>" <?php if( isset($_GET['eid']) && get_post_meta($_GET['eid'], "location", true) == $key){ echo "selected=selected"; } ?>><?php echo $ban['n']; ?> (<?php echo $ban['sw']; ?>x<?php echo $ban['sh']; ?>px)</option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group col-6">
          <label><?php echo __("Banner Image","premiumpress"); ?></label>
          <div class="input-group mt-2">
          <?php if(!empty($allbanners)){ ?>
          
            <select name="campaign[bannerid]" class="form-control" >
              <?php foreach($allbanners as $key => $ban){ ?>
              <option value="<?php echo $ban['id']; ?>" <?php if( isset($_GET['eid']) && get_post_meta($_GET['eid'], "bannerid", true) == $ban['id']){ echo "selected=selected"; } ?>><?php echo $ban['name']; ?> (<?php echo $ban['w']; ?>x<?php echo $ban['h']; ?>px)</option>
              <?php } ?>
            </select>
            <?php }else{ ?>
            <div class="text-center text-muted mb-2"><i class="fal fa-exclamation-circle"></i> <?php echo __("No banners uploaded.","premiumpress"); ?></div>
             
            <a href="#banners" id="ideas-box1" data-targetdiv="banners" class="btn btn-sm btn-system customlist"><i class="fal fa-plus"></i> <?php echo __("Add Banner","premiumpress"); ?></a>
            
            <?php } ?>
          </div>
        </div>
      </div>
      <!-- end row -->
      <div class="col-12 px-0 border-top   py-3">
        <div class="form-group ">
          <label><?php echo __("Banner Code","premiumpress"); ?></label>
          <div class="input-group mt-2">
            <div class="input-group-prepend"> </div>
            <textarea name="campaign[code]" class="form-control" style="height:100px !important;"><?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ echo get_post_meta($_GET['eid'], "code", true); } ?>
</textarea>
          </div>
          <p class="mt-2 text-muted"><?php echo __("If set, this will be used instead of the banner image.","premiumpress"); ?></p>
        </div>
      </div>
      <div class="col-12 px-0 border-top border-bottom py-3">
        <div class="form-group ">
          <label><?php echo __("Banner Link","premiumpress"); ?></label>
          <div class="input-group mt-2">
            <div class="input-group-prepend"> </div>
            <input name="campaign[url]" class="form-control"  type="text" value="<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ echo get_post_meta($_GET['eid'], "url", true); } ?>" placeholder="https://...">
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-6">
          <div class="form-group ">
            <label><?php echo __("Campaign End Date","premiumpress"); ?></label>
            <div class="input-group date mt-2 position-relative"  id="expiry-date">
              <input name="campaign[expires]" class="form-control"  type="text" value="<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ echo get_post_meta($_GET['eid'], "expires", true); }?>">
              <span class="input-group-addon" style="top: 10px;    right: 10px;    position: absolute;    z-index: 100;"> <span class="fal fa-calendar"></span> </span> </div>
          </div>
          <script>
jQuery(document).ready(function() {  

	jQuery('#expiry-date').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss',   
	autoclose: true,
                todayHighlight: true,
               // showMeridian: true,
                startView: 2,
                maxView: 1,  
				pickTime: false, buttonText: '<i class="fa fa-cog"></i>', fontAwesome: 1,  todayBtn: true, pickerPosition: "bottom-right"});

 
});


</script>
          <div class="form-group">
            <div class="form-group">
              <label><?php echo __("Campaign Status","premiumpress"); ?></label>
              <select name="campaign[status]" class="form-control">
                <?php
// ORDER STATUS
 
foreach( $CORE->ADVERTISING("campaign_status", array()) as $k => $n){
?>
                <option value="<?php echo $k; ?>" <?php if(isset($_GET['eid'])){  selected( get_post_meta($_GET['eid'], "status", true), $k ); }  ?>><?php echo $n['name']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group mb-3">
            <label><?php echo __("Banner Clicks","premiumpress"); ?></label>
            <div class="input-group mt-2">
              <div class="input-group-prepend"> <span class="input-group-text"> # </span> </div>
              <input name="campaign[clicks]" class="form-control numericonly"  type="text" value="<?php if(isset($_GET['eid'])){ echo get_post_meta($_GET['eid'], "clicks", true); }else{ echo 0; } ?>">
            </div>
          </div>
          <div class="form-group">
            <label><?php echo __("Banner Impressions","premiumpress"); ?></label>
            <div class="input-group">
              <div class="input-group-prepend"> <span class="input-group-text"> # </span> </div>
              <input name="campaign[impressions]" class="form-control numericonly"  type="text" value="<?php if(isset($_GET['eid'])){ echo get_post_meta($_GET['eid'], "impressions", true); }else{ echo 0; } ?>">
            </div>
          </div>
          <div class="form-group ">
            <label><?php echo __("User ID","premiumpress"); ?></label>
            <div class="input-group">
              <div class="input-group-prepend"> <span class="input-group-text"> <i class="fa fa-user"></i> </span> </div>
              <input name="campaign[userid]" class="form-control numericonly"  type="text" value="<?php if(isset($_GET['eid'])){ echo get_post_meta($_GET['eid'], "userid", true); }else{ echo 0; } ?>">
            </div>
          </div>
        </div>
        <!-- end row -->
      </div>
      <div class="p-4 bg-light text-center mt-4">
        <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
      </div>
    </form>
  </div>
</div>
<?php if(isset($_GET['eid'])){  ?>
<hr />
<h4><?php echo __("Banner Preview","premiumpress"); ?></h4>
<?php $img = $CORE->ADVERTISING("banner_image", get_post_meta($_GET['eid'], "bannerid", true)); ?>
<a href="<?php echo $CORE->ADVERTISING("get_banner_link", $_GET['eid'] ); ?>" target="_blank"> <img src="<?php echo $img; ?>" class="img-fluid"/> </a>
<?php } ?>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
