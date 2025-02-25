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

global $CORE, $userdata;


// GET USER MEMBERSHIP
$mem = $CORE->USER("get_user_membership", $userdata->ID);

?>

<div class="container px-0 mx-0">
  <div class="row">
    <?php if(isset($_GET['noaccess'])){ ?>
    <div class="col-md-12">
      <div class="p-4 text-center bg-danger text-light mb-4">
        <h4><i class="fa fa-lock mr-2"></i> <?php echo __("No Access","premiumpress"); ?></h4>
        <div class=" p-3"><?php echo __("Please upgrade your membership to access this feature.","premiumpress"); ?></div>
      </div>
    </div>
    <?php if(isset($_GET['op']) && $_GET['op'] == "listings_max" && current_user_can('administrator')){ ?>
    <div class="col-md-12">
      <div class="p-4 text-center bg-info text-light mb-4">
        <div class="col-md-10 mx-auto">
          <h4> <i class="fa fa-info-circle"></i> <?php echo __("Admin Only Notice (not visible to users)","premiumpress"); ?> </h4>
          <p> <?php echo __("If you think the 'no access' message above is error - please check your membership settings under - max listing credit.","premiumpress"); ?> </p>
          <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=membershipsetup" class="btn btn-dark">Go now</a> </div>
      </div>
    </div>
    <?php } ?>
    <?php } ?>
    <?php if(!is_array($mem)){ ?>
    <div class="col-12">
      <div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> <?php echo __("You have no active membership.","premiumpress"); ?></div>
    </div>
    <div class="col-12">
      <?php $GLOBALS['no-mem-header'] =1; _ppt_template( 'page-login-memberships' ); ?>
    </div>
    <?php } ?>
    <?php if(is_array($mem)){ ?>
    <div class="col-md-8">
      <?php 
	  
$da = $CORE->date_timediff($mem['date_expires'],'');
  
$subdata = $CORE->USER("get_this_membership",$mem['key']); 
?>
      <div class="card mb-4">
        <div class="card-body"> <a class="float-right badge badge-success" href="<?php echo _ppt(array('links','memberships')); ?>?upgrade=1"> <?php echo __("Upgrade Now","premiumpress"); ?></a>
          <h3 class="mb-4"><?php echo $mem['name']; ?> <?php echo __("Membership","premiumpress"); ?> </h3>
          <?php 
	  
  if( isset($mem['user_approved']) && $mem['user_approved'] == "0"){
  
 ?>
          <div class="mt-n3 mb-2"> <span class="inline-flex items-center mt-n3 font-weight-bold order-status-icon status-4" onclick="SwitchPage('membership');" style="cursor:pointer;"> <span class="dot mr-2"></span> <span class="pr-2px leading-relaxed whitespace-no-wrap"><?php echo __("Pending Approval","premiumpress"); ?> </span> </span> </div>
          <?php } ?>
          <?php  if( isset($mem['user_approved']) && $mem['user_approved'] == "0"){ ?>
          <p class="mt-4"><?php echo __("Your membership upgrade is pending admin approval. As soon as it has been approved your account will be upgraded.","premiumpress"); ?></p>
          <p><?php echo __("Thank you for your patience.","premiumpress"); ?></p>
          <?php } ?>
          <ul class="payment-right large list-unstyled mt-4" <?php  if( isset($mem['user_approved']) && $mem['user_approved'] == "0"){ ?>style="display:none;"<?php } ?>>
            <li>
              <div class="left"><?php echo __("Expires","premiumpress"); ?>:</div>
              <div class="right"> <?php echo hook_date($mem['date_expires']); ?> </div>
              <div class="clearfix"></div>
            </li>
            <li>
              <div class="left"><?php echo __("Time Left","premiumpress"); ?>:</div>
              <div class="right">
                <?php
           
            if($da['expired'] == 0){
             
            	echo $da['string'];
            	
            }else{
            
            	echo __("has expired!","premiumpress");
            
            }
            
            ?>
              </div>
              <div class="clearfix"></div>
            </li>
            <?php foreach($CORE->USER("membership_features", array()) as $f){ 
			
			
			if( _ppt($subdata['key']."_".$f['key']."_hide") == "1" || _ppt("mem".$subdata['key']."_".$f['key']."_hide") == "1" ){ continue; }
			
			 ?>
            <li>
              <div class="left">
                <?php if($f['key'] == " listings"){ 
			  	
				$fc = _ppt('mem'.$subdata['key'].'_listings_count');
				
				echo str_replace("%s", $CORE->LAYOUT("captions","2"),  __("Free %s","premiumpress"))."("; if(!is_numeric($fc)){ echo 0; }else{ echo $fc; } echo ")";
			  	
				}elseif($f['key'] == "listings_max"){ 
			  	
				$fc = _ppt('mem'.$subdata['key'].'_listings_max_count');  
				
				echo str_replace("%s", $CORE->LAYOUT("captions","2"), __("Maximum %s","premiumpress"))."(";if(!is_numeric($fc)){ echo 0; }else{ echo $fc; } echo ")";
			  	
				}elseif($f['key'] == "max_msg"){ 
			  	
				$fc = _ppt('mem'.$subdata['key'].'_max_msg_count');
				
				echo __("Max Messages","premiumpress")." (";
				
				if(!is_numeric($fc)){ echo 0; }else{ echo $fc; } echo ")";
				
				}else{
				
				echo $f['name'];			  
			  
			  	} ?>
              </div>
              <div class="right">
                <?php if($CORE->USER("membership_hasaccess", $f['key'])){  ?>
                <span class="inline-flex items-center font-weight-bold order-status-icon status-1"> <span class="dot mr-2"></span><span class="pr-2px leading-relaxed whitespace-no-wrap"><?php echo __("Active","premiumpress"); ?></span> </span>
                <?php }else{ ?>
                <span class="inline-flex items-center font-weight-bold order-status-icon status-2"> <span class="dot mr-2"></span><span class="pr-2px leading-relaxed whitespace-no-wrap"><?php echo __("Inactive","premiumpress"); ?></span> </span>
                <?php } ?>
              </div>
              <div class="clearfix"></div>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-4 pl-lg-5">
      <?php if(isset($da) && is_array($da) && $da['expired'] == 0){
	   
	   ?>
      <div class="card text-center mb-4">
        <div class="card-header bg-white"><?php echo __("Membership Expires","premiumpress"); ?></div>
        <div class="card-body">
          <h4> <?php echo number_format($da['days-left']); ?> <?php echo __("Days","premiumpress"); ?></h4>
          <?php if($da['days-left'] < 5){ ?>
          <div class="small mt-2 text-muted"><?php echo str_replace(round($da['date_array']['months'],1)." ".__("Months","premiumpress"),"", str_replace($da['date_array']['days']." ".__("Days","premiumpress"),"", $da['string'])); ?></div>
          <?php } ?>
        </div>
      </div>
      <?php } ?>
      <?php if( is_array($mem) && $CORE->USER("membership_hasaccess", "listings") && _ppt(array('lst','websitepackages')) == "1" ){ $fc = _ppt('mem'.$subdata['key'].'_listings_count'); if(!is_numeric($fc)){ $fc = 0; }   ?>
      <div class="card text-center mb-4">
        <div class="card-header bg-white"><?php echo str_replace("%s", $CORE->LAYOUT("captions","1"),__("Free %s Credit","premiumpress")); ?></div>
        <div class="card-body">
          <h4> <?php echo $CORE->USER("get_user_free_membership_addon", array("listings", $userdata->ID)); ?> <?php echo __("Left","premiumpress"); ?></h4>
          <div class="small mt-2 text-muted"><?php echo $fc; ?> <?php echo __("included","premiumpress"); ?> </div>
        </div>
      </div>
      <?php } ?>
      <?php if( is_array($mem) && $CORE->USER("membership_hasaccess", "listings_max") && _ppt(array('lst','websitepackages')) == "1" ){ $fc = _ppt('mem'.$subdata['key'].'_listings_max_count'); if(!is_numeric($fc)){ $fc = 0; }   ?>
      <div class="card text-center mb-4">
        <div class="card-header bg-white"><?php echo str_replace("%s", $CORE->LAYOUT("captions","2"),__("Max %s","premiumpress")); ?></div>
        <div class="card-body">
          <h4> <?php echo $CORE->USER("get_user_free_membership_addon", array("listings_max", $userdata->ID)); ?> <?php echo __("Left","premiumpress"); ?></h4>
          <div class="small mt-2 text-muted"><?php echo $fc; ?> <?php echo __("included","premiumpress"); ?> </div>
        </div>
      </div>
      <?php } ?>
      <?php if( is_array($mem) && $CORE->USER("membership_hasaccess", "max_msg") && _ppt(array('lst','websitepackages')) == "1" ){ $fc = _ppt('mem'.$subdata['key'].'_max_msg_count'); if(!is_numeric($fc)){ $fc = 0; }   ?>
      <div class="card text-center mb-4">
        <div class="card-header bg-white"><?php echo __("Max Messages","premiumpress"); ?></div>
        <div class="card-body">
          <h4> <?php echo $CORE->USER("get_user_free_membership_addon", array("max_msg", $userdata->ID)); ?> <?php echo __("Left","premiumpress"); ?></h4>
          <div class="small mt-2 text-muted"><?php echo $fc; ?> <?php echo __("included","premiumpress"); ?> </div>
        </div>
      </div>
      <?php } ?>
      <?php if( THEME_KEY == "so" ){ $fc = _ppt('mem'.$subdata['key'].'_downloads_count'); if(!is_numeric($fc)){ $fc = 0; }   ?>
      <div class="card text-center mb-4">
        <div class="card-header bg-white"><?php echo __("Free Downloads","premiumpress"); ?></div>
        <div class="card-body">
          <h4> <span id="freedownloads"><?php echo $CORE->USER("get_user_free_membership_addon", array("downloads", $userdata->ID)); ?></span> <?php echo __("Left","premiumpress"); ?></h4>
          <div class="small mt-2 text-muted"><?php echo $fc; ?> <?php echo __("included","premiumpress"); ?> </div>
        </div>
      </div>
      <?php } ?>
      <a href="javascript:void(0);" class="btn btn-warning mt-4 btn-block btn-lg mobile-mb-6" onclick="ajax_cancel_membership();"><?php echo __("Cancel My Membership","premiumpress"); ?></a>
      <script>
   function ajax_cancel_membership(){
   
   if (window.confirm("<?php echo __("Are you sure? This action cannot be undone.","premiumpress"); ?>")) {
          
		
       jQuery.ajax({
           type: "POST",
           url: '<?php echo home_url(); ?>/',		
   		data: {
            action: "cancel_membership",
   			uid: "<?php echo $userdata->ID; ?>",
   			
           },
           success: function(response) {
   			
   			  location.href = "<?php echo _ppt(array('links','myaccount')); ?>";        
   			
           },
           error: function(e) {
               console.log(e)
           }
       });
   }
   }
</script>
    </div>
    <?php } ?>
  </div>
</div>