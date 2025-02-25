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

// PACKAGE ID
$selectedID = "";
if(isset($_GET['eid'])){ $selectedID = get_post_meta($_GET['eid'],'packageID', true);  } 
if(!is_numeric($selectedID)){ $selectedID = 0; }
 

$show_edit_packageid = false;
$show_renew = false;
$show_invoices = false;

if( $CORE->LAYOUT("captions","listings") ){
 
	//1. display packages
	$show_edit_packageid = true;	
	
	//2. display renew
	$show_renew = false;
	
	//3. check for paid invoice
	$show_invoices = false;
	if(isset($_GET['eid'])){
	
		$g = $CORE->ORDER('get_listing_orders', $_GET['eid']);
	 
		if(is_array($g) && !empty($g)){
			$show_invoices = true;
				
				// CHECK IF ORDER IS PAID
				foreach($g as $invoice){ 
					if($invoice['status'] == 1){ // paid
						
						$show_edit_packageid = false;
						$show_renew = true;
						
					}
				}
			
		}
	}

}

if(isset($_GET['repost'])){
$show_invoices = false;
}

if(function_exists('current_user_can') && current_user_can('administrator')){
$show_edit_packageid = true;
}

if(_ppt(array('lst','websitepackages')) == '1'  && THEME_KEY != "sp" && !empty($CORE->PACKAGE("get_packages", array())) ){
?>

 
<div id="packagessection" <?php if(is_admin() || isset($_GET['eid'])){ }else{ ?>style="display:none;"<?php } ?>>

<hr style="margin: 20px -20px 15px -20px;" />

<h6 class="mb-3"><?php if(is_admin() ){ echo __("Package","premiumpress"); }else{ echo str_replace("%s", $CORE->LAYOUT("captions","1"), __("Upgrade %s Package","premiumpress")); } ?></h6>


<?php foreach(  $CORE->PACKAGE("get_packages", array() ) as $k => $n){  

 if(!is_admin() && isset($_GET['eid']) && $n['price'] == 0){ continue; }

?>

 
    <label class="custom-control custom-radio  pb-2">
    
    <input <?php if(!$show_edit_packageid) { ?>disabled<?php } ?> type="radio" id="radiopak<?php echo $n['key']; ?>" onclick="updatePackageID(this.value)" class="pakid-val form-control custom-control-input " name="pakid" value="<?php echo $n['key']; ?>"  
    <?php if($selectedID == $n['key']){ echo "checked=checked"; } ?> required>
    
    
    <div class="custom-control-label"><span style="max-width: 200px;    display: inline-block;"><?php echo $CORE->GEO("translate_pak_name", array( stripslashes($n['name']), $n['key'])  ); ?></span>
      
	  
      <?php if(!isset($_GET['repost']) && isset($_GET['eid']) && $selectedID == $n['key'] ){ ?>
      
      <span class="span-green small float-right"><?php echo __("Enabled","premiumpress"); ?></span>
      
      <?php }else{ ?>
      
		  <?php  if(!defined('WLT_CART')){ ?>
          <?php if($n['price'] == "0"){ ?>
          <b class="float-right"><?php echo __("Free","premiumpress"); ?></b>
          <?php }else{ ?>
          <b class="float-right <?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo $n['price']; ?> </b>
          <?php } ?>
          <?php } ?>
      
      <?php } ?>
      
    </div>
    </label>
 

<?php } ?>
<input type="hidden" class="form-control" name="packageID" id="packageID" value="<?php echo $selectedID; ?>" />
</div>
<?php } ?>





