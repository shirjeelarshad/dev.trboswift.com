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

if(!_ppt_checkfile("ajax-modal-location.php")){  
 	 
	// MY LOCATION SETUP
	if(isset($_SESSION['mylocation'])){
		$country 	= $_SESSION['mylocation']['country'];
		$address 	= $_SESSION['mylocation']['address'];
		$lat 		= $_SESSION['mylocation']['lat'];
		$log 		= $_SESSION['mylocation']['log'];
		$zip 		= $_SESSION['mylocation']['zip'];
	}else{
		$address 	= "";
		$country 	= "GB";
		$lat		= "";
		$log 		= "";
		$zip 		= "";
	} 
?>

 
<div class="modal-dialog" role="document" >
   <div class="modal-content">
      <div class="loginform ajax_modal" id="loginform">
         <div class="modal-body p-0">
            
            <div class="mb-2">
               <button type="button" class="close modalclose" data-dismiss="modal" aria-label="Close" onclick="jQuery('.modal-backdrop').hide();" style="cursor:pointer; width:40px;">
               <span aria-hidden="true">&times;</span>
               </button>
               <h4 class="title"><?php echo __("Where are you now?","premiumpress") ?></h4>
               <p class="small"><?php echo __("Set your location by enter your zipcode below or searching the map.","premiumpress"); ?></p>
            </div>
            
            
            	<hr />
	
	<div id="ppt_google_mylocation_map" style="height:300px; width:100%;"></div>
            
            
            		
	<form method="post" action="#" name="mylocationsform" id="mylocationsform">
	<input type="hidden" name="updatemylocation" value="1" />
	<input type="hidden" name="log" value="<?php echo $log; ?>" id="mylog" />
	<input type="hidden" name="lat" value="<?php echo $lat; ?>" id="mylat" />
	<input type="hidden" name="country" value="<?php echo $country; ?>" id="myco" />
	<input type="hidden" name="zip" value="<?php echo $zip; ?>" id="myzip" />
				 
				
				<div class="row mt-3 mr-0" id="addressbox">
				
					<div class="col-md-10 col-xs-8">
					
					<input type="text" 
                    placeholder="<?php echo __("Enter country, city or zipcode.","premiumpress"); ?>" 
                    onChange="getAddressLocation(this.value);" 
                    name="myaddress" id="myaddress"
                    class="form-control" 
                    tabindex="14" style="font-size:14px;"
                    value="<?php echo $address; ?>">
					
					</div>
					
					<div class="col-md-2 col-xs-4">
					
					<button type="button" class="btn btn-primary"><?php echo __("GO","premiumpress");  ?></button>
					
					</div>
				
				</div>
				
				<div class="clearfix"></div>		 
				
				<div id="savemylocationbox" style="display:none">
				
				<div style="border-top:1px solid #ddd; padding-top:10px; padding-bottom:10px; margin-top:10px; margin-left:-15px; margin-right:-15px;"></div>
				
				<button class="btn btn-primary btn-block col-md-12" id="updatelocation"><?php echo __("Update","premiumpress");  ?></button>
				
				</div>
				
		</form>
            
         </div>
      </div>
   </div>
</div>
 

<?php } ?>