<?php if(function_exists('current_user_can') && current_user_can('administrator') && is_admin()   ){ ?>



<?php if(THEME_KEY == "es"){ ?>
<hr style="margin: 0px -20px 15px -20px;" />
<h6><?php echo __("Verifiy Photos","premiumpress"); ?></h6>

<select class="form-control mb-4" name="custom[photosverified]">
  
  <option value="0" ><?php echo __("Not Verified","premiumpress"); ?></option>
  <option value="1"  <?php if( isset($_GET['eid']) && get_post_meta($_GET['eid'], 'photosverified', true) == 1  ){ echo "selected=selected"; } ?> ><?php echo __("Verified","premiumpress"); ?></option>


</select>

<?php } ?> 





<hr style="margin: 0px -20px 15px -20px;" />
<h6><?php echo __("Listing Status","premiumpress");

if(isset($_GET['eid'])){
$cstatus = $CORE->PACKAGE("get_status_db", $_GET['eid']);
}


 ?></h6>
<select class="form-control mb-4" name="form[post_status]">
  <?php $i=1; foreach($CORE->PACKAGE("get_status", array() ) as $cat){  ?>
  <option value="<?php echo strtolower($cat['key']); ?>"  <?php if( isset($_GET['eid']) &&  strtolower($cstatus) == strtolower($cat['key']) ){ echo "selected=selected";  }elseif(!isset($_GET['eid']) && $i == 1){ echo "selected=selected";  }  ?>><?php echo $cat['name']; ?></option>
  <?php $i++; } ?>
</select>
<?php } ?>
<?php if(function_exists('current_user_can') && current_user_can('administrator') && $CORE->LAYOUT("captions","listings") && is_admin() ){ ?>
<hr style="margin: 0px -20px 15px -20px;" />

<a href="javascript:void(0);" class="small float-right" onclick="jQuery('#live_auction_start_date').val('<?php echo date('Y-m-d H:i:s', strtotime(current_time( 'mysql' ) . "+1 minutes")); ?>');">Time Now + 1 minutes</a>
<h6><?php echo __("Live Auction Time","premiumpress") ?></h6>
<div class="input-group date mb-3" id="live-auction-date">
  <input type="text"        
            name="custom[live_auction_start_date]"  id="live_auction_start_date"
            tabindex=""  
            value="<?php if( isset($_GET['eid']) ){ echo get_post_meta($_GET['eid'] ,'live_auction_start_date', true);  }  ?>"  
            class="form-control form-control-sm rounded-0">
  <span class="input-group-addon" style="top: 10px;    right: 10px;    position: absolute;    z-index: 100;"> <span class="fal fa-calendar"></span> </span> </div>
<script> jQuery(document).ready(function(){   jQuery('#live-auction-date').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss', pickTime: false, fontAwesome: 1,  todayBtn: true, pickerPosition: "bottom-right"}); }); </script>
<?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'] ,'live_auction_start_date', true) != ""){ ?>
<p><?php echo __("Live Aution Time","premiumpress"); ?>: <?php echo get_post_meta($_GET['eid'] ,'live_auction_start_date', true); ?></p>
<?php } ?>


<a href="javascript:void(0);" class="small float-right" onclick="jQuery('#listing_expiry_date').val('<?php echo date('Y-m-d H:i:s', strtotime(current_time( 'mysql' ) . "+1 days")); ?>');">Time Now + 1 days</a>

<h6><?php echo __("Timed Auction Time","premiumpress") ?></h6>
<div class="input-group date mb-3" id="expiry-date">
  <input type="text"        
            name="custom[listing_expiry_date]"  id="listing_expiry_date"
            tabindex=""  
            value="<?php if( isset($_GET['eid']) ){ echo get_post_meta($_GET['eid'] ,'listing_expiry_date', true);  }  ?>"  
            class="form-control form-control-sm rounded-0">
  <span class="input-group-addon" style="top: 10px;    right: 10px;    position: absolute;    z-index: 100;"> <span class="fal fa-calendar"></span> </span> </div>
<script> jQuery(document).ready(function(){   jQuery('#expiry-date').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss', pickTime: false, fontAwesome: 1,  todayBtn: true, pickerPosition: "bottom-right"}); });
	

	
</script>

<?php } ?>
<!--------------- INVOICES FOUND --->
<?php if($show_invoices){ ?>
<hr style="margin: 0px -20px 15px -20px;" />
<h6><?php echo __("Invoices","premiumpress") ?></h6>
<?php foreach($g as $invoice){   ?>
<dl class="d-flex justify-content-between align-items-center small">
  <span><a href="<?php echo THEME_URI; ?>/_invoice.php?invoiceid=<?php echo $invoice['id']; ?>" target="_blank">#<?php echo $invoice['id_formatted']; ?></a> <em class="text-muted">(<?php echo hook_price($invoice['total']); ?>)</em></span>
  <?php if(is_admin()){ ?>
  <a href="admin.php?page=orders&invoiceid=<?php echo $invoice['id']; ?>"><span class="<?php if($invoice['status'] == 1){ ?>span-green<?php }elseif($invoice['status'] == 2){ ?>span-red<?php }else{ ?>span-grey<?php } ?>"><?php echo $invoice['status_formatted']['name']; ?></span></a>
  <?php }else{   ?>
  <span class="<?php if($invoice['status'] == 1){ ?>span-green<?php }elseif($invoice['status'] == 2){ ?>span-red<?php }else{ ?>span-grey<?php } ?>"><?php echo $invoice['status_formatted']['name']; ?></span>
  <?php } ?>
</dl>
<?php } ?>
<?php } ?>